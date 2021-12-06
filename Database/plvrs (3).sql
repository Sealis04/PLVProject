-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 06, 2021 at 12:35 PM
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
(6, 'Restrictions'),
(7, 'Inventory'),
(8, 'mnbvcmh'),
(9, '');

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
(3, 'Monoblock Chairs', '1500', 'Chair', 0, 0),
(4, 'Projector Screen', '2', 'Screen', 0, 0),
(5, 'Extension Cords', '10', 'Cord', 0, 0),
(8, 'asfa', '0', 'asfasf', 0, 0),
(9, 'zxcb', '0', '1254', 0, 0),
(10, 'practice', '23', 'zxcv', 0, 0),
(11, 'srdg`', '25', 'hj', 0, 0),
(12, 'zxv', '0', 'zxv', 0, 0),
(13, 'xcvn', '0', 'xcvn', 0, 0),
(14, 'zdf', '0', 'asf', 0, 0),
(15, 'Sample', '23', 'lol', 0, 0),
(16, '', '0', '', 0, 0),
(17, 'asd', '0', 'on', 1, 0),
(18, 'asd', '123', 'asd', 0, 1),
(19, 'asd', '123', 'asd', 0, 1),
(20, 'asd', '1233', 'asd', 0, 0);

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
(1, NULL, NULL),
(2, NULL, NULL),
(3, NULL, NULL),
(4, NULL, NULL),
(9, 4, 1),
(11, NULL, NULL),
(12, 3, 13),
(13, 3, 13),
(14, 3, 13),
(14, 4, 1);

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
(1, 13, 0, '2021-11-01 15:55:46', 1),
(2, 14, 0, '2021-11-01 16:02:19', 1),
(3, 15, 0, '2021-11-01 16:03:19', 2),
(4, 16, 0, '2021-11-01 16:04:07', 2),
(5, 17, 0, '2021-11-01 16:07:54', 1),
(7, 13, 0, '2021-11-01 16:22:32', 1),
(8, 14, 1, '2021-11-01 18:11:46', 1),
(9, 14, 0, '2021-11-01 19:20:03', 1),
(10, 14, 0, '2021-11-01 19:20:09', 1),
(11, 14, 0, '2021-11-01 19:20:21', 1),
(12, 14, 0, '2021-11-01 19:20:28', 1),
(13, 14, 1, '2021-11-01 19:20:52', 1),
(14, 14, 0, '2021-11-01 19:21:23', 1),
(15, 14, 1, '2021-11-01 19:22:28', 1),
(16, 14, 0, '2021-11-01 19:23:26', 1),
(17, 14, 0, '2021-11-01 19:23:42', 1),
(18, 14, 0, '2021-11-01 19:37:34', 2),
(19, 14, 0, '2021-11-01 19:38:13', 2),
(20, 14, 0, '2021-11-01 19:38:17', 2),
(21, 14, 0, '2021-11-01 19:38:36', 2),
(22, 14, 0, '2021-11-01 19:39:35', 2),
(23, 14, 0, '2021-11-01 19:40:11', 2),
(24, 14, 0, '2021-11-01 19:40:35', 2),
(25, 14, 0, '2021-11-01 19:40:42', 2),
(26, 21, 0, '2021-11-01 19:41:06', 1),
(27, 14, 0, '2021-11-01 19:41:13', 2),
(28, 14, 0, '2021-11-01 19:41:57', 2),
(29, 13, 0, '2021-11-23 13:58:48', 1),
(30, 0, 0, '2021-11-23 20:32:36', 2),
(31, 0, 0, '2021-11-23 20:34:54', 2),
(32, 13, 0, '2021-11-25 14:41:05', 2),
(33, 13, 0, '2021-11-25 15:14:44', 2),
(34, 13, 0, '2021-11-25 15:15:13', 2),
(35, 13, 0, '2021-11-26 23:08:02', 2),
(36, 13, 0, '2021-11-28 14:43:33', 2),
(37, 13, 0, '2021-11-28 14:44:58', 2),
(38, 13, 0, '2021-11-28 14:53:42', 2),
(39, 13, 0, '2021-11-29 15:19:37', 2);

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
(6, 'Requestor cannot borrow an equipment if there is no room reserved. Auditorium only allow 1 reservation per day. One projector is allowed to borrow per Lecture and Simulation Room. ', 6, 0),
(35, 'xcvxcvxcvxcvxcv', 7, 0),
(36, 'vbmg', 5, 0),
(37, '6ulryufl', 8, 0),
(38, '', 9, 0),
(39, '', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reservation`
--

CREATE TABLE `tbl_reservation` (
  `r_ID` int(10) NOT NULL,
  `r_event` text DEFAULT NULL,
  `r_startDateAndTime` datetime DEFAULT NULL,
  `r_endDateAndTime` datetime DEFAULT NULL,
  `r_status` tinyint(1) DEFAULT 0,
  `r_user_ID` int(10) DEFAULT NULL,
  `r_approved_ID` int(10) DEFAULT NULL,
  `r_room_ID` int(10) NOT NULL,
  `r_reviewed` tinyint(4) NOT NULL DEFAULT 0,
  `r_letter_file` varchar(255) DEFAULT NULL,
  `r_Remarks` longtext NOT NULL,
  `isDeleted` tinyint(4) DEFAULT 0,
  `notificationID` int(11) NOT NULL,
  `DateStart` date DEFAULT NULL,
  `DateEnd` date DEFAULT NULL,
  `TimeStart` time DEFAULT NULL,
  `TimeEnd` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_reservation`
--

INSERT INTO `tbl_reservation` (`r_ID`, `r_event`, `r_startDateAndTime`, `r_endDateAndTime`, `r_status`, `r_user_ID`, `r_approved_ID`, `r_room_ID`, `r_reviewed`, `r_letter_file`, `r_Remarks`, `isDeleted`, `notificationID`, `DateStart`, `DateEnd`, `TimeStart`, `TimeEnd`) VALUES
(1, '1', '2021-11-21 08:00:00', '2021-11-21 13:13:05', 0, 13, 1, 1, 1, '1626979229572.png', 'asdasdasd', 0, 7, NULL, NULL, NULL, '00:00:00'),
(2, '2', '2021-11-21 08:00:00', '2021-11-21 09:00:00', 0, 14, 1, 2, 1, '1626979229572.png', '', 0, 8, NULL, NULL, NULL, '00:00:00'),
(3, '3', '2021-11-01 08:00:00', '2021-11-01 09:00:00', 0, 14, 1, 3, 0, '1626979229572.png', '', 0, 13, NULL, NULL, NULL, '00:00:00'),
(4, '4', '2021-11-01 08:00:00', '2021-11-01 09:00:00', 0, 14, 1, 4, 1, '1626979229572.png', '', 0, 15, NULL, NULL, NULL, '00:00:00'),
(9, NULL, '2021-11-30 12:52:50', '2021-11-30 23:08:16', 0, 13, 1, 1, 1, 'Admin Darilag GarciaID', '', 0, 35, '2021-12-01', '2021-12-01', '08:00:00', '15:00:00'),
(11, 'Sampple for two daysd', '2021-11-30 14:43:57', '2021-11-30 14:44:00', 0, 13, 1, 4, 1, 'Admin Darilag GarciaID', '', 0, 36, '2021-12-01', '2021-12-01', '08:00:00', '09:00:00'),
(12, 'asdasd', '2021-11-30 14:46:49', '2021-11-30 14:46:51', 0, 21, 2, 6, 0, 'Admin Darilag GarciaID', '', 0, 37, '2021-12-04', '2021-12-04', '08:00:00', '09:00:00'),
(13, 'Hello', '2021-11-30 14:53:50', '2021-11-30 14:53:52', 0, 21, 1, 2, 0, 'Admin Darilag GarciaID', '', 0, 38, '2021-12-04', '2021-12-04', '08:00:00', '09:00:00'),
(14, 'Multiequipp', '2021-11-30 15:19:41', '2021-11-30 15:19:43', 0, 21, 1, 5, 0, 'Admin Darilag GarciaID', '', 0, 26, '2021-12-04', '2021-12-04', '08:00:00', '09:00:00');

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
  `notificationID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`user_ID`, `user_email`, `user_password`, `user_firstName`, `user_middleName`, `user_lastName`, `user_contactNumber`, `user_course_ID`, `PLV_ID`, `isAdmin`, `isApproved`, `r_marked`, `notificationID`) VALUES
(13, 'admin1@gmail.com', '$2y$10$AWJtx8Od.kq/3XCnnPGO0.KYknstQL8COfywaUz7FswJ7N5B/5o1K', 'Admin', 'Darilag', 'Garcia', '9399465176', 1, '1626979229572.png', 1, 1, 0, 1),
(14, 'user1@gmail.com', '$2y$10$ZLiYnQmADleMdiI.UO5EWesok.d4WqwYdH3kqo4sPanAQu.LvHUpG', 'Bryan', 'Darilag', 'Garcia', '9399465176', 1, 'C:/xampp/htdocs/practice/assets/plvrs (4).sql', 0, 1, 0, 2),
(15, 'user2@gmail.com', '$2y$10$ej/E2MuY.7KzwB6LbAhlquQh4Sp6sUWs6dEONhlNjiEflrvRAhqFu', 'Juan', 'Pedro', 'Penduko', '9098898899', 1, 'C:/xampp/htdocs/practice/assets/plvrs (4).sql', 0, 3, 0, 3),
(16, 'oapskdpoaskdpo@gmail.com', '$2y$10$jT2mkW2tHgQknJQ2RcepDOh74.JFX0A8mrPofZV7aLKw0EpTdlVbi', 'PK P\'SEOF', 'pow krpOQAWKDPO', 'K QDPO', '9994761120', 1, 'C:/xampp/htdocs/practice/assets/73952907_p0_master1200.jpg', 0, 3, 0, 4),
(17, 'Sjdoiajsdoi@gmail.com', '$2y$10$ppFZyBr.ur/Dc6F6up7JcebU40uP5gpiPbrYCZerdAsVIfpj8XWW.', 'SDIFIMI', 'o feg', 'adsfv asdfg', '9994875123', 1, '238940587_3150593868501949_3453972231494101211_n.jpg', 0, 3, 0, 5),
(20, 'asdasdasd@gmail.com', '$2y$10$1feiAc27SRZ1fPrdbyZHSuOjqOCNFwcnM2BCKsVfPC5dhTW03lQi6', 'oikijoiasijdoi', 'jdoiasjdoi', 'sdasdqasd', '10923810298', 1, 'ID', 0, 2, 0, 30),
(21, 'asdasdasdasd@gmail.com', '$2y$10$JAEKVLqU7TaljpV3xw5VF.V/awA5hFTCZbIND7f5KmncQFvo1kxN2', 'asdas', 'xczzz', 'xvbxfgdhytrsyre', '12312313231', 1, 'asdasxvbxfgdhytrsyreID', 0, 2, 0, 26);

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
  ADD KEY `r_room_ID` (`r_room_ID`),
  ADD KEY `tbl_reservation_ibfk_4` (`notificationID`);

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
  ADD KEY `isApproved` (`isApproved`),
  ADD KEY `tbl_user_ibfk_3` (`notificationID`);

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
  MODIFY `equipment_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tbl_notification`
--
ALTER TABLE `tbl_notification`
  MODIFY `notificationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `tbl_policies`
--
ALTER TABLE `tbl_policies`
  MODIFY `p_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `tbl_reservation`
--
ALTER TABLE `tbl_reservation`
  MODIFY `r_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_room`
--
ALTER TABLE `tbl_room`
  MODIFY `room_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `user_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

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
  ADD CONSTRAINT `tbl_reservation_ibfk_4` FOREIGN KEY (`notificationID`) REFERENCES `tbl_notification` (`notificationID`);

--
-- Constraints for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD CONSTRAINT `tbl_user_ibfk_1` FOREIGN KEY (`isApproved`) REFERENCES `tbl_approved` (`approve_ID`),
  ADD CONSTRAINT `tbl_user_ibfk_2` FOREIGN KEY (`user_course_ID`) REFERENCES `tbl_course` (`course_ID`),
  ADD CONSTRAINT `tbl_user_ibfk_3` FOREIGN KEY (`notificationID`) REFERENCES `tbl_notification` (`notificationID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
