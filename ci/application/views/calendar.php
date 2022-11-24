<html lang="en" dir="ltr">

  <head>
    <meta charset="utf-8">
    <title>Dynamic Calendar JavaScript</title>
    <link rel="stylesheet" href=<?php echo base_url("assets/style.css") ?>>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Google Font Link for Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
    <script src=<?php echo base_url("assets/script.js defer")?>></script>
  </head>

  <body>

    <div id="mySidebar" class="sidebar">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">X</a>
    <a href="#">Forum</a>
    <a href="#">Statistics</a>
    <a href="#">Calendar</a>
    <a href="#">Contact Us</a>
  </div>

<div id="main" class = "main">
  <div class="topnav">
    <button class="openbtn" onclick="openNav()">☰</button>
    <a class="active" href="#home">Home</a>
    <a href="#login">User</a>
  </div>

    <div class="wrapper">
      <header>
        <p class="current-date"></p>
        <div class="icons">
          <span id="prev" class="material-symbols-rounded">chevron_left</span>
          <span id="next" class="material-symbols-rounded">chevron_right</span>
        </div>
      </header>

      <div class="calendar">
        <ul class="weeks">
          <li>Sun</li>
          <li>Mon</li>
          <li>Tue</li>
          <li>Wed</li>
          <li>Thu</li>
          <li>Fri</li>
          <li>Sat</li>
        </ul>
        <ul class="days"></ul>
      </div>

      <div id = "eventBar" class="eventBar" id ="eventbar">
        <a href="#close" class="closebtn" onclick="closeEvent()">X</a>
        <a href="#event" class="active">Events should go here</a>
      </div>

      </div>
    </div>
</div>

  </body>
</html>
