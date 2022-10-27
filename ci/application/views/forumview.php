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

<div id="main" type="html" source="assets/nav.html">

</div>

<!--<div id="content">
	<div id="info_box"><?php ["message_count"]?></div>
	<div class="message_template">
		<div class="name_container"><?php ["post_name"]?></div>
		<div class="title_container"><?php ["post_title"]?></div>
		<div class="message_container"><?php ["post_message"]?></div>
	</div>
</div>-->

<?php
	   while($row = mysql_fetch_array($query)) {?>
		   <tr>
			<td><?php echo $row[''];?></td>
		   </tr>
		   <tr>
			<td><?php echo $row[''];?></td>
		   </tr>
		   <tr>
			<td><?php echo $row[''];?></td>
		   </tr>   
<?php } ?>

</body>

<script type="text/javascript" src="nav.js"></script>

</html>