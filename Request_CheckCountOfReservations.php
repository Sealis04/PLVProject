<?php
$date = $_REQUEST['date'];
$reservations = array();
include "db_connection.php";
$conn=OpenCon();
$sql_code = "SELECT COUNT(*) as num FROM tbl_reservation WHERE r_status = 0 AND r_approved_ID = 1 
AND (? BETWEEN DateStart AND DateEnd)";
    if($sql=$conn->prepare($sql_code)){
        $sql->bind_param("s",$date);
            if($sql->execute()){
                $result = $sql->get_result();
                $user = $result->fetch_array(MYSQLI_ASSOC);
                $totalCount = $user['num'];
                echo $user['num'];
                }
             $sql->close();
        }
    $conn->close();
?>