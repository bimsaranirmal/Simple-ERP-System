<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_Controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Item_Model');
    }

    public function index()
    {
        $data['items'] = $this->Item_Model->get_all_items();
        $this->load->view('dashboard', $data);
    }

    public function item()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $item_name = trim($this->input->post('item_name'));
            $item_price = trim($this->input->post('item_price'));
            $item_description = trim($this->input->post('item_description'));

            if (empty($item_name) || empty($item_price) || empty($item_description)) {
                echo "<script>alert('All fields are required.');</script>";
                return;
            }

            if (!is_numeric($item_price)) {
                echo "<script>alert('Price must be a number.');</script>";
                return;
            }

            $data = [
                'item_name' => $item_name,
                'item_price' => $item_price,
                'item_description' => $item_description,
            ];

            if ($this->Item_Model->insert_item($data)) {
                echo "<script>
                    alert('Item successfully inserted!');
                    window.location.href = '" . base_url('dashboard') . "';
                </script>";
            } else {
                echo "<script>alert('Failed to insert item. Please try again.');</script>";
            }
        }
    }

    public function edit($id)
    {
        $data['item'] = $this->Item_Model->get_item_by_id($id);
        $this->load->view('edit_item', $data);
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $this->input->post('item_id');
            $item_name = $this->input->post('item_name');
            $item_price = $this->input->post('item_price');
            $item_description = $this->input->post('item_description');

            if (empty($id) || empty($item_name) || empty($item_price) || empty($item_description)) {
                echo "<script>alert('All fields are required.');</script>";
                return;
            }

            if (!is_numeric($item_price)) {
                echo "<script>alert('Price must be a number.');</script>";
                return;
            }

            $data = [
                'item_name' => $item_name,
                'item_price' => $item_price,
                'item_description' => $item_description,
            ];

            if ($this->Item_Model->update_item($id, $data)) {
                echo "<script>
                    alert('Item updated successfully!');
                    window.location.href = '" . base_url('dashboard') . "';
                </script>";
            } else {
                echo "<script>alert('Failed to update item. Please try again.');</script>";
            }
        }
    }

    public function delete($id)
    {
        if ($this->Item_Model->delete_item($id)) {
            echo "<script>
                alert('Item deleted successfully!');
                window.location.href = '" . base_url('dashboard') . "';
            </script>";
        } else {
            echo "<script>alert('Failed to delete item. Please try again.');</script>";
        }
    }
}