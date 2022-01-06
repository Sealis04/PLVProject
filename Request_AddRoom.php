<?php
include 'db_connection.php';
$name = $_REQUEST['name'];
$qty = $_REQUEST['quantity'];
$desc = $_REQUEST['desc'];
$avail = $_REQUEST['avail'];
echo $_FILES['sample']['name'];
$conn=OpenCon();
//     $sql_code = "INSERT INTO `tbl_room`( `room_name`, `room_capacity`, `room_description`, `room_availability`) VALUES (?,?,?,?)";
//     if($sql=$conn->prepare($sql_code)){
//         $sql->bind_param('sisi',$name,$qty,$desc,$avail);
//         $sql->execute();
//          $sql->close();
//     }
// $conn->close();

if(isset($_FILES['sample'])){
    $valid_ext = array('jpg','png','jpeg');
    $fileName = $_FILES['sample']['name'];
    $fileTmpPath= $_FILES['sample']['tmp_name'];
    $path = 'assets/'.$fileName;
    $fileextension = pathinfo($path, PATHINFO_EXTENSION);
    $fileextension = strtolower($fileextension);
    if (in_array($fileextension, $valid_ext)) {
        if (move_uploaded_file($fileTmpPath, $path)) {
            $sql_code = "INSERT INTO `tbl_room`( `room_name`, `room_capacity`, `room_description`, `room_availability`, `imgPath`) VALUES (?,?,?,?,?)";
            if ($sql = $conn->prepare($sql_code)) {
                $sql->bind_param('sisis', $name, $qty, $desc, $avail,$path);
                $sql->execute();
                $sql->close();
            }
            $conn->close();
        }
    }
}else{
    $sql_code = "INSERT INTO `tbl_room`( `room_name`, `room_capacity`, `room_description`, `room_availability` , `imgPath`) VALUES (?,?,?,?,?)";
    if($sql=$conn->prepare($sql_code)){
        $sql->bind_param('sisis',$name,$qty,$desc,$avail,$path);
        $sql->execute();
         $sql->close();
    }
$conn->close();
}
?>