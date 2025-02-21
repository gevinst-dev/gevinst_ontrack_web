<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tickets extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();

        enforce_permission('reports_tickets-view');
		$this->load->model('admin/setting_model', 'setting');
		$this->load->model('admin/client_model', 'client');
		$this->load->model('admin/customfield_model', 'customfield');

		$this->load->library('datatables');
	}




    public function index()
	{
		$data['title'] = __("Tickets Report");
		$data['page'] = 'admin/reports/tickets';
        log_staff('Viewed tickets report');

		$data['customfields'] = $this->customfield->get_for('Issues');

		$data['clients'] = $this->client->get_all();

		$where = [];

		if($_SESSION['filter_client_id'] != "") $where['client_id'] = $_SESSION['filter_client_id'];

		if($_SESSION['filter_start'] != "") $where['created_at >='] = $_SESSION['filter_start'];
		if($_SESSION['filter_end'] != "") $where['created_at <='] = $_SESSION['filter_end'];


		$data['items'] = $this->db->get_where('app_tickets', $where)->result_array();


		$data['open_count'] = 0;
		$data['reopened_count'] = 0;
		$data['inprogress_count'] = 0;
		$data['answered_count'] = 0;
		$data['closed_count'] = 0;

		$data['low_count'] = 0;
		$data['normal_count'] = 0;
		$data['high_count'] = 0;

		foreach($data['items'] as $item) {
			if($item['status'] == "Open") $data['open_count']++;
			if($item['status'] == "Reopened") $data['reopened_count']++;
			if($item['status'] == "In Progress") $data['inprogress_count']++;
			if($item['status'] == "Answered") $data['answered_count']++;
			if($item['status'] == "Closed") $data['closed_count']++;

			if($item['priority'] == "Low") $data['low_count']++;
			if($item['priority'] == "Normal") $data['normal_count']++;
			if($item['priority'] == "High") $data['high_count']++;
		}

		$this->load->view('admin/layout_page', html_escape($data));

	}



}
