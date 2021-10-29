<?php
//returns array of reservation 
$r_ID = $_REQUEST["var"];
$reservation = array();
include "db_connection.php";
$conn = OpenCon();
$sql_code = "SELECT * FROM `tbl_equipment_reserved` WHERE `r_ID` = ?";
if ($sql = $conn->prepare($sql_code)) {
    $sql->bind_param("i", $r_ID);
    if ($sql->execute()) {
        $result = $sql->get_result();
        while ($row = $result->fetch_assoc()) {
            $sql_code2 = "SELECT * FROM tbl_equipment WHERE `equipment_ID` = ?";
            if ($sql2 = $conn->prepare($sql_code2)) {
                $sql2->bind_param('i',$row['equipment_ID']);
                if ($sql2->execute()) {
                    $result2 = $sql2->get_result();
                    while ($row2 = $result2->fetch_assoc()) {
                         $reservation[] = array(
                        'equipName' => $row2["equipment_name"],
                        'qty'=> $row['Qty'],
                         ); 
                    }
                }
                $sql2->close();
            }
        }
    } else {
        echo $conn->error;
    }
    $sql->close();
}
$conn->close();
$myJSON = json_encode($reservation);
echo $myJSON;
