<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_Controller extends MY_Controller {


	function __construct()
	{
		parent::__construct();

		// restrict access
		if(!$this->session->has_userdata('user_signed_in') && !$this->session->has_userdata('user_id')) {
			$this->session->set_flashdata('toast-warning', __('Please authenticate to access this section!'));
			redirect(base_url('auth/sign_in'));
		}


        $this->session->set_userdata(['date_format' => get_setting('date_format')]);
		date_default_timezone_set(get_setting('timezone'));

      
        $spaces = $this->db->get_where('app_docs_spaces', array('status' => 'Published'))->result_array();
		define('SPACES', $spaces);

	}

    
}
