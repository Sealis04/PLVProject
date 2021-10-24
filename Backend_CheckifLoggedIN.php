<?php 
    $conn = OpenCon();
    echo '<link rel="stylesheet" type="text/css" href="css/notif.css">';
    include 'Backend_Notification.php';
  //check if user is logged in
  if(!isset($_SESSION["userID"])){
    echo '<a href="Window_LOGIN.php" id=l"login" type=button class="header-btn btn">Log in</a>';
  }
  else{
    echo '<a  href="Window_UserPanel.php"><img id="user" src="assets/usericon.png"/></a>';
    echo '<div id="notifDropdown" class="dropdown" >';
    echo '<img id="notif" src="assets/notif.png"/>';
    echo '<div id="notifList" class="dropdown-content" style="width:470%;margin-top:85px;">';
    echo '<div class="row">';
       // New Req
       echo '<div class="row">';
       echo      '<div class="column">';
       echo        '<button id="markAsRead" type="button"><img id="_notif" src="Assets/a_m_a.png">Mark as read</button>';
       echo      '</div>';
       echo '</div>';
       //
    echo      '<div class="column">';
    echo        '<img id="_notif" src="Assets/a_notif.png">';
    echo      '</div>';
    echo      '<div class="column">';
    echo        '<p id="name">Alex Martinez requested a reservation.</p>';
    echo        '<p id="c_event">Dance lab competition LR 301 </p>';
    echo        '<p id="date">October 24, 2021 10:00 AM - 6:00 PM</p>';
    echo      '</div>';
    echo '</div>';
    // New Req
    echo '<div class="row">';
    echo      '<div class="column">';
    echo        '<img id="_notif" src="Assets/a_accept.png">';
    echo      '</div>';
    echo      '<div class="column">';
    echo        '<p id="name">Alex Martinez requested a reservation.</p>';
    echo        '<p id="c_event">Dance lab competition LR 301 </p>';
    echo        '<p id="date">October 24, 2021 10:00 AM - 6:00 PM</p>';
    echo      '</div>';
    echo '</div>';
    // New Req
    echo '<div class="row">';
    echo      '<div class="column">';
    echo        '<img id="_notif" src="Assets/a_cancel.png">';
    echo      '</div>';
    echo      '<div class="column">';
    echo        '<p id="name">Alex Martinez requested a reservation.</p>';
    echo        '<p id="c_event">Dance lab competition LR 301 </p>';
    echo        '<p id="date">October 24, 2021 10:00 AM - 6:00 PM</p>';
    echo      '</div>';
    echo '</div>';
    //
    echo '</div>';
    echo '</div>';
    echo '<a href="Backend_LOGOUT.php" type="button" class="header-btn btn">Log out</a>';
  }
$conn->close();


?>
