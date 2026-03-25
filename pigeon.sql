/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : pigeon

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2021-02-05 20:54:42
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
INSERT INTO `admins` VALUES ('1', 'hello@joinpigeon.com', '$2y$10$uRdqW.0HjT5aPDSaWrnxgOOm0be3/f9b.b4KJu2M40Ryml.pbw4HG', '2020-12-22 14:29:01', '2020-12-22 14:29:01');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of apps
-- ----------------------------
INSERT INTO `apps` VALUES ('1', 'Google Meet', 'app/google-meet.png', '1', '2020-12-22 14:29:01', '2020-12-22 14:29:01');
INSERT INTO `apps` VALUES ('2', 'Zoom', 'app/zoom.png', '1', '2020-12-22 14:29:01', '2020-12-22 14:29:01');

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
-- Table structure for mail_templates
-- ----------------------------
DROP TABLE IF EXISTS `mail_templates`;
CREATE TABLE `mail_templates` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of mail_templates
-- ----------------------------
INSERT INTO `mail_templates` VALUES ('1', 'signup', 'Welcome to Pigeon {Name}', '<p dir=\"ltr\"><strong>Hey {Name},</strong></p>\n\n<p dir=\"ltr\">&nbsp;</p>\n\n<p dir=\"ltr\"><strong>I&rsquo;m Ranvijay, the founder of Pigeon and I&rsquo;d like to personally thank you for signing up to our service.</strong></p>\n\n<p dir=\"ltr\"><strong>We established Pigeon in order to allow professionals like you to do more before &amp; after online meetings. Booking a meeting from your side or to allow audiences to book session slots from your published calendar, Pigeon is always standing by your side.</strong></p>\n\n<p dir=\"ltr\"><strong>I&rsquo;d love to hear what you think of Pigeon and if there is anything we can improve. If you have any questions, please reply to this email. I&rsquo;m always happy to help!</strong></p>\n\n<p>&nbsp;</p>\n\n<p dir=\"ltr\"><strong>Thanks</strong></p>\n\n<p><strong><img src=\"https://lh3.googleusercontent.com/XPj-qlh3EewMxjglCvX4ge6zuPhnf77hnw-4Myi3HDUNJ4aCqSuE7NSOtRZl91SFD1U48NeqERndx4WPtrawHGOkoGb8WPiqtIkT3emSSKqFyeOqdcdaltVU3cKe5WyRJJMsoaHo\" /><br />\nRanvijay Singh<br />\n<img src=\"https://lh5.googleusercontent.com/EvzFPB3sF-Nv_gAyWZnIPjWiOvIS-PLoTHkVwqpEMnZq3Yn3eS6aO2qB5u3WdO7iSdXWNcRN3CzIV-YnZ-Fbk5QvzDZwj2OmxirFBHj5COFmm_eRWeqPaJ4Ia2VIVp0hFbsIHCls\" /></strong></p>', '2020-12-22 14:29:01', '2020-12-22 14:29:01');
INSERT INTO `mail_templates` VALUES ('2', 'no-meeting', 'Struggling to book a meeting?', '<p dir=\"ltr\"><strong>Hi {Name},</strong></p>\n\n<p dir=\"ltr\"><strong>Hope you are doing well.&nbsp;</strong></p>\n\n<p dir=\"ltr\"><strong>Thanks for signing up with me, I am happy to have you onboard.&nbsp; But, it looks like you didn&#39;t try booking a video meeting using Pigeon Chrome Extension yet.</strong></p>\n\n<p dir=\"ltr\"><strong>Do you have <a href=\"https://chrome.google.com/webstore/detail/pigeon/adlljmlbangmeenndganepfkilcdihnm\">Pigeon Chrome Extension</a> Installed in your browser?</strong></p>\n\n<p dir=\"ltr\"><strong>I will be happy to help you in booking a meeting, in case you are facing any problems.</strong></p>\n\n<p dir=\"ltr\"><strong>Please let me know.</strong><br />\n&nbsp;</p>\n\n<p dir=\"ltr\"><strong>Your true productivity partner!</strong></p>\n\n<p dir=\"ltr\"><strong><img src=\"https://lh6.googleusercontent.com/Ld3hQW4dYm7KK_awT7WoULHqSrJvNEcl4QnNdm8jWlImVXfknd5uP_n9j32SqwBCbuQzFR8Rtu4496vetD9tQblD0TJlKpqlP4d7Uav4VS83psnGsbK2PqwvIoNic8cuWUbPT5-h\" /><br />\nPigeon</strong></p>', '2020-12-22 14:29:01', '2020-12-22 14:29:01');
INSERT INTO `mail_templates` VALUES ('3', 'rate-review', 'May I ask you for a favor?', '<p dir=\"ltr\"><strong>Hi {Name},</strong></p>\n\n<p dir=\"ltr\">&nbsp;</p>\n\n<p dir=\"ltr\"><strong>It is good to see Pigeon is working fine and helping you in scheduling your meetings and sessions with much love &amp; efficiency.<br />\nHere, I wanted to make a request. If you could rate &amp; review us on <a href=\"https://chrome.google.com/webstore/detail/pigeon/adlljmlbangmeenndganepfkilcdihnm\">Chrome Web Store</a>.<br />\nIt will really be helpful and will motivate us to improve and keep doing the good job for you.</strong><br />\n&nbsp;</p>\n\n<p dir=\"ltr\"><strong>Your true productivity partner!</strong></p>\n\n<p dir=\"ltr\"><strong><img src=\"https://lh6.googleusercontent.com/Ld3hQW4dYm7KK_awT7WoULHqSrJvNEcl4QnNdm8jWlImVXfknd5uP_n9j32SqwBCbuQzFR8Rtu4496vetD9tQblD0TJlKpqlP4d7Uav4VS83psnGsbK2PqwvIoNic8cuWUbPT5-h\" /><br />\nPigeon</strong></p>', '2020-12-22 14:29:01', '2020-12-22 14:29:01');
INSERT INTO `mail_templates` VALUES ('4', 'complete-meeting', '', '', '2020-12-22 14:29:01', '2020-12-22 14:29:01');
INSERT INTO `mail_templates` VALUES ('5', 'guests-notify', 'I wish your last meeting was successful?', '<p dir=\"ltr\"><strong>Hi {Name},</strong></p>\n\n<p dir=\"ltr\">&nbsp;</p>\n\n<p dir=\"ltr\"><strong>I&rsquo;m Pigeon and I really wish your last meeting with {Email} was successful.<br />\nI am a productivity tool that helps businesses &amp; professionals like you to schedule meetings in an efficient and quick way (say 15 seconds or less).<br />\nYou can use me for both the scopes i.e outbound outreach or publishing your calendar to allow audiences book your time slots.<br />\n<br />\n1. For outbound outreach you can use me as an extension (Available on <a href=\"https://chrome.google.com/webstore/detail/pigeon/adlljmlbangmeenndganepfkilcdihnm\">Chrome Web Store</a> for Free)<br />\n2. For inbound slots booking you can publish your calendar publicly.<br />\n<br />\nThe best part is you can see all your meetings, guests at one place. So no more back &amp; forth from platform to platform to organise your prospects data.<br />\n<a href=\"https://joinpigeon.com\">Sign up for free today!</a><br />\nIn case you have any questions, feel free to reply to this email. I will be happy to answer your queries.<br />\n<br />\nThanks!</strong><br />\n&nbsp;</p>\n\n<p dir=\"ltr\"><strong>Your true productivity partner!</strong></p>\n\n<p dir=\"ltr\"><strong><img src=\"https://lh6.googleusercontent.com/Ld3hQW4dYm7KK_awT7WoULHqSrJvNEcl4QnNdm8jWlImVXfknd5uP_n9j32SqwBCbuQzFR8Rtu4496vetD9tQblD0TJlKpqlP4d7Uav4VS83psnGsbK2PqwvIoNic8cuWUbPT5-h\" /><br />\nPigeon</strong></p>', '2020-12-22 14:29:01', '2020-12-22 14:29:01');
INSERT INTO `mail_templates` VALUES ('6', 'forgot-password', '', '', '2020-12-22 14:29:01', '2020-12-22 14:29:01');
INSERT INTO `mail_templates` VALUES ('7', 'reset-notify', '', '', '2020-12-22 14:29:01', '2020-12-22 14:29:01');

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
  `server_time` datetime NOT NULL,
  `completed` tinyint(4) NOT NULL DEFAULT 0,
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
  `event` int(11) NOT NULL,
  `schedule` int(11) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of memberships
