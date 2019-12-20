-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 20, 2019 at 06:53 AM
-- Server version: 10.1.43-MariaDB-cll-lve
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `letsolnx_neervana`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `brand_name` varchar(200) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Active' COMMENT 'Active/Inactive',
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `brand_name`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`, `is_deleted`) VALUES
(1, 'Kinley', '2019-11-25 13:33:58', 2, NULL, NULL, 'Active', 0),
(2, 'Bislery', '2019-11-25 13:34:07', 2, NULL, NULL, 'Active', 0),
(3, 'Bailley', '2019-11-25 13:34:39', 2, NULL, NULL, 'Active', 0),
(4, 'Aquafina', '2019-11-25 13:34:48', 2, '2019-12-02 19:22:43', 2, 'Active', 1),
(5, 'dsfsdfsdfsdsfsdfsdfsdsfsdfsdfsdsfsdfsdfsdsfsdfsdfsdsfsdfsdfsdsfsdfsdfsdsfsdfsdfsdsfsdfsdfsdsfsdfsdfsdsfsdfsdfsdsfsdfsdfsdsfsdfsdfsdsfsdfsdfsdsfsdfsdfsdsfsdfsdfsdsfsdfsdfsdsfsdfsdfsdsfsdfsdfsdfdfdf', '2019-11-26 14:31:50', 2, '2019-11-26 14:32:37', 2, 'Active', 1),
(6, 'Neervana', '2019-12-10 12:06:46', 2, NULL, NULL, 'Active', 0),
(7, 'Pure-neer', '2019-12-10 12:07:17', 2, NULL, NULL, 'Active', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cash_collection`
--

CREATE TABLE `cash_collection` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `amount` float DEFAULT '0',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 = Deleted',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 = Deleted',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
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
  `credit_limit` decimal(14,2) DEFAULT '0.00',
  `credit_balance` float(10,2) NOT NULL DEFAULT '0.00',
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
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Active' COMMENT 'Active/Inactive',
  `gst_no` varchar(50) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `client_name`, `credit_limit`, `credit_balance`, `address`, `city_id`, `state_id`, `zip_code_id`, `lead_id`, `lat`, `lng`, `contact_person_name_1`, `contact_person_1_phone_1`, `contact_person_1_phone_2`, `contact_person_1_email`, `contact_person_name_2`, `contact_person_2_phone_1`, `contact_person_2_phone_2`, `contact_person_2_email`, `is_deleted`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`, `gst_no`, `category_id`) VALUES
(1, 'Milan & Company', '0.00', 0.00, NULL, 3, 2, 8, 5, NULL, NULL, 'Milan Soni', '7600265925', NULL, 'milans@letsenkindle.com', NULL, NULL, NULL, NULL, 0, '2019-12-19 19:12:50', 5, NULL, NULL, 'Active', 'GJ 01 VV 1809', NULL),
(2, 'Ashish & Company', '0.00', 0.00, NULL, 3, 2, 6, 1, NULL, NULL, 'Ashish Makwana', '9510335127', NULL, 'ashishm@letsenkindle.com', 'Rakesh Jangir', '9166650505', NULL, 'rakeshj@letsenkindle.com', 0, '2019-12-19 19:53:36', 1, NULL, NULL, 'Active', 'ASH 1234', NULL),
(3, 'Rakesh & Company', '0.00', 0.00, NULL, 3, 2, 12, 2, NULL, NULL, 'Rakesh Jangir', '9166650505', NULL, 'rakeshj@letsenkindle.com', NULL, NULL, NULL, NULL, 0, '2019-12-19 22:29:01', 1, NULL, NULL, 'Active', 'GST 1234', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `client_categories`
--

CREATE TABLE `client_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Active' COMMENT 'Active/Inactive',
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0'
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
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
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
  `lead_id` int(11) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `address` varchar(500) DEFAULT NULL,
  `zip_code_id` int(11) DEFAULT NULL,
  `lat` float(9,6) DEFAULT NULL,
  `lng` float(9,6) DEFAULT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Active' COMMENT 'Active/Inactive	'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `client_delivery_addresses`
--

