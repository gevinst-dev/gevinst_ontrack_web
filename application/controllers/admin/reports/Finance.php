<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Finance extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();

        enforce_permission('reports_finance-view');
		$this->load->model('admin/setting_model', 'setting');
		$this->load->model('admin/client_model', 'client');
        $this->load->model('admin/supplier_model', 'supplier');
        $this->load->model('admin/project_model', 'project');
		$this->load->library('datatables');
	}




    public function index()
	{

		$data['title'] = __("Finance Overview");
		$data['page'] = 'admin/reports/finance';
        log_staff('Viewed finance overview report');

        $data['default_currency'] = get_setting('default_currency');
        $data['entities'] = $this->setting->get_entities();
        $data['expensecategories'] = $this->setting->get_expensecategories();



        $data['first_12'] = date('Y-m-d', strtotime('first day of -12 months'));
		$data['last_12'] = date('Y-m-d', strtotime('last day of -12 months'));
		$data['t_12'] = date('M Y', strtotime($data['first_12']));

		$data['first_11'] = date('Y-m-d', strtotime('first day of -11 months'));
		$data['last_11'] = date('Y-m-d', strtotime('last day of -11 months'));
		$data['t_11'] = date('M Y', strtotime($data['first_11']));

		$data['first_10'] = date('Y-m-d', strtotime('first day of -10 months'));
		$data['last_10'] = date('Y-m-d', strtotime('last day of -10 months'));
		$data['t_10'] = date('M Y', strtotime($data['first_10']));

		$data['first_09'] = date('Y-m-d', strtotime('first day of -9 months'));
		$data['last_09'] = date('Y-m-d', strtotime('last day of -9 months'));
		$data['t_09'] = date('M Y', strtotime($data['first_09']));

		$data['first_08'] = date('Y-m-d', strtotime('first day of -8 months'));
		$data['last_08'] = date('Y-m-d', strtotime('last day of -8 months'));
		$data['t_08'] = date('M Y', strtotime($data['first_08']));

		$data['first_07'] = date('Y-m-d', strtotime('first day of -7 months'));
		$data['last_07'] = date('Y-m-d', strtotime('last day of -7 months'));
		$data['t_07'] = date('M Y', strtotime($data['first_07']));

		$data['first_06'] = date('Y-m-d', strtotime('first day of -6 months'));
		$data['last_06'] = date('Y-m-d', strtotime('last day of -6 months'));
		$data['t_06'] = date('M Y', strtotime($data['first_06']));

		$data['first_05'] = date('Y-m-d', strtotime('first day of -5 months'));
		$data['last_05'] = date('Y-m-d', strtotime('last day of -5 months'));
		$data['t_05'] = date('M Y', strtotime($data['first_05']));

		$data['first_04'] = date('Y-m-d', strtotime('first day of -4 months'));
		$data['last_04'] = date('Y-m-d', strtotime('last day of -4 months'));
		$data['t_04'] = date('M Y', strtotime($data['first_04']));

		$data['first_03'] = date('Y-m-d', strtotime('first day of -3 months'));
		$data['last_03'] = date('Y-m-d', strtotime('last day of -3 months'));
		$data['t_03'] = date('M Y', strtotime($data['first_03']));

		$data['first_02'] = date('Y-m-d', strtotime('first day of -2 months'));
		$data['last_02'] = date('Y-m-d', strtotime('last day of -2 months'));
		$data['t_02'] = date('M Y', strtotime($data['first_02']));

		$data['first_01'] = date('Y-m-d', strtotime('first day of -1 months'));
		$data['last_01'] = date('Y-m-d', strtotime('last day of -1 months'));
		$data['t_01'] = date('M Y', strtotime($data['first_01']));

		$data['first_00'] = date('Y-m-d', strtotime('first day of this month'));
		$data['last_00'] = date('Y-m-d', strtotime('last day of this month'));
		$data['t_00'] = date('M Y', strtotime($data['first_00']));


        $data['entity_id'] = 0;
        if($_SESSION['filter_entity_id'] != "") $data['entity_id'] = $_SESSION['filter_entity_id'];


        // sales
        $data['sales_today'] = 0;
        $data['sales_yesterday'] = 0;
        $data['sales_this_week'] = 0;
        $data['sales_this_month'] = 0;
        $data['sales_this_year'] = 0;
        $data['sales_custom'] = 0;



        $this->db->select('id,value,rate');
        $this->db->from('app_invoices');
        $this->db->where(['date >=' => date('Y-m-d'), 'date <=' => date('Y-m-d'), 'status' => 'Valid']);
        if($_SESSION['filter_entity_id'] != "") $this->db->where('entity_id', $_SESSION['filter_entity_id']);
        $invoices_azi = $this->db->get()->result_array();
        foreach($invoices_azi as $item) {
            $data['sales_today'] += $item['value']*$item['rate'];
        }

        $this->db->select('id,value,rate');
        $this->db->from('app_invoices');
        $this->db->where(['date >=' => date('Y-m-d', strtotime('yesterday')), 'date <=' => date('Y-m-d', strtotime('yesterday')), 'status' => 'Valid']);
        if($_SESSION['filter_entity_id'] != "") $this->db->where('entity_id', $_SESSION['filter_entity_id']);
        $invoices_ieri = $this->db->get()->result_array();
        foreach($invoices_ieri as $item) {
            $data['sales_yesterday'] += $item['value']*$item['rate'];
        }


        $this->db->select('id,value,rate');
        $this->db->from('app_invoices');
        $this->db->where(['date >=' => date('Y-m-d', strtotime('monday this week')), 'date <=' => date('Y-m-d', strtotime('sunday this week')), 'status' => 'Valid']);
        if($_SESSION['filter_entity_id'] != "") $this->db->where('entity_id', $_SESSION['filter_entity_id']);
        $invoices_sapt = $this->db->get()->result_array();
        foreach($invoices_sapt as $item) {
            $data['sales_this_week'] += $item['value']*$item['rate'];
        }

        $this->db->select('id,value,rate');
        $this->db->from('app_invoices');
        $this->db->where(['date >=' => date('Y-m-d', strtotime('first day of this month')), 'date <=' => date('Y-m-d', strtotime('last day of this month')), 'status' => 'Valid']);
        if($_SESSION['filter_entity_id'] != "") $this->db->where('entity_id', $_SESSION['filter_entity_id']);
        $invoices_luna = $this->db->get()->result_array();
        foreach($invoices_luna as $item) {
            $data['sales_this_month'] += $item['value']*$item['rate'];
        }

        $this->db->select('id,value,rate');
        $this->db->from('app_invoices');
        $this->db->where(['date >=' => date('Y-m-d', strtotime('first day of january this year')), 'date <=' => date('Y-m-d', strtotime('last day of december this year')), 'status' => 'Valid']);
        if($_SESSION['filter_entity_id'] != "") $this->db->where('entity_id', $_SESSION['filter_entity_id']);
        $invoices_an = $this->db->get()->result_array();
        foreach($invoices_an as $item) {
            $data['sales_this_year'] += $item['value']*$item['rate'];
        }

        $this->db->select('id,value,rate');
        $this->db->from('app_invoices');
        $this->db->where(['date >=' => $_SESSION['filter_start'], 'date <=' => $_SESSION['filter_end'], 'status' => 'Valid']);
        if($_SESSION['filter_entity_id'] != "") $this->db->where('entity_id', $_SESSION['filter_entity_id']);
        $invoices_custom = $this->db->get()->result_array();
        foreach($invoices_custom as $item) {
            $data['sales_custom'] += $item['value']*$item['rate'];
        }




		// expenses

		$data['expenses_today'] = 0;
		$data['expenses_yesterday'] = 0;
		$data['expenses_this_week'] = 0;
		$data['expenses_this_month'] = 0;
		$data['expenses_this_year'] = 0;
		$data['expenses_custom'] = 0;


		$this->db->select('id,value,rate');
        $this->db->from('app_expenses');
        $this->db->where(['date >=' => date('Y-m-d'), 'date <=' => date('Y-m-d'), 'status' => 'Valid']);
        if($_SESSION['filter_entity_id'] != "") $this->db->where('entity_id', $_SESSION['filter_entity_id']);
        $invoices_azi = $this->db->get()->result_array();
        foreach($invoices_azi as $item) {
            $data['expenses_today'] += $item['value']*$item['rate'];
        }

        $this->db->select('id,value,rate');
        $this->db->from('app_expenses');
        $this->db->where(['date >=' => date('Y-m-d', strtotime('yesterday')), 'date <=' => date('Y-m-d', strtotime('yesterday')), 'status' => 'Valid']);
        if($_SESSION['filter_entity_id'] != "") $this->db->where('entity_id', $_SESSION['filter_entity_id']);
        $invoices_ieri = $this->db->get()->result_array();
        foreach($invoices_ieri as $item) {
            $data['expenses_yesterday'] += $item['value']*$item['rate'];
        }


        $this->db->select('id,value,rate');
        $this->db->from('app_expenses');
        $this->db->where(['date >=' => date('Y-m-d', strtotime('monday this week')), 'date <=' => date('Y-m-d', strtotime('sunday this week')), 'status' => 'Valid']);
        if($_SESSION['filter_entity_id'] != "") $this->db->where('entity_id', $_SESSION['filter_entity_id']);
        $invoices_sapt = $this->db->get()->result_array();
        foreach($invoices_sapt as $item) {
            $data['expenses_this_week'] += $item['value']*$item['rate'];
        }

        $this->db->select('id,value,rate');
        $this->db->from('app_expenses');
        $this->db->where(['date >=' => date('Y-m-d', strtotime('first day of this month')), 'date <=' => date('Y-m-d', strtotime('last day of this month')), 'status' => 'Valid']);
        if($_SESSION['filter_entity_id'] != "") $this->db->where('entity_id', $_SESSION['filter_entity_id']);
        $invoices_luna = $this->db->get()->result_array();
        foreach($invoices_luna as $item) {
            $data['expenses_this_month'] += $item['value']*$item['rate'];
        }

        $this->db->select('id,value,rate');
        $this->db->from('app_expenses');
        $this->db->where(['date >=' => date('Y-m-d', strtotime('first day of january this year')), 'date <=' => date('Y-m-d', strtotime('last day of december this year')), 'status' => 'Valid']);
        if($_SESSION['filter_entity_id'] != "") $this->db->where('entity_id', $_SESSION['filter_entity_id']);
        $invoices_an = $this->db->get()->result_array();
        foreach($invoices_an as $item) {
            $data['expenses_this_year'] += $item['value']*$item['rate'];
        }

        $this->db->select('id,value,rate');
        $this->db->from('app_expenses');
        $this->db->where(['date >=' => $_SESSION['filter_start'], 'date <=' => $_SESSION['filter_end'], 'status' => 'Valid']);
        if($_SESSION['filter_entity_id'] != "") $this->db->where('entity_id', $_SESSION['filter_entity_id']);
        $invoices_custom = $this->db->get()->result_array();
        foreach($invoices_custom as $item) {
            $data['expenses_custom'] += $item['value']*$item['rate'];
        }










        // top clients
        $this->db->select('client_id, SUM(value) AS amount', FALSE);
        $this->db->order_by("amount", "desc");
        if($_SESSION['filter_entity_id'] != "") $this->db->where('entity_id', $_SESSION['filter_entity_id']);
        $this->db->where('status', 'Valid');
        $this->db->where('date >=', date('Y-m-d', strtotime('first day of january this year')));
        $this->db->where('date <=', date('Y-m-d', strtotime('last day of december this year')));
        $this->db->group_by("client_id");
        $this->db->limit("15");
        $data['top_clients'] = $this->db->get('app_invoices')->result_array();
        

        // top suppliers
        $this->db->select('supplier_id, SUM(value) AS amount', FALSE);
        $this->db->order_by("amount", "desc");
        if($_SESSION['filter_entity_id'] != "") $this->db->where('entity_id', $_SESSION['filter_entity_id']);
        $this->db->where('status', 'Valid');
        $this->db->where('date >=', date('Y-m-d', strtotime('first day of january this year')));
        $this->db->where('date <=', date('Y-m-d', strtotime('last day of december this year')));
        $this->db->group_by("supplier_id");
        $this->db->limit("15");
        $data['top_suppliers'] = $this->db->get('app_expenses')->result_array();

        

		$this->load->view('admin/layout_page', html_escape($data));


	}



}
