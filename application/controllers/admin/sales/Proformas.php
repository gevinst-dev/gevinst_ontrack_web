<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proformas extends Admin_Controller {


    public function __construct()
	{
		parent::__construct();

		$this->load->model('admin/proforma_model', 'proforma');
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

        enforce_permission('proformas-view');

        $where = [];

        if($_SESSION['data_filter_start'] != "") $where['date >='] = $_SESSION['data_filter_start'];
        if($_SESSION['data_filter_end'] != "") $where['date <='] = $_SESSION['data_filter_end'];

        if($_SESSION['data_filter_agent_id'] != "") {
            if($_SESSION['data_filter_agent_id'] != "0") {
                $where['app_proformas.added_by'] = $_SESSION['data_filter_agent_id'];
            }
        }

        if($_SESSION['global_filter_entity'] != "") $where['entity_id'] = $_SESSION['global_filter_entity'];


		$this->datatables
			->select('app_proformas.id, app_proformas.currency_id, app_proformas.number, app_proformas.date, app_proformas.due_date, app_proformas.value, app_proformas.tax, app_proformas.total, app_proformas.unpaid, app_proformas.status')
			->from('app_proformas')
            ->where($where)
			->join('app_clients', 'app_proformas.client_id = app_clients.id', 'LEFT')
			->select('app_clients.name as client_name')

            ->join('core_staff', 'app_proformas.added_by = core_staff.id', 'LEFT')
            ->select('core_staff.name as agent_name')

            ->join('app_entities', 'app_proformas.entity_id = app_entities.id', 'LEFT')
			->select('app_entities.title as entity_name')


			->edit_column_if('status', '<span class="label label-inverse-danger">'.__("Canceled").'</span>', '', 'Canceled')
			->edit_column_if('status', '<span class="label label-inverse-success">'.__("Valid").'</span>', '', 'Valid')
            ->edit_column_if('status', '<span class="label label-inverse-primary">'.__("Draft").'</span>', '', 'Draft')

            ->add_column(
				'actions',
				'<div class="btn-group" role="group">'.
                    '<button data-modal="admin/sales/proformas/view/$1" data-toggle="tooltip" title="'.__("View Proforma").'" type="button" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-eye"></i></button>'.



                    '<a href="'.base_url('admin/sales/proformas/edit/').'$1" data-toggle="tooltip" title="'.__("Edit proforma").'" type="button" class="btn btn-success btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-edit"></i></a>'.

                    '<div class="dropdown">'.
                        '<a class="btn btn-inverse btn-mini" title="'.__("More actions").'" href="#" id="dropdown-$1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-fw fa-ellipsis-v"></i> </a>'.

                        '<div class="dropdown-menu">'.



                            '<a data-modal="admin/sales/proformas/manage_payment/$1" href="#"  class="dropdown-item"><i class="fas fa-fw fa-coins"></i> '.__("Manage Payment").'</a>'.

                            '<a href="#" data-modal="admin/sales/proformas/send_email/$1" class="dropdown-item"><i class="fas fa-fw fa-envelope"></i> '.__("Send Email").'</a>'.



                            '<a data-modal="admin/sales/proformas/duplicate/$1" href="#"  class="dropdown-item"><i class="fas fa-fw fa-clone"></i> '.__("Duplicate").'</a>'.


                            '<a data-modal="admin/sales/proformas/delete/$1" href="#"  class="dropdown-item"><i class="fas fa-fw fa-trash"></i> '.__("Delete Proforma").'</a>'.



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

        if($this->input->method() === 'post') {


            $action = $this->input->post('action');
            $items = $this->input->post('item');

            if(!empty($items)) {

                if($action == "bulk_print") {

                    $to_print = [];
                    foreach($items as $item) {
                        array_push($to_print, $item);
                    }

                    redirect(base_url('admin/sales/proformas/pdf/view/' . implode('-', $to_print)));

                }


            }


        }



  

        redirect($_SERVER['HTTP_REFERER']);
    }

    public function index()
	{
        enforce_permission('proformas-view');

		$data['title'] = __("Proformas");
		$data['page'] = 'admin/sales/proformas/list';


        $data['agents'] = $this->db->get('core_staff')->result_array();
        $data['entities'] = $this->db->get('app_entities')->result_array();

		$this->load->view('admin/layout_page', html_escape($data));
	}



    public function select_currency()
	{
        enforce_permission('proformas-add');

        $data['currencies'] = $this->setting->get_currencies();

		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('currency_id', __('Currency'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {
                redirect(base_url('admin/sales/proformas/add/'.$this->input->post('currency_id')));
			}

		} else {
			$data['title'] = __("Select Proforma Currency");
			$data['modal'] = 'admin/sales/proformas/select_currency';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}




    public function add($id=0)
	{
        enforce_permission('proformas-add');

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
                    'number' => next_document_number('proforma', $this->input->post('entity_id')),
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


                $result = $this->proforma->add($db_data, $items);



				if($result) {
                    log_staff('Proforma added ' . $result);

					$this->session->set_flashdata('toast-success', __("Proforma has been successfully added."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to add proforma."));

				}

				redirect(base_url('admin/sales/proformas'));

			}

		} else {
			$data['title'] = __("Add Proforma");
            $data['page'] = 'admin/sales/proformas/add';

    		$this->load->view('admin/layout_page', html_escape($data));
		}

	}



    public function edit($id=0)
	{
        enforce_permission('proformas-edit');


        $data['proforma'] = $this->proforma->get($id);
        $data['proforma_items'] = $this->proforma->get_items($id);
        $data['currency'] = $this->setting->get_currency($data['proforma']['currency_id']);
        $data['client'] = $this->client->get($data['proforma']['client_id']);

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

                if($data['proforma']['paid'] > 0) {
                    $db_data['unpaid'] = $this->input->post('total') - $data['proforma']['paid'];
                } else {
                    $db_data['unpaid'] = $this->input->post('total');
                }

                if($this->input->post('total') <= 0){
                    $db_data['unpaid'] = 0;
                    $db_data['paid'] = 0;
                }

				$db_data = $this->security->xss_clean($db_data);
                $items = $this->security->xss_clean($this->input->post('items'));
				$result = $this->proforma->edit($db_data, $items, $id);

				if($result) {
                    log_staff('Proforma edited ' . $id);

					$this->session->set_flashdata('toast-success', __("Proforma has been successfully edit."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to edit proforma."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$data['title'] = __("Edit Proforma");
            $data['page'] = 'admin/sales/proformas/edit';

    		$this->load->view('admin/layout_page', html_escape($data));
		}

	}


    public function manage_payment($id=0)
	{
        enforce_permission('proformas-edit');

        $data['proforma'] = $this->proforma->get($id);
        $data['proforma_items'] = $this->proforma->get_items($id);
        $data['currency'] = $this->setting->get_currency($data['proforma']['currency_id']);

		if($this->input->method() === 'post') {

            $db_data = array(
                'paid' => $this->input->post('paid'),
                'unpaid' => $data['proforma']['total'] - $this->input->post('paid'),
                'updated_at' => date('Y-m-d H:i:s'),
            );

            $this->db->where('id', $id);
            $this->db->update('app_proformas', $db_data);
            $result = true;


			if($result) {
                log_staff('Proforma payment updated ' . $id);

				$this->session->set_flashdata('toast-success', __("Proforma has been successfully edited."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to edit proforma."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			$data['title'] = __("Manage Payment");
			$data['modal'] = 'admin/sales/proformas/manage_payment';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

    public function delete($id=0)
	{
        enforce_permission('proformas-delete');

        $data['proforma'] = $this->proforma->get($id);
        $data['proforma_items'] = $this->proforma->get_items($id);
        $data['currency'] = $this->setting->get_currency($data['proforma']['currency_id']);

		if($this->input->method() === 'post') {

			$result = $this->proforma->delete($id);

			if($result) {
                log_staff('Proforma deleted ' . $id);

				$this->session->set_flashdata('toast-success', __("Proforma has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete proforma."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			$data['title'] = __("Delete Proforma");
			$data['modal'] = 'admin/sales/proformas/delete';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}





    public function view($id=0)
    {
        enforce_permission('proformas-view');

        $data['proforma'] = $this->proforma->get($id);
        $data['proforma_items'] = $this->proforma->get_items($id);
        $data['currency'] = $this->setting->get_currency($data['proforma']['currency_id']);

        $data['title'] = __("View Proforma");
        $data['modal'] = 'admin/sales/proformas/view';

        $this->load->view('admin/layout_modal', html_escape($data));


    }




    public function duplicate($id=0)
    {
        enforce_permission('proformas-add');

        $data['proforma'] = $this->proforma->get($id);
        $data['proforma_items'] = $this->proforma->get_items($id);
        $data['currency'] = $this->setting->get_currency($data['proforma']['currency_id']);

        if($this->input->method() === 'post') {

            //add proforma
 

            $manifest_data = array(
                'entity_id' => $data['proforma']['entity_id'],
                'language_id' => $data['proforma']['language_id'],
                'client_id' => $data['proforma']['client_id'],
                'proposal_id' => $data['proforma']['proposal_id'],
                'recurring_id' => $data['proforma']['recurring_id'],
                'added_by' => $data['proforma']['added_by'],
                'issued_by' => $this->session->staff_id,
                'currency_id' => $data['proforma']['currency_id'],
                'rate' => $data['proforma']['rate'],
                'number' => next_document_number('proforma', $data['proforma']['entity_id']),
                'date' => date('Y-m-d'),
                'due_date' => "",
                'value' => $data['proforma']['value'],
                'tax' => $data['proforma']['tax'],
                'total' => $data['proforma']['total'],
                'status' => "Draft",
                'public_notes' => $data['proforma']['public_notes'],
                'private_notes' => $data['proforma']['private_notes'],
                'client_data' => $data['proforma']['client_data'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            );

            $this->db->insert('app_proformas', $manifest_data);
            $proforma_id = $this->db->insert_id();


            foreach ($data['proforma_items'] as $item) {


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


            $result = true;

            if($result) {
                increase_document_number("proforma", $data['proforma']['entity_id']);
                log_staff('Proforma duplicated ' . $id);

                $this->session->set_flashdata('toast-success', __("Proforma has been successfully duplicated.."));
            } else {
                $this->session->set_flashdata('toast-error', __("Unable to duplicate."));
            }

            redirect($_SERVER['HTTP_REFERER']);

        } else {
            $data['title'] = __("Duplicate Proforma");
            $data['modal'] = 'admin/sales/proformas/duplicate';

            $this->load->view('admin/layout_modal', html_escape($data));
        }

    }





    public function send_email($id=0)
    {
        enforce_permission('proformas-view');

        $data['proforma'] = $this->proforma->get($id);
        $data['proforma_items'] = $this->proforma->get_items($id);
   
        $proforma = $data['proforma'];

        $data['client'] = $this->client->get($data['proforma']['client_id']);
        $client = $data['client'];

        $template = $this->db->get_where('core_email_templates', array('name' => 'Client | New Profroma'))->row_array();
        $data['subject'] = $template['subject'];
        $data['body'] = $template['body'];

        $search = array('{name}', '{email}', '{client_name}', '{proforma_no}', '{profroma_total}', '{due_date}');
        $replace = array($client['name'], $client['email'], $client['name'], $proforma['number'], format_currency($proforma['total'], $proforma['currency_id']), date_display($proforma['due_date']));

        $data['subject'] = str_replace($search, $replace, $data['subject']);
        $data['body'] = str_replace($search, $replace, $data['body']);


        if($this->input->method() === 'post') {


            $email_data = [
                'client_id' => $data['client']['id'],
                'proforma_id' => $data['proforma']['id'],
                'email_address' => $this->input->post('email'),
                'subject' => $this->input->post('subject'),
                'body' => $this->input->post('body'),
            ];
            $this->mailer->send('Client | New Profroma', $email_data);


            $result = true;

            if($result) {
                log_staff('Proforma email sent ' . $id);

                $this->session->set_flashdata('toast-success', __("Email has been successfully sent."));
            } else {
                $this->session->set_flashdata('toast-error', __("Unable to send email."));
            }

            redirect($_SERVER['HTTP_REFERER']);

        } else {
            $data['title'] = __("Send Email");
            $data['modal'] = 'admin/sales/proformas/send_email';

            $this->load->view('admin/layout_modal', html_escape($data));
        }

    }


    public function pdf($method='',$ids_string='')
    {
        enforce_permission('proformas-view');
        
        if($method == "") {
            $method =  $this->uri->segment(5);
        }

        if($ids_string == "") {
            $ids_string =  $this->uri->segment(6);
        }

        $this->proforma->pdf($method, $ids_string);


    }







}
