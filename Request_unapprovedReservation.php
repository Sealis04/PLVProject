<?php
//returns array of reservation 
$reservation = array();
include "db_connection.php";
include "Backend_Pagination.php";
$conn = OpenCon();
$page = $_REQUEST['page'];
$letters = array();
$equip = array();
$limit = 5;
if ($page)
    $start = ($page - 1) * $limit;             //first item to display on this page
else
    $start = 0;	
    $query = "SELECT COUNT(*) as num FROM `tbl_reservation` INNER JOIN tbl_user ON tbl_reservation.r_user_ID = tbl_user.user_ID 
    INNER JOIN tbl_room ON tbl_reservation.r_room_ID = tbl_room.room_ID 
    INNER JOIN tbl_notification ON tbl_notification.notificationID = tbl_reservation.notifID 
    WHERE (tbl_reservation.r_approved_ID = 2 OR tbl_reservation.r_approved_ID = 1) 
    AND tbl_reservation.r_status = 0 AND tbl_notification.forRegistration = 0 
    AND r_reviewed = 0 AND DateEnd > CURDATE()";
		$sql5=$conn->prepare($query);
			$sql5->execute();
			$result = $sql5->get_result();
			$user = $result->fetch_array(MYSQLI_ASSOC);
			$total_items = $user['num'];
		$sql5->close();
       
$sql_code = "SELECT res.r_event,res.r_eventAdviser,res.DateStart,res.DateEnd,res.TimeStart,res.TimeEnd,res.r_approved_ID,res.r_ID,res.r_status,user.user_firstName,
user.user_middleName,user.user_lastName,res.r_user_ID,room.room_name,res.notifID,notif.remarks FROM tbl_reservation as res
INNER JOIN tbl_user as user ON res.r_user_ID = user.user_ID 
INNER JOIN tbl_room as room ON res.r_room_ID = room.room_ID 
INNER JOIN tbl_notification as notif ON notif.notificationID = res.notifID 
WHERE (res.r_approved_ID = 2 OR res.r_approved_ID = 1) 
AND res.r_status = 0 AND notif.forRegistration = 0 
AND res.r_reviewed = 0 AND res.DateEnd > CURDATE() ORDER BY res.r_approved_ID DESC, res.DateStart LIMIT $start,$limit";
if ($sql = $conn->prepare($sql_code)) {
    if ($sql->execute()) {
        $sql->store_result();
        $sql->bind_result($event,$eventAdviser,$DateStart,$DateEnd,$TimeStart,$TimeEnd,$approved,$reservationID,$status,$fn,$mn,$ln,$userID,$roomName,$notifID,$notifRemarks);
        while ($sql->fetch()) {
                        $reservation[] = array(
                            'event' => $event,
                            'eventAdviser' => $eventAdviser,
                            'dateStart' => $DateStart,
                            'dateEnd' => $DateEnd,
                            'timeStart' =>$TimeStart,
                            'timeEnd' => $TimeEnd,
                            'approval' => $approved,
                            'reservationID' => $reservationID,
                            'status' => $status,
                            'firstName'=> $fn,
                            'middleName'=> $mn,
                            'lastName'=> $ln,
                            'userID'=>$userID,
                            'notifID'=>$notifID,
                            'remarks'=>$notifRemarks,
                            'room_name'=>$roomName,
                        );

                        $letterquery = "SELECT letter.letter_Path FROM tbl_reservation as res INNER JOIN
                        tbl_jointable as jointbl
                        ON res.r_ID = jointbl.r_ID
                        INNER JOIN tbl_letterlist as letter
                        ON jointbl.letter_ID = letter.letter_ID
                        WHERE res.r_ID = ?";
                        if($sql2=$conn->prepare($letterquery)){
                            $sql2->bind_param('i',$reservationID);
                            if($sql2->execute()){
                                $sql2->store_result();
                                $sql2->bind_result($letterPath);
                                while($sql2->fetch()){
                                    array_push($letters,$letterPath);
                                }
                            }
                        }
                        $equipQuery = "SELECT equipment_ID,Qty FROM `tbl_equipment_reserved` WHERE `r_ID` = ?";
                        if($sql3=$conn->prepare($equipQuery)){
                            $sql3->bind_param('i',$reservationID);
                            if($sql3->execute()){
                                $sql3->store_result();
                                $sql3->bind_result($equipmentID,$Qty);
                                while($sql3->fetch()){
                                    $equipnamequery = "SELECT equipment_name FROM tbl_equipment WHERE equipment_ID = ?";
                                    if($sql4=$conn->prepare($equipnamequery)){
                                        $sql4->bind_param('i',$equipmentID);
                                        if($sql4->execute()){
                                            $sql4->store_result();
                                            $sql4->bind_result($equipName);
                                            while($sql4->fetch()){
                                                $equip[] = array(
                                                    'equipName'=> $equipName,
                                                    'qty' => $Qty,
                                                );
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        array_push($reservation[count($reservation) - 1],$equip);
                        array_push($reservation[count($reservation) - 1],$letters);
                        $equip = array();
                        $letters = array();
        }
    } else {
        echo $conn->error;
    }
    $sql->close();
}
$url = '/Window_Panel.php?window=UserReservation';
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

