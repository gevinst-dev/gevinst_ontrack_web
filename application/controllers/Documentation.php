<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Documentation extends Public_Controller {


	public function __construct()
	{
		parent::__construct();

		$this->load->model('admin/documentation_model', 'documentation');

        $this->load->library('datatables');
	}


	public function view()
	{

		$data['page'] = 'user/documentation/manage';

        

		$space_id =  $this->uri->segment(3);
		$data['space'] = $this->documentation->get_space($space_id);
		$data['pages'] = $this->documentation->get_pages($space_id);



		$data['title'] = $data['space']['name'];

		if(empty($data['pages'])) {
			$data['selected_page'] = [];
			$data['selected_page_id'] = 0;
		} else {
			$page_id =  $this->uri->segment(4);
			if(empty($page_id)) {
				$data['selected_page'] = $data['pages'][0];
				$data['selected_page_id'] = $data['selected_page']['id'];
			} else {
				$data['selected_page'] = $this->documentation->get_page($page_id);
				$data['selected_page_id'] = $data['selected_page']['id'];
			}
		}

        log_user('Viewed documentation - ' . $data['space']['name']);

		$this->load->view('user/layout_page', $data);
	}


}
