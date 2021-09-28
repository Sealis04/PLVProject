<script>         
            var header = document.getElementById("list");
            var btns = header.getElementsByClassName("btns");
            var x = <?php echo $_SESSION["userID"]?>;
            callUserDetails();
             for (var i = 0; i < btns.length; i++) {
                        btns[i].addEventListener("click", function() {
                        var current = document.getElementsByClassName("active");
                        current[0].className = current[0].className.replace(" active", "");
                        this.className += " active";
                        var profileID = document.getElementById("myProfile").id;
                        var reservationID = document.getElementById("myReservation").id;
                        if(current[0].id == profileID){                    
                            dropContent();
                            callUserDetails();
                        }else if(current[0].id == reservationID){
                            dropContent();
                            callReservationDetails();
                        }else{
                            alert("something went wrong");
                        }
                        });
                    }
                    
            function callUserDetails(){
                document.getElementById("myProfile").disabled="true";
                document.getElementById("myReservation").removeAttribute("disabled");
                var course = <?php echo $_SESSION["usercourse"];?>;
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
                        xmlhttp.open("GET", "getUserDetails.php?var=" + course, true);
                        xmlhttp.send();
            }

            function profileContent(fullname, course, contact, email, password){
            var div = document.createElement('div');
            div.id="profile";
            div.innerHTML='<h3> Name: ' +  fullname + '</h3> <br> <h4> Course:' + course + '<h4> <br>';
            div.innerHTML += '<h4> Email:'+email+'<h4><br>';
            document.getElementById("content").appendChild(div);
            }

            function callReservationDetails(){
                userID = <?php echo $_SESSION["userID"]?>;
                document.getElementById("myReservation").disabled="true";
                document.getElementById("myProfile").removeAttribute("disabled");
                var xmlhttp = new XMLHttpRequest();
                        xmlhttp.onreadystatechange = function(){
                            if(this.readyState == 4 && this.status==200){
                                var myObj = JSON.parse(this.responseText);
                                if(myObj[0] == null){
                                var motherDiv = document.createElement('div');
                                motherDiv.className="reservation";
                                motherDiv.id="motherDiv";
                                motherDiv.innerHTML = '<h3> No reservations </h3?>';
                                document.getElementById("content").appendChild(motherDiv);
                                }else{
                                var motherDiv = document.createElement('div');
                                motherDiv.id = "motherDiv";
                                myObj.forEach(function(element,index){
                                    reservationContent(motherDiv,element,index);
                                });
                                }
                            }
                        }
                        xmlhttp.open("GET", "getReservationForUser.php?var="+ userID, true);
                        xmlhttp.send();
            }

            function reservationContent(motherDiv,element, index){
            var div = document.createElement('div')
            div.className ="reservation"; 
            div.innerHTML = '<h3> Event:'+element.event+'</h3>';
            div.innerHTML +='<h3>Date and Time: '+element.start+" to "+element.end+" </h3><br>";
            div.innerHTML += '<input type="button" class="header-btn btn" value="Edit" onclick="editReservation('+element.eventID+')">';
            div.innerHTML += '<input type="button" class="header-btn btn" onclick="cancelReservation('+element.eventID+')" value="Cancel">'
            document.getElementById("content").appendChild(motherDiv);
            motherDiv.appendChild(div);
            }

            function cancelReservation(eventID){
                var xmlhttp = new XMLHttpRequest();
                        xmlhttp.onreadystatechange = function(){
                            if(this.readyState == 4 && this.status==200){
                                alert(this.responseText);
                                window.location.href = "UserPanel.php";
                            }
                        }
                        xmlhttp.open("GET", "removeReservation.php?var="+ eventID, true);
                        xmlhttp.send();
            }

            function editReservation(eventID){
                console.log("Under construction");
            //     var xmlhttp = new XMLHttpRequest();
            //             xmlhttp.onreadystatechange = function(){
            //                 if(this.readyState == 4 && this.status==200){
            //                     alert(this.responseText);
            //                     window.location.href = "UserPanel.php";
            //                 }
            //             }
            //             xmlhttp.open("GET", "editReservation.php?var="+ eventID, true);
            //             xmlhttp.send();
            // 
            }

            function dropContent(){
                if(document.getElementById("motherDiv")){
                            document.getElementById("motherDiv").remove();
                }else if(document.getElementById("profile")){
                    document.getElementById("profile").remove();
                }else{
                }
            }
</script>