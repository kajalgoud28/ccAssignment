-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Oct 06, 2024 at 03:26 PM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.0.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `login_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `logged_in` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `logged_in`) VALUES
(1, 'kajal', '$2y$10$zQf.jw9VH82iLJcbVwM35exOxKUWShOEA7/JMvAgHRzKWnmhe4SDu', 'user', '2024-09-06 20:49:42'),
(20, 'samidha', '$2y$10$WEOuvUtW3WsO82ct/73Zyu8602OayiFPoC/TRqo7k9j/P0vIF7Llu', 'user', '2024-09-05 08:49:49'),
(21, 'deepak', '$2y$10$vpeFUu7k7JKe8VJSqtbPj.banNPPLnwignv79xO2k.FoAOkHG9rAq', 'user', '2024-09-05 06:58:24'),
(22, 'sanjana', '$2y$10$lIts7BD1qF79JYYpALeQTOUbYc6T6ntzNl..O24EzfHrqvwJ1Y38O', 'user', '2024-09-06 02:00:23'),
(23, 'aftab', '$2y$10$PWXNUYC/1y125y8EzMLSsO7NzbDvQ4pZT.lalgKNqX9S9KDppiEa2', 'user', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
