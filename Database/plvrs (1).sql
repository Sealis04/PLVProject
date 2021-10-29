-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 29, 2021 at 05:09 PM
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
(5, 'Extension Cords', '10', 'Cord', 0),
(8, 'asfa', '0', 'asfasf', 0),
(9, 'zxcb', '0', '1254', 0),
(10, 'practice', '23', 'zxcv', 0),
(11, 'srdg`', '25', 'hj', 0),
(12, 'zxv', '0', 'zxv', 0),
(13, 'xcvn', '0', 'xcvn', 0),
(14, 'zdf', '0', 'asf', 0),
(15, 'Sample', '23', 'lol', 0);

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
(482, NULL, NULL),
(483, NULL, NULL),
(484, NULL, NULL),
(485, NULL, NULL),
(486, NULL, NULL),
(487, NULL, NULL),
(488, NULL, NULL),
(489, NULL, NULL),
(490, NULL, NULL),
(491, NULL, NULL),
(492, NULL, NULL),
(493, NULL, NULL),
(494, NULL, NULL),
(495, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_notification`
--

CREATE TABLE `tbl_notification` (
  `notificationID` int(11) NOT NULL,
  `forUserID` int(11) NOT NULL,
  `isUser` tinyint(11) NOT NULL,
  `isRead` tinyint(1) NOT NULL DEFAULT 0,
  `time` datetime NOT NULL DEFAULT current_timestamp(),
  `decision` tinyint(1) NOT NULL,
  `r_ID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_notification`
--

INSERT INTO `tbl_notification` (`notificationID`, `forUserID`, `isUser`, `isRead`, `time`, `decision`, `r_ID`) VALUES
(22, 13, 0, 0, '2021-10-18 20:16:38', 1, 481),
(23, 13, 1, 0, '2021-10-18 20:54:58', 1, 481),
(24, 15, 1, 0, '2021-10-28 16:52:12', 1, 481),
(25, 13, 1, 0, '2021-10-28 21:13:04', 3, 481),
(38, 13, 1, 0, '2021-10-29 23:08:23', 1, 488),
(39, 13, 0, 0, '2021-10-29 23:08:53', 2, 495);

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
(1, 'Making a reservation is a first come, first serve basis whether the requestor is a PLV student, Professor, or Admin Personnel. A reservation will be requested using PLVRS only and it should be requested 3 days before the event.', 1),
(2, 'To request a reservation, fill out all the required information in reservation form. It will not proceed if there is no attached letter of appoval. When rescheduling, the only requirement is the same letter of approval with rescheduled date that is signed by the respected authorities. A requestor ca', 2),
(3, 'Requested reservation that are made 2 days before the event, exceeds the maximum capacity of a room, unavailable rooms in PLVRS, and coinciding schedule with other reservations will be declined by the GSO.', 3),
(4, 'The rooms that can be reserved are: Lecture Room 301, 302, 303, 401, 402, and 403. Pre-school Simulation Room, Business Administration Simulation Room, and Auditorium. The equipment that can be borrowed are: projectors, 2 projector screens, 2 mobile speakers with microphones each, and 1500 monobloc ', 4),
(5, 'The equipment borrowed must returned directly to the office within the day after using it. If there are damages on a borrowed room or equipment, the requestor will be contacted by the GSO and must personally go to their office.', 5),
(6, 'Requestor cannot borrow an equipment if there is no room reserved. Auditorium only allow 1 reservation per day. One projector is allowed to borrow per Lecture and Simulation Room. ', 6),
(35, 'xcvxcvxcvxcvxcv', 7),
(36, 'vbmg', 5),
(37, '6ulryufl', 8),
(38, '', 9),
(39, '', 1);

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
  `r_Remarks` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_reservation`
--

INSERT INTO `tbl_reservation` (`r_ID`, `r_event`, `r_startDateAndTime`, `r_endDateAndTime`, `r_status`, `r_user_ID`, `r_approved_ID`, `r_room_ID`, `r_reviewed`, `r_letter_file`, `r_Remarks`) VALUES
(481, 'asdasd', '2021-10-19 08:00:00', '2021-10-19 09:00:00', 0, 13, 1, 2, 0, 'C:/xampp/htdocs/practice/assets/039e462305c40d47ea99b2e9b4a330e5.jpg', 'asd'),
(482, 'Something', '2021-10-21 08:00:00', '2021-10-21 09:00:00', 0, 13, 1, 1, 0, 'C:/xampp/htdocs/practice/assets/147340154_148337303789733_1933449064246305894_o.png', ''),
(483, NULL, '2021-10-30 08:00:00', '2021-10-30 09:00:00', 0, 13, 1, 1, 0, 'C:/xampp/htdocs/practice/assets/03.png', ''),
(484, NULL, '2021-11-01 08:00:00', '2021-11-01 09:00:00', 0, 13, 0, 2, 0, 'C:/xampp/htdocs/practice/assets/download.png', ''),
(485, NULL, '2021-11-01 08:00:00', '2021-11-01 09:00:00', 0, 13, 1, 3, 0, 'C:/xampp/htdocs/practice/assets/Carpal tunnel exercise.jpg', ''),
(486, NULL, '2021-11-01 08:00:00', '2021-11-01 09:00:00', 0, 13, 1, 4, 0, 'C:/xampp/htdocs/practice/assets/AP-hd_leftyhandcream_210624.jpg', ''),
(487, NULL, '2021-11-01 08:00:00', '2021-11-01 09:00:00', 0, 13, 1, 5, 0, 'C:/xampp/htdocs/practice/assets/Carpal tunnel exercise.jpg', ''),
(488, NULL, '2021-11-01 08:00:00', '2021-11-01 09:00:00', 0, 13, 1, 6, 0, 'C:/xampp/htdocs/practice/assets/download.png', ''),
(489, NULL, '2021-11-01 08:00:00', '2021-11-01 09:00:00', 0, 13, 2, 7, 0, 'C:/xampp/htdocs/practice/assets/download.png', ''),
(490, NULL, '2021-11-01 08:00:00', '2021-11-01 09:00:00', 0, 13, 2, 8, 0, 'C:/xampp/htdocs/practice/assets/download.png', ''),
(491, NULL, '2021-11-01 08:00:00', '2021-11-01 09:00:00', 0, 13, 2, 9, 0, 'C:/xampp/htdocs/practice/assets/download.png', ''),
(492, NULL, '2021-11-01 08:00:00', '2021-11-01 09:00:00', 0, 13, 2, 10, 0, 'C:/xampp/htdocs/practice/assets/Carpal tunnel exercise.jpg', ''),
(493, NULL, '2021-11-01 08:00:00', '2021-11-01 09:00:00', 0, 13, 2, 11, 0, 'C:/xampp/htdocs/practice/assets/download.png', ''),
(494, NULL, '2021-11-01 08:00:00', '2021-11-01 09:00:00', 0, 13, 2, 12, 0, 'C:/xampp/htdocs/practice/assets/download.png', ''),
(495, NULL, '2021-11-01 08:00:00', '2021-11-01 09:00:00', 0, 13, 2, 1, 0, 'C:/xampp/htdocs/practice/assets/download.png', '');

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
(7, 'Speech Laboratory', 0, 'Speech Laboratory', 0),
(8, 'Student Lounge', 0, 'Student Lounge', 0),
(9, 'Holding Area', 0, 'Holding Area', 0),
(10, 'adsg', 1245, 'awd', 0),
(11, 'zcvb', 136, 'asd', 0),
(12, 'zbz', 0, '124', 0),
(13, 'zbz', 0, '124', 0),
(14, 'cvn', 0, 'afzxv', 0),
(15, 'vbnrh', 0, 'ae123', 0),
(16, 'vbnrh', 0, 'ae123', 0);

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
  `r_marked` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`user_ID`, `user_email`, `user_password`, `user_firstName`, `user_middleName`, `user_lastName`, `user_contactNumber`, `user_course_ID`, `PLV_ID`, `isAdmin`, `isApproved`, `r_marked`) VALUES
