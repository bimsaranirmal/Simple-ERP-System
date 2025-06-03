<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Return_Model extends CI_Model
{

    public function get_invoices_by_customer($customer_id)
    {
        $this->db->select('invoices.id as invoice_id, SUM(invoice_items.total) as total_amount');
        $this->db->from('invoices');
        $this->db->join('invoice_items', 'invoice_items.invoice_id = invoices.id', 'left');

        // Exclude returned invoices
        $this->db->join('returns', 'returns.invoice_id = invoices.id', 'left');
        $this->db->where('invoices.customer_id', $customer_id);
        $this->db->where('returns.invoice_id IS NULL'); // Exclude returned invoices
        $this->db->group_by('invoices.id');

        $query = $this->db->get();

        if (!$query) {
            log_message('error', 'Database error: ' . $this->db->last_query());
            return false;
        }

        return $query->result();
    }


    public function get_invoice_items($invoice_id)
    {
        $this->db->select('items.item_name, invoice_items.item_description, invoice_items.quantity, invoice_items.item_price, invoice_items.total, units.unit_name');
        $this->db->from('invoice_items');
        $this->db->join('items', 'items.id = invoice_items.item_id', 'left');
        $this->db->join('units', 'units.id = invoice_items.unit_id', 'left'); // Join with units table
        $this->db->where('invoice_items.invoice_id', $invoice_id);
        $query = $this->db->get();

        if (!$query) {
            log_message('error', 'Database error: ' . $this->db->last_query());
            return false;
        }

        return $query->result();
    }

    public function get_return_items($return_id)
{
    $this->db->select('return_items.*, items.item_name, items.item_price, units.unit_name');
    $this->db->from('return_items');
    $this->db->join('items', 'return_items.item_id = items.id', 'left');
    $this->db->join('units', 'return_items.unit_id = units.id', 'left');
    $this->db->where('return_items.return_id', $return_id);
    return $this->db->get()->result();
}



    public function save_return($return_data, $return_items_data)
    {
        // Insert the return data (header) into the 'returns' table
        $this->db->insert('returns', $return_data);
        $return_id = $this->db->insert_id();

        foreach ($return_items_data as &$item) {
            $item['return_id'] = $return_id;
        }

        return $return_id; 
    }


    public function save_return_item($item_data)
    {
        return $this->db->insert('return_items', $item_data); // Insert the item into the return_items table
    }

    public function get_all_returns()
    {
        $this->db->select('r.id as return_id, r.created_at, 
                           i.id as invoice_id, i.customer_id, 
                           i.created_at as invoice_created_at, 
                           return_items.item_id, return_items.quantity as quantity, 
                           return_items.total as total, 
                           items.item_name, return_items.price, return_items.item_description, 
                           units.unit_name, 
                           c.customer_name, c.address as customer_address'); 
        $this->db->from('returns r');
        $this->db->join('invoices i', 'i.id = r.invoice_id', 'left');
        $this->db->join('return_items', 'return_items.return_id = r.id', 'left');
        $this->db->join('items', 'return_items.item_id = items.id', 'left');
        $this->db->join('units', 'return_items.unit_id = units.id', 'left');
        $this->db->join('customers c', 'c.id = i.customer_id', 'left');

        return $this->db->get()->result();
    }

    public function get_return_by_id($id)
    {
        $this->db->select('r.id as return_id, r.created_at, 
                       i.id as invoice_id, i.customer_id, 
                       return_items.item_id, return_items.quantity, 
                       return_items.total, return_items.price, 
                       items.item_name, return_items.item_description, 
                       units.unit_name, 
                       c.customer_name, c.address as customer_address');
        $this->db->from('returns r');
        $this->db->join('invoices i', 'i.id = r.invoice_id', 'left');
        $this->db->join('return_items', 'return_items.return_id = r.id', 'left');
        $this->db->join('items', 'return_items.item_id = items.id', 'left');
        $this->db->join('units', 'return_items.unit_id = units.id', 'left');
        $this->db->join('customers c', 'c.id = i.customer_id', 'left');
        $this->db->where('r.id', $id);

        $query = $this->db->get();

        if (!$query) {
            log_message('error', 'Database error: ' . $this->db->last_query());
            return false;
        }

        return $query->row();
    }

    public function get_all_items()
    {
        $this->db->select('id, item_name, item_price, item_description');
        return $this->db->get('items')->result();
    }


    public function update_return($return_id, $return_data, $return_items_data)
    {
        $this->db->where('id', $return_id);
        $this->db->update('returns', $return_data);

        $this->db->where('return_id', $return_id);
        $this->db->delete('return_items');

        foreach ($return_items_data as &$item) {
            $item['return_id'] = $return_id;
        }
        $this->db->insert_batch('return_items', $return_items_data);

        return true; 
    }


    public function delete_return($return_id)
    {
        $this->db->where('id', $return_id);
        $this->db->delete('returns');

        $this->db->where('return_id', $return_id);
        return $this->db->delete('return_items');
    }



}