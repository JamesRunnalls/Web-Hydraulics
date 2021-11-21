-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 27, 2018 at 06:02 PM
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
-- Table structure for table `roughness`
--

CREATE TABLE `roughness` (
  `id` int(11) NOT NULL,
  `Detail` varchar(250) NOT NULL,
  `Minimum` float NOT NULL,
  `Normal` float NOT NULL,
  `Maximum` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roughness`
--

INSERT INTO `roughness` (`id`, `Detail`, `Minimum`, `Normal`, `Maximum`) VALUES
(1, 'Copper', 0.000001, 0.0000015, 0.000002),
(2, 'Lead', 0.000001, 0.0000015, 0.000002),
(3, 'Brass', 0.000001, 0.0000015, 0.000002),
(4, 'Aluminium', 0.000001, 0.0000015, 0.000002),
(5, 'PVC', 0.0000015, 0.00000425, 0.000007),
(6, 'Plastic', 0.0000015, 0.00000425, 0.000007),
(7, 'Steel - Stainless steel bead blasted', 0.000001, 0.0000035, 0.000006),
(8, 'Steel - Stainless steel turned', 0.0000004, 0.0000032, 0.000006),
(9, 'Steel - Stainless steel electropolished', 0.0000001, 0.00000045, 0.0000008),
(10, 'Steel - Steel commercial pipe', 0.000045, 0.0000675, 0.00009),
(11, 'Steel - Stretched steel', 0.000015, 0.000015, 0.000015),
(12, 'Steel - Weld steel', 0.000045, 0.000045, 0.000045),
(13, 'Steel - Galvanized steel', 0.00015, 0.00015, 0.00015),
(14, 'Steel - Rusted steel (corrosion)', 0.00015, 0.200075, 0.4),
(15, 'Cast Iron - New cast iron', 0.00025, 0.000525, 0.0008),
(16, 'Cast Iron - Worn cast iron', 0.0008, 0.00115, 0.0015),
(17, 'Cast Iron - Rusty cast iron', 0.0015, 0.002, 0.0025),
(18, 'Cast Iron - Sheet or asphalted cast iron', 0.00001, 0.0000125, 0.000015),
(19, 'Cement - Smoothed cement', 0.0003, 0.0003, 0.0003),
(20, 'Concrete - Ordinary concrete', 0.0003, 0.00065, 0.001),
(21, 'Contrete - Coarse concrete', 0.0003, 0.00265, 0.005),
(22, 'Wood - Well planed wood', 0.00018, 0.00054, 0.0009),
(23, 'Wood - Ordinary wood', 0.005, 0.005, 0.005);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `roughness`
--
ALTER TABLE `roughness`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `roughness`
--
ALTER TABLE `roughness`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
