-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 13, 2021 at 09:19 AM
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
  `equipment_description` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_equipment`
--

INSERT INTO `tbl_equipment` (`equipment_ID`, `equipment_name`, `equipment_quantity`, `equipment_description`) VALUES
(1, 'Projectors', '14', 'Sound'),
(2, 'Mobile Speaker', '13', 'Sound'),
(3, 'Monoblock Chairs', '1500', 'Chair'),
(4, 'Projector Screen', '2', 'Screen'),
(5, 'Extension Cords', '10', 'Cord'),
(6, 'practice_equip', NULL, NULL),
(7, 'asdasd', '12', 'asdasdasd');

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

--
-- Dumping data for table `tbl_reservation`
--

INSERT INTO `tbl_reservation` (`r_ID`, `r_event`, `r_startDateAndTime`, `r_endDateAndTime`, `r_status`, `r_user_ID`, `r_approved_ID`, `r_room_ID`, `r_letter_file`) VALUES
(437, NULL, '2021-06-27 08:00:00', '2021-06-28 09:00:00', NULL, 7, 1, 1, 'C:/xampp/htdocs/practice/assets/6fd3fe62946291637d25d8047536f278.jpg'),
(438, NULL, '2021-06-27 08:00:00', '2021-06-28 09:00:00', NULL, 7, 2, 2, NULL),
(464, NULL, '2021-06-22 08:00:00', '2021-06-22 09:00:00', NULL, 7, 3, 1, 'C:/xampp/htdocs/practice/assets/11304018965f3102586bb5c.png'),
(470, NULL, '2021-07-23 08:00:00', '2021-07-23 21:00:00', NULL, 9, 3, 1, 'C:/xampp/htdocs/practice/assets/189773813_474294160300621_4912659647283945307_n.png'),
(471, NULL, '2021-07-23 08:00:00', '2021-07-24 09:00:00', NULL, 9, 3, 5, 'C:/xampp/htdocs/practice/assets/189773813_474294160300621_4912659647283945307_n.png'),
(472, NULL, '2021-07-28 08:00:00', '2021-07-29 09:00:00', NULL, 9, 3, 6, 'C:/xampp/htdocs/practice/assets/189773813_474294160300621_4912659647283945307_n.png'),
(473, NULL, '2021-10-10 08:00:00', '2021-10-10 09:00:00', NULL, 11, 2, 1, 'C:/xampp/htdocs/practice/assets/For-Policies-Page (1).docx'),
(474, NULL, '2021-10-10 08:00:00', '2021-10-10 09:00:00', NULL, 11, 2, 1, 'C:/xampp/htdocs/practice/assets/For-Policies-Page (1).docx'),
(475, NULL, '2021-10-10 08:00:00', '2021-10-10 09:00:00', NULL, 11, 2, 1, 'C:/xampp/htdocs/practice/assets/For-Policies-Page (1).docx'),
(476, NULL, '2021-10-10 08:00:00', '2021-10-10 09:00:00', NULL, 12, 2, 1, 'C:/xampp/htdocs/practice/assets/11846540_1064365053582314_5233718397567919860_n.jpg'),
(477, NULL, '2021-10-10 08:00:00', '2021-10-10 09:00:00', NULL, 12, 2, 1, 'C:/xampp/htdocs/practice/assets/For-Policies-Page (1).docx'),
(478, NULL, '2021-10-10 08:00:00', '2021-10-10 09:00:00', NULL, 12, 2, 1, 'C:/xampp/htdocs/practice/assets/For-Policies-Page (1).docx');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_room`
--

CREATE TABLE `tbl_room` (
  `room_ID` int(10) NOT NULL,
  `room_name` varchar(25) DEFAULT NULL,
  `room_capacity` int(10) DEFAULT NULL,
  `room_description` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_room`
--

INSERT INTO `tbl_room` (`room_ID`, `room_name`, `room_capacity`, `room_description`) VALUES
(1, 'LR 303', 50, '3rd Lecture Room in Floor'),
(2, 'LR 401', 50, '1st Lecture Room in Floor'),
(3, 'LR 402', 50, '2nd Lecture Room in Floor'),
(4, 'Auditorium', 500, 'Auditorium'),
(5, 'BA simulation', 50, 'BA simulation'),
(6, 'Pre school simulation', 120, 'Pre school simulation'),
(7, 'Speech Laboratory', NULL, 'Speech Laboratory'),
(8, 'Student Lounge', NULL, 'Student Lounge');

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
(6, 'suatengco04@gmail.comasda', '$2y$10$xQonnP2TDfOA8Zj0r0OPfuhyC.hHRd59cXQMAYyn.1IFXixHQgsWa', 'asdasdasd', 'Juan', 'Suatengco', '9994761209', 1, 'C:/xampp/htdocs/practice/assets/83382030_p0_master1200.jpg', 0, 3),
(7, 'suatengco04@gmail.com', '$2y$10$BwhkoF.c4jhipzIJluT/SO.obrI1XFsauYNfMrvYyeQJOBDNyKwKO', 'Sedrick James', 'Juan', 'Suatengco', '9994761209', 1, 'C:/xampp/htdocs/practice/assets/81126375_p9_master1200.jpg', 1, 1),
(8, 'adminbryan@gmail.com', '$2y$10$FUkR3iMI32veTC6/tE5eluk7VK/lljRzVFJAMaTzwPOYBL5vSSeo2', 'Bryan', 'Darilag', 'Garcia', '9399465176', 1, 'C:/xampp/htdocs/practice/assets/189773813_474294160300621_4912659647283945307_n.png', 1, 1),
(9, 'userbryan@gmail.com', '$2y$10$WDCpdok1rlTVWj3XTHs7oud6/ldN672wD8UzwEjTztaNGeR9PzLpC', 'Bryan', 'Darilag', 'Garcia', '9399465176', 1, 'C:/xampp/htdocs/practice/assets/189773813_474294160300621_4912659647283945307_n.png', 0, 1),
(10, 'userbryan2@gmail.com', '$2y$10$E2D8MK0VcMAdQLXAo8xr3uqrd7LCtfX6QZHw1s2TbQ5jyspIlU2R.', 'Bryan', 'Darilag', 'Garcia', '9399465176', 1, 'C:/xampp/htdocs/practice/assets/189773813_474294160300621_4912659647283945307_n.png', 0, 3),
(11, 'adminbryan2@gmail.com', '$2y$10$mSNWOcjyp6uhq9f7QM7kR.pYkUSap0/2E5KHM9Sx257fWRdisgiSq', 'Bryan', 'Darilag', 'Garcia', '9399465176', 1, 'C:/xampp/htdocs/practice/assets/Valenzuela_Seal.svg.png', 1, 1),
(12, 'userbryan3@gmail.com', '$2y$10$OEXFbP4Eguh/g3Uii5S51uzsouMQwvETSe6pfgDTAg4OuTbPv5L4.', 'Bryan', 'Darilag', 'Garcia', '9399465176', 1, 'C:/xampp/htdocs/practice/assets/For-Policies-Page (1).docx', 0, 1);

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
  MODIFY `room_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
