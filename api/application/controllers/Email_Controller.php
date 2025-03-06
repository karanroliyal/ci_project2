<?php
// defined('BASEPATH') or exit('No direct script access allowed');

class Email_Controller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->jwt_token->get_verified_token();
        $this->load->library('email'); 
    }

    public function mail_sender()
    {

        $permission = $this->fx->check_permission_of_user()['view_permission'];

        if($permission == 0){
            echo $this->fx->api_response(403 , 'Forbidden' , '' , "You don't have permission to send main of invoice");
            return;
        }

        if (isset($_POST['data'])) {
            $_POST = json_decode($_POST['data'], true);
        }

        // print_r($_POST);die;
        if (isset($_POST['message'])) {
            $message = $_POST['message'];
        }
        if (isset($_POST['subject'])) {
            $subject = $_POST['subject'];
        }
        if (isset($_POST['name'])) {
            $name = $_POST['name'];
        }
        if (isset($_POST['email'])) {
            $email = $_POST['email'];
        }
        $invoice_id = '';
        if (isset($_POST['invoice_id'])) {
            $invoice_id = $_POST['invoice_id'];
        }


        $pdfPath = base_url()  . 'pdfs/generated_pdf_' . $invoice_id . '.pdf';
      
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'smtp.gmail.com';
        $config['smtp_port'] = 587; // Port 587 is for STARTTLS
        $config['smtp_user'] = '';
        $config['smtp_pass'] = ''; // Replace with your Gmail App Password
        $config['smtp_crypto'] = 'tls';  // Enable STARTTLS
        $config['charset'] = 'utf-8';
        $config['mailtype'] = 'html';
        $config['newline'] = "\r\n"; // Correct newline format

        // Optional debugging:
        $config['smtp_debug'] = 3; // This will give more detailed debugging output.


        // echo $config['smtp_debug'];die;

        $this->email->initialize($config);

        $this->email->from('karanroliyal12@gmail.com');
        $this->email->to($email, $name);

        $this->email->attach($pdfPath);

        $this->email->subject($subject);
        $this->email->message($message);

        if ($this->email->send()) {

            echo json_encode(['success' => true]);
            return;
        } else {
            echo json_encode(['success' => $this->email->print_debugger()]);
            return;
        }
    }
}
