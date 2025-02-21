<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Licenses extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('admin/license_model', 'license');
		$this->load->model('admin/client_model', 'client');
		$this->load->model('admin/project_model', 'project');
		$this->load->model('admin/attribute_model', 'attribute');
		$this->load->model('admin/issue_model', 'issue');
		$this->load->model('admin/ticket_model', 'ticket');

		$this->load->model('admin/customfield_model', 'customfield');

		$this->load->model('admin/staff_model', 'staff');
		$this->load->model('admin/user_model', 'user');
		$this->load->model('admin/asset_model', 'asset');

		$this->load->model('admin/setting_model', 'setting');
		$this->load->library('datatables');
	}


	public function json_all() {
        enforce_permission('licenses-view');

		$this->datatables
			->select('app_licenses.id, app_licenses.name, app_licenses.tag')
			->from('app_licenses')

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





	public function json_issues($id=0) {
        enforce_permission('issues-view');
		$this->datatables
			->select('app_issues.id, app_issues.name, app_issues.status, app_issues.due_date, app_issues.priority, app_issues.type')
			->from('app_issues')

			->where('app_issues.license_id', $id)

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



	public function json_history($id=0) {
        enforce_permission('licenses-view');

		$this->datatables
			->select('app_license_history.id, app_license_history.action, app_license_history.extra, app_license_history.created_at')

			->where('app_license_history.license_id', $id)

			->from('app_license_history');

		$results = $this->datatables->generate('json');
		$results = json_decode($results, TRUE);

		foreach($results['data'] as $key => $value) {
			$results['data'][$key]['action'] = __($results['data'][$key]['action']);
			$results['data'][$key]['created_at'] = datetime_display($results['data'][$key]['created_at']);
		}

		echo json_encode($results);
	}


	public function index()
	{
        enforce_permission('licenses-view');
        
		$data['title'] = __("Licenses");
		$data['page'] = 'admin/inventory/licenses/list';



		$this->load->view('admin/layout_page', html_escape($data));
	}


	public function import()
	{
        enforce_permission('licenses-add');
		$data['title'] = __("Import Licenses");
		$data['page'] = 'admin/inventory/licenses/import';






        if($this->input->method() === 'post') {


            $csv = fopen($_FILES['userfile']['tmp_name'],"r");
            

            $count = 0;
            while(! feof($csv)) {
                $line = fgetcsv($csv,0,",");
                

                if($this->input->post('skip_first_line') == '1' && $count == 0) { $count++; continue; }

                $tag = trim($line[0]);
				$name = trim($line[1]);
                $client = trim($line[2]);
                $status = trim($line[3]);
                $category = trim($line[4]);
                $supplier = trim($line[5]);
                $serial_number = trim($line[6]);
                $seats = trim($line[7]);
                


                $client_id = existing_client_or_new($client);
                $category_id = existing_license_category_or_new($category);
                $status_id = existing_status_label_or_new($status);
                $supplier_id = existing_supplier_or_new($supplier);


                $db_data = array(
					'client_id' => $client_id,
					'category_id' => $category_id,
					'status_id' => $status_id,
                    'supplier_id' => $supplier_id,
					'tag' => $tag,
					'name' => $name,
					'serial_number' => $serial_number,
					'seats' => $seats,
					'custom_fields_values' => json_encode([]),
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				
				);
                $db_data = $this->security->xss_clean($db_data);
                $this->db->insert('app_licenses', $db_data);


                $count++;
            }
         
            log_staff('Licenses imported');

            $this->session->set_flashdata('toast-success', __("Import has been executed. Check results in the coresponding table."));
            redirect($_SERVER['HTTP_REFERER']);
        }


		$this->load->view('admin/layout_page', html_escape($data));
	}

	public function add()
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
				redirect($_SERVER['HTTP_REFERER']);
			} else {



				if($this->input->post('status_id') == "0" && $this->input->post('new_status') != '') {
					$status_id = $this->attribute->add_status_label( ['name' => $this->input->post('new_status'), 'color' => $this->input->post('new_status_color') ] );
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
					'client_id' => $this->input->post('client_id'),
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

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$data['title'] = __("Add License");
			$data['modal'] = 'admin/inventory/licenses/add';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function edit($id=0)
	{
        enforce_permission('licenses-edit');

		$data['license'] = $this->license->get($id);
		$data['client'] = $this->client->get($data['license']['client_id']);


		$data['suppliers'] = $this->attribute->get_suppliers();
		$data['license_categories'] = $this->attribute->get_license_categories();
		$data['status_labels'] = $this->attribute->get_status_labels();


		$data['customfields'] = $this->customfield->get_for('Licenses');

		if($this->input->method() === 'post') {

			$this->form_validation->set_rules('name', __('Name'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
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
					'client_id' => $this->input->post('client_id'),
					'category_id' => $category_id,
					'status_id' => $status_id,
					'supplier_id' => $supplier_id,
					'tag' => $this->input->post('tag'),
					'name' => $this->input->post('name'),
					'seats' => $this->input->post('seats'),
					'serial_number' => $this->input->post('serial_number'),
					'custom_fields_values' => json_encode($this->input->post('customfield')),
					'updated_at' => date('Y-m-d H:i:s'),
				);


				$db_data = $this->security->xss_clean($db_data);
				$result = $this->license->edit($db_data, $id);

				if($result) {
                    log_staff('License edited ' . $id);

					$this->session->set_flashdata('toast-success', __("License has been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to update license."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$data['title'] = __("Edit License");
			$data['modal'] = 'admin/inventory/licenses/edit';

    
            $clear_cf = $data['license']['custom_fields_values'];
            $data = html_escape($data);
            $data['license']['custom_fields_values'] = $clear_cf;


			$this->load->view('admin/layout_modal', $data);
		}

	}



	public function view($id=0)
	{
        enforce_permission('licenses-view');

		$data['license'] = $this->license->get($id);

		$data['files'] = $this->license->get_files($id);
		$data['comments'] = $this->license->get_comments($id);


		$data['assigned_assets'] = $this->license->get_assigned_assets($id);

		$data['client'] = $this->client->get($data['license']['client_id']);
		$data['user'] = $this->user->get($data['license']['user_id']);

		$data['customfields'] = $this->customfield->get_for('Licenses');


		$data['title'] = __("View License");
		$data['modal'] = 'admin/inventory/licenses/view';


        $clear_notes = $data['license']['notes'];
        $data = html_escape($data);
        $data['license']['notes'] = purify($clear_notes);


		$this->load->view('admin/layout_modal', $data);


	}




	public function assign_user($id=0)
	{
        enforce_permission('licenses-edit');

		$data['license'] = $this->license->get($id);
		$data['client'] = $this->client->get($data['license']['client_id']);

		$data['customfields'] = $this->customfield->get_for('Licenses');

		$data['users'] = $this->user->get_all();


		if($this->input->method() === 'post') {

			$this->form_validation->set_rules('user_id', __('User'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {

				$user = $this->user->get($_POST['user_id']);

				$db_data = array(
					'user_id' => $this->input->post('user_id'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->license->edit($db_data, $id);

				if($result) {
					log_license_activity($id, "User assigned", $user['name']);
                    log_staff('License user assigned ' . $id);


					$this->session->set_flashdata('toast-success', __("User has been successfully assigned."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to assign user."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$data['title'] = __("Assign User");
			$data['modal'] = 'admin/inventory/licenses/assign_user';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}




	public function release_user($id=0)
	{
        enforce_permission('licenses-edit');

		$data['license'] = $this->license->get($id);
		$data['client'] = $this->client->get($data['license']['client_id']);

		$data['customfields'] = $this->customfield->get_for('Licenses');

		$data['users'] = $this->user->get_all();


		if($this->input->method() === 'post') {

			$this->form_validation->set_rules('user_id', __('User'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {

				$old_user = $this->user->get($data['license']['user_id']);
				$user = $this->user->get($_POST['user_id']);

				$db_data = array(
					'user_id' => $this->input->post('user_id'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->license->edit($db_data, $id);

				if($result) {
					log_license_activity($id, "User released", $old_user['name']);

					if($this->input->post('user_id') != '0') {
						log_license_activity($id, "User assigned", $user['name']);
					}

                    log_staff('License user released ' . $id);

					$this->session->set_flashdata('toast-success', __("User has been successfully assigned."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to assign user."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$data['title'] = __("Release User");
			$data['modal'] = 'admin/inventory/licenses/release_user';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}







	public function assign_asset($id=0)
	{
        enforce_permission('licenses-edit');

		$data['license'] = $this->license->get($id);
		$data['client'] = $this->client->get($data['license']['client_id']);


		$data['assets'] = $this->asset->get_all();


		if($this->input->method() === 'post') {

			$asset = $this->asset->get($_POST['asset_id']);

			$db_data = array(
				'asset_id' => $this->input->post('asset_id'),
				'license_id' => $id,
				'created_at' => date('Y-m-d H:i:s'),
			);

			$db_data = $this->security->xss_clean($db_data);
			$result = $this->license->assign_asset($db_data, $id);

			if($result) {
				log_license_activity($id, "Assigned Asset", $asset['tag']);
				log_asset_activity($this->input->post('asset_id'), "Assigned License", $data['license']['tag']);

                log_staff('License asset assigned ' . $id);


				$this->session->set_flashdata('toast-success', __("Asset has been successfully assigned."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to assign asset."));
			}

			redirect($_SERVER['HTTP_REFERER']);



		} else {
			$data['title'] = __("Assign Asset");
			$data['modal'] = 'admin/inventory/licenses/assign_asset';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}



	public function unassign_asset($id=0)
	{
        enforce_permission('licenses-edit');

		$data['assigned_asset'] = $this->license->get_assigned_asset($id);

		$data['asset'] = $this->asset->get($data['assigned_asset']['asset_id']);
		$data['license'] = $this->license->get($data['assigned_asset']['license_id']);


		if($this->input->method() === 'post') {


			$result = $this->license->unassign_asset($id);

			if($result) {
				log_license_activity($id, "Unassign Asset", $data['asset']['tag']);
				log_asset_activity($data['asset']['id'], "Unassign License", $data['license']['tag']);

                log_staff('License asset unassigned ' . $id);


				$this->session->set_flashdata('toast-success', __("Asset has been successfully unassigned."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to unassign asset."));
			}

			redirect($_SERVER['HTTP_REFERER']);



		} else {
			$data['title'] = __("Unassign Asset");
			$data['modal'] = 'admin/inventory/licenses/unassign_asset';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}


	public function edit_notes($id=0)
	{
        enforce_permission('licenses-edit');

		$data['license'] = $this->license->get($id);

		if($this->input->method() === 'post') {


			$db_data = array(
				'notes' => $this->input->post('notes'),
				'updated_at' => date('Y-m-d H:i:s'),
			);

			$db_data = $this->security->xss_clean($db_data);
			$result = $this->license->edit($db_data, $id);

			if($result) {
                log_staff('License notes edited ' . $id);

				$this->session->set_flashdata('toast-success', __("License notes have been successfully updated."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to update license notes."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			redirect($_SERVER['HTTP_REFERER']);
		}

	}


	public function delete($id=0)
	{
        enforce_permission('licenses-delete');

		$data['license'] = $this->license->get($id);

		if($this->input->method() === 'post') {

			$result = $this->license->delete($id);

			if($result) {
                log_staff('License deleted ' . $id);

				$this->session->set_flashdata('toast-success', __("License has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete license."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			$data['title'] = __("Delete License");
			$data['modal'] = 'admin/inventory/licenses/delete';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}






	public function details($id=0)
	{
        enforce_permission('licenses-view');

		$data['license'] = $this->license->get($id);

		$data['files'] = $this->license->get_files($id);
		$data['comments'] = $this->license->get_comments($id);


		$data['client'] = $this->client->get($data['license']['client_id']);
		$data['user'] = $this->user->get($data['license']['user_id']);
		$data['customfields'] = $this->customfield->get_for('Licenses');
		$data['assigned_assets'] = $this->license->get_assigned_assets($id);

		$data['title'] = __("Manage License") . " - " . $data['license']['name'];
		$data['section'] = 'details';
		$data['page'] = 'admin/inventory/licenses/index';


        $clear_notes = $data['license']['notes'];
        $clear_cf = $data['license']['custom_fields_values'];
        $data = html_escape($data);
        $data['license']['notes'] = purify($clear_notes);
        $data['license']['custom_fields_values'] = $clear_cf;

		$this->load->view('admin/layout_page', $data);
	}




	public function issues($id=0)
	{
        enforce_permission('issues-view');
    
		$data['license'] = $this->license->get($id);


		$data['title'] = __("Manage License") . " - " . $data['license']['name'];
		$data['section'] = 'issues';
		$data['page'] = 'admin/inventory/licenses/index';


		$this->load->view('admin/layout_page', html_escape($data));
	}



	public function tickets($id=0)
	{
        enforce_permission('tickets-view');

		$data['license'] = $this->license->get($id);


		$data['title'] = __("Manage License") . " - " . $data['license']['name'];
		$data['section'] = 'tickets';
		$data['page'] = 'admin/inventory/licenses/index';


		$this->load->view('admin/layout_page', html_escape($data));
	}


	public function notes($id=0)
	{
        enforce_permission('licenses-view');

		$data['license'] = $this->license->get($id);


		$data['title'] = __("Manage License") . " - " . $data['license']['name'];
		$data['section'] = 'notes';
		$data['page'] = 'admin/inventory/licenses/index';

        $clear_notes = $data['license']['notes'];
        $data = html_escape($data);
        $data['license']['notes'] = purify($clear_notes);

		$this->load->view('admin/layout_page', $data);
	}





	public function history($id=0)
	{
        enforce_permission('licenses-view');

		$data['license'] = $this->license->get($id);


		$data['title'] = __("Manage License") . " - " . $data['license']['name'];
		$data['section'] = 'history';
		$data['page'] = 'admin/inventory/licenses/index';


		$this->load->view('admin/layout_page', html_escape($data));
	}











	public function add_comment($id)
	{
        enforce_permission('licenses-edit');

		$data['license'] = $this->license->get($id);

		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('comment', __('Comment'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {

				$db_data = array(
					'license_id' => $id,
					'added_by' => $this->session->staff_id,
					'comment' => $this->input->post('comment'),
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->license->add_comment($db_data);

				if($result) {
                    log_staff('License comment added ' . $result);

					$this->session->set_flashdata('toast-success', __("Comment has been successfully added."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to add comment."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$data['title'] = __("Add Comment");
			$data['modal'] = 'admin/inventory/licenses/add_comment';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function edit_comment($id=0)
	{

        enforce_permission('licenses-edit');
		$data['comment'] = $this->license->get_comment($id);
		$data['license'] = $this->license->get($data['comment']['license_id']);

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
				$result = $this->license->edit_comment($db_data, $id);

				if($result) {
                    log_staff('License comment edited ' . $id);

					$this->session->set_flashdata('toast-success', __("Comment has been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to update comment."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$data['title'] = __("Edit Comment");
			$data['modal'] = 'admin/inventory/licenses/edit_comment';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function delete_comment($id=0)
	{
        enforce_permission('licenses-edit');

		$data['comment'] = $this->license->get_comment($id);
		$data['license'] = $this->license->get($data['comment']['license_id']);

		if($this->input->method() === 'post') {

			$result = $this->license->delete_comment($id);

			if($result) {
                log_staff('License comment deleted ' . $id);

				$this->session->set_flashdata('toast-success', __("Comment has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete comment."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			$data['title'] = __("Delete Comment");
			$data['modal'] = 'admin/inventory/licenses/delete_comment';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}







	public function upload_file($id)
	{
        enforce_permission('licenses-edit');

		$data['license'] = $this->license->get($id);

		if($this->input->method() === 'post') {

			$config['upload_path']                = './filestore/main/licenses/';
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
				'license_id' => $id,
				'added_by' => $this->session->staff_id,
				'file' => $this->upload->data('file_name'),
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
			);

			$db_data = $this->security->xss_clean($db_data);
			$result = $this->license->add_file($db_data);

			if($result) {
                log_staff('License file uploaded ' . $result);

				$this->session->set_flashdata('toast-success', __("File has been successfully uploaded."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to upload file."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			$data['title'] = __("Upload File");
			$data['modal'] = 'admin/inventory/licenses/upload_file';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function delete_file($id=0)
	{
        enforce_permission('licenses-delete');

		$data['file'] = $this->license->get_file($id);
		$data['license'] = $this->license->get($data['file']['license_id']);

		if($this->input->method() === 'post') {

			$result = $this->license->delete_file($id);

			unlink('./filestore/main/licenses/'.$data['file']['file']);

			if($result) {
                log_staff('License file deleted ' . $id);

				$this->session->set_flashdata('toast-success', __("File has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete file."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			$data['title'] = __("Delete File");
			$data['modal'] = 'admin/inventory/licenses/delete_file';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function download_file($id=0)
	{
        enforce_permission('licenses-view');

        log_staff('License file downloaded ' . $id);

		$data['file'] = $this->license->get_file($id);
		$data['license'] = $this->license->get($data['file']['license_id']);


		force_download("./filestore/main/licenses/" . $data['file']['file'], NULL);
	}




	public function add_issue($id=0)
	{
        enforce_permission('issues-add');

		$data['license'] = $this->license->get($id);

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
					'client_id' => $data['license']['client_id'],
					'user_id' => $data['license']['user_id'],
					'license_id' => $id,

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
			$data['modal'] = 'admin/inventory/licenses/add_issue';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}





	public function add_ticket($id=0)
	{

        enforce_permission('tickets-add');

		$data['license'] = $this->license->get($id);

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

					'client_id' => $data['license']['client_id'],
					'asset_id' => 0,
					'license_id' => $id,
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
			$data['modal'] = 'admin/inventory/licenses/add_ticket';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}








}
