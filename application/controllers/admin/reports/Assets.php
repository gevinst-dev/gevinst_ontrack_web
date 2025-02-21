<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assets extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();

        enforce_permission('reports_assets-view');

		$this->load->model('admin/setting_model', 'setting');
		$this->load->model('admin/client_model', 'client');
		$this->load->model('admin/customfield_model', 'customfield');

		$this->load->model('admin/attribute_model', 'attribute');

		$this->load->library('datatables');
	}




    public function index()
	{
		$data['title'] = __("Assets Report");
		$data['page'] = 'admin/reports/assets';

        log_staff('Viewed assets report');

		$data['customfields'] = $this->customfield->get_for('Assets');

		$data['clients'] = $this->client->get_all();

		$where = [];

		if($_SESSION['filter_client_id'] != "") $where['client_id'] = $_SESSION['filter_client_id'];

		$data['items'] = $this->db->get_where('app_assets', $where)->result_array();


		$data['asset_categories'] = $this->attribute->get_asset_categories();
		

		$data['status_labels'] = $this->attribute->get_status_labels();

		foreach($data['asset_categories'] as $key => $value) {
			$data['asset_categories'][$key]['count'] = 0;
			foreach($data['items'] as $item) {
				if($item['category_id'] == $data['asset_categories'][$key]['id']) {
					$data['asset_categories'][$key]['count']++;
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
