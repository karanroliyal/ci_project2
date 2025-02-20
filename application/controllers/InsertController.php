<?php
defined('BASEPATH') or exit('No direct script access allowed');
Header('Access-Control-Allow-Origin: *'); //for allow any domain, insecure
Header('Access-Control-Allow-Headers: *'); //for allow any headers, insecure
Header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE'); //method allowed
// header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');


class InsertController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
    }

    // for client , user , item
    public function insert()
    {
        if($_FILES){
            $fileData  = $_FILES['image'];
        }
        $postData = json_decode($this->input->post('data'), true);
        // print_r($_FILES);
        // Properly assign the file to $_FILES
        if($_FILES){
            $_FILES['image'] = [
                'name'     => $fileData['name'],
                'type'     => $fileData['type'],
                'tmp_name' => $fileData['tmp_name'],
                'error'    => $fileData['error'],
                'size'     => $fileData['size']
            ];
        }


        // If decoding fails, return an error
        if (!$postData) {
            echo json_encode(['error' => 'Invalid JSON data received']);
            return;
        }

        // Override $_POST with the decoded 'data'
        $_POST = $postData;
        $table_name = $this->input->post('table');

        $this->load->helper('uniqueness');

        $is_unique_email = "";
        $is_unique_phone = "";
        $is_unique_item = "";

        if (isset($_POST['email']) && isset($_POST['phone'])) {

            $is_unique_email = uniqueHelper('email', $table_name, $this->input->post('email'), 'id', $this->input->post('id'));
            $is_unique_phone = uniqueHelper('phone', $table_name, $this->input->post('phone'), 'id', $this->input->post('id'));
        }
        if (isset($_POST['item_name'])) {
            $is_unique_item = uniqueHelper('item_name', $table_name, $this->input->post('item_name'), 'id', $this->input->post('id'));
        }


        // form validation from php
        $fields = [
            [
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'required|trim|min_length[2]|regex_match[/^[a-zA-Z ]+$/]'
            ],
            [
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'required|trim|valid_emails' . $is_unique_email,
                "errors" => [
                    'is_unique' => 'The %s is already exist.',
                ],
            ],
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'min_length[8]|max_length[15]',
            ],
            [
                'field' => 'phone',
                'label' => 'Phone number',
                'rules' => 'required|trim|exact_length[10]|numeric' . $is_unique_phone,
                "errors" => [
                    'is_unique' => 'The %s is already exist.',
                ],
            ],
            //    [
            //        'field' => 'pincode',
            //        'label' => 'Pincode',
            //        'rules' => 'required|trim|max_length[6]|numeric',
            //    ],
            //    [
            //        'field' => 'state',
            //        'label' => 'State',
            //        'rules' => 'required|trim|numeric',
            //    ],
            //    [
            //        'field' => 'district',
            //        'label' => 'District',
            //        'rules' => 'required|trim|numeric',
            //    ],
            //    [
            //        'field' => 'address',
            //        'label' => 'Address',
            //        'rules' => 'required|trim',
            //    ],
            //    [
            //        'field' => 'gender[]',
            //        'label' => 'Gender',
            //        'rules' => 'required|trim'
            //    ],
            //    [
            //        'field' => 'languages[]',
            //        'label' => 'Languages',
            //        'rules' => 'required|trim'
            //    ],
            //    [
            //        'field' => 'item_name',
            //        'label' => 'Item name',
            //        'rules' => 'required|trim|min_length[2]|regex_match[/^[a-zA-Z- ]+$/]'.$is_unique_item,
            //        "errors" => [
            //            'is_unique' => 'Item is already exist.',
            //        ],
            //    ],
            //    [
            //        'field' => 'item_description',
            //        'label' => 'Item description',
            //        'rules' => 'required|trim|min_length[2]'
            //    ],
            //    [
            //        'field' => 'item_price',
            //        'label' => 'Item price',
            //        'rules' => 'required|trim|numeric'
            //    ],
            //    [
            //        'field' => 'total_amount',
            //        'label' => 'Total amount',
            //        'rules' => 'required|trim|numeric'
            //    ],

        ];




        // validation for image
        if (!isset($_FILES)) {
            if (empty($_FILES['image']['name'])) {
                $this->form_validation->set_rules("image", "Image", 'required');
                array_push($keys, 'image');
                array_push($values, form_error('image'));
            }
        }

        // setting rules for form here 
        $this->form_validation->set_rules($fields);

        // If All things in form are correct it goes here 
        if ($this->form_validation->run()) {

            // Uploading image here 
            if (isset($_POST['uploadImage'])) {
                $path = $_POST['uploadImage'];
                // image configration
                $config['upload_path'] = $path;
            }

            $config['allowed_types'] = 'jpg|png|gif|jpeg';
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);

            // images uploading here
            if (!$this->upload->do_upload('image') && !$this->input->post('action') == "update" &&  isset($_POST['uploadImage'])) {
                if (!empty($_FILES['image']['name'])) {
                    $error = $this->upload->display_errors();
                    echo json_encode(['imageError' => $error, 'fields' => 'image']);
                }
            } else {

                // getting form data
                $postData = $this->input->post();
                if (!empty($_FILES['image']['name'])) {
                    $imageData = $this->upload->data(); // getting image all data 
                    $postData['image'] = $imageData['file_name']; // getting file name
                }
                $this->load->model('insertmodel');
                if ($this->input->post('action') == "update") {
                    unset($postData['uploadImage']);
                    unset($postData['action']);
                    if (isset($postData['password']) && empty(trim($postData['password']))) {
                        unset($postData['password']);
                    }
                    $modelData = $this->insertmodel->update($postData);
                    echo $modelData;
                } else {
                    $modelData = $this->insertmodel->insert($postData);
                    echo $modelData;
                }
            }
        }
        // throwing error on frontend 
        else {
            $error = $this->form_validation->error_array();
            echo json_encode(['error' => $error]);
        }
    }

    // for invoice master only
    public function insertInvoice()
    {

        $this->load->helper('uniqueness');

        $is_unique_invoice_number = uniqueHelper('invoice_number', 'invoice_master', $this->input->post('invoice_number'), 'invoice_id', $this->input->post('invoice_id'));

        $validation = [

            [
                'field' => 'invoice_number',
                'label' => 'Invoice number',
                'rules' => 'required|trim|min_length[2]|regex_match[/^[a-zA-Z0-9]+$/]' . $is_unique_invoice_number
            ],
            [
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'required|trim|min_length[2]|regex_match[/^[a-zA-Z ]+$/]'
            ],
            [
                'field' => 'phone',
                'label' => 'Phone',
                'rules' => 'required|trim|max_length[10]|regex_match[/^[0-9]+$/]'
            ],
            [
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'required|trim|valid_emails'
            ],
            [
                'field' => 'address',
                'label' => 'Address',
                'rules' => 'required|trim',
            ],
            [
                'field' => 'total_amount',
                'label' => 'Total amount',
                'rules' => 'required|trim|numeric',
            ],


        ];

        $this->form_validation->set_rules($validation);

        if ($this->form_validation->run()) {

            $formData = $this->input->post();

            if (isset($formData['action'])) {

                $this->load->model('insertmodel');
                echo $this->insertmodel->updateInvoice($formData);
            } else {

                $this->load->model('insertmodel');
                echo $this->insertmodel->insertInvoice($formData);
            }
        } else {

            $errors = $this->form_validation->error_array();

            echo json_encode(['errors' => $errors]);
        }
    }

    // for generating invoice number
    public function generateInvoice()
    {

        // echo "hello ji i am here";

        $this->load->model('insertmodel');
        $result = $this->insertmodel->generateInvoiveNumber();

        echo $result;
    }

    // Edit button 
    public function edit()
    {
        $data = $this->input->post();
        $this->load->model('insertmodel');
        $data_from_model = $this->insertmodel->edit_data($data);
        echo $data_from_model;
    }
}
