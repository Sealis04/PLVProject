<?php
    function getEmail($userID,$rid,$remarks,$approval){
    $conn=OpenCon();
       $sql_code = "SELECT * FROM `tbl_user` WHERE `user_ID` = ?";
       if($sql=$conn -> prepare($sql_code)){
           $sql->bind_param("i",$userID);
           if($sql->execute()){
                $result = $sql->get_result();
                while($row = $result->fetch_assoc()){
                    $email  = $row['user_email'];
                    $fn = $row['user_firstName'];
               
                }
           }
           $sql->close();
       }
       sendEmail($email,$rid,$fn,$remarks,$approval);
    }

    
    function sendEmail($email,$rid,$fn,$remarks,$approval){
        $subject = 'PLVRS Reservation Notification';
        if($rid != null){
            $conn=OpenCon();
            //qquerying reservation details
            $sql_code = "SELECT tbl_reservation.r_event, tbl_reservation.DateStart,tbl_reservation.DateEnd,tbl_reservation.TimeStart, tbl_reservation.TimeEnd, tbl_room.room_name from 
                tbl_reservation INNER JOIN
                tbl_room
                ON tbl_reservation.r_room_ID = tbl_room.room_ID 
                WHERE r_ID = ?";
            if($sql=$conn->prepare($sql_code)){
                $sql->bind_param("i",$r_user);
                $r_user = $rid;
                    if($sql->execute()){
                        $sql->store_result();
                        if($sql->num_rows==1){
                            $sql->bind_result($event,$start,$end,$startTime,$endTime,$room);
                            if($sql->fetch()){
                                 $startTime = strtotime($startTime);
                $endTime = strtotime($endTime);
                $formattedStartTime = date('h:i:s A',$startTime);
                $formattedEndTime = date('h:i:s A',$endTime);
                if($approval == 1){
                    $message = 'Hello, '.$fn. "<br>";
                    $message .= 'This is to inform you that your reservation for ' .$event. ',which will be held at '.$room.' has been accepted, Congratulations!'."<br>";
                    $message .= 'The event starts at '.$start.' and ends at '.$end. ' with the time being from '.$formattedStartTime.' to '.$formattedEndTime."<br>";
                    if($remarks != ' '){
                        $message .='Remarks from admin:' .$remarks;
                    }
                }else if($approval == 3){
                    $message = 'Hello, '.$fn."<br>";
                    $message .= 'This is to inform you that your reservation for '.$event.', which will be held at '.$room.' has been rejected.'."<br>";
                    if($remarks !=''){
                        $message .='Remarks from admin:' .$remarks;
                    }else{
                        $message .='No remarks from admin, please contact/visit the GSO office to know the reason.';
                    }
                }else if($approval == 4){
                    $message = 'Hello, '.$fn."<br>";
                    $message .= 'This is to inform you that your reservation for '.$event.', which will be held at '.$room.' has been cancelled by an adminstrator. Please read the details as remarked by the admin below.'."<br>";
                    if($remarks !=''){
                        $message .='Remarks from admin:' .$remarks;
                    } 
                }
            

        }else{
            if($approval == 3){
                $message = 'Hello, '.$fn."<br>";
                $message .= 'This is to inform you that your registration has been rejected <br>';
                if($remarks != ' '){
                    $message .='Remarks from admin:' .$remarks;
                }else{
                    $message .='No remarks from admin, please contact/visit the GSO office to know the reason.';
                }
            }else if($approval == 1){
                $message = 'Hello, '.$fn."<br>";
                $message .= 'This is to inform you that your registration has been accepted, Congratulations!'."<br>";
                $message .= 'You can now start creating reservations for the facilities under the GSO!'."<br>";
            if($remarks != ' '){
                $message .='Remarks from admin:' .$remarks;
            }
            }         
        }
                            }
                        }
                        }else{
                            echo $conn->error;
                        }
                     $sql->close();
                }
               
     
        $fromEmail = $_SESSION["email"];
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: '.$fromEmail.'<'.$fromEmail.'>' . "\r\n".'Reply-To: '.$fromEmail."\r\n" . 'X-Mailer: PHP/' . phpversion();
        $message = '<!doctype html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport"
                          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
                    <meta http-equiv="X-UA-Compatible" content="ie=edge">
                    <title>Document</title>
                </head>
                <body>
                <span class="preheader" style="color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;">'.$message.'</span>
                    <div class="container">
                     '.$message.'<br><br>
                        Regards<br>
                      '.$fromEmail.'
                    </div>
                </body>
                </html>';
        $result = @mail($email, $subject, $message, $headers);
    }
