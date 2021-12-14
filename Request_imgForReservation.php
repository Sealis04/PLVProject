<?php
//returns array of reservation \
$rID = $_REQUEST['r_ID'];
session_start();
include "db_connection.php";
$letters = array();
$conn = OpenCon();
$sql_code = "SELECT * FROM tbl_reservation INNER JOIN
tbl_jointable 
ON tbl_reservation.r_ID = tbl_jointable.r_ID
INNER JOIN tbl_letterlist
ON tbl_jointable.letter_ID = tbl_letterlist.letter_ID
WHERE tbl_reservation.r_ID = ?";
    if($sql=$conn->prepare($sql_code)){
        $sql->bind_param("i",$rID);
            if($sql->execute()){
                $result = $sql->get_result();
                while($row = $result->fetch_assoc()){
                    array_push($letters,$row['letter_Path']);
                }
                }
             $sql->close();
        }
    $conn->close();
        $myJSON = json_encode($letters);
        echo $myJSON;
    ?>
