<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Licenses extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();

        enforce_permission('reports_licenses-view');
		$this->load->model('admin/setting_model', 'setting');
		$this->load->model('admin/client_model', 'client');
		$this->load->model('admin/customfield_model', 'customfield');

		$this->load->model('admin/attribute_model', 'attribute');

		$this->load->library('datatables');
	}




    public function index()
	{
		$data['title'] = __("Licenses Report");
		$data['page'] = 'admin/reports/licenses';

        log_staff('Viewed licenses report');


		$data['customfields'] = $this->customfield->get_for('Licenses');

		$data['clients'] = $this->client->get_all();

		$where = [];

		if($_SESSION['filter_client_id'] != "") $where['client_id'] = $_SESSION['filter_client_id'];

		$data['items'] = $this->db->get_where('app_licenses', $where)->result_array();


		$data['license_categories'] = $this->attribute->get_license_categories();
		$data['status_labels'] = $this->attribute->get_status_labels();


		foreach($data['license_categories'] as $key => $value) {
			$data['license_categories'][$key]['count'] = 0;
			foreach($data['items'] as $item) {
				if($item['category_id'] == $data['license_categories'][$key]['id']) {
					$data['license_categories'][$key]['count']++;
				}
			}
		}

		foreach($data['status_labels'] as $key => $value) {
			$data['status_labels'][$key]['count'] = 0;
			foreach($data['items'] as $item) {
				if($item['status_id'] == $data['status_labels'][$key]['id']) {
					$data['status_labels'][$key]['count']++;
				}
			}
		}



		$this->load->view('admin/layout_page', html_escape($data));

	}



}
