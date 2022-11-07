<!DOCTYPE HTML>
<html>
<head>
<link rel="stylesheet" href="<?php echo base_url("assets/forum_style.css") ?>">
<link rel="stylesheet" href="<?php echo base_url("assets/nav_style.css") ?>">

</head>

<body>

<table border = "1" id="message_container">
<thead>
</thead>
<tbody>
<?php
echo "controller called";
foreach ($results as $row) {
	?>
    <tr class="post_head">
      <td class="subject">
        <?php echo $row['Subject']?>
      </td>
    </tr>
    <tr class="message">
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

<script type="text/javascript" src="<?php echo base_url("assets/nav.js") ?>"></script>

</html>