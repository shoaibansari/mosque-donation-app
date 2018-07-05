-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 14, 2018 at 04:05 PM
-- Server version: 10.1.22-MariaDB
-- PHP Version: 7.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jaria_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` int(10) UNSIGNED NOT NULL,
  `module` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `action` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `user_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `details` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`id`, `module`, `action`, `user_id`, `user_name`, `details`, `created_at`, `updated_at`) VALUES
(2, 'hoa', 'create', 1, 'Admin', '<a href=\"http://www.flash-drive.site/backoffice/978/users/edit/1\">Admin</a> has created a HOA <a href=\"http://www.flash-drive.site/backoffice/978/areas/edit/12\">HOA# 212</a>', '2018-04-25 06:52:29', '2018-04-25 06:52:29'),
(3, 'hoa', 'delete', 1, 'Admin', '<a href=\"http://www.flash-drive.site/backoffice/978/users/edit/1\">Admin</a> has deleted a HOA <a href=\"http://www.flash-drive.site/backoffice/978/areas/edit/12\">HOA# 212</a>', '2018-04-25 06:52:36', '2018-04-25 06:52:36'),
(4, 'hoa', 'update', 1, 'Admin', '<a href=\"http://www.flash-drive.site/backoffice/978/users/edit/1\">Admin</a> has updated a HOA <a href=\"http://www.flash-drive.site/backoffice/978/areas/edit/11\">HOA #411</a>', '2018-04-25 06:52:42', '2018-04-25 06:52:42'),
(5, 'hoa', 'import', 1, 'Admin', '<a href=\"http://www.flash-drive.site/backoffice/978/users/edit/1\">Admin</a> has imported homeowners in HOA <a href=\"http://www.flash-drive.site/backoffice/978/areas/edit/8\">HOA# 5</a>', '2018-04-25 06:58:10', '2018-04-25 06:58:10'),
(6, 'drive', 'create', 1, 'Admin', '<a href=\"http://www.flash-drive.site/backoffice/978/users/edit/1\">Admin</a> has created a drive <a href=\"http://www.flash-drive.site/backoffice/978/jobs/view/25\">2018-04-25</a>', '2018-04-25 06:58:29', '2018-04-25 06:58:29'),
(7, 'drive', 'accept', 2, 'Demo Driver', '<a href=\"http://www.flash-drive.site/backoffice/978/users/edit/2\">Demo Driver</a> has accepted a drive <a href=\"http://www.flash-drive.site/backoffice/978/jobs/view/25\">2018-04-25</a>', '2018-04-25 06:58:56', '2018-04-25 06:58:56'),
(8, 'drive', 'update', 1, 'Admin', '<a href=\"http://www.flash-drive.site/backoffice/978/users/edit/1\">Admin</a> has updated a drive <a href=\"http://www.flash-drive.site/backoffice/978/jobs/view/25\">2018-04-25</a>', '2018-04-25 06:58:56', '2018-04-25 06:58:56'),
(9, 'drive', 'reject', 1, 'Admin', '<a href=\"http://www.flash-drive.site/backoffice/978/users/edit/1\">Admin</a> has rejected a drive <a href=\"http://www.flash-drive.site/backoffice/978/jobs/view/25\">2018-04-25</a>', '2018-04-25 06:59:33', '2018-04-25 06:59:33'),
(10, 'drive', 'update', 1, 'Admin', '<a href=\"http://www.flash-drive.site/backoffice/978/users/edit/1\">Admin</a> has updated a drive <a href=\"http://www.flash-drive.site/backoffice/978/jobs/view/25\">2018-04-25</a>', '2018-04-25 06:59:33', '2018-04-25 06:59:33'),
(11, 'drive', 'delete', 1, 'Admin', '<a href=\"http://www.flash-drive.site/backoffice/978/users/edit/1\">Admin</a> has deleted a drive <a href=\"http://www.flash-drive.site/backoffice/978/jobs/view/25\">2018-04-25</a>', '2018-04-25 06:59:37', '2018-04-25 06:59:37'),
(12, 'drive', 'complete', 1, 'Admin', '<a href=\"http://www.flash-drive.site/backoffice/978/users/edit/1\">Admin</a> has completed a drive <a href=\"http://www.flash-drive.site/backoffice/978/jobs/view/23\">2018-04-25</a>', '2018-04-25 06:59:56', '2018-04-25 06:59:56'),
(13, 'drive', 'import', 1, 'Admin', '<a href=\"http://www.flash-drive.site/backoffice/978/users/edit/1\">Admin</a> has imported homeowners in drive <a href=\"http://www.flash-drive.site/backoffice/978/jobs/view/23\">drive</a>', '2018-04-25 07:00:03', '2018-04-25 07:00:03'),
(14, 'location_photo', 'upload', 1, 'Admin', '<a href=\"http://www.flash-drive.site/backoffice/978/users/edit/1\">Admin</a> has uploaded images in address <a href=\"http://www.flash-drive.site/backoffice/978/jobs/view/image/23/3\">2504 SIR BARTON BAY SCHERTZ, TX 78154</a>', '2018-04-25 07:00:28', '2018-04-25 07:00:28'),
(15, 'location_photo', 'upload', 1, 'Admin', '<a href=\"http://www.flash-drive.site/backoffice/978/users/edit/1\">Admin</a> has uploaded images in address <a href=\"http://www.flash-drive.site/backoffice/978/jobs/view/image/23/3\">2504 SIR BARTON BAY SCHERTZ, TX 78154</a>', '2018-04-25 07:00:39', '2018-04-25 07:00:39'),
(16, 'location_photo', 'delete', 1, 'Admin', '<a href=\"http://www.flash-drive.site/backoffice/978/users/edit/1\">Admin</a> has deleted image from address <a href=\"http://www.flash-drive.site/backoffice/978/jobs/view/image/23/3\">2504 SIR BARTON BAY SCHERTZ, TX 78154</a>', '2018-04-25 07:00:43', '2018-04-25 07:00:43'),
(17, 'location_violation', 'report violation', 1, 'Admin', '<a href=\"http://www.flash-drive.site/backoffice/978/users/edit/1\">Admin</a> has reported violations on address <a href=\"http://www.flash-drive.site/backoffice/978/location/violations/view/3\">2504 SIR BARTON BAY SCHERTZ, TX 78154</a>', '2018-04-25 07:01:09', '2018-04-25 07:01:09'),
(18, 'driver', 'update', 1, 'Admin', '<a href=\"http://www.flash-drive.site/backoffice/978/users/edit/1\">Admin</a> has updated a driver <a href=\"http://www.flash-drive.site/backoffice/978/vehicles/edit/1\">driver</a>', '2018-04-25 09:36:16', '2018-04-25 09:36:16'),
(19, 'driver', 'create', 1, 'Admin', '<a href=\"http://www.flash-drive.site/backoffice/978/users/edit/1\">Admin</a> has created a driver <a href=\"http://www.flash-drive.site/backoffice/978/vehicles/edit/2\">driver</a>', '2018-04-25 09:47:13', '2018-04-25 09:47:13'),
(20, 'driver', 'delete', 1, 'Admin', '<a href=\"http://www.flash-drive.site/backoffice/978/users/edit/1\">Admin</a> has deleted a driver <a href=\"http://www.flash-drive.site/backoffice/978/vehicles/edit/2\">driver</a>', '2018-04-25 09:47:24', '2018-04-25 09:47:24'),
(21, 'driver', 'update', 1, 'Admin', '<a href=\"http://www.flash-drive.site/backoffice/978/users/edit/1\">Admin</a> has updated a driver <a href=\"http://www.flash-drive.site/backoffice/978/vehicles/edit/1\">Vehicle #1</a>', '2018-04-25 09:50:44', '2018-04-25 09:50:44'),
(22, 'driver', 'create', 1, 'Admin', '<a href=\"http://www.flash-drive.site/backoffice/978/users/edit/1\">Admin</a> has created a driver <a href=\"http://www.flash-drive.site/backoffice/978/vehicles/edit/3\">Driver Test</a>', '2018-04-25 09:51:02', '2018-04-25 09:51:02'),
(23, 'driver', 'delete', 1, 'Admin', '<a href=\"http://www.flash-drive.site/backoffice/978/users/edit/1\">Admin</a> has deleted a driver <a href=\"http://www.flash-drive.site/backoffice/978/vehicles/edit/3\">Driver Test</a>', '2018-04-25 09:51:23', '2018-04-25 09:51:23'),
(24, 'driver', 'create', 1, 'Admin', '<a href=\"http://www.flash-drive.site/backoffice/978/users/edit/1\">Admin</a> has created a driver <a href=\"http://www.flash-drive.site/backoffice/978/vehicles/edit/4\">Test Driver</a>', '2018-04-25 09:51:41', '2018-04-25 09:51:41'),
(25, 'driver', 'delete', 1, 'Admin', '<a href=\"http://www.flash-drive.site/backoffice/978/users/edit/1\">Admin</a> has deleted a driver <a href=\"http://www.flash-drive.site/backoffice/978/vehicles/edit/4\">Test Driver</a>', '2018-04-25 09:51:46', '2018-04-25 09:51:46'),
(26, 'camera', 'create', 1, 'Admin', '<a href=\"http://www.flash-drive.site/backoffice/978/users/edit/1\">Admin</a> has created a camera <a href=\"http://www.flash-drive.site/backoffice/978/cameras/edit/4\">Camera#4</a>', '2018-04-25 09:56:06', '2018-04-25 09:56:06'),
(27, 'camera', 'delete', 1, 'Admin', '<a href=\"http://www.flash-drive.site/backoffice/978/users/edit/1\">Admin</a> has deleted a camera <a href=\"http://www.flash-drive.site/backoffice/978/cameras/edit/4\">Camera#4</a>', '2018-04-25 09:57:49', '2018-04-25 09:57:49'),
(28, 'camera', 'update', 1, 'Admin', '<a href=\"http://www.flash-drive.site/backoffice/978/users/edit/1\">Admin</a> has updated a camera <a href=\"http://www.flash-drive.site/backoffice/978/cameras/edit/3\">Camera#3</a>', '2018-04-25 09:59:15', '2018-04-25 09:59:15');

-- --------------------------------------------------------

--
-- Table structure for table `areas`
--

