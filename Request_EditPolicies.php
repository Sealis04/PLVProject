<?php
include "db_connection.php";
$pcateg = $_REQUEST['name'];
$pdesc = $_REQUEST['desc'];
$pID = $_REQUEST['ID'];
$conn=OpenCon();
$sql_code = $sqlcode = "UPDATE `tbl_policies` SET `p_description`=?, `p_ct_ID`=? WHERE p_ID = ?";
    if($sql=$conn->prepare($sql_code)){
        $sql->bind_param('sii',$pdesc,$pcateg,$pID);
            $sql->execute();
             $sql->close();
        }
    $conn->close();
?>
