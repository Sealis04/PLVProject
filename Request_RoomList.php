<?php
//returns array of equipment \
$equip = array();
include "db_connection.php";
$conn=OpenCon();
$sql_code = "SELECT * FROM tbl_room WHERE ?";
    if($sql=$conn->prepare($sql_code)){
        $sql->bind_param("i",$room_ID);
        $room_ID = 1;
            if($sql->execute()){
                $result = $sql->get_result();
                    while($row = $result->fetch_assoc()){
                    $equip[]= array(
                        'roomID'=> $row["room_ID"],
                        'roomName' => $row["room_name"],
                        'roomCap' => $row["room_capacity"],
                        'roomDesc' => $row["room_description"]
                    );
                    }
                }
             $sql->close();
        }
    $conn->close();
    $myJSON = json_encode($equip);
    echo $myJSON;
?>