<?php
include 'db_connection.php';
$name = $_REQUEST['name'];
$qty = $_REQUEST['quantity'];
$desc = $_REQUEST['desc'];
$avail = $_REQUEST['avail'];

$conn=OpenCon();
    $sql_code = "INSERT INTO `tbl_equipment`(`equipment_name`, `equipment_quantity`, `equipment_description`, `equipment_availability`) VALUES (?,?,?,?)";
    if($sql=$conn->prepare($sql_code)){
        $sql->bind_param('sisi',$name,$qty,$desc,$avail);
        $sql->execute();
         $sql->close();
    }
$conn->close();


?>