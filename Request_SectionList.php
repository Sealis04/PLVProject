<?php
//returns array of course \

$course = array();
include "db_connection.php";
$conn=OpenCon();
$sql_code = "SELECT * FROM tbl_section WHERE ? ORDER BY s_section";
    if($sql=$conn->prepare($sql_code)){
        $sql->bind_param("i",$identifier);
        $identifier = 1;
            if($sql->execute()){
                $result = $sql->get_result();
                    while($row = $result->fetch_assoc()){
                    $course[]= array(
                            'sectionID'=> $row["s_id"],
                            'sectionName'=> $row["s_section"]
                    );
                    }
                }
             $sql->close();
        }
    $conn->close();
    $myJSON = json_encode($course);
    echo $myJSON;
?>