CREATE TABLE `areas` (
  `id` int(10) UNSIGNED NOT NULL,
  `creator_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(45) DEFAULT NULL,
  `active` tinyint(1) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `areas`
--

INSERT INTO `areas` (`id`, `creator_id`, `title`, `active`, `created_at`, `updated_at`) VALUES
(1, 1, 'First Homeowner Association', 1, '2018-02-20 07:39:21', '2018-02-20 07:39:21'),
(2, 1, 'HOA# 2', 1, '2018-02-21 10:28:11', '2018-02-21 10:28:11'),
(4, 1, 'HOA #4', 1, '2018-03-14 11:45:33', '2018-03-14 11:45:33'),
(8, 1, 'HOA# 5', 1, '2018-04-24 18:58:34', '2018-04-24 18:58:34'),
(9, 1, 'HOA #66', 1, '2018-04-25 06:48:36', '2018-04-25 06:48:36'),
(10, 1, 'HOA# 244', 1, '2018-04-25 06:49:33', '2018-04-25 06:49:33'),
(11, 1, 'HOA #411', 1, '2018-04-25 06:51:19', '2018-04-25 06:51:19');

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `subject` varchar(120) DEFAULT NULL,
  `details` text,
  `is_read` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(80) DEFAULT NULL,
  `code` varchar(4) DEFAULT NULL,
  `currency_name` varchar(40) DEFAULT NULL,
  `currency_code` varchar(40) DEFAULT NULL,
  `currency_symbol` varchar(4) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `code`, `currency_name`, `currency_code`, `currency_symbol`, `active`, `created_at`, `updated_at`) VALUES
(1, NULL, 'AF', 'AFN', 'Afghani', '', 1, NULL, NULL),
(2, NULL, 'AL', 'ALL', 'Lek', '', 1, NULL, NULL),
(3, NULL, 'DZ', 'DZD', 'Dinar', '', 1, NULL, NULL),
(4, NULL, 'AS', 'USD', 'Dollar', '', 1, NULL, NULL),
(5, NULL, 'AD', 'EUR', 'Euro', '', 1, NULL, NULL),
(6, NULL, 'AO', 'AOA', 'Kwanza', '', 1, NULL, NULL),
(7, NULL, 'AI', 'XCD', 'Dollar', '', 1, NULL, NULL),
(8, NULL, 'AG', 'XCD', 'Dollar', '', 1, NULL, NULL),
(9, NULL, 'AR', 'ARS', 'Peso', '', 1, NULL, NULL),
(10, NULL, 'AM', 'AMD', 'Dram', '', 1, NULL, NULL),
(11, NULL, 'AW', 'AWG', 'Guilder', '', 1, NULL, NULL),
(12, NULL, 'AU', 'AUD', 'Dollar', '', 1, NULL, NULL),
(13, NULL, 'AT', 'EUR', 'Euro', '', 1, NULL, NULL),
(14, NULL, 'AZ', 'AZN', 'Manat', '', 1, NULL, NULL),
(15, NULL, 'BS', 'BSD', 'Dollar', '', 1, NULL, NULL),
(16, NULL, 'BH', 'BHD', 'Dinar', '', 1, NULL, NULL),
(17, NULL, 'BD', 'BDT', 'Taka', '', 1, NULL, NULL),
(18, NULL, 'BB', 'BBD', 'Dollar', '', 1, NULL, NULL),
(19, NULL, 'BY', 'BYR', 'Ruble', '', 1, NULL, NULL),
(20, NULL, 'BE', 'EUR', 'Euro', '', 1, NULL, NULL),
(21, NULL, 'BZ', 'BZD', 'Dollar', '', 1, NULL, NULL),
(22, NULL, 'BJ', 'XOF', 'Franc', '', 1, NULL, NULL),
(23, NULL, 'BM', 'BMD', 'Dollar', '', 1, NULL, NULL),
(24, NULL, 'BT', 'BTN', 'Ngultrum', '', 1, NULL, NULL),
(25, NULL, 'BO', 'BOB', 'Boliviano', '', 1, NULL, NULL),
(26, NULL, 'BA', 'BAM', 'Marka', '', 1, NULL, NULL),
(27, NULL, 'BW', 'BWP', 'Pula', '', 1, NULL, NULL),
(28, NULL, 'BV', 'NOK', 'Krone', '', 1, NULL, NULL),
(29, NULL, 'BR', 'BRL', 'Real', '', 1, NULL, NULL),
(30, NULL, 'IO', 'USD', 'Dollar', '', 1, NULL, NULL),
(31, NULL, 'VG', 'USD', 'Dollar', '', 1, NULL, NULL),
(32, NULL, 'BN', 'BND', 'Dollar', '', 1, NULL, NULL),
(33, NULL, 'BG', 'BGN', 'Lev', '', 1, NULL, NULL),
(34, NULL, 'BF', 'XOF', 'Franc', '', 1, NULL, NULL),
(35, NULL, 'BI', 'BIF', 'Franc', '', 1, NULL, NULL),
(36, NULL, 'KH', 'KHR', 'Riels', '', 1, NULL, NULL),
(37, NULL, 'CM', 'XAF', 'Franc', '', 1, NULL, NULL),
(38, NULL, 'CA', 'CAD', 'Dollar', '', 1, NULL, NULL),
(39, NULL, 'CV', 'CVE', 'Escudo', '', 1, NULL, NULL),
(40, NULL, 'KY', 'KYD', 'Dollar', '', 1, NULL, NULL),
(41, NULL, 'CF', 'XAF', 'Franc', '', 1, NULL, NULL),
(42, NULL, 'TD', 'XAF', 'Franc', '', 1, NULL, NULL),
(43, NULL, 'CL', 'CLP', 'Peso', '', 1, NULL, NULL),
(44, NULL, 'CN', 'CNY', 'Yuan Renminbi', '', 1, NULL, NULL),
(45, NULL, 'CX', 'AUD', 'Dollar', '', 1, NULL, NULL),
(46, NULL, 'CC', 'AUD', 'Dollar', '', 1, NULL, NULL),
(47, NULL, 'CO', 'COP', 'Peso', '', 1, NULL, NULL),
(48, NULL, 'KM', 'KMF', 'Franc', '', 1, NULL, NULL),
(49, NULL, 'CK', 'NZD', 'Dollar', '', 1, NULL, NULL),
(50, NULL, 'CR', 'CRC', 'Colon', '', 1, NULL, NULL),
(51, NULL, 'HR', 'HRK', 'Kuna', '', 1, NULL, NULL),
(52, NULL, 'CU', 'CUP', 'Peso', '', 1, NULL, NULL),
(53, NULL, 'CY', 'CYP', 'Pound', '', 1, NULL, NULL),
(54, NULL, 'CZ', 'CZK', 'Koruna', '', 1, NULL, NULL),
(55, NULL, 'CD', 'CDF', 'Franc', '', 1, NULL, NULL),
(56, NULL, 'DK', 'DKK', 'Krone', '', 1, NULL, NULL),
(57, NULL, 'DJ', 'DJF', 'Franc', '', 1, NULL, NULL),
(58, NULL, 'DM', 'XCD', 'Dollar', '', 1, NULL, NULL),
(59, NULL, 'DO', 'DOP', 'Peso', '', 1, NULL, NULL),
(60, NULL, 'TL', 'USD', 'Dollar', '', 1, NULL, NULL),
(61, NULL, 'EC', 'USD', 'Dollar', '', 1, NULL, NULL),
(62, NULL, 'EG', 'EGP', 'Pound', '', 1, NULL, NULL),
(63, NULL, 'SV', 'SVC', 'Colone', '', 1, NULL, NULL),
(64, NULL, 'GQ', 'XAF', 'Franc', '', 1, NULL, NULL),
(65, NULL, 'ER', 'ERN', 'Nakfa', '', 1, NULL, NULL),
(66, NULL, 'EE', 'EEK', 'Kroon', '', 1, NULL, NULL),
(67, NULL, 'ET', 'ETB', 'Birr', '', 1, NULL, NULL),
(68, NULL, 'FK', 'FKP', 'Pound', '', 1, NULL, NULL),
(69, NULL, 'FO', 'DKK', 'Krone', '', 1, NULL, NULL),
(70, NULL, 'FJ', 'FJD', 'Dollar', '', 1, NULL, NULL),
(71, NULL, 'FI', 'EUR', 'Euro', '', 1, NULL, NULL),
(72, NULL, 'FR', 'EUR', 'Euro', '', 1, NULL, NULL),
(73, NULL, 'GF', 'EUR', 'Euro', '', 1, NULL, NULL),
(74, NULL, 'PF', 'XPF', 'Franc', '', 1, NULL, NULL),
(75, NULL, 'TF', 'EUR', 'Euro  ', '', 1, NULL, NULL),
(76, NULL, 'GA', 'XAF', 'Franc', '', 1, NULL, NULL),
(77, NULL, 'GM', 'GMD', 'Dalasi', '', 1, NULL, NULL),
(78, NULL, 'GE', 'GEL', 'Lari', '', 1, NULL, NULL),
(79, NULL, 'DE', 'EUR', 'Euro', '', 1, NULL, NULL),
(80, NULL, 'GH', 'GHC', 'Cedi', '', 1, NULL, NULL),
(81, NULL, 'GI', 'GIP', 'Pound', '', 1, NULL, NULL),
(82, NULL, 'GR', 'EUR', 'Euro', '', 1, NULL, NULL),
(83, NULL, 'GL', 'DKK', 'Krone', '', 1, NULL, NULL),
(84, NULL, 'GD', 'XCD', 'Dollar', '', 1, NULL, NULL),
(85, NULL, 'GP', 'EUR', 'Euro', '', 1, NULL, NULL),
(86, NULL, 'GU', 'USD', 'Dollar', '', 1, NULL, NULL),
(87, NULL, 'GT', 'GTQ', 'Quetzal', '', 1, NULL, NULL),
(88, NULL, 'GN', 'GNF', 'Franc', '', 1, NULL, NULL),
(89, NULL, 'GW', 'XOF', 'Franc', '', 1, NULL, NULL),
(90, NULL, 'GY', 'GYD', 'Dollar', '', 1, NULL, NULL),
(91, NULL, 'HT', 'HTG', 'Gourde', '', 1, NULL, NULL),
(92, NULL, 'HM', 'AUD', 'Dollar', '', 1, NULL, NULL),
(93, NULL, 'HN', 'HNL', 'Lempira', '', 1, NULL, NULL),
(94, NULL, 'HK', 'HKD', 'Dollar', '', 1, NULL, NULL),
(95, NULL, 'HU', 'HUF', 'Forint', '', 1, NULL, NULL),
(96, NULL, 'IS', 'ISK', 'Krona', '', 1, NULL, NULL),
(97, NULL, 'IN', 'INR', 'Rupee', '', 1, NULL, NULL),
(98, NULL, 'ID', 'IDR', 'Rupiah', '', 1, NULL, NULL),
(99, NULL, 'IR', 'IRR', 'Rial', '', 1, NULL, NULL),
(100, NULL, 'IQ', 'IQD', 'Dinar', '', 1, NULL, NULL),
(101, NULL, 'IE', 'EUR', 'Euro', '', 1, NULL, NULL),
(102, NULL, 'IL', 'ILS', 'Shekel', '', 1, NULL, NULL),
(103, NULL, 'IT', 'EUR', 'Euro', '', 1, NULL, NULL),
(104, NULL, 'CI', 'XOF', 'Franc', '', 1, NULL, NULL),
(105, NULL, 'JM', 'JMD', 'Dollar', '', 1, NULL, NULL),
(106, NULL, 'JP', 'JPY', 'Yen', '', 1, NULL, NULL),
(107, NULL, 'JO', 'JOD', 'Dinar', '', 1, NULL, NULL),
(108, NULL, 'KZ', 'KZT', 'Tenge', '', 1, NULL, NULL),
(109, NULL, 'KE', 'KES', 'Shilling', '', 1, NULL, NULL),
(110, NULL, 'KI', 'AUD', 'Dollar', '', 1, NULL, NULL),
(111, NULL, 'KW', 'KWD', 'Dinar', '', 1, NULL, NULL),
(112, NULL, 'KG', 'KGS', 'Som', '', 1, NULL, NULL),
(113, NULL, 'LA', 'LAK', 'Kip', '', 1, NULL, NULL),
(114, NULL, 'LV', 'LVL', 'Lat', '', 1, NULL, NULL),
(115, NULL, 'LB', 'LBP', 'Pound', '', 1, NULL, NULL),
(116, NULL, 'LS', 'LSL', 'Loti', '', 1, NULL, NULL),
(117, NULL, 'LR', 'LRD', 'Dollar', '', 1, NULL, NULL),
(118, NULL, 'LY', 'LYD', 'Dinar', '', 1, NULL, NULL),
(119, NULL, 'LI', 'CHF', 'Franc', '', 1, NULL, NULL),
(120, NULL, 'LT', 'LTL', 'Litas', '', 1, NULL, NULL),
(121, NULL, 'LU', 'EUR', 'Euro', '', 1, NULL, NULL),
(122, NULL, 'MO', 'MOP', 'Pataca', '', 1, NULL, NULL),
(123, NULL, 'MK', 'MKD', 'Denar', '', 1, NULL, NULL),
(124, NULL, 'MG', 'MGA', 'Ariary', '', 1, NULL, NULL),
(125, NULL, 'MW', 'MWK', 'Kwacha', '', 1, NULL, NULL),
(126, NULL, 'MY', 'MYR', 'Ringgit', '', 1, NULL, NULL),
(127, NULL, 'MV', 'MVR', 'Rufiyaa', '', 1, NULL, NULL),
(128, NULL, 'ML', 'XOF', 'Franc', '', 1, NULL, NULL),
(129, NULL, 'MT', 'MTL', 'Lira', '', 1, NULL, NULL),
(130, NULL, 'MH', 'USD', 'Dollar', '', 1, NULL, NULL),
(131, NULL, 'MQ', 'EUR', 'Euro', '', 1, NULL, NULL),
(132, NULL, 'MR', 'MRO', 'Ouguiya', '', 1, NULL, NULL),
(133, NULL, 'MU', 'MUR', 'Rupee', '', 1, NULL, NULL),
(134, NULL, 'YT', 'EUR', 'Euro', '', 1, NULL, NULL),
(135, NULL, 'MX', 'MXN', 'Peso', '', 1, NULL, NULL),
(136, NULL, 'FM', 'USD', 'Dollar', '', 1, NULL, NULL),
(137, NULL, 'MD', 'MDL', 'Leu', '', 1, NULL, NULL),
(138, NULL, 'MC', 'EUR', 'Euro', '', 1, NULL, NULL),
(139, NULL, 'MN', 'MNT', 'Tugrik', '', 1, NULL, NULL),
(140, NULL, 'MS', 'XCD', 'Dollar', '', 1, NULL, NULL),
(141, NULL, 'MA', 'MAD', 'Dirham', '', 1, NULL, NULL),
(142, NULL, 'MZ', 'MZN', 'Meticail', '', 1, NULL, NULL),
(143, NULL, 'MM', 'MMK', 'Kyat', '', 1, NULL, NULL),
(144, NULL, 'NA', 'NAD', 'Dollar', '', 1, NULL, NULL),
(145, NULL, 'NR', 'AUD', 'Dollar', '', 1, NULL, NULL),
(146, NULL, 'NP', 'NPR', 'Rupee', '', 1, NULL, NULL),
(147, NULL, 'NL', 'EUR', 'Euro', '', 1, NULL, NULL),
(148, NULL, 'AN', 'ANG', 'Guilder', '', 1, NULL, NULL),
(149, NULL, 'NC', 'XPF', 'Franc', '', 1, NULL, NULL),
(150, NULL, 'NZ', 'NZD', 'Dollar', '', 1, NULL, NULL),
(151, NULL, 'NI', 'NIO', 'Cordoba', '', 1, NULL, NULL),
(152, NULL, 'NE', 'XOF', 'Franc', '', 1, NULL, NULL),
(153, NULL, 'NG', 'NGN', 'Naira', '', 1, NULL, NULL),
(154, NULL, 'NU', 'NZD', 'Dollar', '', 1, NULL, NULL),
(155, NULL, 'NF', 'AUD', 'Dollar', '', 1, NULL, NULL),
(156, NULL, 'KP', 'KPW', 'Won', '', 1, NULL, NULL),
(157, NULL, 'MP', 'USD', 'Dollar', '', 1, NULL, NULL),
(158, NULL, 'NO', 'NOK', 'Krone', '', 1, NULL, NULL),
(159, NULL, 'OM', 'OMR', 'Rial', '', 1, NULL, NULL),
(160, NULL, 'PK', 'PKR', 'Rupee', '', 1, NULL, NULL),
(161, NULL, 'PW', 'USD', 'Dollar', '', 1, NULL, NULL),
(162, NULL, 'PS', 'ILS', 'Shekel', '', 1, NULL, NULL),
(163, NULL, 'PA', 'PAB', 'Balboa', '', 1, NULL, NULL),
(164, NULL, 'PG', 'PGK', 'Kina', '', 1, NULL, NULL),
(165, NULL, 'PY', 'PYG', 'Guarani', '', 1, NULL, NULL),
(166, NULL, 'PE', 'PEN', 'Sol', '', 1, NULL, NULL),
(167, NULL, 'PH', 'PHP', 'Peso', '', 1, NULL, NULL),
(168, NULL, 'PN', 'NZD', 'Dollar', '', 1, NULL, NULL),
(169, NULL, 'PL', 'PLN', 'Zloty', '', 1, NULL, NULL),
(170, NULL, 'PT', 'EUR', 'Euro', '', 1, NULL, NULL),
(171, NULL, 'PR', 'USD', 'Dollar', '', 1, NULL, NULL),
(172, NULL, 'QA', 'QAR', 'Rial', '', 1, NULL, NULL),
(173, NULL, 'CG', 'XAF', 'Franc', '', 1, NULL, NULL),
(174, NULL, 'RE', 'EUR', 'Euro', '', 1, NULL, NULL),
(175, NULL, 'RO', 'RON', 'Leu', '', 1, NULL, NULL),
(176, NULL, 'RU', 'RUB', 'Ruble', '', 1, NULL, NULL),
(177, NULL, 'RW', 'RWF', 'Franc', '', 1, NULL, NULL),
(178, NULL, 'SH', 'SHP', 'Pound', '', 1, NULL, NULL),
(179, NULL, 'KN', 'XCD', 'Dollar', '', 1, NULL, NULL),
(180, NULL, 'LC', 'XCD', 'Dollar', '', 1, NULL, NULL),
(181, NULL, 'PM', 'EUR', 'Euro', '', 1, NULL, NULL),
(182, NULL, 'VC', 'XCD', 'Dollar', '', 1, NULL, NULL),
(183, NULL, 'WS', 'WST', 'Tala', '', 1, NULL, NULL),
(184, NULL, 'SM', 'EUR', 'Euro', '', 1, NULL, NULL),
(185, NULL, 'ST', 'STD', 'Dobra', '', 1, NULL, NULL),
(186, NULL, 'SA', 'SAR', 'Rial', '', 1, NULL, NULL),
(187, NULL, 'SN', 'XOF', 'Franc', '', 1, NULL, NULL),
(188, NULL, 'CS', 'RSD', 'Dinar', '', 1, NULL, NULL),
(189, NULL, 'SC', 'SCR', 'Rupee', '', 1, NULL, NULL),
(190, NULL, 'SL', 'SLL', 'Leone', '', 1, NULL, NULL),
(191, NULL, 'SG', 'SGD', 'Dollar', '', 1, NULL, NULL),
(192, NULL, 'SK', 'SKK', 'Koruna', '', 1, NULL, NULL),
(193, NULL, 'SI', 'EUR', 'Euro', '', 1, NULL, NULL),
(194, NULL, 'SB', 'SBD', 'Dollar', '', 1, NULL, NULL),
(195, NULL, 'SO', 'SOS', 'Shilling', '', 1, NULL, NULL),
(196, NULL, 'ZA', 'ZAR', 'Rand', '', 1, NULL, NULL),
(197, NULL, 'GS', 'GBP', 'Pound', '', 1, NULL, NULL),
(198, NULL, 'KR', 'KRW', 'Won', '', 1, NULL, NULL),
(199, NULL, 'ES', 'EUR', 'Euro', '', 1, NULL, NULL),
(200, NULL, 'LK', 'LKR', 'Rupee', '', 1, NULL, NULL),
(201, NULL, 'SD', 'SDD', 'Dinar', '', 1, NULL, NULL),
(202, NULL, 'SR', 'SRD', 'Dollar', '', 1, NULL, NULL),
(203, NULL, 'SJ', 'NOK', 'Krone', '', 1, NULL, NULL),
(204, NULL, 'SZ', 'SZL', 'Lilangeni', '', 1, NULL, NULL),
(205, NULL, 'SE', 'SEK', 'Krona', '', 1, NULL, NULL),
(206, NULL, 'CH', 'CHF', 'Franc', '', 1, NULL, NULL),
(207, NULL, 'SY', 'SYP', 'Pound', '', 1, NULL, NULL),
(208, NULL, 'TW', 'TWD', 'Dollar', '', 1, NULL, NULL),
(209, NULL, 'TJ', 'TJS', 'Somoni', '', 1, NULL, NULL),
(210, NULL, 'TZ', 'TZS', 'Shilling', '', 1, NULL, NULL),
(211, NULL, 'TH', 'THB', 'Baht', '', 1, NULL, NULL),
(212, NULL, 'TG', 'XOF', 'Franc', '', 1, NULL, NULL),
(213, NULL, 'TK', 'NZD', 'Dollar', '', 1, NULL, NULL),
(214, NULL, 'TO', 'TOP', 'Pa\'anga', '', 1, NULL, NULL),
(215, NULL, 'TT', 'TTD', 'Dollar', '', 1, NULL, NULL),
(216, NULL, 'TN', 'TND', 'Dinar', '', 1, NULL, NULL),
(217, NULL, 'TR', 'TRY', 'Lira', '', 1, NULL, NULL),
(218, NULL, 'TM', 'TMM', 'Manat', '', 1, NULL, NULL),
(219, NULL, 'TC', 'USD', 'Dollar', '', 1, NULL, NULL),
(220, NULL, 'TV', 'AUD', 'Dollar', '', 1, NULL, NULL),
(221, NULL, 'VI', 'USD', 'Dollar', '', 1, NULL, NULL),
(222, NULL, 'UG', 'UGX', 'Shilling', '', 1, NULL, NULL),
(223, NULL, 'UA', 'UAH', 'Hryvnia', '', 1, NULL, NULL),
(224, NULL, 'AE', 'AED', 'Dirham', '', 1, NULL, NULL),
(225, NULL, 'GB', 'GBP', 'Pound', '', 1, NULL, NULL),
(226, NULL, 'US', 'USD', 'Dollar', '', 1, NULL, NULL),
(227, NULL, 'UM', 'USD', 'Dollar ', '', 1, NULL, NULL),
(228, NULL, 'UY', 'UYU', 'Peso', '', 1, NULL, NULL),
(229, NULL, 'UZ', 'UZS', 'Som', '', 1, NULL, NULL),
(230, NULL, 'VU', 'VUV', 'Vatu', '', 1, NULL, NULL),
(231, NULL, 'VA', 'EUR', 'Euro', '', 1, NULL, NULL),
(232, NULL, 'VE', 'VEF', 'Bolivar', '', 1, NULL, NULL),
(233, NULL, 'VN', 'VND', 'Dong', '', 1, NULL, NULL),
(234, NULL, 'WF', 'XPF', 'Franc', '', 1, NULL, NULL),
(235, NULL, 'EH', 'MAD', 'Dirham', '', 1, NULL, NULL),
(236, NULL, 'YE', 'YER', 'Rial', '', 1, NULL, NULL),
(237, NULL, 'ZM', 'ZMK', 'Kwacha', '', 1, NULL, NULL),
(238, NULL, 'ZW', 'ZWD', 'Dollar', '', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(10) UNSIGNED NOT NULL,
  `area_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `self_allocate` tinyint(1) DEFAULT '0',
  `requested_at` timestamp NULL DEFAULT NULL,
  `is_accepted` tinyint(1) DEFAULT '0',
  `accepted_at` timestamp NULL DEFAULT NULL,
  `is_completed` tinyint(1) DEFAULT '0',
  `is_forcefully_completed` tinyint(1) DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `area_id`, `name`, `self_allocate`, `requested_at`, `is_accepted`, `accepted_at`, `is_completed`, `is_forcefully_completed`, `completed_at`, `created_at`, `updated_at`) VALUES
