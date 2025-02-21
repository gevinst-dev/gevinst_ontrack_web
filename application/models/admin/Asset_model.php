<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Asset_model extends CI_Model {


    /**
     *
     * Get single item by ID
     *
     */
    public function get($id)
    {
        $query = $this->db->get_where('app_assets', array('id' => $id));
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
            $query = $this->db->get('app_assets');
        } else {
            $query = $this->db->get_where('app_assets', ['client_id' => $client_id]);
        }
        
        return $result = $query->result_array();
    }



    /**
     *
     * Get assigned licenses
     *
     */
    public function get_assigned_licenses($id)
    {
        $query = $this->db->get_where('app_license_assignments', array('asset_id' => $id));
        return $result = $query->result_array();
    }



    /**
     *
     * Get asset comments
     *
     */
    public function get_comments($id)
    {
        $query = $this->db->get_where('app_asset_comments', array('asset_id' => $id));
        return $result = $query->result_array();
    }


    /**
     *
     * Get asset issues
     *
     */
    public function get_issues($id)
    {
        $query = $this->db->get_where('app_issues', array('asset_id' => $id));
        return $result = $query->result_array();
    }

    /**
     *
     * Get asset tickets
     *
     */
    public function get_tickets($id)
    {
        $query = $this->db->get_where('app_tickets', array('asset_id' => $id));
        return $result = $query->result_array();
    }



    /**
     *
     * Get asset files
     *
     */
    public function get_files($id)
    {
        $query = $this->db->get_where('app_asset_files', array('asset_id' => $id));
        return $result = $query->result_array();
    }




    /**
     *
     * Get credentials
     *
     */
    public function get_credentials($id)
    {
        $query = $this->db->get_where('app_credentials', array('asset_id' => $id));
        return $result = $query->result_array();
    }



    /**
     *
     * Add item
     *
     */
    public function add($data)
    {

        if( $this->db->insert('app_assets', $data) ) {
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

        if( $this->db->update('app_assets', $data) ) {
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
        if( $this->db->delete('app_assets', array('id' => $id)) ) {
            return TRUE;
        } else {
            return FALSE;
        }


    }



    /**
     *
     * Assign License
     *
     */
    public function assign_license($data)
    {

        if( $this->db->insert('app_license_assignments', $data) ) {
            return TRUE;
        } else {
            return FALSE;
        }

    }


    /**
     *
     * Unassign License
     *
     */
    public function unassign_license($id)
    {
        if( $this->db->delete('app_license_assignments', array('id' => $id)) ) {
            return TRUE;
        } else {
            return FALSE;
        }


    }

    /**
     *
     * Get single assigned license
     *
     */
    public function get_assigned_license($id)
    {
        $query = $this->db->get_where('app_license_assignments', array('id' => $id));
        return $result = $query->row_array();
    }






    /**
     *
     * Get single comment
     *
     */
    public function get_comment($id)
    {
        $query = $this->db->get_where('app_asset_comments', array('id' => $id));
        return $result = $query->row_array();
    }



    /**
     *
     * Add comment
     *
     */
    public function add_comment($data)
    {

        if( $this->db->insert('app_asset_comments', $data) ) {
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

        if( $this->db->update('app_asset_comments', $data) ) {
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
        if( $this->db->delete('app_asset_comments', array('id' => $id)) ) {
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
        $query = $this->db->get_where('app_asset_files', array('id' => $id));
        return $result = $query->row_array();
    }



    /**
     *
     * Add file
     *
     */
    public function add_file($data)
    {

        if( $this->db->insert('app_asset_files', $data) ) {
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
        if( $this->db->delete('app_asset_files', array('id' => $id)) ) {
            return TRUE;
        } else {
            return FALSE;
        }


    }










    /**
     *
     * Get single credential
     *
     */
    public function get_credential($id)
    {
        $query = $this->db->get_where('app_credentials', array('id' => $id));
        return $result = $query->row_array();
    }



    /**
     *
     * Add credential
     *
     */
    public function add_credential($data)
    {

        if( $this->db->insert('app_credentials', $data) ) {
            return $this->db->insert_id();
        } else {
            return FALSE;
        }

    }


    /**
     *
     * Edit credential
     *
     */
    public function edit_credential($data, $id)
    {
        $this->db->where('id', $id);

        if( $this->db->update('app_credentials', $data) ) {
            return TRUE;
        } else {
            return FALSE;
        }

    }


    /**
     *
     * Delete credential
     *
     */
    public function delete_credential($id)
    {
        if( $this->db->delete('app_credentials', array('id' => $id)) ) {
            return TRUE;
        } else {
            return FALSE;
        }


    }





}



?>
