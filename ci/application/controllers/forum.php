<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forum extends CI_Controller {
	
	public function view()
	{
		$this->load->helper('url');
		$this->load->model('forummodel');
		
		$data = $this->forummodel->getPosts();

		$results = array("results" => $data);
		
		//Passes message data from model to the view
		$this->load->view('forumview', $results);
	}
}

?>