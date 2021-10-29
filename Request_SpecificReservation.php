<?php
//returns array of reservation 
$r_ID = $_REQUEST['r_ID'];
$array2 = array();
include "db_connection.php";
$conn = OpenCon();
$sql_code = "SELECT * FROM tbl_reservation WHERE r_approved_ID = 1 AND r_status = 0 AND r_endDateAndTime < CURRENT_DATE() AND r_ID = ?";
if ($sql = $conn->prepare($sql_code)) {
    $sql->bind_param('i',$r_ID);
    if ($sql->execute()) {
        $result = $sql->get_result();
        while($row = $result->fetch_assoc()){
           $sql_code2 = "SELECT * from tbl_user WHERE `user_ID`  = ?";
           if($sql2 = $conn ->prepare($sql_code2)){
               $sql2->bind_param('i',$row['r_user_ID']);
               if($sql2->execute()){
                  $result2 = $sql2->get_result();
                  while($row2 = $result2->fetch_assoc()){
                      $array2 = array(
                          'firstName' => $row2['user_firstName'],
                          'middleName'=> $row2['user_middleName'],
                          'lastName'=>$row2['user_lastName'],
                          'roomID'=>$row['r_room_ID'],
                          'userID' =>$row2['user_ID']
                      );
                  }
               }  
           }
        }
    } else {
        echo $conn->error;
    }
    $sql->close();
}
$conn->close();
$myJSON = json_encode($array2);
echo $myJSON;