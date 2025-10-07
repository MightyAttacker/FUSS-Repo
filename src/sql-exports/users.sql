-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 07, 2025 at 01:55 PM
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
  `sentby` varchar(45) NOT NULL,
  `sentto` varchar(45) NOT NULL,
  `created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mailbox`
--

INSERT INTO `mailbox` (`id`, `Subject`, `message`, `sentby`, `sentto`, `created`) VALUES
(1, 'test', 'test', 'bob@flinders.edu.au', 'putl0014@flinders.edu.au', '2025-10-07');

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
-- Table structure for table `userdata`
--

DROP TABLE IF EXISTS `userdata`;
CREATE TABLE `userdata` (
  `id` int(11) NOT NULL,
  `email` varchar(45) NOT NULL,
  `firstName` varchar(80) NOT NULL,
  `lastName` varchar(80) NOT NULL,
  `password` varchar(255) NOT NULL,
  `admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userdata`
--

INSERT INTO `userdata` (`id`, `email`, `firstName`, `lastName`, `password`, `admin`) VALUES
(1, 'putl0014@flinders.edu.au', 'Jayden', 'Putland', '$2y$10$ds4ha4PtWZZZ2Xk9G.4pRuKwAcJSeKQczEOYZDqMIjimGrtasegtG', 1),
(2, 'bob@flinders.edu.au', 'Bob', 'Test', '$2y$10$FhUF0v/ZyEzPw6GLdOuwEONmeEuBpzZxrFQ8VqGk6JJuytP.G.RQ6', 1),
(3, 'test@flinders.edu.au', 'First', 'Last', '$2y$10$mmiNWdOSqK0HWZaRtcNHe.yjyoB3khBe.Ickx8DG3Rs4mrYIwj1r6', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_mailbox`
--

DROP TABLE IF EXISTS `user_mailbox`;
CREATE TABLE `user_mailbox` (
  `id` int(45) NOT NULL,
  `user` varchar(45) NOT NULL,
  `mailbox` varchar(45) NOT NULL,
  `message_id` int(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_mailbox`
--

INSERT INTO `user_mailbox` (`id`, `user`, `mailbox`, `message_id`) VALUES
(1, 'bob@flinders.edu.au', 'Out', 1),
(2, 'putl0014@flinders.edu.au', 'In', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mailbox`
--
ALTER TABLE `mailbox`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userdata`
--
ALTER TABLE `userdata`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Indexes for table `user_mailbox`
--
ALTER TABLE `user_mailbox`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `Message ID` (`message_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mailbox`
--
ALTER TABLE `mailbox`
  MODIFY `id` int(45) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` int(45) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_mailbox`
--
ALTER TABLE `user_mailbox`
  ADD CONSTRAINT `Message ID` FOREIGN KEY (`message_id`) REFERENCES `mailbox` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
