-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 03, 2020 at 06:35 AM
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
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
`ad_id` int(11) NOT NULL,
  `ad_usertype` int(11) NOT NULL,
  `full_name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `ad_username` text COLLATE utf8_unicode_ci NOT NULL,
  `ad_phone` text COLLATE utf8_unicode_ci NOT NULL,
  `altmobno` text COLLATE utf8_unicode_ci NOT NULL,
  `ad_email` text COLLATE utf8_unicode_ci NOT NULL,
  `ad_password` text COLLATE utf8_unicode_ci NOT NULL,
  `ad_profile` text COLLATE utf8_unicode_ci NOT NULL,
  `ad_adddate` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`ad_id`, `ad_usertype`, `full_name`, `ad_username`, `ad_phone`, `altmobno`, `ad_email`, `ad_password`, `ad_profile`, `ad_adddate`) VALUES
(1, 1, 'ADMIN', 'admin', '1234567890', '1234567890', 'ex@gmail.com', 'admin', '1.jpg', '2018-10-13');

-- --------------------------------------------------------

--
-- Table structure for table `dw_employee_master`
--

CREATE TABLE IF NOT EXISTS `dw_employee_master` (
`DEM_ID` int(100) NOT NULL,
  `DEM_EMP_ID` varchar(100) NOT NULL,
  `DEM_EMP_NAME_PREFIX` varchar(10) NOT NULL,
  `DEM_EMP_FIRST_NAME` varchar(100) NOT NULL,
  `DEM_EMP_MIDDLE_NAME` varchar(100) NOT NULL,
  `DEM_EMP_LAST_NAME` varchar(100) NOT NULL,
  `DEM_EMP_GENDER` varchar(10) NOT NULL,
  `DEM_EMP_DOB` date NOT NULL,
  `DEM_EMP_AGE` int(11) NOT NULL,
  `DEM_PERMANENT_ADDRESS` varchar(500) NOT NULL,
  `DEM_PA_PINCODE` int(10) NOT NULL,
  `DEM_CURRRENT_ADDRESS` varchar(500) NOT NULL,
  `DEM_CA_PINCODE` int(10) NOT NULL,
  `DEM_MOBILE_NUMBER` int(10) NOT NULL,
  `DEM_ALTERNATE_MOBILE_NUMBER` int(20) NOT NULL,
  `DEM_PERSONAL_EMAIL_ID` varchar(100) NOT NULL,
  `DEM_OFFICIAL_EMAIL_ID` varchar(100) NOT NULL,
  `DEM_START_DATE` date NOT NULL,
  `DEM_END_DATE` date NOT NULL,
  `DEM_ACTIVE_FLAG` varchar(10) NOT NULL,
  `DEM_CREATION_DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `DEM_CREATED_BY` varchar(100) NOT NULL,
  `DEM_LAST_UPDATED_DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `DEM_LAST_UPDATED_BY` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dw_employee_master`
--

