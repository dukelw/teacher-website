-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: teacherweb
-- ------------------------------------------------------
-- Server version	8.0.36

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
<<<<<<<< HEAD:dbteacher/teacherweb_doccategory.sql
-- Table structure for table `doccategory`
--

DROP TABLE IF EXISTS `doccategory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `doccategory` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `CATENAME` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
========
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comment` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `content` longtext NOT NULL,
  `parentID` int DEFAULT NULL,
  `userID` int DEFAULT NULL,
  `createAt` datetime DEFAULT NULL,
  `likeNum` int DEFAULT NULL,
  `dislikeNum` int DEFAULT NULL,
  `titleID` int DEFAULT NULL,
>>>>>>>> 9b4429fce416c2a5121b3e0415153fe9f91720ca:dbteacher/teacherweb_comment.sql
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
<<<<<<<< HEAD:dbteacher/teacherweb_doccategory.sql
-- Dumping data for table `doccategory`
--

LOCK TABLES `doccategory` WRITE;
/*!40000 ALTER TABLE `doccategory` DISABLE KEYS */;
INSERT INTO `doccategory` VALUES (1,'Báo cáo');
/*!40000 ALTER TABLE `doccategory` ENABLE KEYS */;
========
-- Dumping data for table `comment`
--

LOCK TABLES `comment` WRITE;
/*!40000 ALTER TABLE `comment` DISABLE KEYS */;
INSERT INTO `comment` VALUES (12,'See you later',11,1,'2024-05-07 00:00:00',0,0,19),(20,'Bonjour',19,1,'2024-05-07 00:00:00',0,0,19),(42,'Hello',-1,1,'2024-05-07 22:59:45',0,0,19),(43,'Hi',42,1,'2024-05-07 22:59:48',0,0,19),(44,'Bonjout',-1,1,'2024-05-07 23:01:54',0,0,2),(45,'Bonjour',44,1,'2024-05-07 23:02:03',0,0,2);
/*!40000 ALTER TABLE `comment` ENABLE KEYS */;
>>>>>>>> 9b4429fce416c2a5121b3e0415153fe9f91720ca:dbteacher/teacherweb_comment.sql
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

<<<<<<<< HEAD:dbteacher/teacherweb_doccategory.sql
-- Dump completed on 2024-05-07 23:21:03
========
-- Dump completed on 2024-05-07 23:11:12
>>>>>>>> 9b4429fce416c2a5121b3e0415153fe9f91720ca:dbteacher/teacherweb_comment.sql
