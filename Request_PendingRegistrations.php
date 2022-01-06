<?php
//returns array of reservation 
$registration = array();
include "db_connection.php";
include "Backend_Pagination.php";
$conn = OpenCon();
$page = $_REQUEST['page'];
$limit = 5;
if ($page)
    $start = ($page - 1) * $limit;             //first item to display on this page
else
    $start = 0;

$query = "SELECT COUNT(*) as num FROM tbl_user WHERE isApproved = 2 AND tbl_user.user_verified = 'verified'";
$sql5 = $conn->prepare($query);
$sql5->execute();
$result = $sql5->get_result();
$user = $result->fetch_array(MYSQLI_ASSOC);
$total_items = $user['num'];


$sql5->close();

$sql_code = "SELECT * FROM tbl_user INNER JOIN tbl_course on tbl_course.course_ID = tbl_user.user_course_ID 
INNER JOIN tbl_section ON tbl_section.s_id = tbl_user.user_s_ID WHERE isApproved = '2' AND tbl_user.user_verified = 'verified' LIMIT $start,$limit";
if ($sql = $conn->prepare($sql_code)) {
    if ($sql->execute()) {
        $result = $sql->get_result();
        while ($row = $result->fetch_assoc()) {
            $registration[] = array(
                'user' => $row["user_ID"],
                'firstName' => $row["user_firstName"],
                'middleName' => $row["user_middleName"],
                'lastName' => $row["user_lastName"],
                'course' => $row['course_name'],
                'email'=>$row['user_email'],
                'section'=>$row['s_section']
            );
        }
    } else {
        echo $conn->error;
    }
    $sql->close();
}
$url = '/Window_Panel.php?window=UserRegistrations';
$type = 'registration';
$conn->close();
$pagination = getPaginationString($page, $total_items, $limit, false, $url, "&page=", "&category=",$type);
if (count($registration) != 0) {
    $registration[count($registration) - 1] += array(
        'pagination' => $pagination
    );
}
$myJSON = json_encode($registration);
echo $myJSON;