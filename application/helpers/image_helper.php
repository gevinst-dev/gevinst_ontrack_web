<?php


function get_image($file, $width, $height, $basepath="filestore/main/images/")
{

    $final_filename = $width . 'x' . $height . '_' . $file;

    if(file_exists(FCPATH.'filestore/img_cache/' . $final_filename)) {
        return $final_filename;
    } else {

        $source_path = FCPATH. $basepath . $file;
        $target_path = FCPATH.'filestore/img_cache/' . $final_filename;

        $config_manip = array(
            'source_image' => $source_path,
            'new_image' => $target_path,
            'width' => $width,
            'height' => $height
        );

        $CI = & get_instance();
        $CI->image_lib->initialize($config_manip);

        if (!$CI->image_lib->fit()) {
            echo $CI->image_lib->display_errors();
        }

        $CI->image_lib->clear();
        return $final_filename;
    }
}
