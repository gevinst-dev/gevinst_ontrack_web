<?php

defined('BASEPATH') OR exit('No direct script access allowed');



function render_customfield($id,$type,$name,$required=0,$options="",$value="",$description="") {

    if($type == "Text Box") {

        $required_attr = "";
        if($required == "1") { $required_attr = "required"; }

        $field = '
            <div class="form-group">
                <label class="">'.__($name).'</label>
                <input type="text" class="form-control" value="'.$value.'" name="customfield['.$id.']" '.$required.'>
                <span class="help-block with-errors messages text-danger"></span>
                <span class="help-block text-muted">'.__($description).'</span>
            </div>
        ';

    }


    if($type == "Text Area") {

        $required_attr = "";
        if($required == "1") { $required_attr = "required"; }

        $field = '
            <div class="form-group">
                <label class="">'.__($name).'</label>
                <textarea name="customfield['.$id.']" class="form-control" '.$required.' >'.$value.'</textarea>
                <span class="help-block with-errors messages text-danger"></span>
                <span class="help-block text-muted">'.__($description).'</span>
            </div>
        ';

    }


    if($type == "Dropdown") {

        $required_attr = "";
        if($required == "1") { $required_attr = "required"; }

        $field = '
            <div class="form-group">
                <label class="">'.__($name).'</label>
                <select class="select2 form-control" name="customfield['.$id.']" required>
                    <option value="">'.__("- Please select -").'</option>

        ';

        $options = explode(',', $options);

        foreach($options as $option) {
            if($option == $value) {
                $field .= '<option value="'.$option.'" selected >'.$option.'</option>';
            } else {
                $field .= '<option value="'.$option.'" >'.$option.'</option>';
            }

        }

        $field .= '
                </select>
                <span class="help-block with-errors messages text-danger"></span>
                <span class="help-block text-muted">'.__($description).'</span>
            </div>
        ';

    }


    return $field;


}


function extract_value($id,$json) {

    $arrray = json_decode($json, true);

    if(isset($arrray[$id])) {
        return html_escape($arrray[$id]);
    } else {
        return "";
    }


}
