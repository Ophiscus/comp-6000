<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{public function index()
	{
		//redirect(base_url().'User/View/'.$this->session->userdata('username'));
		$this->load->view('loginview');
	}

	function dologin()
	{
		$username = $this->input->post('username');
		$_SESSION['username'] = $username;

		$this->load->model('Login_Model');
		$user_exists = $this->User_Model->checkLogin(
			$this->input->post('username'),													//collect username from form and agaist with database
			$this->input->post('password')
		);

		if ($user_exists) {
			
			$this->load->view('Forumview');
		}
		else {
			//session_destroy();
			$this->session->set_flashdata('error', 'Invalid Username or Password');  		//When the user login fails an error message display and redirect to the login form.
			redirect('index.php/User/login');
		}
	}














}
