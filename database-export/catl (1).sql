-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Време на генериране:  4 юни 2021 в 18:09
-- Версия на сървъра: 10.4.18-MariaDB
-- Версия на PHP: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данни: `catl`
--

-- --------------------------------------------------------

--
-- Структура на таблица `cat`
--

CREATE TABLE `cat` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cat_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Схема на данните от таблица `cat`
--

INSERT INTO `cat` (`id`, `name`, `description`, `age`, `user_id`, `cat_image`) VALUES
(11, 'Haaku', ' Haku is very inteligent and strong. Also very playfull. Haku may seem very mature but he still needs a lot of love', 6, 11, 'uploads/mr-charles.jpg'),
(13, 'Beasty Boy', ' Beasty Boy is kind of a superhero cat, he is so mischivious but he at the end of the day, Beasty is all i  want ', 4, 12, 'uploads/beasty.jpg'),
(16, 'Harry', ' Harry is like prince Harry - very charming with the only difference my Harry is not a prince', 8, 10, 'uploads/Harry.jpg'),
(17, 'Samuel', ' Samuel is very kind, calm and a good little boy', 2, 10, 'uploads/samuel.jpg'),
(18, 'Henry', ' Henry is a majestic a cat and also a cute boy', 1, 12, 'uploads/Hnery.jpg'),
(19, 'Angsty', ' Angsty looks angry 24/7 but has a big and warm heart.', 16, 12, 'uploads/Angsty.jpg');

-- --------------------------------------------------------

--
-- Структура на таблица `image`
--

CREATE TABLE `image` (
  `id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Схема на данните от таблица `image`
--

INSERT INTO `image` (`id`, `image`, `user_id`) VALUES
(17, 'uploads/gallery1.jpg', 10),
(18, 'uploads/gallery2.jpg', 10),
(19, 'uploads/gallery3.jpg', 10),
(20, 'uploads/gallery4.jpg', 11),
(21, 'uploads/gallery5.jpg', 11),
(22, 'uploads/gallery6.jpg', 11),
(23, 'uploads/gallery7.jpg', 11),
(24, 'uploads/gallery10.jpg', 12),
(25, 'uploads/gallery11.jpg', 12);

-- --------------------------------------------------------

--
-- Структура на таблица `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `birthday` varchar(255) DEFAULT NULL,
  `user_image` varchar(255) DEFAULT NULL,
  `isAdmin` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Схема на данните от таблица `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `address`, `birthday`, `user_image`, `isAdmin`) VALUES
(10, 'Hillary Gray', 'hill_gray@gmail.com', 'hillGray1234', 'Wshington', '23 March', 'uploads/hillary.jpg', NULL),
(11, 'Yuumi Mitsune', 'yuuumi@gmail.com', 'yuuumiM1234', 'Sapporo', '3 November', 'uploads/yuumi-mitsune.jpg', NULL),
(12, 'Stan Stevenski', 'stan_stev@gmail.com', 'stanStev1234', 'San Francisco', '7 July', 'uploads/Stan.jpg', NULL),
(13, 'Anna Kuzmova', 'ani@abv.bg', '123456', NULL, NULL, NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Индекси за таблица `cat`
--
ALTER TABLE `cat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cat_ibfk_1` (`user_id`);

--
-- Индекси за таблица `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `test` (`user_id`);

--
-- Индекси за таблица `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password` (`password`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cat`
--
ALTER TABLE `cat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `image`
--
ALTER TABLE `image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Ограничения за дъмпнати таблици
--

--
-- Ограничения за таблица `cat`
--
ALTER TABLE `cat`
  ADD CONSTRAINT `cat_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения за таблица `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `test` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
