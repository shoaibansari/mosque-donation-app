-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2018 at 02:02 PM
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
-- Table structure for table `donations`
--

CREATE TABLE `donations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `mosque_id` int(10) UNSIGNED NOT NULL,
  `donation_title` varchar(255) DEFAULT NULL,
  `donation_description` text,
  `required_amount` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `is_active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `funds`
--

CREATE TABLE `funds` (
  `id` int(11) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `mosque_id` int(10) UNSIGNED NOT NULL,
  `donation_id` int(10) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `payment` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `paypal_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zip_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_account` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tax_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` int(11) NOT NULL,
  `longitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mosques`
--

INSERT INTO `mosques` (`id`, `mosque_name`, `authorized_name`, `email`, `paypal_email`, `address`, `zip_code`, `phone`, `bank_account`, `tax_id`, `is_active`, `longitude`, `latitude`, `created_at`, `updated_at`) VALUES
(91, 'fsdf', 'sfsfs', 'mosqueasdsa@gmail.com', 'mosque@gmail.com', 'United States of America', '12345', '000000000', '00000000000000000000', '43242351111234', 0, '-95.71289100000001', '37.09024', '2018-05-31 05:34:05', '2018-05-31 05:34:05');

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
(1, 'general', 'Site Name', 'app.name', 'Jaria', 'Jaria', 1, 1, 1, '2017-11-29 15:24:49', '2018-05-21 05:29:53', NULL),
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
(39, 'general', 'Google Analytics ID', 'google.analytics', '', '', 1, 1, 13, '2017-11-02 06:32:34', '2018-05-21 05:29:53', NULL),
(40, 'general', 'Page Editor', 'wysiwyg.editor', 'tinymce', 'tinymce', 1, 0, 14, '2017-11-02 06:32:34', '2017-11-02 06:32:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(45) NOT NULL,
  `email` varchar(80) NOT NULL,
  `password` varchar(80) NOT NULL,
  `phone` varchar(12) DEFAULT NULL,
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

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `last_login_at`, `is_blocked`, `blocked_reason`, `is_confirmed`, `user_type`, `is_administrative_user`, `confirmation_code`, `confirmed_at`, `avatar`, `created_at`, `updated_at`, `remember_token`, `is_deleteable`, `device_id`) VALUES
(1, 'Admin', 'admin@jaria.com', '$2y$10$WITeTOZTzrPwod7xcs881udtZ.m0cCKdKuNUHn9ezwOQsqy7GDtpW', '', NULL, 0, NULL, 1, 1, 1, NULL, NULL, '1-1527759698.jpg', NULL, '2018-05-31 04:41:38', 'ilSqxmxO6SClMqQYEw32Zmm9NQTCAaot30ADB8dzu86irAeuqUS4EDplsztQ', 0, 0),
(65, 'Mosqueasd', 'mosqueasdsa@gmail.com', '$2y$10$BajFSAw/bxERJvZ9l8q4AO7RbmxOy6Nlk11uAQ4ELTTTie2SBMa0i', '000000000', NULL, 0, NULL, 1, 2, 0, '6k07C6EE34608962g923M82a045315', NULL, NULL, '2018-05-21 06:51:05', '2018-05-21 06:51:05', NULL, 1, 0),
(66, 'Mosquetfg', 'mosquefghf@gmail.com', '$2y$10$wO.3b/Z96l7zRajM3UqVkeAILmmjbrEy2lFMlNIonyHtj7gpO4bwO', '000000000', NULL, 0, NULL, 1, 2, 0, '2Yw8604a70m1gTEg6iaMHH36s3r143', NULL, NULL, '2018-05-21 07:18:41', '2018-05-21 07:18:41', NULL, 1, 0),
(67, 'Mosque', 'mosque32423@gmail.com', '$2y$10$.LzCIWqQj3mp8P.tj/WCgOm98JEzknGf5.r22mUQuxdETl1ULV6jO', '000000000', NULL, 0, NULL, 1, 2, 0, '2v4i731k8046oUpF0E314Uhr54E989', NULL, NULL, '2018-05-21 07:20:52', '2018-05-21 07:20:52', NULL, 1, 0),
(68, 'Mosquedsa', 'mosqueassa@gmail.com', '$2y$10$lLxi9aMt/M0j4E54V1W65O958qu/Tz2aMCq.dy/1ArGRSl4Cva0nq', '000000000', NULL, 0, NULL, 1, 2, 0, 'J4u8jW4upQ553v2UrScR6Lnj0f0L44', NULL, NULL, '2018-05-21 07:35:42', '2018-05-21 07:35:42', NULL, 1, 0),
(69, 'Mosqueada', 'mosquedsad@gmail.com', '$2y$10$ERdSR3a8Mb09WalKl.cmYuOiJkEz5OdUsbcKnqn/fO/Qs2ckrx/GG', '000000000', NULL, 0, NULL, 1, 2, 0, 'J85421HyzwA444I38oq22uG24Ro0l5', NULL, NULL, '2018-05-21 07:53:53', '2018-05-21 07:53:53', NULL, 1, 0),
(70, 'Mosqueasd', 'mosquesadsa@gmail.com', '$2y$10$WITeTOZTzrPwod7xcs881udtZ.m0cCKdKuNUHn9ezwOQsqy7GDtpW', '000000000', NULL, 0, NULL, 1, 2, 0, '899Rap8l9cRe9266PV923r5JO26c2n', NULL, NULL, '2018-05-23 02:11:02', '2018-05-23 02:11:02', NULL, 1, 0),
(71, 'Mosque', 'mosqueasd@gmail.com', '$2y$10$vGUeiGMMILxXR0DPXayFNOrCp5wWkSMrZuIgZInwqCWdvTI.to3iS', '000000000', NULL, 0, NULL, 1, 2, 0, '7094336432vMH5K0K5cR17scV7DW45', NULL, NULL, '2018-05-23 03:10:12', '2018-05-23 03:10:12', NULL, 1, 0),
(72, 'Mosqueddf', 'mosquesdfsd@gmail.com', '$2y$10$s4417Sbhm0Hgb7P52AoNeORaVKAgfkeyn3NOosoh1179VpJXN/dxS', '000000000', NULL, 0, NULL, 1, 2, 0, '5ITs4603YeA45v6d0Ql47k0Gj9GGL7', NULL, NULL, '2018-05-23 03:41:49', '2018-05-23 03:41:49', NULL, 1, 0),
(73, 'asad', 'asda154@gmail.com', '$2y$10$q5ySb61fA9r7/RTJXgCag./Xk3AgDT97NXfPhALrDz8yeXc8uXEmS', NULL, NULL, 0, NULL, 1, 3, 0, '', '2018-05-23 06:56:12', NULL, '2018-05-23 06:54:51', '2018-05-23 06:56:12', 'gniy9ETzhLiBvZmNPWqC3mUAwAgWC6Q8QFn4otTmIZQZ6Xv1slg3ZlhtNKh8', 1, 0),
(74, 'Mosqueasdasd', 'mosqueasdsad@gmail.com', '$2y$10$hsCqJ.XbDLKNUg2VBkXfGOWN0CFkzv4.Q2PIPCCCZ8096VvtzVFHm', '000000000', NULL, 0, NULL, 1, 2, 0, '4761uz5RM430cf55k7o6hKf3H6Sn33', NULL, NULL, '2018-05-24 02:59:06', '2018-05-24 02:59:06', '3qiyKn32ttxBrDPPE0fLP7ZR89NEkDGlN4wxkg9J0xZDAXIz9Vf26kV7Wn8s', 1, 0),
(75, 'dadada', 'sadsadad@gmail.com', '$2y$10$/I2hAw4.tX33p8TCV2bv5Oa3wqsiCkAGsgBLy.QgGXCQ/GGpTUFw2', '12345678910', NULL, 0, NULL, 1, 2, 0, '', '2018-05-24 03:29:23', NULL, '2018-05-24 03:07:12', '2018-05-24 03:29:23', 'uZ8iRTuPtm0PO1MYs0ASk59kRDzh0iznQWczLJYYLxcNc3LbozQShv3JEzHA', 1, 0),
(76, 'Mosquesadad', 'mosques@gmail.com', '$2y$10$ordp24AjKm720vGLipsJMOUChP2t9z0r3eQk6/lMq0vQ4U/gJJOnC', '000000000', NULL, 0, NULL, 1, 2, 0, 'R50as0N932juDnMn88805333eS3An7', NULL, '', '2018-05-24 05:37:05', '2018-05-30 02:24:12', 'wqctdZb3qkiy4YcY3h7JaBTVqNN3BPUSXCsJjsFxvamnbYPML2bg5RpvageE', 1, 0);

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
(1, 73, '6e33daafb40438b2ff0748f923878e342ca134c9', '', '', NULL, '', 0, 0, '', '', '2018-05-28 01:59:23', '2018-05-23 06:56:17', '2018-05-28 01:59:23');

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
(100, 65, 91);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_contacts_users1_idx` (`user_id`);

--
-- Indexes for table `donations`
--
ALTER TABLE `donations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `funds`
--
ALTER TABLE `funds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_devices`
--
ALTER TABLE `user_devices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_users_devices_users1_idx` (`user_id`),
  ADD KEY `users_devices_token` (`token`);

--
-- Indexes for table `user_mosques`
--
ALTER TABLE `user_mosques`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_mosques_users1_idx` (`user_id`),
  ADD KEY `fk_user_mosques_mosques1_idx` (`mosque_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `donations`
--
ALTER TABLE `donations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `funds`
--
ALTER TABLE `funds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;
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
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;
--
-- AUTO_INCREMENT for table `user_devices`
--
ALTER TABLE `user_devices`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `user_mosques`
--
ALTER TABLE `user_mosques`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD CONSTRAINT `fk_user_contacts_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user_devices`
--
ALTER TABLE `user_devices`
  ADD CONSTRAINT `fk_users_devices_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user_mosques`
--
ALTER TABLE `user_mosques`
  ADD CONSTRAINT `fk_user_mosques_mosques1` FOREIGN KEY (`mosque_id`) REFERENCES `mosques` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_mosques_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
