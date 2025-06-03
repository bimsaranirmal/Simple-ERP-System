<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReturnReport_Model extends CI_Model {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    public function get_returns_for_report($start_date = null, $end_date = null, $customer_id = null)
    {
        $this->db->select('returns.id as return_id, returns.invoice_id, returns.customer_id, returns.created_at,
                        return_items.item_id, return_items.quantity, return_items.total,
                        items.item_name, return_items.price as item_price, return_items.item_description,
                        units.unit_name, customers.customer_name, customers.address as customer_address');
        $this->db->from('returns');
        $this->db->join('return_items', 'return_items.return_id = returns.id', 'left');
        $this->db->join('items', 'return_items.item_id = items.id', 'left');
        $this->db->join('units', 'return_items.unit_id = units.id', 'left');
        $this->db->join('customers', 'customers.id = returns.customer_id', 'left');
        
        // Apply date filters if provided
        if (!empty($start_date)) {
            $this->db->where('DATE(returns.created_at) >=', $start_date);
        }
        
        if (!empty($end_date)) {
            $this->db->where('DATE(returns.created_at) <=', $end_date);
        }
        
        // Apply customer filter if provided
        if (!empty($customer_id)) {
            $this->db->where('returns.customer_id', $customer_id);
        }
        
        // Order by return ID and date
        $this->db->order_by('returns.id', 'ASC');
        $this->db->order_by('returns.created_at', 'DESC');
        
        return $this->db->get()->result();
    }
    
    public function get_all_customers()
    {
        return $this->db->get('customers')->result();
    }
    
    public function get_return_summary()
    {
        // Get summary information for dashboard
        $this->db->select('COUNT(DISTINCT returns.id) as total_returns, 
                        SUM(return_items.total) as total_amount,
                        COUNT(DISTINCT returns.customer_id) as total_customers');
        $this->db->from('returns');
        $this->db->join('return_items', 'return_items.return_id = returns.id', 'left');
        
        return $this->db->get()->row();
    }
    
    public function get_returns_by_month($year = null)
    {
        // If no year is provided, use current year
        if ($year === null) {
            $year = date('Y');
        }
        
        $this->db->select('MONTH(returns.created_at) as month, 
                        COUNT(DISTINCT returns.id) as return_count, 
                        SUM(return_items.total) as total_amount');
        $this->db->from('returns');
        $this->db->join('return_items', 'return_items.return_id = returns.id', 'left');
        $this->db->where('YEAR(returns.created_at)', $year);
        $this->db->group_by('MONTH(returns.created_at)');
        $this->db->order_by('MONTH(returns.created_at)', 'ASC');
        
        return $this->db->get()->result();
    }
    
    public function get_top_return_customers($limit = 5)
    {
        $this->db->select('customers.id, customers.customer_name, 
                        COUNT(DISTINCT returns.id) as return_count, 
                        SUM(return_items.total) as total_amount');
        $this->db->from('customers');
        $this->db->join('returns', 'returns.customer_id = customers.id', 'left');
        $this->db->join('return_items', 'return_items.return_id = returns.id', 'left');
        $this->db->group_by('customers.id');
        $this->db->order_by('total_amount', 'DESC');
        $this->db->limit($limit);
        
        return $this->db->get()->result();
    }
    
    public function get_top_returned_items($limit = 5)
    {
        $this->db->select('items.id, items.item_name, 
                        SUM(return_items.quantity) as total_quantity, 
                        SUM(return_items.total) as total_amount');
        $this->db->from('items');
        $this->db->join('return_items', 'return_items.item_id = items.id', 'left');
        $this->db->group_by('items.id');
        $this->db->order_by('total_amount', 'DESC');
        $this->db->limit($limit);
        
        return $this->db->get()->result();
    }
}