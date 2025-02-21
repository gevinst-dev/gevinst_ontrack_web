<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Suppliers extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('admin/supplier_model', 'supplier');
		$this->load->model('admin/staff_model', 'staff');
		$this->load->library('datatables');
	}


	public function json_all() {
        enforce_permission('suppliers-view');

		$this->datatables
			->select('app_suppliers.id, app_suppliers.name, app_suppliers.email, app_suppliers.phone, app_suppliers.web_address')

			->from('app_suppliers')


			->edit_column('name', '<a href="'.base_url('admin/expenses/suppliers/details/').'$1">$2</a>', 'id,name')
			->add_column(
				'actions',
				'<div class="btn-group" role="group">'.
					'<a href="'.base_url('admin/expenses/suppliers/details/').'$1" data-toggle="tooltip" title="'.__("View Supplier").'" type="button" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-eye"></i></a>'.

					'<button data-modal="admin/expenses/suppliers/delete/$1" data-toggle="tooltip" title="'.__("Delete Supplier").'" type="button" class="btn btn-danger btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-trash"></i></button>'.
				'</div>',
				'id'
			);

		echo $this->datatables->generate('json');

	}



	public function json_expenses($id=0) {
        
        enforce_permission('expenses-view');
	

		$this->datatables
			->select('app_expenses.id, app_expenses.currency_id, app_expenses.date, app_expenses.total, app_expenses.description, app_expenses.status, app_expenses.file')
			->from('app_expenses')

			->where('app_expenses.supplier_id', $id)

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



	public function json_recurring_expenses($id) {

        enforce_permission('recurringexp-view');

		$this->datatables
			->select('app_recurring_expenses.id, app_recurring_expenses.currency_id, app_recurring_expenses.total, app_recurring_expenses.description, app_recurring_expenses.file, app_recurring_expenses.frequency, app_recurring_expenses.emissions, app_recurring_expenses.next_date, app_recurring_expenses.status')
			->from('app_recurring_expenses')

			->where('app_recurring_expenses.supplier_id', $id)


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
        enforce_permission('suppliers-view');

		$data['title'] = __("Suppliers");
		$data['page'] = 'admin/expenses/suppliers/list';

		$this->load->view('admin/layout_page', html_escape($data));
	}


	public function add()
	{
        enforce_permission('suppliers-add');
		$data['staff'] = $this->staff->get_all();

		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('name', __('Name'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {

				$db_data = array(
					'name' => $this->input->post('name'),
					'contact_name' => $this->input->post('contact_name'),
					'phone' => $this->input->post('phone'),
					'email' => $this->input->post('email'),
					'web_address' => $this->input->post('web_address'),
					'address' => $this->input->post('address'),
					'notes' => '',
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->supplier->add($db_data);


				if($result) {
                    log_staff('Supplier added ' . $result);

					$this->session->set_flashdata('toast-success', __("Supplier has been successfully added."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to add supplier."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$data['title'] = __("Add Supplier");
			$data['modal'] = 'admin/expenses/suppliers/add';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}



	public function edit($id=0)
	{
        enforce_permission('suppliers-edit');

		$data['staff'] = $this->staff->get_all();
		$data['supplier'] = $this->supplier->get($id);

		if($this->input->method() === 'post') {

			$this->form_validation->set_rules('name', __('Name'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {

				$db_data = array(
					'name' => $this->input->post('name'),
					'contact_name' => $this->input->post('contact_name'),
					'phone' => $this->input->post('phone'),
					'email' => $this->input->post('email'),
					'web_address' => $this->input->post('web_address'),
					'address' => $this->input->post('address'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->supplier->edit($db_data, $id);

				if($result) {
                    log_staff('Supplier edited ' . $id);

					$this->session->set_flashdata('toast-success', __("Supplier has been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to update supplier."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			redirect($_SERVER['HTTP_REFERER']);
		}

	}


	public function edit_notes($id=0)
	{
        enforce_permission('suppliers-edit');

		$data['supplier'] = $this->supplier->get($id);

		if($this->input->method() === 'post') {

			$db_data = array(
				'notes' => $this->input->post('notes'),
				'updated_at' => date('Y-m-d H:i:s'),
			);

			$db_data = $this->security->xss_clean($db_data);
			$result = $this->supplier->edit($db_data, $id);

			if($result) {
                log_staff('Supplier notes edited ' . $id);

				$this->session->set_flashdata('toast-success', __("Supplier has been successfully updated."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to update supplier."));
			}

		}

		redirect($_SERVER['HTTP_REFERER']);
	}




	public function delete($id=0)
	{
        enforce_permission('suppliers-delete');

		$data['supplier'] = $this->supplier->get($id);

		if($this->input->method() === 'post') {

			$result = $this->supplier->delete($id);

			if($result) {
                log_staff('Supplier deleted ' . $id);

				$this->session->set_flashdata('toast-success', __("Supplier has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete supplier."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			$data['title'] = __("Delete Supplier");
			$data['modal'] = 'admin/expenses/suppliers/delete';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function details($id=0)
	{
        enforce_permission('suppliers-view');

		$data['supplier'] = $this->supplier->get($id);
		$data['files'] = $this->supplier->get_files($id);
		$data['addresses'] = $this->supplier->get_addresses($id);
		$data['comments'] = $this->supplier->get_comments($id);

		$data['staff'] = $this->staff->get_all();

		$data['title'] = __("Manage Supplier");
		$data['section'] = 'details';
		$data['page'] = 'admin/expenses/suppliers/index';


		$this->load->view('admin/layout_page', html_escape($data));
	}


	public function expenses($id=0)
	{
        enforce_permission('expenses-view');

		$data['supplier'] = $this->supplier->get($id);

		$data['title'] = __("Manage Supplier");
		$data['section'] = 'expenses';
		$data['page'] = 'admin/expenses/suppliers/index';

		$this->load->view('admin/layout_page', html_escape($data));
	}


    public function recurring_expenses($id=0)
	{
        enforce_permission('recurringexp-view');

		$data['supplier'] = $this->supplier->get($id);

		$data['title'] = __("Manage Supplier");
		$data['section'] = 'recurring_expenses';
		$data['page'] = 'admin/expenses/suppliers/index';

		$this->load->view('admin/layout_page', html_escape($data));
	}



	public function notes($id=0)
	{
        enforce_permission('suppliers-view');

		$data['supplier'] = $this->supplier->get($id);

		$data['title'] = __("Manage Supplier");
		$data['section'] = 'notes';
		$data['page'] = 'admin/expenses/suppliers/index';

		$this->load->view('admin/layout_page', html_escape($data));
	}






	public function upload_file($id)
	{
        enforce_permission('suppliers-edit');

		$data['supplier'] = $this->supplier->get($id);

		if($this->input->method() === 'post') {

			$config['upload_path']                = './filestore/main/suppliers/';
			$config['allowed_types']              = 'gif|jpg|png|pdf|xls|xlsx|doc|docx|ppt|pptx|txt|zip|jpeg|rar|psd|mpg|cdr|avi|mp4|mkv|flv|7z';
			$config['file_ext_tolower']           = TRUE;
			$config['max_filename_increment']     = 1000;
			$this->load->library('upload', $config);

			if(!empty($_FILES['userfile']['name'])) {
				if(!$this->upload->do_upload('userfile')) { $this->session->set_flashdata('toast-error', __("Error uploading! Check file type or size.")); redirect($_SERVER['HTTP_REFERER']); }
			} else {
				$this->session->set_flashdata('toast-error', __("Please select a file."));
				redirect($_SERVER['HTTP_REFERER']);
				exit;
			}

			$db_data = array(
				'supplier_id' => $id,
				'added_by' => $this->session->staff_id,
				'file' => $this->upload->data('file_name'),
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
			);

			$db_data = $this->security->xss_clean($db_data);
			$result = $this->supplier->add_file($db_data);

			if($result) {
                log_staff('Supplier file added ' . $result);

				$this->session->set_flashdata('toast-success', __("File has been successfully uploaded."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to upload file."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			$data['title'] = __("Upload File");
			$data['modal'] = 'admin/expenses/suppliers/upload_file';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function delete_file($id=0)
	{
        enforce_permission('suppliers-delete');

		$data['file'] = $this->supplier->get_file($id);
		$data['supplier'] = $this->supplier->get($data['file']['supplier_id']);

		if($this->input->method() === 'post') {

			$result = $this->supplier->delete_file($id);

			unlink('./filestore/main/suppliers/'.$data['file']['file']);

			if($result) {
                log_staff('Supplier file deleted ' . $id);

				$this->session->set_flashdata('toast-success', __("File has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete file."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			$data['title'] = __("Delete File");
			$data['modal'] = 'admin/expenses/suppliers/delete_file';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function download_file($id=0)
	{
        enforce_permission('suppliers-view');

        log_staff('Supplier file downloaded ' . $id);


		$data['file'] = $this->supplier->get_file($id);
		$data['supplier'] = $this->supplier->get($data['file']['supplier_id']);


		force_download("./filestore/main/suppliers/" . $data['file']['file'], NULL);
	}








	public function add_address($id)
	{
        enforce_permission('suppliers-edit');
		$data['supplier'] = $this->supplier->get($id);

		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('name', __('Address name'), 'trim|required');
			$this->form_validation->set_rules('address', __('Address'), 'trim|required');
			$this->form_validation->set_rules('city', __('City'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {

				$db_data = array(
					'supplier_id' => $id,
					'name' => $this->input->post('name'),
					'address' => $this->input->post('address'),
					'city' => $this->input->post('city'),
					'state' => $this->input->post('state'),
					'zip_code' => $this->input->post('zip_code'),
					'country' => $this->input->post('country'),
					'phone' => $this->input->post('phone'),
					'notes' => $this->input->post('notes'),
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->supplier->add_address($db_data);

				if($result) {
                    log_staff('Supplier address added ' . $result);

					$this->session->set_flashdata('toast-success', __("Address has been successfully added."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to add address."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$data['title'] = __("Add Address");
			$data['modal'] = 'admin/expenses/suppliers/add_address';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function edit_address($id=0)
	{
        enforce_permission('suppliers-edit');


		$data['address'] = $this->supplier->get_address($id);
		$data['supplier'] = $this->supplier->get($data['address']['supplier_id']);

		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('name', __('Address name'), 'trim|required');
			$this->form_validation->set_rules('address', __('Address'), 'trim|required');
			$this->form_validation->set_rules('city', __('City'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {

				$db_data = array(
					'name' => $this->input->post('name'),
					'address' => $this->input->post('address'),
					'city' => $this->input->post('city'),
					'state' => $this->input->post('state'),
					'zip_code' => $this->input->post('zip_code'),
					'country' => $this->input->post('country'),
					'phone' => $this->input->post('phone'),
					'notes' => $this->input->post('notes'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->supplier->edit_address($db_data, $id);

				if($result) {
                    log_staff('Supplier address edited ' . $id);

					$this->session->set_flashdata('toast-success', __("Address has been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to update address."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$data['title'] = __("Edit Address");
			$data['modal'] = 'admin/expenses/suppliers/edit_address';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function delete_address($id=0)
	{
        enforce_permission('suppliers-delete');

		$data['address'] = $this->supplier->get_address($id);
		$data['supplier'] = $this->supplier->get($data['address']['supplier_id']);

		if($this->input->method() === 'post') {

			$result = $this->supplier->delete_address($id);

			if($result) {
                log_staff('Supplier address deleted ' . $id);

				$this->session->set_flashdata('toast-success', __("Address has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete address."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			$data['title'] = __("Delete Address");
			$data['modal'] = 'admin/expenses/suppliers/delete_address';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}







	public function add_comment($id)
	{
        enforce_permission('suppliers-edit');

		$data['supplier'] = $this->supplier->get($id);

		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('comment', __('Comment'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {

				$db_data = array(
					'supplier_id' => $id,
					'added_by' => $this->session->staff_id,
					'comment' => $this->input->post('comment'),
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->supplier->add_comment($db_data);

				if($result) {
                    log_staff('Supplier comment added ' . $result);

					$this->session->set_flashdata('toast-success', __("Comment has been successfully added."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to add comment."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$data['title'] = __("Add Comment");
			$data['modal'] = 'admin/expenses/suppliers/add_comment';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function edit_comment($id=0)
	{
        enforce_permission('suppliers-edit');

		$data['comment'] = $this->supplier->get_comment($id);
		$data['supplier'] = $this->supplier->get($data['comment']['supplier_id']);

		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('comment', __('Comment'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {

				$db_data = array(
					'comment' => $this->input->post('comment'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->supplier->edit_comment($db_data, $id);

				if($result) {
                    log_staff('Supplier comment edited ' . $id);

					$this->session->set_flashdata('toast-success', __("Comment has been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to update comment."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$data['title'] = __("Edit Comment");
			$data['modal'] = 'admin/expenses/suppliers/edit_comment';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function delete_comment($id=0)
	{
        enforce_permission('suppliers-delete');

		$data['comment'] = $this->supplier->get_comment($id);
		$data['supplier'] = $this->supplier->get($data['comment']['supplier_id']);

		if($this->input->method() === 'post') {

			$result = $this->supplier->delete_comment($id);

			if($result) {
                log_staff('Supplier comment deleted ' . $id);

				$this->session->set_flashdata('toast-success', __("Comment has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete comment."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			$data['title'] = __("Delete Comment");
			$data['modal'] = 'admin/expenses/suppliers/delete_comment';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}




}
