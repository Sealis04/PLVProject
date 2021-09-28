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
              <a href="HomePage.php" type="button" class="header-btn btn ">Home</a>
              <a href="RoomAndEquipment.php" type="button" class="header-btn btn ">Rooms and Equipment</a>
              <a href="Policies.php" type="button" class="header-btn btn">Policies</a>
            </div>
            <div class="nav2">
              <?php
            require "isLoggedInVerification.php";
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
                  </ul>
            </div>
            <div class="big-contents">
                <div class = "content" id="content">
                    <h2></h2>
                    <p></p>
                </div>  
    </div>
        </div>
        <?php require "AdminPaneLJS.php";?>
    </body>
</html>