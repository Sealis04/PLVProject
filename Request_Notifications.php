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
    $sql_code = 'SELECT * FROM `tbl_notification` WHERE `forUserID` = ? AND isUser = 1 ORDER BY `time` DESC LIMIT 10';
}else{
    $sql_code = 'SELECT * FROM `tbl_notification` WHERE isUser = 0 ORDER BY `time` DESC LIMIT 10';
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
   if($isAdmin != 1){
        $notifications[$i]["text"] = 'Your reservation has been '. $result;
    }else{
        $sql_code2 = 'SELECT * FROM `tbl_reservation` WHERE r_ID = ?';
        if($sql2=$conn->prepare($sql_code2)){
            $sql2->bind_param('i',$notifications[$i]['r_ID']);
            if($sql2->execute()){ 
                $result2 = $sql2->get_result();
                while($row = $result2->fetch_assoc()){
                    $sql_code3 = 'SELECT * FROM `tbl_room` WHERE room_ID = ?';
                    if($sql3=$conn->prepare($sql_code3)){
                        $sql3->bind_param('i',$row['r_room_ID']);
                        if($sql3->execute()){ 
                            $result3 = $sql3->get_result();
                            while($row3 = $result3->fetch_assoc()){
                                $notifications[$i] += array(
                                    'roomName'=> $row3['room_name']
                                );
                            }
                        }else{
                           echo $conn->error;
                        }
                        $sql3->close();
                }
            }
            }else{
               echo $conn->error;
            }
            $sql2->close();
        }
        $notifications[$i]['text']='There are '.count($notifications).' reservation requests to be reviewed';
    }
  
}
$conn->close();
    $myJSON =  json_encode($notifications);
    echo $myJSON;
?>