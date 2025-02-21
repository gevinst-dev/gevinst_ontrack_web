<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Staff extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('admin/staff_model', 'staff');
		$this->load->model('admin/role_model', 'role');
		$this->load->model('admin/setting_model', 'setting');
		$this->load->library('datatables');
	}


	public function json_all() {
        enforce_permission('staff-view');

		$this->datatables
			->select('core_staff.id, core_staff.name, email, status')
			->from('core_staff')
			->join('core_roles', 'core_staff.role_id = core_roles.id', 'LEFT')
			->select('core_roles.name as role_name')
			->edit_column_if('status', '<span class="label label-inverse-danger">'.__("Inactive").'</span>', '', 'Inactive')
			->edit_column_if('status', '<span class="label label-inverse-success">'.__("Active").'</span>', '', 'Active')
			->add_column(
				'actions',
				'<div class="btn-group" role="group">'.
					'<button data-modal="admin/setup/staff/edit/$1" data-toggle="tooltip" title="'.__("Edit Staff Account").'" type="button" class="btn btn-success btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-edit"></i></button>'.
					'<button data-modal="admin/setup/staff/delete/$1" data-toggle="tooltip" title="'.__("Delete Staff Account").'" type="button" class="btn btn-danger btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-trash"></i></button>'.
				'</div>',
				'id'
			);

		echo $this->datatables->generate();
	}

	public function index()
	{
        enforce_permission('staff-view');
		$data['title'] = __("Staff");
		$data['page'] = 'admin/setup/staff/list';



		$this->load->view('admin/layout_page', html_escape($data));
	}


	public function add()
	{
        enforce_permission('staff-add');
		$data['roles'] = $this->role->get_all();

		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('role_id', __('Role'), 'trim|required');
			$this->form_validation->set_rules('status', __('Status'), 'trim|required');
			$this->form_validation->set_rules('name', __('Name'), 'trim|required');
			$this->form_validation->set_rules('email', __('Email Address'), 'trim|valid_email|is_unique[core_staff.email]|required');
			$this->form_validation->set_rules('password', __('Password'), 'min_length[8]|required');
			$this->form_validation->set_rules('password_confirm', __('Password Confirmation'), 'required|matches[password]');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect(base_url('admin/setup/staff'));
			} else {

				$db_data = array(
					'role_id' => $this->input->post('role_id'),
					'language_id' => $this->setting->get('default_language_id'),
					'status' => $this->input->post('status'),
					'email' => strtolower($this->input->post('email')),
					'name' => $this->input->post('name'),
					'password' =>  password_hash($this->input->post('password'), PASSWORD_BCRYPT),
					'password_reset_key' => '',
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->staff->add($db_data);

				if($result) {
                    log_staff('Staff added ' . $result);

					$this->session->set_flashdata('toast-success', __("Staff account has been successfully added."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to add staff account."));
				}

				redirect(base_url('admin/setup/staff'));

			}

		} else {
			$data['title'] = __("Add Staff Account");
			$data['modal'] = 'admin/setup/staff/add';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function edit($id=0)
	{
        enforce_permission('staff-edit');

		$data['staff'] = $this->staff->get($id);
		$data['languages'] = $this->setting->get_languages();
		$data['roles'] = $this->role->get_all();

		if($this->input->method() === 'post') {

			$this->form_validation->set_rules('role_id', __('Role'), 'trim|required');
			$this->form_validation->set_rules('status', __('Status'), 'trim|required');
			$this->form_validation->set_rules('name', __('Name'), 'trim|required');


			if($this->input->post('email') != $data['staff']['email']) {
				$this->form_validation->set_rules('email', __('Email Address'), 'trim|valid_email|is_unique[core_staff.email]|required');
			} else {
				$this->form_validation->set_rules('email', __('Email Address'), 'trim|valid_email|required');
			}

			if($this->input->post('password') != "") {
				$this->form_validation->set_rules('password', __('Password'), 'min_length[8]|required');
				$this->form_validation->set_rules('password_confirm', __('Password Confirmation'), 'required|matches[password]');
			}


			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect(base_url('admin/setup/staff'));
			} else {

				$db_data = array(
					'role_id' => $this->input->post('role_id'),
					'language_id' => $this->input->post('language_id'),
					'status' => $this->input->post('status'),
					'email' => strtolower($this->input->post('email')),
					'name' => $this->input->post('name'),
					'updated_at' => date('Y-m-d H:i:s'),
				);


				if($this->input->post('password') != "") {
					$db_data['password'] = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
				}

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->staff->edit($db_data, $id);

				if($result) {
                    log_staff('Staff edited ' . $id);

					$this->session->set_flashdata('toast-success', __("Staff account has been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to update staff account."));
				}

				redirect(base_url('admin/setup/staff'));

			}

		} else {
			$data['title'] = __("Edit Staff Account");
			$data['modal'] = 'admin/setup/staff/edit';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function delete($id=0)
	{
        enforce_permission('staff-delete');

		$data['staff'] = $this->staff->get($id);

		if($this->input->method() === 'post') {

			$result = $this->staff->delete($id);

			if($result) {
                log_staff('Staff deleted ' . $id);

				$this->session->set_flashdata('toast-success', __("Staff account has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete staff account."));
			}

			redirect(base_url('admin/setup/staff'));

		} else {
			$data['title'] = __("Delete Staff Account");
			$data['modal'] = 'admin/setup/staff/delete';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}





}
