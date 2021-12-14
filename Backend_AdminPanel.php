  <script>
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
      var categ = url_string.searchParams.get('category');
      var windowType = url_string.searchParams.get('window');
      var page_number;
      if (c != null) {
          if (categ == 'finished') {
              resList('archives'.c);
          } else if (categ == 'pending') {
              resList('pending', c);
          } else if (categ == 'user') {
              callReservationDetails(c);
          } else if (categ == 'registration') {
              regList(c);
          } else if (categ == 'equipment') {
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
      } else if (categ == 'notifUser') {
          callReservationDetails();
      }



      if (isAdmin == 0) {
          if (windowType == "Profile") {
              callUserDetails();
          } else if (windowType == "MyReservations") {
              callReservationDetails();
          }
      } else {
          if (windowType == "Profile") {
              callUserDetails();
          } else if (windowType == "MyReservations") {
              callReservationDetails();
          } else if (windowType == "UserRegistrations") {
              regList();
          } else if (windowType == "UserReservation") {
              resList('pending');
          } else if (windowType == "ContentEdit") {
              editTabContent();
          } else if (windowType == "Monitoring") {
              monitoringContent();
          } else if (windowType == 'Archives') {
              resList('archive');
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
          //    modal img code
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
          modalImg.className = 'modal-content';
          modalImg.id = 'img01';
          var boxClicked = false;
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
                              var i = 0;
                          };

                      })
                  }
                  boxClicked = true;
              }
          });
          modal.appendChild(span);
          modal.appendChild(modalImg);
          //Previous/next image
          if (path.length > 1) {
              var prev = document.createElement('span');
              prev.className = 'left';
              var next = document.createElement('span');
              next.className = 'right';
              prev.textContent = '<';
              next.textContent = '>';
              prev.addEventListener('click', function() {
                  i--;
                  if (i < 0) i = path.length - 1;
                  modalImg.src = path[i];
              })
              next.addEventListener('click', function() {
                  i++;
                  if (i == path.length) i = 0;
                  modalImg.src = path[i];
              })
              modal.appendChild(prev);
              modal.appendChild(next);
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
          var section = <?php echo $_SESSION['userSection']; ?>;
          var userID = <?php echo $_SESSION["userID"];?>;
          var xmlhttp = new XMLHttpRequest();
          xmlhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                  var myObj = JSON.parse(this.responseText);
                  profileContent(myObj.coursename, myObj.sectionname,myObj.isApproved);

              }
          }
          xmlhttp.open("GET", "/Request_Course.php?var=" + asd + '&section=' + section + '&userID=' + userID, true);
          xmlhttp.send();
      }

      function callReservationDetails(page_number = 1) {
          userID = <?php echo $_SESSION["userID"] ?>;
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
                      var x = [];
                      var motherDiv = document.createElement('div');
                      var list = document.createElement('li');
                      var page = document.createElement('div');
                      page.id = 'pages';
                      motherDiv.id = "currentUserReservation";
                      myObj.forEach(async function(element, index) {
                          let result = await reservationContent(motherDiv, userID, page, element, index);
                          motherDiv.appendChild(result[2]);
                          callReservationImage(result[1], result[0])
                      });
                      page.innerHTML = myObj[myObj.length - 1].pagination;
                      motherDiv.appendChild(page);
                  }
              }
          }
          xmlhttp.open("GET", "/Request_ReservationForUser.php?var=" + userID + '&page=' + page_number + '&window=' + windowType, true);
          xmlhttp.send();
      }

      function reservedEquipment(resID, mainDiv, userID, forUser, status, approval, typePending, notifID) {
          return new Promise(resolve => {
              var xmlhttp = new XMLHttpRequest();
              xmlhttp.onreadystatechange = async function() {
                  if (this.readyState == 4 && this.status == 200) {
                      var myObj = JSON.parse(this.responseText);
                      var list = document.createElement('div');
                      if (myObj.length == 0) {
                          mainDiv.innerHTML += '<h3> No Equipment Borrowed </h3>';

                      } else {
                          mainDiv.innerHTML += '<h3> Equipment Borrowed: </h3>';
                          myObj.forEach(async function(element, index) {
                              var x = await listEquipmentReserved(mainDiv, element, index);
                          });
                      }
                      var printingPanel = "'/Backend_printingPanel.php?id=" + resID + "'";
                      if (forUser) {
                          if (status != 1) {
                              if (approval == 2) {
                                  mainDiv.innerHTML += '<h4 class="pending"> Status:' + "Pending" + '</h4>';
                                  mainDiv.innerHTML += '<input class="header-btn btn" type="button" value="print" onclick="openNewTab('+printingPanel+')"> ';
                                  mainDiv.innerHTML += '<input type="button" class="decline header-btn btn" onclick="cancelReservation(' + resID + ')" value="Cancel">';
                                  mainDiv.innerHTML += '<hr class="hr">';
                              } else if (approval == 3) {
                                  mainDiv.innerHTML += '<h4 class="declined"> Status:' + "Declined" + '</h4>';
                                  mainDiv.innerHTML += '<input class="header-btn btn" type="button" value="print" onclick="openNewTab('+printingPanel+')"> ';
                                  mainDiv.innerHTML += '<input type="button" class="decline header-btn btn" onclick="cancelReservation(' + resID + ')" value="Cancel" disabled>';
                                  mainDiv.innerHTML += '<hr class="hr">';
                              } else if (approval == 1) {
                                  mainDiv.innerHTML += '<h4 class="accepted"> Status:' + "Accepted" + '</h4>';
                                  mainDiv.innerHTML += '<input class="header-btn btn" type="button" value="print" onclick="openNewTab('+printingPanel+')"> ';
                                  mainDiv.innerHTML += '<input type="button" class="decline header-btn btn" onclick="cancelReservation(' + resID + ')" value="Cancel" disabled>';
                                  mainDiv.innerHTML += '<hr class="hr">';
                              } else {
                                  mainDiv.innerHTML += '<h4 class="accepted"> Status:' + "Reservation is Over" + '</h4>';
                                  mainDiv.innerHTML += '<input class="header-btn btn" type="button" value="print" onclick="openNewTab('+printingPanel+')"> ';
                              }
                          } else {
                              mainDiv.innerHTML += '<h4 class="cancelled"> Status:' + "Cancelled" + '</h4>';
                              mainDiv.innerHTML += '<hr class="hr">';
                          }
                      }
                      if (typePending) {
                          //   mainDiv.innerHTML += '<textarea id="remarks" placeholder="Remarks"></textarea><br><br>';
                          var textarea = document.createElement('textarea');
                          textarea.className = 'remarks';
                          textarea.placeholder = "Remarks";
                          mainDiv.appendChild(textarea);
                          mainDiv.innerHTML += '<br><br><input type="button" class = "header-btn btn" value = "Accept" onclick = "AcceptReservation(' + resID + ',' + userID + ',' + notifID + ',' + textarea.textContent + ')">'
                          mainDiv.innerHTML += '<input type="button" class = "header-btn btn decline" value = "Decline" onclick = "DeclineReservation(' + resID + ',' + userID + ',' + notifID + ',' + textarea.textContent + ')">'
                      }
                      resolve('success');
                  }
              }
              xmlhttp.open("GET", "/Request_ReservationForUserEquipment.php?var=" + resID, true);
              xmlhttp.send();
          })
      }
      
      function openNewTab(url){
        window.open(url,'_blank').focus();
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

      function cancelReservation(eventID) {
          var xmlhttp = new XMLHttpRequest();
          xmlhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                  alert(this.responseText);
                  if (c == null) {
                      window.location.href = '/Window_Panel.php?window=MyReservations';
                  } else {
                      window.location.href = '/Window_Panel.php?window=&page=' + c + '&category=user'
                  }
                  callReservationDetails();
              }
          }
          xmlhttp.open("GET", "/Request_RemoveReservation.php?var=" + eventID, true);
          xmlhttp.send();
      }

      function editReservation(eventID) {
          var xmlhttp = new XMLHttpRequest();
          xmlhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                  alert(this.responseText);

                  callReservationDetails();
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
                  alert(this.responseText);
                  if (c == null) {
                      window.location.href = '/Window_Panel.php?window=UserRegistrations';
                  } else {
                      //window.location.href = ''
                  }

                  regList();
              }
          }
          xmlhttp.open("GET", "/Request_AcceptRegistration.php?var=" + user + "&remarks=" + remarks, true);
          xmlhttp.send();
      }

      //Decline Reservation
      function DeclineRegistration(user, remarks) {
          var remarks = document.getElementById('remarks').value;
          var xmlhttp = new XMLHttpRequest();
          xmlhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                  alert(this.responseText);

                  regList();
              }
          }
          xmlhttp.open("GET", "/Request_DeclineRegistration.php?var=" + user + "&remarks=" + remarks, true);
          xmlhttp.send();
      }

      function loadFinishedReservation(bigDiv, page, page_number) {
          var motherDiv = document.createElement('div');
          motherDiv.className = "userResContent";
          motherDiv.id = "resList";
          var xmlhttp = new XMLHttpRequest();
          xmlhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                  var myObj = JSON.parse(this.responseText);
                  if (myObj[0] == null) {
                      motherDiv.innerHTML = '<h3> No user reservation </h3?>';
                  } else {
                      myObj.forEach((element, index) => {
                          finishedReservationContent(motherDiv, 1, element, index);
                      })
                  }
              }
          }
          xmlhttp.open("GET", "/Request_AllReservations.php?page=" + page_number, true);
          xmlhttp.send();
          bigDiv.appendChild(motherDiv);
      }

      function loadPendingReservation(bigDiv, page, page_number) {
          var motherDiv = document.createElement('div');
          motherDiv.className = "userResContent";
          motherDiv.id = "resList";
          var xmlhttp = new XMLHttpRequest();
          xmlhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                  var myObj = JSON.parse(this.responseText);
                  if (myObj[0] == null) {
                      motherDiv.innerHTML = '<h3> No user reservation </h3?>';
                  } else {
                      myObj.forEach(async function(element, index) {
                          var x = await userReservationContent(motherDiv, page, element, index, 'pending');
                          motherDiv.appendChild(x[0]);
                          callReservationImage(x[2], x[1]);
                      });
                  }

              }
          }
          xmlhttp.open("GET", "/Request_unapprovedReservation.php?page=" + page_number, true);
          xmlhttp.send();
          bigDiv.appendChild(motherDiv);
      }
      // Accept Reservations
      function AcceptReservation(eventID, userID, notifID,textArea) {
          var xmlhttp = new XMLHttpRequest();
          xmlhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                  alert(this.responseText);
                  if (c == null) {
                      window.location.href = '/Window_Panel.php?window=UserReservation';
                  } else {
                      window.location.href = '/Window_Panel.php?window=&page=' + c + '&category=pending';
                  }
              }
          }
          xmlhttp.open("GET", "/Request_AcceptReservation.php?var=" + eventID + '&userID=' + userID + '&remarks=' + textArea + '&notifID=' + notifID, true);
          xmlhttp.send();
      }

      //Decline Reservation
      function DeclineReservation(eventID, userID, textArea, notifID) {
          var xmlhttp = new XMLHttpRequest();
          xmlhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                  alert(this.responseText);
                  if (c == null) {
                      window.location.href = '/Window_Panel.php?window=UserReservation';
                  } else {
                      window.location.href = '/Window_Panel.php?window=&page=' + c + '&category=pending';
                  }
              }
          }
          xmlhttp.open("GET", "/Request_DeclineReservation.php?var=" + eventID + '&userID=' + userID + '&remarks=' + textArea + '&notifID=' + notifID, true);
          xmlhttp.send();
      }

      function listUsers(mainDiv, type, page_number) {
          var xmlhttp = new XMLHttpRequest();
          xmlhttp.onreadystatechange = function() {
              var list = document.createElement('select');
              if (this.readyState == 4 && this.status == 200) {
                  var myObj = JSON.parse(this.responseText);
                  var page = document.createElement('div');
                  page.id = 'pages';
                  myObj.forEach(function(element, index) {
                      generateUserContent(mainDiv, type, element, index, page);
                  });
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
                  var page = document.createElement('div');
                  page.id = 'pages';
                  myObj.forEach(function(element, index) {
                      generatePolicies(mainDiv, type, element, index, ...Array(2), page);
                  });
                  addButton(type);
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
                  var page = document.createElement('div');
                  page.id = 'pages';
                  myObj.forEach(function(element, index) {
                      generateTabContent(mainDiv, type, element, index, ...Array(2), page)
                  });
                  addButton(type);
              }
          }
          xmlhttp.open("GET", "/Request_EquipmentListAndAvailability.php?page= " + page_number + '&window=' + windowType, true);
          xmlhttp.send();
      }

      function listCategPolicies(x, add, value) {
          var xmlhttp = new XMLHttpRequest();
          xmlhttp.onreadystatechange = async function() {
              if (this.readyState == 4 && this.status == 200) {
                  var myObj = JSON.parse(this.responseText);
                  if (add) {
                      await myObj.forEach(function(element, index) {
                          categoryPolicyList(x, element, index, value)
                      });
                  } else {
                      await myObj.forEach(function(element, index) {
                          categoryPolicyList(x, element, index, value);
                      });
                      for (a = 0; a < x.options.length; a++) {
                          if (value == x.options[a].innerHTML) {
                              x.selectedIndex = a;
                          }
                      }
                  }
              }
          }
          xmlhttp.open("GET", "/Request_CategoryPolicies.php", true);
          xmlhttp.send();
      }

      function listRoom(mainDiv, type, page_number) {
          var xmlhttp = new XMLHttpRequest();
          xmlhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                  var myObj = JSON.parse(this.responseText);
                  var page = document.createElement('div');
                  page.id = 'pages';
                  myObj.forEach(function(element, index) {
                      generateTabContent(mainDiv, type, element, index, ...Array(2), page);
                  });
                  addButton(type);
              }
          }
          xmlhttp.open("GET", "/Request_RoomListAndAvailability.php?page=" + page_number, true);
          xmlhttp.send();
      }

      function removePolicies(ID) {
          var xmlhttp = new XMLHttpRequest();
          xmlhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {

                  editTabContent();
                  var poliDiv = document.getElementById('polPanel');
                  var poliBtn = document.getElementById('polBtn');
                  polBtn.click('3', poliDiv);
              }
          }
          xmlhttp.open("GET", "/Request_RemovePolicies.php?var=" + ID, true);
          xmlhttp.send();
      }

      function removeEquipment(ID) {
          var xmlhttp = new XMLHttpRequest();
          xmlhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {

                  editTabContent();
                  var equipDiv = document.getElementById('equipPanel');
                  var equipBtn = document.getElementById('equipBtn');
                  equipBtn.click('2', equipDiv);
              }
          }
          xmlhttp.open("GET", "/Request_RemoveEquipment.php?var=" + ID, true);
          xmlhttp.send();

      }

      function removeRoom(ID) {
          var xmlhttp = new XMLHttpRequest();
          xmlhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {

                  editTabContent();
                  var roomDiv = document.getElementById('roomPanel');
                  var roomBtn = document.getElementById('roomBtn');
                  roomBtn.click('2', roomDiv);
              }
          }
          xmlhttp.open("GET", "/Request_RemoveRoom.php?var=" + ID, true);
          xmlhttp.send();

      }

      function addPoliciesQuery(name, desc) {
          var xmlhttp = new XMLHttpRequest();
          xmlhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {

                  editTabContent();
                  var poliDiv = document.getElementById('polPanel');
                  var poliBtn = document.getElementById('polBtn');
                  polBtn.click('3', poliDiv);
              }
          }
          xmlhttp.open("GET", "/Request_AddPolicies.php?name=" + name + '&desc=' + desc, true);
          xmlhttp.send();
      }

      function editUserQuery(availability, ID) {
          var eAvailability;
          if (availability) {
              eAvailability = 1;
          } else if (!availability) {
              eAvailability = 0;
          }
          var xmlhttp = new XMLHttpRequest();
          xmlhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {

              }
          }
          xmlhttp.open("GET", "/Request_EditUser.php?availability=" + eAvailability + '&ID=' + ID, true);
          xmlhttp.send();
      }

      function editPoliciesQuery(name, desc, ID) {
          //editPolicies
          var xmlhttp = new XMLHttpRequest();
          xmlhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {

              }
          }
          xmlhttp.open("GET", "/Request_EditPolicies.php?name=" + name + '&desc=' + desc + '&ID=' + ID, true);
          xmlhttp.send();
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
              if (this.readyState == 4 && this.status == 200) {}
          }
          xmlhttp.open("GET", "/Request_EditEquipList.php?name=" + name + '&quantity=' + quantity + '&desc=' + desc + '&availability=' + eAvailability + '&id=' + ID, true);
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
              if (this.readyState == 4 && this.status == 200) {}
          }
          xmlhttp.open("GET", "/Request_EditRoomList.php?name=" + name + '&cap=' + capacity + '&desc=' + desc + '&availability=' + eAvailability + '&id=' + ID, true);
          xmlhttp.send();
      }

      function callFinishedReservations(div) {
          var xmlhttp = new XMLHttpRequest();
          xmlhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                  var myObj = JSON.parse(this.responseText);
                  if (myObj[0] == null) {
                      div.innerHTML += '<h3> Reservations to be monitored:  </h3?>'
                      div.innerHTML += '<h3> No user reservation </h3>';
                  } else {
                      myObj.forEach(function(element, index) {
                          finishedReservationContent(div, 0, element, index);
                      });
                  }
              }
          }
          xmlhttp.open("GET", "/Request_FinishedReservations.php", true);
          xmlhttp.send();
      }


      function onLoad(ID, review) {
          var xmlhttp = new XMLHttpRequest();
          xmlhttp.onreadystatechange = async function() {
              if (this.readyState == 4 && this.status == 200) {
                  var div = document.getElementById('monitor' + ID);
                  var mainDiv = document.createElement('div');
                  mainDiv.id = 'subContents';
                  mainDiv.className = 'subClassName';
                  const myObj = await JSON.parse(this.responseText);
                  var fullName = myObj.firstName + ' ' + myObj.middleName + ' ' + myObj.lastName;
                  mainDiv.innerHTML = '<h4>Adviser: ' + myObj.eventAdviser + '</h4>';
                  mainDiv.innerHTML += '<h4>Full Name: ' + fullName + '</h4>';
                  const first = await loadRoomDetails(myObj.roomID, mainDiv, ID, myObj.userID, review)
                  div.appendChild(mainDiv);
              }

          }
          xmlhttp.open("GET", "/Request_SpecificReservation.php?r_ID=" + ID + '&isReviewed=' + review, true);
          xmlhttp.send();
      }

      function loadRoomDetails(roomID, mainDiv, ID, userID, review) {
          return new Promise(resolve => {
              var xmlhttp = new XMLHttpRequest();
              xmlhttp.onreadystatechange = async function() {
                  if (this.readyState == 4 && this.status == 200) {
                      var myObj = JSON.parse(this.responseText);
                      mainDiv.innerHTML += '<h4>Room Borrowed: ' + myObj.roomName + '</h4>';
                      const second = await loadEquipDetails(ID, mainDiv, userID, review);
                      resolve('success');
                  }
              }
              xmlhttp.open("GET", "/Request_SpecificRoom.php?var=" + roomID, true);
              xmlhttp.send();
          });

      }

      function loadEquipDetails(ID, mainDiv, userID, review) {
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
                          mainDiv.innerHTML += '<br><input type="button" value="Submit" id = "' + ID + '" onclick="submitRemark(' + ID + ',' + userID + ')" >'
                      }
                      callReservationImage(mainDiv,ID)
                      resolve('success');
                  }
              }
              xmlhttp.open("GET", "/Request_ReservationForUserEquipment.php?var=" + ID, true);
              xmlhttp.send();
          })
      }

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
                  alert(this.responseText)
                  monitoringContent();
              }
          }
          xmlhttp.open("GET", "/Request_EditFinishedReservation.php?var=" + btnID + "&remark=" + x.value + "&marked=" + marked + "&userID=" + userID, true);
          xmlhttp.send();
      }
      //ForEach Functions
      function profileContent(course, section,isApproved) {
          var fn = "<?php echo $_SESSION["fullName"]; ?>";
          var cn = <?php echo $_SESSION["usercontactnumber"]; ?>;
          var email = "<?php echo $_SESSION["email"]; ?>";
          var pass = "<?php echo $_SESSION["password"]; ?>";
          var userID = "<?php echo $_SESSION['user_ID']; ?>";
          var status;
          var div = document.createElement('div');
          div.id = "profContent";
          div.innerHTML = '<h3> Name: ' + fn + '</h3> <br> <h4> Course and Section: ' + course + ' ' + section + '<h4> <br>';
          div.innerHTML += '<h4> Email: ' + email + '<h4><br>';
          if(isApproved == 1){
            status = 'Accepted';
          }else if(isApproved == 2){
            status = 'Pending';
          }else if(isApproved == 3){
            status = 'Denied';
          }
          div.innerHTML += '<h4> Status: ' + status + '<h4><br>';
          // modal img code
          let x = callRegistrationImage(div, userID);
          document.getElementById("content").appendChild(div);
      }
      //HTML PART THAT LISTS THE EQUIPMENT IN THE WINDOW
      function listEquipmentReserved(mainDiv, element, index) {
          return new Promise(resolve => {
              var h4 = document.createElement('h4');
              h4.innerHTML += element.equipName + " Qty: " + element.qty;
              mainDiv.appendChild(h4);
              resolve('success');
              //   mainDiv.innerHTML += '<h4>' + element.equipName + ' Qty: ' + element.qty + '</h4>';
          })
      }

      //HTML PART THAT LISTS THE RESERVATIONS IN THE WINDOW
      async function reservationContent(motherDiv, userID, page, element, index) {
          return new Promise(async resolve => {
              var div = document.createElement('div')
              var date = new Date(element.dateStart + ' ' + element.timeStart);
              var diffTime = new Date(element.dateEnd) - new Date(element.dateStart);
              var numberofloops = (diffTime == 0) ? 1 : Math.ceil(diffTime / (1000 * 60 * 60 * 24));
              var startTime = tConvert(element.timeStart);
              var endTime = tConvert(element.timeEnd)
              div.id = "resContent";
              div.className = "resContent";
              div.innerHTML = '<h3 class="_edit"> Event:' + element.event + '</h3>';
              div.innerHTML += '<h3> Event Adviser:' + element.event + '</h3>';
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
              var x = await reservedEquipment(element.reservationID, div, userID, true, element.status, status, ...Array(1), element.notifID);
              var a = await new Promise(resolve => {
                  document.getElementById("content").appendChild(motherDiv)
                  resolve('success')
              });
              var s = await new Promise(resolve => {
                  motherDiv.appendChild(div);
                  resolve('success');
              });
              if (typeof(element.pagination) != undefined && element.pagination != null) {
                  page.innerHTML = element.pagination;
              }
              resolve([element.reservationID, div, page]);
          })
      }


      //HTML PART THAT LISTS THE REGISTRATION OF USERS
      function registrationContent(motherDiv, page, element, index) {
          var div = document.createElement('div')
          div.id = "userProfContent";
          div.className = "userProfContent";
          div.innerHTML += '<h3 class="_edit"> Name:' + element.firstName + '&nbsp' + element.middleName + '&nbsp' + element.lastName + '</h3>';
          div.innerHTML += '<h3> Course:' + element.course + '</h3>';
          var textarea = document.createElement('textarea');
          textarea.id = 'remarks';
          textarea.placeholder = "Remarks";
          div.appendChild(textarea);
          //   div.innerHTML += '<textarea id = "remarks" placeholder="Remarks"></textarea><br>';
          div.innerHTML += '<br><br><input type="button" class="header-btn btn" value="Accept" onclick="AcceptRegistration(' + element.user + ',' + textarea.textContent + ')">';
          div.innerHTML += '<input type="button" class="decline header-btn btn" onclick="DeclineRegistration(' + element.user + ',' + textarea.textContent + ')" value="Decline">';
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
          } else if (type == 'archive') {
              var bigDiv2 = document.createElement('div');
              bigDiv2.className = 'finishedDiv';
              bigDiv2.id = 'bigFinishedDiv';
              var label2 = document.createElement('h3');
              label2.textContent = 'Finished And Reviewed Reservations';
              bigDiv2.appendChild(label2);
              biggestDiv.appendChild(bigDiv2);
              loadFinishedReservation(bigDiv2, page, page_number);
          }
          bigcontent.appendChild(biggestDiv);
      }


      //HTML PART THAT LISTS THE RESERVATION OF ITS USERS
      async function userReservationContent(motherDiv, page, element, index, type) {
          return new Promise(async resolve => {
              var div = document.createElement('div');
              div.id = 'pendingContent'
              var date = new Date(element.dateStart + ' ' + element.timeStart);
              var diffTime = new Date(element.dateEnd) - new Date(element.dateStart);
              var numberofloops = (diffTime == 0) ? 1 : Math.ceil(diffTime / (1000 * 60 * 60 * 24));
              endTime = tConvert(element.timeEnd)
              startTime = tConvert(element.timeStart)
              div.innerHTML += '<h3> Event Adviser:' + element.event + '</h3>';
              div.innerHTML += '<h3> Room: ' + element.roomName + '</h3>';
              div.innerHTML += '<h3>Starting Date: ' + element.dateStart + " </h3>";
              div.innerHTML += '<h3>Time:' + startTime + ' to ' + endTime + " </h3>";
              div.innerHTML += '<h3>Duration:' + numberofloops + " day/s (Ends at: " + element.dateEnd + ") </h3>";
              if (type == 'pending') {
                  var x = await reservedEquipment(element.reservationID, div, element.userID, false, ...Array(2), true, element.notifID);
              } else if (type == 'finished') {
                  var x = await reservedEquipment(element.reservationID, div, element.userID, false, ...Array(2), false, element.notifID);
              }

              //   sideDiv.appendChild(sideInput);
              //   div.appendChild(sideDiv);
              if (typeof(element.pagination) != undefined && element.pagination != null) {
                  page.innerHTML = element.pagination;
              }
              motherDiv.appendChild(div);
              resolve([page, element.reservationID, div]);
          })
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
          equipInput.src = '/Assets/side-arrow.png';
          equipInput.addEventListener('click', async function() {
              await loadLists("1", equipDiv)
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
          roomInput.src = '/Assets/side-arrow.png';
          roomInput.addEventListener('click', async function() {
              await loadLists("2", roomDiv);
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
          polInput.src = '/Assets/side-arrow.png';
          polInput.addEventListener('click', async function() {
              await loadLists("3", polDiv)
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
          userInput.src = '/Assets/side-arrow.png';
          userInput.addEventListener('click', async function() {
              await loadLists("4", userDiv)
          })
          motherDiv.appendChild(userDiv);
          userDiv.appendChild(userList);
          userDiv.appendChild(userInput);
      }


      //HTML PART THAT DISPLAYS THE TABLE
      function loadLists(param, activeDiv, page_number = 1) {

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
                      div.append(table);
                      roomBtn = false;
                      listRoom(table, div.id, page_number);
                      turnOffOn(div);
                      active = true;
                      row1.appendChild(column1);
                      row1.appendChild(column2);
                      row1.appendChild(column3);
                      row1.appendChild(column4);
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


      //Call for policies instead of generateTabContent()
      function categoryPolicyList(list, element, index, value) {
          var option = document.createElement('option');
          option.textContent = element.ct_Name;
          option.value = element.ct_ID;
          list.appendChild(option);
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

          editBtn.src = "/Assets/c2.png";
          editBtn.addEventListener('click', function() {
              editContent(type, tr, this, element.userID);
          })

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
          if (add) {
              var input = document.createElement('input');
              input.type = 'text';
              input.setAttribute('list', 'policies');
              tdName.appendChild(input);
              var listName = document.createElement('datalist');
              listName.id = 'policies';
              listName.className = 'policyList'
              editBtn.src = '/assets/c2.png';
              editBtn.placeholder = "Apply";
              editBtn.addEventListener('click', function() {
                  editContent(type, tr, this, ...Array(1), add, btn)
              })
              removeBtn.addEventListener('click', function() {
                  tr.remove();
                  btn.disabled = false;
              });
              btn.disabled = true;
              editBtn.placeholder = 'Save';
              removeBtn.placeholder = 'Cancel';
              editBtn.src = '/assets/c2.png';
              removeBtn.src = '/assets/c1.png';
              checker = false;
              listCategPolicies(listName, add);
          } else {
              var listName = document.createElement('select');
              listCategPolicies(listName, ...Array(1), element.p_category);
              listName.className = 'policyList';
              listName.id = element.p_ID;
              editBtn.src = "/assets/c2.png";
              editBtn.addEventListener('click', function() {
                  editContent(type, tr, this, element.p_ID);
              })
              removeBtn.addEventListener('click', function() {
                  removePolicies(element.p_ID)
              });
              removeBtn.src = "/assets/c1.png";
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
          var inputName = document.createElement('input');
          inputName.id = 'contentName';
          tdName.appendChild(inputName);
          var tdQuantity = document.createElement('td');
          var inputQuantity = document.createElement('input');
          inputQuantity.id = 'contentQuantity';
          tdQuantity.appendChild(inputQuantity);
          var tdDesc = document.createElement('td');
          var inputDesc = document.createElement('input');
          inputDesc.id = 'contentDesc';
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
          tdAvailability.appendChild(checkbox);
          if (add) {
              btn.disabled = true;
              checkbox.disabled = false;
              editBtn.src = "/assets/c2.png";
              removeBtn.src = "/assets/c1.png";
              checker = false;
              checkbox.checked = true;
              disableButtons(this);
              editBtn.addEventListener('click', function() {
                  editContent(type, tr, this, ...Array(1), add, btn)
              })
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
                      editBtn.addEventListener('click', async function() {
                          await editContent(type, tr, this, element.roomID);
                      });
                      inputName.value = element.roomName;
                      inputDesc.value = element.roomDesc;
                      inputQuantity.value = element.roomCap;
                      removeBtn.addEventListener('click', function() {
                          removeRoom(element.roomID)
                      });
                      break;
                  case 'equipID':
                      editBtn.addEventListener('click', function() {
                          editContent(type, tr, this, element.equipID);
                      });
                      removeBtn.addEventListener('click', function() {
                          removeEquipment(element.equipID)
                      });
                      inputQuantity.value = element.equipQty;
                      inputName.value = element.equipName;
                      inputDesc.value = element.equipDesc;
                      break;
              }
              editBtn.src = "/assets/c2.png";
              removeBtn.src = "/assets/c1.png";

          }

          var pages = document.getElementById('pages');

          tdRemove.appendChild(editBtn);
          tdRemove.appendChild(removeBtn);
          tr.appendChild(tdName);
          tr.appendChild(tdQuantity)
          tr.appendChild(tdDesc);
          tr.appendChild(tdAvailability);
          tr.appendChild(tdRemove);
          mainDiv.appendChild(tr);
          if (typeof(element.pagination) != undefined && element.pagination != null) {
              page.innerHTML = element.pagination;
              mainDiv.appendChild(page);
          }
          /// tr.before(tdName,pages);
          //appending of element
      }



      function editContent(type, rowID, value, ID, add, btn) {
          if (type == 'policiesID') {
              var name = rowID.children[0].firstChild;
              var desc = rowID.children[1].firstChild;
              if (checker == true) {
                  name.disabled = false;
                  desc.disabled = false;
                  disableButtons(value);
                  checker = false;
              } else if (checker == false) {
                  if (add) {
                      btn.disabled = false;
                  }
                  name.disabled = true;
                  desc.disabled = true;
                  enableButtons(type, name, ...Array(1), desc, ...Array(1), ID, value, add);
              }
          } else if (type == 'userID') {
              var mark = rowID.children[1].firstChild;
              if (checker == true) {
                  mark.disabled = false;
                  disableButtons(value);
                  checker = false;
              } else if (checker == false) {
                  mark.disabled = true;
                  enableButtons(type, ...Array(2), mark, ...Array(1), ID, value, add);
              }
          } else {
              var name = rowID.children[0].firstChild;
              var quantity = rowID.children[1].firstChild;
              var desc = rowID.children[2].firstChild;
              var availability = rowID.children[3].firstChild;
              if (checker == true) {
                  name.disabled = false;
                  desc.disabled = false;
                  availability.disabled = false;
                  quantity.disabled = false;
                  disableButtons(value);
                  checker = false;
              } else if (checker == false) {
                  if (add) {
                      btn.disabled = false;
                  }
                  name.disabled = true;
                  desc.disabled = true;
                  availability.disabled = true;
                  quantity.disabled = true;
                  enableButtons(type, name, quantity, desc, availability, ID, value, add);
              }
          }

      }


      function enableButtons(type, name, quantity, desc, availability, ID, value, add) {
          var x = document.querySelectorAll('.editButton');
          for (a = 0; a < x.length; a++) {
              x[a].disabled = false;
          }
          if (add) {
              if (type == 'roomID') {
                  addRoomQuery(name.value, quantity.value, desc.value, availability.checked);
              } else if (type == 'equipID') {
                  addEquipQuery(name.value, quantity.value, desc.value, availability.checked);
              } else if (type == 'policiesID') {
                  addPoliciesQuery(name.value, desc.value);
              }
          } else {
              if (typeof(document.getElementById('addBtn')) == undefined && document.getElementById('addBtn') != null) document.getElementById('addBtn').disabled = true;
              if (type == 'roomID') {
                  editRoomQuery(name.value, quantity.value, desc.value, availability.checked, ID);
              } else if (type == 'equipID') {
                  editEquipQuery(name.value, quantity.value, desc.value, availability.checked, ID);
              } else if (type == 'policiesID') {
                  editPoliciesQuery(name.value, desc.value, ID);
              } else if (type == 'userID') {
                  editUserQuery(desc.checked, ID);
              }
              if (typeof(value) != undefined && value != null) {
                  value.value = "Edit";
              }
          }
          checker = true;
      }

      function disableButtons(value) {
          var x = document.querySelectorAll('.editButton');
          if (typeof(document.getElementById('addBtn')) == undefined && document.getElementById('addBtn') != null) document.getElementById('addBtn').disabled = true;
          for (a = 0; a < x.length; a++) {
              if (value != x[a]) {
                  x[a].disabled = true;
                  //changeimg of edit to apply
                  // value.value = 'Apply';
              }
          }
      }

      function addRoomQuery(name, quantity, desc, availability) {
          var eAvailability;
          if (availability) {
              eAvailability = 0;
          } else if (!availability) {
              eAvailability = 1;
          }

          var xmlhttp = new XMLHttpRequest();
          xmlhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {}
          }
          xmlhttp.open("GET", "/Request_AddRoom.php?name=" + name + '&desc=' + desc + '&quantity=' + quantity + '&avail=' + eAvailability, true);
          xmlhttp.send();

          editTabContent();
          var roomDiv = document.getElementById('roomPanel');
          var roomBtn = document.getElementById('roomBtn');
          roomBtn.click('2', equipDiv);
      }

      function addEquipQuery(name, quantity, desc, availability) {
          var eAvailability;
          if (availability) {
              eAvailability = 0;
          } else if (!availability) {
              eAvailability = 1;
          }

          var xmlhttp = new XMLHttpRequest();
          xmlhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {}
          }
          xmlhttp.open("GET", "/Request_AddEquipment.php?name=" + name + '&desc=' + desc + '&quantity=' + quantity + '&avail=' + eAvailability, true);
          xmlhttp.send();

          editTabContent();
          var equipDiv = document.getElementById('equipPanel');
          var equipBtn = document.getElementById('equipBtn');
          equipBtn.click('2', equipDiv);

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
      function monitoringContent() {
          var motherDiv = document.createElement('div');
          motherDiv.id = "monitoringContent";
          motherDiv.className = 'row';
          document.getElementById('content').appendChild(motherDiv);
          //format of monitoring
          callFinishedReservations(motherDiv);
      }

      function finishedReservationContent(div, review, element, index) {
          isClicked = false;
          var label = document.createElement('h3');
          label.id = 'eventName';
          label.className = 'block';
          var startTime = tConvert(element.timeStart);
          var endTime = tConvert(element.timeEnd);
          label.textContent = 'Event: ' + element.event;
          var space = document.createElement('br');
          var date = document.createElement('h3');
          date.id = 'EventDate';
          date.className = 'block';
          date.textContent = 'From: ' + startTime + ' to ' + endTime;
          var sideDiv = document.createElement('div');
          sideDiv.className = 'sidePanel';
          sideDiv.id = 'monitor' + element.reservationID;
          var sideInput = document.createElement('input');
          sideInput.className = 'openBtn';
          sideInput.type = 'image';
          sideInput.src = '/assets/side-arrow.png';
          sideInput.addEventListener('click', function() {
              loadContent(element.reservationID, review);
          })
          sideDiv.appendChild(label);
          sideDiv.appendChild(space);
          sideDiv.appendChild(date);
          sideDiv.appendChild(sideInput);
          div.appendChild(sideDiv);
      }

      function loadContent(ID, review) {
          if (isClicked) {
              if (activeID == ID) {
                  document.getElementById('subContents').remove();
                  isClicked = false;
              } else {
                  document.getElementById('subContents').remove();
                  onLoad(ID, review);
                  activeID = ID;
                  isClicked = true;
              }
          } else {
              onLoad(ID, review);
              isClicked = true;
              activeID = ID;
          }
      }

      function listEquipDetails(ID, mainDiv, element, index) {
          mainDiv.innerHTML += '<h4 class="equipID" placeholder = "EquipName">' + element.equipName + ':' + +element.qty + ' </h4>'
      }
  </script>