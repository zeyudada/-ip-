# Host: localhost  (Version: 5.7.26)
# Date: 2019-11-30 19:16:05
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "ip_config"
#

DROP TABLE IF EXISTS `ip_config`;
CREATE TABLE `ip_config` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(255) NOT NULL DEFAULT '',
  `pwd` varchar(255) NOT NULL DEFAULT '',
  `url` varchar(255) NOT NULL DEFAULT '',
  `sj` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

#
# Data for table "ip_config"
#

INSERT INTO `ip_config` VALUES (1,'admin','e10adc3949ba59abbe56e057f20f883e','https://www.baidu.com/','moren','泽宇大大','QQ红包');

#
# Structure for table "ip_list"
#

DROP TABLE IF EXISTS `ip_list`;
CREATE TABLE `ip_list` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) NOT NULL DEFAULT '',
  `time` varchar(255) NOT NULL DEFAULT '',
  `info` text NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

#
# Data for table "ip_list"
#

/*!40000 ALTER TABLE `ip_list` DISABLE KEYS */;
INSERT INTO `ip_list` VALUES (3,'127.0.0.1','2020-07-29 11:49:34','这是自带的一条记录，无视或者删除即可！');
/*!40000 ALTER TABLE `ip_list` ENABLE KEYS */;
