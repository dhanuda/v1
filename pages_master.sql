-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 10, 2024 at 06:27 PM
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
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `pages_master`
--

CREATE TABLE `pages_master` (
  `page_id` int(11) NOT NULL,
  `page_name` varchar(250) NOT NULL,
  `is_parent` int(4) NOT NULL,
  `parent_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `pages_master`
--

INSERT INTO `pages_master` (`page_id`, `page_name`, `is_parent`, `parent_id`) VALUES
(1, 'Dashboard', 0, 0),
(2, 'My Private Messages', 0, 0),
(3, 'My Profile', 0, 0),
(4, 'My Calendar', 0, 0),
(5, 'Settings', 0, 0),
(6, 'Departments', 0, 0),
(7, 'Users Management', 0, 0),
(8, 'Customers', 0, 0),
(9, 'Billing Management', 0, 0),
(10, 'Projects Management', 0, 0),
(11, 'Knowledge Base', 0, 0),
(12, 'Tickets Management', 0, 0),
(13, 'Resources', 0, 0),
(14, 'HR Management', 0, 0),
(15, 'Marketing Management', 0, 0),
(16, 'Dashboard', 1, 1),
(17, 'My Private Messages', 2, 2),
(18, 'My Profile', 3, 3),
(19, 'My Calendar', 4, 4),
(20, 'View Departments', 6, 6),
(21, 'View Projects', 10, 10),
(22, 'View Milestone Manager', 10, 10),
(23, 'Company Configuration', 5, 5),
(24, 'Branch Master', 5, 5),
(25, 'IP Master', 5, 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pages_master`
--
ALTER TABLE `pages_master`
  ADD PRIMARY KEY (`page_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pages_master`
--
ALTER TABLE `pages_master`
  MODIFY `page_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
