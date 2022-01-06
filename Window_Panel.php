<html>
    <head>
        <title>PLVRS</title>
        <link rel="icon" href="assets/plv.png">
        <meta charset="UTF-8">
        <link rel="stylesheet" href="/bootstrap-3.4.1-dist/bootstrap-3.4.1-dist/css/bootstrap.min.css">
        <script src="/bootstrap-3.4.1-dist/bootstrap-3.4.1-dist/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="css/AdminPanel.css">
    </head>
    <body>
    <?php 
    include "db_connection.php";
    session_start();
      if (isset($_SESSION['userID'])) {
             if ($_SESSION['user_verified'] == 'not verified') {
            echo '<script>
            alert("Please confirm the OTP that was sent to your Email!")
            window.location.href = "Window_OTP.php?code='.$_SESSION['user_code'].'"
            </script>';
        } else {
             if ($_SESSION["isAdmin"] != 1) {
            if(!($_GET['window'] == 'Profile' || $_GET['window'] == 'MyReservations')){
                echo '<script>
                alert("Invalid User")
                 window.location.href = "Window_HomePage.php"
                </script>';
        } 
      } 
        }
       
      }else {
            echo '<script>
            alert("Please Log in first.")
            window.location.href = "index.php"
            </script>';
        }
        ?>
            <sidenav>
                 <?php 
                 if ($_SESSION['user_verified'] == 'verified') {
                    require "Backend_CheckifLoggedIN.php";
                    } ?>
            </sidenav>
        <mainbody class='main'>
        <div class="content big-contents col-sm-10" id='content'>
            </div>
        </mainbody>
     
        <?php require "Backend_AdminPanel.php";?>
        <link rel="stylesheet" href="/css/side-nav.css">
    </body>
  
</html>