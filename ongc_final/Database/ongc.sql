-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 15, 2022 at 06:48 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ongc`
--

-- --------------------------------------------------------

--
-- Table structure for table `ongc_admin`
--

CREATE TABLE `ongc_admin` (
  `admin_id` varchar(10) NOT NULL,
  `name` text NOT NULL,
  `admin_cpf` varchar(8) NOT NULL,
  `email` varchar(200) NOT NULL,
  `otp` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ongc_admin`
--

INSERT INTO `ongc_admin` (`admin_id`, `name`, `admin_cpf`, `email`, `otp`) VALUES
('1A8H9W4B2M', 'Amit Kumar', '1U8X3M2P', 'akak61999@gmail.com', '');

-- --------------------------------------------------------

--
-- Table structure for table `ongc_flagged_posts`
--

CREATE TABLE `ongc_flagged_posts` (
  `flagged_id` int(11) NOT NULL,
  `post_id` varchar(8) NOT NULL,
  `user_id` int(6) NOT NULL,
  `posting_time` datetime NOT NULL,
  `mod_id` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ongc_moderators`
--

CREATE TABLE `ongc_moderators` (
  `mod_id` int(11) NOT NULL,
  `user_id` int(8) NOT NULL,
  `mod_status` text NOT NULL,
  `otp` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `registered_employee`
--

CREATE TABLE `registered_employee` (
  `cpf` varchar(8) NOT NULL,
  `user_id` mediumint(6) NOT NULL,
  `name` tinytext NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `status` tinytext NOT NULL,
  `otp` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `registered_employee`
--

INSERT INTO `registered_employee` (`cpf`, `user_id`, `name`, `email`, `mobile`, `status`, `otp`) VALUES
('1U8X3M2P', 551451, 'Amit Kumar', '', '', '', ''),
('2Y8J4C9B', 397957, 'Riya Jain', '', '', '', ''),
('4H6K3O3V', 967172, 'Sumit Mishra', '', '', '', ''),
('5N8S6N4D', 798527, 'Komal Sharma', '', '', '', ''),
('6U9G3M4P', 883445, 'Raj Kumar', '', '', '', ''),
('7C3H0Z1H', 394862, 'Anmol Minj', '', '', '', ''),
('8N3M9X9S', 684927, 'Pankaj Kumar', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_bio`
--

CREATE TABLE `user_bio` (
  `user_id` varchar(11) NOT NULL,
  `pro_pic` varchar(500) NOT NULL,
  `bio` text NOT NULL,
  `current_designation` tinytext NOT NULL,
  `date_of_birth` date NOT NULL,
  `marriage_anniversary` date NOT NULL,
  `intrests` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user_comments`
--

CREATE TABLE `user_comments` (
  `comment_id` int(11) NOT NULL,
  `post_id` varchar(8) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` mediumtext NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_likes`
--

CREATE TABLE `user_likes` (
  `like_id` int(11) NOT NULL,
  `post_id` varchar(7) NOT NULL,
  `user_id` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_posts_backup`
--

CREATE TABLE `user_posts_backup` (
  `backup_id` varchar(6) NOT NULL,
  `post_id` varchar(6) NOT NULL,
  `user_id` mediumint(6) NOT NULL,
  `posting_time` datetime NOT NULL,
  `post_type` varchar(25) NOT NULL,
  `text` mediumtext NOT NULL,
  `image` varchar(400) NOT NULL,
  `video` varchar(400) NOT NULL,
  `external_url` varchar(1500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_posts_main`
--

CREATE TABLE `user_posts_main` (
  `post_id` varchar(6) NOT NULL,
  `user_id` mediumint(6) NOT NULL,
  `posting_time` datetime NOT NULL,
  `post_type` varchar(25) NOT NULL,
  `text` mediumtext NOT NULL,
  `image` varchar(400) NOT NULL,
  `video` varchar(400) NOT NULL,
  `external_url` varchar(1500) NOT NULL,
  `views` int(11) NOT NULL,
  `status` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ongc_admin`
--
ALTER TABLE `ongc_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `ongc_flagged_posts`
--
ALTER TABLE `ongc_flagged_posts`
  ADD PRIMARY KEY (`flagged_id`);

--
-- Indexes for table `ongc_moderators`
--
ALTER TABLE `ongc_moderators`
  ADD PRIMARY KEY (`mod_id`);

--
-- Indexes for table `registered_employee`
--
ALTER TABLE `registered_employee`
  ADD PRIMARY KEY (`cpf`);

--
-- Indexes for table `user_bio`
--
ALTER TABLE `user_bio`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_comments`
--
ALTER TABLE `user_comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `user_likes`
--
ALTER TABLE `user_likes`
  ADD PRIMARY KEY (`like_id`);

--
-- Indexes for table `user_posts_backup`
--
ALTER TABLE `user_posts_backup`
  ADD PRIMARY KEY (`backup_id`);

--
-- Indexes for table `user_posts_main`
--
ALTER TABLE `user_posts_main`
  ADD PRIMARY KEY (`post_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ongc_flagged_posts`
--
ALTER TABLE `ongc_flagged_posts`
  MODIFY `flagged_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ongc_moderators`
--
ALTER TABLE `ongc_moderators`
  MODIFY `mod_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_comments`
--
ALTER TABLE `user_comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_likes`
--
ALTER TABLE `user_likes`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
