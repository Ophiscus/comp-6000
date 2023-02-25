<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login_Model extends CI_Model
{
	
	public function __construct()
	{
		$this->load->database();
		$passHashOptions = array('cost' =>11);
	}
	
	public function checkLogin($username, $Password)
	{	
		/*
		//Checking for correct user login details
		$query = $this->db->get_where('Staff', array(				//Getting data username and password from Users table which matches in the database
			'username' => $username,
			'password' => sha1($Password)
		));
		if (!empty($query->row_array())) {							//Checking if result is empty, if it is then an error may occur
			return TRUE;
		} else {
			return FALSE;
		}
		*/

		//get the hashed pasword from the database
		$this->db->select('password');
		$this->db->from('Staff');
		$this->db->where('username',$username,TRUE);
		$queryResult = $this->db->get()->result_array();

		$hashedPassword = $queryResult[0];
		
		//check it's validity
		if(password_verify($Password,$hashedPassword)) {
			
			if(password_needs_rehash($hashedPassword,"PASSWORD_DEFAULT",$passHashOptions)) {
				$newHash = password_hash($Password,"PASSWORD_DEFAULT",$passHashOptions);
				updatePassword($username,$newHash);
			}

			return TRUE;
		} else {
			return FALSE;
		}

		return FALSE;
	}
	
	public function getAllUsers()
	{
		$sql = "SELECT * FROM Staff";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function ExsitUser($name)
	{								//Check through username only, if user exist
		$query = $this->db->get_where('Staff', array(
			'username' => $name
		));
		if ($query->num_rows() == 1) {								//Checking at most 1, at least 0 from the number of rows retured.
			return TRUE;
		} else {       
			return FALSE;
		}
	}

	//update a password hash when PHP's default password hashing algorithm updates to a new one.
	private function updatePassword($username,$newPassword) {
		$this->db->set('password',$newPassword);
		$this->db->where('username',$username);
		$this->db->update('Staff');
	}
	
}