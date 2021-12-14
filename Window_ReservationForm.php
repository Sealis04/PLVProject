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
    $conn = OpenCon();
    $min = Date("Y-m-d", strtotime('+3 days'));
    $minTime = '08:00';
    $maxTime = '17:00';
    $initialTime = '08:00';
    $initialTime_2 = '09:00';
    $uploadErr = "";
    //determine if admin
    if (isset($_SESSION['userID'])) {
        if ($_SESSION["isApproved"] == 2) {
            echo '<script>
        alert("User account is still pending, unable to create a reservation")
        window.location.href = "Window_HomePage.php"
        </script>';
        } else if ($_SESSION["isApproved"] == 1) {
            if ($_SESSION["isAdmin"] == 1) {
                $approveID = 1;
            } else {
                $approveID = 2;
            }
        }
    } else {
        echo '<script>
        alert("Please Log in first.")
        window.location.href = "Window_LOGIN.php"
        </script>';
    }
    //form initialization
    // if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //     if (isset($_POST['equipAdd'])) {
    //         if (isset($_POST['qty']) && isset($_POST['equipment'])) {
    //             $equipID = $_POST['equipment'];
    //             $qty = $_POST['qty'];
    //             $toStore = array_map(null, $equipID, $qty);
    //             $keys = array("ID", "qty");
    //             $toStore = array_map(function ($e) use ($keys) {
    //                 return array_combine($keys, $e);
    //             }, $toStore);
    //         } else {
    //             $toStore = [];
    //         }
    //     } else {
    //         $toStore = [];
    //     }
    //     $eventName = $_POST['event'];
    //     $userID = $_SESSION["userID"];
    //     $roomID = $_POST['room'];
    //     $adviser = $_POST['adviser'];
    //     $today = date("Y-m-d h:i:s");
    //     $startDate = $_POST['startDate'];
    //     $startTime = $_POST['startTime'];
    //     $endTime = $_POST['endTime'];
    //     $duration = $_POST['duration'];
    //     $days = '+ ' . $duration - 1 . 'days';
    //     $endDate = Date('Y-m-d', strtotime($startDate . $days));
    //     //NOTE, REMEMBER TO ADD IF EQUIPID==0 IN CONDITIONS LATER
    //     //check if file is uploaded
    //         if($_FILES["letterUpload"]["error"]>0){
    //             $uploadErr = "Please upload letter of approval/s.";
    //          }
    //            $fullName =  $_SESSION["fullName"];
    //          $fileTmpPath = $_FILES["letterUpload"]["tmp_name"];
    //          $fileName = $fullName. "ID";
    //            if(move_uploaded_file($fileTmpPath,"assets/".$fileName)){
              
                 
    //         }
    // }

    // $conn->close();

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

    // function insertEquipment($lastID, $conn, $eID, $qtyVal)
    // {

    //     $sql_code_2 = "INSERT INTO tbl_equipment_reserved(r_ID,equipment_ID,Qty) VALUES (?,?,?)";
    //     if ($sql2 = $conn->prepare($sql_code_2)) {
    //         $sql2->bind_param("sii", $lastID, $eID, $qtyVal);
    //         if ($sql2->execute()) {
    //             echo '<script>
    //             alert("Reservation success\nStatus: Pending")
    //             window.location.href = "Window_LOGIN.php"
    //             </script>';
    //         } else {
    //             echo '<script>alert("' . $conn->error . '")</script>';
    //         }
    //         $sql2->close();
    //     }
    // }
    ?>
    <div class="nav2">
        <?php
          require "Backend_CheckifLoggedIN.php";
        ?>
    </div>
    <div class="container">
        <div class="form-container">
            <legend>FORM</legend>
            <input type='button' onclick="addReservation()" value='Add' style='float:right' >
            <label for="Name">Name:</label>
            <input type="text" id="fullName" disabled name="Name" ><br><br>
            <label for="Course">Course:</label>
            <input type="text" id="course" disabled name="Course"><br><br>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data" id="reservationForm">
            </form>
        </div>
    </div>
    <?php
    require "Backend_ReservationForm.php";
    ?>
</body>
<!-- <link rel="stylesheet" href="/CSS/Form.css"> -->

</html>