<html>
    <head>
        <title>PLVRS</title>
        <link rel="icon" href="assets/plv.png">
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/registration.css?v=<?php echo time();?>">
        <link rel="stylesheet" href="bootstrap-3.4.1-dist/bootstrap-3.4.1-dist/css/bootstrap.min.css">
        <script src="bootstrap-3.4.1-dist/bootstrap-3.4.1-dist/js/bootstrap.min.js"></script>
    </head>
    <body style="background-color: rgb(40,40,40)">
    <?php
    include "db_connection.php";
    $conn = OpenCon();
    //Form part
    $emailErr = $passwordErr = $contactErr = $firstNameErr = $middleNameErr = $lastNameErr=$fileUpload=$uploadErr="";
    $email = $password = $contact = $firstName = $middleName = $lastName="";
     if($_SERVER["REQUEST_METHOD"]=="POST"){
       echo "asdasd";
        if(empty(test_input($_POST["email"]))){
          $emailErr="* Required";
        }else{
          if(!filter_var(test_input($_POST["email"]), FILTER_VALIDATE_EMAIL)){
            $emailErr="* Invalid Email";
          }else{
            $sql_code = "SELECT user_ID from tbl_user WHERE user_email = ?";
            if($sql=$conn->prepare($sql_code)){
              $sql->bind_param("s",$email_param);
              $email_param = test_input($_POST["email"]);
              if($sql->execute()){
                $sql->store_result();
                if($sql->num_rows==1){
                  $emailErr="* Email is already taken";
                }else{
                  $email = test_input($_POST["email"]);
                }
              }else{
                echo "Oops, something went wrong";
              }
              $sql->close();
            }
          }
        }

        if(empty(test_input($_POST["contact"]))){
        $contactErr="* Required";
      } else{
        if(!preg_match("/^\d+$/",test_input($_POST["contact"]))){
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
          if(!preg_match("/^[a-zA-Z-' ]*$/",test_input($_POST["firstName"]))){
            $firstNameErr="Only letters and white space allowed";
          } else{
            $firstName=test_input($_POST["firstName"]);
          }
        }

      if(empty(test_input($_POST["lastName"]))){
        $lastNameErr="* Required";
      }
      else{
        if(!preg_match("/^[a-zA-Z-' ]*$/",test_input($_POST["lastName"]))){
          $lastNameErr="Only letters and white space allowed";
        }else{
          $lastName = test_input($_POST["lastName"]);
        }
      }

      if(!preg_match("/^[a-zA-Z-' ]*$/",test_input($_POST["middleName"]))){
            $middleNameErr="Only letters and white space allowed";
          }else{
            $middleName = test_input($_POST["middleName"]);
          }

          
        if(empty(test_input($_POST["password"]))){
          $passwordErr="* Required";
        }
        else if(strlen(test_input($_POST["password"])) < 7){
          $passwordErr="Password must at least have 7 characters";
        }else{
          $password = test_input($_POST["password"]);
        }

        if(empty($emailErr) && empty($passwordErr) && empty($contactErr) && empty($firstNameErr) && empty($middleNameErr) && empty($lastNameErr)){
          $sql_code = "INSERT INTO tbl_user (user_email, user_password, user_firstName, user_middleName, user_lastName, user_contactNumber) VALUES (?, ?, ?, ?, ? ,?)";
          if($sql = $conn->prepare($sql_code)){
            $sql->bind_param("sssssi",$email,$password_hash,$firstName,$middleName,$lastName,$contact);
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            if($sql->execute()){
              header("location: login.php");
            }else{
              echo "Something went wrong";
            }
            $sql->close();
          }
        }
        //Upload part (under construction)
        // $message=$uploadErr="";
        
        // if($_FILES["fileUpload"]["error"]>0){
        //     $uploadErr = "Please upload your valid PLV ID";
        // }
        // else{
        // if (isset($_POST["registerBtn"]) && $_POST["registerBtn"] == "Register") 
        // {
        //     if(isset($_FILES["fileUpload"]) && $_FILES["fileUpload"]["error"]==UPLOAD_ERR_OK){
        //         $fileTmpPath = $_FILES["fileUpload"]["tmp_name"];
        //         $fileName = $_FILES["fileUpload"]["name"];
        //         $fileType = $_FILES["fileUpload"]["type"];
        //         $targetDirectory ="C:/xampp/htdocs/practice/assets/";
        //         $targetFilePath = $targetDirectory.$fileName;
        //         $fileNameCmps = explode(".", $fileName);
        //         $fileExtension = strtolower(end($fileNameCmps));

        //         // check if file has one of the following extensions
        //         $allowedfileExtensions = array("jpg","png");
                
        //         if(in_array($fileExtension, $allowedfileExtensions)){
        //           if(move_uploaded_file($fileTmpPath, $targetFilePath)){
        //             $newFileName = "('".$fileName."')";
        //           }else{
        //             echo"you done fucked up";
        //           }
        //         }else{
        //           $message = "Upload Failed. Allowed file types:".implode(",",$allowedfileExtensions);
        //         }

        //         if(empty($uploadErr)){
        //           $sql_code = "INSERT INTO tbl_user (PLV_ID) VALUES (?) ";
        //           if($sql=$conn->prepare($sql_code)){
        //             $sql->bind_param("b",$fileName);
        //             if($sql->execute()){
        //               echo "image uploaded";
        //             }else{
        //               echo "image failed to upload";
        //             }
        //           }
        //         }

        //         $sql_code = "SELECT PLV_ID FROM tbl_user WHERE user_ID =?";
        //         if($sql=$conn->prepare($sql_code)){
        //           $sql->store_result();
        //           if($sql->num_rows ==1){
        //             $sql->bind_result($image);
        //             if($sql->fetch()){
        //               echo "<img src='data:image/jpeg:base 64," .base64_encode($image['PLV_ID']).">";
        //             }
        //         }
        //       }
                
        //         // if (in_array($fileExtension, $allowedfileExtensions)){
        //         //     $uploadFileDir = "C:/xampp/htdocs/practice/assets/";
        //         //     $dest_path = $uploadFileDir . $newFileName;
        //         //     if(move_uploaded_file($fileTmpPath, $dest_path)) 
        //         //     {
        //         //       $message ="File is successfully uploaded.";
        //         //     }
        //         //     else
        //         //     {
        //         //       $message = "There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.";
        //         //     }
        //         //   }
        //         //  else
        //         //   {
        //         //     $message = "Upload failed. Allowed file types: " . implode(",", $allowedfileExtensions);
        //         //   }
        //         }
        //         else
        //         {
        //           $message = "There is some error in the file upload. Please check the following error.<br>";
        //           $message .= "Error:" . $_FILES["$fileUpload"]["error"];
        //         }
        //     }
        // }

        $conn->close();
    }

    function test_input($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }


    ?>
        <nav id="head-container">
          <div class="container">
            <img id="fb" src="assets/plv.png" alt="PLV Logo">
            <a href = "RoomAndEquipment.php" type="button" class="header-btn btn btn-primary">Rooms and Equipment</a>
            <a href="Policies.php" type="button" class="header-btn btn btn-primary">Policies</a>
            <img id="user-icon" src="assets/user-icon.png" alt="user-icon">
            <span class="name" name="name">Unknown</span>
            <a href="login.php" id="login" type="button" class="header-btn btn btn-primary">Log in</a>
            </div>
        </nav>
        <div class="container">
            <div class="col-xs-4"></div>
            <div class="loginForm col-xs-4">
                <img src="assets/plv.png" style="display: block; margin-left: auto; margin-right: auto; margin-bottom: 50; height: 100; width: 100; margin-top: 100;">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
                    <div class="md-form form-group">
                        <input  type="text"  class="form-control .w-25 formbox" name="email" placeholder="Email" value="<?php echo(isset($email))?$email:''?>">
                        <span class="error"><?php echo $emailErr;?></span>
                      </div>
                      <div class="md-form form-group">
                        <input  type="password" class="form-control .w-25 formbox" name="password" placeholder="Password" >
                        <span class="error"><?php echo $passwordErr;?></span>
                      </div>
                      <div class="md-form form-group">
                        <input maxlength="11" type="text" class="form-control .w-25 formbox" name="contact" placeholder="Contact" value="<?php echo(isset($contact))?$contact:''?>">
                        <span class="error"><?php echo $contactErr;?></span>
                      </div>
                      <div class="md-form form-group">
                        <input type="text" class="form-control .w-25 formbox" name="firstName" placeholder="First Name" value="<?php echo(isset($firstName))?$firstName:''?>">
                        <span class="error"><?php echo $firstNameErr;?></span>
                      </div>
                      <div class="md-form form-group">
                        <input  type="text" class="form-control .w-25 formbox" name="middleName" placeholder="Middle Name" value="<?php echo(isset($middleName))?$middleName:''?>">
                        <span class="error"><?php echo $middleNameErr;?></span>
                      </div>
                      <div class="md-form form-group">
                        <input type="text" class="form-control .w-25 formbox" name="lastName" placeholder="Last Name" value="<?php echo(isset($lastName))?$lastName:''?>">
                        <span class="error"><?php echo $lastNameErr;?></span>
                      </div>
                      <div class="md-form form-group">
                        <label class="form-label" for="customFile">Attach ID</label>
                        <input type="file" class="form-control" name="fileUpload"/>
                        <span class="error"><?php echo $uploadErr;?></span>
                      </div>
                      <input type="submit" class="btn btn-primary btn-lg btn-block" style="margin:auto;" name="registerBtn" value="Register">              
                      <a href="login.php" style="text-decoration: underline; text-align: center;display: block; margin-top: 30px;">Log in</a>
                </form>
            </div>
            <div class="col-xs-4"></div>
        </div>
    </body>
</html>


<!--style for all inputs
style="background: transparent;border: none;border-bottom: 1px solid #000000;-webkit-box-shadow: none;box-shadow: none; border-radius: 0;"
put in css later-->