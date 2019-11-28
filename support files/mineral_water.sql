-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2019 at 03:38 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mineral_water`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `brand_name` varchar(200) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Active' COMMENT 'Active/Inactive',
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `brand_name`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`, `is_deleted`) VALUES
(1, 'Kinley', '2019-11-25 13:33:58', 2, NULL, NULL, 'Active', 0),
(2, 'Bislery', '2019-11-25 13:34:07', 2, NULL, NULL, 'Active', 0),
(3, 'Bailley', '2019-11-25 13:34:39', 2, NULL, NULL, 'Active', 0),
(4, 'Aquafina', '2019-11-25 13:34:48', 2, '2019-11-26 14:35:22', 2, 'Active', 0),
(5, 'dsfsdfsdfsdsfsdfsdfsdsfsdfsdfsdsfsdfsdfsdsfsdfsdfsdsfsdfsdfsdsfsdfsdfsdsfsdfsdfsdsfsdfsdfsdsfsdfsdfsdsfsdfsdfsdsfsdfsdfsdsfsdfsdfsdsfsdfsdfsdsfsdfsdfsdsfsdfsdfsdsfsdfsdfsdsfsdfsdfsdsfsdfsdfsdfdfdf', '2019-11-26 14:31:50', 2, '2019-11-26 14:32:37', 2, 'Active', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `state_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `code` varchar(20) DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 = Deleted',
  `created_at` datetime DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `state_id`, `name`, `code`, `status`, `is_deleted`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 1, 'Jaipur', 'JP', 'Active', 0, '2019-11-25 12:56:15', 1, NULL, NULL),
(2, 1, 'Sikar', 'SKR', 'Active', 0, '2019-11-25 12:56:15', 1, NULL, NULL),
(3, 2, 'Ahmedabad', 'ABD', 'Active', 0, '2019-11-25 12:56:47', 1, NULL, NULL),
(4, 2, 'Gandhinagar', 'GD', 'Active', 0, '2019-11-25 12:56:47', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `client_name` varchar(200) DEFAULT NULL,
  `credit_limit` decimal(14,2) DEFAULT 0.00,
  `credit_balance` float(10,2) NOT NULL DEFAULT 0.00,
  `address` varchar(500) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `zip_code_id` int(11) DEFAULT NULL,
  `lead_id` int(11) DEFAULT NULL COMMENT 'leads.lead_id if client is converted from lead',
  `lat` varchar(20) DEFAULT NULL,
  `lng` varchar(20) DEFAULT NULL,
  `contact_person_name_1` varchar(200) DEFAULT NULL,
  `contact_person_1_phone_1` varchar(20) DEFAULT NULL,
  `contact_person_1_phone_2` varchar(20) DEFAULT NULL,
  `contact_person_1_email` varchar(200) DEFAULT NULL,
  `contact_person_name_2` varchar(200) DEFAULT NULL,
  `contact_person_2_phone_1` varchar(20) DEFAULT NULL,
  `contact_person_2_phone_2` varchar(20) DEFAULT NULL,
  `contact_person_2_email` varchar(200) DEFAULT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Active' COMMENT 'Active/Inactive',
  `gst_no` varchar(50) NOT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `client_name`, `credit_limit`, `credit_balance`, `address`, `city_id`, `state_id`, `zip_code_id`, `lead_id`, `lat`, `lng`, `contact_person_name_1`, `contact_person_1_phone_1`, `contact_person_1_phone_2`, `contact_person_1_email`, `contact_person_name_2`, `contact_person_2_phone_1`, `contact_person_2_phone_2`, `contact_person_2_email`, `is_deleted`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`, `gst_no`, `category_id`) VALUES
(1, 'letsenkindle', '2000.00', 390.00, 'Plot No.-5,\r\nKanbha', 3, 2, 5, NULL, NULL, NULL, 'Milan Soni', '1231231231', '7897897897', 'rakeshj@letsenkindle.com', 'Snehal Trapsiya', '9772446625', '9772446628', 'snehal@gmail.com', 0, '2019-11-25 14:10:26', 2, '2019-11-26 17:39:21', 2, 'Active', 'GJ08 1806 FC', 4),
(2, 'Milan & Sons', '5000.00', 0.00, 'Plot No.-5,\r\nKanbha', 3, 2, 6, NULL, NULL, NULL, 'Milan Soni', '9166650505', '8963015122', 'milan@gmail.com', 'Gopal', '9829069118', '9772446628', 'milan@gmail.com', 0, '2019-11-25 15:26:24', 2, NULL, NULL, 'Active', 'GJ08 1806 FC', 1),
(5, 'test', '5000.00', 0.00, 'Plot No.-5,\r\nKanbha', 3, 2, 6, NULL, NULL, NULL, 'Milan Soni', '9166650505', '8963015122', 'milan@gmail.com', 'Gopal', '9829069118', '9772446628', 'milan@gmail.com', 0, '2019-11-25 15:26:24', 2, NULL, NULL, 'Active', 'GJ08 1806 FC', 1);

-- --------------------------------------------------------

--
-- Table structure for table `client_categories`
--

CREATE TABLE `client_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Active' COMMENT 'Active/Inactive',
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `client_categories`
--

INSERT INTO `client_categories` (`id`, `name`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`, `is_deleted`) VALUES
(1, 'Gold Client', '2019-10-30 19:44:36', NULL, '2019-11-25 12:19:04', 2, 'Active', 0),
(4, 'Ordinary Client', '2019-11-25 12:19:09', 2, NULL, NULL, 'Active', 0),
(5, 'Silver Client', '2019-11-25 12:19:15', 2, NULL, NULL, 'Active', 0);

-- --------------------------------------------------------

--
-- Table structure for table `client_contacts`
--

CREATE TABLE `client_contacts` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `person_name` varchar(200) DEFAULT NULL,
  `is_primary` varchar(20) NOT NULL DEFAULT 'No' COMMENT 'No/Yes',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Active' COMMENT 'Active/Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `client_delivery_addresses`
--

CREATE TABLE `client_delivery_addresses` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `address` varchar(500) DEFAULT NULL,
  `zip_code_id` int(11) DEFAULT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Active' COMMENT 'Active/Inactive	'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `client_delivery_addresses`
--

