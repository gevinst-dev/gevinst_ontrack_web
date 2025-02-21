<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tickets extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('admin/ticket_model', 'ticket');
        $this->load->model('admin/predefined_reply_model', 'predefined_reply');
		$this->load->model('admin/staff_model', 'staff');

		$this->load->model('admin/client_model', 'client');


		$this->load->model('admin/asset_model', 'asset');
		$this->load->model('admin/license_model', 'license');
		$this->load->model('admin/project_model', 'project');

		$this->load->model('admin/customfield_model', 'customfield');

		$this->load->model('admin/user_model', 'user');
		$this->load->model('admin/setting_model', 'setting');
		$this->load->library('datatables');
	}


	public function json_assigned() {
        enforce_permission('tickets-view');

		$this->datatables
			->select('app_tickets.id, app_tickets.ticket, app_tickets.subject, app_tickets.email, app_tickets.status, app_tickets.priority')

			->where('app_tickets.assigned_to', $this->session->staff_id)
			->where('app_tickets.status !=', 'Closed')

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

	public function json_open() {

        enforce_permission('tickets-view');

		$this->datatables
			->select('app_tickets.id, app_tickets.ticket, app_tickets.subject, app_tickets.email, app_tickets.status, app_tickets.priority')
			->where('app_tickets.status', 'Open')
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


	public function json_reopened() {

        enforce_permission('tickets-view');

		$this->datatables
			->select('app_tickets.id, app_tickets.ticket, app_tickets.subject, app_tickets.email, app_tickets.status, app_tickets.priority')
			->where('app_tickets.status', 'Reopened')
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


	public function json_inprogress() {

        enforce_permission('tickets-view');

		$this->datatables
			->select('app_tickets.id, app_tickets.ticket, app_tickets.subject, app_tickets.email, app_tickets.status, app_tickets.priority')
			->where('app_tickets.status', 'In Progress')
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


	public function json_answered() {

        enforce_permission('tickets-view');

		$this->datatables
			->select('app_tickets.id, app_tickets.ticket, app_tickets.subject, app_tickets.email, app_tickets.status, app_tickets.priority')
			->where('app_tickets.status', 'Answered')
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

	public function json_all() {

        enforce_permission('tickets-view');

		$this->datatables
			->select('app_tickets.id, app_tickets.ticket, app_tickets.subject, app_tickets.email, app_tickets.status, app_tickets.priority')
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

			->add_column('relations', '')

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

	public function assigned()
	{
        enforce_permission('tickets-view');

		$data['title'] = __("Assigned Tickets");
		$data['page'] = 'admin/tickets/list_assigned';

		$this->load->view('admin/layout_page', html_escape($data));
	}

	public function open()
	{
        enforce_permission('tickets-view');

		$data['title'] = __("Open Tickets");
		$data['page'] = 'admin/tickets/list_open';

		$this->load->view('admin/layout_page', html_escape($data));
	}

	public function reopened()
	{
        enforce_permission('tickets-view');

		$data['title'] = __("Reopened Tickets");
		$data['page'] = 'admin/tickets/list_reopened';

		$this->load->view('admin/layout_page', html_escape($data));
	}

	public function inprogress()
	{
        enforce_permission('tickets-view');

		$data['title'] = __("In Progress Tickets");
		$data['page'] = 'admin/tickets/list_inprogress';

		$this->load->view('admin/layout_page', html_escape($data));
	}

	public function answered()
	{
        enforce_permission('tickets-view');

		$data['title'] = __("Answered Tickets");
		$data['page'] = 'admin/tickets/list_answered';

		$this->load->view('admin/layout_page', html_escape($data));
	}


	public function all()
	{
        enforce_permission('tickets-view');

		$data['title'] = __("All Tickets");
		$data['page'] = 'admin/tickets/list_all';

		$this->load->view('admin/layout_page', html_escape($data));
	}


	public function add()
	{
        enforce_permission('tickets-add');

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

					'client_id' => $this->input->post('client_id'),
					'asset_id' => $this->input->post('asset_id'),
					'license_id' => $this->input->post('license_id'),
					'project_id' => $this->input->post('project_id'),

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
                        'name' => $saved_file,
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
					$staff_notifiable = $this->staff->get_all_notifiable();
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
			$data['modal'] = 'admin/tickets/add';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}


	public function edit($id=0)
	{
        enforce_permission('tickets-edit');

		$data['ticket'] = $this->ticket->get($id);

		$data['staff'] = $this->staff->get_all_active();
		$data['users'] = $this->user->get_all();

		$data['client'] = $this->client->get($data['ticket']['client_id']);
		$data['asset'] = $this->asset->get($data['ticket']['asset_id']);
		$data['license'] = $this->license->get($data['ticket']['license_id']);
		$data['project'] = $this->project->get($data['ticket']['project_id']);

		$data['customfields'] = $this->customfield->get_for('Tickets');

		if($this->input->method() === 'post') {

			$this->form_validation->set_rules('email', __('Email'), 'trim|required');
			$this->form_validation->set_rules('status', __('Status'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {

				$db_data = array(
					'user_id' => $this->input->post('user_id'),
					'assigned_to' => $this->input->post('assigned_to'),

					'client_id' => $this->input->post('client_id'),
					'asset_id' => $this->input->post('asset_id'),
					'license_id' => $this->input->post('license_id'),
					'project_id' => $this->input->post('project_id'),

					'email' => $this->input->post('email'),
					'cc' => $this->input->post('cc'),
					'status' => $this->input->post('status'),
					'priority' => $this->input->post('priority'),
					'subject' => $this->input->post('subject'),
					'custom_fields_values' => json_encode($this->input->post('customfield')),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->ticket->edit($db_data, $id);

				// send ticket assigned to admin
				if($this->input->post('assigned_to') != $data['ticket']['assigned_to']) {
					if($this->input->post('assigned_to') != "0") {
						$this->mailer->send("Staff | Ticket assigned", [ "staff_id" => $this->input->post('assigned_to'), 'ticket_id' => $id ]);
					}

				}


				if($result) {
                    log_staff('Ticket edited ' . $id);

					$this->session->set_flashdata('toast-success', __("Ticket has been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to update ticket."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$data['title'] = __("Edit Ticket");
			$data['modal'] = 'admin/tickets/edit';

            $clear_cf = $data['ticket']['custom_fields_values'];
            $data = html_escape($data);
            $data['ticket']['custom_fields_values'] = $clear_cf;


			$this->load->view('admin/layout_modal', $data);
		}

	}




	public function add_reply($id=0)
	{
        enforce_permission('tickets-edit');

		if($this->input->method() === 'post') {

			$data['ticket'] = $this->ticket->get($id);


			$db_data = array(
				'status' => $this->input->post('status'),
				'updated_at' => date('Y-m-d H:i:s'),
			);

			$db_data = $this->security->xss_clean($db_data);
			$result = $this->ticket->edit($db_data, $id);


			$db_reply_data = array(
				'ticket_id' => $id,
				'staff_id' => $this->session->staff_id,
				'message' => $this->input->post('message'),
				'created_at' => date('Y-m-d H:i:s'),
			);
			$db_reply_data = $this->security->xss_clean($db_reply_data);
			$this->db->insert('app_ticket_replies', $db_reply_data);
			$reply_id = $this->db->insert_id();

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
					'reply_id' => $reply_id,
					'file' => $saved_file,
                    'name' => $saved_file,
					'created_at' => date('Y-m-d H:i:s'),
				);
				$db_file_data = $this->security->xss_clean($db_file_data);
				$this->db->insert('app_ticket_reply_files', $db_file_data);
			}


			// send new reply added notification to user
			$this->mailer->send("User | New ticket reply", [ "email_address" => $data['ticket']['email'], 'ticket_id' => $data['ticket']['id'], 'reply_id' => $reply_id ]);


			if($result) {
                log_staff('Ticket reply added ' . $data['ticket']['id']);

				$this->session->set_flashdata('toast-success', __("Reply has been successfully updated."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to update ticket."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			die("Invalid operation!");
		}

	}


	public function edit_notes($id=0)
	{
        enforce_permission('tickets-edit');


		if($this->input->method() === 'post') {

			$db_data = array(
				'notes' => $this->input->post('notes'),
				'updated_at' => date('Y-m-d H:i:s'),
			);

			$db_data = $this->security->xss_clean($db_data);
			$result = $this->ticket->edit($db_data, $id);


			if($result) {
                log_staff('Ticket notes edited ' . $id);

				$this->session->set_flashdata('toast-success', __("Ticket has been successfully updated."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to update ticket."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			die("Invalid operation!");
		}

	}

	public function assign($id=0)
	{
        enforce_permission('tickets-edit');

		$data['ticket'] = $this->ticket->get($id);
		$data['staff'] = $this->staff->get_all_active();

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
				$result = $this->ticket->edit($db_data, $id);


				if($this->input->post('assigned_to') != $data['ticket']['assigned_to']) {
					if($this->input->post('assigned_to') != "0") {
						$this->mailer->send("Staff | Ticket assigned", [ "staff_id" => $this->input->post('assigned_to'), 'ticket_id' => $id ]);
					}

				}

				if($result) {
                    log_staff('Ticket assigned ' . $id);

					$this->session->set_flashdata('toast-success', __("Ticket has been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to update ticket."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			if($data['ticket']['assigned_to'] == '0') {
				$data['title'] = __("Assign Ticket");
			} else {
				$data['title'] = __("Reassign Ticket");
			}

			$data['modal'] = 'admin/tickets/assign';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}


	public function close($id=0)
	{
        enforce_permission('tickets-edit');

		$data['ticket'] = $this->ticket->get($id);

		if($this->input->method() === 'post') {

				$db_data = array(
					'status' => "Closed",
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->ticket->edit($db_data, $id);

				if($result) {
                    log_staff('Ticket closed ' . $id);

					$this->session->set_flashdata('toast-success', __("Ticket has been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to update ticket."));
				}

				redirect($_SERVER['HTTP_REFERER']);

		} else {
			$data['title'] = __("Close Ticket");
			$data['modal'] = 'admin/tickets/close';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function reopen($id=0)
	{
        enforce_permission('tickets-edit');

		$data['ticket'] = $this->ticket->get($id);

		if($this->input->method() === 'post') {

				$db_data = array(
					'status' => "Reopened",
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->ticket->edit($db_data, $id);

				if($result) {
                    log_staff('Ticket reopened ' . $id);

					$this->session->set_flashdata('toast-success', __("Ticket has been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to update ticket."));
				}

				redirect($_SERVER['HTTP_REFERER']);

		} else {
			$data['title'] = __("Reopen Ticket");
			$data['modal'] = 'admin/tickets/reopen';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}



	public function delete($id=0)
	{
        enforce_permission('tickets-delete');

		$data['ticket'] = $this->ticket->get($id);

		if($this->input->method() === 'post') {

			$result = $this->ticket->delete($id);

			if($result) {
                log_staff('Ticket deleted ' . $id);

				$this->session->set_flashdata('toast-success', __("Ticket has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete ticket."));
			}

			redirect($_SERVER['HTTP_REFERER']);
		} else {
			$data['title'] = __("Delete Ticket");
			$data['modal'] = 'admin/tickets/delete';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function view($id=0)
	{
        enforce_permission('tickets-view');

		$data['ticket'] = $this->ticket->get($id);

		$data['user'] = $this->user->get($data['ticket']['user_id']);

		$data['assigned_to'] = $this->staff->get($data['ticket']['assigned_to']);

		$data['comments'] = $this->ticket->get_comments($id);
		$data['replies'] = $this->ticket->get_replies($id);

        $data['predefined_replies'] = $this->predefined_reply->get_all($id);

		$data['customfields'] = $this->customfield->get_for('Tickets');

		$data['title'] = __("View Ticket");
		$data['page'] = 'admin/tickets/view';


        $clear_cf = $data['ticket']['custom_fields_values'];
        $data['ticket'] = html_escape($data['ticket']);
        $data['ticket']['custom_fields_values'] = $clear_cf;


        $data['user'] = html_escape($data['user']);
        $data['assigned_to'] = html_escape($data['assigned_to']);
        $data['comments'] = html_escape($data['comments']);





		$this->load->view('admin/layout_page', $data);


	}


	public function add_comment($id)
	{
        enforce_permission('tickets-edit');

		$data['ticket'] = $this->ticket->get($id);

		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('comment', __('Comment'), 'trim');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {

				$db_data = array(
					'ticket_id' => $id,
					'added_by' => $this->session->staff_id,
					'comment' => $this->input->post('comment'),
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->ticket->add_comment($db_data);

				if($result) {
                    log_staff('Ticket comment added ' . $id);

					$this->session->set_flashdata('toast-success', __("Comment has been successfully added."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to add comment."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$data['title'] = __("Add Comment");
			$data['modal'] = 'admin/tickets/add_comment';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function edit_comment($id=0)
	{
        enforce_permission('tickets-edit');

		$data['comment'] = $this->ticket->get_comment($id);
		$data['ticket'] = $this->ticket->get($data['comment']['ticket_id']);

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
				$result = $this->ticket->edit_comment($db_data, $id);

				if($result) {
                    log_staff('Ticket commend edited ' . $id);

					$this->session->set_flashdata('toast-success', __("Comment has been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to update comment."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$data['title'] = __("Edit Comment");
			$data['modal'] = 'admin/tickets/edit_comment';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function delete_comment($id=0)
	{

        enforce_permission('tickets-edit');

		$data['comment'] = $this->ticket->get_comment($id);
		$data['ticket'] = $this->ticket->get($data['comment']['ticket_id']);

		if($this->input->method() === 'post') {

			$result = $this->ticket->delete_comment($id);

			if($result) {
                log_staff('Ticket comment deleted ' . $id);

				$this->session->set_flashdata('toast-success', __("Comment has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete comment."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			$data['title'] = __("Delete Comment");
			$data['modal'] = 'admin/tickets/delete_comment';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}






	public function download_reply_file($id=0)
	{
        enforce_permission('tickets-view');

		$data['file'] = $this->ticket->get_reply_file($id);

		force_download($data['file']['name'], read_file("./filestore/main/tickets/" . $data['file']['file']));
	}



}
