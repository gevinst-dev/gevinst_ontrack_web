<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Ticket_model extends CI_Model {


    /**
     *
     * Get single item by ID
     *
     */
    public function get($id)
    {
        $query = $this->db->get_where('app_tickets', array('id' => $id));
        return $result = $query->row_array();
    }

    /**
     *
     * Get task comments
     *
     */
    public function get_comments($id)
    {
        $query = $this->db->get_where('app_ticket_comments', array('ticket_id' => $id));
        return $result = $query->result_array();
    }

    /**
     *
     * Get task replies
     *
     */
    public function get_replies($id)
    {
        $query = $this->db->order_by("created_at", "desc")->get_where('app_ticket_replies', array('ticket_id' => $id));
        return $result = $query->result_array();
    }

    /**
     *
     * Get reply files
     *
     */
    public function get_reply_files($id)
    {
        $query = $this->db->get_where('app_ticket_reply_files', array('reply_id' => $id));
        return $result = $query->result_array();
    }



    /**
     *
     * Get task comments
     *
     */
    public function get_existing()
    {
        $query = $this->db->select('id, ticket')->get_where('app_tickets', array('updated_at >' => date('Y-m-d H:i:s', strtotime("first day of -3 month"))));
        return $result = $query->result_array();
    }


    /**
     *
     * Add item
     *
     */
    public function add($data, $reply_data)
    {

        if( $this->db->insert('app_tickets', $data) ) {
            $insert_id = $this->db->insert_id();

            $reply_data['ticket_id'] = $insert_id;
            $this->db->insert('app_ticket_replies', $reply_data);
            $reply_id = $this->db->insert_id();

            return $reply_id;
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

        if( $this->db->update('app_tickets', $data) ) {
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
        if( $this->db->delete('app_tickets', array('id' => $id)) ) {

            $replies = $this->db->get_where('app_ticket_replies', array('ticket_id' => $id))->result_array();

            foreach ($replies as $reply) {
                $this->db->delete('app_ticket_reply_files', array('reply_id' => $reply['id']));
            }

            $this->db->delete('app_ticket_replies', array('ticket_id' => $id));

            $this->db->delete('app_ticket_comments', array('ticket_id' => $id));
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
        $query = $this->db->get_where('app_ticket_comments', array('id' => $id));
        return $result = $query->row_array();
    }



    /**
     *
     * Add comment
     *
     */
    public function add_comment($data)
    {

        if( $this->db->insert('app_ticket_comments', $data) ) {
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

        if( $this->db->update('app_ticket_comments', $data) ) {
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
        if( $this->db->delete('app_ticket_comments', array('id' => $id)) ) {
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
    public function get_reply_file($id)
    {
        $query = $this->db->get_where('app_ticket_reply_files', array('id' => $id));
        return $result = $query->row_array();
    }



    /**
     *
     * Get single reply
     *
     */
    public function get_reply($id)
    {
        $query = $this->db->get_where('app_ticket_replies', array('id' => $id));
        return $result = $query->row_array();
    }


    /**
     *
     * Add file
     *
     */
    public function add_file($data)
    {

        if( $this->db->insert('app_ticket_reply_files', $data) ) {
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
        if( $this->db->delete('app_ticket_reply_files', array('id' => $id)) ) {
            return TRUE;
        } else {
            return FALSE;
        }


    }


}



?>
