<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forum extends CI_Controller {
	
	public function show()
	{
		$this->load->helper('url');
		$this->load->model('Forummodel');
		
		$data = $this->Forummodel->getPosts();
		
		//Loads user data set in the login script
		$this->load->library('session');
		
		$results = array("results" => $data);
		
		//Passes message data from model to the view
		$this->load->view('forumview', $results);
	}
	
	public function post()
	{
		$this->load->model('Forummodel');
	
		$title = $this->input->post('title');
		$message = $this->input->post('post_cont');
	
		$this->Forummodel->insertMessage($title, $message);
		
		//Reload the page
		$this->load->helper('url');
		$this->load->model('Forummodel');
		$data = $this->Forummodel->getPosts();
		$results = array("results" => $data);
		$this->load->view('forumview', $results);
	}
}
?>