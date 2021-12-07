<?php
//returns array of reservation 
$reservation = array();
include "db_connection.php";
$conn = OpenCon();
$sql_code = "SELECT * FROM tbl_reservation WHERE r_approved_ID = 1 AND r_status = 0 AND r_reviewed = 0 AND DateEnd < CURRENT_DATE();";
if ($sql = $conn->prepare($sql_code)) {
    if ($sql->execute()) {
        $result = $sql->get_result();
        while ($row = $result->fetch_assoc()) {
            $reservation[] = array(
                'event' => $row["r_event"],
                'dateStart' => $row['DateStart'],
                'dateEnd' => $row['DateEnd'],
                'timeStart' => $row['TimeStart'],
                'timeEnd' => $row['TimeEnd'],
                'approval' => $row['r_approved_ID'],
                'reservationID' => $row["r_ID"],
                'status' => $row['r_status'],
                'userID' => $row['r_user_ID']
            );
        }
    } else {
        echo $conn->error;
    }
    $sql->close();
}
$conn->close();

$myJSON = json_encode($reservation);
echo $myJSON;
