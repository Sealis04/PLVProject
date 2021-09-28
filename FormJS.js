            listEquip();
            listRoom();
            renderRestofForm();
            function listEquip(){
                var  xmlhttp = new XMLHttpRequest();
                        xmlhttp.onreadystatechange = function(){
                            if(this.readyState == 4 && this.status==200){
                                var myObj = JSON.parse(this.responseText);
                                myObj.forEach(renderListEquip);
                            }
                        }
                        xmlhttp.open("GET", "getEquipmentlist.php", true);
                        xmlhttp.send();
            }
            function listRoom(){
                var  xmlhttp = new XMLHttpRequest();
                        xmlhttp.onreadystatechange = function(){
                            if(this.readyState == 4 && this.status==200){
                                var myObj = JSON.parse(this.responseText);
                                myObj.forEach(renderListRoom);
                            }
                        }
                        xmlhttp.open("GET", "getRoomList.php", true);
                        xmlhttp.send();
            }
            function renderListEquip(element, index){                
                var option = document.createElement('option');
                option.appendChild(document.createTextNode(element.equipName));
                option.value = element.equipID;
                document.getElementById('equipment').appendChild(option);
            }

            function renderListRoom(element, index){                
                var option = document.createElement('option');
                option.appendChild(document.createTextNode(element.roomName));
                option.value = element.roomID;
                document.getElementById('room').appendChild(option);
            }

            function renderRestofForm(){
                alert("asdasdasd");
            document.getElementById("name").value = $_SESSION["fullName"];
            document.getElementById("course").value = $_SESSION["usercourse"];
            document.getElementById("contact").value="0" + $_SESSION["usercontact"];
            }

        