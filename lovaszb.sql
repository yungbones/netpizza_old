-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql.omega:3306
-- Generation Time: Nov 14, 2018 at 09:50 AM
-- Server version: 5.6.42-log
-- PHP Version: 5.6.37-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lovaszb`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `name` varchar(60) COLLATE utf8_bin NOT NULL,
  `phone` varchar(11) COLLATE utf8_bin NOT NULL,
  `password` varchar(1000) COLLATE utf8_bin NOT NULL,
  `address` varchar(1000) COLLATE utf8_bin NOT NULL,
  `adminuser` int(11) NOT NULL DEFAULT '0',
  `regdate` varchar(1000) COLLATE utf8_bin NOT NULL,
  `lastlogin` varchar(1000) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `name`, `phone`, `password`, `address`, `adminuser`, `regdate`, `lastlogin`) VALUES
(1, 'admin', '', '$7DkS9WjV$f14d737bd7e966280aee219f9f44d1e793b2b88cde8abbcf828937ac2b635ac5df7def2bf75e0ff965888a063af532ad7740f3825a8f51643f8c98d6602f033d', '', 1, '2018-09-25 10:32:12', '2018-09-25 10:32:12'),
(12, 'LovĂĄsz Bence', '06303518291', '$/2dJWcM7$ca621da9fcf87c7eac89a540ee109ff89b8e9d2ec33d991686857edb97cdc5b93bfc4f72049f4dd104afe01a2f64b5043a0383a43123751accaaf6d4e44f158a', 'Paks', 0, '2018-10-25 10:20:50', '2018-10-25 10:20:50'),
(13, 'SzilĂĄgyi SĂĄndor', '06705800999', '$g2ye0DG$f08d835dab70b7b5c0d79cf0d395338b93537c6b47786c89b3b0af71477775c8eeb2268a78132ee0b457f2c6bd19c02ce81e3495d6e48035baf95c6add2d3b2e', 'GĂśd, BartĂłk BĂŠla utca 2.', 0, '2018-10-25 16:21:36', '2018-10-25 16:21:36');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `orderdatas` varchar(1000) COLLATE utf8_bin NOT NULL COMMENT 'JSON[[ [name, type, price] ]]',
  `price` int(5) NOT NULL,
  `userid` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '1: started |2: finished | 3: deleted',
  `time` varchar(1000) COLLATE utf8_bin NOT NULL,
  `date` int(11) NOT NULL,
  `finished` varchar(1000) COLLATE utf8_bin DEFAULT 'Folyamatban'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `orderdatas`, `price`, `userid`, `status`, `time`, `date`, `finished`) VALUES
(57, '[[\"Pizza Kalifornia\",\"1\",\"1450\"],[\"Pizza Picante\",\"2\",\"3405\"]]', 4855, 12, 0, '2018-10-26 10:59:29', 20181026, 'Folyamatban'),
(58, '[[\"Pizza Kalifornia\",\"1\",\"1450\"]]', 1450, 12, 0, '2018-10-26 11:00:24', 20181026, 'Folyamatban'),
(59, '[[\"Pizza Kalifornia\",\"1\",\"1450\"]]', 1450, 12, 0, '2018-10-26 11:00:31', 20181026, 'Folyamatban'),
(60, '[[\"Pizza Kalifornia\",\"1\",\"1450\"]]', 1450, 12, 0, '2018-10-26 11:05:42', 20181026, 'Folyamatban'),
(61, '[[\"Pizza Kalifornia\",\"1\",\"1450\"]]', 1450, 12, 0, '2018-10-26 16:15:36', 20181026, 'Folyamatban'),
(62, '[[\"Pizza Picante\",\"1\",\"1390\"],[\"Pizza Picante\",\"1\",\"1390\"]]', 2780, 12, 0, '2018-10-26 16:15:41', 20181026, 'Folyamatban'),
(63, '[[\"Pizza Picante\",\"2\",\"3405\"],[\"Pizza Picante\",\"2\",\"3405\"]]', 6810, 12, 0, '2018-10-26 16:15:47', 20181026, 'Folyamatban'),
(64, '[[\"Pizza Kalifornia\",\"1\",\"1450\"],[\"Pizza Kalifornia\",\"1\",\"1450\"],[\"Pizza Kalifornia\",\"1\",\"1450\"]]', 4350, 12, 0, '2018-11-05 08:12:57', 20181105, 'Folyamatban'),
(65, '[[\"Pizza Kalifornia\",\"2\",\"3552\"]]', 3552, 12, 0, '2018-11-06 11:24:28', 20181106, 'Folyamatban'),
(66, '[[\"Pizza Kalifornia\",\"2\",\"2915\"]]', 2915, 12, 3, '2018-11-08 10:16:17', 20181108, '2018-11-08 12:42:57'),
(67, '[[\"Pizza Kalifornia\",\"1\",\"1190\"],[\"Pizza Kalifornia\",\"1\",\"1190\"]]', 2380, 12, 3, '2018-11-08 12:42:13', 20181108, '2018-11-08 12:42:55'),
(68, '[[\"Pizza Picante\",\"2\",\"3405\"],[\"Pizza Picante\",\"2\",\"3405\"]]', 6810, 12, 3, '2018-11-08 12:42:19', 20181108, '2018-11-08 12:42:53'),
(69, '[[\"Pizza Kalifornia\",\"1\",\"1190\"]]', 1190, 12, 3, '2018-11-08 12:42:24', 20181108, '2018-11-08 12:42:52');

-- --------------------------------------------------------

--
-- Table structure for table `sitedatas`
--

CREATE TABLE `sitedatas` (
  `id` int(11) NOT NULL,
  `maintance` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `sitedatas`
--

INSERT INTO `sitedatas` (`id`, `maintance`) VALUES
(1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `storage`
--

CREATE TABLE `storage` (
  `id` int(11) NOT NULL,
  `normal` int(11) NOT NULL,
  `large` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `storage`
--

INSERT INTO `storage` (`id`, `normal`, `large`) VALUES
(1, 500, 300);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `sitedatas`
--
ALTER TABLE `sitedatas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `storage`
--
ALTER TABLE `storage`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `sitedatas`
--
ALTER TABLE `sitedatas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `storage`
--
ALTER TABLE `storage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `accounts` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
