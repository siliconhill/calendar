-- phpMyAdmin SQL Dump
-- version 3.5.5
-- http://www.phpmyadmin.net
--
-- Počítač: localhost
-- Vygenerováno: Pon 25. úno 2013, 10:16
-- Verze MySQL: 5.5.29-MariaDB-log
-- Verze PHP: 5.4.12

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Databáze: `krouzek`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Vypisuji data pro tabulku `event`
--

INSERT INTO `event` (`id`, `name`, `description`) VALUES
(11, 'test', 'default'),
(12, 'test', 'popis');

-- --------------------------------------------------------

--
-- Struktura tabulky `instance`
--

CREATE TABLE IF NOT EXISTS `instance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `timeStart` datetime NOT NULL,
  `timeEnd` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `event_id` (`event_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Vypisuji data pro tabulku `instance`
--

INSERT INTO `instance` (`id`, `event_id`, `timeStart`, `timeEnd`) VALUES
(8, 12, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 11, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 11, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Struktura tabulky `resource`
--

CREATE TABLE IF NOT EXISTS `resource` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `resource_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `resource_id` (`resource_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Vypisuji data pro tabulku `resource`
--

INSERT INTO `resource` (`id`, `name`, `resource_id`) VALUES
(1, 'Homepage', NULL);

-- --------------------------------------------------------

--
-- Struktura tabulky `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Vypisuji data pro tabulku `role`
--

INSERT INTO `role` (`id`, `name`, `role_id`) VALUES
(1, 'guest', NULL),
(2, 'registered', 1),
(3, 'admin', 2);

-- --------------------------------------------------------

--
-- Struktura tabulky `role_resource`
--

CREATE TABLE IF NOT EXISTS `role_resource` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `resource_id` int(11) NOT NULL,
  `privilege` varchar(255) NOT NULL DEFAULT '',
  `allowed` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`role_id`),
  KEY `resource_id` (`resource_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `role_resource`
--

INSERT INTO `role_resource` (`id`, `role_id`, `resource_id`, `privilege`, `allowed`) VALUES
(0, 3, 1, '', 1);

-- --------------------------------------------------------

--
-- Struktura tabulky `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) NOT NULL,
  `realname` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Vypisuji data pro tabulku `user`
--

INSERT INTO `user` (`id`, `name`, `password`, `salt`, `realname`) VALUES
(1, 'test', '$1$qkHf3L.J$ELa28tt3SRhCMWf6R7uuZ1', '', 'Test');

-- --------------------------------------------------------

--
-- Struktura tabulky `user_role`
--

CREATE TABLE IF NOT EXISTS `user_role` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `user_role`
--

INSERT INTO `user_role` (`user_id`, `role_id`) VALUES
(1, 3);

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `instance`
--
ALTER TABLE `instance`
  ADD CONSTRAINT `instance_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE CASCADE;

--
-- Omezení pro tabulku `resource`
--
ALTER TABLE `resource`
  ADD CONSTRAINT `resource_ibfk_1` FOREIGN KEY (`resource_id`) REFERENCES `resource` (`id`) ON DELETE CASCADE;

--
-- Omezení pro tabulku `role`
--
ALTER TABLE `role`
  ADD CONSTRAINT `role_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE;

--
-- Omezení pro tabulku `role_resource`
--
ALTER TABLE `role_resource`
  ADD CONSTRAINT `role_resource_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_resource_ibfk_2` FOREIGN KEY (`resource_id`) REFERENCES `resource` (`id`) ON DELETE CASCADE;

--
-- Omezení pro tabulku `user_role`
--
ALTER TABLE `user_role`
  ADD CONSTRAINT `user_role_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_role_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE;
