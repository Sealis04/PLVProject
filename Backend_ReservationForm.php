<script >
            generateEquipmentList();
            renderRestofForm();
            listRoom();
            eventTrigger();
            // var btn = document.getElementById('addBtn'); 
            // btn.disabled=true;
            var counter = 0;
            var start;
            var end; 
            var array= [];
            function listRoom(){
                var  xmlhttp = new XMLHttpRequest();
                        xmlhttp.onreadystatechange = function(){
                            if(this.readyState == 4 && this.status==200){
                                var myObj = JSON.parse(this.responseText);
                                // var noOption = document.createElement('option');
                                // noOption.appendChild(document.createTextNode('Please choose a room'));
                                // noOption.value = 0;
                                // noOption.id = 'options';
                                // document.getElementById("room").appendChild(noOption);
                                myObj.forEach(renderListRoom);
                            }
                        }
                        xmlhttp.open("GET", "Request_RoomList.php", true);
                        xmlhttp.send();
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
                        xmlhttp.open("GET", "Request_Course.php?var=" + x, true);
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
            //             xmlhttp.open("GET", "Request_QtyOfSpecifiedEquipment.php?var=" + x, true);
            //             xmlhttp.send();  
            //     }
               
            //         }
      
            // function addFunction(){
            //     counter ++;
            //     btn.disabled = true;
            //     var select = document.createElement('select');
            //     select.id = "equipment"+counter;
            //     select.name="equipment[]";
            //     select.className="selectEquipment"
            //     var input = document.createElement('input');
            //     input.name='qty[]';
            //     input.type = 'number';
            //     input.min = 1;
            //     input.id="input";
            //     var space = document.createElement('br');
            //     var div = document.createElement('div');
            //     div.id = "equipment_list"+ counter;
            //    // document.getElementById('equipment_list').appendChild(space);
            //     document.getElementById('subHeadDiv').appendChild(div);
            //     div.appendChild(select);
            //     div.appendChild(input);
            //     makingListEquip(select);
            //     // defaultValue();
            //     //disabled on change
                
            // }
            
            

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
            //             xmlhttp.open("GET", "Request_LatestReservations.php", true);
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
        
        //Description:
        //Changes contents of Room And Equipment list based on date (Due to availability)
            function eventTrigger(){            
                //var second = header.getElementsByTagName('div');
                //var select = header.getElementsByTagName('select');
               // var input = header.getElementsByTagName('input');
                    callActiveReservations(function (result){
                    disable(result);
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
                        denied = [];
                        disable(result); 
                        removeTB(true);
                    }
                })
            });
            }
            function disable(result){
                array = [];
                var roomID = document.getElementById('room');
                var counting = 0;
                 var condition = true;
                //put loadDefaultQty here if no conflict schedules;   
                if(start >= end){
                        document.getElementById('endErr').textContent="End must be later than start time."
                        document.getElementById('submitBtn').disabled=true;
                    }else{
                        document.getElementById('submitBtn').disabled=false;
                        document.getElementById('endErr').textContent="";
                        
                        for(var i = 0; i< result.length;i++){             
                            if(!(end <= result[i]['start'] || start >= result[i]['end'])){
                                for(var a = 0; a<roomID.length;a++){
                                    if(roomID.options[a].value == result[i]['room']){ 
                                    roomID.remove(a);
                                    }
                                }
                                array.push({equipID: result[i]['equipID'],qty:result[i]['qty']});
                               
                                }
                               //addEquipment is my callback.
                                condition = false;
                            }
                            }
                            if(condition){
                                roomID.options.length = 0;
                                listRoom();
                            }
                            
                            
                        }
                    

            //adjusted max qty based on conflicting schedules
       
                

               
            //default max qty for no conflicting schedules
            

            function callActiveReservations(callback){
                var  xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function(){
                    if(this.readyState == 4 && this.status==200){
                      if(callback){
                          callback(JSON.parse(this.responseText));
                      }
                    }
                }
                xmlhttp.open("GET", "Request_LatestReservations.php", true);
                xmlhttp.send();
            }     



            //Equipment related stuff
            //Checker if User wants to add equip or not
           function generateEquipmentList(){
            var mainDiv = document.getElementById("equipmentList");
            const cb = document.getElementById('equipmentCB');
            if(cb.checked){
                generateTB();
            }else{
                removeTB();
            }
           }
           function generateTB(){
            var mainDiv = document.getElementById("equipmentList");
            var subDiv_1 = document.createElement('div');
            subDiv_1.id = 'subDiv_1';
             var select  = document.createElement('select');
             var buttonAdd = document.createElement('input');
             //buttonAdd properties
             buttonAdd.name = 'buttonAdd';
             buttonAdd.type = 'button';
             buttonAdd.value = 'Add';    
             buttonAdd.id = 'buttonAdd';   
             buttonAdd.addEventListener('click',addEquipment);       
               var space = document.createElement('br');
               //select properties
               select.id = "equipList";
               select.className = "equipListCN";
               select.addEventListener('change',checkIfSelectedIsAdded);
                mainDiv.appendChild(subDiv_1);
                subDiv_1.appendChild(select);
                subDiv_1.appendChild(buttonAdd);
                listEquip(true);
                //disableOnChange();
            }

            function addEquipment(){
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
                buttonRemove.type ='button';
                buttonRemove.value = 'X';
                buttonRemove.addEventListener('click',removeSpecificTB)
                //label properties
                mainDiv.appendChild(subDiv_2);
                subDiv_2.appendChild(hiddenInput);
                subDiv_2.appendChild(input_2);
                subDiv_2.appendChild(input)
                subDiv_2.appendChild(buttonRemove);
                subDiv_2.appendChild(label);
                listEquip(false,hiddenInput,input,label);
                checkIfSelectedIsAdded();
                counter++;
            }
        
            function checkIfSelectedIsAdded(){
                var subDiv = document.querySelectorAll('.removableDiv');
                var select = document.getElementById('equipList');
                var buttonAdd = document.getElementById('buttonAdd');
                for(var i = subDiv.length - 1;i>=0;i--){
                        if(subDiv[i].querySelector('.hiddenEquipInput').value == select.options[select.selectedIndex].value){
                            buttonAdd.disabled = true;
                            break;
                        }else{
                            buttonAdd.disabled = false;
                        } 
                }
                if(select.options.length == counter){
                    buttonAdd.disabled=  true;
                }
            }
           
           function removeTB(onChange){
            var divsToRemove = document.querySelectorAll('.removableDiv');
            var subDivToRemove = document.getElementById('subDiv_1')
            if(subDivToRemove){
                subDivToRemove.remove();
            if(divsToRemove.length >0){
                for(var i = divsToRemove.length-1; i>=0;i--){
                divsToRemove[i].remove();
            }
            const cb = document.getElementById('equipmentCB');
                cb.checked = false;
            }
            counter = 0;
            }

            if(onChange == true){
                const cb = document.getElementById('equipmentCB');
                cb.checked = false;
                counter = 0;
            }
           }
           function removeSpecificTB(){
            var divsToRemove = document.querySelectorAll('.removableDiv');
               if(divsToRemove.length !=1){
                   this.parentElement.remove();
                   counter--;
               }else{
                   
                   removeTB();
  
               }
               checkIfSelectedIsAdded();
           }

            function listEquip(generate,equipID,input,label){
                var  xmlhttp = new XMLHttpRequest();
                        xmlhttp.onreadystatechange = function(){
                            if(this.readyState == 4 && this.status==200){
                                var myObj = JSON.parse(this.responseText);
                                var select = document.getElementById('equipList');  
                                if(generate == true){
                                    myObj.forEach(function(element,index){
                                    renderListEquip(select, element, index)}); 
                                }else{
                                    myObj.forEach(function(element,index){
                                        renderMaxQty(equipID,input,label,element, index)}); 
                                }                  
                            }
                        }
                        xmlhttp.open("GET", "Request_EquipmentList.php", true);
                        xmlhttp.send();
            }

             function renderMaxQty(equip,input,label,element, index){
                    if(array.length != 0){
                            for(i = 0; i<array.length;i++){
                                if(element.equipID == array[i]['equipID']){
                                    if(element.equipQty !== array[i]['qty']){    
                                        input.max = element.equipQty - array[i]['qty'];
                                        label.textContent = 'Max:' + input.max;
                                    }
                                }else{
                                    if(equip.value == element.equipID){
                                    input.max = element.equipQty;
                                    label.textContent = 'Max:' + element.equipQty;
                                    }
                                }
                            }
                    }else{
                    if(equip.value == element.equipID){
                    input.max = element.equipQty;
                    label.textContent = 'Max:' + element.equipQty;
                    }
                    }
        }


    
            function renderListEquip(select, element, index){
                var option = document.createElement('option');
                option.appendChild(document.createTextNode(element.equipName));
                option.value = element.equipID;
                select.appendChild(option);
                // document.getElementById(equipmentID).appendChild(option);
                if(array.length !=0){
                    for(i=0; i<array.length;i++){
                        if(element.equipID == array[i]['equipID']){
                            if(element.equipQty == array[i]['qty']){
                                option.remove(element.equipID);
                            }
                        }
                    }
                }
            }
          
            // function disableOnChange(){
            //     const selectOption = document.querySelectorAll('.equipListCN');
            //     selectOption.forEach(function(){  
            //         let values = Array.from(selectOption).map(select=>select.value);
            //                             for (let select of selectOption){
            //                                 select.querySelectorAll('option').forEach((option)=>{
            //                                     let value = option.value;
                                                
            //                                     //console.log(select.value);
            //                                     //console.log(values);    
            //                                     // if(value !== select.value && values.includes(value)){
            //                                     //     console.log(value);
            //                                     // //    for(i =0; i<(Math.max(value)); i++){
                                                    
            //                                     // //    }
            //                                     // }else{
            //                                     //     option.disabled=false;
            //                                     // }
            //                                     if(value == select.value && values.includes(value)){
            //                                        option.enabled = true;
            //                                     }else{
            //                                         option.disabled = false;
            //                                     }
            //                                 });
            //                             }
            //     })
            //     selectOption.forEach((elem)=>{
            //         elem.addEventListener('change',(event)=>{
            //             checkIfSelectedIsAdded();
            //             let values = Array.from(selectOption).map(select=>select.value);
            //                             for (let select of selectOption){
            //                                 select.querySelectorAll('option').forEach((option)=>{
            //                                     let value = option.value;
            //                                     if(value !== select.value && values.includes(value)){                    
            //                                         option.disabled=true;         
            //                                     }else{
            //                                         option.disabled=false;
            //                                     }
            //                                 });
            //                             }
            //         })
            //     })
            // }
  
