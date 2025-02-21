<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {


    /**
     *
     * Get single item by ID
     *
     */
    public function get($id)
    {
        $query = $this->db->get_where('core_users', array('id' => $id));
        return $result = $query->row_array();
    }



    /**
     *
     * Get staff name
     *
     */
    public function get_name($id)
    {
        $query = $this->db->get_where('core_users', array('id' => $id));
        return $result = $query->row_array()['name'];
    }


    /**
     *
     * Get staff email
     *
     */
    public function get_email($id)
    {
        $query = $this->db->get_where('core_users', array('id' => $id));
        return $result = $query->row_array()['email'];
    }



    /**
     *
     * Get all records
     *
     */
    public function get_all()
    {
        $query = $this->db->get('core_users');
        return $result = $query->result_array();
    }

    /**
     *
     * Add item
     *
     */
    public function add($data)
    {

        if( $this->db->insert('core_users', $data) ) {
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

        if( $this->db->update('core_users', $data) ) {
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
        if( $this->db->delete('core_users', array('id' => $id)) ) {
            return TRUE;
        } else {
            return FALSE;
        }


    }



}



?>
