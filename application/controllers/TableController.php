<?php
defined('BASEPATH') or exit('No direct script access allowed');
Header('Access-Control-Allow-Origin: *'); //for allow any domain, insecure
Header('Access-Control-Allow-Headers: *'); //for allow any headers, insecure
Header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE'); //method allowed

class TableController extends CI_Controller{

    public function __construct(){
        parent::__construct();
    }

    public function index(){

        // $livedata = $this->input->post();
        $livedata = file_get_contents("php://input");
        $livedata = json_decode($livedata, TRUE);

        $this->load->model('tablemodel');

        $modelData = $this->tablemodel->createTable($livedata);

        echo $modelData;

    }

    public function delete(){

        $deleteData = $this->input->post();

        $this->load->model('tablemodel');

        echo $this->tablemodel->delete($deleteData);

    }

    public function dashboardData(){

        $this->load->model('tablemodel');
        echo $this->tablemodel->dashboardFunction();
        

    }

}