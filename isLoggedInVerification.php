<?php 
    $conn = OpenCon();
  //check if user is logged in
  if(!isset($_SESSION["userID"])){
    echo '<a href="login.php" id=l"login" type=button class="header-btn btn">Log in</a>';
  }
  else{
    echo '<a  href="UserPanel.php"><img id="user" src="assets/usericon.png"/></a>';
    echo '<div class="dropdown">';
    echo '<a  href=""><img id="notif" src="assets/notif.png"/><span>1</span></a>';
    echo '<div class="dropdown-content">';
    echo '<p>Hello World!</p>';
    echo '</div>';
    echo '</div>';
    echo '<a href="Logout.php" type="button" class="header-btn btn">Log out</a>';
  }
$conn->close();
?>