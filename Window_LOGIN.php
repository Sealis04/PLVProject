<html>
        <head>
        <title>PLVRS</title>
        <link rel="icon" href="assets/plv.png">
        <meta charset="UTF-8">
        <link rel="stylesheet" href="bootstrap-3.4.1-dist/bootstrap-3.4.1-dist/css/bootstrap.min.css">
        <script src="bootstrap-3.4.1-dist/bootstrap-3.4.1-dist/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="css/login.css">
        </head>
    <body>
    <?php
session_start();
//check if user is logged in
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: Window_HomePage.php");
    exit;
}

$count = 0;
$emailErr = $passwordErr="";
$email = $password=$userID="";
 include "db_connection.php";
 $conn = OpenCon();
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        //Email check
        if(empty(test_input($_POST["email"]))){
            $emailErr="* Email is required";
        } else{
            if (!filter_var(test_input($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format";
                $email="";
              }else{
                  $email=test_input($_POST["email"]);
              }
        }
        //Password check
        if(empty($_POST["password"])){
            $passwordErr="* Password is required";
        }else{
            $password = test_input($_POST["password"]);
        }
        //Email Password Match
        if(empty($emailErr) && empty($passwordErr)){
            $sql_code = "SELECT * FROM tbl_user WHERE user_email= ?";
            if($sql = $conn->prepare($sql_code)){
                $sql->bind_param("s", $email);
                if($sql ->execute()){
                    $sql->store_result();
                    if($sql->num_rows ==1){
                        $sql->bind_result($userID,$email,$password_db,$userfn,$usermn,$userln,$usercn,$usercourse,$userIDImage,$isAdmin,$isApproved,$isMarked,$notifID);
                        if($sql->fetch()){
                            if($isApproved == 1 || $isApproved == 2){
                                if(password_verify($password,$password_db)){
                                    if($isApproved == 2){
                                       echo '<script>alert("Account is still pending. User is unable to reserve until approved")
                                            window.location.href="Window_HomePage.php"
                                            </script>';
                                        }else if($isApproved == 1){
                                            header("location: Window_HomePage.php");
                                        }
                                    //Stores user info
                                    session_regenerate_id();
                                    $_SESSION["loggedin"] = true;
                                    $_SESSION["fullName"]=$userfn." ".$usermn." ". $userln;
                                    $_SESSION["userID"] = $userID;
                                    $_SESSION["email"] = $email;
                                    $_SESSION["usercontactnumber"]=$usercn;
                                    $_SESSION["usercourse"]=$usercourse;
                                    $_SESSION["isAdmin"]=$isAdmin;
                                    $_SESSION["isApproved"]=$isApproved;
                                    $_SESSION["password"]=$password_db;
                                    $_SESSION['isMarked'] = $isMarked;
                                    $_SESSION['ID_img'] = $userIDImage;
                                   
                                }else{
                                    $passwordErr="Invalid password";  
                                }
                            }else if($isApproved==3){
                                echo '<script>alert("Account has been rejected, please try again")
                                     window.location.href="Window_HomePage.php"
                                     </script>';
                            }
                            
                        }
                }else{
                    $emailErr="Invalid Email";
                    $email="";
                }
            }else {
                echo '<script>alert("Oops, something went wrong")</script>' ;
            }
            $sql->close();
        }
        $conn->close();
    }
}
        //Cleans content
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
            <div class="nav2">
              <?php
            require "Backend_CheckifLoggedIN.php";
                ?>        
            </div>
            </div>
        </nav>
        <div class="container">
            <div class="col-xs-4"></div>
            <div class="loginForm col-xs-4">
                <img id="plv-logo" src="assets/plv.png">
                <form action-="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                    <div class="md-form form-group">
                        <input id="email" type="text" class="form-control .w-25" name="email" placeholder="Email" value="<?php echo(isset($email))? $email:""?>">
                        <span class="error"><?php echo $emailErr;?></span>
                      </div>
                      <div class="md-form form-group">
                        <input id="password" type="password" class="form-control .w-25" name="password" placeholder="Password">
                        <span class="error"><?php echo $passwordErr;?></span>
                      </div>
                      <button type="submit" id="login2">Login</button>
                      <a id="signup" href="Window_Registrationpage.php">Sign up</a>
                </form>
            </div>
            <div class="col-xs-4"></div>
        </div>
        <!--END-->
    </body>
</html>