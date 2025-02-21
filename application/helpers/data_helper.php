<?php

defined('BASEPATH') OR exit('No direct script access allowed');


function purify($string) {
    $purifier = new HTMLPurifier();


    return $purifier->purify($string);


}


function expenses_by_category($entity, $category_id, $start, $end) {
    $CI =& get_instance();
    $total = 0;


    $CI->db->select('app_expenses.id,app_expenses.value, app_expenses.category_id, app_expenses.rate');
    $CI->db->from('app_expenses');


    $CI->db->where('app_expenses.category_id', $category_id);
    $CI->db->where('app_expenses.status', 'Valid');
    if($entity != "") $CI->db->where('app_expenses.entity_id', $entity);
    $CI->db->where('app_expenses.date >=', $start);
    $CI->db->where('app_expenses.date <=', $end);


    $invoices_custom = $CI->db->get()->result_array();

    foreach($invoices_custom as $item) {
        $total += $item['value']*$item['rate'];
    }


    return $total;
}

function guidv4()
{
    $data = openssl_random_pseudo_bytes(16);
    assert(strlen($data) == 16);

    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}




function check_recaptcha($response) {

	$url = 'https://www.google.com/recaptcha/api/siteverify';

	$data = array(
		'secret' => get_setting("google_recaptcha_secretkey"),
		'response' => $response
	);

	$options = array(
		'http' => array (
			'method' => 'POST',
			'content' => http_build_query($data)
		)
	);

	$context  = stream_context_create($options);
	$verify = file_get_contents($url, false, $context);
	$captcha_success = json_decode($verify);

	if ($captcha_success->success==false) {
		return false;
	} else if ($captcha_success->success==true) {
		return true;
	}

}




function client_has_permission($permission) {
    //$CI =& get_instance();
    if($permission == '') return false;

    if($permission == "kb") { if(get_setting('public_kb') == "1")  return true; }
    if($permission == "documentation") { if(get_setting('public_documentation') == "1")  return true; }
    if($permission == "submit_ticket") { if(get_setting('public_submit_ticket') == "1")  return true; }


    return false;
}


function enforce_client_permission($permission) {
    if(client_has_permission($permission) == false) {
        die("Unauthorized! This is a restricted area.");
    }
}


function user_has_permission($permission) {
    $CI =& get_instance();

    if($permission == '') return false;

    if(!$CI->session->user_signed_in) {
        return false;
    }

    $user = $CI->db->get_where('core_users', array( 'id' => $CI->session->user_id ))->row_array();

    if(empty($user)) return false;


    if($permission == "assets") { if($user['permission_assets'] == 1) return true; }
    if($permission == "licenses") { if($user['permission_licenses'] == 1) return true; }
    if($permission == "domains") { if($user['permission_domains'] == 1) return true; }
    if($permission == "credentials") { if($user['permission_credentials'] == 1) return true; }
    if($permission == "projects") { if($user['permission_projects'] == 1) return true; }
    if($permission == "tickets") { if($user['permission_tickets'] == 1) return true; }
    if($permission == "issues") { if($user['permission_issues'] == 1) return true; }
    if($permission == "kb") { if($user['permission_kb'] == 1) return true; }
    if($permission == "documentation") { if($user['permission_ducumentation'] == 1) return true; }
    if($permission == "invoices") { if($user['permission_invoices'] == 1) return true; }
    if($permission == "proformas") { if($user['permission_proformas'] == 1) return true; }
    if($permission == "proposals") { if($user['permission_proposals'] == 1) return true; }
    if($permission == "receipts") { if($user['permission_receipts'] == 1) return true; }
    if($permission == "profile") { if($user['permission_profile'] == 1) return true; }
    if($permission == "client") { if($user['permission_client'] == 1) return true; }

    return false;

}




function enforce_user_permission($permission) {
    if(user_has_permission($permission) == false) {
        die("Unauthorized! This is a restricted area.");
    }

}

function text_excerpt($text, $max_length = 140, $cut_off = '...', $keep_word = false)
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


function notify_active_admins($template, $data) {
    $CI =& get_instance();

    $staff = $CI->db->get_where('core_staff', array( 'status' => 'Active' ))->result_array();

    foreach ($staff as $item) {
        $data['staff_id'] = $item['id'];
        $CI->mailer->send($template, $data);
    }


}

