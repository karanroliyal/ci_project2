<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Client_master_model extends CI_Model
{

    public function client_insert_db($insertData)
    {

        return $this->db->insert('client_master', $insertData);
    }

    public function client_update_db($updateData, $id)
    {

        $email = $updateData['email'];
        $phone = $updateData['phone'];


        $duplicateEmail =   $this->db->where('email', $email);
        $duplicateEmail =    $this->db->where('id !=', $id);
        $duplicateEmail =   $this->db->get('client_master')->num_rows();

        $duplicatePhone =   $this->db->where('phone', $phone);
        $duplicatePhone =    $this->db->where('id !=', $id);
        $duplicatePhone =   $this->db->get('client_master')->num_rows();



        if ($duplicateEmail == 0 &&  $duplicatePhone == 0) {
            $this->db->where('id', $id);
            return  $this->db->update('client_master', $updateData);
        } else {
            return ['duplicateEmail' => $duplicateEmail, 'duplicatePhone' => $duplicatePhone];
        }
    }

    public function client_master_table($liveData)
    {
        
        $table_value = json_decode($this->table_data->table_controls($liveData));


        $liveDataArray = ['id' => $liveData['id'], 'NAME' => $liveData['NAME'], 'email' => $liveData['email'], 'phone' => $liveData['phone']];

        $offset = ($table_value->currentPage - 1) * $table_value->pageLimit;

        // for table records 
        $result = $this->db->order_by($table_value->sortOn, $table_value->sortOrder);
        $result = $this->db->select('id,NAME,email,phone,concat_ws(" , ", address , sm.state_name , dm.district_name) as address,pincode ')->from('client_master');
        $result = $this->db->like($liveDataArray);
        $result = $this->db->join('state_master sm', 'client_master.state = sm.state_id');
        $result = $this->db->join('district_master dm', 'client_master.district = dm.district_id');
        $result = $this->db->get('', $table_value->pageLimit, $offset);


        // Number of pages 
        $paginationDb = $this->db->from('client_master');
        $paginationDb = $this->db->like($liveDataArray);
        $paginationDb = $this->db->get();
        $pages = ceil($paginationDb->num_rows() / $table_value->pageLimit);

        return json_encode(['table' => $result->result_array(), 'pagination' => ['totalPages' => $pages, 'current_page_opened' => $table_value->currentPage]]);
    }

    public function client_master_edit($user_id)
    {


        $this->db->where('id', $user_id);
        $result = $this->db->get('client_master');

        return json_encode($result->row());
    }

    public function client_master_delete($deleteUserId)
    {

        $this->db->where('id', $deleteUserId);
        $result =   $this->db->delete('client_master');
        $result =   $this->db->affected_rows();


        return $result;
    }

    public function state_data()
    {

        $this->db->select('state_id , state_name');
        $result =  $this->db->get('state_master');

        return $result->result_array();
    }

    public function district_data($state_id)
    {

        $this->db->select('district_id , district_name');
        $this->db->where('state_id',$state_id);
        $result =  $this->db->get('district_master');

        return json_encode(['district_options' => $result->result_array()]);
    }
}
