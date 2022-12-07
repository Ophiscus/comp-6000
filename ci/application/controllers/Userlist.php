<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Userlist extends CI_Controller {
	
	public function show()
	{
		$this->load->helper('url');
		$this->load->model('Userlistmodel');
		
		$data = $this->Userlistmodel->getUsers();

		$results = array("results" => $data);
		
		//Passes message data from model to the view
		$this->load->view('userlistview', $results);
	}
}

?>