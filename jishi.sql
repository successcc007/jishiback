-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2017-11-14 23:23:52
-- 服务器版本： 5.7.9
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jishi`
--

-- --------------------------------------------------------

--
-- 表的结构 `tbl_comment`
--

DROP TABLE IF EXISTS `tbl_comment`;
CREATE TABLE IF NOT EXISTS `tbl_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `create_time` int(11) NOT NULL,
  `provider_id` int(11) NOT NULL,
  `c_status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `tbl_c_city`
--

DROP TABLE IF EXISTS `tbl_c_city`;
CREATE TABLE IF NOT EXISTS `tbl_c_city` (
  `i_id` int(11) NOT NULL,
  `s_name` varchar(20) NOT NULL,
  `i_province_id` int(11) NOT NULL,
  `i_version` int(11) NOT NULL,
  `i_delete` int(1) NOT NULL,
  PRIMARY KEY (`i_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `tbl_c_city`
--

INSERT INTO `tbl_c_city` (`i_id`, `s_name`, `i_province_id`, `i_version`, `i_delete`) VALUES
(101, 'Las Vegas', 101, 0, 0),
(201, 'Toronto', 101, 0, 0),
(301, 'Seattle', 201, 0, 0),
(401, 'Edmonton', 201, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `tbl_c_country`
--

DROP TABLE IF EXISTS `tbl_c_country`;
CREATE TABLE IF NOT EXISTS `tbl_c_country` (
  `i_id` int(11) NOT NULL,
  `s_name` varchar(20) NOT NULL,
  `i_version` int(11) NOT NULL,
  `i_delete` int(1) NOT NULL,
  PRIMARY KEY (`i_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `tbl_c_country`
--

INSERT INTO `tbl_c_country` (`i_id`, `s_name`, `i_version`, `i_delete`) VALUES
(101, 'Japan', 0, 0),
(201, 'Canada', 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `tbl_c_customer`
--

DROP TABLE IF EXISTS `tbl_c_customer`;
CREATE TABLE IF NOT EXISTS `tbl_c_customer` (
  `i_id` int(11) NOT NULL,
  `s_phone` varchar(20) NOT NULL,
  `s_user_name` varchar(20) NOT NULL,
  `i_version` int(11) NOT NULL,
  `i_delete` int(1) NOT NULL,
  `s_password` varchar(50) NOT NULL,
  `s_sex` tinyint(1) NOT NULL DEFAULT '0',
  `s_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '登录状态',
  `s_create_time` int(11) NOT NULL COMMENT '注册时间',
  `s_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 技师 0 客户',
  PRIMARY KEY (`i_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `tbl_c_customer`
--

INSERT INTO `tbl_c_customer` (`i_id`, `s_phone`, `s_user_name`, `i_version`, `i_delete`, `s_password`, `s_sex`, `s_status`, `s_create_time`, `s_type`) VALUES
(101, '4253061818', 'tom189', 1, 0, '', 0, 0, 0, 0),
(201, '4168891765', 'loveyou888', 1, 0, '', 0, 0, 0, 0),
(301, '13958130201', 'admin', 0, 0, 'a205f270af603217fdf655472e596cf0', 0, 0, 1509617951, 0),
(401, '13958130204', 'test', 0, 0, '1cf64187017d04ee566b99e03720c9a3', 0, 1, 1509675881, 0);

-- --------------------------------------------------------

--
-- 表的结构 `tbl_c_order`
--

DROP TABLE IF EXISTS `tbl_c_order`;
CREATE TABLE IF NOT EXISTS `tbl_c_order` (
  `i_id` int(11) NOT NULL,
  `i_customer_id` int(11) NOT NULL,
  `i_provider_id` int(11) NOT NULL,
  `dt_order_time` datetime DEFAULT NULL,
  `dt_start_time` datetime DEFAULT NULL,
  `t_service_time` int(5) DEFAULT NULL,
  `s_type` varchar(10) NOT NULL,
  `i_order_price` int(6) NOT NULL,
  `dt_customer_arrived_time` datetime DEFAULT NULL,
  `dt_unit_sent_time` datetime DEFAULT NULL,
  `dt_provider_arrived_time` datetime DEFAULT NULL,
  `i_final_price` int(6) NOT NULL DEFAULT '0',
  `dt_paid_time` datetime DEFAULT NULL,
  `dt_canceled_time` datetime DEFAULT NULL,
  `dt_closed_time` datetime DEFAULT NULL,
  `i_customer_score` int(1) DEFAULT NULL,
  `s_customer_note` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `i_provider_score` int(1) DEFAULT NULL,
  `s_provider_note` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `dt_service_start_time` datetime NOT NULL COMMENT '服务开始时间',
  PRIMARY KEY (`i_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `tbl_c_order`
--

INSERT INTO `tbl_c_order` (`i_id`, `i_customer_id`, `i_provider_id`, `dt_order_time`, `dt_start_time`, `t_service_time`, `s_type`, `i_order_price`, `dt_customer_arrived_time`, `dt_unit_sent_time`, `dt_provider_arrived_time`, `i_final_price`, `dt_paid_time`, `dt_canceled_time`, `dt_closed_time`, `i_customer_score`, `s_customer_note`, `i_provider_score`, `s_provider_note`, `status`, `dt_service_start_time`) VALUES
(101, 101, 101, '2017-09-15 00:00:00', '2017-09-15 08:00:00', 30, 'in', 120, '2017-09-15 08:03:00', '2017-09-15 08:05:00', '0000-00-00 00:00:00', 110, '2017-09-15 08:09:00', '0000-00-00 00:00:00', '2017-09-15 08:36:00', 5, 'good service', 4, '??', 0, '0000-00-00 00:00:00'),
(201, 201, 201, '2017-09-16 04:00:00', '2017-09-16 11:00:00', 60, 'out', 240, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2017-09-16 10:30:00', 280, '2017-09-16 10:37:00', '0000-00-00 00:00:00', '2017-09-16 11:40:00', 5, 'nice girl, good service', 5, '????', 0, '0000-00-00 00:00:00'),
(301, 301, 201, '2017-11-09 21:36:07', NULL, 1, 'in', 1, '2017-11-09 21:37:02', NULL, NULL, 1010, '2017-11-11 22:32:22', '2017-11-09 21:46:53', NULL, 2, NULL, 3, NULL, 1, '0000-00-00 00:00:00'),
(401, 101, 101, '2017-11-14 22:13:11', NULL, 1, 'in', 5288, '2017-11-15 07:14:30', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 101, NULL, 1, '1933-04-02 22:04:45'),
(501, 101, 101, '2017-11-15 07:20:10', NULL, 1, 'in', 5288, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '1934-04-17 18:27:58');

-- --------------------------------------------------------

--
-- 表的结构 `tbl_c_provider`
--

DROP TABLE IF EXISTS `tbl_c_provider`;
CREATE TABLE IF NOT EXISTS `tbl_c_provider` (
  `i_id` int(11) NOT NULL,
  `i_studio_id` int(11) NOT NULL,
  `s_name` varchar(20) NOT NULL,
  `i_weight` int(11) NOT NULL,
  `i_height` int(11) NOT NULL,
  `s_cup` varchar(1) NOT NULL,
  `i_top` int(11) NOT NULL,
  `i_mid` int(11) NOT NULL,
  `i_bot` int(11) NOT NULL,
  `i_age` int(11) NOT NULL,
  `s_nation` varchar(20) NOT NULL,
  `i_version` int(11) NOT NULL,
  `i_delete` int(1) NOT NULL,
  `i_score` tinyint(1) NOT NULL DEFAULT '0' COMMENT '评分',
  `i_price` decimal(10,0) NOT NULL,
  `i_imgurl` varchar(200) NOT NULL,
  `i_type` char(4) NOT NULL COMMENT '服务类型',
  PRIMARY KEY (`i_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `tbl_c_provider`
--

INSERT INTO `tbl_c_provider` (`i_id`, `i_studio_id`, `s_name`, `i_weight`, `i_height`, `s_cup`, `i_top`, `i_mid`, `i_bot`, `i_age`, `s_nation`, `i_version`, `i_delete`, `i_score`, `i_price`, `i_imgurl`, `i_type`) VALUES
(101, 101, 'Amy', 120, 158, 'C', 22, 25, 23, 25, 'Japan', 0, 0, 100, '300', 't1.jpg', 'in'),
(201, 101, 'Nana', 130, 173, 'D', 23, 24, 25, 21, 'Chinese', 0, 0, 90, '700', 't2.jpg', 'out'),
(301, 201, 'Ella', 130, 174, 'C', 25, 28, 31, 28, 'Korean', 0, 0, 95, '600', 't3.jpg', 'in'),
(401, 201, 'Emma', 128, 158, 'C', 25, 26, 28, 19, 'Singapo', 0, 0, 70, '800', 't4.jpg', 'out');

-- --------------------------------------------------------

--
-- 表的结构 `tbl_c_provider_img`
--

DROP TABLE IF EXISTS `tbl_c_provider_img`;
CREATE TABLE IF NOT EXISTS `tbl_c_provider_img` (
  `i_id` int(11) NOT NULL AUTO_INCREMENT,
  `img_url` varchar(50) NOT NULL COMMENT '图片路径',
  `provider_id` int(11) NOT NULL COMMENT '技师ID',
  `create_time` int(11) DEFAULT NULL COMMENT '图片创建时间',
  `s_note` varchar(50) DEFAULT NULL COMMENT '图片备注',
  PRIMARY KEY (`i_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tbl_c_provider_img`
--

INSERT INTO `tbl_c_provider_img` (`i_id`, `img_url`, `provider_id`, `create_time`, `s_note`) VALUES
(1, 't1.jpg', 101, NULL, NULL),
(2, 't11.jpg', 101, NULL, NULL),
(3, 't22.jpg', 101, NULL, NULL),
(4, 't33.jpg', 101, NULL, NULL),
(5, 't44.jpg', 101, NULL, NULL),
(6, 't55.jpg', 101, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `tbl_c_province`
--

DROP TABLE IF EXISTS `tbl_c_province`;
CREATE TABLE IF NOT EXISTS `tbl_c_province` (
  `i_id` int(11) NOT NULL,
  `s_name` varchar(20) NOT NULL,
  `i_country_id` int(11) NOT NULL,
  `s_type` varchar(10) NOT NULL,
  `i_version` int(11) NOT NULL,
  `i_delete` int(1) NOT NULL,
  PRIMARY KEY (`i_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `tbl_c_province`
--

INSERT INTO `tbl_c_province` (`i_id`, `s_name`, `i_country_id`, `s_type`, `i_version`, `i_delete`) VALUES
(101, 'Nevada', 101, 'State', 0, 0),
(201, 'Ontario', 201, 'Province', 0, 0),
(301, 'Washington', 101, 'State', 0, 0),
(401, 'Alberta', 201, 'Province', 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `tbl_c_studio`
--

DROP TABLE IF EXISTS `tbl_c_studio`;
CREATE TABLE IF NOT EXISTS `tbl_c_studio` (
  `i_id` int(11) NOT NULL,
  `s_name` varchar(30) NOT NULL,
  `i_city_id` int(11) NOT NULL,
  `s_address` varchar(50) NOT NULL,
  `s_postal` varchar(10) NOT NULL,
  `s_unit` varchar(10) NOT NULL,
  `i_version` int(11) NOT NULL,
  `i_delete` int(1) NOT NULL,
  PRIMARY KEY (`i_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `tbl_c_studio`
--

INSERT INTO `tbl_c_studio` (`i_id`, `s_name`, `i_city_id`, `s_address`, `s_postal`, `s_unit`, `i_version`, `i_delete`) VALUES
(101, 'studio 1', 101, '850 North Las Vegas Boulevard', '98109', '101', 0, 0),
(201, 'studio2', 101, '101 Yonge street', 'Y2K 6N3', '235B', 0, 0),
(301, 'studio 3', 201, '2201 Westlake Avenue', '18754', '1008', 0, 0),
(401, 'studio 4', 201, '7730 - 34th Street', '2KH 3B5', '2C', 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `tbl_n_id`
--

DROP TABLE IF EXISTS `tbl_n_id`;
CREATE TABLE IF NOT EXISTS `tbl_n_id` (
  `s_class` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `i_current_id` int(11) NOT NULL,
  `i_version` int(11) NOT NULL,
  PRIMARY KEY (`s_class`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `tbl_n_id`
--

INSERT INTO `tbl_n_id` (`s_class`, `i_current_id`, `i_version`) VALUES
('c_city', 401, 4),
('c_country', 201, 2),
('c_customer', 201, 2),
('c_order', 101, 1),
('c_provider', 401, 4),
('c_province', 401, 4),
('c_studio', 401, 4);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
