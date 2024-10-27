-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2024-10-28 00:20:06
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
(51, 1, 7, '😎', '2024-10-14 16:39:37', 0),
(52, 1, 7, '6666', '2024-10-14 16:39:40', 0),
(53, 8, 7, '😎', '2024-10-14 16:45:48', 0),
(54, 8, 7, '6', '2024-10-14 16:45:54', 0),
(55, 8, 7, '👍', '2024-10-14 16:45:56', 0),
(56, 8, 7, '1', '2024-10-14 17:02:49', 0),
(57, 8, 7, '😍', '2024-10-14 17:07:28', 0),
(58, 8, 7, '🤓', '2024-10-14 17:08:35', 0),
(59, 1, 7, '🤓', '2024-10-14 17:16:35', 0),
(60, 1, 7, '🐔', '2024-10-14 17:16:45', 0),
(61, 9, 8, '😍', '2024-10-27 15:34:25', 0),
(62, 9, 8, '@ai 我要面试', '2024-10-27 15:51:47', 0),
(63, 9, 8, '@ai 操你妈', '2024-10-27 15:51:58', 0),
(64, 9, 8, '@ai 明天早上吃什么', '2024-10-27 15:52:11', 0),
(65, 9, 8, '打', '2024-10-27 15:52:45', 0),
(66, 9, 8, '@ai 我要面试', '2024-10-27 15:52:53', 0),
(67, 9, 8, '@ai 我好无聊啊', '2024-10-27 16:00:59', 0),
(68, 9, 8, '哎呀，这么好的天气或者这么悠闲的时刻，怎么能让无聊占据呢？不如我给你出个主意，我们一起玩个轻松的小游戏吧，或者我可以给你讲个笑话，让你开心开心？😉', '2024-10-27 16:01:01', 1),
(69, 9, 8, '@ai 好啊好啊', '2024-10-27 16:01:14', 0),
(70, 9, 8, '哎呀，你好呀！这么开心地和我聊天，是不是有什么烦恼想要倾诉呢？或者，想听听我分享一些轻松愉快的话题？😉🍵', '2024-10-27 16:01:15', 1),
(71, 9, 8, '@ai 我想听故事', '2024-10-27 16:01:27', 0),
(72, 9, 8, '哎呀，绿茶来啦！那我们就来个轻松的小故事吧。\n\n话说在一个遥远的绿茶村，村子里有一棵巨大的绿茶树，这棵树可是村子里的宝贝，因为它的叶子能泡出最香最美的绿茶。村子里有一个叫小茶的少年，他从小就喜欢在绿茶树下听老人们讲古。\n\n有一天，小茶听老村长说，绿茶树的秘密不仅仅在于它的叶子，还在于它每年会开一次神秘的花。这花只在夜晚开放，第二天就会消失，所以没有人见过它真正的样子。\n\n小茶好奇心起，决定找出这个秘密。他每晚都守在树下，终于在一个月光皎洁的夜晚，他看到了那朵绿茶花。它像一颗绿色的珍珠，散发着淡淡的清香。小茶小心翼翼地摘下了一瓣花，突然间，他听到了一个声音：“勇敢的小茶，你摘下了我的花瓣，你将获得一份特别的礼物。”\n\n小茶睁开眼，发现他面前出现了一位美丽的绿茶仙子。仙子告诉他，这份礼物就是让小茶拥有感知绿茶树所有秘密的能力。小茶激动地答应了。\n\n从那天起，小茶成了绿茶村的守护者，他用他的能力保护着这棵神奇的绿茶树，也让村子变得更加繁荣。而那朵神秘的绿茶花，也成了小茶和绿茶仙子友谊的象征。\n\n怎么样，这个故事你喜欢吗？如果你还有其他想听的，尽管告诉绿茶哦！🍵💭', '2024-10-27 16:01:36', 1),
(73, 9, 8, '大家觉得如何', '2024-10-27 16:01:57', 0),
(74, 9, 8, '呵呵呵', '2024-10-27 16:07:33', 0),
(75, 9, 8, '@ai 明天吃什么呢', '2024-10-27 16:07:41', 0),
(76, 9, 8, '绿茶聊天体验器：哎呀，明天吃什么真是个头疼的问题呢。要不我们一起想想法子？可以试试早餐来点鸡蛋灌饼，午餐吃个麻辣烫，晚餐来个烤鱼，怎么样？或者你有其他什么特别想吃的吗？😉', '2024-10-27 16:07:44', 1),
(77, 9, 8, '@ai 明天早餐吃什么呢', '2024-10-27 16:07:59', 0),
(78, 9, 8, '哎呀，这个嘛，绿茶我建议可以尝试一下时令的水果搭配全麦面包，既健康又美味呢！或者，如果你喜欢更丰富的口感，可以来个煎蛋三明治，搭配一杯香浓的豆浆，既营养又方便。你呢，有什么特别想吃的吗？😉', '2024-10-27 16:08:02', 1),
(79, 9, 8, '@你现在是什么智能题', '2024-10-27 16:09:30', 0),
(80, 9, 8, '@ai 你现在是什么智能体', '2024-10-27 16:10:06', 0),
(81, 9, 8, '你好！我是一个人工智能助手，基于先进的语言模型设计而成。我的主要功能是通过理解和生成自然语言来与用户进行交流，提供信息、解答问题以及进行各种有趣的对话。如果你有任何问题或者想要聊聊天，随时告诉我！', '2024-10-27 16:10:11', 1),
(82, 9, 8, '😎', '2024-10-27 16:10:16', 0),
(83, 9, 8, '你好', '2024-10-27 16:16:03', 0),
(84, 9, 8, '哈哈哈', '2024-10-27 16:17:59', 0),
(85, 9, 8, '@ai 明天早上吃什么好呢，我在福州', '2024-10-27 16:18:15', 0),
(86, 9, 8, '你好呀，在福州早餐有很多选择呢！如果你想尝试一些地道的福州美食，可以考虑以下几种：\n\n1. **鱼丸汤** - 福州的鱼丸汤非常有名，鲜美的鱼丸搭配清澈的汤底，口感Q弹，营养丰富。\n2. **鼎边糊** - 这是一种以大米和海鲜为主料，口感滑嫩的传统早餐。\n3. **福州光饼** - 是一种传统的面食，可以搭配豆腐乳、酱菜一起吃，很下饭。\n4. **锅边糊** - 和鼎边糊类似，但口感更细腻，通常配以肉丝、香菇等。\n5. **油条豆浆** - 油条酥脆，豆浆滑嫩，是经典的搭配。\n\n如果你喜欢西式早餐，也可以选择：\n\n- **三明治** - 选择你喜欢的肉类和蔬菜，搭配新鲜烤制的面包。\n- **吐司** - 可以搭配果酱、黄油，或者烤培根、煎蛋。\n- **燕麦片** - 搭配牛奶或酸奶，加入一些坚果和水果，健康美味。\n\n你打算尝试哪一种呢？或者有没有什么特别想吃的？我们可以一起研究一下！', '2024-10-27 16:18:22', 1);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

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
