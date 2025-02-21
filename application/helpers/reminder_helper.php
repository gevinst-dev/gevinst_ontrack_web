<?php

defined('BASEPATH') OR exit('No direct script access allowed');


function set_reminder($description, $datetime, $staff_id, $client_id=0) {
    $CI =& get_instance();


    if(strlen($datetime) < 13) {
        $datetime = $datetime . " 12:00:00";
    }

    $db_data = array(
        'added_by' => 0,
        'assigned_to' => $staff_id,
        'client_id' => $client_id,
        'status' => "Upcoming",
        'description' => $description,
        'datetime' => $datetime,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
    );




}
