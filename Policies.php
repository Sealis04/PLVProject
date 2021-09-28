<html>
    <head>
        <title>PLVRS</title>
        <link rel="icon" href="assets/plv.png">
        <meta charset="UTF-8">
        <link rel="stylesheet" href="bootstrap-3.4.1-dist/bootstrap-3.4.1-dist/css/bootstrap.min.css">
        <script src="bootstrap-3.4.1-dist/bootstrap-3.4.1-dist/js/bootstrap.min.js"></script>

        <link rel="stylesheet" href="css/Policies.css">
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
              <a href="HomePage.php" type="button" class="header-btn btn ">Home</a>
              <a href="RoomAndEquipment.php" type="button" class="header-btn btn ">Rooms and Equipment</a>
              <a href="Policies.php" type="button" class="header-btn btn">Policies</a>
            </div>
            <div class="nav2">
              <?php
            require "isLoggedInVerification.php";
                ?>        
            </div>
        </div>
        </nav>
        <div class="container">
            <legend>Policies</legend>
            <div class="image">
                <img src="assets/announcement.png"/>
            </div>
            <div class="text-policies">
                <h1>Header</h1>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt maxime quos molestias voluptatibus animi rerum facere ex dicta dolor tenetur. 
                Natus aspernatur quidem omnis numquam doloribus repudiandae in quis vel?Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt maxime quos molestias voluptatibus animi rerum facere ex dicta dolor tenetur. 
                Natus aspernatur quidem omnis numquam doloribus repudiandae in quis vel?Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt maxime quos molestias voluptatibus animi rerum facere ex dicta dolor tenetur. 
                Natus aspernatur quidem omnis numquam doloribus repudiandae in quis vel?Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt maxime quos molestias voluptatibus animi rerum facere ex dicta dolor tenetur. 
                Natus aspernatur quidem omnis numquam doloribus repudiandae in quis vel?Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt maxime quos molestias voluptatibus animi rerum facere ex dicta dolor tenetur. 
                Natus aspernatur quidem omnis numquam doloribus repudiandae in quis vel?Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt maxime quos molestias voluptatibus animi rerum facere ex dicta dolor tenetur. 
                Natus aspernatur quidem omnis numquam doloribus repudiandae in quis vel?Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt maxime quos molestias voluptatibus animi rerum facere ex dicta dolor tenetur. 
                Natus aspernatur quidem omnis numquam doloribus repudiandae in quis vel?
            </div>
        </div>
    </body>
</html>