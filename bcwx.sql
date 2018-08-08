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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `bargain_bargain_order` */

insert  into `bargain_bargain_order`(`id`,`uid`,`goods_id`,`bargain_sn`,`attr1_id`,`attr2_id`,`bargain_count`,`deal_money`,`is_addorder`,`type`,`create_time`) values (1,1,1,'NFD72018080949541005',0,0,0,'0.00',0,0,1533744001),(2,1,2,'W6VP2018080951541025',0,0,0,'0.00',0,0,1533744115);

/*Table structure for table `bargain_data` */

DROP TABLE IF EXISTS `bargain_data`;

CREATE TABLE `bargain_data` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `goods_id` int(10) NOT NULL COMMENT '对应商品id',
  `p50` varchar(500) NOT NULL COMMENT '1-50人',
  `p100` varchar(500) DEFAULT NULL COMMENT '50-100人',
  `p200` varchar(500) DEFAULT NULL COMMENT '100-200人',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `bargain_data` */

insert  into `bargain_data`(`id`,`goods_id`,`p50`,`p100`,`p200`) values (1,1,'51.15,86.33,3.96,103.79,2.03,77.77,108.31,71.32,34.55,1.21,132.1,1.42,2.53,1.28,59.73,1.28,1.24,64.83,66.36,129.84,60.65,9.4,1.19,1.13,1.41,26.4,2.56,1.56,132.67,65.67,6.76,103.09,16.94,109.12,2.23,54.29,85.72,1.56,71.03,45.36,1.12,55.54,67.73,54.95,1.34,1.2,58.23,50.53,84.3,125.29','4.33,1.83,1.84,4.77,48.22,84.78,5.28,1.23,35.90,3.96,1.07,1.24,102.87,2.10,56.47,40.68,1.21,51.99,1.39,46.36,76.17,47.10,86.06,85.66,55.22,2.59,1.22,1.01,1.45,2.87,1.99,85.30,76.40,1.23,1.31,97.68,1.02,1.04,1.33,29.67,34.12,1.17,107.02,101.44,1.01,66.76,67.52,91.14,40.78,35.20','100.19,103.54,1.15,2.56,1.27,1.30,1.40,14.54,115.84,1.25,1.03,84.64,1.21,1.03,47.47,76.25,1.47,1.20,1.15,91.04,63.93,17.75,4.81,1.01,1.39,1.65,52.27,101.64,82.63,83.55,2.17,97.11,1.07,1.16,100.75,1.33,1.19,1.26,1.33,1.08,94.61,1.04,1.06,119.84,1.17,78.51,86.78,29.10,45.20,74.08'),(2,2,'1.01,1.00,1.12,1.03,2.11,1.03,1.00,1.05,22.61,1.03,39.27,1.04,38.97,1.08,2.27,2.34,69.76,19.38,68.58,1.00,3.41,1.00,1.02,66.07,28.95,1.75,1.01,27.77,72.90,66.32,1.01,42.11,1.02,1.02,1.08,7.52,1.04,1.01,1.03,1.08,1.05,30.21,1.00,48.79,63.33,1.02,1.01,1.02,32.82,14.95','1.08,57.04,1.12,1.08,1.13,1.20,10.67,64.77,31.12,1.13,13.72,1.18,3.54,1.16,46.18,35.94,1.18,1.14,45.20,1.14,1.09,1.06,1.03,45.67,19.98,74.38,1.11,1.13,1.78,1.01,1.55,69.70,57.31,1.10,75.45,1.29,1.21,1.03,1.03,65.72,1.18,21.75,1.06,1.11,84.08,84.71,1.19,2.42,1.15,57.00',NULL);

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

insert  into `bargain_goods`(`id`,`goods_name`,`img1_id`,`img2_id`,`activity_money`,`original_price`,`bargain_section`,`bargain_section2`,`join_count`,`goods_desc`,`attr1_id`,`attr2_id`,`type`) values (1,'隐适美隐形矫正','/static/bargain/images/sm_03.jpg','/static/bargain/images/big_02.jpg','33800.00','39800.00','','',0,'<ul><li><span style=\"font-size: 0.36rem\">Invisalign</span>隐适美系统是一种近乎隐形的创新型治疗方法们</li><li>可以轻柔而持久地矫正你的牙齿。 </li><li>既能满足矫正牙齿的需要，</li><li>又同时避免了传统托槽矫正能看到“钢牙”的缺点。</li><li>又同时避免了传统托槽矫正能看到<em style=\"font-size: 0.36rem;font-style:normal;color: red;\">“钢牙”</em>的缺点。</li><li>就能让牙齿有效、精准的移动。</li></ul>',0,0,0),(2,'进口金属自锁托槽矫正','/static/bargain/images/sm_05.jpg','/static/bargain/images/big_01.jpg','11800.00','13800.00','','',0,'<p style=\"text-indent: 2em;\">自锁正畸托槽是指在正畸治疗中，用一种专用的黏结剂固定在牙齿表面的一种金属或陶瓷等材料制成的装置，用于容纳和固定正畸钢丝，传递矫治力到牙齿，从而达到牙齿矫正的目的。</p>',0,0,0);

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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `bargain_users_info` */

insert  into `bargain_users_info`(`id`,`openid`,`nickname`,`sex`,`city`,`province`,`country`,`headimgurl`,`create_time`,`update_time`) values (1,'oNKC-0TJuJ8e_LJhsor1tVzqFHD8','Rehack',1,'成都','四川','中国','http://thirdwx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTIN6ICAamJIEKIyk9gAllcicicWcp8Ut1NJ5CakaaD29zLSq2HNL5p6FiaxibHC6ZibHydgOBsfn0K5IbQ/132',1533743982,1533743982);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
