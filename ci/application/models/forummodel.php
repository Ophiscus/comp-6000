<?php
class Forummodel extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}
	
	//Retrieves all messages in database and passes it to the controller
	public function getPosts() {
		$sql = "SELECT Poster, Subject, Content, PostDate, MessageType FROM Announcements ORDER BY PostDate DESC"; //Announcements should be ForumPosts

		$query = $this->db->query($sql);
		
		return $query->result_array();
	}
	
	//Retrieves all comment data
	public function getComments() {
		$sql = "SELECT Poster, Subject, Poster, PostDate, CommentContent FROM Replies ORDER BY PostDate DESC";

		$query = $this->db->query($sql);
		
		return $query->result_array();
	}
	
	public function insertMessage($title, $string, $type)
	{
		$data['Subject'] = $title;
		$data['Content'] = $string;
		$data['MessageType'] = $type;
		$data['Poster'] = 1;
		$data['PostDate'] = date("Y-m-d h:i:sa");
		
		$this->db->insert('Announcements', $data); //Announcements should be ForumPosts
	}
	
	public function insertReply($title, $string, $replyto) {
		$data['Subject'] = $title;
		$data['Poster'] = 1;
		$data['PostDate'] = date("Y-m-d h:i:sa");
		$data['CommentContent'] = $string;
		$data['ReplyTo'] = $replyto;
		
		$this->db->insert('Replies', $data);
	}
}
?>