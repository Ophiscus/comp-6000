<html lang="en" dir="ltr">

  <head>
    <meta charset="utf-8">
    <title>Dynamic Calendar JavaScript</title>
    <link rel="stylesheet" href=<?php echo base_url("assets/style.css") ?>>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Google Font Link for Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
    <script src=<?php echo base_url("assets/script.js defer")?>></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
        <a href="#event" class="active" id = "eventTime">N/A</a>
        <a href="#event" class="active" id = "eventDescription">Events should go here</a>
      </div>

      </div>
    </div>
</div>

  </body>
  
  <script defer>
    function openEvent(data){
    document.getElementById("eventBar").style.display ="block";
    if(data == null) {
      console.log("nothing");
        document.getElementById("eventTime").innerHTML = "N/A";
        document.getElementById("eventDescription").innerHTML = "No Event";
    } else {
        info = data.split(",")
        document.getElementById("eventTime").innerHTML = "Time: " + info[0] + "-" + info[1];
        document.getElementById("eventDescription").innerHTML = "Description: " + info[2];
    }
  }

function closeEvent(){
    document.getElementById("eventBar").style.display ="none";
}

const daysTag = document.querySelector(".days"),
currentDate = document.querySelector(".current-date"),
prevNextIcon = document.querySelectorAll(".icons span");

// getting new date, current year and month
let date = new Date(),
currYear = date.getFullYear(),
currMonth = date.getMonth();
let demoEventData = "TestUser data fro the event bar";
let demoDate = new Date("30-11-2022");

// storing full name of all months in array
const months = ["January", "February", "March", "April", "May", "June", "July",
              "August", "September", "October", "November", "December"];

const dynamicCalendar = (events) => {
      let firstDayofMonth = new Date(currYear, currMonth, 1).getDay(), // getting first day of month
      lastDateofMonth = new Date(currYear, currMonth + 1, 0).getDate(), // getting last date of month
      lastDayofMonth = new Date(currYear, currMonth, lastDateofMonth).getDay(), // getting last day of month
      lastDateofLastMonth = new Date(currYear, currMonth, 0).getDate(); // getting last date of previous month
      let liTag = "";

      nextEventDate = new Date(events[0]["Shift Start"]);

            for (let i = firstDayofMonth; i > 0; i--) { // creating li of previous month last days
                      liTag += `<li class="inactive">${lastDateofLastMonth - i + 1}</li>`;
                  }

            for (let i = 1; i <= lastDateofMonth; i++) { // creating li of all days of current month
                      // adding active class to li if the current day, month, and year matched
                    let improvDate= (i).toLocaleString(undefined, {minimumIntegerDigits: 2, useGrouping:false}) 
                    let thisDate = new Date(`${improvDate} ${months[currMonth]} ${currYear}`);
                    let sqlDate = thisDate.toISOString(); 
                      if(parseInt(improvDate) === nextEventDate.getDate() && currMonth +1 === (nextEventDate.getMonth()+1) && currYear === nextEventDate.getFullYear()) {
                        liTag += `<li  onclick = "openEvent('${nextEventDate.toLocaleTimeString()},${new Date(events[0]["End Time"]).toLocaleTimeString()},${events[0]["Description"]}')" class="event">${i}</li>`
                      } else if(isToday = i=== date.getDate() && currMonth === new Date().getMonth()&& currYear === new Date().getFullYear())
                        {  
                            liTag += `<li  onclick = "openEvent()" class="active">${i}</li>`;
                        }
                    else
                    {
                        liTag += `<li onclick = "openEvent()">${i}</li>`;
                    } 
                }

            for (let i = lastDayofMonth; i < 6; i++) { // creating li of next month first days
                      liTag += `<li class="inactive">${i - lastDayofMonth + 1}</li>`
                  }
                  currentDate.innerText = `${months[currMonth]} ${currYear}`; // passing current mon and yr as currentDate text
                  daysTag.innerHTML = liTag;
              }
      $.ajax({
        url: '<?php echo base_url("index.php/Calendar/getEventByMonth")?>',
        method: 'get',
        data: {month: parseInt(currMonth+1)},
        dataType: 'json',
        success:function(response) {
          events = response;
          dynamicCalendar(response);
        } 
      })

prevNextIcon.forEach(icon => { // getting prev and next icons
  $.ajax({
        url: '<?php echo base_url("index.php/Calendar/getEventByMonth")?>',
        method: 'get',
        data: {month: currMonth},
        dataType: 'json',
        success:function(response) {
          events = response;
          
          icon.addEventListener("click", () => { // adding click event on both icons
        // if clicked icon is previous icon then decrement current month by 1 else increment it by 1
        currMonth = icon.id === "prev" ? currMonth - 1 : currMonth + 1;

        if(currMonth < 0 || currMonth > 11) { // if current month is less than 0 or greater than 11
            // creating a new date of current year & month and pass it as date value
            date = new Date(currYear, currMonth);
            currYear = date.getFullYear(); // updating current year with new date year
            currMonth = date.getMonth(); // updating current month with new date month
        } else {
            date = new Date(); // pass the current date as date value
        }
        
        dynamicCalendar(events); // calling dynamicCalendar function
    });
        }
      })
    
});

  </script>
</html>
