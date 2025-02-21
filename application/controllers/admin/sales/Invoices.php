<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoices extends Admin_Controller {


    public function __construct()
	{
		parent::__construct();

		$this->load->model('admin/invoice_model', 'invoice');
		$this->load->model('admin/staff_model', 'staff');
        $this->load->model('admin/client_model', 'client');
        $this->load->model('admin/setting_model', 'setting');
        $this->load->model('admin/item_model', 'item');
		$this->load->library('datatables');

        if(!isset($_SESSION['data_filter_start']))
            $this->session->set_userdata('data_filter_start', date('Y-m-d', strtotime('first day of january this year')));

        if(!isset($_SESSION['data_filter_end']))
            $this->session->set_userdata('data_filter_end', date('Y-m-d', strtotime('last day of this month')));

        if(!isset($_SESSION['data_filter_agent_id']))
            $this->session->set_userdata('data_filter_agent_id', '0');


        if(!isset($_SESSION['global_filter_entity']))
            $this->session->set_userdata('global_filter_entity', '');

	}


    public function set_filters() {

		if($this->input->method() === 'post') {

			if(isset($_POST['data_filter_start']))
				if($_POST['data_filter_start'] != "") $this->session->set_userdata('data_filter_start', date_to_db($this->input->post('data_filter_start'))); else $this->session->set_userdata('data_filter_start', '');

			if(isset($_POST['data_filter_end']))
				if($_POST['data_filter_end'] != "") $this->session->set_userdata('data_filter_end', date_to_db($this->input->post('data_filter_end'))); else $this->session->set_userdata('data_filter_end', '');

			if(isset($_POST['data_filter_agent_id']))
				$this->session->set_userdata('data_filter_agent_id', $this->input->post('data_filter_agent_id'));

            if(isset($_POST['global_filter_entity']))
				$this->session->set_userdata('global_filter_entity', $this->input->post('global_filter_entity'));


			redirect($_SERVER['HTTP_REFERER']);

		} else {
			die("Invalid action!");
		}
	}


    public function json_all() {
        enforce_permission('invoices-view');

        $where = [];

        if($_SESSION['data_filter_start'] != "") $where['date >='] = $_SESSION['data_filter_start'];
        if($_SESSION['data_filter_end'] != "") $where['date <='] = $_SESSION['data_filter_end'];

        if($_SESSION['data_filter_agent_id'] != "") {
            if($_SESSION['data_filter_agent_id'] != "0") {
                $where['app_invoices.added_by'] = $_SESSION['data_filter_agent_id'];
            }
        }

        if($_SESSION['global_filter_entity'] != "") $where['entity_id'] = $_SESSION['global_filter_entity'];


		$this->datatables
			->select('app_invoices.id, app_invoices.currency_id, app_invoices.number, app_invoices.date, app_invoices.due_date, app_invoices.value, app_invoices.tax, app_invoices.total, app_invoices.unpaid, app_invoices.status')
			->from('app_invoices')
            ->where($where)
			->join('app_clients', 'app_invoices.client_id = app_clients.id', 'LEFT')
			->select('app_clients.name as client_name')

            ->join('core_staff', 'app_invoices.added_by = core_staff.id', 'LEFT')
            ->select('core_staff.name as agent_name')

            ->join('app_entities', 'app_invoices.entity_id = app_entities.id', 'LEFT')
			->select('app_entities.title as entity_name')


			->edit_column_if('status', '<span class="label label-inverse-danger">'.__("Canceled").'</span>', '', 'Canceled')
			->edit_column_if('status', '<span class="label label-inverse-success">'.__("Valid").'</span>', '', 'Valid')
            ->edit_column_if('status', '<span class="label label-inverse-primary">'.__("Draft").'</span>', '', 'Draft')

            ->add_column(
				'actions',
				'<div class="btn-group" role="group">'.
                    '<button data-modal="admin/sales/invoices/view/$1" data-toggle="tooltip" title="'.__("View Invoice").'" type="button" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-eye"></i></button>'.



                    '<a href="'.base_url('admin/sales/invoices/edit/').'$1" data-toggle="tooltip" title="'.__("Edit Invoice").'" type="button" class="btn btn-success btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-edit"></i></a>'.

                    '<div class="dropdown">'.
                        '<a class="btn btn-inverse btn-mini" title="'.__("More actions").'" href="#" id="dropdown-$1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-fw fa-ellipsis-v"></i> </a>'.

                        '<div class="dropdown-menu">'.



                            '<a data-modal="admin/sales/invoices/manage_payment/$1" href="#"  class="dropdown-item"><i class="fas fa-fw fa-coins"></i> '.__("Manage Payment").'</a>'.

                            '<div class="dropdown-divider"></div>'.
                            '<a href="#" data-modal="admin/sales/invoices/send_email/$1" class="dropdown-item"><i class="fas fa-fw fa-envelope"></i> '.__("Send Email").'</a>'.
                            '<a href="#" data-modal="admin/sales/proforinvoicesmas/send_reminder/$1" class="dropdown-item"><i class="fas fa-fw fa-bell"></i> '.__("Send Reminder").'</a>'.
                            '<div class="dropdown-divider"></div>'.


                            '<a data-modal="admin/sales/invoices/duplicate/$1" href="#"  class="dropdown-item"><i class="fas fa-fw fa-clone"></i> '.__("Duplicate").'</a>'.

                            '<a data-modal="admin/sales/invoices/generate_storno/$1" href="#"  class="dropdown-item"><i class="fas fa-fw fa-minus"></i> '.__("Generate Storno").'</a>'.

                            '<a data-modal="admin/sales/invoices/delete/$1" href="#"  class="dropdown-item"><i class="fas fa-fw fa-trash"></i> '.__("Delete Invoice").'</a>'.



                        '</div>'.

                    '</div>'.






                '</div>',
				'id'
			);



        $results = $this->datatables->generate('json');
        $results = json_decode($results, TRUE);

        foreach($results['data'] as $key => $value) {

            $results['data'][$key]['date'] = date_display($value['date']);
            $results['data'][$key]['due_date'] = date_display($value['due_date']);




            $results['data'][$key]['value'] = format_currency($value['value'], $value['currency_id']);
            $results['data'][$key]['tax'] = format_currency(round($value['tax'],2), $value['currency_id']);
            $results['data'][$key]['total'] = format_currency($value['total'], $value['currency_id']);

            if($value['unpaid'] > 0) {
                $results['data'][$key]['unpaid'] = '<span class="text-danger">' . format_currency($value['unpaid'], $value['currency_id']) . '</span>';
            } else {
                $results['data'][$key]['unpaid'] = format_currency($value['unpaid'], $value['currency_id']);
            }



        }

        echo json_encode($results);

	}



    public function bulk_operations() {

        enforce_permission('invoices-edit');

        if($this->input->method() === 'post') {


            $action = $this->input->post('action');
            $items = $this->input->post('item');

            if(!empty($items)) {

                if($action == "bulk_print") {

                    $to_print = [];
                    foreach($items as $item) {
                        array_push($to_print, $item);
                    }

                    redirect(base_url('admin/sales/invoices/pdf/view/' . implode('-', $to_print)));

                }


            }


        }



  

        redirect($_SERVER['HTTP_REFERER']);
    }

    public function index()
	{
        enforce_permission('invoices-view');

		$data['title'] = __("Invoices");
		$data['page'] = 'admin/sales/invoices/list';


        $data['agents'] = $this->db->get('core_staff')->result_array();
        $data['entities'] = $this->db->get('app_entities')->result_array();

		$this->load->view('admin/layout_page', html_escape($data));
	}



    public function select_currency()
	{
        enforce_permission('invoices-add');

        $data['currencies'] = $this->setting->get_currencies();

		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('currency_id', __('Currency'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {
                redirect(base_url('admin/sales/invoices/add/'.$this->input->post('currency_id')));
			}

		} else {
			$data['title'] = __("Select Invoice Currency");
			$data['modal'] = 'admin/sales/invoices/select_currency';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}




    public function add($id=0)
	{
        enforce_permission('invoices-add');

        if($id == 0) {
            $data['currency'] = $this->setting->get_currency(get_setting('default_currency'));
        } else {
            $data['currency'] = $this->setting->get_currency($id);
        }


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
                    'entity_id' => $this->input->post('entity_id'),
                    'language_id' => $this->input->post('language_id'),
					'client_id' => $this->input->post('client_id'),
					'added_by' => $this->input->post('added_by'),
                    'issued_by' => $this->session->staff_id,
					'currency_id' => $id,
                    'rate' => $this->input->post('rate'),
                    'number' => next_document_number('invoice', $this->input->post('entity_id')),
                    'date' => date_to_db($this->input->post('date')),
                    'due_date' => date_to_db($this->input->post('due_date')),
                    'value' => $this->input->post('value'),
                    'tax' => $this->input->post('tax'),
                    'total' => $this->input->post('total'),
                    'unpaid' => $this->input->post('total'),
                    'status' => $this->input->post('status'),

                    'public_notes' => $this->input->post('public_notes'),
                    'private_notes' => $this->input->post('private_notes'),
                    'client_data' => serialize($data['client']),
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
                $items = $this->security->xss_clean($this->input->post('items'));


                $result = $this->invoice->add($db_data, $items);





				if($result) {
                    log_staff('Invoice added ' . $result);

					$this->session->set_flashdata('toast-success', __("Invoice has been successfully added."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to add invoice."));
				}

				redirect(base_url('admin/sales/invoices'));

			}

		} else {
			$data['title'] = __("Add Invoice");
            $data['page'] = 'admin/sales/invoices/add';

    		$this->load->view('admin/layout_page', html_escape($data));
		}

	}



    public function edit($id=0)
	{
        enforce_permission('invoices-edit');

        $data['invoice'] = $this->invoice->get($id);
        $data['invoice_items'] = $this->invoice->get_items($id);
        $data['currency'] = $this->setting->get_currency($data['invoice']['currency_id']);
        $data['client'] = $this->client->get($data['invoice']['client_id']);

        $data['staff'] = $this->staff->get_all();
        $data['languages'] = $this->setting->get_languages();
        $data['taxrates'] = $this->setting->get_taxrates();
        $data['entities'] = $this->setting->get_entities();


		if($this->input->method() === 'post') {

			$this->form_validation->set_rules('client_id', __('Client'), 'trim|required');
            $this->form_validation->set_rules('date', __('Date'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {
                $data['client'] = $this->client->get($this->input->post('client_id'));

				$db_data = array(
                    'entity_id' => $this->input->post('entity_id'),
                    'language_id' => $this->input->post('language_id'),
					'client_id' => $this->input->post('client_id'),
                    'added_by' => $this->input->post('added_by'),
                    'rate' => $this->input->post('rate'),
                    'number' => $this->input->post('number'),
                    'date' => date_to_db($this->input->post('date')),
                    'due_date' => date_to_db($this->input->post('due_date')),
                    'value' => $this->input->post('value'),
                    'tax' => $this->input->post('tax'),
                    'total' => $this->input->post('total'),



                    'status' => $this->input->post('status'),

                    'public_notes' => $this->input->post('public_notes'),
                    'private_notes' => $this->input->post('private_notes'),
                    'client_data' => serialize($data['client']),
					'updated_at' => date('Y-m-d H:i:s'),
				);

                if($data['invoice']['paid'] > 0) {
                    $db_data['unpaid'] = $this->input->post('total') - $data['invoice']['paid'];
                } else {
                    $db_data['unpaid'] = $this->input->post('total');
                }

                if($this->input->post('total') <= 0){
                    $db_data['unpaid'] = 0;
                    $db_data['paid'] = 0;
                }

				$db_data = $this->security->xss_clean($db_data);
                $items = $this->security->xss_clean($this->input->post('items'));
				$result = $this->invoice->edit($db_data, $items, $id);

				if($result) {
                    log_staff('Invoice edited ' . $id);

					$this->session->set_flashdata('toast-success', __("Invoice has been successfully edit."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to edit invoice."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$data['title'] = __("Edit Invoice");
            $data['page'] = 'admin/sales/invoices/edit';

    		$this->load->view('admin/layout_page', html_escape($data));
		}

	}


    public function manage_payment($id=0)
	{
        enforce_permission('invoices-edit');

        $data['invoice'] = $this->invoice->get($id);
        $data['invoice_items'] = $this->invoice->get_items($id);
        $data['currency'] = $this->setting->get_currency($data['invoice']['currency_id']);

		if($this->input->method() === 'post') {

            $db_data = array(
                'paid' => $this->input->post('paid'),
                'unpaid' => $data['invoice']['total'] - $this->input->post('paid'),
                'updated_at' => date('Y-m-d H:i:s'),
            );

            $this->db->where('id', $id);
            $this->db->update('app_invoices', $db_data);
            $result = true;


			if($result) {
                log_staff('Invoice payment updated ' . $id);

				$this->session->set_flashdata('toast-success', __("Invoice has been successfully edited."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to edit invoice."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			$data['title'] = __("Manage Payment");
			$data['modal'] = 'admin/sales/invoices/manage_payment';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

    public function delete($id=0)
	{
        enforce_permission('invoices-delete');

        $data['invoice'] = $this->invoice->get($id);
        $data['invoice_items'] = $this->invoice->get_items($id);
        $data['currency'] = $this->setting->get_currency($data['invoice']['currency_id']);

		if($this->input->method() === 'post') {

			$result = $this->invoice->delete($id);

			if($result) {
                log_staff('Invoice deleted ' . $id);

				$this->session->set_flashdata('toast-success', __("Invoice has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete invoice."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			$data['title'] = __("Delete Invoice");
			$data['modal'] = 'admin/sales/invoices/delete';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}





    public function view($id=0)
    {

        enforce_permission('invoices-view');

        $data['invoice'] = $this->invoice->get($id);
        $data['invoice_items'] = $this->invoice->get_items($id);
        $data['currency'] = $this->setting->get_currency($data['invoice']['currency_id']);

        $data['title'] = __("View Invoice");
        $data['modal'] = 'admin/sales/invoices/view';

        $this->load->view('admin/layout_modal', html_escape($data));


    }





    public function generate_storno($id=0)
    {
        enforce_permission('invoices-add');

        $data['invoice'] = $this->invoice->get($id);
        $data['invoice_items'] = $this->invoice->get_items($id);
        $data['currency'] = $this->setting->get_currency($data['invoice']['currency_id']);

        if($this->input->method() === 'post') {

            //add invoice

            $invoice_num = next_document_number('invoice', $data['invoice']['entity_id']);
            $invoice_data = array(
                'internal' => $data['invoice']['internal'],
                'entity_id' => $data['invoice']['entity_id'],
                'client_id' => $data['invoice']['client_id'],
                'proposal_id' => $data['invoice']['proposal_id'],
                'order_id' => $data['invoice']['order_id'],
                'added_by' => $data['invoice']['added_by'],
                'issued_by' => $this->session->staff_id,
                'currency_id' => $data['invoice']['currency_id'],
                'rate' => $data['invoice']['rate'],
                'number' => $invoice_num,
                'date' => date('Y-m-d'),
                'due_date' => "",
                'value' => -$data['invoice']['value'],
                'tax' => -$data['invoice']['tax'],
                'total' => -$data['invoice']['total'],
                'unpaid' => 0,
                'stock_op' => $data['invoice']['stock_op'],
                'status' => "Valid",
                'notes' => "Storno " . $data['invoice']['number'],
                'client_data' => $data['invoice']['client_data'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            );

            $this->db->insert('app_invoices', $invoice_data);
            $invoice_id = $this->db->insert_id();


            foreach ($data['invoice_items'] as $item) {
                $db_item = array();
                $db_item['invoice_id'] = $invoice_id;
                $db_item['item_id'] = $item['item_id'];
                $db_item['type'] = $item['type'];
                $db_item['name'] = $item['name'];
                $db_item['description'] = $item['description'];
                $db_item['um'] = $item['um'];
                $db_item['qty'] = -$item['qty'];
                $db_item['taxrate'] = $item['taxrate'];
                $db_item['price'] = $item['price'];
                $db_item['value'] = -$item['value'];
                $db_item['tax'] = -$item['tax'];
                $db_item['total'] = -$item['total'];
                $this->db->insert('app_invoice_items', $db_item);
            }





            $result = true;

            if($result) {
                increase_document_number("invoice", $data['invoice']['entity_id']);
                log_staff('Invoice storno generated ' . $id);

                $this->session->set_flashdata('toast-success', __("Storno Invoice has been successfully generated."));
            } else {
                $this->session->set_flashdata('toast-error', __("Unable to generate storno invoice."));
            }

            redirect($_SERVER['HTTP_REFERER']);

        } else {
            $data['title'] = __("Generate Storno Invoice");
            $data['modal'] = 'admin/sales/invoices/generate_sorno';

            $this->load->view('admin/layout_modal', html_escape($data));
        }

    }




    public function duplicate($id=0)
    {
        enforce_permission('invoices-add');

        $data['invoice'] = $this->invoice->get($id);
        $data['invoice_items'] = $this->invoice->get_items($id);
        $data['currency'] = $this->setting->get_currency($data['invoice']['currency_id']);

        if($this->input->method() === 'post') {

            //add invoice



            $manifest_data = array(
                'entity_id' => $data['invoice']['entity_id'],
                'language_id' => $data['invoice']['language_id'],
                'client_id' => $data['invoice']['client_id'],
                'proposal_id' => $data['invoice']['proposal_id'],
                'recurring_id' => $data['invoice']['recurring_id'],
                'added_by' => $data['invoice']['added_by'],
                'issued_by' => $this->session->staff_id,
                'currency_id' => $data['invoice']['currency_id'],
                'rate' => $data['invoice']['rate'],
                'number' => next_document_number('invoice', $data['invoice']['entity_id']),
                'date' => date('Y-m-d'),
                'due_date' => "",
                'value' => $data['invoice']['value'],
                'tax' => $data['invoice']['tax'],
                'total' => $data['invoice']['total'],
                'status' => "Draft",
                'public_notes' => $data['invoice']['public_notes'],
                'private_notes' => $data['invoice']['private_notes'],
                'client_data' => $data['invoice']['client_data'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            );

            $this->db->insert('app_invoices', $manifest_data);
            $invoice_id = $this->db->insert_id();


            foreach ($data['invoice_items'] as $item) {


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


            $result = true;

            if($result) {
                increase_document_number("invoice", $data['invoice']['entity_id']);
                log_staff('Invoice duplicated ' . $id);

                $this->session->set_flashdata('toast-success', __("Invoice has been successfully duplicated.."));
            } else {
                $this->session->set_flashdata('toast-error', __("Unable to duplicate."));
            }

            redirect($_SERVER['HTTP_REFERER']);

        } else {
            $data['title'] = __("Duplicate Invoice");
            $data['modal'] = 'admin/sales/invoices/duplicate';

            $this->load->view('admin/layout_modal', html_escape($data));
        }

    }





    public function send_email($id=0)
    {
        enforce_permission('invoices-view');

        $data['invoice'] = $this->invoice->get($id);
        $data['invoice_items'] = $this->invoice->get_items($id);
        $invoice = $data['invoice'];

        $data['client'] = $this->client->get($data['invoice']['client_id']);
        $client = $data['client'];

        $template = $this->db->get_where('core_email_templates', array('name' => 'Client | New Invoice'))->row_array();
        $data['subject'] = $template['subject'];
        $data['body'] = $template['body'];

        $search = array('{name}', '{email}', '{client_name}', '{invoice_no}', '{invoice_total}', '{due_date}');
        $replace = array($client['name'], $client['email'], $client['name'], $invoice['number'], format_currency($invoice['total'], $invoice['currency_id']), date_display($invoice['due_date']));

        $data['subject'] = str_replace($search, $replace, $data['subject']);
        $data['body'] = str_replace($search, $replace, $data['body']);


        if($this->input->method() === 'post') {


            $email_data = [
                'client_id' => $data['client']['id'],
                'invoice_id' => $data['invoice']['id'],
                'email_address' => $this->input->post('email'),
                'subject' => $this->input->post('subject'),
                'body' => $this->input->post('body'),
            ];
            $this->mailer->send('Client | New Invoice', $email_data);


            $result = true;

            if($result) {
                log_staff('Invoice email sent ' . $id);

                $this->session->set_flashdata('toast-success', __("Email has been successfully sent."));
            } else {
                $this->session->set_flashdata('toast-error', __("Unable to send email."));
            }

            redirect($_SERVER['HTTP_REFERER']);

        } else {
            $data['title'] = __("Send Email");
            $data['modal'] = 'admin/sales/invoices/send_email';

            $this->load->view('admin/layout_modal', html_escape($data));
        }

    }







    public function send_reminder($id=0)
    {
        enforce_permission('invoices-view');

        $data['invoice'] = $this->invoice->get($id);
        $data['invoice_items'] = $this->invoice->get_items($id);
        $invoice = $data['invoice'];

        $data['client'] = $this->client->get($data['invoice']['client_id']);
        $client = $data['client'];

        $template = $this->db->get_where('core_email_templates', array('name' => 'Client | Invoice Reminder'))->row_array();
        $data['subject'] = $template['subject'];
        $data['body'] = $template['body'];

        $search = array('{name}', '{email}', '{client_name}', '{invoice_no}', '{invoice_total}', '{due_date}');
        $replace = array($client['name'], $client['email'], $client['name'], $invoice['number'], format_currency($invoice['total'], $invoice['currency_id']), date_display($invoice['due_date']));

        $data['subject'] = str_replace($search, $replace, $data['subject']);
        $data['body'] = str_replace($search, $replace, $data['body']);


        if($this->input->method() === 'post') {


            $email_data = [
                'client_id' => $data['client']['id'],
                'invoice_id' => $data['invoice']['id'],
                'email_address' => $this->input->post('email'),
                'subject' => $this->input->post('subject'),
                'body' => $this->input->post('body'),
            ];
            $this->mailer->send('Client | Invoice Reminder', $email_data);


            $result = true;

            if($result) {
                log_staff('Invoice reminder sent ' . $id);

                $this->session->set_flashdata('toast-success', __("Email has been successfully sent."));
            } else {
                $this->session->set_flashdata('toast-error', __("Unable to send email."));
            }

            redirect($_SERVER['HTTP_REFERER']);

        } else {
            $data['title'] = __("Send Reminder");
            $data['modal'] = 'admin/sales/invoices/send_reminder';

            $this->load->view('admin/layout_modal', html_escape($data));
        }

    }





    public function pdf($method='',$ids_string='')
    {
        enforce_permission('invoices-view');
        
        if($method == "") {
            $method =  $this->uri->segment(5);
        }

        if($ids_string == "") {
            $ids_string =  $this->uri->segment(6);
        }

        $this->invoice->pdf($method, $ids_string);


    }


}
