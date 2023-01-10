<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forum extends CI_Controller {
	
	public function show() {
		$this->load->helper('url');
		$this->load->model('Forummodel');
		
		$data = $this->Forummodel->getPosts();
		$comment_data = $this->Forummodel->getComments();
		
		//Loads user data set in the login script
		$this->load->library('session');
		
		$results = array("results" => $data);
		$comment_results = array("comment_results" => $comment_data);
		
		//Passes message data from model to the view
		$this->load->view('forumview', ($results + $comment_results));
	}
	
	public function post() {
		$this->load->model('Forummodel');
	
		$title = $this->input->post('title');
		$message = $this->input->post('post_cont');
		$type = $this->input->post('type_select');
	
		$this->Forummodel->insertMessage($title, $message, $type);
		
		//Reload the page
		$this->load->helper('url');
		$this->load->model('Forummodel');
		$data = $this->Forummodel->getPosts();
		
		//Loads user data set in the login script
		$this->load->library('session');
		
		$results = array("results" => $data);
		$this->load->view('forumview', $results);
	}
	
	public function post_comment() {
		$this->load->model('Forummodel');
	
		$title = $this->input->post('comment_title');
		$message = $this->input->post('comment_cont');
	
		$this->Forummodel->insertReply($title, $message);
		
		//Reload the page
		$data = $this->Forummodel->getPosts();
		$comment_data = $this->Forummodel->getComments();
		
		//Loads user data set in the login script
		$this->load->library('session');
		
		$results = array("results" => $data);
		$comment_results = array("comment_results" => $comment_data);
		
		//Passes message data from model to the view
		$this->load->view('forumview', ($results + $comment_results));
	}
}
?>