<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recurring extends Admin_Controller {


    public function __construct()
	{
		parent::__construct();

		$this->load->model('admin/recurring_model', 'recurring');
		$this->load->model('admin/staff_model', 'staff');
        $this->load->model('admin/client_model', 'client');
        $this->load->model('admin/setting_model', 'setting');
        $this->load->model('admin/item_model', 'item');
		$this->load->library('datatables');



        if(!isset($_SESSION['data_filter_start']))
            $this->session->set_userdata('data_filter_start', date('Y-m-d', strtotime('first day of this year')));

        if(!isset($_SESSION['data_filter_end']))
            $this->session->set_userdata('data_filter_end', date('Y-m-d', strtotime('last day of this month')));

        if(!isset($_SESSION['data_filter_agent_id']))
            $this->session->set_userdata('data_filter_agent_id', $this->session->staff_id);


        if(!isset($_SESSION['global_filter_entity']))
            $this->session->set_userdata('global_filter_entity', '');


        if(!isset($_SESSION['recurring_status_filter']))
            $this->session->set_userdata('recurring_status_filter', '');


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

            if(isset($_POST['recurring_status_filter']))
				$this->session->set_userdata('recurring_status_filter', $this->input->post('recurring_status_filter'));

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			die("Invalid action!");
		}
	}



    public function json_all() {

        enforce_permission('recurring-view');

        $where = [];

    
        if($_SESSION['data_filter_agent_id'] != "") {
            if($_SESSION['data_filter_agent_id'] != "0") {
                $where['app_recurring.added_by'] = $_SESSION['data_filter_agent_id'];
            }
        }

        if($_SESSION['global_filter_entity'] != "") $where['app_recurring.entity_id'] = $_SESSION['global_filter_entity'];

        if($_SESSION['recurring_status_filter'] != "") $where['app_recurring.status'] = $_SESSION['recurring_status_filter'];


		$this->datatables
			->select('app_recurring.id, app_recurring.type, app_recurring.frequency, app_recurring.name, app_recurring.start_date, app_recurring.next_date, app_recurring.value, app_recurring.status, app_recurring.emissions')
			->from('app_recurring')
            ->where($where)

			->join('app_clients', 'app_recurring.client_id = app_clients.id', 'LEFT')
			->select('app_clients.name as client_name')

            ->join('core_staff', 'app_recurring.added_by = core_staff.id', 'LEFT')
            ->select('core_staff.name as agent_name')

            ->join('app_currencies', 'app_recurring.currency_id = app_currencies.id', 'LEFT')
            ->select('app_currencies.code as currency')

            ->join('app_entities', 'app_recurring.entity_id = app_entities.id', 'LEFT')
			->select('app_entities.title as entity_name')

			->edit_column_if('status', '<span class="label label-inverse-primary">'.__("Draft").'</span>', '', 'Draft')
            ->edit_column_if('status', '<span class="label label-inverse-success">'.__("Active").'</span>', '', 'Active')
			->edit_column_if('status', '<span class="label label-inverse-warning">'.__("Suspended").'</span>', '', 'Suspended')
            ->edit_column_if('status', '<span class="label label-inverse-danger">'.__("Canceled").'</span>', '', 'Canceled')

            ->add_column(
				'actions',
				'<div class="btn-group" role="group">'.

                    '<button data-modal="admin/sales/recurring/view/$1" data-toggle="tooltip" title="'.__("View Recurrence").'" type="button" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-eye"></i></button>'.
					'<a href="'.base_url('admin/sales/recurring/edit/').'$1" data-toggle="tooltip" title="'.__("Edit Recurrence").'" type="button" class="btn btn-success btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-edit"></i></a>'.
                    '<button data-modal="admin/sales/recurring/duplicate/$1" data-toggle="tooltip" title="'.__("Duplicate Recurrence").'" type="button" class="btn btn-warning btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-copy"></i></button>'.
					'<button data-modal="admin/sales/recurring/delete/$1" data-toggle="tooltip" title="'.__("Delete Recurrence").'" type="button" class="btn btn-danger btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-trash"></i></button>'.

                '</div>',
				'id'
			);



        $results = $this->datatables->generate('json');
        $results = json_decode($results, TRUE);

        foreach($results['data'] as $key => $value) {

            $results['data'][$key]['start_date'] = date_display($value['start_date']);
            $results['data'][$key]['next_date'] = date_display($value['next_date']);

         
        }

        echo json_encode($results);

	}



    public function index()
	{
        enforce_permission('recurring-view');

		$data['title'] = __("Recurring");
		$data['page'] = 'admin/sales/recurring/list';

        $data['agents'] = $this->db->get('core_staff')->result_array();
        $data['entities'] = $this->db->get('app_entities')->result_array();

		$this->load->view('admin/layout_page', html_escape($data));
	}





    public function add($id=0)
	{
        enforce_permission('recurring-add');

        $data['currencies'] = $this->setting->get_currencies();


        $data['clients'] = $this->client->get_all();
        $data['taxrates'] = $this->setting->get_taxrates();
        $data['entities'] = $this->setting->get_entities();
        $data['languages'] = $this->setting->get_languages();
        $data['items'] = $this->item->get_all();
        $data['staff'] = $this->staff->get_all();

		if($this->input->method() === 'post') {



			$this->form_validation->set_rules('client_id', __('Client'), 'trim|required');
            $this->form_validation->set_rules('start_date', __('Date'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {
                $data['client'] = $this->client->get($this->input->post('client_id'));

                if( $this->input->post('emission_limit') == "" ) {
                    $emission_limit = -1;
                } else {
                    $emission_limit = $this->input->post('emission_limit');
                }

				$db_data = array(
                    'type' => $this->input->post('type'),
                    'entity_id' => $this->input->post('entity_id'),
					'client_id' => $this->input->post('client_id'),
					'added_by' => $this->input->post('added_by'),
                    'language_id' => $this->input->post('language_id'),
					'currency_id' => $this->input->post('currency_id'),
                    'send_email' => $this->input->post('send_email'),
                    'name' => $this->input->post('name'),
                    'frequency' => $this->input->post('frequency'),

                    'start_date' => date_to_db($this->input->post('start_date')),
                    'next_date' => date_to_db($this->input->post('start_date')),
                    'due_days' => $this->input->post('due_days'),
                    'emission_limit' => $emission_limit,
                    'value' => $this->input->post('value'),
                    'status' =>  $this->input->post('status'),
                    'notes' => $this->input->post('notes'),
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
                $items = $this->security->xss_clean($this->input->post('items'));
				$result = $this->recurring->add($db_data, $items);

				if($result) {
                    log_staff('Recurring added ' . $result);

					$this->session->set_flashdata('toast-success', __("Recurrence has been successfully added."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to add recurrence."));
				}

				redirect(base_url('admin/sales/recurring'));

			}

		} else {
			$data['title'] = __("Add Recurrence");
            $data['page'] = 'admin/sales/recurring/add';

    		$this->load->view('admin/layout_page', html_escape($data));
		}

	}



    public function edit($id=0)
	{
        enforce_permission('recurring-edit');
        $data['currencies'] = $this->setting->get_currencies();

        $data['recurring'] = $this->recurring->get($id);
        $data['recurring_items'] = $this->recurring->get_items($id);
        $data['currency'] = $this->setting->get_currency($data['recurring']['currency_id']);


        $data['client'] = $this->client->get($data['recurring']['client_id']);

        $data['taxrates'] = $this->setting->get_taxrates();
        $data['entities'] = $this->setting->get_entities();
        $data['languages'] = $this->setting->get_languages();
        $data['currencies'] = $this->setting->get_currencies();
        $data['staff'] = $this->staff->get_all();

		if($this->input->method() === 'post') {

			$this->form_validation->set_rules('client_id', __('Client'), 'trim|required');


			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {
                $data['client'] = $this->client->get($this->input->post('client_id'));

				$db_data = array(
                    'type' => $this->input->post('type'),
                    'entity_id' => $this->input->post('entity_id'),
					'client_id' => $this->input->post('client_id'),
                    'added_by' => $this->input->post('added_by'),
                    'language_id' => $this->input->post('language_id'),
                    'currency_id' => $this->input->post('currency_id'),
                    'send_email' => $this->input->post('send_email'),
                    'name' => $this->input->post('name'),
                    'frequency' => $this->input->post('frequency'),
                    'next_date' => date_to_db($this->input->post('next_date')),
                    'due_days' => $this->input->post('due_days'),
                    'emission_limit' => $this->input->post('emission_limit'),
                    'value' => $this->input->post('value'),
                    'status' => $this->input->post('status'),
                    'notes' => $this->input->post('notes'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
                $items = $this->security->xss_clean($this->input->post('items'));
				$result = $this->recurring->edit($db_data, $items, $id);

				if($result) {
                    log_staff('Recurring edited ' . $id);

					$this->session->set_flashdata('toast-success', __("Recurrence has been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to update recurrence."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$data['title'] = __("Edit Recurrence");
            $data['page'] = 'admin/sales/recurring/edit';

    		$this->load->view('admin/layout_page', html_escape($data));
		}

	}



    public function delete($id=0)
	{
        enforce_permission('recurring-delete');

        $data['recurring'] = $this->recurring->get($id);
        $data['recurring_items'] = $this->recurring->get_items($id);
        $data['currency'] = $this->setting->get_currency($data['recurring']['currency_id']);

		if($this->input->method() === 'post') {

			$result = $this->recurring->delete($id);

			if($result) {
                log_staff('Recurring deleted ' . $id);

				$this->session->set_flashdata('toast-success', __("Recurrence has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete recurrence."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			$data['title'] = __("Delete Recurrence");
			$data['modal'] = 'admin/sales/recurring/delete';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}


    public function view($id=0)
    {
        enforce_permission('recurring-view');

        $data['recurring'] = $this->recurring->get($id);
        $data['recurring_items'] = $this->recurring->get_items($id);
        $data['currency'] = $this->setting->get_currency($data['recurring']['currency_id']);

        $data['title'] = __("View Recurrence");
        $data['modal'] = 'admin/sales/recurring/view';

        $this->load->view('admin/layout_modal', html_escape($data));


    }



    public function duplicate($id=0)
	{
        enforce_permission('recurring-add');

        $data['recurring'] = $this->recurring->get($id);
        $data['recurring_items'] = $this->recurring->get_items($id);


		if($this->input->method() === 'post') {



            $order_data = array(
                'type' => $data['recurring']['type'],
                'entity_id' => $data['recurring']['entity_id'],
                'client_id' => $data['recurring']['client_id'],
                'added_by' => $data['recurring']['added_by'],
                'language_id' => $data['recurring']['language_id'],
                'currency_id' => $data['recurring']['currency_id'],
                'send_email' => $data['recurring']['send_email'],
                'name' => $data['recurring']['name'],
                'frequency' => $data['recurring']['frequency'],
                'start_date' => $data['recurring']['start_date'],
                'next_date' => $data['recurring']['next_date'],
                'due_days' => $data['recurring']['due_days'],
                'emission_limit' => $data['recurring']['emission_limit'],
                'emissions' => 0,
             
                'value' => $data['recurring']['value'],
                'status' => "Draft",
                'notes' => $data['recurring']['notes'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            );

            $this->db->insert('app_recurring', $order_data);
            $recurring_id = $this->db->insert_id();

            foreach($data['proposal_items'] as $item) {
                $db_item = array();
                $db_item['recurring_id'] = $recurring_id;
                $db_item['currency_id'] = $item['currency_id'];
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
                $this->db->insert('app_recurring_items', $db_item);
            }



            $result = TRUE;


			if($result) {
                log_staff('Recurring duplicated ' . $id);

				$this->session->set_flashdata('toast-success', __("Recurrence has been successfully duplicated."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to duplicate recurrence."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			$data['title'] = __("Duplicate Recurrence");
			$data['modal'] = 'admin/sales/recurring/duplicate';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}



    public function convert_to_invoice($id=0)
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
                'client_id' => $data['proposal']['client_id'],
                'proposal_id' => $data['proposal']['id'],
                'order_id' => "0",
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
                'status' => "Valid",
                'stock_op' => 1,
                'notes' => "",
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
                $db_item['um'] = $item['um'];
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
                log_staff('Recurring converted to invoice ' . $id);

                increase_document_number("invoice", $data['proposal']['entity_id']);
				$this->session->set_flashdata('toast-success', __("Proposal has been successfully converted to invoice."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to convert proposal."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			$data['title'] = __("Convertiti in Factura");
			$data['modal'] = 'admin/sales/recurring/convert_to_invoice';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}








}
