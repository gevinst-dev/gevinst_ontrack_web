<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Projects extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();

        enforce_permission('reports_projects-view');
		$this->load->model('admin/setting_model', 'setting');
		$this->load->model('admin/client_model', 'client');
        $this->load->model('admin/project_model', 'project');
		$this->load->library('datatables');
	}




    public function index()
	{

		$data['title'] = __("Projects Report");
		$data['page'] = 'admin/reports/projects';

		$data['clients'] = $this->client->get_all();
        log_staff('Viewed projects report');




		$where = [];

		if($_SESSION['filter_client_id'] != "") $where['client_id'] = $_SESSION['filter_client_id'];

		$data['items'] = $this->db->get_where('app_projects', $where)->result_array();



		$this->load->view('admin/layout_page', html_escape($data));


	}



}
