/*
SQLyog Ultimate v12.08 (64 bit)
MySQL - 5.6.35-log : Database - course_work
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`course_work` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `course_work`;

/*Table structure for table `os_user` */

CREATE TABLE `os_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL COMMENT '用户名',
  `password` varchar(50) NOT NULL COMMENT '密码',
  `actualname` varchar(50) DEFAULT NULL COMMENT '用户真实姓名',
  `sex` int(1) DEFAULT '0' COMMENT '用户性别 0-男 1-女',
  `avatarimg` varchar(200) DEFAULT NULL COMMENT '头像',
  `mobile` varchar(11) DEFAULT '' COMMENT '手机',
  `email` varchar(50) DEFAULT '' COMMENT '邮箱',
  `birthdate` date DEFAULT NULL COMMENT '出生日期',
  `jobtitle` varchar(32) DEFAULT NULL COMMENT '用户职称',
  `teachgrade` varchar(32) DEFAULT NULL COMMENT '授课年纪',
  `school` varchar(60) DEFAULT NULL COMMENT '学校名称',
  `address` varchar(80) DEFAULT NULL COMMENT '居住地址',
  `vercode` varchar(16) DEFAULT NULL COMMENT '手机验证码',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '用户状态  1 正常  2 禁止',
  `cstype` int(1) DEFAULT '0' COMMENT '参赛性质 0-个人;1-团体',
  `advance_status` int(1) DEFAULT '0' COMMENT '晋级状态 0-未晋级 1 晋级',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '用户信息更新时间',
  `last_login_time` datetime DEFAULT NULL COMMENT '最后登陆时间',
  `token` varchar(90) DEFAULT NULL COMMENT 'token令牌字符串',
  `time_out` time(6) DEFAULT NULL COMMENT 'token失效时间',
  `last_login_ip` varchar(50) DEFAULT '' COMMENT '最后登录IP',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=utf8 COMMENT='用户表';

/*Data for the table `os_user` */

insert  into `os_user`(`id`,`username`,`password`,`actualname`,`sex`,`avatarimg`,`mobile`,`email`,`birthdate`,`jobtitle`,`teachgrade`,`school`,`address`,`vercode`,`status`,`cstype`,`advance_status`,`create_time`,`update_time`,`last_login_time`,`token`,`time_out`,`last_login_ip`) values (1,'王峰','7b79e788e94c1c41b6d4e1b1280c4bdb','王峰',0,NULL,'12233333333','17256605@qq.com','2018-06-25','中教三级','八年级','北京十四中学','北京海淀区23号',NULL,1,0,0,'2018-06-23 00:53:31',NULL,NULL,NULL,NULL,''),(2,'zhangsan','7b79e788e94c1c41b6d4e1b1280c4bdb','张明',1,NULL,'18389562561','23@qq.com','2018-05-10','中教三级','七年级','北京十四中学','北京海淀区23号',NULL,1,0,0,'2018-06-23 00:54:07',NULL,NULL,NULL,NULL,''),(3,'wangpeixu','7b79e788e94c1c41b6d4e1b1280c4bdb','张明',1,NULL,'12385469856','45454@qq.com','2018-06-05','中教三级','九年级','北京十四中学','北京海淀区23号',NULL,1,0,0,'2018-06-23 00:54:30',NULL,NULL,NULL,NULL,''),(4,'wang','26365e2e8fe91ba7d997ed26dab7ac45','张明',1,NULL,'18311398247','1346@qq.com','2018-06-05','中教三级','八年级','北京十四中学','北京海淀区23号',NULL,1,1,0,'2018-06-23 00:55:19',NULL,NULL,NULL,NULL,''),(5,'zhang','7b79e788e94c1c41b6d4e1b1280c4bdb','张明',1,NULL,'18325698546','123@qq.com','1966-07-01','中教一级','八年级','北京十四中学','北京海淀区23号',NULL,1,1,0,'2018-06-23 00:55:46',NULL,NULL,NULL,NULL,''),(6,'asdfdsf','f89a0b233988125251413afc7226f416','张明',1,NULL,'18311398245','1212@qq.com','2018-06-05','中教三级','八年级','北京十四中学','北京海淀区23号',NULL,1,0,1,'2018-06-23 00:56:26',NULL,NULL,NULL,NULL,''),(7,'zhansan','7b79e788e94c1c41b6d4e1b1280c4bdb','张明',1,NULL,'15878956456','222@qq.com','2018-06-04','中教三级','八年级','北京十四中学','北京海淀区23号',NULL,1,0,1,'2018-06-23 00:57:06',NULL,NULL,NULL,NULL,''),(9,'wangsheg','7b79e788e94c1c41b6d4e1b1280c4bdb','张明',1,NULL,'18326589654','123456@qq.com','1966-07-01','中教三级','八年级','北京十四中学','北京海淀区23号',NULL,1,1,1,'2018-06-23 00:53:31',NULL,NULL,NULL,NULL,''),(20,'wasg','7b79e788e94c1c41b6d4e1b1280c4bdb','张奇',0,NULL,'18326589654','123456@qq.com','1966-07-01','中教三级','九年级','北京十四中学','北京海淀区23号',NULL,1,0,0,'2018-06-23 00:53:31',NULL,NULL,NULL,NULL,''),(21,'ag','7b79e788e94c1c41b6d4e1b1280c4bdb','张奇',0,NULL,'18326589654','123456@qq.com','1966-07-01','中教三级','八年级','北京十四中学','北京海淀区23号',NULL,1,0,0,'2018-06-23 00:53:31',NULL,NULL,NULL,NULL,''),(22,'王培旭','972af5f4e96f31d822f4a3acfcf79291','张奇',0,NULL,'18326589654','123456@qq.com','1966-07-01','中教三级','九年级','北京十四中学','北京海淀区23号',NULL,1,0,0,'2018-06-23 00:53:31',NULL,NULL,NULL,NULL,''),(38,'张江','6b47f37738f3e12eb2410a4d066a4e03',NULL,0,NULL,'18801456666','99999999@qq.com',NULL,NULL,NULL,NULL,NULL,NULL,1,0,0,'2018-06-27 14:09:03',NULL,NULL,NULL,NULL,''),(24,'wpx000','dec5167c8585e106f95655406f322062','wpx000',1,NULL,'18845454545','wpx000@abc.com','1991-01-06','中学作文大赛','八年级','北京时代中学','北京市海淀区',NULL,1,0,0,'2018-06-25 16:47:55','2018-06-27 13:37:10',NULL,NULL,NULL,''),(32,'王明阳','6b47f37738f3e12eb2410a4d066a4e03','张奇',1,NULL,'18877777777','99999999@qq.com',NULL,NULL,NULL,NULL,NULL,NULL,1,0,0,'2018-06-26 07:07:37',NULL,NULL,NULL,NULL,''),(43,'','d41d8cd98f00b204e9800998ecf8427e',NULL,0,NULL,'','',NULL,NULL,NULL,NULL,NULL,NULL,1,0,0,'2018-06-29 00:00:00',NULL,NULL,NULL,NULL,''),(42,'wangpx','6b47f37738f3e12eb2410a4d066a4e03',NULL,0,NULL,'18801454666','99966666@qq.com',NULL,NULL,NULL,NULL,NULL,NULL,1,0,0,'2018-06-29 00:00:00',NULL,NULL,NULL,NULL,''),(44,'wpxhhh','7b2b269c370c8a7c86fcf155b932494c',NULL,0,NULL,'18888888888','111000@abc.com',NULL,NULL,NULL,NULL,NULL,'1234',1,0,0,'2018-06-30 00:00:00',NULL,NULL,NULL,NULL,''),(45,'wpx999','86544e2ee73788e521ec2e49bc69e356',NULL,0,NULL,'18888888899','118888@abc.com',NULL,NULL,NULL,NULL,NULL,'2346',1,0,0,'2018-06-30 00:00:00',NULL,NULL,NULL,NULL,''),(46,'wpx111','58182358a46499f9dd99b09d8f255a87',NULL,0,NULL,'18888888111','11000011@abc.com',NULL,NULL,NULL,NULL,NULL,'1111',1,0,0,'2018-06-30 00:00:00',NULL,NULL,NULL,NULL,'');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
