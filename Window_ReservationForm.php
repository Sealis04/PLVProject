<html>

<head>
    <title>PLVRS</title>
    <link rel="icon" href="assets/plv.png">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="bootstrap-3.4.1-dist/bootstrap-3.4.1-dist/css/bootstrap.min.css">
    <script src="bootstrap-3.4.1-dist/bootstrap-3.4.1-dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/css/side-nav.css">
            <link rel="stylesheet" href="/bootstrap-4.1.3-dist/css/bootstrap.min.css">
    <script src="/bootstrap-4.1.3-dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/Form.css">
</head>

<body>

    <?php
    include "db_connection.php";
    include "Request_storeNotification.php";
    include "Request_CheckUserDetails.php";
    session_start();
    $conn = OpenCon();
    $min = Date("Y-m-d", strtotime('+3 days'));
    $minTime = '08:00';
    $maxTime = '17:00';
    $initialTime = '08:00';
    $initialTime_2 = '09:00';
    $uploadErr = ""; 
    //determine if admin
  
    ?>
    <sidenav>
        <?php
         if (isset($_SESSION['userID'])) {
         if ($_SESSION['user_verified'] == 'not verified') {
            echo '<script>
            alert("Please confirm the OTP that was sent to your Email!")
            window.location.href = "Window_OTP.php?code='.$_SESSION['user_code'].'"
            </script>';
        } else {
            require "Backend_CheckifLoggedIN.php";
             $remarks = checkDetails($_SESSION['userID']);
        if (isset($remarks)) {
            echo '<script>
            alert("'.$remarks.'.")
            window.location.href = "Window_HomePage.php"
            </script>';
        } else {
            if ($_SESSION["isAdmin"] == 1) {
                $approveID = 1;
            } else {
                $approveID = 2;
            }
        }
        }
    } else {
        echo '<script>
        alert("Please Log in first.")
        window.location.href = "index.php"
        </script>';
    }
        ?>
    </sidenav>
    <nav>
            <div class="navbar">
            <div class="nav2">
                  
            </div>
            </div>
        </nav>
    <div class="container">
        <div class="form-container shadow-lg p-3 mb-5 bg-white rounded">
        <form>
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="fullName" readOnly class="form-control" name="Name">
        </div>
        <div class="form-group">
                <label for="Course">Course:</label>
                <input type="text" class="form-control" readOnly name="Course">
                </div>
        </form>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data" id="reservationForm">
            </form>
        </div>
    </div>
    <?php
    require "Backend_ReservationForm.php";
    ?>
</body>
<!-- <link rel="stylesheet" href="/CSS/Form.css"> -->

</html>