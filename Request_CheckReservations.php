<?php
$month = $_REQUEST['month'] + 1;
$year = $_REQUEST['year'];
$day = $_REQUEST['day'];
$reservations = array();
include "db_connection.php";
$conn=OpenCon();
$sql_code = "SELECT *,TIME(r_startDateAndTime) as 'start',TIME(r_endDateAndTime) as 'end' FROM tbl_reservation INNER JOIN tbl_room
ON tbl_reservation.r_room_ID = tbl_room.room_ID
INNER JOIN tbl_user
ON tbl_reservation.r_user_ID = tbl_user.user_ID
WHERE MONTH(r_startDateAndTime) = ? AND YEAR(r_startDateAndTime) = ? AND DAY(r_startDateAndTime) = ? AND r_approved_ID = 1";
    if($sql=$conn->prepare($sql_code)){
        $sql->bind_param("iii",$month,$year,$day);
            if($sql->execute()){
                 $result = $sql->get_result();
                 while($row = $result->fetch_assoc()){
                    $reservations[] = array(
                    'event_name' => $row['r_event'],
                    'start' => $row['start'],
                    'end' => $row['end'],
                    'firstName'=>$row['user_firstName'],
                    'middleName'=>$row['user_middleName'],
                    'lastName'=>$row['user_lastName'],
                    'room_name'=>$row['room_name'],
                    );
                 }
                }else{
                 echo  $conn->error;
                }
             $sql->close();
        }
    $conn->close();
    $myJSON = json_encode($reservations );
    echo $myJSON;
?>