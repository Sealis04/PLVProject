<?php
//returns array of reservation 
    $reservation = array();
    include "db_connection.php";
    $conn=OpenCon();
    $sql_code = "SELECT * FROM tbl_reservation WHERE r_approved_ID = 2 AND r_status = 0 AND r_startDateAndTime > CURRENT_DATE();";
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
                            'userID'=> $row['r_user_ID'],
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
?>