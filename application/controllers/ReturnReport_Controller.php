<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReturnReport_Controller extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ReturnReport_Model');
        $this->load->model('Return_Model');
        $this->load->helper('url');
        $this->load->helper('download');
    }
    
    public function index()
    {
        $data['title'] = 'Return Reports';
        $this->load->view('returnReport', $data);
    }
    
    // Generate individual return PDF for printing
    public function print_return($return_id) {
        $return_data = $this->Return_Model->get_return_by_id($return_id);
        $return_items = $this->Return_Model->get_return_items($return_id);

        
        if (!$return_data) {
            show_error('Return not found');
            return;
        }
        
        // Prepare data for the view
        $data = [
            'return_data' => $return_data,
            'return_items' => $return_items,
        ];
        
        // Load the printable view
        $this->load->view('return_printable', $data);
    }
    
    public function generate_csv() {
        // Get filter parameters
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $customer_id = $this->input->post('customer_id');
        
        // Get return data based on filters
        $returns = $this->ReturnReport_Model->get_returns_for_report($start_date, $end_date, $customer_id);
        
        // Define CSV headers
        $filename = 'return_report_' . date('YmdHis') . '.csv';
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        
        $output = fopen('php://output', 'w');
        
        // Add CSV column headers
        fputcsv($output, array('Return #', 'Invoice #', 'Date', 'Customer Name', 'Address', 'Item Name', 'Description', 'Quantity', 'Unit', 'Price', 'Total'));
        
        // Write data rows
        foreach ($returns as $return) {
            fputcsv($output, array(
                $return->return_id,
                $return->invoice_id,
                date('Y-m-d', strtotime($return->created_at)),
                $return->customer_name,
                $return->customer_address,
                $return->item_name,
                $return->item_description,
                $return->quantity,
                $return->unit_name,
                $return->item_price,
                $return->total
            ));
        }
        
        fclose($output);
        exit;
    }
    
    public function generate_pdf_simple() {
        // Get filter parameters
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $customer_id = $this->input->post('customer_id');
        
        $data['returns'] = $this->ReturnReport_Model->get_returns_for_report($start_date, $end_date, $customer_id);
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        
        $data['grand_total'] = 0;
        foreach ($data['returns'] as $return) {
            $data['grand_total'] += $return->total;
        }
        
        // Load a view that formats the report as printable HTML
        $this->load->view('return_report_printable', $data);
    }
}