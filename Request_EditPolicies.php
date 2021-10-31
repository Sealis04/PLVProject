<?php
$desc = $_REQUEST['desc'];
$name = $_REQUEST['name'];
$ID = $_REQUEST['ID'];
include "db_connection.php";
$conn=OpenCon();
$sql_code = $sqlcode = "UPDATE tbl_policies INNER JOIN tbl_category_policy ON tbl_policies.p_ct_ID = tbl_category_policy.ct_ID SET tbl_policies.p_description = ? , tbl_policies.p_ct_ID = ? WHERE p_ID = ?";
    if($sql=$conn->prepare($sql_code)){
        $sql->bind_param("sii",$desc,$name,$ID);
            if($sql->execute()){
                }
             $sql->close();
        }
    $conn->close();
?>
