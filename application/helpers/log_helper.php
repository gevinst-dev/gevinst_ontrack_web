<?php

defined('BASEPATH') OR exit('No direct script access allowed');


function log_asset_activity($asset_id, $action, $extra="")
    {
        $CI =& get_instance();


        $db_data = array(
            'asset_id' => $asset_id,
            'action' => $action,
            'extra' => $extra,
            'created_at' => date('Y-m-d H:i:s'),
        );

        $CI->db->insert('app_asset_history', $db_data);


    }




function log_license_activity($license_id, $action, $extra="")
    {
        $CI =& get_instance();


        $db_data = array(
            'license_id' => $license_id,
            'action' => $action,
            'extra' => $extra,
            'created_at' => date('Y-m-d H:i:s'),
        );

        $CI->db->insert('app_license_history', $db_data);


    }

/**
 * Log Staff Activity
 *
 *
 * @param	string	$description
 * @param	integer	$staff_id
 * @return	boolean [always TRUE]
 */
function log_staff($description, $staff_id=0)
{
    $CI =& get_instance();

    if($staff_id == 0) {
        $staff_id = $CI->session->userdata('staff_id');
    }

    if($staff_id === null) { $staff_id = 0; }

    $db_data = array(
        'staff_id' => $staff_id,
        'ip_address' => $CI->input->ip_address(),
        'description' => $description,
        'created_at' => date('Y-m-d H:i:s'),
    );

    $CI->db->insert('core_staff_activity_log', $db_data);

    return TRUE;

}



/**
 * Log User Activity
 *
 *
 * @param	string	$description
 * @param	integer	$user_id
 * @return	boolean [always TRUE]
 */
function log_user($description, $user_id=0)
{
    $CI =& get_instance();

    if($user_id == 0) {
        $user_id = $CI->session->userdata('user_id');
    }

    if($user_id === null) { $user_id = 0; }
    $db_data = array(
        'user_id' => $user_id,
        'ip_address' => $CI->input->ip_address(),
        'description' => $description,
        'created_at' => date('Y-m-d H:i:s'),
    );

    $CI->db->insert('core_user_activity_log', $db_data);

    return TRUE;

}
