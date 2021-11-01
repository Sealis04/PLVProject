<?php
//returns array of reservation 
$userID = $_REQUEST["var"];
$page = $_REQUEST['page'];
$reservation = array();
include "db_connection.php";
include 'Backend_Pagination.php';
$conn = OpenCon();
$limit = 5;
if ($page)
    $start = ($page - 1) * $limit;             //first item to display on this page
else
    $start = 0;	
    $query = "SELECT COUNT(*) as num FROM tbl_reservation WHERE r_user_ID = ? and r_status = 0 AND r_startDateAndTime > CURRENT_DATE()";
		$sql5=$conn->prepare($query);
        $sql5->bind_param("i", $userID);
			$sql5->execute();
			$result2 = $sql5->get_result();
			$user = $result2->fetch_array(MYSQLI_ASSOC);
			$total_items = $user['num'];
		$sql5->close();
$sql_code = "SELECT * FROM tbl_reservation INNER JOIN tbl_room ON tbl_reservation.r_room_ID = tbl_room.room_ID WHERE tbl_reservation.r_user_ID = ? AND tbl_reservation.r_startDateAndTime > CURRENT_DATE() LIMIT $start, $limit";
if($sql= $conn->prepare($sql_code)){
    $sql->bind_param('i',$r_user);
    $r_user = $userID;
    if($sql->execute()){
        $result = $sql->get_result();
        while($row = $result->fetch_assoc()){
            $reservation[] = array(
                'event' => $row["r_event"],
                'start' => $row["r_startDateAndTime"],
                'end' => $row["r_endDateAndTime"],
                'approval' => $row['r_approved_ID'],
                'reservationID' => $row["r_ID"],
                'status' => $row['r_status'],
                'room' => $row['room_name'],
                'userID' => $row['r_user_ID']
            ); 
        }
    }
    $sql->close();
}
$type = 'user';
$conn->close();
$pagination = getPaginationString($page,$total_items,$limit,false,'/Window_AdminPanel.php/',"?page=","&category=",$type);
if(count($reservation) != 0){
    $reservation[count($reservation)-1]+=array(
        'pagination' => $pagination
    );
}
$myJSON = json_encode($reservation);
echo $myJSON;
