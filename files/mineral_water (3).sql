-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 03, 2019 at 01:52 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.3

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
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `first_name` varchar(200) DEFAULT NULL,
  `last_name` varchar(200) DEFAULT NULL,
  `credit_limit` float DEFAULT '0',
  `email` varchar(300) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `address` varchar(500) DEFAULT NULL,
  `zip_code_id` int(11) DEFAULT NULL,
  `lead_id` int(11) DEFAULT NULL COMMENT 'leads.lead_id if client is converted from lead',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Active' COMMENT 'Active/Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `first_name`, `last_name`, `credit_limit`, `email`, `phone`, `address`, `zip_code_id`, `lead_id`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`) VALUES
(1, 'Rakesh', 'Jagnir', 10000, 'rk@test.com', NULL, 'jaipur', NULL, NULL, '2019-08-26 16:38:14', NULL, '2019-08-29 17:23:34', 2, 'Active'),
(2, 'test', 'test', 200, 'test@test.com', NULL, 'test', 1, NULL, '2019-08-26 17:05:10', 2, '2019-08-28 19:40:21', 2, 'Active'),
(3, 'Rakesh', 'Jangir', 125, 'rakesh-api-update@test.com', NULL, 'test api', 3, NULL, '2019-08-27 19:25:56', 0, '2019-08-29 14:45:16', 2, 'Active'),
(4, 'ravi', NULL, NULL, 'rkj@test.com', NULL, NULL, NULL, NULL, '2019-08-29 14:37:25', 2, '2019-08-29 16:33:19', 2, 'Active'),
(5, 'new client', 'Jangir', 125, NULL, NULL, 'test api', 3, NULL, '2019-08-30 17:17:00', 0, NULL, NULL, 'Active'),
(6, 'My New Client Updated', 'From Api', NULL, 'api-test@test.com', '896301215', 'API Address', 2, NULL, '2019-08-30 17:24:03', 5, '2019-08-30 19:12:05', 2, 'Active');

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

--
-- Dumping data for table `client_contacts`
--

INSERT INTO `client_contacts` (`id`, `client_id`, `phone`, `person_name`, `is_primary`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`) VALUES
(1, 1, '8963015122', 'test person', 'No', '2019-08-26 17:44:48', NULL, '2019-08-30 16:08:07', 2, 'Active'),
(2, 1, '9166650505', 'test person two', 'No', '2019-08-26 17:44:48', NULL, '2019-08-30 16:08:11', 2, 'Active'),
(4, 1, '1234567891', 'test', 'No', '2019-08-26 18:44:53', 2, '2019-08-27 20:08:24', 2, 'Active'),
(5, 1, '123456', 'new', 'No', '2019-08-26 18:45:40', 2, '2019-08-29 13:09:21', 2, 'Active'),
(6, 1, '3333', 'test', 'No', '2019-08-26 18:48:51', 2, NULL, NULL, 'Active'),
(7, 2, '12345678', 'Rakesh', 'No', '2019-08-26 19:02:55', 2, NULL, NULL, 'Active'),
(8, 2, '89630', 'Milan', 'Yes', '2019-08-26 19:03:00', 2, '2019-08-26 19:03:04', 2, 'Active'),
(9, 1, '1231231231', 'api customer updated', 'No', '2019-08-27 20:08:24', 0, '2019-08-29 17:29:46', 0, 'Active'),
(10, 3, '123', 'test', 'Yes', '2019-08-28 18:29:48', 2, '2019-08-28 18:29:48', 2, 'Active');

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
-- Table structure for table `client_visits`
--

CREATE TABLE `client_visits` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
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

--
-- Dumping data for table `coordinates`
--

