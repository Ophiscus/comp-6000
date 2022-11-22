<!DOCTYPE HTML>
<html>
<head>
<link rel="stylesheet" href="<?php echo base_url("assets/forum_style.css") ?>">
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

</html>