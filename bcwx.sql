/*
SQLyog Ultimate v12.08 (64 bit)
MySQL - 5.5.53 : Database - bcwx
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`bcwx` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `bcwx`;

/*Table structure for table `bargain_users_info` */

DROP TABLE IF EXISTS `bargain_users_info`;

CREATE TABLE `bargain_users_info` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `openid` varchar(50) NOT NULL,
  `nickname` varchar(20) NOT NULL COMMENT '微信号昵称',
  `sex` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '性别1男',
  `city` varchar(10) NOT NULL COMMENT '市级',
  `province` varchar(10) NOT NULL COMMENT '省级',
  `country` varchar(10) NOT NULL COMMENT '国家',
  `headimgurl` varchar(300) NOT NULL COMMENT '头像地址',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE` (`openid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
