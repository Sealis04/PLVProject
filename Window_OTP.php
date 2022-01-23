<html>

<head>
    <title>PLVRS</title>
    <link rel="icon" href="assets/plv.png">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/registration.css">
    <link rel="stylesheet" href="bootstrap-3.4.1-dist/bootstrap-3.4.1-dist/css/bootstrap.min.css">
    <script src="bootstrap-3.4.1-dist/bootstrap-3.4.1-dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/otp.css">
    <link rel="stylesheet" href="css/SpecificallyForModal.css">
    <script type="text/javascript" src="Backend_Modal.php"></script>
</head>

<body>
    <?php
    session_start();
    if (isset($_SESSION['user_verified']) && $_SESSION['user_verified'] == 'verified') {
        header("location: Window_HomePage.php");
        exit;
    }
    include "sendEmailLink.php";
    $conn = OpenCon();
    if (isset($_GET['code'])) {
        if (isset($_SESSION['user_code'])) {
            if ($_SESSION['user_code'] != $_GET['code']) {
                echo '<script>
           modal("Invalid User Access",function(){
               window.location.href="/index.php";
           })
            </script>';
            }
        }
        $val = $_GET['code'];
        if (isset($_POST['OTP'])) {
            if (empty($_POST['OTPVal'])) {
                echo '<script>
              modal("Please input a valid OTP value",function(){
              return;
            })

                </script>';
            } else {
                $input = $_POST['OTPVal'];
                $sql_code = "SELECT user_otp, user_timeStamp FROM tbl_user WHERE user_activationcode = ?";
                if ($sql = $conn->prepare($sql_code)) {
                    $sql->bind_param('s', $val);
                    if ($sql->execute()) {
                        $sql->store_result();
                        if ($sql->num_rows == 1) {
                            $sql->bind_result($userOTP, $userTimeStamp);
                            if ($sql->fetch()) {
                                date_default_timezone_set('Asia/Manila');
                                $currDate = date('Y-m-d h:i:s', time());
                                $date = strtotime($userTimeStamp) + (60 * 5);
                                $dbDate = date('Y-m-d h:i:s', $date);
                                if ($currDate <= $dbDate) {
                                    if ($input == $userOTP) {
                                        $sql_code2 = "UPDATE tbl_user SET user_verified = 'verified', user_activationcode = ?
                                            WHERE tbl_user.user_activationcode = ?";
                                        if ($sql2 = $conn->prepare($sql_code2)) {
                                            $usercode = null;
                                            $sql2->bind_param('ss', $usercode, $val);
                                            if ($sql2->execute()) {
                                                $_SESSION['user_verified'] = 'verified';
                                                echo '<script>
                                                    modal("Registration Successful! \n Status:Pending",function(){
                                                        window.location.href = "/index.php"
                                                      })
                                                    </script>';
                                            } else {
                                                echo $conn->error;
                                            }
                                        } else {
                                            echo $conn->error;
                                        }
                                        $sql2->close();
                                    } else {
                                        echo '<script>
                                              modal("Incorrect OTP",function(){
                                                return;
                                              })

                                                </script>';
                                    }
                                } else {
                                    echo '<script>
                                        modal("OTP has expired",function(){
                                            return;
                                          })
                                                </script>';
                                }
                            }
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
        echo '<script>
          modal("Invalid URL",function(){
            window.location.href = "/index.php";
          })
                                </script>';
    }
    ?>
    <!--CHANGES-->
    <nav>
        <div class="navbar">
            <div class="nav2">

            </div>
        </div>
    </nav>

    <body>
        <div class="OTP">
            <h3>Security verification</h3>
            <p>To secure your account, please complete the following verification.</p>
            <p>Email verification code</p>
            <div id="otpForm">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . '?' . $_SERVER['QUERY_STRING']); ?>" method="post">
                    <input id="tACode" name='OTPVal'>
                    <input id="resend" name='resendBtn' type='button' value="Resend"><label id="timer"></label>
                    <input class="header-btn btn" id="submit" name='OTP' type='submit'>
                </form>
            </div>
        </div>
    </body>
</body>
<?php
require "Backend_OTP.php";
?>;

</html>