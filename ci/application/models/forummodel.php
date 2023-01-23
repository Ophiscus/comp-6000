<?php
class Forummodel extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
		
		//Loads user data set in the login script
		$this->load->library('session');
	}
	
	//Retrieves all messages in database and passes it to the controller
	public function getPosts() {
		$sql = "SELECT PostID, Poster, Subject, Content, PostDate, MessageType FROM ForumPosts ORDER BY PostDate DESC";

		$query = $this->db->query($sql);
		
		return $query->result_array();
	}
	
	//Retrieves all comment data
	public function getComments() {
		$sql = "SELECT CommentSubject, CommentPoster, CommentPostDate, CommentContent FROM Replies ORDER BY CommentPostDate DESC";

		$query = $this->db->query($sql);
		
		return $query->result_array();
	}
	
	public function insertMessage($title, $string, $type)
	{
		$data['Subject'] = $title;
		$data['Content'] = $string;
		$data['MessageType'] = $type;
		$data['Poster'] = $this->session->userdata('staffid');
		$data['PostDate'] = date('Y-m-d H:i:s');
		
		$this->db->insert('ForumPosts', $data);
	}
	
	public function insertReply($title, $string, $replyto) {
		$data['CommentSubject'] = $title;
		$data['CommentPoster'] = $this->session->userdata('staffid');
		$data['CommentPostDate'] = date("Y-m-d h:i:sa");
		$data['CommentContent'] = $string;
		$data['ReplyTo'] = $replyto;
		
		$this->db->insert('Replies', $data);
	}
	
	public function getPoster($posterID) {
		$sql = "SELECT 'First Name', 'Last Name' FROM Staff WHERE StaffID = " + $posterID;

		$query = $this->db->query($sql);
		
		return $query->result_array();
	}
}
?>