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