INSERT INTO `client_delivery_addresses` (`id`, `client_id`, `title`, `address`, `zip_code_id`, `is_deleted`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`) VALUES
(1, 2, 'Home', 'Plot No.-1, New Colony', 5, 0, '2019-11-25 15:02:26', 1, '2019-11-27 14:01:03', 2, 'Active'),
(2, 1, 'Client 1 Home', 'Plot No.-1, Client 1 Colony', 5, 0, '2019-11-27 15:31:51', 1, NULL, NULL, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `client_location_images`
--

CREATE TABLE `client_location_images` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `image_name` varchar(300) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `client_product_price`
--

CREATE TABLE `client_product_price` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `sale_price` float NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Active' COMMENT 'Active/Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `client_product_price`
--

INSERT INTO `client_product_price` (`id`, `client_id`, `product_id`, `sale_price`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`) VALUES
(1, 2, 1, 20, '2019-11-25 15:26:24', 2, NULL, NULL, 'Active'),
(2, 2, 2, 20, '2019-11-25 15:26:24', 2, NULL, NULL, 'Active'),
(3, 2, 3, 18, '2019-11-25 15:26:24', 2, NULL, NULL, 'Active'),
(4, 2, 4, 6, '2019-11-25 15:26:24', 2, '2019-11-28 15:06:01', NULL, 'Active'),
(5, 2, 5, 5, '2019-11-25 15:26:24', 2, NULL, NULL, 'Active'),
(6, 2, 6, 5, '2019-11-25 15:26:24', 2, NULL, NULL, 'Active'),
(13, 1, 1, 5, '2019-11-28 13:36:26', 2, NULL, NULL, 'Active'),
(14, 1, 2, 5, '2019-11-28 13:36:26', 2, NULL, NULL, 'Active'),
(15, 1, 3, 5, '2019-11-28 13:36:26', 2, NULL, NULL, 'Active'),
(16, 1, 4, 5, '2019-11-28 13:36:26', 2, NULL, NULL, 'Active'),
(17, 1, 5, 5, '2019-11-28 13:36:26', 2, NULL, NULL, 'Active'),
(18, 1, 6, 5, '2019-11-28 13:36:26', 2, NULL, NULL, 'Active'),
(19, 1, 7, 343.4, '2019-11-28 17:26:20', 2, NULL, NULL, 'Active'),
(20, 2, 7, 343.4, '2019-11-28 17:26:20', 2, NULL, NULL, 'Active'),
(21, 5, 7, 343.4, '2019-11-28 17:26:20', 2, NULL, NULL, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `client_selesmans`
--

CREATE TABLE `client_selesmans` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `salesman_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Active' COMMENT 'Active/Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `client_visits`
--

CREATE TABLE `client_visits` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `visit_date` date DEFAULT NULL,
  `visit_time` time DEFAULT NULL,
  `visit_type` varchar(50) DEFAULT NULL COMMENT 'phone,inperson',
  `opportunity` varchar(500) DEFAULT NULL,
  `other_notes` varchar(500) DEFAULT NULL,
  `visit_notes` varchar(500) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `client_visits`
--

INSERT INTO `client_visits` (`id`, `client_id`, `visit_date`, `visit_time`, `visit_type`, `opportunity`, `other_notes`, `visit_notes`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 2, '2019-01-01', '05:00:00', NULL, NULL, NULL, NULL, '2019-11-28 19:52:56', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `coordinates`
--

CREATE TABLE `coordinates` (
  `id` int(11) NOT NULL,
  `lat` float(9,6) DEFAULT NULL,
  `lng` float(9,6) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `coordinates`
--

INSERT INTO `coordinates` (`id`, `lat`, `lng`, `user_id`, `created_at`, `created_by`) VALUES
(1, 23.033058, 72.463005, 4, '2019-09-24 11:02:52', NULL),
(2, 23.026896, 72.468155, 4, '2019-09-24 11:02:54', NULL),
(3, 23.019314, 72.473816, 4, '2019-09-24 11:02:56', NULL),
(4, 23.014257, 72.479485, 4, '2019-09-24 11:02:57', NULL),
(5, 23.008570, 72.478111, 4, '2019-09-24 11:02:58', NULL),
(6, 23.005568, 72.476562, 4, '2019-09-24 11:02:59', NULL),
(7, 22.998772, 72.473473, 4, '2019-09-24 11:03:01', NULL),
(8, 22.992926, 72.472275, 4, '2019-09-24 11:03:01', NULL),
(9, 22.985579, 72.484879, 4, '2019-09-24 11:03:03', NULL),
(10, 22.985498, 72.499565, 4, '2019-09-24 11:03:05', NULL),
(11, 22.990871, 72.519310, 4, '2019-09-24 11:03:06', NULL),
(12, 22.993954, 72.535339, 4, '2019-09-24 11:03:09', NULL),
(13, 22.988028, 72.538910, 4, '2019-09-24 11:03:10', NULL),
(14, 22.976965, 72.546806, 4, '2019-09-24 11:03:11', NULL),
(15, 22.975384, 72.552986, 4, '2019-09-24 11:03:12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `delivery`
--

CREATE TABLE `delivery` (
  `id` int(11) NOT NULL,
  `expected_delivey_datetime` datetime DEFAULT NULL,
  `actual_delivey_datetime` datetime DEFAULT NULL,
  `pickup_location` varchar(50) DEFAULT NULL,
  `warehouse` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Active' COMMENT 'Active/Inactive',
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `delivery`
--

INSERT INTO `delivery` (`id`, `expected_delivey_datetime`, `actual_delivey_datetime`, `pickup_location`, `warehouse`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`, `is_deleted`) VALUES
(22, '2019-11-26 00:00:00', '2019-11-28 18:58:39', 'Office', NULL, '2019-11-28 14:18:36', 2, '2019-11-28 20:08:14', 2, 'Active', 0);

-- --------------------------------------------------------

--
-- Table structure for table `delivery_config`
--

CREATE TABLE `delivery_config` (
  `id` int(11) NOT NULL,
  `delivery_id` int(11) DEFAULT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `delivery_boy_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Active' COMMENT 'Active/Inactive',
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `delivery_config`
--

INSERT INTO `delivery_config` (`id`, `delivery_id`, `vehicle_id`, `driver_id`, `delivery_boy_id`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`, `is_deleted`) VALUES
(64, 22, 1, 4, 3, '2019-11-28 20:08:14', 2, NULL, NULL, 'Active', 0);

-- --------------------------------------------------------

