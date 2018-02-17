-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 06, 2018 at 01:25 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `computer_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `accessories`
--

CREATE TABLE `accessories` (
  `id` int(11) UNSIGNED NOT NULL,
  `active` tinyint(2) UNSIGNED NOT NULL,
  `slug` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `accessories`
--

INSERT INTO `accessories` (`id`, `active`, `slug`, `name`, `created`, `updated`) VALUES
(1, 1, 'Xperie_set', 'Xperie set', '2018-01-06 00:00:00', '2018-01-19 13:30:15'),
(2, 1, 'Geforece_set', 'Geforece set', '2018-01-06 00:00:00', '2018-01-19 13:30:15'),
(3, 1, 'amd-v212-set', 'AMD V212 Set', '2018-02-02 08:16:32', '2018-02-02 08:16:32');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(11) UNSIGNED NOT NULL,
  `image_id` int(11) DEFAULT NULL,
  `active` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `slug` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `short_content` varchar(255) DEFAULT NULL,
  `content` text,
  `term` text,
  `meta_title` text,
  `meta_description` text,
  `meta_keyword` text,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `image_id`, `active`, `slug`, `name`, `short_content`, `content`, `term`, `meta_title`, `meta_description`, `meta_keyword`, `created`, `updated`) VALUES
(1, 29, 1, 'dell', 'Dell', 'Dell is international brand, famouse about their high quality monitor, pc, laptop etc', 'lorem ipsum this could be a very long and boring text but i do not write now 5k character here, i hope someone can forgive me for this.', 'Licence and guarantee term coming here, maybe i need a content writer because i am not good story teller.', 'Dell', 'Dell, Pc, Laptop, Monitor', 'Dell, Pc, Laptop, Monitor', '2018-01-10 00:00:00', '2018-01-16 09:31:34'),
(3, 46, 1, 'amd', 'Amd', 'Amd is international brand, famouse about their high quality monitor, pc, laptop etc', 'lorem ipsum this could be a very long and boring text but i do not write now 5k character here, i hope someone can forgive me for this.', 'Licence and guarantee term coming here, maybe i need a content writer because i am not good story teller.', 'Amd', 'Amd, Pc, Laptop, Monitor', 'Amd, Pc, Laptop, Monitor', '2018-01-10 00:00:00', '2018-02-01 08:06:28'),
(4, 47, 1, 'asus', 'Asus', 'dfg dfg', ' dfg dd ', ' dfgdf g', 'dfgdfg', ' dfgd', 'dg dfg', '2018-01-17 07:19:24', '2018-02-01 08:07:11'),
(5, 48, 1, 'crucial', 'Crucial', 'fgh', 'fhfgh', 'gfhfg', 'vbnvb', 'nvbnvb', 'nvbnvbn', '2018-01-17 07:30:00', '2018-02-01 08:09:12'),
(6, 49, 1, 'kingstone', 'Kingstone', 'asd', 'asd', 'asd', 'asda', 'sdasd', 'as asd', '2018-01-24 09:44:28', '2018-02-01 08:44:03'),
(7, 50, 1, 'microsoft', 'Microsoft', 'dsf', 'sdfsd', 'fsdf', 'asda', 'asd a', 'sd asd', '2018-01-24 10:00:11', '2018-02-01 09:05:51'),
(8, 51, 1, 'razer', 'Razer', NULL, NULL, NULL, 'sdf', 'sdf', 'sdf', '2018-02-01 09:15:19', '2018-02-01 09:15:19'),
(9, 52, 1, 'logitech', 'Logitech', NULL, NULL, NULL, 'dsf', 'sdfsd', 'fsdf', '2018-02-01 09:20:06', '2018-02-01 09:20:06'),
(10, 53, 1, 'intel', 'Intel', '', '', '', 'rer', 'tert', 'erte', '2018-02-02 07:02:53', '2018-02-02 07:03:41'),
(11, 54, 1, 'nvidia', 'NVidia', NULL, NULL, NULL, 'dasdas', 'asd', 'asda', '2018-02-02 07:04:08', '2018-02-02 07:04:08'),
(12, 55, 1, 'ati', 'Ati', NULL, NULL, NULL, 'sdfs', 'dfs', 'dfsd', '2018-02-02 07:04:46', '2018-02-02 07:04:46'),
(13, 56, 1, 'corsair', 'Corsair', NULL, NULL, NULL, 'sdf', 'sdf', 'sdf', '2018-02-02 14:20:23', '2018-02-02 14:20:23'),
(14, 57, 1, 'canon', 'Canon', NULL, NULL, NULL, 'fgd', 'fgd', 'fgd', '2018-02-02 14:20:36', '2018-02-02 14:20:36'),
(15, 58, 1, 'kaspersky', 'Kaspersky', NULL, NULL, NULL, 'fdgd', 'dfgdf', 'dg', '2018-02-02 14:20:59', '2018-02-02 14:20:59'),
(26, 91, 1, 'sdf', 'sdf', NULL, NULL, NULL, 'fdsf', '', '', '2018-02-04 18:06:28', '2018-02-04 18:06:28');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) UNSIGNED NOT NULL,
  `parent_id` int(11) UNSIGNED DEFAULT '0',
  `order` int(11) DEFAULT '0',
  `active` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `slug` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `parent_id`, `order`, `active`, `slug`, `name`, `created`, `updated`) VALUES
(1, 0, 4, 1, 'desktop_pc', 'Desktop PC', '2018-01-07 20:58:00', '2018-02-02 15:53:41'),
(2, 0, 8, 1, 'laptop_and_acc', 'Laptop & Acc.', '2018-01-07 20:58:00', '2018-02-02 15:53:41'),
(3, 0, 11, 1, 'printer', 'Printer', '2018-01-07 20:58:00', '2018-01-23 11:37:28'),
(4, 0, 21, 1, 'server_network', 'Server & Network', '2018-01-07 20:58:00', '2018-01-18 13:13:09'),
(5, 0, 0, 1, 'software', 'Software', '2018-01-07 20:58:00', '2018-02-02 15:53:41'),
(6, 0, 32, 1, 'pc_component', 'PC Component', '2018-01-07 20:58:00', '2018-01-18 12:44:29'),
(7, 0, 45, 1, 'pc_peripheral', 'PC Peripheral', '2018-01-07 20:58:00', '2018-01-18 12:44:29'),
(8, 0, 55, 1, 'laptop_accessory', 'Laptop Accessory', '2018-01-07 20:58:00', '2018-01-18 12:44:29'),
(9, 1, 5, 1, 'pc_system', 'PC System', '2018-01-07 20:58:00', '2018-02-02 15:53:41'),
(10, 1, 6, 1, 'monitor', 'Monitors', '2018-01-07 20:58:00', '2018-02-02 15:53:41'),
(11, 1, 7, 1, 'refurbished_pc', 'Refurbished PC', '2018-01-07 20:58:00', '2018-02-02 15:53:41'),
(12, 2, 9, 1, 'laptop', 'Laptop', '2018-01-07 20:58:00', '2018-02-02 15:53:41'),
(13, 2, 10, 0, 'refurbished_laptop', 'Refurbished Laptop', '2018-01-07 20:58:00', '2018-02-02 15:53:41'),
(14, 3, 12, 1, 'laser_printer', 'Laser Printer', '2018-01-07 20:58:00', '2018-01-23 11:37:28'),
(15, 3, 13, 1, 'inkjet_printer', 'Inkjet Printer', '2018-01-07 20:58:00', '2018-01-23 11:37:28'),
(16, 3, 14, 1, 'other_printer', 'Other Printers', '2018-01-07 20:58:00', '2018-01-23 11:37:28'),
(17, 3, 15, 1, 'fax', 'Faxs', '2018-01-07 20:58:00', '2018-01-23 11:37:28'),
(18, 3, 16, 1, 'scanner', 'Scanners', '2018-01-07 20:58:00', '2018-01-23 11:37:28'),
(19, 3, 17, 1, 'printer_supplies', 'Printer Supplies', '2018-01-07 20:58:00', '2018-01-23 11:37:28'),
(20, 3, 18, 1, 'accessory', 'Accessories', '2018-01-07 20:58:00', '2018-01-23 11:37:28'),
(21, 4, 22, 1, 'complete_server', 'Complete_Servers', '2018-01-07 20:58:00', '2018-01-19 08:12:33'),
(22, 4, 23, 1, 'server_hdd', 'Server Hard Disc', '2018-01-07 20:58:00', '2018-01-19 08:12:33'),
(23, 4, 25, 1, 'server_memory', 'Server Memory', '2018-01-07 20:58:00', '2018-01-19 08:12:26'),
(24, 4, 24, 1, 'server_processor', 'Server Processor', '2018-01-07 20:58:00', '2018-01-19 08:12:33'),
(25, 4, 26, 1, 'server_power_supply', 'Server Power Supply', '2018-01-07 20:58:00', '2018-01-18 13:13:09'),
(26, 4, 27, 1, 'server_accessory', 'Server Accessory', '2018-01-07 20:58:00', '2018-01-18 13:13:09'),
(27, 4, 28, 1, 'ups', 'UPS', '2018-01-07 20:58:00', '2018-01-18 13:13:09'),
(28, 4, 29, 1, 'router', 'Router', '2018-01-07 20:58:00', '2018-01-18 13:13:09'),
(29, 4, 30, 1, 'network_card', 'Network Card', '2018-01-07 20:58:00', '2018-01-18 13:13:09'),
(30, 4, 31, 1, 'cables', 'Cable & Accessory', '2018-01-07 20:58:00', '2018-01-18 13:13:09'),
(31, 5, 1, 1, 'operating_system', 'Op. System', '2018-01-07 20:58:00', '2018-02-02 15:53:41'),
(32, 5, 2, 1, 'office_others', 'Office & Other Apps.', '2018-01-07 20:58:00', '2018-02-02 15:53:41'),
(33, 5, 3, 1, 'antivirus', 'Antivirus', '2018-01-07 20:58:00', '2018-02-02 15:53:41'),
(34, 6, 33, 1, 'motherboard', 'Motherboard', '2018-01-07 20:58:00', '2018-01-18 12:44:29'),
(35, 6, 34, 1, 'video_card', 'Video Card & Coolers', '2018-01-07 20:58:00', '2018-01-18 12:44:29'),
(36, 6, 35, 1, 'sound_card', 'Sound Card', '2018-01-07 20:58:00', '2018-01-18 12:44:29'),
(37, 6, 36, 1, 'memory', 'Memory', '2018-01-07 20:58:00', '2018-01-18 12:44:29'),
(38, 6, 37, 1, 'processor', 'Processor', '2018-01-07 20:58:00', '2018-01-18 12:44:29'),
(39, 6, 38, 1, 'hard_disc', 'Hard Disc', '2018-01-07 20:58:00', '2018-01-18 12:44:29'),
(40, 6, 39, 1, 'ssd_hard_disc', 'SSD Hard Disc', '2018-01-07 20:58:00', '2018-01-18 12:44:29'),
(41, 6, 40, 1, 'pc_box_case', 'PC Box Case', '2018-01-07 20:58:00', '2018-01-18 12:44:29'),
(42, 6, 41, 1, 'power_supply', 'Power Supply', '2018-01-07 20:58:00', '2018-01-18 12:44:29'),
(43, 6, 42, 1, 'optical_unit', 'Optical Unit', '2018-01-07 20:58:00', '2018-01-18 12:44:29'),
(44, 6, 43, 1, 'cooler', 'Cooler', '2018-01-07 20:58:00', '2018-01-18 12:44:29'),
(45, 6, 44, 1, 'rank', 'Rack', '2018-01-07 20:58:00', '2018-01-18 12:44:29'),
(46, 7, 46, 1, 'keyboard', 'Keyboard', '2018-01-07 20:58:00', '2018-01-18 12:44:29'),
(47, 7, 47, 1, 'mouse', 'Mouse', '2018-01-07 20:58:00', '2018-01-18 12:44:29'),
(48, 7, 48, 1, 'mousepad', 'Mousepad', '2018-01-07 20:58:00', '2018-01-18 12:44:29'),
(49, 7, 49, 1, 'external_hard_disc', 'Ex. Hard Disc', '2018-01-07 20:58:00', '2018-01-18 12:44:29'),
(50, 7, 50, 1, 'external_ssd', 'Ex. SSD Hard Disc', '2018-01-07 20:58:00', '2018-01-18 12:44:29'),
(51, 7, 51, 1, 'external_optical_unit', 'Ex. Optical Unit', '2018-01-07 20:58:00', '2018-01-18 12:44:29'),
(52, 7, 52, 1, 'speaker', 'Speaker', '2018-01-07 20:58:00', '2018-01-18 12:44:29'),
(53, 7, 53, 1, 'usb_stick', 'USB Stick', '2018-01-07 20:58:00', '2018-01-18 12:44:29'),
(54, 7, 54, 1, 'web_camera', 'Web Camera', '2018-01-07 20:58:00', '2018-01-18 12:44:29'),
(55, 8, 56, 1, 'stand_cooler', 'Stand & Cooler', '2018-01-07 20:58:00', '2018-01-18 12:44:29'),
(56, 8, 57, 1, 'bag_case', 'Bag & Case', '2018-01-07 20:58:00', '2018-01-18 12:44:29'),
(57, 8, 58, 1, 'power_supply_battery', 'Power Supply & Battery', '2018-01-07 20:58:00', '2018-01-18 12:44:29'),
(58, 8, 59, 1, 'hard_disc', 'Hard Disc', '2018-01-07 20:58:00', '2018-01-18 12:44:29'),
(59, 8, 60, 1, 'laptop_memory', 'Laptop Memory', '2018-01-07 20:58:00', '2018-01-18 12:44:29');

-- --------------------------------------------------------

--
-- Table structure for table `classifications`
--

CREATE TABLE `classifications` (
  `id` int(11) UNSIGNED NOT NULL,
  `active` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `brand_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `category_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `slug` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `meta_title` text,
  `meta_description` text,
  `meta_keyword` text,
  `created` datetime DEFAULT NULL,
  `updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `classifications`
