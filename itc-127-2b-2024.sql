-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2025 at 02:20 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `itc-127-2b-2024`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblaccounts`
--

CREATE TABLE `tblaccounts` (
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `usertype` varchar(50) NOT NULL,
  `userstatus` varchar(50) NOT NULL,
  `createdby` varchar(50) NOT NULL,
  `datecreated` date NOT NULL DEFAULT current_timestamp(),
  `email` varchar(50) DEFAULT NULL,
  `timecreated` varchar(50) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblaccounts`
--

INSERT INTO `tblaccounts` (`username`, `password`, `usertype`, `userstatus`, `createdby`, `datecreated`, `email`, `timecreated`, `profile_picture`) VALUES
('2021008', '1234', 'STUDENT', 'ACTIVE', 'admin', '2024-04-20', NULL, '07:27:19pm', 'uploads/420582761_7343925795673365_8019901552228046525_n (1).jpg'),
('2200000', '1234', 'STUDENT', 'ACTIVE', 'admin', '2024-04-15', NULL, '12:32:53am', NULL),
('2200726', '1234', 'STUDENT', 'ACTIVE', 'admin', '2024-04-15', NULL, '2:17.55pm', NULL),
('2200813', '1234', 'STUDENT', 'ACTIVE', 'admin', '2024-04-14', 'tornoarvin@gmail.com', '10:53:50am', 'uploads/arvinstud.jpg'),
('2433057', '1234', 'STUDENT', 'ACTIVE', 'admin', '2024-04-16', NULL, '05:17:20pm', NULL),
('admin', '1234', 'ADMINISTRATOR', 'ACTIVE', 'admin', '2024-03-16', NULL, '09:22:35am', 'uploads/3.jpg'),
('arvin', '1234', 'ADMINISTRATOR', 'ACTIVE', 'admin', '2024-03-13', NULL, '02:41:47pm', 'uploads/1.jpg'),
('Magnus carlsen', '1234', 'ADMINISTRATOR', 'ACTIVE', 'admin', '2024-03-16', NULL, '10:10:07am', NULL),
('registrar', '1234', 'REGISTRAR', 'ACTIVE', 'admin', '2024-03-13', NULL, '02:41:07pm', 'uploads/3.jpg'),
('student', '1234', 'STUDENT', 'ACTIVE', 'admin', '2024-03-13', NULL, '02:41:29pm', 'uploads/4.jpg'),
('tal', '1234', 'ADMINISTRATOR', 'ACTIVE', 'admin', '2024-03-23', NULL, '02:02:41pm', NULL),
('test', '1234', 'STAFF', 'ACTIVE', 'arvin', '2024-04-22', NULL, '12:05:39pm', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblresidents`
--

CREATE TABLE `tblresidents` (
  `id` int(11) NOT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `birthday` varchar(40) NOT NULL,
  `birthplace` varchar(40) NOT NULL,
  `civil_status` varchar(20) DEFAULT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `voter_status` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblresidents`
--

INSERT INTO `tblresidents` (`id`, `last_name`, `age`, `gender`, `first_name`, `birthday`, `birthplace`, `civil_status`, `middle_name`, `voter_status`, `address`, `image_path`) VALUES
(1, 'ada', 14, 'Male', 'add', '', '', 'Separated', 'qeqe', 'Registered', 'addad', ''),
(2, 'Baltao', 141, 'Male', 'adad', '', '', 'Separated', 'adadad', 'Registered', 'adadad', ''),
(3, 'Baltao', 414, 'Male', 'adad', '', '', 'Separated', 'adad', 'Registered', 'adadadad', ''),
(4, 'adad', 14, 'Female', 'adad', '', '', 'Separated', 'qeqeqe', 'Registered', 'qeqeqe', ''),
(5, 'Baltao', 1313, 'Male', '1331', '2025-04-11', 'adad', 'Separated', 'hahahha', 'Registered', 'qeqeqe', ''),
(6, 'Baltao', 1414, 'Male', 'Steve', '2025-04-12', 'adada', 'Married', 'hahahhah', 'Registered', 'dadadad131', ''),
(7, 'Baltao', 41, 'Male', 'angelo', '2025-04-11', 'adxdad', 'Separated', 'adada', 'Registered', 'qeqex131', ''),
(8, 'adadad', 141, 'Male', 'hdsdh', '2025-04-11', 'adad', 'Married', 'adad', 'Registered', 'qeedada', ''),
(9, 'asas', 113, 'Male', 'gggg', '2025-04-11', 'qeqe', 'Separated', 'qeqe', 'Registered', 'qeqeqe', ''),
(10, 'Baltao', 4113, 'Male', 'Steve13133', '2025-04-11', 'adadad', 'Married', 'adad', 'Registered', 'addad', ''),
(11, 'hahahhaha', 113, 'Male', 'hahahahha', '2025-04-11', 'qeqeqe', 'Separated', 'rrqrqr', 'Registered', 'qrqdsqddq', ''),
(12, 'espinar', 144, 'Male', 'geryk', '2025-04-11', 'adadda', 'Married', 'addda', 'Non-registered', 'adadadad', ''),
(13, 'Baltao', 1444, 'Male', 'adadad', '2025-04-11', 'adadad', 'Married', 'adad', 'Registered', 'qeqeqe', ''),
(14, 'adada', 1414, 'Male', 'adadadq', '2025-04-11', 'qeqdq', 'Separated', '', 'Registered', 'qeqe13414', ''),
(15, 'QADAE', 55, 'Male', 'EQEQE', '2025-04-11', '41414', 'Married', 'ADAD', 'Registered', 'QEQEQE', ''),
(16, 'Baltao', 144, 'Female', 'SASAGSG', '2025-04-17', '1313', 'Married', 'GAGAGGA', 'Registered', '131331', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblaccounts`
--
ALTER TABLE `tblaccounts`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `tblresidents`
--
ALTER TABLE `tblresidents`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblresidents`
--
ALTER TABLE `tblresidents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
