<?php


class Login_model extends CI_Model{

public function check_login_db($loginDetails){


    $this->db->where($loginDetails);

    $result = $this->db->get('user_master');

    return $result;


}

}

