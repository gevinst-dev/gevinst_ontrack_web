-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 28, 2022 at 06:52 PM
-- Server version: 10.6.4-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `onti1`
--

-- --------------------------------------------------------

--
-- Table structure for table `app_assets`
--

CREATE TABLE `app_assets` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL DEFAULT 0,
  `category_id` int(11) NOT NULL DEFAULT 0,
  `status_id` int(11) NOT NULL DEFAULT 0,
  `manufacturer_id` int(11) NOT NULL DEFAULT 0,
  `model_id` int(11) NOT NULL DEFAULT 0,
  `location_id` int(11) NOT NULL DEFAULT 0,
  `supplier_id` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `tag` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `purchase_date` varchar(32) NOT NULL DEFAULT '',
  `warranty_end` varchar(32) NOT NULL DEFAULT '',
  `serial_number` varchar(255) NOT NULL DEFAULT '',
  `main_image` varchar(255) NOT NULL DEFAULT '',
  `notes` text NOT NULL,
  `custom_fields_values` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `app_assets`
--

INSERT INTO `app_assets` (`id`, `client_id`, `category_id`, `status_id`, `manufacturer_id`, `model_id`, `location_id`, `supplier_id`, `user_id`, `tag`, `name`, `purchase_date`, `warranty_end`, `serial_number`, `main_image`, `notes`, `custom_fields_values`, `created_at`, `updated_at`) VALUES
(1, 8, 7, 1, 7, 4, 1, 1, 0, 'MF1', 'Mainframe', '2022-07-01', '2024-08-01', 'HSHS765AHQ', 'IBM_Blue_Gene_P_supercomputer.jpg', '', 'null', '2022-08-27 20:54:54', '2022-08-27 22:01:00'),
(2, 6, 2, 1, 1, 1, 2, 2, 0, 'MA-001', 'MacBook Air M1 2020 8GB 512 GB', '2022-08-01', '2023-08-01', 'JHISA822221', '750302493_apple-macbook-air-13-3-m1-8gb-256gb-mgn63.jpg', '', 'null', '2022-08-27 20:56:19', '2022-08-27 22:01:19'),
(3, 2, 2, 1, 1, 5, 3, 2, 0, 'MB-002', 'MacBook Pro M2 16GB 1TB', '2022-08-01', '2024-08-01', 'SDSDW2112', 'MacBook-Pro-14-in-Silver_1.jpg', '', 'null', '2022-08-27 21:00:23', '2022-08-27 22:01:33'),
(4, 2, 3, 3, 6, 6, 3, 2, 0, 'XE-001', 'Xerox 3215', '2020-04-01', '2022-08-01', '3215XER', 'hero_960x960.png', '', 'null', '2022-08-27 21:08:25', '2022-08-27 22:02:23');

-- --------------------------------------------------------

--
-- Table structure for table `app_asset_categories`
--

CREATE TABLE `app_asset_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `color` varchar(7) NOT NULL DEFAULT '#000',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `app_asset_categories`
--

INSERT INTO `app_asset_categories` (`id`, `name`, `color`, `created_at`, `updated_at`) VALUES
(1, 'Workstations', '#C05252', '2022-08-27 20:30:03', '2022-08-27 20:30:03'),
(2, 'Laptops', '#247B73', '2022-08-27 20:30:15', '2022-08-27 20:30:15'),
(3, 'Printers', '#8CA817', '2022-08-27 20:30:23', '2022-08-27 20:30:23'),
(4, 'Routers', '#351DC8', '2022-08-27 20:30:32', '2022-08-27 20:30:32'),
(5, 'Keyboards', '#9B37CC', '2022-08-27 20:31:05', '2022-08-27 20:31:05'),
(6, 'Docking Stations', '#8E7D35', '2022-08-27 20:31:32', '2022-08-27 20:31:32'),
(7, 'Mainframe', '#000000', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `app_asset_comments`
--

CREATE TABLE `app_asset_comments` (
  `id` int(11) NOT NULL,
  `asset_id` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `app_asset_comments`
--

INSERT INTO `app_asset_comments` (`id`, `asset_id`, `added_by`, `comment`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type.', '2022-08-28 07:05:09', '2022-08-28 07:05:09');

-- --------------------------------------------------------

--
-- Table structure for table `app_asset_files`
--

CREATE TABLE `app_asset_files` (
  `id` int(11) NOT NULL,
  `asset_id` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `show_user` tinyint(1) NOT NULL DEFAULT 1,
  `file` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `app_asset_history`
--

CREATE TABLE `app_asset_history` (
  `id` int(11) NOT NULL,
  `asset_id` int(11) NOT NULL,
  `action` varchar(255) NOT NULL,
  `extra` varchar(255) NOT NULL DEFAULT '',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `app_asset_history`
--

INSERT INTO `app_asset_history` (`id`, `asset_id`, `action`, `extra`, `created_at`) VALUES
(1, 1, 'Asset added', '', '2022-08-27 20:54:54'),
(2, 2, 'Asset added', '', '2022-08-27 20:56:19'),
(3, 2, 'User assigned', 'Richard Hendricks', '2022-08-27 20:58:15'),
(4, 3, 'Asset added', '', '2022-08-27 21:00:23'),
(5, 3, 'User assigned', 'Bobby Axelrod', '2022-08-27 21:00:34'),
(6, 4, 'Asset added', '', '2022-08-27 21:08:25'),
(7, 1, 'Asset edited', '', '2022-08-27 22:01:00'),
(8, 2, 'Asset edited', '', '2022-08-27 22:01:19'),
(9, 3, 'Asset edited', '', '2022-08-27 22:01:33'),
(10, 4, 'Asset edited', '', '2022-08-27 22:02:23');

-- --------------------------------------------------------

--
-- Table structure for table `app_clients`
--

CREATE TABLE `app_clients` (
  `id` int(11) NOT NULL,
  `type` varchar(32) NOT NULL DEFAULT 'Client',
  `name` varchar(255) NOT NULL DEFAULT '',
  `company_id` varchar(32) NOT NULL DEFAULT '',
  `company_taxid` varchar(32) NOT NULL DEFAULT '',
  `phone` varchar(128) NOT NULL DEFAULT '',
  `email` varchar(128) NOT NULL DEFAULT '',
  `website` varchar(128) NOT NULL DEFAULT '',
  `address` varchar(256) NOT NULL DEFAULT '',
  `city` varchar(128) NOT NULL DEFAULT '',
  `state` varchar(128) NOT NULL DEFAULT '',
  `zip_code` varchar(32) NOT NULL DEFAULT '',
  `country` varchar(128) NOT NULL DEFAULT '',
  `notes` text NOT NULL,
  `description` varchar(255) NOT NULL DEFAULT '',
  `custom_fields_values` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `app_clients`
--

INSERT INTO `app_clients` (`id`, `type`, `name`, `company_id`, `company_taxid`, `phone`, `email`, `website`, `address`, `city`, `state`, `zip_code`, `country`, `notes`, `description`, `custom_fields_values`, `created_at`, `updated_at`) VALUES
(1, 'Client', 'E Corp', '', '', '', '', '', '', '', '', '', '', '', '', '', '2022-08-27 20:35:44', '2022-08-27 20:35:49'),
(2, 'Client', 'Axe Capital', '', '', '', '', '', '', '', '', '', '', '', '', '', '2022-08-27 20:36:00', '2022-08-27 20:36:00'),
(3, 'Client', 'Aviato', '', '', '', '', '', '', '', '', '', '', '', '', '', '2022-08-27 20:36:09', '2022-08-27 20:36:09'),
(4, 'Client', 'Stark Industries', '', '', '', '', '', '', '', '', '', '', '', '', '', '2022-08-27 20:36:21', '2022-08-27 20:36:33'),
(5, 'Client', 'Monsters, Inc.', '', '', '', '', '', '', '', '', '', '', '', '', '', '2022-08-27 20:36:47', '2022-08-27 20:36:47'),
(6, 'Client', 'Pied Piper', '', '', '', '', '', '', '', '', '', '', '', '', '', '2022-08-27 20:37:04', '2022-08-27 20:43:05'),
(7, 'Client', 'Tyrell Corp.', '', '', '', '', '', '', '', '', '', '', '', '', '', '2022-08-27 20:37:31', '2022-08-27 20:37:31'),
(8, 'Client', 'Umbrella Corp', '', '', '', '', '', '', '', '', '', '', '', '', '', '2022-08-27 20:39:24', '2022-08-27 20:39:24'),
(9, 'Client', 'Orchid Inc', '', '7328821', '8008018811', 'jake@orchid.com', 'orchid.com', '', '', '', '', '', '<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean. A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth. Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name of Lorem Ipsum decided to leave for the far World of Grammar. The Big Oxmox advised her not to do so, because there were thousands of bad Commas, wild Question Marks and devious Semikoli, but the Little Blind Text didn’t listen. She packed her seven versalia, put her initial into the belt and made herself on the way. When she reached the first hills of the Italic Mountains, she had a last view back on the skyline of her hometown Bookmarksgrove, the headline of Alphabet Village and the subline of her own road, the Line Lane.</p>', '', '', '2022-08-27 21:30:28', '2022-08-27 21:32:30');

-- --------------------------------------------------------

--
-- Table structure for table `app_client_addresses`
--

CREATE TABLE `app_client_addresses` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zip_code` varchar(32) NOT NULL,
  `country` varchar(64) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `notes` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `app_client_comments`
--

CREATE TABLE `app_client_comments` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `app_client_comments`
--

