-- MySQL dump 10.13  Distrib 5.7.21, for Linux (x86_64)
--
-- Host: localhost    Database: sysblog
-- ------------------------------------------------------
-- Server version	5.7.21-0ubuntu0.16.04.1-log

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
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Kushagra','mamax','$2y$10$nb9HvZDqvSnJIgznnzZv3.QeuejXx/pbzq30N1jl/akdNeC6vTXFm',NULL,NULL,'2018-04-21 08:42:40'),(2,'Ets','sd@ff.com','$2y$10$nqutJjpe3KcgevvXHJ5w/uUWmxMa.1YLg733IWml0Q1pbTFxOJsUe',NULL,NULL,NULL),(3,'8eoie','aksdk@ff.com','$2y$10$U37KdBfxpXbJt0dkKqfKYeRVNyrX3a/vAZOXd3PV01tDYdPi2oQHi',NULL,NULL,NULL),(23,'Kushagra Mishra','danish.mehra.crazy@gmail.com','$2y$10$tzWHCt/N.kS/AHFWLtnB8elR4HH0V6.z2QCWAxxk4n38nOMKV1PZe',NULL,'2018-04-21 01:37:55','2018-04-21 01:37:55'),(24,'Kushagra Mishra','karizmatic.kay@gmail.com','$2y$10$2GEHBTE.vYhUklw3OKecyuuPa3UWWugw1wuAEZPaNfxK3IPo/QBwm','NUdrCuydSFwqCiZ93j7xoasjGlSKE0ERnMrfbdoe9wfnWXMvDyouzTEvXELY','2018-04-21 01:44:24','2018-04-23 09:13:25'),(41,'kushagra','kaka','',NULL,'2018-04-21 08:39:54','2018-04-21 08:39:54'),(42,'kushagra','mamaz','',NULL,'2018-04-21 08:40:31','2018-04-21 08:44:03'),(44,'kushagra','mamas','',NULL,'2018-04-21 08:45:13','2018-04-21 08:45:13'),(45,'Random name','randomEmail@gmail.com','Random Password',NULL,'2018-04-22 02:04:35','2018-04-22 02:04:35'),(46,'Random name','random20Email@gmail.com','Random Password',NULL,'2018-04-22 02:10:03','2018-04-22 02:10:03'),(48,'Random name','random30Email@gmail.com','Random Password',NULL,'2018-04-22 02:11:07','2018-04-22 02:11:07'),(49,'Random name','random40Email@gmail.com','Random Password',NULL,'2018-04-22 03:30:10','2018-04-22 03:30:10');
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

-- Dump completed on 2018-04-27 23:09:29
