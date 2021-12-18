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
    $query = "SELECT COUNT(*) as num FROM `tbl_reservation` 
    WHERE r_approved_ID = 2 OR 1 AND r_status = 0 ORDER BY dateStart, r_approved_ID ";
		$sql5=$conn->prepare($query);
			$sql5->execute();
			$result = $sql5->get_result();
			$user = $result->fetch_array(MYSQLI_ASSOC);
			$total_items = $user['num'];
		$sql5->close();
       
$sql_code = "SELECT * FROM `tbl_reservation`
INNER JOIN tbl_user ON tbl_reservation.r_user_ID = tbl_user.user_ID 
INNER JOIN tbl_room ON tbl_reservation.r_room_ID = tbl_room.room_ID 
INNER JOIN tbl_notification ON tbl_notification.notificationID = tbl_reservation.notifID 
WHERE tbl_reservation.r_approved_ID = 2 OR tbl_reservation.r_approved_ID = 1 AND tbl_reservation.r_status = 0 
AND tbl_notification.forRegistration = 0 ORDER BY dateStart, r_approved_ID DESC LIMIT $start,$limit";
if ($sql = $conn->prepare($sql_code)) {
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
                            'firstName'=> $row['user_firstName'],
                            'middleName'=> $row['user_middleName'],
                            'lastName'=> $row['user_lastName'],
                            'userID'=>$row['r_user_ID'],
                            'roomID'=>$row['r_room_ID'],
                            'notifID'=>$row['notifID'],
                            'remarks'=>$row['remarks'],
                            'room_name'=>$row['room_name'],
                        );
        }
    } else {
        echo $conn->error;
    }
    $sql->close();
}
$url = '/Window_Panel.php?window=';
$type = 'pending';
$conn->close();
$pagination = getPaginationString($page,$total_items,$limit,false,$url,"&page=","&category=",$type);
if(count($reservation)!=0){
	$reservation[count($reservation)-1]+=array(
		'pagination' => $pagination
	);
}

$myJSON = json_encode($reservation);
echo $myJSON;

