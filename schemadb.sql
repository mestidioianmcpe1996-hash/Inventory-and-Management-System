-- MySQL dump 10.13  Distrib 8.0.43, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: project(411)
-- ------------------------------------------------------
-- Server version	8.0.43

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
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,'admin','admin_2025!'),(5,'mark','123456789');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `barcode`
--

DROP TABLE IF EXISTS `barcode`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `barcode` (
  `barcodeID` int NOT NULL DEFAULT '100',
  `Item_name` varchar(45) NOT NULL,
  `quantity` int NOT NULL,
  `schoolID` int NOT NULL,
  PRIMARY KEY (`barcodeID`),
  UNIQUE KEY `barcodeID_UNIQUE` (`barcodeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `barcode`
--

LOCK TABLES `barcode` WRITE;
/*!40000 ALTER TABLE `barcode` DISABLE KEYS */;
INSERT INTO `barcode` VALUES (100,'ballpen',2,12345);
/*!40000 ALTER TABLE `barcode` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `borrowers`
--

DROP TABLE IF EXISTS `borrowers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `borrowers` (
  `borrowerID` int NOT NULL AUTO_INCREMENT,
  `school_id` int NOT NULL,
  `firstname` varchar(45) NOT NULL,
  `lastname` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `phone_number` bigint NOT NULL,
  `borrow_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `return_date` varchar(45) NOT NULL,
  PRIMARY KEY (`borrowerID`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `borrowers`
--

LOCK TABLES `borrowers` WRITE;
/*!40000 ALTER TABLE `borrowers` DISABLE KEYS */;
INSERT INTO `borrowers` VALUES (1,12345,'mark','subere','jhovan@gmail.com',9356252809,'2025-10-06 00:34:55','2025-10-8 10:15:02'),(2,23456,'ian','mestidio','mestidio@gmail.com',9123456789,'2025-10-06 13:47:24','2025-10-20-11:12:14'),(3,23123,'dsfsd','sacaca','dsvsn@gmail.com',9123124324,'2025-10-06 13:48:58','2025-10-21-12:41:12'),(4,23121,'cvxcx','ngmknd','scsa@gmail.com',9213123141,'2025-10-06 13:52:58','2025-10-22-11:42:10');
/*!40000 ALTER TABLE `borrowers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `items` (
  `itemsID` int NOT NULL AUTO_INCREMENT,
  `barcode` varchar(45) NOT NULL,
  `item_name` varchar(45) NOT NULL,
  `quantity` int NOT NULL,
  PRIMARY KEY (`itemsID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `items`
--

LOCK TABLES `items` WRITE;
/*!40000 ALTER TABLE `items` DISABLE KEYS */;
INSERT INTO `items` VALUES (1,'qweqr','arduino',5),(2,'cxzcz','czcasca',12);
/*!40000 ALTER TABLE `items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_borrowers`
--

DROP TABLE IF EXISTS `tbl_borrowers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_borrowers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `barcode_id` int(8) unsigned zerofill NOT NULL,
  `item_name` varchar(45) NOT NULL,
  `qty_borrow` int NOT NULL,
  `school_id` int(9) unsigned zerofill NOT NULL,
  `studname` varchar(45) NOT NULL,
  `date_borrow` datetime NOT NULL,
  `date_ret` datetime NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_borrowers`
--

LOCK TABLES `tbl_borrowers` WRITE;
/*!40000 ALTER TABLE `tbl_borrowers` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_borrowers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_items`
--

DROP TABLE IF EXISTS `tbl_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_items` (
  `barcode_id` int(8) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `item_name` varchar(45) NOT NULL,
  `quantity` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`barcode_id`),
  UNIQUE KEY `id_UNIQUE` (`barcode_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_items`
--

LOCK TABLES `tbl_items` WRITE;
/*!40000 ALTER TABLE `tbl_items` DISABLE KEYS */;
INSERT INTO `tbl_items` VALUES (00000001,'ballpen',10),(00000004,'paper',20),(00000007,'pen',10);
/*!40000 ALTER TABLE `tbl_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_register`
--

DROP TABLE IF EXISTS `tbl_register`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_register` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fname` varchar(45) NOT NULL,
  `lname` varchar(45) NOT NULL,
  `idschool` int(9) unsigned zerofill NOT NULL,
  `course` varchar(45) NOT NULL,
  `yearlevel` varchar(45) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `idschool_UNIQUE` (`idschool`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_register`
--

LOCK TABLES `tbl_register` WRITE;
/*!40000 ALTER TABLE `tbl_register` DISABLE KEYS */;
INSERT INTO `tbl_register` VALUES (34,'Mark Jhovan','Subere',000057343,'BSCPE','4th Year','markjhovansubere@gmail.com');
/*!40000 ALTER TABLE `tbl_register` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_transaction`
--

DROP TABLE IF EXISTS `tbl_transaction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_transaction` (
  `id_transac` int NOT NULL AUTO_INCREMENT,
  `barcode_id` int(8) unsigned zerofill NOT NULL,
  `item_name` varchar(45) NOT NULL,
  `qty_borrowed` int NOT NULL,
  `school_id` int(9) unsigned zerofill NOT NULL,
  `studname` varchar(45) NOT NULL,
  `date_borrowed` datetime NOT NULL,
  `date_reg_return` datetime NOT NULL,
  `date_returned` datetime NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id_transac`),
  UNIQUE KEY `id_transac_UNIQUE` (`id_transac`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_transaction`
--

LOCK TABLES `tbl_transaction` WRITE;
/*!40000 ALTER TABLE `tbl_transaction` DISABLE KEYS */;
INSERT INTO `tbl_transaction` VALUES (1,00000001,'ballpen',1,000012345,'Mark Subere','2025-10-26 19:45:00','2025-10-26 19:47:00','2025-10-26 19:52:00','markjhovansubere@gmail.com'),(2,00000002,'pen',1,000046201,'ian Mestidio','2025-10-27 01:25:00','2025-10-27 01:26:00','2025-10-27 01:34:00','jhovancpe12@gmail.com'),(3,00000001,'ballpen',1,000057343,'Mark Jhovan Subere','2025-10-27 00:05:00','2025-10-27 00:06:00','2025-10-27 13:54:00','markjhovansubere@gmail.com'),(4,00000002,'pen',1,000054661,'','2025-10-26 20:17:00','2025-10-26 20:18:00','2025-10-27 13:56:00',''),(5,00000001,'ballpen',2,000054690,'Christine Landayao','2025-10-27 13:53:00','2025-10-27 13:55:00','2025-10-27 14:18:00','landayao.christinetcpe1996@gmail.com'),(6,00000001,'ballpen',1,000057343,'','2025-10-28 13:24:00','2025-10-28 13:26:00','2025-10-28 13:25:00','');
/*!40000 ALTER TABLE `tbl_transaction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transaction`
--

DROP TABLE IF EXISTS `transaction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `transaction` (
  `transactionID` int NOT NULL AUTO_INCREMENT,
  `itemsID` int NOT NULL,
  `borrowerID` int NOT NULL,
  `borrow_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `return_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`transactionID`),
  KEY `itemsID_idx` (`itemsID`),
  KEY `borrowerId_idx` (`borrowerID`),
  CONSTRAINT `borrowerId` FOREIGN KEY (`borrowerID`) REFERENCES `borrowers` (`borrowerID`),
  CONSTRAINT `itemsID` FOREIGN KEY (`itemsID`) REFERENCES `items` (`itemsID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaction`
--

LOCK TABLES `transaction` WRITE;
/*!40000 ALTER TABLE `transaction` DISABLE KEYS */;
INSERT INTO `transaction` VALUES (1,1,1,'2025-10-06 00:29:05','2025-10-06 00:29:05');
/*!40000 ALTER TABLE `transaction` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-10-28 16:14:37
