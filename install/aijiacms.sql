
DROP TABLE IF EXISTS `aijiacms_404`;
CREATE TABLE `aijiacms_404` (
  `itemid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL DEFAULT '',
  `robot` varchar(20) NOT NULL DEFAULT '',
  `username` varchar(30) NOT NULL DEFAULT '',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`)
) TYPE=MyISAM COMMENT='404日志';

DROP TABLE IF EXISTS `aijiacms_ad`;
CREATE TABLE `aijiacms_ad` (
  `aid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '',
  `pid` int(10) unsigned NOT NULL DEFAULT '0',
  `typeid` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  `amount` float NOT NULL DEFAULT '0',
  `currency` varchar(20) NOT NULL DEFAULT '',
  `url` varchar(255) NOT NULL DEFAULT '',
  `introduce` varchar(255) NOT NULL DEFAULT '',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `fromtime` int(10) unsigned NOT NULL DEFAULT '0',
  `totime` int(10) unsigned NOT NULL DEFAULT '0',
  `stat` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `note` text NOT NULL,
  `code` text NOT NULL,
  `text_name` varchar(100) NOT NULL DEFAULT '',
  `text_url` varchar(255) NOT NULL DEFAULT '',
  `text_title` varchar(100) NOT NULL DEFAULT '',
  `text_style` varchar(50) NOT NULL DEFAULT '',
  `image_src` varchar(255) NOT NULL DEFAULT '',
  `image_url` varchar(255) NOT NULL DEFAULT '',
  `image_alt` varchar(100) NOT NULL DEFAULT '',
  `flash_src` varchar(255) NOT NULL DEFAULT '',
  `flash_url` varchar(255) NOT NULL DEFAULT '',
  `flash_loop` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `key_moduleid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `key_catid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `key_word` varchar(100) NOT NULL DEFAULT '',
  `key_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `listorder` smallint(4) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`aid`),
  KEY `pid` (`pid`)
) TYPE=MyISAM COMMENT='广告';



DROP TABLE IF EXISTS `aijiacms_stats`;
CREATE TABLE `aijiacms_stats` (
  `id` varchar(8) NOT NULL,
  `uv` int(10) unsigned NOT NULL DEFAULT '0',
  `uv_pc` int(10) unsigned NOT NULL DEFAULT '0',
  `uv_mb` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` int(10) unsigned NOT NULL DEFAULT '0',
  `ip_pc` int(10) unsigned NOT NULL DEFAULT '0',
  `ip_mb` int(10) unsigned NOT NULL DEFAULT '0',
  `pv` int(10) unsigned NOT NULL DEFAULT '0',
  `pv_pc` int(10) unsigned NOT NULL DEFAULT '0',
  `pv_mb` int(10) unsigned NOT NULL DEFAULT '0',
  `rb` int(10) unsigned NOT NULL DEFAULT '0',
  `rb_pc` int(10) unsigned NOT NULL DEFAULT '0',
  `rb_mb` int(10) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='统计汇总';



DROP TABLE IF EXISTS `aijiacms_stats_pv`;
CREATE TABLE `aijiacms_stats_pv` (
  `sid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `mid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `url` varchar(255) NOT NULL DEFAULT '',
  `refer` varchar(255) NOT NULL,
  `domain` varchar(100) NOT NULL,
  `homepage` varchar(30) NOT NULL,
  `username` varchar(30) NOT NULL DEFAULT '',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `robot` varchar(20) NOT NULL,
  `pc` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`sid`),
  KEY `homepage` (`homepage`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='统计PV';



DROP TABLE IF EXISTS `aijiacms_stats_screen`;
CREATE TABLE `aijiacms_stats_screen` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(50) NOT NULL DEFAULT '',
  `width` int(10) unsigned NOT NULL DEFAULT '0',
  `height` int(10) unsigned NOT NULL DEFAULT '0',
  `ua` text NOT NULL,
  `url` varchar(255) NOT NULL,
  `refer` varchar(255) NOT NULL,
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='统计屏幕';


DROP TABLE IF EXISTS `aijiacms_stats_user`;
CREATE TABLE `aijiacms_stats_user` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `id` varchar(8) NOT NULL,
  `ip` int(10) unsigned NOT NULL DEFAULT '0',
  `ip_pc` int(10) unsigned NOT NULL DEFAULT '0',
  `ip_mb` int(10) unsigned NOT NULL DEFAULT '0',
  `pv` int(10) unsigned NOT NULL DEFAULT '0',
  `pv_pc` int(10) unsigned NOT NULL DEFAULT '0',
  `pv_mb` int(10) unsigned NOT NULL DEFAULT '0',
  `rb` int(10) unsigned NOT NULL DEFAULT '0',
  `rb_pc` int(10) unsigned NOT NULL DEFAULT '0',
  `rb_mb` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`),
  KEY `id` (`id`),
  KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='统计商家';


DROP TABLE IF EXISTS `aijiacms_stats_uv`;
CREATE TABLE `aijiacms_stats_uv` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(50) NOT NULL DEFAULT '',
  `robot` varchar(20) NOT NULL,
  `area` varchar(255) NOT NULL,
  `country` varchar(100) NOT NULL,
  `province` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `network` varchar(50) NOT NULL,
  `screen` varchar(20) NOT NULL,
  `pc` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `ua` text NOT NULL,
  `os` varchar(50) NOT NULL,
  `bs` varchar(50) NOT NULL,
  `bd` varchar(50) NOT NULL,
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`),
  KEY `ip` (`ip`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='统计UV';




-- 
-- 表的结构 `aijiacms_cart`
-- 

DROP TABLE IF EXISTS `aijiacms_cart`;
CREATE TABLE `aijiacms_cart` (
  `userid` bigint(20) unsigned NOT NULL default '0',
  `data` text NOT NULL,
  `edittime` int(10) unsigned NOT NULL default '0',
  UNIQUE KEY `userid` (`userid`)
) TYPE=MyISAM COMMENT='购物车';

-- --------------------------------------------------------

DROP TABLE IF EXISTS `aijiacms_address`;
CREATE TABLE `aijiacms_address` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `truename` varchar(30) NOT NULL DEFAULT '',
  `address` varchar(255) NOT NULL DEFAULT '',
  `postcode` varchar(10) NOT NULL DEFAULT '',
  `telephone` varchar(30) NOT NULL DEFAULT '',
  `mobile` varchar(30) NOT NULL DEFAULT '',
  `username` varchar(30) DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `listorder` smallint(4) unsigned NOT NULL DEFAULT '0',
  `note` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`),
  KEY `username` (`username`)
) TYPE=MyISAM COMMENT='收货地址';

DROP TABLE IF EXISTS `aijiacms_admin`;
CREATE TABLE `aijiacms_admin` (
  `adminid` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `listorder` smallint(4) unsigned NOT NULL DEFAULT '0',
  `title` varchar(30) NOT NULL DEFAULT '',
  `url` varchar(255) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `moduleid` smallint(6) NOT NULL DEFAULT '0',
  `file` varchar(20) NOT NULL DEFAULT '',
  `action` varchar(255) NOT NULL DEFAULT '',
  `catid` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`adminid`)
) TYPE=MyISAM COMMENT='管理员';



DROP TABLE IF EXISTS `aijiacms_admin_log`;
CREATE TABLE `aijiacms_admin_log` (
  `logid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `qstring` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(30) NOT NULL DEFAULT '',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `logtime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`logid`)
) TYPE=MyISAM COMMENT='管理日志';


DROP TABLE IF EXISTS `aijiacms_admin_online`;
CREATE TABLE `aijiacms_admin_online` (
  `sid` varchar(32) NOT NULL DEFAULT '',
  `username` varchar(30) NOT NULL DEFAULT '',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `moduleid` int(10) unsigned NOT NULL DEFAULT '0',
  `qstring` varchar(255) NOT NULL DEFAULT '',
  `lasttime` int(10) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `sid` (`sid`)
) TYPE=HEAP COMMENT='在线管理员';


DROP TABLE IF EXISTS `aijiacms_ad_place`;
CREATE TABLE `aijiacms_ad_place` (
  `pid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `moduleid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `typeid` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `open` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `name` varchar(255) NOT NULL DEFAULT '',
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `introduce` varchar(255) NOT NULL DEFAULT '',
  `code` text NOT NULL,
  `width` smallint(5) unsigned NOT NULL DEFAULT '0',
  `height` smallint(5) unsigned NOT NULL DEFAULT '0',
  `price` float unsigned NOT NULL DEFAULT '0',
  `ads` smallint(4) unsigned NOT NULL DEFAULT '0',
  `listorder` smallint(4) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `template` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`pid`)
) TYPE=MyISAM COMMENT='广告位';



DROP TABLE IF EXISTS `aijiacms_alert`;
CREATE TABLE `aijiacms_alert` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `mid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  `word` varchar(100) NOT NULL DEFAULT '',
  `rate` smallint(4) unsigned NOT NULL DEFAULT '0',
  `email` varchar(50) NOT NULL DEFAULT '',
  `username` varchar(30) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '0',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `sendtime` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`),
  KEY `username` (`username`)
) TYPE=MyISAM COMMENT='房源提醒';

DROP TABLE IF EXISTS `aijiacms_announce`;
CREATE TABLE `aijiacms_announce` (
  `itemid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `typeid` int(10) unsigned NOT NULL DEFAULT '0',
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `fromtime` int(10) unsigned NOT NULL DEFAULT '0',
  `totime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `islink` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  `listorder` smallint(4) unsigned NOT NULL DEFAULT '0',
  `template` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`),
  KEY `addtime` (`addtime`)
) TYPE=MyISAM COMMENT='公告';


DROP TABLE IF EXISTS `aijiacms_area`;
CREATE TABLE `aijiacms_area` (
  `areaid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `areaname` varchar(50) NOT NULL DEFAULT '',
  `parentid` int(10) unsigned NOT NULL DEFAULT '0',
  `arrparentid` varchar(255) NOT NULL DEFAULT '',
  `child` tinyint(1) NOT NULL DEFAULT '0',
  `arrchildid` text NOT NULL,
  `listorder` smallint(4) unsigned NOT NULL DEFAULT '0',
  `map` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`areaid`)
) TYPE=MyISAM COMMENT='地区';



DROP TABLE IF EXISTS `aijiacms_article_8`;
CREATE TABLE `aijiacms_article_8` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `fee` float NOT NULL DEFAULT '0',
  `subtitle` text NOT NULL,
  `introduce` varchar(255) NOT NULL DEFAULT '',
  `tag` varchar(100) NOT NULL DEFAULT '',
  `keyword` varchar(255) NOT NULL DEFAULT '',
  `pptword` varchar(255) NOT NULL DEFAULT '',
  `author` varchar(50) NOT NULL DEFAULT '',
  `copyfrom` varchar(30) NOT NULL DEFAULT '',
  `fromurl` varchar(255) NOT NULL DEFAULT '',
  `voteid` varchar(100) NOT NULL DEFAULT '',
  `comments` int(10) unsigned NOT NULL default '0',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(30) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `template` varchar(30) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `islink` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  `filepath` varchar(255) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  `houseid` int(10) DEFAULT NULL,
  `housename` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`itemid`),
  KEY `addtime` (`addtime`),
  KEY `catid` (`catid`),
  KEY `username` (`username`)
) TYPE=MyISAM COMMENT='资讯';


DROP TABLE IF EXISTS `aijiacms_article_data_8`;
CREATE TABLE `aijiacms_article_data_8` (
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` longtext NOT NULL,
  PRIMARY KEY (`itemid`)
) TYPE=MyISAM COMMENT='资讯内容';


DROP TABLE IF EXISTS `aijiacms_ask`;
CREATE TABLE `aijiacms_ask` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `typeid` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `username` varchar(30) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `admin` varchar(30) NOT NULL DEFAULT '',
  `admintime` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `reply` text NOT NULL,
  `star` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `houseid` int(10) NOT NULL,
  `tousername` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`)
) TYPE=MyISAM COMMENT='客服中心';

DROP TABLE IF EXISTS `aijiacms_appolist`;
CREATE TABLE `aijiacms_appolist` (
  `appo_list_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) CHARACTER SET utf8 NOT NULL,
  `house_id` int(11) NOT NULL,
  `house_title` varchar(255) CHARACTER SET utf8 NOT NULL,
  `update_time` varchar(255) CHARACTER SET utf8 NOT NULL,
  `appo_site` char(10) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`appo_list_id`),
  KEY `user_id` (`username`,`house_id`)
) TYPE=MyISAM COMMENT='预约刷新';

DROP TABLE IF EXISTS `aijiacms_banip`;
CREATE TABLE `aijiacms_banip` (
  `itemid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(50) NOT NULL DEFAULT '',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `totime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`)
) TYPE=MyISAM COMMENT='IP禁止';


DROP TABLE IF EXISTS `aijiacms_banword`;
CREATE TABLE `aijiacms_banword` (
  `bid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `replacefrom` varchar(255) NOT NULL DEFAULT '',
  `replaceto` varchar(255) NOT NULL DEFAULT '',
  `deny` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`bid`)
) TYPE=MyISAM COMMENT='词语过滤';


DROP TABLE IF EXISTS `aijiacms_buy_16`;
CREATE TABLE `aijiacms_buy_16` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `typeid` smallint(2) unsigned NOT NULL DEFAULT '0',
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `fee` float NOT NULL DEFAULT '0',
  `introduce` varchar(255) NOT NULL DEFAULT '',
  `n1` varchar(100) NOT NULL,
  `n2` varchar(100) NOT NULL,
  `n3` varchar(100) NOT NULL,
  `v1` varchar(100) NOT NULL,
  `v2` varchar(100) NOT NULL,
  `v3` varchar(100) NOT NULL,
  `amount` varchar(10) NOT NULL DEFAULT '',
  `price` varchar(10) NOT NULL DEFAULT '',
  `pack` varchar(20) NOT NULL DEFAULT '',
  `days` smallint(3) unsigned NOT NULL DEFAULT '0',
  `tag` varchar(100) NOT NULL DEFAULT '',
  `keyword` varchar(255) NOT NULL DEFAULT '',
  `pptword` varchar(255) NOT NULL DEFAULT '',
  `comments` int(10) unsigned NOT NULL default '0',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `thumb1` varchar(255) NOT NULL DEFAULT '',
  `thumb2` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(30) NOT NULL DEFAULT '',
  `groupid` smallint(4) unsigned NOT NULL DEFAULT '0',
  `company` varchar(100) NOT NULL DEFAULT '',
  `vip` smallint(2) unsigned NOT NULL DEFAULT '0',
  `validated` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `truename` varchar(30) NOT NULL DEFAULT '',
  `telephone` varchar(50) NOT NULL DEFAULT '',
  `mobile` varchar(50) NOT NULL DEFAULT '',
  `address` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `msn` varchar(50) NOT NULL DEFAULT '',
  `qq` varchar(20) NOT NULL DEFAULT '',
  `ali` varchar(30) NOT NULL DEFAULT '',
    `wx` varchar(50) NOT NULL DEFAULT '',
  `skype` varchar(30) NOT NULL DEFAULT '',
  `totime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `editdate` date NOT NULL DEFAULT '0000-00-00',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `adddate` date NOT NULL DEFAULT '0000-00-00',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `template` varchar(30) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  `filepath` varchar(255) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  `room` varchar(50) NOT NULL DEFAULT '',
  `hall` varchar(50) NOT NULL,
  `toilet` varchar(50) NOT NULL DEFAULT '',
  `balcony` varchar(50) NOT NULL DEFAULT '',
  `houseearm` int(19) NOT NULL,
  PRIMARY KEY (`itemid`),
  KEY `username` (`username`),
  KEY `editdate` (`editdate`,`vip`,`edittime`),
  KEY `edittime` (`edittime`),
  KEY `catid` (`catid`),
  KEY `areaid` (`areaid`)
) TYPE=MyISAM COMMENT='求购';


DROP TABLE IF EXISTS `aijiacms_buy_data_16`;
CREATE TABLE `aijiacms_buy_data_16` (
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` mediumtext NOT NULL,
  PRIMARY KEY (`itemid`)
) TYPE=MyISAM COMMENT='求购内容';


DROP TABLE IF EXISTS `aijiacms_cache`;
CREATE TABLE `aijiacms_cache` (
  `cacheid` varchar(32) NOT NULL DEFAULT '',
  `totime` int(10) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `cacheid` (`cacheid`)
) TYPE=MyISAM COMMENT='文件缓存';


DROP TABLE IF EXISTS `aijiacms_category`;
CREATE TABLE `aijiacms_category` (
  `catid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `moduleid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `catname` varchar(50) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `catdir` varchar(255) NOT NULL DEFAULT '',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  `letter` varchar(4) NOT NULL DEFAULT '',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `item` bigint(20) unsigned NOT NULL DEFAULT '0',
  `property` smallint(6) unsigned NOT NULL DEFAULT '0',
  `parentid` int(10) unsigned NOT NULL DEFAULT '0',
  `arrparentid` varchar(255) NOT NULL DEFAULT '',
  `child` tinyint(1) NOT NULL DEFAULT '0',
  `arrchildid` text NOT NULL,
  `listorder` smallint(4) unsigned NOT NULL DEFAULT '0',
  `template` varchar(30) NOT NULL DEFAULT '',
  `show_template` varchar(30) NOT NULL DEFAULT '',
  `seo_title` varchar(255) NOT NULL DEFAULT '',
  `seo_keywords` varchar(255) NOT NULL DEFAULT '',
  `seo_description` varchar(255) NOT NULL DEFAULT '',
  `group_list` varchar(255) NOT NULL DEFAULT '',
  `group_show` varchar(255) NOT NULL DEFAULT '',
  `group_add` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`catid`)
) TYPE=MyISAM COMMENT='栏目分类';



DROP TABLE IF EXISTS `aijiacms_category_option`;
CREATE TABLE `aijiacms_category_option` (
  `oid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `required` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `search` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `value` text NOT NULL,
  `extend` text NOT NULL,
  `listorder` smallint(4) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`oid`),
  KEY `catid` (`catid`)
) TYPE=MyISAM COMMENT='分类属性';


