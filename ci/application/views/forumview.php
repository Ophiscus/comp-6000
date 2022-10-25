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

<div id="main" include-html="nav.html">

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