-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: garage_v_parrot
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `brands`
--

DROP TABLE IF EXISTS `brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `brands` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `property` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `brands`
--

LOCK TABLES `brands` WRITE;
/*!40000 ALTER TABLE `brands` DISABLE KEYS */;
INSERT INTO `brands` VALUES (1,'Acura'),(2,'Alfa Romeo'),(3,'Aston Martin'),(4,'Audi'),(5,'Bentley'),(6,'BMW'),(7,'Bugatti'),(8,'Buick'),(9,'Cadillac'),(10,'Chery'),(11,'Chevrolet'),(12,'Chrysler'),(13,'Citro√´n'),(14,'Dacia'),(15,'Daewoo'),(16,'Daihatsu'),(17,'Dodge'),(18,'Ferrari'),(19,'Fiat'),(20,'Ford'),(21,'Geely'),(22,'Genesis'),(23,'GMC'),(24,'Great Wall'),(25,'Haval'),(26,'Honda'),(27,'Hummer'),(28,'Hyundai'),(29,'Infiniti'),(30,'Isuzu'),(31,'Jaguar'),(32,'Jeep'),(33,'Kia'),(34,'Lada'),(35,'Lamborghini'),(36,'Lancia'),(37,'Land Rover'),(38,'Lexus'),(39,'Lincoln'),(40,'Lotus'),(41,'Maserati'),(42,'Mazda'),(43,'McLaren'),(44,'Mercedes-Benz'),(45,'Mercury'),(46,'MG'),(47,'Mini'),(48,'Mitsubishi'),(49,'Nissan'),(50,'Opel'),(51,'Pagani'),(52,'Peugeot'),(53,'Pontiac'),(54,'Porsche'),(55,'Proton'),(56,'Ram'),(57,'Renault'),(58,'Rolls-Royce'),(59,'Saab'),(60,'Saturn'),(61,'≈†koda'),(62,'Smart'),(63,'SsangYong'),(64,'Subaru'),(65,'Suzuki'),(66,'Tata'),(67,'Tesla'),(68,'Toyota'),(69,'Vauxhall'),(70,'Volkswagen'),(71,'Volvo'),(72,'Autres'),(73,'ZAZ');
/*!40000 ALTER TABLE `brands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cars`
--

DROP TABLE IF EXISTS `cars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cars` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `motor_technologie` int(11) DEFAULT NULL,
  `brand` int(11) DEFAULT NULL,
  `title` varchar(50) NOT NULL,
  `price` int(11) NOT NULL,
  `year` varchar(4) NOT NULL,
  `mileage` int(11) NOT NULL,
  `puissance_din` int(11) NOT NULL,
  `puissance_fiscale` int(11) NOT NULL,
  `is_automatically` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_95C71D141B37E026` (`motor_technologie`),
  KEY `IDX_95C71D141C52F958` (`brand`),
  CONSTRAINT `FK_95C71D141B37E026` FOREIGN KEY (`motor_technologie`) REFERENCES `motor_technologies` (`id`),
  CONSTRAINT `FK_95C71D141C52F958` FOREIGN KEY (`brand`) REFERENCES `brands` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cars`
--

LOCK TABLES `cars` WRITE;
/*!40000 ALTER TABLE `cars` DISABLE KEYS */;
INSERT INTO `cars` VALUES ('å‘ØUs‰ç¸]wº√NU',1,70,'Golf VII GTI',27000,'2019',42000,245,14,1),('å‘ØUs‰ç¸]wΩï}â',2,19,'Fiat 500',13000,'1992',134000,70,6,0),('å‘ØUs‰ç¸]wΩ‘ÕÀ',4,71,'Volvo XC90',22000,'2016',78000,300,16,1),('å‘ØUs‰ç¸]wæ*øO',1,7,'Bugatti Chiron',2237000,'2022',12000,1000,100,0),('å‘ØUs‰ç¸]wø1J',1,44,'AMG GTR',246000,'2022',23000,600,40,0),('å‘ØUs‰ç¸]wø∏r',2,11,'Camaro',32000,'2018',56000,400,20,0);
/*!40000 ALTER TABLE `cars` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cars_users`
--

