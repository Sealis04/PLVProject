<?php
$date = $_REQUEST['date'];
$reservations = array();
include "db_connection.php";
$conn=OpenCon();
$sql_code = "SELECT *,TimeStart as 'start',TimeEnd as 'end' FROM tbl_reservation INNER JOIN tbl_room
ON tbl_reservation.r_room_ID = tbl_room.room_ID
INNER JOIN tbl_user
ON tbl_reservation.r_user_ID = tbl_user.user_ID
WHERE (? between tbl_reservation.DateStart AND tbl_reservation.DateEnd) AND r_status = 0 AND r_approved_ID = 1";
    if($sql=$conn->prepare($sql_code)){
        $sql->bind_param("s",$date);
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
                    'facilitator' =>$row['r_eventAdviser']
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