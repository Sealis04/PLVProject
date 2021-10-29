<?php
include "db_connection.php";
session_start();
$conn = OpenCon();
$userID = $_SESSION["userID"];
$reset = $_REQUEST['reset'];
$isAdmin = $_SESSION['isAdmin'];
$option;
$notifications = array();
// if($reset === 1){
//     $option = true;
//     $sql_code = 'SELECT * FROM `tbl_notification` WHERE `forUserID` = ? ORDER BY `time` DESC LIMIT 10';
//     setcookie('loadedNotifications','10',time() + 86400,"/");
// }else{
//     $option = false;
//     $loadedNots =  $_COOKIE['loadedNotifications'];
//     $sql_code = 'SELECT * FROM `tbl_notification` WHERE `forUserID` = ? ORDER BY `time` DESC LIMIT ?';
//     $loadedNots = (string)($loadedNots+10);
//     setCookie("loadedNotifications",$loadedNots,time()+86400,"/");
// }
if($isAdmin != 1){
    $sql_code = 'SELECT * FROM `tbl_notification` WHERE `forUserID` = ? AND type = 1 ORDER BY `time` DESC LIMIT 10';
}else{
    $sql_code = 'SELECT * FROM `tbl_notification` WHERE type = 0 ORDER BY `time` DESC LIMIT 10';
}

if($sql=$conn->prepare($sql_code)){
    if($isAdmin != 1){
        $sql->bind_param('i',$userID);
    }
    if($sql->execute()){ 
        $result = $sql->get_result();
        while($row = $result->fetch_assoc()){
            $notifications[] = array(
                'id' => $row['notificationID'],
                'isRead'=> $row['isRead'],
                'decision' => $row['decision'],
                'userID'=>$row['forUserID'],
                'r_ID'=>$row['r_ID'],
                'text' =>'',
            );
        }
    }else{
       echo $conn->error;
    }
    $sql->close();
}


for($i = 0; $i<count($notifications); $i++){
    $decision = $notifications[$i]['decision'];
    if($decision == 1){
        $result = 'approved';
    }else if($decision == 3){
        $result = 'declined';
    }
  //  if($isAdmin != 1){
        $notifications[$i]["text"] = 'Your reservation has been '. $result;
    // }else{
    //     $sql_code2 = 'SELECT * FROM `tbl_reservation` WHERE r_ID = ?';
    //     if($sql2=$conn->prepare($sql_code2)){
    //         $sql2->bind_param('i',$row['r_ID']);
    //         if($sql2->execute()){ 
    //             $result2 = $sql2->get_result();
    //             while($row = $result2->fetch_assoc()){
    //             }
    //         }else{
    //            echo $conn->error;
    //         }
    //         $sql->close();
    //     }
    //     $notifications[$i]['text']='A user has made a reservation for';
    // }
  
}
$conn->close();
if(empty($notifications)){
    echo 'No New Notifications';
}else{
    $myJSON =  json_encode($notifications);
    echo $myJSON;
}

?>