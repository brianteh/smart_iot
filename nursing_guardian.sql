-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 17, 2023 at 09:20 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nursing_guardian`
--

-- --------------------------------------------------------

--
-- Table structure for table `fall_record`
--

CREATE TABLE `fall_record` (
  `user_id` varchar(20) NOT NULL,
  `timestamp` datetime NOT NULL,
  `location_id` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fall_record`
--

INSERT INTO `fall_record` (`user_id`, `timestamp`, `location_id`) VALUES
('ABCDEFG', '2023-09-16 04:52:14', '2'),
('ASDFGHJKL', '2023-09-16 07:44:35', '4'),
('ASDFGHJKL', '2023-09-16 07:45:08', '4'),
('ASDFGHJKL', '2023-09-16 07:45:25', '4'),
('ASDFGHJKL', '2023-09-16 07:45:28', '4'),
('ASDFGHJKL', '2023-09-16 07:45:30', '4'),
('ABCDEFG', '2023-09-16 08:08:18', '4'),
('ABCDEFG', '2023-09-16 08:08:38', '4'),
('ABCDEFG', '2023-09-16 08:23:07', '1'),
('ABCDEFG', '2023-09-16 08:23:09', '1'),
('ABCDEFG', '2023-09-16 08:23:32', '1'),
('ABCDEFG', '2023-09-16 09:56:23', '4'),
('ABCDEFG', '2023-09-16 09:56:31', '1'),
('ABCDEFG', '2023-09-16 09:56:38', '1'),
('ABCDEFG', '2023-09-16 09:56:49', '1'),
('ABCDEFG', '2023-09-16 09:56:55', '1'),
('ABCDEFG', '2023-09-16 09:56:58', '1'),
('ABCDEFG', '2023-09-16 09:57:00', '1'),
('ABCDEFG', '2023-09-16 09:57:02', '1'),
('ABCDEFG', '2023-09-16 09:57:10', '1'),
('ABCDEFG', '2023-09-16 09:57:26', '1'),
('ABCDEFG', '2023-09-16 09:57:47', '1'),
('ABCDEFG', '2023-09-16 10:01:13', '1'),
('ABCDEFG', '2023-09-16 10:01:15', '1'),
('ABCDEFG', '2023-09-16 10:01:35', '1'),
('ABCDEFG', '2023-09-16 10:10:54', '3'),
('ABCDEFG', '2023-09-16 10:11:19', '3'),
('ABCDEFG', '2023-09-16 10:11:34', '3'),
('ABCDEFG', '2023-09-16 10:11:36', '1'),
('ABCDEFG', '2023-09-16 10:11:41', '3'),
('ABCDEFG', '2023-09-16 10:12:02', '3'),
('ABCDEFG', '2023-09-16 10:12:14', '3'),
('ABCDEFG', '2023-09-16 10:15:03', '1'),
('ABCDEFG', '2023-09-16 10:21:02', '1'),
('ABCDEFG', '2023-09-16 10:21:55', '1'),
('ABCDEFG', '2023-09-16 10:22:08', '1'),
('ABCDEFG', '2023-09-16 10:22:10', '1'),
('ABCDEFG', '2023-09-16 10:22:21', '1'),
('ABCDEFG', '2023-09-16 10:22:24', '1'),
('ABCDEFG', '2023-09-16 10:22:26', '1'),
('ABCDEFG', '2023-09-16 10:22:30', '1'),
('ABCDEFG', '2023-09-16 10:22:36', '1'),
('ABCDEFG', '2023-09-16 10:22:39', '1'),
('ABCDEFG', '2023-09-16 10:22:55', '1'),
('ABCDEFG', '2023-09-16 10:22:57', '1'),
('ABCDEFG', '2023-09-16 10:23:24', '1'),
('ABCDEFG', '2023-09-16 10:24:35', '1'),
('ABCDEFG', '2023-09-16 14:34:25', '1'),
('ABCDEFG', '2023-09-16 14:44:02', '4'),
('ABCDEFG', '2023-09-16 14:45:10', '4'),
('ABCDEFG', '2023-09-16 14:45:12', '4'),
('ABCDEFG', '2023-09-16 14:45:25', '4'),
('ABCDEFG', '2023-09-17 13:31:29', '1'),
('ABCDEFG', '2023-09-17 13:32:52', '1'),
('ABCDEFG', '2023-09-17 13:39:56', '1'),
('ABCDEFG', '2023-09-17 18:21:37', '1'),
('ABCDEFG', '2023-09-17 18:21:41', '1'),
('ABCDEFG', '2023-09-17 18:21:43', '1'),
('ABCDEFG', '2023-09-17 18:21:46', '1'),
('ABCDEFG', '2023-09-17 18:23:36', '1'),
('ABCDEFG', '2023-09-17 18:25:56', '1'),
('ABCDEFG', '2023-09-17 18:32:06', '4'),
('ABCDEFG', '2023-09-17 18:32:15', '1'),
('ABCDEFG', '2023-09-17 18:42:34', '1'),
('ABCDEFG', '2023-09-17 18:42:36', '1'),
('ABCDEFG', '2023-09-17 18:44:08', '4'),
('ABCDEFG', '2023-09-17 18:44:13', '4'),
('ABCDEFG', '2023-09-17 18:44:15', '4'),
('ABCDEFG', '2023-09-17 18:44:17', '4'),
('ABCDEFG', '2023-09-17 18:45:24', '4'),
('ABCDEFG', '2023-09-17 18:45:33', '4'),
('ABCDEFG', '2023-09-17 18:46:40', '1'),
('ABCDEFG', '2023-09-17 18:46:45', '1'),
('ABCDEFG', '2023-09-17 18:46:47', '1'),
('ABCDEFG', '2023-09-17 18:46:49', '1'),
('ABCDEFG', '2023-09-17 18:46:52', '1'),
('ABCDEFG', '2023-09-17 18:46:54', '1'),
('ABCDEFG', '2023-09-17 18:46:59', '1'),
('ABCDEFG', '2023-09-17 18:51:19', '4'),
('ABCDEFG', '2023-09-17 18:51:53', '4'),
('ABCDEFG', '2023-09-17 19:20:04', '1'),
('ABCDEFG', '2023-09-17 19:29:41', '1'),
('ABCDEFG', '2023-09-17 19:42:08', '4'),
('ABCDEFG', '2023-09-17 20:53:05', '4'),
('ABCDEFG', '2023-09-17 20:53:31', '4'),
('ABCDEFG', '2023-09-17 21:06:30', '4'),
('ABCDEFG', '2023-09-17 21:06:32', '4'),
('ABCDEFG', '2023-09-17 21:09:30', '4'),
('ABCDEFG', '2023-09-17 21:09:34', '4'),
('ABCDEFG', '2023-09-17 21:09:36', '4'),
('ABCDEFG', '2023-09-17 21:09:43', '4'),
('ABCDEFG', '2023-09-17 21:11:08', '4'),
('ABCDEFG', '2023-09-17 21:11:10', '4'),
('ABCDEFG', '2023-09-17 21:13:20', '4'),
('ABCDEFG', '2023-09-17 21:13:37', '4'),
('ABCDEFG', '2023-09-17 21:13:39', '4'),
('ABCDEFG', '2023-09-17 21:16:12', '4'),
('ABCDEFG', '2023-09-17 21:16:15', '4'),
('ABCDEFG', '2023-09-17 21:17:04', '4'),
('ABCDEFG', '2023-09-17 21:17:11', '4'),
('ABCDEFG', '2023-09-17 21:17:50', '4'),
('ABCDEFG', '2023-09-17 21:18:17', '4'),
('ABCDEFG', '2023-09-17 21:18:22', '4'),
('ABCDEFG', '2023-09-17 21:20:35', '4'),
('ABCDEFG', '2023-09-17 21:20:39', '4'),
('ABCDEFG', '2023-09-17 21:20:47', '4'),
('ABCDEFG', '2023-09-17 21:20:49', '4'),
('ABCDEFG', '2023-09-17 21:23:47', '4'),
('ABCDEFG', '2023-09-17 21:33:39', '4'),
('ABCDEFG', '2023-09-17 21:35:11', '4'),
('ABCDEFG', '2023-09-17 21:35:29', '4'),
('ABCDEFG', '2023-09-17 21:44:21', '4'),
('ABCDEFG', '2023-09-17 21:45:17', '4'),
('ABCDEFG', '2023-09-17 21:45:22', '4'),
('ABCDEFG', '2023-09-17 21:45:28', '4'),
('ABCDEFG', '2023-09-17 21:45:42', '4');

