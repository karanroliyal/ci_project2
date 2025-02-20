<?php
defined('BASEPATH') or exit('No direct script access allowed');


class DropdownModel extends CI_Model{

    function client($clientName){

        $this->db->like($clientName);

        $result = $this->db->get('client_master')->result();

        return json_encode(['object' => $result]);

    }

    function item($itemName){

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

    public function district($state_id){

        $this->db->select('district_id');
        $this->db->select('district_name');
        $this->db->where('state_id' , $state_id['state_id']);
        $query = $this->db->get('district_master');


        $district_options = "";

        foreach($query->result_array() as $row){

            $district_options .= "<option class='dynamic_district' value='{$row['district_id']}'>{$row['district_name']}</option>";

        }

        echo json_encode(['district_options' => $district_options]);

        

    }

}















