-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 14, 2021 at 01:25 PM
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
(478, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_policy`
--

CREATE TABLE `tbl_policy` (
  `policy_categories` varchar(255) DEFAULT NULL,
  `policy_description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reservation`
--

CREATE TABLE `tbl_reservation` (
  `r_ID` int(10) NOT NULL,
  `r_event` date DEFAULT NULL,
  `r_startDateAndTime` datetime DEFAULT NULL,
  `r_endDateAndTime` datetime DEFAULT NULL,
  `r_status` tinyint(1) DEFAULT NULL,
  `r_user_ID` int(10) DEFAULT NULL,
  `r_approved_ID` int(10) DEFAULT NULL,
  `r_room_ID` int(10) NOT NULL,
  `r_letter_file` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_approved`
--
ALTER TABLE `tbl_approved`
  ADD PRIMARY KEY (`approve_ID`);

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
-- AUTO_INCREMENT for table `tbl_reservation`
--
ALTER TABLE `tbl_reservation`
  MODIFY `r_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=479;

--
-- AUTO_INCREMENT for table `tbl_room`
--
ALTER TABLE `tbl_room`
  MODIFY `room_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `user_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_equipment_reserved`
--
ALTER TABLE `tbl_equipment_reserved`
  ADD CONSTRAINT `tbl_equipment_reserved_ibfk_1` FOREIGN KEY (`r_ID`) REFERENCES `tbl_reservation` (`r_ID`),
  ADD CONSTRAINT `tbl_equipment_reserved_ibfk_2` FOREIGN KEY (`equipment_ID`) REFERENCES `tbl_equipment` (`equipment_ID`);

--
-- Constraints for table `tbl_reservation`
--
ALTER TABLE `tbl_reservation`
  ADD CONSTRAINT `tbl_reservation_ibfk_1` FOREIGN KEY (`r_user_ID`) REFERENCES `tbl_user` (`user_ID`),
  ADD CONSTRAINT `tbl_reservation_ibfk_2` FOREIGN KEY (`r_approved_ID`) REFERENCES `tbl_approved` (`approve_ID`),
  ADD CONSTRAINT `tbl_reservation_ibfk_4` FOREIGN KEY (`r_room_ID`) REFERENCES `tbl_room` (`room_ID`);

--
-- Constraints for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD CONSTRAINT `tbl_user_ibfk_1` FOREIGN KEY (`user_course_ID`) REFERENCES `tbl_course` (`course_ID`),
  ADD CONSTRAINT `tbl_user_ibfk_2` FOREIGN KEY (`isApproved`) REFERENCES `tbl_approved` (`approve_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
