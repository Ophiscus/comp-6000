<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login_Model extends CI_Model
{
	
public function __construct()
	{
		$this->load->database();
	}
	
public function checkLogin($data)
	{			
		
		//Checking for correct user login details
		$user = 'SELECT username FROM Staff';
		$password = 'SELECT password FROM Staff';
		
		$query = $this->db->get_where('Staff',array(
			'username' = $data['username'];
			'password' = $data['password'];
		)

		);
		if ($query->num_rows() == 1) {								//Checking at most 1, at least 0 from the number of rows retured.
			return TRUE;
		} else {       
			return FALSE;
		}
		
	}
	
public function getAllUsers()
	{
		
		$this->db->select('*');
        $this->db->from('Staff');

        $query=$this->db->get();

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

	
	
	
	
	
	
	
	
	
	
}
	