INSERT INTO `app_client_comments` (`id`, `client_id`, `added_by`, `comment`, `created_at`, `updated_at`) VALUES
(1, 9, 1, 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.', '2022-08-27 21:31:44', '2022-08-27 21:31:44'),
(2, 9, 1, 'Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante.', '2022-08-27 21:31:59', '2022-08-27 21:31:59');

-- --------------------------------------------------------

--
-- Table structure for table `app_client_files`
--

CREATE TABLE `app_client_files` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `file` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `app_credentials`
--

CREATE TABLE `app_credentials` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL DEFAULT 0,
  `asset_id` int(11) NOT NULL DEFAULT 0,
  `project_id` int(11) NOT NULL DEFAULT 0,
  `type` varchar(255) NOT NULL DEFAULT '',
  `username` text NOT NULL,
  `pswd` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `app_currencies`
--

CREATE TABLE `app_currencies` (
  `id` int(11) NOT NULL,
  `code` varchar(16) NOT NULL,
  `prefix` varchar(16) NOT NULL,
  `suffix` varchar(16) NOT NULL,
  `rate` decimal(10,4) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `app_currencies`
--

INSERT INTO `app_currencies` (`id`, `code`, `prefix`, `suffix`, `rate`, `created_at`, `updated_at`) VALUES
(1, 'EUR', '', '€', '1.0000', '2019-02-26 17:50:15', '2022-08-27 20:17:08'),
(2, 'USD', '$', '', '1.0035', '2019-02-26 17:54:28', '2019-02-26 17:54:37'),
(3, 'GBP', '£', '', '1.1790', '2021-03-18 15:58:24', '2021-03-18 15:59:44');

-- --------------------------------------------------------

--
-- Table structure for table `app_customfields`
--

CREATE TABLE `app_customfields` (
  `id` int(11) NOT NULL,
  `for` varchar(64) NOT NULL,
  `type` varchar(64) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL,
  `options` text NOT NULL,
  `required` int(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `app_docs_pages`
--

CREATE TABLE `app_docs_pages` (
  `id` int(11) NOT NULL,
  `space_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT 0,
  `name` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `status` varchar(32) NOT NULL DEFAULT 'Published',
  `sort` int(11) NOT NULL DEFAULT 0,
  `folder` int(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `app_docs_pages`
--

INSERT INTO `app_docs_pages` (`id`, `space_id`, `parent_id`, `name`, `content`, `status`, `sort`, `folder`, `created_at`, `updated_at`) VALUES
(1, 1, 0, 'Lorem ipsum', '<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p>\r\n<p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>\r\n<p></p>', 'Published', 0, 0, '2022-08-28 12:32:45', '2022-08-28 12:33:09');

-- --------------------------------------------------------

--
-- Table structure for table `app_docs_spaces`
--

CREATE TABLE `app_docs_spaces` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` varchar(32) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `app_docs_spaces`
--

INSERT INTO `app_docs_spaces` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Lorem ipsum', 'Published', '2022-08-28 12:32:37', '2022-08-28 12:32:37');

-- --------------------------------------------------------

--
-- Table structure for table `app_domains`
--

CREATE TABLE `app_domains` (
  `id` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `notify` varchar(255) NOT NULL DEFAULT 'a:0:{}',
  `client_id` int(11) NOT NULL DEFAULT 0,
  `domain` varchar(255) NOT NULL,
  `exp_date` date NOT NULL,
  `notify_30` int(1) NOT NULL DEFAULT 1,
  `notify_14` int(1) NOT NULL DEFAULT 1,
  `notify_7` int(1) NOT NULL DEFAULT 1,
  `notify_3` int(1) NOT NULL DEFAULT 1,
  `notify_0` int(1) NOT NULL DEFAULT 1,
  `notify_client` int(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `app_domains`
--

INSERT INTO `app_domains` (`id`, `added_by`, `notify`, `client_id`, `domain`, `exp_date`, `notify_30`, `notify_14`, `notify_7`, `notify_3`, `notify_0`, `notify_client`, `created_at`, `updated_at`) VALUES
(1, 1, 'a:1:{i:0;s:1:\"1\";}', 2, 'axecapital.com', '2029-11-22', 1, 1, 1, 1, 1, 1, '2022-08-27 20:51:53', '2022-08-27 20:51:53'),
(2, 1, 'a:1:{i:0;s:1:\"1\";}', 3, 'aviato.com', '2025-07-17', 1, 1, 1, 1, 1, 1, '2022-08-27 20:52:14', '2022-08-27 20:52:14'),
(3, 1, 'a:1:{i:0;s:1:\"1\";}', 6, 'piedpiper.com', '2028-08-31', 1, 1, 1, 1, 1, 0, '2022-08-27 20:52:34', '2022-08-27 20:52:34');

-- --------------------------------------------------------

--
-- Table structure for table `app_entities`
--

CREATE TABLE `app_entities` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `title` varchar(32) NOT NULL,
  `taxid` varchar(32) NOT NULL DEFAULT '',
  `address` varchar(32) NOT NULL DEFAULT '',
  `onrc` varchar(32) NOT NULL DEFAULT '',
  `cap_soc` varchar(32) NOT NULL DEFAULT '',
  `banca` varchar(32) DEFAULT '',
  `iban` varchar(32) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `invoice_prefix` varchar(32) NOT NULL,
  `invoice_next` varchar(32) NOT NULL,
  `proforma_prefix` varchar(32) NOT NULL,
  `proforma_next` varchar(32) NOT NULL,
  `proposal_prefix` varchar(32) NOT NULL,
  `proposal_next` varchar(32) NOT NULL,
  `receipt_prefix` varchar(32) NOT NULL,
  `receipt_next` varchar(32) NOT NULL,
  `ctr_prefix` varchar(32) NOT NULL DEFAULT '',
  `ctr_next` varchar(32) NOT NULL DEFAULT '',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `app_entities`
--

INSERT INTO `app_entities` (`id`, `name`, `title`, `taxid`, `address`, `onrc`, `cap_soc`, `banca`, `iban`, `description`, `invoice_prefix`, `invoice_next`, `proforma_prefix`, `proforma_next`, `proposal_prefix`, `proposal_next`, `receipt_prefix`, `receipt_next`, `ctr_prefix`, `ctr_next`, `created_at`, `updated_at`) VALUES
(1, 'onTrack Inc', 'ONT', '', '', '', '', '', '', '<p>Company No.: 982233111<br>Santa Monica Blvd, No. 34<br>Los Angeles, California</p>\r\n<p>Account Number: 12341111<br>Bank: Bank of America</p>', 'ONT', '15', 'ONT', '3', 'ONT', '3', 'ONT', '0001', 'ONT', '0001', '2022-08-27 20:22:03', '2022-08-27 21:38:46');

-- --------------------------------------------------------

--
-- Table structure for table `app_events`
--

CREATE TABLE `app_events` (
  `id` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `calendar` varchar(64) NOT NULL DEFAULT 'Group',
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `all_day` int(11) NOT NULL DEFAULT 0,
  `start_date` varchar(64) NOT NULL DEFAULT '',
  `end_date` varchar(64) NOT NULL DEFAULT '',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `app_events`
--

INSERT INTO `app_events` (`id`, `added_by`, `calendar`, `title`, `description`, `all_day`, `start_date`, `end_date`, `created_at`, `updated_at`) VALUES
(1, 1, 'Group', 'Teambuilding', '', 1, '2022-10-27 00:00:00', '2022-11-07 00:23:00', '2022-08-27 21:23:59', '2022-08-27 21:23:59'),
(2, 1, 'Private', 'Meet with new client', '', 0, '2022-08-30 11:24:00', '', '2022-08-27 21:24:43', '2022-08-27 21:24:43');

-- --------------------------------------------------------

--
-- Table structure for table `app_expenses`
--

CREATE TABLE `app_expenses` (
  `id` int(11) NOT NULL,
  `entity_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `value` decimal(12,2) NOT NULL,
  `tax` decimal(12,2) NOT NULL,
  `total` decimal(12,2) NOT NULL,
  `paid` decimal(12,2) NOT NULL,
  `rate` decimal(12,4) NOT NULL DEFAULT 1.0000,
  `description` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `status` varchar(32) NOT NULL,
  `file` varchar(255) NOT NULL DEFAULT '',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `app_expenses`
--


-- --------------------------------------------------------

--
-- Table structure for table `app_expense_categories`
--

CREATE TABLE `app_expense_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `app_expense_categories`
--

INSERT INTO `app_expense_categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Hosting', '2022-08-27 20:18:27', '2022-08-27 20:18:27'),
(2, 'Telecomunications', '2022-08-27 20:18:44', '2022-08-27 20:18:44'),
(3, 'Office Supplies', '2022-08-27 20:19:00', '2022-08-27 20:19:00'),
(4, 'Rent', '2022-08-27 21:13:12', '2022-08-27 21:13:12'),
(5, 'Fuel', '2022-08-27 21:13:18', '2022-08-27 21:13:18'),
(6, 'Banking Fees', '2022-08-27 21:13:54', '2022-08-27 21:13:54'),
(7, 'Leasing', '2022-08-27 21:14:06', '2022-08-27 21:14:06'),
(8, 'Taxes', '2022-08-27 21:14:15', '2022-08-27 21:14:15'),
(9, 'Other', '2022-08-27 21:14:19', '2022-08-27 21:14:19');

-- --------------------------------------------------------

--
-- Table structure for table `app_invoices`
--

CREATE TABLE `app_invoices` (
  `id` int(11) NOT NULL,
  `entity_id` int(11) NOT NULL DEFAULT 0,
  `language_id` int(1) NOT NULL DEFAULT 0,
  `client_id` int(11) NOT NULL,
  `proposal_id` int(11) NOT NULL DEFAULT 0,
  `recurring_id` int(11) NOT NULL DEFAULT 0,
  `added_by` int(11) NOT NULL DEFAULT 0,
  `issued_by` int(11) NOT NULL DEFAULT 0,
  `currency_id` int(11) NOT NULL,
  `rate` float NOT NULL DEFAULT 1,
  `number` varchar(64) NOT NULL DEFAULT '',
  `date` date NOT NULL,
  `due_date` varchar(32) NOT NULL,
  `value` decimal(16,2) NOT NULL DEFAULT 0.00,
  `tax` decimal(16,2) NOT NULL DEFAULT 0.00,
  `total` decimal(16,2) NOT NULL DEFAULT 0.00,
  `paid` decimal(16,2) NOT NULL DEFAULT 0.00,
  `unpaid` decimal(16,2) NOT NULL DEFAULT 0.00,
  `status` varchar(64) NOT NULL,
  `public_notes` text NOT NULL,
  `private_notes` text NOT NULL,
  `client_data` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


-- --------------------------------------------------------

--
-- Table structure for table `app_invoice_items`
--

CREATE TABLE `app_invoice_items` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `type` varchar(64) NOT NULL DEFAULT 'Service',
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `qty` float NOT NULL DEFAULT 0,
  `taxrate` float NOT NULL DEFAULT 0,
  `price` decimal(16,4) NOT NULL DEFAULT 0.0000,
  `value` decimal(16,2) NOT NULL DEFAULT 0.00,
  `tax` decimal(16,2) NOT NULL DEFAULT 0.00,
  `total` decimal(16,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `app_issues`
--

CREATE TABLE `app_issues` (
  `id` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `assigned_to` int(11) NOT NULL,
  `client_id` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `asset_id` int(11) NOT NULL DEFAULT 0,
  `license_id` int(11) NOT NULL DEFAULT 0,
  `project_id` int(11) NOT NULL DEFAULT 0,
  `milestone_id` int(11) NOT NULL DEFAULT 0,
  `show_user` tinyint(1) NOT NULL DEFAULT 1,
  `order` int(11) NOT NULL DEFAULT 0,
  `released` int(1) NOT NULL DEFAULT 0,
  `status` varchar(32) NOT NULL,
  `type` varchar(32) NOT NULL DEFAULT 'Task',
  `priority` varchar(32) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `due_date` varchar(32) NOT NULL,
  `custom_fields_values` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `app_issues`
--

INSERT INTO `app_issues` (`id`, `added_by`, `assigned_to`, `client_id`, `user_id`, `asset_id`, `license_id`, `project_id`, `milestone_id`, `show_user`, `order`, `released`, `status`, `type`, `priority`, `name`, `description`, `due_date`, `custom_fields_values`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 6, 0, 0, 0, 1, 0, 1, 0, 0, 'Done', 'Task', 'High', 'Rewrite the compresion algorithms', '', '2023-01-31', '', '2022-08-27 20:44:35', '2022-08-28 14:18:12'),
(2, 1, 0, 6, 0, 0, 0, 1, 0, 1, 1, 0, 'To Do', 'Bug', 'Normal', 'Image compression does not work', '', '2022-10-31', '', '2022-08-27 20:44:55', '2022-08-27 20:44:55'),
(3, 1, 1, 8, 0, 1, 0, 0, 0, 1, 0, 0, 'To Do', 'Maintenance', 'Normal', 'Clear caches and temporary files', '', '2022-08-10', 'null', '2022-08-27 21:03:16', '2022-08-27 21:03:16'),
(4, 1, 0, 2, 0, 0, 0, 2, 0, 1, 0, 0, 'To Do', 'Task', 'Normal', 'Replace cables', '', '', '', '2022-08-27 21:04:50', '2022-08-27 21:04:50'),
(5, 1, 1, 2, 0, 0, 0, 2, 0, 1, 2, 0, 'To Do', 'Maintenance', 'Normal', 'Clean main cabinet', '', '2022-10-26', '', '2022-08-27 21:05:15', '2022-08-27 21:05:15'),
(6, 1, 1, 2, 0, 0, 0, 2, 0, 1, 0, 0, 'Done', 'Task', 'High', 'Install new router', '', '2022-08-29', '', '2022-08-27 21:05:52', '2022-08-27 21:05:55'),
(7, 1, 1, 2, 0, 0, 0, 2, 0, 1, 0, 0, 'In Progress', 'Task', 'Low', 'Replace switches', '', '2022-08-18', '', '2022-08-27 21:06:28', '2022-08-27 21:06:32'),
(8, 1, 0, 6, 0, 0, 0, 1, 1, 1, 0, 1, 'Done', 'Improvement', 'Normal', 'Improve the user interface', '', '', '', '2022-08-28 14:15:26', '2022-08-28 14:15:30');

-- --------------------------------------------------------

--
-- Table structure for table `app_issue_comments`
--

CREATE TABLE `app_issue_comments` (
  `id` int(11) NOT NULL,
  `issue_id` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `app_issue_files`
--

CREATE TABLE `app_issue_files` (
  `id` int(11) NOT NULL,
  `issue_id` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `show_user` tinyint(1) NOT NULL DEFAULT 1,
  `file` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `app_items`
--

CREATE TABLE `app_items` (
  `id` int(11) NOT NULL,
  `type` varchar(64) NOT NULL DEFAULT 'Product',
  `name` varchar(255) NOT NULL,
  `price` float NOT NULL DEFAULT 0,
  `taxrate` float NOT NULL DEFAULT 0,
  `description` longtext NOT NULL,
  `sku` text NOT NULL,
  `main_image` text NOT NULL,
  `notes` longtext NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `app_items`
--

INSERT INTO `app_items` (`id`, `type`, `name`, `price`, `taxrate`, `description`, `sku`, `main_image`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'Service', 'Computer Management', 100, 0, '', 'CM1', '', '', '2022-08-27 20:28:14', '2022-08-27 20:28:14'),
(2, 'Service', 'Printer Management', 25, 0, '', 'PM1', '', '', '2022-08-27 20:28:43', '2022-08-27 20:28:43'),
(3, 'Service', 'Office 365 Management', 120, 0, '', 'O365M', '', '', '2022-08-27 20:29:06', '2022-08-27 20:29:06');

-- --------------------------------------------------------

--
-- Table structure for table `app_item_files`
--

CREATE TABLE `app_item_files` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `file` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `app_item_images`
--

CREATE TABLE `app_item_images` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `file` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `app_kb_articles`
--

CREATE TABLE `app_kb_articles` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `access` varchar(32) NOT NULL,
  `status` varchar(32) NOT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `app_kb_categories`
--

CREATE TABLE `app_kb_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `access` varchar(32) NOT NULL,
  `status` varchar(32) NOT NULL,
  `image` varchar(255) NOT NULL DEFAULT '',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `app_licenses`
--

CREATE TABLE `app_licenses` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `category_id` int(11) NOT NULL DEFAULT 0,
  `status_id` int(11) NOT NULL DEFAULT 0,
  `supplier_id` int(11) NOT NULL DEFAULT 0,
  `tag` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `serial_number` varchar(255) NOT NULL,
  `seats` varchar(255) NOT NULL,
  `notes` text NOT NULL,
  `custom_fields_values` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `app_licenses`
--

INSERT INTO `app_licenses` (`id`, `client_id`, `user_id`, `category_id`, `status_id`, `supplier_id`, `tag`, `name`, `serial_number`, `seats`, `notes`, `custom_fields_values`, `created_at`, `updated_at`) VALUES
(1, 4, 0, 3, 1, 1, 'L-001', 'Red Hat Enterprise Linux', '', '', '', 'null', '2022-08-27 20:45:52', '2022-08-27 20:45:52'),
(2, 3, 0, 2, 1, 2, 'L-002', 'Windows Server 2019 Standard', '', '', '', 'null', '2022-08-27 20:46:28', '2022-08-28 10:43:50'),
(3, 5, 0, 4, 1, 3, 'CP1', 'cPanel', '', '', '', 'null', '2022-08-27 20:49:47', '2022-08-27 20:51:14'),
(4, 2, 0, 5, 1, 2, 'CDR-001', 'Corel Draw X9', '', '', '', 'null', '2022-08-28 12:31:26', '2022-08-28 12:31:26');

-- --------------------------------------------------------

--
-- Table structure for table `app_license_assignments`
--

CREATE TABLE `app_license_assignments` (
  `id` int(11) NOT NULL,
  `license_id` int(11) NOT NULL,
  `asset_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `app_license_categories`
--

CREATE TABLE `app_license_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `color` varchar(7) NOT NULL DEFAULT '#000',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `app_license_categories`
--

INSERT INTO `app_license_categories` (`id`, `name`, `color`, `created_at`, `updated_at`) VALUES
(1, 'Windows OS', '#274EB0', '2022-08-27 20:31:47', '2022-08-27 20:31:47'),
(2, 'Windows Server', '#288BBC', '2022-08-27 20:31:58', '2022-08-27 20:31:58'),
(3, 'Linux', '#D02121', '2022-08-27 20:32:04', '2022-08-27 20:32:04'),
(4, 'Web Hosting CP', '#1D59A8', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'Graphics', '#BA8181', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `app_license_comments`
--

CREATE TABLE `app_license_comments` (
  `id` int(11) NOT NULL,
  `license_id` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `app_license_files`
--

CREATE TABLE `app_license_files` (
  `id` int(11) NOT NULL,
  `license_id` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `show_user` tinyint(1) NOT NULL DEFAULT 1,
  `file` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `app_license_history`
--

CREATE TABLE `app_license_history` (
  `id` int(11) NOT NULL,
  `license_id` int(11) NOT NULL,
  `action` varchar(255) NOT NULL,
  `extra` varchar(255) NOT NULL DEFAULT '',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `app_license_history`
--

INSERT INTO `app_license_history` (`id`, `license_id`, `action`, `extra`, `created_at`) VALUES
(1, 2, 'User assigned', 'Erlich Bachman', '2022-08-28 10:43:50');

-- --------------------------------------------------------

--
-- Table structure for table `app_locations`
--

CREATE TABLE `app_locations` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL DEFAULT 0,
  `name` varchar(255) NOT NULL DEFAULT '',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `app_locations`
--

INSERT INTO `app_locations` (`id`, `client_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 8, 'Underground', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 6, 'Pied Piper Office', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 2, 'Axe Office', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `app_manufacturers`
--

CREATE TABLE `app_manufacturers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `app_manufacturers`
--

INSERT INTO `app_manufacturers` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Apple', '2022-08-27 20:33:40', '2022-08-27 20:33:40'),
(2, 'Dell', '2022-08-27 20:33:45', '2022-08-27 20:33:45'),
(3, 'HP', '2022-08-27 20:33:49', '2022-08-27 20:33:49'),
(4, 'ASUS', '2022-08-27 20:33:53', '2022-08-27 20:33:53'),
(5, 'Acer', '2022-08-27 20:34:04', '2022-08-27 20:34:04'),
(6, 'Xerox', '2022-08-27 20:34:08', '2022-08-27 20:34:08'),
(7, 'IBM', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `app_models`
--

CREATE TABLE `app_models` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `app_models`
--

INSERT INTO `app_models` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'MacBook Air M1 2020', '2022-08-27 20:34:19', '2022-08-27 20:34:19'),
(2, 'MacBook Pro M1', '2022-08-27 20:34:34', '2022-08-27 20:34:34'),
(3, 'MacBook Air M2', '2022-08-27 20:34:44', '2022-08-27 20:34:44'),
(4, 'XK1', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'MacBook Pro M2', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, '3215', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `app_paymentmethods`
--

CREATE TABLE `app_paymentmethods` (
  `id` int(11) NOT NULL,
  `status` varchar(32) NOT NULL DEFAULT 'Active',
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `app_paymentmethods`
--

INSERT INTO `app_paymentmethods` (`id`, `status`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Active', 'Wire Transfer', '', '2022-08-27 20:18:02', '2022-08-27 20:18:02'),
(2, 'Active', 'Cash', '', '2022-08-27 20:18:07', '2022-08-27 20:18:07');

-- --------------------------------------------------------

--
-- Table structure for table `app_predefined_replies`
--

CREATE TABLE `app_predefined_replies` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `app_proformas`
--

CREATE TABLE `app_proformas` (
  `id` int(11) NOT NULL,
  `entity_id` int(11) NOT NULL DEFAULT 0,
  `language_id` int(1) NOT NULL DEFAULT 0,
  `client_id` int(11) NOT NULL,
  `proposal_id` int(11) NOT NULL DEFAULT 0,
  `recurring_id` int(11) NOT NULL DEFAULT 0,
  `added_by` int(11) NOT NULL DEFAULT 0,
  `issued_by` int(11) NOT NULL DEFAULT 0,
  `currency_id` int(11) NOT NULL,
  `rate` float NOT NULL DEFAULT 1,
  `number` varchar(64) NOT NULL DEFAULT '',
  `date` date NOT NULL,
  `due_date` varchar(32) NOT NULL,
  `value` decimal(16,2) NOT NULL DEFAULT 0.00,
  `tax` decimal(16,2) NOT NULL DEFAULT 0.00,
  `total` decimal(16,2) NOT NULL DEFAULT 0.00,
  `paid` decimal(16,2) NOT NULL DEFAULT 0.00,
  `unpaid` decimal(16,2) NOT NULL DEFAULT 0.00,
  `status` varchar(64) NOT NULL,
  `public_notes` text NOT NULL,
  `private_notes` text NOT NULL,
  `client_data` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `app_proformas`
--

INSERT INTO `app_proformas` (`id`, `entity_id`, `language_id`, `client_id`, `proposal_id`, `recurring_id`, `added_by`, `issued_by`, `currency_id`, `rate`, `number`, `date`, `due_date`, `value`, `tax`, `total`, `paid`, `unpaid`, `status`, `public_notes`, `private_notes`, `client_data`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 9, 2, 0, 1, 1, 1, 1, 'ONT 0001', '2022-08-27', '2022-08-27', '2500.00', '0.00', '2500.00', '0.00', '0.00', 'Valid', '', '', 'a:18:{s:2:\"id\";s:1:\"9\";s:4:\"type\";s:6:\"Client\";s:4:\"name\";s:10:\"Orchid Inc\";s:10:\"company_id\";s:0:\"\";s:13:\"company_taxid\";s:7:\"7328821\";s:5:\"phone\";s:10:\"8008018811\";s:5:\"email\";s:15:\"jake@orchid.com\";s:7:\"website\";s:10:\"orchid.com\";s:7:\"address\";s:0:\"\";s:4:\"city\";s:0:\"\";s:5:\"state\";s:0:\"\";s:8:\"zip_code\";s:0:\"\";s:7:\"country\";s:0:\"\";s:5:\"notes\";s:1095:\"<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean. A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth. Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name of Lorem Ipsum decided to leave for the far World of Grammar. The Big Oxmox advised her not to do so, because there were thousands of bad Commas, wild Question Marks and devious Semikoli, but the Little Blind Text didn’t listen. She packed her seven versalia, put her initial into the belt and made herself on the way. When she reached the first hills of the Italic Mountains, she had a last view back on the skyline of her hometown Bookmarksgrove, the headline of Alphabet Village and the subline of her own road, the Line Lane.</p>\";s:11:\"description\";s:0:\"\";s:20:\"custom_fields_values\";s:0:\"\";s:10:\"created_at\";s:19:\"2022-08-27 21:30:28\";s:10:\"updated_at\";s:19:\"2022-08-27 21:32:30\";}', '2022-08-27 21:35:25', '2022-08-27 21:35:25'),
(2, 1, 1, 2, 1, 0, 1, 1, 1, 1, 'ONT 0002', '2022-08-27', '2022-08-27', '120.00', '0.00', '120.00', '0.00', '120.00', 'Valid', '', '', 'a:18:{s:2:\"id\";s:1:\"2\";s:4:\"type\";s:6:\"Client\";s:4:\"name\";s:11:\"Axe Capital\";s:10:\"company_id\";s:0:\"\";s:13:\"company_taxid\";s:0:\"\";s:5:\"phone\";s:0:\"\";s:5:\"email\";s:0:\"\";s:7:\"website\";s:0:\"\";s:7:\"address\";s:0:\"\";s:4:\"city\";s:0:\"\";s:5:\"state\";s:0:\"\";s:8:\"zip_code\";s:0:\"\";s:7:\"country\";s:0:\"\";s:5:\"notes\";s:0:\"\";s:11:\"description\";s:0:\"\";s:20:\"custom_fields_values\";s:0:\"\";s:10:\"created_at\";s:19:\"2022-08-27 20:36:00\";s:10:\"updated_at\";s:19:\"2022-08-27 20:36:00\";}', '2022-08-27 21:37:04', '2022-08-27 21:37:04');

-- --------------------------------------------------------

--
-- Table structure for table `app_proforma_items`
--

CREATE TABLE `app_proforma_items` (
  `id` int(11) NOT NULL,
  `proforma_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `type` varchar(64) NOT NULL DEFAULT 'Service',
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `qty` float NOT NULL DEFAULT 0,
  `taxrate` float NOT NULL DEFAULT 0,
  `price` decimal(16,4) NOT NULL DEFAULT 0.0000,
  `value` decimal(16,2) NOT NULL DEFAULT 0.00,
  `tax` decimal(16,2) NOT NULL DEFAULT 0.00,
  `total` decimal(16,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `app_proforma_items`
--

INSERT INTO `app_proforma_items` (`id`, `proforma_id`, `item_id`, `type`, `name`, `description`, `qty`, `taxrate`, `price`, `value`, `tax`, `total`) VALUES
(1, 1, 1, 'Service', 'Computer Management', '', 25, 0, '100.0000', '2500.00', '0.00', '2500.00'),
(2, 2, 3, 'Service', 'Office 365 Management', '', 1, 0, '120.0000', '120.00', '0.00', '120.00');

-- --------------------------------------------------------

--
-- Table structure for table `app_projects`
--

CREATE TABLE `app_projects` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL DEFAULT 0,
  `name` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `notes` longtext NOT NULL,
  `status` varchar(32) NOT NULL DEFAULT 'Draft',
  `custom_fields_values` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `app_projects`
--

INSERT INTO `app_projects` (`id`, `client_id`, `name`, `description`, `notes`, `status`, `custom_fields_values`, `created_at`, `updated_at`) VALUES
(1, 6, 'Pied Piper', '<p><span>Over the years, <em>Pied Piper</em> has changed many landscapes. Compression. Data. The Internet. </span></p>', '', 'In Progress', 'null', '2022-08-27 20:42:53', '2022-08-27 20:43:20'),
(2, 2, 'Network Upgrade', '', '', 'In Progress', 'null', '2022-08-27 21:04:26', '2022-08-27 21:04:26');

-- --------------------------------------------------------

--
-- Table structure for table `app_project_comments`
--

CREATE TABLE `app_project_comments` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `app_project_files`
--

CREATE TABLE `app_project_files` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `show_user` tinyint(1) NOT NULL DEFAULT 1,
  `file` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `app_project_milestones`
--

CREATE TABLE `app_project_milestones` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `due_date` varchar(32) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `app_project_milestones`
--

INSERT INTO `app_project_milestones` (`id`, `project_id`, `name`, `description`, `due_date`, `created_at`, `updated_at`) VALUES
(1, 1, 'Version 1.1', '', '2022-10-31', '2022-08-28 14:15:51', '2022-08-28 14:15:51');

-- --------------------------------------------------------

--
-- Table structure for table `app_proposals`
--

CREATE TABLE `app_proposals` (
  `id` int(11) NOT NULL,
  `language_id` int(11) DEFAULT 1,
  `entity_id` int(11) NOT NULL DEFAULT 0,
  `client_id` int(11) NOT NULL,
  `added_by` int(11) NOT NULL DEFAULT 0,
  `currency_id` int(11) NOT NULL,
  `converted` int(1) NOT NULL DEFAULT 0,
  `rate` float NOT NULL DEFAULT 1,
  `number` varchar(64) NOT NULL DEFAULT '',
  `date` date NOT NULL,
  `valid_until` varchar(32) NOT NULL,
  `value` float NOT NULL DEFAULT 0,
  `tax` float NOT NULL DEFAULT 0,
  `total` float NOT NULL DEFAULT 0,
  `status` varchar(64) NOT NULL,
  `offer_text` text NOT NULL,
  `notes` text NOT NULL,
  `client_data` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `app_proposals`
--

INSERT INTO `app_proposals` (`id`, `language_id`, `entity_id`, `client_id`, `added_by`, `currency_id`, `converted`, `rate`, `number`, `date`, `valid_until`, `value`, `tax`, `total`, `status`, `offer_text`, `notes`, `client_data`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, 1, 1, 1, 1, 'ONT 0001', '2022-08-27', '2022-10-31', 120, 0, 120, 'Accepted', '', '', 'a:18:{s:2:\"id\";s:1:\"2\";s:4:\"type\";s:6:\"Client\";s:4:\"name\";s:11:\"Axe Capital\";s:10:\"company_id\";s:0:\"\";s:13:\"company_taxid\";s:0:\"\";s:5:\"phone\";s:0:\"\";s:5:\"email\";s:0:\"\";s:7:\"website\";s:0:\"\";s:7:\"address\";s:0:\"\";s:4:\"city\";s:0:\"\";s:5:\"state\";s:0:\"\";s:8:\"zip_code\";s:0:\"\";s:7:\"country\";s:0:\"\";s:5:\"notes\";s:0:\"\";s:11:\"description\";s:0:\"\";s:20:\"custom_fields_values\";s:0:\"\";s:10:\"created_at\";s:19:\"2022-08-27 20:36:00\";s:10:\"updated_at\";s:19:\"2022-08-27 20:36:00\";}', '2022-08-27 21:25:39', '2022-08-27 21:25:46'),
(2, 1, 1, 9, 1, 1, 1, 1, 'ONT 0002', '2022-09-01', '2022-11-30', 2500, 0, 2500, 'Accepted', '', '', 'a:18:{s:2:\"id\";s:1:\"9\";s:4:\"type\";s:4:\"Lead\";s:4:\"name\";s:10:\"Orchid Inc\";s:10:\"company_id\";s:0:\"\";s:13:\"company_taxid\";s:7:\"7328821\";s:5:\"phone\";s:10:\"8008018811\";s:5:\"email\";s:15:\"jake@orchid.com\";s:7:\"website\";s:10:\"orchid.com\";s:7:\"address\";s:0:\"\";s:4:\"city\";s:0:\"\";s:5:\"state\";s:0:\"\";s:8:\"zip_code\";s:0:\"\";s:7:\"country\";s:0:\"\";s:5:\"notes\";s:1095:\"<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean. A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth. Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name of Lorem Ipsum decided to leave for the far World of Grammar. The Big Oxmox advised her not to do so, because there were thousands of bad Commas, wild Question Marks and devious Semikoli, but the Little Blind Text didn’t listen. She packed her seven versalia, put her initial into the belt and made herself on the way. When she reached the first hills of the Italic Mountains, she had a last view back on the skyline of her hometown Bookmarksgrove, the headline of Alphabet Village and the subline of her own road, the Line Lane.</p>\";s:11:\"description\";s:0:\"\";s:20:\"custom_fields_values\";s:0:\"\";s:10:\"created_at\";s:19:\"2022-08-27 21:30:28\";s:10:\"updated_at\";s:19:\"2022-08-27 21:32:30\";}', '2022-08-27 21:33:23', '2022-08-27 21:33:56');

-- --------------------------------------------------------

--
-- Table structure for table `app_proposal_items`
--

CREATE TABLE `app_proposal_items` (
  `id` int(11) NOT NULL,
  `proposal_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `type` varchar(64) NOT NULL DEFAULT 'Service',
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `qty` float NOT NULL DEFAULT 0,
  `taxrate` float NOT NULL DEFAULT 0,
  `price` float NOT NULL DEFAULT 0,
  `value` float NOT NULL DEFAULT 0,
  `tax` float NOT NULL DEFAULT 0,
  `total` float NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `app_proposal_items`
--

INSERT INTO `app_proposal_items` (`id`, `proposal_id`, `item_id`, `type`, `name`, `description`, `qty`, `taxrate`, `price`, `value`, `tax`, `total`) VALUES
(2, 1, 3, 'Service', 'Office 365 Management', '', 1, 0, 120, 120, 0, 120),
(4, 2, 1, 'Service', 'Computer Management', '', 25, 0, 100, 2500, 0, 2500);

-- --------------------------------------------------------

--
-- Table structure for table `app_receipts`
--

CREATE TABLE `app_receipts` (
  `id` int(11) NOT NULL,
  `paymentmethod_id` int(11) NOT NULL,
  `entity_id` int(11) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `tagged_invoices` text NOT NULL,
  `status` varchar(32) NOT NULL DEFAULT 'Valid',
  `amount` decimal(16,2) NOT NULL,
  `rate` decimal(8,4) NOT NULL DEFAULT 1.0000,
  `date` date NOT NULL,
  `reference` varchar(255) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `app_receipts`
--

INSERT INTO `app_receipts` (`id`, `paymentmethod_id`, `entity_id`, `currency_id`, `client_id`, `invoice_id`, `tagged_invoices`, `status`, `amount`, `rate`, `date`, `reference`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 8, 0, 'a:1:{i:0;s:1:\"1\";}', 'Valid', '2600.00', '1.0000', '2022-08-27', '1234', '', '2022-08-27 21:18:19', '2022-08-27 21:18:19');

-- --------------------------------------------------------

--
-- Table structure for table `app_recurring`
--

CREATE TABLE `app_recurring` (
  `id` int(11) NOT NULL,
  `type` varchar(32) NOT NULL,
  `entity_id` int(11) NOT NULL DEFAULT 0,
  `client_id` int(11) NOT NULL,
  `added_by` int(11) NOT NULL DEFAULT 0,
  `language_id` int(11) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `send_email` int(1) NOT NULL DEFAULT 0,
  `name` varchar(255) NOT NULL DEFAULT '',
  `frequency` varchar(128) NOT NULL,
  `start_date` date NOT NULL,
  `next_date` date NOT NULL,
  `due_days` int(11) NOT NULL DEFAULT 0,
  `emission_limit` int(11) NOT NULL DEFAULT -1,
  `emissions` int(11) NOT NULL DEFAULT 0,
  `value` float NOT NULL DEFAULT 0,
  `status` varchar(64) NOT NULL,
  `notes` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


-- --------------------------------------------------------

--
-- Table structure for table `app_recurring_expenses`
--

CREATE TABLE `app_recurring_expenses` (
  `id` int(11) NOT NULL,
  `entity_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `value` decimal(12,2) NOT NULL,
  `tax` decimal(12,2) NOT NULL,
  `total` decimal(12,2) NOT NULL,
  `paid` decimal(12,2) NOT NULL,
  `description` varchar(255) NOT NULL,
  `frequency` varchar(128) NOT NULL,
  `start_date` date NOT NULL,
  `next_date` date NOT NULL,
  `emission_limit` int(11) NOT NULL DEFAULT -1,
  `emissions` int(11) NOT NULL DEFAULT 0,
  `status` varchar(32) NOT NULL,
  `file` varchar(255) NOT NULL DEFAULT '',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- --------------------------------------------------------

--
-- Table structure for table `app_recurring_items`
--

CREATE TABLE `app_recurring_items` (
  `id` int(11) NOT NULL,
  `recurring_id` int(11) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `type` varchar(64) NOT NULL DEFAULT 'Service',
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `qty` float NOT NULL DEFAULT 0,
  `taxrate` float NOT NULL DEFAULT 0,
  `price` float NOT NULL DEFAULT 0,
  `value` float NOT NULL DEFAULT 0,
  `tax` float NOT NULL DEFAULT 0,
  `total` float NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


-- --------------------------------------------------------

--
-- Table structure for table `app_reminders`
--

CREATE TABLE `app_reminders` (
  `id` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `assigned_to` int(11) NOT NULL,
  `client_id` int(11) NOT NULL DEFAULT 0,
  `status` varchar(32) NOT NULL,
  `description` longtext NOT NULL,
  `datetime` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `app_reminders`
--

INSERT INTO `app_reminders` (`id`, `added_by`, `assigned_to`, `client_id`, `status`, `description`, `datetime`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 0, 'Upcoming', 'Renew Office 365 license', '2023-01-25 00:22:00', '2022-08-27 21:22:15', '2022-08-27 21:22:15'),
(2, 1, 1, 2, 'Upcoming', 'Reboot cloud server V22', '2022-09-20 00:22:00', '2022-08-27 21:22:58', '2022-08-27 21:22:58');

-- --------------------------------------------------------

--
-- Table structure for table `app_status_labels`
--

CREATE TABLE `app_status_labels` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `color` varchar(7) NOT NULL DEFAULT '#000',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `app_status_labels`
--

INSERT INTO `app_status_labels` (`id`, `name`, `color`, `created_at`, `updated_at`) VALUES
(1, 'Active', '#3BA024', '2022-08-27 20:32:14', '2022-08-27 20:32:14'),
(2, 'Deployed', '#227ABC', '2022-08-27 20:32:27', '2022-08-27 20:32:27'),
(3, 'Broken', '#F10F0F', '2022-08-27 20:32:39', '2022-08-27 20:32:50'),
(4, 'In Repair', '#DDBB2C', '2022-08-27 20:33:03', '2022-08-27 20:33:03'),
(5, 'Decommissioned', '#BAB6B6', '2022-08-27 20:33:32', '2022-08-27 20:33:32');

-- --------------------------------------------------------

--
-- Table structure for table `app_suppliers`
--

CREATE TABLE `app_suppliers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `contact_name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `web_address` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `notes` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `app_suppliers`
--

INSERT INTO `app_suppliers` (`id`, `name`, `contact_name`, `phone`, `email`, `web_address`, `address`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'IBM', '', '', '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Amazon', '', '', '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'cPanel', '', '', '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'GoDaddy', '', '', '', '', '', '', '2022-08-27 21:10:39', '2022-08-27 21:10:39'),
(5, 'Hetzner', '', '', '', '', '', '', '2022-08-27 21:11:04', '2022-08-27 21:11:04'),
(6, 'Office Co', '', '', '', '', '', '', '2022-08-27 21:14:53', '2022-08-27 21:14:53');

-- --------------------------------------------------------

--
-- Table structure for table `app_supplier_addresses`
--

CREATE TABLE `app_supplier_addresses` (
  `id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zip_code` varchar(32) NOT NULL,
  `country` varchar(64) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `notes` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `app_supplier_comments`
--

CREATE TABLE `app_supplier_comments` (
  `id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `app_supplier_files`
--

CREATE TABLE `app_supplier_files` (
  `id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `file` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `app_taxrates`
--

CREATE TABLE `app_taxrates` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `rate` float NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `app_taxrates`
--

INSERT INTO `app_taxrates` (`id`, `name`, `rate`, `created_at`, `updated_at`) VALUES
(1, '0%', 0, '2022-08-27 23:14:36', '2022-08-27 20:27:31');

-- --------------------------------------------------------

--
-- Table structure for table `app_tickets`
--

CREATE TABLE `app_tickets` (
  `id` int(11) NOT NULL,
  `uuid` varchar(64) NOT NULL,
  `ticket` varchar(64) NOT NULL,
  `user_id` int(11) NOT NULL,
  `assigned_to` int(11) NOT NULL,
  `client_id` int(11) NOT NULL DEFAULT 0,
  `asset_id` int(11) NOT NULL DEFAULT 0,
  `license_id` int(11) NOT NULL DEFAULT 0,
  `project_id` int(11) NOT NULL DEFAULT 0,
  `email` varchar(128) NOT NULL,
  `cc` text NOT NULL,
  `status` varchar(32) NOT NULL,
  `priority` varchar(32) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `notes` longtext NOT NULL,
  `custom_fields_values` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `app_ticket_comments`
--

CREATE TABLE `app_ticket_comments` (
  `id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


-- --------------------------------------------------------

--
-- Table structure for table `app_ticket_replies`
--

CREATE TABLE `app_ticket_replies` (
  `id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` longtext NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


-- --------------------------------------------------------

--
-- Table structure for table `app_ticket_reply_files`
--

CREATE TABLE `app_ticket_reply_files` (
  `id` int(11) NOT NULL,
  `reply_id` int(11) NOT NULL,
  `file` text NOT NULL,
  `name` text NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `core_emails`
--

CREATE TABLE `core_emails` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `sent` varchar(10) NOT NULL DEFAULT 'No',
  `priority` int(1) NOT NULL DEFAULT 1,
  `email_address` varchar(255) NOT NULL,
  `subject` text NOT NULL,
  `body` longtext NOT NULL,
  `attachments` text NOT NULL,
  `errors` text NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


-- --------------------------------------------------------

--
-- Table structure for table `core_email_templates`
--

CREATE TABLE `core_email_templates` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `subject` text NOT NULL,
  `body` longtext NOT NULL,
  `info` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `core_email_templates`
--

INSERT INTO `core_email_templates` (`id`, `name`, `subject`, `body`, `info`, `created_at`, `updated_at`) VALUES
(1, 'User | Welcome email', 'Welcome', '<p>Hi {name},</p>\r\n<p></p>\r\n<p>Your account hass been succesfully created on {app_name} helpdesk.</p>\r\n<p>To login please use the following details:</p>\r\n<p>URL: {url}</p>\r\n<p>Username: {email}</p>\r\n<p>Password: {password}</p>\r\n<p>*For security reasons we strogly advise that you chnage your password after the first log in.</p>\r\n<p></p>\r\n<p></p>', '', '2018-12-06 00:00:00', '2022-08-28 12:39:43'),
(2, 'User | Password reset', 'Password reset', '<p>Hi {name},</p>\r\n<p></p>\r\n<p>To reset your password please click <a href=\"{url}\">here</a> or copy and paste the link below into your favorite browser.</p>\r\n<p>{url}</p>', '', '2018-12-06 00:00:00', '2022-08-23 10:28:56'),
(3, 'User | Password reset confirmation', 'Password reset confirmation', '<p>Hi {name},</p>\r\n<p></p>\r\n<p>This is to confirm that you have succesfully reset your password.</p>', '', '2018-12-06 00:00:00', '2022-08-23 10:29:50'),
(4, 'Staff | Password reset', 'Password reset', '<p>Hi {name},</p>\r\n<p></p>\r\n<p>To reset your password please click <a href=\"{url}\">here</a> or copy and paste the link below into your favorite browser.</p>\r\n<p>{url}</p>', '', '2018-12-06 00:00:00', '2022-08-28 12:44:23'),
(5, 'Staff | Password reset confirmation', 'Password reset confirmation', '<p>Hi {name},</p>\r\n<p></p>\r\n<p>This is to confirm that you have succesfully reset your password.</p>\r\n<p></p>', '', '2018-12-06 00:00:00', '2022-08-28 12:44:33'),
(6, 'Staff | Reminder alert', 'Reminder: {reminder}', '<p>Hi {name}</p>\n<p> </p>\n<p>The following reminder has been triggered:</p>\n<p><strong>{reminder}</strong></p>', '', '2021-11-24 15:42:15', '2021-11-24 15:42:15'),
(7, 'Staff | Issue due date reminder', 'Issues due date reminder: {issue}', '<p>Hi {name},</p>\r\n<p>The due date for the following issue: <strong>{issue}</strong> is <strong>{due_date}</strong>.</p>', '', '2021-11-24 15:42:43', '2022-08-28 12:48:17'),
(8, 'Staff | Issue overdue', 'Issue overdue: {issue}', '<p>Hi {name},</p>\r\n<p>The due date for the following issue: <strong>{issue}</strong> is overdue.</p>', '', '2021-11-24 15:42:59', '2022-08-28 12:49:09'),
(9, 'Staff | Issue assigned', 'Issue assigned: {issue}', '<p>Hi {name},</p>\r\n<p></p>\r\n<p>The following issue has been assigned to you</p>\r\n<p>Issue: <strong>{issue}</strong></p>\r\n<p>Due date: <strong>{due_date}</strong></p>', '', '2021-11-24 15:43:12', '2022-08-28 12:50:30'),
(10, 'Staff | New ticket', 'New ticket #{ticket} - {subject}', '<p>Hi {name},</p>\r\n<p></p>\r\n<p>A new ticket has been opened:</p>\r\n<p>Ticket: #<strong>{ticket}</strong></p>\r\n<p>Subject: <strong>{subject}</strong></p>\r\n<p>Message:</p>\r\n<p>{message}</p>', '', '2021-11-24 15:43:33', '2022-08-28 13:21:18'),
(11, 'Staff | New ticket reply', 'New ticket reply #{ticket} - {subject}', '<p>Hi {name},</p>\r\n<p></p>\r\n<p>A new reply has been added to the following ticket:</p>\r\n<p>Ticket: #{ticket}</p>\r\n<p>Subject: {subject}</p>\r\n<p>{message}</p>', '', '2021-11-24 15:43:49', '2022-08-28 13:21:09'),
(12, 'Staff | Ticket assigned', 'Ticket assigned: #{ticket} - {subject}', '<p>Hi {name},</p>\r\n<p></p>\r\n<p>The following ticket has been assigned to you</p>\r\n<p>Ticket: #{ticket}</p>\r\n<p>Subject: {subject}</p>\r\n<p></p>\r\n<p>{message}</p>\r\n<p></p>', '', '2021-11-24 15:44:00', '2022-08-28 13:21:34'),
(13, 'Staff | New recurring document', 'New recurring document', '<p>Hi {name},</p>\r\n<p></p>\r\n<p>A new recurring document has been issued:</p>\r\n<p>Type: {type}</p>\r\n<p>Recurrence name: {reccurence_name}</p>\r\n<p>Client: {client}</p>\r\n<p></p>', '', '2021-11-24 15:44:13', '2022-08-28 12:59:11'),
(14, 'Client | New Invoice', 'New invoice: {invoice_no}', '<p>Hi {client_name},</p>\r\n<p></p>\r\n<p>Please find attached the following invoice</p>\r\n<p>Number: <strong>{invoice_no}</strong></p>\r\n<p>Total value: <strong>{invoice_total}</strong></p>\r\n<p>Due date: <strong>{due_date}</strong></p>', '', '2021-11-24 15:45:15', '2022-08-28 13:01:42'),
(15, 'Client | Invoice Reminder', 'Payment reminder: {invoice_no}', '<p>Hi {client_name},</p>\r\n<p></p>\r\n<p>According to our records the following invoice is <strong>unpaid</strong>.</p>\r\n<p>Invoice: <strong>{invoice_no}</strong></p>\r\n<p>Total: <strong>{invoice_total}</strong></p>\r\n<p>Due date: <strong>{due_date}</strong></p>', '', '2021-11-24 15:45:32', '2022-08-28 13:04:45'),
(16, 'Client | Invoice Overdue', 'Payment overdue: {invoice_no}', '<p>Hi {client_name},</p>\r\n<p></p>\r\n<p>According to our records the payment for the following invoice is now <strong>overdue. </strong></p>\r\n<p>Please complete the payment as soon as possible in order to avoid service interruption.</p>\r\n<p>Number: <strong>{invoice_no}</strong></p>\r\n<p>Total: <strong>{invoice_total}</strong></p>\r\n<p>Due date: <span xss=removed><strong>{due_date}</strong></span></p>\r\n<p>*If you have already completed the payment please ignore this email.</p>', '', '2021-11-24 15:45:48', '2022-08-28 13:09:56'),
(17, 'Client | New Proposal', 'New Proposal: {proposal_no}', '<p>Hi {client_name},</p>\r\n<p></p>\r\n<p>Please find attached the following proposal:</p>\r\n<p>Number: <strong>{proposal_no}</strong></p>\r\n<p>Total value: <strong>{proposal_total}</strong></p>\r\n<p>Due date: <strong>{due_date}</strong></p>', '', '2021-11-24 15:46:16', '2022-08-28 13:11:10'),
(18, 'Client | New Proforma', 'New Proforma: {proforma_no}', '<p>Hi {client_name},</p>\r\n<p></p>\r\n<p>Please find attached the following proforma:</p>\r\n<p>Number: <strong>{proforma_no}</strong></p>\r\n<p>Total value: <strong>{proforma_total}</strong></p>\r\n<p>Due date: <strong>{due_date}</strong></p>', '', '2021-11-24 15:46:47', '2022-08-28 13:11:59'),
(19, 'User | New ticket', 'New ticket: #{ticket} - {subject}', '<p>Hi {name},</p>\r\n<p></p>\r\n<p>For your request, we have opened the following support ticket {ticket}.</p>\r\n<p>Our representatives will get back to you as soon as possible.</p>\r\n<p>Ticket: #<strong>{ticket}</strong></p>\r\n<p>Subject: <strong>{subject}</strong></p>\r\n<p>Your messahe:</p>\r\n<p>{message}</p>', '', '2021-11-24 15:47:23', '2022-08-28 13:21:45'),
(20, 'User | New ticket reply', 'New ticket reply: #{ticket} - {subject}', '<p>Hi {name},</p>\r\n<p></p>\r\n<p>A new response has been added to your ticket:</p>\r\n<p><strong>#{ticket}</strong> - <strong>{subject}</strong></p>\r\n<p>{message}</p>', '', '2021-11-24 15:47:36', '2022-08-28 13:21:52'),
(21, 'User | Ticket auto close', 'Ticket closed #{ticket} - {subject}', '<p>Hi {name},</p>\r\n<p></p>\r\n<p>Since we have not received new information from you, regarding the ticket below, our system closed your request automatically.</p>\r\n<p>#{ticket} - {subject}</p>\r\n<p>*This is an automated email.</p>', '', '2021-11-24 15:47:50', '2022-08-28 13:21:57'),
(22, 'Staff | Domain expiry', 'Domain {domain} expires on {exp_date}', '<p>Hi {name}</p>\n<p> </p>\n<p>The domain <strong>{domain}</strong> expires on <strong>{exp_date}</strong></p>\n', '', '2021-12-06 13:08:26', '2021-12-06 13:08:26'),
(23, 'Staff | Domain expired', 'Domain {domain} has expired', '<p>Hi {name}</p>\r\n<p></p>\r\n<p>The domain <strong>{domain}</strong> has <strong>expired.</strong></p>', '', '2021-12-06 13:10:24', '2022-08-28 13:23:26'),
(24, 'Client | Domain expiry', 'Domain {domain} expires on {exp_date}', '<p>Hi {name}</p>\r\n<p></p>\r\n<p>The domain <strong>{domain}</strong> expires on <strong>{exp_date}.</strong></p>', '', '2021-12-06 13:12:20', '2022-08-28 13:23:36'),
(25, 'Client | Domain expired', 'Domain {domain} has expired', '<p>Hi {name}</p>\r\n<p> </p>\r\n<p>The domain <strong>{domain}</strong> has <strong>expired</strong></p>\r\n', '', '2021-12-06 13:12:51', '2021-12-06 13:12:51'),
(26, 'Staff | New Issue', 'New issue: {issue}', '<p>Hi {name},</p>\r\n<p> </p>\r\n<p>A new issue has been added:</p>\r\n<p> </p>\r\n<p>Issue: <strong>{issue}</strong></p>\r\n<br><br>\r\n', '', '2022-08-19 18:33:50', '2022-08-19 18:33:50');

-- --------------------------------------------------------

--
-- Table structure for table `core_languages`
--

CREATE TABLE `core_languages` (
  `id` int(11) NOT NULL,
  `code` varchar(16) NOT NULL,
  `name` varchar(255) NOT NULL,
  `rtl` int(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `core_languages`
--

INSERT INTO `core_languages` (`id`, `code`, `name`, `rtl`, `created_at`, `updated_at`) VALUES
(1, 'en', 'English', 0, '2018-11-01 00:00:00', '2018-11-01 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `core_roles`
--

CREATE TABLE `core_roles` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `permissions` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `core_roles`
--

INSERT INTO `core_roles` (`id`, `name`, `permissions`, `created_at`, `updated_at`) VALUES
(1, 'Super Administrator', 'a:2:{i:0;s:7:\"default\";i:1;s:15:\"licenses-delete\";}', '2018-11-01 00:00:00', '2022-08-27 09:14:10');

-- --------------------------------------------------------

--
-- Table structure for table `core_sessions`
--

CREATE TABLE `core_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) NOT NULL,
  `data` blob NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `core_settings`
--

CREATE TABLE `core_settings` (
  `name` varchar(255) NOT NULL,
  `value` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `core_settings`
--

INSERT INTO `core_settings` (`name`, `value`) VALUES
('default_language', '1'),
('google_recaptcha', '0'),
('google_recaptcha_sitekey', ''),
('google_recaptcha_secretkey', ''),
('email_from_address', 'ontrack@demo.com'),
('email_from_name', 'onTrack'),
('email_smtp', '0'),
('email_smtp_host', ''),
('email_smtp_port', ''),
('email_smtp_crypto', ''),
('email_smtp_user', ''),
('email_smtp_pass', ''),
('app_name', 'onTrack'),
('timezone', 'UTC'),
('date_format', 'Y-m-d;yyyy-mm-dd'),
('week_start', '1'),
('default_taxrate', '1'),
('default_currency', '1'),
('multi_entity', '1'),
('invoice_accent_color', '#AE05E3'),
('proposal_text', ''),
('email_signature', '<p></p>\r\n<p>Best wishes,</p>\r\n<p>onTrack</p>'),
('invoice_text', ''),
('imap_server', ''),
('imap_port', '993'),
('imap_encryption', '/ssl'),
('imap_user', ''),
('imap_pass', ''),
('custom_imap_connect', ''),
('tickets_autoclose', '0'),
('tickets_autoclose_notif', '1'),
('cron_lastrun', ''),
('cron_daily_lastrun', ''),
('cron_daily_run_at', '09'),
('decimal_separator', '.'),
('thousands_separator', ' '),
('user_accent_color', '#363945'),
('user_permission_assets', '1'),
('user_permission_licenses', '1'),
('user_permission_domains', '1'),
('user_permission_credentials', '1'),
('user_permission_projects', '1'),
('user_permission_tickets', '1'),
('user_permission_issues', '1'),
('user_permission_kb', '1'),
('user_permission_ducumentation', '1'),
('user_permission_invoices', '1'),
('user_permission_proformas', '1'),
('user_permission_proposals', '1'),
('user_permission_profile', '1'),
('user_permission_client', '1'),
('public_kb', '1'),
('public_documentation', '1'),
('public_submit_ticket', '1'),
('user_permission_receipts', '1'),
('db_level', '1'),
('exchange_rates_provider', ''),
('exchange_rates_provider_key', ''),
('exchange_rates_provider_last_update', '');

-- --------------------------------------------------------

--
-- Table structure for table `core_staff`
--

CREATE TABLE `core_staff` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `ticket_notif` int(1) NOT NULL DEFAULT 1,
  `status` varchar(12) NOT NULL DEFAULT 'Active',
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `body_class` varchar(32) NOT NULL DEFAULT 'day',
  `d_finance_overview` int(1) DEFAULT 1,
  `d_monthly_financials` int(1) NOT NULL DEFAULT 1,
  `d_assets_category` int(1) NOT NULL DEFAULT 1,
  `d_assets_status` int(1) NOT NULL DEFAULT 1,
  `d_license_category` int(1) NOT NULL DEFAULT 1,
  `d_license_status` int(1) NOT NULL DEFAULT 1,
  `d_recent_assets` int(1) NOT NULL DEFAULT 1,
  `d_recent_licenses` int(1) NOT NULL DEFAULT 1,
  `d_recent_projects` int(1) NOT NULL DEFAULT 1,
  `d_assigned_tickets` int(1) NOT NULL DEFAULT 1,
  `d_assigned_issues` int(1) NOT NULL DEFAULT 1,
  `d_upcoming_reminders` int(1) NOT NULL DEFAULT 1,
  `d_upcoming_events` int(1) NOT NULL DEFAULT 1,
  `d_sent_proposals` int(1) NOT NULL DEFAULT 1,
  `d_exchange_rates` int(1) NOT NULL DEFAULT 1,
  `password` varchar(255) NOT NULL,
  `password_reset_key` varchar(255) NOT NULL DEFAULT '',
  `calendars` text NOT NULL,
  `color` varchar(6) NOT NULL DEFAULT 'cccccc',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;


-- --------------------------------------------------------

--
-- Table structure for table `core_staff_activity_log`
--

CREATE TABLE `core_staff_activity_log` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `ip_address` text NOT NULL,
  `description` text NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `core_translations`
--

CREATE TABLE `core_translations` (
  `id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `original_string` text NOT NULL,
  `translated_string` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;


-- --------------------------------------------------------

--
-- Table structure for table `core_users`
--

CREATE TABLE `core_users` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL DEFAULT 0,
  `status` varchar(12) NOT NULL DEFAULT 'Active',
  `language_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `designation` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL,
  `password_reset_key` varchar(255) NOT NULL DEFAULT '',
  `permission_assets` tinyint(1) NOT NULL DEFAULT 1,
  `permission_licenses` tinyint(1) NOT NULL DEFAULT 1,
  `permission_domains` tinyint(1) NOT NULL DEFAULT 1,
  `permission_credentials` tinyint(1) NOT NULL DEFAULT 1,
  `permission_projects` tinyint(1) NOT NULL DEFAULT 1,
  `permission_tickets` tinyint(1) NOT NULL DEFAULT 1,
  `permission_issues` tinyint(1) NOT NULL DEFAULT 1,
  `permission_kb` tinyint(1) NOT NULL DEFAULT 1,
  `permission_ducumentation` tinyint(1) NOT NULL DEFAULT 1,
  `permission_invoices` tinyint(1) NOT NULL DEFAULT 1,
  `permission_proformas` tinyint(1) NOT NULL DEFAULT 1,
  `permission_proposals` tinyint(1) NOT NULL DEFAULT 1,
  `permission_receipts` tinyint(1) NOT NULL DEFAULT 1,
  `permission_profile` tinyint(1) NOT NULL DEFAULT 1,
  `permission_client` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `core_user_activity_log`
--

CREATE TABLE `core_user_activity_log` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ip_address` text NOT NULL,
  `description` text NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `app_assets`
--
ALTER TABLE `app_assets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `status_id` (`status_id`),
  ADD KEY `manufacturer_id` (`manufacturer_id`),
  ADD KEY `model_id` (`model_id`),
  ADD KEY `location_id` (`location_id`),
  ADD KEY `supplie_id` (`supplier_id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `app_asset_categories`
--
ALTER TABLE `app_asset_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_asset_comments`
--
ALTER TABLE `app_asset_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_asset_files`
--
ALTER TABLE `app_asset_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_asset_history`
--
ALTER TABLE `app_asset_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asset_id` (`asset_id`);

--
-- Indexes for table `app_clients`
--
ALTER TABLE `app_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `app_client_addresses`
--
ALTER TABLE `app_client_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `app_client_comments`
--
ALTER TABLE `app_client_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `app_client_files`
--
ALTER TABLE `app_client_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `app_credentials`
--
ALTER TABLE `app_credentials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_currencies`
--
ALTER TABLE `app_currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_customfields`
--
ALTER TABLE `app_customfields`
  ADD PRIMARY KEY (`id`),
  ADD KEY `for` (`for`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `app_docs_pages`
--
ALTER TABLE `app_docs_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_docs_spaces`
--
ALTER TABLE `app_docs_spaces`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_domains`
--
ALTER TABLE `app_domains`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_entities`
--
ALTER TABLE `app_entities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_events`
--
ALTER TABLE `app_events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_expenses`
--
ALTER TABLE `app_expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplier_id` (`supplier_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `currency_id` (`currency_id`),
  ADD KEY `entity_id` (`entity_id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `app_expense_categories`
--
ALTER TABLE `app_expense_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_invoices`
--
ALTER TABLE `app_invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `entity_id` (`entity_id`),
  ADD KEY `language_id` (`language_id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `proposal_id` (`proposal_id`),
  ADD KEY `recurring_id` (`recurring_id`),
  ADD KEY `currency_id` (`currency_id`),
  ADD KEY `added_by` (`added_by`),
  ADD KEY `issued_by` (`issued_by`),
  ADD KEY `created_at` (`created_at`),
  ADD KEY `updated_at` (`updated_at`),
  ADD KEY `date` (`date`);

--
-- Indexes for table `app_invoice_items`
--
ALTER TABLE `app_invoice_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_id` (`invoice_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `app_issues`
--
ALTER TABLE `app_issues`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `assigned_to` (`assigned_to`),
  ADD KEY `added_by` (`added_by`),
  ADD KEY `asset_id` (`asset_id`),
  ADD KEY `license_id` (`license_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `app_issue_comments`
--
ALTER TABLE `app_issue_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_issue_files`
--
ALTER TABLE `app_issue_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_items`
--
ALTER TABLE `app_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `app_item_files`
--
ALTER TABLE `app_item_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `added_by` (`added_by`);

--
-- Indexes for table `app_item_images`
--
ALTER TABLE `app_item_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `added_by` (`added_by`);

--
-- Indexes for table `app_kb_articles`
--
ALTER TABLE `app_kb_articles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_kb_categories`
--
ALTER TABLE `app_kb_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_licenses`
--
ALTER TABLE `app_licenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `status_id` (`status_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `app_license_assignments`
--
ALTER TABLE `app_license_assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `license_id` (`license_id`),
  ADD KEY `asset_id` (`asset_id`);

--
-- Indexes for table `app_license_categories`
--
ALTER TABLE `app_license_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_license_comments`
--
ALTER TABLE `app_license_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_license_files`
--
ALTER TABLE `app_license_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_license_history`
--
ALTER TABLE `app_license_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asset_id` (`license_id`);

--
-- Indexes for table `app_locations`
--
ALTER TABLE `app_locations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`) USING BTREE;

--
-- Indexes for table `app_manufacturers`
--
ALTER TABLE `app_manufacturers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_models`
--
ALTER TABLE `app_models`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_paymentmethods`
--
ALTER TABLE `app_paymentmethods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_predefined_replies`
--
ALTER TABLE `app_predefined_replies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_proformas`
--
ALTER TABLE `app_proformas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `entity_id` (`entity_id`),
  ADD KEY `language_id` (`language_id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `proposal_id` (`proposal_id`),
  ADD KEY `recurring_id` (`recurring_id`),
  ADD KEY `currency_id` (`currency_id`),
  ADD KEY `added_by` (`added_by`),
  ADD KEY `issued_by` (`issued_by`),
  ADD KEY `created_at` (`created_at`),
  ADD KEY `updated_at` (`updated_at`),
  ADD KEY `date` (`date`);

--
-- Indexes for table `app_proforma_items`
--
ALTER TABLE `app_proforma_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_id` (`proforma_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `app_projects`
--
ALTER TABLE `app_projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_project_comments`
--
ALTER TABLE `app_project_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_project_files`
--
ALTER TABLE `app_project_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_project_milestones`
--
ALTER TABLE `app_project_milestones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_proposals`
--
ALTER TABLE `app_proposals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `entity_id` (`entity_id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `added_by` (`added_by`),
  ADD KEY `currency_id` (`currency_id`),
  ADD KEY `converted` (`converted`),
  ADD KEY `language_id` (`language_id`);

--
-- Indexes for table `app_proposal_items`
--
ALTER TABLE `app_proposal_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proposal_id` (`proposal_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `app_receipts`
--
ALTER TABLE `app_receipts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `paymentmethod_id` (`paymentmethod_id`),
  ADD KEY `currency_id` (`currency_id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `invoice_id` (`invoice_id`),
  ADD KEY `date` (`date`),
  ADD KEY `status` (`status`),
  ADD KEY `entity_id` (`entity_id`);

--
-- Indexes for table `app_recurring`
--
ALTER TABLE `app_recurring`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type` (`type`),
  ADD KEY `entity_id` (`entity_id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `added_by` (`added_by`),
  ADD KEY `language_id` (`language_id`),
  ADD KEY `currency_id` (`currency_id`),
  ADD KEY `start_date` (`start_date`),
  ADD KEY `next_date` (`next_date`);

--
-- Indexes for table `app_recurring_expenses`
--
ALTER TABLE `app_recurring_expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplier_id` (`supplier_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `currency_id` (`currency_id`),
  ADD KEY `entity_id` (`entity_id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `app_recurring_items`
--
ALTER TABLE `app_recurring_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recurring_id` (`recurring_id`),
  ADD KEY `currency_id` (`currency_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `app_reminders`
--
ALTER TABLE `app_reminders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_status_labels`
--
ALTER TABLE `app_status_labels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_suppliers`
--
ALTER TABLE `app_suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_supplier_addresses`
--
ALTER TABLE `app_supplier_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`supplier_id`);

--
-- Indexes for table `app_supplier_comments`
--
ALTER TABLE `app_supplier_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`supplier_id`);

--
-- Indexes for table `app_supplier_files`
--
ALTER TABLE `app_supplier_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`supplier_id`);

--
-- Indexes for table `app_taxrates`
--
ALTER TABLE `app_taxrates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_tickets`
--
ALTER TABLE `app_tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `assigned_to` (`assigned_to`),
  ADD KEY `asset_id` (`asset_id`),
  ADD KEY `license_id` (`license_id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `uuid` (`uuid`);

--
-- Indexes for table `app_ticket_comments`
--
ALTER TABLE `app_ticket_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_ticket_replies`
--
ALTER TABLE `app_ticket_replies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_ticket_reply_files`
--
ALTER TABLE `app_ticket_reply_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `core_emails`
--
ALTER TABLE `core_emails`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff_id` (`staff_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `sent` (`sent`),
  ADD KEY `priority` (`priority`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `core_email_templates`
--
ALTER TABLE `core_email_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `core_languages`
--
ALTER TABLE `core_languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `core_roles`
--
ALTER TABLE `core_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `core_sessions`
--
ALTER TABLE `core_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `timestamp` (`timestamp`);

--
-- Indexes for table `core_settings`
--
ALTER TABLE `core_settings`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `core_staff`
--
ALTER TABLE `core_staff`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `core_staff_activity_log`
--
ALTER TABLE `core_staff_activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `core_translations`
--
ALTER TABLE `core_translations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `language_id` (`language_id`);

--
-- Indexes for table `core_users`
--
ALTER TABLE `core_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `status` (`status`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `core_user_activity_log`
--
ALTER TABLE `core_user_activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `app_assets`
--
ALTER TABLE `app_assets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `app_asset_categories`
--
ALTER TABLE `app_asset_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `app_asset_comments`
--
ALTER TABLE `app_asset_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `app_asset_files`
--
ALTER TABLE `app_asset_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_asset_history`
--
ALTER TABLE `app_asset_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `app_clients`
--
ALTER TABLE `app_clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `app_client_addresses`
--
ALTER TABLE `app_client_addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_client_comments`
--
ALTER TABLE `app_client_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `app_client_files`
--
ALTER TABLE `app_client_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_credentials`
--
ALTER TABLE `app_credentials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_currencies`
--
ALTER TABLE `app_currencies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `app_customfields`
--
ALTER TABLE `app_customfields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_docs_pages`
--
ALTER TABLE `app_docs_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `app_docs_spaces`
--
ALTER TABLE `app_docs_spaces`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `app_domains`
--
ALTER TABLE `app_domains`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `app_entities`
--
ALTER TABLE `app_entities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `app_events`
--
ALTER TABLE `app_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `app_expenses`
--
ALTER TABLE `app_expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_expense_categories`
--
ALTER TABLE `app_expense_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `app_invoices`
--
ALTER TABLE `app_invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_invoice_items`
--
ALTER TABLE `app_invoice_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_issues`
--
ALTER TABLE `app_issues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `app_issue_comments`
--
ALTER TABLE `app_issue_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_issue_files`
--
ALTER TABLE `app_issue_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_items`
--
ALTER TABLE `app_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `app_item_files`
--
ALTER TABLE `app_item_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_item_images`
--
ALTER TABLE `app_item_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_kb_articles`
--
ALTER TABLE `app_kb_articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_kb_categories`
--
ALTER TABLE `app_kb_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_licenses`
--
ALTER TABLE `app_licenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `app_license_assignments`
--
ALTER TABLE `app_license_assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_license_categories`
--
ALTER TABLE `app_license_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `app_license_comments`
--
ALTER TABLE `app_license_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_license_files`
--
ALTER TABLE `app_license_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_license_history`
--
ALTER TABLE `app_license_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `app_locations`
--
ALTER TABLE `app_locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `app_manufacturers`
--
ALTER TABLE `app_manufacturers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `app_models`
--
ALTER TABLE `app_models`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `app_paymentmethods`
--
ALTER TABLE `app_paymentmethods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `app_predefined_replies`
--
ALTER TABLE `app_predefined_replies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_proformas`
--
ALTER TABLE `app_proformas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `app_proforma_items`
--
ALTER TABLE `app_proforma_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `app_projects`
--
ALTER TABLE `app_projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `app_project_comments`
--
ALTER TABLE `app_project_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_project_files`
--
ALTER TABLE `app_project_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_project_milestones`
--
ALTER TABLE `app_project_milestones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `app_proposals`
--
ALTER TABLE `app_proposals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `app_proposal_items`
--
ALTER TABLE `app_proposal_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `app_receipts`
--
ALTER TABLE `app_receipts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `app_recurring`
--
ALTER TABLE `app_recurring`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_recurring_expenses`
--
ALTER TABLE `app_recurring_expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_recurring_items`
--
ALTER TABLE `app_recurring_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_reminders`
--
ALTER TABLE `app_reminders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `app_status_labels`
--
ALTER TABLE `app_status_labels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `app_suppliers`
--
ALTER TABLE `app_suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `app_supplier_addresses`
--
ALTER TABLE `app_supplier_addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_supplier_comments`
--
ALTER TABLE `app_supplier_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_supplier_files`
--
ALTER TABLE `app_supplier_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_taxrates`
--
ALTER TABLE `app_taxrates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `app_tickets`
--
ALTER TABLE `app_tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_ticket_comments`
--
ALTER TABLE `app_ticket_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_ticket_replies`
--
ALTER TABLE `app_ticket_replies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_ticket_reply_files`
--
ALTER TABLE `app_ticket_reply_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `core_emails`
--
ALTER TABLE `core_emails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `core_email_templates`
--
ALTER TABLE `core_email_templates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `core_languages`
--
ALTER TABLE `core_languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `core_roles`
--
ALTER TABLE `core_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `core_staff`
--
ALTER TABLE `core_staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `core_staff_activity_log`
--
ALTER TABLE `core_staff_activity_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `core_translations`
--
ALTER TABLE `core_translations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `core_users`
--
ALTER TABLE `core_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `core_user_activity_log`
--
ALTER TABLE `core_user_activity_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

  CREATE TABLE `app_project_assets` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `asset_id` int(11) NOT NULL,
  `notes` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `app_project_assets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `asset_id` (`asset_id`);

ALTER TABLE `app_project_assets` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `app_events` ADD `client_id` INT(11) NOT NULL DEFAULT '0' AFTER `id`; 
ALTER TABLE `app_events` ADD INDEX(`client_id`);
ALTER TABLE `app_events` ADD `reminder_id` INT(11) NOT NULL DEFAULT '0' AFTER `client_id`; 
ALTER TABLE `app_events` ADD INDEX(`reminder_id`);
ALTER TABLE `app_reminders` ADD `notify_client` INT(1) NOT NULL DEFAULT '0' AFTER `client_id`;

INSERT INTO `core_email_templates` (`id`, `name`, `subject`, `body`, `info`, `created_at`, `updated_at`) VALUES (NULL, 'Client | Reminder alert', 'Reminder: {reminder}', '<p>Hi {name}</p>\r\n<p> </p>\r\n<p>The following reminder has been triggered:</p>\r\n<p><strong>{reminder}</strong></p>', '', '2022-11-09 15:48:07.000000', '2022-11-09 15:48:07.000000');
UPDATE `core_settings` SET `value` = '2' WHERE `core_settings`.`name` = 'db_level'; 


COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
