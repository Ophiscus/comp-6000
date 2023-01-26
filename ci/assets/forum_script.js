//When the view is fully loaded these functions are called
window.onload = function(event) {
	//showComments();
	
	//getUsers();
}

//Cycles through every element in page checking for manager tag, if an element has this then they are hidden if the employee is not a manager
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

//Opens the post creation form
function openForm() {
	var popup = document.getElementById("popup");
	var button = document.getElementById("create");

	if (popup.style.display == "none") {
		popup.style.display = "block";
		button.innerHTML = "Cancel";
	} else if (popup.style.display == "block") {
		popup.style.display = "none";
		button.innerHTML = "Create Post";
	} else {
		popup.style.display = "block";
		button.innerHTML = "Cancel";
	}
}

//Looks at all elements which should have comments and displays them
/*function showComments() {
	var posts = document.getElementsByClassName("comment");
	
	for (var i = 0; i < posts.length; i++) {
		posts[i].setAttribute( 'style', 'display: block !important' );
	}
}*/

//Allows the manager to edit the subject and message
/*function editPost(current) {
	//Hard coding positions of elements to be changed, temporary
	var subject = this.parentElement.children[1];
	var message = this.parentElement.parentElement.children[1];
	
	var subject_content = subject.innerHTML;
	var message_content = message.innerHTML;
	
	console.log("Subject content " + subject_content);
	console.log("Message content " + message_content);
}*/

function test() {
	console.log("ping");
}
