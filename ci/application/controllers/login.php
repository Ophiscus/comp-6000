<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation'); 											//this loads the form validation function
		$this->load->library('session');
		$this->load->helper('url');
	}

	public function index()
	{
		//redirect(base_url().'User/View/'.$this->session->userdata('username'));
		
	}
	
	public function showView()
	{
		$this->load->view('loginview');
	}
	
	function dologin()
	{
		$username = $this->input->post('username');
		$_SESSION['username'] = $username;

		$this->load->model('Login_Model');
		$user_exists = $this->Login_Model->checkLogin(
			$this->input->post('username'),													//collect //username from form and agaist with database
			$this->input->post('password')
		);

		if ($user_exists) {
			
			$this->load->view('forumview');                                               
		}
		else {
			//session_destroy();
			$this->session->set_flashdata('error', 'Invalid Username or Password');  		//When the user login fails an error message display and redirect to the login form.
			redirect('/Login/showView','refresh');
		}
	}

}
?>