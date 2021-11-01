<?php
//returns array of reservation
function checkDetails($userID){
    $conn = OpenCon();
    $sql_code = "SELECT isApproved,r_marked FROM tbl_user WHERE `user_ID` = ?";
    if ($sql = $conn->prepare($sql_code)) {
        $sql->bind_param('i',$userID);
        if ($sql->execute()) {
             $sql->store_result();
             if($sql->num_rows == 1){
                $sql->bind_result($isApproved,$isMarked);
                if($sql->fetch()){
                    if($isApproved == 3){
                        return 'Account was declined, please register again';
                    }else if($isApproved == 2){
                        return 'Account still pending';
                    }else if($isMarked = 1){
                        return 'Account was marked, please contact the GSO department for more details';
                    }
                }
             }
            
        } else {
            echo $conn->error;
        }
        $sql->close();
    }
    $conn->close();
} 
