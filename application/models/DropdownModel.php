<?php
defined('BASEPATH') or exit('No direct script access allowed');
Header('Access-Control-Allow-Origin: *'); //for allow any domain, insecure
Header('Access-Control-Allow-Headers: *'); //for allow any headers, insecure
Header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE'); //method allowed


class DropdownModel extends CI_Model
{

    function client($clientName)
    {

        $this->db->like($clientName);

        $result = $this->db->get('client_master')->result();

        return json_encode(['object' => $result]);
    }

    function item($itemName)
    {

        if (isset($itemName['arrId'])) {
            $arrId = json_decode($_POST['arrId'], true); // Convert JSON string to array
    
            if (!is_array($arrId)) {
                $arrId = []; // Ensure $arrId is an array
            }
    
            $ids = implode(",", $arrId); // Now it will work correctly
    
            $this->db->where_not_in('id', explode(",", $ids)); // Ensure proper format
            unset($itemName['arrId']);
        }

        $this->db->like($itemName);

        $result = $this->db->get('item_master')->result();

        return json_encode(['object' => $result]);
    }

    public function district($state_id)
    {

        $this->db->select('district_id');
        $this->db->select('district_name');
        $this->db->where('state_id', $state_id['state_id']);
        $query = $this->db->get('district_master');


        $district_options = "";

        // foreach($query->result_array() as $row){

        //     $district_options .= "<option class='dynamic_district' value='{$row['district_id']}'>{$row['district_name']}</option>";

        // }

        echo json_encode(['district_options' => $query->result_array()]);
    }
}
