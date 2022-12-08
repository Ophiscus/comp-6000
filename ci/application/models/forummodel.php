<?php
class Forummodel extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}
	
	//Retrieves all messages in database and passes it to the controller
	public function getPosts()
	{
		$sql = "SELECT Subject, Content, PostDate FROM Announcements ORDER BY PostDate DESC";

		$query = $this->db->query($sql);
		
		return $query->result_array();
	}
	
	public function insertMessage($title, $string)
	{
		$data['Subject'] = $title;
		$data['Content'] = $string;
		$data['Poster'] = 1;
		$data['PostDate'] = date("Y-m-d h:i:sa");
		
		$this->db->insert('Announcements', $data);
	}
}
?>