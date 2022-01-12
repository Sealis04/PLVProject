<script type="text/javascript" src="Backend_Modal.php"></script>
<script type="text/javascript">
    //public form changes
    var isAdmin = <?php echo isset($_SESSION['isAdmin']) ? $_SESSION['isAdmin'] : NULL ?>;
    var equipBtn;
    var roomBtn;
    var policiesBtn;
    var userBtn;
    var checker = true;
    var active;
    var isClicked;
    var activeID;
    var userResClick;
    var check;
    var pending;
    var finished;
    var url = window.location.href;
    var url_string = new URL(url);
    var c = url_string.searchParams.get('page');
    var category = url_string.searchParams.get('category');
    var windowType = url_string.searchParams.get('window');
    var page_number;
    loadStuff(category, windowType)

    function createModal(text, func) {
        modalBody = document.createElement('div');
        modalBody.className = 'modalConfirm shadow p-3 mb-5 bg-white rounded';  
        modalMessage = document.createElement('h4');
        modalMessage.textContent = text;
        modalConfirm = document.createElement('input');
        modalConfirm.type = 'button';
        modalConfirm.value = "Confirm";
        modalConfirm.className = "header-btn btn g-confirm";
        modalCancel = document.createElement('input');
        modalCancel.type = 'button';
        modalCancel.value = "Cancel";
        modalCancel.className = "header-btn btn decline g-decline";
        modalBody.appendChild(modalMessage);
        modalBody.appendChild(modalConfirm);
        modalBody.appendChild(modalCancel);
        modalConfirm.addEventListener('click', function(e) {
            modalBody.remove();
            func();
        });
        modalCancel.addEventListener('click', function(e) {
            modalBody.remove();
            return true;
        });
        document.body.appendChild(modalBody);

    }

    function loadStuff(categ, windowType) {
        if (c == null) {
            if (isAdmin == 0) {
                if (windowType == "Profile") {
                    callUserDetails();
                } else if (windowType == "MyReservations") {
                    userReservationDetails();
                }
            } else {
                if (windowType == "Profile") {
                    callUserDetails();
                } else if (windowType == "MyReservations") {
                    userReservationDetails();
                } else if (windowType == "UserRegistrations") {
                    regList();
                } else if (windowType == "UserReservation") {
                    resList('pending');
                } else if (windowType == "ContentEdit") {
                    if (categ == null) {
                        editTabContent();
                    } else {
                        if (categ == 'equipment') {
                            editTabContent();
                            loadLists('1', document.getElementById('equipPanel'))
                        } else if (categ == 'room') {
                            editTabContent();
                            loadLists('2', document.getElementById('roomPanel'));
                        } else if (categ == 'policies') {
                            editTabContent();
                            loadLists('3', document.getElementById('polPanel'))
                        } else if (categ == 'userList') {
                            editTabContent();
                            loadLists('4', document.getElementById('userPanel'))
                        }
                    }

                } else if (windowType == "Monitoring") {
                    monitoringContent();
                } else if (windowType == 'Archives') {
                    resList('archives');
                }
            }
        } else {
            if (isAdmin == 0) {
                if (windowType == "Profile") {
                    callUserDetails();
                } else if (windowType == "MyReservations") {
                    userReservationDetails(c);
                }
            } else {
                if (windowType == "Profile") {
                    callUserDetails();
                } else if (windowType == "MyReservations") {
                    userReservationDetails(c);
                } else if (windowType == "UserRegistrations") {
                    regList(c);
                } else if (windowType == "UserReservation") {
                    resList('pending', c);
                } else if (windowType == "ContentEdit") {
                    if (categ == null) {
                        editTabContent();
                    } else {
                        if (categ == 'equipment') {
                            editTabContent();
                            loadLists('1', document.getElementById('equipPanel'), c)
                        } else if (categ == 'room') {
                            editTabContent();
                            loadLists('2', document.getElementById('roomPanel'), c)
                        } else if (categ == 'policies') {
                            editTabContent();
                            loadLists('3', document.getElementById('polPanel'), c)
                        } else if (categ == 'userList') {
                            editTabContent();
                            loadLists('4', document.getElementById('userPanel'), c)
                        }
                    }
                } else if (windowType == "Monitoring") {
                    monitoringContent(c);
                } else if (windowType == 'Archives') {
                    resList('archives', c);
                }
            }
        }

    }

    //Regular Functions
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

    function loadImages(mainDiv, path) {
        var click = false;
        var flipped = false;
        //    modal img code
        var i = 0;
        var div = document.createElement('div');
        div.className = 'modalImage';
        var img = document.createElement('img');
        img.className = "myImg";
        img.src = '/' + path[0];
        img.id = 'container';
        var modal = document.createElement('div');
        modal.id = 'myModal';
        modal.className = 'modal';
        var span = document.createElement('span');
        span.className = 'close';
        span.textContent = 'X';
        var modalImg = document.createElement('img');
        modalImg.id = 'modal-content';
        var boxClicked = false;
        var modalDiv = document.createElement('div');
        var angle = 0;
        var manipulateDiv = document.createElement('div');
        manipulateDiv.className = 'moveModal';
        //Manipulate modalImgelements
        var rotate = document.createElement('img');
        rotate.className = 'rotate modalEdit';
        rotate.src = 'assets/rotate.png';
        rotate.addEventListener('click', function(e) {
            angle = (angle + 90) % 360;
            modalImg.className = " rotate" + angle;
            click = false;
            flipped = false;
        });
        var flip = document.createElement('img');
        flip.className = 'rotate modalEdit';
        flip.src = 'assets/flip.png';
        flip.addEventListener('click', function(e) {
            if (flipped == false) {
                modalImg.className += ' flipped';
                flipped = true;
            } else {
                modalImg.classList.remove('flipped');
                flipped = false;
            }
        });
        document.addEventListener('click', function(e) {
            if (e.target && e.target == img) {
                e.stopPropagation();
                modal.style.display = "block";
                modalImg.src = e.target.src;
                if (!boxClicked) {
                    document.addEventListener('click', function(event) {
                        if (event.target == modal) {
                            boxClicked = false;
                            modal.style.display = 'none'
                            modalImg.classname = ' ';
                            click = false;
                            flipped = false;
                            var i = 0;
                        };
                        if (event.target == modalImg) {
                            if (!click) {
                                click = true;
                                modalImg.classList.remove('zoomedIn');
                                modalImg.className += ' zoomedOut';
                            } else {
                                click = false;
                                modalImg.classList.remove('zoomedOut');
                            }
                        }
                    })
                }
                boxClicked = true;
            }
        });
        manipulateDiv.appendChild(span);
        manipulateDiv.appendChild(rotate);
        manipulateDiv.appendChild(flip)
        modalDiv.appendChild(modalImg);
        modal.appendChild(modalDiv);
        modal.appendChild(manipulateDiv)
        //Previous/next image
        if (path.length > 1) {
            var prev = document.createElement('span');
            prev.className = 'left';
            var next = document.createElement('span');
            next.className = 'right';
            prev.textContent = '<';
            next.textContent = '>';
            prev.addEventListener('click', function() {
                modalImg.className = '';
                angle = 0;
                i--;
                if (i < 0) i = path.length - 1;
                modalImg.src = path[i];
            })
            next.addEventListener('click', function() {
                modalImg.className = '';
                angle = 0;
                i++;
                if (i == path.length) i = 0;
                modalImg.src = path[i];
            })
            manipulateDiv.appendChild(prev);
            manipulateDiv.appendChild(next);
        }
        //      rotation stuff
        //   var rotateLeft = document.createElement('span');
        //   span.className = 'rotateLeft';
        //   var rotateRight = document.createElement('span');
        //   span.className = 'rotateRight';
        //   modal.appendChild(rotateLeft);
        //   modal.appendChild(rotateRight);
        // When the user clicks on <span> (x), close the modal3
        span.addEventListener('click', function() {
            modal.style.display = "none";
            modalImg.classname = ' ';
            click = false;
            flipped = false;
        })
        div.appendChild(img);
        div.appendChild(modal);
        mainDiv.appendChild(div);
    }

    function disableAndRemove() {
        if (c != null) {
            var newURL = "/Window_Panel.php";
            window.history.replaceState({}, document.title, "" + newURL);
        }
    }
    //Asynchronous Functions
    function callUserDetails() {
        var asd = <?php echo $_SESSION["usercourse"]; ?>;
        var section = <?php echo isset($_SESSION['userSection']) ? $_SESSION['userSection'] : 'null'; ?>;
        var userID = <?php echo $_SESSION["userID"]; ?>;

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var myObj = JSON.parse(this.responseText);
                profileContent(myObj.coursename, myObj.sectionname, myObj.isApproved, myObj.remarks, myObj.isMarked);

            }
        }
        xmlhttp.open("GET", "/Request_Course.php?var=" + asd + '&section=' + section + '&userID=' + userID, true);
        xmlhttp.send();
    }

    function userReservationDetails(page_number = 1) {
        var mainDiv = document.createElement('div');
        mainDiv.id = 'parentDiv';
        var page = document.createElement('div');
        page.id = 'pages';
        filterPart(mainDiv, page, 'userres');
        callReservationDetails(mainDiv, page, page_number);
        document.getElementById('content').appendChild(mainDiv);
    }

    function callReservationDetails(mainDiv, page, page_number = 1, month = new Date().getMonth() + 1, year = new Date().getFullYear()) {
        userID = <?php echo $_SESSION["userID"] ?>;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var myObj = JSON.parse(this.responseText);
                console.log(myObj);
                var motherDiv = document.createElement('div');
                motherDiv.id = "currentUserReservation";
                if (myObj[0] == null) {
                    if (page_number == 1) {
                        motherDiv.innerHTML += '<h3> No reservations </h3?>';
                    } else {
                        page_number -= 1;
                        callReservationDetails(page_number, month, year);
                    }
                } else {
                    var x = [];
                    console.log(myObj);
                    var list = document.createElement('li');
                    myObj.forEach(function(element, index) {
                        let result = reservationContent(motherDiv, userID, page, element, index);
                        reservedEquipment(element.reservationID, result[1], userID, true, element.status, status, ...Array(1), element.notifID, element.notif_remark, element.dateStart, element.timeStart, element.decision, element.event);
                        motherDiv.appendChild(result[2]);
                    });
                    page.innerHTML = myObj[myObj.length - 1].pagination;
                    motherDiv.appendChild(page);
                }
                mainDiv.appendChild(motherDiv);
            }
        }
        xmlhttp.open("GET", "/Request_ReservationForUser.php?var=" + userID + '&page=' + page_number + '&window=' + windowType + '&month=' + month + '&year=' + year, true);
        xmlhttp.send();
    }

    function reservedEquipment(resID, mainDiv, userID, forUser, status, approval, typePending, notifID, remarks, date, time, decision, eventName) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = async function() {
            if (this.readyState == 4 && this.status == 200) {
                var myObj = JSON.parse(this.responseText);
                var recordedDate = new Date(date + ' ' + time);
                var list = document.createElement('div');
                if (myObj.length == 0) {
                    mainDiv.innerHTML += '<h3> No Equipment Borrowed </h3>';
                } else {
                    mainDiv.innerHTML += '<h3> Equipment Borrowed: </h3>';
                    myObj.forEach(function(element, index) {
                        listEquipmentReserved(mainDiv, element, index);
                    });
                }
                var printingPanel = "'/Backend_printingPanel.php?id=" + resID + "'";
                if (forUser) {
                    if (status != 1) {
                        if (approval == 2) {
                            mainDiv.innerHTML += '<h4 class="pending"> Status:' + "Pending" + '</h4>';
                            mainDiv.innerHTML += '<br>';
                            mainDiv.innerHTML += '<input class="header-btn btn" type="button" value="Print" onclick="openNewTab(' + printingPanel + ')"> ';
                            mainDiv.innerHTML += '<input type="button" class="decline header-btn btn" onclick="' + 'createModal(' + "'Confirm cancellation of " + eventName + "?'" + ', function(){cancelReservation(' + resID + ',' + "'MyReservations'" + ')})' + '"' + 'value="Cancel">';
                            mainDiv.innerHTML += '<hr class="hr">';
                        } else if (approval == 3) {
                            mainDiv.innerHTML += '<h4 class="declined"> Status:' + "Declined" + '</h4>';
                            mainDiv.innerHTML += '<h4>Remarks: ' + remarks + '</h4>';
                            mainDiv.innerHTML += '<input class="header-btn btn" type="button" value="Print" onclick="openNewTab(' + printingPanel + ')"> ';
                            mainDiv.innerHTML += '<hr class="hr">';
                        } else if (approval == 1) {
                            mainDiv.innerHTML += '<h4 class="accepted"> Status:' + "Accepted" + '</h4>';
                            mainDiv.innerHTML += '<input class="header-btn btn" type="button" value="Print" onclick="openNewTab(' + printingPanel + ')"> ';
                            if (new Date() >= new Date(recordedDate.setDate(recordedDate.getDate() - 1))) {
                                mainDiv.innerHTML += '<input type="button" class="decline header-btn btn" onclick="' + 'createModal(' + "'Confirm cancellation of " + eventName + "?'" + ', function(){cancelReservation(' + resID + ',' + "'MyReservations'" + ')})' + '"' + 'value="Cancel" disabled>';
                            } else {
                                mainDiv.innerHTML += '<input type="button" class="decline header-btn btn" onclick="' + 'createModal(' + "'Confirm cancellation of " + eventName + "?'" + ', function(){cancelReservation(' + resID + ',' + "'MyReservations'" + ')})' + '"' + 'value="Cancel">';
                            }
                            mainDiv.innerHTML += '<hr class="hr">';
                        } else {
                            mainDiv.innerHTML += '<h4 class="accepted"> Status:' + "Reservation is Over" + '</h4>';
                            mainDiv.innerHTML += '<input class="header-btn btn" type="button" value="Print" onclick="openNewTab(' + printingPanel + ')"> ';
                        }
                    } else {
                        if (decision == 4) {
                            mainDiv.innerHTML += '<h4 class="cancelled"> Status:' + "Cancelled" + '</h4>';
                            mainDiv.innerHTML += '<h4>Remarks: ' + remarks + '</h4>';
                            mainDiv.innerHTML += '<hr class="hr">';
                        } else {
                            mainDiv.innerHTML += '<h4 class="cancelled"> Status:' + "Cancelled" + '</h4>';
                            mainDiv.innerHTML += '<hr class="hr">';
                        }
                    }
                }
                if (typePending) {
                    var textarea = document.createElement('textarea');
                    textarea.className = 'remarks';
                    textarea.placeholder = "Remarks";
                    textarea.id = 'remarks' + resID;
                    if (approval == 1) {
                        mainDiv.innerHTML += '<h4 class="accepted"> Status:' + "Accepted" + '</h4>';
                        mainDiv.innerHTML += '<br>';
                        mainDiv.appendChild(textarea);
                        mainDiv.innerHTML += '<br><br><input type="button" class="decline header-btn btn" onclick="' + 'createModal(' + "'Confirm cancellation of " + eventName + "?'" + ', function(){cancelreservationforadmin(' + resID + ',' + userID + ',' + notifID + ')})" value="Cancel">';
                    } else {
                        mainDiv.innerHTML += '<h4 class="pending"> Status:' + "Pending" + '</h4>';
                        mainDiv.innerHTML += '<br>';
                        mainDiv.appendChild(textarea);
                        mainDiv.innerHTML += '<br><br><input type="button" class = "header-btn btn" value = "Accept" onclick="' + 'createModal(' + "'Confirm Accept of " + eventName + "?'" + ', function(){AcceptReservation(' + resID + ',' + userID + ',' + notifID + ')})">'
                        mainDiv.innerHTML += '<input type="button" class ="header-btn btn decline" value = "Decline" onclick="' + 'createModal(' + "'Confirm Decline of " + eventName + "?'" + ', function(){DeclineReservation(' + resID + ',' + userID + ',' + notifID + ')})"">'

                    }
                    mainDiv.innerHTML += '<input class="header-btn btn" type="button" value="Print" onclick="openNewTab(' + printingPanel + ')"> ';
                    mainDiv.innerHTML += '<hr class="hr">'
                }
                callReservationImage(mainDiv, resID);
            }
        }
        xmlhttp.open("GET", "/Request_ReservationForUserEquipment.php?var=" + resID, true);
        xmlhttp.send();
    }

    function openNewTab(url) {
        window.open(url, '_blank').focus();
    }

    function callRegistrationImage(mainDiv, userID) {
        return new Promise(resolve => {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var myObj = JSON.parse(this.responseText);
                    var imgArray = Object.values(myObj);
                    loadImages(mainDiv, imgArray);
                    resolve('success');
                }
            }
            xmlhttp.open("GET", "/Request_imgForRegistration.php?userID=" + userID, true);
            xmlhttp.send();
        })
    }

    function callReservationImage(mainDiv, r_ID) {
        return new Promise(resolve => {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var myObj = JSON.parse(this.responseText);
                    var imgArray = Object.values(myObj);
                    loadImages(mainDiv, imgArray);
                    resolve(imgArray);
                }
            }
            xmlhttp.open("GET", "/Request_imgForReservation.php?r_ID=" + r_ID, true);
            xmlhttp.send();
        })
    }

    function cancelReservation(eventID, type) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                modal(this.responseText, function() {
                    if (c == null) {
                        window.location.href = '/Window_Panel.php?window=' + type;
                    } else {
                        window.location.href = '/Window_Panel.php?window=' + type + '&page=' + c + '&category=user'
                    }
                })
            }
        }
        xmlhttp.open("GET", "/Request_RemoveReservation.php?var=" + eventID, true);
        xmlhttp.send();
    }

    function editReservation(eventID) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                modal(this.responseText, function() {
                    callReservationDetails();
                })
            }
        }
        xmlhttp.open("GET", "/Request_EditReservation.php?var=" + eventID, true);
        xmlhttp.send();
    }
    // USER REGISTRATION
    function regList(page_number = 1) {
        //must need to added
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
                    var page = document.createElement('div');
                    page.id = 'pages';
                    motherDiv.id = "regList";
                    myObj.forEach(function(element, index) {
                        registrationContent(motherDiv, page, element, index);
                    });
                }
            }
        }
        xmlhttp.open("GET", "/Request_PendingRegistrations.php?page=" + page_number, true);
        xmlhttp.send();
    }

    // Accept Reservation

    function AcceptRegistration(user, remarks) {
        var remarks = document.getElementById('remarks').value;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                modal(this.responseText, function() {
                    if (c == null) {
                        window.location.href = '/Window_Panel.php?window=UserRegistrations';
                    } else {
                        window.location.href = '/Window_Panel.php?window=UserRegistrations&page=' + c + '&category=registration'
                    }
                    // regList();
                })
            }
        }
        xmlhttp.open("GET", "/Request_AcceptRegistration.php?var=" + user + "&remarks=" + remarks, true);
        xmlhttp.send();
    }

    //Decline Reservation
    function DeclineRegistration(user, remarks) {
        //   var remarks = document.getElementById('remarks').value;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                modal(this.responseText, function() {
                    if (c == null) {
                        window.location.href = '/Window_Panel.php?window=UserRegistrations';
                    } else {
                        window.location.href = '/Window_Panel.php?window=UserRegistrations&page=' + c + '&category=registration'
                    }
                })
            }
        }
        xmlhttp.open("GET", "/Request_DeclineRegistration.php?var=" + user + "&remarks=" + remarks, true);
        xmlhttp.send();
    }



    function loadPendingReservation(bigDiv, page, page_number = 1) {
        var motherDiv = document.createElement('div');
        motherDiv.className = "userResContent";
        motherDiv.id = "resList";
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var myObj = JSON.parse(this.responseText);
                if (myObj[0] == null) {
                    if (page_number == 1) {
                        motherDiv.innerHTML = '<h3> No user reservation </h3?>';
                    } else {
                        page_number -= 1;
                        resList('pending', page_number);
                    }
                } else {
                    myObj.forEach(function(element, index) {
                        var x = userReservationContent(motherDiv, page, element, index, );
                        reservedEquipment(element.reservationID, x[2], element.userID, false, ...Array(1), element.approval, true, element.notifID, ...Array(4), element.event);
                        motherDiv.appendChild(x[0]);
                    });
                }

            }
        }
        xmlhttp.open("GET", "/Request_unapprovedReservation.php?page=" + page_number, true);
        xmlhttp.send();
        bigDiv.appendChild(motherDiv);
    }
    // Accept Reservations
    function AcceptReservation(eventID, userID, notifID, textArea) {
        var textArea = document.getElementById('remarks' + eventID).value;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                modal(this.responseText, function() {
                    if (c == null) {
                        window.location.href = '/Window_Panel.php?window=UserReservation';
                    } else {
                        window.location.href = '/Window_Panel.php?window=UserReservation&page=' + c + '&category=pending';
                    }
                })
            }
        }
        xmlhttp.open("GET", "/Request_AcceptReservation.php?var=" + eventID + '&userID=' + userID + '&remarks=' + textArea + '&notifID=' + notifID, true);
        xmlhttp.send();
    }

    //Decline Reservation
    function DeclineReservation(eventID, userID, notifID, textArea) {
        var textArea = document.getElementById('remarks' + eventID).value;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                modal(this.responseText, function() {
                    if (c == null) {
                        window.location.href = '/Window_Panel.php?window=UserReservation';
                    } else {
                        window.location.href = '/Window_Panel.php?window=UserReservation&page=' + c + '&category=pending';
                    }
                })
            }
        }
        xmlhttp.open("GET", "/Request_DeclineReservation.php?var=" + eventID + '&userID=' + userID + '&remarks=' + textArea + '&notifID=' + notifID, true);
        xmlhttp.send();
    }

    function cancelreservationforadmin(eventID, userID, notifID, textArea) {
        var textArea = document.getElementById('remarks' + eventID).value;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                modal(this.responseText, function() {
                    if (c == null) {
                        window.location.href = '/Window_Panel.php?window=UserReservation';
                    } else {
                        window.location.href = '/Window_Panel.php?window=UserReservation&page=' + c + '&category=pending';
                    }
                })
            }
        }
        xmlhttp.open("GET", "/Request_RemoveReservationAdminSide.php?var=" + eventID + '&userID=' + userID + '&remarks=' + textArea + '&notifID=' + notifID, true);
        xmlhttp.send();
    }

    function listUsers(mainDiv, type, page_number) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            var list = document.createElement('select');
            if (this.readyState == 4 && this.status == 200) {
                var myObj = JSON.parse(this.responseText);
                if (myObj.length == 0) {
                    if (page_number != 1) {
                        page_number -= 1;
                        listUsers(mainDiv, type, page_number);
                    }
                } else {
                    var page = document.createElement('div');
                    page.id = 'pages';
                    myObj.forEach(function(element, index) {
                        generateUserContent(mainDiv, type, element, index, page);
                    });
                }
            }
        }
        xmlhttp.open("GET", "/Request_UserList.php?page=" + page_number, true);
        xmlhttp.send();
    }

    function listPolicies(mainDiv, type, page_number) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            var list = document.createElement('select');
            if (this.readyState == 4 && this.status == 200) {
                var myObj = JSON.parse(this.responseText);
                if (myObj.length == 0) {
                    if (page_number != 1) {
                        page_number -= 1;
                        listPolicies(mainDiv, type, page_number);
                    }
                } else {
                    var page = document.createElement('div');
                    page.id = 'pages';
                    myObj.forEach(function(element, index) {
                        generatePolicies(mainDiv, type, element, index, ...Array(2), page);
                    });
                    addButton(type);
                }
            }
        }
        xmlhttp.open("GET", "/Request_Policies.php?page=" + page_number, true);
        xmlhttp.send();
    }

    function listEquip(mainDiv, type, page_number) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var myObj = JSON.parse(this.responseText);
                if (myObj.length == 0) {
                    if (page_number != 1) {
                        page_number -= 1;
                        listEquip(mainDiv, type, page_number);
                    }
                } else {
                    var page = document.createElement('div');
                    page.id = 'pages';
                    myObj.forEach(function(element, index) {
                        generateTabContent(mainDiv, type, element, index, ...Array(2), page)
                    });
                    addButton(type);
                }
            }
        }
        xmlhttp.open("GET", "/Request_EquipmentListAndAvailability.php?page= " + page_number + '&window=' + windowType, true);
        xmlhttp.send();
    }

    function listCategPolicies(x, add, value) {
        return new Promise(resolve => {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = async function() {
                if (this.readyState == 4 && this.status == 200) {
                    var myObj = JSON.parse(this.responseText);
                    myObj.forEach(result => {
                        var option = document.createElement('option');
                        option.textContent = result.ct_p_Name;
                        option.value = result.ct_p_ID;
                        x.appendChild(option);
                    })
                    resolve('success');
                }
            }
            xmlhttp.open("GET", "/Request_CategoryPolicies.php", true);
            xmlhttp.send();
        })
    }

    function listRoom(mainDiv, type, page_number) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var myObj = JSON.parse(this.responseText);
                if (myObj.length == 0) {
                    if (page_number != 1) {
                        page_number -= 1;
                        listRoom(mainDiv, type, page_number);
                    }
                } else {
                    var page = document.createElement('div');
                    page.id = 'pages';
                    myObj.forEach(function(element, index) {
                        generateTabContent(mainDiv, type, element, index, ...Array(2), page);
                    });
                    addButton(type);
                }
            }
        }
        xmlhttp.open("GET", "/Request_RoomListAndAvailability.php?page=" + page_number, true);
        xmlhttp.send();
    }

    function removePolicies(ID) {
        //   if (confirm('Are you sure?') == true) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById('editList').remove();
                loadStuff('policies', 'ContentEdit');
                //   editTabContent();
                //   var poliDiv = document.getElementById('polPanel');
                //   var poliBtn = document.getElementById('polBtn');
                //   polBtn.click('3', poliDiv);
            }
        }
        xmlhttp.open("GET", "/Request_RemovePolicies.php?var=" + ID, true);
        xmlhttp.send();
        //   } else {
        //       document.getElementById('editList').remove();
        //       loadStuff('policies', 'ContentEdit');
        //   }
    }

    function removeEquipment(ID) {
        //   if (confirm('Are you sure?') == true) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById('editList').remove();
                //   editTabContent();
                //   var equipDiv = document.getElementById('equipPanel');
                //   var equipBtn = document.getElementById('equipBtn');
                loadStuff('equipment', 'ContentEdit')
                //   equipBtn.click('2', equipDiv);
            }
        }
        xmlhttp.open("GET", "/Request_RemoveEquipment.php?var=" + ID, true);
        xmlhttp.send();
        //   } else {
        //       document.getElementById('editList').remove();

        //       loadStuff('equipment', 'ContentEdit')
        //   }
    }

    function removeRoom(ID) {
        //   if (confirm('Are you sure?') == true) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById('editList').remove();
                loadStuff('room', 'ContentEdit');
            }
        }
        xmlhttp.open("GET", "/Request_RemoveRoom.php?var=" + ID, true);
        xmlhttp.send();
        //   } else {
        //       document.getElementById('editList').remove();
        //       loadStuff('room', 'ContentEdit');
        //   }
    }

    function addPoliciesQuery(ID, desc) {
        //   if (confirm('Are you sure?') == true) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById('editList').remove();
                loadStuff('policies', 'ContentEdit');
            }
        }
        xmlhttp.open("GET", "/Request_AddPolicies.php?ID=" + ID + '&desc=' + desc, true);
        xmlhttp.send();
        //   } else {
        //       document.getElementById('editList').remove();
        //       loadStuff('policies', 'ContentEdit');
        //   }
    }

    function editUserQuery(availability, ID) {
        //   if (confirm('Are you sure?') == true) {
        var eAvailability;
        if (availability) {
            eAvailability = 1;
        } else if (!availability) {
            eAvailability = 0;
        }
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById('editList').remove();
                loadStuff('userList', 'ContentEdit');
            }
        }
        xmlhttp.open("GET", "/Request_EditUser.php?availability=" + eAvailability + '&ID=' + ID, true);
        xmlhttp.send();
        //   } else {
        //       document.getElementById('editList').remove();
        //       loadStuff('userList', 'ContentEdit');
        //   }
    }

    function editPoliciesQuery(name, desc, ID) {
        //editPolicies
        //   if (confirm('Are you sure?') == true) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {

                document.getElementById('editList').remove();
                loadStuff('policies', 'ContentEdit');
            }
        }
        xmlhttp.open("GET", "/Request_EditPolicies.php?name=" + name + '&desc=' + desc + '&ID=' + ID, true);
        xmlhttp.send();
        //   } else {
        //       document.getElementById('editList').remove();
        //       loadStuff('policies', 'ContentEdit');
        //   }
    }

    function editEquipQuery(name, quantity, desc, availability, ID) {
        //   if (confirm('Are you sure?') == true) {
        var eAvailability;
        if (availability) {
            eAvailability = 0;
        } else if (!availability) {
            eAvailability = 1;
        }
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById('editList').remove();
                loadStuff('equipment', 'ContentEdit');
            }
        }
        xmlhttp.open("GET", "/Request_EditEquipList.php?name=" + name + '&quantity=' + quantity + '&desc=' + desc + '&availability=' + eAvailability + '&id=' + ID, true);
        xmlhttp.send();
        //   } else {
        //       document.getElementById('editList').remove();
        //       loadStuff('equipment', 'ContentEdit');
        //   }
    }

    function editRoomQuery(name, capacity, desc, availability, ID, inputParam) {
        //   if (confirm('Are you sure?') == true) {
        var eAvailability;
        if (availability) {
            eAvailability = 0;
        } else if (!availability) {
            eAvailability = 1;
        }
        var formData = new FormData();
        var file = inputParam.files[0];
        formData.append('sample', file);
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById('editList').remove();
                loadStuff('room', 'ContentEdit');
            }
        }
        xmlhttp.open("POST", "/Request_EditRoomList.php?name=" + name + '&cap=' + capacity + '&desc=' + desc + '&availability=' + eAvailability + '&id=' + ID, true);
        xmlhttp.send(formData);
        //   } else {
        //       document.getElementById('editList').remove();
        //       loadStuff('room', 'ContentEdit');
        //   }
    }
    //ForEach Functions
    function sendEmail(userID) {
        var x = localStorage.getItem('resetpass');
        const date1 = new Date(x);
        const date2 = new Date();
        const diffTime = Math.abs(date2 - date1);
        if (x) {
            console.log(diffTime);
            if (diffTime / 1000 >= 300) {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        modal('A link was sent to your email \nPlease Check', function() {
                            localStorage.setItem("resetpass", new Date());
                            document.location.reload();
                        });
                    }
                }
                xmlhttp.open("GET", "/sendEmailLink.php?var=" + userID + '&type=resetpassword', true);
                xmlhttp.send();
            } else {
                modal('You can only reset your password once every 5 minutes, please wait.', function() {
                    return;
                });
            }
        } else {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    modal('A link was sent to your email \nPlease Check', function() {
                        localStorage.setItem("resetpass", new Date());
                        document.location.reload();
                    });
                }
            }
            xmlhttp.open("GET", "/sendEmailLink.php?var=" + userID + '&type=resetpassword', true);
            xmlhttp.send();
        }


    }

    //ForEach Functions
    function profileContent(course, section, isApproved, remarks, isMarked) {
        var fn = "<?php echo $_SESSION["fullName"]; ?>";
        var cn = <?php echo $_SESSION["usercontactnumber"]; ?>;
        var email = "<?php echo $_SESSION["email"]; ?>";
        var pass = "<?php echo $_SESSION["password"]; ?>";
        var userID = "<?php echo $_SESSION['user_ID']; ?>";
        var isAdmin = <?php echo $_SESSION['isAdmin']; ?>;
        var div = document.createElement('div');
        div.className = "_profContent";
        var status;
        div.id = "profContent";
        div.className = "_profContent";
        var forgotBtn = document.createElement('input');
        forgotBtn.className = 'header-btn btn resetPw';
        forgotBtn.type = 'button';
        forgotBtn.value = 'Reset Password';
        forgotBtn.addEventListener('click', function() {
            sendEmail(userID);
        })
        if (isAdmin != 1) {
            if (course == 'Teacher') {
                div.innerHTML = '<h3> Name: ' + fn + '</h3> <br> <h4> ' + course + '<h4> <br>';
                div.innerHTML += '<h4> Email: ' + email + '<h4><br>';
            } else {
                div.innerHTML = '<h3> Name: ' + fn + '</h3> <br> <h4> Course and Section: ' + course + ' ' + section + '<h4> <br>';
                div.innerHTML += '<h4> Email: ' + email + '<h4><br>';
            }
            if (isApproved != 3) {
                if (isApproved == 1) {
                    status = 'Accepted';
                } else if (isApproved == 2) {
                    status = 'Pending';
                }
                div.innerHTML += '<h4> Status: ' + status + '<h4><br>';
            } else if (isApproved == 3) {
                status = 'Denied';
                div.innerHTML += '<h4> Status: ' + status + '<h4><br>';
                div.innerHTML += '<h4> Remarks: ' + remarks + '<h4><br>';
            }
            if (isMarked == 1) {
                div.innerHTML += '<h4>This user has been marked, you are not able to create any reservations <h4><br>';
                div.innerHTML += '<h4> Please contact the gso for more details<h4><br>';
            }
        } else {
            div.innerHTML = '<h3> Name: ' + fn + '</h3> <br>';
            div.innerHTML += '<h4> Email: ' + email + '<h4><br>';
        }
        div.appendChild(forgotBtn);
        // modal img code
        let x = callRegistrationImage(div, userID);
        document.getElementById("content").appendChild(div);
    }
    //HTML PART THAT LISTS THE EQUIPMENT IN THE WINDOW
    function listEquipmentReserved(mainDiv, element, index) {
        var h4 = document.createElement('h4');
        h4.innerHTML += element.equipName + " Qty: " + element.qty;
        mainDiv.appendChild(h4);
    }

    //HTML PART THAT LISTS THE RESERVATIONS IN THE WINDOW
    function reservationContent(motherDiv, userID, page, element, index) {
        var div = document.createElement('div')
        var date = new Date(element.dateStart + ' ' + element.timeStart);
        var diffTime = Math.abs(new Date(element.dateEnd) - new Date(element.dateStart));
        var numberofloops = (diffTime == 0) ? 1 : Math.ceil(diffTime / (1000 * 60 * 60 * 24) + 1);
        var startTime = tConvert(element.timeStart);
        var endTime = tConvert(element.timeEnd)
        div.id = "resContent";
        div.className = "resContent";
        div.innerHTML = '<h3 class="_edit"> Event:' + element.event + '</h3>';
        div.innerHTML += '<h3> Event Adviser:' + element.eventAdviser + '</h3>';
        div.innerHTML += '<h3>Starting Date: ' + element.dateStart + " </h3>";
        div.innerHTML += '<h3>Time:' + startTime + ' to ' + endTime + " </h3>";
        div.innerHTML += '<h3>Duration:' + numberofloops + " day/s. (Ends at: " + element.dateEnd + ") </h3>";
        div.innerHTML += '<h3>Room: ' + element.room + '</h3>';
        var date = new Date();
        var d1 = new Date(element.end);
        if (d1 < date) {
            status = 4;
        } else {
            status = element.approval;
        }
        document.getElementById("content").appendChild(motherDiv)
        motherDiv.appendChild(div);
        if (typeof(element.pagination) != undefined && element.pagination != null) {
            page.innerHTML = element.pagination;
        }
        return [element.reservationID, div, page];
    }


    //HTML PART THAT LISTS THE REGISTRATION OF USERS
    function registrationContent(motherDiv, page, element, index) {
        var div = document.createElement('div')
        div.id = "userProfContent";
        div.className = "userProfContent";
        div.innerHTML += '<h3 class="_edit"> Name:' + element.firstName + '&nbsp' + element.middleName + '&nbsp' + element.lastName + '</h3>';
        div.innerHTML += '<h3> Course:' + element.course + '</h3>';
        div.innerHTML += '<h3> Email:' + element.email + '</h3>';
        if (element.course.toLowerCase() != 'teacher') {
            div.innerHTML += '<h3> Section:' + element.section + '</h3>';
        }
        var fn = element.firstName + ' ' + element.middleName + ' ' + element.lastName
        var textarea = document.createElement('textarea');
        textarea.id = 'remarks';
        textarea.placeholder = "Remarks";
        div.appendChild(textarea);
        //   div.innerHTML += '<textarea id = "remarks" placeholder="Remarks"></textarea><br>';
        div.innerHTML += '<br><br><input type="button" class="header-btn btn" value="Accept" onclick="' + 'createModal(' + "'Confirm Registration of " + fn + "?'" + ', function(){AcceptRegistration(' + element.user + ',' + textarea.textContent + ')})">';
        div.innerHTML += '<input type="button" class="decline header-btn btn" value ="Decline" onclick="' + 'createModal(' + "'Decline Registration of user  " + fn + "?'" + ', function(){DeclineRegistration(' + element.user + ',' + textarea.textContent + ')})">';
        div.innerHTML += '<hr class="hr">';
        document.getElementById("content").appendChild(motherDiv);
        motherDiv.appendChild(div);
        callRegistrationImage(div, element.user)
        if (typeof(element.pagination) != undefined && element.pagination != null) {
            page.innerHTML = element.pagination;
            motherDiv.appendChild(page);
        }
    }



    //RESERVATION
    function resList(type, page_number = 1) {
        var bigcontent = document.getElementById('content');
        var biggestDiv = document.createElement('div');
        var page = document.createElement('div');
        page.id = 'pages';
        if (type == 'pending') {
            biggestDiv.id = 'biggestDiv';
            var bigDiv = document.createElement('div');
            bigDiv.className = 'pendingDiv';
            bigDiv.id = 'bigPendingDiv';
            var label = document.createElement('h2');
            label.textContent = 'Pending Reservations';
            bigDiv.appendChild(label);
            //   bigDiv.appendChild(sideInput)
            biggestDiv.appendChild(bigDiv);
            loadPendingReservation(bigDiv, page, page_number);
        } else if (type == 'archives') {
            var bigDiv2 = document.createElement('div');
            bigDiv2.className = 'finishedDiv';
            bigDiv2.id = 'bigFinishedDiv';
            filterPart(bigDiv2, page, 'archive');
            var label2 = document.createElement('h3');
            label2.textContent = 'Finished And Reviewed Reservations';
            bigDiv2.appendChild(label2);
            biggestDiv.appendChild(bigDiv2);
            loadFinishedReservation(bigDiv2, page, page_number);
        }
        bigcontent.appendChild(biggestDiv);
    }


    //HTML PART THAT LISTS THE RESERVATION OF ITS USERS
    function userReservationContent(motherDiv, page, element, index) {
        var div = document.createElement('div');
        div.id = 'pendingContent'
        var date = new Date(element.dateStart + ' ' + element.timeStart);
        var diffTime = new Date(element.dateEnd) - new Date(element.dateStart);
        var numberofloops = (diffTime == 0) ? 1 : Math.ceil(diffTime / (1000 * 60 * 60 * 24) + 1);
        endTime = tConvert(element.timeEnd)
        startTime = tConvert(element.timeStart)
        div.innerHTML += '<h3> Requestor:' + element.firstName + ' ' + element.middleName + ' ' + element.lastName + '</h3>';
        div.innerHTML += '<h3> Event Name:' + element.event + '</h3>';
        div.innerHTML += '<h3> Event Adviser:' + element.eventAdviser + '</h3>';
        div.innerHTML += '<h3> Room: ' + element.room_name + '</h3>';
        div.innerHTML += '<h3>Starting Date: ' + element.dateStart + " </h3>";
        div.innerHTML += '<h3>Time:' + startTime + ' to ' + endTime + " </h3>";
        div.innerHTML += '<h3>Duration:' + numberofloops + " day/s (Ends at: " + element.dateEnd + ") </h3>";
        if (typeof(element.pagination) != undefined && element.pagination != null) {
            page.innerHTML = element.pagination;
        }
        motherDiv.appendChild(div);
        return [page, element.reservationID, div];
    }

    //HTML PART THAT LISTS THE TAB CONTENT FOR EDIT
    function editTabContent() {
        active = false;
        equipBtn = true;
        roomBtn = true;
        policiesBtn = true;
        userBtn = true;
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
        equipInput.id = 'equipBtn';
        equipInput.className = 'openBtn';
        equipInput.type = 'image';
        equipInput.src = 'assets/side-arrow.png';
        equipInput.addEventListener('click', async function() {
            if (equipBtn == true) {
                document.getElementById('editList').remove();
                c = null;
                await loadStuff('equipment', 'ContentEdit')
                equipBtn = false;
            } else {
                document.getElementById('equipID').remove();
                equipBtn = true;
            }

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
        roomInput.id = 'roomBtn';
        roomInput.className = 'openBtn';
        roomInput.type = 'image';
        roomInput.src = 'assets/side-arrow.png';
        roomInput.addEventListener('click', async function() {
            if (roomBtn == true) {
                document.getElementById('editList').remove();
                c = null;
                await loadStuff('room', 'ContentEdit');
                roomBtn = false;
            } else {
                document.getElementById('roomID').remove();
                roomBtn = true;
            }
        });
        motherDiv.appendChild(roomDiv);
        roomDiv.appendChild(roomLabel);
        roomDiv.appendChild(roomInput);

        //policiesList
        var policiesList = document.createElement('label');
        policiesList.textContent = 'Policies';
        var polDiv = document.createElement('div');
        polDiv.id = 'polPanel';
        polDiv.className = 'sidePanel';
        var polInput = document.createElement('input');
        polInput.id = 'polBtn';
        polInput.className = 'openBtn';
        polInput.type = 'image';
        polInput.src = 'assets/side-arrow.png';
        polInput.addEventListener('click', async function() {
            if (policiesBtn == true) {
                document.getElementById('editList').remove();
                c = null;
                await loadStuff('policies', 'ContentEdit');
                polciiesBtn = false;
            } else {
                document.getElementById('policiesID').remove();
                policiesBtn = true;
            }

        })
        motherDiv.appendChild(polDiv);
        polDiv.appendChild(policiesList);
        polDiv.appendChild(polInput);

        //userList
        var userList = document.createElement('label');
        userList.textContent = 'Users';
        var userDiv = document.createElement('div');
        userDiv.id = 'userPanel';
        userDiv.className = 'sidePanel';
        var userInput = document.createElement('input');
        userInput.id = 'userBtn';
        userInput.className = 'openBtn';
        userInput.type = 'image';
        userInput.src = 'assets/side-arrow.png';
        userInput.addEventListener('click', async function() {
            if (userBtn == true) {
                document.getElementById('editList').remove();
                c = null;
                await loadStuff('userList', 'ContentEdit');
                userBtn = false;
            } else {
                document.getElementById('userID').remove();
                userBtn = true;
            }

        })
        motherDiv.appendChild(userDiv);
        userDiv.appendChild(userList);
        userDiv.appendChild(userInput);
    }


    //HTML PART THAT DISPLAYS THE TABLE
    function loadLists(param, activeDiv, page_number = 1) {
        checker = true;
        var div = document.createElement('div');
        div.id = "divID";
        var table = document.createElement('table');
        table.style = 'border:1px solid #000099';
        var row1 = document.createElement('tr');
        var column1 = document.createElement('td');
        var column2 = document.createElement('td');
        var column3 = document.createElement('td');
        var column4 = document.createElement('td');
        var column5 = document.createElement('td');
        row1.style = 'border:4px solid #000099';
        column1.style = 'border:0.5px solid black';
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
                    table.className = "editTable";
                    activeDiv.appendChild(div);
                    column1.textContent = "Equipment Name";
                    column2.textContent = "Equipment Quantity";
                    column3.textContent = "Equipment Description";
                    column4.textContent = "Equipment Availability";
                    div.append(table);
                    equipBtn = false;
                    listEquip(table, div.id, page_number);
                    turnOffOn(div);
                    active = true;
                    row1.appendChild(column1);
                    row1.appendChild(column2);
                    row1.appendChild(column3);
                    row1.appendChild(column4);
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
                    var column6 = document.createElement('td');
                    column6.textContent = 'Room Image';
                    div.append(table);
                    roomBtn = false;
                    listRoom(table, div.id, page_number);
                    turnOffOn(div);
                    active = true;
                    row1.appendChild(column1);
                    row1.appendChild(column2);
                    row1.appendChild(column3);
                    row1.appendChild(column4);
                    row1.appendChild(column6);
                } else {
                    roomBtn = true;
                    document.getElementById('roomID').remove();
                    active = false;
                }
                break;
            case "3":
                if (policiesBtn) {
                    div.id = 'policiesID'
                    div.style.height = '50%';
                    table.id = 'policiesTbl';
                    activeDiv.appendChild(div);
                    column1.textContent = 'Policy Category';
                    column2.textContent = 'Policies';
                    div.append(table);
                    turnOffOn(div);
                    listPolicies(table, div.id, page_number);
                    policiesBtn = false;
                    active = true;
                    row1.appendChild(column1);
                    row1.appendChild(column2);
                } else {
                    policiesBtn = true;
                    document.getElementById('policiesID').remove();
                    active = false;
                }
                break;
            case "4":
                if (userBtn) {
                    div.id = 'userID'
                    div.style.height = '50%';
                    table.id = 'userTbl';
                    activeDiv.appendChild(div);
                    column1.textContent = 'Full Name';
                    column2.textContent = 'Marked';
                    column5.textContent = "Edit";
                    div.append(table);
                    turnOffOn(div);
                    listUsers(table, div.id, page_number);
                    userBtn = false;
                    active = true;
                    row1.appendChild(column1);
                    row1.appendChild(column2);
                } else {
                    userBtn = true;
                    document.getElementById('userID').remove();
                    active = false;
                }
                break;
            default:
                console.log('something seems to be wrong');
        }

        row1.appendChild(column5);

    }

    function turnOffOn(div) {
        if (active) {
            if (div.id == 'equipID') {
                roomBtn = true;
                policiesBtn = true;
                userBtn = true;
                if (typeof(document.getElementById('roomID')) != undefined && document.getElementById('roomID') != null) {
                    document.getElementById('roomID').remove();
                } else if (typeof(document.getElementById('policiesID')) != undefined && document.getElementById('policiesID') != null) {
                    document.getElementById('policiesID').remove();
                } else {
                    document.getElementById('userID').remove();
                }
            } else if (div.id == 'roomID') {
                equipBtn = true;
                policiesBtn = true;
                userBtn = true;
                if (typeof(document.getElementById('equipID')) != undefined && document.getElementById('equipID') != null) {
                    document.getElementById('equipID').remove();
                } else if (typeof(document.getElementById('policiesID')) != undefined && document.getElementById('policiesID') != null) {
                    document.getElementById('policiesID').remove();
                } else {
                    document.getElementById('userID').remove();
                }
            } else if (div.id == 'policiesID') {
                roomBtn = true;
                equipBtn = true;
                userBtn = true;
                if (typeof(document.getElementById('roomID')) != undefined && document.getElementById('roomID') != null) {
                    document.getElementById('roomID').remove();
                } else if (typeof(document.getElementById('equipID')) != undefined && document.getElementById('equipID') != null) {
                    document.getElementById('equipID').remove();
                } else {
                    document.getElementById('userID').remove();
                }
            } else if (div.id == 'userID') {
                roomBtn = true;
                equipBtn = true;
                policiesBtn = true;
                if (typeof(document.getElementById('roomID')) != undefined && document.getElementById('roomID') != null) {
                    document.getElementById('roomID').remove();
                } else if (typeof(document.getElementById('equipID')) != undefined && document.getElementById('equipID') != null) {
                    document.getElementById('equipID').remove();
                } else {
                    document.getElementById('policiesID').remove();
                }
            }
            enableButtons();
        }
    }


    function generateUserContent(mainDiv, type, element, index, page) {
        var tr = document.createElement('tr');
        tr.id = index;
        mainDiv.appendChild(tr);
        var tdName = document.createElement('td');
        var fullName = document.createElement('p');
        fullName.textContent = element.userFName + ' ' + element.userMDName + ' ' + element.userLName;
        // var inputName= document.createElement('input');
        // inputName.disabled = true;
        // inputName.id = 'contentName';
        // inputName.value = element.p_category;
        // tdName.appendChild(inputName);
        var tdAvailability = document.createElement('td');
        var checkbox = document.createElement('input');
        checkbox.type = 'checkbox';
        checkbox.id = 'isMarkedCB';
        checkbox.disabled = true;
        if (element.isMarked == 0) {
            checkbox.checked = false;
        } else {
            checkbox.checked = true;
        }
        var tdRemove = document.createElement('td');
        var editBtn = document.createElement('input');
        editBtn.type = 'image';
        editBtn.className = 'editButton';
        editBtn.src = "assets/c2.png";
        editBtn.addEventListener('click', editContent);
        editBtn.typeParam = type;
        editBtn.addParam = false;
        editBtn.cbParam = checkbox;
        editBtn.IDParam = element.userID;
        tdRemove.appendChild(editBtn);
        tdName.appendChild(fullName);
        tdAvailability.appendChild(checkbox);
        tr.appendChild(tdName);
        tr.appendChild(tdAvailability);
        tr.appendChild(tdRemove);
        if (typeof(element.pagination) != undefined && element.pagination != null) {
            page.innerHTML = element.pagination;
            mainDiv.appendChild(page);
        }
    }
    async function generatePolicies(mainDiv, type, element, index, add, btn, page) {
        var tr = document.createElement('tr');
        tr.id = index;
        mainDiv.appendChild(tr);
        var tdName = document.createElement('td');

        // var inputName= document.createElement('input');
        // inputName.disabled = true;
        // inputName.id = 'contentName';
        // inputName.value = element.p_category;
        // tdName.appendChild(inputName);

        var tdDesc = document.createElement('td');
        var inputDesc = document.createElement('textarea');

        inputDesc.id = 'contentDesc';
        tdDesc.appendChild(inputDesc);

        var tdRemove = document.createElement('td');
        var editBtn = document.createElement('input');
        editBtn.type = 'image';
        editBtn.className = 'editButton';
        var removeBtn = document.createElement('input');
        removeBtn.type = 'image';
        removeBtn.className = 'removeButton';
        if (add) {
            var input = document.createElement('input');
            input.type = 'text';
            input.setAttribute('list', 'policies');
            tdName.appendChild(input);
            var listName = document.createElement('datalist');
            listName.id = 'policies';
            listName.className = 'policyList'
            editBtn.src = 'assets/c2.png';
            editBtn.placeholder = "Apply";
            editBtn.addEventListener('click', editContent);
            editBtn.typeParam = type;
            editBtn.addParam = true;
            editBtn.listParam = input;
            editBtn.descParam = inputDesc;
            editBtn.removeButton = removeBtn;
            removeBtn.addEventListener('click', function() {
                tr.remove();
                btn.disabled = false;
            });
            btn.disabled = true;
            editBtn.placeholder = 'Save';
            removeBtn.placeholder = 'Cancel';
            editBtn.src = 'assets/c2.png';
            removeBtn.src = 'assets/c1.png';
            checker = false;
            listCategPolicies(listName, add);
        } else {
            var listName = document.createElement('select');
            var x = await listCategPolicies(listName, ...Array(1), element.p_category);
            listName.className = 'policyList';
            listName.id = element.p_ID;
            listName.value = element.p_ct_ID;
            editBtn.src = "assets/c2.png";
            editBtn.addEventListener('click', editContent);
            editBtn.typeParam = type;
            editBtn.addParam = false;
            editBtn.listParam = listName;
            editBtn.descParam = inputDesc;
            editBtn.removeButton = removeBtn;
            editBtn.IDParam = element.p_ID;
            removeBtn.addEventListener('click', function() {
                createModal("Remove Policy?", function() {
                    return removePolicies(element.p_ID)
                })
            });
            removeBtn.src = "assets/c1.png";
            inputDesc.disabled = true;
            inputDesc.value = element.p_description;
            listName.disabled = true;
        }
        tdRemove.appendChild(editBtn);
        tdRemove.appendChild(removeBtn);
        tdName.appendChild(listName);
        tr.appendChild(tdName);
        tr.appendChild(tdDesc);
        tr.appendChild(tdRemove);
        if (typeof(element.pagination) != undefined && element.pagination != null) {
            page.innerHTML = element.pagination;
            mainDiv.appendChild(page);
        }
    }
    //Called by function that lists all Equipment (should be a foreach kinda thing)
    function generateTabContent(mainDiv, type, element, index, add, btn, page) {
        var tr = document.createElement('tr');
        tr.id = index;
        var tdName = document.createElement('td');
        var inputName = document.createElement('textarea');
        inputName.id = 'contentName';
        inputName.required = true;
        tdName.appendChild(inputName);
        var tdQuantity = document.createElement('td');
        var inputQuantity = document.createElement('input');
        inputQuantity.id = 'contentQuantity';
        inputQuantity.required = true;
        inputQuantity.type = 'number';
        tdQuantity.appendChild(inputQuantity);
        var tdDesc = document.createElement('td');
        var inputDesc = document.createElement('textarea');
        inputDesc.id = 'contentDesc';
        inputDesc.required = true;
        tdDesc.appendChild(inputDesc);
        var tdAvailability = document.createElement('td');
        var checkbox = document.createElement('input');
        checkbox.type = 'checkbox';
        checkbox.id = 'availabilityCB';
        var tdRemove = document.createElement('td');
        var editBtn = document.createElement('input');
        editBtn.type = 'image';
        editBtn.className = 'editButton';
        var removeBtn = document.createElement('input');
        removeBtn.type = 'image';
        removeBtn.className = 'removeButton';
        tdAvailability.appendChild(checkbox);
        tdRemove.appendChild(editBtn);
        tdRemove.appendChild(removeBtn);
        tr.appendChild(tdName);
        tr.appendChild(tdQuantity)
        tr.appendChild(tdDesc);
        tr.appendChild(tdAvailability);
        if (add) {
            btn.disabled = true;
            checkbox.disabled = false;
            checker = false;
            checkbox.checked = true;
            disableButtons(editBtn, removeBtn);
            if (type == 'roomID') {
                var img = document.createElement('input');
                img.type = 'image';
                tr.appendChild(img);
                var input = document.createElement('input');
                input.type = 'file';
                input.setAttribute('name', 'roomImg');
                tr.appendChild(input);
                input.onchange = evt => {
                    const [file] = input.files;
                    if (file) {
                        img.src = URL.createObjectURL(file);
                    }
                };
            }
            editBtn.addEventListener('click', editContent);
            editBtn.typeParam = type;
            editBtn.addParam = true;
            editBtn.nameParam = inputName;
            editBtn.quantityParam = inputQuantity;
            editBtn.descParam = inputDesc;
            editBtn.cbParam = checkbox;
            editBtn.imageParam = img;
            editBtn.imageUploadParam = input;
            editBtn.removeButton = removeBtn;
            removeBtn.addEventListener('click', function() {
                tr.remove();
                btn.disabled = false;
            });

        } else {
            inputName.disabled = true;
            inputQuantity.disabled = true;
            inputDesc.disabled = true;
            checkbox.disabled = true;
            if (element.roomAvailability == 0 || element.equipAvailability == 0) {
                checkbox.checked = true;
            } else {
                checkbox.checked = false;
            }
            switch (type) {
                case 'roomID':
                    editBtn.addEventListener('click', editContent);
                    editBtn.typeParam = type;
                    editBtn.addParam = false;
                    editBtn.nameParam = inputName;
                    editBtn.quantityParam = inputQuantity;
                    editBtn.descParam = inputDesc;
                    editBtn.cbParam = checkbox;
                    editBtn.IDParam = element.roomID;
                    editBtn.removeButton = removeBtn;
                    inputName.value = element.roomName;
                    inputDesc.value = element.roomDesc;
                    inputQuantity.value = element.roomCap;
                    removeBtn.addEventListener('click', function() {
                        createModal("Remove Room?", function() {
                            return removeRoom(element.roomID)
                        })

                    });
                    var img = document.createElement('input');
                    img.type = 'image';
                    img.className = 'editC img-thumbnail';
                    img.src = element.imgPath;
                    tr.appendChild(img);
                    var input = document.createElement('input');
                    input.setAttribute('name', 'roomImg', 'editC img-thumbnail');
                    input.type = 'file';
                    input.style = 'display:none';
                    img.addEventListener('click', function() {
                        input.click();
                    })

                    input.onchange = evt => {
                        const [file] = input.files;
                        if (file) {
                            img.src = URL.createObjectURL(file);
                        }
                    };


                    input.disabled = true;
                    tr.appendChild(input);
                    editBtn.imageParam = img;
                    editBtn.imageUploadParam = input;
                    break;
                case 'equipID':
                    editBtn.addEventListener('click', editContent);
                    editBtn.typeParam = type;
                    editBtn.addParam = false;
                    editBtn.nameParam = inputName;
                    editBtn.quantityParam = inputQuantity;
                    editBtn.descParam = inputDesc;
                    editBtn.cbParam = checkbox;
                    editBtn.IDParam = element.equipID;
                    editBtn.removeButton = removeBtn;
                    removeBtn.addEventListener('click', function() {
                        createModal('Remove Equipment?', function() {
                            return removeEquipment(element.equipID);
                        })
                    });
                    inputQuantity.value = element.equipQty;
                    inputName.value = element.equipName;
                    inputDesc.value = element.equipDesc;
                    break;
            }
            editBtn.src = "assets/c2.png";
            removeBtn.src = "assets/c1.png";

        }

        var pages = document.getElementById('pages');

        tr.appendChild(tdRemove);
        mainDiv.appendChild(tr);
        if (typeof(element.pagination) != undefined && element.pagination != null) {
            page.innerHTML = element.pagination;
            mainDiv.appendChild(page);
        }
        /// tr.before(tdName,pages);
        //appending of element
    }

    function editContent(e) {
        if (checker == true) {
            disableButtons(e.currentTarget, e.currentTarget.removeButton);
            console.log(e.currentTarget.removeButton);
            name = (e.currentTarget.nameParam) ? e.currentTarget.nameParam.disabled = false : ' ';
            qty = (e.currentTarget.quantityParam) ? e.currentTarget.quantityParam.disabled = false : ' ';
            desc = (e.currentTarget.descParam) ? e.currentTarget.descParam.disabled = false : ' ';
            availability = (e.currentTarget.cbParam) ? e.currentTarget.cbParam.disabled = false : ' ';
            selectedList = (e.currentTarget.listParam) ? e.currentTarget.listParam.disabled = false : ' ';
            listParam = (e.currentTarget.listParam) ? e.currentTarget.listParam.disabled = false : ' ';
            inputParam = (e.currentTarget.imageUploadParam) ? e.currentTarget.imageUploadParam.disabled = false : ' ';
            checker = false;
        } else {
            //disabling part 
            name = (e.currentTarget.nameParam) ? e.currentTarget.nameParam.value : ' ';
            qty = (e.currentTarget.quantityParam) ? e.currentTarget.quantityParam.value : ' ';
            desc = (e.currentTarget.descParam) ? e.currentTarget.descParam.value : ' ';
            availability = (e.currentTarget.cbParam) ? e.currentTarget.cbParam.checked : ' ';
            selectedList = (e.currentTarget.listParam) ? e.currentTarget.listParam.value : ' ';
            type = (e.currentTarget.typeParam) ? e.currentTarget.typeParam : ' ';
            ID = (e.currentTarget.IDParam) ? e.currentTarget.IDParam : ' ';
            listParam = (e.currentTarget.listParam) ? e.currentTarget.listParam.value : ' ';
            inputParam = (e.currentTarget.imageUploadParam) ? e.currentTarget.imageUploadParam : ' ';
            addParam = (e.currentTarget.addParam) ? e.currentTarget.addParam : '';
            var target = e.currentTarget;
            var text;
            if (addParam) {
                if (type == 'policiesID') {
                    text = 'Confirm addition of Policy?';
                } else if (type == 'roomID') {
                    text = 'Confirm addition of Room?';
                } else if (type == 'equipID') {
                    text = 'Confirm addition of Equipment?';
                }
            } else {
                if (type == 'policiesID') {
                    text = 'Confirm change of Policy?';
                } else if (type == 'roomID') {
                    text = 'Confirm change of Room?';
                } else if (type == 'equipID') {
                    text = 'Confirm change of Equipment?';
                } else if (type = 'userID') {
                    text = 'Confirm mark of user? \n *Note: Marking users means they are not able to create a reservation (They are still able to access the site)';
                }
            }

            createModal(text, function() {
                checker = true;
                var x = enableButtons(type, name, qty, desc, availability, ID, e.currentTarget, addParam, listParam, inputParam);
                if (x) {
                    name = (target.nameParam) ? target.nameParam.disabled = true : ' ';
                    qty = (target.quantityParam) ? target.quantityParam.disabled = true : ' ';
                    desc = (target.descParam) ? target.descParam.disabled = true : ' ';
                    availability = (target.cbParam) ? target.cbParam.disabled = true : ' ';
                    selectedList = (target.listParam) ? target.listParam.disabled = true : ' ';
                    listParam = (target.listParam) ? target.listParam.disabled = true : ' ';
                    inputParam = (target.imageUploadParam) ? target.imageUploadParam.disabled = true : ' ';
                }else{
                    checker = false;
                }
            });
        }
    }

    function enableButtons(type, name, quantity, desc, availability, ID, value, add, listParam, inputParam) {
        const x = document.querySelectorAll('.editButton');
        const y = document.querySelectorAll('.removeButton');
        if (add) {
            if (type == 'policiesID') {
                if (listParam == '' || desc == '') {
                    modal('Input must not be empty/ or zero ', function() {
                        return;
                    })
                    return false;
                } else {
                    addPoliciesQuery(listParam, desc);
                    return true;
                }
            } else {
                if (name == '' || desc == '' || quantity == '' || quantity == 0) {
                    modal('Input must not be empty/ or zero ', function() {
                        return;
                    })
                    return false;
                    if (type == 'roomID') {
                        loadStuff('room', 'ContentEdit');
                        return true;
                    } else if (type == 'equipID') {
                        loadStuff('equipment', 'ContentEdit');
                        return true;
                    }
                } else {
                    if (type == 'roomID') {
                         addRoomQuery(name, quantity, desc, availability, inputParam);
                        return true;
                    } else if (type == 'equipID') {
                         addEquipQuery(name, quantity, desc, availability);
                        return true;
                    }

                }
            }


        } else {
            if (typeof(document.getElementById('addBtn')) == undefined && document.getElementById('addBtn') != null) document.getElementById('addBtn').disabled = true;
            if (type == 'policiesID') {
                if (listParam == '' || desc == '') {
                    modal('Input must not be empty/ or zero ', function() {
                        return;
                    })
                    return false;
                } else {
                     editPoliciesQuery(listParam, desc, ID);
                    return true;
                }
            } else if (type == 'userID') {
                 editUserQuery(availability, ID);
                return true;
            } else {
                if (name == '' || desc == '' || quantity == '' || quantity == 0) {
                    modal('Input must not be empty/ or zero ', function() {
                        return;
                    })
                    return false;
                    if (type == 'roomID') {
                        loadStuff('room', 'ContentEdit');
                        return true;
                    } else if (type == 'equipID') {
                        loadStuff('equipment', 'ContentEdit');
                        return true;
                    }
                } else {
                    if (type == 'roomID') {
                        editRoomQuery(name, quantity, desc, availability, ID, inputParam);
                        return true;
                    } else if (type == 'equipID') {
                        editEquipQuery(name, quantity, desc, availability, ID);
                        return true;
                    }
                }
            }

            for (a = 0; a < x.length; a++) {
                x[a].disabled = false;
            }
            for (a = 0; a < y.length; a++) {
                y[a].disabled = false;
            }

            if (typeof(value) != undefined && value != null) {
                value.value = "Edit";
            }
        }
    }

    function disableButtons(value, value2) {
        var x = document.querySelectorAll('.editButton');
        var y = document.querySelectorAll('.removeButton');
        if (typeof(document.getElementById('addBtn')) == undefined && document.getElementById('addBtn') != null) document.getElementById('addBtn').disabled = true;
        for (a = 0; a < x.length; a++) {
            if (value != x[a]) {
                x[a].disabled = true;
            }
        }
        for (a = 0; a < y.length; a++) {
            if (value2 != y[a]) {
                y[a].disabled = true;
            }
        }
        // to change edit and cancel icons
          value.src = 'assets/checked.png';
          value2.src = 'assets/cross.png';
    }

    function addRoomQuery(name, quantity, desc, availability, inputParam) {
        //   if (confirm('Are you sure?') == true) {
        var eAvailability;
        if (availability) {
            eAvailability = 0;
        } else if (!availability) {
            eAvailability = 1;
        }
        var formData = new FormData();
        var file = inputParam.files[0];
        formData.append('sample', file);
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById('editList').remove();
                loadStuff('room', 'ContentEdit');
            }
        }
        xmlhttp.open("POST", "/Request_AddRoom.php?name=" + name + '&desc=' + desc + '&quantity=' + quantity + '&avail=' + eAvailability, true);
        xmlhttp.send(formData);

        //   } else {
        //       document.getElementById('editList').remove();
        //       loadStuff('room', 'ContentEdit');
        //   }

        //   editTabContent();
        //   var roomDiv = document.getElementById('roomPanel');
        //   var roomBtn = document.getElementById('roomBtn');
        //   roomBtn.click('2', equipDiv);
    }

    function addEquipQuery(name, quantity, desc, availability) {
        //   if (confirm('Are you sure?') == true) {
        var eAvailability;
        if (availability) {
            eAvailability = 0;
        } else if (!availability) {
            eAvailability = 1;
        }

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                loadStuff('equipment', 'ContentEdit')
            }
        }
        xmlhttp.open("GET", "/Request_AddEquipment.php?name=" + name + '&desc=' + desc + '&quantity=' + quantity + '&avail=' + eAvailability, true);
        xmlhttp.send();
        document.getElementById('editList').remove();
        //   editTabContent();
        //   var equipDiv = document.getElementById('equipPanel');
        //   var equipBtn = document.getElementById('equipBtn');
        //   equipBtn.click('2', equipDiv);
        //   } else {
        //       document.getElementById('editList').remove();
        //       loadStuff('room', 'ContentEdit');
        //   }
    }

    //Added at the end once everything is rendered
    function addButton(type) {
        var botDiv = document.createElement('div');
        botDiv.className = "bottom";
        var botInput = document.createElement('input');
        botInput.type = 'submit';
        botInput.id = 'addBtn';
        if (type == 'roomID') {
            var mainDiv = document.getElementById('roomID');
            var table = document.getElementById('roomTbl');
            botInput.addEventListener('click', function() {
                generateTabContent(table, type, ...Array(2), true, botInput);
            })
            botInput.value = "Add Room";
        } else if (type == 'equipID') {
            botInput.value = "Add Equipment";
            var mainDiv = document.getElementById('equipID');
            var table = document.getElementById('equipmentTbl');
            botInput.addEventListener('click', function() {
                generateTabContent(table, type, ...Array(2), true, botInput);
            })
        } else if (type == 'policiesID') {
            botInput.value = "Add Policy";
            var mainDiv = document.getElementById('policiesID');
            var table = document.getElementById('policiesTbl');
            botInput.addEventListener('click', function() {
                generatePolicies(table, type, ...Array(2), true, botInput);
            })
        }
        //bottomDiv elements
        botDiv.appendChild(botInput);
        mainDiv.appendChild(botDiv);
    }

    //Monitoring form
    function monitoringContent(c) {
        var motherDiv = document.createElement('div');
        motherDiv.id = "monitoringContent";
        motherDiv.className = 'row';
        document.getElementById('content').appendChild(motherDiv);
        //format of monitoring
        callFinishedReservations(motherDiv, c);
    }





    function listEquipDetails(ID, mainDiv, element, index) {
        mainDiv.innerHTML += '<h4 class="equipID" placeholder = "EquipName">' + element.equipName + ':' + +element.qty + ' </h4>'
    }


    function filterPart(mainDiv, page, type) {
        var div = document.createElement('div');
        div.id = 'Filter';
        //   var search = document.createElement('input');
        //   search.type = 'text';
        //   search.id = 'myInput';
        var button = document.createElement('button');
        button.id = 'myInput';
        button.textContent = 'Filter'
        var monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        var monthDropdown = document.createElement('select');

        for (a = 0; a < monthNames.length; a++) {
            var option = document.createElement('option');
            option.textContent = monthNames[a];
            option.value = a + 1;
            monthDropdown.appendChild(option);
        }
        var currentYear = new Date().getFullYear();
        var yearDropdown = document.createElement('select');
        for (var i = currentYear; i < currentYear + 5; i++) {
            var option = document.createElement('option');
            option.textContent = i;
            option.value = i;
            yearDropdown.appendChild(option);
        }

        for (var x = currentYear; x > currentYear - 5; x--) {
            if (x != currentYear) {
                var option = document.createElement('option');
                option.textContent = x;
                option.value = x;
                var i, L = yearDropdown.options.length - 1;
                for (i = L; i >= 0; i--) {
                    yearDropdown.insertBefore(option, yearDropdown.options[i])
                }
            }
        }

        for (count = 0; count < monthDropdown.length; count++) {
            if (monthDropdown[count].value == new Date().getMonth() + 1) {
                monthDropdown.options[count].selected = true;
            }
        }

        for (count = 0; count < yearDropdown.length; count++) {
            if (yearDropdown[count].value == new Date().getFullYear()) {
                yearDropdown.options[count].selected = true;
            }
        }
        //   monthDropdown.appendChild(defaultOption2);
        //   yearDropdown.appendChild(defaultOption);
        //   div.appendChild(search);
        div.appendChild(monthDropdown);
        div.appendChild(yearDropdown);
        //   div.appendChild(button);
        mainDiv.appendChild(div);
        monthDropdown.addEventListener('change', filterSearchQuery);
        yearDropdown.addEventListener('change', filterSearchQuery)
        //   button.addEventListener('click', filterSearchQuery);
        // monthDropdown.searchParam = search;
        monthDropdown.monthParam = monthDropdown;
        monthDropdown.yearParam = yearDropdown;
        monthDropdown.pageParam = page;
        monthDropdown.mainDivParam = mainDiv;
        monthDropdown.typeParam = type;
        // yearDropdown.searchParam = search;
        yearDropdown.monthParam = monthDropdown;
        yearDropdown.yearParam = yearDropdown;
        yearDropdown.pageParam = page;
        yearDropdown.mainDivParam = mainDiv;
        yearDropdown.typeParam = type;
        //   return [search.value,monthDropdown.value,yearDropdown.value];
    }

    function removeOptions(selectElement, exception) {
        var i, L = selectElement.options.length - 1;
        for (i = L; i >= 0; i--) {
            if (exception != selectElement.options[i].value) {
                selectElement.remove(i);
            }
        }
    }

    function filterSearchQuery(e) {
        if (e.currentTarget == e.currentTarget.yearParam) {
            let value = e.currentTarget.yearParam.value;
            let date = new Date(e.currentTarget.yearParam.value).getFullYear();
            removeOptions(e.currentTarget.yearParam, value)
            for (var a = value; a < date + 5; a++) {
                if (a != value) {
                    var option = document.createElement('option');
                    option.textContent = a;
                    option.value = a;
                    e.currentTarget.appendChild(option);
                }
            }
            for (var x = value; x > date - 5; x--) {
                if (x != value) {
                    var option = document.createElement('option');
                    option.textContent = x;
                    option.value = x;
                    var i, L = e.currentTarget.options.length - 1;
                    for (i = L; i >= 0; i--) {
                        e.currentTarget.yearParam.insertBefore(option, e.currentTarget.options[i])
                    }
                }
            }
        }

        mainDiv = e.currentTarget.mainDivParam;
        page = e.currentTarget.pageParam;
        //   keyword = e.currentTarget.searchParam.value;
        month = e.currentTarget.monthParam.value;
        year = e.currentTarget.yearParam.value;
        if (e.currentTarget.typeParam == 'archive') {
            document.getElementById('resList').remove();
            loadFinishedReservation(mainDiv, page, 1, month, year);
        } else if (e.currentTarget.typeParam = 'userres') {
            document.getElementById('currentUserReservation').remove();
            callReservationDetails(mainDiv, page, 1, month, year);
        }

    }

    //ALl functions related to archives and to be reviewed
    //Archived Query
    function loadFinishedReservation(bigDiv, page, page_number = 1, month = new Date().getMonth() + 1, year = new Date().getFullYear()) {
        var motherDiv = document.createElement('div');
        motherDiv.className = "userResContent";
        motherDiv.id = "resList";
        var params = "?page=" + page_number + "&month=" + month + "&year=" + year + '&filter=ON';
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var myObj = JSON.parse(this.responseText);
                if (myObj[0] == null) {
                    motherDiv.innerHTML = '<h3> No user reservation </h3?>';
                } else {
                    myObj.forEach((element, index) => {
                        finishedReservationContent(motherDiv, 1, element, index, page);
                    })
                }
            }
        }
        xmlhttp.open("POST", "/Request_AllReservations.php" + params, true);
        xmlhttp.send();
        bigDiv.appendChild(motherDiv);
    }

    //To be reviewed query
    function callFinishedReservations(div, page_number = 1) {
        var page = document.createElement('div');
        page.id = 'pages';
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var myObj = JSON.parse(this.responseText);
                if (myObj[0] == null) {
                    div.innerHTML += '<h3> Reservations to be monitored:  </h3?>'
                    div.innerHTML += '<h3> No user reservation </h3>';
                } else {
                    myObj.forEach(function(element, index) {
                        finishedReservationContent(div, 0, element, index, page);
                    });
                }
            }
        }
        xmlhttp.open("GET", "/Request_FinishedReservations.php?page=" + page_number, true);
        xmlhttp.send();
    }

    //Displays the event name + time with the btn.
    function finishedReservationContent(div, review, element, index, page) {
        var mainDiv = document.createElement('div');
        mainDiv.id = 'finishedContent';
        isClicked = false;
        var label = document.createElement('h3');
        label.id = 'eventName';
        label.className = 'block';
        var startTime = tConvert(element.timeStart);
        var endTime = tConvert(element.timeEnd);
        label.textContent = 'Event: ' + element.event;
        var space = document.createElement('br');
        //   var sideDiv = document.createElement('div');
        //   sideDiv.className = 'sidePanel';
        //   sideDiv.id = 'monitor' + element.reservationID;
        //   var sideInput = document.createElement('input');
        //   sideInput.className = 'openBtn';
        //   sideInput.type = 'image';
        //   sideInput.src = '/assets/side-arrow.png';
        // //   sideInput.addEventListener('click', function() {
        // //       loadContent(element.reservationID, review);
        // //   })
        onLoad(element.reservationID, review, mainDiv, element.remarks);
        mainDiv.appendChild(label);
        mainDiv.innerHTML += '<h3>Event Date: ' + element.dateStart + ' to ' + element.dateEnd + '</h3>';
        mainDiv.innerHTML += '<h3>From: ' + startTime + ' to ' + endTime + '</h3>';

        div.appendChild(mainDiv)

        if (typeof(element.pagination) != undefined && element.pagination != null) {
            page.innerHTML = element.pagination;
            div.appendChild(page);
        }
    }
    //Loads info based on selected reservatoion
    function onLoad(ID, review, div, remarks) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = async function() {
            if (this.readyState == 4 && this.status == 200) {
                var mainDiv = document.createElement('div');
                mainDiv.id = 'subContents';
                mainDiv.className = 'subClassName';
                const myObj = await JSON.parse(this.responseText);
                var fullName = myObj.firstName + ' ' + myObj.middleName + ' ' + myObj.lastName;
                mainDiv.innerHTML = '<h4>Adviser: ' + myObj.eventAdviser + '</h4>';
                mainDiv.innerHTML += '<h4>Full Name: ' + fullName + '</h4>';
                const first = await loadRoomDetails(myObj.roomID, mainDiv, ID, myObj.userID, review, remarks)
                div.appendChild(mainDiv);
                mainDiv.innerHTML += '<hr class="hro">';
            }
        }
        xmlhttp.open("GET", "/Request_SpecificReservation.php?r_ID=" + ID + '&isReviewed=' + review, true);
        xmlhttp.send();
    }

    function loadRoomDetails(roomID, mainDiv, ID, userID, review, remarks) {
        return new Promise(resolve => {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = async function() {
                if (this.readyState == 4 && this.status == 200) {
                    var myObj = JSON.parse(this.responseText);
                    mainDiv.innerHTML += '<h4>Room Borrowed: ' + myObj.roomName + '</h4>';
                    const second = await loadEquipDetails(ID, mainDiv, userID, review, remarks);
                    resolve('success');
                }
            }
            xmlhttp.open("GET", "/Request_SpecificRoom.php?var=" + roomID, true);
            xmlhttp.send();
        });

    }

    function loadEquipDetails(ID, mainDiv, userID, review, remarks) {
        return new Promise(resolve => {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var myObj = JSON.parse(this.responseText);
                    if (myObj.length == 0) {
                        mainDiv.innerHTML += '<h4>No Equipment Borrowed</h4>';
                    } else {
                        mainDiv.innerHTML += '<h4>Equipment Borrowed: </h4>';
                    }
                    myObj.forEach(function(element, index) {
                        listEquipDetails(ID, mainDiv, element, index);
                    })
                    if (review == 0) {
                        mainDiv.innerHTML += '<textarea id ="remarksArea">'
                        mainDiv.innerHTML += '<br><label>Mark User? <input type="checkbox" id="markUser">'
                        mainDiv.innerHTML += '<br><input class="header-btn btn submitMf" type="button" value="Submit" id = "' + ID + '" onclick="submitRemark(' + ID + ',' + userID + ')" >'
                    } else {
                        mainDiv.innerHTML += '<h4>Remarks: ' + remarks + '</h4>';
                    }
                    var printingPanel = "'/Backend_printingPanel.php?id=" + ID + "'";
                    mainDiv.innerHTML += '<input class="header-btn btn" type="button" value="Print" onclick="openNewTab(' + printingPanel + ')"> ';
                    callReservationImage(mainDiv, ID)
                    resolve('success');
                }
            }
            xmlhttp.open("GET", "/Request_ReservationForUserEquipment.php?var=" + ID, true);
            xmlhttp.send();
        })
    }


    //Submit remarks
    function submitRemark(btnID, userID) {
        var x = document.getElementById('remarksArea');
        var id = document.getElementById('markUser');
        var marked;
        if (id.checked == true) {
            marked = 1;
        } else {
            marked = 0;
        }
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                modal(this.responseText,function(){
                document.getElementById('monitoringContent').remove();
                loadStuff(...Array(1), 'Monitoring');
                })
            }
        }
        xmlhttp.open("GET", "/Request_EditFinishedReservation.php?var=" + btnID + "&remark=" + x.value + "&marked=" + marked + "&userID=" + userID, true);
        xmlhttp.send();
    }
</script>