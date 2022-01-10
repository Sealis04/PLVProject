<html>

<head>
    <title>PLVRS</title>
    <link rel="icon" href="assets/plv.png">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="bootstrap-3.4.1-dist/bootstrap-3.4.1-dist/css/bootstrap.min.css">
    <script src="bootstrap-3.4.1-dist/bootstrap-3.4.1-dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="bootstrap-4.1.3-dist/css/bootstrap.min.css">
    <script src="bootstrap-4.1.3-dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/AdminPanel.css">
    <link rel="stylesheet" href="css/SpecificallyForModal.css">
    <script type="text/javascript" src="Backend_Modal.php"></script>
</head>

<body>
    <?php
    include "db_connection.php";
    session_start();
    if (isset($_SESSION['userID'])) {
        if ($_SESSION['user_verified'] == 'not verified') {
            echo '<script>
            modal("Please confirm the OTP that was sent to your Email!",function(){
                window.location.href = "Window_OTP.php?code=' . $_SESSION['user_code'] . '"
            });
            </script>';
        } else {
            if ($_SESSION["isAdmin"] != 1) {
                if (!($_GET['window'] == 'Profile' || $_GET['window'] == 'MyReservations')) {
                    echo '<script>
                modal("Invalid User",function(){
                    window.location.href = "Window_HomePage.php"
                });
                </script>';
                }
            }
        }
    } else {
        echo '<script>
            modal("Please Log in first.",function(){
                window.location.href = "index.php"
            });
            </script>';
    }
    ?>
    <sidenav>
        <?php
            require "Backend_CheckifLoggedIN.php";
        ?>
    </sidenav>
    <nav>
        <div class="navbar">
            <div class="nav2">

            </div>
        </div>
        <mainbody class='main'>
            <div class="content big-contents shadow-lg p-3 mb-5 bg-white rounded" id='content'>
            </div>
        </mainbody>

        <?php require "Backend_AdminPanel.php"; ?>
        <link rel="stylesheet" href="/css/side-nav.css">
</body>

</html>