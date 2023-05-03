-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2023 at 06:35 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `database_by_pos`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart_item`
--

CREATE TABLE `cart_item` (
  `code` int(4) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัส',
  `quantity` int(100) NOT NULL COMMENT 'จำนวน',
  `price` int(100) NOT NULL COMMENT 'ราคา',
  `id_cart_item` int(2) UNSIGNED ZEROFILL NOT NULL COMMENT 'id',
  `order_code` int(5) UNSIGNED ZEROFILL NOT NULL COMMENT 'id_รายการสั่งซื้อ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cart_item`
--

INSERT INTO `cart_item` (`code`, `quantity`, `price`, `id_cart_item`, `order_code`) VALUES
(0003, 4, 50, 01, 00169),
(0002, 8, 10, 02, 00169),
(0006, 3, 60, 04, 00169),
(0007, 2, 10, 18, 00169),
(0002, 6, 10, 22, 00172),
(0004, 2, 60, 23, 00174),
(0002, 1, 10, 24, 00174),
(0004, 1, 60, 25, 00176),
(0006, 1, 60, 27, 00178),
(0002, 1, 10, 28, 00179),
(0006, 1, 60, 29, 00179),
(0005, 1, 50, 30, 00179),
(0004, 1, 60, 31, 00179),
(0004, 1, 60, 32, 00180),
(0004, 1, 60, 33, 00182),
(0005, 1, 50, 34, 00182),
(0003, 1, 50, 35, 00182),
(0004, 1, 60, 36, 00183),
(0003, 1, 50, 37, 00183),
(0006, 1, 60, 38, 00184),
(0005, 1, 50, 39, 00184),
(0004, 5, 60, 40, 00185),
(0003, 7, 50, 41, 00186),
(0006, 1, 60, 42, 00186);

-- --------------------------------------------------------

--
-- Table structure for table `category_food`
--

