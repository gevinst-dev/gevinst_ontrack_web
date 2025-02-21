<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Expenses extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('admin/expense_model', 'expense');

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

        enforce_permission('expenses-view');

		$where = [];

		if($_SESSION['filter_start'] != "") $where['date >='] = $_SESSION['filter_start'];
        if($_SESSION['filter_end'] != "") $where['date <='] = $_SESSION['filter_end'];

		if($_SESSION['filter_entity_id'] != "") { $where['app_expenses.entity_id'] = $_SESSION['filter_entity_id']; }
		if($_SESSION['filter_supplier_id'] != "") { $where['app_expenses.supplier_id'] = $_SESSION['filter_supplier_id']; }
		if($_SESSION['filter_expense_category_id'] != "") { $where['app_expenses.category_id'] = $_SESSION['filter_expense_category_id']; }


		$this->datatables
			->select('app_expenses.id, app_expenses.currency_id, app_expenses.date, app_expenses.total, app_expenses.description, app_expenses.status, app_expenses.file')
			->from('app_expenses')

			->where($where)

			->edit_column_if('status', '<span class="label label-inverse-danger">'.__("Canceled").'</span>', '', 'Canceled')
			->edit_column_if('status', '<span class="label label-inverse-success">'.__("Valid").'</span>', '', 'Valid')
            ->edit_column_if('status', '<span class="label label-inverse-primary">'.__("Draft").'</span>', '', 'Draft')

			->edit_column('file', '<a href="'.base_url('admin/expenses/expenses/download_file/').'$1">$2</a>', 'id,file')

			->join('app_entities', 'app_expenses.entity_id = app_entities.id', 'LEFT')
			->select('app_entities.title as entity_name')

			->join('app_suppliers', 'app_expenses.supplier_id = app_suppliers.id', 'LEFT')
			->select('app_suppliers.name as supplier_name')

			->join('app_projects', 'app_expenses.project_id = app_projects.id', 'LEFT')
			->select('app_projects.name as project_name')

			->join('app_expense_categories', 'app_expenses.category_id = app_expense_categories.id', 'LEFT')
			->select('app_expense_categories.name as category_name')


            ->add_column(
				'actions',
				'<div class="btn-group" role="group">'.
                    '<button data-modal="admin/expenses/expenses/edit/$1" data-toggle="tooltip" title="'.__("Edit Expense").'" type="button" class="btn btn-success btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-edit"></i></button>'.
					'<button data-modal="admin/expenses/expenses/delete/$1" data-toggle="tooltip" title="'.__("Delete Expense").'" type="button" class="btn btn-danger btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-trash"></i></button>'.
                '</div>',
				'id'
			);



        $results = $this->datatables->generate('json');
        $results = json_decode($results, TRUE);

        foreach($results['data'] as $key => $value) {

            $results['data'][$key]['date'] = date_display($value['date']);



            $results['data'][$key]['total'] = format_currency($value['total'], $value['currency_id']);
        }

        echo json_encode($results);

	}



	public function index()
	{
        enforce_permission('expenses-view');

		$data['title'] = __("Expenses");
		$data['page'] = 'admin/expenses/expenses/list';

		$data['entities'] = $this->db->get('app_entities')->result_array();
		$data['suppliers'] = $this->db->get('app_suppliers')->result_array();
		$data['projects'] = $this->db->get('app_projects')->result_array();
		$data['expense_categories'] = $this->db->get('app_expense_categories')->result_array();

		$this->load->view('admin/layout_page', html_escape($data));
	}


	public function add()
	{
        enforce_permission('expenses-add');

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

				$rate = exrate_latest($this->input->post('currency_id'));

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
					'rate' => $rate,
					'description' => $this->input->post('description'),
					'date' => date_to_db($this->input->post('date')),
					'status' => $this->input->post('status'),


					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);


				$config['upload_path']                = './filestore/main/expenses/';
				$config['allowed_types']              = 'gif|jpg|png|jpeg|pdf';
				$config['file_ext_tolower']           = TRUE;
				$config['max_filename_increment']     = 1000;
				$this->load->library('upload', $config);

				if(!empty($_FILES['userfile']['name'])) {
					if(!$this->upload->do_upload('userfile')) { $this->session->set_flashdata('toast-error', __("Error uploading! Check file type or size.")); redirect($_SERVER['HTTP_REFERER']); }
					$db_data['file'] = $this->upload->data('file');
				}

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->expense->add($db_data);

				if($result) {
                    log_staff('Expense added ' . $result);

					$this->session->set_flashdata('toast-success', __("Expense has been successfully added."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to add item."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$data['title'] = __("Add Expense");
			$data['modal'] = 'admin/expenses/expenses/add';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}



	public function edit($id=0)
	{
        enforce_permission('expenses-edit');

		$data['expense'] = $this->expense->get($id);

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
					'rate' => $this->input->post('rate'),
					'description' => $this->input->post('description'),
					'date' => date_to_db($this->input->post('date')),
					'status' => $this->input->post('status'),

					'updated_at' => date('Y-m-d H:i:s'),
				);

				$config['upload_path']                = './filestore/main/expenses/';
				$config['allowed_types']              = 'gif|jpg|png|jpeg|pdf';
				$config['file_ext_tolower']           = TRUE;
				$config['max_filename_increment']     = 1000;
				$this->load->library('upload', $config);

				if(!empty($_FILES['userfile']['name'])) {
					if(!$this->upload->do_upload('userfile')) { $this->session->set_flashdata('toast-error', __("Error uploading! Check file type or size.")); redirect($_SERVER['HTTP_REFERER']); }
					$db_data['file'] = $this->upload->data('file_name');
				}

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->expense->edit($db_data, $id);

				if($result) {
                    log_staff('Expense edited ' . $id);

					$this->session->set_flashdata('toast-success', __("Expense has been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to update item."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {

			$data['title'] = __("Edit Expense");
			$data['modal'] = 'admin/expenses/expenses/edit';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}




	public function delete($id=0)
	{
        enforce_permission('expenses-delete');

		$data['expense'] = $this->expense->get($id);

		if($this->input->method() === 'post') {

			$result = $this->expense->delete($id);

			if($result) {
                log_staff('Expense deleted ' . $id);

				$this->session->set_flashdata('toast-success', __("Expense has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete expense."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			$data['title'] = __("Delete Expense");
			$data['modal'] = 'admin/expenses/expenses/delete';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}




	public function download_file($id=0)
	{
        enforce_permission('expenses-view');
        log_staff('Expense file downloaded ' . $id);

        
		$data['expense'] = $this->expense->get($id);

		force_download("./filestore/main/expenses/" . $data['expense']['file'], NULL);
	}




















}
