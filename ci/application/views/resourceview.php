<html>
<head>

<style>
body{
background-image: url("youngchef.jpg");
background-size: 500px;
background-color: #FFFDD0;
}
table,tr,td{
    border : 1px solid;
    width : 100%;
    border-collapse:collapse;
}
</style>
</head>
<body onload="checkManagerElements('<?php echo $this->session->userdata('role') ?>')">

<div id="manage_tools" class="manager">
	<div id="tools" onload="isManager(this.id, '<?php echo $this->session->userdata('role') ?>')">
	<?php echo $error;?>

<?php echo form_open_multipart('Resources/do_upload');?>

<h1 style="font-family:verdana";>Resources</h1>

<input type="file" name="userfile" size="20" />

<br /><br />

<input type="submit" value="Add file" />

<?php echo "</form>"?>
		


</div>


 
  
    

</div>
</body>
</html>