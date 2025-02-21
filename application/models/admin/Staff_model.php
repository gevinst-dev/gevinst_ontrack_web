<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Staff_model extends CI_Model {


    /**
     *
     * Get single item by ID
     *
     */
    public function get($id)
    {
        $query = $this->db->get_where('core_staff', array('id' => $id));
        return $result = $query->row_array();
    }


    /**
     *
     * Get staff name
     *
     */
    public function get_name($id)
    {
        $query = $this->db->get_where('core_staff', array('id' => $id));
        return $result = $query->row_array()['name'];
    }


    /**
     *
     * Get staff email
     *
     */
    public function get_email($id)
    {
        $query = $this->db->get_where('core_staff', array('id' => $id));
        return $result = $query->row_array()['email'];
    }


    /**
     *
     * Get staff color
     *
     */
    public function get_color($id)
    {
        $query = $this->db->get_where('core_staff', array('id' => $id));
        return $result = $query->row_array()['color'];
    }




    /**
     *
     * Get all records
     *
     */
    public function get_all()
    {
        $query = $this->db->get('core_staff');
        return $result = $query->result_array();
    }


    /**
     *
     * Get all active records
     *
     */
    public function get_all_active()
    {
        $query = $this->db->get_where('core_staff', array('status' => 'Active'));
        return $result = $query->result_array();
    }


    /**
     *
     * Get all active records
     *
     */
    public function get_all_ticket_notifiable()
    {
        $query = $this->db->get_where('core_staff', array('status' => 'Active', 'ticket_notif' => '1'));
        return $result = $query->result_array();
    }
    

        /**
     *
     * Get all active records
     *
     */
    public function get_all_notifiable()
    {
        $query = $this->db->get_where('core_staff', array('status' => 'Active'));
        return $result = $query->result_array();
    }


    /**
     *
     * Add item
     *
     */
    public function add($data)
    {

        if( $this->db->insert('core_staff', $data) ) {
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

        if( $this->db->update('core_staff', $data) ) {
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
        if( $this->db->delete('core_staff', array('id' => $id)) ) {
            return TRUE;
        } else {
            return FALSE;
        }


    }



}



?>
