//When the view is fully loaded these functions are called
window.onload = function(event) {
	//getUsers();
}

//Cycles through every element in page checking for manager tag, if an element has this then they are hidden if the employee is not a manager
function checkManagerElements(query_result) {
	var manager_elements = document.getElementsByClassName("manager");
	
	for (var i = 0; i < manager_elements.length; i++) {
		if (query_result == "Manager") {
			manager_elements[i].style.display = "block";
		} else {
			manager_elements[i].style.display = "none";
		}
	}
}

//Opens the post and comment creation form
function openForm(popup, create) {
	var popup = document.getElementById(popup);
	var button = document.getElementById(create);

	if (popup.style.display == "none") {
		popup.style.display = "block";
		button.innerHTML = "Cancel";
	} else if (popup.style.display == "block") {
		popup.style.display = "none";
		button.innerHTML = "Create Content";
	} else {
		popup.style.display = "block";
		button.innerHTML = "Cancel";
	}
}

//Allows the manager to edit the subject and message
function editPost(current) {
	//Hard coding positions of elements to be changed, temporary
	//var subject_parent = current.parentElement;
	//var message_parent = current.parentElement.parentElement.children[2];
	var post_head = current.parentElement;
	
	var subject = current.parentElement.children[1];
	var message = current.parentElement.parentElement.children[2].children[0];
	
	var subject_content = subject.innerHTML;
	var message_content = message.innerHTML;
	
	var form = document.createElement("FORM");
	form.setAttribute("method", "post");
	form.setAttribute("action", "Forum/updatePost");
	post_head.appendChild(form);
	
	var subject_input = document.createElement("INPUT");
	subject_input.setAttribute("type", "text");
	subject_input.setAttribute("value", subject_content);
	subject_input.setAttribute("name", "edit_sub");
	subject_input.className = "edit_sub";
	
	var message_input = document.createElement("INPUT");
	message_input.setAttribute("type", "text");
	message_input.setAttribute("value", message_content);
	message_input.setAttribute("name", "edit_mes");
	message_input.className = "edit_mes";
	
	form.appendChild(subject_input);
	form.appendChild(message_input);
	
	//subject_parent.appendChild(subject_input);
	//subject_parent.insertBefore(subject_input, subject_parent.children[2]);
	//message_parent.appendChild(message_input);
	
	subject.style.display = "none";
	message.style.display = "none";
	
}

function generateComment(el, poster, content, post_date) {
	var comment_sec = document.createElement("TR");
	
	var poster_sec = document.createElement("TD");
	var content_sec = document.createElement("TD");
	var post_date_sec = document.createElement("TD");
	
	poster_sec.textContent = poster;
	content_sec.textContent = content;
	post_date_sec.textContent = post_date;
	
	poster_sec.className = "poster_ind"
	content_sec.className = "content_ind"
	post_date_sec.className = "post_date_ind"
	
	comment_sec.className = "comment_ind"
	
	comment_sec.appendChild(poster_sec);
	comment_sec.appendChild(content_sec);
	comment_sec.appendChild(post_date_sec);
	
	el.appendChild(comment_sec);
}

function test() {
	console.log("ping");
}
