<!DOCTYPE html>
<html>
<head>
<style>


body{
	background-color: green;
}

 

h1{
	colour: black;
	text-align: left;
}

.container{
background-color: lightgrey;
width: 300 px;
border: 3px solid #f1f1f1;
padding: 50px;
margin:20px;
height: 20px;

}

</style>
</head>
<body>

<!-- Heading of the page  -->

	<h1>Company name</h1>
	
<!-- Form to enter in Username and Password   -->
	<div class ="container">
	    <h1>Login</h1>
		<label for = "usern"><b>Username</b></label>
		<input type = "text" placeholder = "Enter username" name = "usern" required>
		
		<label for = "ps"><b>Password</b></label>
		<input type = "text" placeholder = "Enter Password" name="ps" required>
		
<!-- Submit button // need to map the submit button to the dashboard -->
		<button type="submit">login</button>

<!-- when one or both fields don't have a value to check -->
...

<!-- when incorrect details that don't match on the database -->
...


</div>
</body>
</html>