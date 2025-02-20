<?php
defined('BASEPATH') or exit('No direct script access allowed');

function uniqueHelper($fieldName , $table_name , $value_check_duplicate , $unique_field , $unique_val   ){


    $CI =& get_instance();

    if ($CI->input->post('action') == "update") {
        $CI->db->select('*');
        $CI->db->from($table_name);
        $CI->db->where($fieldName, $value_check_duplicate );
        $CI->db->where($unique_field.'!=', $unique_val);
        $query = $CI->db->get()->num_rows();

        if ($query > 0) {
           return $is_unique =  '|is_unique[' . $table_name . '.'.$fieldName.']';
        } else {
            return $is_unique = "";
        }
    } else {
       return $is_unique = '|is_unique[' . $table_name . '.'.$fieldName.']';
    }

}