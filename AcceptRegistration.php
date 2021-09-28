<?php
//returns array of reservation \
$sid = $_REQUEST["var"];
$reservation = array();
include "db_connection.php";
$conn=OpenCon();
$sql_code = "UPDATE `tbl_user` SET `isApproved` = '1' WHERE `user_ID` = ?";
    if($sql=$conn->prepare($sql_code)){
        $sql->bind_param("i",$s_id);
        $s_id = $sid;
            if($sql->execute()){
                echo "Registration accepted!";
                }
             $sql->close();
        }
    $conn->close();
?>
//aaaaaaaa
