-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 27, 2020 at 06:15 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pisazon`
--
CREATE DATABASE IF NOT EXISTS `pisazon` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `pisazon`;

-- --------------------------------------------------------

--
-- Table structure for table `ebook`
--

CREATE TABLE `ebook` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `author` varchar(50) NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ebook`
--

INSERT INTO `ebook` (`id`, `title`, `author`, `price`) VALUES
(1, 'Roba', 'Corsini', 300),
(2, 'Cose', 'Stea', 400),
(3, 'Terzo', 'Tonellotto', 0.5);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `id_buyer` int(11) NOT NULL,
  `id_ebook` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `id_buyer`, `id_ebook`, `date`) VALUES
(1, 8, 1, '2020-12-22'),
(2, 8, 2, '2020-12-22');

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
  `hash_token` varchar(128) NOT NULL,
  `expiration_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `hash_pass` varchar(255) DEFAULT NULL,
  `attempts` int(11) NOT NULL DEFAULT 0,
  `locked_until` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `hash_pass`, `attempts`, `locked_until`) VALUES
(1, 'boh', 'boh@gmail.com', '$2y$10$.FKsaUjhJvTgizT43f6dK.LZ.GM4rWGknnys8VoIDT3CS5N7dLRB6', 0, '2020-12-26 15:10:44'),
(4, 'caio', 'caio@gmail.com', '$2y$10$vBHGmiaY8RljP60BumVUv.zKTD8TrEsSvz3xzgNKjpNXmE6vC/Cy2', 0, '2020-12-26 15:10:44'),
(8, 'tizio', 'tizio@mail.com', '$2y$10$4F8CeZWrKPK9Du0gTQUQOuW2L2BDOXOvZ/wd6C0.5HeSSwqWO7gWq', 0, '2020-12-26 15:10:44'),
(9, 'a', 'andrea2bak@yahoo.it', '$2y$10$Du9XyTUDcuZsoB2pwx8K/OO451iCwFVg64Zp2xHJ0HXr5el1dYSyu', 0, '2020-12-27 16:16:33'),
(11, 'b', 'b@mail.com', '$2y$10$t1FLjo.LTQxsLzgjNzkvaOfWJPirKqJ66walKeBsucLnbmeiQmKeS', 0, '2020-12-27 16:35:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ebook`
--
ALTER TABLE `ebook`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Title_Author_Unique` (`author`,`title`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `buyer_ebook_unique` (`id_buyer`,`id_ebook`),
  ADD KEY `FK_order_ebook` (`id_ebook`);

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `hash_token` (`hash_token`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username_UNIQUE` (`username`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ebook`
--
ALTER TABLE `ebook`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `FK_order_user` FOREIGN KEY (`id_buyer`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tokens`
--
ALTER TABLE `tokens`
  ADD CONSTRAINT `FK_tokens_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `Clean_Tokens_Older_Than_10_minutes_And_Users_Not_Registered` ON SCHEDULE EVERY 1 MINUTE STARTS '2020-12-27 18:10:35' ON COMPLETION NOT PRESERVE ENABLE COMMENT 'Clean up tokens and users that did not complete the registration' DO BEGIN
    
    DELETE FROM user
    WHERE id IN(
		SELECT u.id
		FROM user as u join token as t on u.id = t.id_user
		WHERE u.hash_pass = null AND t.expiration_date < NOW()
    );
    
    DELETE FROM tokens
    WHERE expiration_date < NOW();
    
	END$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
