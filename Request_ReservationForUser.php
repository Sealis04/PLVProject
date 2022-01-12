<?php
//returns array of reservation 
$userID = $_REQUEST["var"];
$page = $_REQUEST['page'];
$window = $_REQUEST['window'];
$month = $_REQUEST['month'];
$year = $_REQUEST['year'];
$reservation = array();
include "db_connection.php";
include 'Backend_Pagination.php';
$conn = OpenCon();
$limit = 5;
if ($page)
    $start = ($page - 1) * $limit;             //first item to display on this page
else
    $start = 0;
$query = "SELECT COUNT(*) as num FROM tbl_reservation WHERE r_user_ID = ? 
AND (CASE WHEN ? != 0
     THEN MONTH(tbl_reservation.DateStart) = ?
     ELSE TRUE
     END)
AND (CASE WHEN ? != 0
THEN YEAR(tbl_reservation.DateStart) = ?
ELSE TRUE
END)   ";
$sql5 = $conn->prepare($query);
$sql5->bind_param("iiiii", $userID, $month,$month,$year,$year);
$sql5->execute();
$result2 = $sql5->get_result();
$user = $result2->fetch_array(MYSQLI_ASSOC);
$total_items = $user['num'];
$sql5->close();

$sql_code = "SELECT * FROM tbl_reservation 
INNER JOIN tbl_room ON tbl_reservation.r_room_ID = tbl_room.room_ID 
INNER JOIN tbl_notification ON tbl_reservation.notifID = tbl_notification.notificationID
WHERE tbl_reservation.r_user_ID = ? AND tbl_notification.forRegistration = 0 
AND (CASE WHEN ? != 0
     THEN MONTH(tbl_reservation.DateStart) = ?
     ELSE TRUE
     END)
AND (CASE WHEN ? != 0
THEN YEAR(tbl_reservation.DateStart) = ?
ELSE TRUE
END)
ORDER BY tbl_reservation.r_status, FIELD(r_approved_ID,'1') DESC, (CASE WHEN DATE(NOW()) < DATE(tbl_reservation.DateStart)
     THEN 1
     ELSE 0
     END) DESC , tbl_reservation.DateStart LIMIT $start, $limit";
if ($sql = $conn->prepare($sql_code)) {
    $sql->bind_param('iiiii', $r_user,$month,$month,$year,$year);
    $r_user = $userID;
    if ($sql->execute()) {
        $result = $sql->get_result();
        while ($row = $result->fetch_assoc()) {
            $reservation[] = array(
                'event' => $row["r_event"],
                'eventAdviser' => $row["r_eventAdviser"],
                'dateStart' => $row["DateStart"],
                'dateEnd' => $row["DateEnd"],
                'timeStart' => $row['TimeStart'],
                'timeEnd' => $row['TimeEnd'],
                'approval' => $row['r_approved_ID'],
                'reservationID' => $row["r_ID"],
                'status' => $row['r_status'],
                'room' => $row['room_name'],
                'userID' => $row['r_user_ID'],
                'eventAdviser'=>$row['r_eventAdviser'],
                'notifID'=>$row['notifID'],
                'remark'=>$row['r_Remarks'],
                'notif_remark'=>$row['remarks'],
                'decision'=>$row['decision'],
            );
        }
    }
    $sql->close();
}
$type = 'user';
$url = '/Window_Panel.php?window=MyReservations';

// $sql_code2 = "SELECT * FROM tbl_join";

$conn->close();
$pagination = getPaginationString($page, $total_items, $limit, false, $url, "&page=", "&category=", $type);
if (count($reservation) != 0) {
    $reservation[count($reservation) - 1] += array(
        'pagination' => $pagination
    );
}

$myJSON = json_encode($reservation);
echo $myJSON;
