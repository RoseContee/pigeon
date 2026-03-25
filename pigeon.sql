/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : pigeon

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2020-11-26 14:32:49
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for admins
-- ----------------------------
DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admins
-- ----------------------------
INSERT INTO `admins` VALUES ('1', 'admin@admin.com', '$2y$10$CDek/BExXkCqs/g/Ascr0ulib5CeeRppH4RNAggc8ZjJStRMO6S6e', '2020-10-09 08:35:02', '2020-11-03 20:39:27');

-- ----------------------------
-- Table structure for api_tokens
-- ----------------------------
DROP TABLE IF EXISTS `api_tokens`;
CREATE TABLE `api_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of api_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for apps
-- ----------------------------
DROP TABLE IF EXISTS `apps`;
CREATE TABLE `apps` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of apps
-- ----------------------------
INSERT INTO `apps` VALUES ('1', 'Google Meet', '1', '2020-10-09 08:35:02', '2020-10-09 08:35:02');
INSERT INTO `apps` VALUES ('2', 'Zoom', '1', '2020-10-09 08:35:02', '2020-11-13 10:13:44');

-- ----------------------------
-- Table structure for guests
-- ----------------------------
DROP TABLE IF EXISTS `guests`;
CREATE TABLE `guests` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of guests
-- ----------------------------

-- ----------------------------
-- Table structure for meetings
-- ----------------------------
DROP TABLE IF EXISTS `meetings`;
CREATE TABLE `meetings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `app_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `event_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `host_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guests` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `booking_time` datetime NOT NULL,
  `timezone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of meetings
-- ----------------------------

-- ----------------------------
-- Table structure for memberships
-- ----------------------------
DROP TABLE IF EXISTS `memberships`;
CREATE TABLE `memberships` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `membership_package_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `limitation` int(11) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of memberships
-- ----------------------------
INSERT INTO `memberships` VALUES ('1', '1', 'Free', '0', '10', '', '1', '2020-10-09 08:35:02', '2020-11-13 10:13:56');

