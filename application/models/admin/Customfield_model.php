<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Customfield_model extends CI_Model {


    /**
     *
     * Get single item by ID
     *
     */
    public function get($id)
    {
        $query = $this->db->get_where('app_customfields', array('id' => $id));
        return $result = $query->row_array();
    }

    /**
     *
     * Get all records
     *
     */
    public function get_all()
    {
        $query = $this->db->get('app_customfields');
        return $result = $query->result_array();
    }



    /**
     *
     * Get by for
     *
     */
    public function get_for($for)
    {
        $query = $this->db->get_where('app_customfields', [ 'for' => $for ]);
        return $result = $query->result_array();
    }


    /**
     *
     * Add item
     *
     */
    public function add($data)
    {

        if( $this->db->insert('app_customfields', $data) ) {
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

        if( $this->db->update('app_customfields', $data) ) {
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
        if( $this->db->delete('app_customfields', array('id' => $id)) ) {
            return TRUE;
        } else {
            return FALSE;
        }


    }



}



?>
