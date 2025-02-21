<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Public_Controller extends MY_Controller {


	function __construct()
	{
		parent::__construct();


        $this->session->set_userdata(['date_format' => get_setting('date_format')]);
		date_default_timezone_set(get_setting('timezone'));

        $spaces = $this->db->get_where('app_docs_spaces', array('status' => 'Published'))->result_array();
		define('SPACES', $spaces);
        

	}

}
