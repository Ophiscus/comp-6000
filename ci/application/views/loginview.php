<!DOCTYPE html>
<html>
<head>
<link rel=”stylesheet” href=”https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css” />
<style>


body{
	background-color: #FFFDD0;
}

 

h1{
	colour: black;
	text-align: center;
}

h2{
	text-align:center;
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

.Login{
	display:inline-block;
	margin: 0 auto;
}

.form i{
margin-left: -30px; 
cursor: pointer;
}

#logo {
	margin: auto;
    display: flex;
    margin-bottom: -110px;
    margin-top: -70px;
}

</style>
</head>
<body>
<script>
const togglePassword = document.querySelector('#togglePassword');
  const password = document.querySelector('#id_password');

  togglePassword.addEventListener('click', () => {
    // toggle the type attribute
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    // toggle the eye slash icon
    this.classList.toggle('bi-eye');
});
</script>
<!-- calling the dologin function from controller -->	

	<form method="post" action="<?php echo base_url(); ?>index.php/Login/dologin">
	
<!-- Heading of the page  -->

	<image id="logo" src="<?php echo base_url("assets/logo.png") ?>">
	
<!-- Form to enter in Username and Password   -->

	<div class ="container">
	    <?php echo form_open('user/login'); ?>
		<div class="form-group">
	    <h1 style="font-family:verdana";>Login</h1>
		<label for = "usern"><b style="font-family:verdana";>Username</b></label>
		<input type = "text" placeholder = "Enter username" name = "username" required>
		<?php echo form_error('username'); ?>

		</div>
	    <div class="form-group">	
		<label for = "ps"><b style="font-family:verdana";>Password</b></label>
		<input type = "password" placeholder = "Enter Password" name="password" required="" id="id_Password">
		<?php echo form_error('password'); ?>
		</div>
		
		<!--Toggle Password Visibility -->
		<i class="bi bi-eye-slash" id="togglePassword"></i>
		
<!-- Submit button // need to map the submit button to the dashboard -->
        <div class = "button">
		<button type="submit">Login</button>
		<?php echo $this->session->flashdata('login_error'); ?>
        <?php form_close(); ?>
		</div>

<!-- when one or both fields don't have a value to check -->


<!-- when incorrect details that don't match on the database -->


</div>


<h2 style="font-family:verdana"> Need help logging in?</h2>
<!-- link to contact us page  -->
</body>
</html>