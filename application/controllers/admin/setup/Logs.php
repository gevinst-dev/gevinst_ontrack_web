<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logs extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();


		$this->load->library('datatables');

        enforce_permission('logs');

	}


	public function json_all_staff_activity() {
		$this->datatables
			->select('core_staff_activity_log.id, ip_address, description, core_staff_activity_log.created_at')
			->from('core_staff_activity_log')
			->join('core_staff', 'core_staff_activity_log.staff_id = core_staff.id', 'LEFT')
			->select('core_staff.name as name')
			;

		echo $this->datatables->generate();
	}


	public function json_all_users_activity() {
		$this->datatables
			->select('core_user_activity_log.id, ip_address, description, core_user_activity_log.created_at')
			->from('core_user_activity_log')
			->join('core_users', 'core_user_activity_log.user_id = core_users.id', 'LEFT')
			->select('core_users.name as name')
			;

		echo $this->datatables->generate();
	}

	public function json_all_emails() {
		$this->datatables
			->select('core_emails.id, email_address, subject, sent, core_emails.created_at')
			->from('core_emails')
			->join('core_users', 'core_emails.user_id = core_users.id', 'LEFT')
			->select('core_users.name as username')
			->join('core_staff', 'core_emails.staff_id = core_staff.id', 'LEFT')
			->select('core_staff.name as staffname')
			->edit_column_if('sent', '<span class="label label-danger">'.__("No").'</span>', '', 'No')
			->edit_column_if('sent', '<span class="label label-success">'.__("Yes").'</span>', '', 'Yes')
			->edit_column_if('sent', '<span class="label label-info">'.__("Pending").'</span>', '', 'Pending')
			;

		echo $this->datatables->generate();
	}

	public function index()
	{
		redirect(base_url('admin/setup/logs/staff_activity'));
	}


	public function staff_activity()
	{
		$data['title'] = __("Staff Activity Log");
		$data['page'] = 'admin/setup/logs/index';
		$data['section'] = "staff_activity";


		$this->load->view('admin/layout_page', html_escape($data));
	}

	public function user_activity()
	{
		$data['title'] = __("User Activity Log");
		$data['page'] = 'admin/setup/logs/index';
		$data['section'] = "user_activity";

		$this->load->view('admin/layout_page', html_escape($data));
	}

	public function email_log()
	{
		$data['title'] = __("Email Log");
		$data['page'] = 'admin/setup/logs/index';
		$data['section'] = "email_log";

		$this->load->view('admin/layout_page', html_escape($data));
	}


}
