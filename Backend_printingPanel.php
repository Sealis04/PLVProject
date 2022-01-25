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
    (async()=>{
        await onLoad(c)
        
    })();
    createButton();
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
    function createButton(){
        var main = document.getElementById('mainBody');
        var buttonsDiv = document.createElement('div');
        buttonsDiv.id = 'buttonsDiv';
        var print = document.createElement('input');
        var save = document.createElement('input');
        print.type='button';
        print.value = 'Print';
        save.type= 'button';
        save.value='Save as PDF';
        print.addEventListener('click',print);
        buttonsDiv.appendChild(print);
        buttonsDiv.appendChild(save);
        main.appendChild(buttonsDiv);
    }
    function print(e){
    console.log('asd');
    // var prtContent = document.getElementById('main');
    // var WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
    
    // // WinPrint.document.write('<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">');

    // WinPrint.document.write(prtContent.innerHTML);
    // WinPrint.document.close();
    // WinPrint.setTimeout(function(){
    //   WinPrint.focus();
    //   WinPrint.print();
    //   WinPrint.close();
    // }, 1000);
    }
    function onLoad(ID) {
        return new Promise(resolve=>{
            var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = async function() {
            if (this.readyState == 4 && this.status == 200) {
                const myObj = JSON.parse(this.responseText);
                var div = document.createElement('div');
                div.className="sample";
                var fullName = myObj.firstName + ' ' + myObj.middleName + ' ' + myObj.lastName;
                var array = await callUserDetails();
                div.innerHTML += '<img class="header" id="plvlogo" src="assets/plvlogo.png"/>';
                div.innerHTML += '<header class="header" id="plvtext">PAMANTASAN NG LUNGSOD NG VALENZUELA'+'<br>'+'Tongco St., Maysan, Valenzuela City</header>';
                div.innerHTML += '<h5><i>The purpose of this document is a hard copy proof of approved reservation that must be shown to Engr. Psalms June H. Tan at the General Services Office for signatories of the room and equipment reserved.</i></h5>';
                div.innerHTML += '<h4><b>The reservation details of Reservation ID#1 are stated below:</b></h4>';
                div.innerHTML += '<h4><b>Name:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</b>'+ fullName + '</h4>';
                div.innerHTML += '<h4><b>Course and Section:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp </b>' + array.coursename + ' ' + array.sectionname + '<h4>';
                div.innerHTML += '<h4><b>Event:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</b>' + myObj.eventName + '</h4>';
                div.innerHTML += '<h4><b>Adviser:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp </b>' + myObj.eventAdviser + '</h4>';
                div.innerHTML += '<h4><b>Starting Date:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</b>' + myObj.dateStart + '</h4>';
                div.innerHTML += '<h4><b>Ending Date:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</b>' + myObj.dateEnd + '</h4>';
                console.log(myObj.timeStart);
                var timeStart = tConvert(myObj.timeStart);
                var timeEnd = tConvert(myObj.timeEnd);
                div.innerHTML += '<h4><b>Time:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</b> ' + timeStart + ' to ' + timeEnd + '</h4>';
                document.getElementById('mainBody').appendChild(div);
                var x = await loadRoomDetails(myObj.roomID, div, ID, myObj.userID)
                div.innerHTML += '<h4><br><br><br>Approved by:</h4>';
                div.innerHTML += '<h4>__________________________</h4>';
                div.innerHTML += '<h4>ENGR. PSALMS JUNE H. TAN</h4>';
                div.innerHTML += '<h4><i>Assistant Building Administrator</i></h4>';
                div.innerHTML += '<h4><br><br><b>Scanned Copy of Approval Letter:</b> </h4>';
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
                    div.innerHTML += '<h4><b>Room Reserved:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</b>' + myObj.roomName + '</h4>';
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
                        mainDiv.innerHTML += await '<br><h4 class="equipID" placeholder = "EquipName"> No Equipment Borrowed </h4 >'
                    } else {
                        mainDiv.innerHTML += '<br><h4 class="equipID" placeholder = "EquipName"> Equipment Borrowed:  </h4 >'
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
        mainDiv.innerHTML += '<br><h4  class="equipID" placeholder = "EquipName">' + element.equipName + ': </h4 >'
        mainDiv.innerHTML += '<h4  disabled class="equipQty" placeholder = "EquipName">' + element.qty + '</h4 > ';
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