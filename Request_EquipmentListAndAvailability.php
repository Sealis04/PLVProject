<?php
//returns array of equipment \
$equip = array();
include "db_connection.php";
include "backend_Pagination.php";
$conn=OpenCon();


$window =$_REQUEST['window'];
$page = $_REQUEST['page'];
$limit = 5;
if ($page)
    $start = ($page - 1) * $limit;             //first item to display on this page
else
    $start = 0;	
    $query = "SELECT COUNT(*) as num FROM tbl_equipment WHERE isDeleted=0";
		$sql5=$conn->prepare($query);
			$sql5->execute();
			$result = $sql5->get_result();
			$user = $result->fetch_array(MYSQLI_ASSOC);
			$total_items = $user['num'];
		$sql5->close();
       


$sql_code = "SELECT * FROM tbl_equipment WHERE isDeleted = 0 LIMIT $start,$limit";
    if($sql=$conn->prepare($sql_code)){
            if($sql->execute()){
                $result = $sql->get_result();
                    while($row = $result->fetch_assoc()){
                    $equip[]= array(
                        'equipID'=> $row["equipment_ID"],
                        'equipName' => $row["equipment_name"],
                        'equipQty' => $row["equipment_quantity"],
                        'equipDesc' => $row["equipment_description"],
                        'equipAvailability' => $row['equipment_availability']
                    );
                    }
                }
             $sql->close();
        }
    $url = '/Window_Panel.php?window=';
    $conn->close();
    $pagination = getPaginationString($page,$total_items,$limit,false, $url,"&page=","&category=",'equipment');
    if(count($equip)!=0 ){
        
        $equip [count($equip)-1] += array(
            'pagination' => $pagination,
        );
    }
    $myJSON = json_encode($equip);
    echo $myJSON;
?>