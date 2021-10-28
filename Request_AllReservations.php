<?php
//returns array of reservation
    $reservation = array();
    include "db_connection.php";
    $conn=OpenCon();
    $sql_code = "SELECT * from tbl_reservation ORDER BY r_ID DESC LIMIT 10 ";
        if($sql=$conn->prepare($sql_code)){
                if($sql->execute()){
                    $result = $sql->get_result();
                        while($row = $result->fetch_assoc()){
                            $sql_code2 = "SELECT * FROM tbl_user WHERE user_ID = ?";
                            if ($sql2 = $conn->prepare($sql_code2)) {
                                $sql2->bind_param("i", $row['r_user_ID']);
                                if ($sql2->execute()) {
                                    $result2 = $sql2->get_result();
                                    while ($row2 = $result2->fetch_assoc()) {
                                        $reservation[] = array(
                                            'event' => $row["r_event"],
                                            'start' => $row["r_startDateAndTime"],
                                            'end' => $row["r_endDateAndTime"],
                                            'approval' => $row['r_approved_ID'],
                                            'reservationID' => $row["r_ID"],
                                            'status' => $row['r_status'],
                                            'firstName'=> $row2['user_firstName'],
                                            'middleName'=> $row2['user_middleName'],
                                            'lastName'=> $row2['user_lastName'],
                                            'userID'=>$row['r_user_ID'],
                                            'roomID'=>$row['r_room_ID'],
                                            'imgLetter'=>$row['r_letter_file']
                                        );
                                    }
                                }
                                $sql2->close();
                            }
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