<html>

<head>
    <title>PLVRS</title>
    <link rel="icon" href="assets/plv.png">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="bootstrap-3.4.1-dist/bootstrap-3.4.1-dist/css/bootstrap.min.css">
    <script src="bootstrap-3.4.1-dist/bootstrap-3.4.1-dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/Resetpw.css">
    <link rel="stylesheet" href="css/SpecificallyForModal.css">
    <script type="text/javascript" src="Backend_Modal.php"></script>
</head>

<body>
    <?php
    include "db_connection.php";
    session_start();
    $conn = OpenCon();
    if(isset($_GET['forget'])){
        if(!$_GET['forget']){
            if(!isset($_SESSION['user_ID'])){
              echo '<script> 
              modal("Please login First!",function(){
                window.location.href = "index.php"
                });
              </script>';
        } 
        }
    }
       
     if($_GET['forget'] == 'false'){
          if (isset($_GET['code']) && isset($_GET['userID'])) {
            $sql_code2 = "SELECT `user_activationcode`, `user_timeStamp` FROM `tbl_user` WHERE `user_ID` = ?";
            if ($sql2 = $conn->prepare($sql_code2)) {
                $sql2->bind_param('i', $_GET['userID']);
                if ($sql2->execute()) {
                    $sql2->store_result();
                    if ($sql2->num_rows == 1) {
                      $sql2->bind_result($usercode,$sentTime);
                        if ($sql2->fetch()) {
                             date_default_timezone_set('Asia/Manila');
                            $currDate = date('Y-m-d h:i:s', time());
                            $date = strtotime($sentTime) + (60 * 5);
                            $dbDate = date('Y-m-d h:i:s', $date);
                        if($currDate <= $dbDate){
                            if (password_verify($usercode, $_GET['code'])) {
                               if (isset($_POST['submit'])) {
                                      if (empty($_POST['old']) || (empty($_POST['new'])) || (empty($_POST['confirm']))) {
                                    echo '<script> 
                                    modal("Please fill up all blank inputs before proceeding",function(){
                                        return;
                                        });
                                    </script>';
                                } else {
                                    $sql_code3 = "SELECT `user_password` FROM `tbl_user` WHERE `user_ID` = ?";
                                    if ($sql3 = $conn->prepare($sql_code3)) {
                                        $sql3->bind_param('i', $_GET['userID']);
                                        if ($sql3->execute()) {
                                            $sql3->store_result();
                                            if ($sql3->num_rows == 1) {
                                                $sql3->bind_result($password_db);
                                                if ($sql3->fetch()) {
                                                    if (password_verify($_POST['old'], $password_db)) {
                                                        if($_POST['old'] != $_POST['new']){
                                                             if ($_POST['new'] == $_POST['confirm']) {
                                                                       $newpass = test_input($_POST['new']);
                                                                        if(strlen($newpass) < 7){
                                                                            echo '<script> 
                                                                            modal("Password must be 7 characters or longer",function(){
                                                                                return;
                                                                                });
                                                                         </script>';
                                                                        }else{
                                                                            $sql_code4 = "UPDATE tbl_user SET user_password = ?, user_activationcode = ? WHERE tbl_user.user_ID = ? ";
                                                                                if ($sql4 = $conn->prepare($sql_code4)) {
                                                                                    $code =null;
                                                                                    $sql4->bind_param('ssi', $password_hash, $code, $_GET['userID']);
                                                                                    $password_hash = password_hash($newpass, PASSWORD_DEFAULT);
                                                                                    if ($sql4->execute()) {
                                                                                              echo '<script>
                                                                                              modal("Password changed successfully!",function(){
                                                                                                window.location.href="Backend_LOGOUT.php";
                                                                                                });
                                                                                          </script>';
                                                                                    }
                                                                                    $sql4->close();
                                                                                }
                                                                        }
                                                           
                                                        }else{
                                                            echo '<script> 
                                                            modal("New Passwords do not match",function(){
                                                              return;
                                                                });
                                                            </script>';
                                                        }
                                                        }else{
                                                           echo '<script> modal("Please input a new password!",function(){
                                                            return;
                                                            });
                                                           </script>'; 
                                                        }
                                                       
                                                    }else{
                                                        echo '<script> 
                                                        modal("New password does not match old password",function(){
                                                           return;
                                                            });</script>';
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }       
                                }
                            }else{
                                  echo '<script> 
                                  modal("Invalid User Access",function(){
                                    window.location.href="index.php"
                                     });
                                  </script>';
                            }
                            }else{
                               echo  '<script> 
                               modal("Link has expired",function(){
                                window.location.href="index.php"
                                 });
                               </script>';
                           }
                        }
                    }
                }
            }
        
    }
     }else if($_GET['forget'] == 'true'){
         if (isset($_GET['code']) && isset($_GET['userID'])) {
            $sql_code2 = "SELECT `user_activationcode`, `user_timeStamp` FROM `tbl_user` WHERE `user_ID` = ?";
            if ($sql2 = $conn->prepare($sql_code2)) {
                $sql2->bind_param('i', $_GET['userID']);
                if ($sql2->execute()) {
                    $sql2->store_result();
                    if ($sql2->num_rows == 1) {
                      $sql2->bind_result($usercode,$sentTime);
                        if ($sql2->fetch()) {
                             date_default_timezone_set('Asia/Manila');
                            $currDate = date('Y-m-d h:i:s', time());
                            $date = strtotime($sentTime) + (60 * 5);
                            $dbDate = date('Y-m-d h:i:s', $date);
                        if($currDate <= $dbDate){
                            if (password_verify($usercode, $_GET['code'])) {
                               if (isset($_POST['submit'])) {
                                      if ((empty($_POST['new'])) || (empty($_POST['confirm']))) {
                                    echo '<script>
                                        modal("Please fill up all blank inputs before proceeding",function(){
                                        return;
                                        }); </script>';
                                } else {
                                                        if ($_POST['new'] == $_POST['confirm']) {
                                                            $newpass = test_input($_POST['new']);
                                                               if(strlen($newpass) < 7){
                                                                            echo '<script> 
                                                                            modal("Password must be 7 characters or longer",function(){
                                                                                return;
                                                                                }); </script>';
                                                                        }else{
                                                                            $sql_code4 = "UPDATE tbl_user SET user_password = ?, user_activationcode = ? WHERE tbl_user.user_ID = ? ";
                                                            if ($sql4 = $conn->prepare($sql_code4)) {
                                                                $code =null;
                                                                $sql4->bind_param('ssi', $password_hash, $code, $_GET['userID']);
                                                                $password_hash = password_hash($newpass, PASSWORD_DEFAULT);
                                                                if ($sql4->execute()) {
                                                                          echo '<script> 
                                                                          modal("Password changed successfully!",function(){
                                                                            window.location.href="Backend_LOGOUT.php";
                                                                            });
                                                                            </script>';
                                                                }
                                                                $sql4->close();
                                                            }
                                                                        }
                                                        }else{
                                                            echo '<script> 
                                                            modal("New Passwords do not match",function(){
                                                              return;
                                                                });
                                                            </script>';
                                                        }
                                }       
                                }
                            }else{
                                  echo '<script> 
                                  modal("Invalid User Access",function(){
                                    window.location.href="index.php"
                                      });
                                  </script>';
                            }
                            }else{
                               echo  '<script>
                               modal("Link has expired",function(){
                                window.location.href="index.php"
                                  });
                               </script>';
                           }
                        }
                    }
                }
            }
        
    }
     }
    function test_input($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    function crypto_rand_secure($min, $max)
    {
        $range = $max - $min;
        if ($range < 1) return $min; // not so random...
        $log = ceil(log($range, 2));
        $bytes = (int) ($log / 8) + 1; // length in bytes
        $bits = (int) $log + 1; // length in bits
        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd > $range);
        return $min + $rnd;
    }

    function getToken($length)
    {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet .= "0123456789";
        $max = strlen($codeAlphabet); // edited

        for ($i = 0; $i < $length; $i++) {
            $token .= $codeAlphabet[crypto_rand_secure(0, $max - 1)];
        }

        return $token;
    }

    ?>
    <sidenav>
        <?php
            require "Backend_CheckifLoggedIN.php";
        ?>
    </sidenav>
    <div class="OTP">
        <h3>Reset Password</h3>
        <div id="otpForm">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . '?' . $_SERVER['QUERY_STRING']); ?>" method="post">
                <?php if($_GET['forget'] == 'false'){ ?>
          <label>Old Password: </label><input type="password" id="oldPassword" name='old'><br>
         <?php }; ?>
                <label>New Password: </label><input type="password" id="newPassword" name='new'><br>
                <label>Retype New Password: </label><input type="password" id="reTypePassword" name='confirm'><br>
                <input class="header-btn btn" id="submit" name='submit' type='submit'>
            </form>
        </div>
    </div>
</body>

</html>