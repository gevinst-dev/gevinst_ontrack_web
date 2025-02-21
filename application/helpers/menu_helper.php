<?php

defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * Menu Active
 *
 * Check if current page is active
 * If $current_page contains $search_string echoes $class_true; else echoes $class_false
 *
 * @param	string	$current_page
 * @param	string	$search_string
 * @param	string	$class_true
 * @param	string	$class_false - optional
 * @return	string
 */
function menu_active($current_page, $search_string, $class_true, $class_false="")
{

    if(stripos($current_page, $search_string) !== false) {
        echo $class_true;
    } else {
        echo $class_false;
    }


}
