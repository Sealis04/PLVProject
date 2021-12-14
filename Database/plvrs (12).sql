-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 14, 2021 at 05:08 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `plvrs`
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
(1, 'Policy'),
(2, 'Reservation'),
(3, 'Declined Reservation'),
(4, 'Inventory'),
(5, 'Important'),
(6, 'Restrictions');

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
  `equipment_availability` tinyint(4) NOT NULL,
  `isDeleted` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_equipment`
--

INSERT INTO `tbl_equipment` (`equipment_ID`, `equipment_name`, `equipment_quantity`, `equipment_description`, `equipment_availability`, `isDeleted`) VALUES
(1, 'Projectors', '14', 'Sound', 1, 0),
(2, 'Mobile Speaker', '13', 'Sound', 1, 0),
(3, 'Monoblock Chairs', '1500', 'Chair', 1, 0),
(4, 'Projector Screen', '2', 'Screen', 1, 0),
(5, 'Extension Cords', '10', 'Cord', 1, 0);

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

-- --------------------------------------------------------

--
-- Table structure for table `tbl_jointable`
--

CREATE TABLE `tbl_jointable` (
  `r_ID` int(11) NOT NULL,
  `letter_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_jointable`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_letterforregistration`
--

CREATE TABLE `tbl_letterforregistration` (
  `u_ID` int(11) NOT NULL,
  `letterPath` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_letterlist`
--

CREATE TABLE `tbl_letterlist` (
  `letter_ID` int(11) NOT NULL,
  `letter_Path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_letterlist`
--

INSERT INTO `tbl_letterlist` (`letter_ID`, `letter_Path`) VALUES
(45, 'assets/unknown.png'),
(46, 'assets/unknown.png'),
(47, 'assets/unknown1.png'),
(48, 'assets/AquaComfy.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_notification`
--

CREATE TABLE `tbl_notification` (
  `notificationID` int(11) NOT NULL,
  `isRead` tinyint(1) NOT NULL DEFAULT 0,
  `time` datetime NOT NULL DEFAULT current_timestamp(),
  `decision` tinyint(1) NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `forUserID` int(11) NOT NULL,
  `forRegistration` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_notification`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_policies`
--

CREATE TABLE `tbl_policies` (
  `p_ID` int(10) NOT NULL,
  `p_description` varchar(300) DEFAULT NULL,
  `p_ct_ID` int(10) NOT NULL,
  `isDeleted` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_policies`
--

INSERT INTO `tbl_policies` (`p_ID`, `p_description`, `p_ct_ID`, `isDeleted`) VALUES
(1, 'Making a reservation is a first come, first serve basis whether the requestor is a PLV student, Professor, or Admin Personnel. A reservation will be requested using PLVRS only and it should be requested 3 days before the event.', 1, 0),
(2, 'To request a reservation, fill out all the required information in reservation form. It will not proceed if there is no attached letter of appoval. When rescheduling, the only requirement is the same letter of approval with rescheduled date that is signed by the respected authorities. A requestor ca', 2, 0),
(3, 'Requested reservation that are made 2 days before the event, exceeds the maximum capacity of a room, unavailable rooms in PLVRS, and coinciding schedule with other reservations will be declined by the GSO.', 3, 0),
(4, 'The rooms that can be reserved are: Lecture Room 301, 302, 303, 401, 402, and 403. Pre-school Simulation Room, Business Administration Simulation Room, and Auditorium. The equipment that can be borrowed are: projectors, 2 projector screens, 2 mobile speakers with microphones each, and 1500 monobloc ', 4, 0),
(5, 'The equipment borrowed must returned directly to the office within the day after using it. If there are damages on a borrowed room or equipment, the requestor will be contacted by the GSO and must personally go to their office.', 5, 0),
(6, 'Requestor cannot borrow an equipment if there is no room reserved. Auditorium only allow 1 reservation per day. One projector is allowed to borrow per Lecture and Simulation Room. ', 6, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reservation`
--

CREATE TABLE `tbl_reservation` (
  `r_ID` int(10) NOT NULL,
  `r_event` text DEFAULT NULL,
  `r_eventAdviser` varchar(255) NOT NULL,
  `r_status` tinyint(1) DEFAULT 0,
  `r_user_ID` int(10) DEFAULT NULL,
  `r_approved_ID` int(10) DEFAULT NULL,
  `r_room_ID` int(10) NOT NULL,
  `r_reviewed` tinyint(4) NOT NULL DEFAULT 0,
  `r_Remarks` longtext NOT NULL,
  `isDeleted` tinyint(4) DEFAULT 0,
  `DateStart` date DEFAULT NULL,
  `DateEnd` date DEFAULT NULL,
  `TimeStart` time DEFAULT NULL,
  `TimeEnd` time NOT NULL,
  `notifID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_reservation`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_room`
--

CREATE TABLE `tbl_room` (
  `room_ID` int(10) NOT NULL,
  `room_name` varchar(25) DEFAULT NULL,
  `room_capacity` int(10) DEFAULT NULL,
  `room_description` varchar(25) DEFAULT NULL,
  `room_availability` tinyint(4) NOT NULL,
  `isDeleted` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_room`
--

INSERT INTO `tbl_room` (`room_ID`, `room_name`, `room_capacity`, `room_description`, `room_availability`, `isDeleted`) VALUES
(1, 'LR 303', 50, '3rd Lecture Room in Floor', 0, 0),
(2, 'LR 401', 50, '1st Lecture Room in Floor', 1, 0),
(3, 'LR 402', 50, '2nd Lecture Room in Floor', 1, 0),
(4, 'Auditorium', 500, 'Auditorium', 0, 0),
(5, 'BA simulation', 50, 'BA simulation', 0, 0),
(6, 'Pre school simulation', 120, 'Pre school simulation', 0, 0),
(7, 'Speech Laboratory', 0, 'Speech Laboratory', 0, 0),
(8, 'Student Lounge', 0, 'Student Lounge', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_section`
--

CREATE TABLE `tbl_section` (
  `s_id` int(11) NOT NULL,
  `s_section` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_section`
--

INSERT INTO `tbl_section` (`s_id`, `s_section`) VALUES
(4, '3-4'),
(11, '3-1'),
(12, '3-2'),
(13, '3-3'),
(15, '3-5'),
(16, '4-1'),
(17, '4-2'),
(18, '4-3'),
(19, '4-4'),
(20, '4-5'),
(21, '5-1'),
(22, '5-2'),
(23, '5-3'),
(24, '5-4'),
(25, '5-5');

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
  `isApproved` int(10) DEFAULT NULL,
  `r_marked` tinyint(4) NOT NULL DEFAULT 0,
  `user_s_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`user_ID`, `user_email`, `user_password`, `user_firstName`, `user_middleName`, `user_lastName`, `user_contactNumber`, `user_course_ID`, `PLV_ID`, `isAdmin`, `isApproved`, `r_marked`, `user_s_ID`) VALUES
(13, 'admin1@gmail.com', '$2y$10$AWJtx8Od.kq/3XCnnPGO0.KYknstQL8COfywaUz7FswJ7N5B/5o1K', 'Admin', 'Darilag', 'Garcia', '9399465176', 1, '1626979229572.png', 1, 1, 0, 4),
(14, 'user1@gmail.com', '$2y$10$ZLiYnQmADleMdiI.UO5EWesok.d4WqwYdH3kqo4sPanAQu.LvHUpG', 'Bryan', 'Darilag', 'Garcia', '9399465176', 1, 'C:/xampp/htdocs/practice/assets/plvrs (4).sql', 0, 1, 0, 11),
(15, 'user2@gmail.com', '$2y$10$ej/E2MuY.7KzwB6LbAhlquQh4Sp6sUWs6dEONhlNjiEflrvRAhqFu', 'Juan', 'Pedro', 'Penduko', '9098898899', 1, 'C:/xampp/htdocs/practice/assets/plvrs (4).sql', 0, 3, 0, 11);

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
-- Indexes for table `tbl_jointable`
--
ALTER TABLE `tbl_jointable`
  ADD KEY `letter_ID` (`letter_ID`),
  ADD KEY `r_ID` (`r_ID`);

--
-- Indexes for table `tbl_letterlist`
--
ALTER TABLE `tbl_letterlist`
  ADD PRIMARY KEY (`letter_ID`);

--
-- Indexes for table `tbl_notification`
--
ALTER TABLE `tbl_notification`
  ADD PRIMARY KEY (`notificationID`),
  ADD KEY `forUserID` (`forUserID`);

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
  ADD KEY `r_room_ID` (`r_room_ID`),
  ADD KEY `notifID` (`notifID`);

--
-- Indexes for table `tbl_room`
--
ALTER TABLE `tbl_room`
  ADD PRIMARY KEY (`room_ID`);

--
-- Indexes for table `tbl_section`
--
ALTER TABLE `tbl_section`
  ADD PRIMARY KEY (`s_id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`user_ID`),
  ADD KEY `user_course_ID` (`user_course_ID`),
  ADD KEY `isApproved` (`isApproved`),
  ADD KEY `user_s_ID` (`user_s_ID`);

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
  MODIFY `ct_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_course`
--
ALTER TABLE `tbl_course`
  MODIFY `course_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_equipment`
--
ALTER TABLE `tbl_equipment`
  MODIFY `equipment_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tbl_letterlist`
--
ALTER TABLE `tbl_letterlist`
  MODIFY `letter_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `tbl_notification`
--
ALTER TABLE `tbl_notification`
  MODIFY `notificationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;

--
-- AUTO_INCREMENT for table `tbl_policies`
--
ALTER TABLE `tbl_policies`
  MODIFY `p_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `tbl_reservation`
--
ALTER TABLE `tbl_reservation`
  MODIFY `r_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `tbl_room`
--
ALTER TABLE `tbl_room`
  MODIFY `room_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbl_section`
--
ALTER TABLE `tbl_section`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `user_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_equipment_reserved`
--
ALTER TABLE `tbl_equipment_reserved`
  ADD CONSTRAINT `tbl_equipment_reserved_ibfk2` FOREIGN KEY (`r_ID`) REFERENCES `tbl_reservation` (`r_ID`),
  ADD CONSTRAINT `tbl_equipment_reserved_ibfk_1` FOREIGN KEY (`equipment_ID`) REFERENCES `tbl_equipment` (`equipment_ID`);

--
-- Constraints for table `tbl_jointable`
--
ALTER TABLE `tbl_jointable`
  ADD CONSTRAINT `tbl_jointable_ibfk_1` FOREIGN KEY (`letter_ID`) REFERENCES `tbl_letterlist` (`letter_ID`),
  ADD CONSTRAINT `tbl_jointable_ibfk_2` FOREIGN KEY (`r_ID`) REFERENCES `tbl_reservation` (`r_ID`);

--
-- Constraints for table `tbl_policies`
--
ALTER TABLE `tbl_policies`
  ADD CONSTRAINT `tbl_policies_ibfk_1` FOREIGN KEY (`p_ct_ID`) REFERENCES `tbl_category_policy` (`ct_ID`);

--
-- Constraints for table `tbl_reservation`
--
ALTER TABLE `tbl_reservation`
  ADD CONSTRAINT `tbl_reservation_ibfk_1` FOREIGN KEY (`r_approved_ID`) REFERENCES `tbl_approved` (`approve_ID`),
  ADD CONSTRAINT `tbl_reservation_ibfk_2` FOREIGN KEY (`r_user_ID`) REFERENCES `tbl_user` (`user_ID`),
  ADD CONSTRAINT `tbl_reservation_ibfk_3` FOREIGN KEY (`r_room_ID`) REFERENCES `tbl_room` (`room_ID`),
  ADD CONSTRAINT `tbl_reservation_ibfk_4` FOREIGN KEY (`notifID`) REFERENCES `tbl_notification` (`notificationID`);

--
-- Constraints for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD CONSTRAINT `tbl_user_ibfk_1` FOREIGN KEY (`isApproved`) REFERENCES `tbl_approved` (`approve_ID`),
  ADD CONSTRAINT `tbl_user_ibfk_2` FOREIGN KEY (`user_course_ID`) REFERENCES `tbl_course` (`course_ID`),
  ADD CONSTRAINT `tbl_user_ibfk_4` FOREIGN KEY (`user_s_ID`) REFERENCES `tbl_section` (`s_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
