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

/*function isManager(query_result) {
	console.log("test");
	if (query_result == "Manager") {
		document.getElementById(tools).style.display = "block";
	} else {
		document.getElementById(tools).style.display = "none";
	}
}*/
