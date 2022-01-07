
<html>

<head>
    <title>PLVRS</title>
    <link rel="icon" href="assets/plv.png">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="bootstrap-3.4.1-dist/bootstrap-3.4.1-dist/css/bootstrap.min.css">
    <script src="bootstrap-3.4.1-dist/bootstrap-3.4.1-dist/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="css/Policies.css">
</head>

<body>
    <?php
    include "db_connection.php";
    session_start();
    ?>
    <nav id="head-container">
        <div class="navbar">

                <?php
        if ($_SESSION['user_verified'] == 'not verified') {
            echo '<script>
            alert("Please confirm the OTP that was sent to your Email!")
            window.location.href = "Window_OTP.php?code='.$_SESSION['user_code'].'"
            </script>';
        } else {
            require "Backend_CheckifLoggedIN.php";
        }
                ?>
        </div>
    </nav>
    <div class="container">
        <legend>Policies</legend>
        
    </div>

    <div class="container col-sm-9 col-lg-8">
        <div id = 'policies' class="policy">
        </div>
        <?php require 'Backend_PoliciesPage.php' ?>
</body>

</html>