(13, 'admin1@gmail.com', '$2y$10$AWJtx8Od.kq/3XCnnPGO0.KYknstQL8COfywaUz7FswJ7N5B/5o1K', 'Bryan', 'Darilag', 'Garcia', '9399465176', 1, 'C:/xampp/htdocs/practice/assets/plvrs (4).sql', 1, 1, 0),
(14, 'user1@gmail.com', '$2y$10$ZLiYnQmADleMdiI.UO5EWesok.d4WqwYdH3kqo4sPanAQu.LvHUpG', 'Bryan', 'Darilag', 'Garcia', '9399465176', 1, 'C:/xampp/htdocs/practice/assets/plvrs (4).sql', 0, 1, 0),
(15, 'user2@gmail.com', '$2y$10$ej/E2MuY.7KzwB6LbAhlquQh4Sp6sUWs6dEONhlNjiEflrvRAhqFu', 'Juan', 'Pedro', 'Penduko', '9098898899', 1, 'C:/xampp/htdocs/practice/assets/plvrs (4).sql', 0, 3, 0);

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
  ADD PRIMARY KEY (`notificationID`),
  ADD KEY `r_ConstraintID` (`r_ID`);

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
  MODIFY `equipment_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
  MODIFY `r_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=496;

--
-- AUTO_INCREMENT for table `tbl_room`
--
ALTER TABLE `tbl_room`
  MODIFY `room_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `user_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_notification`
--
ALTER TABLE `tbl_notification`
  ADD CONSTRAINT `r_ConstraintID` FOREIGN KEY (`r_ID`) REFERENCES `tbl_reservation` (`r_ID`);

--
-- Constraints for table `tbl_policies`
--
ALTER TABLE `tbl_policies`
  ADD CONSTRAINT `tbl_policies_ibfk_1` FOREIGN KEY (`p_ct_ID`) REFERENCES `tbl_category_policy` (`ct_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
