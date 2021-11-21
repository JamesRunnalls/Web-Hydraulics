-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 14, 2018 at 01:09 AM
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
-- Table structure for table `inletcontrolcoefficients`
--

CREATE TABLE `inletcontrolcoefficients` (
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
  `F` float NOT NULL,
  `Form` int(11) NOT NULL,
  `K` float NOT NULL,
  `M` float NOT NULL,
  `CS` float NOT NULL,
  `Y` float NOT NULL,
  `Source` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inletcontrolcoefficients`
--

INSERT INTO `inletcontrolcoefficients` (`id`, `inlettype`, `inletconfig`, `Ke`, `SR`, `A`, `BS`, `C`, `DIP`, `EE`, `F`, `Form`, `K`, `M`, `CS`, `Y`, `Source`) VALUES
(1, 'Circular', 'Thin Edge Projecting', 0.9, 0.5, 0.187321, 0.56771, -0.156544, 0.0447052, 0.00343602, 0.000089661, 1, 0.034, 1.5, 0.0553, 0.54, 'HDS-5 & HY8'),
(2, 'Circular', 'Mitered to Conform to Slope', 0.7, 0.7, 0.107137, 0.757789, -0.361462, 0.123393, 0.0160642, 0.00076739, 1, 0.021, 1.33, 0.0463, 0.75, 'HDS-5 & HY8'),
(3, 'Circular', 'Square Edge with Headwall (Steel/Aluminum/ Corrugated PE)', 0.5, 0.5, 0.167433, 0.538595, -0.149374, 0.0391543, 0.00343974, 0.000115882, 1, 0.0078, 2, 0.0379, 0.69, 'Norman et al., 2001 & HY8'),
(4, 'Circular', 'Grooved End Projecting', 0.2, 0.5, 0.108786, 0.662381, -0.233801, 0.0579585, 0.0055789, 0.000205052, 1, 0.0045, 2, 0.0317, 0.69, 'HDS-5 & HY8'),
(5, 'Circular', 'Grooved End in Headwall', 0.2, 0.5, 0.114099, 0.653562, -0.233615, 0.0597723, 0.00616338, 0.000242832, 1, 0.0018, 2, 0.0292, 0.74, 'HDS-5 & HY8'),
(6, 'Circular', 'Beveled Edge (1:1)', 0.2, 0.5, 0.063343, 0.766512, -0.316097, 0.0876701, 0.00983695, 0.00041676, 1, 0.0018, 2.5, 0.03, 0.74, 'HDS-5 & HY8'),
(7, 'Circular', 'Beveled Edge (1.5:1)', 0.2, 0.5, 0.08173, 0.698353, -0.253683, 0.065125, 0.0071975, 0.000312451, 1, 0.0018, 2.5, 0.0243, 0.83, 'HDS-5 & HY8'),
(8, 'Circular', 'Square Edge with Headwall (Concrete/PVC/H DPE)', 0.5, 0.5, 0.087483, 0.706578, -0.253295, 0.0667001, 0.00661651, 0.000250619, 1, 0.0098, 2, 0.0398, 0.67, 'HDS-5 & HY8'),
(9, 'Circular', '20% Embedded Projecting End Pond', 1, 0.5, 0.0608835, 0.485734, 0.138194, 0.0275392, -0.00214547, 0.0000642769, 1, 0.086, 0.58, 0.0303, 0.58, 'NCHRP Report 734 & HY8'),
(10, 'Circular', '40% Embedded Projecting End Pond', 1, 0.5, 0.0888878, 0.431529, 0.0738665, 0.01592, -0.0010339, 0.0000262133, 1, 0.084, 0.76, 0.0453, 0.69, 'NCHRP Report 734 & HY8'),
(11, 'Circular', '50% Embedded Projecting End Pond', 1, 0.5, 0.0472951, 0.598794, 0.191732, 0.0480749, -0.00424418, 0.000141153, 1, 0.1057, 0.69, 0.0606, 0.54, 'NCHRP Report 734 & HY8'),
(12, 'Circular', '20% Embedded Square Headwall', 0.55, 0.5, 0.0899368, 0.363047, 0.0683746, 0.0109594, -0.000706535, 0.0000189546, 1, 0.0566, 0.44, 0.0198, 0.69, 'NCHRP Report 734 & HY8'),
(13, 'Circular', '40% Embedded Square Headwall', 0.55, 0.5, 0.0742985, 0.427366, 0.0849121, 0.0157965, -0.00102652, 0.0000260156, 1, 0.049, 0.71, 0.0332, 0.67, 'NCHRP Report 734 & HY8'),
(14, 'Circular', '50% Embedded Square Headwall', 0.55, 0.5, 0.212469, 0.511462, 0.1742, 0.0410961, -0.0036631, 0.000123085, 1, 0.0595, 0.59, 0.0402, 0.65, 'NCHRP Report 734 & HY8'),
(15, 'Circular', '20% Embedded 45 degree Beveled End', 0.35, 0.5, 0.0795781, 0.37332, 0.0821509, 0.0148671, -0.00121877, 0.0000406896, 1, 0.0292, 0.57, 0.0161, 0.73, 'NCHRP Report 734 & HY8'),
(16, 'Circular', '40% Embedded 45 degree Beveled End', 0.35, 0.5, 0.084574, 0.389114, 0.0685091, 0.011719, -0.00079044, 0.0000226454, 1, 0.0358, 0.62, 0.0245, 0.75, 'NCHRP Report 734 & HY8'),
(17, 'Circular', '50% Embedded 45 degree Beveled End', 0.35, 0.5, 0.0732498, 0.426296, 0.082531, 0.0158108, -0.00103587, 0.0000265873, 1, 0.0464, 0.46, 0.0324, 0.67, 'NCHRP Report 734 & HY8'),
(18, 'Circular', '20% Embedded Mitered End 1.5H:1V', 0.9, 0.5, 0.0750188, 0.404533, 0.0959306, 0.0172403, -0.00121896, 0.0000338252, 1, 0.0431, 0.58, 0.0235, 0.61, 'NCHRP Report 734 & HY8'),
(19, 'Circular', '40% Embedded Mitered End 1.5H:1V', 0.9, 0.5, 0.0868199, 0.362177, 0.0483093, 0.00870598, -0.000359507, 0.00000289144, 1, 0.0317, 0.77, 0.0363, 0.65, 'NCHRP Report 734 & HY8'),
(20, 'Circular', '50% Embedded Mitered End 1.5H:1V', 0.9, 0.5, 0.0344461, 0.574817, 0.204079, 0.0492722, -0.00436372, 0.000144795, 1, 0.0351, 0.59, 0.0504, 0.44, 'NCHRP Report 734 & HY8'),
(21, 'Rectangular', 'Square Edge (90 degree) Headwall Square Edge (90 & 15 degree flare) Wingwall', 0.5, 0.5, 0.122117, 0.505435, 0.10856, 0.0207809, 0.00136757, 0.00003456, 1, 0.061, 0.75, 0.04, 0.8, 'HDS-5 & HY8'),
(22, 'Rectangular', 'Square Edge (30- 75 degree flare) Wingwall', 0.4, 0.5, 0.0724927, 0.507087, 0.117474, 0.0221702, 0.00148958, 0.000038, 1, 0.026, 1, 0.0347, 0.81, 'HDS-5 & HY8'),
(23, 'Rectangular', 'Square Edge (0 degree flare) Wingwall', 0.7, 0.5, 0.144133, 0.461363, 0.0921507, 0.0200028, 0.00136449, 0.0000358, 1, 0.061, 0.75, 0.0423, 0.82, 'HDS-5 & HY8'),
(24, 'Rectangular', '1:1 Bevel (45 degree flare) Wingwall', 0.2, 0.5, 0.0995633, 0.441247, 0.0743498, 0.0127318, 0.0007588, 0.00001774, 2, 0.497, 0.667, 0.0302, 0.835, 'HDS-5 & HY8');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `inletcontrolcoefficients`
--
ALTER TABLE `inletcontrolcoefficients`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `inletcontrolcoefficients`
--
ALTER TABLE `inletcontrolcoefficients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
