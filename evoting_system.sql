-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 24, 2020 at 07:57 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `evoting_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `candidate`
--

CREATE TABLE `candidate` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `symbol` varchar(100) NOT NULL,
  `category_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `candidate`
--

INSERT INTO `candidate` (`id`, `full_name`, `photo`, `symbol`, `category_id`, `timestamp`) VALUES
(25, 'Akshant', '13.jpg', '13.png', 30, '2020-09-24 17:47:17'),
(26, 'Dhruv', '01.jpg', '01.png', 30, '2020-09-24 17:47:52'),
(27, 'Mishika', '11.jpg', '11.png', 30, '2020-09-24 17:48:38');

-- --------------------------------------------------------

--
-- Table structure for table `election_category`
--

CREATE TABLE `election_category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `max_voter` int(11) NOT NULL,
  `adult_voter` varchar(10) NOT NULL DEFAULT 'No',
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `expire_timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `vote_start_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `vote_end_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `election_category`
--

INSERT INTO `election_category` (`id`, `name`, `max_voter`, `adult_voter`, `timestamp`, `expire_timestamp`, `vote_start_time`, `vote_end_time`) VALUES
(30, 'TechComp Alumini Selection', 0, 'No', '2020-09-24 17:27:10', '2020-09-27 06:30:00', '2020-09-23 06:30:10', '2020-09-23 06:30:58'),
(31, 'College HOD Selection', 0, 'No', '2020-09-24 17:27:49', '2020-09-30 06:30:00', '2020-09-24 17:27:49', '2020-09-24 17:27:49'),
(32, 'CEO Selection for PiedPiper Project', 0, 'No', '2020-09-24 17:28:17', '2020-10-15 06:30:00', '2020-09-24 17:28:17', '2020-09-24 17:28:17');

-- --------------------------------------------------------

--
-- Table structure for table `request_to_register`
--

CREATE TABLE `request_to_register` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `election_category` varchar(100) NOT NULL,
  `max_voter` int(11) NOT NULL,
  `adult_voter` varchar(10) NOT NULL DEFAULT '''No''',
  `expire_timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `ac_status` varchar(10) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `request_to_register`
--

INSERT INTO `request_to_register` (`id`, `full_name`, `email`, `election_category`, `max_voter`, `adult_voter`, `expire_timestamp`, `timestamp`, `ac_status`) VALUES
(7, 'Sandeep', 'sandy@evoting.com', 'TechComp Alumini Selection', 40, 'Yes', '2020-09-27 06:30:00', '2020-09-24 17:26:04', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `system_users`
--

CREATE TABLE `system_users` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `date_of_birth` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL DEFAULT '12346578',
  `role` enum('admin','organiser','voter') NOT NULL DEFAULT 'voter',
  `election_category_id` int(11) NOT NULL,
  `voted` varchar(4) DEFAULT 'No',
  `created_timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `system_users`
--

INSERT INTO `system_users` (`user_id`, `full_name`, `email`, `date_of_birth`, `password`, `role`, `election_category_id`, `voted`, `created_timestamp`) VALUES
(1, 'Admin', 'admin@evoting.com', NULL, '7c222fb2927d828af22f592134e8932480637c0d', 'admin', 0, NULL, '2020-03-17 10:47:13'),
(386550, 'Sudhan', 'sudhan@evoting.com', '30-05-1998', '7c222fb2927d828af22f592134e8932480637c0d', 'voter', 30, 'No', '2020-09-24 17:48:55'),
(386543, 'Sandeep', 'sandy@evoting.com', NULL, '7c222fb2927d828af22f592134e8932480637c0d', 'organiser', 30, 'No', '2020-09-24 17:27:10'),
(386544, 'Ivaan', 'ivaan@evoting.com', NULL, '7c222fb2927d828af22f592134e8932480637c0d', 'organiser', 31, 'No', '2020-09-24 17:28:56'),
(386545, 'Vivaan', 'vivaan@evoting.com', NULL, '7c222fb2927d828af22f592134e8932480637c0d', 'organiser', 32, 'No', '2020-09-24 17:29:16'),
(386546, 'Anaya', 'anaya@evoting.com', NULL, '7c222fb2927d828af22f592134e8932480637c0d', 'organiser', 32, 'No', '2020-09-24 17:30:35'),
(386547, '?John', 'john@evoting.com', '20-10-1999', '7c222fb2927d828af22f592134e8932480637c0d', 'voter', 30, 'Yes', '2020-09-24 17:48:55'),
(386548, 'Thomas', 'thomas@evoting.com', '15-02-1998', '7c222fb2927d828af22f592134e8932480637c0d', 'voter', 30, 'No', '2020-09-24 17:48:55'),
(386549, 'Robin', 'robin@evoting.com', '12-01-1999', '7c222fb2927d828af22f592134e8932480637c0d', 'voter', 30, 'No', '2020-09-24 17:48:55');

-- --------------------------------------------------------

--
-- Table structure for table `vote_details`
--

CREATE TABLE `vote_details` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `candidate_id` int(11) NOT NULL,
  `vote` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vote_details`
--

INSERT INTO `vote_details` (`id`, `category_id`, `candidate_id`, `vote`) VALUES
(9, 30, 25, 0),
(10, 30, 26, 1),
(11, 30, 27, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `candidate`
--
ALTER TABLE `candidate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `election_category`
--
ALTER TABLE `election_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `request_to_register`
--
ALTER TABLE `request_to_register`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_users`
--
ALTER TABLE `system_users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `vote_details`
--
ALTER TABLE `vote_details`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `candidate`
--
ALTER TABLE `candidate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `election_category`
--
ALTER TABLE `election_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `request_to_register`
--
ALTER TABLE `request_to_register`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `system_users`
--
ALTER TABLE `system_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=386551;

--
-- AUTO_INCREMENT for table `vote_details`
--
ALTER TABLE `vote_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
