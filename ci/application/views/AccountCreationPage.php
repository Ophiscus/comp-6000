<!DOCTYPE html>
<html>
  <head>
    <title>Create Employee's Account</title>
<body style="background-color:#77DD77">
    <style>
      html, body {
      display: flex;
      justify-content: center;
      height: 100%;
      }
      body, div, h1, h4, form, input{ 
      outline: none;
      font-family: Verdana;
      font-size: 16px;
      }
      h1 {
      padding: 10px 0;
      font-size: 32px;
      font-weight: 300;
      text-align: center;
      }

      hr {
      color: #a9a9a9;
      opacity: 0.3;
      }
      .main-block {
      max-width: 340px; 
      min-height: 460px; 
      padding: 10px 0;
      margin: auto;
      border-radius: 5px; 
      border: solid 1px #ccc;
      box-shadow: 1px 2px 5px rgba(0,0,0,.31); 
      background: #ebebeb; 
      }
      form {
      margin: 0 30px;
      }   
     
      label#icon {
      margin: 0;
      border-radius: 5px 0 0 5px;
      }

      input[type=radio]:checked + label:after {
      opacity: 1;
      }
      input[type=text], input[type=password] {
      width: calc(100%);
      height: 36px;
      margin: 13px 0 0 -5px;
      padding-left: 10px; 
      border-radius: 0 5px 5px 0;
      border: solid 1px #cbc9c9; 
      }
      input[type=password] {
      margin-bottom: 15px;
      }
      .btn-block {
      margin-top: 10px;
      text-align: center;
      }
      button {
      width: 100%;
      padding: 10px 0;
      margin: 10px auto;
      border-radius: 5px; 
      border: none;
      background: #228B22; 
      font-size: 14px;
      font-weight: 600;
      color: #fff;
      }
      button:hover {
      background: #77DD77;
      }
    </style>
  </head>
  <body>
    <div class="main-block">
      <h1>Account Creation</h1>
      <form action='<?php echo base_url("index.php/Signup/dosignup")?>' method="post" >
     
       <!-- Users enter in details into the form -->
        <!-- First name input box-->
        <input type="text" name="firstname" id="firstname" placeholder="First Name" required/>

        <!-- Last name input box -->
        <input type="text" name="lastname" id="lastname" placeholder="Last Name" required/>

        <!--Email input Box-->
        <input type="text" name="emailname" id="email" placeholder="Email" required/>

        <!--Username input Box-->
        <input type="text" name="username" id="username" placeholder="Username" required/>

        <!--Password input Box-->
        <input type="password" name="password" id="password" placeholder="Password" required/>

        <hr>
        <h4>Access Level</h4>
        <div class="employeeRole">

          <input type="radio" id="Manager" value="Manager" name="accessLevel">
          <label for="managerAccess" class="radio">Manager</label>


          <input type="radio" id="Employee" value="Staff" name="accessLevel">
          <label for="employeeAccess" class="radio">Employee</label>
        
        <hr>
        <div class="btn-block">

        <!-- Submit Employee Creation // need to link to the database -->
          <button type="submit" href="/">Submit</button>

        <!--Map submit back to the manager's dashboard-->
        </div>
      </form>
    </div>
  </body>
</html>

