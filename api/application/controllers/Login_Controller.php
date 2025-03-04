<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Login_Controller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('login_model');
        // $this
    }

    public function login_check()
    {

        $loginDetails = $_POST;
        $result =  $this->login_model->check_login_db($loginDetails);

        if ($result->row() !== null) {


            $userId = $result->row()->id;

            $menu = $this->login_model->menu_db($userId);

            $jsonData = $result->row();

            $jwtToken = $this->jwt_token->generate_token($jsonData);

            echo json_encode(['statusCode' => 200, 'status' => 'success', 'data' => $result->row(), 'Token' => $jwtToken , 'menu'=> $menu->result_array()]);
            return;
        } else {
            echo json_encode(['statusCode' => 400, 'status' => 'fail']);
            return;
        }
    }
}
