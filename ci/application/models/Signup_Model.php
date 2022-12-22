<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Signup_Model extends CI_Model
{
    // need to make sure username is unique when the database is being checked.
    public function addUser($username,$password)
    {
        //security feature for passwords to be encrypted
       $password = sha1($password);
       $sql = "INSERT INTO Staff(username,password,email) VALUES($username,$password,NULL,NULL)";
       $query = $this ->db->query($sql);
    }
}
?>
