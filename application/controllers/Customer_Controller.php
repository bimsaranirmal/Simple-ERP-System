<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_Controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Customer_Model');
    }

    public function index()
    {
        $data['customers'] = $this->Customer_Model->get_all_customers();
        $this->load->view('customer', $data);
    }

    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'customer_name' => $this->input->post('customer_name'),
                'customer_code' => $this->input->post('customer_code'),
                'address' => $this->input->post('address'),
                'mobile' => $this->input->post('mobile')
            ];

            if ($this->input->post('id')) {
                $this->Customer_Model->update_customer($this->input->post('id'), $data);
            } else {
                $this->Customer_Model->insert_customer($data);
            }
            redirect('customer');
        }
    }

    public function edit($id)
    {
        $data['customer'] = $this->Customer_Model->get_customer_by_id($id);
        $this->load->view('customer_form', $data);
    }

    public function delete($id)
    {
        $this->Customer_Model->delete_customer($id);
        redirect('customer');
    }
}