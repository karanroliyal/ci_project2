<?php
defined('BASEPATH') or exit('No direct script access allowed');
Header('Access-Control-Allow-Origin: *'); //for allow any domain, insecure
Header('Access-Control-Allow-Headers: *'); //for allow any headers, insecure
Header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE'); //method allowed


class Invoice_Master_Controller extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->model('invoice_master_model');
    }



    public function invoice_table()
    {

        $_POST = json_decode($this->input->post('data'), true);


        $result = $this->invoice_master_model->invoice_master_table($_POST);

        echo $result;
    }

    public function client_autocomplete()
    {

        $searchString = $this->input->post();

        $result =  $this->invoice_master_model->client_autocomplete_model($searchString);

        echo  json_encode(['object' => $result]);
    }


    public function item_autocomplete()
    {

        $searchString = $this->input->post();

        $result =  $this->invoice_master_model->item_autocomplete_model($searchString);

        echo  json_encode(['object' => $result]);
    }

    public function invoice_edit()
    {

        $invoiceId = $_POST['id'];

        $result =  $this->invoice_master_model->invoice_master_edit($invoiceId);

        if ($result !== null) {
            echo $result;
        } else {
            $error = ['error' => 'Invalid id'];
            echo json_encode(['error' => $error]);
        }
    }


    public function insert_invoice_data()
    {

        $wholePostData = json_decode($this->input->post('data'), true);

        $itemDataForModel = $wholePostData['items_container'];


        unset($wholePostData['items_container']);
        unset($wholePostData['uploadImage']);
        unset($wholePostData['table']);
        unset($wholePostData['action']);
        unset($wholePostData['invoice_id']);

        $clientData = $wholePostData;


        unset($wholePostData['NAME']);
        unset($wholePostData['email']);
        unset($wholePostData['phone']);
        unset($wholePostData['address']);

        $clinetDataForModel = $wholePostData;


        $_POST['client'] = $clientData;
        $_POST['items'] = $itemDataForModel;


        $fields = [
            ['field' => 'client[invoice_number]', 'label' => 'Invoice number', 'rules' => 'required|trim|min_length[3]|max_length[10]|regex_match[/^[a-zA-Z0-9]+$/]|is_unique[invoice_master.invoice_number]'],
            ['field' => 'client[invoice_date]', 'label' => 'Invoice date', 'rules' => 'required'],
            ['field' => 'client[NAME]', 'label' => 'Name', 'rules' => 'required|trim|min_length[3]|max_length[40]|regex_match[/^[a-zA-Z ]+$/]'],
            ['field' => 'client[email]', 'label' => 'Email', 'rules' => 'required|trim|valid_email'],
            ['field' => 'client[phone]', 'label' => 'Phone', 'rules' => 'required|trim|min_length[10]|max_length[10]|regex_match[/^[0-9]{10}$/]'],
            ['field' => 'client[address]', 'label' => 'Address', 'rules' => 'required|trim'],
            ['field' => 'client[client_id]', 'label' => 'Client ID', 'rules' => 'required|trim'],
        ];

        foreach ($itemDataForModel as $index => $item) {
            $fields[] = ['field' => "items[$index][item_id]", 'label' => 'Item ID', 'rules' => 'required|trim|integer'];
            $fields[] = ['field' => "items[$index][item_name]", 'label' => 'Item Name', 'rules' => 'required|trim|min_length[3]|max_length[40]|regex_match[/^[a-zA-Z- ]+$/]'];
            $fields[] = ['field' => "items[$index][item_price]", 'label' => 'Item Price', 'rules' => 'required|trim|regex_match[/^[0-9.]+$/]'];
            $fields[] = ['field' => "items[$index][quantity]", 'label' => 'Quantity', 'rules' => 'required|trim|regex_match[/^[0-9]+$/]'];
            $fields[] = ['field' => "items[$index][amount]", 'label' => 'Item Amount', 'rules' => 'required|trim|regex_match[/^[0-9.]+$/]'];
        }

        $this->form_validation->set_rules($fields);

        if ($this->form_validation->run()) {

            $result =  $this->invoice_master_model->invoice_master_insert_data($itemDataForModel, $clinetDataForModel);

            if($result){

                echo json_encode(['statusCode'=>201 , 'status'=>'success']);

            }else{

                echo json_encode(['statusCode'=>401 , 'status'=>'fail']);

            }
            
        } else {

            $error = $this->form_validation->error_array();

            echo json_encode(['error' => $error]);
        }
    }

    public function update_invoice_data()
    {

        $wholePostData = json_decode($this->input->post('data'), true);

        $itemDataForModel = $wholePostData['items_container'];
        $invoice_id = $wholePostData['invoice_id'];

        // echo $invoice_id;die;


        unset($wholePostData['items_container']);
        unset($wholePostData['uploadImage']);
        unset($wholePostData['table']);
        unset($wholePostData['action']);

        $clientData = $wholePostData;


        unset($wholePostData['NAME']);
        unset($wholePostData['email']);
        unset($wholePostData['phone']);
        unset($wholePostData['address']);

        $clinetDataForModel = $wholePostData;


        $_POST['client'] = $clientData;
        $_POST['items'] = $itemDataForModel;


        $fields = [
            ['field' => 'client[invoice_number]', 'label' => 'Invoice number', 'rules' => 'required|trim|min_length[3]|max_length[10]|regex_match[/^[a-zA-Z0-9]+$/]'],
            ['field' => 'client[invoice_date]', 'label' => 'Invoice date', 'rules' => 'required'],
            ['field' => 'client[invoice_id]', 'label' => 'Invoice id', 'rules' => 'required'],
            ['field' => 'client[NAME]', 'label' => 'Name', 'rules' => 'required|trim|min_length[3]|max_length[40]|regex_match[/^[a-zA-Z ]+$/]'],
            ['field' => 'client[email]', 'label' => 'Email', 'rules' => 'required|trim|valid_email'],
            ['field' => 'client[phone]', 'label' => 'Phone', 'rules' => 'required|trim|min_length[10]|max_length[10]|regex_match[/^[0-9]{10}$/]'],
            ['field' => 'client[address]', 'label' => 'Address', 'rules' => 'required|trim'],
            ['field' => 'client[client_id]', 'label' => 'Client ID', 'rules' => 'required|trim'],
        ];

        foreach ($itemDataForModel as $index => $item) {
            $fields[] = ['field' => "items[$index][item_id]", 'label' => 'Item ID', 'rules' => 'required|trim|integer'];
            $fields[] = ['field' => "items[$index][item_name]", 'label' => 'Item Name', 'rules' => 'required|trim|min_length[3]|max_length[40]|regex_match[/^[a-zA-Z- ]+$/]'];
            $fields[] = ['field' => "items[$index][item_price]", 'label' => 'Item Price', 'rules' => 'required|trim|regex_match[/^[0-9.]+$/]'];
            $fields[] = ['field' => "items[$index][quantity]", 'label' => 'Quantity', 'rules' => 'required|trim|regex_match[/^[0-9]+$/]'];
            $fields[] = ['field' => "items[$index][amount]", 'label' => 'Item Amount', 'rules' => 'required|trim|regex_match[/^[0-9.]+$/]'];
        }

        $this->form_validation->set_rules($fields);

        if ($this->form_validation->run()) {

            $result =  $this->invoice_master_model->invoice_master_update_data($itemDataForModel, $clinetDataForModel , $invoice_id);

            if($result){

                echo json_encode(['statusCode'=>201 , 'status'=>'success']);

            }else{

                echo json_encode(['statusCode'=>401 , 'status'=>'fail']);

            }
            
        } else {

            $error = $this->form_validation->error_array();

            echo json_encode(['error' => $error]);
        }
    }

    public function generate_invoice_number(){

        $result = $this->invoice_master_model->generate_last_invoice_number();

        echo json_encode($result);

    }


    public function invoice_mail_to_client(){

        $clientId = $_POST['client_id'];

        $result = $this->invoice_master_model->client_details_for_mail($clientId);

        echo json_encode($result);

    }

}