CREATE TABLE `category_food` (
  `food_category_code` int(4) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสหมวดอาหาร',
  `food_category_name` varchar(50) NOT NULL COMMENT 'ชื่อหมวดอาหาร'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category_food`
--

INSERT INTO `category_food` (`food_category_code`, `food_category_name`) VALUES
(0001, 'อาหารจานหลัก'),
(0002, 'อาหารทานเล่น'),
(0003, 'เครื่องดื่ม'),
(0004, 'ท็อปปิ้งอาหาร');

-- --------------------------------------------------------

--
-- Table structure for table `food_item`
--

CREATE TABLE `food_item` (
  `food_menu_code` int(4) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสเมนูอาหาร',
  `food_menu_name` varchar(100) NOT NULL COMMENT 'ชื่อเมนูอาหาร',
  `selling_price_food` int(10) NOT NULL COMMENT 'ราคาขาย',
  `category_food` int(4) UNSIGNED ZEROFILL NOT NULL COMMENT 'ประเภทอาหาร',
  `img` varchar(100) NOT NULL COMMENT 'ภาพอาหาร',
  `date_added` datetime NOT NULL COMMENT 'วันที่เพิ่มข้อมูล',
  `status` int(1) NOT NULL COMMENT 'สถานะ เช่น ยกเลิกเมนูหรือเมนูยังไม่พร้อม\r\n'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `food_item`
--

INSERT INTO `food_item` (`food_menu_code`, `food_menu_name`, `selling_price_food`, `category_food`, `img`, `date_added`, `status`) VALUES
(0002, 'ข้าว ', 10, 0001, 'pr_644a6979b942a.jpg', '0000-00-00 00:00:00', 1),
(0003, 'เกาเหลา [ ธรรมดา ]', 50, 0001, 'pr_63cccd027dbbb.jpg', '0000-00-00 00:00:00', 1),
(0004, 'เกาเหลา [ พิเศษ ]', 60, 0001, 'pr_63cccd2952d60.jpg', '0000-00-00 00:00:00', 1),
(0005, 'ก๊วยจั๊บ [ ธรรมดา ]', 50, 0001, 'pr_63cccd5c15535.jpg', '0000-00-00 00:00:00', 1),
(0006, 'ก๊วยจั๊บ [ พิเศษ]', 60, 0001, 'pr_63cccd83872c1.jpg', '0000-00-00 00:00:00', 1),
(0007, 'ไข่ต้ม', 10, 0004, 'pr_643bf09bd1e26.jpeg', '0000-00-00 00:00:00', 1),
(0008, 'หมูกรอบ', 10, 0004, 'pr_643bf0fa0868b.jpg', '0000-00-00 00:00:00', 1),
(0009, 'เลือด ', 10, 0004, 'pr_643c51a42d5f8.jpg', '0000-00-00 00:00:00', 1),
(0011, 'น้ำเก๊กฮวย ', 15, 0003, 'pr_644a89b666b4e.jpg', '2023-04-27 06:28:48', 1),
(0024, 'กระเพาะ ', 10, 0004, 'pr_644aa68534f97.jpg', '2023-04-27 09:40:24', 1);

-- --------------------------------------------------------

--
-- Table structure for table `history_in_out`
--

CREATE TABLE `history_in_out` (
  `id_history_in_out` int(4) UNSIGNED ZEROFILL NOT NULL COMMENT 'id การเข้า-ออก',
  `user_id` int(4) UNSIGNED ZEROFILL NOT NULL COMMENT 'id ผู้ใช้',
  `date_time_check-in` datetime DEFAULT NULL COMMENT 'วันที่/เวลา login',
  `date_time_check-out` datetime NOT NULL COMMENT 'วันที่/เวลา logout',
  `device` varchar(20) NOT NULL COMMENT 'อุปกรณ์'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `history_in_out`
--

INSERT INTO `history_in_out` (`id_history_in_out`, `user_id`, `date_time_check-in`, `date_time_check-out`, `device`) VALUES
(0001, 0001, '2023-04-17 09:29:03', '2023-04-17 10:01:05', ' computer'),
(0002, 0001, '2023-04-17 10:08:33', '0000-00-00 00:00:00', ' computer'),
(0003, 0001, '2023-04-17 10:28:18', '0000-00-00 00:00:00', ' computer'),
(0004, 0001, '2023-04-17 10:29:33', '0000-00-00 00:00:00', ' computer'),
(0005, 0001, '2023-04-18 01:49:40', '2023-04-18 01:58:21', ' computer'),
(0006, 0001, '2023-04-18 01:58:45', '2023-04-18 01:59:11', ' computer'),
(0007, 0001, '2023-04-18 02:00:25', '0000-00-00 00:00:00', ' computer'),
(0008, 0001, '2023-04-18 02:00:26', '0000-00-00 00:00:00', ' computer'),
(0009, 0001, '2023-04-18 02:00:26', '0000-00-00 00:00:00', ' Mobile'),
(0010, 0001, '2023-04-18 02:00:26', '0000-00-00 00:00:00', ' Tablet'),
(0011, 0001, '2023-04-18 02:00:26', '0000-00-00 00:00:00', ' Mobile'),
(0012, 0001, '2023-04-18 02:00:26', '2023-04-18 02:01:57', ' Mobile'),
(0013, 0001, '2023-04-18 02:02:16', '0000-00-00 00:00:00', ' computer'),
(0014, 0001, '2023-04-18 02:26:24', '0000-00-00 00:00:00', ' computer'),
(0015, 0001, '2023-04-18 02:27:03', '2023-04-18 10:00:04', ' computer'),
(0016, 0002, '2023-04-18 11:15:15', '2023-04-18 11:16:08', ' computer'),
(0017, 0002, '2023-04-18 11:16:16', '2023-04-18 11:37:55', ' computer'),
(0018, 0001, '2023-04-18 11:38:10', '0000-00-00 00:00:00', ' computer'),
(0019, 0002, '2023-04-18 11:45:09', '0000-00-00 00:00:00', ' computer'),
(0020, 0001, '2023-04-19 07:46:45', '0000-00-00 00:00:00', ' computer'),
(0021, 0001, '2023-04-19 07:47:28', '0000-00-00 00:00:00', ' computer'),
(0022, 0002, '2023-04-20 04:32:13', '0000-00-00 00:00:00', ' computer'),
(0023, 0001, '2023-04-21 12:24:18', '0000-00-00 00:00:00', ' computer'),
(0024, 0001, '2023-04-21 02:13:29', '0000-00-00 00:00:00', ' computer'),
(0025, 0001, '2023-04-21 04:23:34', '0000-00-00 00:00:00', ' computer'),
(0026, 0002, '2023-04-21 02:47:48', '0000-00-00 00:00:00', ' computer'),
(0027, 0002, '2023-04-22 11:46:26', '0000-00-00 00:00:00', ' computer'),
(0028, 0002, '2023-04-23 06:03:14', '0000-00-00 00:00:00', ' computer'),
(0029, 0002, '2023-04-24 07:13:40', '2023-04-24 09:47:29', ' computer'),
(0030, 0001, '2023-04-24 09:47:33', '0000-00-00 00:00:00', ' computer'),
(0031, 0001, '2023-04-24 09:55:21', '0000-00-00 00:00:00', ' computer'),
(0032, 0002, '2023-04-25 10:28:23', '2023-04-25 10:30:10', ' computer'),
(0033, 0001, '2023-04-25 10:30:14', '2023-04-25 01:27:17', ' computer'),
(0034, 0002, '2023-04-25 01:28:30', '2023-04-25 01:30:01', ' computer'),
(0035, 0001, '2023-04-25 01:30:06', '2023-04-25 01:32:32', ' computer'),
(0036, 0002, '2023-04-25 01:32:36', '2023-04-25 01:45:12', ' computer'),
(0037, 0001, '2023-04-25 01:35:54', '0000-00-00 00:00:00', ' computer'),
(0038, 0001, '2023-04-25 01:45:16', '2023-04-25 01:51:21', ' computer'),
(0039, 0002, '2023-04-25 01:51:29', '2023-04-26 01:26:11', ' computer'),
(0040, 0001, '2023-04-26 01:26:15', '0000-00-00 00:00:00', ' computer'),
(0041, 0001, '2023-04-26 04:03:35', '2023-04-26 04:41:22', ' computer'),
(0042, 0002, '2023-04-26 02:23:36', '0000-00-00 00:00:00', ' computer'),
(0043, 0001, '2023-04-26 02:31:28', '0000-00-00 00:00:00', ' computer'),
(0044, 0001, '2023-04-26 02:31:48', '0000-00-00 00:00:00', ' computer'),
(0045, 0002, '2023-04-26 04:46:21', '2023-04-26 04:49:00', ' computer'),
(0046, 0001, '2023-04-26 04:49:12', '0000-00-00 00:00:00', ' computer'),
(0047, 0002, '2023-04-26 08:12:06', '0000-00-00 00:00:00', ' computer'),
(0048, 0001, '2023-04-26 08:12:46', '0000-00-00 00:00:00', ' computer'),
(0049, 0002, '2023-04-27 03:04:51', '2023-04-27 03:17:29', ' computer'),
(0050, 0001, '2023-04-27 03:17:33', '0000-00-00 00:00:00', ' computer'),
(0051, 0001, '2023-04-27 07:54:13', '0000-00-00 00:00:00', ' computer'),
(0052, 0001, '2023-04-27 08:00:02', '2023-04-28 01:14:07', ' computer'),
(0053, 0002, '2023-04-28 01:14:15', '2023-04-28 01:20:04', ' computer'),
(0054, 0001, '2023-04-28 01:20:08', '2023-04-28 02:12:56', ' computer'),
(0055, 0001, '2023-04-28 02:13:01', '0000-00-00 00:00:00', ' computer'),
(0056, 0001, '2023-04-28 02:14:23', '0000-00-00 00:00:00', ' computer'),
(0057, 0001, '2023-04-28 03:55:41', '0000-00-00 00:00:00', ' computer'),
(0058, 0001, '2023-04-28 03:55:42', '2023-04-28 05:32:45', ' computer'),
(0059, 0002, '2023-04-30 05:43:59', '0000-00-00 00:00:00', ' computer'),
(0060, 0001, '2023-05-02 11:06:18', '2023-05-02 11:23:34', ' computer'),
(0061, 0001, '2023-05-02 12:34:48', '0000-00-00 00:00:00', ' computer'),
(0062, 0001, '2023-05-02 09:50:46', '0000-00-00 00:00:00', ' computer');

-- --------------------------------------------------------

--
-- Table structure for table `order_list`
--

CREATE TABLE `order_list` (
  `order_code` int(5) UNSIGNED NOT NULL COMMENT 'รหัสรายการสั่งอาหาร',
  `number_food_items` int(10) NOT NULL COMMENT 'จำนวนรายการอาหาร',
  `all_food_prices` int(100) NOT NULL COMMENT 'ยอดรวม',
  `date_time` datetime NOT NULL COMMENT 'วัน/เวลา สั่งอาหาร',
  `user_id` int(4) NOT NULL COMMENT 'id ผู้ใช้',
  `table_id` int(2) UNSIGNED ZEROFILL NOT NULL COMMENT 'id โต๊ะ',
  `id_payment_status` int(2) UNSIGNED ZEROFILL NOT NULL COMMENT 'id_สถานะการชำระเงิน'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_list`
--

INSERT INTO `order_list` (`order_code`, `number_food_items`, `all_food_prices`, `date_time`, `user_id`, `table_id`, `id_payment_status`) VALUES
(169, 17, 480, '2023-04-26 02:32:59', 1, 01, 01),
(171, 6, 140, '2023-04-26 02:35:38', 1, 02, 03),
(172, 6, 60, '2023-04-26 04:47:20', 2, 01, 01),
(174, 3, 130, '2023-04-26 08:13:24', 1, 02, 01),
(176, 1, 60, '2023-04-27 03:12:46', 2, 01, 01),
(177, 1, 50, '2023-04-28 01:15:35', 2, 01, 03),
(178, 1, 60, '2023-04-28 01:19:43', 2, 01, 01),
(179, 4, 180, '2023-04-28 01:21:05', 1, 01, 01),
(180, 1, 60, '2023-04-28 01:23:05', 1, 01, 01),
(182, 3, 160, '2023-05-02 11:06:46', 1, 10, 01),
(183, 2, 110, '2023-05-02 11:07:03', 1, 02, 01),
(184, 2, 110, '2023-05-02 11:07:20', 1, 10, 01),
(185, 5, 300, '2023-05-02 11:22:57', 1, 10, 01),
(186, 8, 410, '2023-05-02 04:28:09', 1, 01, 01);

-- --------------------------------------------------------

--
-- Table structure for table `payment_status`
--

CREATE TABLE `payment_status` (
  `id_payment_status` int(2) UNSIGNED ZEROFILL NOT NULL COMMENT 'id_สถานะ',
  `status` varchar(100) NOT NULL COMMENT 'สถานะการชำระเงิน'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `payment_status`
--

INSERT INTO `payment_status` (`id_payment_status`, `status`) VALUES
(01, 'ชำระเงินแล้ว'),
(02, 'รอชำระเงิน'),
(03, 'ยกเลิก');

-- --------------------------------------------------------

--
-- Table structure for table `pay_through`
--

CREATE TABLE `pay_through` (
  `id_pay_through` int(2) UNSIGNED NOT NULL COMMENT 'id_จ่ายผ่าน',
  `pay_through` varchar(10) NOT NULL COMMENT 'จ่ายผ่าน'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pay_through`
--

INSERT INTO `pay_through` (`id_pay_through`, `pay_through`) VALUES
(1, 'เงินสด'),
(2, 'qr code');

-- --------------------------------------------------------

--
-- Table structure for table `sales_history`
--

CREATE TABLE `sales_history` (
  `receipt` int(5) UNSIGNED ZEROFILL NOT NULL COMMENT 'เลขใบเสร็จ',
  `order_code` int(5) UNSIGNED NOT NULL COMMENT 'รหัสรายการสั่งซื้อ',
  `id_pay_through` int(2) UNSIGNED ZEROFILL NOT NULL COMMENT 'รหัสชำระเงินด้วย',
  `user_id` int(4) UNSIGNED ZEROFILL NOT NULL COMMENT 'id ผู้ใช้',
  `date_time` datetime NOT NULL COMMENT 'วันที่/เวลา ที่ออกใบเสร็จ',
  `all_food_prices` varchar(100) NOT NULL COMMENT 'ราคารวม'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sales_history`
--

INSERT INTO `sales_history` (`receipt`, `order_code`, `id_pay_through`, `user_id`, `date_time`, `all_food_prices`) VALUES
(00001, 169, 01, 0001, '2023-04-26 04:44:56', '480.00'),
(00002, 172, 01, 0002, '2023-04-26 04:48:40', '60.00'),
(00003, 174, 01, 0001, '2023-04-26 08:14:06', '130.00'),
(00004, 172, 01, 0002, '2023-04-27 03:12:33', '60.00'),
(00005, 176, 02, 0002, '2023-04-27 03:17:24', '60.00'),
(00006, 178, 01, 0001, '2023-04-28 01:20:33', '60.00'),
(00007, 179, 01, 0001, '2023-04-28 01:21:09', '180.00'),
(00008, 180, 02, 0001, '2023-04-28 01:23:09', '60.00'),
(00009, 182, 01, 0001, '2023-05-02 11:06:51', '160.00'),
(00010, 183, 01, 0001, '2023-05-02 11:07:09', '110.00'),
(00011, 184, 02, 0001, '2023-05-02 11:07:24', '110.00'),
(00012, 185, 01, 0001, '2023-05-02 04:16:27', '300.00'),
(00013, 186, 01, 0001, '2023-05-02 04:28:33', '410.00');

-- --------------------------------------------------------

--
-- Table structure for table `table_number`
--

CREATE TABLE `table_number` (
  `table_id` int(2) UNSIGNED ZEROFILL NOT NULL COMMENT 'id โตีะ',
  `status` int(2) NOT NULL COMMENT 'สถานะ [0=ว่าง , 1=ไม่ว่าง] ',
  `date_added` datetime NOT NULL COMMENT 'วันที่เพิ่ม',
  `number` int(2) UNSIGNED ZEROFILL NOT NULL COMMENT 'เลขโต๊ะ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `table_number`
--

INSERT INTO `table_number` (`table_id`, `status`, `date_added`, `number`) VALUES
(01, 0, '2023-03-31 10:28:11', 01),
(02, 0, '2023-03-31 10:28:31', 02),
(10, 0, '2023-04-25 02:55:30', 03);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(4) UNSIGNED ZEROFILL NOT NULL COMMENT 'id ผู้ใช้',
  `user_name` varchar(100) NOT NULL COMMENT 'ชื่อผู้ใช้',
  `password` varchar(100) NOT NULL COMMENT 'รหัสผ่าน',
  `phone` varchar(10) NOT NULL COMMENT 'เบอร์โทรศัพท์',
  `id_user_type` int(2) NOT NULL COMMENT 'ประเภทบัญชีผู้ใช้',
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `useredit` int(2) UNSIGNED ZEROFILL NOT NULL COMMENT 'การแก้ไขบัญชี 0 = ไม่เคยแก้ไข , 1 = เคยแก้ไข'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `password`, `phone`, `id_user_type`, `date_added`, `useredit`) VALUES
(0001, 'admin ', '$2y$10$b0K7pGlSG5TBrdFtUEA/YeY5Bg8F2IilrzfpCE0avmxfIfwxbJm4G', '0800000055', 1, '2023-04-18 09:00:20', 01),
(0002, 'kkk ', '$2y$10$oM4adLD2txy8PfbzVWRyX.fg7PDKB0WsS.mwowmY74u/GTh7GU1Ja', '0000000000', 2, '2023-04-18 08:57:45', 01),
(0005, 'chatchaya ', '$2y$10$FWQ9eAxY3AczwAQDT9FnkuclPH9pgVLEjdC1HLf0878FQ5aMe5LAG', '0809999999', 1, '2023-04-28 05:01:19', 00);

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `id_user_type` int(2) NOT NULL,
  `user_type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`id_user_type`, `user_type`) VALUES
(1, 'เจ้าของร้าน'),
(2, 'พนักงาน');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart_item`
--
ALTER TABLE `cart_item`
  ADD PRIMARY KEY (`id_cart_item`),
  ADD KEY `rrr` (`order_code`),
  ADD KEY `rrr2` (`code`);

--
-- Indexes for table `category_food`
--
ALTER TABLE `category_food`
  ADD PRIMARY KEY (`food_category_code`);

--
-- Indexes for table `food_item`
--
ALTER TABLE `food_item`
  ADD PRIMARY KEY (`food_menu_code`),
  ADD KEY `fk_2` (`category_food`);

--
-- Indexes for table `history_in_out`
--
ALTER TABLE `history_in_out`
  ADD PRIMARY KEY (`id_history_in_out`),
  ADD KEY `fk_3` (`user_id`);

--
-- Indexes for table `order_list`
--
ALTER TABLE `order_list`
  ADD PRIMARY KEY (`order_code`),
  ADD KEY `h` (`id_payment_status`),
  ADD KEY `fk_4` (`table_id`) USING BTREE;

--
-- Indexes for table `payment_status`
--
ALTER TABLE `payment_status`
  ADD PRIMARY KEY (`id_payment_status`);

--
-- Indexes for table `pay_through`
--
ALTER TABLE `pay_through`
  ADD PRIMARY KEY (`id_pay_through`);

--
-- Indexes for table `sales_history`
--
ALTER TABLE `sales_history`
  ADD PRIMARY KEY (`receipt`),
  ADD KEY `we` (`order_code`),
  ADD KEY `we2` (`user_id`),
  ADD KEY `we3` (`id_pay_through`);

--
-- Indexes for table `table_number`
--
ALTER TABLE `table_number`
  ADD PRIMARY KEY (`table_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `id_user_type` (`id_user_type`);

--
-- Indexes for table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`id_user_type`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart_item`
--
ALTER TABLE `cart_item`
  MODIFY `id_cart_item` int(2) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `category_food`
--
ALTER TABLE `category_food`
  MODIFY `food_category_code` int(4) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสหมวดอาหาร', AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `food_item`
--
ALTER TABLE `food_item`
  MODIFY `food_menu_code` int(4) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'รหัสเมนูอาหาร', AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `history_in_out`
--
ALTER TABLE `history_in_out`
  MODIFY `id_history_in_out` int(4) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'id การเข้า-ออก', AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `order_list`
--
ALTER TABLE `order_list`
  MODIFY `order_code` int(5) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'รหัสรายการสั่งอาหาร', AUTO_INCREMENT=188;

--
-- AUTO_INCREMENT for table `payment_status`
--
ALTER TABLE `payment_status`
  MODIFY `id_payment_status` int(2) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'id_สถานะ', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pay_through`
--
ALTER TABLE `pay_through`
  MODIFY `id_pay_through` int(2) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id_จ่ายผ่าน', AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sales_history`
--
ALTER TABLE `sales_history`
  MODIFY `receipt` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'เลขใบเสร็จ', AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `table_number`
--
ALTER TABLE `table_number`
  MODIFY `table_id` int(2) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'id โตีะ', AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(4) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'id ผู้ใช้', AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_item`
--
ALTER TABLE `cart_item`
  ADD CONSTRAINT `rrr` FOREIGN KEY (`order_code`) REFERENCES `order_list` (`order_code`) ON UPDATE CASCADE,
  ADD CONSTRAINT `rrr2` FOREIGN KEY (`code`) REFERENCES `food_item` (`food_menu_code`) ON UPDATE CASCADE;

--
-- Constraints for table `food_item`
--
ALTER TABLE `food_item`
  ADD CONSTRAINT `fk_2` FOREIGN KEY (`category_food`) REFERENCES `category_food` (`food_category_code`) ON UPDATE CASCADE;

--
-- Constraints for table `history_in_out`
--
ALTER TABLE `history_in_out`
  ADD CONSTRAINT `fk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `order_list`
--
ALTER TABLE `order_list`
  ADD CONSTRAINT `h` FOREIGN KEY (`id_payment_status`) REFERENCES `payment_status` (`id_payment_status`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tt` FOREIGN KEY (`table_id`) REFERENCES `table_number` (`table_id`) ON UPDATE CASCADE;

--
-- Constraints for table `sales_history`
--
ALTER TABLE `sales_history`
  ADD CONSTRAINT `we` FOREIGN KEY (`order_code`) REFERENCES `order_list` (`order_code`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `we2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `we3` FOREIGN KEY (`id_pay_through`) REFERENCES `pay_through` (`id_pay_through`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_user_type`) REFERENCES `user_type` (`id_user_type`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
