<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Item_Master_Controller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('item_master_model');
        // Uploading image here 
        $config['upload_path'] = './items';
        $config['allowed_types'] = 'jpg|png|gif|jpeg';
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload', $config);
        $this->jwt_token->get_verified_token();
    }

    public function insert_item_data()
    {

        $fileData  = $_FILES['image'];

        $_POST = json_decode($this->input->post('data'), true);


        // unseting all unrequired fileds
        $_POST = $this->unset_unwanted_data->unset_data($_POST);


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
                'field' => 'item_name',
                'label' => 'Item name',
                'rules' => 'required|trim|min_length[2]|regex_match[/^[a-zA-Z- ]+$/]|is_unique[item_master.item_name]'
            ],
            [
                'field' => 'item_description',
                'label' => 'Item description',
                'rules' => 'required|trim'
            ],
            [
                'field' => 'item_price',
                'label' => 'Item price',
                'rules' => 'required|trim|regex_match[/^[0-9.]+$/]'
            ]


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

            $result = $this->item_master_model->item_insert_db($_POST);

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

    public function update_item_data()
    {

        if ($_FILES) {
            $fileData  = $_FILES['image'];
        }

        $_POST = json_decode($this->input->post('data'), true);

        $userId =   $_POST['id'];

        // unseting all unrequired fileds
        $_POST = $this->unset_unwanted_data->unset_data($_POST);

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
                'field' => 'item_name',
                'label' => 'Item name',
                'rules' => 'required|trim|min_length[2]|regex_match[/^[a-zA-Z- ]+$/]'
            ],
            [
                'field' => 'item_description',
                'label' => 'Item description',
                'rules' => 'required|trim'
            ],
            [
                'field' => 'item_price',
                'label' => 'Item price',
                'rules' => 'required|trim|regex_match[/^[0-9.]+$/]'
            ]


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

            $result = $this->item_master_model->item_update_db($_POST, $userId);


            if ($result == 1) {
                echo json_encode(['statusCode' => 201, 'status' => 'success']);
                return;
            } else {
                if ($result['dupliacteItem'] !== 0) {
                    $error = ['error' => 'Item is already exists'];
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

    public function item_table()
    {

        $_POST = json_decode($this->input->post('data'), true);

        $result = $this->item_master_model->item_master_table($_POST);

        echo $result;
        return;

    }

    public function item_edit()
    {

        $userId = $_POST['id'];

        $result =  $this->item_master_model->item_master_edit($userId);

        if ($result !== null) {
            echo $result;
            return;
        } else {
            $error = ['error' => 'Invalid id'];
            echo json_encode(['error' => $error]);
            return;
        }
    }

    public function item_delete()
    {

        $deleteUserId = $_POST['deleteid'];

        $result =  $this->item_master_model->item_master_delete($deleteUserId);

        if ($result !== 0) {
            echo json_encode(['statusCode' => 200, 'status' => 'success']);
            return;
        } else {
            $error = ['error' => 'Invalid id'];
            echo json_encode(['statusCode' => 400, 'status' => $error]);
            return;
        }
    }

    
}
