<script>
                    //lists equipment list
                    // Add active class to the current button (highlight it)
                    var header = document.getElementById("list");
                    var btns = header.getElementsByClassName("btns");

                    //calls default selected (ID with value x)
                    var x;
                        
                    for (var i = 0; i <= btns.length-1; i++) {
                        x = btns[0].id;
                        btns[i].addEventListener("click", function() {
                        var current = document.getElementsByClassName("active");
                        current[0].className = current[0].className.replace(" active", "");
                        this.className += " active";
                        var currID = current[0].id;
                        //Calls current values of roomname,desc,cap by returning roomIDvalue
                        var id = document.getElementById("equipment").id;
                        if(currID === id && document.getElementById("h1").textContent != "Equipment List"){
                        document.getElementById("h1").textContent="Equipment List";
                        document.getElementById("p1").textContent="";
                        callList(true);
                        }else if(currID != id){
                        callList(false);
                        var  xmlhttp = new XMLHttpRequest();
                        xmlhttp.onreadystatechange = function(){
                            if(this.readyState == 4 && this.status==200){
                                var myObj = JSON.parse(this.responseText);
                                document.getElementById("h1").textContent=myObj.roomName;
                                document.getElementById("p1").textContent=myObj.roomDesc;
                            }
                        }
                        xmlhttp.open("GET", "Request_ExistingSpecificRoom.php?var=" + currID, true);
                        xmlhttp.send();
                        }
                        });
                    }
                    var defaultClass = document.getElementById(x);
                       defaultClass.className += ' active';
                 
                    var  xmlhttp = new XMLHttpRequest();
                        xmlhttp.onreadystatechange = function(){
                            if(this.readyState == 4 && this.status==200){
                                var myObj = JSON.parse(this.responseText);
                                document.getElementById("h1").textContent=myObj.roomName;
                                document.getElementById("p1").textContent=myObj.roomDesc;
                            }
                        }
                        xmlhttp.open("GET", "Request_SpecificRoom.php?var=" + x, true);
                        xmlhttp.send();

                    function callList(result){
                        var  xmlhttp = new XMLHttpRequest();
                        xmlhttp.onreadystatechange = function(){
                            if(this.readyState ==4 && this.status==200){
                            var myObj = JSON.parse(this.responseText);
                            if(result == true){
                                myObj.forEach(renderEquipList);
                            }else if(result == false){
                               unRenderEquipList();
                            }else{
                                alert("ok what the fuck happened");
                            }
                            }
                        }
                        xmlhttp.open("GET", "Request_EquipmentList.php", true);
                        xmlhttp.send();
                    }
                    function renderEquipList(element, index){
                                var li = document.createElement('li');
                                li.setAttribute("class","works");
                                var p = document.createElement('p');
                                p.setAttribute("class","works");
                                var q = document.createElement('p');
                                q.setAttribute("class","works");
                                var space = document.createElement('br');
                                space.setAttribute("class","works");
                                document.getElementById("contentDiv").appendChild(li);
                                document.getElementById("contentDiv").appendChild(q);
                                document.getElementById('contentDiv').appendChild(p);
                                document.getElementById("contentDiv").appendChild(space);
                                q.textContent = "-" + element.equipQty;
                                li.textContent = element.equipName;
                                p.textContent = "-" +element.equipDesc;
                           }
                    function unRenderEquipList(){
                        var drop = document.getElementsByClassName("works");
                        while (drop.length> 0){
                            drop[0].parentNode.removeChild(drop[0]);
                        }
                    }


</script>    
