-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 23, 2018 at 07:55 PM
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
-- Table structure for table `minorloss`
--

CREATE TABLE `minorloss` (
  `id` int(11) NOT NULL,
  `Detail` varchar(250) NOT NULL,
  `K` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `minorloss`
--

INSERT INTO `minorloss` (`id`, `Detail`, `K`) VALUES
(1, 'Tee - Flanged Dividing Line Flow', 0.2),
(2, 'Tee - Threaded Dividing Line Flow', 0.9),
(3, 'Tee - Flanged Dividing Branched Flow', 1),
(4, 'Tee - Threaded  Dividing Branch Flow', 2),
(5, 'Union -  Threaded', 0.08),
(6, 'Elbow - Flanged Regular 90', 0.3),
(7, 'Elbow - Threaded Regular 90', 1.5),
(8, 'Elbow - Threaded Regular 45', 0.4),
(9, 'Elbow - Flanged Long Radius 90', 0.2),
(10, 'Elbow - Threaded Long Radius 90', 0.7),
(11, 'Elbow - Flanged Long Radius 45', 0.2),
(12, 'Return Bend - Flanged 180', 0.2),
(13, 'Return Bend - Threaded 180', 1.5),
(14, 'Valve - Globe Valve Fully Open', 10),
(15, 'Valve - Angle Valve Fully Open', 2),
(16, 'Valve - Gate Valve Fully Open', 0.15),
(17, 'Valve - Gate Valve 1/4 Closed', 0.26),
(18, 'Valve - Gate Valve 1/2 Closed', 2.1),
(19, 'Valve - Gate Valve 3/4 Closed', 17),
(20, 'Valve - Swing Check Valve Forward Flow', 2),
(21, 'Valve - Ball Valve Fully Open', 0.05),
(22, 'Valve - Ball Valve 1/3 Closed', 5.5),
(23, 'Valve - Ball Valve 2/3 Closed', 200),
(24, 'Valve - Diaphragm Valve Open', 2.3),
(25, 'Valve - Diaphragm Valve Half Open', 4.3),
(26, 'Valve - Diaphragm Valve 1/4 Open', 21),
(27, 'Water Meter', 7),
(28, 'Manhole - Trunkline only with no bend at the junction', 0.5),
(29, 'Manhole - Trunkline only with 45 degree bend at the junction', 0.6),
(30, 'Manhole - Trunkline only with 90 degree bend at the junction', 0.8),
(31, 'Manhole - Trunkline with one lateral', 0.7),
(32, 'Manhole - Two roughly equivalent entrance lines with angle less than 90 degree between lines', 0.8),
(33, 'Manhole - Two roughly equivalent entrance lines with angle more than 90 degree between lines', 0.9),
(34, 'Manhole - Three or more entrance lines', 1),
(35, 'Other', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `minorloss`
--
ALTER TABLE `minorloss`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `minorloss`
--
ALTER TABLE `minorloss`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
