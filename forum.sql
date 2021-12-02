-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Gazdă: 127.0.0.1
-- Timp de generare: dec. 02, 2021 la 06:22 AM
-- Versiune server: 10.4.21-MariaDB
-- Versiune PHP: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Bază de date: `forum`
--

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `forum_id` int(11) NOT NULL,
  `titlu` varchar(255) NOT NULL,
  `descriere` varchar(255) NOT NULL,
  `data_creare` datetime NOT NULL DEFAULT current_timestamp(),
  `creat_de` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_categorie_user` (`creat_de`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `forum`
--

DROP TABLE IF EXISTS `forum`;
CREATE TABLE IF NOT EXISTS `forum` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titlu` varchar(255) NOT NULL,
  `descriere` varchar(255) NOT NULL,
  `data_creare` datetime NOT NULL DEFAULT current_timestamp(),
  `creat_de` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `forum_abonament`
--

DROP TABLE IF EXISTS `forum_abonament`;
CREATE TABLE IF NOT EXISTS `forum_abonament` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ab_subiect_id` int(11) NOT NULL,
  `ab_email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ab_subiect_email` (`ab_subiect_id`,`ab_email`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `forum_documente`
--

DROP TABLE IF EXISTS `forum_documente`;
CREATE TABLE IF NOT EXISTS `forum_documente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `postare_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_document_postare` (`postare_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `forum_vizualizari`
--

DROP TABLE IF EXISTS `forum_vizualizari`;
CREATE TABLE IF NOT EXISTS `forum_vizualizari` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `forum_id` int(11) DEFAULT NULL,
  `categorie_id` int(11) DEFAULT NULL,
  `subiect_id` int(11) DEFAULT NULL,
  `ip` varchar(15) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_vizualizare_forum` (`forum_id`),
  KEY `fk_vizualizare_categorie` (`categorie_id`),
  KEY `fk_vizualizare_subiect` (`subiect_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `postare`
--

DROP TABLE IF EXISTS `postare`;
CREATE TABLE IF NOT EXISTS `postare` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subiect_id` int(11) NOT NULL,
  `continut` text NOT NULL,
  `data_creare` datetime NOT NULL DEFAULT current_timestamp(),
  `creat_de` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_postare_subiect` (`subiect_id`),
  KEY `fk_postare_user` (`creat_de`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `subiect`
--

DROP TABLE IF EXISTS `subiect`;
CREATE TABLE IF NOT EXISTS `subiect` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categorie_id` int(11) NOT NULL,
  `titlu` varchar(255) NOT NULL,
  `descriere` varchar(255) NOT NULL,
  `data_creare` datetime NOT NULL DEFAULT current_timestamp(),
  `creat_de` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_subiect_categorie` (`categorie_id`),
  KEY `fk_subiect_user` (`creat_de`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT 10,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `verification_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Constrângeri pentru tabele eliminate
--

--
-- Constrângeri pentru tabele `categorie`
--
ALTER TABLE `categorie`
  ADD CONSTRAINT `fk_categorie_forum` FOREIGN KEY (`forum_id`) REFERENCES `forum` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_categorie_user` FOREIGN KEY (`creat_de`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constrângeri pentru tabele `forum_abonament`
--
ALTER TABLE `forum_abonament`
  ADD CONSTRAINT `fk_abonament_subiect` FOREIGN KEY (`ab_subiect_id`) REFERENCES `subiect` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constrângeri pentru tabele `forum_documente`
--
ALTER TABLE `forum_documente`
  ADD CONSTRAINT `fk_document_postare` FOREIGN KEY (`postare_id`) REFERENCES `postare` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constrângeri pentru tabele `forum_vizualizari`
--
ALTER TABLE `forum_vizualizari`
  ADD CONSTRAINT `fk_vizualizare_categorie` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_vizualizare_forum` FOREIGN KEY (`forum_id`) REFERENCES `forum` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_vizualizare_subiect` FOREIGN KEY (`subiect_id`) REFERENCES `subiect` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constrângeri pentru tabele `postare`
--
ALTER TABLE `postare`
  ADD CONSTRAINT `fk_postare_subiect` FOREIGN KEY (`subiect_id`) REFERENCES `subiect` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_postare_user` FOREIGN KEY (`creat_de`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constrângeri pentru tabele `subiect`
--
ALTER TABLE `subiect`
  ADD CONSTRAINT `fk_subiect_categorie` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_subiect_user` FOREIGN KEY (`creat_de`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
