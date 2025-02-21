<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Issues extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('admin/issue_model', 'issue');
		$this->load->model('admin/staff_model', 'staff');
		$this->load->model('admin/setting_model', 'setting');

		$this->load->model('admin/client_model', 'client');
		$this->load->model('admin/user_model', 'user');
		$this->load->model('admin/asset_model', 'asset');
		$this->load->model('admin/license_model', 'license');
		$this->load->model('admin/project_model', 'project');

		$this->load->model('admin/customfield_model', 'customfield');


		$this->load->library('datatables');
	}


	public function json_assigned() {

        enforce_permission('issues-view');

		$this->datatables
			->select('app_issues.id, app_issues.name, app_issues.status, due_date, app_issues.priority, app_issues.type')
			->where('app_issues.assigned_to', $this->session->staff_id)
			->where('app_issues.status', 'To Do')
			->or_where('app_issues.status', 'In Progress')
			->from('app_issues')
			->join('core_staff', 'app_issues.assigned_to = core_staff.id', 'LEFT')
			->select('core_staff.name as assigned_to')
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
					'<a href="'.base_url('admin/issues/view/').'$1" data-toggle="tooltip" title="'.__("View Issue").'" type="button" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-eye"></i></a>'.
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

	public function json_todo() {

        enforce_permission('issues-view');

		$this->datatables
			->select('app_issues.id, app_issues.name, app_issues.status, due_date, app_issues.priority, app_issues.type')
			->where('app_issues.status', 'To Do')
			->from('app_issues')
			->join('core_staff', 'app_issues.assigned_to = core_staff.id', 'LEFT')
			->select('core_staff.name as assigned_to')
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
					'<a href="'.base_url('admin/issues/view/').'$1" data-toggle="tooltip" title="'.__("View Issue").'" type="button" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-eye"></i></a>'.
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

	public function json_inprogress() {

        enforce_permission('issues-view');

		$this->datatables
			->select('app_issues.id, app_issues.name, app_issues.status, due_date, app_issues.priority, app_issues.type')
			->where('app_issues.status', 'In Progress')
			->from('app_issues')
			->join('core_staff', 'app_issues.assigned_to = core_staff.id', 'LEFT')
			->select('core_staff.name as assigned_to')
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
					'<a href="'.base_url('admin/issues/view/').'$1" data-toggle="tooltip" title="'.__("View Issue").'" type="button" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-eye"></i></a>'.
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


	public function json_done() {

        enforce_permission('issues-view');

		$this->datatables
			->select('app_issues.id, app_issues.name, app_issues.status, due_date, app_issues.priority, app_issues.type')
			->where('app_issues.status', 'Done')
			->from('app_issues')
			->join('core_staff', 'app_issues.assigned_to = core_staff.id', 'LEFT')
			->select('core_staff.name as assigned_to')
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
					'<a href="'.base_url('admin/issues/view/').'$1" data-toggle="tooltip" title="'.__("View Issue").'" type="button" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-eye"></i></a>'.
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

	public function json_all() {

        enforce_permission('issues-view');

		$this->datatables
			->select('app_issues.id, app_issues.name, app_issues.status, due_date, app_issues.priority, app_issues.type')
			->from('app_issues')
			->join('core_staff', 'app_issues.assigned_to = core_staff.id', 'LEFT')
			->select('core_staff.name as assigned_to')
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
					'<a href="'.base_url('admin/issues/view/').'$1" data-toggle="tooltip" title="'.__("View Issue").'" type="button" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-eye"></i></a>'.
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

	public function assigned()
	{

        enforce_permission('issues-view');
		$data['title'] = __("Assigned Issues");
		$data['page'] = 'admin/issues/list_assigned';

		$this->load->view('admin/layout_page', html_escape($data));
	}

	public function todo()
	{

        enforce_permission('issues-view');
		$data['title'] = __("To Do Issues");
		$data['page'] = 'admin/issues/list_todo';

		$this->load->view('admin/layout_page', html_escape($data));
	}

	public function inprogress()
	{
        enforce_permission('issues-view');
		$data['title'] = __("In Progress Issues");
		$data['page'] = 'admin/issues/list_inprogress';

		$this->load->view('admin/layout_page', html_escape($data));
	}

	public function done()
	{
        enforce_permission('issues-view');
		$data['title'] = __("Completed Issues");
		$data['page'] = 'admin/issues/list_done';

		$this->load->view('admin/layout_page', html_escape($data));
	}

	public function all()
	{
        enforce_permission('issues-view');
		$data['title'] = __("All Issues");
		$data['page'] = 'admin/issues/list_all';

		$this->load->view('admin/layout_page', html_escape($data));
	}


	public function add()
	{
        enforce_permission('issues-add');
		$data['staff'] = $this->staff->get_all();

		$data['customfields'] = $this->customfield->get_for('Issues');

		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('assigned_to', __('Assigned To'), 'trim|required');
			$this->form_validation->set_rules('priority', __('Priority'), 'trim|required');
			$this->form_validation->set_rules('name', __('Name'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {

				$db_data = array(
					'added_by' => $this->session->staff_id,
					'assigned_to' => $this->input->post('assigned_to'),
					'client_id' => $this->input->post('client_id'),
					'user_id' => $this->input->post('user_id'),
					'asset_id' => $this->input->post('asset_id'),
					'license_id' => $this->input->post('license_id'),
					'project_id' => $this->input->post('project_id'),
					'status' => "To Do",
					'type' => $this->input->post('type'),
					'priority' => $this->input->post('priority'),
					'name' => $this->input->post('name'),
					'description' => $this->input->post('description'),
					'due_date' => date_to_db($this->input->post('due_date')),
					'custom_fields_values' => json_encode($this->input->post('customfield')),
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->issue->add($db_data);

				if($result) {
                    log_staff('Issue added ' . $result);

                    if($this->input->post('assigned_to') != "0") {
						$this->mailer->send("Staff | Issue assigned", [ "staff_id" => $this->input->post('assigned_to'), 'task_id' => $result ]);
					}


					$this->session->set_flashdata('toast-success', __("Issue has been successfully added."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to add issue."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$data['title'] = __("Add Issue");
			$data['modal'] = 'admin/issues/add';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function edit($id=0)
	{
        enforce_permission('issues-edit');

		$data['issue'] = $this->issue->get($id);
		$data['staff'] = $this->staff->get_all();


		$data['client'] = $this->client->get($data['issue']['client_id']);
		$data['user'] = $this->user->get($data['issue']['user_id']);
		$data['asset'] = $this->asset->get($data['issue']['asset_id']);
		$data['license'] = $this->license->get($data['issue']['license_id']);
		$data['project'] = $this->project->get($data['issue']['project_id']);



		$data['customfields'] = $this->customfield->get_for('Issues');

		if($this->input->method() === 'post') {

			$this->form_validation->set_rules('assigned_to', __('Assigned To'), 'trim|required');
			$this->form_validation->set_rules('priority', __('Priority'), 'trim|required');
			$this->form_validation->set_rules('name', __('Name'), 'trim|required');


			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {

				$db_data = array(
					'assigned_to' => $this->input->post('assigned_to'),
					'client_id' => $this->input->post('client_id'),
					'user_id' => $this->input->post('user_id'),
					'asset_id' => $this->input->post('asset_id'),
					'license_id' => $this->input->post('license_id'),
					'project_id' => $this->input->post('project_id'),
					'type' => $this->input->post('type'),
					'priority' => $this->input->post('priority'),
					'name' => $this->input->post('name'),
					'description' => $this->input->post('description'),
					'due_date' => date_to_db($this->input->post('due_date')),
					'custom_fields_values' => json_encode($this->input->post('customfield')),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->issue->edit($db_data, $id);

				if($result) {
                    log_staff('Issue edited ' . $id);

                    if($this->input->post('assigned_to') != $data['issue']['assigned_to']) {
						$this->mailer->send("Staff | Issue assigned", [ "staff_id" => $this->input->post('assigned_to'), 'task_id' => $id ]);
					}


					$this->session->set_flashdata('toast-success', __("Issue has been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to update issue."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$data['title'] = __("Edit Issue");
			$data['modal'] = 'admin/issues/edit';


            $clear_notes = $data['issue']['description'];
            $clear_cf = $data['issue']['custom_fields_values'];

            $data = html_escape($data);
            $data['issue']['description'] = purify($clear_notes);
            $data['issue']['custom_fields_values'] = $clear_cf;


			$this->load->view('admin/layout_modal', $data);
		}

	}



	public function assign($id=0)
	{
        enforce_permission('issues-edit');
		$data['issue'] = $this->issue->get($id);
		$data['staff'] = $this->staff->get_all();

		if($this->input->method() === 'post') {

			$this->form_validation->set_rules('assigned_to', __('Assigned To'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {

				$db_data = array(
					'assigned_to' => $this->input->post('assigned_to'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->issue->edit($db_data, $id);

				if($result) {
                    log_staff('Issue assigned ' . $id);

                    if($result) {
                        if($this->input->post('assigned_to') != $data['issue']['assigned_to']) 
                        {
                            $this->mailer->send("Staff | Issue assigned", [ "staff_id" => $this->input->post('assigned_to'), 'task_id' => $id ]);
                        }
                    }


					$this->session->set_flashdata('toast-success', __("Issue has been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to update issue."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			if($data['issue']['assigned_to'] == '0') {
				$data['title'] = __("Assign Issue");
			} else {
				$data['title'] = __("Reassign Issue");
			}

			$data['modal'] = 'admin/issues/assign';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}


	public function set_done($id=0)
	{
        enforce_permission('issues-edit');
		$data['issue'] = $this->issue->get($id);

		if($this->input->method() === 'post') {

				$db_data = array(
					'status' => "Done",
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->issue->edit($db_data, $id);

				if($result) {
                    log_staff('Issue done ' . $id);

					$this->session->set_flashdata('toast-success', __("Issue has been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to update issue."));
				}

				redirect($_SERVER['HTTP_REFERER']);

		} else {
			$data['title'] = __("Set as completed");
			$data['modal'] = 'admin/issues/set_done';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}


	public function set_inprogress($id=0)
	{
        enforce_permission('issues-edit');
		$data['issue'] = $this->issue->get($id);

		if($this->input->method() === 'post') {

				$db_data = array(
					'status' => "In Progress",
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->issue->edit($db_data, $id);

				if($result) {
                    log_staff('Issue in progress ' . $id);

					$this->session->set_flashdata('toast-success', __("Issue has been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to update issue."));
				}

				redirect($_SERVER['HTTP_REFERER']);

		} else {
			$data['title'] = __("Set In Progress");
			$data['modal'] = 'admin/issues/set_inprogress';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function delete($id=0)
	{
        enforce_permission('issues-delete');
		$data['issue'] = $this->issue->get($id);

		if($this->input->method() === 'post') {

			$result = $this->issue->delete($id);

			if($result) {
                log_staff('Issue deleted ' . $id);

				$this->session->set_flashdata('toast-success', __("Issue has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete issue."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			$data['title'] = __("Delete Issue");
			$data['modal'] = 'admin/issues/delete';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function view($id=0)
	{
        enforce_permission('issues-view');
		$data['issue'] = $this->issue->get($id);

		$data['added_by'] = $this->staff->get($data['issue']['added_by']);
		$data['assigned_to'] = $this->staff->get($data['issue']['assigned_to']);

		$data['comments'] = $this->issue->get_comments($id);
		$data['files'] = $this->issue->get_files($id);

		$data['customfields'] = $this->customfield->get_for('Issues');

		$data['title'] = __("View Issue");
		$data['page'] = 'admin/issues/view';

        $clear_notes = $data['issue']['description'];
        $clear_cf = $data['issue']['custom_fields_values'];
        $data = html_escape($data);
        $data['issue']['description'] = purify($clear_notes);
        $data['issue']['custom_fields_values'] = $clear_cf;


		$this->load->view('admin/layout_page', $data);


	}


	public function quick_view($id=0)
	{
        enforce_permission('issues-view');
		$data['issue'] = $this->issue->get($id);

		$data['added_by'] = $this->staff->get($data['issue']['added_by']);
		$data['assigned_to'] = $this->staff->get($data['issue']['assigned_to']);

		$data['comments'] = $this->issue->get_comments($id);
		$data['files'] = $this->issue->get_files($id);

		$data['customfields'] = $this->customfield->get_for('Issues');

		$data['title'] = __("View Issue") . " - " . $data['issue']['name'];
		$data['modal'] = 'admin/issues/quick_view';

        $clear_notes = $data['issue']['description'];
        $clear_cf = $data['issue']['custom_fields_values'];
        $data = html_escape($data);
        $data['issue']['description'] = purify($clear_notes);
        $data['issue']['custom_fields_values'] = $clear_cf;


		$this->load->view('admin/layout_modal', $data);


	}


	public function add_comment($id)
	{
        enforce_permission('issues-edit');
		$data['issue'] = $this->issue->get($id);

		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('comment', __('Comment'), 'trim');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {

				$db_data = array(
					'issue_id' => $id,
					'added_by' => $this->session->staff_id,
					'comment' => $this->input->post('comment'),
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->issue->add_comment($db_data);

				if($result) {
                    log_staff('Issue commend added ' . $result);

					$this->session->set_flashdata('toast-success', __("Comment has been successfully added."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to add comment."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$data['title'] = __("Add Comment");
			$data['modal'] = 'admin/issues/add_comment';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function edit_comment($id=0)
	{
        enforce_permission('issues-edit');

		$data['comment'] = $this->issue->get_comment($id);
		$data['issue'] = $this->issue->get($data['comment']['issue_id']);

		if($this->input->method() === 'post') {

			$this->form_validation->set_rules('comment', __('Comment'), 'trim');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {

				$db_data = array(
					'comment' => $this->input->post('comment'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->issue->edit_comment($db_data, $id);

				if($result) {
                    log_staff('Issue comment edited ' . $id);

					$this->session->set_flashdata('toast-success', __("Comment has been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to update comment."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$data['title'] = __("Edit Comment");
			$data['modal'] = 'admin/issues/edit_comment';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function delete_comment($id=0)
	{
        enforce_permission('issues-delete');
		$data['comment'] = $this->issue->get_comment($id);
		$data['issue'] = $this->issue->get($data['comment']['issue_id']);

		if($this->input->method() === 'post') {

			$result = $this->issue->delete_comment($id);

			if($result) {
                log_staff('Issue comment deleted ' . $id);

				$this->session->set_flashdata('toast-success', __("Comment has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete comment."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			$data['title'] = __("Delete Comment");
			$data['modal'] = 'admin/issues/delete_comment';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}



	public function upload_file($id)
	{
        enforce_permission('issues-edit');
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
                log_staff('Issue file uploaded ' . $result);

				$this->session->set_flashdata('toast-success', __("File has been successfully uploaded."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to upload file."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			$data['title'] = __("Upload File");
			$data['modal'] = 'admin/issues/upload_file';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function delete_file($id=0)
	{
        enforce_permission('issues-delete');
		$data['file'] = $this->issue->get_file($id);
		$data['issue'] = $this->issue->get($data['file']['issue_id']);

		if($this->input->method() === 'post') {

			$result = $this->issue->delete_file($id);

			unlink('./filestore/main/issues/'.$data['file']['file']);

			if($result) {
                log_staff('Issue file deleted ' . $id);

				$this->session->set_flashdata('toast-success', __("File has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete file."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			$data['title'] = __("Delete File");
			$data['modal'] = 'admin/issues/delete_file';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function download_file($id=0)
	{
        enforce_permission('issues-view');
        log_staff('Issue file downloaded ' . $id);

		$data['file'] = $this->issue->get_file($id);
		$data['issue'] = $this->issue->get($data['file']['issue_id']);


		force_download("./filestore/main/issues/" . $data['file']['file'], NULL);
	}



}
