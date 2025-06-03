<?php // Chart_Model.php  
defined('BASEPATH') OR exit('No direct script access allowed');  

class Chart_Model extends CI_Model {  
    
    public function get_invoice_totals_by_customer($start_date = null, $end_date = null) {
        $this->db->select('customers.customer_name, COALESCE(SUM(invoice_items.total), 0) as total_amount');
        $this->db->from('customers');
        $this->db->join('invoices', 'customers.id = invoices.customer_id', 'left');
        $this->db->join('invoice_items', 'invoice_items.invoice_id = invoices.id', 'left');
        if ($start_date && $end_date) {
            $this->db->where('invoices.created_at >=', $start_date);
            $this->db->where('invoices.created_at <=', $end_date);
        }
        $this->db->group_by('customers.customer_name');
        return $this->db->get()->result();
    }
    
    public function get_returned_invoice_totals_by_customer($start_date = null, $end_date = null) {
        $this->db->select('customers.customer_name, COALESCE(SUM(return_items.total), 0) as return_total');
        $this->db->from('customers');
        $this->db->join('returns', 'customers.id = returns.customer_id', 'left');
        $this->db->join('return_items', 'return_items.return_id = returns.id', 'left');
        if ($start_date && $end_date) {
            $this->db->where('returns.created_at >=', $start_date);
            $this->db->where('returns.created_at <=', $end_date);
        }
        $this->db->group_by('customers.customer_name');
        return $this->db->get()->result();
    }
    
    public function get_customer_percentage() {
        // Get total customers
        $total_customers = $this->db->count_all('customers');
        
        // Get customers with invoices
        $this->db->select('COUNT(DISTINCT customer_id) as invoice_customers');
        $this->db->from('invoices');
        $invoice_customers = $this->db->get()->row()->invoice_customers;
        
        // Get customers with returns
        $this->db->select('COUNT(DISTINCT customer_id) as return_customers');
        $this->db->from('returns');
        $return_customers = $this->db->get()->row()->return_customers;
        
        // Count customers with neither invoices nor returns
        // We use subqueries to find customers not in either invoices or returns tables
        $this->db->select('COUNT(*) as no_invoice_customers');
        $this->db->from('customers');
        $this->db->where("id NOT IN (SELECT DISTINCT customer_id FROM invoices)");
        $this->db->where("id NOT IN (SELECT DISTINCT customer_id FROM returns)");
        $no_invoice_customers = $this->db->get()->row()->no_invoice_customers;
        
        return [
            'invoice_customers' => $invoice_customers,
            'return_customers' => $return_customers,
            'no_invoice_customers' => $no_invoice_customers,
            'total_customers' => $total_customers
        ];
    }
}