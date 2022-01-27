<?php
//returns array of reservation 
$r_ID = $_REQUEST['r_ID'];
$review = $_REQUEST['isReviewed'];
$array2 = array();
$letters = array();
include "db_connection.php";
$conn = OpenCon();
if($review != 'null'){
    $sql_code = "SELECT * FROM tbl_reservation 
    INNER JOIN tbl_user
    ON tbl_reservation.r_user_ID = tbl_user.user_ID
    WHERE tbl_reservation.r_approved_ID = 1 AND tbl_reservation.r_status = 0 
    AND tbl_reservation.r_reviewed = ? 
    AND r_ID = ?";
    if ($sql = $conn->prepare($sql_code)) {
        if($review != 'null'){
            $sql->bind_param('ii',$review,$r_ID);
        }else{
            $sql->bind_param('i',$r_ID);
        }
        if ($sql->execute()) {
            $result = $sql->get_result();
            while ($row = $result->fetch_assoc()) {
                $array2 = array(
                    'firstName' => $row['user_firstName'],
                    'middleName' => $row['user_middleName'],
                    'lastName' => $row['user_lastName'],
                    'roomID' => $row['r_room_ID'],
                    'userID' => $row['user_ID'],
                    'eventName' => $row['r_event'],
                    'eventAdviser' => $row['r_eventAdviser'],
                    'r_ID' => $row['r_ID'],
                    'dateStart' => $row["DateStart"],
                    'dateEnd' => $row["DateEnd"],
                    'timeStart' => $row['TimeStart'],
                    'timeEnd' => $row['TimeEnd'],
                );
            }
        } else {
            echo $conn->error;
        }
        $sql->close();
    }
}else{
    $sql_code = "SELECT user.user_firstName,user.user_middleName,user.user_lastName,user.user_ID,res.r_event,res.r_eventAdviser,res.r_ID, res.DateStart,res.DateEnd,res.TimeStart,res.TimeEnd,course.course_name,section.s_section,room.room_name FROM tbl_reservation res INNER JOIN tbl_user user ON res.r_user_ID = user.user_ID INNER JOIN tbl_room room ON res.r_room_ID = room.room_ID INNER JOIN tbl_course as course ON course.course_ID = user.user_course_ID 
    INNER JOIN tbl_section as section ON section.s_id = user.user_s_ID WHERE res.r_status = 0 AND res.r_ID = ?";
    if($sql = $conn->prepare($sql_code)) {
        $sql->bind_param('i',$r_ID);
        if ($sql->execute()) {
            $sql->store_result();
            $sql->bind_result($fn,$mn,$ln,$userID,$event,$eventAdviser,$rID,$DateStart,$DateEnd,$TimeStart,$TimeEnd,$course,$section,$roomname);
            $result = $sql->get_result();
            while($sql->fetch()){
                    $array2 = array(
                    'firstName' => $fn,
                    'middleName' => $mn,
                    'lastName' => $ln,
                    'userID' => $userID,
                    'eventName' => $event,
                    'eventAdviser' => $eventAdviser,
                    'r_ID' => $rID,
                    'dateStart' => $DateStart,
                    'dateEnd' => $DateEnd,
                    'timeStart' =>$TimeStart,
                    'timeEnd' => $TimeEnd,
                    'course' => $course,
                    'section'=> $section,
                    'roomname'=> $roomname,
                );
            }
        } else {
            echo $conn->error;
        }
        $sql->close();
    }

    $letterquery = "SELECT letter.letter_Path FROM tbl_reservation as res INNER JOIN
    tbl_jointable as jointbl
    ON res.r_ID = jointbl.r_ID
    INNER JOIN tbl_letterlist as letter
    ON jointbl.letter_ID = letter.letter_ID
    WHERE res.r_ID = ?";
    if($sql2=$conn->prepare($letterquery)){
        $sql2->bind_param('i',$rID);
        if($sql2->execute()){
            $sql2->store_result();
            $sql2->bind_result($letterPath);
            while($sql2->fetch()){
                array_push($letters,$letterPath);
            }   
        }
    }
    // array_push($array2[count($array2) - 1],$letters);
    $array2 += array(
        'letters' => $letters,
    );
    $letters = array();
}
$conn->close();
$myJSON = json_encode($array2);
echo $myJSON;
