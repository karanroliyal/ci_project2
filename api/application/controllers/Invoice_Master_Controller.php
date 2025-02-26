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



    public function client_autocomplete(){

        $searchString = $this->input->post();

        echo $this->invoice_master_model->client_autocomplete_model($searchString);
        
    }
    public function item_autocomplete(){
        
        $searchString = $this->input->post();

        echo $this->invoice_master_model->item_autocomplete_model($searchString);

    }



}
