<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Invoice_Master_Controller extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->model('invoice_master_model');
    }



    public function invoice_table()
    {

        if($this->fx->check_permission_of_user('view_p') == 0){
            echo $this->fx->api_response(403 , 'Forbidden' , '' , "You don't have permission to view any invoice");
            return;
        }

        $_POST = json_decode($this->input->post('data'), true);


        $result = $this->invoice_master_model->invoice_master_table($_POST);

        echo $result;
        return;

    }

    public function client_autocomplete()
    {


        $searchString = $this->input->post();

        $result =  $this->invoice_master_model->client_autocomplete_model($searchString);

        echo  json_encode(['object' => $result]);
        return;

    }


    public function item_autocomplete()
    {

        $searchString = $this->input->post();

        $result =  $this->invoice_master_model->item_autocomplete_model($searchString);

        echo  json_encode(['object' => $result]);
        return;
    }

    public function invoice_edit()
    {

        if($this->fx->check_permission_of_user('update_p') == 0){
            echo $this->fx->api_response(403 , 'Forbidden' , '' , "You don't have permission to edit any invoice");
            return;
        }

        $invoiceId = $_POST['id'];

        $result =  $this->invoice_master_model->invoice_master_edit($invoiceId);

        if ($result !== null) {
            echo $result;
            return;
        } else {
            $error = ['error' => 'Invalid id'];
            echo json_encode(['error' => $error]);
            return;
        }
    }


    public function insert_invoice_data()
    {

        if($this->fx->check_permission_of_user('add_p') == 0){
            echo $this->fx->api_response(403 , 'Forbidden' , '' , "You don't have permission to add any invoice");
            return;
        }

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

            if($result['result']){
                $inserted_id = $result['inserted_id'];
                $_POST['invoice_id'] = $inserted_id;
                $this->fx->user_log_creator('add' , $_POST , 'Invoice master' , $inserted_id);
                echo json_encode(['statusCode'=>201 , 'status'=>'success']);
                return;

            }else{

                echo json_encode(['statusCode'=>401 , 'status'=>'fail']);
                return;

            }
            
        } else {

            $error = $this->form_validation->error_array();

            echo json_encode(['error' => $error]);
            return;
        }
    }

    public function update_invoice_data()
    {

        if($this->fx->check_permission_of_user('update_p') == 0){
            echo $this->fx->api_response(403 , 'Forbidden' , '' , "You don't have permission to edit any invoice");
            return;
        }

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
                $_POST['invoice_id'] = $invoice_id;
                $this->fx->user_log_creator('update' , $_POST , 'Invoice master' , $invoice_id);
                echo json_encode(['statusCode'=>201 , 'status'=>'success']);
                return;

            }else{

                echo json_encode(['statusCode'=>401 , 'status'=>'fail']);
                return;

            }
            
        } else {

            $error = $this->form_validation->error_array();

            echo json_encode(['error' => $error]);
            return;
        }
    }

    public function generate_invoice_number(){


        if($this->fx->check_permission_of_user('add_p') == 0){
            echo $this->fx->api_response(403 , 'Forbidden' , '' , "You don't have permission to add any invoice");
            return;
        }

        $result = $this->invoice_master_model->generate_last_invoice_number();

        echo json_encode($result);
        return;

    }


    public function invoice_mail_to_client(){

        if($this->fx->check_permission_of_user('view_p') == 0){
            echo $this->fx->api_response(403 , 'Forbidden' , '' , "You don't have permission to view any invoice");
            return;
        }

        $clientId = $_POST['client_id'];

        $result = $this->invoice_master_model->client_details_for_mail($clientId);

        echo json_encode($result);
        return;

    }

    public function invoice_master_record_delete(){

        if($this->fx->check_permission_of_user('delete_p') == 0){
            echo $this->fx->api_response(403 , 'Forbidden' , '' , "You don't have permission to delete any invoice");
            return;
        }

        $invoiceId = $_POST['deleteid'];

        // echo $invoiceId;die;

        $result =  $this->invoice_master_model->delete_invoice($invoiceId);

        if($result !== 0){
            $this->fx->user_log_creator('delete' , ['deleted id'=>$invoiceId] , 'Invoice master' , $invoiceId);
            echo json_encode(['statusCode'=>200 , 'status'=>'success']);
            return;
        }else{
            $error = ['error'=>'Invalid id'];
            echo json_encode(['statusCode'=>400 , 'status'=>$error]);
            return;
        }

    }

}
