<?php
//returns array of reservation 
    $registration = array();
    include "db_connection.php";
    $conn=OpenCon();
    $sql_code = "SELECT `user_ID`, `user_firstName`, `user_middleName`, `user_lastName`, `course_name` FROM tbl_user
    LEFT JOIN tbl_course
    on tbl_course.course_ID = tbl_user.isApproved WHERE isApproved = '2'";
        if($sql=$conn->prepare($sql_code)){
                if($sql->execute()){
                    $result = $sql->get_result();
                        while($row = $result->fetch_assoc()){
                        $registration[]= array(
                            'user' => $row["user_ID"],
                            'firstName' => $row["user_firstName"],
                            'middleName' => $row["user_middleName"],
                            'lastName'=>$row["user_lastName"],
                            'course'=>$row['course_name'],
                        );
                        }
                    }else{
                        echo $conn->error;
                    }
                 $sql->close();
            }
        $conn->close();
        $myJSON = json_encode($registration);
        echo $myJSON;
?>