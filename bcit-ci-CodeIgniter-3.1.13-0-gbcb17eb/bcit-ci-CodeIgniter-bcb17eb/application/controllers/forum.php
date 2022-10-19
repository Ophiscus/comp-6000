<?php

class forum extends CI_Controller {
	$forum = new controller;
	
	public function getMessages($user)
	{
		$sql = "SELECT user, post_message FROM Posts ORDER BY date";
	}

}

?>