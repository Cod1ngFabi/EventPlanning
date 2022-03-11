-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 11. Mrz 2022 um 08:20
-- Server-Version: 10.4.19-MariaDB
-- PHP-Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `event`
--

-- --------------------------------------------------------

CREATE TABLE `eventInput` (
  `forename` varchar(11) CHARACTER SET utf8 NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `item` varchar(11) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

CREATE TABLE `eventPlanning` (
  `item` varchar(11) CHARACTER SET utf8 NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit` varchar(11) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

CREATE TABLE `loginData` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `loginpassword` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

CREATE TABLE `swapMeet` (
  `forename` varchar(11) NOT NULL,
  `telephone` int(11) NOT NULL,
  `search` varchar(30) NOT NULL,
  `offer` varchar(30) NOT NULL,
  `timestmp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


ALTER TABLE `eventInput`
  ADD PRIMARY KEY (`forename`);

ALTER TABLE `eventPlanning`
  ADD PRIMARY KEY (`item`);

ALTER TABLE `loginData`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `swapMeet`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `loginData`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `swapMeet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;
