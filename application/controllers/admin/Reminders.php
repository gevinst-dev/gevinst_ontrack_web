<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reminders extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('admin/reminder_model', 'reminder');
		$this->load->model('admin/staff_model', 'staff');
		$this->load->model('admin/client_model', 'client');
		$this->load->model('admin/setting_model', 'setting');
		$this->load->library('datatables');
	}



	public function json_all() {
        enforce_permission('reminders-view');

		$this->datatables
			->select('app_reminders.id, app_reminders.description, app_reminders.status, app_reminders.datetime')
			->from('app_reminders')

			->join('core_staff', 'app_reminders.assigned_to = core_staff.id', 'LEFT')
			->select('core_staff.name as assigned_to')

			->join('app_clients', 'app_reminders.client_id = app_clients.id', 'LEFT')
			->select('app_clients.name as client_name')

			->edit_column_if('status', '<span class="label label-danger">'.__("Upcoming").'</span>', '', 'Upcoming')
			->edit_column_if('status', '<span class="label label-success">'.__("Reminded").'</span>', '', 'Reminded')



			->add_column(
				'actions',
				'<div class="btn-group" role="group">'.

					'<button data-modal="admin/reminders/edit/$1" data-toggle="tooltip" title="'.__("Edit Reminder").'" type="button" class="btn btn-success btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-edit"></i></button>'.
					'<button data-modal="admin/reminders/delete/$1" data-toggle="tooltip" title="'.__("Delete Reminder").'" type="button" class="btn btn-danger btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-trash"></i></button>'.
				'</div>',
				'id'
			);

		$results = $this->datatables->generate('json');
		$results = json_decode($results, TRUE);

		foreach($results['data'] as $key => $value) {

			$results['data'][$key]['datetime'] = datetime_display($value['datetime']);

		}

		echo json_encode($results);
	}



	public function index()
	{
        enforce_permission('reminders-view');

		$data['title'] = __("Reminders");
		$data['page'] = 'admin/reminders/list';

		$this->load->view('admin/layout_page', html_escape($data));
	}


	public function add()
	{

        enforce_permission('reminders-add');

		$data['staff'] = $this->staff->get_all_active();

		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('assigned_to', __('Assigned To'), 'trim|required');
			$this->form_validation->set_rules('description', __('Description'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {

				$db_data = array(
					'added_by' => $this->session->staff_id,
					'assigned_to' => $this->input->post('assigned_to'),
					'client_id' => $this->input->post('client_id'),
                    'notify_client' => $this->input->post('notify_client'),
					'status' => "Upcoming",
					'description' => $this->input->post('description'),
					'datetime' => datetime_hi_to_db($this->input->post('datetime')),
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->reminder->add($db_data);

				if($result) {
                    log_staff('Reminder added ' . $result);

					$this->session->set_flashdata('toast-success', __("Reminder has been successfully added."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to add reminder."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$data['title'] = __("Add Reminder");
			$data['modal'] = 'admin/reminders/add';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function edit($id=0)
	{
        enforce_permission('reminders-edit');

		$data['reminder'] = $this->reminder->get($id);
		$data['staff'] = $this->staff->get_all_active();

		$data['client'] = $this->client->get($data['reminder']['client_id']);

		if($this->input->method() === 'post') {

			$this->form_validation->set_rules('assigned_to', __('Assigned To'), 'trim|required');
			$this->form_validation->set_rules('description', __('Description'), 'trim|required');


			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {

				$db_data = array(
					'assigned_to' => $this->input->post('assigned_to'),
					'client_id' => $this->input->post('client_id'),
                    'notify_client' => $this->input->post('notify_client'),
					'description' => $this->input->post('description'),
					'status' => $this->input->post('status'),
					'datetime' => datetime_hi_to_db($this->input->post('datetime')),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->reminder->edit($db_data, $id);

				if($result) {
                    log_staff('Reminder edited ' . $id);

					$this->session->set_flashdata('toast-success', __("Reminder has been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to update reminder."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$data['title'] = __("Edit Reminder");
			$data['modal'] = 'admin/reminders/edit';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}



	public function delete($id=0)
	{
        enforce_permission('reminders-delete');

		$data['reminder'] = $this->reminder->get($id);

		if($this->input->method() === 'post') {

			$result = $this->reminder->delete($id);

			if($result) {
                log_staff('Reminder deleted ' . $id);

				$this->session->set_flashdata('toast-success', __("Reminder has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete reminder."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			$data['title'] = __("Delete Reminder");
			$data['modal'] = 'admin/reminders/delete';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}



}
