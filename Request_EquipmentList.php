<?php
//returns array of equipment \
$equip = array();
include "db_connection.php";
$conn=OpenCon();
$sql_code = "SELECT * FROM tbl_equipment WHERE isDeleted = 0 AND equipment_Availability = 0";
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
    $conn->close();
    $myJSON = json_encode($equip);
    echo $myJSON;
?>