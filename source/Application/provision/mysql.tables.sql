-- --------------------------------------------------------
-- Hôte :                        127.0.0.1
-- Version du serveur:           10.1.21-MariaDB - mariadb.org binary distribution
-- SE du serveur:                Win32
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Export de la structure de la base pour dzr
CREATE DATABASE IF NOT EXISTS `dzr` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_bin */;
USE `dzr`;

-- Export de la structure de la table dzr. album
CREATE TABLE IF NOT EXISTS `album` (
  `id` varchar(50) COLLATE utf8_bin NOT NULL,
  `title` varchar(255) COLLATE utf8_bin NOT NULL,
  `data` text COLLATE utf8_bin NOT NULL,
  `artist_id` varchar(50) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Index 1` (`title`),
  KEY `Index 2` (`artist_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Les données exportées n'étaient pas sélectionnées.
-- Export de la structure de la table dzr. album_song
CREATE TABLE IF NOT EXISTS `album_song` (
  `id` varchar(50) COLLATE utf8_bin NOT NULL,
  `album_id` varchar(50) COLLATE utf8_bin NOT NULL,
  `song_id` varchar(50) COLLATE utf8_bin NOT NULL,
  `rank` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Index 2` (`album_id`),
  KEY `Index 3` (`song_id`),
  KEY `Index 4` (`rank`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Les données exportées n'étaient pas sélectionnées.
-- Export de la structure de la table dzr. artist
CREATE TABLE IF NOT EXISTS `artist` (
  `id` varchar(50) COLLATE utf8_bin NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `data` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Index 2` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Les données exportées n'étaient pas sélectionnées.
-- Export de la structure de la table dzr. playlist
CREATE TABLE IF NOT EXISTS `playlist` (
  `id` varchar(50) COLLATE utf8_bin NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `user_id` varchar(50) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `slug` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `playlist_userid` (`user_id`),
  KEY `playlist_slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Les données exportées n'étaient pas sélectionnées.
-- Export de la structure de la table dzr. playlist_song
CREATE TABLE IF NOT EXISTS `playlist_song` (
  `id` varchar(50) COLLATE utf8_bin NOT NULL,
  `playlist_id` varchar(50) COLLATE utf8_bin NOT NULL,
  `song_id` varchar(50) COLLATE utf8_bin NOT NULL,
  `rank` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Index 2` (`playlist_id`,`song_id`,`rank`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Les données exportées n'étaient pas sélectionnées.
-- Export de la structure de la table dzr. song
CREATE TABLE IF NOT EXISTS `song` (
  `id` varchar(50) COLLATE utf8_bin NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL,
  `duration` int(10) unsigned NOT NULL COMMENT 'durée en secondes',
  `artist_id` varchar(50) COLLATE utf8_bin NOT NULL,
  `data` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Index 2` (`artist_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Les données exportées n'étaient pas sélectionnées.
-- Export de la structure de la table dzr. user
CREATE TABLE IF NOT EXISTS `user` (
  `id` varchar(50) COLLATE utf8_bin NOT NULL,
  `email` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `creation_date` datetime DEFAULT NULL,
  `data` text COLLATE utf8_bin,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Les données exportées n'étaient pas sélectionnées.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
