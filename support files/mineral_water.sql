-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 13, 2019 at 11:05 AM
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
  `credit_limit` decimal(14,2) DEFAULT '0.00',
  `credit_balance` float(10,2) NOT NULL DEFAULT '0.00',
  `email` varchar(300) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `address` varchar(500) DEFAULT NULL,
  `zip_code_id` int(11) DEFAULT NULL,
  `lead_id` int(11) DEFAULT NULL COMMENT 'leads.lead_id if client is converted from lead',
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Active' COMMENT 'Active/Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `first_name`, `last_name`, `credit_limit`, `credit_balance`, `email`, `phone`, `address`, `zip_code_id`, `lead_id`, `is_deleted`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`) VALUES
(1, 'Rakesh', NULL, '10000.00', 234.70, 'milans@letsenkindle.com', NULL, 'jaipur', NULL, NULL, 0, '2019-08-26 16:38:14', NULL, '2019-09-13 14:28:48', 2, 'Active'),
(2, 'test', 'test', '200.00', 0.00, 'test@test.com', NULL, 'test', 1, NULL, 0, '2019-08-26 17:05:10', 2, '2019-08-28 19:40:21', 2, 'Active'),
(3, 'Rakesh', 'Jangir', NULL, 0.00, 'rakeshpdate@test.com', '9351561626', 'Jangir', 2, NULL, 0, '2019-08-27 19:25:56', 0, '2019-09-12 18:15:28', 5, 'Active'),
(4, 'ravi', NULL, NULL, 0.00, 'rkj@test.com', NULL, NULL, NULL, NULL, 0, '2019-08-29 14:37:25', 2, '2019-08-29 16:33:19', 2, 'Active'),
(5, 'new client', 'Jangir', '125.00', 0.00, 'rakeshj@letsenkindle.com', '8963015122', 'Kanchan Bhoomi,\r\nAhmedabad', 3, NULL, 0, '2019-08-30 17:17:00', 0, '2019-09-11 13:13:15', 2, 'Active'),
(6, 'My New Client Updated', 'From Api', NULL, 0.00, 'api-test@test.com', '896301215', 'API Address', 2, NULL, 0, '2019-08-30 17:24:03', 5, '2019-08-30 19:12:05', 2, 'Active'),
(7, 'Chestha', 'Alling', '125.00', 0.00, 'testone@test.com', '9898656944', '9182 Maple Ave. \r\nMays Landing, NJ 08330\r\n', 3, NULL, 0, '2019-09-09 15:54:42', 2, '2019-09-09 15:56:06', 2, 'Active'),
(8, 'Mehul', 'Patel', NULL, 0.00, 'mehul@cms.com', NULL, 'Patel', 2, NULL, 0, '2019-09-12 18:08:18', 5, NULL, NULL, 'Active'),
(9, 'Milan', 'Soni', NULL, 0.00, 'sdasd@gmail.com', '5612231212', 'Soni', 2, NULL, 0, '2019-09-12 18:10:41', 5, NULL, NULL, 'Active');

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
(10, 3, '123', 'test', 'Yes', '2019-08-28 18:29:48', 2, '2019-08-28 18:29:48', 2, 'Active'),
(11, 6, '89899655236', 'Zahid', 'Yes', '2019-09-09 15:41:37', 2, '2019-09-09 15:41:45', 2, 'Active'),
(12, 7, '9898656944', 'Zahid', 'No', '2019-09-09 15:56:28', 2, NULL, NULL, 'Active'),
(13, 7, '2365896656', 'Jose', 'No', '2019-09-09 15:56:39', 2, NULL, NULL, 'Active'),
(14, 7, '2236658745', 'Miller', 'Yes', '2019-09-09 15:56:53', 2, '2019-09-09 15:56:53', 2, 'Active');

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
(1, 23.077271, 72.688545, 2, '2019-09-03 12:18:20', 2),
(2, 23.076164, 72.688629, 2, '2019-09-03 12:18:22', 2),
(3, 23.072769, 72.688805, 2, '2019-09-03 12:18:24', 2),
(4, 23.064569, 72.692154, 2, '2019-09-03 12:18:26', 2),
(5, 23.072546, 72.666924, 4, '2019-09-03 12:18:40', 4),
(6, 23.074766, 72.637520, 5, '2019-09-03 12:18:45', 5);

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
(25, 6, 4, '2019-08-27 16:23:48', 2, NULL, NULL, 'Active'),
(26, 12, 5, '2019-09-09 17:05:44', 2, NULL, NULL, 'Active'),
(27, 12, 6, '2019-09-09 17:05:44', 2, NULL, NULL, 'Active'),
(28, 12, 7, '2019-09-09 17:05:44', 2, NULL, NULL, 'Active');

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
-- Table structure for table `mail_template`
--

CREATE TABLE `mail_template` (
  `id` int(11) NOT NULL,
  `template_body` text CHARACTER SET utf8,
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
  `delivery_boy_id` int(11) DEFAULT NULL,
  `expected_delivery_date` date DEFAULT NULL,
  `actual_delivery_date` date DEFAULT NULL,
  `payable_amount` float(10,2) DEFAULT '0.00',
  `status` varchar(20) NOT NULL DEFAULT 'Active' COMMENT 'Active/Inactive',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `client_id`, `delivery_boy_id`, `expected_delivery_date`, `actual_delivery_date`, `payable_amount`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(4, 1, NULL, '2019-09-10', '2019-09-10', 2050.30, 'Active', '2019-09-09 11:47:59', 2, '2019-09-09 15:22:51', NULL),
(5, 5, NULL, NULL, NULL, 600.50, 'Active', '2019-09-09 12:01:09', 4, '2019-09-09 15:23:00', NULL),
(6, 1, NULL, NULL, NULL, 15.00, 'Active', '2019-09-11 18:27:41', 1, '2019-09-11 18:28:20', NULL);

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

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `actual_price`, `effective_price`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(3, 4, 1, 10, 10, 12, '2019-09-09 11:47:59', 1, '2019-09-09 13:39:44', NULL),
(4, 4, 2, 10, 12, 15, '2019-09-09 11:47:59', 1, '2019-09-09 13:39:47', NULL),
(5, 5, 1, 10, 10, 12, '2019-09-09 12:01:09', 1, NULL, NULL),
(6, 5, 2, 10, 12, 15, '2019-09-09 12:01:09', 1, NULL, NULL),
(7, 6, 2, 10, 12, 15, '2019-09-11 18:27:41', 1, NULL, NULL);

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
(25, 1, 'Cash', NULL, NULL, NULL, '200.00', '0.00', '0.00', '0.00', '2019-09-13 14:02:56', NULL),
(26, 1, 'Cash', NULL, NULL, NULL, '200.00', '0.00', '0.00', '0.00', '2019-09-13 14:02:56', NULL),
(27, 1, 'Cash', NULL, NULL, NULL, '1000.00', '0.00', '0.00', '34.70', '2019-09-13 14:04:44', NULL);

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
(23, 4, 25, '200.00', '0.00', '200.00', 'PARTIAL'),
(24, 4, 26, '200.00', '0.00', '200.00', 'PARTIAL'),
(25, 4, 27, '950.30', '0.00', '950.30', 'PARTIAL'),
(26, 6, 27, '15.00', '0.00', '15.00', 'PAID');

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
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `product_code`, `description`, `weight`, `dimension`, `cost_price`, `sale_price`, `status`, `is_deleted`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Bislery', 'BSLY-001', 'This is test', 20, '65x65', 10, 12, 'Active', 0, '2019-08-27 15:11:47', 2, '2019-09-13 12:59:04', 2),
(2, 'Kinley', 'KINLY-002', 'This is test', 20, '65x65', 10, 12, 'Active', 0, '2019-08-27 15:11:47', 2, '2019-09-13 12:59:37', 2),
(3, '500 ML Kinley', 'KNLY-001', 'Test', 50, '65x65', 40, 50, 'Active', 0, '2019-09-13 12:56:49', 2, NULL, NULL);

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
(2, 3, 'bg.jpg', 'bg_thumb.jpg', 1, '2019-09-13 12:56:49', 2, NULL, NULL),
(3, 1, 'Egreeting_logo.png', 'Egreeting_logo_thumb.png', 1, '2019-09-13 12:59:04', NULL, '2019-09-13 12:59:04', 2),
(4, 2, 'Flowchart.png', 'Flowchart_thumb.png', 1, '2019-09-13 12:59:37', NULL, '2019-09-13 12:59:37', 2);

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
  `system_name` varchar(255) DEFAULT NULL,
  `email_host` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `from_name` varchar(255) DEFAULT NULL,
  `reply_to` varchar(255) DEFAULT NULL,
  `reply_to_name` varchar(255) DEFAULT NULL,
  `maps_api_key` varchar(100) DEFAULT NULL,
  `node_server_url` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `system_name`, `email_host`, `username`, `password`, `from_name`, `reply_to`, `reply_to_name`, `maps_api_key`, `node_server_url`) VALUES
(1, 'Neervana', 'smtp.gmail.com', 'ehs.mehul@gmail.com', 'androiddev123', 'Mehul Patel', 'ehs.mehul@gmail.com', 'Mehul Patel', 'AIzaSyAORZjG4KZf9oLcCo4XbKFDExSCvpIHaDQ', 'http://172.16.3.123:3000');

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
(2, 'Admin', 'iStrator', 'admin@gmail.com', '1111111111', 1, 'admin', 'admin', 'Active', 0, '2019-08-26 14:13:06', NULL, '2019-08-29 19:18:46', 2),
(4, 'Snehal', 'Trapsya', 'snehalt@letsenkindle.com', '9166650505', 3, NULL, 'snehal', 'Active', 0, '2019-08-26 15:14:04', 2, '2019-09-09 15:38:18', 2),
(5, 'Mehul', 'Patel', 'mehulp@letsenkindle.com', '8401015275', 2, 'mehulp', 'mehul', 'Active', 0, '2019-08-27 13:02:44', 2, '2019-09-09 15:34:01', 2),
(6, 'Zahid', 'Mansuri', 'zahidm@letsenkindle.com', '2365589945', 2, 'zahidm', 'superman', 'Active', 0, '2019-09-09 18:00:00', 2, NULL, NULL);

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
(5, 5, 'cXt_bzvfRz0:APA91bGwXB29yBmI3QRhi2IMtN5m8_5o7TT28fx3y_IBcGZR8veF3ggTlDQOLy5EU5qrUSKXCYyOS5uEJSB1MmP3n34KS2W1ns0YtWAOfYK82ITVmvyCYLvu4QxGsWW4R5GTWeM_CVav', '2019-09-12 18:02:05'),
(6, 5, 'czxrD4Ybwn8:APA91bEy3MzhcjsPnQi4ZKLixR6LB4ut-YSRGEb9R1Q4DpJdqgOusC5wuqZNIeoujkK1lMMtDLUycBOZ44-95QWGZSLxNvnG0O-DGjwiqRcddazewgRkWrAOgcLpZT5j6VXu9-bgHtBn', '2019-09-13 10:21:22');

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
(20, 2, 3, '2019-08-29 19:18:46', 2, NULL, NULL, 'Active'),
(21, 5, 3, '2019-09-09 15:34:00', 2, NULL, NULL, 'Active'),
(22, 6, 4, '2019-09-09 18:00:00', 2, NULL, NULL, 'Active'),
(23, 6, 5, '2019-09-09 18:00:00', 2, NULL, NULL, 'Active'),
(24, 6, 6, '2019-09-09 18:00:00', 2, NULL, NULL, 'Active');

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
(1, 5, 2, '2019-09-09 15:34:00', 2, NULL, NULL, 'Active'),
(2, 5, 3, '2019-09-09 15:34:00', 2, NULL, NULL, 'Active'),
(3, 6, 12, '2019-09-09 18:00:00', 2, NULL, NULL, 'Active');

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
  `status` varchar(20) DEFAULT 'Active' COMMENT 'Active/Inactive',
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vehicle`
--

