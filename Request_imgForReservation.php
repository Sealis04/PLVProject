<?php
//returns array of reservation \
$rID = $_REQUEST['r_ID'];
session_start();
include "db_connection.php";
$letters = array();
$conn = OpenCon();
$sql_code = "SELECT * FROM tbl_letterforreservation WHERE r_ID = ?";
    if($sql=$conn->prepare($sql_code)){
        $sql->bind_param("i",$rID);
            if($sql->execute()){
                $result = $sql->get_result();
                while($row = $result->fetch_assoc()){
                    array_push($letters,$row['letterPath']);
                }
                }
             $sql->close();
        }
    $conn->close();
        $myJSON = json_encode($letters);
        echo $myJSON;
    ?>
