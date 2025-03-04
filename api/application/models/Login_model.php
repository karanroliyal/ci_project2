<?php


class Login_model extends CI_Model{

public function check_login_db($loginDetails){


    $this->db->where($loginDetails);
    $result = $this->db->get('user_master');
    return $result;


}


public function menu_db($userId){

    $this->db->select(' menu_name , route , icon_class , menu_priority ');
    $this->db->from('user_permission');
    $this->db->join('menu' , 'menu.id = user_permission.menu_id');
    $this->db->where('view_p' , 1);
    $this->db->where('user_id' , $userId);
    $menu = $this->db->get('');

    return $menu;

}

}

