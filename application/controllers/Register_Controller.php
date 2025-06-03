<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register_Controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Register_Model'); 
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($this->input->post('name'));
            $email = trim($this->input->post('email'));
            $password = trim($this->input->post('password'));

            if (empty($name) || empty($email) || empty($password)) {
                echo "<script>alert('All fields are required.');</script>";
                return;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "<script>alert('Invalid email format.');</script>";
                return;
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $data = [
                'name' => $name,
                'email' => $email,
                'password' => $hashedPassword,
            ];

            if ($this->Register_Model->insert_user($data)) {
                echo "<script>
                    alert('Registration successful! Redirecting to login page...');
                    window.location.href = '" . base_url('login') . "';
                </script>";
            } else {
                echo "<script>alert('Failed to register. Please try again.');</script>";
            }
        }

        $this->load->view('register');
    }
}