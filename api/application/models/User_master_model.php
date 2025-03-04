<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_master_model extends CI_Model
{

    public function user_insert_db($insertData)
    {

        return $this->db->insert('user_master', $insertData);
    }

    public function user_update_db($updateData, $id)
    {

        $email = $updateData['email'];
        $phone = $updateData['phone'];


        $duplicateEmail =   $this->db->where('email', $email);
        $duplicateEmail =    $this->db->where('id !=', $id);
        $duplicateEmail =   $this->db->get('user_master')->num_rows();

        $duplicatePhone =   $this->db->where('phone', $phone);
        $duplicatePhone =    $this->db->where('id !=', $id);
        $duplicatePhone =   $this->db->get('user_master')->num_rows();



        if ($duplicateEmail == 0 &&  $duplicatePhone == 0) {
            $this->db->where('id', $id);
            return  $this->db->update('user_master', $updateData);
        } else {
            return ['duplicateEmail' => $duplicateEmail, 'duplicatePhone' => $duplicatePhone];
        }
    }

    public function user_master_table($liveData)
    {

        $table_value = json_decode($this->table_data->table_controls($liveData));

        $liveDataArray = ['id' => $liveData['id'], 'name' => $liveData['name'], 'email' => $liveData['email'], 'phone' => $liveData['phone']];

        $offset = ($table_value->currentPage - 1) * $table_value->pageLimit;

        // for table records 
        $result = $this->db->order_by($table_value->sortOn, $table_value->sortOrder);
        $result = $this->db->select('id,name,email,phone,image')->from('user_master');
        $result = $this->db->like($liveDataArray);
        $result = $this->db->get('', $table_value->pageLimit, $offset);

        // Number of pages 
        $paginationDb = $this->db->from('user_master');
        $paginationDb = $this->db->like($liveDataArray);
        $paginationDb = $this->db->get();
        $pages = ceil($paginationDb->num_rows() / $table_value->pageLimit);

        $permission = $this->fx->check_permission_of_user();

        return json_encode(['table' => $result->result_array(), 'pagination' => ['totalPages' => $pages, 'current_page_opened' => $table_value->currentPage   ] , 'permission'=>$permission]);
    }

    public function user_master_edit($user_id)
    {


        $this->db->where('id', $user_id);
        $result = $this->db->get('user_master');

        return json_encode($result->row());
    }

    public function user_master_delete($deleteUserId)
    {

        $this->db->where('id', $deleteUserId);
        $result =   $this->db->delete('user_master');
        $result =   $this->db->affected_rows();


        return $result;

    }


}
