
-- --------------------------------------------------------

--
-- Table structure for table `news_tb`
--   Ç±ÇÍÇÕêóå`SQLÇ≈Ç∑
--

CREATE TABLE IF NOT EXISTS `tb_news` (
  `nw_seq` int(10) NOT NULL AUTO_INCREMENT,
  `nw_status` int(1) NOT NULL,
  `nw_type` varchar(25) NOT NULL,
  `nw_title` text NOT NULL,
  `nw_body` int(15) NOT NULL,
  `nw_open_date` datetime,
  `nw_end_date` datetime,
  `nw_image01` varchar(20) NOT NULL,
  `nw_image02` varchar(20) NOT NULL,
  `nw_image03` varchar(20) NOT NULL,
  `nw_cl_is` int(10) NOT NULL,
  `nw_cl_siteid` varchar(20) NOT NULL,
  `nw_create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nw_update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`nw_seq`),
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `contact_tb`
--

