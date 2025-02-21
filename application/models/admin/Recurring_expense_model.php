<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Recurring_expense_model extends CI_Model {


    /**
     *
     * Get single item by ID
     *
     */
    public function get($id)
    {
        $query = $this->db->get_where('app_recurring_expenses', array('id' => $id));
        return $result = $query->row_array();
    }



    public function get_all()
    {
        $query = $this->db->get('app_recurring_expenses');
        return $result = $query->result_array();
    }



    /**
     *
     * Add item
     *
     */
    public function add($data)
    {

        if( $this->db->insert('app_recurring_expenses', $data) ) {
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

        if( $this->db->update('app_recurring_expenses', $data) ) {
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
        if( $this->db->delete('app_recurring_expenses', array('id' => $id)) ) {
            return TRUE;
        } else {
            return FALSE;
        }


    }











}



?>
