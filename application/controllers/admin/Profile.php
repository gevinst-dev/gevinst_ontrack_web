<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('admin/staff_model', 'staff');
		$this->load->model('admin/role_model', 'role');
		$this->load->model('admin/setting_model', 'setting');
		$this->load->library('datatables');
	}




	public function index()
	{
		$data['staff'] = $this->staff->get($this->session->staff_id);
		$data['languages'] = $this->setting->get_languages();

		if($this->input->method() === 'post') {

			$this->form_validation->set_rules('name', __('Name'), 'trim|required');

			if($this->input->post('email') != $data['staff']['email']) {
				$this->form_validation->set_rules('email', __('Email Address'), 'trim|valid_email|is_unique[core_staff.email]|required');
			} else {
				$this->form_validation->set_rules('email', __('Email Address'), 'trim|valid_email|required');
			}

			if($this->input->post('password') != "") {
				$this->form_validation->set_rules('password', __('Password'), 'min_length[8]|required');
				$this->form_validation->set_rules('password_confirm', __('Password Confirmation'), 'required|matches[password]');
			}


			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect(base_url('admin/profile'));
			} else {

				$db_data = array(
					'language_id' => $this->input->post('language_id'),
					'email' => strtolower($this->input->post('email')),
					'name' => $this->input->post('name'),

					'd_finance_overview' => $this->input->post('d_finance_overview'),
					'd_monthly_financials' => $this->input->post('d_monthly_financials'),
					'd_assets_category' => $this->input->post('d_assets_category'),
					'd_assets_status' => $this->input->post('d_assets_status'),
					'd_license_category' => $this->input->post('d_license_category'),
					'd_license_status' => $this->input->post('d_license_status'),
					'd_recent_assets' => $this->input->post('d_recent_assets'),
					'd_recent_licenses' => $this->input->post('d_recent_licenses'),
					'd_recent_projects' => $this->input->post('d_recent_projects'),
					'd_assigned_tickets' => $this->input->post('d_assigned_tickets'),
					'd_assigned_issues' => $this->input->post('d_assigned_issues'),
					'd_upcoming_reminders' => $this->input->post('d_upcoming_reminders'),
					'd_upcoming_events' => $this->input->post('d_upcoming_events'),

                    'd_sent_proposals' => $this->input->post('d_sent_proposals'),
                    'd_exchange_rates' => $this->input->post('d_exchange_rates'),



					'updated_at' => date('Y-m-d H:i:s'),
				);

				if($this->input->post('password') != "") {
					$db_data['password'] = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
				}

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->staff->edit($db_data, $this->session->staff_id);

				if($result) {
                    log_staff('Profile updated ' . $this->session->staff_id);

					$this->session->set_flashdata('toast-success', __("Your profile has been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to update your profile."));
				}

				redirect(base_url('admin/profile'));

			}

		} else {
			$data['title'] = __("My Profile");
			$data['page'] = 'admin/profile';

			$this->load->view('admin/layout_page', html_escape($data));
		}

	}






}
