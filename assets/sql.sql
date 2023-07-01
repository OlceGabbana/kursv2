-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: mydb
-- ------------------------------------------------------
-- Server version	8.0.30

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
-- Table structure for table `account`
--

DROP TABLE IF EXISTS `account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `account` (
  `id_users` int NOT NULL AUTO_INCREMENT,
  `user_password` varchar(45) DEFAULT NULL,
  `user_login` varchar(45) DEFAULT NULL,
  `user_email` varchar(45) DEFAULT NULL,
  `user_name` varchar(45) DEFAULT NULL,
  `user_surname` varchar(45) DEFAULT NULL,
  `user_phone` varchar(11) DEFAULT NULL,
  `user_score` int DEFAULT NULL,
  PRIMARY KEY (`id_users`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account`
--

LOCK TABLES `account` WRITE;
/*!40000 ALTER TABLE `account` DISABLE KEYS */;
INSERT INTO `account` VALUES (1,'ЩЩЩЩЩ','olce_gabbana','o.g@mail.ru','Оля','Соколова','12345678912',155);
/*!40000 ALTER TABLE `account` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `account_has_addresses`
--

DROP TABLE IF EXISTS `account_has_addresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `account_has_addresses` (
  `account_id_users` int NOT NULL,
  `addresses_id_address` int NOT NULL,
  PRIMARY KEY (`account_id_users`,`addresses_id_address`),
  KEY `fk_account_has_addresses_addresses1_idx` (`addresses_id_address`),
  KEY `fk_account_has_addresses_account_idx` (`account_id_users`),
  CONSTRAINT `fk_account_has_addresses_account` FOREIGN KEY (`account_id_users`) REFERENCES `account` (`id_users`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_account_has_addresses_addresses1` FOREIGN KEY (`addresses_id_address`) REFERENCES `addresses` (`id_address`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account_has_addresses`
--

LOCK TABLES `account_has_addresses` WRITE;
/*!40000 ALTER TABLE `account_has_addresses` DISABLE KEYS */;
INSERT INTO `account_has_addresses` VALUES (1,1),(1,2);
/*!40000 ALTER TABLE `account_has_addresses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `addresses`
--

DROP TABLE IF EXISTS `addresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `addresses` (
  `id_address` int NOT NULL AUTO_INCREMENT,
  `address_city` varchar(45) DEFAULT NULL,
  `address` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id_address`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `addresses`
--

LOCK TABLES `addresses` WRITE;
/*!40000 ALTER TABLE `addresses` DISABLE KEYS */;
INSERT INTO `addresses` VALUES (1,'Кострома','Скворцова,8-74'),(2,'Москва','Ленина,127-12');
/*!40000 ALTER TABLE `addresses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id_category` int NOT NULL AUTO_INCREMENT,
  `name_category` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dishes`
--

DROP TABLE IF EXISTS `dishes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dishes` (
  `id_dish` int NOT NULL AUTO_INCREMENT,
  `dish_name` varchar(45) DEFAULT NULL,
  `dish_cost` decimal(9,2) DEFAULT NULL,
  `dish_weight` decimal(9,2) DEFAULT NULL,
  `dish_calories` int DEFAULT NULL,
  PRIMARY KEY (`id_dish`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dishes`
--

LOCK TABLES `dishes` WRITE;
/*!40000 ALTER TABLE `dishes` DISABLE KEYS */;
INSERT INTO `dishes` VALUES (1,'Утка по-пекински',450.00,300.00,512),(2,'Рулет ПП',260.00,250.00,250);
/*!40000 ALTER TABLE `dishes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dishes_has_categories`
--

DROP TABLE IF EXISTS `dishes_has_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dishes_has_categories` (
  `dishes_id_dish` int NOT NULL,
  `categories_id_category` int NOT NULL,
  PRIMARY KEY (`dishes_id_dish`,`categories_id_category`),
  KEY `fk_dishes_has_categories_categories1_idx` (`categories_id_category`),
  KEY `fk_dishes_has_categories_dishes_idx` (`dishes_id_dish`),
  CONSTRAINT `fk_dishes_has_categories_categories1` FOREIGN KEY (`categories_id_category`) REFERENCES `categories` (`id_category`),
  CONSTRAINT `fk_dishes_has_categories_dishes` FOREIGN KEY (`dishes_id_dish`) REFERENCES `dishes` (`id_dish`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dishes_has_categories`
--

LOCK TABLES `dishes_has_categories` WRITE;
/*!40000 ALTER TABLE `dishes_has_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `dishes_has_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dishes_has_order`
--

DROP TABLE IF EXISTS `dishes_has_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dishes_has_order` (
  `dishes_id_dish` int NOT NULL,
  `order_id_order` int NOT NULL,
  PRIMARY KEY (`dishes_id_dish`,`order_id_order`),
  KEY `fk_dishes_has_order_order1_idx` (`order_id_order`),
  KEY `fk_dishes_has_order_dishes1_idx` (`dishes_id_dish`),
  CONSTRAINT `fk_dishes_has_order_dishes1` FOREIGN KEY (`dishes_id_dish`) REFERENCES `dishes` (`id_dish`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_dishes_has_order_order1` FOREIGN KEY (`order_id_order`) REFERENCES `order` (`id_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dishes_has_order`
--

LOCK TABLES `dishes_has_order` WRITE;
/*!40000 ALTER TABLE `dishes_has_order` DISABLE KEYS */;
INSERT INTO `dishes_has_order` VALUES (2,1);
/*!40000 ALTER TABLE `dishes_has_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order`
--

DROP TABLE IF EXISTS `order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order` (
  `id_order` int NOT NULL AUTO_INCREMENT,
  `order_time` time DEFAULT NULL,
  `order_time_issue` time DEFAULT NULL,
  `order_payment` enum('Оплачено','Не оплачено') DEFAULT NULL,
  `order_delivery` enum('Доставлено','Не доставлено') DEFAULT NULL,
  `account_id_users` int NOT NULL,
  `dishes_id_dish` int NOT NULL,
  PRIMARY KEY (`id_order`),
  KEY `fk_order_account1_idx` (`account_id_users`),
  KEY `fk_order_dishes1_idx` (`dishes_id_dish`),
  CONSTRAINT `fk_order_account1` FOREIGN KEY (`account_id_users`) REFERENCES `account` (`id_users`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_order_dishes1` FOREIGN KEY (`dishes_id_dish`) REFERENCES `dishes` (`id_dish`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order`
--

LOCK TABLES `order` WRITE;
/*!40000 ALTER TABLE `order` DISABLE KEYS */;
INSERT INTO `order` VALUES (1,'15:00:00','15:40:00','Оплачено','Доставлено',1,2);
/*!40000 ALTER TABLE `order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id_order` int NOT NULL AUTO_INCREMENT,
  `date_order` datetime(6) DEFAULT NULL,
  `sum_order` decimal(9,2) DEFAULT NULL,
  `users_id_user` int NOT NULL,
  PRIMARY KEY (`id_order`,`users_id_user`),
  KEY `fk_orders_users1_idx` (`users_id_user`),
  CONSTRAINT `fk_orders_users1` FOREIGN KEY (`users_id_user`) REFERENCES `users` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders_has_dishes`
--

DROP TABLE IF EXISTS `orders_has_dishes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders_has_dishes` (
  `orders_id_order` int NOT NULL,
  `dishes_id_dish` int NOT NULL,
  PRIMARY KEY (`orders_id_order`,`dishes_id_dish`),
  KEY `fk_orders_has_dishes_dishes1_idx` (`dishes_id_dish`),
  KEY `fk_orders_has_dishes_orders1_idx` (`orders_id_order`),
  CONSTRAINT `fk_orders_has_dishes_dishes1` FOREIGN KEY (`dishes_id_dish`) REFERENCES `dishes` (`id_dish`),
  CONSTRAINT `fk_orders_has_dishes_orders1` FOREIGN KEY (`orders_id_order`) REFERENCES `orders` (`id_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders_has_dishes`
--

LOCK TABLES `orders_has_dishes` WRITE;
/*!40000 ALTER TABLE `orders_has_dishes` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders_has_dishes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reservations` (
  `id_reservation` int NOT NULL AUTO_INCREMENT,
  `date_reservation` date DEFAULT NULL,
  `time_begin_reservation` time DEFAULT NULL,
  `time_end_reservation` time DEFAULT NULL,
  PRIMARY KEY (`id_reservation`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservations`
--

LOCK TABLES `reservations` WRITE;
/*!40000 ALTER TABLE `reservations` DISABLE KEYS */;
/*!40000 ALTER TABLE `reservations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tables`
--

DROP TABLE IF EXISTS `tables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tables` (
  `id_table` int NOT NULL AUTO_INCREMENT,
  `sits_table` int DEFAULT NULL,
  `status_table` enum('Занято','Свободно') DEFAULT 'Свободно',
  `price_hour_table` decimal(9,2) DEFAULT NULL,
  `reservations_id_reservation` int NOT NULL,
  PRIMARY KEY (`id_table`,`reservations_id_reservation`),
  KEY `fk_tables_reservations1_idx` (`reservations_id_reservation`),
  CONSTRAINT `fk_tables_reservations1` FOREIGN KEY (`reservations_id_reservation`) REFERENCES `reservations` (`id_reservation`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tables`
--

LOCK TABLES `tables` WRITE;
/*!40000 ALTER TABLE `tables` DISABLE KEYS */;
/*!40000 ALTER TABLE `tables` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `name_user` varchar(45) DEFAULT NULL,
  `surn_user` varchar(80) DEFAULT NULL,
  `fname_user` varchar(80) DEFAULT NULL,
  `phone_user` varchar(11) DEFAULT NULL,
  `e-mail_user` varchar(100) DEFAULT NULL,
  `hash_pw_user` varchar(150) DEFAULT NULL,
  `score_user` int DEFAULT '0',
  `role_user` enum('Администратор','Пользователь','Модератор') DEFAULT 'Пользователь',
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_has_reservations`
--

DROP TABLE IF EXISTS `users_has_reservations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users_has_reservations` (
  `users_id_user` int NOT NULL,
  `reservations_id_reservation` int NOT NULL,
  PRIMARY KEY (`users_id_user`,`reservations_id_reservation`),
  KEY `fk_users_has_reservations_reservations1_idx` (`reservations_id_reservation`),
  KEY `fk_users_has_reservations_users1_idx` (`users_id_user`),
  CONSTRAINT `fk_users_has_reservations_reservations1` FOREIGN KEY (`reservations_id_reservation`) REFERENCES `reservations` (`id_reservation`),
  CONSTRAINT `fk_users_has_reservations_users1` FOREIGN KEY (`users_id_user`) REFERENCES `users` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_has_reservations`
--

LOCK TABLES `users_has_reservations` WRITE;
/*!40000 ALTER TABLE `users_has_reservations` DISABLE KEYS */;
/*!40000 ALTER TABLE `users_has_reservations` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-05-20 18:36:51
