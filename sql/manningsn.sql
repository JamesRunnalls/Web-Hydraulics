-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 23, 2018 at 07:51 PM
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
-- Table structure for table `manningsn`
--

CREATE TABLE `manningsn` (
  `id` int(11) NOT NULL,
  `Detail` varchar(250) NOT NULL,
  `Minimum` float NOT NULL,
  `Normal` float NOT NULL,
  `Maximum` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `manningsn`
--

INSERT INTO `manningsn` (`id`, `Detail`, `Minimum`, `Normal`, `Maximum`) VALUES
(1, 'Brass - Smooth', 0.009, 0.01, 0.013),
(2, 'Steel - Lockbar and welded', 0.01, 0.012, 0.014),
(3, 'Steel - Riveted and spiral', 0.013, 0.016, 0.017),
(4, 'Cast Iron - Coated', 0.01, 0.013, 0.014),
(5, 'Cast Iron - Uncoated', 0.011, 0.014, 0.016),
(6, 'Wrought Iron - Black', 0.012, 0.014, 0.015),
(7, 'Wrought Iron - Galvanized', 0.013, 0.016, 0.017),
(8, 'Corrugated Metal - Subdrain', 0.017, 0.019, 0.021),
(9, 'Corrugated Metal - Stormdrain', 0.021, 0.024, 0.03),
(10, 'Cement - Neat Surface', 0.01, 0.011, 0.013),
(11, 'Cement - Mortar', 0.011, 0.013, 0.015),
(12, 'Concrete - Culvert straight and free of debris', 0.01, 0.011, 0.013),
(13, 'Concrete - Culvert with bends connections and some debris', 0.011, 0.013, 0.014),
(14, 'Concrete - Finished', 0.011, 0.012, 0.014),
(15, 'Concrete - Sewer with manholes inlet etc. straight', 0.013, 0.015, 0.017),
(16, 'Concrete - Unfinished steel form', 0.012, 0.013, 0.014),
(17, 'Concrete - Unfinished smooth wood form', 0.012, 0.014, 0.016),
(18, 'Concrete - Unfinished rough wood form', 0.015, 0.017, 0.02),
(19, 'Wood - Stave', 0.01, 0.012, 0.014),
(20, 'Wood - Laminated treated', 0.015, 0.017, 0.02),
(21, 'Clay - Common drainage tile', 0.011, 0.013, 0.017),
(22, 'Clay - Vitrified sewer', 0.011, 0.014, 0.017),
(23, 'Clay - Vitrified sewer with manholes inlet etc.', 0.013, 0.015, 0.017),
(24, 'Clay - Vitrified Subdrain with open joint', 0.014, 0.016, 0.018),
(25, 'Brickwork - Glazed', 0.011, 0.013, 0.015),
(26, 'Brickwork - Lined with cement mortar', 0.012, 0.015, 0.017),
(27, 'Brickwork - Sanitary sewers coated with sewage slime with bends and connections', 0.012, 0.013, 0.016),
(28, 'Brickwork - Paved invert sewer smooth bottom', 0.016, 0.019, 0.02),
(29, 'Brickwork - Rubble masonry cemented', 0.018, 0.025, 0.03),
(30, 'Plastic - Smooth', 0.011, 0.013, 0.015),
(31, 'Plastic - Corrugated', 0.02, 0.024, 0.028);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `manningsn`
--
ALTER TABLE `manningsn`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `manningsn`
--
ALTER TABLE `manningsn`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
