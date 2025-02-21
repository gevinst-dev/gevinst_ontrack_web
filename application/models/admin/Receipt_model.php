<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Receipt_model extends CI_Model {


    /**
     *
     * Get single item by ID
     *
     */
    public function get($id)
    {
        $query = $this->db->get_where('app_receipts', array('id' => $id));
        return $result = $query->row_array();
    }



    /**
     *
     * Add item
     *
     */
    public function add($data)
    {

        if( $this->db->insert('app_receipts', $data) ) {

            $id = $this->db->insert_id();

            return $id;
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

        if( $this->db->update('app_receipts', $data) ) {
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
        if( $this->db->delete('app_receipts', array('id' => $id)) ) {
            return TRUE;
        } else {
            return FALSE;
        }


    }




    public function pdf($method, $ids_string)
    {
        $ids_string = explode('-', $ids_string);

        $mpdf = new \Mpdf\Mpdf([
            'defaultPageNumStyle' => '1',
            'format' => 'A5-L',
        ]);

        $stylesheet = file_get_contents('./public/assets/css/pdf-bootstrap.css');
        $mpdf->WriteHTML($stylesheet, 1);

        $p=1;

        
        foreach($ids_string as $receipt_id) {

            $l_id  = get_setting('default_language');

            $data['receipt'] = $this->receipt->get($receipt_id);
            $data['currency'] = $this->setting->get_currency($data['receipt']['currency_id']);
            $data['paymentmethod'] = $this->setting->get_paymentmethod($data['receipt']['paymentmethod_id']);
            $data['client'] = $this->client->get($data['receipt']['client_id']);
    
            $data['entity'] = $this->setting->get_entity($data['receipt']['entity_id']);
    


            if(count($ids_string) == 1) {
                $title = __p("Receipt", $l_id) . " - " . $data['receipt']['reference'] . " - " . $data['client']['name'];
            } else {
                $title = __p("Invoices Export", $l_id);
            }
            $mpdf->SetTitle( $title );


            ob_start();
            ?>



            <?php

            if(file_exists(FCPATH . '/application/views/documents/receipt.custom.php')) {
                include FCPATH . '/application/views/documents/receipt.custom.php';
            } else {
                include FCPATH . '/application/views/documents/receipt.php';
            }

            ?>

            <?php
            
            $html = ob_get_contents();
            ob_end_clean();
            $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
            $mpdf->WriteHTML($html, 2);



            if($p != count($ids_string) ) {
                $mpdf->AddPageByArray(['resetpagenum' => 1, 'suppress' => 'off']);
            }


            $p++;

        }




        if($method == "view") {
            $mpdf->Output();

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
