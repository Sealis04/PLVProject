<?php
//returns array of course \

$course = array();
include "db_connection.php";
$conn=OpenCon();
$sql_code = "SELECT * FROM tbl_course WHERE ?";
    if($sql=$conn->prepare($sql_code)){
        $sql->bind_param("i",$identifier);
        $identifier = 1;
            if($sql->execute()){
                $result = $sql->get_result();
                    while($row = $result->fetch_assoc()){
                    $course[]= array(
                            'courseID'=> $row["course_ID"],
                            'courseName'=> $row["course_name"]
                    );
                    }
                }
             $sql->close();
        }
    $conn->close();
    $myJSON = json_encode($course);
    echo $myJSON;
?>