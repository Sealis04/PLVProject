<html>
    <head>
        <title>PLVRS</title>
        <link rel="icon" href="assets/plv.png">
        <meta charset="UTF-8">
        <link rel="stylesheet" href="/bootstrap-3.4.1-dist/bootstrap-3.4.1-dist/css/bootstrap.min.css">
        <script src="/bootstrap-3.4.1-dist/bootstrap-3.4.1-dist/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="/CSS/AdminPanel.css">
    </head>
    <body>
    <?php 
    include "db_connection.php";
    session_start();
        ?>
            <sidenav>
              <?php
            require "Backend_CheckifLoggedIN.php";
                ?>        
            </sidenav>

        <!-- <div class="container">
            <div id = "list" class="side-nav">
                <ul >
                <li><input type="button" id="myProfile" class="btns tab " value = "My Profile"></li>
                <li><input type="button" id="myReservation" class="btns tab" value="My Reservation"></li>
                <?php
                if($_SESSION['isAdmin'] == 1){
                ?>
                <li><input type="button" id="userProfile" class="btns tab" value="User Registrations"></li>
                <li><input type="button" id="userReservations" class="btns tab" value = "User Reservations"></li>
                <li><input type = "button" id = "editContents" class="btns tab" value = "Edit Content"></li>
                <li><input type = "button" id = "monitoringForm" class="btns tab" value = "Monitoring Form"></li>

                <?php }
                ?>
                  </ul>
            </div>
           
        </div> -->
        <mainbody class='main'>
        <div class="content big-contents" id='content'>
            </div>
        </mainbody>
     
        <?php require "Backend_AdminPanel.php";?>
        <?php require "Backend_Notification.php";?>
        <link rel="stylesheet" href="/css/side-nav.css">
    </body>
  
</html>