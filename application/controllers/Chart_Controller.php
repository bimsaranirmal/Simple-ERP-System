<?php // Chart_Controller.php 
defined('BASEPATH') OR exit('No direct script access allowed');  

class Chart_Controller extends CI_Controller {  
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Chart_Model');
    }
    
    public function index() {
        $this->load->view('chart');
    }
    
    public function get_chart_data() {
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        
        $invoice_totals = $this->Chart_Model->get_invoice_totals_by_customer($start_date, $end_date);
        $return_totals = $this->Chart_Model->get_returned_invoice_totals_by_customer($start_date, $end_date);
        $customer_percentage = $this->Chart_Model->get_customer_percentage();
        
        echo json_encode([
            'invoice_totals' => $invoice_totals,
            'return_totals' => $return_totals,
            'customer_percentage' => $customer_percentage
        ]);
    }
}