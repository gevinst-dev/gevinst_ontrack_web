<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attributes extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();

        $this->load->model('admin/attribute_model', 'attribute');
		$this->load->model('admin/client_model', 'client');

		$this->load->model('admin/setting_model', 'setting');
	
	}



    public function index()
    {
        redirect(base_url('admin/inventory/attributes/asset_categories'));
    }




    public function asset_categories()
	{
        enforce_permission('attributes-view');

		$data['title'] = __("Asset Categories");
		$data['page'] = 'admin/inventory/attributes/index';
		$data['section'] = "asset_categories";

        $data['asset_categories'] = $this->attribute->get_asset_categories();

		$this->load->view('admin/layout_page', html_escape($data));
	}



    public function license_categories()
    {
        enforce_permission('attributes-view');

        $data['title'] = __("License Categories");
        $data['page'] = 'admin/inventory/attributes/index';
        $data['section'] = "license_categories";

        $data['license_categories'] = $this->attribute->get_license_categories();

        $this->load->view('admin/layout_page', html_escape($data));
    }


    public function status_labels()
    {
        enforce_permission('attributes-view');

        $data['title'] = __("Status Labels");
        $data['page'] = 'admin/inventory/attributes/index';
        $data['section'] = "status_labels";

        $data['status_labels'] = $this->attribute->get_status_labels();

        $this->load->view('admin/layout_page', html_escape($data));
    }


    public function manufacturers()
    {
        enforce_permission('attributes-view');

        $data['title'] = __("Manufacturers");
        $data['page'] = 'admin/inventory/attributes/index';
        $data['section'] = "manufacturers";

        $data['manufacturers'] = $this->attribute->get_manufacturers();

        $this->load->view('admin/layout_page', html_escape($data));
    }


    public function asset_models()
    {
        enforce_permission('attributes-view');

        $data['title'] = __("Models");
        $data['page'] = 'admin/inventory/attributes/index';
        $data['section'] = "asset_models";

        $data['models'] = $this->attribute->get_models();

        $this->load->view('admin/layout_page', html_escape($data));
    }


    public function locations()
    {
        enforce_permission('attributes-view');

        $data['title'] = __("Locations");
        $data['page'] = 'admin/inventory/attributes/index';
        $data['section'] = "locations";

        $data['locations'] = $this->attribute->get_locations();

        $this->load->view('admin/layout_page', html_escape($data));
    }


    public function suppliers()
    {
        enforce_permission('attributes-view');

        $data['title'] = __("Suppliers");
        $data['page'] = 'admin/inventory/attributes/index';
        $data['section'] = "suppliers";

        $data['suppliers'] = $this->attribute->get_suppliers();

        $this->load->view('admin/layout_page', html_escape($data));
    }








    public function add_asset_category()
	{
        enforce_permission('attributes-add');

		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('name', __('Name'), 'trim|required');
			$this->form_validation->set_rules('color', __('Badge Color'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect(base_url('admin/inventory/attributes/asset_categories'));
			} else {

				$db_data = array(
					'name' => $this->input->post('name'),
					'color' => $this->input->post('color'),
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->attribute->add_asset_category($db_data);

				if($result) {
                    log_staff('Asset Category added ' . $result);

					$this->session->set_flashdata('toast-success', __("Asset category has been successfully added."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to add asset category."));
				}

				redirect(base_url('admin/inventory/attributes/asset_categories'));

			}

		} else {
			$data['title'] = __("Add Asset Category");
			$data['modal'] = 'admin/inventory/attributes/add_asset_category';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function edit_asset_category($id=0)
	{
        enforce_permission('attributes-edit');
		$data['asset_category'] = $this->attribute->get_asset_category($id);

		if($this->input->method() === 'post') {

            $this->form_validation->set_rules('name', __('Name'), 'trim|required');
			$this->form_validation->set_rules('color', __('Badge Color'), 'trim|required');


			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect(base_url('admin/inventory/attributes/asset_categories'));
			} else {

				$db_data = array(
					'name' => $this->input->post('name'),
					'color' => $this->input->post('color'),
					'updated_at' => date('Y-m-d H:i:s'),
				);


				$db_data = $this->security->xss_clean($db_data);
				$result = $this->attribute->edit_asset_category($db_data, $id);

				if($result) {
                    log_staff('Asset Category edited ' . $id);

					$this->session->set_flashdata('toast-success', __("Asset category has been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to update asset category."));
				}

				redirect(base_url('admin/inventory/attributes/asset_categories'));

			}

		} else {
			$data['title'] = __("Edit Asset Category");
			$data['modal'] = 'admin/inventory/attributes/edit_asset_category';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function delete_asset_category($id=0)
	{
        enforce_permission('attributes-delete');

		$data['asset_category'] = $this->attribute->get_asset_category($id);

		if($this->input->method() === 'post') {

			$result = $this->attribute->delete_asset_category($id);

			if($result) {
                log_staff('Asset Category deleted ' . $id);

				$this->session->set_flashdata('toast-success', __("Asset category has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete asset category."));
			}

			redirect(base_url('admin/inventory/attributes/asset_categories'));

		} else {
			$data['title'] = __("Delete Asset Category");
			$data['modal'] = 'admin/inventory/attributes/delete_asset_category';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}










    public function add_license_category()
	{

        enforce_permission('attributes-add');

		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('name', __('Name'), 'trim|required');
			$this->form_validation->set_rules('color', __('Badge Color'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect(base_url('admin/inventory/attributes/license_categories'));
			} else {

				$db_data = array(
					'name' => $this->input->post('name'),
					'color' => $this->input->post('color'),
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->attribute->add_license_category($db_data);

				if($result) {
                    log_staff('License Category added ' . $result);

					$this->session->set_flashdata('toast-success', __("License category has been successfully added."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to add license category."));
				}

				redirect(base_url('admin/inventory/attributes/license_categories'));

			}

		} else {
			$data['title'] = __("Add License Category");
			$data['modal'] = 'admin/inventory/attributes/add_license_category';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function edit_license_category($id=0)
	{
        enforce_permission('attributes-edit');

		$data['license_category'] = $this->attribute->get_license_category($id);

		if($this->input->method() === 'post') {

            $this->form_validation->set_rules('name', __('Name'), 'trim|required');
			$this->form_validation->set_rules('color', __('Badge Color'), 'trim|required');


			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect(base_url('admin/inventory/attributes/license_categories'));
			} else {

				$db_data = array(
					'name' => $this->input->post('name'),
					'color' => $this->input->post('color'),
					'updated_at' => date('Y-m-d H:i:s'),
				);


				$db_data = $this->security->xss_clean($db_data);
				$result = $this->attribute->edit_license_category($db_data, $id);

				if($result) {

                    log_staff('License Category edited ' . $id);

					$this->session->set_flashdata('toast-success', __("License category has been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to update license category."));
				}

				redirect(base_url('admin/inventory/attributes/license_categories'));

			}

		} else {
			$data['title'] = __("Edit License Category");
			$data['modal'] = 'admin/inventory/attributes/edit_license_category';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function delete_license_category($id=0)
	{
        enforce_permission('attributes-delete');

		$data['license_category'] = $this->attribute->get_license_category($id);

		if($this->input->method() === 'post') {

			$result = $this->attribute->delete_license_category($id);

			if($result) {
                log_staff('License Category deleted ' . $id);

				$this->session->set_flashdata('toast-success', __("License category has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete license category."));
			}

			redirect(base_url('admin/inventory/attributes/license_categories'));

		} else {
			$data['title'] = __("Delete License Category");
			$data['modal'] = 'admin/inventory/attributes/delete_license_category';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}









    public function add_status_label()
	{
        enforce_permission('attributes-add');

		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('name', __('Name'), 'trim|required');
			$this->form_validation->set_rules('color', __('Badge Color'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect(base_url('admin/inventory/attributes/status_labels'));
			} else {

				$db_data = array(
					'name' => $this->input->post('name'),
					'color' => $this->input->post('color'),
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->attribute->add_status_label($db_data);

				if($result) {
                    log_staff('Status Label added ' . $result);

					$this->session->set_flashdata('toast-success', __("Status label has been successfully added."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to add status label."));
				}

				redirect(base_url('admin/inventory/attributes/status_labels'));

			}

		} else {
			$data['title'] = __("Add Status Label");
			$data['modal'] = 'admin/inventory/attributes/add_status_label';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function edit_status_label($id=0)
	{
        enforce_permission('attributes-edit');

		$data['status_label'] = $this->attribute->get_status_label($id);

		if($this->input->method() === 'post') {

            $this->form_validation->set_rules('name', __('Name'), 'trim|required');
			$this->form_validation->set_rules('color', __('Badge Color'), 'trim|required');


			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect(base_url('admin/inventory/attributes/status_labels'));
			} else {

				$db_data = array(
					'name' => $this->input->post('name'),
					'color' => $this->input->post('color'),
					'updated_at' => date('Y-m-d H:i:s'),
				);


				$db_data = $this->security->xss_clean($db_data);
				$result = $this->attribute->edit_status_label($db_data, $id);

				if($result) {
                    log_staff('Status Label edited ' . $id);

					$this->session->set_flashdata('toast-success', __("Status label has been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to update status label."));
				}

				redirect(base_url('admin/inventory/attributes/status_labels'));

			}

		} else {
			$data['title'] = __("Edit Status Label");
			$data['modal'] = 'admin/inventory/attributes/edit_status_label';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function delete_status_label($id=0)
	{
        enforce_permission('attributes-delete');

		$data['status_label'] = $this->attribute->get_status_label($id);

		if($this->input->method() === 'post') {

			$result = $this->attribute->delete_status_label($id);

			if($result) {
                log_staff('Status Label deleted ' . $id);

				$this->session->set_flashdata('toast-success', __("Status label has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete status label."));
			}

			redirect(base_url('admin/inventory/attributes/status_labels'));

		} else {
			$data['title'] = __("Delete Status Label");
			$data['modal'] = 'admin/inventory/attributes/delete_status_label';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}











    public function add_manufacturer()
	{

        enforce_permission('attributes-add');
		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('name', __('Name'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect(base_url('admin/inventory/attributes/manufacturers'));
			} else {

				$db_data = array(
					'name' => $this->input->post('name'),
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->attribute->add_manufacturer($db_data);

				if($result) {
                    log_staff('Manufacturer added ' . $result);

					$this->session->set_flashdata('toast-success', __("Manufacturer has been successfully added."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to add manufacturer."));
				}

				redirect(base_url('admin/inventory/attributes/manufacturers'));

			}

		} else {
			$data['title'] = __("Add Manufacturer");
			$data['modal'] = 'admin/inventory/attributes/add_manufacturer';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function edit_manufacturer($id=0)
	{
        enforce_permission('attributes-edit');
		$data['manufacturer'] = $this->attribute->get_manufacturer($id);

		if($this->input->method() === 'post') {

            $this->form_validation->set_rules('name', __('Name'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect(base_url('admin/inventory/attributes/manufacturers'));
			} else {

				$db_data = array(
					'name' => $this->input->post('name'),
					'updated_at' => date('Y-m-d H:i:s'),
				);


				$db_data = $this->security->xss_clean($db_data);
				$result = $this->attribute->edit_manufacturer($db_data, $id);

				if($result) {
                    log_staff('Manufacturer edited ' . $id);

					$this->session->set_flashdata('toast-success', __("Manufacturer has been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to update manufacturer."));
				}

				redirect(base_url('admin/inventory/attributes/manufacturers'));

			}

		} else {
			$data['title'] = __("Edit Manufacturer");
			$data['modal'] = 'admin/inventory/attributes/edit_manufacturer';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function delete_manufacturer($id=0)
	{
        enforce_permission('attributes-delete');

		$data['manufacturer'] = $this->attribute->get_manufacturer($id);

		if($this->input->method() === 'post') {

			$result = $this->attribute->delete_manufacturer($id);

			if($result) {
                log_staff('Manufacturer deleted ' . $id);

				$this->session->set_flashdata('toast-success', __("Manufacturer has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete manufacturer."));
			}

			redirect(base_url('admin/inventory/attributes/manufacturers'));

		} else {
			$data['title'] = __("Delete manufacturer");
			$data['modal'] = 'admin/inventory/attributes/delete_manufacturer';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}






    public function add_asset_model()
	{
        enforce_permission('attributes-add');
		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('name', __('Name'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect(base_url('admin/inventory/attributes/models'));
			} else {

				$db_data = array(
					'name' => $this->input->post('name'),
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->attribute->add_model($db_data);

				if($result) {
                    log_staff('Asset model added ' . $result);

					$this->session->set_flashdata('toast-success', __("Model has been successfully added."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to add model."));
				}

				redirect(base_url('admin/inventory/attributes/asset_models'));

			}

		} else {
			$data['title'] = __("Add Model");
			$data['modal'] = 'admin/inventory/attributes/add_asset_model';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function edit_asset_model($id=0)
	{
        enforce_permission('attributes-edit');

		$data['model'] = $this->attribute->get_model($id);

		if($this->input->method() === 'post') {

            $this->form_validation->set_rules('name', __('Name'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect(base_url('admin/inventory/attributes/asset_models'));
			} else {

				$db_data = array(
					'name' => $this->input->post('name'),
					'updated_at' => date('Y-m-d H:i:s'),
				);


				$db_data = $this->security->xss_clean($db_data);
				$result = $this->attribute->edit_model($db_data, $id);

				if($result) {
                    log_staff('Asset model edited ' . $id);

					$this->session->set_flashdata('toast-success', __("Model has been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to update model."));
				}

				redirect(base_url('admin/inventory/attributes/asset_models'));

			}

		} else {
			$data['title'] = __("Edit Model");
			$data['modal'] = 'admin/inventory/attributes/edit_asset_model';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function delete_asset_model($id=0)
	{
        enforce_permission('attributes-delete');

		$data['model'] = $this->attribute->get_model($id);

		if($this->input->method() === 'post') {

			$result = $this->attribute->delete_model($id);

			if($result) {
                log_staff('Asset model deleted ' . $id);

				$this->session->set_flashdata('toast-success', __("Model has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete model."));
			}

			redirect(base_url('admin/inventory/attributes/asset_models'));

		} else {
			$data['title'] = __("Delete Model");
			$data['modal'] = 'admin/inventory/attributes/delete_asset_model';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}






    public function add_location()
	{

        enforce_permission('attributes-add');
		$data['clients'] = $this->client->get_all();

		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('name', __('Name'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect(base_url('admin/inventory/attributes/locations'));
			} else {

				$db_data = array(
                    'client_id' => $this->input->post('client_id'),
					'name' => $this->input->post('name'),
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->attribute->add_location($db_data);

				if($result) {
                    log_staff('Location added ' . $result);

					$this->session->set_flashdata('toast-success', __("Location has been successfully added."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to add location."));
				}

				redirect(base_url('admin/inventory/attributes/locations'));

			}

		} else {
			$data['title'] = __("Add Location");
			$data['modal'] = 'admin/inventory/attributes/add_location';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function edit_location($id=0)
	{
        enforce_permission('attributes-edit');
		$data['clients'] = $this->client->get_all();
		$data['location'] = $this->attribute->get_location($id);

		if($this->input->method() === 'post') {

            $this->form_validation->set_rules('name', __('Name'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect(base_url('admin/inventory/attributes/locations'));
			} else {

				$db_data = array(
                    'client_id' => $this->input->post('client_id'),
					'name' => $this->input->post('name'),
					'updated_at' => date('Y-m-d H:i:s'),
				);


				$db_data = $this->security->xss_clean($db_data);
				$result = $this->attribute->edit_location($db_data, $id);

				if($result) {
                    log_staff('Location edited ' . $id);

					$this->session->set_flashdata('toast-success', __("Location has been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to update location."));
				}

				redirect(base_url('admin/inventory/attributes/locations'));

			}

		} else {
			$data['title'] = __("Edit Location");
			$data['modal'] = 'admin/inventory/attributes/edit_location';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function delete_location($id=0)
	{
        enforce_permission('attributes-delete');

		$data['location'] = $this->attribute->get_location($id);

		if($this->input->method() === 'post') {

			$result = $this->attribute->delete_location($id);

			if($result) {
                log_staff('Location deleted ' . $id);

				$this->session->set_flashdata('toast-success', __("Location has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete location."));
			}

			redirect(base_url('admin/inventory/attributes/locations'));

		} else {
			$data['title'] = __("Delete Location");
			$data['modal'] = 'admin/inventory/attributes/delete_location';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}






    public function add_supplier()
	{
        enforce_permission('attributes-add');
		if($this->input->method() === 'post') {
			$this->form_validation->set_rules('name', __('Name'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect(base_url('admin/inventory/attributes/suppliers'));
			} else {

				$db_data = array(
					'name' => $this->input->post('name'),
					'contact_name' => $this->input->post('contact_name'),
					'phone' => $this->input->post('phone'),
					'email' => $this->input->post('email'),
					'web_address' => $this->input->post('web_address'),
					'address' => $this->input->post('address'),
					'notes' => $this->input->post('notes'),

					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$db_data = $this->security->xss_clean($db_data);
				$result = $this->attribute->add_supplier($db_data);

				if($result) {
                    log_staff('Supplier added ' . $result);

					$this->session->set_flashdata('toast-success', __("Supplier has been successfully added."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to add supplier."));
				}

				redirect(base_url('admin/inventory/attributes/suppliers'));

			}

		} else {
			$data['title'] = __("Add Supplier");
			$data['modal'] = 'admin/inventory/attributes/add_supplier';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function edit_supplier($id=0)
	{
        enforce_permission('attributes-edit');
		$data['supplier'] = $this->attribute->get_supplier($id);

		if($this->input->method() === 'post') {

            $this->form_validation->set_rules('name', __('Name'), 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('toast-validation', validation_errors());
				redirect(base_url('admin/inventory/attributes/suppliers'));
			} else {

				$db_data = array(
					'name' => $this->input->post('name'),
					'contact_name' => $this->input->post('contact_name'),
					'phone' => $this->input->post('phone'),
					'email' => $this->input->post('email'),
					'web_address' => $this->input->post('web_address'),
					'address' => $this->input->post('address'),
					'notes' => $this->input->post('notes'),

					'updated_at' => date('Y-m-d H:i:s'),
				);


				$db_data = $this->security->xss_clean($db_data);
				$result = $this->attribute->edit_supplier($db_data, $id);

				if($result) {
                    log_staff('Supplier edited ' . $id);

					$this->session->set_flashdata('toast-success', __("Supplier has been successfully updated."));
				} else {
					$this->session->set_flashdata('toast-error', __("Unable to update supplier."));
				}

				redirect(base_url('admin/inventory/attributes/suppliers'));

			}

		} else {
			$data['title'] = __("Edit Supplier");
			$data['modal'] = 'admin/inventory/attributes/edit_supplier';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}

	public function delete_supplier($id=0)
	{
        enforce_permission('attributes-delete');

		$data['supplier'] = $this->attribute->get_supplier($id);

		if($this->input->method() === 'post') {

			$result = $this->attribute->delete_supplier($id);

			if($result) {
                log_staff('Supplier deleted ' . $id);

				$this->session->set_flashdata('toast-success', __("Supplier has been successfully deleted."));
			} else {
				$this->session->set_flashdata('toast-error', __("Unable to delete supplier."));
			}

			redirect(base_url('admin/inventory/attributes/suppliers'));

		} else {
			$data['title'] = __("Delete Supplier");
			$data['modal'] = 'admin/inventory/attributes/delete_supplier';

			$this->load->view('admin/layout_modal', html_escape($data));
		}

	}




}