//CODES ABOUT LISTING EQUIIPMENT

// function resetWindow(){
//                 if(document.getElementById("subHeadDiv")){
//                     document.getElementById("subHeadDiv").remove();
//                 }
//                 var subHeadDiv = document.createElement('div');
//                 var subDiv = document.createElement('div');
//                 var select = document.createElement('select');
//                 var input = document.createElement('input');
//                 var button = document.createElement('button');
//                 input.type= "number";
//                 input.min = "1";
//                 input.name="qty[]";
//                 input.id = "input";
//                 button.onclick= function(){
//                     addFunction();
//                 };
//                 button.id = "addBtn";
//                 button.textContent="Add";
//                 subHeadDiv.id = "subHeadDiv";
//                 subDiv.id = "equipment_list0";
//                 select.name = "equipment[]";
//                 select.id = "equipment0";
//                 select.className ="selectEquipment"
//                 subDiv.appendChild(select);
//                 subDiv.appendChild(input);
//                 subDiv.appendChild(button);
//                 document.getElementById("equipment_list").appendChild(subHeadDiv);
//                 subHeadDiv.appendChild(subDiv);
//                 listEquip('equipment0');
//             }

// function callEquipmentQty(x,i,callback){
//                 if(x!=0){
//                     var  xmlhttp = new XMLHttpRequest();
//                         xmlhttp.onreadystatechange = function(){
//                             if(this.readyState == 4 && this.status==200){
//                                 var myObj = JSON.parse(this.responseText);
//                                if(callback){
//                                    callback(JSON.parse(this.responseText),i);
//                                }
//                             }  
//                         }
//                         xmlhttp.open("GET", "Request_QtyOfSpecifiedEquipment.php?var=" + x, true);
//                         xmlhttp.send();  
//                 }
//                 }

