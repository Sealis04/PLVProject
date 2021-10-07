<?php
//returns array of reservation
    $reservation = array();
    include "db_connection.php";
    $conn=OpenCon();
    $sql_code = "SELECT * from tbl_equipment_reserved equip INNER JOIN tbl_reservation reserve ON equip.r_ID=reserve.r_ID WHERE reserve.r_startDateAndTime > CURRENT_DATE() AND r_status = 0";
        if($sql=$conn->prepare($sql_code)){
                if($sql->execute()){
                    $result = $sql->get_result();
                        while($row = $result->fetch_assoc()){
                        $reservation[]= array(
                            'event' => $row["r_event"],
                            'start' => $row["r_startDateAndTime"],
                            'end'=>$row["r_endDateAndTime"],
                            'approval'=>$row['r_approved_ID'],
                            'room'=>$row['r_room_ID'],
                            'eventID'=> $row["r_ID"],
                            'equipID'=>$row['equipment_ID'],
                            'qty'=>$row["Qty"]
                        );
                        }
                    }else{
                        echo $conn->error;
                    }
                 $sql->close();
            }
        $conn->close();
        $myJSON = json_encode($reservation);
        echo $myJSON;
// function getEquip(){
//     $equip = array();
//     $conn=OpenCon();
//     $sql_code = "SELECT * FROM tbl_equipment_reserved WHERE r_ID = ?";
//     if($sql=$conn->prepare($sql_code)){
//         $sql->bind_param('i',$)
//     }
// }
?>