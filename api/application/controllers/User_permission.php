<?php
defined('BASEPATH') or exit('No direct script access allowed');


class User_permission extends CI_Controller{

    public function __construct(){

    parent::__construct();
    $this->jwt_token->get_verified_token();
    $this->load->model('user_permission_db');

    }


    public function get_user_name(){

        $result = $this->user_permission_db->user_data_db();

        $checkData =  json_encode($result->row() == null);

        if($checkData){
           echo  $this->fx->api_response(200 , true , $result->result_array() , 'User data get successfully' );
            return;
        }else{
           echo  $this->fx->api_response(400 , false ,'Unable to get user data');
            return;
        }

    }

    public function get_menu_data(){

        $result = $this->user_permission_db->menu_data_db();

        $checkData =  json_encode($result->row() == null);

        if($checkData){
            echo  $this->fx->api_response(200 , true , $result->result_array() , 'Menu data get successfully' );
            return;
        }else{
           echo  $this->fx->api_response(400 , false ,'Unable to get menu data');
            return;
        }

    }


}