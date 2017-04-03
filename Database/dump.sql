-- MySQL dump 10.13  Distrib 5.7.11, for Win32 (AMD64)
--
-- Host: 127.0.0.1    Database: news
-- ------------------------------------------------------
-- Server version	5.7.11

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `T_MEM_memberc`
--

DROP TABLE IF EXISTS `T_MEM_memberc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `T_MEM_memberc` (
  `MEM_id` int(11) NOT NULL AUTO_INCREMENT,
  `MEM_fk_MRC` int(11) NOT NULL DEFAULT '2',
  `MEM_firstname` varchar(255) NOT NULL,
  `MEM_lastname` varchar(255) NOT NULL,
  `MEM_email` varchar(255) DEFAULT NULL,
  `MEM_username` varchar(30) NOT NULL,
  `MEM_password` varchar(255) NOT NULL,
  `MEM_birthdate` date DEFAULT NULL,
  `MEM_dateregister` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`MEM_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='Liste des membres';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `T_MEM_memberc`
--

LOCK TABLES `T_MEM_memberc` WRITE;
INSERT INTO `T_MEM_memberc` VALUES (1,2,'Tom','Pape','t.pape@dreamcentury.com','tpape','mdp','1995-03-03','2017-03-01 15:36:15'),(2,1,'Super','Admin','admin@dreamcentury.com','admin','mdp','2017-03-23','2017-02-28 15:37:09'),(7,2,'Guillaume','Stenek','g.stenek@dreamcentury.com','gstenek','pass','1994-07-31','2017-03-22 11:38:16'),(8,2,'Clément','Moulia','c.moulia@dreamcentury.com','cmoulia','pass','2017-03-23','2017-03-22 11:43:24'),(10,2,'prenom','nom','a@a.com','mat','mdp','2017-03-24','2017-03-23 18:23:00'),(12,2,'Prénom','Nom','a@b.com','user','password','2017-03-24','2017-03-24 10:14:32'),(13,2,'Firstname','Lastname','a@c.com','newuser','pass','2017-03-24','2017-03-24 10:51:37'),(14,2,'Pre','Nom','b@a.com','newtest','mdp','2017-03-27','2017-03-24 10:56:42');
UNLOCK TABLES;

--
-- Table structure for table `T_MEM_rolec`
--

DROP TABLE IF EXISTS `T_MEM_rolec`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `T_MEM_rolec` (
  `MRC_id` int(11) NOT NULL AUTO_INCREMENT,
  `MRC_name` varchar(50) NOT NULL,
  `MRC_description` varchar(500) NOT NULL,
  PRIMARY KEY (`MRC_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `T_MEM_rolec`
--

LOCK TABLES `T_MEM_rolec` WRITE;
INSERT INTO `T_MEM_rolec` VALUES (1,'admin','Tous les droits'),(2,'user','Ajout de news, et édition');
UNLOCK TABLES;

--
-- Table structure for table `T_NEW_commentc`
--

DROP TABLE IF EXISTS `T_NEW_commentc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `T_NEW_commentc` (
  `NCC_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `NCC_fk_NNC` smallint(6) NOT NULL,
  `NCC_author` varchar(50) DEFAULT NULL,
  `NCC_fk_MEM_author` int(11) DEFAULT NULL,
  `NCC_fk_MEM_admin` int(11) DEFAULT NULL,
  `NCC_content` text NOT NULL,
  `NCC_dateadd` datetime NOT NULL,
  `NCC_dateupdate` datetime DEFAULT NULL,
  PRIMARY KEY (`NCC_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8038 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `T_NEW_commentc`
--

LOCK TABLES `T_NEW_commentc` WRITE;
INSERT INTO `T_NEW_commentc` VALUES (1,5,'Tom',NULL,NULL,'Commentaire','2017-02-28 17:09:12',NULL),(2,5,'Tom',NULL,NULL,'Commentaire','2017-03-21 07:31:38',NULL),(7707,6,'tpape\'',NULL,NULL,'fegfr','2017-03-24 14:35:07',NULL),(7962,16,'gsgtr',NULL,2,'grsgrgp123456','2017-03-29 13:17:36','2017-03-30 08:55:46'),(7995,16,NULL,2,2,'grgsgfd','2017-03-30 10:08:44','2017-03-30 10:15:52'),(7999,16,NULL,2,2,'nouveaucommentaire','2017-03-30 10:23:45','2017-03-30 10:37:05'),(8011,16,'auteur',NULL,NULL,'commentaire','2017-03-30 12:42:43',NULL),(8036,16,NULL,2,NULL,'fbf','2017-03-30 14:40:52',NULL),(8037,16,NULL,1,NULL,'frsgr','2017-03-30 16:39:41',NULL);
UNLOCK TABLES;

--
-- Table structure for table `T_NEW_newsc`
--

DROP TABLE IF EXISTS `T_NEW_newsc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `T_NEW_newsc` (
  `NNC_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `NNC_fk_MEM_author` int(11) NOT NULL,
  `NNC_fk_MEM_admin` int(11) DEFAULT NULL,
  `NNC_title` varchar(100) NOT NULL,
  `NNC_content` text NOT NULL,
  `NNC_dateadd` datetime NOT NULL,
  `NNC_dateupdate` datetime NOT NULL,
  PRIMARY KEY (`NNC_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `T_NEW_newsc`
--

LOCK TABLES `T_NEW_newsc` WRITE;
INSERT INTO `T_NEW_newsc` VALUES (1,1,NULL,'Top 5 des façons les plus marrantes de se fail en PHP','Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.','2017-02-28 14:32:56','2017-02-28 14:32:56'),(2,2,NULL,'Vous n\'en croirai pas vos yeux lorsque vous découvrirez comment cet homme à ','Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.','2017-02-28 14:32:56','2017-02-28 14:32:56'),(3,7,NULL,'TITRE ACCROCHEUR : L’ASTUCE INFAILLIBLE (LA DIX VA VOUS FAIRE PLEURER)','Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.','2017-02-28 14:32:56','2017-02-28 14:32:56'),(4,8,NULL,'26 choses qui parleront à tous ceux qui ont bossé en centre d’appels','Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.','2017-02-28 14:32:56','2017-02-28 14:32:56'),(5,7,NULL,'L’incroyable road trip de 111 jours d’une famille de l’Inde jusqu’à la France','Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.','2017-02-28 14:32:56','2017-02-28 14:32:56'),(6,2,2,'News','Contenu','2017-03-23 09:39:34','2017-03-23 12:07:18'),(16,1,2,'gregeg','bttbtrb','2017-03-24 14:52:15','2017-03-24 16:41:51');
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-03-31 18:06:38
