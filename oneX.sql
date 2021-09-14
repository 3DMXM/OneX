# Host: 23.101.1.46  (Version: 5.6.50-log)
# Date: 2021-09-14 15:52:33
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "downloadurl"
#

CREATE TABLE `downloadurl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_path` varchar(500) DEFAULT NULL COMMENT '下载文件',
  `file_download_url` longtext COMMENT '下载地址',
  `file_up_time` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COMMENT='下载地址缓存';

#
# Structure for table "file_data"
#

CREATE TABLE `file_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) DEFAULT NULL COMMENT '文件名称',
  `file_path` varchar(500) DEFAULT NULL COMMENT '文件路径',
  `file_type` varchar(255) DEFAULT NULL COMMENT '文件类型',
  `file_data` longtext COMMENT '文件内容',
  `file_time` datetime DEFAULT NULL COMMENT '更新时间',
  `file_download_url` longtext COMMENT '文件下载地址',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='文件内容缓存';

#
# Structure for table "filelist"
#

CREATE TABLE `filelist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_parent` varchar(255) DEFAULT NULL COMMENT '父级目录',
  `file_name` varchar(255) DEFAULT NULL COMMENT '文件、文件名',
  `file_type` varchar(255) DEFAULT NULL COMMENT '文件类型 文件夹、文件、文本 等',
  `file_title` varchar(255) DEFAULT NULL COMMENT '自定义文件夹标题',
  `file_downloadUrl` longtext COMMENT '文件下载地址',
  `file_size` varchar(255) DEFAULT NULL COMMENT '文件大小',
  `file_time` varchar(255) DEFAULT NULL COMMENT '文件更新时间',
  `file_up_time` datetime DEFAULT NULL COMMENT '更新时间',
  `file_click_cnt` int(11) DEFAULT '0' COMMENT '游览量',
  PRIMARY KEY (`id`),
  KEY `file_name` (`file_name`),
  KEY `file_parent` (`file_parent`)
) ENGINE=MyISAM AUTO_INCREMENT=9354 DEFAULT CHARSET=utf8 COMMENT='文件列表';

#
# Structure for table "site_info"
#

CREATE TABLE `site_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_name` varchar(255) DEFAULT NULL COMMENT '网站名称',
  `password` varchar(255) DEFAULT NULL COMMENT '后台密码',
  `onedrive_root` varchar(255) DEFAULT NULL COMMENT '起始目录',
  `cache_expire_time` int(11) DEFAULT NULL COMMENT '缓存时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='网站数据';

#
# Structure for table "token"
#

CREATE TABLE `token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `scope` varchar(255) DEFAULT NULL COMMENT '获取权限范围',
  `expires_in` int(11) DEFAULT NULL COMMENT '过期时间',
  `expires_on` int(11) DEFAULT NULL,
  `access_token` longtext,
  `refresh_token` longtext,
  `client_id` varchar(255) DEFAULT NULL,
  `client_secret` varchar(255) DEFAULT NULL,
  `up_time` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='Onedrive Token';

#
# Structure for table "user"
#

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) DEFAULT NULL,
  `user_password` varchar(255) DEFAULT NULL COMMENT '密码',
  `user_last_login_time` datetime DEFAULT NULL COMMENT '最后登录时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户表';
