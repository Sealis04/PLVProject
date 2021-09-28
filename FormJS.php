<script >
            resetWindow();
            renderRestofForm();
            listRoom();
            eventTrigger();
            var btn = document.getElementById('addBtn'); 
            btn.disabled=true;
            var counter = 0;
            var start;
            var end; 
            var reservedQty = 0;
            var availableQty = 0;

            function listEquip(equipmentID){
                var  xmlhttp = new XMLHttpRequest();
                        xmlhttp.onreadystatechange = function(){
                            if(this.readyState == 4 && this.status==200){
                                var myObj = JSON.parse(this.responseText);
                                var noOption = document.createElement('option');
                                noOption.appendChild(document.createTextNode('None'));
                                noOption.value=0;
                                document.getElementById(equipmentID).appendChild(noOption);
                                myObj.forEach(function(element,index){
                                    renderListEquip(equipmentID,noOption,element,index);
                                });
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
            function renderListEquip(equipmentID,noOption,element, index){                
                var option = document.createElement('option');
                option.appendChild(document.createTextNode(element.equipName));
                option.value = element.equipID;
               // document.getElementById(equipmentID).appendChild(noOption);
                document.getElementById(equipmentID).appendChild(option);
                //document.getElementById('equipment0').onchange=function(){getValue(this)};
            }

            

            function renderListRoom(element, index){                
                var option = document.createElement('option');
                option.appendChild(document.createTextNode(element.roomName));
                option.value = element.roomID;
                option.id="options";
                document.getElementById('room').appendChild(option);
            }

            
            function renderRestofForm(){
                var x = "<?php echo $_SESSION["usercourse"];?>;"
                var  xmlhttp = new XMLHttpRequest();
                        xmlhttp.onreadystatechange = function(){
                            if(this.readyState == 4 && this.status==200){
                                document.getElementById("course").value = this.responseText;
                            }
                        }
                        xmlhttp.open("GET", "getUserDetails.php?var=" + x, true);
                        xmlhttp.send();
                        document.getElementById("name").value = "<?php echo $_SESSION["fullName"];?>";
                        document.getElementById("contact").value="0" + "<?php echo $_SESSION["usercontactnumber"];?>";
                        }

            // function getValue(ID){
            //     var ID = ID || "can't get ID";
            //     var x = ID.value;
            //    btn = document.getElementById('addBtn'); 
            //    // var headerDiv = "equipment_list" + getValueCount;
            //     var headerDiv = document.getElementById('equipment_list');
            //     var secondHeader = headerDiv.getElementsByTagName('div');
            //             if(x == ""){
            //                 btn.disabled=true;
            //             }else{
            //                 btn.disabled=false;
            //             } 

            //     if(x==0){
            //         if(!(ID.id == "equipment0")){
            //             for(var i=0, len = secondHeader.length; i<len;i++){
            //                 if(headerDiv.getElementsByTagName('select')[i].id === ID.id){
            //                     secondHeader[i].parentNode.removeChild(secondHeader[i]);
            //                     counter--;
            //                 }
            //             }
            //         }
            //     }else{
            //         var  xmlhttp = new XMLHttpRequest();
            //             xmlhttp.onreadystatechange = function(){
            //                 if(this.readyState == 4 && this.status==200){
            //                    var myObj = JSON.parse(this.responseText);
            //                     for(var i=0;i<secondHeader.length;i++){
            //                         if(headerDiv.getElementsByTagName('select')[i].id === ID.id){
            //                             if(headerDiv.getElementsByTagName('input')[i].id == "input"){
            //                                 headerDiv.getElementsByTagName('input')[i].setAttribute('max',myObj.equipQty);
            //                                 console.log(headerDiv.getElementsByTagName('input')[i].id);
            //                             }
            //                         }
            //                     }

            //                 }  
            //             }
            //             xmlhttp.open("GET", "getEquipmentQty.php?var=" + x, true);
            //             xmlhttp.send();  
            //     }
               
            //         }
      
            function addFunction(){
                counter ++;
                btn.disabled = true;
                var select = document.createElement('select');
                select.id = "equipment"+counter;
                select.name="equipment[]";
                select.className="selectEquipment"
                var input = document.createElement('input');
                input.name='qty[]';
                input.type = 'number';
                input.min = 1;
                input.id="input";
                var space = document.createElement('br');
                var div = document.createElement('div');
                div.id = "equipment_list"+ counter;
               // document.getElementById('equipment_list').appendChild(space);
                document.getElementById('subHeadDiv').appendChild(div);
                div.appendChild(select);
                div.appendChild(input);
                makingListEquip(select);
                // defaultValue();
                //disabled on change
                // const selectOption = document.querySelectorAll('.selectEquipment');
                // selectOption.forEach(function(){
                //     let values = Array.from(selectOption).map(select=>select.value);
                //                         for (let select of selectOption){
                //                             select.querySelectorAll('option').forEach((option)=>{
                //                                 let value = option.value;
                //                                 if(value != 0&& value !== select.value && values.includes(value)){                    
                //                                     option.disabled=true;
                //                                 }else{
                //                                     option.disabled=false;
                //                                 }
                //                             });
                //                         }
                // })
                // selectOption.forEach((elem)=>{
                //     elem.addEventListener('change',(event)=>{
                //         let values = Array.from(selectOption).map(select=>select.value);
                //                         for (let select of selectOption){
                //                             select.querySelectorAll('option').forEach((option)=>{
                //                                 let value = option.value;
                //                                 if(value != 0 && value !== select.value && values.includes(value)){                    
                //                                     option.disabled=true;
                //                                 }else{
                //                                     option.disabled=false;
                //                                 }
                //                             });
                //                         }
                //     })
                // })
            }
            function makingListEquip(select){
                var list = document.getElementById('equipment0');
                if(typeof select == "object"){
                    for (var i=0; i<list.length; i++){
                    var options = document.createElement('option');
                    options.value = list.options[i].value;
                    options.appendChild(document.createTextNode(list.options[i].text));
                    select.appendChild(options);
                }
                }else if(typeof select == "number"){
                    var header = document.getElementById('equipment_list');
                    var second = header.getElementsByTagName('div');
                    var select2 = header.getElementsByTagName('select');
                    for(var i=0;i<select2.length;i++){
                        select2[i].remove(select);
                        if(select2[i].value == 0){
                            if(select2[i].id == "equipment0"){
                            }else{
                                second[i].remove();
                                counter--;
                            }
                        }
                    }
                }
  
            }

        //     function defaultValue(){
        //         var header = document.getElementById('equipment_list');
        //         var second = header.getElementsByTagName('div');
        //         var list = document.getElementById('equipment0');
        //         for(var i =0; i<second.length; i++){
        //             if(header.getElementsByTagName('select')[i].id != "equipment0"){
        //                 if(header.getElementsByTagName('select')[i].value == 0){
        //                     for(var a = 0; a<list.length;a++){
        //                         if(header.getElementsByTagName('select')[i-1].value != list.options[a].value){
        //                             header.getElementsByTagName('select')[i].value = list.options[a-(a-1)].value;
        //                             console.log(list.options[a-(a-2)].value);
        //                             console.log(a)
        //                         }
        //                     }
        //             }
        //         }
                  
        //     }
        // }
            
            // function middleMan(){
            //     var  xmlhttp = new XMLHttpRequest();
            //             xmlhttp.onreadystatechange = function(){
            //                 if(this.readyState == 4 && this.status==200){
            //                     var myObj = JSON.parse(this.responseText);
            //                     var roomID = document.getElementById('room');
            //                     var denied = [];
            //                     var approved = [];
            //                     if(typeof end === "undefined"){
            //                             var endTime = document.getElementById('endTime').value;
            //                             end = new Date(endTime).toISOString().split('T')[0]+' '+new Date(endTime).toTimeString().split(' ')[0];
            //                         }
            //                     if(typeof start === "undefined"){
            //                             var startTime= document.getElementById('startTime').value;
            //                             start =new Date(startTime).toISOString().split('T')[0]+' '+new Date(startTime).toTimeString().split(' ')[0];
            //                         } 
            //                             if(start >= end){
            //                                 document.getElementById('endErr').textContent="End must be later than start time."
            //                                 document.getElementById('submitBtn').disabled=true;
            //                             }else{
            //                                 document.getElementById('submitBtn').disabled=false;
            //                                 document.getElementById('endErr').textContent="";
            //                                 for(var i=0; i<myObj.length;i++){
            //                                if(!(end <= myObj[i]['start'] || start >= myObj[i]['end'])){
            //                                    //updating room list
            //                                    getQty(myObj,i,reservedQty);
            //                                     for(var a =0; a<roomID.length;a++){
            //                                         if(roomID.options[a].value == myObj[i]['room']){
            //                                             denied.push(a);
            //                                             roomID.remove(a);
            //                                         }
            //                                     }
            //                                     }else{
            //                                         //updating room list
            //                                         if(denied.length == 0){
            //                                         roomID.options.length=0;
            //                                         listRoom();
            //                                     }
            //                                     }
            //                                 }
            //                             }
            //                 }
            //             }
            //             xmlhttp.open("GET", "getAllReservationsTrue.php", true);
            //             xmlhttp.send();
            // }

            // function getQty(myObj,i,reservedQty){
            // var header = document.getElementById('equipment_list');
            // var second = header.getElementsByTagName('div');
            // var head = header.querySelectorAll('.selectEquipment')
            // head.forEach((elem)=>{
            //         for(let select of head){
            //             select.querySelectorAll('option').forEach((option)=>{
            //                 let value = option.value
            //                 if(myObj[i]['equipID'] == select.value && value == select.value){
            //                     console.log(select.value);
            //                     console.log(i);
                              
            //                 }
            //             })
            //         }
            // })
            // }
            // function startDate(value){
            //     start = new Date(value).toISOString().split('T')[0]+' '+new Date(value).toTimeString().split(' ')[0];
            //     middleMan();
               
            // }

            // function endDate(value){
            //         end = new Date(value).toISOString().split('T')[0]+' '+new Date(value).toTimeString().split(' ')[0];
            //     middleMan();
            // }
            
            function eventTrigger(){
                var roomID = document.getElementById('room');
                var header = document.getElementById('subHeadDiv');
                var second = header.getElementsByTagName('div');
                var select = header.getElementsByTagName('select');
                var input = header.getElementsByTagName('input');
                var denied =[];
                var deniedEquip=[];
                var list = document.getElementById('equipment0');
                    callActiveReservations(function (result){
                    document.getElementById('wrapper').addEventListener('change',function(event){
                    var elem = event.target; 
                    if(elem.id == "startTime"){
                        start = new Date(elem.value).toISOString().split('T')[0]+' '+new Date(elem.value).toTimeString().split(' ')[0];
                    }else if(typeof start == "undefined"){
                        var startTime= document.getElementById('startTime').value;
                        start =new Date(startTime).toISOString().split('T')[0]+' '+new Date(startTime).toTimeString().split(' ')[0];
                    }
                    if(elem.id == "endTime"){
                    end = new Date(elem.value).toISOString().split('T')[0]+' '+new Date(elem.value).toTimeString().split(' ')[0];
                    }else if(typeof end == "undefined"){
                    var endTime = document.getElementById('endTime').value;
                    end = new Date(endTime).toISOString().split('T')[0]+' '+new Date(endTime).toTimeString().split(' ')[0];
                    }
                    if(elem.id == "startTime" || elem.id == "endTime"){
                        document.getElementById("reservationForm").reset();
                        denied = [];
                        deniedEquip=[];  
                        disable(elem,roomID,result,denied,select,input,second,deniedEquip,list);      
                    }
                    if(elem.parentElement.parentElement.parentElement.id == "equipment_list"){
                        
                        disableAddBtn(elem,list);
                        //Might need to remove thi
                        disable(elem,roomID,result,denied,select,input,second,deniedEquip,list);      
                    }
                })
            });
            }

            function disableAddBtn(elem,list){
                var lastValue = list.options[list.options.length - 2].value;
                    if(elem.value == 0){
                        btn.disabled=true;
                    }else if(counter >= lastValue){
                        btn.disabled=true;
                    }else{
                        btn.disabled = false;
                    }
            }

            function disable(elem,roomID,result,denied,select,input,second,deniedEquip,list){
                //put loadDefaultQty here if no conflict schedules;
                if(start >= end){
                        document.getElementById('endErr').textContent="End must be later than start time."
                        document.getElementById('submitBtn').disabled=true;
                    }else{
                        document.getElementById('submitBtn').disabled=false;
                        document.getElementById('endErr').textContent="";
                        for(var i = 0; i<result.length;i++){
                            if(!(end <= result[i]['start'] || start >= result[i]['end'])){
                                for(var a = 0; a<roomID.length;a++){
                                    if(roomID.options[a].value == result[i]['room']){
                                       denied.push(a);
                                       roomID.remove(a);
                                    }
                                }
                                changeMaxQty(select,input,result,i,second,deniedEquip,list);
                            }else{
                                loadMaxQty(second,select,input)
                                if(elem.parentElement.parentElement.parentElement.id != "equipment_list"){
                                if(denied.length == 0){
                                roomID.options.length=0;
                                listRoom();
                                }
                                if(deniedEquip.length==0){
                                    for(var z = 0; z<select.length;z++){
                                        select[z].options.length=1;
                                        listEquip(select[z].id);
                                    }
                                }
                                break;
                                }
                            }
                        }
                    }
            }

            //adjusted max qty based on conflicting schedules
        function changeMaxQty(select,input,result2,i,second,deniedEquip,list){
            // for(var a =0; a<list.length;a++){
            //     if(list.options[a].value == result2[i]['equipID']){
            //         deniedEquip.push(result2[i]['equipID']);
            //         makingListEquip(result2[i]['equipID']);
            //     }
            // }
     
            // var list = document.getElementById('equipment0');
            // for(var a=0; a<second.length;a++){
            //     for(var i=0; i<list.length;i++){
                    
            //         console.log(list.options[i].value);
            //     }
            // }
                reservedQty = [];
                    for(var b =0; b<list.length - 1;b++){ 
                        callEquipmentQty(list.options[b].value,i, function(result,i){
                                if(result2[i]['equipID'] == result.equipID){
                                if(reservedQty[result.equipID]){
                                    reservedQty[result.equipID] += result2[i]['qty'];
                                }else{
                                    reservedQty[result.equipID] = result2[i]['qty'];
                                }
                                if(reservedQty[result.equipID] >= result.equipQty){
                                    deniedEquip.push(result2[i]['equipID']);
                                    makingListEquip(result2[i]['equipID']);
                                }else{
                                availableQty =  result.equipQty - reservedQty[result.equipID];  
                                for(var b=0;b<second.length;b++){
                                    console.log(select[b].value);
                                    console.log(result2[i]['equipID'])
                                    if(select[b].id){
                                        if(select[b].value == result2[i]['equipID']){
                                            input[b].setAttribute('max',availableQty);
                                           
                                        }
                                    }
                                }
                            }
                            }
                        })
                    }   
                   
            }
                

               
            //default max qty for no conflicting schedules
            function loadMaxQty(second,select,input){
                        for(var i=0;i<second.length;i++){
                            if(select[i].value != 0 ){
                                if(select[i].id){
                                callEquipmentQty(select[i].value,i, function (result,i){
                                    input[i].setAttribute('max',result.equipQty);
                                    input[i].setAttribute('value',1);
                                })
                            }
                            }else if(select[i].value==0){
                                if(second.length>1){
                                    if(second[i].id != "equipment0"){
                                        if(select[i].value == 0){
                                            second[i].remove();
                                            counter--;
                                        }
                                    }
                                }else{
                                input[i].removeAttribute('max');
                                input[i].setAttribute('value',"");
                                }
                                break;
                            }
                        }
                        
            }

            function callActiveReservations(callback){
                var  xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function(){
                    if(this.readyState == 4 && this.status==200){
                      if(callback){
                        
                          callback(JSON.parse(this.responseText));
                      }
                    }
                }
                xmlhttp.open("GET", "getAllReservationsTrue.php", true);
                xmlhttp.send();
            }     

            function callEquipmentQty(x,i,callback){
                if(x!=0){
                    var  xmlhttp = new XMLHttpRequest();
                        xmlhttp.onreadystatechange = function(){
                            if(this.readyState == 4 && this.status==200){
                                var myObj = JSON.parse(this.responseText);
                               if(callback){
                                   callback(JSON.parse(this.responseText),i);
                               }
                            }  
                        }
                        xmlhttp.open("GET", "getEquipmentQty.php?var=" + x, true);
                        xmlhttp.send();  
                }
                }


            function resetWindow(){
                if(document.getElementById("subHeadDiv")){
                    document.getElementById("subHeadDiv").remove();
                }
                var subHeadDiv = document.createElement('div');
                var subDiv = document.createElement('div');
                var select = document.createElement('select');
                var input = document.createElement('input');
                var button = document.createElement('button');
                input.type= "number";
                input.min = "1";
                input.name="qty[]";
                input.id = "input";
                button.onclick= function(){
                    addFunction();
                };
                button.id = "addBtn";
                button.textContent="Add";
                subHeadDiv.id = "subHeadDiv";
                subDiv.id = "equipment_list0";
                select.name = "equipment[]";
                select.id = "equipment0";
                select.className ="selectEquipment"
                subDiv.appendChild(select);
                subDiv.appendChild(input);
                subDiv.appendChild(button);
                document.getElementById("equipment_list").appendChild(subHeadDiv);
                subHeadDiv.appendChild(subDiv);
                listEquip('equipment0');
                
            }

//Some QOL of change notes:
//when changing dropdown selected, max qty doesn't change, fix it
//Trial code for trying to disable "NONE" on selects that isn't the last. 
                //     for(var i=0, len = secondHeader.length; i<len;i++){
                //     if(headerDiv.getElementsByTagName('select')[i].id != headerDiv.getElementsByTagName('select')[secondHeader.length - 1].id){
                //         const selectOption = document.querySelectorAll('.selectEquipment');
                //         selectOption.forEach(function(){
                //             for(let select of selectOption){
                //                 select.querySelectorAll('option').forEach((option)=>{
                //                     let value = option.value;
                //                     if(value === 0){
                //                     option.disabled = true;
                //                     }else{
                //                     option.disabled=false;
                //                     }
                //                 })
                //             }
                //         })
                //     }
                // }

//ADJUSTMENTS TOM (6/22/2021)

//ADJUST MAX VALUE WHEN DATE IS CHANGING
//SET DEFAULT MAX VALUE WHEN DATE IS CHANGING
//tl'dr, its like its 2 separate instances when theres a conflict and when there's not, make it a single one



//BUGS TO FIX
// CHANGE DATE, EQUIP TURNS TO NONE CHOSEN, ADDBTN IS ENABLED (MUST BE DISABLED);

//Todo tom
//Everychange of date resets equipment and value choices to make MY life easierw
</script>
        


