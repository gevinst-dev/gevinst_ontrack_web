<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Documentation_model extends CI_Model {


    /**
     *
     * Get single item by ID
     *
     */
    public function get_space($id)
    {
        $query = $this->db->get_where('app_docs_spaces', array('id' => $id));
        return $result = $query->row_array();
    }


    /**
     *
     * Get single item by ID
     *
     */
    public function get_page($id)
    {
        $query = $this->db->get_where('app_docs_pages', array('id' => $id));
        return $result = $query->row_array();
    }

    /**
     *
     * Get all pages
     *
     */
    public function get_pages($space_id)
    {
        $query = $this->db->get_where('app_docs_pages', array('space_id' => $space_id));
        return $result = $query->result_array();
    }


    /**
     *
     * Add space
     *
     */
    public function add_space($data)
    {

        if( $this->db->insert('app_docs_spaces', $data) ) {
            return $this->db->insert_id();
        } else {
            return FALSE;
        }

    }


    /**
     *
     * Edit space
     *
     */
    public function edit_space($data, $id)
    {
        $this->db->where('id', $id);

        if( $this->db->update('app_docs_spaces', $data) ) {
            return TRUE;
        } else {
            return FALSE;
        }

    }


    /**
     *
     * Delete space
     *
     */
    public function delete_space($id)
    {
        if( $this->db->delete('app_docs_spaces', array('id' => $id)) ) {
            $this->db->delete('app_docs_pages', array('space_id' => $id));
            return TRUE;
        } else {
            return FALSE;
        }


    }




    /**
     *
     * Add page
     *
     */
    public function add_page($data)
    {

        if( $this->db->insert('app_docs_pages', $data) ) {
            return $this->db->insert_id();
        } else {
            return 0;
        }

    }


    /**
     *
     * Edit page
     *
     */
    public function edit_page($data, $id)
    {
        $this->db->where('id', $id);

        if( $this->db->update('app_docs_pages', $data) ) {
            return TRUE;
        } else {
            return FALSE;
        }

    }


    /**
     *
     * Delete page
     *
     */
    public function delete_page($id)
    {
        if( $this->db->delete('app_docs_pages', array('id' => $id)) ) {

            $this->db->delete('app_docs_pages', array('parent_id' => $id));


            return TRUE;
        } else {
            return FALSE;
        }


    }


}



?>
