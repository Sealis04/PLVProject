<?php
//returns array of reservation 
$reservation = array();
$equip = array();
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


$sql_code = "SELECT user.user_firstName,user.user_middleName,
user.user_lastName,room.room_name,user.user_ID,res.r_event,res.r_eventAdviser,res.r_ID
,res.DateStart,res.DateEnd,res.TimeStart,res.TimeEnd FROM tbl_reservation res
    INNER JOIN tbl_user user
    ON res.r_user_ID = user.user_ID
    INNER JOIN tbl_room room 
    ON res.r_room_ID = room.room_ID
WHERE r_approved_ID = 1 AND r_status = 0 AND r_reviewed = 0 AND DateEnd < CURRENT_DATE() 
ORDER BY DateEnd LIMIT $start,$limit";
if ($sql = $conn->prepare($sql_code)) {
    if ($sql->execute()) {
        $sql->store_result();
        $sql->bind_result($fn,$mn,$ln,$roomName,$userID,$event,$adviser,$rID,$DateStart,$DateEnd,$TimeStart,$TimeEnd);
        while ($sql->fetch()) {
            $reservation[] = array(
                'firstName' => $fn,
                'middleName' => $mn,
                'lastName' => $ln,
                'roomName' => $roomName,
                'userID' => $userID,
                'eventname' => $event,
                'eventAdviser' => $adviser,
                'r_ID' => $rID,
                'dateStart' => $DateStart,
                'dateEnd' => $DateEnd,
                'timeStart' => $TimeStart,
                'timeEnd' => $TimeEnd
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
                                            'ID'=>$equipmentID
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
