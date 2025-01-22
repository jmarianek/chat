-- MySQL dump 10.13  Distrib 8.0.22, for Win64 (x86_64)
--
-- Host: localhost    Database: chat
-- ------------------------------------------------------
-- Server version	8.0.22

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Temporary view structure for view `active_users`
--

DROP TABLE IF EXISTS `active_users`;
/*!50001 DROP VIEW IF EXISTS `active_users`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `active_users` AS SELECT 
 1 AS `id`,
 1 AS `login`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `posts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `msg` varchar(1000) COLLATE utf8_czech_ci NOT NULL,
  `blocked` enum('Y','N') COLLATE utf8_czech_ci NOT NULL DEFAULT 'N',
  `rooms_id` int NOT NULL,
  `users_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `posts_fk1` (`users_id`),
  KEY `posts_fk2` (`rooms_id`),
  CONSTRAINT `posts_fk1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`),
  CONSTRAINT `posts_fk2` FOREIGN KEY (`rooms_id`) REFERENCES `rooms` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (1,'Zprava od Jan','N',1,4),(2,'Dalsi zprava od Jan','N',1,4);
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rooms`
--

DROP TABLE IF EXISTS `rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rooms` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8_czech_ci NOT NULL,
  `public` enum('Y','N') COLLATE utf8_czech_ci NOT NULL DEFAULT 'N',
  `descr` varchar(1000) COLLATE utf8_czech_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rooms`
--

LOCK TABLES `rooms` WRITE;
/*!40000 ALTER TABLE `rooms` DISABLE KEYS */;
INSERT INTO `rooms` VALUES (1,'room1','Y','Místnost pro všechny'),(3,'room2','N','Místnost 2');
/*!40000 ALTER TABLE `rooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8_czech_ci DEFAULT NULL,
  `surname` varchar(50) COLLATE utf8_czech_ci DEFAULT NULL,
  `passwd` varchar(32) COLLATE utf8_czech_ci NOT NULL,
  `login` varchar(20) COLLATE utf8_czech_ci NOT NULL,
  `role` enum('admin','moderator','user') COLLATE utf8_czech_ci NOT NULL DEFAULT 'user',
  `blocked` enum('Y','N') COLLATE utf8_czech_ci NOT NULL DEFAULT 'N',
  `avatar` varchar(50) COLLATE utf8_czech_ci DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `age` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`),
  KEY `users_idx1` (`surname`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,NULL,NULL,'827ccb0eea8a706c4c34a16891f84e7b','admin','admin','N',NULL,'2024-11-20 07:29:09',20),(4,'Jan','Novak','827ccb0eea8a706c4c34a16891f84e7b','jnovak','user','N',NULL,'2024-11-20 07:29:09',25),(5,NULL,NULL,'827ccb0eea8a706c4c34a16891f84e7b','icerny','user','N',NULL,'2024-11-20 09:03:48',NULL),(6,NULL,NULL,'827ccb0eea8a706c4c34a16891f84e7b','mjasek','user','N',NULL,'2024-11-20 09:05:08',NULL),(7,NULL,'Vesela','827ccb0eea8a706c4c34a16891f84e7b','vesela','user','N',NULL,'2024-12-11 08:11:45',NULL),(8,'Alena','Vesela','827ccb0eea8a706c4c34a16891f84e7b','avesela','user','N',NULL,'2024-12-11 08:25:20',NULL),(9,'Pavel','Stary','827ccb0eea8a706c4c34a16891f84e7b','pstary','user','Y',NULL,'2024-12-11 08:32:16',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `user_created` BEFORE INSERT ON `users` FOR EACH ROW begin
    set new.created = now(); -- aktualni datum do created
    set new.blocked = 'Y'; -- zablokujeme noveho uziv.
end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `users_rooms`
--

DROP TABLE IF EXISTS `users_rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users_rooms` (
  `users_id` int NOT NULL,
  `rooms_id` int NOT NULL,
  KEY `fk_users_rooms_users_idx` (`users_id`),
  KEY `fk_users_rooms_rooms1_idx` (`rooms_id`),
  CONSTRAINT `fk_users_rooms_rooms1` FOREIGN KEY (`rooms_id`) REFERENCES `rooms` (`id`),
  CONSTRAINT `fk_users_rooms_users` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_rooms`
--

LOCK TABLES `users_rooms` WRITE;
/*!40000 ALTER TABLE `users_rooms` DISABLE KEYS */;
/*!40000 ALTER TABLE `users_rooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `view_posts`
--

DROP TABLE IF EXISTS `view_posts`;
/*!50001 DROP VIEW IF EXISTS `view_posts`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_posts` AS SELECT 
 1 AS `id`,
 1 AS `login`,
 1 AS `msg`,
 1 AS `rooms_id`*/;
SET character_set_client = @saved_cs_client;

--
-- Final view structure for view `active_users`
--

/*!50001 DROP VIEW IF EXISTS `active_users`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `active_users` AS select `u`.`id` AS `id`,`u`.`login` AS `login` from `users` `u` where exists(select `posts`.`id` from `posts` where (`posts`.`users_id` = `u`.`id`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_posts`
--

/*!50001 DROP VIEW IF EXISTS `view_posts`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_posts` AS select `u`.`id` AS `id`,`u`.`login` AS `login`,`p`.`msg` AS `msg`,`p`.`rooms_id` AS `rooms_id` from (`users` `u` left join `posts` `p` on((`u`.`id` = `p`.`users_id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-12-18  9:03:45
