<?php
//returns array of equipment \
$categories = array();
$types = array();
include "db_connection.php";
$conn=OpenCon();

$sql_code2 = "SELECT * from tbl_category_policy";
if($sql2=$conn->prepare($sql_code2)){
        if($sql2->execute()){
            $result2 = $sql2->get_result();
                while($row2 = $result2->fetch_assoc()){
                $types[] = array(
                  'ct_p_ID'=> $row2['ct_ID'],
                  'ct_p_Name'=>$row2['ct_category_name']
                );
                }
            }
         $sql2->close();
    }

    $categories [] = array(
        'innerArray'=> $types,
    );
    $myJSON = json_encode($categories);
    echo $myJSON;
?>