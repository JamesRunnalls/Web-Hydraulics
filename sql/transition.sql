-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 27, 2018 at 06:01 PM
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
-- Table structure for table `transition`
--

CREATE TABLE `transition` (
  `id` int(11) NOT NULL,
  `Detail` varchar(250) NOT NULL,
  `Value` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transition`
--

INSERT INTO `transition` (`id`, `Detail`, `Value`) VALUES
(1, 'Squared', 'Squared'),
(2, 'Rounded', 'Rounded'),
(3, 'Tapered (5 degrees)', '5'),
(4, 'Tapered (10 degrees)', '10'),
(5, 'Tapered (15 degrees)', '15'),
(6, 'Tapered (20 degrees)', '20'),
(7, 'Tapered (25 degrees)', '25'),
(8, 'Tapered (30 degrees)', '30'),
(9, 'Tapered (35 degrees)', '35'),
(10, 'Tapered (40 degrees)', '40'),
(11, 'Tapered (45 degrees)', '45'),
(12, 'Tapered (50 degrees)', '50'),
(13, 'Tapered (55 degrees)', '55'),
(14, 'Tapered (60 degrees)', '60'),
(15, 'Tapered (65 degrees)', '65'),
(16, 'Tapered (70 degrees)', '70'),
(17, 'Tapered (75 degrees)', '75'),
(18, 'Tapered (80 degrees)', '80'),
(19, 'Tapered (85 degrees)', '85'),
(20, 'None', 'None');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `transition`
--
ALTER TABLE `transition`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `transition`
--
ALTER TABLE `transition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
