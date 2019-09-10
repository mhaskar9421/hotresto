-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 10, 2019 at 04:31 AM
-- Server version: 5.7.26
-- PHP Version: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotresto`
--

-- --------------------------------------------------------

--
-- Table structure for table `hr_booked_rooms`
--

DROP TABLE IF EXISTS `hr_booked_rooms`;
CREATE TABLE IF NOT EXISTS `hr_booked_rooms` (
  `booked_id` int(11) NOT NULL AUTO_INCREMENT,
  `booked_room_id` int(11) NOT NULL,
  `booked_dates` text NOT NULL,
  PRIMARY KEY (`booked_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `hr_bookings`
--

DROP TABLE IF EXISTS `hr_bookings`;
CREATE TABLE IF NOT EXISTS `hr_bookings` (
  `booking_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `room_charges` int(11) NOT NULL,
  `extra_occupancy` int(11) NOT NULL,
  `checkin_date` date NOT NULL,
  `checkout_date` date NOT NULL,
  `booked_dates` text NOT NULL,
  `food_bill_number` varchar(255) NOT NULL,
  `food_bill_amount` varchar(255) NOT NULL,
  `total_amount` varchar(255) NOT NULL,
  `paid_amount` varchar(255) NOT NULL,
  `payment_mode` varchar(255) NOT NULL,
  `payment_status` varchar(255) NOT NULL,
  `booking_date` date NOT NULL,
  PRIMARY KEY (`booking_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Triggers `hr_bookings`
--
DROP TRIGGER IF EXISTS `updateBookedRoom`;
DELIMITER $$
CREATE TRIGGER `updateBookedRoom` AFTER INSERT ON `hr_bookings` FOR EACH ROW INSERT INTO hr_booked_rooms VALUES (null, NEw.room_id,NEW.booked_dates)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `hr_customers`
--

DROP TABLE IF EXISTS `hr_customers`;
CREATE TABLE IF NOT EXISTS `hr_customers` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(250) NOT NULL,
  `customer_mobile` varchar(255) NOT NULL,
  `customer_idtype` varchar(255) NOT NULL,
  `customer_idnumber` varchar(255) NOT NULL,
  `customer_address` text NOT NULL,
  `customer_uploadImage` text NOT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hr_login`
--

DROP TABLE IF EXISTS `hr_login`;
CREATE TABLE IF NOT EXISTS `hr_login` (
  `login_id` int(11) NOT NULL AUTO_INCREMENT,
  `login_username` varchar(255) NOT NULL,
  `login_password` varchar(255) NOT NULL,
  `login_active_status` int(11) NOT NULL,
  PRIMARY KEY (`login_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `hr_login`
--

INSERT INTO `hr_login` (`login_id`, `login_username`, `login_password`, `login_active_status`) VALUES
(1, 'admin', 'admin', 1);

-- --------------------------------------------------------

--
-- Table structure for table `hr_rooms`
--

DROP TABLE IF EXISTS `hr_rooms`;
CREATE TABLE IF NOT EXISTS `hr_rooms` (
  `room_id` int(11) NOT NULL AUTO_INCREMENT,
  `room_name` varchar(255) NOT NULL,
  `room_number` varchar(255) NOT NULL,
  `room_bed_count` varchar(255) NOT NULL,
  `room_image` text NOT NULL,
  PRIMARY KEY (`room_id`),
  KEY `room_id` (`room_id`),
  KEY `room_id_2` (`room_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `hr_tax`
--

DROP TABLE IF EXISTS `hr_tax`;
CREATE TABLE IF NOT EXISTS `hr_tax` (
  `tax_id` int(11) NOT NULL AUTO_INCREMENT,
  `tax_type` varchar(255) NOT NULL,
  `tax_amount` varchar(255) NOT NULL,
  PRIMARY KEY (`tax_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `hr_tax`
--

INSERT INTO `hr_tax` (`tax_id`, `tax_type`, `tax_amount`) VALUES
(1, 'State GST', '12');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
