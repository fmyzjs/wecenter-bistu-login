-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- 主机: 127.0.0.1
-- 生成日期: 2014 年 09 月 23 日 02:20
-- 服务器版本: 5.5.27
-- PHP 版本: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `we`
--

-- --------------------------------------------------------

--
-- 表的结构 `aws_users_bistu`
--

CREATE TABLE IF NOT EXISTS `aws_users_bistu` (
  `userid` bigint(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `username` varchar(64) CHARACTER SET utf8 NOT NULL,
  `profile_image_url` varchar(255) CHARACTER SET utf8 NOT NULL,
  `idtype` varchar(6) CHARACTER SET utf8 NOT NULL,
  `add_time` int(10) NOT NULL,
  `access_token` varchar(64) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
