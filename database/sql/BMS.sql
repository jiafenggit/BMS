/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : dwy_wechat_store

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2017-02-10 14:58:54
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for admins
-- ----------------------------
DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_email_unique` (`email`),
  UNIQUE KEY `admins_mobile_unique` (`mobile`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of admins
-- ----------------------------
INSERT INTO `admins` VALUES ('1', 'mc', '510037291@qq.com', '$2y$10$g/7zTcsc9DJ2C02ESNLraeL0J4niXdx1H.KWMUsLbEUlyP5b/CnFe', '18868195360', 'RfPLDKnGF3oMyi47MQGrIyJ16dxvraRjsCQ0nW3riI7BoSVjMQD6j0fvCrOG', '2017-02-09 17:35:04', '2017-02-10 02:40:17');

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES ('2014_10_12_000000_create_users_table', '1');
INSERT INTO `migrations` VALUES ('2014_10_12_100000_create_password_resets_table', '1');
INSERT INTO `migrations` VALUES ('2017_02_09_092228_entrust_setup_tables', '2');
INSERT INTO `migrations` VALUES ('2017_02_09_092647_create_admins_table', '3');

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pid` int(10) unsigned NOT NULL,
  `type` tinyint(3) unsigned NOT NULL,
  `rank` int(10) unsigned NOT NULL,
  `is_show` tinyint(1) NOT NULL DEFAULT '1',
  `is_blank` tinyint(1) NOT NULL DEFAULT '0' COMMENT '新窗口打开',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES ('1', 'admin.index', '首页', '/index', '后台首页', 'fa-home', '0', '1', '1', '1', '0', '2016-07-11 00:00:00', '2016-07-12 13:47:16');
INSERT INTO `permissions` VALUES ('2', 'admin.rbac', '权限管理', '', 'rbac权限', 'fa-users', '0', '1', '1000', '1', '0', '2016-07-11 00:00:00', '2016-07-13 09:15:55');
INSERT INTO `permissions` VALUES ('3', 'admin.admins', '管理员', '/admins', 'rbac权限 管理员列表', '', '2', '1', '50', '1', '0', '2016-07-11 00:00:00', '2016-07-11 00:00:00');
INSERT INTO `permissions` VALUES ('4', 'admin.role', '角色', '/role', 'rbac权限 角色列表', '', '2', '1', '100', '1', '0', '2016-07-11 00:00:00', '2016-07-11 00:00:00');
INSERT INTO `permissions` VALUES ('5', 'admin.permission', '权限', '/permission', 'rbac权限 权限列表', '', '2', '1', '200', '1', '0', '2016-07-11 00:00:00', '2016-07-11 00:00:00');
INSERT INTO `permissions` VALUES ('6', 'admin.create', '添加管理员', '', null, '', '3', '0', '50', '0', '0', '2016-07-12 14:03:19', '2016-07-12 14:03:19');
INSERT INTO `permissions` VALUES ('7', 'admin.edit', '编辑管理员', '', null, '', '3', '0', '60', '0', '0', '2016-07-12 14:24:36', '2016-07-12 14:24:36');
INSERT INTO `permissions` VALUES ('8', 'admin.destroy', '删除管理员', '', null, '', '3', '0', '70', '10', '0', '2016-07-12 14:25:03', '2016-07-12 14:25:03');
INSERT INTO `permissions` VALUES ('9', 'role.create', '添加角色', '', null, '', '4', '0', '50', '0', '0', '2016-07-12 14:27:57', '2016-07-12 14:27:57');
INSERT INTO `permissions` VALUES ('10', 'role.edit', '编辑角色', '', null, '', '4', '0', '60', '0', '0', '2016-07-12 14:28:16', '2016-07-12 14:28:16');
INSERT INTO `permissions` VALUES ('11', 'role.destroy', '删除角色', '', null, '', '4', '0', '70', '0', '0', '2016-07-12 14:28:38', '2016-07-12 14:28:38');
INSERT INTO `permissions` VALUES ('12', 'perm.create', '添加权限', '', null, '', '5', '0', '50', '0', '0', '2016-07-12 14:29:02', '2016-07-12 14:29:02');
INSERT INTO `permissions` VALUES ('13', 'perm.edit', '编辑权限', '', null, '', '5', '0', '60', '0', '0', '2016-07-12 14:29:22', '2016-07-12 14:29:22');
INSERT INTO `permissions` VALUES ('14', 'perm.destroy', '删除权限', '', null, '', '5', '0', '70', '0', '0', '2016-07-12 14:30:50', '2016-07-12 14:30:50');

-- ----------------------------
-- Table structure for permission_role
-- ----------------------------
DROP TABLE IF EXISTS `permission_role`;
CREATE TABLE `permission_role` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of permission_role
-- ----------------------------
INSERT INTO `permission_role` VALUES ('1', '1');
INSERT INTO `permission_role` VALUES ('1', '2');
INSERT INTO `permission_role` VALUES ('2', '1');
INSERT INTO `permission_role` VALUES ('2', '2');
INSERT INTO `permission_role` VALUES ('3', '1');
INSERT INTO `permission_role` VALUES ('3', '2');
INSERT INTO `permission_role` VALUES ('4', '1');
INSERT INTO `permission_role` VALUES ('5', '1');
INSERT INTO `permission_role` VALUES ('6', '1');
INSERT INTO `permission_role` VALUES ('6', '2');
INSERT INTO `permission_role` VALUES ('7', '1');
INSERT INTO `permission_role` VALUES ('7', '2');
INSERT INTO `permission_role` VALUES ('8', '1');
INSERT INTO `permission_role` VALUES ('8', '2');
INSERT INTO `permission_role` VALUES ('9', '1');
INSERT INTO `permission_role` VALUES ('10', '1');
INSERT INTO `permission_role` VALUES ('11', '1');
INSERT INTO `permission_role` VALUES ('12', '1');
INSERT INTO `permission_role` VALUES ('13', '1');
INSERT INTO `permission_role` VALUES ('14', '1');

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES ('1', 'admin', '超级管理员', '拥有网站所有权限', '2016-07-11 00:00:00', '2016-07-11 00:00:00');
INSERT INTO `roles` VALUES ('2', 'common_admin', '普通管理员', '拥有网站部分权限', '2016-07-11 00:00:00', '2016-07-11 00:00:00');

-- ----------------------------
-- Table structure for role_user
-- ----------------------------
DROP TABLE IF EXISTS `role_user`;
CREATE TABLE `role_user` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of role_user
-- ----------------------------
INSERT INTO `role_user` VALUES ('1', '1');
INSERT INTO `role_user` VALUES ('3', '2');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
