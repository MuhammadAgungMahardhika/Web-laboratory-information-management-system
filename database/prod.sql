-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: localhost    Database: web_simlhp
-- ------------------------------------------------------
-- Server version	8.0.37

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
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('jli_cache_spatie.permission.cache','a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:142:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";s:13:\"view-any-user\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:1;a:4:{s:1:\"a\";i:2;s:1:\"b\";s:9:\"view-user\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:2;a:4:{s:1:\"a\";i:3;s:1:\"b\";s:11:\"create-user\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:3;a:4:{s:1:\"a\";i:4;s:1:\"b\";s:11:\"update-user\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:4;a:4:{s:1:\"a\";i:5;s:1:\"b\";s:11:\"delete-user\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:5;a:4:{s:1:\"a\";i:6;s:1:\"b\";s:24:\"view-chart-role-personel\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:6;a:4:{s:1:\"a\";i:7;s:1:\"b\";s:17:\"view-any-personel\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:7;a:4:{s:1:\"a\";i:8;s:1:\"b\";s:13:\"view-personel\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:8;a:4:{s:1:\"a\";i:9;s:1:\"b\";s:15:\"create-personel\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:9;a:4:{s:1:\"a\";i:10;s:1:\"b\";s:15:\"update-personel\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:10;a:4:{s:1:\"a\";i:11;s:1:\"b\";s:15:\"delete-personel\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:11;a:4:{s:1:\"a\";i:12;s:1:\"b\";s:17:\"view-any-position\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:12;a:4:{s:1:\"a\";i:13;s:1:\"b\";s:13:\"view-position\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:13;a:4:{s:1:\"a\";i:14;s:1:\"b\";s:15:\"create-position\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:14;a:4:{s:1:\"a\";i:15;s:1:\"b\";s:15:\"update-position\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:15;a:4:{s:1:\"a\";i:16;s:1:\"b\";s:15:\"delete-position\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:16;a:4:{s:1:\"a\";i:17;s:1:\"b\";s:17:\"view-any-province\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:17;a:4:{s:1:\"a\";i:18;s:1:\"b\";s:13:\"view-province\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:18;a:4:{s:1:\"a\";i:19;s:1:\"b\";s:15:\"create-province\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:19;a:4:{s:1:\"a\";i:20;s:1:\"b\";s:15:\"update-province\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:20;a:4:{s:1:\"a\";i:21;s:1:\"b\";s:15:\"delete-province\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:21;a:4:{s:1:\"a\";i:22;s:1:\"b\";s:13:\"view-any-city\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:22;a:4:{s:1:\"a\";i:23;s:1:\"b\";s:9:\"view-city\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:23;a:4:{s:1:\"a\";i:24;s:1:\"b\";s:11:\"create-city\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:24;a:4:{s:1:\"a\";i:25;s:1:\"b\";s:11:\"update-city\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:25;a:4:{s:1:\"a\";i:26;s:1:\"b\";s:11:\"delete-city\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:26;a:4:{s:1:\"a\";i:27;s:1:\"b\";s:19:\"view-chart-customer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:27;a:4:{s:1:\"a\";i:28;s:1:\"b\";s:17:\"view-any-customer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:28;a:4:{s:1:\"a\";i:29;s:1:\"b\";s:13:\"view-customer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:29;a:4:{s:1:\"a\";i:30;s:1:\"b\";s:15:\"create-customer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:30;a:4:{s:1:\"a\";i:31;s:1:\"b\";s:15:\"update-customer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:31;a:4:{s:1:\"a\";i:32;s:1:\"b\";s:15:\"delete-customer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:32;a:4:{s:1:\"a\";i:33;s:1:\"b\";s:13:\"view-any-role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:33;a:4:{s:1:\"a\";i:34;s:1:\"b\";s:9:\"view-role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:34;a:4:{s:1:\"a\";i:35;s:1:\"b\";s:11:\"create-role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:35;a:4:{s:1:\"a\";i:36;s:1:\"b\";s:11:\"update-role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:36;a:4:{s:1:\"a\";i:37;s:1:\"b\";s:11:\"delete-role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:37;a:4:{s:1:\"a\";i:38;s:1:\"b\";s:14:\"view-any-param\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:38;a:4:{s:1:\"a\";i:39;s:1:\"b\";s:10:\"view-param\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:39;a:4:{s:1:\"a\";i:40;s:1:\"b\";s:12:\"create-param\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:40;a:4:{s:1:\"a\";i:41;s:1:\"b\";s:12:\"update-param\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:41;a:4:{s:1:\"a\";i:42;s:1:\"b\";s:12:\"delete-param\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:42;a:4:{s:1:\"a\";i:43;s:1:\"b\";s:41:\"view-chart-accreditation-status-parameter\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:43;a:4:{s:1:\"a\";i:44;s:1:\"b\";s:18:\"view-any-parameter\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:44;a:4:{s:1:\"a\";i:45;s:1:\"b\";s:14:\"view-parameter\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:45;a:4:{s:1:\"a\";i:46;s:1:\"b\";s:16:\"create-parameter\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:46;a:4:{s:1:\"a\";i:47;s:1:\"b\";s:16:\"update-parameter\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:47;a:4:{s:1:\"a\";i:48;s:1:\"b\";s:16:\"delete-parameter\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:48;a:4:{s:1:\"a\";i:49;s:1:\"b\";s:19:\"view-any-regulation\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:49;a:4:{s:1:\"a\";i:50;s:1:\"b\";s:15:\"view-regulation\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:50;a:4:{s:1:\"a\";i:51;s:1:\"b\";s:17:\"create-regulation\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:51;a:4:{s:1:\"a\";i:52;s:1:\"b\";s:17:\"update-regulation\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:52;a:4:{s:1:\"a\";i:53;s:1:\"b\";s:17:\"delete-regulation\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:53;a:4:{s:1:\"a\";i:54;s:1:\"b\";s:24:\"view-any-regulation-type\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:54;a:4:{s:1:\"a\";i:55;s:1:\"b\";s:20:\"view-regulation-type\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:55;a:4:{s:1:\"a\";i:56;s:1:\"b\";s:22:\"create-regulation-type\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:56;a:4:{s:1:\"a\";i:57;s:1:\"b\";s:22:\"update-regulation-type\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:57;a:4:{s:1:\"a\";i:58;s:1:\"b\";s:22:\"delete-regulation-type\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:58;a:4:{s:1:\"a\";i:59;s:1:\"b\";s:22:\"view-any-sample-matric\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:59;a:4:{s:1:\"a\";i:60;s:1:\"b\";s:18:\"view-sample-matric\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:60;a:4:{s:1:\"a\";i:61;s:1:\"b\";s:20:\"create-sample-matric\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:61;a:4:{s:1:\"a\";i:62;s:1:\"b\";s:20:\"update-sample-matric\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:62;a:4:{s:1:\"a\";i:63;s:1:\"b\";s:20:\"delete-sample-matric\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:63;a:4:{s:1:\"a\";i:64;s:1:\"b\";s:20:\"view-any-sample-type\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:64;a:4:{s:1:\"a\";i:65;s:1:\"b\";s:16:\"view-sample-type\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:65;a:4:{s:1:\"a\";i:66;s:1:\"b\";s:18:\"create-sample-type\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:66;a:4:{s:1:\"a\";i:67;s:1:\"b\";s:18:\"update-sample-type\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:67;a:4:{s:1:\"a\";i:68;s:1:\"b\";s:18:\"delete-sample-type\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:68;a:4:{s:1:\"a\";i:69;s:1:\"b\";s:15:\"view-any-sample\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:69;a:4:{s:1:\"a\";i:70;s:1:\"b\";s:11:\"view-sample\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:70;a:4:{s:1:\"a\";i:71;s:1:\"b\";s:13:\"create-sample\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:71;a:4:{s:1:\"a\";i:72;s:1:\"b\";s:13:\"update-sample\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:72;a:4:{s:1:\"a\";i:73;s:1:\"b\";s:13:\"delete-sample\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:73;a:4:{s:1:\"a\";i:74;s:1:\"b\";s:17:\"collecting-sample\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:74;a:4:{s:1:\"a\";i:75;s:1:\"b\";s:16:\"receiving-sample\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:75;a:4:{s:1:\"a\";i:76;s:1:\"b\";s:14:\"prepare-sample\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:76;a:4:{s:1:\"a\";i:77;s:1:\"b\";s:21:\"download-label-sample\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:77;a:4:{s:1:\"a\";i:78;s:1:\"b\";s:20:\"view-any-test-method\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:78;a:4:{s:1:\"a\";i:79;s:1:\"b\";s:16:\"view-test-method\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:79;a:4:{s:1:\"a\";i:80;s:1:\"b\";s:18:\"create-test-method\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:80;a:4:{s:1:\"a\";i:81;s:1:\"b\";s:18:\"update-test-method\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:81;a:4:{s:1:\"a\";i:82;s:1:\"b\";s:18:\"delete-test-method\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:82;a:4:{s:1:\"a\";i:83;s:1:\"b\";s:21:\"view-any-test-package\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:83;a:4:{s:1:\"a\";i:84;s:1:\"b\";s:17:\"view-test-package\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:84;a:4:{s:1:\"a\";i:85;s:1:\"b\";s:19:\"create-test-package\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:85;a:4:{s:1:\"a\";i:86;s:1:\"b\";s:19:\"update-test-package\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:86;a:4:{s:1:\"a\";i:87;s:1:\"b\";s:19:\"delete-test-package\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:87;a:4:{s:1:\"a\";i:88;s:1:\"b\";s:20:\"view-chart-quotation\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:88;a:4:{s:1:\"a\";i:89;s:1:\"b\";s:18:\"view-any-quotation\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:89;a:4:{s:1:\"a\";i:90;s:1:\"b\";s:14:\"view-quotation\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:90;a:4:{s:1:\"a\";i:91;s:1:\"b\";s:16:\"create-quotation\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:91;a:4:{s:1:\"a\";i:92;s:1:\"b\";s:16:\"update-quotation\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:92;a:4:{s:1:\"a\";i:93;s:1:\"b\";s:16:\"delete-quotation\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:93;a:4:{s:1:\"a\";i:94;s:1:\"b\";s:17:\"preview-quotation\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:94;a:4:{s:1:\"a\";i:95;s:1:\"b\";s:14:\"send-quotation\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:95;a:4:{s:1:\"a\";i:96;s:1:\"b\";s:18:\"download-quotation\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:96;a:4:{s:1:\"a\";i:97;s:1:\"b\";s:16:\"submit-quotation\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:97;a:4:{s:1:\"a\";i:98;s:1:\"b\";s:16:\"accept-quotation\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:98;a:4:{s:1:\"a\";i:99;s:1:\"b\";s:16:\"revise-quotation\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:99;a:4:{s:1:\"a\";i:100;s:1:\"b\";s:16:\"cancel-quotation\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:100;a:4:{s:1:\"a\";i:101;s:1:\"b\";s:22:\"view-any-term-template\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:101;a:4:{s:1:\"a\";i:102;s:1:\"b\";s:18:\"view-term-template\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:102;a:4:{s:1:\"a\";i:103;s:1:\"b\";s:20:\"create-term-template\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:103;a:4:{s:1:\"a\";i:104;s:1:\"b\";s:20:\"update-term-template\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:104;a:4:{s:1:\"a\";i:105;s:1:\"b\";s:20:\"delete-term-template\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:105;a:4:{s:1:\"a\";i:106;s:1:\"b\";s:16:\"view-any-company\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:106;a:4:{s:1:\"a\";i:107;s:1:\"b\";s:12:\"view-company\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:107;a:4:{s:1:\"a\";i:108;s:1:\"b\";s:14:\"create-company\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:108;a:4:{s:1:\"a\";i:109;s:1:\"b\";s:14:\"update-company\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:109;a:4:{s:1:\"a\";i:110;s:1:\"b\";s:14:\"delete-company\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:110;a:4:{s:1:\"a\";i:111;s:1:\"b\";s:18:\"view-chart-lab-job\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:111;a:4:{s:1:\"a\";i:112;s:1:\"b\";s:16:\"view-any-lab-job\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:112;a:4:{s:1:\"a\";i:113;s:1:\"b\";s:12:\"view-lab-job\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:113;a:4:{s:1:\"a\";i:114;s:1:\"b\";s:14:\"create-lab-job\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:114;a:4:{s:1:\"a\";i:115;s:1:\"b\";s:14:\"update-lab-job\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:115;a:4:{s:1:\"a\";i:116;s:1:\"b\";s:14:\"delete-lab-job\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:116;a:4:{s:1:\"a\";i:117;s:1:\"b\";s:27:\"preview-lab-job-task-letter\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:117;a:4:{s:1:\"a\";i:118;s:1:\"b\";s:28:\"download-lab-job-task-letter\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:118;a:4:{s:1:\"a\";i:119;s:1:\"b\";s:25:\"print-lab-job-task-letter\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:119;a:4:{s:1:\"a\";i:120;s:1:\"b\";s:13:\"start-lab-job\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:120;a:4:{s:1:\"a\";i:121;s:1:\"b\";s:25:\"complete-lab-job-sampling\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:121;a:4:{s:1:\"a\";i:122;s:1:\"b\";s:25:\"complete-lab-job-analysis\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:122;a:4:{s:1:\"a\";i:123;s:1:\"b\";s:27:\"complete-lab-job-validation\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:123;a:4:{s:1:\"a\";i:124;s:1:\"b\";s:23:\"generate-lab-job-report\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:124;a:4:{s:1:\"a\";i:125;s:1:\"b\";s:22:\"approve-lab-job-report\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:125;a:4:{s:1:\"a\";i:126;s:1:\"b\";s:19:\"send-lab-job-report\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:126;a:4:{s:1:\"a\";i:127;s:1:\"b\";s:20:\"abort-lab-job-report\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:127;a:4:{s:1:\"a\";i:128;s:1:\"b\";s:22:\"view-chart-test-result\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:128;a:4:{s:1:\"a\";i:129;s:1:\"b\";s:20:\"view-any-test-result\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:129;a:4:{s:1:\"a\";i:130;s:1:\"b\";s:16:\"view-test-result\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:130;a:4:{s:1:\"a\";i:131;s:1:\"b\";s:18:\"create-test-result\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:131;a:4:{s:1:\"a\";i:132;s:1:\"b\";s:18:\"update-test-result\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:132;a:4:{s:1:\"a\";i:133;s:1:\"b\";s:18:\"delete-test-result\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:133;a:4:{s:1:\"a\";i:134;s:1:\"b\";s:28:\"request-validate-test-result\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:134;a:4:{s:1:\"a\";i:135;s:1:\"b\";s:20:\"validate-test-result\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:135;a:4:{s:1:\"a\";i:136;s:1:\"b\";s:27:\"revision-needed-test-result\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:136;a:4:{s:1:\"a\";i:137;s:1:\"b\";s:18:\"reject-test-result\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:137;a:4:{s:1:\"a\";i:138;s:1:\"b\";s:23:\"view-any-specialization\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:138;a:4:{s:1:\"a\";i:139;s:1:\"b\";s:19:\"view-specialization\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:139;a:4:{s:1:\"a\";i:140;s:1:\"b\";s:21:\"create-specialization\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:140;a:4:{s:1:\"a\";i:141;s:1:\"b\";s:21:\"update-specialization\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:141;a:4:{s:1:\"a\";i:142;s:1:\"b\";s:21:\"delete-specialization\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}}s:5:\"roles\";a:7:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:10:\"superadmin\";s:1:\"c\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:2;s:1:\"b\";s:8:\"customer\";s:1:\"c\";s:3:\"web\";}i:2;a:3:{s:1:\"a\";i:3;s:1:\"b\";s:5:\"admin\";s:1:\"c\";s:3:\"web\";}i:3;a:3:{s:1:\"a\";i:4;s:1:\"b\";s:19:\"sampling technician\";s:1:\"c\";s:3:\"web\";}i:4;a:3:{s:1:\"a\";i:5;s:1:\"b\";s:7:\"analyst\";s:1:\"c\";s:3:\"web\";}i:5;a:3:{s:1:\"a\";i:6;s:1:\"b\";s:17:\"technical manager\";s:1:\"c\";s:3:\"web\";}i:6;a:3:{s:1:\"a\";i:7;s:1:\"b\";s:15:\"laboratory head\";s:1:\"c\";s:3:\"web\";}}}',1775147941);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cities`
--

DROP TABLE IF EXISTS `cities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cities` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `province_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cities_name_index` (`name`),
  KEY `fk_cities_province` (`province_id`),
  CONSTRAINT `fk_cities_province` FOREIGN KEY (`province_id`) REFERENCES `provinces` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=515 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cities`
--

