<?php
//returns array of reservation \
$userID = $_REQUEST['userID'];
session_start();
include "db_connection.php";
$letters = array();
$conn = OpenCon();
$sql_code = "SELECT * FROM tbl_letterforregistration WHERE u_ID = ?";
    if($sql=$conn->prepare($sql_code)){
        $sql->bind_param("i",$userID);
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
