<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forum extends CI_Controller {
	
	//Loads all data required for the view
	public function getViewData() {
		$data = $this->Forummodel->getPosts();
		$comment_data = $this->Forummodel->getComments();
		$user_data = $this->Forummodel->getUsers();
		
		//Loads user data set in the login script
		$this->load->library('session');
		
		$results = array("postData" => $data, "commentData" => $comment_data, "userData" => $user_data);
		
		//Passes message data from model to the view
		$this->load->view('forumview', $results);
	}
	
	public function show() {
		$this->load->helper('url');
		$this->load->model('Forummodel');
		
		$this->getViewData();
	}
	
	//Posts a new message
	public function post() {
		$this->load->model('Forummodel');
		$this->load->helper('url');
	
		$title = $this->input->post('title');
		$message = $this->input->post('post_cont');
		$type = $this->input->post('type_select');
	
		$this->Forummodel->insertMessage($title, $message, $type);
		
		$this->getViewData();
	}
	
	//Posts a new comment
	public function post_comment() {
		$this->load->helper('url');
		$this->load->model('Forummodel');
	
		$reply = $this->input->post('ccontent');
		$reply_to = $this->input->post('reply_to'); 
	
		$this->Forummodel->insertReply($reply, $reply_to);
		
		$this->getViewData();
	}
	
	//Sends updated content from view to database, then reloads view
	public function updatePost() {
		$this->load->helper('url');
		$this->load->model('Forummodel');

		$subject = $this->input->post('edit_sub');
		$message = $this->input->post('edit_mes');
		$postid = $this->input->post('edit_id');
		
		$this->Forummodel->editTable($subject, $message, $postid);
		
		$this->getViewData();
	}
}
?>