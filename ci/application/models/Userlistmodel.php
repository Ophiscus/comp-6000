<?php
class Userlistmodel extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}
	
	//Retrieves all messages in database and passes it to the controller
	public function getUsers()
	{
		$sql = "SELECT `First Name`,`Last Name`, `username`,`Job Title`,`contact number` FROM Staff";

		$query = $this->db->query($sql);
		
		return $query->result_array();
	}	
}
?>