-- --------------------------------------------------------

--
-- Table structure for table `hr_record`
--

CREATE TABLE `hr_record` (
  `user_id` varchar(20) NOT NULL,
  `hr_rate` int(11) NOT NULL,
  `timestamp` datetime NOT NULL,
  `location_id` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hr_record`
--

INSERT INTO `hr_record` (`user_id`, `hr_rate`, `timestamp`, `location_id`) VALUES
('ABCDEFG', 240, '2023-09-16 04:50:04', '2');

-- --------------------------------------------------------

--
-- Table structure for table `hr_status`
--

CREATE TABLE `hr_status` (
  `user_id` varchar(20) NOT NULL,
  `hr_data` text NOT NULL,
  `valid_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hr_status`
--

INSERT INTO `hr_status` (`user_id`, `hr_data`, `valid_date`) VALUES
('HIJKLMNOP', '[10,10,10,10,10,10,10,10,10,10]', '2023-09-17 11:09:45'),
('ABCDEFG', '[\"223\",\"200\",\"200\",\"200\",\"120\",\"120\",\"120\",\"100\",\"100\",\"100\"]', '2023-09-17 23:04:22'),
('QRSTUV', '[\"100\",\"100\",\"100\",\"100\",\"100\",\"100\",\"100\",\"100\",\"100\",\"100\"]', '2023-09-17 23:03:06');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `location_id` int(11) NOT NULL,
  `location_side` varchar(20) NOT NULL,
  `location_front` varchar(20) NOT NULL,
  `location_name` text NOT NULL,
  `camera_ip` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`location_id`, `location_side`, `location_front`, `location_name`, `camera_ip`) VALUES
(1, '90AE1792', '10', 'Room 1', '0.0.0.0'),
(2, 'F946B72', '100', 'Room 2', '0.0.0.0'),
(3, '143F8F12', '1000', 'Room 3', '192.168.0.21'),
(4, 'XXX', 'XXX', 'Null location', '0.0.0.0');

-- --------------------------------------------------------

--
-- Table structure for table `panic`
--

CREATE TABLE `panic` (
  `panic_id` int(11) NOT NULL,
  `panic_desc` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `panic`
--

INSERT INTO `panic` (`panic_id`, `panic_desc`) VALUES
(0, 'Feeling Normal'),
(1, 'Feeling Unwell '),
(2, 'Chest Pain'),
(3, 'Toilet'),
(4, 'Thirsty/Hungry'),
(5, 'Feeling Lonely');

-- --------------------------------------------------------

--
-- Table structure for table `panic_record`
--

CREATE TABLE `panic_record` (
  `panic_id` int(11) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `panic_record`
--

INSERT INTO `panic_record` (`panic_id`, `user_id`, `date`) VALUES
(0, '0', '2023-09-17 18:44:26'),
(0, '0', '2023-09-17 18:44:29'),
(0, '0', '2023-09-17 18:44:29'),
(0, '0', '2023-09-17 18:44:30'),
(0, '0', '2023-09-17 18:44:31'),
(0, '0', '2023-09-17 18:44:32'),
(0, '0', '2023-09-17 18:44:34'),
(0, '0', '2023-09-17 18:44:42'),
(0, '0', '2023-09-17 18:44:43'),
(0, '0', '2023-09-17 18:44:47'),
(0, '0', '2023-09-17 18:44:48'),
(0, '0', '2023-09-17 18:44:50'),
(0, '0', '2023-09-17 18:45:01'),
(0, '0', '2023-09-17 18:45:05'),
(0, '0', '2023-09-17 18:45:06'),
(0, '0', '2023-09-17 18:45:07'),
(0, '0', '2023-09-17 18:45:08'),
(0, '0', '2023-09-17 18:45:09'),
(0, '0', '2023-09-17 18:45:09'),
(0, '0', '2023-09-17 18:45:13'),
(0, '0', '2023-09-17 18:45:13'),
(0, '0', '2023-09-17 18:45:16'),
(0, '0', '2023-09-17 18:45:17'),
(0, '0', '2023-09-17 18:45:17'),
(0, '0', '2023-09-17 18:45:18'),
(0, '0', '2023-09-17 18:45:19'),
(0, '0', '2023-09-17 18:45:20'),
(0, '0', '2023-09-17 18:45:24'),
(0, '0', '2023-09-17 18:45:25'),
(0, '0', '2023-09-17 18:45:26'),
(0, '0', '2023-09-17 18:45:27'),
(0, '0', '2023-09-17 18:45:28'),
(0, '0', '2023-09-17 18:46:53'),
(0, '0', '2023-09-17 18:47:16'),
(0, '0', '2023-09-17 18:47:16'),
(0, '0', '2023-09-17 21:06:19'),
(0, '0', '2023-09-17 21:06:20'),
(0, '0', '2023-09-17 21:06:22'),
(0, '0', '2023-09-17 21:07:24'),
(0, '0', '2023-09-17 21:07:26'),
(0, '0', '2023-09-17 21:07:32'),
(0, '0', '2023-09-17 21:07:35'),
(0, '0', '2023-09-17 21:07:38'),
(0, '0', '2023-09-17 21:07:41'),
(0, '0', '2023-09-17 21:07:44'),
(0, '0', '2023-09-17 21:07:46'),
(0, '0', '2023-09-17 21:24:41'),
(0, '0', '2023-09-17 21:24:41'),
(0, '0', '2023-09-17 21:24:43'),
(0, '0', '2023-09-17 21:24:43'),
(0, '0', '2023-09-17 21:24:44'),
(0, '0', '2023-09-17 21:24:47'),
(0, '0', '2023-09-17 21:24:54'),
(0, '0', '2023-09-17 21:24:55'),
(0, '0', '2023-09-17 21:24:56'),
(0, '0', '2023-09-17 21:24:56'),
(0, '0', '2023-09-17 21:34:41'),
(0, '0', '2023-09-17 21:34:43'),
(0, '0', '2023-09-17 21:34:52'),
(0, '0', '2023-09-17 21:34:54'),
(0, '0', '2023-09-17 21:35:00'),
(0, '0', '2023-09-17 21:44:48'),
(0, '0', '2023-09-17 21:44:50'),
(0, '0', '2023-09-17 21:44:55'),
(0, '0', '2023-09-17 21:44:59');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` varchar(20) NOT NULL,
  `location_id` int(11) NOT NULL,
  `fall_status` tinyint(1) NOT NULL,
  `panic_status` tinyint(1) NOT NULL,
  `panic_id` int(11) NOT NULL,
  `user_name` text NOT NULL,
  `user_ic` varchar(12) NOT NULL,
  `online_status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `location_id`, `fall_status`, `panic_status`, `panic_id`, `user_name`, `user_ic`, `online_status`) VALUES
('HIJKLMNOP', 2, 0, 1, 1, 'Tim', '111111010001', 0),
('ABCDEFG', 2, 1, 0, 0, 'Peter', '121212010001', 1),
('QRSTUV', 3, 0, 0, 0, 'Benedict', '140407020068', 1);

-- --------------------------------------------------------

--
-- Table structure for table `walk_record`
--

CREATE TABLE `walk_record` (
  `user_id` varchar(20) NOT NULL,
  `steps` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `walk_record`
--

INSERT INTO `walk_record` (`user_id`, `steps`, `date`) VALUES
('ABCDEFG', 58, '2023-09-17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`location_id`);

--
-- Indexes for table `panic`
--
ALTER TABLE `panic`
  ADD PRIMARY KEY (`panic_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_ic`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `location_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
