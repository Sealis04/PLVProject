                    <?php 
                    include "db_connection.php";
                    $room_ID = $_REQUEST["var"];
                        $conn=OpenCon();
                        $sql_code = "SELECT room_ID, room_name, room_description, room_capacity, imgPath FROM tbl_room WHERE room_ID = ? AND isDeleted = 0 AND room_availability = 0";
                        if($sql=$conn->prepare($sql_code)){
                            $sql->bind_param("i",$room_ID);
                                if($sql->execute()){
                                    $sql->store_result();
                                    if($sql->num_rows==1){
                                        $sql->bind_result($room_ID_param, $room_name_param, $room_desc_param,$room_cap,$room_img);
                                        if($sql->fetch()){
                                            if ($room_ID_param == $room_ID) {
                                                $roomObj["roomName"] = $room_name_param;
                                                $roomObj["roomDesc"] = $room_desc_param;
                                                $roomObj["room_capacity"] = $room_cap;
                                                $roomObj["imgPath"] = $room_img;
                                                $myJSON = json_encode($roomObj);
                                                echo $myJSON;
                                            }
                                        }
                                    }
                                    }
                                    $sql->close();
                                }
                                $conn->close();
                                ?>