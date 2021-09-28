<html>
    <head>
        <title>PLVRS</title>
        <link rel="icon" href="assets/plv.png">
        <meta charset="UTF-8">
       
        <link rel="stylesheet" href="bootstrap-3.4.1-dist/bootstrap-3.4.1-dist/css/bootstrap.min.css">
        <script src="bootstrap-3.4.1-dist/bootstrap-3.4.1-dist/js/bootstrap.min.js"></script>

        <link rel="stylesheet" href="css/index.css">
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
            <div id="carousel">
                <img class="image" src="assets/announcement.png" style="width:100%">
            </div>
            <div id="calendar">
                <div class ="month">
                    <ul>
                        <li class="prev">&#10094;</li>
                        <li class="next">&#10095;</li>
                        <li>August
                            <br>
                            <span>2021</span>
                        </li>
                    </ul>
                </div>
                <ul class="weekdays">
                    <li>Monday</li>
                    <li>Tuesday</li>
                    <li>Wednesday</li>
                    <li>Thursday</li>
                    <li>Friday</li>
                    <li>Saturday</li>
                    <li>Sunday</li>
                </ul>
                <ul class="days">
                    <li>1</li>
                    <li>2</li>
                    <li>3</li>
                    <li>4</li>
                    <li>5</li>
                    <li>6</li>
                    <li>7</li>
                    <li>8</li>
                    <li>9</li>
                    <li>10</li>
                    <li>11</li>
                    <li>12</li>
                    <li>13</li>
                    <li>14</li>
                    <li>15</li>
                    <li>16</li>
                    <li>17</li>
                    <li>18</li>
                    <li>19</li>
                    <li>20</li>
                    <li>21</li>
                    <li>22</li>
                    <li>23</li>
                    <li>24</li>
                    <li>25</li>
                    <li>26</li>
                    <li>27</li>
                    <li>28</li>
                    <li>29</li>
                    <li>30</li>
                    <li>31</li>
                </ul>
                <div class="resBtn">
                <a href ="<?php echo(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"])?"form.php":"login.php" ?>">
                <input class = "header-btn btn" type="button" value="Create Reservation"></a>
                </div>
            </div>
            </div>
    </body>
</html>