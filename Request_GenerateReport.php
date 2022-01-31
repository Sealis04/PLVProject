<?php
//returns array of reservation 
include "db_connection.php";
$conn = OpenCon();
$month = $_REQUEST['month'];
$year = $_REQUEST['year'];

$array = array();
$room = array();
$equip = array();
$broken =array();
$query = "SELECT COUNT(*) as num FROM tbl_reservation as 
res INNER JOIN tbl_room as room ON res.r_room_ID = room.room_ID 
WHERE MONTH(res.DateEnd) = ? AND YEAR(res.DateEnd) = ? AND res.r_approved_ID = 1 AND res.r_status = 0";
$sql5 = $conn->prepare($query);
$sql5->bind_param('ii',$month,$year);
$sql5->execute();
$result = $sql5->get_result();
$user = $result->fetch_array(MYSQLI_ASSOC);
$total_items = $user['num'];
$sql5->close();


$query2 = "SELECT room.room_name, Count(*) as occurences FROM tbl_reservation as 
res INNER JOIN tbl_room as room ON res.r_room_ID = room.room_ID 
WHERE MONTH(res.DateEnd) = ? AND YEAR(res.DateEnd) = ? AND res.r_approved_ID = 1 AND res.r_status = 0
GROUP BY room.room_name";

if($sql=$conn->prepare($query2)){
    $sql->bind_param('ii',$month,$year);
    if($sql->execute()){
        $sql->store_result();
        $sql->bind_result($roomName,$count);
        while($sql->fetch()){
            $room[] = array(
                'x'=> $roomName,
                'value'=>$count
            );
        }
    }
}

$query3 ='SELECT name.equipment_name,Count(*) as occurences FROM tbl_reservation as res 
            INNER JOIn tbl_equipment_reserved as equip
            ON res.r_ID = equip.r_ID
            INNER JOIN tbl_equipment as name
            ON name.equipment_ID = equip.equipment_ID
            WHERE MONTH(res.DateEnd)= ? AND YEAR(res.DateEnd)= ? GROUP BY name.equipment_name';
if($sql2=$conn->prepare($query3)){
    $sql2->bind_param('ii',$month,$year);
    if($sql2->execute()){
        $sql2->store_result();
        $sql2->bind_result($equipName,$count);
        while($sql2->fetch()){
            $equip[] = array(
                'x'=> $equipName,
                'value'=>$count
            );
        }
    }
}

$query5 ='SELECT name.equipment_name,Count(*) as occurences FROM tbl_reservation as res 
INNER JOIn tbl_damagedequipment as equip
ON res.r_ID = equip.r_ID
INNER JOIN tbl_equipment as name
ON name.equipment_ID = equip.equipmentID
WHERE MONTH(res.DateEnd)= ? AND YEAR(res.DateEnd)= ? GROUP BY name.equipment_name';
            if($sql3=$conn->prepare($query5)){
                $sql3->bind_param('ii',$month,$year);
                if($sql3->execute()){
                    $sql3->store_result();
                    $sql3->bind_result($equipName,$count);
                    while($sql3->fetch()){
                        $broken[] = array(
                            'x'=> $equipName,
                            'value'=>$count
                        );
                    }
                }
            }
array_push($array,$room);
array_push($array,$equip);
array_push($array,$total_items);
array_push($array,$broken);
$myJSON = json_encode($array);
echo $myJSON;
