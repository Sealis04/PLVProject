<?php
//returns array of reservation \
$rid = $_REQUEST["var"];
$userID = $_REQUEST['userID'];
$remarks = $_REQUEST['textArea'];
session_start();
include "db_connection.php";
include 'Backend_SendEmail.php';
include 'Request_storeNotification.php';
$conn = OpenCon();
$sql_code = "UPDATE `tbl_reservation` SET `r_approved_ID` = '1' WHERE r_ID = ?";
    if($sql=$conn->prepare($sql_code)){
        $sql->bind_param("i",$r_id);
        $r_id = $rid;
            if($sql->execute()){
                echo "Reservation accepted!";
                }
             $sql->close();
        }
    $conn->close();
     getEmail($userID,$rid,$remarks,1);
     update($userID,1,$remarks);
    ?>
