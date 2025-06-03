<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Invoice_Controller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Invoice_Model');
    }

    public function index()
    {
        $this->load->model('Customer_Model');
        $this->load->model('Unit_Model');
        $data['customers'] = $this->Customer_Model->get_all_customers();
        $data['items'] = $this->Invoice_Model->get_all_items();
        $data['units'] = $this->Unit_Model->get_all_units();
        $data['invoices'] = $this->Invoice_Model->get_all_invoices_copy(); // Using copy table
        $this->load->view('invoice', $data);
    }



    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $customer_id = $this->input->post('customer_id');
            $item_ids = $this->input->post('item_id');
            $unit_ids = $this->input->post('unit_id');
            $item_prices = $this->input->post('item_price');
            $quantities = $this->input->post('quantity');
            $item_descriptions = $this->input->post('item_description');

            if (empty($customer_id) || empty($item_ids)) {
                echo "<script>alert('Customer and at least one item are required.');</script>";
                return;
            }

            $items_data = [];
            foreach ($item_ids as $index => $item_id) {
                $quantity = $quantities[$index];
                $total = $item_prices[$index] * $quantity;
                $items_data[] = [
                    'item_id' => (int) $item_id,
                    'unit_id' => (int) $unit_ids[$index],
                    'item_price' => (float) $item_prices[$index],
                    'quantity' => (float) $quantity,
                    'total' => (float) $total,
                    'item_description' => $item_descriptions[$index] ?? ''
                ];
            }

            $this->Invoice_Model->save_invoice_copy_sp($customer_id, $items_data);

            echo "<script>
                alert('Invoice saved successfully!');
                window.location.href = '" . base_url('invoice') . "';
            </script>";
        }
    }

    public function edit($id)
    {
        $this->load->model('Customer_Model');
        $this->load->model('Unit_Model');

        $data['invoice'] = $this->Invoice_Model->get_invoice_by_id_copy($id);
        $data['invoice_items'] = $this->Invoice_Model->get_invoice_items_copy($id);
        $data['customers'] = $this->Customer_Model->get_all_customers();
        $data['units'] = $this->Unit_Model->get_all_units();
        $data['items'] = $this->Invoice_Model->get_all_items();

        $this->load->view('edit_invoice', $data);
    }


    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $invoice_id = $this->input->post('invoice_id');
            $customer_id = $this->input->post('customer_id');
            $item_ids = $this->input->post('item_id');
            $unit_ids = $this->input->post('unit_id');
            $item_prices = $this->input->post('item_price');
            $quantities = $this->input->post('quantity');
            $totals = $this->input->post('total');
            $item_descriptions = $this->input->post('item_description');

            // Validate required fields
            if (empty($invoice_id) || empty($customer_id) || empty($item_ids)) {
                echo "<script>alert('Customer and at least one item are required.');</script>";
                return;
            }

            // Prepare invoice data
            $invoice_data = [
                'customer_id' => $customer_id,
            ];

            // Prepare items data
            $items_data = [];
            foreach ($item_ids as $index => $item_id) {
                $items_data[] = [
                    'item_id' => $item_id,
                    'unit_id' => $unit_ids[$index],
                    'item_price' => $item_prices[$index],
                    'quantity' => $quantities[$index],
                    'total' => $totals[$index],
                    'item_description' => $item_descriptions[$index],
                ];
            }

            // Use the copy tables update method
            $this->Invoice_Model->update_invoice_copy($invoice_id, $invoice_data, $items_data);

            echo "<script>
            alert('Invoice updated successfully!');
            window.location.href = '" . base_url('invoice') . "';
        </script>";
        }
    }


    public function delete($id)
    {
        if (!empty($id)) {
            $this->Invoice_Model->delete_invoice_copy($id);

            echo "<script>
                alert('Invoice deleted successfully!');
                window.location.href = '" . base_url('invoice') . "';
            </script>";
        } else {
            echo "<script>
                alert('Invalid invoice ID!');
                window.location.href = '" . base_url('invoice') . "';
            </script>";
        }
    }

    
}