<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'third_party/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

class Dompdf_gen {
    public $dompdf;
    
    public function __construct() {
        $this->dompdf = new Dompdf();
    }
    
    public function load_html($html){
        $this->dompdf->loadHtml($html);
    }
    
    public function render(){
        $this->dompdf->render();
    }
    
    public function output(){
        return $this->dompdf->output();
    }
    
    public function stream($filename, $options = array()){
        $this->dompdf->stream($filename, $options);
    }
}