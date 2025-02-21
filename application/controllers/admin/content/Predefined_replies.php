<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Predefined_replies extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('admin/predefined_reply_model', 'predefined_reply');
		$this->load->model('admin/setting_model', 'setting');
		$this->load->library('datatables');
	}


	public function json_all() {
        enforce_permission('pr-view');

		$this->datatables
			->select('id, name')
			->from('app_predefined_replies')
			->add_column(
				'actions',
				'<div class="btn-group" role="group">'.
					'<button data-modal="admin/content/predefined_replies/edit/$1" data-toggle="tooltip" title="'.__("Edit predefined reply").'" type="button" class="btn btn-success btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-edit"></i></button>'.
					'<button data-modal="admin/content/predefined_replies/delete/$1" data-toggle="tooltip" title="'.__("Delete predefined reply").'" type="button" class="btn btn-danger btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-trash"></i></button>'.
				'</div>',
				'id'
			);

		echo $this->datatables->generate();
	}

	public function index()
	{
        enforce_permission('pr-view');

		$data['title'] = __("Predefined Replies");
		$data['page'] = 'admin/content/predefined_replies/list';



		$this->load->view('admin/layout_page', html_escape($data));
	}


	public function add()
	{

        enforce_permission('pr-add');

		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('name', __('Name'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect(base_url('admin/content/predefined_replies'));
			} else {

				$db_data = array(
					'name' => $this->input->post('name'),
					'content' => $this->input->post('content'),
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->predefined_reply->add($db_data);

				if($result) {
                    log_staff('Predefined Reply added ' . $result);

					$this->session->set_flashdata('toast-success', __("Predefined reply has been successfully added."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to add predefined reply."));
				}

				redirect(base_url('admin/content/predefined_replies'));

			}

		} else {
			$data['title'] = __("Add Predefined Reply");
			$data['modal'] = 'admin/content/predefined_replies/add';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function edit($id=0)
	{
        enforce_permission('pr-edit');

		$data['predefined_reply'] = $this->predefined_reply->get($id);

		if($this->input->method() === 'post') {

			$this->form_validation->set_rules('name', __('Name'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect(base_url('admin/content/predefined_replies'));
			} else {

				$db_data = array(
					'name' => $this->input->post('name'),
					'content' => $this->input->post('content'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->predefined_reply->edit($db_data, $id);

				if($result) {
                    log_staff('Predefined Reply edited ' . $id);

					$this->session->set_flashdata('toast-success', __("Predefined reply has been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to update predefined reply."));
				}

				redirect(base_url('admin/content/predefined_replies'));

			}

		} else {
			$data['title'] = __("Edit Predefined Reply");
			$data['modal'] = 'admin/content/predefined_replies/edit';

            $clear_notes = $data['predefined_reply']['content'];
            $data = html_escape($data);
            $data['predefined_reply']['content'] = purify($clear_notes);


			$this->load->view('admin/layout_modal', $data);
		}

	}

	public function delete($id=0)
	{
        enforce_permission('pr-delete');

		$data['predefined_reply'] = $this->predefined_reply->get($id);

		if($this->input->method() === 'post') {

			$result = $this->predefined_reply->delete($id);

			if($result) {
                log_staff('Predefined Reply deleted ' . $id);

				$this->session->set_flashdata('toast-success', __("Predefined reply has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete predefined reply."));
			}

			redirect(base_url('admin/content/documentation'));

		} else {
			$data['title'] = __("Delete Predefined Reply");
			$data['modal'] = 'admin/content/predefined_replies/delete';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}





}
