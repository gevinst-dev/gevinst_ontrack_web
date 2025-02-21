<?php

defined('BASEPATH') OR exit('No direct script access allowed');



function recalculate_invoice_total($id) {
    $CI =& get_instance();

    $invoice = $CI->db->get_where('app_invoices', array('id' => $id))->row_array();
    $items = $CI->db->get_where('app_invoice_items', array('invoice_id' => $id))->result_array();

    $value = 0;
    $tax = 0;
    $total = 0;

    foreach($items as $item) {
        $value = $value + $item['value'];
        $tax = $tax + $item['tax'];
        $total = $total + $item['total'];
    }

    $invoice_data = array(
        'value' => $value,
        'tax' => $tax,
        'total' => $total,
        'unpaid' => $total,
    );


    $CI->db->where('id', $id);
    $CI->db->update('app_invoices', $invoice_data);


}


function recalculate_proforma_total($id) {
    $CI =& get_instance();

    $invoice = $CI->db->get_where('app_proformas', array('id' => $id))->row_array();
    $items = $CI->db->get_where('app_proforma_items', array('proforma_id' => $id))->result_array();

    $value = 0;
    $tax = 0;
    $total = 0;

    foreach($items as $item) {
        $value = $value + $item['value'];
        $tax = $tax + $item['tax'];
        $total = $total + $item['total'];
    }

    $invoice_data = array(
        'value' => $value,
        'tax' => $tax,
        'total' => $total,
        'unpaid' => $total,
    );


    $CI->db->where('id', $id);
    $CI->db->update('app_purchases', $invoice_data);


}





function increase_document_number($type, $entity_id) { //offer, guarantee or paymentnotice
    $CI =& get_instance();

    $entity = $CI->db->get_where('app_entities', array( 'id' => $entity_id ))->row_array();

    // increase next number
    $increased = $entity[$type.'_next'] + 1;
    $CI->db->where('id', $entity_id);
    $CI->db->update('app_entities', [ $type.'_next' => $increased]);

    return;
}


function decrease_document_number($type, $entity_id) { //offer, guarantee or paymentnotice
    $CI =& get_instance();

    $entity = $CI->db->get_where('app_entities', array( 'id' => $entity_id ))->row_array();

    // increase next number
    $decreased = $entity[$type.'_next'] - 1;
    $CI->db->where('id', $entity_id);
    $CI->db->update('app_entities', [ $type.'_next' => $decreased]);

    return;
}

function next_document_number($type, $entity_id) {
    $CI =& get_instance();
    $entity = $CI->db->get_where('app_entities', array( 'id' => $entity_id ))->row_array();

    return $entity[$type . '_prefix'] . " " . zerofill($entity[$type . '_next']);
}



function sales_between_adv($start, $end, $entity=0, $agent=0) { // fara tva
    $CI =& get_instance();
    $total = 0;

    $filters['date >='] = $start;
    $filters['date <='] = $end;
    $filters['status'] = 'Valid';
    if($agent != 0) {
        $filters['added_by'] = $agent;
    }
    if($entity != 0) {
        $filters['entity_id'] = $entity;
    }


    $invoices = $CI->db->get_where('app_invoices', $filters)->result_array();

    foreach($invoices as $invoice) {
        $total += $invoice['value'] * $invoice['rate'];
    }

    return round($total,2);
}

function sales_between($start, $end, $agent=0, $entity=0) {
    $CI =& get_instance();
    $total = 0;


    $filters['date >='] = $start;
    $filters['date <='] = $end;
    $filters['status'] = 'Valid';
    if($agent != 0) {
        $filters['added_by'] = $agent;
    }
    if($entity != 0) {
        $filters['entity_id'] = $entity;
    }

    $invoices = $CI->db->get_where('app_invoices', $filters)->result_array();

    foreach($invoices as $invoice) {
        $total += $invoice['value'] * $invoice['rate'];
    }

    return round($total,2);
}