function documentation_page_select($space_id,$parent,$nesting=0,$selected=0) {
    $CI =& get_instance();

    $pages = $CI->db->order_by("sort", "asc")->get_where('app_docs_pages', array('space_id' => $space_id, 'parent_id' => $parent))->result_array();

    $nestingHtml = str_repeat('&nbsp;&nbsp;&nbsp;', $nesting);

    foreach($pages as $page) {
        echo '<option value="'.$page['id'].'"';

        if($page['id'] == $selected) echo ' selected';

        echo '>' . $nestingHtml . $page['name'] . '</option>';


        documentation_page_select($space_id,$page['id'],$nesting+1,$selected);
    }

}


function documentation_page_tree($space_id,$parent,$selected) {
    $CI =& get_instance();

    $pages = $CI->db->order_by("sort", "asc")->get_where('app_docs_pages', array('space_id' => $space_id, 'parent_id' => $parent))->result_array();

    if(!empty($pages)) {
        echo "<ul>";
        foreach($pages as $page) {


            if($page['id'] == $selected) {
                if($page['folder'] == 1) {
                    echo '<li data-jstree=\'{"opened":true, "type":"folder", "selected":true}\' ';
                } else {
                    echo '<li data-jstree=\'{"opened":true, "type":"file", "selected":true}\' ';
                }
            } else {
                if($page['folder'] == 1) {
                    echo '<li data-jstree=\'{"opened":true, "type":"folder"}\' ';
                } else {
                    echo '<li data-jstree=\'{"opened":true, "type":"file"}\' ';
                }


            }

            echo '><span data-navigate="'.base_url('admin/content/documentation/manage/'.$space_id.'/'.$page['id']).'" >' . $page['name'] . '</span>';


            documentation_page_tree($space_id,$page['id'],$selected);

            echo '</li>';
        }
        echo "</ul>";
    }


}





function documentation_page_select_client($space_id,$parent,$nesting=0,$selected=0) {
    $CI =& get_instance();

    $pages = $CI->db->order_by("sort", "asc")->get_where('app_docs_pages', array('space_id' => $space_id, 'parent_id' => $parent))->result_array();

    $nestingHtml = str_repeat('&nbsp;&nbsp;&nbsp;', $nesting);

    foreach($pages as $page) {
        echo '<option value="'.$page['id'].'"';

        if($page['id'] == $selected) echo ' selected';

        echo '>' . $nestingHtml . $page['name'] . '</option>';


        documentation_page_select_client($space_id,$page['id'],$nesting+1,$selected);
    }

}


function documentation_page_tree_client($space_id,$parent,$selected) {
    $CI =& get_instance();

    $pages = $CI->db->order_by("sort", "asc")->get_where('app_docs_pages', array('space_id' => $space_id, 'parent_id' => $parent))->result_array();

    if(!empty($pages)) {
        echo "<ul>";
        foreach($pages as $page) {


            if($page['id'] == $selected) {
                if($page['folder'] == 1) {
                    echo '<li data-jstree=\'{"opened":true, "type":"folder", "selected":true}\' ';
                } else {
                    echo '<li data-jstree=\'{"opened":true, "type":"file", "selected":true}\' ';
                }
            } else {
                if($page['folder'] == 1) {
                    echo '<li data-jstree=\'{"opened":true, "type":"folder"}\' ';
                } else {
                    echo '<li data-jstree=\'{"opened":true, "type":"file"}\' ';
                }


            }

            echo '><span data-navigate="'.base_url('documentation/view/'.$space_id.'/'.$page['id']).'" >' . $page['name'] . '</span>';


            documentation_page_tree_client($space_id,$page['id'],$selected);

            echo '</li>';
        }
        echo "</ul>";
    }


}


if(!function_exists("str_contains")) {

    function str_contains($string,$word) {
        if (stripos($string, $word) !== false) {
            return true;
        } else {
            return false;
        }
    }

}




function sortByDate($a, $b) {

    $t1 = strtotime($a['date']);
    $t2 = strtotime($b['date']);

    return $t1 - $t2;
}

function aasort (&$array, $key) {
    $sorter=array();
    $ret=array();
    reset($array);
    foreach ($array as $ii => $va) {
        $sorter[$ii]=$va[$key];
    }
    asort($sorter);
    foreach ($sorter as $ii => $va) {
        $ret[$ii]=$array[$ii];
    }
    $array=$ret;
}

function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
    $sort_col = array();
    foreach ($arr as $key=> $row) {
        $sort_col[$key] = $row[$col];
    }

    array_multisort($sort_col, $dir, $arr);

    return $arr;
}


function random_color_part() {
    return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
}

function random_color() {
    return random_color_part() . random_color_part() . random_color_part();
}




function get_shippingmethod_name($id) {
    $CI =& get_instance();
    $item = $CI->db->get_where('app_shippingmethods', array( 'id' => $id ))->row_array();
    if($item) return $item['name'];
}


