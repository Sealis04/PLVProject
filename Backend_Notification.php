<script>
    var count = 0;
    var clicked = false;
    onload = getNotifications(1);
    isAdmin = <?php
                echo $_SESSION['isAdmin']; ?>;

    function getNotifications(reset) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var myObj = JSON.parse(this.responseText);
                if (clicked == false) {
                    var list = document.getElementById('notifList');
                    var div = document.createElement('div');
                    div.className = "row";
                    list.appendChild(div);
                    if (myObj.length > 0) {
                        myObj.forEach(function(element, index) {
                            listNotif(myObj.length, element, index)
                        });
                        if (isAdmin != 1) {
                            var button = document.createElement('input');
                            button.type = 'button';
                            button.value = 'Mark all as read';
                            div.appendChild(button);
                            var dropdown = document.getElementById('notifDropdown');
                            var notifCount = document.createElement('span');
                            notifCount.textContent = count;
                            dropdown.appendChild(notifCount);
                            console.log(count);
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

    function listNotif(length, element, index) {
        if (isAdmin != 1) {
            if (typeof(element.regid)!= undefined && element.regid != null ){
            var decision;
            if(element.regdecision == 1){
                decision = 'accepted';
            }else{
                decision = 'declined';
            }
            var list = document.getElementById('notifList');
            var div = document.createElement('a');
            div.addEventListener('click',function(){
                notifRead(element.resid);
                window.location.href = "/Window_AdminPanel.php/ "
            })
            div.innerHTML += '<div id = "imgNotif" class="column">';
            div.innerHTML += '<img id="_notif" src = "">';
            div.innerHTML += '</div>';
            div.innerHTML += '<div id="detNotif" class = "column">';
            div.innerHTML += '<p id="name"> Your registration has been ' +decision + '</p>';
            if (element.regisRead == 0) {
                count++;
            }

            list.appendChild(div);
            }
            if(typeof(element.resid)!= undefined && element.resid != null){
                var decision;
            if(element.resdecision == 1){
                decision = 'accepted';
            }else{
                decision = 'declined';
            }
            var list = document.getElementById('notifList');
            var div = document.createElement('a');
            div.addEventListener('click',function(){
                notifRead(element.resid);
                window.location.href = "/Window_AdminPanel.php/?category=notifUser "
            })
            div.innerHTML += '<div id = "imgNotif" class="column">';
            div.innerHTML += '<img id="_notif" src = "">';
            div.innerHTML += '</div>';
            div.innerHTML += '<div id="detNotif" class = "column">';
            div.innerHTML += '<p id="name"> Your reservation has been ' + decision + '</p>';
            if (element.resisRead == 0) {
                count++;
            }

            var start = new Date(element.resStart).toISOString().split('T')[0] + ' ' + new Date(element.resStart).toTimeString().split(' ')[0] + ' to ' + new Date(element.resEnd).toTimeString().split(' ')[0]
                div.innerHTML += '<p>Schedule: ' + start; + '</p>'
                div.innerHTML += '<p>Event: ' + element.resName; + '</p>'
                div.innerHTML += '</div>';

            list.appendChild(div);
            } 
          
        } else {
            var list = document.getElementById('notifList');
            var div = document.createElement('div');
            div.innerHTML += '<div id="detNotif" class="column">';
            div.innerHTML += '<p id="name">' + element.adminText + '</p>';
            div.innerHTML += '<p id="name">' + element.adminReservations + '</p>';
            div.innerHTML += '<p id="name">' + element.adminRegistration + '</p>';
            list.appendChild(div);
        }

        // var notifDiv = document.createElement('div');
        // notifDiv.id = 'class';
        // var href = document.createElement('a');
        // //href.href = 'Window_AdminPanel.php/my'+ element.userID;
        // href.addEventListener('click',function(){
        //     notifRead(element.id);
        // })
        // var paraText = document.createElement('label');
        // paraText.type = 'text';
        // paraText.textContent = element.text;
        // if (element.isRead == 0) {
        //     count++;
        //     notifDiv.className = 'notRead';
        // }
        // href.appendChild(paraText);
        // notifDiv.appendChild(href);
        // list.appendChild(notifDiv);
    }

    function notifRead(id) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {}
        }
        xmlhttp.open("GET", "/Request_storeNotification.php?id=" + id, true);
        xmlhttp.send();
    }
</script>