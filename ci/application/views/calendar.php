   <html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Dynamic Calendar JavaScript</title>
  <link rel="stylesheet" href=<?php echo base_url("assets/style.css") ?>>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Google Font Link for Icons -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
  <script src=<?php echo base_url("assets/script.js defer") ?>></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link rel="stylesheet" href="<?php echo base_url("assets/nav_style.css") ?>">
</head>

<body>
    
<div id="main" class="main">

    <?php include("assets/nav.html");?>

    <div class="wrapper">
      <header>
        <p class="current-date"></p>
        <?php if($ManagerAccess) { 
		      echo '<span><button onclick="openAddForm()">Add Event</button></span>';
        }
        ?>
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

      <div id="eventBar" class="eventBar" id="eventbar">
        <a href="javascript:void(0)" class="closebtn" onclick="closeEvent()">X</a>
        <?php if($ManagerAccess) {
          echo '<a href= "#edit" class="editbtn" onclick="openForm()">Edit</a>';
        }
        ?>
    <table class="eventTable" id = "displayEvent">
    <tr class = "tableHeader" >
      <th> Start Date/Time</th>
      <th> End Date/Time</th>
      <th>Description</th>
      <th>Edit/Delete</th>
    </tr>
  </table>
		</div>

		</div>
				<div class="editPopup">
					<div class="formPopup" id="popupForm">
						<form action="/action_page.php" class="formContainer">
						<h2>Please input time and description</h2>
							 <label for="Time">
								 <strong>Time</strong>
							</label>
							<input type="text" id="time" placeholder="please enter the time for the event." name="Time" required>
							<label for="description">
								<strong>Event/Description</strong>
							 </label>
							 <input type="text" id="description" placeholder="Please enter event" name="Description" required>
							<button type="submit" class="btn">Submit</button>
							<button type="button" class="btn cancel" onclick="closeForm()">Cancel</button>
						 </form>
					</div>
				 </div>
		</div>
	</div>

	<form method = "post" action = "<?php echo site_url('Calendar/post');?>">

	</div>
		<div class="addPopup">
			<div class="addFormPopup" id="addPopupForm">
				<div action="/action_page.php" class="Container">
					<h2>Please input time and description</h2>
					<label for="staffID">
							<strong>staffID</strong>
						</label>
					<input type="number" id="staff" placeholder="Please enter event" name="StaffID" required>
						<label for="startDate">
							<strong>Starting time<strong>
						</label>
					<input type="datetime-local" id="startdate" placeholder="please enter the date for the event." name="StartDate" required>
						<label for="endTime">
							<strong>End Time</strong>
						</label>
					<input type="datetime-local" id="endtime" placeholder="please enter the time for the event." name="endTime" required>
						<label for="description">
							<strong>Event/Description</strong>
						</label>
					<input type="text" id="description" placeholder="Please enter event" name="Description" required>
						<button type="submit" class="btn" value = "Post">Submit</button>
						<button type="button" class="btn cancel" onclick="closeAddForm()">Cancel</button>
        </div>
			</div>
		</div>
	</div>
</div>
	</form>

 </div>

</body>

<script defer>
const eventDateData = new Array();

  function closeEvent() {
    document.getElementById("eventBar").style.display = "none";
  }

  function openForm() {
        document.getElementById("popupForm").style.display = "block";
      }

 function closeForm() {
     document.getElementById("popupForm").style.display = "none";
   }

  function openAddForm() {
       document.getElementById("addPopupForm").style.display = "block";
    }

