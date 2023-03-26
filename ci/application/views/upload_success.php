<html>
<head>
    <title>Success Message</title>
</head>
<body>
<h3>Congragulation Your file has been uploaded successfully</h3>
<!-- Uploaded file specification will show up here -->
<ul>
    <?php foreach ($upload_data as $item => $value):?>
    <li><?php echo $item;?>: <?php echo $value;?></li>
    <?php endforeach; ?>
</ul>
<div>

<p><?php echo anchor('Add file', 'Upload Another File!'); ?></p>
<div>
<?php
foreach ($upload_data as $row) { 
?>
	
<video src = '"<?php echo $row['full_path']?>"' controls width='320px' height='320px'></video>

<?php
   }   
?>
</div>
</body>
</html>