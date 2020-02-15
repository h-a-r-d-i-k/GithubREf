<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require FCPATH . '/vendor/dompdf/dompdf/src/Autoloader.php';
use Dompdf\Dompdf;
use Dompdf\Options;
function generate($html, $filename='', $stream=TRUE,$paper){ 
	$options = new Options();
    
    // CRM-12165 - Remote file support required for image handling.
	$options->set('isRemoteEnabled', TRUE);

    // intiating class Dompdf
    $dompdf = new Dompdf($options);

    // loading HTML    
    $dompdf->loadHtml($html);
    
    // defining size of page
    $dompdf->setPaper('A4', 'portrait');

    $dompdf->render();
    if ($stream) {
        // creating pdf
        $dompdf->stream($filename.".pdf",array("Attachment" => 1));
    } else {
        return $dompdf->output(); 
    }
}
?>