INSERT INTO `dw_employee_master` (`DEM_ID`, `DEM_EMP_ID`, `DEM_EMP_NAME_PREFIX`, `DEM_EMP_FIRST_NAME`, `DEM_EMP_MIDDLE_NAME`, `DEM_EMP_LAST_NAME`, `DEM_EMP_GENDER`, `DEM_EMP_DOB`, `DEM_EMP_AGE`, `DEM_PERMANENT_ADDRESS`, `DEM_PA_PINCODE`, `DEM_CURRRENT_ADDRESS`, `DEM_CA_PINCODE`, `DEM_MOBILE_NUMBER`, `DEM_ALTERNATE_MOBILE_NUMBER`, `DEM_PERSONAL_EMAIL_ID`, `DEM_OFFICIAL_EMAIL_ID`, `DEM_START_DATE`, `DEM_END_DATE`, `DEM_ACTIVE_FLAG`, `DEM_CREATION_DATE`, `DEM_CREATED_BY`, `DEM_LAST_UPDATED_DATE`, `DEM_LAST_UPDATED_BY`) VALUES
(1, 'DW19101', 'MR.', 'AKSHAY', 'M', 'NAIR', 'MALE', '1996-11-07', 23, 'Shankarnagar', 431736, 'ssss', 321555, 1651556545, 2147483647, 'akshaynair971@gmail.com', 'akshaynair971@gmail.com', '2019-10-03', '2019-10-03', 'ACTIVE', '0000-00-00 00:00:00', '1', '2019-12-17 04:13:13', '1'),
(2, 'DW19102', 'MR.', 'PRAVIN', 'RAVINDRA', 'ROY', 'MALE', '1989-09-21', 30, 'Shankarnagar', 431736, 'd', 15212, 2147483647, 2147483647, 'pravin@gmail.com', 'pravin@gmail.com', '2019-10-03', '2019-10-03', 'ACTIVE', '0000-00-00 00:00:00', '1', '2019-12-17 04:12:01', '1'),
(3, 'DW19103', 'MR.', 'MADHAV', 'EX', 'SIR', 'MALE', '1989-10-31', 30, 'Shankarnagar', 431736, 'CSCS', 454554, 1154545545, 2147483647, 'madhav@gg.c', 'madhav@GG.V', '2019-10-03', '2019-10-03', 'ACTIVE', '0000-00-00 00:00:00', '1', '2019-12-17 04:10:14', '1'),
(4, 'DW19104', 'MR.', 'RAJA', 'RAM', 'SALVI', 'MALE', '1971-10-21', 48, 'scsdc', 456456, 'xdscscq', 555555, 2147483647, 2147483647, 'raja@gmail.com', 'raja@gmail.com', '2019-10-03', '2019-10-03', 'ACTIVE', '2019-10-03 03:53:47', '1', '2019-12-17 04:08:12', '1'),
(5, 'DW19105', 'MR.', 'ABHIJEET', 'RAMESH', 'RAWLE', 'MALE', '1987-01-29', 32, 'SHANKARNAGAR', 431736, 'SHANKARNAGAR', 431736, 2147483647, 2147483647, 'abhi@gmail.com', 'abhi@gmail.com', '2019-10-02', '0000-00-00', 'ACTIVE', '2019-10-14 14:40:04', '1', '2019-12-17 04:01:14', '1');

-- --------------------------------------------------------

--
-- Table structure for table `dw_emp_attendance`
--

