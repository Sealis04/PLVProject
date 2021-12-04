<script>
    generateEquipmentList();
    listRoom();
    renderRestofForm();
    (async () => {
        const value = await eventTrigger()})();
   
    // var btn = document.getElementById('addBtn'); 
    // btn.disabled=true;
    var counter = 0;
    var startDate = document.getElementById('startDate').value;
    var tempDate = new Date(startDate);
    var duration = document.getElementById('durationDay').value;
    var endDate = tempDate.setDate(tempDate.getDate() + Number(duration));
    var startTime = document.getElementById('startTime').value;
    var endTime = document.getElementById('endTime').value;
    var array = [];
    var roomArray = [];

    async function listRoom() {
        return new Promise((resolve, reject) => {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    try{
                    var myObj = JSON.parse(this.responseText);
                    myObj.forEach(renderListRoom);
                    resolve('success');
                    }catch(exception){
                        reject(exception);
                    }
                  
                }
            }
            xmlhttp.open("GET", "Request_RoomList.php", true);
            xmlhttp.send();
        })
    }



    function renderListRoom(element, index) {
        var option = document.createElement('option');
        option.appendChild(document.createTextNode(element.roomName));
        option.value = element.roomID;
        option.id = "options";
        document.getElementById('room').appendChild(option);


    }



    function renderRestofForm() {
        var x = "<?php echo $_SESSION["usercourse"]; ?>;"
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("course").value = this.responseText;
            }
        }
        xmlhttp.open("GET", "Request_Course.php?var=" + x, true);
        xmlhttp.send();
        document.getElementById("name").value = "<?php echo $_SESSION["fullName"]; ?>";
        document.getElementById("contact").value = "0" + "<?php echo $_SESSION["usercontactnumber"]; ?>";
    }
    //Description:
    //Changes contents of Room And Equipment list based on date (Due to availability)
     function eventTrigger() {
        let callReservations = callActiveReservations(async function(result){
            await disable(result);
            document.getElementById('wrapper').addEventListener('change', async function(event) {
                var elem = event.target;
                if (elem.id == 'startDate') {
                    startDate = document.getElementById('startDate').value
                }
                if (elem.id == 'durationDay') {
                    duration = document.getElementById('durationDay').value;
                }
                if (elem.id == 'startTime') {
                    startTime = elem.value;
                }
                if (elem.id == 'endTime') {
                    endTime = elem.value;
                }
                if (elem.id == 'startDate' || elem.id == 'durationDay' || elem.id == 'startTime' || elem.id == "endTime") {
                    if(endTime > startTime){
                    console.log('asd');
                    resetRoomList();
                    let x = await listRoom();
                    let y = await disable(result);
                    removeTB(true);
                    document.getElementById('endTimeErr').textContent = '';
                    }else{
                        document.getElementById('endTimeErr').textContent = 'End Time must be later than Start Time';
                    }           
                }
            })
        })
    }

    async function disable(result) {
        let promise = new Promise((resolve,reject)=>{
        var roomID = document.getElementById('room');
        array = [];
        roomArray = [];
        var counting = 0;
        var condition = true;
        try{
            resolve('success');
            for (var x = 0; x < result.length; x++) {
            var diffTime = new Date(result[x]['dateEnd']) - new Date(result[x]['dateStart']);
            var numberofloops = (diffTime == 0) ? 0 : Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            for (var i = 0; i <= numberofloops; i++) {
                var storedEnd = new Date(result[x]['dateStart'] + ' ' + result[x]['timeEnd']); //stored end B
                var storedStart = new Date(result[x]['dateStart'] + ' ' + result[x]['timeStart']); //stored start A
                storedEnd.setTime(storedEnd.getTime() + (3*60*60*1000));
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
        }catch(exception){
            reject(exception);
        }
        })
    }

    //Check if totalQty != 0
    function checkValue(){

    }

    //default max qty for no conflicting schedules

    async function resetRoomList() {
        var roomID = document.getElementById('room');
        var length = roomID.options.length - 1;
        for (var i = length; i >= 0; i--) {
            roomID.remove(i);
        }
        return;
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



    //Equipment related stuff
    //Checker if User wants to add equip or not
    function generateEquipmentList() {
        var mainDiv = document.getElementById("equipmentList");
        const cb = document.getElementById('equipmentCB');
        if (cb.checked) {
            generateTB();
        } else {
            removeTB();
        }
    }

    function generateTB() {
        var mainDiv = document.getElementById("equipmentList");
        var subDiv_1 = document.createElement('div');
        subDiv_1.id = 'subDiv_1';
        var select = document.createElement('select');
        var buttonAdd = document.createElement('input');
        //buttonAdd properties
        buttonAdd.name = 'buttonAdd';
        buttonAdd.type = 'button';
        buttonAdd.value = 'Add';
        buttonAdd.id = 'buttonAdd';
        buttonAdd.addEventListener('click', addEquipment);
        var space = document.createElement('br');
        //select properties
        select.id = "equipList";
        select.className = "equipListCN";
        select.addEventListener('change', checkIfSelectedIsAdded);
        mainDiv.appendChild(subDiv_1);
        subDiv_1.appendChild(select);
        subDiv_1.appendChild(buttonAdd);
        listEquip(true);
        //disableOnChange();
    }

    function addEquipment() {
        var mainDiv = document.getElementById("equipmentList");
        var select = document.getElementById('equipList');
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
        input_2.className = 'equipInput'
        input_2.readOnly = true;
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
        //label properties
        mainDiv.appendChild(subDiv_2);
        subDiv_2.appendChild(hiddenInput);
        subDiv_2.appendChild(input_2);
        subDiv_2.appendChild(input)
        subDiv_2.appendChild(buttonRemove);
        subDiv_2.appendChild(label);
        listEquip(false, hiddenInput, input, label);
        checkIfSelectedIsAdded();
        counter++;
    }

    function checkIfSelectedIsAdded() {
        var subDiv = document.querySelectorAll('.removableDiv');
        var select = document.getElementById('equipList');
        var buttonAdd = document.getElementById('buttonAdd');
        for (var i = subDiv.length - 1; i >= 0; i--) {
            if (subDiv[i].querySelector('.hiddenEquipInput').value == select.options[select.selectedIndex].value) {
                buttonAdd.disabled = true;
                break;
            } else {
                buttonAdd.disabled = false;
            }
        }
        if (select.options.length == counter) {
            buttonAdd.disabled = true;
        }
    }

    function removeTB(onChange) {
        var divsToRemove = document.querySelectorAll('.removableDiv');
        var subDivToRemove = document.getElementById('subDiv_1')
        if (subDivToRemove) {
            subDivToRemove.remove();
            if (divsToRemove.length > 0) {
                for (var i = divsToRemove.length - 1; i >= 0; i--) {
                    divsToRemove[i].remove();
                }
                const cb = document.getElementById('equipmentCB');
                cb.checked = false;
            }
            counter = 0;
        }

        if (onChange == true) {
            const cb = document.getElementById('equipmentCB');
            cb.checked = false;
            counter = 0;
        }
    }

    function removeSpecificTB() {
        var divsToRemove = document.querySelectorAll('.removableDiv');
        if (divsToRemove.length != 1) {
            this.parentElement.remove();
            counter--;
        } else {
            removeTB();
        }
        checkIfSelectedIsAdded();
    }

    function listEquip(generate, equipID, input, label) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var myObj = JSON.parse(this.responseText);
                var select = document.getElementById('equipList');
                if (generate == true) {
                    myObj.forEach(function(element, index) {
                        renderListEquip(select, element, index)
                    });
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
        var currentQty = element.equipQty;
        if (array.length != 0) {
            for (i = 0; i < array.length; i++) {
                if (equip.value == element.equipID) {
                    label.textContent = 'Max:' + currentQty;
                    if (equip.value == array[i]['equipID']) {
                        currentQty -= array[i]['qty'];
                        label.textContent = 'Max:' + currentQty;
                    } 
                }
            }
        } else {
            if (equip.value == element.equipID) {
                currentQty = element.equipQty;
                label.textContent = 'Max:' + currentQty;
            }
        }
        input.max = currentQty;
    }



    function renderListEquip(select, element, index) {
        var currentQty = element.equipQty;
        if (array.length != 0) {
            for (i = 0; i < array.length; i++) {
                if (element.equipID == array[i]['equipID']) {
                    console.log('asd1');
                        currentQty -= array[i]['qty'];
                        console.log(currentQty);
                }
            }
            if(currentQty != 0) {
                var option = document.createElement('option');
                option.appendChild(document.createTextNode(element.equipName));
                option.value = element.equipID;
                select.appendChild(option);
            }
        }else{
            var option = document.createElement('option');
                option.appendChild(document.createTextNode(element.equipName));
                option.value = element.equipID;
                select.appendChild(option);
        }
    }
</script>