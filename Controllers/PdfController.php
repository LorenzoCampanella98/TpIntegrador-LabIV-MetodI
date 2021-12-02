<?php 
    namespace Controllers;
    require 'pdf/dompdf/autoload.inc.php';
    use Dompdf\Dompdf;

    class PdfController{
    
        public function __construct()
        {
            $pdf = new Dompdf();
            $html=$this->file_get_contents_curl("http://http://laboratorioiv.local/TP%20FINAL/TpIntegrador-LabIV-MetodI/Views/misDatosPdf.php");
            $pdf->set_paper("letter", "portrait");
            $pdf->load_html(utf8_decode($html));
            $pdf->render();
            $pdf->stream('reportePdf.pdf');
        }

        function file_get_contents_curl($url) {
            $crl = curl_init();
            $timeout = 5;
            curl_setopt($crl, CURLOPT_URL, $url);
            curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($crl, CURLOPT_CONNECTTIMEOUT, $timeout);
            $ret = curl_exec($crl);
            curl_close($crl);
            return $ret;
        }
    
    }
  





?>