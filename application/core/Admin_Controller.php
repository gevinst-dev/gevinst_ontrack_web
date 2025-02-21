<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_Controller extends MY_Controller {


	function __construct()
	{
		parent::__construct();


		// restrict access
		if(!$this->session->has_userdata('staff_signed_in') && !$this->session->has_userdata('staff_id')) {
			$this->session->set_flashdata('toast-warning', __('Please authenticate to access this section!'));
			redirect(base_url('admin/auth/sign_in'));
		}


		$menu_data = [
			'alert_count' => 0,

			'tickets_open' => $this->db->where('status', 'Open')->from("app_tickets")->count_all_results(),
			'tickets_reopened' => $this->db->where('status', 'Reopened')->from("app_tickets")->count_all_results(),
			'tickets_inprogress' => $this->db->where('status', 'In Progress')->from("app_tickets")->count_all_results(),
			'tickets_assigned' => $this->db->where(['status !=' => 'Closed', 'assigned_to' => $this->session->staff_id ])->from("app_tickets")->count_all_results(),

			'issues_todo' => $this->db->where('status', 'To Do')->from("app_issues")->count_all_results(),
			'issues_inprogress' => $this->db->where('status', 'In Progress')->from("app_issues")->count_all_results(),

			'issues_assigned' => $this->db->where(['status' => 'To Do', 'assigned_to' => $this->session->staff_id ])->from("app_issues")->count_all_results(),

			'reminders_upcoming' => $this->db->where(['status' => 'Upcoming', 'assigned_to' => $this->session->staff_id ])->from("app_reminders")->count_all_results(),
		];

		if($menu_data['tickets_assigned'] > 0) $menu_data['alert_count']++;
		if($menu_data['issues_assigned'] > 0) $menu_data['alert_count']++;

		define('MENU_DATA', $menu_data);




		$this->session->set_userdata(['date_format' => get_setting('date_format')]);
		date_default_timezone_set(get_setting('timezone'));



        if(get_setting('db_level') < REQ_DB_LEVEL) {
            $this->upgrade->execute();
        }






	}

}
