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
            
            <div class="nav2">
              <?php
           require "Backend_CheckifLoggedIN.php";
                ?>        
            </div>
            </div>
        </nav>

        <!--body-->
        <div class="container">
            <div id = "carousel">
            <img class="image" src="assets/announcement.png"/>
            </div>
            <div class="row"> 
                    
                <legend>Room And Equipment</legend>
                <div class="bodyContainer">
                    <div class="side-nav" id="list">
                        <ul method="post">
                        <?php
                    //creates entire list of rooms. 
                        $conn=OpenCon();
                        $sql_code = "SELECT * FROM tbl_room WHERE isDeleted = 0 and room_availability = 0";
                        if($sql=$conn->prepare($sql_code)){
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