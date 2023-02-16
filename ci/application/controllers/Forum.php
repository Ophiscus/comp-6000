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
		
		$results = array("postData" => $data, "commentData" => $comment_data);
		
		//Passes message data from model to the view
		$this->load->view('forumview', $results);
		//$this->load->view('testview');
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
		$this->load->helper('url');
		$this->load->model('Forummodel');
	
		$reply = $this->input->post('ccontent');
		$reply_to = $this->input->post('reply_to'); 
	
		$this->Forummodel->insertReply($reply, $reply_to);
		
		$data = $this->Forummodel->getPosts();
		$comment_data = $this->Forummodel->getComments();
		
		//Loads user data set in the login script
		$this->load->library('session');
		
		$results = array("postData" => $data, "commentData" => $comment_data);
		
		//Passes message data from model to the view
		$this->load->view('forumview', $results);
	}
	
	public function updatePost() {
		$this->load->helper('url');
		$this->load->model('Forummodel');
		
		$subject = $this->input->post('edit_sub');
		$message = $this->input->post('edit_mes');
		
		
	}
}
?>