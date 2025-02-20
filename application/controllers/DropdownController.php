<?php
defined('BASEPATH') or exit('No direct script access allowed');


class DropdownController extends CI_Controller{

    // client auto complete
    public function client_autocomplete(){

        $searchString = $this->input->post();

        $this->load->model('dropdownmodel');

        echo $this->dropdownmodel->client($searchString);
        

    }

    // item auto complete
    public function item_autocomplete(){

        $searchString = $this->input->post();

        $this->load->model('dropdownmodel');

        echo $this->dropdownmodel->item($searchString);

    }

    // district 
    public function district(){

        $state_id = $this->input->post();
        $this->load->model('dropdownmodel');
        echo $this->dropdownmodel->district($state_id);

    }

}