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
		$sql = "SELECT CommentSubject, CommentPoster, CommentPostDate, CommentContent, ReplyTo FROM Replies ORDER BY CommentPostDate DESC";
		
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
	
	public function insertReply($reply, $replyto) {
		$data['CommentPoster'] = $this->session->userdata('staffid');
		$data['CommentPostDate'] = date("Y-m-d h:i:sa");
		$data['CommentContent'] = $reply;
		$data['ReplyTo'] = $replyto;
		
		$this->db->insert('Replies', $data);
	}
	
	public function getUsers() {
		//$sql = "SELECT `First Name`, `Last Name`, StaffID FROM Staff";

		//$query = $this->db->query($sql);
		$query = $this->db->query("SELECT FirstName, LastName, StaffID FROM Staff");
		
		return $query->result_array();
	}
	
	public function editTable($subject, $message, $postid) {
		//$sql = "UPDATE ForumPosts SET Subject = " . $subject . ", Content = " . $message . " WHERE PostID = " . $postid;

		$data = array('Subject'=>$subject,'Content'=>$message);
		$this->db->where('PostID',$postid);
		$this->db->update('ForumPosts',$data);

	}
}
?>