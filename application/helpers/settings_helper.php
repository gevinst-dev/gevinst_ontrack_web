<?php

defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * Get setting value
 *
 *
 * @param	string	$name
 * @return	string
 */
function get_setting($name)
{
    $CI =& get_instance();

    $result = $CI->db->get_where('core_settings', array( 'name' => $name ))->row_array();



    return $result['value'];

}

/**
 * Update setting
 *
 *
 * @param	string	$name
 * @param	string	$value
 * @return	boolean
 */
function update_setting($name, $value)
{
    $CI =& get_instance();

    $CI->db->where('name', $name);

    if( $CI->db->update('core_settings', ['value' => $value]) ) {
        return TRUE;
    } else {
        return FALSE;
    }

}


/**
 * Get permissions array
 *
 *
 * @param	string	$name
 * @return	array
 */
function get_permissions($id)
{
    $CI =& get_instance();

    $result = $CI->db->get_where('core_roles', array( 'id' => $id ))->row_array();

    return unserialize($result['permissions']);
}


/**
 * Check if logged in staff has permission to perform actin
 *
 *
 * @param	string	$action
 * @return	array
 */
function has_permission($action)
{

    $CI =& get_instance();

    // if super administrator
    if($CI->session->staff_role_id == 1) {
        return TRUE;
    }


    if(in_array($action, $CI->session->staff_permissions)) {
        return TRUE;
    } else {
        return FALSE;
    }


}


/**
 * Check if logged in staff has permission and enforce it if the action is attempted
 *
 *
 * @param	string	$action
 * @return	array
 */
function enforce_permission($action)
{
    $CI =& get_instance();

    if(!has_permission($action)) {
        die('Forbidden!');
    }

}


