<?php
$eName = $_REQUEST['name'];
$eQuantity = $_REQUEST['quantity'];
$eAvailability = $_REQUEST['availability'];
$eDesc = $_REQUEST['desc'];
$eID = $_REQUEST['id'];
include "db_connection.php";
$conn=OpenCon();
$sql_code = "UPDATE `tbl_equipment` SET `equipment_name` = ?, `equipment_quantity` = ?, `equipment_description` = ?, `equipment_availability` = ?  WHERE equipment_ID = ?";
    if($sql=$conn->prepare($sql_code)){
        $sql->bind_param("sisii",$eName,$eQuantity,$eDesc,$eAvailability,$eID);
            if($sql->execute()){
                echo "Edit Success";
                }
             $sql->close();
        }
    $conn->close();
?>