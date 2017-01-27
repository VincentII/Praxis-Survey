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
-- Table structure for table `answers`
--

DROP TABLE IF EXISTS `answers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `answers` (
  `Question_ID` int(11) NOT NULL,
  `Set_ID` varchar(45) NOT NULL,
  `Event_ID` int(11) NOT NULL,
  `Question_Ans` int(11) NOT NULL,
  PRIMARY KEY (`Question_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
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
  `Comment_ID` int(11) NOT NULL,
  `Set_ID` varchar(45) NOT NULL,
  `Comment` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`Comment_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
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
  `Event_id` int(11) NOT NULL,
  `Event_Name` varchar(45) NOT NULL,
  `Location` varchar(45) NOT NULL,
  `event_date` date DEFAULT NULL,
  PRIMARY KEY (`Event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
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
  `Set_ID` int(11) NOT NULL,
  `Question_Set_Description` varchar(45) NOT NULL,
  PRIMARY KEY (`Set_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
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
  `question_ID` int(11) NOT NULL,
  `Set_ID` int(11) NOT NULL,
  `Question_Num` int(11) NOT NULL,
  `Question_Act` varchar(300) NOT NULL,
  PRIMARY KEY (`question_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
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
  `User_ID` int(11) NOT NULL,
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

-- Dump completed on 2017-01-27 10:55:39
