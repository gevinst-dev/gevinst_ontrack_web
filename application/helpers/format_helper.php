<?php

defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * Get the date format for PHP
 */
function date_php_format() {
    $CI =& get_instance();

    if(isset($CI->session->date_format)) {
        $format = explode(";", $CI->session->date_format);
    } else {
        $format = explode(";", DATE_FORMAT);
    }

	return $format[0];
}

/**
 * Get the date format for JavaScript
 */
function date_js_format() {
    $CI =& get_instance();

    if(isset($CI->session->date_format)) {
        $format = explode(";", $CI->session->date_format);
    } else {
        $format = explode(";", DATE_FORMAT);
    }
	return $format[1];
}


/**
 * Format ISO date to selected format
 */
function date_display($date) {
    $CI =& get_instance();

    if(isset($CI->session->date_format)) {
        $format = explode(";", $CI->session->date_format);
    } else {
        $format = explode(";", DATE_FORMAT);
    }

    if($date == "") { return ""; }
    else if ($date == "0000-00-00") { return ""; }
    else return date($format[0], strtotime($date) );

}

/**
 * Format ISO datetime to selected format
 */
function datetime_display($date) {
    $CI =& get_instance();

    if(isset($CI->session->date_format)) {
        $format = explode(";", $CI->session->date_format);
    } else {
        $format = explode(";", DATE_FORMAT);
    }

    if($date == "") { return ""; }
    else if ($date == "0000-00-00 00:00:00") { return ""; }
    else return date($format[0]." H:i:s", strtotime($date) );

}

/**
 * Format ISO datetime to selected format
 */
function datetime_hi_display($date) {
    $CI =& get_instance();

    if(isset($CI->session->date_format)) {
        $format = explode(";", $CI->session->date_format);
    } else {
        $format = explode(";", DATE_FORMAT);
    }

    if($date == "") { return ""; }
    else if ($date == "0000-00-00 00:00:00") { return ""; }
    else return date($format[0]." H:i", strtotime($date) );

}

/**
 * Convert date to ISO format
 */
function date_to_db($date) {
    $CI =& get_instance();

    if(isset($CI->session->date_format)) {
        $format = explode(";", $CI->session->date_format);
    } else {
        $format = explode(";", DATE_FORMAT);
    }

    if($date == "") { return ""; }
    else if ($date == "0000-00-00") { return ""; }
    else {
        $dateObj = date_create_from_format($format[0], $date);
        return date_format($dateObj,"Y-m-d");
    }

}

/**
 * Convert datetime to ISO format
 */
function datetime_his_to_db($date) {
    $CI =& get_instance();

    if(isset($CI->session->date_format)) {
        $format = explode(";", $CI->session->date_format);
    } else {
        $format = explode(";", DATE_FORMAT);
    }

    if($date == "") { return ""; }
    else if ($date == "0000-00-00 00:00:00") { return ""; }
    else {
        $dateObj = date_create_from_format($format[0] . " H:i:s", $date);
        return date_format($dateObj,"Y-m-d H:i:s");
    }

}

/**
 * Convert datetime to ISO format
 */
function datetime_hi_to_db($date) {
    $CI =& get_instance();

    if(isset($CI->session->date_format)) {
        $format = explode(";", $CI->session->date_format);
    } else {
        $format = explode(";", DATE_FORMAT);
    }


    if($date == "") { return ""; }
    else if ($date == "0000-00-00 00:00:00") { return ""; }
    else {
        $dateObj = date_create_from_format($format[0] . " H:i", $date);
        return date_format($dateObj,"Y-m-d H:i:s");
    }

}


function _nf($value) {
    if(is_numeric($value)) {
        return number_format($value, 2, get_setting('decimal_separator'), get_setting('thousands_separator'));
    } else {
        return $value;
    }

}


function format_currency($value, $currency_id) {
    $CI =& get_instance();

    $secondary_db = $CI->load->database('secondary', TRUE);

    $currency = $secondary_db->get_where('app_currencies', array( 'id' => $currency_id ))->row_array();

    $value = number_format($value, 2, get_setting('decimal_separator'), get_setting('thousands_separator'));

    return $currency['prefix'] . $value . $currency['suffix'];
}



function format_issue_icon($type) {
    $icon_html = "";

    if($type == "Task") { $icon_html = '<i class="fa fa-check-square fa-fw text-primary" data-toggle="tooltip" title="'.__('Task').'"></i>';  }
    if($type == "Maintenance") { $icon_html = '<i class="fa fa-minus-square fa-fw text-warning" data-toggle="tooltip" title="'.__('Maintenance').'"></i>';  }
    if($type == "Bug") { $icon_html = '<i class="fa fa-bug fa-fw text-danger" data-toggle="tooltip" title="'.__('Bug').'"></i>';  }
    if($type == "Improvement") { $icon_html = '<i class="fa fa-external-link-square-alt fa-fw text-info" data-toggle="tooltip" title="'.__('Improvement').'"></i>';  }
    if($type == "New Feature") { $icon_html = '<i class="fa fa-plus-square fa-fw text-success" data-toggle="tooltip" title="'.__('New Feature').'"></i>';  }
    if($type == "Story") { $icon_html = '<i class="fa fa-circle fa-fw text-purple" data-toggle="tooltip" title="'.__('Story').'"></i>';  }

    return $icon_html;

}



function shorten_text($text, $max_length = 140, $cut_off = '...', $keep_word = false)
{
    if(strlen($text) <= $max_length) {
        return $text;
    }

    if(strlen($text) > $max_length) {
        if($keep_word) {
            $text = substr($text, 0, $max_length + 1);

            if($last_space = strrpos($text, ' ')) {
                $text = substr($text, 0, $last_space);
                $text = rtrim($text);
                $text .=  $cut_off;
            }
        } else {
            $text = substr($text, 0, $max_length);
            $text = rtrim($text);
            $text .=  $cut_off;
        }
    }

    return $text;
}
