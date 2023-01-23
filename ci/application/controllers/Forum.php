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
		$results = $results /*+ $comment_results*/;
		
		//Adds usernames to results
		/*for ($i = 0; $i < count($results); $i++) { 
			$posterName = $this->Forummodel->getPoster($results[$i]['Poster']);
			$results[$i]['PosterName'] = $posterName['First Name'] + $posterName['Last Name'];
		}*/
		
		//Trying with for each loop instead
		/*foreach ($results as $row) {
			$posterName = $this->Forummodel->getPoster($row['Poster']);
			$row['PosterName'] = $posterName['First Name'] + $posterName['Last Name'];
		}*/
		
		/*
		// That's exactly how result_array() returns your result
		$updated_results = array(
			array('PostID' => $results['PostID']),
			array('Subject' => $results['Subject']),
			array('Poster' => $results['Poster']),
			array('PostDate' => $results['PostDate']),
			array('Content' => $results['Content']),
			array('MessageType' => $results['MessageType']),
			array('PosterName' => $this->Forummodel->getPoster($results[$i]['Poster']))
		);

		// That's an empty result array
		$result = array();

		// Processing in your controller
		foreach ($articles as $key => $article)
		{
			$result[$numbers[$key]] = $article['title'];
		}
		*/
		
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
		$reply_to = $this->input->post(); 
	
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