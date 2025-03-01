<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller{

    public function __construct(){

        parent::__construct();
        $this->jwt_token->get_verified_token();
        $this->load->model('Menu_db');

    }

    public function get_menu(){

        $result = $this->Menu_db->get_menu_db();

        $bool =  json_encode($result->row() == null);

        
        if($bool){
            
            echo json_encode(['statusCode'=>200 , 'status'=> 'success' , 'data'=> $result->result_array()]);
            return;

        }else{

            echo json_encode(['statusCode'=>400 , 'status'=> 'success' , 'data'=> $result->result_array()]);
            return;
        }


    }

}












?>