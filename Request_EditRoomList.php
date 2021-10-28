<?php
$rName = $_REQUEST['name'];
$rQuantity = $_REQUEST['cap'];
$rAvailability = $_REQUEST['availability'];
$rDesc = $_REQUEST['desc'];
$rID = $_REQUEST['id'];
include "db_connection.php";
$conn=OpenCon();
$sql_code = "UPDATE `tbl_room` SET `room_name` = ?, `room_capacity` = ?, `room_description` = ?, `room_availability` = ?  WHERE room_ID = ?";
    if($sql=$conn->prepare($sql_code)){
        $sql->bind_param("sisii",$rName,$rQuantity,$rDesc,$rAvailability,$rID);
            if($sql->execute()){
                echo "Edit Success";
                }
             $sql->close();
        }
    $conn->close();
?>