<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends User_Controller {

	public function __construct()
	{
		parent::__construct();

        enforce_user_permission('profile');

		$this->load->model('admin/setting_model', 'setting');
        $this->load->model('admin/customfield_model', 'customfield');
        $this->load->model('admin/attribute_model', 'attribute');
        $this->load->model('admin/user_model', 'user');
        $this->load->model('admin/staff_model', 'staff');

		

	}

    public function index()
    {
		$data['title'] = __("My Profile");
		$data['page'] = 'user/profile';

        $data['languages'] = $this->setting->get_languages();
        $data['user'] = $this->user->get($this->session->user_id);

        log_user('Viewed profile');

		if($this->input->method() === 'post') {


			if($this->input->post('email') != $data['user']['email']) {
				$this->form_validation->set_rules('email', __('Email Address'), 'trim|valid_email|is_unique[core_users.email]|required');
			} else {
				$this->form_validation->set_rules('email', __('Email Address'), 'trim|valid_email|required');
			}

			if($this->input->post('password') != "") {
				$this->form_validation->set_rules('password', __('Password'), 'min_length[8]|required');
				$this->form_validation->set_rules('password_confirm', __('Password Confirmation'), 'required|matches[password]');
			}


			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect(base_url('profile'));
			} else {

				$db_data = array(
					'language_id' => strip_tags($this->input->post('language_id')),
					'email' => strtolower(strip_tags($this->input->post('email'))),
					'name' => strip_tags($this->input->post('name')),
                    'designation' => strip_tags($this->input->post('designation')),
					'updated_at' => date('Y-m-d H:i:s'),
				);


				if($this->input->post('password') != "") {
					$db_data['password'] = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
				}


                $language = $this->db->get_where('core_languages', ['id' => $db_data['language_id']])->row_array();

                $session_data = array(
                    'user_id' => $this->session->user_id,
                    'client_id' => $this->session->client_id,
                    'user_language_id' => $this->input->post('language_id'),
                    'user_language_rtl' => $language['rtl'],
                    'user_email' => strtolower($this->input->post('email')),
                    'user_name' => $this->input->post('name'),
                    'user_signed_in' => TRUE,
                    'client' => $this->session->client
                );
                $this->session->set_userdata($session_data);




			
				$result = $this->user->edit($db_data, $this->session->user_id);

				if($result) {
                    log_user('Updated profile');

					$this->session->set_flashdata('toast-success', __("Your profile has been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to update your profile."));
				}

				redirect(base_url('profile'));

			}

		} else {
			$this->load->view('user/layout_page', html_escape($data));
		}



		
    }


}