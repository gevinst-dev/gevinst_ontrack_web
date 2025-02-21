<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Issues extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();

        enforce_permission('reports_issues-view');
		$this->load->model('admin/setting_model', 'setting');
		$this->load->model('admin/client_model', 'client');
		$this->load->model('admin/customfield_model', 'customfield');

		$this->load->library('datatables');
	}




    public function index()
	{
		$data['title'] = __("Issues Report");
		$data['page'] = 'admin/reports/issues';
        log_staff('Viewed issues report');


		$data['customfields'] = $this->customfield->get_for('Issues');

		$data['clients'] = $this->client->get_all();

		$where = [];

		if($_SESSION['filter_client_id'] != "") $where['client_id'] = $_SESSION['filter_client_id'];

		if($_SESSION['filter_start'] != "") $where['created_at >='] = $_SESSION['filter_start'];
		if($_SESSION['filter_end'] != "") $where['created_at <='] = $_SESSION['filter_end'];


		$data['items'] = $this->db->get_where('app_issues', $where)->result_array();


		$data['todo_count'] = 0;
		$data['inprogress_count'] = 0;
		$data['done_count'] = 0;

		$data['low_count'] = 0;
		$data['normal_count'] = 0;
		$data['high_count'] = 0;

		$data['task_count'] = 0;
		$data['maintenance_count'] = 0;
		$data['bug_count'] = 0;
		$data['improvement_count'] = 0;
		$data['newfeature_count'] = 0;
		$data['story_count'] = 0;

		foreach($data['items'] as $item) {
			if($item['status'] == "To Do") $data['todo_count']++;
			if($item['status'] == "In Progress") $data['inprogress_count']++;
			if($item['status'] == "Done") $data['done_count']++;

			if($item['priority'] == "Low") $data['low_count']++;
			if($item['priority'] == "Normal") $data['normal_count']++;
			if($item['priority'] == "High") $data['high_count']++;

			if($item['type'] == "Task") $data['task_count']++;
			if($item['type'] == "Maintenance") $data['maintenance_count']++;
			if($item['type'] == "Bug") $data['bug_count']++;
			if($item['type'] == "Improvement") $data['improvement_count']++;
			if($item['type'] == "New Feature") $data['newfeature_count']++;
			if($item['type'] == "Story") $data['story_count']++;
		}



		$this->load->view('admin/layout_page', html_escape($data));

	}



}
