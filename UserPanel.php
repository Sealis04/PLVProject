<html>
    <head>
        <title>PLVRS</title>
        <link rel="icon" href="assets/plv.png">
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/UserPanel.css">
        <link rel="stylesheet" href="bootstrap-3.4.1-dist/bootstrap-3.4.1-dist/css/bootstrap.min.css">
        <script src="bootstrap-3.4.1-dist/bootstrap-3.4.1-dist/js/bootstrap.min.js"></script>
    </head>
    <body>
    <?php 
    include "db_connection.php";
    session_start();
    //check if user is logged in
    $_SESSION["state"]="true";
    if ($_SESSION['isAdmin']== true){
        header("location:adminPanel.php");
    }
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
            <br>
            <legend>My Account</legend>
            <div id = "list" class="side-nav">
                <ul>
                    <li><input class = "btns active" id = "myProfile" type="button" value="User Profile"></li>
                    <li><input class = "btns" id="myReservation" type="button " value="User Reservations"></li>
                  </ul>
            </div>
            <div class="big-contents">
                <div id="content">
                </div>        
            </div>
        </div>
        <?php require "UserPanelJS.php" ?>
        <link rel="stylesheet" href="css/UserPanel.css">
    </body>
</html>