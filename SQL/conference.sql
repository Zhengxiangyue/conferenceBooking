-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 23, 2017 at 07:53 AM
-- Server version: 5.7.10
-- PHP Version: 5.5.37


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `conference`
--

-- --------------------------------------------------------

--
-- Table structure for table `mrbs_booking`
--

CREATE TABLE IF NOT EXISTS `mrbs_booking` (
  `bid` int(11) NOT NULL COMMENT '预约id',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `cid` int(11) NOT NULL COMMENT '要预约的会议室id',
  `bookingTime` varchar(32) NOT NULL COMMENT '预约下单的时间 2012-09-07 17:32:42',
  `lastEditTime` varchar(64) NOT NULL COMMENT '最后一次用户编辑时间',
  `useDate` varchar(32) NOT NULL COMMENT '要使用的日期 2017-09-08',
  `department` varchar(256) NOT NULL COMMENT '预约部门',
  `applicant` varchar(64) NOT NULL COMMENT '申请人',
  `applicantMobile` varchar(15) NOT NULL COMMENT '申请人联系方式',
  `useBeginTime` varchar(32) NOT NULL COMMENT '开始时间 08:00',
  `useEndTime` varchar(32) NOT NULL COMMENT '结束时间 10:00',
  `weekDay` int(2) NOT NULL COMMENT '星期 1 2 3 4 5 6 7',
  `status` int(2) NOT NULL COMMENT '预约状态',
  `need` varchar(256) NOT NULL COMMENT '其他需要',
  `specialNeed` varchar(256) NOT NULL,
  `introduction` varchar(512) NOT NULL COMMENT '会议介绍',
  `checkTime` varchar(32) NOT NULL COMMENT '审核通过时间/审核驳回时间',
  `checkUid` int(11) NOT NULL COMMENT '操作管理员的id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mrbs_conference_room`
--

CREATE TABLE IF NOT EXISTS `mrbs_conference_room` (
  `cid` int(11) NOT NULL COMMENT '会议室id',
  `name` varchar(256) NOT NULL COMMENT '会议室名称',
  `position` varchar(256) NOT NULL COMMENT '会议室地点',
  `capacity` int(8) NOT NULL COMMENT '可容纳人数',
  `images` varchar(256) NOT NULL COMMENT '会议室图片',
  `open` int(2) NOT NULL COMMENT '0：不开放；1：开放',
  `openBeginTime` varchar(32) NOT NULL COMMENT '会议室开放起始时间：0：00，21：30',
  `openEndTime` varchar(32) NOT NULL COMMENT '会议室开放结束时间13：00，24：00',
  `personInCharge` varchar(64) NOT NULL COMMENT '负责人',
  `mobile` varchar(16) NOT NULL COMMENT '负责人联系电话',
  `status` int(2) NOT NULL DEFAULT '1' COMMENT '0:已删除 1：正常',
  `remark` varchar(256) NOT NULL COMMENT '备注',
  `addTime` varchar(32) NOT NULL COMMENT '添加会议室时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mrbs_mobile_code`
--

CREATE TABLE IF NOT EXISTS `mrbs_mobile_code` (
  `id` int(11) NOT NULL COMMENT '自增id',
  `mobile` varchar(11) NOT NULL COMMENT '手机号',
  `code` varchar(6) NOT NULL COMMENT '最新一次的验证码',
  `send_time` int(10) NOT NULL COMMENT '最新一次发送验证码的时间戳'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mrbs_users`
--

CREATE TABLE IF NOT EXISTS `mrbs_users` (
  `uid` int(11) unsigned NOT NULL COMMENT '用户ID',
  `mobile` varchar(16) DEFAULT NULL COMMENT '用户手机',
  `user_name` varchar(255) DEFAULT NULL COMMENT '用户名',
  `department` varchar(255) DEFAULT NULL COMMENT '用户部门',
  `type` tinyint(4) DEFAULT '2' COMMENT '用户类型，1为管理员，2为普通用户',
  `password` varchar(32) DEFAULT NULL COMMENT '用户密码',
  `salt` varchar(16) DEFAULT NULL COMMENT '用户附加混淆码',
  `reg_time` int(10) DEFAULT NULL COMMENT '注册时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mrbs_booking`
--
ALTER TABLE `mrbs_booking`
  ADD PRIMARY KEY (`bid`),
  ADD KEY `uid` (`uid`),
  ADD KEY `cid` (`cid`);

--
-- Indexes for table `mrbs_conference_room`
--
ALTER TABLE `mrbs_conference_room`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `mrbs_mobile_code`
--
ALTER TABLE `mrbs_mobile_code`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mobile` (`mobile`);

--
-- Indexes for table `mrbs_users`
--
ALTER TABLE `mrbs_users`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `mobile` (`mobile`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mrbs_booking`
--
ALTER TABLE `mrbs_booking`
  MODIFY `bid` int(11) NOT NULL AUTO_INCREMENT COMMENT '预约id';
--
-- AUTO_INCREMENT for table `mrbs_conference_room`
--
ALTER TABLE `mrbs_conference_room`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT COMMENT '会议室id';
--
-- AUTO_INCREMENT for table `mrbs_mobile_code`
--
ALTER TABLE `mrbs_mobile_code`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id';
--
-- AUTO_INCREMENT for table `mrbs_users`
--
ALTER TABLE `mrbs_users`
  MODIFY `uid` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID';

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
