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

/*Table structure for table `bargain_bargain_order` */

DROP TABLE IF EXISTS `bargain_bargain_order`;

CREATE TABLE `bargain_bargain_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '砍价商品发起的用户ID',
  `goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '参与活动的商品',
  `bargain_sn` varchar(20) NOT NULL COMMENT '砍价订单编号',
  `attr1_id` smallint(5) unsigned NOT NULL COMMENT 'attr1属性id',
  `attr2_id` smallint(5) unsigned NOT NULL COMMENT 'attr2属性id',
  `bargain_count` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '被砍价次数',
  `deal_money` decimal(7,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '最终交易价格',
  `is_addorder` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否下单购买(0:未下单，1已下单)',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0是线上，1是地推',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '发起时间',
  PRIMARY KEY (`id`),
  KEY `activity_bargain_id` (`bargain_sn`),
  KEY `attr1_id` (`attr1_id`),
  KEY `attr2_id` (`attr2_id`),
  KEY `product_id` (`goods_id`),
  KEY `user_id` (`uid`),
  KEY `is_addorder` (`is_addorder`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `bargain_bargain_order` */

/*Table structure for table `bargain_goods` */

DROP TABLE IF EXISTS `bargain_goods`;

CREATE TABLE `bargain_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `goods_name` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '商品名称',
  `img1_id` varchar(50) NOT NULL DEFAULT '0' COMMENT '商品图片缩略图id',
  `img2_id` varchar(50) NOT NULL DEFAULT '0' COMMENT '商品图片大图id',
  `activity_money` decimal(7,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '活动价,最低砍价',
  `original_price` decimal(7,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '原价',
  `bargain_section` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '砍价区间',
  `bargain_section2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '砍价区间2【用户线上砍价(新用户砍价区间)】',
  `join_count` smallint(3) unsigned NOT NULL DEFAULT '0' COMMENT '参与人数',
  `goods_desc` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '活动商品描述',
  `attr1_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'attr1属性',
  `attr2_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'attr2属性',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0是线上，1是地推',
  PRIMARY KEY (`id`),
  KEY `attr2_id` (`attr2_id`),
  KEY `attr1_id` (`attr1_id`),
  KEY `type` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `bargain_goods` */

insert  into `bargain_goods`(`id`,`goods_name`,`img1_id`,`img2_id`,`activity_money`,`original_price`,`bargain_section`,`bargain_section2`,`join_count`,`goods_desc`,`attr1_id`,`attr2_id`,`type`) values (1,'隐适美隐形矫正','/static/bargain/images/sm_03.jpg','/static/bargain/images/big_02.jpg','33800.00','46800.00','','',0,'<ul><li><span style=\"font-size: 0.36rem\">Invisalign</span>隐适美系统是一种近乎隐形的创新型治疗方法们</li><li>可以轻柔而持久地矫正你的牙齿。 </li><li>既能满足矫正牙齿的需要，</li><li>又同时避免了传统托槽矫正能看到“钢牙”的缺点。</li><li>又同时避免了传统托槽矫正能看到<em style=\"font-size: 0.36rem;font-style:normal;color: red;\">“钢牙”</em>的缺点。</li><li>就能让牙齿有效、精准的移动。</li></ul>',0,0,0),(2,'进口自锁托槽矫正','/static/bargain/images/sm_05.jpg','/static/bargain/images/big_01.jpg','11800.00','17800.00','','',0,'<p style=\"text-indent: 2em;\">自锁正畸托槽是指在正畸治疗中，用一种专用的黏结剂固定在牙齿表面的一种金属或陶瓷等材料制成的装置，用于容纳和固定正畸钢丝，传递矫治力到牙齿，从而达到牙齿矫正的目的。</p>',0,0,0);

/*Table structure for table `bargain_helpers` */

DROP TABLE IF EXISTS `bargain_helpers`;

CREATE TABLE `bargain_helpers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `helper_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '帮助者ID',
  `order_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发起者订单主键id',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '参与时间',
  `bargain_money` decimal(5,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '砍掉价格',
  PRIMARY KEY (`id`),
  KEY `assistor_id` (`helper_id`),
  KEY `bargain_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `bargain_helpers` */

/*Table structure for table `bargain_images` */

DROP TABLE IF EXISTS `bargain_images`;

CREATE TABLE `bargain_images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `img_path` varchar(100) NOT NULL COMMENT '图片路径',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `bargain_images` */

insert  into `bargain_images`(`id`,`img_path`) values (1,'/static/bargain/images/big_01.jpg'),(2,'/static/bargain/images/big_02.jpg'),(3,'/static/bargain/images/sm_03.jpg'),(4,'/static/bargain/images/sm_05.jpg'),(5,'/static/bargain/images/banner_01.jpg');

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `bargain_users_info` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
