<?php

use SebastianBergmann\Environment\Console;

defined('BASEPATH') or exit('No direct script access allowed');

class User_permission_db extends CI_Model
{

    public function user_data_db()
    {


        $data = $this->jwt_token->get_verified_token();
        $loginUserId = $data->id;

        $this->db->where('id !=', $loginUserId);
        $this->db->select('name , id');
        $result = $this->db->get('user_master');

        return $result;
    }

    public function user_permission_db($userId)
    {

        $this->db->select('
        m.id , 
        m.menu_name ,
         m.menu_priority , 
         up.user_id , 
         IFNULL(up.add_p , 0) as add_p , 
         IFNULL(up.delete_p , 0) as delete_p , 
         IFNULL(up.update_p , 0) as update_p, 
         IFNULL(up.view_p , 0) as view_p
         ');
        $this->db->from('menu m');
        $this->db->join('user_permission up', 'm.id = up.menu_id AND up.user_id = ' . $this->db->escape($userId), 'left');
        $result = $this->db->get();

        return $result;
    }


    public function insert_user_permission_db($userId , $permissionData){

        $this->db->where('user_id' , $userId );
        
        if($this->db->delete('user_permission')){
           
            foreach($permissionData as $value){

                unset($value['menu_name']);
                $result = $this->db->insert('user_permission',$value);

            }

            return $result;

        }

    }


}
