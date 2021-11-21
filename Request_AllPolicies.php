<?php
//returns array of reservation
$policies = array();
include "db_connection.php";
$conn=OpenCon();
$sql_code = "SELECT * FROM tbl_policies INNER JOIN tbl_category_policy ON tbl_policies.p_ct_ID = tbl_category_policy.ct_ID WHERE isDeleted = 0";
if ($sql = $conn->prepare($sql_code)) {
    if ($sql->execute()) {
        $result = $sql->get_result();
        while ($row = $result->fetch_assoc()) {
                $policies[] = array(
                    'p_description' => $row['p_description'],
                    'p_category'=>$row['ct_category_name'],
                    'p_ct_ID' => $row['p_ct_ID'],
                    'p_ID' => $row['p_ID'],
                );
            
        }
    } else {
        echo $conn->error;
    }
    $sql->close();
}
$myJSON = json_encode($policies);
echo $myJSON;
