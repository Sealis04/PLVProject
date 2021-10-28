<?php
//returns array of reservation
$policies = array();
include "db_connection.php";
$conn = OpenCon();
$sql_code = "SELECT * from tbl_policies";
if ($sql = $conn->prepare($sql_code)) {
    if ($sql->execute()) {
        $result = $sql->get_result();
        while ($row = $result->fetch_assoc()) {
            $sql_code2 = "SELECT * FROM tbl_category_policy WHERE ct_ID = ?";
            if ($sql2 = $conn->prepare($sql_code2)) {
                $sql2->bind_param('i',$row['p_ct_ID']);
                if ($sql2->execute()) {
                    $result2 = $sql2->get_result();
                    while ($row2 = $result2->fetch_assoc()) {
                        $policies[] = array(
                            'p_description' => $row['p_description'],
                            'p_category'=>$row2['ct_category_name'],
                            'p_ct_ID' => $row['p_ct_ID'],
                            'p_ID' => $row['p_ID'],
                        );
                    }
                }
                $sql2->close();
            }
        }
    } else {
        echo $conn->error;
    }
    $sql->close();
}
$conn->close();
$myJSON = json_encode($policies);
echo $myJSON;
