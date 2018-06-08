/*
Navicat MySQL Data Transfer

Source Server         : hospital
Source Server Version : 50714
Source Host           : localhost:3306
Source Database       : healthcheckup

Target Server Type    : MYSQL
Target Server Version : 50714
File Encoding         : 65001

Date: 2018-06-08 20:27:28
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for hc_admin
-- ----------------------------
DROP TABLE IF EXISTS `hc_admin`;
CREATE TABLE `hc_admin` (
  `id` smallint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT '后台管理人员',
  `login_name` varchar(64) NOT NULL,
  `login_pwd` char(32) NOT NULL COMMENT '管理员登录密码',
  `salt` char(4) NOT NULL COMMENT '密码加盐',
  `admin_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '管理员账号状态（1正常0冻结）',
  `admin_phone` char(11) NOT NULL COMMENT '管理员手机号',
  `admin_name` varchar(64) NOT NULL COMMENT '用户名称',
  `admin_email` varchar(64) DEFAULT NULL,
  `creat_time` int(11) DEFAULT NULL COMMENT '账户创建时间',
  `login_time` int(11) DEFAULT NULL COMMENT '登陆时间',
  `last_login_time` int(11) DEFAULT NULL COMMENT '上一次登录时间',
  `admin_portrait` varchar(100) DEFAULT NULL COMMENT '管理员头像',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hc_admin
-- ----------------------------
INSERT INTO `hc_admin` VALUES ('1', 'hcadmin', '25f9e794323b453885f5181f1b624d0b', '789', '1', '15801379183', '汪娜娜', '123@qq.com', '1526559130', '1528443290', '1526559130', '/static/assets/avatars/user.jpg');

-- ----------------------------
-- Table structure for hc_company
-- ----------------------------
DROP TABLE IF EXISTS `hc_company`;
CREATE TABLE `hc_company` (
  `company_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '单位/团体/公司id',
  `company_name` varchar(50) NOT NULL COMMENT '公司名称',
  `company_addr` varchar(50) NOT NULL,
  `company_connect` varchar(15) NOT NULL COMMENT '联系方式',
  `create_time` int(11) NOT NULL COMMENT '第一次添加时间',
  PRIMARY KEY (`company_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hc_company
-- ----------------------------

-- ----------------------------
-- Table structure for hc_migrations
-- ----------------------------
DROP TABLE IF EXISTS `hc_migrations`;
CREATE TABLE `hc_migrations` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `end_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `breakpoint` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hc_migrations
-- ----------------------------
INSERT INTO `hc_migrations` VALUES ('20170822041240', 'Rbac', '2018-05-28 16:40:11', '2018-05-28 16:40:11', '0');

-- ----------------------------
-- Table structure for hc_permission
-- ----------------------------
DROP TABLE IF EXISTS `hc_permission`;
CREATE TABLE `hc_permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '权限名称',
  `path` varchar(100) NOT NULL DEFAULT '' COMMENT '权限路径',
  `description` varchar(200) NOT NULL DEFAULT '' COMMENT '权限描述',
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '权限状态',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='权限表';

-- ----------------------------
-- Records of hc_permission
-- ----------------------------

-- ----------------------------
-- Table structure for hc_role
-- ----------------------------
DROP TABLE IF EXISTS `hc_role`;
CREATE TABLE `hc_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '角色名称',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '父角色id',
  `description` varchar(200) NOT NULL DEFAULT '' COMMENT '描述信息',
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '角色状态',
  `sort_num` int(11) NOT NULL DEFAULT '0' COMMENT '排序值',
  `left_key` int(11) NOT NULL DEFAULT '0' COMMENT '用来组织关系的左值',
  `right_key` int(11) NOT NULL DEFAULT '0' COMMENT '用来组织关系的右值',
  `level` int(11) NOT NULL DEFAULT '0' COMMENT '所处层级',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='角色';

-- ----------------------------
-- Records of hc_role
-- ----------------------------
INSERT INTO `hc_role` VALUES ('3', '超级管理员', '0', '可以操作系统任何操作', '1', '1', '5', '6', '1');
INSERT INTO `hc_role` VALUES ('4', '体检医护', '0', '体检过程中记录体检信息', '1', '2', '1', '4', '1');
INSERT INTO `hc_role` VALUES ('5', '外科医护', '4', '外科体检 医护', '1', '1', '2', '3', '2');

-- ----------------------------
-- Table structure for hc_role_permission
-- ----------------------------
DROP TABLE IF EXISTS `hc_role_permission`;
CREATE TABLE `hc_role_permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL DEFAULT '0' COMMENT '角色Id',
  `permission_id` int(11) NOT NULL DEFAULT '0' COMMENT '权限ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色权限对应表';

-- ----------------------------
-- Records of hc_role_permission
-- ----------------------------

-- ----------------------------
-- Table structure for hc_user
-- ----------------------------
DROP TABLE IF EXISTS `hc_user`;
CREATE TABLE `hc_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) NOT NULL DEFAULT '' COMMENT '用户账号',
  `password` varchar(64) NOT NULL DEFAULT '' COMMENT '用户密码',
  `mobile` varchar(20) NOT NULL DEFAULT '' COMMENT '手机号码',
  `email` varchar(50) NOT NULL DEFAULT '' COMMENT '邮箱',
  `last_login_time` int(11) NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '用户状态',
  `salt` tinyint(4) unsigned NOT NULL COMMENT '密码加盐',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of hc_user
-- ----------------------------

-- ----------------------------
-- Table structure for hc_user111
-- ----------------------------
DROP TABLE IF EXISTS `hc_user111`;
CREATE TABLE `hc_user111` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `user_name` varchar(45) NOT NULL COMMENT '用户姓名',
  `user_idcard` char(18) NOT NULL COMMENT '用户身份证号',
  `user_sex` tinyint(3) unsigned NOT NULL COMMENT '性别：1：女；2：男',
  `user_age` tinyint(3) unsigned NOT NULL COMMENT '年龄',
  `user_birthday` int(10) unsigned DEFAULT NULL,
  `user_phone` char(11) DEFAULT NULL COMMENT '用户手机号',
  `nation_id` tinyint(3) unsigned DEFAULT NULL COMMENT '民族id',
  `is_marry` tinyint(3) unsigned DEFAULT NULL COMMENT '是否结婚：0：未婚 1：已婚',
  `profession_id` tinyint(3) unsigned DEFAULT NULL COMMENT '职业id',
  `create_time` int(10) unsigned NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hc_user111
-- ----------------------------

-- ----------------------------
-- Table structure for hc_user_role
-- ----------------------------
DROP TABLE IF EXISTS `hc_user_role`;
CREATE TABLE `hc_user_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `role_id` int(11) NOT NULL DEFAULT '0' COMMENT '角色id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户角色对应关系';

-- ----------------------------
-- Records of hc_user_role
-- ----------------------------
