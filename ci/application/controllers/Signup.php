<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Signup extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation'); 											//this loads the form validation function
		$this->load->library('session');
		$this->load->helper(array('form', 'url'));
		$this->load->database();
	}

    public function show()
    {
        $this->load->view("Signup";)
    }
// Acknowledge the input of the employee's credentials
    public function dosignup()
    {
        // load up database to input the new employee's infomation
        $this->load->database();
        $this->load->model('Signup_Model');
        $firstname = $this->input->post('firstname');
        $lastname = $this->input->post('firstname');
        $email = $this->input->post('password');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $accesslevel = $this->input->post('accesslevel');
        $this->Signup_Model->addUser($username,$password);
    }
}
?>