DROP TABLE IF EXISTS `aijiacms_category_value`;
CREATE TABLE `aijiacms_category_value` (
  `oid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `moduleid` smallint(6) NOT NULL DEFAULT '0',
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `value` text NOT NULL,
  KEY `moduleid` (`moduleid`,`itemid`)
) TYPE=MyISAM COMMENT='分类属性值';


DROP TABLE IF EXISTS `aijiacms_chat`;
CREATE TABLE `aijiacms_chat` (
  `chatid` varchar(32) NOT NULL,
  `fromuser` varchar(30) NOT NULL,
  `fromnick` varchar(50) NOT NULL,
  `fgettime` int(10) unsigned NOT NULL DEFAULT '0',
  `freadtime` int(10) unsigned NOT NULL DEFAULT '0',
  `fnew` int(10) unsigned NOT NULL DEFAULT '0',
  `touser` varchar(30) NOT NULL,
  `tonick` varchar(50) NOT NULL,
  `tgettime` int(10) unsigned NOT NULL DEFAULT '0',
  `treadtime` int(10) unsigned NOT NULL DEFAULT '0',
  `tnew` int(10) unsigned NOT NULL DEFAULT '0',
  `lastmsg` varchar(255) NOT NULL,
  `lasttime` int(10) unsigned NOT NULL DEFAULT '0',
  `forward` varchar(255) NOT NULL,
  UNIQUE KEY `chatid` (`chatid`),
  KEY `fromuser` (`fromuser`),
  KEY `lasttime` (`lasttime`),
  KEY `touser` (`touser`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='在线聊天';

DROP TABLE IF EXISTS `aijiacms_chat_data_0`;
CREATE TABLE `aijiacms_chat_data_0` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `chatid` varchar(32) NOT NULL,
  `username` varchar(30) NOT NULL,
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  `nickname` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`itemid`),
  KEY `chatid` (`chatid`),
  KEY `addtime` (`addtime`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='聊天记录_0';

DROP TABLE IF EXISTS `aijiacms_chat_data_1`;
CREATE TABLE `aijiacms_chat_data_1` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `chatid` varchar(32) NOT NULL,
  `username` varchar(30) NOT NULL,
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  `nickname` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`itemid`),
  KEY `chatid` (`chatid`),
  KEY `addtime` (`addtime`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='聊天记录_1';

DROP TABLE IF EXISTS `aijiacms_chat_data_2`;
CREATE TABLE `aijiacms_chat_data_2` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `chatid` varchar(32) NOT NULL,
  `username` varchar(30) NOT NULL,
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  `nickname` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`itemid`),
  KEY `chatid` (`chatid`),
  KEY `addtime` (`addtime`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='聊天记录_2';


DROP TABLE IF EXISTS `aijiacms_chat_data_3`;
CREATE TABLE `aijiacms_chat_data_3` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `chatid` varchar(32) NOT NULL,
  `username` varchar(30) NOT NULL,
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  `nickname` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`itemid`),
  KEY `chatid` (`chatid`),
  KEY `addtime` (`addtime`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='聊天记录_3';



DROP TABLE IF EXISTS `aijiacms_chat_data_4`;
CREATE TABLE `aijiacms_chat_data_4` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `chatid` varchar(32) NOT NULL,
  `username` varchar(30) NOT NULL,
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  `nickname` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`itemid`),
  KEY `chatid` (`chatid`),
  KEY `addtime` (`addtime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='聊天记录_4';


DROP TABLE IF EXISTS `aijiacms_chat_data_5`;
CREATE TABLE `aijiacms_chat_data_5` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `chatid` varchar(32) NOT NULL,
  `username` varchar(30) NOT NULL,
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  `nickname` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`itemid`),
  KEY `chatid` (`chatid`),
  KEY `addtime` (`addtime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='聊天记录_5';


DROP TABLE IF EXISTS `aijiacms_chat_data_6`;
CREATE TABLE `aijiacms_chat_data_6` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `chatid` varchar(32) NOT NULL,
  `username` varchar(30) NOT NULL,
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  `nickname` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`itemid`),
  KEY `chatid` (`chatid`),
  KEY `addtime` (`addtime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='聊天记录_6';


DROP TABLE IF EXISTS `aijiacms_chat_data_7`;
CREATE TABLE `aijiacms_chat_data_7` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `chatid` varchar(32) NOT NULL,
  `username` varchar(30) NOT NULL,
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  `nickname` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`itemid`),
  KEY `chatid` (`chatid`),
  KEY `addtime` (`addtime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='聊天记录_7';


DROP TABLE IF EXISTS `aijiacms_chat_data_8`;
CREATE TABLE `aijiacms_chat_data_8` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `chatid` varchar(32) NOT NULL,
  `username` varchar(30) NOT NULL,
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  `nickname` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`itemid`),
  KEY `chatid` (`chatid`),
  KEY `addtime` (`addtime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='聊天记录_8';


DROP TABLE IF EXISTS `aijiacms_chat_data_9`;
CREATE TABLE `aijiacms_chat_data_9` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `chatid` varchar(32) NOT NULL,
  `username` varchar(30) NOT NULL,
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  `nickname` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`itemid`),
  KEY `chatid` (`chatid`),
  KEY `addtime` (`addtime`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='聊天记录_9';


DROP TABLE IF EXISTS `aijiacms_city`;
CREATE TABLE `aijiacms_city` (
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `iparea` text NOT NULL,
  `domain` varchar(255) NOT NULL DEFAULT '',
  `letter` varchar(4) NOT NULL DEFAULT '',
  `listorder` smallint(4) unsigned NOT NULL DEFAULT '0',
  `template` varchar(50) NOT NULL DEFAULT '',
  `seo_title` varchar(255) NOT NULL DEFAULT '',
  `seo_keywords` varchar(255) NOT NULL DEFAULT '',
  `seo_description` varchar(255) NOT NULL DEFAULT '',
  `hits` int(5) DEFAULT NULL,
  `map_mid` varchar(30) DEFAULT NULL,
  UNIQUE KEY `areaid` (`areaid`),
  KEY `domain` (`domain`)
) TYPE=MyISAM COMMENT='城市分站';


DROP TABLE IF EXISTS `aijiacms_comment`;
CREATE TABLE `aijiacms_comment` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `item_mid` smallint(6) NOT NULL DEFAULT '0',
  `item_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `item_title` varchar(255) NOT NULL DEFAULT '',
  `item_username` varchar(30) NOT NULL DEFAULT '',
  `star` tinyint(1) NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  `qid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `quotation` text NOT NULL,
  `username` varchar(30) NOT NULL DEFAULT '',
  `passport` varchar(30) NOT NULL DEFAULT '',
  `hidden` tinyint(1) NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `reply` text NOT NULL,
  `editor` varchar(30) NOT NULL DEFAULT '',
  `replyer` varchar(30) NOT NULL DEFAULT '',
  `replytime` int(10) unsigned NOT NULL DEFAULT '0',
  `agree` int(10) unsigned NOT NULL DEFAULT '0',
  `against` int(10) unsigned NOT NULL DEFAULT '0',
  `quote` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`),
  KEY `item_mid` (`item_mid`),
  KEY `item_id` (`item_id`)
) TYPE=MyISAM COMMENT='评论';


DROP TABLE IF EXISTS `aijiacms_comment_ban`;
CREATE TABLE `aijiacms_comment_ban` (
  `bid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `moduleid` smallint(6) NOT NULL DEFAULT '0',
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`bid`)
) TYPE=MyISAM COMMENT='评论禁止';


DROP TABLE IF EXISTS `aijiacms_comment_stat`;
CREATE TABLE `aijiacms_comment_stat` (
  `sid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `moduleid` smallint(6) NOT NULL DEFAULT '0',
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `comment` int(10) unsigned NOT NULL DEFAULT '0',
  `star1` int(10) unsigned NOT NULL DEFAULT '0',
  `star2` int(10) unsigned NOT NULL DEFAULT '0',
  `star3` int(10) unsigned NOT NULL DEFAULT '0',
  `star4` int(10) unsigned NOT NULL DEFAULT '0',
  `star5` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`sid`)
) TYPE=MyISAM COMMENT='评论统计';


DROP TABLE IF EXISTS `aijiacms_company`;
CREATE TABLE `aijiacms_company` (
  `userid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `groupid` smallint(4) unsigned NOT NULL DEFAULT '0',
  `company` varchar(100) NOT NULL DEFAULT '',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `validated` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `validator` varchar(100) NOT NULL DEFAULT '',
  `validtime` int(10) unsigned NOT NULL DEFAULT '0',
  `vip` smallint(2) unsigned NOT NULL DEFAULT '0',
  `vipt` smallint(2) unsigned NOT NULL DEFAULT '0',
  `vipr` smallint(2) NOT NULL DEFAULT '0',
  `type` varchar(100) NOT NULL DEFAULT '',
  `catid` varchar(100) NOT NULL DEFAULT '',
  `catids` varchar(100) NOT NULL DEFAULT '',
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  `mode` varchar(100) NOT NULL DEFAULT '',
  `capital` float unsigned NOT NULL DEFAULT '0',
  `regunit` varchar(15) NOT NULL DEFAULT '',
  `size` varchar(100) NOT NULL DEFAULT '',
  `regyear` varchar(4) NOT NULL DEFAULT '',
  `regcity` varchar(30) NOT NULL DEFAULT '',
  `sell` varchar(255) NOT NULL DEFAULT '',
  `buy` varchar(255) NOT NULL DEFAULT '',
  `business` varchar(255) NOT NULL DEFAULT '',
  `telephone` varchar(50) NOT NULL DEFAULT '',
  `fax` varchar(50) NOT NULL DEFAULT '',
  `mail` varchar(50) NOT NULL DEFAULT '',
   `gzh` varchar(50) NOT NULL default '',
  `gzhqr` varchar(255) NOT NULL default '',
  `address` varchar(255) NOT NULL DEFAULT '',
  `postcode` varchar(20) NOT NULL DEFAULT '',
  `homepage` varchar(255) NOT NULL DEFAULT '',
  `fromtime` int(10) unsigned NOT NULL DEFAULT '0',
  `totime` int(10) unsigned NOT NULL DEFAULT '0',
  `styletime` int(10) unsigned NOT NULL DEFAULT '0',
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `introduce` varchar(255) NOT NULL DEFAULT '',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `comments` int(10) unsigned NOT NULL default '0',
  `keyword` varchar(255) NOT NULL DEFAULT '',
  `template` varchar(30) NOT NULL DEFAULT '',
  `skin` varchar(30) NOT NULL DEFAULT '',
  `domain` varchar(100) NOT NULL DEFAULT '',
  `icp` varchar(100) NOT NULL DEFAULT '',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  `companyid` int(10) DEFAULT NULL,
  `letter` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`userid`),
  KEY `domain` (`domain`),
  KEY `vip` (`vip`),
  KEY `areaid` (`areaid`),
  KEY `groupid` (`groupid`)
) TYPE=MyISAM COMMENT='公司';




DROP TABLE IF EXISTS `aijiacms_company_catid`;
CREATE TABLE `aijiacms_company_catid` (
  `userid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  `groupid` smallint(4) unsigned NOT NULL DEFAULT '0',
  `vip` smallint(2) unsigned NOT NULL DEFAULT '0',
  KEY `userid` (`userid`),
  KEY `catid` (`catid`)
) TYPE=MyISAM COMMENT='公司分类';


DROP TABLE IF EXISTS `aijiacms_company_data`;
CREATE TABLE `aijiacms_company_data` (
  `userid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  PRIMARY KEY (`userid`)
) TYPE=MyISAM COMMENT='公司内容';


DROP TABLE IF EXISTS `aijiacms_company_setting`;
CREATE TABLE `aijiacms_company_setting` (
  `userid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `item_key` varchar(100) NOT NULL DEFAULT '',
  `item_value` text NOT NULL,
  KEY `userid` (`userid`)
) TYPE=MyISAM COMMENT='公司设置';



-- 
-- 表的结构 `aijiacms_favorite`
-- 

DROP TABLE IF EXISTS `aijiacms_favorite`;
CREATE TABLE `aijiacms_favorite` (
  `itemid` bigint(20) unsigned NOT NULL auto_increment,
  `mid` smallint(6) unsigned NOT NULL default '0',
  `tid` bigint(20) unsigned NOT NULL default '0',
  `listorder` smallint(4) unsigned NOT NULL default '0',
  `userid` bigint(20) unsigned NOT NULL default '0',
  `typeid` bigint(20) unsigned NOT NULL default '0',
  `title` varchar(100) NOT NULL default '',
  `style` varchar(50) NOT NULL default '',
  `thumb` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL default '',
  `note` varchar(255) NOT NULL default '',
  `addtime` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`itemid`),
  KEY `userid` (`userid`)
) TYPE=MyISAM COMMENT='房源收藏';

DROP TABLE IF EXISTS `aijiacms_fetch`;
CREATE TABLE `aijiacms_fetch` (
  `itemid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sitename` varchar(100) NOT NULL DEFAULT '',
  `domain` varchar(255) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `encode` varchar(30) NOT NULL DEFAULT '',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`)
) TYPE=MyISAM COMMENT='单页采集';


DROP TABLE IF EXISTS `aijiacms_fields`;
CREATE TABLE `aijiacms_fields` (
  `itemid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tb` varchar(30) NOT NULL DEFAULT '',
  `name` varchar(50) NOT NULL DEFAULT '',
  `title` varchar(100) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  `type` varchar(20) NOT NULL DEFAULT '',
  `length` smallint(4) unsigned NOT NULL DEFAULT '0',
  `html` varchar(30) NOT NULL DEFAULT '',
  `default_value` text NOT NULL,
  `option_value` text NOT NULL,
  `width` smallint(4) unsigned NOT NULL DEFAULT '0',
  `height` smallint(4) unsigned NOT NULL DEFAULT '0',
  `input_limit` varchar(255) NOT NULL DEFAULT '',
  `addition` varchar(255) NOT NULL DEFAULT '',
  `display` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `front` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `listorder` smallint(4) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`),
  KEY `tablename` (`tb`)
) TYPE=MyISAM COMMENT='自定义字段';


DROP TABLE IF EXISTS `aijiacms_finance_card`;
CREATE TABLE `aijiacms_finance_card` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `number` varchar(30) NOT NULL DEFAULT '',
  `password` varchar(30) NOT NULL DEFAULT '',
  `amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `totime` int(10) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`),
  UNIQUE KEY `number` (`number`)
) TYPE=MyISAM COMMENT='充值卡';


DROP TABLE IF EXISTS `aijiacms_finance_cash`;
CREATE TABLE `aijiacms_finance_cash` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL DEFAULT '',
  `bank` varchar(50) NOT NULL DEFAULT '',
   `banktype` tinyint(1) unsigned NOT NULL default '0',
  `branch` varchar(100) NOT NULL,
  `account` varchar(30) NOT NULL DEFAULT '',
  `truename` varchar(30) NOT NULL DEFAULT '',
  `amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `fee` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `note` varchar(255) NOT NULL DEFAULT '',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`),
  KEY `username` (`username`)
) TYPE=MyISAM COMMENT='申请提现';


DROP TABLE IF EXISTS `aijiacms_finance_charge`;
CREATE TABLE `aijiacms_finance_charge` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL DEFAULT '',
  `bank` varchar(20) NOT NULL DEFAULT '',
  `amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `fee` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `sendtime` int(10) unsigned NOT NULL DEFAULT '0',
  `receivetime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `note` varchar(255) NOT NULL DEFAULT '',
  `reason` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`),
  KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='在线充值';



DROP TABLE IF EXISTS `aijiacms_finance_credit`;
CREATE TABLE `aijiacms_finance_credit` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL DEFAULT '',
  `amount` int(10) NOT NULL DEFAULT '0',
  `balance` int(10) NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `reason` varchar(255) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  `editor` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`),
  KEY `username` (`username`)
) TYPE=MyISAM COMMENT='积分流水';


-- --------------------------------------------------------

-- 
-- 表的结构 `aijiacms_finance_pay`
-- 

DROP TABLE IF EXISTS `aijiacms_finance_pay`;
CREATE TABLE `aijiacms_finance_pay` (
  `itemid` bigint(20) unsigned NOT NULL auto_increment,
  `username` varchar(30) NOT NULL default '',
  `fee` float unsigned NOT NULL default '0',
  `currency` varchar(20) NOT NULL default '',
  `paytime` int(10) unsigned NOT NULL default '0',
  `ip` varchar(50) NOT NULL default '',
  `mid` smallint(6) unsigned NOT NULL default '0',
  `tid` bigint(20) unsigned NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`itemid`),
  KEY `username` (`username`)
) TYPE=MyISAM COMMENT='支付记录';


DROP TABLE IF EXISTS `aijiacms_finance_promo`;
CREATE TABLE `aijiacms_finance_promo` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `number` varchar(30) NOT NULL DEFAULT '',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `amount` float NOT NULL DEFAULT '0',
  `reuse` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `totime` int(10) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`),
  UNIQUE KEY `number` (`number`)
) TYPE=MyISAM COMMENT='优惠码';


DROP TABLE IF EXISTS `aijiacms_finance_record`;
CREATE TABLE `aijiacms_finance_record` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL DEFAULT '',
  `bank` varchar(30) NOT NULL DEFAULT '',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `balance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `reason` varchar(255) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  `editor` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`),
  KEY `username` (`username`)
) TYPE=MyISAM COMMENT='财务流水';


DROP TABLE IF EXISTS `aijiacms_finance_sms`;
CREATE TABLE `aijiacms_finance_sms` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL DEFAULT '',
  `amount` int(10) NOT NULL DEFAULT '0',
  `balance` int(10) NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `reason` varchar(255) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  `editor` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`),
  KEY `username` (`username`)
) TYPE=MyISAM COMMENT='短信增减';


DROP TABLE IF EXISTS `aijiacms_friend`;
CREATE TABLE `aijiacms_friend` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `listorder` smallint(4) unsigned NOT NULL DEFAULT '0',
  `userid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `typeid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `truename` varchar(20) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `company` varchar(100) NOT NULL DEFAULT '',
  `career` varchar(20) NOT NULL DEFAULT '',
  `telephone` varchar(20) NOT NULL DEFAULT '',
  `mobile` varchar(20) NOT NULL DEFAULT '',
  `homepage` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `wx` varchar(50) NOT NULL default '',
  `qq` varchar(20) NOT NULL DEFAULT '',
  `ali` varchar(30) NOT NULL DEFAULT '',
  `skype` varchar(30) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`),
  KEY `userid` (`userid`)
) TYPE=MyISAM COMMENT='我的房友';


DROP TABLE IF EXISTS `aijiacms_gift`;
CREATE TABLE `aijiacms_gift` (
  `itemid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `typeid` int(10) unsigned NOT NULL DEFAULT '0',
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `credit` int(10) unsigned NOT NULL DEFAULT '0',
  `amount` int(10) unsigned NOT NULL DEFAULT '0',
  `groupid` varchar(255) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `orders` int(10) unsigned NOT NULL DEFAULT '0',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `maxorder` int(10) unsigned NOT NULL default '1',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `fromtime` int(10) unsigned NOT NULL DEFAULT '0',
  `totime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`)
) TYPE=MyISAM COMMENT='积分换礼';


DROP TABLE IF EXISTS `aijiacms_gift_order`;
CREATE TABLE `aijiacms_gift_order` (
  `oid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `credit` int(10) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `status` varchar(255) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`oid`),
  KEY `itemid` (`itemid`)
) TYPE=MyISAM COMMENT='积分换礼订单';


