<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Signup_Model extends CI_Model
{
    public function addUser($username,$password)
    {
       $password = sha1($password);
       $sql = "INSERT INTO Staff(username,password,email) VALUES($username,$password,NULL,NULL)";
       $query = $this ->db->query($sql);
    }
}