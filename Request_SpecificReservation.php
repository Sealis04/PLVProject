<?php
//returns array of reservation 
$r_ID = $_REQUEST['r_ID'];
$review = $_REQUEST['isReviewed'];
$array2 = array();
include "db_connection.php";
$conn = OpenCon();
if($review != 'null'){
    $sql_code = "SELECT * FROM tbl_reservation 
    INNER JOIN tbl_user
    ON tbl_reservation.r_user_ID = tbl_user.user_ID
    WHERE tbl_reservation.r_approved_ID = 1 AND tbl_reservation.r_status = 0 
    AND tbl_reservation.r_reviewed = ? 
    AND r_ID = ?";
}else{
    $sql_code = "SELECT * FROM tbl_reservation 
    INNER JOIN tbl_user
    ON tbl_reservation.r_user_ID = tbl_user.user_ID
    WHERE tbl_reservation.r_status = 0 
    AND r_ID = ?";
}

if ($sql = $conn->prepare($sql_code)) {
    if($review != 'null'){
        $sql->bind_param('ii',$review,$r_ID);
    }else{
        $sql->bind_param('i',$r_ID);
    }
   
    if ($sql->execute()) {
        $result = $sql->get_result();
        while ($row = $result->fetch_assoc()) {
            $array2 = array(
                'firstName' => $row['user_firstName'],
                'middleName' => $row['user_middleName'],
                'lastName' => $row['user_lastName'],
                'roomID' => $row['r_room_ID'],
                'userID' => $row['user_ID'],
                'eventName' => $row['r_event'],
                'eventAdviser' => $row['r_eventAdviser'],
                'r_ID' => $row['r_ID'],
                'dateStart' => $row["DateStart"],
                'dateEnd' => $row["DateEnd"],
                'timeStart' => $row['TimeStart'],
                'timeEnd' => $row['TimeEnd'],
            );
        }
    } else {
        echo $conn->error;
    }
    $sql->close();
}
$conn->close();
$myJSON = json_encode($array2);
echo $myJSON;
