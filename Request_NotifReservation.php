<?php
//returns array of reservation 
$r_ID = $_REQUEST['id'];
$array2 = array();
include "db_connection.php";
$conn = OpenCon();
$sql_code = "SELECT * FROM tbl_reservation WHERE r_ID = ?";
if ($sql = $conn->prepare($sql_code)) {
    $sql->bind_param('i',$r_ID);
    if ($sql->execute()) {
        $result = $sql->get_result();
        while($row = $result->fetch_assoc()){
            $array2 = array(
                  'start' => $row['r_startDateAndTime'],
                  'end' => $row['r_endDateAndTime'],
                  'eventName'=>$row['r_event'],
            );
        }
    } else {
        echo $conn->error;
    }
    $sql->close();
}
$conn->close();
$myJSON = json_encode($array2);
echo $myJSON;