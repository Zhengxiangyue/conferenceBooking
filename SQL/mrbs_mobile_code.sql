CREATE TABLE IF NOT EXISTS `mrbs_mobile_code` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `mobile` varchar(11) NOT NULL COMMENT '手机号',
  `code` varchar(6) NOT NULL COMMENT '最新一次的验证码',
  `send_time` int(10) NOT NULL COMMENT '最新一次发送验证码的时间戳',
  PRIMARY KEY (`id`),
  UNIQUE KEY `mobile` (`mobile`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;