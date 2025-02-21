<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Issues extends User_Controller {

	public function __construct()
	{
		parent::__construct();

        enforce_user_permission('issues');

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
        $this->load->model('admin/issue_model', 'issue');

		$this->load->library('datatables');
	}





	public function json_all() {
		$this->datatables
			->select('app_issues.id, app_issues.name, app_issues.status, due_date, app_issues.priority, app_issues.type')
			->from('app_issues')
            ->where('app_issues.client_id', $this->session->client_id)

			->join('core_staff', 'app_issues.assigned_to = core_staff.id', 'LEFT')
			->select('core_staff.name as assigned_to')
			->edit_column_if('status', '<span class="label label-primary">'.__("To Do").'</span>', 'id', 'To Do')
			->edit_column_if('status', '<span class="label label-warning">'.__("In Progress").'</span>', '', 'In Progress')
			->edit_column_if('status', '<span class="label label-success">'.__("Done").'</span>', '', 'Done')


			->edit_column_if('priority', '<span class="label label-inverse-success">'.__("Low").'</span>', '', 'Low')
			->edit_column_if('priority', '<span class="label label-inverse-primary">'.__("Normal").'</span>', '', 'Normal')
			->edit_column_if('priority', '<span class="label label-inverse-danger">'.__("High").'</span>', '', 'High')

			->edit_column('name', '<a href="'.base_url('issues/view/').'$1">$2</a>', 'id,name')

			->add_column(
				'actions',
				'<div class="btn-group" role="group">'.
					'<a href="'.base_url('issues/view/').'$1" data-toggle="tooltip" title="'.__("View Issue").'" type="button" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-eye"></i></a>'.
					
				'</div>',
				'id'
			);

		$results = $this->datatables->generate('json');
		$results = json_decode($results, TRUE);

		foreach($results['data'] as $key => $value) {

			if(strpos($value['status'], 'label-success') !== false) {
				$results['data'][$key]['due_date'] = date_display($value['due_date']);

			} else {
				if(date('Y-m-d') > $value['due_date']) {
					$results['data'][$key]['due_date'] = "<span class='text-danger' data-toggle='tooltip' title='".__("Overdue")."'>".date_display($value['due_date'])."</span>";
				}
				if($value['due_date'] > date('Y-m-d')) {
					$results['data'][$key]['due_date'] = "<span class='text-primary'>".date_display($value['due_date'])."</span>";
				}

				if($results['data'][$key]['assigned_to'] == "") {
					$results['data'][$key]['assigned_to'] = '<a data-modal="admin/issues/assign/'.$value['id'].'" data-toggle="tooltip" title="'.__("Click to assign").'" class="text-default">'.__("Unassigned").'</a>';
				} else {
					$results['data'][$key]['assigned_to'] = '<a data-modal="admin/issues/assign/'.$value['id'].'" data-toggle="tooltip" title="'.__("Click to reassign").'" >'.$value['assigned_to'].'</a>';
				}


			}

			$results['data'][$key]['name'] = format_issue_icon($results['data'][$key]['type']) . " " . $results['data'][$key]['name'];

		}

		echo json_encode($results);
	}




	public function index()
	{
		$data['title'] = __("All Issues");
		$data['page'] = 'user/issues/list';

        log_user('Viewed issues');

		$this->load->view('user/layout_page', html_escape($data));
	}





	public function add()
	{
		$data['staff'] = $this->staff->get_all();

		$data['customfields'] = $this->customfield->get_for('Issues');

        $data['assets'] = $this->asset->get_all($this->session->client_id);
        $data['licenses'] = $this->license->get_all($this->session->client_id);
        $data['projects'] = $this->project->get_all($this->session->client_id);


		if($this->input->method() === 'post') {
			
			$this->form_validation->set_rules('priority', __('Priority'), 'trim|required');
			$this->form_validation->set_rules('name', __('Name'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {

				$db_data = array(
					'added_by' => 0,
					'assigned_to' => 0,
					'client_id' => $this->session->client_id,
					'user_id' => $this->session->user_id,
					'asset_id' => strip_tags($this->input->post('asset_id')),
					'license_id' => strip_tags($this->input->post('license_id')),
					'project_id' => strip_tags($this->input->post('project_id')),
					'status' => "To Do",
					'type' => strip_tags($this->input->post('type')),
					'priority' => strip_tags($this->input->post('priority')),
					'name' => strip_tags($this->input->post('name')),
					'description' => $this->input->post('description'),
					'due_date' => date_to_db($this->input->post('due_date')),
					'custom_fields_values' => json_encode($this->input->post('customfield')),
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->issue->add($db_data);

				if($result) {
                    log_user('Added issue ' . $result);

                    $staff_notifiable = $this->staff->get_all_notifiable();
                    foreach ($staff_notifiable as $item) {
                        $this->mailer->send("Staff | New Issue", [ "staff_id" => $item['id'], 'task_id' => $result ]);
                    }


					$this->session->set_flashdata('toast-success', __("Issue has been successfully added."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to add issue."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$data['title'] = __("Add Issue");
			$data['modal'] = 'user/issues/add';

			$this->load->view('user/layout_modal', html_escape($data));
		}

	}




    public function view($id=0)
	{
		$data['issue'] = $this->issue->get($id);

        if($this->session->client_id != $data['issue']['client_id']) die('Unauthorized!');

		$data['added_by'] = $this->staff->get($data['issue']['added_by']);
		$data['assigned_to'] = $this->staff->get($data['issue']['assigned_to']);

		$data['comments'] = $this->issue->get_comments($id);
		$data['files'] = $this->issue->get_files($id);

		$data['customfields'] = $this->customfield->get_for('Issues');

		$data['title'] = __("View Issue");
		$data['page'] = 'user/issues/view';

        log_user('Viewed issue ' . $id);

        $clear_notes = $data['issue']['description'];
        $clear_cf = $data['issue']['custom_fields_values'];
        $data = html_escape($data);
        $data['issue']['description'] = purify($clear_notes);
        $data['issue']['custom_fields_values'] = $clear_cf;


		$this->load->view('user/layout_page', $data);


	}





	public function upload_file($id)
	{
		$data['issue'] = $this->issue->get($id);

		if($this->input->method() === 'post') {

			$config['upload_path']                = './filestore/main/issues/';
			$config['allowed_types']              = 'gif|jpg|png|pdf|xls|xlsx|doc|docx|ppt|pptx|txt|zip|jpeg|rar|psd|mpg|cdr|avi|mp4|mkv|flv|7z';
			$config['file_ext_tolower']           = TRUE;
			$config['max_filename_increment']     = 1000;
			$this->load->library('upload', $config);

			if(!empty($_FILES['userfile']['name'])) {
				if(!$this->upload->do_upload('userfile')) { $this->session->set_flashdata('toast-error', __("Error uploading! Check file type or size.")); redirect($_SERVER['HTTP_REFERER']); }
			} else {
				$this->session->set_flashdata('toast-error', __("Please select a file."));
				redirect($_SERVER['HTTP_REFERER']);
				exit;
			}

			$db_data = array(
				'issue_id' => $id,
				'added_by' => $this->session->staff_id,
				'file' => $this->upload->data('file_name'),
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
			);

			$db_data = $this->security->xss_clean($db_data);
			$result = $this->issue->add_file($db_data);

			if($result) {
                log_user('Uploaded issue file ' . $result);

				$this->session->set_flashdata('toast-success', __("File has been successfully uploaded."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to upload file."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			$data['title'] = __("Upload File");
			$data['modal'] = 'user/issues/upload_file';

			$this->load->view('user/layout_modal', html_escape($data));
		}

	}



    public function download_file($id=0)
	{
		$data['file'] = $this->issue->get_file($id);
		$data['issue'] = $this->issue->get($data['file']['issue_id']);

        log_user('Downloaded issue file ' . $id);

		force_download("./filestore/main/issues/" . $data['file']['file'], NULL);
	}





}