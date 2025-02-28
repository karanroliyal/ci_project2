<?php

class dashboard_model extends CI_Model{


    public function users_count(){

        $this->db->select('count(id) as user');
        $result = $this->db->get('user_master');

        return $result;

    }

    public function client_count(){

        $this->db->select('count(id) as client');
        $result = $this->db->get('client_master');

        return $result;

    }

    public function item_count(){

        $this->db->select('count(id) as item');
        $result = $this->db->get('item_master');

        return $result;

    }

    public function invoice_total_amount(){

        $this->db->select('sum(total_amount) as invoice_total_amount');
        $result = $this->db->get('invoice_master');

        return $result;

    }


}