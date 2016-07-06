-- phpMyAdmin SQL Dump
-- version 3.3.10.5
-- http://www.phpmyadmin.net
--
-- Host: mysql533.db.sakura.ne.jp
-- Generation Time: Jun 30, 2016 at 09:09 AM
-- Server version: 5.5.38
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `temipo_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_tb`
--

CREATE TABLE IF NOT EXISTS `mb_account` (
  `ac_seq` int(5) NOT NULL AUTO_INCREMENT,
  `ac_status` int(1) NOT NULL,
  `ac_type` varchar(10) NOT NULL,
  `ac_id` varchar(20) NOT NULL,
  `ac_pw` varchar(255) NOT NULL,
  `ac_department1` varchar(20) NOT NULL,
  `ac_name01` varchar(20) NOT NULL,
  `ac_name02` varchar(20) NOT NULL,
  `ac_mail` varchar(100) NOT NULL,
  `ac_auth` varchar(25) NOT NULL,
  `ac_lastlogin` timestamp NOT NULL,
  `ac_create_date` timestamp NOT NULL,
  `ac_update_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ac_id`),
  UNIQUE KEY `mail` (`ac_mail`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `account_tb`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog_entry_tb`
--

--CREATE TABLE IF NOT EXISTS `blog_entry_tb` (
--  `no` int(10) NOT NULL,
--  `client_id` varchar(20) NOT NULL,
--  `status` int(1) NOT NULL,
--  `entry_title` varchar(50) NOT NULL,
--  `entry_body` text NOT NULL,
--  `entry_category` varchar(20) NOT NULL,
--  `entry_tags` varchar(100) NOT NULL,
--  `posting_date` datetime NOT NULL,
--  `update_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
--  PRIMARY KEY (`no`)
--) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `blog_entry_tb`
--


-- --------------------------------------------------------

--
-- Table structure for table `client_tb`
--

