-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 18, 2019 at 10:22 AM
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

--
-- Dumping data for table `cash_collection`
--

INSERT INTO `cash_collection` (`id`, `user_id`, `amount`, `is_deleted`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 3, 224.5, 0, '2019-12-09 00:00:00', 2, NULL, NULL),
(2, 3, 100, 0, '2019-12-09 00:00:00', 2, NULL, NULL),
(3, 4, 1000, 0, '2019-12-17 00:00:00', 2, NULL, NULL),
(4, 4, 2500, 0, '2019-12-17 00:00:00', 2, NULL, NULL),
(5, 3, 6000, 0, '2019-12-17 00:00:00', 2, NULL, NULL),
(6, 3, 7400, 0, '2019-12-17 00:00:00', 2, NULL, NULL),
(7, 3, 200, 0, '2019-12-17 00:00:00', 2, NULL, NULL),
(8, 4, 200, 0, '2019-12-18 00:00:00', 2, NULL, NULL);

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
(1, 'Sun Pharma', '0.00', 0.00, NULL, 1, 1, 3, 1, NULL, NULL, 'Snehal Trapsiya', '9166650505', NULL, 'snehal@gmail.com', 'Mehul Patel', '8963015122', NULL, 'mehul@gmail.com', 0, '2019-12-05 14:26:27', 1, '2019-12-05 15:36:53', 2, 'Active', 'abc123', NULL),
(2, 'Gandhi soda', '0.00', 0.00, NULL, 3, 2, 5, 2, NULL, NULL, 'priyanshu', '6598653265', NULL, 'priyanshu@gmail.com', 'priyanshu', '4477880055', NULL, NULL, 0, '2019-12-05 14:52:06', 1, '2019-12-05 15:34:36', 2, 'Active', '77BJDEP4681J1JC', NULL),
(3, 'Khanjan testing', '0.00', 0.00, NULL, 3, 2, 6, 4, NULL, NULL, 'Khanjan Shah', '9429620022', NULL, 'khanjanshah06@gmail.com', NULL, NULL, NULL, NULL, 0, '2019-12-05 18:19:39', 1, NULL, NULL, 'Active', NULL, NULL),
(4, 'Ravi Sandwich', '0.00', 0.00, NULL, 3, 2, 1, 3, NULL, NULL, 'Vasukaka', '8454813349', NULL, 'ehs.mehul@gmail.com', NULL, '8525329645', NULL, NULL, 0, '2019-12-05 19:02:02', 1, NULL, NULL, 'Active', NULL, NULL),
(5, 'star snacks', '0.00', 0.00, NULL, 3, 2, 4, 5, NULL, NULL, 'shivabhai', '9865326598', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2019-12-05 19:23:47', 1, NULL, NULL, 'Active', NULL, NULL),
(6, 'Empire bakery', '0.00', 0.00, NULL, 3, 2, 6, 10, NULL, NULL, 'Mohsinbhai', '6459865329', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2019-12-06 12:45:00', 1, NULL, NULL, 'Active', NULL, NULL),
(7, 'natural ice-cream', '0.00', 0.00, NULL, 3, 2, 12, 9, NULL, NULL, 'divyesh bhai', '9904499818', NULL, 'arjit@neervana.net', NULL, NULL, NULL, NULL, 0, '2019-12-06 12:49:02', 1, '2019-12-17 17:41:30', 2, 'Active', NULL, NULL),
(8, 'Khanjan final testing', '0.00', 0.00, NULL, 3, 2, 12, 12, NULL, NULL, '9867777777', '9429620022', NULL, 'kh', NULL, NULL, NULL, NULL, 0, '2019-12-06 13:51:03', 1, NULL, NULL, 'Active', NULL, NULL),
(9, 'modi sandwich', '0.00', 0.00, NULL, 3, 2, 12, 14, NULL, NULL, 'pranav modi', '9865487845', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2019-12-09 11:19:10', 1, NULL, NULL, 'Active', NULL, NULL),
(10, 'Harish pan parlour', '0.00', 0.00, NULL, 3, 2, 12, 15, NULL, NULL, 'Harish dave', '7855669988', NULL, 'hariah@aol.com', NULL, NULL, NULL, NULL, 0, '2019-12-09 13:15:51', 1, NULL, NULL, 'Active', '44ghjim7657hweo', NULL),
(11, 'Eminent hotel', NULL, 0.00, NULL, 3, 2, 12, 13, NULL, NULL, 'Azam', '9173021172', NULL, 'azaz@yahoo.com', NULL, NULL, NULL, NULL, 1, '2019-12-11 10:51:03', 1, '2019-12-17 04:13:42', NULL, 'Active', NULL, NULL),
(12, 'Eminent hotel', NULL, 0.00, NULL, 3, 2, 12, 13, NULL, NULL, 'Azam', '9173021172', NULL, 'azaz@yahoo.com', NULL, NULL, NULL, NULL, 1, '2019-12-11 10:51:25', 1, '2019-12-17 04:13:47', NULL, 'Active', NULL, NULL),
(13, 'Eminent hotel', NULL, 0.00, NULL, 3, 2, 12, 13, NULL, NULL, 'Azam', '9173021172', NULL, 'azaz@yahoo.com', NULL, NULL, NULL, NULL, 1, '2019-12-11 10:51:31', 1, '2019-12-17 04:13:51', NULL, 'Active', NULL, NULL),
(14, 'Eminent hotel', NULL, 0.00, NULL, 3, 2, 12, 13, NULL, NULL, 'Azam', '9173021172', NULL, 'azaz@yahoo.com', NULL, NULL, NULL, NULL, 1, '2019-12-11 10:51:32', 1, '2019-12-17 04:13:55', NULL, 'Active', NULL, NULL),
(15, 'Eminent hotel', NULL, 0.00, NULL, 3, 2, 12, 13, NULL, NULL, 'Azam', '9173021172', NULL, 'azaz@yahoo.com', NULL, NULL, NULL, NULL, 1, '2019-12-11 10:51:33', 1, '2019-12-17 04:14:00', NULL, 'Active', NULL, NULL),
(16, 'Eminent hotel', NULL, 0.00, NULL, 3, 2, 12, 13, NULL, NULL, 'Azam', '9173021172', NULL, 'azaz@yahoo.com', NULL, NULL, NULL, NULL, 1, '2019-12-11 10:51:34', 1, '2019-12-17 04:14:05', NULL, 'Active', NULL, NULL),
(17, 'Eminent hotel', NULL, 0.00, NULL, 3, 2, 12, 13, NULL, NULL, 'Azam', '9173021172', NULL, 'azaz@yahoo.com', NULL, NULL, NULL, NULL, 1, '2019-12-11 10:51:35', 1, '2019-12-17 04:22:22', NULL, 'Active', NULL, NULL),
(18, 'Eminent hotel', NULL, 0.00, NULL, 3, 2, 12, 13, NULL, NULL, 'Azam', '9173021172', NULL, 'azaz@yahoo.com', NULL, NULL, NULL, NULL, 1, '2019-12-11 10:51:37', 1, '2019-12-17 04:22:27', NULL, 'Active', NULL, NULL),
(19, 'Eminent hotel', NULL, 0.00, NULL, 3, 2, 12, 13, NULL, NULL, 'Azam', '9173021172', NULL, 'azaz@yahoo.com', NULL, NULL, NULL, NULL, 1, '2019-12-11 10:51:46', 1, '2019-12-17 04:22:32', NULL, 'Active', NULL, NULL),
(20, 'Eminent hotel', NULL, 0.00, NULL, 3, 2, 12, 13, NULL, NULL, 'Azam', '9173021172', NULL, 'azaz@yahoo.com', NULL, NULL, NULL, NULL, 0, '2019-12-11 10:53:24', 1, NULL, NULL, 'Active', NULL, NULL),
(21, 'Queenland cafe', '0.00', 0.00, NULL, 3, 2, 12, 16, NULL, NULL, 'pritesh', '9265579908', NULL, 'pritesh@yahoo.com', NULL, NULL, NULL, NULL, 0, '2019-12-11 12:53:22', 1, '2019-12-11 13:02:22', 2, 'Active', NULL, NULL),
(22, 'yuk', '0.00', 0.00, NULL, 3, 2, 12, 40, NULL, NULL, 'tres', '9723664556', NULL, 'test@test.com', NULL, NULL, NULL, NULL, 0, '2019-12-16 18:15:07', 1, NULL, NULL, 'Active', NULL, NULL),
(23, 'Khanjanss', '0.00', 0.00, NULL, 2, 1, 8, 41, NULL, NULL, '9429629022', '9638527410', NULL, 'khanjanshah06@gmail.com', NULL, NULL, NULL, NULL, 0, '2019-12-17 14:15:21', 1, NULL, NULL, 'Active', 'gggg', NULL),
(24, 'Reliance mart', '0.00', 0.00, NULL, 3, 2, 12, 39, NULL, NULL, 'Ashok Mishra', '8401036474', NULL, 'ashok@gmail.com', NULL, NULL, NULL, NULL, 0, '2019-12-17 14:33:24', 1, '2019-12-17 16:06:54', 2, 'Active', '22hdbpk6378j11', 4);

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
(1, 1, NULL, 'Home', 'Home address', 1, 23.048065, 72.568230, 0, '2019-12-05 14:25:54', 1, '2019-12-05 17:41:30', 2, 'Active'),
(2, 2, NULL, 'shop', 'ganesh complex, paladi char rasta, Ahmedabad', 5, 23.048065, 72.568230, 0, '2019-12-05 14:51:50', 1, '2019-12-05 17:40:52', 2, 'Active'),
(3, 3, NULL, 'Home', 'F/5 Chandrika Appartment', 6, 23.045265, 72.568817, 0, '2019-12-05 18:15:22', 1, '2019-12-05 00:00:00', NULL, 'Active'),
(4, 4, NULL, 'shop', 'Ravi kirana, Navrangpura', 7, NULL, NULL, 0, '2019-12-05 19:01:51', 1, '2019-12-05 00:00:00', NULL, 'Active'),
(5, 5, NULL, 'shop', 'nava vadaj', 1, NULL, NULL, 0, '2019-12-05 19:23:30', 1, '2019-12-05 00:00:00', NULL, 'Active'),
(6, 6, NULL, 'shop', 'dinbai tower', 7, NULL, NULL, 0, '2019-12-06 12:44:54', 1, '2019-12-06 00:00:00', NULL, 'Active'),
(7, 7, NULL, 'shop', 'mithakhali', 12, NULL, NULL, 0, '2019-12-06 12:48:56', 1, '2019-12-06 00:00:00', NULL, 'Active'),
(8, 8, NULL, 'home', 'f/5', 1, 23.045265, 72.568810, 0, '2019-12-06 13:44:27', 1, '2019-12-06 00:00:00', NULL, 'Active'),
(9, 8, NULL, 'home', 'eee', 1, 23.045265, 72.568810, 0, '2019-12-06 13:45:13', 1, '2019-12-06 00:00:00', NULL, 'Active'),
(10, 9, NULL, 'Shop', 'vasna', 12, 23.045269, 72.568825, 0, '2019-12-09 11:18:57', 1, '2019-12-09 00:00:00', NULL, 'Active'),
(11, 10, NULL, 'shop', 'law garden circle, law garden', 12, NULL, NULL, 0, '2019-12-09 13:15:44', 1, '2019-12-09 00:00:00', NULL, 'Active'),
(12, 1, NULL, 'Officer', 'Sandwich', 7, 23.047407, 72.566879, 0, '2019-12-10 17:00:51', 1, NULL, NULL, 'Active'),
(13, 11, NULL, 'office', 'sarkhej', 12, NULL, NULL, 0, '2019-12-11 10:50:51', 1, '2019-12-11 00:00:00', NULL, 'Active'),
(14, 21, NULL, 'shop', 'Jamalpur', 12, NULL, NULL, 0, '2019-12-11 12:53:13', 1, '2019-12-11 00:00:00', NULL, 'Active'),
(15, 22, NULL, 'test', 'jkdkd', 12, 23.045277, 72.568848, 0, '2019-12-16 18:12:02', 1, '2019-12-16 00:00:00', NULL, 'Active'),
(16, 23, NULL, 'Home', 'F/5 Chandrika Appartment', 10, NULL, NULL, 0, '2019-12-17 14:15:05', 1, '2019-12-17 00:00:00', NULL, 'Active'),
(17, 24, NULL, 'shop', 'mahalaxmi chaar rasta, paldi', 12, NULL, NULL, 0, '2019-12-17 14:33:14', 1, '2019-12-17 00:00:00', NULL, 'Active');

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
(1, NULL, 1, 4, 0, 5, 0, '2019-12-05 00:00:00', 4, NULL, NULL, 'Active'),
(2, NULL, 2, 1, 0, 25, 15, '2019-12-05 00:00:00', 4, NULL, NULL, 'Active'),
(3, NULL, 1, 7, 0, 8, 0, '2019-12-05 00:00:00', 3, NULL, NULL, 'Active'),
(4, NULL, 2, 7, 0, 25, 2, '2019-12-06 00:00:00', 3, NULL, NULL, 'Active'),
(5, NULL, 8, 0, 0, 0, 0, '2019-12-06 00:00:00', 3, NULL, NULL, 'Active'),
(6, NULL, 8, 0, 0, 0, 0, '2019-12-06 00:00:00', 3, NULL, NULL, 'Active'),
(7, NULL, 8, 0, 0, 0, 0, '2019-12-06 00:00:00', 3, NULL, NULL, 'Active'),
(8, NULL, 5, 7, 0, 56, 63, '2019-12-06 00:00:00', 3, NULL, NULL, 'Active'),
(9, NULL, 9, 0, 0, 0, 0, '2019-12-09 00:00:00', 3, NULL, NULL, 'Active'),
(10, NULL, 10, 7, 0, 3, 0, '2019-12-09 00:00:00', 4, NULL, NULL, 'Active'),
(11, NULL, 10, 7, 0, 3, 0, '2019-12-09 00:00:00', 4, NULL, NULL, 'Active'),
(12, NULL, 21, 0, 0, 0, 0, '2019-12-11 00:00:00', 4, NULL, NULL, 'Active'),
(13, NULL, 21, 7, 0, 3, 3, '2019-12-11 00:00:00', 4, NULL, NULL, 'Active'),
(14, NULL, 19, 7, 0, 2, 2, '2019-12-17 00:00:00', 3, NULL, NULL, 'Active'),
(15, NULL, 19, 7, 0, 2, 2, '2019-12-17 00:00:00', 3, NULL, NULL, 'Active'),
(16, NULL, 19, 7, 0, 2, 2, '2019-12-17 00:00:00', 3, NULL, NULL, 'Active'),
(17, NULL, 19, 7, 0, 2, 2, '2019-12-17 00:00:00', 3, NULL, NULL, 'Active'),
(18, NULL, 19, 7, 0, 2, 2, '2019-12-17 00:00:00', 3, NULL, NULL, 'Active'),
(19, NULL, 19, 7, 0, 2, 2, '2019-12-17 00:00:00', 3, NULL, NULL, 'Active'),
(20, NULL, 19, 7, 0, 8, 0, '2019-12-17 00:00:00', 3, NULL, NULL, 'Active'),
(21, NULL, 11, 7, 0, 2, 1, '2019-12-17 00:00:00', 3, NULL, NULL, 'Active'),
(22, NULL, 3, 0, 0, 0, 0, '2019-12-17 00:00:00', 3, NULL, NULL, 'Active'),
(23, NULL, 3, 0, 0, 0, 0, '2019-12-17 00:00:00', 3, NULL, NULL, 'Active'),
(24, NULL, 3, 0, 0, 0, 0, '2019-12-17 00:00:00', 3, NULL, NULL, 'Active'),
(25, NULL, 3, 0, 0, 0, 0, '2019-12-17 00:00:00', 3, NULL, NULL, 'Active'),
(26, NULL, 3, 0, 0, 0, 0, '2019-12-17 00:00:00', 3, NULL, NULL, 'Active'),
(27, NULL, 14, 7, 0, 1, 1, '2019-12-17 00:00:00', 3, NULL, NULL, 'Active'),
(28, NULL, 14, 7, 0, 1, 1, '2019-12-17 00:00:00', 3, NULL, NULL, 'Active'),
(29, NULL, 14, 7, 0, 1, 1, '2019-12-17 00:00:00', 3, NULL, NULL, 'Active'),
(30, NULL, 14, 7, 0, 1, 1, '2019-12-17 00:00:00', 3, NULL, NULL, 'Active'),
(31, NULL, 14, 7, 0, 1, 1, '2019-12-17 00:00:00', 3, NULL, NULL, 'Active'),
(32, NULL, 14, 7, 0, 1, 1, '2019-12-17 00:00:00', 3, NULL, NULL, 'Active'),
(33, NULL, 14, 7, 0, 1, 1, '2019-12-17 00:00:00', 3, NULL, NULL, 'Active'),
(34, NULL, 14, 7, 0, 1, 1, '2019-12-17 00:00:00', 3, NULL, NULL, 'Active'),
(35, NULL, 14, 7, 0, 1, 1, '2019-12-17 00:00:00', 3, NULL, NULL, 'Active'),
(36, NULL, 14, 7, 0, 1, 1, '2019-12-17 00:00:00', 3, NULL, NULL, 'Active'),
(37, NULL, 14, 7, 0, 1, 1, '2019-12-17 00:00:00', 3, NULL, NULL, 'Active'),
(38, NULL, 16, 7, 0, 8, 5, '2019-12-17 00:00:00', 3, NULL, NULL, 'Active'),
(39, NULL, 24, 7, 0, 4, 3, '2019-12-17 00:00:00', 3, NULL, NULL, 'Active'),
(40, NULL, 24, 7, 0, 4, 3, '2019-12-17 00:00:00', 3, NULL, NULL, 'Active'),
(41, NULL, 24, 7, 0, 5, 0, '2019-12-17 00:00:00', 4, NULL, NULL, 'Active'),
(42, NULL, 24, 7, 0, 5, 0, '2019-12-17 00:00:00', 4, NULL, NULL, 'Active'),
(43, NULL, 24, 7, 0, 5, 0, '2019-12-17 00:00:00', 4, NULL, NULL, 'Active'),
(44, NULL, 24, 7, 0, 5, 0, '2019-12-17 00:00:00', 4, NULL, NULL, 'Active'),
(45, NULL, 17, 7, 0, 5, 6, '2019-12-17 00:00:00', 3, NULL, NULL, 'Active'),
(46, NULL, 17, 7, 0, 5, 6, '2019-12-17 00:00:00', 3, NULL, NULL, 'Active'),
(47, NULL, 17, 7, 0, 5, 6, '2019-12-17 00:00:00', 3, NULL, NULL, 'Active'),
(48, NULL, 17, 7, 0, 5, 6, '2019-12-17 00:00:00', 3, NULL, NULL, 'Active'),
(49, NULL, 17, 7, 0, 5, 6, '2019-12-17 00:00:00', 3, NULL, NULL, 'Active'),
(50, NULL, 17, 7, 0, 5, 6, '2019-12-17 00:00:00', 3, NULL, NULL, 'Active'),
(51, NULL, 17, 7, 0, 5, 6, '2019-12-17 00:00:00', 3, NULL, NULL, 'Active'),
(52, NULL, 17, 7, 0, 5, 6, '2019-12-17 00:00:00', 3, NULL, NULL, 'Active'),
(53, NULL, 8, 0, 0, 0, 0, '2019-12-17 00:00:00', 3, NULL, NULL, 'Active'),
(54, NULL, 15, 7, 0, 5, 5, '2019-12-17 00:00:00', 4, NULL, NULL, 'Active'),
(55, NULL, 7, 0, 0, 0, 0, '2019-12-17 00:00:00', 3, NULL, NULL, 'Active'),
(56, NULL, 18, 7, 0, 2, 0, '2019-12-17 00:00:00', 3, NULL, NULL, 'Active'),
(57, NULL, 1, 0, 0, 0, 0, '2019-12-18 00:00:00', 3, NULL, NULL, 'Active');

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
(1, 1, 1, 265, '2019-12-05 14:26:27', NULL, '2019-12-10 11:34:16', 2, 'Active'),
(2, 1, 2, 250, '2019-12-05 14:26:27', NULL, '2019-12-10 11:34:16', 2, 'Active'),
(3, 1, 3, 255, '2019-12-05 14:26:27', NULL, '2019-12-10 11:34:16', 2, 'Active'),
(4, 1, 4, 175, '2019-12-05 14:26:27', NULL, '2019-12-10 11:34:16', 2, 'Active'),
(5, 1, 5, 190, '2019-12-05 14:26:27', NULL, '2019-12-10 11:34:16', 2, 'Active'),
(6, 1, 7, 25, '2019-12-05 14:26:27', NULL, '2019-12-05 06:23:45', NULL, 'Active'),
(7, 1, 8, 18, '2019-12-05 14:26:27', NULL, NULL, NULL, 'Active'),
(8, 1, 9, 455, '2019-12-05 14:26:27', NULL, '2019-12-10 11:34:16', 2, 'Active'),
(9, 2, 1, 235, '2019-12-05 14:52:06', NULL, '2019-12-10 11:35:05', 2, 'Active'),
(10, 2, 2, 250, '2019-12-05 14:52:06', NULL, '2019-12-10 11:35:05', 2, 'Active'),
(11, 2, 3, 265, '2019-12-05 14:52:06', NULL, '2019-12-10 11:35:05', 2, 'Active'),
(12, 2, 4, 167, '2019-12-05 14:52:06', NULL, '2019-12-10 11:35:05', 2, 'Active'),
(13, 2, 5, 200, '2019-12-05 14:52:06', NULL, '2019-12-10 11:35:05', 2, 'Active'),
(14, 2, 7, 24.5, '2019-12-05 14:52:06', NULL, '2019-12-06 01:03:55', NULL, 'Active'),
(15, 2, 8, 18, '2019-12-05 14:52:06', NULL, NULL, NULL, 'Active'),
(16, 2, 9, 465, '2019-12-05 14:52:06', NULL, '2019-12-10 11:35:05', 2, 'Active'),
(17, 3, 1, 267, '2019-12-05 18:19:39', NULL, '2019-12-17 04:45:06', 2, 'Active'),
(18, 3, 2, 251, '2019-12-05 18:19:39', NULL, '2019-12-17 04:45:06', 2, 'Active'),
(19, 3, 3, 275, '2019-12-05 18:19:39', NULL, '2019-12-10 11:36:58', 2, 'Active'),
(20, 3, 4, 168, '2019-12-05 18:19:39', NULL, '2019-12-10 11:36:58', 2, 'Active'),
(21, 3, 5, 210, '2019-12-05 18:19:39', NULL, '2019-12-10 11:36:58', 2, 'Active'),
(22, 3, 7, 25, '2019-12-05 18:19:39', NULL, NULL, NULL, 'Active'),
(23, 3, 8, 18, '2019-12-05 18:19:39', NULL, NULL, NULL, 'Active'),
(24, 3, 9, 455, '2019-12-05 18:19:39', NULL, '2019-12-10 11:36:58', 2, 'Active'),
(25, 4, 1, 245, '2019-12-05 19:02:02', NULL, '2019-12-10 12:04:52', 2, 'Active'),
(26, 4, 2, 258, '2019-12-05 19:02:02', NULL, '2019-12-17 06:59:43', 2, 'Active'),
(27, 4, 3, 157, '2019-12-05 19:02:02', NULL, '2019-12-10 12:04:52', 2, 'Active'),
(28, 4, 4, 168, '2019-12-05 19:02:02', NULL, '2019-12-10 12:04:52', 2, 'Active'),
(29, 4, 5, 192, '2019-12-05 19:02:02', NULL, '2019-12-10 12:04:52', 2, 'Active'),
(30, 4, 7, 25, '2019-12-05 19:02:02', NULL, NULL, NULL, 'Active'),
(31, 4, 8, 19, '2019-12-05 19:02:02', NULL, '2019-12-10 12:04:52', 2, 'Active'),
(32, 4, 9, 454, '2019-12-05 19:02:02', NULL, '2019-12-10 12:04:52', 2, 'Active'),
(33, 5, 1, 266, '2019-12-05 19:23:47', NULL, '2019-12-10 12:05:31', 2, 'Active'),
(34, 5, 2, 248, '2019-12-05 19:23:47', NULL, '2019-12-10 12:05:31', 2, 'Active'),
(35, 5, 3, 254, '2019-12-05 19:23:47', NULL, '2019-12-10 12:05:31', 2, 'Active'),
(36, 5, 4, 166, '2019-12-05 19:23:47', NULL, '2019-12-10 12:05:31', 2, 'Active'),
(37, 5, 5, 90, '2019-12-05 19:23:47', NULL, '2019-12-10 12:05:31', 2, 'Active'),
(38, 5, 7, 24, '2019-12-05 19:23:47', NULL, '2019-12-10 12:05:31', 2, 'Active'),
(39, 5, 8, 17, '2019-12-05 19:23:47', NULL, '2019-12-10 12:05:31', 2, 'Active'),
(40, 5, 9, 452, '2019-12-05 19:23:47', NULL, '2019-12-10 12:05:31', 2, 'Active'),
(41, 6, 1, 265, '2019-12-06 12:45:00', NULL, NULL, NULL, 'Active'),
(42, 6, 2, 245, '2019-12-06 12:45:00', NULL, NULL, NULL, 'Active'),
(43, 6, 3, 255, '2019-12-06 12:45:00', NULL, NULL, NULL, 'Active'),
(44, 6, 4, 165, '2019-12-06 12:45:00', NULL, NULL, NULL, 'Active'),
(45, 6, 5, 190, '2019-12-06 12:45:00', NULL, NULL, NULL, 'Active'),
(46, 6, 7, 25, '2019-12-06 12:45:00', NULL, NULL, NULL, 'Active'),
(47, 6, 8, 18, '2019-12-06 12:45:00', NULL, NULL, NULL, 'Active'),
(48, 6, 9, 45, '2019-12-06 12:45:00', NULL, NULL, NULL, 'Active'),
(49, 7, 1, 260, '2019-12-06 12:49:02', NULL, '2019-12-17 04:43:37', NULL, 'Active'),
(50, 7, 2, 241.5, '2019-12-06 12:49:02', NULL, '2019-12-17 04:43:37', NULL, 'Active'),
(51, 7, 3, 254, '2019-12-06 12:49:02', NULL, '2019-12-17 04:43:37', NULL, 'Active'),
(52, 7, 4, 165, '2019-12-06 12:49:02', NULL, NULL, NULL, 'Active'),
(53, 7, 5, 190, '2019-12-06 12:49:02', NULL, NULL, NULL, 'Active'),
(54, 7, 7, 25, '2019-12-06 12:49:02', NULL, NULL, NULL, 'Active'),
(55, 7, 8, 18, '2019-12-06 12:49:02', NULL, NULL, NULL, 'Active'),
(56, 7, 9, 45, '2019-12-06 12:49:02', NULL, NULL, NULL, 'Active'),
(57, 8, 1, 200, '2019-12-06 13:51:03', NULL, '2019-12-17 06:29:05', NULL, 'Active'),
(58, 8, 2, 245, '2019-12-06 13:51:03', NULL, NULL, NULL, 'Active'),
(59, 8, 3, 255, '2019-12-06 13:51:03', NULL, NULL, NULL, 'Active'),
(60, 8, 4, 165, '2019-12-06 13:51:03', NULL, NULL, NULL, 'Active'),
(61, 8, 5, 190, '2019-12-06 13:51:03', NULL, NULL, NULL, 'Active'),
(62, 8, 7, 25, '2019-12-06 13:51:03', NULL, NULL, NULL, 'Active'),
(63, 8, 8, 18, '2019-12-06 13:51:03', NULL, NULL, NULL, 'Active'),
(64, 8, 9, 45, '2019-12-06 13:51:03', NULL, NULL, NULL, 'Active'),
(65, 9, 1, 261, '2019-12-09 11:19:10', NULL, '2019-12-17 06:44:54', NULL, 'Active'),
(66, 9, 2, 245, '2019-12-09 11:19:10', NULL, '2019-12-17 06:44:54', NULL, 'Active'),
(67, 9, 3, 255, '2019-12-09 11:19:10', NULL, NULL, NULL, 'Active'),
(68, 9, 4, 165, '2019-12-09 11:19:10', NULL, NULL, NULL, 'Active'),
(69, 9, 5, 190, '2019-12-09 11:19:10', NULL, NULL, NULL, 'Active'),
(70, 9, 7, 25, '2019-12-09 11:19:10', NULL, NULL, NULL, 'Active'),
(71, 9, 8, 18, '2019-12-09 11:19:10', NULL, NULL, NULL, 'Active'),
(72, 9, 9, 455, '2019-12-09 11:19:10', NULL, NULL, NULL, 'Active'),
(73, 10, 1, 260, '2019-12-09 13:15:51', NULL, '2019-12-17 04:40:15', NULL, 'Active'),
(74, 10, 2, 245, '2019-12-09 13:15:51', NULL, NULL, NULL, 'Active'),
(75, 10, 3, 255, '2019-12-09 13:15:51', NULL, NULL, NULL, 'Active'),
(76, 10, 4, 165, '2019-12-09 13:15:51', NULL, NULL, NULL, 'Active'),
(77, 10, 5, 190, '2019-12-09 13:15:51', NULL, NULL, NULL, 'Active'),
(78, 10, 7, 25, '2019-12-09 13:15:51', NULL, NULL, NULL, 'Active'),
(79, 10, 8, 18, '2019-12-09 13:15:51', NULL, NULL, NULL, 'Active'),
(80, 10, 9, 455, '2019-12-09 13:15:51', NULL, NULL, NULL, 'Active'),
(81, 11, 1, 265, '2019-12-11 10:51:03', NULL, NULL, NULL, 'Active'),
(82, 11, 2, 245, '2019-12-11 10:51:03', NULL, NULL, NULL, 'Active'),
(83, 11, 3, 255, '2019-12-11 10:51:03', NULL, NULL, NULL, 'Active'),
(84, 11, 4, 165, '2019-12-11 10:51:03', NULL, NULL, NULL, 'Active'),
(85, 11, 5, 190, '2019-12-11 10:51:03', NULL, NULL, NULL, 'Active'),
(86, 11, 7, 25, '2019-12-11 10:51:03', NULL, NULL, NULL, 'Active'),
(87, 11, 8, 18, '2019-12-11 10:51:03', NULL, NULL, NULL, 'Active'),
(88, 11, 9, 455, '2019-12-11 10:51:03', NULL, NULL, NULL, 'Active'),
(89, 12, 1, 265, '2019-12-11 10:51:25', NULL, NULL, NULL, 'Active'),
(90, 12, 2, 245, '2019-12-11 10:51:25', NULL, NULL, NULL, 'Active'),
(91, 12, 3, 255, '2019-12-11 10:51:25', NULL, NULL, NULL, 'Active'),
(92, 12, 4, 165, '2019-12-11 10:51:25', NULL, NULL, NULL, 'Active'),
(93, 12, 5, 190, '2019-12-11 10:51:25', NULL, NULL, NULL, 'Active'),
(94, 12, 7, 25, '2019-12-11 10:51:25', NULL, NULL, NULL, 'Active'),
(95, 12, 8, 18, '2019-12-11 10:51:25', NULL, NULL, NULL, 'Active'),
(96, 12, 9, 455, '2019-12-11 10:51:25', NULL, NULL, NULL, 'Active'),
(97, 13, 1, 265, '2019-12-11 10:51:31', NULL, NULL, NULL, 'Active'),
(98, 13, 2, 245, '2019-12-11 10:51:31', NULL, NULL, NULL, 'Active'),
(99, 13, 3, 255, '2019-12-11 10:51:31', NULL, NULL, NULL, 'Active'),
(100, 13, 4, 165, '2019-12-11 10:51:31', NULL, NULL, NULL, 'Active'),
(101, 13, 5, 190, '2019-12-11 10:51:31', NULL, NULL, NULL, 'Active'),
(102, 13, 7, 25, '2019-12-11 10:51:31', NULL, NULL, NULL, 'Active'),
(103, 13, 8, 18, '2019-12-11 10:51:31', NULL, NULL, NULL, 'Active'),
(104, 13, 9, 455, '2019-12-11 10:51:31', NULL, NULL, NULL, 'Active'),
(105, 14, 1, 265, '2019-12-11 10:51:32', NULL, NULL, NULL, 'Active'),
(106, 14, 2, 245, '2019-12-11 10:51:32', NULL, NULL, NULL, 'Active'),
(107, 14, 3, 255, '2019-12-11 10:51:32', NULL, NULL, NULL, 'Active'),
(108, 14, 4, 165, '2019-12-11 10:51:32', NULL, NULL, NULL, 'Active'),
(109, 14, 5, 190, '2019-12-11 10:51:32', NULL, NULL, NULL, 'Active'),
(110, 14, 7, 25, '2019-12-11 10:51:32', NULL, NULL, NULL, 'Active'),
(111, 14, 8, 18, '2019-12-11 10:51:32', NULL, NULL, NULL, 'Active'),
(112, 14, 9, 455, '2019-12-11 10:51:32', NULL, NULL, NULL, 'Active'),
(113, 15, 1, 265, '2019-12-11 10:51:33', NULL, NULL, NULL, 'Active'),
(114, 15, 2, 245, '2019-12-11 10:51:33', NULL, NULL, NULL, 'Active'),
(115, 15, 3, 255, '2019-12-11 10:51:33', NULL, NULL, NULL, 'Active'),
(116, 15, 4, 165, '2019-12-11 10:51:33', NULL, NULL, NULL, 'Active'),
(117, 15, 5, 190, '2019-12-11 10:51:33', NULL, NULL, NULL, 'Active'),
(118, 15, 7, 25, '2019-12-11 10:51:33', NULL, NULL, NULL, 'Active'),
(119, 15, 8, 18, '2019-12-11 10:51:33', NULL, NULL, NULL, 'Active'),
(120, 15, 9, 455, '2019-12-11 10:51:33', NULL, NULL, NULL, 'Active'),
(121, 16, 1, 265, '2019-12-11 10:51:34', NULL, NULL, NULL, 'Active'),
(122, 16, 2, 245, '2019-12-11 10:51:34', NULL, NULL, NULL, 'Active'),
(123, 16, 3, 255, '2019-12-11 10:51:34', NULL, NULL, NULL, 'Active'),
(124, 16, 4, 165, '2019-12-11 10:51:34', NULL, NULL, NULL, 'Active'),
(125, 16, 5, 190, '2019-12-11 10:51:34', NULL, NULL, NULL, 'Active'),
(126, 16, 7, 25, '2019-12-11 10:51:34', NULL, NULL, NULL, 'Active'),
(127, 16, 8, 18, '2019-12-11 10:51:34', NULL, NULL, NULL, 'Active'),
(128, 16, 9, 455, '2019-12-11 10:51:34', NULL, NULL, NULL, 'Active'),
(129, 17, 1, 265, '2019-12-11 10:51:35', NULL, NULL, NULL, 'Active'),
(130, 17, 2, 245, '2019-12-11 10:51:35', NULL, NULL, NULL, 'Active'),
(131, 17, 3, 255, '2019-12-11 10:51:35', NULL, NULL, NULL, 'Active'),
(132, 17, 4, 165, '2019-12-11 10:51:35', NULL, NULL, NULL, 'Active'),
(133, 17, 5, 190, '2019-12-11 10:51:35', NULL, NULL, NULL, 'Active'),
(134, 17, 7, 25, '2019-12-11 10:51:35', NULL, NULL, NULL, 'Active'),
(135, 17, 8, 18, '2019-12-11 10:51:35', NULL, NULL, NULL, 'Active'),
(136, 17, 9, 455, '2019-12-11 10:51:35', NULL, NULL, NULL, 'Active'),
(137, 18, 1, 265, '2019-12-11 10:51:37', NULL, NULL, NULL, 'Active'),
(138, 18, 2, 245, '2019-12-11 10:51:37', NULL, NULL, NULL, 'Active'),
(139, 18, 3, 255, '2019-12-11 10:51:37', NULL, NULL, NULL, 'Active'),
(140, 18, 4, 165, '2019-12-11 10:51:37', NULL, NULL, NULL, 'Active'),
(141, 18, 5, 190, '2019-12-11 10:51:37', NULL, NULL, NULL, 'Active'),
(142, 18, 7, 25, '2019-12-11 10:51:37', NULL, NULL, NULL, 'Active'),
(143, 18, 8, 18, '2019-12-11 10:51:37', NULL, NULL, NULL, 'Active'),
(144, 18, 9, 455, '2019-12-11 10:51:37', NULL, NULL, NULL, 'Active'),
(145, 19, 1, 265, '2019-12-11 10:51:46', NULL, NULL, NULL, 'Active'),
(146, 19, 2, 245, '2019-12-11 10:51:46', NULL, NULL, NULL, 'Active'),
(147, 19, 3, 255, '2019-12-11 10:51:46', NULL, NULL, NULL, 'Active'),
(148, 19, 4, 165, '2019-12-11 10:51:46', NULL, NULL, NULL, 'Active'),
(149, 19, 5, 190, '2019-12-11 10:51:46', NULL, NULL, NULL, 'Active'),
(150, 19, 7, 25, '2019-12-11 10:51:46', NULL, NULL, NULL, 'Active'),
(151, 19, 8, 18, '2019-12-11 10:51:46', NULL, NULL, NULL, 'Active'),
(152, 19, 9, 455, '2019-12-11 10:51:46', NULL, NULL, NULL, 'Active'),
(153, 20, 1, 265, '2019-12-11 10:53:24', NULL, NULL, NULL, 'Active'),
(154, 20, 2, 245, '2019-12-11 10:53:24', NULL, NULL, NULL, 'Active'),
(155, 20, 3, 255, '2019-12-11 10:53:24', NULL, NULL, NULL, 'Active'),
(156, 20, 4, 165, '2019-12-11 10:53:24', NULL, NULL, NULL, 'Active'),
(157, 20, 5, 190, '2019-12-11 10:53:24', NULL, NULL, NULL, 'Active'),
(158, 20, 7, 25, '2019-12-11 10:53:24', NULL, NULL, NULL, 'Active'),
(159, 20, 8, 18, '2019-12-11 10:53:24', NULL, NULL, NULL, 'Active'),
(160, 20, 9, 455, '2019-12-11 10:53:24', NULL, NULL, NULL, 'Active'),
(161, 21, 1, 265, '2019-12-11 12:53:22', NULL, NULL, NULL, 'Active'),
(162, 21, 2, 245, '2019-12-11 12:53:22', NULL, NULL, NULL, 'Active'),
(163, 21, 3, 255, '2019-12-11 12:53:22', NULL, NULL, NULL, 'Active'),
(164, 21, 4, 167, '2019-12-11 12:53:22', NULL, '2019-12-17 04:39:08', NULL, 'Active'),
(165, 21, 5, 198, '2019-12-11 12:53:22', NULL, '2019-12-17 04:39:08', NULL, 'Active'),
(166, 21, 7, 27, '2019-12-11 12:53:22', NULL, '2019-12-17 04:39:08', NULL, 'Active'),
(167, 21, 8, 18, '2019-12-11 12:53:22', NULL, NULL, NULL, 'Active'),
(168, 21, 9, 455, '2019-12-11 12:53:22', NULL, NULL, NULL, 'Active'),
(169, 22, 1, 265, '2019-12-16 18:15:08', NULL, NULL, NULL, 'Active'),
(170, 22, 2, 245, '2019-12-16 18:15:08', NULL, NULL, NULL, 'Active'),
(171, 22, 3, 255, '2019-12-16 18:15:08', NULL, NULL, NULL, 'Active'),
(172, 22, 4, 165, '2019-12-16 18:15:08', NULL, NULL, NULL, 'Active'),
(173, 22, 5, 190, '2019-12-16 18:15:08', NULL, NULL, NULL, 'Active'),
(174, 22, 7, 25, '2019-12-16 18:15:08', NULL, NULL, NULL, 'Active'),
(175, 22, 8, 18, '2019-12-16 18:15:08', NULL, NULL, NULL, 'Active'),
(176, 22, 9, 455, '2019-12-16 18:15:08', NULL, NULL, NULL, 'Active'),
(177, 23, 1, 2000, '2019-12-17 14:15:21', NULL, '2019-12-17 03:46:07', NULL, 'Active'),
(178, 23, 2, 245, '2019-12-17 14:15:21', NULL, NULL, NULL, 'Active'),
(179, 23, 3, 255, '2019-12-17 14:15:21', NULL, NULL, NULL, 'Active'),
(180, 23, 4, 165, '2019-12-17 14:15:21', NULL, NULL, NULL, 'Active'),
(181, 23, 5, 190, '2019-12-17 14:15:21', NULL, NULL, NULL, 'Active'),
(182, 23, 7, 25, '2019-12-17 14:15:21', NULL, NULL, NULL, 'Active'),
(183, 23, 8, 18, '2019-12-17 14:15:21', NULL, NULL, NULL, 'Active'),
(184, 23, 9, 455, '2019-12-17 14:15:21', NULL, NULL, NULL, 'Active'),
(185, 24, 1, 261, '2019-12-17 14:33:24', NULL, '2019-12-17 04:04:53', NULL, 'Active'),
(186, 24, 2, 247, '2019-12-17 14:33:24', NULL, '2019-12-17 04:04:53', NULL, 'Active'),
(187, 24, 3, 255, '2019-12-17 14:33:24', NULL, NULL, NULL, 'Active'),
(188, 24, 4, 165, '2019-12-17 14:33:24', NULL, NULL, NULL, 'Active'),
(189, 24, 5, 198, '2019-12-17 14:33:24', NULL, '2019-12-17 04:04:53', NULL, 'Active'),
(190, 24, 7, 22, '2019-12-17 14:33:24', NULL, '2019-12-17 04:04:53', NULL, 'Active'),
(191, 24, 8, 18, '2019-12-17 14:33:24', NULL, NULL, NULL, 'Active'),
(192, 24, 9, 455, '2019-12-17 14:33:24', NULL, NULL, NULL, 'Active'),
(193, 1, 10, 120, '2019-12-17 17:38:18', 2, NULL, NULL, 'Active'),
(194, 2, 10, 120, '2019-12-17 17:38:18', 2, NULL, NULL, 'Active'),
(195, 3, 10, 120, '2019-12-17 17:38:18', 2, NULL, NULL, 'Active'),
(196, 4, 10, 120, '2019-12-17 17:38:18', 2, NULL, NULL, 'Active'),
(197, 5, 10, 120, '2019-12-17 17:38:18', 2, NULL, NULL, 'Active'),
(198, 6, 10, 120, '2019-12-17 17:38:18', 2, NULL, NULL, 'Active'),
(199, 7, 10, 120, '2019-12-17 17:38:18', 2, NULL, NULL, 'Active'),
(200, 8, 10, 120, '2019-12-17 17:38:18', 2, NULL, NULL, 'Active'),
(201, 9, 10, 120, '2019-12-17 17:38:18', 2, NULL, NULL, 'Active'),
(202, 10, 10, 120, '2019-12-17 17:38:18', 2, NULL, NULL, 'Active'),
(203, 11, 10, 120, '2019-12-17 17:38:18', 2, NULL, NULL, 'Active'),
(204, 12, 10, 120, '2019-12-17 17:38:18', 2, NULL, NULL, 'Active'),
(205, 13, 10, 120, '2019-12-17 17:38:18', 2, NULL, NULL, 'Active'),
(206, 14, 10, 120, '2019-12-17 17:38:18', 2, NULL, NULL, 'Active'),
(207, 15, 10, 120, '2019-12-17 17:38:18', 2, NULL, NULL, 'Active'),
(208, 16, 10, 120, '2019-12-17 17:38:18', 2, NULL, NULL, 'Active'),
(209, 17, 10, 120, '2019-12-17 17:38:18', 2, NULL, NULL, 'Active'),
(210, 18, 10, 120, '2019-12-17 17:38:18', 2, NULL, NULL, 'Active'),
(211, 19, 10, 120, '2019-12-17 17:38:18', 2, NULL, NULL, 'Active'),
(212, 20, 10, 120, '2019-12-17 17:38:18', 2, NULL, NULL, 'Active'),
(213, 21, 10, 120, '2019-12-17 17:38:18', 2, NULL, NULL, 'Active'),
(214, 22, 10, 120, '2019-12-17 17:38:18', 2, NULL, NULL, 'Active'),
(215, 23, 10, 120, '2019-12-17 17:38:18', 2, NULL, NULL, 'Active'),
(216, 24, 10, 120, '2019-12-17 17:38:18', 2, NULL, NULL, 'Active');

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

--
-- Dumping data for table `client_visits`
--

INSERT INTO `client_visits` (`id`, `client_id`, `visit_date`, `visit_time`, `visit_type`, `opportunity`, `other_notes`, `visit_notes`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 6, '2019-12-09', '10:45:00', 'inperson', 'y es', NULL, NULL, '2019-12-06 12:45:41', 1, NULL, NULL),
(2, 22, '2019-12-16', '06:16:00', 'inperson', '15 boxes monthly', NULL, 'falaja', '2019-12-16 18:17:06', 1, '2019-12-18 07:33:48', NULL),
(3, 22, '2019-12-16', '06:16:00', 'inperson', '15 boxes monthly', NULL, 'falaja', '2019-12-16 18:17:06', 1, '2019-12-18 07:33:48', NULL),
(4, 22, '2019-12-16', '06:16:00', 'inperson', '15 boxes monthly', NULL, 'falaja', '2019-12-16 18:17:06', 1, '2019-12-18 07:33:48', NULL),
(5, 6, '2019-12-18', '11:55:00', 'inperson', '10 box', NULL, 'test', '2019-12-17 12:55:41', 1, '2019-12-18 07:33:41', NULL),
(6, 6, '2019-12-18', '11:55:00', 'inperson', '10 box', NULL, 'test', '2019-12-17 12:55:41', 1, '2019-12-18 07:33:48', NULL),
(7, 6, '2019-12-18', '11:55:00', 'inperson', '10 box', NULL, 'test', '2019-12-17 12:55:41', 1, '2019-12-18 07:33:48', NULL),
(8, 6, '2019-12-18', '11:55:00', 'inperson', '10 box', NULL, 'test', '2019-12-17 12:55:42', 1, '2019-12-18 07:33:48', NULL),
(9, 1, '2019-12-17', '12:59:00', 'inperson', NULL, NULL, NULL, '2019-12-17 12:59:52', 1, NULL, NULL),
(10, 1, '2019-12-17', '15:00:00', 'inperson', 'hello', NULL, 'test', '2019-12-17 13:00:24', 1, '2019-12-18 07:33:48', NULL),
(11, 1, '2019-12-18', '16:41:00', 'inperson', NULL, NULL, 'this is test note.', '2019-12-18 16:41:47', 1, '2019-12-18 07:33:48', NULL),
(12, 2, '2019-12-18', '17:58:00', 'inperson', 'abcd', NULL, 'defg', '2019-12-18 17:58:27', 1, NULL, NULL);

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
  `expected_delivey_datetime` datetime DEFAULT NULL,
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
(1, '2019-12-05 00:00:00', '2019-12-05 14:39:34', 'Office', NULL, '2019-12-05 14:30:38', 2, '2019-12-05 18:42:35', 2, 'Active', 0),
(2, '2019-12-05 00:00:00', '2019-12-05 15:20:03', 'Office', NULL, '2019-12-05 14:53:39', 2, '2019-12-06 19:08:43', 2, 'Active', 0),
(3, '2019-12-05 00:00:00', '2019-12-05 18:13:03', 'Office', NULL, '2019-12-05 16:54:15', 2, '2019-12-05 18:43:03', 2, 'Active', 0),
(4, '2019-12-05 00:00:00', NULL, 'Office', NULL, '2019-12-05 18:23:52', 2, '2019-12-06 19:04:17', 2, 'Active', 0),
(5, '2019-12-06 00:00:00', '2019-12-06 13:27:34', 'Office', NULL, '2019-12-06 11:34:23', 2, '2019-12-06 00:00:00', 3, 'Active', 0),
(6, '2019-12-06 00:00:00', '2019-12-06 15:55:20', 'Warehouse', 2, '2019-12-06 14:33:29', 2, '2019-12-06 00:00:00', 3, 'Active', 0),
(7, '2019-12-06 00:00:00', NULL, 'Office', NULL, '2019-12-06 15:01:08', 2, NULL, NULL, 'Active', 0),
(8, '2019-12-09 00:00:00', '2019-12-09 11:54:57', 'Office', NULL, '2019-12-09 11:54:33', 2, '2019-12-09 00:00:00', 3, 'Active', 0),
(9, '2019-12-09 00:00:00', '2019-12-09 18:53:03', 'Warehouse', 2, '2019-12-09 14:58:36', 2, '2019-12-09 00:00:00', 4, 'Active', 0),
(10, '2019-12-11 00:00:00', '2019-12-11 12:59:23', 'Office', NULL, '2019-12-11 12:55:53', 2, '2019-12-11 00:00:00', 4, 'Active', 0),
(11, '2019-12-11 00:00:00', '2019-12-11 13:06:27', 'Office', NULL, '2019-12-11 13:04:56', 2, '2019-12-11 00:00:00', 4, 'Active', 0),
(12, '2019-12-16 00:00:00', NULL, 'Warehouse', 2, '2019-12-16 18:33:54', 2, NULL, NULL, 'Active', 0),
(13, '2019-12-17 00:00:00', '2019-12-17 15:57:52', 'Office', NULL, '2019-12-17 13:46:29', 2, '2019-12-17 00:00:00', 3, 'Active', 0),
(14, '2019-12-17 00:00:00', '2019-12-17 16:02:49', 'Warehouse', 1, '2019-12-17 13:47:24', 2, '2019-12-17 00:00:00', 3, 'Active', 0),
(15, '2019-12-17 00:00:00', '2019-12-17 15:58:14', 'Office', NULL, '2019-12-17 13:48:20', 2, '2019-12-17 00:00:00', 3, 'Active', 0),
(16, '2019-12-17 00:00:00', '2019-12-17 17:19:26', 'Office', NULL, '2019-12-17 13:50:10', 2, '2019-12-17 00:00:00', 4, 'Active', 0),
(17, '2019-12-17 00:00:00', '2019-12-17 16:02:53', 'Office', NULL, '2019-12-17 14:13:47', 2, '2019-12-17 00:00:00', 3, 'Active', 0),
(18, '2019-12-17 00:00:00', '2019-12-17 16:58:11', 'Office', NULL, '2019-12-17 14:16:25', 2, '2019-12-17 00:00:00', 3, 'Active', 0),
(19, '2019-12-17 00:00:00', '2019-12-17 18:04:56', 'Office', NULL, '2019-12-17 14:18:40', 2, '2019-12-17 00:00:00', 3, 'Active', 0),
(20, '2019-12-17 00:00:00', NULL, 'Office', NULL, '2019-12-17 14:23:04', 2, NULL, NULL, 'Active', 0),
(21, '2019-12-17 00:00:00', NULL, 'Office', NULL, '2019-12-17 14:25:21', 2, NULL, NULL, 'Active', 0),
(26, '2019-12-17 00:00:00', '2019-12-17 16:13:16', 'Office', NULL, '2019-12-17 15:09:49', 2, '2019-12-17 00:00:00', 4, 'Active', 0),
(27, '2019-12-17 00:00:00', '2019-12-17 16:00:13', 'Office', NULL, '2019-12-17 15:16:19', 2, '2019-12-17 00:00:00', 3, 'Active', 0),
(39, '2019-12-17 00:00:00', NULL, 'Office', NULL, '2019-12-17 15:59:20', 2, '2019-12-17 15:59:49', 2, 'Active', 0),
(40, '2019-12-17 00:00:00', '2019-12-17 17:06:53', 'Office', NULL, '2019-12-17 17:02:19', 2, '2019-12-17 00:00:00', 3, 'Active', 0),
(42, '2019-12-17 00:00:00', NULL, 'Office', NULL, '2019-12-17 17:56:07', 2, NULL, NULL, 'Active', 0),
(43, '2019-12-18 00:00:00', NULL, 'Office', NULL, '2019-12-18 13:37:35', 2, NULL, NULL, 'Active', 0),
(44, '2019-12-18 00:00:00', '2019-12-18 16:35:15', 'Office', NULL, '2019-12-18 13:38:42', 2, '2019-12-18 00:00:00', 3, 'Active', 0);

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
(9, 1, 1, 4, NULL, '2019-12-05 18:42:35', 2, NULL, NULL, 'Active', 0),
(10, 3, 5, 4, 3, '2019-12-05 18:43:03', 2, NULL, NULL, 'Active', 0),
(11, 5, 3, 4, 3, '2019-12-06 11:34:23', 2, NULL, NULL, 'Active', 0),
(12, 6, 7, 4, 3, '2019-12-06 14:33:29', 2, NULL, NULL, 'Active', 0),
(13, 7, 3, 4, 3, '2019-12-06 15:01:08', 2, NULL, NULL, 'Active', 0),
(23, 4, 2, 4, NULL, '2019-12-06 19:04:17', 2, NULL, NULL, 'Active', 0),
(24, 2, 1, 4, NULL, '2019-12-06 19:08:43', 2, NULL, NULL, 'Active', 0),
(25, 8, 5, 4, 3, '2019-12-09 11:54:33', 2, NULL, NULL, 'Active', 0),
(26, 9, 1, 4, NULL, '2019-12-09 14:58:36', 2, NULL, NULL, 'Active', 0),
(27, 10, 1, 4, NULL, '2019-12-11 12:55:53', 2, NULL, NULL, 'Active', 0),
(28, 11, 2, 4, NULL, '2019-12-11 13:04:56', 2, NULL, NULL, 'Active', 0),
(29, 12, 5, 4, 3, '2019-12-16 18:33:54', 2, NULL, NULL, 'Active', 0),
(30, 13, 5, 4, 3, '2019-12-17 13:46:29', 2, NULL, NULL, 'Active', 0),
(31, 14, 1, 4, 3, '2019-12-17 13:47:24', 2, NULL, NULL, 'Active', 0),
(32, 15, 2, 4, 3, '2019-12-17 13:48:20', 2, NULL, NULL, 'Active', 0),
(33, 16, 2, 4, NULL, '2019-12-17 13:50:10', 2, NULL, NULL, 'Active', 0),
(34, 17, 2, 4, 3, '2019-12-17 14:13:47', 2, NULL, NULL, 'Active', 0),
(35, 18, 1, 4, 3, '2019-12-17 14:16:25', 2, NULL, NULL, 'Active', 0),
(36, 19, 1, 4, 3, '2019-12-17 14:18:40', 2, NULL, NULL, 'Active', 0),
(37, 20, 1, 4, 3, '2019-12-17 14:23:04', 2, NULL, NULL, 'Active', 0),
(38, 21, 1, 4, 3, '2019-12-17 14:25:21', 2, NULL, NULL, 'Active', 0),
(43, 26, 1, 4, 3, '2019-12-17 15:09:49', 2, NULL, NULL, 'Active', 0),
(44, 27, 1, 4, 3, '2019-12-17 15:16:19', 2, NULL, NULL, 'Active', 0),
(67, 39, 1, 4, NULL, '2019-12-17 15:59:49', 2, NULL, NULL, 'Active', 0),
(68, 40, 1, 4, 3, '2019-12-17 17:02:19', 2, NULL, NULL, 'Active', 0),
(70, 42, 1, 4, 3, '2019-12-17 17:56:07', 2, NULL, NULL, 'Active', 0),
(71, 43, 1, 4, 3, '2019-12-18 13:37:35', 2, NULL, NULL, 'Active', 0),
(72, 44, 1, 4, 3, '2019-12-18 13:38:42', 2, NULL, NULL, 'Active', 0);

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

INSERT INTO `delivery_config_orders` (`id`, `delivery_id`, `delivery_config_id`, `order_id`, `order_weight`, `payment_mode`, `amount`, `notes`, `signature_file`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`, `is_deleted`) VALUES
(9, 1, 9, 1, 0, NULL, 0, NULL, NULL, '2019-12-05 18:42:35', 2, NULL, NULL, 'Active', 0),
(10, 3, 10, 3, 0, NULL, 0, NULL, NULL, '2019-12-05 18:43:03', 2, NULL, NULL, 'Active', 0),
(11, 5, 11, 7, 0, 'Cash', 25, 'This', '1575618989207.png', '2019-12-06 11:34:23', 2, '2019-12-06 00:00:00', 3, 'Active', 0),
(12, 6, 12, 6, 0, 'Cash', 200, '', NULL, '2019-12-06 14:33:29', 2, '2019-12-06 00:00:00', 3, 'Active', 0),
(13, 6, 12, 10, 0, 'Cash', 0, 'test', '15756278299572.png', '2019-12-06 14:33:29', 2, '2019-12-06 00:00:00', 3, 'Active', 0),
(14, 7, 13, 9, 0, NULL, 0, NULL, NULL, '2019-12-06 15:01:08', 2, NULL, NULL, 'Active', 0),
(24, 4, 23, 4, 0, NULL, 0, NULL, NULL, '2019-12-06 19:04:17', 2, NULL, NULL, 'Active', 0),
(25, 2, 24, 2, 0, NULL, 0, NULL, NULL, '2019-12-06 19:08:43', 2, NULL, NULL, 'Active', 0),
(26, 8, 25, 11, 0, 'Cash', 0, '', NULL, '2019-12-09 11:54:33', 2, '2019-12-09 00:00:00', 3, 'Active', 0),
(27, 9, 26, 12, 0, 'Cash', 5100, '', '15758977669121.png', '2019-12-09 14:58:36', 2, '2019-12-09 08:42:59', 4, 'Active', 0),
(28, 10, 27, 24, 0, 'Cash', 600, '', '1576049359024.png', '2019-12-11 12:55:53', 2, '2019-12-11 00:00:00', 4, 'Active', 0),
(29, 11, 28, 25, 0, 'Cash', 2000, 'test', '1576049779930.png', '2019-12-11 13:04:56', 2, '2019-12-11 00:00:00', 4, 'Active', 0),
(30, 12, 29, 15, 0, NULL, 0, NULL, NULL, '2019-12-16 18:33:54', 2, NULL, NULL, 'Active', 0),
(31, 12, 29, 16, 0, NULL, 0, NULL, NULL, '2019-12-16 18:33:54', 2, NULL, NULL, 'Active', 0),
(32, 13, 30, 22, 0, 'Cash', 258, '', '15765784172776.png', '2019-12-17 13:46:29', 2, '2019-12-17 00:00:00', 3, 'Active', 0),
(33, 14, 31, 17, 0, 'Cash', 50, '', NULL, '2019-12-17 13:47:24', 2, '2019-12-17 00:00:00', 3, 'Active', 0),
(34, 15, 32, 14, 0, 'Cash', 56, '', NULL, '2019-12-17 13:48:20', 2, '2019-12-17 00:00:00', 3, 'Active', 0),
(35, 16, 33, 18, 0, 'Cash', 2873.75, 'test', '1576583345026.png', '2019-12-17 13:50:10', 2, '2019-12-17 00:00:00', 4, 'Active', 0),
(36, 17, 34, 19, 0, 'Cash', 5, 'dd', '1576578764461.png', '2019-12-17 14:13:47', 2, '2019-12-17 00:00:00', 3, 'Active', 0),
(37, 18, 35, 20, 0, 'Cash', 5, '', NULL, '2019-12-17 14:16:25', 2, '2019-12-17 00:00:00', 3, 'Active', 0),
(38, 19, 36, 21, 0, 'Cash', 200, 'gg', NULL, '2019-12-17 14:18:40', 2, '2019-12-17 00:00:00', 3, 'Active', 0),
(39, 20, 37, 23, 0, NULL, 0, NULL, NULL, '2019-12-17 14:23:04', 2, NULL, NULL, 'Active', 0),
(40, 21, 38, 26, 0, NULL, 0, NULL, NULL, '2019-12-17 14:25:21', 2, NULL, NULL, 'Active', 0),
(45, 26, 43, 29, 0, 'CashCash', 940.6, 'submit by postman', 'saajan-july-83.jpg', '2019-12-17 15:09:49', 2, '2019-12-17 00:00:00', 4, 'Active', 0),
(46, 27, 44, 28, 0, 'Cash', 2222.05, '', '15765785969564.png', '2019-12-17 15:16:19', 2, '2019-12-17 00:00:00', 3, 'Active', 0),
(69, 39, 67, 32, 0, NULL, 0, NULL, NULL, '2019-12-17 15:59:49', 2, NULL, NULL, 'Active', 0),
(70, 40, 68, 38, 0, 'Cash', 5000, '', NULL, '2019-12-17 17:02:19', 2, '2019-12-17 00:00:00', 3, 'Active', 0),
(73, 42, 70, 35, 0, NULL, 0, NULL, NULL, '2019-12-17 17:56:07', 2, NULL, NULL, 'Active', 0),
(74, 43, 71, 33, 0, NULL, 0, NULL, NULL, '2019-12-18 13:37:35', 2, NULL, NULL, 'Active', 0),
(75, 44, 72, 13, 0, 'Cash', 200, 'rakesh test', '1576667103304.png', '2019-12-18 13:38:42', 2, '2019-12-18 00:00:00', 3, 'Active', 0);

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
(10, 1, 2, '2019-12-05 18:42:35', 2, NULL, NULL, 'Active', 0),
(11, 3, 1, '2019-12-05 18:43:03', 2, NULL, NULL, 'Active', 0),
(12, 3, 2, '2019-12-05 18:43:03', 2, NULL, NULL, 'Active', 0),
(13, 5, 1, '2019-12-06 11:34:23', 2, NULL, NULL, 'Active', 0),
(14, 6, 1, '2019-12-06 14:33:29', 2, NULL, NULL, 'Active', 0),
(15, 6, 2, '2019-12-06 14:33:29', 2, NULL, NULL, 'Active', 0),
(16, 7, 1, '2019-12-06 15:01:08', 2, NULL, NULL, 'Active', 0),
(26, 4, 1, '2019-12-06 19:04:17', 2, NULL, NULL, 'Active', 0),
(27, 2, 1, '2019-12-06 19:08:43', 2, NULL, NULL, 'Active', 0),
(28, 8, 1, '2019-12-09 11:54:33', 2, NULL, NULL, 'Active', 0),
(29, 9, 1, '2019-12-09 14:58:36', 2, NULL, NULL, 'Active', 0),
(30, 10, 1, '2019-12-11 12:55:53', 2, NULL, NULL, 'Active', 0),
(31, 11, 1, '2019-12-11 13:04:56', 2, NULL, NULL, 'Active', 0),
(32, 12, 1, '2019-12-16 18:33:54', 2, NULL, NULL, 'Active', 0),
(33, 13, 1, '2019-12-17 13:46:29', 2, NULL, NULL, 'Active', 0),
(34, 14, 1, '2019-12-17 13:47:24', 2, NULL, NULL, 'Active', 0),
(35, 15, 1, '2019-12-17 13:48:20', 2, NULL, NULL, 'Active', 0),
(36, 16, 1, '2019-12-17 13:50:10', 2, NULL, NULL, 'Active', 0),
(37, 17, 1, '2019-12-17 14:13:47', 2, NULL, NULL, 'Active', 0),
(38, 18, 1, '2019-12-17 14:16:25', 2, NULL, NULL, 'Active', 0),
(39, 19, 1, '2019-12-17 14:18:40', 2, NULL, NULL, 'Active', 0),
(40, 20, 1, '2019-12-17 14:23:04', 2, NULL, NULL, 'Active', 0),
(41, 21, 1, '2019-12-17 14:25:21', 2, NULL, NULL, 'Active', 0),
(46, 26, 1, '2019-12-17 15:09:49', 2, NULL, NULL, 'Active', 0),
(47, 27, 1, '2019-12-17 15:16:19', 2, NULL, NULL, 'Active', 0),
(70, 39, 1, '2019-12-17 15:59:49', 2, NULL, NULL, 'Active', 0),
(71, 40, 1, '2019-12-17 17:02:19', 2, NULL, NULL, 'Active', 0),
(72, 40, 2, '2019-12-17 17:02:19', 2, NULL, NULL, 'Active', 0),
(74, 42, 1, '2019-12-17 17:56:07', 2, NULL, NULL, 'Active', 0),
(75, 43, 1, '2019-12-18 13:37:35', 2, NULL, NULL, 'Active', 0),
(76, 44, 1, '2019-12-18 13:38:42', 2, NULL, NULL, 'Active', 0),
(77, 44, 2, '2019-12-18 13:38:42', 2, NULL, NULL, 'Active', 0);

-- --------------------------------------------------------

--
-- Table structure for table `fcm_notifications`
--

CREATE TABLE `fcm_notifications` (
  `id` int(11) NOT NULL,
  `title` varchar(200) DEFAULT NULL,
  `message` varchar(500) DEFAULT NULL,
  `user_arr` varchar(500) DEFAULT NULL,
  `fcm_tokens` varchar(500) DEFAULT NULL,
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
(18, 'Order Delivery', 'New Delivery Created.', NULL, NULL, '{\"multicast_id\":5389625389295748395,\"success\":2,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1575612263827559%c07a64c8c07a64c8\"},{\"message_id\":\"0:1575612263832674%c07a64c8c07a64c8\"}]}', '2019-12-06 01:04:23', NULL, NULL, NULL, 'Active'),
(19, 'Order Delivery', 'New Delivery Created.', NULL, NULL, '{\"multicast_id\":1239844858012188108,\"success\":2,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1575623009430167%c07a64c8c07a64c8\"},{\"message_id\":\"0:1575623009505982%c07a64c8c07a64c8\"}]}', '2019-12-06 04:03:29', NULL, NULL, NULL, 'Active'),
(20, 'Order Approval', 'Order NO. - 9 has been approved.', NULL, NULL, '{\"multicast_id\":7623588580558967564,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1575623099743788%c07a64c8c07a64c8\"}]}', '2019-12-06 04:04:59', NULL, NULL, NULL, 'Active'),
(21, 'Order Delivery', 'New Delivery Created.', NULL, NULL, '{\"multicast_id\":8110661255051371828,\"success\":2,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1575624668917512%c07a64c8c07a64c8\"},{\"message_id\":\"0:1575624668918040%c07a64c8c07a64c8\"}]}', '2019-12-06 04:31:08', NULL, NULL, NULL, 'Active'),
(22, 'Order Delivery', 'New Delivery Created.', NULL, NULL, '{\"multicast_id\":2207432161792365832,\"success\":0,\"failure\":1,\"canonical_ids\":0,\"results\":[{\"error\":\"NotRegistered\"}]}', '2019-12-06 08:16:55', NULL, NULL, NULL, 'Active'),
(23, 'Order Delivery', 'New Delivery Created.', NULL, NULL, '{\"multicast_id\":3928608792198012981,\"success\":0,\"failure\":1,\"canonical_ids\":0,\"results\":[{\"error\":\"NotRegistered\"}]}', '2019-12-06 08:21:40', NULL, NULL, NULL, 'Active'),
(24, 'Order Delivery', 'New Delivery Created.', NULL, NULL, '{\"multicast_id\":5960762886321609486,\"success\":0,\"failure\":1,\"canonical_ids\":0,\"results\":[{\"error\":\"NotRegistered\"}]}', '2019-12-06 08:21:40', NULL, NULL, NULL, 'Active'),
(25, 'Order Delivery', 'Delivery created for Khanjan testing at F/5 Chandrika Appartment with expected delivery on {expected_delivery_date} having order amount Rs.1800 with Order Id 4', NULL, NULL, '{\"multicast_id\":5798941372634448162,\"success\":0,\"failure\":1,\"canonical_ids\":0,\"results\":[{\"error\":\"NotRegistered\"}]}', '2019-12-06 08:24:15', NULL, NULL, NULL, 'Active'),
(26, 'Order Delivery', 'Delivery created for Khanjan testing at F/5 Chandrika Appartment with expected delivery on 05-12-2019 having order amount Rs.1800 with Order Id 4', NULL, NULL, '{\"multicast_id\":1728222140155323572,\"success\":0,\"failure\":1,\"canonical_ids\":0,\"results\":[{\"error\":\"NotRegistered\"}]}', '2019-12-06 08:27:13', NULL, NULL, NULL, 'Active'),
(27, 'Order Delivery', 'Delivery created for Khanjan testing at F/5 Chandrika Appartment with expected delivery on 05-12-2019 having order amount Rs.1800 with Order Id 4', NULL, NULL, '{\"multicast_id\":717715863046705195,\"success\":0,\"failure\":1,\"canonical_ids\":0,\"results\":[{\"error\":\"NotRegistered\"}]}', '2019-12-06 08:32:02', NULL, NULL, NULL, 'Active'),
(28, 'Order Delivery', 'Delivery created for Khanjan testing at F/5 Chandrika Appartment with expected delivery on 05-12-2019 having order amount Rs.1800 with Order Id 4', NULL, NULL, '{\"multicast_id\":6015498547758655202,\"success\":0,\"failure\":1,\"canonical_ids\":0,\"results\":[{\"error\":\"NotRegistered\"}]}', '2019-12-06 08:32:02', NULL, NULL, NULL, 'Active'),
(29, 'Order Delivery', 'New Delivery Created.', NULL, NULL, '{\"multicast_id\":5588352647357117118,\"success\":0,\"failure\":1,\"canonical_ids\":0,\"results\":[{\"error\":\"NotRegistered\"}]}', '2019-12-06 08:33:21', NULL, NULL, NULL, 'Active'),
(30, 'Order Delivery', 'Delivery created for Khanjan testing at F/5 Chandrika Appartment with expected delivery on 05-12-2019 having order amount Rs.1800 with Order Id 4', NULL, NULL, '{\"multicast_id\":3880462405341631999,\"success\":0,\"failure\":1,\"canonical_ids\":0,\"results\":[{\"error\":\"NotRegistered\"}]}', '2019-12-06 08:34:17', NULL, NULL, NULL, 'Active'),
(31, 'Order Delivery', 'Delivery created for Gandhi soda at ganesh complex, paladi char rasta, Ahmedabad with expected delivery on 05-12-2019 having order amount Rs.1800 with Order Id 2', NULL, NULL, '{\"multicast_id\":1964759386881603436,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1575639524170259%c07a64c8c07a64c8\"}]}', '2019-12-06 08:38:44', NULL, NULL, NULL, 'Active'),
(32, 'Order Approval', 'Order NO. - 11 has been approved.', NULL, NULL, '{\"multicast_id\":4785042393477181129,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1575872603377719%c07a64c8c07a64c8\"}]}', '2019-12-09 01:23:23', NULL, NULL, NULL, 'Active'),
(33, 'Order Delivery', 'Delivery created for modi sandwich at vasna with expected delivery on 09-12-2019 having order amount Rs.1800 with Order Id 11', NULL, NULL, '{\"multicast_id\":4445379666504943329,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1575872674156136%c07a64c8c07a64c8\"}]}', '2019-12-09 01:24:34', NULL, NULL, NULL, 'Active'),
(34, 'Order Delivery', 'Delivery created for modi sandwich at vasna with expected delivery on 09-12-2019 having order amount Rs.1800 with Order Id 11', NULL, NULL, '{\"multicast_id\":1162249602699921839,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1575872674601756%c07a64c8c07a64c8\"}]}', '2019-12-09 01:24:34', NULL, NULL, NULL, 'Active'),
(35, 'Order Delivery', 'Delivery created for Harish pan parlour at law garden circle, law garden with expected delivery on 09-12-2019 having order amount Rs. 5100 with Order Id 12', NULL, NULL, '{\"multicast_id\":3197102693919015358,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1575883717099841%c07a64c8c07a64c8\"}]}', '2019-12-09 04:28:37', NULL, NULL, NULL, 'Active'),
(36, 'Order Delivery', 'Delivery created for Queenland cafe at Jamalpur with expected delivery on 11-12-2019 having order amount Rs. 1258.75 with Order Id 24', NULL, NULL, '{\"multicast_id\":630573397802003910,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576049153693748%c07a64c8c07a64c8\"}]}', '2019-12-11 02:25:53', NULL, NULL, NULL, 'Active'),
(37, 'Order Delivery', 'Delivery created for Queenland cafe at Jamalpur with expected delivery on 11-12-2019 having order amount Rs. 2508 with Order Id 25', NULL, NULL, '{\"multicast_id\":4525694612959343284,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576049697007961%c07a64c8c07a64c8\"}]}', '2019-12-11 02:34:57', NULL, NULL, NULL, 'Active'),
(38, 'Order Delivery', 'Delivery created for Eminent hotel at sarkhej with expected delivery on 16-12-2019 having order amount Rs. 2873.75 with Order Id 15', NULL, NULL, '{\"multicast_id\":9170844293747566243,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576501435032544%c07a64c8c07a64c8\"}]}', '2019-12-16 08:03:55', NULL, NULL, NULL, 'Active'),
(39, 'Order Delivery', 'Delivery created for Eminent hotel at sarkhej with expected delivery on 16-12-2019 having order amount Rs. 2873.75 with Order Id 15', NULL, NULL, '{\"multicast_id\":5388345115765385801,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576501435348943%c07a64c8c07a64c8\"}]}', '2019-12-16 08:03:55', NULL, NULL, NULL, 'Active'),
(40, 'Order Delivery', 'Delivery created for Eminent hotel at sarkhej with expected delivery on 16-12-2019 having order amount Rs. 2873.75 with Order Id 16', NULL, NULL, '{\"multicast_id\":8821843949771648738,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576501435640932%c07a64c8c07a64c8\"}]}', '2019-12-16 08:03:55', NULL, NULL, NULL, 'Active'),
(41, 'Order Delivery', 'Delivery created for Eminent hotel at sarkhej with expected delivery on 16-12-2019 having order amount Rs. 2873.75 with Order Id 16', NULL, NULL, '{\"multicast_id\":1862548147518429527,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576501435934084%c07a64c8c07a64c8\"}]}', '2019-12-16 08:03:55', NULL, NULL, NULL, 'Active'),
(42, 'Order Delivery', 'Delivery created for Eminent hotel at sarkhej with expected delivery on 17-12-2019 having order amount Rs. 2873.75 with Order Id 22', NULL, NULL, '{\"multicast_id\":7272899348855700750,\"success\":0,\"failure\":1,\"canonical_ids\":0,\"results\":[{\"error\":\"NotRegistered\"}]}', '2019-12-17 03:16:30', NULL, NULL, NULL, 'Active'),
(43, 'Order Delivery', 'Delivery created for Eminent hotel at sarkhej with expected delivery on 17-12-2019 having order amount Rs. 2873.75 with Order Id 22', NULL, NULL, '{\"multicast_id\":8270735539922489281,\"success\":0,\"failure\":1,\"canonical_ids\":0,\"results\":[{\"error\":\"NotRegistered\"}]}', '2019-12-17 03:16:30', NULL, NULL, NULL, 'Active'),
(44, 'Order Delivery', 'Delivery created for Eminent hotel at sarkhej with expected delivery on 17-12-2019 having order amount Rs. 2873.75 with Order Id 17', NULL, NULL, '{\"multicast_id\":5804568219358740511,\"success\":0,\"failure\":1,\"canonical_ids\":0,\"results\":[{\"error\":\"NotRegistered\"}]}', '2019-12-17 03:17:24', NULL, NULL, NULL, 'Active'),
(45, 'Order Delivery', 'Delivery created for Eminent hotel at sarkhej with expected delivery on 17-12-2019 having order amount Rs. 2873.75 with Order Id 17', NULL, NULL, '{\"multicast_id\":1194758259096357820,\"success\":0,\"failure\":1,\"canonical_ids\":0,\"results\":[{\"error\":\"NotRegistered\"}]}', '2019-12-17 03:17:25', NULL, NULL, NULL, 'Active'),
(46, 'Order Delivery', 'Delivery created for Eminent hotel at sarkhej with expected delivery on 17-12-2019 having order amount Rs. 2873.75 with Order Id 14', NULL, NULL, '{\"multicast_id\":3205742675372170325,\"success\":0,\"failure\":1,\"canonical_ids\":0,\"results\":[{\"error\":\"NotRegistered\"}]}', '2019-12-17 03:18:20', NULL, NULL, NULL, 'Active'),
(47, 'Order Delivery', 'Delivery created for Eminent hotel at sarkhej with expected delivery on 17-12-2019 having order amount Rs. 2873.75 with Order Id 14', NULL, NULL, '{\"multicast_id\":728233556675177485,\"success\":0,\"failure\":1,\"canonical_ids\":0,\"results\":[{\"error\":\"NotRegistered\"}]}', '2019-12-17 03:18:21', NULL, NULL, NULL, 'Active'),
(48, 'Order Delivery', 'Delivery created for Eminent hotel at sarkhej with expected delivery on 17-12-2019 having order amount Rs. 2873.75 with Order Id 18', NULL, NULL, '{\"multicast_id\":6626532176720872274,\"success\":0,\"failure\":1,\"canonical_ids\":0,\"results\":[{\"error\":\"NotRegistered\"}]}', '2019-12-17 03:20:10', NULL, NULL, NULL, 'Active'),
(49, 'Order Delivery', 'Delivery created for Eminent hotel at sarkhej with expected delivery on 17-12-2019 having order amount Rs. 2873.75 with Order Id 19', NULL, NULL, '{\"multicast_id\":7213770850966200184,\"success\":0,\"failure\":1,\"canonical_ids\":0,\"results\":[{\"error\":\"NotRegistered\"}]}', '2019-12-17 03:43:48', NULL, NULL, NULL, 'Active'),
(50, 'Order Delivery', 'Delivery created for Eminent hotel at sarkhej with expected delivery on 17-12-2019 having order amount Rs. 2873.75 with Order Id 19', NULL, NULL, '{\"multicast_id\":4122323547184553400,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576572228262805%c07a64c8c07a64c8\"}]}', '2019-12-17 03:43:48', NULL, NULL, NULL, 'Active'),
(51, 'Order Approval', 'Order NO. - 27 has been approved.', NULL, NULL, '{\"multicast_id\":6366069560429498933,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576572368048452%c07a64c8c07a64c8\"}]}', '2019-12-17 03:46:08', NULL, NULL, NULL, 'Active'),
(52, 'Order Delivery', 'Delivery created for Eminent hotel at sarkhej with expected delivery on 17-12-2019 having order amount Rs. 2873.75 with Order Id 20', NULL, NULL, '{\"multicast_id\":244866731820504099,\"success\":0,\"failure\":1,\"canonical_ids\":0,\"results\":[{\"error\":\"NotRegistered\"}]}', '2019-12-17 03:46:25', NULL, NULL, NULL, 'Active'),
(53, 'Order Delivery', 'Delivery created for Eminent hotel at sarkhej with expected delivery on 17-12-2019 having order amount Rs. 2873.75 with Order Id 20', NULL, NULL, '{\"multicast_id\":5998301644412285486,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576572385686893%c07a64c8c07a64c8\"}]}', '2019-12-17 03:46:25', NULL, NULL, NULL, 'Active'),
(54, 'Order Delivery', 'Delivery created for Eminent hotel at sarkhej with expected delivery on 17-12-2019 having order amount Rs. 2873.75 with Order Id 21', NULL, '[\"fHkDUaHfLhI:APA91bFe3L_2Vjl5Cr78JdGLm9Q_K6smnS_tl8ZxqNbjdnSwpUzpQXtNt8zTRyQwYPsRRHQXDao9gzbsncCLy-ShUc29xKzfM_a-akH9LZY7eCc8rd94KjEF33vBcgvXPKXGYTSsPMhH\"]', '{\"multicast_id\":3849091509472904176,\"success\":0,\"failure\":1,\"canonical_ids\":0,\"results\":[{\"error\":\"NotRegistered\"}]}', '2019-12-17 03:48:40', NULL, NULL, NULL, 'Active'),
(55, 'Order Delivery', 'Delivery created for Eminent hotel at sarkhej with expected delivery on 17-12-2019 having order amount Rs. 2873.75 with Order Id 21', NULL, '[\"dUQ6_3RiqqM:APA91bHzkiJZ8CS9elbD4wT04-RNubATRHfP9LUScbfaDYwTx2YKaEn6sld8W9Ltrz4UOlCSNqFCKzMwstUHy930iNiNzuzRQHh6IyJ0qhAvjZNjcWR8jLjCmwWlP-SO9aiSl5llgjSQ\"]', '{\"multicast_id\":8563949178142093503,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576572521215988%c07a64c8c07a64c8\"}]}', '2019-12-17 03:48:41', NULL, NULL, NULL, 'Active'),
(56, 'Order Delivery', 'Delivery created for Eminent hotel at sarkhej with expected delivery on 17-12-2019 having order amount Rs. 2873.75 with Order Id 23', '[{\"user_id\":\"4\",\"device_id\":\"dUQ6_3RiqqM:APA91bHzkiJZ8CS9elbD4wT04-RNubATRHfP9LUScbfaDYwTx2YKaEn6sld8W9Ltrz4UOlCSNqFCKzMwstUHy930iNiNzuzRQHh6IyJ0qhAvjZNjcWR8jLjCmwWlP-SO9aiSl5llgjSQ\"}]', '[\"dUQ6_3RiqqM:APA91bHzkiJZ8CS9elbD4wT04-RNubATRHfP9LUScbfaDYwTx2YKaEn6sld8W9Ltrz4UOlCSNqFCKzMwstUHy930iNiNzuzRQHh6IyJ0qhAvjZNjcWR8jLjCmwWlP-SO9aiSl5llgjSQ\"]', '{\"multicast_id\":4967251927987609843,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576572784501000%c07a64c8c07a64c8\"}]}', '2019-12-17 03:53:04', NULL, NULL, NULL, 'Active'),
(57, 'Order Delivery', 'Delivery created for Eminent hotel at sarkhej with expected delivery on 17-12-2019 having order amount Rs. 2873.75 with Order Id 23', '[{\"user_id\":\"3\",\"device_id\":\"etrtZZzxixA:APA91bGGTtdOgu4NlMIBDmvCitfHCLS0bkUl2M4wfnSVUt07WcLsND9FnUp84ke2GQBIdtiXauscSdJdzx9zkdOK-x6s7zMtRMEE6KbJr9Q4Jski6v2LlX-fqopAp6VLRfhymzMjbZ_q\"}]', '[\"etrtZZzxixA:APA91bGGTtdOgu4NlMIBDmvCitfHCLS0bkUl2M4wfnSVUt07WcLsND9FnUp84ke2GQBIdtiXauscSdJdzx9zkdOK-x6s7zMtRMEE6KbJr9Q4Jski6v2LlX-fqopAp6VLRfhymzMjbZ_q\"]', '{\"multicast_id\":7714197298910142597,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576572784917404%c07a64c8c07a64c8\"}]}', '2019-12-17 03:53:04', NULL, NULL, NULL, 'Active'),
(58, 'Order Delivery', 'Delivery created for yuk at jkdkd with expected delivery on 17-12-2019 having order amount Rs. 7039.5 with Order Id 26', '[{\"user_id\":\"4\",\"device_id\":\"etrtZZzxixA:APA91bGGTtdOgu4NlMIBDmvCitfHCLS0bkUl2M4wfnSVUt07WcLsND9FnUp84ke2GQBIdtiXauscSdJdzx9zkdOK-x6s7zMtRMEE6KbJr9Q4Jski6v2LlX-fqopAp6VLRfhymzMjbZ_q\"}]', '[\"etrtZZzxixA:APA91bGGTtdOgu4NlMIBDmvCitfHCLS0bkUl2M4wfnSVUt07WcLsND9FnUp84ke2GQBIdtiXauscSdJdzx9zkdOK-x6s7zMtRMEE6KbJr9Q4Jski6v2LlX-fqopAp6VLRfhymzMjbZ_q\"]', '{\"multicast_id\":2309574409847468795,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576572921403942%c07a64c8c07a64c8\"}]}', '2019-12-17 03:55:21', NULL, NULL, NULL, 'Active'),
(59, 'Order Delivery', 'Delivery created for yuk at jkdkd with expected delivery on 17-12-2019 having order amount Rs. 7039.5 with Order Id 26', '[{\"user_id\":\"3\",\"device_id\":\"eNznWnbKAvo:APA91bHrjDxe9Y2eCTxmSMTznPJQx_PN6xQDaFtcuBaiqrDyQszlhujKEQXEvI0-D1PYClspJzdNpeqnlP18sfhnEyKHv3-09JEqtU3CCAAR00c7es2CZt3AM5z9ngOulZNCP6pTJ2C9\"}]', '[\"eNznWnbKAvo:APA91bHrjDxe9Y2eCTxmSMTznPJQx_PN6xQDaFtcuBaiqrDyQszlhujKEQXEvI0-D1PYClspJzdNpeqnlP18sfhnEyKHv3-09JEqtU3CCAAR00c7es2CZt3AM5z9ngOulZNCP6pTJ2C9\"]', '{\"multicast_id\":3782488231619890520,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576572921700356%c07a64c8c07a64c8\"}]}', '2019-12-17 03:55:21', NULL, NULL, NULL, 'Active'),
(64, 'Order Delivery', 'Delivery created for Reliance mart at mahalaxmi chaar rasta, paldi with expected delivery on 17-12-2019 having order amount Rs. 3940.6 with Order Id 29', '[{\"user_id\":\"3\",\"device_id\":\"dUbMuhY-IEQ:APA91bFsf0HuoWi77zrRa6CSV5MH8s3ZAWPrlXhWLFp4mRFVx2Klq3YYCf2PLoNZw4RchoHPb-sRdsHfdrbIAYgrNQo1DBSYLBz8b2nxWy4oRRW9nUxhZY-RuMDQxqvFWe2Y8reB-RD9\"}]', '[\"dUbMuhY-IEQ:APA91bFsf0HuoWi77zrRa6CSV5MH8s3ZAWPrlXhWLFp4mRFVx2Klq3YYCf2PLoNZw4RchoHPb-sRdsHfdrbIAYgrNQo1DBSYLBz8b2nxWy4oRRW9nUxhZY-RuMDQxqvFWe2Y8reB-RD9\"]', '{\"multicast_id\":5446527113028115002,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576575357448503%c07a64c8c07a64c8\"}]}', '2019-12-17 04:35:57', NULL, NULL, NULL, 'Active'),
(65, 'Order Delivery', 'Delivery created for Reliance mart at mahalaxmi chaar rasta, paldi with expected delivery on 17-12-2019 having order amount Rs. 3940.6 with Order Id 29', '[{\"user_id\":\"3\",\"device_id\":\"dUbMuhY-IEQ:APA91bFsf0HuoWi77zrRa6CSV5MH8s3ZAWPrlXhWLFp4mRFVx2Klq3YYCf2PLoNZw4RchoHPb-sRdsHfdrbIAYgrNQo1DBSYLBz8b2nxWy4oRRW9nUxhZY-RuMDQxqvFWe2Y8reB-RD9\"}]', '[\"dUbMuhY-IEQ:APA91bFsf0HuoWi77zrRa6CSV5MH8s3ZAWPrlXhWLFp4mRFVx2Klq3YYCf2PLoNZw4RchoHPb-sRdsHfdrbIAYgrNQo1DBSYLBz8b2nxWy4oRRW9nUxhZY-RuMDQxqvFWe2Y8reB-RD9\"]', '{\"multicast_id\":1596212381459161115,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576575542562128%c07a64c8c07a64c8\"}]}', '2019-12-17 04:39:02', NULL, NULL, NULL, 'Active'),
(66, 'Order Approval', 'Order NO. - 32 has been approved.', '[{\"user_id\":\"1\",\"device_id\":\"d-Xna5UbCQg:APA91bGLw_2jpqsvcIuPA03WA0Y5oq18V4-aqFwN_6FBUDmLuynK6MiFeAsGDnlmzuDTG37BokbDDKxFhCNkwOwnQ-CRVTmM1AlDhsmHKhuedLBKkj_XIDVRozrN494nwrh0JjLjFVnf\"}]', '[\"d-Xna5UbCQg:APA91bGLw_2jpqsvcIuPA03WA0Y5oq18V4-aqFwN_6FBUDmLuynK6MiFeAsGDnlmzuDTG37BokbDDKxFhCNkwOwnQ-CRVTmM1AlDhsmHKhuedLBKkj_XIDVRozrN494nwrh0JjLjFVnf\"]', '{\"multicast_id\":4092516476299442585,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576575548229107%c07a64c8c07a64c8\"}]}', '2019-12-17 04:39:08', NULL, NULL, NULL, 'Active'),
(67, 'Order Delivery', 'Delivery created for Reliance mart at mahalaxmi chaar rasta, paldi with expected delivery on 17-12-2019 having order amount Rs. 3940.6 with Order Id 29', '[{\"user_id\":\"3\",\"device_id\":\"dUbMuhY-IEQ:APA91bFsf0HuoWi77zrRa6CSV5MH8s3ZAWPrlXhWLFp4mRFVx2Klq3YYCf2PLoNZw4RchoHPb-sRdsHfdrbIAYgrNQo1DBSYLBz8b2nxWy4oRRW9nUxhZY-RuMDQxqvFWe2Y8reB-RD9\"}]', '[\"dUbMuhY-IEQ:APA91bFsf0HuoWi77zrRa6CSV5MH8s3ZAWPrlXhWLFp4mRFVx2Klq3YYCf2PLoNZw4RchoHPb-sRdsHfdrbIAYgrNQo1DBSYLBz8b2nxWy4oRRW9nUxhZY-RuMDQxqvFWe2Y8reB-RD9\"]', '{\"multicast_id\":409344172309386996,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576575589521954%c07a64c8c07a64c8\"}]}', '2019-12-17 04:39:49', NULL, NULL, NULL, 'Active'),
(68, 'Order Approval', 'Order NO. - 34 has been approved.', '[{\"user_id\":\"1\",\"device_id\":\"d-Xna5UbCQg:APA91bGLw_2jpqsvcIuPA03WA0Y5oq18V4-aqFwN_6FBUDmLuynK6MiFeAsGDnlmzuDTG37BokbDDKxFhCNkwOwnQ-CRVTmM1AlDhsmHKhuedLBKkj_XIDVRozrN494nwrh0JjLjFVnf\"}]', '[\"d-Xna5UbCQg:APA91bGLw_2jpqsvcIuPA03WA0Y5oq18V4-aqFwN_6FBUDmLuynK6MiFeAsGDnlmzuDTG37BokbDDKxFhCNkwOwnQ-CRVTmM1AlDhsmHKhuedLBKkj_XIDVRozrN494nwrh0JjLjFVnf\"]', '{\"multicast_id\":1414090404286169532,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576575615544069%c07a64c8c07a64c8\"}]}', '2019-12-17 04:40:15', NULL, NULL, NULL, 'Active'),
(69, 'Order Approval', 'Order NO. - 33 has been approved.', '[{\"user_id\":\"1\",\"device_id\":\"fSqWvzQIZfQ:APA91bEi9tk8aQVaV9HAOAMxinBSerN32X6e3X0_pATv9KAR9-R227uRd150NC5bQoJbxexFGQxNrkiCKIvfQdm1HGn-OADWP2HGOCK8_BYghd9H4Yft5KL4zxGKsEmXrUBk_h5B6c_9\"}]', '[\"fSqWvzQIZfQ:APA91bEi9tk8aQVaV9HAOAMxinBSerN32X6e3X0_pATv9KAR9-R227uRd150NC5bQoJbxexFGQxNrkiCKIvfQdm1HGn-OADWP2HGOCK8_BYghd9H4Yft5KL4zxGKsEmXrUBk_h5B6c_9\"]', '{\"multicast_id\":4696127266314602310,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576575818088928%c07a64c8c07a64c8\"}]}', '2019-12-17 04:43:38', NULL, NULL, NULL, 'Active'),
(70, 'Order Approval', 'Order NO. - 28 has been approved.', '[{\"user_id\":\"1\",\"device_id\":\"d-Xna5UbCQg:APA91bGLw_2jpqsvcIuPA03WA0Y5oq18V4-aqFwN_6FBUDmLuynK6MiFeAsGDnlmzuDTG37BokbDDKxFhCNkwOwnQ-CRVTmM1AlDhsmHKhuedLBKkj_XIDVRozrN494nwrh0JjLjFVnf\"}]', '[\"d-Xna5UbCQg:APA91bGLw_2jpqsvcIuPA03WA0Y5oq18V4-aqFwN_6FBUDmLuynK6MiFeAsGDnlmzuDTG37BokbDDKxFhCNkwOwnQ-CRVTmM1AlDhsmHKhuedLBKkj_XIDVRozrN494nwrh0JjLjFVnf\"]', '{\"multicast_id\":3211902199734188140,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576575906382372%c07a64c8c07a64c8\"}]}', '2019-12-17 04:45:06', NULL, NULL, NULL, 'Active'),
(71, 'Order Delivery', 'Delivery created for Khanjan testing at F/5 Chandrika Appartment with expected delivery on 17-12-2019 having order amount Rs. 2222.05 with Order Id 28', '[{\"user_id\":\"4\",\"device_id\":\"d-Xna5UbCQg:APA91bGLw_2jpqsvcIuPA03WA0Y5oq18V4-aqFwN_6FBUDmLuynK6MiFeAsGDnlmzuDTG37BokbDDKxFhCNkwOwnQ-CRVTmM1AlDhsmHKhuedLBKkj_XIDVRozrN494nwrh0JjLjFVnf\"}]', '[\"d-Xna5UbCQg:APA91bGLw_2jpqsvcIuPA03WA0Y5oq18V4-aqFwN_6FBUDmLuynK6MiFeAsGDnlmzuDTG37BokbDDKxFhCNkwOwnQ-CRVTmM1AlDhsmHKhuedLBKkj_XIDVRozrN494nwrh0JjLjFVnf\"]', '{\"multicast_id\":3219511231265175671,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576575979407248%c07a64c8c07a64c8\"}]}', '2019-12-17 04:46:19', NULL, NULL, NULL, 'Active'),
(72, 'Order Delivery', 'Delivery created for Khanjan testing at F/5 Chandrika Appartment with expected delivery on 17-12-2019 having order amount Rs. 2222.05 with Order Id 28', '[{\"user_id\":\"3\",\"device_id\":\"dUbMuhY-IEQ:APA91bFsf0HuoWi77zrRa6CSV5MH8s3ZAWPrlXhWLFp4mRFVx2Klq3YYCf2PLoNZw4RchoHPb-sRdsHfdrbIAYgrNQo1DBSYLBz8b2nxWy4oRRW9nUxhZY-RuMDQxqvFWe2Y8reB-RD9\"}]', '[\"dUbMuhY-IEQ:APA91bFsf0HuoWi77zrRa6CSV5MH8s3ZAWPrlXhWLFp4mRFVx2Klq3YYCf2PLoNZw4RchoHPb-sRdsHfdrbIAYgrNQo1DBSYLBz8b2nxWy4oRRW9nUxhZY-RuMDQxqvFWe2Y8reB-RD9\"]', '{\"multicast_id\":8170554418123931594,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576575979717719%c07a64c8c07a64c8\"}]}', '2019-12-17 04:46:19', NULL, NULL, NULL, 'Active'),
(73, 'Order Delivery', 'Delivery created for Queenland cafe at Jamalpur with expected delivery on 17-12-2019 having order amount Rs. 1648.25 with Order Id 32', '[{\"user_id\":\"4\",\"device_id\":\"d-Xna5UbCQg:APA91bGLw_2jpqsvcIuPA03WA0Y5oq18V4-aqFwN_6FBUDmLuynK6MiFeAsGDnlmzuDTG37BokbDDKxFhCNkwOwnQ-CRVTmM1AlDhsmHKhuedLBKkj_XIDVRozrN494nwrh0JjLjFVnf\"}]', '[\"d-Xna5UbCQg:APA91bGLw_2jpqsvcIuPA03WA0Y5oq18V4-aqFwN_6FBUDmLuynK6MiFeAsGDnlmzuDTG37BokbDDKxFhCNkwOwnQ-CRVTmM1AlDhsmHKhuedLBKkj_XIDVRozrN494nwrh0JjLjFVnf\"]', '{\"multicast_id\":6204026516584210013,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576576017116508%c07a64c8c07a64c8\"}]}', '2019-12-17 04:46:57', NULL, NULL, NULL, 'Active'),
(74, 'Order Delivery', 'Delivery created for Queenland cafe at Jamalpur with expected delivery on 17-12-2019 having order amount Rs. 1648.25 with Order Id 32', '[{\"user_id\":\"3\",\"device_id\":\"dUbMuhY-IEQ:APA91bFsf0HuoWi77zrRa6CSV5MH8s3ZAWPrlXhWLFp4mRFVx2Klq3YYCf2PLoNZw4RchoHPb-sRdsHfdrbIAYgrNQo1DBSYLBz8b2nxWy4oRRW9nUxhZY-RuMDQxqvFWe2Y8reB-RD9\"}]', '[\"dUbMuhY-IEQ:APA91bFsf0HuoWi77zrRa6CSV5MH8s3ZAWPrlXhWLFp4mRFVx2Klq3YYCf2PLoNZw4RchoHPb-sRdsHfdrbIAYgrNQo1DBSYLBz8b2nxWy4oRRW9nUxhZY-RuMDQxqvFWe2Y8reB-RD9\"]', '{\"multicast_id\":81863878939139822,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576576017431101%c07a64c8c07a64c8\"}]}', '2019-12-17 04:46:57', NULL, NULL, NULL, 'Active'),
(75, 'Order Delivery', 'Delivery created for natural ice-cream at mithakhali with expected delivery on 17-12-2019 having order amount Rs. 4564.75 with Order Id 33', '[{\"user_id\":\"4\",\"device_id\":\"d-Xna5UbCQg:APA91bGLw_2jpqsvcIuPA03WA0Y5oq18V4-aqFwN_6FBUDmLuynK6MiFeAsGDnlmzuDTG37BokbDDKxFhCNkwOwnQ-CRVTmM1AlDhsmHKhuedLBKkj_XIDVRozrN494nwrh0JjLjFVnf\"}]', '[\"d-Xna5UbCQg:APA91bGLw_2jpqsvcIuPA03WA0Y5oq18V4-aqFwN_6FBUDmLuynK6MiFeAsGDnlmzuDTG37BokbDDKxFhCNkwOwnQ-CRVTmM1AlDhsmHKhuedLBKkj_XIDVRozrN494nwrh0JjLjFVnf\"]', '{\"multicast_id\":7764811187092065838,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576577089500396%c07a64c8c07a64c8\"}]}', '2019-12-17 05:04:49', NULL, NULL, NULL, 'Active'),
(76, 'Order Delivery', 'Delivery created for natural ice-cream at mithakhali with expected delivery on 17-12-2019 having order amount Rs. 4564.75 with Order Id 33', '[{\"user_id\":\"3\",\"device_id\":\"dUbMuhY-IEQ:APA91bFsf0HuoWi77zrRa6CSV5MH8s3ZAWPrlXhWLFp4mRFVx2Klq3YYCf2PLoNZw4RchoHPb-sRdsHfdrbIAYgrNQo1DBSYLBz8b2nxWy4oRRW9nUxhZY-RuMDQxqvFWe2Y8reB-RD9\"}]', '[\"dUbMuhY-IEQ:APA91bFsf0HuoWi77zrRa6CSV5MH8s3ZAWPrlXhWLFp4mRFVx2Klq3YYCf2PLoNZw4RchoHPb-sRdsHfdrbIAYgrNQo1DBSYLBz8b2nxWy4oRRW9nUxhZY-RuMDQxqvFWe2Y8reB-RD9\"]', '{\"multicast_id\":5030595469084856848,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576577089845388%c07a64c8c07a64c8\"}]}', '2019-12-17 05:04:49', NULL, NULL, NULL, 'Active'),
(77, 'Order Delivery', 'Delivery created for natural ice-cream at mithakhali with expected delivery on 17-12-2019 having order amount Rs. 4564.75 with Order Id 33', '[{\"user_id\":\"4\",\"device_id\":\"d-Xna5UbCQg:APA91bGLw_2jpqsvcIuPA03WA0Y5oq18V4-aqFwN_6FBUDmLuynK6MiFeAsGDnlmzuDTG37BokbDDKxFhCNkwOwnQ-CRVTmM1AlDhsmHKhuedLBKkj_XIDVRozrN494nwrh0JjLjFVnf\"}]', '[\"d-Xna5UbCQg:APA91bGLw_2jpqsvcIuPA03WA0Y5oq18V4-aqFwN_6FBUDmLuynK6MiFeAsGDnlmzuDTG37BokbDDKxFhCNkwOwnQ-CRVTmM1AlDhsmHKhuedLBKkj_XIDVRozrN494nwrh0JjLjFVnf\"]', '{\"multicast_id\":8049424287297431049,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576577127120054%c07a64c8c07a64c8\"}]}', '2019-12-17 05:05:27', NULL, NULL, NULL, 'Active'),
(78, 'Order Delivery', 'Delivery created for natural ice-cream at mithakhali with expected delivery on 17-12-2019 having order amount Rs. 4564.75 with Order Id 33', '[{\"user_id\":\"3\",\"device_id\":\"edk3k4lp0uA:APA91bGQEie1RJ68RKH0e_OEEZeQtpsIMbCzEmCJBPycFx91GzxFM2ayhH6abHZClKYrBA2zoLRbzTxlQQSgAHVtLr5DkjpRc05ZNjTQG1ku49PcidaKvFypIykMGd_Z6DgdnjTLCxK3\"}]', '[\"edk3k4lp0uA:APA91bGQEie1RJ68RKH0e_OEEZeQtpsIMbCzEmCJBPycFx91GzxFM2ayhH6abHZClKYrBA2zoLRbzTxlQQSgAHVtLr5DkjpRc05ZNjTQG1ku49PcidaKvFypIykMGd_Z6DgdnjTLCxK3\"]', '{\"multicast_id\":7351178217003609802,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576577127435873%c07a64c8c07a64c8\"}]}', '2019-12-17 05:05:27', NULL, NULL, NULL, 'Active'),
(79, 'Order Delivery', 'Delivery updated for natural ice-cream at mithakhali with expected delivery on 17-12-2019 having order amount Rs. 4564.75 with Order Id 33', '[{\"user_id\":\"4\",\"device_id\":\"d-Xna5UbCQg:APA91bGLw_2jpqsvcIuPA03WA0Y5oq18V4-aqFwN_6FBUDmLuynK6MiFeAsGDnlmzuDTG37BokbDDKxFhCNkwOwnQ-CRVTmM1AlDhsmHKhuedLBKkj_XIDVRozrN494nwrh0JjLjFVnf\"}]', '[\"d-Xna5UbCQg:APA91bGLw_2jpqsvcIuPA03WA0Y5oq18V4-aqFwN_6FBUDmLuynK6MiFeAsGDnlmzuDTG37BokbDDKxFhCNkwOwnQ-CRVTmM1AlDhsmHKhuedLBKkj_XIDVRozrN494nwrh0JjLjFVnf\"]', '{\"multicast_id\":3458791975197765424,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576577147260949%c07a64c8c07a64c8\"}]}', '2019-12-17 05:05:47', NULL, NULL, NULL, 'Active'),
(80, 'Order Delivery', 'Delivery updated for natural ice-cream at mithakhali with expected delivery on 17-12-2019 having order amount Rs. 4564.75 with Order Id 33', '[{\"user_id\":\"3\",\"device_id\":\"edk3k4lp0uA:APA91bGQEie1RJ68RKH0e_OEEZeQtpsIMbCzEmCJBPycFx91GzxFM2ayhH6abHZClKYrBA2zoLRbzTxlQQSgAHVtLr5DkjpRc05ZNjTQG1ku49PcidaKvFypIykMGd_Z6DgdnjTLCxK3\"}]', '[\"edk3k4lp0uA:APA91bGQEie1RJ68RKH0e_OEEZeQtpsIMbCzEmCJBPycFx91GzxFM2ayhH6abHZClKYrBA2zoLRbzTxlQQSgAHVtLr5DkjpRc05ZNjTQG1ku49PcidaKvFypIykMGd_Z6DgdnjTLCxK3\"]', '{\"multicast_id\":3913200353535592030,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576577147582432%c07a64c8c07a64c8\"}]}', '2019-12-17 05:05:47', NULL, NULL, NULL, 'Active'),
(81, 'Order Delivery', 'Delivery created for natural ice-cream at mithakhali with expected delivery on 17-12-2019 having order amount Rs. 4564.75 with Order Id 33', '[{\"user_id\":\"4\",\"device_id\":\"d-Xna5UbCQg:APA91bGLw_2jpqsvcIuPA03WA0Y5oq18V4-aqFwN_6FBUDmLuynK6MiFeAsGDnlmzuDTG37BokbDDKxFhCNkwOwnQ-CRVTmM1AlDhsmHKhuedLBKkj_XIDVRozrN494nwrh0JjLjFVnf\"}]', '[\"d-Xna5UbCQg:APA91bGLw_2jpqsvcIuPA03WA0Y5oq18V4-aqFwN_6FBUDmLuynK6MiFeAsGDnlmzuDTG37BokbDDKxFhCNkwOwnQ-CRVTmM1AlDhsmHKhuedLBKkj_XIDVRozrN494nwrh0JjLjFVnf\"]', '{\"multicast_id\":6277748533064446551,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576577206346826%c07a64c8c07a64c8\"}]}', '2019-12-17 05:06:46', NULL, NULL, NULL, 'Active'),
(82, 'Order Delivery', 'Delivery updated for natural ice-cream at mithakhali with expected delivery on 17-12-2019 having order amount Rs. 4564.75 with Order Id 33', '[{\"user_id\":\"4\",\"device_id\":\"d-Xna5UbCQg:APA91bGLw_2jpqsvcIuPA03WA0Y5oq18V4-aqFwN_6FBUDmLuynK6MiFeAsGDnlmzuDTG37BokbDDKxFhCNkwOwnQ-CRVTmM1AlDhsmHKhuedLBKkj_XIDVRozrN494nwrh0JjLjFVnf\"}]', '[\"d-Xna5UbCQg:APA91bGLw_2jpqsvcIuPA03WA0Y5oq18V4-aqFwN_6FBUDmLuynK6MiFeAsGDnlmzuDTG37BokbDDKxFhCNkwOwnQ-CRVTmM1AlDhsmHKhuedLBKkj_XIDVRozrN494nwrh0JjLjFVnf\"]', '{\"multicast_id\":1042553697338360744,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576577223293218%c07a64c8c07a64c8\"}]}', '2019-12-17 05:07:03', NULL, NULL, NULL, 'Active'),
(83, 'Order Delivery', 'Delivery created for natural ice-cream at mithakhali with expected delivery on 17-12-2019 having order amount Rs. 4564.75 with Order Id 33', '[{\"user_id\":\"4\",\"device_id\":\"dUbMuhY-IEQ:APA91bFsf0HuoWi77zrRa6CSV5MH8s3ZAWPrlXhWLFp4mRFVx2Klq3YYCf2PLoNZw4RchoHPb-sRdsHfdrbIAYgrNQo1DBSYLBz8b2nxWy4oRRW9nUxhZY-RuMDQxqvFWe2Y8reB-RD9\"}]', '[\"dUbMuhY-IEQ:APA91bFsf0HuoWi77zrRa6CSV5MH8s3ZAWPrlXhWLFp4mRFVx2Klq3YYCf2PLoNZw4RchoHPb-sRdsHfdrbIAYgrNQo1DBSYLBz8b2nxWy4oRRW9nUxhZY-RuMDQxqvFWe2Y8reB-RD9\"]', '{\"multicast_id\":2369789002460679597,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576577504863111%c07a64c8c07a64c8\"}]}', '2019-12-17 05:11:44', NULL, NULL, NULL, 'Active'),
(84, 'Order Delivery', 'Delivery created for natural ice-cream at mithakhali with expected delivery on 17-12-2019 having order amount Rs. 4564.75 with Order Id 33', '[{\"user_id\":\"3\",\"device_id\":\"fSqWvzQIZfQ:APA91bEi9tk8aQVaV9HAOAMxinBSerN32X6e3X0_pATv9KAR9-R227uRd150NC5bQoJbxexFGQxNrkiCKIvfQdm1HGn-OADWP2HGOCK8_BYghd9H4Yft5KL4zxGKsEmXrUBk_h5B6c_9\"}]', '[\"fSqWvzQIZfQ:APA91bEi9tk8aQVaV9HAOAMxinBSerN32X6e3X0_pATv9KAR9-R227uRd150NC5bQoJbxexFGQxNrkiCKIvfQdm1HGn-OADWP2HGOCK8_BYghd9H4Yft5KL4zxGKsEmXrUBk_h5B6c_9\"]', '{\"multicast_id\":1836009613666714645,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576577505047357%c07a64c8c07a64c8\"}]}', '2019-12-17 05:11:45', NULL, NULL, NULL, 'Active'),
(85, 'Order Delivery', 'Delivery created for natural ice-cream at mithakhali with expected delivery on 17-12-2019 having order amount Rs. 4564.75 with Order Id 33', '[{\"user_id\":\"4\",\"device_id\":\"dUbMuhY-IEQ:APA91bFsf0HuoWi77zrRa6CSV5MH8s3ZAWPrlXhWLFp4mRFVx2Klq3YYCf2PLoNZw4RchoHPb-sRdsHfdrbIAYgrNQo1DBSYLBz8b2nxWy4oRRW9nUxhZY-RuMDQxqvFWe2Y8reB-RD9\"}]', '[\"dUbMuhY-IEQ:APA91bFsf0HuoWi77zrRa6CSV5MH8s3ZAWPrlXhWLFp4mRFVx2Klq3YYCf2PLoNZw4RchoHPb-sRdsHfdrbIAYgrNQo1DBSYLBz8b2nxWy4oRRW9nUxhZY-RuMDQxqvFWe2Y8reB-RD9\"]', '{\"multicast_id\":8157377779803625859,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576577536262088%c07a64c8c07a64c8\"}]}', '2019-12-17 05:12:16', NULL, NULL, NULL, 'Active'),
(86, 'Order Delivery', 'Delivery created for natural ice-cream at mithakhali with expected delivery on 17-12-2019 having order amount Rs. 4564.75 with Order Id 33', '[{\"user_id\":\"4\",\"device_id\":\"dUbMuhY-IEQ:APA91bFsf0HuoWi77zrRa6CSV5MH8s3ZAWPrlXhWLFp4mRFVx2Klq3YYCf2PLoNZw4RchoHPb-sRdsHfdrbIAYgrNQo1DBSYLBz8b2nxWy4oRRW9nUxhZY-RuMDQxqvFWe2Y8reB-RD9\"}]', '[\"dUbMuhY-IEQ:APA91bFsf0HuoWi77zrRa6CSV5MH8s3ZAWPrlXhWLFp4mRFVx2Klq3YYCf2PLoNZw4RchoHPb-sRdsHfdrbIAYgrNQo1DBSYLBz8b2nxWy4oRRW9nUxhZY-RuMDQxqvFWe2Y8reB-RD9\"]', '{\"multicast_id\":3011784469560207334,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576577553302856%c07a64c8c07a64c8\"}]}', '2019-12-17 05:12:33', NULL, NULL, NULL, 'Active'),
(87, 'Order Delivery', 'Delivery created for natural ice-cream at mithakhali with expected delivery on 17-12-2019 having order amount Rs. 4564.75 with Order Id 33', '[{\"user_id\":\"4\",\"device_id\":\"dUbMuhY-IEQ:APA91bFsf0HuoWi77zrRa6CSV5MH8s3ZAWPrlXhWLFp4mRFVx2Klq3YYCf2PLoNZw4RchoHPb-sRdsHfdrbIAYgrNQo1DBSYLBz8b2nxWy4oRRW9nUxhZY-RuMDQxqvFWe2Y8reB-RD9\"}]', '[\"dUbMuhY-IEQ:APA91bFsf0HuoWi77zrRa6CSV5MH8s3ZAWPrlXhWLFp4mRFVx2Klq3YYCf2PLoNZw4RchoHPb-sRdsHfdrbIAYgrNQo1DBSYLBz8b2nxWy4oRRW9nUxhZY-RuMDQxqvFWe2Y8reB-RD9\"]', '{\"multicast_id\":1026356309771779467,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576577575358268%c07a64c8c07a64c8\"}]}', '2019-12-17 05:12:55', NULL, NULL, NULL, 'Active'),
(88, 'Order Delivery', 'Delivery created for Queenland cafe at Jamalpur with expected delivery on 17-12-2019 having order amount Rs. 1648.25 with Order Id 32', '[{\"user_id\":\"4\",\"device_id\":\"dUbMuhY-IEQ:APA91bFsf0HuoWi77zrRa6CSV5MH8s3ZAWPrlXhWLFp4mRFVx2Klq3YYCf2PLoNZw4RchoHPb-sRdsHfdrbIAYgrNQo1DBSYLBz8b2nxWy4oRRW9nUxhZY-RuMDQxqvFWe2Y8reB-RD9\"}]', '[\"dUbMuhY-IEQ:APA91bFsf0HuoWi77zrRa6CSV5MH8s3ZAWPrlXhWLFp4mRFVx2Klq3YYCf2PLoNZw4RchoHPb-sRdsHfdrbIAYgrNQo1DBSYLBz8b2nxWy4oRRW9nUxhZY-RuMDQxqvFWe2Y8reB-RD9\"]', '{\"multicast_id\":7423934639167620665,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576577751853862%c07a64c8c07a64c8\"}]}', '2019-12-17 05:15:51', NULL, NULL, NULL, 'Active'),
(89, 'Order Delivery', 'Delivery updated for Queenland cafe at Jamalpur with expected delivery on 17-12-2019 having order amount Rs. 1648.25 with Order Id 32', '[{\"user_id\":\"4\",\"device_id\":\"dUbMuhY-IEQ:APA91bFsf0HuoWi77zrRa6CSV5MH8s3ZAWPrlXhWLFp4mRFVx2Klq3YYCf2PLoNZw4RchoHPb-sRdsHfdrbIAYgrNQo1DBSYLBz8b2nxWy4oRRW9nUxhZY-RuMDQxqvFWe2Y8reB-RD9\"}]', '[\"dUbMuhY-IEQ:APA91bFsf0HuoWi77zrRa6CSV5MH8s3ZAWPrlXhWLFp4mRFVx2Klq3YYCf2PLoNZw4RchoHPb-sRdsHfdrbIAYgrNQo1DBSYLBz8b2nxWy4oRRW9nUxhZY-RuMDQxqvFWe2Y8reB-RD9\"]', '{\"multicast_id\":3570727342592098796,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576577765661944%c07a64c8c07a64c8\"}]}', '2019-12-17 05:16:05', NULL, NULL, NULL, 'Active'),
(90, 'Order Delivery', 'Delivery updated for Queenland cafe at Jamalpur with expected delivery on 17-12-2019 having order amount Rs. 1648.25 with Order Id 32', '[{\"user_id\":\"4\",\"device_id\":\"dUbMuhY-IEQ:APA91bFsf0HuoWi77zrRa6CSV5MH8s3ZAWPrlXhWLFp4mRFVx2Klq3YYCf2PLoNZw4RchoHPb-sRdsHfdrbIAYgrNQo1DBSYLBz8b2nxWy4oRRW9nUxhZY-RuMDQxqvFWe2Y8reB-RD9\"}]', '[\"dUbMuhY-IEQ:APA91bFsf0HuoWi77zrRa6CSV5MH8s3ZAWPrlXhWLFp4mRFVx2Klq3YYCf2PLoNZw4RchoHPb-sRdsHfdrbIAYgrNQo1DBSYLBz8b2nxWy4oRRW9nUxhZY-RuMDQxqvFWe2Y8reB-RD9\"]', '{\"multicast_id\":1833785507791507671,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576577776390862%c07a64c8c07a64c8\"}]}', '2019-12-17 05:16:16', NULL, NULL, NULL, 'Active'),
(91, 'Order Delivery', 'Delivery updated for Queenland cafe at Jamalpur with expected delivery on 17-12-2019 having order amount Rs. 1648.25 with Order Id 32', '[{\"user_id\":\"4\",\"device_id\":\"dUbMuhY-IEQ:APA91bFsf0HuoWi77zrRa6CSV5MH8s3ZAWPrlXhWLFp4mRFVx2Klq3YYCf2PLoNZw4RchoHPb-sRdsHfdrbIAYgrNQo1DBSYLBz8b2nxWy4oRRW9nUxhZY-RuMDQxqvFWe2Y8reB-RD9\"}]', '[\"dUbMuhY-IEQ:APA91bFsf0HuoWi77zrRa6CSV5MH8s3ZAWPrlXhWLFp4mRFVx2Klq3YYCf2PLoNZw4RchoHPb-sRdsHfdrbIAYgrNQo1DBSYLBz8b2nxWy4oRRW9nUxhZY-RuMDQxqvFWe2Y8reB-RD9\"]', '{\"multicast_id\":6210862950353726854,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576577792525339%c07a64c8c07a64c8\"}]}', '2019-12-17 05:16:32', NULL, NULL, NULL, 'Active'),
(92, 'Order Delivery', 'Delivery created for Queenland cafe at Jamalpur with expected delivery on 17-12-2019 having order amount Rs. 1648.25 with Order Id 32', '[{\"user_id\":\"4\",\"device_id\":\"dUbMuhY-IEQ:APA91bFsf0HuoWi77zrRa6CSV5MH8s3ZAWPrlXhWLFp4mRFVx2Klq3YYCf2PLoNZw4RchoHPb-sRdsHfdrbIAYgrNQo1DBSYLBz8b2nxWy4oRRW9nUxhZY-RuMDQxqvFWe2Y8reB-RD9\"}]', '[\"dUbMuhY-IEQ:APA91bFsf0HuoWi77zrRa6CSV5MH8s3ZAWPrlXhWLFp4mRFVx2Klq3YYCf2PLoNZw4RchoHPb-sRdsHfdrbIAYgrNQo1DBSYLBz8b2nxWy4oRRW9nUxhZY-RuMDQxqvFWe2Y8reB-RD9\"]', '{\"multicast_id\":7641007573261056779,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576578087006932%c07a64c8c07a64c8\"}]}', '2019-12-17 05:21:27', NULL, NULL, NULL, 'Active'),
(93, 'Order Delivery', 'Delivery created for Queenland cafe at Jamalpur with expected delivery on 17-12-2019 having order amount Rs. 1648.25 with Order Id 32', '[{\"user_id\":\"4\",\"device_id\":\"dUbMuhY-IEQ:APA91bFsf0HuoWi77zrRa6CSV5MH8s3ZAWPrlXhWLFp4mRFVx2Klq3YYCf2PLoNZw4RchoHPb-sRdsHfdrbIAYgrNQo1DBSYLBz8b2nxWy4oRRW9nUxhZY-RuMDQxqvFWe2Y8reB-RD9\"}]', '[\"dUbMuhY-IEQ:APA91bFsf0HuoWi77zrRa6CSV5MH8s3ZAWPrlXhWLFp4mRFVx2Klq3YYCf2PLoNZw4RchoHPb-sRdsHfdrbIAYgrNQo1DBSYLBz8b2nxWy4oRRW9nUxhZY-RuMDQxqvFWe2Y8reB-RD9\"]', '{\"multicast_id\":7984810572810923118,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576578172397123%c07a64c8c07a64c8\"}]}', '2019-12-17 05:22:52', NULL, NULL, NULL, 'Active'),
(94, 'Order Delivery', 'Delivery updated for Queenland cafe at Jamalpur with expected delivery on 17-12-2019 having order amount Rs. 1648.25 with Order Id 32', '[{\"user_id\":\"4\",\"device_id\":\"dUbMuhY-IEQ:APA91bFsf0HuoWi77zrRa6CSV5MH8s3ZAWPrlXhWLFp4mRFVx2Klq3YYCf2PLoNZw4RchoHPb-sRdsHfdrbIAYgrNQo1DBSYLBz8b2nxWy4oRRW9nUxhZY-RuMDQxqvFWe2Y8reB-RD9\"}]', '[\"dUbMuhY-IEQ:APA91bFsf0HuoWi77zrRa6CSV5MH8s3ZAWPrlXhWLFp4mRFVx2Klq3YYCf2PLoNZw4RchoHPb-sRdsHfdrbIAYgrNQo1DBSYLBz8b2nxWy4oRRW9nUxhZY-RuMDQxqvFWe2Y8reB-RD9\"]', '{\"multicast_id\":2961827600220376980,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576578181445637%c07a64c8c07a64c8\"}]}', '2019-12-17 05:23:01', NULL, NULL, NULL, 'Active'),
(95, 'Order Delivery', 'Delivery updated for Queenland cafe at Jamalpur with expected delivery on 17-12-2019 having order amount Rs. 1648.25 with Order Id 32', '[{\"user_id\":\"4\",\"device_id\":\"dUbMuhY-IEQ:APA91bFsf0HuoWi77zrRa6CSV5MH8s3ZAWPrlXhWLFp4mRFVx2Klq3YYCf2PLoNZw4RchoHPb-sRdsHfdrbIAYgrNQo1DBSYLBz8b2nxWy4oRRW9nUxhZY-RuMDQxqvFWe2Y8reB-RD9\"}]', '[\"dUbMuhY-IEQ:APA91bFsf0HuoWi77zrRa6CSV5MH8s3ZAWPrlXhWLFp4mRFVx2Klq3YYCf2PLoNZw4RchoHPb-sRdsHfdrbIAYgrNQo1DBSYLBz8b2nxWy4oRRW9nUxhZY-RuMDQxqvFWe2Y8reB-RD9\"]', '{\"multicast_id\":593988792603239436,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576578195231126%c07a64c8c07a64c8\"}]}', '2019-12-17 05:23:15', NULL, NULL, NULL, 'Active'),
(96, 'Order Delivery', 'Delivery updated for Queenland cafe at Jamalpur with expected delivery on 17-12-2019 having order amount Rs. 1648.25 with Order Id 32', '[{\"user_id\":\"4\",\"device_id\":\"dUbMuhY-IEQ:APA91bFsf0HuoWi77zrRa6CSV5MH8s3ZAWPrlXhWLFp4mRFVx2Klq3YYCf2PLoNZw4RchoHPb-sRdsHfdrbIAYgrNQo1DBSYLBz8b2nxWy4oRRW9nUxhZY-RuMDQxqvFWe2Y8reB-RD9\"}]', '[\"dUbMuhY-IEQ:APA91bFsf0HuoWi77zrRa6CSV5MH8s3ZAWPrlXhWLFp4mRFVx2Klq3YYCf2PLoNZw4RchoHPb-sRdsHfdrbIAYgrNQo1DBSYLBz8b2nxWy4oRRW9nUxhZY-RuMDQxqvFWe2Y8reB-RD9\"]', '{\"multicast_id\":3719723994386465679,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576578206691702%c07a64c8c07a64c8\"}]}', '2019-12-17 05:23:26', NULL, NULL, NULL, 'Active'),
(97, 'Order Delivery', 'Delivery updated for Queenland cafe at Jamalpur with expected delivery on 17-12-2019 having order amount Rs. 1648.25 with Order Id 32', '[{\"user_id\":\"4\",\"device_id\":\"dUbMuhY-IEQ:APA91bFsf0HuoWi77zrRa6CSV5MH8s3ZAWPrlXhWLFp4mRFVx2Klq3YYCf2PLoNZw4RchoHPb-sRdsHfdrbIAYgrNQo1DBSYLBz8b2nxWy4oRRW9nUxhZY-RuMDQxqvFWe2Y8reB-RD9\"}]', '[\"dUbMuhY-IEQ:APA91bFsf0HuoWi77zrRa6CSV5MH8s3ZAWPrlXhWLFp4mRFVx2Klq3YYCf2PLoNZw4RchoHPb-sRdsHfdrbIAYgrNQo1DBSYLBz8b2nxWy4oRRW9nUxhZY-RuMDQxqvFWe2Y8reB-RD9\"]', '{\"multicast_id\":9000795366777045637,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576578207463982%c07a64c8c07a64c8\"}]}', '2019-12-17 05:23:27', NULL, NULL, NULL, 'Active'),
(98, 'Order Delivery', 'Delivery created for Queenland cafe at Jamalpur with expected delivery on 17-12-2019 having order amount Rs. 1648.25 with Order Id 32', '[{\"user_id\":\"4\",\"device_id\":\"dUbMuhY-IEQ:APA91bFsf0HuoWi77zrRa6CSV5MH8s3ZAWPrlXhWLFp4mRFVx2Klq3YYCf2PLoNZw4RchoHPb-sRdsHfdrbIAYgrNQo1DBSYLBz8b2nxWy4oRRW9nUxhZY-RuMDQxqvFWe2Y8reB-RD9\"}]', '[\"dUbMuhY-IEQ:APA91bFsf0HuoWi77zrRa6CSV5MH8s3ZAWPrlXhWLFp4mRFVx2Klq3YYCf2PLoNZw4RchoHPb-sRdsHfdrbIAYgrNQo1DBSYLBz8b2nxWy4oRRW9nUxhZY-RuMDQxqvFWe2Y8reB-RD9\"]', '{\"multicast_id\":2945083808920875994,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576578561057897%c07a64c8c07a64c8\"}]}', '2019-12-17 05:29:21', NULL, NULL, NULL, 'Active'),
(99, 'Order Delivery', 'Delivery updated for Queenland cafe at Jamalpur with expected delivery on 17-12-2019 having order amount Rs. 1648.25 with Order Id 32', '[{\"user_id\":\"4\",\"device_id\":\"dUbMuhY-IEQ:APA91bFsf0HuoWi77zrRa6CSV5MH8s3ZAWPrlXhWLFp4mRFVx2Klq3YYCf2PLoNZw4RchoHPb-sRdsHfdrbIAYgrNQo1DBSYLBz8b2nxWy4oRRW9nUxhZY-RuMDQxqvFWe2Y8reB-RD9\"}]', '[\"dUbMuhY-IEQ:APA91bFsf0HuoWi77zrRa6CSV5MH8s3ZAWPrlXhWLFp4mRFVx2Klq3YYCf2PLoNZw4RchoHPb-sRdsHfdrbIAYgrNQo1DBSYLBz8b2nxWy4oRRW9nUxhZY-RuMDQxqvFWe2Y8reB-RD9\"]', '{\"multicast_id\":3439098055250546594,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576578571502858%c07a64c8c07a64c8\"}]}', '2019-12-17 05:29:31', NULL, NULL, NULL, 'Active'),
(100, 'Order Delivery', 'Delivery updated for Queenland cafe at Jamalpur with expected delivery on 17-12-2019 having order amount Rs. 1648.25 with Order Id 32', '[{\"user_id\":\"4\",\"device_id\":\"dUbMuhY-IEQ:APA91bFsf0HuoWi77zrRa6CSV5MH8s3ZAWPrlXhWLFp4mRFVx2Klq3YYCf2PLoNZw4RchoHPb-sRdsHfdrbIAYgrNQo1DBSYLBz8b2nxWy4oRRW9nUxhZY-RuMDQxqvFWe2Y8reB-RD9\"}]', '[\"dUbMuhY-IEQ:APA91bFsf0HuoWi77zrRa6CSV5MH8s3ZAWPrlXhWLFp4mRFVx2Klq3YYCf2PLoNZw4RchoHPb-sRdsHfdrbIAYgrNQo1DBSYLBz8b2nxWy4oRRW9nUxhZY-RuMDQxqvFWe2Y8reB-RD9\"]', '{\"multicast_id\":2243993442346575731,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1576578589385735%c07a64c8c07a64c8\"}]}', '2019-12-17 05:29:49', NULL, NULL, NULL, 'Active'),
(101, 'Order Approval', 'Order NO. - 38 has been approved.', '[{\"user_id\":\"1\",\"device_id\":\"edk3k4lp0uA:APA91bGQEie1RJ68RKH0e_OEEZeQtpsIMbCzEmCJBPycFx91GzxFM2ayhH6abHZClKYrBA2zoLRbzTxlQQSgAHVtLr5DkjpRc05ZNjTQG1ku49PcidaKvFypIykMGd_Z6DgdnjTLCxK3\"}]', '[\"edk3k4lp0uA:APA91bGQEie1RJ68RKH0e_OEEZeQtpsIMbCzEmCJBPycFx91GzxFM2ayhH6abHZClKYrBA2zoLRbzTxlQQSgAHVtLr5DkjpRc05ZNjTQG1ku49PcidaKvFypIykMGd_Z6DgdnjTLCxK3\"]', 'Field \"to\" must be a JSON string: [\"edk3k4lp0uA:APA91bGQEie1RJ68RKH0e_OEEZeQtpsIMbCzEmCJBPycFx91GzxFM2ayhH6abHZClKYrBA2zoLRbzTxlQQSgAHVtLr5DkjpRc05ZNjTQG1ku49PcidaKvFypIykMGd_Z6DgdnjTLCxK3\"]\n', '2019-12-17 06:29:06', NULL, NULL, NULL, 'Active'),
(102, 'Order Delivery', 'Delivery created for Khanjan final testing at f/5 with expected delivery on 17-12-2019 having order amount Rs. 9500 with Order Id 38', '[{\"user_id\":\"4\",\"device_id\":\"dUbMuhY-IEQ:APA91bFsf0HuoWi77zrRa6CSV5MH8s3ZAWPrlXhWLFp4mRFVx2Klq3YYCf2PLoNZw4RchoHPb-sRdsHfdrbIAYgrNQo1DBSYLBz8b2nxWy4oRRW9nUxhZY-RuMDQxqvFWe2Y8reB-RD9\"}]', '[\"dUbMuhY-IEQ:APA91bFsf0HuoWi77zrRa6CSV5MH8s3ZAWPrlXhWLFp4mRFVx2Klq3YYCf2PLoNZw4RchoHPb-sRdsHfdrbIAYgrNQo1DBSYLBz8b2nxWy4oRRW9nUxhZY-RuMDQxqvFWe2Y8reB-RD9\"]', 'Field \"to\" must be a JSON string: [\"dUbMuhY-IEQ:APA91bFsf0HuoWi77zrRa6CSV5MH8s3ZAWPrlXhWLFp4mRFVx2Klq3YYCf2PLoNZw4RchoHPb-sRdsHfdrbIAYgrNQo1DBSYLBz8b2nxWy4oRRW9nUxhZY-RuMDQxqvFWe2Y8reB-RD9\"]\n', '2019-12-17 06:32:19', NULL, NULL, NULL, 'Active'),
(103, 'Order Delivery', 'Delivery created for Khanjan final testing at f/5 with expected delivery on 17-12-2019 having order amount Rs. 9500 with Order Id 38', '[{\"user_id\":\"3\",\"device_id\":\"d-Xna5UbCQg:APA91bGLw_2jpqsvcIuPA03WA0Y5oq18V4-aqFwN_6FBUDmLuynK6MiFeAsGDnlmzuDTG37BokbDDKxFhCNkwOwnQ-CRVTmM1AlDhsmHKhuedLBKkj_XIDVRozrN494nwrh0JjLjFVnf\"}]', '[\"d-Xna5UbCQg:APA91bGLw_2jpqsvcIuPA03WA0Y5oq18V4-aqFwN_6FBUDmLuynK6MiFeAsGDnlmzuDTG37BokbDDKxFhCNkwOwnQ-CRVTmM1AlDhsmHKhuedLBKkj_XIDVRozrN494nwrh0JjLjFVnf\"]', 'Field \"to\" must be a JSON string: [\"d-Xna5UbCQg:APA91bGLw_2jpqsvcIuPA03WA0Y5oq18V4-aqFwN_6FBUDmLuynK6MiFeAsGDnlmzuDTG37BokbDDKxFhCNkwOwnQ-CRVTmM1AlDhsmHKhuedLBKkj_XIDVRozrN494nwrh0JjLjFVnf\"]\n', '2019-12-17 06:32:20', NULL, NULL, NULL, 'Active'),
(104, 'Order Approval', 'Order No. 35 for modi sandwich for products -  has been approved with final amount 4958.05. Delivery date is 2019-12-17', '[{\"user_id\":\"1\",\"device_id\":\"eDM5wuIUEBs:APA91bGuGckmS0zmIcIBJI0AdhtsH3myilO2XRb43qzbErOIEtoAzWoDvl4Wrz0JIdhmG6S244UNS8quAI_3uDPH6rWypftHX1uFI8TBCRMM4BWLgGC65ldlHeWrZWnmhdWCec2tRy_N\"}]', '[\"eDM5wuIUEBs:APA91bGuGckmS0zmIcIBJI0AdhtsH3myilO2XRb43qzbErOIEtoAzWoDvl4Wrz0JIdhmG6S244UNS8quAI_3uDPH6rWypftHX1uFI8TBCRMM4BWLgGC65ldlHeWrZWnmhdWCec2tRy_N\"]', 'Field \"to\" must be a JSON string: [\"eDM5wuIUEBs:APA91bGuGckmS0zmIcIBJI0AdhtsH3myilO2XRb43qzbErOIEtoAzWoDvl4Wrz0JIdhmG6S244UNS8quAI_3uDPH6rWypftHX1uFI8TBCRMM4BWLgGC65ldlHeWrZWnmhdWCec2tRy_N\"]\n', '2019-12-17 06:44:54', NULL, NULL, NULL, 'Active'),
(105, 'Order Approval', 'Order NO. - 37 has been approved.', '[{\"user_id\":\"1\",\"device_id\":\"eDM5wuIUEBs:APA91bGuGckmS0zmIcIBJI0AdhtsH3myilO2XRb43qzbErOIEtoAzWoDvl4Wrz0JIdhmG6S244UNS8quAI_3uDPH6rWypftHX1uFI8TBCRMM4BWLgGC65ldlHeWrZWnmhdWCec2tRy_N\"}]', '[\"eDM5wuIUEBs:APA91bGuGckmS0zmIcIBJI0AdhtsH3myilO2XRb43qzbErOIEtoAzWoDvl4Wrz0JIdhmG6S244UNS8quAI_3uDPH6rWypftHX1uFI8TBCRMM4BWLgGC65ldlHeWrZWnmhdWCec2tRy_N\"]', 'Field \"to\" must be a JSON string: [\"eDM5wuIUEBs:APA91bGuGckmS0zmIcIBJI0AdhtsH3myilO2XRb43qzbErOIEtoAzWoDvl4Wrz0JIdhmG6S244UNS8quAI_3uDPH6rWypftHX1uFI8TBCRMM4BWLgGC65ldlHeWrZWnmhdWCec2tRy_N\"]\n', '2019-12-17 06:52:23', NULL, NULL, NULL, 'Active'),
(106, 'Order No. 37 for Khanjan final testing has been approved with final amount 9500. Delivery date is 2019-12-17', 'New Notification', '[{\"user_id\":\"1\",\"device_id\":\"eDM5wuIUEBs:APA91bGuGckmS0zmIcIBJI0AdhtsH3myilO2XRb43qzbErOIEtoAzWoDvl4Wrz0JIdhmG6S244UNS8quAI_3uDPH6rWypftHX1uFI8TBCRMM4BWLgGC65ldlHeWrZWnmhdWCec2tRy_N\"}]', '[\"eDM5wuIUEBs:APA91bGuGckmS0zmIcIBJI0AdhtsH3myilO2XRb43qzbErOIEtoAzWoDvl4Wrz0JIdhmG6S244UNS8quAI_3uDPH6rWypftHX1uFI8TBCRMM4BWLgGC65ldlHeWrZWnmhdWCec2tRy_N\"]', 'Field \"to\" must be a JSON string: [\"eDM5wuIUEBs:APA91bGuGckmS0zmIcIBJI0AdhtsH3myilO2XRb43qzbErOIEtoAzWoDvl4Wrz0JIdhmG6S244UNS8quAI_3uDPH6rWypftHX1uFI8TBCRMM4BWLgGC65ldlHeWrZWnmhdWCec2tRy_N\"]\n', '2019-12-17 06:52:23', NULL, NULL, NULL, 'Active'),
(107, 'Order Approval', 'Order NO. - 39 has been approved.', '[{\"user_id\":\"1\",\"device_id\":\"eDM5wuIUEBs:APA91bGuGckmS0zmIcIBJI0AdhtsH3myilO2XRb43qzbErOIEtoAzWoDvl4Wrz0JIdhmG6S244UNS8quAI_3uDPH6rWypftHX1uFI8TBCRMM4BWLgGC65ldlHeWrZWnmhdWCec2tRy_N\"}]', '[\"eDM5wuIUEBs:APA91bGuGckmS0zmIcIBJI0AdhtsH3myilO2XRb43qzbErOIEtoAzWoDvl4Wrz0JIdhmG6S244UNS8quAI_3uDPH6rWypftHX1uFI8TBCRMM4BWLgGC65ldlHeWrZWnmhdWCec2tRy_N\"]', 'Field \"to\" must be a JSON string: [\"eDM5wuIUEBs:APA91bGuGckmS0zmIcIBJI0AdhtsH3myilO2XRb43qzbErOIEtoAzWoDvl4Wrz0JIdhmG6S244UNS8quAI_3uDPH6rWypftHX1uFI8TBCRMM4BWLgGC65ldlHeWrZWnmhdWCec2tRy_N\"]\n', '2019-12-17 06:59:44', NULL, NULL, NULL, 'Active'),
(108, 'Order No. 39 for Ravi Sandwich has been approved with final amount 2156.5. Delivery date is 2019-12-17', 'New Notification', '[{\"user_id\":\"1\",\"device_id\":\"eDM5wuIUEBs:APA91bGuGckmS0zmIcIBJI0AdhtsH3myilO2XRb43qzbErOIEtoAzWoDvl4Wrz0JIdhmG6S244UNS8quAI_3uDPH6rWypftHX1uFI8TBCRMM4BWLgGC65ldlHeWrZWnmhdWCec2tRy_N\"}]', '[\"eDM5wuIUEBs:APA91bGuGckmS0zmIcIBJI0AdhtsH3myilO2XRb43qzbErOIEtoAzWoDvl4Wrz0JIdhmG6S244UNS8quAI_3uDPH6rWypftHX1uFI8TBCRMM4BWLgGC65ldlHeWrZWnmhdWCec2tRy_N\"]', 'Field \"to\" must be a JSON string: [\"eDM5wuIUEBs:APA91bGuGckmS0zmIcIBJI0AdhtsH3myilO2XRb43qzbErOIEtoAzWoDvl4Wrz0JIdhmG6S244UNS8quAI_3uDPH6rWypftHX1uFI8TBCRMM4BWLgGC65ldlHeWrZWnmhdWCec2tRy_N\"]\n', '2019-12-17 06:59:44', NULL, NULL, NULL, 'Active'),
(109, 'Order Delivery', 'Delivery created for natural ice-cream at mithakhali with expected delivery on 17-12-2019 having order amount Rs. 4564.75 with Order Id 33', '[{\"user_id\":\"4\",\"device_id\":\"fUUm_AAKlXw:APA91bHHJG03k96jpU9dezNd3ddGS4M8olPt8OS2neL4zIMZSfYJL-OocY2nPR_C-odfUEkwfaqo0FrmNkZCfobCLbRM74fRrowUO0KrJIsxJukOsD9Pi1oslOhiIDRoH9z-taIiOITB\"}]', '[\"fUUm_AAKlXw:APA91bHHJG03k96jpU9dezNd3ddGS4M8olPt8OS2neL4zIMZSfYJL-OocY2nPR_C-odfUEkwfaqo0FrmNkZCfobCLbRM74fRrowUO0KrJIsxJukOsD9Pi1oslOhiIDRoH9z-taIiOITB\"]', 'Field \"to\" must be a JSON string: [\"fUUm_AAKlXw:APA91bHHJG03k96jpU9dezNd3ddGS4M8olPt8OS2neL4zIMZSfYJL-OocY2nPR_C-odfUEkwfaqo0FrmNkZCfobCLbRM74fRrowUO0KrJIsxJukOsD9Pi1oslOhiIDRoH9z-taIiOITB\"]\n', '2019-12-17 07:09:47', NULL, NULL, NULL, 'Active');
INSERT INTO `fcm_notifications` (`id`, `title`, `message`, `user_arr`, `fcm_tokens`, `response`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`) VALUES
(110, 'Order Delivery', 'Delivery created for natural ice-cream at mithakhali with expected delivery on 17-12-2019 having order amount Rs. 4564.75 with Order Id 33', '[{\"user_id\":\"3\",\"device_id\":\"frkHVSY6Qco:APA91bGb524a71vNnsKM5v5IzFr1t3_oAHgna4IhS-KVS9fst9e7wDxQ1LnLKXoTx0tmxaEfH63_7ewOn1u3MscwfTL4XGu0ieiSetLCG0lmdgvsXSA5ZdGRCTEztmYBbzID3ezt0kWp\"}]', '[\"frkHVSY6Qco:APA91bGb524a71vNnsKM5v5IzFr1t3_oAHgna4IhS-KVS9fst9e7wDxQ1LnLKXoTx0tmxaEfH63_7ewOn1u3MscwfTL4XGu0ieiSetLCG0lmdgvsXSA5ZdGRCTEztmYBbzID3ezt0kWp\"]', 'Field \"to\" must be a JSON string: [\"frkHVSY6Qco:APA91bGb524a71vNnsKM5v5IzFr1t3_oAHgna4IhS-KVS9fst9e7wDxQ1LnLKXoTx0tmxaEfH63_7ewOn1u3MscwfTL4XGu0ieiSetLCG0lmdgvsXSA5ZdGRCTEztmYBbzID3ezt0kWp\"]\n', '2019-12-17 07:09:47', NULL, NULL, NULL, 'Active'),
(111, 'Order Delivery', 'Delivery created for Harish pan parlour at law garden circle, law garden with expected delivery on 17-12-2019 having order amount Rs. 7386.25 with Order Id 34', '[{\"user_id\":\"4\",\"device_id\":\"fUUm_AAKlXw:APA91bHHJG03k96jpU9dezNd3ddGS4M8olPt8OS2neL4zIMZSfYJL-OocY2nPR_C-odfUEkwfaqo0FrmNkZCfobCLbRM74fRrowUO0KrJIsxJukOsD9Pi1oslOhiIDRoH9z-taIiOITB\"}]', '[\"fUUm_AAKlXw:APA91bHHJG03k96jpU9dezNd3ddGS4M8olPt8OS2neL4zIMZSfYJL-OocY2nPR_C-odfUEkwfaqo0FrmNkZCfobCLbRM74fRrowUO0KrJIsxJukOsD9Pi1oslOhiIDRoH9z-taIiOITB\"]', 'Field \"to\" must be a JSON string: [\"fUUm_AAKlXw:APA91bHHJG03k96jpU9dezNd3ddGS4M8olPt8OS2neL4zIMZSfYJL-OocY2nPR_C-odfUEkwfaqo0FrmNkZCfobCLbRM74fRrowUO0KrJIsxJukOsD9Pi1oslOhiIDRoH9z-taIiOITB\"]\n', '2019-12-17 07:09:47', NULL, NULL, NULL, 'Active'),
(112, 'Order Delivery', 'Delivery created for Harish pan parlour at law garden circle, law garden with expected delivery on 17-12-2019 having order amount Rs. 7386.25 with Order Id 34', '[{\"user_id\":\"3\",\"device_id\":\"frkHVSY6Qco:APA91bGb524a71vNnsKM5v5IzFr1t3_oAHgna4IhS-KVS9fst9e7wDxQ1LnLKXoTx0tmxaEfH63_7ewOn1u3MscwfTL4XGu0ieiSetLCG0lmdgvsXSA5ZdGRCTEztmYBbzID3ezt0kWp\"}]', '[\"frkHVSY6Qco:APA91bGb524a71vNnsKM5v5IzFr1t3_oAHgna4IhS-KVS9fst9e7wDxQ1LnLKXoTx0tmxaEfH63_7ewOn1u3MscwfTL4XGu0ieiSetLCG0lmdgvsXSA5ZdGRCTEztmYBbzID3ezt0kWp\"]', 'Field \"to\" must be a JSON string: [\"frkHVSY6Qco:APA91bGb524a71vNnsKM5v5IzFr1t3_oAHgna4IhS-KVS9fst9e7wDxQ1LnLKXoTx0tmxaEfH63_7ewOn1u3MscwfTL4XGu0ieiSetLCG0lmdgvsXSA5ZdGRCTEztmYBbzID3ezt0kWp\"]\n', '2019-12-17 07:09:48', NULL, NULL, NULL, 'Active'),
(113, 'Order Delivery', 'Delivery created for modi sandwich at vasna with expected delivery on 17-12-2019 having order amount Rs. 4958.05 with Order Id 35', '[{\"user_id\":\"3\",\"device_id\":\"fUUm_AAKlXw:APA91bHHJG03k96jpU9dezNd3ddGS4M8olPt8OS2neL4zIMZSfYJL-OocY2nPR_C-odfUEkwfaqo0FrmNkZCfobCLbRM74fRrowUO0KrJIsxJukOsD9Pi1oslOhiIDRoH9z-taIiOITB\"}]', '[\"fUUm_AAKlXw:APA91bHHJG03k96jpU9dezNd3ddGS4M8olPt8OS2neL4zIMZSfYJL-OocY2nPR_C-odfUEkwfaqo0FrmNkZCfobCLbRM74fRrowUO0KrJIsxJukOsD9Pi1oslOhiIDRoH9z-taIiOITB\"]', 'Field \"to\" must be a JSON string: [\"fUUm_AAKlXw:APA91bHHJG03k96jpU9dezNd3ddGS4M8olPt8OS2neL4zIMZSfYJL-OocY2nPR_C-odfUEkwfaqo0FrmNkZCfobCLbRM74fRrowUO0KrJIsxJukOsD9Pi1oslOhiIDRoH9z-taIiOITB\"]\n', '2019-12-17 07:26:07', NULL, NULL, NULL, 'Active'),
(114, 'Order Delivery', 'Delivery created for natural ice-cream at mithakhali with expected delivery on 18-12-2019 having order amount Rs. 4564.75 with Order Id 33', '[{\"user_id\":\"3\",\"device_id\":\"fUUm_AAKlXw:APA91bHHJG03k96jpU9dezNd3ddGS4M8olPt8OS2neL4zIMZSfYJL-OocY2nPR_C-odfUEkwfaqo0FrmNkZCfobCLbRM74fRrowUO0KrJIsxJukOsD9Pi1oslOhiIDRoH9z-taIiOITB\"}]', '[\"fUUm_AAKlXw:APA91bHHJG03k96jpU9dezNd3ddGS4M8olPt8OS2neL4zIMZSfYJL-OocY2nPR_C-odfUEkwfaqo0FrmNkZCfobCLbRM74fRrowUO0KrJIsxJukOsD9Pi1oslOhiIDRoH9z-taIiOITB\"]', 'Field \"to\" must be a JSON string: [\"fUUm_AAKlXw:APA91bHHJG03k96jpU9dezNd3ddGS4M8olPt8OS2neL4zIMZSfYJL-OocY2nPR_C-odfUEkwfaqo0FrmNkZCfobCLbRM74fRrowUO0KrJIsxJukOsD9Pi1oslOhiIDRoH9z-taIiOITB\"]\n', '2019-12-18 03:07:35', NULL, NULL, NULL, 'Active'),
(115, 'Order Delivery', 'Delivery created for Sun Pharma at Home address with expected delivery on 18-12-2019 having order amount Rs. 265 with Order Id 13', '[{\"user_id\":\"3\",\"device_id\":\"fUUm_AAKlXw:APA91bHHJG03k96jpU9dezNd3ddGS4M8olPt8OS2neL4zIMZSfYJL-OocY2nPR_C-odfUEkwfaqo0FrmNkZCfobCLbRM74fRrowUO0KrJIsxJukOsD9Pi1oslOhiIDRoH9z-taIiOITB\"}]', '[\"fUUm_AAKlXw:APA91bHHJG03k96jpU9dezNd3ddGS4M8olPt8OS2neL4zIMZSfYJL-OocY2nPR_C-odfUEkwfaqo0FrmNkZCfobCLbRM74fRrowUO0KrJIsxJukOsD9Pi1oslOhiIDRoH9z-taIiOITB\"]', 'Field \"to\" must be a JSON string: [\"fUUm_AAKlXw:APA91bHHJG03k96jpU9dezNd3ddGS4M8olPt8OS2neL4zIMZSfYJL-OocY2nPR_C-odfUEkwfaqo0FrmNkZCfobCLbRM74fRrowUO0KrJIsxJukOsD9Pi1oslOhiIDRoH9z-taIiOITB\"]\n', '2019-12-18 03:08:42', NULL, NULL, NULL, 'Active');

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
(51, 3, 18, 1, '2019-12-06 00:00:00', 0, '2019-12-06 00:00:00', 3, 'Active'),
(52, 4, 18, 1, '2019-12-06 00:00:00', 0, '2019-12-06 00:00:00', 4, 'Active'),
(53, 3, 19, 1, '2019-12-06 00:00:00', 0, '2019-12-06 00:00:00', 3, 'Active'),
(54, 4, 19, 1, '2019-12-06 00:00:00', 0, '2019-12-06 00:00:00', 4, 'Active'),
(55, 1, 20, 1, '2019-12-06 00:00:00', 0, '2019-12-10 00:00:00', 1, 'Active'),
(56, 3, 21, 1, '2019-12-06 00:00:00', 0, '2019-12-06 00:00:00', 3, 'Active'),
(57, 4, 21, 1, '2019-12-06 00:00:00', 0, '2019-12-06 00:00:00', 4, 'Active'),
(58, 4, 22, 1, '2019-12-06 00:00:00', 0, '2019-12-06 00:00:00', 4, 'Active'),
(59, 4, 23, 1, '2019-12-06 00:00:00', 0, '2019-12-06 00:00:00', 4, 'Active'),
(60, 3, 24, 1, '2019-12-06 00:00:00', 0, '2019-12-10 00:00:00', 3, 'Active'),
(61, 4, 25, 1, '2019-12-06 00:00:00', 0, '2019-12-06 00:00:00', 4, 'Active'),
(62, 4, 26, 0, '2019-12-06 00:00:00', 0, NULL, NULL, 'Active'),
(63, 4, 27, 0, '2019-12-06 00:00:00', 0, NULL, NULL, 'Active'),
(64, 3, 28, 1, '2019-12-06 00:00:00', 0, '2019-12-09 00:00:00', 3, 'Active'),
(65, 4, 29, 0, '2019-12-06 00:00:00', 0, NULL, NULL, 'Active'),
(66, 4, 30, 1, '2019-12-06 00:00:00', 0, '2019-12-06 00:00:00', 4, 'Active'),
(67, 4, 31, 1, '2019-12-06 00:00:00', 0, '2019-12-06 00:00:00', 4, 'Active'),
(68, 1, 32, 1, '2019-12-09 00:00:00', 0, '2019-12-10 00:00:00', 1, 'Active'),
(69, 4, 33, 0, '2019-12-09 00:00:00', 0, NULL, NULL, 'Active'),
(70, 3, 34, 1, '2019-12-09 00:00:00', 0, '2019-12-09 00:00:00', 3, 'Active'),
(71, 4, 35, 1, '2019-12-09 00:00:00', 0, '2019-12-11 00:00:00', 4, 'Active'),
(72, 4, 36, 1, '2019-12-11 00:00:00', 0, '2019-12-11 00:00:00', 4, 'Active'),
(73, 4, 37, 1, '2019-12-11 00:00:00', 0, '2019-12-11 00:00:00', 4, 'Active'),
(74, 4, 38, 0, '2019-12-16 00:00:00', 0, NULL, NULL, 'Active'),
(75, 3, 39, 0, '2019-12-16 00:00:00', 0, NULL, NULL, 'Active'),
(76, 4, 40, 0, '2019-12-16 00:00:00', 0, NULL, NULL, 'Active'),
(77, 3, 41, 0, '2019-12-16 00:00:00', 0, NULL, NULL, 'Active'),
(78, 4, 42, 0, '2019-12-17 00:00:00', 0, NULL, NULL, 'Active'),
(79, 3, 43, 0, '2019-12-17 00:00:00', 0, NULL, NULL, 'Active'),
(80, 4, 44, 0, '2019-12-17 00:00:00', 0, NULL, NULL, 'Active'),
(81, 3, 45, 0, '2019-12-17 00:00:00', 0, NULL, NULL, 'Active'),
(82, 4, 46, 0, '2019-12-17 00:00:00', 0, NULL, NULL, 'Active'),
(83, 3, 47, 0, '2019-12-17 00:00:00', 0, NULL, NULL, 'Active'),
(84, 4, 48, 0, '2019-12-17 00:00:00', 0, NULL, NULL, 'Active'),
(85, 4, 49, 0, '2019-12-17 00:00:00', 0, NULL, NULL, 'Active'),
(86, 3, 50, 0, '2019-12-17 00:00:00', 0, NULL, NULL, 'Active'),
(87, 1, 51, 1, '2019-12-17 00:00:00', 0, '2019-12-17 00:00:00', 1, 'Active'),
(88, 4, 52, 0, '2019-12-17 00:00:00', 0, NULL, NULL, 'Active'),
(89, 3, 53, 0, '2019-12-17 00:00:00', 0, NULL, NULL, 'Active'),
(90, 4, 54, 0, '2019-12-17 00:00:00', 0, NULL, NULL, 'Active'),
(91, 3, 55, 0, '2019-12-17 00:00:00', 0, NULL, NULL, 'Active'),
(92, 4, 56, 0, '2019-12-17 00:00:00', 0, NULL, NULL, 'Active'),
(93, 3, 57, 0, '2019-12-17 00:00:00', 0, NULL, NULL, 'Active'),
(94, 4, 58, 0, '2019-12-17 00:00:00', 0, NULL, NULL, 'Active'),
(95, 3, 59, 0, '2019-12-17 00:00:00', 0, NULL, NULL, 'Active'),
(96, 1, 60, 1, '2019-12-17 00:00:00', 0, '2019-12-17 00:00:00', 1, 'Active'),
(97, 4, 61, 0, '2019-12-17 00:00:00', 0, NULL, NULL, 'Active'),
(98, 3, 62, 0, '2019-12-17 00:00:00', 0, NULL, NULL, 'Active'),
(99, 3, 63, 0, '2019-12-17 00:00:00', 0, NULL, NULL, 'Active'),
(100, 3, 64, 0, '2019-12-17 00:00:00', 0, NULL, NULL, 'Active'),
(101, 3, 65, 0, '2019-12-17 00:00:00', 0, NULL, NULL, 'Active'),
(102, 1, 66, 1, '2019-12-17 00:00:00', 0, '2019-12-17 00:00:00', 1, 'Active'),
(103, 3, 67, 0, '2019-12-17 00:00:00', 0, NULL, NULL, 'Active'),
(104, 1, 68, 1, '2019-12-17 00:00:00', 0, '2019-12-17 00:00:00', 1, 'Active'),
(105, 1, 69, 1, '2019-12-17 00:00:00', 0, '2019-12-17 00:00:00', 1, 'Active'),
(106, 1, 70, 1, '2019-12-17 00:00:00', 0, '2019-12-17 00:00:00', 1, 'Active'),
(107, 4, 71, 0, '2019-12-17 00:00:00', 0, NULL, NULL, 'Active'),
(108, 3, 72, 1, '2019-12-17 00:00:00', 0, '2019-12-17 00:00:00', 3, 'Active'),
(109, 4, 73, 0, '2019-12-17 00:00:00', 0, NULL, NULL, 'Active'),
(110, 3, 74, 0, '2019-12-17 00:00:00', 0, NULL, NULL, 'Active'),
(111, 4, 75, 0, '2019-12-17 00:00:00', 0, NULL, NULL, 'Active'),
(112, 3, 76, 0, '2019-12-17 00:00:00', 0, NULL, NULL, 'Active'),
(113, 4, 77, 0, '2019-12-17 00:00:00', 0, NULL, NULL, 'Active'),
(114, 3, 78, 0, '2019-12-17 00:00:00', 0, NULL, NULL, 'Active'),
(115, 4, 79, 0, '2019-12-17 00:00:00', 0, NULL, NULL, 'Active'),
(116, 3, 80, 0, '2019-12-17 00:00:00', 0, NULL, NULL, 'Active'),
(117, 4, 81, 0, '2019-12-17 00:00:00', 0, NULL, NULL, 'Active'),
(118, 4, 82, 0, '2019-12-17 00:00:00', 0, NULL, NULL, 'Active'),
(119, 4, 83, 0, '2019-12-17 00:00:00', 0, NULL, NULL, 'Active'),
(120, 3, 84, 0, '2019-12-17 00:00:00', 0, NULL, NULL, 'Active'),
(121, 4, 85, 0, '2019-12-17 00:00:00', 0, NULL, NULL, 'Active'),
(122, 4, 86, 0, '2019-12-17 00:00:00', 0, NULL, NULL, 'Active'),
(123, 4, 87, 0, '2019-12-17 00:00:00', 0, NULL, NULL, 'Active'),
(124, 4, 88, 0, '2019-12-17 00:00:00', 0, NULL, NULL, 'Active'),
(125, 4, 89, 0, '2019-12-17 00:00:00', 0, NULL, NULL, 'Active'),
(126, 4, 90, 0, '2019-12-17 00:00:00', 0, NULL, NULL, 'Active'),
(127, 4, 91, 0, '2019-12-17 00:00:00', 0, NULL, NULL, 'Active'),
(128, 4, 92, 0, '2019-12-17 00:00:00', 0, NULL, NULL, 'Active'),
(129, 4, 93, 0, '2019-12-17 00:00:00', 0, NULL, NULL, 'Active'),
(130, 4, 94, 0, '2019-12-17 00:00:00', 0, NULL, NULL, 'Active'),
(131, 4, 95, 0, '2019-12-17 00:00:00', 0, NULL, NULL, 'Active'),
(132, 4, 96, 0, '2019-12-17 00:00:00', 0, NULL, NULL, 'Active'),
(133, 4, 97, 0, '2019-12-17 00:00:00', 0, NULL, NULL, 'Active'),
(134, 4, 98, 0, '2019-12-17 00:00:00', 0, NULL, NULL, 'Active'),
(135, 4, 99, 0, '2019-12-17 00:00:00', 0, NULL, NULL, 'Active'),
(136, 4, 100, 0, '2019-12-17 00:00:00', 0, NULL, NULL, 'Active'),
(137, 1, 101, 1, '2019-12-17 00:00:00', 0, '2019-12-17 00:00:00', 1, 'Active'),
(138, 4, 102, 0, '2019-12-17 00:00:00', 0, NULL, NULL, 'Active'),
(139, 3, 103, 0, '2019-12-17 00:00:00', 0, NULL, NULL, 'Active'),
(140, 1, 104, 1, '2019-12-17 00:00:00', 0, '2019-12-17 00:00:00', 1, 'Active'),
(141, 1, 105, 1, '2019-12-17 00:00:00', 0, '2019-12-18 00:00:00', 1, 'Active'),
(142, 1, 106, 1, '2019-12-17 00:00:00', 0, '2019-12-18 00:00:00', 1, 'Active'),
(143, 1, 107, 1, '2019-12-17 00:00:00', 0, '2019-12-18 00:00:00', 1, 'Active'),
(144, 1, 108, 1, '2019-12-17 00:00:00', 0, '2019-12-18 00:00:00', 1, 'Active'),
(145, 4, 109, 0, '2019-12-17 00:00:00', 0, NULL, NULL, 'Active'),
(146, 3, 110, 1, '2019-12-17 00:00:00', 0, '2019-12-17 00:00:00', 3, 'Active'),
(147, 4, 111, 0, '2019-12-17 00:00:00', 0, NULL, NULL, 'Active'),
(148, 3, 112, 1, '2019-12-17 00:00:00', 0, '2019-12-17 00:00:00', 3, 'Active'),
(149, 3, 113, 0, '2019-12-17 00:00:00', 0, NULL, NULL, 'Active'),
(150, 3, 114, 0, '2019-12-18 00:00:00', 0, NULL, NULL, 'Active'),
(151, 3, 115, 0, '2019-12-18 00:00:00', 0, NULL, NULL, 'Active');

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
(1, 1, 5, '2019-11-25 13:04:38', 2, NULL, NULL, 'Active'),
(2, 1, 6, '2019-11-25 13:04:38', 2, NULL, NULL, 'Active'),
(7, 2, 1, '2019-12-05 14:30:05', 2, NULL, NULL, 'Active'),
(8, 2, 2, '2019-12-05 14:30:05', 2, NULL, NULL, 'Active'),
(9, 2, 3, '2019-12-05 14:30:05', 2, NULL, NULL, 'Active'),
(10, 2, 4, '2019-12-05 14:30:05', 2, NULL, NULL, 'Active'),
(11, 1, 12, '2019-12-06 14:37:04', 2, NULL, NULL, 'Active');

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
(1, 'Sun Pharma', 'Snehal Trapsiya', 'snehal@gmail.com', '9166650505', NULL, 1, '2019-12-05 14:18:35', 1, '2019-12-05 03:56:27', NULL, 0),
(2, 'Gandhi soda', 'priyanshu', 'priyanshu@gmail.com', '6598653265', '4477880055', 1, '2019-12-05 14:47:09', 1, '2019-12-05 04:22:06', NULL, 0),
(3, 'Ravi Sandwich', 'Vasukaka', 'ehs.mehul@gmail.com', '8454813349', '8525329645', 1, '2019-12-05 15:23:43', 1, '2019-12-05 08:32:02', NULL, 0),
(4, 'Khanjan testing', 'Khanjan Shah', 'khanjanshah06@gmail.com', '9429620022', NULL, 1, '2019-12-05 18:07:40', 1, '2019-12-05 07:49:39', NULL, 0),
(5, 'star snacks', 'shivabhai', NULL, '9865326598', NULL, 1, '2019-12-05 18:22:17', 1, '2019-12-05 08:53:47', NULL, 0),
(6, 'star snacks', 'shivabhai', NULL, '9865326598', NULL, 0, '2019-12-05 18:22:18', 1, '2019-12-11 00:12:05', NULL, 1),
(7, 'hhuu', 'cfgg', 'khanjanan', '1234567891', '3214567891', 0, '2019-12-05 18:24:54', 1, '2019-12-10 03:33:58', NULL, 1),
(8, 'hhuu', 'cfgg', 'khanjanan', '1234567891', '3214567891', 0, '2019-12-05 18:24:55', 1, '2019-12-10 03:33:50', NULL, 1),
(9, 'natural ice-cream', 'divyesh bhai', NULL, '9865989898', NULL, 1, '2019-12-06 11:52:06', 1, '2019-12-06 02:19:02', NULL, 0),
(10, 'Empire bakery', 'Mohsinbhai', NULL, '6459865329', NULL, 1, '2019-12-06 12:42:23', 1, '2019-12-06 02:15:00', NULL, 0),
(11, 'test', 'test', 'ashish@gmail.com', '9166650111', NULL, 0, '2019-12-06 13:10:56', 2, '2019-12-06 02:41:04', NULL, 1),
(12, 'Khanjan final testing', '9867777777', 'kh', '9429620022', NULL, 1, '2019-12-06 13:42:25', 1, '2019-12-10 03:34:09', NULL, 1),
(13, 'Eminent hotel', 'Azam', 'azaz@yahoo.com', '9173021172', NULL, 1, '2019-12-06 19:21:14', 1, '2019-12-11 00:21:03', 2, 0),
(14, 'modi sandwich', 'pranav modi', NULL, '9865487845', NULL, 1, '2019-12-09 11:13:35', 1, '2019-12-09 00:49:10', NULL, 0),
(15, 'Harish pan parlour', 'Harish dave', 'hariah@aol.com', '7855669988', NULL, 1, '2019-12-09 13:13:50', 1, '2019-12-09 02:45:51', NULL, 0),
(16, 'Queenland cafe', 'pritesh', NULL, '9468009966', NULL, 1, '2019-12-09 17:07:24', 1, '2019-12-11 02:23:22', NULL, 0),
(17, 'sai pan parlor', 'mahesh', NULL, '6438959868', NULL, 0, '2019-12-09 17:07:52', 1, '2019-12-11 00:11:40', NULL, 1),
(18, 'sai pan parlor', 'mahesh', NULL, '6438959868', NULL, 0, '2019-12-09 17:07:52', 1, '2019-12-10 03:34:21', NULL, 1),
(19, 'sai pan parlor', 'mahesh', NULL, '6438959868', NULL, 0, '2019-12-09 17:07:52', 1, NULL, NULL, 0),
(20, 'sai pan parlor', 'mahesh', NULL, '6438959868', NULL, 0, '2019-12-09 17:07:52', 1, '2019-12-11 00:11:58', NULL, 1),
(21, 'sai pan parlor', 'mahesh', NULL, '6438959868', NULL, 0, '2019-12-09 17:07:53', 1, '2019-12-11 00:11:51', NULL, 1),
(22, 'sai pan parlor', 'mahesh', NULL, '6438959868', NULL, 0, '2019-12-09 17:07:53', 1, '2019-12-11 00:11:34', NULL, 1),
(23, 'Nutan restaurant', 'salim', NULL, '9865888664', NULL, 0, '2019-12-09 17:08:53', 1, '2019-12-11 00:11:25', NULL, 1),
(24, 'Nutan restaurant', 'salim', NULL, '9865888664', NULL, 0, '2019-12-09 17:08:53', 1, '2019-12-10 03:33:38', NULL, 1),
(25, 'Nutan restaurant', 'salim', NULL, '9865888664', NULL, 0, '2019-12-09 17:08:53', 1, '2019-12-10 03:33:29', NULL, 1),
(26, 'Nutan restaurant', 'salim', NULL, '9865888664', NULL, 0, '2019-12-09 17:08:53', 1, '2019-12-10 03:33:19', NULL, 1),
(27, 'Nutan restaurant', 'salim', NULL, '9865888664', NULL, 0, '2019-12-09 17:08:53', 1, '2019-12-11 00:11:15', NULL, 1),
(28, 'Nutan restaurant', 'salim', NULL, '9865888664', NULL, 0, '2019-12-09 17:08:53', 1, NULL, NULL, 0),
(29, 'freezeland sandwich', 'kamlesh pandya', NULL, '6865986536', NULL, 0, '2019-12-10 10:38:07', 1, NULL, NULL, 0),
(30, 'freezeland sandwich', 'kamlesh pandya', NULL, '6865986536', NULL, 0, '2019-12-10 10:38:07', 1, '2019-12-10 03:33:05', NULL, 1),
(31, 'freezeland sandwich', 'kamlesh pandya', NULL, '6865986536', NULL, 0, '2019-12-10 10:38:07', 1, '2019-12-11 00:10:07', NULL, 1),
(32, 'freezeland sandwich', 'kamlesh pandya', NULL, '6865986536', NULL, 0, '2019-12-10 10:38:07', 1, '2019-12-10 03:32:55', NULL, 1),
(33, 'freezeland sandwich', 'kamlesh pandya', NULL, '6865986536', NULL, 0, '2019-12-10 10:38:07', 1, '2019-12-11 00:09:55', NULL, 1),
(34, 'freezeland sandwich', 'kamlesh pandya', NULL, '6865986536', NULL, 0, '2019-12-10 10:38:07', 1, '2019-12-11 00:10:00', NULL, 1),
(35, 'vdb', 'shd', 'ehs.mehul@gmail.com', '6264646466', '9559494664', 0, '2019-12-10 11:12:14', 1, NULL, NULL, 0),
(36, 'Ashok chawana mart', 'premjibhai', NULL, '6898699464', NULL, 0, '2019-12-10 13:58:08', 1, '2019-12-11 00:10:12', NULL, 1),
(37, 'Ashok chawana mart', 'premjibhai', NULL, '6898699464', NULL, 0, '2019-12-10 13:58:09', 1, NULL, NULL, 0),
(38, 'Twst', 'hd', 'hdhd@jsj.sjs', '6262625656', '9565655556', 0, '2019-12-10 14:01:23', 1, '2019-12-10 03:34:32', NULL, 1),
(39, 'Reliance mart', 'Ashok Mishra', NULL, '9986649946', NULL, 1, '2019-12-10 14:02:16', 1, '2019-12-17 04:03:24', NULL, 0),
(40, 'yuk', 'tres', 'test@test.com', '9723664556', NULL, 1, '2019-12-16 18:01:08', 1, '2019-12-16 07:45:08', NULL, 0),
(41, 'Khanjanss', '9429629022', 'khanjanshah06@gmail.com', '9638527410', NULL, 1, '2019-12-17 14:12:39', 1, '2019-12-17 03:45:21', NULL, 0),
(42, 'test rakesh', 'rakesh', 'rakesh123@test.com', '1231233212', NULL, 0, '2019-12-18 16:44:33', 1, NULL, NULL, 0),
(43, 'ahish makwana', 'ahsih', 'ashi@test.com', '1212343456', NULL, 0, '2019-12-18 17:53:28', 1, NULL, NULL, 0),
(44, 'test 1', 'test one', 'test11@gmail.com', '1593572585', NULL, 0, '2019-12-18 17:56:01', 1, NULL, NULL, 0),
(45, 'xyz', 'xyz', 'asasa@gmail.com', '4545656528', NULL, 0, '2019-12-18 18:00:12', 1, NULL, NULL, 0);

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
(1, 1, '2019-12-05', '14:18:35', 'InPerson', NULL, NULL, NULL, '2019-12-05 00:00:00', 1, '2019-12-18 07:34:23', NULL),
(2, 1, '2019-12-05', '14:19:00', 'inperson', 'Test opportunity', NULL, 'Notes of client', '2019-12-05 14:19:26', 1, '2019-12-18 07:34:31', NULL),
(3, 2, '2019-12-05', '14:47:09', 'InPerson', NULL, NULL, NULL, '2019-12-05 00:00:00', 1, '2019-12-18 07:34:23', NULL),
(4, 3, '2019-12-05', '15:23:43', 'InPerson', NULL, NULL, NULL, '2019-12-05 00:00:00', 1, '2019-12-18 07:34:23', NULL),
(5, 4, '2019-12-05', '18:07:40', 'InPerson', NULL, NULL, NULL, '2019-12-05 00:00:00', 1, '2019-12-18 07:34:23', NULL),
(6, 7, '2019-12-05', '18:24:54', 'InPerson', NULL, NULL, NULL, '2019-12-05 00:00:00', 1, '2019-12-18 07:34:23', NULL),
(7, 8, '2019-12-05', '18:24:55', 'InPerson', NULL, NULL, NULL, '2019-12-05 00:00:00', 1, '2019-12-18 07:34:23', NULL),
(8, 6, '2019-12-05', '23:40:00', 'phone', 'hello', NULL, 'test', '2019-12-06 13:41:00', 1, '2019-12-18 07:34:42', NULL),
(9, 35, '2019-12-10', '11:12:14', 'InPerson', NULL, NULL, NULL, '2019-12-10 00:00:00', 1, '2019-12-18 07:34:23', NULL),
(10, 38, '2019-12-10', '14:01:23', 'InPerson', NULL, NULL, NULL, '2019-12-10 00:00:00', 1, '2019-12-18 07:34:23', NULL),
(11, 19, '2019-12-20', '11:36:00', 'phone', '105 box monthly for more than a year long period', NULL, 'this is for testing purpose only.\n', '2019-12-18 16:36:41', 1, '2019-12-18 07:34:42', NULL),
(12, 35, '2019-12-22', '10:43:00', 'inperson', '200 carton', NULL, 'this is test notes', '2019-12-18 16:43:44', 1, '2019-12-18 07:34:42', NULL),
(13, 42, '2019-12-18', '16:44:33', 'InPerson', NULL, NULL, NULL, '2019-12-18 00:00:00', 1, '2019-12-18 07:34:23', NULL),
(14, 42, '2019-12-18', '16:57:00', 'inperson', '123', NULL, 'test rakesh 2', '2019-12-18 16:57:53', 1, '2019-12-18 07:34:42', NULL),
(15, 43, '2019-12-18', '17:53:28', 'InPerson', NULL, NULL, NULL, '2019-12-18 00:00:00', 1, '2019-12-18 07:34:23', NULL),
(16, 44, '2019-12-18', '17:56:01', 'InPerson', NULL, NULL, NULL, '2019-12-18 00:00:00', 1, '2019-12-18 07:34:23', NULL),
(17, 19, '2019-12-18', '17:59:00', 'inperson', 'tera', NULL, NULL, '2019-12-18 17:59:36', 1, '2019-12-18 07:34:23', NULL),
(18, 45, '2019-12-18', '18:00:12', 'InPerson', NULL, NULL, NULL, '2019-12-18 00:00:00', 1, '2019-12-18 07:34:23', NULL);

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
(1, 1, 1, 2, 'High', NULL, '2019-12-05', NULL, '2019-12-05', 500.00, 1, 'Cash', '2019-12-05', '14:26:00', 'Delivered', 'Active', 'Paid', 1, '2019-12-05 14:26:27', 1, '2019-12-16 07:58:47', 4),
(2, 2, 2, 1, 'Low', NULL, '2019-12-05', NULL, '2019-12-05', 2561.00, 2, 'Cash', '2019-12-05', '16:52:00', 'Delivered', 'Active', 'Pending', 1, '2019-12-05 14:52:06', 1, '2019-12-06 08:38:44', 4),
(3, 1, 1, 1, 'Low', NULL, '2019-12-05', NULL, '2019-12-05', 3950.00, 3, 'Cash', '2019-12-05', '00:00:00', 'Delivered', 'Active', 'Partial', 1, '2019-12-05 16:53:18', 1, '2019-12-16 07:58:47', 3),
(4, 3, 3, 7, 'Low', NULL, '2019-12-05', NULL, NULL, 1575.00, 4, 'Cash', '2019-12-05', '12:15:00', 'Approved', 'Active', 'Paid', 1, '2019-12-05 18:19:39', 1, '2019-12-17 05:09:51', NULL),
(5, 4, 4, 1, 'Low', NULL, '2019-12-05', NULL, NULL, 1742.50, NULL, 'Cash', '2019-12-05', '00:00:00', 'Approved', 'Active', 'Pending', 1, '2019-12-05 19:02:02', 1, '2019-12-06 07:25:41', NULL),
(6, 5, 5, 0, 'Low', NULL, '2019-12-05', NULL, '2019-12-06', 225.00, 6, 'Cash', '2019-12-05', '00:00:00', 'Delivered', 'Active', 'Pending', 0, '2019-12-05 19:23:47', 1, '2019-12-06 07:25:41', 3),
(7, 2, 2, 1, 'Low', NULL, '2019-12-06', NULL, '2019-12-06', 1291.50, 5, 'Cash', '2019-12-06', '00:00:00', 'Delivered', 'Active', 'Pending', 1, '2019-12-06 11:33:12', 1, '2019-12-06 07:25:41', 3),
(8, 6, 6, 1, 'Low', NULL, '2019-12-06', NULL, NULL, 6282.00, NULL, 'Cash', '2019-12-06', '00:00:00', 'Approval Required', 'Active', 'Pending', 1, '2019-12-06 12:45:00', 1, '2019-12-06 07:25:41', NULL),
(9, 7, 7, 1, 'Low', NULL, '2019-12-06', NULL, NULL, 3253.00, 7, 'Cash', '2019-12-06', '00:00:00', 'Approved', 'Active', 'Paid', 1, '2019-12-06 12:49:02', 1, '2019-12-17 05:09:18', NULL),
(10, 8, 9, 1, 'Low', NULL, '2019-12-06', NULL, '2019-12-06', 42400.00, 6, 'Cash', '2019-12-06', '00:00:00', 'Delivered', 'Active', 'Pending', 0, '2019-12-06 13:51:03', 1, '2019-12-06 07:25:41', 3),
(11, 9, 10, 1, 'Low', NULL, '2019-12-09', NULL, '2019-12-09', 15861.00, 8, 'Cash', '2019-12-09', '11:19:00', 'Delivered', 'Active', 'Pending', 1, '2019-12-09 11:19:10', 1, '2019-12-09 00:00:00', 3),
(12, 10, 11, 7, 'Low', NULL, '2019-12-09', NULL, '2019-12-09', 5100.00, 9, 'Cash', '2019-12-09', '00:00:00', 'Delivered', 'Active', 'Paid', 0, '2019-12-09 13:15:51', 1, '2019-12-17 07:41:37', 4),
(13, 1, 1, 0, 'Low', NULL, '2019-12-10', NULL, '2019-12-18', 265.00, 44, 'Cash', '2019-12-10', '00:00:00', 'Delivered', 'Active', 'Pending', 0, '2019-12-10 17:30:30', 1, '2019-12-18 00:00:00', 3),
(14, 11, 13, 1, 'Medium', NULL, '2019-12-11', NULL, '2019-12-17', 3025.00, 15, 'Cash', '2019-12-11', '11:51:00', 'Delivered', 'Active', 'Pending', 0, '2019-12-11 10:51:03', 1, '2019-12-17 00:00:00', 3),
(15, 12, 13, 1, 'Medium', NULL, '2019-12-11', NULL, NULL, 3025.00, 12, 'Cash', '2019-12-11', '11:51:00', 'Pending', 'Active', 'Pending', 0, '2019-12-11 10:51:25', 1, '2019-12-16 08:03:55', NULL),
(16, 13, 13, 1, 'Medium', NULL, '2019-12-11', NULL, NULL, 3025.00, 12, 'Cash', '2019-12-11', '11:51:00', 'Pending', 'Active', 'Pending', 0, '2019-12-11 10:51:31', 1, '2019-12-16 08:03:55', NULL),
(17, 14, 13, 1, 'Medium', NULL, '2019-12-11', NULL, '2019-12-17', 3025.00, 14, 'Cash', '2019-12-11', '11:51:00', 'Delivered', 'Active', 'Pending', 0, '2019-12-11 10:51:32', 1, '2019-12-17 00:00:00', 3),
(18, 15, 13, 1, 'Medium', NULL, '2019-12-11', NULL, '2019-12-17', 3025.00, 16, 'Cash', '2019-12-11', '11:51:00', 'Delivered', 'Active', 'Pending', 0, '2019-12-11 10:51:33', 1, '2019-12-17 00:00:00', 4),
(19, 16, 13, 1, 'Medium', NULL, '2019-12-11', NULL, '2019-12-17', 3025.00, 17, 'Cash', '2019-12-11', '11:51:00', 'Delivered', 'Active', 'Pending', 0, '2019-12-11 10:51:34', 1, '2019-12-17 00:00:00', 3),
(20, 17, 13, 1, 'Medium', NULL, '2019-12-11', NULL, '2019-12-17', 3025.00, 18, 'Cash', '2019-12-11', '11:51:00', 'Delivered', 'Active', 'Pending', 0, '2019-12-11 10:51:35', 1, '2019-12-17 00:00:00', 3),
(21, 18, 13, 1, 'Medium', NULL, '2019-12-11', NULL, '2019-12-17', 3025.00, 19, 'Cash', '2019-12-11', '11:51:00', 'Delivered', 'Active', 'Pending', 0, '2019-12-11 10:51:37', 1, '2019-12-17 00:00:00', 3),
(22, 19, 13, 1, 'Medium', NULL, '2019-12-11', NULL, '2019-12-17', 3025.00, 13, 'Cash', '2019-12-11', '11:51:00', 'Delivered', 'Active', 'Pending', 0, '2019-12-11 10:51:46', 1, '2019-12-17 00:00:00', 3),
(23, 20, 13, 1, 'Medium', NULL, '2019-12-11', NULL, NULL, 3025.00, 20, 'Cash', '2019-12-11', '11:51:00', 'Pending', 'Active', 'Pending', 0, '2019-12-11 10:53:24', 1, '2019-12-17 03:53:04', NULL),
(24, 21, 14, 1, 'Low', NULL, '2019-12-11', NULL, '2019-12-11', 1325.00, 10, 'Cash', '2019-12-11', '12:53:00', 'Delivered', 'Active', 'Pending', 0, '2019-12-11 12:53:22', 1, '2019-12-11 00:00:00', 4),
(25, 21, 14, 1, 'Low', NULL, '2019-12-11', NULL, '2019-12-11', 2640.00, 11, 'Cash', '2019-12-11', '00:00:00', 'Delivered', 'Active', 'Pending', 0, '2019-12-11 13:04:14', 1, '2019-12-11 00:00:00', 4),
(26, 22, 15, 1, 'Low', NULL, '2019-12-16', NULL, NULL, 7410.00, 21, 'Cash', '2019-12-16', '18:15:00', 'Pending', 'Active', 'Pending', 0, '2019-12-16 18:15:07', 1, '2019-12-17 03:55:21', NULL),
(27, 23, 16, 7, 'Low', NULL, '2019-12-17', NULL, NULL, 40000.00, NULL, 'Cash', '2019-12-17', '17:15:00', 'Approved', 'Active', 'Pending', 1, '2019-12-17 14:15:21', 1, '2019-12-17 03:46:07', NULL),
(28, 3, 3, 1, 'Low', NULL, '2019-12-17', NULL, '2019-12-17', 2339.00, 27, 'Cash', '2019-12-17', '16:28:00', 'Delivered', 'Active', 'Partial', 1, '2019-12-17 14:28:47', 1, '2019-12-17 00:00:00', 3),
(29, 24, 17, 1, 'Low', NULL, '2019-12-17', NULL, '2019-12-17', 4148.00, 26, 'Cash', '2019-12-17', '16:33:00', 'Delivered', 'Active', 'Pending', 1, '2019-12-17 14:33:24', 1, '2019-12-17 00:00:00', 4),
(30, 4, 4, 1, 'Low', NULL, '2019-12-17', NULL, NULL, 49000.00, NULL, 'Cash', '2019-12-17', '00:00:00', 'Pending', 'Active', 'Pending', 0, '2019-12-17 14:34:56', 1, NULL, NULL),
(31, 4, 4, 1, 'Low', NULL, '2019-12-17', NULL, NULL, 49000.00, NULL, 'Cash', '2019-12-17', '00:00:00', 'Pending', 'Active', 'Pending', 0, '2019-12-17 14:34:57', 1, NULL, NULL),
(32, 21, 14, 1, 'Low', NULL, '2019-12-17', NULL, NULL, 1735.00, 39, 'Cash', '2019-12-17', '20:37:00', 'Approved', 'Active', 'Pending', 1, '2019-12-17 14:37:16', 1, '2019-12-17 05:29:49', NULL),
(33, 7, 7, 1, 'Low', NULL, '2019-12-17', NULL, '2019-12-17', 4805.00, 43, 'Cash', '2019-12-17', '00:00:00', 'Delivered', 'Active', 'Pending', 1, '2019-12-17 14:53:44', 1, '2019-12-18 03:07:35', 3),
(34, 10, 11, 1, 'Medium', NULL, '2019-12-17', NULL, NULL, 7775.00, NULL, 'Cash', '2019-12-17', '00:00:00', 'Approved', 'Active', 'Partial', 1, '2019-12-17 15:08:41', 1, '2019-12-18 03:07:21', NULL),
(35, 9, 10, 1, 'Urgent', NULL, '2019-12-17', NULL, NULL, 5219.00, 42, 'Cash', '2019-12-17', '00:00:00', 'Approved', 'Active', 'Pending', 1, '2019-12-17 15:34:01', 1, '2019-12-17 07:26:07', NULL),
(36, 8, 8, 1, 'Low', NULL, '2019-12-17', NULL, NULL, 10000.00, NULL, 'Cash', '2019-12-17', '22:57:00', 'Approval Required', 'Active', 'Pending', 1, '2019-12-17 16:57:28', 1, NULL, NULL),
(37, 8, 8, 1, 'Low', NULL, '2019-12-17', NULL, NULL, 10000.00, NULL, 'Cash', '2019-12-17', '22:57:00', 'Approved', 'Active', 'Pending', 1, '2019-12-17 16:57:28', 1, '2019-12-17 06:52:23', NULL),
(38, 8, 8, 1, 'Low', NULL, '2019-12-17', NULL, '2019-12-17', 10000.00, 40, 'Cash', '2019-12-17', '22:57:00', 'Delivered', 'Active', 'Pending', 1, '2019-12-17 16:57:29', 1, '2019-12-17 00:00:00', 3),
(39, 4, 4, 1, 'Low', NULL, '2019-12-17', NULL, NULL, 2270.00, NULL, 'Cash', '2019-12-17', '00:00:00', 'Approved', 'Active', 'Pending', 1, '2019-12-17 17:27:22', 1, '2019-12-17 06:59:43', NULL);

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
(1, 1, 1, 10, 20, 20, '200.00', '2019-12-05 14:26:27', 1, NULL, NULL),
(2, 1, 2, 10, 20, 20, '200.00', '2019-12-05 14:26:27', 1, NULL, NULL),
(3, 1, 4, 20, 5, 5, '100.00', '2019-12-05 14:26:27', 1, '2019-12-05 03:59:06', NULL),
(4, 2, 1, 40, 23.5, 23.5, '940.00', '2019-12-05 14:52:06', 1, '2019-12-05 04:22:34', NULL),
(5, 2, 2, 60, 20.6, 20.6, '1236.00', '2019-12-05 14:52:06', 1, '2019-12-05 04:22:34', NULL),
(6, 2, 5, 70, 5.5, 5.5, '385.00', '2019-12-05 14:52:06', 1, '2019-12-05 04:22:34', NULL),
(7, 3, 7, 8, 25, 25, '200.00', '2019-12-05 16:53:18', 1, '2019-12-05 06:23:45', NULL),
(8, 3, 5, 500, 5.5, 5.5, '2750.00', '2019-12-05 16:53:18', 1, '2019-12-05 06:23:45', NULL),
(9, 3, 3, 50, 18, 18, '900.00', '2019-12-05 16:53:18', 1, NULL, NULL),
(10, 3, 2, 5, 20, 20, '100.00', '2019-12-05 16:53:18', 1, NULL, NULL),
(11, 4, 1, 5, 25, 25, '125.00', '2019-12-05 18:19:39', 1, '2019-12-05 07:51:00', NULL),
(12, 4, 1, 8, 25, 25, '200.00', '2019-12-05 18:19:39', 1, '2019-12-05 07:51:00', NULL),
(13, 4, 1, 50, 25, 25, '1250.00', '2019-12-05 18:19:39', 1, '2019-12-05 07:51:00', NULL),
(14, 5, 1, 65, 24.5, 24.5, '1592.50', '2019-12-05 19:02:02', 1, '2019-12-05 08:34:40', NULL),
(15, 5, 7, 6, 25, 25, '150.00', '2019-12-05 19:02:02', 1, NULL, NULL),
(16, 6, 7, 9, 25, 25, '225.00', '2019-12-05 19:23:47', 1, NULL, NULL),
(17, 7, 7, 7, 24.5, 24.5, '171.50', '2019-12-06 11:33:12', 1, '2019-12-06 01:03:55', NULL),
(18, 7, 4, 10, 7, 7, '70.00', '2019-12-06 11:33:12', 1, NULL, NULL),
(19, 7, 3, 70, 15, 15, '1050.00', '2019-12-06 11:33:12', 1, '2019-12-06 01:03:55', NULL),
(20, 8, 1, 15, 265, 263, '3945.00', '2019-12-06 12:45:00', 1, NULL, NULL),
(21, 8, 2, 6, 245, 252, '1512.00', '2019-12-06 12:45:00', 1, NULL, NULL),
(22, 8, 4, 5, 165, 165, '825.00', '2019-12-06 12:45:00', 1, NULL, NULL),
(23, 9, 1, 5, 265, 265, '1325.00', '2019-12-06 12:49:02', 1, NULL, NULL),
(24, 9, 2, 8, 241, 241, '1928.00', '2019-12-06 12:49:02', 1, '2019-12-06 04:04:59', NULL),
(25, 10, 1, 50, 265, 265, '13250.00', '2019-12-06 13:51:03', 1, NULL, NULL),
(26, 10, 1, 10, 265, 265, '2650.00', '2019-12-06 13:51:03', 1, NULL, NULL),
(27, 10, 1, 100, 265, 265, '26500.00', '2019-12-06 13:51:03', 1, NULL, NULL),
(28, 11, 1, 5, 263, 263, '1315.00', '2019-12-09 11:19:10', 1, '2019-12-09 01:23:22', NULL),
(29, 11, 2, 8, 247, 247, '1976.00', '2019-12-09 11:19:10', 1, '2019-12-09 01:23:22', NULL),
(30, 11, 3, 4, 255, 255, '1020.00', '2019-12-09 11:19:10', 1, NULL, NULL),
(31, 11, 4, 70, 165, 165, '11550.00', '2019-12-09 11:19:10', 1, NULL, NULL),
(32, 12, 1, 3, 265, 265, '795.00', '2019-12-09 13:15:51', 1, NULL, NULL),
(33, 12, 2, 5, 245, 245, '1225.00', '2019-12-09 13:15:51', 1, NULL, NULL),
(34, 12, 7, 3, 25, 25, '75.00', '2019-12-09 13:15:51', 1, NULL, NULL),
(35, 12, 5, 8, 190, 190, '1520.00', '2019-12-09 13:15:51', 1, NULL, NULL),
(36, 12, 4, 9, 165, 165, '1485.00', '2019-12-09 13:15:51', 1, NULL, NULL),
(37, 13, 1, 1, 265, 265, '265.00', '2019-12-10 17:30:30', 1, NULL, NULL),
(38, 14, 1, 6, 265, 265, '1590.00', '2019-12-11 10:51:03', 1, NULL, NULL),
(39, 14, 2, 4, 245, 245, '980.00', '2019-12-11 10:51:03', 1, NULL, NULL),
(40, 14, 5, 2, 190, 190, '380.00', '2019-12-11 10:51:03', 1, NULL, NULL),
(41, 14, 7, 3, 25, 25, '75.00', '2019-12-11 10:51:03', 1, NULL, NULL),
(42, 15, 1, 6, 265, 265, '1590.00', '2019-12-11 10:51:25', 1, NULL, NULL),
(43, 15, 2, 4, 245, 245, '980.00', '2019-12-11 10:51:25', 1, NULL, NULL),
(44, 15, 5, 2, 190, 190, '380.00', '2019-12-11 10:51:25', 1, NULL, NULL),
(45, 15, 7, 3, 25, 25, '75.00', '2019-12-11 10:51:25', 1, NULL, NULL),
(46, 16, 1, 6, 265, 265, '1590.00', '2019-12-11 10:51:31', 1, NULL, NULL),
(47, 16, 2, 4, 245, 245, '980.00', '2019-12-11 10:51:31', 1, NULL, NULL),
(48, 16, 5, 2, 190, 190, '380.00', '2019-12-11 10:51:31', 1, NULL, NULL),
(49, 16, 7, 3, 25, 25, '75.00', '2019-12-11 10:51:31', 1, NULL, NULL),
(50, 17, 1, 6, 265, 265, '1590.00', '2019-12-11 10:51:32', 1, NULL, NULL),
(51, 17, 2, 4, 245, 245, '980.00', '2019-12-11 10:51:32', 1, NULL, NULL),
(52, 17, 5, 2, 190, 190, '380.00', '2019-12-11 10:51:32', 1, NULL, NULL),
(53, 17, 7, 3, 25, 25, '75.00', '2019-12-11 10:51:32', 1, NULL, NULL),
(54, 18, 1, 6, 265, 265, '1590.00', '2019-12-11 10:51:33', 1, NULL, NULL),
(55, 18, 2, 4, 245, 245, '980.00', '2019-12-11 10:51:33', 1, NULL, NULL),
(56, 18, 5, 2, 190, 190, '380.00', '2019-12-11 10:51:33', 1, NULL, NULL),
(57, 18, 7, 3, 25, 25, '75.00', '2019-12-11 10:51:33', 1, NULL, NULL),
(58, 19, 1, 6, 265, 265, '1590.00', '2019-12-11 10:51:34', 1, NULL, NULL),
(59, 19, 2, 4, 245, 245, '980.00', '2019-12-11 10:51:34', 1, NULL, NULL),
(60, 19, 5, 2, 190, 190, '380.00', '2019-12-11 10:51:34', 1, NULL, NULL),
(61, 19, 7, 3, 25, 25, '75.00', '2019-12-11 10:51:34', 1, NULL, NULL),
(62, 20, 1, 6, 265, 265, '1590.00', '2019-12-11 10:51:35', 1, NULL, NULL),
(63, 20, 2, 4, 245, 245, '980.00', '2019-12-11 10:51:35', 1, NULL, NULL),
(64, 20, 5, 2, 190, 190, '380.00', '2019-12-11 10:51:35', 1, NULL, NULL),
(65, 20, 7, 3, 25, 25, '75.00', '2019-12-11 10:51:35', 1, NULL, NULL),
(66, 21, 1, 6, 265, 265, '1590.00', '2019-12-11 10:51:37', 1, NULL, NULL),
(67, 21, 2, 4, 245, 245, '980.00', '2019-12-11 10:51:37', 1, NULL, NULL),
(68, 21, 5, 2, 190, 190, '380.00', '2019-12-11 10:51:37', 1, NULL, NULL),
(69, 21, 7, 3, 25, 25, '75.00', '2019-12-11 10:51:37', 1, NULL, NULL),
(70, 22, 1, 6, 265, 265, '1590.00', '2019-12-11 10:51:46', 1, NULL, NULL),
(71, 22, 2, 4, 245, 245, '980.00', '2019-12-11 10:51:46', 1, NULL, NULL),
(72, 22, 5, 2, 190, 190, '380.00', '2019-12-11 10:51:46', 1, NULL, NULL),
(73, 22, 7, 3, 25, 25, '75.00', '2019-12-11 10:51:46', 1, NULL, NULL),
(74, 23, 1, 6, 265, 265, '1590.00', '2019-12-11 10:53:24', 1, NULL, NULL),
(75, 23, 2, 4, 245, 245, '980.00', '2019-12-11 10:53:24', 1, NULL, NULL),
(76, 23, 5, 2, 190, 190, '380.00', '2019-12-11 10:53:24', 1, NULL, NULL),
(77, 23, 7, 3, 25, 25, '75.00', '2019-12-11 10:53:24', 1, NULL, NULL),
(78, 24, 1, 5, 265, 265, '1325.00', '2019-12-11 12:53:22', 1, NULL, NULL),
(79, 25, 1, 6, 265, 265, '1590.00', '2019-12-11 13:04:14', 1, NULL, NULL),
(80, 25, 7, 4, 25, 25, '100.00', '2019-12-11 13:04:14', 1, NULL, NULL),
(81, 25, 5, 5, 190, 190, '950.00', '2019-12-11 13:04:14', 1, NULL, NULL),
(82, 26, 1, 25, 265, 265, '6625.00', '2019-12-16 18:15:07', 1, NULL, NULL),
(83, 26, 2, 3, 245, 245, '735.00', '2019-12-16 18:15:07', 1, NULL, NULL),
(84, 26, 7, 2, 25, 25, '50.00', '2019-12-16 18:15:07', 1, NULL, NULL),
(85, 27, 1, 20, 2000, 2000, '40000.00', '2019-12-17 14:15:21', 1, '2019-12-17 03:46:07', NULL),
(86, 28, 1, 5, 267, 267, '1335.00', '2019-12-17 14:28:47', 1, '2019-12-17 04:45:06', NULL),
(87, 28, 2, 4, 251, 251, '1004.00', '2019-12-17 14:28:47', 1, '2019-12-17 04:45:06', NULL),
(88, 29, 1, 6, 261, 261, '1566.00', '2019-12-17 14:33:24', 1, '2019-12-17 04:04:53', NULL),
(89, 29, 2, 6, 247, 247, '1482.00', '2019-12-17 14:33:24', 1, '2019-12-17 04:04:53', NULL),
(90, 29, 5, 5, 198, 198, '990.00', '2019-12-17 14:33:24', 1, '2019-12-17 04:04:53', NULL),
(91, 29, 7, 5, 22, 22, '110.00', '2019-12-17 14:33:24', 1, '2019-12-17 04:04:53', NULL),
(92, 30, 1, 200, 245, 245, '49000.00', '2019-12-17 14:34:56', 1, NULL, NULL),
(93, 31, 1, 200, 245, 245, '49000.00', '2019-12-17 14:34:57', 1, NULL, NULL),
(94, 32, 4, 5, 167, 167, '835.00', '2019-12-17 14:37:16', 1, '2019-12-17 04:39:08', NULL),
(95, 32, 5, 4, 198, 198, '792.00', '2019-12-17 14:37:16', 1, '2019-12-17 04:39:08', NULL),
(96, 32, 7, 4, 27, 27, '108.00', '2019-12-17 14:37:16', 1, '2019-12-17 04:39:08', NULL),
(97, 33, 1, 9, 260, 260, '2340.00', '2019-12-17 14:53:44', 1, '2019-12-17 04:43:37', NULL),
(98, 33, 2, 6, 241.5, 241.5, '1449.00', '2019-12-17 14:53:44', 1, '2019-12-17 04:43:37', NULL),
(99, 33, 3, 4, 254, 254, '1016.00', '2019-12-17 14:53:44', 1, '2019-12-17 04:43:37', NULL),
(100, 34, 1, 10, 260, 260, '2600.00', '2019-12-17 15:08:41', 1, '2019-12-17 04:40:15', NULL),
(101, 34, 2, 5, 245, 245, '1225.00', '2019-12-17 15:08:41', 1, NULL, NULL),
(102, 34, 3, 6, 255, 255, '1530.00', '2019-12-17 15:08:41', 1, NULL, NULL),
(103, 34, 4, 8, 165, 165, '1320.00', '2019-12-17 15:08:41', 1, NULL, NULL),
(104, 34, 5, 5, 190, 190, '950.00', '2019-12-17 15:08:41', 1, NULL, NULL),
(105, 34, 7, 6, 25, 25, '150.00', '2019-12-17 15:08:41', 1, NULL, NULL),
(106, 35, 1, 4, 261, 261, '1044.00', '2019-12-17 15:34:01', 1, '2019-12-17 06:44:54', NULL),
(107, 35, 2, 6, 245, 245, '1470.00', '2019-12-17 15:34:01', 1, '2019-12-17 06:44:54', NULL),
(108, 35, 3, 4, 255, 255, '1020.00', '2019-12-17 15:34:01', 1, NULL, NULL),
(109, 35, 4, 5, 165, 165, '825.00', '2019-12-17 15:34:01', 1, NULL, NULL),
(110, 35, 5, 4, 190, 190, '760.00', '2019-12-17 15:34:01', 1, NULL, NULL),
(111, 35, 7, 4, 25, 25, '100.00', '2019-12-17 15:34:01', 1, NULL, NULL),
(112, 36, 1, 50, 265, 200, '10000.00', '2019-12-17 16:57:28', 1, NULL, NULL),
(113, 37, 1, 50, 200, 200, '10000.00', '2019-12-17 16:57:28', 1, '2019-12-17 06:52:23', NULL),
(114, 38, 1, 50, 200, 200, '10000.00', '2019-12-17 16:57:29', 1, '2019-12-17 06:29:05', NULL),
(115, 39, 1, 4, 245, 245, '980.00', '2019-12-17 17:27:22', 1, NULL, NULL),
(116, 39, 2, 5, 258, 258, '1290.00', '2019-12-17 17:27:22', 1, '2019-12-17 06:59:43', NULL);

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

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `client_id`, `payment_mode`, `check_no`, `check_date`, `transection_no`, `paid_amount`, `credit_balance_used`, `previous_credit_balance`, `new_credit_balance`, `created_at`, `created_by`) VALUES
(1, 1, 'Cash', NULL, NULL, NULL, '1000.00', '0.00', '0.00', '0.00', '2019-12-16 07:58:47', NULL),
(2, 7, 'Cash', NULL, NULL, NULL, '3253.00', '0.00', '0.00', '0.00', '2019-12-17 05:09:18', NULL),
(3, 3, 'Cash', NULL, NULL, NULL, '2500.00', '0.00', '0.00', '0.00', '2019-12-17 05:09:51', NULL),
(4, 10, 'Cheque', '12454664', '2019-12-04', NULL, '2000.00', '0.00', '0.00', '0.00', '2019-12-17 07:40:19', NULL),
(5, 10, 'Cheque', '121554', '2019-12-17', NULL, '5000.00', '0.00', '0.00', '0.00', '2019-12-17 07:41:37', NULL);

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

--
-- Dumping data for table `payment_details`
--

INSERT INTO `payment_details` (`id`, `order_id`, `payment_id`, `amount_used`, `credit_used`, `total_payment`, `status`) VALUES
(1, 1, 1, '500.00', '0.00', '500.00', 'PAID'),
(2, 3, 1, '500.00', '0.00', '500.00', 'PARTIAL'),
(3, 9, 2, '3253.00', '0.00', '3253.00', 'PAID'),
(4, 4, 3, '1575.00', '0.00', '1575.00', 'PAID'),
(5, 28, 3, '925.00', '0.00', '925.00', 'PARTIAL'),
(6, 12, 4, '2000.00', '0.00', '2000.00', 'PARTIAL'),
(7, 12, 5, '3100.00', '0.00', '3100.00', 'PAID'),
(8, 34, 5, '1900.00', '0.00', '1900.00', 'PARTIAL');

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
(1, 'Ashish', 'Makwana', 'ashish@gmail.com', '76752681245', 2, 's', 'admin', 'Active', 0, '2019-11-25 14:11:53', 2, '2019-12-06 17:53:35', 2),
(2, 'Devansh', 'Shah', 'admin@gmail.com', '8963015123', 1, 'admin', 'admin', 'Active', 0, '2019-11-25 14:12:28', 2, '2019-11-28 14:11:25', 2),
(3, 'Rakesh', 'Jangir', 'rakesh@gmail.com', '8963015144', 3, 'd', 'admin', 'Active', 0, '2019-11-25 14:13:01', 2, '2019-12-05 04:15:35', NULL),
(4, 'Ravi', 'Prajapati', 'ravi@gmail.com', '8963012121', 4, 'dr', 'admin', 'Active', 0, '2019-11-25 14:13:38', 2, '2019-12-05 04:15:49', NULL);

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
(144, 3, 'fUUm_AAKlXw:APA91bHHJG03k96jpU9dezNd3ddGS4M8olPt8OS2neL4zIMZSfYJL-OocY2nPR_C-odfUEkwfaqo0FrmNkZCfobCLbRM74fRrowUO0KrJIsxJukOsD9Pi1oslOhiIDRoH9z-taIiOITB', '2019-12-17 07:12:45'),
(150, 1, 'd-Xna5UbCQg:APA91bGLw_2jpqsvcIuPA03WA0Y5oq18V4-aqFwN_6FBUDmLuynK6MiFeAsGDnlmzuDTG37BokbDDKxFhCNkwOwnQ-CRVTmM1AlDhsmHKhuedLBKkj_XIDVRozrN494nwrh0JjLjFVnf', '2019-12-18 06:04:45'),
(151, 1, 'dsIcxv1Cfa0:APA91bGQZqoNRLtObz-MqVUlsiVVQyP1o5O-ryqTvQy242Eyl0ImcJqky46MLc0_G51UK14TeQP4CHHDh3-VyGnFM-gNxjCxawvY5DFnoR6ouk09FDlNhfvFBGQDLjV1lwb3OfAjXdj4', '2019-12-18 06:13:37');

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
(2, 3, 1, '2019-11-25 14:13:01', 2, NULL, NULL, 'Active'),
(3, 4, 1, '2019-11-25 14:13:38', 2, NULL, NULL, 'Active');

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
(1, 'Ahmedabad-1', 2, 3, '2019-11-25 13:04:38', 2, '2019-12-06 14:37:04', 2, 'Active'),
(2, 'Jaipur', 1, NULL, '2019-11-25 13:04:51', 2, '2019-12-05 14:30:05', 2, 'Active');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `client_location_images`
--
ALTER TABLE `client_location_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `client_product_inventory`
--
ALTER TABLE `client_product_inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `client_product_price`
--
ALTER TABLE `client_product_price`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=217;

--
-- AUTO_INCREMENT for table `client_selesmans`
--
ALTER TABLE `client_selesmans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `client_visits`
--
ALTER TABLE `client_visits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `coordinates`
--
ALTER TABLE `coordinates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `delivery`
--
ALTER TABLE `delivery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `delivery_config`
--
ALTER TABLE `delivery_config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `delivery_config_orders`
--
ALTER TABLE `delivery_config_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `delivery_routes`
--
ALTER TABLE `delivery_routes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `fcm_notifications`
--
ALTER TABLE `fcm_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `fcm_notification_user`
--
ALTER TABLE `fcm_notification_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;

--
-- AUTO_INCREMENT for table `group_to_zip_code`
--
ALTER TABLE `group_to_zip_code`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `leads`
--
ALTER TABLE `leads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `lead_visits`
--
ALTER TABLE `lead_visits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `mail_template`
--
ALTER TABLE `mail_template`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `order_delivery_images`
--
ALTER TABLE `order_delivery_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payment_details`
--
ALTER TABLE `payment_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_devices`
--
ALTER TABLE `user_devices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;

--
-- AUTO_INCREMENT for table `user_vehicle`
--
ALTER TABLE `user_vehicle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_zip_codes`
--
ALTER TABLE `user_zip_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_zip_code_groups`
--
ALTER TABLE `user_zip_code_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
