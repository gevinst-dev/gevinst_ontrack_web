<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends User_Controller {


	public function __construct()
	{
		parent::__construct();

		$this->load->model('admin/setting_model', 'setting');
        $this->load->model('admin/customfield_model', 'customfield');
        $this->load->model('admin/attribute_model', 'attribute');
        
	}


	public function index()
	{
		$data['title'] = __("Dashboard");
		$data['page'] = 'user/dashboard/index';



        log_user('Viewed dashboard');

		$data['assets_count'] = $this->db->where('client_id', $this->session->client_id)->from("app_assets")->count_all_results();
        $data['licenses_count'] = $this->db->where('client_id', $this->session->client_id)->from("app_licenses")->count_all_results();
        $data['domains_count'] = $this->db->where('client_id', $this->session->client_id)->from("app_domains")->count_all_results();
        $data['projects_count'] = $this->db->where('client_id', $this->session->client_id)->from("app_projects")->count_all_results();
        $data['tickets_count'] = $this->db->where('client_id', $this->session->client_id)->from("app_tickets")->count_all_results();
        $data['issues_count'] = $this->db->where('client_id', $this->session->client_id)->from("app_issues")->count_all_results();



        $data['ongoing_issues'] = $this->db->where('client_id', $this->session->client_id)->where_in('status', ['To Do', 'In Progress'])->get('app_issues')->result_array();
		$data['ongoing_tickets'] = $this->db->where('client_id', $this->session->client_id)->where_in('status', ['Open', 'Reopened', 'In Progress'])->get('app_tickets')->result_array();


        $data['asset_categories'] = $this->attribute->get_asset_categories();
		$data['license_categories'] = $this->attribute->get_license_categories();
		$data['status_labels'] = $this->attribute->get_status_labels();

        $data['unpaid_invoices'] = 0;
        $unpaid_invoices = $this->db->get_where('app_invoices', ['unpaid >' => 0, 'status' => 'Valid'])->result_array();
        foreach($unpaid_invoices as $item) {
            $data['unpaid_invoices'] += $item['unpaid'];
        }


		$client = $this->db->get_where('app_clients', array('id' => $this->session->client['id']))->row_array();

		$data['latest_proposals'] = $this->db->where(['client_id' => $this->session->client['id']])->order_by('created_at', 'DESC')->limit(10)->get('app_proposals')->result_array();

	


		$this->load->view('user/layout_page', html_escape($data));

	}
}
