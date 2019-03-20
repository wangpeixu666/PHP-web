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

/*Table structure for table `os_admin_user` */

CREATE TABLE `os_admin_user` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL DEFAULT '' COMMENT '管理员用户名',
  `password` varchar(50) NOT NULL DEFAULT '' COMMENT '管理员密码',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态 1 启用 0 禁用',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `last_login_time` datetime DEFAULT NULL COMMENT '最后登录时间',
  `last_login_ip` varchar(20) DEFAULT NULL COMMENT '最后登录IP',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='管理员表';

/*Data for the table `os_admin_user` */

insert  into `os_admin_user`(`id`,`username`,`password`,`status`,`create_time`,`last_login_time`,`last_login_ip`) values (1,'admin','0dfc7612f607db6c17fd99388e9e5f9c',1,'2016-10-18 15:28:37','2018-06-28 14:03:00','218.247.224.130');

/*Table structure for table `os_article` */

CREATE TABLE `os_article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文章ID',
  `cid` smallint(5) unsigned NOT NULL COMMENT '分类ID',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `introduction` varchar(255) DEFAULT '' COMMENT '简介',
  `content` longtext COMMENT '内容',
  `author` varchar(20) DEFAULT '' COMMENT '作者',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态 0 待审核  1 审核',
  `reading` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '阅读量',
  `thumb` varchar(255) DEFAULT '' COMMENT '缩略图',
  `photo` text COMMENT '图集',
  `is_top` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否置顶  0 不置顶  1 置顶',
  `is_recommend` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否推荐  0 不推荐  1 推荐',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `publish_time` datetime NOT NULL COMMENT '发布时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='文章表';

/*Data for the table `os_article` */

insert  into `os_article`(`id`,`cid`,`title`,`introduction`,`content`,`author`,`status`,`reading`,`thumb`,`photo`,`is_top`,`is_recommend`,`sort`,`create_time`,`publish_time`) values (1,1,'测试文章一','','<p>测试内容</p>','admin',1,0,'',NULL,0,0,0,'2017-04-11 14:10:10','2017-04-11 14:09:45');

/*Table structure for table `os_auth_group` */

CREATE TABLE `os_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` varchar(255) NOT NULL COMMENT '权限规则ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='权限组表';

/*Data for the table `os_auth_group` */

insert  into `os_auth_group`(`id`,`title`,`status`,`rules`) values (1,'超级管理组',1,'1,2,3,73,74,5,6,7,8,9,10,11,12,39,40,41,42,43,14,13,20,21,22,23,24,15,25,26,27,28,29,30,16,17,44,45,46,47,48,18,49,50,51,52,53,19,31,32,33,34,35,36,37,54,55,58,59,60,61,62,56,63,64,65,66,67,57,68,69,70,71,72');

/*Table structure for table `os_auth_group_access` */

CREATE TABLE `os_auth_group_access` (
  `uid` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='权限组规则表';

/*Data for the table `os_auth_group_access` */

insert  into `os_auth_group_access`(`uid`,`group_id`) values (1,1);

/*Table structure for table `os_auth_rule` */

CREATE TABLE `os_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL DEFAULT '' COMMENT '规则名称',
  `title` varchar(20) NOT NULL,
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `pid` smallint(5) unsigned NOT NULL COMMENT '父级ID',
  `icon` varchar(50) DEFAULT '' COMMENT '图标',
  `sort` tinyint(4) unsigned NOT NULL COMMENT '排序',
  `condition` char(100) DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=79 DEFAULT CHARSET=utf8 COMMENT='规则表';

/*Data for the table `os_auth_rule` */

