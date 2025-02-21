<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customfields extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('admin/customfield_model', 'customfield');

		$this->load->model('admin/setting_model', 'setting');
		$this->load->library('datatables');
	}



	public function json_all() {
        enforce_permission('cf-view');

		$this->datatables
			->select('id, for, type, name')
			->from('app_customfields')


			->add_column(
				'actions',
				'<div class="btn-group" role="group">'.

					'<button data-modal="admin/setup/customfields/edit/$1" data-toggle="tooltip" title="'.__("Edit Reminder").'" type="button" class="btn btn-success btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-edit"></i></button>'.
					'<button data-modal="admin/setup/customfields/delete/$1" data-toggle="tooltip" title="'.__("Delete Reminder").'" type="button" class="btn btn-danger btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-trash"></i></button>'.
				'</div>',
				'id'
			);

		$results = $this->datatables->generate('json');
		$results = json_decode($results, TRUE);

		foreach($results['data'] as $key => $value) {

			$results['data'][$key]['for'] = __($value['for']);
			$results['data'][$key]['type'] = __($value['type']);
		}

		echo json_encode($results);
	}



	public function index()
	{
        enforce_permission('cf-view');
		$data['title'] = __("Custom Fields");
		$data['page'] = 'admin/setup/customfields/list';

		$this->load->view('admin/layout_page', html_escape($data));
	}


	public function add()
	{
        enforce_permission('cf-add');

		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('for', __('For'), 'trim|required');
			$this->form_validation->set_rules('type', __('Type'), 'trim|required');
			$this->form_validation->set_rules('name', __('Name'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {

				$db_data = array(
					'for' => $this->input->post('for'),
					'type' => $this->input->post('type'),
					'name' => $this->input->post('name'),
					'description' => $this->input->post('description'),
					'options' => $this->input->post('options'),
					'required' => $this->input->post('required'),
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->customfield->add($db_data);

				if($result) {
                    log_staff('Custom field added ' . $result);

					$this->session->set_flashdata('toast-success', __("Custom field has been successfully added."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to add custom field."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$data['title'] = __("Add Custom Field");
			$data['modal'] = 'admin/setup/customfields/add';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function edit($id=0)
	{
        enforce_permission('cf-edit');

		$data['customfield'] = $this->customfield->get($id);


		if($this->input->method() === 'post') {

			$this->form_validation->set_rules('for', __('For'), 'trim|required');
			$this->form_validation->set_rules('type', __('Type'), 'trim|required');
			$this->form_validation->set_rules('name', __('Name'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {

				$db_data = array(
					'for' => $this->input->post('for'),
					'type' => $this->input->post('type'),
					'name' => $this->input->post('name'),
					'description' => $this->input->post('description'),
					'options' => $this->input->post('options'),
					'required' => $this->input->post('required'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->customfield->edit($db_data, $id);

				if($result) {
                    log_staff('Custom field edited ' . $id);

					$this->session->set_flashdata('toast-success', __("Custom field has been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to update custom field."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$data['title'] = __("Edit Custom Field");
			$data['modal'] = 'admin/setup/customfields/edit';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}



	public function delete($id=0)
	{
        enforce_permission('cf-delete');

		$data['customfield'] = $this->customfield->get($id);

		if($this->input->method() === 'post') {

			$result = $this->customfield->delete($id);

			if($result) {
                log_staff('Custom field deleted ' . $id);

				$this->session->set_flashdata('toast-success', __("Custom field has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete custom field."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			$data['title'] = __("Delete Custom Field");
			$data['modal'] = 'admin/setup/customfields/delete';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}



}
