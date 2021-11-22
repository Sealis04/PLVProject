<html>
    <head>
        <title>PLVRS</title>
        <link rel="icon" href="assets/plv.png">
        <meta charset="UTF-8">
        <link rel="stylesheet" href="bootstrap-3.4.1-dist/bootstrap-3.4.1-dist/css/bootstrap.min.css">
        <script src="bootstrap-3.4.1-dist/bootstrap-3.4.1-dist/js/bootstrap.min.js"></script>
        
        <link rel="stylesheet" href="css/Form.css">
    </head>
    <body>
    
    <?php
    include "db_connection.php";
    include "Backend_GetAllReservations.php";
    include "Request_storeNotification.php";
    include "Request_CheckUserDetails.php";
    $allReservations = json_decode(getAll());
    session_start();
    $conn= OpenCon();
    $min = Date("Y-m-d", strtotime('+3 days'));
    $max = $min.'T09:00';
    $min .='T08:00';
    $uploadErr="";
    //determine if admin
    if($_SESSION["isAdmin"]== 1){
        $approveID = 1;
    }else{
        $approveID= 2;
    }
    
    //form initialization
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        if(isset($_POST['equipAdd'])){
            if(isset($_POST['qty']) && isset($_POST['equipment'])){
                $equipID = $_POST['equipment'];
                $qty = $_POST['qty'];
                $toStore = array_map(null,$equipID,$qty);
                $keys = array("ID","qty");
                $toStore = array_map(function ($e) use ($keys) {return array_combine($keys,$e);},$toStore);
            }else{
                $toStore = [];
            }
        }else{
            $toStore = [];
        }
            $fileTmpPath = $_FILES["letterUpload"]["tmp_name"];
            $fileName = $_FILES["letterUpload"]["name"];
            $targetDirectory ="C:/xampp/htdocs/practice/assets/".$fileName;
            $userID = $_SESSION["userID"];
            $roomID = $_POST['room'];
            $today = date("Y-m-d h:i:s");
            $start = $_POST["startTime"];
            $end = $_POST["endTime"];
            $today_dt = new DateTime($today);
            $start_dt = new DateTime($start);
            $end_dt = new DateTime($end);
            $today_dt = $today_dt->format('Y-m-d h:i:s');
            $start_dt = $start_dt->format('Y-m-d h:i:s');
            $end_dt = $end_dt -> format('Y-m-d h:i:s');
            //NOTE, REMEMBER TO ADD IF EQUIPID==0 IN CONDITIONS LATER

        //check if file is uploaded
        if($_FILES["letterUpload"]["error"]>0){
            $uploadErr = "Please upload letter of approval/s.";
         }
       
         
         
           if(move_uploaded_file($fileTmpPath,"assets/".$fileName)){
            $notifID = notification($userID,2);
            $remarks = checkDetails($userID);
            if(!isset($remarks)){
                $sql_code = "INSERT INTO tbl_reservation (r_user_ID,r_room_ID,r_approved_ID,r_letter_file,r_startDateAndTime, r_endDateAndTime,notificationID) VALUES (?,?,?,?,?,?,?);";
                if($sql = $conn->prepare($sql_code)){
                    $sql->bind_param("iiisssi",$userID,$roomID,$approveID,$targetDirectory,$start,$end,$notifID);
                                        if($sql->execute()){
                                            $lastID = $conn->insert_id;
                                            if(!empty($toStore)){
                                                foreach($toStore as $values){
                                                    $eID = $values['ID'];
                                                    $qtyVal = $values['qty'];
                                                    insertEquipment($lastID,$conn,$eID,$qtyVal);    
                                                }
                                            }else{
                                                $eID = NULL;
                                                $qtyVal = NULL;
                                                insertEquipment($lastID,$conn,$eID,$qtyVal);
                                            }
                                          
                                        }else{
                                            echo '<script>alert("'.$conn->error.'")</script>';
                                        }           
                    $sql->close();
                }
                
            }else{
                echo '<script>alert("'.$remarks.'")</script>';
                } 
        }
    }
           
    $conn->close();

    // if($_SERVER["REQUEST_METHOD"]=="POST"){
    //     date_default_timezone_set('Asia/Manila');
        
    //     $today = date("Y-m-d h:i:s");
    //     $start = $_POST["startTime"];
    //     $today_dt = new DateTime($today);
    //     $start_dt = new DateTime($start);
    //     $today_dt = $today_dt->format('Y-m-d h:i:s');
    //     $start_dt = $start_dt->format('Y-m-d h:i:s');
    //     $min = Date("Y-m-d", strtotime('+3 days'));
    //     $max = $min.'T09:00';
    //     $min .='T08:00';
    //     if($start_dt < $today_dt){
    //         echo '<script>alert("FUCK")</script>';
    //     }else{
    //         echo '<script>alert("Nice")</script>';
    //     }
    // }

    function insertEquipment($lastID,$conn,$eID,$qtyVal){
      
        $sql_code_2 = "INSERT INTO tbl_equipment_reserved(r_ID,equipment_ID,Qty) VALUES (?,?,?)";
        if($sql2 = $conn->prepare($sql_code_2)){
            $sql2->bind_param("sii",$lastID,$eID,$qtyVal);
            if($sql2->execute()){
                echo '<script>
                alert("Reservation success\nStatus: Pending")
                window.location.href = "Window_LOGIN.php"
                </script>';
            }else{
                echo '<script>alert("'.$conn->error.'")</script>';
            }
            $sql2->close();
        }
    }
            ?>
        <nav id="head-container">
            <div class="navbar">
            
            <div class="nav2">
              <?php
            // require "Backend_CheckifLoggedIN.php";
                ?>        
            </div>
            </div>
        </nav>
        <div class="container">
            <div class="form-container">
                <legend>FORM</legend>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data" id="reservationForm">
                    <label for="Name" >Name:</label>
                    <input type="text" id="name" disabled name="Name"><br><br>
                    <label for="Course" >Course:</label>
                    <input type="text" id="course" disabled name="Course"><br><br>
                    <label for="Event">Event:</label>
                    <input type="text" id="event" name="course"><br><br>
                    <!--date and time-->
                    <div id = "wrapper"> 
                    <label for="dateAndTime">Reservation Date and Time Start:</label>
                    <input type="datetime-local" id="startTime" name="startTime" min="<?php echo $min; ?>" value="<?php echo $min; ?>"><br><br>
                    <span class="error" id="startErr"></span>
                    <label for="dateAndTime">Reservation Date and Time End:</label>
                    <input type="datetime-local" id="endTime" name="endTime" min="<?php echo $max; ?>" value="<?php echo $max; ?>">
                    <br>
                    <span class="error" id="endErr"></span>
                    <br>
                    <br>
                        <!--dropdown list room query-->
                        <label for="room">Room:</label>
                        <select name="room" id="room" > 
                          </select><br><br>
                        <!--dropdown list equip query-->
                        <div id = "equipmentList">
                        <label for= "Equipment" class="labelName"> Add Equipment? </label>
                        <label class="switch">
                            <input id = "equipmentCB" onClick="generateEquipmentList()"  type="checkbox" name = 'equipAdd'>
                        <span class="slider round"></span>
                        </label>
                        <br>
                        <br>
                        </div>
                        <!-- <label for="equipment">Equipment needed:</label>
                        <div id="equipment_list">
                        </div> -->
                        <br>
                          <label for="Contact">Contact details:</label>
                          <input type="text" id="contact" disabled name="Contact"><br><br>
                          <label class="form-label" for="form-control">Attach Leters</label>
                        <input type="file" class="form-control" id="File" name="letterUpload" /><br><br>
                        <span class="error"><?php echo $uploadErr;?></span>
                        <input type="submit" class="submit btn" style="float: right;" name="submitBtn" value="Submit" id="submitBtn">
                    </form>
                </div>
            </div>
        </div>
        <?php
        require "Backend_ReservationForm.php";
        ?>
    </body>
</html>