insert  into `os_auth_rule`(`id`,`name`,`title`,`type`,`status`,`pid`,`icon`,`sort`,`condition`) values (1,'admin/System/default','系统配置',1,1,0,'fa fa-gears',0,''),(2,'admin/System/siteConfig','站点配置',1,1,1,'',0,''),(3,'admin/System/updateSiteConfig','更新配置',1,0,1,'',0,''),(5,'admin/Menu/default','菜单管理',1,1,0,'fa fa-bars',0,''),(6,'admin/Menu/index','后台菜单',1,1,5,'',0,''),(7,'admin/Menu/add','添加菜单',1,0,6,'',0,''),(8,'admin/Menu/save','保存菜单',1,0,6,'',0,''),(9,'admin/Menu/edit','编辑菜单',1,0,6,'',0,''),(10,'admin/Menu/update','更新菜单',1,0,6,'',0,''),(11,'admin/Menu/delete','删除菜单',1,0,6,'',0,''),(12,'admin/Nav/index','导航管理',1,1,5,'',0,''),(13,'admin/Coursepre/index','初赛管理',1,1,14,'fa fa-sitemap',0,''),(14,'admin/Content/default','课件管理',1,1,0,'fa fa-file-text',6,''),(15,'admin/Courseremach/index','复赛管理',1,1,14,'',0,''),(16,'admin/User/default','用户管理',1,1,0,'fa fa-users',0,''),(17,'admin/User/index','普通用户',1,1,16,'',0,''),(18,'admin/AdminUser/index','管理员',1,1,16,'',0,''),(19,'admin/AuthGroup/index','权限组',1,1,16,'',0,''),(22,'admin/Coursepre/detail','初赛详情',1,0,13,'',0,''),(23,'admin/Coursepre/update','更新初赛',1,0,13,'',0,''),(24,'admin/Coursepre/delete','删除初赛',1,0,13,'',0,''),(27,'admin/Courseremach/edit','编辑复赛',1,0,15,'',0,''),(28,'admin/Courseremach/details','复赛详情',1,0,15,'',0,''),(29,'admin/Courseremach/delete','删除复赛',1,0,15,'',0,''),(30,'admin/Courseremach/toggle','复赛审核',1,0,15,'',0,''),(31,'admin/AuthGroup/add','添加权限组',1,0,19,'',0,''),(32,'admin/AuthGroup/save','保存权限组',1,0,19,'',0,''),(33,'admin/AuthGroup/edit','编辑权限组',1,0,19,'',0,''),(34,'admin/AuthGroup/update','更新权限组',1,0,19,'',0,''),(35,'admin/AuthGroup/delete','删除权限组',1,0,19,'',0,''),(36,'admin/AuthGroup/auth','授权',1,0,19,'',0,''),(37,'admin/AuthGroup/updateAuthGroupRule','更新权限组规则',1,0,19,'',0,''),(39,'admin/Nav/add','添加导航',1,0,12,'',0,''),(40,'admin/Nav/save','保存导航',1,0,12,'',0,''),(41,'admin/Nav/edit','编辑导航',1,0,12,'',0,''),(42,'admin/Nav/update','更新导航',1,0,12,'',0,''),(43,'admin/Nav/delete','删除导航',1,0,12,'',0,''),(44,'admin/User/add','添加用户',1,0,17,'',0,''),(45,'admin/User/save','保存用户',1,0,17,'',0,''),(46,'admin/User/edit','编辑用户',1,0,17,'',0,''),(47,'admin/User/update','更新用户',1,0,17,'',0,''),(48,'admin/User/delete','删除用户',1,0,17,'',0,''),(49,'admin/AdminUser/add','添加管理员',1,0,18,'',0,''),(50,'admin/AdminUser/save','保存管理员',1,0,18,'',0,''),(51,'admin/AdminUser/edit','编辑管理员',1,0,18,'',0,''),(52,'admin/AdminUser/update','更新管理员',1,0,18,'',0,''),(53,'admin/AdminUser/delete','删除管理员',1,0,18,'',0,''),(54,'admin/Slide/default','扩展管理',1,1,0,'fa fa-wrench',0,''),(55,'admin/SlideCategory/index','轮播分类',1,1,54,'',0,''),(56,'admin/Slide/index','轮播图管理',1,1,54,'',0,''),(57,'admin/Link/index','友情链接',1,1,54,'fa fa-link',0,''),(58,'admin/SlideCategory/add','添加分类',1,0,55,'',0,''),(59,'admin/SlideCategory/save','保存分类',1,0,55,'',0,''),(60,'admin/SlideCategory/edit','编辑分类',1,0,55,'',0,''),(61,'admin/SlideCategory/update','更新分类',1,0,55,'',0,''),(62,'admin/SlideCategory/delete','删除分类',1,0,55,'',0,''),(63,'admin/Slide/add','添加轮播',1,0,56,'',0,''),(64,'admin/Slide/save','保存轮播',1,0,56,'',0,''),(65,'admin/Slide/edit','编辑轮播',1,0,56,'',0,''),(66,'admin/Slide/update','更新轮播',1,0,56,'',0,''),(67,'admin/Slide/delete','删除轮播',1,0,56,'',0,''),(68,'admin/Link/add','添加链接',1,0,57,'',0,''),(69,'admin/Link/save','保存链接',1,0,57,'',0,''),(70,'admin/Link/edit','编辑链接',1,0,57,'',0,''),(71,'admin/Link/update','更新链接',1,0,57,'',0,''),(72,'admin/Link/delete','删除链接',1,0,57,'',0,''),(73,'admin/ChangePassword/index','修改密码',1,1,1,'',0,''),(74,'admin/ChangePassword/updatePassword','更新密码',1,0,1,'',0,''),(75,'admin/LevyapiUser/default','API接口管理',1,1,0,'fa fa-users',0,''),(76,'admin/LevyapiUser/index','API用户管理',1,1,75,'',0,''),(77,'admin/Statistics/default','统计分析',1,1,0,'fa fa-file-text',5,''),(78,'admin/Statistics/index','参赛统计',1,1,77,'',0,'');

