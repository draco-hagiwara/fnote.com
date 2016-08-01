-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2016 年 7 月 25 日 16:54
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

-- --------------------------------------------------------

--
-- テーブルの構造 `ci_sessions`
--

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

CREATE TABLE `mb_client` (
  `cl_seq` int(10) UNSIGNED NOT NULL,
  `cl_status` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `cl_sales_id` int(10) UNSIGNED NOT NULL,
  `cl_editor_id` int(10) UNSIGNED NOT NULL,
  `cl_admin_id` int(10) UNSIGNED NOT NULL DEFAULT '1',
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
  `cl_comment` text COMMENT '非承認事由',
  `cl_auth` varchar(25) DEFAULT NULL,
  `cl_lastlogin` datetime DEFAULT NULL,
  `cl_create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cl_update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `tb_contact`
--

CREATE TABLE `tb_contact` (
  `co_seq` int(10) UNSIGNED NOT NULL,
  `co_status` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `co_cl_siteid` varchar(20) NOT NULL,
  `co_contact_name` varchar(100) DEFAULT NULL,
  `co_contact_body` text,
  `co_contact_tel` varchar(15) DEFAULT NULL,
  `co_contact_mail` varchar(255) DEFAULT NULL,
  `co_create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `co_update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `tb_entry`
--

CREATE TABLE `tb_entry` (
  `en_seq` int(10) UNSIGNED NOT NULL,
  `en_title01` varchar(100) DEFAULT NULL,
  `en_body01` text,
  `en_length01` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `en_title02` varchar(100) DEFAULT NULL,
  `en_body02` text,
  `en_length02` int(11) NOT NULL DEFAULT '0',
  `en_entry_tags` varchar(255) DEFAULT NULL,
  `en_cate01` smallint(5) UNSIGNED DEFAULT '0',
  `en_cate02` smallint(5) UNSIGNED DEFAULT '0',
  `en_cate03` smallint(5) UNSIGNED DEFAULT '0',
  `en_shopname` varchar(100) DEFAULT NULL,
  `en_shopname_sub` text,
  `en_url` varchar(255) DEFAULT NULL,
  `en_zip01` smallint(5) UNSIGNED DEFAULT NULL,
  `en_zip02` smallint(5) UNSIGNED DEFAULT NULL,
  `en_pref` tinyint(3) UNSIGNED DEFAULT NULL,
  `en_addr01` varchar(100) DEFAULT NULL,
  `en_addr02` varchar(100) DEFAULT NULL,
  `en_buil` varchar(100) DEFAULT NULL,
  `en_tel` varchar(15) DEFAULT NULL,
  `en_mail` varchar(100) DEFAULT NULL,
  `en_opentime` text,
  `en_holiday` text,
  `en_since` text,
  `en_parking` text,
  `en_seat` text,
  `en_card` text,
  `en_access` text,
  `en_access_sub` text,
  `en_contents01` text,
  `en_contents02` text,
  `en_description` text,
  `en_keywords` text,
  `en_sns01` text,
  `en_sns02` text,
  `en_sns03` text,
  `en_sns04` text,
  `en_sns05` text,
  `en_google_map` text,
  `en_free01` text,
  `en_free02` text,
  `en_free03` text,
  `en_free04` text,
  `en_free05` text,
  `en_cl_seq` int(10) UNSIGNED NOT NULL,
  `en_cl_id` varchar(20) NOT NULL,
  `en_cl_siteid` varchar(20) NOT NULL,
  `en_auth` varchar(25) DEFAULT NULL,
  `en_posting_date` datetime DEFAULT NULL,
  `en_create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `en_update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `tb_image`
--

CREATE TABLE `tb_image` (
  `im_seq` int(10) NOT NULL,
  `im_status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `im_type` varchar(15) DEFAULT NULL,
  `im_size` int(10) UNSIGNED NOT NULL,
  `im_width` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `im_height` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `im_filename` varchar(50) DEFAULT NULL,
  `im_title` varchar(50) DEFAULT NULL,
  `im_description` varchar(255) DEFAULT '',
  `im_disp_no` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `im_header` tinyint(4) UNSIGNED NOT NULL DEFAULT '0',
  `im_cl_seq` int(10) UNSIGNED NOT NULL,
  `im_cl_siteid` varchar(20) NOT NULL,
  `im_create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `im_update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `tb_log`
--

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
-- テーブルの構造 `tb_news`
--

CREATE TABLE `tb_news` (
  `nw_seq` int(10) UNSIGNED NOT NULL,
  `nw_status` tinyint(4) NOT NULL DEFAULT '0',
  `nw_type` tinyint(4) NOT NULL DEFAULT '0',
  `nw_title` varchar(50) DEFAULT NULL,
  `nw_body` text,
  `nw_start_date` date DEFAULT NULL,
  `nw_end_date` date DEFAULT NULL,
  `nw_image01` varchar(50) DEFAULT NULL,
  `nw_image02` varchar(50) DEFAULT NULL,
  `nw_image03` varchar(50) DEFAULT NULL,
  `nw_cl_seq` int(10) UNSIGNED NOT NULL,
  `nw_cl_siteid` varchar(20) NOT NULL,
  `nw_create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nw_update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `tb_revision`
--

CREATE TABLE `tb_revision` (
  `rv_seq` int(10) NOT NULL,
  `rv_dispno` tinyint(4) NOT NULL DEFAULT '0',
  `rv_description` varchar(50) DEFAULT NULL,
  `rv_entry_title01` varchar(100) NOT NULL,
  `rv_entry_body01` text NOT NULL,
  `rv_length01` smallint(6) NOT NULL DEFAULT '0',
  `rv_entry_title02` varchar(100) DEFAULT NULL,
  `rv_entry_body02` text,
  `rv_length02` smallint(6) NOT NULL DEFAULT '0',
  `rv_cl_seq` int(10) UNSIGNED NOT NULL,
  `rv_cl_siteid` varchar(20) NOT NULL,
  `rv_create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `rv_update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- ビュー用の代替構造 `vw_a_clientlist`
--
CREATE TABLE `vw_a_clientlist` (
`cl_seq` int(10) unsigned
,`cl_status` tinyint(3) unsigned
,`cl_sales_id` int(10) unsigned
,`cl_editor_id` int(10) unsigned
,`cl_admin_id` int(10) unsigned
,`cl_contract_str` date
,`cl_contract_end` date
,`cl_plan` tinyint(3) unsigned
,`cl_siteid` varchar(20)
,`cl_id` varchar(20)
,`cl_pw` varchar(255)
,`cl_company` varchar(50)
,`cl_president01` varchar(50)
,`cl_president02` varchar(50)
,`cl_department` varchar(50)
,`cl_person01` varchar(20)
,`cl_person02` varchar(20)
,`cl_tel` varchar(15)
,`cl_mobile` varchar(15)
,`cl_fax` varchar(15)
,`cl_mail` varchar(100)
,`cl_mailsub` varchar(100)
,`salsedep` varchar(50)
,`salsename01` varchar(20)
,`salsename02` varchar(20)
,`salseacmail` varchar(100)
,`editordep` varchar(50)
,`editorname01` varchar(20)
,`editorname02` varchar(20)
,`editoracmail` varchar(100)
,`admindep` varchar(50)
,`adminname01` varchar(20)
,`adminname02` varchar(20)
,`adminacmail` varchar(100)
);

-- --------------------------------------------------------

--
-- ビュー用の構造 `vw_a_clientlist`
--
DROP TABLE IF EXISTS `vw_a_clientlist`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_a_clientlist`  AS  select `T1`.`cl_seq` AS `cl_seq`,`T1`.`cl_status` AS `cl_status`,`T1`.`cl_sales_id` AS `cl_sales_id`,`T1`.`cl_editor_id` AS `cl_editor_id`,`T1`.`cl_admin_id` AS `cl_admin_id`,`T1`.`cl_contract_str` AS `cl_contract_str`,`T1`.`cl_contract_end` AS `cl_contract_end`,`T1`.`cl_plan` AS `cl_plan`,`T1`.`cl_siteid` AS `cl_siteid`,`T1`.`cl_id` AS `cl_id`,`T1`.`cl_pw` AS `cl_pw`,`T1`.`cl_company` AS `cl_company`,`T1`.`cl_president01` AS `cl_president01`,`T1`.`cl_president02` AS `cl_president02`,`T1`.`cl_department` AS `cl_department`,`T1`.`cl_person01` AS `cl_person01`,`T1`.`cl_person02` AS `cl_person02`,`T1`.`cl_tel` AS `cl_tel`,`T1`.`cl_mobile` AS `cl_mobile`,`T1`.`cl_fax` AS `cl_fax`,`T1`.`cl_mail` AS `cl_mail`,`T1`.`cl_mailsub` AS `cl_mailsub`,`T2`.`ac_department` AS `salsedep`,`T2`.`ac_name01` AS `salsename01`,`T2`.`ac_name02` AS `salsename02`,`T2`.`ac_mail` AS `salseacmail`,`T3`.`ac_department` AS `editordep`,`T3`.`ac_name01` AS `editorname01`,`T3`.`ac_name02` AS `editorname02`,`T3`.`ac_mail` AS `editoracmail`,`T4`.`ac_department` AS `admindep`,`T4`.`ac_name01` AS `adminname01`,`T4`.`ac_name02` AS `adminname02`,`T4`.`ac_mail` AS `adminacmail` from (((`mb_client` `T1` left join `mb_account` `T2` on((`T1`.`cl_sales_id` = `T2`.`ac_seq`))) left join `mb_account` `T3` on((`T1`.`cl_editor_id` = `T3`.`ac_seq`))) left join `mb_account` `T4` on((`T1`.`cl_admin_id` = `T4`.`ac_seq`))) ;

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
  ADD UNIQUE KEY `ac_id` (`ac_id`),
  ADD KEY `ac_status` (`ac_status`);

--
-- Indexes for table `mb_client`
--
ALTER TABLE `mb_client`
  ADD PRIMARY KEY (`cl_seq`) USING BTREE,
  ADD UNIQUE KEY `cl_siteid` (`cl_siteid`),
  ADD UNIQUE KEY `cl_id` (`cl_id`),
  ADD KEY `cl_status` (`cl_status`),
  ADD KEY `cl_sales_id` (`cl_sales_id`),
  ADD KEY `cl_editor_id` (`cl_editor_id`),
  ADD KEY `cl_admin_id` (`cl_admin_id`);

--
-- Indexes for table `tb_contact`
--
ALTER TABLE `tb_contact`
  ADD PRIMARY KEY (`co_seq`),
  ADD KEY `co_status` (`co_status`),
  ADD KEY `co_cl_siteid` (`co_cl_siteid`);

--
-- Indexes for table `tb_entry`
--
ALTER TABLE `tb_entry`
  ADD PRIMARY KEY (`en_seq`),
  ADD UNIQUE KEY `en_cl_id` (`en_cl_id`),
  ADD UNIQUE KEY `en_cl_siteid` (`en_cl_siteid`),
  ADD UNIQUE KEY `en_cl_seq` (`en_cl_seq`);

--
-- Indexes for table `tb_image`
--
ALTER TABLE `tb_image`
  ADD PRIMARY KEY (`im_seq`),
  ADD KEY `im_status` (`im_status`),
  ADD KEY `im_cl_seq` (`im_cl_seq`),
  ADD KEY `im_cl_siteid` (`im_cl_siteid`);

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
-- Indexes for table `tb_news`
--
ALTER TABLE `tb_news`
  ADD PRIMARY KEY (`nw_seq`),
  ADD KEY `nw_status` (`nw_status`),
  ADD KEY `nw_cl_seq` (`nw_cl_seq`),
  ADD KEY `nw_cl_siteid` (`nw_cl_siteid`);

--
-- Indexes for table `tb_revision`
--
ALTER TABLE `tb_revision`
  ADD PRIMARY KEY (`rv_seq`),
  ADD KEY `rv_dispno` (`rv_dispno`),
  ADD KEY `rv_cl_siteid` (`rv_cl_siteid`),
  ADD KEY `rv_cl_seq` (`rv_cl_seq`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mb_account`
--
ALTER TABLE `mb_account`
  MODIFY `ac_seq` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `mb_client`
--
ALTER TABLE `mb_client`
  MODIFY `cl_seq` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `tb_contact`
--
ALTER TABLE `tb_contact`
  MODIFY `co_seq` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `tb_entry`
--
ALTER TABLE `tb_entry`
  MODIFY `en_seq` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tb_image`
--
ALTER TABLE `tb_image`
  MODIFY `im_seq` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `tb_log`
--
ALTER TABLE `tb_log`
  MODIFY `lg_seq` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tb_news`
--
ALTER TABLE `tb_news`
  MODIFY `nw_seq` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `tb_revision`
--
ALTER TABLE `tb_revision`
  MODIFY `rv_seq` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
