<?php
//returns array of equipment \
$equip = array();
include "db_connection.php";
include "Backend_Pagination.php";
$conn=OpenCon();



$page = $_REQUEST['page'];
$limit = 5;
if ($page)
    $start = ($page - 1) * $limit;             //first item to display on this page
else
    $start = 0;	
    $query = "SELECT COUNT(*) as num FROM tbl_room WHERE isDeleted=0";
		$sql5=$conn->prepare($query);
			$sql5->execute();
			$result = $sql5->get_result();
			$user = $result->fetch_array(MYSQLI_ASSOC);
			$total_items = $user['num'];
		$sql5->close();
       
$sql_code = "SELECT * FROM tbl_room WHERE isDeleted = 0 LIMIT $start,$limit";
    if($sql=$conn->prepare($sql_code)){
        $room_ID = 1;
            if($sql->execute()){
                $result = $sql->get_result();
                    while($row = $result->fetch_assoc()){
                    $equip[]= array(
                        'roomID'=> $row["room_ID"],
                        'roomName' => $row["room_name"],
                        'roomCap' => $row["room_capacity"],
                        'roomDesc' => $row["room_description"],
                        'roomAvailability' => $row['room_availability'],
                        'imgPath' =>$row['imgPath']
                    );
                    }
                }
             $sql->close();
        }
    $conn->close();
    $url = '/Window_Panel.php?window=ContentEdit';
    $pagination = getPaginationString($page,$total_items,$limit,false,$url,"&page=","&category=",'room');
    if(count($equip)!=0 ){
        $equip [count($equip)-1] += array(
            'pagination' => $pagination,
        );
    }
    $myJSON = json_encode($equip);
    echo $myJSON;
?>