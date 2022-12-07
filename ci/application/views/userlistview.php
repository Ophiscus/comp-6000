<!DOCTYPE HTML>
<html>
<head>
<style>
.announcement {
	margin-top: 20px;
}
tbody {
	width: 100%;
}
html, body {
	height: 100%;
}

</style>

<link rel="stylesheet" href="<?php echo base_url("assets/nav_style.css") ?>">

</head>

<body>
<div id="main">

<?php include("assets/nav.html");?>

<table id="content">
<thead>
</thead>
<tbody>
<?php
foreach ($results as $row) {
	?>
	<tr class="employees">
		<tr class="post_head">
		  <td class="firstname">
			<?php echo $row['First Name']?>
		  </td>
		  <td class="lastname">
			<?php echo $row['Last Name']?>
		  </td>
		  <td class ="username">
		    <?php echo $row['username']?>
		  </td>
		  <td class ="jobtitle">
            <?php echo $row['Job Title']?>		  
		</tr>
	<?php
   }   
?>

</tbody>
</table>

</div>
</body>

<script type="text/javascript" src="<?php echo base_url("assets/nav.js") ?>"></script>

</html>