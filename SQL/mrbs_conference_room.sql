CREATE TABLE IF NOT EXISTS `mrbs_conference_room` (
  `cid` int(11) NOT NULL COMMENT '会议室id',
  `name` varchar(256) NOT NULL COMMENT '会议室名称',
  `position` varchar(256) NOT NULL COMMENT '会议室地点',
  `open` int(2) NOT NULL COMMENT '0：不开放；1：开放',
  `openBeginTime` varchar(32) NOT NULL COMMENT '会议室开放起始时间：0：00，21：30',
  `openEndTime` varchar(32) NOT NULL COMMENT '会议室开放结束时间13：00，24：00',
  `personInCharge` varchar(64) NOT NULL COMMENT '负责人',
  `mobile` varchar(16) NOT NULL COMMENT '负责人联系电话',
  `remark` varchar(256) NOT NULL COMMENT '备注'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mrbs_conference_room`
--
ALTER TABLE `mrbs_conference_room`
  ADD PRIMARY KEY (`cid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mrbs_conference_room`
--
ALTER TABLE `mrbs_conference_room`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT COMMENT '会议室id';


ALTER TABLE `mrbs_conference_room` ADD `images` VARCHAR(256) NOT NULL COMMENT '会议室图片' AFTER `position`;
ALTER TABLE `mrbs_conference_room` ADD `addTime` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '添加会议室时间' AFTER `remark`;
ALTER TABLE `mrbs_conference_room` ADD `capacity` INT(8) NOT NULL COMMENT '可容纳人数' AFTER `position`;
ALTER TABLE `mrbs_conference_room` ADD `status` INT(2) NOT NULL DEFAULT '1' COMMENT '0:已删除 1：正常' AFTER `mobile`;
ALTER TABLE `mrbs_conference_room` ADD `needList` VARCHAR(512) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '会议室设施' AFTER `images`;