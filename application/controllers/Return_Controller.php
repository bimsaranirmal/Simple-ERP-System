<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Return_Controller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session'); 
        $this->load->model('Return_Model');
    }

    public function index()
    {
        $this->load->model('Customer_Model'); 
        $this->load->model('Item_Model');
        $this->load->model('Unit_Model'); 
        $this->load->model('Invoice_Model');

        $data['customers'] = $this->Customer_Model->get_all_customers(); 
        $data['items'] = $this->Item_Model->get_all_items();
        $data['units'] = $this->Unit_Model->get_all_units();
        $data['invoices'] = $this->Invoice_Model->get_all_invoices(); 

        $this->load->view('return', $data); 
    }

    public function view_returns()
    {
        $this->load->model('Customer_Model');
        $this->load->model('Item_Model');
        $this->load->model('Unit_Model');
        $this->load->model('Return_Model');  

        $data['customers'] = $this->Customer_Model->get_all_customers(); 
        $data['items'] = $this->Item_Model->get_all_items();
        $data['units'] = $this->Unit_Model->get_all_units();
        $data['returns'] = $this->Return_Model->get_all_returns(); 

        $this->load->view('return', $data);
    }
    public function get_invoices_by_customer()
    {
        $customer_id = $this->input->post('customer_id'); 

        if (!empty($customer_id)) {
            $invoices = $this->Return_Model->get_invoices_by_customer($customer_id); 
            echo json_encode($invoices);
        } else {
            echo json_encode(['error' => 'Customer ID not provided']);
        }
    }

    public function get_invoice_items()
    {
        $invoice_id = $this->input->post('invoice_id'); 

        if (!empty($invoice_id)) {
            $this->load->model('Return_Model'); 
            $items = $this->Return_Model->get_invoice_items($invoice_id); 

            if ($items) {
                echo json_encode($items);
            } else {
                echo json_encode(['error' => 'No items found for the selected invoice.']);
            }
        } else {
            echo json_encode(['error' => 'Invoice ID not provided.']);
        }
    }

    public function get_all_items()
    {
        $this->load->model('Item_Model');
        $items = $this->Item_Model->get_all_items();
        echo json_encode($items); 
    }

    public function get_all_units()
    {
        $this->load->model('Unit_Model'); 
        $units = $this->Unit_Model->get_all_units(); 
        echo json_encode($units);
    }

    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $customer_id = $this->input->post('customer_id');
            $invoice_id = $this->input->post('invoice_id');
            $item_ids = $this->input->post('item_id');
            $unit_ids = $this->input->post('unit_id');
            $item_prices = $this->input->post('item_price');
            $quantities = $this->input->post('quantity');
            $item_descriptions = $this->input->post('item_description');

            if (empty($customer_id) || empty($invoice_id) || empty($item_ids)) {
                echo "<script>alert('Customer, invoice, and at least one item are required.');</script>";
                return;
            }

            $return_id = 'RET-' . date('YmdHis') . '-' . rand(100, 999);
            $return_data = [
                'invoice_id' => $invoice_id,
                'customer_id' => $customer_id,
                'created_at' => date('Y-m-d H:i:s'),  
            ];

            $return_items_data = [];
            foreach ($item_ids as $index => $item_id) {
                $quantity = $quantities[$index];
                $total = $item_prices[$index] * $quantity;
                $return_items_data[] = [
                    'item_id' => $item_id,
                    'unit_id' => $unit_ids[$index],
                    'price' => $item_prices[$index],
                    'quantity' => $quantity,
                    'total' => $total,
                    'item_description' => $item_descriptions[$index] ?? '',
                ];
            }

            $this->load->model('Return_Model');
            $header_id = $this->Return_Model->save_return($return_data, $return_items_data);

            foreach ($return_items_data as $return_item) {
                $return_item['return_id'] = $header_id; 
                $this->Return_Model->save_return_item($return_item);
            }

            echo "<script>
            alert('Return invoice saved successfully!');
            window.location.href = '" . base_url('return/view_returns') . "';
        </script>";
        }
    }

    public function edit($id)
    {
        $this->load->model('Customer_Model');
        $this->load->model('Unit_Model');

        $data['return'] = $this->Return_Model->get_return_by_id($id);
        $data['return_items'] = $this->Return_Model->get_return_items($id);
        $data['customers'] = $this->Customer_Model->get_all_customers();
        $data['units'] = $this->Unit_Model->get_all_units();
        $data['items'] = $this->Return_Model->get_all_items();

        $this->load->view('edit_return', $data);
    }


    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get input data
            $return_id = $this->input->post('return_id');

            if (empty($return_id)) {
                echo "<script>alert('Return ID is missing.');</script>";
                return;
            }
            $customer_id = $this->input->post('customer_id');
            $invoice_id = $this->input->post('invoice_id');
            $item_ids = $this->input->post('item_id');
            $unit_ids = $this->input->post('unit_id');
            $item_prices = $this->input->post('item_price');
            $quantities = $this->input->post('quantity');
            $item_descriptions = $this->input->post('item_description');

            $return_id = $this->input->post('return_id');
            $return_data = [
                'invoice_id' => $invoice_id,
                'customer_id' => $customer_id,
                'created_at' => date('Y-m-d H:i:s'), 
            ];

            $return_items_data = [];
            foreach ($item_ids as $index => $item_id) {
                $quantity = $quantities[$index];
                $total = $item_prices[$index] * $quantity;
                $return_items_data[] = [
                    'item_id' => $item_id,
                    'unit_id' => $unit_ids[$index],
                    'price' => $item_prices[$index],
                    'quantity' => $quantity,
                    'total' => $total,
                    'item_description' => $item_descriptions[$index] ?? '',
                    'return_id' => $return_id,  
                ];
            }

            $this->Return_Model->update_return($return_id, $return_data, $return_items_data); 

            // Output success message and redirect to return invoices list
            echo "<script>
            alert('Return invoice update successfully!');
            window.location.href = '" . base_url('return') . "';
        </script>";
        }
    }

    public function delete($id)
    {
        $this->Return_Model->delete_return($id);
        redirect('return/view_returns');
    }
}