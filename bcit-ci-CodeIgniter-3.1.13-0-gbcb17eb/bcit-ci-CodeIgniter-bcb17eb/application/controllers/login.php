<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{public function index()
	{
		//redirect(base_url().'User/View/'.$this->session->userdata('username'));
		$this->load->view('loginview');
	}














}