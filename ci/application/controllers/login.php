<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation'); 											//this loads the form validation function
		$this->load->library('session');
		$this->load->helper(array('form', 'url'));
		$this->load->database();
	}

	public function index()
	{
		
		//redirect(base_url().'User/View/'.$this->session->userdata('username'));
		$this->showView();
	}
	
	public function showView()
	{
		$this->load->view('loginview');
	}
	
	function dologin()
	{
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('loginview');
		} else {

			$username = $this->input->post('username');
			$password = $this->input->post('password');

			$this->db->limit(1);
			$user = $this->db->get_where('Staff',['username' => $username]);

		

			$this->load->model('Login_Model');

			if(!$user) {
				$this->session->set_flashdata('login_error', 'Please check your username or password and try again.', 300);
				redirect(uri_string());
			}
			//if(!password_verify($password,$user->password)) {
			if(!$this->Login_Model->checkLogin($username,$password)) {
				$this->session->set_flashdata('login_error', 'Please check your email or password and try again.', 300);
				redirect(uri_string());
			}
			
			$results = $user->row();
			 $data = array(
					'username' => $results->username,
					'first_name' => $results->{'First Name'},
					'last_name' => $results->{'Last Name'},
					'password' => $results->password,
					'role' => $results->Role,
					);

				
			$this->session->set_userdata($data);

			//redirect('/'); // redirect to home
			//echo 'Login success!'; exit;
			redirect('/Forum/show');
			
		}		
	}

	public function logout(){
        $this->session->sess_destroy();
        redirect('user/login');
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