(8, 1, '2018-03-28', 1, '2018-04-24 18:21:55', 1, '2018-04-24 18:21:55', 1, 1, '2018-04-23 06:37:36', '2018-03-27 06:28:03', '2018-04-24 18:21:55'),
(21, 4, '2018-04-23', 1, '2018-04-23 06:31:14', 1, '2018-04-23 06:31:14', 1, 1, '2018-04-24 18:27:25', '2018-04-23 06:31:14', '2018-04-24 18:27:25'),
(23, 2, '2018-04-25', 1, '2018-04-24 18:21:08', 1, '2018-04-24 18:21:08', 1, 1, '2018-04-25 06:59:56', '2018-04-24 18:21:08', '2018-04-25 06:59:56'),
(24, 8, '2018-04-25', 1, '2018-04-24 18:59:01', 1, '2018-04-24 18:59:01', 1, 1, '2018-04-24 18:59:27', '2018-04-24 18:59:01', '2018-04-24 18:59:27');

-- --------------------------------------------------------

--
-- Stand-in structure for view `jobs_view`
-- (See below for the actual view)
--
CREATE TABLE `jobs_view` (
);

-- --------------------------------------------------------

--
-- Table structure for table `location_photos`
--

CREATE TABLE `location_photos` (
  `id` int(10) UNSIGNED NOT NULL,
  `job_id` int(10) UNSIGNED DEFAULT NULL,
  `location_id` int(11) NOT NULL,
  `filename` varchar(350) DEFAULT NULL,
  `filesize` int(11) DEFAULT NULL,
  `camera_number` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `location_photos`
--

INSERT INTO `location_photos` (`id`, `job_id`, `location_id`, `filename`, `filesize`, `camera_number`, `created_at`, `updated_at`) VALUES
(2, 8, 1, '1-the-edge-cornwall-exterior5-via-smallhousebliss-jpg-1524055766-1524055766.jpg', 82150, 0, '2018-04-18 07:49:26', '2018-04-18 07:49:26'),
(6, 8, 1, '1-2-gozygl-jpg-1524490472-1524490472.jpg', 77132, 0, '2018-04-23 08:34:32', '2018-04-23 08:34:32'),
(9, 8, 1, '1-2017-best-houses-62-jpg-1524490473-1524490473.jpg', 107446, 0, '2018-04-23 08:34:33', '2018-04-23 08:34:33'),
(12, 24, 40, '40-vintagecity-788556-jpg-1524614831-1524614831.jpg', 1081335, 0, '2018-04-24 19:07:12', '2018-04-24 19:07:12'),
(13, 24, 40, '40-Cities-Stone-Street-the-old-town-099497-jpg-1524614841-1524614841.jpg', 629523, 0, '2018-04-24 19:07:21', '2018-04-24 19:07:21'),
(14, 24, 40, '40-vintagecity-788556-jpg-1524614868-1524614868.jpg', 1081335, 0, '2018-04-24 19:07:48', '2018-04-24 19:07:48'),
(15, 24, 40, '40-wallpaper-4k-nature-wallpaper-7260-jpg-1524614937-1524614937.jpg', 953944, 0, '2018-04-24 19:08:58', '2018-04-24 19:08:58'),
(16, 23, 3, '3-Cities-Stone-Street-the-old-town-099497-jpg-1524657627-1524657627.jpg', 629523, 0, '2018-04-25 07:00:28', '2018-04-25 07:00:28');

-- --------------------------------------------------------

--
-- Stand-in structure for view `location_violations_view`
-- (See below for the actual view)
--
CREATE TABLE `location_violations_view` (
);

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(10) UNSIGNED NOT NULL,
  `ip_address` varchar(30) DEFAULT NULL,
  `country_code` varchar(2) DEFAULT NULL,
  `email` varchar(80) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `login_history`
--

CREATE TABLE `login_history` (
  `id` int(10) UNSIGNED NOT NULL,
  `ip_address` varchar(30) DEFAULT NULL,
  `country_code` varchar(2) DEFAULT NULL,
  `login_via` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `active` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(80) DEFAULT NULL,
  `item_type` enum('page','category','url','site_root','slug') DEFAULT NULL,
  `link_to` varchar(500) DEFAULT NULL,
  `target` varchar(30) DEFAULT NULL,
  `active` tinyint(4) DEFAULT NULL,
  `display_order` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `menu_id` int(10) UNSIGNED NOT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2018_05_09_082034_create_mosques_table', 1),
(2, '2018_05_10_120715_create_user_mosques_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `mosques`
--

CREATE TABLE `mosques` (
  `id` int(10) UNSIGNED NOT NULL,
  `mosque_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `authorized_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zip_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_account` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tax_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mosques`
--

INSERT INTO `mosques` (`id`, `mosque_name`, `authorized_name`, `email`, `address`, `zip_code`, `phone`, `bank_account`, `tax_id`, `created_at`, `updated_at`) VALUES
(17, 'Mosque', 'Mosque', 'mosque1@gmail.com', 'dsfdsfds', '0000', '000000000', '0000000000', '13345', '2018-05-11 08:24:29', '2018-05-11 08:24:29');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(10) UNSIGNED NOT NULL,
  `slug` varchar(240) DEFAULT NULL,
  `slug_editable` tinyint(1) DEFAULT NULL,
  `banner` varchar(80) DEFAULT NULL,
  `background` varchar(80) DEFAULT NULL,
  `heading` varchar(80) DEFAULT NULL,
  `abstract` text,
  `contents` text,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_keywords` varchar(255) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `published` tinyint(1) DEFAULT NULL,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `slug`, `slug_editable`, `banner`, `background`, `heading`, `abstract`, `contents`, `meta_title`, `meta_keywords`, `meta_description`, `published`, `published_at`, `created_at`, `updated_at`) VALUES
(1, '', 0, '', '', 'Home Page', '', '<p>Sample page contents</p>', NULL, NULL, NULL, 1, '2017-12-29 14:02:35', '2017-12-29 14:02:35', '2017-12-29 09:10:36'),
(2, 'about', 0, 'header', NULL, 'Heading', NULL, 'Test', NULL, NULL, NULL, 1, '2017-12-29 14:02:35', '2017-12-29 14:02:35', '2017-12-29 14:02:35');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('driver@gmail.com', '$2y$10$c0emUaYL22KNDR1ch1AWG.hv8lRXSgTXvb4bEI7mnoGmjdSsWYvPm', '2018-02-25 15:40:29');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(45) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `title`, `active`, `created_at`, `updated_at`) VALUES
(1, 'Can upload property photos', 1, '2017-12-15 10:55:45', '2017-12-15 10:55:48'),
(2, 'Can remove property photos', 1, '2017-12-15 10:55:45', '2017-12-15 10:55:45'),
(3, 'Can report report violations', 1, '2017-12-15 10:55:45', '2017-12-15 10:55:45'),
(7, 'Can see violation details', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(45) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `is_deleteable` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `title`, `active`, `is_deleteable`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 1, 0, '2017-12-15 05:51:00', '2017-12-27 09:47:37'),
(2, 'Mosque Admin', 1, 0, '2017-12-15 05:51:00', '2017-12-27 12:07:14'),
(3, 'Donor', 1, 0, '2017-12-15 05:51:00', '2017-12-27 09:54:41');

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

CREATE TABLE `role_permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `permission_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `role_permissions`
--

INSERT INTO `role_permissions` (`id`, `role_id`, `permission_id`) VALUES
(1, 1, 1),
(15, 2, 1),
(16, 2, 2),
(18, 2, 7),
(19, 3, 3),
(20, 3, 7),
(21, 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` enum('general','social-link','local','user-interface','vendor','debug','single') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `label` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `default_value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `editable` tinyint(1) DEFAULT '1',
  `visible` tinyint(1) DEFAULT '1',
  `display_order` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `type`, `label`, `key`, `value`, `default_value`, `editable`, `visible`, `display_order`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'general', 'Site Name', 'app.name', 'Jaria', 'Jaria', 1, 1, 1, '2017-11-29 15:24:49', '2017-11-29 15:24:49', NULL),
(2, 'general', 'Version', 'app.version', '1.0.0', '1.0.0', 0, 1, 2, '2017-11-29 15:24:49', '2017-11-29 15:24:49', NULL),
(3, 'general', 'Installation Date', 'app.installation_at', '2017-11-29 20:24:49', '2017-11-29 20:24:49', 0, 1, 3, '2017-11-29 15:24:49', '2017-11-29 15:24:49', NULL),
(4, 'general', 'First Name', 'client.first_name', 'Admin', 'Admin', 0, 0, 4, '2017-11-02 06:32:34', '2017-11-02 06:32:34', NULL),
(5, 'general', 'Last Name', 'client.last_name', '', '', 0, 0, 5, '2017-11-02 06:32:34', '2017-11-02 06:32:34', NULL),
(6, 'general', 'Admin Email', 'client.email', 'admin@flashdrive.com', 'admin@flashdrive.com', 1, 1, 6, '2017-11-02 06:32:34', '2017-11-02 06:32:34', NULL),
(7, 'general', 'Phone Plain', 'phone.plain', '+0012145503360', '', 1, 1, 7, '2017-11-02 06:32:34', '2017-11-02 06:32:34', NULL),
(8, 'general', 'Phone Formatted', 'phone.formatted', '+1-214-550-3360', '', 1, 1, 8, '2017-11-02 06:32:34', '2017-11-02 06:32:34', NULL),
(9, 'general', 'Email - Info', 'email.info', 'info@flashdrive.com', 'info@flashdrive.com', 1, 1, 9, '2017-11-02 06:32:34', '2017-11-02 06:32:34', NULL),
(10, 'general', 'Email - Support', 'email.support', 'support@flashdrive.com', 'support@flashdrive.com', 1, 1, 10, '2017-11-02 06:32:34', '2017-11-02 06:32:34', NULL),
(11, 'general', 'Email - No Reply', 'email.no_reply', 'no-reply@flashdrive.com', 'no-reply@flashdrive.com', 1, 1, 11, '2017-11-02 06:32:34', '2017-11-02 06:32:34', NULL),
(12, 'general', 'Admin Login Base', 'backend.admin.base', 'backoffice/978/', 'backoffice/978/', 0, 0, 12, '2017-11-02 06:32:34', '2017-11-02 06:32:34', NULL),
(15, 'user-interface', 'Theme - Frontend', 'theme.frontend', 'default', 'default', 0, 0, 1, '2017-11-02 06:32:34', '2017-11-02 06:32:34', NULL),
(16, 'user-interface', 'Theme - Admin Panel', 'theme.backoffice', 'default', 'default', 0, 0, 2, '2017-11-02 06:32:34', '2017-11-02 06:32:34', NULL),
(17, 'user-interface', 'Theme - User Panel', 'theme.users-area', 'default', 'default', 0, 0, 3, '2017-11-02 06:32:34', '2017-11-02 06:32:34', NULL),
(24, 'local', 'Timezone Name', 'timezone.name', 'America/Chicago', 'GMT', 0, 1, 1, '2017-11-02 06:32:34', '2017-11-02 06:32:34', NULL),
(25, 'local', 'Timezone Offset', 'timezone.offset', '0', '0', 0, 0, 2, '2017-11-02 06:32:34', '2017-11-02 06:32:34', NULL),
(26, 'local', 'Time Format - Short', 'time.format.short', 'H:i', 'h:i A', 0, 1, 3, '2017-11-02 06:32:34', '2017-11-02 06:32:34', NULL),
(27, 'local', 'Time Format - Long', 'time.format.long', 'h:i A', 'h:i:s A', 0, 1, 4, '2017-11-02 06:32:34', '2017-11-02 06:32:34', NULL),
(28, 'local', 'Time Format - Full', 'time.format.full', 'h:i:s A', 'h:i:u A', 0, 0, 5, '2017-11-02 06:32:34', '2017-11-02 06:32:34', NULL),
(29, 'local', 'Date Format - Short', 'date.format.short', 'm/d/Y', 'm/d/Y', 0, 1, 6, '2017-11-02 06:32:34', '2017-11-02 06:32:34', NULL),
(30, 'local', 'Date Format - Long', 'date.format.long', 'F d, Y', 'F d, Y', 0, 1, 7, '2017-11-02 06:32:34', '2017-11-02 06:32:34', NULL),
(31, 'local', 'Date Format - Full', 'date.format.full', 'D, F d, Y', 'D, F d, Y', 0, 0, 8, '2017-11-02 06:32:34', '2017-11-02 06:32:34', NULL),
(32, 'local', 'Language', 'language.default', 'EN-US', 'EN-US', 0, 1, 9, '2017-11-02 06:32:34', '2017-11-02 06:32:34', NULL),
(33, 'local', 'Supported Languages', 'supported.languages', 'EN-US', 'EN-US', 0, 0, 10, '2017-11-02 06:32:34', '2017-11-02 06:32:34', NULL),
(34, 'vendor', 'Vendor Name', 'vendor.name', 'FSD Solutions LLC', 'FSD Solutions LLC', 0, 1, 1, '2017-11-02 06:32:34', '2017-11-02 06:32:34', NULL),
(35, 'vendor', 'Vendor URL', 'vendor.url', 'http://www.fsdsolutions.com', 'http://www.fsdsolutions.com', 0, 1, 2, '2017-11-02 06:32:34', '2017-11-02 06:32:34', NULL),
(36, 'debug', 'On Error Send Email', 'on_error.send_email', '1', '1', 1, 0, 3, '2017-11-02 06:32:34', '2017-11-02 06:32:34', NULL),
(37, 'debug', 'On Error Send Email To', 'on_error.email', 'adnan@fsdsolutions.com', 'adnan@fsdsolutions.com', 1, 0, 4, '2017-11-02 06:32:34', '2017-11-02 06:32:34', NULL),
(38, 'debug', 'On Error Email Subject', 'on_error.email.subject', 'Error has occured in FlashDrive.com website', 'Error has occured in FlashDrive.com website', 1, 0, 5, '2017-11-02 06:32:34', '2017-11-02 06:32:34', NULL),
(39, 'general', 'Google Analytics ID', 'google.analytics', '', '', 1, 1, 13, '2017-11-02 06:32:34', '2017-11-02 06:32:34', NULL),
(40, 'general', 'Page Editor', 'wysiwyg.editor', 'tinymce', 'tinymce', 1, 0, 14, '2017-11-02 06:32:34', '2017-11-02 06:32:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` int(11) NOT NULL,
  `code` char(2) COLLATE utf8_unicode_ci NOT NULL,
  `name` char(40) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `code`, `name`, `active`, `created_at`, `updated_at`) VALUES
(1, 'AK', 'Alaska', 1, NULL, NULL),
(2, 'AL', 'Alabama', 1, NULL, NULL),
(3, 'AS', 'American Samoa', 1, NULL, NULL),
(4, 'AZ', 'Arizona', 1, NULL, NULL),
(5, 'AR', 'Arkansas', 1, NULL, NULL),
(6, 'CA', 'California', 1, NULL, NULL),
(7, 'CO', 'Colorado', 1, NULL, NULL),
(8, 'CT', 'Connecticut', 1, NULL, NULL),
(9, 'DE', 'Delaware', 1, NULL, NULL),
(10, 'DC', 'District of Columbia', 1, NULL, NULL),
(11, 'FM', 'Federated States of Micronesia', 1, NULL, NULL),
(12, 'FL', 'Florida', 1, NULL, NULL),
(13, 'GA', 'Georgia', 1, NULL, NULL),
(14, 'GU', 'Guam', 1, NULL, NULL),
(15, 'HI', 'Hawaii', 1, NULL, NULL),
(16, 'ID', 'Idaho', 1, NULL, NULL),
(17, 'IL', 'Illinois', 1, NULL, NULL),
(18, 'IN', 'Indiana', 1, NULL, NULL),
(19, 'IA', 'Iowa', 1, NULL, NULL),
(20, 'KS', 'Kansas', 1, NULL, NULL),
(21, 'KY', 'Kentucky', 1, NULL, NULL),
(22, 'LA', 'Louisiana', 1, NULL, NULL),
(23, 'ME', 'Maine', 1, NULL, NULL),
(24, 'MH', 'Marshall Islands', 1, NULL, NULL),
(25, 'MD', 'Maryland', 1, NULL, NULL),
(26, 'MA', 'Massachusetts', 1, NULL, NULL),
(27, 'MI', 'Michigan', 1, NULL, NULL),
(28, 'MN', 'Minnesota', 1, NULL, NULL),
(29, 'MS', 'Mississippi', 1, NULL, NULL),
(30, 'MO', 'Missouri', 1, NULL, NULL),
(31, 'MT', 'Montana', 1, NULL, NULL),
(32, 'NE', 'Nebraska', 1, NULL, NULL),
(33, 'NV', 'Nevada', 1, NULL, NULL),
(34, 'NH', 'New Hampshire', 1, NULL, NULL),
(35, 'NJ', 'New Jersey', 1, NULL, NULL),
(36, 'NM', 'New Mexico', 1, NULL, NULL),
(37, 'NY', 'New York', 1, NULL, NULL),
(38, 'NC', 'North Carolina', 1, NULL, NULL),
(39, 'ND', 'North Dakota', 1, NULL, NULL),
(40, 'MP', 'Northern Mariana Islands', 1, NULL, NULL),
(41, 'OH', 'Ohio', 1, NULL, NULL),
(42, 'OK', 'Oklahoma', 1, NULL, NULL),
(43, 'OR', 'Oregon', 1, NULL, NULL),
(44, 'PW', 'Palau', 1, NULL, NULL),
(45, 'PA', 'Pennsylvania', 1, NULL, NULL),
(46, 'PR', 'Puerto Rico', 1, NULL, NULL),
(47, 'RI', 'Rhode Island', 1, NULL, NULL),
(48, 'SC', 'South Carolina', 1, NULL, NULL),
(49, 'SD', 'South Dakota', 1, NULL, NULL),
(50, 'TN', 'Tennessee', 1, NULL, NULL),
(51, 'TX', 'Texas', 1, NULL, NULL),
(52, 'UT', 'Utah', 1, NULL, NULL),
(53, 'VT', 'Vermont', 1, NULL, NULL),
(54, 'VI', 'Virgin Islands', 1, NULL, NULL),
(55, 'VA', 'Virginia', 1, NULL, NULL),
(56, 'WA', 'Washington', 1, NULL, NULL),
(57, 'WV', 'West Virginia', 1, NULL, NULL),
(58, 'WI', 'Wisconsin', 1, NULL, NULL),
(59, 'WY', 'Wyoming', 1, NULL, NULL),
(60, 'AE', 'Armed Forces Africa', 0, NULL, NULL),
(61, 'AA', 'Armed Forces Americas (except Canada)', 0, NULL, NULL),
(62, 'AE', 'Armed Forces Canada', 0, NULL, NULL),
(63, 'AE', 'Armed Forces Europe', 0, NULL, NULL),
(64, 'AE', 'Armed Forces Middle East', 0, NULL, NULL),
(65, 'AP', 'Armed Forces Pacific', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(45) NOT NULL,
  `email` varchar(80) NOT NULL,
  `password` varchar(80) NOT NULL,
  `last_login_at` datetime DEFAULT NULL,
  `is_blocked` tinyint(4) DEFAULT '0',
  `blocked_reason` varchar(1000) DEFAULT NULL,
  `is_confirmed` tinyint(4) DEFAULT '0',
  `user_type` tinyint(1) DEFAULT NULL,
  `is_administrative_user` tinyint(1) DEFAULT '0',
  `confirmation_code` varchar(45) DEFAULT NULL,
  `confirmed_at` timestamp NULL DEFAULT NULL,
  `avatar` varchar(80) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `is_deleteable` tinyint(1) DEFAULT '1',
  `device_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `last_login_at`, `is_blocked`, `blocked_reason`, `is_confirmed`, `user_type`, `is_administrative_user`, `confirmation_code`, `confirmed_at`, `avatar`, `created_at`, `updated_at`, `remember_token`, `is_deleteable`, `device_id`) VALUES
(1, 'Admin', 'admin@jaria.com', '$2y$10$WITeTOZTzrPwod7xcs881udtZ.m0cCKdKuNUHn9ezwOQsqy7GDtpW', NULL, 0, NULL, 1, 0, 1, NULL, NULL, '1-1519348064.jpg', NULL, '2018-02-22 20:07:44', 'Fg1RyuDS291dxBIwJDIQzsheO7AJHmbY8bqHBEMxZPyflcZZGNS9lI6MFmQw', 0, 0),
(17, 'Mosque Admin 2', 'mosque@gmail.com', '$2y$10$WITeTOZTzrPwod7xcs881udtZ.m0cCKdKuNUHn9ezwOQsqy7GDtpW', '2018-05-14 08:49:32', 0, NULL, 1, 2, 0, 'Xx6g0pY3E4Gj9y395hd70046j35t2A', NULL, '17-1525941668.jpg', '2018-05-10 03:41:08', '2018-05-14 03:49:32', 'y49eMV7F8eOQZyzFx6nDWgdMIq8kEKpUFpUM3cPdGNkBUQpkS28qP6mOkxkg', 1, 1),
(20, 'Shoaib', 'shoaib.fsdsolutions@gmail.com', '', '2018-05-10 10:16:09', 0, NULL, 1, 3, 0, '', '2018-05-10 04:44:51', '20-1525947473.jpg', '2018-05-10 04:43:21', '2018-05-11 09:41:17', 'JTMd6E2N8NA67E90l9LlVRngKhXiNlOxjPreAOYNjOrrdbNDCuykkhnIL3qX', 1, 0),
(21, 'Mosque Admin 1', 'mosque1@gmail.com', '$2y$10$qM/G9igloIIxhug.6xEGY.uf1dgrAspXu8X4ynkiK6/UoV1MItPSm', NULL, 0, NULL, 1, 2, 0, 'c26k1Tz6378i2CGzme66iHN8kW3YeZ', NULL, '21-1525962203.jpg', '2018-05-10 09:23:22', '2018-05-10 09:23:24', NULL, 1, 0),
(24, 'donoruser', 'donoruser1@gmail.com', '$2y$10$hjNmiYq1IPMf.t4nAsELbOUGJNWSKD2hutvPNjxAXzR.nIUacqUgm', NULL, 0, NULL, 1, 3, 0, '', '2018-05-14 08:25:27', NULL, '2018-05-14 08:06:50', '2018-05-14 08:44:45', 'ogAWrvIfBqCIoSfO4F1u419cd1aS3u0pJfMZtzPtsSwvRVQ94rthUqGwyHE0', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_activities`
--

CREATE TABLE `user_activities` (
  `id` int(10) UNSIGNED NOT NULL,
  `activity_type` enum('photos taken') DEFAULT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_devices`
--

CREATE TABLE `user_devices` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `platform` enum('ios','android','windows') DEFAULT NULL,
  `os_version` varchar(50) DEFAULT NULL,
  `device_id` varchar(45) DEFAULT NULL,
  `gcm_id` varchar(45) DEFAULT NULL COMMENT 'Google Cloud Message - ID',
  `notifications` tinyint(1) DEFAULT '1',
  `badges` int(10) UNSIGNED DEFAULT '0',
  `latitude` varchar(25) DEFAULT NULL,
  `longitude` varchar(25) DEFAULT NULL,
  `last_activity_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_devices`
--

INSERT INTO `user_devices` (`id`, `user_id`, `token`, `platform`, `os_version`, `device_id`, `gcm_id`, `notifications`, `badges`, `latitude`, `longitude`, `last_activity_at`, `created_at`, `updated_at`) VALUES
(1, 24, '', '', '', NULL, '', 0, 0, '', '', '2018-05-14 08:32:10', NULL, '2018-05-14 08:35:13'),
(2, 17, 'adccb6f6cbe0c3ad003db370ccaf74f5f6555470', '', '', '12', '', 0, 0, '', '', '2018-05-14 07:10:59', '2018-05-14 07:07:13', '2018-05-14 07:10:59');

-- --------------------------------------------------------

--
-- Table structure for table `user_locations`
--

CREATE TABLE `user_locations` (
  `id` int(11) NOT NULL,
  `homeowner_id` int(10) UNSIGNED NOT NULL,
  `address` varchar(500) DEFAULT NULL,
  `street` varchar(80) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `state` varchar(45) DEFAULT NULL,
  `zip` varchar(30) DEFAULT NULL,
  `country` varchar(2) DEFAULT 'US',
  `latitude` varchar(25) DEFAULT NULL,
  `longitude` varchar(25) DEFAULT NULL,
  `is_approved` tinyint(1) DEFAULT '-1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_locations`
--

INSERT INTO `user_locations` (`id`, `homeowner_id`, `address`, `street`, `city`, `state`, `zip`, `country`, `latitude`, `longitude`, `is_approved`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 5, '2500 PILLORY POINTE SCHERTZ, TX 78154', NULL, NULL, NULL, NULL, 'US', '29.610300942799284', '-98.24732331349185', 1, '2018-02-20 07:39:21', '2018-02-20 07:40:30', NULL),
(2, 6, '2504 PILLORY POINTE SCHERTZ, TX 78154', NULL, NULL, NULL, NULL, 'US', '29.610195963144346', '-98.24705018895492', 1, '2018-02-20 07:39:21', '2018-02-20 07:40:30', NULL),
(3, 7, '2504 SIR BARTON BAY SCHERTZ, TX 78154', NULL, NULL, NULL, NULL, 'US', '29.610507296409157', '-98.2474695117088', 1, '2018-02-20 07:39:21', '2018-02-20 07:40:30', NULL),
(4, 8, '2505 PILLORY POINTE SCHERTZ, TX 78154', NULL, NULL, NULL, NULL, 'US', '29.61075210673709', '-98.2474609393359', 1, '2018-02-20 07:39:21', '2018-02-20 07:40:30', NULL),
(5, 9, '3416 Joy Lane Irvine CA California', '3416 Joy Lane', 'Irvine', 'CA', 'California', 'US', '29.61075210673709', '-98.2474609393359', 1, '2018-02-20 07:43:04', '2018-02-20 07:44:09', NULL),
(6, 10, '4473 Coolidge Street NEWPORT MI 48166', '4473 Coolidge Street', 'NEWPORT', 'MI', '48166', 'US', '29.61075210673709', '-98.2474609393359', 1, '2018-02-20 08:12:26', '2018-02-20 08:16:59', NULL),
(7, 11, 'A-13, Faraz Avenue, Block20, Gulstan-e-Johar Karachi Sindh 75290', 'A-13, Faraz Avenue, Block20, Gulstan-e-Johar', 'Karachi', 'Sindh', '75290', 'US', '24.9054322', '67.11450660000003', -1, '2018-02-20 12:30:26', '2018-02-20 12:30:26', NULL),
(8, 12, '6315 S Zarzamora St San Antonio TX 78211', '6315 S Zarzamora St', 'San Antonio', 'TX', '78211', 'US', '29.3651912', '-98.53463920000002', -1, '2018-02-20 12:39:09', '2018-02-20 12:39:09', NULL),
(9, 13, '2121 SW 36th St San Antonio tx 78237', '2121 SW 36th St', 'San Antonio', 'tx', '78237', 'US', '29.4081072', '-98.5755785', -1, '2018-02-20 12:42:08', '2018-02-20 12:42:08', NULL),
(10, 10, '1102 Barclay St San Antonio TX 78207', '1102 Barclay St', 'San Antonio', 'TX', '78207', 'US', '29.607800635712138', '-98.24242663583982', 1, '2018-02-20 20:09:43', '2018-02-21 10:27:12', NULL),
(11, 5, '2500 PILLORY POINTE SCHERTZ, TX 78154', NULL, NULL, NULL, NULL, 'US', '29.610300942799284', '-98.24732331349185', 1, '2018-02-21 10:28:11', '2018-02-21 10:28:11', NULL),
(12, 6, '2504 PILLORY POINTE SCHERTZ, TX 78154', NULL, NULL, NULL, NULL, 'US', '29.610195963144346', '-98.24705018895492', 1, '2018-02-21 10:28:11', '2018-02-21 10:28:11', NULL),
(13, 7, '2504 SIR BARTON BAY SCHERTZ, TX 78154', NULL, NULL, NULL, NULL, 'US', '29.610507296409157', '-98.2474695117088', 1, '2018-02-21 10:28:11', '2018-02-21 10:28:11', NULL),
(14, 8, '2505 PILLORY POINTE SCHERTZ, TX 78154', NULL, NULL, NULL, NULL, 'US', '29.61075210673709', '-98.2474609393359', 1, '2018-02-21 10:28:11', '2018-02-21 10:28:11', NULL),
(15, 5, '2500 PILLORY POINTE SCHERTZ, TX 78154', NULL, NULL, NULL, NULL, 'US', '29.610300942799284', '-98.24732331349185', 1, '2018-02-21 18:41:59', '2018-02-21 18:41:59', NULL),
(16, 6, '2504 PILLORY POINTE SCHERTZ, TX 78154', NULL, NULL, NULL, NULL, 'US', '29.610195963144346', '-98.24705018895492', 1, '2018-02-21 18:41:59', '2018-02-21 18:41:59', NULL),
(17, 7, '2504 SIR BARTON BAY SCHERTZ, TX 78154', NULL, NULL, NULL, NULL, 'US', '29.610507296409157', '-98.2474695117088', 1, '2018-02-21 18:41:59', '2018-02-21 18:41:59', NULL),
(18, 8, '2505 PILLORY POINTE SCHERTZ, TX 78154', NULL, NULL, NULL, NULL, 'US', '29.61075210673709', '-98.2474609393359', 1, '2018-02-21 18:41:59', '2018-02-21 18:41:59', NULL),
(19, 5, '2500 PILLORY POINTE SCHERTZ, TX 78154', NULL, NULL, NULL, NULL, 'US', '29.610300942799284', '-98.24732331349185', 1, '2018-02-26 16:02:35', '2018-02-26 16:02:35', NULL),
(20, 6, '2504 PILLORY POINTE SCHERTZ, TX 78154', NULL, NULL, NULL, NULL, 'US', '29.610195963144346', '-98.24705018895492', 1, '2018-02-26 16:02:35', '2018-02-26 16:02:35', NULL),
(21, 7, '2504 SIR BARTON BAY SCHERTZ, TX 78154', NULL, NULL, NULL, NULL, 'US', '29.610507296409157', '-98.2474695117088', 1, '2018-02-26 16:02:35', '2018-02-26 16:02:35', NULL),
(22, 8, '2505 PILLORY POINTE SCHERTZ, TX 78154', NULL, NULL, NULL, NULL, 'US', '29.61075210673709', '-98.2474609393359', 1, '2018-02-26 16:02:35', '2018-02-26 16:02:35', NULL),
(23, 14, 'A-13, Faraz Avenue, Block20, Gulstan-e-Johar Karachi Sindh 75290', 'A-13, Faraz Avenue, Block20, Gulstan-e-Johar', 'Karachi', 'Sindh', '75290', 'US', '24.9054322', '67.11450660000003', -1, '2018-02-27 07:04:47', '2018-02-27 07:04:47', NULL),
(24, 5, '2500 PILLORY POINTE SCHERTZ, TX 78154', NULL, NULL, NULL, NULL, 'US', '29.610300942799284', '-98.24732331349185', 1, '2018-03-14 11:45:33', '2018-03-14 11:45:33', NULL),
(25, 6, '2504 PILLORY POINTE SCHERTZ, TX 78154', NULL, NULL, NULL, NULL, 'US', '29.610195963144346', '-98.24705018895492', 1, '2018-03-14 11:45:33', '2018-03-14 11:45:33', NULL),
(26, 7, '2504 SIR BARTON BAY SCHERTZ, TX 78154', NULL, NULL, NULL, NULL, 'US', '29.610507296409157', '-98.2474695117088', 1, '2018-03-14 11:45:33', '2018-03-14 11:45:33', NULL),
(27, 8, '2505 PILLORY POINTE SCHERTZ, TX 78154', NULL, NULL, NULL, NULL, 'US', '29.61075210673709', '-98.2474609393359', 1, '2018-03-14 11:45:33', '2018-03-14 11:45:33', NULL),
(28, 5, '2500 PILLORY POINTE SCHERTZ, TX 78154', NULL, NULL, NULL, NULL, 'US', '29.610300942799284', '-98.24732331349185', 1, '2018-04-23 05:00:06', '2018-04-23 05:00:06', NULL),
(29, 6, '2504 PILLORY POINTE SCHERTZ, TX 78154', NULL, NULL, NULL, NULL, 'US', '29.610195963144346', '-98.24705018895492', 1, '2018-04-23 05:00:06', '2018-04-23 05:00:06', NULL),
(30, 7, '2504 SIR BARTON BAY SCHERTZ, TX 78154', NULL, NULL, NULL, NULL, 'US', '29.610507296409157', '-98.2474695117088', 1, '2018-04-23 05:00:06', '2018-04-23 05:00:06', NULL),
(31, 8, '2505 PILLORY POINTE SCHERTZ, TX 78154', NULL, NULL, NULL, NULL, 'US', '29.61075210673709', '-98.2474609393359', 1, '2018-04-23 05:00:06', '2018-04-23 05:00:06', NULL),
(32, 5, '2500 PILLORY POINTE SCHERTZ, TX 78154', NULL, NULL, NULL, NULL, 'US', '29.610300942799284', '-98.24732331349185', 1, '2018-04-23 05:03:17', '2018-04-23 05:03:17', NULL),
(33, 6, '2504 PILLORY POINTE SCHERTZ, TX 78154', NULL, NULL, NULL, NULL, 'US', '29.610195963144346', '-98.24705018895492', 1, '2018-04-23 05:03:17', '2018-04-23 05:03:17', NULL),
(34, 7, '2504 SIR BARTON BAY SCHERTZ, TX 78154', NULL, NULL, NULL, NULL, 'US', '29.610507296409157', '-98.2474695117088', 1, '2018-04-23 05:03:17', '2018-04-23 05:03:17', NULL),
(35, 8, '2505 PILLORY POINTE SCHERTZ, TX 78154', NULL, NULL, NULL, NULL, 'US', '29.61075210673709', '-98.2474609393359', 1, '2018-04-23 05:03:17', '2018-04-23 05:03:17', NULL),
(36, 5, '2500 PILLORY POINTE SCHERTZ, TX 78154', NULL, NULL, NULL, NULL, 'US', '29.610300942799284', '-98.24732331349185', 1, '2018-04-24 18:55:06', '2018-04-24 18:55:06', NULL),
(37, 6, '2504 PILLORY POINTE SCHERTZ, TX 78154', NULL, NULL, NULL, NULL, 'US', '29.610195963144346', '-98.24705018895492', 1, '2018-04-24 18:55:06', '2018-04-24 18:55:06', NULL),
(38, 7, '2504 SIR BARTON BAY SCHERTZ, TX 78154', NULL, NULL, NULL, NULL, 'US', '29.610507296409157', '-98.2474695117088', 1, '2018-04-24 18:55:06', '2018-04-24 18:55:06', NULL),
(39, 8, '2505 PILLORY POINTE SCHERTZ, TX 78154', NULL, NULL, NULL, NULL, 'US', '29.61075210673709', '-98.2474609393359', 1, '2018-04-24 18:55:06', '2018-04-24 18:55:06', NULL),
(40, 5, '2500 PILLORY POINTE SCHERTZ, TX 78154', NULL, NULL, NULL, NULL, 'US', '29.610300942799284', '-98.24732331349185', 1, '2018-04-24 18:58:34', '2018-04-24 18:58:34', NULL),
(41, 6, '2504 PILLORY POINTE SCHERTZ, TX 78154', NULL, NULL, NULL, NULL, 'US', '29.610195963144346', '-98.24705018895492', 1, '2018-04-24 18:58:34', '2018-04-24 18:58:34', NULL),
(42, 7, '2504 SIR BARTON BAY SCHERTZ, TX 78154', NULL, NULL, NULL, NULL, 'US', '29.610507296409157', '-98.2474695117088', 1, '2018-04-24 18:58:34', '2018-04-24 18:58:34', NULL),
(43, 8, '2505 PILLORY POINTE SCHERTZ, TX 78154', NULL, NULL, NULL, NULL, 'US', '29.61075210673709', '-98.2474609393359', 1, '2018-04-24 18:58:34', '2018-04-24 18:58:34', NULL),
(44, 5, '2500 PILLORY POINTE SCHERTZ, TX 78154', NULL, NULL, NULL, NULL, 'US', '29.610300942799284', '-98.24732331349185', 1, '2018-04-25 06:48:36', '2018-04-25 06:48:36', NULL),
(45, 6, '2504 PILLORY POINTE SCHERTZ, TX 78154', NULL, NULL, NULL, NULL, 'US', '29.610195963144346', '-98.24705018895492', 1, '2018-04-25 06:48:36', '2018-04-25 06:48:36', NULL),
(46, 7, '2504 SIR BARTON BAY SCHERTZ, TX 78154', NULL, NULL, NULL, NULL, 'US', '29.610507296409157', '-98.2474695117088', 1, '2018-04-25 06:48:36', '2018-04-25 06:48:36', NULL),
(47, 8, '2505 PILLORY POINTE SCHERTZ, TX 78154', NULL, NULL, NULL, NULL, 'US', '29.61075210673709', '-98.2474609393359', 1, '2018-04-25 06:48:36', '2018-04-25 06:48:36', NULL),
(48, 5, '2500 PILLORY POINTE SCHERTZ, TX 78154', NULL, NULL, NULL, NULL, 'US', '29.610300942799284', '-98.24732331349185', 1, '2018-04-25 06:49:33', '2018-04-25 06:49:33', NULL),
(49, 6, '2504 PILLORY POINTE SCHERTZ, TX 78154', NULL, NULL, NULL, NULL, 'US', '29.610195963144346', '-98.24705018895492', 1, '2018-04-25 06:49:33', '2018-04-25 06:49:33', NULL),
(50, 7, '2504 SIR BARTON BAY SCHERTZ, TX 78154', NULL, NULL, NULL, NULL, 'US', '29.610507296409157', '-98.2474695117088', 1, '2018-04-25 06:49:34', '2018-04-25 06:49:34', NULL),
(51, 8, '2505 PILLORY POINTE SCHERTZ, TX 78154', NULL, NULL, NULL, NULL, 'US', '29.61075210673709', '-98.2474609393359', 1, '2018-04-25 06:49:34', '2018-04-25 06:49:34', NULL),
(52, 5, '2500 PILLORY POINTE SCHERTZ, TX 78154', NULL, NULL, NULL, NULL, 'US', '29.610300942799284', '-98.24732331349185', 1, '2018-04-25 06:51:19', '2018-04-25 06:51:19', NULL),
(53, 6, '2504 PILLORY POINTE SCHERTZ, TX 78154', NULL, NULL, NULL, NULL, 'US', '29.610195963144346', '-98.24705018895492', 1, '2018-04-25 06:51:19', '2018-04-25 06:51:19', NULL),
(54, 7, '2504 SIR BARTON BAY SCHERTZ, TX 78154', NULL, NULL, NULL, NULL, 'US', '29.610507296409157', '-98.2474695117088', 1, '2018-04-25 06:51:19', '2018-04-25 06:51:19', NULL),
(55, 8, '2505 PILLORY POINTE SCHERTZ, TX 78154', NULL, NULL, NULL, NULL, 'US', '29.61075210673709', '-98.2474609393359', 1, '2018-04-25 06:51:19', '2018-04-25 06:51:19', NULL),
(56, 5, '2500 PILLORY POINTE SCHERTZ, TX 78154', NULL, NULL, NULL, NULL, 'US', '29.610300942799284', '-98.24732331349185', 1, '2018-04-25 06:52:29', '2018-04-25 06:52:29', NULL),
(57, 6, '2504 PILLORY POINTE SCHERTZ, TX 78154', NULL, NULL, NULL, NULL, 'US', '29.610195963144346', '-98.24705018895492', 1, '2018-04-25 06:52:29', '2018-04-25 06:52:29', NULL),
(58, 7, '2504 SIR BARTON BAY SCHERTZ, TX 78154', NULL, NULL, NULL, NULL, 'US', '29.610507296409157', '-98.2474695117088', 1, '2018-04-25 06:52:29', '2018-04-25 06:52:29', NULL),
(59, 8, '2505 PILLORY POINTE SCHERTZ, TX 78154', NULL, NULL, NULL, NULL, 'US', '29.61075210673709', '-98.2474609393359', 1, '2018-04-25 06:52:29', '2018-04-25 06:52:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_mosques`
--

CREATE TABLE `user_mosques` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `mosque_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_mosques`
--

INSERT INTO `user_mosques` (`id`, `user_id`, `mosque_id`) VALUES
(109, 17, 17),
(110, 20, 17);

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`id`, `user_id`, `role_id`) VALUES
(1, 1, 1),
(2, 2, 2),
(4, 3, 3),
(5, 15, 2),
(6, 16, 3);

-- --------------------------------------------------------

--
-- Structure for view `jobs_view`
--
DROP TABLE IF EXISTS `jobs_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`homestead`@`%` SQL SECURITY DEFINER VIEW `jobs_view`  AS  (select `j`.`id` AS `id`,`j`.`area_id` AS `area_id`,`j`.`name` AS `name`,`j`.`self_allocate` AS `self_allocate`,`j`.`requested_at` AS `requested_at`,`j`.`is_accepted` AS `is_accepted`,`j`.`accepted_at` AS `accepted_at`,`j`.`is_completed` AS `is_completed`,`j`.`is_forcefully_completed` AS `is_forcefully_completed`,`j`.`completed_at` AS `completed_at`,`j`.`created_at` AS `created_at`,`j`.`updated_at` AS `updated_at`,`areas`.`id` AS `hoa_id`,`areas`.`title` AS `hoa_title`,`u`.`id` AS `driver_id`,`u`.`name` AS `driver_name`,`u`.`email` AS `driver_email`,(select count(0) from `job_locations` where (`job_locations`.`job_id` = `j`.`id`)) AS `locations_count`,(select count(0) from `job_locations` where ((`job_locations`.`job_id` = `j`.`id`) and (`job_locations`.`is_completed` = '1'))) AS `locations_completed`,(select (`locations_count` - `locations_completed`)) AS `locations_remaining`,(select round(((`locations_completed` * 100) / `locations_count`),0)) AS `progress` from (((`jobs` `j` join `areas` on((`areas`.`id` = `j`.`area_id`))) left join `driver_job` `dj` on((`dj`.`job_id` = `j`.`id`))) left join `users` `u` on((`u`.`id` = `dj`.`driver_id`)))) ;

-- --------------------------------------------------------

--
-- Structure for view `location_violations_view`
--
DROP TABLE IF EXISTS `location_violations_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`homestead`@`%` SQL SECURITY DEFINER VIEW `location_violations_view`  AS  (select `lv`.`id` AS `id`,`lv`.`location_id` AS `location_id`,`lv`.`photo_id` AS `photo_id`,`lv`.`violation_id` AS `violation_id`,`lv`.`reporter_id` AS `reporter_id`,`lv`.`status_id` AS `status_id`,`lv`.`marked_photo` AS `marked_photo`,`lv`.`created_at` AS `created_at`,`lv`.`updated_at` AS `updated_at`,`u`.`name` AS `homeowner_name`,`u`.`avatar` AS `avatar`,`u`.`email` AS `homeowner_email`,`ul`.`homeowner_id` AS `homeowner_id`,`ul`.`address` AS `address`,`ul`.`street` AS `street`,`ul`.`city` AS `city`,`ul`.`state` AS `state`,`ul`.`zip` AS `zip`,`ul`.`country` AS `country`,`ul`.`latitude` AS `latitude`,`ul`.`longitude` AS `longitude`,`ul`.`is_approved` AS `is_approved`,`areas`.`title` AS `hoa`,`areas`.`id` AS `hoa_id`,`vs`.`title` AS `status`,`v`.`title` AS `violation_title`,'' AS `checkboxes` from ((((((`location_violations` `lv` join `user_locations` `ul` on((`ul`.`id` = `lv`.`location_id`))) join `users` `u` on((`u`.`id` = `ul`.`homeowner_id`))) join `area_locations` `al` on((`al`.`location_id` = `ul`.`id`))) join `areas` on((`areas`.`id` = `al`.`area_id`))) join `violation_statuses` `vs` on((`vs`.`id` = `lv`.`status_id`))) join `violations` `v` on((`v`.`id` = `lv`.`violation_id`))) where isnull(`ul`.`deleted_at`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_areas_users1_idx` (`creator_id`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_contacts_users1_idx` (`user_id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_area_users_areas1_idx` (`area_id`);

--
-- Indexes for table `location_photos`
--
ALTER TABLE `location_photos`
  ADD PRIMARY KEY (`id`,`location_id`),
  ADD KEY `fk_location_photos_user_locations1_idx` (`location_id`),
  ADD KEY `fk_location_photos_jobs1_idx` (`job_id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_history`
--
ALTER TABLE `login_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_login_history_users1_idx` (`user_id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_menu_items_menus1_idx` (`menu_id`),
  ADD KEY `fk_menu_items_menu_items1_idx` (`parent_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mosques`
--
ALTER TABLE `mosques`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`(255));

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_role_permissions_roles_idx` (`role_id`),
  ADD KEY `fk_role_permissions_permissions1_idx` (`permission_id`);

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
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_activities`
--
ALTER TABLE `user_activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_activities_users1_idx` (`user_id`);

--
-- Indexes for table `user_devices`
--
ALTER TABLE `user_devices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_users_devices_users1_idx` (`user_id`),
  ADD KEY `users_devices_token` (`token`);

--
-- Indexes for table `user_locations`
--
ALTER TABLE `user_locations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_locations_users1_idx` (`homeowner_id`);

--
-- Indexes for table `user_mosques`
--
ALTER TABLE `user_mosques`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_mosques_users1_idx` (`user_id`),
  ADD KEY `fk_user_mosques_mosques1_idx` (`mosque_id`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_roles_users1_idx` (`user_id`),
  ADD KEY `fk_user_roles_roles1_idx` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `areas`
--
ALTER TABLE `areas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=239;
--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `location_photos`
--
ALTER TABLE `location_photos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `login_history`
--
ALTER TABLE `login_history`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `mosques`
--
ALTER TABLE `mosques`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `role_permissions`
--
ALTER TABLE `role_permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `user_activities`
--
ALTER TABLE `user_activities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_devices`
--
ALTER TABLE `user_devices`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user_locations`
--
ALTER TABLE `user_locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;
--
-- AUTO_INCREMENT for table `user_mosques`
--
ALTER TABLE `user_mosques`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;
--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `areas`
--
ALTER TABLE `areas`
  ADD CONSTRAINT `fk_areas_users1` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD CONSTRAINT `fk_user_contacts_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `jobs`
--
ALTER TABLE `jobs`
  ADD CONSTRAINT `fk_area_users_areas1` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `location_photos`
--
ALTER TABLE `location_photos`
  ADD CONSTRAINT `fk_location_photos_jobs1` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_location_photos_user_locations1` FOREIGN KEY (`location_id`) REFERENCES `user_locations` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `login_history`
--
ALTER TABLE `login_history`
  ADD CONSTRAINT `fk_login_history_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD CONSTRAINT `fk_menu_items_menu_items1` FOREIGN KEY (`parent_id`) REFERENCES `menu_items` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_menu_items_menus1` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD CONSTRAINT `fk_role_permissions_permissions1` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_role_permissions_roles` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user_activities`
--
ALTER TABLE `user_activities`
  ADD CONSTRAINT `fk_user_activities_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user_devices`
--
ALTER TABLE `user_devices`
  ADD CONSTRAINT `fk_users_devices_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user_locations`
--
ALTER TABLE `user_locations`
  ADD CONSTRAINT `fk_user_locations_users1` FOREIGN KEY (`homeowner_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user_mosques`
--
ALTER TABLE `user_mosques`
  ADD CONSTRAINT `fk_user_mosques_mosques1` FOREIGN KEY (`mosque_id`) REFERENCES `mosques` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_mosques_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD CONSTRAINT `fk_user_roles_roles1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_roles_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
