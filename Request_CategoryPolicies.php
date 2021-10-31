<?php
//returns array of equipment \
$categories = array();
include "db_connection.php";
$conn=OpenCon();
$sql_code = "SELECT * from tbl_policies INNER JOIN tbl_category_policy ON tbl_policies.p_ct_ID = tbl_category_policy.ct_ID GROUP BY tbl_policies.p_ct_ID";
    if($sql=$conn->prepare($sql_code)){
            if($sql->execute()){
                $result = $sql->get_result();
                    while($row = $result->fetch_assoc()){
                    $categories[]= array(
                      'ct_ID'=> $row['ct_ID'],
                      'ct_Name'=>$row['ct_category_name'],
                    );
                    }
                }
             $sql->close();
        }
    $conn->close();
    $myJSON = json_encode($categories);
    echo $myJSON;
?>