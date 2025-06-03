<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Unit_Model extends CI_Model {

    public function get_all_units()
    {
        return $this->db->get('units')->result();
    }

    public function insert_unit($data)
    {
        return $this->db->insert('units', $data);
    }

    public function get_unit_by_id($id)
    {
        return $this->db->where('id', $id)->get('units')->row();
    }

    public function update_unit($id, $data)
    {
        return $this->db->where('id', $id)->update('units', $data);
    }

    public function delete_unit($id)
    {
        return $this->db->where('id', $id)->delete('units');
    }
}