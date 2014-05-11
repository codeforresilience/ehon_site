-- phpMyAdmin SQL Dump
-- version 3.5.7
-- http://www.phpmyadmin.net
--
-- ホスト: localhost
-- 生成日時: 2014 年 5 月 05 日 14:21
-- サーバのバージョン: 5.5.29
-- PHP のバージョン: 5.4.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- データベース: `ehon`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `attachments`
--

CREATE TABLE `attachments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file` varchar(255) NOT NULL,
  `width` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  `seq` int(11) DEFAULT NULL,
  `ehon_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='upload プラグイン' AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `ehons`
--

CREATE TABLE `ehons` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `copyright` varchar(255) DEFAULT NULL,
  `user_id` int(10) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `user_id_2` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `langs`
--

CREATE TABLE `langs` (
  `code` char(2) NOT NULL DEFAULT '',
  `name` varchar(50) NOT NULL,
  `native` varchar(50) NOT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `langs`
--

INSERT INTO `langs` (`code`, `name` ,`native`) VALUES
('ar', 'Arabic','العربية'),
('bh', 'Bihari','भोजपुरी'),
('bn', 'Bengali','বাংলা'),
('de', 'German','Deutsch'),
('en', 'English','English'),
('es', 'Spanish','español'),
('fa', 'Persian','فارسی'),
('fr', 'French','français'),
('hi', 'Hindi','हिन्दी, हिंदी'),
('it', 'Italian','italiano'),
('ja', 'Japanese','にほんご'),
('jv', 'Javanese','basa Jawa'),
('ko', 'Korean','한국어'),
('mr', 'Marathi','मराठी'),
('ms', 'Malay','بهاس ملايو‎'),
('pa', 'Punjabi','ਪੰਜਾਬੀ,'),
('pt', 'Portuguese','português'),
('ru', 'Russian','русский язык'),
('ta', 'Tamil','தமிழ்'),
('te', 'Telugu','తెలుగు'),
('th', 'Thai','ไทย'),
('tl', 'Tagalog','Wikang Tagalog'),
('tr', 'Turkish','Türkçe'),
('ur', 'Urdu','اردو'),
('vi', 'Vietnamese','Tiếng Việt'),
('zh', 'Chinese','中文');

-- --------------------------------------------------------

--
-- テーブルの構造 `masks`
--

CREATE TABLE `masks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `attachment_id` int(10) DEFAULT NULL,
  `x` float DEFAULT NULL,
  `y` float DEFAULT NULL,
  `width` float DEFAULT NULL,
  `height` float DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pages_id` (`attachment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `titles`
--

CREATE TABLE `titles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ehon_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `lang_code` char(2) NOT NULL DEFAULT 'en',
  `title` varchar(255) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ehon_lang` (`ehon_id`,`lang_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `translations`
--

CREATE TABLE `translations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mask_id` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  `lang_code` char(2) NOT NULL DEFAULT 'en',
  `translation` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mask_lang` (`mask_id`,`lang_code`),
  KEY `lang_code` (`lang_code`),
  KEY `mask_id` (`mask_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `lang_code` char(2) NOT NULL DEFAULT 'en',
  `photo_path` varchar(255) NOT NULL,
  `contact_url` text NOT NULL,
  `provider` varchar(64) NOT NULL,
  `provider_uid` varchar(255) NOT NULL,
  `role` int(11) DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lang_code` (`lang_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

