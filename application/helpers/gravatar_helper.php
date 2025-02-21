<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author Ivan Tcholakov <ivantcholakov@gmail.com>, 2015
 * @license The MIT License, http://opensource.org/licenses/MIT
 */

if (!function_exists('gravatar')) {

    // This helper function has been added here for compatibility with PyroCMS.
    function gravatar($email = '', $size = 80, $default = 'monsterid') {

        $ci = & get_instance();
        $ci->load->library('gravatar');

        $gravatar_url = $ci->gravatar->get($email, $size, $default, null, 'g');

        return $gravatar_url;



    }

}
