<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tickets extends User_Controller {

	public function __construct()
	{
		parent::__construct();

        enforce_user_permission('tickets');

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

		$this->load->library('datatables');
	}



	public function json_all() {
		$this->datatables
			->select('app_tickets.id, app_tickets.ticket, app_tickets.subject, app_tickets.email, app_tickets.status, app_tickets.priority, app_tickets.created_at, app_tickets.updated_at')
			->from('app_tickets')
            ->where('app_tickets.client_id', $this->session->client_id)

			->join('core_staff', 'app_tickets.assigned_to = core_staff.id', 'LEFT')
			->select('core_staff.name as assigned_to')
			->join('core_users', 'app_tickets.user_id = core_users.id', 'LEFT')
			->select('core_users.name as user_name')

			->join('app_clients', 'app_tickets.client_id = app_clients.id', 'LEFT')
			->select('app_clients.name as client_name')


			->join('app_assets', 'app_tickets.asset_id = app_assets.id', 'LEFT')
			->select('app_assets.tag as asset_tag')

			->join('app_licenses', 'app_tickets.license_id = app_licenses.id', 'LEFT')
			->select('app_licenses.tag as license_tag')

			->join('app_projects', 'app_tickets.project_id = app_projects.id', 'LEFT')
			->select('app_projects.name as project_name')

			->edit_column_if('status', '<span class="label label-primary">'.__("Open").'</span>', '', 'Open')
			->edit_column_if('status', '<span class="label label-warning">'.__("In Progress").'</span>', '', 'In Progress')
			->edit_column_if('status', '<span class="label label-success">'.__("Answered").'</span>', '', 'Answered')
			->edit_column_if('status', '<span class="label label-danger">'.__("Reopened").'</span>', '', 'Reopened')
			->edit_column_if('status', '<span class="label label-default">'.__("Closed").'</span>', '', 'Closed')

			->edit_column_if('priority', '<span class="label label-inverse-success">'.__("Low").'</span>', '', 'Low')
			->edit_column_if('priority', '<span class="label label-inverse-primary">'.__("Normal").'</span>', '', 'Normal')
			->edit_column_if('priority', '<span class="label label-inverse-danger">'.__("High").'</span>', '', 'High')

			->edit_column('subject', '<a href="'.base_url('tickets/view/').'$1">$2</a>', 'id,subject')

			->add_column('relations', '')

			->add_column(
				'actions',
				'<div class="btn-group" role="group">'.
					'<a href="'.base_url('tickets/view/').'$1" data-toggle="tooltip" title="'.__("View Ticket").'" type="button" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-eye"></i></a>'.
				
				'</div>',
				'id'
			);

		$results = $this->datatables->generate('json');
		$results = json_decode($results, TRUE);

		foreach($results['data'] as $key => $value) {

			if($results['data'][$key]['client_name'] != "") {
				if($results['data'][$key]['user_name'] != "") {
					$results['data'][$key]['user_name'] .= " | " . $results['data'][$key]['client_name'];
				} else {
					$results['data'][$key]['user_name'] .= $results['data'][$key]['client_name'];
				}
			}

			if($results['data'][$key]['user_name'] != "") {
				$results['data'][$key]['email'] = "<b>" . $results['data'][$key]['user_name'] . "</b><br>" . $results['data'][$key]['email'];
			} else {
				$results['data'][$key]['email'] = $results['data'][$key]['email'];
			}

            
            $results['data'][$key]['created_at'] = datetime_display($results['data'][$key]['created_at']);
            $results['data'][$key]['updated_at'] = datetime_display($results['data'][$key]['updated_at']);

		
		}

		echo json_encode($results);
	}







	public function index()
	{
		$data['title'] = __("All Tickets");
		$data['page'] = 'user/tickets/list';

        log_user('Viewed tickets');


		$this->load->view('user/layout_page', html_escape($data));
	}




	public function add()
	{
		$data['staff'] = $this->staff->get_all_active();
		$data['users'] = $this->user->get_all();

        $data['assets'] = $this->asset->get_all($this->session->client_id);
        $data['licenses'] = $this->license->get_all($this->session->client_id);
        $data['projects'] = $this->project->get_all($this->session->client_id);

		$data['customfields'] = $this->customfield->get_for('Tickets');

		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('subject', __('Subject'), 'trim|required');
			
			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {

                $user = $this->db->get_where('core_users', ['id' => $this->session->user_id])->row_array();

				$db_data = array(
                    'uuid' => guidv4(),
					'ticket' => random_ticket(8),
					'user_id' => $this->session->user_id,
					'assigned_to' => 0,

					'client_id' => $this->session->client_id,

					'asset_id' => strip_tags($this->input->post('asset_id')),
					'license_id' => strip_tags($this->input->post('license_id')),
					'project_id' => strip_tags($this->input->post('project_id')),

					'email' => $user['email'],
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
                    'user_id' => $this->session->user_id,
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
                $staff_notifiable = $this->staff->get_all_ticket_notifiable();
                foreach ($staff_notifiable as $item) {
                    $this->mailer->send("Staff | New ticket", [ "staff_id" => $item['id'], 'ticket_id' => $reply['ticket_id'] ]);
                }
                  
                // send new ticket created notification to user
                $reply = $this->ticket->get_reply($result);
                $ticket = $this->ticket->get($reply['ticket_id']);
                $this->mailer->send("User | New ticket", [ "email_address" => $ticket['email'], 'ticket_id' => $reply['ticket_id'] ]);
            

				if($result) {
                    log_user('Added ticket ' . $reply['ticket_id']);

					$this->session->set_flashdata('toast-success', __("Ticket has been successfully added."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to add ticket."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$data['title'] = __("Add Ticket");
			$data['modal'] = 'user/tickets/add';

			$this->load->view('user/layout_modal', html_escape($data));
		}

	}



	public function add_reply($id=0)
	{

		if($this->input->method() === 'post') {

			$data['ticket'] = $this->ticket->get($id);


			$db_data = array(
				'status' => "Reopened",
				'updated_at' => date('Y-m-d H:i:s'),
			);

			$db_data = $this->security->xss_clean($db_data);
			$result = $this->ticket->edit($db_data, $id);


			$db_reply_data = array(
				'ticket_id' => $id,
				'staff_id' => 0,
                'user_id' => $this->session->user_id,
				'message' => $this->input->post('message'),
				'created_at' => date('Y-m-d H:i:s'),
			);
			$db_reply_data = $this->security->xss_clean($db_reply_data);
			$this->db->insert('app_ticket_replies', $db_reply_data);
			$reply_id = $this->db->insert_id();

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
					'reply_id' => $reply_id,
					'file' => $saved_file,
                    'name' => $saved_file,
					'created_at' => date('Y-m-d H:i:s'),
				);
				$db_file_data = $this->security->xss_clean($db_file_data);
				$this->db->insert('app_ticket_reply_files', $db_file_data);
			}


			// send new reply notification to staff  
            $staff_notifiable = $this->staff->get_all_notifiable();
            foreach ($staff_notifiable as $item) {
                $this->mailer->send("Staff | New ticket reply", [ "staff_id" => $item['id'], 'ticket_id' => $data['ticket']['id'], 'reply_id' => $reply_id ]);
            }


			if($result) {
                log_user('Added ticket reply ' . $data['ticket']['id']);

				$this->session->set_flashdata('toast-success', __("Reply has been successfully updated."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to update ticket."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			die("Invalid operation!");
		}

	}




    public function view($id=0)
	{
		$data['ticket'] = $this->ticket->get($id);

        if($this->session->client_id != $data['ticket']['client_id']) die('Unauthorized!');

		$data['user'] = $this->user->get($data['ticket']['user_id']);

		$data['assigned_to'] = $this->staff->get($data['ticket']['assigned_to']);

		$data['comments'] = $this->ticket->get_comments($id);
		$data['replies'] = $this->ticket->get_replies($id);

		$data['customfields'] = $this->customfield->get_for('Tickets');

		$data['title'] = __("Ticket #") . $data['ticket']['ticket'];
		$data['page'] = 'user/tickets/view';

        log_user('Viewed ticket ' . $id);


        
        $clear_cf = $data['ticket']['custom_fields_values'];
        $data['ticket'] = html_escape($data['ticket']);
        $data['ticket']['custom_fields_values'] = $clear_cf;


        $data['user'] = html_escape($data['user']);
        $data['assigned_to'] = html_escape($data['assigned_to']);
        $data['comments'] = html_escape($data['comments']);


		$this->load->view('user/layout_page', $data);


	}

    public function download_reply_file($id=0)
	{
		$data['file'] = $this->ticket->get_reply_file($id);
		$data['ticket'] = $this->ticket->get($data['file']['ticket_id']);

        log_user('Downloaded ticket file ' . $id);

		force_download($data['file']['name'], read_file("./filestore/main/tickets/" . $data['file']['file']));
	}




}