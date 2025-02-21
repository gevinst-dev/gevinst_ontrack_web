<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Predefined_reply_model extends CI_Model {


    /**
     *
     * Get single item by ID
     *
     */
    public function get($id)
    {
        $query = $this->db->get_where('app_predefined_replies', array('id' => $id));
        return $result = $query->row_array();
    }


    /**
     *
     * Get all
     *
     */
    public function get_all()
    {
        $query = $this->db->get('app_predefined_replies');
        return $result = $query->result_array();
    }


    /**
     *
     * Add predefined reply
     *
     */
    public function add($data)
    {

        if( $this->db->insert('app_predefined_replies', $data) ) {
            return $this->db->insert_id();
        } else {
            return FALSE;
        }

    }


    /**
     *
     * Edit predefined reply
     *
     */
    public function edit($data, $id)
    {
        $this->db->where('id', $id);

        if( $this->db->update('app_predefined_replies', $data) ) {
            return TRUE;
        } else {
            return FALSE;
        }

    }


    /**
     *
     * Delete predefined reply
     *
     */
    public function delete($id)
    {
        if( $this->db->delete('app_predefined_replies', array('id' => $id)) ) {
            return TRUE;
        } else {
            return FALSE;
        }


    }



}



?>
