<!DOCTYPE HTML>
<html>
<head>
<style>

tbody {
	width: 100%;
}
html, body {
	height: 100%;
}
.values{
background-color:white;
border: 1px solid black;
text-align: center;
width: 100%;
color:black;
}

.post_head{
	background-color:#228B22;
	border: 1px solid black;
	text-align: center;
	color:white;
	width: 100%;
}

#content{
	width:100%;
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
			<th>First Name</th>
			<th>Last Name</th>
			<th>Username</th>
			<th>Job title</th>
			<th>Contact Number</th>
</tr>
	<tr class = "values">	
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
          </td>  
		  <td class = "contactnumber">
		  <?php echo $row['contact number']?>
          </td>
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