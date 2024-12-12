-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 17, 2024 at 02:11 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `manzil_v2`
--

-- --------------------------------------------------------

--
-- Table structure for table `company_info`
--

CREATE TABLE `company_info` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `logo` text NOT NULL,
  `subscription_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `company_info`
--

INSERT INTO `company_info` (`id`, `name`, `logo`, `subscription_id`) VALUES
(1, 'Yamalshsam Restaurant and Halls (Benadir branch)', '', 57);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_addr_country`
--

CREATE TABLE `tbl_addr_country` (
  `id` int(11) NOT NULL,
  `country_id` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `country_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `country_status` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Active',
  `country_timestamp` varchar(15) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_addr_country`
--

INSERT INTO `tbl_addr_country` (`id`, `country_id`, `country_name`, `country_status`, `country_timestamp`) VALUES
(1, 'country_id_01', 'Somalia', 'Active', ''),
(2, 'country_id_02', 'ugand', 'Active', '1664797085');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_addr_districts`
--

CREATE TABLE `tbl_addr_districts` (
  `id` int(11) NOT NULL,
  `district_id` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `region_id` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `district_name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `district_status` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Active',
  `district_timestamp` varchar(15) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_addr_districts`
--

INSERT INTO `tbl_addr_districts` (`id`, `district_id`, `region_id`, `district_name`, `district_status`, `district_timestamp`) VALUES
(1, 'district_id_01', 'region_id_01', 'Hodan', 'Active', ''),
(1, 'district_id_01', 'region_id_01', 'Hodan', 'Active', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_addr_regions`
--

CREATE TABLE `tbl_addr_regions` (
  `id` int(11) NOT NULL,
  `region_id` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `country_id` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `region_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `region_status` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Active',
  `region_timestamp` varchar(15) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_addr_regions`
--

INSERT INTO `tbl_addr_regions` (`id`, `region_id`, `country_id`, `region_name`, `region_status`, `region_timestamp`) VALUES
(1, 'region_id_01', 'country_id_01', 'Konfur Galbeed', 'Active', ''),
(2, 'region_id_02', 'country_id_01', 'Hirshabelle', 'Active', '1664801634'),
(3, 'region_id_0', 'country_id_01', 'Jubaland', 'Active', '1664801766'),
(4, 'region_id_0', 'country_id_01', 'Putlan', 'Active', '1664802418'),
(5, 'id_0', 'country_id_01', 'Putlan', 'Active', '1664802552'),
(6, 'region_id_06', 'country_id_01', 'Putlan', 'Active', '1664802717');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_advanced_payment`
--

CREATE TABLE `tbl_advanced_payment` (
  `adv_pay_id` int(11) NOT NULL,
  `ten_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `amount_bal` decimal(10,2) NOT NULL,
  `account_id` varchar(50) NOT NULL,
  `adv_pay_date` date NOT NULL,
  `profile_no` varchar(25) NOT NULL,
  `site_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_apartments`
--

CREATE TABLE `tbl_apartments` (
  `ap_id` int(11) NOT NULL,
  `ap_no` varchar(50) NOT NULL,
  `profile_no` varchar(25) DEFAULT NULL,
  `floor_id` int(11) NOT NULL,
  `ap_type_id` int(11) NOT NULL,
  `price` decimal(65,2) NOT NULL,
  `bedrooms` tinyint(4) NOT NULL,
  `pathrooms` tinyint(4) NOT NULL,
  `kitchen` tinyint(4) DEFAULT NULL,
  `ap_des` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ap_status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_apartments`
--

INSERT INTO `tbl_apartments` (`ap_id`, `ap_no`, `profile_no`, `floor_id`, `ap_type_id`, `price`, `bedrooms`, `pathrooms`, `kitchen`, `ap_des`, `created_at`, `ap_status`) VALUES
(1, '101', NULL, 1, 3, '700.00', 1, 1, 1, 'ffsfs', '2024-09-17 12:01:14', 'Active'),
(2, '102', NULL, 1, 3, '700.00', 1, 1, 1, 'gddsfs', '2024-09-17 12:01:32', 'Active'),
(3, '103', NULL, 1, 3, '700.00', 1, 1, 1, 'gddsfs', '2024-09-17 12:01:47', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_apartment_types`
--

CREATE TABLE `tbl_apartment_types` (
  `ap_type_id` int(11) NOT NULL,
  `ap_type_name` varchar(100) NOT NULL,
  `des` varchar(255) NOT NULL,
  `profile_no` varchar(25) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ap_type_status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_apartment_types`
--

INSERT INTO `tbl_apartment_types` (`ap_type_id`, `ap_type_name`, `des`, `profile_no`, `created_at`, `ap_type_status`) VALUES
(1, 'VIP', '', 'f0fc2942', '2023-03-26 08:43:29', 'Active'),
(2, 'studio', '1+1', '98e8bc3c', '2023-03-26 18:54:19', 'Active'),
(3, '3+1', '', '19186974', '2023-03-27 08:33:34', 'Active'),
(4, '2+1', '', '19186974', '2023-03-27 08:33:44', 'Active'),
(5, '1+1', ' ', '19186974', '2023-03-27 08:34:00', 'Active'),
(6, 'A4', '1+1', '19186974', '2023-03-27 08:33:22', 'Deleted'),
(7, 'Studi', 'all in one', 'f0fc2942', '2023-03-28 09:32:02', 'Active'),
(8, 'vip-room', 'vip', '7d9cbaa4', '2023-04-30 10:32:57', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_branches`
--

CREATE TABLE `tbl_branches` (
  `branch_id` int(11) NOT NULL,
  `br_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `br_address` text COLLATE utf8_unicode_ci NOT NULL,
  `br_status` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Active',
  `profile_no` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `br_tag` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'sub',
  `br_timestamp` varchar(15) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_branches`
--

INSERT INTO `tbl_branches` (`branch_id`, `br_name`, `br_address`, `br_status`, `profile_no`, `br_tag`, `br_timestamp`) VALUES
(1, 'Barkaale Apartments (HQ)', 'degmada hodan', 'Active', '13b11745', 'main', '1679312063'),
(2, 'Yamalshsam Restaurant and Halls (Taleh Branch)', 'Taleh, Degmad Hodan', 'Active', '', 'sub', '1724570289'),
(3, 'Yamalshsam Restaurants (Jubba Branch)', 'Jubba, Degamada shibis', 'Active', '', 'sub', '1724915269');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_clients`
--

CREATE TABLE `tbl_clients` (
  `id` int(11) NOT NULL,
  `client_id` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `ut_id` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `profile_no` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `cl_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `cl_tell` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `cl_email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `cl_img` text COLLATE utf8_unicode_ci NOT NULL,
  `cl_status` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Active',
  `login_key` varchar(10) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_clients`
--

INSERT INTO `tbl_clients` (`id`, `client_id`, `ut_id`, `profile_no`, `cl_name`, `cl_tell`, `cl_email`, `cl_img`, `cl_status`, `login_key`) VALUES
(1, 'client_id_01', 'ut_id_03', 'e282d6a5', 'Client Salah', '9842', '5541851', '1661762559-RAED-pngtree-call-center-customer-support-service-avatar-png-image_5232853.png', 'Active', 'b189db7e'),
(2, 'client_id_02', 'ut_id_03', '20224110', 'sadfasdf', 'asdfasdfasd', 'fasdfasdfa', '1663067930-RAED-ibsbank.png', 'Active', '5d56dc0d'),
(3, 'client_id_03', 'ut_id_03', '1a92520f', 'asdfasdfasdf', 'asdfasdfasdf', 'asdfasdfsdfghsfghdfghdfghdfhghjkghjk', '1663069290-RAED-ibsbank.png', 'Active', '4b33ac55'),
(4, 'client_id_04', 'ut_id_03', '2c621c18', 'fgdfdfgsdfgsd', 'sdfgsdvx', 'sdfgsdfg', '1663142447-RAED-merchant.png', 'Active', '02e93ccd'),
(5, 'client_id_05', 'ut_id_03', 'd45751f1', 'asdgasdadva', 'fvasdvafv', 'afvafva', '1663142524-RAED-evc plus.png', 'Active', 'cc78a0c6'),
(6, 'client_id_06', 'ut_id_03', 'af37fb26', 'fasdfsadf', 'sdfasdfasd', 'fasdfa', '1663142749-RAED-edahab.png', 'Active', 'e717af93'),
(7, 'client_id_07', 'ut_id_03', '136f048f', 'sadfasdf', 'asdfsadfas', 'dfasdfasd', '1663142815-RAED-ibsbank.png', 'Active', '988a50c0'),
(8, 'client_id_08', 'ut_id_03', '1e8a5c53', 'Test client', 'asdfasd', 'sdfasdf', '1663402142-RAED-anders-jilden-AkUR27wtaxs-unsplash.jpg', 'Active', '480c6c60'),
(9, 'client_id_09', 'ut_id_03', 'e8f44b6a', 'aaaaaaaaaaaaaaaaa', 'aaaaaaaaaa', 'aaaaaaa', '1663404226-RAED-lucas-ludwig-Mv1_rinnL7s-unsplash.jpg', 'Active', 'a71fbfc0'),
(10, 'client_id_010', 'ut_id_03', '6c5504c8', 'Omar musa ', '2526808080', 'omar@muna.com', '1679139090-RAED-103160_man_512x512.png', 'Active', '23d17b3e'),
(11, 'client_id_011', 'ut_id_03', 'e5b94da7', 'sharmarke', '2526808080', 'sharma@sh.com', '1679293156-RAED-103160_man_512x512.png', 'Active', 'c45c715b'),
(12, 'client_id_012', 'ut_id_03', 'f0fc2942', 'Abdinasir', '617335344', 'mogadishu@mall.com', '1679294999-RAED-WhatsApp Image 2023-03-20 at 9.48.31 AM.jpeg', 'Active', '6b924ac7'),
(13, 'client_id_013', 'ut_id_03', '7d9cbaa4', 'Abdirzaak Raage', '0618336667', 'cafiif666@gmail.com', '1679297219-RAED-copy-code-snippet-for-pushing-existing-repository-1024x679.png', 'Active', 'bdab80c0'),
(14, 'client_id_014', 'ut_id_03', '98e8bc3c', 'Test person', '123456', 'test@gmail.com', '1679299292-RAED-copy-code-snippet-for-pushing-existing-repository-1024x679.png', 'Active', '027fa473'),
(15, 'client_id_015', 'ut_id_03', '19186974', 'barakaale', '123456', 'barakale@raed.com', '1679555127-RAED-WhatsApp Image 2023-03-22 at 3.50.08 PM.jpeg', 'Active', '0184556f'),
(16, 'client_id_016', 'ut_id_03', '3ec30556', 'Hassan Osobow', '0619057878', 'x.osobow@gmail.com', '1685431946-RAED-hassansafe.jpeg', 'Active', 'fb345a4d');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_client_profile`
--

CREATE TABLE `tbl_client_profile` (
  `id` int(11) NOT NULL,
  `cp_id` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `profile_no` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `cp_full_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cp_short_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `cp_tell` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `cp_email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `cp_address` text COLLATE utf8_unicode_ci NOT NULL,
  `cp_logo_icon` text COLLATE utf8_unicode_ci NOT NULL,
  `cp_logo_text` text COLLATE utf8_unicode_ci NOT NULL,
  `cp_logo_full` text COLLATE utf8_unicode_ci NOT NULL,
  `cp_status` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Pending',
  `cp_tag` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `cp_timestamp` varchar(15) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_client_profile`
--

INSERT INTO `tbl_client_profile` (`id`, `cp_id`, `profile_no`, `cp_full_name`, `cp_short_name`, `cp_tell`, `cp_email`, `cp_address`, `cp_logo_icon`, `cp_logo_text`, `cp_logo_full`, `cp_status`, `cp_tag`, `cp_timestamp`) VALUES
(1, 'cp_id_01', 'e282d6a5', 'marwaas ecommerce', 'marwaas ', '9827982789', 'asdf', 'sadfsadf', '1661762559-RAED-pngtree-call-center-customer-support-service-avatar-png-image_5232849.png', '1661762559-RAED-pngtree-call-center-customer-support-service-avatar-png-image_5232853.png', '1661762559-RAED-pngtree-call-center-customer-support-service-avatar-png-image_5232854.png', 'Active', '', '1661762559'),
(2, 'cp_id_02', '20224110', 'asdfasdf', 'asdfasdf', 'asdfasdf', 'asdfasdfasdf', 'asdfasdfasdf', '1663067930-RAED-edahab.png', '1663067930-RAED-ssmbank.png', '1663067930-RAED-evc plus.png', 'Pending', '', '1663067930'),
(3, 'cp_id_03', '1a92520f', 'asdfasdfas', 'dfasdfasdfa', 'sdfasdfasdf', 'asdfasdf', 'asdfasdfasdfasdfa', '1663069290-RAED-edahab.png', '1663069290-RAED-ssmbank.png', '1663069290-RAED-evc plus.png', 'Pending', '', '1663069290'),
(4, 'cp_id_04', '2c621c18', 'sadfasdf', 'asdfasdfasdfasdfas', 'dfasdfdfdfsfdfsdfsd', 'fsdfsdfsdf', 'sdfsdfsdfs', '1663142447-RAED-edahab.png', '1663142447-RAED-ibsbank.png', '1663142447-RAED-evc plus.png', 'Pending', '', '1663142447'),
(5, 'cp_id_05', 'd45751f1', 'dsfgsdfg', 'dsfgsdfg', 'fgsdfgsd', 'fgsdfgsdfgsdfg', 'sdfgsdfgsdfg', '1663142524-RAED-ssmbank.png', '1663142524-RAED-edahab.png', '1663142524-RAED-merchant.png', 'Pending', '', '1663142524'),
(6, 'cp_id_06', 'af37fb26', 'sadfasdf', 'asdfasdf', 'asdfa', 'sdfasdf', 'asdfsadf', '1663142749-RAED-ssmbank.png', '1663142749-RAED-ibsbank.png', '1663142749-RAED-edahab.png', 'Pending', '', '1663142749'),
(7, 'cp_id_07', '136f048f', 'sadfasdf', 'sdfasdf', 'sadfsadf', 'asdfasdf', 'sadfsadfsadfsd', '1663142815-RAED-evc plus.png', '1663142815-RAED-ssmbank.png', '1663142815-RAED-ibsbank.png', 'Pending', '', '1663142815'),
(8, 'cp_id_08', '1e8a5c53', 'Test for fin acc', 'test', 'sadfasd', 'fasdfasdf', 'asdfasdfasd', '1663402142-RAED-lucas-ludwig-Mv1_rinnL7s-unsplash.jpg', '1663402142-RAED-fabian-quintero-UWQP2mh5YJI-unsplash.jpg', '1663402142-RAED-anders-jilden-AkUR27wtaxs-unsplash.jpg', 'Pending', '', '1663402142'),
(9, 'cp_id_09', 'e8f44b6a', 'adfadsfasdfasdfasd', 'fasdfasdfas', 'dfasdfasdf', 'asdfasdfasdf', 'asdfasdfasd', '1663404226-RAED-anders-jilden-AkUR27wtaxs-unsplash.jpg', '1663404226-RAED-lucas-ludwig-Mv1_rinnL7s-unsplash.jpg', '1663404226-RAED-fabian-quintero-UWQP2mh5YJI-unsplash.jpg', 'Pending', '', '1663404226'),
(10, 'cp_id_010', '6c5504c8', 'Muna Apartments', 'Muna', '682033324', 'muna@apart.com', 'degmada hodan', '1679139090-RAED-apart.png', '1679139090-RAED-apart.png', '1679139090-RAED-apart.png', 'Active', '', '1679139090'),
(11, 'cp_id_011', 'e5b94da7', 'Sharma apartments', 'sharama', '68203332', 'sharma@sharma.com', 'degamad hodan', '1679293156-RAED-147133.png', '1679293156-RAED-', '1679293156-RAED-147133.png', 'Active', '', '1679293156'),
(12, 'cp_id_012', 'f0fc2942', 'Mugadishu mall', 'mogadishu mall', '617335344', 'mogadishu@mall.com', 'HamarWayne', '1679294999-RAED-WhatsApp Image 2023-03-20 at 9.44.48 AM.jpeg', '1679294999-RAED-', '1679294999-RAED-WhatsApp Image 2023-03-20 at 9.44.48 AM.jpeg', 'Active', '', '1679294999'),
(13, 'cp_id_013', '7d9cbaa4', 'Raage Apartmemts', 'Raage ', '618336667', 'cafiif666@gmail.com', 'Degamad hodan', '1679297219-RAED-copy-code-snippet-for-pushing-existing-repository-1024x679.png', '1679297219-RAED-', '1679297219-RAED-copy-code-snippet-for-pushing-existing-repository-1024x679.png', 'Active', '', '1679297219'),
(14, 'cp_id_014', '98e8bc3c', 'Test Apartment', 'Test', '123456', 'test@gmail.com', 'degmada hodan', '1679299292-RAED-copy-code-snippet-for-pushing-existing-repository-1024x679.png', '1679299292-RAED-', '1679299292-RAED-copy-code-snippet-for-pushing-existing-repository-1024x679.png', 'Active', '', '1679299292'),
(15, 'cp_id_015', '19186974', 'Barakaale Apartments', 'Barakale', '123456', 'barakale@raed.com', 'degmada hodan', '1679555127-RAED-WhatsApp Image 2023-03-22 at 3.50.08 PM.jpeg', '1679555127-RAED-', '1679555127-RAED-WhatsApp Image 2023-03-22 at 3.50.08 PM.jpeg', 'Active', '', '1679555127'),
(19, 'cp_id_019', '3ec30556', 'Safe Accounting and Consultancy', 'Safe Accounting', '0619057878', 'info@safeaccounting.com', 'Bakaro market, howlwadag, mogadishu', '1685431946-RAED-safeacc.png', '1685431946-RAED-', '1685431946-RAED-safeacc.png', 'Active', '', '1685431946');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cl_accounts`
--

CREATE TABLE `tbl_cl_accounts` (
  `account_id` int(10) NOT NULL,
  `profile_no` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `acc_grp_id` int(11) NOT NULL,
  `acc_type_id` int(11) NOT NULL,
  `acc_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `acc_name_ar` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `acc_balance` decimal(12,2) NOT NULL,
  `acc_tag` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `acc_des` text COLLATE utf8_unicode_ci NOT NULL,
  `acc_status` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `acc_set` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Custom'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_cl_accounts`
--

INSERT INTO `tbl_cl_accounts` (`account_id`, `profile_no`, `acc_grp_id`, `acc_type_id`, `acc_name`, `acc_name_ar`, `acc_balance`, `acc_tag`, `acc_des`, `acc_status`, `acc_set`) VALUES
(1, '13b11745', 4, 2, 'Sales Income', NULL, '6537.70', 'INC', 'Income', 'Active', 'fixed'),
(2, '13b11745', 2, 3, 'Deposit Payable', NULL, '750.00', 'DP', 'Deposit Payable', 'Active', 'custom'),
(3, '13b11745', 1, 1, 'Cash', NULL, '8900.00', 'CB', 'Cash', 'Active', 'custom'),
(4, '13b11745', 1, 5, 'Account Receivable', NULL, '0.00', 'AR', 'Account Receivable', 'Active', 'custom'),
(5, '13b11745', 1, 1, '39404302', NULL, '0.00', 'SHRM', 'Sharmarke', 'Deleted', 'Custom'),
(6, '13b11745', 5, 4, 'Sales Discount', NULL, '0.00', 'SED', 'Sales Discount', 'Active', 'fixed'),
(7, '13b11745', 2, 3, 'advanced paymen payable', NULL, '0.00', 'APP', 'Advanced payment payable', 'Active', 'custom'),
(8, '13b11745', 1, 1, 'Premier wallet', NULL, '0.00', 'account_id_08', 'Premier wallet', 'Active', 'Custom'),
(9, '13b11745', 1, 1, 'Dahabshiil(308013493801)', NULL, '0.00', 'account_id_09', 'dahabshiil account', 'Active', 'Custom'),
(10, '13b11745', 3, 7, 'Capital Acc', NULL, '5000.00', 'account_id_010', 'Capital Account', 'Active', 'Custom'),
(11, '13b11745', 5, 8, 'Electricity', NULL, '500.00', 'account_id_011', 'sharmarke', 'Active', 'Custom'),
(12, '13b11745', 2, 3, 'Account payable', NULL, '0.00', 'AP', 'Account payable', 'Active', 'custom'),
(13, '13b11745', 5, 6, 'Payroll', NULL, '6350.00', 'Payroll', 'Payroll account', 'Active', 'fixed'),
(14, '13b11745', 1, 1, 'Salaam Bank (31125512)', '', '18650.00', 'account_id_014', 'Salam Somali Bank', 'Active', 'Custom'),
(15, '13b11745', 1, 1, 'Murchant 705610', NULL, '0.00', 'account_id_015', '', 'Active', 'Custom'),
(17, '', 1, 1, 'Marchent 705608', NULL, '0.00', 'account_id_017', '', 'Active', 'Custom'),
(18, '', 1, 1, 'Marchent Edahab 093411', NULL, '0.00', 'account_id_018', '', 'Active', 'Custom'),
(20, '', 5, 8, 'Rent', NULL, '0.00', 'account_id_020', 'Rent', 'Active', 'Custom'),
(21, '', 5, 8, 'Internet', NULL, '130.00', 'account_id_021', 'Internet', 'Active', 'Custom'),
(22, '', 5, 8, 'Water supply', NULL, '100.00', 'account_id_022', 'Water supply', 'Active', 'Custom'),
(23, '', 5, 8, 'Gaas', NULL, '0.00', 'account_id_023', 'Gaas', 'Active', 'Custom'),
(24, '', 5, 8, 'Shidaal', NULL, '0.00', 'account_id_024', 'Shidaal', 'Active', 'Custom'),
(25, '', 5, 8, 'Nadaafad', NULL, '0.00', 'account_id_025', 'Nadaafad', 'Active', 'Custom'),
(26, '', 5, 8, 'Dhisme', NULL, '0.00', 'account_id_026', 'Dhisme', 'Active', 'Custom'),
(27, '', 5, 8, 'Office supply', NULL, '0.00', 'account_id_027', 'Office supply', 'Active', 'Custom'),
(28, '', 5, 8, 'Maintenances', NULL, '0.00', 'account_id_028', 'Maintenances', 'Active', 'Custom'),
(29, '', 5, 8, 'Logistics', NULL, '0.00', 'account_id_029', 'Logistics', 'Active', 'Custom'),
(30, '', 5, 8, 'Advertising ', NULL, '0.00', 'account_id_030', 'Advertising', 'Active', 'Custom'),
(31, '', 5, 8, 'Waiter Commissions', NULL, '0.00', 'account_id_031', 'Waiter Commissions', 'Active', 'Custom'),
(32, '', 5, 0, 'Other expenses', NULL, '0.00', 'account_id_032', 'Other expenses', 'Active', 'Custom'),
(33, '', 5, 8, 'Biti Cash(Maqaayada)', NULL, '0.00', 'account_id_033', 'Biti Cash', 'Active', 'Custom'),
(34, '', 3, 7, 'Retained Earning', NULL, '1355.00', 'account_id_034', 'Retained Earning', 'Active', 'Custom'),
(35, '', 6, 10, 'Cash Drawing ', NULL, '0.00', 'account_id_035', 'Cash Drawing ', 'Active', 'Custom'),
(36, '13b11745', 1, 11, 'Inventory 2', '', '295.00', 'IS', 'Inventory', 'Active', 'fixed'),
(37, '', 1, 11, 'Inventory 2', 'Inventory 2', '0.00', 'INV', 'Inventory 2', 'Deleted', 'Custom'),
(41, '', 1, 5, 'customer ali ahmed', 'customer ali ahmed', '1150.00', '3', 'customer ali ahmed', 'Active', 'Customer'),
(42, '', 2, 3, 'hassan supplier', 'hassan supplier', '350.00', '1', 'hassan supplier', 'Active', 'Supplier'),
(43, '', 5, 6, 'Food and Beverage Expense', 'Food and Beverage Expense', '110.00', 'FABE', 'Food and Beverage Expense', 'Active', 'fixed'),
(44, '', 1, 5, 'Maxamed Farah jamac', 'Maxamed Farah jamac', '0.00', '4', 'Maxamed Farah jamac', 'Active', 'Customer'),
(52, '', 2, 3, 'Beco', 'Beco', '0.00', '2', 'Beco', 'Active', 'Supplier'),
(53, '', 1, 5, 'Fartuun maxamed', 'Fartuun maxamed', '0.00', '5', 'Fartuun maxamed', 'Active', 'Customer'),
(54, '', 1, 5, 'Warsan cabdulle', 'Warsan cabdulle', '0.00', '6', 'Warsan cabdulle', 'Active', 'Customer'),
(55, '', 3, 7, 'Abdi Ahmed', 'Abdi Ahmed', '4182.30', 'Abdi Ahmed', 'Abdi Ahmed', 'Active', 'Custom'),
(56, '', 2, 3, 'supplier first ', 'supplier first ', '5000.00', '6', 'supplier first ', 'Active', 'Supplier'),
(57, '', 1, 5, 'fsfs', 'fsfs', '0.00', '28', 'fsfs', 'Active', 'Customer'),
(58, '', 2, 3, 'Alnaciim Water supply', 'Alnaciim Water supply', '0.00', '7', 'Alnaciim Water supply', 'Active', 'Supplier'),
(59, '', 2, 3, 'Hass Gas supply', 'Hass Gas supply', '0.00', '8', 'Hass Gas supply', 'Active', 'Supplier'),
(60, '', 2, 3, 'Bluecom Internet', 'Bluecom Internet', '0.00', '9', 'Bluecom Internet', 'Active', 'Supplier'),
(61, '', 1, 5, 'Maxamed Farah Ciise', 'Maxamed Farah Ciise', '0.00', '1', 'Maxamed Farah Ciise', 'Active', 'Customer'),
(62, '', 1, 5, 'Fartuun maxamed', 'Fartuun maxamed', '0.00', '2', 'Fartuun maxamed', 'Active', 'Customer');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cl_account_groups`
--

CREATE TABLE `tbl_cl_account_groups` (
  `acc_grp_id` int(10) NOT NULL,
  `acc_grp_name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `acc_grp_nature` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `acc_grp_status` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Active',
  `acc_grp_timestamp` varchar(15) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_cl_account_groups`
--

INSERT INTO `tbl_cl_account_groups` (`acc_grp_id`, `acc_grp_name`, `acc_grp_nature`, `acc_grp_status`, `acc_grp_timestamp`) VALUES
(1, 'Assets', 'dr', 'Active', ''),
(2, 'Liabilities', 'cr', 'Active', ''),
(3, 'Equity', 'cr', 'Active', ''),
(4, 'Revenue', 'cr', 'Active', ''),
(5, 'Expenses', 'dr', 'Active', ''),
(6, 'Drawing/Dividend', 'dr', 'Active', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cl_account_types`
--

CREATE TABLE `tbl_cl_account_types` (
  `acc_type_id` int(10) NOT NULL,
  `acc_grp_id` int(10) NOT NULL,
  `acc_type_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `acc_type_tag` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `acc_type_status` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `acc_type_timestamp` varchar(15) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_cl_account_types`
--

INSERT INTO `tbl_cl_account_types` (`acc_type_id`, `acc_grp_id`, `acc_type_name`, `acc_type_tag`, `acc_type_status`, `acc_type_timestamp`) VALUES
(1, 1, 'Cash & Bank', 'CB', 'Active', ''),
(2, 4, 'Revenue', 'SR', 'Active', ''),
(3, 2, 'Account Payable', 'AP', 'Active', ''),
(4, 5, 'Allowed Discount', 'AD', 'Active', ''),
(5, 1, 'Account Receivable', 'AR', 'Active', ''),
(6, 5, 'Operation Expenses', 'EXP', 'Active', ''),
(7, 3, 'Capital', 'CAP', 'Active', ''),
(8, 5, 'Utiltiy', 'UTL', 'Active', ''),
(9, 1, 'Fixed Assets', 'FA', 'Active', ''),
(10, 6, 'Drawing ', 'Drawing ', 'Active', ''),
(11, 1, 'Inventory', 'INV', 'Active', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cl_financial_period`
--

CREATE TABLE `tbl_cl_financial_period` (
  `fp_id` int(10) NOT NULL,
  `profile_no` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `branch_id` int(11) NOT NULL,
  `fp_start_date` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `fp_end_date` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `fp_des` text COLLATE utf8_unicode_ci NOT NULL,
  `fp_status` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `fp_timestamp` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_cl_financial_period`
--

INSERT INTO `tbl_cl_financial_period` (`fp_id`, `profile_no`, `branch_id`, `fp_start_date`, `fp_end_date`, `fp_des`, `fp_status`, `fp_timestamp`) VALUES
(1, '13b11745', 0, '2023-02-20', '2023-06-17', 'test', 'InActive', '1679312063'),
(2, NULL, 1, '2023-06-17', '2024-06-17', 'New Financial Period', 'Active', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cl_transections`
--

CREATE TABLE `tbl_cl_transections` (
  `trx_id` int(10) NOT NULL,
  `profile_no` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `branch_id` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `trx_source` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `trx_timestamp` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `trx_date` date DEFAULT NULL,
  `trx_amount` decimal(12,2) NOT NULL,
  `fp_id` int(10) NOT NULL,
  `trx_des` text COLLATE utf8_unicode_ci NOT NULL,
  `trx_status` varchar(25) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_cl_transections`
--

INSERT INTO `tbl_cl_transections` (`trx_id`, `profile_no`, `branch_id`, `trx_source`, `trx_timestamp`, `trx_date`, `trx_amount`, `fp_id`, `trx_des`, `trx_status`) VALUES
(1, '', '1', 'Open Capital', '1725113331', '2024-08-31', '5000.00', 2, 'Open Capital', 'Posted'),
(4, '', '1', 'PURCHASES', '1725113737', '2024-08-31', '350.00', 2, 'Inventory Purchases', 'Posted'),
(5, NULL, '1', 'inventory usage', '', '2024-08-31', '25.00', 2, 'inventory usage on: 2024/08/31', 'Posted'),
(6, NULL, '1', 'inventory usage', '', '2024-08-31', '30.00', 2, 'inventory usage on: 2024/08/31', 'Posted'),
(7, NULL, '1', 'POS Sales', '', '2024-08-31', '75.00', 2, '', 'Posted'),
(8, NULL, '1', 'Booking Charges', '', '2024-08-31', '1820.00', 2, '', 'Posted'),
(9, NULL, '1', 'Receipt', '', '2024-08-31', '1000.00', 2, '', 'Posted'),
(10, NULL, '1', 'POS Sales', '', '2024-08-31', '10.00', 2, '', 'Posted'),
(13, NULL, '1', 'Receipt', '', '2024-08-31', '500.00', 2, '', 'Posted'),
(14, NULL, '1', 'Invoice', '', '2024-08-31', '250.00', 2, 'koranto ladiiwan galyay', 'Posted'),
(15, NULL, '1', 'Payment', '', '2024-08-31', '250.00', 2, '', 'Posted'),
(16, NULL, '1', 'Receipt', '', '2024-09-01', '320.00', 2, '', 'Posted'),
(17, NULL, '1', 'POS Sales', '', '2024-09-01', '5.00', 2, '', 'Posted'),
(18, '', '1', 'Salary', '1725186873', '2024-09-01', '250.00', 2, '', 'Posted'),
(19, '', '1', 'Closing August', '1725267651', '2024-09-02', '1910.00', 2, 'Closing August', 'Posted'),
(20, NULL, '1', 'Booking Charges', '', '2024-09-02', '650.00', 2, '', 'Posted'),
(21, '', '1', 'Salary', '1725268502', '2024-09-02', '250.00', 2, '', 'Posted'),
(22, NULL, '1', 'Booking Charges', '', '2024-09-02', '500.00', 2, '', 'Posted'),
(23, '', '1', 'internet', '1725268607', '2024-09-02', '100.00', 2, 'internet', 'Posted'),
(24, '', '1', 'Cash Transfer', '1725268904', '2024-09-02', '6260.00', 2, 'Cash Transfer', 'Posted'),
(25, '', '1', 'Balance Transfer', '1725270706', '2024-09-02', '12520.00', 2, 'Balance Transfer', 'Posted'),
(26, '', '1', 'draw cash', '1725270898', '2024-09-02', '18780.00', 2, 'draw cash', 'Posted'),
(27, '', '1', 'draw cash', '1725271129', '2024-09-02', '18780.00', 2, 'draw cash', 'Posted'),
(28, '', '1', 'cash draw back', '1725271881', '2024-09-02', '18780.00', 2, 'cash draw back', 'Posted'),
(29, '', '1', 'cash draw', '1725272001', '2024-09-02', '18780.00', 2, 'cash draw', 'Posted'),
(30, '', '1', 'cash draw', '1725272098', '2024-09-02', '18780.00', 2, 'cash draw', 'Posted'),
(31, NULL, '1', 'Invoice', '', '2024-09-09', '5000.00', 2, 'internetka bisha 11aad', 'Posted'),
(32, NULL, '1', 'Invoice', '', '2024-09-09', '50.00', 2, '20 caag oo biyo ah', 'Posted'),
(33, NULL, '1', 'Invoice', '', '2024-09-09', '50.00', 2, '20 caag oo biyo ah', 'Posted'),
(34, NULL, '1', 'Payment', '', '2024-09-09', '100.00', 2, '', 'Posted'),
(35, NULL, '1', 'Invoice', '', '2024-09-09', '30.00', 2, 'biilka internet bisha 8aad', 'Posted'),
(36, NULL, '1', 'Payment', '', '2024-09-09', '30.00', 2, '', 'Posted'),
(37, NULL, '1', 'Bill', '', '2024-09-10', '750.00', 2, '', 'Posted'),
(39, NULL, '1', 'Utility Charges', '', '0000-00-00', '2.30', 2, '', 'Posted'),
(40, NULL, '1', 'Utility Charges', '', '0000-00-00', '135.30', 2, '', 'Posted'),
(41, NULL, '1', 'Receipt', '', '2024-09-15', '135.30', 2, '', 'Posted'),
(42, NULL, '1', 'Receipt', '', '2024-09-17', '2.30', 2, '', 'Posted'),
(43, NULL, '1', 'Receipt', '', '2024-09-10', '750.00', 2, '', 'Posted'),
(55, NULL, '1', 'Bill', '', '2024-09-17', '400.00', 2, '', 'Posted'),
(56, NULL, '1', 'Bill', '', '2024-09-17', '750.00', 2, '', 'Posted'),
(57, NULL, '1', 'Bill', '', '2024-09-17', '600.00', 2, '', 'Posted'),
(58, NULL, '1', 'Bill', '', '2024-09-17', '750.00', 2, '', 'Posted'),
(59, NULL, '1', 'Bill', '', '2024-09-17', '400.00', 2, '', 'Posted'),
(60, NULL, '1', 'Bill', '', '2024-09-01', '750.00', 2, '', 'Posted'),
(61, NULL, '1', 'Receipt', '', '2024-09-05', '750.00', 2, '', 'Posted'),
(63, NULL, '1', 'Deposit', '', '2024-09-17', '750.00', 2, '', 'Posted'),
(65, NULL, '1', 'Utility Charges', '', '0000-00-00', '4.10', 2, '', 'Posted'),
(66, NULL, '1', 'Receipt', '', '2024-09-17', '4.10', 2, '', 'Posted'),
(67, NULL, '1', 'Utility Charges', '', '0000-00-00', '26.00', 2, '', 'Posted'),
(69, NULL, '1', 'Receipt', '', '2024-09-17', '26.00', 2, '', 'Posted'),
(70, NULL, '1', 'PaymentVoucher', '', '2024-09-17', '600.00', 2, 'salary to ahmed cali ahmed', 'Posted'),
(71, NULL, '1', 'ReceiptVoucher', '', '2024-09-17', '4182.30', 2, 'dhigaal uu leehay Abdi Ahmed', 'Posted');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cl_trans_details`
--

CREATE TABLE `tbl_cl_trans_details` (
  `trx_det_id` int(11) NOT NULL,
  `trx_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `dr_amount` decimal(12,2) NOT NULL,
  `cr_amount` decimal(12,2) NOT NULL,
  `trx_det_des` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_cl_trans_details`
--

INSERT INTO `tbl_cl_trans_details` (`trx_det_id`, `trx_id`, `account_id`, `dr_amount`, `cr_amount`, `trx_det_des`) VALUES
(1, 1, 3, '5000.00', '0.00', ''),
(2, 1, 10, '0.00', '5000.00', ''),
(7, 4, 36, '350.00', '0.00', ''),
(8, 4, 42, '0.00', '350.00', ''),
(9, 5, 36, '0.00', '25.00', ''),
(10, 5, 43, '25.00', '0.00', ''),
(11, 6, 36, '0.00', '30.00', ''),
(12, 6, 43, '30.00', '0.00', ''),
(13, 7, 15, '75.00', '0.00', ''),
(14, 7, 1, '0.00', '75.00', ''),
(15, 8, 41, '1820.00', '0.00', ''),
(16, 8, 1, '0.00', '1820.00', ''),
(17, 9, 17, '1000.00', '0.00', ''),
(18, 9, 41, '0.00', '1000.00', ''),
(19, 10, 17, '10.00', '0.00', ''),
(20, 10, 1, '0.00', '10.00', ''),
(25, 13, 17, '500.00', '0.00', ''),
(26, 13, 41, '0.00', '500.00', ''),
(27, 14, 52, '0.00', '250.00', ''),
(28, 14, 11, '250.00', '0.00', ''),
(29, 15, 3, '0.00', '250.00', ''),
(30, 15, 52, '250.00', '0.00', ''),
(31, 16, 8, '320.00', '0.00', ''),
(32, 16, 41, '0.00', '320.00', ''),
(33, 17, 8, '5.00', '0.00', ''),
(34, 17, 1, '0.00', '5.00', ''),
(35, 18, 3, '0.00', '250.00', ''),
(36, 18, 13, '250.00', '0.00', ''),
(37, 19, 1, '1910.00', '0.00', ''),
(38, 19, 11, '0.00', '250.00', ''),
(39, 19, 13, '0.00', '250.00', ''),
(40, 19, 43, '0.00', '55.00', ''),
(41, 19, 34, '0.00', '1355.00', ''),
(42, 20, 41, '650.00', '0.00', ''),
(43, 20, 1, '0.00', '650.00', ''),
(44, 21, 3, '0.00', '250.00', ''),
(45, 21, 13, '250.00', '0.00', ''),
(46, 22, 41, '500.00', '0.00', ''),
(47, 22, 1, '0.00', '500.00', ''),
(48, 23, 21, '100.00', '0.00', ''),
(49, 23, 3, '0.00', '100.00', ''),
(50, 24, 14, '6260.00', '0.00', ''),
(51, 24, 8, '0.00', '325.00', ''),
(52, 24, 17, '0.00', '1510.00', ''),
(53, 24, 15, '0.00', '75.00', ''),
(54, 24, 3, '0.00', '4350.00', ''),
(55, 25, 14, '12520.00', '0.00', ''),
(56, 25, 8, '0.00', '650.00', ''),
(57, 25, 3, '0.00', '8700.00', ''),
(58, 25, 15, '0.00', '150.00', ''),
(59, 25, 17, '0.00', '3020.00', ''),
(60, 26, 55, '18780.00', '0.00', ''),
(61, 26, 14, '0.00', '18780.00', ''),
(62, 27, 35, '18780.00', '0.00', ''),
(63, 27, 55, '0.00', '18780.00', ''),
(64, 28, 14, '18780.00', '0.00', ''),
(65, 28, 35, '0.00', '18780.00', ''),
(66, 29, 35, '18780.00', '0.00', ''),
(67, 29, 14, '0.00', '18780.00', ''),
(68, 30, 14, '18780.00', '0.00', ''),
(69, 30, 35, '0.00', '18780.00', ''),
(70, 31, 56, '0.00', '5000.00', ''),
(71, 31, 13, '5000.00', '0.00', ''),
(72, 32, 58, '0.00', '50.00', ''),
(73, 32, 22, '50.00', '0.00', ''),
(74, 33, 58, '0.00', '50.00', ''),
(75, 33, 22, '50.00', '0.00', ''),
(76, 34, 14, '0.00', '100.00', ''),
(77, 34, 58, '100.00', '0.00', ''),
(78, 35, 60, '0.00', '30.00', ''),
(79, 35, 21, '30.00', '0.00', ''),
(80, 36, 14, '0.00', '30.00', ''),
(81, 36, 60, '30.00', '0.00', ''),
(82, 37, 41, '750.00', '0.00', ''),
(83, 37, 1, '0.00', '750.00', ''),
(85, 39, 41, '2.30', '0.00', ''),
(86, 39, 1, '0.00', '2.30', ''),
(87, 40, 54, '135.30', '0.00', ''),
(88, 40, 1, '0.00', '135.30', ''),
(89, 41, 3, '135.30', '0.00', ''),
(90, 41, 54, '0.00', '135.30', ''),
(91, 42, 3, '2.30', '0.00', ''),
(92, 42, 41, '0.00', '2.30', ''),
(93, 43, 3, '750.00', '0.00', ''),
(94, 43, 41, '0.00', '750.00', ''),
(117, 55, 3, '400.00', '0.00', ''),
(118, 55, 1, '0.00', '400.00', ''),
(119, 56, 3, '750.00', '0.00', ''),
(120, 56, 1, '0.00', '750.00', ''),
(121, 57, 3, '600.00', '0.00', ''),
(122, 57, 1, '0.00', '600.00', ''),
(123, 58, 3, '750.00', '0.00', ''),
(124, 58, 1, '0.00', '750.00', ''),
(125, 59, 3, '400.00', '0.00', ''),
(126, 59, 1, '0.00', '400.00', ''),
(127, 60, 61, '750.00', '0.00', ''),
(128, 60, 1, '0.00', '750.00', ''),
(129, 61, 3, '750.00', '0.00', ''),
(130, 61, 61, '0.00', '750.00', ''),
(133, 63, 3, '750.00', '0.00', ''),
(134, 63, 2, '0.00', '750.00', ''),
(137, 65, 61, '4.10', '0.00', ''),
(138, 65, 1, '0.00', '4.10', ''),
(139, 66, 3, '4.10', '0.00', ''),
(140, 66, 61, '0.00', '4.10', ''),
(141, 67, 62, '26.00', '0.00', ''),
(142, 67, 1, '0.00', '26.00', ''),
(145, 69, 3, '26.00', '0.00', ''),
(146, 69, 62, '0.00', '26.00', ''),
(147, 70, 3, '0.00', '600.00', ''),
(148, 70, 13, '600.00', '0.00', ''),
(149, 71, 3, '4182.30', '0.00', ''),
(150, 71, 55, '0.00', '4182.30', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customers`
--

CREATE TABLE `tbl_customers` (
  `customer_id` int(11) NOT NULL,
  `cust_name` varchar(100) NOT NULL,
  `cust_tell` varchar(50) NOT NULL,
  `cust_email` varchar(100) DEFAULT NULL,
  `sex` varchar(11) NOT NULL,
  `identification` varchar(50) NOT NULL,
  `ref_name` varchar(50) DEFAULT NULL,
  `ref_phone` varchar(20) DEFAULT NULL,
  `profile_no` varchar(25) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `cust_status` varchar(50) NOT NULL,
  `branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_customers`
--

INSERT INTO `tbl_customers` (`customer_id`, `cust_name`, `cust_tell`, `cust_email`, `sex`, `identification`, `ref_name`, `ref_phone`, `profile_no`, `created_at`, `cust_status`, `branch_id`) VALUES
(1, 'Maxamed Farah Ciise', '525632', 'newprerson@gmail.com', 'male', '4563256', 'new ref name1', '12356253', '', '2024-09-17 10:22:50', 'Active', 1),
(2, 'Fartuun maxamed', '525632', 'fartun@gmail.com', 'male', '788585', 'new ref name1', '', '', '2024-09-17 10:23:41', 'Active', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer_balances`
--

CREATE TABLE `tbl_customer_balances` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `created_date` date NOT NULL,
  `remarks` varchar(250) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `balance` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_deposit`
--

CREATE TABLE `tbl_deposit` (
  `dep_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `amount_bal` decimal(10,2) NOT NULL,
  `account_id` int(11) NOT NULL,
  `des` text DEFAULT NULL,
  `profile_no` varchar(30) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_deposit`
--

INSERT INTO `tbl_deposit` (`dep_id`, `customer_id`, `amount`, `amount_bal`, `account_id`, `des`, `profile_no`, `created_at`) VALUES
(1, 1, '750.00', '750.00', 3, '', '', '2024-09-17 11:17:05');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_employees`
--

CREATE TABLE `tbl_employees` (
  `emp_id` int(11) NOT NULL,
  `image` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `emp_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `emp_blood` varchar(55) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `emp_phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `emp_depart` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `job_id` int(11) NOT NULL,
  `emp_email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `user_name` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `emp_code` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `profile_no` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `branch_id` int(11) NOT NULL,
  `date_joining` date NOT NULL,
  `emp_status` varchar(25) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_employees`
--

INSERT INTO `tbl_employees` (`emp_id`, `image`, `emp_name`, `gender`, `emp_blood`, `dob`, `emp_phone`, `emp_depart`, `job_id`, `emp_email`, `user_name`, `emp_code`, `profile_no`, `branch_id`, `date_joining`, `emp_status`) VALUES
(1, '1698860735-RAED-WhatsApp Image 2023-11-01 at 8.40.23 PM.jpeg', 'Maxamed Cabdullahi Xaamud maxamed ', 'Male', 'O+', '2003-10-15', '0619785172', 'HR', 1, 'maxamedqanciye90@gmail.com', 'Na', '#00001', '', 3, '2023-08-14', 'Blocked'),
(2, '1698860606-RAED-1698766901240_2-removebg-preview~2.png', 'Cabdiraxman Maxamed Diiriye ', 'Male', 'O+', '1996-05-10', '0614385522', 'HR', 3, '', 'Na', '#00002', '', 3, '2021-05-10', 'Active'),
(3, '1698826700-RAED-', 'Maxamed Abuukar Salaad ', 'Male', NULL, '2004-10-15', '0610414326', 'HR', 5, '', 'Na', '#00003', '', 0, '2022-10-15', 'Active'),
(4, '1698827169-RAED-', 'Cadnaan Siciid Cabdi Axmed ', 'Male', NULL, '2004-10-15', '0613745283', 'HR', 6, '', 'Na', '#00004', '', 0, '2023-10-15', 'Active'),
(5, '1698827721-RAED-', 'Ibrahim Cusmaan Xasan ', 'Male', NULL, '1999-10-15', '0614916530', 'HR', 4, 'ibrahincismaan35@gmail.com', 'Na', '#00005', '', 0, '2019-10-15', 'Active'),
(6, '1698828112-RAED-', 'Axmed Cabdi Caziiz Guleed ', 'Male', NULL, '1990-10-15', '0619212729', 'HR', 7, '', 'Na', '#00006', '', 0, '2023-10-15', 'Active'),
(7, '1698860535-RAED-WhatsApp Image 2023-11-01 at 8.40.23 PM.jpeg', 'Maxamed Cabdullahi Xaamud ', 'Male', 'O+', '2003-10-15', '0619785172', 'HR', 1, 'maxamedqanciye90@gmail.com', 'Na', '#00001', '', 0, '2023-08-14', 'Active'),
(8, '', 'Ahmad Ali Nureyr', 'Male', NULL, '1992-01-01', '525663', '', 1, 'ahmed@ttek.com', '', NULL, '', 1, '2024-08-01', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_expenses`
--

CREATE TABLE `tbl_expenses` (
  `exp_id` int(11) NOT NULL,
  `exp_des` varchar(255) NOT NULL,
  `exp_cost` decimal(12,2) NOT NULL,
  `account_id` varchar(50) NOT NULL,
  `account_exp_id` varchar(50) NOT NULL,
  `type_id` int(11) NOT NULL,
  `exp_status` varchar(20) NOT NULL,
  `profile_no` varchar(30) NOT NULL,
  `trx_id` varchar(50) NOT NULL,
  `rec_ref` varchar(50) NOT NULL,
  `site_id` int(11) DEFAULT NULL,
  `exp_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_extras`
--

CREATE TABLE `tbl_extras` (
  `id` int(10) NOT NULL,
  `ext_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `subs_no` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `profile_no` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `ext_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `ext_no` int(5) NOT NULL,
  `ext_price` decimal(12,2) NOT NULL,
  `ext_total` decimal(12,2) NOT NULL,
  `ext_status` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `ext_timestamp` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_extras`
--

INSERT INTO `tbl_extras` (`id`, `ext_id`, `subs_no`, `profile_no`, `ext_type`, `ext_no`, `ext_price`, `ext_total`, `ext_status`, `ext_timestamp`) VALUES
(1, 'ext_id_01', '7822222001', 'e282d6a5', 'Users', 3, '5.00', '15.00', 'Pending', 1661948008),
(2, 'ext_id_02', '7822222001', 'e282d6a5', 'Branches', 12, '10.00', '120.00', 'Recovered', 1661948015),
(3, 'ext_id_03', '7822222001', 'e282d6a5', 'Branches', 45, '10.00', '450.00', 'Active', 1661948305),
(4, 'ext_id_04', '7822222001', 'e282d6a5', 'Users', 5, '5.00', '25.00', 'Pending', 1662362920),
(5, 'ext_id_05', '7822222001', 'e282d6a5', 'Users', 10000, '5.00', '50.00', 'Pending', 1662362947),
(6, 'ext_id_06', '7822222001', 'e282d6a5', 'Branches', 10000, '10.00', '100.00', 'Pending', 1662363065);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_extra_features`
--

CREATE TABLE `tbl_extra_features` (
  `id` int(11) NOT NULL,
  `ext_ft_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `subs_no` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `profile_no` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `feature_id` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `ext_ft_price` decimal(12,2) NOT NULL,
  `ext_ft_status` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Pending',
  `ext_ft_timestamp` varchar(15) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_extra_features`
--

INSERT INTO `tbl_extra_features` (`id`, `ext_ft_id`, `subs_no`, `profile_no`, `feature_id`, `ext_ft_price`, `ext_ft_status`, `ext_ft_timestamp`) VALUES
(1, 'ext_ft_id_01', '7822222001', 'e282d6a5', 'feature_id_06', '2.30', 'Pending', '1662276458'),
(6, 'ext_ft_id_06', '7822222001', 'e282d6a5', 'feature_id_05', '30.00', 'Pending', '1662364141'),
(7, 'ext_ft_id_07', '7822222011', '1e8a5c53', 'feature_id_06', '2.30', 'Pending', '1663416242');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_features`
--

CREATE TABLE `tbl_features` (
  `id` int(11) NOT NULL,
  `feature_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `package_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `feature_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `feature_price` decimal(12,2) NOT NULL,
  `feature_des` text COLLATE utf8_unicode_ci NOT NULL,
  `feature_status` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_features`
--

INSERT INTO `tbl_features` (`id`, `feature_id`, `package_id`, `feature_name`, `feature_price`, `feature_des`, `feature_status`) VALUES
(1, 'feature_id_01', 'package_id_01', 'Basic Core', '21.00', '', 'Active'),
(2, 'feature_id_02', 'package_id_01', 'Service 1', '6.00', '', 'Active'),
(3, 'feature_id_03', 'package_id_01', 'Service 2', '8.00', '', 'Active'),
(4, 'feature_id_04', 'package_id_01', 'Service 3', '9.50', '', 'Active'),
(5, 'feature_id_05', 'package_id_02', 'Premium Core', '30.00', '', 'Active'),
(6, 'feature_id_06', 'package_id_02', 'Service 1', '2.30', '', 'Active'),
(7, 'feature_id_07', 'package_id_02', 'Service 2', '3.50', '', 'Active'),
(8, 'feature_id_08', 'package_id_02', 'Service 3', '12.70', '', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_feature_tabs`
--

CREATE TABLE `tbl_feature_tabs` (
  `id` int(11) NOT NULL,
  `ft_tab_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `feature_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `tab_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `ft_tab_status` varchar(25) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_feature_tabs`
--

INSERT INTO `tbl_feature_tabs` (`id`, `ft_tab_id`, `feature_id`, `tab_id`, `ft_tab_status`) VALUES
(1, 'ft_tab_id_01', 'feature_id_01', 'tab_id_01', 'Active'),
(2, 'ft_tab_id_02', 'feature_id_02', 'tab_id_02', 'Block'),
(3, 'ft_tab_id_03', 'feature_id_02', 'tab_id_07', 'Block'),
(4, 'ft_tab_id_04', 'feature_id_03', 'tab_id_05', 'Active'),
(5, 'ft_tab_id_05', 'feature_id_03', 'tab_id_03', 'Active'),
(6, 'ft_tab_id_06', 'feature_id_03', 'tab_id_04', 'Active'),
(7, 'ft_tab_id_07', 'feature_id_03', 'tab_id_06', 'Active'),
(8, 'ft_tab_id_08', 'feature_id_05', 'tab_id_09', 'Active'),
(9, 'ft_tab_id_08', 'feature_id_06', 'tab_id_08', 'Active'),
(10, 'ft_tab_id_08', 'feature_id_06', 'tab_id_010', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_floors`
--

CREATE TABLE `tbl_floors` (
  `floor_id` int(11) NOT NULL,
  `profile_no` varchar(25) NOT NULL,
  `floor_name` varchar(100) NOT NULL,
  `site_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `floor_status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_floors`
--

INSERT INTO `tbl_floors` (`floor_id`, `profile_no`, `floor_name`, `site_id`, `created_at`, `floor_status`) VALUES
(1, '', 'Floor 1', 1, '2024-09-17 12:00:45', 'Active'),
(2, '', 'Floor 2', 1, '2024-09-17 12:00:45', 'Active'),
(3, '', 'Floor 3', 1, '2024-09-17 12:00:45', 'Active'),
(4, '', 'Floor 4', 1, '2024-09-17 12:00:45', 'Active'),
(5, '', 'Floor 5', 1, '2024-09-17 12:00:45', 'Active'),
(6, '', 'Floor 6', 1, '2024-09-17 12:00:45', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_jobs`
--

CREATE TABLE `tbl_jobs` (
  `job_id` int(11) NOT NULL,
  `job_name` varchar(50) NOT NULL,
  `job_salary` decimal(10,2) NOT NULL,
  `job_status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_jobs`
--

INSERT INTO `tbl_jobs` (`job_id`, `job_name`, `job_salary`, `job_status`) VALUES
(1, 'Cashier', '250.00', 'Active'),
(2, 'Security', '0.00', 'Active'),
(3, 'Waiter', '0.00', 'Active'),
(4, 'Chef ', '0.00', 'Active'),
(5, 'Drink Maker ', '0.00', 'Active'),
(6, 'Matooriste ', '0.00', 'Active'),
(7, 'Laabiyeete ', '0.00', 'Active'),
(8, 'User', '0.00', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_login`
--

CREATE TABLE `tbl_login` (
  `id` int(11) NOT NULL,
  `login_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `holder` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `login_key` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_login`
--

INSERT INTO `tbl_login` (`id`, `login_id`, `holder`, `login_key`, `username`, `password`, `salt`) VALUES
(1, 'login_id_01', 'User', 'fc0c4663', 'asaalixi', 'd55768b6c7b14b3caca3dafbc7b356', '770e8101c004898'),
(34, 'login_id_034', 'Client', 'b189db7e', 'aa', '9ff82efa85321f6f458ab8762f5634', '60c1108ee42d63a'),
(41, 'login_id_041', 'Sub_User', 'ea3fb164', 'kalsan', '4310d56b5dfbd5e6feb3877f7c670d', '73a26594b2a7e88'),
(42, 'login_id_042', 'Sub_User', '19c3f17e', 'amal', 'd7def7eb183fe625be19316a191a37', '2f611f0ada0c0ed'),
(43, 'login_id_043', 'User', '0e0b05e6', 'admin', 'f9891e4d6462d365aa4a968b1c9ade', 'bb229c1e45562a9'),
(44, 'login_id_044', 'User', '312067ae', 'admin', '5d51e503f8bf8f68d0cfaf5dce0f91', 'd2ea3c91bb61d21'),
(45, 'login_id_045', 'Client', '5d56dc0d', 'sdasdfasdfassadf', '214a5d63fcbfe4160feb17cdd73994', 'a39a92fc9514190'),
(46, 'login_id_046', 'Client', '4b33ac55', 'hgjkghjkghjkghjkgh', '14a3bd9baa1dcc2e8ff81d1551e7dc', '5b9ec94c6afeeda'),
(47, 'login_id_047', 'Client', '02e93ccd', 'cvxcvxcbxcvbxcvb', '943bb4d7fa53adee8e730847b0cde6', '53b550fce204348'),
(48, 'login_id_048', 'Client', 'cc78a0c6', 'dfvafvafdvafvsdfbfgnbfdgn', '9ca4575f9e09a30f4b1cdeeba29396', 'e968f4c34cda388'),
(49, 'login_id_049', 'Client', 'e717af93', 'dfasdfasd', 'c1a20b199b1ba3a4e46649bc2e74b7', '675808d3b005910'),
(50, 'login_id_050', 'Client', '988a50c0', 'fsadfasdfa', '20f9b4103fe296fd66d80f35893c6d', '5f82bc0b6c1df1e'),
(51, 'login_id_051', 'Client', '480c6c60', 'assd289', '64ce48237bcfde92eedcb2e0257a7b', '1e2b0e30074e7e0'),
(52, 'login_id_052', 'Client', 'a71fbfc0', 'aaaaaaaaadsddddddd', 'fa292fc722c8853245beba82c533e7', 'f4799133aacb52d'),
(53, 'login_id_053', 'Staff', '37cfd758', 'kalsan1', '1f653e716d439b7d608e47469cf3e1', 'acc8187689a3aa8'),
(54, 'login_id_054', 'Staff', '44cfd711', 'amina', 'd82db2d32702ec249823156c395b2e', '47a8a53b04a2967'),
(55, 'login_id_055', 'Staff', '44cfd755', 'khalif', '13fbceda6b992a2a9e42aa4a053fca', 'dc0fd2327d95d8a'),
(56, 'login_id_056', 'Staff', 'a51ac139', 'salad', '752800339d83fa0bb6d255cc390116', '56fb9c88fa02d13'),
(57, 'login_id_057', 'Staff', 'a34c82e8', 'lab', '4273f56cf5ea041bea6c8f1501eb72', '70a2e787690081f'),
(58, 'login_id_058', 'Client', '23d17b3e', 'omar', '807f7e38f9bdb730f2ac3bb0ca9d26', 'c4a25b01ce7dac6'),
(59, 'login_id_059', 'Client', 'c45c715b', 'sharma', '386a275c4df554385279595abd1671', '77d5e552a306f75'),
(60, 'login_id_060', 'Client', '6b924ac7', 'mmall', 'e9c5864d9e9d5702d355174ed8b35a', '140c812611a1be9'),
(61, 'login_id_061', 'Client', 'bdab80c0', 'raage', '92858a0d496df1228382ec6309408b', '805be1062a9c67a'),
(62, 'login_id_062', 'Client', '027fa473', 'test', '10dedd49d69b6a228d1948e6b3fcb2', '4d2fe32aab6cb46'),
(63, 'login_id_063', 'Client', '0184556f', 'barakaale', '14dc613216edbbf36fb5afc7112475', 'f4910436ac1ec4d'),
(65, 'login_id_065', 'Client', 'fb345a4d', 'osobow', '0d7a19b564b8ce12a14d2d7f47325a', '15ba9114d15d547');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_menu`
--

CREATE TABLE `tbl_menu` (
  `tab_id` int(11) NOT NULL,
  `tab_name_en` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `tab_name_ar` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `tab_icon` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `tab_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tab_parent` text COLLATE utf8_unicode_ci NOT NULL,
  `tab_tag` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `tab_order` int(11) NOT NULL,
  `tab_type` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `tab_status` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_menu`
--

INSERT INTO `tbl_menu` (`tab_id`, `tab_name_en`, `tab_name_ar`, `tab_icon`, `tab_url`, `tab_parent`, `tab_tag`, `tab_order`, `tab_type`, `tab_status`) VALUES
(1, 'Setting', 'الإعدادات', 'settings', 'javascript:void(0)', '0', 'multiple', 1, '', 'Active'),
(2, 'User Management', 'إدارة المستخدمين', 'users', 'javascript:void(0)', '0', 'multiple', 2, '', 'Active'),
(3, 'User Types', 'أنواع المستخدمين', 'user', 'settings/roles', '2', 'single', 3, '', 'Active'),
(4, 'Users', 'المستخدمون', 'user', 'user/list', '2', 'single', 4, '', 'Active'),
(5, 'Menus', 'القوائم', 'user', 'settings/menus', '1', 'single', 4, '', 'Active'),
(6, 'Financial Management', 'ادارة المالية', 'bar-chart', 'javascript:void(0)', '0', 'multiple', 3, '', 'Active'),
(7, 'Roles & Permissions', 'الصلاحيات والأذون', '', 'settings/uac', '2', 'single', 6, '', 'Active'),
(8, 'Financial Period', 'الفترة المالية', '', 'financial/finperiod', '6', 'single', 7, '', 'Active'),
(9, 'Chart of Accounts', 'دليل الحسابات', '', 'financial/chart_accounts', '6', 'single', 6, '', 'Active'),
(10, 'Journal Entry', 'دفتر اليومية', '', 'financial/journal', '6', 'single', 9, '', 'Active'),
(11, 'Transactions', 'سجل الحركات', '', 'financial/trx', '6', 'single', 10, '', 'Active'),
(12, 'Human Resource', 'الموارد البشرية', 'user-check', 'javascript:void(0)', '0', 'multiple', 4, '', 'Active'),
(13, 'Employees', 'الموظفين', '', 'hr/employees', '12', 'single', 11, '', 'Active'),
(14, 'Jobs', 'الوظائف', '', 'hr/jobs', '12', 'single', 11, '', 'Active'),
(15, 'Payroll', 'كشف الواتب', '', 'hr/payroll', '12', 'single', 14, '', 'Active'),
(23, 'Supplier Center', 'مركز الموردين', 'users', 'javascript:void(0)', '0', 'multiple', 8, '', 'Active'),
(24, 'Suppliers', 'الموردون', '', 'supplier/list', '23', 'single', 0, '', 'Active'),
(25, 'Bills', 'نوع المورد', '', 'invoice/list', '23', 'single', 0, '', 'Active'),
(26, 'Payments', 'المدفوعات', '', 'payment/list', '23', 'single', 0, '', 'Active'),
(27, 'Customer Center', 'مركز العملاء', 'users', 'javascript:void(0)', '0', 'multiple', 9, '', 'Active'),
(28, 'Customers', 'العملاء', '', 'customer/list', '27', 'single', 0, '', 'Active'),
(30, 'Receipts', 'الإيصالات', '', 'receipt/list', '27', 'single', 0, '', 'Active'),
(34, 'Reports', 'التقارير', 'trending-up', 'javascript:void(0)', '0', 'multiple', 10, '', 'Active'),
(37, 'Payment Voucher', 'سند الصرف', '', 'financial/payment_voucher', '6', 'single', 0, '', 'Active'),
(38, 'Receipt Voucher', 'سند القبض', '', 'financial/receipt_voucher', '6', 'single', 0, '', 'Active'),
(42, 'Branches', 'الوحدات', '', 'settings/branches', '1', 'single', 0, '', 'Active'),
(61, 'Income Statement', 'ادارة الأسهم', 'briefcase', 'report/income_statemant', '34', 'single', 3, '', 'Active'),
(62, 'Balance Sheet ', 'ادارة الأسهم', 'briefcase', 'report/blance_sheet', '34', 'single', 3, '', 'Active'),
(63, 'Customer', 'ادارة الأسهم', 'briefcase', 'report/customers', '34', 'single', 3, '', 'Active'),
(64, 'Supplier', 'ادارة الأسهم', 'briefcase', 'report/supplier', '34', 'single', 3, '', 'Active'),
(65, 'Inventory Evaluation  ', 'ادارة الأسهم', 'briefcase', 'report/inventory_evaluation', '34', 'single', 3, '', 'Active'),
(81, 'Rental management', 'Rental Agreement', 'home', '#', '0', 'single', 6, '', 'Active'),
(82, 'Rental List', 'Rental List', 'home', 'rental/list', '81', 'single', 1, '', 'Active'),
(83, 'Closed Rentals', 'Closed Rental List', 'home', 'rental/closed', '81', 'single', 1, '', 'Active'),
(84, 'Rental Bills', 'Rental Bills', 'home', 'bill/list', '81', 'single', 1, '', 'Active'),
(85, 'Charge Bills', 'Charge Bills', 'home', 'bill/charges', '81', 'single', 1, '', 'Active'),
(87, 'Meters & Reading', 'Meters & Reading', 'home', '#', '0', 'single', 7, '', 'Active'),
(88, 'Rates', 'Rates', 'home', 'rate/list', '87', 'single', 1, '', 'Active'),
(89, 'Meters', 'Meters', 'home', 'meter/list', '87', 'single', 1, '', 'Active'),
(90, 'Readings', 'Readings', 'home', 'reading/list', '87', 'single', 1, '', 'Active'),
(91, 'Apartment Center', 'Apartemenet Center', 'home', '#', '0', 'single', 5, '', 'Active'),
(92, 'Building', 'Building', 'home', 'apartment/building', '91', 'single', 1, '', 'Active'),
(93, 'Floors', 'Floors', 'home', 'apartment/floors', '91', 'single', 1, '', 'Active'),
(94, 'Apartments', 'Apartments', 'home', 'apartment/apartments', '91', 'single', 1, '', 'Active'),
(95, 'Apartment Types', 'Apartment Types', 'home', 'apartment/apartment_types', '91', 'single', 1, '', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_menu_access`
--

CREATE TABLE `tbl_menu_access` (
  `id` int(11) NOT NULL,
  `user_id` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `tab_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `access_status` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_menu_access`
--

INSERT INTO `tbl_menu_access` (`id`, `user_id`, `tab_id`, `access_status`) VALUES
(46, '12', '6', 'Active'),
(47, '12', '12', 'Active'),
(48, '12', '34', 'Active'),
(49, '12', '35', 'Active'),
(50, '12', '46', 'Active'),
(51, '12', '8', 'Active'),
(52, '12', '9', 'Active'),
(53, '12', '10', 'Active'),
(54, '12', '11', 'Active'),
(55, '12', '37', 'Active'),
(56, '12', '38', 'Active'),
(57, '12', '13', 'Active'),
(58, '12', '14', 'Active'),
(59, '12', '15', 'Active'),
(60, '12', '60', 'Active'),
(61, '12', '61', 'Active'),
(62, '12', '62', 'Active'),
(63, '12', '63', 'Active'),
(64, '12', '64', 'Active'),
(65, '12', '65', 'Active'),
(66, '12', '52', 'Active'),
(67, '12', '47', 'Active'),
(68, '12', '54', 'Active'),
(69, '12', '55', 'Active'),
(70, '12', '56', 'Active'),
(71, '12', '57', 'Active'),
(72, '12', '58', 'Active'),
(607, '2', '12', 'Active'),
(608, '2', '23', 'Active'),
(609, '2', '27', 'Active'),
(610, '2', '13', 'Active'),
(611, '2', '14', 'Active'),
(612, '2', '15', 'Active'),
(613, '2', '24', 'Active'),
(614, '2', '25', 'Active'),
(615, '2', '26', 'Active'),
(616, '2', '28', 'Active'),
(617, '2', '30', 'Active'),
(618, '3', '12', 'Active'),
(619, '3', '23', 'Active'),
(620, '3', '27', 'Active'),
(621, '3', '13', 'Active'),
(622, '3', '14', 'Active'),
(623, '3', '15', 'Active'),
(624, '3', '24', 'Active'),
(625, '3', '25', 'Active'),
(626, '3', '26', 'Active'),
(627, '3', '28', 'Active'),
(628, '3', '30', 'Active'),
(806, '1', '1', 'Active'),
(807, '1', '2', 'Active'),
(808, '1', '6', 'Active'),
(809, '1', '12', 'Active'),
(810, '1', '23', 'Active'),
(811, '1', '27', 'Active'),
(812, '1', '34', 'Active'),
(813, '1', '81', 'Active'),
(814, '1', '87', 'Active'),
(815, '1', '91', 'Active'),
(816, '1', '5', 'Active'),
(817, '1', '42', 'Active'),
(818, '1', '3', 'Active'),
(819, '1', '4', 'Active'),
(820, '1', '7', 'Active'),
(821, '1', '8', 'Active'),
(822, '1', '9', 'Active'),
(823, '1', '10', 'Active'),
(824, '1', '11', 'Active'),
(825, '1', '37', 'Active'),
(826, '1', '38', 'Active'),
(827, '1', '13', 'Active'),
(828, '1', '14', 'Active'),
(829, '1', '15', 'Active'),
(830, '1', '24', 'Active'),
(831, '1', '25', 'Active'),
(832, '1', '26', 'Active'),
(833, '1', '28', 'Active'),
(834, '1', '30', 'Active'),
(835, '1', '61', 'Active'),
(836, '1', '62', 'Active'),
(837, '1', '63', 'Active'),
(838, '1', '64', 'Active'),
(839, '1', '65', 'Active'),
(840, '1', '82', 'Active'),
(841, '1', '84', 'Active'),
(842, '1', '85', 'Active'),
(843, '1', '88', 'Active'),
(844, '1', '89', 'Active'),
(845, '1', '90', 'Active'),
(846, '1', '92', 'Active'),
(847, '1', '93', 'Active'),
(848, '1', '94', 'Active'),
(849, '1', '95', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_meters`
--

CREATE TABLE `tbl_meters` (
  `meter_id` int(11) NOT NULL,
  `meter_name` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `des` text NOT NULL,
  `ap_id` int(11) NOT NULL,
  `reg_date` date NOT NULL,
  `profile_no` varchar(25) NOT NULL,
  `meter_status` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_meters`
--

INSERT INTO `tbl_meters` (`meter_id`, `meter_name`, `type`, `des`, `ap_id`, `reg_date`, `profile_no`, `meter_status`) VALUES
(8, 'EM-E3', 'Electricity', '', 20, '2023-05-01', '19186974', 'Active'),
(9, 'WM-E3', 'Water', '', 20, '2023-05-01', '19186974', 'Active'),
(10, 'EM-A1', 'Electricity', 'EM-A1', 2, '2023-08-01', '19186974', 'Active'),
(11, 'WM-A1', 'Water', 'WM-A1', 2, '2023-08-01', '19186974', 'Active'),
(12, 'WM-B3', 'Water', 'WM-B3', 8, '2023-07-01', '19186974', 'Active'),
(13, 'EM-B3', 'Electricity', 'EM-B3', 8, '2023-07-01', '19186974', 'Active'),
(14, 'WM-B4', 'Water', 'EM-B4', 9, '0000-00-00', '19186974', 'Active'),
(15, 'EM-B4', 'Electricity', 'EM-B4', 9, '2023-07-01', '19186974', 'Active'),
(16, 'EM-A3', 'Electricity', '', 4, '0000-00-00', '19186974', 'Active'),
(17, 'WM-A3', 'Water', 'EM-A3', 4, '2023-07-01', '19186974', 'Active'),
(18, 'EM-B1', 'Electricity', 'EM-B1', 6, '2023-07-01', '19186974', 'Active'),
(19, 'WM-B1', 'Water', 'WM-B1', 6, '2023-07-01', '19186974', 'Active'),
(20, 'EM-C1', 'Electricity', 'EM-C1', 10, '2023-08-01', '19186974', 'Active'),
(21, 'WM-C2', 'Water', 'WM-C2', 11, '2023-07-01', '19186974', 'Active'),
(22, 'EM-C2', 'Electricity', 'EM-C2', 11, '2023-07-01', '19186974', 'Active'),
(23, 'EM-C3', 'Electricity', 'EM-C3', 12, '2023-07-01', '19186974', 'Active'),
(24, 'WM-C3', 'Water', 'WM-C3', 12, '2023-07-01', '19186974', 'Active'),
(25, 'EM-C4', 'Electricity', 'EM-C4', 13, '2023-07-01', '19186974', 'Active'),
(26, 'EM-A4', 'Electricity', 'EM-A4', 5, '2023-07-01', '19186974', 'Active'),
(27, 'WM-A4', 'Water', 'WM-A4', 5, '2023-07-01', '19186974', 'Active'),
(28, 'EM-D3', 'Electricity', 'EM-D3', 16, '2023-07-01', '19186974', 'Active'),
(29, 'WM-D3', 'Water', 'WM-D3', 16, '2023-07-01', '19186974', 'Active'),
(30, 'EM-D4', 'Electricity', 'EM-D4', 17, '2023-07-01', '19186974', 'Active'),
(31, 'WM-D4', 'Water', 'WM-D4', 17, '2023-07-01', '19186974', 'Active'),
(32, 'EM-E2', 'Electricity', 'EM-E2', 19, '2023-07-01', '19186974', 'Active'),
(33, 'WM-E2', 'Water', 'WME2', 19, '2023-07-01', '19186974', 'Active'),
(34, 'EM-E3', 'Electricity', 'EM-E3', 20, '2023-07-01', '19186974', 'Active'),
(35, 'WM-E3', 'Water', 'WM-E3', 20, '2023-07-01', '19186974', 'Active'),
(36, 'EM-E4', 'Electricity', 'EM-E4', 21, '2023-07-01', '19186974', 'Active'),
(37, 'WM-E4', 'Water', 'WM-E4', 21, '2023-07-01', '19186974', 'Active'),
(38, 'EM-F3', 'Electricity', 'EM-F3', 24, '2023-07-01', '19186974', 'Active'),
(39, 'WM-F3', 'Water', 'WM-F3', 24, '2023-07-01', '19186974', 'Active'),
(40, 'EM-F4', 'Electricity', 'EM-F4', 25, '2023-07-01', '19186974', 'Active'),
(41, 'WM-F4', 'Water', 'WM-F4', 25, '2023-07-01', '19186974', 'Active'),
(42, 'EM-G3', 'Electricity', 'EM-G3', 28, '2023-07-01', '19186974', 'Active'),
(43, 'WM-G3', 'Water', 'WM-G3', 28, '2023-07-01', '19186974', 'Active'),
(44, 'EM-G4', 'Electricity', 'EM-G4', 29, '2023-07-01', '19186974', 'Active'),
(45, 'WM-G4', 'Water', 'WM-G4', 29, '2023-07-01', '19186974', 'Active'),
(46, 'EM-F3', 'Electricity', 'EM-F3', 24, '2023-07-01', '19186974', 'Active'),
(47, 'WM-F3', 'Water', 'WM-F3', 24, '2023-07-01', '19186974', 'Active'),
(48, 'EM-F4', 'Electricity', 'EM-F4', 25, '2023-07-01', '19186974', 'Active'),
(49, 'WM-F4', 'Water', 'WM-F4', 25, '2023-07-01', '19186974', 'Active'),
(50, 'EM-G3', 'Electricity', 'EM-G3', 28, '2023-07-01', '19186974', 'Active'),
(51, 'WM-G3', 'Water', 'WM-G3', 28, '2023-07-01', '19186974', 'Active'),
(52, 'EM-H2', 'Electricity', 'EM-H2', 31, '2023-07-01', '19186974', 'Active'),
(53, 'WM-H2', 'Water', 'WM-H2', 31, '2023-07-01', '19186974', 'Active'),
(54, 'EM-H3', 'Electricity', 'EM-H3', 32, '2023-07-01', '19186974', 'Active'),
(55, 'WM-H3', 'Water', 'WM-H3', 32, '2023-07-01', '19186974', 'Active'),
(56, 'EM-H4', 'Electricity', 'EM-H4', 33, '2023-07-01', '19186974', 'Active'),
(57, 'WM-H4', 'Water', 'WM-H4', 33, '2023-07-01', '19186974', 'Active'),
(58, 'WM-C4', 'Water', 'WM-C4', 13, '2023-08-01', '19186974', 'Active'),
(59, 'WM-C1', 'Water', 'WM-C1', 10, '2023-08-01', '19186974', 'Active'),
(60, 'WM-B2', 'Water', 'WM-B2', 7, '2023-08-02', '19186974', 'Active'),
(61, 'EM-B2', 'Electricity', 'EM-B2', 7, '2023-08-02', '19186974', 'Active'),
(62, 'EM-D1', 'Electricity', 'EM-D1', 14, '2023-08-02', '19186974', 'Active'),
(63, 'WM-D1', 'Water', 'WM-D1', 14, '2023-08-02', '19186974', 'Active'),
(64, 'EM-D2', 'Electricity', 'EM-D2', 15, '2023-08-03', '19186974', 'Active'),
(65, 'WM-D2', 'Water', 'WM-D2', 15, '2023-08-03', '19186974', 'Active'),
(66, 'EM-F2', 'Electricity', 'EM-F2', 23, '2023-08-02', '19186974', 'Active'),
(67, 'WM-F2', 'Water', 'WM-F2', 23, '2023-08-02', '19186974', 'Active'),
(68, 'WM-G1', 'Water', 'WM-G1', 27, '2023-08-02', '19186974', 'Active'),
(69, 'WM-G1', 'Water', 'WM-G1', 26, '2023-08-02', '19186974', 'Active'),
(70, 'EM-A2', 'Electricity', 'EM-A2', 3, '2023-08-28', '19186974', 'Active'),
(71, 'EM-A2', 'Electricity', 'EM-A2', 3, '2023-08-28', '19186974', 'Active'),
(72, 'WM-A2', 'Water', 'WM-A2', 3, '2023-08-28', '19186974', 'Active'),
(73, 'WM-A2', 'Water', 'WM-A2', 3, '2023-08-28', '19186974', 'Active'),
(74, 'EM-G2', 'Electricity', 'EM-G2', 27, '2023-08-28', '19186974', 'Active'),
(75, 'EM-E1', 'Electricity', 'EM-E1', 18, '2023-10-01', '19186974', 'Active'),
(76, 'WM-E1', 'Water', 'WM-E1', 18, '2023-10-01', '19186974', 'Active'),
(77, 'WM-E1', 'Water', 'WM-E1', 18, '2023-10-01', '19186974', 'Active'),
(78, 'WM-G2', 'Water', 'WM-G2', 27, '2023-10-01', '19186974', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_packages`
--

CREATE TABLE `tbl_packages` (
  `id` int(11) NOT NULL,
  `package_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `package_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `package_price` decimal(12,2) NOT NULL,
  `package_branches` int(11) NOT NULL,
  `package_sub_users` int(11) NOT NULL,
  `max_branches` int(11) NOT NULL,
  `max_sub_users` int(11) NOT NULL,
  `per_branch` decimal(12,2) NOT NULL,
  `per_sub_user` decimal(12,2) NOT NULL,
  `package_des` text COLLATE utf8_unicode_ci NOT NULL,
  `package_status` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Pending',
  `package_timestamp` varchar(15) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_packages`
--

INSERT INTO `tbl_packages` (`id`, `package_id`, `package_name`, `package_price`, `package_branches`, `package_sub_users`, `max_branches`, `max_sub_users`, `per_branch`, `per_sub_user`, `package_des`, `package_status`, `package_timestamp`) VALUES
(1, 'package_id_01', 'Basic', '50.00', 2, 5, 2, 4, '10.00', '5.00', 'Basic is for starters', 'Active', '1660542604'),
(2, 'package_id_02', 'Premium', '150.00', 5, 10, 3, 9, '7.00', '5.00', 'Premium ', 'Active', '1660543807');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rahan_document`
--

CREATE TABLE `tbl_rahan_document` (
  `rah_id` int(11) NOT NULL,
  `tan_id` int(11) NOT NULL,
  `document_path` varchar(255) DEFAULT NULL,
  `document_img` varchar(255) DEFAULT NULL,
  `rah_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rates`
--

CREATE TABLE `tbl_rates` (
  `rate_id` int(11) NOT NULL,
  `base_name` varchar(90) NOT NULL,
  `rate_value` decimal(10,2) NOT NULL,
  `rate_status` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_rates`
--

INSERT INTO `tbl_rates` (`rate_id`, `base_name`, `rate_value`, `rate_status`) VALUES
(6, 'rate_water_normal', '1.30', 'Active'),
(7, 'rate_el_normal', '0.41', 'Active'),
(8, 'normal', '0.46', 'Active'),
(9, 'wow rate', '2.00', 'Active'),
(10, 'wow rate', '2.00', 'Active'),
(11, 'rate_water_normal', '2.00', 'Active'),
(12, 'rate_water_normal', '2.00', 'Active'),
(13, 'rate_water_normal', '2.00', 'Active'),
(14, 'rate_water_normal', '2.00', 'Active'),
(15, 'rate_water_normal', '2.00', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reading`
--

CREATE TABLE `tbl_reading` (
  `reading_id` int(11) NOT NULL,
  `prev` decimal(10,2) NOT NULL,
  `current` decimal(10,2) NOT NULL,
  `diff` decimal(10,2) NOT NULL,
  `rate_id` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `meter_id` int(11) NOT NULL,
  `reading_status` varchar(20) NOT NULL DEFAULT 'Active',
  `profile_no` varchar(20) NOT NULL,
  `reading_date` date NOT NULL,
  `read_month` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_reading`
--

INSERT INTO `tbl_reading` (`reading_id`, `prev`, `current`, `diff`, `rate_id`, `total`, `meter_id`, `reading_status`, `profile_no`, `reading_date`, `read_month`) VALUES
(1, '0.00', '30.00', '30.00', 7, '12.30', 10, 'Active', '19186974', '2024-07-24', 'July'),
(2, '0.00', '30.00', '30.00', 8, '13.80', 71, 'Active', '19186974', '2024-07-16', 'July'),
(3, '0.00', '30.00', '30.00', 6, '45.00', 70, 'Active', '19186974', '2024-07-16', 'July'),
(4, '30.00', '50.00', '20.00', 6, '30.00', 71, 'Active', '19186974', '2024-08-07', 'August'),
(5, '0.00', '20.00', '20.00', 7, '8.20', 11, 'Active', '19186974', '2024-08-12', 'August'),
(6, '0.00', '30.00', '30.00', 6, '39.00', 16, 'Active', '', '2024-09-18', 'September'),
(7, '30.00', '30.00', '0.00', 7, '0.00', 70, 'Active', '', '2024-09-17', 'September'),
(8, '30.00', '35.00', '5.00', 8, '2.30', 10, 'Active', '', '2024-09-17', 'September'),
(9, '0.00', '330.00', '330.00', 7, '135.30', 60, 'Active', '', '0000-00-00', 'January'),
(10, '35.00', '45.00', '10.00', 7, '4.10', 10, 'Active', '', '2024-09-17', 'September'),
(11, '30.00', '50.00', '20.00', 6, '26.00', 70, 'Active', '', '2024-09-17', 'September');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ref_persons`
--

CREATE TABLE `tbl_ref_persons` (
  `ref_person_id` int(11) NOT NULL,
  `ref_person_name` varchar(200) NOT NULL,
  `reef_person_tel` varchar(100) NOT NULL,
  `ref_person_email` varchar(100) DEFAULT NULL,
  `ref_person_id_no` varchar(200) NOT NULL,
  `ref_person_id_img` varchar(255) DEFAULT NULL,
  `ref_person_status` varchar(20) NOT NULL,
  `profile_no` varchar(25) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_relocation`
--

CREATE TABLE `tbl_relocation` (
  `relocation_id` int(11) NOT NULL,
  `ten_id` int(11) NOT NULL,
  `prev_ap_id` int(11) NOT NULL,
  `new_ap_id` int(11) NOT NULL,
  `reason` text NOT NULL,
  `balance` decimal(65,3) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rentals`
--

CREATE TABLE `tbl_rentals` (
  `rental_id` int(11) NOT NULL,
  `profile_no` varchar(25) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `ap_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `duration` varchar(10) DEFAULT NULL,
  `rental_date` date NOT NULL,
  `deposit` decimal(10,2) NOT NULL,
  `ref_person_id` int(11) DEFAULT NULL,
  `rental_status` varchar(30) NOT NULL,
  `login_key` varchar(25) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_rentals`
--

INSERT INTO `tbl_rentals` (`rental_id`, `profile_no`, `customer_id`, `ap_id`, `start_date`, `end_date`, `duration`, `rental_date`, `deposit`, `ref_person_id`, `rental_status`, `login_key`, `created_at`) VALUES
(1, '', 1, 16, '2024-08-01', '2024-11-30', '121 days ', '2024-09-17', '750.00', NULL, 'Active', NULL, '2024-09-17 10:50:11'),
(2, '', 2, 17, '2024-08-01', '2024-11-30', '121 days ', '2024-09-17', '400.00', NULL, 'Active', NULL, '2024-09-17 10:56:20'),
(3, '', 1, 18, '2024-08-01', '2024-10-31', '91 days ', '2024-09-17', '750.00', NULL, 'Active', NULL, '2024-09-17 11:17:05');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rental_bills`
--

CREATE TABLE `tbl_rental_bills` (
  `bill_id` int(11) NOT NULL,
  `bill_no` varchar(100) DEFAULT NULL,
  `profile_no` varchar(25) NOT NULL,
  `rental_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `total` double(10,2) NOT NULL,
  `balance` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL,
  `bill_date` date NOT NULL,
  `bill_due_date` date DEFAULT NULL,
  `bill_status` varchar(100) DEFAULT NULL,
  `account_id` varchar(255) DEFAULT NULL,
  `receipt_date` date DEFAULT NULL,
  `remarks` varchar(20) NOT NULL,
  `trx_id` varchar(50) NOT NULL,
  `rec_trx_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_rental_bills`
--

INSERT INTO `tbl_rental_bills` (`bill_id`, `bill_no`, `profile_no`, `rental_id`, `customer_id`, `total`, `balance`, `discount`, `bill_date`, `bill_due_date`, `bill_status`, `account_id`, `receipt_date`, `remarks`, `trx_id`, `rec_trx_id`, `created_at`) VALUES
(1, '', '', 1, 1, 750.00, '750.00', '0.00', '2024-09-17', '1970-01-01', 'PAID', NULL, '2024-09-17', 'RENT', '58', '58', '2024-09-17 10:50:11'),
(2, '', '', 2, 2, 400.00, '400.00', '0.00', '2024-09-17', '1970-01-01', 'PAID', NULL, '2024-09-17', 'RENT', '59', '59', '2024-09-17 10:56:20'),
(3, '', '', 1, 1, 750.00, '0.00', '0.00', '2024-09-01', '2024-10-01', 'PAID', NULL, '2024-09-05', 'RENT', '60', '61', '2024-09-17 10:58:12'),
(4, '', '', 3, 1, 750.00, '750.00', '0.00', '2024-09-17', '2024-10-17', 'UNPAID', NULL, '2024-09-17', 'RENT', '62', '', '2024-09-17 11:24:29'),
(5, '', '', 0, 1, 4.10, '0.00', '0.00', '2024-09-17', '2024-09-22', 'PAID', NULL, '2024-09-17', 'UTILITY', '65', '66', '2024-09-17 11:24:06'),
(6, '', '', 0, 2, 26.00, '0.00', '0.00', '2024-09-17', '2024-09-22', 'PAID', NULL, '2024-09-17', 'UTILITY', '67', '69', '2024-09-17 11:27:27');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rental_bills_tracker`
--

CREATE TABLE `tbl_rental_bills_tracker` (
  `track_id` int(11) NOT NULL,
  `bill_date` date NOT NULL,
  `profile_no` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rental_receipts`
--

CREATE TABLE `tbl_rental_receipts` (
  `receipt_id` int(11) NOT NULL,
  `profile_no` varchar(25) NOT NULL,
  `bill_id` int(11) NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL,
  `account_id` varchar(100) NOT NULL,
  `receipt_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `login_key` varchar(25) NOT NULL,
  `rec_status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rental_termination`
--

CREATE TABLE `tbl_rental_termination` (
  `term_id` int(11) NOT NULL,
  `rental_id` int(11) NOT NULL,
  `profile_no` varchar(30) NOT NULL,
  `term_date` date NOT NULL,
  `reason` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_roles`
--

CREATE TABLE `tbl_roles` (
  `id` int(11) NOT NULL,
  `role_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `role_name_en` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `role_des` text COLLATE utf8_unicode_ci NOT NULL,
  `uc_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `role_status` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Pending',
  `role_timestamp` varchar(15) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_roles`
--

INSERT INTO `tbl_roles` (`id`, `role_id`, `role_name_en`, `role_des`, `uc_id`, `role_status`, `role_timestamp`) VALUES
(1, 'role_id_01', 'System Admin', 'Only for system administrator category', 'uc_id_01', 'Active', '1254789677'),
(2, 'role_id_02', 'Service Client', 'only for service client role', 'uc_id_02', 'Active', '1642537586');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_salary`
--

CREATE TABLE `tbl_salary` (
  `salary_id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `Job_id` int(11) DEFAULT NULL,
  `comm` decimal(4,1) NOT NULL,
  `deduction` decimal(4,1) NOT NULL,
  `net_pay` int(11) NOT NULL,
  `month` varchar(12) NOT NULL,
  `payment_date` date NOT NULL,
  `account_id` varchar(50) NOT NULL,
  `salary_status` varchar(15) NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `trx_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_salary`
--

INSERT INTO `tbl_salary` (`salary_id`, `emp_id`, `Job_id`, `comm`, `deduction`, `net_pay`, `month`, `payment_date`, `account_id`, `salary_status`, `remarks`, `trx_id`) VALUES
(1, 1, NULL, '0.0', '0.0', 250, 'July', '2024-07-11', 'account_id_03', 'Active', '', 'trx_id_04914'),
(2, 1, NULL, '0.0', '0.0', 250, 'January', '2024-08-19', '3', 'Active', '', '7'),
(3, 8, NULL, '0.0', '0.0', 250, 'January', '2024-09-01', '3', 'Active', '', '18'),
(4, 8, NULL, '0.0', '0.0', 250, 'February', '2024-09-02', '3', 'Active', '', '21');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sites`
--

CREATE TABLE `tbl_sites` (
  `site_id` int(11) NOT NULL,
  `site_name` varchar(100) NOT NULL,
  `site_address` varchar(100) NOT NULL,
  `profile_no` varchar(25) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_sites`
--

INSERT INTO `tbl_sites` (`site_id`, `site_name`, `site_address`, `profile_no`, `created_at`, `status`) VALUES
(1, 'Muna Tower', 'Taleh, Hodan', '', '2024-09-17 12:00:45', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_staff`
--

CREATE TABLE `tbl_staff` (
  `id` int(10) NOT NULL,
  `staff_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `profile_no` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `login_key` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `staff_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `ut_id` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `staff_tell` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `staff_email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `staff_gender` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `staff_marital` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `blood_type` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `emp_type` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `job_id` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `branch_id` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `grant_access` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `staff_address` text COLLATE utf8_unicode_ci NOT NULL,
  `staff_img` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `staff_tag` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `staff_status` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Active',
  `staff_timestamp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_staff`
--

INSERT INTO `tbl_staff` (`id`, `staff_id`, `profile_no`, `login_key`, `staff_name`, `ut_id`, `staff_tell`, `staff_email`, `staff_gender`, `staff_marital`, `blood_type`, `emp_type`, `job_id`, `branch_id`, `grant_access`, `staff_address`, `staff_img`, `staff_tag`, `staff_status`, `staff_timestamp`) VALUES
(1, 'staff_id_01', 'e282d6a5', '', 'Ali Nuur Hassan', 'ut_id_04', '6154879898', 'dadf@asd.com', 'Male', 'Single', 'A+', 'Full-Time', 'job_id_06', 'branch_id_02', 'Not-Granted', 'Taleex Hodan, Mogadishu Somalia', '1664438152-RAED-HRSALE_Organization_Chart.png', 'st', 'Active', 1664438152),
(2, 'staff_id_02', 'e282d6a5', '44cfd711', 'Amina Nuur Hassan', 'ut_id_06', '6154879898', 'dadf@asd.com', 'Female', 'Married', 'B-', 'Part-Time', 'job_id_01', 'branch_id_01', 'Not-Granted', 'Taleex Hodan, Mogadishu Somalia', '1664439442-RAED-ARAGSAN_LOGO-02.jpg', 'dr', 'Active', 1664439442),
(3, 'staff_id_03', 'e282d6a5', '', 'Maryan Cabdi Maalin', 'ut_id_07', '6154879898', 'dadf@asd.com', 'Female', 'Single', 'O+', 'Full-Time', 'job_id_02', 'branch_id_01', 'Not-Granted', 'Taleex Hodan, Mogadishu Somalia', '1664452735-RAED-c1ec5dffc54448afad3bfb45bbefbb09.jpg', 'nr', 'Active', 1664452735),
(4, 'staff_id_04', 'e282d6a5', '37cfd758', 'Kalsan Kasim Kadiye', 'ut_id_06', '6154879898', 'dadf@asd.com', 'Female', 'Single', 'AB+', 'Part-Time', 'job_id_09', 'branch_id_01', 'Not-Granted', 'Taleex Hodan, Mogadishu Somalia', '1664884971-RAED-163827.png', 'dr', 'Active', 1664884971),
(5, 'staff_id_05', 'e282d6a5', '44cfd755', 'Ali Mohamed Khalif', 'ut_id_06', '617000264', 'dralivision@gmail.com', 'Male', 'Married', 'A+', 'Full-Time', 'job_id_01', 'branch_id_01', 'Not-Granted', 'Taleex Hodan, Mogadishu Somalia', '1665917470-RAED-pngtree-call-center-customer-support-service-avatar-png-image_5232853.png', 'dr', 'Active', 1665917470),
(6, 'staff_id_06', 'e282d6a5', 'a51ac139', 'Salad Hussein Jamac', 'ut_id_04', '23265687', 'salad@acb.com', 'Male', 'Single', 'A-', 'Full-Time', 'job_id_06', 'branch_id_01', 'Not-Granted', 'Taleex Hodan, Mogadishu Somalia', '1665998025-RAED-103160_man_512x512.png', 'st', 'Active', 1665998025),
(7, 'staff_id_07', 'e282d6a5', 'a34c82e8', 'Lab Salah Ahmed', 'ut_id_08', '6154879898', 'dadf@asd.com', 'Male', 'Single', 'A-', 'Full-Time', 'job_id_03', 'branch_id_01', 'Not-Granted', 'Taleex Hodan, Mogadishu Somalia', '1667217473-RAED-147133.png', 'lt', 'Active', 1667217473);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sub_users`
--

CREATE TABLE `tbl_sub_users` (
  `id` int(10) NOT NULL,
  `sub_user_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `ut_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `sub_user_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `sub_user_tell` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `sub_user_email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `sub_user_branch` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `sub_user_img` text COLLATE utf8_unicode_ci NOT NULL,
  `login_key` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `profile_no` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `sub_user_status` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Pending',
  `sub_user_timestamp` varchar(15) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_sub_users`
--

INSERT INTO `tbl_sub_users` (`id`, `sub_user_id`, `ut_id`, `sub_user_name`, `sub_user_tell`, `sub_user_email`, `sub_user_branch`, `sub_user_img`, `login_key`, `profile_no`, `sub_user_status`, `sub_user_timestamp`) VALUES
(1, 'sub_user_id_01', 'ut_id_04', 'kalsan abdi nuur', '63525248', 'kalsan@abc.com', 'branch_id_01', '1661762679-RAED-pngtree-call-center-customer-support-service-avatar-png-image_5232849.png', 'f6fe3733', 'e282d6a5', 'Deleted', '1661762679'),
(2, 'sub_user_id_02', 'ut_id_03', 'Amal Nuur Ali ', '658958', 'amal@abc.com', 'branch_id_01', '1661842205-RAED-pngtree-call-center-customer-support-service-avatar-png-image_5232854.png', '3c96a4b6', 'e282d6a5', 'Deleted', '1661842205'),
(3, 'sub_user_id_03', 'ut_id_04', 'asdfsad', 'sdfasd', 'sdf', 'branch_id_01', '1661842870-RAED-163827.png', '0e2a4328', 'e282d6a5', 'Deleted', '1661842870'),
(4, 'sub_user_id_04', 'ut_id_03', 'sdfasd', 'fasdfasd', 'fsadfsad', 'branch_id_01', '1661842970-RAED-103160_man_512x512.png', '0fe8291f', 'e282d6a5', 'Deleted', '1661842970'),
(5, 'sub_user_id_05', 'ut_id_03', 'asdfasd', 'fasdfas', 'dfasdf', 'branch_id_01', '1661843043-RAED-pngtree-call-center-customer-support-service-avatar-png-image_5232853.png', '0aa1778c', 'e282d6a5', 'Deleted', '1661843043'),
(6, 'sub_user_id_06', 'ut_id_03', 'asdfasdf', 'sadfasdf', 'asdfsadf', 'branch_id_01', '1661843080-RAED-pngtree-call-center-customer-support-service-avatar-png-image_5232853.png', '3f1d693a', 'e282d6a5', 'Deleted', '1661843080'),
(7, 'sub_user_id_07', 'ut_id_04', 'Kalsan Jamac Salah', '225599887', 'kalsan@abc.com', 'branch_id_01', '1678092217-RAED-WhatsApp Image 2023-02-28 at 7.48.40 AM (1).jpeg', 'ea3fb164', 'e282d6a5', 'Active', '1661948504'),
(8, 'sub_user_id_08', 'ut_id_03', 'Amal Ali Kasim', '928249842', 'amal@abc.com', 'branch_id_02', '1661948712-RAED-pngtree-call-center-customer-support-service-avatar-png-image_5232854.png', '19c3f17e', 'e282d6a5', 'Active', '1661948712');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_suppliers`
--

CREATE TABLE `tbl_suppliers` (
  `sup_id` int(11) NOT NULL,
  `sup_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sup_email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sup_phone` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sup_balance` decimal(10,2) NOT NULL,
  `sup_status` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_no` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_id` int(11) NOT NULL,
  `reg_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_suppliers`
--

INSERT INTO `tbl_suppliers` (`sup_id`, `sup_name`, `sup_email`, `sup_phone`, `sup_balance`, `sup_status`, `profile_no`, `branch_id`, `reg_date`) VALUES
(4, 'saha water', 'sahawater@gmail.com', '612238858', '0.00', 'Active', '19186974', 0, '2023-05-08'),
(5, 'Som gaas', 'somgas@somgas.so', '615557719', '0.00', 'Active', '19186974', 0, '2023-07-06'),
(6, 'supplier first ', 'sup@gm.com', '1234445', '0.00', 'Active', '', 1, '2024-09-08'),
(7, 'Alnaciim Water supply', 'alnaciim@water.so', '852020', '0.00', 'Active', '', 1, '2024-09-09'),
(8, 'Hass Gas supply', 'hassgas@gas.so', '602020', '0.00', 'Active', '', 1, '2024-09-09'),
(9, 'Bluecom Internet', 'bluecomint@bluecom.so', '653030', '0.00', 'Active', '', 1, '2024-09-09');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_supplier_balances`
--

CREATE TABLE `tbl_supplier_balances` (
  `id` int(11) NOT NULL,
  `sup_id` int(11) NOT NULL,
  `created_date` date NOT NULL,
  `remarks` varchar(250) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `balance` decimal(10,2) NOT NULL,
  `trx_id` int(11) NOT NULL,
  `profile_no` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_supplier_balances`
--

INSERT INTO `tbl_supplier_balances` (`id`, `sup_id`, `created_date`, `remarks`, `amount`, `balance`, `trx_id`, `profile_no`) VALUES
(1, 4, '2024-07-25', 'Bill', '30.00', '30.00', 0, '19186974'),
(2, 4, '2024-07-25', 'Payment', '30.00', '0.00', 0, ''),
(3, 7, '2024-09-09', 'Bill - 5332', '50.00', '100.00', 33, ''),
(4, 7, '2024-09-09', 'Payment', '100.00', '0.00', 34, ''),
(5, 9, '2024-09-09', 'Bill(5256),biilka internet bisha 8aad', '30.00', '30.00', 35, ''),
(6, 9, '2024-09-09', 'Payment', '30.00', '0.00', 36, '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_supplier_invoices`
--

CREATE TABLE `tbl_supplier_invoices` (
  `inv_id` int(11) NOT NULL,
  `inv_no` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `inv_ref` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `balance` decimal(10,2) NOT NULL,
  `sup_id` int(11) NOT NULL,
  `ser_id` int(11) NOT NULL,
  `inv_status` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_id` int(11) NOT NULL,
  `account_exp_id` int(11) NOT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `site_id` int(11) DEFAULT NULL,
  `trx_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `inv_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_supplier_invoices`
--

INSERT INTO `tbl_supplier_invoices` (`inv_id`, `inv_no`, `inv_ref`, `amount`, `balance`, `sup_id`, `ser_id`, `inv_status`, `account_id`, `account_exp_id`, `remarks`, `site_id`, `trx_id`, `inv_date`) VALUES
(1, 'INV1', '5332', '30.00', '0.00', 4, 0, 'PAID', 0, 0, '', NULL, 'trx_id_014', '2024-07-25'),
(2, 'INV2', '5332', '5000.00', '5000.00', 6, 0, 'UNPAID', 0, 13, 'internetka bisha 11aad', NULL, '31', '2024-09-09'),
(3, 'INV3', '1236', '50.00', '50.00', 7, 0, 'UNPAID', 0, 22, '20 caag oo biyo ah', NULL, '32', '2024-09-09'),
(4, 'INV4', '5332', '50.00', '50.00', 7, 0, 'UNPAID', 0, 22, '20 caag oo biyo ah', NULL, '33', '2024-09-09'),
(5, 'INV5', '5256', '30.00', '30.00', 9, 0, 'UNPAID', 0, 21, 'biilka internet bisha 8aad', NULL, '35', '2024-09-09');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_supplier_payments`
--

CREATE TABLE `tbl_supplier_payments` (
  `pay_id` int(11) NOT NULL,
  `pay_amount` decimal(10,2) NOT NULL,
  `sup_id` int(11) NOT NULL,
  `inv_id` int(11) NOT NULL,
  `account_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pay_date` date NOT NULL,
  `pay_status` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trx_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_supplier_payments`
--

INSERT INTO `tbl_supplier_payments` (`pay_id`, `pay_amount`, `sup_id`, `inv_id`, `account_id`, `pay_date`, `pay_status`, `trx_id`) VALUES
(1, '30.00', 0, 1, 'account_id_043', '2024-07-25', '', 'trx_id_015'),
(2, '100.00', 7, 0, '14', '2024-09-09', '', '34'),
(3, '30.00', 9, 0, '14', '2024-09-09', '', '36');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_supplier_services`
--

CREATE TABLE `tbl_supplier_services` (
  `ser_id` int(11) NOT NULL,
  `ser_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ser_des` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_no` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ser_status` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reg_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_supplier_services`
--

INSERT INTO `tbl_supplier_services` (`ser_id`, `ser_name`, `ser_des`, `profile_no`, `ser_status`, `reg_date`) VALUES
(1, 'Cleaning', 'this is cleaning service', '0', 'Active', '2023-04-13'),
(2, 'Repairing', 'repairing service', '0', 'Active', '2023-04-17'),
(3, 'Electircity', 'electricity', '0', 'Active', '2023-04-26'),
(4, 'Biti cash', 'biti  cash', '0', 'Active', '2023-04-26'),
(5, 'water supply expense', 'water supply expense', '', 'Active', '2023-07-06'),
(6, 'Gas expenses', 'Gas expenses', '', 'Active', '2023-07-06');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tenant_alerts`
--

CREATE TABLE `tbl_tenant_alerts` (
  `tan_alert_id` int(11) NOT NULL,
  `agreement_id` int(11) NOT NULL,
  `alert` text NOT NULL,
  `tan_alert_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `user_id` int(11) NOT NULL,
  `ut_id` int(11) NOT NULL,
  `fullname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `passwd` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_tell` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_img` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_no` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `user_timestamp` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `companyId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`user_id`, `ut_id`, `fullname`, `user_name`, `passwd`, `user_tell`, `user_email`, `user_img`, `role`, `profile_no`, `user_status`, `user_timestamp`, `branch_id`, `companyId`) VALUES
(1, 1, 'Omar Haji', 'omar', '$2y$10$b4e92VOnXQQMhPs7yfu9N.XGkW7XX/84Jh1YMsfcxgy5Cx/1FKszG', '0613646438', 'omar@raed.so', '1700038298-RAED-1699968802-RAED-haji1.jpg', 'SuperAdmin', '162f3956', 'Active', '1681026638', 1, 1),
(2, 1, 'Aisha Sheikh Ahmed', 'aisha', '$2y$10$tqsPyIbfl5zs.3P8c.PAeOyi.1LmC1VM/nq0Y3sXdDSV0ixue.BXy', '61625259', 'casho@gmil.com', '1724571492-RAED-', 'Admin', NULL, 'Active', '1724571492', 2, 0),
(3, 1, 'Hassan Ibrahim', 'sudan', '$2y$10$ivtFTgjhYWmvh3zAQk2UQugUjyGo0UZdxvh.KMXxGuKHSI/a25v2G', '0618505050', 'sudab@gmail.com', '1724916782-RAED-', 'Admin', NULL, 'Active', '1724916782', 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_type`
--

CREATE TABLE `tbl_user_type` (
  `ut_id` int(11) NOT NULL,
  `uc_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `ut_name_en` varchar(35) COLLATE utf8_unicode_ci NOT NULL,
  `ut_name_ar` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `ut_des` text COLLATE utf8_unicode_ci NOT NULL,
  `ut_status` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Pending',
  `ut_timestamp` varchar(15) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_user_type`
--

INSERT INTO `tbl_user_type` (`ut_id`, `uc_id`, `ut_name_en`, `ut_name_ar`, `ut_des`, `ut_status`, `ut_timestamp`) VALUES
(1, '', 'Admin', 'مديرعام', 'system admin type', 'Active', '1684924652'),
(2, '', 'Cashier', '', 'cashier user type', 'Active', '1685178903'),
(3, '', 'Waiter', 'مديرعام', 'fsfs', 'Active', '1686385235'),
(4, '', 'HR', '', 'Yes', 'Active', '1686385257'),
(5, '', 'Receiption', '', 'Receiption', 'Active', '1687360298');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_utility_bills`
--

CREATE TABLE `tbl_utility_bills` (
  `ut_bill_id` int(11) NOT NULL,
  `bill_no` varchar(50) NOT NULL,
  `type_id` int(11) NOT NULL,
  `ten_id` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `balance` decimal(10,2) NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `bill_status` varchar(12) NOT NULL,
  `profile_no` varchar(20) NOT NULL,
  `trx_id` int(11) NOT NULL,
  `bill_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_utility_receipts`
--

CREATE TABLE `tbl_utility_receipts` (
  `receipt_id` int(11) NOT NULL,
  `ut_bill_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL,
  `account_id` varchar(100) NOT NULL,
  `trx_id` int(11) NOT NULL,
  `receipt_date` date NOT NULL,
  `rec_status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `vouchers`
--

CREATE TABLE `vouchers` (
  `id` int(11) NOT NULL,
  `voucher_type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `paid_to` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `paid_from` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refnum` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `curr_id` int(11) NOT NULL,
  `des` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  `staff` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_id` int(11) NOT NULL,
  `voucher_status` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vouchers`
--

INSERT INTO `vouchers` (`id`, `voucher_type`, `paid_to`, `amount`, `paid_from`, `refnum`, `curr_id`, `des`, `date`, `staff`, `branch_id`, `voucher_status`) VALUES
(1, 'PaymentVoucher', '13', '600.00', '3', '2563', 0, 'salary to ahmed cali ahmed', '2024-09-17 00:00:00', 'Omar Haji', 1, 'posted'),
(2, 'ReceiptVoucher', '3', '4182.30', '55', '1234', 0, 'dhigaal uu leehay Abdi Ahmed', '2024-09-17 00:00:00', 'Omar Haji', 1, 'posted');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `company_info`
--
ALTER TABLE `company_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_addr_country`
--
ALTER TABLE `tbl_addr_country`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_addr_regions`
--
ALTER TABLE `tbl_addr_regions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_advanced_payment`
--
ALTER TABLE `tbl_advanced_payment`
  ADD PRIMARY KEY (`adv_pay_id`);

--
-- Indexes for table `tbl_apartments`
--
ALTER TABLE `tbl_apartments`
  ADD PRIMARY KEY (`ap_id`);

--
-- Indexes for table `tbl_apartment_types`
--
ALTER TABLE `tbl_apartment_types`
  ADD PRIMARY KEY (`ap_type_id`);

--
-- Indexes for table `tbl_branches`
--
ALTER TABLE `tbl_branches`
  ADD PRIMARY KEY (`branch_id`);

--
-- Indexes for table `tbl_clients`
--
ALTER TABLE `tbl_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_client_profile`
--
ALTER TABLE `tbl_client_profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_cl_accounts`
--
ALTER TABLE `tbl_cl_accounts`
  ADD PRIMARY KEY (`account_id`);

--
-- Indexes for table `tbl_cl_account_groups`
--
ALTER TABLE `tbl_cl_account_groups`
  ADD PRIMARY KEY (`acc_grp_id`);

--
-- Indexes for table `tbl_cl_account_types`
--
ALTER TABLE `tbl_cl_account_types`
  ADD PRIMARY KEY (`acc_type_id`);

--
-- Indexes for table `tbl_cl_financial_period`
--
ALTER TABLE `tbl_cl_financial_period`
  ADD PRIMARY KEY (`fp_id`);

--
-- Indexes for table `tbl_cl_transections`
--
ALTER TABLE `tbl_cl_transections`
  ADD PRIMARY KEY (`trx_id`);

--
-- Indexes for table `tbl_cl_trans_details`
--
ALTER TABLE `tbl_cl_trans_details`
  ADD PRIMARY KEY (`trx_det_id`);

--
-- Indexes for table `tbl_customers`
--
ALTER TABLE `tbl_customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `tbl_customer_balances`
--
ALTER TABLE `tbl_customer_balances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_deposit`
--
ALTER TABLE `tbl_deposit`
  ADD PRIMARY KEY (`dep_id`);

--
-- Indexes for table `tbl_employees`
--
ALTER TABLE `tbl_employees`
  ADD PRIMARY KEY (`emp_id`);

--
-- Indexes for table `tbl_expenses`
--
ALTER TABLE `tbl_expenses`
  ADD PRIMARY KEY (`exp_id`);

--
-- Indexes for table `tbl_extras`
--
ALTER TABLE `tbl_extras`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_extra_features`
--
ALTER TABLE `tbl_extra_features`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_features`
--
ALTER TABLE `tbl_features`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_feature_tabs`
--
ALTER TABLE `tbl_feature_tabs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_floors`
--
ALTER TABLE `tbl_floors`
  ADD PRIMARY KEY (`floor_id`);

--
-- Indexes for table `tbl_jobs`
--
ALTER TABLE `tbl_jobs`
  ADD PRIMARY KEY (`job_id`);

--
-- Indexes for table `tbl_login`
--
ALTER TABLE `tbl_login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_menu`
--
ALTER TABLE `tbl_menu`
  ADD PRIMARY KEY (`tab_id`);

--
-- Indexes for table `tbl_menu_access`
--
ALTER TABLE `tbl_menu_access`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_meters`
--
ALTER TABLE `tbl_meters`
  ADD PRIMARY KEY (`meter_id`);

--
-- Indexes for table `tbl_packages`
--
ALTER TABLE `tbl_packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_rahan_document`
--
ALTER TABLE `tbl_rahan_document`
  ADD PRIMARY KEY (`rah_id`);

--
-- Indexes for table `tbl_rates`
--
ALTER TABLE `tbl_rates`
  ADD PRIMARY KEY (`rate_id`);

--
-- Indexes for table `tbl_reading`
--
ALTER TABLE `tbl_reading`
  ADD PRIMARY KEY (`reading_id`);

--
-- Indexes for table `tbl_ref_persons`
--
ALTER TABLE `tbl_ref_persons`
  ADD PRIMARY KEY (`ref_person_id`);

--
-- Indexes for table `tbl_relocation`
--
ALTER TABLE `tbl_relocation`
  ADD PRIMARY KEY (`relocation_id`);

--
-- Indexes for table `tbl_rentals`
--
ALTER TABLE `tbl_rentals`
  ADD PRIMARY KEY (`rental_id`),
  ADD KEY `ap_id` (`ap_id`),
  ADD KEY `ten_id` (`customer_id`);

--
-- Indexes for table `tbl_rental_bills`
--
ALTER TABLE `tbl_rental_bills`
  ADD PRIMARY KEY (`bill_id`);

--
-- Indexes for table `tbl_rental_bills_tracker`
--
ALTER TABLE `tbl_rental_bills_tracker`
  ADD PRIMARY KEY (`track_id`);

--
-- Indexes for table `tbl_rental_receipts`
--
ALTER TABLE `tbl_rental_receipts`
  ADD PRIMARY KEY (`receipt_id`);

--
-- Indexes for table `tbl_rental_termination`
--
ALTER TABLE `tbl_rental_termination`
  ADD PRIMARY KEY (`term_id`);

--
-- Indexes for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_salary`
--
ALTER TABLE `tbl_salary`
  ADD PRIMARY KEY (`salary_id`);

--
-- Indexes for table `tbl_sites`
--
ALTER TABLE `tbl_sites`
  ADD PRIMARY KEY (`site_id`);

--
-- Indexes for table `tbl_staff`
--
ALTER TABLE `tbl_staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_sub_users`
--
ALTER TABLE `tbl_sub_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_suppliers`
--
ALTER TABLE `tbl_suppliers`
  ADD PRIMARY KEY (`sup_id`);

--
-- Indexes for table `tbl_supplier_balances`
--
ALTER TABLE `tbl_supplier_balances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_supplier_invoices`
--
ALTER TABLE `tbl_supplier_invoices`
  ADD PRIMARY KEY (`inv_id`);

--
-- Indexes for table `tbl_supplier_payments`
--
ALTER TABLE `tbl_supplier_payments`
  ADD PRIMARY KEY (`pay_id`);

--
-- Indexes for table `tbl_supplier_services`
--
ALTER TABLE `tbl_supplier_services`
  ADD PRIMARY KEY (`ser_id`);

--
-- Indexes for table `tbl_tenant_alerts`
--
ALTER TABLE `tbl_tenant_alerts`
  ADD PRIMARY KEY (`tan_alert_id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `tbl_user_type`
--
ALTER TABLE `tbl_user_type`
  ADD PRIMARY KEY (`ut_id`);

--
-- Indexes for table `tbl_utility_bills`
--
ALTER TABLE `tbl_utility_bills`
  ADD PRIMARY KEY (`ut_bill_id`);

--
-- Indexes for table `tbl_utility_receipts`
--
ALTER TABLE `tbl_utility_receipts`
  ADD PRIMARY KEY (`receipt_id`);

--
-- Indexes for table `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `company_info`
--
ALTER TABLE `company_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_addr_country`
--
ALTER TABLE `tbl_addr_country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_addr_regions`
--
ALTER TABLE `tbl_addr_regions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_advanced_payment`
--
ALTER TABLE `tbl_advanced_payment`
  MODIFY `adv_pay_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_apartments`
--
ALTER TABLE `tbl_apartments`
  MODIFY `ap_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_apartment_types`
--
ALTER TABLE `tbl_apartment_types`
  MODIFY `ap_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_branches`
--
ALTER TABLE `tbl_branches`
  MODIFY `branch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_clients`
--
ALTER TABLE `tbl_clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbl_client_profile`
--
ALTER TABLE `tbl_client_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tbl_cl_accounts`
--
ALTER TABLE `tbl_cl_accounts`
  MODIFY `account_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `tbl_cl_account_groups`
--
ALTER TABLE `tbl_cl_account_groups`
  MODIFY `acc_grp_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_cl_account_types`
--
ALTER TABLE `tbl_cl_account_types`
  MODIFY `acc_type_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_cl_financial_period`
--
ALTER TABLE `tbl_cl_financial_period`
  MODIFY `fp_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_cl_transections`
--
ALTER TABLE `tbl_cl_transections`
  MODIFY `trx_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `tbl_cl_trans_details`
--
ALTER TABLE `tbl_cl_trans_details`
  MODIFY `trx_det_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT for table `tbl_customers`
--
ALTER TABLE `tbl_customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_customer_balances`
--
ALTER TABLE `tbl_customer_balances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_deposit`
--
ALTER TABLE `tbl_deposit`
  MODIFY `dep_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_employees`
--
ALTER TABLE `tbl_employees`
  MODIFY `emp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_expenses`
--
ALTER TABLE `tbl_expenses`
  MODIFY `exp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_extras`
--
ALTER TABLE `tbl_extras`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_extra_features`
--
ALTER TABLE `tbl_extra_features`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_features`
--
ALTER TABLE `tbl_features`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_feature_tabs`
--
ALTER TABLE `tbl_feature_tabs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_floors`
--
ALTER TABLE `tbl_floors`
  MODIFY `floor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_jobs`
--
ALTER TABLE `tbl_jobs`
  MODIFY `job_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_login`
--
ALTER TABLE `tbl_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `tbl_menu`
--
ALTER TABLE `tbl_menu`
  MODIFY `tab_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `tbl_menu_access`
--
ALTER TABLE `tbl_menu_access`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=850;

--
-- AUTO_INCREMENT for table `tbl_meters`
--
ALTER TABLE `tbl_meters`
  MODIFY `meter_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `tbl_packages`
--
ALTER TABLE `tbl_packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_rahan_document`
--
ALTER TABLE `tbl_rahan_document`
  MODIFY `rah_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_rates`
--
ALTER TABLE `tbl_rates`
  MODIFY `rate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_reading`
--
ALTER TABLE `tbl_reading`
  MODIFY `reading_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_ref_persons`
--
ALTER TABLE `tbl_ref_persons`
  MODIFY `ref_person_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_relocation`
--
ALTER TABLE `tbl_relocation`
  MODIFY `relocation_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_rentals`
--
ALTER TABLE `tbl_rentals`
  MODIFY `rental_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_rental_bills`
--
ALTER TABLE `tbl_rental_bills`
  MODIFY `bill_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_rental_bills_tracker`
--
ALTER TABLE `tbl_rental_bills_tracker`
  MODIFY `track_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_rental_receipts`
--
ALTER TABLE `tbl_rental_receipts`
  MODIFY `receipt_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_rental_termination`
--
ALTER TABLE `tbl_rental_termination`
  MODIFY `term_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_salary`
--
ALTER TABLE `tbl_salary`
  MODIFY `salary_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_sites`
--
ALTER TABLE `tbl_sites`
  MODIFY `site_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_suppliers`
--
ALTER TABLE `tbl_suppliers`
  MODIFY `sup_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_supplier_balances`
--
ALTER TABLE `tbl_supplier_balances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_supplier_invoices`
--
ALTER TABLE `tbl_supplier_invoices`
  MODIFY `inv_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_supplier_payments`
--
ALTER TABLE `tbl_supplier_payments`
  MODIFY `pay_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_supplier_services`
--
ALTER TABLE `tbl_supplier_services`
  MODIFY `ser_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_user_type`
--
ALTER TABLE `tbl_user_type`
  MODIFY `ut_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_utility_bills`
--
ALTER TABLE `tbl_utility_bills`
  MODIFY `ut_bill_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_utility_receipts`
--
ALTER TABLE `tbl_utility_receipts`
  MODIFY `receipt_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
