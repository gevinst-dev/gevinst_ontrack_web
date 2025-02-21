<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Misc extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('admin/staff_model', 'staff');
		$this->load->model('admin/setting_model', 'setting');

	}




	public function set_body_class($id='')
	{
		echo $id;

		$db_data = array(
			'body_class' => $id,
		);
		$result = $this->staff->edit($db_data, $this->session->staff_id);

		$session_data = array(
			'staff_body_class' => $id,
		);
		$this->session->set_userdata($session_data);


		redirect($_SERVER['HTTP_REFERER']);


	}



}
