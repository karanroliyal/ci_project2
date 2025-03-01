<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_permission_db extends CI_Model{

    public function user_data_db(){


        $data = $this->jwt_token->get_verified_token();
        $loginUserId = $data->id;

        $this->db->where('id !=' , $loginUserId);
        $this->db->select('name , id');
        $result = $this->db->get('user_master');

        return $result;

    }

    public function menu_data_db(){

        $this->db->select('menu_name , id');
        $this->db->where('menu_name , id');
        $result =  $this->db->get('menu');
        return  $result ;

    }

}