INSERT INTO `client_delivery_addresses` (`id`, `client_id`, `lead_id`, `title`, `address`, `zip_code_id`, `lat`, `lng`, `is_deleted`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`) VALUES
(1, 1, NULL, 'Office', 'Income Tax', 8, 23.045263, 72.568550, 0, '2019-12-19 19:12:27', 5, '2019-12-19 00:00:00', NULL, 'Active'),
(3, 2, NULL, 'Home', 'Bopal', 6, NULL, NULL, 0, '2019-12-19 19:53:03', 1, '2019-12-19 00:00:00', NULL, 'Active'),
(4, 3, NULL, 'Home 2', 'Janta Colony', 12, 23.045237, 72.568642, 0, '2019-12-19 22:28:48', 1, '2019-12-19 00:00:00', NULL, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `client_location_images`
--

CREATE TABLE `client_location_images` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `image_name` varchar(300) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `client_product_inventory`
--

CREATE TABLE `client_product_inventory` (
  `id` int(11) NOT NULL,
  `dco_id` int(11) DEFAULT NULL COMMENT 'delivery_config_orders.id',
  `client_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `existing_quentity` int(11) DEFAULT '0',
  `new_delivered` int(11) NOT NULL DEFAULT '0',
  `empty_collected` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Active' COMMENT 'Active/Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `client_product_inventory`
--

INSERT INTO `client_product_inventory` (`id`, `dco_id`, `client_id`, `product_id`, `existing_quentity`, `new_delivered`, `empty_collected`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`) VALUES
(9, 20, 1, 7, 0, 5, 0, '2019-12-20 00:00:00', 4, NULL, NULL, 'Active'),
(10, 21, 1, 7, 5, 10, 0, '2019-12-20 00:00:00', 3, NULL, NULL, 'Active'),
(11, 22, 1, 7, 15, 20, 5, '2019-12-20 00:00:00', 4, NULL, NULL, 'Active'),
(12, 23, 1, 7, 30, 3, 5, '2019-12-20 00:00:00', 4, NULL, NULL, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `client_product_price`
--

CREATE TABLE `client_product_price` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `sale_price` float NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Active' COMMENT 'Active/Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `client_product_price`
--

INSERT INTO `client_product_price` (`id`, `client_id`, `product_id`, `sale_price`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`) VALUES
(1, 1, 1, 262, '2019-12-19 19:12:50', NULL, '2019-12-19 11:01:11', NULL, 'Active'),
(2, 1, 2, 245, '2019-12-19 19:12:50', NULL, NULL, NULL, 'Active'),
(3, 1, 3, 250, '2019-12-19 19:12:50', NULL, '2019-12-19 08:44:20', NULL, 'Active'),
(4, 1, 4, 165, '2019-12-19 19:12:50', NULL, NULL, NULL, 'Active'),
(5, 1, 5, 189, '2019-12-19 19:12:50', NULL, '2019-12-20 05:44:56', NULL, 'Active'),
(6, 1, 7, 24, '2019-12-19 19:12:50', NULL, '2019-12-20 05:44:56', NULL, 'Active'),
(7, 1, 8, 18, '2019-12-19 19:12:50', NULL, NULL, NULL, 'Active'),
(8, 1, 9, 455, '2019-12-19 19:12:50', NULL, NULL, NULL, 'Active'),
(9, 1, 10, 120, '2019-12-19 19:12:50', NULL, NULL, NULL, 'Active'),
(10, 2, 1, 260, '2019-12-19 19:53:36', NULL, '2019-12-20 04:52:04', NULL, 'Active'),
(11, 2, 2, 245, '2019-12-19 19:53:36', NULL, NULL, NULL, 'Active'),
(12, 2, 3, 255, '2019-12-19 19:53:36', NULL, NULL, NULL, 'Active'),
(13, 2, 4, 165, '2019-12-19 19:53:36', NULL, NULL, NULL, 'Active'),
(14, 2, 5, 190, '2019-12-19 19:53:36', NULL, NULL, NULL, 'Active'),
(15, 2, 7, 25, '2019-12-19 19:53:36', NULL, NULL, NULL, 'Active'),
(16, 2, 8, 18, '2019-12-19 19:53:36', NULL, NULL, NULL, 'Active'),
(17, 2, 9, 455, '2019-12-19 19:53:36', NULL, NULL, NULL, 'Active'),
(18, 2, 10, 120, '2019-12-19 19:53:36', NULL, NULL, NULL, 'Active'),
(19, 3, 1, 263, '2019-12-19 22:29:01', NULL, '2019-12-20 04:18:42', NULL, 'Active'),
(20, 3, 2, 245, '2019-12-19 22:29:01', NULL, NULL, NULL, 'Active'),
(21, 3, 3, 255, '2019-12-19 22:29:01', NULL, NULL, NULL, 'Active'),
(22, 3, 4, 165, '2019-12-19 22:29:01', NULL, NULL, NULL, 'Active'),
(23, 3, 5, 190, '2019-12-19 22:29:01', NULL, NULL, NULL, 'Active'),
(24, 3, 7, 25, '2019-12-19 22:29:01', NULL, NULL, NULL, 'Active'),
(25, 3, 8, 18, '2019-12-19 22:29:01', NULL, NULL, NULL, 'Active'),
(26, 3, 9, 455, '2019-12-19 22:29:01', NULL, NULL, NULL, 'Active'),
(27, 3, 10, 120, '2019-12-19 22:29:01', NULL, NULL, NULL, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `client_selesmans`
--

CREATE TABLE `client_selesmans` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `salesman_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
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
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `coordinates`
--

CREATE TABLE `coordinates` (
  `id` int(11) NOT NULL,
  `lat` float(9,6) DEFAULT NULL,
  `lng` float(9,6) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `delivery`
--

CREATE TABLE `delivery` (
  `id` int(11) NOT NULL,
  `expected_delivey_datetime` date DEFAULT NULL,
  `actual_delivey_datetime` datetime DEFAULT NULL,
  `pickup_location` varchar(50) DEFAULT NULL,
  `warehouse` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Active' COMMENT 'Active/Inactive',
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `delivery`
--

INSERT INTO `delivery` (`id`, `expected_delivey_datetime`, `actual_delivey_datetime`, `pickup_location`, `warehouse`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`, `is_deleted`) VALUES
(2, '2019-12-19', '2019-12-19 23:13:40', 'Warehouse', 1, '2019-12-19 23:03:23', 8, '2019-12-19 00:00:00', 4, 'Active', 0),
(3, '2019-12-19', '2019-12-19 23:21:24', 'Office', NULL, '2019-12-19 23:05:23', 8, '2019-12-20 13:47:52', 8, 'Active', 0),
(21, '2019-12-20', '2019-12-20 14:59:56', 'Office', NULL, '2019-12-20 13:47:52', 8, '2019-12-20 00:00:00', 3, 'Active', 0),
(22, '2019-12-20', '2019-12-20 16:08:09', 'Office', NULL, '2019-12-20 15:22:18', 8, '2019-12-20 00:00:00', 4, 'Active', 0),
(23, '2019-12-20', '2019-12-20 16:20:26', 'Office', NULL, '2019-12-20 16:15:33', 8, '2019-12-20 00:00:00', 3, 'Active', 0),
(24, '2019-12-20', '2019-12-20 16:29:02', 'Office', NULL, '2019-12-20 16:27:21', 8, '2019-12-20 00:00:00', 4, 'Active', 0),
(25, '2019-12-20', '2019-12-20 16:32:30', 'Office', NULL, '2019-12-20 16:31:46', 8, '2019-12-20 00:00:00', 3, 'Active', 0),
(26, '2019-12-20', '2019-12-20 16:53:13', 'Office', NULL, '2019-12-20 16:35:43', 8, '2019-12-20 00:00:00', 4, 'Active', 0);

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
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Active' COMMENT 'Active/Inactive',
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `delivery_config`
--

INSERT INTO `delivery_config` (`id`, `delivery_id`, `vehicle_id`, `driver_id`, `delivery_boy_id`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`, `is_deleted`) VALUES
(2, 2, 1, 4, NULL, '2019-12-19 23:03:23', 8, NULL, NULL, 'Active', 0),
(3, 3, 1, 6, 3, '2019-12-19 23:05:23', 8, NULL, NULL, 'Active', 0),
(22, 21, 1, 4, 3, '2019-12-20 14:49:11', 8, NULL, NULL, 'Active', 0),
(23, 22, 1, 4, NULL, '2019-12-20 15:22:18', 8, NULL, NULL, 'Active', 0),
(24, 23, 1, 4, 3, '2019-12-20 16:15:33', 8, NULL, NULL, 'Active', 0),
(26, 24, 1, 4, NULL, '2019-12-20 16:28:19', 8, NULL, NULL, 'Active', 0),
(27, 25, 1, 4, 3, '2019-12-20 16:31:46', 8, NULL, NULL, 'Active', 0),
(28, 26, 1, 4, NULL, '2019-12-20 16:35:43', 8, NULL, NULL, 'Active', 0);

-- --------------------------------------------------------

--
-- Table structure for table `delivery_config_orders`
--

CREATE TABLE `delivery_config_orders` (
  `id` int(11) NOT NULL,
  `delivery_id` int(11) DEFAULT NULL,
  `delivery_config_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `order_weight` float NOT NULL DEFAULT '0',
  `payment_mode` varchar(50) DEFAULT NULL,
  `amount` float DEFAULT '0' COMMENT 'Amount Recieved at delivey time',
  `notes` varchar(500) DEFAULT NULL,
  `delivery_datetime` datetime DEFAULT NULL,
  `signature_file` varchar(300) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Active' COMMENT 'Active/Inactive',
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `delivery_config_orders`
--

INSERT INTO `delivery_config_orders` (`id`, `delivery_id`, `delivery_config_id`, `order_id`, `order_weight`, `payment_mode`, `amount`, `notes`, `delivery_datetime`, `signature_file`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`, `is_deleted`) VALUES
(3, 2, 2, 5, 0, 'Cash', 6270, 'Product recieved and 6270 rs given.', '2019-12-19 23:13:40', '1576777396279.png', '2019-12-19 23:03:23', 8, '2019-12-19 00:00:00', 4, 'Active', 0),
(4, 3, 3, 1, 0, 'Cash', 19357, '5 jars recieved', '2019-12-19 23:21:24', '1576777855169.png', '2019-12-19 23:05:23', 8, '2019-12-20 01:06:03', 3, 'Active', 0),
(11, 21, 22, 2, 0, 'Cash', 25200, 'ashish recieved order', '2019-12-20 14:52:17', '1576833719966.png', '2019-12-20 14:49:11', 8, '2019-12-20 00:00:00', 3, 'Active', 0),
(12, 21, 22, 6, 0, 'Cash', 2499, 'rakesh recieved order', '2019-12-20 14:58:53', '1576834115242.png', '2019-12-20 14:49:11', 8, '2019-12-20 00:00:00', 3, 'Active', 0),
(13, 21, 22, 7, 0, 'Cash', 1245, 'milan ne lia', '2019-12-20 14:59:56', '1576834186386.png', '2019-12-20 14:49:11', 8, '2019-12-20 00:00:00', 3, 'Active', 0),
(14, 22, 23, 8, 0, 'Cash', 125, '9 inv', '2019-12-20 15:24:30', '1576835599335.png', '2019-12-20 15:22:18', 8, '2019-12-20 00:00:00', 4, 'Active', 0),
(15, 22, 23, 9, 0, 'Cash', 1235, 'ashish given 1235 rs', '2019-12-20 16:08:09', '15768382502811.png', '2019-12-20 15:22:18', 8, '2019-12-20 00:00:00', 4, 'Active', 0),
(16, 23, 24, 10, 0, 'Cash', 2408, 'milan gave 2408 rs', '2019-12-20 16:17:05', '1576838810264.png', '2019-12-20 16:15:33', 8, '2019-12-20 00:00:00', 3, 'Active', 0),
(17, 23, 24, 11, 0, 'Cash', 125, '5', '2019-12-20 16:18:34', '1576838873735.png', '2019-12-20 16:15:33', 8, '2019-12-20 00:00:00', 3, 'Active', 0),
(18, 23, 24, 12, 0, 'Cash', 310, '9', '2019-12-20 16:20:26', '1576839006894.png', '2019-12-20 16:15:33', 8, '2019-12-20 00:00:00', 3, 'Active', 0),
(20, 24, 26, 13, 0, 'Cash', 124, '5 dropped', '2019-12-20 16:29:02', '1576839517719.png', '2019-12-20 16:28:19', 8, '2019-12-20 00:00:00', 4, 'Active', 0),
(21, 25, 27, 14, 0, 'Cash', 0, '5 old 10 new 0 collected', '2019-12-20 16:32:30', NULL, '2019-12-20 16:31:46', 8, '2019-12-20 00:00:00', 3, 'Active', 0),
(22, 26, 28, 15, 0, 'Cash', 9433, '20 drop 5 taken', '2019-12-20 16:37:21', '1576840024764.png', '2019-12-20 16:35:43', 8, '2019-12-20 00:00:00', 4, 'Active', 0),
(23, 26, 28, 16, 0, 'Cash', 72, '5 collected', '2019-12-20 16:53:13', '1576840978330.png', '2019-12-20 16:35:43', 8, '2019-12-20 00:00:00', 4, 'Active', 0);

-- --------------------------------------------------------

--
-- Table structure for table `delivery_routes`
--

CREATE TABLE `delivery_routes` (
  `id` int(11) NOT NULL,
  `delivery_id` int(11) DEFAULT NULL,
  `zip_code_group_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Active' COMMENT 'Active/Inactive',
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `delivery_routes`
--

INSERT INTO `delivery_routes` (`id`, `delivery_id`, `zip_code_group_id`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`, `is_deleted`) VALUES
(2, 2, 1, '2019-12-19 23:03:23', 8, NULL, NULL, 'Active', 0),
(3, 3, 1, '2019-12-19 23:05:23', 8, NULL, NULL, 'Active', 0),
(4, 4, 1, '2019-12-20 12:34:19', 8, NULL, NULL, 'Active', 0),
(5, 5, 1, '2019-12-20 13:23:36', 8, NULL, NULL, 'Active', 0),
(7, 7, 1, '2019-12-20 13:28:34', 8, NULL, NULL, 'Active', 0),
(14, 14, 1, '2019-12-20 13:37:21', 8, NULL, NULL, 'Active', 0),
(22, 21, 1, '2019-12-20 14:49:11', 8, NULL, NULL, 'Active', 0),
(23, 22, 1, '2019-12-20 15:22:18', 8, NULL, NULL, 'Active', 0),
(24, 23, 1, '2019-12-20 16:15:33', 8, NULL, NULL, 'Active', 0),
(26, 24, 1, '2019-12-20 16:28:19', 8, NULL, NULL, 'Active', 0),
(27, 25, 1, '2019-12-20 16:31:46', 8, NULL, NULL, 'Active', 0),
(28, 26, 1, '2019-12-20 16:35:43', 8, NULL, NULL, 'Active', 0);

-- --------------------------------------------------------

--
-- Table structure for table `fcm_notifications`
--

CREATE TABLE `fcm_notifications` (
  `id` int(11) NOT NULL,
  `title` varchar(200) DEFAULT NULL,
  `message` varchar(500) DEFAULT NULL,
  `user_arr` varchar(1500) DEFAULT NULL,
  `fcm_tokens` varchar(1000) DEFAULT NULL,
  `response` varchar(500) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Active' COMMENT 'Active/Inactive '
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fcm_notifications`
--

INSERT INTO `fcm_notifications` (`id`, `title`, `message`, `user_arr`, `fcm_tokens`, `response`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`) VALUES
(18, 'Order Approved', 'Order No. 2 for Ashish & Company has been approved with final amount 25200. Delivery date is 2019-12-21', '[{\"user_id\":\"1\",\"device_id\":\"dsIcxv1Cfa0:APA91bGQZqoNRLtObz-MqVUlsiVVQyP1o5O-ryqTvQy242Eyl0ImcJqky46MLc0_G51UK14TeQP4CHHDh3-VyGnFM-gNxjCxawvY5DFnoR6ouk09FDlNhfvFBGQDLjV1lwb3OfAjXdj4\"}]', '[\"dsIcxv1Cfa0:APA91bGQZqoNRLtObz-MqVUlsiVVQyP1o5O-ryqTvQy242Eyl0ImcJqky46MLc0_G51UK14TeQP4CHHDh3-VyGnFM-gNxjCxawvY5DFnoR6ouk09FDlNhfvFBGQDLjV1lwb3OfAjXdj4\"]', '{\"multicast_id\":7742440959677957222,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576775342350038%c07a64c8f9fd7ecd\"}]}', '2019-12-19 22:39:02', 8, NULL, NULL, 'Active'),
(19, 'Order Approved', 'Order No. 5 for Rakesh & Company has been approved with final amount 6270. Delivery date is 2019-12-24', '[{\"user_id\":\"1\",\"device_id\":\"dsIcxv1Cfa0:APA91bGQZqoNRLtObz-MqVUlsiVVQyP1o5O-ryqTvQy242Eyl0ImcJqky46MLc0_G51UK14TeQP4CHHDh3-VyGnFM-gNxjCxawvY5DFnoR6ouk09FDlNhfvFBGQDLjV1lwb3OfAjXdj4\"}]', '[\"dsIcxv1Cfa0:APA91bGQZqoNRLtObz-MqVUlsiVVQyP1o5O-ryqTvQy242Eyl0ImcJqky46MLc0_G51UK14TeQP4CHHDh3-VyGnFM-gNxjCxawvY5DFnoR6ouk09FDlNhfvFBGQDLjV1lwb3OfAjXdj4\"]', '{\"multicast_id\":5084893789417760570,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576775377059514%c07a64c8f9fd7ecd\"}]}', '2019-12-19 22:39:37', 8, NULL, NULL, 'Active'),
(20, 'Order Delivery', 'Delivery created for Rakesh & Company at Janta Colony with expected delivery on 19-12-2019 having order amount Rs. 6270 with Order Id 5', '[{\"user_id\":\"4\",\"device_id\":\"dsIcxv1Cfa0:APA91bGQZqoNRLtObz-MqVUlsiVVQyP1o5O-ryqTvQy242Eyl0ImcJqky46MLc0_G51UK14TeQP4CHHDh3-VyGnFM-gNxjCxawvY5DFnoR6ouk09FDlNhfvFBGQDLjV1lwb3OfAjXdj4\"}]', '[\"dsIcxv1Cfa0:APA91bGQZqoNRLtObz-MqVUlsiVVQyP1o5O-ryqTvQy242Eyl0ImcJqky46MLc0_G51UK14TeQP4CHHDh3-VyGnFM-gNxjCxawvY5DFnoR6ouk09FDlNhfvFBGQDLjV1lwb3OfAjXdj4\"]', '{\"multicast_id\":7122467444509149855,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576776804014650%c07a64c8f9fd7ecd\"}]}', '2019-12-19 23:03:24', 8, NULL, NULL, 'Active'),
(21, 'Order Delivery', 'Delivery created for Milan & Company at Income Tax with expected delivery on 19-12-2019 having order amount Rs. 19356.25 with Order Id 1', '[{\"user_id\":\"6\",\"device_id\":\"dsIcxv1Cfa0:APA91bGQZqoNRLtObz-MqVUlsiVVQyP1o5O-ryqTvQy242Eyl0ImcJqky46MLc0_G51UK14TeQP4CHHDh3-VyGnFM-gNxjCxawvY5DFnoR6ouk09FDlNhfvFBGQDLjV1lwb3OfAjXdj4\"}]', '[\"dsIcxv1Cfa0:APA91bGQZqoNRLtObz-MqVUlsiVVQyP1o5O-ryqTvQy242Eyl0ImcJqky46MLc0_G51UK14TeQP4CHHDh3-VyGnFM-gNxjCxawvY5DFnoR6ouk09FDlNhfvFBGQDLjV1lwb3OfAjXdj4\"]', '{\"multicast_id\":2752791447834859014,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576776923821661%c07a64c8f9fd7ecd\"}]}', '2019-12-19 23:05:23', 8, NULL, NULL, 'Active'),
(22, 'Order Delivery', 'Delivery created for Ashish & Company at Bopal with expected delivery on 19-12-2019 having order amount Rs. 25200 with Order Id 2', '[{\"user_id\":\"6\",\"device_id\":\"dsIcxv1Cfa0:APA91bGQZqoNRLtObz-MqVUlsiVVQyP1o5O-ryqTvQy242Eyl0ImcJqky46MLc0_G51UK14TeQP4CHHDh3-VyGnFM-gNxjCxawvY5DFnoR6ouk09FDlNhfvFBGQDLjV1lwb3OfAjXdj4\"}]', '[\"dsIcxv1Cfa0:APA91bGQZqoNRLtObz-MqVUlsiVVQyP1o5O-ryqTvQy242Eyl0ImcJqky46MLc0_G51UK14TeQP4CHHDh3-VyGnFM-gNxjCxawvY5DFnoR6ouk09FDlNhfvFBGQDLjV1lwb3OfAjXdj4\"]', '{\"multicast_id\":6477479589139525396,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576776924125495%c07a64c8f9fd7ecd\"}]}', '2019-12-19 23:05:24', 8, NULL, NULL, 'Active'),
(23, 'Order Delivery', 'Delivery created for Ashish & Company at Bopal with expected delivery on 20-12-2019 having order amount Rs. 25200 with Order Id 2', '[{\"user_id\":\"4\",\"device_id\":\"dsIcxv1Cfa0:APA91bGQZqoNRLtObz-MqVUlsiVVQyP1o5O-ryqTvQy242Eyl0ImcJqky46MLc0_G51UK14TeQP4CHHDh3-VyGnFM-gNxjCxawvY5DFnoR6ouk09FDlNhfvFBGQDLjV1lwb3OfAjXdj4\"}]', '[\"dsIcxv1Cfa0:APA91bGQZqoNRLtObz-MqVUlsiVVQyP1o5O-ryqTvQy242Eyl0ImcJqky46MLc0_G51UK14TeQP4CHHDh3-VyGnFM-gNxjCxawvY5DFnoR6ouk09FDlNhfvFBGQDLjV1lwb3OfAjXdj4\"]', '{\"multicast_id\":8981126976601616820,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576825459541601%c07a64c8f9fd7ecd\"}]}', '2019-12-20 12:34:19', 8, NULL, NULL, 'Active'),
(24, 'Order Delivery', 'Delivery created for Ashish & Company at Bopal with expected delivery on 20-12-2019 having order amount Rs. 25200 with Order Id 2', '[{\"user_id\":\"4\",\"device_id\":\"dsIcxv1Cfa0:APA91bGQZqoNRLtObz-MqVUlsiVVQyP1o5O-ryqTvQy242Eyl0ImcJqky46MLc0_G51UK14TeQP4CHHDh3-VyGnFM-gNxjCxawvY5DFnoR6ouk09FDlNhfvFBGQDLjV1lwb3OfAjXdj4\"}]', '[\"dsIcxv1Cfa0:APA91bGQZqoNRLtObz-MqVUlsiVVQyP1o5O-ryqTvQy242Eyl0ImcJqky46MLc0_G51UK14TeQP4CHHDh3-VyGnFM-gNxjCxawvY5DFnoR6ouk09FDlNhfvFBGQDLjV1lwb3OfAjXdj4\"]', '{\"multicast_id\":644127184181993361,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576828416462460%c07a64c8f9fd7ecd\"}]}', '2019-12-20 13:23:36', 8, NULL, NULL, 'Active'),
(25, 'Order Delivery', 'Delivery created for Ashish & Company at Bopal with expected delivery on 20-12-2019 having order amount Rs. 25200 with Order Id 2', '[{\"user_id\":\"4\",\"device_id\":\"dsIcxv1Cfa0:APA91bGQZqoNRLtObz-MqVUlsiVVQyP1o5O-ryqTvQy242Eyl0ImcJqky46MLc0_G51UK14TeQP4CHHDh3-VyGnFM-gNxjCxawvY5DFnoR6ouk09FDlNhfvFBGQDLjV1lwb3OfAjXdj4\"}]', '[\"dsIcxv1Cfa0:APA91bGQZqoNRLtObz-MqVUlsiVVQyP1o5O-ryqTvQy242Eyl0ImcJqky46MLc0_G51UK14TeQP4CHHDh3-VyGnFM-gNxjCxawvY5DFnoR6ouk09FDlNhfvFBGQDLjV1lwb3OfAjXdj4\"]', '{\"multicast_id\":5635498220516117058,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576828715147025%c07a64c8f9fd7ecd\"}]}', '2019-12-20 13:28:35', 8, NULL, NULL, 'Active'),
(26, 'Order Delivery', 'Delivery created for Ashish & Company at Bopal with expected delivery on 20-12-2019 having order amount Rs. 25200 with Order Id 2', '[{\"user_id\":\"4\",\"device_id\":\"dsIcxv1Cfa0:APA91bGQZqoNRLtObz-MqVUlsiVVQyP1o5O-ryqTvQy242Eyl0ImcJqky46MLc0_G51UK14TeQP4CHHDh3-VyGnFM-gNxjCxawvY5DFnoR6ouk09FDlNhfvFBGQDLjV1lwb3OfAjXdj4\"}]', '[\"dsIcxv1Cfa0:APA91bGQZqoNRLtObz-MqVUlsiVVQyP1o5O-ryqTvQy242Eyl0ImcJqky46MLc0_G51UK14TeQP4CHHDh3-VyGnFM-gNxjCxawvY5DFnoR6ouk09FDlNhfvFBGQDLjV1lwb3OfAjXdj4\"]', '{\"multicast_id\":17994197461095674,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576829242213562%c07a64c8f9fd7ecd\"}]}', '2019-12-20 13:37:22', 8, NULL, NULL, 'Active'),
(27, 'Order Delivery', 'Delivery created for Ashish & Company at Bopal with expected delivery on 20-12-2019 having order amount Rs. 25200 with Order Id 2', '[{\"user_id\":\"4\",\"device_id\":\"dsIcxv1Cfa0:APA91bGQZqoNRLtObz-MqVUlsiVVQyP1o5O-ryqTvQy242Eyl0ImcJqky46MLc0_G51UK14TeQP4CHHDh3-VyGnFM-gNxjCxawvY5DFnoR6ouk09FDlNhfvFBGQDLjV1lwb3OfAjXdj4\"}]', '[\"dsIcxv1Cfa0:APA91bGQZqoNRLtObz-MqVUlsiVVQyP1o5O-ryqTvQy242Eyl0ImcJqky46MLc0_G51UK14TeQP4CHHDh3-VyGnFM-gNxjCxawvY5DFnoR6ouk09FDlNhfvFBGQDLjV1lwb3OfAjXdj4\"]', '{\"multicast_id\":136433482616542714,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576829872813609%c07a64c8f9fd7ecd\"}]}', '2019-12-20 13:47:52', 8, NULL, NULL, 'Active'),
(28, 'Order Approved', 'Order No. 12 for Milan & Company has been approved with final amount 310. Delivery date is 2019-12-20', '[{\"user_id\":\"5\",\"device_id\":\"dsIcxv1Cfa0:APA91bGQZqoNRLtObz-MqVUlsiVVQyP1o5O-ryqTvQy242Eyl0ImcJqky46MLc0_G51UK14TeQP4CHHDh3-VyGnFM-gNxjCxawvY5DFnoR6ouk09FDlNhfvFBGQDLjV1lwb3OfAjXdj4\"}]', '[\"dsIcxv1Cfa0:APA91bGQZqoNRLtObz-MqVUlsiVVQyP1o5O-ryqTvQy242Eyl0ImcJqky46MLc0_G51UK14TeQP4CHHDh3-VyGnFM-gNxjCxawvY5DFnoR6ouk09FDlNhfvFBGQDLjV1lwb3OfAjXdj4\"]', '{\"multicast_id\":4817469869684442473,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576838697151948%c07a64c8f9fd7ecd\"}]}', '2019-12-20 16:14:57', 8, NULL, NULL, 'Active'),
(29, 'Order Delivery', 'Delivery updated for Milan & Company at Income Tax with expected delivery on 20-12-2019 having order amount Rs. 120 with Order Id 13', '[{\"user_id\":\"4\",\"device_id\":\"dsIcxv1Cfa0:APA91bGQZqoNRLtObz-MqVUlsiVVQyP1o5O-ryqTvQy242Eyl0ImcJqky46MLc0_G51UK14TeQP4CHHDh3-VyGnFM-gNxjCxawvY5DFnoR6ouk09FDlNhfvFBGQDLjV1lwb3OfAjXdj4\"}]', '[\"dsIcxv1Cfa0:APA91bGQZqoNRLtObz-MqVUlsiVVQyP1o5O-ryqTvQy242Eyl0ImcJqky46MLc0_G51UK14TeQP4CHHDh3-VyGnFM-gNxjCxawvY5DFnoR6ouk09FDlNhfvFBGQDLjV1lwb3OfAjXdj4\"]', '{\"multicast_id\":2423117427290443965,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576839499367816%c07a64c8f9fd7ecd\"}]}', '2019-12-20 16:28:19', 8, NULL, NULL, 'Active'),
(30, 'Order Delivery', 'Delivery created for Milan & Company at Income Tax with expected delivery on 20-12-2019 having order amount Rs. 9433.5 with Order Id 15', '[{\"user_id\":\"4\",\"device_id\":\"dsIcxv1Cfa0:APA91bGQZqoNRLtObz-MqVUlsiVVQyP1o5O-ryqTvQy242Eyl0ImcJqky46MLc0_G51UK14TeQP4CHHDh3-VyGnFM-gNxjCxawvY5DFnoR6ouk09FDlNhfvFBGQDLjV1lwb3OfAjXdj4\"}]', '[\"dsIcxv1Cfa0:APA91bGQZqoNRLtObz-MqVUlsiVVQyP1o5O-ryqTvQy242Eyl0ImcJqky46MLc0_G51UK14TeQP4CHHDh3-VyGnFM-gNxjCxawvY5DFnoR6ouk09FDlNhfvFBGQDLjV1lwb3OfAjXdj4\"]', '{\"multicast_id\":338459548843505674,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576839943424268%c07a64c8f9fd7ecd\"}]}', '2019-12-20 16:35:43', 8, NULL, NULL, 'Active'),
(31, 'Order Delivery', 'Delivery created for Milan & Company at Income Tax with expected delivery on 20-12-2019 having order amount Rs. 72 with Order Id 16', '[{\"user_id\":\"4\",\"device_id\":\"dsIcxv1Cfa0:APA91bGQZqoNRLtObz-MqVUlsiVVQyP1o5O-ryqTvQy242Eyl0ImcJqky46MLc0_G51UK14TeQP4CHHDh3-VyGnFM-gNxjCxawvY5DFnoR6ouk09FDlNhfvFBGQDLjV1lwb3OfAjXdj4\"}]', '[\"dsIcxv1Cfa0:APA91bGQZqoNRLtObz-MqVUlsiVVQyP1o5O-ryqTvQy242Eyl0ImcJqky46MLc0_G51UK14TeQP4CHHDh3-VyGnFM-gNxjCxawvY5DFnoR6ouk09FDlNhfvFBGQDLjV1lwb3OfAjXdj4\"]', '{\"multicast_id\":7628023269181147947,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576839943733382%c07a64c8f9fd7ecd\"}]}', '2019-12-20 16:35:43', 8, NULL, NULL, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `fcm_notification_user`
--

CREATE TABLE `fcm_notification_user` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `notification_id` int(11) DEFAULT NULL,
  `is_read` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Active' COMMENT 'Active/Inactive '
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fcm_notification_user`
--

INSERT INTO `fcm_notification_user` (`id`, `user_id`, `notification_id`, `is_read`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`) VALUES
(30, 1, 18, 0, '2019-12-19 22:39:02', 8, NULL, NULL, 'Active'),
(31, 1, 19, 0, '2019-12-19 22:39:37', 8, NULL, NULL, 'Active'),
(32, 4, 20, 0, '2019-12-19 23:03:24', 8, NULL, NULL, 'Active'),
(33, 6, 21, 0, '2019-12-19 23:05:23', 8, NULL, NULL, 'Active'),
(34, 6, 22, 0, '2019-12-19 23:05:24', 8, NULL, NULL, 'Active'),
(35, 4, 23, 0, '2019-12-20 12:34:19', 8, NULL, NULL, 'Active'),
(36, 4, 24, 0, '2019-12-20 13:23:36', 8, NULL, NULL, 'Active'),
(37, 4, 25, 0, '2019-12-20 13:28:35', 8, NULL, NULL, 'Active'),
(38, 4, 26, 0, '2019-12-20 13:37:22', 8, NULL, NULL, 'Active'),
(39, 4, 27, 0, '2019-12-20 13:47:52', 8, NULL, NULL, 'Active'),
(40, 5, 28, 0, '2019-12-20 16:14:57', 8, NULL, NULL, 'Active'),
(41, 4, 29, 0, '2019-12-20 16:28:19', 8, NULL, NULL, 'Active'),
(42, 4, 30, 0, '2019-12-20 16:35:43', 8, NULL, NULL, 'Active'),
(43, 4, 31, 0, '2019-12-20 16:35:43', 8, NULL, NULL, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `group_to_zip_code`
--

CREATE TABLE `group_to_zip_code` (
  `id` int(11) NOT NULL,
  `zip_code_group_id` int(11) DEFAULT NULL,
  `zip_code_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Active' COMMENT 'Active/Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `group_to_zip_code`
--

INSERT INTO `group_to_zip_code` (`id`, `zip_code_group_id`, `zip_code_id`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`) VALUES
(1, 1, 5, '2019-12-19 17:37:52', 2, NULL, NULL, 'Active'),
(2, 1, 6, '2019-12-19 17:37:52', 2, NULL, NULL, 'Active'),
(3, 1, 7, '2019-12-19 17:37:52', 2, NULL, NULL, 'Active'),
(4, 1, 8, '2019-12-19 17:37:52', 2, NULL, NULL, 'Active'),
(5, 1, 12, '2019-12-19 17:37:52', 2, NULL, NULL, 'Active'),
(6, 2, 10, '2019-12-19 17:38:13', 2, NULL, NULL, 'Active'),
(7, 3, 3, '2019-12-19 17:38:40', 2, NULL, NULL, 'Active'),
(8, 3, 4, '2019-12-19 17:38:40', 2, NULL, NULL, 'Active'),
(9, 3, 13, '2019-12-19 17:38:40', 2, NULL, NULL, 'Active'),
(10, 4, 1, '2019-12-19 17:38:53', 2, NULL, NULL, 'Active'),
(11, 4, 2, '2019-12-19 17:38:53', 2, NULL, NULL, 'Active');

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
  `is_converted` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `leads`
--

INSERT INTO `leads` (`id`, `company_name`, `contact_person_name`, `email`, `phone_1`, `phone_2`, `is_converted`, `created_at`, `created_by`, `updated_at`, `updated_by`, `is_deleted`) VALUES
(1, 'Ashish & Company', 'Ashish Makwana', 'ashishm@letsenkindle.com', '9510335127', NULL, 1, '2019-12-19 18:12:16', 1, '2019-12-19 09:23:36', 2, 0),
(2, 'Rakesh & Company', 'Rakesh Jangir', 'rakeshj@letsenkindle.com', '9166650505', NULL, 1, '2019-12-19 18:17:54', 1, '2019-12-19 11:59:01', NULL, 0),
(4, 'Snehal & Company', 'Snehal Trapsiya', 'snehalt@letsenkindle.com', '9773083060', NULL, 0, '2019-12-19 18:45:30', 8, NULL, NULL, 0),
(5, 'Milan & Company', 'Milan Soni', 'milans@letsenkindle.com', '7600265925', NULL, 1, '2019-12-19 19:05:21', 5, '2019-12-19 08:42:50', NULL, 0);

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
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lead_visits`
--

INSERT INTO `lead_visits` (`id`, `lead_id`, `visit_date`, `visit_time`, `visit_type`, `opportunity`, `other_notes`, `visit_notes`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 1, '2019-12-19', '18:12:16', 'InPerson', NULL, NULL, 'Lead added by Salesman Ashish Makwana on 19-12-2019', '2019-12-19 00:00:00', 1, NULL, NULL),
(2, 1, '2019-12-20', '21:46:00', 'phone', 'Monthly order for 20 ltr bottles', NULL, 'Nice Client', '2019-12-19 18:50:12', 1, NULL, NULL),
(3, 5, '2019-12-19', '19:05:21', 'InPerson', NULL, NULL, 'Lead added by Rakesh Salesman on 19-12-2019', '2019-12-19 00:00:00', 5, NULL, NULL),
(4, 5, '2019-12-19', '22:06:00', 'inperson', 'bhayankar opportunity hai boss', NULL, 'time pe ajana', '2019-12-19 19:06:15', 5, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mail_template`
--

CREATE TABLE `mail_template` (
  `id` int(11) NOT NULL,
  `template_body` text CHARACTER SET utf8,
  `type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `expected_delivery_date_in_deliver_table` date DEFAULT NULL,
  `actual_delivery_date` date DEFAULT NULL,
  `payable_amount` float(10,2) DEFAULT '0.00',
  `delivery_id` int(11) DEFAULT NULL,
  `payment_mode` varchar(50) DEFAULT NULL,
  `payment_schedule_date` date DEFAULT NULL,
  `payment_schedule_time` time DEFAULT NULL,
  `order_status` varchar(50) NOT NULL DEFAULT 'Pending' COMMENT 'Pending/Approval Required/Approved/Rejected',
  `status` varchar(20) NOT NULL DEFAULT 'Active' COMMENT 'Active/Inactive',
  `payment_status` varchar(30) NOT NULL DEFAULT 'Pending' COMMENT 'Pending/Partial/Paid',
  `need_admin_approval` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `client_id`, `delivery_address_id`, `scheme_id`, `priority`, `delivery_boy_id`, `expected_delivery_date`, `expected_delivery_date_in_deliver_table`, `actual_delivery_date`, `payable_amount`, `delivery_id`, `payment_mode`, `payment_schedule_date`, `payment_schedule_time`, `order_status`, `status`, `payment_status`, `need_admin_approval`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 1, 1, 1, 'High', NULL, '2019-12-20', '2019-12-19', '2019-12-19', 20375.00, 3, 'Cash', '2019-12-20', '22:00:00', 'Delivered', 'Active', 'Pending', 1, '2019-12-19 19:12:50', 5, '2019-12-19 00:00:00', 3),
(2, 2, 3, 2, 'Medium', NULL, '2019-12-21', '2019-12-20', '2019-12-20', 25300.00, 21, 'Cash', '2019-12-21', '19:53:00', 'Delivered', 'Active', 'Pending', 1, '2019-12-19 19:53:36', 1, '2019-12-20 00:00:00', 3),
(5, 3, 4, 1, 'Low', NULL, '2019-12-24', '2019-12-19', '2019-12-19', 6600.00, 2, 'Cash', '2019-12-24', '22:28:00', 'Delivered', 'Active', 'Pending', 1, '2019-12-19 22:29:01', 1, '2019-12-19 00:00:00', 4),
(6, 3, 4, 1, 'Medium', NULL, '2019-12-20', '2019-12-20', '2019-12-20', 2630.00, 21, 'Cash', '2019-12-20', '12:22:00', 'Delivered', 'Active', 'Pending', 1, '2019-12-20 12:22:10', 1, '2019-12-20 00:00:00', 3),
(7, 1, 1, 1, 'Urgent', NULL, '2019-12-20', '2019-12-20', '2019-12-20', 1310.00, 21, 'Cash', '2019-12-20', '14:48:00', 'Delivered', 'Active', 'Pending', 0, '2019-12-20 14:48:15', 5, '2019-12-20 00:00:00', 3),
(8, 1, 1, 0, 'Low', NULL, '2019-12-20', '2019-12-20', '2019-12-20', 125.00, 22, 'Cash', '2019-12-20', '15:20:00', 'Delivered', 'Active', 'Pending', 0, '2019-12-20 15:20:52', 1, '2019-12-20 00:00:00', 4),
(9, 2, 3, 1, 'Low', NULL, '2019-12-20', '2019-12-20', '2019-12-20', 1300.00, 22, 'Cash', '2019-12-20', '15:21:00', 'Delivered', 'Active', 'Pending', 1, '2019-12-20 15:21:41', 1, '2019-12-20 00:00:00', 4),
(10, 1, 1, 1, 'Low', NULL, '2019-12-20', '2019-12-20', '2019-12-20', 2535.00, 23, 'Cash', '2019-12-20', '16:10:00', 'Delivered', 'Active', 'Pending', 0, '2019-12-20 16:10:44', 5, '2019-12-20 00:00:00', 3),
(11, 1, 1, 0, 'Low', NULL, '2019-12-20', '2019-12-20', '2019-12-20', 125.00, 23, 'Cash', '2019-12-20', '16:11:00', 'Delivered', 'Active', 'Pending', 0, '2019-12-20 16:11:43', 5, '2019-12-20 00:00:00', 3),
(12, 1, 1, 0, 'Low', NULL, '2019-12-20', '2019-12-20', '2019-12-20', 310.00, 23, 'Cash', '2019-12-20', '16:14:00', 'Delivered', 'Active', 'Pending', 1, '2019-12-20 16:14:32', 5, '2019-12-20 00:00:00', 3),
(13, 1, 1, 0, 'Low', NULL, '2019-12-20', '2019-12-20', '2019-12-20', 120.00, 24, 'Cash', '2019-12-20', '16:26:00', 'Delivered', 'Active', 'Pending', 0, '2019-12-20 16:26:57', 1, '2019-12-20 00:00:00', 4),
(14, 1, 1, 0, 'Low', NULL, '2019-12-20', '2019-12-20', '2019-12-20', 240.00, 25, 'Cash', '2019-12-20', '16:31:00', 'Delivered', 'Active', 'Pending', 0, '2019-12-20 16:31:23', 1, '2019-12-20 00:00:00', 3),
(15, 1, 1, 1, 'Low', NULL, '2019-12-20', '2019-12-20', '2019-12-20', 9930.00, 26, 'Cash', '2019-12-20', '16:34:00', 'Delivered', 'Active', 'Pending', 0, '2019-12-20 16:34:42', 1, '2019-12-20 00:00:00', 4),
(16, 1, 1, 0, 'Low', NULL, '2019-12-20', '2019-12-20', '2019-12-20', 72.00, 26, 'Cash', '2019-12-20', '16:35:00', 'Delivered', 'Active', 'Pending', 0, '2019-12-20 16:35:05', 1, '2019-12-20 00:00:00', 4);

-- --------------------------------------------------------

--
-- Table structure for table `order_delivery_images`
--

CREATE TABLE `order_delivery_images` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `image_name` varchar(300) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
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
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `actual_price`, `effective_price`, `subtotal`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 1, 3, 5, 250, 250, '1250.00', '2019-12-19 19:12:50', 5, '2019-12-19 08:44:20', NULL),
(2, 1, 5, 100, 190, 190, '19000.00', '2019-12-19 19:12:50', 5, NULL, NULL),
(3, 1, 7, 5, 25, 25, '125.00', '2019-12-19 19:12:50', 5, NULL, NULL),
(4, 2, 1, 50, 261, 261, '13000.00', '2019-12-19 19:53:36', 1, '2019-12-19 09:26:51', NULL),
(5, 2, 2, 50, 245, 245, '12250.00', '2019-12-19 19:53:36', 1, NULL, NULL),
(8, 5, 1, 25, 264, 264, '6600.00', '2019-12-19 22:29:01', 1, '2019-12-19 12:00:10', NULL),
(9, 6, 1, 10, 263, 263, '2630.00', '2019-12-20 12:22:10', 1, '2019-12-20 04:18:42', NULL),
(10, 7, 1, 5, 262, 262, '1310.00', '2019-12-20 14:48:15', 5, NULL, NULL),
(11, 8, 7, 5, 25, 25, '125.00', '2019-12-20 15:20:52', 1, NULL, NULL),
(12, 9, 1, 5, 260, 260, '1300.00', '2019-12-20 15:21:41', 1, '2019-12-20 04:52:04', NULL),
(13, 10, 1, 5, 262, 262, '1310.00', '2019-12-20 16:10:44', 5, NULL, NULL),
(14, 10, 2, 5, 245, 245, '1225.00', '2019-12-20 16:10:44', 5, NULL, NULL),
(15, 11, 7, 5, 25, 25, '125.00', '2019-12-20 16:11:43', 5, NULL, NULL),
(16, 12, 5, 1, 189, 189, '189.00', '2019-12-20 16:14:32', 5, '2019-12-20 05:44:56', NULL),
(17, 12, 7, 1, 24, 24, '25.00', '2019-12-20 16:14:32', 5, '2019-12-20 05:44:56', NULL),
(18, 12, 7, 4, 24, 24, '96.00', '2019-12-20 16:14:32', 5, '2019-12-20 05:44:56', NULL),
(19, 13, 7, 5, 24, 24, '120.00', '2019-12-20 16:26:57', 1, NULL, NULL),
(20, 14, 7, 10, 24, 24, '240.00', '2019-12-20 16:31:23', 1, NULL, NULL),
(21, 15, 5, 50, 189, 189, '9450.00', '2019-12-20 16:34:42', 1, NULL, NULL),
(22, 15, 7, 20, 24, 24, '480.00', '2019-12-20 16:34:42', 1, NULL, NULL),
(23, 16, 7, 3, 24, 24, '72.00', '2019-12-20 16:35:05', 1, NULL, NULL);

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
  `credit_balance_used` decimal(14,2) NOT NULL DEFAULT '0.00',
  `previous_credit_balance` decimal(14,2) NOT NULL DEFAULT '0.00',
  `new_credit_balance` decimal(14,2) DEFAULT '0.00',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `total_payment` decimal(14,2) NOT NULL DEFAULT '0.00',
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
  `cost_price` float DEFAULT '0',
  `sale_price` float DEFAULT '0',
  `manage_stock_needed` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Do we need to manage stock for this product.',
  `status` varchar(20) NOT NULL DEFAULT 'Active' COMMENT 'Active | Deactive',
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `brand_id`, `product_name`, `product_code`, `description`, `weight`, `dimension`, `cost_price`, `sale_price`, `manage_stock_needed`, `status`, `is_deleted`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 6, 'Neervana Pet Bottle', 'NIR-1', '', 12, '12*4*4', 225, 265, 0, 'Active', 0, '2019-11-25 14:00:43', 2, '2019-12-10 12:08:14', 2),
(2, 1, 'Aquafina 1 Ltr', 'AQ - 1', '', 14, '5*3*10', 210, 245, 0, 'Active', 0, '2019-11-25 14:01:23', 2, '2019-12-06 11:35:50', 2),
(3, 3, 'Evian 1 Ltr', 'EV -1', '', 12, '5*3*10', 195, 255, 0, 'Active', 0, '2019-11-25 14:02:03', 2, '2019-12-06 11:36:50', 2),
(4, 7, 'Bilery 250ml', 'BS-250', '', 12, '7*4*4', 140, 165, 0, 'Active', 0, '2019-11-25 14:03:09', 2, '2019-12-10 12:07:34', 2),
(5, 6, 'Evian 250 ml', 'Ev-250', '', 11, '7*4*4', 160, 190, 0, 'Active', 0, '2019-11-25 14:03:45', 2, '2019-12-10 12:08:27', 2),
(6, 1, 'test', 'te', '', 0, 'd', 5, 5, 0, 'Active', 1, '2019-11-25 14:04:51', 2, '2019-11-25 14:05:01', NULL),
(7, 6, '20 Liter water jar', '33', '20 Liter water jar', 4, '500x500', 22, 25, 1, 'Active', 0, '2019-11-28 17:26:20', 2, '2019-12-10 12:08:35', 2),
(8, 1, 'Test Product zahid', 'test', 'test', 45, '5*3*10', 45, 18, 0, 'Active', 0, '2019-12-04 12:38:18', 2, '2019-12-04 13:34:49', 2),
(9, 3, 'test aaa', 'test aaa', 'test', 16, 'd', 450, 455, 0, 'Active', 0, '2019-12-04 13:42:52', 2, '2019-12-06 14:29:53', 2),
(10, 6, 'Neervana Blue 12 Box', 'NB', '', 12, '', 75, 120, 0, 'Active', 0, '2019-12-17 17:38:18', 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `original_image_name` varchar(300) DEFAULT NULL,
  `thumb` varchar(300) DEFAULT NULL,
  `is_primary` tinyint(4) DEFAULT '0' COMMENT '0-not primary, 1-primary',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
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
(5, 5, 'Evian-330ml-Natural-Mineral-Water-Bottle-Plastic-1.jpg', 'Evian-330ml-Natural-Mineral-Water-Bottle-Plastic-1_thumb.jpg', 1, '2019-11-25 14:03:45', 2, NULL, NULL),
(7, 8, '6e0cc9e6-3fae-4f5b-9ae3-805cdc1e72b7.jfif', '6e0cc9e6-3fae-4f5b-9ae3-805cdc1e72b7_thumb.jfif', 1, '2019-12-04 13:34:49', NULL, '2019-12-04 13:34:49', 2),
(8, 9, '500ml-mineral-water-bottle-500x5001.jpg', '500ml-mineral-water-bottle-500x5001_thumb.jpg', 1, '2019-12-04 13:43:19', 2, NULL, NULL),
(9, 7, '20_liter.jpg', '20_liter_thumb.jpg', 1, '2019-12-05 16:36:58', 2, NULL, NULL),
(10, 10, 'LL1.png', 'LL1_thumb.png', 1, '2019-12-17 17:38:18', 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role_name` varchar(200) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
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
  `type` varchar(50) DEFAULT NULL COMMENT 'price_scheme,product_order_scheme',
  `order_value` float DEFAULT NULL,
  `gift_mode` varchar(50) DEFAULT NULL COMMENT 'cash_benifit/free_product',
  `discount_mode` varchar(50) DEFAULT NULL COMMENT 'amount/percentage',
  `discount_value` float DEFAULT NULL,
  `discounted_amount` float DEFAULT NULL,
  `match_mode` varchar(50) DEFAULT NULL COMMENT 'all/any',
  `free_product_id` int(11) DEFAULT NULL,
  `free_product_qty` float DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Active' COMMENT 'Active/Inactive',
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schemes`
--

INSERT INTO `schemes` (`id`, `name`, `description`, `start_date`, `end_date`, `type`, `order_value`, `gift_mode`, `discount_mode`, `discount_value`, `discounted_amount`, `match_mode`, `free_product_id`, `free_product_qty`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`, `is_deleted`) VALUES
(1, 'Get 5% discount on purchase of 1000', 'Get 5% discount on purchase of 1000', '2019-11-25', '2020-01-16', 'price_scheme', 500, 'cash_benifit', 'percentage', 5, NULL, NULL, NULL, NULL, '2019-11-25 14:15:56', 2, '2019-12-03 11:28:25', 2, 'Active', 0),
(2, 'Get 1 bottle free on purchase of 10 qty of Bilery-1ltr', 'Get 50 of on purchase of 50 qty of Bilery-1ltr', '2019-11-25', '2020-01-23', 'product_order_scheme', NULL, 'cash_benifit', 'amount', 100, NULL, 'all', NULL, NULL, '2019-11-25 14:17:13', 2, '2019-12-03 11:27:35', 2, 'Active', 0),
(7, 'free product', NULL, '2019-12-03', '2020-01-31', 'price_scheme', 500, 'free_product', NULL, NULL, NULL, NULL, 3, 2, '2019-12-03 11:29:01', 2, NULL, NULL, 'Active', 0),
(8, 'Arjit ki scheme', 'fallad', '2020-01-01', '2020-01-31', 'price_scheme', 2000, 'free_product', NULL, NULL, NULL, NULL, 3, 1, '2019-12-16 17:49:54', 2, NULL, NULL, 'Active', 0);

-- --------------------------------------------------------

--
-- Table structure for table `scheme_products`
--

CREATE TABLE `scheme_products` (
  `id` int(11) NOT NULL,
  `scheme_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Active' COMMENT 'Active/Inactive',
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `scheme_products`
--

INSERT INTO `scheme_products` (`id`, `scheme_id`, `product_id`, `quantity`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`, `is_deleted`) VALUES
(9, 2, 1, 10, '2019-12-03 11:27:35', 2, NULL, NULL, 'Active', 0),
(10, 2, 2, 5, '2019-12-03 11:27:35', 2, NULL, NULL, 'Active', 0);

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
  `default_credit_limit` float NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `system_name`, `email_host`, `username`, `password`, `from_name`, `reply_to`, `reply_to_name`, `maps_api_key`, `node_server_url`, `default_credit_limit`) VALUES
(1, 'Deliverify', 'smtp.gmail.com', 'ehs.mehul@gmail.com', 'androiddev123', 'Mehul Patel', 'ehs.mehul@gmail.com', 'Mehul Patel', 'AIzaSyAMD5zzVlDuZih7zU3Y8yn2crJEcFtrt5M', 'http://172.16.3.123/rakesh/milan:3000', 0);

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `code` varchar(20) DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 = Deleted',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
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
  `is_deleted` tinyint(11) DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `phone`, `role_id`, `username`, `password`, `status`, `is_deleted`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Ashish', 'Makwana', 'ashishm@letsenkindle.com', '9510335127', 2, 'ashish', 'admin', 'Active', 0, '2019-11-25 14:11:53', 2, '2019-12-19 19:31:27', 8),
(2, 'Snehal', 'Trapsiya', 'snehalt@letsenkindle.com', '9773083060', 3, 'snehal', 'admin', 'Active', 0, '2019-11-25 14:12:28', 2, '2019-12-19 17:47:52', 2),
(3, 'Milan', 'Soni', 'milans@letsenkindle.com', '7600265925', 3, 'milan', 'admin', 'Active', 0, '2019-11-25 14:13:01', 2, '2019-12-19 17:47:32', 2),
(4, 'Ravi', 'Prajapati', 'ravip@letsenkindle.com', '7990535113', 4, 'ravi', 'admin', 'Active', 0, '2019-11-25 14:13:38', 2, '2019-12-19 17:47:46', 2),
(5, 'Rakesh', 'Jangir', 'rakeshj@letsenkindle.com', '9166650505', 2, 'rakesh', 'admin', 'Active', 0, '2019-12-19 17:41:59', 2, '2019-12-19 19:03:46', 8),
(6, 'Mehul', 'Patel', 'mehulp@letsenkindle.com', '8401036474', 4, 'mehul', 'admin', 'Active', 0, '2019-12-19 17:48:35', 2, '2019-12-19 17:55:12', 2),
(8, 'Devansh', 'Shah', 'devansh@letsenkindle.com', '9723664556', 1, 'devansh', 'admin', 'Active', 0, '2019-12-19 18:44:32', 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_devices`
--

CREATE TABLE `user_devices` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `device_id` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_devices`
--

INSERT INTO `user_devices` (`id`, `user_id`, `device_id`, `created_at`) VALUES
(50, 4, 'dsIcxv1Cfa0:APA91bGQZqoNRLtObz-MqVUlsiVVQyP1o5O-ryqTvQy242Eyl0ImcJqky46MLc0_G51UK14TeQP4CHHDh3-VyGnFM-gNxjCxawvY5DFnoR6ouk09FDlNhfvFBGQDLjV1lwb3OfAjXdj4', '2019-12-20 06:05:18');

-- --------------------------------------------------------

--
-- Table structure for table `user_vehicle`
--

CREATE TABLE `user_vehicle` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
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
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Active' COMMENT 'Active/Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_zip_codes`
--

INSERT INTO `user_zip_codes` (`id`, `user_id`, `zip_code_id`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`) VALUES
(1, 1, 10, '2019-12-19 17:40:59', 2, NULL, NULL, 'Active'),
(2, 5, 1, '2019-12-19 17:41:59', 2, NULL, NULL, 'Active'),
(3, 5, 2, '2019-12-19 17:41:59', 2, NULL, NULL, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `user_zip_code_groups`
--

CREATE TABLE `user_zip_code_groups` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `zip_code_group_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Active' COMMENT 'Active/Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_zip_code_groups`
--

INSERT INTO `user_zip_code_groups` (`id`, `user_id`, `zip_code_group_id`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`) VALUES
(2, 5, 3, '2019-12-19 17:41:59', 2, NULL, NULL, 'Active'),
(3, 1, 1, '2019-12-19 19:31:27', 8, NULL, NULL, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

CREATE TABLE `vehicle` (
  `id` int(11) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `number` varchar(200) DEFAULT NULL,
  `capacity_in_ton` float DEFAULT NULL COMMENT 'actuelly capacity is in kg',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Active' COMMENT 'Active/Inactive',
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vehicle`
--

INSERT INTO `vehicle` (`id`, `name`, `number`, `capacity_in_ton`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`, `is_deleted`) VALUES
(1, 'Tata 207', 'GJ01CA1234', 12000, '2019-11-25 13:06:33', 2, NULL, NULL, 'Active', 0),
(2, 'Tata 407', 'Gj02CC1122', 15000, '2019-11-25 13:06:52', 2, NULL, NULL, 'Active', 0),
(3, 'Tata ACE', 'RJ23ST1695', 8000, '2019-11-25 13:07:09', 2, NULL, NULL, 'Active', 0),
(4, 'Honda CD Deluxe', 'GJ03DF1212', 20, '2019-11-25 13:07:33', 2, '2019-12-02 20:23:33', 2, 'Active', 0),
(5, 'Honda CD Deluxe', 'GJ06FC3218', 2000, '2019-11-25 13:07:52', 2, NULL, NULL, 'Active', 0),
(6, 'test', 'GJ01CA1233', 15000, '2019-11-26 14:33:53', 2, '2019-11-26 14:33:56', NULL, 'Active', 1),
(7, 'Volvo FM 410', ' FM 410', 50000, '2019-12-06 14:26:34', 2, NULL, NULL, 'Active', 0),
(8, 'Tata Ace', 'MH 01 BA 2433', 100, '2019-12-16 17:44:33', 2, NULL, NULL, 'Active', 0);

-- --------------------------------------------------------

--
-- Table structure for table `warehouses`
--

CREATE TABLE `warehouses` (
  `id` int(11) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Active' COMMENT 'Active/Inactive',
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0'
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
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
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
(10, '382308', 4, 2, 'Hilol', '2019-11-25 13:03:35', 1, NULL, NULL, 'Active'),
(12, '380001', 3, 2, 'Ahmedabad', '2019-12-06 12:43:40', 2, NULL, NULL, 'Active'),
(13, '383940', 1, 1, 'Jhotwara s', '2019-12-06 17:52:27', 2, NULL, NULL, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `zip_code_groups`
--

CREATE TABLE `zip_code_groups` (
  `id` int(11) NOT NULL,
  `group_name` varchar(200) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Active' COMMENT 'Active/Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zip_code_groups`
--

INSERT INTO `zip_code_groups` (`id`, `group_name`, `state_id`, `city_id`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`) VALUES
(1, 'Ahmedabad City', 2, 3, '2019-12-19 17:37:52', 2, NULL, NULL, 'Active'),
(2, 'Gandhinagar City', 2, 4, '2019-12-19 17:38:13', 2, NULL, NULL, 'Active'),
(3, 'Jaipur City', 1, 1, '2019-12-19 17:38:40', 2, NULL, NULL, 'Active'),
(4, 'Sikar City', 1, 2, '2019-12-19 17:38:53', 2, NULL, NULL, 'Active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cash_collection`
--
ALTER TABLE `cash_collection`
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
-- Indexes for table `client_product_inventory`
--
ALTER TABLE `client_product_inventory`
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
-- Indexes for table `fcm_notifications`
--
ALTER TABLE `fcm_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fcm_notification_user`
--
ALTER TABLE `fcm_notification_user`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `cash_collection`
--
ALTER TABLE `cash_collection`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `client_location_images`
--
ALTER TABLE `client_location_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `client_product_inventory`
--
ALTER TABLE `client_product_inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `client_product_price`
--
ALTER TABLE `client_product_price`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `client_selesmans`
--
ALTER TABLE `client_selesmans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `client_visits`
--
ALTER TABLE `client_visits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coordinates`
--
ALTER TABLE `coordinates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `delivery`
--
ALTER TABLE `delivery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `delivery_config`
--
ALTER TABLE `delivery_config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `delivery_config_orders`
--
ALTER TABLE `delivery_config_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `delivery_routes`
--
ALTER TABLE `delivery_routes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `fcm_notifications`
--
ALTER TABLE `fcm_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `fcm_notification_user`
--
ALTER TABLE `fcm_notification_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `group_to_zip_code`
--
ALTER TABLE `group_to_zip_code`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `leads`
--
ALTER TABLE `leads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `lead_visits`
--
ALTER TABLE `lead_visits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `mail_template`
--
ALTER TABLE `mail_template`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `order_delivery_images`
--
ALTER TABLE `order_delivery_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_details`
--
ALTER TABLE `payment_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `schemes`
--
ALTER TABLE `schemes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `scheme_products`
--
ALTER TABLE `scheme_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_devices`
--
ALTER TABLE `user_devices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `user_vehicle`
--
ALTER TABLE `user_vehicle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_zip_codes`
--
ALTER TABLE `user_zip_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_zip_code_groups`
--
ALTER TABLE `user_zip_code_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `vehicle`
--
ALTER TABLE `vehicle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `warehouses`
--
ALTER TABLE `warehouses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `zip_codes`
--
ALTER TABLE `zip_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `zip_code_groups`
--
ALTER TABLE `zip_code_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
