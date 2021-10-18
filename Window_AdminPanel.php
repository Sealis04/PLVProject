<html>
    <head>
        <title>PLVRS</title>
        <link rel="icon" href="assets/plv.png">
        <meta charset="UTF-8">
        <link rel="stylesheet" href="bootstrap-3.4.1-dist/bootstrap-3.4.1-dist/css/bootstrap.min.css">
        <script src="bootstrap-3.4.1-dist/bootstrap-3.4.1-dist/js/bootstrap.min.js"></script>

        <link rel="stylesheet" href="css/AdminPanel.css">
    </head>
    <body>
    <?php 
    include "db_connection.php";
    session_start();
        ?>
        <nav id="head-container">
            <div class="navbar">
            <div class="nav1">
              <img id="fb" src="assets/plv.png" alt="PLV Logo">
              <a href="Window_HomePage.php" type="button" class="header-btn btn ">Home</a>
              <a href="Window_RoomAndEquipment.php" type="button" class="header-btn btn ">Rooms and Equipment</a>
              <a href="Window_PoliciesPage.php" type="button" class="header-btn btn">Policies</a>
            </div>
            <div class="nav2">
              <?php
            require "Backend_CheckifLoggedIN.php";
                ?>        
            </div>
        </div>
        </nav>

        <div class="container">
            <div id = "list" class="side-nav">
                <ul >
                <li><input type="button" id="myProfile" class="btns active" value = "My Profile"></li>
                <li><input type="button" id="myReservation" class="btns" value="My Reservation"></li>
                <li><input type="button" id="userProfile" class="btns" value="User Registrations"></li>
                <li><input type="button" id="userReservations" class="btns" value = "User Reservations"></li>
                <li><input type = "button" id = "editContents" class="btns" value = "Edit Content"></li>
                  </ul>
            </div>
            <div class="big-contents">
                <div class = "content" id="content">
                </div>  
    </div>
        </div>
        <?php require "Backend_AdminPanel.php";?>
        <?php require "Backend_Notification.php";?>
    </body>
</html>