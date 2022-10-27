<!DOCTYPE html>
<html>
<head>
<style>


body{
	background-color: #77DD77;
}

 

h1{
	colour: black;
	text-align: center;
}

.container{
background-color: lightgrey;
width: 300px;
border: 3px solid #f1f1f1;
padding: 16px;
margin: 0 auto;
height: 300px;



}

input[type=text], input[type=password] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
}

</style>
</head>
<body>
<script>
function showPassword() {
  var x = document.getElementById("myInput");
    if (x.type === "password") {
    x.type = "text";
  } else {
      x.type = "password";
  }
}
</script>
<!-- Heading of the page  -->

	<h1 style="font-family:verdana";>Company name</h1>
	
<!-- Form to enter in Username and Password   -->
	<div class ="container">
	    <h1 style="font-family:verdana";>Login</h1>
		<label for = "usern"><b style="font-family:verdana";>Username</b></label>
		<input type = "text" placeholder = "Enter username" name = "usern" required>
		
		<label for = "ps"><b style="font-family:verdana";>Password</b></label>
		<input type = "password" placeholder = "Enter Password" name="ps" required>
		
		<!--Toggle Password Visibility -->
		<input type= "checkbox" onclick="showPassword()">
		
<!-- Submit button // need to map the submit button to the dashboard -->
		<button type="submit">Login</button>

<!-- when one or both fields don't have a value to check -->


<!-- when incorrect details that don't match on the database -->


</div>

<h2 style="font-family:verdana"> Need help logging in?</h2>
<!-- link to contact us page  -->
</body>
</html>