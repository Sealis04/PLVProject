<?php
//returns array of reservation 
$r_ID = $_REQUEST['r_ID'];
$review = $_REQUEST['isReviewed'];
$array2 = array();
$letters = array();
$equip = array();
include "db_connection.php";
$conn = OpenCon();
if ($review != 'null') {
    $sql_code = "SELECT user.user_firstName,user.user_middleName,user.user_lastName,room.room_name,user.user_ID,res.r_event,res.r_eventAdviser,res.r_ID
    ,res.DateStart,res.DateEnd,res.TimeStart,res.TimeEnd FROM tbl_reservation res
        INNER JOIN tbl_user user
        ON res.r_user_ID = user.user_ID
        INNER JOIN tbl_room room 
        ON res.r_room_ID = room.room_ID
        WHERE res.r_approved_ID = 1 AND res.r_status = 0 
        AND res.r_reviewed = ? 
        AND res.r_ID = ?";
    if ($sql = $conn->prepare($sql_code)) {
        $sql->bind_param('ii', $review, $r_ID);
        if ($sql->execute()) {
            $sql->store_result();
            $sql->bind_result($fn, $mn, $ln, $roomName, $userID, $event, $adviser, $rid, $DateStart, $DateEnd, $TimeStart, $TimeEnd);
            while ($sql->fetch()) {
                $array2 = array(
                    'firstName' => $fn,
                    'middleName' => $mn,
                    'lastName' => $ln,
                    'roomName' => $roomName,
                    'userID' => $userID,
                    'eventName' => $event,
                    'eventAdviser' => $adviser,
                    'r_ID' => $rid,
                    'dateStart' => $DateStart,
                    'dateEnd' => $DateEnd,
                    'timeStart' => $TimeStart,
                    'timeEnd' => $TimeEnd,
                );
                $equipQuery = "SELECT equipment_ID,Qty FROM `tbl_equipment_reserved` WHERE `r_ID` = ?";
                if ($sql3 = $conn->prepare($equipQuery)) {
                    $sql3->bind_param('i', $rid);
                    if ($sql3->execute()) {
                        $sql3->store_result();
                        $sql3->bind_result($equipmentID, $Qty);
                        while ($sql3->fetch()) {
                            $equipnamequery = "SELECT equipment_name FROM tbl_equipment WHERE equipment_ID = ?";
                            if ($sql4 = $conn->prepare($equipnamequery)) {
                                $sql4->bind_param('i', $equipmentID);
                                if ($sql4->execute()) {
                                    $sql4->store_result();
                                    $sql4->bind_result($equipName);
                                    while ($sql4->fetch()) {
                                        $equip[] = array(
                                            'equipName' => $equipName,
                                            'qty' => $Qty,
                                        );
                                    }
                                }
                            }
                        }
                    }
                }
                array_push($reservation[count($reservation) - 1], $equip);
                $equip = array();
            }
        } else {
            echo $conn->error;
        }
        $sql->close();
    }
} else {
    $sql_code = "SELECT user.user_firstName,user.user_middleName,user.user_lastName,user.user_ID,res.r_event,res.r_eventAdviser,res.r_ID, res.DateStart,res.DateEnd,res.TimeStart,res.TimeEnd,course.course_name,section.s_section,room.room_name FROM tbl_reservation res INNER JOIN tbl_user user ON res.r_user_ID = user.user_ID INNER JOIN tbl_room room ON res.r_room_ID = room.room_ID INNER JOIN tbl_course as course ON course.course_ID = user.user_course_ID 
    INNER JOIN tbl_section as section ON section.s_id = user.user_s_ID WHERE res.r_status = 0 AND res.r_ID = ?";
    if ($sql = $conn->prepare($sql_code)) {
        $sql->bind_param('i', $r_ID);
        if ($sql->execute()) {
            $sql->store_result();
            $sql->bind_result($fn, $mn, $ln, $userID, $event, $eventAdviser, $rID, $DateStart, $DateEnd, $TimeStart, $TimeEnd, $course, $section, $roomname);
            while ($sql->fetch()) {
                $letterquery = "SELECT letter.letter_Path FROM tbl_reservation as res INNER JOIN
                tbl_jointable as jointbl
                ON res.r_ID = jointbl.r_ID
                INNER JOIN tbl_letterlist as letter
                ON jointbl.letter_ID = letter.letter_ID
                WHERE res.r_ID = ?";
                if ($sql2 = $conn->prepare($letterquery)) {
                    $sql2->bind_param('i', $rID);
                    if ($sql2->execute()) {
                        $sql2->store_result();
                        $sql2->bind_result($letterPath);
                        while ($sql2->fetch()) {
                            array_push($letters, $letterPath);
                        }
                    }
                }

                $equipQuery = "SELECT equipment_ID,Qty FROM `tbl_equipment_reserved` WHERE `r_ID` = ?";
                if ($sql3 = $conn->prepare($equipQuery)) {
                    $sql3->bind_param('i', $rID);
                    if ($sql3->execute()) {
                        $sql3->store_result();
                        $sql3->bind_result($equipmentID, $Qty);
                        while ($sql3->fetch()) {
                            $equipnamequery = "SELECT equipment_name FROM tbl_equipment WHERE equipment_ID = ?";
                            if ($sql4 = $conn->prepare($equipnamequery)) {
                                $sql4->bind_param('i', $equipmentID);
                                if ($sql4->execute()) {
                                    $sql4->store_result();
                                    $sql4->bind_result($equipName);
                                    while ($sql4->fetch()) {
                                        $equip[] = array(
                                            'equipName' => $equipName,
                                            'qty' => $Qty,
                                        );
                                    }
                                }
                            }
                        }
                    }
                }

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
                    'timeStart' => $TimeStart,
                    'timeEnd' => $TimeEnd,
                    'course' => $course,
                    'section' => $section,
                    'roomname' => $roomname,
                    'letters' => $letters,
                    'equip' => $equip,
                );
                $equip = array();
                $letters = array();
            }
        } else {
            echo $conn->error;
        }
        $sql->close();
    }
}
$conn->close();
$myJSON = json_encode($array2);
echo $myJSON;
