<?php

use Mpdf\Barcode\Postnet;

defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();


	}



	public function index()
	{
		$data['title'] = __("Search Results");
		$data['page'] = 'admin/search';

        $data['result_count'] = 0;


        if($this->input->method() === 'post') {
			$this->form_validation->set_rules('query', __('Keyword'), 'required|min_length[3]');


			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {

                $query = $this->input->post('query');

                $data['assets'] = [];
                $data['licenses'] = [];
                $data['domains'] = [];
                $data['clients'] = [];
                $data['projects'] = [];
                $data['tickets'] = [];
                $data['issues'] = [];
                $data['suppliers'] = [];
                


                if(has_permission('assets-view')) {
                    // assets
                    $this->db->like('name', $query);
                    $this->db->or_like('tag', $query);
                    $data['assets'] = $this->db->get('app_assets')->result_array();
                }

                if(has_permission('licenses-view')) {
                    // licenses
                    $this->db->like('name', $query);
                    $this->db->or_like('tag', $query);
                    $data['licenses'] = $this->db->get('app_licenses')->result_array();
                }

                if(has_permission('domains-view')) {
                    // domains
                    $this->db->like('domain', $query);
                    $data['domains'] = $this->db->get('app_domains')->result_array();
                }

                if(has_permission('clients-view')) {
                    // clients
                    $this->db->like('name', $query);
                    $data['clients'] = $this->db->get('app_clients')->result_array();
                }

                if(has_permission('projects-view')) {
                    // projects
                    $this->db->like('name', $query);
                    $data['projects'] = $this->db->get('app_projects')->result_array();
                }

                if(has_permission('tickets-view')) {
                    // tickets
                    $this->db->like('ticket', $query);
                    $this->db->or_like('subject', $query);
                    $data['tickets'] = $this->db->get('app_tickets')->result_array();
                }

                if(has_permission('issues-view')) {
                    // issues
                    $this->db->like('name', $query);
                    $this->db->or_like('description', $query);
                    $data['issues'] = $this->db->get('app_issues')->result_array();
                }

                if(has_permission('suppliers-view')) {
                    // suppliers
                    $this->db->like('name', $query);
                    $data['suppliers'] = $this->db->get('app_suppliers')->result_array();
                }



                
                $data['result_count'] = 
                    count($data['assets']) + 
                    count($data['licenses']) + 
                    count($data['domains']) + 
                    count($data['clients']) + 
                    count($data['projects']) + 
                    count($data['tickets']) + 
                    count($data['issues']) + 
                    count($data['suppliers']);
            }

        }







        $this->load->view('admin/layout_page', html_escape($data));

    }



}
