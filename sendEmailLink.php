<script src="Backend_Modal.php" type="text/javascript"></script>
<?php
include "db_connection.php";
$conn=OpenCon();
$type;
if(isset($_GET['type'])){
    $type = $_GET['type'];

}else{
    $type=null;
}
if($type == 'resetpassword'){
    $sql_code = "SELECT `user_email` FROM `tbl_user` WHERE `user_ID` = ?";
    if($sql=$conn->prepare($sql_code)){
        $var = $_GET['var'];
        $sql->bind_param('i',$var);
            if($sql->execute()){
                $sql->store_result();
                if($sql->num_rows == 1){
                    $sql->bind_result($userEmail);
                    if($sql->fetch()){
                    $user_activationCode = getToken(12);
                    setTimezone($conn);
                     $sql_code2 = "UPDATE `tbl_user` SET `user_activationcode` = ?, `user_timeStamp` = now() WHERE `user_ID` = ?";
                    if($sql2=$conn->prepare($sql_code2)){
                        $sql2->bind_param('si',$user_activationCode,$var);
                        if($sql2->execute()){
                            $link = password_hash($user_activationCode,PASSWORD_DEFAULT);
                            sendEmail($userEmail,$link,$var,'false');
                        }
                        $sql2->close();
                    }
                    }
                }
                }
             $sql->close();
        }
}else if($type == 'OTP'){
        $var = $_GET['var'];
        $userOTP = rand(100000,999999);
        $sql_code = "SELECT user_email FROM tbl_user WHERE user_activationcode = ?";
        if ($sql = $conn->prepare($sql_code)) {
            $sql->bind_param('s', $var);
              if ($sql->execute()) {
                $sql->store_result();
                if($sql->num_rows == 1){
                    $sql->bind_result($userEmail);
                    setTimezone($conn);
                    if($sql->fetch()){
                        $sql_code3 = "UPDATE tbl_user SET user_otp = ?, `user_timeStamp` = now() WHERE user_activationcode =?";
                        if ($sql3 = $conn->prepare($sql_code3)) {
                            $sql3->bind_param('is', $userOTP, $var);
                            if ($sql3->execute()) {;
                                sendOTP($userOTP,$userEmail);
                            }else{
                                echo '<script> alert("'.$conn->error.'") </script>';
                            }
                        }
                    }
                }
            }else{
               echo '<script> alert("'.$conn->error.'") </script>';
            }
        }
        
            
}

function setTimezone($conn){
$sql_timezonecode = "set time_zone = '+08:00'";
 if($sql=$conn->prepare($sql_timezonecode)){
     $sql->execute();
 }
}
function forgotPassword($email){
    $conn2=OpenCon();
    setTimezone($conn2);
    $sql_code = "SELECT `user_ID` FROM `tbl_user` WHERE `user_email` = ?";
    if($sql=$conn2->prepare($sql_code)){
        $sql->bind_param('s',$email);
            if($sql->execute()){
                $sql->store_result();
                if($sql->num_rows == 1){
                    $sql->bind_result($uID);
                    if($sql->fetch()){
                    $user_activationCode = getToken(12);
                    $sql_code2 = "UPDATE `tbl_user` SET `user_activationcode` = ?, `user_timeStamp` = now() WHERE `user_ID` = ?";
                    if($sql2=$conn2->prepare($sql_code2)){
                        $sql2->bind_param('si',$user_activationCode,$uID);
                        if($sql2->execute()){
                            $link = password_hash($user_activationCode,PASSWORD_DEFAULT);
                            sendEmail($email,$link,$uID,'true');
                            return true;
                        }
                        $sql2->close();
                    }
                    }
                }else{
                      echo '<script> 
                      modal("Email is not registered",function(){return;});
                      </script>';
                      return false;
                }
                }
             $sql->close();
        }
        $conn2->close();
}
function sendOTP($OTP,$email){
    $subject = 'PLVRS Registration Notification';
    $message_body = '
    <p>[PLVRS]Email Verification Code: <b>'.$OTP.
    '</b>.</p>
    <p>Valid for 5 minutes. Do not share this code with anyone.</p>
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

function sendEmail($email,$endlink,$var,$forget){
    $subject = 'PLVRS Registration Notification';
    $message_body = '
    <p>[PLVRS]You requested to reset your password, Click on the link below to continue<b>;
    </b>
    <br>
    <a href="plvrs-gso.online/Window_ResetPassword.php?code='.$endlink.'&userID='.$var.'&forget='.$forget.'">
    Click Me!
    </a>
    <br>
    <p> *Note: This link will expire in 5 minutes </p>
    <br>
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
    $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet.= "0123456789";
    $max = strlen($codeAlphabet); // edited

    for ($i=0; $i < $length; $i++) {
        $token .= $codeAlphabet[crypto_rand_secure(0, $max-1)];
    }

    return $token;
}
?>