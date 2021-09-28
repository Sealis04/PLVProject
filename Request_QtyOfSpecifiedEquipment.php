<?php 
                    include "db_connection.php";
                    $equip_ID = $_REQUEST["var"];
                   if($equip_ID==0){
                    
                   }else{
                    $conn=OpenCon();
                    $sql_code = "SELECT * FROM tbl_equipment WHERE equipment_ID = ?";
                    if($sql=$conn->prepare($sql_code)){
                        $sql->bind_param("i",$equip_ID);
                            if($sql->execute()){
                                $sql->store_result();
                                if($sql->num_rows==1){
                                    $sql->bind_result($equipID,$equipName,$equipQty,$equipDesc);
                                    if($sql->fetch()){
                                        if($equipID = $equip_ID){
                                            $equipObj["equipID"]=$equipID;
                                            $equipObj["equipName"]=$equipName;
                                            $equipObj["equipQty"]=$equipQty;
                                            $equipObj["equipDesc"]=$equipDesc;
                                            $myJSON = json_encode($equipObj);
                                            echo $myJSON;
                                        }else{
                                            echo "empty";
                                        }
                                    }
                                }
                                }
                                $sql->close();
                            }
                            $conn->close();
                   }
?>