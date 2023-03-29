//When the view is fully loaded these functions are called
window.onload = function(event) {
}

//Cycles through every element in page checking for manager tag, if an element has this then they are hidden if the employee is not a manager
function checkManagerElements(query_result) {
	var manager_elements = document.getElementsByClassName("manager");
	
	for (var i = 0; i < manager_elements.length; i++) {
		if (query_result == "Manager") {
			manager_elements[i].style.display = "block";
		} else {
			manager_elements[i].remove();
			status = "remove";
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
function editPost(current, currNum) {
	var post_head = current.parentElement;
	
	//Hide edit icon
	current.style.display = "none";
	current.removeAttribute("onclick");
	
	//Add confirm and cancel icons
	var tick = document.createElement("INPUT");
	tick.setAttribute("type", "submit");
	tick.setAttribute("value", "");
	tick.className = "tick_icon";
	
	var cross = document.createElement("IMG");
	cross.src = "../../assets/cross_icon.png";
	cross.className = "cross_icon";
	
	//Define key variables
	var subject = document.getElementById("subject" + currNum);
	var message = document.getElementById("message" + currNum);
	var subject_content = subject.innerHTML.trim();
	var message_content = message.innerHTML.trim();
	
	//Create form and add it is a child to post
	var inputForm = document.createElement("FORM");
	
	$.get('updatePost', function(response) {
		inputForm.action = base_url + "index.php/Forum/updatePost";
    });
	
	//Creating the overall edit form
	var formContainer = document.createElement("TD");
	formContainer.className = "form_container";
	formContainer.id = "form_container" + currNum;
	
	inputForm.id = "form" + currNum;
	inputForm.setAttribute("method", "post");
	
	post_head.parentElement.insertBefore(formContainer, post_head.nextSibling);
	formContainer.appendChild(inputForm);
	
	//Create labels
	var sub_label = document.createElement("LABEL");
	sub_label.className = "sub_label";
	sub_label.innerHTML = "Edit Subject:";
	
	var mess_label = document.createElement("LABEL");
	mess_label.className = "mess_label";
	mess_label.innerHTML = "Edit Message:";
	
	//Create subject input field and assign its attributes
	var subject_input = document.createElement("INPUT");
	subject_input.setAttribute("type", "text");
	subject_input.setAttribute("value", subject_content);
	subject_input.setAttribute("name", "edit_sub");
	subject_input.className = "edit_sub";
	
	//Create message input field and assign its attributes
	var message_input = document.createElement("INPUT");
	message_input.setAttribute("type", "text");
	message_input.setAttribute("value", message_content);
	message_input.setAttribute("name", "edit_mes");
	message_input.className = "edit_mes";
	
	//Create post id input field
	var id_input = document.createElement("INPUT");
	id_input.setAttribute("type", "number");
	id_input.setAttribute("step", "1");
	id_input.setAttribute("name", "edit_id");
	id_input.setAttribute("value", document.getElementById("announcement" + currNum).children[0].id);
	id_input.className = "id_input";
	
	//Add inputs to form
	inputForm.appendChild(sub_label);
	inputForm.appendChild(subject_input);
	inputForm.appendChild(mess_label);
	inputForm.appendChild(message_input);
	
	inputForm.appendChild(id_input);
	
	document.getElementById("form" + currNum).appendChild(tick);
	document.getElementById("form" + currNum).appendChild(cross);
	
	//Add confirm and cancel button onclick events
	cross.onclick = null;
	cross.setAttribute("onclick", "closeEdit(" + currNum + ")");
	
	//Hide the post display-only elements
	subject.style.display = "none";
	message.style.display = "none";
}

//Removes every element in the edit form
function closeEdit(currNum) {
	document.getElementById("form" + currNum).remove();
	
	document.getElementById("subject" + currNum).style.display = "block";
	document.getElementById("message" + currNum).style.display = "block";
	
	var edit = document.getElementById("edit_icon" + currNum);
	edit.style.display = "block";
	
	//Ensures that the edit button never has more than one event listener attached to it
	var newEdit = edit.cloneNode(true);
	edit.parentNode.replaceChild(newEdit, edit);
	
	newEdit.addEventListener("click", function() {
        editPost(newEdit, currNum);
    });
	
	document.getElementById("form_container" + currNum).style.display = "none";
}

//Loads a comment given certain parameters from the view data
function generateComment(el, poster, content, post_date) {
	var comment_sec = document.createElement("TR");
	
	var poster_sec = document.createElement("TD");
	var content_sec = document.createElement("TD");
	var post_date_sec = document.createElement("TD");
	
	var comment_info = document.createElement("TR");
	var comment_content = document.createElement("TR");
	
	poster_sec.textContent = poster;
	content_sec.textContent = content;
	post_date_sec.textContent = post_date;
	
	poster_sec.className = "poster_ind";
	content_sec.className = "content_ind";
	post_date_sec.className = "post_date_ind";
	
	comment_sec.className = "comment_ind";
	
	comment_info.appendChild(poster_sec);
	comment_info.appendChild(post_date_sec);
	comment_content.appendChild(content_sec);
	
	comment_sec.appendChild(comment_info);
	comment_sec.appendChild(comment_content);
	
	el.appendChild(comment_sec);
}