DROP TABLE IF EXISTS `aijiacms_group_15`;
CREATE TABLE `aijiacms_group_15` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `fee` float NOT NULL DEFAULT '0',
  `introduce` varchar(255) NOT NULL DEFAULT '',
  `price` varchar(10) NOT NULL DEFAULT '0',
  `marketprice` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `savemoney` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `discount` float unsigned NOT NULL DEFAULT '0',
  `minamount` int(10) unsigned NOT NULL DEFAULT '0',
  `amount` int(10) unsigned NOT NULL DEFAULT '0',
  `logistic` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `tag` varchar(100) NOT NULL DEFAULT '',
  `keyword` varchar(255) NOT NULL DEFAULT '',
  `pptword` varchar(255) NOT NULL DEFAULT '',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
   `comments` int(10) unsigned NOT NULL default '0',
  `orders` int(10) unsigned NOT NULL DEFAULT '0',
  `sales` int(10) unsigned NOT NULL DEFAULT '0',
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(30) NOT NULL DEFAULT '',
  `groupid` smallint(4) unsigned NOT NULL DEFAULT '0',
  `company` varchar(100) NOT NULL DEFAULT '',
  `vip` smallint(2) unsigned NOT NULL DEFAULT '0',
  `validated` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `truename` varchar(30) NOT NULL DEFAULT '',
  `telephone` varchar(50) NOT NULL DEFAULT '',
  `mobile` varchar(50) NOT NULL DEFAULT '',
  `address` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `msn` varchar(50) NOT NULL DEFAULT '',
  `qq` varchar(20) NOT NULL DEFAULT '',
  `ali` varchar(30) NOT NULL DEFAULT '',
    `wx` varchar(50) NOT NULL DEFAULT '',
  `skype` varchar(30) NOT NULL DEFAULT '',
  `totime` int(10) unsigned NOT NULL DEFAULT '0',
  `endtime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `template` varchar(30) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `process` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  `filepath` varchar(255) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  `houseid` int(10) NOT NULL DEFAULT '0',
  `housename` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`itemid`),
  KEY `username` (`username`),
  KEY `addtime` (`addtime`),
  KEY `catid` (`catid`),
  KEY `areaid` (`areaid`)
) TYPE=MyISAM COMMENT='团购';


DROP TABLE IF EXISTS `aijiacms_group_data_15`;
CREATE TABLE `aijiacms_group_data_15` (
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` mediumtext NOT NULL,
  PRIMARY KEY (`itemid`)
) TYPE=MyISAM COMMENT='团购内容';


DROP TABLE IF EXISTS `aijiacms_group_order_15`;
CREATE TABLE `aijiacms_group_order_15` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `gid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `buyer` varchar(30) NOT NULL DEFAULT '',
  `seller` varchar(30) NOT NULL DEFAULT '',
  `title` varchar(100) NOT NULL DEFAULT '',
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `price` varchar(10) NOT NULL DEFAULT '0',
  `number` int(10) unsigned NOT NULL DEFAULT '0',
  `amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `logistic` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `password` varchar(6) NOT NULL DEFAULT '',
  `buyer_name` varchar(30) NOT NULL DEFAULT '',
  `buyer_address` varchar(255) NOT NULL DEFAULT '',
  `buyer_postcode` varchar(10) NOT NULL DEFAULT '',
  `buyer_phone` varchar(30) NOT NULL DEFAULT '',
  `buyer_mobile` varchar(30) NOT NULL DEFAULT '',
  `buyer_receive` varchar(50) NOT NULL DEFAULT '',
  `send_type` varchar(50) NOT NULL DEFAULT '',
  `send_no` varchar(50) NOT NULL DEFAULT '',
  `send_time` varchar(20) NOT NULL DEFAULT '',
  `send_days` int(10) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`),
  KEY `buyer` (`buyer`),
  KEY `seller` (`seller`)
) TYPE=MyISAM COMMENT='团购订单';


-- --------------------------------------------------------

-- 
-- 表的结构 `aijiacms_order`
-- 

DROP TABLE IF EXISTS `aijiacms_order`;
CREATE TABLE `aijiacms_order` (
  `itemid` bigint(20) unsigned NOT NULL auto_increment,
  `mid` smallint(6) unsigned NOT NULL default '16',
  `mallid` bigint(20) unsigned NOT NULL default '0',
  `pid` bigint(20) unsigned NOT NULL default '0',
  `cid` bigint(20) unsigned NOT NULL default '0',
  `buyer` varchar(30) NOT NULL default '',
  `seller` varchar(30) NOT NULL default '',
  `title` varchar(100) NOT NULL default '',
  `thumb` varchar(255) NOT NULL default '',
  `price` decimal(10,2) unsigned NOT NULL default '0.00',
  `number` int(10) unsigned NOT NULL default '0',
  `amount` decimal(10,2) unsigned NOT NULL default '0.00',
  `discount` decimal(10,2) unsigned NOT NULL default '0.00',
  `fee` decimal(10,2) NOT NULL default '0.00',
  `fee_name` varchar(30) NOT NULL default '',
  `buyer_name` varchar(30) NOT NULL default '',
  `buyer_address` varchar(255) NOT NULL default '',
  `buyer_postcode` varchar(10) NOT NULL default '',
  `buyer_mobile` varchar(30) NOT NULL default '',
  `buyer_star` tinyint(1) unsigned NOT NULL default '0',
  `seller_star` tinyint(1) unsigned NOT NULL default '0',
  `send_type` varchar(50) NOT NULL default '',
  `send_no` varchar(50) NOT NULL default '',
  `send_status` tinyint(1) unsigned NOT NULL default '0',
  `send_time` varchar(20) NOT NULL default '',
  `send_days` int(10) unsigned NOT NULL default '0',
  `cod` tinyint(1) unsigned NOT NULL default '0',
  `trade_no` varchar(50) NOT NULL default '',
  `add_time` smallint(6) NOT NULL default '0',
  `addtime` int(10) unsigned NOT NULL default '0',
  `updatetime` int(10) unsigned NOT NULL default '0',
  `editor` varchar(30) NOT NULL default '',
  `buyer_reason` mediumtext NOT NULL,
  `refund_reason` mediumtext NOT NULL,
  `note` varchar(255) NOT NULL default '',
  `status` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`itemid`),
  KEY `buyer` (`buyer`),
  KEY `seller` (`seller`),
  KEY `pid` (`pid`)
) TYPE=MyISAM COMMENT='订单';

-- --------------------------------------------------------


DROP TABLE IF EXISTS `aijiacms_guestbook`;
CREATE TABLE `aijiacms_guestbook` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `reply` text NOT NULL,
  `hidden` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `truename` varchar(30) NOT NULL DEFAULT '',
  `telephone` varchar(50) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `qq` varchar(30) NOT NULL DEFAULT '',
  `ali` varchar(30) NOT NULL DEFAULT '',
  `skype` varchar(30) NOT NULL DEFAULT '',
   `wx` varchar(50) NOT NULL default '',
  `username` varchar(30) NOT NULL DEFAULT '',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `hids` int(10) NOT NULL,
  `lp` varchar(20) NOT NULL,
  PRIMARY KEY (`itemid`),
  KEY `username` (`username`)
) TYPE=MyISAM COMMENT='留言本';

DROP TABLE IF EXISTS `aijiacms_house_pic`;
CREATE TABLE `aijiacms_house_pic` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `item` bigint(20) unsigned NOT NULL DEFAULT '0',
  `introduce` text NOT NULL,
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `mid` int(10) unsigned NOT NULL DEFAULT '0',
  `listorder` smallint(4) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`),
  KEY `listorder` (`listorder`),
  KEY `item` (`item`)
)TYPE=MyISAM COMMENT='房源图库';

DROP TABLE IF EXISTS `aijiacms_honor`;
CREATE TABLE `aijiacms_honor` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `authority` varchar(100) NOT NULL DEFAULT '',
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `fromtime` int(10) unsigned NOT NULL DEFAULT '0',
  `totime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `note` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`),
  KEY `username` (`username`),
  KEY `addtime` (`addtime`)
) TYPE=MyISAM COMMENT='荣誉资质';


DROP TABLE IF EXISTS `aijiacms_keylink`;
CREATE TABLE `aijiacms_keylink` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `url` varchar(255) NOT NULL DEFAULT '',
  `item` varchar(20) NOT NULL DEFAULT '',
  `listorder` smallint(4) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`),
  KEY `item` (`item`)
) TYPE=MyISAM COMMENT='关联链接';


DROP TABLE IF EXISTS `aijiacms_keyword`;
CREATE TABLE `aijiacms_keyword` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `moduleid` smallint(6) NOT NULL DEFAULT '0',
  `word` varchar(255) NOT NULL DEFAULT '',
  `keyword` varchar(255) NOT NULL DEFAULT '',
  `letter` varchar(255) NOT NULL DEFAULT '',
  `items` int(10) unsigned NOT NULL DEFAULT '0',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0',
  `total_search` int(10) unsigned NOT NULL DEFAULT '0',
  `month_search` int(10) unsigned NOT NULL DEFAULT '0',
  `week_search` int(10) unsigned NOT NULL DEFAULT '0',
  `today_search` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '3',
  PRIMARY KEY (`itemid`),
  KEY `moduleid` (`moduleid`),
  KEY `word` (`word`),
  KEY `letter` (`letter`),
  KEY `keyword` (`keyword`)
) TYPE=MyISAM COMMENT='关键词';



DROP TABLE IF EXISTS `aijiacms_link`;
CREATE TABLE `aijiacms_link` (
  `itemid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `typeid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `introduce` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(30) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `listorder` smallint(4) NOT NULL DEFAULT '0',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`),
  KEY `username` (`username`),
  KEY `listorder` (`listorder`)
) TYPE=MyISAM COMMENT='友情链接';


DROP TABLE IF EXISTS `aijiacms_login`;
CREATE TABLE `aijiacms_login` (
  `logid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
   `passsalt` varchar(8) NOT NULL,
  `admin` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `loginip` varchar(50) NOT NULL DEFAULT '',
  `loginport` varchar(50) NOT NULL DEFAULT '',
  `logintime` int(10) unsigned NOT NULL DEFAULT '0',
  `message` varchar(255) NOT NULL DEFAULT '',
  `agent` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`logid`)
) TYPE=MyISAM COMMENT='登录日志';


DROP TABLE IF EXISTS `aijiacms_mail`;
CREATE TABLE `aijiacms_mail` (
  `itemid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `typeid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `sendtime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`)
) TYPE=MyISAM COMMENT='邮件订阅';


DROP TABLE IF EXISTS `aijiacms_mail_list`;
CREATE TABLE `aijiacms_mail_list` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `typeids` varchar(255) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`),
  UNIQUE KEY `username` (`username`)
) TYPE=MyISAM COMMENT='订阅列表';


DROP TABLE IF EXISTS `aijiacms_mail_log`;
CREATE TABLE `aijiacms_mail_log` (
  `itemid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `note` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`)
) TYPE=MyISAM COMMENT='邮件记录';


DROP TABLE IF EXISTS `aijiacms_mall_cart`;
CREATE TABLE `aijiacms_mall_cart` (
  `userid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `data` text NOT NULL,
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `userid` (`userid`)
) TYPE=MyISAM COMMENT='购物车';


DROP TABLE IF EXISTS `aijiacms_member`;
CREATE TABLE `aijiacms_member` (
  `userid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL DEFAULT '',
  `passport` varchar(30) NOT NULL DEFAULT '',
  `company` varchar(100) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `passsalt` varchar(8) NOT NULL,
  `payword` varchar(32) NOT NULL DEFAULT '',
  `paysalt` varchar(8) NOT NULL,
  `email` varchar(50) NOT NULL DEFAULT '',
  `message` smallint(6) unsigned NOT NULL DEFAULT '0',
  `chat` smallint(6) unsigned NOT NULL DEFAULT '0',
  `sound` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `online` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `avatar` varchar(255) NOT NULL DEFAULT '',
  `gender` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `truename` varchar(20) NOT NULL DEFAULT '',
  `mobile` varchar(50) NOT NULL DEFAULT '',
  `qq` varchar(20) NOT NULL DEFAULT '',
  `wx` varchar(50) NOT NULL DEFAULT '',
  `wxqr` varchar(255) NOT NULL DEFAULT '',
  `ali` varchar(30) NOT NULL DEFAULT '',
  `skype` varchar(30) NOT NULL DEFAULT '',
  `department` varchar(30) NOT NULL DEFAULT '',
  `career` varchar(30) NOT NULL DEFAULT '',
  `admin` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `role` varchar(255) NOT NULL DEFAULT '',
  `aid` int(10) unsigned NOT NULL DEFAULT '0',
  `groupid` smallint(4) unsigned NOT NULL DEFAULT '4',
  `regid` smallint(4) unsigned NOT NULL DEFAULT '0',
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  `sms` int(10) NOT NULL DEFAULT '0',
  `credit` int(10) NOT NULL DEFAULT '0',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00',
  `deposit` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `regip` varchar(50) NOT NULL DEFAULT '',
  `regtime` int(10) unsigned NOT NULL DEFAULT '0',
  `loginip` varchar(50) NOT NULL DEFAULT '',
  `logintime` int(10) unsigned NOT NULL DEFAULT '0',
  `logintimes` int(10) unsigned NOT NULL DEFAULT '1',
  `send` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `vemail` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `vmobile` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `vtruename` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `vbank` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `vcompany` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `vtrade` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `trade` varchar(50) NOT NULL DEFAULT '',
  `support` varchar(50) NOT NULL DEFAULT '',
  `inviter` varchar(30) NOT NULL DEFAULT '',
  `weixin_openid` varchar(100) NOT NULL DEFAULT '',
  `baidu_openid` varchar(255) NOT NULL DEFAULT '',
  `token` varchar(255) NOT NULL DEFAULT '',
  `nickname` varchar(255) NOT NULL DEFAULT '',
  `companyid` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `note` text NOT NULL,
  PRIMARY KEY (`userid`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `passport` (`passport`),
  KEY `groupid` (`groupid`)
) TYPE=MyISAM COMMENT='会员';

DROP TABLE IF EXISTS `aijiacms_member_check`;
CREATE TABLE `aijiacms_member_check` (
  `userid` bigint(20) unsigned NOT NULL auto_increment,
  `username` varchar(30) NOT NULL default '',
  `content` mediumtext NOT NULL,
  `addtime` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`userid`),
  UNIQUE KEY `username` (`username`)
) TYPE=MyISAM COMMENT='会员资料审核';

DROP TABLE IF EXISTS `aijiacms_member_group`;
CREATE TABLE `aijiacms_member_group` (
  `groupid` smallint(4) unsigned NOT NULL auto_increment,
  `groupname` varchar(50) NOT NULL default '',
  `vip` smallint(2) unsigned NOT NULL default '0',
  `listorder` smallint(4) unsigned NOT NULL default '0',
  PRIMARY KEY  (`groupid`)
) TYPE=MyISAM COMMENT='会员组';

DROP TABLE IF EXISTS `aijiacms_message`;
CREATE TABLE `aijiacms_message` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `typeid` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  `fromuser` varchar(30) NOT NULL DEFAULT '',
  `touser` varchar(30) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `isread` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `issend` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `feedback` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `groupids` varchar(20) NOT NULL DEFAULT '',
  `telephone` varchar(30) NOT NULL DEFAULT '',
  `truename` varchar(30) NOT NULL DEFAULT '',
  `sex` varchar(30) NOT NULL DEFAULT '',
  `email` varchar(50) DEFAULT NULL,
  `linkurl` varchar(50) DEFAULT NULL,
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`),
  KEY `touser` (`touser`)
) TYPE=MyISAM  COMMENT='站内信件';


DROP TABLE IF EXISTS `aijiacms_module`;
CREATE TABLE `aijiacms_module` (
  `moduleid` smallint(6) unsigned NOT NULL auto_increment,
  `module` varchar(20) NOT NULL default '',
  `name` varchar(20) NOT NULL default '',
  `moduledir` varchar(20) NOT NULL default '',
  `domain` varchar(255) NOT NULL default '',
   `mobile` varchar(255) NOT NULL default '',
  `linkurl` varchar(255) NOT NULL default '',
  `style` varchar(50) NOT NULL default '',
  `listorder` smallint(4) unsigned NOT NULL default '0',
  `islink` tinyint(1) unsigned NOT NULL default '0',
  `ismenu` tinyint(1) unsigned NOT NULL default '0',
  `isblank` tinyint(1) unsigned NOT NULL default '0',
  `logo` tinyint(1) unsigned NOT NULL default '0',
  `disabled` tinyint(1) unsigned NOT NULL default '0',
  `installtime` int(10) unsigned NOT NULL default '0',
  `icon` varchar(255) DEFAULT NULL,
  PRIMARY KEY  (`moduleid`)
) TYPE=MyISAM COMMENT='模型';

DROP TABLE IF EXISTS `aijiacms_newhouse_6`;
CREATE TABLE `aijiacms_newhouse_6` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `catid` varchar(30) NOT NULL DEFAULT '0',
  `mycatid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `typeid` smallint(2) unsigned NOT NULL DEFAULT '0',
  `areaid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `elite` tinyint(1) NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `fee` float NOT NULL DEFAULT '0',
  `introduce` varchar(255) NOT NULL DEFAULT '',
  `price` decimal(10,0) unsigned NOT NULL,
  `days` smallint(3) unsigned NOT NULL DEFAULT '0',
  `tag` varchar(100) NOT NULL DEFAULT '',
  `keyword` varchar(255) NOT NULL DEFAULT '',
  `pptword` varchar(255) NOT NULL DEFAULT '',
  `comments` int(10) unsigned NOT NULL default '0',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `thumb1` varchar(255) NOT NULL DEFAULT '',
  `thumb2` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(30) NOT NULL DEFAULT '',
  `groupid` smallint(4) unsigned NOT NULL DEFAULT '0',
  `company` varchar(100) NOT NULL DEFAULT '',
  `vip` smallint(2) unsigned NOT NULL DEFAULT '0',
  `validated` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `truename` varchar(30) NOT NULL DEFAULT '',
  `telephone` varchar(50) NOT NULL DEFAULT '',
  `mobile` varchar(50) NOT NULL DEFAULT '',
  `address` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `msn` varchar(50) NOT NULL DEFAULT '',
  `qq` varchar(20) NOT NULL DEFAULT '',
    `wx` varchar(50) NOT NULL DEFAULT '',
  `ali` varchar(30) NOT NULL DEFAULT '',
  `skype` varchar(30) NOT NULL DEFAULT '',
  `totime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `editdate` date NOT NULL DEFAULT '0000-00-00',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `adddate` date NOT NULL DEFAULT '0000-00-00',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `template` varchar(30) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  `filepath` varchar(255) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  `letter` varchar(10) NOT NULL DEFAULT '' COMMENT '字母',
  `map` varchar(255) NOT NULL DEFAULT '' COMMENT '地图',
  `tedian` varchar(255) NOT NULL DEFAULT '' COMMENT '特点',
  `selltime` varchar(20) NOT NULL COMMENT '开盘时间',
  `completion` varchar(20) NOT NULL COMMENT '交房时间',
  `lp_type` varchar(20) NOT NULL DEFAULT '' COMMENT '物业类型',
  `lp_year` int(10) NOT NULL COMMENT '产权年限',
  `lp_company` varchar(30) NOT NULL DEFAULT '' COMMENT '物业公司',
  `lp_costs` float(10,2) NOT NULL COMMENT '物业费',
  `lp_totalarea` int(20) NOT NULL COMMENT '规划面积',
  `lp_area` int(10) DEFAULT NULL COMMENT '建筑面积',
  `lp_number` int(10) NOT NULL COMMENT '规划户数',
  `lp_car` int(10) DEFAULT NULL COMMENT '车位数',
  `lp_volume` float(10,2) DEFAULT NULL COMMENT '容积率',
  `lp_green` int(10) DEFAULT NULL COMMENT '绿化率',
  `lp_bus` varchar(50) DEFAULT '' COMMENT '公车',
  `lp_edu` varchar(50) DEFAULT '' COMMENT '教育',
  `lp_hospital` varchar(50) DEFAULT NULL COMMENT '医院',
  `lp_bank` varchar(50) DEFAULT '' COMMENT '银行',
  `lineprice` varchar(50) NOT NULL DEFAULT '' COMMENT '曲线价格',
  `linedate` varchar(100) NOT NULL DEFAULT '' COMMENT '曲线日期',
  `sell_address` varchar(50) DEFAULT NULL,
  `buildtype` varchar(255) NOT NULL,
  `kfs` varchar(255) NOT NULL,
  `lp_dianping` varchar(255) DEFAULT NULL,
  `isnew` int(4) DEFAULT '0',
  `fitment` varchar(255) NOT NULL,
  `bbsurl` varchar(255) NOT NULL,
  `lpts` varchar(255) NOT NULL,
  `range` varchar(80) NOT NULL,
  `pinyin` varchar(80) DEFAULT NULL,
  `isfx` int(4) DEFAULT '0',
  `yongjin` varchar(80) NOT NULL,
  `star0` int(10) unsigned NOT NULL DEFAULT '0',
  `star1` int(10) unsigned NOT NULL DEFAULT '0',
  `star2` int(10) unsigned NOT NULL DEFAULT '0',
  `star3` int(10) unsigned NOT NULL DEFAULT '0',
  `star4` int(10) unsigned NOT NULL DEFAULT '0',
  `ishb` int(4) DEFAULT '0',
  `islink` int(4) DEFAULT '0',
  
  `hongbao` varchar(80) NOT NULL,
  `hbtime` int(10) unsigned NOT NULL DEFAULT '0',
  `hbnum` int(10) unsigned NOT NULL DEFAULT '0',
  `quanjing` varchar(255) NOT NULL,
  `wenfangs` varchar(255) NOT NULL,
  `zhiye` varchar(255) NOT NULL,
   `video` varchar(255) NOT NULL,
  PRIMARY KEY (`itemid`),
  KEY `username` (`username`),
  KEY `editdate` (`editdate`,`vip`,`edittime`),
  KEY `edittime` (`edittime`),
  KEY `catid` (`catid`),
  KEY `mycatid` (`mycatid`),
  KEY `areaid` (`areaid`)
) TYPE=MyISAM COMMENT='新房';

