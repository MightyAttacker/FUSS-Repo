-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 12, 2025 at 10:25 AM
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
-- Database: `users`
--

-- --------------------------------------------------------

--
-- Table structure for table `mailbox`
--

DROP TABLE IF EXISTS `mailbox`;
CREATE TABLE `mailbox` (
  `id` int(45) NOT NULL,
  `Subject` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `sentby` varchar(60) NOT NULL,
  `sentto` varchar(60) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mailbox`
--

INSERT INTO `mailbox` (`id`, `Subject`, `message`, `sentby`, `sentto`, `created`) VALUES
(1, 'test', 'test', 'bob@flinders.edu.au', 'putl0014@flinders.edu.au', '2025-10-07 12:30:00'),
(2, 'Bob the tester', 'hello bob the tester', 'bob@flinders.edu.au', 'putl0014@flinders.edu.au', '2025-10-08 05:30:14'),
(3, 'Testing Time Zone', 'it is currently 2:09pm', 'putl0014@flinders.edu.au', 'bob@flinders.edu.au', '2025-10-08 14:09:30'),
(4, 'character limit', 'gfwhyuISKKKKKKKKKKKKKKKKKKKKKKKDHGAHSDFAHKGJFDSHKJFSHAGKJHGKJFSAHGSAFHGJASFHJGASFHGJFHJASGHGJSFAHGJFSAHGJSFAHGSAFGHJhjfjahkshjsfajhfsajhsafhjjfasjklfasjhlkfashjlfashjfashjfhsajhjfasjhkafsjhkfashjklfasljhlfasjlhafsjlhfasljhkafsljhkfashjlkhfjaslhjafshjklasf', 'putl0014@flinders.edu.au', 'bob@flinders.edu.au', '2025-10-08 14:17:27'),
(5, 'Hello', 'testing Message', 'putl0014@flinders.edu.au', 'bob@flinders.edu.au', '2025-10-08 14:28:04'),
(6, 'Hello', 'test 4', 'putl0014@flinders.edu.au', 'bob@flinders.edu.au', '2025-10-08 14:32:15'),
(7, 'test 1 2 3', 'test 1 2 3', 'putl0014@flinders.edu.au', 'test@flinders.edu.au', '2025-10-11 19:47:09'),
(14, 'test 1 2 3', 'test 1 2 3', 'putl0014@flinders.edu.au', 'test@flinders.edu.au', '2025-10-11 19:49:46'),
(15, 'Test #9', 'Mambo # 5', 'putl0014@flinders.edu.au', 'test@flinders.edu.au', '2025-10-11 19:50:08'),
(16, 'Request for chat', 'Hello, lorem ipsum blah blah', 'test1@flinders.edu.au', 'putl0014@flinders.edu.au', '2025-10-12 15:49:20'),
(17, 'Hello', 'Hello and Welcome to FUSS, can I help you with anything', 'test1@flinders.edu.au', 'putl0014@flinders.edu.au', '2025-10-12 15:49:53'),
(18, 'Help Im stuck', 'Help Im stuck in the database let me out', 'test1@flinders.edu.au', 'putl0014@flinders.edu.au', '2025-10-12 15:50:13'),
(19, 'JK Im okay', 'totally not a bot .exe', 'test1@flinders.edu.au', 'putl0014@flinders.edu.au', '2025-10-12 15:50:32'),
(20, 'Message #7', 'Test message number 7', 'test1@flinders.edu.au', 'putl0014@flinders.edu.au', '2025-10-12 15:51:15'),
(21, 'Test msg #8', 'god this is boring', 'test1@flinders.edu.au', 'putl0014@flinders.edu.au', '2025-10-12 15:51:33'),
(22, 'Test #10', 'god is it over for me?', 'test1@flinders.edu.au', 'putl0014@flinders.edu.au', '2025-10-12 15:51:47'),
(23, 'Hello have you heard the good word?', 'The bird is the word', 'test1@flinders.edu.au', 'putl0014@flinders.edu.au', '2025-10-12 15:52:04');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages` (
  `id` int(6) UNSIGNED NOT NULL,
  `message` varchar(255) NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `message`, `reg_date`) VALUES
(1, 'Connection and insert into db successful', '2025-10-03 04:21:27');

-- --------------------------------------------------------

--
-- Table structure for table `requestbox`
--

DROP TABLE IF EXISTS `requestbox`;
CREATE TABLE `requestbox` (
  `id` int(45) NOT NULL,
  `skillName` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `credits` int(5) NOT NULL,
  `requestee` varchar(60) NOT NULL,
  `requester` varchar(60) NOT NULL,
  `proposedDate` datetime NOT NULL,
  `created` datetime NOT NULL,
  `requesteeAgreed` tinyint(1) NOT NULL DEFAULT 0,
  `requesterAgreed` tinyint(1) NOT NULL DEFAULT 0,
  `requesterConfirmed` tinyint(1) NOT NULL DEFAULT 0,
  `requesteeConfirmed` tinyint(1) NOT NULL DEFAULT 0,
  `creditsReleased` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `requestbox`
--

INSERT INTO `requestbox` (`id`, `skillName`, `message`, `credits`, `requestee`, `requester`, `proposedDate`, `created`, `requesteeAgreed`, `requesterAgreed`, `requesterConfirmed`, `requesteeConfirmed`, `creditsReleased`) VALUES
(3, 'Jedi Mind Tricks', 'Help me I wish to learn the force', 1, '1', '7', '2026-05-04 17:37:00', '2025-10-12 17:37:44', 1, 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

DROP TABLE IF EXISTS `skills`;
CREATE TABLE `skills` (
  `skillName` varchar(60) NOT NULL,
  `academic` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`skillName`, `academic`) VALUES
('academicTest', 1),
('academicTest1', 1),
('academicTest2', 1),
('academicTest3', 1),
('academicTest4', 1),
('academicTest5', 1),
('academicTest6', 1),
('Basic C++ Programming', 1),
('Basic HTML', 1),
('Basic JavaScript', 1),
('Basic PHP', 1),
('Basic Report Writing', 1),
('Basic SQL', 1),
('Expert HTML', 1),
('Expert JavaScript', 1),
('Expert PHP', 1),
('Expert Report Writing', 1),
('Expert SQL', 1),
('House Moving', 0),
('How to Make Friendships', 0),
('Intermediate HTML', 1),
('Intermediate JavaScript', 1),
('Intermediate PHP', 1),
('Intermediate Report Writing', 1),
('Intermediate SQL', 1),
('Learning to Draw', 0),
('nonAcademicTest1', 0),
('nonAcademicTest2', 0),
('nonAcademicTest3', 0),
('nonAcademicTest4', 0),
('nonAcademicTest5', 0),
('nonAcademicTest6', 0),
('nonAcademicTest7', 0),
('nonAcademicTest8', 0),
('Sketching Profiles', 0);

-- --------------------------------------------------------

--
-- Table structure for table `userdata`
--

DROP TABLE IF EXISTS `userdata`;
CREATE TABLE `userdata` (
  `id` int(11) NOT NULL,
  `email` varchar(45) NOT NULL,
  `firstName` varchar(80) NOT NULL,
  `lastName` varchar(80) NOT NULL,
  `password` varchar(255) NOT NULL,
  `imageName` varchar(255) NOT NULL DEFAULT 'default-avatar.jpg',
  `imagePath` varchar(255) NOT NULL DEFAULT '../userProfilePictures/default-avatar.jpg',
  `academicYear` tinyint(3) NOT NULL DEFAULT 1,
  `credits` smallint(4) UNSIGNED NOT NULL,
  `college` varchar(60) NOT NULL,
  `bio` varchar(255) NOT NULL,
  `availability` varchar(255) DEFAULT NULL,
  `last_active` date DEFAULT NULL,
  `Suspended` tinyint(1) NOT NULL DEFAULT 0,
  `suspendedUntil` date DEFAULT NULL,
  `Deleted` tinyint(1) NOT NULL DEFAULT 0,
  `admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userdata`
--

INSERT INTO `userdata` (`id`, `email`, `firstName`, `lastName`, `password`, `imageName`, `imagePath`, `academicYear`, `credits`, `college`, `bio`, `availability`, `last_active`, `Suspended`, `suspendedUntil`, `Deleted`, `admin`) VALUES
(1, 'putl0014@flinders.edu.au', 'Jayden', 'Putland', '$2y$10$ds4ha4PtWZZZ2Xk9G.4pRuKwAcJSeKQczEOYZDqMIjimGrtasegtG', 'Screenshot 2024-11-10 131358.png', '../userProfilePictures/Screenshot 2024-11-10 131358.png', 1, 15, 'Information Science', 'Not an explodey', 'Wednesdays after 4pm', '2025-10-11', 0, NULL, 0, 1),
(2, 'bob@flinders.edu.au', 'Bob', 'Test', '$2y$10$FhUF0v/ZyEzPw6GLdOuwEONmeEuBpzZxrFQ8VqGk6JJuytP.G.RQ6', 'default-avatar.jpg', '../userProfilePictures/default-avatar.jpg', 0, 1, '', '', NULL, NULL, 0, NULL, 0, 1),
(3, 'test@flinders.edu.au', 'First', 'Last', '$2y$10$mmiNWdOSqK0HWZaRtcNHe.yjyoB3khBe.Ickx8DG3Rs4mrYIwj1r6', 'Screenshot 2024-11-17 144136.png', '../userProfilePictures/Screenshot 2024-11-17 144136.png', 0, 1, '', '', 'Monday All Day, Tuesday after 11am, Friday Before 3pm', NULL, 1, '2025-10-11', 0, 0),
(4, 'klen0010@flinders.edu.au', 'Lachlan', 'Lachlans Last Name ', '$2y$10$ds4ha4PtWZZZ2Xk9G.4pRuKwAcJSeKQczEOYZDqMIjimGrtasegtG', 'default-avatar.jpg', '../userProfilePictures/default-avatar.jpg', 0, 1, '', '', NULL, '0000-00-00', 0, NULL, 0, 1),
(5, 'wach0035@flinders.edu.au', 'Thomas', 'Thomas Last Name ', '$2y$10$ds4ha4PtWZZZ2Xk9G.4pRuKwAcJSeKQczEOYZDqMIjimGrtasegtG', 'default-avatar.jpg', '../userProfilePictures/default-avatar.jpg', 0, 1, '', '', NULL, '0000-00-00', 0, NULL, 0, 1),
(6, 'mane0039@flinders.edu.au', 'Liam', 'Liams Last Name ', '$2y$10$ds4ha4PtWZZZ2Xk9G.4pRuKwAcJSeKQczEOYZDqMIjimGrtasegtG', 'default-avatar.jpg', '../userProfilePictures/default-avatar.jpg', 0, 1, '', '', NULL, '0000-00-00', 0, NULL, 0, 1),
(7, 'test1@flinders.edu.au', 'First', 'First', '$2y$10$gtZWRpAnqTP.rULVLI8UDupGWZv4HENHSJmWhX7.2u.eKJxvhPJLy', 'default-avatar.jpg', '../userProfilePictures/default-avatar.jpg', 1, 1, '', '', NULL, NULL, 0, NULL, 0, 0),
(8, 'firstfirster@flinders.edu.au', 'First', 'Firster', '$2y$10$FA.sjxbbbKVRlFLX783YXezY/lM7QIA3bGcsj.6ZG6/fs69Be91i2', 'default-avatar.jpg', '../userProfilePictures/default-avatar.jpg', 1, 1, '', '', NULL, NULL, 0, NULL, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `userrequestedskills`
--

DROP TABLE IF EXISTS `userrequestedskills`;
CREATE TABLE `userrequestedskills` (
  `id` int(11) NOT NULL,
  `skillName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userrequestedskills`
--

INSERT INTO `userrequestedskills` (`id`, `skillName`) VALUES
(1, 'House Moving'),
(1, 'nonAcademicTest8');

-- --------------------------------------------------------

--
-- Table structure for table `userrequests`
--

DROP TABLE IF EXISTS `userrequests`;
CREATE TABLE `userrequests` (
  `request_ID` int(10) NOT NULL,
  `userID` tinyint(10) NOT NULL,
  `Request` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `userskills`
--

DROP TABLE IF EXISTS `userskills`;
CREATE TABLE `userskills` (
  `id` int(11) NOT NULL,
  `skillName` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userskills`
--

INSERT INTO `userskills` (`id`, `skillName`) VALUES
(1, 'academicTest'),
(1, 'academicTest1'),
(1, 'academicTest2'),
(1, 'Basic C++ Programming'),
(1, 'House Moving'),
(1, 'nonAcademicTest1'),
(1, 'nonAcademicTest5'),
(2, 'academicTest4'),
(2, 'academicTest5'),
(2, 'House Moving'),
(2, 'nonAcademicTest5'),
(3, 'Basic HTML'),
(3, 'Basic JavaScript'),
(3, 'Basic Report Writing'),
(3, 'Expert HTML'),
(3, 'Expert JavaScript'),
(3, 'Expert Report Writing'),
(3, 'Intermediate HTML'),
(3, 'Intermediate JavaScript'),
(3, 'Intermediate Report Writing');

-- --------------------------------------------------------

--
-- Table structure for table `user_mailbox`
--

DROP TABLE IF EXISTS `user_mailbox`;
CREATE TABLE `user_mailbox` (
  `id` int(45) NOT NULL,
  `user` varchar(45) NOT NULL,
  `mailbox` varchar(45) NOT NULL,
  `mailbox_id` int(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_mailbox`
--

INSERT INTO `user_mailbox` (`id`, `user`, `mailbox`, `mailbox_id`) VALUES
(1, 'bob@flinders.edu.au', 'Out', 1),
(2, 'putl0014@flinders.edu.au', 'In', 1),
(3, 'putl0014@flinders.edu.au', 'In', 2),
(4, 'bob@flinders.edu.au', 'Out', 2),
(5, 'bob@flinders.edu.au', 'In', 3),
(6, 'putl0014@flinders.edu.au', 'Out', 3),
(7, 'bob@flinders.edu.au', 'In', 4),
(8, 'putl0014@flinders.edu.au', 'Out', 4),
(9, 'bob@flinders.edu.au', 'In', 5),
(10, 'putl0014@flinders.edu.au', 'Out', 5),
(11, 'bob@flinders.edu.au', 'In', 6),
(12, 'putl0014@flinders.edu.au', 'Out', 6),
(14, 'test@flinders.edu.au', 'In', 14),
(15, 'putl0014@flinders.edu.au', 'Out', 14),
(16, 'test@flinders.edu.au', 'In', 15),
(17, 'putl0014@flinders.edu.au', 'Out', 15),
(18, 'putl0014@flinders.edu.au', 'In', 16),
(19, 'test1@flinders.edu.au', 'Out', 16),
(20, 'putl0014@flinders.edu.au', 'In', 17),
(21, 'test1@flinders.edu.au', 'Out', 17),
(22, 'putl0014@flinders.edu.au', 'In', 18),
(23, 'test1@flinders.edu.au', 'Out', 18),
(24, 'putl0014@flinders.edu.au', 'In', 19),
(25, 'test1@flinders.edu.au', 'Out', 19),
(26, 'putl0014@flinders.edu.au', 'In', 20),
(27, 'test1@flinders.edu.au', 'Out', 20),
(28, 'putl0014@flinders.edu.au', 'In', 21),
(29, 'test1@flinders.edu.au', 'Out', 21),
(30, 'putl0014@flinders.edu.au', 'In', 22),
(31, 'test1@flinders.edu.au', 'Out', 22),
(32, 'putl0014@flinders.edu.au', 'In', 23),
(33, 'test1@flinders.edu.au', 'Out', 23);

-- --------------------------------------------------------

--
-- Table structure for table `user_requestbox`
--

DROP TABLE IF EXISTS `user_requestbox`;
CREATE TABLE `user_requestbox` (
  `id` int(45) NOT NULL,
  `user` varchar(45) NOT NULL,
  `requestboxType` varchar(45) NOT NULL,
  `requestBox_id` int(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_requestbox`
--

INSERT INTO `user_requestbox` (`id`, `user`, `requestboxType`, `requestBox_id`) VALUES
(2, '7', 'In', 2),
(3, '7', 'Out', 2),
(4, '1', 'In', 3),
(5, '7', 'Out', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mailbox`
--
ALTER TABLE `mailbox`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `requestbox`
--
ALTER TABLE `requestbox`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`skillName`);

--
-- Indexes for table `userdata`
--
ALTER TABLE `userdata`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Indexes for table `userrequestedskills`
--
ALTER TABLE `userrequestedskills`
  ADD PRIMARY KEY (`id`,`skillName`);

--
-- Indexes for table `userrequests`
--
ALTER TABLE `userrequests`
  ADD PRIMARY KEY (`request_ID`);

--
-- Indexes for table `userskills`
--
ALTER TABLE `userskills`
  ADD PRIMARY KEY (`id`,`skillName`);

--
-- Indexes for table `user_mailbox`
--
ALTER TABLE `user_mailbox`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_requestbox`
--
ALTER TABLE `user_requestbox`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mailbox`
--
ALTER TABLE `mailbox`
  MODIFY `id` int(45) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `requestbox`
--
ALTER TABLE `requestbox`
  MODIFY `id` int(45) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `userdata`
--
ALTER TABLE `userdata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `userrequests`
--
ALTER TABLE `userrequests`
  MODIFY `request_ID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_mailbox`
--
ALTER TABLE `user_mailbox`
  MODIFY `id` int(45) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `user_requestbox`
--
ALTER TABLE `user_requestbox`
  MODIFY `id` int(45) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `userskills`
--
ALTER TABLE `userskills`
  ADD CONSTRAINT `userskills_ibfk_1` FOREIGN KEY (`id`) REFERENCES `userdata` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_mailbox`
--
ALTER TABLE `user_mailbox`
  ADD CONSTRAINT `Message ID` FOREIGN KEY (`mailbox_id`) REFERENCES `mailbox` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
