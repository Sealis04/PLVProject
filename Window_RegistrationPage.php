
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
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: Window_HomePage.php");
    exit;
    }
    include "db_connection.php";
    include "Request_storeNotification.php";
    //include "Request_storeNotification";
    $conn = OpenCon();
    //Form part
    function setTimezone($conn){
        $sql_timezonecode = "set time_zone = '+08:00'";
         if($sql=$conn->prepare($sql_timezonecode)){
             $sql->execute();
         }
        }
    $emailErr = $passwordErr = $contactErr = $firstNameErr = $middleNameErr = $lastNameErr=$uploadErr=$userIDErr = "";
    $email = $password = $contact = $firstName = $middleName = $lastName=$userID = "";
    $isAdmin = 0;
    $isApproved = 2;
     if($_SERVER["REQUEST_METHOD"]=="POST"){
        if(empty(test_input($_POST["email"]))){
          $emailErr="* Required";
        }else{
          if(!filter_var(test_input($_POST["email"]), FILTER_VALIDATE_EMAIL)){
            $emailErr="* Invalid Email";
          }else{
            $sql_code = "SELECT user_ID from tbl_user WHERE user_email = ? AND isApproved != 3";
            if($sql=$conn->prepare($sql_code)){
              $sql->bind_param("s",$email_param);
              $email_param = test_input($_POST["email"]);
              if($sql->execute()){
                $sql->store_result();
                if($sql->num_rows==1){
                  $emailErr="* Email is already taken";
                }else{
                  $email = test_input(strtolower($_POST["email"]));
                }
              }else{
                echo "Oops, something went wrong";
              }
              $sql->close();
            }
          }
        }

        //userID
        if(empty(test_input($_POST["userID"]))){
          $userIDErr="* Required";
        }else{
         if(!preg_match('/^[0-9-]*$/',test_input($_POST['userID']))){
           $userIDErr= "Invalid user ID";
         }else{
          $sql_code2 = "SELECT user_ID from tbl_user WHERE userIDNumber = ? AND isApproved !=3";
          if($sql2=$conn->prepare($sql_code2)){
            $sql2->bind_param("s",$userIDPARAM);
            $userIDPARAM = test_input($_POST['userID']);
            if($sql2->execute()){
              $sql2->store_result();
              if($sql2->num_rows == 1){
                $userIDErr="* User has already been registered";
              }else{
                $userIdParam = test_input($_POST['userID']);
              }
            }else{
              echo "Something went wrong";
            }
            $sql2->close();
          }
         }
        }
        if(empty(test_input($_POST["contact"]))){
        $contactErr="* Required";
      } else{
        if(!preg_match('/^[0-9]{11}+$/',test_input($_POST["contact"]))){
          $contactErr="Invalid Contact Number";
        }else{
          if(strlen(test_input($_POST["contact"]))<11){
            $contactErr="Invalid Contact Number";
          }else{
            $contact = test_input($_POST["contact"]);
          }
        }
      }

      if(empty(test_input($_POST["firstName"]))){
          $firstNameErr="* Required";
        }else{
          if(!preg_match("/^[a-zA-ZñÑ' ]*$/",test_input($_POST["firstName"]))){
            $firstNameErr="Only letters and white space allowed";
          } else{
            $firstName=test_input($_POST["firstName"]);
            $firstName = ucwords(strtolower($firstName));
          }
        }

      if(empty(test_input($_POST["lastName"]))){
        $lastNameErr="* Required";
      }
      else{
        if(!preg_match("/^[a-zA-ZñÑ' ]*$/",test_input($_POST["lastName"]))){
          $lastNameErr="Only letters and white space allowed";
        }else{
          $lastName = test_input($_POST["lastName"]);
          $lastName = ucwords(strtolower($lastName));
        }
      }

      if(!preg_match("/^[a-zA-ZñÑ' ]*$/",test_input($_POST["middleName"]))){
            $middleNameErr="Only letters and white space allowed";
          }else{
            $middleName = test_input($_POST["middleName"]);
             $middleName = ucwords(strtolower($middleName));
          }

          
        if(empty(test_input($_POST["password"]))){
          $passwordErr="* Required";
        }
        else if(strlen(test_input($_POST["password"])) < 7){
          $passwordErr="Password must at least have 7 characters";
        }else{
          $password = test_input($_POST["password"]);
        }

        if($_FILES["fileUpload"]["error"]<0){
           $uploadErr = "Please upload your valid PLV ID";
        }
        
      $fileCount = count(array_filter($_FILES["fileUpload"]["name"]));
      $valid_ext = array('jpg', 'png', 'jpeg');
      for ($i = 0; $i < $fileCount; $i++) {
        $fileName = $_FILES['fileUpload']['name'][$i];
        $path = "assets/" . $fileName;
        $fileextension = pathinfo($path, PATHINFO_EXTENSION);
        $fileextension = strtolower($fileextension);
        if (!in_array($fileextension, $valid_ext)) {
          $uploadErr = "Invalid ID format";
        }
      }
        if(empty($emailErr) && empty($userIDErr) && empty($passwordErr) && empty($contactErr) && empty($firstNameErr) && empty($middleNameErr) && empty($lastNameErr) && empty($uploadErr)){
          $selectedUserType = $_POST['Type'];
          if($selectedUserType == 1){
            $selectedCourse = $_POST["course"];
            $selectedSection = $_POST['section'];
          }else{
            $selectedCourse = 18;
            $selectedSection= 1;
          }
        setTimezone($conn);
          $user_activationCode = getToken(12);
          $userOTP = rand(100000,999999);
          $notverified = 'not verified';
          $sql_code = "INSERT INTO tbl_user 
          (userIDNumber,user_email, user_password, user_firstName, user_middleName, user_lastName,
           user_contactNumber,user_course_ID,isAdmin,isApproved,user_s_ID,user_verified,user_otp,user_activationcode) 
           VALUES (?, ?, ?, ?, ?, ? , ? , ? , ?, ?,?,?,?,?)";
          if($sql = $conn->prepare($sql_code)){
            $sql->bind_param("ssssssiiiiisis",$userIdParam,$email,$password_hash,$firstName,$middleName,$lastName,$contact,
            $selectedCourse,$isAdmin,$isApproved,$selectedSection,$notverified,$userOTP,$user_activationCode);
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            if($sql->execute()){
              $lastID = $conn->insert_id;
              $notifID = notification($lastID, 2,1);
              uploadImage($conn,$fileCount,$sql->insert_id);
              sendOTP($userOTP,$email);
              echo '<script>
                    alert("Please confirm the OTP that was sent to your Email!")
                    window.location.href = "/Window_OTP.php?code='.$user_activationCode.'&userID='.$lastID.'"
                    </script>';
            }else{
              echo "Something went wrong";
              echo $conn -> error;
            }
            $sql->close();
          }
        // //Upload part (under construction)
        }
        $conn->close();
    }
    function uploadImage($conn,$fileCount,$id){
      for($i = 0; $i<$fileCount;$i++){
        $fileTmpPath = $_FILES["fileUpload"]["tmp_name"][$i];
        $fileName = $_FILES['fileUpload']['name'][$i];
        $path = "assets/".$fileName;
        $fileextension = pathinfo($path,PATHINFO_EXTENSION);
        $fileextension = strtolower($fileextension);
          if(move_uploaded_file($fileTmpPath,$path)){
            $sql_code2 = "INSERT INTO tbl_letterforregistration (u_ID,letterPath) VALUES (?,?)";
            if($sql2 = $conn->prepare($sql_code2)){
              $sql2->bind_param('is', $id,$path);
               $sql2->execute();
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
      <!--CHANGES-->
      <nav>
            <div class="nav2">
              <?php
           require "Backend_CheckifLoggedIN.php";
                ?>        
            </div>
    </nav>
    <!--END-->
        <div class="container">
            <div class="col-sm-6 col-lg-4"></div>
            <div class="loginForm col-sm-6 col-lg-4">
                <img src="assets/plv.png" style="display: block; margin-left: auto; margin-right: auto; margin-bottom: 50; height: 100; width: 100; margin-top: 100;">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data"> 
                <div class="md-form form-group">
                        <input required type="text"  style="background: transparent;border: none;border-bottom: 1px solid #000000;-webkit-box-shadow: none;box-shadow: none; border-radius: 0;" class="form-control .w-25" name="userID" placeholder="ID #" value="<?php echo(isset($userID))?$userID:''?>" >
                        <span class="error"><?php echo $userIDErr;?></span>
                      </div>
                    <div class="md-form form-group">
                        <input required type="text"  style="background: transparent;border: none;border-bottom: 1px solid #000000;-webkit-box-shadow: none;box-shadow: none; border-radius: 0;" class="form-control .w-25" name="email" placeholder="Email" value="<?php echo(isset($email))?$email:''?>" >
                        <span class="error"><?php echo $emailErr;?></span>
                      </div>
                      <div class="md-form form-group">
                        <input required type="password"  style="background: transparent;border: none;border-bottom: 1px solid #000000;-webkit-box-shadow: none;box-shadow: none; border-radius: 0;" class="form-control .w-25" name="password" placeholder="Password">
                        <span class="error"><?php echo $passwordErr;?></span>
                      </div>
                      <div class="md-form form-group">
                        <input required type="number"  maxlength="11" style="background: transparent;border: none;border-bottom: 1px solid #000000;-webkit-box-shadow: none;box-shadow: none; border-radius: 0;" class="form-control .w-25" name="contact" placeholder="Contact Number" value="<?php echo(isset($contact))?$contact:''?>">
                        <span class="error"><?php echo $contactErr;?></span>
                      </div>
                      <div class="md-form form-group">
                        <input required type="text"   style="background: transparent;border: none;border-bottom: 1px solid #000000;-webkit-box-shadow: none;box-shadow: none; border-radius: 0;" class="form-control .w-25" name="firstName" placeholder="First Name" value="<?php echo(isset($firstName))?$firstName:''?>">
                        <span class="error"><?php echo $firstNameErr;?></span>
                      </div>
                      <div class="md-form form-group">
                        <input type="text" style="background: transparent;border: none;border-bottom: 1px solid #000000;-webkit-box-shadow: none;box-shadow: none; border-radius: 0;" class="form-control .w-25" name="middleName" placeholder="Middle Name" value="<?php echo(isset($middleName))?$middleName:''?>">
                        <span class="error"><?php echo $middleNameErr;?></span>
                      </div>
                      <div class="md-form form-group">
                        <input  required type="text"  style="background: transparent;border: none;border-bottom: 1px solid #000000;-webkit-box-shadow: none;box-shadow: none; border-radius: 0;" class="form-control .w-25" name="lastName" placeholder="Last Name" value="<?php echo(isset($lastName))?$lastName:''?>">
                        <span class="error"><?php echo $lastNameErr;?></span>
                      </div>
                      <!--CHANGES-->
                      <div class="md-form form-group">
                          <label for="Type">Register as:</label>
                          <select id="Type" name="Type" >
                            <option value='1'>Student</option>
                            <option value='2'>Teacher</option>
                          </select>
                      </div>
                      <!--END-->
                      <div class="md-form form-group">
                        <label class="form-label" for="customFile">Attach ID</label>
                        <input required  type="file" multiple class="form-control" id="File" name = "fileUpload[]" />
                        <span class="error"><?php echo $uploadErr;?></span>
                      </div>
                      <button type="submit" class="sgn-btn btn" id="register" style="margin:auto;" name="registerBtn">Register</button>
                      <a href="index.php" style="text-decoration: underline; text-align: center;display: block; margin-top: 30px;">Log in</a>
                </form>
            </div>
            <div class="col-sm-6 col-lg-4"></div>
        </div>
        <?php require "Backend_RegistrationPage.php"?>
    </body>
</html>