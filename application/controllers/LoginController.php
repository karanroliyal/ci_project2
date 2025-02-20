<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LoginController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('form');
    }

    public function index()
    {
        $this->load->view('login');
    }

    // after coming form js validation for login
    public function success()
    {
        $inputFieldsValidation = [
            [
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'required|trim'
            ],
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required|trim'
            ],
        ];

        $this->form_validation->set_rules($inputFieldsValidation);

        if($this->form_validation->run()){

            // getting data of form after validation from js
            $post = $this->input->post();
    
            // calling model for login details check
            $this->load->model('logincheckmodel');
            $result = $this->logincheckmodel->checklogindetail($post);
    
            // setting users session here 
            if ($result['rows'] == 1) {
                $this->session->set_userdata($result['data'][0]);
            }
    
            echo $result['rows'];

        }
        else{

            echo 11;
            
        }
    }

    public function logout(){

        if(session_destroy()){
            echo "success";
        }



    }
}
