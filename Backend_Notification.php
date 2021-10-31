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
                        if (isAdmin != 1) {
                            var button = document.createElement('input');
                            button.type = 'button';
                            button.value = 'Mark all as read';
                            div.appendChild(button);
                            myObj.forEach(function(element, index) {
                                listNotif(myObj.length, element, index)
                            });
                        } else {
                            var notif = document.createElement('notif');
                            notif.innerHTML = myObj[myObj.length - 1].text;
                            list.appendChild(notif);
                        }
                        var dropdown = document.getElementById('notifDropdown');
                        var notifCount = document.createElement('span');
                        notifCount.textContent = count;
                        dropdown.appendChild(notifCount);
                        clicked = true;
                    }else{
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
        var list = document.getElementById('notifList');
        var div = document.createElement('div');
        div.innerHTML += '<div id = "imgNotif" class="column">';
        div.innerHTML += '<img id="_notif" src = "">';
        div.innerHTML += '</div>';
        div.innerHTML += '<div id="detNotif" class = "column">';
        div.innerHTML += '<p id="name">' + element.text + '</p>';
        if (element.isRead == 0) {
            count++;
        }
        loadNotifDetails(element.r_ID, div);

        list.appendChild(div);
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

    function loadNotifDetails(r_ID, div) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var myObj = JSON.parse(this.responseText)
                var start = new Date(myObj.start).toISOString().split('T')[0] + ' ' + new Date(myObj.start).toTimeString().split(' ')[0] + ' to ' + new Date(myObj.end).toTimeString().split(' ')[0]
                div.innerHTML += '<p>Schedule: ' + start; + '</p>'
                div.innerHTML += '<p>Event: ' + myObj.eventName; + '</p>'
                div.innerHTML += '</div>';
            }
        }
        xmlhttp.open("GET", "/Request_NotifReservation.php?id=" + r_ID, true);
        xmlhttp.send();
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