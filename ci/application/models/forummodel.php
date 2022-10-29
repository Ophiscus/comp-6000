<?php
class Messages_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}
	
	//Retrieves all messages in database and passes it to the controller
	public function getPosts()
	{
		$sql = "SELECT Subject, Content FROM Announcements";

		$query = $this->db->query($sql);
		
		return $query->result_array();
	}	
}
?>