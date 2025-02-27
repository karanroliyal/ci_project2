<?php
defined('BASEPATH') or exit('No direct script access allowed');
Header('Access-Control-Allow-Origin: *'); //for allow any domain, insecure
Header('Access-Control-Allow-Headers: *'); //for allow any headers, insecure
Header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE'); //method allowed

class Email_Controller extends CI_Controller
{

    public function mail_sender()
    {

        $_POST = json_decode($this->input->post('data') , true);

        print_r($_POST);

        die;

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

  

}
