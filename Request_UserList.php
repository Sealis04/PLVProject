<?php
//returns array of equipment \
$user = array();
include "db_connection.php";
$conn=OpenCon();
$sql_code = "SELECT * FROM tbl_user WHERE isAdmin = 0 and isApproved = 1";
    if($sql=$conn->prepare($sql_code)){
            if($sql->execute()){
                $result = $sql->get_result();
                    while($row = $result->fetch_assoc()){
                    $user[]= array(
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
    $myJSON = json_encode($user);
    echo $myJSON;
?>