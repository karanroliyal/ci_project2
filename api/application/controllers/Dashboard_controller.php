<?php

// use SebastianBergmann\Environment\Console;

defined('BASEPATH') or exit('No direct script access allowed');
Header('Access-Control-Allow-Origin: * '); //for allow any domain, insecure
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization, Token');
Header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE'); //method allowed

class Dashboard_controller extends CI_Controller{


    public function __construct()
    {
        parent::__construct();  

        $this->load->model('dashboard_model');
        $this->jwt_token->get_verified_token();
    
    }

    public function user_master_total_users(){
        $result = $this->dashboard_model->users_count();

        if($result){
            echo json_encode($result->row());
            return;
        }else{
            echo json_encode(['statusCode'=>400]);
            return;
        }

    }

    public function client_master_total_clients(){

        $result = $this->dashboard_model->client_count();

        if($result){
            echo json_encode($result->row());
            return;
        }else{
            echo json_encode(['statusCode'=>400]);
            return;
        }

    }

    public function item_master_total_items(){

        $result = $this->dashboard_model->item_count();

        if($result){
            echo json_encode($result->row());
            return;
        }else{
            echo json_encode(['statusCode'=>400]);
            return;
        }

    }

    public function invoice_master_total_sales(){

        $result = $this->dashboard_model->invoice_total_amount();

        if($result){
            echo json_encode($result->row());
            return;
        }else{
            echo json_encode(['statusCode'=>400]);
            return;
        }

    }

}