<?php
include "db_connection.php";
session_start();
$conn = OpenCon();
$userID = $_SESSION["userID"];
$reset = $_REQUEST['reset'];
$isAdmin = $_SESSION['isAdmin'];
$option;
$notifications = array();
$info = array();
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
    $sql_code = 'SELECT * FROM `tbl_notification` WHERE `forUserID` = ? AND `decision` != 2 ORDER BY `time` DESC LIMIT 10';
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
                    'text' =>'',
                );
            }
        }else{
           echo $conn->error;
        }
        $sql->close();
    }
}else{
    $sql_code = 'SELECT COUNT(*) as num FROM tbl_notification INNER JOIN tbl_reservation ON tbl_notification.notificationID = tbl_reservation.notificationID WHERE tbl_reservation.r_approved_ID = 2 ';
    $sql_code2 = 'SELECT COUNT(*) as num FROM tbl_notification INNER JOIN tbl_user ON tbl_notification.notificationID = tbl_user.notificationID WHERE tbl_user.isApproved = 2 ';
    $sql4=$conn->prepare($sql_code);
    $sql4->execute();
    $result = $sql4->get_result();
    $user = $result->fetch_array(MYSQLI_ASSOC);
    $notifCount = $user['num'];
    $sql4->close();


$sql5=$conn->prepare($sql_code2);
$sql5->execute();
$result = $sql5->get_result();
$user = $result->fetch_array(MYSQLI_ASSOC);
$reservCount = $user['num'];
$sql5->close();
}


    for($i = 0; $i<count($notifications); $i++){
        $decision = $notifications[$i]['decision'];
        if($decision == 1){
            $result = 'approved';
        }else if($decision == 3){
            $result = 'declined';
        }
       if($isAdmin != 1){
            $notifications[$i]["text"] = 'Your reservation has been '. $result;
        }
    }


$conn->close();

if($isAdmin == 1){
        if(!isset($notifCount) && !isset($reservCount)){
            $notifications[0] = array(
                'adminText' => 'Nothing to review'
            );
        }else{
            $notifications[0] = array(
                'adminText' => 'To review:'
            );
          if(isset($notifCount)){
            $notifications[0] += array(
                'adminReservations' => 'There are '.$notifCount.' reservation/s to review'
            );
            }else{
                $notifications[0] += array(
                    'adminText' => 'There is no reservation to review'
                );
            }
            if(isset($reservCount)){
                $notifications[0] += array(
                    'adminRegistration' => 'There are '.$reservCount.' registration/s to review'
                );
            }else{
                $notifications[0] += array(
                    'adminText' => 'There is no registration to review'
                );
            }
          
        }
      
}
    $myJSON =  json_encode($notifications);
    echo $myJSON;
?>