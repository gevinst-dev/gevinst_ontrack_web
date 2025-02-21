<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {


	function __construct()
	{
		parent::__construct();

		// attempt staff autologin if the cookie is present
		if(!$this->session->has_userdata('staff_signed_in') && !$this->session->has_userdata('staff_id')) {
			$staff_rm_cookie = get_cookie('staff_rm');
			if(!empty($staff_rm_cookie)) autologin_staff($staff_rm_cookie);
		}

		// attempt user autologin if the cookie is present
		if(!$this->session->has_userdata('user_signed_in') && !$this->session->has_userdata('user_id')) {
			$user_rm_cookie = get_cookie('user_rm');
			if(!empty($user_rm_cookie)) autologin_user($user_rm_cookie);
		}

		if(!$this->session->has_userdata('staff_signed_in') && !$this->session->has_userdata('staff_id')) {
			$default_language = $this->db->get_where('core_languages', ['id' => get_setting('default_language')])->row_array();
			$session_data = array(
				'staff_language_id' => $default_language['id'],
				'staff_language_rtl' => $default_language['rtl'],
			);
			$this->session->set_userdata($session_data);
		}

	}

}

require __DIR__.'/Public_Controller.php';
require __DIR__.'/User_Controller.php';
require __DIR__.'/Admin_Controller.php';
