function openNav() {
  document.getElementById("mySidebar").style.width = "250px";
  document.getElementById("main").style.marginLeft = "250px";
}

function closeNav() {
  document.getElementById("mySidebar").style.width = "0";
  document.getElementById("main").style.marginLeft= "0";
}

function openEvent(){
    document.getElementById("eventBar").style.display ="block";
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

const dynamicCalendar = () => {
      let firstDayofMonth = new Date(currYear, currMonth, 1).getDay(), // getting first day of month
      lastDateofMonth = new Date(currYear, currMonth + 1, 0).getDate(), // getting last date of month
      lastDayofMonth = new Date(currYear, currMonth, lastDateofMonth).getDay(), // getting last day of month
      lastDateofLastMonth = new Date(currYear, currMonth, 0).getDate(); // getting last date of previous month
      let liTag = "";

            for (let i = firstDayofMonth; i > 0; i--) { // creating li of previous month last days
                      liTag += `<li class="inactive">${lastDateofLastMonth - i + 1}</li>`;
                  }

            for (let i = 1; i <= lastDateofMonth; i++) { // creating li of all days of current month
                      // adding active class to li if the current day, month, and year matched
                    let currentDate= (i).toLocaleString(undefined, {minimumIntegerDigits: 2, useGrouping:false}) 
                    let thisDate = new Date(`${currentDate} ${months[currMonth]} ${currYear}`);
                      console.log(thisDate);
                    let sqlDate = thisDate.toISOString(); 
                      console.log(sqlDate);
                    if(isToday = i=== date.getDate() && currMonth === new Date().getMonth()&& currYear === new Date().getFullYear())
                            {  
                                    liTag += `<li  onclick = "openEvent()" class="active">${i}</li>`;
                            }
                                   
                    else if(i == demoDate.getDate()&& currMonth === demoDate().getMonth()&& currYear === demoDate().getFullYear())
                    {
                        liTag += `<li onclick = "openEvent()" class="event">${i}</li>`; 
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
dynamicCalendar();

prevNextIcon.forEach(icon => { // getting prev and next icons
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
        dynamicCalendar(); // calling dynamicCalendar function
    });
});
