<?php
$eAvailability = $_REQUEST['availability'];
$eID = $_REQUEST['id'];
include "db_connection.php";
$conn=OpenCon();
$sql_code = "UPDATE `tbl_user` SET r_marked=? WHERE `user_ID` =?";
    if($sql=$conn->prepare($sql_code)){
        $sql->bind_param("ii",$eAvailability,$eID);
            if($sql->execute()){
                echo "Edit Success";
                }
             $sql->close();
        }
    $conn->close();
?>