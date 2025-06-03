<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class InvoiceReport_Model extends CI_Model {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    public function get_invoices_for_report($start_date = null, $end_date = null, $customer_id = null)
    {
        $this->db->select('invoices.id as invoice_id, invoices.customer_id, invoices.created_at,
                        invoice_items.item_id, invoice_items.quantity, invoice_items.total,
                        items.item_name, invoice_items.item_price, invoice_items.item_description,
                        units.unit_name, customers.customer_name, customers.address as customer_address');
        $this->db->from('invoices');
        $this->db->join('invoice_items', 'invoice_items.invoice_id = invoices.id', 'left');
        $this->db->join('items', 'invoice_items.item_id = items.id', 'left');
        $this->db->join('units', 'invoice_items.unit_id = units.id', 'left');
        $this->db->join('customers', 'customers.id = invoices.customer_id', 'left');
        
        // Apply date filters if provided
        if (!empty($start_date)) {
            $this->db->where('DATE(invoices.created_at) >=', $start_date);
        }
        
        if (!empty($end_date)) {
            $this->db->where('DATE(invoices.created_at) <=', $end_date);
        }

        if (!empty($customer_id)) {
            $this->db->where('invoices.customer_id', $customer_id);
        }

        $this->db->order_by('invoices.id', 'ASC');
        $this->db->order_by('invoices.created_at', 'DESC');
        
        return $this->db->get()->result();
    }
    
    public function get_all_customers()
    {
        return $this->db->get('customers')->result();
    }
    
    public function get_invoice_summary()
    {
        // Get summary information for dashboard
        $this->db->select('COUNT(DISTINCT invoices.id) as total_invoices, 
                        SUM(invoice_items.total) as total_amount,
                        COUNT(DISTINCT invoices.customer_id) as total_customers');
        $this->db->from('invoices');
        $this->db->join('invoice_items', 'invoice_items.invoice_id = invoices.id', 'left');
        
        return $this->db->get()->row();
    }
    
    public function get_invoices_by_month($year = null)
    {
        // If no year is provided, use current year
        if ($year === null) {
            $year = date('Y');
        }
        
        $this->db->select('MONTH(invoices.created_at) as month, 
                        COUNT(DISTINCT invoices.id) as invoice_count, 
                        SUM(invoice_items.total) as total_amount');
        $this->db->from('invoices');
        $this->db->join('invoice_items', 'invoice_items.invoice_id = invoices.id', 'left');
        $this->db->where('YEAR(invoices.created_at)', $year);
        $this->db->group_by('MONTH(invoices.created_at)');
        $this->db->order_by('MONTH(invoices.created_at)', 'ASC');
        
        return $this->db->get()->result();
    }
    
    public function get_top_customers($limit = 5)
    {
        $this->db->select('customers.id, customers.customer_name, 
                        COUNT(DISTINCT invoices.id) as invoice_count, 
                        SUM(invoice_items.total) as total_amount');
        $this->db->from('customers');
        $this->db->join('invoices', 'invoices.customer_id = customers.id', 'left');
        $this->db->join('invoice_items', 'invoice_items.invoice_id = invoices.id', 'left');
        $this->db->group_by('customers.id');
        $this->db->order_by('total_amount', 'DESC');
        $this->db->limit($limit);
        
        return $this->db->get()->result();
    }
    
    public function get_top_items($limit = 5)
    {
        $this->db->select('items.id, items.item_name, 
                        SUM(invoice_items.quantity) as total_quantity, 
                        SUM(invoice_items.total) as total_amount');
        $this->db->from('items');
        $this->db->join('invoice_items', 'invoice_items.item_id = items.id', 'left');
        $this->db->group_by('items.id');
        $this->db->order_by('total_amount', 'DESC');
        $this->db->limit($limit);
        
        return $this->db->get()->result();
    }
}