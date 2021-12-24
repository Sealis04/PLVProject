<script>
    var count = 0;
    var clicked = false;
    onload = getNotifications(1);
    isAdmin = <?php if (isset($_SESSION['isAdmin'])) echo $_SESSION['isAdmin']; ?>;

    function getNotifications(reset) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = async function() {
            if (this.readyState == 4 && this.status == 200) {
                var myObj = JSON.parse(this.responseText);
                console.log(clicked);
                if (clicked == false) {
                    var list = document.getElementById('notifList');
                    var div = document.createElement('div');
                    div.className = "row";
                    list.appendChild(div);
                    if (myObj.length > 0) {
                        var mainDiv = document.createElement('div');
                        mainDiv.className='mainDiv';
                        list.appendChild(mainDiv);
                        myObj.forEach(function(element, index) {
                            listNotif(myObj.length, element, index, mainDiv)
                        });
                        if (isAdmin != 1) {
                            if(count !=0){
                            var notifCount = document.getElementById('notif');
                            notifCount.innerHTML += '<sup id="sup"> ' + count + '<sup>';
                            var button = document.createElement('input');
                            button.id='markallasRead';
                            button.className='header-btn btn';
                            button.type = 'button';
                            button.value = 'Mark all as read';
                            document.addEventListener('click',markallasread);
                            div.appendChild(button);
                            }else{
                               div.innerHTML += '<p>No New Notifications</p>'; 
                            }
                        }
                        clicked = true;
                    } else {
                        div.innerHTML = ' No New Notifications';
                    }

                } else {
                    document.getElementsByClassName('notifs').remove
                    clicked == false;
                }
            }
        }
        xmlhttp.open("GET", "/Request_Notifications.php?reset=" + reset, true);
        xmlhttp.send();
    }
    function markallasread(e){
        if(e.target && e.target.id == 'markallasRead'){
            e.target.parentElement.parentElement.querySelectorAll('.detNotif').forEach(async e=>{
                console.log(e.id);
                var x = await notifRead(e.id)
            })
          document.querySelectorAll('.row').forEach(e=>{
              e.remove();
          })
          document.querySelectorAll('.mainDiv').forEach(e=>{
              e.remove();
          })
          document.getElementById('sup').remove();
          count = 0;
          clicked = false;
          getNotifications(1);
        }
    }
    function listNotif(length, element, index, mainDiv) {
        if (isAdmin != 1) {
            if (element.resisRead == 0) {
                if (typeof(element.resid) != undefined && element.resid != null) {
                    var decision;
                    if (element.resdecision == 1) {
                        decision = 'accepted';
                    } else if(element.resdecision == 4){
                        decision = 'cancelled';
                    }else{
                        decision = 'declined';
                    }
                    var div = document.createElement('a');
                    div.addEventListener('click', function() {
                        notifRead(element.resid);
                        window.location.href = "/Window_Panel.php?window=MyReservations "
                    })
                    div.innerHTML += '<div id="'+element.resid+'" class = "detNotif">';
                    div.innerHTML += '<p id="name"> Your reservation has been ' + decision + '</p>';
                    if (element.resisRead == 0) {
                        count++;
                    }
                    div.innerHTML += '<p>Event: ' + element.resName; + '</p>';
                    div.innerHTML += '</div>';
                    mainDiv.appendChild(div);
                }
            }
            if (element.regisRead == 0) {
            if (typeof(element.regid) != undefined && element.regid != null) {
                var decision;
                if (element.regdecision == 1) {
                    decision = 'accepted';
                } else {
                    decision = 'declined';
                }
                var div = document.createElement('a');
                div.addEventListener('click', function() {
                    notifRead(element.regid);
                    window.location.href = "/Window_Panel.php?window=Profile "
                })
                div.innerHTML += '<div id = "imgNotif" class="column">';
                div.innerHTML += '<img id="_notif" src = "">';
                div.innerHTML += '</div>';
                div.innerHTML += '<div id="'+element.regid+'" class = "detNotif">';
                div.innerHTML += '<p id="name"> Your registration has been ' + decision + '</p>';
                mainDiv.appendChild(div);
                if (element.regisRead == 0) {
                    count++;
                }
            }
        }
    } else {
        var list = document.getElementById('notifList');
        var div = document.createElement('div');
        div.innerHTML += '<div id="detNotif" class="detNotif">';
        div.innerHTML += '<p id="name">' + element.adminText + '</p>';
        div.innerHTML += '<p id="name">' + element.adminReservations + '</p>';
        div.innerHTML += '<p id="name">' + element.adminRegistration + '</p>';
        list.appendChild(div);
    }
    }

    function notifRead(id) {
        return new Promise(resolve=>{
            var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                resolve('success');
            }
        }
        xmlhttp.open("GET", "/Request_storeNotification.php?id=" + id, true);
        xmlhttp.send();
        })
        
    }
</script>