DROP TABLE IF EXISTS `cars_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cars_users` (
  `user_id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `car_id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  PRIMARY KEY (`user_id`,`car_id`),
  KEY `IDX_8ECEF66FA76ED395` (`user_id`),
  KEY `IDX_8ECEF66FC3C6F69F` (`car_id`),
  CONSTRAINT `FK_8ECEF66FA76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `FK_8ECEF66FC3C6F69F` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cars_users`
--

LOCK TABLES `cars_users` WRITE;
/*!40000 ALTER TABLE `cars_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `cars_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctrine_migration_versions`
--

LOCK TABLES `doctrine_migration_versions` WRITE;
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `text` varchar(255) NOT NULL,
  `car_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `service_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_DB021E96C3C6F69F` (`car_id`),
  KEY `IDX_DB021E96ED5CA9E6` (`service_id`),
  CONSTRAINT `FK_DB021E96C3C6F69F` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`),
  CONSTRAINT `FK_DB021E96ED5CA9E6` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messenger_messages`
--

LOCK TABLES `messenger_messages` WRITE;
/*!40000 ALTER TABLE `messenger_messages` DISABLE KEYS */;
INSERT INTO `messenger_messages` VALUES (1,'O:36:\\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\\":2:{s:44:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\\";a:1:{s:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\";a:1:{i:0;O:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\":1:{s:55:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\\";s:21:\\\"messenger.bus.default\\\";}}}s:45:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\\";O:51:\\\"Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\\":2:{s:60:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0message\\\";O:28:\\\"Symfony\\\\Component\\\\Mime\\\\Email\\\":6:{i:0;N;i:1;N;i:2;s:265:\\\"Pour r√©initialiser votre mot de passe, veuillez cliquer sur ce lien: <a href=\\\'http://yourdomain.com/reset-password?token=8e0739ce4f30dc39d2208e46dd842a708937ba04ce61f4ab2e98df550fa535d1\\\'>R√©initialiser le mot de passe</a>. Attention, ce lien restera actif 1 heure.\\\";i:3;s:5:\\\"utf-8\\\";i:4;a:0:{}i:5;a:2:{i:0;O:37:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\\":2:{s:46:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0headers\\\";a:3:{s:4:\\\"from\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:4:\\\"From\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:25:\\\"garageparrot43@outlook.fr\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:0:\\\"\\\";}}}}s:2:\\\"to\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:2:\\\"To\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:17:\\\"vincent@parrot.fr\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:0:\\\"\\\";}}}}s:7:\\\"subject\\\";a:1:{i:0;O:48:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:7:\\\"Subject\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:55:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\0value\\\";s:39:\\\"R√©initialisation de votre mot de passe\\\";}}}s:49:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0lineLength\\\";i:76;}i:1;N;}}s:61:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0envelope\\\";N;}}','[]','default','2024-01-06 07:58:45','2024-01-06 07:58:45',NULL),(2,'O:36:\\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\\":2:{s:44:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\\";a:1:{s:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\";a:1:{i:0;O:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\":1:{s:55:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\\";s:21:\\\"messenger.bus.default\\\";}}}s:45:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\\";O:51:\\\"Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\\":2:{s:60:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0message\\\";O:28:\\\"Symfony\\\\Component\\\\Mime\\\\Email\\\":6:{i:0;N;i:1;N;i:2;s:265:\\\"Pour r√©initialiser votre mot de passe, veuillez cliquer sur ce lien: <a href=\\\'http://yourdomain.com/reset-password?token=f000924f0ed0c19f1dc3787f6bb2bafa50e5746b36879b5a614ca3bd2ac2a023\\\'>R√©initialiser le mot de passe</a>. Attention, ce lien restera actif 1 heure.\\\";i:3;s:5:\\\"utf-8\\\";i:4;a:0:{}i:5;a:2:{i:0;O:37:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\\":2:{s:46:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0headers\\\";a:3:{s:4:\\\"from\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:4:\\\"From\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:25:\\\"garageparrot43@outlook.fr\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:0:\\\"\\\";}}}}s:2:\\\"to\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:2:\\\"To\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:17:\\\"vincent@parrot.fr\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:0:\\\"\\\";}}}}s:7:\\\"subject\\\";a:1:{i:0;O:48:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:7:\\\"Subject\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:55:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\0value\\\";s:39:\\\"R√©initialisation de votre mot de passe\\\";}}}s:49:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0lineLength\\\";i:76;}i:1;N;}}s:61:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0envelope\\\";N;}}','[]','default','2024-01-06 08:00:19','2024-01-06 08:00:19',NULL);
/*!40000 ALTER TABLE `messenger_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `motor_technologies`
--

DROP TABLE IF EXISTS `motor_technologies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `motor_technologies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `property` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `motor_technologies`
--

LOCK TABLES `motor_technologies` WRITE;
/*!40000 ALTER TABLE `motor_technologies` DISABLE KEYS */;
INSERT INTO `motor_technologies` VALUES (1,'Essence'),(2,'Diesel'),(3,'√âlectrique'),(4,'Hybride'),(5,'GPL'),(6,'√âthanol'),(7,'Autres');
/*!40000 ALTER TABLE `motor_technologies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pictures`
--

DROP TABLE IF EXISTS `pictures`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pictures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `picture` varchar(255) NOT NULL,
  `is_primary` tinyint(1) NOT NULL,
  `car` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  PRIMARY KEY (`id`),
  KEY `IDX_8F7C2FC0773DE69D` (`car`),
  CONSTRAINT `FK_8F7C2FC0773DE69D` FOREIGN KEY (`car`) REFERENCES `cars` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pictures`
--

LOCK TABLES `pictures` WRITE;
/*!40000 ALTER TABLE `pictures` DISABLE KEYS */;
INSERT INTO `pictures` VALUES (1,'voiture-1-1.jpg',1,'å‘ØUs‰ç¸]wº√NU'),(2,'voiture-1-2.jpg',0,'å‘ØUs‰ç¸]wº√NU'),(3,'voiture-1-3.jpg',0,'å‘ØUs‰ç¸]wº√NU'),(4,'voiture-1-4.jpg',0,'å‘ØUs‰ç¸]wº√NU'),(5,'voiture-2-1.jpg',1,'å‘ØUs‰ç¸]wΩï}â'),(6,'voiture-2-2.jpg',0,'å‘ØUs‰ç¸]wΩï}â'),(7,'voiture-2-3.jpg',0,'å‘ØUs‰ç¸]wΩï}â'),(8,'voiture-2-4.jpg',0,'å‘ØUs‰ç¸]wΩï}â'),(9,'voiture-3-1.jpg',1,'å‘ØUs‰ç¸]wΩ‘ÕÀ'),(10,'voiture-3-2.jpg',0,'å‘ØUs‰ç¸]wΩ‘ÕÀ'),(11,'voiture-3-3.jpg',0,'å‘ØUs‰ç¸]wΩ‘ÕÀ'),(12,'voiture-3-4.jpg',0,'å‘ØUs‰ç¸]wΩ‘ÕÀ'),(13,'voiture-4-1.jpg',1,'å‘ØUs‰ç¸]wæ*øO'),(14,'voiture-4-2.jpg',0,'å‘ØUs‰ç¸]wæ*øO'),(15,'voiture-4-3.jpg',0,'å‘ØUs‰ç¸]wæ*øO'),(16,'voiture-4-4.jpg',0,'å‘ØUs‰ç¸]wæ*øO'),(17,'voiture-5-1.jpg',1,'å‘ØUs‰ç¸]wø1J'),(18,'voiture-5-2.jpg',0,'å‘ØUs‰ç¸]wø1J'),(19,'voiture-5-3.jpg',0,'å‘ØUs‰ç¸]wø1J'),(20,'voiture-5-4.jpg',0,'å‘ØUs‰ç¸]wø1J'),(21,'voiture-6-1.jpg',1,'å‘ØUs‰ç¸]wø∏r'),(22,'voiture-6-2.jpg',0,'å‘ØUs‰ç¸]wø∏r'),(23,'voiture-6-3.jpg',0,'å‘ØUs‰ç¸]wø∏r'),(24,'voiture-6-4.jpg',0,'å‘ØUs‰ç¸]wø∏r');
/*!40000 ALTER TABLE `pictures` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `text` varchar(175) NOT NULL,
  `approved` tinyint(1) NOT NULL,
  `service_id` int(11) DEFAULT NULL,
  `rate` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6970EB0FED5CA9E6` (`service_id`),
  CONSTRAINT `FK_6970EB0FED5CA9E6` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
INSERT INTO `reviews` VALUES (1,'John','Doe','Tr√®s satisfait de la r√©paration m√©canique g√©n√©rale.',1,1,5),(2,'Jane','Doe','L‚Äôentretien p√©riodique √©tait excellent.',1,2,4),(3,'Alex','Martin','Service de climatisation impeccable et rapide.',1,3,5),(4,'Sophie','Leroy','R√©paration de pneus professionnelle. Tr√®s satisfait.',1,4,4),(5,'Lucas','Dupont','Travail exceptionnel sur la carrosserie de ma voiture.',1,5,5),(6,'Emma','Durand','Achat de voiture d‚Äôoccasion tr√®s satisfaisant, service impeccable.',1,6,5);
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews_users`
--

DROP TABLE IF EXISTS `reviews_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reviews_users` (
  `user_id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `review_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`review_id`),
  KEY `IDX_1CD05D5DA76ED395` (`user_id`),
  KEY `IDX_1CD05D5D3E2E969B` (`review_id`),
  CONSTRAINT `FK_1CD05D5D3E2E969B` FOREIGN KEY (`review_id`) REFERENCES `reviews` (`id`),
  CONSTRAINT `FK_1CD05D5DA76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews_users`
--

LOCK TABLES `reviews_users` WRITE;
/*!40000 ALTER TABLE `reviews_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `reviews_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schedules`
--

DROP TABLE IF EXISTS `schedules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schedules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(100) NOT NULL,
  `day` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedules`
--

LOCK TABLES `schedules` WRITE;
/*!40000 ALTER TABLE `schedules` DISABLE KEYS */;
INSERT INTO `schedules` VALUES (1,'08:45 - 12:00 ; 13:30 - 17:15','Lundi'),(2,'08:45 - 12:00 ; 13:30 - 17:15','Mardi'),(3,'08:45 - 12:00 ; 13:30 - 17:15','Mercredi'),(4,'08:45 - 12:00 ; 13:30 - 17:15','Jeudi'),(5,'08:45 - 12:00 ; 13:30 - 17:15','Vendredi'),(6,'08:45 - 12:00','Samedi'),(7,'Ferm√©','Dimanche');
/*!40000 ALTER TABLE `schedules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schedules_users`
--

DROP TABLE IF EXISTS `schedules_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schedules_users` (
  `user_id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `schedule_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`schedule_id`),
  KEY `IDX_F4875E82A76ED395` (`user_id`),
  KEY `IDX_F4875E82A40BC2D5` (`schedule_id`),
  CONSTRAINT `FK_F4875E82A40BC2D5` FOREIGN KEY (`schedule_id`) REFERENCES `schedules` (`id`),
  CONSTRAINT `FK_F4875E82A76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedules_users`
--

LOCK TABLES `schedules_users` WRITE;
/*!40000 ALTER TABLE `schedules_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `schedules_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `text` varchar(400) NOT NULL,
  `picture` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` VALUES (1,'R√©paration de m√©canique g√©n√©rale','Notre garage offre une expertise pointue en r√©parations m√©caniques, \n            r√©solvant efficacement les probl√®mes li√©s au moteur, √† la transmission \n            et √† d\'autres composants essentiels. Nous diagnostiquons avec pr√©cision \n            et r√©parons rapidement pour vous remettre sur la route en toute s√©curit√©.','mecanique.jpg'),(2,'Entretien p√©riodique','Assurer la long√©vit√© de votre v√©hicule est notre priorit√©. \n            Notre service d\'entretien p√©riodique comprend des v√©rifications rigoureuses, \n            des changements d\'huile r√©guliers et une maintenance pr√©ventive pour garantir \n            des performances optimales et r√©duire les risques de pannes inattendues.','entretien.jpg'),(3,'Service de climatisation','La fra√Æcheur dans votre voiture est cruciale. Notre √©quipe sp√©cialis√©e \n            offre un service complet de climatisation, du diagnostic des probl√®mes de refroidissement \n            √† la r√©paration des fuites, assurant un confort optimal dans votre v√©hicule par tous les temps.','climatisation.jpg'),(4,'R√©paration et remplacement des pneus','Des pneus en bon √©tat sont essentiels pour une conduite s√ªre. \n            Nous proposons des services de r√©paration de pneus crev√©s, \n            d\'alignement, et de remplacement, avec une gamme de marques et de mod√®les pour r√©pondre \n            √† vos besoins sp√©cifiques.','pneus.jpg'),(5,'R√©paration de la carrosserie','Des bosses aux √©raflures, notre √©quipe de r√©paration de carrosserie redonne \n            √† votre v√©hicule son aspect d\'origine. Nous utilisons des techniques avanc√©es pour \n            restaurer la carrosserie, vous offrant un r√©sultat impeccable et une voiture qui brille \n            comme neuve.','carosserie.jpg'),(6,'Vente de v√©hicules d‚Äôoccasions','        Notre garage se sp√©cialise dans la vente de voitures d\'occasion de qualit√©. \r\n            Chaque v√©hicule est rigoureusement s√©lectionn√© et r√©vis√© par nos experts pour garantir \r\n            fiabilit√© et performance. Nous proposons un large choix de marques et mod√®les, \r\n            adapt√©s √† tous les budgets et besoins.','occasion.jpg');
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services_users`
--

DROP TABLE IF EXISTS `services_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `services_users` (
  `user_id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `service_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`service_id`),
  KEY `IDX_A8611FABA76ED395` (`user_id`),
  KEY `IDX_A8611FABED5CA9E6` (`service_id`),
  CONSTRAINT `FK_A8611FABA76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `FK_A8611FABED5CA9E6` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services_users`
--

LOCK TABLES `services_users` WRITE;
/*!40000 ALTER TABLE `services_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `services_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `email` varchar(255) NOT NULL,
  `password` varchar(60) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_1483A5E9E7927C74` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES ('å‘Øœ˝}áïtN•','vincent@parrot.fr','$2y$13$K9quFB7vG24VunEDtlC48Ot7sq1.cIrq4pM8.f4Aaw2Xpyv76h4Fq','Vincent','Parrot',1,'f000924f0ed0c19f1dc3787f6bb2bafa50e5746b36879b5a614ca3bd2ac2a023','2024-01-06 10:00:19');
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

-- Dump completed on 2024-01-06  9:51:23
