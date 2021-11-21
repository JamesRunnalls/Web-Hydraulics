-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 11, 2018 at 03:40 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jamesru3_webhydraulics`
--

-- --------------------------------------------------------

--
-- Table structure for table `folder`
--

CREATE TABLE `folder` (
  `id` int(11) NOT NULL,
  `Name` varchar(250) NOT NULL,
  `Parent` varchar(250) NOT NULL,
  `Type` varchar(250) NOT NULL,
  `Description` varchar(250) NOT NULL,
  `User` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `folder`
--

INSERT INTO `folder` (`id`, `Name`, `Parent`, `Type`, `Description`, `User`) VALUES
(62, 'Sub - Super', 'None', 'pipeflow', '', 'jamesrunnalls'),
(63, 'Super - Sub', 'None', 'pipeflow', '', 'jamesrunnalls'),
(64, 'Model Tests', 'None', 'folder', 'Culvert Hydraulics: Comparison of Current Computer Models', 'jamesrunnalls'),
(65, 'Case A - Confirmed', '64', 'pipeflow', 'Q: 0-300cfs, Slope: 1%, Tailwater Depth: 0', 'jamesrunnalls'),
(66, 'Case B - Confirmed', '64', 'pipeflow', 'Q: 0-100cfs, Slope: 0.2%, Tailwater Depth: 0', 'jamesrunnalls'),
(68, 'Case D', '64', 'pipeflow', '', 'jamesrunnalls'),
(69, 'Case C - Confirmed', '64', 'pipeflow', 'Q: 0-150cfs, Slope: 0.3%, Tailwater Depth: 0', 'jamesrunnalls'),
(70, 'Hydraulic Jump', 'None', 'pipeflow', 'Hydraulic jump test', 'jamesrunnalls'),
(72, 'HJ', 'None', 'pipeflow', 'Hydraulic jump test', 'jamesrunnalls'),
(73, 'None', 'None', 'pipeflow', 'None', 'None'),
(74, 'None', 'None', 'pipeflow', 'None', 'None'),
(75, 'None', 'None', 'pipeflow', 'None', 'jamesrunnalls'),
(76, 'Test Pipeflow', 'None', 'pipeflow', '', 'test');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `folder`
--
ALTER TABLE `folder`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `folder`
--
ALTER TABLE `folder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
