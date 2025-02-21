<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Proforma_model extends CI_Model {


    /**
     *
     * Get single item by ID
     *
     */
    public function get($id)
    {
        $query = $this->db->get_where('app_proformas', array('id' => $id));
        return $result = $query->row_array();
    }


    /**
     *
     * Get single item by ID
     *
     */
    public function get_items($id)
    {
        $query = $this->db->get_where('app_proforma_items', array('proforma_id' => $id));
        return $result = $query->result_array();
    }


    /**
     *
     * Get all records
     *
     */
    public function get_all_invoices()
    {
        $query = $this->db->get('app_proformas');
        return $result = $query->result_array();
    }


    /**
     *
     * Add item
     *
     */
    public function add($data, $items)
    {




        if( $this->db->insert('app_proformas', $data) ) {
            $proforma_id = $this->db->insert_id();

            $i = 0;
            foreach($items['item_id'] as $item) {
                $db_item = array();
                $db_item['proforma_id'] = $proforma_id;
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
                $this->db->insert('app_proforma_items', $db_item);
                $i++;
            }

            increase_document_number("proforma", $data['entity_id']);

            return $proforma_id;
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
        $this->db->delete('app_proforma_items', array('proforma_id' => $id));

        $i = 0;
        foreach($items['item_id'] as $item) {
            $db_item = array();
            $db_item['proforma_id'] = $id;
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
            $this->db->insert('app_proforma_items', $db_item);
            $i++;
        }

        $this->db->where('id', $id);
        if( $this->db->update('app_proformas', $data) ) {
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
        if( $this->db->delete('app_proformas', array('id' => $id)) ) {
            $this->db->delete('app_proforma_items', array('proforma_id' => $id));
            return TRUE;
        } else {
            return FALSE;
        }


    }





    public function pdf($method, $invoice_ids_string)
    {

        $invoice_ids = explode('-', $invoice_ids_string);

        $mpdf = new \Mpdf\Mpdf([
            'defaultPageNumStyle' => '1'
        ]);
        $mpdf->setFooter(__("Page") . ' {PAGENO} / {nbpg}');

        $stylesheet = file_get_contents('./public/assets/css/pdf-bootstrap.css');
        $mpdf->WriteHTML($stylesheet, 1);

        $p=1;
        foreach($invoice_ids as $invoice_id) {


            $data['invoice'] = $this->proforma->get($invoice_id);
            $l_id  = $data['invoice']['language_id'];
            $data['invoice_items'] = $this->proforma->get_items($invoice_id);
            $data['currency'] = $this->setting->get_currency($data['invoice']['currency_id']);
            $data['client'] = $this->client->get($data['invoice']['client_id']);
            $data['added_by'] = $this->staff->get($data['invoice']['added_by']);
            $data['issued_by'] = $this->staff->get($data['invoice']['issued_by']);
            $data['entity'] = $this->setting->get_entity($data['invoice']['entity_id']);

            $persistent_client_info = unserialize($data['invoice']['client_data']);



            if(count($invoice_ids) == 1) {
                $title = __p("Proforma", $l_id) . " - " . $data['invoice']['number'] . " - " . $persistent_client_info['name'];
            } else {
                $title = __p("Proformas Export", $l_id);
            }



            $mpdf->SetTitle( $title );




            ob_start();
            ?>



            <?php

                if(file_exists(FCPATH . '/application/views/documents/proforma.custom.php')) {
                    include FCPATH . '/application/views/documents/proforma.custom.php';
                } else {
                    include FCPATH . '/application/views/documents/proforma.php';
                }

            ?>


            <?php
            $html = ob_get_contents();
            ob_end_clean();
            $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
            $mpdf->WriteHTML($html, 2);



            if($p != count($invoice_ids) ) {
                $mpdf->AddPageByArray(['resetpagenum' => 1, 'suppress' => 'off']);
            }


            $p++;

        }



        if($method == "view") {
            $file = $title . '.pdf';
            $mpdf->Output($file, \Mpdf\Output\Destination::INLINE);

        } else if($method == "download") {
            $file = $title . '.pdf';
            $mpdf->Output($file, \Mpdf\Output\Destination::DOWNLOAD);

        } else if($method == "save") {
            $file = './filestore/temp/' . $title . '.pdf';
            $mpdf->Output($file, \Mpdf\Output\Destination::FILE);
            return $title . '.pdf';

        } else if($method == "raw") {
            $content = $mpdf->Output('', \Mpdf\Output\Destination::STRING_RETURN);
            return $content;

        }


    }





}



?>
