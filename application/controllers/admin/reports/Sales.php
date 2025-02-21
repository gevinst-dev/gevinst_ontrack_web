<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();

        enforce_permission('reports_sales-view');
		$this->load->model('admin/setting_model', 'setting');
		$this->load->model('admin/client_model', 'client');
        $this->load->model('admin/project_model', 'project');
		$this->load->library('datatables');
	}




    public function index()
	{

		$data['title'] = __("Sales Report");
		$data['page'] = 'admin/reports/sales';

        log_staff('Viewed sales report');


		$data['clients'] = $this->client->get_all();

        $data['entities'] = $this->setting->get_entities();
        $data['currencies'] = $this->setting->get_currencies();






		$where = [];

        if($_SESSION['filter_start'] != "") $where['date >='] = $_SESSION['filter_start'];
		if($_SESSION['filter_end'] != "") $where['date <='] = $_SESSION['filter_end'];

		if($_SESSION['filter_client_id'] != "") $where['client_id'] = $_SESSION['filter_client_id'];
        if($_SESSION['filter_currency_id'] != "") $where['currency_id'] = $_SESSION['filter_currency_id'];
        if($_SESSION['filter_entity_id'] != "") $where['entity_id'] = $_SESSION['filter_entity_id'];

        if($_SESSION['filter_invoice_status'] != "") $where['status'] = $_SESSION['filter_invoice_status'];

        if($_SESSION['filter_payment_status'] == "Paid") $where['unpaid'] = 0;
        if($_SESSION['filter_payment_status'] == "Unpaid + Partially Paid") $where['unpaid >'] = 0;

		$data['items'] = $this->db->get_where('app_invoices', $where)->result_array();



		$this->load->view('admin/layout_page', html_escape($data));


	}



}
