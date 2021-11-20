<html>

<head>
    <title>PLVRS</title>
    <link rel="icon" href="assets/plv.png">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="bootstrap-3.4.1-dist/bootstrap-3.4.1-dist/css/bootstrap.min.css">
    <script src="bootstrap-3.4.1-dist/bootstrap-3.4.1-dist/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="css/Policies.css">
</head>

<body>
    <div>
    <div> 
        <input value='<' onclick='prevMonth()' type='button' style="display:inline-block;   ">
        <h3 id="monthAndYear" style="display:inline-block; "></h3> 
        <input value='>' onclick='nextMonth()' type='button' style="display:inline-block; ">
    </div>
        <table id="calendar">
            <thead>
                <tr>
                    <th>Sun</th>
                    <th>Mon</th>
                    <th>Tue</th>
                    <th>Wed</th>
                    <th>Thurs</th>
                    <th>Fri</th>
                    <th>Sat</th>
                </tr>
            </thead>
            <tbody id="calendar-body">
            </tbody>
        </table>
        <div>
            <label for="month"></label>
            <select name="month" id="month" onchange='jump()'>
                <option value=0>Jan</option>
                <option value=1>Feb</option>
                <option value=2>Mar</option>
                <option value=3>Apr</option>
                <option value=4>May</option>
                <option value=5>Jun</option>
                <option value=6>Jul</option>
                <option value=7>Aug</option>
                <option value=8>Sept</option>
                <option value=9>Oct</option>
                <option value=10>Nov</option>
                <option value=11>Dec</option>
            </select>
            <label for="year"></label>
            <select name="year" id="year">
            </select>
        </div>
    </div>
    <div id = 'body'>
       
    <!-- <div id='hoursLabel' style='flex:1%;'>
    </div>
    <div id='hoursbody' style='flex:99%'>
    </div> -->
    </div>
    <script>
        let today = new Date();
        let currentDay = today.getDay();
        let currentMonth = today.getMonth();
        let currentYear = today.getFullYear();
        let selectYear = document.getElementById('year');
        let selectMonth = document.getElementById('month');
        let months = ['Jan', 'Feb', 'Mar', "Apr", 'May', 'Jun', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'];
        let monthAndYear = document.getElementById('monthAndYear');
        loopYear(currentYear);
        calendar(currentMonth, currentYear);
        loopBody('2021','11','2');
        openDate(currentMonth,currentYear,currentDay);
        function loopBody(){
        }
        function nextMonth() {
            currentYear = (currentMonth == 11) ? currentYear + 1 : currentYear;
            currentMonth = (currentMonth + 1) % 12;
            calendar(currentMonth, currentYear);
        }

        function prevMonth() {
            currentYear = (currentMonth == 0) ? currentYear - 1 : currentYear;
            currentMonth = (currentMonth == 0) ? 11 : currentMonth - 1;
            calendar(currentMonth, currentYear);
        }
        

        function jump() {
            currentYear = parseInt(selectYear.value);
            currentMonth = parseInt(selectMonth.value);
            calendar(currentMonth, currentYear);
        }

        function loopYear(year) {
            var yearList = document.getElementById('year');
            yearList.addEventListener('change', jump);
            for (a = 15; a > 0; a--) {
                var option = document.createElement('option');
                option.textContent = year - a;
                option.value = year - a;
                yearList.appendChild(option);
            }
            for (a = 0; a < 15; a++) {
                var option = document.createElement('option');
                option.textContent = year + a;
                option.value = year + a;
                yearList.appendChild(option);
            }
            for (a = 0; a < yearList.length; a++) {
                if (yearList.options[a].value == year) {
                    console.log("im in");
                    yearList.selectedIndex = a;
                }
            }
        }
        function addRowHandlers(){
            var table = document.getElementById('calendar');
            var rows = table.getElementsByTagName('tr');
            for(i=0;i<rows.length;i++){
                var currentRow=table.rows[i];
                var columns = currentRow.getElementsByTagName('td');
                for(a = 0;a<columns.length;a++){
                    var currentValue = columns[a];
                    var createClickHandler = 
                    function (row){
                    return function(){
                        var active = document.getElementsByClassName("active");
                        active[0].className = active[0].className.replace(" active", "");
                        row.className += ' active';
                        var id = row.innerHTML;
                        alert(id + ' '+ currentMonth + ' ' + currentYear);
                        //openDate(currentMonth,currentYear,id);
                    }
                }
                currentValue.onclick = createClickHandler(currentValue);
                }
            }
        }

        // function openDate(currentMonth,currentYear,selectedDay){
        // var xmlhttp = new XMLHttpRequest();
        // xmlhttp.onreadystatechange = function() {
        //     if (this.readyState == 4 && this.status == 200) {
        //         var myObj = JSON.parse(this.responseText);
        //         var mainDiv = document.getElementById('body');
        //         mainDiv.innerHTML ='';
        //         if(myObj.length != 0){
        //         myObj.forEach(listEvents);
        //         }else{
        //         mainDiv.innerHTML = 'No Reservations scheduled';
        //         }
              
        //     }
        // }
        // xmlhttp.open("GET", "/Request_CheckReservations.php?month=" + currentMonth + '&year=' + currentYear + '&day=' + selectedDay, true);
        // xmlhttp.send();
        // }

        // function listEvents(element,index){
        //     var mainDiv = document.getElementById('body');
        //     var div = document.createElement('div');
        //     div.innerHTML = ' <h3>Event Name: '+ element.event_name+' ['+element.start +' - ' + element.end +']</h3>';
        //     div.innerHTML += '<h3>Room Name:'+ element.room_name+'</h3>';
        //     div.innerHTML += '<h3>Reserved By:'+ element.firstName+ ' ' + element.middleName + ' ' + element.lastName+'</h3>';
        //     mainDiv.appendChild(div);

        // }
        function calendar(month, year) {
         
            var firstDay = (new Date(year, month)).getDay();
            let daysInMonth = 32 - new Date(year, 2, 32).getDate();
            let tbl_body = document.getElementById('calendar-body');

            tbl_body.innerHTML = "";
            monthAndYear.innerHTML = months[month] + " " + year;
            selectYear.value = year;
            selectMonth.value = month;

            let date = 1;
            for (let i = 0; i < 6; i++) { 
                let row = document.createElement('tr');
                for (let j = 0; j < 7; j++) {
                    if (i == 0 && j < firstDay) {
                        let cell = document.createElement('td');
                        let cellText = document.createTextNode('');
                        cell.appendChild(cellText);
                        row.appendChild(cell);
                    } else if (date > daysInMonth) {
                        break;
                    } else {
                        let cell = document.createElement('td');
                        let cellText = document.createTextNode(date);
                     
                        if (date === today.getDate() && year == today.getFullYear() && month === today.getMonth()) {
                            cell.classList.add('bg-info');
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
    </script>
</body>

</html>