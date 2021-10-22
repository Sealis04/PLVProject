<script>
    var count = 0;
    var clicked = false;
    onload = getNotifications(1);
    function getNotifications(reset) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var myObj = JSON.parse(this.responseText);
                if(clicked == false){
                    myObj.forEach(function(element, index) {
                    listNotif(myObj.length, element, index)
                });
                var dropdown = document.getElementById('notifDropdown');
                var notifCount = document.createElement('span');
                notifCount.textContent = count;
                dropdown.appendChild(notifCount);
                clicked = true;
                }else{
                    document.getElementsByClassName('notifs').remove
                    clicked == false;
                }
               
            }
        }
        xmlhttp.open("GET", "Request_Notifications.php?reset=" + reset, true);
        xmlhttp.send();
    }

    function listNotif(length, element, index) {
        var list = document.getElementById('notifList');
        var notifDiv = document.createElement('div');
        notifDiv.id = 'class';
        var href = document.createElement('a');
        //href.href = 'Window_AdminPanel.php/my'+ element.userID;
        href.addEventListener('click',function(){
            notifRead(element.id);
        })
        var paraText = document.createElement('label');
        paraText.type = 'text';
        paraText.textContent = element.text;
        if (element.isRead == 0) {
            count++;
            notifDiv.className = 'notRead';
        }
        href.appendChild(paraText);
        notifDiv.appendChild(href);
        list.appendChild(notifDiv);
    }

    function notifRead(id){
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
            }
        }
        xmlhttp.open("GET", "Request_storeNotification.php?id=" + id, true);
        xmlhttp.send();
    }
</script>