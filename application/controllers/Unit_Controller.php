<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Unit_Controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Unit_Model');
    }

    public function index()
    {
        $data['units'] = $this->Unit_Model->get_all_units();
        $this->load->view('unit', $data);
    }

    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'unit_name' => $this->input->post('unit_name'),
                'unit_code' => $this->input->post('unit_code')
            ];

            $this->Unit_Model->insert_unit($data);
            redirect('unit');
        }
    }

    public function delete($id)
    {
        $this->Unit_Model->delete_unit($id);
        redirect('unit');
    }
}