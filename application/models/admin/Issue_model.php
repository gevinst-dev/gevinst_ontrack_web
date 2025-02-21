<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Issue_model extends CI_Model {


    /**
     *
     * Get single item by ID
     *
     */
    public function get($id)
    {
        $query = $this->db->get_where('app_issues', array('id' => $id));
        return $result = $query->row_array();
    }

    /**
     *
     * Get task comments
     *
     */
    public function get_comments($id)
    {
        $query = $this->db->get_where('app_issue_comments', array('issue_id' => $id));
        return $result = $query->result_array();
    }

    /**
     *
     * Get task files
     *
     */
    public function get_files($id)
    {
        $query = $this->db->get_where('app_issue_files', array('issue_id' => $id));
        return $result = $query->result_array();
    }

    /**
     *
     * Add item
     *
     */
    public function add($data)
    {

        if( $this->db->insert('app_issues', $data) ) {
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

        if( $this->db->update('app_issues', $data) ) {
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
        if( $this->db->delete('app_issues', array('id' => $id)) ) {
            $this->db->delete('app_issue_files', array('issue_id' => $id));
            $this->db->delete('app_issue_comments', array('issue_id' => $id));
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
        $query = $this->db->get_where('app_issue_comments', array('id' => $id));
        return $result = $query->row_array();
    }



    /**
     *
     * Add comment
     *
     */
    public function add_comment($data)
    {

        if( $this->db->insert('app_issue_comments', $data) ) {
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

        if( $this->db->update('app_issue_comments', $data) ) {
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
        if( $this->db->delete('app_issue_comments', array('id' => $id)) ) {
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
        $query = $this->db->get_where('app_issue_files', array('id' => $id));
        return $result = $query->row_array();
    }



    /**
     *
     * Add file
     *
     */
    public function add_file($data)
    {

        if( $this->db->insert('app_issue_files', $data) ) {
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
        if( $this->db->delete('app_issue_files', array('id' => $id)) ) {
            return TRUE;
        } else {
            return FALSE;
        }


    }


}



?>
