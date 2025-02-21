<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clients extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();

        enforce_permission('reports_clients-view');
		$this->load->model('admin/setting_model', 'setting');
		$this->load->library('datatables');
	}




    public function index()
	{

		$data['title'] = __("Clients Report");
		$data['page'] = 'admin/reports/clients';

        log_staff('Viewed cleints report');

		$data['items'] = $this->db->get('app_clients')->result_array();



		$this->load->view('admin/layout_page', html_escape($data));


	}



}
