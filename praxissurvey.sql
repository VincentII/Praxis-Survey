CREATE DATABASE  IF NOT EXISTS `praxissurvey` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `praxissurvey`;
-- MySQL dump 10.13  Distrib 5.7.12, for Win64 (x86_64)
--
-- Host: localhost    Database: praxissurvey
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.16-MariaDB

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
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `Admin_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(45) NOT NULL,
  `Password` varchar(45) NOT NULL,
  `Admin_Type` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Admin_ID`),
  UNIQUE KEY `Username_UNIQUE` (`Username`),
  UNIQUE KEY `ID_admin_UNIQUE` (`Admin_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,'Tuesday','Friday',0),(2,'Reyanna','Chuckie',0);
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `answers`
--

DROP TABLE IF EXISTS `answers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `answers` (
  `Answer_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Question_ID` int(11) NOT NULL,
  `Set_ID` int(11) NOT NULL,
  `Event_ID` int(11) NOT NULL,
  `Question_Ans` int(11) NOT NULL,
  PRIMARY KEY (`Answer_ID`),
  KEY `set_idx` (`Set_ID`),
  KEY `event_idx` (`Event_ID`),
  KEY `setfk_idx` (`Set_ID`),
  KEY `eventfk_idx` (`Event_ID`),
  CONSTRAINT `eventfk` FOREIGN KEY (`Event_ID`) REFERENCES `event` (`Event_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `setfk` FOREIGN KEY (`Set_ID`) REFERENCES `question_set` (`Set_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=113 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `answers`
--

LOCK TABLES `answers` WRITE;
/*!40000 ALTER TABLE `answers` DISABLE KEYS */;
INSERT INTO `answers` VALUES (1,24,4,1,5),(2,25,4,1,5),(3,26,4,1,5),(4,27,4,1,3),(5,28,4,1,3),(6,24,4,2,2),(7,24,4,2,4),(8,24,4,1,3),(9,25,4,1,5),(10,26,4,1,3),(11,27,4,1,4),(12,28,4,1,2),(13,24,4,1,5),(14,25,4,1,4),(15,26,4,1,1),(16,27,4,1,4),(17,28,4,1,1),(18,24,4,1,1),(19,25,4,1,3),(20,26,4,1,4),(21,27,4,1,5),(22,28,4,1,3),(23,24,4,1,1),(24,25,4,1,3),(25,26,4,1,4),(26,27,4,1,5),(27,28,4,1,3),(28,24,4,1,3),(29,25,4,1,5),(30,26,4,1,3),(31,27,4,1,4),(32,28,4,1,4),(33,24,4,1,5),(34,25,4,1,3),(35,26,4,1,3),(36,27,4,1,5),(37,28,4,1,3),(38,24,4,1,4),(39,25,4,1,5),(40,26,4,1,3),(41,27,4,1,5),(42,28,4,1,3),(43,24,4,3,1),(44,25,4,3,1),(45,26,4,3,1),(46,27,4,3,1),(47,28,4,3,1),(48,24,4,3,1),(49,25,4,3,1),(50,26,4,3,1),(51,27,4,3,1),(52,28,4,3,3),(53,24,4,3,1),(54,25,4,3,1),(55,26,4,3,1),(56,27,4,3,1),(57,28,4,3,3),(58,24,4,3,4),(59,25,4,3,3),(60,26,4,3,4),(61,27,4,3,3),(62,28,4,3,4),(63,24,4,3,4),(64,25,4,3,3),(65,26,4,3,4),(66,27,4,3,3),(67,28,4,3,4),(68,24,4,3,4),(69,25,4,3,3),(70,26,4,3,4),(71,27,4,3,3),(72,28,4,3,4),(73,24,4,3,4),(74,25,4,3,3),(75,26,4,3,4),(76,27,4,3,3),(77,28,4,3,4),(78,24,4,3,4),(79,25,4,3,3),(80,26,4,3,4),(81,27,4,3,3),(82,28,4,3,4),(83,24,4,3,4),(84,25,4,3,3),(85,26,4,3,4),(86,27,4,3,3),(87,28,4,3,4),(88,24,4,3,5),(89,25,4,3,3),(90,26,4,3,4),(91,27,4,3,3),(92,28,4,3,5),(93,24,4,3,3),(94,25,4,3,5),(95,26,4,3,3),(96,27,4,3,4),(97,28,4,3,2),(98,24,4,3,3),(99,25,4,3,5),(100,26,4,3,3),(101,27,4,3,4),(102,28,4,3,2),(103,24,4,3,3),(104,25,4,3,5),(105,26,4,3,3),(106,27,4,3,4),(107,28,4,3,2),(108,24,4,3,3),(109,25,4,3,5),(110,26,4,3,3),(111,27,4,3,4),(112,28,4,3,2);
/*!40000 ALTER TABLE `answers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comment` (
  `Comment_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Event_ID` int(11) NOT NULL,
  `Set_ID` int(11) NOT NULL,
  `Comment_Ans` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`Comment_ID`),
  KEY `event_idx` (`Event_ID`),
  KEY `set_idx` (`Set_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comment`
--

LOCK TABLES `comment` WRITE;
/*!40000 ALTER TABLE `comment` DISABLE KEYS */;
INSERT INTO `comment` VALUES (1,1,1,'So cool!'),(2,1,4,'Lost my way!'),(3,3,4,' '),(4,3,4,'ñ'),(5,3,4,'www'),(6,3,4,'   www'),(7,3,4,'Llanfairpwllgwyngyllgogerychwyrndrobwll-llantysiliogogogoch'),(8,3,4,'Llanfairpwllgwyngyllgogerychwyrndrobwllllantysiliogogogoch'),(9,3,4,'wwww'),(10,3,4,'    wwww');
/*!40000 ALTER TABLE `comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event`
--

DROP TABLE IF EXISTS `event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event` (
  `Event_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Event_Name` varchar(45) NOT NULL,
  `Event_Location` varchar(45) NOT NULL,
  `event_date` date NOT NULL,
  `is_closed` int(11) NOT NULL DEFAULT '1',
  `is_archived` int(11) NOT NULL DEFAULT '1',
  `markedfordelete` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Event_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event`
--

LOCK TABLES `event` WRITE;
/*!40000 ALTER TABLE `event` DISABLE KEYS */;
INSERT INTO `event` VALUES (1,'PRU Life Praxis','Makati','2017-02-01',0,0,0),(2,'Sun Life Praxis','Makati','2017-02-01',1,0,0),(3,'Cafe Session','Makati','2017-02-02',0,0,0);
/*!40000 ALTER TABLE `event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question_set`
--

DROP TABLE IF EXISTS `question_set`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question_set` (
  `Set_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Question_Set_Description` varchar(45) NOT NULL,
  PRIMARY KEY (`Set_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question_set`
--

LOCK TABLES `question_set` WRITE;
/*!40000 ALTER TABLE `question_set` DISABLE KEYS */;
INSERT INTO `question_set` VALUES (1,'Pre-game Survey'),(2,'Post-game Survey'),(3,'End of the Day Survey'),(4,'Main Questions');
/*!40000 ALTER TABLE `question_set` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `questions` (
  `question_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Set_ID` int(11) NOT NULL,
  `Question_Num` int(11) NOT NULL,
  `Question_Act` varchar(300) NOT NULL,
  PRIMARY KEY (`question_ID`),
  KEY `Set_idx` (`Set_ID`),
  KEY `question_idx` (`Question_Num`),
  CONSTRAINT `Set` FOREIGN KEY (`Set_ID`) REFERENCES `question_set` (`Set_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `question` FOREIGN KEY (`Question_Num`) REFERENCES `questions` (`question_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questions`
--

LOCK TABLES `questions` WRITE;
/*!40000 ALTER TABLE `questions` DISABLE KEYS */;
INSERT INTO `questions` VALUES (1,1,1,'My financial knowledge is enough for me to manage my income and wealth.'),(2,1,2,'I understand business cycles and their effect on my finance and the economy.'),(3,1,3,'I have a good understanding how risk and reward are linked.'),(4,1,4,'I understand how insurance works.'),(5,1,5,'I understand why people need to save for the long and short term.'),(6,1,6,'I understand how stock markets and unit-linked policies work.'),(7,1,7,'I understand how financial products can benefit me and my family.'),(8,1,8,'I feel that I can talk knowledgeably about finance to others.'),(9,2,1,'My financial knowledge is enough for me to manage my income and wealth.'),(10,2,2,'I understand business cycles and their effect on my finance and the economy.'),(11,2,3,'I have a good understanding how risk and reward are linked.'),(12,2,4,'I understand how insurance works.'),(13,2,5,'I understand why people need to save for the long and short term.'),(14,2,6,'I understand how stock markets and unit-linked policies work.'),(15,2,7,'I understand how financial products can benefit me and my family.'),(16,2,8,'I feel that I can talk knowledgeably about finance to others.'),(17,3,1,'I learned a lot about general financial principles and products through Praxis gameplay.'),(18,3,2,'Including Praxis in new staff agent training will make the training more interesting and attractive.'),(19,3,3,'Praxis is an interesting and innovative way to introduce financial principles and products to staff, agents, partners and customers.'),(20,3,4,'I think Praxis is very effective for building our brand as a company that provides financial education to its stakeholders.'),(21,3,5,'After the Praxis training, I feel very confident about being a GameFaster.'),(22,3,6,'I would like to have more training or practice before I conduct my first gameplay.'),(23,3,7,'The Praxis training session was well conducted by the SMFM team.'),(24,4,1,'I think I did well in the game.'),(25,4,2,'I enjoyed the game.'),(26,4,3,'I learned something new by playing the game.'),(27,4,4,'I would like to play this game again.'),(28,4,5,'The game made me act today to change my financial future.');
/*!40000 ALTER TABLE `questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `User_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(45) DEFAULT NULL,
  `Email` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`User_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-02-15 15:02:46
