<html>
    <head>
        <title>PLVRS</title>
        <link rel="icon" href="assets/plv.png">
        <meta charset="UTF-8">
        <link rel="stylesheet" href="bootstrap-3.4.1-dist/bootstrap-3.4.1-dist/css/bootstrap.min.css">
        <script src="bootstrap-3.4.1-dist/bootstrap-3.4.1-dist/js/bootstrap.min.js"></script>

        <link rel="stylesheet" href="css/RoomAndEquipment.css">
    </head>
    <body>
            <?php 
            include "db_connection.php";
            session_start();
            
                ?>
        <nav id="head-container">
            <div class="navbar">
            <div class="nav1">
              <img id="fb" src="assets/plv.png" alt="PLV Logo">
              <a href="Window_HomePage.php" type="button" class="header-btn btn ">Home</a>
              <a href="Window_RoomAndEquipment.php" type="button" class="header-btn btn ">Rooms and Equipment</a>
              <a href="Window_PoliciesPage.php" type="button" class="header-btn btn">Policies</a>
            </div>
            <div class="nav2">
              <?php
           require "Backend_CheckifLoggedIN.php";
                ?>        
            </div>
            </div>
        </nav>

        <!--body-->
        <div class="container">
            <div class="row">
                <div class="image">
                    <img src="assets/announcement.png"/>
                </div>
                <legend>Room And Equipment</legend>
                <div class="bodyContainer">
                    <div class="side-nav" id="list">
                        <ul method="post">
                        <?php
                    //creates entire list of rooms. 
                        $conn=OpenCon();
                        $sql_code = "SELECT * FROM tbl_room WHERE ?";
                        if($sql=$conn->prepare($sql_code)){
                            $sql->bind_param("i",$room_ID);
                            $room_ID = 1;
                                if($sql->execute()){
                                    $result = $sql->get_result();
                                    while($row = $result->fetch_assoc()){
                                        //echo "<li>".'<a id ="'.$row["room_ID"].'"class="btns">'.$row["room_name"]."</a>"."</li>";
                                        echo '<li>'.'<input id ="'.$row["room_ID"].'"class="btns" type="button" value= "'.$row['room_name'].'"'.'<li>';
                                }
                        }
                        $sql->close();
                    }
                    $conn->close();
                        ?>
                    <li><a class= "btns" id="equipment">Equipment list</a></li>
                    <li><a class= "btn active" style="display:none" visibility="hidden">asd</a></li>
                          </ul>
                    </div>
                        <div class="big-contents" >
                            <ul id="contentDiv"> 
                            <h1 id="h1"></h1>
                            <h2 id="h2"><h2>
                            <p id="p1"></p>
                            </ul>   
                            </div>  
                    </div>
            </div>       
        </div>
        <?php require "Backend_RoomAndEquipment.php";?>
   </body>
</html>