<?php
//returns array of reservation 
$reservation = array();
include "db_connection.php";
include "Backend_Pagination.php";
$conn = OpenCon();

$page = $_REQUEST['page'];
$limit = 5;
if ($page)
    $start = ($page - 1) * $limit;             //first item to display on this page
else
    $start = 0;
$query = "SELECT COUNT(*) as num FROM tbl_reservation WHERE r_approved_ID = 1 AND r_status = 0 AND r_reviewed = 0
AND DateEnd < CURRENT_DATE() ";
$sql5 = $conn->prepare($query);
$sql5->execute();
$result = $sql5->get_result();
$user = $result->fetch_array(MYSQLI_ASSOC);
$total_items = $user['num'];
$sql5->close();


$sql_code = "SELECT * FROM tbl_reservation 
WHERE r_approved_ID = 1 AND r_status = 0 AND r_reviewed = 0 AND DateEnd < CURRENT_DATE() LIMIT $start,$limit";
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

$url = '/Window_Panel.php?window=Monitoring';
$type = 'review';
$pagination = getPaginationString($page, $total_items, $limit, false, $url, "&page=", "&category=", $type);
if (count($reservation) != 0) {
    $reservation[count($reservation) - 1] += array(
        'pagination' => $pagination,
    );
}

$myJSON = json_encode($reservation);
echo $myJSON;
