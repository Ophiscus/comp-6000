<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Signup_Model extends CI_Model
{
    function __construct() {
        $this->load->database();
    }
    // need to make sure username is unique when the database is being checked. 
    /* No you don't, the username has a unqiue constraint on it, it will enforce that on it's own, you just need to communicate 
    that to the user. :)*/
    public function addUser($firstname,$lastname,$email,$username,$password,$accesslevel)
    {
       $hashedPassword = password_hash($password,PASSWORD_DEFAULT);
       $this->db->set('FirstName',$firstname);
       $this->db->set('LastName',$lastname);
       $this->db->set('username',$username);
       $this->db->set('password',$hashedPassword);
       $this->db->set('role',$accesslevel); 
       $this->db->insert('Staff');
    }
}
?>
