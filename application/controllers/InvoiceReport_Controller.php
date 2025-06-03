<?php
defined('BASEPATH') or exit('No direct script access allowed');

class InvoiceReport_Controller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('InvoiceReport_Model');
        $this->load->model('Invoice_Model');
        $this->load->model('Customer_Model'); // <-- Add this line
        $this->load->helper('url');
        $this->load->helper('download');


    }

    public function index()
    {
        $data['title'] = 'Invoice Reports';
        $this->load->view('invoiceReport', $data);
    }

    public function print_invoice($invoice_id)
    {
        // Get invoice and its items
        $invoice = $this->Invoice_Model->get_invoice_by_id_copy($invoice_id);
        $invoice_items = $this->Invoice_Model->get_invoice_items_copy($invoice_id);

        if (!$invoice) {
            show_error('Invoice not found');
            return;
        }

        // Fetch customer's phone number for WhatsApp
        $customer_whatsapp_number = '';
        // $customer_obj = null; // Not strictly needed if only mobile is used later
        if (isset($invoice->customer_id)) {
            // Now Customer_Model is indeed loaded in the constructor
            $customer = $this->Customer_Model->get_customer_by_id($invoice->customer_id);
            if ($customer && !empty($customer->mobile)) {
                $customer_whatsapp_number = $customer->mobile;
            }
            // $customer_obj = $customer;
        }

        $data = [
            'invoice' => $invoice,
            'invoice_items' => $invoice_items,
            'customer_whatsapp_number' => $customer_whatsapp_number, // Pass phone number to the view
        ];

        // Generate HTML for PDF using data that includes the customer's WhatsApp number
        $html = $this->load->view('invoice_printable', $data, TRUE); 

        $this->load->library('dompdf_gen');

        $this->dompdf_gen->load_html($html);
        $this->dompdf_gen->render();

        $pdf_filename = 'invoice' . $invoice_id . '.pdf';
        $upload_dir = FCPATH . 'uploads/invoices/';

        // Ensure the upload directory exists
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        $pdf_path = $upload_dir . $pdf_filename;

        file_put_contents($pdf_path, $this->dompdf_gen->output());

        $pdf_url = base_url('uploads/invoices/' . $pdf_filename);

        // Prepare direct WhatsApp share URL if customer number and PDF URL are available
        $direct_whatsapp_share_url = '';
        if (!empty($customer_whatsapp_number) && !empty($pdf_url)) {
            $sanitizedPhone = preg_replace('/\D/', '', $customer_whatsapp_number); // Remove non-digits
            if (!empty($sanitizedPhone)) {
                $shareTextLink = "Here is your invoice: " . $pdf_url;
                // Ensure the link is properly URL-encoded for the text parameter
                $direct_whatsapp_share_url = "https://wa.me/" . $sanitizedPhone . "?text=" . rawurlencode($shareTextLink);
            }
        }

        // Update data for the view that will be displayed to the user
        $data['pdf_url'] = $pdf_url;
        $data['pdf_filename'] = $pdf_filename; 
        $data['direct_whatsapp_share_url'] = $direct_whatsapp_share_url; // Pass the fully formed direct share URL
        $this->load->view('invoice_printable', $data);
    }


    public function generate_csv()
    {
        // Get filter parameters
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $customer_id = $this->input->post('customer_id');

        $invoices = $this->InvoiceReport_Model->get_invoices_for_report($start_date, $end_date, $customer_id);

        $filename = 'invoice_report_' . date('YmdHis') . '.csv';

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename="' . $filename . '"');

        $output = fopen('php://output', 'w');

        fputcsv($output, array('Invoice #', 'Date', 'Customer Name', 'Address', 'Item Name', 'Description', 'Quantity', 'Unit', 'Price', 'Total'));
        foreach ($invoices as $invoice) {
            fputcsv($output, array(
                $invoice->invoice_id,
                date('Y-m-d', strtotime($invoice->created_at)),
                $invoice->customer_name,
                $invoice->customer_address,
                $invoice->item_name,
                $invoice->item_description,
                $invoice->quantity,
                $invoice->unit_name,
                $invoice->item_price,
                $invoice->total
            ));
        }

        fclose($output);
        exit;
    }
  
    public function generate_pdf_simple()
    {
        // Get filter parameters
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $customer_id = $this->input->post('customer_id');

        $data['invoices'] = $this->InvoiceReport_Model->get_invoices_for_report($start_date, $end_date, $customer_id);
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;

        $data['grand_total'] = 0;
        foreach ($data['invoices'] as $invoice) {
            $data['grand_total'] += $invoice->total;
        }

        $html = $this->load->view('invoice_report_printable', $data, TRUE);

        $this->load->library('dompdf_gen');

        $this->dompdf_gen->load_html($html);
        $this->dompdf_gen->render();

        $pdf_filename = 'invoice_' . date('YmdHis') . '.pdf';
        $pdf_path = FCPATH . 'uploads/all/' . $pdf_filename;

        file_put_contents($pdf_path, $this->dompdf_gen->output());

        $pdf_url = base_url('uploads/all/' . $pdf_filename);
        $data['pdf_filename'] = $pdf_filename; // Pass the filename to the view

        $data['pdf_url'] = $pdf_url;
        $this->load->view('invoice_report_printable', $data);
    }


}