CREATE TABLE IF NOT EXISTS `mb_client` (
  `cl_seq` int(5) NOT NULL AUTO_INCREMENT,
  `cl_status` int(1) NOT NULL,
  `cl_sales_id` varchar(20) NOT NULL,
  `cl_editor_id` varchar(20) NOT NULL,
  `cl_contract_str` date NOT NULL,
  `cl_contract_end` date NOT NULL,
  `cl_plan` varchar(10) NOT NULL DEFAULT 'basic',
  `cl_client_id` varchar(20) NOT NULL,
  `cl_pw` varchar(255) NOT NULL,
  `cl_company` varchar(50) NOT NULL,
  `cl_president01` varchar(50) NOT NULL,
  `cl_president02` varchar(50) NOT NULL,
  `cl_department` varchar(50) NOT NULL,
  `cl_person01` varchar(20) NOT NULL,
  `cl_person02` varchar(20) NOT NULL,
  `cl_tel` varchar(15) NOT NULL,
  `cl_mobile` varchar(15) NOT NULL,
  `cl_fax` varchar(15) NOT NULL,
  `cl_mail` varchar(100) NOT NULL,
  `cl_mailsub` varchar(100) NOT NULL,
  `cl_t_category` int(11) NOT NULL,
  `cl_t_shopname` varchar(100) NOT NULL,
  `cl_t_shopname_sub` varchar(100) NOT NULL,
  `cl_t_url` varchar(255) NOT NULL,
  `cl_t_zip01` int(3) NOT NULL,
  `cl_t_zip02` int(4) NOT NULL,
  `cl_t_pref` int(4) NOT NULL,
  `cl_t_addr01` varchar(100) NOT NULL,
  `cl_t_addr02` varchar(100) NOT NULL,
  `cl_t_buil` varchar(100) NOT NULL,
  `cl_t_tel` varchar(15) NOT NULL,
  `cl_t_mail` varchar(100) NOT NULL,
  `cl_t_opentime` text NOT NULL,
  `cl_t_holiday` text NOT NULL,
  `cl_t_since` varchar(50) NOT NULL,
  `cl_t_parking` text NOT NULL,
  `cl_t_seat` text NOT NULL,
  `cl_t_card` text NOT NULL,
  `cl_t_access` text NOT NULL,
  `cl_t_access_sub` text NOT NULL,
  `cl_t_contents01` text NOT NULL,
  `cl_t_contents02` text NOT NULL,
  `cl_t_free01` text NOT NULL,
  `cl_t_free02` text NOT NULL,
  `cl_t_free03` text NOT NULL,
  `cl_t_free04` text NOT NULL,
  `cl_t_free05` text NOT NULL,
  `cl_auth` varchar(25) NOT NULL,
  `cl_create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cl_update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`cl_seq`),
  KEY `sales_id` (`cl_sales_id`),
  KEY `editor_id` (`cl_editor_id`),
  KEY `client_id` (`cl_client_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `client_tb`
--


-- --------------------------------------------------------

--
-- Table structure for table `contact_tb`
--

CREATE TABLE IF NOT EXISTS `tb_contact` (
  `co_seq` int(10) NOT NULL AUTO_INCREMENT,
  `co_status` int(1) NOT NULL,
  `co_client_id` varchar(20) NOT NULL,
  `co_contact_name` varchar(25) NOT NULL,
  `co_contact_body` text NOT NULL,
  `co_contact_tel` int(15) NOT NULL,
  `co_contact_mail` varchar(255) NOT NULL,
  `co_create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `co_update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`co_seq`),
  KEY `client_id` (`co_client_id`),
  KEY `status` (`co_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `contact_tb`
--


-- --------------------------------------------------------

--
-- Table structure for table `entry_tb`
--

CREATE TABLE IF NOT EXISTS `tb_entry` (
  `en_seq` int(10) NOT NULL AUTO_INCREMENT,
  `en_client_id` varchar(20) NOT NULL,
  `en_title01` varchar(100) NOT NULL,
  `en_body01` text NOT NULL,
  `en_description01` text NOT NULL,
  `en_length01` int(5) NOT NULL,
  `en_title02` varchar(100) NOT NULL,
  `en_body02` text NOT NULL,
  `en_description02` text NOT NULL,
  `en_length02` int(5) NOT NULL,
  `en_entry_tags` varchar(255) NOT NULL,
  `en_length` int(5) NOT NULL,
  `en_auth` varchar(25) NOT NULL,
  `en_posting_date` datetime NOT NULL,
  `en_create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `en_update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`en_seq`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `entry_tb`
--


-- --------------------------------------------------------

--
-- Table structure for table `image_tb`
--

CREATE TABLE IF NOT EXISTS `tb_image` (
  `im_seq` int(10) NOT NULL AUTO_INCREMENT,
  `im_type` varchar(3) NOT NULL,
  `im_size` int(10) NOT NULL,
  `im_width` int(5) NOT NULL,
  `im_height` int(5) NOT NULL,
  `im_client_id` varchar(20) NOT NULL,
  `im_owner` int(1) NOT NULL,
  `im_is_header` int(1) NOT NULL,
  `im_description` varchar(255) NOT NULL,
  `im_is_photolist` int(1) NOT NULL,
  `im_display_order` int(3) NOT NULL,
  `im_create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `im_update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`im_seq`),
  KEY `client_id` (`im_client_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `image_tb`
--


-- --------------------------------------------------------

--
-- Table structure for table `log_tb`
--

CREATE TABLE IF NOT EXISTS `tb_log` (
  `lg_seq` int(10) NOT NULL AUTO_INCREMENT,
  `lg_user_type` varchar(10) NOT NULL,
  `lg_user_id` varchar(100) NOT NULL,
  `lg_client_id` varchar(20) NOT NULL,
  `lg_type` varchar(35) NOT NULL,
  `lg_detail` text NOT NULL,
  `lg_ip` varchar(39) NOT NULL,
  `lg_create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lg_update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`lg_seq`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `log_tb`
--


-- --------------------------------------------------------

--
-- Table structure for table `revision_tb`
--

CREATE TABLE IF NOT EXISTS `tb_revision` (
  `rv_seq` int(10) NOT NULL AUTO_INCREMENT,
  `rv_client_id` varchar(20) NOT NULL,
  `rv_entry_title` varchar(100) NOT NULL,
  `rv_entry_body` text NOT NULL,
  `rv_entry_description` text NOT NULL,
  `rv_entry_tags` varchar(255) NOT NULL,
  `rv_length` int(5) NOT NULL,
  `rv_create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `rv_update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`rv_seq`),
  KEY `client_id` (`rv_client_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `revision_tb`
--

