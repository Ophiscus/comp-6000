<!DOCTYPE HTML>
<html>
<head>
<link rel="stylesheet" href="<?php echo base_url("assets/forum_style.css") ?>">
<link rel="stylesheet" href="<?php echo base_url("assets/nav_style.css") ?>">

</head>

<body>
<div id="main">

<?php include("assets/nav.html");?>

<div id="tools">
	<button id="create" onClick="openForm()">Create Post</button>
</div>

<form method = "post" action = "<?php echo site_url('Forum/post'); ?>">

<div id="popup">
	<label for="title">Title:</label><br>
	<input type="text" id="title" name="title"><br>
	
	<label for="post_cont">Content:</label><br>
	<input type="text" id="post_cont" name="post_cont"><br>
	
	<input type = "submit" value = "Post"/>
</div>

</form>

<table id="content">
<thead>
</thead>
<tbody>
<?php
foreach ($results as $row) {
	?>
	<tr class="announcement">
		<tr class="post_head">
		  <td class="subject">
			<?php echo $row['Subject']?>
		  </td>
		  <td class="date">
			<?php echo $row['PostDate']?>
		  </td>
		</tr>
		<tr>
		  <td class="message">
			<?php echo $row['Content']?>
		  </td>
		</tr>
	</tr>
	<?php
   }   
?>

</tbody>
</table>

</div>
</body>

<script type="text/javascript" src="<?php echo base_url("assets/nav.js") ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/forum_script.js") ?>"></script>

</html>