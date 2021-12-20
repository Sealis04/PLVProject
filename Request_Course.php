<?php
$courseID = $_REQUEST["var"];
$sectionID = $_REQUEST['section'];
$userID = $_REQUEST['userID'];
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

    $sql_code3 = "SELECT isApproved from tbl_user WHERE `user_ID` =?";
    if($sql3=$conn->prepare($sql_code3)){
        $sql3->bind_param ("i",$userID);
        if($sql3->execute()){
            $sql3->store_result();
            if($sql3->num_rows == 1){
                $sql3->bind_result($isApproved);
                    if($sql3->fetch()){
                        $details['isApproved'] = $isApproved; 
                    }
            }
        }
        $sql3->close();
    }
    
    $sql_code4 = "SELECT remarks FROM tbl_notification WHERE forUserID = ? AND forRegistration = 1";
    if($sql4=$conn->prepare($sql_code4)){
        $sql4->bind_param ("i",$userID);
        if($sql4->execute()){
            $sql4->store_result();
            if($sql4->num_rows == 1){
                $sql4->bind_result($remarks);
                    if($sql4->fetch()){
                        $details['remarks'] = $remarks; 
                    }
            }
        }
        $sql4->close();
    }


    $sql_code5 = "SELECT r_marked FROM tbl_user WHERE tbl_user.user_ID = ?";
    if($sql5=$conn->prepare($sql_code5)){
        $sql5->bind_param ("i",$userID);
        if($sql5->execute()){
            $sql5->store_result();
            if($sql5->num_rows == 1){
                $sql5->bind_result($mark);
                    if($sql5->fetch()){
                        $details['isMarked'] = $mark; 
                    }
            }
        }
        $sql5->close();
    }
    
    $myJSON = json_encode($details);
    echo $myJSON;

    $conn->close();

?>