// function loadMaxQty(second,select,input){
//                         for(var i=0;i<second.length;i++){
//                             if(select[i].value != 0 ){
//                                 if(select[i].id){
//                                 callEquipmentQty(select[i].value,i, function (result,i){
//                                     input[i].setAttribute('max',result.equipQty);
//                                     input[i].setAttribute('value',1);
//                                 })
//                             }
//                             }else if(select[i].value==0){
//                                 if(second.length>1){
//                                     if(second[i].id != "equipment0"){
//                                         if(select[i].value == 0){
//                                             second[i].remove();
//                                             counter--;
//                                         }
//                                     }
//                                 }else{
//                                 input[i].removeAttribute('max');
//                                 input[i].setAttribute('value',"");
//                                 }
//                                 break;
//                             }
//                         }
                        
//             }

// function changeMaxQty(select,input,result2,i,second,deniedEquip,list){
//             // for(var a =0; a<list.length;a++){
//             //     if(list.options[a].value == result2[i]['equipID']){
//             //         deniedEquip.push(result2[i]['equipID']);
//             //         makingListEquip(result2[i]['equipID']);
//             //     }
//             // }
     
//             // var list = document.getElementById('equipment0');
//             // for(var a=0; a<second.length;a++){
//             //     for(var i=0; i<list.length;i++){
                    
