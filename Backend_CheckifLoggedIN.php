<?php 
    $conn = OpenCon();
   
  //check if user is logged in
  if(!isset($_SESSION["userID"])){
    echo '<a href="/Window_LOGIN.php" id"login" type=button class="header-btn btn">Log in</a>';
  }
  else{
    include 'Backend_Notification.php';
    echo '<a  href="/Window_AdminPanel.php"><img id="user" src="/assets/usericon.png"/></a>';
    echo '<div id="notifDropdown" class="dropdown">';
    echo '<img id="notif" src="/assets/notif.png"/>';
    echo '<div id="notifList" class="dropdown-content">';
    echo '</div>';
    echo '</div>';
    echo '<a href="/Backend_LOGOUT.php" type="button" class="header-btn btn">Log out</a>';
  }
$conn->close();


?>
