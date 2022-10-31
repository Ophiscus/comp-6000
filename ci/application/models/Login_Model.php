<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login_Model extends CI_Model
{
	
public function __construct()
	{
		$this->load->database();
	}
	
public function checkLogin($username, $Password)
	{																//Checking for correct user login details
		$query = $this->db->get_where('Staff', array(				//Getting data username and password from Users table which matches in the database
			'username' => $username,
			'password' => sha1($Password)
		));
		if (!empty($query->row_array())) {							//Checking if result is empty, if it is then an error may occur
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
public function getAllUsers()
	{
		$sql = "SELECT * FROM Staff";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	
	
	
	
	
	
	
	
	
}
	