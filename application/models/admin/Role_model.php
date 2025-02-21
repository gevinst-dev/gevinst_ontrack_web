<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Role_model extends CI_Model {


    /**
     *
     * Get single item by ID
     *
     */
    public function get($id)
    {
        $query = $this->db->get_where('core_roles', array('id' => $id));
        return $result = $query->row_array();
    }



    /**
     *
     * Get all
     *
     */
    public function get_all()
    {
        $query = $this->db->get('core_roles');
        return $result = $query->result_array();
    }


    /**
     *
     * Add item
     *
     */
    public function add($data)
    {

        if( $this->db->insert('core_roles', $data) ) {
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

        if( $this->db->update('core_roles', $data) ) {
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
        if( $this->db->delete('core_roles', array('id' => $id)) ) {
            return TRUE;
        } else {
            return FALSE;
        }


    }



}



?>
