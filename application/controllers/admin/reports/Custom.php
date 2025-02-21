<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Custom extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();


		$this->load->model('admin/setting_model', 'setting');
		$this->load->library('datatables');
	}




    public function index()
	{

		$data['title'] = __("Custom Report");
		$data['page'] = 'admin/reports/custom';


	


		$this->load->view('admin/layout_page', html_escape($data));


	}



}
