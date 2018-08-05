/*
SQLyog Ultimate v12.08 (64 bit)
MySQL - 5.5.56 : Database - bcwx
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

/*Table structure for table `bargain_goods` */

DROP TABLE IF EXISTS `bargain_goods`;

CREATE TABLE `bargain_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `product_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `product_name` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '商品名称',
  `img_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品图片id',
  `activity_money` decimal(7,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '活动价,最低砍价',
  `original_price` decimal(7,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '原价',
  `bargain_section` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '砍价区间',
  `bargain_section2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '砍价区间2【用户线上砍价(新用户砍价区间)】',
  `join_count` smallint(3) unsigned NOT NULL DEFAULT '0' COMMENT '参与人数',
  `product_desc` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '活动商品描述',
  `attr1_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'attr1属性',
  `attr2_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'attr2属性',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0是线上，1是地推',
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `attr2_id` (`attr2_id`),
  KEY `attr1_id` (`attr1_id`),
  KEY `type` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Table structure for table `bargain_helpers` */

DROP TABLE IF EXISTS `bargain_helpers`;

CREATE TABLE `bargain_helpers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `order_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发起者订单主键id',
  `assistor_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '帮助者ID',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '参与时间',
  `bargain_money` decimal(5,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '砍掉价格',
  PRIMARY KEY (`id`),
  KEY `assistor_id` (`assistor_id`),
  KEY `bargain_id` (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Table structure for table `bargain_images` */

DROP TABLE IF EXISTS `bargain_images`;

CREATE TABLE `bargain_images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `img_path` varchar(100) NOT NULL COMMENT '图片路径',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Table structure for table `bargain_order` */

DROP TABLE IF EXISTS `bargain_order`;

CREATE TABLE `bargain_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `activity_bargain_id` int(10) unsigned NOT NULL COMMENT 'activity_prodcuts主键id',
  `product_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '参与活动的商品',
  `attr1_id` smallint(5) unsigned NOT NULL COMMENT 'attr1属性id',
  `attr2_id` smallint(5) unsigned NOT NULL COMMENT 'attr2属性id',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '砍价商品发起的用户ID',
  `bargain_count` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '被砍价次数',
  `deal_money` decimal(7,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '最终交易价格',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '发起时间',
  `is_addorder` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否下单购买(0:未下单，1已下单)',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0是线上，1是地推',
  PRIMARY KEY (`id`),
  KEY `activity_bargain_id` (`activity_bargain_id`),
  KEY `attr1_id` (`attr1_id`),
  KEY `attr2_id` (`attr2_id`),
  KEY `product_id` (`product_id`),
  KEY `user_id` (`user_id`),
  KEY `is_addorder` (`is_addorder`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
