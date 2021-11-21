-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 22, 2018 at 12:33 AM
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
-- Table structure for table `polynomialcoefficient`
--

CREATE TABLE `polynomialcoefficient` (
  `id` int(11) NOT NULL,
  `inlettype` varchar(250) NOT NULL,
  `inletconfig` varchar(250) NOT NULL,
  `Ke` float NOT NULL,
  `SR` float NOT NULL,
  `A` float NOT NULL,
  `BS` float NOT NULL,
  `C` float NOT NULL,
  `DIP` float NOT NULL,
  `EE` float NOT NULL,
  `F` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `polynomialcoefficient`
--

INSERT INTO `polynomialcoefficient` (`id`, `inlettype`, `inletconfig`, `Ke`, `SR`, `A`, `BS`, `C`, `DIP`, `EE`, `F`) VALUES
(1, 'Circular', 'Thin Edge Projecting', 0.9, 0.5, 0.187321, 0.56771, -0.156544, 0.0447052, 0.00343602, 0.000089661),
(2, 'Circular', 'Mitered to Conform to Slop ', 0.7, 0.7, 0.107137, 0.757789, -0.361462, 0.123393, 0.0160642, 0.00076739),
(3, 'Circular', 'Square Edge with Headwall (Steel/Aluminum/ Corrugated PE)', 0.5, 0.5, 0.167433, 0.538595, -0.149374, 0.0391543, 0.00343974, 0.000115882),
(4, 'Circular', 'Grooved End Projecting', 0.2, 0.5, 0.108786, 0.662381, -0.233801, 0.0579585, 0.0055789, 0.000205052),
(5, 'Circular', 'Grooved End in Headwall', 0.2, 0.5, 0.114099, 0.653562, -0.233615, 0.0597723, 0.00616338, 0.000242832),
(6, 'Circular', 'Beveled Edge (1:1)', 0.2, 0.5, 0.063343, 0.766512, -0.316097, 0.0876701, 0.00983695, 0.00041676),
(7, 'Circular', 'Beveled Edge (1.5:1)', 0.2, 0.5, 0.08173, 0.698353, -0.253683, 0.065125, 0.0071975, 0.000312451),
(8, 'Circular', 'Square Projection', 0.2, 0.5, 0.167287, 0.558766, -0.159813, 0.0420069, 0.00369252, 0.000125169),
(9, 'Circular', 'Square Edge with Headwall (Concrete/PVC/H DPE)', 0.5, 0.5, 0.087483, 0.706578, -0.253295, 0.0667001, 0.00661651, 0.000250619),
(10, 'Circular', 'End Section', 0.4, 0.5, 0.120659, 0.630768, -0.218423, 0.0591815, 0.00599169, 0.000229287),
(11, 'Circular', '20% Embedded Projecting End Pond', 1, 0.5, 0.0608835, 0.485734, 0.138194, 0.0275392, -0.00214547, 0.0000642769),
(12, 'Circular', '40% Embedded Projecting End Pond', 1, 0.5, 0.0888878, 0.431529, 0.0738665, 0.01592, -0.0010339, 0.0000262133),
(13, 'Circular', '50% Embedded Projecting End Pond', 1, 0.5, 0.0472951, 0.598794, 0.191732, 0.0480749, -0.00424418, 0.000141153),
(14, 'Circular', '20% Embedded Square Headwall', 0.55, 0.5, 0.0899368, 0.363047, 0.0683746, 0.0109594, -0.000706536, 0.0000189546),
(15, 'Circular', '40% Embedded Square Headwall', 0.55, 0.5, 0.0742985, 0.427366, 0.0849121, 0.0157965, -0.00102652, 0.0000260156),
(16, 'Circular', '50% Embedded Square Headwall', 0.55, 0.5, 0.212469, 0.511462, 0.1742, 0.0410961, -0.0036631, 0.000123085),
(17, 'Circular', '20% Embedded 45 degree Beveled End', 0.35, 0.5, 0.0795781, 0.37332, 0.0821509, 0.0148671, -0.00121877, 0.0000406896),
(18, 'Circular', '40% Embedded 45 degree Beveled End', 0.35, 0.5, 0.084574, 0.389114, 0.0685091, 0.011719, -0.00079044, 0.0000226454),
(19, 'Circular', '50% Embedded 45 degree Beveled End', 0.35, 0.5, 0.0732498, 0.426296, 0.082531, 0.0158108, -0.00103587, 0.0000265873),
(20, 'Circular', '20% Embedded Mitered End 1.5H:1V', 0.9, 0.5, 0.0750188, 0.404533, 0.0959306, 0.0172403, -0.00121896, 0.0000338252),
(21, 'Circular', '40% Embedded Mitered End 1.5H:1V', 0.9, 0.5, 0.0868199, 0.362177, 0.0483093, 0.00870598, -0.000359507, 0.00000289144),
(22, 'Circular', '50% Embedded Mitered End 1.5H:1V', 0.9, 0.5, 0.0344461, 0.574817, 0.204079, 0.0492722, -0.00436372, 0.000144795),
(23, 'Rectangular', 'Square Edge (90 degree) Headwall Square Edge (90 & 15 degree flare) Wingwall', 0.5, 0.5, 0.122117, 0.505435, 0.10856, 0.0207809, 0.00136757, 0.00003456),
(24, 'Rectangular', '1.5:1 Bevel (90 degree) Headwall 1.5:1 Bevel (19-34 degree flare) Wingwall', 0.2, 0.5, 0.106759, 0.455157, 0.0812895, 0.0121558, 0.00067794, 0.0000148),
(25, 'Rectangular', '1:1 Bevel Headwall', 0.2, 0.5, 0.166609, 0.398935, 0.0640392, 0.0112014, 0.0006449, 0.000014566),
(26, 'Rectangular', 'Square Edge (30- 75 degree flare) Wingwall', 0.4, 0.5, 0.0724927, 0.507087, 0.117474, 0.0221702, 0.00148958, 0.000038),
(27, 'Rectangular', 'Square Edge (0 degree flare) Wingwall', 0.7, 0.5, 0.144133, 0.461363, 0.0921507, 0.0200028, 0.00136449, 0.0000358),
(28, 'Rectangular', '1:1 Bevel (45 degree flare) Wingwall', 0.2, 0.5, 0.0995633, 0.441247, 0.0743498, 0.0127318, 0.0007588, 0.00001774);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `polynomialcoefficient`
--
ALTER TABLE `polynomialcoefficient`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `polynomialcoefficient`
--
ALTER TABLE `polynomialcoefficient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