-- ----------------------------
INSERT INTO `memberships` VALUES ('1', '1', 'Free', '0', '10', '1', '50', '10 Limitation\n1 Events\n10 Sessions', '1', '2020-12-22 14:29:01', '2020-12-22 14:29:01');

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
INSERT INTO `membership_packages` VALUES ('1', 'Monthly Plan', '1', 'month', '0', '1', '2020-12-22 14:29:01', '2020-12-22 14:29:01');

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
INSERT INTO `migrations` VALUES ('13', '2020_11_06_105753_create_api_tokens_table', '1');
INSERT INTO `migrations` VALUES ('14', '2020_12_08_044021_create_mail_templates_table', '1');
INSERT INTO `migrations` VALUES ('15', '2020_12_17_124526_create_user_events_table', '1');
INSERT INTO `migrations` VALUES ('16', '2020_12_19_153830_create_user_schedules_table', '1');
INSERT INTO `migrations` VALUES ('17', '2020_12_21_222424_create_scheduled_events_table', '1');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of platforms
-- ----------------------------
INSERT INTO `platforms` VALUES ('1', 'LinkedIn', 'https://www.linkedin.com/', '1', '2020-12-22 14:29:01', '2020-12-22 14:29:01');

-- ----------------------------
-- Table structure for scheduled_events
-- ----------------------------
DROP TABLE IF EXISTS `scheduled_events`;
CREATE TABLE `scheduled_events` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `event_id` bigint(20) NOT NULL,
  `invitee_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `invitee_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `invitee_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `scheduled_time` datetime NOT NULL,
  `timezone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of scheduled_events
