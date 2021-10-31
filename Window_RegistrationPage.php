
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
    include "Request_storeNotification";
    $conn = OpenCon();
    //Form part
    $emailErr = $passwordErr = $contactErr = $firstNameErr = $middleNameErr = $lastNameErr=$uploadErr="";
    $email = $password = $contact = $firstName = $middleName = $lastName="";
    $isAdmin = 0;
    $isApproved = 2;
     if($_SERVER["REQUEST_METHOD"]=="POST"){
     
      $fileTmpPath = $_FILES["fileUpload"]["tmp_name"];
      $fileName = $_FILES["fileUpload"]["name"];
      $targetDirectory ="C:/xampp/htdocs/practice/assets/".$fileName;
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

        if($_FILES["fileUpload"]["error"]>0){
          // $uploadErr = "Please upload your valid PLV ID";
        }
        if(empty($emailErr) && empty($passwordErr) && empty($contactErr) && empty($firstNameErr) && empty($middleNameErr) && empty($lastNameErr && empty($uploadErr))){
          if(move_uploaded_file($fileTmpPath,"assets/".$fileName))
          {
          $selectedCourse = $_POST["course"];
          $sql_code = "INSERT INTO tbl_user (user_email, user_password, user_firstName, user_middleName, user_lastName, user_contactNumber,user_course_ID,PLV_ID,isAdmin,isApproved) VALUES (?, ?, ?, ?, ? , ? , ? , ?, ?, ?)";
          if($sql = $conn->prepare($sql_code)){
            $sql->bind_param("sssssiisii",$email,$password_hash,$firstName,$middleName,$lastName,$contact,$selectedCourse,$targetDirectory,$isAdmin,$isApproved);
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            if($sql->execute()){
              echo '<script>
                    alert("Registration Successful!\n Status:Pending")
                    window.location.href = "Window_LOGIN.php"
                    </script>';
            }else{
              echo "Something went wrong";
              echo $conn -> error;
            }
            $sql->close();
          }
        }
        //Upload part (under construction)
        $message=$uploadErr="";
        }
        $conn->close();
    }

    function test_input($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    ?>
      <!--CHANGES-->
      <nav id="head-container">
            <div class="navbar">
            <div class="nav1">
              <img id="fb" src="assets/plv.png" alt="PLV Logo">
              <a href="Window_HomePage.php" type="button" class="header-btn btn ">Home</a>
              <a href="Window_RoomAndEquipment.php" type="button" class="header-btn btn ">Rooms and Equipment</a>
              <a href="Window_PoliciesPage.php" type="button" class="header-btn btn">Policies</a>
            </div>
            <div class="nav2">
              <?php
            require "Backend_CheckifLoggedIN.php";
                ?>        
            </div>
            </div>
    </nav>
    <!--END-->
        <div class="container">
            <div class="col-xs-4"></div>
            <div class="loginForm col-xs-4">
                <img src="assets/plv.png" style="display: block; margin-left: auto; margin-right: auto; margin-bottom: 50; height: 100; width: 100; margin-top: 100;">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data"> 
                    <div class="md-form form-group">
                        <input type="text" style="background: transparent;border: none;border-bottom: 1px solid #000000;-webkit-box-shadow: none;box-shadow: none; border-radius: 0;" class="form-control .w-25" name="email" placeholder="Email" value="<?php echo(isset($email))?$email:''?>" >
                        <span class="error"><?php echo $emailErr;?></span>
                      </div>
                      <div class="md-form form-group">
                        <input type="password" style="background: transparent;border: none;border-bottom: 1px solid #000000;-webkit-box-shadow: none;box-shadow: none; border-radius: 0;" class="form-control .w-25" name="password" placeholder="Password">
                        <span class="error"><?php echo $passwordErr;?></span>
                      </div>
                      <div class="md-form form-group">
                        <input type="text" maxlength="11" style="background: transparent;border: none;border-bottom: 1px solid #000000;-webkit-box-shadow: none;box-shadow: none; border-radius: 0;" class="form-control .w-25" name="contact" placeholder="Contact" value="<?php echo(isset($contact))?$contact:''?>">
                        <span class="error"><?php echo $contactErr;?></span>
                      </div>
                      <div class="md-form form-group">
                        <input type="text" style="background: transparent;border: none;border-bottom: 1px solid #000000;-webkit-box-shadow: none;box-shadow: none; border-radius: 0;" class="form-control .w-25" name="firstName" placeholder="First Name" value="<?php echo(isset($firstName))?$firstName:''?>">
                        <span class="error"><?php echo $firstNameErr;?></span>
                      </div>
                      <div class="md-form form-group">
                        <input type="text" style="background: transparent;border: none;border-bottom: 1px solid #000000;-webkit-box-shadow: none;box-shadow: none; border-radius: 0;" class="form-control .w-25" name="middleName" placeholder="Middle Name" value="<?php echo(isset($middleName))?$middleName:''?>">
                        <span class="error"><?php echo $middleNameErr;?></span>
                      </div>
                      <div class="md-form form-group">
                        <input  type="text" style="background: transparent;border: none;border-bottom: 1px solid #000000;-webkit-box-shadow: none;box-shadow: none; border-radius: 0;" class="form-control .w-25" name="lastName" placeholder="Last Name" value="<?php echo(isset($lastName))?$lastName:''?>">
                        <span class="error"><?php echo $lastNameErr;?></span>
                      </div>
                      <!--CHANGES-->
                      <div class="md-form form-group">
                          <label for="course">Course:</label>
                          <select id="course" name="course" >
                          </select>
                      </div>
                      <!--END-->
                      <div class="md-form form-group">
                        <label class="form-label" for="customFile">Attach ID</label>
                        <input type="file" class="form-control" id="File" name = "fileUpload" />
                        <span class="error"><?php echo $uploadErr;?></span>
                      </div>
                      <button type="submit" class="sgn-btn btn" id="register" style="margin:auto;" name="registerBtn">Register</button>
                      <a href="Window_LOGIN.php" style="text-decoration: underline; text-align: center;display: block; margin-top: 30px;">Log in</a>
                </form>
            </div>
            <div class="col-xs-4"></div>
        </div>
        <?php require "Backend_RegistrationPage.php"?>
    </body>
</html>