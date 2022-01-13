<script type="text/javascript" src="Backend_Modal.php"></script>
<script>
    var number = 0;
    (async () => {
        const value = await generateForm(number);
        const valve = new Promise(resolve => {
            document.getElementById('reservationForm').appendChild(value);
            resolve('success');
        });
        const secondvalue = await addRestOfForm();
        await runRest();
    })();

    function runRest() {
        renderRestofForm();
        var startDate = document.getElementById('startDate').value;
        var tempDate = new Date(startDate);
        var duration = document.getElementById('durationDay').value;
        var endDate = tempDate.setDate(tempDate.getDate() + Number(duration));
        var startTime = document.getElementById('startTime').value;
        var endTime = document.getElementById('endTime').value;
        eventTrigger(startDate, duration, endDate, startTime, endTime)
        var x = document.getElementsByClassName('roomInfo');
        loadMaxQty(x[0].querySelector('select'));
    }
    var array = [];
    async function listRoom(room, currentTarget) {
        return new Promise((resolve, reject) => {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    try {
                        var myObj = JSON.parse(this.responseText);
                        myObj.forEach(function(element, index) {
                            renderListRoom(room, element, index)
                        });
                        resolve([room, currentTarget]);
                        var x = document.getElementsByClassName('roomInfo');
                        loadMaxQty(x[0].querySelector('select'));
                    } catch (exception) {
                        reject(exception);
                    }

                }
            }
            xmlhttp.open("GET", "Request_RoomList.php", true);
            xmlhttp.send();
        })
    }

    function loadMaxQty(select) {
        return new Promise((resolve, reject) => {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    try {
                        var myObj = JSON.parse(this.responseText);
                        myObj.forEach(result => {
                            if (select.value == result.roomID) {
                                select.parentElement.querySelectorAll('input')[0].max = result.roomCap;
                                select.parentElement.querySelectorAll('label')[2].textContent = 'Cap: ' + result.roomCap + ' people';
                            }
                        })
                        resolve('success');
                    } catch (exception) {
                        reject(exception);
                    }
                }
            }
            xmlhttp.open("GET", "Request_RoomList.php", true);
            xmlhttp.send();
        })
    }

    function renderListRoom(room, element, index) {
        if (element.roomCap != 0) {
            var option = document.createElement('option');
            option.appendChild(document.createTextNode(element.roomName));
            option.value = element.roomID;
            option.id = "options";
            room.appendChild(option);
        }

    }

    function renderRestofForm() {
        var x = <?php echo $_SESSION["usercourse"]; ?>;
        var section = <?php echo $_SESSION['userSection']; ?>;
        var fullName = "<?php echo $_SESSION['fullName']; ?>";
        document.getElementById("fullName").value = fullName;
        document.getElementById("contact").value = "0" + "<?php echo $_SESSION["usercontactnumber"]; ?>";
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var myObj = JSON.parse(this.responseText)
                if(myObj.sectionname == "Teacher"){
                    document.getElementById("course").value = myObj.coursename;
                }else{
                    document.getElementById("course").value = myObj.coursename + ' ' + myObj.sectionname;
                }
              
            }
        }
        xmlhttp.open("GET", "Request_Course.php?var=" + x + '&section=' + section + '&userID=' + null, true);
        xmlhttp.send();
    }

    function callActiveReservations(callback) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if (callback) {
                    callback(JSON.parse(this.responseText));
                }
            }
        }
        xmlhttp.open("GET", "Request_LatestReservations.php", true);
        xmlhttp.send();
    }
    //Description:
    //Changes contents of Room And Equipment list based on date (Due to availability)
    function eventTrigger(startDate, duration, endDate, startTime, endTime) {
        let callReservations = callActiveReservations(async function(result) {
            var count = document.querySelectorAll('.eventChanger');
            // var label = count.querySelectorAll('.error');
            var sample = count.length - 1;
            var room = count[sample].getElementsByTagName('select')[0];
            let response = await disable(startDate, duration, endDate, startTime, endTime, room, result);
            for (a = 0; a < count.length; a++) {
                var label = count[a].querySelector('.error');
                count[a].addEventListener('change', loadWrapperEvents, true)
                count[a].startDateParam = startDate;
                count[a].durationParam = duration;
                count[a].endDateParam = endDate;
                count[a].startTimeParam = startTime;
                count[a].endTimeParam = endTime;
                count[a].resultParam = result;
                count[a].formParam = count[a].parentElement;
                count[a].errorParam = label;
            }
        })
    }

    async function loadWrapperEvents(evt) {
        var room = this.getElementsByTagName('select')[0];
        var cb = this.getElementsByTagName('input')[5];
        var inputElements = this.getElementsByTagName('input');
        var elem = event.target;
        if (elem == inputElements[0]) {
            evt.currentTarget.startDateParam = elem.value
        }
        if (elem == inputElements[1]) {
            evt.currentTarget.durationParam = elem.value;
        }
        if (elem == inputElements[2]) {
            evt.currentTarget.startTimeParam = elem.value;
        }
        if (elem == inputElements[3]) {
            evt.currentTarget.endTimeParam = elem.value;
        }
        if (elem == inputElements[0] || elem == inputElements[1] || elem == inputElements[2] || elem == inputElements[3]) {
            if (evt.currentTarget.endTimeParam > evt.currentTarget.startTimeParam) {
                document.getElementById('submitBtn').disabled = false;
                resetRoomList(room);
                removeTB(true, cb, evt.currentTarget.formParam);
                evt.currentTarget.errorParam.textContent = '';
                var data1 = listRoom(room, evt.currentTarget);
                await data1.then(([resolve, target]) => {
                    disable(target.startDateParam, target.durationParam,
                        target.endDateParam, target.startTimeParam, target.endTimeParam, resolve, target.resultParam);
                });

                // var data2 = disable(evt.currentTarget.startDateParam,evt.currentTarget.durationParam,evt.currentTarget.endDateParam
                //     ,evt.currentTarget.startTimeParam,evt.currentTarget.endTimeParam,data1,evt.currentTarget.resultParam);
                // await data2;

            } else {
                evt.currentTarget.errorParam.textContent = 'End Time must be later than Start Time';
                document.getElementById('submitBtn').disabled = true;
            }
        }
    }

    async function disable(startDate, duration, endDate, startTime, endTime, roomID, result) {
        let promise = new Promise((resolve, reject) => {
            array = [];
            try {
                for (var x = 0; x < result.length; x++) {
                    var diffTime = new Date(result[x]['dateEnd']) - new Date(result[x]['dateStart']);
                    var numberofloops = (diffTime == 0) ? 0 : Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                    for (var i = 0; i <= numberofloops; i++) {
                        var storedEnd = new Date(result[x]['dateStart'] + ' ' + result[x]['timeEnd']); //stored end B
                        var storedStart = new Date(result[x]['dateStart'] + ' ' + result[x]['timeStart']); //stored start A
                        storedEnd.setTime(storedEnd.getTime() + (3 * 60 * 60 * 1000));
                        storedEnd.setDate(storedEnd.getDate() + Number(i));
                        storedStart.setDate(storedStart.getDate() + Number(i));
                        for (a = 0; a < duration; a++) {
                            var inputStart = new Date(startDate + ' ' + startTime); //input start C 
                            var inputEnd = new Date(startDate + ' ' + endTime); //input End D 
                            inputStart.setDate(inputStart.getDate() + Number(a));
                            inputEnd.setDate(inputEnd.getDate() + Number(a));
                            if ((inputStart <= storedEnd) && (storedStart <= inputEnd)) {
                                for (var s = 0; s < roomID.length; s++) {
                                    if (roomID.options[s].value == result[x]['room']) {
                                        roomID.remove(s);
                                        if (roomID.length == 0) {
                                            var option = document.createElement('option');
                                            option.appendChild(document.createTextNode('No available rooms for reservation'));
                                            option.value = 0;
                                            roomID.appendChild(option);
                                        }
                                    }
                                }
                                array.push({
                                    equipID: result[x]['equipID'],
                                    qty: result[x]['qty'],
                                });
                            }

                        }
                    }
                }
                resolve('success');
            } catch (exception) {
                reject(exception);
            }
        })
    }


    //default max qty for no conflicting schedules

    async function resetRoomList(roomID) {
        var length = roomID.options.length - 1;
        for (var i = length; i >= 0; i--) {
            roomID.remove(i);
        }
        return;
    }




    //Equipment related stuff
    //Checker if User wants to add equip or not
    // function generateEquipmentList(cb = document.getElementById('equipmentCB0'),equipList = document.getElementById('equipmentList0')){
    //     if (cb.checked) {
    //         generateTB(equipList);
    //     } else {
    //         removeTB(equipList);
    //     }
    // }

    function generateTB(equipList, form) {
        var counter = 0;
        var addedArray = [];
        var subDiv_1 = document.createElement('div');
        subDiv_1.id = 'subDiv_1';
        var select = document.createElement('select');
        var buttonAdd = document.createElement('input');
        //buttonAdd properties
        buttonAdd.name = 'buttonAdd';
        buttonAdd.className = 'buttonAdd';
        buttonAdd.type = 'button';
        buttonAdd.value = 'Add';
        buttonAdd.id = 'buttonAdd' + number;
        buttonAdd.addEventListener('click', addButtonEvent, true)
        buttonAdd.addEventListener('click', checkIfSelectedIsAdded, true);
        buttonAdd.typeParam = 'buttonAdd';
        buttonAdd.counterParam = counter;
        buttonAdd.formParam = form;
        buttonAdd.selectParam = select;
        buttonAdd.buttonAddParam = buttonAdd;
        buttonAdd.equipListParam = equipList;
        //select properties
        select.id = "equipList" + number;
        select.className = "equipListCN";
        select.addEventListener('change', checkIfSelectedIsAdded, true);
        select.arrayParam = array;
        select.typeParam = 'select';
        select.selectParam = select;
        select.buttonAddParam = buttonAdd;
        subDiv_1.appendChild(select);
        subDiv_1.appendChild(buttonAdd);
        document.getElementById(equipList.id).appendChild(subDiv_1)
        listEquip(true, select, ...Array(3), buttonAdd);
        //disableOnChange();
    }

    function addEquipment(equipList, select, buttonAdd, form, counter) {
        // var mainDiv = document.getElementById("equipmentList");
        // var select = document.getElementById('equipList');
        var array = [];
        var subDiv_2 = document.createElement('div');
        subDiv_2.className = "removableDiv";
        var input_2 = document.createElement('input');
        var hiddenInput = document.createElement('input');
        var input = document.createElement('input');
        var buttonRemove = document.createElement('input');
        var label = document.createElement('label');
        // hidden Input
        hiddenInput.value = select.options[select.selectedIndex].value;
        hiddenInput.name = "equipment[]";
        hiddenInput.type = 'hidden';
        hiddenInput.className = 'hiddenEquipInput';
        //label properties
        input_2.value = select.options[select.selectedIndex].text;
        input_2.className = 'equipInput';
        input_2.readOnly = true;
        input_2.name = "equipName[]";
        input_2.type = 'text';
        //input properties
        input.type = 'number';
        input.min = '1';
        input.name = 'qty[]';
        //buttonRemove properties
        buttonRemove.name = 'buttonRemove';
        buttonRemove.type = 'button';
        buttonRemove.value = 'X';
        buttonRemove.addEventListener('click', removeSpecificTB)
        buttonRemove.addEventListener('click', checkIfSelectedIsAdded);
        buttonRemove.counterParam = counter;
        buttonRemove.arrayParam = array;
        buttonRemove.typeParam = 'remove';
        buttonRemove.formParam = form;
        buttonRemove.selectParam = select;
        buttonRemove.buttonAddParam = buttonAdd;
        buttonRemove.equipListParam = equipList;
        buttonRemove.hiddenInputParam = hiddenInput;
        buttonRemove.cbParam = equipList.getElementsByTagName('input')[0];
        //label properties
        var mainDiv = document.getElementById(equipList.id);
        mainDiv.appendChild(subDiv_2);
        subDiv_2.appendChild(hiddenInput);
        subDiv_2.appendChild(input_2);
        subDiv_2.appendChild(input)
        subDiv_2.appendChild(buttonRemove);
        subDiv_2.appendChild(label);
        select.hiddenInputParam = hiddenInput;
        buttonAdd.hiddenInputParam = hiddenInput;
        listEquip(false, ...Array(1), hiddenInput, input, label);
        // checkIfSelectedIsAdded(hiddenInput, select, buttonAdd);
        counter++;
    }

    function checkIfSelectedIsAdded(evt) {
        if (evt.currentTarget.typeParam == 'buttonAdd') {
            if (evt.currentTarget.hiddenInputParam.value ==
                evt.currentTarget.selectParam.options[evt.currentTarget.selectParam.selectedIndex].value) {
                evt.currentTarget.buttonAddParam.disabled = true;
            } else {
                evt.currentTarget.buttonAddParam.disabled = false;
            }
            // }
            if (evt.currentTarget.selectParam.options.length == evt.currentTarget.counterParam) {
                evt.currentTarget.buttonAddParam.disabled = true;
            }
        } else if (evt.currentTarget.typeParam == 'select') {
            evt.currentTarget.arrayParam = [];
            evt.currentTarget.parentElement.parentElement.querySelectorAll('input[name="equipment[]"]').forEach(result => {
                evt.currentTarget.arrayParam.push(result.value)
            })
            for (resultcount = 0; resultcount < evt.currentTarget.arrayParam.length; resultcount++) {
                if (evt.currentTarget.arrayParam[resultcount] == evt.currentTarget.value) {

                    evt.currentTarget.buttonAddParam.disabled = true;
                    break;
                } else {
                    evt.currentTarget.buttonAddParam.disabled = false;
                }
            }
            // if (evt.currentTarget.hiddenInputParam.value == evt.currentTarget.value) {
            //     evt.currentTarget.buttonAddParam.disabled = true;
            // } else {
            //     evt.currentTarget.buttonAddParam.disabled = false;
            // }

            // if (evt.currentTarget.selectParam.options.length == counter) {
            //     evt.currentTarget.buttonAddParam.disabled = true;
            // }
        } else if (evt.currentTarget.typeParam == 'remove') {
            evt.currentTarget.arrayParam = [];
            var x = evt.currentTarget.equipListParam;

            x.querySelectorAll('input[name="equipment[]"]').forEach(result => {
                evt.currentTarget.arrayParam.push(result.value)
            })
            for (resultcount = 0; resultcount < evt.currentTarget.arrayParam.length; resultcount++) {
                if (evt.currentTarget.arrayParam[resultcount] == evt.currentTarget.value) {
                    evt.currentTarget.buttonAddParam.disabled = true;
                    break;
                } else {
                    evt.currentTarget.buttonAddParam.disabled = false;
                }
                if (evt.currentTarget.selectParam.options.length == evt.currentTarget.counterParam) {
                    evt.currentTarget.buttonAddParam.disabled = true;
                }
            }
        }
    }

    function removeTB(onChange, cb, subDiv) {
        var firstDiv = subDiv.getElementsByTagName('div')[3];
        console.log(subDiv);
        var divsToRemove = subDiv.querySelectorAll('.removableDiv');
        if (firstDiv) {
            firstDiv.remove();
            if (divsToRemove.length > 0) {
                for (var i = divsToRemove.length - 1; i >= 0; i--) {
                    divsToRemove[i].remove();
                }
            } else {
                document.getElementById(cb.id).checked = false;
            }
        }

        if (onChange == true) {
            document.getElementById(cb.id).checked = false;
        }
    }

    function removeSpecificTB(evt) {
        var form = evt.currentTarget.formParam;
        var divsToRemove = form.querySelectorAll('.removableDiv');
        if (divsToRemove.length != 1) {
            this.parentElement.remove();
            evt.currentTarget.counterParam--;
        } else {
            removeTB(true, evt.currentTarget.cbParam, form);
        }
        checkIfSelectedIsAdded(evt);
    }

    function listEquip(generate, select, equipID, input, label, buttonAdd) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var myObj = JSON.parse(this.responseText);
                if (generate == true) {
                    if (myObj.length > 0) {
                        myObj.forEach(function(element, index) {
                            renderListEquip(select, element, index)
                        });
                    } else {
                        buttonAdd.disabled = true;
                        var option = document.createElement('option');
                        option.appendChild(document.createTextNode('No Equipment Available'));
                        option.value = null;
                        select.appendChild(option);
                    }

                } else {
                    myObj.forEach(function(element, index) {
                        renderMaxQty(equipID, input, label, element, index)
                    });
                }
            }
        }
        xmlhttp.open("GET", "Request_EquipmentList.php", true);
        xmlhttp.send();
    }

    function renderMaxQty(equip, input, label, element, index) {
        currentQty = element.equipQty;
        if (array.length != 0) {
            for (i = 0; i < array.length; i++) {
                if (equip.value == element.equipID) {
                    if (array[i]['equipID'] == element.equipID) {
                        currentQty -= array[i]['qty'];
                    }
                    input.max = currentQty;
                    label.textContent = 'Max: ' + currentQty;
                }

                // if (equip.value == element.equipID) {
                //     currentQty = element.equipQty;
                //     input.max = currentQty;
                //     label.textContent = 'Max:' + currentQty;
                // }
                // if (equip.value == array[i]['equipID']) {
                //     currentQty = element.equipQty;
                //     if (equip.value == element.equipID) {
                //         currentQty -= array[i]['qty'];
                //         label.textContent = 'Max:' + currentQty;
                //     } else {
                //         label.textContent = 'Max:' + currentQty;
                //     }
                //     input.max = currentQty;
                // }
            }
        } else {
            if (equip.value == element.equipID) {
                currentQty = element.equipQty;
                input.max = currentQty;
                label.textContent = 'Max:' + currentQty;
            }
        }

    }



    function renderListEquip(select, element, index) {
        var currentQty = element.equipQty;
        for (i = 0; i < array.length; i++) {
            if (element.equipID == array[i]['equipID']) {
                currentQty -= array[i]['qty'];
            }
        }
        if (currentQty != 0) {
            var option = document.createElement('option');
            option.appendChild(document.createTextNode(element.equipName));
            option.value = element.equipID;
            select.appendChild(option);
        }
    }
    async function generateForm(number) {
        return new Promise(async resolve => {
            var div = document.createElement('div');
            div.id = 'addedChild';
            div.className = 'formparts';
            // form stuff
            // var form = document.createElement('form');
            // form.action = "/Window_ReservationForm.php";
            // form.method = "post";
            // form.enctype = 'multipart/form-data';
            // form.id = 'reservationForm' + number;
            // form.appendChild(div);
            //eventtitle and adviser
            var eventLabel = document.createElement('label');
            eventLabel.setAttribute('for', "Event");
            eventLabel.textContent = 'Event Name: '
            eventLabel.className = 'col-sm-5 col-form-label';
            var eventInput = document.createElement('input');
            eventInput.type = 'text';
            eventInput.className = 'form-control';
            eventInput.id = 'event';
            eventInput.name = 'event';
            eventInput.required = true;

            var adviserLabel = document.createElement('label');
            adviserLabel.textContent = 'Event Adviser: '
            adviserLabel.className = 'col-sm-5 col-form-label';
            var adviserInput = document.createElement('input');
            adviserInput.text = 'text';
            adviserInput.className = 'form-control';
            adviserInput.id = 'adviser';
            adviserInput.name = 'adviser';


            div.appendChild(eventLabel);
            div.appendChild(eventInput);
            div.innerHTML += '<br>';
            div.appendChild(adviserLabel);
            div.appendChild(adviserInput);
            div.innerHTML += '<br>';

            var wrapper = document.createElement('div');
            wrapper.id = 'wrapper';
            wrapper.className = 'eventChanger';
            div.appendChild(wrapper);
            //Date
            var currentDate = new Date();
            var dateLabel = document.createElement('label');
            dateLabel.setAttribute('for', 'dateAndTime');
            dateLabel.className = 'col-sm-5 col-form-label';
            dateLabel.textContent = 'Start Date: '
            var dateInput = document.createElement('input');
            dateInput.type = 'date';
            dateInput.className = 'form-control';
            dateInput.id = 'startDate';
            dateInput.name = 'startDate';
            currentDate.setDate(currentDate.getDate() + 3);
            currentMonth = currentDate.getMonth() + 1;
            currentDay = currentDate.getDate();
            if (currentMonth < 10) {
                currentMonth = '0' + currentMonth;
            }
            if (currentDay < 10) {
                currentDay = '0' + currentDay
            };
            var minDate = currentDate.getFullYear() + '-' + (currentMonth) + '-' + currentDay;
            dateInput.setAttribute('value', minDate);
            dateInput.min = minDate;
            dateInput.required = true;

            wrapper.appendChild(dateLabel);
            wrapper.appendChild(dateInput);
            wrapper.innerHTML += '<br>';

            //Duration
            var durationLabel = document.createElement('label');
            durationLabel.setAttribute('for', 'Duration');
            durationLabel.className = 'col-sm-5 col-form-label';
            durationLabel.textContent = 'Duration  (in Days): ';
            var durationInput = document.createElement('input');
            durationInput.type = 'number';
            durationInput.className = 'form-control';
            durationInput.name = 'duration';
            durationInput.id = 'durationDay';
            durationInput.setAttribute('placeholder', '(In Days)');
            durationInput.setAttribute('value', '1');
            durationInput.required = true;

            wrapper.appendChild(durationLabel);
            wrapper.appendChild(durationInput);
            wrapper.innerHTML += '<br><br>';

            //Start and End Time
            var timeLabel = document.createElement('label');
            timeLabel.setAttribute('for', 'dateAndTime');
            timeLabel.textContent = 'Start to End Time: ';
            var startInput = document.createElement('input');
            startInput.className = 'form-control';
            startInput.id = 'startTime';

            startInput.name = 'startTime';
            startInput.type = 'time';
            startInput.min = "08:00";
            startInput.max = "17:00";
            startInput.setAttribute('value', '08:00');
            startInput.required = true;
            var span = document.createElement('span');
            span.textContent = ' to ';
            var endTimeErr = document.createElement('span');
            endTimeErr.className = 'error';
            endTimeErr.id = 'endTimeErr';
            var endInput = document.createElement('input');
            endInput.className = 'form-control';
            endInput.id = 'endTime';
            endInput.name = 'endTime';
            endInput.type = 'time';
            endInput.min = "08:00";
            endInput.max = "17:00";
            endInput.setAttribute('value', '09:00');
            endInput.required = true;

            wrapper.appendChild(timeLabel);
            wrapper.appendChild(startInput);
            wrapper.appendChild(span);
            wrapper.appendChild(endInput);
            wrapper.innerHTML += '<br>';
            wrapper.appendChild(endTimeErr);
            wrapper.innerHTML += '<br>';


            //Room
            var roomDiv = document.createElement('div');
            roomDiv.className = 'roomInfo';
            var roomLabel = document.createElement('label');
            roomLabel.className = 'col-sm-1 col-form-select';
            roomLabel.setAttribute('for', 'room');
            roomLabel.textContent = 'Room: '
            var selectLabel = document.createElement('select');
            selectLabel.className = 'drop-rooms';  
            selectLabel.name = 'room';
            selectLabel.id = 'room' + number;
            await listRoom(selectLabel, ...Array(1), roomDiv);
            var maxAttendees = document.createElement('input');
            maxAttendees.placeHolder = '# of Attendees'
            maxAttendees.className = 'form-control';
            maxAttendees.type = 'number';
            maxAttendees.name = 'attendees';
            // input.max = element.roomCap;
            var label = document.createElement('label');
            label.className = 'col-sm-5 col-form-select';
            label.textContent = '# of Attendees:';
            var maxLabel = document.createElement('label');
            document.addEventListener('change', async function(e) {
                if (e.target && e.target.id == selectLabel.id) {
                    var x = await loadMaxQty(e.target);
                    console.log(maxAttendees);
                }
            });
            roomDiv.appendChild(roomLabel);
            roomDiv.appendChild(selectLabel);
            roomDiv.innerHTML += '<br><br>';
            roomDiv.appendChild(label);
            roomDiv.appendChild(maxAttendees);
            roomDiv.appendChild(maxLabel);
            wrapper.appendChild(roomDiv);
            wrapper.innerHTML += '<br>';

            //Equipment
            var equipDiv = document.createElement('div');
            equipDiv.id = 'equipmentList' + number;

            wrapper.appendChild(equipDiv);

            //Append to equipDiv
            var equipLabel = document.createElement('label');
            equipLabel.setAttribute('for', 'Equipment');
            equipLabel.className = 'labelName';
            equipLabel.className = 'col-sm-5 col-form-select';
            equipLabel.textContent = 'Add Equipment?';
            equipLabel.innerHTML += '<br>';
            var switchLabel = document.createElement('label');
            switchLabel.className = 'col-sm-5 col-form-select';
            switchLabel.className = 'switch';
            equipDiv.innerHTML += '<br>';

            equipDiv.appendChild(equipLabel);
            equipDiv.appendChild(switchLabel);


            //append to switchLabel
            var CBinput = document.createElement('input');
            CBinput.id = 'equipmentCB' + number;

            CBinput.type = 'checkbox';
            CBinput.name = 'equipAdd';
            CBinput.checked = true;
            var CBspan = document.createElement('span');
            CBspan.className = "slider round";
            document.addEventListener('change', function(e) {
                if (e.target && e.target.id == CBinput.id) {
                    if (e.target.checked == true) {
                        generateTB(equipDiv, div);
                    } else {
                        removeTB(...Array(1), CBinput, div);
                        document.removeEventListener('click', addButtonEvent, true)
                    }
                }
            })
            switchLabel.appendChild(CBinput);
            switchLabel.appendChild(CBspan);

            div.innerHTML += '<br>';
            resolve(div);
        })
        // var style = document.createElement('style');
        // url ='/CSS/Form.css';
        // style.textContent = '@import "' + url + '"';
        // var head = document.getElementsByTagName('head')[0]; 
        // var fi = setInterval(function() {
        //     try {
        //         style.sheet.cssRules; // <--- MAGIC: only populated when file is loaded
        //         CSSDone('listening to @import-ed cssRules');
        //         clearInterval(fi);
        //     } catch (e) {}
        // }, 10);
        // head.appendChild(style);
    }

    function addButtonEvent(event) {
        if (event.target && event.target.id == event.currentTarget.buttonAddParam.id) {
            addEquipment(event.currentTarget.equipListParam,
                event.currentTarget.selectParam, event.currentTarget.buttonAddParam, event.currentTarget.formParam, event.currentTarget.counterParam);
        }
    }

    async function addRestOfForm() {
        return new Promise(resolve => {
            var div = document.createElement('div');
            div.id = 'restofForm';

            var form = document.getElementById('reservationForm');
            var contactLabel = document.createElement('label');
            contactLabel.setAttribute('for', 'Contact');
            contactLabel.textContent = 'Contact Details: ';
            contactLabel.className = 'col-sm-5 col-form-select';
            var contactInput = document.createElement('input');
            contactInput.type = 'text';
            contactInput.id = 'contact';
            contactInput.className = 'form-control';
            contactInput.disabled = true;
            contactInput.name = 'contact';

            var attachLetter = document.createElement('label');
            attachLetter.setAttribute('for', 'form-control');
            attachLetter.textContent = 'Attachment Letters:  ';
            attachLetter.className = 'form-label';

            var attachInput = document.createElement('input');
            attachInput.type = 'file';
            attachInput.className = 'form-control';
            attachInput.id = 'File';
            attachInput.name = 'letterUpload[]';
            attachInput.multiple = true;

            var spanErr = document.createElement('span');
            spanErr.className = 'error';
            // spanErr.textContent = <?php echo $uploadErr ?>;

            var submitBtn = document.createElement('input');
            submitBtn.type = 'submit';
            submitBtn.className = 'submit Btn';
            submitBtn.style = 'float:right;';
            submitBtn.name = 'submitBtn';
            submitBtn.textContent = 'Submit';
            submitBtn.id = 'submitBtn';
            form.addEventListener('submit', getAllValues, true);
            // document.addEventListener('click', getAllValues, true);
            // document.submitParam = submitBtn
            div.appendChild(contactLabel);
            div.appendChild(contactInput);
            div.innerHTML += '<br>';
            div.appendChild(attachLetter);
            div.appendChild(attachInput);
            div.innerHTML += '<br>';
            div.appendChild(spanErr);
            div.appendChild(submitBtn);
            form.appendChild(div);
            resolve('success');
        })
    }
    // async function removeForm(){
    //     document.getElementById('restofForm').remove();
    //     await addRestOfForm();
    // }
    async function addReservation() {
        number++;
        var form = await generateForm(number);
        var removeBtn = document.createElement('input');
        removeBtn.type = 'button';
        removeBtn.className = 'removeBtn';
        removeBtn.style = 'float:right';
        removeBtn.addEventListener('click', removeThis);
        removeBtn.value = 'X';
        removeBtn.formParam = form;
        var inputList = form.querySelectorAll('input');
        var mainBody = document.getElementById('reservationForm');
        var before = document.getElementById('restofForm');
        var hr = document.createElement('hr');
        removeBtn.hrParam = hr;
        form.insertBefore(removeBtn, form.firstChild);
        mainBody.insertBefore(form, before);
        mainBody.insertBefore(hr, form)
        var tempDate = new Date(inputList[2].value);
        var duration = inputList[3].value;
        var endDate = tempDate.setDate(tempDate.getDate() + Number(duration));
        loadMaxQty(form.querySelector('select')[0].parentElement)
        eventTrigger(inputList[2].value, inputList[3].value, endDate, inputList[4].value, inputList[5].value);
    }

    function removeThis(evt) {
        evt.currentTarget.formParam.remove();
        evt.currentTarget.hrParam.remove();
    }

    function getAllValues(evt) {
        evt.preventDefault();
        var inputSuccess;
        var fileUploadSuccess;
        var roomSuccess;
        var facts = true;
        let profile = [];
        var x = document.getElementById('restofForm').querySelectorAll('input');
        var uploadedCount = x[1].files.length
        document.querySelectorAll(".formparts").forEach(f => {
            let obj = {};
            let equipqty = [];
            let equipID = [];
            let equipName = [];
            f.querySelectorAll("input").forEach(ele => {
                if (ele.value != '') {
                    if (ele.id == 'durationDay') {
                        if (ele.value <= 0) {
                            facts = false;
                            modal("Invalid value for Input:Duration", () => {
                                return;
                            })
                        } else {
                            obj[ele.name] = ele.value || "";
                        }
                    } else {
                        obj[ele.name] = ele.value || "";
                    }

                    if (facts) {
                        success = true;
                    }
                } else {
                    if (facts) {
                        success = false;
                        modal('blank values, please fill them up', () => {
                            return;
                        })
                        facts = false;
                    }
                }
            });
            var room = f.querySelectorAll('select');
            if (room[0].value == 0) {
                modal('No available Room for that slot, please choose a different Date/Time slot.', () => {
                    return;
                });
                roomSuccess = false;
                facts = false;
            } else {
                roomSuccess = true;
                obj['room'] = room[0].value;
                obj['roomName'] = room[0].options[room[0].selectedIndex].text;
            }

            f.querySelectorAll('input[name="qty[]"]').forEach(result => {
                equipqty.push({
                    'qty': result.value,
                    'max': result.max
                });
            })
            f.querySelectorAll('input[name="equipment[]"]').forEach(result => {
                equipID.push({
                    'ID': result.value
                });
            })

            f.querySelectorAll('input[name="equipName[]"]').forEach(result => {
                equipName.push({
                    'name': result.value
                });
            })
            let arr3 = equipqty.map((item, i) => Object.assign({}, item, equipID[i]));
            let arr4 = arr3.map((item, i) => Object.assign({}, item, equipName[i]));
            obj['EquipmentStuff'] = arr4;
            var numberofloops1 = (obj['duration'] == 1) ? 0 : obj['duration'] - 1;
            var endDate = new Date(obj['startDate']);
            endDate.setDate(endDate.getDate() + Number(numberofloops1));
            obj['endDate'] = endDate.toISOString().split('T')[0];
            profile.push(obj);
        });
        if (uploadedCount == 0) {
            if (facts) {
                modal("Please upload your attachment letters", () => {
                    return;
                });
            }
            fileUploadSuccess = false;
        } else {
            fileUploadSuccess = true;
        }
        for (var fileCount = 0; fileCount < uploadedCount; fileCount++) {
            if (!x[1].files[fileCount].name.match(/.(jpg|jpeg|png)$/i)) {
                modal('Invalid file format\n Accepts JPG|JPEG|PNG', () => {
                    return;
                });
                fileUploadSuccess = false;
                break;
            }
        }
        if (fileUploadSuccess && success && roomSuccess) {
            var everythingOkay;
            if (profile.length > 1) {
                loop1: for (var i = 0; i < profile.length; i++) {
                    var numberofloops = (profile[i]['duration'] == 1) ? 0 : profile[i]['duration'] - 1;
                    loop2:
                        for (var firstCycle = 0; firstCycle <= numberofloops; firstCycle++) {
                            var firstStart = new Date(profile[i]['startDate'] + ' ' + profile[i]['startTime']);
                            var firstEnd = new Date(profile[i]['startDate'] + ' ' + profile[i]['endTime']);
                            firstStart.setDate(firstStart.getDate() + Number(firstCycle));
                            firstEnd.setDate(firstEnd.getDate() + Number(firstCycle));
                        }
                    loop3:
                        for (var iv2 = 0; iv2 < profile.length; iv2++) {
                            var numberofloops2 = (profile[iv2]['duration'] == 1) ? 0 : profile[iv2]['duration'] - 1;
                            if (i != iv2) {
                                loop4: for (var secondCycle = 0; secondCycle <= numberofloops2; secondCycle++) {
                                    var secondStart = new Date(profile[iv2]['startDate'] + ' ' + profile[iv2]['startTime']);
                                    var secondEnd = new Date(profile[iv2]['startDate'] + ' ' + profile[iv2]['endTime']);
                                    secondStart.setDate(secondStart.getDate() + Number(secondCycle));
                                    secondEnd.setDate(secondEnd.getDate() + Number(secondCycle));
                                    if ((firstStart <= secondEnd) && (secondStart <= firstEnd)) {
                                        console.log('conflict');
                                        if (profile[iv2]['EquipmentStuff'].length >= 1) {
                                            loop5: for (equipCount1 = 0; equipCount1 < profile[iv2]['EquipmentStuff'].length; equipCount1++) {
                                                if (profile[i]['EquipmentStuff'].length >= 1) {
                                                    loop6: for (equipCount2 = 0; equipCount2 < profile[i]['EquipmentStuff'].length; equipCount2++) {
                                                        if (profile[iv2]['EquipmentStuff'][equipCount1]['ID'] == profile[i]['EquipmentStuff'][equipCount2]['ID']) {
                                                            var currentQty = parseInt(profile[iv2]['EquipmentStuff'][equipCount1]['qty']) + parseInt(profile[i]['EquipmentStuff'][equipCount2]['qty']);
                                                            if (currentQty > parseInt(profile[iv2]['EquipmentStuff'][equipCount1]['max'])) {
                                                                modal('Total quantity of equipment has exceeded the maximum capacity possible.\nPlease change before proceeding', function() {
                                                                    return;
                                                                })
                                                                var everythingOkay = false;
                                                                break loop1;
                                                            } else {
                                                                var everythingOkay = true;
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                        if (profile[i]['room'] == profile[iv2]['room']) {
                                            modal('Conflicting schedule in rooms. \nPlease change one before proceeding.', function() {
                                                return;
                                            })
                                            var everythingOkay = false;
                                            break loop1;
                                        } else {
                                            everythingOkay = true;
                                        }
                                    } else {
                                        everythingOkay = true;
                                    }
                                }
                            }
                        }
                }
            }
            else {
                everythingOkay = true;
            }
        }
        let submitBtn = evt.currentTarget.submitBtn;
        if(everythingOkay){
            createModal(profile, x[1].files, function() {
            submitForm(profile, submitBtn);
        })
        }
    }

    function submitForm(profile, submitBtn) {
        var form = document.getElementById('reservationForm');
        profile = JSON.stringify(profile);
        var formData = new FormData(form);
        var xmlhttp = new XMLHttpRequest();
        submitBtn.disabled = true;
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if (this.responseText == 'success') {
                    modal("Reservation success\nStatus: Pending", function() {
                        window.location.href = "Window_HomePage.php";
                    })
                } else {
                    modal(this.responseText, function() {
                        location.reload();
                    })
                }
            }
        }
        xmlhttp.open("POST", "Request_InsertIntoTbl_reservation.php?var=" + profile, true);
        xmlhttp.send(formData);
    }

    function createModal(profileArr, filesArr, func, i = 0) {
        modalBody = document.createElement('div');
        modalBody.className = 'modalConfirm shadow p-3 mb-5 bg-white rounded';
        invisibleContainer = document.createElement('div');
        invisibleContainer.className = 'fullscreenContainer';
        reservationDetails = document.createElement('div');
        reservationDetails.innerHTML =
            '<h3> Confirm Reservation of the ff:' +
            '<h4> Event Name: ' + profileArr[i].event +
            '<h4> Event Adviser: ' + profileArr[i].adviser +
            '<h4> From: ' + profileArr[i].startDate + ' to ' + profileArr[i].endDate +
            '<h4> Time: ' + profileArr[i].startTime + ' to ' + profileArr[i].endTime +
            '<h4> Room: ' + profileArr[i].roomName + ' Attendees: ' + profileArr[i].attendees;
        for (a = i; a < profileArr[i].EquipmentStuff.length; a++) {
            reservationDetails.innerHTML += '<h4> Equipment to be reserved: ';
            reservationDetails.innerHTML += '<h5>' + profileArr[i].EquipmentStuff[a].name + ': ' + profileArr[i].EquipmentStuff[a].qty;
        }
        modalConfirm = document.createElement('input');
        modalConfirm.type = 'button';
        modalConfirm.value = "Confirm";
        modalConfirm.className = 'header-btn btn f-confirm';
        modalCancel = document.createElement('input');
        modalCancel.type = 'button';
        modalCancel.value = "Cancel";
        modalCancel.className = 'header-btn btn decline f-decline';
        modalBody.appendChild(reservationDetails);
        invisibleContainer.appendChild(modalBody);
        if (profileArr.length > 1) {
            var manipulateDiv = document.createElement('div');
            var prev = document.createElement('span');
            prev.className = 'left';
            var next = document.createElement('span');
            next.className = 'right';
            prev.textContent = ' previous ';
            next.textContent = ' next  ';
            prev.addEventListener('click', function() {
                i--;
                if (i < 0) i = profileArr.length - 1;
                invisibleContainer.remove();
                createModal(profileArr,filesArr,func,i);
            })

            next.addEventListener('click', function() {
                i++;
                if (i == profileArr.length) i = 0;
                invisibleContainer.remove();
                createModal(profileArr,filesArr,func,i);
            })
            manipulateDiv.appendChild(prev);
            manipulateDiv.appendChild(next);
            modalBody.appendChild(manipulateDiv);
        }
        modalConfirm.addEventListener('click', function(e) {
            func();
            invisibleContainer.remove();
        });
        modalCancel.addEventListener('click', function(e) {
            invisibleContainer.remove();
            return true;
        });
        document.body.appendChild(invisibleContainer);
        //for modal Image
        reservationDetails.innerHTML += '<h4> Letters included: ' +
        '*NOTE: Please make sure all uploaded images are in proper format/orientation to reduce the chances of your reservation being rejected. ';
        var img = document.createElement('img');
        img.src = URL.createObjectURL(filesArr[0]);
        var moveDiv = document.createElement('div');
        moveDiv.class = "moveModal";
        var modal = document.createElement('div');
        modal.id = 'myModal';
        modal.className = 'modal modal-f';
        var span = document.createElement('span');
        span.className = 'close';
        span.textContent = 'X';
        var modalImg = document.createElement('img');
        modalImg.id = 'modal-content';
        modalImg.className = 'adjust';
        var boxClicked = false;
        var modalDiv = document.createElement('div');

        reservationDetails.appendChild(img);
        reservationDetails.appendChild(modal);
        modal.appendChild(modalImg);
        modal.appendChild(moveDiv)
        span.addEventListener('click', function() {
            modal.style.display = "none";
            modalImg.classname = ' ';
            click = false;
            flipped = false;
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
                            var b = 0;
                        };
                    })
                }
                boxClicked = true;
            }
        });
        if (filesArr.length > 1) {
            var b = 0;
            var prev = document.createElement('span');
            prev.className = 'left';
            var next = document.createElement('span');
            next.className = 'right';
            prev.textContent = '<';
            next.textContent = '>';
            prev.addEventListener('click', function() {
                b--;
                if (b < 0) b = filesArr.length - b;
                modalImg.src = URL.createObjectURL(filesArr[b]);
            })
            next.addEventListener('click', function() {
                b++;
                if (b == filesArr.length) b = 0;
                console.log(filesArr[b]);
                modalImg.src = URL.createObjectURL(filesArr[b]);
            })
            moveDiv.appendChild(prev);
            moveDiv.appendChild(next);
        }

        modalBody.appendChild(modalConfirm);
        modalBody.appendChild(modalCancel);
    }
</script>