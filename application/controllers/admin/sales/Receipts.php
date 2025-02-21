<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Receipts extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('admin/receipt_model', 'receipt');
		$this->load->model('admin/supplier_model', 'supplier');
		$this->load->model('admin/client_model', 'client');
		$this->load->model('admin/staff_model', 'staff');
		$this->load->model('admin/setting_model', 'setting');
		$this->load->library('datatables');
	}




	public function json_all() {
        enforce_permission('receipts-view');

		$this->datatables
			->select('app_receipts.id, app_receipts.currency_id, app_receipts.date, app_receipts.amount, app_receipts.reference, app_receipts.status')

			->from('app_receipts')

			->join('app_paymentmethods', 'app_receipts.paymentmethod_id = app_paymentmethods.id', 'LEFT')
			->select('app_paymentmethods.name as paymentmethod_name')

			->join('app_clients', 'app_receipts.client_id = app_clients.id', 'LEFT')
			->select('app_clients.name as client_name')


			->edit_column_if('status', '<span class="label label-inverse-danger">'.__("Canceled").'</span>', '', 'Canceled')
			->edit_column_if('status', '<span class="label label-inverse-success">'.__("Valid").'</span>', '', 'Valid')


			->add_column(
				'actions',
				'<div class="btn-group" role="group">'.

                    '<a href="'.base_url('admin/sales/receipts/pdf/view/').'$1" target="_blank" data-toggle="tooltip" title="'.__("View Receipt").'" type="button" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-file-pdf"></i></a>'.

					'<button data-modal="admin/sales/receipts/edit/$1" data-toggle="tooltip" title="'.__("Edit Receipt").'" type="button" class="btn btn-success btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-edit"></i></button>'.
					'<button data-modal="admin/sales/receipts/delete/$1" data-toggle="tooltip" title="'.__("Delete Receipt").'" type="button" class="btn btn-danger btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-trash"></i></button>'.
				'</div>',
				'id'
			);

			$results = $this->datatables->generate('json');
			$results = json_decode($results, TRUE);

			foreach($results['data'] as $key => $value) {
				$results['data'][$key]['date'] = date_display($value['date']);

				$results['data'][$key]['amount'] = format_currency($value['amount'], $value['currency_id']);
			}

			echo json_encode($results);

	}


	public function index()
	{
        enforce_permission('receipts-view');

		$data['title'] = __("Receipts");
		$data['page'] = 'admin/sales/receipts/list';

		$this->load->view('admin/layout_page', html_escape($data));
	}




	public function add()
	{
        enforce_permission('receipts-add');

		$data['currencies'] = $this->setting->get_currencies();
        $data['entities'] = $this->setting->get_entities();
		$data['paymentmethods'] = $this->setting->get_paymentmethods();

		if($this->input->method() === 'post') {



			$this->form_validation->set_rules('paymentmethod_id', __('Paymnet Method'), 'trim|required');
			$this->form_validation->set_rules('date', __('Date'), 'trim|required');
			$this->form_validation->set_rules('amount', __('Amount'), 'trim|required');
			$this->form_validation->set_rules('client_id', __('Client'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {



				$reference = $this->input->post('reference');

				if($this->input->post('receipt') == "1") {
					$reference = next_document_number('receipt', $this->input->post('entity_id'));
				}


				if($this->input->post('auto_tag') == "1") {
					$tag_invoices = $this->db->order_by('date', 'ASC')->get_where('app_invoices', array('client_id' => $this->input->post('client_id'), 'status' => 'Valid', 'entity_id' => $this->input->post('entity_id'), 'unpaid !=' => 0))->result_array();

					$_POST['tagged_invoices'] = [];

					foreach($tag_invoices as $tag_invoice) {
						array_push($_POST['tagged_invoices'], $tag_invoice['id']);
					}
				}

				$db_data = array(
                    'paymentmethod_id' => $this->input->post('paymentmethod_id'),
					'entity_id' => $this->input->post('entity_id'),
					'currency_id' => $this->input->post('currency_id'),
                    'client_id' => $this->input->post('client_id'),
                    'invoice_id' => 0,
                    'tagged_invoices' => serialize($_POST['tagged_invoices']),
                    'status' => 'Valid',
                    'amount' => $this->input->post('amount'),
                    'rate' => $this->input->post('rate'),
					'date' => date_to_db($this->input->post('date')),
					'reference' => $reference,
					'description' => $this->input->post('description'),

					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);



				$db_data = $this->security->xss_clean($db_data);
				$result = $this->receipt->add($db_data);


				// start invoice distribution
				$amount_to_distribute = $this->input->post('amount');
				$representing = "";


				$actually_tagged = [];

				foreach ($_POST['tagged_invoices'] as $invoice_id) {
					$invoice = $this->db->get_where('app_invoices', array('id' => $invoice_id))->row_array();

					if($amount_to_distribute == 0) {
						continue;
					}



					if($amount_to_distribute == $invoice['unpaid']) {
						$invoice_update['unpaid'] = 0;
						$invoice_update['paid'] = $invoice['total'];
						$amount_to_distribute = 0;
					} else if($amount_to_distribute > $invoice['unpaid']) {
						$invoice_update['unpaid'] = 0;
						$invoice_update['paid'] = $invoice['total'];
						$amount_to_distribute = $amount_to_distribute - $invoice['unpaid'];
					} else if($amount_to_distribute < $invoice['unpaid']) {
						$invoice_update['unpaid'] = $invoice['unpaid'] - $amount_to_distribute;
						$invoice_update['paid'] = $invoice['paid'] + $amount_to_distribute;
						$amount_to_distribute = 0;
					}


					$representing .= $invoice['number'] . " ";
					array_push($actually_tagged, $invoice['id']);

					$this->db->where('id', $invoice_id);
					$this->db->update('app_invoices', $invoice_update);
				}
				// end invoice distribution

				$this->db->where('id', $result);
				$this->db->update('app_receipts', ['tagged_invoices' => serialize($actually_tagged)]);



				if($result) {
					if($this->input->post('receipt') == "1") { increase_document_number('receipt', $this->input->post('entity_id')); }

                    log_staff('Receipt added ' . $result);

					$this->session->set_flashdata('toast-success', __("Transaction has been successfully added."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to add transaction."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$data['title'] = __("Add Receipt");
			$data['modal'] = 'admin/sales/receipts/add';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}


	public function edit($id=0)
	{
        enforce_permission('receipts-edit');

		$data['receipt'] = $this->receipt->get($id);
		$data['client'] = $this->client->get($data['receipt']['client_id']);

		$data['currencies'] = $this->setting->get_currencies();
        $data['entities'] = $this->setting->get_entities();
        $data['paymentmethods'] = $this->setting->get_paymentmethods();





		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('date', __('Date'), 'trim|required');
			$this->form_validation->set_rules('amount', __('Amount'), 'trim|required');

			$this->form_validation->set_rules('client_id', __('Client'), 'trim|required');


			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {


				// start invoice undistribution
				if($data['receipt']['tagged_invoices'] != "") {
					$tagged_invoices = unserialize($data['receipt']['tagged_invoices']);
					$amount_to_undistribute = $data['receipt']['amount'];

					foreach ($tagged_invoices as $invoice_id) {

						$invoice = $this->db->get_where('app_invoices', array('id' => $invoice_id))->row_array();

						if($amount_to_undistribute == $invoice['unpaid']) {
							$invoice_update['unpaid'] = $invoice['total'];
							$invoice_update['paid'] = 0;
							$amount_to_undistribute = 0;
						} else if($amount_to_undistribute > $invoice['unpaid']) {
							$invoice_update['unpaid'] = $invoice['total'];
							$invoice_update['paid'] = 0;
							$amount_to_undistribute = $amount_to_undistribute - $invoice['unpaid'];
						} else if($amount_to_undistribute < $invoice['unpaid']) {
							$invoice_update['unpaid'] = $invoice['unpaid'] + $amount_to_undistribute;
							$invoice_update['paid'] = $invoice['paid'] - $amount_to_undistribute;
							$amount_to_undistribute = 0;
						}

						$this->db->where('id', $invoice_id);
						$this->db->update('app_invoices', $invoice_update);



					}

				}
				// end invoice undistribution


				// start invoice distribution
				if(!empty($_POST['tagged_invoices'])) {
					$amount_to_distribute = $this->input->post('amount');

					foreach ($_POST['tagged_invoices'] as $invoice_id) {

						$invoice = $this->db->get_where('app_invoices', array('id' => $invoice_id))->row_array();

						if($amount_to_distribute == $invoice['unpaid']) {
							$invoice_update['unpaid'] = 0;
							$invoice_update['paid'] = $invoice['total'];
							$amount_to_distribute = 0;
						} else if($amount_to_distribute > $invoice['unpaid']) {
							$invoice_update['unpaid'] = 0;
							$invoice_update['paid'] = $invoice['total'];
							$amount_to_distribute = $amount_to_distribute - $invoice['unpaid'];
						} else if($amount_to_distribute < $invoice['unpaid']) {
							$invoice_update['unpaid'] = $invoice['unpaid'] - $amount_to_distribute;
							$invoice_update['paid'] = $invoice['paid'] + $amount_to_distribute;
							$amount_to_distribute = 0;
						}

						$this->db->where('id', $invoice_id);
						$this->db->update('app_invoices', $invoice_update);


					}


				}
				// end invoice distribution

				if(!isset($_POST['representing'])) {
					$_POST['representing'] = "";
				}



				$db_data = array(

                    'paymentmethod_id' => $this->input->post('paymentmethod_id'),
                    'entity_id' => $this->input->post('entity_id'),
                    'currency_id' => $this->input->post('currency_id'),
                    'client_id' => $this->input->post('client_id'),

                    'tagged_invoices' => serialize($_POST['tagged_invoices']),
                    'status' => $this->input->post('status'),
                    'amount' => $this->input->post('amount'),
                    'rate' => $this->input->post('rate'),
                    'date' => date_to_db($this->input->post('date')),
                    'reference' => $this->input->post('reference'),
                    'description' => $this->input->post('description'),

					'updated_at' => date('Y-m-d H:i:s'),
				);



				$db_data = $this->security->xss_clean($db_data);
				$result = $this->receipt->edit($db_data, $id);

				if($result) {
                    log_staff('Receipt edited ' . $id);

					$this->session->set_flashdata('toast-success', __("Transaction has been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to update transaction."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$data['title'] = __("Edit Receipt");

			$data['modal'] = 'admin/sales/receipts/edit';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}



	public function delete($id=0)
	{
        enforce_permission('receipts-delete');

		$data['receipt'] = $this->receipt->get($id);

		if($this->input->method() === 'post') {

			// start invoice undistribution
			if($data['receipt']['tagged_invoices'] != "") {
				$tagged_invoices = unserialize($data['receipt']['tagged_invoices']);
				$amount_to_undistribute = $data['receipt']['amount'];

				foreach ($tagged_invoices as $invoice_id) {

						$invoice = $this->db->get_where('app_invoices', array('id' => $invoice_id))->row_array();

						if($amount_to_undistribute == $invoice['unpaid']) {
							$invoice_update['unpaid'] = $invoice['total'];
							$invoice_update['paid'] = 0;
							$amount_to_undistribute = 0;
						} else if($amount_to_undistribute > $invoice['unpaid']) {
							$invoice_update['unpaid'] = $invoice['total'];
							$invoice_update['paid'] = 0;
							$amount_to_undistribute = $amount_to_undistribute - $invoice['unpaid'];
						} else if($amount_to_undistribute < $invoice['unpaid']) {
							$invoice_update['unpaid'] = $invoice['unpaid'] + $amount_to_undistribute;
							$invoice_update['paid'] = $invoice['paid'] - $amount_to_undistribute;
							$amount_to_undistribute = 0;
						}

						$this->db->where('id', $invoice_id);
						$this->db->update('app_invoices', $invoice_update);



				}

			}
			// end invoice undistribution

			$result = $this->receipt->delete($id);

			if($result) {
                log_staff('Receipt deleted ' . $id);

				$this->session->set_flashdata('toast-success', __("Receipt has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete receipt."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			$data['title'] = __("Delete Receipt");
			$data['modal'] = 'admin/sales/receipts/delete';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}



    public function pdf($method='',$ids_string='')
    {
        enforce_permission('receipts-view');
        
        if($method == "") {
            $method =  $this->uri->segment(5);
        }

        if($ids_string == "") {
            $ids_string =  $this->uri->segment(6);
        }

        $this->receipt->pdf($method, $ids_string);


    }







}
