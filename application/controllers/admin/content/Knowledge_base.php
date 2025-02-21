<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Knowledge_base extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('admin/knowledge_base_model', 'knowledge_base');
		$this->load->model('admin/setting_model', 'setting');
		$this->load->library('datatables');
	}


	public function json_all_articles() {
        enforce_permission('kb-view');

		$this->datatables
			->select('app_kb_articles.id, app_kb_articles.name, app_kb_articles.access, app_kb_articles.status')
			->from('app_kb_articles')

			->join('app_kb_categories', 'app_kb_articles.category_id = app_kb_categories.id', 'LEFT')
			->select('app_kb_categories.name as category_name')

			->edit_column_if('access', __("Public"), '', 'Public')
			->edit_column_if('access', __("Users"), '', 'Users')
			->edit_column_if('access', __("Staff"), '', 'Staff')

			->edit_column_if('status', '<span class="label label-inverse-danger">'.__("Draft").'</span>', '', 'Draft')
			->edit_column_if('status', '<span class="label label-inverse-success">'.__("Published").'</span>', '', 'Published')

			->add_column(
				'actions',
				'<div class="btn-group" role="group">'.
					'<button data-modal="admin/content/knowledge_base/edit_article/$1" data-toggle="tooltip" title="'.__("Edit article").'" type="button" class="btn btn-success btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-edit"></i></button>'.
					'<button data-modal="admin/content/knowledge_base/delete_article/$1" data-toggle="tooltip" title="'.__("Delete article").'" type="button" class="btn btn-danger btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-trash"></i></button>'.
				'</div>',
				'id'
			);

		echo $this->datatables->generate();
	}

	public function json_all_categories() {
        enforce_permission('kb-view');

		$this->datatables
			->select('id, name, access, status')
			->from('app_kb_categories')

			->edit_column_if('access', __("Public"), '', 'Public')
			->edit_column_if('access', __("Users"), '', 'Users')
			->edit_column_if('access', __("Staff"), '', 'Staff')

			->edit_column_if('status', '<span class="label label-inverse-danger">'.__("Draft").'</span>', '', 'Draft')
			->edit_column_if('status', '<span class="label label-inverse-success">'.__("Published").'</span>', '', 'Published')

			->add_column(
				'actions',
				'<div class="btn-group" role="group">'.
					'<button data-modal="admin/content/knowledge_base/edit_category/$1" data-toggle="tooltip" title="'.__("Edit category").'" type="button" class="btn btn-success btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-edit"></i></button>'.
					'<button data-modal="admin/content/knowledge_base/delete_category/$1" data-toggle="tooltip" title="'.__("Delete category").'" type="button" class="btn btn-danger btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-trash"></i></button>'.
				'</div>',
				'id'
			);

		echo $this->datatables->generate();
	}

	public function index()
	{
		redirect(base_url('admin/content/knowledge_base/articles'));
	}

	public function articles()
	{
        enforce_permission('kb-view');

		$data['title'] = __("Knowledge Base Articles");
		$data['page'] = 'admin/content/knowledge_base/articles';

		$this->load->view('admin/layout_page', html_escape($data));
	}

	public function categories()
	{
        enforce_permission('kb-view');

		$data['title'] = __("Knowledge Base Categories");
		$data['page'] = 'admin/content/knowledge_base/categories';

		$this->load->view('admin/layout_page', html_escape($data));
	}


	public function add_category()
	{

        enforce_permission('kb-add');
		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('name', __('Name'), 'trim|required');
			$this->form_validation->set_rules('status', __('Status'), 'trim|required');
			$this->form_validation->set_rules('access', __('Access Level'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect(base_url('admin/content/knowledge_base/categories'));
			} else {

				$db_data = array(
					'name' => $this->input->post('name'),
					'description' => $this->input->post('description'),
					'access' => $this->input->post('access'),
					'status' => $this->input->post('status'),
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$config['upload_path']                = './filestore/public/';
				$config['allowed_types']              = 'gif|jpg|png|jpeg';
				$config['file_ext_tolower']           = TRUE;
				$config['max_filename_increment']     = 1000;
				$this->load->library('upload', $config);

				if(!empty($_FILES['userfile']['name'])) {
					if(!$this->upload->do_upload('userfile')) { $this->session->set_flashdata('toast-error', __("Error uploading! Check file type or size.")); redirect($_SERVER['HTTP_REFERER']); }
					$db_data['image'] = $this->upload->data('file_name');
				}

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->knowledge_base->add_category($db_data);

				if($result) {
                    log_staff('Knowledge Base category added ' . $result);

					$this->session->set_flashdata('toast-success', __("Category has been successfully added."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to add category."));
				}

				redirect(base_url('admin/content/knowledge_base/categories'));

			}

		} else {
			$data['title'] = __("Add Knowledge Base Category");
			$data['modal'] = 'admin/content/knowledge_base/add_category';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function edit_category($id=0)
	{
        enforce_permission('kb-edit');

		$data['category'] = $this->knowledge_base->get_category($id);

		if($this->input->method() === 'post') {

			$this->form_validation->set_rules('name', __('Name'), 'trim|required');
			$this->form_validation->set_rules('status', __('Status'), 'trim|required');
			$this->form_validation->set_rules('access', __('Access Level'), 'trim|required');


			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect(base_url('admin/content/knowledge_base/categories'));
			} else {

				$db_data = array(
					'name' => $this->input->post('name'),
					'description' => $this->input->post('description'),
					'access' => $this->input->post('access'),
					'status' => $this->input->post('status'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$config['upload_path']                = './filestore/public/';
				$config['allowed_types']              = 'jpg|png|jpeg';
				$config['file_ext_tolower']           = TRUE;
				$config['max_filename_increment']     = 1000;
				$this->load->library('upload', $config);

				if(!empty($_FILES['userfile']['name'])) {
					if(!$this->upload->do_upload('userfile')) { $this->session->set_flashdata('toast-error', __("Error uploading! Check file type or size.")); redirect($_SERVER['HTTP_REFERER']); }
					$db_data['image'] = $this->upload->data('file_name');
				}

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->knowledge_base->edit_category($db_data, $id);

				if($result) {
                    log_staff('Knowledge Base category edited ' . $id);

					$this->session->set_flashdata('toast-success', __("Category has been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to update category."));
				}

				redirect(base_url('admin/content/knowledge_base/categories'));

			}

		} else {
			$data['title'] = __("Edit Knowledge Base Category");
			$data['modal'] = 'admin/content/knowledge_base/edit_category';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function delete_category($id=0)
	{
        enforce_permission('kb-delete');

		$data['category'] = $this->knowledge_base->get_category($id);

		if($this->input->method() === 'post') {

			$result = $this->knowledge_base->delete_category($id);

			if($result) {
                log_staff('Knowledge Base category deleted ' . $id);

				$this->session->set_flashdata('toast-success', __("Category has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete category."));
			}

			redirect(base_url('admin/content/knowledge_base/categories'));

		} else {
			$data['title'] = __("Delete Knowledge Base Category");
			$data['modal'] = 'admin/content/knowledge_base/delete_category';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}






	public function add_article()
	{
        enforce_permission('kb-add');

		$data['categories'] = $this->knowledge_base->get_categories();

		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('name', __('Name'), 'trim|required');
			$this->form_validation->set_rules('category_id', __('Knowledge base category'), 'trim|required');
			$this->form_validation->set_rules('status', __('Status'), 'trim|required');
			$this->form_validation->set_rules('access', __('Access Level'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect(base_url('admin/content/knowledge_base/articles'));
			} else {

				$db_data = array(
					'category_id' => $this->input->post('category_id'),
					'name' => $this->input->post('name'),
					'content' => $this->input->post('content'),
					'access' => $this->input->post('access'),
					'status' => $this->input->post('status'),
                    'featured' => $this->input->post('featured'),
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->knowledge_base->add_article($db_data);

				if($result) {
                    log_staff('Knowledge Base article added ' . $result);

					$this->session->set_flashdata('toast-success', __("Article has been successfully added."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to add article."));
				}

				redirect(base_url('admin/content/knowledge_base/articles'));

			}

		} else {
			$data['title'] = __("Add Knowledge Base Article");
			$data['modal'] = 'admin/content/knowledge_base/add_article';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function edit_article($id=0)
	{
        enforce_permission('kb-edit');

		$data['article'] = $this->knowledge_base->get_article($id);
		$data['categories'] = $this->knowledge_base->get_categories();

		if($this->input->method() === 'post') {

			$this->form_validation->set_rules('name', __('Name'), 'trim|required');
			$this->form_validation->set_rules('category_id', __('Knowledge base category'), 'trim|required');
			$this->form_validation->set_rules('status', __('Status'), 'trim|required');
			$this->form_validation->set_rules('access', __('Access Level'), 'trim|required');


			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect(base_url('admin/content/knowledge_base/articles'));
			} else {

				$db_data = array(
					'category_id' => $this->input->post('category_id'),
					'name' => $this->input->post('name'),
					'content' => $this->input->post('content'),
					'access' => $this->input->post('access'),
					'status' => $this->input->post('status'),
                    'featured' => $this->input->post('featured'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->knowledge_base->edit_article($db_data, $id);

				if($result) {
                    log_staff('Knowledge Base erticle edited ' . $id);

					$this->session->set_flashdata('toast-success', __("Article has been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to update article."));
				}

				redirect(base_url('admin/content/knowledge_base/articles'));

			}

		} else {
			$data['title'] = __("Edit Knowledge Base Article");
			$data['modal'] = 'admin/content/knowledge_base/edit_article';

            $clear_notes = $data['article']['content'];
            $data = html_escape($data);
            $data['article']['content'] = purify($clear_notes);

			$this->load->view('admin/layout_modal', $data);
		}

	}

	public function delete_article($id=0)
	{
        enforce_permission('kb-delete');

		$data['article'] = $this->knowledge_base->get_article($id);

		if($this->input->method() === 'post') {

			$result = $this->knowledge_base->delete_article($id);

			if($result) {
                log_staff('Knowledge Base article deleted ' . $id);

				$this->session->set_flashdata('toast-success', __("Article has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete article."));
			}

			redirect(base_url('admin/content/knowledge_base/articles'));

		} else {
			$data['title'] = __("Delete Knowledge Base Article");
			$data['modal'] = 'admin/content/knowledge_base/delete_article';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}


}
