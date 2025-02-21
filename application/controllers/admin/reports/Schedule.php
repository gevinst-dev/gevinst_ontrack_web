<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Schedule extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();


		$this->load->model('admin/setting_model', 'setting');
		$this->load->library('datatables');
	}




    public function index()
	{

		$data['title'] = __("Schedule Report");
		$data['modal'] = 'admin/reports/schedule';





		$this->load->view('admin/layout_modal', html_escape($data));


	}



}
