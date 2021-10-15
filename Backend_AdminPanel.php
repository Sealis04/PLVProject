<script>
    //public form changes




    var header = document.getElementById("list");
    var btns = header.getElementsByClassName("btns");
    var profile = document.getElementById("myProfile");
    var reservation = document.getElementById("myReservation");
    var userProf = document.getElementById("userProfile");
    var userRes = document.getElementById("userReservations");
    var editCont = document.getElementById('editContents');
    var profileID = profile.id;
    var reservationID = reservation.id;
    var userProfID = userProf.id;
    var userResID = userRes.id;
    var editContID = editCont.id;
    var equipBtn;
    var roomBtn;
    var checker = true;
    var active;
    callUserDetails();
    for (var i = 0; i < btns.length; i++) {
        btns[i].addEventListener("click", function() {
            var current = document.getElementsByClassName("active");
            current[0].className = current[0].className.replace(" active", "");
            this.className += " active";
            if (current[0].id == profileID) {
                dropContent();
                callUserDetails();
            } else if (current[0].id == reservationID) {
                dropContent();
                callReservationDetails();
            } else if (current[0].id == userProfID) {
                dropContent();
                regList()
            } else if (current[0].id == userResID) {
                dropContent();
                resList();
            } else if (current[0].id == editContID) {
                dropContent();
                editTabContent();
            }
        })
    }

    function callUserDetails() {
        profile.disabled = "true";
        reservation.removeAttribute("disabled");
        userProf.removeAttribute("disabled");
        userRes.removeAttribute("disabled");
        var asd = <?php echo $_SESSION["usercourse"]; ?>;
        var fn = "<?php echo $_SESSION["fullName"]; ?>";
        var cn = <?php echo $_SESSION["usercontactnumber"]; ?>;
        var email = "<?php echo $_SESSION["email"]; ?>";
        var pass = "<?php echo $_SESSION["password"]; ?>";
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                profileContent(fn, this.responseText, cn, email, pass);
            }
        }
        xmlhttp.open("GET", "Request_Course.php?var=" + asd, true);
        xmlhttp.send();
    }

    function profileContent(fullname, course, contact, email, password) {
        var div = document.createElement('difunctionv');
        div.id = "profContent";
        div.innerHTML = '<h3> Name: ' + fullname + '</h3> <br> <h4> Course:' + course + '<h4> <br>';
        div.innerHTML += '<h4> Email:' + email + '<h4><br>';
        document.getElementById("content").appendChild(div);
    }


    function callReservationDetails() {
        userID = <?php echo $_SESSION["userID"] ?>;
        reservation.disabled = "true";
        profile.removeAttribute("disabled");
        userProf.removeAttribute("disabled");
        userRes.removeAttribute("disabled");
        editCont.removeAttribute("disabled");
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var myObj = JSON.parse(this.responseText);
                if (myObj[0] == null) {
                    var motherDiv = document.createElement('div');
                    motherDiv.id = "currentUserReservation";
                    motherDiv.innerHTML = '<h3> No reservations </h3?>';
                    document.getElementById("content").appendChild(motherDiv);
                } else {
                    var motherDiv = document.createElement('div');
                    motherDiv.id = "currentUserReservation";
                    myObj.forEach(function(element, index) {
                        reservationContent(motherDiv, element, index)
                    });
                }
            }
        }
        xmlhttp.open("GET", "Request_ReservationForUser.php?var=" + userID, true);
        xmlhttp.send();
    }

    function reservationContent(motherDiv, element, index) {
        var div = document.createElement('div')
        div.id = "resContent";
        div.className = "resContent";
        div.innerHTML = '<h3> Event:' + element.event + '</h3>';
        div.innerHTML += '<h3>Date and Time: ' + element.start + " to " + element.end + " </h3><br>";

        //div.innerHTML += '<input type="button" class="header-btn btn" value="Edit" onclick="cancelReservation('+element.eventID+')">';
        // div.innerHTML += '<input type="button" class="header-btn btn" onclick="cancelReservation('+element.eventID+')" value="Cancel">';
        if (element.status != 1) {
            if (element.approval == 1) {
                div.innerHTML += '<h4> Status:' + "Approved" + '<h4><br>';
                div.innerHTML += '<input type="button" class="header-btn btn" onclick="cancelReservation(' + element.eventID + ')" value="Cancel">'
            } else if (element.approval == 2) {
                div.innerHTML += '<h4> Status:' + "Pending" + '<h4><br>';
                div.innerHTML += '<input type="button" class="header-btn btn" onclick="cancelReservation(' + element.eventID + ')" value="Cancel">'
            } else {
                div.innerHTML += '<h4> Status:' + "Declined" + '<h4><br>';
                div.innerHTML += '<input type="button" class="header-btn btn" onclick="cancelReservation(' + element.eventID + ')" value="Cancel" disabled>'
            }
        } else {
            div.innerHTML += '<h4> Status:' + "Cancelled" + '<h4><br>';
            div.innerHTML += '<input type="button" class="header-btn btn" onclick="cancelReservation(' + element.eventID + ')" value="Cancel" disabled>'
        }
        document.getElementById("content").appendChild(motherDiv);
        motherDiv.appendChild(div);
    }

    function cancelReservation(eventID) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                alert(this.responseText);
                window.location.href = "Window_AdminPanel.php";
            }
        }
        xmlhttp.open("GET", "Request_RemoveReservation.php?var=" + eventID, true);
        xmlhttp.send();
    }

    function editReservation(eventID) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                alert(this.responseText);
                window.location.href = "Window_AdminPanel.php";
            }
        }
        xmlhttp.open("GET", "Request_EditReservation.php?var=" + eventID, true);
        xmlhttp.send();
    }


    //DROP CONTENTS
    function dropContent() {
        if (document.getElementById("profContent")) {
            document.getElementById("profContent").remove();
        } else if (document.getElementById("regList")) {
            document.getElementById("regList").remove();
            console.log("di nag wowork yung 2")
        } else if (document.getElementById("resList")) {
            document.getElementById("resList").remove();
            console.log("di nag wowork yung user prof")
        } else if (document.getElementById("currentUserReservation")) {
            document.getElementById("currentUserReservation").remove();
            console.log("di nag wowork yung user reges")
        } else if (document.getElementById('editList')) {
            document.getElementById("editList").remove();
        }
    }

    // USER REGISTRATION
    function regList() {
        //must need to added
        document.getElementById("userProfile").disabled = "true";
        document.getElementById("myProfile").removeAttribute("disabled");
        document.getElementById("myReservation").removeAttribute("disabled");
        document.getElementById("userReservations").removeAttribute("disabled");
        editCont.removeAttribute("disabled");
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var myObj = JSON.parse(this.responseText);
                if (myObj[0] == null) {
                    var motherDiv = document.createElement('div');
                    motherDiv.className = "userProfContent";
                    motherDiv.id = "regList";
                    motherDiv.innerHTML = '<h3> No user registration</h3?>';
                    document.getElementById("content").appendChild(motherDiv);
                } else {
                    var motherDiv = document.createElement('div');
                    motherDiv.id = "regList";
                    myObj.forEach(function(element, index) {
                        registrationContent(motherDiv, element, index);
                    });
                }
            }
        }
        xmlhttp.open("GET", "Request_PendingRegistrations.php", true);
        xmlhttp.send();
    }

    function registrationContent(motherDiv, element, index) {
        var div = document.createElement('div')
        div.id = "userProfContent";
        div.className = "userProfContent";
        div.innerHTML += '<h3> Name:' + element.firstName + '&nbsp' + element.middleName + '&nbsp' + element.lastName + '</h3>';
        div.innerHTML += '<h3> Course:' + element.course + '</h3>';
        div.innerHTML += '<input type="button" class="header-btn btn" value="Accept" onclick="AcceptRegistration(' + element.user + ')">';
        div.innerHTML += '<input type="button" class="header-btn btn" onclick="DeclineRegistration(' + element.user + ')" value="Decline">';
        document.getElementById("content").appendChild(motherDiv);
        motherDiv.appendChild(div);
    }

    // Accept Reservation

    function AcceptRegistration(user) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                alert(this.responseText);
                window.location.href = "Window_AdminPanel.php";
            }
        }
        xmlhttp.open("GET", "Request_AcceptRegistration.php?var=" + user, true);
        xmlhttp.send();
    }

    //Decline Reservation
    function DeclineRegistration(user) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                alert(this.responseText);
                window.location.href = "Window_AdminPanel.php";
            }
        }
        xmlhttp.open("GET", "Request_DeclineReservation.php?var=" + user, true);
        xmlhttp.send();
    }

    //RESERVATION
    function resList() {
        document.getElementById("userReservations").disabled = "true";
        document.getElementById("myProfile").removeAttribute("disabled");
        document.getElementById("myReservation").removeAttribute("disabled");
        document.getElementById("userProfile").removeAttribute("disabled");
        editCont.removeAttribute("disabled");
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var myObj = JSON.parse(this.responseText);
                if (myObj[0] == null) {
                    var motherDiv = document.createElement('div');
                    motherDiv.className = "userResContent";
                    motherDiv.id = "resList";
                    motherDiv.innerHTML = '<h3> No user reservation </h3?>';
                    document.getElementById("content").appendChild(motherDiv);
                } else {
                    var motherDiv = document.createElement('div');
                    motherDiv.id = "resList";
                    myObj.forEach(function(element, index) {
                        userReservationContent(motherDiv, element, index);
                    });
                }
            }
        }
        xmlhttp.open("GET", "Request_ApprovedReservation.php", true);
        xmlhttp.send();

    }

    function userReservationContent(motherDiv, element, index) {
        var div = document.createElement('div')
        div.id = "userResContent";
        div.className = "userResContent";
        div.innerHTML = '<h3> Event:' + element.event + '</h3>';
        div.innerHTML += '<h3>Date and Time: ' + element.start + " to " + element.end + " </h3><br>";
        div.innerHTML += '<input type="button" class="header-btn btn" value="Accept" onclick="AcceptReservation(' + element.eventID + ')">';
        div.innerHTML += '<input type="button" class="header-btn btn" onclick="DeclineReservation(' + element.eventID + ')" value="Decline">';
        document.getElementById("content").appendChild(motherDiv);
        motherDiv.appendChild(div);
    }

    // Accept Reservatione
    function AcceptReservation(eventID) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                alert(this.responseText);
                window.location.href = "Window_AdminPanel.php";
            }
        }
        xmlhttp.open("GET", "Request_AcceptReservation.php?var=" + eventID, true);
        xmlhttp.send();
    }

    //Decline Reservation
    function DeclineReservation(eventID) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                alert(this.responseText);
                window.location.href = "Window_AdminPanel.php";
            }
        }
        xmlhttp.open("GET", "Request_DeclineReservation.php?var=" + eventID, true);
        xmlhttp.send();
    }

    function editTabContent() {
        active = false;
         equipBtn = true;
         roomBtn = true;
        document.getElementById("userReservations").removeAttribute('disabled');
        document.getElementById("myProfile").removeAttribute("disabled");
        document.getElementById("myReservation").removeAttribute("disabled");
        document.getElementById("userProfile").removeAttribute("disabled");
        editCont.disabled = true;
        var motherDiv = document.createElement('div');
        motherDiv.id = "editList";
        document.getElementById('content').appendChild(motherDiv);
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
        equipInput.addEventListener('click', function() {
            loadLists("1", equipDiv)
        });
        motherDiv.appendChild(equipDiv);
        equipDiv.appendChild(equipLabel);
        equipDiv.appendChild(equipInput);
        //roomList
        var roomLabel = document.createElement('label');
        roomLabel.textContent = 'Room list';
        var roomDiv = document.createElement('div');
        roomDiv.id = 'roomPanel';
        roomDiv.className = 'sidePanel';
        var roomInput = document.createElement('input');
        roomInput.id = 'dropBtn';
        roomInput.className = 'openBtn';
        roomInput.type = "button";
        roomInput.value = ">";
        roomInput.addEventListener('click', function() {
            loadLists("2", roomDiv);
        });
        motherDiv.appendChild(roomDiv);
        roomDiv.appendChild(roomLabel);
        roomDiv.appendChild(roomInput);

        //policiesList
        var policiesList = document.createElement('label');
        policiesList.textContent = 'Policies';
        var polDiv = document.createElement('div');
        polDiv.id = 'polPanel';
        polDiv.className ='sidePanel';
        var polInput = document.createElement('input');
        polInput.id = 'dropBtn';
        polInput.className = 'openBtn';
        polInput.type = 'button';
        polInput.value = '>';
        motherDiv.appendChild(polDiv);
        polDiv.appendChild(policiesList);
        polDiv.appendChild(polInput);
    }



    function loadLists(param, activeDiv) {

        var div = document.createElement('div');
        div.id = "divID";
        var table = document.createElement('table');
        table.style = 'border:1px solid black';
        var row1 = document.createElement('tr');
        var column1 = document.createElement('td');
        var column2 = document.createElement('td');
        var column3 = document.createElement('td');
        var column4 = document.createElement('td');
        var column5 = document.createElement('td');
        row1.style = 'border:1px solid black';
        column1.style = 'border:1px solid black';
        column2.style = 'border:1px solid black';
        column3.style = 'border:1px solid black';
        column4.style = 'border:1px solid black';
        column5.style = 'border:1px solid black';
        column5.textContent = "Edit/Remove";
        table.appendChild(row1);
        div.className = 'mainDiv_edit'
        switch (param) {
            case "1":
                if (equipBtn) {
                    div.id = "equipID";
                    div.style.height = '50%';
                    table.id = "equipmentTbl";
                    activeDiv.appendChild(div);
                    column1.textContent = "Equipment Name";
                    column2.textContent = "Equipment Quantity";
                    column3.textContent = "Equipment Description";
                    column4.textContent = "Equipment Availability";
                    div.append(table);
                    equipBtn = false;
                    listEquip(table, div.id)
                    turnOffOn(div);
                    active = true;
                } else {
                    equipBtn = true;
                    document.getElementById('equipID').remove();
                    active = false;
                }
                break;
            case "2":
                if (roomBtn) {
                    div.id = "roomID";
                    div.style.height = '50%';
                    table.id = "roomTbl";
                    activeDiv.appendChild(div);
                    column1.textContent = "Room Name";
                    column2.textContent = "Room Capacity"
                    column3.textContent = "Room Description";
                    column4.textContent = "Room Availability";
                    div.append(table);
                    roomBtn = false;
                    listRoom(table, div.id);
                    turnOffOn(div);
                    active = true;
                } else {
                    roomBtn = true;
                    document.getElementById('roomID').remove();
                    active = false;
                }
                break;
            default:
                console.log(param);
                console.log('something seems to be wrong');
        }
        row1.appendChild(column1);
        row1.appendChild(column2);
        row1.appendChild(column3);
        row1.appendChild(column4);
        row1.appendChild(column5);
        //Logic to close other tabs when user presses another tab
      

        
        // if(typeof(form) != 'undefined' && form != null){
        //     var form = document.getElementById('myForm');
        //     //form updated
        //     var saving = false;
        //     form.onsubmit = function(){saving = true;};

        //     //form not saved warning
        //     //Unload doesn't seem to be working, study how it works
        //     // window.onunload = function(){
        //     //     if(!saving){
        //     //         console.log(asd);
        //     //         var f = checkIfFormChange(form);
        //     //         if(f.length > 0) alert("Form updates have not been saved");
        //     //     }
        //     // };
        //     window.unload = function(){
        //         alert('woops');

        //     }



        //         window.addEventListener("unload",function(e){
        //                 e.returnValue = ("Form update have not been saved, Leave?");
        //             })


        //     }
    }

    function turnOffOn(div){
        if (active) {
            if (div.id == 'equipID') {
                roomBtn = true;
                document.getElementById('roomID').remove();
            } else if (div.id == 'roomID') {
                equipBtn = true;
                document.getElementById('equipID').remove();
            }
        }
    }
    function listEquip(mainDiv, type) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var myObj = JSON.parse(this.responseText);
                myObj.forEach(function(element, index) {
                    generateTabContent(mainDiv, type, element, index)
                });
                addButton(type);
            }
        }
        xmlhttp.open("GET", "Request_EquipmentList.php", true);
        xmlhttp.send();
    }

    function listRoom(mainDiv, type) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var myObj = JSON.parse(this.responseText);
                myObj.forEach(function(element, index) {
                    generateTabContent(mainDiv, type, element, index);

                });
                addButton(type);
            }
        }
        xmlhttp.open("GET", "Request_RoomList.php", true);
        xmlhttp.send();
    }

    //Called by function that lists all Equipment (should be a foreach kinda thing)
    function generateTabContent(mainDiv, type, element, index) {
        var tr = document.createElement('tr');
        tr.id = index;
        mainDiv.appendChild(tr);
        var tdName = document.createElement('td');
        var inputName = document.createElement('input');
        inputName.disabled = true;
        inputName.id = 'contentName';
        tdName.appendChild(inputName);


        var tdQuantity = document.createElement('td');
        var inputQuantity = document.createElement('input');
        inputQuantity.id = 'contentQuantity';
        tdQuantity.appendChild(inputQuantity);
        inputQuantity.disabled = true;

        var tdDesc = document.createElement('td');
        var inputDesc = document.createElement('input');
        inputDesc.disabled = true;
        inputDesc.id = 'contentDesc';
        tdDesc.appendChild(inputDesc);

        var tdAvailability = document.createElement('td');
        var checkbox = document.createElement('input');
        checkbox.type = 'checkbox';
        checkbox.id = 'availabilityCB';
        checkbox.disabled = true;
        if (element.roomAvailability == 0 || element.equipAvailability == 0) {
            checkbox.checked = true;
        } else {
            checkbox.checked = false;
        }
        tdAvailability.appendChild(checkbox);


        var tdRemove = document.createElement('td');
        var editBtn = document.createElement('input');
        editBtn.type = 'button';
        editBtn.value = "Edit";
        editBtn.className = 'editButton';
        if (type == 'roomID') {
            editBtn.addEventListener('click', function() {
                editContent(type, tr, this, element.roomID);
            });
        } else if (type == 'equipID') {
            editBtn.addEventListener('click', function() {
                editContent(type, tr, this, element.equipID);
            });
        }

        var removeBtn = document.createElement('input');
        removeBtn.type = 'button';
        removeBtn.value = "Remove";
        removeBtn.addEventListener('click', function() {
            removeContent(type, tr);
        });
        tdRemove.appendChild(editBtn);
        tdRemove.appendChild(removeBtn);

        tr.appendChild(tdName);

        switch (type) {
            case 'roomID':
                inputName.value = element.roomName;
                inputDesc.value = element.roomDesc;
                inputQuantity.value = element.roomCap;
                break;
            case 'equipID':
                inputQuantity.value = element.equipQty;
                inputName.value = element.equipName;
                inputDesc.value = element.equipDesc;
                break;
        }
        tr.appendChild(tdQuantity)
        tr.appendChild(tdDesc);
        tr.appendChild(tdAvailability);
        tr.appendChild(tdRemove);




        //appending of element
    }

    function editContent(type, rowID, value, ID) {
        var name = rowID.children[0].firstChild;
        name.disabled = false;

        var quantity = rowID.children[1].firstChild;
        var desc = rowID.children[2].firstChild;
        var availability = rowID.children[3].firstChild;
        if (checker == true) {
            name.disabled = false;
            desc.disabled = false;
            availability.disabled = false;
            if (typeof(quantity) != undefined && quantity != null) {
                quantity.disabled = false;
            }
            disableButtons(value);
            checker = false;
        } else if (checker == false) {
            name.disabled = true;
            desc.disabled = true;
            availability.disabled = true;
            if (typeof(quantity) != undefined && quantity != null) {
                quantity.disabled = true;
            }
            enableButtons(value);
            if (type == 'roomID') {
                editRoomQuery(name.value, quantity.value, desc.value, availability.checked, ID);
            } else if (type == 'equipID') {
                editEquipQuery(name.value, quantity.value, desc.value, availability.checked, ID);
            }
            checker = true;
        }

    }

    function disableButtons(value) {
        var x = document.querySelectorAll('.editButton');

        for (a = 0; a < x.length; a++) {
            if (value != x[a]) {
                x[a].disabled = true;
            }
        }

    }

    function enableButtons(value) {
        var x = document.querySelectorAll('.editButton');

        for (a = 0; a < x.length; a++) {
            x[a].disabled = false;
        }

    }

    function editEquipQuery(name, quantity, desc, availability, ID) {
        var eAvailability;
        if (availability) {
            eAvailability = 0;
        } else if (!availability) {
            eAvailability = 1;
        }
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText);
            }
        }
        xmlhttp.open("GET", "Request_EditEquipList.php?name=" + name + '&quantity=' + quantity + '&desc=' + desc + '&availability=' + eAvailability + '&id=' + ID, true);
        xmlhttp.send();
    }

    function editRoomQuery(name, capacity, desc, availability, ID) {
        var eAvailability;
        if (availability) {
            eAvailability = 0;
        } else if (!availability) {
            eAvailability = 1;
        }
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText);
            }
        }
        xmlhttp.open("GET", "Request_EditRoomList.php?name=" + name + '&cap=' + capacity + '&desc=' + desc + '&availability=' + eAvailability + '&id=' + ID, true);
        xmlhttp.send();
    }

    function removeContent(type) {

    }

    //Added at the end once everything is rendered
    function addButton(type) {
        if (type == 'roomID') {
            var mainDiv = document.getElementById('roomID');
        } else if (type == 'equipID') {
            var mainDiv = document.getElementById('equipID');
        }
        var botDiv = document.createElement('div');
        //bottomDiv elements
        botDiv.className = "bottom";
        var botInput = document.createElement('input');
        botInput.type = 'submit';
        botInput.value = "Add Equipment";
        botDiv.appendChild(botInput);
        mainDiv.appendChild(botDiv);
    }
</script>