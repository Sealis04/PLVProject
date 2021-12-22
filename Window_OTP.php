<html>

<head>
    <title>PLVRS</title>
    <link rel="icon" href="assets/plv.png">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/registration.css">
    <link rel="stylesheet" href="bootstrap-3.4.1-dist/bootstrap-3.4.1-dist/css/bootstrap.min.css">
    <script src="bootstrap-3.4.1-dist/bootstrap-3.4.1-dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/registration.css">
</head>

<body>
    <?php
    session_start();
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
        header("location: Window_HomePage.php");
        exit;
    }
    include "db_connection.php";
    $conn = OpenCon();
    if (isset($_GET['code'])) {
        $val = $_GET['code'];
        if (isset($_POST['OTP'])) {
            if (empty($_POST['OTPVal'])) {
                echo 'ENTER OTP NUMBER';
            } else {
                $input = $_POST['OTPVal'];
                $sql_code = "SELECT * FROM tbl_user WHERE user_activationcode = ?";
                if ($sql = $conn->prepare($sql_code)) {
                    $sql->bind_param('s', $val);
                    if ($sql->execute()) {
                        $result = $sql->get_result();
                        $user = $result->fetch_array(MYSQLI_ASSOC);
                        if ($input == $user['user_otp']) {
                            $sql_code2 = "UPDATE tbl_user SET user_verified = 'verified'
                                WHERE tbl_user.user_activationcode = ?";
                            if ($sql2 = $conn->prepare($sql_code2)) {
                                $sql2->bind_param('s', $val);
                                if ($sql2->execute()) {
                                    echo '<script>
                                    alert("Registration Successful! \n Status:Pending")
                                    window.location.href = "/Window_LOGIN.php"
                                    </script>';
                                } else {
                                    echo $conn->error;
                                }
                            } else {
                                echo $conn->error;
                            }
                            $sql2->close();
                        } else {
                            echo 'Incorrect OTP';
                        }
                    } else {
                        echo "Something went wrong";
                        echo $conn->error;
                    }
                    $sql->close();
                }
            }
        }
    } else {
        echo 'invalid URL';
    }

    ?>
    <!--CHANGES-->
    <div class="nav2">
        <?php
        // require "Backend_CheckifLoggedIN.php";
        ?>
    </div>

    <body>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . '?' . $_SERVER['QUERY_STRING']); ?>" method="post">
            <input name='OTPVal'>
            <input name='OTP' type='submit'>
        </form>
    </body>
    <?php
    require 'Backend_OTPCheck.php';
    ?>

</html>