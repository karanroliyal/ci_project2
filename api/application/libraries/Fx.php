<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Fx
{

    protected $CI;

    public function __construct()
    {
        // Get CodeIgniter instance
        $this->CI = &get_instance();
        // Load the JWT Library
        $this->CI->load->library('Jwt_token'); // Ensure the library file is named correctly
    }

    public function api_response($statusCode, $status, $data, $message)
    {


        if ($statusCode == 200) {

            return json_encode(['statusCode' => $statusCode, 'status' => $status, 'data' => $data, 'message' => $message]);
        } else {

            return json_encode(['statusCode' => $statusCode, 'status' => $status, 'message' => $message]);
        }
    }

    // check permission for login user
    public function check_permission_of_user()
    {
        $path_of_frontend = $this->CI->input->get_request_header('myurl');

        $user_id = $this->CI->jwt_token->get_verified_token();
        $user_id = $user_id->id;

        //    $result =  $this->CI->db->get('user_master')->row();

        $permissionDb = $this->CI->db->select('
            m.menu_name ,
            m.menu_priority , 
            up.user_id , 
            m.route,
            IFNULL(up.add_p , 0) as add_p , 
            IFNULL(up.delete_p , 0) as delete_p , 
            IFNULL(up.update_p , 0) as update_p, 
            IFNULL(up.view_p , 0) as view_p
        ');


        $permissionDb = $this->CI->db->from('menu m');
        $permissionDb = $this->CI->db->join('user_permission up', 'm.id = up.menu_id');
        $permissionDb = $this->CI->db->where('up.user_id' , $user_id);
        $permissionDb = $this->CI->db->where('m.route' , $path_of_frontend);
        $permissionDb =  $this->CI->db->get()->row();

        return [
            'edit_permission'=>$permissionDb->update_p,
            'delete_permission'=>$permissionDb->delete_p,
            'view_permission'=>$permissionDb->view_p,
            'add_permission'=>$permissionDb->add_p,
        ];
    }
}