DROP TABLE IF EXISTS `aijiacms_newhouse_search_6`;
CREATE TABLE `aijiacms_newhouse_search_6` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `areaid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `sorttime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`),
  KEY `catid` (`catid`)
) TYPE=MyISAM COMMENT='新房搜索';


DROP TABLE IF EXISTS `aijiacms_newhouse_data_6`;
CREATE TABLE `aijiacms_newhouse_data_6` (
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` mediumtext NOT NULL,
  PRIMARY KEY (`itemid`)
) TYPE=MyISAM COMMENT='新房内容';

DROP TABLE IF EXISTS `aijiacms_newhouse_price`;
CREATE TABLE `aijiacms_newhouse_price` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `price` int(10) NOT NULL,
  `market` smallint(6) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL,
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  `company` varchar(100) NOT NULL,
  `telephone` varchar(50) NOT NULL,
  `qq` varchar(20) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `note` varchar(255) NOT NULL,
  `title` varchar(50) NOT NULL,
  `trend` int(10) NOT NULL,
  PRIMARY KEY (`itemid`),
  KEY `addtime` (`addtime`),
  KEY `pid` (`pid`)
) TYPE=MyISAM  COMMENT='新房报价';

DROP TABLE IF EXISTS `aijiacms_news`;
CREATE TABLE `aijiacms_news` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `typeid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
   `thumb` varchar(255) NOT NULL,
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  `houseid` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`),
  KEY `username` (`username`),
  KEY `addtime` (`addtime`)
) TYPE=MyISAM COMMENT='公司新闻';


DROP TABLE IF EXISTS `aijiacms_news_data`;
CREATE TABLE `aijiacms_news_data` (
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` mediumtext NOT NULL,
  PRIMARY KEY (`itemid`)
) TYPE=MyISAM COMMENT='公司新闻内容';


DROP TABLE IF EXISTS `aijiacms_oauth`;
CREATE TABLE `aijiacms_oauth` (
  `itemid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL DEFAULT '',
  `site` varchar(30) NOT NULL DEFAULT '',
  `openid` varchar(255) NOT NULL DEFAULT '',
  `nickname` varchar(255) NOT NULL DEFAULT '',
  `avatar` varchar(255) NOT NULL DEFAULT '',
  `url` varchar(255) NOT NULL DEFAULT '',
  `logintimes` int(10) unsigned NOT NULL DEFAULT '0',
  `logintime` int(10) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`),
  KEY `username` (`username`),
  KEY `site` (`site`,`openid`)
) TYPE=MyISAM COMMENT='一键登录';


DROP TABLE IF EXISTS `aijiacms_online`;
CREATE TABLE `aijiacms_online` (
  `userid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `moduleid` int(10) unsigned NOT NULL DEFAULT '0',
  `online` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `lasttime` int(10) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `userid` (`userid`)
) TYPE=MyISAM COMMENT='在线会员';


DROP TABLE IF EXISTS `aijiacms_page`;
CREATE TABLE `aijiacms_page` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  `listorder` smallint(4) unsigned NOT NULL DEFAULT '0',
  `note` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`),
  KEY `username` (`username`),
  KEY `addtime` (`addtime`)
) TYPE=MyISAM COMMENT='公司单页';


DROP TABLE IF EXISTS `aijiacms_page_data`;
CREATE TABLE `aijiacms_page_data` (
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` mediumtext NOT NULL,
  PRIMARY KEY (`itemid`)
) TYPE=MyISAM COMMENT='公司单页内容';


DROP TABLE IF EXISTS `aijiacms_photo_12`;
CREATE TABLE `aijiacms_photo_12` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `fee` float NOT NULL DEFAULT '0',
  `introduce` varchar(255) NOT NULL DEFAULT '',
  `keyword` varchar(255) NOT NULL DEFAULT '',
  `pptword` varchar(255) NOT NULL DEFAULT '',
  `items` int(10) unsigned NOT NULL DEFAULT '0',
  `comments` int(10) unsigned NOT NULL default '0',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(30) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `template` varchar(30) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `open` tinyint(1) unsigned NOT NULL DEFAULT '3',
  `password` varchar(30) NOT NULL DEFAULT '',
  `question` varchar(30) NOT NULL DEFAULT '',
  `answer` varchar(30) NOT NULL DEFAULT '',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  `filepath` varchar(255) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  `houseid` int(10) NOT NULL DEFAULT '0',
  `housename` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`itemid`),
  KEY `addtime` (`addtime`),
  KEY `catid` (`catid`),
  KEY `username` (`username`)
) TYPE=MyISAM COMMENT='图库';


DROP TABLE IF EXISTS `aijiacms_photo_data_12`;
CREATE TABLE `aijiacms_photo_data_12` (
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` longtext NOT NULL,
  PRIMARY KEY (`itemid`)
) TYPE=MyISAM COMMENT='图库内容';



DROP TABLE IF EXISTS `aijiacms_photo_item_12`;
CREATE TABLE `aijiacms_photo_item_12` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `item` bigint(20) unsigned NOT NULL DEFAULT '0',
  `introduce` text NOT NULL,
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `mianji` varchar(50) NOT NULL DEFAULT '',
  `listorder` smallint(4) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`),
  KEY `listorder` (`listorder`),
  KEY `item` (`item`)
) TYPE=MyISAM  COMMENT='图库图片';

DROP TABLE IF EXISTS `aijiacms_poll`;
CREATE TABLE `aijiacms_poll` (
  `itemid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `typeid` int(10) unsigned NOT NULL DEFAULT '0',
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `seo_title` varchar(255) NOT NULL DEFAULT '',
  `seo_keywords` varchar(255) NOT NULL DEFAULT '',
  `seo_description` varchar(255) NOT NULL DEFAULT '',
  `thumb_width` smallint(6) unsigned NOT NULL DEFAULT '0',
  `thumb_height` smallint(6) unsigned NOT NULL DEFAULT '0',
  `poll_max` smallint(6) unsigned NOT NULL DEFAULT '0',
  `poll_page` smallint(6) unsigned NOT NULL DEFAULT '0',
  `poll_cols` smallint(6) unsigned NOT NULL DEFAULT '0',
  `poll_order` smallint(6) unsigned NOT NULL DEFAULT '0',
  `polls` int(10) unsigned NOT NULL DEFAULT '0',
  `items` int(10) unsigned NOT NULL DEFAULT '0',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `fromtime` int(10) unsigned NOT NULL DEFAULT '0',
  `totime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  `template_poll` varchar(30) NOT NULL DEFAULT '',
  `template` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`),
  KEY `addtime` (`addtime`)
) TYPE=MyISAM COMMENT='票选';


DROP TABLE IF EXISTS `aijiacms_poll_item`;
CREATE TABLE `aijiacms_poll_item` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pollid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `introduce` varchar(255) NOT NULL DEFAULT '',
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  `polls` int(10) unsigned NOT NULL DEFAULT '0',
  `listorder` smallint(4) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`),
  KEY `pollid` (`pollid`)
) TYPE=MyISAM COMMENT='票选选项';


DROP TABLE IF EXISTS `aijiacms_poll_record`;
CREATE TABLE `aijiacms_poll_record` (
  `rid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `pollid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `polltime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`rid`)
) TYPE=MyISAM COMMENT='票选记录';


DROP TABLE IF EXISTS `aijiacms_question`;
CREATE TABLE `aijiacms_question` (
  `qid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `question` varchar(255) NOT NULL DEFAULT '',
  `answer` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`qid`)
) TYPE=MyISAM COMMENT='验证问题';


DROP TABLE IF EXISTS `aijiacms_rent_7`;
CREATE TABLE `aijiacms_rent_7` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `mycatid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `typeid` smallint(2) unsigned NOT NULL DEFAULT '0',
  `areaid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `elite` tinyint(1) NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `fee` float NOT NULL DEFAULT '0',
  `introduce` varchar(255) NOT NULL DEFAULT '',
  `unit` varchar(10) NOT NULL DEFAULT '',
  `price` varchar(50) NOT NULL DEFAULT '',
  `days` smallint(3) unsigned NOT NULL DEFAULT '0',
  `tag` varchar(100) NOT NULL DEFAULT '',
  `keyword` varchar(255) NOT NULL DEFAULT '',
  `pptword` varchar(255) NOT NULL DEFAULT '',
  `comments` int(10) unsigned NOT NULL default '0',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `thumb1` varchar(255) NOT NULL DEFAULT '',
  `thumb2` varchar(255) NOT NULL DEFAULT '',
  `thumb3` varchar(255) NOT NULL DEFAULT '',
  `thumb4` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(30) NOT NULL DEFAULT '',
  `groupid` smallint(4) unsigned NOT NULL DEFAULT '0',
  `company` varchar(100) NOT NULL DEFAULT '',
  `vip` smallint(2) unsigned NOT NULL DEFAULT '0',
  `validated` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `truename` varchar(30) NOT NULL DEFAULT '',
  `telephone` varchar(50) NOT NULL DEFAULT '',
  `mobile` varchar(50) NOT NULL DEFAULT '',
  `address` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `msn` varchar(50) NOT NULL DEFAULT '',
  `qq` varchar(20) NOT NULL DEFAULT '',
    `wx` varchar(50) NOT NULL DEFAULT '',
  `ali` varchar(30) NOT NULL DEFAULT '',
  `skype` varchar(30) NOT NULL DEFAULT '',
  `totime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `editdate` date NOT NULL DEFAULT '0000-00-00',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `adddate` date NOT NULL DEFAULT '0000-00-00',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `template` varchar(30) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  `filepath` varchar(255) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  `housename` varchar(50) NOT NULL DEFAULT 'e',
  `houseid` int(10) NOT NULL,
  `room` varchar(50) NOT NULL DEFAULT '',
  `hall` varchar(50) NOT NULL,
  `toilet` varchar(50) NOT NULL DEFAULT '',
  `balcony` varchar(50) NOT NULL DEFAULT '',
  `houseearm` int(19) NOT NULL,
  `floor1` int(10) NOT NULL,
  `floor2` int(10) NOT NULL,
  `cqxz` varchar(10) NOT NULL,
  `houseyear` varchar(10) NOT NULL,
  `toward` varchar(10) NOT NULL,
  `map` varchar(100) NOT NULL,
  `peitao` varchar(255) NOT NULL,
  `fyts` varchar(255) NOT NULL,
  `bus` varchar(50) NOT NULL,
  `renttype` varchar(20) DEFAULT NULL,
  `paytype` varchar(20) DEFAULT NULL,
  `paytype2` varchar(20) DEFAULT NULL,
  `zhuanxiu` varchar(255) NOT NULL,
  `range` varchar(255) NOT NULL,
  `peitaor` varchar(255) NOT NULL,
  `fytsr` varchar(255) NOT NULL,
  `istop` smallint(6) DEFAULT '0',
  `ishot` smallint(6) DEFAULT '0',
   `islink` int(4) DEFAULT '0',
  `to_time` int(10) NOT NULL DEFAULT '0',
  `hot_time` int(10) DEFAULT '0',
   `quanjing` varchar(255) NOT NULL,
     `video` varchar(255) NOT NULL,
  `thumbs` text NOT NULL,
  PRIMARY KEY (`itemid`),
  KEY `username` (`username`),
  KEY `editdate` (`editdate`,`vip`,`edittime`),
  KEY `edittime` (`edittime`),
  KEY `catid` (`catid`),
  KEY `mycatid` (`mycatid`),
  KEY `areaid` (`areaid`)
) TYPE=MyISAM COMMENT='租房';


DROP TABLE IF EXISTS `aijiacms_rent_search_7`;
CREATE TABLE `aijiacms_rent_search_7` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `areaid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `sorttime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`),
  KEY `catid` (`catid`)
) TYPE=MyISAM COMMENT='租房搜索';


DROP TABLE IF EXISTS `aijiacms_rent_data_7`;
CREATE TABLE `aijiacms_rent_data_7` (
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` mediumtext NOT NULL,
  PRIMARY KEY (`itemid`)
) TYPE=MyISAM COMMENT='租房内容';


DROP TABLE IF EXISTS `aijiacms_sale_5`;
CREATE TABLE `aijiacms_sale_5` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `mycatid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `typeid` smallint(2) unsigned NOT NULL DEFAULT '0',
  `areaid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `elite` tinyint(1) NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `fee` float NOT NULL DEFAULT '0',
  `introduce` varchar(255) NOT NULL DEFAULT '',
  `unit` varchar(10) NOT NULL DEFAULT '',
   `price` varchar(50) NOT NULL DEFAULT '',
  `days` smallint(3) unsigned NOT NULL DEFAULT '0',
  `tag` varchar(100) NOT NULL DEFAULT '',
  `keyword` varchar(255) NOT NULL DEFAULT '',
  `pptword` varchar(255) NOT NULL DEFAULT '',
  `comments` int(10) unsigned NOT NULL default '0',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `thumb1` varchar(255) NOT NULL DEFAULT '',
  `thumb2` varchar(255) NOT NULL DEFAULT '',
  `thumb3` varchar(255) NOT NULL DEFAULT '',
  `thumb4` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(30) NOT NULL DEFAULT '',
  `groupid` smallint(4) unsigned NOT NULL DEFAULT '0',
  `company` varchar(100) NOT NULL DEFAULT '',
  `vip` smallint(2) unsigned NOT NULL DEFAULT '0',
  `validated` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `truename` varchar(30) NOT NULL DEFAULT '',
  `telephone` varchar(50) NOT NULL DEFAULT '',
  `mobile` varchar(50) NOT NULL DEFAULT '',
  `address` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `msn` varchar(50) NOT NULL DEFAULT '',
  `qq` varchar(20) NOT NULL DEFAULT '',
    `wx` varchar(50) NOT NULL DEFAULT '',
  `ali` varchar(30) NOT NULL DEFAULT '',
  `skype` varchar(30) NOT NULL DEFAULT '',
  `totime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `editdate` date NOT NULL DEFAULT '0000-00-00',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `adddate` date NOT NULL DEFAULT '0000-00-00',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `template` varchar(30) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  `filepath` varchar(255) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  `housename` varchar(50) NOT NULL DEFAULT 'e',
  `houseid` int(10) NOT NULL,
  `room` varchar(50) NOT NULL DEFAULT '',
  `hall` varchar(50) NOT NULL,
  `toilet` varchar(50) NOT NULL DEFAULT '',
  `balcony` varchar(50) NOT NULL DEFAULT '',
  `houseearm` int(19) NOT NULL,
  `floor1` int(10) NOT NULL,
  `floor2` int(10) NOT NULL,
  `cqxz` varchar(10) NOT NULL,
  `houseyear` varchar(10) NOT NULL,
  `map` varchar(100) NOT NULL,
  `peitao` varchar(255) NOT NULL,
  `fyts` varchar(255) NOT NULL,
  `bus` varchar(50) NOT NULL,
  `zhuanxiu` varchar(255) NOT NULL,
  `toward` varchar(255) NOT NULL,
  `fix` varchar(255) NOT NULL,
  `range` varchar(255) NOT NULL,
   `islink` int(4) DEFAULT '0',
  `istop` smallint(6) DEFAULT '0',
  `ishot` smallint(6) DEFAULT '0',
  `to_time` int(10) NOT NULL DEFAULT '0',
  `hot_time` int(10) DEFAULT '0',
  `quanjing` varchar(255) NOT NULL,
  `video` varchar(255) NOT NULL,
  `thumbs` text NOT NULL,
  PRIMARY KEY (`itemid`),
  KEY `username` (`username`),
  KEY `editdate` (`editdate`,`vip`,`edittime`),
  KEY `edittime` (`edittime`),
  KEY `catid` (`catid`),
  KEY `mycatid` (`mycatid`),
  KEY `areaid` (`areaid`)
) TYPE=MyISAM COMMENT='二手房';


