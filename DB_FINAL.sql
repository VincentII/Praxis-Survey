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
INSERT INTO `admin` VALUES (1,'Tuesday','9bd76ce7ce133994c4c4cc2488049d61',0),(2,'Reyanna','f6fdffe48c908deb0f4c3bd36c032e72',0);
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
  `Question_ID` int(11) DEFAULT NULL,
  `Set_ID` int(11) DEFAULT NULL,
  `Event_ID` int(11) DEFAULT NULL,
  `Question_ans` int(11) DEFAULT NULL,
  PRIMARY KEY (`Answer_ID`),
  KEY `fkset_idx` (`Set_ID`),
  KEY `fkevent_idx` (`Event_ID`),
  CONSTRAINT `fkevent` FOREIGN KEY (`Event_ID`) REFERENCES `event` (`Event_ID`) ON DELETE CASCADE,
  CONSTRAINT `fkset` FOREIGN KEY (`Set_ID`) REFERENCES `question_set` (`Set_ID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `answers`
--

LOCK TABLES `answers` WRITE;
/*!40000 ALTER TABLE `answers` DISABLE KEYS */;
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
  `Event_Name` varchar(45) DEFAULT NULL,
  `Event_Location` varchar(45) DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `is_closed` int(11) DEFAULT '1',
  `is_archived` int(11) DEFAULT '0',
  `markedfordelete` int(11) DEFAULT '0',
  PRIMARY KEY (`Event_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event`
--

LOCK TABLES `event` WRITE;
/*!40000 ALTER TABLE `event` DISABLE KEYS */;
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
  `is_closed` int(11) NOT NULL DEFAULT '0',
  `is_archived` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Set_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question_set`
--

LOCK TABLES `question_set` WRITE;
/*!40000 ALTER TABLE `question_set` DISABLE KEYS */;
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
/*!40000 ALTER TABLE `questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `url`
--

DROP TABLE IF EXISTS `url`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `url` (
  `URL_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Event_ID` int(11) DEFAULT NULL,
  `Set_ID` int(11) DEFAULT NULL,
  `URL` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`URL_ID`),
  UNIQUE KEY `URL_UNIQUE` (`URL`),
  KEY `fk_event_idx` (`Event_ID`),
  KEY `fk_set_idx` (`Set_ID`),
  CONSTRAINT `fk_event` FOREIGN KEY (`Event_ID`) REFERENCES `event` (`Event_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_set` FOREIGN KEY (`Set_ID`) REFERENCES `question_set` (`Set_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `url`
--

LOCK TABLES `url` WRITE;
/*!40000 ALTER TABLE `url` DISABLE KEYS */;
/*!40000 ALTER TABLE `url` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `User_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(45) DEFAULT 'No Name',
  `Email` varchar(45) DEFAULT 'No Email',
  `Mobile` varchar(45) DEFAULT 'No Number',
  PRIMARY KEY (`User_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
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

-- Dump completed on 2017-03-14  9:30:20
