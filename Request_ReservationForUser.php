<?php
//returns array of reservation 
$userID = $_REQUEST["var"];
$page = $_REQUEST['page'];
$window = $_REQUEST['window'];
$month = $_REQUEST['month'];
$year = $_REQUEST['year'];
$reservation = array();
$letters = array();
$equip = array();
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

$sql_code = "SELECT res.r_ID, res.r_event, res.r_eventAdviser,res.DateStart,res.DateEnd,res.r_approved_ID,
res.TimeStart,res.TimeEnd,res.r_status,room.room_name,res.r_user_ID, res.notifID,
res.r_Remarks,notif.remarks,notif.decision FROM tbl_reservation as res
INNER JOIN tbl_room as room ON res.r_room_ID = room.room_ID
INNER JOIN	tbl_notification as notif ON res.notifID = notif.notificationID
WHERE res.r_user_ID = ? 
AND (CASE WHEN ? != 0
     THEN MONTH(res.DateStart) = ?
     ELSE TRUE
     END)
AND (CASE WHEN ? != 0
THEN YEAR(res.DateStart) = ?
ELSE TRUE
END)
ORDER BY res.r_status, FIELD(res.r_approved_ID,'1') DESC, (CASE WHEN DATE(NOW()) < DATE(res.DateStart)
     THEN 1
     ELSE 0
     END) DESC , res.DateStart LIMIT $start,$limit
";
if ($sql = $conn->prepare($sql_code)) {
    $sql->bind_param('iiiii',$userID,$month,$month,$year,$year);
    $r_user = $userID;
    if ($sql->execute()) {
        $sql->store_result();
        $sql->bind_result($reservationID,$event,$eventAdviser,$dateStart,$dateEnd, $approval,$timeStart,$timeEnd,$status,$room,$userID,$notifID,$remark,$notif_remark,$decision);
        while($sql->fetch()){
             $reservation[] = array(
                'event' => $event,
                'eventAdviser' => $eventAdviser,
                'dateStart' => $dateStart,
                'dateEnd' => $dateEnd,
                'timeStart' => $timeStart,
                'timeEnd' => $timeEnd,
                'approval' => $approval,
                'reservationID' => $reservationID,
                'status' => $status,
                'room' => $room,
                'userID' => $userID,
                'notifID'=>$notifID,
                'remark'=>$remark,
                'notif_remark'=>$notif_remark,
                'decision'=>$decision,
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
    }
    $sql->close();
}
$type = 'user';
$url = '/Window_Panel.php?window=MyReservations';

// $sql_code2 = "SELECT * FROM tbl_join";

$conn->close();
$pagination = getPaginationString($page, $total_items, $limit, false, $url, "&page=", "&category=", $type,$month,$year);
if (count($reservation) != 0) {
    $reservation[count($reservation) - 1] += array(
        'pagination' => $pagination
    );
}

$myJSON = json_encode($reservation);
echo $myJSON;
