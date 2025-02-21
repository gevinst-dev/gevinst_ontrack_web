<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier_model extends CI_Model {


    /**
     *
     * Get single item by ID
     *
     */
    public function get($id)
    {
        $query = $this->db->get_where('app_suppliers', array('id' => $id));
        return $result = $query->row_array();
    }



    public function get_all()
    {
        $query = $this->db->get('app_suppliers');
        return $result = $query->result_array();
    }



    /**
     *
     * Add item
     *
     */
    public function add($data)
    {

        if( $this->db->insert('app_suppliers', $data) ) {
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

        if( $this->db->update('app_suppliers', $data) ) {
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
        if( $this->db->delete('app_suppliers', array('id' => $id)) ) {
            return TRUE;
        } else {
            return FALSE;
        }


    }









    /**
     *
     * Get single file
     *
     */
    public function get_file($id)
    {
        $query = $this->db->get_where('app_supplier_files', array('id' => $id));
        return $result = $query->row_array();
    }

    /**
     *
     * Get item files
     *
     */
    public function get_files($id)
    {
        $query = $this->db->get_where('app_supplier_files', array('supplier_id' => $id));
        return $result = $query->result_array();
    }

    /**
     *
     * Add file
     *
     */
    public function add_file($data)
    {

        if( $this->db->insert('app_supplier_files', $data) ) {
            return $this->db->insert_id();
        } else {
            return FALSE;
        }

    }



    /**
     *
     * Delete file
     *
     */
    public function delete_file($id)
    {
        if( $this->db->delete('app_supplier_files', array('id' => $id)) ) {
            return TRUE;
        } else {
            return FALSE;
        }


    }




    /**
     *
     * Get single address
     *
     */
    public function get_address($id)
    {
        $query = $this->db->get_where('app_supplier_addresses', array('id' => $id));
        return $result = $query->row_array();
    }

    /**
     *
     * Get item addresses
     *
     */
    public function get_addresses($id)
    {
        $query = $this->db->get_where('app_supplier_addresses', array('supplier_id' => $id));
        return $result = $query->result_array();
    }

    /**
     *
     * Add address
     *
     */
    public function add_address($data)
    {

        if( $this->db->insert('app_supplier_addresses', $data) ) {
            return $this->db->insert_id();
        } else {
            return FALSE;
        }

    }

    /**
     *
     * Edit address
     *
     */
    public function edit_address($data, $id)
    {
        $this->db->where('id', $id);

        if( $this->db->update('app_supplier_addresses', $data) ) {
            return TRUE;
        } else {
            return FALSE;
        }

    }

    /**
     *
     * Delete address
     *
     */
    public function delete_address($id)
    {
        if( $this->db->delete('app_supplier_addresses', array('id' => $id)) ) {
            return TRUE;
        } else {
            return FALSE;
        }


    }





    /**
     *
     * Get single comment
     *
     */
    public function get_comment($id)
    {
        $query = $this->db->get_where('app_supplier_comments', array('id' => $id));
        return $result = $query->row_array();
    }

    /**
     *
     * Get item comments
     *
     */
    public function get_comments($id)
    {
        $query = $this->db->get_where('app_supplier_comments', array('supplier_id' => $id));
        return $result = $query->result_array();
    }

    /**
     *
     * Add comment
     *
     */
    public function add_comment($data)
    {

        if( $this->db->insert('app_supplier_comments', $data) ) {
            return $this->db->insert_id();
        } else {
            return FALSE;
        }

    }

    /**
     *
     * Edit comment
     *
     */
    public function edit_comment($data, $id)
    {
        $this->db->where('id', $id);

        if( $this->db->update('app_supplier_comments', $data) ) {
            return TRUE;
        } else {
            return FALSE;
        }

    }

    /**
     *
     * Delete comment
     *
     */
    public function delete_comment($id)
    {
        if( $this->db->delete('app_supplier_comments', array('id' => $id)) ) {
            return TRUE;
        } else {
            return FALSE;
        }


    }

}



?>
