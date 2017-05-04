-- Adminer 4.3.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` bigint(255) unsigned NOT NULL AUTO_INCREMENT,
  `content` text CHARACTER SET utf8 NOT NULL,
  `user_id` bigint(255) NOT NULL,
  `message_id` bigint(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `message_id` (`message_id`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`message_id`) REFERENCES `messages` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comments_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comments_ibfk_4` FOREIGN KEY (`message_id`) REFERENCES `messages` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comments_ibfk_5` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comments_ibfk_6` FOREIGN KEY (`message_id`) REFERENCES `messages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `user_id` bigint(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8;

INSERT INTO `messages` (`id`, `content`, `user_id`, `created_at`) VALUES
(67,	'Ð¡Ð¾Ð¾Ð±Ñ‰ÐµÐ½Ð¸Ðµ 1',	10,	'2017-05-03 20:41:46'),
(68,	'Ð¡Ð¾Ð¾Ð±Ñ‰ÐµÐ½Ð¸Ðµ 2',	10,	'2017-05-03 20:41:53'),
(69,	'Ð¡Ð¾Ð¾Ð±Ñ‰ÐµÐ½Ð¸Ðµ 3',	10,	'2017-05-03 20:41:57'),
(70,	'Ð¡Ð¾Ð¾Ð±Ñ‰ÐµÐ½Ð¸Ðµ 4',	10,	'2017-05-03 20:42:01'),
(71,	'Ð¡Ð¾Ð¾Ð±Ñ‰ÐµÐ½Ð¸Ðµ 5',	10,	'2017-05-03 20:42:04'),
(72,	'Ð¡Ð¾Ð¾Ð±Ñ‰ÐµÐ½Ð¸Ðµ 6',	10,	'2017-05-03 20:42:07'),
(73,	'Ð¡Ð¾Ð¾Ð±Ñ‰ÐµÐ½Ð¸Ðµ 7',	10,	'2017-05-03 20:42:10'),
(74,	'Ð¡Ð¾Ð¾Ð±Ñ‰ÐµÐ½Ð¸Ðµ 8',	10,	'2017-05-03 20:42:13'),
(75,	'Ð¡Ð¾Ð¾Ð±Ñ‰ÐµÐ½Ð¸Ðµ 9',	10,	'2017-05-03 20:42:16'),
(76,	'Ð¡Ð¾Ð¾Ð±Ñ‰ÐµÐ½Ð¸Ðµ 10',	10,	'2017-05-03 20:42:19'),
(77,	'Ð¡Ð¾Ð¾Ð±Ñ‰ÐµÐ½Ð¸Ðµ 11',	10,	'2017-05-03 20:42:22'),
(78,	'Ð¡Ð¾Ð¾Ð±Ñ‰ÐµÐ½Ð¸Ðµ 12',	10,	'2017-05-03 20:42:25');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT 'No name user',
  `photo` varchar(1000) DEFAULT NULL,
  `social_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

INSERT INTO `users` (`id`, `name`, `photo`, `social_id`) VALUES
(10,	'Ð–ÐµÐ½Ñ ÐšÑƒÐ±Ð°Ð¹',	'https://pp.userapi.com/c636624/v636624720/7bfd/wl-U17wyQE0.jpg',	'153720720');

-- 2017-05-04 07:26:48
