<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
        enforce_permission('reports_users-view');

		$this->load->model('admin/setting_model', 'setting');
		$this->load->model('admin/client_model', 'client');
		$this->load->library('datatables');
	}




    public function index()
	{

		$data['title'] = __("Users Report");
		$data['page'] = 'admin/reports/users';

        log_staff('Viewed users report');


		$data['clients'] = $this->client->get_all();

		$where = [];
		if($_SESSION['filter_client_id'] != "") $where['client_id'] = $_SESSION['filter_client_id'];

		$data['items'] = $this->db->get_where('core_users', $where)->result_array();



		$this->load->view('admin/layout_page', html_escape($data));


	}



}
