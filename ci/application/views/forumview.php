<!DOCTYPE HTML>
<html>
<head>
<link rel="stylesheet" href="<?php echo base_url("assets/forum_style.css") ?>">
<link rel="stylesheet" href="<?php echo base_url("assets/nav_style.css") ?>">

</head>

<body onload="isManager('<?php echo $this->session->userdata('role') ?>')">
<div id="main">

<?php include("assets/nav.html");?>

<div id="manage_tools">

<div id="tools" onload="test()">
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
</div>

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
<script type="text/javascript">
	function isManager(query_result) {
		console.log(query_result);
		if (query_result == "Manager") {
			document.getElementById("tools").style.display = "block";
		} else if (query_result == "Staff") {
			document.getElementById("tools").style.display = "none";
		}
	}
</script>

</html>