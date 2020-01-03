-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 03, 2020 at 06:38 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dailywagesdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `dw_payment_tracker`
--

CREATE TABLE IF NOT EXISTS `dw_payment_tracker` (
`DPT_ID` int(11) NOT NULL,
  `DPT_CREATION_DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `DPT_CREATED_BY` varchar(100) NOT NULL,
  `DPT_LAST_UPDATED_DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `DPT_LAST_UPDATED_BY` varchar(100) NOT NULL,
  `DPT_PAYMENT_DATE` date NOT NULL,
  `DPT_PAYMENT_MONTH` int(2) NOT NULL,
  `DPT_PAYMENT_YEAR` int(4) NOT NULL,
  `DPT_TOTAL_DAYS_WORKED` int(11) NOT NULL,
  `DPT_TOTAL_GW_HRS` int(11) NOT NULL,
  `TOTAL_DEDUCTION` float NOT NULL,
  `DPT_NET_WAGES_PAID` float NOT NULL,
  `DPT_INVOICE_NO` text NOT NULL,
  `DPT_STATUS` int(11) NOT NULL,
  `DEM_EMP_ID` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dw_payment_tracker`
--
ALTER TABLE `dw_payment_tracker`
 ADD PRIMARY KEY (`DPT_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dw_payment_tracker`
--
ALTER TABLE `dw_payment_tracker`
MODIFY `DPT_ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
