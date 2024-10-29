-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2024-10-29 23:50:17
-- 服务器版本： 5.7.40-log
-- PHP 版本： 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `120_55_57_217_11`
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
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `is_ai` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `chat_messages`
--

INSERT INTO `chat_messages` (`id`, `user_id`, `room_id`, `message`, `created_at`, `is_ai`) VALUES
(103, 12, 11, '66', '2024-10-28 06:57:16', 0),
(104, 12, 11, '@ai 你好啊', '2024-10-28 06:57:21', 0),
(105, 12, 11, '你好呀！很高兴能和你聊天。今天有什么特别的事情想要分享吗？或者有什么问题想要探讨的？我们可以聊聊天气、兴趣爱好，或者是最近的生活点滴。', '2024-10-28 06:57:23', 1),
(106, 12, 11, '666', '2024-10-28 07:01:04', 0),
(107, 12, 11, 'fuckyou', '2024-10-28 07:01:12', 0),
(108, 9, 11, '666', '2024-10-28 07:01:37', 0),
(109, 9, 11, 'nima', '2024-10-28 07:01:40', 0),
(110, 9, 11, 'hahaha', '2024-10-28 07:02:28', 0),
(111, 9, 11, '我去', '2024-10-28 07:02:34', 0),
(112, 12, 11, 'nima', '2024-10-28 07:02:57', 0),
(113, 9, 11, '😀', '2024-10-28 07:07:37', 0),
(114, 9, 11, '😅', '2024-10-28 07:07:41', 0),
(115, 9, 11, '😂', '2024-10-28 07:08:06', 0),
(116, 9, 11, 'hhh', '2024-10-28 07:08:11', 0),
(117, 9, 11, '😎', '2024-10-28 07:09:47', 0),
(118, 9, 11, '😎', '2024-10-28 07:11:40', 0),
(119, 9, 11, '😎', '2024-10-28 07:14:42', 0),
(120, 9, 11, '😜', '2024-10-28 07:17:25', 0),
(121, 9, 11, '👍', '2024-10-28 07:17:39', 0),
(122, 9, 11, '😆', '2024-10-28 07:17:43', 0),
(123, 9, 11, '我说你', '2024-10-28 07:17:58', 0),
(124, 9, 11, '😍', '2024-10-28 07:18:13', 0),
(125, 9, 11, '😎', '2024-10-28 07:18:21', 0),
(126, 9, 11, '😅', '2024-10-28 07:20:03', 0),
(127, 9, 11, '😎', '2024-10-28 07:23:47', 0),
(128, 9, 11, '👍', '2024-10-28 07:25:10', 0),
(129, 12, 11, '😁', '2024-10-28 07:25:15', 0),
(130, 12, 11, '666', '2024-10-28 07:34:58', 0),
(131, 12, 11, '666', '2024-10-28 07:34:58', 0),
(132, 9, 11, '666', '2024-10-28 07:35:09', 0),
(133, 9, 11, '如何', '2024-10-28 07:35:16', 0),
(134, 12, 11, '666', '2024-10-28 07:37:00', 0),
(135, 12, 11, '666', '2024-10-28 07:37:00', 0),
(136, 12, 11, '666', '2024-10-28 07:37:30', 0),
(137, 12, 11, '666', '2024-10-28 07:37:30', 0),
(138, 12, 11, '666', '2024-10-28 07:39:29', 0),
(139, 12, 11, '4', '2024-10-28 07:42:46', 0),
(140, 12, 11, '😎', '2024-10-28 12:26:03', 0),
(141, 12, 11, '😎', '2024-10-28 12:52:10', 0),
(142, 12, 11, '🤩', '2024-10-28 13:04:07', 0),
(143, 9, 11, '看看', '2024-10-28 13:06:35', 0),
(144, 9, 11, '@ai 晚上有什么好玩的', '2024-10-28 13:07:07', 0),
(145, 12, 11, '@ai 怎么不说话', '2024-10-28 13:07:46', 0),
(146, 12, 13, '@ai 你好', '2024-10-28 13:09:47', 0),
(147, 12, 13, '你好呀！很高兴能和你聊天。今天过得怎么样？有什么新鲜事儿想和我分享吗？😊', '2024-10-28 13:09:50', 1),
(148, 12, 13, '🤤', '2024-10-28 13:25:12', 0),
(149, 12, 13, '666', '2024-10-28 13:41:51', 0),
(150, 12, 13, '111', '2024-10-28 13:42:05', 0),
(152, 12, 13, 'look、<img src=\'uploads/671f95d48db93_OIP-C.jpg\' alt=\'图片\' style=\'max-width:200px;\'>', '2024-10-28 13:47:00', 0),
(153, 12, 13, '🤩', '2024-10-28 13:47:16', 0),
(154, 12, 13, '@ai 你还好吗', '2024-10-28 13:48:37', 0),
(155, 12, 13, '你好呀！我作为一个人工智能助手，一直都在这里准备与你聊天呢。感觉还不错，你呢？今天过得怎么样？有没有什么新鲜事儿想要和我分享的？😊', '2024-10-28 13:48:39', 1),
(157, 13, 13, '再试试<img src=\'uploads/671f9a32f353a_OIP-C.jpg\' alt=\'图片\' style=\'max-width:200px;\'>', '2024-10-28 14:05:38', 0),
(158, 13, 13, '666', '2024-10-28 16:36:26', 0),
(159, 12, 13, '你好', '2024-10-29 11:49:25', 0),
(160, 12, 13, '👍', '2024-10-29 11:51:43', 0),
(161, 12, 13, '🤩', '2024-10-29 11:57:39', 0),
(162, 12, 13, '@ai 我好无聊啊', '2024-10-29 11:57:56', 0),
(163, 12, 13, '哎呀，看来今天你心情不太好呢。有什么事情让你感到无聊吗？我们可以聊聊天，也许能帮你分散一下注意力哦！你平时喜欢做什么来消遣时间呢？', '2024-10-29 11:58:02', 1),
(164, 9, 13, '😂', '2024-10-29 15:42:24', 0),
(165, 12, 13, '11', '2024-10-29 15:43:36', 0),
(166, 9, 13, '😍', '2024-10-29 15:43:51', 0);

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
(11, 'good', '2024-10-28 06:42:18', 9, '202cb962ac59075b964b07152d234b70'),
(13, 'hello', '2024-10-28 13:09:39', 12, '202cb962ac59075b964b07152d234b70');

