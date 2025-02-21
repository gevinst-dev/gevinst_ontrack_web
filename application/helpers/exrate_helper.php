<?php

defined('BASEPATH') OR exit('No direct script access allowed');



function exrate_latest($currency) {
    $CI =& get_instance();

    if(is_numeric($currency)) {
        $currency_row = $CI->db->get_where('app_currencies', array('id' => $currency))->row_array();
        $currency = $currency_row['code'];
        return $currency_row['rate'];
    } else {
        $currency_row = $CI->db->get_where('app_currencies', array('code' => $currency))->row_array();
        $currency = $currency_row['code'];
        return $currency_row['rate'];
    }

   
    return 1;


}


function exrate_latest_date_formated() {
    $CI =& get_instance();

    //exchange_rates_provider_last_update

    $exchange_rates_provider_last_update = get_setting('exchange_rates_provider_last_update');

    if($exchange_rates_provider_last_update == "") {
        return 'N/A';
    } else {
        return datetime_display($exchange_rates_provider_last_update);
    }


}
