<!DOCTYPE HTML>
<html>
<head>
<link rel="stylesheet" href="<?php echo base_url("assets/forum_style.css") ?>">
<link rel="stylesheet" href="<?php echo base_url("assets/nav_style.css") ?>">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="<?php echo base_url("assets/forum_script.js") ?>"></script>
</head>

<body onload="checkManagerElements('<?php echo $this->session->userdata('role') ?>')">
<div id="main">

<!-- Loading General Navigation UI -->
<?php include("assets/nav.html");?>

<!-- Manager Toolbar -->
<div id="manage_tools" class="manager">
	<div id="tools" onload="isManager(this.id, '<?php echo $this->session->userdata('role') ?>')">
		<button id="create" onClick="openForm('popup', 'create')">Create Post</button>
	</div>

	<form method = "post" action = "<?php echo site_url('Forum/post'); ?>">
		<div id="popup">
			<!-- Title -->
			<label for="title" id="title_label">Title:</label><br>
			<input type="text" id="title" name="title"><br>
			
			<!-- Message -->
			<label for="post_cont" id="post_label">Content:</label><br>
			<textarea type="text" id="post_cont" name="post_cont"></textarea><br>
			
			<!-- Post Type -->
			<div id="type_select">
				<label>Type of Message</label>
				<select name="type_select">
				  <option value="announce">Announcement</option>
				  <option value="comment">Interactive</option>
				</select>
			</div>
			
			<input type="submit" id="submit" value="Post"/>
		</div>
	</form>
</div>

<!-- Load Posts -->
<table id="content">
<thead>
</thead>
<tbody>
<?php
$id_num = 0;
foreach ($postData as $row) { 
	?>
	<tr class="announcement" id="announcement<?php echo $id_num ?>">
		<td class="post" id="<?php echo $row['PostID']?>">
			<tr class="post_head">
				<td class="poster">
					<?php
					foreach ($userData as $user) {
						if ((int)$row['Poster'] == (int)$user['StaffID']) {
							echo $user['FirstName'] . " " . $user['LastName'];
						}
					}
					?>
					<?php// echo $row['Poster']?>
				</td>
				<td class="subject" id="subject<?php echo $id_num ?>">
					<?php echo $row['Subject']?>
				</td>
				<td class="date">
					<?php echo $row['PostDate']?>
				</td>
				<td class="edit_icon_parent manager">
					<img class="edit_icon" src="<?php echo base_url("assets/edit_icon.png") ?>" onClick="editPost(this, <?php echo $id_num ?>)" id="edit_icon<?php echo $id_num ?>">
				</td>
			</tr>
			<tr class="message_container">
				<td class="message" id="message<?php echo $id_num ?>">
					<?php echo $row['Content']?>
				</td>
			</tr>
			
			<tr class="comment_section <?php echo $row['MessageType']?>" id="<?php echo $id_num ?>" style="display:table">	
				<td class="comment_def">
				
				<button id="<?php echo "create_comment" . $id_num ?>" class="create_comments" onClick="openForm('<?php echo "comment_popup" . $id_num ?>', '<?php echo "create_comment" . $id_num ?>')">Create Comment</button>
				
				<form method = "post" action = "<?php echo site_url('Forum/post_comment'); ?>">
					<div id="<?php echo "comment_popup" . $id_num ?>" class="comment_popups">
						<!-- Comment -->
						<label for="ccontent" class="ccontent_label">Content:</label><br>
						<input type="text" class="ccontent" name="ccontent"><br>
						
						<input class="hide_reply" type="number" step="1" class="reply_to" name="reply_to" value="<?php echo $row['PostID'] ?>"><br>
						
						<input type="submit" class="submit_comment" value="Post"/>
					</div>
				</form>
				
				</td>
				
				<?php 
				if ($row['MessageType'] == "comment") {
					foreach ($commentData as $row2) {
						if ($row2['ReplyTo'] == $row['PostID']) {
							$username;
							foreach ($userData as $user) {
								if ((int)$row2['CommentPoster'] == (int)$user['StaffID']) {
									$username = $user['FirstName'] . " " . $user['LastName'];
								}
							} ?> <script> generateComment(document.getElementById("<?php echo $id_num ?>"), "<?php echo $username ?>", "<?php echo $row2['CommentContent'] ?>", "<?php echo $row2['CommentPostDate'] ?>"); </script> 
							<script> document.getElementById("<?php echo $id_num ?>").style.display = "table"; </script> <?php
						}
					}
				}
				?>
			</tr>
		</td>
	</tr>
	<?php
	$id_num++;
   }   
?>

</tbody>
</table>

</div>
</body>

<script type="text/javascript" src="<?php echo base_url("assets/nav.js") ?>"></script>
<script type="text/javascript">
	function test() {
		console.log("ping");
	}
</script>
<script src="<?php echo base_url("assets/jquery-3.6.3.min.js") ?>">
	$( document ).ready(function() {
		console.log( "ready!" );
	});
	
	$("comment").load(function(){
	  console.log("Image loaded.");
	});
</script>

</html>