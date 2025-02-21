<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Expenses extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();

        enforce_permission('reports_expenses-view');
		$this->load->model('admin/setting_model', 'setting');
		$this->load->model('admin/client_model', 'client');
        $this->load->model('admin/supplier_model', 'supplier');
        $this->load->model('admin/project_model', 'project');
		$this->load->library('datatables');
	}




    public function index()
	{

		$data['title'] = __("Expenses Report");
		$data['page'] = 'admin/reports/expenses';

        log_staff('Viewed expenses report');

        $data['suppliers'] = $this->supplier->get_all();

        $data['entities'] = $this->setting->get_entities();
        $data['currencies'] = $this->setting->get_currencies();






		$where = [];

        if($_SESSION['filter_start'] != "") $where['date >='] = $_SESSION['filter_start'];
		if($_SESSION['filter_end'] != "") $where['date <='] = $_SESSION['filter_end'];

		if($_SESSION['filter_supplier_id'] != "") $where['supplier_id'] = $_SESSION['filter_supplier_id'];
        if($_SESSION['filter_currency_id'] != "") $where['currency_id'] = $_SESSION['filter_currency_id'];
        if($_SESSION['filter_entity_id'] != "") $where['entity_id'] = $_SESSION['filter_entity_id'];

        if($_SESSION['filter_invoice_status'] != "") $where['status'] = $_SESSION['filter_invoice_status'];



		$data['items'] = $this->db->get_where('app_expenses', $where)->result_array();



		$this->load->view('admin/layout_page', html_escape($data));


	}



}
