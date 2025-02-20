-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 08, 2024 at 09:05 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `state`
--

-- --------------------------------------------------------

--
-- Table structure for table `state_master`
--

CREATE TABLE `state_master` (
  `state_id` smallint(5) NOT NULL,
  `state_name` varchar(100) NOT NULL,
  `state_code` char(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `state_master`
--

INSERT INTO `state_master` (`state_id`, `state_name`, `state_code`) VALUES
(1, 'Andhra Pradesh', '37'),
(2, 'Arunachal Pradesh', '12'),
(3, 'Assam', '18'),
(4, 'Bihar', '10'),
(5, 'Chhattisgarh', '22'),
(6, 'Goa', '30'),
(7, 'Gujarat', '24'),
(8, 'Haryana', '06'),
(9, 'Himachal Pradesh', '02'),
(10, 'Jharkhand', '20'),
(11, 'Karnataka', '29'),
(12, 'Kerala', '32'),
(13, 'Madhya Pradesh', '23'),
(14, 'Maharashtra', '27'),
(15, 'Manipur', '14'),
(16, 'Meghalaya', '17'),
(17, 'Mizoram', '15'),
(18, 'Nagaland', '13'),
(19, 'Odisha', '21'),
(20, 'Punjab', '03'),
(21, 'Rajasthan', '08'),
(22, 'Sikkim', '11'),
(23, 'Tamil Nadu', '33'),
(24, 'Telangana', '36'),
(25, 'Tripura', '16'),
(26, 'Uttar Pradesh', '09'),
(27, 'Uttarakhand', '05'),
(28, 'West Bengal', '19'),
(29, 'Andaman and Nicobar Island', '35'),
(30, 'Chandigarh', '04'),
(31, 'Dadra and Nagar Haveli and Daman and Diu', '26'),
(32, 'Delhi', '07'),
(33, 'Ladakh', '38'),
(34, 'Lakshadweep', '31'),
(35, 'Jammu and Kashmir', '01'),
(36, 'Puducherry', '34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `state_master`
--
ALTER TABLE `state_master`
  ADD PRIMARY KEY (`state_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `state_master`
--
ALTER TABLE `state_master`
  MODIFY `state_id` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
