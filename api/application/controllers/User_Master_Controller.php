<?php
defined('BASEPATH') or exit('No direct script access allowed');


class User_Master_Controller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_master_model');
        // Uploading image here 
        $config['upload_path'] = './profiles';
        $config['allowed_types'] = 'jpg|png|gif|jpeg';
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload', $config);
        $this->jwt_token->get_verified_token();
    }

    public function insert_user_data()
    {

        $permission = $this->fx->check_permission_of_user()['add_permission'];

        if($permission == 0){
            echo $this->fx->api_response(403 , 'Forbidden' , '' , "You don't have permission to add any user");
            return;
        }

        $fileData  = $_FILES['image'];

        $_POST = json_decode($this->input->post('data'), true);


        // unseting all unrequired fileds
        unset($_POST['table']);
        unset($_POST['id']);
        unset($_POST['action']);
        unset($_POST['image']);
        unset($_POST['uploadImage']);


        // getting image data into $Files

        $_FILES['image'] = [
            'name'     => $fileData['name'],
            'type'     => $fileData['type'],
            'tmp_name' => $fileData['tmp_name'],
            'error'    => $fileData['error'],
            'size'     => $fileData['size']
        ];


        $fieldsToValidate = [

            [
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'required|trim|min_length[2]|regex_match[/^[a-zA-Z ]+$/]'
            ],
            [
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'required|trim|min_length[2]|valid_email|is_unique[user_master.email]'
            ],
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required|trim|min_length[8]|max_length[15]|regex_match[/^(?=.*\d)(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z]).{8,}$/]'
            ],
            [
                'field' => 'phone',
                'label' => 'Phone',
                'rules' => 'required|trim|min_length[10]|max_length[10]|regex_match[/^[0-9]{10}$/]|is_unique[user_master.phone]'
            ],


        ];


        // Image files validation
        if (empty($_FILES['image']['name'])) {

            $this->form_validation->set_rules("image", "Image", 'required');

        }


        $this->form_validation->set_rules($fieldsToValidate);

        if ($this->form_validation->run()) {


            if ($this->upload->do_upload('image')) {

                $imageData = $this->upload->data(); // getting image all data 
                $_POST['image'] = $imageData['file_name'];
                
            } else {
                $error = $this->upload->display_errors();

                $error = json_encode(['error' => 'Ivalid image format']);

                echo   json_encode(['error' => $error]);
                return;
            }

            $result = $this->user_master_model->user_insert_db($_POST);

            if ($result) {

                echo json_encode(['statusCode' => 201, 'status' => 'success']);
                return;
            } else {

                echo json_encode(['statusCode' => 401, 'status' => 'fail']);
                return;
            }
        } else {

            $error = $this->form_validation->error_array();
            echo json_encode(['error' => $error]);
            return;
        }
    }

    public function update_user_data()
    {

        $permission = $this->fx->check_permission_of_user()['edit_permission'];

        if($permission == 0){
            echo $this->fx->api_response(403 , 'Forbidden' , '' , "You don't have permission to edit any user");
            return;
        }

        if ($_FILES) {
            $fileData  = $_FILES['image'];
        }

        $_POST = json_decode($this->input->post('data'), true);

        $userId =   $_POST['id'];

        // unseting all unrequired fileds
        unset($_POST['table']);
        unset($_POST['id']);
        unset($_POST['action']);
        unset($_POST['image']);
        unset($_POST['uploadImage']);
        if (empty(trim($_POST['password']))) {
            unset($_POST['password']);
        }

        // getting image data into $Files
        if ($_FILES) {
            $_FILES['image'] = [
                'name'     => $fileData['name'],
                'type'     => $fileData['type'],
                'tmp_name' => $fileData['tmp_name'],
                'error'    => $fileData['error'],
                'size'     => $fileData['size']
            ];
        }


        $fieldsToValidate = [

            [
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'required|trim|min_length[2]|regex_match[/^[a-zA-Z ]+$/]'
            ],
            [
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'required|trim|min_length[2]|valid_email'
            ],
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'min_length[8]|max_length[15]|regex_match[/^(?=.*\d)(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z]).{8,}$/]'
            ],
            [
                'field' => 'phone',
                'label' => 'Phone',
                'rules' => "required|trim|min_length[10]|max_length[10]|regex_match[/^[0-9]{10}$/]"
            ],


        ];



        $this->form_validation->set_rules($fieldsToValidate);

        if ($this->form_validation->run()) {


            if ($_FILES) {
                if ($this->upload->do_upload('image')) {

                    $imageData = $this->upload->data(); // getting image all data 
                    $_POST['image'] = $imageData['file_name'];
                } else {
                    $error = $this->upload->display_errors();

                    $error = ['error' => 'Invalid image format'];

                    echo   json_encode(['error' => $error]);
                    return;
                }
            }

            $result = $this->user_master_model->user_update_db($_POST, $userId);

            // echo $result ; die;

            if ($result == 1) {
                echo json_encode(['statusCode' => 201, 'status' => 'success']);
                return;
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

    public function user_table()
    {

        $permission = $this->fx->check_permission_of_user()['view_permission'];

        if($permission == 0){
            echo $this->fx->api_response(403 , 'Forbidden' , '' , "You don't have permission to view user table");
            return;
        }

        $_POST = json_decode($this->input->post('data'), true);


        $result = $this->user_master_model->user_master_table($_POST);

        echo $result;
        return;

    }

    public function user_edit()
    {

        $permission = $this->fx->check_permission_of_user()['edit_permission'];


        if($permission == 0){
            echo $this->fx->api_response(403 , 'Forbidden' , '' , "You don't have permission to edit any user");
            return;
        }

        $userId = $_POST['id'];

        $result =  $this->user_master_model->user_master_edit($userId);

        if ($result !== null) {
            echo $result;
            return;
        } else {
            $error = ['error' => 'Invalid id'];
            echo json_encode(['error' => $error]);
            return;
        }
    }

    public function user_delete()
    {

        $permission = $this->fx->check_permission_of_user()['delete_permission'];

        if($permission == 0){
            echo $this->fx->api_response(403 , 'Forbidden' , '' , "You don't have permission to delete any user");
            return;
        }

        $deleteUserId = $_POST['deleteid'];

        $result =  $this->user_master_model->user_master_delete($deleteUserId);

        if($result !== 0){
            echo json_encode(['statusCode'=>200 , 'status'=>'success']);
            return;
        }else{
            $error = ['error'=>'Invalid id'];
            echo json_encode(['statusCode'=>400 , 'status'=>$error]);
            return;
        }


    }


}
