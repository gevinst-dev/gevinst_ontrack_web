<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recurring extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('admin/recurring_expense_model', 'recurring_expense');

		$this->load->model('admin/setting_model', 'setting');

		$this->load->library('datatables');

		if(!isset($_SESSION['filter_start']))
			$this->session->set_userdata('filter_start', date('Y-m-d', strtotime('first day of this month')));

		if(!isset($_SESSION['filter_end']))
			$this->session->set_userdata('filter_end', date('Y-m-d', strtotime('last day of this month')));


		if(!isset($_SESSION['filter_entity_id']))
			$this->session->set_userdata('filter_entity_id', '');


		if(!isset($_SESSION['filter_supplier_id']))
			$this->session->set_userdata('filter_supplier_id', '');

		if(!isset($_SESSION['filter_project_id']))
			$this->session->set_userdata('filter_project_id', '');


		if(!isset($_SESSION['filter_expense_category_id']))
            $this->session->set_userdata('filter_expense_category_id', '');
	}


	public function set_filters() {

		if($this->input->method() === 'post') {



			if(isset($_POST['filter_start']))
				$this->session->set_userdata('filter_start', date_to_db($this->input->post('filter_start')));

			if(isset($_POST['filter_end']))
				$this->session->set_userdata('filter_end', date_to_db($this->input->post('filter_end')));


			if(isset($_POST['filter_entity_id']))
				$this->session->set_userdata('filter_entity_id', $this->input->post('filter_entity_id'));

			if(isset($_POST['filter_supplier_id']))
				$this->session->set_userdata('filter_supplier_id', $this->input->post('filter_supplier_id'));

			if(isset($_POST['filter_project_id']))
				$this->session->set_userdata('filter_project_id', $this->input->post('filter_project_id'));

			if(isset($_POST['filter_expense_category_id']))
				$this->session->set_userdata('filter_expense_category_id', $this->input->post('filter_expense_category_id'));



			redirect($_SERVER['HTTP_REFERER']);

		} else {
			die("Invalid action!");
		}
	}


	public function json_all() {
        enforce_permission('recurringexp-view');

		$where = [];



		if($_SESSION['filter_entity_id'] != "") { $where['app_recurring_expenses.entity_id'] = $_SESSION['filter_entity_id']; }
		if($_SESSION['filter_supplier_id'] != "") { $where['app_recurring_expenses.supplier_id'] = $_SESSION['filter_supplier_id']; }
		if($_SESSION['filter_project_id'] != "") { $where['app_recurring_expenses.project_id'] = $_SESSION['filter_project_id']; }
		if($_SESSION['filter_expense_category_id'] != "") { $where['app_recurring_expenses.category_id'] = $_SESSION['filter_expense_category_id']; }


		$this->datatables
			->select('app_recurring_expenses.id, app_recurring_expenses.currency_id, app_recurring_expenses.total, app_recurring_expenses.description, app_recurring_expenses.file, app_recurring_expenses.frequency, app_recurring_expenses.emissions, app_recurring_expenses.next_date, app_recurring_expenses.status')
			->from('app_recurring_expenses')

			->where($where)


			->edit_column_if('status', '<span class="label label-inverse-danger">'.__("Draft").'</span>', '', 'Draft')
            ->edit_column_if('status', '<span class="label label-inverse-primary">'.__("Active").'</span>', '', 'Active')
			->edit_column_if('status', '<span class="label label-inverse-success">'.__("Suspended").'</span>', '', 'Suspended')
            ->edit_column_if('status', '<span class="label label-inverse-info-border">'.__("Canceled").'</span>', '', 'Canceled')

			->edit_column('file', '<a href="'.base_url('admin/expenses/recurring/download_file/').'$1">$2</a>', 'id,file')

			->join('app_entities', 'app_recurring_expenses.entity_id = app_entities.id', 'LEFT')
			->select('app_entities.title as entity_name')

			->join('app_suppliers', 'app_recurring_expenses.supplier_id = app_suppliers.id', 'LEFT')
			->select('app_suppliers.name as supplier_name')

			->join('app_projects', 'app_recurring_expenses.project_id = app_projects.id', 'LEFT')
			->select('app_projects.name as project_name')

			->join('app_expense_categories', 'app_recurring_expenses.category_id = app_expense_categories.id', 'LEFT')
			->select('app_expense_categories.name as category_name')


            ->add_column(
				'actions',
				'<div class="btn-group" role="group">'.
                    '<button data-modal="admin/expenses/recurring/edit/$1" data-toggle="tooltip" title="'.__("Edit Recurring Expense").'" type="button" class="btn btn-success btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-edit"></i></button>'.
					'<button data-modal="admin/expenses/recurring/delete/$1" data-toggle="tooltip" title="'.__("Delete Recurring Expense").'" type="button" class="btn btn-danger btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-trash"></i></button>'.
                '</div>',
				'id'
			);



        $results = $this->datatables->generate('json');
        $results = json_decode($results, TRUE);

        foreach($results['data'] as $key => $value) {

            $results['data'][$key]['next_date'] = date_display($value['next_date']);



            $results['data'][$key]['total'] = format_currency($value['total'], $value['currency_id']);
        }

        echo json_encode($results);

	}



	public function index()
	{
        enforce_permission('recurringexp-view');

		$data['title'] = __("Recurring Expenses");
		$data['page'] = 'admin/expenses/recurring/list';

		$data['entities'] = $this->db->get('app_entities')->result_array();
		$data['suppliers'] = $this->db->get('app_suppliers')->result_array();
		$data['projects'] = $this->db->get('app_projects')->result_array();
		$data['expense_categories'] = $this->db->get('app_expense_categories')->result_array();

		$this->load->view('admin/layout_page', html_escape($data));
	}


	public function add()
	{
        enforce_permission('recurringexp-add');

		$data['currencies'] = $this->db->get('app_currencies')->result_array();
		$data['entities'] = $this->db->get('app_entities')->result_array();
		$data['suppliers'] = $this->db->get('app_suppliers')->result_array();
		$data['projects'] = $this->db->get('app_projects')->result_array();
		$data['expense_categories'] = $this->db->get('app_expense_categories')->result_array();


		if($this->input->method() === 'post') {

			$this->form_validation->set_rules('entity_id', __('Entity'), 'trim|required');
			$this->form_validation->set_rules('supplier_id', __('Supplier'), 'trim|required');
			$this->form_validation->set_rules('category_id', __('Category'), 'trim|required');

			$this->form_validation->set_rules('value', __('Value'), 'trim|required');
			$this->form_validation->set_rules('tax', __('Tax'), 'trim|required');
			$this->form_validation->set_rules('total', __('Total'), 'trim|required');


			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {



				$db_data = array(

					'entity_id' => $this->input->post('entity_id'),
					'supplier_id' => $this->input->post('supplier_id'),
					'project_id' => $this->input->post('project_id'),
					'category_id' => $this->input->post('category_id'),
					'currency_id' => $this->input->post('currency_id'),
					'value' => $this->input->post('value'),
					'tax' => $this->input->post('tax'),
					'total' => $this->input->post('total'),
					'paid' => $this->input->post('paid'),
					'description' => $this->input->post('description'),
					'frequency' => $this->input->post('frequency'),
					'start_date' => date_to_db($this->input->post('start_date')),
					'next_date' => date_to_db($this->input->post('start_date')),
					'emission_limit' => $this->input->post('emission_limit'),
					'emissions' => $this->input->post('emissions'),
					'status' => $this->input->post('status'),

					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);


				$config['upload_path']                = './filestore/main/recurring_expenses/';
				$config['allowed_types']              = 'gif|jpg|png|jpeg|pdf';
				$config['file_ext_tolower']           = TRUE;
				$config['max_filename_increment']     = 1000;
				$this->load->library('upload', $config);

				if(!empty($_FILES['userfile']['name'])) {
					if(!$this->upload->do_upload('userfile')) { $this->session->set_flashdata('toast-error', __("Error uploading! Check file type or size.")); redirect($_SERVER['HTTP_REFERER']); }
					$db_data['file'] = $this->upload->data('file');
				}

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->recurring_expense->add($db_data);

				if($result) {
                    log_staff('Recurring Expense added ' . $result);

					$this->session->set_flashdata('toast-success', __("Recurring Expense has been successfully added."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to add item."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$data['title'] = __("Add Recurring Expense");
			$data['modal'] = 'admin/expenses/recurring/add';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}



	public function edit($id=0)
	{
        enforce_permission('recurringexp-edit');

		$data['recurring_expense'] = $this->recurring_expense->get($id);

		$data['currencies'] = $this->db->get('app_currencies')->result_array();
		$data['entities'] = $this->db->get('app_entities')->result_array();
		$data['suppliers'] = $this->db->get('app_suppliers')->result_array();
		$data['projects'] = $this->db->get('app_projects')->result_array();
		$data['expense_categories'] = $this->db->get('app_expense_categories')->result_array();

		if($this->input->method() === 'post') {

			$this->form_validation->set_rules('entity_id', __('Entity'), 'trim|required');
			$this->form_validation->set_rules('supplier_id', __('Supplier'), 'trim|required');
			$this->form_validation->set_rules('category_id', __('Category'), 'trim|required');

			$this->form_validation->set_rules('value', __('Value'), 'trim|required');
			$this->form_validation->set_rules('tax', __('Tax'), 'trim|required');
			$this->form_validation->set_rules('total', __('Total'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {



				$db_data = array(
					'entity_id' => $this->input->post('entity_id'),
					'supplier_id' => $this->input->post('supplier_id'),
					'project_id' => $this->input->post('project_id'),
					'category_id' => $this->input->post('category_id'),
					'currency_id' => $this->input->post('currency_id'),
					'value' => $this->input->post('value'),
					'tax' => $this->input->post('tax'),
					'total' => $this->input->post('total'),
					'paid' => $this->input->post('paid'),
					'description' => $this->input->post('description'),
					'frequency' => $this->input->post('frequency'),

					'next_date' => date_to_db($this->input->post('next_date')),
					'emission_limit' => $this->input->post('emission_limit'),
					'status' => $this->input->post('status'),

					'updated_at' => date('Y-m-d H:i:s'),
				);

				$config['upload_path']                = './filestore/main/recurring_expenses/';
				$config['allowed_types']              = 'gif|jpg|png|jpeg|pdf';
				$config['file_ext_tolower']           = TRUE;
				$config['max_filename_increment']     = 1000;
				$this->load->library('upload', $config);

				if(!empty($_FILES['userfile']['name'])) {
					if(!$this->upload->do_upload('userfile')) { $this->session->set_flashdata('toast-error', __("Error uploading! Check file type or size.")); redirect($_SERVER['HTTP_REFERER']); }
					$db_data['file'] = $this->upload->data('file_name');
				}

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->recurring_expense->edit($db_data, $id);

				if($result) {
                    log_staff('Recurring Expense edited ' . $id);

					$this->session->set_flashdata('toast-success', __("Recurring Expense has been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to update item."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {

			$data['title'] = __("Edit Recurring Expense");
			$data['modal'] = 'admin/expenses/recurring/edit';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}




	public function delete($id=0)
	{
        enforce_permission('recurringexp-delete');

		$data['recurring_expense'] = $this->recurring_expense->get($id);

		if($this->input->method() === 'post') {

			$result = $this->recurring_expense->delete($id);

			if($result) {
                log_staff('Recurring Expense deleted ' . $id);

				$this->session->set_flashdata('toast-success', __("Recurring Expense has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete recurring expense."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			$data['title'] = __("Delete Recurring Expense");
			$data['modal'] = 'admin/expenses/recurring/delete';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}




	public function download_file($id=0)
	{
        enforce_permission('recurringexp-view');
        log_staff('Recurring Expense file downloaded ' . $id);

        
		$data['recurring_expense'] = $this->recurring_expense->get($id);

		force_download("./filestore/main/recurring_expenses/" . $data['recurring_expense']['file'], NULL);
	}




















}
