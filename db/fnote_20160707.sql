-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2016 年 7 月 07 日 11:18
-- サーバのバージョン： 10.1.13-MariaDB
-- PHP Version: 7.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fnote`
--
CREATE DATABASE IF NOT EXISTS `fnote` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `fnote`;

-- --------------------------------------------------------

--
-- テーブルの構造 `ci_sessions`
--

DROP TABLE IF EXISTS `ci_sessions`;
CREATE TABLE `ci_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `mb_account`
--

DROP TABLE IF EXISTS `mb_account`;
CREATE TABLE `mb_account` (
  `ac_seq` int(11) UNSIGNED NOT NULL,
  `ac_status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `ac_type` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `ac_id` varchar(50) NOT NULL,
  `ac_pw` varchar(255) NOT NULL,
  `ac_department` varchar(50) DEFAULT NULL,
  `ac_name01` varchar(20) NOT NULL,
  `ac_name02` varchar(20) NOT NULL,
  `ac_tel` varchar(15) DEFAULT NULL,
  `ac_mobile` varchar(15) DEFAULT NULL,
  `ac_mail` varchar(100) NOT NULL,
  `ac_auth` varchar(25) DEFAULT NULL,
  `ac_lastlogin` datetime DEFAULT NULL,
  `ac_create_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `ac_update_date` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `mb_client`
--

DROP TABLE IF EXISTS `mb_client`;
CREATE TABLE `mb_client` (
  `cl_seq` int(10) UNSIGNED NOT NULL,
  `cl_status` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `cl_sales_id` int(10) UNSIGNED NOT NULL,
  `cl_editor_id` int(10) UNSIGNED NOT NULL,
  `cl_contract_str` date DEFAULT NULL,
  `cl_contract_end` date DEFAULT NULL,
  `cl_plan` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `cl_siteid` varchar(20) NOT NULL,
  `cl_id` varchar(20) NOT NULL,
  `cl_pw` varchar(255) NOT NULL,
  `cl_company` varchar(50) NOT NULL,
  `cl_president01` varchar(50) NOT NULL,
  `cl_president02` varchar(50) NOT NULL,
  `cl_department` varchar(50) DEFAULT NULL,
  `cl_person01` varchar(20) NOT NULL,
  `cl_person02` varchar(20) NOT NULL,
  `cl_tel` varchar(15) NOT NULL,
  `cl_mobile` varchar(15) DEFAULT NULL,
  `cl_fax` varchar(15) DEFAULT NULL,
  `cl_mail` varchar(100) NOT NULL,
  `cl_mailsub` varchar(100) DEFAULT NULL,
  `cl_auth` varchar(25) DEFAULT NULL,
  `cl_create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cl_update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `tb_contact`
--

DROP TABLE IF EXISTS `tb_contact`;
CREATE TABLE `tb_contact` (
  `co_seq` int(10) UNSIGNED NOT NULL,
  `co_status` tinyint(3) UNSIGNED NOT NULL,
  `co_cl_siteid` varchar(20) NOT NULL,
  `co_contact_name` varchar(100) NOT NULL,
  `co_contact_body` text NOT NULL,
  `co_contact_tel` int(15) NOT NULL,
  `co_contact_mail` varchar(255) NOT NULL,
  `co_create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `co_update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `tb_entry`
--

DROP TABLE IF EXISTS `tb_entry`;
CREATE TABLE `tb_entry` (
  `en_seq` int(10) UNSIGNED NOT NULL,
  `en_cl_siteid` varchar(20) NOT NULL,
  `en_title01` varchar(100) NOT NULL,
  `en_body01` text NOT NULL,
  `en_description01` text NOT NULL,
  `en_length01` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `en_title02` varchar(100) DEFAULT NULL,
  `en_body02` text,
  `en_description02` text,
  `en_length02` int(11) NOT NULL DEFAULT '0',
  `en_entry_tags` varchar(255) DEFAULT NULL,
  `en_cate01` smallint(5) UNSIGNED DEFAULT NULL,
  `en_cate02` smallint(5) UNSIGNED DEFAULT NULL,
  `en_cate03` smallint(5) UNSIGNED DEFAULT NULL,
  `en_shopname` varchar(100) NOT NULL,
  `en_shopname_sub` varchar(100) DEFAULT NULL,
  `en_url` varchar(255) DEFAULT NULL,
  `en_zip01` smallint(5) UNSIGNED NOT NULL,
  `en_zip02` smallint(5) UNSIGNED NOT NULL,
  `en_pref` tinyint(3) UNSIGNED NOT NULL,
  `en_addr01` varchar(100) NOT NULL,
  `en_addr02` varchar(100) DEFAULT NULL,
  `en_buil` varchar(100) DEFAULT NULL,
  `en_tel` varchar(15) DEFAULT NULL,
  `en_mail` varchar(100) DEFAULT NULL,
  `en_opentime` text,
  `en_holiday` text,
  `en_since` varchar(50) DEFAULT NULL,
  `en_parking` text,
  `en_seat` text,
  `en_card` text,
  `en_access` text,
  `en_access_sub` text,
  `en_contents01` text,
  `en_contents02` text,
  `en_sns01` text,
  `en_sns02` text,
  `en_sns03` text,
  `en_sns04` text,
  `en_sns05` text,
  `en_free01` text,
  `en_free02` text,
  `en_free03` text,
  `en_free04` text,
  `en_free05` text,
  `en_auth` varchar(25) DEFAULT NULL,
  `en_posting_date` datetime DEFAULT NULL,
  `en_create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `en_update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `tb_image`
--

DROP TABLE IF EXISTS `tb_image`;
CREATE TABLE `tb_image` (
  `im_seq` int(10) NOT NULL,
  `im_type` varchar(3) NOT NULL,
  `im_size` int(10) NOT NULL,
  `im_width` int(5) NOT NULL,
  `im_height` int(5) NOT NULL,
  `im_cl_siteid` varchar(20) NOT NULL,
  `im_owner` int(1) NOT NULL,
  `im_is_header` int(1) NOT NULL,
  `im_description` varchar(255) NOT NULL,
  `im_is_photolist` int(1) NOT NULL,
  `im_display_order` int(3) NOT NULL,
  `im_create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `im_update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `tb_log`
--

DROP TABLE IF EXISTS `tb_log`;
CREATE TABLE `tb_log` (
  `lg_seq` int(10) NOT NULL,
  `lg_user_type` varchar(10) NOT NULL,
  `lg_user_id` varchar(100) NOT NULL,
  `lg_cl_siteid` varchar(20) NOT NULL,
  `lg_type` varchar(35) NOT NULL,
  `lg_detail` text NOT NULL,
  `lg_ip` varchar(39) NOT NULL,
  `lg_create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lg_update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `tb_mail_tpl`
--

DROP TABLE IF EXISTS `tb_mail_tpl`;
CREATE TABLE `tb_mail_tpl` (
  `mt_id` tinyint(3) UNSIGNED NOT NULL COMMENT 'テンプレID',
  `mt_title` varchar(100) NOT NULL COMMENT 'テンプレタイトル',
  `mt_subject` varchar(100) NOT NULL COMMENT 'メール件名',
  `mt_body` text COMMENT 'メール本文',
  `mt_from` varchar(50) DEFAULT NULL COMMENT 'メールfrom',
  `mt_from_name` varchar(50) DEFAULT NULL COMMENT 'メールfrom名称',
  `mt_to` varchar(100) DEFAULT NULL COMMENT 'メールto',
  `mt_cc` varchar(100) DEFAULT NULL COMMENT 'メールcc',
  `mt_bcc` varchar(50) DEFAULT NULL COMMENT 'メールbcc',
  `mt_del_flg` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '削除フラグ',
  `mt_creator_id` int(10) UNSIGNED DEFAULT NULL COMMENT '作成者ID',
  `mt_create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '作成日時',
  `mt_update_date` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='メールテンプレート情報';

-- --------------------------------------------------------

--
-- テーブルの構造 `tb_revision`
--

DROP TABLE IF EXISTS `tb_revision`;
CREATE TABLE `tb_revision` (
  `rv_seq` int(10) NOT NULL,
  `rv_cl_siteid` varchar(20) NOT NULL,
  `rv_entry_title` varchar(100) NOT NULL,
  `rv_entry_body` text NOT NULL,
  `rv_entry_description` text NOT NULL,
  `rv_entry_tags` varchar(255) NOT NULL,
  `rv_length` int(5) NOT NULL,
  `rv_create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `rv_update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `mb_account`
--
ALTER TABLE `mb_account`
  ADD PRIMARY KEY (`ac_seq`),
  ADD UNIQUE KEY `ac_mail` (`ac_mail`),
  ADD UNIQUE KEY `ac_id` (`ac_id`);

--
-- Indexes for table `mb_client`
--
ALTER TABLE `mb_client`
  ADD UNIQUE KEY `cl_seq` (`cl_seq`),
  ADD UNIQUE KEY `cl_clientid_2` (`cl_siteid`),
  ADD UNIQUE KEY `cl_id_2` (`cl_id`),
  ADD KEY `cl_clientid` (`cl_siteid`),
  ADD KEY `cl_id` (`cl_id`),
  ADD KEY `cl_seq_2` (`cl_seq`);

--
-- Indexes for table `tb_contact`
--
ALTER TABLE `tb_contact`
  ADD PRIMARY KEY (`co_seq`),
  ADD KEY `client_id` (`co_cl_siteid`),
  ADD KEY `status` (`co_status`);

--
-- Indexes for table `tb_image`
--
ALTER TABLE `tb_image`
  ADD PRIMARY KEY (`im_seq`),
  ADD KEY `client_id` (`im_cl_siteid`);

--
-- Indexes for table `tb_log`
--
ALTER TABLE `tb_log`
  ADD PRIMARY KEY (`lg_seq`);

--
-- Indexes for table `tb_mail_tpl`
--
ALTER TABLE `tb_mail_tpl`
  ADD PRIMARY KEY (`mt_id`);

--
-- Indexes for table `tb_revision`
--
ALTER TABLE `tb_revision`
  ADD PRIMARY KEY (`rv_seq`),
  ADD KEY `client_id` (`rv_cl_siteid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mb_account`
--
ALTER TABLE `mb_account`
  MODIFY `ac_seq` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `mb_client`
--
ALTER TABLE `mb_client`
  MODIFY `cl_seq` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tb_contact`
--
ALTER TABLE `tb_contact`
  MODIFY `co_seq` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tb_image`
--
ALTER TABLE `tb_image`
  MODIFY `im_seq` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tb_log`
--
ALTER TABLE `tb_log`
  MODIFY `lg_seq` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tb_revision`
--
ALTER TABLE `tb_revision`
  MODIFY `rv_seq` int(10) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
