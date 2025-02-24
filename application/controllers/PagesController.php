<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PagesController extends CI_Controller{

    public function index(){

        $this->load->view('dashboard');

    }
    public function usermaster(){

        $this->load->view('user');

    }
    public function clientmaster(){

        $this->load->view('client');

    }
    public function itemmaster(){

        $this->load->view('item');

    }
    public function invoice(){

        $this->load->view('invoice');

    }
    public function sessionControl(){

        // $this->load->view('index');

    }


}













