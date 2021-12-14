<head>
    <title>PLVRS</title>
    <link rel="icon" href="assets/plv.png">
    <meta charset="UTF-8">

    <link rel="stylesheet" href="/bootstrap-3.4.1-dist/bootstrap-3.4.1-dist/css/bootstrap.min.css">
    <script src="/bootstrap-3.4.1-dist/bootstrap-3.4.1-dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/css/index.css">
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
    (async()=>{
        await onLoad(c)
        window.print();
    })();
    function loadImages(mainDiv, path,count) {
        return new Promise(resolve=>{ 
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

    function onLoad(ID) {
        return new Promise(resolve=>{
            var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = async function() {
            if (this.readyState == 4 && this.status == 200) {
                const myObj = JSON.parse(this.responseText);
                var div = document.createElement('div');
                var fullName = myObj.firstName + ' ' + myObj.middleName + ' ' + myObj.lastName;
                var array = await callUserDetails();
                div.innerHTML += '<h4>Name: ' + fullName + '</h4>';
                div.innerHTML += '<h4> Course and Section: ' + array.coursename + ' ' + array.sectionname + '<h4>';
                div.innerHTML += '<h4>Event: ' + myObj.eventName + '</h4>';
                div.innerHTML += '<h4>Adviser: ' + myObj.eventAdviser + '</h4>';
                div.innerHTML += '<h4>Starting Date: ' + myObj.dateStart + '</h4>';
                div.innerHTML += '<h4>Ending Date: ' + myObj.dateEnd + '</h4>';
                console.log(myObj.timeStart);
                var timeStart = tConvert(myObj.timeStart);
                var timeEnd = tConvert(myObj.timeEnd);
                div.innerHTML += '<h4>From: ' + timeStart + ' to ' + timeEnd + '</h4>';
                document.getElementById('mainBody').appendChild(div);
                var x = await loadRoomDetails(myObj.roomID, div, ID, myObj.userID)
                div.innerHTML += '<h4>Original Letter: </h4>';
             //   var a = await loadImages(div,myObj.imgLetter);+
                var a = await callReservationImage(div,ID);
                resolve('success');
            }
        }
        xmlhttp.open("GET", "/Request_SpecificReservation.php?r_ID=" + ID +'&isReviewed=' + null, true);
        xmlhttp.send();
        })
       
    }

    async function callUserDetails() {
        return promise = await new Promise(resolve => {
            var asd = <?php echo $_SESSION["usercourse"]; ?>;
            var section = <?php echo $_SESSION['userSection']; ?>;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var myObj = JSON.parse(this.responseText);
                    resolve(myObj);

                    return myObj;
                }
            }
            xmlhttp.open("GET", "/Request_Course.php?var=" + asd + '&section=' + section+ '&userID=' + null, true);
            xmlhttp.send();
        })

    }

    function loadRoomDetails(roomID, div, ID, userID) {
        return new Promise(resolve => {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = async function() {
                if (this.readyState == 4 && this.status == 200) {
                    var myObj = JSON.parse(this.responseText);
                    div.innerHTML += '<h4>Room Reserved : ' + myObj.roomName + '</h4>';
                    const second = await loadEquipDetails(ID, div, userID);
                    resolve('success');
                }
            }
            xmlhttp.open("GET", "/Request_SpecificRoom.php?var=" + roomID, true);
            xmlhttp.send();
        })
    }

    function loadEquipDetails(ID, mainDiv, userID) {
        return new Promise(resolve => {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = async function() {
                if (this.readyState == 4 && this.status == 200) {
                    var myObj = JSON.parse(this.responseText);
                    if (myObj.length == 0) {
                        mainDiv.innerHTML += await '<br><label class="equipID" placeholder = "EquipName"> No Equipment Borrowed </label>'
                    } else {
                        mainDiv.innerHTML += '<br><label class="equipID" placeholder = "EquipName"> Equipment Borrowed:  </label>'
                        var x = await myObj.forEach((element, index) =>  listEquipDetails(ID, mainDiv, element, index));
                    }
                    resolve('success');
                }
            }
            xmlhttp.open("GET", "/Request_ReservationForUserEquipment.php?var=" + ID, true);
            xmlhttp.send();
        })

    }

    function listEquipDetails(ID, mainDiv, element, index) {
        return new Promise(resolve=>{
        mainDiv.innerHTML += '<br><label class="equipID" placeholder = "EquipName">' + element.equipName + ': </label>'
        mainDiv.innerHTML += '<label disabled class="equipQty" placeholder = "EquipName">' + element.qty + '</label> ';
        resolve('success');
        })
        
    }

    function callReservationImage(mainDiv, r_ID) {
          return new Promise(resolve => {
              var xmlhttp = new XMLHttpRequest();
              xmlhttp.onreadystatechange = function() {
                  if (this.readyState == 4 && this.status == 200) {
                      var myObj = JSON.parse(this.responseText);
                      var imgArray = Object.values(myObj);
                      for(a = 0; a<imgArray.length;a++){
                        loadImages(mainDiv, imgArray,a);
                      }
                      resolve('success');
                  }
              }
              xmlhttp.open("GET", "/Request_imgForReservation.php?r_ID=" + r_ID, true);
              xmlhttp.send();
          })
      }
</script>

</html>