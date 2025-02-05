-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2024 at 11:56 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `delivery`
--

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `id_branch` int(11) NOT NULL,
  `name_branch` varchar(50) DEFAULT NULL,
  `address_branch` varchar(100) NOT NULL,
  `phone_bransh` varchar(100) NOT NULL,
  `branch_status` int(5) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`id_branch`, `name_branch`, `address_branch`, `phone_bransh`, `branch_status`) VALUES
(1, 'فرع إب', 'شارع العدين', '7758', 1),
(2, 'فرع صنعاء', 'حدةs', '778', 1),
(3, 'فرع الدمام', 'شارع 26', '', 1),
(4, 'إدارة الفروع', 'يستعرض كل بيانات النظام ', '', 2);

-- --------------------------------------------------------

--
-- Table structure for table `currency_tab`
--

CREATE TABLE `currency_tab` (
  `id_currency` int(11) NOT NULL,
  `name_currency` varchar(30) NOT NULL,
  `nic_currency` varchar(30) NOT NULL,
  `status_currency` int(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `currency_tab`
--

INSERT INTO `currency_tab` (`id_currency`, `name_currency`, `nic_currency`, `status_currency`) VALUES
(7, 'ريال سعودي', '112211', 1);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id_customer` int(11) NOT NULL,
  `cus_name` varchar(100) NOT NULL,
  `cus_phone` varchar(100) NOT NULL,
  `cus_id_card` varchar(100) DEFAULT NULL,
  `cus_card_img` text DEFAULT '1.png',
  `cus_whatsapp` varchar(100) DEFAULT NULL,
  `cus_type` varchar(20) NOT NULL,
  `cus_address` varchar(200) DEFAULT NULL,
  `cus_note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id_customer`, `cus_name`, `cus_phone`, `cus_id_card`, `cus_card_img`, `cus_whatsapp`, `cus_type`, `cus_address`, `cus_note`) VALUES
(1, 'osamah', '775662462', '11212141251', '1.jpg', '775662462', '1', 'ibb', NULL),
(2, 'سامي', '32', '', '1.png', '', '1', 'tr', ''),
(3, 'سامي', '11', '', '_1731624242.png', '', '1', 'tr', ''),
(4, '22', '432', '23', '_1731624323.png', '33333333', '1', '', '333333333333'),
(5, 'u1', '67', '', '1.png', '', '1', '', ''),
(6, 'u2', '3', '333333333333', '_1731624624.png', '33', '1', '', '33'),
(7, 'u3', '55', '34444444444', '55_1731624764.png', '43', '1', '', '33'),
(8, 'u4', '6543', '11', '6543_1731624961.png', '1', '1', '', '2'),
(9, '23', '33', '', '1.png', '', '1', '', ''),
(10, 'wer', '43', '', '1.png', '', '1', '', ''),
(11, 'sfs', '453', '', '', '', '2', 'sfs', '345'),
(12, 'v', '243', '', '', '', '2', '', ''),
(13, 'dsv', '234', '', '', '', '2', 'erw', ''),
(14, 'as', '24', '', '1.png', '', '1', '', ''),
(15, '6', '5', '', '', '', '2', '', ''),
(16, '34', '34', '', '1.png', '', '1', '', ''),
(17, '5t4', '55', '', '', '', '2', '', ''),
(18, 'سامي', '701073397', '1121211', '1.png', '2212', '1', '', '12312'),
(19, 'dsv', '73397874', '', '', '', '2', 'sfs', 'trert4'),
(20, 'سامي', '121', '21', '1.png', '12', '1', '', '22'),
(21, 'dsv', '1223', '', '', '', '2', 'sfs', '123'),
(22, 'سامي', '12', '123', '1.png', '123', '1', '', '2'),
(23, 'v', '123', '', '', '', '2', '231', '345'),
(24, '', '0', '', '1.png', '', '1', '', ''),
(25, '', '0', '', '', '', '2', '', ''),
(26, 'سامي', '775662462', '12313', '1.png', '1231', '1', '', '1231'),
(27, 'dsv', '123', '112233', '1.png', '', '2', '32', '21'),
(28, 'سامي', '775662462', '12313', '1.png', '1231', '1', '', '1231'),
(29, 'سامي', '775662462', '12313', '1.png', '1231', '1', '', '1231'),
(30, 'سامي', '775662462', '12313', '1.png', '1231', '1', '', '1231'),
(31, 'سامي', '775662462', '12313', '1.png', '1231', '1', '', '1231'),
(32, 'سامي', '775662462', '12313', '1.png', '1231', '1', '', '1231'),
(33, 'سامي', '775662462', '12313', '1.png', '1231', '1', '', '1231'),
(34, 'سامي', '775662462', '12313', '1.png', '1231', '1', '', '1231'),
(35, 'osamh', '123', '', '', '', '2', '32', '21'),
(36, '', '0', '', '1.png', '', '1', '', ''),
(37, '', '0', '', '', '', '2', '', ''),
(38, 'qq', '2342', '12313', '1.png', '1231', '1', '', ''),
(39, 'qwe', '342', '', '', '', '2', '234', '234'),
(40, 'سامي', '123', '1', '1.png', '32', '1', '', '21'),
(41, '1212', '123', '', '', '', '2', '32', '21'),
(42, 'ee', '123', '23424223', '123_1733080841.png', '', '2', '32', '0'),
(43, '1111111', '123', '', '', '', '2', '32', '21'),
(44, 'شسش', '123', '', '', '', '2', '32', '21'),
(45, '2222', '123', '', '', '', '2', '32', '21'),
(46, '2342', '6723', '0', '6723_1732231739.png', '', '1', '', ''),
(47, 'سامي', '775662462', '0', '1.png', '', '1', '', ''),
(48, 'osamh', '775662462', '0', '', '', '2', '68', '68ا'),
(49, 'سامي', '775662462', '0', '1.png', '', '1', '', ''),
(50, 'osamh', '775662462', '0', '', '', '2', '68', '68ا'),
(51, 'سامي', '775662462', '345', '1.png', '', '1', '', ''),
(52, 'qwe', '345', '0', '', '', '2', '345', '345'),
(53, 'abood', '776452830', '15010022336', '1.png', '852000000', '1', '', ''),
(54, 'ossamah', '774345357', '0', '', '', '2', 'ibb', ''),
(55, 'علي', '4454', '0', '1.png', '', '1', '', ''),
(56, 'سلمان', '77858', '0', '', '', '2', '', ''),
(57, 'حسن', '7898', '4454', '7898_1733095195.png', '223251', '1', '', '11111'),
(58, 'رشيد', '71141', '0', '', '', '2', 'مين', ''),
(59, 'u4', '225', '45465', '1.png', '', '1', '', ''),
(60, '87', '78', '0', '', '', '2', '', ''),
(61, 'v45y', '456', '0', '1.png', '', '1', '', ''),
(62, '456', '6557', '0', '', '', '2', '', ''),
(63, 'سامي', '0775662462', '345', '1.png', '', '1', '', ''),
(64, 'سامي', '345', '345', '1.png', '68', '1', '', '345'),
(65, 'علي الدوكري', '7652', '0', '1.png', '', '1', '', ''),
(66, 'منير الاعمش', '44525', '0', '', '', '2', '', ''),
(67, 'محمد عبدالله ناجي', '714', '0', '1.png', '', '1', '', ''),
(68, 'جابر عبدالله ', '77847', '0', '', '', '2', '', ''),
(69, 'jkh', '11', '0', '', '', '2', '', ''),
(70, '', '', '0', '1.png', '', '1', '', ''),
(71, 'جابر', '47', '0131231', '_1734034454.png', '23442142', '2', 'sdarfr', 'حححححححح'),
(72, '1', '1', '1', '1_1733446077.png', '1', '1', '', '1'),
(73, '23e', '232', '0', '', '', '2', '', ''),
(74, 'ali', '1121', '0', '', '', '2', '142', ''),
(75, '414', '112', '0', '', '', '2', '', ''),
(76, 'r34', '2342', '0', '', '', '2', 'ewr', '23424');

-- --------------------------------------------------------

--
-- Table structure for table `edit_mess`
--

CREATE TABLE `edit_mess` (
  `id_edit_mess` int(11) NOT NULL,
  `fk_id_user_edit_mess` int(11) NOT NULL,
  `fk_order_edit_mess` int(11) NOT NULL,
  `date_edit_edit_mess` date NOT NULL DEFAULT current_timestamp(),
  `why_edit_mess` text NOT NULL,
  `what_edit_mess` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs_table`
--

CREATE TABLE `jobs_table` (
  `job_id` int(11) NOT NULL,
  `job_name` varchar(100) NOT NULL,
  `job_details` text DEFAULT NULL,
  `job_note` text NOT NULL,
  `status` int(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobs_table`
--

INSERT INTO `jobs_table` (`job_id`, `job_name`, `job_details`, `job_note`, `status`) VALUES
(1, 'مدير', 'm', '', 1),
(2, 'مدخل بيانات', NULL, '', 1),
(3, 'سائق', NULL, '', 2),
(4, 'حمال', NULL, '', 1),
(14, 'رقابة', '1', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `level_mess`
--

CREATE TABLE `level_mess` (
  `id_level_mess` int(5) NOT NULL,
  `name_level_mess` varchar(30) NOT NULL,
  `small_class` varchar(100) NOT NULL DEFAULT 'right badge badge',
  `icon_status` varchar(100) NOT NULL DEFAULT 'nav-icon far fa-envelope',
  `close_small` varchar(100) NOT NULL DEFAULT '</small>',
  `close_icon` varchar(100) NOT NULL DEFAULT '</i>'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `level_mess`
--

INSERT INTO `level_mess` (`id_level_mess`, `name_level_mess`, `small_class`, `icon_status`, `close_small`, `close_icon`) VALUES
(1, 'بمكتب الإرسال', '<small class=\"badge badge-secondary\">', '<i class=\"icon fas fa-home\">', '</small>', '</i>'),
(2, 'مسلم للسائق', '<small class=\"right badge badge-dark\">', '<i class=\"fas fa-ambulance\">', '</small>', '</i>'),
(3, 'في الطريق', '<small class=\"badge badge-primary\">', '<i class=\"icon fas fa-truck\">', '</small>', '</i>'),
(4, 'مسلم لموظف التسلم', '<small class=\"badge badge-warning\" >', '<i class=\"nav-icon far fa-enve\">', '</small>', '</i>'),
(5, 'في مكتب التسليم', '<small class=\"badge badge-info\">', '<i class=\"icon fas fa-building\">', '</small>', '</i>'),
(6, 'مكتمل', '<small class=\"right badge-success\">', '<i class=\"nav-icon far fa-envelope\">', '</small>', '</i>'),
(7, 'مكتمل', '<small class=\"badge badge-success\">', '<i class=\"icon fas fa-check\">', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `mess_type`
--

CREATE TABLE `mess_type` (
  `id_mess` int(11) NOT NULL,
  `name_mess` varchar(30) NOT NULL,
  `mess_type_details` text DEFAULT 'لاشيئ',
  `status_mess` int(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mess_type`
--

INSERT INTO `mess_type` (`id_mess`, `name_mess`, `mess_type_details`, `status_mess`) VALUES
(1, 'ضرف', 'كرتوني', 1),
(2, 'صندوق', 'صندوق كرتوني او بلاستيك', 1);

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id_order` int(11) NOT NULL,
  `gov` varchar(30) NOT NULL,
  `custom_id_sender` int(11) NOT NULL,
  `custom_id_recipient` int(11) DEFAULT 0,
  `money_received` decimal(10,2) NOT NULL DEFAULT 0.00,
  `check_receipt_sender` int(5) NOT NULL DEFAULT 0,
  `ch_ex_us_fri` int(5) NOT NULL DEFAULT 0,
  `ch_ex_dri_sec` int(5) NOT NULL DEFAULT 0,
  `check_export` int(5) NOT NULL DEFAULT 0,
  `ch_imp_dri_fri` int(5) NOT NULL DEFAULT 0,
  `ch_imp_us_sec` int(5) NOT NULL DEFAULT 0,
  `check_import` int(5) NOT NULL DEFAULT 0,
  `check_receipt_recipient` int(5) NOT NULL DEFAULT 0,
  `user_id_receipt_sender` int(11) DEFAULT 0,
  `user_id__export` int(11) DEFAULT 0,
  `user_id__import` int(11) DEFAULT 0,
  `user_id__receipt_recipient` int(11) DEFAULT 0,
  `verify_message` int(5) NOT NULL DEFAULT 0,
  `fk_id_branch_sender` int(11) NOT NULL DEFAULT 0,
  `fk_id_branch_recipient` int(11) NOT NULL,
  `order_note` varchar(500) NOT NULL DEFAULT 'لاشيئ',
  `order_not_recipient` varchar(500) DEFAULT NULL,
  `receive_image_sender` text NOT NULL,
  `receive_image_recipient` varchar(255) NOT NULL,
  `QR` text NOT NULL,
  `fk_level_mess` int(5) NOT NULL DEFAULT 1,
  `money_honesty` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status_order` int(5) NOT NULL DEFAULT 1,
  `fk_id_driver` int(11) NOT NULL DEFAULT 0,
  `date_of_receipt_sender` date NOT NULL DEFAULT current_timestamp(),
  `date_export` date DEFAULT NULL,
  `date_import` date DEFAULT NULL,
  `date_of_receipt_recipient` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id_order`, `gov`, `custom_id_sender`, `custom_id_recipient`, `money_received`, `check_receipt_sender`, `ch_ex_us_fri`, `ch_ex_dri_sec`, `check_export`, `ch_imp_dri_fri`, `ch_imp_us_sec`, `check_import`, `check_receipt_recipient`, `user_id_receipt_sender`, `user_id__export`, `user_id__import`, `user_id__receipt_recipient`, `verify_message`, `fk_id_branch_sender`, `fk_id_branch_recipient`, `order_note`, `order_not_recipient`, `receive_image_sender`, `receive_image_recipient`, `QR`, `fk_level_mess`, `money_honesty`, `status_order`, `fk_id_driver`, `date_of_receipt_sender`, `date_export`, `date_import`, `date_of_receipt_recipient`) VALUES
(13, '', 1, 1, 0.00, 1, 0, 0, 0, 0, 0, 0, 0, 11, 0, NULL, NULL, 1, 2, 1, '', NULL, '13_1687808524.jpeg', '13_1688400888.jpg', '0', 1, 0.00, 1, 0, '2024-10-16', NULL, NULL, NULL),
(107, '', 65, 66, 0.00, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 13, 0, 1, 2, 3, '', NULL, '7652_1733155618.png', '', '10704286500696', 5, 0.00, 2, 12, '2024-12-02', '2024-12-02', '2024-12-02', NULL),
(108, '1', 67, 68, 420.00, 1, 1, 1, 1, 0, 0, 0, 0, 1, 1, 0, 0, 1, 2, 1, '', NULL, '', '', '10801004095205', 3, 0.00, 1, 0, '2024-12-06', '2024-12-06', NULL, NULL),
(109, 'تعز', 67, 71, 5900.00, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 10, 1, 1, 1, 2, 'حححححححح', '', '714_1733437229.png', '1.png', '10904120351460', 6, 1500.00, 1, 12, '2024-12-06', '2024-12-07', '2024-12-12', '2024-12-16'),
(110, 'jl', 72, 76, 400.23, 1, 1, 0, 0, 0, 0, 0, 0, 1, NULL, 0, 0, 1, 2, 1, '', NULL, '2342_1733450615.png', '', '11001463438749', 1, 0.00, 1, 12, '2024-12-07', '2024-12-07', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_item`
--

CREATE TABLE `order_item` (
  `id_item_order` int(11) NOT NULL,
  `fk_order` int(11) NOT NULL,
  `item_type` varchar(30) NOT NULL,
  `weight_item` decimal(10,3) DEFAULT NULL,
  `cost_message` decimal(10,2) NOT NULL,
  `item_details` text NOT NULL,
  `item_statue` int(5) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_item`
--

INSERT INTO `order_item` (`id_item_order`, `fk_order`, `item_type`, `weight_item`, `cost_message`, `item_details`, `item_statue`) VALUES
(212, 25, '1', 1.000, 21.00, 'e', 1),
(216, 25, '1', 3.000, 34.00, '', 1),
(217, 28, '1', 0.000, 12.00, '', 1),
(218, 28, '1', 2.000, 23.00, '', 1),
(219, 28, '1', 5.000, 34.00, '', 1),
(220, 28, '1', 12.000, 2.00, '', 1),
(221, 29, '1', 23.000, 90.00, '', 1),
(222, 30, '0', 0.000, 343.00, '', 1),
(223, 30, '0', 0.000, 34.00, '', 1),
(224, 34, '1', 22.000, 12.00, '123', 1),
(225, 35, '1', 22.000, 12.00, '123', 1),
(226, 36, '1', 22.000, 12.00, '123', 1),
(227, 38, '1', 22.000, 12.00, '123', 1),
(228, 39, '1', 22.000, 12.00, '123', 1),
(229, 40, '1', 22.000, 12.00, '123', 1),
(230, 41, '1', 22.000, 12.00, '123', 1),
(231, 32, '1', 22.000, 12.00, '123', 1),
(232, 43, '1', 22.000, 12.00, '123', 1),
(233, 44, '1', 22.000, 12.00, '123', 1),
(234, 45, '1', 32.000, 1.00, '123', 1),
(235, 40, '1', 32.000, 1.00, '123', 1),
(236, 32, '1', 3.000, 3.00, '0', 1),
(237, 32, '1', 78.000, 78.00, '787', 1),
(238, 33, '1', 3.000, 435.50, '345', 1),
(239, 33, '1', 456.000, 565.15, '456', 1),
(240, 37, '1', 32.000, 1.00, '123', 1),
(241, 46, '1', 2.000, 12.00, '12', 1),
(242, 47, '1', 32.000, 1.00, '123', 1),
(243, 48, '1', 234.000, 234.00, '324', 1),
(244, 49, '1', 234.000, 234.00, '324', 1),
(245, 49, '1', 12.000, 23.00, '12', 1),
(246, 50, '1', 345.000, 345.00, '345', 1),
(247, 51, '1', 5.000, 600.00, '2', 1),
(248, 51, '1', 2.000, 5.00, '', 1),
(249, 52, '1', 45.500, 400.50, '', 1),
(256, 59, '1', 456.000, 456.00, '', 1),
(257, 60, '1', 456.000, 456.00, '', 1),
(260, 63, '1', 456.000, 456.00, '', 1),
(261, 64, '1', 456.000, 456.00, '', 1),
(262, 65, '1', 456.000, 456.00, '', 1),
(263, 66, '1', 456.000, 456.00, '', 1),
(264, 67, '1', 456.000, 456.00, '', 1),
(265, 68, '1', 456.000, 456.00, '', 1),
(266, 70, '1', 456.000, 456.00, '', 1),
(267, 71, '1', 456.000, 456.00, '', 1),
(268, 72, '1', 456.000, 456.00, '', 1),
(269, 73, '1', 45.000, 34.00, '', 1),
(270, 74, '1', 45.000, 34.00, '', 1),
(271, 75, '1', 45.000, 34.00, '', 1),
(272, 76, '1', 45.000, 34.00, '', 1),
(273, 77, '1', 45.000, 34.00, '', 1),
(274, 78, '1', 45.000, 34.00, '', 1),
(275, 79, '1', 45.000, 34.00, '', 1),
(276, 80, '1', 345.000, 1.00, '2', 1),
(277, 81, '1', 345.000, 1.00, '2', 1),
(278, 82, '1', 345.000, 1.00, '2', 1),
(279, 83, '1', 345.000, 1.00, '2', 1),
(280, 84, '1', 345.000, 1.00, '2', 1),
(281, 85, '1', 345.000, 1.00, '2', 1),
(282, 86, '1', 345.000, 1.00, '2', 1),
(283, 87, '1', 345.000, 1.00, '2', 1),
(284, 88, '1', 345.000, 1.00, '2', 1),
(285, 89, '1', 345.000, 1.00, '2', 1),
(288, 92, '1', 345.000, 1.00, '2', 1),
(289, 93, '1', 345.000, 1.00, '2', 1),
(290, 94, '1', 345.000, 1.00, '2', 1),
(291, 95, '1', 345.000, 1.00, '2', 1),
(292, 96, '1', 345.000, 1.00, '2', 1),
(293, 97, '1', 345.000, 1.00, '2', 1),
(294, 98, '1', 345.000, 1.00, '2', 1),
(295, 99, '1', 345.000, 1.00, '2', 1),
(296, 100, '1', 345.000, 1.00, '2', 1),
(297, 101, '1', 345.000, 1.00, '2', 1),
(298, 102, '1', 345.000, 1.00, '2', 1),
(299, 103, '1', 345.000, 1.00, '2', 1),
(300, 104, '1', 345.000, 1.00, '2', 1),
(301, 105, '1', 345.000, 1.00, '2', 1),
(302, 106, '1', 345.000, 1.00, '2', 1),
(303, 107, '1', 5.000, 50.00, '', 1),
(304, 107, '1', 10.000, 100.00, '', 1),
(306, 109, '1', 1.000, 100.00, 'هنت', 1),
(307, 110, '1', 1.000, 112.00, '2', 1),
(309, 110, '2', 2.000, 7.00, '747', 1),
(310, 110, '1', 1.000, 474.00, '7787', 1),
(311, 108, '2', 1.000, 142.20, 'liji', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id_page` int(11) NOT NULL,
  `sort` int(5) NOT NULL,
  `link` text NOT NULL,
  `name_page` varchar(100) NOT NULL,
  `icon_page` varchar(50) NOT NULL,
  `page_details` text DEFAULT NULL,
  `page_status` int(50) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id_page`, `sort`, `link`, `name_page`, `icon_page`, `page_details`, `page_status`) VALUES
(1, 8, 'kiji', 'إدارة المستخدمين', 'nav-icon fas fa-user-plus', 'إدارة المستخدمين', 1),
(5, 9, 'llokikl', 'إدارة الصلاحيات', 'nav-icon fas fa-lock', 'إدارة الصلاحيات', 1),
(8, 1, 'llop', 'إضافة رسالة', 'nav-icon fas fa-edit', 'إضافة طلب', 1),
(14, 10, 'nnnnnkug', 'بيانات الشركة', 'icon fas fa-building', 'بيانات الشركة', 1),
(15, 3, 'mnjghhhg', 'استلام الشحنات', 'fas fa-link', 'استلام الشحنات', 1),
(16, 2, 'mklkj', 'تصدير الشحنات', 'fab fa-telegram-plane fa-lg', 'تصدير الشحنات', 1),
(17, 4, 'nnjnmmnh', 'تسليم الرسائل', 'icon fas fa-check', 'تسليم الرسائل', 1),
(18, 7, 'kkiji', 'إدارة الرسائل', 'fas fa-th-large', 'إدارة الرسائل', 1),
(19, 5, 'kjhksje', 'إستلام الرسائل-سائقين', 'fas fa-truck', 'إستلام الرسائل-سائقين', 1),
(20, 6, 'llkmkj', 'تسليم الرسائل-سائق', 'fas fa-truck', 'تسليم الرسائل-سائق', 1),
(21, 11, 'ljkhsfew7uh', 'تقارير بحسب', 'fas fa-truck', 'إيجاد تقارير بحسب الموظفين ام الفروع', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pages_permission`
--

CREATE TABLE `pages_permission` (
  `id_u_p` int(11) NOT NULL,
  `fk_user_id` int(11) NOT NULL,
  `fk_page_id` int(11) NOT NULL,
  `user_pages_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pages_permission`
--

INSERT INTO `pages_permission` (`id_u_p`, `fk_user_id`, `fk_page_id`, `user_pages_status`) VALUES
(1, 10, 1, 1),
(2, 1, 1, 1),
(3, 1, 5, 1),
(4, 1, 0, 0),
(5, 1, 2, 1),
(6, 1, 3, 1),
(7, 1, 4, 1),
(8, 1, 6, 1),
(9, 1, 7, 1),
(10, 1, 8, 1),
(11, 1, 9, 1),
(12, 1, 10, 1),
(13, 1, 11, 1),
(14, 1, 12, 1),
(15, 1, 13, 1),
(16, 1, 14, 1),
(17, 1, 15, 1),
(18, 1, 16, 1),
(19, 1, 17, 1),
(20, 1, 18, 1),
(21, 8, 1, 1),
(22, 8, 5, 1),
(23, 10, 5, 1),
(24, 10, 8, 1),
(25, 9, 8, 1),
(26, 8, 8, 1),
(27, 11, 1, 1),
(28, 11, 5, 1),
(29, 11, 8, 1),
(30, 11, 14, 1),
(31, 11, 15, 1),
(32, 11, 16, 1),
(33, 11, 17, 1),
(34, 11, 18, 1),
(35, 10, 14, 1),
(36, 1, 19, 1),
(37, 1, 20, 1),
(38, 12, 19, 1),
(39, 12, 20, 1),
(40, 13, 5, 1),
(42, 13, 1, 1),
(43, 13, 8, 1),
(44, 13, 14, 1),
(45, 13, 15, 1),
(46, 13, 16, 1),
(47, 13, 17, 1),
(48, 13, 18, 1),
(49, 13, 19, 1),
(50, 13, 20, 1),
(51, 9, 1, 1),
(52, 9, 5, 1),
(53, 1, 21, 1),
(54, 11, 21, 1),
(55, 8, 21, 1),
(56, 8, 18, 1),
(57, 8, 17, 1),
(58, 8, 16, 1),
(59, 8, 15, 1),
(60, 8, 14, 1),
(61, 8, 19, 1),
(62, 8, 20, 1),
(63, 10, 20, 1),
(64, 10, 17, 1),
(65, 10, 15, 1),
(66, 10, 16, 1),
(67, 10, 18, 1),
(68, 10, 19, 1),
(69, 10, 21, 1);

-- --------------------------------------------------------

--
-- Table structure for table `shipping`
--

CREATE TABLE `shipping` (
  `id_ship` int(11) NOT NULL,
  `fk_order` int(11) NOT NULL,
  `fk_user` int(11) NOT NULL,
  `cost_ship` double DEFAULT NULL,
  `address_ship` varchar(250) DEFAULT NULL,
  `date_export` date NOT NULL DEFAULT current_timestamp(),
  `statue_ship` int(5) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shipping`
--

INSERT INTO `shipping` (`id_ship`, `fk_order`, `fk_user`, `cost_ship`, `address_ship`, `date_export`, `statue_ship`) VALUES
(1, 14, 1, 4000, 'اب ميتم ', '2023-06-15', 1),
(2, 15, 1, 2, '2', '2023-06-15', 1),
(3, 16, 1, 2, '2', '2023-06-15', 1),
(4, 17, 1, 3000, 'اب ميتم ', '2023-06-17', 1),
(5, 18, 1, 74, ';km', '2023-06-16', 1),
(6, 19, 1, 1992, 'kk', '2023-06-16', 1),
(7, 20, 1, 2000, '457', '2023-06-19', 1),
(8, 21, 2, 2000, 'اب ميتم ', '2023-06-19', 1),
(9, 22, 2, 500, 'اب ميتم ', '2023-06-22', 1),
(10, 23, 1, 1200, 'aa', '2024-02-08', 1),
(11, 24, 1, 78, '234r3', '0000-00-00', 1),
(12, 37, 1, 1, NULL, '2024-11-27', 1),
(13, 51, 12, 605, NULL, '2024-12-01', 1),
(14, 107, 12, 150, NULL, '2024-12-02', 1),
(15, 108, 12, 142.2, NULL, '2024-12-07', 1),
(16, 109, 12, 100, NULL, '2024-12-07', 1);

-- --------------------------------------------------------

--
-- Table structure for table `size_items`
--

CREATE TABLE `size_items` (
  `id_size_items` int(11) NOT NULL,
  `name_size` varchar(100) NOT NULL,
  `detiles_size` text NOT NULL DEFAULT 'لايوجد',
  `size_statues` int(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `size_items`
--

INSERT INTO `size_items` (`id_size_items`, `name_size`, `detiles_size`, `size_statues`) VALUES
(1, 'صغيرl', 'حجم صغيرs', 1),
(2, 'متوسط', 'حجم متوسط', 1);

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `id_system` int(11) NOT NULL,
  `name_system` varchar(100) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `phon_number` varchar(100) NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `icon_system` varchar(100) DEFAULT '1.jpg',
  `whatsapp` varchar(50) NOT NULL DEFAULT '+967775662462',
  `telegram` varchar(50) NOT NULL DEFAULT '+967775662462',
  `website_system` varchar(255) DEFAULT NULL,
  `instagram` varchar(50) NOT NULL DEFAULT '#',
  `facebook` varchar(100) NOT NULL DEFAULT '#',
  `twitter` varchar(100) NOT NULL DEFAULT '#',
  `linkedin` varchar(100) NOT NULL DEFAULT '#',
  `about_system` varchar(1000) NOT NULL,
  `updata_date` varchar(100) NOT NULL DEFAULT current_timestamp(),
  `fk_user_chang` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id_system`, `name_system`, `Email`, `phon_number`, `address`, `icon_system`, `whatsapp`, `telegram`, `website_system`, `instagram`, `facebook`, `twitter`, `linkedin`, `about_system`, `updata_date`, `fk_user_chang`) VALUES
(1, 'شركة البركه للنقل الدولي', 'albarka@gmail.com', '', '', '1_1731188805.jpg', '', '', '', '', '', '', '', '', '2024-12-07 02:05:27', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `name` varchar(500) NOT NULL,
  `user_phone` varchar(100) DEFAULT NULL,
  `email_user` varchar(200) NOT NULL,
  `password_user` varchar(200) NOT NULL,
  `img_user` text NOT NULL DEFAULT '1.png',
  `user_job` int(2) NOT NULL,
  `details_job` text DEFAULT NULL,
  `user_note` text DEFAULT NULL,
  `fk_branch` int(2) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `name`, `user_phone`, `email_user`, `password_user`, `img_user`, `user_job`, `details_job`, `user_note`, `fk_branch`, `status`) VALUES
(1, 'اسامه شحره', '7010', 'osamah.shahra@gmail.com', '$2y$10$tAHdHcBnKZLljLxgKTJ56.BEDRZGjW2FNp0W5oGB.AnRY412XK1JO', '1_1731108700.png', 1, '34aaaa', '1111', 2, 1),
(8, 'mkkkk', '777778', 'mml@gmail.com', '$2y$10$cP8xts3FGfoesVy9EBEm0OruShBVxK5HHFuea7F.cYZMIxQPKjp2m', '1.png', 4, 'ssssssss777777777', '5555555555', 3, 1),
(9, 'Akram ', '774614', 'aa@gmail.com', '$2y$10$FOIM.MQ1RH243Wi10E3QZecQU7utaZEL1w7quNCIIUbuysZyHtYzq', '1.png', 2, '', '0', 2, 2),
(10, 'Anas', '7738', 'anas@gmail.com', '$2y$10$hviqRPSQ2149FG7pZQ3lPOS4Y.zh2jE47DI2wW802MoOUCVnO8Zfi', '1.png', 4, '', '0', 1, 1),
(11, 'عبدالخالق', '776452830', 'abdulkhalk@gmail.com', '$2y$10$BKoN9Xwl5Ykhz3a6tGK3EuH0c8CTDNj3y.z8HR1VSA0NIaYv2NaGe', '1.png', 1, '778', '778', 2, 1),
(12, 'القاهر', '776452830', 'adibb@gmail.com', '$2y$10$SfOfmyr5N1eLy20EfFHR8OjRnBRr4GudQarJ1ZglEk8FNDglqatle', '1.png', 3, 'driver', '', 1, 1),
(13, 'صلاح ', '2', 'slalh@gmail.com', '$2y$10$7dHCw1GWLZ/MycpsHlV8M.VyknMc99Om2fkv6unt2XE1bnTVQlnbS', '1.png', 1, '', '', 3, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`id_branch`);

--
-- Indexes for table `currency_tab`
--
ALTER TABLE `currency_tab`
  ADD PRIMARY KEY (`id_currency`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id_customer`);

--
-- Indexes for table `edit_mess`
--
ALTER TABLE `edit_mess`
  ADD PRIMARY KEY (`id_edit_mess`);

--
-- Indexes for table `jobs_table`
--
ALTER TABLE `jobs_table`
  ADD PRIMARY KEY (`job_id`);

--
-- Indexes for table `level_mess`
--
ALTER TABLE `level_mess`
  ADD PRIMARY KEY (`id_level_mess`);

--
-- Indexes for table `mess_type`
--
ALTER TABLE `mess_type`
  ADD PRIMARY KEY (`id_mess`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id_order`);

--
-- Indexes for table `order_item`
--
ALTER TABLE `order_item`
  ADD PRIMARY KEY (`id_item_order`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id_page`);

--
-- Indexes for table `pages_permission`
--
ALTER TABLE `pages_permission`
  ADD PRIMARY KEY (`id_u_p`);

--
-- Indexes for table `shipping`
--
ALTER TABLE `shipping`
  ADD PRIMARY KEY (`id_ship`);

--
-- Indexes for table `size_items`
--
ALTER TABLE `size_items`
  ADD PRIMARY KEY (`id_size_items`);

--
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
  ADD PRIMARY KEY (`id_system`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `id_branch` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `currency_tab`
--
ALTER TABLE `currency_tab`
  MODIFY `id_currency` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id_customer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `edit_mess`
--
ALTER TABLE `edit_mess`
  MODIFY `id_edit_mess` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs_table`
--
ALTER TABLE `jobs_table`
  MODIFY `job_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `level_mess`
--
ALTER TABLE `level_mess`
  MODIFY `id_level_mess` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `mess_type`
--
ALTER TABLE `mess_type`
  MODIFY `id_mess` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id_order` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `order_item`
--
ALTER TABLE `order_item`
  MODIFY `id_item_order` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=312;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id_page` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `pages_permission`
--
ALTER TABLE `pages_permission`
  MODIFY `id_u_p` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `shipping`
--
ALTER TABLE `shipping`
  MODIFY `id_ship` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `size_items`
--
ALTER TABLE `size_items`
  MODIFY `id_size_items` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id_system` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
