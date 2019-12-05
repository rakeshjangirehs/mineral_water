-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2019 at 02:09 PM
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
(4, 'Aquafina', '2019-11-25 13:34:48', 2, '2019-12-02 19:22:43', 2, 'Active', 1),
(5, 'dsfsdfsdfsdsfsdfsdfsdsfsdfsdfsdsfsdfsdfsdsfsdfsdfsdsfsdfsdfsdsfsdfsdfsdsfsdfsdfsdsfsdfsdfsdsfsdfsdfsdsfsdfsdfsdsfsdfsdfsdsfsdfsdfsdsfsdfsdfsdsfsdfsdfsdsfsdfsdfsdsfsdfsdfsdsfsdfsdfsdsfsdfsdfsdfdfdf', '2019-11-26 14:31:50', 2, '2019-11-26 14:32:37', 2, 'Active', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cash_collection`
--

CREATE TABLE `cash_collection` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `amount` float DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 = Deleted',
  `created_at` datetime DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
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
  `gst_no` varchar(50) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `lead_id` int(11) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `address` varchar(500) DEFAULT NULL,
  `zip_code_id` int(11) DEFAULT NULL,
  `lat` float(9,6) DEFAULT NULL,
  `lng` float(9,6) DEFAULT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Active' COMMENT 'Active/Inactive	'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
-- Table structure for table `client_product_inventory`
--

CREATE TABLE `client_product_inventory` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `existing_quentity` int(11) DEFAULT 0,
  `new_delivered` int(11) NOT NULL DEFAULT 0,
  `empty_collected` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Active' COMMENT 'Active/Inactive'
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

-- --------------------------------------------------------

--
-- Table structure for table `fcm_notifications`
--

CREATE TABLE `fcm_notifications` (
  `id` int(11) NOT NULL,
  `message` varchar(500) DEFAULT NULL,
  `response` varchar(500) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Active' COMMENT 'Active/Inactive '
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fcm_notification_user`
--

CREATE TABLE `fcm_notification_user` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `notification_id` int(11) DEFAULT NULL,
  `is_read` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Active' COMMENT 'Active/Inactive '
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

-- --------------------------------------------------------

--
-- Table structure for table `mail_template`
--

CREATE TABLE `mail_template` (
  `id` int(11) NOT NULL,
  `template_body` text CHARACTER SET utf8 DEFAULT NULL,
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
  `manage_stock_needed` tinyint(4) NOT NULL DEFAULT 0 COMMENT 'Do we need to manage stock for this product.',
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

INSERT INTO `products` (`id`, `brand_id`, `product_name`, `product_code`, `description`, `weight`, `dimension`, `cost_price`, `sale_price`, `manage_stock_needed`, `status`, `is_deleted`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 2, 'Bisleri Pet Bottle', 'BIS-1', '', 1, '12*4*4', 12, 20, 0, 'Active', 0, '2019-11-25 14:00:43', 2, '2019-12-03 14:34:10', NULL),
(2, 4, 'Aquafina 1 Ltr', 'AQ - 1', '', 1, '5*3*10', 12, 20, 0, 'Active', 0, '2019-11-25 14:01:23', 2, NULL, NULL),
(3, 3, 'Evian 1 Ltr', 'EV -1', '', 1, '5*3*10', 14, 18, 0, 'Active', 0, '2019-11-25 14:02:03', 2, NULL, NULL),
(4, 2, 'Bilery 250ml', 'BS-250', '', 250, '7*4*4', 3, 7, 1, 'Active', 0, '2019-11-25 14:03:09', 2, '2019-12-03 18:33:39', NULL),
(5, 1, 'Evian 250 ml', 'Ev-250', '', 250, '7*4*4', 3, 5, 0, 'Active', 0, '2019-11-25 14:03:45', 2, '2019-12-02 20:21:42', 2),
(6, 1, 'test', 'te', '', 0, 'd', 5, 5, 0, 'Active', 1, '2019-11-25 14:04:51', 2, '2019-11-25 14:05:01', NULL),
(7, 1, 'df', '33', 'dfd', 3.15, '3', 22.4, 343.4, 0, 'Active', 0, '2019-11-28 17:26:20', 2, NULL, NULL),
(8, 1, 'Test Product zahid', 'test', 'test', 45, '5*3*10', 45, 18, 0, 'Active', 0, '2019-12-04 12:38:18', 2, '2019-12-04 13:34:49', 2),
(9, 3, 'test aaa', 'test aaa', 'test', 45, 'd', 45, 45, 0, 'Active', 0, '2019-12-04 13:42:52', 2, '2019-12-04 13:43:19', 2);

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
(5, 5, 'Evian-330ml-Natural-Mineral-Water-Bottle-Plastic-1.jpg', 'Evian-330ml-Natural-Mineral-Water-Bottle-Plastic-1_thumb.jpg', 1, '2019-11-25 14:03:45', 2, NULL, NULL),
(7, 8, '6e0cc9e6-3fae-4f5b-9ae3-805cdc1e72b7.jfif', '6e0cc9e6-3fae-4f5b-9ae3-805cdc1e72b7_thumb.jfif', 1, '2019-12-04 13:34:49', NULL, '2019-12-04 13:34:49', 2),
(8, 9, '500ml-mineral-water-bottle-500x5001.jpg', '500ml-mineral-water-bottle-500x5001_thumb.jpg', 1, '2019-12-04 13:43:19', 2, NULL, NULL);

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
  `type` varchar(50) DEFAULT NULL COMMENT 'price_scheme,product_order_scheme',
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
(1, 'Get 5% discount on purchase of 1000', 'Get 5% discount on purchase of 1000', '2019-11-25', '2020-01-16', 'price_scheme', 500, 'cash_benifit', 'percentage', 5, NULL, NULL, NULL, NULL, '2019-11-25 14:15:56', 2, '2019-12-03 11:28:25', 2, 'Active', 0),
(2, 'Get 1 bottle free on purchase of 10 qty of Bilery-1ltr', 'Get 50 of on purchase of 50 qty of Bilery-1ltr', '2019-11-25', '2020-01-23', 'product_order_scheme', NULL, 'cash_benifit', 'amount', 100, NULL, 'all', NULL, NULL, '2019-11-25 14:17:13', 2, '2019-12-03 11:27:35', 2, 'Active', 0),
(7, 'free product', NULL, '2019-12-03', '2020-01-31', 'price_scheme', 500, 'free_product', NULL, NULL, NULL, NULL, 3, 2, '2019-12-03 11:29:01', 2, NULL, NULL, 'Active', 0);

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

--
-- Dumping data for table `user_devices`
--

INSERT INTO `user_devices` (`id`, `user_id`, `device_id`, `created_at`) VALUES
(1, 1, 'abcd', '2019-12-02 17:10:58'),
(2, 1, 'abcd', '2019-12-02 17:11:21'),
(3, 2, 'abcd', '2019-12-02 17:11:21');

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
(4, 'Honda CD Deluxe', 'GJ03DF1212', 20, '2019-11-25 13:07:33', 2, '2019-12-02 20:23:33', 2, 'Active', 0),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT for table `client_product_inventory`
--
ALTER TABLE `client_product_inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `client_product_price`
--
ALTER TABLE `client_product_price`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `delivery_config`
--
ALTER TABLE `delivery_config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `delivery_config_orders`
--
ALTER TABLE `delivery_config_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `delivery_routes`
--
ALTER TABLE `delivery_routes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fcm_notifications`
--
ALTER TABLE `fcm_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `fcm_notification_user`
--
ALTER TABLE `fcm_notification_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `group_to_zip_code`
--
ALTER TABLE `group_to_zip_code`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `leads`
--
ALTER TABLE `leads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lead_visits`
--
ALTER TABLE `lead_visits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mail_template`
--
ALTER TABLE `mail_template`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_delivery_images`
--
ALTER TABLE `order_delivery_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `schemes`
--
ALTER TABLE `schemes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
