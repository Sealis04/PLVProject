<?php
include "Request_CategoryPolicies.php";
$pcateg_ID = $_REQUEST['ID'];
$pdesc = $_REQUEST['desc'];
$categories = [];
$conn=OpenCon();
$var = false;
$sql_code = "SELECT * from tbl_category_policy";
if($sql=$conn->prepare($sql_code)){
    if($sql->execute()){
        $result = $sql->get_result();
        while ($row = $result->fetch_assoc()) {
            $categories [] = array(
                'ct_ID'=>$row['ct_ID'],
                'ct_name'=>$row['ct_category_name'],
            );
        }
    }
}

foreach ($categories as $value) {
    if ($pcateg_ID == $value['ct_ID']) {
        $sql_code4 = "INSERT INTO `tbl_policies`(`p_description`, `p_ct_ID`) VALUES (?,?)";
        if ($sql4 = $conn->prepare($sql_code4)) {
            $sql4->bind_param('si', $pdesc, $pcateg_ID);
            if ($sql4->execute()) {
                $var = true;
            }
            $sql4->close();
        }
    } else if (strtolower($pcateg_ID) == strtolower($value['ct_name'])) {
        $sql_code4 = "INSERT INTO `tbl_policies`(`p_description`, `p_ct_ID`) VALUES (?,?)";
        if ($sql4 = $conn->prepare($sql_code4)) {
            $sql4->bind_param('si', $pdesc, $value['ct_ID']);
            if ($sql4->execute()) {
                $var = true;
            }
            $sql4->close();
        }
    }
}



if($var == false){
    $sql_code3 = "INSERT INTO tbl_category_policy (ct_category_name) VALUES (?)";
    if($sql3=$conn->prepare($sql_code3)){
        $sql3->bind_param('s',$pcateg_ID);
        if($sql3->execute()){
            $lastID = $conn->insert_id;
            $sql_code2 = "INSERT INTO `tbl_policies`(`p_description`, `p_ct_ID`) VALUES (?,?)";
            if($sql2=$conn->prepare($sql_code2)){
                $sql2->bind_param('si',$pdesc,$lastID);
                if($sql2->execute()){
                   echo 'success';
                }
                 $sql2->close();
            }
        }
        $sql3->close();
    }
}


// if($var == false){
//     $conn=OpenCon();
//     $sql_code3 = "INSERT INTO `tbl_category_policy`(`ct_category_name`) VALUES (?)";
//     if($sql3=$conn->prepare($sql_code3)){
//         $sql3->bind_param('s',$pcateg);
//         if($sql3->execute()){
//             $sql_code2 = "INSERT INTO `tbl_policies`(`p_description`, `p_ct_ID`) VALUES (?,?)";
//             if($sql2=$conn->prepare($sql_code2)){
//                 $categ_ID = $sql3->insert_id;
//                 $sql2->bind_param('si',$pdesc,$categ_ID);
//                 if($sql2->execute()){
//                     echo 'success';
//                 }else{
//                     echo $conn->error;
//                 }
//             }
//         }
       
//     }
   
//     $sql2->close();
//     $sql3->close();

// }
$conn->close();
