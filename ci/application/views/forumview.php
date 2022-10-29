<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE HTML>
<html>
<head>
<link rel="stylesheet" href="assets/forum_style.css">
<link rel="stylesheet" href="assets/nav_style.css">

</head>

<body>

<div id="main" type="html" source="assets/nav.html"></div>

<!--Code for example html-->
<!--<div id="content">
	<div id="info_box">/div>
	<div class="message_template">
		<div class="name_container">Name</div>
		<div class="title_container">Title</div>
		<div class="message_container">Message</div>
	</div>
</div>-->

<table border = "1">
<thead>
<tr>
	<td>Subject</td>
	<td>Content</td>
<tr>
</thead>
<tbody>
<?php

foreach ($results as $row) {
	?>
	<tr>
		<td>
			<?php echo $row['Subject']?>
		</td>
		<td>
			<?php echo $row['Content']?>
		</td>
	</tr>
	<?php
   }   
?>

</tbody>
</table>

</body>

<script type="text/javascript" src="nav.js"></script>

</html>