<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginCheckModel extends CI_Model{

    // it checks login details that user have entered
    public function checkLoginDetail($data){

       $q['rows'] =  $this->db->where($data)->get('user_master')->num_rows();

       if($q['rows'] == 1){
        $q['data']=$this->db->where($data)->get('user_master')->result_array();
       }
        
       return $q ;

    }

}



