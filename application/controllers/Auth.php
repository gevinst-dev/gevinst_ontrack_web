<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends Public_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('auth_model', 'auth');

		$this->load->model('admin/client_model', 'client');

		$this->load->model('admin/setting_model', 'setting');

	}


	
	public function index()
	{
		if($this->session->has_userdata('user_id')){
			redirect(base_url('dashboard'));
		} else {
			redirect(base_url('auth/sign_in'));
		}
	}


	public function sign_in()
	{

		if( $this->session->has_userdata('user_id') && $this->session->has_userdata('user_signed_in') ){
			redirect(base_url('dashboard'));
		}

		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('email', __('Email Address'), 'trim|valid_email|required');
			$this->form_validation->set_rules('password', __('Password'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect(base_url('auth/sign_in'));
			} else {

                if(get_setting('google_recaptcha') == '1') {
                    $captchatest = check_recaptcha($_POST["g-recaptcha-response"]);

                    if($captchatest == false) {
                        $this->session->set_flashdata('toast-error', __("Captcha validation failed!"));
                        redirect($_SERVER['HTTP_REFERER']);
                    }
                }

				$email = $this->security->xss_clean($this->input->post('email'));
				$password = $this->security->xss_clean($this->input->post('password'));

				$result = $this->auth->authenticate($email, $password);

				if($result) {
					$client = $this->db->get_where('app_clients', array( 'id' => $result['client_id'] ))->row_array();

					if($result['status'] == 'Active') {

                        $language = $this->db->get_where('core_languages', ['id' => $result['language_id']])->row_array();

						$session_data = array(
							'user_id' => $result['id'],
							'client_id' => $result['client_id'],
							'user_language_id' => $result['language_id'],
                            'user_language_rtl' => $language['rtl'],

							'user_email' => $result['email'],
							'user_name' => $result['name'],
							'user_signed_in' => TRUE,
							'client' => $client
						);
						$this->session->set_userdata($session_data);

						if($this->input->post('remember_me') == "1") {
							$user_rm_cookie = array(
							    'name'   => 'user_rm',
							    'value'  => $this->encryption->encrypt($result['id']),
							    'expire' => '2592000',  // 30 days
							);
							set_cookie($user_rm_cookie);
						}

						$this->session->set_flashdata('toast-success', __("You have successfully signed in."));
						log_staff(__('Successful authentication'), $result['id']);
						redirect(base_url('dashboard'));

					} else {
						log_staff(__('Failed authentication: account is inactive.'), $result['id']);
						$this->session->set_flashdata('toast-error', __('Your account has been disabled!'));
						redirect(base_url('auth/sign_in'));
					}
				} else {
					$this->session->set_flashdata('toast-error', __('Invalid credentials!'));
					redirect(base_url('auth/sign_in'));
				}
			}

		} else {

            $data['title'] = __("Sign In");
            $data['page'] = 'user/sign_in';
    
    
            $this->load->view('user/layout_page', html_escape($data));

		}

	}




	public function sign_out()
	{
		$this->session->sess_destroy();
		delete_cookie('user_rm');

		$this->session->set_flashdata('toast-success', __("You have successfully signed out."));
		redirect(base_url('auth/sign_in'));
	}




	public function forgot_password()
	{
		if( $this->session->has_userdata('user_id') && $this->session->has_userdata('user_signed_in') ){
			redirect(base_url('dashboard'));
		}

		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('email', __('Email Address'), 'trim|valid_email|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect(base_url('auth/forgot_password'));
			} else {

                if(get_setting('google_recaptcha') == '1') {
                    $captchatest = check_recaptcha($_POST["g-recaptcha-response"]);

                    if($captchatest == false) {
                        $this->session->set_flashdata('toast-error', __("Captcha validation failed!"));
                        redirect($_SERVER['HTTP_REFERER']);
                    }
                }

				$email = $this->security->xss_clean($this->input->post('email'));
				$result = $this->auth->check_email_address($email);
				if($result) {
					$this->auth->set_password_reset_key($email);
					$this->mailer->send("User | Password reset", [ "user_id" => $result['id'] ]);
					log_staff(__('Password reset initiated'), $result['id']);

					$this->session->set_flashdata('toast-success', __('We have sent instructions for resetting your password to your email'));
					redirect(base_url('auth/forgot_password'));
				} else {
					$this->session->set_flashdata('toast-error', __('Invalid email address! Please check your email address and try again.'));
					redirect(base_url('auth/forgot_password'));
				}

			}

		} else {
			$data['title'] = __("Forgot Password");
            $data['page'] = 'user/forgot_password';
    
    
            $this->load->view('user/layout_page', html_escape($data));



		}

	}


	public function reset_password()
	{
		$key = $this->uri->segment(3);


		if(empty($key)) {
			$this->session->set_flashdata('toast-error', __('Password reset key is missing.'));
			redirect(base_url('auth/forgot_password'));
		}

		if(!$this->auth->check_reset_key($key)) {
			$this->session->set_flashdata('toast-error', __('Invalid password reset key.'));
			redirect(base_url('auth/forgot_password'));
		}

		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('password', __('Password'), 'trim|required|min_length[8]');
			$this->form_validation->set_rules('password_confirm', __('Password Confirmation'), 'trim|required|matches[password]');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect(base_url('auth/reset_password/'.$key));
			} else {
				$new_password = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
				$result = $this->auth->reset_password($key, $new_password);

				if($result) {
					$this->mailer->send("User | Password reset confirmation", [ "user_id" => $result['id'] ]);

					$this->session->set_flashdata('toast-success', __('New password has been updated successfully. You can now sign in with your new password.'));
					redirect(base_url('auth/sign_in'));
				} else {
					$this->session->set_flashdata('toast-error', __('Unable to change password! Please try again.'));
					redirect(base_url('auth/forgot_password'));
				}

			}

		} else {

            $data['title'] = __("Reset Password");
            $data['page'] = 'user/reset_password';
            $data['key'] = $key;
    
            $this->load->view('user/layout_page', html_escape($data));



			
			
			
		}


	}






}
