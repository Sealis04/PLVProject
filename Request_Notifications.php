<?php
include "db_connection.php";
session_start();
$conn = OpenCon();
$userID = $_SESSION["userID"];
$reset = $_REQUEST['reset'];
$option;
$notifications = array();
if($reset === 1){
    $option = true;
    $sql_code = 'SELECT * FROM `tbl_notification` WHERE `forUserID` = ? ORDER BY `time` DESC LIMIT 10';
    setcookie('loadedNotifications','10',time() + 86400,"/");
}else{
    $option = false;
    $loadedNots =  $_COOKIE['loadedNotifications'];
    $sql_code = 'SELECT * FROM `tbl_notification` WHERE `forUserID` = ? ORDER BY `time` DESC LIMIT ?';
    $loadedNots = (string)($loadedNots+10);
    setCookie("loadedNotifications",$loadedNots,time()+86400,"/");
}
if($sql=$conn->prepare($sql_code)){
    if($option){
        $sql->bind_param('i',$userID);
    }else if(!$option){
        $sql->bind_param('ii',$userID,$loadedNots);
    }
    if($sql->execute()){
        $result = $sql->get_result();
        while($row = $result->fetch_assoc()){
            $notifications[] = array(
                'id' => $row['notificationID'],
                'isRead'=> $row['isRead'],
                'decision' => $row['decision'],
                'userID'=>$row['forUserID'],
                'text' =>''
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
    $notifications[$i]["text"] = 'Your reservation has been '. $result;
}

if(empty($notifications)){
    echo 'No New Notifications';
}else{
    $myJSON =  json_encode($notifications);
    echo $myJSON;
}

?>