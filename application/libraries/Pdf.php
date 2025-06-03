<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'third_party/dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

class Pdf
{
    public function __construct()
    {
        
    }
    
    public function generate($html, $filename = '', $stream = TRUE, $paper = 'A4', $orientation = 'portrait')
    {
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->set('isRemoteEnabled', TRUE);
        $options->set('isHtml5ParserEnabled', TRUE);
        
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper($paper, $orientation);
        $dompdf->render();
        
        if ($stream) {
            $dompdf->stream($filename . '.pdf', array('Attachment' => 0));
        } else {
            return $dompdf->output();
        }
    }
    
    public function save($html, $filename, $path, $paper = 'A4', $orientation = 'portrait')
    {
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->set('isRemoteEnabled', TRUE);
        $options->set('isHtml5ParserEnabled', TRUE);
        
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper($paper, $orientation);
        $dompdf->render();
        
        $output = $dompdf->output();
        file_put_contents($path . $filename, $output);
        
        return $path . $filename;
    }
}
?>