DROP TABLE IF EXISTS `aijiacms_sale_search_5`;
CREATE TABLE `aijiacms_sale_search_5` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `areaid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `sorttime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`),
  KEY `catid` (`catid`)
) TYPE=MyISAM COMMENT='二手房搜索';



DROP TABLE IF EXISTS `aijiacms_sale_data_5`;
CREATE TABLE `aijiacms_sale_data_5` (
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` mediumtext NOT NULL,
  PRIMARY KEY (`itemid`)
) TYPE=MyISAM COMMENT='二手房内容';


DROP TABLE IF EXISTS `aijiacms_session`;
CREATE TABLE `aijiacms_session` (
  `sessionid` varchar(32) NOT NULL DEFAULT '',
  `data` text NOT NULL,
  `lastvisit` int(10) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `sessionid` (`sessionid`)
) TYPE=MyISAM COMMENT='SESSION';


DROP TABLE IF EXISTS `aijiacms_setting`;
CREATE TABLE `aijiacms_setting` (
  `item` varchar(30) NOT NULL DEFAULT '',
  `item_key` varchar(100) NOT NULL DEFAULT '',
  `item_value` text NOT NULL,
  KEY `item` (`item`)
) TYPE=MyISAM COMMENT='网站设置';


DROP TABLE IF EXISTS `aijiacms_sms`;
CREATE TABLE `aijiacms_sms` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `mobile` varchar(30) NOT NULL DEFAULT '',
  `message` text NOT NULL,
  `word` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `sendtime` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(50) NOT NULL,
  `code` varchar(255) NOT NULL DEFAULT '',
  `encode` int(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`)
) TYPE=MyISAM COMMENT='短信记录';


DROP TABLE IF EXISTS `aijiacms_special_11`;
CREATE TABLE `aijiacms_special_11` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `introduce` varchar(255) NOT NULL DEFAULT '',
  `tag` varchar(100) NOT NULL DEFAULT '',
  `keyword` varchar(255) NOT NULL DEFAULT '',
  `pptword` varchar(255) NOT NULL DEFAULT '',
  `items` int(10) unsigned NOT NULL DEFAULT '0',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `comments` int(10) unsigned NOT NULL DEFAULT '0',
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `banner` varchar(255) NOT NULL DEFAULT '',
  `cfg_photo` smallint(4) unsigned NOT NULL DEFAULT '0',
  `cfg_video` smallint(4) unsigned NOT NULL DEFAULT '0',
  `cfg_type` smallint(4) unsigned NOT NULL DEFAULT '0',
  `seo_title` varchar(255) NOT NULL DEFAULT '',
  `seo_keywords` varchar(255) NOT NULL DEFAULT '',
  `seo_description` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(30) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `template` varchar(30) NOT NULL DEFAULT '0',
  `template_type` varchar(30) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `islink` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  `filepath` varchar(255) NOT NULL DEFAULT '',
  `domain` varchar(255) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`),
  KEY `addtime` (`addtime`),
  KEY `catid` (`catid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='专题';;

DROP TABLE IF EXISTS `aijiacms_special_data_11`;
CREATE TABLE `aijiacms_special_data_11` (
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` longtext NOT NULL,
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='专题内容';


DROP TABLE IF EXISTS `aijiacms_special_item_11`;
CREATE TABLE `aijiacms_special_item_11` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `specialid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `typeid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `introduce` varchar(255) NOT NULL DEFAULT '',
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(30) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`),
  KEY `addtime` (`addtime`),
  KEY `specialid` (`specialid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='专题信息';


DROP TABLE IF EXISTS `aijiacms_sphinx`;
CREATE TABLE `aijiacms_sphinx` (
  `moduleid` int(10) unsigned NOT NULL DEFAULT '0',
  `maxid` bigint(20) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `moduleid` (`moduleid`)
) TYPE=MyISAM COMMENT='Sphinx';


DROP TABLE IF EXISTS `aijiacms_spread`;
CREATE TABLE `aijiacms_spread` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `mid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `tid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `word` varchar(50) NOT NULL DEFAULT '',
  `price` float NOT NULL DEFAULT '0',
  `currency` varchar(30) NOT NULL DEFAULT '',
  `company` varchar(100) NOT NULL DEFAULT '',
  `username` varchar(30) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `fromtime` int(10) unsigned NOT NULL DEFAULT '0',
  `totime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `note` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`)
) TYPE=MyISAM COMMENT='排名推广';

-- 
-- 表的结构 `aijiacms_spread_price`
-- 

DROP TABLE IF EXISTS `aijiacms_spread_price`;
CREATE TABLE `aijiacms_spread_price` (
  `itemid` bigint(20) unsigned NOT NULL auto_increment,
  `mid` smallint(6) unsigned NOT NULL default '0',
  `word` varchar(50) NOT NULL default '',
  `price` float NOT NULL default '0',
  `editor` varchar(30) NOT NULL default '',
  `edittime` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`itemid`)
) TYPE=MyISAM COMMENT='排名起价';


DROP TABLE IF EXISTS `aijiacms_style`;
CREATE TABLE `aijiacms_style` (
  `itemid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `typeid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `skin` varchar(50) NOT NULL DEFAULT '',
  `template` varchar(50) NOT NULL DEFAULT '',
  `author` varchar(30) NOT NULL DEFAULT '',
  `groupid` varchar(30) NOT NULL DEFAULT '',
  `fee` float NOT NULL DEFAULT '0',
  `currency` varchar(20) NOT NULL DEFAULT '',
  `money` float NOT NULL DEFAULT '0',
  `credit` int(10) unsigned NOT NULL DEFAULT '0',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `listorder` smallint(4) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`)
) TYPE=MyISAM COMMENT='公司主页模板';



DROP TABLE IF EXISTS `aijiacms_type`;
CREATE TABLE `aijiacms_type` (
  `typeid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `listorder` smallint(4) NOT NULL DEFAULT '0',
   `parentid` bigint(20) NOT NULL DEFAULT '0',
  `typename` varchar(255) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  
  `item` varchar(20) NOT NULL DEFAULT '',
  `cache` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`typeid`),
  KEY `listorder` (`listorder`),
  KEY `item` (`item`)
) TYPE=MyISAM COMMENT='分类';




-- 
-- 表的结构 `aijiacms_upgrade`
-- 

DROP TABLE IF EXISTS `aijiacms_upgrade`;
CREATE TABLE `aijiacms_upgrade` (
  `itemid` bigint(20) unsigned NOT NULL auto_increment,
  `userid` bigint(20) unsigned NOT NULL default '0',
  `username` varchar(30) NOT NULL default '',
  `gid` smallint(4) unsigned NOT NULL default '0',
  `groupid` smallint(4) unsigned NOT NULL default '0',
  `amount` float NOT NULL default '0',
  `message` tinyint(1) unsigned NOT NULL default '0',
  `company` varchar(100) NOT NULL default '',
  `addtime` int(10) unsigned NOT NULL default '0',
  `ip` varchar(50) NOT NULL default '',
  `editor` varchar(30) NOT NULL default '',
  `edittime` int(10) unsigned NOT NULL default '0',
  `status` tinyint(1) NOT NULL default '0',
  `reason` text NOT NULL,
  `note` text NOT NULL,
   `fromtime` int(10) NOT NULL,
  `totime` int(10) NOT NULL,
  PRIMARY KEY  (`itemid`)
) TYPE=MyISAM COMMENT='会员升级';


-- 
-- 表的结构 `aijiacms_upload_0`
-- 

DROP TABLE IF EXISTS `aijiacms_upload_0`;
CREATE TABLE `aijiacms_upload_0` (
  `pid` int(10) unsigned NOT NULL auto_increment,
  `item` varchar(32) NOT NULL default '',
  `tb` varchar(30) NOT NULL,
  `moduleid` smallint(6) unsigned NOT NULL default '0',
  `itemid` bigint(20) unsigned NOT NULL default '0',
  `fileurl` varchar(255) NOT NULL default '',
  `filesize` int(10) unsigned NOT NULL default '0',
  `fileext` varchar(10) NOT NULL default '',
  `upfrom` varchar(10) NOT NULL default '',
  `width` int(10) unsigned NOT NULL default '0',
  `height` int(10) unsigned NOT NULL default '0',
  `addtime` int(10) unsigned NOT NULL default '0',
  `username` varchar(30) NOT NULL default '',
  `ip` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`pid`),
  KEY `item` (`item`)
) TYPE=MyISAM COMMENT='上传记录0';

-- --------------------------------------------------------

-- 
-- 表的结构 `aijiacms_upload_1`
-- 

DROP TABLE IF EXISTS `aijiacms_upload_1`;
CREATE TABLE `aijiacms_upload_1` (
  `pid` int(10) unsigned NOT NULL auto_increment,
  `item` varchar(32) NOT NULL default '',
  `tb` varchar(30) NOT NULL,
  `moduleid` smallint(6) unsigned NOT NULL default '0',
  `itemid` bigint(20) unsigned NOT NULL default '0',
  `fileurl` varchar(255) NOT NULL default '',
  `filesize` int(10) unsigned NOT NULL default '0',
  `fileext` varchar(10) NOT NULL default '',
  `upfrom` varchar(10) NOT NULL default '',
  `width` int(10) unsigned NOT NULL default '0',
  `height` int(10) unsigned NOT NULL default '0',
  `addtime` int(10) unsigned NOT NULL default '0',
  `username` varchar(30) NOT NULL default '',
  `ip` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`pid`),
  KEY `item` (`item`)
) TYPE=MyISAM COMMENT='上传记录1';

-- --------------------------------------------------------

-- 
-- 表的结构 `aijiacms_upload_2`
-- 

DROP TABLE IF EXISTS `aijiacms_upload_2`;
CREATE TABLE `aijiacms_upload_2` (
  `pid` int(10) unsigned NOT NULL auto_increment,
  `item` varchar(32) NOT NULL default '',
  `tb` varchar(30) NOT NULL,
  `moduleid` smallint(6) unsigned NOT NULL default '0',
  `itemid` bigint(20) unsigned NOT NULL default '0',
  `fileurl` varchar(255) NOT NULL default '',
  `filesize` int(10) unsigned NOT NULL default '0',
  `fileext` varchar(10) NOT NULL default '',
  `upfrom` varchar(10) NOT NULL default '',
  `width` int(10) unsigned NOT NULL default '0',
  `height` int(10) unsigned NOT NULL default '0',
  `addtime` int(10) unsigned NOT NULL default '0',
  `username` varchar(30) NOT NULL default '',
  `ip` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`pid`),
  KEY `item` (`item`)
) TYPE=MyISAM COMMENT='上传记录2';

-- --------------------------------------------------------

-- 
-- 表的结构 `aijiacms_upload_3`
-- 

DROP TABLE IF EXISTS `aijiacms_upload_3`;
CREATE TABLE `aijiacms_upload_3` (
  `pid` int(10) unsigned NOT NULL auto_increment,
  `item` varchar(32) NOT NULL default '',
  `tb` varchar(30) NOT NULL,
  `moduleid` smallint(6) unsigned NOT NULL default '0',
  `itemid` bigint(20) unsigned NOT NULL default '0',
  `fileurl` varchar(255) NOT NULL default '',
  `filesize` int(10) unsigned NOT NULL default '0',
  `fileext` varchar(10) NOT NULL default '',
  `upfrom` varchar(10) NOT NULL default '',
  `width` int(10) unsigned NOT NULL default '0',
  `height` int(10) unsigned NOT NULL default '0',
  `addtime` int(10) unsigned NOT NULL default '0',
  `username` varchar(30) NOT NULL default '',
  `ip` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`pid`),
  KEY `item` (`item`)
) TYPE=MyISAM COMMENT='上传记录3';

-- --------------------------------------------------------

-- 
-- 表的结构 `aijiacms_upload_4`
-- 

DROP TABLE IF EXISTS `aijiacms_upload_4`;
CREATE TABLE `aijiacms_upload_4` (
  `pid` int(10) unsigned NOT NULL auto_increment,
  `item` varchar(32) NOT NULL default '',
  `tb` varchar(30) NOT NULL,
  `moduleid` smallint(6) unsigned NOT NULL default '0',
  `itemid` bigint(20) unsigned NOT NULL default '0',
  `fileurl` varchar(255) NOT NULL default '',
  `filesize` int(10) unsigned NOT NULL default '0',
  `fileext` varchar(10) NOT NULL default '',
  `upfrom` varchar(10) NOT NULL default '',
  `width` int(10) unsigned NOT NULL default '0',
  `height` int(10) unsigned NOT NULL default '0',
  `addtime` int(10) unsigned NOT NULL default '0',
  `username` varchar(30) NOT NULL default '',
  `ip` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`pid`),
  KEY `item` (`item`)
) TYPE=MyISAM COMMENT='上传记录4';

-- --------------------------------------------------------

-- 
-- 表的结构 `aijiacms_upload_5`
-- 

DROP TABLE IF EXISTS `aijiacms_upload_5`;
CREATE TABLE `aijiacms_upload_5` (
  `pid` int(10) unsigned NOT NULL auto_increment,
  `item` varchar(32) NOT NULL default '',
  `tb` varchar(30) NOT NULL,
  `moduleid` smallint(6) unsigned NOT NULL default '0',
  `itemid` bigint(20) unsigned NOT NULL default '0',
  `fileurl` varchar(255) NOT NULL default '',
  `filesize` int(10) unsigned NOT NULL default '0',
  `fileext` varchar(10) NOT NULL default '',
  `upfrom` varchar(10) NOT NULL default '',
  `width` int(10) unsigned NOT NULL default '0',
  `height` int(10) unsigned NOT NULL default '0',
  `addtime` int(10) unsigned NOT NULL default '0',
  `username` varchar(30) NOT NULL default '',
  `ip` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`pid`),
  KEY `item` (`item`)
) TYPE=MyISAM COMMENT='上传记录5';

-- --------------------------------------------------------

-- 
-- 表的结构 `aijiacms_upload_6`
-- 

DROP TABLE IF EXISTS `aijiacms_upload_6`;
CREATE TABLE `aijiacms_upload_6` (
  `pid` int(10) unsigned NOT NULL auto_increment,
  `item` varchar(32) NOT NULL default '',
  `tb` varchar(30) NOT NULL,
  `moduleid` smallint(6) unsigned NOT NULL default '0',
  `itemid` bigint(20) unsigned NOT NULL default '0',
  `fileurl` varchar(255) NOT NULL default '',
  `filesize` int(10) unsigned NOT NULL default '0',
  `fileext` varchar(10) NOT NULL default '',
  `upfrom` varchar(10) NOT NULL default '',
  `width` int(10) unsigned NOT NULL default '0',
  `height` int(10) unsigned NOT NULL default '0',
  `addtime` int(10) unsigned NOT NULL default '0',
  `username` varchar(30) NOT NULL default '',
  `ip` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`pid`),
  KEY `item` (`item`)
) TYPE=MyISAM COMMENT='上传记录6';

-- --------------------------------------------------------

-- 
-- 表的结构 `aijiacms_upload_7`
-- 

DROP TABLE IF EXISTS `aijiacms_upload_7`;
CREATE TABLE `aijiacms_upload_7` (
  `pid` int(10) unsigned NOT NULL auto_increment,
  `item` varchar(32) NOT NULL default '',
  `tb` varchar(30) NOT NULL,
  `moduleid` smallint(6) unsigned NOT NULL default '0',
  `itemid` bigint(20) unsigned NOT NULL default '0',
  `fileurl` varchar(255) NOT NULL default '',
  `filesize` int(10) unsigned NOT NULL default '0',
  `fileext` varchar(10) NOT NULL default '',
  `upfrom` varchar(10) NOT NULL default '',
  `width` int(10) unsigned NOT NULL default '0',
  `height` int(10) unsigned NOT NULL default '0',
  `addtime` int(10) unsigned NOT NULL default '0',
  `username` varchar(30) NOT NULL default '',
  `ip` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`pid`),
  KEY `item` (`item`)
) TYPE=MyISAM COMMENT='上传记录7';

-- --------------------------------------------------------

-- 
-- 表的结构 `aijiacms_upload_8`
-- 

DROP TABLE IF EXISTS `aijiacms_upload_8`;
CREATE TABLE `aijiacms_upload_8` (
  `pid` int(10) unsigned NOT NULL auto_increment,
  `item` varchar(32) NOT NULL default '',
  `tb` varchar(30) NOT NULL,
  `moduleid` smallint(6) unsigned NOT NULL default '0',
  `itemid` bigint(20) unsigned NOT NULL default '0',
  `fileurl` varchar(255) NOT NULL default '',
  `filesize` int(10) unsigned NOT NULL default '0',
  `fileext` varchar(10) NOT NULL default '',
  `upfrom` varchar(10) NOT NULL default '',
  `width` int(10) unsigned NOT NULL default '0',
  `height` int(10) unsigned NOT NULL default '0',
  `addtime` int(10) unsigned NOT NULL default '0',
  `username` varchar(30) NOT NULL default '',
  `ip` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`pid`),
  KEY `item` (`item`)
) TYPE=MyISAM COMMENT='上传记录8';

-- --------------------------------------------------------

-- 
-- 表的结构 `aijiacms_upload_9`
-- 

DROP TABLE IF EXISTS `aijiacms_upload_9`;
CREATE TABLE `aijiacms_upload_9` (
  `pid` int(10) unsigned NOT NULL auto_increment,
  `item` varchar(32) NOT NULL default '',
  `tb` varchar(30) NOT NULL,
  `moduleid` smallint(6) unsigned NOT NULL default '0',
  `itemid` bigint(20) unsigned NOT NULL default '0',
  `fileurl` varchar(255) NOT NULL default '',
  `filesize` int(10) unsigned NOT NULL default '0',
  `fileext` varchar(10) NOT NULL default '',
  `upfrom` varchar(10) NOT NULL default '',
  `width` int(10) unsigned NOT NULL default '0',
  `height` int(10) unsigned NOT NULL default '0',
  `addtime` int(10) unsigned NOT NULL default '0',
  `username` varchar(30) NOT NULL default '',
  `ip` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`pid`),
  KEY `item` (`item`)
) TYPE=MyISAM COMMENT='上传记录9';


DROP TABLE IF EXISTS `aijiacms_validate`;
CREATE TABLE `aijiacms_validate` (
  `itemid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `type` varchar(30) NOT NULL DEFAULT '',
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `thumb1` varchar(255) NOT NULL DEFAULT '',
  `thumb2` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(30) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`)
) TYPE=MyISAM COMMENT='资料认证';


