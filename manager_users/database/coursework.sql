-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 29, 2024 at 09:57 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `coursework`
--

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `question_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `image_url` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`question_id`, `user_id`, `title`, `content`, `created_at`, `image_url`) VALUES
(4, 13, 'Title', 'Test', '2024-04-22 14:16:01', 'Test'),
(5, 14, 'Hi', 'New', '2024-04-29 14:15:34', 'Hi'),
(6, 14, 'Hello kitiy', 'Hel;', '2024-04-29 14:44:32', 'Daine');

-- --------------------------------------------------------

--
-- Table structure for table `tokenLogin`
--

CREATE TABLE `tokenLogin` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `token` varchar(2000) DEFAULT NULL,
  `create_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tokenLogin`
--

INSERT INTO `tokenLogin` (`id`, `user_id`, `token`, `create_at`) VALUES
(10, 13, '4125258d5864fb6c118b6ef5117b0090bf0daf8e', '2024-04-21 16:59:58'),
(11, 13, '5c931a189b4f53ae7ad38d86ac0a548f4ffc40df', '2024-04-21 19:20:21'),
(14, 13, 'a998edf82084091c7c58132705f97d3cdb4079ed', '2024-04-22 21:02:52'),
(15, 14, 'c5a1f4a255aa8803ed5c4dd39cae4c9cabbce071', '2024-04-29 21:15:13');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(2000) DEFAULT NULL,
  `forgotToken` varchar(100) DEFAULT NULL,
  `activeToken` varchar(2000) DEFAULT NULL,
  `create_at` datetime DEFAULT current_timestamp(),
  `update_at` datetime DEFAULT current_timestamp(),
  `status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `password`, `forgotToken`, `activeToken`, `create_at`, `update_at`, `status`) VALUES
(9, 'daitranquang', 'daid@gmail.com', '$2y$10$562Oceh1p7tze5OGNUf5qOUAgAEGVDENBqOxEKWFRl6Se0fYPo5Cm', '60a2646d0fb6823d1c73df81bd7a5e6f755d760a', 'adb27065bb11b34349674fa9c3010f17da6b60b6', '2024-04-21 07:52:22', '2024-04-21 12:52:22', 0),
(13, 'Daine', 'trangquangdai03072004@gmail.com', '$2y$10$FexzDsfudCWAZ4Q22a9xbOFPwjsEXXlA9WKV7XTm5GDvv2ixhTHRi', NULL, NULL, '2024-04-21 16:57:54', '2024-04-21 19:25:30', 1),
(14, 'tester', 'test.1212@example.com', '$2y$10$dokrIXOJa3mFHywky5Fu1eBWs4RuPww/A2bbR9qxjOp11SLfb9z0q', NULL, '47014248f1f07323f4988659f966c8c82565babb', '2024-04-29 21:14:51', '2024-04-30 02:14:51', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`question_id`),
  ADD KEY `questions_ibfk_1` (`user_id`);

--
-- Indexes for table `tokenLogin`
--
ALTER TABLE `tokenLogin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tokenLogin`
--
ALTER TABLE `tokenLogin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tokenLogin`
--
ALTER TABLE `tokenLogin`
  ADD CONSTRAINT `tokenlogin_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
