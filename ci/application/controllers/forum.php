<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class forum extends CI_Controller {
	
	public function view()
	{
		$this->load->model('forummodel');
		
		$data = $this->forummodel->getPosts();

		$results = array("results" => $data);
		
		//Passes message data from model to the view
		$this->load->view('ViewMessages', $results);
	}
}

?>