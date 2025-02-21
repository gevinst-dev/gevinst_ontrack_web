<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Credentials extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('admin/credential_model', 'credential');
		$this->load->model('admin/asset_model', 'asset');
		$this->load->model('admin/client_model', 'client');
		$this->load->model('admin/project_model', 'project');
		$this->load->model('admin/setting_model', 'setting');
		$this->load->library('datatables');
	}


	public function json_all() {
        enforce_permission('credentials-view');

		$this->datatables
			->select('app_credentials.id, app_credentials.type, app_credentials.username')
			->from('app_credentials')


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

	public function index()
	{
        enforce_permission('credentials-view');
		$data['title'] = __("Credentials");
		$data['page'] = 'admin/inventory/credentials/list';



		$this->load->view('admin/layout_page', html_escape($data));
	}

	public function import()
	{
        enforce_permission('credentials-add');
		$data['title'] = __("Import Credentials");
		$data['page'] = 'admin/inventory/credentials/import';



        if($this->input->method() === 'post') {


            $csv = fopen($_FILES['userfile']['tmp_name'],"r");
            

            $count = 0;
            while(! feof($csv)) {
                $line = fgetcsv($csv,0,",");
                

                if($this->input->post('skip_first_line') == '1' && $count == 0) { $count++; continue; }

                
            
                $type = trim($line[0]);
				$username = trim($line[1]);
                $password = trim($line[2]);
                $client = trim($line[3]);
    
                

                $client_id = existing_client_or_new($client);


                $db_data = array(

                    'client_id' => $client_id,
					'asset_id' => 0,
					'project_id' => 0,
					'type' => $type,
					'username' => $username,
					'pswd' => $this->encryption->encrypt($password),

					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				
				);
                $db_data = $this->security->xss_clean($db_data);
                $this->db->insert('app_credentials', $db_data);


                $count++;
            }

            log_staff('Credentials imported');

            $this->session->set_flashdata('toast-success', __("Import has been executed. Check results in the coresponding table."));
            redirect($_SERVER['HTTP_REFERER']);

        }



		$this->load->view('admin/layout_page', html_escape($data));
	}


	public function add()
	{
        enforce_permission('credentials-add');

		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('type', __('Type'), 'trim|required');


			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {

				$db_data = array(
					'client_id' => $this->input->post('client_id'),
					'asset_id' => $this->input->post('asset_id'),
					'project_id' => $this->input->post('project_id'),
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
			$data['modal'] = 'admin/inventory/credentials/add';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function edit($id=0)
	{
        enforce_permission('credentials-edit');

		$data['credential'] = $this->credential->get($id);
		$data['client'] = $this->client->get($data['credential']['client_id']);
		$data['asset'] = $this->asset->get($data['credential']['asset_id']);
		$data['project'] = $this->project->get($data['credential']['project_id']);



		if($this->input->method() === 'post') {

			$this->form_validation->set_rules('type', __('Type'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {

				$db_data = array(
					'client_id' => $this->input->post('client_id'),
					'asset_id' => $this->input->post('asset_id'),
					'project_id' => $this->input->post('project_id'),
					'type' => $this->input->post('type'),
					'username' => $this->input->post('username'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				if($this->input->post('pswd') != "") {
					$db_data['pswd'] = $this->encryption->encrypt($this->input->post('pswd'));
				}

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->credential->edit($db_data, $id);

				if($result) {
                    log_staff('Credential edited ' . $id);

					$this->session->set_flashdata('toast-success', __("Credential has been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to update credential."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$data['title'] = __("Edit Credential");
			$data['modal'] = 'admin/inventory/credentials/edit';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function delete($id=0)
	{
        enforce_permission('credentials-delete');

		$data['credential'] = $this->credential->get($id);

		if($this->input->method() === 'post') {

			$result = $this->credential->delete($id);

			if($result) {
                log_staff('Credential deleted ' . $id);

				$this->session->set_flashdata('toast-success', __("Credential has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete credential."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			$data['title'] = __("Delete Credential");
			$data['modal'] = 'admin/inventory/credentials/delete';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}



	public function view($id=0)
	{
        enforce_permission('credentials-view');

        log_staff('Credential viewed ' . $id);

        
		$data['credential'] = $this->credential->get($id);
		$data['client'] = $this->client->get($data['credential']['client_id']);
		$data['asset'] = $this->asset->get($data['credential']['asset_id']);
		$data['project'] = $this->project->get($data['credential']['project_id']);

		$data['title'] = __("View Credential");
		$data['modal'] = 'admin/inventory/credentials/view';

		$this->load->view('admin/layout_modal', html_escape($data));


	}






}
