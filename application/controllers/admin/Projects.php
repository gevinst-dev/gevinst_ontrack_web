<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Projects extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('admin/project_model', 'project');
		$this->load->model('admin/staff_model', 'staff');
		$this->load->model('admin/issue_model', 'issue');
		$this->load->model('admin/client_model', 'client');
		$this->load->model('admin/ticket_model', 'ticket');
		$this->load->model('admin/user_model', 'user');
        $this->load->model('admin/asset_model', 'asset');

		$this->load->model('admin/customfield_model', 'customfield');

		$this->load->library('datatables');
	}


	public function json_all() {
        enforce_permission('projects-view');

		$this->datatables
			->select('app_projects.id, app_projects.name, app_projects.status')
			->from('app_projects')

			->join('app_clients', 'app_projects.client_id = app_clients.id', 'LEFT')
			->select('app_clients.name as client_name')


			->add_column(
				'actions',
				'<div class="btn-group" role="group">'.
					'<a href="'.base_url('admin/projects/details/').'$1" data-toggle="tooltip" title="'.__("Manage Project").'" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-eye"></i></a>'.
					'<button data-modal="admin/projects/edit/$1" data-toggle="tooltip" title="'.__("Edit Project").'" type="button" class="btn btn-success btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-edit"></i></button>'.
					'<button data-modal="admin/projects/delete/$1" data-toggle="tooltip" title="'.__("Delete Project").'" type="button" class="btn btn-danger btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-trash"></i></button>'.
				'</div>',
				'id'
			);

		echo $this->datatables->generate();
	}



	public function json_issues($id=0) {
        enforce_permission('issues-view');

		$this->datatables
			->select('app_issues.id, app_issues.name, app_issues.status, app_issues.due_date, app_issues.priority, app_issues.type')
			->from('app_issues')

			->where('app_issues.project_id', $id)

			->join('core_staff', 'app_issues.assigned_to = core_staff.id', 'LEFT')
			->select('core_staff.name as assigned_to')

			->join('app_project_milestones', 'app_issues.milestone_id = app_project_milestones.id', 'LEFT')
			->select('app_project_milestones.name as milestone')


			->edit_column_if('status', '<a data-modal="admin/issues/set_inprogress/$1" href="" data-toggle="tooltip" title="'.__("Set in progress").'"><span class="label label-primary">'.__("To Do").'</span></a>', 'id', 'To Do')
			->edit_column_if('status', '<a data-modal="admin/issues/set_done/$1" href="" data-toggle="tooltip" title="'.__("Set completed").'"><span class="label label-warning">'.__("In Progress").'</span></a>', '', 'In Progress')
			->edit_column_if('status', '<span class="label label-success">'.__("Done").'</span>', '', 'Done')


			->edit_column_if('priority', '<span class="label label-inverse-success">'.__("Low").'</span>', '', 'Low')
			->edit_column_if('priority', '<span class="label label-inverse-primary">'.__("Normal").'</span>', '', 'Normal')
			->edit_column_if('priority', '<span class="label label-inverse-danger">'.__("High").'</span>', '', 'High')

			->edit_column('name', '<a href="'.base_url('admin/issues/view/').'$1">$2</a>', 'id,name')

			->add_column(
				'actions',
				'<div class="btn-group" role="group">'.

					'<button data-modal="admin/issues/quick_view/$1" data-toggle="tooltip" title="'.__("View Issue").'" type="button" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-eye"></i></button>'.
					'<button data-modal="admin/issues/edit/$1" data-toggle="tooltip" title="'.__("Edit Issue").'" type="button" class="btn btn-success btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-edit"></i></button>'.
					'<button data-modal="admin/issues/delete/$1" data-toggle="tooltip" title="'.__("Delete Issue").'" type="button" class="btn btn-danger btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-trash"></i></button>'.
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




	public function json_tickets($id=0) {
        enforce_permission('tickets-view');

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

			->edit_column('subject', '<a href="'.base_url('admin/tickets/view/').'$1">$2</a>', 'id,subject')

			->add_column(
				'actions',
				'<div class="btn-group" role="group">'.
					'<a href="'.base_url('admin/tickets/view/').'$1" data-toggle="tooltip" title="'.__("View Ticket").'" type="button" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-eye"></i></a>'.
					'<button data-modal="admin/tickets/edit/$1" data-toggle="tooltip" title="'.__("Edit Ticket").'" type="button" class="btn btn-success btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-edit"></i></button>'.
					'<button data-modal="admin/tickets/delete/$1" data-toggle="tooltip" title="'.__("Delete Ticket").'" type="button" class="btn btn-danger btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-trash"></i></button>'.
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

			if($results['data'][$key]['assigned_to'] == "") {
				$results['data'][$key]['assigned_to'] = '<a data-modal="admin/tickets/assign/'.$value['id'].'" data-toggle="tooltip" title="'.__("Click to assign").'" class="text-default">'.__("Unassigned").'</a>';
			} else {
				$results['data'][$key]['assigned_to'] = '<a data-modal="admin/tickets/assign/'.$value['id'].'" data-toggle="tooltip" title="'.__("Click to reassign").'" >'.$value['assigned_to'].'</a>';
			}
		}

		echo json_encode($results);
	}




	public function json_milestones($id=0) {

        enforce_permission('projects-view');

		$this->datatables
			->select('app_project_milestones.id, app_project_milestones.name, app_project_milestones.due_date')
			->from('app_project_milestones')

			->where('app_project_milestones.project_id', $id)



			->add_column(
				'actions',
				'<div class="btn-group" role="group">'.
					'<button data-modal="admin/projects/edit_milestone/$1" data-toggle="tooltip" title="'.__("Edit Milestone").'" type="button" class="btn btn-success btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-edit"></i></button>'.
					'<button data-modal="admin/projects/delete_milestone/$1" data-toggle="tooltip" title="'.__("Delete Milestone").'" type="button" class="btn btn-danger btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-trash"></i></button>'.
				'</div>',
				'id'
			);



		$results = $this->datatables->generate('json');
		$results = json_decode($results, TRUE);

		foreach($results['data'] as $key => $value) {

			$results['data'][$key]['due_date'] = date_display($value['due_date']);

		}

		echo json_encode($results);

	}



    public function json_assets($id=0) {

        enforce_permission('assets-view');

		$this->datatables
			->select('app_project_assets.id, app_project_assets.asset_id, app_project_assets.notes')
			->from('app_project_assets')

			->where('app_project_assets.project_id', $id)



            ->join('app_assets', 'app_project_assets.asset_id = app_assets.id', 'LEFT')
			->select('app_assets.tag as asset_tag')
            ->select('app_assets.name as asset_name')

			->add_column(
				'actions',
				'<div class="btn-group" role="group">'.
					'<button data-modal="admin/projects/edit_asset_assignment/$1" data-toggle="tooltip" title="'.__("Edit Asset Assignment").'" type="button" class="btn btn-success btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-edit"></i></button>'.
					'<button data-modal="admin/projects/delete_asset_assignment/$1" data-toggle="tooltip" title="'.__("Delete Asset Assignment").'" type="button" class="btn btn-danger btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-trash"></i></button>'.
				'</div>',
				'id'
			);



		$results = $this->datatables->generate('json');
		$results = json_decode($results, TRUE);

		foreach($results['data'] as $key => $value) {

			//$results['data'][$key]['due_date'] = date_display($value['due_date']);

		}

		echo json_encode($results);

	}


	public function index()
	{
        enforce_permission('projects-view');

		$data['title'] = __("Projects");
		$data['page'] = 'admin/projects/list';



		$this->load->view('admin/layout_page', html_escape($data));
	}



	public function details($id=0)
	{
        enforce_permission('projects-view');

		$data['project'] = $this->project->get($id);

		$data['files'] = $this->project->get_files($id);
		$data['milestones'] = $this->project->get_milestones($id);
		$data['comments'] = $this->project->get_comments($id);
		$data['credentials'] = $this->project->get_credentials($id);

		$data['client'] = $this->client->get($data['project']['client_id']);

		$data['customfields'] = $this->customfield->get_for('Projects');

		$data['staff'] = $this->staff->get_all();

		$data['title'] = __("Manage Project") . " - " . $data['project']['name'];
		$data['section'] = 'details';
		$data['page'] = 'admin/projects/index';

        $clear_notes = $data['project']['notes'];
        $clear_notesdesc = $data['project']['description'];
        $clear_cf = $data['project']['custom_fields_values'];

        $data = html_escape($data);

        $data['project']['notes'] = purify($clear_notes);
        $data['project']['description'] = purify($clear_notesdesc);
        $data['project']['custom_fields_values'] = $clear_cf;



		$this->load->view('admin/layout_page', $data);
	}


	public function milestones($id=0)
	{
        enforce_permission('projects-view');

		$data['project'] = $this->project->get($id);

		$data['files'] = $this->project->get_files($id);
		$data['milestones'] = $this->project->get_milestones($id);
		$data['comments'] = $this->project->get_comments($id);

		$data['staff'] = $this->staff->get_all();

		$data['title'] = __("Manage Project") . " - " . $data['project']['name'];
		$data['section'] = 'milestones';
		$data['page'] = 'admin/projects/index';


		$this->load->view('admin/layout_page', html_escape($data));
	}



    public function assets($id=0)
	{
        enforce_permission('assets-view');

		$data['project'] = $this->project->get($id);

		$data['files'] = $this->project->get_files($id);
		$data['comments'] = $this->project->get_comments($id);

		$data['staff'] = $this->staff->get_all();

		$data['title'] = __("Manage Project") . " - " . $data['project']['name'];
		$data['section'] = 'assets';
		$data['page'] = 'admin/projects/index';


		$this->load->view('admin/layout_page', html_escape($data));
	}


	public function issues($id=0)
	{
        enforce_permission('issues-view');

		$data['project'] = $this->project->get($id);

		$data['files'] = $this->project->get_files($id);
		$data['milestones'] = $this->project->get_milestones($id);
		$data['comments'] = $this->project->get_comments($id);


		$data['staff'] = $this->staff->get_all();

		$data['title'] = __("Manage Project") . " - " . $data['project']['name'];
		$data['section'] = 'issues';
		$data['page'] = 'admin/projects/index';


		$this->load->view('admin/layout_page', html_escape($data));
	}

	public function board($id=0)
	{
        enforce_permission('issues-view');

		$data['project'] = $this->project->get($id);

		$data['files'] = $this->project->get_files($id);
		$data['milestones'] = $this->project->get_milestones($id);
		$data['comments'] = $this->project->get_comments($id);


		$data['todo'] = $this->project->get_issues_to_do($id);
		$data['inprogress'] = $this->project->get_issues_inprogress($id);
		$data['done'] = $this->project->get_issues_done_unreleased($id);

        foreach($data['todo'] as $key => $value) { $data['todo'][$key]['description'] = strip_tags($data['todo'][$key]['description']);  }
        foreach($data['inprogress'] as $key => $value) { $data['inprogress'][$key]['description'] = strip_tags($data['inprogress'][$key]['description']);  }
        foreach($data['done'] as $key => $value) { $data['done'][$key]['description'] = strip_tags($data['done'][$key]['description']);  }


		$data['staff'] = $this->staff->get_all();

		$data['title'] = __("Manage Project") . " - " . $data['project']['name'];
		$data['section'] = 'board';
		$data['page'] = 'admin/projects/index';


		$this->load->view('admin/layout_page', html_escape($data));
	}



	public function tickets($id=0)
	{
        enforce_permission('tickets-view');

		$data['project'] = $this->project->get($id);


		$data['title'] = __("Manage Project") . " - " . $data['project']['name'];
		$data['section'] = 'tickets';
		$data['page'] = 'admin/projects/index';


		$this->load->view('admin/layout_page', html_escape($data));
	}


	public function notes($id=0)
	{
        enforce_permission('projects-view');

		$data['project'] = $this->project->get($id);

		$data['files'] = $this->project->get_files($id);
		$data['milestones'] = $this->project->get_milestones($id);
		$data['comments'] = $this->project->get_comments($id);

		$data['staff'] = $this->staff->get_all();

		$data['title'] = __("Manage Project") . " - " . $data['project']['name'];
		$data['section'] = 'notes';
		$data['page'] = 'admin/projects/index';


        $clear_notes = $data['project']['notes'];
        $clear_cf = $data['project']['custom_fields_values'];
        $data = html_escape($data);
        $data['project']['notes'] = purify($clear_notes);
        $data['project']['custom_fields_values'] = $clear_cf;


		$this->load->view('admin/layout_page', $data);
	}






	public function add()
	{
        enforce_permission('projects-add');

		$data['customfields'] = $this->customfield->get_for('Projects');

		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('name', __('Name'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {

				$db_data = array(
					'client_id' => $this->input->post('client_id'),
					'name' => $this->input->post('name'),
					'description' => $this->input->post('description'),
					'status' => $this->input->post('status'),
					'notes' => '',
					'custom_fields_values' => json_encode($this->input->post('customfield')),
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->project->add($db_data);

				if($result) {
                    log_staff('Project added ' . $result);

					$this->session->set_flashdata('toast-success', __("Project has been successfully added."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to add project."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$data['title'] = __("Add Project");
			$data['modal'] = 'admin/projects/add';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function edit($id=0)
	{

        enforce_permission('projects-edit');

		$data['project'] = $this->project->get($id);
		$data['client'] = $this->client->get($data['project']['client_id']);

		$data['customfields'] = $this->customfield->get_for('Projects');

		if($this->input->method() === 'post') {

			$this->form_validation->set_rules('name', __('Name'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {

				$db_data = array(
					'client_id' => $this->input->post('client_id'),
					'name' => $this->input->post('name'),
					'description' => $this->input->post('description'),
					'status' => $this->input->post('status'),
					'custom_fields_values' => json_encode($this->input->post('customfield')),
					'updated_at' => date('Y-m-d H:i:s'),
				);


				$db_data = $this->security->xss_clean($db_data);
				$result = $this->project->edit($db_data, $id);

				if($result) {
                    log_staff('Project edited ' . $id);

					$this->session->set_flashdata('toast-success', __("Project has been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to update project."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$data['title'] = __("Edit Project");
			$data['modal'] = 'admin/projects/edit';

            $clear_cf = $data['project']['custom_fields_values'];
            $data = html_escape($data);
            $data['project']['custom_fields_values'] = $clear_cf;


			$this->load->view('admin/layout_modal', $data);
		}

	}

	public function edit_notes($id=0)
	{

        enforce_permission('projects-edit');

		$data['project'] = $this->project->get($id);

		if($this->input->method() === 'post') {


			$db_data = array(
				'notes' => $this->input->post('notes'),
				'updated_at' => date('Y-m-d H:i:s'),
			);

			$db_data = $this->security->xss_clean($db_data);
			$result = $this->project->edit($db_data, $id);

			if($result) {
                log_staff('Project notes updated ' . $id);

				$this->session->set_flashdata('toast-success', __("Project notes have been successfully updated."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to update project notes."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			redirect($_SERVER['HTTP_REFERER']);
		}

	}

	public function delete($id=0)
	{

        enforce_permission('projects-delete');

		$data['project'] = $this->project->get($id);

		if($this->input->method() === 'post') {

			$result = $this->project->delete($id);

			if($result) {
                log_staff('Project deleted ' . $id);

				$this->session->set_flashdata('toast-success', __("Project has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete project."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			$data['title'] = __("Delete Project");
			$data['modal'] = 'admin/projects/delete';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}








	public function add_issue($id=0)
	{
        enforce_permission('issues-add');

		$data['project'] = $this->project->get($id);

		$data['staff'] = $this->staff->get_all();
		$data['milestones'] = $this->project->get_milestones($data['project']['id']);

		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('assigned_to', __('Assigned To'), 'trim|required');
			$this->form_validation->set_rules('priority', __('Priority'), 'trim|required');
			$this->form_validation->set_rules('name', __('Name'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {

				$db_data = array(
					'client_id' => $data['project']['client_id'],
					'project_id' => $id,
					'milestone_id' => $this->input->post('milestone_id'),
					'added_by' => $this->session->staff_id,
					'assigned_to' => $this->input->post('assigned_to'),
					'status' => "To Do",
					'type' => $this->input->post('type'),
					'priority' => $this->input->post('priority'),
					'name' => $this->input->post('name'),
					'description' => $this->input->post('description'),
					'due_date' => date_to_db($this->input->post('due_date')),
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->issue->add($db_data);

				if($result) {
                    log_staff('Issues added ' . $result);

					$this->session->set_flashdata('toast-success', __("Issue has been successfully added."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to add issue."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$data['title'] = __("Add Issue");
			$data['modal'] = 'admin/projects/add_issue';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function edit_issue($id=0)
	{
        enforce_permission('issues-edit');

		$data['issue'] = $this->issue->get($id);
		$data['project'] = $this->project->get($data['issue']['project_id']);
		$data['staff'] = $this->staff->get_all();
		$data['milestones'] = $this->project->get_milestones($data['project']['id']);

		if($this->input->method() === 'post') {

			$this->form_validation->set_rules('assigned_to', __('Assigned To'), 'trim|required');
			$this->form_validation->set_rules('priority', __('Priority'), 'trim|required');
			$this->form_validation->set_rules('name', __('Name'), 'trim|required');


			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {

				$db_data = array(
					'milestone_id' => $this->input->post('milestone_id'),

					'assigned_to' => $this->input->post('assigned_to'),
					'type' => $this->input->post('type'),
					'priority' => $this->input->post('priority'),
					'name' => $this->input->post('name'),
					'description' => $this->input->post('description'),
					'due_date' => date_to_db($this->input->post('due_date')),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->issue->edit($db_data, $id);

				if($result) {
                    log_staff('Issue edited ' . $id);

					$this->session->set_flashdata('toast-success', __("Issue has been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to update issue."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$data['title'] = __("Edit Issue");
			$data['modal'] = 'admin/projects/edit_issue';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}



	public function delete_issue($id=0)
	{
        enforce_permission('issues-delete');

		$data['issue'] = $this->issue->get($id);

		if($this->input->method() === 'post') {

			$result = $this->issue->delete($id);

			if($result) {
                log_staff('Issues deleted ' . $id);

				$this->session->set_flashdata('toast-success', __("Issue has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete issue."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			$data['title'] = __("Delete Issue");
			$data['modal'] = 'admin/projects/delete_issue';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}




	public function view_issue($id=0)
	{

        enforce_permission('issues-view');

		$data['issue'] = $this->issue->get($id);

		$data['added_by'] = $this->staff->get($data['issue']['added_by']);
		$data['assigned_to'] = $this->staff->get($data['issue']['assigned_to']);

		$data['comments'] = $this->issue->get_comments($id);
		$data['files'] = $this->issue->get_files($id);



		$data['title'] = __("View Issue") . " - " . $data['issue']['name'];
		$data['modal'] = 'admin/projects/view_issue';

		$this->load->view('admin/layout_modal', html_escape($data));


	}




	public function ajax_update_issue()
	{

        enforce_permission('issues-edit');

		if($this->input->method() === 'post') {

            log_staff('Issues edited ' . $this->input->post('id'));

			$db_data = array(
				'status' => $this->input->post('status'),
				'updated_at' => date('Y-m-d H:i:s'),
			);

			$db_data = $this->security->xss_clean($db_data);
			$result = $this->issue->edit($db_data, $this->input->post('id'));

		}

	}


	public function ajax_update_issues_order()
	{
        enforce_permission('issues-edit');

		if($this->input->method() === 'post') {

			$issues = explode(',', $this->input->post('order'));

			$i=0;
			foreach($issues as $issue) {
				if(is_numeric($issue)) {

					$db_data = array(
						'order' => $i,
					);

					$db_data = $this->security->xss_clean($db_data);
					$result = $this->issue->edit($db_data, $issue);

					$i++;
				}
			}


		}

	}



	public function release($id)
	{

        enforce_permission('projects-edit');

		$data['project'] = $this->project->get($id);
        $data['milestones'] = $this->project->get_milestones($id);

		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('milestone_id', __('Milestone'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {

                $issues = $this->db->get_where('app_issues', ['project_id' => $id, 'status' => 'Done', 'released' => 0]);

                $this->db->where('project_id', $id);
                $this->db->where('status', 'Done');
                $this->db->where('released', 0);
                $this->db->update('app_issues', [ 'released' => 1, 'milestone_id' => $this->input->post('milestone_id') ]);
                
				$result = true;

				if($result) {
                    log_staff('Project Released ' . $result);

					$this->session->set_flashdata('toast-success', __("Release has been successfully processesd."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to release project."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$data['title'] = __("Release");
			$data['modal'] = 'admin/projects/release';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

    }



	public function add_comment($id)
	{

        enforce_permission('projects-edit');

		$data['project'] = $this->project->get($id);

		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('comment', __('Comment'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {

				$db_data = array(
					'project_id' => $id,
					'added_by' => $this->session->staff_id,
					'comment' => $this->input->post('comment'),
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->project->add_comment($db_data);

				if($result) {
                    log_staff('Project comment added ' . $result);

					$this->session->set_flashdata('toast-success', __("Comment has been successfully added."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to add comment."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$data['title'] = __("Add Comment");
			$data['modal'] = 'admin/projects/add_comment';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function edit_comment($id=0)
	{
        enforce_permission('projects-edit');

		$data['comment'] = $this->project->get_comment($id);
		$data['project'] = $this->project->get($data['comment']['project_id']);

		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('comment', __('Comment'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {

				$db_data = array(
					'comment' => $this->input->post('comment'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->project->edit_comment($db_data, $id);

				if($result) {
                    log_staff('Project comment edited ' . $result);

					$this->session->set_flashdata('toast-success', __("Comment has been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to update comment."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$data['title'] = __("Edit Comment");
			$data['modal'] = 'admin/projects/edit_comment';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function delete_comment($id=0)
	{
        enforce_permission('projects-delete');

		$data['comment'] = $this->project->get_comment($id);
		$data['project'] = $this->project->get($data['comment']['project_id']);

		if($this->input->method() === 'post') {

			$result = $this->project->delete_comment($id);

			if($result) {
                log_staff('Project comment deleted ' . $id);

				$this->session->set_flashdata('toast-success', __("Comment has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete comment."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			$data['title'] = __("Delete Comment");
			$data['modal'] = 'admin/projects/delete_comment';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}







	public function upload_file($id)
	{
        enforce_permission('projects-edit');

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
                log_staff('Project file uploaded ' . $result);

				$this->session->set_flashdata('toast-success', __("File has been successfully uploaded."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to upload file."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			$data['title'] = __("Upload File");
			$data['modal'] = 'admin/projects/upload_file';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function delete_file($id=0)
	{
        enforce_permission('projects-delete');

		$data['file'] = $this->project->get_file($id);
		$data['project'] = $this->project->get($data['file']['project_id']);

		if($this->input->method() === 'post') {

			$result = $this->project->delete_file($id);

			unlink('./filestore/main/projects/'.$data['file']['file']);

			if($result) {
                log_staff('Project file deleted ' . $id);

				$this->session->set_flashdata('toast-success', __("File has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete file."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			$data['title'] = __("Delete File");
			$data['modal'] = 'admin/projects/delete_file';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function download_file($id=0)
	{
        enforce_permission('projects-view');

        log_staff('Project file downloaded ' . $id);


		$data['file'] = $this->project->get_file($id);
		$data['project'] = $this->project->get($data['file']['project_id']);


		force_download("./filestore/main/projects/" . $data['file']['file'], NULL);
	}














	public function add_milestone($id)
	{
		$data['project'] = $this->project->get($id);

		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('name', __('Name'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {

				$db_data = array(
					'project_id' => $id,
					'name' => $this->input->post('name'),
					'description' => $this->input->post('description'),
					'due_date' => date_to_db($this->input->post('due_date')),
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->project->add_milestone($db_data);

				if($result) {
                    log_staff('Project milestone added ' . $result);

					$this->session->set_flashdata('toast-success', __("Milestone has been successfully added."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to add milestone."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$data['title'] = __("Add Milestone");
			$data['modal'] = 'admin/projects/add_milestone';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function edit_milestone($id=0)
	{

		$data['milestone'] = $this->project->get_milestone($id);
		$data['project'] = $this->project->get($data['milestone']['project_id']);

		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('name', __('Name'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {

				$db_data = array(
					'name' => $this->input->post('name'),
					'description' => $this->input->post('description'),
					'due_date' => date_to_db($this->input->post('due_date')),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->project->edit_milestone($db_data, $id);

				if($result) {
                    log_staff('Project milestone edited ' . $id);

					$this->session->set_flashdata('toast-success', __("Milestone has been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to update milestone."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$data['title'] = __("Edit Milestone");
			$data['modal'] = 'admin/projects/edit_milestone';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function delete_milestone($id=0)
	{
		$data['milestone'] = $this->project->get_milestone($id);
		$data['project'] = $this->project->get($data['milestone']['project_id']);

		if($this->input->method() === 'post') {

			$result = $this->project->delete_milestone($id);

			if($result) {
                log_staff('Project milestone deleted ' . $id);

				$this->session->set_flashdata('toast-success', __("Milestone has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete milestone."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			$data['title'] = __("Delete Milestone");
			$data['modal'] = 'admin/projects/delete_milestone';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}













	public function add_asset_assignment($id)
	{
		$data['project'] = $this->project->get($id);

		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('asset_id', __('Asset'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {

				$db_data = array(
					'project_id' => $id,
					'asset_id' => $this->input->post('asset_id'),
					'notes' => $this->input->post('notes'),
					
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->project->add_asset_assignment($db_data);

				if($result) {
                    log_staff('Project milestone added ' . $result);

					$this->session->set_flashdata('toast-success', __("Asset assignment has been successfully added."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to add asset assignment."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$data['title'] = __("Add Asset Assignment");
			$data['modal'] = 'admin/projects/add_asset_assignment';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function edit_asset_assignment($id=0)
	{

		$data['asset_assignment'] = $this->project->get_asset_assignment($id);
		$data['project'] = $this->project->get($data['asset_assignment']['project_id']);

        $data['asset'] = $this->asset->get($data['asset_assignment']['asset_id']);


		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('asset_id', __('Asset'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {

				$db_data = array(
					'asset_id' => $this->input->post('asset_id'),
					'notes' => $this->input->post('notes'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->project->edit_asset_assignment($db_data, $id);

				if($result) {
                    log_staff('Asset assignment edited ' . $id);

					$this->session->set_flashdata('toast-success', __("Asset assignment has been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to update asset assignment."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$data['title'] = __("Edit Asset Assignment");
			$data['modal'] = 'admin/projects/edit_asset_assignment';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function delete_asset_assignment($id=0)
	{
		$data['asset_assignment'] = $this->project->get_asset_assignment($id);
		$data['project'] = $this->project->get($data['asset_assignment']['project_id']);

		if($this->input->method() === 'post') {

			$result = $this->project->delete_asset_assignment($id);

			if($result) {
                log_staff('Asset assignment deleted ' . $id);

				$this->session->set_flashdata('toast-success', __("Asset assignment has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete asset assignment."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			$data['title'] = __("Delete Asset Assignment");
			$data['modal'] = 'admin/projects/delete_asset_assignment';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}









	public function add_credential($id)
	{
		$data['project'] = $this->project->get($id);

		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('type', __('Type'), 'trim|required');


			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {

				$db_data = array(
					'client_id' => $data['project']['client_id'],
					'asset_id' => 0,

					'project_id' => $id,
					'type' => $this->input->post('type'),
					'username' => $this->input->post('username'),
					'pswd' => $this->encryption->encrypt($this->input->post('pswd')),
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->asset->add_credential($db_data);

				if($result) {
                    log_staff('Credential added ' . $result);

					$this->session->set_flashdata('toast-success', __("Credential has been successfully added."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to add credential."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$data['title'] = __("Add Credential");
			$data['modal'] = 'admin/projects/add_credential';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}




	public function add_ticket($id=0)
	{

		$data['project'] = $this->project->get($id);




		$data['staff'] = $this->staff->get_all_active();
		$data['users'] = $this->user->get_all();

		$data['customfields'] = $this->customfield->get_for('Tickets');

		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('email', __('Email'), 'trim|required');
			$this->form_validation->set_rules('status', __('Status'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {


				$db_data = array(
					'ticket' => random_ticket(8),
					'user_id' => $this->input->post('user_id'),
					'assigned_to' => $this->input->post('assigned_to'),

					'client_id' => $data['project']['client_id'],
					'asset_id' => 0,
					'license_id' => 0,
					'project_id' => $id,

					'email' => $this->input->post('email'),
					'cc' => $this->input->post('cc'),
					'status' => $this->input->post('status'),
					'priority' => $this->input->post('priority'),
					'subject' => $this->input->post('subject'),

					'custom_fields_values' => json_encode($this->input->post('customfield')),

					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_reply_data = array(
					'staff_id' => $this->session->staff_id,
					'message' => $this->input->post('message'),
					'created_at' => date('Y-m-d H:i:s'),
				);


				$db_data = $this->security->xss_clean($db_data);
				$db_reply_data = $this->security->xss_clean($db_reply_data);

				$result = $this->ticket->add($db_data, $db_reply_data);


				$config['upload_path']                = './filestore/main/tickets/';
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
						'created_at' => date('Y-m-d H:i:s'),
					);
					$db_file_data = $this->security->xss_clean($db_file_data);
					$this->db->insert('app_ticket_reply_files', $db_file_data);
				}

				// send ticket assigned to admin or send new ticket to all notifiable staff
				if($this->input->post('assigned_to') != "0") {
					$reply = $this->ticket->get_reply($result);
					$this->mailer->send("Staff | Ticket assigned", [ "staff_id" => $this->input->post('assigned_to'), 'ticket_id' => $reply['ticket_id'] ]);
				} else {
					$reply = $this->ticket->get_reply($result);
					$staff_notifiable = $this->staff->get_all_ticket_notifiable();
					foreach ($staff_notifiable as $item) {
						$this->mailer->send("Staff | New ticket", [ "staff_id" => $item['id'], 'ticket_id' => $reply['ticket_id'] ]);
					}
				}

				if($this->input->post('notify') == "1") {
					// send new ticket created notification to user
					$reply = $this->ticket->get_reply($result);
					$ticket = $this->ticket->get($reply['ticket_id']);
					$this->mailer->send("User | New ticket", [ "email_address" => $ticket['email'], 'ticket_id' => $reply['ticket_id'] ]);
				}

				if($result) {
                    log_staff('Ticket added ' . $reply['ticket_id']);

					$this->session->set_flashdata('toast-success', __("Ticket has been successfully added."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to add ticket."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$data['title'] = __("Add Ticket");
			$data['modal'] = 'admin/projects/add_ticket';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}












}
