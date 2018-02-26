CREATE TABLE `mrbs_booking`
(
`bid` INT(11) NOT NULL COMMENT '预约id' ,
`cid` INT(11) NOT NULL COMMENT '要预约的会议室id' ,
`bookingTime` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '预约下单的时间 2012-09-07 17:32:42' ,
`useDate` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '要使用的日期 2017-09-08' ,
`department` VARCHAR(256) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '预约部门' ,
`applicant` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '申请人' ,
`useBeginTime` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '开始时间 08:00' ,
`useEndTime` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '结束时间 10:00' ,
`weekDay` INT(2) NOT NULL COMMENT '星期 1 2 3 4 5 6 7' , `status` INT(2) NOT NULL COMMENT '预约状态'
) ENGINE = InnoDB;

ALTER TABLE `mrbs_booking` ADD `uid` INT(11) NOT NULL COMMENT '用户id' AFTER `bid`;
ALTER TABLE `mrbs_booking` ADD PRIMARY KEY(`bid`);
ALTER TABLE `mrbs_booking` CHANGE `bid` `bid` INT(11) NOT NULL AUTO_INCREMENT COMMENT '预约id';

ALTER TABLE `mrbs_booking` ADD INDEX(`uid`);
ALTER TABLE `mrbs_booking` ADD INDEX(`cid`);

ALTER TABLE `mrbs_booking` ADD `lastEditTime` VARCHAR(64) NOT NULL COMMENT '最后一次用户编辑时间' AFTER `bookingTime`;
ALTER TABLE `mrbs_booking` ADD `checkTime` VARCHAR(32) NOT NULL COMMENT '审核通过时间/审核驳回时间' AFTER `status`;
ALTER TABLE `mrbs_booking` ADD `introduction` VARCHAR(512) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '会议介绍' AFTER `status`;
ALTER TABLE `mrbs_booking` ADD `applicantMobile` VARCHAR(15) NOT NULL COMMENT '申请人联系方式' AFTER `applicant`;
ALTER TABLE `mrbs_booking` ADD `need` VARCHAR(256)  NOT NULL COMMENT '其他需要' AFTER `status`;
ALTER TABLE `mrbs_booking` ADD `specialNeed` VARCHAR(256) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `need`;
ALTER TABLE `mrbs_booking` ADD `checkUid` INT(11) NOT NULL COMMENT '操作管理员的id' AFTER `checkTime`;
ALTER TABLE `mrbs_booking` ADD `number` INT(5) NOT NULL COMMENT '参会人数' AFTER `applicant`;
ALTER TABLE `mrbs_booking` ADD `meetingName` VARCHAR(256) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `cid`;
