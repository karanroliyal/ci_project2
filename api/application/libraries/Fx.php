<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Fx
{

    protected $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->library('Jwt_token');
        if($this->CI->uri->segment(2) !== 'login_check'){
            $this->CI->jwt_token->get_verified_token();
            $this->api_log_creator($_POST , current_url()  );
        };
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
    public function check_permission_of_user($default="")
    {
        $path_of_frontend = $this->CI->input->get_request_header('myurl');

        $user_id = $this->CI->jwt_token->get_verified_token();
        $user_id = $user_id->id;

        //    $result =  $this->CI->db->get('user_master')->row();

        $permissionDb = $this->CI->db->select('
            IFNULL(up.add_p , 0) as add_p , 
            IFNULL(up.delete_p , 0) as delete_p , 
            IFNULL(up.update_p , 0) as update_p, 
            IFNULL(up.view_p , 0) as view_p
        ');


        $permissionDb = $this->CI->db->from('menu m');
        $permissionDb = $this->CI->db->join('user_permission up', 'm.id = up.menu_id');
        $permissionDb = $this->CI->db->where('up.user_id', $user_id);
        $permissionDb = $this->CI->db->where('m.route', $path_of_frontend);
        $permissionDb = $this->CI->db->get()->row();

        if($default == ''){
            return [
                'edit_permission' => $permissionDb->update_p,
                'delete_permission' => $permissionDb->delete_p,
                'view_permission' => $permissionDb->view_p,
                'add_permission' => $permissionDb->add_p,
            ];
        }else{

            return $default = $permissionDb->$default;

        }

    }

    // user log function
    public function user_log_creator($action, $data , $action_table , $action_id )
    {
        $path_of_frontend = $this->CI->input->get_request_header('myurl');
        $user_data = $this->CI->jwt_token->get_verified_token();

        $user_id = $user_data->id;
        $user_name = $user_data->name;
        $data = json_encode($data);
        $message = '';

        if ($action == 'add') {
            $message = "$user_name (id : $user_id) added  id ($action_id) on $action_table table";
        } else if ($action == 'update') {
            $message = "$user_name (id : $user_id) updated id ($action_id) on $action_table table";
        } else if ($action == 'delete') {
            $message = "$user_name (id : $user_id) deleted id ($action_id) on $action_table table";
        }else if($action == 'call'){
            $message = "$user_name (id : $user_id) called this api : {$_SERVER['PHP_SELF']} on $action_table table";
        }

        $lastSegment = basename($path_of_frontend); 
        $menu_name = str_replace("-", " ", $lastSegment); 


        $insert_data = [
            'user_id' => $user_id,
            'page_name' => $menu_name,
            'action_performed' => $action,
            'data' => $data,
            'action_table' => $action_table,
            'message' => $message
        ];

        $this->CI->db->insert('user_log', $insert_data);

    }

    // api log function
    public function api_log_creator($data , $api){

        $user_data = $this->CI->jwt_token->get_verified_token();

        $insert_data = [

            'user_id'=>$user_data->id,
            'user_name'=>$user_data->name,
            'data'=>json_encode($data),
            'api'=> $api

        ];

        $this->CI->db->insert('api_log' , $insert_data);

    }


}
