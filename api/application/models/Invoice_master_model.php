<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Invoice_master_model extends CI_Model
{

    public function invoice_master_table($liveData){

        $sortOn = $liveData['sortOn'];
        $sortOrder = $liveData['sortOrder'];
        $pageLimit = $liveData['pageLimit'];
        $currentPage = $liveData['currentPage'];

        $liveDataArray = ['invoice_number' => $liveData['invoice_number']];

        $offset = ($currentPage - 1) * $pageLimit;

        // for table records 
        $result = $this->db->order_by($sortOn, $sortOrder);
        $result = $this->db->select('invoice_id,invoice_number,invoice_date,NAME,email,phone,total_amount')->from('invoice_master');
        $result = $this->db->like($liveDataArray);
        $result = $this->db->join('client_master cm', 'cm.id = invoice_master.client_id');
        $result = $this->db->get('', $pageLimit, $offset);


        // Number of pages 
        $paginationDb = $this->db->from('invoice_master');
        $paginationDb = $this->db->like($liveDataArray);
        $paginationDb = $this->db->get();
        $pages = ceil($paginationDb->num_rows() / $pageLimit);

        return json_encode(['table' => $result->result_array(), 'pagination' => ['totalPages' => $pages, 'current_page_opened' => $currentPage]]);


        
    }

    public function client_autocomplete_model($clientName){

        $this->db->like($clientName);

        $result = $this->db->get('client_master')->result();

        return json_encode(['object' => $result]);

    }

    public function item_autocomplete_model($itemName){

        if(isset($itemName['arrId'])){
            $arrId = $_POST['arrId'];
    
        $ids = implode(" ," ,$arrId);

            $this->db->where_not_in('id', $ids);
            unset($itemName['arrId']);
            
        }

        $this->db->like($itemName);

        $result = $this->db->get('item_master')->result();

        return json_encode(['object' => $result]);

    }

}
