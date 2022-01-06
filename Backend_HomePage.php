<script>
    let today = new Date();
    let currentDay = today.getDate();
    let currentMonth = today.getMonth();
    let currentYear = today.getFullYear();
    //let selectYear = document.getElementById('year');
    //let selectMonth = document.getElementById('month');
    let months = ['Jan', 'Feb', 'Mar', "Apr", 'May', 'Jun', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'];
      let fullmonths = ['January', 'Februaru', 'March', "April", 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    let monthAndYear = document.getElementById('monthAndYear');
    // loopYear(currentYear);
    calendar(currentMonth, currentYear);
    // loopBody('2021', '11', '2');
    openDate(currentMonth, currentYear, currentDay);
    let activeMonth;
    let activeYear;
    let activeDay;
    // function loopBody() {}

    function nextMonth() {    
        currentYear = (currentMonth == 11) ? currentYear + 1 : currentYear;
        currentMonth = (currentMonth + 1) % 12;
        activeDay = '1';
        // if(activeYear == currentYear){
        //     if(activeMonth == currentMonth){
        //         calendar(currentMonth, currentYear,activeDay);
        //     }else{
        //         calendar(currentMonth, currentYear);
        //     }
        // }else{
            calendar(currentMonth, currentYear,activeDay);
        // }
        openDate(currentMonth,currentYear,activeDay);
    }

    function prevMonth() {
        currentYear = (currentMonth == 0) ? currentYear - 1 : currentYear;
        currentMonth = (currentMonth == 0) ? 11 : currentMonth - 1;
        activeDay = '1';
        // if(activeYear == currentYear){
        //     if(activeMonth == currentMonth){
        //         calendar(currentMonth, currentYear,activeDay);
        //     }else{
        //         calendar(currentMonth, currentYear);
        //     }
        // }else{
            calendar(currentMonth, currentYear,activeDay);
            openDate(currentMonth,currentYear,activeDay);
        // }

    }
    // Jumping code
    function jump() {
        currentYear = parseInt(selectYear.value);
        currentMonth = parseInt(selectMonth.value);
        calendar(currentMonth, currentYear);
    }

    // function loopYear(year) {
    //     var yearList = document.getElementById('year');
    //     yearList.addEventListener('change', jump);
    //     for (a = 15; a > 0; a--) {
    //         var option = document.createElement('option');
    //         option.textContent = year - a;
    //         option.value = year - a;
    //         yearList.appendChild(option);
    //     }
    //     for (a = 0; a < 15; a++) {
    //         var option = document.createElement('option');
    //         option.textContent = year + a;
    //         option.value = year + a;
    //         yearList.appendChild(option);
    //     }
    //     for (a = 0; a < yearList.length; a++) {
    //         if (yearList.options[a].value == year) {
    //             console.log("im in");
    //             yearList.selectedIndex = a;
    //         }
    //     }
    // }

    function addRowHandlers() {
        var table = document.getElementById('calendar');
        var rows = table.getElementsByTagName('tr');
        for (i = 0; i < rows.length; i++) {
            var currentRow = table.rows[i];
            var columns = currentRow.getElementsByTagName('td');
            for (a = 0; a < columns.length; a++) {
                var currentValue = columns[a];
                var createClickHandler =
                    function(row) {
                        return function() {
                            var active = document.getElementsByClassName("active");
                            if (active.length > 0) {
                                active[0].className = active[0].className.replace("active", "");
                                row.className += ' active';
                            } else {
                                row.className += 'active';
                            }
                            var id = row.innerHTML;
                            activeYear = currentYear;
                            activeMonth= currentMonth;
                            // activeDay = id;
                            openDate(currentMonth, currentYear, id);
                        }
                    }
                currentValue.onclick = createClickHandler(currentValue);
            }
        }
    }

    function calendar(month, year,activeDay) {
        var firstDay = (new Date(year, month)).getDay();
        let daysInMonth = new Date(year, month + 1, 0).getDate();
        let tbl_body = document.getElementById('calendar-body');
        tbl_body.innerHTML = "";
        monthAndYear.innerHTML = months[month] + " " + year;
        let date = 1;
        let activeDate;
        for (let i = 0; i < 6; i++) {
            let row = document.createElement('tr');
            for (let j = 0; j < 7; j++) {
                if (i == 0 && j < firstDay) {
                    let cell = document.createElement('td');
                    cell.style = 'height:5vw;text-align:left;vertical-align:top;'
                    let cellText = document.createTextNode('');
                    cell.appendChild(cellText);
                    row.appendChild(cell);
                } else if (date > daysInMonth) {
                    break;
                } else {
                    let cell = document.createElement('td');
                    cell.style = 'height:5vw;text-align:left;vertical-align:top';
                    let cellText = document.createTextNode(date);
                    if (date === today.getDate() && year == today.getFullYear() && month === today.getMonth()) {
                        cell.classList.add('bg-info');
                    }
                    if(activeDay == date){
                        cell.classList.add('active');
                    }
                    cell.appendChild(cellText);
                    row.appendChild(cell);
                    date++;
                }
            }
            tbl_body.appendChild(row);
        }
        addRowHandlers();
    }

    // opens scheduled reservations
    function openDate(currentMonth, currentYear, selectedDay) {
       var date = currentYear + '-' + (currentMonth + 1) + '-' + selectedDay;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var myObj = JSON.parse(this.responseText);
                var mainDiv = document.getElementById('listBody');
                var x = fullmonths[currentMonth];
                currentDate = x + ' ' + selectedDay + ', ' + currentYear;
                console.log(currentDate);
                if (myObj.length != 0) {
                    mainDiv.innerHTML = "";
                    myObj.forEach(function(element,index){
                        listEvents(currentDate,element,index)
                    });
                } else {
                    mainDiv.innerHTML = 'No Reservations scheduled';
                }

            }
        }
        xmlhttp.open("GET", "/Request_CheckReservations.php?date=" +  date, true);
        xmlhttp.send();
    }

    function listEvents(currDate,element, index) {
        var div = document.getElementById('listBody');
        // div.innerHTML = ' <h3>Event Name: '+ element.event_name+' ['+element.start +' - ' + element.end +']</h3>';
        // div.innerHTML += '<h3>Room Name:'+ element.room_name+'</h3>';
        // div.innerHTML += '<h3>Reserved By:'+ element.firstName+ ' ' + element.middleName + ' ' + element.lastName+'</h3>';
        div.innerHTML += '<h4>' + element.event_name + '<h4>';
        // div.innerHTML += '<h5>' + +'<h5>'
        let start = tConvert(element.start);
        let end = tConvert (element.end);
        div.innerHTML += '<h5>' + currDate + '<h5> <br>';
        div.innerHTML += '<h5>' + start + ' to ' + end +'<h5> <br>';
        div.innerHTML += '<h5>' + element.room_name + '<h5>';
        div.innerHTML += '<h5> Reserved By:' + element.firstName + ' ' + element.middleName + ' ' + element.lastName + '<h5>';
         div.innerHTML += '<h5> Facilitated by:' + element.facilitator + '<h5>';
        div.innerHTML += '<hr class="hr">';

    }
    
    function tConvert(time) {
        // Check correct time format and split into components
        time = time.toString().match(/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];

        if (time.length > 1) { // If time format correct
            time = time.slice(1); // Remove full string match value
            time[5] = +time[0] < 12 ? ' AM' : ' PM'; // Set AM/PM
            time[0] = +time[0] % 12 || 12; // Adjust hours
        }
        return time.join(''); // return adjusted time or original string
    }
</script>