<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_Controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Login_Model'); // Load the Login_Model
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($this->input->post('email'));
            $password = trim($this->input->post('password'));

            // Validate input
            if (empty($email) || empty($password)) {
                echo "<script>alert('Email and password are required.');</script>";
                return;
            }

            // Fetch user by email
            $user = $this->Login_Model->get_user_by_email($email);

            // Verify password
            if ($user && password_verify($password, $user->password)) {
                echo "<script>
                    alert('Login successful! Redirecting to dashboard...');
                    window.location.href = '" . base_url('chart') . "';
                </script>";
            } else {
                echo "<script>alert('Invalid email or password.');</script>";
            }
        }

        // Load the login view
        $this->load->view('login');
    }
}