-- ----------------------------
-- Table structure for membership_packages
-- ----------------------------
DROP TABLE IF EXISTS `membership_packages`;
CREATE TABLE `membership_packages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `period` int(11) NOT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of membership_packages
-- ----------------------------
INSERT INTO `membership_packages` VALUES ('1', 'Monthly Plan', '1', 'month', '0', '1', '2020-10-09 08:35:02', '2020-11-13 10:13:52');

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES ('1', '2014_10_12_000000_create_users_table', '1');
INSERT INTO `migrations` VALUES ('2', '2014_10_12_100000_create_password_resets_table', '1');
INSERT INTO `migrations` VALUES ('3', '2020_09_10_002114_create_words_table', '1');
INSERT INTO `migrations` VALUES ('4', '2020_09_10_014713_create_platforms_table', '1');
INSERT INTO `migrations` VALUES ('5', '2020_09_10_030017_create_apps_table', '1');
INSERT INTO `migrations` VALUES ('6', '2020_09_10_040322_create_user_metas_table', '1');
INSERT INTO `migrations` VALUES ('7', '2020_09_10_165211_create_admins_table', '1');
INSERT INTO `migrations` VALUES ('8', '2020_09_10_175638_create_memberships_table', '1');
INSERT INTO `migrations` VALUES ('9', '2020_09_10_214410_create_settings_table', '1');
INSERT INTO `migrations` VALUES ('10', '2020_09_10_224936_create_meetings_table', '1');
INSERT INTO `migrations` VALUES ('11', '2020_09_10_231800_create_guests_table', '1');
INSERT INTO `migrations` VALUES ('12', '2020_09_10_232034_create_membership_packages_table', '1');
INSERT INTO `migrations` VALUES ('13', '2020_11_05_165156_add_google_id_to_users', '2');
INSERT INTO `migrations` VALUES ('14', '2020_11_06_105753_create_api_tokens_table', '3');

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for platforms
-- ----------------------------
DROP TABLE IF EXISTS `platforms`;
CREATE TABLE `platforms` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of platforms
-- ----------------------------
INSERT INTO `platforms` VALUES ('1', 'LinkedIn', 'https://www.linkedin.com/', '1', '2020-10-09 08:35:02', '2020-11-13 09:36:05');
INSERT INTO `platforms` VALUES ('2', 'Facebook', 'https://facebook.com', '1', '2020-11-13 09:46:31', '2020-11-13 10:13:39');

-- ----------------------------
-- Table structure for settings
-- ----------------------------
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_value` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of settings
-- ----------------------------
INSERT INTO `settings` VALUES ('1', 'site_name', 'Pigeon', '2020-10-09 08:35:02', '2020-10-21 11:47:12');
INSERT INTO `settings` VALUES ('2', 'site_url', 'https://joinpigeon.com/', '2020-10-09 08:35:02', '2020-10-09 08:35:02');
INSERT INTO `settings` VALUES ('3', 'site_logo', 'assets/images/logo.png', '2020-10-09 08:35:02', '2020-10-09 08:35:02');
INSERT INTO `settings` VALUES ('4', 'favicon', 'assets/images/logo.png', '2020-10-09 08:35:02', '2020-10-09 08:35:02');
INSERT INTO `settings` VALUES ('5', 'contact_email', 'hello@joinpigeon.com', '2020-10-09 08:35:02', '2020-10-09 08:35:02');
INSERT INTO `settings` VALUES ('6', 'facebook_link', 'https://www.facebook.com/joinpigeontoday/', '2020-10-09 08:35:02', '2020-10-09 08:35:02');
INSERT INTO `settings` VALUES ('7', 'twitter_link', 'https://twitter.com/joinpigeon/', '2020-10-09 08:35:02', '2020-10-09 08:35:02');
INSERT INTO `settings` VALUES ('8', 'linkedin_link', 'https://www.linkedin.com/company/joinpigeon/', '2020-10-09 08:35:02', '2020-10-09 08:35:02');
INSERT INTO `settings` VALUES ('9', 'meta_title', 'Pigeon - Create meeting invites directly from LinkedIn Chatrooms', '2020-10-09 08:35:02', '2020-10-21 11:46:44');
INSERT INTO `settings` VALUES ('10', 'meta_keywords', 'schedule a meeting, book a meeting, meeting invites, zoom meeting, Google meet,', '2020-10-09 08:35:02', '2020-10-21 11:46:44');
INSERT INTO `settings` VALUES ('11', 'meta_description', 'Pigeon chrome extension helps you book meetings directly from LinkedIn chatroom. Continue your chat with the prospect, create a meeting without keep them waiting in chatroom. Book meetings in 15 seconds.', '2020-10-09 08:35:02', '2020-10-21 11:46:44');
INSERT INTO `settings` VALUES ('28', 'mail_driver', 'smtp', '2020-11-05 19:13:47', '2020-11-05 19:13:47');
INSERT INTO `settings` VALUES ('29', 'mail_host', 'smtp-relay.gmail.com', '2020-11-05 19:13:47', '2020-11-05 19:13:47');
INSERT INTO `settings` VALUES ('30', 'mail_port', '587', '2020-11-05 19:13:47', '2020-11-05 19:13:47');
INSERT INTO `settings` VALUES ('31', 'mail_username', 'hello@joinpigeon.com', '2020-11-05 19:13:47', '2020-11-05 19:13:47');
INSERT INTO `settings` VALUES ('32', 'mail_password', null, '2020-11-05 19:13:47', '2020-11-05 19:13:47');
INSERT INTO `settings` VALUES ('33', 'mail_encryption', 'tls', '2020-11-05 19:13:47', '2020-11-05 19:13:47');
INSERT INTO `settings` VALUES ('34', 'google_client_id', '97803995479-0epuvc2735gllpi9hnp1k3pocb0le73t.apps.googleusercontent.com', '2020-11-05 19:13:50', '2020-11-05 19:13:50');
INSERT INTO `settings` VALUES ('35', 'google_client_secret', '6tkBTQUnoNx4V9GeJfp2cBxy', '2020-11-05 19:13:50', '2020-11-05 19:13:50');
INSERT INTO `settings` VALUES ('36', 'how_video', 'https://www.youtube.com/watch?v=qLdslXvkUdY', '2020-11-25 13:19:00', '2020-11-25 13:19:00');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `membership_id` int(11) NOT NULL,
  `limitation` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `api_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `linkedin_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------

-- ----------------------------
-- Table structure for user_metas
-- ----------------------------
DROP TABLE IF EXISTS `user_metas`;
CREATE TABLE `user_metas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of user_metas
-- ----------------------------

-- ----------------------------
-- Table structure for words
-- ----------------------------
DROP TABLE IF EXISTS `words`;
CREATE TABLE `words` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `word` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of words
-- ----------------------------
INSERT INTO `words` VALUES ('1', 'call', '2020-10-09 08:35:02', '2020-10-09 08:35:02');
INSERT INTO `words` VALUES ('2', 'Zoom', '2020-10-09 08:35:02', '2020-10-09 08:35:02');
INSERT INTO `words` VALUES ('3', 'meeting', '2020-10-09 08:35:02', '2020-10-09 08:35:02');
INSERT INTO `words` VALUES ('4', 'invite', '2020-10-09 08:35:02', '2020-10-09 08:35:02');
