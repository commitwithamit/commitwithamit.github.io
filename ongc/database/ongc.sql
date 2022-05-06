-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 06, 2022 at 06:12 AM
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
  `otp` varchar(6) NOT NULL,
  `password` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ongc_admin`
--

INSERT INTO `ongc_admin` (`admin_id`, `name`, `admin_cpf`, `email`, `otp`, `password`) VALUES
('1A8H9W4B2M', 'Amit Kumar', '1U8X3M2P', 'akak61999@gmail.com', '', 'c6001d5b2ac3df314204a8f9d7a00e1503c9aba0fd4538645de4bf4cc7e2555cfe9ff9d0236bf327ed3e907849a98df4d330c4bea551017d465b4c1d9b80bcb0');

-- --------------------------------------------------------

--
-- Table structure for table `ongc_flagged_posts`
--

CREATE TABLE `ongc_flagged_posts` (
  `flagged_id` int(11) NOT NULL,
  `post_id` varchar(8) NOT NULL,
  `user_id` int(6) NOT NULL,
  `posting_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ongc_moderators`
--

CREATE TABLE `ongc_moderators` (
  `mod_id` int(11) NOT NULL,
  `user_id` int(8) NOT NULL
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
  `otp` varchar(6) NOT NULL,
  `dark_mode` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `registered_employee`
--

INSERT INTO `registered_employee` (`cpf`, `user_id`, `name`, `email`, `mobile`, `status`, `otp`, `dark_mode`) VALUES
('1U8X3M2P', 551451, 'Amit Kumar', 'akak61999@gmail.com', '8770211802', 'active', '', ''),
('2Y8J4C9B', 397957, 'Riya Jain', 'riya123@gmail.com', '8770488324', 'active', '', ''),
('4H6K3O3V', 967172, 'Sumit Mishra', '', '8989764300', 'pending', '', ''),
('5N8S6N4D', 798527, 'Komal Sharma', '', '8956236598', 'pending', '', ''),
('7C3H0Z1H', 394862, 'Anmol Minj', 'anmol99minj@gmail.com', '9696458500', 'pending', '', ''),
('8N3M9X9S', 684927, 'Pankaj Kumar', 'pankaj454@gmail.com', '', 'pending', '', '');

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

--
-- Dumping data for table `user_bio`
--

INSERT INTO `user_bio` (`user_id`, `pro_pic`, `bio`, `current_designation`, `date_of_birth`, `marriage_anniversary`, `intrests`) VALUES
('397957', 'user-images/5Q8X2A4T7Y.jpeg', 'Our greatest glory is not in never falling, but in rising every time we fall.', 'Chief Superitendent', '1992-12-15', '0000-00-00', 'Football, Badminton, Singing and Dancing'),
('551451', 'user-images/9T7K0P2N1X.jpeg', 'â€œFor everything that is really great and inspiring is created by the individual who can labour in freedom.â€', 'HR', '1992-02-11', '0000-00-00', '');

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

--
-- Dumping data for table `user_comments`
--

INSERT INTO `user_comments` (`comment_id`, `post_id`, `user_id`, `comment`, `time`) VALUES
(1, '1R2M4B', 551451, 'hello nice pic', '2018-09-05 18:30:00'),
(2, '1R2M4B', 397957, 'jai ho india', '2022-04-05 10:06:43'),
(28, '2C4X7W', 551451, 'nice moon of my life', '2022-04-05 18:33:20'),
(34, '2C4X7W', 551451, 'Talking to the moon :)', '2022-04-06 11:42:15'),
(38, '0B3B8K', 551451, 'nice pic', '2022-04-06 11:53:29'),
(53, '3Q0R2X', 397957, 'The Amar Jawan Jyoti, which had been burning for more than five decades to honour the martyrs of the armed forces, was merged with newly built National War Memorial.', '2022-04-09 18:12:38'),
(59, '2C4X7W', 397957, 'This is the best moon i\'ve ever seen, keep clicking such pictures buddy.', '2022-04-09 18:28:43'),
(95, '3Q0R2X', 551451, '\"World\'s best monument\"', '2022-04-10 11:06:37');

-- --------------------------------------------------------

--
-- Table structure for table `user_likes`
--

CREATE TABLE `user_likes` (
  `like_id` int(11) NOT NULL,
  `post_id` varchar(7) NOT NULL,
  `user_id` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_likes`
--

INSERT INTO `user_likes` (`like_id`, `post_id`, `user_id`) VALUES
(62, '2C4X7W', '397957'),
(64, '0B3B8K', '397957'),
(65, '0B3B8K', '798527'),
(81, '3Q0R2X', '551451'),
(82, '3Q0R2X', '397957'),
(83, '7C8S0Y', '551451'),
(84, '1V9Y5J', '397957'),
(85, '9I0O2G', '551451');

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