--
-- Table structure for table `delivery_config_orders`
--

CREATE TABLE `delivery_config_orders` (
  `id` int(11) NOT NULL,
  `delivery_id` int(11) DEFAULT NULL,
  `delivery_config_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `payment_mode` varchar(50) DEFAULT NULL,
  `amount` float DEFAULT 0,
  `notes` varchar(500) DEFAULT NULL,
  `signature_file` varchar(300) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Active' COMMENT 'Active/Inactive',
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `delivery_config_orders`
--

INSERT INTO `delivery_config_orders` (`id`, `delivery_id`, `delivery_config_id`, `order_id`, `payment_mode`, `amount`, `notes`, `signature_file`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`, `is_deleted`) VALUES
(95, 22, 64, 8, NULL, 0, NULL, NULL, '2019-11-28 20:08:14', 2, NULL, NULL, 'Active', 0),
(96, 22, 64, 9, NULL, 0, NULL, NULL, '2019-11-28 20:08:14', 2, NULL, NULL, 'Active', 0);

-- --------------------------------------------------------

--
-- Table structure for table `delivery_routes`
--

CREATE TABLE `delivery_routes` (
  `id` int(11) NOT NULL,
  `delivery_id` int(11) DEFAULT NULL,
  `zip_code_group_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Active' COMMENT 'Active/Inactive',
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `delivery_routes`
--

INSERT INTO `delivery_routes` (`id`, `delivery_id`, `zip_code_group_id`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`, `is_deleted`) VALUES
(47, 22, 1, '2019-11-28 20:08:14', 2, NULL, NULL, 'Active', 0);

-- --------------------------------------------------------

--
-- Table structure for table `group_to_zip_code`
--

