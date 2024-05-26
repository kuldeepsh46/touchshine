-- phpMyAdmin SQL Dump
-- version 4.9.11
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 25, 2023 at 06:23 PM
-- Server version: 5.7.41
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `khilaadi_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_gateway`
--

CREATE TABLE `tb_gateway` (
  `id` int(11) NOT NULL,
  `signup_fee` int(11) NOT NULL,
  `gateway_upiuid` varchar(255) NOT NULL,
  `gateway_secret` varchar(255) NOT NULL,
  `gateway_key` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_gateway`
--

INSERT INTO `tb_gateway` (`id`, `signup_fee`, `gateway_upiuid`, `gateway_secret`, `gateway_key`) VALUES
(1, 1, 'payssxwu@paytm', 'UAeGs0VT3', '829b95-a7f7e1-2sb1-525255-1ccbd5');

-- --------------------------------------------------------

--
-- Table structure for table `tb_partner`
--

CREATE TABLE `tb_partner` (
  `id` int(11) NOT NULL,
  `uid_token` varchar(50) NOT NULL,
  `type` int(11) NOT NULL,
  `login_id` varchar(20) NOT NULL,
  `login_pwd` varchar(200) NOT NULL,
  `login_otp` varchar(12) NOT NULL,
  `name` varchar(100) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `mobile` varchar(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pan_no` varchar(10) NOT NULL,
  `uid_no` varchar(12) NOT NULL,
  `balance` varchar(100) NOT NULL,
  `token` varchar(100) NOT NULL,
  `secret` varchar(100) NOT NULL,
  `txn_status_webhook` varchar(255) NOT NULL,
  `slab` int(11) NOT NULL,
  `upi_id` varchar(50) NOT NULL,
  `device` longtext NOT NULL,
  `upis` longtext NOT NULL,
  `paytm_business` longtext,
  `paytm_active` int(11) NOT NULL DEFAULT '0',
  `settle_account` mediumtext NOT NULL,
  `upi_active` int(11) NOT NULL,
  `status` varchar(10) NOT NULL,
  `payid` varchar(255) DEFAULT NULL,
  `password_bckup` varchar(255) DEFAULT NULL,
  `start_date` varchar(255) DEFAULT NULL,
  `expire_date` varchar(255) DEFAULT NULL,
  `trial_done` varchar(255) NOT NULL DEFAULT '0',
  `plan_txn_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_partner`
--

INSERT INTO `tb_partner` (`id`, `uid_token`, `type`, `login_id`, `login_pwd`, `login_otp`, `name`, `company_name`, `mobile`, `email`, `pan_no`, `uid_no`, `balance`, `token`, `secret`, `txn_status_webhook`, `slab`, `upi_id`, `device`, `upis`, `paytm_business`, `paytm_active`, `settle_account`, `upi_active`, `status`, `payid`, `password_bckup`, `start_date`, `expire_date`, `trial_done`, `plan_txn_id`) VALUES
(268, '', 1, 'ADMIN', '$2y$10$pNho/32eNwxCy8yW.RYALexWM774DntRZvm216j9DE5stT8iY0xGa', 'gMnjzcAw', 'test', 'test', '1234567890', 'test@gmail.com', 'RJDPS1193P', '123123123124', '', '', '', '', 3, '', '', '', NULL, 0, '{\"account_no\":\"asdad\",\"beneficiary_name\":\"nortaxas\",\"ifsc\":\"asd\"}', 0, 'active', '', 'RJDPS1193P', NULL, NULL, '0', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_settings`
--

CREATE TABLE `tb_settings` (
  `id` int(11) NOT NULL,
  `socket` varchar(10) NOT NULL,
  `base_url` varchar(200) NOT NULL,
  `company_name` varchar(200) NOT NULL,
  `company_account` mediumtext NOT NULL,
  `company_logo` varchar(255) NOT NULL,
  `app_logo` text NOT NULL,
  `company_about` mediumtext NOT NULL,
  `web_fav` varchar(255) NOT NULL,
  `web_tag` text NOT NULL,
  `web_rights` varchar(200) NOT NULL,
  `support` mediumtext NOT NULL,
  `slab_id` int(11) NOT NULL,
  `upi_prefix` varchar(50) NOT NULL,
  `upi_bank` varchar(100) NOT NULL,
  `hypto_token` varchar(200) NOT NULL,
  `authorization` varchar(255) NOT NULL,
  `smsapi` longtext NOT NULL,
  `app_link` text NOT NULL,
  `live_chat` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `notification` longtext NOT NULL,
  `uid` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_settings`
--

INSERT INTO `tb_settings` (`id`, `socket`, `base_url`, `company_name`, `company_account`, `company_logo`, `app_logo`, `company_about`, `web_fav`, `web_tag`, `web_rights`, `support`, `slab_id`, `upi_prefix`, `upi_bank`, `hypto_token`, `authorization`, `smsapi`, `app_link`, `live_chat`, `notification`, `uid`, `status`) VALUES
(1, 'https://', 'upifast.in', 'UPI PG', '{\"account\":\"91700000000\",\"name\":\"test\",\"ifsc\":\"PYTM0123456 ( UPI / IMPS / NEFT )\"}', 'logo-removebg-preview.png', '', 'Bengaluru Karnataka', 'https://upifast.in/public/uploads/all/62U9RiWsTLJDFPye4O0ox7gVOqRpv6wLbR3cIgLx.gif', 'UpiFast - Get Instant Settlement with 0 % MDR Fee', 'UpiFast', '{\"mobile\":\"5395001134\",\"mobile1\":\"5395001134\",\"email\":\"admin@apise.in\"}', 3, 'multipe', 'upi@upi', 'NA', 'NA', '{\"username\":\"https://smsapi/login.php?msgid=2\",\"password\":\"https://smsapi/login.php?msgid=2\",\"smsurl\":\"https://smsapi/login.php?msgid=2\"}', 'http://upifast.in/images/brand.png', '<script>\n (function () {\n var options = {\n whatsapp: \"5395991134\", // WhatsApp number\n call_to_action: \"WhtsApp Support\", // Call to action\n position: \"right\", // Position may be \'right\' or \'left\'\n };\n var proto = document.location.protocol, host = \"whatshelp.io\", url = proto + \"//static.\" + host;\n var s = document.createElement(\'script\'); s.type = \'text/javascript\'; s.async = true; s.src = url + \'/widget-send-button/js/init.js\';\n s.onload = function () { WhWidgetSendButton.init(host, proto, options); };\n var x = document.getElementsByTagName(\'script\')[0]; x.parentNode.insertBefore(s, x);\n })();\n</script>', '<h2><span class=\"marker\"><strong>LifeTime Offer Plan Price: 5000&nbsp;Only</strong></span></h2>\r\n', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_slab`
--

CREATE TABLE `tb_slab` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `upi` varchar(50) NOT NULL,
  `van` varchar(50) NOT NULL,
  `imps` varchar(100) NOT NULL,
  `neft` varchar(100) NOT NULL,
  `uid` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_slab`
--

INSERT INTO `tb_slab` (`id`, `name`, `upi`, `van`, `imps`, `neft`, `uid`, `status`) VALUES
(3, 'Default', '0.50', '0.50', '{\"slab1\":\"2.50\",\"slab2\":\"4.30\",\"slab3\":\"8.95\"}', '{\"slab1\":\"3.60\",\"slab2\":\"3.60\",\"slab3\":\"3.60\"}', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_transactions`
--

CREATE TABLE `tb_transactions` (
  `id` int(11) NOT NULL,
  `token` varchar(100) NOT NULL,
  `user_uid` int(11) NOT NULL,
  `order_id` varchar(50) NOT NULL,
  `client_orderid` varchar(200) NOT NULL,
  `date` date NOT NULL,
  `time` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `mode` varchar(50) NOT NULL,
  `pay_upi` varchar(100) NOT NULL,
  `upi_id` varchar(100) NOT NULL,
  `rrn` varchar(100) NOT NULL,
  `txn_amount` varchar(100) NOT NULL,
  `fees` varchar(100) NOT NULL,
  `settle_amount` varchar(100) NOT NULL,
  `closing_balance` varchar(100) NOT NULL,
  `txn_type` varchar(20) NOT NULL,
  `remark` text NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_transactions`
--

INSERT INTO `tb_transactions` (`id`, `token`, `user_uid`, `order_id`, `client_orderid`, `date`, `time`, `type`, `mode`, `pay_upi`, `upi_id`, `rrn`, `txn_amount`, `fees`, `settle_amount`, `closing_balance`, `txn_type`, `remark`, `status`) VALUES
(3, '', 249, 'U3ncfuA1hH', '', '2023-02-08', '11:13:22 AM', 'Received - Admin', 'DCA', '917800152849', 'GDZPM8799A', '1675835002', '5000', '0', '5000', '5012', 'CREDIT', 'Admin', 'COMPLETED');

-- --------------------------------------------------------

--
-- Table structure for table `tb_upis`
--

CREATE TABLE `tb_upis` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `upi_uid` int(11) NOT NULL,
  `upi_id` varchar(100) NOT NULL,
  `upi_name` varchar(200) NOT NULL,
  `pan` varchar(10) NOT NULL,
  `category` varchar(100) NOT NULL,
  `address` varchar(200) NOT NULL,
  `date` varchar(50) NOT NULL,
  `time` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_upis`
--

INSERT INTO `tb_upis` (`id`, `uid`, `upi_uid`, `upi_id`, `upi_name`, `pan`, `category`, `address`, `date`, `time`, `status`) VALUES
(14, 1, 45545, 'nn@upi', 'fdgfd', 'HXsdssdsd2', 'Restaurants', 'ADDRESS', '2023-02-18', '02:42:57 AM', 'PENDING');

-- --------------------------------------------------------

--
-- Table structure for table `tb_virtualtxn`
--

CREATE TABLE `tb_virtualtxn` (
  `id` int(11) NOT NULL,
  `credited_at` varchar(100) NOT NULL,
  `bene_account_no` varchar(200) NOT NULL,
  `bene_account_ifsc` varchar(200) NOT NULL,
  `rmtr_full_name` varchar(200) NOT NULL,
  `rmtr_account_no` varchar(200) NOT NULL,
  `rmtr_account_ifsc` varchar(50) NOT NULL,
  `rmtr_to_bene_note` varchar(255) NOT NULL,
  `txn_id` varchar(200) NOT NULL,
  `amount` varchar(200) NOT NULL,
  `charges_gst` varchar(200) NOT NULL,
  `settled_amount` varchar(200) NOT NULL,
  `txn_time` varchar(100) NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `payment_type` varchar(50) NOT NULL,
  `bank_ref_num` varchar(50) NOT NULL,
  `results` longtext,
  `client_orderid` varchar(100) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_virtualtxn`
--

INSERT INTO `tb_virtualtxn` (`id`, `credited_at`, `bene_account_no`, `bene_account_ifsc`, `rmtr_full_name`, `rmtr_account_no`, `rmtr_account_ifsc`, `rmtr_to_bene_note`, `txn_id`, `amount`, `charges_gst`, `settled_amount`, `txn_time`, `created_at`, `payment_type`, `bank_ref_num`, `results`, `client_orderid`, `user_id`) VALUES
(75, '2023-02-16 04:23:53', 's@paytm', 'W3EGUVYEs676501592', 'nfjf@mail.com', '4358764587 - 88171676501591', 'Txn Success', 'Payment received from name', '1676501633', '1.00', '0', '1.00', '2023-02-16 04:23:41.0', '2023-02-16 04:23:41.0', 'UPI', '304775593756', '{\"TXNID\":\"20230216010350000832833673962710483\",\"BANKTXNID\":\"304775593756\",\"ORDERID\":\"W3EGUVYEej1676501592\",\"TXNAMOUNT\":\"1.00\",\"STATUS\":\"TXN_SUCCESS\",\"TXNTYPE\":\"SALE\",\"GATEWAYNAME\":\"PPBL\",\"RESPCODE\":\"01\",\"RESPMSG\":\"Txn Success\",\"MID\":\"idVKUA69203033163757\",\"PAYMENTMODE\":\"UPI\",\"REFUNDAMT\":\"0.0\",\"TXNDATE\":\"2023-02-16 04:23:41.0\",\"currentTxnCount\":\"1\"}', '88171676501591', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_gateway`
--
ALTER TABLE `tb_gateway`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_partner`
--
ALTER TABLE `tb_partner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_settings`
--
ALTER TABLE `tb_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_slab`
--
ALTER TABLE `tb_slab`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_transactions`
--
ALTER TABLE `tb_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_upis`
--
ALTER TABLE `tb_upis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_virtualtxn`
--
ALTER TABLE `tb_virtualtxn`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_partner`
--
ALTER TABLE `tb_partner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=270;

--
-- AUTO_INCREMENT for table `tb_settings`
--
ALTER TABLE `tb_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_slab`
--
ALTER TABLE `tb_slab`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_transactions`
--
ALTER TABLE `tb_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_upis`
--
ALTER TABLE `tb_upis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tb_virtualtxn`
--
ALTER TABLE `tb_virtualtxn`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