function closeAddForm() {
     document.getElementById("addPopupForm").style.display = "none";
   }

  const daysTag = document.querySelector(".days"),
    currentDate = document.querySelector(".current-date"),
    prevNextIcon = document.querySelectorAll(".icons span");

  // getting new date, current year and month
  let date = new Date(),
    currYear = date.getFullYear(),
    currMonth = date.getMonth();
    

  // storing full name of all months in array
  const months = ["January", "February", "March", "April", "May", "June", "July",
    "August", "September", "October", "November", "December"];

  const dynamicCalendar = (events) => {
    let firstDayofMonth = new Date(currYear, currMonth, 1).getDay(), // getting first day of month
      lastDateofMonth = new Date(currYear, currMonth + 1, 0).getDate(), // getting last date of month
      lastDayofMonth = new Date(currYear, currMonth, lastDateofMonth).getDay(), // getting last day of month
      lastDateofLastMonth = new Date(currYear, currMonth, 0).getDate(); // getting last date of previous month
    let liTag = "";

    var eventsToFill = false;
    var nextEvent = false;

    if ((events.length > 0)) {
      var eventNumber = 0;
      nextEventDate = new Date(events[eventNumber]["ShiftStart"]);
      eventsToFill = true;
    }

    for (let i = firstDayofMonth; i > 0; i--) { // creating li of previous month last days
      liTag += `<li class="inactive">${lastDateofLastMonth - i + 1}</li>`;
    }

    for (let i = 1; i <= lastDateofMonth; i++) { // creating li of all days of current month
      var eventsData = [];

      if (nextEvent && events[eventNumber] != null) {
        nextEventDate = new Date(events[eventNumber]["ShiftStart"]);
        nextEvent = true;
      }
    
      // adding active class to li if the current day, month, and year matched
      let improvDate = (i).toLocaleString(undefined, { minimumIntegerDigits: 2, useGrouping: false })

      if( isToday = i === date.getDate() && eventsToFill === true && parseInt(improvDate) === nextEventDate.getDate() && currMonth + 1 === (nextEventDate.getMonth() + 1) && currYear === nextEventDate.getFullYear() && currMonth === new Date().getMonth() && currYear === new Date().getFullYear())
        {
          var j = eventNumber;
          while(j <= event.length-1)
            {
              eventDateCheck = new Date(events[j]["ShiftStart"])
              if(eventDateCheck.getDate() === parseInt(improvDate))
              {
                eventDateData += events[j];
                console.log(eventDateData);
                j++;
              }
              else
              {
                break;
              }
              
            }
          liTag += `<li id=${i}  onclick = "openEvent(...${eventDateData})" class="active event">${i}</li>`
          eventNumber = j;
          nextEvent = true
        }
      else if (eventsToFill && parseInt(improvDate) === nextEventDate.getDate() && currMonth + 1 === (nextEventDate.getMonth() + 1) && currYear === nextEventDate.getFullYear()) 
          {
            var isEventPresent = null;
            var j = eventNumber;
            var trialData = new Array();
            while(j <= events.length-1)
            {
              let eventDateCheck = new Date(events[j]["ShiftStart"])
              if(eventDateCheck.getDate() === parseInt(improvDate))
              {
                trialData.push(events[j]);
                j++;
              }
              else
              {
                break;
              }
            }
            
            eventDateData.push(trialData);
            liTag += `<li id=${i} onclick = "openEvent(this.id)" class="event">${i}</li>`
            eventNumber = j;
            nextEvent = true;
          }
      else if (isToday = i === date.getDate() && currMonth === new Date().getMonth() && currYear === new Date().getFullYear()) 
        {
          liTag += `<li id=${i} onclick = "openEvent()" class="active">${i}</li>`;
        }
      else 
        {
         liTag += `<li id=${i} onclick = "openEvent()">${i}</li>`;
        }
    }


    for (let i = lastDayofMonth; i < 6; i++) { // creating li of next month first days
      liTag += `<li class="inactive">${i - lastDayofMonth + 1}</li>`
    }
    currentDate.innerText = `${months[currMonth]} ${currYear}`; // passing current mon and yr as currentDate text
    daysTag.innerHTML = liTag;
  }
  
  <?php if( $ManagerAccess ) {
    $url = base_url("index.php/Calendar/getEventByMonth");
  } else {
    $url = base_url("index.php/Calendar/getStaffEvents");
  }?>
  
  url = <?php echo "'" . $url . "'" ?>

  $.ajax({
    url: url,
    method: 'get',
    data: { month: parseInt(currMonth + 1)},
    dataType: 'json',
    success: function (response) {
      events = response;
      console.log(response);
      dynamicCalendar(response);
    }
  })

  prevNextIcon.forEach(icon => { // getting prev and next icons

    icon.addEventListener("click", () => {// if clicked icon is previous icon then decrement current month by 1 else increment it by 1
      currMonth = icon.id === "prev" ? currMonth - 1 : currMonth + 1;

      if(currMonth < 0 ) { // if current month is less than 0 or greater than 11
            // creating a new date of current year & month and pass it as date value
            date = new Date();
            currYear--;
            currMonth = 11;
        } 
        else if(currMonth > 11){
            date = new Date(); // pass the current date as date value
            currYear++;
            currMonth = 0;
        }else {
        date = new Date(); // pass the current date as date value
      }

      <?php if( $ManagerAccess ) {
      $url = base_url("index.php/Calendar/getEventByMonth");
      } else {
      $url = base_url("index.php/Calendar/getStaffEvents");
      }?>
  
      url = <?php echo "'" . $url . "'" ?>

      // adding click event on both icons
      $.ajax({
        url: url,
        method: 'get',
        data: { month: currMonth + 1 },
        dataType: 'json',
        success: function (response) {
          events = response;
        },
        complete: function () {
          dynamicCalendar(events); // calling dynamicCalendar function
        }
      });

    })

  });

  function openEvent(Id) {
    document.getElementById("eventBar").style.display = "block";
    console.log(eventDateData);
    if (eventDateData == null) {
      console.log("nothing");
    } 
    else 
    {
      console.log("Data");
      var table = document.getElementById("displayEvent");
      var tempData;

      for(var i = 0; i<= (eventDateData.length-1); i++)
      {
        var date = new Date(eventDateData[i][0]["ShiftStart"]);
        console.log(date);
        let improvDate = (Id).toLocaleString(undefined, { minimumIntegerDigits: 2, useGrouping: false });

          if(date.getDate() == improvDate )
          {
            tempData = eventDateData[i];
            break;
          }
      }

      console.log(tempData);

      for(var j = 0; j<= (tempData.length -1); j++)
      {
        var tableRow = document.createElement("tr");
        tableRow.id = "row"+tempData[j]["RotaID"];
        for(var k = 0; k <= 3; k++)
        {
          var info;
          console.log(k);
          switch(k)
          {
            case 0:
              info = "ShiftStart";
              break;
            case 1:
              info = "EndTime";
              break;
            case 2:
              info = "Description";
              break;
            case 3:
              info = "RotaID";
          }
            rowInfo = tempData[j][info]
            var tableData = document.createElement("td");
            console.log(info);
            tableData.innerText = rowInfo;
            tableRow.appendChild(tableData);
            
            //create delete button
            if( <?php echo json_encode($ManagerAccess); ?> && k === 3) {
              var rowItem = document.createElement("td");
              let deleteButton = document.createElement('input');
              deleteButton.type = "button";
              deleteButton.id = "deleteButton"+rowInfo;
              deleteButton.value = "Delete";
              deleteButton.addEventListener("click",function(){deleteEvent(rowInfo);});
              rowItem.appendChild(deleteButton);
              tableRow.appendChild(rowItem);
            }
        }
        
        table.appendChild(tableRow);
      }

    }
  }

  function deleteEvent(id) {
    document.getElementById("row"+id).outerHTML="";

    $.ajax({
      url: '<?php echo base_url("index.php/Calendar/deleteEvent")?>',
      method: 'post',
      data: {id:id},
      success:function(){
        alert("Delete successful.");
      }
    })
  }
</script>

</html>
