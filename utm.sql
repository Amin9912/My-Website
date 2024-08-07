-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 02, 2024 at 07:21 AM
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
-- Database: `utm`
--

-- --------------------------------------------------------

--
-- Table structure for table `travelling_details`
--

CREATE TABLE `travelling_details` (
  `id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `location_from` varchar(255) NOT NULL,
  `location_to` varchar(255) NOT NULL,
  `purpose` varchar(255) NOT NULL,
  `mileage` int(11) NOT NULL,
  `parking` int(11) NOT NULL,
  `toll` int(11) NOT NULL,
  `flights` int(11) NOT NULL,
  `taxi_fare` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `travelling_details`
--

INSERT INTO `travelling_details` (`id`, `date`, `location_from`, `location_to`, `purpose`, `mileage`, `parking`, `toll`, `flights`, `taxi_fare`) VALUES
(1, '2024-07-04 00:00:00', 'KLLL122331231123', 'KK', 'Walk', 123, 10, 20, 200, 100),
(3, '2024-07-09 00:00:00', 'KL', 'PN', 'shop', 100, 200, 300, 400, 500000),
(4, '2024-07-03 00:00:00', 'PRL', 'asd', 'qwe', 100, 123, 123, 123, 123),
(6, '2024-07-31 00:00:00', 'PRLqweqweqwe', 'PN', 'shop', 232, 123, 232, 232, 2323),
(7, '2024-07-11 00:00:00', 'KL', '1000', '100', 100, 100, 100, 100, 100),
(8, '2024-07-26 00:00:00', 'PRK', '1000', 'shoping', 234, 100, 123, 234, 123);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` int(11) NOT NULL DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`) VALUES
(1, 'amin', 'amin@gmail.com', '$2y$10$aIU3K4J8DTXqWW7g.vAgfuTcP58KUKT6iVMDnsH2qXnbKe8iL.6Pm', 1),
(2, 'amin', 'amin@gmail.com', '$2y$10$H828bWDaWIS4xBcX1LRPDO1RAfcHl2/naR6VBY8NwSIv1pOUO374u', 2),
(3, 'amin2', 'amin2@gmail.com', '$2y$10$u6JMhi7aD142YvldzBIR..dHF8bJqo1Vx3tGjvfmgAr1KgcfNlxF.', 2),
(4, 'amin2', 'amin2@gmail.com', '$2y$10$2aQq2xdlHJRbLquvdfuuxeRRTQMOlZY6r7ySXy3YK2eCiis7A28u6', 2),
(5, 'staff', 'staff@gmail.com', '$2y$10$3SjhzMaQxj0N9DiN/d4wyep5TEfMfzEVlTWt.S1xMnHdsKE2tG322', 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `role`) VALUES
(1, 'admin'),
(2, 'staff');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `travelling_details`
--
ALTER TABLE `travelling_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `travelling_details`
--
ALTER TABLE `travelling_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
