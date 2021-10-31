<?php
$id = $_REQUEST['var'];
include "db_connection.php";
$conn=OpenCon();
$sql_code = "UPDATE `tbl_room` SET isDeleted = 1 WHERE room_ID = ?";
    if($sql=$conn->prepare($sql_code)){
        $sql->bind_param("i",$id);
            if($sql->execute()){
                echo "Edit Success";
                }
             $sql->close();
        }
    $conn->close();
?>