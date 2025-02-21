<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Submit_ticket extends Public_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('admin/setting_model', 'setting');
        $this->load->model('admin/customfield_model', 'customfield');
        $this->load->model('admin/attribute_model', 'attribute');
        $this->load->model('admin/user_model', 'user');
        $this->load->model('admin/staff_model', 'staff');

		$this->load->model('admin/asset_model', 'asset');
		$this->load->model('admin/license_model', 'license');
		$this->load->model('admin/domain_model', 'domain');
		$this->load->model('admin/credential_model', 'credential');
        $this->load->model('admin/project_model', 'project');

        $this->load->model('admin/ticket_model', 'ticket');

	}










	public function index()
	{
		$data['title'] = __("Submit Ticket");
		$data['page'] = 'user/submit_ticket';

        $data['customfields'] = $this->customfield->get_for('Tickets');



        if($this->input->method() === 'post') {
			$this->form_validation->set_rules('subject', __('Subject'), 'trim|required');
		
			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {


                if(get_setting('google_recaptcha') == '1') {
                    $captchatest = check_recaptcha($_POST["g-recaptcha-response"]);

                    if($captchatest == false) {
                        $this->session->set_flashdata('toast-error', __("Captcha validation failed!"));
                        redirect($_SERVER['HTTP_REFERER']);
                    }
                }

                $user_id = 0;
                $user = $this->db->get_where('core_users', ['email' => $this->input->post('email')])->row_array();

                if($user) {
                    $user_id = $user['id'];
                }


				$db_data = array(
                    'uuid' => guidv4(),
					'ticket' => random_ticket(8),
					'user_id' => $user_id,
					'assigned_to' => 0,
					'client_id' => $this->session->client_id,
					'asset_id' => 0,
					'license_id' => 0,
					'project_id' => 0,
					'email' => strip_tags($this->input->post('email')),
					'cc' => strip_tags($this->input->post('cc')),
					'status' => "Open",
					'priority' => strip_tags($this->input->post('priority')),
					'subject' => strip_tags($this->input->post('subject')),
					'custom_fields_values' => json_encode($this->input->post('customfield')),
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_reply_data = array(
					'staff_id' => 0,
                    'user_id' => $user_id,
					'message' => $this->input->post('message'),
					'created_at' => date('Y-m-d H:i:s'),
				);


				$db_data = $this->security->xss_clean($db_data);
				$db_reply_data = $this->security->xss_clean($db_reply_data);

				$result = $this->ticket->add($db_data, $db_reply_data);


				$config['upload_path']                = FCPATH . '/filestore/main/tickets/';
				$config['allowed_types']              = 'gif|jpg|png|pdf|xls|xlsx|doc|docx|ppt|pptx|txt|zip|jpeg|rar|psd|mpg|cdr|avi|mp4|mkv|flv|7z';
				$config['file_ext_tolower']           = TRUE;
				$config['max_filename_increment']     = 1000;
				$saved_files = [];

				if(!empty($_FILES['userfiles']['name'])) {

					$filesCount = count($_FILES['userfiles']['name']);

					for($i = 0; $i < $filesCount; $i++) {
						$_FILES['file']['name']     = $_FILES['userfiles']['name'][$i];
		                $_FILES['file']['type']     = $_FILES['userfiles']['type'][$i];
		                $_FILES['file']['tmp_name'] = $_FILES['userfiles']['tmp_name'][$i];
		                $_FILES['file']['error']     = $_FILES['userfiles']['error'][$i];
		                $_FILES['file']['size']     = $_FILES['userfiles']['size'][$i];

						$this->load->library('upload', $config);
						$this->upload->initialize($config);

						if($this->upload->do_upload('file')) {
							array_push($saved_files, $this->upload->data('file_name'));
						}
					}
				}

				foreach ($saved_files as $saved_file) {
					$db_file_data = array(
						'reply_id' => $result,
						'file' => $saved_file,
                        'name' => $saved_file,
						'created_at' => date('Y-m-d H:i:s'),
					);
					$db_file_data = $this->security->xss_clean($db_file_data);
					$this->db->insert('app_ticket_reply_files', $db_file_data);
				}

		
                $reply = $this->ticket->get_reply($result);
                $staff_notifiable = $this->staff->get_all_notifiable();
                foreach ($staff_notifiable as $item) {
                    $this->mailer->send("Staff | New ticket", [ "staff_id" => $item['id'], 'ticket_id' => $reply['ticket_id'] ]);
                }
                  
                // send new ticket created notification to user
                $reply = $this->ticket->get_reply($result);
                $ticket = $this->ticket->get($reply['ticket_id']);
                $this->mailer->send("User | New ticket", [ "email_address" => $ticket['email'], 'ticket_id' => $reply['ticket_id'] ]);
            

				if($result) {
                    log_user('Ticket submitted ' . $reply['ticket_id']);

					$this->session->set_flashdata('toast-success', __("Ticket has been successfully added."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to add ticket."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$this->load->view('user/layout_page', html_escape($data));
		}



		
	}






    public function view($id=0)
	{
		$data['ticket'] = $this->ticket->get($id);

		$data['user'] = $this->user->get($data['ticket']['user_id']);

		$data['assigned_to'] = $this->staff->get($data['ticket']['assigned_to']);

		$data['comments'] = $this->ticket->get_comments($id);
		$data['replies'] = $this->ticket->get_replies($id);

		$data['customfields'] = $this->customfield->get_for('Tickets');

		$data['title'] = __("Ticket #") . $data['ticket']['ticket'];
		$data['page'] = 'user/tickets/view';

		$this->load->view('user/layout_page', html_escape($data));


	}






}