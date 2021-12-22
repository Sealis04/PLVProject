<?php
//returns array of reservation
$policies = array();
include "db_connection.php";
include "Backend_Pagination.php";
$conn=OpenCon();



$page = $_REQUEST['page'];
$limit = 5;
if ($page)
    $start = ($page - 1) * $limit;             //first item to display on this page
else
    $start = 0;	
    $query = "SELECT COUNT(*) as num FROM tbl_policies WHERE isDeleted=0";
		$sql5=$conn->prepare($query);
			$sql5->execute();
			$result = $sql5->get_result();
			$user = $result->fetch_array(MYSQLI_ASSOC);
			$total_items = $user['num'];
		$sql5->close();
       

$sql_code = "SELECT * FROM tbl_policies INNER JOIN tbl_category_policy ON tbl_policies.p_ct_ID = tbl_category_policy.ct_ID WHERE isDeleted = 0 LIMIT $start,$limit";
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
$url = '/Window_Panel.php?window=ContentEdit';
$conn->close();
$pagination = getPaginationString($page,$total_items,$limit,false,$url,"&page=","&category=",'policies');
if(count($policies)!=0 ){
    $policies [count($policies)-1] += array(
        'pagination' => $pagination,
    );
}
$myJSON = json_encode($policies);
echo $myJSON;
