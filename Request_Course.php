<?php
$courseID = $_REQUEST["var"];
$sectionID = $_REQUEST['section'];
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
                        $details['coursename'] = $coursename;
                    }
            }
        } 
        $sql->close();
    }

    $sql_code2 = "SELECT s_section from tbl_section WHERE s_ID =?";
    if($sql2=$conn->prepare($sql_code2)){
        $sql2->bind_param ("i",$sectionID);
        if($sql2->execute()){
            $sql2->store_result();
            if($sql2->num_rows == 1){
                $sql2->bind_result($sectionName);
                    if($sql2->fetch()){
                        $details['sectionname'] = $sectionName; 
                    }
            }
        }
        $sql2->close();
    }
    
    $myJSON = json_encode($details);
    echo $myJSON;

    $conn->close();

?>