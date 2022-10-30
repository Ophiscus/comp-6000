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

<table border = "1" id="message_container">
<thead>
</thead>
<tbody>
<?php

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

<script type="text/javascript" src="nav.js"></script>

</html>