-- --------------------------------------------------------

--
-- 表的结构 `chat_users`
--

CREATE TABLE `chat_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `last_active` timestamp NULL DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `chat_users`
--

INSERT INTO `chat_users` (`id`, `username`, `password`, `created_at`, `last_active`, `room_id`) VALUES
(1, '123', '$2y$10$8CjyQqsZfa0Q8T6NgmJr3ORTZgnofTlyw5r6j9RITthwf3yKZqpF6', '2024-10-13 05:34:50', NULL, NULL),
(2, '666', '$2y$10$HYdiHb89HdSY7rY49WOtse4I0MB89zWsKdK10D.jnkKRLubEm4qJG', '2024-10-13 05:41:57', NULL, NULL),
(3, '777', '$2y$10$GoyNmCs6hJAc6gcJD3Q0e.Q92oS5HNzlW/3YY0nzuGig0bFfNEF26', '2024-10-13 05:49:15', NULL, NULL),
(4, '6666', '$2y$10$En6chuwssAe9Ur0MsrJkCeALNqdG1L54gV5xFdfC7xkEhOpxyutrW', '2024-10-13 07:41:31', NULL, NULL),
(5, 'Southerly', '$2y$10$FzR2t5K8MDSjsPi9AELYrekbWnG3hRsxCeI42NfClz7o5mDf.l54O', '2024-10-14 05:44:59', NULL, NULL),
(6, '123456', '$2y$10$odLk4.gaUDgZ4qr4DBMU2..OZ7M5oX9Tnbu9n6LOj72Prr8a4yrIq', '2024-10-14 16:16:38', NULL, NULL),
(7, '111', '$2y$10$uP3JfS7.7VbR6nndAan25.qYkOT5uPbcHHsb5hkAlsndR8wtqNBB2', '2024-10-14 16:39:49', NULL, NULL),
(8, '1111', '$2y$10$PZ99ohPyfiYs9a5RmICbUeMReDL4BZUQrpzAScwBCPNUfXhiSXBQu', '2024-10-14 16:43:51', NULL, NULL),
(9, 'jack', '$2y$10$YiBkeLKdCo7cYZHowC7xR.Y2CjTvmdO/kXa4WV8KrSAcl4d..2MYO', '2024-10-15 02:17:33', '2024-10-29 15:50:02', 13),
(10, '12345', '$2y$10$95iza3lJbbyYkKK57prSw.iYqbF/B3J9TaIjR.hM9LAhCZVUpyrhO', '2024-10-27 17:46:51', NULL, NULL),
(11, 'ikun666', '$2y$10$6E/op.0u23GAFyeJrgdjB.BJynS1i4gExW5nWb9c9DEOMX.g6uPk2', '2024-10-28 02:26:34', NULL, NULL),
(12, '1122', '$2y$10$YsAfk0/bZy4gRlNkECYwe.iq9MSzqL8WtNMX6g5QAddcbVjyuHEWi', '2024-10-28 06:44:10', '2024-10-29 15:49:23', 13),
(13, '1133', '$2y$10$lG8JURMId7JvhXfKmj93AuvXXguommAAo3f/AZV.BGoVTpznRr69K', '2024-10-28 13:49:12', NULL, NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=167;

--
-- 使用表AUTO_INCREMENT `chat_rooms`
--
ALTER TABLE `chat_rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- 使用表AUTO_INCREMENT `chat_users`
--
ALTER TABLE `chat_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

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
