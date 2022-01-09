<head>
    <title>PLVRS</title>
    <link rel="icon" href="assets/plv.png">
    <meta charset="UTF-8">
  <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="stylesheet" href="/bootstrap-3.4.1-dist/bootstrap-3.4.1-dist/css/bootstrap.min.css">
    <script src="/bootstrap-3.4.1-dist/bootstrap-3.4.1-dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/bootstrap-4.1.3-dist/css/bootstrap.min.css">
    <script src="/bootstrap-4.1.3-dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/index.css">
</head>

<body>
    <?php
    include "db_connection.php";
    session_start();
    ?>

    <sidenav>
        <?php
        if(isset($_SESSION['user_ID'])){
             if ($_SESSION['user_verified'] == 'not verified') {
                echo '<script>
                    alert("Please confirm the OTP that was sent to your Email!")
                    window.location.href = "/Window_OTP.php?code='.$_SESSION['user_code'].'&userID='.$_SESSION['user_ID'].'"
                    </script>';
            }
        }
        require "Backend_CheckifLoggedIN.php";
        ?>
         <nav>
            <div class="navbar">
            <div class="nav2">
                  
            </div>
            </div>
    </nav>
    </sidenav>
    <mainBody class='main'>
        <div style="text-align:center">
            <input value='<' onclick='prevMonth()' type='button' style="display:inline-block;   ">
            <h3 id="monthAndYear" style="display:inline-block; "></h3>
            <input value='>' onclick='nextMonth()' type='button' style="display:inline-block; ">
        </div>

        <table id="calendar" class="shadow-lg p-3 mb-5 bg-white rounded" style="table-layout:fixed; width:90%">
            <thead>
                <tr>
                    <th>Sun</th>
                    <th>Mon</th>
                    <th>Tue</th>
                    <th>Wed</th>
                    <th>Thurs</th>
                    <th>Fri</th>
                    <th>Sat</th>
                </tr>
            </thead>
            <tbody id="calendar-body">
            </tbody>
        </table>
        <!-- Code for jumping years and months, optional -->
        <!-- <div>
        <label for="month"></label>
        <select name="month" id="month" onchange='jump()'>
            <option value=0>Jan</option>
            <option value=1>Feb</option>
            <option value=2>Mar</option>
            <option value=3>Apr</option>
            <option value=4>May</option>
            <option value=5>Jun</option>
            <option value=6>Jul</option>
            <option value=7>Aug</option>
            <option value=8>Sept</option>
            <option value=9>Oct</option>
            <option value=10>Nov</option>
            <option value=11>Dec</option>
        </select>
        <label for="year"></label>
        <select name="year" id="year">
        </select>
    </div> -->
        </div>
        <div id='body'>

            <!-- <div id='hoursLabel' style='flex:1%;'>
    </div>
    <div id='hoursbody' style='flex:99%'>
    </div> -->
        </div>
        <input class="header-btn btn create-reservation" type="button" value="Create Reservation" onclick="location.href='/Window_ReservationForm.php'"></a>
        <!-- <div class="reservations">
            <h3> No Reservation</h3>
        </div> -->
        <div class="reservations shadow-lg p-3 mb-5 bg-white rounded" id='listBody'>
        </div>
    </mainBody>

</body>
<?php 
require "Backend_HomePage.php";
?>

</html>