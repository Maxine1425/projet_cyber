-- Adminer 4.8.1 MySQL 10.11.6-MariaDB-0+deb12u1 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `id_article` int(11) NOT NULL AUTO_INCREMENT,
  `auteur` varchar(50) NOT NULL,
  `nom_article` varchar(50) NOT NULL,
  `contenu` varchar(1000) NOT NULL,
  `image` blob DEFAULT NULL,
  `date_creation` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `compte_id` int(11) NOT NULL,
  `pdf` blob DEFAULT NULL,
  `zip` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_article`),
  KEY `compte_id` (`compte_id`),
  CONSTRAINT `article_ibfk_1` FOREIGN KEY (`compte_id`) REFERENCES `compte` (`id_compte`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `commentaire`;
CREATE TABLE `commentaire` (
  `id_commentaire` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `commentaire` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_commentaire`),
  KEY `article_id` (`article_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `commentaire_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `article` (`id_article`) ON DELETE CASCADE,
  CONSTRAINT `commentaire_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `compte` (`id_compte`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `compte`;
CREATE TABLE `compte` (
  `id_compte` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(50) NOT NULL,
  `password` varchar(200) NOT NULL,
  `mail` varchar(50) NOT NULL,
  PRIMARY KEY (`id_compte`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- 2024-12-18 16:53:56