function get_client_name($client_id) {
    $CI =& get_instance();
    $item = $CI->db->get_where('app_clients', array( 'id' => $client_id ))->row_array();
    if($item) return $item['name'];
}


function get_supplier_name($id) {
    $CI =& get_instance();
    $item = $CI->db->get_where('app_suppliers', array( 'id' => $id ))->row_array();
    if($item) return $item['name'];
}

function get_user_name($id) {
    $CI =& get_instance();
    $item = $CI->db->get_where('core_users', array( 'id' => $id ))->row_array();
    if($item) return $item['name'];
}

function get_staff_name($id) {
    $CI =& get_instance();
    $item = $CI->db->get_where('core_staff', array( 'id' => $id ))->row_array();
    if($item) return $item['name'];
}

function get_entity_title($id) {
    $CI =& get_instance();
    $item = $CI->db->get_where('app_entities', array( 'id' => $id ))->row_array();
    if($item) return $item['title'];
}

function get_agent_name($id) {
    $CI =& get_instance();
    $item = $CI->db->get_where('core_staff', array( 'id' => $id ))->row_array();
    if($item) return $item['name'];
}

function get_item_name($item_id) {
    $CI =& get_instance();
    $item = $CI->db->get_where('app_items', array( 'id' => $item_id ))->row_array();
    if($item) return $item['name'];
}


function get_item_sku($item_id) {
    $CI =& get_instance();
    $item = $CI->db->get_where('app_items', array( 'id' => $item_id ))->row_array();
    if($item) return $item['sku'];
}

function get_item_um($item_id) {
    $CI =& get_instance();
    $item = $CI->db->get_where('app_items', array( 'id' => $item_id ))->row_array();
    if($item) return $item['um'];
}




function get_asset_category_name($id) {
    $CI =& get_instance();
    $item = $CI->db->get_where('app_asset_categories', array( 'id' => $id ))->row_array();
    //return $item['name'];

    if($item)  return '<span class="label" style="background-color:'.$item['color'].'">'.$item['name'].'</span>';
}

function get_license_category_name($id) {
    $CI =& get_instance();
    $item = $CI->db->get_where('app_license_categories', array( 'id' => $id ))->row_array();
    //return $item['name'];

    if($item)  return '<span class="label" style="background-color:'.$item['color'].'">'.$item['name'].'</span>';
}

function get_status_name($id) {
    $CI =& get_instance();
    $item = $CI->db->get_where('app_status_labels', array( 'id' => $id ))->row_array();
    //return $item['name'];

    if($item) return '<span class="label" style="background-color:'.$item['color'].'">'.$item['name'].'</span>';
}

##


function get_location_name($id) {
    $CI =& get_instance();
    $item = $CI->db->get_where('app_locations', array( 'id' => $id ))->row_array();
    if($item) return $item['name'];
}


function get_manufacturer_name($id) {
    $CI =& get_instance();
    $item = $CI->db->get_where('app_manufacturers', array( 'id' => $id ))->row_array();
    if($item) return $item['name'];
}


function get_model_name($id) {
    $CI =& get_instance();
    $item = $CI->db->get_where('app_models', array( 'id' => $id ))->row_array();
    if($item) return $item['name'];
}





function payment_method_name($id) {
    $CI =& get_instance();

    $row = $CI->db->get_where('app_paymentmethods', array('id' => $id))->row_array();

    if(empty($row)) return ""; else return $row['name'];

}


function get_currency_name($id) {
    $CI =& get_instance();

    $row = $CI->db->get_where('app_currencies', array('id' => $id))->row_array();

    if(empty($row)) return ""; else return $row['code'];

}


function get_asset_name($id) {
    $CI =& get_instance();
    $item = $CI->db->get_where('app_assets', array( 'id' => $id ))->row_array();
    if($item) return $item['tag'] . " " . $item['name'];
}


function get_license_name($id) {
    $CI =& get_instance();
    $item = $CI->db->get_where('app_licenses', array( 'id' => $id ))->row_array();
    if($item) return $item['tag'] . " " . $item['name'];
}

function get_project_name($id) {
    $CI =& get_instance();
    $item = $CI->db->get_where('app_projects', array( 'id' => $id ))->row_array();
    if($item) return $item['name'];
}


function get_milestone_name($id) {
    $CI =& get_instance();
    $item = $CI->db->get_where('app_project_milestones', array( 'id' => $id ))->row_array();
    if($item) return $item['name'];
}



function get_kb_category_name($id) {
    $CI =& get_instance();
    $item = $CI->db->get_where('app_kb_categories', array( 'id' => $id ))->row_array();
    if($item) return $item['name'];
}
