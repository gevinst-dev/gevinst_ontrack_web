<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Domains extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('admin/domain_model', 'domain');

		$this->load->model('admin/staff_model', 'staff');
		$this->load->model('admin/client_model', 'client');
		$this->load->model('admin/setting_model', 'setting');
		$this->load->library('datatables');
	}



	public function json_all() {
        enforce_permission('domains-view');

		$this->datatables
			->select('app_domains.id, app_domains.domain, app_domains.exp_date')
			->from('app_domains')


			->join('app_clients', 'app_domains.client_id = app_clients.id', 'LEFT')
			->select('app_clients.name as client_name')


			->add_column(
				'actions',
				'<div class="btn-group" role="group">'.
                    '<button data-modal="admin/inventory/domains/view/$1" data-toggle="tooltip" title="'.__("View Domain").'" type="button" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-eye"></i></button>'.
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



	public function index()
	{
        enforce_permission('domains-view');

		$data['title'] = __("Domains");
		$data['page'] = 'admin/inventory/domains/list';

		$this->load->view('admin/layout_page', html_escape($data));
	}


	public function import()
	{
        enforce_permission('domains-add');
		$data['title'] = __("Import Domains");
		$data['page'] = 'admin/inventory/domains/import';




        if($this->input->method() === 'post') {


            $csv = fopen($_FILES['userfile']['tmp_name'],"r");
            

            $count = 0;
            while(! feof($csv)) {
                $line = fgetcsv($csv,0,",");
                

                if($this->input->post('skip_first_line') == '1' && $count == 0) { $count++; continue; }

                

                $domain = trim($line[0]);
				$client = trim($line[1]);
                $expiry_date = trim($line[2]);
                $notify_30 = trim($line[3]);
                $notify_14 = trim($line[4]);
                $notify_7 = trim($line[5]);
                $notify_3 = trim($line[6]);
                $notify_0 = trim($line[7]);
                $notify_client = trim($line[8]);
                

                $client_id = existing_client_or_new($client);


                $db_data = array(
                    'added_by' => 0,
					'notify' => serialize([]),
					'client_id' => $client_id,
					'domain' => $domain,
					'exp_date' => $expiry_date,
					'notify_30' => $notify_30,
					'notify_14' => $notify_14,
					'notify_7' => $notify_7,
					'notify_3' => $notify_3,
					'notify_0' => $notify_0,
					'notify_client' => $notify_client,

					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				
				);
                $db_data = $this->security->xss_clean($db_data);
                $this->db->insert('app_domains', $db_data);


                $count++;
            }

            log_staff('Domains imported');

            $this->session->set_flashdata('toast-success', __("Import has been executed. Check results in the coresponding table."));
            redirect($_SERVER['HTTP_REFERER']);
            
        }


		$this->load->view('admin/layout_page', html_escape($data));
	}


	public function add()
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
					'client_id' => $this->input->post('client_id'),

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
			$data['modal'] = 'admin/inventory/domains/add';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}



	public function view($id=0)
	{
        enforce_permission('domains-view');

		$data['domain'] = $this->domain->get($id);
		$data['selected_notify'] = unserialize($data['domain']['notify']);
		$data['staff'] = $this->staff->get_all_active();

		$data['client'] = $this->client->get($data['domain']['client_id']);

    
        $data['title'] = __("View Domain");
        $data['modal'] = 'admin/inventory/domains/view';

        $this->load->view('admin/layout_modal', html_escape($data));
    

	}

	public function edit($id=0)
	{
        enforce_permission('domains-edit');

		$data['domain'] = $this->domain->get($id);
		$data['selected_notify'] = unserialize($data['domain']['notify']);
		$data['staff'] = $this->staff->get_all_active();

		$data['client'] = $this->client->get($data['domain']['client_id']);

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
					'client_id' => $this->input->post('client_id'),

					'domain' => $this->input->post('domain'),
					'exp_date' => date_to_db($this->input->post('exp_date')),

					'notify_30' => $this->input->post('notify_30'),
					'notify_14' => $this->input->post('notify_14'),
					'notify_7' => $this->input->post('notify_7'),
					'notify_3' => $this->input->post('notify_3'),
					'notify_0' => $this->input->post('notify_0'),
					'notify_client' => $this->input->post('notify_client'),


					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->domain->edit($db_data, $id);

				if($result) {
                    log_staff('Domain edited ' . $id);

					$this->session->set_flashdata('toast-success', __("Domain has been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to update domain."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$data['title'] = __("Edit Domain");
			$data['modal'] = 'admin/inventory/domains/edit';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}



	public function delete($id=0)
	{
        enforce_permission('domains-delete');

		$data['domain'] = $this->domain->get($id);

		if($this->input->method() === 'post') {

			$result = $this->domain->delete($id);

			if($result) {
                log_staff('Domain deleted ' . $id);

				$this->session->set_flashdata('toast-success', __("Domain has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete domain."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			$data['title'] = __("Delete Domain");
			$data['modal'] = 'admin/inventory/domains/delete';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}



}
