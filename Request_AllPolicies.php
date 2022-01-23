<?php
//returns array of reservation
$policies = array();
include "db_connection.php";
$conn=OpenCon();
$sql_code = "SELECT tbl_policies.p_description,tbl_policies.p_ct_ID,tbl_policies.p_ID,tbl_category_policy.ct_category_name 
FROM tbl_policies INNER JOIN tbl_category_policy ON tbl_policies.p_ct_ID = tbl_category_policy.ct_ID WHERE isDeleted = 0";
if ($sql = $conn->prepare($sql_code)) {
    if ($sql->execute()) {
        $sql->store_result();
        $sql->bind_result($p_description,$p_ct_ID,$p_ID,$ct_category_name);
        while($sql->fetch()){
            $policies[] = array(
                'p_description' => $p_description,
                'p_category'=>$ct_category_name,
                'p_ct_ID' => $p_ct_ID,
                'p_ID' => $p_ID
            );
        }
    } else {
        echo $conn->error;
    }
    $sql->close();
}
$myJSON = json_encode($policies);
echo $myJSON;
