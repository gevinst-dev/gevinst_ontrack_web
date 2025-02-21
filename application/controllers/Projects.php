<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Projects extends User_Controller {

	public function __construct()
	{
		parent::__construct();

        enforce_user_permission('projects');

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

		$this->load->library('datatables');
	}




	public function json_all() {
		$this->datatables
			->select('app_projects.id, app_projects.name, app_projects.status')
			->from('app_projects')
            ->where('app_projects.client_id', $this->session->client_id)

			->join('app_clients', 'app_projects.client_id = app_clients.id', 'LEFT')
			->select('app_clients.name as client_name')


			->add_column(
				'actions',
				'<div class="btn-group" role="group">'.
					'<a href="'.base_url('projects/details/').'$1" data-toggle="tooltip" title="'.__("Manage Project").'" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-eye"></i></a>'.
					
				'</div>',
				'id'
			);

		echo $this->datatables->generate();
	}



	public function json_issues($id=0) {
		$this->datatables
			->select('app_issues.id, app_issues.name, app_issues.status, app_issues.due_date, app_issues.priority, app_issues.type')
			->from('app_issues')

			->where('app_issues.project_id', $id)

			->join('core_staff', 'app_issues.assigned_to = core_staff.id', 'LEFT')
			->select('core_staff.name as assigned_to')

			->join('app_project_milestones', 'app_issues.milestone_id = app_project_milestones.id', 'LEFT')
			->select('app_project_milestones.name as milestone')


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

					'<button data-modal="issues/quick_view/$1" data-toggle="tooltip" title="'.__("View Issue").'" type="button" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-eye"></i></button>'.
					
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

		

			}

			$results['data'][$key]['name'] = format_issue_icon($results['data'][$key]['type']) . " " . $results['data'][$key]['name'];

		}

		echo json_encode($results);
	}




	public function json_tickets($id=0) {
		$this->datatables
			->select('app_tickets.id, app_tickets.ticket, app_tickets.subject, app_tickets.email, app_tickets.status, app_tickets.priority')

			->where('app_tickets.project_id', $id)

			->from('app_tickets')
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

		
		}

		echo json_encode($results);
	}




	public function json_milestones($id=0) {

		$this->datatables
			->select('app_project_milestones.id, app_project_milestones.name, app_project_milestones.due_date')
			->from('app_project_milestones')

			->where('app_project_milestones.project_id', $id)

			;



		$results = $this->datatables->generate('json');
		$results = json_decode($results, TRUE);

		foreach($results['data'] as $key => $value) {

			$results['data'][$key]['due_date'] = date_display($value['due_date']);

		}

		echo json_encode($results);

	}



    public function index()
	{
		$data['title'] = __("Projects");
		$data['page'] = 'user/projects/list';


        log_user('Viewed projects');

		$this->load->view('user/layout_page', html_escape($data));
	}







	public function details($id=0)
	{
		$data['project'] = $this->project->get($id);

		$data['files'] = $this->project->get_files($id);
		$data['milestones'] = $this->project->get_milestones($id);
		$data['comments'] = $this->project->get_comments($id);
		$data['credentials'] = $this->project->get_credentials($id);


		$data['customfields'] = $this->customfield->get_for('Projects');

		$data['staff'] = $this->staff->get_all();

		$data['title'] = __("Project") . " - " . $data['project']['name'];
		$data['section'] = 'details';
		$data['page'] = 'user/projects/index';

        log_user('Viewed project ' . $id);





        $clear_notes = $data['project']['notes'];
        $clear_notesdesc = $data['project']['description'];
        $clear_cf = $data['project']['custom_fields_values'];

        $data = html_escape($data);

        $data['project']['notes'] = purify($clear_notes);
        $data['project']['description'] = purify($clear_notesdesc);
        $data['project']['custom_fields_values'] = $clear_cf;




		$this->load->view('user/layout_page', $data);
	}


	public function milestones($id=0)
	{
		$data['project'] = $this->project->get($id);

		$data['files'] = $this->project->get_files($id);
		$data['milestones'] = $this->project->get_milestones($id);
		$data['comments'] = $this->project->get_comments($id);

		$data['staff'] = $this->staff->get_all();

		$data['title'] = __("Project") . " - " . $data['project']['name'];
		$data['section'] = 'milestones';
		$data['page'] = 'user/projects/index';

        log_user('Viewed project milestones ' . $id);

		$this->load->view('user/layout_page', html_escape($data));
	}


	public function issues($id=0)
	{
		$data['project'] = $this->project->get($id);

		$data['files'] = $this->project->get_files($id);
		$data['milestones'] = $this->project->get_milestones($id);
		$data['comments'] = $this->project->get_comments($id);


		$data['staff'] = $this->staff->get_all();

		$data['title'] = __("Project") . " - " . $data['project']['name'];
		$data['section'] = 'issues';
		$data['page'] = 'user/projects/index';

        log_user('Viewed project issues ' . $id);

		$this->load->view('user/layout_page', html_escape($data));
	}





	public function tickets($id=0)
	{
		$data['project'] = $this->project->get($id);


		$data['title'] = __("Project") . " - " . $data['project']['name'];
		$data['section'] = 'tickets';
		$data['page'] = 'user/projects/index';

        log_user('Viewed project tickets ' . $id);

		$this->load->view('user/layout_page', html_escape($data));
	}






	public function upload_file($id)
	{
		$data['project'] = $this->project->get($id);

		if($this->input->method() === 'post') {

			$config['upload_path']                = './filestore/main/projects/';
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
				'project_id' => $id,
				'added_by' => $this->session->staff_id,
				'file' => $this->upload->data('file_name'),
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
			);

			$db_data = $this->security->xss_clean($db_data);
			$result = $this->project->add_file($db_data);

			if($result) {
                log_user('Uploaded project file ' . $result);

				$this->session->set_flashdata('toast-success', __("File has been successfully uploaded."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to upload file."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			$data['title'] = __("Upload File");
			$data['modal'] = 'user/projects/upload_file';

			$this->load->view('user/layout_modal', html_escape($data));
		}

	}


    public function download_file($id=0)
	{
		$data['file'] = $this->project->get_file($id);
		$data['project'] = $this->project->get($data['file']['project_id']);

        log_user('Downloaded project file ' . $id);

		force_download("./filestore/main/projects/" . $data['file']['file'], NULL);
	}




}