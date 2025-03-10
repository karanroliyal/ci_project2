<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Client_Master_Controller extends CI_Controller{

    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('client_master_model');
    }


    public function insert_client_data()
    {

        if($this->fx->check_permission_of_user('add_p') == 0){
            echo $this->fx->api_response(403 , 'Forbidden' , '' , "You don't have permission to add any client");
            return;
        }

        $_POST = json_decode($this->input->post('data'), true);

        // unseting all unrequired fileds
        $_POST = $this->unset_unwanted_data->unset_data($_POST);

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
                $inserted_id = $this->db->insert_id();
                $_POST['id'] = $inserted_id;
                $this->fx->user_log_creator('add' , $_POST , 'Client master' , $inserted_id);
                echo json_encode(['statusCode' => 201, 'status' => 'success']);
                return;
            } else {

                echo json_encode(['statusCode' => 401, 'status' => 'fail']);
                return ;
            }
        } else {

            $error = $this->form_validation->error_array();
            echo json_encode(['error' => $error]);
            return ;
        }
    }

    public function update_client_data()
    {

        if($this->fx->check_permission_of_user('update_p') == 0){
            echo $this->fx->api_response(403 , 'Forbidden' , '' , "You don't have permission to edit any client");
            return;
        }

        $_POST = json_decode($this->input->post('data'), true);

        $userId =   $_POST['id'];

        // unseting all unrequired fileds
        $_POST = $this->unset_unwanted_data->unset_data($_POST);
        

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
                $_POST['id'] = $userId;
                $this->fx->user_log_creator('update' , $_POST , 'Client master' , $userId);
                echo json_encode(['statusCode' => 201, 'status' => 'success']);
            } else {
                if ($result['duplicateEmail'] !== 0) {
                    $error = ['error' => 'Email is already in use'];
                    echo  json_encode(['error' => $error]);
                    return;
                } else {
                    $error = ['error' => 'Phone number is already in use'];
                    echo  json_encode(['error' => $error]);
                    return;
                }
            }
        } else {

            $error = $this->form_validation->error_array();
            echo json_encode(['error' => $error]);
            return;
        }
    }

    public function client_table()
    {

        if($this->fx->check_permission_of_user('view_p') == 0){
            echo $this->fx->api_response(403 , 'Forbidden' , '' , "You don't have permission to view any client");
            return;
        }

        $_POST = json_decode($this->input->post('data'), true);


        $result = $this->client_master_model->client_master_table($_POST);

        echo  $result;
        
        return;

    }

    public function client_edit()
    {

        if($this->fx->check_permission_of_user('update_p') == 0){
            echo $this->fx->api_response(403 , 'Forbidden' , '' , "You don't have permission to edit any client");
            return;
        }

        $userId = $_POST['id'];

        $result =  $this->client_master_model->client_master_edit($userId);

        if ($result !== null) {
            echo $result;
            return;
        } else {
            $error = ['error' => 'Invalid id'];
            echo json_encode(['error' => $error]);
            return;
        }
    }

    public function client_delete()
    {

        if($this->fx->check_permission_of_user('delete_p') == 0){
            echo $this->fx->api_response(403 , 'Forbidden' , '' , "You don't have permission to delete any client");
            return;
        }


        $deleteUserId = $_POST['deleteid'];

        $result =  $this->client_master_model->client_master_delete($deleteUserId);

        if($result !== 0){
            $this->fx->user_log_creator('delete' , ['deleted id'=>$deleteUserId] , 'Client master' , $deleteUserId);
            echo json_encode(['statusCode'=>200 , 'status'=>'success']);
            return;
        }else{
            $error = ['error'=>'Invalid id'];
            echo json_encode(['statusCode'=>400 , 'status'=>$error]);
            return;
        }


    }

    public function state_master_option(){

        $result =  $this->client_master_model->state_data();

        echo json_encode(['state'=>$result]);
        return;

    }

    public function district_master_option(){

        $stateId = $_POST['state_id'];

        $result = $this->client_master_model->district_data($stateId);
        echo $result;
        return;

    }


}