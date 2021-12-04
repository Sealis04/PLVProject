<html>
    <head>
        <title>PLVRS</title>
        <link rel="icon" href="assets/plv.png">
        <meta charset="UTF-8">
        <link rel="stylesheet" href="bootstrap-3.4.1-dist/bootstrap-3.4.1-dist/css/bootstrap.min.css">
        <script src="bootstrap-3.4.1-dist/bootstrap-3.4.1-dist/js/bootstrap.min.js"></script>
        
        <link rel="stylesheet" href="/CSS/Form.css">
    </head>
    <body>
    
    <?php
    include "db_connection.php";
    include "Request_storeNotification.php";
    include "Request_CheckUserDetails.php";
    session_start();
    $conn= OpenCon();
    $min = Date("Y-m-d", strtotime('+3 days'));
    $minTime = '08:00';
    $maxTime = '17:00';
    $initialTime = '08:00';
    $initialTime_2='09:00';
    $uploadErr="";
    //determine if admin
    if(isset($_SESSION['userID'])){
        if($_SESSION["isApproved"] == 2){
            echo '<script>
        alert("User account is still pending, unable to create a reservation")
        window.location.href = "Window_HomePage.php"
        </script>';
        }else if($_SESSION["isApproved"] == 1){
            if($_SESSION["isAdmin"]== 1){
                $approveID = 1;
            }else{
                $approveID= 2;
            }
        }
    }else{
        echo '<script>
        alert("Please Log in first.")
        window.location.href = "Window_LOGIN.php"
        </script>';
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
            $eventName = $_POST['event'];
            $userID = $_SESSION["userID"];
            $roomID = $_POST['room'];
            $today = date("Y-m-d h:i:s");
            $startDate = $_POST['startDate'];
            $startTime = $_POST['startTime'];
            $endTime = $_POST['endTime'];
            $duration = $_POST['duration'];
            $days ='+ '. $duration - 1 .'days';
            $endDate = Date('Y-m-d', strtotime($startDate.$days));
        //NOTE, REMEMBER TO ADD IF EQUIPID==0 IN CONDITIONS LATER
        //check if file is uploaded
        if($_FILES["letterUpload"]["error"]>0){
            $uploadErr = "Please upload letter of approval/s.";
         }
           $fullName =  $_SESSION["fullName"];
         $fileTmpPath = $_FILES["letterUpload"]["tmp_name"];
         $fileName = $fullName. "ID";
           if(move_uploaded_file($fileTmpPath,"assets/".$fileName)){
            $notifID = notification($userID,2);
            $remarks = checkDetails($userID);
            if(!isset($remarks)){
                $sql_code = "INSERT INTO tbl_reservation (r_user_ID,r_event,r_room_ID,r_approved_ID,r_letter_file,notificationID,DateStart,DateEnd,TimeStart,TimeEnd) VALUES (?,?,?,?,?,?,?,?,?,?);";
                if($sql = $conn->prepare($sql_code)){
                    $sql->bind_param("isiisissss",$userID,$eventName,$roomID,$approveID,$fileName,$notifID,$startDate,$endDate,$startTime,$endTime);
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
            <div class="nav2">
              <?php
            require "Backend_CheckifLoggedIN.php";
                ?>        
            </div>
        <div class="container">
            <div class="form-container">
                <legend>FORM</legend>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data" id="reservationForm">
                    <label for="Name" >Name:</label>
                    <input type="text" id="name" disabled name="Name"><br><br>
                    <label for="Course" >Course:</label>
                    <input type="text" id="course" disabled name="Course"><br><br>
                    <label for="Event" >Event:</label>
                    <input type="text" id="event" name='event' required><br><br>
                    <!--date and time-->
                    <div id = "wrapper"> 
                    <label for="dateAndTime">Reservation Date and Time Start:</label>
                    <input type="date" id="startDate" name="startDate" min="<?php echo $min; ?>" value="<?php echo $min; ?>" required><br><br>
                    <span class="error" id="startErr"></span>
                    <label for="Duration"> Duration: </label> <input id='durationDay' name='duration' type="text" placeholder="(In Days)" value = "1" required>
                    <br> <br>
                    <label for="dateAndTime">Reservation Date and Time End:</label>
                    <input type="time" id="startTime" name="startTime" min="<?php echo $minTime; ?>" max ="<?php echo $maxTime; ?>"  value ="<?php echo $initialTime; ?>"required>
                    <span > to </span>
                    <input type="time" id="endTime" name="endTime" min="<?php echo $minTime; ?>" max ="<?php echo $maxTime; ?>"  value ="<?php echo $initialTime_2; ?>"required><br>
                    <!-- <span class="validity"></span> -->
                    <span class="error" id="endTimeErr"></span>
                    <br>
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
