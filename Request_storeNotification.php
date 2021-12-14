<?php
function notification($userID,$decision,$forRegistration){
    $conn = OpenCon();    
    $sql_code = 'INSERT INTO tbl_notification(forUserID,decision,forRegistration) VALUES (?,?,?);';
    if($sql = $conn->prepare($sql_code)){
        $sql->bind_param('iii',$userID,$decision,$forRegistration);
       if($sql->execute()){
           return $conn->insert_id;
       }
    }
    $conn ->close();
}
function update($userID,$decision,$remarks,$type,$notifID){

    $conn = OpenCon();    
    if($type == 1){
        if($remarks == 'undefined'){
            $value = null;
        }else{
            $value = $remarks;
        }
        $sql_code = 'UPDATE tbl_notification SET decision = ?,remarks=? WHERE forUserID = ? AND forRegistration = ?';
        if($sql = $conn->prepare($sql_code)){
            $sql->bind_param('isii',$decision,$value,$userID,$type);
           if($sql->execute()){
           }
        }
        $conn ->close();
    }else if($type == 0){
       if($remarks == 'undefined'){
           $value = null;
       }else{
           $value = $remarks;
       }
        $sql_code = 'UPDATE tbl_notification SET decision = ?,remarks=? WHERE forUserID = ? AND forRegistration = ? AND notificationID = ?';
        if($sql = $conn->prepare($sql_code)){
            $sql->bind_param('isiii',$decision,$value,$userID,$type,$notifID);
           if($sql->execute()){
           }
        }
        $conn ->close();
    }
    
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