<?php
$reviewed = '1';
$rid = $_REQUEST["var"];
$remarks = $_REQUEST['remark'];
$mark = $_REQUEST['marked'];
$userID = $_REQUEST['userID'];
$qtyArr = $_REQUEST['damagedQty'];
$decodedArr = json_decode($qtyArr,true);
$reservation = array();
include "db_connection.php";
$conn=OpenCon();
$sql_code = "UPDATE tbl_reservation SET r_reviewed = ?,r_Remarks = ? WHERE r_ID = ?";
    if($sql=$conn->prepare($sql_code)){
        $sql->bind_param('isi',$reviewed,$remarks,$rid);
            if($sql->execute()){
                echo 'success';
                }
             $sql->close();
        }

$sql_code2 = "UPDATE tbl_user SET r_marked = ? WHERE r_ID =?";
if($sql2=$conn->prepare($sql_code2)){
    $sql2->bind_param('ii',$mark,$userID);
        if($sql2->execute()){
            echo 'success';
            }
         $sql2->close();
    }
    $sql_code3 = "SELECT DateEnd from tbl_reservation WHERE r_ID =?";
    if($sql3=$conn->prepare($sql_code3)){
        $sql3->bind_param('i',$rid);
            if($sql3->execute()){
              $sql3->store_result();
              $sql3->bind_result($DateEnd);
              while($sql3->fetch()){
                if(count($decodedArr) > 0){
                    for ($count = 0; $count < count($decodedArr); $count++) {
                        if($decodedArr[$count]['equipmentQty'] != 0){
                            $query1 = "INSERT INTO `tbl_damagedequipment`(`r_ID`,`equipmentID`, `qty`, `Date`) VALUES 
                            (?,?,?,?) ";
                            if($sql4=$conn->prepare($query1)){
                                $sql4->bind_param('iiis',$rid,$decodedArr[$count]['ID'],$decodedArr[$count]['equipmentQty'],$DateEnd);
                                if($sql4->execute()){
                                    echo 'success';
                                }
                            }
                        }
                    }
                }
              }
            }
             $sql3->close();
        }
    $conn->close();
