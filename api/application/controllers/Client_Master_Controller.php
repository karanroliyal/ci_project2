<?php
defined('BASEPATH') or exit('No direct script access allowed');
Header('Access-Control-Allow-Origin: *'); //for allow any domain, insecure
Header('Access-Control-Allow-Headers: *'); //for allow any headers, insecure
Header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE'); //method allowed

class Client_Master_Controller extends CI_Controller{

    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('client_master_model');
    }


    public function insert_client_data()
    {

        $_POST = json_decode($this->input->post('data'), true);

        // unseting all unrequired fileds
        unset($_POST['table']);
        unset($_POST['id']);
        unset($_POST['action']);
        unset($_POST['image']);
        unset($_POST['uploadImage']);

        $fieldsToValidate = [

            [
                'field' => 'NAME',
                'label' => 'Name',
                'rules' => 'required|trim|min_length[2]|regex_match[/^[a-zA-Z ]+$/]'
            ],
            [
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'required|trim|min_length[2]|valid_email|is_unique[client_master.email]'
            ],
            [
                'field' => 'address',
                'label' => 'Address',
                'rules' => 'required|trim'
            ],
            [
                'field' => 'phone',
                'label' => 'Phone',
                'rules' => 'required|trim|min_length[10]|max_length[10]|regex_match[/^[0-9]{10}$/]|is_unique[client_master.phone]'
            ],
            [
                'field' => 'state',
                'label' => 'State',
                'rules' => 'required|trim'
            ],
            [
                'field' => 'district',
                'label' => 'District',
                'rules' => 'required|trim'
            ],
            [
                'field' => 'pincode',
                'label' => 'Pincode',
                'rules' => 'required|trim|min_length[6]|max_length[6]'
            ],


        ];



        $this->form_validation->set_rules($fieldsToValidate);

        if ($this->form_validation->run()) {

            $result = $this->client_master_model->client_insert_db($_POST);

            if ($result) {

                echo json_encode(['statusCode' => 201, 'status' => 'success']);
            } else {

                echo json_encode(['statusCode' => 401, 'status' => 'fail']);
            }
        } else {

            $error = $this->form_validation->error_array();
            echo json_encode(['error' => $error]);
        }
    }

    public function update_client_data()
    {

        $_POST = json_decode($this->input->post('data'), true);

        $userId =   $_POST['id'];

        // unseting all unrequired fileds
        unset($_POST['table']);
        unset($_POST['id']);
        unset($_POST['action']);
        unset($_POST['image']);
        unset($_POST['uploadImage']);
        

        $fieldsToValidate = [

            [
                'field' => 'NAME',
                'label' => 'Name',
                'rules' => 'required|trim|min_length[2]|regex_match[/^[a-zA-Z ]+$/]'
            ],
            [
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'required|trim|min_length[2]|valid_email'
            ],
            [
                'field' => 'address',
                'label' => 'Address',
                'rules' => 'required|trim'
            ],
            [
                'field' => 'phone',
                'label' => 'Phone',
                'rules' => 'required|trim|min_length[10]|max_length[10]|regex_match[/^[0-9]{10}$/]'
            ],
            [
                'field' => 'state',
                'label' => 'State',
                'rules' => 'required|trim'
            ],
            [
                'field' => 'district',
                'label' => 'District',
                'rules' => 'required|trim'
            ],
            [
                'field' => 'pincode',
                'label' => 'Pincode',
                'rules' => 'required|trim|min_length[6]|max_length[6]'
            ],


        ];


        $this->form_validation->set_rules($fieldsToValidate);

        if ($this->form_validation->run()) {

            

            $result = $this->client_master_model->client_update_db($_POST, $userId);


            if ($result == 1) {
                echo json_encode(['statusCode' => 201, 'status' => 'success']);
            } else {
                if ($result['duplicateEmail'] !== 0) {
                    $error = ['error' => 'Email is already in use'];
                    echo  json_encode(['error' => $error]);
                } else {
                    $error = ['error' => 'Phone number is already in use'];
                    echo  json_encode(['error' => $error]);
                }
            }
        } else {

            $error = $this->form_validation->error_array();
            echo json_encode(['error' => $error]);
        }
    }

    public function client_table()
    {

        $_POST = json_decode($this->input->post('data'), true);


        $result = $this->client_master_model->client_master_table($_POST);

        echo $result;
    }

    public function client_edit()
    {

        $userId = $_POST['id'];

        $result =  $this->client_master_model->client_master_edit($userId);

        if ($result !== null) {
            echo $result;
        } else {
            $error = ['error' => 'Invalid id'];
            echo json_encode(['error' => $error]);
        }
    }

    public function client_delete()
    {

        $deleteUserId = $_POST['deleteid'];

        $result =  $this->client_master_model->user_master_delete($deleteUserId);

        if($result !== 0){
            echo json_encode(['statusCode'=>200 , 'status'=>'success']);
        }else{
            $error = ['error'=>'Invalid id'];
            echo json_encode(['statusCode'=>400 , 'status'=>$error]);
        }


    }

    public function state_master_option(){

        $result =  $this->client_master_model->state_data();

        echo json_encode(['state'=>$result]);

    }

    public function district_master_option(){

        $stateId = $_POST['state_id'];

        $result = $this->client_master_model->district_data($stateId);
        echo $result;

    }


}