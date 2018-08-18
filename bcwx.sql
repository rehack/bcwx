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

/*Table structure for table `bargain_data` */

DROP TABLE IF EXISTS `bargain_data`;

CREATE TABLE `bargain_data` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `goods_id` int(10) NOT NULL COMMENT '对应商品id',
  `p50` varchar(500) NOT NULL COMMENT '1-50人',
  `p100` varchar(500) DEFAULT NULL COMMENT '50-100人',
  `p200` varchar(700) DEFAULT NULL COMMENT '100-200人',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `bargain_data` */

insert  into `bargain_data`(`id`,`goods_id`,`p50`,`p100`,`p200`) values (1,1,'81.23,1.4,37.66,97.64,55.77,116.76,78.68,46.28,1.43,1.38,1.28,1.44,2.61,1.41,1.6,1.37,130.74,66.52,1.43,51.48,63.12,97.05,1.31,1.42,12.56,82.67,67.31,1.35,127.44,69.02,130.37,80.53,42.65,1.3,85.05,117.58,1.07,131.38,12.74,1.45,1.52,1.36,124.94,112.22,1.41,115.88,1.48,33.18,1.16,1.37','4.33,1.83,1.84,4.77,48.22,84.78,5.28,1.23,35.90,3.96,1.07,1.24,102.87,2.10,56.47,40.68,1.21,51.99,1.39,46.36,76.17,47.10,86.06,85.66,55.22,2.59,1.22,1.01,1.45,2.87,1.99,85.30,76.40,1.23,1.31,97.68,1.02,1.04,1.33,29.67,34.12,1.17,107.02,101.44,1.01,66.76,67.52,91.14,40.78,35.20','19.61,19.74,38.04,11.43,48.22,1.31,1.37,27.67,42.77,31.84,38.99,38.12,1.35,1.4,1.35,14.66,1.43,47.38,32.26,1.36,32.03,28.1,3.05,1.35,48.34,1.36,1.41,1.33,1.32,30.17,1.29,1.38,1.38,16.51,1.34,32.76,1.35,26.22,22.37,1.38,1.37,47.59,3.6,45.23,1.74,37.29,47.17,41.26,1.43,19.3,1.37,33.63,49.53,24.97,1.34,1.29,23.35,42.2,1.44,25.65,1.3,45.42,20.15,16.47,1.84,26.65,40.72,1.28,1.34,30.61,1.36,24.69,1.4,32.51,47.85,1.33,1.49,1.39,1.4,11,1.42,3.32,48.91,1.26,39.09,44.78,43.8,2.52,1.37,1.39,22.43,1.36,18.45,1.44,19.1,35.2,31.48,1.39,39.9,5.7'),(2,2,'50.22,5.17,5.02,3.92,26.5,56.68,43.53,5.4,5.58,5.12,4.92,5.59,9.42,5.11,44.14,5.04,4.8,4.89,5.02,4.81,50.98,43.98,4.93,50.83,5.89,4.59,6.52,5.16,5.06,4.67,40.04,32.2,27.46,4.81,5.12,53.02,5.19,5.26,5.54,4.92,23.1,30.4,5.07,5.06,4.91,5.05,5.91,4.92,5.13,43.4','1.08,57.04,1.12,1.08,1.13,1.20,10.67,64.77,31.12,1.13,13.72,1.18,3.54,1.16,46.18,35.94,1.18,1.14,45.20,1.14,1.09,1.06,1.03,45.67,19.98,74.38,1.11,1.13,1.78,1.01,1.55,69.70,57.31,1.10,75.45,1.29,1.21,1.03,1.03,65.72,1.18,21.75,1.06,1.11,84.08,84.71,1.19,2.42,1.15,57.00',NULL);

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
  `goods_desc_m` varchar(50) NOT NULL COMMENT '商品简短描述,用于分享出去链接显示',
  `attr1_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'attr1属性',
  `attr2_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'attr2属性',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0是线上，1是地推',
  PRIMARY KEY (`id`),
  KEY `attr2_id` (`attr2_id`),
  KEY `attr1_id` (`attr1_id`),
  KEY `type` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `bargain_goods` */

insert  into `bargain_goods`(`id`,`goods_name`,`img1_id`,`img2_id`,`activity_money`,`original_price`,`bargain_section`,`bargain_section2`,`join_count`,`goods_desc`,`goods_desc_m`,`attr1_id`,`attr2_id`,`type`) values (1,'隐适美隐形矫正','/static/bargain/images/sm_03.jpg','/static/bargain/images/big_02.jpg','33800.00','39800.00','','',0,'<ul><li><span style=\"font-size: 0.36rem\">Invisalign</span>隐适美系统是一种近乎隐形的创新型治疗方法,</li><li>可以轻柔而持久地矫正你的牙齿。 </li><li>既能满足矫正牙齿的需要,</li><li>又同时避免了传统托槽矫正能看到<em style=\"font-size: 0.36rem;font-style:normal;color: red;\">“钢牙”</em>的缺点。</li><li>只需佩戴一副透明的牙套，</li><li>就能让牙齿有效、精准的移动。</li></ul>','',0,0,0),(2,'进口金属自锁托槽矫正','/static/bargain/images/sm_05.jpg','/static/bargain/images/big_01.jpg','11800.00','13800.00','','',0,'<p style=\"text-indent: 2em;\">自锁正畸托槽是指在正畸治疗中，用一种专用的黏结剂固定在牙齿表面的一种金属或陶瓷等材料制成的装置，用于容纳和固定正畸钢丝，传递矫治力到牙齿，从而达到牙齿矫正的目的。</p>','',0,0,0);

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `bargain_users_info` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
