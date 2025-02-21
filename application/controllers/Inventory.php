<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory extends User_Controller {

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

		$this->load->library('datatables');
	}





	public function json_assets() {

        enforce_user_permission('assets');

		$this->datatables
			->select('app_assets.id, app_assets.name, app_assets.tag, app_assets.warranty_end')
			->from('app_assets')
            ->where('app_assets.client_id', $this->session->client_id)

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

					'<a href="'.base_url('inventory/asset_details/').'$1" data-toggle="tooltip" title="'.__("View Asset").'" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-eye"></i></a>'.
					
				'</div>',
				'id'
			);

		echo $this->datatables->generate();
	}



	public function json_asset_issues($id=0) {

        enforce_user_permission('issues');

		$this->datatables
			->select('app_issues.id, app_issues.name, app_issues.status, app_issues.due_date, app_issues.priority, app_issues.type')
			->from('app_issues')

			->where('app_issues.asset_id', $id)

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




	public function json_asset_tickets($id=0) {

        enforce_user_permission('tickets');

		$this->datatables
			->select('app_tickets.id, app_tickets.ticket, app_tickets.subject, app_tickets.email, app_tickets.status, app_tickets.priority')

			->where('app_tickets.asset_id', $id)

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


	public function json_credentials() {

        enforce_user_permission('credentials');

		$this->datatables
			->select('app_credentials.id, app_credentials.type, app_credentials.username')
			->from('app_credentials')
            ->where('app_credentials.client_id', $this->session->client_id)


			->join('app_clients', 'app_credentials.client_id = app_clients.id', 'LEFT')
			->select('app_clients.name as client_name')

			->join('app_assets', 'app_credentials.asset_id = app_assets.id', 'LEFT')
			->select('app_assets.name as asset_name')

			->join('app_projects', 'app_credentials.project_id = app_projects.id', 'LEFT')
			->select('app_projects.name as project_name')


		
			->add_column(
				'actions',
				'<div class="btn-group" role="group">'.
					'<button data-modal="inventory/view_credential/$1" data-toggle="tooltip" title="'.__("View Credential").'" type="button" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-eye"></i></button>'.
				
				'</div>',
				'id'
			);

		echo $this->datatables->generate();
	}



	public function json_domains() {

        enforce_user_permission('domains');

		$this->datatables
			->select('app_domains.id, app_domains.domain, app_domains.exp_date')
			->from('app_domains')
            ->where('app_domains.client_id', $this->session->client_id)

			->join('app_clients', 'app_domains.client_id = app_clients.id', 'LEFT')
			->select('app_clients.name as client_name')


			->add_column(
				'actions',
				'<div class="btn-group" role="group">'.
                    '<button data-modal="inventory/view_domain/$1" data-toggle="tooltip" title="'.__("View Domain").'" type="button" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-eye"></i></button>'.
					
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



	public function json_licenses() {

        enforce_user_permission('licenses');

		$this->datatables
			->select('app_licenses.id, app_licenses.name, app_licenses.tag')
			->from('app_licenses')
            ->where('app_licenses.client_id', $this->session->client_id)

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
					'<a href="'.base_url('inventory/license_details/').'$1" data-toggle="tooltip" title="'.__("View License").'" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-eye"></i></a>'.

					
				'</div>',
				'id'
			);

		echo $this->datatables->generate();
	}





	public function json_license_issues($id=0) {

        enforce_user_permission('issues');

		$this->datatables
			->select('app_issues.id, app_issues.name, app_issues.status, app_issues.due_date, app_issues.priority, app_issues.type')
			->from('app_issues')

			->where('app_issues.license_id', $id)

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




	public function json_license_tickets($id=0) {

        enforce_user_permission('tickets');

		$this->datatables
			->select('app_tickets.id, app_tickets.ticket, app_tickets.subject, app_tickets.email, app_tickets.status, app_tickets.priority')

			->where('app_tickets.license_id', $id)

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


	public function assets()
	{
        enforce_user_permission('assets');

		$data['title'] = __("Assets");
		$data['page'] = 'user/inventory/assets';

        log_user('Viewed assets');

		$this->load->view('user/layout_page', html_escape($data));

	}


    public function licenses()
	{
        enforce_user_permission('licenses');

		$data['title'] = __("Licenses");
		$data['page'] = 'user/inventory/licenses';

        log_user('Viewed licenses');

		$this->load->view('user/layout_page', html_escape($data));

	}


    public function domains()
	{
        enforce_user_permission('domains');

		$data['title'] = __("Domains");
		$data['page'] = 'user/inventory/domains';

        log_user('Viewed domains');

		$this->load->view('user/layout_page', html_escape($data));

	}

    public function credentials()
	{
        enforce_user_permission('credentials');

		$data['title'] = __("Credentials");
		$data['page'] = 'user/inventory/credentials';

        log_user('Viewed credentials');

		$this->load->view('user/layout_page', html_escape($data));

	}




    public function view_credential($id=0)
	{
        enforce_user_permission('credentials');

		$data['credential'] = $this->credential->get($id);
        if($this->session->client_id != $data['credential']['client_id']) die('Unauthorized!');
		
		$data['asset'] = $this->asset->get($data['credential']['asset_id']);
		$data['project'] = $this->project->get($data['credential']['project_id']);

		$data['title'] = __("View Credential");
		$data['modal'] = 'user/inventory/view_credential';

        log_user('Viewed credential ' . $id);

		$this->load->view('user/layout_modal', html_escape($data));


	}


    public function view_domain($id=0)
	{
        enforce_user_permission('domains');

		$data['domain'] = $this->domain->get($id);
        if($this->session->client_id != $data['domain']['client_id']) die('Unauthorized!');

		$data['selected_notify'] = unserialize($data['domain']['notify']);
		

	
        $data['title'] = __("View Domain");
        $data['modal'] = 'user/inventory/view_domain';

        log_user('Viewed domain ' . $id);

        $this->load->view('user/layout_modal', html_escape($data));
    

	}




	public function asset_details($id=0)
	{
        enforce_user_permission('assets');

		$data['asset'] = $this->asset->get($id);
        if($this->session->client_id != $data['asset']['client_id']) die('Unauthorized!');

		$data['files'] = $this->asset->get_files($id);
		$data['comments'] = $this->asset->get_comments($id);
		$data['credentials'] = $this->asset->get_credentials($id);
		$data['assigned_licenses'] = $this->asset->get_assigned_licenses($id);

		
		$data['user'] = $this->user->get($data['asset']['user_id']);

		$data['customfields'] = $this->customfield->get_for('Assets');

		$data['title'] = __("Asset") . " - " . $data['asset']['name'];
		$data['section'] = 'details';
		$data['page'] = 'user/inventory/asset';


        $clear_notes = $data['asset']['notes'];
        $clear_cf = $data['asset']['custom_fields_values'];

        $data = html_escape($data);

        $data['asset']['notes'] = purify($clear_notes);
        $data['asset']['custom_fields_values'] = $clear_cf;



        log_user('Viewed asset ' . $id);
		$this->load->view('user/layout_page', $data);
	}




	public function asset_issues($id=0)
	{
        enforce_user_permission('issues');

		$data['asset'] = $this->asset->get($id);
        if($this->session->client_id != $data['asset']['client_id']) die('Unauthorized!');


		$data['title'] = __("Asset") . " - " . $data['asset']['name'];
		$data['section'] = 'issues';
		$data['page'] = 'user/inventory/asset';

        log_user('Viewed asset issues ' . $id); 
		$this->load->view('user/layout_page', html_escape($data));
	}



	public function asset_tickets($id=0)
	{
        enforce_user_permission('tickets');

		$data['asset'] = $this->asset->get($id);
        if($this->session->client_id != $data['asset']['client_id']) die('Unauthorized!');


		$data['title'] = __("Asset") . " - " . $data['asset']['name'];
		$data['section'] = 'tickets';
		$data['page'] = 'user/inventory/asset';

        log_user('Viewed asset tickets ' . $id);
		$this->load->view('user/layout_page', html_escape($data));
	}


	public function download_asset_file($id=0)
	{
        enforce_user_permission('assets');

		$data['file'] = $this->asset->get_file($id);
		$data['asset'] = $this->asset->get($data['file']['asset_id']);

        log_user('Downloaded asset file ' . $id);
		force_download("./filestore/main/assets/" . $data['file']['file'], NULL);
	}






	public function license_details($id=0)
	{
        enforce_user_permission('licenses');

		$data['license'] = $this->license->get($id);
        if($this->session->client_id != $data['license']['client_id']) die('Unauthorized!');

		$data['files'] = $this->license->get_files($id);
		$data['comments'] = $this->license->get_comments($id);


		
		$data['user'] = $this->user->get($data['license']['user_id']);
		$data['customfields'] = $this->customfield->get_for('Licenses');
		$data['assigned_assets'] = $this->license->get_assigned_assets($id);

		$data['title'] = __("License") . " - " . $data['license']['name'];
		$data['section'] = 'details';
		$data['page'] = 'user/inventory/license';

        $clear_notes = $data['license']['notes'];
        $clear_cf = $data['license']['custom_fields_values'];

        $data = html_escape($data);

        $data['license']['notes'] = purify($clear_notes);
        $data['license']['custom_fields_values'] = $clear_cf;


        log_user('Viewed license ' . $id);
		$this->load->view('user/layout_page', $data);
	}




	public function license_issues($id=0)
	{
        enforce_user_permission('issues');

		$data['license'] = $this->license->get($id);
        if($this->session->client_id != $data['license']['client_id']) die('Unauthorized!');


		$data['title'] = __("License") . " - " . $data['license']['name'];
		$data['section'] = 'issues';
		$data['page'] = 'user/inventory/license';

        log_user('Viewed license issues ' . $id);
		$this->load->view('user/layout_page', html_escape($data));
	}



	public function license_tickets($id=0)
	{
        enforce_user_permission('tickets');

		$data['license'] = $this->license->get($id);
        if($this->session->client_id != $data['license']['client_id']) die('Unauthorized!');


		$data['title'] = __("License") . " - " . $data['license']['name'];
		$data['section'] = 'tickets';
		$data['page'] = 'user/inventory/license';

        log_user('Viewed license tickets ' . $id);
		$this->load->view('user/layout_page', html_escape($data));
	}


	public function download_license_file($id=0)
	{

        enforce_user_permission('licenses');

		$data['file'] = $this->license->get_file($id);
		$data['license'] = $this->license->get($data['file']['license_id']);

        log_user('Downloaded license file ' . $id);

		force_download("./filestore/main/licenses/" . $data['file']['file'], NULL);
	}


}