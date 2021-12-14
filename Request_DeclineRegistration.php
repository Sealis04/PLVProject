<?php
$sid = $_REQUEST["var"];
$remarks = $_REQUEST['remarks'];
session_start();
include "db_connection.php";
include 'Backend_SendEmail.php';
include 'Request_storeNotification.php';
$conn=OpenCon();
$sql_code = "UPDATE `tbl_user` SET `isApproved` = '3' WHERE `user_ID` = ?"; 
    if($sql=$conn->prepare($sql_code)){
        $sql->bind_param("i",$s_id);
        $s_id = $sid;
            if($sql->execute()){
                echo "Registration declined!";
                }
             $sql->close();
        }
    $conn->close();
    $approval = 3;
    getEmail($sid, null,$remarks,$approval);
    update($sid,1,$remarks,1,null);
?>