--

INSERT INTO `classifications` (`id`, `active`, `brand_id`, `category_id`, `slug`, `name`, `meta_title`, `meta_description`, `meta_keyword`, `created`, `updated`) VALUES
(1, 1, 10, 38, 'pentium-4', 'Pentium 4', 'f ghfgh f', 'gh fgh gf', 'fffffffffffffffh fgh f', '2018-01-02 00:00:00', '2018-02-02 07:15:39'),
(2, 1, 10, 38, 'celeron', 'Celeron', 'fgh fhf', ' fghfg hfg', 'h fghf gh', '2018-01-02 00:00:00', '2018-02-02 07:15:57'),
(3, 1, 10, 38, 'i3-core', 'i3 Core', 'dgf', 'gdfg', 'df', '2018-02-02 07:06:08', '2018-02-02 07:16:11'),
(4, 1, 10, 38, 'i5-core', 'i5 Core', 'ret', 'ert', 'ert', '2018-02-02 07:06:23', '2018-02-02 07:16:53'),
(5, 1, 8, 38, 'i7-core', 'i7 Core', 'sdfs', 'dfs', 'dfs', '2018-02-02 07:07:36', '2018-02-02 07:24:53'),
(6, 1, 0, 1, 'ddr2_pc', 'DDR2 PC', 'asd', 'asdas', 'asdas', '2018-02-02 07:50:33', '2018-02-02 07:50:58'),
(7, 1, 0, 0, 'ddr3_pc', 'DDR3 PC', 'fdgdf', 'gdfg', 'dfgd', '2018-02-02 07:51:31', '2018-02-02 07:51:31'),
(8, 1, 0, 1, 'ddr4_pc', 'DDR4 PC', 'sdsf', 'sdfs', 'sdf', '2018-02-02 07:52:35', '2018-02-02 07:53:13'),
(9, 1, 0, 1, 'ddr2_laptop', 'DDR2 Laptop', 'asd', 'asdas', 'asdas', '2018-02-02 07:50:33', '2018-02-02 07:50:58'),
(10, 1, 0, 0, 'ddr3_laptop', 'DDR3 Laptop', 'fdgdf', 'gdfg', 'dfgd', '2018-02-02 07:51:31', '2018-02-02 07:51:31'),
(11, 1, 0, 1, 'ddr4_laptop', 'DDR4_laptop', 'sdsf', 'sdfs', 'sdf', '2018-02-02 07:52:35', '2018-02-02 07:53:13'),
(12, 1, 3, 0, '2-amd-core', '2 Core AMD', 'asd', 'asd', 'asd', '2018-02-02 08:01:20', '2018-02-02 08:01:20'),
(13, 1, 3, 0, '3-core-amd', '3 Core AMD', 'asd', 'asd', 'asd', '2018-02-02 08:01:20', '2018-02-02 08:01:20'),
(14, 1, 3, 0, '4-core-amd', '4 Core AMD', 'asd', 'asd', 'asd', '2018-02-02 08:01:20', '2018-02-02 08:01:20'),
(15, 1, 3, 0, '6-core-amd', '6 Core AMD', 'asd', 'asd', 'asd', '2018-02-02 08:01:20', '2018-02-02 08:01:20'),
(16, 1, 3, 0, '8-core-amd', '8 Core AMD', 'asd', 'asd', 'asd', '2018-02-02 08:01:20', '2018-02-02 08:01:20');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) UNSIGNED NOT NULL,
  `country_id` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(2) UNSIGNED NOT NULL DEFAULT '1',
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT '',
  `message` text,
  `status` tinyint(4) UNSIGNED DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `country_id`, `active`, `name`, `phone`, `email`, `message`, `status`, `created`, `updated`) VALUES
