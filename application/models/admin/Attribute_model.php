<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Attribute_model extends CI_Model {


    /**
     *
     * Get asset categories
     *
     */
    public function get_asset_categories()
    {
        $query = $this->db->get('app_asset_categories');
        return $result = $query->result_array();
    }


    /**
     *
     * Get asset category
     *
     */
    public function get_asset_category($id)
    {
        $query = $this->db->get_where('app_asset_categories', array('id' => $id));
        return $result = $query->row_array();
    }


    /**
     *
     * Get license categories
     *
     */
    public function get_license_categories()
    {
        $query = $this->db->get('app_license_categories');
        return $result = $query->result_array();
    }


    /**
     *
     * Get license category
     *
     */
    public function get_license_category($id)
    {
        $query = $this->db->get_where('app_license_categories', array('id' => $id));
        return $result = $query->row_array();
    }



    /**
     *
     * Get status labels
     *
     */
    public function get_status_labels()
    {
        $query = $this->db->get('app_status_labels');
        return $result = $query->result_array();
    }


    /**
     *
     * Get status label
     *
     */
    public function get_status_label($id)
    {
        $query = $this->db->get_where('app_status_labels', array('id' => $id));
        return $result = $query->row_array();
    }



    /**
     *
     * Get manufacturers
     *
     */
    public function get_manufacturers()
    {
        $query = $this->db->get('app_manufacturers');
        return $result = $query->result_array();
    }


    /**
     *
     * Get manufacturer
     *
     */
    public function get_manufacturer($id)
    {
        $query = $this->db->get_where('app_manufacturers', array('id' => $id));
        return $result = $query->row_array();
    }


    /**
     *
     * Get models
     *
     */
    public function get_models()
    {
        $query = $this->db->get('app_models');
        return $result = $query->result_array();
    }


    /**
     *
     * Get model
     *
     */
    public function get_model($id)
    {
        $query = $this->db->get_where('app_models', array('id' => $id));
        return $result = $query->row_array();
    }


    /**
     *
     * Get locations
     *
     */
    public function get_locations()
    {
        $query = $this->db->get('app_locations');
        return $result = $query->result_array();
    }


    /**
     *
     * Get location
     *
     */
    public function get_location($id)
    {
        $query = $this->db->get_where('app_locations', array('id' => $id));
        return $result = $query->row_array();
    }



    /**
     *
     * Get suppliers
     *
     */
    public function get_suppliers()
    {
        $query = $this->db->get('app_suppliers');
        return $result = $query->result_array();
    }


    /**
     *
     * Get supplier
     *
     */
    public function get_supplier($id)
    {
        $query = $this->db->get_where('app_suppliers', array('id' => $id));
        return $result = $query->row_array();
    }







    ##########




    /**
     *
     * Add asset_category
     *
     */
    public function add_asset_category($data)
    {

        if( $this->db->insert('app_asset_categories', $data) ) {
            return $this->db->insert_id();
        } else {
            return FALSE;
        }

    }


    /**
     *
     * Edit asset_category
     *
     */
    public function edit_asset_category($data, $id)
    {
        $this->db->where('id', $id);

        if( $this->db->update('app_asset_categories', $data) ) {
            return TRUE;
        } else {
            return FALSE;
        }

    }


    /**
     *
     * Delete asset_category
     *
     */
    public function delete_asset_category($id)
    {
        if( $this->db->delete('app_asset_categories', array('id' => $id)) ) {
            return TRUE;
        } else {
            return FALSE;
        }


    }









    /**
     *
     * Add license_category
     *
     */
    public function add_license_category($data)
    {

        if( $this->db->insert('app_license_categories', $data) ) {
            return $this->db->insert_id();
        } else {
            return FALSE;
        }

    }


    /**
     *
     * Edit asset_category
     *
     */
    public function edit_license_category($data, $id)
    {
        $this->db->where('id', $id);

        if( $this->db->update('app_license_categories', $data) ) {
            return TRUE;
        } else {
            return FALSE;
        }

    }


    /**
     *
     * Delete asset_category
     *
     */
    public function delete_license_category($id)
    {
        if( $this->db->delete('app_license_categories', array('id' => $id)) ) {
            return TRUE;
        } else {
            return FALSE;
        }


    }













    /**
     *
     * Add status_label
     *
     */
    public function add_status_label($data)
    {

        if( $this->db->insert('app_status_labels', $data) ) {
            return $this->db->insert_id();
        } else {
            return FALSE;
        }

    }


    /**
     *
     * Edit status_label
     *
     */
    public function edit_status_label($data, $id)
    {
        $this->db->where('id', $id);

        if( $this->db->update('app_status_labels', $data) ) {
            return TRUE;
        } else {
            return FALSE;
        }

    }


    /**
     *
     * Delete status_label
     *
     */
    public function delete_status_label($id)
    {
        if( $this->db->delete('app_status_labels', array('id' => $id)) ) {
            return TRUE;
        } else {
            return FALSE;
        }


    }






    /**
     *
     * Add manufacturer
     *
     */
    public function add_manufacturer($data)
    {

        if( $this->db->insert('app_manufacturers', $data) ) {
            return $this->db->insert_id();
        } else {
            return FALSE;
        }

    }


    /**
     *
     * Edit manufacturer
     *
     */
    public function edit_manufacturer($data, $id)
    {
        $this->db->where('id', $id);

        if( $this->db->update('app_manufacturers', $data) ) {
            return TRUE;
        } else {
            return FALSE;
        }

    }


    /**
     *
     * Delete manufacturer
     *
     */
    public function delete_manufacturer($id)
    {
        if( $this->db->delete('app_manufacturers', array('id' => $id)) ) {
            return TRUE;
        } else {
            return FALSE;
        }


    }







    /**
     *
     * Add model
     *
     */
    public function add_model($data)
    {

        if( $this->db->insert('app_models', $data) ) {
            return $this->db->insert_id();
        } else {
            return FALSE;
        }

    }


    /**
     *
     * Edit model
     *
     */
    public function edit_model($data, $id)
    {
        $this->db->where('id', $id);

        if( $this->db->update('app_models', $data) ) {
            return TRUE;
        } else {
            return FALSE;
        }

    }


    /**
     *
     * Delete model
     *
     */
    public function delete_model($id)
    {
        if( $this->db->delete('app_models', array('id' => $id)) ) {
            return TRUE;
        } else {
            return FALSE;
        }


    }








    /**
     *
     * Add location
     *
     */
    public function add_location($data)
    {

        if( $this->db->insert('app_locations', $data) ) {
            return $this->db->insert_id();
        } else {
            return FALSE;
        }

    }


    /**
     *
     * Edit location
     *
     */
    public function edit_location($data, $id)
    {
        $this->db->where('id', $id);

        if( $this->db->update('app_locations', $data) ) {
            return TRUE;
        } else {
            return FALSE;
        }

    }


    /**
     *
     * Delete location
     *
     */
    public function delete_location($id)
    {
        if( $this->db->delete('app_locations', array('id' => $id)) ) {
            return TRUE;
        } else {
            return FALSE;
        }


    }






    /**
     *
     * Add supplier
     *
     */
    public function add_supplier($data)
    {

        if( $this->db->insert('app_suppliers', $data) ) {
            return $this->db->insert_id();
        } else {
            return FALSE;
        }

    }


    /**
     *
     * Edit supplier
     *
     */
    public function edit_supplier($data, $id)
    {
        $this->db->where('id', $id);

        if( $this->db->update('app_suppliers', $data) ) {
            return TRUE;
        } else {
            return FALSE;
        }

    }


    /**
     *
     * Delete supplier
     *
     */
    public function delete_supplier($id)
    {
        if( $this->db->delete('app_suppliers', array('id' => $id)) ) {
            return TRUE;
        } else {
            return FALSE;
        }


    }






}



?>
