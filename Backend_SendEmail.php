<?php
    function getEmail($userID,$rid){
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
       sendEmail($email,$rid,$fn);
    }
    function sendEmail($email,$rid,$fn){
        $subject = 'PLVRS Reservation Notification';
        if($rid != null){
            $conn=OpenCon();
            //qquerying reservation details
            $sql_code = "SELECT * FROM tbl_reservation WHERE r_ID = ?";
            if($sql=$conn->prepare($sql_code)){
                $sql->bind_param("i",$r_user);
                $r_user = $rid;
                    if($sql->execute()){
                        $result = $sql->get_result();
                            while($row = $result->fetch_assoc()){
                                $event = $row['r_event'];
                                $start = $row['r_startDateAndTime'];
                                $end = $row['r_endDateAndTime'];
                                $room = $row['r_room_ID'];
                            }
                        }else{
                            echo $conn->error;
                        }
                     $sql->close();
                }
                $message = 'Hello'.$fn.'\r\n';
                $message .= 'This is to inform you that your reservation for' . $event . ',which will be held at'.$room.'has been accepted, congratulations! \r\n';
                $message .= 'The event starts at '.$start.'and ends at'.$end;
        }else{
            $message = 'Hello'.$fn.'\r\n';
            $message .= 'This is to inform you that your registration has been accepted, Congratulations! \r\n';
            $message .= 'You can now start creating reservations for the facilities under the GSO!';
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
                     '.$message.'<br/>
                        Regards<br/>
                      '.$fromEmail.'
                    </div>
                </body>
                </html>';
        $result = @mail($email, $subject, $message, $headers);
    }