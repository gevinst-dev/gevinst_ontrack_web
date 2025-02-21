<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Recurring_model extends CI_Model {


    /**
     *
     * Get single item by ID
     *
     */
    public function get($id)
    {
        $query = $this->db->get_where('app_recurring', array('id' => $id));
        return $result = $query->row_array();
    }


    /**
     *
     * Get single item by ID
     *
     */
    public function get_items($id)
    {
        $query = $this->db->get_where('app_recurring_items', array('recurring_id' => $id));
        return $result = $query->result_array();
    }


    /**
     *
     * Get all records
     *
     */
    public function get_all_recurrings()
    {
        $query = $this->db->get('app_recurring');
        return $result = $query->result_array();
    }


    /**
     *
     * Add item
     *
     */
    public function add($data, $items)
    {

        if( $this->db->insert('app_recurring', $data) ) {
            $recurring_id = $this->db->insert_id();

            $i = 0;
            foreach($items['item_id'] as $item) {
                $db_item = array();
                $db_item['recurring_id'] = $recurring_id;
                $db_item['currency_id'] = $items['currency_id'][$i];
                $db_item['item_id'] = $items['item_id'][$i];
                $db_item['type'] = $items['type'][$i];
                $db_item['name'] = $items['name'][$i];
                $db_item['description'] = $items['description'][$i];

                $db_item['qty'] = $items['qty'][$i];
                $db_item['taxrate'] = $items['taxrate'][$i];
                $db_item['price'] = $items['price'][$i];
                $db_item['value'] = $items['value'][$i];
                $db_item['tax'] = $items['tax'][$i];
                $db_item['total'] = $items['total'][$i];
                $this->db->insert('app_recurring_items', $db_item);
                $i++;
            }



            return $recurring_id;
        } else {
            return FALSE;
        }

    }


    /**
     *
     * Edit item
     *
     */
    public function edit($data, $items, $id)
    {
        $this->db->delete('app_recurring_items', array('recurring_id' => $id));

        $i = 0;
        foreach($items['item_id'] as $item) {
            $db_item = array();
            $db_item['recurring_id'] = $id;
            $db_item['item_id'] = $items['item_id'][$i];
            $db_item['currency_id'] = $items['currency_id'][$i];
            $db_item['type'] = $items['type'][$i];
            $db_item['name'] = $items['name'][$i];
            $db_item['description'] = $items['description'][$i];
            
            $db_item['qty'] = $items['qty'][$i];
            $db_item['taxrate'] = $items['taxrate'][$i];
            $db_item['price'] = $items['price'][$i];
            $db_item['value'] = $items['value'][$i];
            $db_item['tax'] = $items['tax'][$i];
            $db_item['total'] = $items['total'][$i];
            $this->db->insert('app_recurring_items', $db_item);
            $i++;
        }

        $this->db->where('id', $id);
        if( $this->db->update('app_recurring', $data) ) {
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
        if( $this->db->delete('app_recurring', array('id' => $id)) ) {
            $this->db->delete('app_recurring_items', array('recurring_id' => $id));
            return TRUE;
        } else {
            return FALSE;
        }


    }







}



?>
