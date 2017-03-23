-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Jeu 23 Mars 2017 à 16:06
-- Version du serveur :  5.7.11
-- Version de PHP :  5.6.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `news`
--
CREATE DATABASE IF NOT EXISTS `news` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `news`;

-- --------------------------------------------------------

--
-- Structure de la table `T_MEM_memberc`
--

DROP TABLE IF EXISTS `T_MEM_memberc`;
CREATE TABLE `T_MEM_memberc` (
  `MEM_id` int(11) NOT NULL,
  `MEM_fk_MRC` int(11) NOT NULL DEFAULT '2',
  `MEM_firstname` varchar(255) NOT NULL,
  `MEM_lastname` varchar(255) NOT NULL,
  `MEM_email` varchar(255) DEFAULT NULL,
  `MEM_username` varchar(30) NOT NULL,
  `MEM_password` varchar(255) NOT NULL,
  `MEM_birthdate` date DEFAULT NULL,
  `MEM_dateregister` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Liste des membres';

--
-- Contenu de la table `T_MEM_memberc`
--

INSERT INTO `T_MEM_memberc` (`MEM_id`, `MEM_fk_MRC`, `MEM_firstname`, `MEM_lastname`, `MEM_email`, `MEM_username`, `MEM_password`, `MEM_birthdate`, `MEM_dateregister`) VALUES
(1, 2, 'Tom', 'Pape', 't.pape@dreamcentury.com', 'tpape', 'mdp', '1995-03-03', '2017-03-01 15:36:15'),
(2, 1, 'Super', 'Admin', 'admin@dreamcentury.com', 'admin', 'mdp', '2017-03-23', '2017-02-28 15:37:09'),
(7, 2, 'Guillaume', 'Stenek', 'g.stenek@dreamcentury.com', 'gstenek', 'pass', '1994-07-31', '2017-03-22 11:38:16'),
(8, 2, 'Clément', 'Moulia', 'c.moulia@dreamcentury.com', 'cmoulia', 'pass', '2017-03-23', '2017-03-22 11:43:24');

-- --------------------------------------------------------

--
-- Structure de la table `T_MEM_rolec`
--

DROP TABLE IF EXISTS `T_MEM_rolec`;
CREATE TABLE `T_MEM_rolec` (
  `MRC_id` int(11) NOT NULL,
  `MRC_name` varchar(50) NOT NULL,
  `MRC_description` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `T_MEM_rolec`
--

INSERT INTO `T_MEM_rolec` (`MRC_id`, `MRC_name`, `MRC_description`) VALUES
(1, 'admin', 'Tous les droits'),
(2, 'user', 'Ajout de news, et édition');

-- --------------------------------------------------------

--
-- Structure de la table `T_NEW_commentc`
--

DROP TABLE IF EXISTS `T_NEW_commentc`;
CREATE TABLE `T_NEW_commentc` (
  `NCC_id` mediumint(9) NOT NULL,
  `NCC_fk_NNC` smallint(6) NOT NULL,
  `NCC_author` varchar(50) DEFAULT NULL,
  `NCC_fk_MEM_author` int(11) DEFAULT NULL,
  `NCC_fk_MEM_admin` int(11) DEFAULT NULL,
  `NCC_content` text NOT NULL,
  `NCC_dateadd` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `T_NEW_commentc`
--

INSERT INTO `T_NEW_commentc` (`NCC_id`, `NCC_fk_NNC`, `NCC_author`, `NCC_fk_MEM_author`, `NCC_fk_MEM_admin`, `NCC_content`, `NCC_dateadd`) VALUES
(1, 5, 'Tom', NULL, NULL, 'Commentaire', '2017-02-28 17:09:12'),
(2, 5, 'Tom', NULL, NULL, 'Commentaire', '2017-03-21 07:31:38'),
(3, 7, 'tpape', NULL, NULL, 'commentaire', '2017-03-23 10:22:07'),
(4, 7, 'notlogged', NULL, NULL, 'commentaire po intéressant', '2017-03-23 10:36:13'),
(5, 8, 'tpape', NULL, NULL, 'content', '2017-03-23 12:27:32'),
(6, 0, 'tpape', NULL, NULL, 'content2', '2017-03-23 12:35:04'),
(7682, 8, 'mrtest', NULL, NULL, 'contenutest', '2017-03-23 13:59:17'),
(7687, 8, 'tpapea', NULL, NULL, 't', '2017-03-23 14:15:09'),
(7697, 8, NULL, 1, NULL, 'ye', '2017-03-23 14:21:31');

-- --------------------------------------------------------

--
-- Structure de la table `T_NEW_newsc`
--

DROP TABLE IF EXISTS `T_NEW_newsc`;
CREATE TABLE `T_NEW_newsc` (
  `NNC_id` smallint(5) UNSIGNED NOT NULL,
  `NNC_fk_MEM_author` int(11) NOT NULL,
  `NNC_fk_MEM_admin` int(11) DEFAULT NULL,
  `NNC_title` varchar(100) NOT NULL,
  `NNC_content` text NOT NULL,
  `NNC_dateadd` datetime NOT NULL,
  `NNC_dateupdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `T_NEW_newsc`
--

INSERT INTO `T_NEW_newsc` (`NNC_id`, `NNC_fk_MEM_author`, `NNC_fk_MEM_admin`, `NNC_title`, `NNC_content`, `NNC_dateadd`, `NNC_dateupdate`) VALUES
(1, 1, NULL, 'Top 5 des façons les plus marrantes de se fail en PHP', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2017-02-28 14:32:56', '2017-02-28 14:32:56'),
(2, 2, NULL, 'Vous n\'en croirai pas vos yeux lorsque vous découvrirez comment cet homme à ', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2017-02-28 14:32:56', '2017-02-28 14:32:56'),
(3, 7, NULL, 'TITRE ACCROCHEUR : L’ASTUCE INFAILLIBLE (LA DIX VA VOUS FAIRE PLEURER)', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2017-02-28 14:32:56', '2017-02-28 14:32:56'),
(4, 8, NULL, '26 choses qui parleront à tous ceux qui ont bossé en centre d’appels', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2017-02-28 14:32:56', '2017-02-28 14:32:56'),
(5, 7, NULL, 'L’incroyable road trip de 111 jours d’une famille de l’Inde jusqu’à la France', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2017-02-28 14:32:56', '2017-02-28 14:32:56'),
(6, 2, 2, 'News', 'Contenu', '2017-03-23 09:39:34', '2017-03-23 12:07:18'),
(7, 1, 2, 'par tom', 'a modifier', '2017-03-23 10:06:02', '2017-03-23 12:08:54'),
(8, 1, NULL, 'testfk', 'contenu', '2017-03-23 12:12:38', '2017-03-23 12:12:38');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `T_MEM_memberc`
--
ALTER TABLE `T_MEM_memberc`
  ADD PRIMARY KEY (`MEM_id`);

--
-- Index pour la table `T_MEM_rolec`
--
ALTER TABLE `T_MEM_rolec`
  ADD PRIMARY KEY (`MRC_id`);

--
-- Index pour la table `T_NEW_commentc`
--
ALTER TABLE `T_NEW_commentc`
  ADD PRIMARY KEY (`NCC_id`);

--
-- Index pour la table `T_NEW_newsc`
--
ALTER TABLE `T_NEW_newsc`
  ADD PRIMARY KEY (`NNC_id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `T_MEM_memberc`
--
ALTER TABLE `T_MEM_memberc`
  MODIFY `MEM_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `T_MEM_rolec`
--
ALTER TABLE `T_MEM_rolec`
  MODIFY `MRC_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `T_NEW_commentc`
--
ALTER TABLE `T_NEW_commentc`
  MODIFY `NCC_id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7698;
--
-- AUTO_INCREMENT pour la table `T_NEW_newsc`
--
ALTER TABLE `T_NEW_newsc`
  MODIFY `NNC_id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
