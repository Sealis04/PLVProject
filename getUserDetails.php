<?php
$courseID = $_REQUEST["var"];
// $conn=OpenCon();
// $user_ID = $_REQUEST["var"];
// $sql_code = "SELECT * from tbl_user WHERE user_ID = ?";
// if($sql=$conn->prepare($sql_code)){
//     $sql->bind_param("i",$user_ID);
//     if($sql->execute()){
//         $sql->store_result();
//         if($sql->num_rows == 1){
//             $sql->bind_result($userID, $useremail, $userpass, $userfn, $usermn, $userln,$usercn,$usercourse,$courseID,$isAdmin);
//                 if($sql->fetch()){
//                     $userObj["fullname"] = $userfn . " ". $usermn. " " . $userln;
//                     $userObj["course"]= $usercourse;
//                     $userObj["coursename"]=getCourse($usercourse);
//                     $userObj["contact"]=$usercn;
//                     $userObj["email"]=$useremail;
//                     $userObj["pass"]=$userpass;
//                     $myJSON = json_encode($userObj);
//                     echo $myJSON;
//             }
//         }
//     }
//     $sql->close();
// }
// $conn->close();
include "db_connection.php";
    $conn=OpenCon();
    $sql_code = "SELECT course_name from tbl_course WHERE course_ID =?";
    if($sql=$conn->prepare($sql_code)){
        $sql->bind_param ("i",$course_ID);
        $course_ID = $courseID;
        if($sql->execute()){
            $sql->store_result();
            if($sql->num_rows == 1){
                $sql->bind_result($coursename);
                    if($sql->fetch()){
                        echo $coursename;
                    }
            }
        } 
        $sql->close();
    }
    $conn->close();

?>