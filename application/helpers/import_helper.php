<?php

defined('BASEPATH') OR exit('No direct script access allowed');



function existing_client_or_new($name) {
    $CI =& get_instance();

    $item = $CI->db->get_where('app_clients', array( 'name' => $name ))->row_array();

    if($item) {
        return $item['id'];
    } else {

        $db_data = array(
            'name' => $name,
            'description' => '',
            'company_id' => '',
            'company_taxid' => '',
            'phone' => '',
            'email' => '',
            'website' => '',
            'address' => '',
            'city' => '',
            'state' => '',
            'zip_code' => '',
            'country' => '',
            'notes' => '',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        );

        $db_data = $CI->security->xss_clean($db_data);
        $CI->db->insert('app_clients', $db_data);
        $insert_id = $CI->db->insert_id();
        
        return $insert_id;
    }

}


function existing_location_or_new($name, $client_id) {
    $CI =& get_instance();

    $item = $CI->db->get_where('app_locations', array( 'name' => $name, 'client_id' => $client_id ))->row_array();

    if($item) {
        return $item['id'];
    } else {

        $db_data = array(
            'client_id' => $client_id,
            'name' => $name,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        );

        $db_data = $CI->security->xss_clean($db_data);
        $CI->db->insert('app_locations', $db_data);
        $insert_id = $CI->db->insert_id();
        
        return $insert_id;
    }

}


function existing_status_label_or_new($name) {
    $CI =& get_instance();

    $item = $CI->db->get_where('app_status_labels', array( 'name' => $name))->row_array();

    if($item) {
        return $item['id'];
    } else {

        $db_data = array(
            'name' => $name,
            'color' => "#".random_color(),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        );

        $db_data = $CI->security->xss_clean($db_data);
        $CI->db->insert('app_status_labels', $db_data);
        $insert_id = $CI->db->insert_id();
        
        return $insert_id;
    }

}


function existing_asset_category_or_new($name) {
    $CI =& get_instance();

    $item = $CI->db->get_where('app_asset_categories', array( 'name' => $name))->row_array();

    if($item) {
        return $item['id'];
    } else {

        $db_data = array(
            'name' => $name,
            'color' => "#".random_color(),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        );

        $db_data = $CI->security->xss_clean($db_data);
        $CI->db->insert('app_asset_categories', $db_data);
        $insert_id = $CI->db->insert_id();
        
        return $insert_id;
    }

}

function existing_license_category_or_new($name) {
    $CI =& get_instance();

    $item = $CI->db->get_where('app_license_categories', array( 'name' => $name))->row_array();

    if($item) {
        return $item['id'];
    } else {

        $db_data = array(
            'name' => $name,
            'color' => "#".random_color(),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        );

        $db_data = $CI->security->xss_clean($db_data);
        $CI->db->insert('app_license_categories', $db_data);
        $insert_id = $CI->db->insert_id();
        
        return $insert_id;
    }

}


function existing_supplier_or_new($name) {
    $CI =& get_instance();

    $item = $CI->db->get_where('app_suppliers', array( 'name' => $name))->row_array();

    if($item) {
        return $item['id'];
    } else {

        $db_data = array(
            'name' => $name,
            'contact_name' => '',
            'phone' => '',
            'email' => '',
            'web_address' => '',
            'address' => '',
            'notes' => '',
        );

        $db_data = $CI->security->xss_clean($db_data);
        $CI->db->insert('app_suppliers', $db_data);
        $insert_id = $CI->db->insert_id();
        
        return $insert_id;
    }

}


function existing_manufacturer_or_new($name) {
    $CI =& get_instance();

    $item = $CI->db->get_where('app_manufacturers', array( 'name' => $name))->row_array();

    if($item) {
        return $item['id'];
    } else {

        $db_data = array(
            'name' => $name,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        );

        $db_data = $CI->security->xss_clean($db_data);
        $CI->db->insert('app_manufacturers', $db_data);
        $insert_id = $CI->db->insert_id();
        
        return $insert_id;
    }

}


function existing_model_or_new($name) {
    $CI =& get_instance();

    $item = $CI->db->get_where('app_models', array( 'name' => $name))->row_array();

    if($item) {
        return $item['id'];
    } else {

        $db_data = array(
            'name' => $name,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        );

        $db_data = $CI->security->xss_clean($db_data);
        $CI->db->insert('app_models', $db_data);
        $insert_id = $CI->db->insert_id();
        
        return $insert_id;
    }

}