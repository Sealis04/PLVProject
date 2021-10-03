<?php
//returns array of reservation \
$rid = $_REQUEST["var"];
$reservation = array();
include "db_connection.php";
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
?>