INSERT INTO `vehicle` (`id`, `name`, `number`, `capacity_in_ton`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`, `is_deleted`) VALUES
(1, 'Icher', 'RJ-13-EJ-7644', 50, '2019-08-27 15:59:31', NULL, '2019-09-11 18:31:33', 2, 'Active', 0),
(2, 'dsfdsf', 'rakesh', 100, '2019-08-27 15:59:31', NULL, '2019-08-29 17:58:07', 2, 'Active', 0),
(3, 'Honda Shine', 'rj23st1695', 2, '2019-08-27 16:16:15', 2, '2019-09-05 14:39:29', 2, 'Active', 0),
(4, 'Honda shine', 'GJ27CG2348', 0.2, '2019-09-09 17:28:37', 2, NULL, NULL, 'Active', 0),
(5, 'Chota haathi', 'GJ-32-AD-8856', 1.5, '2019-09-10 11:27:17', 2, '2019-09-10 11:27:25', 2, 'Active', 0);

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
(4, '332025', '2019-08-27 12:15:37', NULL, '2019-08-29 15:16:54', 2, 'Active'),
(5, '380001', '2019-09-09 16:38:04', 2, NULL, NULL, 'Active'),
(6, '380054', '2019-09-09 16:38:13', 2, NULL, NULL, 'Active'),
(7, '380002', '2019-09-09 16:38:20', 2, '2019-09-09 19:02:44', 2, 'Active'),
(8, '380003, 380004, 3800', '2019-09-09 19:03:08', 2, NULL, NULL, 'Active'),
(9, '380003, 380004, 3800', '2019-09-09 19:03:08', 2, NULL, NULL, 'Active'),
(10, '380021, 380022, 3800', '2019-09-09 19:03:42', 2, NULL, NULL, 'Active');

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
(11, 'aaaaaaaaaaaaaa', '2019-08-29 13:45:30', 2, '2019-08-29 14:46:23', 2, 'Active'),
(12, 'ahmedabad', '2019-09-09 17:05:43', 2, NULL, NULL, 'Active');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `client_contacts`
--
ALTER TABLE `client_contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `client_location_images`
--
ALTER TABLE `client_location_images`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `group_to_zip_code`
--
ALTER TABLE `group_to_zip_code`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `order_delivery_images`
--
ALTER TABLE `order_delivery_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `payment_details`
--
ALTER TABLE `payment_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_devices`
--
ALTER TABLE `user_devices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_vehicle`
--
ALTER TABLE `user_vehicle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_zip_codes`
--
ALTER TABLE `user_zip_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `user_zip_code_groups`
--
ALTER TABLE `user_zip_code_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `vehicle`
--
ALTER TABLE `vehicle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `zip_codes`
--
ALTER TABLE `zip_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `zip_code_groups`
--
ALTER TABLE `zip_code_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
