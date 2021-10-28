<?php
include "db_connection.php";
$conn=OpenCon();
$sql_code = $sqlcode = "UPDATE `tbl_policies` SET `p_description`=? `p_ct_ID`=? WHERE p_ID = ?";
    if($sql=$conn->prepare($sql_code)){
        $sql->bind_param("sssiii",$eventName,$start,$end,$equipID,$roomID,$rid);
            if($sql->execute()){
                }
             $sql->close();
        }
    $conn->close();
?>
