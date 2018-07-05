-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 18, 2018 at 01:44 PM
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
(58, 'Mosque', 'Mosque', 'mosque1@gmail.com', 'mosque1@gmail.com', 'karachi,pakistan', '0000', '000000000', '0000000000', '13345', 1, NULL, NULL, '2018-05-18 01:50:29', '2018-05-18 01:50:40'),
(59, 'mosque25', 'ammar', 'ammar@gmail.com', 'ammar25@gmail.com', 'karachi,pakistan', '0000', '000000000', '0000000000', '1334', 0, NULL, NULL, '2018-05-18 05:39:29', '2018-05-18 05:39:29'),
(60, 'mosque253', 'ammar12', 'ammar12@gmail.com', 'ammar253@gmail.com', 'karachi,pakistan', '0000', '000000000', '0000000000', '1334', 1, NULL, NULL, '2018-05-18 05:52:43', '2018-05-18 05:53:26');

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
(1, 'Admin', 'admin@jaria.com', '$2y$10$WITeTOZTzrPwod7xcs881udtZ.m0cCKdKuNUHn9ezwOQsqy7GDtpW', '', NULL, 0, NULL, 1, 0, 1, NULL, NULL, '1-1519348064.jpg', NULL, '2018-02-22 20:07:44', 'H9zTO1qJqUzPl7q7EhMXNYs2wHdhsMO79YrQOwZuWTYVGgoE1MClzlGnfEkZ', 0, 0),
(20, 'Shoaib', 'shoaib.fsdsolutions@gmail.com', '', '', '2018-05-10 10:16:09', 0, NULL, 1, 3, 0, '', '2018-05-10 04:44:51', '20-1525947473.jpg', '2018-05-10 04:43:21', '2018-05-11 09:41:17', 'JTMd6E2N8NA67E90l9LlVRngKhXiNlOxjPreAOYNjOrrdbNDCuykkhnIL3qX', 1, 0),
(47, 'Faraz', 'faraz@gmail.com', '$2y$10$sNOQe8CnN3FZglJkLtOaUudjlKVhAYcIjwiWw9d91NNnGAXp/yNPu', '000000000', NULL, 0, NULL, 1, 2, 0, '6K8W5Mha3n0Q4IPq6J904dG0OexF68', NULL, NULL, '2018-05-16 04:21:52', '2018-05-16 04:21:52', NULL, 1, 0),
(48, 'uzair', 'mosque@gmail.com', '$2y$10$pUBvktVwGo4atG.61IO3hu6iCmpD3NaGm9ztBeFloCOArvMxAckXm', '000000000', NULL, 0, NULL, 1, 2, 0, 'm494jz928rd1Fm4pIZ2gD5H845MM2e', NULL, NULL, '2018-05-16 04:37:20', '2018-05-16 04:37:20', NULL, 1, 0),
(49, 'Mosque', 'mosque12@gmail.com', '$2y$10$fvkjj8Yp/PakzPyJA./o9eqHnH2xwfI6hQTR4x9LIPHz//GcizuL2', '000000000', NULL, 0, NULL, 1, 2, 0, 'G3qi213tSr3iGa6sXS07CH4bA454Je', NULL, NULL, '2018-05-16 04:54:09', '2018-05-16 04:54:09', NULL, 1, 0),
(50, 'faraz235', 'faraz23@gmail.com', '$2y$10$1yVvbL4Jjc1mcQ2523.W0uBkRscKLNEkhzvx1Jf8Zw.dgmLfS/.2C', NULL, NULL, 0, NULL, 1, 3, 0, '', '2018-05-16 05:10:51', NULL, '2018-05-16 05:10:13', '2018-05-16 05:15:38', 'qkUUJlDuy7snDnLSqcVASvM5ggABiQfApEHgNiLn4PQg8fY8Exusxsm0P8QX', 1, 0),
(51, 'ammar', 'ammar@gmail.com', '$2y$10$7dOS3tJ8R47jyjK4m/bHP.kdiYSpourEQKjNsnR0SrlDnEZgLcFgq', '000000000', NULL, 0, NULL, 0, 2, 0, '722y449yT3B16rEf1qn9tbMBIYww69', NULL, NULL, '2018-05-18 05:39:30', '2018-05-18 05:39:30', NULL, 1, 0),
(52, 'ammar12', 'ammar12@gmail.com', '$2y$10$kwpf1IBNd6m5aZSPbM.POO4sWusGW8ulrl40n9dYM6wmX.zvHd4.m', '000000000', NULL, 0, NULL, 1, 2, 0, '', '2018-05-18 05:53:40', NULL, '2018-05-18 05:52:44', '2018-05-18 05:53:40', NULL, 1, 0);

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
(3, 52, '92009eed23762bedd30ed208f5958eefa39441b1', '', '', NULL, '', 0, 0, '', '', '2018-05-18 06:24:59', '2018-05-16 05:11:01', '2018-05-18 06:24:59');

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
(17, 48, 58),
(18, 51, 59),
(20, 52, 60);

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;
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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;
--
-- AUTO_INCREMENT for table `user_devices`
--
ALTER TABLE `user_devices`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `user_mosques`
--
ALTER TABLE `user_mosques`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
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
