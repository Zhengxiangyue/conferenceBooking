CREATE TABLE `mrbs_users`
(
	`uid` int(11) unsigned NOT NULL auto_increment COMMENT "用户ID",

	`mobile` varchar(16) DEFAULT NULL COMMENT '用户手机',

	`user_name` varchar(255) DEFAULT NULL COMMENT '用户名',

	`department` varchar(255) DEFAULT NULL COMMENT '用户部门',

	`type`  tinyint DEFAULT 2 COMMENT  "用户类型，1为管理员，2为普通用户",

	`password` varchar(32) DEFAULT NULL COMMENT '用户密码',

	`salt` varchar(16) DEFAULT NULL COMMENT '用户附加混淆码',

	`reg_time` int(10) DEFAULT NULL COMMENT '注册时间',

	PRIMARY KEY (`uid`),

	UNIQUE  KEY `mobile` (`mobile`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;