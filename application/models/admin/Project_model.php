<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Project_model extends CI_Model {


    /**
     *
     * Get single item by ID
     *
     */
    public function get($id)
    {
        $query = $this->db->get_where('app_projects', array('id' => $id));
        return $result = $query->row_array();
    }


    /**
     *
     * Get all
     *
     */
    public function get_all($client_id=0)
    {

        if($client_id == 0) {
            $query = $this->db->get('app_projects');
        } else {
            $query = $this->db->get_where('app_projects', ['client_id' => $client_id]);
        }

      
        return $result = $query->result_array();
    }


    /**
     *
     * Get project issues
     *
     */
    public function get_issues($id)
    {
        $query = $this->db->get_where('app_issues', array('project_id' => $id));
        return $result = $query->result_array();
    }



    /**
     *
     * Get project issues
     *
     */
    public function get_issues_selected($id)
    {
        $query = $this->db->order_by('order ASC')->get_where('app_issues', array('project_id' => $id, 'status' => "To Do", 'assigned_to' => $this->session->staff_id));
        return $result = $query->result_array();
    }



    /**
     *
     * Get project issues
     *
     */
    public function get_issues_to_do($id)
    {
        $query = $this->db->order_by('order ASC')->get_where('app_issues', array('project_id' => $id, 'status' => "To Do"));
        return $result = $query->result_array();
    }



    /**
     *
     * Get project issues
     *
     */
    public function get_issues_inprogress($id)
    {
        $query = $this->db->order_by('order ASC')->get_where('app_issues', array('project_id' => $id, 'status' => "In Progress"));
        return $result = $query->result_array();
    }


    /**
     *
     * Get project issues
     *
     */
    public function get_issues_done($id)
    {
        $query = $this->db->order_by('order ASC')->get_where('app_issues', array('project_id' => $id, 'status' => "Done"));
        return $result = $query->result_array();
    }


        /**
     *
     * Get project issues
     *
     */
    public function get_issues_done_unreleased($id)
    {
        $query = $this->db->order_by('order ASC')->get_where('app_issues', array('project_id' => $id, 'status' => "Done", 'released' => 0));
        return $result = $query->result_array();
    }



    /**
     *
     * Get project comments
     *
     */
    public function get_comments($id)
    {
        $query = $this->db->get_where('app_project_comments', array('project_id' => $id));
        return $result = $query->result_array();
    }


    /**
     *
     * Get project milestones
     *
     */
    public function get_milestones($id)
    {
        $query = $this->db->get_where('app_project_milestones', array('project_id' => $id));
        return $result = $query->result_array();
    }



    /**
     *
     * Get project files
     *
     */
    public function get_files($id)
    {
        $query = $this->db->get_where('app_project_files', array('project_id' => $id));
        return $result = $query->result_array();
    }



    /**
     *
     * Get credentials
     *
     */
    public function get_credentials($id)
    {
        $query = $this->db->get_where('app_credentials', array('project_id' => $id));
        return $result = $query->result_array();
    }


    /**
     *
     * Add item
     *
     */
    public function add($data)
    {

        if( $this->db->insert('app_projects', $data) ) {
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

        if( $this->db->update('app_projects', $data) ) {
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
        if( $this->db->delete('app_projects', array('id' => $id)) ) {

            $this->db->delete('app_project_files', array('project_id' => $id));
            $this->db->delete('app_project_comments', array('project_id' => $id));


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
        $query = $this->db->get_where('app_project_comments', array('id' => $id));
        return $result = $query->row_array();
    }



    /**
     *
     * Add comment
     *
     */
    public function add_comment($data)
    {

        if( $this->db->insert('app_project_comments', $data) ) {
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

        if( $this->db->update('app_project_comments', $data) ) {
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
        if( $this->db->delete('app_project_comments', array('id' => $id)) ) {
            return TRUE;
        } else {
            return FALSE;
        }


    }








    /**
     *
     * Get single milestone
     *
     */
    public function get_milestone($id)
    {
        $query = $this->db->get_where('app_project_milestones', array('id' => $id));
        return $result = $query->row_array();
    }



    /**
     *
     * Add milestone
     *
     */
    public function add_milestone($data)
    {

        if( $this->db->insert('app_project_milestones', $data) ) {
            return $this->db->insert_id();
        } else {
            return FALSE;
        }

    }


    /**
     *
     * Edit milestone
     *
     */
    public function edit_milestone($data, $id)
    {
        $this->db->where('id', $id);

        if( $this->db->update('app_project_milestones', $data) ) {
            return TRUE;
        } else {
            return FALSE;
        }

    }


    /**
     *
     * Delete milestone
     *
     */
    public function delete_milestone($id)
    {
        if( $this->db->delete('app_project_milestones', array('id' => $id)) ) {
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
        $query = $this->db->get_where('app_project_files', array('id' => $id));
        return $result = $query->row_array();
    }



    /**
     *
     * Add file
     *
     */
    public function add_file($data)
    {

        if( $this->db->insert('app_project_files', $data) ) {
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
        if( $this->db->delete('app_project_files', array('id' => $id)) ) {
            return TRUE;
        } else {
            return FALSE;
        }


    }







    
    /**
     *
     * Get asset_assignments
     *
     */
    public function get_asset_assignments($id)
    {
        $query = $this->db->get_where('app_project_assets', array('project_id' => $id));
        return $result = $query->result_array();
    }


    /**
     *
     * Get single asset_assignment
     *
     */
    public function get_asset_assignment($id)
    {
        $query = $this->db->get_where('app_project_assets', array('id' => $id));
        return $result = $query->row_array();
    }



    /**
     *
     * Add asset_assignment
     *
     */
    public function add_asset_assignment($data)
    {

        if( $this->db->insert('app_project_assets', $data) ) {
            return $this->db->insert_id();
        } else {
            return FALSE;
        }

    }


    /**
     *
     * Edit asset_assignment
     *
     */
    public function edit_asset_assignment($data, $id)
    {
        $this->db->where('id', $id);

        if( $this->db->update('app_project_assets', $data) ) {
            return TRUE;
        } else {
            return FALSE;
        }

    }


    /**
     *
     * Delete asset_assignment
     *
     */
    public function delete_asset_assignment($id)
    {
        if( $this->db->delete('app_project_assets', array('id' => $id)) ) {
            return TRUE;
        } else {
            return FALSE;
        }


    }





}



?>
