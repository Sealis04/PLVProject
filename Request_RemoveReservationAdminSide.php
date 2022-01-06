<?php
//returns array of reservation \
$rid = $_REQUEST["var"];
$userID = $_REQUEST['userID'];
$remarks = $_REQUEST['remarks'];
$notifID = $_REQUEST['notifID'];
session_start();
include "db_connection.php";
include 'Request_storeNotification.php';
include 'Backend_SendEmail.php';
$conn=OpenCon();
$sql_code = "UPDATE `tbl_reservation` SET `r_status` = 1 WHERE r_ID = ?";
    if($sql=$conn->prepare($sql_code)){
        $sql->bind_param("i",$r_id);
        $r_id = $rid;
            if($sql->execute()){
                echo "Cancel success!";
                }
             $sql->close();
        }
    $conn->close();
    getEmail($userID,$rid,$remarks,4);
    update($userID,4,$remarks,0,$notifID);
?>