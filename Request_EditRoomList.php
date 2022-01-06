<?php
$rName = $_REQUEST['name'];
$rQuantity = $_REQUEST['cap'];
$rAvailability = $_REQUEST['availability'];
$rDesc = $_REQUEST['desc'];
$rID = $_REQUEST['id'];
// echo $_FILES['sample']['name'];
include "db_connection.php";
$conn=OpenCon();
if(isset($_FILES['sample'])){
    $valid_ext = array('jpg','png','jpeg');
    $fileName = $_FILES['sample']['name'];
    $fileTmpPath= $_FILES['sample']['tmp_name'];
    $path = 'assets/'.$fileName;
    $fileextension = pathinfo($path, PATHINFO_EXTENSION);
    $fileextension = strtolower($fileextension);
    if (in_array($fileextension, $valid_ext)) {
        if (move_uploaded_file($fileTmpPath, $path)) {
            $sql_code = "UPDATE `tbl_room` SET `room_name` = ?, `room_capacity` = ?, `room_description` = ?, `room_availability` = ?, `imgPath` = ? WHERE room_ID = ?";
            if ($sql = $conn->prepare($sql_code)) {
                $sql->bind_param("sisisi", $rName, $rQuantity, $rDesc, $rAvailability, $path, $rID);
                if ($sql->execute()) {
                    echo "Edit Success";
                }
                $sql->close();
            }
            $conn->close();
        }
    }
}else{
$sql_code = "UPDATE `tbl_room` SET `room_name` = ?, `room_capacity` = ?, `room_description` = ?, `room_availability` = ? WHERE room_ID = ?";
if($sql=$conn->prepare($sql_code)){
    $sql->bind_param("sisii",$rName,$rQuantity,$rDesc,$rAvailability,$rID);
        if($sql->execute()){
            echo "Edit Success";
            }
         $sql->close();
    }
$conn->close();
}
