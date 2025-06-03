<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Invoice_Model extends CI_Model
{
    public function get_all_items()
    {
        $this->db->select('id, item_name, item_price, item_description');
        return $this->db->get('items')->result();
    }

    public function get_all_invoices_copy()
    {
        $this->db->select('invoices_copy.id as invoice_id, invoices_copy.customer_id, invoices_copy.created_at, 
                       invoice_items_copy.item_id, invoice_items_copy.quantity, invoice_items_copy.total, 
                       items.item_name, invoice_items_copy.item_price, invoice_items_copy.item_description, 
                       units.unit_name, customers.customer_name, customers.address as customer_address');
        $this->db->from('invoices_copy');
        $this->db->join('invoice_items_copy', 'invoice_items_copy.invoice_id = invoices_copy.id', 'left');
        $this->db->join('items', 'invoice_items_copy.item_id = items.id', 'left');
        $this->db->join('units', 'invoice_items_copy.unit_id = units.id', 'left');
        $this->db->join('customers', 'customers.id = invoices_copy.customer_id', 'left');
        return $this->db->get()->result();
    }

    public function save_invoice_copy_sp($customer_id, $items_data)
    {
        $json_items = json_encode($items_data);

        $sql = "CALL sp_save_invoice_copy(?, ?)";
        $this->db->query($sql, array($customer_id, $json_items));

        return true;
    }

    public function get_invoice_by_id_copy($id)
    {
        $this->db->select('invoices_copy.*, customers.customer_name, customers.address as customer_address');
        $this->db->from('invoices_copy');
        $this->db->join('customers', 'customers.id = invoices_copy.customer_id', 'left');
        $this->db->where('invoices_copy.id', $id);
        return $this->db->get()->row();
    }

    public function get_invoice_items_copy($invoice_id)
    {
        $this->db->select('invoice_items_copy.*, items.item_name, items.item_description, units.unit_name');
        $this->db->from('invoice_items_copy');
        $this->db->join('items', 'items.id = invoice_items_copy.item_id', 'left');
        $this->db->join('units', 'units.id = invoice_items_copy.unit_id', 'left');
        $this->db->where('invoice_items_copy.invoice_id', $invoice_id);
        return $this->db->get()->result();
    }

    public function save_invoice($invoice_data, $items_data)
    {
        $customer_id = $invoice_data['customer_id'];
        $json_items = json_encode($items_data);

        $sql = "CALL sp_save_invoice_copy(?, ?)";
        $result = $this->db->query($sql, array($customer_id, $json_items));

        return $result;
    }

    public function get_invoice_by_id($id)
    {
        $this->db->select('invoices.*, customers.customer_name, customers.address as customer_address');
        $this->db->from('invoices');
        $this->db->join('customers', 'customers.id = invoices.customer_id', 'left');
        $this->db->where('invoices.id', $id);
        return $this->db->get()->row();
    }

    public function get_invoice_items($invoice_id)
    {
        $this->db->select('invoice_items.*, items.item_name, items.item_description, units.unit_name');
        $this->db->from('invoice_items');
        $this->db->join('items', 'items.id = invoice_items.item_id', 'left');
        $this->db->join('units', 'units.id = invoice_items.unit_id', 'left');
        $this->db->where('invoice_items.invoice_id', $invoice_id);

        return $this->db->get()->result();
    }

    public function update_invoice($invoice_id, $invoice_data, $items_data)
    {
        $this->db->where('id', $invoice_id);
        $this->db->update('invoices', $invoice_data);

        $this->db->where('invoice_id', $invoice_id);
        $this->db->delete('invoice_items');

        foreach ($items_data as &$item) {
            $item['invoice_id'] = $invoice_id;
        }

        $this->db->insert_batch('invoice_items', $items_data);
    }
    public function update_invoice_copy($invoice_id, $invoice_data, $items_data)
    {

        $this->db->where('id', $invoice_id);
        $this->db->update('invoices_copy', $invoice_data);

        $this->db->where('invoice_id', $invoice_id);
        $this->db->delete('invoice_items_copy');

        foreach ($items_data as &$item) {
            $item['invoice_id'] = $invoice_id;
        }
        $this->db->insert_batch('invoice_items_copy', $items_data);
    }


    public function delete_invoice($invoice_id)
    {
        $this->db->where('invoice_id', $invoice_id);
        $this->db->delete('invoice_items');

        $this->db->where('id', $invoice_id);
        $this->db->delete('invoices');
    }

    public function delete_invoice_copy($invoice_id)
    {
        $this->db->where('invoice_id', $invoice_id);
        $this->db->delete('invoice_items_copy');

        $this->db->where('id', $invoice_id);
        $this->db->delete('invoices_copy');
    }

    

    public function get_all_invoices()
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
        return $this->db->get()->result();
    }

}
