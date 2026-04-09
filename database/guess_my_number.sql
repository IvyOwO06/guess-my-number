-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 09, 2026 at 12:07 PM
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
-- Database: `guess_my_number`
--
CREATE DATABASE IF NOT EXISTS `guess_my_number` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `guess_my_number`;

-- --------------------------------------------------------

--
-- Table structure for table `leaderboard`
--

CREATE TABLE IF NOT EXISTS `leaderboard` (
  `gameId` int(10) NOT NULL AUTO_INCREMENT,
  `userId` int(4) NOT NULL,
  `username` varchar(255) NOT NULL,
  `difficulty` int(2) NOT NULL,
  `maxTime(s)` int(10) NOT NULL,
  `attempts` int(10) NOT NULL,
  `guesses` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`gameId`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leaderboard`
--

INSERT INTO `leaderboard` (`gameId`, `userId`, `username`, `difficulty`, `maxTime(s)`, `attempts`, `guesses`, `date`) VALUES
(6, 1, 'Ivy___OwO', 1, 8, 3, '5, 2', '2026-04-07 16:55:21'),
(7, 1, 'Ivy___OwO', 1, 12, 4, '5, 8, 3, 2', '2026-04-07 16:57:19'),
(8, 1, 'Ivy___OwO', 1, 5, 1, '3', '2026-04-07 17:04:06'),
(9, 1, 'Ivy___OwO', 1, 9, 1, '4', '2026-04-07 17:16:00'),
(10, 1, 'Ivy___OwO', 6, 7, 1, '186', '2026-04-07 17:31:31'),
(11, 1, 'Ivy___OwO', 1, 7, 4, '5, 3, 2, 1', '2026-04-07 17:36:44'),
(12, 1, 'Ivy___OwO', 1, 5, 3, '5, 3, 1', '2026-04-07 17:37:17'),
(13, 1, 'Ivy___OwO', 1, 8, 4, '5, 7, 9, 8', '2026-04-07 17:38:02'),
(14, 1, 'Ivy___OwO', 1, 13, 6, '5, 8', '2026-04-07 17:38:07'),
(15, 1, 'Ivy___OwO', 1, 5, 3, '5, 8, 9', '2026-04-07 19:25:20'),
(16, 1, 'Ivy___OwO', 1, 5, 3, '5, 8, 6', '2026-04-07 19:53:14'),
(17, 1, 'Ivy___OwO', 1, 9, 4, '5, 8, 9, 10', '2026-04-07 19:54:02'),
(18, 1, 'Ivy___OwO', 1, 11, 3, '5, 8, 7', '2026-04-07 20:05:08'),
(19, 1, 'Ivy___OwO', 1, 12, 3, '5, 2, 1', '2026-04-08 10:07:00'),
(20, 1, 'Ivy___OwO', 1, 8, 3, '1, 5, 8', '2026-04-08 10:10:13'),
(21, 1, 'Ivy___OwO', 1, 12, 4, '10, 5, 7, 8', '2026-04-08 10:10:39'),
(22, 1, 'Ivy___OwO', 1, 10, 3, '5, 7, 8', '2026-04-08 10:10:49'),
(23, 1, 'Ivy___OwO', 1, 7, 3, '5, 2, 1', '2026-04-08 10:10:56'),
(24, 2, 'Domi', 1, 15, 4, '5, 8, 3, 4', '2026-04-08 10:16:18'),
(25, 1, 'Ivy___OwO', 1, 5, 1, '5', '2026-04-08 10:19:25'),
(26, 2, 'Domi', 1, 43, 3, '5, 5, 2', '2026-04-08 10:21:47'),
(27, 1, 'Ivy___OwO', 1, 13, 3, '1, 5, 4', '2026-04-08 10:47:01'),
(28, 1, 'Ivy___OwO', 1, 8, 3, '5, 3, 1', '2026-04-09 12:00:11'),
(29, 1, 'Ivy___OwO', 1, 31, 3, '5, 3, 2', '2026-04-09 12:03:01');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `userId` int(4) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `username`, `email`, `password`) VALUES
(1, 'Ivy___OwO', 'samdelhaye06@gmail.com', '$2y$10$F2XcxnH1QQH15vGTutAODu2KClCTezCDzO5nA1m/oqRBc4va7/uwy'),
(2, 'Domi', 'domi@domi.domi', '$2y$10$zU0OHT7TDbnot7c74eYF6OzeoGCqejfw.jFCAGDbnjbgU2cy5vyoK');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
