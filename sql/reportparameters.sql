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
-- Table structure for table `reportparameters`
--

CREATE TABLE `reportparameters` (
  `id` int(11) NOT NULL,
  `Folderid` int(11) NOT NULL,
  `Name` varchar(250) NOT NULL,
  `Value` varchar(250) NOT NULL,
  `User` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reportparameters`
--

INSERT INTO `reportparameters` (`id`, `Folderid`, `Name`, `Value`, `User`) VALUES
(91, 65, 'sessionStorageID2', '65', 'jamesrunnalls'),
(92, 65, 'jt', 'Plas Uchaf 2', 'jamesrunnalls'),
(93, 65, 'jn', '50000-1', 'jamesrunnalls'),
(94, 65, 'cd', 'An example computation', 'jamesrunnalls'),
(95, 65, 'r', 'A1', 'jamesrunnalls'),
(96, 65, 'a', 'James Runnalls', 'jamesrunnalls'),
(127, 63, 'sessionStorageID2', '63', 'jamesrunnalls'),
(128, 63, 'jn', 'undefined', 'jamesrunnalls'),
(129, 63, 'r', 'undefined', 'jamesrunnalls'),
(130, 63, 'jt', 'undefined', 'jamesrunnalls'),
(131, 63, 'a', 'undefined', 'jamesrunnalls'),
(132, 63, 'cd', 'undefined', 'jamesrunnalls'),
(133, 62, 'sessionStorageID2', '62', 'jamesrunnalls'),
(134, 62, 'jn', 'R', 'jamesrunnalls'),
(135, 62, 'r', 'sss', 'jamesrunnalls'),
(136, 62, 'jt', 'James', 'jamesrunnalls'),
(137, 62, 'a', 'sss', 'jamesrunnalls'),
(138, 62, 'cd', 'undefinednjame', 'jamesrunnalls');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `reportparameters`
--
ALTER TABLE `reportparameters`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `reportparameters`
--
ALTER TABLE `reportparameters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
