<?php
//returns array of equipment \
$userlist = array();
include "db_connection.php";
include "Backend_Pagination.php";
$conn=OpenCon();

$page = $_REQUEST['page'];
$limit = 5;
if ($page)
    $start = ($page - 1) * $limit;             //first item to display on this page
else
    $start = 0;	
    $query = "SELECT COUNT(*) as num FROM tbl_user WHERE isAdmin = 0 and isApproved = 1";
		$sql5=$conn->prepare($query);
			$sql5->execute();
			$result = $sql5->get_result();
			$user = $result->fetch_array(MYSQLI_ASSOC);
			$total_items = $user['num'];
		$sql5->close();


$sql_code = "SELECT * FROM tbl_user WHERE isAdmin = 0 and isApproved = 1 LIMIT $start,$limit";
    if($sql=$conn->prepare($sql_code)){
            if($sql->execute()){
                $result = $sql->get_result();
                    while($row = $result->fetch_assoc()){
                    $userlist[]= array(
                        'userID'=> $row["user_ID"],
                        'userFName' => $row["user_firstName"],
                        'userMDName' => $row["user_middleName"],
                        'userLName' => $row["user_lastName"],
                        'isMarked' => $row['r_marked'],
                        'user_Email'=> $row['user_email']
                    );
                    }
                }
             $sql->close();
        }
    $conn->close();
    $url = '/Window_Panel.php?window=ContentEdit';
    $pagination = getPaginationString($page,$total_items,$limit,false,$url,"&page=","&category=",'userList');
    if(count($userlist)!=0 ){
        $userlist [count($userlist)-1] += array(
            'pagination' => $pagination,
        );
    }
    $myJSON = json_encode($userlist);
    echo $myJSON;
?>