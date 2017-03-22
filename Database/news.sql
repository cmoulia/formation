-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mer 22 Mars 2017 à 17:05
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
(2, 1, 'Admin', 'Super', 'admin@dreamcentury.com', 'admin', 'mdp', '1971-03-18', '2017-02-28 15:37:09'),
(7, 2, 'Guillaume', 'Stenek', 'g.stenek@dreamcentury.com', 'gstenek', 'pass', '1994-07-31', '2017-03-22 11:38:16'),
(8, 2, 'Clément', 'Moulia', 'c.moulia@dce.com', 'cmoulia', 'pass', '1994-07-29', '2017-03-22 11:43:24');

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
  `NCC_author` varchar(50) NOT NULL,
  `NCC_content` text NOT NULL,
  `NCC_dateadd` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `T_NEW_commentc`
--

INSERT INTO `T_NEW_commentc` (`NCC_id`, `NCC_fk_NNC`, `NCC_author`, `NCC_content`, `NCC_dateadd`) VALUES
(2, 5, 'Tom', 'Commentaire', '2017-02-28 17:09:12'),
(3, 5, 'Tom', 'Commentaire', '2017-03-21 07:31:38'),
(4, 4, 'Benito', 'e65514ad65a38bc8962a7a11330b8aa0', '2017-02-14 10:29:30'),
(5, 4, 'c4eb1374', 'c4eb13a9-fe62-11e6-a', '2017-02-26 10:38:04'),
(6, 3, '0d4b329e', '0d4b32bc-fe63-11e6-a', '2017-02-16 10:40:06'),
(7, 1, '15a6d489', '15a6d4a7-fe63-11e6-a', '2017-02-19 10:40:20'),
(8, 5, '16ee442b', '8e993d496e1abf08af240765cf9b7ca3d69491e0', '2017-02-18 10:47:31'),
(9, 5, '2b459414', '748369de3ce2ddc7e457c485ae186be5090bfc01', '2017-02-23 10:48:05'),
(10, 1, '2b459643', '9121926475ba86a6291bcec584229e262a6ec839', '2017-02-23 10:48:05'),
(11, 1, '2b4596e6', '704e7306311edcc5c3469a67bf1e261ab2fbfbcc', '2017-02-28 10:48:05'),
(12, 4, '2b45973f', '80e2619cd1aa1c5b28cbc3cdb1a42bde91eccc1e', '2017-02-28 10:48:05'),
(13, 4, '2b459795', 'd7f62532ae881da211dcb99378eb98eea4d41a31', '2017-02-21 10:48:05'),
(14, 4, '2b4597eb', '4343a6a30c0b637ace34269912e8568628c49d55', '2017-02-18 10:48:05'),
(15, 5, '2b45983e', '44b35f46a93ddad0d69f43f2e27bad4d1f57f640', '2017-02-22 10:48:05'),
(1142, 4, 'ad2932234b5cec7bd2e9d08ea5e0fd27', 'e68718ec2b5e5e73f0a26f1f3495b701f6cafbf5', '2017-03-01 08:03:32'),
(1766, 4, 'db20251ad08dc8872f1da69a5a3cd8f4', 'bd64786b775835174d1902f8df48e1d09f344cda', '2017-02-23 08:12:12'),
(1876, 4, 'bf631ec851038acd8af70d28491cd243', 'a55a9ba0dcabac21f460d8a3c4732a100015913f', '2017-02-13 08:43:47'),
(2202, 4, 'f690edfacad2a681e9e369a55546ba86', 'd98256e082f6a1383018724154ee5a3c8ae81a37', '2017-02-10 08:38:22'),
(2260, 3, '52a8183aa930d913e1bbff9f3a078ef9', '54f5e7277f440bf8371c97d2526e828cdf2c506c', '2017-02-26 08:41:48'),
(2385, 5, 'f173c809869acd11a498dee73b71f121', '62d3ee5482539346e35247ea665c26176150bf18', '2017-02-05 10:05:56'),
(2536, 1, '46032e1bfabe1735d1cd9146590dd681', 'cda7f9021a3c512fc6be30750c60422ba7691955', '2017-02-10 10:17:05'),
(2674, 2, '11e232513ba42a412167fb94bf922769', 'ddcc73bebf606e7277d809726613c2eaea3003c8', '2017-02-27 09:14:07'),
(2704, 4, '337ad061c7e4b701716b6414b7d013c4', '20c967660b0ee9a33caa0cd075c87d1fb5280b34', '2017-02-03 08:15:47'),
(2705, 4, 'f42fdd8f92dafdd5f9bc0f25af07cffa', '22a58115ad59d00199dfddb7dd55c8576aaa28d2', '2017-02-08 09:48:06'),
(2937, 2, '99673927f44d8230c16ad9eabd2afe24', '3f766abf538212cf6e79c3c0ed00946826b09b3b', '2017-02-25 08:46:30'),
(3749, 5, '74dd5dd96223eb636070fed0ca55df5c', 'a176c3a1c18e14dde59d4126dc9bb8f2879caefe', '2017-02-07 09:45:05'),
(4088, 2, 'c17b05bfd8a2d697b0d2c9fc9258e2be', '19f501a6adf41c7913ed7f1f24d7e5248efdaf44', '2017-02-12 08:02:16'),
(4291, 1, '2d46ab927cc1d04c3f76d6c9ecd50e32', 'cdeb8bd5e4871e72e4474f46ca22f0dcbafeb6b0', '2017-02-17 10:05:49'),
(4316, 5, '381a5faebfd79f15b8e88ccac3171589', '5374a75ff6de0df8a8cbc0a5b02f777b1a329eda', '2017-02-14 09:41:20'),
(4531, 2, '643aba9344aedd2656a54e866783e32d', '2cc1b5fd95406c4acb1ebf0769f4d5b9ea14d8f4', '2017-02-13 08:05:50'),
(4792, 3, '9ccce947271cd0600ad9d26c3aacd218', '80d57af6cff80085a7f5c6f43cf272f713e416c5', '2017-03-01 09:08:14'),
(4809, 1, '81df2babdd251815a8b337069ff25c29', 'e2a57a3a5ca0728dbf8c00edcbd156fe23fd6da0', '2017-02-05 09:39:17'),
(5390, 1, 'ac3e1943a4513d73d384dce5265dfac8', '404c74227263a87588b10f1a753d7740cceb20cc', '2017-02-27 10:01:32'),
(5551, 4, 'b833022903b62fd82e0f47fb8d1d3ecf', '531aedfebd78fc01922b9e2e0c49042860685a2c', '2017-03-01 08:08:06'),
(5577, 3, '0ae656328b1d1161754baf73aef1f9ae', 'cb759f426da9b80f75808fbe5e096ff03e5f73ef', '2017-02-01 10:41:49'),
(5592, 1, 'ef6883dd3b9ebde56922d9341e9ca526', '4f03bc92c7612ce0f09fc0a8bb226bd6b6c6069b', '2017-02-11 10:07:14'),
(5725, 1, '6d9ad8fdaa8a5520f7a4678a800bda4d', 'fee354b63342823928773afc3bdc80a159629ae9', '2017-02-18 10:26:03'),
(5848, 5, '78410d07a470f940c18015320b3a68ea', 'acea2890045a35fd0e354bd3b9981252fea6cd0d', '2017-01-31 09:44:16'),
(5922, 4, '2f62a4ef35ef4065641d850352bae2f4', 'b77e74425496e1febb6a14a32316da1f12924379', '2017-02-03 08:05:10'),
(6568, 3, '8bfa5c5d6332cef9312c751e76ec46df', '5688873555c9e6f4fa738c3249811d8d213c1af7', '2017-02-02 10:02:36'),
(6914, 1, '4f708c41f296e409bad89ef101d3d114', '0fca455d3fb433d5f4dcd12531d3763d769d2f9a', '2017-02-05 10:05:32'),
(7073, 4, 'ffc37eed69015292d57a149bb6364f9e', '6e110f60e5324783f35955580a596c7ccd70394c', '2017-03-01 08:30:41'),
(7074, 1, '0ec8fc45c341456110f372b67a5f9d41', '44703085fd629f12ce80c256d2df74e450881249', '2017-02-26 08:26:36'),
(7430, 5, '469f3a9e9a3661c20f4d33f585a5cb78', '3f4ac11d9c27617341969669658c11065ad69a15', '2017-02-16 10:13:34'),
(7674, 1, 'az', 'az', '2017-03-22 16:58:48');