DROP TABLE IF EXISTS `aijiacms_video_14`;
CREATE TABLE `aijiacms_video_14` (
   `itemid` bigint(20) unsigned NOT NULL auto_increment,
  `catid` int(10) unsigned NOT NULL default '0',
  `areaid` int(10) unsigned NOT NULL default '0',
  `level` tinyint(1) unsigned NOT NULL default '0',
  `title` varchar(100) NOT NULL default '',
  `style` varchar(50) NOT NULL default '',
  `fee` float NOT NULL default '0',
  `tag` varchar(255) NOT NULL default '',
  `album` varchar(100) NOT NULL,
  `keyword` varchar(255) NOT NULL default '',
  `pptword` varchar(255) NOT NULL default '',
  `hits` int(10) unsigned NOT NULL default '0',
  `comments` int(10) unsigned NOT NULL default '0',
  `thumb` varchar(255) NOT NULL default '',
  `video` varchar(255) NOT NULL default '',
  `wx` varchar(50) NOT NULL DEFAULT '',
  `mobile` tinyint(1) unsigned NOT NULL default '0',
  `width` smallint(4) unsigned NOT NULL default '0',
  `height` smallint(4) unsigned NOT NULL default '0',
  `username` varchar(30) NOT NULL default '',
  `addtime` int(10) unsigned NOT NULL default '0',
  `introduce` varchar(255) NOT NULL default '',
  `editor` varchar(30) NOT NULL default '',
  `edittime` int(10) unsigned NOT NULL default '0',
  `ip` varchar(50) NOT NULL default '',
  `template` varchar(30) NOT NULL default '0',
  `status` tinyint(1) NOT NULL default '0',
  `linkurl` varchar(255) NOT NULL default '',
  `filepath` varchar(255) NOT NULL default '',
  `note` varchar(255) NOT NULL default '',
  `houseid` int(10) DEFAULT NULL,
  `housename` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`itemid`),
  KEY `username` (`username`),
  KEY `addtime` (`addtime`),
  KEY `catid` (`catid`),
  KEY `album` (`album`)
) TYPE=MyISAM COMMENT='视频';


DROP TABLE IF EXISTS `aijiacms_video_data_14`;
CREATE TABLE `aijiacms_video_data_14` (
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` mediumtext NOT NULL,
  PRIMARY KEY (`itemid`)
) TYPE=MyISAM COMMENT='视频内容';


DROP TABLE IF EXISTS `aijiacms_vote`;
CREATE TABLE `aijiacms_vote` (
  `itemid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `typeid` int(10) unsigned NOT NULL DEFAULT '0',
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `choose` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `vote_min` smallint(2) unsigned NOT NULL DEFAULT '0',
  `vote_max` smallint(2) unsigned NOT NULL DEFAULT '0',
  `votes` int(10) unsigned NOT NULL DEFAULT '0',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `fromtime` int(10) unsigned NOT NULL DEFAULT '0',
  `totime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `linkto` varchar(255) NOT NULL DEFAULT '',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  `template_vote` varchar(30) NOT NULL DEFAULT '',
  `template` varchar(30) NOT NULL DEFAULT '',
  `s1` varchar(255) NOT NULL DEFAULT '',
  `s2` varchar(255) NOT NULL DEFAULT '',
  `s3` varchar(255) NOT NULL DEFAULT '',
  `s4` varchar(255) NOT NULL DEFAULT '',
  `s5` varchar(255) NOT NULL DEFAULT '',
  `s6` varchar(255) NOT NULL DEFAULT '',
  `s7` varchar(255) NOT NULL DEFAULT '',
  `s8` varchar(255) NOT NULL DEFAULT '',
  `s9` varchar(255) NOT NULL DEFAULT '',
  `s10` varchar(255) NOT NULL DEFAULT '',
  `v1` int(10) unsigned NOT NULL DEFAULT '0',
  `v2` int(10) unsigned NOT NULL DEFAULT '0',
  `v3` int(10) unsigned NOT NULL DEFAULT '0',
  `v4` int(10) unsigned NOT NULL DEFAULT '0',
  `v5` int(10) unsigned NOT NULL DEFAULT '0',
  `v6` int(10) unsigned NOT NULL DEFAULT '0',
  `v7` int(10) unsigned NOT NULL DEFAULT '0',
  `v8` int(10) unsigned NOT NULL DEFAULT '0',
  `v9` int(10) unsigned NOT NULL DEFAULT '0',
  `v10` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`)
) TYPE=MyISAM COMMENT='投票';


DROP TABLE IF EXISTS `aijiacms_vote_record`;
CREATE TABLE `aijiacms_vote_record` (
  `rid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `votetime` int(10) unsigned NOT NULL DEFAULT '0',
  `votes` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`rid`),
  KEY `itemid` (`itemid`)
) TYPE=MyISAM COMMENT='投票记录';


DROP TABLE IF EXISTS `aijiacms_webpage`;
CREATE TABLE `aijiacms_webpage` (
  `itemid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item` varchar(30) NOT NULL DEFAULT '',
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `content` mediumtext NOT NULL,
  `seo_title` varchar(255) NOT NULL DEFAULT '',
  `seo_keywords` varchar(255) NOT NULL DEFAULT '',
  `seo_description` varchar(255) NOT NULL DEFAULT '',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `listorder` smallint(4) NOT NULL DEFAULT '0',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `islink` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  `domain` varchar(255) NOT NULL DEFAULT '',
  `template` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`)
) TYPE=MyISAM COMMENT='单网页';

DROP TABLE IF EXISTS `aijiacms_wenfang`;
CREATE TABLE `aijiacms_wenfang` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `item_mid` smallint(6) NOT NULL DEFAULT '0',
  `item_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `item_title` varchar(255) NOT NULL DEFAULT '',
  `item_linkurl` varchar(255) NOT NULL DEFAULT '',
  `item_username` varchar(30) NOT NULL DEFAULT '',
  `star` tinyint(1) NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  `qid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `quotation` text NOT NULL,
  `username` varchar(30) NOT NULL DEFAULT '',
  `hidden` tinyint(1) NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `reply` text NOT NULL,
  `editor` varchar(30) NOT NULL DEFAULT '',
  `replyer` varchar(30) NOT NULL DEFAULT '',
  `replytime` int(10) unsigned NOT NULL DEFAULT '0',
  `agree` int(10) unsigned NOT NULL DEFAULT '0',
  `against` int(10) unsigned NOT NULL DEFAULT '0',
  `quote` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`),
  KEY `item_mid` (`item_mid`),
  KEY `item_id` (`item_id`)
) TYPE=MyISAM COMMENT='问房';

DROP TABLE IF EXISTS `aijiacms_info_13`;
CREATE TABLE `aijiacms_info_13` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `fee` float NOT NULL DEFAULT '0',
  `keyword` varchar(255) NOT NULL DEFAULT '',
  `pptword` varchar(255) NOT NULL DEFAULT '',
  `comments` int(10) unsigned NOT NULL default '0',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `thumb1` varchar(255) NOT NULL DEFAULT '',
  `thumb2` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(30) NOT NULL DEFAULT '',
  `groupid` smallint(4) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `adddate` date NOT NULL DEFAULT '0000-00-00',
  `totime` int(10) unsigned NOT NULL DEFAULT '0',
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  `company` varchar(100) NOT NULL DEFAULT '',
  `vip` smallint(2) unsigned NOT NULL DEFAULT '0',
  `validated` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `truename` varchar(30) NOT NULL DEFAULT '',
  `telephone` varchar(50) NOT NULL DEFAULT '',
  `fax` varchar(50) NOT NULL DEFAULT '',
  `mobile` varchar(50) NOT NULL DEFAULT '',
  `address` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `qq` varchar(20) NOT NULL DEFAULT '',
  `ali` varchar(30) NOT NULL DEFAULT '',
  `skype` varchar(30) NOT NULL DEFAULT '',
  `msn` varchar(50) NOT NULL DEFAULT '',
  `wx` varchar(50) NOT NULL DEFAULT '',
  `introduce` varchar(255) NOT NULL DEFAULT '',
  `n1` varchar(100) NOT NULL,
  `n2` varchar(100) NOT NULL,
  `n3` varchar(100) NOT NULL,
  `v1` varchar(100) NOT NULL,
  `v2` varchar(100) NOT NULL,
  `v3` varchar(100) NOT NULL,
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `editdate` date NOT NULL DEFAULT '0000-00-00',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `template` varchar(30) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `listorder` smallint(4) unsigned NOT NULL DEFAULT '0',
  `islink` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  `filepath` varchar(255) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`),
  KEY `username` (`username`),
  KEY `edittime` (`edittime`),
  KEY `catid` (`catid`),
  KEY `areaid` (`areaid`),
  KEY `editdate` (`editdate`,`vip`,`edittime`)
) TYPE=MyISAM  COMMENT='装修';


DROP TABLE IF EXISTS `aijiacms_info_data_13`;
CREATE TABLE `aijiacms_info_data_13` (
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` mediumtext NOT NULL,
  PRIMARY KEY (`itemid`)
) TYPE=MyISAM  COMMENT='装修内容';

DROP TABLE IF EXISTS `aijiacms_fenxiao`;
CREATE TABLE `aijiacms_fenxiao` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `listorder` smallint(4) unsigned NOT NULL DEFAULT '0',
  `userid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `typeid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `truename` varchar(20) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `company` varchar(100) NOT NULL DEFAULT '',
  `career` varchar(20) NOT NULL DEFAULT '',
  `telephone` varchar(20) NOT NULL DEFAULT '',
  `mobile` varchar(20) NOT NULL DEFAULT '',
  `homepage` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `msn` varchar(50) NOT NULL DEFAULT '',
  `qq` varchar(20) NOT NULL DEFAULT '',
    `wx` varchar(50) NOT NULL DEFAULT '',
  `ali` varchar(30) NOT NULL DEFAULT '',
  `skype` varchar(30) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `yxjg` varchar(255) NOT NULL,
  `areaid` varchar(20) NOT NULL,
  `house` varchar(100) NOT NULL,
  `hname` varchar(200) NOT NULL,
  `house2` varchar(200) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `tuijian` varchar(50) DEFAULT NULL,
  `cprice` varchar(20) DEFAULT NULL,
  `cmoney` varchar(20) DEFAULT NULL,
  `shouse` varchar(20) DEFAULT NULL,
  `edittime` int(10) DEFAULT NULL,
  `editor` varchar(30) NOT NULL,
  `snote` varchar(255) NOT NULL,
  `content` varchar(255) NOT NULL,
  `message` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`),
  KEY `userid` (`userid`)
) TYPE=MyISAM COMMENT='分销客户';

DROP TABLE IF EXISTS `aijiacms_finance_amount`;
CREATE TABLE `aijiacms_finance_amount` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL DEFAULT '',
  `kehu` varchar(30) NOT NULL DEFAULT '',
  `amount` decimal(10,0) NOT NULL DEFAULT '0',
  `balance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `note` varchar(255) NOT NULL DEFAULT '',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `admintime` int(10) NOT NULL,
  `admin` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`),
  KEY `username` (`username`)
) TYPE=MyISAM  COMMENT='佣金结算';





DROP TABLE IF EXISTS `aijiacms_cron`;
CREATE TABLE `aijiacms_cron` (
  `itemid` smallint(6) unsigned NOT NULL auto_increment,
  `title` varchar(30) NOT NULL,
  `type` tinyint(1) unsigned NOT NULL default '0',
  `name` varchar(20) NOT NULL,
  `schedule` varchar(255) NOT NULL,
  `n1` varchar(100) NOT NULL,
  `n2` varchar(100) NOT NULL,
  `n3` varchar(100) NOT NULL,
  `v1` varchar(100) NOT NULL,
  `v2` varchar(100) NOT NULL,
  `v3` varchar(100) NOT NULL,
  `lasttime` int(10) unsigned NOT NULL default '0',
  `nexttime` int(10) unsigned NOT NULL default '0',
  `status` tinyint(1) unsigned NOT NULL default '0',
  `note` text NOT NULL,
  PRIMARY KEY  (`itemid`),
  KEY `nexttime` (`nexttime`)
) TYPE=MyISAM COMMENT='计划任务';

DROP TABLE IF EXISTS `aijiacms_finance_deposit`;
CREATE TABLE `aijiacms_finance_deposit` (
  `itemid` bigint(20) unsigned NOT NULL auto_increment,
  `username` varchar(30) NOT NULL default '',
  `amount` decimal(10,2) NOT NULL default '0.00',
  `addtime` int(10) unsigned NOT NULL default '0',
  `editor` varchar(30) NOT NULL,
  `reason` varchar(255) NOT NULL default '',
  `note` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`itemid`),
  KEY `username` (`username`)
) TYPE=MyISAM COMMENT='保证金';

DROP TABLE IF EXISTS `aijiacms_form`;
CREATE TABLE `aijiacms_form` (
  `itemid` int(10) unsigned NOT NULL auto_increment,
  `typeid` int(10) unsigned NOT NULL default '0',
  `areaid` int(10) unsigned NOT NULL default '0',
  `level` tinyint(1) unsigned NOT NULL default '0',
  `title` varchar(100) NOT NULL default '',
  `style` varchar(50) NOT NULL default '',
  `content` mediumtext NOT NULL,
  `groupid` varchar(255) NOT NULL,
  `verify` tinyint(1) unsigned NOT NULL default '0',
  `display` tinyint(1) unsigned NOT NULL default '0',
  `question` int(10) unsigned NOT NULL default '0',
  `maxanswer` int(10) unsigned NOT NULL default '1',
  `answer` int(10) unsigned NOT NULL default '0',
  `hits` int(10) unsigned NOT NULL default '0',
  `addtime` int(10) unsigned NOT NULL default '0',
  `fromtime` int(10) unsigned NOT NULL default '0',
  `totime` int(10) unsigned NOT NULL default '0',
  `editor` varchar(30) NOT NULL default '',
  `edittime` int(10) unsigned NOT NULL default '0',
  `linkurl` varchar(255) NOT NULL default '',
  `template` varchar(30) NOT NULL,
  PRIMARY KEY  (`itemid`),
  KEY `addtime` (`addtime`)
) TYPE=MyISAM COMMENT='表单';

DROP TABLE IF EXISTS `aijiacms_form_answer`;
CREATE TABLE `aijiacms_form_answer` (
  `aid` bigint(20) unsigned NOT NULL auto_increment,
  `fid` bigint(20) unsigned NOT NULL default '0',
  `rid` bigint(20) unsigned NOT NULL default '0',
  `qid` bigint(20) unsigned NOT NULL default '0',
  `username` varchar(30) NOT NULL default '',
  `ip` varchar(50) NOT NULL default '',
  `addtime` int(10) unsigned NOT NULL default '0',
  `content` mediumtext NOT NULL,
  `other` varchar(255) NOT NULL,
  `item` varchar(100) NOT NULL,
  PRIMARY KEY  (`aid`)
) TYPE=MyISAM COMMENT='表单回复';

DROP TABLE IF EXISTS `aijiacms_form_question`;
CREATE TABLE `aijiacms_form_question` (
  `qid` bigint(20) unsigned NOT NULL auto_increment,
  `fid` int(10) unsigned NOT NULL default '0',
  `type` tinyint(1) unsigned NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `value` mediumtext NOT NULL,
  `required` varchar(30) NOT NULL,
  `extend` mediumtext NOT NULL,
  `listorder` smallint(4) unsigned NOT NULL default '0',
  PRIMARY KEY  (`qid`),
  KEY `fid` (`fid`)
) TYPE=MyISAM COMMENT='表单选项';

DROP TABLE IF EXISTS `aijiacms_form_record`;
CREATE TABLE `aijiacms_form_record` (
  `rid` bigint(20) unsigned NOT NULL auto_increment,
  `fid` bigint(20) unsigned NOT NULL default '0',
  `username` varchar(30) NOT NULL default '',
  `ip` varchar(50) NOT NULL default '',
  `addtime` int(10) unsigned NOT NULL default '0',
  `item` varchar(100) NOT NULL,
  PRIMARY KEY  (`rid`)
) TYPE=MyISAM COMMENT='表单回复记录';



DROP TABLE IF EXISTS `aijiacms_weixin_bind`;
CREATE TABLE `aijiacms_weixin_bind` (
  `username` varchar(30) NOT NULL default '',
  `sid` varchar(32) NOT NULL default '0',
  `addtime` int(10) unsigned NOT NULL default '0',
  UNIQUE KEY `username` (`username`)
) TYPE=MyISAM COMMENT='微信扫码绑定';

DROP TABLE IF EXISTS `aijiacms_weixin_chat`;
CREATE TABLE `aijiacms_weixin_chat` (
  `itemid` bigint(20) unsigned NOT NULL auto_increment,
  `editor` varchar(30) NOT NULL,
  `openid` varchar(255) NOT NULL default '',
  `type` varchar(20) NOT NULL,
  `event` tinyint(1) unsigned NOT NULL default '0',
  `addtime` int(10) unsigned NOT NULL default '0',
  `content` mediumtext NOT NULL,
  `misc` mediumtext NOT NULL,
  PRIMARY KEY  (`itemid`),
  KEY `openid` (`openid`),
  KEY `addtime` (`addtime`),
  KEY `event` (`event`)
) TYPE=MyISAM COMMENT='微信消息';

DROP TABLE IF EXISTS `aijiacms_weixin_user`;
CREATE TABLE `aijiacms_weixin_user` (
  `itemid` bigint(20) unsigned NOT NULL auto_increment,
  `username` varchar(30) NOT NULL default '',
  `openid` varchar(255) NOT NULL default '',
  `nickname` varchar(255) NOT NULL default '',
  `sex` tinyint(1) unsigned NOT NULL default '0',
  `city` varchar(100) NOT NULL,
  `province` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `language` varchar(100) NOT NULL,
  `headimgurl` varchar(255) NOT NULL,
  `edittime` int(10) unsigned NOT NULL default '0',
  `addtime` int(10) unsigned NOT NULL default '0',
  `visittime` int(10) unsigned NOT NULL default '0',
  `credittime` int(10) unsigned NOT NULL default '0',
  `subscribe` tinyint(1) unsigned NOT NULL default '1',
  `push` tinyint(1) unsigned NOT NULL default '1',
  `logintime` int(10) unsigned NOT NULL default '0',
    `logintimes` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`itemid`),
  UNIQUE KEY `openid` (`openid`),
  KEY `username` (`username`)
) TYPE=MyISAM COMMENT='微信用户';

