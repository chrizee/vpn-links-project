-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 03, 2018 at 12:00 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 7.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vpn`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(64) NOT NULL,
  `salt` varchar(32) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pic` varchar(100) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `salt`, `created`, `pic`, `status`) VALUES
(1, 'admin', 'admin@vpn.com', 'a072aefd1753372791c6ae8caa54c17825e90bcc30ae03894f66f4d6580e2b54', 'sB#PM@HifgZ=ehH,.u8IIxPbHA@%K9@B', '2018-06-03 09:18:44', '5b13c9fda5bfa.jpg', '1'),
(2, 'sammy', 'sammy@gmail.com', '0f89ac3877b62c7108f1bb6e4d29b3ce5eefdc066f5240eee388edb83d7f3efe', 'E%jVoNf2=9S%EpsKVr_^Un--zb#SKlZ6', '2018-06-03 11:25:02', '5b13c9d880cab.jpg', '1');

-- --------------------------------------------------------

--
-- Table structure for table `vpn`
--

CREATE TABLE `vpn` (
  `id` int(11) NOT NULL,
  `url` mediumtext NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vpn`
--

INSERT INTO `vpn` (`id`, `url`, `username`, `password`, `status`, `created_at`) VALUES
(1, 'http://www.vpn.net', 'efe', 'password', '1', '2018-06-03 09:47:02'),
(6, 'trinity', 'trinity', 'chovwebhh', '1', '2018-06-03 11:42:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vpn`
--
ALTER TABLE `vpn`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `vpn`
--
ALTER TABLE `vpn`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
