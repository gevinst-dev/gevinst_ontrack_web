<?php

defined('BASEPATH') OR exit('No direct script access allowed');


function client_total_invoiced($client_id) {
    $CI =& get_instance();

    $total = 0;

    $invoices = $CI->db->get_where('app_invoices', array('client_id' => $client_id))->result_array();


    foreach($invoices as $invoice) {
        $total += $invoice['total']*$invoice['rate'];
    }


    return round($total,2);
}



function client_total_unpaid($client_id) {
    $CI =& get_instance();

    $total = 0;

    $invoices = $CI->db->get_where('app_invoices', array('client_id' => $client_id))->result_array();


    foreach($invoices as $invoice) {
        $total += $invoice['unpaid']*$invoice['rate'];
    }


    return round($total,2);
}


function client_total_paid($client_id) {
    $CI =& get_instance();

    $total = 0;

    $invoices = $CI->db->get_where('app_invoices', array('client_id' => $client_id))->result_array();


    foreach($invoices as $invoice) {
        $total += $invoice['paid']*$invoice['rate'];
    }


    return round($total,2);
}