DROP TABLE IF EXISTS `aijiacms_qiandao`;
CREATE TABLE `aijiacms_qiandao` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `userid` bigint(20) NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `signdays` smallint(3) NOT NULL DEFAULT '0',
  `feeadd` int(10) NOT NULL DEFAULT '0',
  `ostype` varchar(50) NOT NULL DEFAULT '',
  `areaid` smallint(6) NOT NULL DEFAULT '0',
  `note` varchar(255) NOT NULL DEFAULT '',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`itemid`),
  UNIQUE KEY `itemid` (`itemid`)
) TYPE=MyISAM COMMENT='会员到签';

DROP TABLE IF EXISTS `aijiacms_hongbao`;
CREATE TABLE `aijiacms_hongbao` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `userid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `truename` varchar(20) NOT NULL DEFAULT '',
  `mobile` varchar(20) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `house` varchar(100) NOT NULL,
  `hname` varchar(200) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `money` varchar(20) DEFAULT NULL,
  `edittime` int(10) DEFAULT NULL,
  `editor` varchar(30) NOT NULL,
  PRIMARY KEY (`itemid`),
  KEY `username` (`username`) USING BTREE
) ENGINE=MyISAM COMMENT='红包';

DROP TABLE IF EXISTS `aijiacms_newhouse_huxing`;
CREATE TABLE `aijiacms_newhouse_huxing` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `houseid` int(20) NOT NULL,
  `introduce` text NOT NULL,
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `listorder` smallint(4) unsigned NOT NULL DEFAULT '0',
  `catid` int(20) NOT NULL,
  `status` int(20) NOT NULL,
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `edittime` int(20) NOT NULL,
  `title` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `bh` varchar(20) NOT NULL,
  `shi` int(10) NOT NULL,
  `ting` int(10) NOT NULL,
  `wei` int(10) NOT NULL,
  `mj` varchar(10) NOT NULL,
  `dj` varchar(10) NOT NULL,
  `note` varchar(10) NOT NULL,
  `zlhx` int(10) NOT NULL,
  `xszt` int(10) NOT NULL,
  PRIMARY KEY (`itemid`),
  KEY `listorder` (`listorder`)
) ENGINE=MyISAM   COMMENT='图库图片';


DROP TABLE IF EXISTS `aijiacms_newhouse_xiangce`;
CREATE TABLE `aijiacms_newhouse_xiangce` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `houseid` int(20) NOT NULL,
  `introduce` text NOT NULL,
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `listorder` smallint(4) unsigned NOT NULL DEFAULT '0',
  `catid` int(20) NOT NULL,
  `status` int(20) NOT NULL,
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `edittime` int(20) NOT NULL,
  `title` varchar(20) CHARACTER SET utf8 NOT NULL,
  `username` varchar(20) NOT NULL,
   `level` int(20) NOT NULL,
  PRIMARY KEY (`itemid`),
  KEY `listorder` (`listorder`)
) ENGINE=MyISAM  COMMENT='图库图片';

-- 
-- 表的结构 `aijiacms_chat_data_0`
-- 

DROP TABLE IF EXISTS `aijiacms_chat_data_0`;
CREATE TABLE `aijiacms_chat_data_0` (
  `itemid` bigint(20) unsigned NOT NULL auto_increment,
  `chatid` varchar(32) NOT NULL,
  `username` varchar(30) NOT NULL,
  `addtime` int(10) unsigned NOT NULL default '0',
  `content` text NOT NULL,
  PRIMARY KEY  (`itemid`),
  KEY `chatid` (`chatid`),
  KEY `addtime` (`addtime`)
) TYPE=MyISAM COMMENT='聊天记录_0';

-- --------------------------------------------------------

-- 
-- 表的结构 `aijiacms_chat_data_1`
-- 

DROP TABLE IF EXISTS `aijiacms_chat_data_1`;
CREATE TABLE `aijiacms_chat_data_1` (
  `itemid` bigint(20) unsigned NOT NULL auto_increment,
  `chatid` varchar(32) NOT NULL,
  `username` varchar(30) NOT NULL,
  `addtime` int(10) unsigned NOT NULL default '0',
  `content` text NOT NULL,
  PRIMARY KEY  (`itemid`),
  KEY `chatid` (`chatid`),
  KEY `addtime` (`addtime`)
) TYPE=MyISAM COMMENT='聊天记录_1';

-- --------------------------------------------------------

-- 
-- 表的结构 `aijiacms_chat_data_2`
-- 

DROP TABLE IF EXISTS `aijiacms_chat_data_2`;
CREATE TABLE `aijiacms_chat_data_2` (
  `itemid` bigint(20) unsigned NOT NULL auto_increment,
  `chatid` varchar(32) NOT NULL,
  `username` varchar(30) NOT NULL,
  `addtime` int(10) unsigned NOT NULL default '0',
  `content` text NOT NULL,
  PRIMARY KEY  (`itemid`),
  KEY `chatid` (`chatid`),
  KEY `addtime` (`addtime`)
) TYPE=MyISAM COMMENT='聊天记录_2';

-- --------------------------------------------------------

-- 
-- 表的结构 `aijiacms_chat_data_3`
-- 

DROP TABLE IF EXISTS `aijiacms_chat_data_3`;
CREATE TABLE `aijiacms_chat_data_3` (
  `itemid` bigint(20) unsigned NOT NULL auto_increment,
  `chatid` varchar(32) NOT NULL,
  `username` varchar(30) NOT NULL,
  `addtime` int(10) unsigned NOT NULL default '0',
  `content` text NOT NULL,
  PRIMARY KEY  (`itemid`),
  KEY `chatid` (`chatid`),
  KEY `addtime` (`addtime`)
) TYPE=MyISAM COMMENT='聊天记录_3';

-- --------------------------------------------------------

-- 
-- 表的结构 `aijiacms_chat_data_4`
-- 

DROP TABLE IF EXISTS `aijiacms_chat_data_4`;
CREATE TABLE `aijiacms_chat_data_4` (
  `itemid` bigint(20) unsigned NOT NULL auto_increment,
  `chatid` varchar(32) NOT NULL,
  `username` varchar(30) NOT NULL,
  `addtime` int(10) unsigned NOT NULL default '0',
  `content` text NOT NULL,
  PRIMARY KEY  (`itemid`),
  KEY `chatid` (`chatid`),
  KEY `addtime` (`addtime`)
) TYPE=MyISAM COMMENT='聊天记录_4';

-- --------------------------------------------------------

-- 
-- 表的结构 `aijiacms_chat_data_5`
-- 

DROP TABLE IF EXISTS `aijiacms_chat_data_5`;
CREATE TABLE `aijiacms_chat_data_5` (
  `itemid` bigint(20) unsigned NOT NULL auto_increment,
  `chatid` varchar(32) NOT NULL,
  `username` varchar(30) NOT NULL,
  `addtime` int(10) unsigned NOT NULL default '0',
  `content` text NOT NULL,
  PRIMARY KEY  (`itemid`),
  KEY `chatid` (`chatid`),
  KEY `addtime` (`addtime`)
) TYPE=MyISAM COMMENT='聊天记录_5';

-- --------------------------------------------------------

-- 
-- 表的结构 `aijiacms_chat_data_6`
-- 

DROP TABLE IF EXISTS `aijiacms_chat_data_6`;
CREATE TABLE `aijiacms_chat_data_6` (
  `itemid` bigint(20) unsigned NOT NULL auto_increment,
  `chatid` varchar(32) NOT NULL,
  `username` varchar(30) NOT NULL,
  `addtime` int(10) unsigned NOT NULL default '0',
  `content` text NOT NULL,
  PRIMARY KEY  (`itemid`),
  KEY `chatid` (`chatid`),
  KEY `addtime` (`addtime`)
) TYPE=MyISAM COMMENT='聊天记录_6';

-- --------------------------------------------------------

-- 
-- 表的结构 `aijiacms_chat_data_7`
-- 

DROP TABLE IF EXISTS `aijiacms_chat_data_7`;
CREATE TABLE `aijiacms_chat_data_7` (
  `itemid` bigint(20) unsigned NOT NULL auto_increment,
  `chatid` varchar(32) NOT NULL,
  `username` varchar(30) NOT NULL,
  `addtime` int(10) unsigned NOT NULL default '0',
  `content` text NOT NULL,
  PRIMARY KEY  (`itemid`),
  KEY `chatid` (`chatid`),
  KEY `addtime` (`addtime`)
) TYPE=MyISAM COMMENT='聊天记录_7';

-- --------------------------------------------------------

-- 
-- 表的结构 `aijiacms_chat_data_8`
-- 

DROP TABLE IF EXISTS `aijiacms_chat_data_8`;
CREATE TABLE `aijiacms_chat_data_8` (
  `itemid` bigint(20) unsigned NOT NULL auto_increment,
  `chatid` varchar(32) NOT NULL,
  `username` varchar(30) NOT NULL,
  `addtime` int(10) unsigned NOT NULL default '0',
  `content` text NOT NULL,
  PRIMARY KEY  (`itemid`),
  KEY `chatid` (`chatid`),
  KEY `addtime` (`addtime`)
) TYPE=MyISAM COMMENT='聊天记录_8';

-- --------------------------------------------------------

-- 
-- 表的结构 `aijiacms_chat_data_9`
-- 

DROP TABLE IF EXISTS `aijiacms_chat_data_9`;
CREATE TABLE `aijiacms_chat_data_9` (
  `itemid` bigint(20) unsigned NOT NULL auto_increment,
  `chatid` varchar(32) NOT NULL,
  `username` varchar(30) NOT NULL,
  `addtime` int(10) unsigned NOT NULL default '0',
  `content` text NOT NULL,
  PRIMARY KEY  (`itemid`),
  KEY `chatid` (`chatid`),
  KEY `addtime` (`addtime`)
) TYPE=MyISAM COMMENT='聊天记录_9';

-- --------------------------------------------------------

-- 
-- 表的结构 `aijiacms_finance_award`
-- 

DROP TABLE IF EXISTS `aijiacms_finance_award`;
CREATE TABLE `aijiacms_finance_award` (
  `itemid` bigint(20) unsigned NOT NULL auto_increment,
  `username` varchar(30) NOT NULL default '',
  `fee` float unsigned NOT NULL default '0',
  `paytime` int(10) unsigned NOT NULL default '0',
  `ip` varchar(50) NOT NULL default '',
  `mid` smallint(6) unsigned NOT NULL default '0',
  `tid` bigint(20) unsigned NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`itemid`),
  KEY `username` (`username`)
) TYPE=MyISAM COMMENT='打赏记录';

-- --------------------------------------------------------

-- 
-- 表的结构 `aijiacms_finance_coupon`
-- 

DROP TABLE IF EXISTS `aijiacms_finance_coupon`;
CREATE TABLE `aijiacms_finance_coupon` (
  `itemid` bigint(20) unsigned NOT NULL auto_increment,
  `title` varchar(100) NOT NULL,
  `username` varchar(30) NOT NULL,
  `seller` varchar(30) NOT NULL,
  `addtime` int(10) unsigned NOT NULL default '0',
  `fromtime` int(10) unsigned NOT NULL default '0',
  `totime` int(10) unsigned NOT NULL default '0',
  `price` decimal(10,2) unsigned NOT NULL default '0.00',
  `cost` decimal(10,2) unsigned NOT NULL default '0.00',
  `pid` bigint(20) unsigned NOT NULL default '0',
  `oid` bigint(20) unsigned NOT NULL default '0',
  `editor` varchar(30) NOT NULL,
  `edittime` int(10) unsigned NOT NULL default '0',
  `note` varchar(255) NOT NULL,
  PRIMARY KEY  (`itemid`),
  KEY `username` (`username`)
) TYPE=MyISAM COMMENT='优惠券';

-- --------------------------------------------------------

-- 
-- 表的结构 `aijiacms_finance_promo`
-- 

DROP TABLE IF EXISTS `aijiacms_finance_promo`;
CREATE TABLE `aijiacms_finance_promo` (
  `itemid` bigint(20) unsigned NOT NULL auto_increment,
  `title` varchar(100) NOT NULL,
  `username` varchar(30) NOT NULL,
  `addtime` int(10) unsigned NOT NULL default '0',
  `fromtime` int(10) unsigned NOT NULL default '0',
  `totime` int(10) unsigned NOT NULL default '0',
  `price` decimal(10,2) unsigned NOT NULL default '0.00',
  `cost` decimal(10,2) unsigned NOT NULL default '0.00',
  `amount` int(10) unsigned NOT NULL default '0',
  `number` int(10) unsigned NOT NULL default '0',
  `open` tinyint(1) unsigned NOT NULL default '1',
  `editor` varchar(30) NOT NULL,
  `edittime` int(10) unsigned NOT NULL default '0',
  `note` varchar(255) NOT NULL,
  PRIMARY KEY  (`itemid`),
  KEY `username` (`username`)
) TYPE=MyISAM COMMENT='优惠促销';

-- --------------------------------------------------------

-- 
-- 表的结构 `aijiacms_mall_view_16`
-- 

DROP TABLE IF EXISTS `aijiacms_mall_view_16`;
CREATE TABLE `aijiacms_mall_view_16` (
  `uid` varchar(50) NOT NULL,
  `itemid` bigint(20) unsigned NOT NULL default '0',
  `username` varchar(30) NOT NULL default '',
  `seller` varchar(30) NOT NULL,
  `lasttime` int(10) unsigned NOT NULL default '0',
  UNIQUE KEY `uid` (`uid`),
  KEY `username` (`username`),
  KEY `lasttime` (`lasttime`)
) TYPE=MyISAM COMMENT='浏览历史';

-- --------------------------------------------------------

-- 
-- 表的结构 `aijiacms_member_misc`
-- 

DROP TABLE IF EXISTS `aijiacms_member_misc`;
CREATE TABLE `aijiacms_member_misc` (
  `userid` bigint(20) unsigned NOT NULL,
  `username` varchar(30) NOT NULL default '',
  `bank` varchar(30) NOT NULL default '',
  `banktype` tinyint(1) unsigned NOT NULL default '0',
  `branch` varchar(100) NOT NULL,
  `account` varchar(30) NOT NULL default '',
  `reply` text NOT NULL,
  `black` text NOT NULL,
  `send` tinyint(1) unsigned NOT NULL default '1',
  UNIQUE KEY `userid` (`userid`),
  UNIQUE KEY `username` (`username`)
) TYPE=MyISAM COMMENT='会员杂项';

-- --------------------------------------------------------

-- 
-- 表的结构 `aijiacms_weixin_auto`
-- 

DROP TABLE IF EXISTS `aijiacms_weixin_auto`;
CREATE TABLE `aijiacms_weixin_auto` (
  `itemid` int(10) unsigned NOT NULL auto_increment,
  `keyword` varchar(255) NOT NULL,
  `reply` text NOT NULL,
  PRIMARY KEY  (`itemid`),
  KEY `keyword` (`keyword`)
) TYPE=MyISAM COMMENT='微信回复';

-- --------------------------------------------------------


DROP TABLE IF EXISTS `aijiacms_navmenu`;
CREATE TABLE `aijiacms_navmenu` (
  `navid` int(11) NOT NULL AUTO_INCREMENT,
  `parentid` int(11) NOT NULL COMMENT '导航 id',
  `arrparentid` varchar(11) NOT NULL DEFAULT '255' COMMENT '父 id',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态;1:显示;0:隐藏',
  `listorder` float NOT NULL DEFAULT '10000' COMMENT '排序',
   `title` varchar(100) NOT NULL DEFAULT '',
  `target` varchar(10) NOT NULL DEFAULT '' COMMENT '打开方式',
  `href` varchar(100) NOT NULL DEFAULT '' COMMENT '链接',
  `icon` varchar(20) NOT NULL DEFAULT '' COMMENT '图标',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '层级关系',
  `child` tinyint(20) NOT NULL,
  `arrchildid` text NOT NULL,
  PRIMARY KEY (`navid`)
) TYPE=MyISAM COMMENT='菜单';

DROP TABLE IF EXISTS `aijiacms_newhouse_sand`;
CREATE TABLE `aijiacms_newhouse_sand` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `house_id` int(11) unsigned NOT NULL DEFAULT '0',
  `title` varchar(50) DEFAULT '' COMMENT '楼栋名称',
  `unit` varchar(100) DEFAULT '' COMMENT '单元数',
  `elevator` varchar(100) DEFAULT '' COMMENT '电梯数',
  `floor_num` varchar(100) DEFAULT '' COMMENT '楼层数',
  `room_num` varchar(100) DEFAULT '' COMMENT '总户数',
  `open_time` int(11) unsigned DEFAULT '0' COMMENT '开盘时间',
  `complate_time` int(11) unsigned DEFAULT '0' COMMENT '交房时间',
  `sale_status` char(4) DEFAULT NULL COMMENT '销售状态',
  `huxing_id` varchar(50) DEFAULT '' COMMENT '户型id '',''分隔',
  `is_del` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '新增时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS `aijiacms_newhouse_sand_pic`;
CREATE TABLE `aijiacms_newhouse_sand_pic` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `house_id` int(11) unsigned NOT NULL DEFAULT '0',
  `img` varchar(100) DEFAULT NULL COMMENT '沙盘图片',
  `data` text COMMENT '位置标注',
  `is_del` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '新增时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `aijiacms_subscribe_follow`;
CREATE TABLE `aijiacms_subscribe_follow` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '',
  `subid` int(20) NOT NULL,
  `content` text NOT NULL,
  `username` varchar(30) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `telephone` varchar(30) NOT NULL DEFAULT '',
  `truename` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`),
  KEY `touser` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='预约管理';

