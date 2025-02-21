<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();

        enforce_permission('settings');

		$this->load->model('admin/setting_model', 'setting');
	
	}




	public function index()
	{
		redirect(base_url('admin/setup/settings/general'));
	}


	public function general()
	{
		$data['title'] = __("General Settings");
		$data['page'] = 'admin/setup/settings/index';
		$data['section'] = "general";


		$data['currencies'] = $this->setting->get_currencies();
		$data['taxrates'] = $this->setting->get_taxrates();

		if($this->input->method() === 'post') {
            

			$this->form_validation->set_rules('app_name', __('App Name'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect(base_url('admin/setup/settings/general'));
			} else {
                
				update_setting('app_name', $this->input->post('app_name'));

				update_setting('google_recaptcha', $this->input->post('google_recaptcha'));
				update_setting('google_recaptcha_sitekey', $this->input->post('google_recaptcha_sitekey'));
				update_setting('google_recaptcha_secretkey', $this->input->post('google_recaptcha_secretkey'));


				update_setting('default_taxrate', $this->input->post('default_taxrate'));
				update_setting('default_currency', $this->input->post('default_currency'));
				update_setting('multi_entity', $this->input->post('multi_entity'));

                log_staff('General settings updated');
				$this->session->set_flashdata('toast-success', __("Settings have been successfully updated."));

				redirect(base_url('admin/setup/settings/general'));
			}

		} else {
			$this->load->view('admin/layout_page', html_escape($data));
		}


	}



	public function personalization()
	{
		$data['title'] = __("Personalization Settings");
		$data['page'] = 'admin/setup/settings/index';
		$data['section'] = "personalization";

		$data['timezones'] = $this->setting->get_timezones();
		$data['languages'] = $this->setting->get_languages();

		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('invoice_accent_color', __('Invoice Accent Color'), 'trim|required');
	
			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect(base_url('admin/setup/settings/personalization'));
			} else {



				update_setting('invoice_accent_color', $this->input->post('invoice_accent_color'));
				update_setting('proposal_text', $this->input->post('proposal_text'));
                update_setting('invoice_text', $this->input->post('invoice_text'));
                

				$config['upload_path']                = './public/';
				$config['allowed_types']              = 'jpg|png|jpeg';
				$config['overwrite'] 				  = TRUE;
				$this->load->library('upload', $config);

				if(!empty($_FILES['logo_light']['name'])) {
					$config['upload_path']                = './public/';
					$config['allowed_types']              = 'jpg|png';
					$config['overwrite'] 				  = TRUE;
					$config['file_name'] 				  = 'logo_light.png';
					$this->upload->initialize($config);

					$this->upload->do_upload('logo_light');
				}


				if(!empty($_FILES['logo_dark']['name'])) {
					$config['upload_path']                = './public/';
					$config['allowed_types']              = 'jpg|png';
					$config['overwrite'] 				  = TRUE;
					$config['file_name'] 				  = 'logo_dark.png';
					$this->upload->initialize($config);

					$this->upload->do_upload('logo_dark');
				}


				if(!empty($_FILES['logo_pdf']['name'])) {
					$config['upload_path']                = './public/';
					$config['allowed_types']              = 'jpg|png|jpeg';
					$config['overwrite'] 				  = TRUE;
					$config['file_name'] 				  = 'logo_pdf.jpg';
					$this->upload->initialize($config);

					$this->upload->do_upload('logo_pdf');
				}


	
		

				if(!empty($_FILES['favicon']['name'])) {
					$config['upload_path']                = './public/';
					$config['allowed_types']              = 'jpg|png';
					$config['overwrite'] 				  = TRUE;
					$config['file_name'] 				  = 'favicon.png';
					$this->upload->initialize($config);

					$this->upload->do_upload('favicon');
				}

				sleep(2);



                log_staff('Personalization settings updated');
				$this->session->set_flashdata('toast-success', __("Settings have been successfully updated."));

				redirect(base_url('admin/setup/settings/personalization'));
			}

		} else {
			$this->load->view('admin/layout_page', html_escape($data));
		}
	}



	public function user_area()
	{
		$data['title'] = __("User Area");
		$data['page'] = 'admin/setup/settings/index';
		$data['section'] = "user_area";



		if($this->input->method() === 'post') {


            $config['upload_path']                = './public/';
            $config['allowed_types']              = 'jpg|png|jpeg';
            $config['overwrite'] 				  = TRUE;
            $this->load->library('upload', $config);

            if(!empty($_FILES['logo_user_area']['name'])) {
                $config['upload_path']                = './public/';
                $config['allowed_types']              = 'jpg|png';
                $config['overwrite'] 				  = TRUE;
                $config['file_name'] 				  = 'logo_user_area.png';
                $this->upload->initialize($config);

                $this->upload->do_upload('logo_user_area');
            }



		
            update_setting('user_accent_color', $this->input->post('user_accent_color'));
            update_setting('user_permission_assets', $this->input->post('user_permission_assets'));
            update_setting('user_permission_licenses', $this->input->post('user_permission_licenses'));
            update_setting('user_permission_domains', $this->input->post('user_permission_domains'));
            update_setting('user_permission_credentials', $this->input->post('user_permission_credentials'));
            update_setting('user_permission_projects', $this->input->post('user_permission_projects'));
            update_setting('user_permission_tickets', $this->input->post('user_permission_tickets'));
            update_setting('user_permission_issues', $this->input->post('user_permission_issues'));
            update_setting('user_permission_kb', $this->input->post('user_permission_kb'));
            update_setting('user_permission_ducumentation', $this->input->post('user_permission_ducumentation'));
            update_setting('user_permission_invoices', $this->input->post('user_permission_invoices'));
            update_setting('user_permission_proformas', $this->input->post('user_permission_proformas'));
            update_setting('user_permission_proposals', $this->input->post('user_permission_proposals'));
            update_setting('user_permission_receipts', $this->input->post('user_permission_receipts'));
            update_setting('user_permission_profile', $this->input->post('user_permission_profile'));
            update_setting('user_permission_client', $this->input->post('user_permission_client'));

            update_setting('public_kb', $this->input->post('public_kb'));
            update_setting('public_documentation', $this->input->post('public_documentation'));
            update_setting('public_submit_ticket', $this->input->post('public_submit_ticket'));
            
            log_staff('User area settings updated');
            $this->session->set_flashdata('toast-success', __("Settings have been successfully updated."));

            redirect(base_url('admin/setup/settings/user_area'));

		} else {
			$this->load->view('admin/layout_page', html_escape($data));
		}
	}


	public function localisation()
	{
		$data['title'] = __("Localisation Settings");
		$data['page'] = 'admin/setup/settings/index';
		$data['section'] = "localisation";

		$data['timezones'] = $this->setting->get_timezones();
		$data['languages'] = $this->setting->get_languages();

		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('timezone', __('Timezone'), 'trim|required');
			$this->form_validation->set_rules('date_format', __('Date Format'), 'trim|required');
			$this->form_validation->set_rules('default_language', __('Default Language'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect(base_url('admin/setup/settings/localisation'));
			} else {

				update_setting('timezone', $this->input->post('timezone'));
				update_setting('date_format', $this->input->post('date_format'));
				update_setting('week_start', $this->input->post('week_start'));
				update_setting('default_language', $this->input->post('default_language'));

				update_setting('decimal_separator', $this->input->post('decimal_separator'));
				update_setting('thousands_separator', $this->input->post('thousands_separator'));

                log_staff('Localisation settings updated');
				$this->session->set_flashdata('toast-success', __("Settings have been successfully updated."));

				redirect(base_url('admin/setup/settings/localisation'));
			}

		} else {
			$this->load->view('admin/layout_page', html_escape($data));
		}
	}

	public function languages()
	{
		$data['title'] = __("Languages");
		$data['page'] = 'admin/setup/settings/index';
		$data['section'] = "languages";

		$data['languages'] = $this->setting->get_languages();

		$this->load->view('admin/layout_page', html_escape($data));
	}


	public function taxrates()
	{
		$data['title'] = __("Tax Rates");
		$data['page'] = 'admin/setup/settings/index';
		$data['section'] = "taxrates";

		$data['taxrates'] = $this->setting->get_taxrates();

		$this->load->view('admin/layout_page', html_escape($data));
	}

	public function currencies()
	{
		$data['title'] = __("Currencies");
		$data['page'] = 'admin/setup/settings/index';
		$data['section'] = "currencies";

		$data['currencies'] = $this->setting->get_currencies();


        if($this->input->method() === 'post') {
			

            update_setting('exchange_rates_provider', $this->input->post('exchange_rates_provider'));
            update_setting('exchange_rates_provider_key', $this->input->post('exchange_rates_provider_key'));
            

            log_staff('Currency settings updated');
            $this->session->set_flashdata('toast-success', __("Settings have been successfully updated."));

            redirect(base_url('admin/setup/settings/currencies'));
        

		} else {
			$this->load->view('admin/layout_page', html_escape($data));
		}




	}

	public function payment()
	{
		$data['title'] = __("Payment Methods");
		$data['page'] = 'admin/setup/settings/index';
		$data['section'] = "payment";

		$data['paymentmethods'] = $this->setting->get_paymentmethods();

		$this->load->view('admin/layout_page', html_escape($data));
	}


	public function expense_categories()
	{
		$data['title'] = __("Expense Categories");
		$data['page'] = 'admin/setup/settings/index';
		$data['section'] = "expense_categories";

		$data['expense_categories'] = $this->setting->get_expense_categories();

		$this->load->view('admin/layout_page', html_escape($data));
	}


	public function entities()
	{
		$data['title'] = __("Entities");
		$data['page'] = 'admin/setup/settings/index';
		$data['section'] = "entities";

		$data['entities'] = $this->setting->get_entities();

		$this->load->view('admin/layout_page', html_escape($data));
	}


	public function email()
	{
		$data['title'] = __("Email Settings");
		$data['page'] = 'admin/setup/settings/index';
		$data['section'] = "email";

		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('email_from_name', __('From Name'), 'trim|required');
			$this->form_validation->set_rules('email_from_address', __('From Address'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect(base_url('admin/setup/settings/email'));
			} else {

				update_setting('email_from_address', $this->input->post('email_from_address'));
				update_setting('email_from_name', $this->input->post('email_from_name'));
				update_setting('email_smtp', $this->input->post('email_smtp'));
				update_setting('email_smtp_host', $this->input->post('email_smtp_host'));
				update_setting('email_smtp_port', $this->input->post('email_smtp_port'));
				update_setting('email_smtp_crypto', $this->input->post('email_smtp_crypto'));
				update_setting('email_smtp_user', $this->input->post('email_smtp_user'));
				update_setting('email_smtp_pass', $this->input->post('email_smtp_pass'));

				update_setting('email_signature', $this->input->post('email_signature'));

                log_staff('Email settings updated');
				$this->session->set_flashdata('toast-success', __("Settings have been successfully updated."));

				redirect(base_url('admin/setup/settings/email'));
			}

		} else {
			$this->load->view('admin/layout_page', html_escape($data));
		}
	}




	public function tickets()
	{
		$data['title'] = __("Tickets Settings");
		$data['page'] = 'admin/setup/settings/index';
		$data['section'] = "tickets";

		if($this->input->method() === 'post') {


				update_setting('imap_server', $this->input->post('imap_server'));
				update_setting('imap_port', $this->input->post('imap_port'));
				update_setting('imap_encryption', $this->input->post('imap_encryption'));
				update_setting('imap_user', $this->input->post('imap_user'));
				update_setting('imap_pass', $this->input->post('imap_pass'));

				update_setting('tickets_autoclose', $this->input->post('tickets_autoclose'));
				update_setting('tickets_autoclose_notif', $this->input->post('tickets_autoclose_notif'));




				update_setting('custom_imap_connect', $this->input->post('custom_imap_connect'));

                log_staff('Tickets settings updated');
				$this->session->set_flashdata('toast-success', __("Settings have been successfully updated."));

				redirect(base_url('admin/setup/settings/tickets'));


		} else {
			$this->load->view('admin/layout_page', html_escape($data));
		}
	}






	public function email_templates()
	{
		$data['title'] = __("Email Templates");
		$data['page'] = 'admin/setup/settings/index';
		$data['section'] = "email_templates";

		$data['templates'] = $this->setting->get_email_templates();

		$this->load->view('admin/layout_page', html_escape($data));
	}


    public function cron_job()
	{
		$data['title'] = __("Cron job");
		$data['page'] = 'admin/setup/settings/index';
		$data['section'] = "cron_job";

		
		$this->load->view('admin/layout_page', html_escape($data));
	}
    

	public function about()
	{
		$data['title'] = __("About");
		$data['page'] = 'admin/setup/settings/index';
		$data['section'] = "about";



		$this->load->view('admin/layout_page', html_escape($data));
	}



	public function add_language()
	{

		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('name', __('Language Name'), 'trim|required');
			$this->form_validation->set_rules('code', __('Language Code'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect(base_url('admin/setup/settings/languages'));
			} else {

				$db_data = array(
					'code' => $this->input->post('code'),
					'name' => $this->input->post('name'),
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->setting->add_language($db_data);

				if($result) {
					$language_id = $this->db->insert_id();
					$original_translations = $this->setting->get_translations(1);

					foreach($original_translations as $original_translation) {
						register_string($original_translation['original_string'], $language_id);
					}

                    log_staff('Language added');

					$this->session->set_flashdata('toast-success', __("Language has been successfully added."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to add language."));
				}

				redirect(base_url('admin/setup/settings/languages'));

			}

		} else {
			$data['title'] = __("Add Language");
			$data['modal'] = 'admin/setup/settings/add_language';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function edit_language($id=0)
	{
		$data['language'] = $this->setting->get_language($id);

		if($this->input->method() === 'post') {

			$this->form_validation->set_rules('name', __('Name'), 'trim|required');
			$this->form_validation->set_rules('code', __('Language Code'), 'trim|required');


			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect(base_url('admin/setup/settings/languages'));
			} else {

				$db_data = array(
					'code' => $this->input->post('code'),
					'name' => $this->input->post('name'),
					'updated_at' => date('Y-m-d H:i:s'),
				);


				$db_data = $this->security->xss_clean($db_data);
				$result = $this->setting->edit_language($db_data, $id);

				if($result) {
                    log_staff('Language edited');
					$this->session->set_flashdata('toast-success', __("Language has been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to update language."));
				}

				redirect(base_url('admin/setup/settings/languages'));

			}

		} else {
			$data['title'] = __("Edit Language");
			$data['modal'] = 'admin/setup/settings/edit_language';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function delete_language($id=0)
	{
		$data['language'] = $this->setting->get_language($id);

		if($this->input->method() === 'post') {

			$result = $this->setting->delete_language($id);

			if($result) {
                log_staff('Language deleted');

				$this->session->set_flashdata('toast-success', __("Language has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete language."));
			}

			redirect(base_url('admin/setup/settings/languages'));

		} else {
			$data['title'] = __("Delete Language");
			$data['modal'] = 'admin/setup/settings/delete_language';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}



	public function add_taxrate()
	{

		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('name', __('Name'), 'trim|required');
			$this->form_validation->set_rules('rate', __('Rate'), 'trim|required|numeric');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect(base_url('admin/setup/settings/taxrates'));
			} else {

				$db_data = array(
					'name' => $this->input->post('name'),
					'rate' => $this->input->post('rate'),
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->setting->add_taxrate($db_data);

				if($result) {
                    log_staff('Tax Rate added');
					$this->session->set_flashdata('toast-success', __("Tax rate has been successfully added."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to add tax rate."));
				}

				redirect(base_url('admin/setup/settings/taxrates'));

			}

		} else {
			$data['title'] = __("Add Tax Rate");
			$data['modal'] = 'admin/setup/settings/add_taxrate';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function edit_taxrate($id=0)
	{
		$data['taxrate'] = $this->setting->get_taxrate($id);

		if($this->input->method() === 'post') {

			$this->form_validation->set_rules('name', __('Name'), 'trim|required');
			$this->form_validation->set_rules('rate', __('Rate'), 'trim|required|numeric');


			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect(base_url('admin/setup/settings/taxrates'));
			} else {

				$db_data = array(
					'name' => $this->input->post('name'),
					'rate' => $this->input->post('rate'),
					'updated_at' => date('Y-m-d H:i:s'),
				);


				$db_data = $this->security->xss_clean($db_data);
				$result = $this->setting->edit_taxrate($db_data, $id);

				if($result) {
                    log_staff('Tax Rate edited');

					$this->session->set_flashdata('toast-success', __("Tax rate has been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to update tax rate."));
				}

				redirect(base_url('admin/setup/settings/taxrates'));

			}

		} else {
			$data['title'] = __("Edit Tax Rate");
			$data['modal'] = 'admin/setup/settings/edit_taxrate';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function delete_taxrate($id=0)
	{
		$data['taxrate'] = $this->setting->get_taxrate($id);

		if($this->input->method() === 'post') {

			$result = $this->setting->delete_taxrate($id);

			if($result) {
                log_staff('Tax Rate deleted');

				$this->session->set_flashdata('toast-success', __("Tax rate has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete tax rate."));
			}

			redirect(base_url('admin/setup/settings/taxrates'));

		} else {
			$data['title'] = __("Delete Tax Rate");
			$data['modal'] = 'admin/setup/settings/delete_taxrate';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}



	public function add_currency()
	{

		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('code', __('Code'), 'trim|required');
			$this->form_validation->set_rules('rate', __('Rate'), 'trim|required|numeric');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect(base_url('admin/setup/settings/currencies'));
			} else {

				$db_data = array(
					'code' => $this->input->post('code'),
					'prefix' => $this->input->post('prefix'),
					'suffix' => $this->input->post('suffix'),
					'rate' => $this->input->post('rate'),
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->setting->add_currency($db_data);

				if($result) {
                    log_staff('Currency added');

					$this->session->set_flashdata('toast-success', __("Currency has been successfully added."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to add currency."));
				}

				redirect(base_url('admin/setup/settings/currencies'));

			}

		} else {
			$data['title'] = __("Add Currency");
			$data['modal'] = 'admin/setup/settings/add_currency';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function edit_currency($id=0)
	{
		$data['currency'] = $this->setting->get_currency($id);

		if($this->input->method() === 'post') {

			$this->form_validation->set_rules('code', __('Code'), 'trim|required');
			$this->form_validation->set_rules('rate', __('Rate'), 'trim|required|numeric');


			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect(base_url('admin/setup/settings/currencies'));
			} else {

				$db_data = array(
					'code' => $this->input->post('code'),
					'prefix' => $this->input->post('prefix'),
					'suffix' => $this->input->post('suffix'),
					'rate' => $this->input->post('rate'),
					'updated_at' => date('Y-m-d H:i:s'),
				);


				$db_data = $this->security->xss_clean($db_data);
				$result = $this->setting->edit_currency($db_data, $id);

				if($result) {
                    log_staff('Currency edited');

					$this->session->set_flashdata('toast-success', __("Currency has been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to update currency."));
				}

				redirect(base_url('admin/setup/settings/currencies'));

			}

		} else {
			$data['title'] = __("Edit Currency");
			$data['modal'] = 'admin/setup/settings/edit_currency';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function delete_currency($id=0)
	{
		$data['currency'] = $this->setting->get_currency($id);

		if($this->input->method() === 'post') {

			$result = $this->setting->delete_currency($id);

			if($result) {
                log_staff('Currency deleted');

				$this->session->set_flashdata('toast-success', __("Currency has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete currency."));
			}

			redirect(base_url('admin/setup/settings/currencies'));

		} else {
			$data['title'] = __("Delete Currency");
			$data['modal'] = 'admin/setup/settings/delete_currency';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}




	public function add_paymentmethod()
	{

		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('status', __('status'), 'trim|required');
			$this->form_validation->set_rules('name', __('name'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect(base_url('admin/setup/settings/payment'));
			} else {

				$db_data = array(
					'status' => $this->input->post('status'),
					'name' => $this->input->post('name'),
					'description' => $this->input->post('description'),
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->setting->add_paymentmethod($db_data);

				if($result) {
                    log_staff('Payment method added');

					$this->session->set_flashdata('toast-success', __("Payment method has been successfully added."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to add payment method."));
				}

				redirect(base_url('admin/setup/settings/payment'));

			}

		} else {
			$data['title'] = __("Add Payment Method");
			$data['modal'] = 'admin/setup/settings/add_paymentmethod';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function edit_paymentmethod($id=0)
	{
		$data['paymentmethod'] = $this->setting->get_paymentmethod($id);

		if($this->input->method() === 'post') {

			$this->form_validation->set_rules('status', __('status'), 'trim|required');
			$this->form_validation->set_rules('name', __('name'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect(base_url('admin/setup/settings/payment'));
			} else {

				$db_data = array(
					'status' => $this->input->post('status'),
					'name' => $this->input->post('name'),
					'description' => $this->input->post('description'),
					'updated_at' => date('Y-m-d H:i:s'),
				);


				$db_data = $this->security->xss_clean($db_data);
				$result = $this->setting->edit_paymentmethod($db_data, $id);

				if($result) {
                    log_staff('Payment method edited');
					$this->session->set_flashdata('toast-success', __("Payment method has been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to update payment mthod."));
				}

				redirect(base_url('admin/setup/settings/payment'));

			}

		} else {
			$data['title'] = __("Edit Payment Method");
			$data['modal'] = 'admin/setup/settings/edit_paymentmethod';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function delete_paymentmethod($id=0)
	{
		$data['paymentmethod'] = $this->setting->get_paymentmethod($id);

		if($this->input->method() === 'post') {

			$result = $this->setting->delete_paymentmethod($id);

			if($result) {
                log_staff('Payment method deleted');

				$this->session->set_flashdata('toast-success', __("Payment method has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete payment method."));
			}

			redirect(base_url('admin/setup/settings/payment'));

		} else {
			$data['title'] = __("Delete Payment Method");
			$data['modal'] = 'admin/setup/settings/delete_paymentmethod';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}







	public function add_expense_category()
	{

		if($this->input->method() === 'post') {

			$this->form_validation->set_rules('name', __('name'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect(base_url('admin/setup/settings/expense_categories'));
			} else {

				$db_data = array(

					'name' => $this->input->post('name'),
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->setting->add_expense_category($db_data);

				if($result) {
                    log_staff('Expense category added');
					$this->session->set_flashdata('toast-success', __("Expense Category has been successfully added."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to add Expense Category."));
				}

				redirect(base_url('admin/setup/settings/expense_categories'));

			}

		} else {
			$data['title'] = __("Add Expense Category");
			$data['modal'] = 'admin/setup/settings/add_expense_category';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function edit_expense_category($id=0)
	{
		$data['expense_category'] = $this->setting->get_expense_category($id);

		if($this->input->method() === 'post') {


			$this->form_validation->set_rules('name', __('name'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect(base_url('admin/setup/settings/expense_categories'));
			} else {

				$db_data = array(

					'name' => $this->input->post('name'),
					'updated_at' => date('Y-m-d H:i:s'),
				);


				$db_data = $this->security->xss_clean($db_data);
				$result = $this->setting->edit_expense_category($db_data, $id);

				if($result) {
                    log_staff('Expense category edited');

					$this->session->set_flashdata('toast-success', __("Expense Category has been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to update Expense Category."));
				}

				redirect(base_url('admin/setup/settings/expense_categories'));

			}

		} else {
			$data['title'] = __("Edit Expense Category");
			$data['modal'] = 'admin/setup/settings/edit_expense_category';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function delete_expense_category($id=0)
	{
		$data['expense_category'] = $this->setting->get_expense_category($id);

		if($this->input->method() === 'post') {

			$result = $this->setting->delete_expense_category($id);

			if($result) {
                log_staff('Expense category deleted');

				$this->session->set_flashdata('toast-success', __("Expense Category has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete Expense Category."));
			}

			redirect(base_url('admin/setup/settings/expense_categories'));

		} else {
			$data['title'] = __("Delete Expense Category");
			$data['modal'] = 'admin/setup/settings/delete_expense_category';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}












	public function add_entity()
	{

		if($this->input->method() === 'post') {
			
			$this->form_validation->set_rules('name', __('name'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect(base_url('admin/setup/settings/entities'));
			} else {

				$db_data = array(
					'name' => $this->input->post('name'),
					'title' => $this->input->post('title'),
					'description' => $this->input->post('description'),

					'invoice_prefix' => $this->input->post('invoice_prefix'),
					'invoice_next' => $this->input->post('invoice_next'),

					'proforma_prefix' => $this->input->post('proforma_prefix'),
					'proforma_next' => $this->input->post('proforma_next'),

					'proposal_prefix' => $this->input->post('proposal_prefix'),
					'proposal_next' => $this->input->post('proposal_next'),

					'receipt_prefix' => $this->input->post('receipt_prefix'),
					'receipt_next' => $this->input->post('receipt_next'),


					'ctr_prefix' => $this->input->post('ctr_prefix'),
					'ctr_next' => $this->input->post('ctr_next'),



					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->setting->add_entity($db_data);

				if($result) {
                    log_staff('Entity added');
					$this->session->set_flashdata('toast-success', __("Entity has been successfully added."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to add entity."));
				}

				redirect(base_url('admin/setup/settings/entities'));

			}

		} else {
			$data['title'] = __("Add Entity");
			$data['modal'] = 'admin/setup/settings/add_entity';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function edit_entity($id=0)
	{
		$data['entity'] = $this->setting->get_entity($id);

		if($this->input->method() === 'post') {

	
			$this->form_validation->set_rules('name', __('name'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect(base_url('admin/setup/settings/entities'));
			} else {

				$db_data = array(
					'name' => $this->input->post('name'),
					'title' => $this->input->post('title'),
					'description' => $this->input->post('description'),

					'invoice_prefix' => $this->input->post('invoice_prefix'),
					'invoice_next' => $this->input->post('invoice_next'),

					'proforma_prefix' => $this->input->post('proforma_prefix'),
					'proforma_next' => $this->input->post('proforma_next'),

					'proposal_prefix' => $this->input->post('proposal_prefix'),
					'proposal_next' => $this->input->post('proposal_next'),

					'receipt_prefix' => $this->input->post('receipt_prefix'),
					'receipt_next' => $this->input->post('receipt_next'),

					'ctr_prefix' => $this->input->post('ctr_prefix'),
					'ctr_next' => $this->input->post('ctr_next'),

					'updated_at' => date('Y-m-d H:i:s'),
				);


				$db_data = $this->security->xss_clean($db_data);
				$result = $this->setting->edit_entity($db_data, $id);

				if($result) {
                    log_staff('Entity edited');

					$this->session->set_flashdata('toast-success', __("Entity has been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to update entity."));
				}

				redirect(base_url('admin/setup/settings/entities'));

			}

		} else {
			$data['title'] = __("Edit Entity");
			$data['modal'] = 'admin/setup/settings/edit_entity';

            $clear_notes = $data['entity']['description'];
            $data = html_escape($data);
            $data['entity']['description'] = purify($clear_notes);


			$this->load->view('admin/layout_modal', $data);
		}

	}

	public function delete_entity($id=0)
	{
		$data['entity'] = $this->setting->get_entity($id);

		if($this->input->method() === 'post') {

			$result = $this->setting->delete_entity($id);

			if($result) {
                log_staff('Entity deleted');

				$this->session->set_flashdata('toast-success', __("Entity has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete entity."));
			}

			redirect(base_url('admin/setup/settings/entities'));

		} else {
			$data['title'] = __("Delete Entity");
			$data['modal'] = 'admin/setup/settings/delete_entity';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}








	public function edit_email_template($id=0)
	{
		$data['template'] = $this->setting->get_email_template($id);

		if($this->input->method() === 'post') {

			$this->form_validation->set_rules('subject', __('Email Subject'), 'trim|required');
			$this->form_validation->set_rules('body', __('Email Body'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect(base_url('admin/setup/settings/email_templates'));
			} else {

				$db_data = array(
					'subject' => $this->input->post('subject'),
					'body' => $this->input->post('body'),
					'updated_at' => date('Y-m-d H:i:s'),
				);


				$db_data = $this->security->xss_clean($db_data);
				$result = $this->setting->edit_email_template($db_data, $id);

				if($result) {
                    log_staff('Email template updated');

					$this->session->set_flashdata('toast-success', __("Email template has been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to update email template."));
				}

				redirect(base_url('admin/setup/settings/email_templates'));

			}

		} else {
			$data['title'] = __("Edit Email Template");
			$data['modal'] = 'admin/setup/settings/edit_email_template';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}



	public function edit_translation($id=0)
	{
		$data['title'] = __("Edit Translation");
		$data['page'] = 'admin/setup/settings/edit_translation';

		$data['translations'] = $this->setting->get_translations($id);
		$data['language_id'] = $id;

		if($this->input->method() === 'post') {

			foreach($data['translations'] as $translation) {
				if($this->input->post($translation['id'])) {
					$this->db->where('id', $translation['id']);
					$this->db->update('core_translations', [ 'translated_string' => $this->input->post($translation['id']) ]);
				}

			}

            log_staff('Translation updated');
			$this->session->set_flashdata('toast-success', __("Translation has been successfully updated."));
			redirect(base_url('admin/setup/settings/edit_translation/'.$id));

		} else {
			$this->load->view('admin/layout_page', html_escape($data));
		}


	}


}
