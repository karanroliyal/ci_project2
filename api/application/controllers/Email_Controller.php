<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Email_Controller extends CI_Controller
{

    public function __construct()
    {
        $this->jwt_token->get_verified_token();
    }

    public function mail_sender()
    {

        $_POST = json_decode($this->input->post('data') , true);

        $message = $_POST['message'];
        $subject = $_POST['subject'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $invoice_id = $_POST['invoice_id'];


        $pdfPath = base_url().'pdfs/generated_pdf_'.$invoice_id.'.pdf';

        // echo $pdfPath; die;

        // print_r($_POST);

        // die;

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

        $this->email->from('karanroliyal12@gmail.com');
        $this->email->to($email , $name);
        
        $this->email->attach($pdfPath);

        $this->email->subject($subject);
        $this->email->message($message);

        if($this->email->send()){

            echo json_encode(['success'=>true]);
            return;

        }else{
            echo json_encode(['success'=>$this->email->print_debugger()]);
            return;
        }
    }

  

}
