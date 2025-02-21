<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clients extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('admin/client_model', 'client');
		$this->load->model('admin/setting_model', 'setting');


		$this->load->model('admin/asset_model', 'asset');
		$this->load->model('admin/license_model', 'license');
		$this->load->model('admin/domain_model', 'domain');
		$this->load->model('admin/credential_model', 'credential');
		$this->load->model('admin/project_model', 'project');
		$this->load->model('admin/ticket_model', 'ticket');
		$this->load->model('admin/issue_model', 'issue');
		$this->load->model('admin/reminder_model', 'reminder');

		$this->load->model('admin/attribute_model', 'attribute');

		$this->load->model('admin/staff_model', 'staff');
		$this->load->model('admin/user_model', 'user');

		$this->load->model('admin/customfield_model', 'customfield');


		$this->load->library('datatables');
	}


	public function json_all() {
        enforce_permission('client-view');

		$this->datatables
			->select('id, name, email')
			->from('app_clients')
			->add_column(
				'actions',
				'<div class="btn-group" role="group">'.
					'<a href="'.base_url('admin/clients/overview/').'$1" data-toggle="tooltip" title="'.__("Manage Client").'" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-eye"></i></a>'.
					'<a href="'.base_url('admin/clients/edit/').'$1" data-toggle="tooltip" title="'.__("Edit Client").'" class="btn btn-success btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-edit"></i></a>'.

					'<button data-modal="admin/clients/delete/$1" data-toggle="tooltip" title="'.__("Delete Client").'" type="button" class="btn btn-danger btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-trash"></i></button>'.
				'</div>',
				'id'
			);

		echo $this->datatables->generate();
	}



	public function json_assets($id=0) {
        enforce_permission('assets-view');

		$this->datatables
			->select('app_assets.id, app_assets.name, app_assets.tag, app_assets.warranty_end')
			->from('app_assets')

			->where('app_assets.client_id', $id)

			->join('app_status_labels', 'app_assets.status_id = app_status_labels.id', 'LEFT')
			->select('app_status_labels.name as status')
			->select('app_status_labels.color as status_color')

			->join('app_asset_categories', 'app_assets.category_id = app_asset_categories.id', 'LEFT')
			->select('app_asset_categories.name as category')
			->select('app_asset_categories.color as category_color')

			->join('app_clients', 'app_assets.client_id = app_clients.id', 'LEFT')
			->select('app_clients.name as client_name')


			->edit_column('category', '<span class="label" style="background-color:$1">$2</span>', 'category_color,category')

			->edit_column('status', '<span class="label" style="background-color:$1">$2</span>', 'status_color,status')

	

			->add_column(
				'actions',
				'<div class="btn-group" role="group">'.
					'<a href="'.base_url('admin/inventory/assets/details/').'$1" data-toggle="tooltip" title="'.__("Manage Asset").'" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-eye"></i></a>'.

					'<button data-modal="admin/inventory/assets/edit/$1" data-toggle="tooltip" title="'.__("Edit Asset").'" type="button" class="btn btn-success btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-edit"></i></button>'.
					'<button data-modal="admin/inventory/assets/delete/$1" data-toggle="tooltip" title="'.__("Delete Asset").'" type="button" class="btn btn-danger btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-trash"></i></button>'.
				'</div>',
				'id'
			);

		echo $this->datatables->generate();
	}



	public function json_licenses($id=0) {
        enforce_permission('licenses-view');

		$this->datatables
			->select('app_licenses.id, app_licenses.name, app_licenses.tag')
			->from('app_licenses')

			->where('app_licenses.client_id', $id)

			->join('app_status_labels', 'app_licenses.status_id = app_status_labels.id', 'LEFT')
			->select('app_status_labels.name as status')
			->select('app_status_labels.color as status_color')

			->join('app_license_categories', 'app_licenses.category_id = app_license_categories.id', 'LEFT')
			->select('app_license_categories.name as category')
			->select('app_license_categories.color as category_color')

			->join('app_clients', 'app_licenses.client_id = app_clients.id', 'LEFT')
			->select('app_clients.name as client_name')


			->edit_column('category', '<span class="label" style="background-color:$1">$2</span>', 'category_color,category')

			->edit_column('status', '<span class="label" style="background-color:$1">$2</span>', 'status_color,status')



			->add_column(
				'actions',
				'<div class="btn-group" role="group">'.
					'<a href="'.base_url('admin/inventory/licenses/details/').'$1" data-toggle="tooltip" title="'.__("Manage License").'" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-eye"></i></a>'.

					'<button data-modal="admin/inventory/licenses/edit/$1" data-toggle="tooltip" title="'.__("Edit License").'" type="button" class="btn btn-success btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-edit"></i></button>'.
					'<button data-modal="admin/inventory/licenses/delete/$1" data-toggle="tooltip" title="'.__("Delete License").'" type="button" class="btn btn-danger btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-trash"></i></button>'.
				'</div>',
				'id'
			);

		echo $this->datatables->generate();
	}


	public function json_domains($id=0) {
        enforce_permission('domains-view');

		$this->datatables
			->select('app_domains.id, app_domains.domain, app_domains.exp_date')
			->from('app_domains')

			->where('app_domains.client_id', $id)

			->join('app_clients', 'app_domains.client_id = app_clients.id', 'LEFT')
			->select('app_clients.name as client_name')


			->add_column(
				'actions',
				'<div class="btn-group" role="group">'.

					'<button data-modal="admin/inventory/domains/edit/$1" data-toggle="tooltip" title="'.__("Edit Domain").'" type="button" class="btn btn-success btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-edit"></i></button>'.
					'<button data-modal="admin/inventory/domains/delete/$1" data-toggle="tooltip" title="'.__("Delete Domain").'" type="button" class="btn btn-danger btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-trash"></i></button>'.
				'</div>',
				'id'
			);

		$results = $this->datatables->generate('json');
		$results = json_decode($results, TRUE);

		foreach($results['data'] as $key => $value) {


			if(date('Y-m-d') > $value['exp_date']) {
				$results['data'][$key]['exp_date'] = "<span class='text-danger' data-toggle='tooltip' title='".__("Expired")."'>".date_display($value['exp_date'])."</span>";
			}
			if($value['exp_date'] > date('Y-m-d')) {
				$results['data'][$key]['due_date'] = "<span class='text-primary'>".date_display($value['exp_date'])."</span>";
			}



		}

		echo json_encode($results);
	}



	public function json_credentials($id=0) {
        enforce_permission('credentials-view');

		$this->datatables
			->select('app_credentials.id, app_credentials.type, app_credentials.username')
			->from('app_credentials')

			->where('app_credentials.client_id', $id)

			->join('app_clients', 'app_credentials.client_id = app_clients.id', 'LEFT')
			->select('app_clients.name as client_name')

			->join('app_assets', 'app_credentials.asset_id = app_assets.id', 'LEFT')
			->select('app_assets.name as asset_name')

			->join('app_projects', 'app_credentials.project_id = app_projects.id', 'LEFT')
			->select('app_projects.name as project_name')

			->add_column(
				'actions',
				'<div class="btn-group" role="group">'.
					'<button data-modal="admin/inventory/credentials/view/$1" data-toggle="tooltip" title="'.__("View Credential").'" type="button" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-eye"></i></button>'.
					'<button data-modal="admin/inventory/credentials/edit/$1" data-toggle="tooltip" title="'.__("Edit Credential").'" type="button" class="btn btn-success btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-edit"></i></button>'.
					'<button data-modal="admin/inventory/credentials/delete/$1" data-toggle="tooltip" title="'.__("Delete Credential").'" type="button" class="btn btn-danger btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-trash"></i></button>'.
				'</div>',
				'id'
			);

		echo $this->datatables->generate();
	}



	public function json_projects($id=0) {
        enforce_permission('projects-view');

		$this->datatables
			->select('app_projects.id, app_projects.name, app_projects.status')
			->from('app_projects')

			->where('app_projects.client_id', $id)

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




	public function json_tickets($id=0) {
        enforce_permission('tickets-view');

		$this->datatables
			->select('app_tickets.id, app_tickets.ticket, app_tickets.subject, app_tickets.email, app_tickets.status, app_tickets.priority')

			->where('app_tickets.client_id', $id)

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



	public function json_issues($id=0) {
        enforce_permission('issues-view');

		$this->datatables
			->select('app_issues.id, app_issues.name, app_issues.status, app_issues.due_date, app_issues.priority, app_issues.type')
			->from('app_issues')

			->where('app_issues.client_id', $id)

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



	public function json_reminders($id=0) {
        enforce_permission('reminders-view');

		$this->datatables
			->select('app_reminders.id, app_reminders.description, app_reminders.status, app_reminders.datetime')
			->from('app_reminders')

			->where('app_reminders.client_id', $id)

			->join('core_staff', 'app_reminders.assigned_to = core_staff.id', 'LEFT')
			->select('core_staff.name as assigned_to')

			->join('app_clients', 'app_reminders.client_id = app_clients.id', 'LEFT')
			->select('app_clients.name as client_name')

			->edit_column_if('status', '<span class="label label-danger">'.__("Upcoming").'</span>', '', 'Upcoming')
			->edit_column_if('status', '<span class="label label-success">'.__("Reminded").'</span>', '', 'Reminded')



			->add_column(
				'actions',
				'<div class="btn-group" role="group">'.

					'<button data-modal="admin/reminders/edit/$1" data-toggle="tooltip" title="'.__("Edit Reminder").'" type="button" class="btn btn-success btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-edit"></i></button>'.
					'<button data-modal="admin/reminders/delete/$1" data-toggle="tooltip" title="'.__("Delete Reminder").'" type="button" class="btn btn-danger btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-trash"></i></button>'.
				'</div>',
				'id'
			);

		$results = $this->datatables->generate('json');
		$results = json_decode($results, TRUE);

		foreach($results['data'] as $key => $value) {

			$results['data'][$key]['datetime'] = datetime_display($value['datetime']);

		}

		echo json_encode($results);
	}





    public function json_proposals($id=0) {
        enforce_permission('proposals-view');

		$this->datatables
			->select('app_proposals.id, app_proposals.currency_id, app_proposals.number, app_proposals.date, app_proposals.valid_until, app_proposals.total, app_proposals.status')
			->from('app_proposals')
            ->where('app_proposals.client_id', $id)

			->join('app_clients', 'app_proposals.client_id = app_clients.id', 'LEFT')
			->select('app_clients.name as client_name')

            ->join('app_entities', 'app_proposals.entity_id = app_entities.id', 'LEFT')
			->select('app_entities.title as entity_name')

			->edit_column_if('status', '<span class="label label-inverse-danger">'.__("Draft").'</span>', '', 'Draft')
            ->edit_column_if('status', '<span class="label label-inverse-primary">'.__("Sent").'</span>', '', 'Sent')
			->edit_column_if('status', '<span class="label label-inverse-success">'.__("Accepted").'</span>', '', 'Accepted')
            ->edit_column_if('status', '<span class="label label-inverse-info-border">'.__("Canceled").'</span>', '', 'Canceled')

            ->add_column(
				'actions',
				'<div class="btn-group" role="group">'.

                    '<button data-modal="admin/sales/proposals/view/$1" data-toggle="tooltip" title="'.__("View Proposal").'" type="button" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-eye"></i></button>'.
					'<a href="'.base_url('admin/sales/proposals/edit/').'$1" data-toggle="tooltip" title="'.__("Edit Proposal").'" type="button" class="btn btn-success btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-edit"></i></a>'.



                    '<div class="dropdown">'.
                        '<a class="btn btn-inverse btn-mini" title="'.__("More actions").'" href="#" id="dropdown-$1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-fw fa-ellipsis-v"></i> </a>'.

                        '<div class="dropdown-menu">'.
                            '<a href="'.base_url('admin/sales/proposals/pdf/view/').'$1" target="_blank" class="dropdown-item"><i class="fas fa-fw fa-file-pdf"></i> '.__("View PDF").'</a>'.
                            '<a href="'.base_url('admin/sales/proposals/pdf/download/').'$1"  class="dropdown-item"><i class="fas fa-fw fa-file-pdf"></i> '.__("Download PDF").'</a>'.

                            '<a href="#" data-modal="admin/sales/proposals/send_email/$1" class="dropdown-item"><i class="fas fa-fw fa-envelope"></i> '.__("Send Email").'</a>'.


                            '<div class="dropdown-divider"></div>'.

                            '<a data-modal="admin/sales/proposals/generate_proforma/$1" href="#"  class="dropdown-item"><i class="fas fa-fw fa-file-invoice"></i> '.__("Generate Proforma").'</a>'.
                            '<a data-modal="admin/sales/proposals/generate_invoice/$1" href="#"  class="dropdown-item"><i class="fas fa-fw fa-file-invoice-dollar"></i> '.__("Generate Invoice").'</a>'.

                            '<div class="dropdown-divider"></div>'.

                            '<a data-modal="admin/sales/proposals/duplicate/$1" href="#"  class="dropdown-item"><i class="fas fa-fw fa-clone"></i> '.__("Duplicate").'</a>'.
                            '<a data-modal="admin/sales/proposals/delete/$1" href="#"  class="dropdown-item"><i class="fas fa-fw fa-trash"></i> '.__("Delete").'</a>'.
                        '</div>'.

                    '</div>'.


                '</div>',
				'id'
			);



        $results = $this->datatables->generate('json');
        $results = json_decode($results, TRUE);

        foreach($results['data'] as $key => $value) {

            $results['data'][$key]['date'] = date_display($value['date']);
            $results['data'][$key]['valid_until'] = date_display($value['valid_until']);


            $results['data'][$key]['total'] = format_currency($value['total'], $value['currency_id']);
        }

        echo json_encode($results);

	}



	public function json_proformas($id=0) {

        enforce_permission('proformas-view');
		$this->datatables
			->select('app_proformas.id, app_proformas.currency_id, app_proformas.number, app_proformas.date, app_proformas.due_date, app_proformas.value, app_proformas.tax, app_proformas.total, app_proformas.unpaid, app_proformas.status')
			->from('app_proformas')
            ->where('app_proformas.client_id', $id)

			->join('app_clients', 'app_proformas.client_id = app_clients.id', 'LEFT')
			->select('app_clients.name as client_name')

            ->join('core_staff', 'app_proformas.added_by = core_staff.id', 'LEFT')
            ->select('core_staff.name as agent_name')

            ->join('app_entities', 'app_proformas.entity_id = app_entities.id', 'LEFT')
			->select('app_entities.title as entity_name')


			->edit_column_if('status', '<span class="label label-inverse-danger">'.__("Canceled").'</span>', '', 'Canceled')
			->edit_column_if('status', '<span class="label label-inverse-success">'.__("Valid").'</span>', '', 'Valid')
            ->edit_column_if('status', '<span class="label label-inverse-primary">'.__("Draft").'</span>', '', 'Draft')

            ->add_column(
				'actions',
				'<div class="btn-group" role="group">'.
                    '<button data-modal="admin/sales/proformas/view/$1" data-toggle="tooltip" title="'.__("View Proforma").'" type="button" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-eye"></i></button>'.



                    '<a href="'.base_url('admin/sales/proformas/edit/').'$1" data-toggle="tooltip" title="'.__("Edit proforma").'" type="button" class="btn btn-success btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-edit"></i></a>'.

                    '<div class="dropdown">'.
                        '<a class="btn btn-inverse btn-mini" title="'.__("More actions").'" href="#" id="dropdown-$1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-fw fa-ellipsis-v"></i> </a>'.

                        '<div class="dropdown-menu">'.



                            '<a data-modal="admin/sales/proformas/manage_payment/$1" href="#"  class="dropdown-item"><i class="fas fa-fw fa-coins"></i> '.__("Manage Payment").'</a>'.

                            '<a href="#" data-modal="admin/sales/proformas/send_email/$1" class="dropdown-item"><i class="fas fa-fw fa-envelope"></i> '.__("Send Email").'</a>'.



                            '<a data-modal="admin/sales/proformas/duplicate/$1" href="#"  class="dropdown-item"><i class="fas fa-fw fa-clone"></i> '.__("Duplicate").'</a>'.


                            '<a data-modal="admin/sales/proformas/delete/$1" href="#"  class="dropdown-item"><i class="fas fa-fw fa-trash"></i> '.__("Delete Proforma").'</a>'.



                        '</div>'.

                    '</div>'.






                '</div>',
				'id'
			);



        $results = $this->datatables->generate('json');
        $results = json_decode($results, TRUE);

        foreach($results['data'] as $key => $value) {

            $results['data'][$key]['date'] = date_display($value['date']);
            $results['data'][$key]['due_date'] = date_display($value['due_date']);




            $results['data'][$key]['value'] = format_currency($value['value'], $value['currency_id']);
            $results['data'][$key]['tax'] = format_currency(round($value['tax'],2), $value['currency_id']);
            $results['data'][$key]['total'] = format_currency($value['total'], $value['currency_id']);

            if($value['unpaid'] > 0) {
                $results['data'][$key]['unpaid'] = '<span class="text-danger">' . format_currency($value['unpaid'], $value['currency_id']) . '</span>';
            } else {
                $results['data'][$key]['unpaid'] = format_currency($value['unpaid'], $value['currency_id']);
            }



        }

        echo json_encode($results);

	}




    public function json_invoices($id=0) {

        enforce_permission('invoices-view');

		$this->datatables
			->select('app_invoices.id, app_invoices.currency_id, app_invoices.number, app_invoices.date, app_invoices.due_date, app_invoices.value, app_invoices.tax, app_invoices.total, app_invoices.unpaid, app_invoices.status')
			->from('app_invoices')
            ->where('app_invoices.client_id', $id)

			->join('app_clients', 'app_invoices.client_id = app_clients.id', 'LEFT')
			->select('app_clients.name as client_name')

            ->join('core_staff', 'app_invoices.added_by = core_staff.id', 'LEFT')
            ->select('core_staff.name as agent_name')

            ->join('app_entities', 'app_invoices.entity_id = app_entities.id', 'LEFT')
			->select('app_entities.title as entity_name')


			->edit_column_if('status', '<span class="label label-inverse-danger">'.__("Canceled").'</span>', '', 'Canceled')
			->edit_column_if('status', '<span class="label label-inverse-success">'.__("Valid").'</span>', '', 'Valid')
            ->edit_column_if('status', '<span class="label label-inverse-primary">'.__("Draft").'</span>', '', 'Draft')

            ->add_column(
				'actions',
				'<div class="btn-group" role="group">'.
                    '<button data-modal="admin/sales/invoices/view/$1" data-toggle="tooltip" title="'.__("View Invoice").'" type="button" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-eye"></i></button>'.



                    '<a href="'.base_url('admin/sales/invoices/edit/').'$1" data-toggle="tooltip" title="'.__("Edit Invoice").'" type="button" class="btn btn-success btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-edit"></i></a>'.

                    '<div class="dropdown">'.
                        '<a class="btn btn-inverse btn-mini" title="'.__("More actions").'" href="#" id="dropdown-$1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-fw fa-ellipsis-v"></i> </a>'.

                        '<div class="dropdown-menu">'.



                            '<a data-modal="admin/sales/invoices/manage_payment/$1" href="#"  class="dropdown-item"><i class="fas fa-fw fa-coins"></i> '.__("Manage Payment").'</a>'.

                            '<div class="dropdown-divider"></div>'.
                            '<a href="#" data-modal="admin/sales/invoices/send_email/$1" class="dropdown-item"><i class="fas fa-fw fa-envelope"></i> '.__("Send Email").'</a>'.
                            '<a href="#" data-modal="admin/sales/proforinvoicesmas/send_reminder/$1" class="dropdown-item"><i class="fas fa-fw fa-bell"></i> '.__("Send Reminder").'</a>'.
                            '<div class="dropdown-divider"></div>'.


                            '<a data-modal="admin/sales/invoices/duplicate/$1" href="#"  class="dropdown-item"><i class="fas fa-fw fa-clone"></i> '.__("Duplicate").'</a>'.

                            '<a data-modal="admin/sales/invoices/generate_storno/$1" href="#"  class="dropdown-item"><i class="fas fa-fw fa-minus"></i> '.__("Generate Storno").'</a>'.

                            '<a data-modal="admin/sales/invoices/delete/$1" href="#"  class="dropdown-item"><i class="fas fa-fw fa-trash"></i> '.__("Delete Invoice").'</a>'.



                        '</div>'.

                    '</div>'.






                '</div>',
				'id'
			);



        $results = $this->datatables->generate('json');
        $results = json_decode($results, TRUE);

        foreach($results['data'] as $key => $value) {

            $results['data'][$key]['date'] = date_display($value['date']);
            $results['data'][$key]['due_date'] = date_display($value['due_date']);




            $results['data'][$key]['value'] = format_currency($value['value'], $value['currency_id']);
            $results['data'][$key]['tax'] = format_currency(round($value['tax'],2), $value['currency_id']);
            $results['data'][$key]['total'] = format_currency($value['total'], $value['currency_id']);

            if($value['unpaid'] > 0) {
                $results['data'][$key]['unpaid'] = '<span class="text-danger">' . format_currency($value['unpaid'], $value['currency_id']) . '</span>';
            } else {
                $results['data'][$key]['unpaid'] = format_currency($value['unpaid'], $value['currency_id']);
            }



        }

        echo json_encode($results);

	}




    public function json_recurring($id=0) {
        enforce_permission('recurring-view');

		$this->datatables
			->select('app_recurring.id, app_recurring.type, app_recurring.frequency, app_recurring.name, app_recurring.start_date, app_recurring.next_date, app_recurring.value, app_recurring.status, app_recurring.emissions')
			->from('app_recurring')
            ->where('app_recurring.client_id', $id)

			->join('app_clients', 'app_recurring.client_id = app_clients.id', 'LEFT')
			->select('app_clients.name as client_name')

            ->join('core_staff', 'app_recurring.added_by = core_staff.id', 'LEFT')
            ->select('core_staff.name as agent_name')

            ->join('app_currencies', 'app_recurring.currency_id = app_currencies.id', 'LEFT')
            ->select('app_currencies.code as currency')

            ->join('app_entities', 'app_recurring.entity_id = app_entities.id', 'LEFT')
			->select('app_entities.title as entity_name')

			->edit_column_if('status', '<span class="label label-inverse-danger">'.__("Draft").'</span>', '', 'Draft')
            ->edit_column_if('status', '<span class="label label-inverse-primary">'.__("Active").'</span>', '', 'Active')
			->edit_column_if('status', '<span class="label label-inverse-success">'.__("Suspended").'</span>', '', 'Suspended')
            ->edit_column_if('status', '<span class="label label-inverse-info-border">'.__("Canceled").'</span>', '', 'Canceled')

            ->add_column(
				'actions',
				'<div class="btn-group" role="group">'.

                    '<button data-modal="admin/sales/recurring/view/$1" data-toggle="tooltip" title="'.__("View Recurrence").'" type="button" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-eye"></i></button>'.
					'<a href="'.base_url('admin/sales/recurring/edit/').'$1" data-toggle="tooltip" title="'.__("Edit Recurrence").'" type="button" class="btn btn-success btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-edit"></i></a>'.
                    '<button data-modal="admin/sales/recurring/duplicate/$1" data-toggle="tooltip" title="'.__("Duplicate Recurrence").'" type="button" class="btn btn-warning btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-copy"></i></button>'.
					'<button data-modal="admin/sales/recurring/delete/$1" data-toggle="tooltip" title="'.__("Delete Recurrence").'" type="button" class="btn btn-danger btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-trash"></i></button>'.

                '</div>',
				'id'
			);



        $results = $this->datatables->generate('json');
        $results = json_decode($results, TRUE);

        foreach($results['data'] as $key => $value) {

            $results['data'][$key]['start_date'] = date_display($value['start_date']);
            $results['data'][$key]['next_date'] = date_display($value['next_date']);

        }

        echo json_encode($results);

	}


	public function index()
	{
        enforce_permission('client-view');

		$data['title'] = __("Clients");
		$data['page'] = 'admin/clients/list';



		$this->load->view('admin/layout_page', html_escape($data));
	}



	public function overview($id=0)
	{
        enforce_permission('client-view');

        $data['customfields'] = $this->customfield->get_for('Clients');


		$data['client'] = $this->client->get($id);

		$data['comments'] = $this->client->get_comments($id);


		$data['asset_categories'] = $this->attribute->get_asset_categories();
		$data['license_categories'] = $this->attribute->get_license_categories();
		$data['status_labels'] = $this->attribute->get_status_labels();

		$data['locations'] = $this->db->get_where('app_locations', [ 'client_id' => $id])->result_array();


		$data['title'] = $data['client']['name'] . ' - ' . __("Overview");
		$data['page'] = 'admin/clients/index';
		$data['section'] = 'overview';




		$this->load->view('admin/layout_page', html_escape($data));
	}


	public function edit($id=0)
	{
        enforce_permission('client-edit');

        $data['customfields'] = $this->customfield->get_for('Clients');

		$data['client'] = $this->client->get($id);


		$data['title'] = $data['client']['name'] . ' - ' . __("Edit");
		$data['page'] = 'admin/clients/index';
		$data['section'] = 'edit';


		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('name', __('Name'), 'trim|required');


			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect(base_url('admin/users'));
			} else {

				$db_data = array(
					'name' => $this->input->post('name'),
					'description' => $this->input->post('description'),

					'company_id' => $this->input->post('company_id'),
					'company_taxid' => $this->input->post('company_taxid'),
					'phone' => $this->input->post('phone'),
					'email' => $this->input->post('email'),
					'website' => $this->input->post('website'),
					'address' => $this->input->post('address'),
					'city' => $this->input->post('city'),
					'state' => $this->input->post('state'),
					'zip_code' => $this->input->post('zip_code'),
					'country' => $this->input->post('country'),

                    'custom_fields_values' => json_encode($this->input->post('customfield')),

					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->client->edit($db_data, $id);

				if($result) {
                    log_staff('Client edited ' . $id);

					$this->session->set_flashdata('toast-success', __("Client has been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to add client."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {

            $clear_cf = $data['client']['custom_fields_values'];
            $data = html_escape($data);
            $data['client']['custom_fields_values'] = $clear_cf;


			$this->load->view('admin/layout_page', $data);
		}


	}




	public function assets($id=0)
	{
        enforce_permission('assets-view');

		$data['client'] = $this->client->get($id);


		$data['title'] = $data['client']['name'] . ' - ' . __("Assets");
		$data['page'] = 'admin/clients/index';
		$data['section'] = 'assets';




		$this->load->view('admin/layout_page', html_escape($data));
	}

	public function licenses($id=0)
	{
        enforce_permission('licenses-view');

		$data['client'] = $this->client->get($id);


		$data['title'] = $data['client']['name'] . ' - ' . __("Licenses");
		$data['page'] = 'admin/clients/index';
		$data['section'] = 'licenses';




		$this->load->view('admin/layout_page', html_escape($data));
	}


	public function domains($id=0)
	{
        enforce_permission('domains-view');

		$data['client'] = $this->client->get($id);


		$data['title'] = $data['client']['name'] . ' - ' . __("Domains");
		$data['page'] = 'admin/clients/index';
		$data['section'] = 'domains';




		$this->load->view('admin/layout_page', html_escape($data));
	}


	public function credentials($id=0)
	{
        enforce_permission('credentials-view');

		$data['client'] = $this->client->get($id);


		$data['title'] = $data['client']['name'] . ' - ' . __("Credentials");
		$data['page'] = 'admin/clients/index';
		$data['section'] = 'credentials';




		$this->load->view('admin/layout_page', html_escape($data));
	}

	public function projects($id=0)
	{
        enforce_permission('projects-view');

		$data['client'] = $this->client->get($id);


		$data['title'] = $data['client']['name'] . ' - ' . __("Projects");
		$data['page'] = 'admin/clients/index';
		$data['section'] = 'projects';




		$this->load->view('admin/layout_page', html_escape($data));
	}

	public function tickets($id=0)
	{
        enforce_permission('tickets-view');

		$data['client'] = $this->client->get($id);


		$data['title'] = $data['client']['name'] . ' - ' . __("Tickets");
		$data['page'] = 'admin/clients/index';
		$data['section'] = 'tickets';




		$this->load->view('admin/layout_page', html_escape($data));
	}

	public function issues($id=0)
	{
        enforce_permission('issues-view');

		$data['client'] = $this->client->get($id);


		$data['title'] = $data['client']['name'] . ' - ' . __("Issues");
		$data['page'] = 'admin/clients/index';
		$data['section'] = 'issues';




		$this->load->view('admin/layout_page', html_escape($data));
	}

	public function reminders($id=0)
	{
        enforce_permission('reminders-view');

		$data['client'] = $this->client->get($id);


		$data['title'] = $data['client']['name'] . ' - ' . __("Reminders");
		$data['page'] = 'admin/clients/index';
		$data['section'] = 'reminders';




		$this->load->view('admin/layout_page', html_escape($data));
	}

	public function proposals($id=0)
	{
        enforce_permission('proposals-view');

		$data['client'] = $this->client->get($id);


		$data['title'] = $data['client']['name'] . ' - ' . __("Proposals");
		$data['page'] = 'admin/clients/index';
		$data['section'] = 'proposals';




		$this->load->view('admin/layout_page', html_escape($data));
	}



	public function proformas($id=0)
	{
        enforce_permission('proformas-view');

		$data['client'] = $this->client->get($id);


		$data['title'] = $data['client']['name'] . ' - ' . __("Proformas");
		$data['page'] = 'admin/clients/index';
		$data['section'] = 'proformas';



		$this->load->view('admin/layout_page', html_escape($data));
	}

	public function invoices($id=0)
	{
        enforce_permission('invoices-view');

		$data['client'] = $this->client->get($id);


		$data['title'] = $data['client']['name'] . ' - ' . __("Invoices");
		$data['page'] = 'admin/clients/index';
		$data['section'] = 'invoices';




		$this->load->view('admin/layout_page', html_escape($data));
	}


	public function recurring($id=0)
	{
        enforce_permission('recurring-view');

		$data['client'] = $this->client->get($id);


		$data['title'] = $data['client']['name'] . ' - ' . __("Recurring");
		$data['page'] = 'admin/clients/index';
		$data['section'] = 'recurring';




		$this->load->view('admin/layout_page', html_escape($data));
	}


	public function files($id=0)
	{
        enforce_permission('clients-view');

		$data['client'] = $this->client->get($id);

		$data['files'] = $this->client->get_files($id);

		$data['title'] = $data['client']['name'] . ' - ' . __("Files");
		$data['page'] = 'admin/clients/index';
		$data['section'] = 'files';




		$this->load->view('admin/layout_page', html_escape($data));
	}


	public function notes($id=0)
	{
        enforce_permission('clients-view');

		$data['client'] = $this->client->get($id);


		$data['title'] = $data['client']['name'] . ' - ' . __("Notes");
		$data['page'] = 'admin/clients/index';
		$data['section'] = 'notes';


        $clear_notes = $data['client']['notes'];
        $data = html_escape($data);
        $data['client']['notes'] = purify($clear_notes);

		$this->load->view('admin/layout_page', $data);
	}


    

	public function import()
	{
        enforce_permission('clients-add');

		$data['title'] = __("Import Clients");
		$data['page'] = 'admin/clients/import';



        if($this->input->method() === 'post') {


            $csv = fopen($_FILES['userfile']['tmp_name'],"r");
            

            $count = 0;
            while(! feof($csv)) {
                $line = fgetcsv($csv,0,",");
                

                if($this->input->post('skip_first_line') == '1' && $count == 0) { $count++; continue; }

               
            
                
                $name = trim($line[0]);
				$tax_vat_id = trim($line[1]);
                $company_id = trim($line[2]);
                $phone = trim($line[3]);
                $website = trim($line[4]);
                $email = trim($line[5]);
                $address = trim($line[6]);
                $country = trim($line[7]);
                $city = trim($line[8]);
                $state = trim($line[9]);
                $zip_postal_code = trim($line[10]);
                $description = trim($line[11]);

    
            

                $db_data = array(
					'name' => $name,
					'description' => $description,
					'company_id' => $company_id,
					'company_taxid' => $tax_vat_id,
					'phone' => $phone,
					'email' => $email,
					'website' => $website,
					'address' => $address,
					'city' => $city,
					'state' => $state,
					'zip_code' => $zip_postal_code,
					'country' => $country,
					'notes' => '',

					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				
				);
                $db_data = $this->security->xss_clean($db_data);
                $this->db->insert('app_clients', $db_data);


                $count++;
            }

            log_staff('Clients imported');

            $this->session->set_flashdata('toast-success', __("Import has been executed. Check results in the coresponding table."));
            redirect($_SERVER['HTTP_REFERER']);

        }



		$this->load->view('admin/layout_page', html_escape($data));
	}


	public function add()
	{

        enforce_permission('clients-add');

        $data['customfields'] = $this->customfield->get_for('Clients');

		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('name', __('Name'), 'trim|required');


			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect(base_url('admin/users'));
			} else {

				$db_data = array(
					'name' => $this->input->post('name'),
					'description' => $this->input->post('description'),

					'company_id' => $this->input->post('company_id'),
					'company_taxid' => $this->input->post('company_taxid'),
					'phone' => $this->input->post('phone'),
					'email' => $this->input->post('email'),
					'website' => $this->input->post('website'),
					'address' => $this->input->post('address'),
					'city' => $this->input->post('city'),
					'state' => $this->input->post('state'),
					'zip_code' => $this->input->post('zip_code'),
					'country' => $this->input->post('country'),
					'notes' => '',
                    'custom_fields_values' => json_encode($this->input->post('customfield')),

					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->client->add($db_data);

				if($result) {
                    log_staff('Client added ' . $result);

					$this->session->set_flashdata('toast-success', __("Client has been successfully added."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to add client."));
				}

				redirect(base_url('admin/clients'));

			}

		} else {
			$data['title'] = __("Add Client");
			$data['modal'] = 'admin/clients/add';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}






	public function delete($id=0)
	{

        enforce_permission('clients-delete');

		$data['client'] = $this->client->get($id);

		if($this->input->method() === 'post') {

			$result = $this->client->delete($id);

			if($result) {
                log_staff('Client deleted ' . $id);

				$this->session->set_flashdata('toast-success', __("Client has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete client."));
			}

			redirect(base_url('admin/clients'));

		} else {
			$data['title'] = __("Delete Client");
			$data['modal'] = 'admin/clients/delete';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}






	public function edit_notes($id=0)
	{
       
		$data['client'] = $this->client->get($id);

		if($this->input->method() === 'post') {

            enforce_permission('clients-edit');

			$db_data = array(
				'notes' => $this->input->post('notes'),
				'updated_at' => date('Y-m-d H:i:s'),
			);

			$db_data = $this->security->xss_clean($db_data);
			$result = $this->client->edit($db_data, $id);

			if($result) {
                log_staff('Client notes edited ' . $id);

				$this->session->set_flashdata('toast-success', __("Client notes have been successfully updated."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to update client notes."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			redirect($_SERVER['HTTP_REFERER']);
		}

	}








	public function add_comment($id)
	{
        enforce_permission('clients-edit');

		$data['client'] = $this->client->get($id);

		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('comment', __('Comment'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {

				$db_data = array(
					'client_id' => $id,
					'added_by' => $this->session->staff_id,
					'comment' => $this->input->post('comment'),
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->client->add_comment($db_data);

				if($result) {
                    log_staff('Client comment added ' . $result);

					$this->session->set_flashdata('toast-success', __("Comment has been successfully added."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to add comment."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$data['title'] = __("Add Comment");
			$data['modal'] = 'admin/clients/add_comment';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function edit_comment($id=0)
	{
        enforce_permission('clients-edit');

		$data['comment'] = $this->client->get_comment($id);
		$data['client'] = $this->client->get($data['comment']['client_id']);

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
				$result = $this->client->edit_comment($db_data, $id);

				if($result) {
                    log_staff('Client comment edited ' . $id);

					$this->session->set_flashdata('toast-success', __("Comment has been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to update comment."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$data['title'] = __("Edit Comment");
			$data['modal'] = 'admin/clients/edit_comment';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function delete_comment($id=0)
	{
        enforce_permission('clients-delete');

		$data['comment'] = $this->client->get_comment($id);
		$data['client'] = $this->client->get($data['comment']['client_id']);

		if($this->input->method() === 'post') {

			$result = $this->client->delete_comment($id);

			if($result) {
                log_staff('Client comment deleted ' . $id);

				$this->session->set_flashdata('toast-success', __("Comment has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete comment."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			$data['title'] = __("Delete Comment");
			$data['modal'] = 'admin/clients/delete_comment';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}







	public function upload_file($id)
	{
        enforce_permission('clients-edit');

		$data['client'] = $this->client->get($id);

		if($this->input->method() === 'post') {

			$config['upload_path']                = './filestore/main/clients/';
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
				'client_id' => $id,
				'added_by' => $this->session->staff_id,
				'file' => $this->upload->data('file_name'),
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
			);

			$db_data = $this->security->xss_clean($db_data);
			$result = $this->client->add_file($db_data);

			if($result) {
                log_staff('Client file uploaded ' . $result);

				$this->session->set_flashdata('toast-success', __("File has been successfully uploaded."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to upload file."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			$data['title'] = __("Upload File");
			$data['modal'] = 'admin/clients/upload_file';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function delete_file($id=0)
	{
        enforce_permission('clients-delete');

		$data['file'] = $this->client->get_file($id);
		$data['client'] = $this->client->get($data['file']['client_id']);

		if($this->input->method() === 'post') {

			$result = $this->client->delete_file($id);

			unlink('./filestore/main/clients/'.$data['file']['file']);

			if($result) {
				$this->session->set_flashdata('toast-success', __("File has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete file."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
            log_staff('Client file deleted ' . $id);

			$data['title'] = __("Delete File");
			$data['modal'] = 'admin/clients/delete_file';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function download_file($id=0)
	{
        enforce_permission('clients-view');

        log_staff('Client file downloaded ' . $id);


		$data['file'] = $this->client->get_file($id);
		$data['client'] = $this->client->get($data['file']['client_id']);


		force_download("./filestore/main/clients/" . $data['file']['file'], NULL);
	}







	public function add_credential($id)
	{
        enforce_permission('credentials-add');

		$data['client'] = $this->client->get($id);

		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('type', __('Type'), 'trim|required');


			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {

				$db_data = array(
					'client_id' => $id,
					'asset_id' => 0,

					'project_id' => 0,
					'type' => $this->input->post('type'),
					'username' => $this->input->post('username'),
					'pswd' => $this->encryption->encrypt($this->input->post('pswd')),
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->credential->add($db_data);

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
			$data['modal'] = 'admin/clients/add_credential';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}




	public function add_project()
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
					'client_id' => $id,
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



	public function add_issue($id=0)
	{
        enforce_permission('issues-add');

		$data['client'] = $this->client->get($id);

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
					'client_id' => $id,
					'asset_id' => 0,

					'added_by' => $this->session->staff_id,
					'assigned_to' => $this->input->post('assigned_to'),
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

					$this->session->set_flashdata('toast-success', __("Issue has been successfully added."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to add issue."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$data['title'] = __("Add Issue");
			$data['modal'] = 'admin/clients/add_issue';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}





	public function add_ticket($id=0)
	{
        enforce_permission('tickets-add');


		$data['client'] = $this->client->get($id);


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

					'client_id' => $id,
					'asset_id' => 0,
					'license_id' => 0,
					'project_id' => 0,

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
			$data['modal'] = 'admin/clients/add_ticket';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}







	public function add_domain($id=0)
	{
        enforce_permission('domains-add');

		$data['staff'] = $this->staff->get_all_active();

		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('domain', __('Domain'), 'trim|required');
			$this->form_validation->set_rules('exp_date', __('Expiry Date'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {

				$db_data = array(
					'added_by' => $this->session->staff_id,
					'notify' => serialize($this->input->post('notify')),
					'client_id' => $id,

					'domain' => $this->input->post('domain'),
					'exp_date' => date_to_db($this->input->post('exp_date')),

					'notify_30' => $this->input->post('notify_30'),
					'notify_14' => $this->input->post('notify_14'),
					'notify_7' => $this->input->post('notify_7'),
					'notify_3' => $this->input->post('notify_3'),
					'notify_0' => $this->input->post('notify_0'),
					'notify_client' => $this->input->post('notify_client'),

					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->domain->add($db_data);

				if($result) {
                    log_staff('Domain added ' . $result);

					$this->session->set_flashdata('toast-success', __("Domain has been successfully added."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to add domain."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$data['title'] = __("Add Domain");
			$data['modal'] = 'admin/clients/add_domain';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}






	public function add_reminder($id=0)
	{
        enforce_permission('reminders-add');

		$data['staff'] = $this->staff->get_all_active();

		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('assigned_to', __('Assigned To'), 'trim|required');
			$this->form_validation->set_rules('description', __('Description'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {

				$db_data = array(
					'added_by' => $this->session->staff_id,
					'assigned_to' => $this->input->post('assigned_to'),
					'client_id' => $id,
					'status' => "Upcoming",
					'description' => $this->input->post('description'),
					'datetime' => datetime_hi_to_db($this->input->post('datetime')),
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->reminder->add($db_data);

				if($result) {
                    log_staff('Reminder added ' . $result);

					$this->session->set_flashdata('toast-success', __("Reminder has been successfully added."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to add reminder."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$data['title'] = __("Add Reminder");
			$data['modal'] = 'admin/clients/add_reminder';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}




	public function add_asset($id=0)
	{
        enforce_permission('assets-add');

		$data['suppliers'] = $this->attribute->get_suppliers();
		$data['asset_categories'] = $this->attribute->get_asset_categories();
		$data['status_labels'] = $this->attribute->get_status_labels();
		$data['manufacturers'] = $this->attribute->get_manufacturers();
		$data['models'] = $this->attribute->get_models();
		$data['locations'] = $this->attribute->get_locations();

		$data['customfields'] = $this->customfield->get_for('Assets');

		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('name', __('Name'), 'trim|required');


			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect(base_url('admin/inventory/assets'));
			} else {


				if($this->input->post('location_id') == "0" && $this->input->post('new_location') != '') {
					$location_id = $this->attribute->add_location( ['client_id' => $this->input->post('client_id'), 'name' => $this->input->post('new_location') ] );
				} else {
					$location_id = $this->input->post('location_id');
				}


				if($this->input->post('status_id') == "0" && $this->input->post('new_status') != '') {
					$status_id = $this->attribute->add_status( ['name' => $this->input->post('new_status'), 'color' => $this->input->post('new_status_color') ] );
				} else {
					$status_id = $this->input->post('status_id');
				}

				if($this->input->post('category_id') == "0" && $this->input->post('new_asset_category') != '') {
					$category_id = $this->attribute->add_asset_category( ['name' => $this->input->post('new_asset_category'), 'color' => $this->input->post('new_asset_category_color') ] );
				} else {
					$category_id = $this->input->post('category_id');
				}


				if($this->input->post('supplier_id') == "0" && $this->input->post('new_supplier') != '') {
					$supplier_id = $this->attribute->add_supplier( [ 'name' => $this->input->post('new_supplier') ] );
				} else {
					$supplier_id = $this->input->post('supplier_id');
				}


				if($this->input->post('manufacturer_id') == "0" && $this->input->post('new_manufacturer') != '') {
					$manufacturer_id = $this->attribute->add_manufacturer( [ 'name' => $this->input->post('new_manufacturer') ] );
				} else {
					$manufacturer_id = $this->input->post('manufacturer_id');
				}

				if($this->input->post('model_id') == "0" && $this->input->post('new_model') != '') {
					$model_id = $this->attribute->add_model( [ 'name' => $this->input->post('new_model') ] );
				} else {
					$model_id = $this->input->post('model_id');
				}


				$db_data = array(
					'client_id' => $id,
					'category_id' => $category_id,
					'status_id' => $status_id,
					'manufacturer_id' => $manufacturer_id,
					'model_id' => $model_id,
					'location_id' => $location_id,
					'supplier_id' => $supplier_id,
					'tag' => $this->input->post('tag'),
					'name' => $this->input->post('name'),

					'purchase_date' => date_to_db($this->input->post('purchase_date')),
					'warranty_end' => date_to_db($this->input->post('warranty_end')),

					'serial_number' => $this->input->post('serial_number'),

					'custom_fields_values' => json_encode($this->input->post('customfield')),

					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->asset->add($db_data);

				if($result) {
                    log_staff('Asset added ' . $result);

					$this->session->set_flashdata('toast-success', __("Asset has been successfully added."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to add asset."));
				}

				redirect(base_url('admin/client/assets/'.$id));

			}

		} else {
			$data['title'] = __("Add Asset");
			$data['modal'] = 'admin/clients/add_asset';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}





	public function add_license($id=0)
	{
        enforce_permission('licenses-add');

		$data['suppliers'] = $this->attribute->get_suppliers();
		$data['license_categories'] = $this->attribute->get_license_categories();
		$data['status_labels'] = $this->attribute->get_status_labels();


		$data['customfields'] = $this->customfield->get_for('Licenses');

		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('name', __('Name'), 'trim|required');


			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect(base_url('admin/inventory/licenses'));
			} else {



				if($this->input->post('status_id') == "0" && $this->input->post('new_status') != '') {
					$status_id = $this->attribute->add_status( ['name' => $this->input->post('new_status'), 'color' => $this->input->post('new_status_color') ] );
				} else {
					$status_id = $this->input->post('status_id');
				}

				if($this->input->post('category_id') == "0" && $this->input->post('new_license_category') != '') {
					$category_id = $this->attribute->add_license_category( ['name' => $this->input->post('new_license_category'), 'color' => $this->input->post('new_license_category_color') ] );
				} else {
					$category_id = $this->input->post('category_id');
				}


				if($this->input->post('supplier_id') == "0" && $this->input->post('new_supplier') != '') {
					$supplier_id = $this->attribute->add_supplier( [ 'name' => $this->input->post('new_supplier') ] );
				} else {
					$supplier_id = $this->input->post('supplier_id');
				}





				$db_data = array(
					'client_id' => $id,
					'category_id' => $category_id,
					'status_id' => $status_id,
					'supplier_id' => $supplier_id,
					'tag' => $this->input->post('tag'),
					'name' => $this->input->post('name'),
					'serial_number' => $this->input->post('serial_number'),
					'seats' => $this->input->post('seats'),
					'custom_fields_values' => json_encode($this->input->post('customfield')),

					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->license->add($db_data);

				if($result) {
                    log_staff('License added ' . $result);

					$this->session->set_flashdata('toast-success', __("License has been successfully added."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to add license."));
				}

				redirect(base_url('admin/client/licenses/'.$id));

			}

		} else {
			$data['title'] = __("Add License");
			$data['modal'] = 'admin/clients/add_license';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}




}
