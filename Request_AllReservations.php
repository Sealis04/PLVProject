<?php
$month = $_REQUEST['month'];
$year = $_REQUEST['year'];
$reservation = array();
$equip = array();
include "db_connection.php";
$conn = OpenCon();
include "Backend_Pagination.php";
$page = $_REQUEST['page'];
$limit = 5;
if ($page)
    $start = ($page - 1) * $limit;             //first item to display on this page
else
    $start = 0;
$query = "SELECT COUNT(*) as num FROM tbl_reservation WHERE DateEnd < CURRENT_DATE()
        AND tbl_reservation.r_approved_ID = 1 
        AND tbl_reservation.r_reviewed = 1 
        AND tbl_reservation.isDeleted = 0 AND (CASE WHEN ? != 0
     THEN MONTH(tbl_reservation.DateStart) = ?
     ELSE TRUE
     END)
AND (CASE WHEN ? != 0
THEN YEAR(tbl_reservation.DateStart) = ?
ELSE TRUE
END) ";
$sql5 = $conn->prepare($query);
$sql5->bind_param("iiii",$month,$month,$year,$year);
$sql5->execute();
$result = $sql5->get_result();
$user = $result->fetch_array(MYSQLI_ASSOC);
$total_items = $user['num'];
$sql5->close();


$sql_code = "SELECT res.r_event,res.DateStart,res.DateEnd,res.TimeStart,res.TimeEnd,res.r_approved_ID,res.r_ID,res.r_status,user.user_firstName,user.user_middleName,user.user_lastName,res.r_user_ID,room.room_name,res.r_Remarks,res.r_eventAdviser FROM `tbl_reservation` as res
INNER JOIN tbl_user as user ON res.r_user_ID = user.user_ID 
INNER JOIN tbl_room as room ON res.r_room_ID = room.room_ID 
WHERE res.DateEnd < CURRENT_DATE AND res.r_approved_ID = 1 
AND res.r_reviewed = 1 AND res.r_status = 0 AND res.isDeleted = 0 
AND (CASE WHEN ? != 0
     THEN MONTH(res.DateStart) = ?
     ELSE TRUE
     END)
AND (CASE WHEN ? != 0
THEN YEAR(res.DateStart) = ?    
ELSE TRUE
END)  LIMIT $start,$limit ";
if ($sql = $conn->prepare($sql_code)) {
    $sql->bind_param("iiii",$month,$month,$year,$year);
    if ($sql->execute()) {
        $sql->store_result();
        $sql->bind_result($event,$dateStart,$dateEnd,$timeStart,$timeEnd,$approval,$rID,$status,$fn,$mn,$ln,$userID,$roomName,$remarks,$adviser);
        while ($sql->fetch()){
            $reservation[] = array(
                'eventname' => $event,
                'eventAdviser' => $adviser,
                'dateStart' => $dateStart,
                'dateEnd' => $dateEnd,
                'timeStart' => $timeStart,
                'timeEnd' => $timeEnd,
                'approval' => $approval,
                'r_ID' => $rID,
                'status' => $status,
                'firstName' => $fn,
                'middleName' => $mn,
                'lastName' => $ln,
                'userID' => $userID,
                'roomName' => $roomName,
                'remarks'=>$remarks
            );
            $equipQuery = "SELECT equipment_ID,Qty FROM `tbl_equipment_reserved` WHERE `r_ID` = ?";
            if($sql3=$conn->prepare($equipQuery)){
                $sql3->bind_param('i',$rID);
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
            $equip = array();
        }
    } else {
        echo $conn->error;
    }
    $sql->close();
}
$conn->close();
$url = '/Window_Panel.php?window=Archives';
$type = 'finished';
$pagination = getPaginationString($page, $total_items, $limit, false, $url, "&page=", "&category=", $type,$month,$year);
if (count($reservation) != 0) {
    $reservation[count($reservation) - 1] += array(
        'pagination' => $pagination,
    );
}
$myJSON = json_encode($reservation);
echo $myJSON;
