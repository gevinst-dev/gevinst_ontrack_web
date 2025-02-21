<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proposals extends Admin_Controller {


    public function __construct()
	{
		parent::__construct();

		$this->load->model('admin/proposal_model', 'proposal');
		$this->load->model('admin/staff_model', 'staff');
        $this->load->model('admin/client_model', 'client');
        $this->load->model('admin/setting_model', 'setting');
        $this->load->model('admin/item_model', 'item');
		$this->load->library('datatables');



        if(!isset($_SESSION['data_filter_start']))
            $this->session->set_userdata('data_filter_start', date('Y-m-d', strtotime('first day of january this year')));

        if(!isset($_SESSION['data_filter_end']))
            $this->session->set_userdata('data_filter_end', date('Y-m-d', strtotime('last day of this month')));


        if(!isset($_SESSION['global_filter_entity']))
            $this->session->set_userdata('global_filter_entity', '');
	}


    public function set_filters() {

		if($this->input->method() === 'post') {

			if(isset($_POST['data_filter_start']))
				if($_POST['data_filter_start'] != "") $this->session->set_userdata('data_filter_start', date_to_db($this->input->post('data_filter_start'))); else $this->session->set_userdata('data_filter_start', '');

			if(isset($_POST['data_filter_end']))
				if($_POST['data_filter_end'] != "") $this->session->set_userdata('data_filter_end', date_to_db($this->input->post('data_filter_end'))); else $this->session->set_userdata('data_filter_end', '');


            if(isset($_POST['global_filter_entity']))
				$this->session->set_userdata('global_filter_entity', $this->input->post('global_filter_entity'));


			redirect($_SERVER['HTTP_REFERER']);

		} else {
			die("Invalid action!");
		}
	}



    public function json_all() {
        enforce_permission('proposals-view');

        $where = [];

        if($_SESSION['data_filter_start'] != "") $where['date >='] = $_SESSION['data_filter_start'];
        if($_SESSION['data_filter_end'] != "") $where['date <='] = $_SESSION['data_filter_end'];
        if($_SESSION['global_filter_entity'] != "") $where['entity_id'] = $_SESSION['global_filter_entity'];

		$this->datatables
			->select('app_proposals.id, app_proposals.currency_id, app_proposals.number, app_proposals.date, app_proposals.valid_until, app_proposals.total, app_proposals.status')
			->from('app_proposals')
            ->where($where)

			->join('app_clients', 'app_proposals.client_id = app_clients.id', 'LEFT')
			->select('app_clients.name as client_name')

            ->join('app_entities', 'app_proposals.entity_id = app_entities.id', 'LEFT')
			->select('app_entities.title as entity_name')

			->edit_column_if('status', '<span class="label label-inverse-danger">'.__("Draft").'</span>', '', 'Draft')
            ->edit_column_if('status', '<span class="label label-inverse-primary">'.__("Sent").'</span>', '', 'Sent')
			->edit_column_if('status', '<span class="label label-inverse-success">'.__("Accepted").'</span>', '', 'Accepted')
            ->edit_column_if('status', '<span class="label label-inverse-info-border">'.__("Canceled").'</span>', '', 'Canceled')

            ->add_column(
				'actions',
				'<div class="btn-group" role="group">'.

                    '<button data-modal="admin/sales/proposals/view/$1" data-toggle="tooltip" title="'.__("View Proposal").'" type="button" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-eye"></i></button>'.
					'<a href="'.base_url('admin/sales/proposals/edit/').'$1" data-toggle="tooltip" title="'.__("Edit Proposal").'" type="button" class="btn btn-success btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-edit"></i></a>'.



                    '<div class="dropdown">'.
                        '<a class="btn btn-inverse btn-mini" title="'.__("More actions").'" href="#" id="dropdown-$1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-fw fa-ellipsis-v"></i> </a>'.

                        '<div class="dropdown-menu">'.
                            '<a href="'.base_url('admin/sales/proposals/pdf/view/').'$1" target="_blank" class="dropdown-item"><i class="fas fa-fw fa-file-pdf"></i> '.__("View PDF").'</a>'.
                            '<a href="'.base_url('admin/sales/proposals/pdf/download/').'$1"  class="dropdown-item"><i class="fas fa-fw fa-file-pdf"></i> '.__("Download PDF").'</a>'.

                            '<a href="#" data-modal="admin/sales/proposals/send_email/$1" class="dropdown-item"><i class="fas fa-fw fa-envelope"></i> '.__("Send Email").'</a>'.


                            '<div class="dropdown-divider"></div>'.

                            '<a data-modal="admin/sales/proposals/generate_proforma/$1" href="#"  class="dropdown-item"><i class="fas fa-fw fa-file-invoice"></i> '.__("Generate Proforma").'</a>'.
                            '<a data-modal="admin/sales/proposals/generate_invoice/$1" href="#"  class="dropdown-item"><i class="fas fa-fw fa-file-invoice-dollar"></i> '.__("Generate Invoice").'</a>'.

                            '<div class="dropdown-divider"></div>'.

                            '<a data-modal="admin/sales/proposals/duplicate/$1" href="#"  class="dropdown-item"><i class="fas fa-fw fa-clone"></i> '.__("Duplicate").'</a>'.
                            '<a data-modal="admin/sales/proposals/delete/$1" href="#"  class="dropdown-item"><i class="fas fa-fw fa-trash"></i> '.__("Delete").'</a>'.
                        '</div>'.

                    '</div>'.


                '</div>',
				'id'
			);



        $results = $this->datatables->generate('json');
        $results = json_decode($results, TRUE);

        foreach($results['data'] as $key => $value) {

            $results['data'][$key]['date'] = date_display($value['date']);
            $results['data'][$key]['valid_until'] = date_display($value['valid_until']);


            $results['data'][$key]['total'] = format_currency($value['total'], $value['currency_id']);
        }

        echo json_encode($results);

	}



    public function index()
	{
        enforce_permission('proposals-view');

		$data['title'] = __("Proposals");
		$data['page'] = 'admin/sales/proposals/list';


        $data['entities'] = $this->db->get('app_entities')->result_array();

		$this->load->view('admin/layout_page', html_escape($data));
	}



    public function select_currency()
	{
        enforce_permission('proposals-add');

        $data['currencies'] = $this->setting->get_currencies();

		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('currency_id', __('Currency'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {
                redirect(base_url('admin/sales/proposals/add/'.$this->input->post('currency_id')));
			}

		} else {
			$data['title'] = __("Select Proposal Currency");
			$data['modal'] = 'admin/sales/proposals/select_currency';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}




    public function add($id=0)
	{
        enforce_permission('proposals-add');

        if($id == 0 || $id > 4) {
            $data['currency'] = $this->setting->get_currency(get_setting('default_currency'));

            $data['client'] = $this->client->get($id);

            $id = get_setting('default_currency');
        } else {
            $data['currency'] = $this->setting->get_currency($id);



        }



        $data['clients'] = $this->client->get_all();
        $data['taxrates'] = $this->setting->get_taxrates();
        $data['entities'] = $this->setting->get_entities();
        $data['languages'] = $this->setting->get_languages();
        $data['items'] = $this->item->get_all();
        $data['staff'] = $this->staff->get_all();

		if($this->input->method() === 'post') {



			$this->form_validation->set_rules('client_id', __('Client'), 'trim|required');
            $this->form_validation->set_rules('date', __('Date'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {
                $data['client'] = $this->client->get($this->input->post('client_id'));

				$db_data = array(
                    'language_id' => $this->input->post('language_id'),
                    'entity_id' => $this->input->post('entity_id'),
					'client_id' => $this->input->post('client_id'),
					'added_by' => $this->input->post('added_by'),
					'currency_id' => $id,
                    'rate' => $this->input->post('rate'),
                    'number' => next_document_number("proposal", $this->input->post('entity_id')),
                    'date' => date_to_db($this->input->post('date')),
                    'valid_until' => date_to_db($this->input->post('valid_until')),
                    'value' => $this->input->post('value'),
                    'tax' => $this->input->post('tax'),
                    'total' => $this->input->post('total'),
                    'status' => "Draft",
                    'offer_text' => $this->input->post('offer_text'),
                    'notes' => $this->input->post('notes'),
                    'client_data' => serialize($data['client']),
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
                $items = $this->security->xss_clean($this->input->post('items'));
				$result = $this->proposal->add($db_data, $items);

				if($result) {
                    log_staff('Proposal added ' . $result);

					$this->session->set_flashdata('toast-success', __("Proposal has been successfully added."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to add proposal."));
				}

				redirect(base_url('admin/sales/proposals'));

			}

		} else {
			$data['title'] = __("Add Proposal");
            $data['page'] = 'admin/sales/proposals/add';

    		$this->load->view('admin/layout_page', html_escape($data));
		}

	}



    public function edit($id=0)
	{

        enforce_permission('proposals-edit');
        $data['proposal'] = $this->proposal->get($id);
        $data['proposal_items'] = $this->proposal->get_items($id);
        $data['currency'] = $this->setting->get_currency($data['proposal']['currency_id']);


        $data['client'] = $this->client->get($data['proposal']['client_id']);
        $data['taxrates'] = $this->setting->get_taxrates();
        $data['entities'] = $this->setting->get_entities();
        $data['languages'] = $this->setting->get_languages();
        $data['staff'] = $this->staff->get_all();

		if($this->input->method() === 'post') {

			$this->form_validation->set_rules('client_id', __('Client'), 'trim|required');
            $this->form_validation->set_rules('date', __('Date'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {
                $data['client'] = $this->client->get($this->input->post('client_id'));

				$db_data = array(
                    'language_id' => $this->input->post('language_id'),
                    'entity_id' => $this->input->post('entity_id'),
					'client_id' => $this->input->post('client_id'),
                    'added_by' => $this->input->post('added_by'),
                    'rate' => $this->input->post('rate'),
                    'number' => $this->input->post('number'),

                    'date' => date_to_db($this->input->post('date')),
                    'valid_until' => date_to_db($this->input->post('valid_until')),
                    'value' => $this->input->post('value'),
                    'tax' => $this->input->post('tax'),
                    'total' => $this->input->post('total'),
                    'status' => $this->input->post('status'),
                    'offer_text' => $this->input->post('offer_text'),
                    'notes' => $this->input->post('notes'),
                    'client_data' => serialize($data['client']),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
                $items = $this->security->xss_clean($this->input->post('items'));
				$result = $this->proposal->edit($db_data, $items, $id);

				if($result) {
                    log_staff('Proposal edited ' . $id);

					$this->session->set_flashdata('toast-success', __("Proposal has been successfully edit."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to edit proposal."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$data['title'] = __("Edit Proposal");
            $data['page'] = 'admin/sales/proposals/edit';

    		$this->load->view('admin/layout_page', html_escape($data));
		}

	}



    public function delete($id=0)
	{
        enforce_permission('proposals-delete');

        $data['proposal'] = $this->proposal->get($id);
        $data['proposal_items'] = $this->proposal->get_items($id);
        $data['currency'] = $this->setting->get_currency($data['proposal']['currency_id']);

		if($this->input->method() === 'post') {

			$result = $this->proposal->delete($id);

			if($result) {
                log_staff('Proposal deleted ' . $id);

				$this->session->set_flashdata('toast-success', __("Proposal has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete proposal."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			$data['title'] = __("Delete Proposal");
			$data['modal'] = 'admin/sales/proposals/delete';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}



    public function duplicate($id=0)
	{
        enforce_permission('proposals-add');

        $data['proposal'] = $this->proposal->get($id);
        $data['proposal_items'] = $this->proposal->get_items($id);
        $data['currency'] = $this->setting->get_currency($data['proposal']['currency_id']);

		if($this->input->method() === 'post') {

            $client = $this->client->get($data['proposal']['client_id']);

            $order_data = array(
                'language_id' => $data['proposal']['language_id'],
                'entity_id' => $data['proposal']['entity_id'],
                'client_id' => $data['proposal']['client_id'],
                'added_by' => $data['proposal']['added_by'],
                'currency_id' => $data['proposal']['currency_id'],
                'converted' => "0",
                'rate' => $data['proposal']['rate'],
                'number' => next_document_number("proposal", $data['proposal']['entity_id']),
                'date' => date('Y-m-d'),
                'valid_until' => "",
                'value' => $data['proposal']['value'],
                'tax' => $data['proposal']['tax'],
                'total' => $data['proposal']['total'],
                'status' => $data['proposal']['status'],
                'offer_text' => $data['proposal']['offer_text'],
                'notes' => $data['proposal']['notes'],
                'client_data' => serialize($client),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            );

            $this->db->insert('app_proposals', $order_data);
            $proposal_id = $this->db->insert_id();

            foreach($data['proposal_items'] as $item) {
                $db_item = array();
                $db_item['proposal_id'] = $proposal_id;
                $db_item['item_id'] = $item['item_id'];
                $db_item['type'] = $item['type'];
                $db_item['name'] = $item['name'];
                $db_item['description'] = $item['description'];
                $db_item['qty'] = $item['qty'];
                $db_item['taxrate'] = $item['taxrate'];
                $db_item['price'] = $item['price'];
                $db_item['value'] = $item['value'];
                $db_item['tax'] = $item['tax'];
                $db_item['total'] = $item['total'];
                $this->db->insert('app_proposal_items', $db_item);
            }

            increase_document_number("proposal", $data['proposal']['entity_id']);

            $result = TRUE;


			if($result) {
                log_staff('Proposal duplicated ' . $id);

				$this->session->set_flashdata('toast-success', __("Proposal has been successfully duplicated."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to duplicate proposal."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			$data['title'] = __("Duplicate Proposal");
			$data['modal'] = 'admin/sales/proposals/duplicate';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

    public function generate_proforma($id=0)
	{
        enforce_permission('proformas-add');

        $data['proposal'] = $this->proposal->get($id);
        $data['proposal_items'] = $this->proposal->get_items($id);
        $data['currency'] = $this->setting->get_currency($data['proposal']['currency_id']);

		if($this->input->method() === 'post') {

            $client = $this->client->get($data['proposal']['client_id']);
            $this->client->edit(['type' => 'Client'], $client['id']);

            $order_data = array(
                'entity_id' => $data['proposal']['entity_id'],
                'language_id' => $data['proposal']['language_id'],
                'client_id' => $data['proposal']['client_id'],
                'proposal_id' => $data['proposal']['id'],
                'added_by' => $data['proposal']['added_by'],
                'issued_by' => $this->session->staff_id,
                'currency_id' => $data['proposal']['currency_id'],
                'rate' => $data['proposal']['rate'],
                'number' => next_document_number("proforma", $data['proposal']['entity_id']),
                'date' => date('Y-m-d'),
                'due_date' => date('Y-m-d'),
                'value' => $data['proposal']['value'],
                'tax' => $data['proposal']['tax'],
                'total' => $data['proposal']['total'],
                'unpaid' => $data['proposal']['total'],
                'status' => "Valid",
          
                'client_data' => serialize($client),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            );

            $this->db->insert('app_proformas', $order_data);
            $proforma_id = $this->db->insert_id();

            foreach($data['proposal_items'] as $item) {
                $db_item = array();
                $db_item['proforma_id'] = $proforma_id;
                $db_item['item_id'] = $item['item_id'];
                $db_item['type'] = $item['type'];
                $db_item['name'] = $item['name'];
                $db_item['description'] = $item['description'];
                $db_item['qty'] = $item['qty'];
                $db_item['taxrate'] = $item['taxrate'];
                $db_item['price'] = $item['price'];
                $db_item['value'] = $item['value'];
                $db_item['tax'] = $item['tax'];
                $db_item['total'] = $item['total'];
                $this->db->insert('app_proforma_items', $db_item);
            }

            $result = $this->proposal->mark_converted($id);

			if($result) {
                increase_document_number("proforma", $data['proposal']['entity_id']);
                log_staff('Proposal proforma generated ' . $id);

				$this->session->set_flashdata('toast-success', __("Proposal has been successfully converted to proforma."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to convert proposal."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			$data['title'] = __("Generate Proforma");
			$data['modal'] = 'admin/sales/proposals/generate_proforma';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}


    public function generate_invoice($id=0)
	{
        enforce_permission('invoices-add');

        $data['proposal'] = $this->proposal->get($id);
        $data['proposal_items'] = $this->proposal->get_items($id);
        $data['currency'] = $this->setting->get_currency($data['proposal']['currency_id']);

		if($this->input->method() === 'post') {

            $client = $this->client->get($data['proposal']['client_id']);
            $this->client->edit(['type' => 'Client'], $client['id']);

            $order_data = array(
                'entity_id' => $data['proposal']['entity_id'],
                'language_id' => $data['proposal']['language_id'],
                'client_id' => $data['proposal']['client_id'],
                'proposal_id' => $data['proposal']['id'],
                'added_by' => $data['proposal']['added_by'],
                'issued_by' => $this->session->staff_id,
                'currency_id' => $data['proposal']['currency_id'],
                'rate' => $data['proposal']['rate'],
                'number' => next_document_number("invoice", $data['proposal']['entity_id']),
                'date' => date('Y-m-d'),
                'due_date' => date('Y-m-d'),
                'value' => $data['proposal']['value'],
                'tax' => $data['proposal']['tax'],
                'total' => $data['proposal']['total'],
                'unpaid' => $data['proposal']['total'],
                'status' => "Valid",
            
                'client_data' => serialize($client),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            );

            $this->db->insert('app_invoices', $order_data);
            $invoice_id = $this->db->insert_id();

            foreach($data['proposal_items'] as $item) {
                $db_item = array();
                $db_item['invoice_id'] = $invoice_id;
                $db_item['item_id'] = $item['item_id'];
                $db_item['type'] = $item['type'];
                $db_item['name'] = $item['name'];
                $db_item['description'] = $item['description'];
                $db_item['qty'] = $item['qty'];
                $db_item['taxrate'] = $item['taxrate'];
                $db_item['price'] = $item['price'];
                $db_item['value'] = $item['value'];
                $db_item['tax'] = $item['tax'];
                $db_item['total'] = $item['total'];
                $this->db->insert('app_invoice_items', $db_item);
            }

            $result = $this->proposal->mark_converted($id);

			if($result) {
                increase_document_number("invoice", $data['proposal']['entity_id']);
                log_staff('Proposal invoice generated ' . $id);

				$this->session->set_flashdata('toast-success', __("Proposal has been successfully converted to invoice."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to convert proposal."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			$data['title'] = __("Generate Invoice");
			$data['modal'] = 'admin/sales/proposals/generate_invoice';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}





    public function view($id=0)
	{
        enforce_permission('proposals-view');

        $data['proposal'] = $this->proposal->get($id);
        $data['proposal_items'] = $this->proposal->get_items($id);
        $data['currency'] = $this->setting->get_currency($data['proposal']['currency_id']);

		$data['title'] = __("View Proposal");
		$data['modal'] = 'admin/sales/proposals/view';

		$this->load->view('admin/layout_modal', html_escape($data));


	}







    public function send_email($id=0)
    {
        enforce_permission('proposals-view');

        $data['proposal'] = $this->proposal->get($id);
        $data['proposal_items'] = $this->proposal->get_items($id);
        $proposal = $data['proposal'];

        $data['client'] = $this->client->get($data['proposal']['client_id']);
        $client = $data['client'];

        $template = $this->db->get_where('core_email_templates', array('name' => 'Client | New Proposal'))->row_array();
        $data['subject'] = $template['subject'];
        $data['body'] = $template['body'];

        $search = array('{name}', '{email}', '{client_name}', '{proposal_no}', '{proposal_total}', '{due_date}');
        $replace = array($client['name'], $client['email'], $client['name'], $proposal['number'], format_currency($proposal['total'], $proposal['currency_id']), date_display($proposal['valid_until']));

        $data['subject'] = str_replace($search, $replace, $data['subject']);
        $data['body'] = str_replace($search, $replace, $data['body']);


        if($this->input->method() === 'post') {


            $email_data = [
                'client_id' => $data['client']['id'],
                'proposal_id' => $data['proposal']['id'],
                'email_address' => $this->input->post('email'),
                'subject' => $this->input->post('subject'),
                'body' => $this->input->post('body'),
            ];
            $this->mailer->send('Client | New Proposal', $email_data);


            $result = true;

            if($result) {
                log_staff('Proposal email sent ' . $id);

                $this->session->set_flashdata('toast-success', __("Email has been successfully sent."));
            } else {
                $this->session->set_flashdata('toast-error', __("Unable to send email."));
            }

            redirect($_SERVER['HTTP_REFERER']);

        } else {
            $data['title'] = __("Send Email");
            $data['modal'] = 'admin/sales/proposals/send_email';

            $this->load->view('admin/layout_modal', html_escape($data));
        }

    }







    public function pdf($method='',$ids_string='')
    {
        enforce_permission('proposals-view');
        
        if($method == "") {
            $method =  $this->uri->segment(5);
        }

        if($ids_string == "") {
            $ids_string =  $this->uri->segment(6);
        }

        $this->proposal->pdf($method, $ids_string);


    }


}
