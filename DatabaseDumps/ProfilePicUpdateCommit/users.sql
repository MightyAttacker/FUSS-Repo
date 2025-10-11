-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 11, 2025 at 02:58 AM
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
(6, 'Hello', 'test 4', 'putl0014@flinders.edu.au', 'bob@flinders.edu.au', '2025-10-08 14:32:15');

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
('House Moving', 0),
('nonAcademicTest1', 0),
('nonAcademicTest2', 0),
('nonAcademicTest3', 0),
('nonAcademicTest4', 0),
('nonAcademicTest5', 0),
('nonAcademicTest6', 0),
('nonAcademicTest7', 0),
('nonAcademicTest8', 0);

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
  `last_active` date DEFAULT NULL,
  `admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userdata`
--

INSERT INTO `userdata` (`id`, `email`, `firstName`, `lastName`, `password`, `imageName`, `imagePath`, `academicYear`, `credits`, `college`, `bio`, `last_active`, `admin`) VALUES
(1, 'putl0014@flinders.edu.au', 'Jayden', 'Putland', '$2y$10$ds4ha4PtWZZZ2Xk9G.4pRuKwAcJSeKQczEOYZDqMIjimGrtasegtG', 'Daschund stock.jpg', '../userProfilePictures/Daschund stock.jpg', 1, 10, 'Information Science', 'Not an explodey', '2025-10-09', 1),
(2, 'bob@flinders.edu.au', 'Bob', 'Test', '$2y$10$FhUF0v/ZyEzPw6GLdOuwEONmeEuBpzZxrFQ8VqGk6JJuytP.G.RQ6', 'default-avatar.jpg', '../userProfilePictures/default-avatar.jpg', 0, 0, '', '', NULL, 1),
(3, 'test@flinders.edu.au', 'First', 'Last', '$2y$10$mmiNWdOSqK0HWZaRtcNHe.yjyoB3khBe.Ickx8DG3Rs4mrYIwj1r6', 'default-avatar.jpg', '../userProfilePictures/default-avatar.jpg\r\n', 0, 0, '', '', NULL, 0);

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
(1, 'Intermediate C++ Programming');

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
(1, 'academicTest5'),
(1, 'Basic C++ Programming'),
(1, 'nonAcademicTest1'),
(1, 'nonAcademicTest2'),
(1, 'nonAcademicTest3'),
(1, 'nonAcademicTest4'),
(1, 'nonAcademicTest5'),
(1, 'nonAcademicTest6'),
(1, 'nonAcademicTest7');

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
(12, 'putl0014@flinders.edu.au', 'Out', 6);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
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
-- Indexes for table `userskills`
--
ALTER TABLE `userskills`
  ADD PRIMARY KEY (`id`,`skillName`);

--
-- Indexes for table `user_mailbox`
--
ALTER TABLE `user_mailbox`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `Message ID` (`mailbox_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `userdata`
--
ALTER TABLE `userdata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_mailbox`
--
ALTER TABLE `user_mailbox`
  MODIFY `id` int(45) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
