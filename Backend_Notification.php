<script>
getNotifications(1);
function getNotifications(reset){
    var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText);
                var myObj = JSON.parse(this.responseText);
                myObj.forEach(listNotif);
            }
        }
        xmlhttp.open("GET", "Request_Notifications.php?reset=" + reset, true);
        xmlhttp.send();
}

function listNotif(element,index){
//Add stuff here that appends to the notif button and lists all notifs
}
</script>