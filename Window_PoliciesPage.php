
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
    <div class="container">
        <legend>Policies</legend>
        <div class="image">
            <img src="assets/announcement.png" />
        </div>
    </div>

    <div class="container">
        <div class="policy">
            <img src="assets/Reservation.jpg" alt="booking" />
            • First come, first serve basis whether the requestor is a professor or a student and whatever the events purpose. <br>
            • To request, fill out the registration form indicate the necessary details, facility to be reserved, equipment (if any), and props (if any), date and time, attach the letter of approval then click submit.<br>
            • The reservation request will not proceed if there is no attached letter of approval.<br>
            • A room can be reserved even if there is no equipment borrowed.<br>
            • Equipment cannot be borrowed if there is no room reserved.<br>
            • Once submitted, there will be 3 days allotted for the administrator to respond.<br>
            • The status of your reservation will show if it is “Pending”, “Viewed”, or “Approved/Declined”.<br>
            • Minimum of 3 days before the event to book for a reservation.<br>
            • Requested reservation lesser than 3 days before the event will automatically denied.<br>
            • PLV Students, PLV Professors, and PLV admin personnel can request a reservation.<br>
            • The requestor cannot be able to request a reservation for a room that is not available on the PLVRS.<br>
            • The user can send a follow up using “submit a ticket” in the system. The GSO will be notified via PLVRS and email notification.<br>
            • The requestor will have a proper documentation of follow up ticket to be sent on their email to inform that the follow up was sent.<br>
            • The requestor can reschedule the request for reservation whether it is approved or pending.<br>
            • To request a reschedule, the only requirement is the same letter of approval with rescheduled date that is signed by the respected authorities.<br>
            • Requestor can cancel minimum of 1 day before the reserved date whether the status of their request is pending or approved.<br>
        </div>
        <div class="policy">
            <img src="assets/RoomAndEquipment.jpg" alt="booking" />
            • The rooms that can be reserved are: Lecture Room 301, 302, 303, 401, 402, and 403. Pre-school Simulation Room, Business Administration Simulation Room, and Auditorium.<br>
            • Auditorium only allows 1 reservation per day.<br>
            • Any requested reservation of a room that exceeds the maximum capacity of each room are automatically declined.<br>
            • One projector is allowed to borrow per Lecture Room and Simulation Room.<br>
            • It is advisable not to bring the same equipment that the GSO can provide to maximize the usage of it dedicated for the university.<br>
            • Any equipment that will be borrowed shall be returned directly to the office by the borrower within the day after using it.<br>
            • The number of rooms and equipment as well as its availability is recorded in the system for reliable monitoring.<br>
            • There will be a monitoring sheet and inventory report generated every after reservation. Its content will depend on the reservation details and will automatically update the availability of room and equipment once the request for the reservation is submitted.<br>
            • In case it coincides to a broken equipment or is needed within the next reservation, the system will automatically notify the requestor who will be affected.<br>
        </div>
        <div class="policy">
            <img src="assets/Violation.jpg" alt="booking" />
            • The borrower who fails to return an equipment within the day after using it, will have a “red mark” on their profile indicating a Negative Trust.<br>
            • Having a “red mark” on their profile can reflect on their clearance.<br>
            • Verified users agree not to damage the room and equipment reserved.<br>
            • If an equipment is lightly damaged, it will be replaced with the same specification. But, if an equipment is severely damaged, the Local Government Unit (LGU) will be responsible for it.<br>
            • Affixing items to the walls, floor, ceilings of any room, taping, or nailing items to any surface is prohibited.<br>
            • The requestor who damages an item will be contacted by the GSO and must personally go to their office.<br>
        </div>
        <div class="policy">
            <img src="assets/Others.jpg" alt="booking" />
            • Notifications will be via PLVRS and email notification.<br>
            • The GSO can be contacted via email notification or telephone number.<br>
            • Food and Beverages are strictly not allowed in the Auditorium and Simulation Rooms.<br>
        </div>
</body>

</html>