<?php
function notification($userID,$decision,$type,$rID){
    $conn = OpenCon();    
    $sql_code = 'INSERT INTO tbl_notification(forUserID,decision,isUser,r_ID) VALUES (?,?,?,?);';
    if($sql = $conn->prepare($sql_code)){
        $sql->bind_param('iiii',$userID,$decision,$type,$rID);
        $sql->execute();
    }
    $conn ->close();
}
if (isset($_REQUEST['id'])){
include 'db_connection.php';
    $conn = OpenCon();    
    $sql_code = 'UPDATE `tbl_notification` SET `isRead`= 1 WHERE `notificationID` = ?';
    if($sql = $conn->prepare($sql_code)){
        $sql->bind_param('i',$_REQUEST['id']);
        $sql->execute();
    }
    $conn ->close();
}




// Code for updating notification
// $sql_code = "SELECT `notificationID`  FROM `tbl_notification` WHERE `forUserID` = ?";
// if($sql = $conn->prepare($sql_code)){
// $sql->bind_param('i',$userID);
// if($sql->execute()){
//     $result = $sql->get_result();
//     while($row = $result->fetch_assoc()){

//     }
// }
//}

?>