/*Table structure for table `os_category` */

CREATE TABLE `os_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类ID',
  `name` varchar(50) NOT NULL COMMENT '分类名称',
  `alias` varchar(50) DEFAULT '' COMMENT '导航别名',
  `content` longtext COMMENT '分类内容',
  `thumb` varchar(255) DEFAULT '' COMMENT '缩略图',
  `icon` varchar(20) DEFAULT '' COMMENT '分类图标',
  `list_template` varchar(50) DEFAULT '' COMMENT '分类列表模板',
  `detail_template` varchar(50) DEFAULT '' COMMENT '分类详情模板',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '分类类型  1  列表  2 单页',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类ID',
  `path` varchar(255) DEFAULT '' COMMENT '路径',
  `create_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='分类表';

/*Data for the table `os_category` */

insert  into `os_category`(`id`,`name`,`alias`,`content`,`thumb`,`icon`,`list_template`,`detail_template`,`type`,`sort`,`pid`,`path`,`create_time`) values (1,'分类一','','','','','','',1,0,0,'0,','2016-12-22 18:22:24');

/*Table structure for table `os_levyapi_user` */

CREATE TABLE `os_levyapi_user` (
  `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(75) DEFAULT NULL,
  `user_pwd` varchar(75) DEFAULT NULL,
  `access_token` char(90) DEFAULT NULL,
  `app_key` char(120) DEFAULT NULL,
  `create_time` varchar(60) DEFAULT NULL,
  `app_id` char(90) DEFAULT NULL,
  `status` enum('1','0') DEFAULT '1' COMMENT '是否删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `os_levyapi_user` */

insert  into `os_levyapi_user`(`id`,`user_name`,`user_pwd`,`access_token`,`app_key`,`create_time`,`app_id`,`status`) values (1,'中版集团数字传媒有限公司\r\n','sheng','s5s4d5s5d5as5s5s4d5s4d5s4d5s4d','s5s5d4e8er4s5df4s5df4s5sdw8e8r8t8t8t5g5f',NULL,'735fefbe97903a6480f9fbc14','1'),(4,'asdfasdf','139960872bfe648944b0aaa8050b0234','XcJ5EyCKRlBprZRsR7fhfHvSFqHiWM','onzXtQgDfMEuvXWarly3ckzTirXWvRbIE8F3CcZT','2018-06-24 20:12:59','jILTQlPJLre0VcVG87FPRhHal','1'),(6,'张烨','cb5e4b0a14f5fff8a93a56377ce77d74','HPyzgN0HVW8rRKQYw2TE1tS0OpyoNK','Fc0NENllYprcTdiEwoPhQsdp7dv69P64Ie9tPR51','2018-06-25 15:08:06','fyydpT44muhINSUXiR6BAelJI','1');

/*Table structure for table `os_link` */

CREATE TABLE `os_link` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '链接名称',
  `link` varchar(255) DEFAULT '' COMMENT '链接地址',
  `image` varchar(255) DEFAULT '' COMMENT '链接图片',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态 1 显示  2 隐藏',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='友情链接表';

/*Data for the table `os_link` */

/*Table structure for table `os_nav` */

CREATE TABLE `os_nav` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL COMMENT '父ID',
  `name` varchar(20) NOT NULL COMMENT '导航名称',
  `alias` varchar(20) DEFAULT '' COMMENT '导航别称',
  `link` varchar(255) DEFAULT '' COMMENT '导航链接',
  `icon` varchar(255) DEFAULT '' COMMENT '导航图标',
  `target` varchar(10) DEFAULT '' COMMENT '打开方式',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态  0 隐藏  1 显示',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='导航表';

/*Data for the table `os_nav` */

/*Table structure for table `os_slide` */

CREATE TABLE `os_slide` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cid` int(10) unsigned NOT NULL COMMENT '分类ID',
  `name` varchar(50) NOT NULL COMMENT '轮播图名称',
  `description` varchar(255) DEFAULT '' COMMENT '说明',
  `link` varchar(255) DEFAULT '' COMMENT '链接',
  `target` varchar(10) DEFAULT '' COMMENT '打开方式',
  `image` varchar(255) DEFAULT '' COMMENT '轮播图片',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态  1 显示  0  隐藏',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='轮播图表';

/*Data for the table `os_slide` */

/*Table structure for table `os_slide_category` */

CREATE TABLE `os_slide_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '轮播图分类',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='轮播图分类表';

/*Data for the table `os_slide_category` */

insert  into `os_slide_category`(`id`,`name`) values (1,'首页轮播');

/*Table structure for table `os_system` */

CREATE TABLE `os_system` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '配置项名称',
  `value` text NOT NULL COMMENT '配置项值',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='系统配置表';

/*Data for the table `os_system` */

insert  into `os_system`(`id`,`name`,`value`) values (1,'site_config','a:7:{s:10:\"site_title\";s:30:\"Think Admin 后台管理系统\";s:9:\"seo_title\";s:0:\"\";s:11:\"seo_keyword\";s:0:\"\";s:15:\"seo_description\";s:0:\"\";s:14:\"site_copyright\";s:0:\"\";s:8:\"site_icp\";s:0:\"\";s:11:\"site_tongji\";s:0:\"\";}');

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

/*Table structure for table `os_usercontent` */

CREATE TABLE `os_usercontent` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `userid` int(11) unsigned DEFAULT NULL COMMENT '用户id',
  `csname` varchar(200) DEFAULT NULL COMMENT '初赛课件名称',
  `designname` varchar(200) DEFAULT NULL COMMENT '初赛教学设计',
  `demoname` varchar(200) DEFAULT NULL COMMENT '初赛演示课件',
  `evaluatename` varchar(200) DEFAULT NULL COMMENT '初赛评测练习',
  `recsname` varchar(90) DEFAULT NULL COMMENT '复赛课件名称',
  `videoURL` varchar(100) DEFAULT NULL COMMENT '复赛课件视频地址',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `os_usercontent` */

insert  into `os_usercontent`(`id`,`userid`,`csname`,`designname`,`demoname`,`evaluatename`,`recsname`,`videoURL`) values (1,1,'初赛课件]北京师范大学附属实验中学-张奇-8467','[教学设计]北京师范大学附属实验中学-张奇-8467.docx','[演示课件]北京师范大学附属实验中学-张奇-8467.ppt','[评测练习]北京师范大学附属实验中学-张奇-8467.docx',NULL,'https://v.youku.com/'),(2,2,'初赛课件]北京师范大学附属实验中学-','[教学设计]北京师范大学附属实验中学-张奇-8467.docx','[演示课件]北京师范大学附属实验中学.ppt','[评测练习]北京师范大学附属实验中学.docx',NULL,'https://v.youku.com/'),(3,3,'初赛课件]北京师范大学附属实验中学-','初赛课件]北京师范大学附属实验中学-','初赛课件]北京师范大学附属实验中学-','[评测练习]北京师范大学附属实验中学.docx',NULL,'https://v.youku.com/'),(6,24,'北京师范大学附属实验中学-wpx-8467','北京师范大学附属实验中学-wpx-8467','北京师范大学附属实验中学-wpx-8467','北京师范大学附属实验中学-wpx-8467',NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
