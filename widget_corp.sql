-- Adminer 4.3.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `hashed_password` varchar(60) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `admins` (`id`, `username`, `hashed_password`) VALUES
(2,	'kskoglund',	'$2y$10$N2M3MDRmMDAxYjM5MjI4NO8si6dsnBN11c0wd7hi3ZffaguBrty32'),
(7,	'johndoe',	'$2y$10$YjZhZTJjNDdmZTllNDhjYOW3hJ6YsBJd363Cwn.7SgzmujT/OGKhG');

DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject_id` int(11) NOT NULL,
  `menu_name` varchar(30) NOT NULL,
  `position` int(3) NOT NULL,
  `visible` tinyint(1) NOT NULL,
  `content` text,
  PRIMARY KEY (`id`),
  KEY `subject_id` (`subject_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `pages` (`id`, `subject_id`, `menu_name`, `position`, `visible`, `content`) VALUES
(1,	1,	'Our Mission',	1,	1,	'Our miss always been'),
(2,	1,	'Our History',	2,	1,	'Founded in 1898 by 2'),
(3,	2,	'Large Widgets',	1,	1,	'Large widgets is here'),
(4,	2,	'Small Widgets',	2,	1,	'All in small widgets'),
(5,	3,	'Retrofitting',	1,	1,	'We ll replace widgets...'),
(6,	3,	'Certification',	2,	1,	'We can certify widgets');

DROP TABLE IF EXISTS `subjects`;
CREATE TABLE `subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(30) NOT NULL,
  `position` int(3) NOT NULL,
  `visible` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `subjects` (`id`, `menu_name`, `position`, `visible`) VALUES
(1,	'About Widget Corp',	1,	1),
(2,	'Products',	2,	1),
(3,	'Services',	3,	1),
(4,	'Today\'s Widget Trivia',	4,	1),
(5,	'Sample Subject',	5,	1),
(6,	'Test subject',	6,	1);

-- 2017-09-08 08:18:58
