<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Roles extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('admin/role_model', 'role');
		$this->load->library('datatables');
	}


	public function json_all() {
        enforce_permission('roles-view');

		$this->datatables
			->select('id, name')
			->from('core_roles')
			->add_column(
				'actions',
				'<div class="btn-group" role="group">'.
					'<a href="'.base_url('admin/setup/roles/edit/').'$1" data-toggle="tooltip" title="'.__("Edit Role").'" type="button" class="btn btn-success btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-edit"></i></a>'.
					'<button data-modal="admin/setup/roles/delete/$1" data-toggle="tooltip" title="'.__("Delete Role").'" type="button" class="btn btn-danger btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-trash"></i></button>'.
				'</div>',
				'id'
			);

		echo $this->datatables->generate();
	}

	public function index()
	{
        enforce_permission('roles-view');
		$data['title'] = __("Roles");
		$data['page'] = 'admin/setup/roles/list';



		$this->load->view('admin/layout_page', html_escape($data));
	}


	public function add()
	{
        enforce_permission('roles-add');
		$data['permissions'] = array();

		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('name', __('Name'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect(base_url('admin/setup/roles'));
			} else {

				$db_data = array(
					'name' => $this->input->post('name'),
					'permissions' => serialize($this->input->post('permissions')),
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->role->add($db_data);

				if($result) {
                    log_staff('Role added ' . $result);

					$this->session->set_flashdata('toast-success', __("Role has been successfully added."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to add role."));
				}

				redirect(base_url('admin/setup/roles'));

			}

		} else {
			$data['title'] = __("Add Role");
			$data['page'] = 'admin/setup/roles/add';

			$this->load->view('admin/layout_page', html_escape($data));
		}

	}

	public function edit($id=0)
	{
        enforce_permission('roles-edit');

		$data['role'] = $this->role->get($id);
		$data['permissions'] = unserialize($data['role']['permissions']);

		if($this->input->method() === 'post') {

			$this->form_validation->set_rules('name', __('Name'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect(base_url('admin/setup/roles/edit/'.$id));
			} else {

				$db_data = array(
					'name' => $this->input->post('name'),
					'permissions' => serialize($this->input->post('permissions')),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->role->edit($db_data, $id);

				if($result) {
                    log_staff('Role edited ' . $id);

					$this->session->set_flashdata('toast-success', __("Role has been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to update role."));
				}

				redirect(base_url('admin/setup/roles/edit/'.$id));

			}

		} else {
			$data['title'] = __("Edit Role");
			$data['page'] = 'admin/setup/roles/edit';

			$this->load->view('admin/layout_page', html_escape($data));
		}

	}

	public function delete($id=0)
	{
        enforce_permission('roles-delete');

		$data['role'] = $this->role->get($id);

		if($this->input->method() === 'post') {

			$result = $this->role->delete($id);

			if($result) {
                log_staff('Role deleted ' . $id);

				$this->session->set_flashdata('toast-success', __("Role has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete role."));
			}

			redirect(base_url('admin/setup/roles'));

		} else {
			$data['title'] = __("Delete Role");
			$data['modal'] = 'admin/setup/roles/delete';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}





}
