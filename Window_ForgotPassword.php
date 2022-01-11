<html>
        <head>
        <title>PLVRS</title>
        <link rel="icon" href="assets/plv.png">
        <meta charset="UTF-8">
        <link rel="stylesheet" href="bootstrap-3.4.1-dist/bootstrap-3.4.1-dist/css/bootstrap.min.css">
        <script src="bootstrap-3.4.1-dist/bootstrap-3.4.1-dist/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="css/login.css">
        <link rel="stylesheet" href="css/SpecificallyForModal.css">
        <link rel="stylesheet" href="bootstrap-4.1.3-dist/css/bootstrap.min.css">
    <script src="bootstrap-4.1.3-dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="Backend_Modal.php"></script>
    
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
 include "sendEmailLink.php";
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

        if (empty($emailErr)) {
            $result = forgotPassword($email);
            if ($result != false) {
                echo '<script> 
                modal("A link was sent to your email \nPlease Check",function(){
                    window.location.href= "index.php"
                });
                 </script>';
            }
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
        <nav>
            <div class="navbar">
            <div class="nav2">
              <?php
            require "Backend_CheckifLoggedIN.php";
                ?>        
            </div>
            </div>
        </nav>
        <div class="container">
            <div class="col-sm-6 col-lg-5"></div>
            <div class="loginForm col-sm-6col-lg-5 shadow-lg p-3 mb-5 bg-white rounded">
                <img id="plv-logo" src="assets/plv.png">
                <form action-="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                    <div class="md-form form-group">
                        <input id="email" type="text" class="form-control .w-25" name="email" placeholder="Email" value="<?php echo(isset($email))? $email:""?>">
                        <span class="error"><?php echo $emailErr;?></span>
                      </div>
                      <button type="submit" id="login2" name='submitbtn'>Submit</button>
                      <a id="signup" href="index.php">Login</a>
                      <a id="signup" href="Window_RegistrationPage.php">Sign up</a>
                </form>
            </div>
            <div class="col-sm-6 col-lg-5"></div>
        </div>
        <!--END-->
    </body>
</html>