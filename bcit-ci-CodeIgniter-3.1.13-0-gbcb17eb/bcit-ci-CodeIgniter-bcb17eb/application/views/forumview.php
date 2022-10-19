<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE HTML>
<html>
<head>
<link rel="stylesheet" href="forum_style.css">
<link rel="stylesheet" href="nav_style.css">

</head>

<body>

<div id="main">
	<div class="topnav">
	<button class="openbtn" onclick="openNav()">☰</button>
	<a class="active" href="#home">Home</a>
	<a href="#Announcements">Announcements</a>
	<a href="#contact">Contact Us</a>
	<a href="#about">About</a>
	<a href="#login">Login</a>
	</div>

	<div id="mySidebar" class="sidebar">
		<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">X</a>
		<a href="#">Maneger</a>
		<a href="#">Statistic</a>
		<a href="#">Calendar</a>
		<a href="#">Contact Us</a>
	</div>
</div>

<div id="content">
	<div id="info_box"><?php ["message_count"]?></div>
	<div class="message_template">
		<div class="name_container"><?php ["post_name"]?></div>
		<div class="title_container"><?php ["post_title"]?></div>
		<div class="message_container"><?php ["post_message"]?></div>
	</div>
</div>

</body>

<script type="text/javascript" src="nav.js"></script>

</html>