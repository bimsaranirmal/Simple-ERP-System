<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_Model extends CI_Model {

    public function get_all_customers()
    {
        return $this->db->get('customers')->result();
    }

    public function insert_customer($data)
    {
        return $this->db->insert('customers', $data);
    }

    public function get_customer_by_id($id)
    {
        return $this->db->where('id', $id)->get('customers')->row();
    }

    public function update_customer($id, $data)
    {
        return $this->db->where('id', $id)->update('customers', $data);
    }

    public function delete_customer($id)
    {
        return $this->db->where('id', $id)->delete('customers');
    }
}