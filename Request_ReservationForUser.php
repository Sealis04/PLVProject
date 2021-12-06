<?php
//returns array of reservation 
$userID = $_REQUEST["var"];
$page = $_REQUEST['page'];
$window = $_REQUEST['window'];
$reservation = array();
include "db_connection.php";
include 'Backend_Pagination.php';
$conn = OpenCon();
$limit = 5;
if ($page)
    $start = ($page - 1) * $limit;             //first item to display on this page
else
    $start = 0;
$query = "SELECT COUNT(*) as num FROM tbl_reservation WHERE r_user_ID = ? and r_status = 0 ";
$sql5 = $conn->prepare($query);
$sql5->bind_param("i", $userID);
$sql5->execute();
$result2 = $sql5->get_result();
$user = $result2->fetch_array(MYSQLI_ASSOC);
$total_items = $user['num'];
$sql5->close();
$sql_code = "SELECT * FROM tbl_reservation INNER JOIN tbl_room ON tbl_reservation.r_room_ID = tbl_room.room_ID WHERE tbl_reservation.r_user_ID = ? ORDER BY tbl_reservation.DateStart  DESC LIMIT $start, $limit";
if ($sql = $conn->prepare($sql_code)) {
    $sql->bind_param('i', $r_user);
    $r_user = $userID;
    if ($sql->execute()) {
        $result = $sql->get_result();
        while ($row = $result->fetch_assoc()) {
            $reservation[] = array(
                'event' => $row["r_event"],
                'dateStart' => $row["DateStart"],
                'dateEnd' => $row["DateEnd"],
                'timeStart' => $row['TimeStart'],
                'timeEnd' => $row['TimeEnd'],
                'approval' => $row['r_approved_ID'],
                'reservationID' => $row["r_ID"],
                'status' => $row['r_status'],
                'room' => $row['room_name'],
                'userID' => $row['r_user_ID'],
                'ImgLetter' => $row['r_letter_file'],
            );
        }
    }
    $sql->close();
}
$type = 'user';
$url = '/Window_Panel.php?window=';
$conn->close();
$pagination = getPaginationString($page, $total_items, $limit, false, $url, "&page=", "&category=", $type);
if (count($reservation) != 0) {
    $reservation[count($reservation) - 1] += array(
        'pagination' => $pagination
    );
}
$myJSON = json_encode($reservation);
echo $myJSON;
