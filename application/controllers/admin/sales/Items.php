<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Items extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('admin/item_model', 'item');

		$this->load->model('admin/setting_model', 'setting');

		$this->load->library('datatables');

		if(!isset($_SESSION['filter_start']))
			$this->session->set_userdata('filter_start', date('Y-m-d', strtotime('first day of this month')));

		if(!isset($_SESSION['filter_end']))
			$this->session->set_userdata('filter_end', date('Y-m-d', strtotime('last day of this month')));
	}


	public function set_filters() {

		if($this->input->method() === 'post') {



			if(isset($_POST['filter_start']))
				$this->session->set_userdata('filter_start', date_to_db($this->input->post('filter_start')));

			if(isset($_POST['filter_end']))
				$this->session->set_userdata('filter_end', date_to_db($this->input->post('filter_end')));



			redirect($_SERVER['HTTP_REFERER']);

		} else {
			die("Invalid action!");
		}
	}


	public function json_all() {
        enforce_permission('items-view');

		$this->datatables
			->select('app_items.id, app_items.sku, app_items.name, app_items.type')
			->from('app_items')
			->edit_column('name', '<a href="'.base_url('admin/sales/items/details/').'$1">$2</a>', 'id,name')

			->add_column(
				'actions',
				'<div class="btn-group" role="group">'.


					'<a href="'.base_url('admin/sales/items/details/').'$1" data-toggle="tooltip" title="'.__("View Item").'" type="button" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-eye"></i></a>'.
					'<button data-modal="admin/sales/items/delete/$1" data-toggle="tooltip" title="'.__("Delete Item").'" type="button" class="btn btn-danger btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-trash"></i></button>'.
				'</div>',
				'id'
			);

		$results = $this->datatables->generate('json');
		$results = json_decode($results, TRUE);

		foreach($results['data'] as $key => $value) {


			$results['data'][$key]['type'] = __($value['type']);
		}

		echo json_encode($results);
	}


	public function json_sales() {
		$this->datatables
			->select('app_items.id, app_items.sku, app_items.name, app_items.type')
			->from('app_items')
			->join('app_categories', 'app_items.category_id = app_categories.id', 'LEFT')
			->select('app_categories.name as category')
			->edit_column('name', '<a href="'.base_url('admin/sales/items/details/').'$1">$2</a>', 'id,name')
			->add_column('stock', '')
			->add_column(
				'actions',
				'<div class="btn-group" role="group">'.
					'<a href="'.base_url('admin/sales/items/details/').'$1" data-toggle="tooltip" title="'.__("View Item").'" type="button" class="btn btn-primary btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-eye"></i></a>'.
					'<button data-modal="admin/sales/items/delete/$1" data-toggle="tooltip" title="'.__("Delete Item").'" type="button" class="btn btn-danger btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-trash"></i></button>'.
				'</div>',
				'id'
			);

		$results = $this->datatables->generate('json');
		$results = json_decode($results, TRUE);

		foreach($results['data'] as $key => $value) {
			if($value['type'] != 'Services') {
				$results['data'][$key]['stock'] = count_stock($value['id']);
			}

			$results['data'][$key]['type'] = __($value['type']);
		}

		echo json_encode($results);
	}


	public function json_item($id=0)
	{
        enforce_permission('items-view');

		$item = $this->item->get($id);

		echo json_encode($item);
	}

	public function index()
	{
        enforce_permission('items-view');

		$data['title'] = __("Items");
		$data['page'] = 'admin/sales/items/list';

		$this->load->view('admin/layout_page', html_escape($data));
	}


	public function add()
	{
        enforce_permission('items-add');
		$data['taxrates'] = $this->setting->get_taxrates();

		if($this->input->method() === 'post') {

			$this->form_validation->set_rules('type', __('Item Type'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {

				$db_data = array(

					'type' => $this->input->post('type'),
					'name' => $this->input->post('name'),
					'price' => $this->input->post('price'),
					'taxrate' => $this->input->post('taxrate'),
					'description' => $this->input->post('description'),
					'sku' => $this->input->post('sku'),
					'notes' => '',
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$config['upload_path']                = './filestore/main/images/';
				$config['allowed_types']              = 'gif|jpg|png|jpeg';
				$config['file_ext_tolower']           = TRUE;
				$config['max_filename_increment']     = 1000;
				$this->load->library('upload', $config);

				if(!empty($_FILES['userfile']['name'])) {
					if(!$this->upload->do_upload('userfile')) { $this->session->set_flashdata('toast-error', __("Error uploading! Check file type or size.")); redirect($_SERVER['HTTP_REFERER']); }
					$db_data['main_image'] = $this->upload->data('file_name');
				}

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->item->add($db_data);

				if($result) {
                    log_staff('Item added ' . $result);

					$this->session->set_flashdata('toast-success', __("Item has been successfully added."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to add item."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			$data['title'] = __("Add Item");
			$data['modal'] = 'admin/sales/items/add';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}



	public function edit($id=0)
	{
        enforce_permission('items-edit');

		$data['item'] = $this->item->get($id);


		if($this->input->method() === 'post') {

			$this->form_validation->set_rules('type', __('Item Type'), 'trim|required');
			$this->form_validation->set_rules('name', __('Name'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {

				$db_data = array(
					'type' => $this->input->post('type'),
					'name' => $this->input->post('name'),
					'price' => $this->input->post('price'),
					'taxrate' => $this->input->post('taxrate'),
					'description' => $this->input->post('description'),
					'sku' => $this->input->post('sku'),
					
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$config['upload_path']                = './filestore/main/images/';
				$config['allowed_types']              = 'gif|jpg|png|jpeg';
				$config['file_ext_tolower']           = TRUE;
				$config['max_filename_increment']     = 1000;
				$this->load->library('upload', $config);

				if(!empty($_FILES['userfile']['name'])) {
					if(!$this->upload->do_upload('userfile')) { $this->session->set_flashdata('toast-error', __("Error uploading! Check file type or size.")); redirect($_SERVER['HTTP_REFERER']); }
					$db_data['main_image'] = $this->upload->data('file_name');
				}

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->item->edit($db_data, $id);

				if($result) {
                    log_staff('Item edited ' . $id);

					$this->session->set_flashdata('toast-success', __("Item has been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to update item."));
				}

				redirect($_SERVER['HTTP_REFERER']);

			}

		} else {
			redirect($_SERVER['HTTP_REFERER']);
		}

	}


	public function edit_notes($id=0)
	{
        enforce_permission('items-edit');

		$data['item'] = $this->item->get($id);

		if($this->input->method() === 'post') {

			$db_data = array(
				'notes' => $this->input->post('notes'),
				'updated_at' => date('Y-m-d H:i:s'),
			);

			$db_data = $this->security->xss_clean($db_data);
			$result = $this->item->edit($db_data, $id);

			if($result) {
                log_staff('Item notes edited ' . $id);

				$this->session->set_flashdata('toast-success', __("Item has been successfully updated."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to update item."));
			}

		}

		redirect($_SERVER['HTTP_REFERER']);
	}



	public function delete($id=0)
	{
        enforce_permission('items-delete');

		$data['item'] = $this->item->get($id);

		if($this->input->method() === 'post') {

			$result = $this->item->delete($id);

			if($result) {
                log_staff('Item deleted ' . $id);

				$this->session->set_flashdata('toast-success', __("Item has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete item."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			$data['title'] = __("Delete item");
			$data['modal'] = 'admin/sales/items/delete';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function details($id=0)
	{
        enforce_permission('items-view');

		$data['taxrates'] = $this->setting->get_taxrates();

		$data['item'] = $this->item->get($id);
		$data['files'] = $this->item->get_files($id);
		$data['images'] = $this->item->get_images($id);

		$data['title'] = __("Manage Item");
		$data['section'] = 'details';
		$data['page'] = 'admin/sales/items/index';


		$this->load->view('admin/layout_page', html_escape($data));
	}


	public function notes($id=0)
	{
        enforce_permission('items-view');

		$data['item'] = $this->item->get($id);

		$data['title'] = __("Manage Item");
		$data['section'] = 'notes';
		$data['page'] = 'admin/sales/items/index';

		$this->load->view('admin/layout_page', html_escape($data));
	}





	public function sales($id=0)
	{
		$data['item'] = $this->item->get($id);

		$data['title'] = __("Manage Item");
		$data['section'] = 'sales';
		$data['page'] = 'admin/sales/items/index';

		$this->load->view('admin/layout_page', html_escape($data));
	}


	public function upload_file($id)
	{
        enforce_permission('items-edit');

		$data['item'] = $this->item->get($id);

		if($this->input->method() === 'post') {

			$config['upload_path']                = './filestore/main/items/';
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
				'item_id' => $id,
				'added_by' => $this->session->staff_id,
				'file' => $this->upload->data('file_name'),
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
			);

			$db_data = $this->security->xss_clean($db_data);
			$result = $this->item->add_file($db_data);

			if($result) {
                log_staff('Item file uploaded ' . $result);

				$this->session->set_flashdata('toast-success', __("File has been successfully uploaded."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to upload file."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			$data['title'] = __("Upload File");
			$data['modal'] = 'admin/sales/items/upload_file';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function delete_file($id=0)
	{
        enforce_permission('items-delete');

		$data['file'] = $this->item->get_file($id);
		$data['item'] = $this->item->get($data['file']['item_id']);

		if($this->input->method() === 'post') {

			$result = $this->item->delete_file($id);

			unlink('./filestore/main/items/'.$data['file']['file']);

			if($result) {
                log_staff('Item file deleted ' . $id);

				$this->session->set_flashdata('toast-success', __("File has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete file."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			$data['title'] = __("Delete File");
			$data['modal'] = 'admin/sales/items/delete_file';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function download_file($id=0)
	{
        enforce_permission('items-view');

        log_staff('Item file downloaded ' . $id);


		$data['file'] = $this->item->get_file($id);
		$data['item'] = $this->item->get($data['file']['item_id']);


		force_download("./filestore/main/items/" . $data['file']['file'], NULL);
	}






	public function upload_image($id)
	{
        enforce_permission('items-edit');

		$data['item'] = $this->item->get($id);

		if($this->input->method() === 'post') {

			$config['upload_path']                = './filestore/main/images/';
			$config['allowed_types']              = 'gif|jpg|png|jpeg';
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
				'item_id' => $id,
				'added_by' => $this->session->staff_id,
				'file' => $this->upload->data('file_name'),
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
			);

			$db_data = $this->security->xss_clean($db_data);
			$result = $this->item->add_image($db_data);

			if($result) {
                log_staff('Item image uploaded ' . $result);

				$this->session->set_flashdata('toast-success', __("Image has been successfully uploaded."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to upload image."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			$data['title'] = __("Upload Image");
			$data['modal'] = 'admin/sales/items/upload_image';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function delete_image($id=0)
	{
        enforce_permission('items-edit');

		$data['image'] = $this->item->get_image($id);
		$data['item'] = $this->item->get($data['image']['item_id']);

		if($this->input->method() === 'post') {

			$result = $this->item->delete_image($id);

			unlink('./filestore/main/images/'.$data['image']['file']);

			if($result) {
                log_staff('Item image deleted ' . $id);

				$this->session->set_flashdata('toast-success', __("Image has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete image."));
			}

			redirect($_SERVER['HTTP_REFERER']);

		} else {
			$data['title'] = __("Delete Image");
			$data['modal'] = 'admin/sales/items/delete_image';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function view_image($id=0)
	{
        enforce_permission('items-view');

        log_staff('Item image viewed ' . $id);


		$data['image'] = $this->item->get_image($id);
		$data['item'] = $this->item->get($data['image']['item_id']);


		$data['title'] = __("View Image");
		$data['modal'] = 'admin/sales/items/view_image';

		$this->load->view('admin/layout_modal', html_escape($data));


	}

	public function download_image($id=0)
	{
        enforce_permission('items-view');

        log_staff('Item image downloaded ' . $id);


		$data['image'] = $this->item->get_image($id);
		$data['item'] = $this->item->get($data['image']['item_id']);


		force_download("./filestore/main/images/" . $data['image']['file'], NULL);
	}














}
