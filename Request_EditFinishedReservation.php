<?php
$reviewed = '1';
$rid = $_REQUEST["var"];
$remarks = $_REQUEST['remark'];
$mark = $_REQUEST['marked'];
$userID = $_REQUEST['userID'];
$reservation = array();
include "db_connection.php";
$conn=OpenCon();
$sql_code = "UPDATE tbl_reservation SET r_reviewed = ?,r_Remarks = ? WHERE r_ID = ?";
    if($sql=$conn->prepare($sql_code)){
        $sql->bind_param('isi',$reviewed,$remarks,$rid);
            if($sql->execute()){
                echo 'success';
                }
             $sql->close();
        }

$sql_code2 = "UPDATE tbl_user SET r_marked = ? WHERE r_ID =?";
if($sql2=$conn->prepare($sql_code2)){
    $sql2->bind_param('ii',$mark,$userID);
        if($sql2->execute()){
            echo 'success';
            }
         $sql2->close();
    }
    $conn->close();
?>
