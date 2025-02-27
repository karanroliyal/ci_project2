<?php
defined('BASEPATH') or exit('No direct script access allowed');
Header('Access-Control-Allow-Origin: *'); //for allow any domain, insecure
Header('Access-Control-Allow-Headers: *'); //for allow any headers, insecure
Header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE'); //method allowed


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
    }


    public function insert_user_data()
    {

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

            // echo 'Validated';

            

            if ($this->upload->do_upload('image')) {

                $imageData = $this->upload->data(); // getting image all data 
                $_POST['image'] = $imageData['file_name'];
            } else {
                $error = $this->upload->display_errors();

                $error = json_encode(['error' => 'Ivalid image format']);

                echo   json_encode(['error' => $error]);
                die;
            }

            $result = $this->user_master_model->user_insert_db($_POST);

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

    public function update_user_data()
    {

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
                    die;
                }
            }

            $result = $this->user_master_model->user_update_db($_POST, $userId);

            // echo $result ; die;

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

    public function user_table()
    {

        $_POST = json_decode($this->input->post('data'), true);


        $result = $this->user_master_model->user_master_table($_POST);

        echo $result;
    }

    public function user_edit()
    {

        $userId = $_POST['id'];

        $result =  $this->user_master_model->user_master_edit($userId);

        if ($result !== null) {
            echo $result;
        } else {
            $error = ['error' => 'Invalid id'];
            echo json_encode(['error' => $error]);
        }
    }

    public function user_delete()
    {

        $deleteUserId = $_POST['deleteid'];

        $result =  $this->user_master_model->user_master_delete($deleteUserId);

        if($result !== 0){
            echo json_encode(['statusCode'=>200 , 'status'=>'success']);
        }else{
            $error = ['error'=>'Invalid id'];
            echo json_encode(['statusCode'=>400 , 'status'=>$error]);
        }


    }


}
