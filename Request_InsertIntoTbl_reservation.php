<?php
$infoArr = $_REQUEST['var'];
$profArr = json_decode($infoArr, true);
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
    $endDate = $profArr[$count]['endDate'];
    $r_IDArray[] = insertReservation($userID, $endDate, $conn, $profArr, $count);
}
$letterArray = insertLetter($conn);
echo insertJoinTable($conn, $letterArray, $r_IDArray);
function insertReservation($userID, $endDate, $conn, $profArr, $count)
{
    $notifID = notification($userID, 2,0);
    $remarks = checkDetails($userID);
    if (!isset($remarks)) {
        $sql_code = "INSERT INTO tbl_reservation (r_user_ID,r_event,r_eventAdviser,r_room_ID,r_approved_ID,DateStart,DateEnd,TimeStart,TimeEnd,notifID) VALUES (?,?,?,?,?,?,?,?,?,?);";
        if ($sql = $conn->prepare($sql_code)) {
            $sql->bind_param(
                "issiissssi",
                $userID,
                $profArr[$count]['event'],
                $profArr[$count]['adviser'],
                $profArr[$count]['room'],
                $_SESSION['approveID'],
                $profArr[$count]['startDate'],
                $endDate,
                $profArr[$count]['startTime'],
                $profArr[$count]['endTime'],
                $notifID
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

function insertLetter($conn)
{
    $sql_code = "INSERT INTO tbl_letterlist (letter_Path) VALUES (?);";
    $letter_ID = array();
    $valid_ext = array('jpg', 'png', 'jpeg');
    $fileCount =  count($_FILES['letterUpload']['name']);
    for ($i = 0; $i < $fileCount; $i++) {
        $fileTmpPath = $_FILES['letterUpload']['tmp_name'][$i];
        $fileName = $_FILES['letterUpload']['name'][$i];
        $path = "assets/" . $fileName;
        $fileextension = pathinfo($path, PATHINFO_EXTENSION);
        $fileextension = strtolower($fileextension);
        if (in_array($fileextension, $valid_ext)) {
            if (move_uploaded_file($fileTmpPath, $path)) {
                if ($sql = $conn->prepare($sql_code)) {
                    $sql->bind_param('s', $path);
                    if ($sql->execute()) {
                        $lastletterID = $conn->insert_id;
                        $letter_ID[] = $lastletterID;
                    } else {
                        break;
                    }
                }
            }
        }
    }
    // move_uploaded_file($fileTmpPath, "assets/" . $fileName);
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
