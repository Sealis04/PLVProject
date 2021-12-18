<html>

<head>
  <link rel="stylesheet" href="css/side-nav.css">
</head>

</html>
<?php
$conn = OpenCon();
//check if user is logged in
if (isset($_SESSION["userID"])) {
  if ($_SESSION['isAdmin'] == 1) {
    include 'Backend_Notification.php';
    echo '<!--Content-->';
    echo '<div id="sidenav" class="sidenav">';
    echo '<img id="fb" src="assets/plv.png" alt="PLV Logo">';
    echo '<br>';
    echo '<a href="/Window_HomePage.php">Home</a>';
    echo '    <a href="/Window_RoomAndEquipment.php">Rooms and Equipment</a>';
    echo '    <a href="/Window_PoliciesPage.php">Policies</a>';;
    echo '<div id="notifDropdown" class="dropdown">';
    echo '    <a id="notif">Notification</a>';
    echo '<div id="notifList" class="dropdown-content">';
    echo '</div>';
    echo '</div>';
    echo '    <hr>';
    echo '    <a href="/Window_Panel.php?window=Profile" >My Profile</a>';
    echo '    <a href="/Window_Panel.php?window=MyReservations">My Reservation</a>';
    echo '    <a href="/Window_Panel.php?window=UserRegistrations">User Registration</a>';
    echo '    <a href="/Window_Panel.php?window=UserReservation">User Reservation</a>';
    echo '    <a href="/Window_Panel.php?window=ContentEdit">Edit Content</a>';
    echo '    <a href="/Window_Panel.php?window=Monitoring">Monitoring Form</a>';
    echo '    <a href="/Window_Panel.php?window=Archives">Archived Reservations</a>';
    echo '    <hr>';

    echo '    <a id="logout" href="/Backend_LOGOUT.php" type="button"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-left" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0v2z"/>
        <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
      </svg> Logout</a>';

    echo ' </div>';
  } else {
    include 'Backend_Notification.php';
    echo '<!--Content-->';
    echo '<div class="sidenav">';
    echo '<img id="fb" src="assets/plv.png" alt="PLV Logo">';
    echo '<br>';
    echo '<a href="/Window_HomePage.php">Home</a>';
    echo '    <a href="/Window_RoomAndEquipment.php">Rooms and Equipment</a>';
    echo '    <a href="/Window_PoliciesPage.php">Policies</a>';;
    echo '<div id="notifDropdown" class="dropdown">';
    echo '    <a id="notif">Notification</a>';
    echo '<div id="notifList" class="dropdown-content">';
    echo '</div>';
    echo '</div>';
    echo '    <hr>';
    echo '    <a href="/Window_Panel.php?window=Profile">My Profile</a>';
    echo '    <a href="/Window_Panel.php?window=MyReservations">My Reservation</a>';
    echo '    <hr>';

    echo '    <a id="logout" href="/Backend_LOGOUT.php" type="button"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-left" viewBox="0 0 16 16">
      <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0v2z"/>
      <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
    </svg> Logout</a>';

    echo ' </div>';
  }
} else {
  echo '<!--Content-->';
  echo '<div class="sidenav">';
  echo '<img id="fb" src="assets/plv.png" alt="PLV Logo">';
  echo '<br>';
  echo '<a href="/Window_HomePage.php">Home</a>';
  echo '<a href="/Window_RoomAndEquipment.php">Rooms and Equipment</a>';
  echo '<a href="/Window_PoliciesPage.php">Policies</a>';
  echo '    <a href="/Window_LOGIN.php"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
      <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z"/>
      <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
    </svg> Login</a>';
  echo '</div>';
  echo '</div>';
  echo ' </div>';

  //Include login button here
}
$conn->close();
?>
<script>
  var url = window.location.href;
  document.querySelectorAll('a').forEach(result => {
    if (result.pathname == '/Window_Panel.php') {
      if (result.search == window.location.search) {
        result.className += ' active';
      }
    } else if (result.pathname == window.location.pathname) {
      result.className += ' active';
    }
  })
</script>