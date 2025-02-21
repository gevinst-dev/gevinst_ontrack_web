<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Item_model extends CI_Model {


    /**
     *
     * Get single item by ID
     *
     */
    public function get($id)
    {
        $query = $this->db->get_where('app_items', array('id' => $id));
        return $result = $query->row_array();
    }

    /**
     *
     * Get single item by ID
     *
     */
    public function get_name($id)
    {
        $query = $this->db->get_where('app_items', array('id' => $id));
        return $result = $query->row_array()['name'];
    }
    /**
     *
     * Get single item by ID
     *
     */
    public function get_sku($id)
    {
        $query = $this->db->get_where('app_items', array('id' => $id));
        return $result = $query->row_array()['sku'];
    }

    /**
     *
     * Get all records
     *
     */
    public function get_all()
    {
        $query = $this->db->get('app_items');
        return $result = $query->result_array();
    }


    /**
     *
     * Get item attachments
     *
     */
    public function get_files($id)
    {
        $query = $this->db->get_where('app_item_files', array('item_id' => $id));
        return $result = $query->result_array();
    }

    /**
     *
     * Get item additional images
     *
     */
    public function get_images($id)
    {
        $query = $this->db->get_where('app_item_images', array('item_id' => $id));
        return $result = $query->result_array();
    }



    /**
     *
     * Add item
     *
     */
    public function add($data)
    {

        if( $this->db->insert('app_items', $data) ) {
            return $this->db->insert_id();
        } else {
            return FALSE;
        }

    }


    /**
     *
     * Edit item
     *
     */
    public function edit($data, $id)
    {
        $this->db->where('id', $id);

        if( $this->db->update('app_items', $data) ) {
            return TRUE;
        } else {
            return FALSE;
        }

    }


    /**
     *
     * Delete item
     *
     */
    public function delete($id)
    {
        if( $this->db->delete('app_items', array('id' => $id)) ) {
            return TRUE;
        } else {
            return FALSE;
        }


    }




    /**
     *
     * Get single attachment
     *
     */
    public function get_file($id)
    {
        $query = $this->db->get_where('app_item_files', array('id' => $id));
        return $result = $query->row_array();
    }


    /**
     *
     * Add attachment
     *
     */
    public function add_file($data)
    {

        if( $this->db->insert('app_item_files', $data) ) {
            return $this->db->insert_id();
        } else {
            return FALSE;
        }

    }



    /**
     *
     * Delete attachment
     *
     */
    public function delete_file($id)
    {
        if( $this->db->delete('app_item_files', array('id' => $id)) ) {
            return TRUE;
        } else {
            return FALSE;
        }


    }






    /**
     *
     * Get single image
     *
     */
    public function get_image($id)
    {
        $query = $this->db->get_where('app_item_images', array('id' => $id));
        return $result = $query->row_array();
    }


    /**
     *
     * Add image
     *
     */
    public function add_image($data)
    {

        if( $this->db->insert('app_item_images', $data) ) {
            return $this->db->insert_id();
        } else {
            return FALSE;
        }

    }


    /**
     *
     * Delete image
     *
     */
    public function delete_image($id)
    {
        if( $this->db->delete('app_item_images', array('id' => $id)) ) {
            return TRUE;
        } else {
            return FALSE;
        }

    }







}



?>
