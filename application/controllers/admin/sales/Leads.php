<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leads extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('admin/lead_model', 'lead');
		$this->load->model('admin/staff_model', 'staff');
		$this->load->library('datatables');
	}


	public function json_all() {
        enforce_permission('leads-view');

		$this->datatables
			->select('app_clients.id, app_clients.name, app_clients.company_taxid, app_clients.email, app_clients.phone, app_clients.city')
			->where('type', 'Lead')
			->from('app_clients')



			->edit_column('name', '<a href="'.base_url('admin/sales/leads/details/').'$1">$2</a>', 'id,name')
			->add_column(
				'actions',
				'<div class="btn-group" role="group">'.
					'<a href="'.base_url('admin/sales/leads/details/').'$1" data-toggle="tooltip" title="'.__("View Lead").'" type="button" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-eye"></i></a>'.
					'<button data-modal="admin/sales/leads/convert/$1" data-toggle="tooltip" title="'.__("Convert to Client").'" type="button" class="btn btn-inverse btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-bullseye"></i></button>'.
					'<button data-modal="admin/sales/leads/delete/$1" data-toggle="tooltip" title="'.__("Delete Lead").'" type="button" class="btn btn-danger btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-trash"></i></button>'.
				'</div>',
				'id'
			);

		echo $this->datatables->generate('json');

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
                            '<a href="'.base_url('admin/sales/proposals/pdfoffer/view/').'$1" target="_blank" class="dropdown-item"><i class="fas fa-fw fa-file-pdf"></i> '.__("View PDF").'</a>'.
                            '<a href="'.base_url('admin/sales/proposals/pdfoffer/download/').'$1"  class="dropdown-item"><i class="fas fa-fw fa-file-pdf"></i> '.__("Download PDF").'</a>'.

                            '<a href="#" data-modal="admin/sales/invoices/send_email/$1" class="dropdown-item"><i class="fas fa-fw fa-envelope"></i> '.__("Send Email").'</a>'.


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


	public function index()
	{
        enforce_permission('leads-view');

		$data['title'] = __("Leads");
		$data['page'] = 'admin/sales/leads/list';

		$this->load->view('admin/layout_page', html_escape($data));
	}


	public function add()
	{
        enforce_permission('leads-add');
		$data['staff'] = $this->staff->get_all();

		if($this->input->method() === 'post') {


            $db_data = array(
                'type' => 'Lead',
                'name' => $this->input->post('name'),
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

                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            );

            $db_data = $this->security->xss_clean($db_data);
            $result = $this->lead->add($db_data);



            if($result) {
                log_staff('Lead added ' . $result);

                $this->session->set_flashdata('toast-success', __("Lead has been successfully added."));
            } else {
                $this->session->set_flashdata('toast-error', __("Unable to add lead."));
            }

            redirect($_SERVER['HTTP_REFERER']);



		} else {
			$data['title'] = __("Add Lead");
			$data['modal'] = 'admin/sales/leads/add';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}



	public function edit($id=0)
	{
        enforce_permission('leads-edit');

		$data['staff'] = $this->staff->get_all();
		$data['lead'] = $this->lead->get($id);

		if($this->input->method() === 'post') {

			$this->form_validation->set_rules('name', __('Name'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {

				$db_data = array(
					'name' => $this->input->post('name'),
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
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->lead->edit($db_data, $id);

				if($result) {
                    log_staff('Lead edited ' . $id);

					$this->session->set_flashdata('toast-success', __("Lead has been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to update lead."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			redirect($_SERVER['HTTP_REFERER']);
		}

	}


	public function edit_notes($id=0)
	{
        enforce_permission('leads-edit');

		$data['lead'] = $this->lead->get($id);

		if($this->input->method() === 'post') {

			$db_data = array(
				'notes' => $this->input->post('notes'),
				'updated_at' => date('Y-m-d H:i:s'),
			);

			$db_data = $this->security->xss_clean($db_data);
			$result = $this->lead->edit($db_data, $id);

			if($result) {
                log_staff('Lead notes edited ' . $id);

				$this->session->set_flashdata('toast-success', __("Lead has been successfully updated."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to update lead."));
			}

		}

		redirect($_SERVER['HTTP_REFERER']);
	}


	public function convert($id=0)
	{
        enforce_permission('leads-edit');

		$data['lead'] = $this->lead->get($id);

		if($this->input->method() === 'post') {

			$db_data = array(
				'type' => 'Client',
				'updated_at' => date('Y-m-d H:i:s'),
			);

			$db_data = $this->security->xss_clean($db_data);
			$result = $this->lead->edit($db_data, $id);

			if($result) {
                log_staff('Lead converted to client ' . $id);

				$this->session->set_flashdata('toast-success', __("Lead has been successfully converted to client."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to convert lead."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			$data['title'] = __("Convert Lead");
			$data['modal'] = 'admin/sales/leads/convert';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}


	public function delete($id=0)
	{
        enforce_permission('leads-delete');

		$data['lead'] = $this->lead->get($id);

		if($this->input->method() === 'post') {

			$result = $this->lead->delete($id);

			if($result) {
                log_staff('Lead deleted ' . $id);

				$this->session->set_flashdata('toast-success', __("Lead has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete lead."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			$data['title'] = __("Delete Lead");
			$data['modal'] = 'admin/sales/leads/delete';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function details($id=0)
	{
        enforce_permission('leads-view');

		$data['lead'] = $this->lead->get($id);
		$data['files'] = $this->lead->get_files($id);
		$data['addresses'] = $this->lead->get_addresses($id);
		$data['comments'] = $this->lead->get_comments($id);

		$data['staff'] = $this->staff->get_all();

		$data['title'] = __("Manage Lead");
		$data['section'] = 'details';
		$data['page'] = 'admin/sales/leads/index';


		$this->load->view('admin/layout_page', html_escape($data));
	}


	public function proposals($id=0)
	{
        enforce_permission('proposals-view');

		$data['lead'] = $this->lead->get($id);

		$data['title'] = __("Manage Lead");
		$data['section'] = 'proposals';
		$data['page'] = 'admin/sales/leads/index';

		$this->load->view('admin/layout_page', html_escape($data));
	}

	public function notes($id=0)
	{
        enforce_permission('leads-view');

		$data['lead'] = $this->lead->get($id);

		$data['title'] = __("Manage Lead");
		$data['section'] = 'notes';
		$data['page'] = 'admin/sales/leads/index';

		$this->load->view('admin/layout_page', html_escape($data));
	}






	public function upload_file($id)
	{
        enforce_permission('leads-edit');

		$data['lead'] = $this->lead->get($id);

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
			$result = $this->lead->add_file($db_data);

			if($result) {
                log_staff('Lead file uploaded ' . $result);

				$this->session->set_flashdata('toast-success', __("File has been successfully uploaded."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to upload file."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			$data['title'] = __("Upload File");
			$data['modal'] = 'admin/sales/leads/upload_file';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function delete_file($id=0)
	{
        enforce_permission('leads-delete');

		$data['file'] = $this->lead->get_file($id);
		$data['lead'] = $this->lead->get($data['file']['client_id']);

		if($this->input->method() === 'post') {

			$result = $this->lead->delete_file($id);

			unlink('./filestore/main/clients/'.$data['file']['file']);

			if($result) {
                log_staff('Lead file deleted ' . $id);

				$this->session->set_flashdata('toast-success', __("File has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete file."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			$data['title'] = __("Delete File");
			$data['modal'] = 'admin/sales/leads/delete_file';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function download_file($id=0)
	{
        enforce_permission('leads-view');


        log_staff('Lead file downloaded ' . $id);

		$data['file'] = $this->lead->get_file($id);
		$data['lead'] = $this->lead->get($data['file']['client_id']);


		force_download("./filestore/main/clients/" . $data['file']['file'], NULL);
	}








	public function add_address($id)
	{
		$data['lead'] = $this->lead->get($id);

		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('name', __('Address name'), 'trim|required');
			$this->form_validation->set_rules('address', __('Address'), 'trim|required');
			$this->form_validation->set_rules('city', __('City'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {

				$db_data = array(
					'client_id' => $id,
					'name' => $this->input->post('name'),
					'address' => $this->input->post('address'),
					'city' => $this->input->post('city'),
					'state' => $this->input->post('state'),
					'zip_code' => $this->input->post('zip_code'),
					'country' => $this->input->post('country'),
					'phone' => $this->input->post('phone'),
					'notes' => $this->input->post('notes'),
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->lead->add_address($db_data);

				if($result) {
                    log_staff('Lead address added ' . $result);

					$this->session->set_flashdata('toast-success', __("Address has been successfully added."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to add address."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$data['title'] = __("Add Address");
			$data['modal'] = 'admin/sales/leads/add_address';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function edit_address($id=0)
	{

		$data['address'] = $this->lead->get_address($id);
		$data['lead'] = $this->lead->get($data['address']['client_id']);

		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('name', __('Address name'), 'trim|required');
			$this->form_validation->set_rules('address', __('Address'), 'trim|required');
			$this->form_validation->set_rules('city', __('City'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {

				$db_data = array(
					'name' => $this->input->post('name'),
					'address' => $this->input->post('address'),
					'city' => $this->input->post('city'),
					'state' => $this->input->post('state'),
					'zip_code' => $this->input->post('zip_code'),
					'country' => $this->input->post('country'),
					'phone' => $this->input->post('phone'),
					'notes' => $this->input->post('notes'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->lead->edit_address($db_data, $id);

				if($result) {
                    log_staff('Lead address edited ' . $id);

					$this->session->set_flashdata('toast-success', __("Address has been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to update address."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$data['title'] = __("Edit Address");
			$data['modal'] = 'admin/sales/leads/edit_address';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function delete_address($id=0)
	{
		$data['address'] = $this->lead->get_address($id);
		$data['lead'] = $this->lead->get($data['address']['client_id']);

		if($this->input->method() === 'post') {

			$result = $this->lead->delete_address($id);

			if($result) {
                log_staff('Lead address deleted ' . $id);

				$this->session->set_flashdata('toast-success', __("Address has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete address."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			$data['title'] = __("Delete Address");
			$data['modal'] = 'admin/sales/leads/delete_address';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}







	public function add_comment($id)
	{
        enforce_permission('leads-edit');

		$data['lead'] = $this->lead->get($id);

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
				$result = $this->lead->add_comment($db_data);

				if($result) {
                    log_staff('Lead comment added ' . $result);

					$this->session->set_flashdata('toast-success', __("Comment has been successfully added."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to add comment."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$data['title'] = __("Add Comment");
			$data['modal'] = 'admin/sales/leads/add_comment';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function edit_comment($id=0)
	{
        enforce_permission('leads-edit');
		$data['comment'] = $this->lead->get_comment($id);
		$data['lead'] = $this->lead->get($data['comment']['client_id']);

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
				$result = $this->lead->edit_comment($db_data, $id);

				if($result) {
                    log_staff('Lead comment edited ' . $id);

					$this->session->set_flashdata('toast-success', __("Comment has been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to update comment."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$data['title'] = __("Edit Comment");
			$data['modal'] = 'admin/sales/leads/edit_comment';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function delete_comment($id=0)
	{
        enforce_permission('leads-delete');

		$data['comment'] = $this->lead->get_comment($id);
		$data['lead'] = $this->lead->get($data['comment']['client_id']);

		if($this->input->method() === 'post') {

			$result = $this->lead->delete_comment($id);

			if($result) {
                log_staff('Lead comment deleted ' . $id);

				$this->session->set_flashdata('toast-success', __("Comment has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete comment."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			$data['title'] = __("Delete Comment");
			$data['modal'] = 'admin/sales/leads/delete_comment';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}




}
