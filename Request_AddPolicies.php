<?php
include "Request_CategoryPolicies.php";
$pcateg = $_REQUEST['name'];
$pdesc = $_REQUEST['desc'];
$var = false;
foreach($categories as $value){
    $conn=OpenCon();
    if($pcateg == $value['ct_Name']){
        $var = true;
        $sql_code4 = "INSERT INTO `tbl_policies`(`p_description`, `p_ct_ID`) VALUES (?,?)";
        if($sql4=$conn->prepare($sql_code4)){
            $sql4->bind_param('si',$pdesc,$value['ct_ID']);
            $sql4->execute();
             $sql4->close();
        }
    $conn->close();
    } 
}
if($var == false){
    $conn=OpenCon();
    $sql_code3 = "INSERT INTO `tbl_category_policy`(`ct_category_name`) VALUES (?)";
    if($sql3=$conn->prepare($sql_code3)){
        $sql3->bind_param('s',$pcateg);
        if($sql3->execute()){
            $sql_code2 = "INSERT INTO `tbl_policies`(`p_description`, `p_ct_ID`) VALUES (?,?)";
            if($sql2=$conn->prepare($sql_code2)){
                $categ_ID = $sql3->insert_id;
                $sql2->bind_param('si',$pdesc,$categ_ID);
                if($sql2->execute()){
                    echo 'success';
                }else{
                    echo $conn->error;
                }
            }
        }
       
    }
   
    $sql2->close();
    $sql3->close();
$conn->close();

}

?>
