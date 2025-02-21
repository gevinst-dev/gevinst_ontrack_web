<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Client_details extends User_Controller {

	public function __construct()
	{
		parent::__construct();

        enforce_user_permission('client');

		$this->load->model('admin/setting_model', 'setting');
        $this->load->model('admin/customfield_model', 'customfield');
        $this->load->model('admin/attribute_model', 'attribute');
        $this->load->model('admin/user_model', 'user');
        $this->load->model('admin/staff_model', 'staff');
        $this->load->model('admin/client_model', 'client');

		

	}

    public function index()
    {
		$data['title'] = __("Client Details");
		$data['page'] = 'user/client_details';

        $data['languages'] = $this->setting->get_languages();
        $data['user'] = $this->user->get($this->session->user_id);
        $data['client'] = $this->client->get($this->session->client_id);

        log_user('Viewed client details');

        
		if($this->input->method() === 'post') {

			$this->form_validation->set_rules('name', __('Name'), 'trim|required');


			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {

				$db_data = array(
					'name' => strip_tags($this->input->post('name')),
					'description' => strip_tags($this->input->post('description')),

					'company_id' => strip_tags($this->input->post('company_id')),
					'company_taxid' => strip_tags($this->input->post('company_taxid')),
					'phone' => strip_tags($this->input->post('phone')),
					'email' => strip_tags($this->input->post('email')),
					'website' => strip_tags($this->input->post('website')),
					'address' => strip_tags($this->input->post('address')),
					'city' => strip_tags($this->input->post('city')),
					'state' => strip_tags($this->input->post('state')),
					'zip_code' => strip_tags($this->input->post('zip_code')),
					'country' => strip_tags($this->input->post('country')),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->client->edit($db_data, $data['client']['id']);

				if($result) {
                    log_user('Updated client details');

					$this->session->set_flashdata('toast-success', __("Client details have been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to update client details."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$this->load->view('user/layout_page', html_escape($data));
		}



		
    }


}