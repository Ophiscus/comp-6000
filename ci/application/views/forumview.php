<!DOCTYPE HTML>
<html>
<head>
<link rel="stylesheet" href="<?php echo base_url("assets/forum_style.css") ?>">
<link rel="stylesheet" href="<?php echo base_url("assets/nav_style.css") ?>">

</head>

<body onload="checkManagerElements('<?php echo $this->session->userdata('role') ?>')">
<div id="main">

<!-- Loading General Navigation UI -->
<?php include("assets/nav.html");?>

<!-- Manager Toolbar -->
<div id="manage_tools" class="manager">
	<div id="tools" onload="isManager(this.id, '<?php echo $this->session->userdata('role') ?>')">
		<button id="create" onClick="openForm()">Create Post</button>
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
			
			<input type = "submit" id="submit" value = "Post"/>
		</div>
	</form>
</div>

<!-- Load Posts -->
<table id="content">
<thead>
</thead>
<tbody>
<?php
foreach ($results as $row) {
	?>
	<tr class="announcement">
		<td class="post <?php echo $row['PostID']?>">
			<tr class="post_head">
				<td class="poster">
					<?php echo $row['Poster']?>
				</td>
				<td class="subject">
					<?php echo $row['Subject']?>
				</td>
				<td class="date">
					<?php echo $row['PostDate']?>
				</td>
				<td class="edit_icon manager" onClick="editPost(this)">
					<img src="<?php echo base_url("assets/edit_icon.png") ?>">
				</td>
			</tr>
			<tr class="message_container">
				<td class="message">
					<?php echo $row['Content']?>
				</td>
			</tr>
			
			<tr class="comment_section <?php echo $row['MessageType']?>">
				<td> Comments: </td>
				<?php
				//Dynamically loading comment HTML elements
				/*foreach ($comment_results as $comment_row) { 
					/*?>
						<tr>
							<button class="create_comment" onClick="openCommentForm()">Add Comment</button>
							<form method = "post" action = "<?php echo site_url('Forum/post_comment'); ?>">
								<div id="popup">
									<!-- Title -->
									<label for="title">Title:</label><br>
									<input type="text" id="title" name="title"><br>
									
									<!-- Reply To -->
									<label><?php echo $comment_row['ReplyTo'] ?></label><br>
									
									<!-- Comment -->
									<label for="post_cont" id="post_cont_lab">Content:</label><br>
									<input type="text" id="post_cont" name="post_cont"><br>
									
									<input type = "submit" id="submit" value = "Post"/>
								</div>
							</form>
						</tr>
						
						<tr class="comment_content">
							<td class="reply">
								<?php echo $row['Replies.Content']?>
							</td>
						</tr>
					<?php
				}*/
				
				//Manually echoing js script in php
				/*echo '<script type="text/javascript">',
					 'var post_ins = document.getElementsByClassName("<?php echo $row["PostID"]?>")',
					 'for(var i = 0; i < post_ins.length; i++) {',
						 'if(<?php echo $row["PostID"]?> == <?php echo $row["ReplyTo"]?>) {',
							'document.createTextNode("<?php echo $row["CommentContent"]?>")',
						 '}',
					 '}',
					 '</script>'
				;*/
				?>
			</tr>
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
<script type="text/javascript" src="<?php echo base_url("assets/forum_script.js") ?>"></script>
<script type="text/javascript">
	function getUsers() {
		var users = document.getElementsByClassName("poster");
		
		for (var i = 0; i < users.length; i++) {
			<?php $controller->getUser(users[i].textContent) ?>
		}
	}
	
	function getComments() {
		console.log("called");
	}
	
	function checkManagerElements(query_result) {
	var manager_elements = document.getElementsByClassName("manager");
	console.log("Called");
	//Faster solution provided css is reverted when page is reloaded
	/*if (query_result == "Manager") {
		console.log("Is a manager");
		for (var i = 0; i < manager_elements.length; i++) {
			manager_elements[i].style.display = "block";
		}
	}*/
	
	for (var i = 0; i < manager_elements.length; i++) {
		if (query_result == "Manager") {
			manager_elements[i].style.display = "block";
		} else {
			manager_elements[i].style.display = "none";
		}
	}
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