function expenses_between($start, $end, $agent=0, $entity=0) {
    $CI =& get_instance();
    $total = 0;


    $filters['date >='] = $start;
    $filters['date <='] = $end;
    $filters['status'] = 'Valid';
    if($agent != 0) {
        $filters['added_by'] = $agent;
    }
    if($entity != 0) {
        $filters['entity_id'] = $entity;
    }

    $expenses = $CI->db->get_where('app_expenses', $filters)->result_array();

    foreach($expenses as $expense) {
        $total += $expense['value'] * $expense['rate'];
    }

    return round($total,2);
}


function collections_between($start, $end, $entity=0) {
    $CI =& get_instance();
    $total = 0;


    $filters['date >='] = $start;
    $filters['date <='] = $end;
    $filters['status'] = 'Valid';
    if($entity != 0) {
        $filters['entity_id'] = $entity;
    }

    $recceipts = $CI->db->get_where('app_receipts', $filters)->result_array();

    foreach($recceipts as $recceipt) {
        $total += $recceipt['amount'] * $recceipt['rate'];
    }

    return round($total,2);
}




function proposals_count($status="", $agent=0) {
    $CI =& get_instance();

    $filters = array();


    $filters['date >='] = date('Y-m-d', strtotime('first day of this year'));
    $filters['date <='] = date('Y-m-d', strtotime('last day of this year'));

    if($status != '') {
        $filters['status'] = $status;
    }

    if($agent != 0) {
        $filters['added_by'] = $agent;
    }

    if(empty($filters)) {
        $proposals = $CI->db->get('app_proposals')->result_array();
    } else {
        $proposals = $CI->db->get_where('app_proposals', $filters)->result_array();
    }


    return count($proposals);
}


function calculate_discount($value, $discount) {

    $discount = $value * ((100 - $discount) /100);

    return round($discount,2);

}



function account_balance_before($account_id, $before) {
    $CI =& get_instance();
    $balance = 0;

    if($account_id != '') $where['account_id'] = $account_id;
    $where['date <'] = $before;

    $transactions = $CI->db->select('amount, rate, type')->get_where('app_transactions', $where)->result_array();



    foreach ($transactions as $transaction) {

        if($transaction['type'] == "Incoming") {
            $balance += round($transaction['amount']*$transaction['rate'], 2);
        }

        if($transaction['type'] == "Outgoing") {
            $balance -= round($transaction['amount']*$transaction['rate'], 2);
        }

        if($transaction['type'] == "Expense") {
            $balance -= round($transaction['amount']*$transaction['rate'], 2);
        }



    }


    return $balance;
}




function client_balance($client_id) {
    $CI =& get_instance();
    $balance = 0;

    $invoices = $CI->db->select('total, rate')->get_where('app_invoices', ['client_id' => $client_id])->result_array();
    foreach ($invoices as $invoice) {
        $balance += round($invoice['total']*$invoice['rate'], 2);
    }

    $transactions = $CI->db->select('amount, rate')->get_where('app_transactions', ['client_id' => $client_id])->result_array();
    foreach ($transactions as $transaction) {

        $balance -= round($transaction['amount']*$transaction['rate'], 2);
    }


    return $balance;
}

function client_balance_before($client_id, $before, $entity_id = 1, $currency_id = 1) {
    $CI =& get_instance();
    $balance = 0;

    $ajustments = $CI->db->select('value')->get_where('app_clients_adj', ['client_id' => $client_id, 'date <' => $before, 'entity_id' => $entity_id, 'currency_id' => $currency_id])->result_array();
    foreach ($ajustments as $ajustment) {
        $balance += $ajustment['value'];
    }

    $invoices = $CI->db->select('total, rate')->get_where('app_invoices', ['client_id' => $client_id, 'date <' => $before, 'entity_id' => $entity_id, 'currency_id' => $currency_id])->result_array();
    foreach ($invoices as $invoice) {
        $balance += $invoice['total'];
    }

    $transactions = $CI->db->select('amount, rate, account_id')->get_where('app_transactions', ['client_id' => $client_id, 'date <' => $before, 'currency_id' => $currency_id])->result_array();
    foreach ($transactions as $transaction) {
        $account = $CI->db->get_where('app_accounts', ['id' => $transaction['account_id']])->row_array();
        if($account['entity_id'] != $entity_id) continue;

        $balance -= $transaction['amount'];
    }


    return $balance;
}