-- --------------------------------------------------------

--
-- Structure de la table `T_NEW_newsc`
--

DROP TABLE IF EXISTS `T_NEW_newsc`;
CREATE TABLE `T_NEW_newsc` (
  `NNC_id` smallint(5) UNSIGNED NOT NULL,
  `NNC_author` varchar(30) NOT NULL,
  `NNC_title` varchar(100) NOT NULL,
  `NNC_content` text NOT NULL,
  `NNC_dateadd` datetime NOT NULL,
  `NNC_dateupdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `T_NEW_newsc`
--

INSERT INTO `T_NEW_newsc` (`NNC_id`, `NNC_author`, `NNC_title`, `NNC_content`, `NNC_dateadd`, `NNC_dateupdate`) VALUES
(1, 'Journaliste 1', 'Top 5 des façons les plus marrantes de se fail en PHP', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2017-02-28 14:32:56', '2017-02-28 14:32:56'),
(2, 'Journaliste 2', 'Vous n\'en croirai pas vos yeux lorsque vous découvrirez comment cet homme à ', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2017-02-28 14:32:56', '2017-02-28 14:32:56'),
(3, 'Journaliste 3', 'TITRE ACCROCHEUR : L’ASTUCE INFAILLIBLE (LA DIX VA VOUS FAIRE PLEURER)', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2017-02-28 14:32:56', '2017-02-28 14:32:56'),
(4, 'Journaliste 3', '26 choses qui parleront à tous ceux qui ont bossé en centre d’appels', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2017-02-28 14:32:56', '2017-02-28 14:32:56'),
(5, 'Journaliste 4', 'L’incroyable road trip de 111 jours d’une famille de l’Inde jusqu’à la France', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2017-02-28 14:32:56', '2017-02-28 14:32:56');

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
  MODIFY `MEM_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT pour la table `T_MEM_rolec`
--
ALTER TABLE `T_MEM_rolec`
  MODIFY `MRC_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `T_NEW_commentc`
--
ALTER TABLE `T_NEW_commentc`
  MODIFY `NCC_id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7677;
--
-- AUTO_INCREMENT pour la table `T_NEW_newsc`
--
ALTER TABLE `T_NEW_newsc`
  MODIFY `NNC_id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1656;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
