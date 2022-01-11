<?php
$day = $_REQUEST['day'];
$month = $_REQUEST['month'];
$year = $_REQUEST['year'];
$reservations = array();
include "db_connection.php";
$conn=OpenCon();
$sql_code = "SELECT COUNT(*) as num FROM tbl_reservation WHERE r_status = 0 AND r_approved_ID = 1 AND MONTH(DateStart) = ? AND YEAR(DateStart)= ?
AND (? BETWEEN DAY(DateStart) AND DAY(DateEnd))";
    if($sql=$conn->prepare($sql_code)){
        $sql->bind_param("sss",$month,$year,$day);
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