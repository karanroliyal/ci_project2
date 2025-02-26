<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Item_master_model extends CI_Model
{

    public function item_insert_db($insertData)
    {

        return $this->db->insert('item_master', $insertData);
    }

    public function item_update_db($updateData, $id)
    {

        $itemName = $updateData['item_name'];


        $dupliacteItem =   $this->db->where('item_name', $itemName);
        $dupliacteItem =    $this->db->where('id !=', $id);
        $dupliacteItem =   $this->db->get('item_master')->num_rows();

        if ($dupliacteItem == 0) {
            $this->db->where('id', $id);
            return  $this->db->update('item_master', $updateData);
        } else {
            return ['dupliacteItem' => $dupliacteItem ];
        }

    }

    public function item_master_table($liveData)
    {

        $sortOn = $liveData['sortOn'];
        $sortOrder = $liveData['sortOrder'];
        $pageLimit = $liveData['pageLimit'];
        $currentPage = $liveData['currentPage'];

        $liveDataArray = ['item_name' => $liveData['item_name']];

        $offset = ($currentPage - 1) * $pageLimit;

        // for table records 
        $result = $this->db->order_by($sortOn, $sortOrder);
        $result = $this->db->select('id,item_name,item_description,item_price,image')->from('item_master');
        $result = $this->db->like($liveDataArray);
        $result = $this->db->get('', $pageLimit, $offset);


        // Number of pages 
        $paginationDb = $this->db->from('item_master');
        $paginationDb = $this->db->like($liveDataArray);
        $paginationDb = $this->db->get();
        $pages = ceil($paginationDb->num_rows() / $pageLimit);

        return json_encode(['table' => $result->result_array(), 'pagination' => ['totalPages' => $pages, 'current_page_opened' => $currentPage]]);
    }

    public function item_master_edit($user_id)
    {


        $this->db->where('id', $user_id);
        $result = $this->db->get('item_master');

        return json_encode($result->row());
    }

    public function item_master_delete($deleteUserId)
    {

        $this->db->where('id', $deleteUserId);
        $result =   $this->db->delete('item_master');
        $result =   $this->db->affected_rows();


        return $result;

    }


}
