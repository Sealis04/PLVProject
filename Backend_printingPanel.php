<head>
    <title>PLVRS</title>
    <link rel="icon" href="assets/plv.png">
    <meta charset="UTF-8">

    <link rel="stylesheet" href="/bootstrap-3.4.1-dist/bootstrap-3.4.1-dist/css/bootstrap.min.css">
    <script src="/bootstrap-3.4.1-dist/bootstrap-3.4.1-dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/printLetter.css">
</head>

<body>
    <?php
    include "db_connection.php";
    session_start();
    ?>
    <div id='mainBody'>

    </div>
    <sidenav>
        <?php
        // require "Backend_CheckifLoggedIN.php";
        ?>
    </sidenav>
</body>
<script>
    var url = window.location.href;
    var url_string = new URL(url);
    var c = url_string.searchParams.get('id');
    console.log(c);
    (async () => {
        await onLoad(c)

    })();
    createButton();

    function loadImages(mainDiv, path, count) {
        return new Promise(resolve => {
            var i = 0;
            var div = document.createElement('div');
            div.className = 'modalImage';
            var img = document.createElement('img');
            img.className = "myImg";
            img.src = path[count];
            img.id = 'container';
            div.appendChild(img);
            mainDiv.appendChild(div);
            resolve('success');
        })
    }

    function tConvert(time) {
        // Check correct time format and split into components
        time = time.toString().match(/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];
        if (time.length > 1) { // If time format correct
            time = time.slice(1); // Remove full string match value
            time[5] = +time[0] < 12 ? 'AM' : 'PM'; // Set AM/PM
            time[0] = +time[0] % 12 || 12; // Adjust hours
        }
        return time.join(''); // return adjusted time or original string
    }

    function createButton() {
        var main = document.getElementById('mainBody');
        var buttonsDiv = document.createElement('div');
        buttonsDiv.id = 'buttonsDiv';
        var print = document.createElement('input');
        print.className = 'header-btn btn printBtn';
        var save = document.createElement('input');
        save.className = 'header-btn btn printBtn';
        print.type = 'button';
        print.value = 'Print';
        save.type = 'button';
        save.value = 'Save as PDF';
        print.addEventListener('click', function(e) {
            window.print();
        });
        save.addEventListener('click', Modal)
        buttonsDiv.appendChild(print);
        buttonsDiv.appendChild(save);
        main.appendChild(buttonsDiv);
    }

    function Modal() {
        modalBody = document.createElement('div');
        invisibleContainer = document.createElement('div');
        invisibleContainer.className = 'fullscreenContainer';
        modalBody.className = 'modalConfirm shadow p-3 mb-5 bg-white rounded'
        modalMessage = document.createElement('h4');
        modalMessage.textContent = "Instructions to save as PDF";
        modalImg = document.createElement('img');
        modalImg.src = "assets/saveaspdfGuide.png";
        modalConfirm = document.createElement('input');
        modalConfirm.className = 'btn btn-primary okay';
        modalConfirm.type = 'button';
        modalConfirm.style = "font-size:15px; margin-left:45%;"
        modalConfirm.value = "Ok";
        modalBody.appendChild(modalMessage);
        modalBody.appendChild(modalImg);
        modalBody.appendChild(modalConfirm);
        invisibleContainer.appendChild(modalBody);
        modalConfirm.addEventListener('click', function(e) {
            invisibleContainer.remove();
            window.print();
        });
        document.body.appendChild(invisibleContainer);
    }

    function onLoad(ID) {
        return new Promise(resolve => {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = async function() {
                if (this.readyState == 4 && this.status == 200) {
                    const myObj = JSON.parse(this.responseText);
                    console.log(myObj);
                    var div = document.createElement('div');
                    div.id = "sample";
                    var fullName = myObj.firstName + ' ' + myObj.middleName + ' ' + myObj.lastName;
                    div.innerHTML += '<img class="header" id="plvlogo" src="assets/plvlogo.png"/>';
                    div.innerHTML += '<header class="header" id="plvtext">PAMANTASAN NG LUNGSOD NG VALENZUELA' + '<br>' + 'Tongco St., Maysan, Valenzuela City</header>';
                    div.innerHTML += '<h5><i>The purpose of this document is a hard copy proof of approved reservation that must be shown to Engr. Psalms June H. Tan at the General Services Office for signatories of the room and equipment reserved.</i></h5>';
                    div.innerHTML += '<h4><b>The reservation details of Reservation ID#1 are stated below:</b></h4>';
                    div.innerHTML += '<h4><b>Reservation ID: &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</b>' + myObj.r_ID + '</h4>';
                    div.innerHTML += '<h4><b>Name:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</b>' + fullName + '</h4>';
                    if (myObj.course == myObj.section) {
                        div.innerHTML += '<h4><b>Course:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp </b>' + myObj.course + '<h4>';
                    } else {
                        div.innerHTML += '<h4><b>Course and Section:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp </b>' + myObj.course + ' ' + myObj.section + '<h4>';
                    }
                    const monthNames = ["January", "February", "March", "April", "May", "June",
                        "July", "August", "September", "October", "November", "December"
                    ];
                    var startdate = new Date(myObj.dateStart);
                    var startDay = startdate.getDay();
                    var startYear = startdate.getFullYear();
                    var startMonth = startdate.getMonth();
                    var startMWord = monthNames[startMonth];
                    var newStart = startMWord + ' ' + startDay + ', ' + startYear;
                    var enddate = new Date(myObj.dateEnd);
                    var endDay = enddate.getDay();
                    var endYear = enddate.getFullYear();
                    var endMonth = enddate.getMonth();
                    var endMWord = monthNames[endMonth];
                    var newEnd = endMWord + ' ' + endDay + ', ' + endYear;
                    div.innerHTML += '<h4><b>Event:     &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</b>' + myObj.eventName + '</h4>';
                    div.innerHTML += '<h4><b>Adviser: &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp </b>' + myObj.eventAdviser + '</h4>';
                    div.innerHTML += '<h4><b>Starting Date:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</b>' + newStart + '</h4>';
                    div.innerHTML += '<h4><b>Ending Date:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</b>' + newEnd + '</h4>';
                    console.log(myObj.timeStart)
                    var timeStart = tConvert(myObj.timeStart);
                    var timeEnd = tConvert(myObj.timeEnd);
                    div.innerHTML += '<h4><b>Time:&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</b> ' + timeStart + ' to ' + timeEnd + '</h4>';
                    document.getElementById('mainBody').appendChild(div);
                    div.innerHTML += '<h4><b>Room Reserved:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</b>' + myObj.roomname + '</h4>';
                    if ((myObj.equip).length == 0) {
                        div.innerHTML += '<br><h4 class="equipID" placeholder = "EquipName"> No Equipment Borrowed </h4 >'
                    } else {
                        div.innerHTML += '<br><h4 class="equipID" placeholder = "EquipName"> Equipment Borrowed:  </h4 >';
                        (myObj.equip).forEach(function(element, index) {
                        listEquipDetails(div, element, index);
                    })
                    }

                    
                    div.innerHTML += '<h4><br><br><br>Approved by:</h4>';
                    div.innerHTML += '<h4>__________________________</h4>';
                    div.innerHTML += '<h4>ENGR. PSALMS JUNE H. TAN</h4>';
                    div.innerHTML += '<h4><i>Assistant Building Administrator</i></h4>';
                    div.innerHTML += '<h4><br><br><b>Scanned Copy of Approval Letter:</b> </h4>';
                    var newdiv = document.createElement('div');
                    newdiv.id = 'pagebreak';
                    div.appendChild(newdiv);
                    for (a = 0; a < (myObj.letters).length; a++) {
                        loadImages(newdiv, myObj.letters, a)
                    }
                    resolve('success');
                }
            }
            xmlhttp.open("GET", "/Request_SpecificReservation.php?r_ID=" + ID + '&isReviewed=' + null, true);
            xmlhttp.send();
        })
    }

    function listEquipDetails(mainDiv, element, index) {
        mainDiv.innerHTML += '<br><h4  class="equipID" placeholder = "EquipName">' + element.equipName + ': </h4 >'
        mainDiv.innerHTML += '<h4  disabled class="equipQty" placeholder = "EquipName">' + element.qty + '</h4 > ';
    }

    // function callReservationImage(mainDiv, r_ID) {
    //     return new Promise(resolve => {
    //         var xmlhttp = new XMLHttpRequest();
    //         xmlhttp.onreadystatechange = function() {
    //             if (this.readyState == 4 && this.status == 200) {
    //                 var myObj = JSON.parse(this.responseText);
    //                 var imgArray = Object.values(myObj);
    //                 var div = document.createElement('div');
    //                     div.id = 'pagebreak';
    //                     mainDiv.appendChild(div);
    //                 for (a = 0; a < imgArray.length; a++) {
    //                     loadImages(div, imgArray, a);
    //                 }
    //                 resolve('success');
    //             }
    //         }
    //         xmlhttp.open("GET", "/Request_imgForReservation.php?r_ID=" + r_ID, true);
    //         xmlhttp.send();
    //     })
    // }
</script>

</html>