(9, NULL, 1, 'kis pista', '', 'shadowvzs@hotmail.com', 'sdfsd fsd sdf', 0, '2018-01-09 15:09:52', '2018-01-09 15:09:52'),
(10, NULL, 1, 'kis gyurka', '', 'shadowvzs@hotmail.com', 'sdfsd fsd sdf', 0, '2018-01-09 15:09:52', '2018-01-09 15:09:52'),
(11, NULL, 1, 'sdfsdf s', '0456546', 'asda@asda.asd', 'sdasdasd', 0, '2018-01-31 10:00:43', '2018-01-31 10:00:43');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(11) UNSIGNED NOT NULL,
  `active` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `content` text,
  `language` varchar(3) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `vat` int(11) DEFAULT '0',
  `currency` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `active`, `name`, `content`, `language`, `address`, `phone`, `vat`, `currency`, `created`, `updated`) VALUES
(483, 1, 'Antarctica', NULL, 'ATA', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(484, 1, 'Antigua and Barbuda', NULL, 'ATG', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(485, 1, 'Argentina', NULL, 'ARG', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(486, 1, 'Armenia', NULL, 'ARM', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(487, 1, 'Aruba', NULL, 'ABW', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(488, 1, 'Australia', NULL, 'AUS', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(489, 1, 'Austria', NULL, 'AUT', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(490, 1, 'Azerbaijan', NULL, 'AZE', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(491, 1, 'Bahamas', NULL, 'BHS', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(492, 1, 'Bahrain', NULL, 'BHR', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(493, 1, 'Bangladesh', NULL, 'BGD', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(494, 1, 'Barbados', NULL, 'BRB', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(495, 1, 'Belarus', NULL, 'BLR', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(496, 1, 'Belgium', NULL, 'BEL', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(497, 1, 'Belize', NULL, 'BLZ', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(498, 1, 'Benin', NULL, 'BEN', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(499, 1, 'Bermuda', NULL, 'BMU', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(500, 1, 'Bhutan', NULL, 'BTN', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(501, 1, 'Bolivia, Plurinational State of', NULL, 'BOL', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(502, 1, 'Bonaire, Sint Eustatius and Saba', NULL, 'BES', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(503, 1, 'Bosnia and Herzegovina', NULL, 'BIH', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(504, 1, 'Botswana', NULL, 'BWA', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(505, 1, 'Bouvet Island', NULL, 'BVT', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(506, 1, 'Brazil', NULL, 'BRA', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(507, 1, 'British Indian Ocean Territory', NULL, 'IOT', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(508, 1, 'Brunei Darussalam', NULL, 'BRN', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(509, 1, 'Bulgaria', NULL, 'BGR', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(510, 1, 'Burkina Faso', NULL, 'BFA', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(511, 1, 'Burundi', NULL, 'BDI', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(512, 1, 'Cambodia', NULL, 'KHM', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(513, 1, 'Cameroon', NULL, 'CMR', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(514, 1, 'Canada', NULL, 'CAN', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(515, 1, 'Cape Verde', NULL, 'CPV', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(516, 1, 'Cayman Islands', NULL, 'CYM', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(517, 1, 'Central African Republic', NULL, 'CAF', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(518, 1, 'Chad', NULL, 'TCD', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(519, 1, 'Chile', NULL, 'CHL', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(520, 1, 'China', NULL, 'CHN', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(521, 1, 'Christmas Island', NULL, 'CXR', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(522, 1, 'Cocos (Keeling) Islands', NULL, 'CCK', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(523, 1, 'Colombia', NULL, 'COL', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(524, 1, 'Comoros', NULL, 'COM', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(525, 1, 'Congo', NULL, 'COG', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(526, 1, 'Congo, the Democratic Republic of the', NULL, 'COD', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(527, 1, 'Cook Islands', NULL, 'COK', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(528, 1, 'Costa Rica', NULL, 'CRI', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(529, 1, 'Côte d\'Ivoire', NULL, 'CIV', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(530, 1, 'Croatia', NULL, 'HRV', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(531, 1, 'Cuba', NULL, 'CUB', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(532, 1, 'Curaçao', NULL, 'CUW', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(533, 1, 'Cyprus', NULL, 'CYP', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(534, 1, 'Czech Republic', NULL, 'CZE', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(535, 1, 'Denmark', NULL, 'DNK', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(536, 1, 'Djibouti', NULL, 'DJI', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(537, 1, 'Dominica', NULL, 'DMA', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(538, 1, 'Dominican Republic', NULL, 'DOM', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(539, 1, 'Ecuador', NULL, 'ECU', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(540, 1, 'Egypt', NULL, 'EGY', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(541, 1, 'El Salvador', NULL, 'SLV', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(542, 1, 'Equatorial Guinea', NULL, 'GNQ', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(543, 1, 'Eritrea', NULL, 'ERI', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(544, 1, 'Estonia', NULL, 'EST', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(545, 1, 'Ethiopia', NULL, 'ETH', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(546, 1, 'Falkland Islands (Malvinas)', NULL, 'FLK', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(547, 1, 'Faroe Islands', NULL, 'FRO', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(548, 1, 'Fiji', NULL, 'FJI', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(549, 1, 'Finland', NULL, 'FIN', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(550, 1, 'France', NULL, 'FRA', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(551, 1, 'French Guiana', NULL, 'GUF', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(552, 1, 'French Polynesia', NULL, 'PYF', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(553, 1, 'French Southern Territories', NULL, 'ATF', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(554, 1, 'Gabon', NULL, 'GAB', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(555, 1, 'Gambia', NULL, 'GMB', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(556, 1, 'Georgia', NULL, 'GEO', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(557, 1, 'Germany', NULL, 'DEU', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(558, 1, 'Ghana', NULL, 'GHA', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(559, 1, 'Gibraltar', NULL, 'GIB', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(560, 1, 'Greece', NULL, 'GRC', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(561, 1, 'Greenland', NULL, 'GRL', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(562, 1, 'Grenada', NULL, 'GRD', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(563, 1, 'Guadeloupe', NULL, 'GLP', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(564, 1, 'Guam', NULL, 'GUM', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(565, 1, 'Guatemala', NULL, 'GTM', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(566, 1, 'Guernsey', NULL, 'GGY', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(567, 1, 'Guinea', NULL, 'GIN', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(568, 1, 'Guinea-Bissau', NULL, 'GNB', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(569, 1, 'Guyana', NULL, 'GUY', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(570, 1, 'Haiti', NULL, 'HTI', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(571, 1, 'Heard Island and McDonald Islands', NULL, 'HMD', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(572, 1, 'Holy See (Vatican City State)', NULL, 'VAT', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(573, 1, 'Honduras', NULL, 'HND', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(574, 1, 'Hong Kong', NULL, 'HKG', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(575, 1, 'Hungary', NULL, 'HUN', NULL, NULL, 0, 'HUF', '2018-01-25 09:52:59', NULL),
(576, 1, 'Iceland', NULL, 'ISL', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(577, 1, 'India', NULL, 'IND', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(578, 1, 'Indonesia', NULL, 'IDN', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(579, 1, 'Iran, Islamic Republic of', NULL, 'IRN', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(580, 1, 'Iraq', NULL, 'IRQ', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(581, 1, 'Ireland', NULL, 'IRL', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(582, 1, 'Isle of Man', NULL, 'IMN', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(583, 1, 'Israel', NULL, 'ISR', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(584, 1, 'Italy', NULL, 'ITA', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(585, 1, 'Jamaica', NULL, 'JAM', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(586, 1, 'Japan', NULL, 'JPN', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(587, 1, 'Jersey', NULL, 'JEY', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(588, 1, 'Jordan', NULL, 'JOR', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(589, 1, 'Kazakhstan', NULL, 'KAZ', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(590, 1, 'Kenya', NULL, 'KEN', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(591, 1, 'Kiribati', NULL, 'KIR', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(592, 1, 'Korea, Democratic People\'s Republic of', NULL, 'PRK', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(593, 1, 'Korea, Republic of', NULL, 'KOR', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(594, 1, 'Kuwait', NULL, 'KWT', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(595, 1, 'Kyrgyzstan', NULL, 'KGZ', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(596, 1, 'Lao People\'s Democratic Republic', NULL, 'LAO', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(597, 1, 'Latvia', NULL, 'LVA', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(598, 1, 'Lebanon', NULL, 'LBN', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(599, 1, 'Lesotho', NULL, 'LSO', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(600, 1, 'Liberia', NULL, 'LBR', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(601, 1, 'Libya', NULL, 'LBY', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(602, 1, 'Liechtenstein', NULL, 'LIE', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(603, 1, 'Lithuania', NULL, 'LTU', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(604, 1, 'Luxembourg', NULL, 'LUX', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(605, 1, 'Macao', NULL, 'MAC', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(606, 1, 'Macedonia, the former Yugoslav Republic of', NULL, 'MKD', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(607, 1, 'Madagascar', NULL, 'MDG', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(608, 1, 'Malawi', NULL, 'MWI', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(609, 1, 'Malaysia', NULL, 'MYS', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(610, 1, 'Maldives', NULL, 'MDV', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(611, 1, 'Mali', NULL, 'MLI', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(612, 1, 'Malta', NULL, 'MLT', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(613, 1, 'Marshall Islands', NULL, 'MHL', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(614, 1, 'Martinique', NULL, 'MTQ', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(615, 1, 'Mauritania', NULL, 'MRT', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(616, 1, 'Mauritius', NULL, 'MUS', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(617, 1, 'Mayotte', NULL, 'MYT', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(618, 1, 'Mexico', NULL, 'MEX', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(619, 1, 'Micronesia, Federated States of', NULL, 'FSM', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(620, 1, 'Moldova, Republic of', NULL, 'MDA', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(621, 1, 'Monaco', NULL, 'MCO', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(622, 1, 'Mongolia', NULL, 'MNG', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(623, 1, 'Montenegro', NULL, 'MNE', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(624, 1, 'Montserrat', NULL, 'MSR', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(625, 1, 'Morocco', NULL, 'MAR', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(626, 1, 'Mozambique', NULL, 'MOZ', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(627, 1, 'Myanmar', NULL, 'MMR', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(628, 1, 'Namibia', NULL, 'NAM', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(629, 1, 'Nauru', NULL, 'NRU', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(630, 1, 'Nepal', NULL, 'NPL', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(631, 1, 'Netherlands', NULL, 'NLD', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(632, 1, 'New Caledonia', NULL, 'NCL', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(633, 1, 'New Zealand', NULL, 'NZL', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(634, 1, 'Nicaragua', NULL, 'NIC', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(635, 1, 'Niger', NULL, 'NER', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(636, 1, 'Nigeria', NULL, 'NGA', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(637, 1, 'Niue', NULL, 'NIU', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(638, 1, 'Norfolk Island', NULL, 'NFK', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(639, 1, 'Northern Mariana Islands', NULL, 'MNP', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(640, 1, 'Norway', NULL, 'NOR', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(641, 1, 'Oman', NULL, 'OMN', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(642, 1, 'Pakistan', NULL, 'PAK', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(643, 1, 'Palau', NULL, 'PLW', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(644, 1, 'Palestinian Territory, Occupied', NULL, 'PSE', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(645, 1, 'Panama', NULL, 'PAN', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(646, 1, 'Papua New Guinea', NULL, 'PNG', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(647, 1, 'Paraguay', NULL, 'PRY', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(648, 1, 'Peru', NULL, 'PER', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(649, 1, 'Philippines', NULL, 'PHL', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(650, 1, 'Pitcairn', NULL, 'PCN', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(651, 1, 'Poland', NULL, 'POL', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(652, 1, 'Portugal', NULL, 'PRT', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(653, 1, 'Puerto Rico', NULL, 'PRI', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(654, 1, 'Qatar', NULL, 'QAT', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(655, 1, 'Réunion', NULL, 'REU', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(656, 1, 'Romania', NULL, 'ROU', NULL, NULL, 19, 'RON', '2018-01-25 09:52:59', NULL),
(657, 1, 'Russian Federation', NULL, 'RUS', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(658, 1, 'Rwanda', NULL, 'RWA', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(659, 1, 'Saint Barthélemy', NULL, 'BLM', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(660, 1, 'Saint Helena, Ascension and Tristan da Cunha', NULL, 'SHN', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(661, 1, 'Saint Kitts and Nevis', NULL, 'KNA', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(662, 1, 'Saint Lucia', NULL, 'LCA', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(663, 1, 'Saint Martin (French part)', NULL, 'MAF', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(664, 1, 'Saint Pierre and Miquelon', NULL, 'SPM', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(665, 1, 'Saint Vincent and the Grenadines', NULL, 'VCT', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(666, 1, 'Samoa', NULL, 'WSM', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(667, 1, 'San Marino', NULL, 'SMR', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(668, 1, 'Sao Tome and Principe', NULL, 'STP', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(669, 1, 'Saudi Arabia', NULL, 'SAU', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(670, 1, 'Senegal', NULL, 'SEN', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(671, 1, 'Serbia', NULL, 'SRB', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(672, 1, 'Seychelles', NULL, 'SYC', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(673, 1, 'Sierra Leone', NULL, 'SLE', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(674, 1, 'Singapore', NULL, 'SGP', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(675, 1, 'Sint Maarten (Dutch part)', NULL, 'SXM', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(676, 1, 'Slovakia', NULL, 'SVK', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(677, 1, 'Slovenia', NULL, 'SVN', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(678, 1, 'Solomon Islands', NULL, 'SLB', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(679, 1, 'Somalia', NULL, 'SOM', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(680, 1, 'South Africa', NULL, 'ZAF', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(681, 1, 'South Georgia and the South Sandwich Islands', NULL, 'SGS', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(682, 1, 'South Sudan', NULL, 'SSD', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(683, 1, 'Spain', NULL, 'ESP', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(684, 1, 'Sri Lanka', NULL, 'LKA', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(685, 1, 'Sudan', NULL, 'SDN', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(686, 1, 'Suriname', NULL, 'SUR', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(687, 1, 'Svalbard and Jan Mayen', NULL, 'SJM', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(688, 1, 'Swaziland', NULL, 'SWZ', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(689, 1, 'Sweden', NULL, 'SWE', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(690, 1, 'Switzerland', NULL, 'CHE', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(691, 1, 'Syrian Arab Republic', NULL, 'SYR', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(692, 1, 'Taiwan, Province of China', NULL, 'TWN', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(693, 1, 'Tajikistan', NULL, 'TJK', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(694, 1, 'Tanzania, United Republic of', NULL, 'TZA', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(695, 1, 'Thailand', NULL, 'THA', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(696, 1, 'Timor-Leste', NULL, 'TLS', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(697, 1, 'Togo', NULL, 'TGO', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(698, 1, 'Tokelau', NULL, 'TKL', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(699, 1, 'Tonga', NULL, 'TON', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(700, 1, 'Trinidad and Tobago', NULL, 'TTO', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(701, 1, 'Tunisia', NULL, 'TUN', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(702, 1, 'Turkey', NULL, 'TUR', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(703, 1, 'Turkmenistan', NULL, 'TKM', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(704, 1, 'Turks and Caicos Islands', NULL, 'TCA', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(705, 1, 'Tuvalu', NULL, 'TUV', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(706, 1, 'Uganda', NULL, 'UGA', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(707, 1, 'Ukraine', NULL, 'UKR', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(708, 1, 'United Arab Emirates', NULL, 'ARE', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(709, 1, 'United Kingdom', NULL, 'GBR', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(710, 1, 'United States', NULL, 'USA', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(711, 1, 'United States Minor Outlying Islands', NULL, 'UMI', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(712, 1, 'Uruguay', NULL, 'URY', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(713, 1, 'Uzbekistan', NULL, 'UZB', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(714, 1, 'Vanuatu', NULL, 'VUT', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(715, 1, 'Venezuela, Bolivarian Republic of', NULL, 'VEN', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(716, 1, 'Viet Nam', NULL, 'VNM', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(717, 1, 'Virgin Islands, British', NULL, 'VGB', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(718, 1, 'Virgin Islands, U.S.', NULL, 'VIR', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(719, 1, 'Wallis and Futuna', NULL, 'WLF', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(720, 1, 'Western Sahara', NULL, 'ESH', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(721, 1, 'Yemen', NULL, 'YEM', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(722, 1, 'Zambia', NULL, 'ZMB', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL),
(723, 1, 'Zimbabwe', NULL, 'ZWE', NULL, NULL, 0, NULL, '2018-01-25 09:52:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `discounts`
--

CREATE TABLE `discounts` (
  `id` int(11) UNSIGNED NOT NULL,
  `active` tinyint(2) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `price_modifier` int(11) NOT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `discounts`
--

INSERT INTO `discounts` (`id`, `active`, `name`, `price_modifier`, `start_date`, `end_date`, `created`, `updated`) VALUES
(1, 1, 'Lv1 Vip Badge', 10, '2018-01-01 00:00:00', '2018-03-16 00:00:00', '2018-01-01 00:00:00', '2018-01-19 09:20:46'),
(2, 1, 'Spring Offer 20%', 20, '2018-02-01 00:00:00', '2018-02-16 00:00:00', '2018-02-02 09:57:04', '2018-02-02 09:57:04'),
(3, 1, 'Spring Offer 15%', 15, '2018-02-01 00:00:00', '2018-02-16 00:00:00', '2018-02-02 09:57:04', '2018-02-02 09:57:04'),
(4, 1, 'Spring Offer 30%', 30, '2018-02-01 00:00:00', '2018-02-16 00:00:00', '2018-02-02 09:57:04', '2018-02-02 09:57:04');

-- --------------------------------------------------------

--
-- Table structure for table `feedbacks`
--

CREATE TABLE `feedbacks` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `product_id` int(11) UNSIGNED NOT NULL,
  `active` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `comment` text,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `feedbacks`
--

INSERT INTO `feedbacks` (`id`, `user_id`, `product_id`, `active`, `comment`, `created`, `updated`) VALUES
(18, 1, 48, 1, 'hjkhjk', '2018-02-01 00:00:00', '2018-02-01 00:00:00'),
(23, 36, 48, 1, 'hjkhjk', '2018-02-05 13:58:53', '2018-02-05 13:58:53'),
(24, 36, 48, 1, 'hjk', '2018-02-05 14:02:00', '2018-02-05 14:02:00'),
(25, 36, 48, 1, 'kjkjk', '2018-02-05 14:06:00', '2018-02-05 14:06:00'),
(26, 36, 48, 1, 'ghj', '2018-02-05 14:08:17', '2018-02-05 14:08:17'),
(27, 36, 48, 1, 'jjjj', '2018-02-05 14:08:50', '2018-02-05 14:08:50'),
(28, 36, 48, 1, 'jkljkl', '2018-02-05 14:09:55', '2018-02-05 14:09:55'),
(29, 5, 48, 1, 'hjkkjl', '0000-00-00 00:00:00', '2018-02-05 14:17:54'),
(30, 36, 48, 1, 'hjk', '0000-00-00 00:00:00', '2018-02-05 14:18:03'),
(31, 36, 48, 1, 'jhk', '2017-10-01 10:00:00', '2018-02-05 14:21:08'),
(32, 36, 48, 1, 'hjk', '2018-02-05 13:22:17', '2018-02-05 14:22:17'),
(33, 36, 48, 1, 'tyuty', '2018-02-05 13:23:15', '2018-02-05 14:23:15'),
(34, 36, 48, 1, 'jk', '2018-02-05 13:24:05', '2018-02-05 14:24:05'),
(35, 36, 48, 1, 'jkkhj', '2018-02-05 13:24:09', '2018-02-05 14:24:09'),
(36, 36, 48, 1, 'hjkhjk', '2018-02-05 13:25:13', '2018-02-05 14:25:13'),
(37, 36, 48, 1, 'hjkhjkhkh', '2018-02-05 13:25:15', '2018-02-05 14:25:15'),
(44, 36, 48, 1, 'hjk', '2018-02-06 06:11:25', '2018-02-06 07:11:25'),
(47, 5, 48, 1, 'ghjghj', '2018-02-06 06:51:10', '2018-02-06 07:51:10'),
(48, 5, 48, 1, 'ghjghjghjg', '2018-02-06 06:51:12', '2018-02-06 07:51:12'),
(50, 5, 48, 1, 'ghjghjghjgghjghjg', '2018-02-06 06:51:16', '2018-02-06 07:51:16'),
(51, 5, 48, 1, 'ghjghjghjgghjghjgghj', '2018-02-06 06:51:18', '2018-02-06 07:51:18'),
(52, 5, 48, 1, 'ghjghjghjgghjghjgghjghjghj', '2018-02-06 06:51:20', '2018-02-06 07:51:20'),
(53, 5, 48, 1, 'ghjghjghjgghjghjgghjghjghjghjg', '2018-02-06 06:51:21', '2018-02-06 07:51:21'),
(54, 5, 48, 1, 'ghj', '2018-02-06 06:56:47', '2018-02-06 07:56:47'),
(55, 5, 48, 1, 'ghjj', '2018-02-06 06:56:50', '2018-02-06 07:56:50'),
(56, 5, 48, 1, 'ghjj', '2018-02-06 06:57:23', '2018-02-06 07:57:24'),
(57, 5, 48, 1, 'ghjj\nh', '2018-02-06 06:57:37', '2018-02-06 07:57:38'),
(58, 5, 48, 1, 'ghj', '2018-02-06 06:58:16', '2018-02-06 07:58:17'),
(59, 5, 48, 1, 'ghjjk', '2018-02-06 06:58:20', '2018-02-06 07:58:20'),
(60, 5, 48, 1, 'ghjjk', '2018-02-06 06:58:46', '2018-02-06 07:58:47'),
(61, 5, 48, 1, 'ghjjkh', '2018-02-06 06:58:57', '2018-02-06 07:58:58'),
(62, 5, 49, 1, 'This is a comment', '2018-02-06 07:05:11', '2018-02-06 08:05:11'),
(63, 5, 49, 1, 'This is next comment', '2018-02-06 07:05:22', '2018-02-06 08:05:22');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `active` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `active`, `name`, `email`, `phone`, `address`, `created`, `updated`) VALUES
(1, 1, 'Owner', 'something@mail.com', '007450000000', 'Somewhere', '2018-01-04 00:00:00', '2018-01-15 14:54:16'),
(2, 1, 'Admin', 'something2@mail.com', '007450000000', 'Somewhere2', '2018-01-04 00:00:00', '2018-01-04 00:00:00'),
(3, 1, 'Moderator', 'something3@mail.com', '007450000000', 'Somewhere3', '2018-01-04 00:00:00', '2018-01-04 00:00:00'),
(4, 1, 'Client', 'something4@mail.com', '007450000000', 'Somewhere4', '2018-01-04 00:00:00', '2018-01-04 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(11) UNSIGNED NOT NULL,
  `path` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `path`, `created`, `updated`) VALUES
(29, '2018-01-17-071957dell.jpg', '2018-01-17 07:19:57', '2018-01-17 07:19:57'),
(46, '5a72bc7457b5a_1517468788.jpg', '2018-02-01 08:06:28', '2018-02-01 08:06:28'),
(47, '5a72bc9fbe495_1517468831.jpg', '2018-02-01 08:07:11', '2018-02-01 08:07:11'),
(48, '5a72bd18d9f0c_1517468952.jpg', '2018-02-01 08:09:12', '2018-02-01 08:09:12'),
(49, '5a72c5436f6fd_1517471043.jpg', '2018-02-01 08:44:03', '2018-02-01 08:44:03'),
(50, '5a72ca5f7cf7e_1517472351.jpg', '2018-02-01 09:05:51', '2018-02-01 09:05:51'),
(51, '5a72cc9728dca_1517472919.jpg', '2018-02-01 09:15:19', '2018-02-01 09:15:19'),
(52, '5a72cdb65fc37_1517473206.jpg', '2018-02-01 09:20:06', '2018-02-01 09:20:06'),
(53, '5a73f12d6ded3_1517547821.jpg', '2018-02-02 07:03:41', '2018-02-02 07:03:41'),
(54, '5a73f14835cc2_1517547848.jpg', '2018-02-02 07:04:08', '2018-02-02 07:04:08'),
(55, '5a73f16e2aa0f_1517547886.jpg', '2018-02-02 07:04:46', '2018-02-02 07:04:46'),
(56, '5a7465970a2b7_1517577623.jpg', '2018-02-02 14:20:23', '2018-02-02 14:20:23'),
(57, '5a7465a44dade_1517577636.jpg', '2018-02-02 14:20:36', '2018-02-02 14:20:36'),
(58, '5a7465bbb6f0b_1517577659.jpg', '2018-02-02 14:20:59', '2018-02-02 14:20:59');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `active` tinyint(4) UNSIGNED NOT NULL DEFAULT '1',
  `price_sub_total` decimal(9,2) UNSIGNED DEFAULT NULL,
  `price_vat` decimal(9,2) UNSIGNED DEFAULT NULL,
  `price_total` decimal(9,2) UNSIGNED DEFAULT NULL,
  `status` tinyint(4) UNSIGNED DEFAULT '0',
  `finished` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `active`, `price_sub_total`, `price_vat`, `price_total`, `status`, `finished`, `created`, `updated`) VALUES
(15, 1, 1, '72.00', '0.00', '72.00', 0, NULL, '2018-01-30 13:39:11', '2018-01-30 13:39:11'),
(22, 36, 1, '189.00', '35.92', '224.92', 3, '2018-01-30 14:37:57', '2018-01-30 14:11:12', '2018-01-30 14:11:12'),
(23, 1, 1, '3.28', '0.00', '3.28', 0, NULL, '2018-01-30 14:42:30', '2018-01-30 14:42:30');

-- --------------------------------------------------------

--
-- Table structure for table `orders_products`
--

CREATE TABLE `orders_products` (
  `id` int(11) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED DEFAULT NULL,
  `product_id` int(10) UNSIGNED DEFAULT NULL,
  `amount` int(10) UNSIGNED DEFAULT NULL,
  `price_sub` decimal(9,2) NOT NULL DEFAULT '0.00',
  `price` decimal(9,2) UNSIGNED DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders_products`
--

INSERT INTO `orders_products` (`id`, `order_id`, `product_id`, `amount`, `price_sub`, `price`, `product_name`, `created`, `updated`) VALUES
(39, 15, 1, 1, '72.00', '72.00', 'valami #EGYIK1', '2018-01-30 13:39:11', '2018-01-30 13:40:44'),
(47, 22, 1, 2, '85.00', '101.15', 'valami #EGYIK1', '2018-01-30 14:11:12', '2018-01-30 14:11:12'),
(49, 22, 6, 2, '9.50', '11.31', 'Valami 203', '2018-01-30 14:11:12', '2018-01-30 14:11:12'),
(50, 23, 10, 4, '0.82', '0.82', 'fghfgh', '2018-01-30 14:42:30', '2018-01-30 14:42:30');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) UNSIGNED NOT NULL,
  `parent_id` int(11) UNSIGNED DEFAULT '0',
  `active` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `url` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `ordering` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `header` tinyint(2) NOT NULL DEFAULT '0',
  `aside` tinyint(2) NOT NULL DEFAULT '0',
  `footer` tinyint(2) NOT NULL DEFAULT '0',
  `short_content` varchar(255) DEFAULT NULL,
  `content` text,
  `meta_title` text,
  `meta_description` text,
  `meta_keyword` text,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `parent_id`, `active`, `url`, `slug`, `name`, `ordering`, `header`, `aside`, `footer`, `short_content`, `content`, `meta_title`, `meta_description`, `meta_keyword`, `created`, `updated`) VALUES
(1, 0, 1, '/', 'products', 'Products', 1, 1, 0, 0, 'balbla ', 'more blabla more and more', 'more blabla more and more', 'more blabla more and more', 'more blabla more and more', '2018-01-01 00:00:00', '2018-01-01 00:00:00'),
(2, 0, 1, '/contact', 'contacts', 'Contacts', 2, 1, 0, 0, 'balbla ', 'more blabla more and more', 'more blabla more and more', 'more blabla more and more', 'more blabla more and more', '2018-01-01 00:00:00', '2018-01-01 00:00:00'),
(3, 0, 1, '', 'about', 'About Us', 2, 1, 0, 0, 'balbla ', 'more blabla more and more', 'more blabla more and more', 'more blabla more and more', 'more blabla more and more', '2018-01-01 00:00:00', '2018-01-01 00:00:00'),
(4, 0, 1, '', 'terms', 'Terms', 2, 1, 0, 0, 'balbla ', 'more blabla more and more', 'more blabla more and more', 'more blabla more and more', 'more blabla more and more', '2018-01-01 00:00:00', '2018-01-01 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) UNSIGNED NOT NULL,
  `active` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `discount_id` int(11) UNSIGNED DEFAULT NULL,
  `category_id` int(11) UNSIGNED DEFAULT NULL,
  `brand_id` int(11) UNSIGNED DEFAULT NULL,
  `classification_id` int(11) UNSIGNED DEFAULT NULL,
  `accessory_id` int(11) UNSIGNED DEFAULT NULL,
  `cover_image_id` int(11) UNSIGNED DEFAULT NULL,
  `item_condition` tinyint(7) UNSIGNED DEFAULT '1',
  `slug` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `short_content` varchar(255) DEFAULT NULL,
  `content` text,
  `price` decimal(9,2) NOT NULL,
  `meta_title` text,
  `meta_description` text,
  `meta_keyword` text,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `active`, `discount_id`, `category_id`, `brand_id`, `classification_id`, `accessory_id`, `cover_image_id`, `item_condition`, `slug`, `name`, `short_content`, `content`, `price`, `meta_title`, `meta_description`, `meta_keyword`, `created`, `updated`) VALUES
(1, 1, 1, 31, 7, 0, 1, 42, 1, 'windows-10-pro', 'Windows 10 Pro', 'dsf sdf sdf', ' sdf sdf sdfs dfs', '900.00', 'sdf sdfs', ' sdfsd fsdf sdf', ' sdfs dfsd fsd', '2018-01-04 00:00:00', '2018-02-01 09:21:22'),
(2, 1, 1, 31, 7, 0, 1, 43, 1, 'windows-10-ultimate', 'Windows 10 Ultimate', 'dsf sdf sdf', ' sdf sdf sdfs dfs', '1200.00', 'sdf sdfs', ' sdfsd fsdf sdf', ' sdfs dfsd fsd', '2018-01-04 00:00:00', '2018-02-01 09:21:36'),
(6, 1, NULL, 32, 7, 0, 1, 40, 1, 'office-365', 'Office 365', 'dfgdf', 'dfg', '500.00', 'dfg', 'dfg', 'dfg', '2018-01-25 12:20:47', '2018-02-01 09:21:56'),
(9, 1, NULL, 31, 7, 0, 1, 41, 1, 'windows-10-home', 'Windows 10 Home', 'fgh', 'ffff', '780.00', 'ssss', 'fsdf', 'sdfsd', '2018-01-25 12:50:15', '2018-02-01 09:21:07'),
(10, 1, 1, 38, 3, 16, 3, 22, 1, 'amd-fx-8370', 'Amd FX 8370', '', '', '150.00', 'asd asd as dasd a', '  sfff hh hh df ', 'dfgdf dfgd f dfg dfg', '2018-01-25 14:05:23', '2018-02-02 08:26:49'),
(11, 1, NULL, 34, 3, 0, 1, 23, 1, 'asus-b350', 'Asus b350', 'dfgd', 'gdfg', '250.00', 'dfgd', 'gdfgd', 'dfgdf', '2018-02-01 08:28:59', '2018-02-01 09:02:58'),
(12, 1, NULL, 12, 3, 0, 1, 25, 1, 'asus-c9', 'Asus c9', 'sd f', 's dfs', '1900.00', ' sfd', 's df', 's dfsdf ', '2018-02-01 08:30:18', '2018-02-01 09:02:38'),
(13, 1, NULL, 12, 3, 0, 1, 26, 1, 'asus-g67', 'Asus G67', 'fghfg', 'fghfg', '2500.00', 'fghfg', 'hfgh', 'fghfg', '2018-02-01 08:34:58', '2018-02-01 09:02:04'),
(14, 1, NULL, 12, 3, 0, 1, 27, 1, 'asus-h99', 'Asus H99', 'sdf', 'sdfs', '3000.00', 'dfsd', 'fsdsd', 'sdfsdf', '2018-02-01 08:35:35', '2018-02-01 09:02:21'),
(15, 1, 2, 12, 3, 0, 1, 28, 1, 'asus-nj99', 'Asus NJ99', 'ghf', 'fgh', '2498.00', 'fgh', 'fgh', 'fgh', '2018-02-01 08:36:14', '2018-02-02 09:58:41'),
(16, 1, NULL, 28, 3, 0, 1, 29, 1, 'asus-v99', 'Asus V99', 'dfgdf', 'dfgdfd', '100.00', 'fgdfg', 'dfgd', 'dfgd', '2018-02-01 08:37:05', '2018-02-01 09:01:34'),
(17, 1, NULL, 34, 3, 0, 1, 30, 1, 'asus-b643-j2', 'Asus B643-J2', 'fghf', 'fghfg', '350.00', 'fgh', 'fgh', 'fgh', '2018-02-01 08:37:47', '2018-02-01 09:16:43'),
(18, 1, 1, 37, 4, 6, 0, 31, 1, 'crucial-2gb-ddr2', 'Crucial 2Gb DDR2', 'fgdh', 'dfg', '80.00', 'dfg', 'dfg', 'dfg', '2018-02-01 08:38:46', '2018-02-02 08:00:39'),
(19, 1, 4, 37, 4, 7, 0, 32, 1, 'crucial-4gb-ddr3', 'Crucial 4gb Ddr3', 'sdf', 'sdf', '1400.00', 'sdf', 'sdf', 'sdf', '2018-02-01 08:39:43', '2018-02-02 09:58:21'),
(20, 1, 1, 37, 4, 8, 0, 33, 1, 'crucial-4gb-ddr4', 'Crucial 4gb Ddr4', 'sdf', 'sdf', '200.00', 'fg', 'fgh', 'gfh', '2018-02-01 08:40:22', '2018-02-02 08:00:21'),
(21, 1, 1, 37, 4, 7, 0, 34, 1, 'crucial-8gb-ddr3', 'Crucial 8gb Ddr3', 'gh', 'fg', '350.00', 'fgh', 'fgh', 'fgh', '2018-02-01 08:41:21', '2018-02-02 08:00:14'),
(22, 1, 1, 37, 5, 7, 0, 35, 1, 'kingstone-2gb-ddr3', 'Kingstone 2Gb Ddr3', '', '', '80.00', '', '', '', '2018-02-01 08:47:30', '2018-02-02 07:59:36'),
(23, 1, 1, 37, 5, 7, 0, 36, 1, 'kingstone-4gb-ddr3', 'Kingstone 4Gb Ddr3', 'DF', 'DFG', '145.00', 'D', 'DFG', 'DFG', '2018-02-01 08:48:19', '2018-02-02 07:59:12'),
(24, 1, 1, 59, 5, 11, 0, 37, 1, 'kingstone-4gb-ddr4', 'Kingstone 4Gb Ddr4', 'hj', 'hj', '200.00', 'h', 'hjk', 'hjk', '2018-02-01 08:48:55', '2018-02-02 07:58:52'),
(25, 1, NULL, 9, 4, 0, 1, 38, 1, 'rog-gdc', 'Rog GDC', '', 'ghj', '2800.00', 'ghj', 'ghj', 'ghj', '2018-02-01 08:51:17', '2018-02-01 08:51:44'),
(26, 1, NULL, 1, 0, 0, 0, 39, 1, 'asus-ntzx', 'Asus NTZX', 'aasd', 'a sda', '3800.00', 'sdasd', ' asd', 'asda', '2018-02-01 08:52:16', '2018-02-01 08:52:16'),
(27, 1, NULL, 46, 8, 0, 1, 44, 1, 'razer-keyboard-s2', 'Razer Keyboard S2', 'hg', 'jgh', '170.00', 'h', 'hh', 'hh', '2018-02-01 09:16:12', '2018-02-01 09:16:12'),
(28, 1, NULL, 46, 8, 0, 1, 45, 1, 'razer-k2', 'Razer K2', 'sdf', 'sdf', '100.00', 'sdfsd', 'sdf', 'sdf', '2018-02-01 09:18:09', '2018-02-01 09:18:09'),
(29, 1, 1, 54, 9, 0, 0, 46, 1, 'logitech-w2', 'Logitech W2', 'jhkghj', 'hjk', '78.00', 'hjk', 'hjk', 'hjk', '2018-02-01 09:22:54', '2018-02-01 09:42:14'),
(30, 1, 1, 54, 9, 0, 0, 47, 1, 'logitech-v23c', 'Logitech V23c', '', 'sdfs', '200.00', 'sdf', 'sdf', 'sdf', '2018-02-01 09:44:12', '2018-02-01 09:44:32'),
(31, 1, 0, 54, 9, 0, 0, 48, 1, 'logitech-b23', 'Logitech B23', '', 'ghj', '170.00', 'ghj', 'ghj', 'ghj', '2018-02-01 09:46:40', '2018-02-01 09:46:40'),
(32, 1, 0, 9, 3, 0, 0, 50, 1, 'ibuypower-2000', 'iBuyPower 2000', 'fdgd', 'gdfg', '2400.00', 'dfg', 'dfg', 'dfg', '2018-02-01 09:55:13', '2018-02-01 09:55:47'),
(33, 1, 0, 34, 3, 0, 3, 51, 1, 'amd-c29-s34', 'Amd C29 s34', 'ds', 'sdf', '219.00', 'sdfsdf', 'sdf', 'sdf', '2018-02-02 08:15:55', '2018-02-02 08:27:09'),
(34, 1, 0, 34, 0, 0, 0, 52, 1, 'asrock-amd-x45', 'Asrock AMD X45', 'ewr', 'wer', '198.00', 'wer', 'wer', 'wer', '2018-02-02 08:27:41', '2018-02-02 08:27:41'),
(35, 1, 0, 34, 0, 0, 0, 53, 1, 'asrock-amd-x45-1', 'Asrock AMD x45', 'jk', 'hk', '178.00', 'hkj', 'hk', 'hjk', '2018-02-02 08:28:14', '2018-02-02 08:28:14'),
(36, 1, 0, 35, 3, 0, 3, 55, 1, 'amd-ryzen-r4-2gb', 'AMD Ryzen r4 2Gb', 'fgh', 'gfhfgh', '590.00', 'fgh', 'fgh', 'fgh', '2018-02-02 08:30:36', '2018-02-02 08:31:53'),
(37, 1, 0, 37, 3, 8, 3, 56, 1, 'amd-8gb-2000-mhz', 'AMD 8Gb 2000 Mhz', 'gghj', 'nbmb', '420.00', 'ghhjg', 'jghj', 'hjgh', '2018-02-02 08:32:47', '2018-02-02 08:32:47'),
(38, 1, 0, 33, 15, 0, 0, 57, 1, 'kspersky-internet-security', 'Kspersky Internet Security', 'asd', 'asd', '120.00', 'asd', 'asd', 'asd', '2018-02-02 14:21:45', '2018-02-02 14:21:45'),
(39, 1, 0, 14, 14, 0, 0, 58, 1, 'canon-x28', 'Canon X28', 'df', 's', '250.00', 'sdf', 'sdf', 'sdf', '2018-02-02 14:22:33', '2018-02-02 14:22:33'),
(40, 1, 0, 17, 14, 0, 0, 59, 1, 'canon-fax-u23', 'Canon Fax U23', 'dfgd', 'asd', '300.00', 'dfg', 'dfg', 'dfg', '2018-02-02 14:23:11', '2018-02-02 14:23:11'),
(41, 1, 0, 12, 1, 0, 0, 60, 1, 'dell-xps4', 'Dell XPS4', 'asd', 'asdasd', '1900.00', 'asd', 'asd', 'asd', '2018-02-02 14:26:25', '2018-02-02 14:26:25'),
(42, 1, 0, 12, 1, 0, 0, 61, 1, 'del-inspire-x5', 'Del Inspire X5', 'DFg', 'df', '2400.00', 'gdfg', 'dfg', 'dfg', '2018-02-02 14:27:00', '2018-02-02 14:27:00'),
(43, 1, 0, 10, 1, 0, 0, 62, 1, 'dell-u2417', 'Dell U2417', 'DFgdfg', 'dfg', '300.00', 'dfgd', 'fg', '', '2018-02-02 14:30:10', '2018-02-02 14:30:10'),
(44, 1, 0, 10, 1, 0, 0, 63, 1, 'dell-u34', 'Dell U34', 'gf', 'dgdf', '230.00', 'gdf', 'gdfg', 'dfg', '2018-02-02 14:30:57', '2018-02-02 14:30:57'),
(45, 1, 0, 46, 13, 0, 0, 64, 1, 'corsair-kb23', 'Corsair Kb23', 'sdf', 'sdf', '200.00', 'sdf', 'sdf', 'sdf', '2018-02-02 14:31:48', '2018-02-02 14:31:48'),
(46, 1, 0, 46, 7, 0, 0, 65, 1, 'mircrosoft-kb2519', 'Mircrosoft Kb2519', 'd', 's', '125.00', 'sdf', 'sdf', 'sdf', '2018-02-02 14:32:37', '2018-02-02 14:32:37'),
(47, 1, 0, 15, 14, 0, 0, 66, 1, 'pixma-g240', 'Pixma g240', 'sdf', 'sdf', '400.00', 'sdf', 'sdf', 'sfd', '2018-02-02 14:33:09', '2018-02-02 14:33:09'),
(48, 1, 0, 47, 9, 0, 0, 81, 1, 'logitech-m23', 'Logitech M23', 'sdf', 'sdf', '400.00', 'sdf', 'sdf', 'sf', '2018-02-02 14:34:05', '2018-02-02 14:34:05'),
(49, 1, 0, 47, 8, 0, 0, 69, 1, 'razer-m7', 'Razer M7', 'fd', 'df', '120.00', 'g', 'dfg', 'dg', '2018-02-02 14:34:45', '2018-02-02 14:37:00');

-- --------------------------------------------------------

--
-- Table structure for table `products_images`
--

CREATE TABLE `products_images` (
  `id` int(11) UNSIGNED NOT NULL,
  `product_id` int(11) UNSIGNED DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products_images`
--

INSERT INTO `products_images` (`id`, `product_id`, `name`, `created`, `updated`) VALUES
(22, 10, '5a72be11b87e0_1517469201.jpg', '2018-02-01 08:13:21', '2018-02-01 08:13:21'),
(23, 11, '5a72c1bb5b0aa_1517470139.jpg', '2018-02-01 08:28:59', '2018-02-01 08:28:59'),
(25, 12, '5a72c2f9e1af8_1517470457.jpg', '2018-02-01 08:34:17', '2018-02-01 08:34:17'),
(26, 13, '5a72c32271c81_1517470498.jpg', '2018-02-01 08:34:58', '2018-02-01 08:34:58'),
(27, 14, '5a72c3478bfbc_1517470535.jpg', '2018-02-01 08:35:35', '2018-02-01 08:35:35'),
(28, 15, '5a72c36e1c9f0_1517470574.jpg', '2018-02-01 08:36:14', '2018-02-01 08:36:14'),
(29, 16, '5a72c3a156261_1517470625.jpg', '2018-02-01 08:37:05', '2018-02-01 08:37:05'),
(30, 17, '5a72c3cb360ac_1517470667.jpg', '2018-02-01 08:37:47', '2018-02-01 08:37:47'),
(31, 18, '5a72c4064878b_1517470726.jpg', '2018-02-01 08:38:46', '2018-02-01 08:38:46'),
(32, 19, '5a72c43f11ee5_1517470783.jpg', '2018-02-01 08:39:43', '2018-02-01 08:39:43'),
(33, 20, '5a72c466c6ba8_1517470822.jpg', '2018-02-01 08:40:22', '2018-02-01 08:40:22'),
(34, 21, '5a72c4a1ed6f9_1517470881.jpg', '2018-02-01 08:41:21', '2018-02-01 08:41:21'),
(35, 22, '5a72c612b006d_1517471250.jpg', '2018-02-01 08:47:30', '2018-02-01 08:47:30'),
(36, 23, '5a72c643de5f0_1517471299.jpg', '2018-02-01 08:48:19', '2018-02-01 08:48:19'),
(37, 24, '5a72c667a02a6_1517471335.jpg', '2018-02-01 08:48:55', '2018-02-01 08:48:55'),
(38, 25, '5a72c6f5a28cc_1517471477.jpg', '2018-02-01 08:51:17', '2018-02-01 08:51:17'),
(39, 26, '5a72c730d44db_1517471536.jpg', '2018-02-01 08:52:16', '2018-02-01 08:52:16'),
(40, 6, '5a72cac658b71_1517472454.jpg', '2018-02-01 09:07:34', '2018-02-01 09:07:34'),
(41, 9, '5a72cb257a30d_1517472549.jpg', '2018-02-01 09:09:09', '2018-02-01 09:09:09'),
(42, 1, '5a72cb95e20e0_1517472661.jpg', '2018-02-01 09:11:01', '2018-02-01 09:11:01'),
(43, 2, '5a72cbc7c4854_1517472711.jpg', '2018-02-01 09:11:51', '2018-02-01 09:11:51'),
(44, 27, '5a72cccce3270_1517472972.jpg', '2018-02-01 09:16:12', '2018-02-01 09:16:12'),
(45, 28, '5a72cd41b12a4_1517473089.jpg', '2018-02-01 09:18:09', '2018-02-01 09:18:09'),
(46, 29, '5a72ce5e16b8f_1517473374.jpg', '2018-02-01 09:22:54', '2018-02-01 09:22:54'),
(47, 30, '5a72d35cb70bb_1517474652.jpg', '2018-02-01 09:44:12', '2018-02-01 09:44:12'),
(48, 31, '5a72d3f01fffd_1517474800.jpg', '2018-02-01 09:46:40', '2018-02-01 09:46:40'),
(50, 32, '5a72d60eb963f_1517475342.jpg', '2018-02-01 09:55:42', '2018-02-01 09:55:42'),
(51, 33, '5a74102bae499_1517555755.jpg', '2018-02-02 08:15:55', '2018-02-02 08:15:55'),
(52, 34, '5a7412edd9069_1517556461.jpg', '2018-02-02 08:27:41', '2018-02-02 08:27:41'),
(53, 35, '5a74130e71530_1517556494.jpg', '2018-02-02 08:28:14', '2018-02-02 08:28:14'),
(55, 36, '5a7413d637bd8_1517556694.jpg', '2018-02-02 08:31:34', '2018-02-02 08:31:34'),
(56, 37, '5a74141f917e2_1517556767.jpg', '2018-02-02 08:32:47', '2018-02-02 08:32:47'),
(57, 38, '5a7465e9d6c75_1517577705.jpg', '2018-02-02 14:21:45', '2018-02-02 14:21:45'),
(58, 39, '5a746619dae25_1517577753.jpg', '2018-02-02 14:22:33', '2018-02-02 14:22:33'),
(59, 40, '5a74663f99584_1517577791.jpg', '2018-02-02 14:23:11', '2018-02-02 14:23:11'),
(60, 41, '5a7467011be3f_1517577985.jpg', '2018-02-02 14:26:25', '2018-02-02 14:26:25'),
(61, 42, '5a746724255d4_1517578020.jpg', '2018-02-02 14:27:00', '2018-02-02 14:27:00'),
(62, 43, '5a7467e226920_1517578210.jpg', '2018-02-02 14:30:10', '2018-02-02 14:30:10'),
(63, 44, '5a746811ce5d1_1517578257.jpg', '2018-02-02 14:30:57', '2018-02-02 14:30:57'),
(64, 45, '5a746844286ef_1517578308.jpg', '2018-02-02 14:31:48', '2018-02-02 14:31:48'),
(65, 46, '5a7468759a584_1517578357.jpg', '2018-02-02 14:32:37', '2018-02-02 14:32:37'),
(66, 47, '5a74689586928_1517578389.jpg', '2018-02-02 14:33:09', '2018-02-02 14:33:09'),
(69, 49, '5a746975d4c06_1517578613.jpg', '2018-02-02 14:36:53', '2018-02-02 14:36:53'),
(81, 48, '4d6089105b8dc087cc109c9a61ad5d8d.jpg', '2018-02-04 15:17:45', '2018-02-04 15:17:45');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) UNSIGNED NOT NULL,
  `product_id` int(11) UNSIGNED DEFAULT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(2) NOT NULL DEFAULT '0',
  `rate` decimal(6,2) UNSIGNED NOT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `product_id`, `user_id`, `active`, `rate`, `created`, `updated`) VALUES
(30, 10, 1, 1, '3.00', '2018-01-31 13:00:02', '2018-01-31 13:01:52'),
(31, 36, 5, 1, '5.00', '2018-02-02 09:32:47', '2018-02-02 09:32:47'),
(32, 48, 5, 1, '4.50', '2018-02-02 15:40:17', '2018-02-02 15:40:17'),
(33, 48, 1, 1, '3.00', '2018-02-04 16:25:28', '2018-02-06 09:32:22'),
(34, 46, 1, 1, '4.50', '2018-02-04 16:25:39', '2018-02-04 16:25:39'),
(35, 49, 5, 1, '4.00', '2018-02-06 09:19:17', '2018-02-06 09:19:17');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `group_id` int(11) UNSIGNED DEFAULT '4',
  `country_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `active` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `slug` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `postal_code` varchar(20) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `number_coc` varchar(255) DEFAULT NULL,
  `number_vat` varchar(255) DEFAULT NULL,
  `bic` varchar(255) DEFAULT NULL,
  `iban` varchar(255) DEFAULT NULL,
  `discount` int(11) NOT NULL DEFAULT '0',
  `recovery_hash` varchar(255) DEFAULT NULL,
  `creation_hash` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `group_id`, `country_id`, `active`, `slug`, `username`, `password`, `first_name`, `last_name`, `email`, `company_name`, `city`, `address`, `postal_code`, `phone`, `number_coc`, `number_vat`, `bic`, `iban`, `discount`, `recovery_hash`, `creation_hash`, `image`, `created`, `updated`) VALUES
(1, 1, 493, 1, NULL, 'Admin', '$2a$07$R1ztIHAtpMO8qMhThyrtj.GccEVfrfRxW2VWCCQNdLvzt/WowI8hG', 'Kis', 'Pista', 'valami@valami.com', 'PC Store', 'Oradea', 'Lacul Rosu', '428791', '0040745153545', '', '', '', '', 18, NULL, NULL, NULL, '2018-01-04 15:17:30', '2018-02-05 07:50:40'),
(5, 4, 491, 1, NULL, 'shadowvzs2', '$2a$07$R1ztIHAtpMO8qMhThyrtj.GccEVfrfRxW2VWCCQNdLvzt/WowI8hG', 'Nagy', 'Pista', '', '', '', '', '', '4564564 456', '', '', '', '', 12, NULL, NULL, NULL, '2018-01-05 08:28:43', '2018-02-06 13:25:38'),
(36, 4, 656, 1, NULL, 'shadowvzs16', '$2a$10$IEOvOBxzWm0shPgELcZJBeh2sCUTFtufu8T8jpzQmfpsRryMhPJk6', 'John', 'Smith', 'shadowvzs@hotmail.com', 'Nimfas corporation', 'Valahol', 'str. Izemize, nr. 33', '413801', '0745655656', '', '', '', '', 5, NULL, '0a6945a00dbe0ada70ef6b6ef0044f09', NULL, '2018-01-09 13:57:48', '2018-01-29 08:35:53'),
(37, 4, 0, 1, NULL, 'shad', '$2a$10$C1kc1atVu4gwFVR0kHdvbODZL/FtDMn84KVIZNP7x.X7y.9bfA5CC', '', '', 'ghfgh@sdf.sfd', '', '', '', '', '', '', '', '', '', 0, NULL, '8bd576c60f24f815b5b0d2b9c7b40f04', NULL, '2018-01-09 14:40:27', '2018-01-19 09:28:48'),
(38, 4, 0, 1, NULL, 'valami', '$2a$10$yw8vMQtbqNi4w6VSHMXum.UMoGN/2KqNxLUSPb/T139kWoovYPmMe', NULL, NULL, 'kis-pista@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'ac831b4db1afb6127cb513a37dd35c0b', NULL, '2018-01-15 08:45:29', '2018-01-15 08:45:29'),
(39, 4, 0, 1, NULL, 'masik', '$2a$10$27vWCpOxI1UXKxt2XRt1QOGPQ1YzqdMR4XayIvrNS07Cx0gT4VHFO', 'Valaki', 'Ez eg', 'shad@hotmail.com', '', '', '', '', '', '', '', '', '', 0, NULL, '8a65adf532f23eb2a0d4eed8915be965', NULL, '2018-01-15 08:48:14', '2018-01-16 12:49:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accessories`
--
ALTER TABLE `accessories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD KEY `image_id` (`image_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `classifications`
--
ALTER TABLE `classifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `brand_id` (`brand_id`),
  ADD KEY `category` (`category_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `country_id` (`country_id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `discounts`
--
ALTER TABLE `discounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `orders_products`
--
ALTER TABLE `orders_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `brand_id` (`brand_id`),
  ADD KEY `series_id` (`classification_id`),
  ADD KEY `discount_id` (`discount_id`),
  ADD KEY `accessory_id` (`accessory_id`),
  ADD KEY `cover_image_id` (`cover_image_id`);

--
-- Indexes for table `products_images`
--
ALTER TABLE `products_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `country_id` (`country_id`),
  ADD KEY `group_id` (`group_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accessories`
--
ALTER TABLE `accessories`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;
--
-- AUTO_INCREMENT for table `classifications`
--
ALTER TABLE `classifications`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=724;
--
-- AUTO_INCREMENT for table `discounts`
--
ALTER TABLE `discounts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;
--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `orders_products`
--
ALTER TABLE `orders_products`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;
--
-- AUTO_INCREMENT for table `products_images`
--
ALTER TABLE `products_images`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;
--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