--
-- Dumping data for table `user_posts_backup`
--

INSERT INTO `user_posts_backup` (`backup_id`, `post_id`, `user_id`, `posting_time`, `post_type`, `text`, `image`, `video`, `external_url`) VALUES
('0J8K4A', '1X1N2R', 551451, '2022-04-06 18:30:41', 'image', '', 'user-images/1O6Y5Z7F9A.jpg', '', ''),
('0L5L2U', '8Y1O4Q', 551451, '2022-04-06 18:32:57', 'text/image', 'desert', 'user-images/2X9C8P1H6F.jpg', '', ''),
('0T5T7L', '6E1S7X', 551451, '2022-04-13 17:23:18', 'image', '', 'user-images/2E9P4I0P5B.jpg', '', ''),
('1U3S3J', '3Q0R2X', 551451, '2022-03-30 09:30:27', 'image', '', 'user-images/5K4L8E7T4W.png', '', ''),
('1U6L8L', '5S4K8K', 551451, '2022-04-13 20:47:35', 'image', '', 'user-images/9D9Z3K6H5S.png', '', ''),
('2B9T9O', '1C9I1V', 551451, '2022-04-07 20:35:20', 'image', '', 'user-images/5B2D0W4V0H.png', '', ''),
('2E1U7B', '0B3B8K', 551451, '2022-03-25 17:54:49', 'text/image', 'Working on new website', 'user-images/0Y6C5P5Y0F.png', '', ''),
('2E4S5Q', '7C8S0Y', 551451, '2022-04-13 17:01:30', 'image', '', 'user-images/0O1B7A8S7M.jpg', '', ''),
('2U2S0S', '1R2M4B', 551451, '2022-03-30 09:31:16', 'text', 'hello world and let\'s have fun!!', '', '', ''),
('3J4T5H', '9I0O2G', 397957, '2022-04-14 14:40:30', 'text', 'We\'re gone with the wind\r\nHair in your face\r\nPut my hands on your waist\r\nStrawberry skies, all on your lips\r\n\'Cause I love how it taste', '', '', ''),
('3R5V6F', '4E6B4L', 551451, '2022-04-17 12:45:56', 'text/image', 'landscape', 'user-images/7S3H6Y4C1K.jpg', '', ''),
('3S8X9H', '9X7O4N', 551451, '2022-04-13 17:05:19', 'image', '', 'user-images/4U5Q6A3T2E.jpg', '', ''),
('3Y6K8T', '2Y5Y8J', 551451, '2022-04-16 14:04:33', 'text/video', 'Banao banao powerbank with led lights!!!', '', 'user-images/6M1A1F2K4O.mp4', ''),
('4A0P3R', '0J0A7B', 551451, '2022-04-13 17:11:31', 'image', '', 'user-images/3I1H0Z3F3D.jpg', '', ''),
('4C1Z7G', '8Z9U1R', 551451, '2022-04-07 20:33:07', 'text/image', 'Ongc database!', 'user-images/8W1T3Z4Z9A.png', '', ''),
('4J1P1Y', '4S7V1F', 551451, '2022-04-07 20:21:10', 'text/image', 'database table', 'user-images/7A2L8R0B5Y.png', '', ''),
('4K3S8E', '5L4H2T', 551451, '2022-04-07 20:45:56', 'image', '', 'user-images/3K9W9Y9J0L.png', '', ''),
('4T6A0Y', '8O0N2U', 551451, '2022-04-15 17:39:25', 'text/image', 'hello my new airpods', 'user-images/9W2J2W7Y4C.jpg', '', ''),
('4U7P0Q', '9H6X9Y', 397957, '2022-04-10 22:27:18', 'text/image', 'Amitabh bachan', 'user-images/9E0C3G1R2Y.png', '', ''),
('4X4S5Z', '5V2G1Q', 551451, '2022-04-06 18:32:41', 'text/image', 'light houuse', 'user-images/5X1P6I1C5P.jpg', '', ''),
('5F8S2C', '3C7Z9C', 551451, '2022-04-17 12:43:16', 'text', 'this is nothing to post', '', '', ''),
('5N6I6U', '6K5L4F', 551451, '2022-04-06 18:30:50', 'image', '', 'user-images/2E4N3C4A2Q.jpg', '', ''),
('5N9B5I', '0B3B8K', 551451, '2022-03-13 00:05:29', 'image', '', 'user-images/0Y6C5P5Y0F.png', '', ''),
('5U2J7L', '3S6F7T', 551451, '2022-04-14 17:55:58', 'text/image', 'cabels!!', 'user-images/1B7X1D1I5S.jpg', '', ''),
('5Y9S7F', '7Q2U4I', 551451, '2022-04-13 20:46:48', 'image', '', 'user-images/6A7R2S6W0F.jpg', '', ''),
('6H6H8Q', '0B3B8K', 551451, '2022-03-25 17:48:13', 'image', '', 'user-images/0Y6C5P5Y0F.png', '', ''),
('6S8S9O', '6D8M4S', 551451, '2022-03-10 16:34:20', 'text/image', 'Lets chill for a moment!!', 'user-images/5Z7V8M8Q9L.jpeg', '', ''),
('6S9Z5I', '2C4X7W', 397957, '2022-03-14 13:09:04', 'text/image', 'Moon of my life <3', 'user-images/6N8Q5N2C8T.jpg', '', ''),
('7D5F1U', '3X3P2R', 551451, '2022-04-15 17:24:10', 'text/image', 'earphones', 'user-images/6K0Q2Y8M2I.jpg', '', ''),
('7E9H1I', '2C4X7W', 397957, '2022-04-09 23:43:58', 'text/image', 'Moon of my life', 'user-images/6N8Q5N2C8T.jpg', '', ''),
('7H9U2U', '0B3B8K', 551451, '2022-03-25 17:49:14', 'text/image', 'nothing ', 'user-images/0Y6C5P5Y0F.png', '', ''),
('7I3M5A', '8O2C2X', 397957, '2022-04-10 22:33:38', 'text/video', 'Upod tripod! @ Rs.799/-', '', 'user-images/6U3Y0X3M0O.mp4', ''),
('7T4X1Y', '1V9Y5J', 397957, '2022-04-14 14:14:27', 'text/image', 'how is this SVG!!', 'user-images/6I3A8U8T9Q.png', '', ''),
('7T5Q2D', '2G2D1N', 551451, '2022-04-06 18:25:18', 'image', '', 'user-images/9B6B4L6K6X.png', '', ''),
('8C0H0Y', '3Q0R2X', 551451, '2022-03-10 16:35:46', 'text/image', 'News time!!', 'user-images/5K4L8E7T4W.png', '', ''),
('8M9Y5B', '8O0N2U', 551451, '2022-04-15 17:39:06', 'image', '', 'user-images/9W2J2W7Y4C.jpg', '', ''),
('8N6W1Z', '4K9J8V', 551451, '2022-04-07 20:45:22', 'image', '', 'user-images/0K7B6G6V7Y.png', '', ''),
('8R8G0W', '3Z8X4Y', 551451, '2022-04-06 21:55:38', 'text/image', 'penguin', 'user-images/4V5R2F8W2R.jpg', '', ''),
('8S5U2A', '3Q0R2X', 551451, '2022-03-30 09:30:39', 'text/image', '', 'user-images/5K4L8E7T4W.png', '', ''),
('9C5H7F', '3Q3L1R', 551451, '2022-04-14 23:22:02', 'text/image', 'landscape\r\n', 'user-images/2C2E8Y8H4Q.jpg', '', ''),
('9E9I1L', '4M4U6M', 551451, '2022-04-06 18:26:14', 'image', '', 'user-images/3F8Y0U5D6A.jpg', '', ''),
('9F9P9L', '1R2M4B', 551451, '2022-03-30 09:41:23', 'text', 'hello how are you guys?', '', '', ''),
('9T8P7F', '8O2C2X', 397957, '2022-04-10 22:23:48', 'text/video', 'Upod tripod!', '', 'user-images/6U3Y0X3M0O.mp4', '');

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
-- Dumping data for table `user_posts_main`
--

INSERT INTO `user_posts_main` (`post_id`, `user_id`, `posting_time`, `post_type`, `text`, `image`, `video`, `external_url`, `views`, `status`) VALUES
('0B3B8K', 551451, '2022-03-13 00:05:29', 'text/image', 'Working on new website', 'user-images/0Y6C5P5Y0F.png', '', '', 0, ''),
('2C4X7W', 397957, '2022-03-14 13:09:04', 'text/image', 'Moon of my life', 'user-images/6N8Q5N2C8T.jpg', '', '', 0, ''),
('3Q0R2X', 551451, '2022-03-10 16:35:46', 'text/image', '', 'user-images/5K4L8E7T4W.png', '', '', 0, ''),
('9I0O2G', 397957, '2022-04-14 14:40:30', 'text', 'We\'re gone with the wind\r\nHair in your face\r\nPut my hands on your waist\r\nStrawberry skies, all on your lips\r\n\'Cause I love how it taste', '', '', '', 0, '');

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
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `user_likes`
--
ALTER TABLE `user_likes`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