CREATE TABLE IF NOT EXISTS `dw_emp_attendance` (
`DEA_ID` int(11) NOT NULL,
  `DEA_CREATION_DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `DEA_CREATION_BY` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `DEA_LAST_UPDATED_DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `DPT_LAST_UPDATED_BY` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `DEA_ATTD_DATE` date NOT NULL,
  `DEA_ATTD_MONTH` int(11) NOT NULL,
  `DEA_ATTD_YEAR` int(11) NOT NULL,
  `DEA_IN_TIME` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `DEA_OUT_TIME` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `DEA_CURRENT_LOCATION` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `DEA_REMARK` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `DEA_SIGN` blob NOT NULL,
  `DEA_LATITUDE` text COLLATE utf8_unicode_ci NOT NULL,
  `DEA_LONGITUDE` text COLLATE utf8_unicode_ci NOT NULL,
  `DEA_STATUS` int(11) NOT NULL,
  `DEM_EMPLOYEE_ID` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dw_emp_attendance`
--

INSERT INTO `dw_emp_attendance` (`DEA_ID`, `DEA_CREATION_DATE`, `DEA_CREATION_BY`, `DEA_LAST_UPDATED_DATE`, `DPT_LAST_UPDATED_BY`, `DEA_ATTD_DATE`, `DEA_ATTD_MONTH`, `DEA_ATTD_YEAR`, `DEA_IN_TIME`, `DEA_OUT_TIME`, `DEA_CURRENT_LOCATION`, `DEA_REMARK`, `DEA_SIGN`, `DEA_LATITUDE`, `DEA_LONGITUDE`, `DEA_STATUS`, `DEM_EMPLOYEE_ID`) VALUES
(1, '2019-11-25 17:46:44', '1', '2019-11-26 20:48:37', '1', '2019-11-01', 11, 2019, '1:16 PM', '6:16 PM', 'OFFICE', 'qwe', 0x717765, '', '', 0, 'DW19101'),
(2, '2019-11-25 17:47:18', '1', '2019-11-26 20:48:37', '1', '2019-11-02', 11, 2019, '1:16 PM', '11:17 PM', 'CUSTOMER SITE', 'aaa', 0x616161, '', '', 0, 'DW19101'),
(3, '2019-11-25 17:49:06', '1', '2019-11-26 20:48:37', '1', '2019-11-03', 11, 2019, '2:18 PM', '12:18 PM', 'OFFICE', 'asd', 0x617364, '', '', 0, 'DW19101'),
(4, '2019-11-25 17:50:03', '1', '2019-11-26 20:48:37', '1', '2019-11-04', 11, 2019, '5:19 PM', '11:19 PM', 'PERSONAL LEAVE', 'rew', 0x726577, '', '', 0, 'DW19101'),
(5, '2019-11-25 17:51:16', '1', '2019-11-26 20:48:37', '1', '2019-11-05', 11, 2019, '5:20 PM', '7:20 PM', 'CASUAL LEAVE', 'zxc', 0x7a7863, '', '', 0, 'DW19101'),
(6, '2019-11-25 17:52:16', '1', '2019-11-26 20:48:37', '1', '2019-11-14', 11, 2019, '10:13 PM', '3:13 PM', 'OFFICE', 'ss', 0x7373, '', '', 0, 'DW19101'),
(7, '2019-11-25 18:13:04', '1', '2019-11-26 20:48:37', '1', '2019-11-06', 11, 2019, '6:42 PM', '10:42 PM', 'PERSONAL LEAVE', 'qwer', 0x71776572, '', '', 0, 'DW19101'),
(8, '2019-11-25 18:14:28', '1', '2019-11-25 18:14:28', '1', '2019-11-01', 11, 2019, '5:44 PM', '9:44 PM', 'CASUAL LEAVE', 'wqe', 0x777165, '', '', 1, 'DW19101'),
(9, '2019-11-25 18:16:14', '1', '2019-11-25 18:16:14', '1', '2019-11-01', 11, 2019, '11:45 PM', '4:45 PM', 'SICK LEAVE', 'qaz', 0x71617a, '', '', 1, 'DW19101'),
(10, '2019-11-25 18:18:34', '1', '2019-11-26 20:48:37', '1', '2019-11-07', 11, 2019, '5:48 PM', '11:48 PM', 'PERSONAL LEAVE', 'xzc', 0x787a63, '', '', 0, 'DW19101'),
(14, '2019-11-26 18:36:36', '1', '2019-11-26 20:48:37', '1', '2019-11-11', 11, 2019, '3:06 AM', '10:06 AM', 'CUSTOMER SITE', 'ewq', 0x657771, '', '', 0, 'DW19101'),
(11, '2019-11-25 18:51:20', '1', '2019-11-26 20:48:37', '1', '2019-11-08', 11, 2019, '3:20 AM', '10:21 AM', 'SICK LEAVE', 'ccc', 0x636363, '', '', 0, 'DW19101'),
(12, '2019-11-25 18:53:32', '1', '2019-11-26 20:48:37', '1', '2019-11-09', 11, 2019, '4:23 AM', '12:23 AM', 'CASUAL LEAVE', 'weqw', 0x77657165, '', '', 0, 'DW19101'),
(13, '2019-11-26 18:34:38', '1', '2019-11-26 20:48:37', '1', '2019-11-10', 11, 2019, '3:04 AM', '11:04 AM', 'OFFICE', 'www', 0x777777, '', '', 0, 'DW19101'),
(15, '2019-11-26 20:18:30', '1', '2019-11-26 20:48:37', '1', '2019-11-12', 11, 2019, '2:48 AM', '11:48 AM', 'CUSTOMER SITE', 'fff', 0x666666, '', '', 0, 'DW19101'),
(16, '2019-11-26 20:51:42', '1', '2019-11-26 20:54:30', '1', '2019-11-13', 11, 2019, '2:21 AM', '10:21 AM', 'PERSONAL LEAVE', 'xxx', 0x787878, '', '', 0, 'DW19101'),
(17, '2019-11-26 20:52:43', '1', '2019-11-26 20:54:30', '1', '2019-11-15', 11, 2019, '2:22 AM', '11:30 AM', 'SICK LEAVE', 'qwee', 0x71776565, '', '', 0, 'DW19101'),
(18, '2019-11-26 20:54:30', '1', '2019-11-26 20:54:30', '1', '2019-11-16', 11, 2019, '2:24 AM', '6:24 AM', 'PERSONAL LEAVE', 'sdfsd', 0x7364666473, '', '', 0, 'DW19101'),
(19, '2019-11-26 20:56:22', '1', '2019-11-26 20:56:29', '1', '2019-11-17', 11, 2019, '2:26 AM', '11:26 AM', 'CASUAL LEAVE', 'adas', 0x6173647361, '', '', 0, 'DW19101'),
(20, '2019-11-27 19:40:50', '1', '2019-11-27 20:32:36', '1', '2019-11-18', 11, 2019, '1:10 AM', '10:10 AM', 'OFFICE', 'eee', 0x656565, '', '', 0, 'DW19101'),
(21, '2019-11-27 20:33:36', '1', '2019-11-27 20:33:59', '1', '2019-11-19', 11, 2019, '2:03 AM', '11:03 AM', 'SICK LEAVE', 'zxcx', 0x7a7863787a, '', '', 0, 'DW19101'),
(22, '2019-12-09 04:07:20', '1', '2019-12-09 04:07:44', '1', '2019-11-01', 11, 2019, '9:37 AM', '9:37 PM', 'OFFICE', 'ccc', 0x616161, '', '', 0, 'DW19103'),
(23, '2019-12-09 04:07:44', '1', '2019-12-09 04:07:44', '1', '2019-11-03', 11, 2019, '9:37 AM', '9:37 PM', 'WEAKLY OFF', 'aa', 0x6161, '', '', 0, 'DW19103');

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
-- Dumping data for table `dw_payment_tracker`
--

INSERT INTO `dw_payment_tracker` (`DPT_ID`, `DPT_CREATION_DATE`, `DPT_CREATED_BY`, `DPT_LAST_UPDATED_DATE`, `DPT_LAST_UPDATED_BY`, `DPT_PAYMENT_DATE`, `DPT_PAYMENT_MONTH`, `DPT_PAYMENT_YEAR`, `DPT_TOTAL_DAYS_WORKED`, `DPT_TOTAL_GW_HRS`, `TOTAL_DEDUCTION`, `DPT_NET_WAGES_PAID`, `DPT_INVOICE_NO`, `DPT_STATUS`, `DEM_EMP_ID`) VALUES
(2, '2019-10-19 15:03:34', '1', '2019-11-22 19:04:30', '1', '2019-10-16', 10, 2019, 9, 5, 23634, 64262, 'qq', 0, 'DW19101'),
(3, '2019-10-22 19:22:37', '1', '2019-11-22 19:04:30', '1', '2019-01-10', 1, 2019, 1, 4, 23634, 64262, 'ggg', 0, 'DW19101'),
(4, '2019-10-23 02:14:23', '1', '2019-11-22 19:04:30', '1', '2019-02-22', 2, 2019, 1, 6, 23634, 64262, '5', 0, 'DW19101'),
(5, '2019-12-09 05:01:48', '1', '2019-12-09 05:04:27', '1', '2019-12-11', 11, 2019, 21, 3, 23634, 64262, 'qrre', 1, 'DW19101');

-- --------------------------------------------------------

--
-- Table structure for table `dw_payroll_history`
--

CREATE TABLE IF NOT EXISTS `dw_payroll_history` (
`DPM_ID` int(11) NOT NULL,
  `DPM_CREATION_DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `DPM_CREATED_BY` varchar(100) NOT NULL,
  `DPM_LAST_UPDATAED_DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `DPM_LAST_UPDATED_BY` varchar(100) NOT NULL,
  `DPM_RATE` float NOT NULL,
  `DPM_VALID_FROM` text NOT NULL,
  `DPM_VALID_TO` text NOT NULL,
  `DPM_BASIC_SALARY` float NOT NULL,
  `DPM_HRA` varchar(100) NOT NULL,
  `DPM_OTHER_ALLOWANCE` float NOT NULL,
  `DPM_SPECIAL_ALLOWANCE` float NOT NULL,
  `DPM_GROSS_WAGES_PAYABLE` float NOT NULL,
  `DPM_PROFESSIONAL_TAX` float NOT NULL,
  `DPM_PF_EMPLOYEE` float NOT NULL,
  `DPM_PF_EMPLOYER` float NOT NULL,
  `DPM_ESIC_EMPLOYEE` float NOT NULL,
  `DPM_ESIC_EMPLOYER` float NOT NULL,
  `DPM_CALCULATED_AMOUNT` float NOT NULL,
  `DEM_EMP_ID` varchar(100) NOT NULL,
  `DUL_USER_ID` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dw_payroll_history`
--

INSERT INTO `dw_payroll_history` (`DPM_ID`, `DPM_CREATION_DATE`, `DPM_CREATED_BY`, `DPM_LAST_UPDATAED_DATE`, `DPM_LAST_UPDATED_BY`, `DPM_RATE`, `DPM_VALID_FROM`, `DPM_VALID_TO`, `DPM_BASIC_SALARY`, `DPM_HRA`, `DPM_OTHER_ALLOWANCE`, `DPM_SPECIAL_ALLOWANCE`, `DPM_GROSS_WAGES_PAYABLE`, `DPM_PROFESSIONAL_TAX`, `DPM_PF_EMPLOYEE`, `DPM_PF_EMPLOYER`, `DPM_ESIC_EMPLOYEE`, `DPM_ESIC_EMPLOYER`, `DPM_CALCULATED_AMOUNT`, `DEM_EMP_ID`, `DUL_USER_ID`) VALUES
(1, '2019-12-17 04:01:15', '1', '2019-12-17 04:01:15', '1', 0, '2019-01-01', '2019-12-31', 14125, '3531', 100, 0, 17756, 200, 1695, 1695, 105.938, 459.062, 13601, 'DW19105', 0),
(2, '2019-12-17 04:06:37', '1', '2019-12-17 04:06:37', '1', 0, '2019-01-01', '2019-12-31', 14125, '3531', 100, 0, 17756, 200, 1695, 1695, 106, 459, 13601, 'DW19105', 0),
(3, '2019-12-17 04:08:13', '1', '2019-12-17 04:08:13', '1', 0, '2019-01-01', '2019-12-31', 14125, '3531', 100, 0, 17756, 200, 1695, 1695, 106, 459, 13601, 'DW19104', 0),
(4, '2019-12-17 04:09:51', '1', '2019-12-17 04:09:51', '1', 0, '2019-01-01', '2019-12-31', 14125, '3531', 100, 0, 17756, 200, 1695, 1695, 106, 459, 13601, 'DW19103', 0),
(5, '2019-12-17 04:12:01', '1', '2019-12-17 04:12:01', '1', 0, '2019-01-01', '2019-12-31', 14125, '3135', 100, 0, 17360, 200, 1695, 1695, 106, 459, 13205, 'DW19102', 0),
(6, '2019-12-17 04:13:13', '1', '2019-12-17 04:13:13', '1', 0, '2019-01-01', '2019-12-31', 14125, '3135', 100, 0, 17360, 200, 1695, 1695, 106, 459, 13205, 'DW19101', 0);

-- --------------------------------------------------------

--
-- Table structure for table `dw_payroll_master`
--

CREATE TABLE IF NOT EXISTS `dw_payroll_master` (
`DPM_ID` int(11) NOT NULL,
  `DPM_CREATION_DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `DPM_CREATED_BY` varchar(100) NOT NULL,
  `DPM_LAST_UPDATAED_DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `DPM_LAST_UPDATED_BY` varchar(100) NOT NULL,
  `DPM_RATE` float NOT NULL,
  `DPM_VALID_FROM` text NOT NULL,
  `DPM_VALID_TO` text NOT NULL,
  `DPM_BASIC_SALARY` float NOT NULL,
  `DPM_HRA` varchar(100) NOT NULL,
  `DPM_OTHER_ALLOWANCE` float NOT NULL,
  `DPM_SPECIAL_ALLOWANCE` float NOT NULL,
  `DPM_GROSS_WAGES_PAYABLE` float NOT NULL,
  `DPM_PROFESSIONAL_TAX` float NOT NULL,
  `DPM_PF_EMPLOYEE` float NOT NULL,
  `DPM_PF_EMPLOYER` float NOT NULL,
  `DPM_ESIC_EMPLOYEE` float NOT NULL,
  `DPM_ESIC_EMPLOYER` float NOT NULL,
  `DPM_CALCULATED_AMOUNT` float NOT NULL,
  `DEM_EMP_ID` varchar(100) NOT NULL,
  `DUL_USER_ID` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dw_payroll_master`
--

INSERT INTO `dw_payroll_master` (`DPM_ID`, `DPM_CREATION_DATE`, `DPM_CREATED_BY`, `DPM_LAST_UPDATAED_DATE`, `DPM_LAST_UPDATED_BY`, `DPM_RATE`, `DPM_VALID_FROM`, `DPM_VALID_TO`, `DPM_BASIC_SALARY`, `DPM_HRA`, `DPM_OTHER_ALLOWANCE`, `DPM_SPECIAL_ALLOWANCE`, `DPM_GROSS_WAGES_PAYABLE`, `DPM_PROFESSIONAL_TAX`, `DPM_PF_EMPLOYEE`, `DPM_PF_EMPLOYER`, `DPM_ESIC_EMPLOYEE`, `DPM_ESIC_EMPLOYER`, `DPM_CALCULATED_AMOUNT`, `DEM_EMP_ID`, `DUL_USER_ID`) VALUES
(1, '0000-00-00 00:00:00', '1', '2019-12-17 04:13:13', '1', 0, '2019-01-01', '2019-12-31', 14125, '3135', 100, 0, 17360, 200, 1695, 1695, 106, 459, 13205, 'DW19101', 1),
(2, '0000-00-00 00:00:00', '1', '2019-12-17 04:12:02', '1', 0, '2019-01-01', '2019-12-31', 14125, '3135', 100, 0, 17360, 200, 1695, 1695, 106, 459, 13205, 'DW19102', 2),
(3, '0000-00-00 00:00:00', '1', '2019-12-17 04:09:52', '1', 0, '2019-01-01', '2019-12-31', 14125, '3531', 100, 0, 17756, 200, 1695, 1695, 106, 459, 13601, 'DW19103', 3),
(4, '0000-00-00 00:00:00', '1', '2019-12-17 04:08:13', '1', 0, '2019-01-01', '2019-12-31', 14125, '3531', 100, 0, 17756, 200, 1695, 1695, 106, 459, 13601, 'DW19104', 4),
(5, '2019-10-14 14:40:04', '1', '2019-12-17 04:06:37', '1', 0, '2019-01-01', '2019-12-31', 14125, '3531', 100, 0, 17756, 200, 1695, 1695, 106, 459, 13601, 'DW19105', 5);

-- --------------------------------------------------------

--
-- Table structure for table `dw_user_login`
--

CREATE TABLE IF NOT EXISTS `dw_user_login` (
`DUL_USER_ID` int(100) NOT NULL,
  `DUL_USER_NAME` varchar(100) NOT NULL,
  `DUL_USER_PASSWORD` varchar(500) NOT NULL,
  `DUL_USER_ROLE` text NOT NULL,
  `DEM_EMP_ID` varchar(100) NOT NULL,
  `DUL_CREATION_DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `DUL_CREATED_BY` varchar(100) NOT NULL,
  `DUL_LAST_UPDATED_DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `DUL_LAST_UPDATED_BY` varchar(100) NOT NULL,
  `DUL_ACTIVE_FLAG` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dw_user_login`
--

INSERT INTO `dw_user_login` (`DUL_USER_ID`, `DUL_USER_NAME`, `DUL_USER_PASSWORD`, `DUL_USER_ROLE`, `DEM_EMP_ID`, `DUL_CREATION_DATE`, `DUL_CREATED_BY`, `DUL_LAST_UPDATED_DATE`, `DUL_LAST_UPDATED_BY`, `DUL_ACTIVE_FLAG`) VALUES
(1, 'asdf', 'asdf', 'permanant', 'DW19101', '2019-10-03 05:52:38', '1', '2019-10-10 19:37:32', '1', 'ACTIVE'),
(2, 'qwe', 'qwe', 'permanant', 'DW19102', '0000-00-00 00:00:00', '1', '2019-10-10 19:30:31', '1', 'ACTIVE'),
(3, 'WER', 'WER', 'contract', 'DW19103', '0000-00-00 00:00:00', '1', '2019-10-03 03:40:39', '1', 'ACTIVE'),
(4, 'raja', 'raja', 'permanant', 'DW19104', '0000-00-00 00:00:00', '1', '2019-12-17 04:08:13', '1', 'ACTIVE'),
(5, '1234', '1234', 'permanant', 'DW19105', '2019-10-14 14:40:04', '1', '2019-10-14 14:40:15', '1', 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `general_setting`
--

CREATE TABLE IF NOT EXISTS `general_setting` (
`gs_id` int(11) NOT NULL,
  `inst_id` int(11) NOT NULL,
  `user_type` int(11) NOT NULL,
  `ins_name` text NOT NULL,
  `ins_tagline` text NOT NULL,
  `ins_mob` text NOT NULL,
  `serial_no` text NOT NULL,
  `affiliate_no` text NOT NULL,
  `establishment_date` text NOT NULL,
  `udise_no` text NOT NULL,
  `school_board` text NOT NULL,
  `ins_address` text NOT NULL,
  `ins_logo` text NOT NULL,
  `terms_condi` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `general_setting`
--

INSERT INTO `general_setting` (`gs_id`, `inst_id`, `user_type`, `ins_name`, `ins_tagline`, `ins_mob`, `serial_no`, `affiliate_no`, `establishment_date`, `udise_no`, `school_board`, `ins_address`, `ins_logo`, `terms_condi`) VALUES
(1, 1, 1, 'Daily Wages', 'Daily Wages', '9876543210', '', '', '2019-09-29', '', '', 'Daily Wages', '1.jpg', 'Super Admin');

-- --------------------------------------------------------

--
-- Table structure for table `tab_allow_tbl`
--

CREATE TABLE IF NOT EXISTS `tab_allow_tbl` (
`tb_allow_id` int(100) NOT NULL,
  `tab_title` text NOT NULL,
  `tab_post_date` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tab_allow_tbl`
--

INSERT INTO `tab_allow_tbl` (`tb_allow_id`, `tab_title`, `tab_post_date`) VALUES
(1, 'Main Dashboard', '2019-03-02'),
(2, 'General Setting', '2019-03-02'),
(3, 'Change Password', '2019-03-02'),
(4, 'Academic Years', '2019-03-02'),
(5, 'Courses (Class)', '2019-03-02'),
(6, 'Board', '2019-03-02'),
(7, 'Sections', '2019-03-02'),
(8, 'Departments', '2019-03-02'),
(9, 'Designations / User', '2019-03-02'),
(10, 'Subjects', '2019-03-02'),
(11, 'Employee Subjects', '2019-03-02'),
(12, 'Add Institute', '2019-03-02'),
(13, 'Employees List', '2019-03-02'),
(14, 'Employee Attendance', '2019-03-02'),
(15, 'Leave Catagories', '2019-03-02'),
(16, 'Leave Requests', '2019-03-02'),
(17, 'Fee Catagory', '2019-03-02'),
(18, 'Student Fee Structure Year', '2019-03-02'),
(19, 'Student Register & Admission', '2019-03-02'),
(20, 'Student Admission Details', '2019-03-02'),
(21, 'Student Attendance', '2019-03-02'),
(22, 'Pay Student Fee', '2019-03-02'),
(23, 'Generate Salary', '2019-03-02'),
(24, 'Expense', '2019-03-02'),
(25, 'Monthly Salary Report', '2019-03-02'),
(26, 'Add Test Mark', '2019-03-02'),
(27, 'View Results', '2019-03-02'),
(28, 'Report Cards', '2019-03-02'),
(29, 'Drivers', '2019-03-02'),
(30, 'Vehicles', '2019-03-02'),
(31, 'Routes', '2019-03-02'),
(32, 'Vehicle/Route Allocation', '2019-03-02'),
(33, 'Student Attendance Report', '2019-03-02'),
(34, 'Student Payment Report', '2019-03-02'),
(35, 'Employee Attendance Report', '2019-03-02'),
(36, 'Add Home Work', '2019-03-02'),
(37, 'Home Work', '2019-03-02'),
(38, 'SMS General Setting', '2019-03-05'),
(39, 'Exam Time Table', '2019-04-05'),
(40, 'Lecture Time Table', '2019-04-05'),
(41, 'Assign Class Teacher', '2019-05-17'),
(42, 'Bonafide', '2019-05-17'),
(43, 'Nirgam Utara', '2019-05-17'),
(44, 'TC', '2019-05-17'),
(45, 'Identity Card', '2019-05-17'),
(46, 'Add New Caste', '2019-05-17'),
(47, 'Add New Caste Category', '2019-05-17'),
(48, 'Database Backup', '2015-05-20'),
(49, 'Add New Documents', '2019-05-21'),
(50, 'Opening Balance', '2016-05-22'),
(51, 'Add Categories', '2019-05-24'),
(52, 'Add Author', '2019-05-24'),
(53, 'Add New Book', '2019-05-24'),
(54, 'Issue Book', '2019-05-24'),
(55, 'Student Book Issue History', '2019-05-24'),
(56, 'Stock', ''),
(57, 'Uniform Stock', '2019-08-28'),
(58, 'Task Assign', '2019-09-08');

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE IF NOT EXISTS `user_type` (
`usr_id` int(100) NOT NULL,
  `usr_type` text NOT NULL,
  `usr_status` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`usr_id`, `usr_type`, `usr_status`) VALUES
(1, 'ADMIN', 1),
(2, 'USER', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
 ADD PRIMARY KEY (`ad_id`);

--
-- Indexes for table `dw_employee_master`
--
ALTER TABLE `dw_employee_master`
 ADD PRIMARY KEY (`DEM_ID`), ADD UNIQUE KEY `DEM_EMP_ID` (`DEM_EMP_ID`);

--
-- Indexes for table `dw_emp_attendance`
--
ALTER TABLE `dw_emp_attendance`
 ADD PRIMARY KEY (`DEA_ID`);

--
-- Indexes for table `dw_payment_tracker`
--
ALTER TABLE `dw_payment_tracker`
 ADD PRIMARY KEY (`DPT_ID`);

--
-- Indexes for table `dw_payroll_history`
--
ALTER TABLE `dw_payroll_history`
 ADD PRIMARY KEY (`DPM_ID`);

--
-- Indexes for table `dw_payroll_master`
--
ALTER TABLE `dw_payroll_master`
 ADD PRIMARY KEY (`DPM_ID`), ADD UNIQUE KEY `DEM_EMPLOYEE_ID` (`DEM_EMP_ID`);

--
-- Indexes for table `dw_user_login`
--
ALTER TABLE `dw_user_login`
 ADD PRIMARY KEY (`DUL_USER_ID`), ADD UNIQUE KEY `DEM_EMP_ID` (`DEM_EMP_ID`);

--
-- Indexes for table `general_setting`
--
ALTER TABLE `general_setting`
 ADD PRIMARY KEY (`gs_id`);

--
-- Indexes for table `tab_allow_tbl`
--
ALTER TABLE `tab_allow_tbl`
 ADD PRIMARY KEY (`tb_allow_id`);

--
-- Indexes for table `user_type`
--
ALTER TABLE `user_type`
 ADD PRIMARY KEY (`usr_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
MODIFY `ad_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `dw_employee_master`
--
ALTER TABLE `dw_employee_master`
MODIFY `DEM_ID` int(100) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `dw_emp_attendance`
--
ALTER TABLE `dw_emp_attendance`
MODIFY `DEA_ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `dw_payment_tracker`
--
ALTER TABLE `dw_payment_tracker`
MODIFY `DPT_ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `dw_payroll_history`
--
ALTER TABLE `dw_payroll_history`
MODIFY `DPM_ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `dw_payroll_master`
--
ALTER TABLE `dw_payroll_master`
MODIFY `DPM_ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `dw_user_login`
--
ALTER TABLE `dw_user_login`
MODIFY `DUL_USER_ID` int(100) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `general_setting`
--
ALTER TABLE `general_setting`
MODIFY `gs_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tab_allow_tbl`
--
ALTER TABLE `tab_allow_tbl`
MODIFY `tb_allow_id` int(100) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=59;
--
-- AUTO_INCREMENT for table `user_type`
--
ALTER TABLE `user_type`
MODIFY `usr_id` int(100) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