-- ----------------------------

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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of settings
-- ----------------------------
INSERT INTO `settings` VALUES ('1', 'site_name', 'Pigeon', '2020-12-22 14:29:01', '2020-12-22 14:29:01');
INSERT INTO `settings` VALUES ('2', 'site_url', 'https://joinpigeon.com/', '2020-12-22 14:29:01', '2020-12-22 14:29:01');
INSERT INTO `settings` VALUES ('3', 'site_logo', 'assets/images/logo.png', '2020-12-22 14:29:01', '2020-12-22 14:29:01');
INSERT INTO `settings` VALUES ('4', 'favicon', 'assets/images/logo.png', '2020-12-22 14:29:01', '2020-12-22 14:29:01');
INSERT INTO `settings` VALUES ('5', 'contact_email', 'hello@joinpigeon.com', '2020-12-22 14:29:01', '2020-12-22 14:29:01');
INSERT INTO `settings` VALUES ('6', 'facebook_link', 'https://www.facebook.com/joinpigeontoday/', '2020-12-22 14:29:01', '2020-12-22 14:29:01');
INSERT INTO `settings` VALUES ('7', 'twitter_link', 'https://twitter.com/joinpigeon/', '2020-12-22 14:29:01', '2020-12-22 14:29:01');
INSERT INTO `settings` VALUES ('8', 'linkedin_link', 'https://www.linkedin.com/company/joinpigeon/', '2020-12-22 14:29:01', '2020-12-22 14:29:01');
INSERT INTO `settings` VALUES ('9', 'meta_title', '', '2020-12-22 14:29:01', '2020-12-22 14:29:01');
INSERT INTO `settings` VALUES ('10', 'meta_keywords', '', '2020-12-22 14:29:01', '2020-12-22 14:29:01');
INSERT INTO `settings` VALUES ('11', 'meta_description', '', '2020-12-22 14:29:01', '2020-12-22 14:29:01');
INSERT INTO `settings` VALUES ('12', 'how_video', 'https://www.youtube.com/watch?v=qLdslXvkUdY', '2020-12-22 14:29:01', '2020-12-22 14:29:01');
INSERT INTO `settings` VALUES ('13', 'mail_driver', 'smtp', '2020-12-28 11:19:53', '2020-12-28 11:19:53');
INSERT INTO `settings` VALUES ('14', 'mail_host', 'smtp.gmail.com', '2020-12-28 11:19:53', '2020-12-28 11:19:53');
INSERT INTO `settings` VALUES ('15', 'mail_port', '587', '2020-12-28 11:19:53', '2020-12-28 11:19:53');
INSERT INTO `settings` VALUES ('16', 'mail_username', 'hello@joinpigeon.com', '2020-12-28 11:19:53', '2020-12-28 11:19:53');
INSERT INTO `settings` VALUES ('17', 'mail_password', 'aiolcqkjeybbtkgd', '2020-12-28 11:19:53', '2020-12-28 11:21:25');
INSERT INTO `settings` VALUES ('18', 'mail_encryption', 'tls', '2020-12-28 11:19:53', '2020-12-28 11:19:53');

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
  `event` int(11) NOT NULL,
  `schedule` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `booking_number` bigint(20) NOT NULL DEFAULT 0,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `api_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------

-- ----------------------------
-- Table structure for user_events
-- ----------------------------
DROP TABLE IF EXISTS `user_events`;
CREATE TABLE `user_events` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `schedule_id` bigint(20) DEFAULT NULL,
  `mon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tue` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wed` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thu` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fri` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sun` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duration` int(11) NOT NULL,
  `break_time` int(11) NOT NULL,
  `timezone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of user_events
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
-- Table structure for user_schedules
-- ----------------------------
DROP TABLE IF EXISTS `user_schedules`;
CREATE TABLE `user_schedules` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tue` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wed` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thu` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fri` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sun` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of user_schedules
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
INSERT INTO `words` VALUES ('1', 'call', '2020-12-22 14:29:01', '2020-12-22 14:29:01');
INSERT INTO `words` VALUES ('2', 'Zoom', '2020-12-22 14:29:01', '2020-12-22 14:29:01');
INSERT INTO `words` VALUES ('3', 'meeting', '2020-12-22 14:29:01', '2020-12-22 14:29:01');
INSERT INTO `words` VALUES ('4', 'invite', '2020-12-22 14:29:01', '2020-12-22 14:29:01');