CREATE TABLE `group_to_zip_code` (
  `id` int(11) NOT NULL,
  `zip_code_group_id` int(11) DEFAULT NULL,
  `zip_code_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Active' COMMENT 'Active/Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `group_to_zip_code`
--

INSERT INTO `group_to_zip_code` (`id`, `zip_code_group_id`, `zip_code_id`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`) VALUES
(1, 1, 5, '2019-11-25 13:04:38', 2, NULL, NULL, 'Active'),
(2, 1, 6, '2019-11-25 13:04:38', 2, NULL, NULL, 'Active'),
(3, 2, 7, '2019-11-25 13:04:51', 2, NULL, NULL, 'Active'),
(4, 2, 8, '2019-11-25 13:04:51', 2, NULL, NULL, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `leads`
--

CREATE TABLE `leads` (
  `id` int(11) NOT NULL,
  `company_name` varchar(200) DEFAULT NULL,
  `contact_person_name` varchar(200) DEFAULT NULL,
  `email` varchar(300) DEFAULT NULL,
  `phone_1` varchar(20) DEFAULT NULL,
  `phone_2` varchar(20) DEFAULT NULL,
  `is_converted` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `leads`
--

INSERT INTO `leads` (`id`, `company_name`, `contact_person_name`, `email`, `phone_1`, `phone_2`, `is_converted`, `created_at`, `created_by`, `updated_at`, `updated_by`, `is_deleted`) VALUES
(1, 'test', 'Rakesh', 'rk@gmail.com', '8963015122', '9166650505', 0, '2019-11-28 15:49:30', 1, '2019-11-28 19:59:38', 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `lead_visits`
--

CREATE TABLE `lead_visits` (
  `id` int(11) NOT NULL,
  `lead_id` int(11) DEFAULT NULL,
  `visit_date` date DEFAULT NULL,
  `visit_time` time DEFAULT NULL,
  `visit_type` varchar(50) DEFAULT NULL COMMENT 'phone,inperson',
  `opportunity` varchar(500) DEFAULT NULL,
  `other_notes` varchar(500) DEFAULT NULL,
  `visit_notes` varchar(500) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lead_visits`
--

INSERT INTO `lead_visits` (`id`, `lead_id`, `visit_date`, `visit_time`, `visit_type`, `opportunity`, `other_notes`, `visit_notes`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(2, 1, '2019-01-01', '05:00:00', NULL, NULL, NULL, NULL, '2019-11-28 19:49:09', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mail_template`
--

CREATE TABLE `mail_template` (
  `id` int(11) NOT NULL,
  `template_body` text CHARACTER SET utf8 DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mail_template`
--

INSERT INTO `mail_template` (`id`, `template_body`, `type`) VALUES
(1, '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n\r\n  <meta charset=\"utf-8\">\r\n  <meta http-equiv=\"x-ua-compatible\" content=\"ie=edge\">\r\n  <title>Password Reset</title>\r\n  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">\r\n  <style type=\"text/css\">\r\n  /**\r\n   * Google webfonts. Recommended to include the .woff version for cross-client compatibility.\r\n   */\r\n  @media screen {\r\n    @font-face {\r\n      font-family: \'Source Sans Pro\';\r\n      font-style: normal;\r\n      font-weight: 400;\r\n      src: local(\'Source Sans Pro Regular\'), local(\'SourceSansPro-Regular\'), url(https://fonts.gstatic.com/s/sourcesanspro/v10/ODelI1aHBYDBqgeIAH2zlBM0YzuT7MdOe03otPbuUS0.woff) format(\'woff\');\r\n    }\r\n    @font-face {\r\n      font-family: \'Source Sans Pro\';\r\n      font-style: normal;\r\n      font-weight: 700;\r\n      src: local(\'Source Sans Pro Bold\'), local(\'SourceSansPro-Bold\'), url(https://fonts.gstatic.com/s/sourcesanspro/v10/toadOcfmlt9b38dHJxOBGFkQc6VGVFSmCnC_l7QZG60.woff) format(\'woff\');\r\n    }\r\n  }\r\n  /**\r\n   * Avoid browser level font resizing.\r\n   * 1. Windows Mobile\r\n   * 2. iOS / OSX\r\n   */\r\n  body,\r\n  table,\r\n  td,\r\n  a {\r\n    -ms-text-size-adjust: 100%; /* 1 */\r\n    -webkit-text-size-adjust: 100%; /* 2 */\r\n  }\r\n  /**\r\n   * Remove extra space added to tables and cells in Outlook.\r\n   */\r\n  table,\r\n  td {\r\n    mso-table-rspace: 0pt;\r\n    mso-table-lspace: 0pt;\r\n  }\r\n  /**\r\n   * Better fluid images in Internet Explorer.\r\n   */\r\n  img {\r\n    -ms-interpolation-mode: bicubic;\r\n  }\r\n  /**\r\n   * Remove blue links for iOS devices.\r\n   */\r\n  a[x-apple-data-detectors] {\r\n    font-family: inherit !important;\r\n    font-size: inherit !important;\r\n    font-weight: inherit !important;\r\n    line-height: inherit !important;\r\n    color: inherit !important;\r\n    text-decoration: none !important;\r\n  }\r\n  /**\r\n   * Fix centering issues in Android 4.4.\r\n   */\r\n  div[style*=\"margin: 16px 0;\"] {\r\n    margin: 0 !important;\r\n  }\r\n  body {\r\n    width: 100% !important;\r\n    height: 100% !important;\r\n    padding: 0 !important;\r\n    margin: 0 !important;\r\n  }\r\n  /**\r\n   * Collapse table borders to avoid space between cells.\r\n   */\r\n  table {\r\n    border-collapse: collapse !important;\r\n  }\r\n  a {\r\n    color: #1a82e2;\r\n  }\r\n  img {\r\n    height: auto;\r\n    line-height: 100%;\r\n    text-decoration: none;\r\n    border: 0;\r\n    outline: none;\r\n  }\r\n  </style>\r\n\r\n</head>\r\n<body style=\"background-color: #e9ecef;\">\r\n\r\n  <!-- start preheader -->\r\n  <div class=\"preheader\" style=\"display: none; max-width: 0; max-height: 0; overflow: hidden; font-size: 1px; line-height: 1px; color: #fff; opacity: 0;\">\r\n    A preheader is the short summary text that follows the subject line when an email is viewed in the inbox.\r\n  </div>\r\n  <!-- end preheader -->\r\n\r\n  <!-- start body -->\r\n  <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n\r\n    <!-- start logo -->\r\n    <tr>\r\n      <td align=\"center\" bgcolor=\"#e9ecef\">\r\n        <!--[if (gte mso 9)|(IE)]>\r\n        <table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\r\n        <tr>\r\n        <td align=\"center\" valign=\"top\" width=\"600\">\r\n        <![endif]-->\r\n        <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"max-width: 600px;\">\r\n          <tr>\r\n            <td align=\"center\" valign=\"top\" style=\"padding: 36px 24px;\">\r\n              <a href=\"SYSTEM_URL\" target=\"_blank\" style=\"display: inline-block;\">\r\n                <img src=\"LOGO_URL\" alt=\"SYSTEM_NAME\" border=\"0\" width=\"48\" style=\"display: block; width: 48px; max-width: 48px; min-width: 48px;\">\r\n              </a>\r\n            </td>\r\n          </tr>\r\n        </table>\r\n        <!--[if (gte mso 9)|(IE)]>\r\n        </td>\r\n        </tr>\r\n        </table>\r\n        <![endif]-->\r\n      </td>\r\n    </tr>\r\n    <!-- end logo -->\r\n\r\n    <!-- start hero -->\r\n    <tr>\r\n      <td align=\"center\" bgcolor=\"#e9ecef\">\r\n        <!--[if (gte mso 9)|(IE)]>\r\n        <table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\r\n        <tr>\r\n        <td align=\"center\" valign=\"top\" width=\"600\">\r\n        <![endif]-->\r\n        <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"max-width: 600px;\">\r\n          <tr>\r\n            <td align=\"left\" bgcolor=\"#ffffff\" style=\"padding: 36px 24px 0; font-family: \'Source Sans Pro\', Helvetica, Arial, sans-serif; border-top: 3px solid #d4dadf;\">\r\n              <h1 style=\"margin: 0; font-size: 32px; font-weight: 700; letter-spacing: -1px; line-height: 48px;\">Reset Your Password</h1>\r\n            </td>\r\n          </tr>\r\n        </table>\r\n        <!--[if (gte mso 9)|(IE)]>\r\n        </td>\r\n        </tr>\r\n        </table>\r\n        <![endif]-->\r\n      </td>\r\n    </tr>\r\n    <!-- end hero -->\r\n\r\n    <!-- start copy block -->\r\n    <tr>\r\n      <td align=\"center\" bgcolor=\"#e9ecef\">\r\n        <!--[if (gte mso 9)|(IE)]>\r\n        <table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\r\n        <tr>\r\n        <td align=\"center\" valign=\"top\" width=\"600\">\r\n        <![endif]-->\r\n        <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"max-width: 600px;\">\r\n\r\n          <!-- start copy -->\r\n          <tr>\r\n            <td align=\"left\" bgcolor=\"#ffffff\" style=\"padding: 24px; font-family: \'Source Sans Pro\', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;\">\r\n              <p style=\"margin: 0;\">Tap the button below to reset your customer account password. If you didn\'t request a new password, you can safely delete this email.</p>\r\n            </td>\r\n          </tr>\r\n          <!-- end copy -->\r\n\r\n          <!-- start button -->\r\n          <tr>\r\n            <td align=\"left\" bgcolor=\"#ffffff\">\r\n              <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n                <tr>\r\n                  <td align=\"center\" bgcolor=\"#ffffff\" style=\"padding: 12px;\">\r\n                    <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n                      <tr>\r\n                        <td align=\"center\" bgcolor=\"#1a82e2\" style=\"border-radius: 6px;\">\r\n                          <a href=\"RESET_PASSWORD_LINK\" target=\"_blank\" style=\"display: inline-block; padding: 16px 36px; font-family: \'Source Sans Pro\', Helvetica, Arial, sans-serif; font-size: 16px; color: #ffffff; text-decoration: none; border-radius: 6px;\">Reset Password</a>\r\n                        </td>\r\n                      </tr>\r\n                    </table>\r\n                  </td>\r\n                </tr>\r\n              </table>\r\n            </td>\r\n          </tr>\r\n          <!-- end button -->\r\n\r\n          <!-- start copy -->\r\n          <tr>\r\n            <td align=\"left\" bgcolor=\"#ffffff\" style=\"padding: 24px; font-family: \'Source Sans Pro\', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;\">\r\n              <p style=\"margin: 0;\">If that doesn\'t work, copy and paste the following link in your browser:</p>\r\n              <p style=\"margin: 0;\"><a href=\"RESET_PASSWORD_LINK\" target=\"_blank\">RESET_PASSWORD_LINK</a></p>\r\n            </td>\r\n          </tr>\r\n          <!-- end copy -->\r\n\r\n          <!-- start copy -->\r\n          <tr>\r\n            <td align=\"left\" bgcolor=\"#ffffff\" style=\"padding: 24px; font-family: \'Source Sans Pro\', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px; border-bottom: 3px solid #d4dadf\">\r\n              <p style=\"margin: 0;\">Cheers,<br> Neervana Support</p>\r\n            </td>\r\n          </tr>\r\n          <!-- end copy -->\r\n\r\n        </table>\r\n        <!--[if (gte mso 9)|(IE)]>\r\n        </td>\r\n        </tr>\r\n        </table>\r\n        <![endif]-->\r\n      </td>\r\n    </tr>\r\n    <!-- end copy block -->\r\n\r\n    <!-- start footer -->\r\n    <tr>\r\n      <td align=\"center\" bgcolor=\"#e9ecef\" style=\"padding: 24px;\">\r\n        <!--[if (gte mso 9)|(IE)]>\r\n        <table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\r\n        <tr>\r\n        <td align=\"center\" valign=\"top\" width=\"600\">\r\n        <![endif]-->\r\n        <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"max-width: 600px;\">\r\n\r\n          <!-- start permission -->\r\n          <tr>\r\n            <td align=\"center\" bgcolor=\"#e9ecef\" style=\"padding: 12px 24px; font-family: \'Source Sans Pro\', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 20px; color: #666;\">\r\n              <p style=\"margin: 0;\">You received this email because we received a request for reset password for your account. If you didn\'t request reset password you can safely delete this email.</p>\r\n            </td>\r\n          </tr>\r\n          <!-- end permission -->\r\n\r\n        </table>\r\n        <!--[if (gte mso 9)|(IE)]>\r\n        </td>\r\n        </tr>\r\n        </table>\r\n        <![endif]-->\r\n      </td>\r\n    </tr>\r\n    <!-- end footer -->\r\n\r\n  </table>\r\n  <!-- end body -->\r\n\r\n</body>\r\n</html>', 'PASSWORD_RESET');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `delivery_address_id` int(11) DEFAULT NULL,
  `scheme_id` int(11) DEFAULT NULL,
  `priority` varchar(50) DEFAULT NULL,
  `delivery_boy_id` int(11) DEFAULT NULL,
  `expected_delivery_date` date DEFAULT NULL,
  `actual_delivery_date` date DEFAULT NULL,
  `payable_amount` float(10,2) DEFAULT 0.00,
  `delivery_id` int(11) DEFAULT NULL,
  `payment_mode` varchar(50) DEFAULT NULL,
  `payment_schedule_date` date DEFAULT NULL,
  `payment_schedule_time` time DEFAULT NULL,
  `order_status` varchar(50) NOT NULL DEFAULT 'Pending' COMMENT 'Pending/Approval Required/Approved/Rejected',
  `status` varchar(20) NOT NULL DEFAULT 'Active' COMMENT 'Active/Inactive',
  `payment_status` varchar(30) NOT NULL DEFAULT 'Pending' COMMENT 'Pending/Partial/Paid',
  `need_admin_approval` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `client_id`, `delivery_address_id`, `scheme_id`, `priority`, `delivery_boy_id`, `expected_delivery_date`, `actual_delivery_date`, `payable_amount`, `delivery_id`, `payment_mode`, `payment_schedule_date`, `payment_schedule_time`, `order_status`, `status`, `payment_status`, `need_admin_approval`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(8, 2, 1, 2, 'High', NULL, '2019-12-02', '2019-11-28', 400.00, 22, 'Cash', '2019-12-06', '19:03:00', 'Delivered', 'Active', 'Paid', 0, '2019-11-28 11:23:13', 1, '2019-11-28 20:08:14', 3),
(9, 2, 1, 2, 'High', NULL, '2019-12-03', NULL, 140.00, 22, 'Cash', '2019-12-07', '19:03:00', 'Pending', 'Active', 'Paid', 0, '2019-11-28 11:24:35', 1, '2019-11-28 20:08:14', NULL),
(10, 2, 1, 2, 'High', NULL, '2019-12-04', NULL, 110.00, NULL, 'Cash', '2019-12-08', '19:03:00', 'Approved', 'Active', 'Partial', 1, '2019-11-28 11:25:24', 1, '2019-11-28 15:06:01', NULL),
(11, 5, 1, 2, 'High', NULL, '2019-12-04', NULL, 120.00, NULL, 'Cash', '2019-12-08', '19:03:00', 'Pending', 'Active', 'Pending', 0, '2019-11-28 12:54:24', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_delivery_images`
--

CREATE TABLE `order_delivery_images` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `image_name` varchar(300) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` float DEFAULT NULL,
  `actual_price` float NOT NULL,
  `effective_price` float DEFAULT NULL,
  `subtotal` decimal(14,2) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `actual_price`, `effective_price`, `subtotal`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(15, 8, 1, 10, 20, 20, '200.00', '2019-11-28 11:23:13', 1, NULL, NULL),
(16, 8, 2, 10, 20, 20, '200.00', '2019-11-28 11:23:13', 1, NULL, NULL),
(17, 9, 3, 10, 7, 7, '70.00', '2019-11-28 11:24:35', 1, '2019-11-28 11:25:53', NULL),
(18, 9, 4, 10, 7, 7, '70.00', '2019-11-28 11:24:35', 1, '2019-11-28 11:25:55', NULL),
(19, 10, 5, 10, 5, 5, '50.00', '2019-11-28 11:25:24', 1, NULL, NULL),
(20, 10, 4, 10, 6, 6, '70.00', '2019-11-28 11:25:24', 1, '2019-11-28 15:06:01', NULL),
(21, 11, 5, 10, 5, 5, '50.00', '2019-11-28 12:54:24', 1, NULL, NULL),
(22, 11, 4, 10, 7, 7, '70.00', '2019-11-28 12:54:24', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `payment_mode` varchar(50) DEFAULT NULL COMMENT 'Cash / Cheque / Credit Card',
  `check_no` varchar(50) DEFAULT NULL,
  `check_date` date DEFAULT NULL,
  `transection_no` varchar(100) DEFAULT NULL,
  `paid_amount` decimal(14,2) DEFAULT NULL,
  `credit_balance_used` decimal(14,2) NOT NULL DEFAULT 0.00,
  `previous_credit_balance` decimal(14,2) NOT NULL DEFAULT 0.00,
  `new_credit_balance` decimal(14,2) DEFAULT 0.00,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `client_id`, `payment_mode`, `check_no`, `check_date`, `transection_no`, `paid_amount`, `credit_balance_used`, `previous_credit_balance`, `new_credit_balance`, `created_at`, `created_by`) VALUES
(66, 2, 'Cash', NULL, NULL, NULL, '90.00', '0.00', '0.00', '0.00', '2019-11-28 11:52:48', NULL),
(67, 2, 'Cash', NULL, NULL, NULL, '10.00', '0.00', '0.00', '0.00', '2019-11-28 11:53:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payment_details`
--

CREATE TABLE `payment_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `payment_id` int(11) DEFAULT NULL,
  `amount_used` decimal(14,2) DEFAULT NULL,
  `credit_used` decimal(14,2) DEFAULT NULL,
  `total_payment` decimal(14,2) NOT NULL DEFAULT 0.00,
  `status` varchar(10) DEFAULT NULL COMMENT 'PARTIAL | PENDING | PAID'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `product_name` varchar(300) DEFAULT NULL,
  `product_code` varchar(50) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `weight` float DEFAULT NULL,
  `dimension` varchar(100) DEFAULT NULL,
  `cost_price` float DEFAULT 0,
  `sale_price` float DEFAULT 0,
  `status` varchar(20) NOT NULL DEFAULT 'Active' COMMENT 'Active | Deactive',
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `brand_id`, `product_name`, `product_code`, `description`, `weight`, `dimension`, `cost_price`, `sale_price`, `status`, `is_deleted`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 2, 'Bisleri Pet Bottle', 'BIS-1', '', 1, '12*4*4', 12, 20, 'Active', 0, '2019-11-25 14:00:43', 2, NULL, NULL),
(2, 4, 'Aquafina 1 Ltr', 'AQ - 1', '', 1, '5*3*10', 12, 20, 'Active', 0, '2019-11-25 14:01:23', 2, NULL, NULL),
(3, 3, 'Evian 1 Ltr', 'EV -1', '', 1, '5*3*10', 14, 18, 'Active', 0, '2019-11-25 14:02:03', 2, NULL, NULL),
(4, 2, 'Bilery 250ml', 'BS-250', '', 250, '7*4*4', 3, 7, 'Active', 0, '2019-11-25 14:03:09', 2, NULL, NULL),
(5, 4, 'Evian 250 ml', 'Ev-250', '', 250, '7*4*4', 3, 5, 'Active', 0, '2019-11-25 14:03:45', 2, NULL, NULL),
(6, 1, 'test', 'te', '', 0, 'd', 5, 5, 'Active', 1, '2019-11-25 14:04:51', 2, '2019-11-25 14:05:01', NULL),
(7, 1, 'df', '33', 'dfd', 3.15, '3', 22.4, 343.4, 'Active', 0, '2019-11-28 17:26:20', 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `original_image_name` varchar(300) DEFAULT NULL,
  `thumb` varchar(300) DEFAULT NULL,
  `is_primary` tinyint(4) DEFAULT 0 COMMENT '0-not primary, 1-primary',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `original_image_name`, `thumb`, `is_primary`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 1, '500ml-mineral-water-bottle-500x500.jpg', '500ml-mineral-water-bottle-500x500_thumb.jpg', 1, '2019-11-25 14:00:43', 2, NULL, NULL),
(2, 2, 'aquafina_500ml_mineral_water_bottle.jpg', 'aquafina_500ml_mineral_water_bottle_thumb.jpg', 1, '2019-11-25 14:01:23', 2, NULL, NULL),
(3, 3, 'DW05501-e.jpg', 'DW05501-e_thumb.jpg', 1, '2019-11-25 14:02:03', 2, NULL, NULL),
(4, 4, '250ml_0.png', '250ml_0_thumb.png', 1, '2019-11-25 14:03:09', 2, NULL, NULL),
(5, 5, 'Evian-330ml-Natural-Mineral-Water-Bottle-Plastic-1.jpg', 'Evian-330ml-Natural-Mineral-Water-Bottle-Plastic-1_thumb.jpg', 1, '2019-11-25 14:03:45', 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role_name` varchar(200) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Active' COMMENT 'Active/Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role_name`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`) VALUES
(1, 'Admin', '2019-08-26 14:12:22', NULL, NULL, NULL, 'Active'),
(2, 'Sales', '2019-08-26 14:12:22', NULL, NULL, NULL, 'Active'),
(3, 'Delivery Boy', '2019-08-26 14:12:22', NULL, NULL, NULL, 'Active'),
(4, 'Loader/Driver', '2019-10-31 13:11:06', NULL, NULL, NULL, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `schemes`
--

CREATE TABLE `schemes` (
  `id` int(11) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `type` varchar(50) NOT NULL COMMENT 'price_scheme,product_order_scheme',
  `order_value` float DEFAULT NULL,
  `gift_mode` varchar(50) DEFAULT NULL COMMENT 'cash_benifit/free_product',
  `discount_mode` varchar(50) DEFAULT NULL COMMENT 'amount/percentage',
  `discount_value` float DEFAULT NULL,
  `discounted_amount` float DEFAULT NULL,
  `match_mode` varchar(50) DEFAULT NULL COMMENT 'all/any',
  `free_product_id` int(11) DEFAULT NULL,
  `free_product_qty` float DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Active' COMMENT 'Active/Inactive',
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schemes`
--

INSERT INTO `schemes` (`id`, `name`, `description`, `start_date`, `end_date`, `type`, `order_value`, `gift_mode`, `discount_mode`, `discount_value`, `discounted_amount`, `match_mode`, `free_product_id`, `free_product_qty`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`, `is_deleted`) VALUES
(1, 'Get 5% discount on purchase of 1000', 'Get 5% discount on purchase of 1000', '2019-11-25', '2019-12-31', 'price_scheme', 1000, 'cash_benifit', 'percentage', 5, NULL, NULL, NULL, NULL, '2019-11-25 14:15:56', 2, NULL, NULL, 'Active', 0),
(2, 'Get 1 bottle free on purchase of 10 qty of Bilery-1ltr', 'Get 50 of on purchase of 50 qty of Bilery-1ltr', '2019-11-25', '2019-12-31', 'product_order_scheme', NULL, 'free_product', NULL, NULL, NULL, 'all', 1, 1, '2019-11-25 14:17:13', 2, NULL, NULL, 'Active', 0);

-- --------------------------------------------------------

--
-- Table structure for table `scheme_products`
--

CREATE TABLE `scheme_products` (
  `id` int(11) NOT NULL,
  `scheme_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Active' COMMENT 'Active/Inactive',
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `scheme_products`
--

INSERT INTO `scheme_products` (`id`, `scheme_id`, `product_id`, `quantity`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`, `is_deleted`) VALUES
(1, 2, 1, 10, '2019-11-25 14:17:13', 2, NULL, NULL, 'Active', 0);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `system_name` varchar(255) DEFAULT NULL,
  `email_host` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `from_name` varchar(255) DEFAULT NULL,
  `reply_to` varchar(255) DEFAULT NULL,
  `reply_to_name` varchar(255) DEFAULT NULL,
  `maps_api_key` varchar(100) DEFAULT NULL,
  `node_server_url` varchar(300) DEFAULT NULL,
  `default_credit_limit` float NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `system_name`, `email_host`, `username`, `password`, `from_name`, `reply_to`, `reply_to_name`, `maps_api_key`, `node_server_url`, `default_credit_limit`) VALUES
(1, 'Neervana', 'smtp.gmail.com', 'ehs.mehul@gmail.com', 'androiddev123', 'Mehul Patel', 'ehs.mehul@gmail.com', 'Mehul Patel', 'AIzaSyAMD5zzVlDuZih7zU3Y8yn2crJEcFtrt5M', 'http://172.16.3.123/rakesh/milan:3000', 0);

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `code` varchar(20) DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 = Deleted',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `name`, `code`, `status`, `is_deleted`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Rajasthan', 'RJ', 'Active', 0, '2019-11-25 12:55:16', 1, '2019-11-25 12:55:28', NULL),
(2, 'Gujarat', 'GJ', 'Active', 0, '2019-11-25 12:55:16', 1, '2019-11-25 12:55:26', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(200) DEFAULT NULL,
  `last_name` varchar(200) DEFAULT NULL,
  `email` varchar(300) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `username` varchar(200) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Active' COMMENT 'Active/Inactive',
  `is_deleted` tinyint(11) DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `phone`, `role_id`, `username`, `password`, `status`, `is_deleted`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Ashish', 'Makwana', 'ashish@gmail.com', '76752681245', 2, 'ashish', 'admin', 'Active', 0, '2019-11-25 14:11:53', 2, '2019-11-27 15:57:21', 2),
(2, 'Devansh', 'Shah', 'admin@gmail.com', '8963015123', 1, 'admin', 'admin', 'Active', 0, '2019-11-25 14:12:28', 2, '2019-11-28 14:11:25', 2),
(3, 'Rakesh', 'Jangir', 'rakesh@gmail.com', '8963015144', 3, 'rakesh', 'admin', 'Active', 0, '2019-11-25 14:13:01', 2, NULL, NULL),
(4, 'Ravi', 'Prajapati', 'ravi@gmail.com', '8963012121', 4, 'ravi', 'ravi', 'Active', 0, '2019-11-25 14:13:38', 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_devices`
--

CREATE TABLE `user_devices` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `device_id` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_vehicle`
--

CREATE TABLE `user_vehicle` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_zip_codes`
--

CREATE TABLE `user_zip_codes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `zip_code_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Active' COMMENT 'Active/Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_zip_code_groups`
--

CREATE TABLE `user_zip_code_groups` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `zip_code_group_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Active' COMMENT 'Active/Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_zip_code_groups`
--

INSERT INTO `user_zip_code_groups` (`id`, `user_id`, `zip_code_group_id`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`) VALUES
(2, 3, 1, '2019-11-25 14:13:01', 2, NULL, NULL, 'Active'),
(3, 4, 1, '2019-11-25 14:13:38', 2, NULL, NULL, 'Active'),
(4, 1, 1, '2019-11-27 15:57:21', 2, NULL, NULL, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

CREATE TABLE `vehicle` (
  `id` int(11) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `number` varchar(200) DEFAULT NULL,
  `capacity_in_ton` float DEFAULT NULL COMMENT 'actuelly capacity is in kg',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Active' COMMENT 'Active/Inactive',
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vehicle`
--

INSERT INTO `vehicle` (`id`, `name`, `number`, `capacity_in_ton`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`, `is_deleted`) VALUES
(1, 'Tata 207', 'GJ01CA1234', 12000, '2019-11-25 13:06:33', 2, NULL, NULL, 'Active', 0),
(2, 'Tata 407', 'Gj02CC1122', 15000, '2019-11-25 13:06:52', 2, NULL, NULL, 'Active', 0),
(3, 'Tata ACE', 'RJ23ST1695', 8000, '2019-11-25 13:07:09', 2, NULL, NULL, 'Active', 0),
(4, 'Honda CD Deluxe', 'GJ03DF1212', 2000, '2019-11-25 13:07:33', 2, '2019-11-26 14:19:27', 2, 'Active', 0),
(5, 'Honda CD Deluxe', 'GJ06FC3218', 2000, '2019-11-25 13:07:52', 2, NULL, NULL, 'Active', 0),
(6, 'test', 'GJ01CA1233', 15000, '2019-11-26 14:33:53', 2, '2019-11-26 14:33:56', NULL, 'Active', 1);

-- --------------------------------------------------------

--
-- Table structure for table `warehouses`
--

CREATE TABLE `warehouses` (
  `id` int(11) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Active' COMMENT 'Active/Inactive',
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `warehouses`
--

INSERT INTO `warehouses` (`id`, `name`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`, `is_deleted`) VALUES
(1, 'Kalupur Warehouse', '2019-11-25 13:42:19', 2, NULL, NULL, 'Active', 0),
(2, 'Bopal Warehouse', '2019-11-25 13:42:24', 2, NULL, NULL, 'Active', 0);

-- --------------------------------------------------------

--
-- Table structure for table `zip_codes`
--

CREATE TABLE `zip_codes` (
  `id` int(11) NOT NULL,
  `zip_code` varchar(20) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `area` varchar(300) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Active' COMMENT 'Active/Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zip_codes`
--

INSERT INTO `zip_codes` (`id`, `zip_code`, `city_id`, `state_id`, `area`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`) VALUES
(1, '332024', 2, 1, 'Tarpura', '2019-11-25 12:58:45', 1, NULL, NULL, 'Active'),
(2, '332025', 2, 1, 'Losal', '2019-11-25 12:58:45', 1, NULL, NULL, 'Active'),
(3, '302012', 1, 1, 'Jhotwara', '2019-11-25 13:00:05', 1, '2019-11-26 15:40:25', 2, 'Active'),
(4, '302016', 1, 1, 'Bani Park', '2019-11-25 13:00:05', 1, NULL, NULL, 'Active'),
(5, '380024', 3, 2, 'ASARWA EXT SOUTH', '2019-11-25 13:01:33', 1, NULL, NULL, 'Active'),
(6, '380058', 3, 2, 'Bopal', '2019-11-25 13:01:33', 1, NULL, NULL, 'Active'),
(7, '382463', 3, 2, 'Kadi', '2019-11-25 13:02:26', 1, NULL, NULL, 'Active'),
(8, '382430', 3, 2, 'Kanbha', '2019-11-25 13:02:26', 1, NULL, NULL, 'Active'),
(10, '382308', 4, 2, 'Hilol', '2019-11-25 13:03:35', 1, NULL, NULL, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `zip_code_groups`
--

CREATE TABLE `zip_code_groups` (
  `id` int(11) NOT NULL,
  `group_name` varchar(200) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Active' COMMENT 'Active/Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zip_code_groups`
--

INSERT INTO `zip_code_groups` (`id`, `group_name`, `state_id`, `city_id`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`) VALUES
(1, 'Ahmedabad-1', 2, 3, '2019-11-25 13:04:38', 2, NULL, NULL, 'Active'),
(2, 'Ahmedabad-2', 2, 3, '2019-11-25 13:04:51', 2, NULL, NULL, 'Active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lead_id` (`lead_id`);

--
-- Indexes for table `client_categories`
--
ALTER TABLE `client_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `client_contacts`
--
ALTER TABLE `client_contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `client_delivery_addresses`
--
ALTER TABLE `client_delivery_addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `client_location_images`
--
ALTER TABLE `client_location_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `client_product_price`
--
ALTER TABLE `client_product_price`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `client_selesmans`
--
ALTER TABLE `client_selesmans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `client_visits`
--
ALTER TABLE `client_visits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lead_id` (`client_id`);

--
-- Indexes for table `coordinates`
--
ALTER TABLE `coordinates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery`
--
ALTER TABLE `delivery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_config`
--
ALTER TABLE `delivery_config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_config_orders`
--
ALTER TABLE `delivery_config_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_routes`
--
ALTER TABLE `delivery_routes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `group_to_zip_code`
--
ALTER TABLE `group_to_zip_code`
  ADD PRIMARY KEY (`id`),
  ADD KEY `zip_code_id` (`zip_code_id`),
  ADD KEY `zip_code_group_id` (`zip_code_group_id`);

--
-- Indexes for table `leads`
--
ALTER TABLE `leads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lead_visits`
--
ALTER TABLE `lead_visits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lead_id` (`lead_id`);

--
-- Indexes for table `mail_template`
--
ALTER TABLE `mail_template`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `order_delivery_images`
--
ALTER TABLE `order_delivery_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_details`
--
ALTER TABLE `payment_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schemes`
--
ALTER TABLE `schemes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scheme_products`
--
ALTER TABLE `scheme_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `user_devices`
--
ALTER TABLE `user_devices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_vehicle`
--
ALTER TABLE `user_vehicle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `vehicle_id` (`vehicle_id`);

--
-- Indexes for table `user_zip_codes`
--
ALTER TABLE `user_zip_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `zip_code_id` (`zip_code_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_zip_code_groups`
--
ALTER TABLE `user_zip_code_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `zip_code_group_id` (`zip_code_group_id`);

--
-- Indexes for table `vehicle`
--
ALTER TABLE `vehicle`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `warehouses`
--
ALTER TABLE `warehouses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zip_codes`
--
ALTER TABLE `zip_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zip_code_groups`
--
ALTER TABLE `zip_code_groups`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `client_categories`
--
ALTER TABLE `client_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `client_contacts`
--
ALTER TABLE `client_contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `client_delivery_addresses`
--
ALTER TABLE `client_delivery_addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `client_location_images`
--
ALTER TABLE `client_location_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `client_product_price`
--
ALTER TABLE `client_product_price`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `client_selesmans`
--
ALTER TABLE `client_selesmans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `client_visits`
--
ALTER TABLE `client_visits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `coordinates`
--
ALTER TABLE `coordinates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `delivery`
--
ALTER TABLE `delivery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `delivery_config`
--
ALTER TABLE `delivery_config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `delivery_config_orders`
--
ALTER TABLE `delivery_config_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `delivery_routes`
--
ALTER TABLE `delivery_routes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `group_to_zip_code`
--
ALTER TABLE `group_to_zip_code`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `leads`
--
ALTER TABLE `leads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `lead_visits`
--
ALTER TABLE `lead_visits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mail_template`
--
ALTER TABLE `mail_template`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `order_delivery_images`
--
ALTER TABLE `order_delivery_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `payment_details`
--
ALTER TABLE `payment_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `schemes`
--
ALTER TABLE `schemes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `scheme_products`
--
ALTER TABLE `scheme_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_devices`
--
ALTER TABLE `user_devices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_vehicle`
--
ALTER TABLE `user_vehicle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_zip_codes`
--
ALTER TABLE `user_zip_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_zip_code_groups`
--
ALTER TABLE `user_zip_code_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `vehicle`
--
ALTER TABLE `vehicle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `warehouses`
--
ALTER TABLE `warehouses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `zip_codes`
--
ALTER TABLE `zip_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `zip_code_groups`
--
ALTER TABLE `zip_code_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `clients_ibfk_1` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`);

--
-- Constraints for table `client_contacts`
--
ALTER TABLE `client_contacts`
  ADD CONSTRAINT `client_contacts_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`);

--
-- Constraints for table `lead_visits`
--
ALTER TABLE `lead_visits`
  ADD CONSTRAINT `lead_visits_ibfk_1` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`);

--
-- Constraints for table `order_delivery_images`
--
ALTER TABLE `order_delivery_images`
  ADD CONSTRAINT `order_delivery_images_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
