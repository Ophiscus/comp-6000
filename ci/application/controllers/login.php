<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation'); 
        $this->load->helper('form');		//this loads the form validation function
		$this->load->library('session');
		$this->load->helper(array('form', 'url'));
		$this->load->database();
		$this->load->model('Login_Model');
	}

	public function index()
	{
		
		//redirect(base_url().'User/View/'.$this->session->userdata('username'));
		
	}
	
	public function Show()
	{
		$this->load->view('loginview');
	}

	

	function dologin()
	{
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		
		if($this->form_validation->run() == FALSE)
		{
			$this->load->view('loginview');
		}
		else {
			$data = [
			$username = $this->input->post('username'),
		    $password = $this->input->post('password')
		];
		   $user = new Login_Model();
		   $result = $user->checkLogin($data);
		   if($result != FALSE)
		   {
			 $this->session->set_flashdata('status', 'you are logged in successfully');
			 $this->session->set_userdata($data);
			 redirect('Forum/Show');
		   }
		   else
		   {
			   $this->session->set_flashdata('error', 'Invalid Username or Password');
               redirect('Login/Show');			   
		   }
		}
    }
		

		
		




	function logout(){
        $this->session->sess_destroy();
        redirect('index.php/login/Show');
    }


		//$username = $this->input->post('username');
		//$_SESSION['username'] = $username;

		//$this->load->model('Login_Model');
		//$user_exists = $this->Login_Model->checkLogin(
			//$this->input->post('username'),													//collect //username from form and agaist with database
			//$this->input->post('password')
		//);

		//if ($user_exists) 
			//$data = array('session_data' => $this->Login_Model->getSessionInfo($_SESSION['username']));
			//$this->load->view('forumview',$data);                                               
		
		//else {
			//session_destroy();
			//$this->session->set_flashdata('error', 'Invalid Username or Password');  		//When the user login fails an error message display and redirect to the login form.
			//redirect('/Login/showView','refresh');
		//}
	

}
?>
