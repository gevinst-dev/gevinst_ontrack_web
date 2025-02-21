<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Upgrade
{

	function __construct()
	{
		$this->CI =& get_instance();
    }


    public function execute()
    {

        $current_db_level = get_setting('db_level');
        

        // upgrade to level 2
        if($current_db_level == '1') {

            $sql = file_get_contents(FCPATH . 'filestore/db/2.sql');

            $mysqli = new mysqli(APP_DB_HOSTNAME,APP_DB_USERNAME,APP_DB_PASSWORD,APP_DB_NAME);

            $mysqli->multi_query($sql);

            $mysqli->close();
            



            
        }
        




    }




}

