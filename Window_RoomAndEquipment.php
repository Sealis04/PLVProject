<html>
    <head>
        <title>PLVRS</title>
        <link rel="icon" href="assets/plv.png">
        <meta charset="UTF-8">
        <link rel="stylesheet" href="bootstrap-3.4.1-dist/bootstrap-3.4.1-dist/css/bootstrap.min.css">
        <script src="bootstrap-3.4.1-dist/bootstrap-3.4.1-dist/js/bootstrap.min.js"></script>

        <link rel="stylesheet" href="css/RoomAndEquipment.css">
        <link rel="stylesheet" href="css/SpecificallyForModal.css">
    <script type="text/javascript" src="Backend_Modal.php"></script>
    </head>
    <body>
            <?php 
            include "db_connection.php";
            session_start();
            
                ?>
        <sidenav>
              <?php
              if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
                    if ($_SESSION['user_verified'] == 'not verified') {
                        echo '<script>
                        modal("Please confirm the OTP that was sent to your Email!",function(){
                            window.location.href = "Window_OTP.php?code='.$_SESSION['user_code'].'"
                        });
                        </script>';
                    }
              }
               require "Backend_CheckifLoggedIN.php";
                ?>        
        </sidenav>
        <nav>
            <div class="navbar">
            <div class="nav2">
                  
            </div>
            </div>
        </nav>

        <!--body-->
        <div class="container">
            
            <div class="row"> 
                    
                <legend>Room And Equipment</legend>
                <div class="bodyContainer">
                    <div class="side-nav" id="list">
                        <ul method="post">
                        <?php
                      
                    //creates entire list of rooms. 
                        $conn=OpenCon();
                        $sql_code = "SELECT * FROM tbl_room WHERE isDeleted = 0 and room_availability = 0";
                        if($sql=$conn->prepare($sql_code)){
                                if($sql->execute()){
                                    $result = $sql->get_result();
                                    while($row = $result->fetch_assoc()){
                                        //echo "<li>".'<a id ="'.$row["room_ID"].'"class="btns">'.$row["room_name"]."</a>"."</li>";
                                        echo '<li>'.'<input id ="'.$row["room_ID"].'"class="btns" type="button" value= "'.$row['room_name'].'"'.'<li>';
                                }
                        }
                        $sql->close();
                    }
                    $conn->close();
                        ?>
                    <li><a class= "btns" id="equipment">Equipment list</a></li>
                    <li><a class= "btn active" style="display:none" visibility="hidden">asd</a></li>
                          </ul>
                    </div>
                        <div class="big-contents" >
                            <ul id="contentDiv"> 
                            <h1 id="h1"></h1>
                            <h3 id="h2"></h3>
                            <h2 id="h2"><h2>
                            <p id="p1"></p>
                            </ul>   
                            </div>  
                    </div>
            </div>       
        </div>
        <?php require "Backend_RoomAndEquipment.php";?>
   </body>
</html>