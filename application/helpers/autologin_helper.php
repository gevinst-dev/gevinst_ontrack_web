<?php

defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * Autologin Staff
 *
 *
 * @param	string	$staff_rm_cookie
 * @return	boolean [always TRUE]
 */
function autologin_staff($staff_rm_cookie)
{
    $CI =& get_instance();

    $result = $CI->db->get_where('core_staff', array( 'id' => $CI->encryption->decrypt($staff_rm_cookie) ))->row_array();

    if(empty($result)) {
        delete_cookie('staff_rm');
        redirect(base_url('admin/auth/sign_in'));
        exit;
    }

    if($result['status'] == 'Inactive') {
        delete_cookie('staff_rm');
        redirect(base_url('admin/auth/sign_in'));
        exit;
    }

    $language = $CI->db->get_where('core_languages', ['id' => $result['language_id']])->row_array();

    $session_data = array(
        'staff_id' => $result['id'],
        'staff_role_id' => $result['role_id'],
        'staff_language_id' => $result['language_id'],
        'staff_language_rtl' => $language['rtl'],
        'staff_email' => $result['email'],
        'staff_name' => $result['name'],
        'staff_body_class' => $result['body_class'],
        'staff_signed_in' => TRUE
    );
    $CI->session->set_userdata($session_data);

    return TRUE;

}



/**
 * Autologin Staff
 *
 *
 * @param	string	$staff_rm_cookie
 * @return	boolean [always TRUE]
 */
function autologin_user($user_rm_cookie)
{
    $CI =& get_instance();

    $result = $CI->db->get_where('core_users', array( 'id' => $CI->encryption->decrypt($user_rm_cookie) ))->row_array();

    if(empty($result)) {
        delete_cookie('user_rm');
        redirect(base_url('auth/sign_in'));
        exit;
    }

    if($result['status'] == 'Inactive') {
        delete_cookie('user_rm');
        redirect(base_url('auth/sign_in'));
        exit;
    }

    $client = $CI->db->get_where('app_clients', array( 'id' => $result['client_id'] ))->row_array();
    $language = $CI->db->get_where('core_languages', ['id' => $result['language_id']])->row_array();

    $session_data = array(
        'user_id' => $result['id'],
        'client_id' => $result['client_id'],
        'user_language_id' => $result['language_id'],
        'user_language_rtl' => $language['rtl'],
        'user_email' => $result['email'],
        'user_name' => $result['name'],
        'user_signed_in' => TRUE,
        'client' => $client
    );
    $CI->session->set_userdata($session_data);

    return TRUE;

}
