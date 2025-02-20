<?php
defined('BASEPATH') or exit('No direct script access allowed');


class EmailController extends CI_Controller
{

    public function mail()
    {
        
        $mailData = $this->input->post();

        // print_r($mailData);


        $this->load->library('email');

        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'smtp.gmail.com';
        $config['smtp_port'] = 587; // Port 587 is for STARTTLS
        $config['smtp_user'] = 'karanroliyal12@gmail.com';
        $config['smtp_pass'] = 'pzxs awnw pbgi szno'; // Replace with your Gmail App Password
        $config['smtp_crypto'] = 'tls';  // Enable STARTTLS
        $config['charset'] = 'utf-8';
        $config['mailtype'] = 'html';
        $config['newline'] = "\r\n"; // Correct newline format
        
        // Optional debugging:
        $config['smtp_debug'] = 2; // This will give more detailed debugging output.
        


        $this->email->initialize($config);

        $this->email->from('karanroliyal12@gmail.com', $mailData['recipient_name']);
        $this->email->to($mailData['mail_to']);
        
        $this->email->attach($mailData['pdf_file_path']);

        $this->email->subject($mailData['subject']);
        $this->email->message($mailData['message']);

        if($this->email->send()){

            echo json_encode(['success'=>true]);

        }else{
            echo json_encode(['success'=>$this->email->print_debugger()]);
        }
    }

    public function clientData(){

        $id = $this->input->post();

        $this->db->select('name , email , invoice_id');
        $this->db->where($id);
        $this->db->from('invoice_master');
        $this->db->join('client_master cm', 'invoice_master.client_id=cm.id');
        $data = $this->db->get()->row();

        echo json_encode($data);
    }

}
