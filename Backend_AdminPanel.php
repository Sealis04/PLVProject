<script>
        var header = document.getElementById("list");
        var btns = header.getElementsByClassName("btns");
        var profile = document.getElementById("myProfile");
        var reservation = document.getElementById("myReservation");
        var userProf= document.getElementById("userProfile");
        var userRes=document.getElementById("userReservations");
        var editCont = document.getElementById('editContents');


        var profileID = profile.id;
        var reservationID = reservation.id;
        var userProfID= userProf.id;
        var userResID=userRes.id;
        var editContID = editCont.id;

        var boolVar = true;
        callUserDetails();
        for (var i = 0; i < btns.length; i++) {
            btns[i].addEventListener("click", function() {
            var current = document.getElementsByClassName("active");
            current[0].className = current[0].className.replace(" active", "");
            this.className += " active";
            if(current[0].id == profileID){
                dropContent();
                callUserDetails();
            }else if(current[0].id == reservationID){
                dropContent();
                callReservationDetails();
            }else if(current[0].id == userProfID){
                dropContent();
                regList()
            }else if(current[0].id == userResID){
                dropContent();
                resList();
            }else if(current[0].id == editContID){
                dropContent();
                editContent();
            }
            })
        }
            function callUserDetails(){
                profile.disabled="true";
                reservation.removeAttribute("disabled");
                userProf.removeAttribute("disabled");
                userRes.removeAttribute("disabled");
                var asd = <?php echo $_SESSION["usercourse"];?>;
                var fn = "<?php echo $_SESSION["fullName"]; ?>";
                var cn = <?php echo $_SESSION["usercontactnumber"];?>;
                var email = "<?php echo $_SESSION["email"];?>";
                var pass = "<?php echo $_SESSION["password"];?>";
                var xmlhttp = new XMLHttpRequest();
                        xmlhttp.onreadystatechange = function(){
                            if(this.readyState == 4 && this.status==200){
                                profileContent(fn,this.responseText,cn,email,pass);
                            }
                        }
                        xmlhttp.open("GET", "Request_Course.php?var=" + asd, true);
                        xmlhttp.send();
            }

            function profileContent(fullname, course, contact, email, password){
            var div = document.createElement('difunctionv');
            div.id="profContent";
            div.innerHTML='<h3> Name: ' +  fullname + '</h3> <br> <h4> Course:' + course + '<h4> <br>';
            div.innerHTML += '<h4> Email:'+email+'<h4><br>';
            document.getElementById("content").appendChild(div);
            }

           
            function callReservationDetails(){
                userID = <?php echo $_SESSION["userID"]?>;
                reservation.disabled="true";
                profile.removeAttribute("disabled");
                userProf.removeAttribute("disabled");
                userRes.removeAttribute("disabled");
                var xmlhttp = new XMLHttpRequest();
                        xmlhttp.onreadystatechange = function(){
                            if(this.readyState == 4 && this.status==200){
                                var myObj = JSON.parse(this.responseText);
                                if(myObj[0] == null){
                                var motherDiv = document.createElement('div');
                                motherDiv.id="motherDiv";
                                motherDiv.innerHTML = '<h3> No reservations </h3?>';
                                document.getElementById("content").appendChild(motherDiv);
                                }else{
                                var motherDiv = document.createElement('div');
                                motherDiv.id="motherDiv";
                                myObj.forEach(function(element,index){
                                    reservationContent(motherDiv,element,index)
                                });
                                }
                            }
                        }
                        xmlhttp.open("GET", "Request_ReservationForUser.php?var="+ userID, true);
                        xmlhttp.send();
            }

            function reservationContent(motherDiv,element, index){
            var div = document.createElement('div')
            div.id = "resContent";
            div.className ="resContent"; 
            div.innerHTML = '<h3> Event:'+element.event+'</h3>';
            div.innerHTML +='<h3>Date and Time: '+element.start+" to "+element.end+" </h3><br>";
            div.innerHTML += '<input type="button" class="header-btn btn" value="Edit" onclick="cancelReservation('+element.eventID+')">';
            div.innerHTML += '<input type="button" class="header-btn btn" onclick="cancelReservation('+element.eventID+')" value="Cancel">'
            document.getElementById("content").appendChild(motherDiv);
            motherDiv.appendChild(div);
            }

            function cancelReservation(eventID){
                var xmlhttp = new XMLHttpRequest();
                        xmlhttp.onreadystatechange = function(){
                            if(this.readyState == 4 && this.status==200){
                                alert(this.responseText);
                                window.location.href = "Window_AdminPanel.php";
                            }
                        }
                        xmlhttp.open("GET", "Request_RemoveReservation.php?var="+ eventID, true);
                        xmlhttp.send();
            }

            function editReservation(eventID){
                var xmlhttp = new XMLHttpRequest();
                        xmlhttp.onreadystatechange = function(){
                            if(this.readyState == 4 && this.status==200){
                                alert(this.responseText);
                                window.location.href = "Window_AdminPanel.php";
                            }
                        }
                        xmlhttp.open("GET", "Request_EditReservation.php?var="+ eventID, true);
                        xmlhttp.send();
            }

            
            //DROP CONTENTS
             function dropContent(){
                if(document.getElementById("profContent")){
                    document.getElementById("profContent").remove();
                    console.log("di nag wowork yung 1")
                }else if(document.getElementById("motherDiv")){
                    document.getElementById("motherDiv").remove();
                    console.log("di nag wowork yung 2")
                }else if(document.getElementById("motherDiv")){
                    document.getElementById("motherDiv").remove();
                    console.log("di nag wowork yung user prof")
                }else if(document.getElementById("motherDiv")){
                    document.getElementById("motherDiv").remove();
                    console.log("di nag wowork yung user reges")
                }else if(document.getElementById('frontPanel')){
                    document.getElementById('frontPanel').remove();
                }
             }

            // USER REGISTRATION
            function regList(){
                 //must need to added
                document.getElementById("userProfile").disabled="true";
                document.getElementById("myProfile").removeAttribute("disabled");
                document.getElementById("myReservation").removeAttribute("disabled");
                document.getElementById("userReservations").removeAttribute("disabled");
                var xmlhttp = new XMLHttpRequest();
                        xmlhttp.onreadystatechange = function(){
                            if(this.readyState == 4 && this.status==200){
                                var myObj = JSON.parse(this.responseText);
                                if(myObj[0] == null){
                                var motherDiv = document.createElement('div');
                                motherDiv.className="userProfContent";
                                motherDiv.id="motherDiv";
                                motherDiv.innerHTML = '<h3> No user registration</h3?>';
                                document.getElementById("content").appendChild(motherDiv);
                                }else{
                                var motherDiv = document.createElement('div');
                                motherDiv.id="motherDiv";
                                myObj.forEach(function(element,index){
                                registrationContent(motherDiv,element,index);
                                });
                                }
                            }
                        }
                        xmlhttp.open("GET", "Request_PendingRegistrations.php", true);
                        xmlhttp.send();
            }

            function registrationContent(motherDiv,element, index){
            var div = document.createElement('div')
            div.id = "userProfContent";
            div.className ="userProfContent"; 
            div.innerHTML += '<h3> Name:'+element.firstName+'&nbsp'+element.middleName+'&nbsp'+element.lastName+'</h3>';
            div.innerHTML += '<h3> Course:'+element.course+'</h3>';
            div.innerHTML += '<input type="button" class="header-btn btn" value="Accept" onclick="AcceptRegistration('+element.user+')">';
            div.innerHTML += '<input type="button" class="header-btn btn" onclick="DeclineRegistration('+element.user+')" value="Decline">';
            document.getElementById("content").appendChild(motherDiv);
            motherDiv.appendChild(div);
            }

            // Accept Reservation

            function AcceptRegistration(user){
                var xmlhttp = new XMLHttpRequest();
                        xmlhttp.onreadystatechange = function(){
                            if(this.readyState == 4 && this.status==200){
                                alert(this.responseText);
                                window.location.href = "Window_AdminPanel.php";
                            }
                        }
                        xmlhttp.open("GET", "Request_AcceptReservation.php?var="+ user, true);
                        xmlhttp.send();
            }

            //Decline Reservation
            function DeclineRegistration(user){
                var xmlhttp = new XMLHttpRequest();
                        xmlhttp.onreadystatechange = function(){
                            if(this.readyState == 4 && this.status==200){
                                alert(this.responseText);
                                window.location.href = "Window_AdminPanel.php";
                            }
                        }
                        xmlhttp.open("GET", "Request_DeclineReservation.php?var="+ user, true);
                        xmlhttp.send();
            }
            
            //RESERVATION
            function resList(){
                document.getElementById("userReservations").disabled="true";
                document.getElementById("myProfile").removeAttribute("disabled");
                document.getElementById("myReservation").removeAttribute("disabled");
                document.getElementById("userProfile").removeAttribute("disabled");
                var xmlhttp = new XMLHttpRequest();
                        xmlhttp.onreadystatechange = function(){
                            if(this.readyState == 4 && this.status==200){
                                var myObj = JSON.parse(this.responseText);
                                if(myObj[0] == null){
                                var motherDiv = document.createElement('div');
                                motherDiv.className="userResContent";
                                motherDiv.id="motherDiv";
                                motherDiv.innerHTML = '<h3> No user reservation </h3?>';
                                document.getElementById("content").appendChild(motherDiv);
                                }else{
                                var motherDiv = document.createElement('div');
                                motherDiv.id="motherDiv";
                                myObj.forEach(function(element,index){
                                reservationContent(motherDiv,element,index);
                                });}
                            }
                        }
                        xmlhttp.open("GET", "Request_ApprovedReservation.php", true);
                        xmlhttp.send();

            }

            function reservationContent(motherDiv,element, index){
            var div = document.createElement('div')
            div.id = "userResContent";
            div.className ="userResContent"; 
            div.innerHTML = '<h3> Event:'+element.event+'</h3>';
            div.innerHTML +='<h3>Date and Time: '+element.start+" to "+element.end+" </h3><br>";
            div.innerHTML += '<input type="button" class="header-btn btn" value="Accept" onclick="AcceptReservation('+element.eventID+')">';
            div.innerHTML += '<input type="button" class="header-btn btn" onclick="DeclineReservation('+element.eventID+')" value="Decline">';
            document.getElementById("content").appendChild(motherDiv);
            motherDiv.appendChild(div);
            }

            // Accept Reservatione
            function AcceptReservation(eventID){
                var xmlhttp = new XMLHttpRequest();
                        xmlhttp.onreadystatechange = function(){
                            if(this.readyState == 4 && this.status==200){
                                alert(this.responseText);
                                window.location.href = "Window_AdminPanel.php";
                            }
                        }
                        xmlhttp.open("GET", "Request_AcceptReservation.php?var="+ eventID, true);
                        xmlhttp.send();
            }

            //Decline Reservation
            function DeclineReservation(eventID){
                var xmlhttp = new XMLHttpRequest();
                        xmlhttp.onreadystatechange = function(){
                            if(this.readyState == 4 && this.status==200){
                                alert(this.responseText);
                                window.location.href = "Window_AdminPanel.php";
                            }
                        }
                        xmlhttp.open("GET", "Request_DeclineReservation.php?var="+ eventID, true);
                        xmlhttp.send();
            }

            function editContent(){
                //equipList
                var equipLabel = document.createElement('label');
                equipLabel.textContent = 'Equipment list';
                var equipDiv = document.createElement('div');
                equipDiv.id = 'equipPanel';
                equipDiv.className = 'sidePanel';
                var equipInput = document.createElement('input');
                equipInput.id = 'dropBtn';
                equipInput.className = 'openBtn';
                equipInput.type = "button";
                equipInput.value = ">";
                equipInput.addEventListener('click',function(){
                    loadEquip("1",equipDiv)
                });
                document.getElementById("content").appendChild(equipDiv);
                equipDiv.appendChild(equipLabel);
                equipDiv.appendChild(equipInput);
                //roomList
                var roomLabel = document.createElement('label');
                roomLabel.textContent = 'Equipment list';
                var roomDiv = document.createElement('div');
                roomDiv.id = 'roomPanel';
                roomDiv.className = 'sidePanel';
                var roomInput = document.createElement('input');
                roomInput.id = 'dropBtn';
                roomInput.className = 'openBtn';
                roomInput.type = "button";
                roomInput.value = ">";
                roomInput.addEventListener('click',function(){
                    loadEquip("2",roomDiv);
                });
                document.getElementById("content").appendChild(roomDiv);
                roomDiv.appendChild(roomLabel);
                roomDiv.appendChild(roomInput);

            }

            function loadEquip(param,activeDiv){
                var div = document.createElement('div');
                div.id = "divID";
                switch(param){
                    case "1":
                        div.style.height = '100%';
                        activeDiv.appendChild(div);
                        break;
                    case "2":
                        div.style.height = '100%';
                        activeDiv.appendChild(div);
                        break;
                    default:
                        console.log(param);
                        console.log('something seems to be wrong');
                }
                // if(boolVar){
                // var subDiv =  document.getElementById('frontPanel');
                // div.style.height = '100%';
                // subDiv.appendChild(div);
                // boolVar = false;
                // }
                // else if(!boolVar){
                // boolVar = true;
                // document.getElementById('divID').remove();
                // }
            }

</script>