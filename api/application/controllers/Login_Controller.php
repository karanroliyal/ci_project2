<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Login_Controller extends CI_Controller
{

    public function login_check()
    {

        $loginDetails = $_POST;

        $this->load->model('login_model');
        $result =  $this->login_model->check_login_db($loginDetails);

        if($result->row() !== null){
            echo json_encode(['statusCode'=>200 , 'status'=>'success' , 'data'=>$result->row()]);
            return;
        }else{
            echo json_encode(['statusCode'=>400 , 'status'=>'fail']);
            return;
        }
    }
}
