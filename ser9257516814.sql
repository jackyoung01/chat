-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2024-10-15 12:56:23
-- 服务器版本： 5.7.44-log
-- PHP 版本： 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `ser9257516814`
--

-- --------------------------------------------------------

--
-- 表的结构 `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password`) VALUES
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e');

-- --------------------------------------------------------

--
-- 表的结构 `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `chat_messages`
--

INSERT INTO `chat_messages` (`id`, `user_id`, `room_id`, `message`, `created_at`) VALUES
(51, 1, 7, '😎', '2024-10-14 16:39:37'),
(52, 1, 7, '6666', '2024-10-14 16:39:40'),
(53, 8, 7, '😎', '2024-10-14 16:45:48'),
(54, 8, 7, '6', '2024-10-14 16:45:54'),
(55, 8, 7, '👍', '2024-10-14 16:45:56'),
(56, 8, 7, '1', '2024-10-14 17:02:49'),
(57, 8, 7, '😍', '2024-10-14 17:07:28'),
(58, 8, 7, '🤓', '2024-10-14 17:08:35'),
(59, 1, 7, '🤓', '2024-10-14 17:16:35'),
(60, 1, 7, '🐔', '2024-10-14 17:16:45');

-- --------------------------------------------------------

--
-- 表的结构 `chat_rooms`
--

CREATE TABLE `chat_rooms` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `chat_rooms`
--

INSERT INTO `chat_rooms` (`id`, `name`, `created_at`, `created_by`, `password`) VALUES
(5, '1', '2024-10-14 05:45:17', 5, 'c4ca4238a0b923820dcc509a6f75849b'),
(7, 'hello', '2024-10-14 16:34:42', 1, '202cb962ac59075b964b07152d234b70'),
(8, 'jack', '2024-10-15 02:17:46', 9, '202cb962ac59075b964b07152d234b70');

-- --------------------------------------------------------

--
-- 表的结构 `chat_users`
--

CREATE TABLE `chat_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `chat_users`
--

INSERT INTO `chat_users` (`id`, `username`, `password`, `created_at`) VALUES
(1, '123', '$2y$10$8CjyQqsZfa0Q8T6NgmJr3ORTZgnofTlyw5r6j9RITthwf3yKZqpF6', '2024-10-13 05:34:50'),
(2, '666', '$2y$10$HYdiHb89HdSY7rY49WOtse4I0MB89zWsKdK10D.jnkKRLubEm4qJG', '2024-10-13 05:41:57'),
(3, '777', '$2y$10$GoyNmCs6hJAc6gcJD3Q0e.Q92oS5HNzlW/3YY0nzuGig0bFfNEF26', '2024-10-13 05:49:15'),
(4, '6666', '$2y$10$En6chuwssAe9Ur0MsrJkCeALNqdG1L54gV5xFdfC7xkEhOpxyutrW', '2024-10-13 07:41:31'),
(5, 'Southerly', '$2y$10$FzR2t5K8MDSjsPi9AELYrekbWnG3hRsxCeI42NfClz7o5mDf.l54O', '2024-10-14 05:44:59'),
(6, '123456', '$2y$10$odLk4.gaUDgZ4qr4DBMU2..OZ7M5oX9Tnbu9n6LOj72Prr8a4yrIq', '2024-10-14 16:16:38'),
(7, '111', '$2y$10$uP3JfS7.7VbR6nndAan25.qYkOT5uPbcHHsb5hkAlsndR8wtqNBB2', '2024-10-14 16:39:49'),
(8, '1111', '$2y$10$PZ99ohPyfiYs9a5RmICbUeMReDL4BZUQrpzAScwBCPNUfXhiSXBQu', '2024-10-14 16:43:51'),
(9, 'jack', '$2y$10$YiBkeLKdCo7cYZHowC7xR.Y2CjTvmdO/kXa4WV8KrSAcl4d..2MYO', '2024-10-15 02:17:33');

--
-- 转储表的索引
--

--
-- 表的索引 `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `room_id` (`room_id`);

--
-- 表的索引 `chat_rooms`
--
ALTER TABLE `chat_rooms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- 表的索引 `chat_users`
--
ALTER TABLE `chat_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- 使用表AUTO_INCREMENT `chat_rooms`
--
ALTER TABLE `chat_rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- 使用表AUTO_INCREMENT `chat_users`
--
ALTER TABLE `chat_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- 限制导出的表
--

--
-- 限制表 `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD CONSTRAINT `chat_messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `chat_users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `chat_messages_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `chat_rooms` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
