<?php
defined('BASEPATH') or exit('No direct script access allowed');


class User_permission extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();
        $this->load->model('user_permission_db');
    }


    public function get_user_name()
    {

        $result = $this->user_permission_db->user_data_db();

        $checkData =  json_encode($result->row() == null);

        if ($checkData) {
            echo  $this->fx->api_response(200, true, $result->result_array(), 'User data get successfully');
            return;
        } else {
            echo  $this->fx->api_response(400, false, 'Unable to get user data');
            return;
        }
    }


    public function get_user_permission_data()
    {

        $userId = $_POST['user_id'];

        $result = $this->user_permission_db->user_permission_db($userId);

        if ($result->num_rows() > 0) {
            echo $this->fx->api_response(200, true, $result->result_array(), 'User data is available');
            return;
        } else if ($result->num_rows() == 0) {
            echo $this->fx->api_response(200, true, $result->result_array(), 'User data is not available');
            return;
        } else {
            echo  $this->fx->api_response(400, false, 'error');
            return;
        }

    }


    public function insert_user_permission()
    {

        $selectedUserId = $_POST['user_id'];

        $_POST = json_decode($this->input->post('data'), true);

        $permissionData = $_POST['permission_fields'];

        $result = $this->user_permission_db->insert_user_permission_db($selectedUserId, $permissionData);

        echo $result;
        return;

    }

    public function get_login_user_permission(){

        $result = $this->fx->check_permission_of_user();

        echo $this->fx->api_response(200 , true , $result , 'login user data permission');

    }

    public function user_permission(){

        echo json_encode(['permission'=>$this->fx->check_permission_of_user()]);

    }

}