LOCK TABLES `cities` WRITE;
/*!40000 ALTER TABLE `cities` DISABLE KEYS */;
INSERT INTO `cities` VALUES (1,11,'KABUPATEN SIMEULUE',NULL,NULL,NULL,NULL),(2,11,'KABUPATEN ACEH SINGKIL',NULL,NULL,NULL,NULL),(3,11,'KABUPATEN ACEH SELATAN',NULL,NULL,NULL,NULL),(4,11,'KABUPATEN ACEH TENGGARA',NULL,NULL,NULL,NULL),(5,11,'KABUPATEN ACEH TIMUR',NULL,NULL,NULL,NULL),(6,11,'KABUPATEN ACEH TENGAH',NULL,NULL,NULL,NULL),(7,11,'KABUPATEN ACEH BARAT',NULL,NULL,NULL,NULL),(8,11,'KABUPATEN ACEH BESAR',NULL,NULL,NULL,NULL),(9,11,'KABUPATEN PIDIE',NULL,NULL,NULL,NULL),(10,11,'KABUPATEN BIREUEN',NULL,NULL,NULL,NULL),(11,11,'KABUPATEN ACEH UTARA',NULL,NULL,NULL,NULL),(12,11,'KABUPATEN ACEH BARAT DAYA',NULL,NULL,NULL,NULL),(13,11,'KABUPATEN GAYO LUES',NULL,NULL,NULL,NULL),(14,11,'KABUPATEN ACEH TAMIANG',NULL,NULL,NULL,NULL),(15,11,'KABUPATEN NAGAN RAYA',NULL,NULL,NULL,NULL),(16,11,'KABUPATEN ACEH JAYA',NULL,NULL,NULL,NULL),(17,11,'KABUPATEN BENER MERIAH',NULL,NULL,NULL,NULL),(18,11,'KABUPATEN PIDIE JAYA',NULL,NULL,NULL,NULL),(19,11,'KOTA BANDA ACEH',NULL,NULL,NULL,NULL),(20,11,'KOTA SABANG',NULL,NULL,NULL,NULL),(21,11,'KOTA LANGSA',NULL,NULL,NULL,NULL),(22,11,'KOTA LHOKSEUMAWE',NULL,NULL,NULL,NULL),(23,11,'KOTA SUBULUSSALAM',NULL,NULL,NULL,NULL),(24,12,'KABUPATEN NIAS',NULL,NULL,NULL,NULL),(25,12,'KABUPATEN MANDAILING NATAL',NULL,NULL,NULL,NULL),(26,12,'KABUPATEN TAPANULI SELATAN',NULL,NULL,NULL,NULL),(27,12,'KABUPATEN TAPANULI TENGAH',NULL,NULL,NULL,NULL),(28,12,'KABUPATEN TAPANULI UTARA',NULL,NULL,NULL,NULL),(29,12,'KABUPATEN TOBA SAMOSIR',NULL,NULL,NULL,NULL),(30,12,'KABUPATEN LABUHAN BATU',NULL,NULL,NULL,NULL),(31,12,'KABUPATEN ASAHAN',NULL,NULL,NULL,NULL),(32,12,'KABUPATEN SIMALUNGUN',NULL,NULL,NULL,NULL),(33,12,'KABUPATEN DAIRI',NULL,NULL,NULL,NULL),(34,12,'KABUPATEN KARO',NULL,NULL,NULL,NULL),(35,12,'KABUPATEN DELI SERDANG',NULL,NULL,NULL,NULL),(36,12,'KABUPATEN LANGKAT',NULL,NULL,NULL,NULL),(37,12,'KABUPATEN NIAS SELATAN',NULL,NULL,NULL,NULL),(38,12,'KABUPATEN HUMBANG HASUNDUTAN',NULL,NULL,NULL,NULL),(39,12,'KABUPATEN PAKPAK BHARAT',NULL,NULL,NULL,NULL),(40,12,'KABUPATEN SAMOSIR',NULL,NULL,NULL,NULL),(41,12,'KABUPATEN SERDANG BEDAGAI',NULL,NULL,NULL,NULL),(42,12,'KABUPATEN BATU BARA',NULL,NULL,NULL,NULL),(43,12,'KABUPATEN PADANG LAWAS UTARA',NULL,NULL,NULL,NULL),(44,12,'KABUPATEN PADANG LAWAS',NULL,NULL,NULL,NULL),(45,12,'KABUPATEN LABUHAN BATU SELATAN',NULL,NULL,NULL,NULL),(46,12,'KABUPATEN LABUHAN BATU UTARA',NULL,NULL,NULL,NULL),(47,12,'KABUPATEN NIAS UTARA',NULL,NULL,NULL,NULL),(48,12,'KABUPATEN NIAS BARAT',NULL,NULL,NULL,NULL),(49,12,'KOTA SIBOLGA',NULL,NULL,NULL,NULL),(50,12,'KOTA TANJUNG BALAI',NULL,NULL,NULL,NULL),(51,12,'KOTA PEMATANG SIANTAR',NULL,NULL,NULL,NULL),(52,12,'KOTA TEBING TINGGI',NULL,NULL,NULL,NULL),(53,12,'KOTA MEDAN',NULL,NULL,NULL,NULL),(54,12,'KOTA BINJAI',NULL,NULL,NULL,NULL),(55,12,'KOTA PADANGSIDIMPUAN',NULL,NULL,NULL,NULL),(56,12,'KOTA GUNUNGSITOLI',NULL,NULL,NULL,NULL),(57,13,'KABUPATEN KEPULAUAN MENTAWAI',NULL,NULL,NULL,NULL),(58,13,'KABUPATEN PESISIR SELATAN',NULL,NULL,NULL,NULL),(59,13,'KABUPATEN SOLOK',NULL,NULL,NULL,NULL),(60,13,'KABUPATEN SIJUNJUNG',NULL,NULL,NULL,NULL),(61,13,'KABUPATEN TANAH DATAR',NULL,NULL,NULL,NULL),(62,13,'KABUPATEN PADANG PARIAMAN',NULL,NULL,NULL,NULL),(63,13,'KABUPATEN AGAM',NULL,NULL,NULL,NULL),(64,13,'KABUPATEN LIMA PULUH KOTA',NULL,NULL,NULL,NULL),(65,13,'KABUPATEN PASAMAN',NULL,NULL,NULL,NULL),(66,13,'KABUPATEN SOLOK SELATAN',NULL,NULL,NULL,NULL),(67,13,'KABUPATEN DHARMASRAYA',NULL,NULL,NULL,NULL),(68,13,'KABUPATEN PASAMAN BARAT',NULL,NULL,NULL,NULL),(69,13,'KOTA PADANG',NULL,NULL,NULL,NULL),(70,13,'KOTA SOLOK',NULL,NULL,NULL,NULL),(71,13,'KOTA SAWAH LUNTO',NULL,NULL,NULL,NULL),(72,13,'KOTA PADANG PANJANG',NULL,NULL,NULL,NULL),(73,13,'KOTA BUKITTINGGI',NULL,NULL,NULL,NULL),(74,13,'KOTA PAYAKUMBUH',NULL,NULL,NULL,NULL),(75,13,'KOTA PARIAMAN',NULL,NULL,NULL,NULL),(76,14,'KABUPATEN KUANTAN SINGINGI',NULL,NULL,NULL,NULL),(77,14,'KABUPATEN INDRAGIRI HULU',NULL,NULL,NULL,NULL),(78,14,'KABUPATEN INDRAGIRI HILIR',NULL,NULL,NULL,NULL),(79,14,'KABUPATEN PELALAWAN',NULL,NULL,NULL,NULL),(80,14,'KABUPATEN S I A K',NULL,NULL,NULL,NULL),(81,14,'KABUPATEN KAMPAR',NULL,NULL,NULL,NULL),(82,14,'KABUPATEN ROKAN HULU',NULL,NULL,NULL,NULL),(83,14,'KABUPATEN BENGKALIS',NULL,NULL,NULL,NULL),(84,14,'KABUPATEN ROKAN HILIR',NULL,NULL,NULL,NULL),(85,14,'KABUPATEN KEPULAUAN MERANTI',NULL,NULL,NULL,NULL),(86,14,'KOTA PEKANBARU',NULL,NULL,NULL,NULL),(87,14,'KOTA D U M A I',NULL,NULL,NULL,NULL),(88,15,'KABUPATEN KERINCI',NULL,NULL,NULL,NULL),(89,15,'KABUPATEN MERANGIN',NULL,NULL,NULL,NULL),(90,15,'KABUPATEN SAROLANGUN',NULL,NULL,NULL,NULL),(91,15,'KABUPATEN BATANG HARI',NULL,NULL,NULL,NULL),(92,15,'KABUPATEN MUARO JAMBI',NULL,NULL,NULL,NULL),(93,15,'KABUPATEN TANJUNG JABUNG TIMUR',NULL,NULL,NULL,NULL),(94,15,'KABUPATEN TANJUNG JABUNG BARAT',NULL,NULL,NULL,NULL),(95,15,'KABUPATEN TEBO',NULL,NULL,NULL,NULL),(96,15,'KABUPATEN BUNGO',NULL,NULL,NULL,NULL),(97,15,'KOTA JAMBI',NULL,NULL,NULL,NULL),(98,15,'KOTA SUNGAI PENUH',NULL,NULL,NULL,NULL),(99,16,'KABUPATEN OGAN KOMERING ULU',NULL,NULL,NULL,NULL),(100,16,'KABUPATEN OGAN KOMERING ILIR',NULL,NULL,NULL,NULL),(101,16,'KABUPATEN MUARA ENIM',NULL,NULL,NULL,NULL),(102,16,'KABUPATEN LAHAT',NULL,NULL,NULL,NULL),(103,16,'KABUPATEN MUSI RAWAS',NULL,NULL,NULL,NULL),(104,16,'KABUPATEN MUSI BANYUASIN',NULL,NULL,NULL,NULL),(105,16,'KABUPATEN BANYU ASIN',NULL,NULL,NULL,NULL),(106,16,'KABUPATEN OGAN KOMERING ULU SELATAN',NULL,NULL,NULL,NULL),(107,16,'KABUPATEN OGAN KOMERING ULU TIMUR',NULL,NULL,NULL,NULL),(108,16,'KABUPATEN OGAN ILIR',NULL,NULL,NULL,NULL),(109,16,'KABUPATEN EMPAT LAWANG',NULL,NULL,NULL,NULL),(110,16,'KABUPATEN PENUKAL ABAB LEMATANG ILIR',NULL,NULL,NULL,NULL),(111,16,'KABUPATEN MUSI RAWAS UTARA',NULL,NULL,NULL,NULL),(112,16,'KOTA PALEMBANG',NULL,NULL,NULL,NULL),(113,16,'KOTA PRABUMULIH',NULL,NULL,NULL,NULL),(114,16,'KOTA PAGAR ALAM',NULL,NULL,NULL,NULL),(115,16,'KOTA LUBUKLINGGAU',NULL,NULL,NULL,NULL),(116,17,'KABUPATEN BENGKULU SELATAN',NULL,NULL,NULL,NULL),(117,17,'KABUPATEN REJANG LEBONG',NULL,NULL,NULL,NULL),(118,17,'KABUPATEN BENGKULU UTARA',NULL,NULL,NULL,NULL),(119,17,'KABUPATEN KAUR',NULL,NULL,NULL,NULL),(120,17,'KABUPATEN SELUMA',NULL,NULL,NULL,NULL),(121,17,'KABUPATEN MUKOMUKO',NULL,NULL,NULL,NULL),(122,17,'KABUPATEN LEBONG',NULL,NULL,NULL,NULL),(123,17,'KABUPATEN KEPAHIANG',NULL,NULL,NULL,NULL),(124,17,'KABUPATEN BENGKULU TENGAH',NULL,NULL,NULL,NULL),(125,17,'KOTA BENGKULU',NULL,NULL,NULL,NULL),(126,18,'KABUPATEN LAMPUNG BARAT',NULL,NULL,NULL,NULL),(127,18,'KABUPATEN TANGGAMUS',NULL,NULL,NULL,NULL),(128,18,'KABUPATEN LAMPUNG SELATAN',NULL,NULL,NULL,NULL),(129,18,'KABUPATEN LAMPUNG TIMUR',NULL,NULL,NULL,NULL),(130,18,'KABUPATEN LAMPUNG TENGAH',NULL,NULL,NULL,NULL),(131,18,'KABUPATEN LAMPUNG UTARA',NULL,NULL,NULL,NULL),(132,18,'KABUPATEN WAY KANAN',NULL,NULL,NULL,NULL),(133,18,'KABUPATEN TULANGBAWANG',NULL,NULL,NULL,NULL),(134,18,'KABUPATEN PESAWARAN',NULL,NULL,NULL,NULL),(135,18,'KABUPATEN PRINGSEWU',NULL,NULL,NULL,NULL),(136,18,'KABUPATEN MESUJI',NULL,NULL,NULL,NULL),(137,18,'KABUPATEN TULANG BAWANG BARAT',NULL,NULL,NULL,NULL),(138,18,'KABUPATEN PESISIR BARAT',NULL,NULL,NULL,NULL),(139,18,'KOTA BANDAR LAMPUNG',NULL,NULL,NULL,NULL),(140,18,'KOTA METRO',NULL,NULL,NULL,NULL),(141,19,'KABUPATEN BANGKA',NULL,NULL,NULL,NULL),(142,19,'KABUPATEN BELITUNG',NULL,NULL,NULL,NULL),(143,19,'KABUPATEN BANGKA BARAT',NULL,NULL,NULL,NULL),(144,19,'KABUPATEN BANGKA TENGAH',NULL,NULL,NULL,NULL),(145,19,'KABUPATEN BANGKA SELATAN',NULL,NULL,NULL,NULL),(146,19,'KABUPATEN BELITUNG TIMUR',NULL,NULL,NULL,NULL),(147,19,'KOTA PANGKAL PINANG',NULL,NULL,NULL,NULL),(148,21,'KABUPATEN KARIMUN',NULL,NULL,NULL,NULL),(149,21,'KABUPATEN BINTAN',NULL,NULL,NULL,NULL),(150,21,'KABUPATEN NATUNA',NULL,NULL,NULL,NULL),(151,21,'KABUPATEN LINGGA',NULL,NULL,NULL,NULL),(152,21,'KABUPATEN KEPULAUAN ANAMBAS',NULL,NULL,NULL,NULL),(153,21,'KOTA B A T A M',NULL,NULL,NULL,NULL),(154,21,'KOTA TANJUNG PINANG',NULL,NULL,NULL,NULL),(155,31,'KABUPATEN KEPULAUAN SERIBU',NULL,NULL,NULL,NULL),(156,31,'KOTA JAKARTA SELATAN',NULL,NULL,NULL,NULL),(157,31,'KOTA JAKARTA TIMUR',NULL,NULL,NULL,NULL),(158,31,'KOTA JAKARTA PUSAT',NULL,NULL,NULL,NULL),(159,31,'KOTA JAKARTA BARAT',NULL,NULL,NULL,NULL),(160,31,'KOTA JAKARTA UTARA',NULL,NULL,NULL,NULL),(161,32,'KABUPATEN BOGOR',NULL,NULL,NULL,NULL),(162,32,'KABUPATEN SUKABUMI',NULL,NULL,NULL,NULL),(163,32,'KABUPATEN CIANJUR',NULL,NULL,NULL,NULL),(164,32,'KABUPATEN BANDUNG',NULL,NULL,NULL,NULL),(165,32,'KABUPATEN GARUT',NULL,NULL,NULL,NULL),(166,32,'KABUPATEN TASIKMALAYA',NULL,NULL,NULL,NULL),(167,32,'KABUPATEN CIAMIS',NULL,NULL,NULL,NULL),(168,32,'KABUPATEN KUNINGAN',NULL,NULL,NULL,NULL),(169,32,'KABUPATEN CIREBON',NULL,NULL,NULL,NULL),(170,32,'KABUPATEN MAJALENGKA',NULL,NULL,NULL,NULL),(171,32,'KABUPATEN SUMEDANG',NULL,NULL,NULL,NULL),(172,32,'KABUPATEN INDRAMAYU',NULL,NULL,NULL,NULL),(173,32,'KABUPATEN SUBANG',NULL,NULL,NULL,NULL),(174,32,'KABUPATEN PURWAKARTA',NULL,NULL,NULL,NULL),(175,32,'KABUPATEN KARAWANG',NULL,NULL,NULL,NULL),(176,32,'KABUPATEN BEKASI',NULL,NULL,NULL,NULL),(177,32,'KABUPATEN BANDUNG BARAT',NULL,NULL,NULL,NULL),(178,32,'KABUPATEN PANGANDARAN',NULL,NULL,NULL,NULL),(179,32,'KOTA BOGOR',NULL,NULL,NULL,NULL),(180,32,'KOTA SUKABUMI',NULL,NULL,NULL,NULL),(181,32,'KOTA BANDUNG',NULL,NULL,NULL,NULL),(182,32,'KOTA CIREBON',NULL,NULL,NULL,NULL),(183,32,'KOTA BEKASI',NULL,NULL,NULL,NULL),(184,32,'KOTA DEPOK',NULL,NULL,NULL,NULL),(185,32,'KOTA CIMAHI',NULL,NULL,NULL,NULL),(186,32,'KOTA TASIKMALAYA',NULL,NULL,NULL,NULL),(187,32,'KOTA BANJAR',NULL,NULL,NULL,NULL),(188,33,'KABUPATEN CILACAP',NULL,NULL,NULL,NULL),(189,33,'KABUPATEN BANYUMAS',NULL,NULL,NULL,NULL),(190,33,'KABUPATEN PURBALINGGA',NULL,NULL,NULL,NULL),(191,33,'KABUPATEN BANJARNEGARA',NULL,NULL,NULL,NULL),(192,33,'KABUPATEN KEBUMEN',NULL,NULL,NULL,NULL),(193,33,'KABUPATEN PURWOREJO',NULL,NULL,NULL,NULL),(194,33,'KABUPATEN WONOSOBO',NULL,NULL,NULL,NULL),(195,33,'KABUPATEN MAGELANG',NULL,NULL,NULL,NULL),(196,33,'KABUPATEN BOYOLALI',NULL,NULL,NULL,NULL),(197,33,'KABUPATEN KLATEN',NULL,NULL,NULL,NULL),(198,33,'KABUPATEN SUKOHARJO',NULL,NULL,NULL,NULL),(199,33,'KABUPATEN WONOGIRI',NULL,NULL,NULL,NULL),(200,33,'KABUPATEN KARANGANYAR',NULL,NULL,NULL,NULL),(201,33,'KABUPATEN SRAGEN',NULL,NULL,NULL,NULL),(202,33,'KABUPATEN GROBOGAN',NULL,NULL,NULL,NULL),(203,33,'KABUPATEN BLORA',NULL,NULL,NULL,NULL),(204,33,'KABUPATEN REMBANG',NULL,NULL,NULL,NULL),(205,33,'KABUPATEN PATI',NULL,NULL,NULL,NULL),(206,33,'KABUPATEN KUDUS',NULL,NULL,NULL,NULL),(207,33,'KABUPATEN JEPARA',NULL,NULL,NULL,NULL),(208,33,'KABUPATEN DEMAK',NULL,NULL,NULL,NULL),(209,33,'KABUPATEN SEMARANG',NULL,NULL,NULL,NULL),(210,33,'KABUPATEN TEMANGGUNG',NULL,NULL,NULL,NULL),(211,33,'KABUPATEN KENDAL',NULL,NULL,NULL,NULL),(212,33,'KABUPATEN BATANG',NULL,NULL,NULL,NULL),(213,33,'KABUPATEN PEKALONGAN',NULL,NULL,NULL,NULL),(214,33,'KABUPATEN PEMALANG',NULL,NULL,NULL,NULL),(215,33,'KABUPATEN TEGAL',NULL,NULL,NULL,NULL),(216,33,'KABUPATEN BREBES',NULL,NULL,NULL,NULL),(217,33,'KOTA MAGELANG',NULL,NULL,NULL,NULL),(218,33,'KOTA SURAKARTA',NULL,NULL,NULL,NULL),(219,33,'KOTA SALATIGA',NULL,NULL,NULL,NULL),(220,33,'KOTA SEMARANG',NULL,NULL,NULL,NULL),(221,33,'KOTA PEKALONGAN',NULL,NULL,NULL,NULL),(222,33,'KOTA TEGAL',NULL,NULL,NULL,NULL),(223,34,'KABUPATEN KULON PROGO',NULL,NULL,NULL,NULL),(224,34,'KABUPATEN BANTUL',NULL,NULL,NULL,NULL),(225,34,'KABUPATEN GUNUNG KIDUL',NULL,NULL,NULL,NULL),(226,34,'KABUPATEN SLEMAN',NULL,NULL,NULL,NULL),(227,34,'KOTA YOGYAKARTA',NULL,NULL,NULL,NULL),(228,35,'KABUPATEN PACITAN',NULL,NULL,NULL,NULL),(229,35,'KABUPATEN PONOROGO',NULL,NULL,NULL,NULL),(230,35,'KABUPATEN TRENGGALEK',NULL,NULL,NULL,NULL),(231,35,'KABUPATEN TULUNGAGUNG',NULL,NULL,NULL,NULL),(232,35,'KABUPATEN BLITAR',NULL,NULL,NULL,NULL),(233,35,'KABUPATEN KEDIRI',NULL,NULL,NULL,NULL),(234,35,'KABUPATEN MALANG',NULL,NULL,NULL,NULL),(235,35,'KABUPATEN LUMAJANG',NULL,NULL,NULL,NULL),(236,35,'KABUPATEN JEMBER',NULL,NULL,NULL,NULL),(237,35,'KABUPATEN BANYUWANGI',NULL,NULL,NULL,NULL),(238,35,'KABUPATEN BONDOWOSO',NULL,NULL,NULL,NULL),(239,35,'KABUPATEN SITUBONDO',NULL,NULL,NULL,NULL),(240,35,'KABUPATEN PROBOLINGGO',NULL,NULL,NULL,NULL),(241,35,'KABUPATEN PASURUAN',NULL,NULL,NULL,NULL),(242,35,'KABUPATEN SIDOARJO',NULL,NULL,NULL,NULL),(243,35,'KABUPATEN MOJOKERTO',NULL,NULL,NULL,NULL),(244,35,'KABUPATEN JOMBANG',NULL,NULL,NULL,NULL),(245,35,'KABUPATEN NGANJUK',NULL,NULL,NULL,NULL),(246,35,'KABUPATEN MADIUN',NULL,NULL,NULL,NULL),(247,35,'KABUPATEN MAGETAN',NULL,NULL,NULL,NULL),(248,35,'KABUPATEN NGAWI',NULL,NULL,NULL,NULL),(249,35,'KABUPATEN BOJONEGORO',NULL,NULL,NULL,NULL),(250,35,'KABUPATEN TUBAN',NULL,NULL,NULL,NULL),(251,35,'KABUPATEN LAMONGAN',NULL,NULL,NULL,NULL),(252,35,'KABUPATEN GRESIK',NULL,NULL,NULL,NULL),(253,35,'KABUPATEN BANGKALAN',NULL,NULL,NULL,NULL),(254,35,'KABUPATEN SAMPANG',NULL,NULL,NULL,NULL),(255,35,'KABUPATEN PAMEKASAN',NULL,NULL,NULL,NULL),(256,35,'KABUPATEN SUMENEP',NULL,NULL,NULL,NULL),(257,35,'KOTA KEDIRI',NULL,NULL,NULL,NULL),(258,35,'KOTA BLITAR',NULL,NULL,NULL,NULL),(259,35,'KOTA MALANG',NULL,NULL,NULL,NULL),(260,35,'KOTA PROBOLINGGO',NULL,NULL,NULL,NULL),(261,35,'KOTA PASURUAN',NULL,NULL,NULL,NULL),(262,35,'KOTA MOJOKERTO',NULL,NULL,NULL,NULL),(263,35,'KOTA MADIUN',NULL,NULL,NULL,NULL),(264,35,'KOTA SURABAYA',NULL,NULL,NULL,NULL),(265,35,'KOTA BATU',NULL,NULL,NULL,NULL),(266,36,'KABUPATEN PANDEGLANG',NULL,NULL,NULL,NULL),(267,36,'KABUPATEN LEBAK',NULL,NULL,NULL,NULL),(268,36,'KABUPATEN TANGERANG',NULL,NULL,NULL,NULL),(269,36,'KABUPATEN SERANG',NULL,NULL,NULL,NULL),(270,36,'KOTA TANGERANG',NULL,NULL,NULL,NULL),(271,36,'KOTA CILEGON',NULL,NULL,NULL,NULL),(272,36,'KOTA SERANG',NULL,NULL,NULL,NULL),(273,36,'KOTA TANGERANG SELATAN',NULL,NULL,NULL,NULL),(274,51,'KABUPATEN JEMBRANA',NULL,NULL,NULL,NULL),(275,51,'KABUPATEN TABANAN',NULL,NULL,NULL,NULL),(276,51,'KABUPATEN BADUNG',NULL,NULL,NULL,NULL),(277,51,'KABUPATEN GIANYAR',NULL,NULL,NULL,NULL),(278,51,'KABUPATEN KLUNGKUNG',NULL,NULL,NULL,NULL),(279,51,'KABUPATEN BANGLI',NULL,NULL,NULL,NULL),(280,51,'KABUPATEN KARANG ASEM',NULL,NULL,NULL,NULL),(281,51,'KABUPATEN BULELENG',NULL,NULL,NULL,NULL),(282,51,'KOTA DENPASAR',NULL,NULL,NULL,NULL),(283,52,'KABUPATEN LOMBOK BARAT',NULL,NULL,NULL,NULL),(284,52,'KABUPATEN LOMBOK TENGAH',NULL,NULL,NULL,NULL),(285,52,'KABUPATEN LOMBOK TIMUR',NULL,NULL,NULL,NULL),(286,52,'KABUPATEN SUMBAWA',NULL,NULL,NULL,NULL),(287,52,'KABUPATEN DOMPU',NULL,NULL,NULL,NULL),(288,52,'KABUPATEN BIMA',NULL,NULL,NULL,NULL),(289,52,'KABUPATEN SUMBAWA BARAT',NULL,NULL,NULL,NULL),(290,52,'KABUPATEN LOMBOK UTARA',NULL,NULL,NULL,NULL),(291,52,'KOTA MATARAM',NULL,NULL,NULL,NULL),(292,52,'KOTA BIMA',NULL,NULL,NULL,NULL),(293,53,'KABUPATEN SUMBA BARAT',NULL,NULL,NULL,NULL),(294,53,'KABUPATEN SUMBA TIMUR',NULL,NULL,NULL,NULL),(295,53,'KABUPATEN KUPANG',NULL,NULL,NULL,NULL),(296,53,'KABUPATEN TIMOR TENGAH SELATAN',NULL,NULL,NULL,NULL),(297,53,'KABUPATEN TIMOR TENGAH UTARA',NULL,NULL,NULL,NULL),(298,53,'KABUPATEN BELU',NULL,NULL,NULL,NULL),(299,53,'KABUPATEN ALOR',NULL,NULL,NULL,NULL),(300,53,'KABUPATEN LEMBATA',NULL,NULL,NULL,NULL),(301,53,'KABUPATEN FLORES TIMUR',NULL,NULL,NULL,NULL),(302,53,'KABUPATEN SIKKA',NULL,NULL,NULL,NULL),(303,53,'KABUPATEN ENDE',NULL,NULL,NULL,NULL),(304,53,'KABUPATEN NGADA',NULL,NULL,NULL,NULL),(305,53,'KABUPATEN MANGGARAI',NULL,NULL,NULL,NULL),(306,53,'KABUPATEN ROTE NDAO',NULL,NULL,NULL,NULL),(307,53,'KABUPATEN MANGGARAI BARAT',NULL,NULL,NULL,NULL),(308,53,'KABUPATEN SUMBA TENGAH',NULL,NULL,NULL,NULL),(309,53,'KABUPATEN SUMBA BARAT DAYA',NULL,NULL,NULL,NULL),(310,53,'KABUPATEN NAGEKEO',NULL,NULL,NULL,NULL),(311,53,'KABUPATEN MANGGARAI TIMUR',NULL,NULL,NULL,NULL),(312,53,'KABUPATEN SABU RAIJUA',NULL,NULL,NULL,NULL),(313,53,'KABUPATEN MALAKA',NULL,NULL,NULL,NULL),(314,53,'KOTA KUPANG',NULL,NULL,NULL,NULL),(315,61,'KABUPATEN SAMBAS',NULL,NULL,NULL,NULL),(316,61,'KABUPATEN BENGKAYANG',NULL,NULL,NULL,NULL),(317,61,'KABUPATEN LANDAK',NULL,NULL,NULL,NULL),(318,61,'KABUPATEN MEMPAWAH',NULL,NULL,NULL,NULL),(319,61,'KABUPATEN SANGGAU',NULL,NULL,NULL,NULL),(320,61,'KABUPATEN KETAPANG',NULL,NULL,NULL,NULL),(321,61,'KABUPATEN SINTANG',NULL,NULL,NULL,NULL),(322,61,'KABUPATEN KAPUAS HULU',NULL,NULL,NULL,NULL),(323,61,'KABUPATEN SEKADAU',NULL,NULL,NULL,NULL),(324,61,'KABUPATEN MELAWI',NULL,NULL,NULL,NULL),(325,61,'KABUPATEN KAYONG UTARA',NULL,NULL,NULL,NULL),(326,61,'KABUPATEN KUBU RAYA',NULL,NULL,NULL,NULL),(327,61,'KOTA PONTIANAK',NULL,NULL,NULL,NULL),(328,61,'KOTA SINGKAWANG',NULL,NULL,NULL,NULL),(329,62,'KABUPATEN KOTAWARINGIN BARAT',NULL,NULL,NULL,NULL),(330,62,'KABUPATEN KOTAWARINGIN TIMUR',NULL,NULL,NULL,NULL),(331,62,'KABUPATEN KAPUAS',NULL,NULL,NULL,NULL),(332,62,'KABUPATEN BARITO SELATAN',NULL,NULL,NULL,NULL),(333,62,'KABUPATEN BARITO UTARA',NULL,NULL,NULL,NULL),(334,62,'KABUPATEN SUKAMARA',NULL,NULL,NULL,NULL),(335,62,'KABUPATEN LAMANDAU',NULL,NULL,NULL,NULL),(336,62,'KABUPATEN SERUYAN',NULL,NULL,NULL,NULL),(337,62,'KABUPATEN KATINGAN',NULL,NULL,NULL,NULL),(338,62,'KABUPATEN PULANG PISAU',NULL,NULL,NULL,NULL),(339,62,'KABUPATEN GUNUNG MAS',NULL,NULL,NULL,NULL),(340,62,'KABUPATEN BARITO TIMUR',NULL,NULL,NULL,NULL),(341,62,'KABUPATEN MURUNG RAYA',NULL,NULL,NULL,NULL),(342,62,'KOTA PALANGKA RAYA',NULL,NULL,NULL,NULL),(343,63,'KABUPATEN TANAH LAUT',NULL,NULL,NULL,NULL),(344,63,'KABUPATEN KOTA BARU',NULL,NULL,NULL,NULL),(345,63,'KABUPATEN BANJAR',NULL,NULL,NULL,NULL),(346,63,'KABUPATEN BARITO KUALA',NULL,NULL,NULL,NULL),(347,63,'KABUPATEN TAPIN',NULL,NULL,NULL,NULL),(348,63,'KABUPATEN HULU SUNGAI SELATAN',NULL,NULL,NULL,NULL),(349,63,'KABUPATEN HULU SUNGAI TENGAH',NULL,NULL,NULL,NULL),(350,63,'KABUPATEN HULU SUNGAI UTARA',NULL,NULL,NULL,NULL),(351,63,'KABUPATEN TABALONG',NULL,NULL,NULL,NULL),(352,63,'KABUPATEN TANAH BUMBU',NULL,NULL,NULL,NULL),(353,63,'KABUPATEN BALANGAN',NULL,NULL,NULL,NULL),(354,63,'KOTA BANJARMASIN',NULL,NULL,NULL,NULL),(355,63,'KOTA BANJAR BARU',NULL,NULL,NULL,NULL),(356,64,'KABUPATEN PASER',NULL,NULL,NULL,NULL),(357,64,'KABUPATEN KUTAI BARAT',NULL,NULL,NULL,NULL),(358,64,'KABUPATEN KUTAI KARTANEGARA',NULL,NULL,NULL,NULL),(359,64,'KABUPATEN KUTAI TIMUR',NULL,NULL,NULL,NULL),(360,64,'KABUPATEN BERAU',NULL,NULL,NULL,NULL),(361,64,'KABUPATEN PENAJAM PASER UTARA',NULL,NULL,NULL,NULL),(362,64,'KABUPATEN MAHAKAM HULU',NULL,NULL,NULL,NULL),(363,64,'KOTA BALIKPAPAN',NULL,NULL,NULL,NULL),(364,64,'KOTA SAMARINDA',NULL,NULL,NULL,NULL),(365,64,'KOTA BONTANG',NULL,NULL,NULL,NULL),(366,65,'KABUPATEN MALINAU',NULL,NULL,NULL,NULL),(367,65,'KABUPATEN BULUNGAN',NULL,NULL,NULL,NULL),(368,65,'KABUPATEN TANA TIDUNG',NULL,NULL,NULL,NULL),(369,65,'KABUPATEN NUNUKAN',NULL,NULL,NULL,NULL),(370,65,'KOTA TARAKAN',NULL,NULL,NULL,NULL),(371,71,'KABUPATEN BOLAANG MONGONDOW',NULL,NULL,NULL,NULL),(372,71,'KABUPATEN MINAHASA',NULL,NULL,NULL,NULL),(373,71,'KABUPATEN KEPULAUAN SANGIHE',NULL,NULL,NULL,NULL),(374,71,'KABUPATEN KEPULAUAN TALAUD',NULL,NULL,NULL,NULL),(375,71,'KABUPATEN MINAHASA SELATAN',NULL,NULL,NULL,NULL),(376,71,'KABUPATEN MINAHASA UTARA',NULL,NULL,NULL,NULL),(377,71,'KABUPATEN BOLAANG MONGONDOW UTARA',NULL,NULL,NULL,NULL),(378,71,'KABUPATEN SIAU TAGULANDANG BIARO',NULL,NULL,NULL,NULL),(379,71,'KABUPATEN MINAHASA TENGGARA',NULL,NULL,NULL,NULL),(380,71,'KABUPATEN BOLAANG MONGONDOW SELATAN',NULL,NULL,NULL,NULL),(381,71,'KABUPATEN BOLAANG MONGONDOW TIMUR',NULL,NULL,NULL,NULL),(382,71,'KOTA MANADO',NULL,NULL,NULL,NULL),(383,71,'KOTA BITUNG',NULL,NULL,NULL,NULL),(384,71,'KOTA TOMOHON',NULL,NULL,NULL,NULL),(385,71,'KOTA KOTAMOBAGU',NULL,NULL,NULL,NULL),(386,72,'KABUPATEN BANGGAI KEPULAUAN',NULL,NULL,NULL,NULL),(387,72,'KABUPATEN BANGGAI',NULL,NULL,NULL,NULL),(388,72,'KABUPATEN MOROWALI',NULL,NULL,NULL,NULL),(389,72,'KABUPATEN POSO',NULL,NULL,NULL,NULL),(390,72,'KABUPATEN DONGGALA',NULL,NULL,NULL,NULL),(391,72,'KABUPATEN TOLI-TOLI',NULL,NULL,NULL,NULL),(392,72,'KABUPATEN BUOL',NULL,NULL,NULL,NULL),(393,72,'KABUPATEN PARIGI MOUTONG',NULL,NULL,NULL,NULL),(394,72,'KABUPATEN TOJO UNA-UNA',NULL,NULL,NULL,NULL),(395,72,'KABUPATEN SIGI',NULL,NULL,NULL,NULL),(396,72,'KABUPATEN BANGGAI LAUT',NULL,NULL,NULL,NULL),(397,72,'KABUPATEN MOROWALI UTARA',NULL,NULL,NULL,NULL),(398,72,'KOTA PALU',NULL,NULL,NULL,NULL),(399,73,'KABUPATEN KEPULAUAN SELAYAR',NULL,NULL,NULL,NULL),(400,73,'KABUPATEN BULUKUMBA',NULL,NULL,NULL,NULL),(401,73,'KABUPATEN BANTAENG',NULL,NULL,NULL,NULL),(402,73,'KABUPATEN JENEPONTO',NULL,NULL,NULL,NULL),(403,73,'KABUPATEN TAKALAR',NULL,NULL,NULL,NULL),(404,73,'KABUPATEN GOWA',NULL,NULL,NULL,NULL),(405,73,'KABUPATEN SINJAI',NULL,NULL,NULL,NULL),(406,73,'KABUPATEN MAROS',NULL,NULL,NULL,NULL),(407,73,'KABUPATEN PANGKAJENE DAN KEPULAUAN',NULL,NULL,NULL,NULL),(408,73,'KABUPATEN BARRU',NULL,NULL,NULL,NULL),(409,73,'KABUPATEN BONE',NULL,NULL,NULL,NULL),(410,73,'KABUPATEN SOPPENG',NULL,NULL,NULL,NULL),(411,73,'KABUPATEN WAJO',NULL,NULL,NULL,NULL),(412,73,'KABUPATEN SIDENRENG RAPPANG',NULL,NULL,NULL,NULL),(413,73,'KABUPATEN PINRANG',NULL,NULL,NULL,NULL),(414,73,'KABUPATEN ENREKANG',NULL,NULL,NULL,NULL),(415,73,'KABUPATEN LUWU',NULL,NULL,NULL,NULL),(416,73,'KABUPATEN TANA TORAJA',NULL,NULL,NULL,NULL),(417,73,'KABUPATEN LUWU UTARA',NULL,NULL,NULL,NULL),(418,73,'KABUPATEN LUWU TIMUR',NULL,NULL,NULL,NULL),(419,73,'KABUPATEN TORAJA UTARA',NULL,NULL,NULL,NULL),(420,73,'KOTA MAKASSAR',NULL,NULL,NULL,NULL),(421,73,'KOTA PAREPARE',NULL,NULL,NULL,NULL),(422,73,'KOTA PALOPO',NULL,NULL,NULL,NULL),(423,74,'KABUPATEN BUTON',NULL,NULL,NULL,NULL),(424,74,'KABUPATEN MUNA',NULL,NULL,NULL,NULL),(425,74,'KABUPATEN KONAWE',NULL,NULL,NULL,NULL),(426,74,'KABUPATEN KOLAKA',NULL,NULL,NULL,NULL),(427,74,'KABUPATEN KONAWE SELATAN',NULL,NULL,NULL,NULL),(428,74,'KABUPATEN BOMBANA',NULL,NULL,NULL,NULL),(429,74,'KABUPATEN WAKATOBI',NULL,NULL,NULL,NULL),(430,74,'KABUPATEN KOLAKA UTARA',NULL,NULL,NULL,NULL),(431,74,'KABUPATEN BUTON UTARA',NULL,NULL,NULL,NULL),(432,74,'KABUPATEN KONAWE UTARA',NULL,NULL,NULL,NULL),(433,74,'KABUPATEN KOLAKA TIMUR',NULL,NULL,NULL,NULL),(434,74,'KABUPATEN KONAWE KEPULAUAN',NULL,NULL,NULL,NULL),(435,74,'KABUPATEN MUNA BARAT',NULL,NULL,NULL,NULL),(436,74,'KABUPATEN BUTON TENGAH',NULL,NULL,NULL,NULL),(437,74,'KABUPATEN BUTON SELATAN',NULL,NULL,NULL,NULL),(438,74,'KOTA KENDARI',NULL,NULL,NULL,NULL),(439,74,'KOTA BAUBAU',NULL,NULL,NULL,NULL),(440,75,'KABUPATEN BOALEMO',NULL,NULL,NULL,NULL),(441,75,'KABUPATEN GORONTALO',NULL,NULL,NULL,NULL),(442,75,'KABUPATEN POHUWATO',NULL,NULL,NULL,NULL),(443,75,'KABUPATEN BONE BOLANGO',NULL,NULL,NULL,NULL),(444,75,'KABUPATEN GORONTALO UTARA',NULL,NULL,NULL,NULL),(445,75,'KOTA GORONTALO',NULL,NULL,NULL,NULL),(446,76,'KABUPATEN MAJENE',NULL,NULL,NULL,NULL),(447,76,'KABUPATEN POLEWALI MANDAR',NULL,NULL,NULL,NULL),(448,76,'KABUPATEN MAMASA',NULL,NULL,NULL,NULL),(449,76,'KABUPATEN MAMUJU',NULL,NULL,NULL,NULL),(450,76,'KABUPATEN MAMUJU UTARA',NULL,NULL,NULL,NULL),(451,76,'KABUPATEN MAMUJU TENGAH',NULL,NULL,NULL,NULL),(452,81,'KABUPATEN MALUKU TENGGARA BARAT',NULL,NULL,NULL,NULL),(453,81,'KABUPATEN MALUKU TENGGARA',NULL,NULL,NULL,NULL),(454,81,'KABUPATEN MALUKU TENGAH',NULL,NULL,NULL,NULL),(455,81,'KABUPATEN BURU',NULL,NULL,NULL,NULL),(456,81,'KABUPATEN KEPULAUAN ARU',NULL,NULL,NULL,NULL),(457,81,'KABUPATEN SERAM BAGIAN BARAT',NULL,NULL,NULL,NULL),(458,81,'KABUPATEN SERAM BAGIAN TIMUR',NULL,NULL,NULL,NULL),(459,81,'KABUPATEN MALUKU BARAT DAYA',NULL,NULL,NULL,NULL),(460,81,'KABUPATEN BURU SELATAN',NULL,NULL,NULL,NULL),(461,81,'KOTA AMBON',NULL,NULL,NULL,NULL),(462,81,'KOTA TUAL',NULL,NULL,NULL,NULL),(463,82,'KABUPATEN HALMAHERA BARAT',NULL,NULL,NULL,NULL),(464,82,'KABUPATEN HALMAHERA TENGAH',NULL,NULL,NULL,NULL),(465,82,'KABUPATEN KEPULAUAN SULA',NULL,NULL,NULL,NULL),(466,82,'KABUPATEN HALMAHERA SELATAN',NULL,NULL,NULL,NULL),(467,82,'KABUPATEN HALMAHERA UTARA',NULL,NULL,NULL,NULL),(468,82,'KABUPATEN HALMAHERA TIMUR',NULL,NULL,NULL,NULL),(469,82,'KABUPATEN PULAU MOROTAI',NULL,NULL,NULL,NULL),(470,82,'KABUPATEN PULAU TALIABU',NULL,NULL,NULL,NULL),(471,82,'KOTA TERNATE',NULL,NULL,NULL,NULL),(472,82,'KOTA TIDORE KEPULAUAN',NULL,NULL,NULL,NULL),(473,91,'KABUPATEN FAKFAK',NULL,NULL,NULL,NULL),(474,91,'KABUPATEN KAIMANA',NULL,NULL,NULL,NULL),(475,91,'KABUPATEN TELUK WONDAMA',NULL,NULL,NULL,NULL),(476,91,'KABUPATEN TELUK BINTUNI',NULL,NULL,NULL,NULL),(477,91,'KABUPATEN MANOKWARI',NULL,NULL,NULL,NULL),(478,91,'KABUPATEN SORONG SELATAN',NULL,NULL,NULL,NULL),(479,91,'KABUPATEN SORONG',NULL,NULL,NULL,NULL),(480,91,'KABUPATEN RAJA AMPAT',NULL,NULL,NULL,NULL),(481,91,'KABUPATEN TAMBRAUW',NULL,NULL,NULL,NULL),(482,91,'KABUPATEN MAYBRAT',NULL,NULL,NULL,NULL),(483,91,'KABUPATEN MANOKWARI SELATAN',NULL,NULL,NULL,NULL),(484,91,'KABUPATEN PEGUNUNGAN ARFAK',NULL,NULL,NULL,NULL),(485,91,'KOTA SORONG',NULL,NULL,NULL,NULL),(486,94,'KABUPATEN MERAUKE',NULL,NULL,NULL,NULL),(487,94,'KABUPATEN JAYAWIJAYA',NULL,NULL,NULL,NULL),(488,94,'KABUPATEN JAYAPURA',NULL,NULL,NULL,NULL),(489,94,'KABUPATEN NABIRE',NULL,NULL,NULL,NULL),(490,94,'KABUPATEN KEPULAUAN YAPEN',NULL,NULL,NULL,NULL),(491,94,'KABUPATEN BIAK NUMFOR',NULL,NULL,NULL,NULL),(492,94,'KABUPATEN PANIAI',NULL,NULL,NULL,NULL),(493,94,'KABUPATEN PUNCAK JAYA',NULL,NULL,NULL,NULL),(494,94,'KABUPATEN MIMIKA',NULL,NULL,NULL,NULL),(495,94,'KABUPATEN BOVEN DIGOEL',NULL,NULL,NULL,NULL),(496,94,'KABUPATEN MAPPI',NULL,NULL,NULL,NULL),(497,94,'KABUPATEN ASMAT',NULL,NULL,NULL,NULL),(498,94,'KABUPATEN YAHUKIMO',NULL,NULL,NULL,NULL),(499,94,'KABUPATEN PEGUNUNGAN BINTANG',NULL,NULL,NULL,NULL),(500,94,'KABUPATEN TOLIKARA',NULL,NULL,NULL,NULL),(501,94,'KABUPATEN SARMI',NULL,NULL,NULL,NULL),(502,94,'KABUPATEN KEEROM',NULL,NULL,NULL,NULL),(503,94,'KABUPATEN WAROPEN',NULL,NULL,NULL,NULL),(504,94,'KABUPATEN SUPIORI',NULL,NULL,NULL,NULL),(505,94,'KABUPATEN MAMBERAMO RAYA',NULL,NULL,NULL,NULL),(506,94,'KABUPATEN NDUGA',NULL,NULL,NULL,NULL),(507,94,'KABUPATEN LANNY JAYA',NULL,NULL,NULL,NULL),(508,94,'KABUPATEN MAMBERAMO TENGAH',NULL,NULL,NULL,NULL),(509,94,'KABUPATEN YALIMO',NULL,NULL,NULL,NULL),(510,94,'KABUPATEN PUNCAK',NULL,NULL,NULL,NULL),(511,94,'KABUPATEN DOGIYAI',NULL,NULL,NULL,NULL),(512,94,'KABUPATEN INTAN JAYA',NULL,NULL,NULL,NULL),(513,94,'KABUPATEN DEIYAI',NULL,NULL,NULL,NULL),(514,94,'KOTA JAYAPURA',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `cities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `companies`
--

DROP TABLE IF EXISTS `companies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `companies` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `province_id` bigint unsigned DEFAULT NULL,
  `city_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `address` text,
  `postal_code` varchar(20) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `npwp` varchar(50) DEFAULT NULL,
  `is_main_company` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `companies_name_unique` (`name`),
  UNIQUE KEY `companies_is_main_company_unique` (`is_main_company`),
  KEY `companies_is_main_company_index` (`is_main_company`),
  KEY `fk_companies_province` (`province_id`),
  KEY `fk_companies_city` (`city_id`),
  CONSTRAINT `fk_companies_city` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_companies_province` FOREIGN KEY (`province_id`) REFERENCES `provinces` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `companies`
--

LOCK TABLES `companies` WRITE;
/*!40000 ALTER TABLE `companies` DISABLE KEYS */;
INSERT INTO `companies` VALUES (1,15,97,'PT. Jambi Lestari International','Jl. Lintas Timur KM. 12, Kel. Talang Bakung, Kec. Jambi Selatan','36139','+62-741-234567','info@jambilestari.com','www.jambilestari.com','01.234.567.8-901.000',1,'system','system','2026-03-29 11:12:54','2026-03-29 11:12:54');
/*!40000 ALTER TABLE `companies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_types`
--

DROP TABLE IF EXISTS `customer_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customer_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `customer_types_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_types`
--

LOCK TABLES `customer_types` WRITE;
/*!40000 ALTER TABLE `customer_types` DISABLE KEYS */;
INSERT INTO `customer_types` VALUES (1,'Perusahaan',NULL,NULL,NULL,NULL),(2,'BUMN',NULL,NULL,NULL,NULL),(3,'Instansi Pemerintah',NULL,NULL,NULL,NULL),(4,'Rumah Sakit',NULL,NULL,NULL,NULL),(5,'Perorangan',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `customer_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `province_id` bigint unsigned DEFAULT NULL,
  `city_id` bigint unsigned DEFAULT NULL,
  `customer_type_id` bigint unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `full_address` varchar(255) DEFAULT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `contact_person_name` varchar(255) NOT NULL,
  `contact_person_title` varchar(255) DEFAULT NULL,
  `contact_phone_number` varchar(255) NOT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `npwp` varchar(255) DEFAULT NULL,
  `registration_date` date NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `customers_name_unique` (`name`),
  KEY `customers_status_index` (`status`),
  KEY `fk_customers_user` (`user_id`),
  KEY `fk_customers_customer_type` (`customer_type_id`),
  KEY `fk_customers_province` (`province_id`),
  KEY `fk_customers_city` (`city_id`),
  CONSTRAINT `fk_customers_city` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_customers_customer_type` FOREIGN KEY (`customer_type_id`) REFERENCES `customer_types` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_customers_province` FOREIGN KEY (`province_id`) REFERENCES `provinces` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_customers_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (1,NULL,31,158,1,'PT. Laju Jaya Mandiri','Jl. Merdeka Raya No. 10, Gambir','10110','Budi Santoso','Manajer','081234567890','contact@lajujaya.com','01.234.567.8-901.234','2025-09-29',1,'system_seeder','system_seeder','2026-03-29 11:12:54','2026-03-29 11:12:54');
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exports`
--

DROP TABLE IF EXISTS `exports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `exports` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `completed_at` timestamp NULL DEFAULT NULL,
  `file_disk` varchar(255) NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `exporter` varchar(255) NOT NULL,
  `processed_rows` int unsigned NOT NULL DEFAULT '0',
  `total_rows` int unsigned NOT NULL,
  `successful_rows` int unsigned NOT NULL DEFAULT '0',
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `exports_user_id_foreign` (`user_id`),
  CONSTRAINT `exports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exports`
--

LOCK TABLES `exports` WRITE;
/*!40000 ALTER TABLE `exports` DISABLE KEYS */;
/*!40000 ALTER TABLE `exports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_import_rows`
--

DROP TABLE IF EXISTS `failed_import_rows`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_import_rows` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `data` json NOT NULL,
  `import_id` bigint unsigned NOT NULL,
  `validation_error` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `failed_import_rows_import_id_foreign` (`import_id`),
  CONSTRAINT `failed_import_rows_import_id_foreign` FOREIGN KEY (`import_id`) REFERENCES `imports` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_import_rows`
--

LOCK TABLES `failed_import_rows` WRITE;
/*!40000 ALTER TABLE `failed_import_rows` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_import_rows` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `imports`
--

DROP TABLE IF EXISTS `imports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `imports` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `completed_at` timestamp NULL DEFAULT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `importer` varchar(255) NOT NULL,
  `processed_rows` int unsigned NOT NULL DEFAULT '0',
  `total_rows` int unsigned NOT NULL,
  `successful_rows` int unsigned NOT NULL DEFAULT '0',
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `imports_user_id_foreign` (`user_id`),
  CONSTRAINT `imports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imports`
--

LOCK TABLES `imports` WRITE;
/*!40000 ALTER TABLE `imports` DISABLE KEYS */;
/*!40000 ALTER TABLE `imports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoice_items`
--

DROP TABLE IF EXISTS `invoice_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `invoice_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `invoice_id` bigint unsigned NOT NULL,
  `source_type` varchar(255) DEFAULT NULL,
  `source_id` bigint unsigned DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `source_index` (`source_type`,`source_id`),
  KEY `fk_invoice_items_invoice` (`invoice_id`),
  CONSTRAINT `fk_invoice_items_invoice` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoice_items`
--

LOCK TABLES `invoice_items` WRITE;
/*!40000 ALTER TABLE `invoice_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoice_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoices`
--

DROP TABLE IF EXISTS `invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `invoices` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `lab_job_id` bigint unsigned NOT NULL,
  `invoice_number` varchar(255) NOT NULL,
  `invoice_date` date NOT NULL,
  `due_date` date NOT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `tax_rate` decimal(5,2) NOT NULL DEFAULT '0.00',
  `total_amount` decimal(10,2) DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invoices_invoice_number_unique` (`invoice_number`),
  KEY `invoices_invoice_number_index` (`invoice_number`),
  KEY `invoices_status_index` (`status`),
  KEY `fk_invoices_lab_job` (`lab_job_id`),
  CONSTRAINT `fk_invoices_lab_job` FOREIGN KEY (`lab_job_id`) REFERENCES `lab_jobs` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoices`
--

LOCK TABLES `invoices` WRITE;
/*!40000 ALTER TABLE `invoices` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lab_job_items`
--

DROP TABLE IF EXISTS `lab_job_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lab_job_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `lab_job_id` bigint unsigned NOT NULL,
  `quotation_item_id` bigint unsigned DEFAULT NULL,
  `test_package_id` bigint unsigned DEFAULT NULL,
  `regulation_id` bigint unsigned DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  `regulation_name` varchar(255) DEFAULT NULL,
  `quantity` int NOT NULL,
  `unit` varchar(50) NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `location` varchar(100) DEFAULT NULL,
  `group` enum('A','B','C') NOT NULL DEFAULT 'A',
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_lab_job_items_lab_jobs` (`lab_job_id`),
  KEY `fk_lab_job_items_quotation_items` (`quotation_item_id`),
  KEY `fk_lab_job_items_test_packages` (`test_package_id`),
  KEY `fk_lab_job_items_regulations` (`regulation_id`),
  CONSTRAINT `fk_lab_job_items_lab_jobs` FOREIGN KEY (`lab_job_id`) REFERENCES `lab_jobs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_lab_job_items_quotation_items` FOREIGN KEY (`quotation_item_id`) REFERENCES `quotation_items` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_lab_job_items_regulations` FOREIGN KEY (`regulation_id`) REFERENCES `regulations` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_lab_job_items_test_packages` FOREIGN KEY (`test_package_id`) REFERENCES `test_packages` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lab_job_items`
--

LOCK TABLES `lab_job_items` WRITE;
/*!40000 ALTER TABLE `lab_job_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `lab_job_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lab_job_personels`
--

DROP TABLE IF EXISTS `lab_job_personels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lab_job_personels` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `lab_job_id` bigint unsigned NOT NULL,
  `personel_id` bigint unsigned NOT NULL,
  `position` enum('ketua','anggota') NOT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lab_job_personels_position_index` (`position`),
  KEY `fk_lab_job_personel_lab_jobs` (`lab_job_id`),
  KEY `fk_lab_job_personel_personels` (`personel_id`),
  CONSTRAINT `fk_lab_job_personel_lab_jobs` FOREIGN KEY (`lab_job_id`) REFERENCES `lab_jobs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_lab_job_personel_personels` FOREIGN KEY (`personel_id`) REFERENCES `personels` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lab_job_personels`
--

LOCK TABLES `lab_job_personels` WRITE;
/*!40000 ALTER TABLE `lab_job_personels` DISABLE KEYS */;
/*!40000 ALTER TABLE `lab_job_personels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lab_jobs`
--

DROP TABLE IF EXISTS `lab_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lab_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `quotation_id` bigint unsigned NOT NULL,
  `job_number` varchar(50) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lab_jobs_job_number_unique` (`job_number`),
  KEY `fk_lab_jobs_quotation` (`quotation_id`),
  CONSTRAINT `fk_lab_jobs_quotation` FOREIGN KEY (`quotation_id`) REFERENCES `quotations` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lab_jobs`
--

LOCK TABLES `lab_jobs` WRITE;
/*!40000 ALTER TABLE `lab_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `lab_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_05_16_065259_add_two_factor_columns_to_users_table',1),(5,'2025_05_16_065328_create_personal_access_tokens_table',1),(6,'2025_05_18_031741_create_cities_table',1),(7,'2025_05_18_031741_create_customer_types_table',1),(8,'2025_05_18_031741_create_provinces_table',1),(9,'2025_05_18_031742_create_customers_table',1),(10,'2025_05_18_171308_create_personel_specializations_table',1),(11,'2025_05_18_171308_create_personels_table',1),(12,'2025_05_18_171308_create_positions_table',1),(13,'2025_05_18_171308_create_specialisasi_parameters_table',1),(14,'2025_05_18_171308_create_specializations_table',1),(15,'2025_06_06_135750_create_sample_types_table',1),(16,'2025_06_06_140225_create_sample_matrics_table',1),(17,'2025_06_06_140225_create_samples_table',1),(18,'2025_06_06_140225_create_test_result_histories_table',1),(19,'2025_06_06_140225_create_test_results_table',1),(20,'2025_06_06_140530_create_regulation_types_table',1),(21,'2025_06_06_140530_create_regulations_table',1),(22,'2025_06_06_140623_create_test_methods_table',1),(23,'2025_06_06_140742_create_params_table',1),(24,'2025_06_06_140743_create_parameters_table',1),(25,'2025_06_06_140913_create_test_packages_table',1),(26,'2025_06_07_090509_create_parameter_test_packages_table',1),(27,'2025_06_10_171653_create_requests_table',1),(28,'2025_06_10_171654_create_request_items_table',1),(29,'2025_06_10_171821_create_lab_jobs_table',1),(30,'2025_06_10_171822_create_lab_job_items_table',1),(31,'2025_06_10_171822_create_lab_job_personels_table',1),(32,'2025_06_10_171822_create_parameter_lab_job_items_table',1),(33,'2025_06_11_034617_create_quotations_table',1),(34,'2025_06_11_034718_create_parameter_quotation_items_table',1),(35,'2025_06_11_034718_create_quoatation_items_table',1),(36,'2025_06_12_045353_create_term_templates_table',1),(37,'2025_06_12_153003_create_companies_table',1),(38,'2025_06_12_153004_create_invoices_table',1),(39,'2025_06_12_153004_create_settings_table',1),(40,'2025_06_12_153005_create_invoice_items_table',1),(41,'2025_06_12_153006_create_payments_table',1),(42,'2025_06_12_172205_add_foreign',1),(43,'2025_06_30_171708_create_notifications_table',1),(44,'2025_10_07_080718_create_imports_table',1),(45,'2025_10_07_080719_create_exports_table',1),(46,'2025_10_07_080720_create_failed_import_rows_table',1),(47,'2026_06_07_090510_create_permission_tables',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` VALUES (1,'App\\Models\\User',1);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint unsigned NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parameter_lab_job_items`
--

DROP TABLE IF EXISTS `parameter_lab_job_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `parameter_lab_job_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `lab_job_item_id` bigint unsigned NOT NULL,
  `parameter_id` bigint unsigned NOT NULL,
  `parameter_code` varchar(255) DEFAULT NULL,
  `parameter_unit` varchar(50) DEFAULT NULL,
  `parameter_price` decimal(10,2) DEFAULT NULL,
  `parameter_test_method_name` varchar(50) DEFAULT NULL,
  `parameter_standard_notes` varchar(50) DEFAULT NULL,
  `parameter_description` text,
  `parameter_status` enum('1','2','3','4','5') DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_parameter_lab_job_items_lab_job_items` (`lab_job_item_id`),
  KEY `fk_parameter_lab_job_items_parameters` (`parameter_id`),
  CONSTRAINT `fk_parameter_lab_job_items_lab_job_items` FOREIGN KEY (`lab_job_item_id`) REFERENCES `lab_job_items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_parameter_lab_job_items_parameters` FOREIGN KEY (`parameter_id`) REFERENCES `parameters` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parameter_lab_job_items`
--

LOCK TABLES `parameter_lab_job_items` WRITE;
/*!40000 ALTER TABLE `parameter_lab_job_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `parameter_lab_job_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parameter_quotation_items`
--

DROP TABLE IF EXISTS `parameter_quotation_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `parameter_quotation_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `quotation_item_id` bigint unsigned NOT NULL,
  `parameter_id` bigint unsigned DEFAULT NULL,
  `parameter_code` varchar(255) DEFAULT NULL,
  `parameter_unit` varchar(50) DEFAULT NULL,
  `parameter_price` decimal(15,2) DEFAULT NULL,
  `parameter_test_method_name` varchar(50) DEFAULT NULL,
  `parameter_standard_notes` varchar(50) DEFAULT NULL,
  `parameter_description` text,
  `parameter_status` enum('1','2','3','4','5') DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_parameter_quotation_items_quotation_items` (`quotation_item_id`),
  KEY `fk_parameter_quotation_items_parameters` (`parameter_id`),
  CONSTRAINT `fk_parameter_quotation_items_parameters` FOREIGN KEY (`parameter_id`) REFERENCES `parameters` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_parameter_quotation_items_quotation_items` FOREIGN KEY (`quotation_item_id`) REFERENCES `quotation_items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parameter_quotation_items`
--

LOCK TABLES `parameter_quotation_items` WRITE;
/*!40000 ALTER TABLE `parameter_quotation_items` DISABLE KEYS */;
INSERT INTO `parameter_quotation_items` VALUES (13,1,1,'SO2','ug/m3',185000.00,'SNI 7119-7:2017','150',NULL,'1','superadmin',NULL,'2026-03-29 11:21:50','2026-03-29 11:21:50'),(14,1,2,'SO2','ug/m3',185000.00,'SNI 7119-7:2017','75',NULL,'2','superadmin',NULL,'2026-03-29 11:21:50','2026-03-29 11:21:50'),(15,1,3,'CO','ug/m3',185000.00,'IKM.JLI-22 (CO meter)','10000',NULL,'1','superadmin',NULL,'2026-03-29 11:21:50','2026-03-29 11:21:50'),(16,1,4,'CO','ug/m3',185000.00,'IKM.JLI-22 (CO meter)','4000',NULL,'1','superadmin',NULL,'2026-03-29 11:21:50','2026-03-29 11:21:50'),(17,1,5,'NO2','ug/m3',185000.00,'SNI 19-7119.2-2005','200',NULL,'1','superadmin',NULL,'2026-03-29 11:21:50','2026-03-29 11:21:50'),(18,1,7,'O3','ug/m3',185000.00,'SNI 19-7119.8-2005','150',NULL,'1','superadmin',NULL,'2026-03-29 11:21:50','2026-03-29 11:21:50'),(19,1,8,'O4','ug/m3',185000.00,'SNI 19-7119.8-2005','100',NULL,'2','superadmin',NULL,'2026-03-29 11:21:50','2026-03-29 11:21:50'),(20,1,9,'NMHC','ug/m3',2015000.00,'SNI 7119.13:2009','160',NULL,'3','superadmin',NULL,'2026-03-29 11:21:50','2026-03-29 11:21:50'),(21,1,10,'TSP','ug/m3',450000.00,'SNI 7119-3-2017','230',NULL,'1','superadmin',NULL,'2026-03-29 11:21:50','2026-03-29 11:21:50'),(22,1,11,'PM10','ug/m3',250000.00,'SNI 7119-15:2016','75',NULL,'1','superadmin',NULL,'2026-03-29 11:21:50','2026-03-29 11:21:50'),(23,1,12,'PM2.5','ug/m3',200000.00,'SNI 7119-14:2016','55',NULL,'1','superadmin',NULL,'2026-03-29 11:21:50','2026-03-29 11:21:50'),(24,1,13,'Pb','ug/m3',185000.00,'SNI 7119-4:2017','2',NULL,'1','superadmin',NULL,'2026-03-29 11:21:50','2026-03-29 11:21:50'),(65,2,45,'CO','%',275000.00,NULL,'M = 4, N = 4 , O = 4',NULL,'2','superadmin',NULL,'2026-03-30 16:45:54','2026-03-30 16:45:54'),(66,2,53,'HC','ppm',275000.00,NULL,'L=-,M=150,N=200,O=200',NULL,'2','superadmin',NULL,'2026-03-30 16:45:54','2026-03-30 16:45:54'),(67,2,54,'HC','ppm',275000.00,NULL,'L=-,M=1100,N=150,O=150',NULL,'2','superadmin',NULL,'2026-03-30 16:45:54','2026-03-30 16:45:54'),(68,2,56,'HC','ppm',275000.00,NULL,'L=2200,M=-,N=-,O=-',NULL,'2','superadmin',NULL,'2026-03-30 16:45:54','2026-03-30 16:45:54'),(69,2,57,'HC','ppm',275000.00,NULL,'L=1800,M=-,N=-,O=-',NULL,'2','superadmin',NULL,'2026-03-30 16:45:54','2026-03-30 16:45:54'),(70,2,58,'HC','ppm',275000.00,NULL,'L=1000,M=-,N=-,O=-',NULL,'2','superadmin',NULL,'2026-03-30 16:45:54','2026-03-30 16:45:54'),(71,2,511,'HC','ppm',275000.00,NULL,'L=6000,M=-,N=-,O=-',NULL,'2','superadmin',NULL,'2026-03-30 16:45:54','2026-03-30 16:45:54'),(78,3,14,'Wind Speed','m/dtk',0.00,'IKM.JLI-30 (Anemometer)','-',NULL,'1','superadmin',NULL,'2026-03-30 16:46:22','2026-03-30 16:46:22'),(79,3,15,'Pressure','mmHg',0.00,'IKM.JLI-30 (Anemometer)','-',NULL,'1','superadmin',NULL,'2026-03-30 16:46:22','2026-03-30 16:46:22'),(80,3,16,'Humidity','%',0.00,'IKM.JLI-30 (Anemometer)','-',NULL,'1','superadmin',NULL,'2026-03-30 16:46:22','2026-03-30 16:46:22'),(81,3,17,'Air Temperature','°C',0.00,'IKM.JLI-30 (Anemometer)','-',NULL,'1','superadmin',NULL,'2026-03-30 16:46:22','2026-03-30 16:46:22'),(82,3,18,'Wind Direction','-',0.00,'IKM.JLI-166 (Weather Station)','-',NULL,'1','superadmin',NULL,'2026-03-30 16:46:22','2026-03-30 16:46:22'),(83,3,19,'Weather','-',0.00,NULL,'-',NULL,'1','superadmin',NULL,'2026-03-30 16:46:22','2026-03-30 16:46:22'),(88,4,41,'Shock Vibration','mm/detik',100000.00,'IKM.JLI-37 (Vibration meter)','2',NULL,'2','superadmin',NULL,'2026-03-30 16:46:49','2026-03-30 16:46:49'),(89,4,42,'Shock Vibration','mm/detik',100000.00,'IKM.JLI-37 (Vibration meter)','5',NULL,'2','superadmin',NULL,'2026-03-30 16:46:49','2026-03-30 16:46:49'),(90,4,43,'Shock Vibration','mm/detik',100000.00,'IKM.JLI-37 (Vibration meter)','10',NULL,'2','superadmin',NULL,'2026-03-30 16:46:49','2026-03-30 16:46:49'),(91,4,44,'Shock Vibration','mm/detik',100000.00,'IKM.JLI-37 (Vibration meter)','10-40',NULL,'2','superadmin',NULL,'2026-03-30 16:46:49','2026-03-30 16:46:49');
/*!40000 ALTER TABLE `parameter_quotation_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parameter_test_packages`
--

DROP TABLE IF EXISTS `parameter_test_packages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `parameter_test_packages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `test_package_id` bigint unsigned NOT NULL,
  `parameter_id` bigint unsigned DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `parameter_test_packages_test_package_id_parameter_id_unique` (`test_package_id`,`parameter_id`),
  KEY `fk_parameter_test_packages_parameters` (`parameter_id`),
  CONSTRAINT `fk_parameter_test_packages_parameters` FOREIGN KEY (`parameter_id`) REFERENCES `parameters` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_parameter_test_packages_test_packages` FOREIGN KEY (`test_package_id`) REFERENCES `test_packages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=120 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parameter_test_packages`
--

LOCK TABLES `parameter_test_packages` WRITE;
/*!40000 ALTER TABLE `parameter_test_packages` DISABLE KEYS */;
INSERT INTO `parameter_test_packages` VALUES (1,1,1,'superadmin',NULL,'2026-03-29 11:14:49','2026-03-29 11:14:49'),(2,1,2,'superadmin',NULL,'2026-03-29 11:15:15','2026-03-29 11:15:15'),(3,1,3,'superadmin',NULL,'2026-03-29 11:15:36','2026-03-29 11:15:36'),(4,1,4,'superadmin',NULL,'2026-03-29 11:16:03','2026-03-29 11:16:03'),(5,1,5,'superadmin',NULL,'2026-03-29 11:16:31','2026-03-29 11:16:31'),(6,1,8,'superadmin',NULL,'2026-03-29 11:16:58','2026-03-29 11:16:58'),(7,1,7,'superadmin',NULL,'2026-03-29 11:18:18','2026-03-29 11:18:18'),(8,1,9,'superadmin',NULL,'2026-03-29 11:19:02','2026-03-29 11:19:02'),(9,1,10,'superadmin',NULL,'2026-03-29 11:19:26','2026-03-29 11:19:26'),(10,1,11,'superadmin',NULL,'2026-03-29 11:20:12','2026-03-29 11:20:12'),(11,1,12,'superadmin',NULL,'2026-03-29 11:20:38','2026-03-29 11:20:38'),(12,1,13,'superadmin',NULL,'2026-03-29 11:21:02','2026-03-29 11:21:02'),(13,2,14,'superadmin',NULL,'2026-03-29 15:40:48','2026-03-29 15:40:48'),(14,2,15,'superadmin',NULL,'2026-03-29 15:41:15','2026-03-29 15:41:15'),(15,2,16,'superadmin',NULL,'2026-03-29 15:41:43','2026-03-29 15:41:43'),(16,2,17,'superadmin',NULL,'2026-03-29 15:42:18','2026-03-29 15:42:18'),(17,2,18,'superadmin',NULL,'2026-03-29 15:42:52','2026-03-29 15:42:52'),(18,2,19,'superadmin',NULL,'2026-03-29 15:43:27','2026-03-29 15:43:27'),(19,3,20,'superadmin',NULL,'2026-03-29 15:45:35','2026-03-29 15:45:35'),(20,3,21,'superadmin',NULL,'2026-03-29 15:45:52','2026-03-29 15:45:52'),(21,3,22,'superadmin',NULL,'2026-03-29 15:46:04','2026-03-29 15:46:04'),(22,3,23,'superadmin',NULL,'2026-03-29 15:46:17','2026-03-29 15:46:17'),(23,3,24,'superadmin',NULL,'2026-03-29 15:46:35','2026-03-29 15:46:35'),(24,4,25,'superadmin',NULL,'2026-03-29 15:48:24','2026-03-29 15:48:24'),(25,4,26,'superadmin',NULL,'2026-03-29 15:48:41','2026-03-29 15:48:41'),(26,4,27,'superadmin',NULL,'2026-03-29 15:48:55','2026-03-29 15:48:55'),(27,4,28,'superadmin',NULL,'2026-03-29 15:49:17','2026-03-29 15:49:17'),(28,4,29,'superadmin',NULL,'2026-03-29 15:49:38','2026-03-29 15:49:38'),(29,4,30,'superadmin',NULL,'2026-03-29 15:49:58','2026-03-29 15:49:58'),(30,4,31,'superadmin',NULL,'2026-03-29 15:50:17','2026-03-29 15:50:17'),(31,4,32,'superadmin',NULL,'2026-03-29 15:50:31','2026-03-29 15:50:31'),(32,4,33,'superadmin',NULL,'2026-03-29 15:50:48','2026-03-29 15:50:48'),(33,4,34,'superadmin',NULL,'2026-03-29 15:51:04','2026-03-29 15:51:04'),(34,4,35,'superadmin',NULL,'2026-03-29 15:51:19','2026-03-29 15:51:19'),(35,4,36,'superadmin',NULL,'2026-03-29 15:51:35','2026-03-29 15:51:35'),(36,4,37,'superadmin',NULL,'2026-03-29 15:51:49','2026-03-29 15:51:49'),(37,4,38,'superadmin',NULL,'2026-03-29 15:52:03','2026-03-29 15:52:03'),(38,5,39,'superadmin',NULL,'2026-03-30 15:47:43','2026-03-30 15:47:43'),(39,5,40,'superadmin',NULL,'2026-03-30 15:48:00','2026-03-30 15:48:00'),(40,5,14,'superadmin',NULL,'2026-03-30 15:50:04','2026-03-30 15:50:04'),(42,5,15,'superadmin',NULL,'2026-03-30 15:52:38','2026-03-30 15:52:38'),(43,5,16,'superadmin',NULL,'2026-03-30 15:52:53','2026-03-30 15:52:53'),(44,5,17,'superadmin',NULL,'2026-03-30 15:53:11','2026-03-30 15:53:11'),(45,5,18,'superadmin',NULL,'2026-03-30 15:53:31','2026-03-30 15:53:31'),(46,5,19,'superadmin',NULL,'2026-03-30 15:54:10','2026-03-30 15:54:10'),(47,6,42,'superadmin',NULL,'2026-03-30 15:55:42','2026-03-30 15:55:42'),(48,6,41,'superadmin',NULL,'2026-03-30 15:59:54','2026-03-30 15:59:54'),(49,6,44,'superadmin',NULL,'2026-03-30 16:00:18','2026-03-30 16:00:18'),(50,6,43,'superadmin',NULL,'2026-03-30 16:00:44','2026-03-30 16:00:44'),(51,7,45,'superadmin',NULL,'2026-03-30 16:20:19','2026-03-30 16:20:19'),(52,7,46,'superadmin',NULL,'2026-03-30 16:20:36','2026-03-30 16:20:36'),(53,7,47,'superadmin',NULL,'2026-03-30 16:20:53','2026-03-30 16:20:53'),(54,7,48,'superadmin',NULL,'2026-03-30 16:21:20','2026-03-30 16:21:20'),(55,7,49,'superadmin',NULL,'2026-03-30 16:21:44','2026-03-30 16:21:44'),(56,7,50,'superadmin',NULL,'2026-03-30 16:22:05','2026-03-30 16:22:05'),(57,7,51,'superadmin',NULL,'2026-03-30 16:22:26','2026-03-30 16:22:26'),(58,7,52,'superadmin',NULL,'2026-03-30 16:23:10','2026-03-30 16:23:10'),(59,7,53,'superadmin',NULL,'2026-03-30 16:23:37','2026-03-30 16:23:37'),(60,7,54,'superadmin',NULL,'2026-03-30 16:23:54','2026-03-30 16:23:54'),(61,7,57,'superadmin',NULL,'2026-03-30 16:24:36','2026-03-30 16:24:36'),(62,7,58,'superadmin',NULL,'2026-03-30 16:25:14','2026-03-30 16:25:14'),(63,7,56,'superadmin',NULL,'2026-03-30 16:25:33','2026-03-30 16:25:33'),(64,7,511,'superadmin',NULL,'2026-03-30 16:30:28','2026-03-30 16:30:28'),(65,7,59,'superadmin',NULL,'2026-03-30 16:31:53','2026-03-30 16:31:53'),(66,7,60,'superadmin',NULL,'2026-03-30 16:32:10','2026-03-30 16:32:10'),(67,7,61,'superadmin',NULL,'2026-03-30 16:32:32','2026-03-30 16:32:32'),(78,7,64,NULL,NULL,NULL,NULL),(79,7,62,NULL,NULL,NULL,NULL),(81,7,63,'superadmin',NULL,'2026-03-30 16:41:52','2026-03-30 16:41:52'),(82,8,80,'superadmin',NULL,'2026-03-31 14:58:43','2026-03-31 14:58:43'),(83,8,81,'superadmin',NULL,'2026-03-31 14:59:14','2026-03-31 14:59:14'),(84,8,82,'superadmin',NULL,'2026-03-31 14:59:28','2026-03-31 14:59:28'),(85,8,67,'superadmin',NULL,'2026-03-31 14:59:44','2026-03-31 14:59:44'),(86,8,83,'superadmin',NULL,'2026-03-31 15:01:03','2026-03-31 15:01:03'),(87,8,84,'superadmin',NULL,'2026-03-31 15:01:29','2026-03-31 15:01:29'),(88,8,85,'superadmin',NULL,'2026-03-31 15:01:47','2026-03-31 15:01:47'),(89,8,86,'superadmin',NULL,'2026-03-31 15:02:05','2026-03-31 15:02:05'),(90,9,71,'superadmin',NULL,'2026-03-31 15:03:16','2026-03-31 15:03:16'),(91,9,72,'superadmin',NULL,'2026-03-31 15:03:29','2026-03-31 15:03:29'),(92,9,69,'superadmin',NULL,'2026-03-31 15:03:43','2026-03-31 15:03:43'),(93,9,67,'superadmin',NULL,'2026-03-31 15:03:57','2026-03-31 15:03:57'),(94,9,66,'superadmin',NULL,'2026-03-31 15:04:13','2026-03-31 15:04:13'),(95,9,65,'superadmin',NULL,'2026-03-31 15:04:27','2026-03-31 15:04:27'),(96,9,68,'superadmin',NULL,'2026-03-31 15:04:41','2026-03-31 15:04:41'),(97,9,86,'superadmin',NULL,'2026-03-31 15:04:56','2026-03-31 15:04:56'),(98,9,73,'superadmin',NULL,'2026-03-31 15:05:15','2026-03-31 15:05:15'),(99,9,74,'superadmin',NULL,'2026-03-31 15:05:32','2026-03-31 15:05:32'),(100,9,75,'superadmin',NULL,'2026-03-31 15:05:59','2026-03-31 15:05:59'),(101,9,76,'superadmin',NULL,'2026-03-31 15:06:18','2026-03-31 15:06:18'),(102,9,77,'superadmin',NULL,'2026-03-31 15:07:08','2026-03-31 15:07:08'),(103,9,78,'superadmin',NULL,'2026-03-31 15:07:28','2026-03-31 15:07:28'),(104,9,79,'superadmin',NULL,'2026-03-31 15:07:52','2026-03-31 15:07:52'),(105,10,71,'superadmin',NULL,'2026-04-01 16:28:52','2026-04-01 16:28:52'),(106,10,72,'superadmin',NULL,'2026-04-01 16:29:07','2026-04-01 16:29:07'),(107,10,69,'superadmin',NULL,'2026-04-01 16:29:20','2026-04-01 16:29:20'),(108,10,67,'superadmin',NULL,'2026-04-01 16:29:35','2026-04-01 16:29:35'),(109,10,66,'superadmin',NULL,'2026-04-01 16:29:53','2026-04-01 16:29:53'),(110,10,65,'superadmin',NULL,'2026-04-01 16:30:10','2026-04-01 16:30:10'),(111,10,68,'superadmin',NULL,'2026-04-01 16:30:22','2026-04-01 16:30:22'),(112,10,86,'superadmin',NULL,'2026-04-01 16:30:44','2026-04-01 16:30:44'),(113,10,73,'superadmin',NULL,'2026-04-01 16:31:01','2026-04-01 16:31:01'),(114,10,74,'superadmin',NULL,'2026-04-01 16:31:18','2026-04-01 16:31:18'),(115,10,75,'superadmin',NULL,'2026-04-01 16:31:42','2026-04-01 16:31:42'),(116,10,76,'superadmin',NULL,'2026-04-01 16:31:54','2026-04-01 16:31:54'),(117,10,77,'superadmin',NULL,'2026-04-01 16:32:12','2026-04-01 16:32:12'),(118,10,78,'superadmin',NULL,'2026-04-01 16:32:26','2026-04-01 16:32:26'),(119,10,79,'superadmin',NULL,'2026-04-01 16:32:42','2026-04-01 16:32:42');
/*!40000 ALTER TABLE `parameter_test_packages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parameters`
--

DROP TABLE IF EXISTS `parameters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `parameters` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `test_method_id` bigint unsigned DEFAULT NULL,
  `code` varchar(50) DEFAULT NULL,
  `long_name` varchar(255) NOT NULL,
  `long_name_standard_notes` varchar(255) GENERATED ALWAYS AS (if(((`standard_notes` is null) or (`standard_notes` = _utf8mb4'')),`long_name`,concat(`long_name`,_utf8mb4' (',`standard_notes`,_utf8mb4')'))) VIRTUAL,
  `unit` varchar(50) DEFAULT NULL,
  `description` text,
  `default_price` decimal(15,2) DEFAULT NULL,
  `status` tinyint DEFAULT '1',
  `tested_time` int DEFAULT NULL,
  `standard_notes` varchar(255) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parameters_long_name_index` (`long_name`),
  KEY `parameters_status_index` (`status`),
  KEY `fk_parameters_params` (`code`),
  KEY `fk_parameters_test_method` (`test_method_id`),
  KEY `parameters_long_name_standard_notes_index` (`long_name_standard_notes`),
  CONSTRAINT `fk_parameters_params` FOREIGN KEY (`code`) REFERENCES `params` (`code`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_parameters_test_method` FOREIGN KEY (`test_method_id`) REFERENCES `test_methods` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=512 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parameters`
--

LOCK TABLES `parameters` WRITE;
/*!40000 ALTER TABLE `parameters` DISABLE KEYS */;
INSERT INTO `parameters` (`id`, `test_method_id`, `code`, `long_name`, `unit`, `description`, `default_price`, `status`, `tested_time`, `standard_notes`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES (1,1,'SO2','Sulfur Dioksida/ Sulphur Dioxide, (SO2)','ug/m3',NULL,185000.00,1,NULL,'150',NULL,NULL,NULL,NULL),(2,1,'SO2','Sulfur Dioksida/ Sulphur Dioxide, (SO2)','ug/m3',NULL,185000.00,2,NULL,'75',NULL,NULL,NULL,NULL),(3,2,'CO','Karbon Monoksida/ Carbon Monoxide, (CO)','ug/m3',NULL,185000.00,1,NULL,'10000',NULL,NULL,NULL,NULL),(4,2,'CO','Karbon Monoksida/ Carbon Monoxide, (CO)','ug/m3',NULL,185000.00,1,NULL,'4000',NULL,NULL,NULL,NULL),(5,3,'NO2','Nitrogen Dioksida/ Nitrogen Dioxide, (NO2)','ug/m3',NULL,185000.00,1,NULL,'200',NULL,NULL,NULL,NULL),(6,3,'NO2','Nitrogen Dioksida/ Nitrogen Dioxide, (NO2)','ug/m3',NULL,185000.00,2,NULL,'65',NULL,NULL,NULL,NULL),(7,4,'O3','Oksidan Fotokimia Sebagai Ozon/ Photochemical Oxidant (Ox) As Ozone, (O3)','ug/m3',NULL,185000.00,1,NULL,'150',NULL,NULL,NULL,NULL),(8,4,'O4','Oksidan Fotokimia Sebagai Ozon/ Photochemical Oxidant (Ox) As Ozone, (O3)','ug/m3',NULL,185000.00,2,NULL,'100',NULL,NULL,NULL,NULL),(9,5,'NMHC','Hidrokarbon non Metana/Non-Methane Hydrocarbons, (NMHC)','ug/m3',NULL,2015000.00,3,NULL,'160',NULL,NULL,NULL,NULL),(10,6,'TSP','Partikulat Debu <100um/ Particulate Matter < 100um, (TSP)','ug/m3',NULL,450000.00,1,NULL,'230',NULL,NULL,NULL,NULL),(11,7,'PM10','Partikulat Debu <10um/ Particulate Matter < 10um, (PM10','ug/m3',NULL,250000.00,1,NULL,'75',NULL,NULL,NULL,NULL),(12,8,'PM2.5','Partikulat Debu <2.5um/ Particulate Matter < 2.5um, (PM2.5)','ug/m3',NULL,200000.00,1,NULL,'55',NULL,NULL,NULL,NULL),(13,9,'Pb','Timbal/Lead, (Pb)','ug/m3',NULL,185000.00,1,NULL,'2',NULL,NULL,NULL,NULL),(14,10,'Wind Speed','Kecepatan Angin/ Wind Speed','m/dtk',NULL,0.00,1,NULL,'-',NULL,NULL,NULL,NULL),(15,10,'Pressure','Tekanan Udara/ Pressure','mmHg',NULL,0.00,1,NULL,'-',NULL,NULL,NULL,NULL),(16,10,'Humidity','Kelembaban Udara/Humidity','%',NULL,0.00,1,NULL,'-',NULL,NULL,NULL,NULL),(17,10,'Air Temperature','Suhu Udara/ Air Temperature','°C',NULL,0.00,1,NULL,'-',NULL,NULL,NULL,NULL),(18,11,'Wind Direction','Arah Angin/Wind Direction','-',NULL,0.00,1,NULL,'-',NULL,NULL,NULL,NULL),(19,NULL,'Weather','Kondisi Cuaca/Weather','-',NULL,0.00,1,NULL,'-',NULL,NULL,NULL,NULL),(20,12,'NH3','Amoniak/Ammonia, (NH3)','ppm',NULL,187500.00,1,NULL,'2.0',NULL,NULL,NULL,NULL),(21,13,'CH3SH','Metil Merkaptana/Methyl Mercaptane, (CH3SH)','ppm',NULL,187500.00,3,NULL,'0.002',NULL,NULL,NULL,NULL),(22,14,'H2S','Hidrogen Sulfida/Hydrogen Sulphide, (H2S)','ppm',NULL,225000.00,1,NULL,'0.02',NULL,NULL,NULL,NULL),(23,15,'(CH3)2S','Metil Sulfida/Methyl Sulphide ((CH3)2)S)','ppm',NULL,225000.00,3,NULL,'0.01',NULL,NULL,NULL,NULL),(24,16,'C6H8CHCH2','Stirena/Styrene (C6H8CHCH2)','ppm',NULL,225000.00,3,NULL,'0.1',NULL,NULL,NULL,NULL),(25,17,'LSM','Tingkat Kebisingan Siang Malam/Day & Evening Noise Level, (LSM) Perumahan dan pemukiman','dB(A)',NULL,250000.00,1,NULL,'55',NULL,NULL,NULL,NULL),(26,17,'LSM','Tingkat Kebisingan Siang Malam/Day & Evening Noise Level, (LSM) Perdagangan dan Jasa','dB(A)',NULL,250000.00,1,NULL,'70',NULL,NULL,NULL,NULL),(27,17,'LSM','Tingkat Kebisingan Siang Malam/Day & Evening Noise Level, (LSM) Perkantoran dan Perdagangan','dB(A)',NULL,250000.00,1,NULL,'65',NULL,NULL,NULL,NULL),(28,17,'LSM','Tingkat Kebisingan Siang Malam/Day & Evening Noise Level, (LSM) Ruang terbuka hijau','dB(A)',NULL,250000.00,1,NULL,'50',NULL,NULL,NULL,NULL),(29,17,'LSM','Tingkat Kebisingan Siang Malam/Day & Evening Noise Level, (LSM) Industri','dB(A)',NULL,250000.00,1,NULL,'70',NULL,NULL,NULL,NULL),(30,17,'LSM','Tingkat Kebisingan Siang Malam/Day & Evening Noise Level, (LSM) Pemerintahan dan fasilitas umum','dB(A)',NULL,250000.00,1,NULL,'60',NULL,NULL,NULL,NULL),(31,17,'LSM','Tingkat Kebisingan Siang Malam/Day & Evening Noise Level, (LSM) Rekreasi','dB(A)',NULL,250000.00,1,NULL,'70',NULL,NULL,NULL,NULL),(32,17,'LSM','Tingkat Kebisingan Siang Malam/Day & Evening Noise Level, (LSM) Khusus Pelabuhan Laut','dB(A)',NULL,250000.00,1,NULL,'70',NULL,NULL,NULL,NULL),(33,17,'LSM','Tingkat Kebisingan Siang Malam/Day & Evening Noise Level, (LSM) Khusus Cagar Budaya','dB(A)',NULL,250000.00,1,NULL,'60',NULL,NULL,NULL,NULL),(34,17,'LSM','Tingkat Kebisingan Siang Malam/Day & Evening Noise Level, (LSM) Rumah sakit dan sejenisnya','dB(A)',NULL,250000.00,1,NULL,'55',NULL,NULL,NULL,NULL),(35,17,'LSM','Tingkat Kebisingan Siang Malam/Day & Evening Noise Level, (LSM) Sekolah Atau sejenisnya','dB(A)',NULL,250000.00,1,NULL,'55',NULL,NULL,NULL,NULL),(36,17,'LSM','Tingkat Kebisingan Siang Malam/Day & Evening Noise Level, (LSM) Tempat Ibadah atau Sejenisnya','dB(A)',NULL,250000.00,1,NULL,'55',NULL,NULL,NULL,NULL),(37,17,'Lavg','Tingkat Kebisingan Rata-Rata/Noise Level Average, (Lavg)',NULL,NULL,100000.00,1,NULL,NULL,NULL,NULL,NULL,NULL),(38,NULL,'Leq','Tingkat Kebisingan Ekuivalen/Noise Level Equivalent, (Leq)',NULL,NULL,100000.00,1,NULL,NULL,NULL,NULL,NULL,NULL),(39,17,'LS','Tingkat Kebisingan Siang/Day Noise Level , (LS)','dB(A)',NULL,250000.00,1,NULL,'-',NULL,NULL,NULL,NULL),(40,17,'LM','Tingkat Kebisingan Malam/Evening Noise Level , (LM)','dB(A)',NULL,250000.00,1,NULL,'-',NULL,NULL,NULL,NULL),(41,18,'Shock Vibration','Getaran Kejut/Shock Vibration (Peruntukan dan bangunan kuno yang memiliki nilai sejarah yang  tinggi)','mm/detik',NULL,100000.00,2,NULL,'2',NULL,'superadmin',NULL,'2026-03-30 15:59:18'),(42,18,'Shock Vibration','Getaran Kejut/Shock Vibration (Bangunan dengan kerusakan yang sudah ada, tampak keretakan-keretakan pada tembok)','mm/detik',NULL,100000.00,2,NULL,'5',NULL,'superadmin',NULL,'2026-03-30 15:59:34'),(43,18,'Shock Vibration','Getaran Kejut/Shock Vibration (Bangunan untuk dalam kondisi teknis yang baik, ada kerusakan-kerusakan kecil seperti : plasteran yang retak)','mm/detik',NULL,100000.00,2,NULL,'10',NULL,NULL,NULL,NULL),(44,18,'Shock Vibration','Getaran Kejut/Shock Vibration (Bangunan \"kuat\" ( misalnya : bangunan industri terbuat danri beton atau baja )','mm/detik',NULL,100000.00,2,NULL,'10-40',NULL,NULL,NULL,NULL),(45,NULL,'CO','CO (<2007) Mobil berpenggerak motor bakar cetus api (bensin)','%',NULL,275000.00,2,NULL,'M = 4, N = 4 , O = 4',NULL,NULL,NULL,NULL),(46,NULL,'CO','CO (2007-2018) Mobil berpenggerak motor bakar cetus api (bensin)','%',NULL,275000.00,2,NULL,'M=1, N=1, O=1',NULL,NULL,NULL,NULL),(47,NULL,'CO','CO (>2018) Mobil berpenggerak motor bakar cetus api (bensin)','%',NULL,275000.00,2,NULL,'M = 0.5, N=0.5, O=0.5',NULL,NULL,NULL,NULL),(48,NULL,'CO','CO (<2010 (2 langkah)) Sepeda motor berpenggerak penyalaan cetus api (bensin)','%',NULL,275000.00,2,NULL,'L = 4.5',NULL,NULL,NULL,NULL),(49,NULL,'CO','CO (<2010 (4 langkah) ) Sepeda motor berpenggerak penyalaan cetus api (bensin)','%',NULL,275000.00,2,NULL,'L = 5,5',NULL,NULL,NULL,NULL),(50,NULL,'CO','CO (2010-2016) Sepeda motor berpenggerak penyalaan cetus api (bensin)','%',NULL,275000.00,2,NULL,'L = 4',NULL,NULL,NULL,NULL),(51,NULL,'CO','CO (>2016) Sepeda motor berpenggerak penyalaan cetus api (bensin)','%',NULL,275000.00,2,NULL,'L = 3',NULL,NULL,NULL,NULL),(52,NULL,'HC','HC <2007 (Mobil berpenggerak motor bakar cetus api (bensin))','ppm',NULL,275000.00,2,NULL,'L=-,M=1000,N=1100,O=1100',NULL,NULL,NULL,NULL),(53,NULL,'HC','HC 2007-2018 (Mobil berpenggerak motor bakar cetus api (bensin))','ppm',NULL,275000.00,2,NULL,'L=-,M=150,N=200,O=200',NULL,NULL,NULL,NULL),(54,NULL,'HC','HC >2018 (Mobil berpenggerak motor bakar cetus api (bensin))','ppm',NULL,275000.00,2,NULL,'L=-,M=1100,N=150,O=150',NULL,NULL,NULL,NULL),(55,NULL,'HC','HC <2010 (2 langkah) (Mobil berpenggerak motor bakar cetus api (bensin))','ppm',NULL,275000.00,2,NULL,'L=6000,M=-,N=-,O=-',NULL,NULL,NULL,NULL),(56,NULL,'HC','HC <2010 (4 langkah) (Sepeda motor berpenggerak penyalaan cetus api (bensin))','ppm',NULL,275000.00,2,NULL,'L=2200,M=-,N=-,O=-',NULL,'superadmin',NULL,'2026-03-30 16:30:08'),(57,NULL,'HC','HC 2010-2016 (Sepeda motor berpenggerak penyalaan cetus api (bensin))','ppm',NULL,275000.00,2,NULL,'L=1800,M=-,N=-,O=-',NULL,NULL,NULL,NULL),(58,NULL,'HC','HC >2016 (Sepeda motor berpenggerak penyalaan cetus api (bensin))','ppm',NULL,275000.00,2,NULL,'L=1000,M=-,N=-,O=-',NULL,NULL,NULL,NULL),(59,19,'Opacity','Opasitas (Mobil berpenggerak motor bakar penyalaan kompresi (diesel) JBB ≤ 3.5 ton)','% HSU',NULL,550000.00,1,NULL,'M=65,N=65,0=65',NULL,NULL,NULL,NULL),(60,19,'Opacity','Opasitas (Mobil berpenggerak motor bakar penyalaan kompresi (diesel) JBB ≤ 3.5 ton)','% HSU',NULL,550000.00,1,NULL,'M=40,N=40,O=40',NULL,NULL,NULL,NULL),(61,19,'Opacity','Opasitas (Mobil berpenggerak motor bakar penyalaan kompresi (diesel) JBB ≤ 3.5 ton)','% HSU',NULL,550000.00,1,NULL,'M=30,N=30,O=30',NULL,NULL,NULL,NULL),(62,19,'Opacity','Opasitas (Mobil berpenggerak motor bakar penyalaan kompresi (diesel) GVW > 3.5 ton)','% HSU',NULL,550000.00,1,NULL,'M=65,N=65,0=65',NULL,NULL,NULL,NULL),(63,19,'Opacity','Opasitas (Mobil berpenggerak motor bakar penyalaan kompresi (diesel) GVW > 3.5 ton)','% HSU',NULL,550000.00,1,NULL,'M=40,N=40,O=40',NULL,NULL,NULL,NULL),(64,19,'Opasitas','Opasitas (Mobil berpenggerak motor bakar penyalaan kompresi (diesel) GVW > 3.5 ton)','% HSU',NULL,550000.00,1,NULL,'M=35,N=35,O=35',NULL,NULL,NULL,NULL),(65,20,'NH3','Amoniak/Ammonia, (NH3)','mg/m3',NULL,0.00,1,NULL,'0,5',NULL,NULL,NULL,NULL),(66,21,'Cl2','Klorin/Chlorine (Cl2)','mg/m3',NULL,0.00,2,NULL,'10',NULL,NULL,NULL,NULL),(67,22,'HCL','Hidrogen Klorida/ Hydrogen Chloride, (HCl)','mg/m3',NULL,0.00,1,NULL,'5',NULL,NULL,NULL,NULL),(68,23,'HF','Hidrogen Fluorida/ Hydrogen Fluoride, (HF)','mg/m3',NULL,0.00,1,NULL,'10',NULL,NULL,NULL,NULL),(69,24,'NO2','Nitrogen Oksida/ Nitrogen Oxides, (NO2)','mg/m3',NULL,0.00,1,NULL,'1000',NULL,NULL,NULL,NULL),(70,25,'Opacity','Opasitas/Opacity','%',NULL,0.00,1,NULL,'35',NULL,NULL,NULL,NULL),(71,26,'Particulate','Partikulat/Particulate','mg/m3',NULL,0.00,1,NULL,'350',NULL,NULL,NULL,NULL),(72,24,'SO2','Sulfur Dioksida/ Sulphur Dioxide, (SO2)','mg/m3',NULL,0.00,1,NULL,'800',NULL,NULL,NULL,NULL),(73,27,'H2S','Total Sulfur Tereduksi/Total Reduced Sulfur, (H2S)','mg/m3',NULL,0.00,2,NULL,'35',NULL,NULL,NULL,NULL),(74,28,'HG','Air Raksa/Mercury, (Hg)','mg/m3',NULL,0.00,2,NULL,'5',NULL,NULL,NULL,NULL),(75,28,'AS','Arsen/Arsenic, (As)','mg/m3',NULL,0.00,2,NULL,'8',NULL,NULL,NULL,NULL),(76,28,'Sb','Antimon/Antimony, (Sb)','mg/m3',NULL,0.00,2,NULL,'8',NULL,NULL,NULL,NULL),(77,28,'Cd','Kadmium/Cadmium, (Cd)','mg/m3',NULL,0.00,2,NULL,'8',NULL,NULL,NULL,NULL),(78,28,'Zn','Seng/Zinc, (Zn)','mg/m3',NULL,0.00,2,NULL,'50',NULL,NULL,NULL,NULL),(79,28,'Pb','Timah Hitam/Lead, (Pb)','mg/m3',NULL,0.00,2,NULL,'12',NULL,NULL,NULL,NULL),(80,26,'Particulate','Partikulat/Particulate','mg/m3',NULL,0.00,1,NULL,'300',NULL,NULL,NULL,NULL),(81,24,'SO2','Sulfur Dioksida/ Sulphur Dioxide, (SO2)','mg/m3',NULL,0.00,1,NULL,'600',NULL,NULL,NULL,NULL),(82,24,'NO2','Nitrogen Oksida/ Nitrogen Oxides, (NO2)','mg/m3',NULL,0.00,1,NULL,'800',NULL,NULL,NULL,NULL),(83,21,'Cl2','Klorin/Chlorine (Cl2)','mg/m3',NULL,0.00,2,NULL,'5',NULL,NULL,NULL,NULL),(84,20,'NH3','Amoniak/Ammonia, (NH3)','mg/m3',NULL,0.00,1,NULL,'1',NULL,NULL,NULL,NULL),(85,23,'HF','Hidrogen Fluorida/ Hydrogen Fluoride, (HF)','mg/m3',NULL,0.00,1,NULL,'8',NULL,NULL,NULL,NULL),(86,25,'Opacity','Opasitas/Opacity','%',NULL,0.00,1,NULL,'30',NULL,NULL,NULL,NULL),(87,26,'Particulate','Partikulat/Particulate','mg/m3',NULL,0.00,1,NULL,'230',NULL,NULL,NULL,NULL),(88,24,'SO2','Sulfur Dioksida/ Sulphur Dioxide, (SO2)','mg/m3',NULL,0.00,1,NULL,'750',NULL,NULL,NULL,NULL),(89,24,'NO2','Nitrogen Oksida/ Nitrogen Oxides, (NO2)','mg/m3',NULL,0.00,1,NULL,'825',NULL,NULL,NULL,NULL),(90,25,'Opacity','Opasitas/Opacity','%',NULL,0.00,1,NULL,'20',NULL,NULL,NULL,NULL),(91,24,'SO2','Sulfur Dioksida/ Sulphur Dioxide, (SO2)','mg/m3',NULL,0.00,1,NULL,'150',NULL,NULL,NULL,NULL),(92,24,'NO2','Nitrogen Oksida/ Nitrogen Oxides, (NO2)','mg/m3',NULL,0.00,1,NULL,'650',NULL,NULL,NULL,NULL),(93,NULL,'Stack Code','Kode Cerobong/ Stack Code','-',NULL,0.00,1,NULL,'-',NULL,NULL,NULL,NULL),(94,29,'Stack Temperature','Suhu Cerobong/ Stack Temperature','°C',NULL,0.00,1,NULL,'-',NULL,NULL,NULL,NULL),(95,24,'NO Value','Nilai NO/NO Value','mg/Nm3',NULL,0.00,1,NULL,'-',NULL,NULL,NULL,NULL),(96,24,'O2 Value','Nilai O2/ O2 Value','%',NULL,0.00,1,NULL,'-',NULL,NULL,NULL,NULL),(97,24,'CO2','Karbon Monoksida/ Carbon Monoxide, (CO)','mg/Nm3',NULL,0.00,1,NULL,'-',NULL,NULL,NULL,NULL),(98,24,'CO2 Value','Nilai CO2/ CO2 Value','%',NULL,0.00,1,NULL,'-',NULL,NULL,NULL,NULL),(99,30,'Traverse Ponts','Jumlah Titik Lintas/Traverse Points','Titik',NULL,0.00,1,NULL,'-',NULL,NULL,NULL,NULL),(100,31,'Qact','Laju Alir Gas Aktual, (Qact)','m3/detik',NULL,0.00,1,NULL,'-',NULL,NULL,NULL,NULL),(101,32,'Md','Bobot Molekul Gas Kering/Dry Molecular Weight, (Md)','g/gmol',NULL,0.00,1,NULL,'-',NULL,NULL,NULL,NULL),(102,33,'Bws','Kadar Uap Air/Moisture Content, (Bws)','-',NULL,0.00,1,NULL,'-',NULL,NULL,NULL,NULL),(103,34,'%I','Persen Isokinetik/Percent Isokineticity, (%I)','%',NULL,0.00,1,NULL,'-',NULL,NULL,NULL,NULL),(104,97,'Temperature','Suhu/Temperature','ºC',NULL,12500.00,1,NULL,'Kelas 1 = Dev3, Kelas 2 = Dev3, Kelas 3 = Dev3',NULL,NULL,NULL,NULL),(105,36,'Temperature','Suhu/Temperature','ºC',NULL,12500.00,2,NULL,'Kelas 1 = Dev3, Kelas 2 = Dev3, Kelas 3 = Dev3',NULL,NULL,NULL,NULL),(106,37,'TDS','Total Padatan Terlarut/Total Dissolved Solids, (TDS)','mg/L',NULL,35000.00,1,NULL,'Kelas 1 = 1000, Kelas 2 = 1000, Kelas 3 = 1000, Kelas 4 = 2000',NULL,NULL,NULL,NULL),(107,38,'TSS','Total Padatan Tersuspensi/Total Suspended Solids, (TSS)','mg/L',NULL,35000.00,1,NULL,'Kelas 1 = 40, Kelas 2 = 50, Kelas 3 = 100, Kelas 4 = 400',NULL,NULL,NULL,NULL),(108,39,'Color','Warna/Color','Pt-Co Unit',NULL,35000.00,1,NULL,'Kelas 1 = 15, Kelas 2 = 50, Kelas 3 = 100, Kelas 4 =',NULL,NULL,NULL,NULL),(109,40,'pH','Derajat Keasaman/ Potential of Hydrogen, (pH)','-',NULL,12500.00,1,NULL,'Kelas 1 = 6-9, Kelas 2 = 6-9, Kelas 3 = 6-9, Kelas 4 = 6-9',NULL,NULL,NULL,NULL),(110,41,'BOD','Kebutuhan Oksigen Biokimiawi/Biochemical Oxygen Demand, (BOD)','mg/L',NULL,75000.00,1,NULL,NULL,NULL,NULL,NULL,NULL),(111,42,'COD','Kebutuhan Oksigen Kimiawi/ Chemical Oxygen Demand, (COD)','mg/L',NULL,75000.00,1,NULL,NULL,NULL,NULL,NULL,NULL),(112,43,'DO','Oksigen Terlarut/ Dissolved Oxygen, (DO)','mg/L',NULL,40000.00,1,NULL,NULL,NULL,NULL,NULL,NULL),(113,44,'DO','Oksigen Terlarut/ Dissolved Oxygen, (DO)','mg/L',NULL,40000.00,1,NULL,NULL,NULL,NULL,NULL,NULL),(114,45,'SO4-2','Sulfat/Sulfate, (SO4-2)','mg/L',NULL,40000.00,1,NULL,NULL,NULL,NULL,NULL,NULL),(115,46,'Cl-','Klorida/ Chloride, (Cl-)','mg/L',NULL,40000.00,1,NULL,NULL,NULL,NULL,NULL,NULL),(116,47,'NO3-N','Nitrat sebagai N/ Nitrate as N, (NO3-N)','mg/L',NULL,40000.00,1,NULL,NULL,NULL,NULL,NULL,NULL),(117,48,'NO2-N','Nitrit sebagai N/ Nitrate as N, (NO2-N)','mg/L',NULL,40000.00,1,NULL,NULL,NULL,NULL,NULL,NULL),(118,49,'NH3-N','Amoniak sebagai N/Ammonia as N, (NH3-N)','mg/L',NULL,75000.00,1,NULL,NULL,NULL,NULL,NULL,NULL),(119,50,'Total Nitrogen','Total Nitrogen/ Total Nitrogen','mg/L',NULL,115000.00,1,NULL,NULL,NULL,NULL,NULL,NULL),(120,51,'Total Phospate as P','Total Fosfat sebagai P/ Total Phosphate as P','mg/L',NULL,45000.00,1,NULL,NULL,NULL,NULL,NULL,NULL),(121,52,'F-','Fluorida/Fluoride, (F-)','mg/L',NULL,40000.00,1,NULL,NULL,NULL,NULL,NULL,NULL),(122,53,'Sulfur as H2S','Belerang sebagai H2S/ Sulfur as H2S','mg/L',NULL,40000.00,1,NULL,NULL,NULL,NULL,NULL,NULL),(123,54,'CN-','Sianida/ Cyanide, (CN-)','mg/L',NULL,55000.00,1,NULL,NULL,NULL,NULL,NULL,NULL),(124,55,'CL2','Klorin Bebas/Free Chlorine, (Cl2)','mg/L',NULL,40000.00,1,NULL,NULL,NULL,NULL,NULL,NULL),(125,56,'Ba','Barium Terlarut/ Dissolved Barium, (Ba)','mg/L',NULL,77500.00,1,NULL,NULL,NULL,NULL,NULL,NULL),(126,57,'B','Boron Terlarut/Dissolved Boron, (B)','mg/L',NULL,77500.00,1,NULL,NULL,NULL,NULL,NULL,NULL),(127,58,'Hg','Raksa Terlarut/ Dissolved Mercury, (Hg)','mg/L',NULL,175000.00,1,NULL,NULL,NULL,NULL,NULL,NULL),(128,59,'As','Arsen Terlarut, Dissolved Arsenic, (As)','mg/L',NULL,115000.00,1,NULL,NULL,NULL,NULL,NULL,NULL),(129,60,'Se','Selenium Terlarut/ Dissolved Selenium, (Se)','mg/L',NULL,115000.00,1,NULL,NULL,NULL,NULL,NULL,NULL),(130,61,'Fe','Besi Terlarut/ Dissolved Iron, (Fe)','mg/L',NULL,77500.00,1,NULL,NULL,NULL,NULL,NULL,NULL),(131,62,'Cd','Kadmium Terlarut/ Dissolved Cadmium (Cd)','mg/L',NULL,115000.00,1,NULL,NULL,NULL,NULL,NULL,NULL),(132,63,'Co','Kobalt Terlarut/ Dissolved Cobalt, (Co)','mg/L',NULL,115000.00,1,NULL,NULL,NULL,NULL,NULL,NULL),(133,61,'Mn','Mangan Terlarut/ Dissolved Manganese, (Mn)','mg/L',NULL,77500.00,1,NULL,NULL,NULL,NULL,NULL,NULL),(134,64,'Ni','Nikel Terlarut/ Dissolved Nickel, (Ni)','mg/L',NULL,77500.00,1,NULL,NULL,NULL,NULL,NULL,NULL),(135,61,'Zn','Seng Terlarut/ Dissolved Zinc, (Zn)','mg/L',NULL,77500.00,1,NULL,NULL,NULL,NULL,NULL,NULL),(136,65,'Cu','Tembaga Terlarut/ Dissolved Copper, (Cu)','mg/L',NULL,77500.00,1,NULL,NULL,NULL,NULL,NULL,NULL),(137,66,'Pb','Timbal Terlarut/ Dissolved Lead (Pb)','mg/L',NULL,115000.00,1,NULL,NULL,NULL,NULL,NULL,NULL),(138,67,'Cr+6','Krom Heksavalen Terlarut/ Dissolved Hexavalent Chromium (Cr+6)','mg/L',NULL,115000.00,1,NULL,NULL,NULL,NULL,NULL,NULL),(139,68,'Oil and Grease','Minyak dan Lemak/ Oil and Grease','mg/L',NULL,125000.00,2,NULL,NULL,NULL,NULL,NULL,NULL),(140,69,'Anionic Surfactants as MBAS','Surfaktan Anionik sebagai MBAS /Anionic Surfactants as MBAS','mg/L',NULL,80000.00,1,NULL,NULL,NULL,NULL,NULL,NULL),(141,70,'Phenol','Fenol/ Phenol','mg/L',NULL,85000.00,1,NULL,NULL,NULL,NULL,NULL,NULL),(142,NULL,'Dieldrin','Aldrin/Dieldrin','ug/L',NULL,1850000.00,3,NULL,NULL,NULL,NULL,NULL,NULL),(143,NULL,'BHC','BHC','ug/L',NULL,1850000.00,3,NULL,NULL,NULL,NULL,NULL,NULL),(144,NULL,'Chlordane','Chlordane','ug/L',NULL,1850000.00,3,NULL,NULL,NULL,NULL,NULL,NULL),(145,NULL,'DDT','DDT','ug/L',NULL,1850000.00,3,NULL,NULL,NULL,NULL,NULL,NULL),(146,NULL,'Endrin','Endrin','ug/L',NULL,1850000.00,3,NULL,NULL,NULL,NULL,NULL,NULL),(147,NULL,'Heptachlor','Heptachlor','ug/L',NULL,1850000.00,3,NULL,NULL,NULL,NULL,NULL,NULL),(148,NULL,'Lindane','Lindane','ug/L',NULL,1850000.00,3,NULL,NULL,NULL,NULL,NULL,NULL),(149,NULL,'Methoxychlor','Methoxychlor','ug/L',NULL,1850000.00,3,NULL,NULL,NULL,NULL,NULL,NULL),(150,NULL,'Toxapan','Toxapan','ug/L',NULL,1850000.00,3,NULL,NULL,NULL,NULL,NULL,NULL),(151,71,'Fecal Coliform','Fecal Coliform','MPN/100 mL',NULL,145000.00,1,NULL,NULL,NULL,NULL,NULL,NULL),(152,72,'Total Coliform','Total Coliform','MPN/100 mL',NULL,145000.00,1,NULL,NULL,NULL,NULL,NULL,NULL),(153,73,'Rubbish','Sampah/Rubbish','-',NULL,15000.00,1,NULL,NULL,NULL,NULL,NULL,NULL),(154,NULL,'Radioaktivitas Gross A','Radioaktivitas Gross A','Bq/L',NULL,2420000.00,3,NULL,NULL,NULL,NULL,NULL,NULL),(155,NULL,'Radioaktivitas Gross B','Radioaktivitas Gross B','Bq/L',NULL,2420000.00,3,NULL,NULL,NULL,NULL,NULL,NULL),(156,74,'Conductivity','Daya Hantar Listrik/ Conductivity','uS/cm',NULL,12500.00,1,NULL,NULL,NULL,NULL,NULL,NULL),(157,75,'TS','Total Padatan/Total Solids,(TS)','mg/L',NULL,35000.00,1,NULL,NULL,NULL,NULL,NULL,NULL),(158,76,'Turbidity','Kekeruhan/Turbidity','NTU',NULL,20000.00,1,NULL,NULL,NULL,NULL,NULL,NULL),(159,37,'Salinity','Salinitas/Salinity','%',NULL,12500.00,1,NULL,NULL,NULL,NULL,NULL,NULL),(160,77,'Orthophosphate','Orthopospat/ Orthophosphate','mg/L',NULL,45000.00,1,NULL,NULL,NULL,NULL,NULL,NULL),(161,78,'Cr','Krom terlarut / Dissolved Chromium, (Cr)','mg/L',NULL,115000.00,1,NULL,NULL,NULL,NULL,NULL,NULL),(162,79,'Escherichia coli','Escherichia coli','MPN/100 mL',NULL,145000.00,1,NULL,NULL,NULL,NULL,NULL,NULL),(163,80,'Alkalinity','Alkalinitas/Alkalinity','mg/L',NULL,40000.00,2,NULL,NULL,NULL,NULL,NULL,NULL),(164,97,'Temperature','Suhu/Temperature','ºC',NULL,12500.00,1,NULL,NULL,NULL,NULL,NULL,NULL),(165,36,'Temperature','Suhu/Temperature','ºC',NULL,12500.00,2,NULL,NULL,NULL,NULL,NULL,NULL),(166,37,'TDS','Total Padatan Terlarut/Total Dissolved Solids, (TDS)','mg/L',NULL,35000.00,1,NULL,NULL,NULL,NULL,NULL,NULL),(167,38,'TSS','Total Padatan Tersuspensi/Total Suspended Solids, (TSS)','mg/L',NULL,35000.00,1,NULL,NULL,NULL,NULL,NULL,NULL),(168,81,'Transparency','Transparasi/ Transparency','m',NULL,15000.00,1,NULL,NULL,NULL,NULL,NULL,NULL),(169,39,'Color','Warna/Color','Pt-Co Unit',NULL,35000.00,1,NULL,NULL,NULL,NULL,NULL,NULL),(170,40,'pH','Derajat Keasaman/ Potential of Hydrogen, (pH)',NULL,NULL,12500.00,1,NULL,NULL,NULL,NULL,NULL,NULL),(171,41,'BOD','Kebutuhan Oksigen Biokimiawi/ Biochemical Oxygen Demand, (BOD)','mg/L',NULL,75000.00,1,NULL,NULL,NULL,NULL,NULL,NULL),(172,NULL,'Klorofil-a','Klorofil-a','mg/m3',NULL,0.00,1,NULL,NULL,NULL,NULL,NULL,NULL),(173,73,'Rubbish','Sampah/Rubbish',NULL,NULL,15000.00,1,NULL,NULL,NULL,NULL,NULL,NULL),(174,82,'Phytoplankton','Phytoplankton',NULL,NULL,500000.00,1,NULL,NULL,NULL,NULL,NULL,NULL),(175,82,'BACILLARIOPHYCEAE:','BACILLARIOPHYCEAE:',NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(176,82,'Achnanthes sp.','Achnanthes sp.','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(177,82,'Actinocyclus sp.','Actinocyclus sp.','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(178,82,'Fragilaria sp.','Fragilaria sp.','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(179,82,'Navicula sp.','Navicula sp.','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(180,82,'Nitzschia sp.','Nitzschia sp.','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(181,82,'Pinnularia sp.','Pinnularia sp.','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(182,82,'Pleurosigma sp.','Pleurosigma sp.','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(183,82,'Surirella sp.','Surirella sp.','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(184,82,'Tabellaria sp.','Tabellaria sp.','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(185,82,'Frustulia sp.','Frustulia sp.','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(186,82,'Neidium sp.','Neidium sp.','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(187,82,'Microspora sp.','Microspora sp.','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(188,82,'CHLOROPHYCEAE:','CHLOROPHYCEAE:',NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(189,82,'Chodatella sp.','Chodatella sp.','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(190,82,'Pediastrum sp.','Pediastrum sp.','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(191,82,'Euastrum sp.','Euastrum sp.','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(192,82,'Eudorina sp.','Eudorina sp.','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(193,82,'Golenkinia sp.','Golenkinia sp.','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(194,82,'Scenedemus sp.','Scenedemus sp.','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(195,82,'Sphaerocytis sp.','Sphaerocytis sp.','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(196,82,'Ulothrix sp.','Ulothrix sp.','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(197,82,'Tetraedron sp.','Tetraedron sp.','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(198,82,'CYANOPHYCEAE:','CYANOPHYCEAE:',NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(199,82,'Anabaena sp.','Anabaena sp.','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(200,82,'Merismopedia sp.','Merismopedia sp.','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(201,82,'Oscillatoria sp.','Oscillatoria sp.','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(202,82,'Spirulina sp.','Spirulina sp.','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(203,82,'DINOPHYCEAE :','DINOPHYCEAE :',NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(204,82,'Ceratium sp.','Ceratium sp.','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(205,82,'Dinobryon sp.','Dinobryon sp.','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(206,82,'EUGLENOPHYCEAE:','EUGLENOPHYCEAE:',NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(207,82,'Phacus sp.','Phacus sp.','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(208,82,'Euglena sp.','Euglena sp.','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(209,82,'Trachelomonas sp.','Trachelomonas sp.','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(210,82,'ZYGNEMATOPHYCEAE','ZYGNEMATOPHYCEAE',NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(211,82,'Cosmarium sp.','Cosmarium sp.','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(212,82,'Closterium sp.','Closterium sp.','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(213,82,'Staurastrum sp.','Staurastrum sp.','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(214,82,'Micrasterias sp.','Micrasterias sp.','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(215,82,'Desmidium sp.','Desmidium sp.','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(216,82,'Spirogyra sp.','Spirogyra sp.','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(217,82,'Zygnemopsis sp.','Zygnemopsis sp.','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(218,82,'Mougeotia sp.','Mougeotia sp.','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(219,82,'Gonatozygon sp.','Gonatozygon sp.','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(220,82,'Ind./L','Kelimpahan (Ind./L)',NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(221,82,'S','Taksa (S)',NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(222,82,'H\'','Keanekaragaman (H\')',NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(223,82,'E','Pemerataan (E)',NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(224,82,'D','Dominasi (D)',NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(225,82,'Zooplankton','Zooplankton',NULL,NULL,500000.00,1,NULL,NULL,NULL,NULL,NULL,NULL),(226,82,'CRUSTACEAE:','CRUSTACEAE:',NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(227,82,'Harpacticus sp.','Harpacticus sp.','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(228,82,'Copepedia sp.','Copepedia sp.','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(229,82,'Nauplius sp.','Nauplius sp.','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(230,82,'Alona sp.','Alona sp.','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(231,82,'Ceriodaphina sp.','Ceriodaphina sp.','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(232,82,'NEMATODA:','NEMATODA:',NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(233,82,'Nematoda worm (sp)','Nematoda worm (sp)','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(234,82,'PROTOZOA:','PROTOZOA:',NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(235,82,'Arcella sp.','Arcella sp.','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(236,82,'Difflugia sp.','Difflugia sp.','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(237,82,'Centropyxis sp.','Centropyxis sp.',NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(238,82,'Euglypha sp.','Euglypha sp.','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(239,82,'Paramecium sp.','Paramecium sp.','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(240,82,'Vorticella sp.','Vorticella sp.','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(241,82,'Wailesella sp.','Wailesella sp.','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(242,82,'ROTIFERA:','ROTIFERA:',NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(243,82,'Brachionus sp.','Brachionus sp.','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(244,82,'Monostylla sp.','Monostylla sp.','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(245,82,'Philodina sp.','Philodina sp.','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(246,82,'Squatinella sp.','Squatinella sp.','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(247,82,'Macrozoobenthos','Macrozoobenthos',NULL,NULL,500000.00,1,NULL,NULL,NULL,NULL,NULL,NULL),(248,82,'EPHEMEROPTERA :','EPHEMEROPTERA :',NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(249,82,'Ameletus sp','Ameletus sp','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(250,82,'Lumbriculus sp','Lumbriculus sp','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(251,82,'Chironomus sp','Chironomus sp','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(252,82,'Medetera sp','Medetera sp','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(253,82,'Psychodidae sp','Psychodidae sp','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(254,82,'GASTROPODA','GASTROPODA',NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(255,82,'Melanoides sp','Melanoides sp','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(256,82,'ORTHOPTERA','ORTHOPTERA',NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(257,82,'Periplaneta sp','Periplaneta sp','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(258,82,'ODONATA','ODONATA',NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(259,82,'Pachydiplax sp','Pachydiplax sp','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(260,82,'CRUSTACEAE','CRUSTACEAE',NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(261,82,'Mysis sp','Mysis sp','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(262,82,'Eriocheir sp.','Eriocheir sp.','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(263,82,'ARANEAE','ARANEAE',NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(264,82,'Araneus sp','Araneus sp','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(265,82,'HEMIPTERA','HEMIPTERA',NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(266,82,'Aquarius sp','Aquarius sp','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(267,82,'Gerris sp.','Gerris sp.','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(268,82,'TRICHOPTERA','TRICHOPTERA',NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(269,82,'Rhyacophila sp.','Rhyacophila sp.','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(270,82,'HYMENOPTERA','HYMENOPTERA',NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(271,82,'Monomorium sp.','Monomorium sp.','Ind/L',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL),(272,40,'Pb','Pb','mg/kg',NULL,660000.00,3,NULL,NULL,NULL,NULL,NULL,NULL),(273,41,'Cu','Cu','mg/kg',NULL,660000.00,3,NULL,NULL,NULL,NULL,NULL,NULL),(274,42,'Zn','Zn','mg/kg',NULL,660000.00,3,NULL,NULL,NULL,NULL,NULL,NULL),(275,38,'Fe','Fe','mg/kg',NULL,660000.00,3,NULL,NULL,NULL,NULL,NULL,NULL),(276,83,'Mn','Mn','mg/kg',NULL,660000.00,3,NULL,NULL,NULL,NULL,NULL,NULL),(277,68,'Total Bahan Organik','Total Bahan Organik','mg/kg',NULL,750000.00,3,NULL,NULL,NULL,NULL,NULL,NULL),(278,84,'Total Karbon','Total Karbon','mg/kg',NULL,750000.00,3,NULL,NULL,NULL,NULL,NULL,NULL),(279,NULL,'pH','Derajat Keasaman/ Potential of Hydrogen, (pH)','-',NULL,12500.00,1,NULL,'6 – 9',NULL,NULL,NULL,NULL),(280,40,'BOD','Kebutuhan Oksigen Biokimiawi/ Biochemical Oxygen Demand, (BOD)','mg/L',NULL,75000.00,1,NULL,'30',NULL,NULL,NULL,NULL),(281,41,'COD','Kebutuhan Oksigen Kimiawi/ Chemical Oxygen Demand, (COD)','mg/L',NULL,75000.00,1,NULL,'100',NULL,NULL,NULL,NULL),(282,42,'TSS','Total Padatan Tersuspensi/Total Suspended Solids, (TSS)','mg/L',NULL,35000.00,1,NULL,'30',NULL,NULL,NULL,NULL),(283,38,'NH3','Amoniak/Ammonia, (NH3)','mg/L',NULL,75000.00,1,NULL,'10',NULL,NULL,NULL,NULL),(284,49,'Oil and Grease','Minyak dan Lemak/ Oil and Grease','mg/L',NULL,125000.00,1,NULL,'5',NULL,NULL,NULL,NULL),(285,71,'Total Coliform','Total Coliform','Jumlah/100 mL',NULL,145000.00,1,NULL,'3.000',NULL,NULL,NULL,NULL),(286,NULL,'Debit','Debit','L/orang/hari',NULL,NULL,2,NULL,'100',NULL,NULL,NULL,NULL),(287,40,'pH','Derajat Keasaman/ Potential of Hydrogen, (pH)','-',NULL,12500.00,1,NULL,'6 – 9',NULL,NULL,NULL,NULL),(288,41,'BOD','Kebutuhan Oksigen Biokimiawi/ Biochemical Oxygen Demand, (BOD)','mg/L',NULL,75000.00,1,NULL,'150',NULL,NULL,NULL,NULL),(289,42,'COD','Kebutuhan Oksigen Kimiawi/ Chemical Oxygen Demand, (COD)','mg/L',NULL,75000.00,1,NULL,'300',NULL,NULL,NULL,NULL),(290,38,'TSS','Total Padatan Tersuspensi/Total Suspended Solids, (TSS)','mg/L',NULL,35000.00,1,NULL,'100',NULL,NULL,NULL,NULL),(291,49,'NH3-N','Amoniak sebagai N/Ammonia as N, (NH3-N)','mg/L',NULL,75000.00,1,NULL,'50',NULL,NULL,NULL,NULL),(292,71,'Fecal Coliform','Fecal coliform','MPN/100 mL',NULL,145000.00,1,NULL,'1000',NULL,NULL,NULL,NULL),(293,40,'pH','Derajat Keasaman/ Potential of Hydrogen, (pH)','-',NULL,12500.00,1,NULL,'x > 50 = 6-9, 3 < x <= 50 = 6-9, 3 < x <= 50 = 6-9',NULL,NULL,NULL,NULL),(294,41,'BOD','Kebutuhan Oksigen Biokimiawi/ Biochemical Oxygen Demand, (BOD)','mg/L',NULL,75000.00,1,NULL,'x > 50 = 30, 3 < x <= 50 = 50, 3 < x <= 50 = 75',NULL,NULL,NULL,NULL),(295,42,'COD','Kebutuhan Oksigen Kimiawi/ Chemical Oxygen Demand, (COD)','mg/L',NULL,75000.00,1,NULL,'x > 50 = 100, 3 < x <= 50 = 100, 3 < x <= 50 = -',NULL,NULL,NULL,NULL),(296,38,'TSS','Total Padatan Tersuspensi/Total Suspended Solids, (TSS)','mg/L',NULL,35000.00,1,NULL,'x > 50 = 30, 3 < x <= 50 = 50, 3 < x <= 50 = -',NULL,NULL,NULL,NULL),(297,49,'NH3-N','Amoniak sebagai N/Ammonia as N, (NH3-N)','mg/L',NULL,75000.00,1,NULL,'x > 50 = 10, 3 < x <= 50 = 20, 3 < x <= 50 = -',NULL,NULL,NULL,NULL),(298,85,'Anionic Surfactants as MBAS','Surfaktan Anionik sebagai MBAS /Anionic Surfactantsas as MBAS','mg/L',NULL,80000.00,1,NULL,'x > 50 = 5, 3 < x <= 50 = 10, 3 < x <= 50 = -',NULL,NULL,NULL,NULL),(299,68,'Oil and Grease','Minyak dan Lemak/ Oil and Grease','mg/L',NULL,125000.00,1,NULL,'x > 50 = 5, 3 < x <= 50 = 10, 3 < x <= 50 = 10',NULL,NULL,NULL,NULL),(300,55,'Cl2','Sisa Klorin/Residual Chlorine, (Cl2)','mg/L',NULL,40000.00,1,NULL,'x > 50 = 1, 3 < x <= 50 = 1, 3 < x <= 50 = 1',NULL,NULL,NULL,NULL),(301,NULL,'Salmonela','Salmonela','-',NULL,NULL,3,NULL,'x > 50 = Negatif, 3 < x <= 50 = Negatif, 3 < x <= 50 = Negatif',NULL,NULL,NULL,NULL),(302,NULL,'Shigela','Shigela','-',NULL,NULL,3,NULL,'x > 50 = Negatif, 3 < x <= 50 = Negatif, 3 < x <= 50 = Negatif',NULL,NULL,NULL,NULL),(303,NULL,'Vibrio cholera','Vibrio cholera','-',NULL,NULL,3,NULL,'x > 50 = Negatif, 3 < x <= 50 = Negatif, 3 < x <= 50 = Negatif',NULL,NULL,NULL,NULL),(304,NULL,'Streptococus','Streptococus','-',NULL,NULL,3,NULL,'x > 50 = Negatif, 3 < x <= 50 = Negatif, 3 < x <= 50 = Negatif',NULL,NULL,NULL,NULL),(305,71,'Fecal Coliform','Fecal coliform','MPN/100 mL',NULL,145000.00,1,NULL,'x > 50 = 1000, 3 < x <= 50 = 1000, 3 < x <= 50 = 1000',NULL,NULL,NULL,NULL),(306,41,'BOD','Kebutuhan Oksigen Biokimiawi/ Biochemical Oxygen Demand, (BOD)','mg/L',NULL,75000.00,1,NULL,'12',NULL,NULL,NULL,NULL),(307,42,'COD','Kebutuhan Oksigen Kimiawi/ Chemical Oxygen Demand, (COD)','mg/L',NULL,75000.00,1,NULL,'80',NULL,NULL,NULL,NULL),(308,38,'TSS','Total Padatan Tersuspensi/Total Suspended Solids, (TSS)','mg/L',NULL,35000.00,1,NULL,'30',NULL,NULL,NULL,NULL),(309,71,'Fecal Coliform','Fecal coliform','mg/L',NULL,145000.00,1,NULL,'200',NULL,NULL,NULL,NULL),(310,55,'Cl2','Sisa Klorin/Residual Chlorine, (Cl2)','MPN/100 mL',NULL,40000.00,1,NULL,'1',NULL,NULL,NULL,NULL),(311,NULL,'Salmonela','Salmonela','-',NULL,NULL,3,NULL,'Negatif',NULL,NULL,NULL,NULL),(312,NULL,'Shigela','Shigela','-',NULL,NULL,3,NULL,'Negatif',NULL,NULL,NULL,NULL),(313,NULL,'Vibrio cholera','Vibrio cholera','-',NULL,NULL,3,NULL,'Negatif',NULL,NULL,NULL,NULL),(314,NULL,'Streptococus','Streptococus','-',NULL,NULL,3,NULL,'Negatif',NULL,NULL,NULL,NULL),(315,40,'pH','Derajat Keasaman/ Potential of Hydrogen, (pH)','-',NULL,12500.00,1,NULL,'45817',NULL,NULL,NULL,NULL),(316,40,'pH','Derajat Keasaman/ Potential of Hydrogen, (pH)','-',NULL,12500.00,1,NULL,'6-9',NULL,NULL,NULL,NULL),(317,41,'BOD','Kebutuhan Oksigen Biokimiawi/ Biochemical Oxygen Demand, (BOD)','mg/L',NULL,75000.00,1,NULL,'100',NULL,NULL,NULL,NULL),(318,42,'COD','Kebutuhan Oksigen Kimiawi/ Chemical Oxygen Demand, (COD)','mg/L',NULL,75000.00,1,NULL,'350',NULL,NULL,NULL,NULL),(319,38,'TSS','Total Padatan Tersuspensi/Total Suspended Solids, (TSS)','mg/L',NULL,35000.00,1,NULL,'150',NULL,NULL,NULL,NULL),(320,68,'Oil and Grease','Minyak dan Lemak/ Oil and Grease','mg/L',NULL,125000.00,1,NULL,'25',NULL,NULL,NULL,NULL),(321,49,'NH3-N','Amoniak sebagai N/Ammonia as N, (NH3-N)','mg/L',NULL,75000.00,1,NULL,'10',NULL,NULL,NULL,NULL),(322,50,'Total Nitrogen','Total Nitrogen/ Total Nitrogen','mg/L',NULL,115000.00,1,NULL,'50',NULL,NULL,NULL,NULL),(323,40,'pH','Derajat Keasaman/ Potential of Hydrogen, (pH)','-',NULL,12500.00,1,NULL,'6 - 9',NULL,NULL,NULL,NULL),(324,NULL,'Debit','Debit limbah paling tinggi/Debit','m3/ton CPO',NULL,NULL,NULL,NULL,'2,5',NULL,NULL,NULL,NULL),(325,42,'COD','Kebutuhan Oksigen Kimiawi/ Chemical Oxygen Demand, (COD)','mg/L',NULL,75000.00,1,NULL,'250',NULL,NULL,NULL,NULL),(326,49,'NH3-N','Amonia Total/Total Ammonia, (NH3-N)','mg/L',NULL,75000.00,1,NULL,'15',NULL,NULL,NULL,NULL),(327,50,'Total Nitrogen','Total Nitrogen/ Total Nitrogen','mg/L',NULL,115000.00,1,NULL,'25',NULL,NULL,NULL,NULL),(328,NULL,'Debit','Debit limbah paling tinggi/Debit','m3/ton produk',NULL,NULL,NULL,NULL,'40',NULL,NULL,NULL,NULL),(329,41,'BOD','Kebutuhan Oksigen Biokimiawi/ Biochemical Oxygen Demand, (BOD)','mg/L',NULL,75000.00,1,NULL,'75',NULL,NULL,NULL,NULL),(330,42,'COD','Kebutuhan Oksigen Kimiawi/ Chemical Oxygen Demand, (COD)','mg/L',NULL,75000.00,1,NULL,'125',NULL,NULL,NULL,NULL),(331,38,'TSS','Total Padatan Tersuspensi/Total Suspended Solids, (TSS)','mg/L',NULL,35000.00,1,NULL,'50',NULL,NULL,NULL,NULL),(332,86,'Phenol','Fenol/ Phenol','mg/L',NULL,85000.00,1,NULL,'0,25',NULL,NULL,NULL,NULL),(333,49,'NH3-N','Amonia Total/Total Ammonia, (NH3-N)','mg/L',NULL,75000.00,1,NULL,'4',NULL,NULL,NULL,NULL),(334,NULL,'Debit','Debit limbah paling tinggi/ Debit','m3/m3 kayu lapis',NULL,NULL,NULL,NULL,'0,30',NULL,NULL,NULL,NULL),(335,61,'Fe','Besi Terlarut/Dissolved Iron, (Fe)','mg/L',NULL,77500.00,1,NULL,'5',NULL,NULL,NULL,NULL),(336,61,'Mn','Mangan Terlarut/Dissolved Manganese, (Mn)','mg/L',NULL,77500.00,1,NULL,'2',NULL,NULL,NULL,NULL),(337,56,'BACILLARIOPHYCEAE:','Barium Total/ Total Barium, (Ba)','mg/L',NULL,77500.00,1,NULL,'2',NULL,NULL,NULL,NULL),(338,61,'Cu','Tembaga Total/ Total Copper, (Cu)','mg/L',NULL,77500.00,1,NULL,'2',NULL,NULL,NULL,NULL),(339,61,'Zn','Seng Total/ Total Zinc, (Zn)','mg/L',NULL,77500.00,1,NULL,'5',NULL,NULL,NULL,NULL),(340,87,'Cr+6','Krom Heksavalen Terlarut/ Dissolved Hexavalent Chromium, (Cr+6)','mg/L',NULL,115000.00,1,NULL,'0,1',NULL,NULL,NULL,NULL),(341,88,'Cr','Krom Total / Total Chromium, (Cr)','mg/L',NULL,115000.00,1,NULL,'0,5',NULL,NULL,NULL,NULL),(342,62,'Cd','Kadmium Total/ Total Cadmium. (Cd)','mg/L',NULL,115000.00,1,NULL,'0,05',NULL,NULL,NULL,NULL),(343,58,'Hg','Raksa Total/ Total Mercury, (Hg)','mg/L',NULL,175000.00,1,NULL,'0,002',NULL,NULL,NULL,NULL),(344,89,'Pb','Timbal Total/ Total Lead, (Pb)','mg/L',NULL,115000.00,1,NULL,'0,1',NULL,NULL,NULL,NULL),(345,90,'Sn','Timah Total/Total Tin, (Sn)','mg/L',NULL,115000.00,1,NULL,'2',NULL,NULL,NULL,NULL),(346,91,'As','Arsen Total/Total Arsenic, (As)','mg/L',NULL,115000.00,1,NULL,'0,1',NULL,NULL,NULL,NULL),(347,92,'Se','Selenium Total/Total Selenium, (Se)','mg/L',NULL,115000.00,1,NULL,'0,05',NULL,NULL,NULL,NULL),(348,88,'Ni','Nikel Total/ Total Nickel, (Ni)','mg/L',NULL,77500.00,1,NULL,'0,2',NULL,NULL,NULL,NULL),(349,93,'Co','Kobalt Total/ Total Cobalt, (Co)','mg/L',NULL,115000.00,1,NULL,'0,4',NULL,NULL,NULL,NULL),(350,94,'CN-','Sianida/ Cyanide, (CN-)','mg/L',NULL,55000.00,1,NULL,'0,05',NULL,NULL,NULL,NULL),(351,95,'H2S','Belerang Terlarut/ Dissolved Sulfur, (H2S)','mg/L',NULL,40000.00,1,NULL,'0,05',NULL,NULL,NULL,NULL),(352,96,'F-','Fluorida/Fluoride, (F-)','mg/L',NULL,40000.00,1,NULL,'2',NULL,NULL,NULL,NULL),(353,55,'Cl2','Klorin Bebas/Free Chlorine, (Cl2)','mg/L',NULL,40000.00,1,NULL,'1',NULL,NULL,NULL,NULL),(354,49,'NH3-N','Amoniak sebagai N/Ammonia as N, (NH3-N)','mg/L',NULL,75000.00,1,NULL,'1',NULL,NULL,NULL,NULL),(355,47,'NO3-N','Nitrat Sebagai N/ Nitrate as N (NO3-N)','mg/L',NULL,40000.00,1,NULL,'20',NULL,NULL,NULL,NULL),(356,48,'NO2-N','Nitrit sebagai N/ Nitrate as N, (NO2-N)','mg/L',NULL,40000.00,1,NULL,'1',NULL,NULL,NULL,NULL),(357,85,'Anionic Surfactants as MBAS','Surfaktan Anionik sebagai MBAS /Anionic Surfactantsas as MBAS','mg/L',NULL,80000.00,1,NULL,'5',NULL,NULL,NULL,NULL),(358,49,'Phenol','Fenol/ Phenol','mg/L',NULL,85000.00,1,NULL,'0,5',NULL,NULL,NULL,NULL),(359,NULL,'AOX','AOX','mg/L',NULL,NULL,3,NULL,'0,5',NULL,NULL,NULL,NULL),(360,NULL,'PCBs','PCBs','mg/L',NULL,NULL,3,NULL,'0,005',NULL,NULL,NULL,NULL),(361,NULL,'PCDFs','PCDFs','mg/L',NULL,NULL,3,NULL,'10',NULL,NULL,NULL,NULL),(362,NULL,'PCDDs','PCDDs','mg/L',NULL,NULL,3,NULL,'10',NULL,NULL,NULL,NULL),(363,97,'Temperature','Suhu/Temperature','-',NULL,12500.00,1,NULL,'38',NULL,NULL,NULL,NULL),(364,36,'Temperature','Suhu/Temperature','-',NULL,12500.00,2,NULL,'38',NULL,NULL,NULL,NULL),(365,37,'TDS','Total Padatan Terlarut/Total Dissolved Solids, (TDS)','mg/L',NULL,35000.00,1,NULL,'2000',NULL,NULL,NULL,NULL),(366,38,'TSS','Total Padatan Tersuspensi/Total Suspended Solids, (TSS)','mg/L',NULL,35000.00,1,NULL,'200',NULL,NULL,NULL,NULL),(367,40,'pH','Derajat Keasaman/ Potential of Hydrogen, (pH)','mg/L',NULL,12500.00,1,NULL,'6.0-9.0',NULL,NULL,NULL,NULL),(368,95,'H2S','Belerang Terlarut/ Dissolved Sulfur, (H2S)','mg/L',NULL,40000.00,1,NULL,'0,5',NULL,NULL,NULL,NULL),(369,49,'NH3-N','Amoniak sebagai N/Ammonia as N, (NH3-N)','mg/L',NULL,75000.00,1,NULL,'5',NULL,NULL,NULL,NULL),(370,50,'Total Nitrogen','Total Nitrogen/ Total Nitrogen','mg/L',NULL,115000.00,1,NULL,'30',NULL,NULL,NULL,NULL),(371,41,'BOD','Kebutuhan Oksigen Biokimiawi/ Biochemical Oxygen Demand, (BOD)','mg/L',NULL,75000.00,1,NULL,'50',NULL,NULL,NULL,NULL),(372,42,'COD','Kebutuhan Oksigen Kimiawi/ Chemical Oxygen Demand, (COD)','mg/L',NULL,75000.00,1,NULL,'100',NULL,NULL,NULL,NULL),(373,68,'Oil and Grease','Minyak dan Lemak/ Oil and Grease','mg/L',NULL,125000.00,1,NULL,'10',NULL,NULL,NULL,NULL),(374,84,'Total Coliform','Total coliform','MPN/100mL',NULL,145000.00,1,NULL,'10000',NULL,NULL,NULL,NULL),(375,97,'Temperature','Suhu/Temperature','-',NULL,12500.00,1,NULL,'40',NULL,NULL,NULL,NULL),(376,36,'Temperature','Suhu/Temperature','-',NULL,12500.00,2,NULL,'40',NULL,NULL,NULL,NULL),(377,37,'TDS','Total Padatan Terlarut/Total Dissolved Solids, (TDS)','mg/L',NULL,35000.00,1,NULL,'4000',NULL,NULL,NULL,NULL),(378,38,'TSS','Total Padatan Tersuspensi/Total Suspended Solids, (TSS)','mg/L',NULL,35000.00,1,NULL,'400',NULL,NULL,NULL,NULL),(379,61,'Fe','Besi Terlarut/Dissolved Iron, (Fe)','mg/L',NULL,77500.00,1,NULL,'10',NULL,NULL,NULL,NULL),(380,61,'Mn','Mangan Terlarut/Dissolved Manganese, (Mn)','mg/L',NULL,77500.00,1,NULL,'5',NULL,NULL,NULL,NULL),(381,56,'Ba','Barium Total/ Total Barium, (Ba)','mg/L',NULL,77500.00,1,NULL,'3',NULL,NULL,NULL,NULL),(382,61,'Cu','Tembaga Total/ Total Copper, (Cu)','mg/L',NULL,77500.00,1,NULL,'3',NULL,NULL,NULL,NULL),(383,61,'Zn','Seng Total/ Total Zinc, (Zn)','mg/L',NULL,77500.00,1,NULL,'10',NULL,NULL,NULL,NULL),(384,87,'Cr+6','Krom Heksavalen Terlarut/ Dissolved Hexavalent Chromium, (Cr+6)','mg/L',NULL,115000.00,1,NULL,'0,5',NULL,NULL,NULL,NULL),(385,88,'Cr','Krom Total / Total Chromium, (Cr)','mg/L',NULL,115000.00,1,NULL,'1',NULL,NULL,NULL,NULL),(386,62,'Cd','Kadmium Total/ Total Cadmium. (Cd)','mg/L',NULL,115000.00,1,NULL,'0,1',NULL,NULL,NULL,NULL),(387,58,'Hg','Raksa Total/ Total Mercury, (Hg)','mg/L',NULL,175000.00,1,NULL,'0,005',NULL,NULL,NULL,NULL),(388,89,'Pb','Timbal Total/ Total Lead, (Pb)','mg/L',NULL,115000.00,1,NULL,'1',NULL,NULL,NULL,NULL),(389,90,'Sn','Timah Total/Total Tin, (Sn)','mg/L',NULL,115000.00,1,NULL,'3',NULL,NULL,NULL,NULL),(390,91,'As','Arsen Total/Total Arsenic, (As)','mg/L',NULL,115000.00,1,NULL,'0,5',NULL,NULL,NULL,NULL),(391,92,'Se','Selenium Total/Total Selenium, (Se)','mg/L',NULL,115000.00,1,NULL,'0,5',NULL,NULL,NULL,NULL),(392,88,'Ni','Nikel Total/ Total Nickel, (Ni)','mg/L',NULL,77500.00,1,NULL,'0,5',NULL,NULL,NULL,NULL),(393,93,'Co','Kobalt Total/ Total Cobalt, (Co)','mg/L',NULL,115000.00,1,NULL,'0,6',NULL,NULL,NULL,NULL),(394,94,'CN-','Sianida/ Cyanide, (CN-)','mg/L',NULL,55000.00,1,NULL,'0,5',NULL,NULL,NULL,NULL),(395,95,'H2S','Belerang Terlarut/ Dissolved Sulfur, (H2S)','mg/L',NULL,40000.00,1,NULL,'1',NULL,NULL,NULL,NULL),(396,96,'F-','Fluorida/Fluoride, (F-)','mg/L',NULL,40000.00,1,NULL,'3',NULL,NULL,NULL,NULL),(397,55,'Cl2','Klorin Bebas/Free Chlorine, (Cl2)','mg/L',NULL,40000.00,1,NULL,'2',NULL,NULL,NULL,NULL),(398,47,'NO3-N','Nitrat Sebagai N/ Nitrate as N (NO3-N)','mg/L',NULL,40000.00,1,NULL,'30',NULL,NULL,NULL,NULL),(399,48,'NO2-N','Nitrit sebagai N/ Nitrate as N, (NO2-N)','mg/L',NULL,40000.00,1,NULL,'3',NULL,NULL,NULL,NULL),(400,50,'Total Nitrogen','Total Nitrogen/ Total Nitrogen','mg/L',NULL,115000.00,1,NULL,'60',NULL,NULL,NULL,NULL),(401,85,'Anionic Surfactants as MBAS','Surfaktan Anionik sebagai MBAS /Anionic Surfactantsas as MBAS','mg/L',NULL,80000.00,1,NULL,'10',NULL,NULL,NULL,NULL),(402,49,'Phenol','Fenol/ Phenol','mg/L',NULL,85000.00,1,NULL,'1',NULL,NULL,NULL,NULL),(403,68,'Oil and Grease','Minyak dan Lemak/ Oil and Grease','mg/L',NULL,125000.00,1,NULL,'20',NULL,NULL,NULL,NULL),(404,84,'Total Coliform','Total coliform','MPN/100mL',NULL,145000.00,1,NULL,'1000',NULL,NULL,NULL,NULL),(405,88,'Fe','Besi Total/Total Iron, (Fe)','mg/L',NULL,35000.00,1,NULL,'7',NULL,NULL,NULL,NULL),(406,88,'Mn','Mangan Total/ Total Manganese, (Mn)','mg/L',NULL,77500.00,1,NULL,'4',NULL,NULL,NULL,NULL),(407,41,'BOD','Kebutuhan Oksigen Biokimiawi/ Biochemical Oxygen Demand, (BOD)','mg/L',NULL,75000.00,1,NULL,'<5000',NULL,NULL,NULL,NULL),(408,42,'COD','Kebutuhan Oksigen Kimiawi/ Chemical Oxygen Demand, (COD)','mg/L',NULL,75000.00,1,NULL,'-',NULL,NULL,NULL,NULL),(409,68,'Oil and Grease','Minyak dan Lemak/ Oil and Grease','mg/L',NULL,125000.00,1,NULL,'-',NULL,NULL,NULL,NULL),(410,62,'Cd','Kadmium Total/ Total Cadmium. (Cd)','mg/L',NULL,115000.00,1,NULL,'-',NULL,NULL,NULL,NULL),(411,61,'Cu','Tembaga Total/ Total Copper, (Cu)','mg/L',NULL,77500.00,1,NULL,'-',NULL,NULL,NULL,NULL),(412,89,'Pb','Timbal Total/ Total Lead, (Pb)','mg/L',NULL,115000.00,1,NULL,'-',NULL,NULL,NULL,NULL),(413,61,'Zn','Seng Total/ Total Zinc, (Zn)','mg/L',NULL,77500.00,1,NULL,'-',NULL,NULL,NULL,NULL),(414,42,'COD','Kebutuhan Oksigen Kimiawi/ Chemical Oxygen Demand, (COD)','mg/L',NULL,75.00,1,NULL,'150',NULL,NULL,NULL,NULL),(415,38,'TSS','Total Padatan Tersuspensi/Total Suspended Solids, (TSS)','mg/L',NULL,35000.00,1,NULL,'60',NULL,NULL,NULL,NULL),(416,68,'Oil and Grease','Minyak dan Lemak/ Oil and Grease','mg/L',NULL,125000.00,1,NULL,'5',NULL,NULL,NULL,NULL),(417,NULL,'Resistivity','Resistivity (daya tahan listrik)','MΩ-cm, suhu 25°C',NULL,35000.00,3,NULL,NULL,NULL,NULL,NULL,NULL),(418,74,'Conductivity','Conductivity (daya hantar listrik)','uS/cm',NULL,35000.00,1,NULL,NULL,NULL,NULL,NULL,NULL),(419,40,'pH','Derajat Keasaman/Potential of Hydrogen, (pH)','-, suhu 25°C',NULL,12500.00,1,NULL,NULL,NULL,NULL,NULL,NULL),(420,NULL,'TOC','Senyawa organic total Total Organic Carbon, (TOC)','ug/l',NULL,750000.00,3,NULL,NULL,NULL,NULL,NULL,NULL),(421,98,'Sodium','Natrium/Sodium','ug/l',NULL,77500.00,1,NULL,NULL,NULL,NULL,NULL,NULL),(422,NULL,'Silica','Silika/Silica','ug/l',NULL,NULL,3,NULL,NULL,NULL,NULL,NULL,NULL),(423,46,'Chloride','Khlorida/ Chloride','ug/l',NULL,40000.00,1,NULL,NULL,NULL,NULL,NULL,NULL),(424,99,'Escherichia Coli','Escherichia coli','CFU/100 mL',NULL,145000.00,1,NULL,'0',NULL,NULL,NULL,NULL),(425,99,'Total Coliform','Total coliform','CFU/100 mL',NULL,145000.00,1,NULL,'0',NULL,NULL,NULL,NULL),(426,97,'Temperature','Suhu/Temperature','ºC',NULL,12500.00,1,NULL,'Suhu udara ± 3',NULL,NULL,NULL,NULL),(427,36,'Temperature','Suhu/Temperature','ºC',NULL,12500.00,2,NULL,'Suhu udara ± 4',NULL,NULL,NULL,NULL),(428,37,'TDS','Total Padatan Terlarut/Total Dissolved Solids, (TDS)','mg/L',NULL,35000.00,1,NULL,'<300',NULL,NULL,NULL,NULL),(429,76,'Turbidity','Kekeruhan/Turbidity','mg/L',NULL,20000.00,1,NULL,'<3',NULL,NULL,NULL,NULL),(430,39,'Color','Warna/Color','mg/L',NULL,35000.00,1,NULL,'10',NULL,NULL,NULL,NULL),(431,100,'Odor','Bau/Odor','-',NULL,12500.00,1,NULL,'Tidak berbau',NULL,NULL,NULL,NULL),(432,40,'pH','Derajat Keasaman/ Potential of Hydrogen, (pH)','mg/L',NULL,12500.00,1,NULL,'6.5-8.5',NULL,NULL,NULL,NULL),(433,101,'NO3','Nitrat Sebagai NO3/Nitrate as NO3, (NO3)','mg/L',NULL,40000.00,1,NULL,'20',NULL,NULL,NULL,NULL),(434,102,'NO2','Nitrit Sebagai NO2/ Nitrate as NO2, (NO2)','mg/L',NULL,40000.00,1,NULL,'3',NULL,NULL,NULL,NULL),(435,67,'Cr+6','Krom Heksavalen Terlarut/ Dissolved Hexavalent Chromium, (Cr+6)','mg/L',NULL,115000.00,1,NULL,'0,01',NULL,NULL,NULL,NULL),(436,61,'Fe','Besi Terlarut/ Dissolved Iron, (Fe)','mg/L',NULL,77500.00,1,NULL,'0,2',NULL,NULL,NULL,NULL),(437,61,'Mn','Mangan Terlarut/ Dissolved Manganese, (Mn)','mg/L',NULL,77500.00,1,NULL,'0,1',NULL,NULL,NULL,NULL),(438,38,'TSS','Padatan Tersuspensi Total/Total Suspended Solids, (TSS)','mg/L',NULL,35000.00,1,NULL,'-',NULL,NULL,NULL,NULL),(439,40,'pH','Derajat Keasaman/Potential of Hydrogen, (pH)','--',NULL,12500.00,1,NULL,'6.5-8.5',NULL,NULL,NULL,NULL),(440,41,'BOD5','Kebutuhan Oksigen Biokimia/Biochemical Oxygen Demand, (BOD5)','mg/L',NULL,75000.00,1,NULL,'-',NULL,NULL,NULL,NULL),(441,42,'COD','Kebutuhan Oksigen Kimiawi/Chemical Oxygen Demand, (COD)','mg/L',NULL,75000.00,1,NULL,'-',NULL,NULL,NULL,NULL),(442,43,'DO','Oksigen Terlarut/Dissolved Oxygen, (DO)','mg/L',NULL,40000.00,1,NULL,'-',NULL,NULL,NULL,NULL),(443,44,'DO','Oksigen Terlarut/Dissolved Oxygen, (DO)','mg/L',NULL,40000.00,1,NULL,'-',NULL,NULL,NULL,NULL),(444,102,'NO2','Nitrit Sebagai NO2/Nitrite as NO2, (NO2)','mg/L',NULL,40000.00,1,NULL,'3',NULL,NULL,NULL,NULL),(445,51,'Total Phosphate as P','Total Fosfat sebagai P/Total Phosphate as P','mg/L',NULL,45000.00,1,NULL,'-',NULL,NULL,NULL,NULL),(446,68,'Oil and Grease','Minyak dan Lemak/Oil and Grease','mg/L',NULL,125000.00,NULL,NULL,'-',NULL,NULL,NULL,NULL),(447,61,'Zn','Seng Terlarut/Dissolved Zinc, (Zn)','mg/L',NULL,77500.00,1,NULL,'-',NULL,NULL,NULL,NULL),(448,88,'Cu','Tembaga Terlarut/ Dissolved Copper, (Cu)','mg/L',NULL,77500.00,1,NULL,'-',NULL,NULL,NULL,NULL),(449,62,'Cd','Kadmium Terlarut/ Dissolved Cadmium (Cd)','mg/L',NULL,115000.00,1,NULL,'-',NULL,NULL,NULL,NULL),(450,89,'Pb','Timbal Terlarut/ Dissolved Lead (Pb)','mg/L',NULL,115000.00,1,NULL,'-',NULL,NULL,NULL,NULL),(451,103,'NH3-N','Ammonia/Ammonia, (NH3-N)','mg/L',NULL,75000.00,1,NULL,'-',NULL,NULL,NULL,NULL),(452,46,'Cl-','Klorida/Chlorida, (Cl-','mg/L',NULL,40000.00,1,NULL,'-',NULL,NULL,NULL,NULL),(453,45,'SO4 2-','Sulfat/Sulfate, (SO4 2-)','mg/L',NULL,40000.00,1,NULL,'-',NULL,NULL,NULL,NULL),(454,73,'Rubbish','Sampah/Rubbish',NULL,NULL,15000.00,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(455,75,'TS','Total Padatan/Total Solids, (TS)','mg/L',NULL,35000.00,1,NULL,'-',NULL,NULL,NULL,NULL),(456,104,'PO4 3-','Orthopospat/Orthophosphate, (PO4 3-)','mg/L',NULL,45000.00,1,NULL,'-',NULL,NULL,NULL,NULL),(457,52,'F','Fluorida/Flouride, (F)','mg/L',NULL,40000.00,1,NULL,'-',NULL,NULL,NULL,NULL),(458,105,'NO3','Nitrat sebagai NO3/Nitrate as NO3, (NO3)','mg/L',NULL,40000.00,1,NULL,'20',NULL,NULL,NULL,NULL),(459,106,'NO2','Nitrit sebagai NO2/Nitrite as NO2, (NO2)','mg/L',NULL,40000.00,1,NULL,'3',NULL,NULL,NULL,NULL),(460,47,'NO3-N','Nitrat sebagai N/Nitrate as N, (NO3-N)','mg/L',NULL,40000.00,1,NULL,'-',NULL,NULL,NULL,NULL),(461,48,'NO2-N','Nitrit sebagai N/Nitrite as N, (NO2-N)','mg/L',NULL,40000.00,1,NULL,'-',NULL,NULL,NULL,NULL),(462,54,'CN-','Sianida/Cyanide, (CN-)','mg/L',NULL,40000.00,1,NULL,'-',NULL,NULL,NULL,NULL),(463,46,'Cl-','Klorida/Chlorida, (Cl-)','mg/L',NULL,55000.00,1,NULL,'-',NULL,NULL,NULL,NULL),(464,45,'SO4-2','Sulfat/Sulfate, (SO4-2)','mg/L',NULL,40000.00,1,NULL,'-',NULL,NULL,NULL,NULL),(465,49,'NH3-N','Amoniak Sebagai N/Ammonia as N, (NH3-N)','mg/L',NULL,75000.00,1,NULL,'-',NULL,NULL,NULL,NULL),(466,107,'NH3','Amoniak/Ammonia, (NH3)','mg/L',NULL,75000.00,1,NULL,'-',NULL,NULL,NULL,NULL),(467,108,'MBAS','Deterjen/Detergent, (MBAS)','mg/L',NULL,80000.00,1,NULL,'-',NULL,NULL,NULL,NULL),(468,59,'As','Arsen/Arsen, (As)','mg/L',NULL,115000.00,1,NULL,'-',NULL,NULL,NULL,NULL),(469,57,'B','Boron/Boron, (B)','mg/L',NULL,77500.00,1,NULL,'-',NULL,NULL,NULL,NULL),(470,92,'Se','Selenium/Selenium, (Se)','mg/L',NULL,115000.00,1,NULL,'-',NULL,NULL,NULL,NULL),(471,56,'Ba','Barium/Barium, (Ba)','mg/L',NULL,77500.00,1,NULL,'-',NULL,NULL,NULL,NULL),(472,58,'Hg','Merkuri/Mercury, (Hg)','mg/L',NULL,17500.00,1,NULL,'-',NULL,NULL,NULL,NULL),(473,62,'Cd','Kadmium/Cadmium, (Cd)','mg/L',NULL,115000.00,1,NULL,'-',NULL,NULL,NULL,NULL),(474,109,'Cu','Tembaga/Copper, (Cu)','mg/L',NULL,77500.00,1,NULL,'-',NULL,NULL,NULL,NULL),(475,61,'Fe','Besi/Iron, (Fe)','mg/L',NULL,77500.00,1,NULL,'0,2',NULL,NULL,NULL,NULL),(476,61,'Mn','Mangan/Manganese, (Mn)','mg/L',NULL,77500.00,1,NULL,'0,1',NULL,NULL,NULL,NULL),(477,61,'Zn','Seng/Zinc, (Zn)','mg/L',NULL,77500.00,1,NULL,'-',NULL,NULL,NULL,NULL),(478,93,'Co','Kobalt/Cobalt, (Co)','mg/L',NULL,115000.00,1,NULL,'-',NULL,NULL,NULL,NULL),(479,89,'Pb','Timbal/Lead, (Pb)','mg/L',NULL,115000.00,1,NULL,'-',NULL,NULL,NULL,NULL),(480,110,'Cr','Krom/Chromium, (Cr)','mg/L',NULL,115000.00,1,NULL,'-',NULL,NULL,NULL,NULL),(481,67,'Cr6+','Krom Heksavalen/Hexavalent Chromium, (Cr6+)','mg/L',NULL,115000.00,1,NULL,'-',NULL,NULL,NULL,NULL),(482,100,'Bau','Bau','-',NULL,12500.00,1,NULL,'Tidak Berbau',NULL,NULL,NULL,NULL),(483,76,'Kekeruhan','Kekeruhan','NTU',NULL,20000.00,1,NULL,'0,5',NULL,NULL,NULL,NULL),(484,81,'Kejernihan','Kejernihan','ºC',NULL,15000.00,1,NULL,'16-40',NULL,NULL,NULL,NULL),(485,NULL,'Kepadatan Perenang','Kepadatan Perenang (Kedalaman <1 m)','M2/perenang',NULL,NULL,2,NULL,'2,2',NULL,NULL,NULL,NULL),(486,NULL,'Kepadatan Perenang','Kepadatan Perenang (Kedalaman 1-1.5 m)','M2/perenang',NULL,NULL,2,NULL,'2,7',NULL,NULL,NULL,NULL),(487,NULL,'Kepadatan Perenang','Kepadatan Perenang (Kedalaman >1.5 m)','M2/perenang',NULL,NULL,2,NULL,'4',NULL,NULL,NULL,NULL),(488,99,'Escherichia Coli','Escherichia coli','CFU/100 mL',NULL,145000.00,1,NULL,'<1',NULL,NULL,NULL,NULL),(489,NULL,'HPC','Heterotrophic Plate Count (HPC)','CFU/100 mL',NULL,NULL,3,NULL,'100',NULL,NULL,NULL,NULL),(490,NULL,'Pseudomonasaeru aureus','Pseudomonasaeru aureus','-',NULL,NULL,3,NULL,'<1',NULL,NULL,NULL,NULL),(491,NULL,'Staphylococcus','Staphylococcus','CFU/100 mL',NULL,NULL,3,NULL,'<100',NULL,NULL,NULL,NULL),(492,NULL,'Legionella spp','Legionella spp','CFU/100 mL',NULL,NULL,3,NULL,'<1',NULL,NULL,NULL,NULL),(493,40,'pH','pH','-',NULL,12500.00,1,NULL,'7-7.80',NULL,NULL,NULL,NULL),(494,40,'pH','pH','-',NULL,12500.00,1,NULL,'7-8',NULL,NULL,NULL,NULL),(495,80,'Alkalinitas','Alkalinitas','mg/L',NULL,40000.00,2,NULL,'80-200',NULL,NULL,NULL,NULL),(496,55,'Sisa Khlor Bebas','Sisa Khlor Bebas','mg/L',NULL,40000.00,1,NULL,'1-1.5',NULL,NULL,NULL,NULL),(497,55,'Sisa Khlor Bebas','Sisa Khlor Bebas','mg/L',NULL,40000.00,1,NULL,'2-3',NULL,NULL,NULL,NULL),(498,NULL,'Sisa Khlor Terikat','Sisa Khlor Terikat','mg/L',NULL,NULL,3,NULL,'3',NULL,NULL,NULL,NULL),(499,NULL,'Total Bromide','Total Bromide','mg/L',NULL,1600000.00,3,NULL,'2-2.5',NULL,NULL,NULL,NULL),(500,NULL,'Total Bromide','Total Bromide','mg/L',NULL,1600000.00,3,NULL,'4-5',NULL,NULL,NULL,NULL),(501,NULL,'Sisa Bromine','Sisa Bromine','mg/L',NULL,NULL,3,NULL,'3-4',NULL,NULL,NULL,NULL),(502,81,'Kejernihan','Kejernihan','Piringan Terlihat Jelas',NULL,15000.00,1,NULL,'-',NULL,NULL,NULL,NULL),(503,97,'Suhu/Temperature','Suhu/Temperature','ºC',NULL,12500.00,1,NULL,'<40',NULL,NULL,NULL,NULL),(504,36,'Suhu/Temperature','Suhu/Temperature','ºC',NULL,12500.00,2,NULL,'<41',NULL,NULL,NULL,NULL),(505,NULL,'HPC','Heterotrophic Plate Count (HPC)','CFU/100 mL',NULL,NULL,3,NULL,'<200',NULL,NULL,NULL,NULL),(506,NULL,'Pseudomonas Aeruginosa','Pseudomonas Aeruginosa','CFU/100 mL',NULL,NULL,3,NULL,'<1',NULL,NULL,NULL,NULL),(507,NULL,'Pseudomonas Aeruginosa','Pseudomonas Aeruginosa','CFU/100 mL',NULL,NULL,3,NULL,'<100',NULL,NULL,NULL,NULL),(508,40,'pH','pH','-',NULL,12500.00,1,NULL,'7.2-7.80',NULL,NULL,NULL,NULL),(509,40,'pH','pH','-',NULL,125000.00,1,NULL,'7.2-8.0',NULL,NULL,NULL,NULL),(510,NULL,'Sisa Khlor Bebas','Sisa Khlor Bebas','mg/L',NULL,40000.00,3,NULL,'3',NULL,NULL,NULL,NULL),(511,NULL,'HC','HC <2010 (2 langkah) (Sepeda motor berpenggerak penyalaan cetus api (bensin))','ppm',NULL,275000.00,2,NULL,'L=6000,M=-,N=-,O=-','superadmin','superadmin','2026-03-30 16:28:39','2026-03-30 16:30:15');
/*!40000 ALTER TABLE `parameters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `params`
--

DROP TABLE IF EXISTS `params`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `params` (
  `code` varchar(50) NOT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `params`
--

LOCK TABLES `params` WRITE;
/*!40000 ALTER TABLE `params` DISABLE KEYS */;
INSERT INTO `params` VALUES ('(CH3)2S','Seeder','Seeder',NULL,NULL),('%I','Seeder','Seeder',NULL,NULL),('Achnanthes sp.','Seeder','Seeder',NULL,NULL),('Actinocyclus sp.','Seeder','Seeder',NULL,NULL),('Air Temperature','Seeder','Seeder',NULL,NULL),('Alkalinitas','Seeder','Seeder',NULL,NULL),('Alkalinity','Seeder','Seeder',NULL,NULL),('Alona sp.','Seeder','Seeder',NULL,NULL),('Ameletus sp','Seeder','Seeder',NULL,NULL),('Anabaena sp.','Seeder','Seeder',NULL,NULL),('Anionic Surfactants as MBAS','Seeder','Seeder',NULL,NULL),('AOX','Seeder','Seeder',NULL,NULL),('Aquarius sp','Seeder','Seeder',NULL,NULL),('ARANEAE','Seeder','Seeder',NULL,NULL),('Araneus sp','Seeder','Seeder',NULL,NULL),('Arcella sp.','Seeder','Seeder',NULL,NULL),('AS','Seeder','Seeder',NULL,NULL),('B','Seeder','Seeder',NULL,NULL),('Ba','Seeder','Seeder',NULL,NULL),('BACILLARIOPHYCEAE:','Seeder','Seeder',NULL,NULL),('Bau','Seeder','Seeder',NULL,NULL),('BHC','Seeder','Seeder',NULL,NULL),('BOD','Seeder','Seeder',NULL,NULL),('BOD5','Seeder','Seeder',NULL,NULL),('Brachionus sp.','Seeder','Seeder',NULL,NULL),('Bws','Seeder','Seeder',NULL,NULL),('C6H8CHCH2','Seeder','Seeder',NULL,NULL),('Cd','Seeder','Seeder',NULL,NULL),('Centropyxis sp.','Seeder','Seeder',NULL,NULL),('Ceratium sp.','Seeder','Seeder',NULL,NULL),('Ceriodaphina sp.','Seeder','Seeder',NULL,NULL),('CH3SH','Seeder','Seeder',NULL,NULL),('Chironomus sp','Seeder','Seeder',NULL,NULL),('Chlordane','Seeder','Seeder',NULL,NULL),('Chloride','Seeder','Seeder',NULL,NULL),('CHLOROPHYCEAE:','Seeder','Seeder',NULL,NULL),('Chodatella sp.','Seeder','Seeder',NULL,NULL),('Cl-','Seeder','Seeder',NULL,NULL),('Cl2','Seeder','Seeder',NULL,NULL),('Closterium sp.','Seeder','Seeder',NULL,NULL),('CN-','Seeder','Seeder',NULL,NULL),('CO','Seeder','Seeder',NULL,NULL),('CO2','Seeder','Seeder',NULL,NULL),('CO2 Value','Seeder','Seeder',NULL,NULL),('COD','Seeder','Seeder',NULL,NULL),('Color','Seeder','Seeder',NULL,NULL),('Conductivity','Seeder','Seeder',NULL,NULL),('Copepedia sp.','Seeder','Seeder',NULL,NULL),('Cosmarium sp.','Seeder','Seeder',NULL,NULL),('Cr','Seeder','Seeder',NULL,NULL),('Cr+6','Seeder','Seeder',NULL,NULL),('Cr6+','Seeder','Seeder',NULL,NULL),('CRUSTACEAE','Seeder','Seeder',NULL,NULL),('CRUSTACEAE:','Seeder','Seeder',NULL,NULL),('Cu','Seeder','Seeder',NULL,NULL),('CYANOPHYCEAE:','Seeder','Seeder',NULL,NULL),('D','Seeder','Seeder',NULL,NULL),('DDT','Seeder','Seeder',NULL,NULL),('Debit','Seeder','Seeder',NULL,NULL),('Desmidium sp.','Seeder','Seeder',NULL,NULL),('Dieldrin','Seeder','Seeder',NULL,NULL),('Difflugia sp.','Seeder','Seeder',NULL,NULL),('Dinobryon sp.','Seeder','Seeder',NULL,NULL),('DINOPHYCEAE :','Seeder','Seeder',NULL,NULL),('DO','Seeder','Seeder',NULL,NULL),('Dominasi (D)','Seeder','Seeder',NULL,NULL),('E','Seeder','Seeder',NULL,NULL),('Endrin','Seeder','Seeder',NULL,NULL),('EPHEMEROPTERA :','Seeder','Seeder',NULL,NULL),('Eriocheir sp.','Seeder','Seeder',NULL,NULL),('Escherichia coli','Seeder','Seeder',NULL,NULL),('Euastrum sp.','Seeder','Seeder',NULL,NULL),('Eudorina sp.','Seeder','Seeder',NULL,NULL),('Euglena sp.','Seeder','Seeder',NULL,NULL),('EUGLENOPHYCEAE:','Seeder','Seeder',NULL,NULL),('Euglypha sp.','Seeder','Seeder',NULL,NULL),('F','Seeder','Seeder',NULL,NULL),('F-','Seeder','Seeder',NULL,NULL),('Fe','Seeder','Seeder',NULL,NULL),('Fecal Coliform','Seeder','Seeder',NULL,NULL),('Fragilaria sp.','Seeder','Seeder',NULL,NULL),('Frustulia sp.','Seeder','Seeder',NULL,NULL),('GASTROPODA','Seeder','Seeder',NULL,NULL),('Gerris sp.','Seeder','Seeder',NULL,NULL),('Golenkinia sp.','Seeder','Seeder',NULL,NULL),('Gonatozygon sp.','Seeder','Seeder',NULL,NULL),('H\'','Seeder','Seeder',NULL,NULL),('H2S','Seeder','Seeder',NULL,NULL),('Harpacticus sp.','Seeder','Seeder',NULL,NULL),('HC','Seeder','Seeder',NULL,NULL),('HCL','Seeder','Seeder',NULL,NULL),('HEMIPTERA','Seeder','Seeder',NULL,NULL),('Heptachlor','Seeder','Seeder',NULL,NULL),('HF','Seeder','Seeder',NULL,NULL),('HG','Seeder','Seeder',NULL,NULL),('HPC','Seeder','Seeder',NULL,NULL),('Humidity','Seeder','Seeder',NULL,NULL),('HYMENOPTERA','Seeder','Seeder',NULL,NULL),('Ind./L','Seeder','Seeder',NULL,NULL),('Keanekaragaman (H\')','Seeder','Seeder',NULL,NULL),('Kejernihan','Seeder','Seeder',NULL,NULL),('Kekeruhan','Seeder','Seeder',NULL,NULL),('Kelimpahan (Ind./L)','Seeder','Seeder',NULL,NULL),('Kepadatan Perenang','Seeder','Seeder',NULL,NULL),('Klorofil-a','Seeder','Seeder',NULL,NULL),('Lavg','Seeder','Seeder',NULL,NULL),('Legionella spp','Seeder','Seeder',NULL,NULL),('Leq','Seeder','Seeder',NULL,NULL),('Lindane','Seeder','Seeder',NULL,NULL),('LM','Seeder','Seeder',NULL,NULL),('LS','Seeder','Seeder',NULL,NULL),('LSM','Seeder','Seeder',NULL,NULL),('Lumbriculus sp','Seeder','Seeder',NULL,NULL),('Macrozoobenthos','Seeder','Seeder',NULL,NULL),('MBAS','Seeder','Seeder',NULL,NULL),('Md','Seeder','Seeder',NULL,NULL),('Medetera sp','Seeder','Seeder',NULL,NULL),('Melanoides sp','Seeder','Seeder',NULL,NULL),('Merismopedia sp.','Seeder','Seeder',NULL,NULL),('Methoxychlor','Seeder','Seeder',NULL,NULL),('Micrasterias sp.','Seeder','Seeder',NULL,NULL),('Microspora sp.','Seeder','Seeder',NULL,NULL),('Mn','Seeder','Seeder',NULL,NULL),('Monomorium sp.','Seeder','Seeder',NULL,NULL),('Monostylla sp.','Seeder','Seeder',NULL,NULL),('Mougeotia sp.','Seeder','Seeder',NULL,NULL),('Mysis sp','Seeder','Seeder',NULL,NULL),('Nauplius sp.','Seeder','Seeder',NULL,NULL),('Navicula sp.','Seeder','Seeder',NULL,NULL),('Neidium sp.','Seeder','Seeder',NULL,NULL),('Nematoda worm (sp)','Seeder','Seeder',NULL,NULL),('NEMATODA:','Seeder','Seeder',NULL,NULL),('NH3','Seeder','Seeder',NULL,NULL),('NH3-N','Seeder','Seeder',NULL,NULL),('Ni','Seeder','Seeder',NULL,NULL),('Nitzschia sp.','Seeder','Seeder',NULL,NULL),('NMHC','Seeder','Seeder',NULL,NULL),('NO Value','Seeder','Seeder',NULL,NULL),('NO2','Seeder','Seeder',NULL,NULL),('NO2-N','Seeder','Seeder',NULL,NULL),('NO3','Seeder','Seeder',NULL,NULL),('NO3-N','Seeder','Seeder',NULL,NULL),('O2 Value','Seeder','Seeder',NULL,NULL),('O3','Seeder','Seeder',NULL,NULL),('O4','Seeder','Seeder',NULL,NULL),('ODONATA','Seeder','Seeder',NULL,NULL),('Odor','Seeder','Seeder',NULL,NULL),('Oil and Grease','Seeder','Seeder',NULL,NULL),('Opacity','Seeder','Seeder',NULL,NULL),('Opasitas','Seeder','Seeder',NULL,NULL),('Orthophosphate','Seeder','Seeder',NULL,NULL),('ORTHOPTERA','Seeder','Seeder',NULL,NULL),('Oscillatoria sp.','Seeder','Seeder',NULL,NULL),('Pachydiplax sp','Seeder','Seeder',NULL,NULL),('Paramecium sp.','Seeder','Seeder',NULL,NULL),('Particulate','Seeder','Seeder',NULL,NULL),('Pb','Seeder','Seeder',NULL,NULL),('PCBs','Seeder','Seeder',NULL,NULL),('PCDDs','Seeder','Seeder',NULL,NULL),('PCDFs','Seeder','Seeder',NULL,NULL),('Pediastrum sp.','Seeder','Seeder',NULL,NULL),('Pemerataan (E)','Seeder','Seeder',NULL,NULL),('Periplaneta sp','Seeder','Seeder',NULL,NULL),('pH','Seeder','Seeder',NULL,NULL),('Phacus sp.','Seeder','Seeder',NULL,NULL),('Phenol','Seeder','Seeder',NULL,NULL),('Philodina sp.','Seeder','Seeder',NULL,NULL),('Phytoplankton','Seeder','Seeder',NULL,NULL),('Pinnularia sp.','Seeder','Seeder',NULL,NULL),('Pleurosigma sp.','Seeder','Seeder',NULL,NULL),('PM10','Seeder','Seeder',NULL,NULL),('PM2.5','Seeder','Seeder',NULL,NULL),('PO4 3-','Seeder','Seeder',NULL,NULL),('Pressure','Seeder','Seeder',NULL,NULL),('PROTOZOA:','Seeder','Seeder',NULL,NULL),('Pseudomonas Aeruginosa','Seeder','Seeder',NULL,NULL),('Pseudomonasaeru aureus','Seeder','Seeder',NULL,NULL),('Psychodidae sp','Seeder','Seeder',NULL,NULL),('Qact','Seeder','Seeder',NULL,NULL),('Radioaktifitas Gross B','Seeder','Seeder',NULL,NULL),('Radioaktivitas Gross A','Seeder','Seeder',NULL,NULL),('Radioaktivitas Gross B','Seeder','Seeder',NULL,NULL),('Resistivity','Seeder','Seeder',NULL,NULL),('Rhyacophila sp.','Seeder','Seeder',NULL,NULL),('ROTIFERA:','Seeder','Seeder',NULL,NULL),('Rubbish','Seeder','Seeder',NULL,NULL),('S','Seeder','Seeder',NULL,NULL),('Salinity','Seeder','Seeder',NULL,NULL),('Salmonela','Seeder','Seeder',NULL,NULL),('Sb','Seeder','Seeder',NULL,NULL),('Scenedemus sp.','Seeder','Seeder',NULL,NULL),('Se','Seeder','Seeder',NULL,NULL),('Shigela','Seeder','Seeder',NULL,NULL),('Shock Vibration','Seeder','Seeder',NULL,NULL),('Silica','Seeder','Seeder',NULL,NULL),('Sisa Bromine','Seeder','Seeder',NULL,NULL),('Sisa Khlor Bebas','Seeder','Seeder',NULL,NULL),('Sisa Khlor Terikat','Seeder','Seeder',NULL,NULL),('Sn','Seeder','Seeder',NULL,NULL),('SO2','Seeder','Seeder',NULL,NULL),('SO4 2-','Seeder','Seeder',NULL,NULL),('SO4-2','Seeder','Seeder',NULL,NULL),('Sodium','Seeder','Seeder',NULL,NULL),('Sphaerocytis sp.','Seeder','Seeder',NULL,NULL),('Spirogyra sp.','Seeder','Seeder',NULL,NULL),('Spirulina sp.','Seeder','Seeder',NULL,NULL),('Squatinella sp.','Seeder','Seeder',NULL,NULL),('Stack Code','Seeder','Seeder',NULL,NULL),('Stack Temperature','Seeder','Seeder',NULL,NULL),('Staphylococcus','Seeder','Seeder',NULL,NULL),('Staurastrum sp.','Seeder','Seeder',NULL,NULL),('Streptococus','Seeder','Seeder',NULL,NULL),('Suhu/Temperature','Seeder','Seeder',NULL,NULL),('Sulfur as H2S','Seeder','Seeder',NULL,NULL),('Surirella sp.','Seeder','Seeder',NULL,NULL),('Tabellaria sp.','Seeder','Seeder',NULL,NULL),('Taksa (S)','Seeder','Seeder',NULL,NULL),('TDS','Seeder','Seeder',NULL,NULL),('Temperature','Seeder','Seeder',NULL,NULL),('Tetraedron sp.','Seeder','Seeder',NULL,NULL),('TOC','Seeder','Seeder',NULL,NULL),('Total Bahan Organik','Seeder','Seeder',NULL,NULL),('Total Bromide','Seeder','Seeder',NULL,NULL),('Total Coliform','Seeder','Seeder',NULL,NULL),('Total Karbon','Seeder','Seeder',NULL,NULL),('Total Nitrogen','Seeder','Seeder',NULL,NULL),('Total Phospate as P','Seeder','Seeder',NULL,NULL),('Total Phosphate as P','Seeder','Seeder',NULL,NULL),('Toxapan','Seeder','Seeder',NULL,NULL),('Trachelomonas sp.','Seeder','Seeder',NULL,NULL),('Transparency','Seeder','Seeder',NULL,NULL),('Traverse Ponts','Seeder','Seeder',NULL,NULL),('TRICHOPTERA','Seeder','Seeder',NULL,NULL),('TS','Seeder','Seeder',NULL,NULL),('TSP','Seeder','Seeder',NULL,NULL),('TSS','Seeder','Seeder',NULL,NULL),('Turbidity','Seeder','Seeder',NULL,NULL),('Ulothrix sp.','Seeder','Seeder',NULL,NULL),('Vibrio cholera','Seeder','Seeder',NULL,NULL),('Vorticella sp.','Seeder','Seeder',NULL,NULL),('Wailesella sp.','Seeder','Seeder',NULL,NULL),('Weather','Seeder','Seeder',NULL,NULL),('Wind Direction','Seeder','Seeder',NULL,NULL),('Wind Speed','Seeder','Seeder',NULL,NULL),('Zn','Seeder','Seeder',NULL,NULL),('Zooplankton','Seeder','Seeder',NULL,NULL),('ZYGNEMATOPHYCEAE','Seeder','Seeder',NULL,NULL),('Zygnemopsis sp.','Seeder','Seeder',NULL,NULL);
/*!40000 ALTER TABLE `params` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `invoice_id` bigint unsigned NOT NULL,
  `payment_date` date NOT NULL,
  `amount_paid` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `reference_number` varchar(255) DEFAULT NULL,
  `notes` text,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `attachment_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_payments_invoice` (`invoice_id`),
  CONSTRAINT `fk_payments_invoice` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=143 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'view-any-user','web','2026-03-29 11:12:45','2026-03-29 11:12:45'),(2,'view-user','web','2026-03-29 11:12:45','2026-03-29 11:12:45'),(3,'create-user','web','2026-03-29 11:12:45','2026-03-29 11:12:45'),(4,'update-user','web','2026-03-29 11:12:45','2026-03-29 11:12:45'),(5,'delete-user','web','2026-03-29 11:12:45','2026-03-29 11:12:45'),(6,'view-chart-role-personel','web','2026-03-29 11:12:45','2026-03-29 11:12:45'),(7,'view-any-personel','web','2026-03-29 11:12:45','2026-03-29 11:12:45'),(8,'view-personel','web','2026-03-29 11:12:45','2026-03-29 11:12:45'),(9,'create-personel','web','2026-03-29 11:12:45','2026-03-29 11:12:45'),(10,'update-personel','web','2026-03-29 11:12:45','2026-03-29 11:12:45'),(11,'delete-personel','web','2026-03-29 11:12:45','2026-03-29 11:12:45'),(12,'view-any-position','web','2026-03-29 11:12:45','2026-03-29 11:12:45'),(13,'view-position','web','2026-03-29 11:12:45','2026-03-29 11:12:45'),(14,'create-position','web','2026-03-29 11:12:45','2026-03-29 11:12:45'),(15,'update-position','web','2026-03-29 11:12:45','2026-03-29 11:12:45'),(16,'delete-position','web','2026-03-29 11:12:46','2026-03-29 11:12:46'),(17,'view-any-province','web','2026-03-29 11:12:46','2026-03-29 11:12:46'),(18,'view-province','web','2026-03-29 11:12:46','2026-03-29 11:12:46'),(19,'create-province','web','2026-03-29 11:12:46','2026-03-29 11:12:46'),(20,'update-province','web','2026-03-29 11:12:46','2026-03-29 11:12:46'),(21,'delete-province','web','2026-03-29 11:12:46','2026-03-29 11:12:46'),(22,'view-any-city','web','2026-03-29 11:12:46','2026-03-29 11:12:46'),(23,'view-city','web','2026-03-29 11:12:46','2026-03-29 11:12:46'),(24,'create-city','web','2026-03-29 11:12:46','2026-03-29 11:12:46'),(25,'update-city','web','2026-03-29 11:12:46','2026-03-29 11:12:46'),(26,'delete-city','web','2026-03-29 11:12:46','2026-03-29 11:12:46'),(27,'view-chart-customer','web','2026-03-29 11:12:46','2026-03-29 11:12:46'),(28,'view-any-customer','web','2026-03-29 11:12:46','2026-03-29 11:12:46'),(29,'view-customer','web','2026-03-29 11:12:46','2026-03-29 11:12:46'),(30,'create-customer','web','2026-03-29 11:12:46','2026-03-29 11:12:46'),(31,'update-customer','web','2026-03-29 11:12:46','2026-03-29 11:12:46'),(32,'delete-customer','web','2026-03-29 11:12:46','2026-03-29 11:12:46'),(33,'view-any-role','web','2026-03-29 11:12:46','2026-03-29 11:12:46'),(34,'view-role','web','2026-03-29 11:12:46','2026-03-29 11:12:46'),(35,'create-role','web','2026-03-29 11:12:46','2026-03-29 11:12:46'),(36,'update-role','web','2026-03-29 11:12:46','2026-03-29 11:12:46'),(37,'delete-role','web','2026-03-29 11:12:46','2026-03-29 11:12:46'),(38,'view-any-param','web','2026-03-29 11:12:46','2026-03-29 11:12:46'),(39,'view-param','web','2026-03-29 11:12:46','2026-03-29 11:12:46'),(40,'create-param','web','2026-03-29 11:12:46','2026-03-29 11:12:46'),(41,'update-param','web','2026-03-29 11:12:46','2026-03-29 11:12:46'),(42,'delete-param','web','2026-03-29 11:12:46','2026-03-29 11:12:46'),(43,'view-chart-accreditation-status-parameter','web','2026-03-29 11:12:46','2026-03-29 11:12:46'),(44,'view-any-parameter','web','2026-03-29 11:12:46','2026-03-29 11:12:46'),(45,'view-parameter','web','2026-03-29 11:12:46','2026-03-29 11:12:46'),(46,'create-parameter','web','2026-03-29 11:12:46','2026-03-29 11:12:46'),(47,'update-parameter','web','2026-03-29 11:12:46','2026-03-29 11:12:46'),(48,'delete-parameter','web','2026-03-29 11:12:46','2026-03-29 11:12:46'),(49,'view-any-regulation','web','2026-03-29 11:12:46','2026-03-29 11:12:46'),(50,'view-regulation','web','2026-03-29 11:12:46','2026-03-29 11:12:46'),(51,'create-regulation','web','2026-03-29 11:12:46','2026-03-29 11:12:46'),(52,'update-regulation','web','2026-03-29 11:12:46','2026-03-29 11:12:46'),(53,'delete-regulation','web','2026-03-29 11:12:46','2026-03-29 11:12:46'),(54,'view-any-regulation-type','web','2026-03-29 11:12:46','2026-03-29 11:12:46'),(55,'view-regulation-type','web','2026-03-29 11:12:46','2026-03-29 11:12:46'),(56,'create-regulation-type','web','2026-03-29 11:12:46','2026-03-29 11:12:46'),(57,'update-regulation-type','web','2026-03-29 11:12:46','2026-03-29 11:12:46'),(58,'delete-regulation-type','web','2026-03-29 11:12:46','2026-03-29 11:12:46'),(59,'view-any-sample-matric','web','2026-03-29 11:12:46','2026-03-29 11:12:46'),(60,'view-sample-matric','web','2026-03-29 11:12:47','2026-03-29 11:12:47'),(61,'create-sample-matric','web','2026-03-29 11:12:47','2026-03-29 11:12:47'),(62,'update-sample-matric','web','2026-03-29 11:12:47','2026-03-29 11:12:47'),(63,'delete-sample-matric','web','2026-03-29 11:12:47','2026-03-29 11:12:47'),(64,'view-any-sample-type','web','2026-03-29 11:12:47','2026-03-29 11:12:47'),(65,'view-sample-type','web','2026-03-29 11:12:47','2026-03-29 11:12:47'),(66,'create-sample-type','web','2026-03-29 11:12:47','2026-03-29 11:12:47'),(67,'update-sample-type','web','2026-03-29 11:12:47','2026-03-29 11:12:47'),(68,'delete-sample-type','web','2026-03-29 11:12:47','2026-03-29 11:12:47'),(69,'view-any-sample','web','2026-03-29 11:12:47','2026-03-29 11:12:47'),(70,'view-sample','web','2026-03-29 11:12:47','2026-03-29 11:12:47'),(71,'create-sample','web','2026-03-29 11:12:47','2026-03-29 11:12:47'),(72,'update-sample','web','2026-03-29 11:12:47','2026-03-29 11:12:47'),(73,'delete-sample','web','2026-03-29 11:12:47','2026-03-29 11:12:47'),(74,'collecting-sample','web','2026-03-29 11:12:47','2026-03-29 11:12:47'),(75,'receiving-sample','web','2026-03-29 11:12:47','2026-03-29 11:12:47'),(76,'prepare-sample','web','2026-03-29 11:12:47','2026-03-29 11:12:47'),(77,'download-label-sample','web','2026-03-29 11:12:47','2026-03-29 11:12:47'),(78,'view-any-test-method','web','2026-03-29 11:12:47','2026-03-29 11:12:47'),(79,'view-test-method','web','2026-03-29 11:12:47','2026-03-29 11:12:47'),(80,'create-test-method','web','2026-03-29 11:12:47','2026-03-29 11:12:47'),(81,'update-test-method','web','2026-03-29 11:12:47','2026-03-29 11:12:47'),(82,'delete-test-method','web','2026-03-29 11:12:47','2026-03-29 11:12:47'),(83,'view-any-test-package','web','2026-03-29 11:12:47','2026-03-29 11:12:47'),(84,'view-test-package','web','2026-03-29 11:12:47','2026-03-29 11:12:47'),(85,'create-test-package','web','2026-03-29 11:12:47','2026-03-29 11:12:47'),(86,'update-test-package','web','2026-03-29 11:12:47','2026-03-29 11:12:47'),(87,'delete-test-package','web','2026-03-29 11:12:47','2026-03-29 11:12:47'),(88,'view-chart-quotation','web','2026-03-29 11:12:47','2026-03-29 11:12:47'),(89,'view-any-quotation','web','2026-03-29 11:12:47','2026-03-29 11:12:47'),(90,'view-quotation','web','2026-03-29 11:12:47','2026-03-29 11:12:47'),(91,'create-quotation','web','2026-03-29 11:12:47','2026-03-29 11:12:47'),(92,'update-quotation','web','2026-03-29 11:12:47','2026-03-29 11:12:47'),(93,'delete-quotation','web','2026-03-29 11:12:47','2026-03-29 11:12:47'),(94,'preview-quotation','web','2026-03-29 11:12:47','2026-03-29 11:12:47'),(95,'send-quotation','web','2026-03-29 11:12:47','2026-03-29 11:12:47'),(96,'download-quotation','web','2026-03-29 11:12:47','2026-03-29 11:12:47'),(97,'submit-quotation','web','2026-03-29 11:12:47','2026-03-29 11:12:47'),(98,'accept-quotation','web','2026-03-29 11:12:47','2026-03-29 11:12:47'),(99,'revise-quotation','web','2026-03-29 11:12:48','2026-03-29 11:12:48'),(100,'cancel-quotation','web','2026-03-29 11:12:48','2026-03-29 11:12:48'),(101,'view-any-term-template','web','2026-03-29 11:12:48','2026-03-29 11:12:48'),(102,'view-term-template','web','2026-03-29 11:12:48','2026-03-29 11:12:48'),(103,'create-term-template','web','2026-03-29 11:12:48','2026-03-29 11:12:48'),(104,'update-term-template','web','2026-03-29 11:12:48','2026-03-29 11:12:48'),(105,'delete-term-template','web','2026-03-29 11:12:48','2026-03-29 11:12:48'),(106,'view-any-company','web','2026-03-29 11:12:48','2026-03-29 11:12:48'),(107,'view-company','web','2026-03-29 11:12:48','2026-03-29 11:12:48'),(108,'create-company','web','2026-03-29 11:12:48','2026-03-29 11:12:48'),(109,'update-company','web','2026-03-29 11:12:48','2026-03-29 11:12:48'),(110,'delete-company','web','2026-03-29 11:12:48','2026-03-29 11:12:48'),(111,'view-chart-lab-job','web','2026-03-29 11:12:48','2026-03-29 11:12:48'),(112,'view-any-lab-job','web','2026-03-29 11:12:48','2026-03-29 11:12:48'),(113,'view-lab-job','web','2026-03-29 11:12:48','2026-03-29 11:12:48'),(114,'create-lab-job','web','2026-03-29 11:12:48','2026-03-29 11:12:48'),(115,'update-lab-job','web','2026-03-29 11:12:48','2026-03-29 11:12:48'),(116,'delete-lab-job','web','2026-03-29 11:12:48','2026-03-29 11:12:48'),(117,'preview-lab-job-task-letter','web','2026-03-29 11:12:48','2026-03-29 11:12:48'),(118,'download-lab-job-task-letter','web','2026-03-29 11:12:48','2026-03-29 11:12:48'),(119,'print-lab-job-task-letter','web','2026-03-29 11:12:48','2026-03-29 11:12:48'),(120,'start-lab-job','web','2026-03-29 11:12:48','2026-03-29 11:12:48'),(121,'complete-lab-job-sampling','web','2026-03-29 11:12:48','2026-03-29 11:12:48'),(122,'complete-lab-job-analysis','web','2026-03-29 11:12:48','2026-03-29 11:12:48'),(123,'complete-lab-job-validation','web','2026-03-29 11:12:48','2026-03-29 11:12:48'),(124,'generate-lab-job-report','web','2026-03-29 11:12:48','2026-03-29 11:12:48'),(125,'approve-lab-job-report','web','2026-03-29 11:12:48','2026-03-29 11:12:48'),(126,'send-lab-job-report','web','2026-03-29 11:12:48','2026-03-29 11:12:48'),(127,'abort-lab-job-report','web','2026-03-29 11:12:48','2026-03-29 11:12:48'),(128,'view-chart-test-result','web','2026-03-29 11:12:48','2026-03-29 11:12:48'),(129,'view-any-test-result','web','2026-03-29 11:12:48','2026-03-29 11:12:48'),(130,'view-test-result','web','2026-03-29 11:12:49','2026-03-29 11:12:49'),(131,'create-test-result','web','2026-03-29 11:12:49','2026-03-29 11:12:49'),(132,'update-test-result','web','2026-03-29 11:12:49','2026-03-29 11:12:49'),(133,'delete-test-result','web','2026-03-29 11:12:49','2026-03-29 11:12:49'),(134,'request-validate-test-result','web','2026-03-29 11:12:49','2026-03-29 11:12:49'),(135,'validate-test-result','web','2026-03-29 11:12:49','2026-03-29 11:12:49'),(136,'revision-needed-test-result','web','2026-03-29 11:12:49','2026-03-29 11:12:49'),(137,'reject-test-result','web','2026-03-29 11:12:49','2026-03-29 11:12:49'),(138,'view-any-specialization','web','2026-03-29 11:12:49','2026-03-29 11:12:49'),(139,'view-specialization','web','2026-03-29 11:12:49','2026-03-29 11:12:49'),(140,'create-specialization','web','2026-03-29 11:12:49','2026-03-29 11:12:49'),(141,'update-specialization','web','2026-03-29 11:12:49','2026-03-29 11:12:49'),(142,'delete-specialization','web','2026-03-29 11:12:49','2026-03-29 11:12:49');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personel_specializations`
--

DROP TABLE IF EXISTS `personel_specializations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personel_specializations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `personel_id` bigint unsigned NOT NULL,
  `specialization_id` bigint unsigned NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personel_specializations_personel_id_specialization_id_unique` (`personel_id`,`specialization_id`),
  KEY `fk_personel_specializations_specialization` (`specialization_id`),
  CONSTRAINT `fk_personel_specializations_personel` FOREIGN KEY (`personel_id`) REFERENCES `personels` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_personel_specializations_specialization` FOREIGN KEY (`specialization_id`) REFERENCES `specializations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personel_specializations`
--

LOCK TABLES `personel_specializations` WRITE;
/*!40000 ALTER TABLE `personel_specializations` DISABLE KEYS */;
/*!40000 ALTER TABLE `personel_specializations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personels`
--

DROP TABLE IF EXISTS `personels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personels` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `company_id` bigint unsigned DEFAULT NULL,
  `position_id` bigint unsigned DEFAULT NULL,
  `nip` varchar(50) DEFAULT NULL,
  `fullname` varchar(255) NOT NULL,
  `phone_number` varchar(50) DEFAULT NULL,
  `address` text,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personels_nip_unique` (`nip`),
  KEY `personels_nip_index` (`nip`),
  KEY `personels_fullname_index` (`fullname`),
  KEY `fk_personels_user` (`user_id`),
  KEY `fk_personels_company` (`company_id`),
  KEY `fk_personels_position` (`position_id`),
  CONSTRAINT `fk_personels_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_personels_position` FOREIGN KEY (`position_id`) REFERENCES `positions` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_personels_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personels`
--

LOCK TABLES `personels` WRITE;
/*!40000 ALTER TABLE `personels` DISABLE KEYS */;
INSERT INTO `personels` VALUES (1,NULL,NULL,NULL,'190101JM05','ULFI ATHA TIFALNI YANUAR, ST','87893516556','Jl. Lrg. Garuda VI Kel. Telanai Pura Kec.Telanaipura Kota Jambi - 36122.',NULL,NULL,NULL,NULL),(2,NULL,NULL,NULL,'121001JM01','INDRA FERRI, A.Md','81363429113','Perumhan Grand Nusa Indah Blok B-05. Jl. Sersan Anwar Bay Rt.27 Kel Bagan Pete Kec. Lama Barajo Kota Jambi.',NULL,NULL,NULL,NULL),(3,NULL,NULL,NULL,'200401JM06','REFNI AZMALIA, SE','','',NULL,NULL,NULL,NULL),(4,NULL,NULL,NULL,'160915JL03','BOBY LASMANA, S.Si','81367064414','Jl. Pattimura II No. 03-A Lorong Kelapa Gading RT. 39 Kel. Kenali Besar Kec. Alam Barajo Kota Jambi ',NULL,NULL,NULL,NULL),(5,NULL,NULL,NULL,'200420JL07','MUHAMMAD RIZKI ARDICHA','82173070332','Perumahan Yeyes Lestari III Blok A No. 07 RT. 38 Kel. Kenali Besar Kec. Alam Barajo Kota Jambi ',NULL,NULL,NULL,NULL),(6,NULL,NULL,NULL,'200420JL08','MUHAMMAD REZA','85271784944','Parumpung Koto Baru Simalanggang Payakumbuh Provinsi Sumatera Barat ',NULL,NULL,NULL,NULL),(7,NULL,NULL,NULL,'200818JL09','ALDIN ANANTA KURNIAWAN','82267486026','Jl. Gajah Mada No. 05 RT. 003 RW. 003 Kel. Kampung Olo Kec. Nanggalo Padang Provinsi Sumatera Barat ',NULL,NULL,NULL,NULL),(8,NULL,NULL,NULL,'201010JL10','NUZUL HAFIIZHA','82387514892','Jl. Raya Lundang No.73 Kel. Pasir Talang Barat, Kec. Sungai Pagu Kab. Solok Selatan ',NULL,NULL,NULL,NULL),(9,NULL,NULL,NULL,'210630JL11','TUTI DAMAYANTI, S.Si','85211188580','Jl. Kol. M. Kukuh RT. 16 RW. 4 Paal V Kota Baru Kota Jambi ',NULL,NULL,NULL,NULL),(10,NULL,NULL,NULL,'211021JL12','INDAH AYU SAPUTRI, SP','85378895455','Jl. S. Anwar Bay RT. 001 Kel. Bagan Pete Kec. Alam Barajo Kota Jambi ',NULL,NULL,NULL,NULL),(11,NULL,NULL,NULL,'220618JL14','WIKE OLAVIA','85265260638','Perum Asabri TNI AL, Jl. Ikan Paus No. 14 A, Kel. Nanuaran Nan XX, Kec. Lubeg Kota Padang',NULL,NULL,NULL,NULL),(12,NULL,NULL,NULL,'221228JL16','NISA DAMAYANTI, A.Md','895639402708','Jl. Sumatera Lorong Mendah RT. 27 Kel. Kebun Handil Kec. Jelutung ',NULL,NULL,NULL,NULL),(13,NULL,NULL,NULL,'221208JL17','SILVIA ANA ELI RAHMAWATI, Sp','85223930129','Lingkungan Rejomulyo II Desa Perdamean Kec. Rantau selatan',NULL,NULL,NULL,NULL),(14,NULL,NULL,NULL,'230515JL18','NANDA SALMA RIHADATUL AISY, S.Si','82371039002','Jl. Ibrahim, Perumahan Permata Citra C-05 Lorong Radio Kel. Rawasari Kec. Alam Barajo Kota Jambi ',NULL,NULL,NULL,NULL),(15,NULL,NULL,NULL,'230522JL19','AVRILLIA AISYA SELVIRA','81277822153','Jl. Taman Sari Perum. Permata sari Regency No. 9, Rumbai, Pekanbaru, Riau ',NULL,NULL,NULL,NULL),(16,NULL,NULL,NULL,'230522JL20','DIMAS RAHMAD HIDAYAT, A.Md, Si','83151356336','Jorong V Kampung, Kecamatan Kamang Magek, Kabupaten Agam Provinsi Sumatera Barat',NULL,NULL,NULL,NULL),(17,NULL,NULL,NULL,'240418JL25','ASSABRY, AM.d, S.Si','82284928520','Padang Kandang Korong Balai Satu Lubuk Pandan Provinsi Sumatera Barat ',NULL,NULL,NULL,NULL),(18,NULL,NULL,NULL,'240419JL26','MUHAMMAD FAUZI','82182157046','Jl. Kebon Daging, No. 33 RT. 12 Mayang Mangurai Kota Jambi Provinsi Jambi ',NULL,NULL,NULL,NULL),(19,NULL,NULL,NULL,'240815JL28','AYU SALSABILA','81365975872','Gg. Nusa Indah I No. 59 Pitameh Tanjung Sabar Lubuk Begalung Padang, Provinsi Sumatera Barat',NULL,NULL,NULL,NULL),(20,NULL,NULL,NULL,'240815JL29','GILANG DWITAMA GUSTI','83140762140','Kampung Jua No. 024 RT. 001/ RW. 003, Kec. Lubuk Begalung, Kota Padang Provinsi Sumatera Barat ',NULL,NULL,NULL,NULL),(21,NULL,NULL,NULL,'240826JL30','MAI INDRA YENI','85264851038','Jl. Rimbo Tarok RT. 003 RW. 009 Kec. Kuranji Kota Padang Sumatera Barat',NULL,NULL,NULL,NULL),(22,NULL,NULL,NULL,'240905JL32','RAHMAD HIDAYAT','81364975890','Jl. H. A Somad Perumahan Yeyes Lestari 3 RT. 38 Kel. Kenali Besar Kec. Alam Barajo Kota Jambi Provinsi Jambi  ',NULL,NULL,NULL,NULL),(23,NULL,NULL,NULL,'240927JL33','MILDA NAILIL FADHILAH','83191019252','Jl. Bahari No. 48, Ulak Karang Selatan, Kecamatan Padang Utara, Kota Padang',NULL,NULL,NULL,NULL),(24,NULL,NULL,NULL,'241008JL35','AISYAH DEFORT ADESKA','89946923331','Jl. J. Dr. M. Hatta, Kecamatan Pauh, Kota Padang',NULL,NULL,NULL,NULL),(25,NULL,NULL,NULL,'241029JL36','MUHAMMAD HABIB FADILLAH PUTRA','','',NULL,NULL,NULL,NULL),(26,NULL,NULL,NULL,'241223JL38','LUTFI AZMI','895603722970','Korong Gadang, Kuranji, Kota Padang Provinsi Sumatra Barat',NULL,NULL,NULL,NULL),(27,NULL,NULL,NULL,'241223JL39','SYAHWA HANIFAH','','',NULL,NULL,NULL,NULL),(28,NULL,NULL,NULL,'250904JL40','WIDYA FUJI ASTUTI, S.E','','',NULL,NULL,NULL,NULL),(29,1,1,1,'01.01.01','superadmin','','',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `personels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `positions`
--

DROP TABLE IF EXISTS `positions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `positions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `positions_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `positions`
--

LOCK TABLES `positions` WRITE;
/*!40000 ALTER TABLE `positions` DISABLE KEYS */;
INSERT INTO `positions` VALUES (1,'Administrator',NULL,NULL,NULL,NULL,NULL),(2,'Ppc',NULL,NULL,NULL,NULL,NULL),(3,'Analis Laboratorium',NULL,NULL,NULL,NULL,NULL),(4,'Kepala Ppc',NULL,NULL,NULL,NULL,NULL),(5,'Kepala Laboratorium',NULL,NULL,NULL,NULL,NULL),(6,'Manajer Laboratorium',NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `positions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `provinces`
--

DROP TABLE IF EXISTS `provinces`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `provinces` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `provinces_name_index` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `provinces`
--

LOCK TABLES `provinces` WRITE;
/*!40000 ALTER TABLE `provinces` DISABLE KEYS */;
INSERT INTO `provinces` VALUES (11,'ACEH',NULL,NULL,NULL,NULL),(12,'SUMATERA UTARA',NULL,NULL,NULL,NULL),(13,'SUMATERA BARAT',NULL,NULL,NULL,NULL),(14,'RIAU',NULL,NULL,NULL,NULL),(15,'JAMBI',NULL,NULL,NULL,NULL),(16,'SUMATERA SELATAN',NULL,NULL,NULL,NULL),(17,'BENGKULU',NULL,NULL,NULL,NULL),(18,'LAMPUNG',NULL,NULL,NULL,NULL),(19,'KEPULAUAN BANGKA BELITUNG',NULL,NULL,NULL,NULL),(21,'KEPULAUAN RIAU',NULL,NULL,NULL,NULL),(31,'DKI JAKARTA',NULL,NULL,NULL,NULL),(32,'JAWA BARAT',NULL,NULL,NULL,NULL),(33,'JAWA TENGAH',NULL,NULL,NULL,NULL),(34,'DI YOGYAKARTA',NULL,NULL,NULL,NULL),(35,'JAWA TIMUR',NULL,NULL,NULL,NULL),(36,'BANTEN',NULL,NULL,NULL,NULL),(51,'BALI',NULL,NULL,NULL,NULL),(52,'NUSA TENGGARA BARAT',NULL,NULL,NULL,NULL),(53,'NUSA TENGGARA TIMUR',NULL,NULL,NULL,NULL),(61,'KALIMANTAN BARAT',NULL,NULL,NULL,NULL),(62,'KALIMANTAN TENGAH',NULL,NULL,NULL,NULL),(63,'KALIMANTAN SELATAN',NULL,NULL,NULL,NULL),(64,'KALIMANTAN TIMUR',NULL,NULL,NULL,NULL),(65,'KALIMANTAN UTARA',NULL,NULL,NULL,NULL),(71,'SULAWESI UTARA',NULL,NULL,NULL,NULL),(72,'SULAWESI TENGAH',NULL,NULL,NULL,NULL),(73,'SULAWESI SELATAN',NULL,NULL,NULL,NULL),(74,'SULAWESI TENGGARA',NULL,NULL,NULL,NULL),(75,'GORONTALO',NULL,NULL,NULL,NULL),(76,'SULAWESI BARAT',NULL,NULL,NULL,NULL),(81,'MALUKU',NULL,NULL,NULL,NULL),(82,'MALUKU UTARA',NULL,NULL,NULL,NULL),(91,'PAPUA BARAT',NULL,NULL,NULL,NULL),(94,'PAPUA',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `provinces` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quotation_items`
--

DROP TABLE IF EXISTS `quotation_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `quotation_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `quotation_id` bigint unsigned NOT NULL,
  `test_package_id` bigint unsigned DEFAULT NULL,
  `regulation_id` bigint unsigned DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  `regulation_name` varchar(255) DEFAULT NULL,
  `quantity` int NOT NULL,
  `unit` varchar(50) NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `location` varchar(100) DEFAULT NULL,
  `group` enum('A','B','C') NOT NULL DEFAULT 'A',
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `quotation_items_group_index` (`group`),
  KEY `fk_quotation_items_quotations` (`quotation_id`),
  KEY `fk_quotation_items_test_packages` (`test_package_id`),
  KEY `fk_quotation_items_regulations` (`regulation_id`),
  CONSTRAINT `fk_quotation_items_quotations` FOREIGN KEY (`quotation_id`) REFERENCES `quotations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_quotation_items_regulations` FOREIGN KEY (`regulation_id`) REFERENCES `regulations` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_quotation_items_test_packages` FOREIGN KEY (`test_package_id`) REFERENCES `test_packages` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quotation_items`
--

LOCK TABLES `quotation_items` WRITE;
/*!40000 ALTER TABLE `quotation_items` DISABLE KEYS */;
INSERT INTO `quotation_items` VALUES (1,1,1,1,'Udara Ambient','PPRI No. 22 Thn 2021 Lamp VII',1,'Titik',0.00,NULL,'A','superadmin',NULL,'2026-03-29 11:21:50','2026-03-29 11:21:50'),(2,2,7,4,'Emisi Sumber Bergerak','KepmenLH No. 49 Tahun 1996 Lampiran IV',1,'Titik',0.00,NULL,'A','superadmin','superadmin','2026-03-30 16:45:17','2026-03-30 16:45:54'),(3,2,2,NULL,'Udara Ambient',NULL,1,'Titik',0.00,NULL,'A','superadmin',NULL,'2026-03-30 16:46:22','2026-03-30 16:46:22'),(4,2,6,4,'Getaran','KepmenLH No. 49 Tahun 1996 Lampiran IV',1,'Titik',0.00,NULL,'A','superadmin',NULL,'2026-03-30 16:46:49','2026-03-30 16:46:49');
/*!40000 ALTER TABLE `quotation_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quotations`
--

DROP TABLE IF EXISTS `quotations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `quotations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `request_id` bigint unsigned DEFAULT NULL,
  `customer_id` bigint unsigned DEFAULT NULL,
  `personel_id` bigint unsigned DEFAULT NULL,
  `quotation_name` varchar(255) NOT NULL,
  `quotation_number` varchar(50) NOT NULL,
  `quotation_date` date NOT NULL,
  `valid_until_date` date NOT NULL,
  `discount_percentage` decimal(5,2) NOT NULL DEFAULT '0.00',
  `ppn_percentage` decimal(5,2) NOT NULL DEFAULT '0.00',
  `pph_percentage` decimal(5,2) NOT NULL DEFAULT '0.00',
  `total_amount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `additional_description` text,
  `status` tinyint NOT NULL DEFAULT '1',
  `approved_by_personel_id` bigint unsigned DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `quotations_quotation_number_unique` (`quotation_number`),
  KEY `quotations_quotation_number_index` (`quotation_number`),
  KEY `quotations_status_index` (`status`),
  KEY `fk_quotations_requests` (`request_id`),
  KEY `fk_quotations_customer` (`customer_id`),
  KEY `fk_quotations_personel` (`personel_id`),
  KEY `fk_quotations_approved_by_personel` (`approved_by_personel_id`),
  CONSTRAINT `fk_quotations_approved_by_personel` FOREIGN KEY (`approved_by_personel_id`) REFERENCES `personels` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_quotations_customer` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_quotations_personel` FOREIGN KEY (`personel_id`) REFERENCES `personels` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_quotations_requests` FOREIGN KEY (`request_id`) REFERENCES `requests` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quotations`
--

LOCK TABLES `quotations` WRITE;
/*!40000 ALTER TABLE `quotations` DISABLE KEYS */;
INSERT INTO `quotations` VALUES (1,NULL,1,29,'Penyaringan Air Limbah','001/Jalint-Lab/III/2026','2026-03-29','2026-04-28',0.00,11.00,0.00,0.00,'<p></p>',1,NULL,NULL,'superadmin',NULL,'2026-03-29 11:21:29','2026-03-29 11:21:29'),(2,NULL,1,29,'Penyaringan Air Limbah','002/Jalint-Lab/III/2026','2026-03-30','2026-04-29',0.00,11.00,0.00,0.00,'<p></p>',1,NULL,NULL,'superadmin',NULL,'2026-03-30 16:43:23','2026-03-30 16:43:23');
/*!40000 ALTER TABLE `quotations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `regulation_types`
--

DROP TABLE IF EXISTS `regulation_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `regulation_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(15) NOT NULL,
  `long_name` varchar(255) NOT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `regulation_types_name_unique` (`name`),
  UNIQUE KEY `regulation_types_long_name_unique` (`long_name`),
  KEY `regulation_types_name_index` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `regulation_types`
--

LOCK TABLES `regulation_types` WRITE;
/*!40000 ALTER TABLE `regulation_types` DISABLE KEYS */;
INSERT INTO `regulation_types` VALUES (1,'PPRI','Peraturan Pemerintah Republik Indonesia',NULL,NULL,NULL,NULL),(2,'KepmenLH','Keputusan Menteri Negara Lingkungan Hidup',NULL,NULL,NULL,NULL),(3,'PermenLH','Peraturan Menteri Negara Lingkungan Hidup',NULL,NULL,NULL,NULL),(4,'PermenLHK','Peraturan Menteri Lingkungan Hidup dan Kehutanan',NULL,NULL,NULL,NULL),(5,'Permenkes','Peraturan Menteri Kesehatan',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `regulation_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `regulations`
--

DROP TABLE IF EXISTS `regulations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `regulations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `regulation_type_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `long_name` text,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `regulations_name_unique` (`name`),
  KEY `regulations_name_index` (`name`),
  KEY `regulations_is_active_index` (`is_active`),
  KEY `fk_regulations_regulation_type` (`regulation_type_id`),
  CONSTRAINT `fk_regulations_regulation_type` FOREIGN KEY (`regulation_type_id`) REFERENCES `regulation_types` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `regulations`
--

LOCK TABLES `regulations` WRITE;
/*!40000 ALTER TABLE `regulations` DISABLE KEYS */;
INSERT INTO `regulations` VALUES (1,1,'PPRI No. 22 Thn 2021 Lamp VII','PPRI No. 22 Thn 2021 Lamp VII',1,NULL,NULL,NULL,NULL),(2,2,'KepmenLH No. 50 Tahun 1996 Lampiran A','KepmenLH No. 50 Tahun 1996 Lampiran A',1,NULL,NULL,NULL,NULL),(3,2,'KepmenLH No. 48 Tahun 1996 Lampiran I','KepmenLH No. 48 Tahun 1996 Lampiran I',1,NULL,NULL,NULL,NULL),(4,2,'KepmenLH No. 49 Tahun 1996 Lampiran IV','KepmenLH No. 49 Tahun 1996 Lampiran IV',1,NULL,NULL,NULL,NULL),(5,2,'KepmenLH No. 13 Tahun 1995 Lampiran V-B','Keputusan Menteri Negara Lingkungan Hidup No. 13 Tahun 1995 Lampiran V-B',1,NULL,NULL,NULL,NULL),(6,3,'PermenLH 07/2007 Lamp I','Peraturan Menteri Negara Lingkungan Hidup Nomor 07 Tahun 2007 Tentang Baku MUtu Emisi Sumber TIdak Bergerak Bagi Ketel Uap Lampiran I Baku Mutu Emisi Sumber Tidak Bergerak Bagi Ketel Uap Yang Menggunakan Bahan Bakar Biomassa Berupa Serabut Dan/Atau Cangkang',1,NULL,NULL,NULL,NULL),(7,3,'PermenLH 07/2007 Lamp III-a','Peraturan Menteri Negara Lingkungan Hidup Nomor 07 Tahun 2007 Tentang Baku MUtu Emisi Sumber TIdak Bergerak Bagi Ketel Uap Lampiran III Baku Mutu Emisi Sumber Tidak Bergerak Bagi Ketel Uap Yang Menggunakan Bahan Bakar Biomassa Selain yang DImaksud Pada Huruf a Dan Hruf b Pasal 3 Ayat (1) ',1,NULL,NULL,NULL,NULL),(8,3,'PermenLH 07/2007 Lamp III-b','Peraturan Menteri Negara Lingkungan Hidup Nomor 07 Tahun 2007 Tentang Baku Mutu Emisi Sumber TIdak Bergerak Bagi Ketel Uap Lampiran III Baku Mutu Emisi Sumber Tidak Bergerak Bagi Ketel Uap Yang Menggunakan Bahan Bakar Batubara',1,NULL,NULL,NULL,NULL),(9,3,'PermenLH 07/2007 Lamp III-c','Peraturan Menteri Negara Lingkungan Hidup Nomor 07 Tahun 2007 Tentang Baku Mutu Emisi Sumber TIdak Bergerak Bagi Ketel Uap Lampiran III Baku Mutu Emisi Sumber Tidak Bergerak Bagi Ketel Uap Yang Menggunakan Bahan Bakar Batubara',1,NULL,NULL,NULL,NULL),(10,3,'PermenLH 07/2007 (Lamp III - Gas)','Peraturan Menteri Negara Lingkungan Hidup Nomor 07 Tahun 2007 Tentang Baku Mutu Emisi Sumber TIdak Bergerak Bagi Ketel Uap Lampiran III Baku Mutu Emisi Sumber Tidak Bergerak Bagi Ketel Uap Yang Menggunakan Bahan Bakar Gas',1,NULL,NULL,NULL,NULL),(11,1,'PPRI No. 22 Thn 2021 Lamp VI- Tabel I','PPRI No. 22 Thn 2021 Lamp VI- Tabel I',1,NULL,NULL,NULL,NULL),(12,1,'PPRI No. 22 Thn 2021 Lamp VI- Tabel II','PPRI No. 22 Thn 2021 Lamp VI- Tabel II',1,NULL,NULL,NULL,NULL),(13,4,'PermenLHK P.68/2016','Peraturan Menteri Lingkungan Hidup dan Kehutanan No P.68/MENLHK/SETJEN/KUM.1/8/2016 Tahun 2016',1,NULL,NULL,NULL,NULL),(14,3,'PermenLH 11/2025 Lamp I-A.1','Peraturan Menteri Lingkungan Hidup/Badan Pengendalian Lingkungan Hidup Republik Indonesia Nomor 11 Tahun 2025 Tentang Baku Mutu Air Limbah Domestik dan Standar Teknologi Pengolahan Air Limbah Domestik Lampiran I A.1',1,NULL,NULL,NULL,NULL),(15,3,'PermenLH 11/2025 Lamp I-A.2','Peraturan Menteri Lingkungan Hidup/Badan Pengendalian Lingkungan Hidup Republik Indonesia Nomor 11 Tahun 2025 Tentang Baku Mutu Air Limbah Domestik dan Standar Teknologi Pengolahan Air Limbah Domestik Lampiran I A.2',1,NULL,NULL,NULL,NULL),(16,3,'PermenLH 11/2025 Lamp I-A.3a','Peraturan Menteri Lingkungan Hidup/Badan Pengendalian Lingkungan Hidup Republik Indonesia Nomor 11 Tahun 2025 Tentang Baku Mutu Air Limbah Domestik dan Standar Teknologi Pengolahan Air Limbah Domestik Lampiran I A.3 a',1,NULL,NULL,NULL,NULL),(17,3,'PermenLH 11/2025 Lamp I-A.3b','Peraturan Menteri Lingkungan Hidup/Badan Pengendalian Lingkungan Hidup Republik Indonesia Nomor 11 Tahun 2025 Tentang Baku Mutu Air Limbah Domestik dan Standar Teknologi Pengolahan Air Limbah Domestik Lampiran I A.3 b',1,NULL,NULL,NULL,NULL),(18,3,'PermenLH 11/2025 Lamp I-B.1','Peraturan Menteri Lingkungan Hidup/Badan Pengendalian Lingkungan Hidup Republik Indonesia Nomor 11 Tahun 2025 Tentang Baku Mutu Air Limbah Domestik dan Standar Teknologi Pengolahan Air Limbah Domestik Lampiran I B.1 ',1,NULL,NULL,NULL,NULL),(19,3,'PermenLH 11/2025 Lamp I-B.2','Peraturan Menteri Lingkungan Hidup/Badan Pengendalian Lingkungan Hidup Republik Indonesia Nomor 11 Tahun 2025 Tentang Baku Mutu Air Limbah Domestik dan Standar Teknologi Pengolahan Air Limbah Domestik Lampiran I B.2',1,NULL,NULL,NULL,NULL),(20,3,'PermenLH 05/2014 Lamp III','PERATURAN MENTERI LINGKUNGAN HIDUP REPUBLIK INDONESIA NOMOR 5 TAHUN 2014 Lampiran III',1,NULL,NULL,NULL,NULL),(21,3,'PermenLH 05/2014 Lamp IV','PERATURAN MENTERI LINGKUNGAN HIDUP REPUBLIK INDONESIA NOMOR 5 TAHUN 2014 Lampiran IV',1,NULL,NULL,NULL,NULL),(22,3,'PermenLH 05/2014 Lamp VII','PERATURAN MENTERI LINGKUNGAN HIDUP REPUBLIK INDONESIA NOMOR 5 TAHUN 2014 Lampiran VII',1,NULL,NULL,NULL,NULL),(23,3,'PermenLH 05/2014 Lamp XLIV-B','PERATURAN MENTERI LINGKUNGAN HIDUP REPUBLIK INDONESIA NOMOR 5 TAHUN 2014 Lampiran XLIV B',1,NULL,NULL,NULL,NULL),(24,3,'PermenLH 05/2014 Lamp XLVII','PERATURAN MENTERI LINGKUNGAN HIDUP REPUBLIK INDONESIA NOMOR 5 TAHUN 2014 Lampiran XLVII ',1,NULL,NULL,NULL,NULL),(25,2,'KepmenLH 113/2003 Lamp I','Keputusan Menteri Negara Lingkungan Hidup No. 113 Tahun 2003 Tentang Baku Mutu Air Limbah Bagi Usaha dan atau Kegiatan Pertambangan Batu Bara (Lampiran I: Baku Mutu Air Limbah Kegiatan Penambangan Batu Bara)',1,NULL,NULL,NULL,NULL),(26,2,'KepmenLH 28/2003 (Sawit)','Keputusan Menteri Lingkungan Hidup No. 28 Tahun 2003 Tentang Pedoman Teknis Pengkajian Pemanfaatan Air Limbah dari Industri Minyak Sawit Pada Tanah di Perkebunan Kelapa Sawit',1,NULL,NULL,NULL,NULL),(27,5,'Permenkes 07/2019 Tab 3-4','Peraturan Menteri Kesehatan RI  No. 07 Tahun 2019 Tentang Kesehatan Lingkungan Rumah Sakit BAB II Standar Baku Mutu Kesehatan Lingkungan dan Persyaratan Kesehatan Tabel 3 & 4 ',1,NULL,NULL,NULL,NULL),(28,5,'Permenkes 02/2023 Tab 3','Peraturan Menteri Kesehatan Republik Indonesia No. 02 Tahun 2023 Tentang Pelaksanaan Peraturan Pemerintah Nomor 66 Tahun 2014 Tentang Kesehatan Lingkungan Bab II A Bagian 2.a, Tabel 3 : Standar Baku Mutu Kesehatan Lingkungan, Parameter Air Untuk Keperluan Higiene dan Sanitasi)',1,NULL,NULL,NULL,NULL),(29,5,'Permenkes 02/2023 Tab 4-6','Peraturan Menteri Kesehatan Republik Indonesia No. 02 Tahun 2023 Tentang Pelaksanaan Peraturan Pemerintah Nomor 66 Tahun 2014 Tentang Kesehatan Lingkungan Bab II A Bagian 2.a, Tabel 4-6 ',1,NULL,NULL,NULL,NULL),(30,5,'Permenkes 02/2023 Tab 7-9','Peraturan Menteri Kesehatan Republik Indonesia No. 02 Tahun 2023 Tentang Pelaksanaan Peraturan Pemerintah Nomor 66 Tahun 2014 Tentang Kesehatan Lingkungan Bab II A Bagian 4.a, Tabel 7-9',1,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `regulations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `request_items`
--

DROP TABLE IF EXISTS `request_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `request_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `request_id` bigint unsigned NOT NULL,
  `test_package_id` bigint unsigned NOT NULL,
  `description` varchar(255) NOT NULL,
  `regulation_name` varchar(255) NOT NULL,
  `quantity` int NOT NULL,
  `unit` varchar(255) NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `location` varchar(255) NOT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `request_items`
--

LOCK TABLES `request_items` WRITE;
/*!40000 ALTER TABLE `request_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `request_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `requests`
--

DROP TABLE IF EXISTS `requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `requests` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint unsigned NOT NULL,
  `lab_job_id` bigint unsigned NOT NULL,
  `request_number` varchar(50) NOT NULL,
  `request_name` varchar(255) NOT NULL,
  `request_date` date NOT NULL,
  `testing_activity_type` varchar(50) DEFAULT NULL,
  `request_notes` text,
  `request_status` enum('submitted_online','received_by_admin','ready_admin_review','pending_admin_clarification','ready_technical_review','pending_technical_clarification','rejected_technical','ready_for_quotation','quotation_sent','quotation_accepted','quotation_rejected','cancelled_by_customer','cancelled_by_lab','closed') NOT NULL DEFAULT 'submitted_online',
  `status_update_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `approved_by_user_id` varchar(255) DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `ppn_percentage` decimal(5,2) NOT NULL DEFAULT '0.00',
  `pph_percentage` decimal(5,2) NOT NULL DEFAULT '0.00',
  `total_amount` decimal(15,2) NOT NULL,
  `term_agreements` text,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `requests_request_number_unique` (`request_number`),
  KEY `fk_requests_customer` (`customer_id`),
  KEY `fk_requests_lab_job` (`lab_job_id`),
  CONSTRAINT `fk_requests_customer` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_requests_lab_job` FOREIGN KEY (`lab_job_id`) REFERENCES `lab_jobs` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `requests`
--

LOCK TABLES `requests` WRITE;
/*!40000 ALTER TABLE `requests` DISABLE KEYS */;
/*!40000 ALTER TABLE `requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1),(8,1),(9,1),(10,1),(11,1),(12,1),(13,1),(14,1),(15,1),(16,1),(17,1),(18,1),(19,1),(20,1),(21,1),(22,1),(23,1),(24,1),(25,1),(26,1),(27,1),(28,1),(29,1),(30,1),(31,1),(32,1),(33,1),(34,1),(35,1),(36,1),(37,1),(38,1),(39,1),(40,1),(41,1),(42,1),(43,1),(44,1),(45,1),(46,1),(47,1),(48,1),(49,1),(50,1),(51,1),(52,1),(53,1),(54,1),(55,1),(56,1),(57,1),(58,1),(59,1),(60,1),(61,1),(62,1),(63,1),(64,1),(65,1),(66,1),(67,1),(68,1),(69,1),(70,1),(71,1),(72,1),(73,1),(74,1),(75,1),(76,1),(77,1),(78,1),(79,1),(80,1),(81,1),(82,1),(83,1),(84,1),(85,1),(86,1),(87,1),(88,1),(89,1),(90,1),(91,1),(92,1),(93,1),(94,1),(95,1),(96,1),(97,1),(98,1),(99,1),(100,1),(101,1),(102,1),(103,1),(104,1),(105,1),(106,1),(107,1),(108,1),(109,1),(110,1),(111,1),(112,1),(113,1),(114,1),(115,1),(116,1),(117,1),(118,1),(119,1),(120,1),(121,1),(122,1),(123,1),(124,1),(125,1),(126,1),(127,1),(128,1),(129,1),(130,1),(131,1),(132,1),(133,1),(134,1),(135,1),(136,1),(137,1),(138,1),(139,1),(140,1),(141,1),(142,1),(1,2),(2,2),(3,2),(4,2),(5,2),(6,2),(7,2),(8,2),(9,2),(10,2),(11,2),(12,2),(13,2),(14,2),(15,2),(16,2),(17,2),(18,2),(19,2),(20,2),(21,2),(22,2),(23,2),(24,2),(25,2),(26,2),(27,2),(28,2),(29,2),(30,2),(31,2),(32,2),(33,2),(34,2),(35,2),(36,2),(37,2),(38,2),(39,2),(40,2),(41,2),(42,2),(43,2),(44,2),(45,2),(46,2),(47,2),(48,2),(49,2),(50,2),(51,2),(52,2),(53,2),(54,2),(55,2),(56,2),(57,2),(58,2),(59,2),(60,2),(61,2),(62,2),(63,2),(64,2),(65,2),(66,2),(67,2),(68,2),(69,2),(70,2),(71,2),(72,2),(73,2),(74,2),(75,2),(76,2),(77,2),(78,2),(79,2),(80,2),(81,2),(82,2),(83,2),(84,2),(85,2),(86,2),(87,2),(88,2),(89,2),(90,2),(91,2),(92,2),(93,2),(94,2),(95,2),(96,2),(97,2),(98,2),(99,2),(100,2),(101,2),(102,2),(103,2),(104,2),(105,2),(106,2),(107,2),(108,2),(109,2),(110,2),(111,2),(112,2),(113,2),(114,2),(115,2),(116,2),(117,2),(118,2),(119,2),(120,2),(121,2),(122,2),(123,2),(124,2),(125,2),(126,2),(127,2),(128,2),(129,2),(130,2),(131,2),(132,2),(133,2),(134,2),(135,2),(136,2),(137,2),(138,2),(139,2),(140,2),(141,2),(142,2),(1,3),(2,3),(3,3),(4,3),(5,3),(6,3),(7,3),(8,3),(9,3),(10,3),(11,3),(12,3),(13,3),(14,3),(15,3),(16,3),(17,3),(18,3),(19,3),(20,3),(21,3),(22,3),(23,3),(24,3),(25,3),(26,3),(27,3),(28,3),(29,3),(30,3),(31,3),(32,3),(33,3),(34,3),(35,3),(36,3),(37,3),(38,3),(39,3),(40,3),(41,3),(42,3),(43,3),(44,3),(45,3),(46,3),(47,3),(48,3),(49,3),(50,3),(51,3),(52,3),(53,3),(54,3),(55,3),(56,3),(57,3),(58,3),(59,3),(60,3),(61,3),(62,3),(63,3),(64,3),(65,3),(66,3),(67,3),(68,3),(69,3),(70,3),(71,3),(72,3),(73,3),(74,3),(75,3),(76,3),(77,3),(78,3),(79,3),(80,3),(81,3),(82,3),(83,3),(84,3),(85,3),(86,3),(87,3),(88,3),(89,3),(90,3),(91,3),(92,3),(93,3),(94,3),(95,3),(96,3),(97,3),(98,3),(99,3),(100,3),(101,3),(102,3),(103,3),(104,3),(105,3),(106,3),(107,3),(108,3),(109,3),(110,3),(111,3),(112,3),(113,3),(114,3),(115,3),(116,3),(117,3),(118,3),(119,3),(120,3),(121,3),(122,3),(123,3),(124,3),(125,3),(126,3),(127,3),(128,3),(129,3),(130,3),(131,3),(132,3),(133,3),(134,3),(135,3),(136,3),(137,3),(138,3),(139,3),(140,3),(141,3),(142,3),(1,4),(2,4),(3,4),(4,4),(5,4),(6,4),(7,4),(8,4),(9,4),(10,4),(11,4),(12,4),(13,4),(14,4),(15,4),(16,4),(17,4),(18,4),(19,4),(20,4),(21,4),(22,4),(23,4),(24,4),(25,4),(26,4),(27,4),(28,4),(29,4),(30,4),(31,4),(32,4),(33,4),(34,4),(35,4),(36,4),(37,4),(38,4),(39,4),(40,4),(41,4),(42,4),(43,4),(44,4),(45,4),(46,4),(47,4),(48,4),(49,4),(50,4),(51,4),(52,4),(53,4),(54,4),(55,4),(56,4),(57,4),(58,4),(59,4),(60,4),(61,4),(62,4),(63,4),(64,4),(65,4),(66,4),(67,4),(68,4),(69,4),(70,4),(71,4),(72,4),(73,4),(74,4),(75,4),(76,4),(77,4),(78,4),(79,4),(80,4),(81,4),(82,4),(83,4),(84,4),(85,4),(86,4),(87,4),(88,4),(89,4),(90,4),(91,4),(92,4),(93,4),(94,4),(95,4),(96,4),(97,4),(98,4),(99,4),(100,4),(101,4),(102,4),(103,4),(104,4),(105,4),(106,4),(107,4),(108,4),(109,4),(110,4),(111,4),(112,4),(113,4),(114,4),(115,4),(116,4),(117,4),(118,4),(119,4),(120,4),(121,4),(122,4),(123,4),(124,4),(125,4),(126,4),(127,4),(128,4),(129,4),(130,4),(131,4),(132,4),(133,4),(134,4),(135,4),(136,4),(137,4),(138,4),(139,4),(140,4),(141,4),(142,4),(1,5),(2,5),(3,5),(4,5),(5,5),(6,5),(7,5),(8,5),(9,5),(10,5),(11,5),(12,5),(13,5),(14,5),(15,5),(16,5),(17,5),(18,5),(19,5),(20,5),(21,5),(22,5),(23,5),(24,5),(25,5),(26,5),(27,5),(28,5),(29,5),(30,5),(31,5),(32,5),(33,5),(34,5),(35,5),(36,5),(37,5),(38,5),(39,5),(40,5),(41,5),(42,5),(43,5),(44,5),(45,5),(46,5),(47,5),(48,5),(49,5),(50,5),(51,5),(52,5),(53,5),(54,5),(55,5),(56,5),(57,5),(58,5),(59,5),(60,5),(61,5),(62,5),(63,5),(64,5),(65,5),(66,5),(67,5),(68,5),(69,5),(70,5),(71,5),(72,5),(73,5),(74,5),(75,5),(76,5),(77,5),(78,5),(79,5),(80,5),(81,5),(82,5),(83,5),(84,5),(85,5),(86,5),(87,5),(88,5),(89,5),(90,5),(91,5),(92,5),(93,5),(94,5),(95,5),(96,5),(97,5),(98,5),(99,5),(100,5),(101,5),(102,5),(103,5),(104,5),(105,5),(106,5),(107,5),(108,5),(109,5),(110,5),(111,5),(112,5),(113,5),(114,5),(115,5),(116,5),(117,5),(118,5),(119,5),(120,5),(121,5),(122,5),(123,5),(124,5),(125,5),(126,5),(127,5),(128,5),(129,5),(130,5),(131,5),(132,5),(133,5),(134,5),(135,5),(136,5),(137,5),(138,5),(139,5),(140,5),(141,5),(142,5),(1,6),(2,6),(3,6),(4,6),(5,6),(6,6),(7,6),(8,6),(9,6),(10,6),(11,6),(12,6),(13,6),(14,6),(15,6),(16,6),(17,6),(18,6),(19,6),(20,6),(21,6),(22,6),(23,6),(24,6),(25,6),(26,6),(27,6),(28,6),(29,6),(30,6),(31,6),(32,6),(33,6),(34,6),(35,6),(36,6),(37,6),(38,6),(39,6),(40,6),(41,6),(42,6),(43,6),(44,6),(45,6),(46,6),(47,6),(48,6),(49,6),(50,6),(51,6),(52,6),(53,6),(54,6),(55,6),(56,6),(57,6),(58,6),(59,6),(60,6),(61,6),(62,6),(63,6),(64,6),(65,6),(66,6),(67,6),(68,6),(69,6),(70,6),(71,6),(72,6),(73,6),(74,6),(75,6),(76,6),(77,6),(78,6),(79,6),(80,6),(81,6),(82,6),(83,6),(84,6),(85,6),(86,6),(87,6),(88,6),(89,6),(90,6),(91,6),(92,6),(93,6),(94,6),(95,6),(96,6),(97,6),(98,6),(99,6),(100,6),(101,6),(102,6),(103,6),(104,6),(105,6),(106,6),(107,6),(108,6),(109,6),(110,6),(111,6),(112,6),(113,6),(114,6),(115,6),(116,6),(117,6),(118,6),(119,6),(120,6),(121,6),(122,6),(123,6),(124,6),(125,6),(126,6),(127,6),(128,6),(129,6),(130,6),(131,6),(132,6),(133,6),(134,6),(135,6),(136,6),(137,6),(138,6),(139,6),(140,6),(141,6),(142,6),(1,7),(2,7),(3,7),(4,7),(5,7),(6,7),(7,7),(8,7),(9,7),(10,7),(11,7),(12,7),(13,7),(14,7),(15,7),(16,7),(17,7),(18,7),(19,7),(20,7),(21,7),(22,7),(23,7),(24,7),(25,7),(26,7),(27,7),(28,7),(29,7),(30,7),(31,7),(32,7),(33,7),(34,7),(35,7),(36,7),(37,7),(38,7),(39,7),(40,7),(41,7),(42,7),(43,7),(44,7),(45,7),(46,7),(47,7),(48,7),(49,7),(50,7),(51,7),(52,7),(53,7),(54,7),(55,7),(56,7),(57,7),(58,7),(59,7),(60,7),(61,7),(62,7),(63,7),(64,7),(65,7),(66,7),(67,7),(68,7),(69,7),(70,7),(71,7),(72,7),(73,7),(74,7),(75,7),(76,7),(77,7),(78,7),(79,7),(80,7),(81,7),(82,7),(83,7),(84,7),(85,7),(86,7),(87,7),(88,7),(89,7),(90,7),(91,7),(92,7),(93,7),(94,7),(95,7),(96,7),(97,7),(98,7),(99,7),(100,7),(101,7),(102,7),(103,7),(104,7),(105,7),(106,7),(107,7),(108,7),(109,7),(110,7),(111,7),(112,7),(113,7),(114,7),(115,7),(116,7),(117,7),(118,7),(119,7),(120,7),(121,7),(122,7),(123,7),(124,7),(125,7),(126,7),(127,7),(128,7),(129,7),(130,7),(131,7),(132,7),(133,7),(134,7),(135,7),(136,7),(137,7),(138,7),(139,7),(140,7),(141,7),(142,7);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'superadmin','web','2026-03-29 11:12:49','2026-03-29 11:12:49'),(2,'customer','web','2026-03-29 11:12:49','2026-03-29 11:12:49'),(3,'admin','web','2026-03-29 11:12:49','2026-03-29 11:12:49'),(4,'sampling technician','web','2026-03-29 11:12:49','2026-03-29 11:12:49'),(5,'analyst','web','2026-03-29 11:12:49','2026-03-29 11:12:49'),(6,'technical manager','web','2026-03-29 11:12:49','2026-03-29 11:12:49'),(7,'laboratory head','web','2026-03-29 11:12:49','2026-03-29 11:12:49');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sample_matrics`
--

DROP TABLE IF EXISTS `sample_matrics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sample_matrics` (
  `code` varchar(12) NOT NULL,
  `sample_type_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `code_name` varchar(255) GENERATED ALWAYS AS (if(((`name` is null) or (`name` = _utf8mb4'')),`code`,concat(`code`,_utf8mb4' (',`name`,_utf8mb4')'))) VIRTUAL,
  `environment_type` tinyint NOT NULL DEFAULT '1',
  `description` text,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`code`),
  UNIQUE KEY `sample_matrics_name_unique` (`name`),
  KEY `sample_matrics_environment_type_index` (`environment_type`),
  KEY `sample_matrics_code_index` (`code`),
  KEY `sample_matrics_name_index` (`name`),
  KEY `fk_sample_matrics_sample_type` (`sample_type_id`),
  CONSTRAINT `fk_sample_matrics_sample_type` FOREIGN KEY (`sample_type_id`) REFERENCES `sample_types` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sample_matrics`
--

LOCK TABLES `sample_matrics` WRITE;
/*!40000 ALTER TABLE `sample_matrics` DISABLE KEYS */;
INSERT INTO `sample_matrics` (`code`, `sample_type_id`, `name`, `environment_type`, `description`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES ('AKl',1,'Air Kegiatan Labor',2,NULL,NULL,NULL,NULL,NULL),('AKr',1,'Air Kolam Renang',3,NULL,NULL,NULL,NULL,NULL),('ALdom',1,'Air Limbah Domestik',1,NULL,NULL,NULL,NULL,NULL),('ALpro',1,'Air Limbah Produksi',3,NULL,NULL,NULL,NULL,NULL),('APd,APw,APr',2,'Udara Lingkungan Kerja',2,NULL,NULL,NULL,NULL,NULL),('APs,APm',1,'Air Sungai, Air Muara dan sejenisnya',1,NULL,NULL,NULL,NULL,NULL),('Ata',1,'Air Akuifer',1,NULL,NULL,NULL,NULL,NULL),('AThs',1,'Air Higiene Sanitasi',3,NULL,NULL,NULL,NULL,NULL),('ATs',1,'Air Spa',3,NULL,NULL,NULL,NULL,NULL),('ATsp',1,'Air Sumur Pantau',1,NULL,NULL,NULL,NULL,NULL),('BA',16,'Biota Air',1,NULL,NULL,NULL,NULL,NULL),('BS',4,'Kebisingan',3,NULL,NULL,NULL,NULL,NULL),('BU',3,'Kebauan',3,NULL,NULL,NULL,NULL,NULL),('ESB',5,'Emisi Sumber Bergerak',3,NULL,NULL,NULL,NULL,NULL),('ESTB',6,'Emisi Sumber Tak Bergerak',3,NULL,NULL,NULL,NULL,NULL),('GT',15,'Getaran',3,NULL,NULL,NULL,NULL,NULL),('SD',17,'Sendimentasi Sungai',1,NULL,NULL,NULL,NULL,NULL),('UA',2,'Udara Ambient',3,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `sample_matrics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sample_types`
--

DROP TABLE IF EXISTS `sample_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sample_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sample_types_name_unique` (`name`),
  KEY `sample_types_name_index` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sample_types`
--

LOCK TABLES `sample_types` WRITE;
/*!40000 ALTER TABLE `sample_types` DISABLE KEYS */;
INSERT INTO `sample_types` VALUES (1,'Air',NULL,NULL,NULL,NULL),(2,'Udara',NULL,NULL,NULL,NULL),(3,'Kebauan',NULL,NULL,NULL,NULL),(4,'Kebisingan',NULL,NULL,NULL,NULL),(5,'Emisi Sumber Bergerak',NULL,NULL,NULL,NULL),(6,'Emisi Sumber Tidak Bergerak',NULL,NULL,NULL,NULL),(7,'Tanah',NULL,NULL,NULL,NULL),(8,'Pupuk',NULL,NULL,NULL,NULL),(9,'Solar',NULL,NULL,NULL,NULL),(10,'Air Minum',NULL,NULL,NULL,NULL),(11,'Infeksius',NULL,NULL,NULL,NULL),(12,'Radio Frekuensi',NULL,NULL,NULL,NULL),(13,'Psikologis',NULL,NULL,NULL,NULL),(14,'Ergonomi',NULL,NULL,NULL,NULL),(15,'Getaran',NULL,NULL,NULL,NULL),(16,'Biota',NULL,NULL,NULL,NULL),(17,'Sedimen',NULL,NULL,NULL,NULL),(18,'Filter Press',NULL,NULL,NULL,NULL),(19,'Padatan',NULL,NULL,NULL,NULL),(20,'Faktor Fisika',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `sample_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `samples`
--

DROP TABLE IF EXISTS `samples`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `samples` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `lab_job_item_id` bigint unsigned NOT NULL,
  `collected_by_personel_id` bigint unsigned DEFAULT NULL,
  `received_by_personel_id` bigint unsigned DEFAULT NULL,
  `sample_code` varchar(50) NOT NULL,
  `collection_date` date DEFAULT NULL,
  `collection_time` time DEFAULT NULL,
  `collection_location_desc` text,
  `latitude` varchar(50) DEFAULT NULL,
  `longitude` varchar(50) DEFAULT NULL,
  `container_type` varchar(100) DEFAULT NULL,
  `container_quantity` int NOT NULL DEFAULT '1',
  `sample_volume` varchar(50) DEFAULT NULL,
  `preservation_method` varchar(255) DEFAULT NULL,
  `collection_notes` text,
  `received_date` date DEFAULT NULL,
  `received_time` time DEFAULT NULL,
  `received_condition_notes` text,
  `collection_type` tinyint NOT NULL DEFAULT '1',
  `status` tinyint NOT NULL DEFAULT '1',
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `samples_sample_code_unique` (`sample_code`),
  KEY `samples_status_index` (`status`),
  KEY `samples_collection_type_index` (`collection_type`),
  KEY `fk_samples_lab_job_item` (`lab_job_item_id`),
  KEY `fk_samples_collected_by_personel` (`collected_by_personel_id`),
  KEY `fk_samples_received_by_personel` (`received_by_personel_id`),
  CONSTRAINT `fk_samples_collected_by_personel` FOREIGN KEY (`collected_by_personel_id`) REFERENCES `personels` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_samples_lab_job_item` FOREIGN KEY (`lab_job_item_id`) REFERENCES `lab_job_items` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_samples_received_by_personel` FOREIGN KEY (`received_by_personel_id`) REFERENCES `personels` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `samples`
--

LOCK TABLES `samples` WRITE;
/*!40000 ALTER TABLE `samples` DISABLE KEYS */;
/*!40000 ALTER TABLE `samples` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `payload` longtext NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('rY6MUDfwVmgvZUxBD33INousGX2vQhizaxKKYAOD',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36','YTo4OntzOjY6Il90b2tlbiI7czo0MDoibXJJZEluMTh2UnpLbWV1MVExRVJGNFpKR2RIUXB1NEtKdm9relNJdSI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjIyOiJQSFBERUJVR0JBUl9TVEFDS19EQVRBIjthOjE6e3M6MjY6IjAxS040WEFRMkdIOVIwVkE3MFo4M001UUZNIjtOO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0MDoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2xpbXMvdGVzdC1wYWNrYWdlcyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MTc6InBhc3N3b3JkX2hhc2hfd2ViIjtzOjYwOiIkMnkkMTIkTWcxeEQ5U0pKTzNnM05yc1FUZXk1T2VTWEFvRDRuaWl4d0llakE4S240UE50UVNRLnhQS0MiO3M6NjoidGFibGVzIjthOjI6e3M6NDA6IjdiNzdiMDU3NmE3ZGFkY2I3ZWVlYTRmODMwOTg2ZTZhX2NvbHVtbnMiO2E6MTA6e2k6MDthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo0OiJuYW1lIjtzOjU6ImxhYmVsIjtzOjIwOiJOYW1hIHBha2V0IHBlbmd1amlhbiI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjE7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTc6InNhbXBsZU1hdHJpYy5uYW1lIjtzOjU6ImxhYmVsIjtzOjEzOiJNYXRyaXggc2FtcGVsIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MjthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoyMDoicmVndWxhdGlvbi5sb25nX25hbWUiO3M6NToibGFiZWwiO3M6ODoiUmVndWxhc2kiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTozO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjU6InByaWNlIjtzOjU6ImxhYmVsIjtzOjU6IkhhcmdhIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NDthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo5OiJpc19hY3RpdmUiO3M6NToibGFiZWwiO3M6OToiSXMgYWN0aXZlIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czozNToicGFyYW1ldGVycy5sb25nX25hbWVfc3RhbmRhcmRfbm90ZXMiO3M6NToibGFiZWwiO3M6OToiUGFyYW1ldGVyIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NjthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMDoiY3JlYXRlZF9ieSI7czo1OiJsYWJlbCI7czoxMDoiQ3JlYXRlZCBieSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjc7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTA6InVwZGF0ZWRfYnkiO3M6NToibGFiZWwiO3M6MTA6IlVwZGF0ZWQgYnkiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo4O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEwOiJjcmVhdGVkX2F0IjtzOjU6ImxhYmVsIjtzOjEwOiJDcmVhdGVkIGF0IjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MDtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MTtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO2I6MTt9aTo5O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEwOiJ1cGRhdGVkX2F0IjtzOjU6ImxhYmVsIjtzOjEwOiJVcGRhdGVkIGF0IjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MDtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MTtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO2I6MTt9fXM6NDA6IjAxYzQ3OGZmMThmMWRhZTc0ZDA2ZDk1NWEzNTA1YTFkX2NvbHVtbnMiO2E6ODp7aTowO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjE0OiJwYXJhbWV0ZXIuY29kZSI7czo1OiJsYWJlbCI7czoxNDoiS29kZSBwYXJhbWV0ZXIiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToxO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjM0OiJwYXJhbWV0ZXIubG9uZ19uYW1lX3N0YW5kYXJkX25vdGVzIjtzOjU6ImxhYmVsIjtzOjE4OiJOYW1hIHBhcmFtZXRlciB1amkiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToyO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjE2OiJwYXJhbWV0ZXIuc3RhdHVzIjtzOjU6ImxhYmVsIjtzOjY6IlN0YXR1cyI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjM7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MjE6InBhcmFtZXRlci50ZXN0ZWRfdGltZSI7czo1OiJsYWJlbCI7czoxNjoiV2FrdHUgcGVuZ3VrdXJhbiI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjQ7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MjQ6InBhcmFtZXRlci5zdGFuZGFyZF9ub3RlcyI7czo1OiJsYWJlbCI7czo5OiJCYWt1IG11dHUiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo1O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjE0OiJwYXJhbWV0ZXIudW5pdCI7czo1OiJsYWJlbCI7czo2OiJTYXR1YW4iO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo2O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjI1OiJwYXJhbWV0ZXIudGVzdE1ldGhvZC5uYW1lIjtzOjU6ImxhYmVsIjtzOjEwOiJNZXRvZGUgdWppIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NzthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoyMzoicGFyYW1ldGVyLmRlZmF1bHRfcHJpY2UiO3M6NToibGFiZWwiO3M6NToiSGFyZ2EiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9fX1zOjg6ImZpbGFtZW50IjthOjA6e319',1775065991);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `company_id` bigint unsigned NOT NULL,
  `letterhead_path` varchar(255) DEFAULT NULL,
  `default_quotation_expiry_days` int DEFAULT '30',
  `term_template_id` bigint unsigned DEFAULT NULL,
  `mail_mailer` varchar(255) DEFAULT 'smtp',
  `mail_host` varchar(255) DEFAULT NULL,
  `mail_port` varchar(255) DEFAULT NULL,
  `mail_username` varchar(255) DEFAULT NULL,
  `mail_password` text,
  `mail_encryption` varchar(255) DEFAULT NULL,
  `mail_from_address` varchar(255) DEFAULT NULL,
  `mail_from_name` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `settings_is_active_index` (`is_active`),
  KEY `fk_settings_company` (`company_id`),
  KEY `fk_settings_term_template` (`term_template_id`),
  CONSTRAINT `fk_settings_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_settings_term_template` FOREIGN KEY (`term_template_id`) REFERENCES `term_templates` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,1,NULL,30,NULL,'smtp','smtp.gmail.com','587','m.agungmahardika12@gmail.com','eyJpdiI6IlMvQTJPRzNBLytvQ1JBcXJVT1JTNEE9PSIsInZhbHVlIjoiaEZtTnRhMHh3UkUvTzE5a2Z5bHlKeXdaMGFqbkt3MlMrRSt4bzN2SGc4OD0iLCJtYWMiOiI4YTFiNTE5ZGM3MTdhZDhhNTk4NDg2ODZjYTgzYjIwNGY1OGRkOTI2YzEzMWU2YzRhMWMzYWZhMWI2MDBmOGRlIiwidGFnIjoiIn0=','tls','no-reply@yourcompany.com','JLI',1,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `specialisasi_parameters`
--

DROP TABLE IF EXISTS `specialisasi_parameters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `specialisasi_parameters` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `specialization_id` bigint unsigned NOT NULL,
  `parameter_id` bigint unsigned NOT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `specialisasi_parameters`
--

LOCK TABLES `specialisasi_parameters` WRITE;
/*!40000 ALTER TABLE `specialisasi_parameters` DISABLE KEYS */;
/*!40000 ALTER TABLE `specialisasi_parameters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `specializations`
--

DROP TABLE IF EXISTS `specializations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `specializations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `specializations_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `specializations`
--

LOCK TABLES `specializations` WRITE;
/*!40000 ALTER TABLE `specializations` DISABLE KEYS */;
/*!40000 ALTER TABLE `specializations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `term_templates`
--

DROP TABLE IF EXISTS `term_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `term_templates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `term_templates_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `term_templates`
--

LOCK TABLES `term_templates` WRITE;
/*!40000 ALTER TABLE `term_templates` DISABLE KEYS */;
/*!40000 ALTER TABLE `term_templates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test_methods`
--

DROP TABLE IF EXISTS `test_methods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `test_methods` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `test_methods_name_index` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=111 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test_methods`
--

LOCK TABLES `test_methods` WRITE;
/*!40000 ALTER TABLE `test_methods` DISABLE KEYS */;
INSERT INTO `test_methods` VALUES (1,'SNI 7119-7:2017',NULL,NULL,NULL,NULL,NULL),(2,'IKM.JLI-22 (CO meter)',NULL,NULL,NULL,NULL,NULL),(3,'SNI 19-7119.2-2005',NULL,NULL,NULL,NULL,NULL),(4,'SNI 19-7119.8-2005',NULL,NULL,NULL,NULL,NULL),(5,'SNI 7119.13:2009',NULL,NULL,NULL,NULL,NULL),(6,'SNI 7119-3-2017',NULL,NULL,NULL,NULL,NULL),(7,'SNI 7119-15:2016',NULL,NULL,NULL,NULL,NULL),(8,'SNI 7119-14:2016',NULL,NULL,NULL,NULL,NULL),(9,'SNI 7119-4:2017',NULL,NULL,NULL,NULL,NULL),(10,'IKM.JLI-30 (Anemometer)',NULL,NULL,NULL,NULL,NULL),(11,'IKM.JLI-166 (Weather Station)',NULL,NULL,NULL,NULL,NULL),(12,'SNI 19-7119.1-2005',NULL,NULL,NULL,NULL,NULL),(13,'NIOSH 2542 (1994)',NULL,NULL,NULL,NULL,NULL),(14,'IKM-JLI-20 (MASA 701)',NULL,NULL,NULL,NULL,NULL),(15,'OWI-T020 (GC)',NULL,NULL,NULL,NULL,NULL),(16,'NIOSH 1501 (2003)',NULL,NULL,NULL,NULL,NULL),(17,'SNI 8427:2017',NULL,NULL,NULL,NULL,NULL),(18,'IKM.JLI-37 (Vibration meter)',NULL,NULL,NULL,NULL,NULL),(19,'SNI 7118-2: 2018',NULL,NULL,NULL,NULL,NULL),(20,'SNI 19-7117.6-2005',NULL,NULL,NULL,NULL,NULL),(21,'IKM.JLI-73 (Spektrofotometer)',NULL,NULL,NULL,NULL,NULL),(22,'SNI 19-7117.8-2005',NULL,NULL,NULL,NULL,NULL),(23,'SNI 19-7117.9-2005',NULL,NULL,NULL,NULL,NULL),(24,'IKM.JLI-24 (Gas Analyzer)',NULL,NULL,NULL,NULL,NULL),(25,'SNI 19-7117.11-2005',NULL,NULL,NULL,NULL,NULL),(26,'US-EPA Method 17, 2017',NULL,NULL,NULL,NULL,NULL),(27,'IKM.JLI-129 (E6000-6DSH)',NULL,NULL,NULL,NULL,NULL),(28,'US-EPA Method 29.2017',NULL,NULL,NULL,NULL,NULL),(29,'IKM.JLI-40 (Infrared Thermometer)',NULL,NULL,NULL,NULL,NULL),(30,'US-EPA Method 1, 2020',NULL,NULL,NULL,NULL,NULL),(31,'US-EPA Method 2, 2017',NULL,NULL,NULL,NULL,NULL),(32,'US-EPA Method 3, 2017',NULL,NULL,NULL,NULL,NULL),(33,'US-EPA Method 4, 2017',NULL,NULL,NULL,NULL,NULL),(34,'US-EPA Methode 17, 2017',NULL,NULL,NULL,NULL,NULL),(35,'SNI 06-6989.23',NULL,NULL,NULL,NULL,NULL),(36,'IKM.JLI-165 (Thermometer Digital)',NULL,NULL,NULL,NULL,NULL),(37,'IKM.JLI-07 (Elektrometri)',NULL,NULL,NULL,NULL,NULL),(38,'APHA 24th Edition, 2540-D,2023',NULL,NULL,NULL,NULL,NULL),(39,'SNI 6989.80:2011',NULL,NULL,NULL,NULL,NULL),(40,'SNI 6989.11:2019',NULL,NULL,NULL,NULL,NULL),(41,'SNI 6989.72:2009',NULL,NULL,NULL,NULL,NULL),(42,'IKM.JLI-12 (Spektrofotometri)',NULL,NULL,NULL,NULL,NULL),(43,'SNI 06-6989.14-2004',NULL,NULL,NULL,NULL,NULL),(44,'APHA 24th Edition 4500-G:2023',NULL,NULL,NULL,NULL,NULL),(45,'SNI 6989.20:2019',NULL,NULL,NULL,NULL,NULL),(46,'SNI 6989.19:2009',NULL,NULL,NULL,NULL,NULL),(47,'SNI 6989.79:2011',NULL,NULL,NULL,NULL,NULL),(48,'SNI 06-6989.9:2004',NULL,NULL,NULL,NULL,NULL),(49,'SNI 06-6989.30-2005',NULL,NULL,NULL,NULL,NULL),(50,'JIS K 0102-2.2022, Butir 17.3',NULL,NULL,NULL,NULL,NULL),(51,'SNI 6989-31:2021 butir 5.5.2',NULL,NULL,NULL,NULL,NULL),(52,'SNI 06-6989.29-2005',NULL,NULL,NULL,NULL,NULL),(53,'IKM.JLI 112 (Spektrofotometri)',NULL,NULL,NULL,NULL,NULL),(54,'SNI 6989.77-2011',NULL,NULL,NULL,NULL,NULL),(55,'IKM.JLI-86 (Spektrofotometri)',NULL,NULL,NULL,NULL,NULL),(56,'SNI 6989.40-2005',NULL,NULL,NULL,NULL,NULL),(57,'APHA 24th Edition, 4500-B,2023',NULL,NULL,NULL,NULL,NULL),(58,'IKM.JLI.74 (MVU-AAS)',NULL,NULL,NULL,NULL,NULL),(59,'IKM.JLI-85 (HVG-AAS)',NULL,NULL,NULL,NULL,NULL),(60,'IKM.JLI-75 (HVG- AAS)',NULL,NULL,NULL,NULL,NULL),(61,'SNI 6989-84:2019',NULL,NULL,NULL,NULL,NULL),(62,'SNI 6989.38-2005',NULL,NULL,NULL,NULL,NULL),(63,'IKM.JLI-79 (AAS)',NULL,NULL,NULL,NULL,NULL),(64,'SNI 06-6989.48:2005',NULL,NULL,NULL,NULL,NULL),(65,'SNI 6989.66:2009',NULL,NULL,NULL,NULL,NULL),(66,'SNI 6989.46-2009',NULL,NULL,NULL,NULL,NULL),(67,'SNI 6989.53:2010',NULL,NULL,NULL,NULL,NULL),(68,'SNI 6989.10:2011',NULL,NULL,NULL,NULL,NULL),(69,'SNI 06-6989.51:2005',NULL,NULL,NULL,NULL,NULL),(70,'APHA 24th Edition, 5530-C,2023',NULL,NULL,NULL,NULL,NULL),(71,'APHA 24th Edition, 9221-E,C, 2023',NULL,NULL,NULL,NULL,NULL),(72,'APHA 24th Edition, 9221-B,C, 2023',NULL,NULL,NULL,NULL,NULL),(73,'IKM.JLI-150 (Observasi Visual)',NULL,NULL,NULL,NULL,NULL),(74,'SNI 6989.1:2019',NULL,NULL,NULL,NULL,NULL),(75,'SNI 6989.26:2019',NULL,NULL,NULL,NULL,NULL),(76,'SNI 06-6989.25-2005',NULL,NULL,NULL,NULL,NULL),(77,'SNI 6989-31:2021 butir 5.5.1',NULL,NULL,NULL,NULL,NULL),(78,'SNI 6989.65-2009',NULL,NULL,NULL,NULL,NULL),(79,'APHA 24th Edition 9221-F,C:2023',NULL,NULL,NULL,NULL,NULL),(80,'APHA 24th Edition 2320.B-2023',NULL,NULL,NULL,NULL,NULL),(81,'IKM.JLI-153 (Visual)',NULL,NULL,NULL,NULL,NULL),(82,'IKM.JLI-32 (Mikroskop)',NULL,NULL,NULL,NULL,NULL),(83,'IKM.JLI-156 (Spektrofotometri)',NULL,NULL,NULL,NULL,NULL),(84,'APHA 24th Edition 9221-B,C:2023',NULL,NULL,NULL,NULL,NULL),(85,'SNI 06.6989.51-2005',NULL,NULL,NULL,NULL,NULL),(86,'SNI 06-6989.21-2004',NULL,NULL,NULL,NULL,NULL),(87,'SNI 6989.71-2009',NULL,NULL,NULL,NULL,NULL),(88,'SNI 6989.84-2019',NULL,NULL,NULL,NULL,NULL),(89,'SNI 6989.46:2009',NULL,NULL,NULL,NULL,NULL),(90,'SNI 6989.64:2009',NULL,NULL,NULL,NULL,NULL),(91,'IKM. JLI-85 (HVG-AAS)',NULL,NULL,NULL,NULL,NULL),(92,'IKM.JLI-75 (HVG-AAS)',NULL,NULL,NULL,NULL,NULL),(93,'IKM. JLI-79 (AAS)',NULL,NULL,NULL,NULL,NULL),(94,'SNI 6989.77:2011',NULL,NULL,NULL,NULL,NULL),(95,'IKM.JLI-112 (Spektrofotometri)',NULL,NULL,NULL,NULL,NULL),(96,'SNI 06-6989.29:2005',NULL,NULL,NULL,NULL,NULL),(97,'SNI 06-6989.23-2005',NULL,NULL,NULL,NULL,NULL),(98,'APHA 24th 3111-B:2023',NULL,NULL,NULL,NULL,NULL),(99,'BS EN ISO 9308-1:2014+A1:2017',NULL,NULL,NULL,NULL,NULL),(100,'SNI 06-6860-2002',NULL,NULL,NULL,NULL,NULL),(101,'IKM.JLI-158 (Spektrofotometri)',NULL,NULL,NULL,NULL,NULL),(102,'IKM.JLI-157 (Spektrofotometri)',NULL,NULL,NULL,NULL,NULL),(103,'SNI 06-6989.30:2005',NULL,NULL,NULL,NULL,NULL),(104,'SNI 6989.31:2021',NULL,NULL,NULL,NULL,NULL),(105,'IKM.JLI-158 (Spektrofometri)',NULL,NULL,NULL,NULL,NULL),(106,'IKM.JLI-157 (Spektrofometri)',NULL,NULL,NULL,NULL,NULL),(107,'IKM.JLI-156 (Spektrofometri)',NULL,NULL,NULL,NULL,NULL),(108,'SNI 06-6989.51-2005',NULL,NULL,NULL,NULL,NULL),(109,'SNI 6989.66-2009',NULL,NULL,NULL,NULL,NULL),(110,'SNI 6989.65:2009',NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `test_methods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test_packages`
--

DROP TABLE IF EXISTS `test_packages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `test_packages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `sample_matric_code` varchar(12) DEFAULT NULL,
  `regulation_id` bigint unsigned DEFAULT NULL,
  `description` text,
  `price` decimal(15,2) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `test_packages_name_index` (`name`),
  KEY `fk_test_packages_sample_matric` (`sample_matric_code`),
  KEY `fk_test_packages_regulation` (`regulation_id`),
  CONSTRAINT `fk_test_packages_regulation` FOREIGN KEY (`regulation_id`) REFERENCES `regulations` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_test_packages_sample_matric` FOREIGN KEY (`sample_matric_code`) REFERENCES `sample_matrics` (`code`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test_packages`
--

LOCK TABLES `test_packages` WRITE;
/*!40000 ALTER TABLE `test_packages` DISABLE KEYS */;
INSERT INTO `test_packages` VALUES (1,'Udara Ambien','UA',1,NULL,0.00,1,'superadmin',NULL,'2026-03-29 11:14:24','2026-03-29 11:14:24'),(2,'Data Tambahan/Meteorologi','UA',NULL,NULL,0.00,1,'superadmin','superadmin','2026-03-29 15:40:24','2026-03-29 15:52:22'),(3,'Kebauan','BU',2,NULL,0.00,1,'superadmin',NULL,'2026-03-29 15:44:34','2026-03-29 15:44:34'),(4,'Kebisingan','BS',3,NULL,0.00,1,'superadmin',NULL,'2026-03-29 15:47:39','2026-03-29 15:47:39'),(5,'Data Tambahan/Meteorologi','UA',NULL,NULL,0.00,1,'superadmin',NULL,'2026-03-30 15:47:12','2026-03-30 15:47:12'),(6,'Getaran','GT',4,NULL,0.00,1,'superadmin',NULL,'2026-03-30 15:55:07','2026-03-30 15:55:07'),(7,'Emisi Sumber Bergerak','ESB',4,NULL,0.00,1,'superadmin',NULL,'2026-03-30 16:02:46','2026-03-30 16:02:46'),(8,'Emisi Sumber Tidak Bergerak','ESTB',6,NULL,0.00,1,'superadmin',NULL,'2026-03-31 14:58:18','2026-03-31 14:58:18'),(9,'Emisi Sumber Tidak Bergerak','ESTB',5,NULL,0.00,1,'superadmin','superadmin','2026-03-31 15:02:53','2026-03-31 15:57:52'),(10,'Emisi Sumber Tidak Bergerak','ESTB',7,NULL,0.00,1,'superadmin',NULL,'2026-04-01 16:28:25','2026-04-01 16:28:25');
/*!40000 ALTER TABLE `test_packages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test_result_histories`
--

DROP TABLE IF EXISTS `test_result_histories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `test_result_histories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `personel_id` bigint unsigned NOT NULL,
  `test_result_id` bigint unsigned NOT NULL,
  `old_status` tinyint NOT NULL,
  `new_status` tinyint NOT NULL,
  `old_tested_value` decimal(10,4) DEFAULT NULL,
  `new_tested_value` decimal(10,4) DEFAULT NULL,
  `comment` text,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_test_result_histories_personel` (`personel_id`),
  KEY `fk_test_result_histories_test_result` (`test_result_id`),
  CONSTRAINT `fk_test_result_histories_personel` FOREIGN KEY (`personel_id`) REFERENCES `personels` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_test_result_histories_test_result` FOREIGN KEY (`test_result_id`) REFERENCES `test_results` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test_result_histories`
--

LOCK TABLES `test_result_histories` WRITE;
/*!40000 ALTER TABLE `test_result_histories` DISABLE KEYS */;
/*!40000 ALTER TABLE `test_result_histories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test_results`
--

DROP TABLE IF EXISTS `test_results`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `test_results` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sample_id` bigint unsigned NOT NULL,
  `parameter_id` bigint unsigned DEFAULT NULL,
  `test_method_id` bigint unsigned DEFAULT NULL,
  `analyst_personel_id` bigint unsigned DEFAULT NULL,
  `validator_personel_id` bigint unsigned DEFAULT NULL,
  `tested_value` decimal(10,4) DEFAULT NULL,
  `unit` varchar(50) DEFAULT NULL,
  `test_date` date DEFAULT NULL,
  `test_notes` text,
  `standard_max_value_ref` decimal(10,4) DEFAULT NULL,
  `standard_min_value_ref` decimal(10,4) DEFAULT NULL,
  `standard_unit_ref` varchar(50) DEFAULT NULL,
  `standard_notes_ref` varchar(255) DEFAULT NULL,
  `comment` text,
  `status` tinyint NOT NULL DEFAULT '1',
  `revision_count` tinyint NOT NULL DEFAULT '0',
  `evaluation_status` tinyint NOT NULL DEFAULT '1',
  `validation_date` timestamp NULL DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `test_results_status_index` (`status`),
  KEY `test_results_evaluation_status_index` (`evaluation_status`),
  KEY `fk_test_results_sample` (`sample_id`),
  KEY `fk_test_results_parameter` (`parameter_id`),
  KEY `fk_test_results_test_method` (`test_method_id`),
  KEY `fk_test_results_analyst_personel` (`analyst_personel_id`),
  KEY `fk_test_results_validator_personel` (`validator_personel_id`),
  CONSTRAINT `fk_test_results_analyst_personel` FOREIGN KEY (`analyst_personel_id`) REFERENCES `personels` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_test_results_parameter` FOREIGN KEY (`parameter_id`) REFERENCES `parameters` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_test_results_sample` FOREIGN KEY (`sample_id`) REFERENCES `samples` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_test_results_test_method` FOREIGN KEY (`test_method_id`) REFERENCES `test_methods` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_test_results_validator_personel` FOREIGN KEY (`validator_personel_id`) REFERENCES `personels` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test_results`
--

LOCK TABLES `test_results` WRITE;
/*!40000 ALTER TABLE `test_results` DISABLE KEYS */;
/*!40000 ALTER TABLE `test_results` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `username` varchar(15) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `two_factor_secret` text,
  `two_factor_recovery_codes` text,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `current_team_id` bigint unsigned DEFAULT NULL,
  `profile_photo_path` varchar(2048) DEFAULT NULL,
  `status` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_status_index` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'superadmin','superadmin','superadmin@example.com','2026-03-29 11:12:55','$2y$12$Mg1xD9SJJO3g3NrsQTey5OeSXAoD4niixwIejA8Kn4PNtQSQ.xPKC',NULL,NULL,NULL,'yCXUJpC76M',NULL,NULL,1,'2026-03-29 11:12:55','2026-03-29 11:12:55');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-04-02  0:54:07
