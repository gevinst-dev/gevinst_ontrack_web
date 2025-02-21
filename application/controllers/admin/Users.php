<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('admin/user_model', 'user');
		$this->load->model('admin/client_model', 'client');
		$this->load->model('admin/setting_model', 'setting');
		$this->load->library('datatables');
	}


	public function json_all() {

        enforce_permission('users-view');

		$this->datatables
			->select('core_users.id, core_users.name, core_users.email, core_users.status, core_users.designation')
			->from('core_users')

			->join('app_clients', 'core_users.client_id = app_clients.id', 'LEFT')
			->select('app_clients.name as client_name')

			->edit_column_if('status', '<span class="label label-inverse-danger">'.__("Inactive").'</span>', '', 'Inactive')
			->edit_column_if('status', '<span class="label label-inverse-success">'.__("Active").'</span>', '', 'Active')
			->add_column(
				'actions',
				'<div class="btn-group" role="group">'.
					'<button data-modal="admin/users/edit/$1" data-toggle="tooltip" title="'.__("Edit User").'" type="button" class="btn btn-success btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-edit"></i></button>'.
					'<button data-modal="admin/users/delete/$1" data-toggle="tooltip" title="'.__("Delete User").'" type="button" class="btn btn-danger btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-trash"></i></button>'.
				'</div>',
				'id'
			);

		echo $this->datatables->generate();
	}

	public function index()
	{
        enforce_permission('users-view');

		$data['title'] = __("Users");
		$data['page'] = 'admin/users/list';



		$this->load->view('admin/layout_page', html_escape($data));
	}


	public function add()
	{

        enforce_permission('users-add');


		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('name', __('Name'), 'trim|required');
			$this->form_validation->set_rules('email', __('Email Address'), 'trim|valid_email|is_unique[core_users.email]|required');
			$this->form_validation->set_rules('password', __('Password'), 'min_length[8]|required');
			$this->form_validation->set_rules('password_confirm', __('Password Confirmation'), 'required|matches[password]');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect(base_url('admin/users'));
			} else {

				$db_data = array(
					'status' => $this->input->post('status'),
					'client_id' => $this->input->post('client_id'),
					'language_id' => $this->setting->get('default_language_id'),
					'email' => strtolower($this->input->post('email')),
					'name' => $this->input->post('name'),
					'designation' => $this->input->post('designation'),
					'password' =>  password_hash($this->input->post('password'), PASSWORD_BCRYPT),
					'password_reset_key' => '',

                    'permission_assets' => $this->input->post('permission_assets'),
                    'permission_licenses' => $this->input->post('permission_licenses'),
                    'permission_domains' => $this->input->post('permission_domains'),
                    'permission_credentials' => $this->input->post('permission_credentials'),
                    'permission_projects' => $this->input->post('permission_projects'),
                    'permission_tickets' => $this->input->post('permission_tickets'),
                    'permission_issues' => $this->input->post('permission_issues'),
                    'permission_kb' => $this->input->post('permission_kb'),
                    'permission_ducumentation' => $this->input->post('permission_ducumentation'),
                    'permission_invoices' => $this->input->post('permission_invoices'),
                    'permission_proformas' => $this->input->post('permission_proformas'),
                    'permission_proposals' => $this->input->post('permission_proposals'),
                    'permission_receipts' => $this->input->post('permission_receipts'),
                    'permission_profile' => $this->input->post('permission_profile'),
                    'permission_client' => $this->input->post('permission_client'),

                    


					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->user->add($db_data);

				if($result) {
                    log_staff('User added ' . $result);
					$this->session->set_flashdata('toast-success', __("User has been successfully added."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to add user."));
				}

				redirect(base_url('admin/users'));

			}

		} else {
			$data['title'] = __("Add User");
			$data['modal'] = 'admin/users/add';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function edit($id=0)
	{

        enforce_permission('users-edit');

		$data['user'] = $this->user->get($id);
		$data['client'] = $this->client->get($data['user']['client_id']);
		$data['languages'] = $this->setting->get_languages();

		if($this->input->method() === 'post') {

			$this->form_validation->set_rules('name', __('Name'), 'trim|required');


			if($this->input->post('email') != $data['user']['email']) {
				$this->form_validation->set_rules('email', __('Email Address'), 'trim|valid_email|is_unique[core_users.email]|required');
			} else {
				$this->form_validation->set_rules('email', __('Email Address'), 'trim|valid_email|required');
			}

			if($this->input->post('password') != "") {
				$this->form_validation->set_rules('password', __('Password'), 'min_length[8]|required');
				$this->form_validation->set_rules('password_confirm', __('Password Confirmation'), 'required|matches[password]');
			}

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect(base_url('admin/users'));
			} else {

				$db_data = array(
					'client_id' => $this->input->post('client_id'),
					'status' => $this->input->post('status'),
					'language_id' => $this->input->post('language_id'),
					'email' => strtolower($this->input->post('email')),
					'name' => $this->input->post('name'),
					'designation' => $this->input->post('designation'),

                    'permission_assets' => $this->input->post('permission_assets'),
                    'permission_licenses' => $this->input->post('permission_licenses'),
                    'permission_domains' => $this->input->post('permission_domains'),
                    'permission_credentials' => $this->input->post('permission_credentials'),
                    'permission_projects' => $this->input->post('permission_projects'),
                    'permission_tickets' => $this->input->post('permission_tickets'),
                    'permission_issues' => $this->input->post('permission_issues'),
                    'permission_kb' => $this->input->post('permission_kb'),
                    'permission_ducumentation' => $this->input->post('permission_ducumentation'),
                    'permission_invoices' => $this->input->post('permission_invoices'),
                    'permission_proformas' => $this->input->post('permission_proformas'),
                    'permission_proposals' => $this->input->post('permission_proposals'),
                    'permission_receipts' => $this->input->post('permission_receipts'),
                    'permission_profile' => $this->input->post('permission_profile'),
                    'permission_client' => $this->input->post('permission_client'),

                    
					'updated_at' => date('Y-m-d H:i:s'),
				);


				if($this->input->post('password') != "") {
					$db_data['password'] = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
				}

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->user->edit($db_data, $id);

				if($result) {
                    log_staff('User edited ' . $id);


					$this->session->set_flashdata('toast-success', __("User has been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to update user."));
				}

				redirect(base_url('admin/users'));

			}

		} else {
			$data['title'] = __("Edit User");
			$data['modal'] = 'admin/users/edit';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function delete($id=0)
	{
        enforce_permission('users-delete');

		$data['user'] = $this->user->get($id);

		if($this->input->method() === 'post') {

			$result = $this->user->delete($id);

			if($result) {
                log_staff('User deleted ' . $id);

				$this->session->set_flashdata('toast-success', __("User has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete user."));
			}

			redirect(base_url('admin/users'));

		} else {
			$data['title'] = __("Delete User");
			$data['modal'] = 'admin/users/delete';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}





}
