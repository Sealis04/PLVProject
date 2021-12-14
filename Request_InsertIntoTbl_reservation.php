<?php
$infoArr = $_REQUEST['var'];
$fileArr = $_REQUEST['fileName'];
$profArr = json_decode($infoArr, true);
$letterArr = json_decode($fileArr, true);
// $myJSON = json_encode($letterArr);
// echo $myJSON;
$r_IDArray = array();

// Start of form
include "db_connection.php";
include "Request_storeNotification.php";
include "Request_CheckUserDetails.php";
session_start();
$conn = OpenCon();
$userID = $_SESSION["userID"];
for ($count = 0; $count < count($profArr); $count++) {
    $duration = $profArr[$count]['duration'];
    $days = '+ ' . $duration - 1 . 'days';
    $endDate = Date('Y-m-d', strtotime($profArr[$count]['startDate'] . $days));
    $r_IDArray[] = insertReservation($userID, $endDate, $conn, $profArr, $count);
    // echo $r_ID['r_ID'];
}
$letterArray = insertLetter($conn, $letterArr);
echo insertJoinTable($conn, $letterArray, $r_IDArray);
function insertReservation($userID, $endDate, $conn, $profArr, $count)
{
    $notifID = notification($userID, 2);
    $remarks = checkDetails($userID);
    if (!isset($remarks)) {
        $sql_code = "INSERT INTO tbl_reservation (r_user_ID,r_event,r_eventAdviser,r_room_ID,r_approved_ID,notificationID,DateStart,DateEnd,TimeStart,TimeEnd) VALUES (?,?,?,?,?,?,?,?,?,?);";
        if ($sql = $conn->prepare($sql_code)) {
            $sql->bind_param(
                "issiiissss",
                $userID,
                $profArr[$count]['event'],
                $profArr[$count]['adviser'],
                $profArr[$count]['room'],
                $_SESSION['approveID'],
                $notifID,
                $profArr[$count]['startDate'],
                $endDate,
                $profArr[$count]['startTime'],
                $profArr[$count]['endTime']
            );
            if ($sql->execute()) {
                $lastID = $conn->insert_id;
                if (!empty($profArr[$count]['EquipmentStuff'])) {
                    foreach ($profArr[$count]['EquipmentStuff'] as $values) {
                        $eID = $values['ID'];
                        $qtyVal = $values['qty'];
                        insertEquipment($lastID, $conn, $eID, $qtyVal);
                    }
                } else {
                    $eID = NULL;
                    $qtyVal = NULL;
                    insertEquipment($lastID, $conn, $eID, $qtyVal);
                }
                return $lastID;
            } else {
                echo '<script>alert("' . $conn->error . '")</script>';
            }
            $sql->close();
        }
    } else {
        echo '<script>alert("' . $remarks . '")</script>';
    }
}
function insertLetter($conn, $letterArr)
{
    $sql_code = "INSERT INTO tbl_letterlist (letter_Path) VALUES (?);";
    $letter_ID = array();
    foreach ($letterArr as $values) {
        $fullName =  $values['fileSource'];
        $fileTmpPath = $_FILES["letterUpload"]["tmp_name"];
        $fileName = $fullName . "ID";
        move_uploaded_file($fileTmpPath, "assets/" . $fileName);
        if ($sql = $conn->prepare($sql_code)) {
            $sql->bind_param('s', $values['fileSource']);
            if ($sql->execute()) {
                $lastletterID = $conn->insert_id;
                $letter_ID[] = $lastletterID;
                $condition = true;
            } else {
                $condition = false;
                break;
            }
        }
    }
    return $letter_ID;
}

function insertJoinTable($conn, $letterID, $rID)
{
    $sql_code = "INSERT INTO tbl_jointable (r_ID,letter_ID) VALUES(?,?)";
    foreach ($rID as $r_IDs) {
        foreach ($letterID as $letter_IDs) {
            if ($sql = $conn->prepare($sql_code)) {
                $sql->bind_param('ii', $r_IDs, $letter_IDs);
                if ($sql->execute()) {

                } else {
                    echo '<script>alert("' . $conn->error . '")</script>';
                }
            }
        }
    }
    return 'success';
}
function insertEquipment($lastID, $conn, $eID, $qtyVal)
{
    $sql_code_2 = "INSERT INTO tbl_equipment_reserved(r_ID,equipment_ID,Qty) VALUES (?,?,?)";
    if ($sql2 = $conn->prepare($sql_code_2)) {
        $sql2->bind_param("sii", $lastID, $eID, $qtyVal);
        if ($sql2->execute()) {
        } else {
            echo '<script>alert("' . $conn->error . '")</script>';
        }
        $sql2->close();
    }
}