INSERT INTO `coordinates` (`id`, `lat`, `lng`, `user_id`, `created_at`, `created_by`) VALUES
(7, 23.067478, 72.488594, 2, '2019-09-03 17:08:02', 2),
(8, 23.067478, 72.487907, 2, '2019-09-03 17:08:51', 2),
(9, 23.084534, 72.484474, 2, '2019-09-03 17:08:58', 2),
(10, 23.086271, 72.486534, 2, '2019-09-03 17:10:00', 2),
(11, 23.091009, 72.477783, 2, '2019-09-03 17:10:08', 2),
(12, 23.096535, 72.468170, 2, '2019-09-03 17:10:12', 2),
(13, 23.096218, 72.456154, 2, '2019-09-03 17:10:16', 2),
(14, 23.094955, 72.434525, 2, '2019-09-03 17:10:20', 2),
(15, 23.082323, 72.412376, 2, '2019-09-03 17:10:24', 2),
(16, 23.081060, 72.409286, 2, '2019-09-03 17:10:27', 2),
(17, 23.079912, 72.860222, 5, '2019-09-03 17:13:07', 5),
(18, 23.076439, 72.710190, 5, '2019-09-03 17:13:16', 5),
(19, 23.077385, 72.734222, 5, '2019-09-03 17:13:23', 5),
(20, 23.077702, 72.715683, 5, '2019-09-03 17:13:27', 5),
(21, 23.076618, 72.711205, 5, '2019-09-03 17:13:36', 5),
(22, 23.077032, 72.692757, 5, '2019-09-03 17:13:43', 5),
(23, 23.076717, 72.696106, 2, '2019-09-03 17:14:04', 2);

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
(10, 3, 2, '2019-08-27 12:48:55', 2, NULL, NULL, 'Active'),
(12, 4, 2, '2019-08-27 12:49:26', 2, NULL, NULL, 'Active'),
(13, 1, 2, '2019-08-27 13:04:34', 2, NULL, NULL, 'Active'),
(14, 2, 3, '2019-08-27 13:04:38', 2, NULL, NULL, 'Active'),
(15, 1, 1, '2019-08-27 14:50:29', 2, NULL, NULL, 'Active'),
(16, 2, 2, '2019-08-27 14:50:33', 2, NULL, NULL, 'Active'),
(17, 3, 2, '2019-08-27 14:50:37', 2, NULL, NULL, 'Active'),
(18, 3, 3, '2019-08-27 14:50:37', 2, NULL, NULL, 'Active'),
(20, 1, 4, '2019-08-27 16:04:18', 2, NULL, NULL, 'Active'),
(21, 5, 1, '2019-08-27 16:22:44', 2, NULL, NULL, 'Active'),
(22, 6, 1, '2019-08-27 16:23:48', 2, NULL, NULL, 'Active'),
(23, 6, 2, '2019-08-27 16:23:48', 2, NULL, NULL, 'Active'),
(24, 6, 3, '2019-08-27 16:23:48', 2, NULL, NULL, 'Active'),
(25, 6, 4, '2019-08-27 16:23:48', 2, NULL, NULL, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `leads`
--

CREATE TABLE `leads` (
  `id` int(11) NOT NULL,
  `first_name` varchar(200) DEFAULT NULL,
  `last_name` varchar(200) DEFAULT NULL,
  `email` varchar(300) DEFAULT NULL,
  `is_converted` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lead_visits`
--

CREATE TABLE `lead_visits` (
  `id` int(11) NOT NULL,
  `lead_id` int(11) DEFAULT NULL,
  `visit_notes` varchar(500) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `expected_delivery_date` date DEFAULT NULL,
  `actual_delivery_date` date DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
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
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(300) DEFAULT NULL,
  `product_code` varchar(50) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `weight` float DEFAULT NULL,
  `dimension` varchar(100) DEFAULT NULL,
  `cost_price` float DEFAULT '0',
  `sale_price` float DEFAULT '0',
  `status` varchar(20) NOT NULL DEFAULT 'Active' COMMENT 'Active | Deactive',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `product_code`, `description`, `weight`, `dimension`, `cost_price`, `sale_price`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Bislery', 'B-101', 'This is test', 20, '65x65', 10, 12, 'Active', '2019-08-27 15:11:47', 2, '2019-08-27 15:12:13', 2);

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
(1, 1, 'Capture.PNG', 'Capture_thumb.PNG', 1, '2019-08-27 15:11:47', 2, NULL, NULL);

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
(3, 'Delivery Boy', '2019-08-26 14:12:22', NULL, NULL, NULL, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `email_host` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `from_name` varchar(255) DEFAULT NULL,
  `reply_to` varchar(255) DEFAULT NULL,
  `reply_to_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `email_host`, `username`, `password`, `from_name`, `reply_to`, `reply_to_name`) VALUES
(1, 'smtp.gmail.com', 'ehs.mehul@gmail.com', 'androiddev123', 'Mehul Patel', 'ehs.mehul@gmail.com', 'Mehul Patel');

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
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `phone`, `role_id`, `username`, `password`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(2, 'Admin', 'iStrator', 'admin@gmail.com', '1111111111', 1, 'admin', 'admin', 'Active', '2019-08-26 14:13:06', NULL, '2019-08-29 19:18:46', 2),
(4, 'Snehal', 'Trapsiya', 'snehalt@letsenkindle.com', '9166650505', 3, 'snehalt', 'snehal', 'Active', '2019-08-26 15:14:04', 2, '2019-08-29 19:17:09', 2),
(5, 'Mehul', 'Patel', 'mehulp@letsenkindle.com', '8401015275', 2, 'mehulp', 'mehul', 'Active', '2019-08-27 13:02:44', 2, '2019-08-29 19:17:09', 2);

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
(2, 5, '534245646546564', '2019-08-27 18:10:25'),
(3, 5, 'cH5zJEWBXCU:APA91bFP2Ad4qTzBtNarjryA-ro856ZRmGF9WwR59jMcDxAjXfj6nMpK-xeC_f7OzcV7nTgzSUl31JWo1sGEyANtnV7Lck1zlU1NGhN-uo0pTSsWVoxoixhAfa-6FTrMyoZDWG-wA1vE', '2019-08-29 16:50:04');

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
(16, 2, 2, '2019-08-27 18:39:07', 2, NULL, NULL, 'Active'),
(17, 5, 2, '2019-08-27 19:11:05', 2, NULL, NULL, 'Active'),
(18, 2, 4, '2019-08-29 17:23:44', 2, NULL, NULL, 'Active'),
(19, 2, 1, '2019-08-29 19:18:46', 2, NULL, NULL, 'Active'),
(20, 2, 3, '2019-08-29 19:18:46', 2, NULL, NULL, 'Active');

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

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

CREATE TABLE `vehicle` (
  `id` int(11) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `number` varchar(200) DEFAULT NULL,
  `capacity_in_ton` float DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Active' COMMENT 'Active/Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vehicle`
--

INSERT INTO `vehicle` (`id`, `name`, `number`, `capacity_in_ton`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`) VALUES
(1, 'test', 'test', 50, '2019-08-27 15:59:31', NULL, '2019-08-29 17:58:04', 2, 'Active'),
(2, 'dsfdsf', 'rakesh', 100, '2019-08-27 15:59:31', NULL, '2019-08-29 17:58:07', 2, 'Active'),
(3, NULL, 'rj23st1695', NULL, '2019-08-27 16:16:15', 2, '2019-08-29 11:52:40', 2, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `zip_codes`
--

CREATE TABLE `zip_codes` (
  `id` int(11) NOT NULL,
  `zip_code` varchar(20) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Active' COMMENT 'Active/Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zip_codes`
--

INSERT INTO `zip_codes` (`id`, `zip_code`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`) VALUES
(1, '380009', '2019-08-26 16:45:14', 2, '2019-08-26 18:15:32', 2, 'Active'),
(2, '3824301', '2019-08-26 18:15:25', 2, '2019-08-29 15:16:58', 2, 'Active'),
(3, '302012', '2019-08-27 12:15:37', NULL, '2019-08-29 15:21:06', 2, 'Active'),
(4, '332025', '2019-08-27 12:15:37', NULL, '2019-08-29 15:16:54', 2, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `zip_code_groups`
--

CREATE TABLE `zip_code_groups` (
  `id` int(11) NOT NULL,
  `group_name` varchar(200) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Active' COMMENT 'Active/Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zip_code_groups`
--

INSERT INTO `zip_code_groups` (`id`, `group_name`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`) VALUES
(1, 'test 1', '2019-08-27 14:50:29', 2, '2019-08-27 16:04:18', 2, 'Active'),
(2, 'test 2', '2019-08-27 14:50:33', 2, '2019-08-29 14:47:01', 2, 'Active'),
(3, 'test 3', '2019-08-27 14:50:37', 2, '2019-08-28 20:15:06', 2, 'Active'),
(4, 'sdasd', '2019-08-27 16:22:22', 2, NULL, NULL, 'Active'),
(5, 'testsdsdsd', '2019-08-27 16:22:32', 2, '2019-08-27 16:22:44', 2, 'Active'),
(6, 'milan', '2019-08-27 16:23:48', 2, NULL, NULL, 'Active'),
(7, 'sdfsdff', '2019-08-29 13:30:30', 2, NULL, NULL, 'Active'),
(8, 'test abcd', '2019-08-29 13:30:58', 2, NULL, NULL, 'Active'),
(9, 'ddd', '2019-08-29 13:41:18', 2, NULL, NULL, 'Active'),
(10, 'test', '2019-08-29 13:41:21', 2, NULL, NULL, 'Active'),
(11, 'aaaaaaaaaaaaaa', '2019-08-29 13:45:30', 2, '2019-08-29 14:46:23', 2, 'Active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lead_id` (`lead_id`);

--
-- Indexes for table `client_contacts`
--
ALTER TABLE `client_contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `client_location_images`
--
ALTER TABLE `client_location_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`);

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
-- Indexes for table `settings`
--
ALTER TABLE `settings`
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
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `client_contacts`
--
ALTER TABLE `client_contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `client_location_images`
--
ALTER TABLE `client_location_images`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `group_to_zip_code`
--
ALTER TABLE `group_to_zip_code`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

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
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `user_zip_code_groups`
--
ALTER TABLE `user_zip_code_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicle`
--
ALTER TABLE `vehicle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `zip_codes`
--
ALTER TABLE `zip_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `zip_code_groups`
--
ALTER TABLE `zip_code_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
