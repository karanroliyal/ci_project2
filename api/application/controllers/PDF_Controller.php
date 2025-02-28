<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once FCPATH . '/vendor/autoload.php';

class PDF_Controller extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    public function view_pdf()
    {

        if(isset($_GET)){
            $id['id'] = $_GET['myId'];
            $html = $this->load->view('pdf', $id, true);
            $mpdf = new \Mpdf\Mpdf();
            $mpdf->showImageErrors = true;
            $mpdf->WriteHTML($html);
            $mpdf->Output();
        }else{
            echo "Something went wrong";
            return;
        }
        
    }
    public function mailPdf()
    {

            $id['id'] = $_POST['mail'];
            $html = $this->load->view('pdf', $id, true);
            $mpdf = new \Mpdf\Mpdf();
            $mpdf->showImageErrors = true;
            $mpdf->WriteHTML($html);
            $filePath = FCPATH  . "pdfs/" . "generated_pdf_" . $id['id'] . '.pdf';
            $mpdf->Output($filePath, "F");
            $this->load->helper('download');
            force_download($filePath, NULL);

    }
}
