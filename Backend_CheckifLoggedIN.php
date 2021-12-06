<html>
  <head>
  <link rel="stylesheet" href="css/side-nav.css">
  </head>
</html>
<?php 
    $conn = OpenCon();
   
  //check if user is logged in
  if(isset($_SESSION["userID"])){
    if($_SESSION['isAdmin'] == 1){
      include 'Backend_Notification.php';
        echo'<!--Content-->';
        echo'<div id="sidenav" class="sidenav">';
        echo'<img id="fb" src="assets/plv.png" alt="PLV Logo">';
        echo'<br>';
        echo'<a href="/Window_HomePage.php">Home</a>';
        echo'    <a href="/Window_RoomAndEquipment.php">Rooms and Equipment</a>';
        echo'    <a href="/Window_PoliciesPage.php">Policies</a>';;
        echo '<div id="notifDropdown" class="dropdown">';
        echo'    <a id="notif">Notification</a>';
        echo '<div id="notifList" class="dropdown-content">';
        echo '</div>';
        echo '</div>';
        echo'    <hr>';
        echo'    <a href="/Window_Panel.php?window=Profile">My Profile</a>';
        echo'    <a href="/Window_Panel.php?window=MyReservations">My Reservation</a>';
        echo'    <a href="/Window_Panel.php?window=UserRegistrations">User Registration</a>';
        echo'    <a href="/Window_Panel.php?window=UserReservation">User Reservation</a>';
        echo'    <a href="/Window_Panel.php?window=ContentEdit">Edit Content</a>';
        echo'    <a href="/Window_Panel.php?window=Monitoring">Monitoring Form</a>';
        echo'    <hr>';
            
        echo'    <a id="logout" href="/Backend_LOGOUT.php" type="button"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
        <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
        </svg> Logout</a>';
          
        echo ' </div>';
    }else{
      include 'Backend_Notification.php';
      echo'<!--Content-->';
      echo'<div class="sidenav">';
      echo'<img id="fb" src="assets/plv.png" alt="PLV Logo">';
      echo'<br>';
      echo'<a href="/Window_HomePage.php">Home</a>';
      echo'    <a href="/Window_RoomAndEquipment.php">Rooms and Equipment</a>';
      echo'    <a href="/Window_PoliciesPage.php">Policies</a>';;
      echo '<div id="notifDropdown" class="dropdown">';
      echo'    <a id="notif">Notification</a>';
      echo '<div id="notifList" class="dropdown-content">';
      echo '</div>';
      echo '</div>';
      echo'    <hr>';
      echo'    <a href="/Window_Panel.php?window=Profile">My Profile</a>';
      echo'    <a href="/Window_Panel.php?window=MyReservations">My Reservation</a>';
      echo'    <hr>';
          
      echo'    <a id="logout" href="/Backend_LOGOUT.php" type="button"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
      <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
      <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
      </svg> Logout</a>';
        
      echo ' </div>';
    }
}else{
  include 'Backend_Notification.php';
      echo'<!--Content-->';
      echo'<div class="sidenav">';
      echo'<img id="fb" src="assets/plv.png" alt="PLV Logo">';
      echo'<br>';
      echo'<a href="/Window_HomePage.php">Home</a>';
      echo'    <a href="/Window_RoomAndEquipment.php">Rooms and Equipment</a>';
      echo'    <a href="/Window_PoliciesPage.php">Policies</a>';;
      echo '</div>';
      echo '</div>';
      echo ' </div>';

      //Include login button here
}
$conn->close();
?>

