<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();

        enforce_permission('reports-view');
		$this->load->model('admin/setting_model', 'setting');
		$this->load->library('datatables');



		if(!isset($_SESSION['filter_client_id']))
			$this->session->set_userdata('filter_client_id', '');

        if(!isset($_SESSION['filter_supplier_id']))
			$this->session->set_userdata('filter_supplier_id', '');

		if(!isset($_SESSION['filter_asset_id']))
				$this->session->set_userdata('filter_asset_id', '');

		if(!isset($_SESSION['filter_license_id']))
				$this->session->set_userdata('filter_license_id', '');

		if(!isset($_SESSION['filter_domain_id']))
				$this->session->set_userdata('filter_domain_id', '');

		if(!isset($_SESSION['filter_project_id']))
				$this->session->set_userdata('filter_project_id', '');

		if(!isset($_SESSION['filter_user_id']))
				$this->session->set_userdata('filter_user_id', '');

		if(!isset($_SESSION['filter_staff_id']))
				$this->session->set_userdata('filter_staff_id', '');

		if(!isset($_SESSION['filter_start']))
			$this->session->set_userdata('filter_start', date('Y-m-d', strtotime('first day of this month')));

		if(!isset($_SESSION['filter_end']))
			$this->session->set_userdata('filter_end', date('Y-m-d', strtotime('last day of this month')));


        if(!isset($_SESSION['filter_currency_id']))
            $this->session->set_userdata('filter_currency_id', '');

        if(!isset($_SESSION['filter_entity_id']))
            $this->session->set_userdata('filter_entity_id', '');

        if(!isset($_SESSION['filter_invoice_status']))
            $this->session->set_userdata('filter_invoice_status', '');

        if(!isset($_SESSION['filter_payment_status']))
            $this->session->set_userdata('filter_payment_status', '');

	}


	public function set_filters() {

		if($this->input->method() === 'post') {


			if(isset($_POST['filter_client_id']))
			$this->session->set_userdata('filter_client_id', $this->input->post('filter_client_id'));

            if(isset($_POST['filter_supplier_id']))
			$this->session->set_userdata('filter_supplier_id', $this->input->post('filter_supplier_id'));

			if(isset($_POST['filter_asset_id']))
			$this->session->set_userdata('filter_asset_id', $this->input->post('filter_asset_id'));

			if(isset($_POST['filter_license_id']))
			$this->session->set_userdata('filter_license_id', $this->input->post('filter_license_id'));

			if(isset($_POST['filter_domain_id']))
			$this->session->set_userdata('filter_domain_id', $this->input->post('filter_domain_id'));

			if(isset($_POST['filter_project_id']))
			$this->session->set_userdata('filter_project_id', $this->input->post('filter_project_id'));

			if(isset($_POST['filter_user_id']))
			$this->session->set_userdata('filter_user_id', $this->input->post('filter_user_id'));

			if(isset($_POST['filter_staff_id']))
			$this->session->set_userdata('filter_staff_id', $this->input->post('filter_staff_id'));




			if(isset($_POST['filter_start']))
				$this->session->set_userdata('filter_start', date_to_db($this->input->post('filter_start')));

			if(isset($_POST['filter_end']))
				$this->session->set_userdata('filter_end', date_to_db($this->input->post('filter_end')));


            if(isset($_POST['filter_currency_id']))
            $this->session->set_userdata('filter_currency_id', $this->input->post('filter_currency_id'));

            if(isset($_POST['filter_entity_id']))
            $this->session->set_userdata('filter_entity_id', $this->input->post('filter_entity_id'));

            
            if(isset($_POST['filter_invoice_status']))
            $this->session->set_userdata('filter_invoice_status', $this->input->post('filter_invoice_status'));

            
            if(isset($_POST['filter_payment_status']))
            $this->session->set_userdata('filter_payment_status', $this->input->post('filter_payment_status'));


			redirect($_SERVER['HTTP_REFERER']);

		} else {
			die('Invalid action');
		}




	}


    public function index()
	{

		$data['title'] = __("Reports");
		$data['page'] = 'admin/reports/index';

		$this->load->view('admin/layout_page', html_escape($data));


	}







}
