<html>

<head>
    <title>PLVRS</title>
    <link rel="icon" href="assets/plv.png">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/registration.css">
    <link rel="stylesheet" href="bootstrap-3.4.1-dist/bootstrap-3.4.1-dist/css/bootstrap.min.css">
    <script src="bootstrap-3.4.1-dist/bootstrap-3.4.1-dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/otp.css">
</head>

<body>
    <?php
    session_start();
    if ( isset($_SESSION['user_verified']) && $_SESSION['user_verified']=='verified') {
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
                                    window.location.href = "/index.php"
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
        }else if(isset($_POST['resend'])){
            $userOTP = rand(100000,999999);
            $sql_code = "SELECT * FROM tbl_user WHERE user_activationcode = ?";
            if ($sql = $conn->prepare($sql_code)) {
                $sql->bind_param('s', $val);
                if ($sql->execute()) {
                    $result = $sql->get_result();
                    $user = $result->fetch_array(MYSQLI_ASSOC);
                    $sql_code3 = "UPDATE tbl_user SET user_otp = ? WHERE user_activationcode =?";
                    if ($sql3 = $conn->prepare($sql_code3)) {
                        $sql3->bind_param('is', $userOTP, $val);
                        if ($sql3->execute()) {
                            echo $user['user_email'];
                            sendOTP($userOTP,$user['user_email']);
                        }
                    }
                }
            }
            
        }
    } else {
        echo 'invalid URL';
    }
 function sendOTP($OTP,$email){
        $subject = 'PLVRS Registration Notification';
        $message_body = '
        <p>For verify your email address, enter this verification code when prompted: <b>'.$OTP.
        '</b>.</p>
        <p>Sincerely,</p>
        <p>Webslesson.info</p>
        ';
        $fromEmail = 'plvrs.gso@gmail.com';
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: ' . $fromEmail . '<' . $fromEmail . '>' . "\r\n" . 'Reply-To: ' . $fromEmail . "\r\n" . 'X-Mailer: PHP/' . phpversion();
        $message = '<!doctype html> <html lang="en">
          <head>
              <meta charset="UTF-8">
              <meta name="viewport"
                    content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
              <meta http-equiv="X-UA-Compatible" content="ie=edge">
              <title>Document</title>
          </head>
          <body>
          <span class="preheader" style="color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;">' . $message_body . '</span>
              <div class="container">
               ' . $message_body . '<br/>
                  Regards<br/>
                ' . $fromEmail . '
              </div>
          </body>
          </html>';
        // $mail->Body = $message_body;
        @mail($email, $subject, $message, $headers);
      }
    ?>
    <!--CHANGES-->
    <div class="nav2">
        <?php
        require "Backend_CheckifLoggedIN.php";
        ?>
    </div>

    <body>
          <div class="OTP">
                <h3>Security verification</h3>
                <p>To secure your account, please complete the following verification.</p>
                <p>Email verification code</p>
                    <div id="otpForm">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . '?' . $_SERVER['QUERY_STRING']); ?>" method="post">
                        <input id="tACode" name='OTPVal'>
                        <input  id="Resend" name='resend' type='submit' value="Resend"><label id="timer"></label>
                        <input  class="header-btn btn" id="submit" name='OTP' type='submit'>
                        </form>
                    </div>
            </div>
    </body>
    </body>
    <?php require "Backend_OTP.php";?>;
</html>