DROP TABLE IF EXISTS `aijiacms_app_nav`;
CREATE TABLE `aijiacms_app_nav` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `platform` char(30) NOT NULL DEFAULT 'pc' COMMENT '所属平台（pc PC网站, h5 H5手机网站, app 手机APP, alipay 支付宝小程序, weixin 微信小程序, baidu 百度小程序）',
  `event_type` tinyint(2) NOT NULL DEFAULT '-1' COMMENT '事件类型（0 WEB页面, 1 内部页面(小程序或APP内部地址), 2 外部小程序(同一个主体下的小程序appid), 3 打开地图, 4 拨打电话）',
  `event_value` char(255) NOT NULL DEFAULT '' COMMENT '事件值',
  `images_url` char(255) NOT NULL DEFAULT '' COMMENT '图片地址',
  `name` char(60) NOT NULL DEFAULT '' COMMENT '别名',
  `is_enable` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否启用（0否，1是）',
  `is_need_login` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否需要登录（0否，1是）',
  `bg_color` char(30) NOT NULL DEFAULT '' COMMENT 'css背景色值',
  `listorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `platform` (`platform`),
  KEY `is_enable` (`is_enable`),
  KEY `sort` (`listorder`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8  COMMENT='手机 - 首页导航';



DROP TABLE IF EXISTS `aijiacms_uid`;
CREATE TABLE `aijiacms_uid` (
  `itemid` bigint(20) unsigned NOT NULL auto_increment,
  PRIMARY KEY  (`itemid`)
) TYPE=MyISAM COMMENT='唯一ID';


DROP TABLE IF EXISTS `aijiacms_keyuan`;
CREATE TABLE `aijiacms_keyuan` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '客源id',
  `gongsiid` int(11) NOT NULL DEFAULT '0' COMMENT '公司',
  `xqbianhao` varchar(255) DEFAULT NULL COMMENT '需求编号',
  `zhuangtai` varchar(50) DEFAULT NULL COMMENT '客户状态',
  `xqyongtu` char(50) DEFAULT NULL COMMENT '需求用途',
  `khxingming` varchar(255) DEFAULT NULL COMMENT '客户姓名',
  `khlaiyuan` varchar(50) DEFAULT NULL COMMENT '客户来源',
  `xqquyu` varchar(255) DEFAULT NULL COMMENT '需求区域',
  `xqxiaoqu` varchar(255) DEFAULT NULL COMMENT '需求小区',
  `xqmianji1` int(11) DEFAULT NULL COMMENT '需求面积1',
  `xqmianji2` int(11) DEFAULT NULL COMMENT '需求面积2',
  `xqjiage1` int(11) DEFAULT NULL COMMENT '需求价格1',
  `xqjiage2` int(11) DEFAULT NULL COMMENT '需求价格2',
  `xqhuxing1` smallint(6) DEFAULT NULL COMMENT '需求户型1',
  `xqhuxing2` smallint(6) DEFAULT NULL COMMENT '需求户型2',
  `gtjieduan` varchar(50) DEFAULT NULL COMMENT '沟通阶段',
  `beizhu` text COMMENT '备注',
  `kydengji` varchar(60) DEFAULT NULL COMMENT '客源等级',
  `qyzhgenjin` varchar(60) DEFAULT NULL COMMENT '全员最后跟进',
  `whrzhgenjin` varchar(60) DEFAULT NULL COMMENT '维护人最后跟进',
  `lururenid` smallint(6) DEFAULT NULL COMMENT '录入人id',
  `weihurenid` int(11) DEFAULT NULL COMMENT '维护人id',
  `weihuren` varchar(255) DEFAULT NULL COMMENT '维护人',
  `louceng1` smallint(6) DEFAULT NULL COMMENT '需求楼层1',
  `louceng2` smallint(6) DEFAULT NULL COMMENT '需求楼层2',
  `fangling1` int(11) DEFAULT NULL COMMENT '需求房龄1',
  `fangling2` int(11) DEFAULT NULL COMMENT '需求房龄2',
  `fukuan` varchar(50) DEFAULT NULL COMMENT '需求付款',
  `peitao` varchar(255) DEFAULT NULL COMMENT '需求配套设施',
  `zhuangxiu` varchar(255) DEFAULT NULL COMMENT '需求装修',
  `chaoxiang` varchar(255) DEFAULT NULL COMMENT '需求朝向',
  `xqyuanyin` text COMMENT '需求原因',
  `dianhua` bigint(20) DEFAULT NULL COMMENT '客户电话',
  `jiqie` varchar(60) DEFAULT NULL COMMENT '是否急切',
  `daikan` varchar(60) DEFAULT NULL COMMENT '是否有带看',
  `fengpan` varchar(60) DEFAULT NULL COMMENT '是否封盘',
  `sfzheng` varchar(60) DEFAULT NULL COMMENT '客户身份证',
  `qqhao` varchar(30) DEFAULT NULL COMMENT '客户QQ号',
  `youxiang` varchar(100) DEFAULT NULL COMMENT '客户邮箱',
  `weixin` varchar(60) DEFAULT NULL COMMENT '客户微信',
  `chexing` varchar(60) DEFAULT NULL COMMENT '客户车型',
  `jtgongju` varchar(60) DEFAULT NULL COMMENT '客户交通工具',
  `kehulx` varchar(60) DEFAULT NULL COMMENT '客户类型',
  `leixing` varchar(100) DEFAULT NULL COMMENT '类型',
  `guoji` varchar(100) DEFAULT NULL COMMENT '客户国籍',
  `minzu` varchar(100) DEFAULT NULL COMMENT '客户民族',
  `xflinian` varchar(100) DEFAULT NULL COMMENT '客户消费理念',
  `mmzl` varchar(100) DEFAULT NULL COMMENT '买卖租赁客户',
  `khnianling` varchar(100) DEFAULT NULL COMMENT '客户年龄',
  `khjiaoyu` varchar(100) DEFAULT NULL COMMENT '客户教育',
  `khaihao` varchar(255) DEFAULT NULL COMMENT '客户爱好',
  `khhunyin` varchar(100) DEFAULT NULL COMMENT '客户婚姻',
  `khshouru` varchar(100) DEFAULT NULL COMMENT '客户收入',
  `khjzquyu` varchar(100) DEFAULT NULL COMMENT '客户居住区域',
  `khjzxiaoqu` varchar(255) DEFAULT NULL COMMENT '客户居住小区',
  `khjzmianji` varchar(100) DEFAULT NULL COMMENT '客户居住面积',
  `khsjpinpai` varchar(100) DEFAULT NULL COMMENT '客户手机品牌',
  `khsjxinghao` varchar(255) DEFAULT NULL COMMENT '客户手机型号',
  `khgzquyu` varchar(100) DEFAULT NULL COMMENT '客户工作区域',
  `khsshangye` varchar(100) DEFAULT NULL COMMENT '客户所属行业',
  `khsfbeizhu` varchar(255) DEFAULT NULL COMMENT '客户身份备注',
  `khzhiwu` varchar(100) DEFAULT NULL COMMENT '客户职务',
  `khjtzcph` varchar(255) DEFAULT NULL COMMENT '客户家庭支出偏好',
  `khjtchengyuan` varchar(255) DEFAULT NULL COMMENT '客户家庭成员',
  `khjqzdsx` varchar(255) DEFAULT NULL COMMENT '客户近期重大事项',
  `khbeizhu` text COMMENT '客户备注',
  `isdel` smallint(2) NOT NULL DEFAULT '2' COMMENT '是否删除',
  `xqysfy` varchar(255) DEFAULT NULL COMMENT '需求一手房源',
  `lurusj` int(11) DEFAULT NULL COMMENT '录入时间',
  `xiugaisj` int(11) DEFAULT NULL COMMENT '最后修改时间',
  `zhgjsj` int(11) NOT NULL COMMENT '最后跟进时间',
  `zhdkshijian` int(11) DEFAULT NULL COMMENT '最后带看时间',
  `fengpanrenid` smallint(6) DEFAULT NULL COMMENT '封盘人id',
  `fpdh` tinyint(1) DEFAULT '2' COMMENT '是否封电话',
  `fpck` tinyint(1) DEFAULT '2' COMMENT '是否封查看',
  `username` varchar(60) DEFAULT NULL COMMENT '经纪人',
  `dkusername` varchar(60) DEFAULT NULL COMMENT '最后跟进',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='客源';


DROP TABLE IF EXISTS `aijiacms_kydaikan`;
CREATE TABLE `aijiacms_kydaikan` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '客源带看id',
  `gongsiid` int(11) DEFAULT NULL COMMENT '公司id',
  `kybh` varchar(100) DEFAULT NULL COMMENT '客源编号',
  `kyid` int(11) DEFAULT NULL COMMENT '客源id',
  `fybh` varchar(255) DEFAULT NULL COMMENT '房源编号',
  `fyid` int(11) DEFAULT NULL COMMENT '房源id',
  `dkuid` int(11) DEFAULT NULL COMMENT '带看人id',
  `peikanid` int(11) DEFAULT NULL COMMENT '陪看人id',
  `kehupj` varchar(255) DEFAULT NULL COMMENT '客户评价',
  `dkshijian` int(11) DEFAULT NULL COMMENT '带看时间',
  `time` int(11) DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='客源带看';


DROP TABLE IF EXISTS `aijiacms_kygenjin`;
CREATE TABLE `aijiacms_kygenjin` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '客源跟进id',
  `gongsiid` int(11) DEFAULT NULL COMMENT '公司id',
  `kybh` varchar(100) DEFAULT NULL COMMENT '客源编号',
  `kyid` int(11) DEFAULT NULL COMMENT '客源id',
  `gjuid` int(11) DEFAULT NULL COMMENT '跟进人id',
  `genjinfs` varchar(60) DEFAULT NULL COMMENT '跟进方式',
  `gjneirong` varchar(255) DEFAULT NULL COMMENT '跟进内容',
  `gjshijian` int(11) DEFAULT NULL COMMENT '跟进时间',
  `zhuangtai` tinyint(1) NOT NULL DEFAULT '1' COMMENT '审核状态',
  `time` int(11) DEFAULT NULL COMMENT '添加时间',
  `gjvoice` varchar(10) DEFAULT NULL COMMENT '跟进语音',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='客源跟进';


DROP TABLE IF EXISTS `aijiacms_kytixing`;
CREATE TABLE `aijiacms_kytixing` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '客源提醒id',
  `gongsiid` int(11) DEFAULT NULL COMMENT '公司id',
  `kybh` varchar(100) DEFAULT NULL COMMENT '客源编号',
  `kyid` int(11) DEFAULT NULL COMMENT '客源id',
  `txuid` int(11) DEFAULT NULL COMMENT '提醒人id',
  `txneirong` varchar(255) DEFAULT NULL COMMENT '提醒内容',
  `txshijian` int(11) DEFAULT NULL COMMENT '提醒时间',
  `adduid` int(11) DEFAULT NULL COMMENT '添加人',
  `time` int(11) DEFAULT NULL COMMENT '添加时间',
  `isyidu` tinyint(1) DEFAULT '0' COMMENT '是否已读',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='客源提醒';

DROP TABLE IF EXISTS `aijiacms_newhouse_yushou`;
CREATE TABLE `aijiacms_newhouse_yushou` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `houseid` int(20) NOT NULL,
  `areaid` smallint(10) DEFAULT NULL,
  `introduce` text NOT NULL,
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `listorder` smallint(4) unsigned NOT NULL DEFAULT '0',
  `catid` int(20) NOT NULL,
  `status` int(20) NOT NULL,
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `edittime` int(20) NOT NULL,
  `title` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `project` varchar(20) NOT NULL,
  `acreage` varchar(20) NOT NULL,
  `residence` varchar(20) NOT NULL,
  `noneresidence` varchar(20) NOT NULL,
  `card_time` int(10) NOT NULL,
  `kfs` varchar(10) NOT NULL,
  `note` varchar(200) NOT NULL,
  PRIMARY KEY (`itemid`),
  KEY `listorder` (`listorder`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='新房预售证';


DROP TABLE IF EXISTS `aijiacms_office_20`;
CREATE TABLE `aijiacms_office_20` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `mycatid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `typeid` smallint(2) unsigned NOT NULL DEFAULT '0',
  `areaid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `elite` tinyint(1) NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `fee` float NOT NULL DEFAULT '0',
  `introduce` varchar(255) NOT NULL DEFAULT '',
  `unit` varchar(10) NOT NULL DEFAULT '',
  `price` int(10) unsigned NOT NULL DEFAULT '0',
  `days` smallint(3) unsigned NOT NULL DEFAULT '0',
  `tag` varchar(100) NOT NULL DEFAULT '',
  `keyword` varchar(255) NOT NULL DEFAULT '',
  `pptword` varchar(255) NOT NULL DEFAULT '',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `thumb1` varchar(255) NOT NULL DEFAULT '',
  `thumb2` varchar(255) NOT NULL DEFAULT '',
  `video` varchar(255) NOT NULL DEFAULT '',
  `thumbs` text NOT NULL,
  `username` varchar(30) NOT NULL DEFAULT '',
  `groupid` smallint(4) unsigned NOT NULL DEFAULT '0',
  `company` varchar(100) NOT NULL DEFAULT '',
  `vip` smallint(2) unsigned NOT NULL DEFAULT '0',
  `validated` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `truename` varchar(30) NOT NULL DEFAULT '',
  `telephone` varchar(50) NOT NULL DEFAULT '',
  `mobile` varchar(50) NOT NULL DEFAULT '',
  `address` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `msn` varchar(50) NOT NULL DEFAULT '',
  `qq` varchar(20) NOT NULL DEFAULT '',
  `ali` varchar(30) NOT NULL DEFAULT '',
  `skype` varchar(30) NOT NULL DEFAULT '',
  `totime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `editdate` date NOT NULL DEFAULT '0000-00-00',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `adddate` date NOT NULL DEFAULT '0000-00-00',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `template` varchar(30) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  `filepath` varchar(255) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  `housename` varchar(50) NOT NULL DEFAULT '',
  `houseid` int(10) NOT NULL,
  `facewidth` float(10,1) NOT NULL,
  `depth` float(10,1) NOT NULL,
  `floorheight` float(10,1) NOT NULL,
  `houseearm` int(19) NOT NULL,
  `floor1` int(10) NOT NULL,
  `floor2` int(10) NOT NULL,
  `fenge` varchar(20) NOT NULL,
  `fitment` varchar(10) NOT NULL,
  `paytype` varchar(10) NOT NULL,
  `map` varchar(100) NOT NULL,
  `wuye` varchar(10) NOT NULL,
  `payinfo` varchar(10) NOT NULL,
  `bus` varchar(50) NOT NULL,
  `freetime` varchar(20) DEFAULT NULL,
  `leasetime` varchar(20) DEFAULT NULL,
  `wuyefei` varchar(20) DEFAULT NULL,
  `zongjia` varchar(20) NOT NULL,
  `istop` smallint(6) DEFAULT '0',
  `ishot` smallint(6) DEFAULT '0',
  `to_time` int(10) NOT NULL DEFAULT '0',
  `hot_time` int(10) DEFAULT '0',
  `shopstate` int(10) DEFAULT NULL,
  `transferfee` varchar(20) DEFAULT NULL,
  `leibie` int(10) DEFAULT NULL,
  `comments` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`itemid`),
  KEY `username` (`username`),
  KEY `editdate` (`editdate`,`vip`,`edittime`),
  KEY `edittime` (`edittime`),
  KEY `catid` (`catid`),
  KEY `mycatid` (`mycatid`),
  KEY `areaid` (`areaid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商铺';


DROP TABLE IF EXISTS `aijiacms_office_data_20`;
CREATE TABLE `aijiacms_office_data_20` (
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` mediumtext NOT NULL,
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='办公内容';


DROP TABLE IF EXISTS `aijiacms_office_search_20`;
CREATE TABLE `aijiacms_office_search_20` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `areaid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `sorttime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`),
  KEY `catid` (`catid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='办公搜索';


DROP TABLE IF EXISTS `aijiacms_shop_19`;
CREATE TABLE `aijiacms_shop_19` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `mycatid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `typeid` smallint(2) unsigned NOT NULL DEFAULT '0',
  `areaid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `elite` tinyint(1) NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `fee` float NOT NULL DEFAULT '0',
  `introduce` varchar(255) NOT NULL DEFAULT '',
  `unit` varchar(10) NOT NULL DEFAULT '',
  `price` varchar(10) NOT NULL DEFAULT '0',
  `days` smallint(3) unsigned NOT NULL DEFAULT '0',
  `tag` varchar(100) NOT NULL DEFAULT '',
  `keyword` varchar(255) NOT NULL DEFAULT '',
  `pptword` varchar(255) NOT NULL DEFAULT '',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `thumb1` varchar(255) NOT NULL DEFAULT '',
  `thumb2` varchar(255) NOT NULL DEFAULT '',
  `video` varchar(255) NOT NULL DEFAULT '',
  `thumbs` text NOT NULL,
  `username` varchar(30) NOT NULL DEFAULT '',
  `groupid` smallint(4) unsigned NOT NULL DEFAULT '0',
  `company` varchar(100) NOT NULL DEFAULT '',
  `vip` smallint(2) unsigned NOT NULL DEFAULT '0',
  `validated` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `truename` varchar(30) NOT NULL DEFAULT '',
  `telephone` varchar(50) NOT NULL DEFAULT '',
  `mobile` varchar(50) NOT NULL DEFAULT '',
  `address` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `msn` varchar(50) NOT NULL DEFAULT '',
  `qq` varchar(20) NOT NULL DEFAULT '',
  `ali` varchar(30) NOT NULL DEFAULT '',
  `skype` varchar(30) NOT NULL DEFAULT '',
  `totime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `editdate` date NOT NULL DEFAULT '0000-00-00',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `adddate` date NOT NULL DEFAULT '0000-00-00',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `template` varchar(30) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  `filepath` varchar(255) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  `housename` varchar(50) NOT NULL DEFAULT '',
  `houseid` int(10) NOT NULL,
  `facewidth` float(10,1) NOT NULL,
  `depth` float(10,1) NOT NULL,
  `floorheight` float(10,1) NOT NULL,
  `houseearm` int(19) NOT NULL,
  `floor1` int(10) NOT NULL,
  `floor2` int(10) NOT NULL,
  `fenge` varchar(20) NOT NULL,
  `fitment` varchar(10) NOT NULL,
  `paytype` varchar(10) NOT NULL,
  `map` varchar(100) NOT NULL,
  `wuye` varchar(10) NOT NULL,
  `payinfo` varchar(10) NOT NULL,
  `bus` varchar(50) NOT NULL,
  `freetime` varchar(20) DEFAULT NULL,
  `leasetime` varchar(20) DEFAULT NULL,
  `wuyefei` varchar(20) DEFAULT NULL,
  `zongjia` varchar(20) NOT NULL,
  `istop` smallint(6) DEFAULT '0',
  `ishot` smallint(6) DEFAULT '0',
  `to_time` int(10) NOT NULL DEFAULT '0',
  `hot_time` int(10) DEFAULT '0',
  `shopstate` int(10) DEFAULT NULL,
  `transferfee` varchar(20) DEFAULT NULL,
  `leibie` int(10) DEFAULT NULL,
  `peitao` varchar(255) NOT NULL,
  `yetai` varchar(255) NOT NULL,
  `fyts` varchar(255) NOT NULL,
  `comments` varchar(200) DEFAULT NULL,
  `zhengti` varchar(255) NOT NULL,
  `shhy` varchar(255) NOT NULL,
  PRIMARY KEY (`itemid`),
  KEY `username` (`username`),
  KEY `editdate` (`editdate`,`vip`,`edittime`),
  KEY `edittime` (`edittime`),
  KEY `catid` (`catid`),
  KEY `mycatid` (`mycatid`),
  KEY `areaid` (`areaid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商铺';


DROP TABLE IF EXISTS `aijiacms_shop_data_19`;
CREATE TABLE `aijiacms_shop_data_19` (
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` mediumtext NOT NULL,
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商铺内容';


DROP TABLE IF EXISTS `aijiacms_shop_search_19`;
CREATE TABLE `aijiacms_shop_search_19` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `areaid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `sorttime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`),
  KEY `catid` (`catid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商铺搜索';





