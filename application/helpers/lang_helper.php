<?php

defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * Register String
 *
 * Adds the string to the core_translations table
 * if it does not exist
 *
 * @param	string	$string
 * @return	string
 */
function register_string($string, $language_id)
{
    $CI =& get_instance();
    $secondary_db = $CI->load->database('secondary', TRUE);

    $db_data = array(
        'language_id' => $language_id,
        'original_string' => $string,
        'translated_string' => $string,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
    );

    $secondary_db->insert('core_translations', $db_data);

}



/**
 * __
 *
 * Searches translations and returns the translated string.
 * It will trigger register_string if the string does not exist
 *
 * @param	string	$string
 * @return	string
 */
function __($string)
{
    $CI =& get_instance();

    $secondary_db = $CI->load->database('secondary', TRUE);

    if($CI->session->staff_language_id) {
        $language_id = $CI->session->staff_language_id;
    } else if($CI->session->user_language_id) {
        $language_id = $CI->session->user_language_id;
    } else {
        $language_id = get_setting('default_language');
    }

    $result = $secondary_db->get_where('core_translations', array('language_id' => $language_id, 'original_string' => $string ))->row_array();

    if($result) {
        return $result['translated_string'];
    } else {
        register_string($string, $language_id);
        return $string;
    }

}


/**
 * _e
 *
 * Searches translations and echoes the translated string.
 * It will trigger register_string if the string does not exist
 *
 * @param	string	$string
 * @return	echo string
 */
function _e($string)
{
    $CI =& get_instance();

    if($CI->session->staff_language_id) {
        $language_id = $CI->session->staff_language_id;
    } else if($CI->session->user_language_id) {
        $language_id = $CI->session->user_language_id;
    } else {
        $language_id = 1;
    }

    $result = $CI->db->get_where('core_translations', array('language_id' => $language_id, 'original_string' => $string ))->row_array();

    if($result) {
        echo $result['translated_string'];
    } else {
        register_string($string, $language_id);
        echo $string;
    }

}






/**
 * __p
 *
 * Searches translations and returns the translated string.
 * It will trigger register_string if the string does not exist
 *
 * @param	string	$string
 * @return	string
 */
function __p($string, $language_id)
{
    $CI =& get_instance();

    $secondary_db = $CI->load->database('secondary', TRUE);

    $result = $secondary_db->get_where('core_translations', array('language_id' => $language_id, 'original_string' => $string ))->row_array();

    if($result) {
        return $result['translated_string'];
    } else {
        register_string($string, $language_id);
        return $string;
    }

}


/**
 * _ep
 *
 * Searches translations and echoes the translated string.
 * It will trigger register_string if the string does not exist
 *
 * @param	string	$string
 * @return	echo string
 */
function _ep($string, $language_id)
{
    $CI =& get_instance();


    $result = $CI->db->get_where('core_translations', array('language_id' => $language_id, 'original_string' => $string ))->row_array();

    if($result) {
        echo $result['translated_string'];
    } else {
        register_string($string, $language_id);
        echo $string;
    }

}
