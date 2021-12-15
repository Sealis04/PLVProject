
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

            <div class="nav2">
                <?php
                require "Backend_CheckifLoggedIN.php";
                ?>
            </div>
        </div>
    </nav>
    <div class="container">
        <legend>Policies</legend>
        
    </div>

    <div class="container">
        <div id = 'policies' class="policy">
        </div>
        <?php require 'Backend_PoliciesPage.php' ?>
</body>

</html>