<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Invoice_master_model extends CI_Model
{

    public function invoice_master_table($liveData)
    {

        $table_value = json_decode($this->table_data->table_controls($liveData));

        $liveDataArray = ['invoice_number' => $liveData['invoice_number']];

        $offset = ($table_value->currentPage - 1) * $table_value->pageLimit;

        // for table records 
        $result = $this->db->order_by($table_value->sortOn, $table_value->sortOrder);
        $result = $this->db->select('invoice_id,invoice_number,invoice_date,NAME,email,phone,total_amount,client_id')->from('invoice_master');
        $result = $this->db->like($liveDataArray);
        $result = $this->db->join('client_master cm', 'cm.id = invoice_master.client_id');
        $result = $this->db->get('', $table_value->pageLimit, $offset);


        // Number of pages 
        $paginationDb = $this->db->from('invoice_master');
        $paginationDb = $this->db->like($liveDataArray);
        $paginationDb = $this->db->get();
        $pages = ceil($paginationDb->num_rows() / $table_value->pageLimit);

        $permission = $this->fx->check_permission_of_user();

        return json_encode(['table' => $result->result_array(), 'pagination' => ['totalPages' => $pages, 'current_page_opened' => $table_value->currentPage   ], 'permission'=>$permission]);
    }

    public function client_autocomplete_model($clientName)
    {

        $this->db->like($clientName);

        $result = $this->db->get('client_master')->result();

        return $result;
    }

    public function item_autocomplete_model($itemName)
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

        return $result;
    }


    public function invoice_master_edit($invoiceId)
    {

        $other = $this->db->join('item_master', 'invoice.item_id = item_master.id');
        $other =   $this->db->where('invoice_id', $invoiceId);
        $other =  $this->db->get('invoice');


        $result =  $this->db->where('invoice_id', $invoiceId);
        $result =  $this->db->join('client_master cm', 'invoice_master.client_id = cm.id');
        $result = $this->db->get('invoice_master');



        return json_encode(['data' => $result->row(), 'item' => $other->result()]);
    }

    public function invoice_master_insert_data($itemData, $clientData)
    {

        // print_r($itemData);die;

        if ($this->db->insert('invoice_master', $clientData)) {

            $invoiceMasterInsertedId =  $this->db->insert_id(); // last inserted id

            
            for ($i = 0; $i < count($itemData); $i++) {

                $itemData[$i]['invoice_id'] = $invoiceMasterInsertedId;

                unset($itemData[$i]['item_name']);
                unset($itemData[$i]['item_price']);

                // print_r($itemData[$i]);die;

               $result =  $this->db->insert('invoice' , $itemData[$i]);

            }

            return ['result'=>$result , 'inserted_id'=>$invoiceMasterInsertedId];
            
        }

        // return json_encode(['clientdata'=>$clientData]);

    }

    public function invoice_master_update_data($itemData, $clientData, $invoiceId){

        $this->db->where('invoice_id' , $invoiceId);

        if($this->db->update('invoice_master' , $clientData)){

            $this->db->where('invoice_id' , $invoiceId);

            if($this->db->delete('invoice')){

                for ($i = 0; $i < count($itemData); $i++) {

                    $itemData[$i]['invoice_id'] = $invoiceId;
    
                    unset($itemData[$i]['item_name']);
                    unset($itemData[$i]['item_price']);
    
                    $result =  $this->db->insert('invoice' , $itemData[$i]);
    
                }

                return $result;

            }

        }

    }

    public function generate_last_invoice_number(){

        $data = $this->db->select('invoice_id')->from('invoice_master')->order_by('invoice_id', 'desc')->limit(1)->get()->row();

        $this->db->select('invoice_id');
        $this->db->from('invoice_master');
        $this->db->order_by('invoice_id' , 'DESC');
        $this->db->limit(1);
        $result = $this->db->get()->row();

        return $result;

    }


    public function client_details_for_mail($clientId){

        $this->db->where('id',$clientId);
        $this->db->select('email , NAME');
        $result = $this->db->get('client_master');

        return $result->row();

    }

    public function delete_invoice($invoiceId){

        $this->db->where('invoice_id',$invoiceId);
        
        if($this->db->delete('invoice')){

            $this->db->where('invoice_id',$invoiceId);
           $result =  $this->db->delete('invoice_master');
           $result = $this->db->affected_rows();

           return $result;

        }

    }


}
