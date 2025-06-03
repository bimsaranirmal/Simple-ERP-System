<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item_Model extends CI_Model {

    public function get_all_items()
    {
        return $this->db->get('items')->result();
    }

    public function get_item_by_id($id)
    {
        return $this->db->where('id', $id)->get('items')->row();
    }

    public function insert_item($data)
    {
        return $this->db->insert('items', $data);
    }

    public function update_item($id, $data)
    {
        return $this->db->where('id', $id)->update('items', $data);
    }

    public function delete_item($id)
    {
        return $this->db->where('id', $id)->delete('items');
    }
}