-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 19, 2021 at 03:48 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `plvrs3`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_approved`
--

CREATE TABLE `tbl_approved` (
  `approve_ID` int(10) NOT NULL,
  `approve_response` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_approved`
--

INSERT INTO `tbl_approved` (`approve_ID`, `approve_response`) VALUES
(1, 'Approved'),
(2, 'Pending'),
(3, 'Declined');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category_policy`
--

CREATE TABLE `tbl_category_policy` (
  `ct_ID` int(10) NOT NULL,
  `ct_category_name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_category_policy`
--

INSERT INTO `tbl_category_policy` (`ct_ID`, `ct_category_name`) VALUES
(1, 'Reservations'),
(2, 'Room and Equipment'),
(3, 'Violations'),
(4, 'Other');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_course`
--

CREATE TABLE `tbl_course` (
  `course_ID` int(10) NOT NULL,
  `course_name` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_course`
--

INSERT INTO `tbl_course` (`course_ID`, `course_name`) VALUES
(1, 'BSIT'),
(2, 'BSEE'),
(3, 'BSCE'),
(4, 'BSP');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_equipment`
--

CREATE TABLE `tbl_equipment` (
  `equipment_ID` int(10) NOT NULL,
  `equipment_name` varchar(25) DEFAULT NULL,
  `equipment_quantity` varchar(25) DEFAULT NULL,
  `equipment_description` varchar(25) DEFAULT NULL,
  `equipment_availability` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_equipment`
--

INSERT INTO `tbl_equipment` (`equipment_ID`, `equipment_name`, `equipment_quantity`, `equipment_description`, `equipment_availability`) VALUES
(1, 'Projectors', '14', 'Sound', 0),
(2, 'Mobile Speaker', '13', 'Sound', 0),
(3, 'Monoblock Chairs', '1500', 'Chair', 0),
(4, 'Projector Screen', '2', 'Screen', 0),
(5, 'Extension Cords', '10', 'Cord', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_equipment_reserved`
--

CREATE TABLE `tbl_equipment_reserved` (
  `r_ID` int(10) NOT NULL,
  `equipment_ID` int(10) DEFAULT NULL,
  `Qty` int(255) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_equipment_reserved`
--

INSERT INTO `tbl_equipment_reserved` (`r_ID`, `equipment_ID`, `Qty`) VALUES
(437, 1, 12),
(437, 2, 12),
(438, 1, 2),
(464, 1, 12),
(470, 5, 1),
(471, 1, 1),
(472, 1, 1),
(473, NULL, NULL),
(474, NULL, NULL),
(475, NULL, NULL),
(476, NULL, NULL),
(477, NULL, NULL),
(478, NULL, NULL),
(479, NULL, NULL),
(480, NULL, NULL),
(481, 1, 14),
(481, 2, 13),
(482, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_notification`
--

CREATE TABLE `tbl_notification` (
  `notificationID` int(11) NOT NULL,
  `forUserID` int(11) NOT NULL,
  `isRead` tinyint(1) NOT NULL DEFAULT 0,
  `time` datetime NOT NULL DEFAULT current_timestamp(),
  `decision` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_notification`
--

INSERT INTO `tbl_notification` (`notificationID`, `forUserID`, `isRead`, `time`, `decision`) VALUES
(22, 13, 0, '2021-10-18 20:16:38', 1),
(23, 13, 0, '2021-10-18 20:54:58', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_policies`
--

CREATE TABLE `tbl_policies` (
  `p_ID` int(10) NOT NULL,
  `p_description` varchar(300) DEFAULT NULL,
  `p_ct_ID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_policies`
--

INSERT INTO `tbl_policies` (`p_ID`, `p_description`, `p_ct_ID`) VALUES
(1, '•	First come, first serve basis whether the requestor is a professor or a student and whatever the events purpose.', 1),
(2, '•	To request, fill out the registration form indicate the necessary details, facility to be reserved, equipment (if any), and props (if any), date and time, attach the letter of approval then click submit. ', 1),
(3, '•	The reservation request will not proceed if there is no attached letter of approval.', 1),
(4, '•	A room can be reserved even if there is no equipment borrowed.', 1),
(5, '•	Equipment cannot be borrowed if there is no room reserved.', 1),
(6, '•	Once submitted, there will be 3 days allotted for the administrator to respond.', 1),
(7, '•	The status of your reservation will show if it is “Pending”, “Viewed”, or “Approved/Declined”.', 1),
(8, '•	Minimum of 3 days before the event to book for a reservation.', 1),
(9, '•	Requested reservation lesser than 3 days before the event will automatically denied.', 1),
(10, '•	PLV Students, PLV Professors, and PLV admin personnel can request a reservation.', 1),
(11, '•	The requestor cannot be able to request a reservation for a room that is not available on the PLVRS.', 1),
(12, '•	The user can send a follow up using “submit a ticket” in the system. The GSO will be notified via PLVRS and email notification.', 1),
(13, '•	The requestor will have a proper documentation of follow up ticket to be sent on their email to inform that the follow up was sent.', 1),
(14, '•	The requestor can reschedule the request for reservation whether it is approved or pending.', 1),
(15, '•	To request a reschedule, the only requirement is the same letter of approval with rescheduled date that is signed by the respected authorities.', 1),
(16, '•	Requestor can cancel minimum of 1 day before the reserved date whether the status of their request is pending or approved.', 1),
(17, '•	The rooms that can be reserved are: Lecture Room 301, 302, 303, 401, 402, and 403. Pre-school Simulation Room, Business Administration Simulation Room, and Auditorium.', 2),
(18, '•	Auditorium only allows 1 reservation per day.', 1),
(19, '•	Any requested reservation of a room that exceeds the maximum capacity of each room are automatically declined.', 2),
(20, '•	One projector is allowed to borrow per Lecture Room and Simulation Room.', 2),
(21, '•	It is advisable not to bring the same equipment that the GSO can provide to maximize the usage of it dedicated for the university.', 2),
(22, '•	Any equipment that will be borrowed shall be returned directly to the office by the borrower within the day after using it.', 2),
(23, '•	The number of rooms and equipment as well as its availability is recorded in the system for reliable monitoring.', 2),
(24, '•	There will be a monitoring sheet and inventory report generated every after reservation. Its content will depend on the reservation details and will automatically update the availability of room and equipment once the request for the reservation is submitted.', 2),
(25, '•	In case it coincides to a broken equipment or is needed within the next reservation, the system will automatically notify the requestor who will be affected.', 2),
(26, '•	The borrower who fails to return an equipment within the day after using it, will have a “red mark” on their profile indicating a Negative Trust.', 3),
(27, '•	Having a “red mark” on their profile can reflect on their clearance.', 3),
(28, '•	Verified users agree not to damage the room and equipment reserved.', 3),
(29, '•	If an equipment is lightly damaged, it will be replaced with the same specification. But, if an equipment is severely damaged, the Local Government Unit (LGU) will be responsible for it.', 3),
(30, '•	Affixing items to the walls, floor, ceilings of any room, taping, or nailing items to any surface is prohibited.', 3),
(31, '•	The requestor who damages an item will be contacted by the GSO and must personally go to their office.', 3),
(32, '•	Notifications will be via PLVRS and email notification.', 4),
(33, '•	The GSO can be contacted via email notification or telephone number.', 4),
(34, '•	Food and Beverages are strictly not allowed in the Auditorium and Simulation Rooms.', 4);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reservation`
--

CREATE TABLE `tbl_reservation` (
  `r_ID` int(10) NOT NULL,
  `r_event` date DEFAULT NULL,
  `r_startDateAndTime` datetime DEFAULT NULL,
  `r_endDateAndTime` datetime DEFAULT NULL,
  `r_status` tinyint(1) DEFAULT 0,
  `r_user_ID` int(10) DEFAULT NULL,
  `r_approved_ID` int(10) DEFAULT NULL,
  `r_room_ID` int(10) NOT NULL,
  `r_letter_file` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_reservation`
--

INSERT INTO `tbl_reservation` (`r_ID`, `r_event`, `r_startDateAndTime`, `r_endDateAndTime`, `r_status`, `r_user_ID`, `r_approved_ID`, `r_room_ID`, `r_letter_file`) VALUES
(481, NULL, '2021-10-21 08:00:00', '2021-10-22 09:00:00', 0, 13, 1, 2, 'C:/xampp/htdocs/practice/assets/039e462305c40d47ea99b2e9b4a330e5.jpg'),
(482, NULL, '2021-10-21 08:00:00', '2021-10-21 09:00:00', 0, 13, 1, 1, 'C:/xampp/htdocs/practice/assets/147340154_148337303789733_1933449064246305894_o.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_room`
--

CREATE TABLE `tbl_room` (
  `room_ID` int(10) NOT NULL,
  `room_name` varchar(25) DEFAULT NULL,
  `room_capacity` int(10) DEFAULT NULL,
  `room_description` varchar(25) DEFAULT NULL,
  `room_availability` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_room`
--

INSERT INTO `tbl_room` (`room_ID`, `room_name`, `room_capacity`, `room_description`, `room_availability`) VALUES
(1, 'LR 303', 50, '3rd Lecture Room in Floor', 0),
(2, 'LR 401', 50, '1st Lecture Room in Floor', 0),
(3, 'LR 402', 50, '2nd Lecture Room in Floor', 0),
(4, 'Auditorium', 500, 'Auditorium', 0),
(5, 'BA simulation', 50, 'BA simulation', 0),
(6, 'Pre school simulation', 120, 'Pre school simulation', 0),
(7, 'Speech Laboratory', NULL, 'Speech Laboratory', 0),
(8, 'Student Lounge', NULL, 'Student Lounge', 0),
(9, 'Holding Area', NULL, 'Holding Area', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `user_ID` int(10) NOT NULL,
  `user_email` varchar(25) DEFAULT NULL,
  `user_password` varchar(255) DEFAULT NULL,
  `user_firstName` varchar(25) DEFAULT NULL,
  `user_middleName` varchar(25) DEFAULT NULL,
  `user_lastName` varchar(25) DEFAULT NULL,
  `user_contactNumber` varchar(11) DEFAULT NULL,
  `user_course_ID` int(10) DEFAULT NULL,
  `PLV_ID` varchar(255) DEFAULT NULL,
  `isAdmin` tinyint(1) DEFAULT NULL,
  `isApproved` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`user_ID`, `user_email`, `user_password`, `user_firstName`, `user_middleName`, `user_lastName`, `user_contactNumber`, `user_course_ID`, `PLV_ID`, `isAdmin`, `isApproved`) VALUES
(13, 'admin1@gmail.com', '$2y$10$AWJtx8Od.kq/3XCnnPGO0.KYknstQL8COfywaUz7FswJ7N5B/5o1K', 'Bryan', 'Darilag', 'Garcia', '9399465176', 1, 'C:/xampp/htdocs/practice/assets/plvrs (4).sql', 1, 1),
(14, 'user1@gmail.com', '$2y$10$ZLiYnQmADleMdiI.UO5EWesok.d4WqwYdH3kqo4sPanAQu.LvHUpG', 'Bryan', 'Darilag', 'Garcia', '9399465176', 1, 'C:/xampp/htdocs/practice/assets/plvrs (4).sql', 0, 1),
(15, 'user2@gmail.com', '$2y$10$ej/E2MuY.7KzwB6LbAhlquQh4Sp6sUWs6dEONhlNjiEflrvRAhqFu', 'Juan', 'Pedro', 'Penduko', '9098898899', 1, 'C:/xampp/htdocs/practice/assets/plvrs (4).sql', 0, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_approved`
--
ALTER TABLE `tbl_approved`
  ADD PRIMARY KEY (`approve_ID`);

--
-- Indexes for table `tbl_category_policy`
--
ALTER TABLE `tbl_category_policy`
  ADD PRIMARY KEY (`ct_ID`);

--
-- Indexes for table `tbl_course`
--
ALTER TABLE `tbl_course`
  ADD PRIMARY KEY (`course_ID`);

--
-- Indexes for table `tbl_equipment`
--
ALTER TABLE `tbl_equipment`
  ADD PRIMARY KEY (`equipment_ID`);

--
-- Indexes for table `tbl_equipment_reserved`
--
ALTER TABLE `tbl_equipment_reserved`
  ADD KEY `tbl_equipment_reserved_ibfk_2` (`equipment_ID`),
  ADD KEY `tbl_equipment_reserved_ibfk_1` (`r_ID`);

--
-- Indexes for table `tbl_notification`
--
ALTER TABLE `tbl_notification`
  ADD PRIMARY KEY (`notificationID`);

--
-- Indexes for table `tbl_policies`
--
ALTER TABLE `tbl_policies`
  ADD PRIMARY KEY (`p_ID`),
  ADD KEY `p_ct_ID` (`p_ct_ID`);

--
-- Indexes for table `tbl_reservation`
--
ALTER TABLE `tbl_reservation`
  ADD PRIMARY KEY (`r_ID`),
  ADD KEY `r_user_ID` (`r_user_ID`),
  ADD KEY `r_approved_ID` (`r_approved_ID`),
  ADD KEY `r_room_ID` (`r_room_ID`);

--
-- Indexes for table `tbl_room`
--
ALTER TABLE `tbl_room`
  ADD PRIMARY KEY (`room_ID`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`user_ID`),
  ADD KEY `user_course_ID` (`user_course_ID`),
  ADD KEY `isApproved` (`isApproved`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_approved`
--
ALTER TABLE `tbl_approved`
  MODIFY `approve_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_category_policy`
--
ALTER TABLE `tbl_category_policy`
  MODIFY `ct_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_course`
--
ALTER TABLE `tbl_course`
  MODIFY `course_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_equipment`
--
ALTER TABLE `tbl_equipment`
  MODIFY `equipment_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_notification`
--
ALTER TABLE `tbl_notification`
  MODIFY `notificationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tbl_policies`
--
ALTER TABLE `tbl_policies`
  MODIFY `p_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `tbl_reservation`
--
ALTER TABLE `tbl_reservation`
  MODIFY `r_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=483;

--
-- AUTO_INCREMENT for table `tbl_room`
--
ALTER TABLE `tbl_room`
  MODIFY `room_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `user_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_policies`
--
ALTER TABLE `tbl_policies`
  ADD CONSTRAINT `tbl_policies_ibfk_1` FOREIGN KEY (`p_ct_ID`) REFERENCES `tbl_category_policy` (`ct_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
