/*
 Navicat Premium Data Transfer

 Source Server         : 127.0.0.1
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : localhost:3306
 Source Schema         : dujiao

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 11/01/2024 14:12:22
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for admin_menu
-- ----------------------------
DROP TABLE IF EXISTS `admin_menu`;
CREATE TABLE `admin_menu`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(20) NOT NULL DEFAULT 0,
  `order` int(11) NOT NULL DEFAULT 0,
  `title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `uri` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `extension` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `show` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 32 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin_menu
-- ----------------------------
INSERT INTO `admin_menu` VALUES (1, 0, 1, 'Index', 'feather icon-bar-chart-2', '/', '', 1, '2021-05-16 18:06:08', NULL);
INSERT INTO `admin_menu` VALUES (2, 0, 2, 'Admin', 'feather icon-settings', '', '', 1, '2021-05-16 18:06:08', NULL);
INSERT INTO `admin_menu` VALUES (3, 2, 3, 'Users', '', 'auth/users', '', 1, '2021-05-16 18:06:08', NULL);
INSERT INTO `admin_menu` VALUES (4, 2, 4, 'Roles', '', 'auth/roles', '', 1, '2021-05-16 18:06:08', NULL);
INSERT INTO `admin_menu` VALUES (5, 2, 5, 'Permission', '', 'auth/permissions', '', 1, '2021-05-16 18:06:08', NULL);
INSERT INTO `admin_menu` VALUES (6, 2, 6, 'Menu', '', 'auth/menu', '', 1, '2021-05-16 18:06:08', NULL);
INSERT INTO `admin_menu` VALUES (7, 2, 7, 'Extensions', '', 'auth/extensions', '', 1, '2021-05-16 18:06:08', NULL);
INSERT INTO `admin_menu` VALUES (11, 0, 9, 'Goods_Manage', 'fa-shopping-bag', NULL, '', 1, '2021-05-17 03:39:55', '2021-05-24 12:44:20');
INSERT INTO `admin_menu` VALUES (12, 11, 11, 'Goods', 'fa-shopping-bag', '/goods', '', 1, '2021-05-17 03:44:35', '2021-05-24 12:44:20');
INSERT INTO `admin_menu` VALUES (13, 11, 10, 'Goods_Group', 'fa-star-half-o', '/goods-group', '', 1, '2021-05-17 09:08:43', '2021-05-24 12:44:20');
INSERT INTO `admin_menu` VALUES (14, 0, 12, 'Carmis_Manage', 'fa-credit-card-alt', NULL, '', 1, '2021-05-18 13:29:50', '2021-05-24 12:44:20');
INSERT INTO `admin_menu` VALUES (15, 14, 13, 'Carmis', 'fa-credit-card', '/carmis', '', 1, '2021-05-18 13:37:59', '2021-05-24 12:44:20');
INSERT INTO `admin_menu` VALUES (16, 14, 14, 'Import_Carmis', 'fa-plus-circle', '/import-carmis', '', 1, '2021-05-19 06:46:35', '2021-05-24 12:44:20');
INSERT INTO `admin_menu` VALUES (17, 18, 16, 'Coupon', 'fa-dollar', '/coupon', '', 1, '2021-05-19 09:29:53', '2021-05-24 12:44:20');
INSERT INTO `admin_menu` VALUES (18, 0, 15, 'Coupon_Manage', 'fa-diamond', NULL, '', 1, '2021-05-19 09:32:03', '2021-05-19 09:32:03');
INSERT INTO `admin_menu` VALUES (19, 0, 17, 'Configuration', 'fa-wrench', NULL, '', 1, '2021-05-21 12:06:47', '2021-05-24 12:44:20');
INSERT INTO `admin_menu` VALUES (20, 19, 18, 'Email_Template_Configuration', 'fa-envelope', '/emailtpl', '', 1, '2021-05-21 12:17:07', '2021-05-24 12:44:20');
INSERT INTO `admin_menu` VALUES (21, 19, 19, 'Pay_Configuration', 'fa-cc-visa', '/pay', '', 1, '2021-05-21 12:41:24', '2021-05-24 12:44:20');
INSERT INTO `admin_menu` VALUES (22, 0, 8, 'Order_Manage', 'fa-table', NULL, '', 1, '2021-05-24 12:43:43', '2021-05-24 12:44:20');
INSERT INTO `admin_menu` VALUES (23, 22, 20, 'Order', 'fa-heart', '/order', '', 1, '2021-05-24 12:46:13', '2021-05-24 12:47:16');
INSERT INTO `admin_menu` VALUES (24, 19, 21, 'System_Setting', 'fa-cogs', '/system-setting', '', 1, '2021-05-27 02:26:34', '2021-05-27 02:26:34');
INSERT INTO `admin_menu` VALUES (25, 19, 22, 'Email_Test', 'fa-envelope', '/email-test', '', 1, '2022-07-27 04:09:34', '2022-07-27 04:17:21');
INSERT INTO `admin_menu` VALUES (26, 0, 23, '按钮设置', 'fa-envelope', '/button', '', 1, '2023-11-24 05:03:24', '2023-11-24 05:03:56');
INSERT INTO `admin_menu` VALUES (27, 0, 24, '充值订单', 'fa-bank', '/recharge', '', 1, '2023-11-24 05:04:39', '2023-11-24 05:04:39');
INSERT INTO `admin_menu` VALUES (28, 0, 25, '消息管理', 'fa-arrow-circle-o-down', '/message', '', 1, '2023-11-24 05:05:24', '2023-11-24 05:05:24');
INSERT INTO `admin_menu` VALUES (29, 0, 26, '用户列表', 'fa-male', '/users', '', 1, '2023-11-25 23:43:04', '2023-11-25 23:43:04');
INSERT INTO `admin_menu` VALUES (31, 0, 28, '会员充值列表', NULL, 'prime', '', 1, '2023-12-29 23:33:57', '2023-12-29 23:33:57');

-- ----------------------------
-- Table structure for admin_permission_menu
-- ----------------------------
DROP TABLE IF EXISTS `admin_permission_menu`;
CREATE TABLE `admin_permission_menu`  (
  `permission_id` bigint(20) NOT NULL,
  `menu_id` bigint(20) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  UNIQUE INDEX `admin_permission_menu_permission_id_menu_id_unique`(`permission_id`, `menu_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for admin_permissions
-- ----------------------------
DROP TABLE IF EXISTS `admin_permissions`;
CREATE TABLE `admin_permissions`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `http_method` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `http_path` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `parent_id` bigint(20) NOT NULL DEFAULT 0,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `admin_permissions_slug_unique`(`slug`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin_permissions
-- ----------------------------
INSERT INTO `admin_permissions` VALUES (1, 'Auth management', 'auth-management', '', '', 1, 0, '2021-05-16 10:06:08', NULL);
INSERT INTO `admin_permissions` VALUES (2, 'Users', 'users', '', '/auth/users*', 2, 1, '2021-05-16 10:06:08', NULL);
INSERT INTO `admin_permissions` VALUES (3, 'Roles', 'roles', '', '/auth/roles*', 3, 1, '2021-05-16 10:06:08', NULL);
INSERT INTO `admin_permissions` VALUES (4, 'Permissions', 'permissions', '', '/auth/permissions*', 4, 1, '2021-05-16 10:06:08', NULL);
INSERT INTO `admin_permissions` VALUES (5, 'Menu', 'menu', '', '/auth/menu*', 5, 1, '2021-05-16 10:06:08', NULL);
INSERT INTO `admin_permissions` VALUES (6, 'Extension', 'extension', '', '/auth/extensions*', 6, 1, '2021-05-16 10:06:08', NULL);

-- ----------------------------
-- Table structure for admin_role_menu
-- ----------------------------
DROP TABLE IF EXISTS `admin_role_menu`;
CREATE TABLE `admin_role_menu`  (
  `role_id` bigint(20) NOT NULL,
  `menu_id` bigint(20) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  UNIQUE INDEX `admin_role_menu_role_id_menu_id_unique`(`role_id`, `menu_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for admin_role_permissions
-- ----------------------------
DROP TABLE IF EXISTS `admin_role_permissions`;
CREATE TABLE `admin_role_permissions`  (
  `role_id` bigint(20) NOT NULL,
  `permission_id` bigint(20) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  UNIQUE INDEX `admin_role_permissions_role_id_permission_id_unique`(`role_id`, `permission_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for admin_role_users
-- ----------------------------
DROP TABLE IF EXISTS `admin_role_users`;
CREATE TABLE `admin_role_users`  (
  `role_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  UNIQUE INDEX `admin_role_users_role_id_user_id_unique`(`role_id`, `user_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin_role_users
-- ----------------------------
INSERT INTO `admin_role_users` VALUES (1, 1, '2021-05-16 10:06:08', '2021-05-16 10:06:08');

-- ----------------------------
-- Table structure for admin_roles
-- ----------------------------
DROP TABLE IF EXISTS `admin_roles`;
CREATE TABLE `admin_roles`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `admin_roles_slug_unique`(`slug`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin_roles
-- ----------------------------
INSERT INTO `admin_roles` VALUES (1, 'Administrator', 'administrator', '2021-05-16 10:06:08', '2021-05-16 10:06:08');

-- ----------------------------
-- Table structure for admin_settings
-- ----------------------------
DROP TABLE IF EXISTS `admin_settings`;
CREATE TABLE `admin_settings`  (
  `slug` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`slug`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for admin_users
-- ----------------------------
DROP TABLE IF EXISTS `admin_users`;
CREATE TABLE `admin_users`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `admin_users_username_unique`(`username`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin_users
-- ----------------------------
INSERT INTO `admin_users` VALUES (1, 'admin', '$2y$10$e7z99Mhxm9BOHL55xHZTx.QcNTZJC6ftRXHCR/ZkBja/jBeasVeBy', 'Administrator', NULL, '4UAXF2BEw9EL1Tr2aGmwkv5DKwxqRF6djOMAHSiBMSOrPfPNHYrjCCQMtnTC', '2021-05-16 10:06:08', '2021-05-16 10:06:08');

-- ----------------------------
-- Table structure for buttons
-- ----------------------------
DROP TABLE IF EXISTS `buttons`;
CREATE TABLE `buttons`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tips` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '注释',
  `keyword` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '关键词',
  `func` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '功能',
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '回复内容',
  `parse` enum('HTML','MarkDown') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'HTML' COMMENT '模式:HTML=HTML,MarkDown=MarkDown',
  `disable` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '链接预览:0=关闭,1=开启',
  `button` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '按钮组',
  `addtime` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 20 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '按钮列表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of buttons
-- ----------------------------
INSERT INTO `buttons` VALUES (1, '这是开始按钮', 'start', NULL, '购买系统请联系客服:@buzhiguiqi充值请发送/chongzhi 金额,比如100U就发送/chongzhi 100', 'HTML', '0', '[[\"💸我要充值\",\"☎️联系客服\"],[\"🛒商品列表\"],[\"👤个人中心\",\"📨订单列表\"],[\"自助开通会员\"]]', '12345');
INSERT INTO `buttons` VALUES (2, '这是商品列表', '🛒商品列表', 'shoplist', '这是商品列表', 'HTML', '0', NULL, '12345');
INSERT INTO `buttons` VALUES (3, '这是商品列表', 'class', 'class', '这是商品列表哦', 'HTML', '0', '11', '11');
INSERT INTO `buttons` VALUES (4, '这是商品分类列表', 'classlist', 'classlist', '这是商品分类列表', 'HTML', '0', 'asd', '12323');
INSERT INTO `buttons` VALUES (5, '这是商品详细信息', 'shopinfo', 'shopinfo', '商品名:{name}\r\n购买数量:{number}\r\n当前库存:{carmis_count}\r\n单价:{money} USDT\r\n商品描述:{description}', 'HTML', '0', '1', '1');
INSERT INTO `buttons` VALUES (6, '确认订单信息', 'confirmorder', 'confirmorder', '订单号:{orderno}\n商品名:{title}\n商品单价:{goods_price} USDT\n购买数量:{buy_amount}\n总付金额:{total_price} USDT\n购买者ID:{uid}\n付款方式:{pay_name}\n创建时间:{created_at}', 'HTML', '0', '1', '1');
INSERT INTO `buttons` VALUES (7, '付款页面', 'gopay', 'gopay', '此订单10分钟内有效，过期后请重新生成订单。\n➖➖➖➖➖➖➖➖➖➖\n订单号:{orderno}\n转账地址:`{token}`(TRC-20网络)\n转账金额:  {money} USDT  {amount} RMB\n➖➖➖➖➖➖➖➖➖➖\n请注意转账金额务必与上方的转账金额一致，否则无法自动到账\n支付完成后, 请等待1分钟左右查询，自动到账。', 'MarkDown', '0', '1', '1');
INSERT INTO `buttons` VALUES (8, '这是联系客服页面', '☎️联系客服', NULL, '本机器人所出售的所有源码如有授权的全部在下方授权链接\n\n授权生成地址:https://caonima.hyperindex.tk/\n\n搭建教程：https://www.oo-uu.cc\n\n联系客服:@buzhiguiqi', 'HTML', '0', '1', '123');
INSERT INTO `buttons` VALUES (9, '这是我要充值页面', '💸我要充值', '', '这是我要充值页面', 'HTML', '0', '[[{\"text\":\"1USDT\",\"callback_data\":\"pay_1\"},{\"text\":\"2USDT\",\"callback_data\":\"pay_2\"}]]', '123');
INSERT INTO `buttons` VALUES (10, '这是个人中心', '👤个人中心', NULL, 'UID:`{uid}`\n用户名:@{username}\n昵称:{nick}\n余额:{money} USDT\n积分:{points}\n添加时间:{addtime}', 'MarkDown', '0', '[[{\"text\":\"充值订单\",\"callback_data\":\"chongzhilist\"}]]', '123');
INSERT INTO `buttons` VALUES (11, '订单列表', '📨订单列表', 'orderlist', '订单列表', 'HTML', '0', '1', '123');
INSERT INTO `buttons` VALUES (12, '这是余额充值', 'pay', 'pay', '此订单10分钟内有效，过期后请重新生成订单。\n➖➖➖➖➖➖➖➖➖➖\n订单号:{orderno}\n转账地址:`{token}`(TRC-20网络)\n转账金额:  {money} USDT  {amount} RMB\n➖➖➖➖➖➖➖➖➖➖\n请注意转账金额务必与上方的转账金额一致，否则无法自动到账\n支付完成后, 请等待1分钟左右查询，自动到账。', 'MarkDown', '0', '12', '12');
INSERT INTO `buttons` VALUES (13, '充值列表', 'chongzhilist', 'chongzhilist', '充值列表里面只展示付款成功的5条订单', 'HTML', '0', '1', '123');
INSERT INTO `buttons` VALUES (14, '补货', 'getkami', 'getkami', '1', 'HTML', '0', '1', '11');
INSERT INTO `buttons` VALUES (15, '取消订单', 'clean', 'clean', '取消订单', 'HTML', '0', '1', '11');
INSERT INTO `buttons` VALUES (16, '自定义购买数量', 'number', 'number', '1', 'HTML', '0', '1', '11');
INSERT INTO `buttons` VALUES (17, '自助开通会员', '自助开通会员', '自助开通会员', '自助开通会员呀', 'HTML', '0', '[[{\"text\":\"为自己充值\",\"callback_data\":\"recharge_my\"},{\"text\":\"为他人充值\",\"callback_data\":\"recharge_other\"}]]', NULL);
INSERT INTO `buttons` VALUES (18, '自助开通会员哦', 'recharge', 'recharge', '充值的用户名:{username} 请选择充值是的时间', 'HTML', '0', NULL, NULL);
INSERT INTO `buttons` VALUES (19, '选择时间', 'gogo', 'gogo', '充值的用户名:{username}  请选择充值是的时间', 'HTML', '0', NULL, NULL);

-- ----------------------------
-- Table structure for carmis
-- ----------------------------
DROP TABLE IF EXISTS `carmis`;
CREATE TABLE `carmis`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `goods_id` int(11) NOT NULL COMMENT '所属商品',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '状态 1未售出 2已售出',
  `is_loop` tinyint(1) NOT NULL DEFAULT 0 COMMENT '循环卡密 1是 0否',
  `carmi` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '卡密',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_goods_id`(`goods_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 196 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci COMMENT = '卡密表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for coupons
-- ----------------------------
DROP TABLE IF EXISTS `coupons`;
CREATE TABLE `coupons`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `discount` decimal(10, 2) NOT NULL DEFAULT 0.00 COMMENT '优惠金额',
  `is_use` tinyint(1) NOT NULL DEFAULT 1 COMMENT '是否已经使用 1未使用 2已使用',
  `is_open` tinyint(1) NOT NULL DEFAULT 1 COMMENT '是否启用 1是 0否',
  `coupon` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '优惠码',
  `ret` int(11) NOT NULL DEFAULT 0 COMMENT '剩余使用次数',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `idx_coupon`(`coupon`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci COMMENT = '优惠码表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for coupons_goods
-- ----------------------------
DROP TABLE IF EXISTS `coupons_goods`;
CREATE TABLE `coupons_goods`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goods_id` int(11) NOT NULL COMMENT '商品id',
  `coupons_id` int(11) NOT NULL COMMENT '优惠码id',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci COMMENT = '优惠码关联商品表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for emailtpls
-- ----------------------------
DROP TABLE IF EXISTS `emailtpls`;
CREATE TABLE `emailtpls`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tpl_name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '邮件标题',
  `tpl_content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '邮件内容',
  `tpl_token` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '邮件标识',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `mail_token`(`tpl_token`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for goods
-- ----------------------------
DROP TABLE IF EXISTS `goods`;
CREATE TABLE `goods`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL COMMENT '所属分类id',
  `gd_name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '商品名称',
  `gd_description` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '商品描述',
  `gd_keywords` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '商品关键字',
  `picture` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL COMMENT '商品图片',
  `retail_price` decimal(10, 2) NULL DEFAULT 0.00 COMMENT '零售价',
  `actual_price` decimal(10, 2) NOT NULL DEFAULT 0.00 COMMENT '实际售价',
  `in_stock` int(11) NOT NULL DEFAULT 0 COMMENT '库存',
  `sales_volume` int(11) NULL DEFAULT 0 COMMENT '销量',
  `ord` int(11) NULL DEFAULT 1 COMMENT '排序权重 越大越靠前',
  `buy_limit_num` int(11) NOT NULL DEFAULT 0 COMMENT '限制单次购买最大数量，0为不限制',
  `buy_prompt` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '购买提示',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '商品描述',
  `type` tinyint(1) NOT NULL DEFAULT 1 COMMENT '商品类型  1自动发货 2人工处理',
  `wholesale_price_cnf` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '批发价配置',
  `other_ipu_cnf` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '其他输入框配置',
  `api_hook` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '回调事件',
  `is_open` tinyint(1) NOT NULL DEFAULT 1 COMMENT '是否启用，1是 0否',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci COMMENT = '商品表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for goods_group
-- ----------------------------
DROP TABLE IF EXISTS `goods_group`;
CREATE TABLE `goods_group`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gp_name` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '分类名称',
  `is_open` tinyint(1) NOT NULL DEFAULT 1 COMMENT '是否启用，1是 0否',
  `ord` int(11) NOT NULL DEFAULT 1 COMMENT '排序权重 越大越靠前',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci COMMENT = '商品分类表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for message
-- ----------------------------
DROP TABLE IF EXISTS `message`;
CREATE TABLE `message`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '消息内容',
  `addtime` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 788 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '机器人消息列表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for orders
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `order_sn` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '订单号',
  `goods_id` int(11) NOT NULL COMMENT '关联商品id',
  `coupon_id` int(11) NULL DEFAULT 0 COMMENT '关联优惠码id',
  `title` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '订单名称',
  `type` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1自动发货 2人工处理',
  `goods_price` decimal(10, 2) NOT NULL DEFAULT 0.00 COMMENT '商品单价',
  `buy_amount` int(11) NOT NULL DEFAULT 1 COMMENT '购买数量',
  `coupon_discount_price` decimal(10, 2) NOT NULL DEFAULT 0.00 COMMENT '优惠码优惠价格',
  `wholesale_discount_price` decimal(10, 2) NOT NULL DEFAULT 0.00 COMMENT '批发价优惠',
  `total_price` decimal(10, 2) NOT NULL DEFAULT 0.00 COMMENT '订单总价',
  `actual_price` decimal(10, 2) NOT NULL DEFAULT 0.00 COMMENT '实际支付价格',
  `search_pwd` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '' COMMENT '查询密码',
  `email` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '下单邮箱',
  `info` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '订单详情',
  `pay_id` int(11) NULL DEFAULT NULL COMMENT '支付通道id',
  `buy_ip` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '购买者下单IP地址',
  `trade_no` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '' COMMENT '第三方支付订单号',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1待支付 2待处理 3处理中 4已完成 5处理失败 6异常 -1过期',
  `coupon_ret_back` tinyint(1) NOT NULL DEFAULT 0 COMMENT '优惠码使用次数是否已经回退 0否 1是',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `idx_order_sn`(`order_sn`) USING BTREE,
  INDEX `idx_goods_id`(`goods_id`) USING BTREE,
  INDEX `idex_email`(`email`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 50 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci COMMENT = '订单表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for pays
-- ----------------------------
DROP TABLE IF EXISTS `pays`;
CREATE TABLE `pays`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pay_name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '支付名称',
  `pay_check` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '支付标识',
  `pay_method` tinyint(1) NOT NULL COMMENT '支付方式 1跳转 2扫码',
  `pay_client` tinyint(1) NOT NULL DEFAULT 1 COMMENT '支付场景：1电脑pc 2手机 3全部',
  `merchant_id` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '商户 ID',
  `merchant_key` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '商户 KEY',
  `merchant_pem` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '商户密钥',
  `pay_handleroute` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '支付处理路由',
  `is_open` tinyint(1) NOT NULL DEFAULT 1 COMMENT '是否启用 1是 0否',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `idx_pay_check`(`pay_check`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 26 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pays
-- ----------------------------
INSERT INTO `pays` VALUES (1, '支付宝当面付', 'zfbf2f', 2, 3, '商户号', '支付宝公钥', '商户私钥', '/pay/alipay', 0, '2019-03-11 13:04:52', '2023-12-19 05:19:33', NULL);
INSERT INTO `pays` VALUES (2, '支付宝 PC', 'aliweb', 1, 1, '商户号', '', '密钥', '/pay/alipay', 0, '2019-07-08 21:25:27', '2023-12-19 05:19:33', NULL);
INSERT INTO `pays` VALUES (3, '码支付 QQ', 'mqq', 1, 1, '商户号', '', '密钥', '/pay/mapay', 0, '2019-07-11 17:05:27', '2023-12-19 05:19:33', NULL);
INSERT INTO `pays` VALUES (4, '码支付支付宝', 'mzfb', 1, 1, '商户号', '', '密钥', '/pay/mapay', 0, '2019-07-11 17:06:02', '2023-12-19 05:19:33', NULL);
INSERT INTO `pays` VALUES (5, '码支付微信', 'mwx', 1, 1, '商户号', '', '密钥', '/pay/mapay', 0, '2019-07-11 17:06:23', '2023-12-19 05:19:33', NULL);
INSERT INTO `pays` VALUES (6, 'Paysapi 支付宝', 'pszfb', 1, 1, '商户号', '', '密钥', '/pay/paysapi', 0, '2019-07-11 17:31:12', '2023-12-19 05:19:33', NULL);
INSERT INTO `pays` VALUES (7, 'Paysapi 微信', 'pswx', 1, 1, '商户号', '', '密钥', '/pay/paysapi', 0, '2019-07-11 17:31:43', '2023-12-19 05:19:33', NULL);
INSERT INTO `pays` VALUES (8, '微信扫码', 'wescan', 2, 1, '商户号', '', '密钥', '/pay/wepay', 0, '2019-07-12 15:50:20', '2023-12-19 05:19:33', NULL);
INSERT INTO `pays` VALUES (11, 'Payjs 微信扫码', 'payjswescan', 1, 1, '商户号', '', '密钥', '/pay/payjs', 0, '2019-07-25 15:28:42', '2023-12-19 05:19:33', NULL);
INSERT INTO `pays` VALUES (14, '易支付-支付宝', 'alipay', 1, 3, '1000', 'https://fkzf.kunyunkeji.cn/submit.php', 'Gx5C555DIWC5ZZc8wYH52MCHGFD220GC', '/pay/yipay', 1, '2020-01-10 23:22:56', '2023-12-08 04:24:46', NULL);
INSERT INTO `pays` VALUES (15, '易支付-微信', 'wxpay', 1, 3, '1000', 'https://fkzf.kunyunkeji.cn/submit.php', 'Gx5C555DIWC5ZZc8wYH52MCHGFD220GC', '/pay/yipay', 1, '2020-07-15 00:27:06', '2023-12-08 04:24:42', NULL);
INSERT INTO `pays` VALUES (16, '易支付-QQ 钱包', 'qqpay', 1, 1, '商户号', NULL, '密钥', '/pay/yipay', 0, '2020-07-15 00:27:03', '2023-12-19 05:19:33', NULL);
INSERT INTO `pays` VALUES (17, 'PayPal', 'paypal', 1, 1, '商户号', NULL, '密钥', '/pay/paypal', 0, '2020-07-15 00:25:20', '2023-12-19 05:19:33', NULL);
INSERT INTO `pays` VALUES (19, 'V 免签支付宝', 'vzfb', 1, 1, 'V 免签通讯密钥', NULL, 'V 免签地址 例如 https://vpay.qq.com/    结尾必须有/', 'pay/vpay', 0, '2020-05-01 21:15:56', '2023-12-19 05:19:33', NULL);
INSERT INTO `pays` VALUES (20, 'V 免签微信', 'vwx', 1, 1, 'V 免签通讯密钥', NULL, 'V 免签地址 例如 https://vpay.qq.com/    结尾必须有/', 'pay/vpay', 0, '2020-05-01 21:17:28', '2023-12-19 05:19:33', NULL);
INSERT INTO `pays` VALUES (21, 'Stripe[微信支付宝]', 'stripe', 1, 1, 'pk开头的可发布密钥', NULL, 'sk开头的密钥', 'pay/stripe', 0, '2020-10-29 21:15:56', '2023-12-19 05:19:33', NULL);
INSERT INTO `pays` VALUES (22, 'Coinbase[加密货币]', 'coinbase', 1, 3, '费率', 'API密钥', '共享密钥', 'pay/coinbase', 0, '2021-08-15 21:15:56', '2023-12-19 05:19:33', NULL);
INSERT INTO `pays` VALUES (23, 'Epusdt[trc20]', 'epusdt', 1, 3, 'qwe12345', '不填即可', 'https://pay.hyperindex.tk/api/v1/order/create-transaction', 'pay/epusdt', 0, '2022-03-22 21:15:56', '2023-12-19 05:19:33', NULL);
INSERT INTO `pays` VALUES (24, 'FREE', 'feee', 1, 1, 'TRC20监控地址', NULL, '不用填写即可', 'pay/feee', 0, '2023-10-20 00:13:25', '2023-12-19 05:19:33', NULL);
INSERT INTO `pays` VALUES (25, '余额支付', 'yue', 1, 1, '什么都不用填写', NULL, '什么都不用填写', 'pay/yue', 0, '2023-10-20 00:13:25', '2023-12-19 05:19:33', NULL);

-- ----------------------------
-- Table structure for prime
-- ----------------------------
DROP TABLE IF EXISTS `prime`;
CREATE TABLE `prime`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用户id',
  `order` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '订单号',
  `username` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '要充值的用户名',
  `month` int(3) NOT NULL COMMENT '月份:3,6,12',
  `status` enum('-1','0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '状态:-1=手动充值,0=待充值,1=自动充值',
  `addtime` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '会员订单充值' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for recharge
-- ----------------------------
DROP TABLE IF EXISTS `recharge`;
CREATE TABLE `recharge`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '所属用户id',
  `orderno` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '订单号',
  `money` float(11, 3) NOT NULL COMMENT '订单金额',
  `sign` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('-1','0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '订单状态:-1=已取消,0=待支付,1=已支付',
  `addtime` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '添加时间',
  `paytime` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '支付时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 70 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '余额充值' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `uid` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `uname` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '用户名',
  `nick` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '用户昵称',
  `money` float(11, 3) NOT NULL DEFAULT 0.000 COMMENT '余额',
  `points` int(11) NOT NULL DEFAULT 0 COMMENT '积分',
  `upid` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '上一级id',
  `addtime` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '添加时间',
  `updatetime` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`uid`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '用户列表' ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