function client_balance_status($client_id) {
    $CI =& get_instance();
    $status['invoiced'] = 0;
    $status['paid'] = 0;


    $invoices = $CI->db->select('total, rate')->get_where('app_invoices', ['client_id' => $client_id])->result_array();
    foreach ($invoices as $invoice) {
        $status['invoiced'] += round($invoice['total']*$invoice['rate'], 2);
    }

    $transactions = $CI->db->select('amount, rate')->get_where('app_transactions', ['client_id' => $client_id])->result_array();
    foreach ($transactions as $transaction) {

        $status['paid'] += round($transaction['amount']*$transaction['rate'], 2);
    }

    $status['unpaid'] = $status['invoiced'] - $status['paid'];
    return $status;
}



function supplier_balance($supplier_id) {
    $CI =& get_instance();
    $balance = 0;

    $invoices = $CI->db->select('total, rate')->get_where('app_purchases', ['supplier_id' => $supplier_id])->result_array();
    foreach ($invoices as $invoice) {
        $balance += round($invoice['total']*$invoice['rate'], 2);
    }

    $transactions = $CI->db->select('amount, rate')->get_where('app_transactions', ['supplier_id' => $supplier_id])->result_array();
    foreach ($transactions as $transaction) {

        $balance -= round($transaction['amount']*$transaction['rate'], 2);
    }


    return $balance;
}

function supplier_balance_before($supplier_id, $before, $entity_id = 1, $currency_id = 1) {
    $CI =& get_instance();
    $balance = 0;

    $ajustments = $CI->db->select('value')->get_where('app_suppliers_adj', ['supplier_id' => $supplier_id, 'date <' => $before, 'entity_id' => $entity_id, 'currency_id' => $currency_id])->result_array();
    foreach ($ajustments as $ajustment) {
        $balance += $ajustment['value'];
    }

    $invoices = $CI->db->select('total, rate')->get_where('app_purchases', ['supplier_id' => $supplier_id, 'date <' => $before, 'entity_id' => $entity_id, 'currency_id' => $currency_id])->result_array();
    foreach ($invoices as $invoice) {
        $balance += $invoice['total'];
    }

    $transactions = $CI->db->select('amount, rate, account_id')->get_where('app_transactions', ['supplier_id' => $supplier_id, 'date <' => $before, 'currency_id' => $currency_id])->result_array();
    foreach ($transactions as $transaction) {
        $account = $CI->db->get_where('app_accounts', ['id' => $transaction['account_id']])->row_array();
        if($account['entity_id'] != $entity_id) continue;

        $balance -= $transaction['amount'];
    }


    return $balance;
}

function supplier_balance_status($supplier_id) {
    $CI =& get_instance();
    $status['invoiced'] = 0;
    $status['paid'] = 0;


    $invoices = $CI->db->select('total, rate')->get_where('app_purchases', ['supplier_id' => $supplier_id])->result_array();
    foreach ($invoices as $invoice) {
        $status['invoiced'] += round($invoice['total']*$invoice['rate'], 2);
    }

    $transactions = $CI->db->select('amount, rate')->get_where('app_transactions', ['supplier_id' => $supplier_id])->result_array();
    foreach ($transactions as $transaction) {

        $status['paid'] += round($transaction['amount']*$transaction['rate'], 2);
    }

    $status['unpaid'] = $status['invoiced'] - $status['paid'];
    return $status;
}



function zerofill($your_int) {
    $filled_int = sprintf("%04d", $your_int);

    return $filled_int;

}
