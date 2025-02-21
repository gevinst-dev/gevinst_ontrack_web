<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Knowledge_base_model extends CI_Model {


    /**
     *
     * Get single item by ID
     *
     */
    public function get_category($id)
    {
        $query = $this->db->get_where('app_kb_categories', array('id' => $id));
        return $result = $query->row_array();
    }

    /**
     *
     * Get all categories
     *
     */
    public function get_categories()
    {
        $query = $this->db->get('app_kb_categories');
        return $result = $query->result_array();
    }


    /**
     *
     * Get single item by ID
     *
     */
    public function get_article($id)
    {
        $query = $this->db->get_where('app_kb_articles', array('id' => $id));
        return $result = $query->row_array();
    }


    /**
     *
     * Add category
     *
     */
    public function add_category($data)
    {

        if( $this->db->insert('app_kb_categories', $data) ) {
            return $this->db->insert_id();
        } else {
            return FALSE;
        }

    }


    /**
     *
     * Edit category
     *
     */
    public function edit_category($data, $id)
    {
        $this->db->where('id', $id);

        if( $this->db->update('app_kb_categories', $data) ) {
            return TRUE;
        } else {
            return FALSE;
        }

    }


    /**
     *
     * Delete category
     *
     */
    public function delete_category($id)
    {
        if( $this->db->delete('app_kb_categories', array('id' => $id)) ) {
            $this->db->delete('app_kb_articles', array('category_id' => $id));
            return TRUE;
        } else {
            return FALSE;
        }


    }






    /**
     *
     * Add article
     *
     */
    public function add_article($data)
    {

        if( $this->db->insert('app_kb_articles', $data) ) {
            return $this->db->insert_id();
        } else {
            return FALSE;
        }

    }


    /**
     *
     * Edit article
     *
     */
    public function edit_article($data, $id)
    {
        $this->db->where('id', $id);

        if( $this->db->update('app_kb_articles', $data) ) {
            return TRUE;
        } else {
            return FALSE;
        }

    }


    /**
     *
     * Delete article
     *
     */
    public function delete_article($id)
    {
        if( $this->db->delete('app_kb_articles', array('id' => $id)) ) {
            return TRUE;
        } else {
            return FALSE;
        }


    }


}



?>
