<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Documentation extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('admin/documentation_model', 'documentation');
		$this->load->model('admin/setting_model', 'setting');
		$this->load->library('datatables');
	}


	public function json_all() {
        enforce_permission('documentation-view');

		$this->datatables
			->select('id, name, status')
			->from('app_docs_spaces')
			->edit_column_if('status', '<span class="label label-inverse-danger">'.__("Draft").'</span>', '', 'Draft')
			->edit_column_if('status', '<span class="label label-inverse-success">'.__("Published").'</span>', '', 'Published')
			->add_column(
				'actions',
				'<div class="btn-group" role="group">'.
					'<a href="'.base_url().'admin/content/documentation/manage/$1" data-toggle="tooltip" title="'.__("Manage space").'" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-book"></i></a>'.
					'<button data-modal="admin/content/documentation/edit_space/$1" data-toggle="tooltip" title="'.__("Edit space").'" type="button" class="btn btn-success btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-edit"></i></button>'.
					'<button data-modal="admin/content/documentation/delete_space/$1" data-toggle="tooltip" title="'.__("Delete space").'" type="button" class="btn btn-danger btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-trash"></i></button>'.
				'</div>',
				'id'
			);

		echo $this->datatables->generate();
	}

	public function index()
	{
        enforce_permission('documentation-view');

		$data['title'] = __("Documentation");
		$data['page'] = 'admin/content/documentation/list';



		$this->load->view('admin/layout_page', html_escape($data));
	}

	public function manage()
	{
        enforce_permission('documentation-edit');

		$data['title'] = __("Manage Documentation");
		$data['page'] = 'admin/content/documentation/manage';

		$space_id =  $this->uri->segment(5);
		$data['space'] = $this->documentation->get_space($space_id);
		$data['pages'] = $this->documentation->get_pages($space_id);

		if(empty($data['pages'])) {
			$data['selected_page'] = [];
			$data['selected_page_id'] = 0;
		} else {
			$page_id =  $this->uri->segment(6);
			if(empty($page_id)) {
				$data['selected_page'] = $data['pages'][0];
				$data['selected_page_id'] = $data['selected_page']['id'];
			} else {
				$data['selected_page'] = $this->documentation->get_page($page_id);
				$data['selected_page_id'] = $data['selected_page']['id'];
			}
		}


        $clear_notes = $data['selected_page']['content'];
        $data = html_escape($data);
        $data['selected_page']['content'] = purify($clear_notes);


		$this->load->view('admin/layout_page', $data);
	}

	public function add_space()
	{
        enforce_permission('documentation-edit');


		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('name', __('Name'), 'trim|required');
			$this->form_validation->set_rules('status', __('Status'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect(base_url('admin/content/documentation'));
			} else {

				$db_data = array(
					'name' => $this->input->post('name'),
					'status' => $this->input->post('status'),
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->documentation->add_space($db_data);

				if($result) {
                    log_staff('Documentation space added ' . $result);

					$this->session->set_flashdata('toast-success', __("Space has been successfully added."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to add space."));
				}

				redirect(base_url('admin/content/documentation'));

			}

		} else {
			$data['title'] = __("Add Space");
			$data['modal'] = 'admin/content/documentation/add_space';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function edit_space($id=0)
	{
        enforce_permission('documentation-edit');

		$data['space'] = $this->documentation->get_space($id);

		if($this->input->method() === 'post') {

			$this->form_validation->set_rules('name', __('Name'), 'trim|required');
			$this->form_validation->set_rules('status', __('Status'), 'trim|required');


			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect(base_url('admin/content/documentation'));
			} else {

				$db_data = array(
					'name' => $this->input->post('name'),
					'status' => $this->input->post('status'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->documentation->edit_space($db_data, $id);

				if($result) {
                    log_staff('Documentation space edited ' . $id);

					$this->session->set_flashdata('toast-success', __("Space has been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to update user."));
				}

				redirect(base_url('admin/content/documentation'));

			}

		} else {
			$data['title'] = __("Edit Space");
			$data['modal'] = 'admin/content/documentation/edit_space';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function delete_space($id=0)
	{
        enforce_permission('documentation-edit');

		$data['space'] = $this->documentation->get_space($id);

		if($this->input->method() === 'post') {

			$result = $this->documentation->delete_space($id);

			if($result) {
                log_staff('Documentation space deleted ' . $id);

				$this->session->set_flashdata('toast-success', __("Space has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete space."));
			}

			redirect(base_url('admin/content/documentation'));

		} else {
			$data['title'] = __("Delete Space");
			$data['modal'] = 'admin/content/documentation/delete_space';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}





	public function add_page($id=0)
	{
        enforce_permission('documentation-edit');

		$data['space'] = $this->documentation->get_space($id);

		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('name', __('Name'), 'trim|required');
			$this->form_validation->set_rules('status', __('Status'), 'trim|required');
			$this->form_validation->set_rules('parent_id', __('Parent page'), 'trim|required');
			$this->form_validation->set_rules('sort', __('Sort order'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect(base_url('admin/content/documentation/manage/'.$data['space']['id']));
			} else {

				$db_data = array(
					'space_id' => $data['space']['id'],
					'parent_id' => $this->input->post('parent_id'),
					'name' => $this->input->post('name'),
					'content' => $this->input->post('content'),
					'status' => $this->input->post('status'),
					'sort' => $this->input->post('sort'),
					'folder' => $this->input->post('folder'),
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->documentation->add_page($db_data);

				if($result != 0) {
                    log_staff('Documentation page added ' . $result);

					$this->session->set_flashdata('toast-success', __("Page has been successfully added."));
					redirect(base_url('admin/content/documentation/manage/'.$data['space']['id'].'/'.$result));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to add page."));
					redirect(base_url('admin/content/documentation/manage/'.$data['space']['id']));
				}

			}

		} else {
			$data['title'] = __("Add Page");
			$data['modal'] = 'admin/content/documentation/add_page';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function edit_page($id=0)
	{
        enforce_permission('documentation-edit');

		$data['page'] = $this->documentation->get_page($id);
		$data['space'] = $this->documentation->get_space($data['page']['space_id']);

		if($this->input->method() === 'post') {

			$this->form_validation->set_rules('name', __('Name'), 'trim|required');
			$this->form_validation->set_rules('status', __('Status'), 'trim|required');
			$this->form_validation->set_rules('parent_id', __('Parent page'), 'trim|required');
			$this->form_validation->set_rules('sort', __('Sort order'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect(base_url('admin/content/documentation/manage/'.$data['space']['id'].'/'.$data['page']['id']));
			} else {

				$db_data = array(
					'parent_id' => $this->input->post('parent_id'),
					'name' => $this->input->post('name'),
					'content' => $this->input->post('content'),
					'status' => $this->input->post('status'),
					'sort' => $this->input->post('sort'),
					'folder' => $this->input->post('folder'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->documentation->edit_page($db_data, $id);

				if($result) {
                    log_staff('Documentation page edited ' . $id);

					$this->session->set_flashdata('toast-success', __("Page has been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to update page."));
				}

				redirect(base_url('admin/content/documentation/manage/'.$data['space']['id'].'/'.$data['page']['id']));

			}

		} else {
			$this->session->set_flashdata('toast-error', __("Not allowed!"));
			redirect($_SERVER['HTTP_REFERER']);
		}

	}

	public function delete_page($id=0)
	{
        enforce_permission('documentation-edit');
        
		$data['page'] = $this->documentation->get_page($id);
		$data['space'] = $this->documentation->get_space($data['page']['space_id']);

		if($this->input->method() === 'post') {

			$result = $this->documentation->delete_page($id);

			if($result) {
                log_staff('Documentation page deleted ' . $id);

				$this->session->set_flashdata('toast-success', __("Page has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete page."));
			}

			redirect(base_url('admin/content/documentation/manage/'.$data['space']['id']));

		} else {
			$data['title'] = __("Delete Space");
			$data['modal'] = 'admin/content/documentation/delete_page';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}




}
