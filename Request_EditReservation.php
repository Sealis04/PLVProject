<?php
$rid = $_REQUEST["var"];
$reservation = array();
include "db_connection.php";
$conn=OpenCon();
$sql_code = $sqlcode = "UPDATE tbl_reservation SET r_event = ?,r_startDateAndTime = ?, r_endDateAndTime = ?, r_equipment_ID = ?,r_room_ID=? WHERE r_ID = ?";
    if($sql=$conn->prepare($sql_code)){
        $sql->bind_param("sssiii",$eventName,$start,$end,$equipID,$roomID,$rid);
            if($sql->execute()){
                }
             $sql->close();
        }
    $conn->close();
?>