//             //         console.log(list.options[i].value);
//             //     }
//             // }
//                 reservedQty = [];
//                     for(var b =0; b<list.length - 1;b++){ 
//                         callEquipmentQty(list.options[b].value,i, function(result,i){
//                                 if(result2[i]['equipID'] == result.equipID){
//                                 if(reservedQty[result.equipID]){
//                                     reservedQty[result.equipID] += result2[i]['qty'];
//                                 }else{
//                                     reservedQty[result.equipID] = result2[i]['qty'];
//                                 }
//                                 if(reservedQty[result.equipID] >= result.equipQty){
//                                     deniedEquip.push(result2[i]['equipID']);
//                                     makingListEquip(result2[i]['equipID']);
//                                 }else{
//                                 availableQty =  result.equipQty - reservedQty[result.equipID];  
//                                 for(var b=0;b<second.length;b++){
//                                     console.log(select[b].value);
//                                     console.log(result2[i]['equipID'])
//                                     if(select[b].id){
//                                         if(select[b].value == result2[i]['equipID']){
//                                             input[b].setAttribute('max',availableQty);
                                           
//                                         }
//                                     }
//                                 }
//                             }
//                             }
//                         })
//                     }   
                   
//             }

// function disableAddBtn(elem,list){
//                 var lastValue = list.options[list.options.length - 2].value;
//                     if(elem.value == 0){
//                         btn.disabled=true;
//                     }else if(counter >= lastValue){
//                         btn.disabled=true;
//                     }else{
//                         btn.disabled = false;
//                     }
//             }



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
        


