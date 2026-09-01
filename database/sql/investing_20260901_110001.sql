-- MySQL dump 10.13  Distrib 8.0.46, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: investing_db
-- ------------------------------------------------------
-- Server version	8.0.46-0ubuntu0.24.04.3

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
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
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
-- Table structure for table `deposits`
--

DROP TABLE IF EXISTS `deposits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `deposits` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `deposit_date` date NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `deposits_user_id_foreign` (`user_id`),
  CONSTRAINT `deposits_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deposits`
--

LOCK TABLES `deposits` WRITE;
/*!40000 ALTER TABLE `deposits` DISABLE KEYS */;
INSERT INTO `deposits` VALUES (1,1,100000.00,'2025-01-01',NULL,'2026-08-02 14:03:58','2026-08-02 14:03:58'),(2,1,10000.00,'2026-01-01',NULL,'2026-08-02 14:04:11','2026-08-02 14:04:11');
/*!40000 ALTER TABLE `deposits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
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
-- Table structure for table `financial_reports`
--

DROP TABLE IF EXISTS `financial_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `financial_reports` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `stock_id` bigint unsigned NOT NULL,
  `period_a_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `period_a_year` smallint unsigned DEFAULT NULL,
  `period_a_month` tinyint unsigned DEFAULT NULL,
  `period_a_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `period_b_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `period_b_year` smallint unsigned DEFAULT NULL,
  `period_b_month` tinyint unsigned DEFAULT NULL,
  `period_b_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revenue_a` decimal(20,6) DEFAULT NULL,
  `revenue_b` decimal(20,6) DEFAULT NULL,
  `revenue_note` text COLLATE utf8mb4_unicode_ci,
  `gross_profit_a` decimal(20,6) DEFAULT NULL,
  `gross_profit_b` decimal(20,6) DEFAULT NULL,
  `gross_profit_note` text COLLATE utf8mb4_unicode_ci,
  `net_profit_a` decimal(20,6) DEFAULT NULL,
  `net_profit_b` decimal(20,6) DEFAULT NULL,
  `net_profit_note` text COLLATE utf8mb4_unicode_ci,
  `eps_a` decimal(20,6) DEFAULT NULL,
  `eps_b` decimal(20,6) DEFAULT NULL,
  `eps_note` text COLLATE utf8mb4_unicode_ci,
  `summary_notes` longtext COLLATE utf8mb4_unicode_ci,
  `enable_projection` tinyint(1) NOT NULL DEFAULT '0',
  `projection_multiplier` decimal(8,2) NOT NULL DEFAULT '2.00',
  `operating_profit` decimal(20,6) DEFAULT NULL,
  `operating_margin` decimal(20,6) DEFAULT NULL,
  `net_margin` decimal(20,6) DEFAULT NULL,
  `book_value` decimal(20,6) DEFAULT NULL,
  `cash_balance` decimal(20,6) DEFAULT NULL,
  `total_assets` decimal(20,6) DEFAULT NULL,
  `total_liabilities` decimal(20,6) DEFAULT NULL,
  `shareholders_equity` decimal(20,6) DEFAULT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `financial_reports_stock_id_foreign` (`stock_id`),
  KEY `financial_reports_created_by_foreign` (`created_by`),
  KEY `financial_reports_updated_by_foreign` (`updated_by`),
  CONSTRAINT `financial_reports_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `financial_reports_stock_id_foreign` FOREIGN KEY (`stock_id`) REFERENCES `stocks` (`id`) ON DELETE CASCADE,
  CONSTRAINT `financial_reports_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financial_reports`
--

LOCK TABLES `financial_reports` WRITE;
/*!40000 ALTER TABLE `financial_reports` DISABLE KEYS */;
INSERT INTO `financial_reports` VALUES (1,169,'half_year',2026,6,'june-2026','year',2025,NULL,'2025',1063094727.000000,1292867767.000000,NULL,96945448.000000,125626148.000000,NULL,43101963.000000,62103726.000000,NULL,1.080000,1.230000,NULL,'<p></p>',0,2.00,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1,'2026-08-23 13:33:16','2026-08-23 13:50:58'),(2,96,'quarter',2026,3,'march-2026','year',2025,12,'2025',11168750.000000,65927409.000000,NULL,978697.000000,-583476.000000,NULL,11895501.000000,-20258460.000000,NULL,0.260000,-0.300000,NULL,'<p></p>',1,4.00,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1,'2026-08-25 13:24:29','2026-08-25 15:09:08'),(3,118,'half_year',2026,6,'june-2026','year',2025,12,'2025',1951064802.000000,3686669262.000000,NULL,143673886.000000,182304277.000000,NULL,194005057.000000,254734532.000000,NULL,1.340000,1.760000,NULL,'<p></p>',0,2.00,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1,'2026-08-27 09:41:03','2026-08-27 09:49:19'),(4,69,'half_year',2026,6,'june-2026','year',2025,12,'2025',99053055.000000,200176136.000000,NULL,19151688.000000,35934261.000000,NULL,6533784.000000,8861535.000000,NULL,0.020000,0.026000,NULL,'<p></p>',0,2.00,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1,'2026-08-27 09:58:55','2026-08-27 10:00:08'),(5,130,'half_year',2026,6,'june-2026','year',2025,6,'2025',17677935781.000000,29984446222.000000,NULL,4325772331.000000,6880884167.000000,NULL,1765844357.000000,2404498163.000000,NULL,1.170000,1.380000,NULL,'<p></p>',0,2.00,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1,'2026-08-27 10:46:34','2026-08-27 10:46:34'),(6,234,'half_year',2026,6,'june-2026','year',2025,12,'2025',651998583.000000,768416855.000000,NULL,588192462.000000,700190319.000000,NULL,626056196.000000,916677849.000000,NULL,0.400000,0.590000,NULL,'<p></p>',0,2.00,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1,'2026-08-27 10:56:33','2026-08-27 10:56:33'),(7,113,'half_year',2026,6,'june-2026','year',2025,12,'2025',189778637.000000,709951321.000000,NULL,69681760.000000,90962741.000000,NULL,54442981.000000,51511913.000000,NULL,0.570000,0.960000,NULL,'<p></p>',0,2.00,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1,'2026-08-27 11:07:51','2026-08-27 11:07:51'),(8,171,'half_year',2026,6,'june-2026','year',2025,12,'2025',820615681.000000,1482839619.000000,NULL,352478553.000000,619510103.000000,NULL,192453759.000000,242912200.000000,NULL,11.990000,17.140000,NULL,'<p></p>',0,2.00,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1,'2026-08-29 13:46:04','2026-08-29 14:10:23');
/*!40000 ALTER TABLE `financial_reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
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
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
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
-- Table structure for table `media`
--

DROP TABLE IF EXISTS `media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `media` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `collection_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `conversions_disk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` bigint unsigned NOT NULL,
  `manipulations` json NOT NULL,
  `custom_properties` json NOT NULL,
  `generated_conversions` json NOT NULL,
  `responsive_images` json NOT NULL,
  `order_column` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `media_uuid_unique` (`uuid`),
  KEY `media_model_type_model_id_index` (`model_type`,`model_id`),
  KEY `media_order_column_index` (`order_column`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media`
--

LOCK TABLES `media` WRITE;
/*!40000 ALTER TABLE `media` DISABLE KEYS */;
/*!40000 ALTER TABLE `media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_01_26_140835_create_deposits_table',1),(5,'2026_01_26_140836_create_withdrawals_table',1),(6,'2026_01_26_143201_add_avatar_to_users_table',1),(7,'2026_01_26_143312_create_media_table',1),(8,'2026_05_07_000000_create_stocks_table',1),(9,'2026_05_07_131708_create_trades_table',1),(10,'2026_05_07_141328_create_trade_tracks_table',1),(11,'2026_05_10_000000_create_wallets_table',1),(12,'2026_06_03_162525_add_year_to_trades_table',1),(13,'2026_06_04_000000_create_sectors_table',1),(14,'2026_06_04_000001_add_sector_id_to_stocks_table',1),(15,'2026_08_02_000000_create_stock_fee_settings_table',1),(16,'2026_08_03_000000_add_tax_rates_to_stock_fee_settings_table',2),(17,'2026_08_03_100000_add_fra_fee_minimum_to_stock_fee_settings_table',3),(18,'2026_08_03_200000_rename_egx_fee_to_risk_fund_fee_in_stock_fee_settings_table',4),(19,'2026_08_18_165038_add_closed_at_to_trades_table',5),(20,'2026_08_23_170000_create_financial_reports_table',6),(22,'2026_08_26_000000_create_wallet_logs_table',7);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
-- Table structure for table `sectors`
--

DROP TABLE IF EXISTS `sectors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sectors` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_ar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sectors_name_unique` (`name`),
  UNIQUE KEY `sectors_name_ar_unique` (`name_ar`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sectors`
--

LOCK TABLES `sectors` WRITE;
/*!40000 ALTER TABLE `sectors` DISABLE KEYS */;
INSERT INTO `sectors` VALUES (1,'Banks','بنوك','2026-08-02 14:00:07','2026-08-02 14:00:07'),(2,'Basic Resources','موارد أساسية','2026-08-02 14:00:07','2026-08-02 14:00:07'),(3,'Healthcare & Pharmaceuticals','رعاية صحية و ادوية','2026-08-02 14:00:07','2026-08-02 14:00:07'),(4,'Industrial Products & Services & Automobiles','خدمات و منتجات صناعية وسيارات','2026-08-02 14:00:07','2026-08-02 14:00:07'),(5,'Real Estate','عقارات','2026-08-02 14:00:07','2026-08-02 14:00:07'),(6,'Tourism & Recreation','سياحة وترفيه','2026-08-02 14:00:07','2026-08-02 14:00:07'),(7,'Utilities','مرافق','2026-08-02 14:00:07','2026-08-02 14:00:07'),(8,'Telecommunications & Media & IT','اتصالات و اعلام و تكنولوجيا المعلومات','2026-08-02 14:00:07','2026-08-02 14:00:07'),(9,'Food, Beverages & Tobacco','أغذية و مشروبات و تبغ','2026-08-02 14:00:07','2026-08-02 14:00:07'),(10,'Energy & Support Services','طاقة وخدمات مساندة','2026-08-02 14:00:07','2026-08-02 14:00:07'),(11,'Trade & Distribution','تجارة و موزعون','2026-08-02 14:00:07','2026-08-02 14:00:07'),(12,'Transportation & Shipping Services','خدمات النقل والشحن','2026-08-02 14:00:07','2026-08-02 14:00:07'),(13,'Educational Services','خدمات تعليمية','2026-08-02 14:00:07','2026-08-02 14:00:07'),(14,'Non-Banking Financial Services','خدمات مالية غير مصرفية','2026-08-02 14:00:07','2026-08-02 14:00:07'),(15,'Contracting & Engineering Construction','مقاولات و إنشاءات هندسية','2026-08-02 14:00:07','2026-08-02 14:00:07'),(16,'Textiles & Durable Goods','منسوجات و سلع معمرة','2026-08-02 14:00:07','2026-08-02 14:00:07'),(17,'Building Materials','مواد البناء','2026-08-02 14:00:07','2026-08-02 14:00:07'),(18,'Paper, Packaging & Wrapping Materials','ورق ومواد تعبئة و تغليف','2026-08-02 14:00:07','2026-08-02 14:00:07'),(19,'Nile Stock Exchange','بورصة النيل','2026-08-02 14:39:43','2026-08-02 14:39:43'),(20,'صناديق','صناديق','2026-08-02 16:56:06','2026-08-02 16:56:06');
/*!40000 ALTER TABLE `sectors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
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
INSERT INTO `sessions` VALUES ('SpwDZEO77amG1MxqlVYvrsWm7I9HyW4FzKCgZu32',1,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36','YTo3OntzOjY6Il90b2tlbiI7czo0MDoiVmVHdzl6SmNDaXQ0YmYxMG82cXk1ank0YjUzaXdFUmpuSWg2enlIRSI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2NDoiYmQxZDYwOGIyZTFjOGQzOGZmNDQ0NmQ2YzZjOTEzNDZjYjRjNDBkYTBjM2UyZmU4ZTkwYmQwOWYyM2I0NThlMSI7czo2OiJ0YWJsZXMiO2E6Mjp7czo0MDoiOTYyMjFlZDg3ZGU5OGViYTJhNzU3NWEyNTZhZWQxYTdfY29sdW1ucyI7YTo3OntpOjA7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTA6InN0b2NrLm5hbWUiO3M6NToibGFiZWwiO3M6MTA6Itin2YTYs9mH2YUiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToxO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjY6ImFtb3VudCI7czo1OiJsYWJlbCI7czoxMjoi2KfZhNmF2KjZhNi6IjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MjthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMzoiY3VycmVudF90b3RhbCI7czo1OiJsYWJlbCI7czoyOToi2KfZhNil2KzZhdin2YTZiiDYp9mE2K3Yp9mE2YoiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTozO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjE5OiJ0b3RhbF90cmFkZXNfYW1vdW50IjtzOjU6ImxhYmVsIjtzOjI3OiLZhdio2YTYuiDYp9mE2KrYr9in2YjZhNin2KoiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo0O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjExOiJwcm9maXRfbG9zcyI7czo1OiJsYWJlbCI7czoyNToi2KfZhNix2KjYrS/Yp9mE2K7Ys9in2LHYqSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjU7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6Njoic3RhdHVzIjtzOjU6ImxhYmVsIjtzOjEyOiLYp9mE2K3Yp9mE2KkiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo2O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEwOiJjcmVhdGVkX2F0IjtzOjU6ImxhYmVsIjtzOjI1OiLYqtin2LHZitiuINin2YTYpdmG2LTYp9ihIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fX1zOjQwOiI3MmU2NzM5MjRmMGI1YzgyNDQ4ZDZhMTdmMTVhZDE2Zl9jb2x1bW5zIjthOjc6e2k6MDthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMDoiY3JlYXRlZF9hdCI7czo1OiJsYWJlbCI7czoxNDoi2KfZhNiq2KfYsdmK2K4iO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToxO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjY6ImFjdGlvbiI7czo1OiJsYWJlbCI7czoxNDoi2KfZhNil2KzYsdin2KEiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToyO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjE2OiJ0cmFuc2FjdGlvbl90eXBlIjtzOjU6ImxhYmVsIjtzOjEwOiLYp9mE2YbZiNi5IjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MzthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo2OiJhbW91bnQiO3M6NToibGFiZWwiO3M6Mzg6Itin2YTZhdio2YTYuiAvINiq2LrZitixINin2YTZhtmC2K/ZitipIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NDthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMToiY2FzaF9iZWZvcmUiO3M6NToibGFiZWwiO3M6MjM6Itil2KzZhdin2YTZiiDYp9mE2YbZgtivIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxNzoic2F2ZV9jbG91ZF9iZWZvcmUiO3M6NToibGFiZWwiO3M6Mzg6Itil2KzZhdin2YTZiiDYp9mE2K3Zgdi4INin2YTYs9it2KfYqNmKIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NjthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxNDoidHJhZGVfdHJhY2tfaWQiO3M6NToibGFiZWwiO3M6MjE6Itiq2KrYqNi5INin2YTYtdmB2YLYqSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO319fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjI3OiJodHRwOi8vaW52ZXN0aW5nLnRlc3QvYWRtaW4iO3M6NToicm91dGUiO3M6MzA6ImZpbGFtZW50LmFkbWluLnBhZ2VzLmRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6ODoiZmlsYW1lbnQiO2E6MDp7fX0=',1788184695);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stock_fee_settings`
--

DROP TABLE IF EXISTS `stock_fee_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `stock_fee_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `thunder_percentage` double DEFAULT NULL,
  `thunder_fixed_fee` double DEFAULT NULL,
  `exchange_fee_percentage` double DEFAULT NULL,
  `risk_fund_fee_percentage` double DEFAULT NULL,
  `misr_clearing_fee_percentage` double DEFAULT NULL,
  `fra_fee_percentage` double DEFAULT NULL,
  `fra_fee_minimum` double DEFAULT '1',
  `tax_t0_percentage` double DEFAULT '0.025',
  `tax_t1_t2_percentage` double DEFAULT '0.05',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stock_fee_settings`
--

LOCK TABLES `stock_fee_settings` WRITE;
/*!40000 ALTER TABLE `stock_fee_settings` DISABLE KEYS */;
INSERT INTO `stock_fee_settings` VALUES (1,0.1,2,0.01,0.005,0.01,0.005,1,0.025,0.05,'2026-08-02 14:23:29','2026-08-03 13:39:41');
/*!40000 ALTER TABLE `stock_fee_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stocks`
--

DROP TABLE IF EXISTS `stocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `stocks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `market` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'EGx',
  `price` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sector_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `stocks_code_unique` (`code`),
  KEY `stocks_sector_id_foreign` (`sector_id`),
  CONSTRAINT `stocks_sector_id_foreign` FOREIGN KEY (`sector_id`) REFERENCES `sectors` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=237 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stocks`
--

LOCK TABLES `stocks` WRITE;
/*!40000 ALTER TABLE `stocks` DISABLE KEYS */;
INSERT INTO `stocks` VALUES (1,'العامة لاستصلاح الأراضي والتنمية والتعمير','AALR','EGx',305.09,'2026-08-02 14:01:38','2026-08-31 12:23:30',15),(2,'أبو قير للأسمدة و الصناعات الكيماوية','ABUK','EGx',80.9,'2026-08-02 14:01:38','2026-08-31 12:23:31',2),(3,'الشركة العربية لإدارة وتطوير الأصول','ACAMD','EGx',2,'2026-08-02 14:01:38','2026-08-31 12:23:32',5),(4,'ايه كابيتال القابضة','ACAP','EGx',8.83,'2026-08-02 14:01:38','2026-08-31 12:23:33',14),(5,'العربية لحليج الأقطان','ACGC','EGx',14.14,'2026-08-02 14:01:38','2026-08-31 12:23:34',16),(7,'أكت فاينانشال للاستشارات ش م م','ACTF','EGx',2.7,'2026-08-02 14:01:38','2026-08-31 12:23:35',14),(8,'العربية للأدوية والصناعات الكيماوية','ADCI','EGx',299.74,'2026-08-02 14:01:38','2026-08-31 12:23:35',3),(9,'مصرف أبو ظبي الإسلامي - مصر','ADIB','EGx',54.69,'2026-08-02 14:01:38','2026-08-31 12:23:36',1),(10,'العربية لمنتجات الألبان','ADPC','EGx',3.88,'2026-08-02 14:01:38','2026-08-31 12:23:36',9),(11,'آراب للتنمية والاستثمار العقاري','ADRI','EGx',9.47,'2026-08-02 14:01:38','2026-08-31 12:23:37',5),(12,'الأهلي للتنمية والاستثمار','AFDI','EGx',56.21,'2026-08-02 14:01:38','2026-08-31 12:23:38',14),(13,'مطاحن ومخابز الإسكندرية','AFMC','EGx',175.2,'2026-08-02 14:01:38','2026-08-31 12:23:39',9),(14,'ارابيا انفستمنتس هولدنج','AIDC','EGx',0.76,'2026-08-02 14:01:38','2026-08-31 12:23:39',14),(15,'أطلس للاستثمار والصناعات الغذائية','AIFI','EGx',2.42,'2026-08-02 14:01:38','2026-08-31 12:23:40',9),(16,'ارابيا انفستمنتس هولدنج','AIHC','EGx',0.35,'2026-08-02 14:01:38','2026-08-02 17:28:25',14),(17,'أجواء للصناعات الغذائية - مصر','AJWA','EGx',180.2,'2026-08-02 14:01:38','2026-08-31 12:23:41',9),(18,'الاسكندرية لتداول الحاويات والبضائع','ALCN','EGx',30.05,'2026-08-02 14:01:38','2026-08-31 12:23:42',12),(19,'الألومنيوم العربية','ALUM','EGx',28.5,'2026-08-02 14:01:38','2026-08-31 12:23:42',2),(20,'مجموعة عامر القابضة','AMER','EGx',5.72,'2026-08-02 14:01:38','2026-08-31 12:23:43',5),(21,'الإسكندرية للخدمات الطبية المركز الطبي الجديد','AMES','EGx',130.73,'2026-08-02 14:01:38','2026-08-31 12:23:43',9),(22,'الملتقى العربي للاستثمارات','AMIA','EGx',19.34,'2026-08-02 14:01:38','2026-08-31 12:23:44',14),(23,'الاسكندرية للزيوت المعدنية','AMOC','EGx',12.25,'2026-08-02 14:01:38','2026-08-31 12:23:45',10),(24,'نوفيدا للاستثمار والتكنولوجيا','AMPI','EGx',2.92,'2026-08-02 14:01:38','2026-08-31 12:23:45',19),(25,'العربية وبولفارا للغزل والنسيج','APSW','EGx',8.68,'2026-08-02 14:01:38','2026-08-31 12:23:46',16),(26,'المطورون العرب القابضة','ARAB','EGx',0.255,'2026-08-02 14:01:38','2026-08-31 12:23:47',5),(27,'العربية للأسمنت','ARCC','EGx',77,'2026-08-02 14:01:38','2026-08-31 12:23:47',17),(28,'المجموعة المصرية العقارية','AREH','EGx',1.42,'2026-08-02 14:01:38','2026-08-31 12:23:48',5),(29,'العربية للمحابس','ARVA','EGx',9.05,'2026-08-02 14:01:38','2026-08-02 14:02:25',17),(30,'أسيك للتعدين','ASCM','EGx',63.51,'2026-08-02 14:01:38','2026-08-31 12:23:49',2),(31,'اسباير كابيتال القابضة للاستثمارات المالية','ASPI','EGx',0.452,'2026-08-02 14:01:38','2026-08-31 12:23:50',14),(32,'التوفيق للتأجير التمويلي','ATLC','EGx',5.67,'2026-08-02 14:01:38','2026-08-31 12:23:51',14),(33,'مصر الوطنية للصلب','ATQA','EGx',11.91,'2026-08-02 14:01:38','2026-08-31 12:23:51',2),(34,'الاسكندرية للأدوية والصناعات الكيماوية','AXPH','EGx',1702.93,'2026-08-02 14:01:38','2026-08-31 12:23:52',3),(35,'بي إنفستمنتس القابضة','BINV','EGx',52,'2026-08-02 14:01:38','2026-08-31 12:23:53',14),(36,'جلاكسو سميثكلاين','BIOC','EGx',340.72,'2026-08-02 14:01:38','2026-08-31 12:23:54',3),(37,'بنيان للتنمية والتجارة','BONY','EGx',4.5,'2026-08-02 14:01:38','2026-08-31 12:23:54',5),(38,'بلتون المالية القابضة','BTFH','EGx',2.97,'2026-08-02 14:01:38','2026-08-31 12:23:55',14),(39,'بنك قناة السويس','CANA','EGx',41.61,'2026-08-02 14:01:38','2026-08-31 12:23:57',1),(40,'القاهرة للخدمات التعليمية','CAED','EGx',140.97,'2026-08-02 14:01:38','2026-08-31 12:23:56',13),(41,'شركة القلعة للاستشارات المالية ش.م.م','CCAP','EGx',6.05,'2026-08-02 14:01:38','2026-08-31 12:23:57',14),(42,'الخليجية الكندية للاستثمار العقاري العربي','CCRS','EGx',2.6,'2026-08-02 14:01:38','2026-08-31 12:23:58',5),(43,'مطاحن مصر الوسطى','CEFM','EGx',143.86,'2026-08-02 14:01:38','2026-08-31 12:23:59',9),(44,'العربية للخزف سيراميكا','CERA','EGx',1.24,'2026-08-02 14:01:38','2026-08-31 12:23:59',17),(45,'العرفة للاستثمارات والاستشارات','CFGH','EGx',0.118,'2026-08-02 14:01:38','2026-08-31 12:24:00',14),(46,'سي آي كابيتال القابضة للاستثمارات المالية','CICH','EGx',12.24,'2026-08-02 14:01:38','2026-08-31 12:24:00',14),(47,'بنك كريدي أجريكول مصر','CIEB','EGx',25.45,'2026-08-02 14:01:38','2026-08-31 12:24:01',1),(48,'القاهرة للاستثمار والتنمية العقارية','CIRA','EGx',32.57,'2026-08-02 14:01:38','2026-08-31 12:24:01',14),(49,'شركة مستشفي كليوباترا','CLHO','EGx',17.9,'2026-08-02 14:01:38','2026-08-31 12:24:02',3),(50,'كونتكت المالية القابضة','CNFN','EGx',4.85,'2026-08-02 14:01:38','2026-08-31 12:24:03',14),(51,'البنك التجاري الدولي (مصر)','COMI','EGx',136.3,'2026-08-02 14:01:38','2026-08-31 12:24:03',1),(52,'كوبر للاستثمار التجاري والتطوير العقاري','COPR','EGx',0.515,'2026-08-02 14:01:38','2026-08-31 12:24:04',15),(53,'القاهره للزيوت والصابون','COSG','EGx',1.82,'2026-08-02 14:01:38','2026-08-31 12:24:05',9),(54,'القاهرة للأدوية والصناعات الكيماوية','CPCI','EGx',548.1,'2026-08-02 14:01:38','2026-08-31 12:24:06',3),(55,'كريست مارك للمقاولات والتطوير العقاري','CRST','EGx',3,'2026-08-02 14:01:38','2026-08-31 12:24:06',15),(56,'القناة للتوكيلات الملاحية','CSAG','EGx',41.36,'2026-08-02 14:01:38','2026-08-31 12:24:07',12),(57,'التعمير والاستشارات الهندسية','DAPH','EGx',134.05,'2026-08-02 14:01:38','2026-08-31 12:24:08',5),(58,'الدلتا للتأمين','DEIN','EGx',10.35,'2026-08-02 14:01:38','2026-08-05 14:59:05',3),(59,'ديجيتايز للاستثمار والتقنية','DGTZ','EGx',2.54,'2026-08-02 14:01:38','2026-08-31 12:24:09',8),(60,'الصناعات الغذائية العربية','DOMT','EGx',28.41,'2026-08-02 14:01:38','2026-08-31 12:24:09',9),(61,'دايس للملابس الجاهزة','DSCW','EGx',1.92,'2026-08-02 14:01:38','2026-08-31 12:24:10',16),(62,'دلتا للطباعة والتغليف','DTPP','EGx',308.11,'2026-08-02 14:01:38','2026-08-31 12:24:11',4),(63,'العربية لاستصلاح الاراضي','EALR','EGx',395.05,'2026-08-02 14:01:38','2026-08-31 12:24:11',15),(64,'المصرية العربية ثمار لتداول الأوراق المالية','EASB','EGx',7.68,'2026-08-02 14:01:38','2026-08-31 12:24:12',14),(65,'الشرقية - ايسترن كومباني','EAST','EGx',35.8,'2026-08-02 14:01:38','2026-08-31 12:24:12',9),(66,'اصول إى إس بى للوساطة في الاوراق المالية','EBSC','EGx',2.17,'2026-08-02 14:01:38','2026-08-31 12:24:13',14),(67,'العز للسيراميك والبورسلين','ECAP','EGx',32.28,'2026-08-02 14:01:38','2026-08-31 12:24:13',17),(68,'مطاحن شرق الدلتا','EDFM','EGx',405.15,'2026-08-02 14:01:38','2026-08-31 12:24:14',9),(69,'العربية للصناعات الهندسية','EEII','EGx',3.02,'2026-08-02 14:01:38','2026-08-31 12:24:15',4),(70,'المالية والصناعية المصرية','EFIC','EGx',199.08,'2026-08-02 14:01:38','2026-08-31 12:24:16',2),(71,'إيديتا للصناعات الغذائية','EFID','EGx',30.5,'2026-08-02 14:01:38','2026-08-31 12:24:16',9),(72,'اي فاينانس للاستثمارات المالية والرقمية','EFIH','EGx',22.9,'2026-08-02 14:01:38','2026-08-31 12:24:17',8),(73,'مصر للالومنيوم','EGAL','EGx',360,'2026-08-02 14:01:38','2026-08-31 12:24:17',2),(74,'غاز مصر','EGAS','EGx',58.95,'2026-08-02 14:01:38','2026-08-31 12:24:18',7),(75,'البنك المصري الخليجي','EGBE','EGx',0.53,'2026-08-02 14:01:38','2026-08-31 12:24:19',1),(76,'الصناعات الكيماوية المصرية','EGCH','EGx',13.81,'2026-08-02 14:01:38','2026-08-31 12:24:19',2),(77,'صندوق المصريين للاستثمار العقاري','EGREF','EGx',33.25,'2026-08-02 14:01:38','2026-08-31 12:24:20',14),(78,'المصرية للأقمار الصناعية','EGSA','EGx',8.69,'2026-08-02 14:01:38','2026-08-20 11:50:50',8),(79,'المصرية للمنتجعات السياحية','EGTS','EGx',17.16,'2026-08-02 14:01:38','2026-08-31 12:24:22',6),(80,'المصريين للاسكان والتنمية والتعمير','EHDR','EGx',2.83,'2026-08-02 14:01:38','2026-08-31 12:24:22',5),(81,'الكابلات الكهربائية المصرية','ELEC','EGx',2.08,'2026-08-02 14:01:38','2026-08-31 12:24:23',4),(82,'القاهرة للإسكان والتعمير','ELKA','EGx',1.85,'2026-08-02 14:01:38','2026-08-31 12:24:24',5),(83,'النصر لتصنيع الحاصلات الزراعية','ELNA','EGx',37,'2026-08-02 14:01:38','2026-08-30 11:50:52',9),(84,'الشمس للإسكان والتعمير','ELSH','EGx',13.52,'2026-08-02 14:01:38','2026-08-31 12:24:25',5),(85,'الوادى العالمية للاستثمار و التنمية','ELWA','EGx',1.87,'2026-08-02 14:01:38','2026-08-31 12:24:26',6),(86,'إعمار مصر للتنمية','EMFD','EGx',13,'2026-08-02 14:01:38','2026-08-31 12:24:26',5),(87,'الصناعات الهندسية المعمارية للانشاء والتعمير','ENGC','EGx',43.4,'2026-08-02 14:01:38','2026-08-31 12:24:27',15),(88,'العروبة للسمسرة في الاوراق المالية','EOSB','EGx',1.57,'2026-08-02 14:01:38','2026-08-30 11:50:56',14),(89,'المصرية للدواجن','EPCO','EGx',11.17,'2026-08-02 14:01:38','2026-08-31 12:24:28',9),(90,'الاهرام للطباعة والتغليف','EPPK','EGx',12.01,'2026-08-02 14:01:38','2026-08-31 12:24:29',18),(91,'المصرية للاتصالات','ETEL','EGx',116,'2026-08-02 14:01:38','2026-08-31 12:24:29',8),(92,'المصرية لخدمات النقل','ETRS','EGx',11.06,'2026-08-02 14:01:38','2026-08-31 12:24:30',12),(93,'البنك المصري لتنمية الصادرات','EXPA','EGx',20.96,'2026-08-02 14:01:38','2026-08-31 12:24:30',1),(94,'بنك فيصل الإسلامي المصري بالجنيه','FAIT','EGx',43,'2026-08-02 14:01:38','2026-08-31 12:24:31',1),(95,'بنك فيصل الإسلامي المصري بالدولار','FAITA','EGx',0.99,'2026-08-02 14:01:38','2026-08-30 11:51:00',1),(96,'فيوتشر كير للصناعات الطبية','FCMD','EGx',7.35,'2026-08-02 14:01:38','2026-08-31 12:24:32',3),(97,'فيركيم مصر للأسمدة والكيماويات','FERC','EGx',80.82,'2026-08-02 14:01:38','2026-08-05 15:02:47',2),(98,'فوري لتكنولوجيا البنوك والمدفوعات الإلكترونية','FWRY','EGx',18.85,'2026-08-02 14:01:38','2026-08-31 12:24:33',14),(99,'غبور أوتو ش م م','GBCO','EGx',29.4,'2026-08-02 14:01:38','2026-08-31 12:24:34',4),(100,'جدوى للتنمية الصناعية','GDWA','EGx',0.807,'2026-08-02 14:01:38','2026-08-30 11:51:04',4),(101,'الجيزة العامة للمقاولات والاستثمار العقاري','GGCC','EGx',0.863,'2026-08-02 14:01:38','2026-08-31 12:24:37',15),(102,'جو جرين للاستثمار الزراعى والتنمية','GGRN','EGx',1.37,'2026-08-02 14:01:38','2026-08-31 12:24:37',9),(103,'الغربية الإسلامية للتنمية العمرانية','GIHD','EGx',69.09,'2026-08-02 14:01:38','2026-08-31 12:24:38',5),(104,'مجموعة جى . أم . سى للاستثمارات الصناعية والتجارية المالية','GMCI','EGx',1.87,'2026-08-02 14:01:38','2026-08-30 11:51:06',11),(105,'جولدن كوست السخنة للاستثمار السياحي','GOCO','EGx',0.85,'2026-08-02 14:01:38','2026-08-05 15:04:45',6),(106,'جورميه ايجيبت دوت كوم للاغذية','GOUR','EGx',17,'2026-08-02 14:01:38','2026-08-31 12:24:39',11),(107,'جي بي آي للنمو العمراني','GPIM','EGx',1.59,'2026-08-02 14:01:38','2026-08-31 12:24:40',15),(108,'جولدن بيراميدز بلازا','GPPL','EGx',1.4,'2026-08-02 14:01:38','2026-08-05 15:05:35',6),(109,'جراند انفستمنت القابضة للاستثمارات المالية','GRCA','EGx',78.97,'2026-08-02 14:01:38','2026-08-31 12:24:41',14),(110,'العامة للصوامع والتخزين','GSSC','EGx',282.02,'2026-08-02 14:01:38','2026-08-31 12:24:42',9),(111,'جيتكس للاستثمارات التجارية والصناعية','GTEX','EGx',0.044,'2026-08-02 14:01:38','2026-08-31 12:24:42',16),(112,'جولدن تكس للاصواف','GTWL','EGx',232.2,'2026-08-02 14:01:38','2026-08-31 12:24:43',16),(113,'هيبكو للاستثمارات التجارية والتنمية العقارية','HBCO','EGx',14.94,'2026-08-02 14:01:38','2026-08-31 12:24:44',19),(114,'القابضة للاستثمارات المالية','HCFI','EGx',3.77,'2026-08-02 14:01:38','2026-08-05 15:06:09',14),(115,'بنك التعمير والإسكان','HDBK','EGx',105.18,'2026-08-02 14:01:38','2026-08-31 12:24:45',1),(116,'مصر الجديدة للاسكان والتعمير','HELI','EGx',7.72,'2026-08-02 14:01:38','2026-08-31 12:24:45',5),(117,'المجموعة المالية هيرمس القابضة','HRHO','EGx',25.59,'2026-08-02 14:01:38','2026-08-31 12:24:46',14),(118,'الدولية للأسمدة والكيماويات','ICFC','EGx',23.01,'2026-08-02 14:01:38','2026-08-31 12:24:46',11),(119,'العالمية للاستثمار والتنمية','ICID','EGx',16.67,'2026-08-02 14:01:38','2026-08-31 12:24:47',5),(120,'الدولية للتأجير التمويلي','ICLE','EGx',15.76,'2026-08-02 14:01:38','2026-08-05 15:06:31',14),(121,'الإسماعيلية الجديدة للتطوير والتنمية العمرانية','IDRE','EGx',53.5,'2026-08-02 14:01:38','2026-08-31 12:24:48',5),(122,'المشروعات الصناعية والهندسية','IEEC','EGx',1.06,'2026-08-02 14:01:38','2026-08-31 12:24:49',15),(123,'الدولية للمحاصيل الزراعية','IFAP','EGx',20.53,'2026-08-02 14:01:38','2026-08-31 12:24:49',11),(124,'المجموعة المتكاملة للأعمال الهندسية','INEG','EGx',0.52,'2026-08-02 14:01:38','2026-08-31 12:24:50',19),(125,'الاسماعيلية الوطنية للصناعات الغذائية','INFI','EGx',152.44,'2026-08-02 14:01:38','2026-08-31 12:24:51',9),(126,'الحديد والصلب المصرية','IRON','EGx',30.02,'2026-08-02 14:01:38','2026-08-31 12:24:51',2),(127,'الاسماعيلية مصر للدواجن','ISMA','EGx',34.71,'2026-08-02 14:01:38','2026-08-31 12:24:52',9),(128,'الحديد والصلب للمناجم والمحاجر','ISMQ','EGx',9.08,'2026-08-02 14:01:38','2026-08-31 12:24:52',2),(129,'ابن سينا فارما','ISPH','EGx',12.92,'2026-08-02 14:01:38','2026-08-31 12:24:53',3),(130,'جهينة للصناعات الغذائية','JUFO','EGx',26.5,'2026-08-02 14:01:38','2026-08-31 12:24:54',9),(131,'النصر للملابس والمنسوجات','KABO','EGx',9.46,'2026-08-02 14:01:39','2026-08-31 12:24:54',16),(132,'نهر الخير للتنمية والأستثمار الزراعى والخدمات البيئي','KRDI','EGx',0.435,'2026-08-02 14:01:39','2026-08-31 12:24:56',9),(133,'القاهرة الوطنية للاستثمار والاوراق المالية','KWIN','EGx',111.43,'2026-08-02 14:01:39','2026-08-31 12:24:56',14),(134,'كفر الزيات للمبيدات والكيماويات','KZPC','EGx',12.97,'2026-08-02 14:01:39','2026-08-31 12:24:57',2),(135,'ليسيكو مصر','LCSW','EGx',34.8,'2026-08-02 14:01:39','2026-08-31 12:24:58',17),(136,'لوتس للتنمية والاستثمار الزراعي','LUTS','EGx',1.13,'2026-08-02 14:01:39','2026-08-31 12:24:58',9),(137,'مرسيليا المصرية الخليجية للاستثمار العقاري','MAAL','EGx',9.01,'2026-08-02 14:01:39','2026-08-31 12:24:59',5),(138,'مدينة نصر للاسكان والتعمير','MASR','EGx',7.65,'2026-08-02 14:01:39','2026-08-31 12:25:00',5),(139,'إم بي للهندسة والمقاولات','MBEG','EGx',6.94,'2026-08-02 14:01:39','2026-08-31 12:25:00',15),(140,'مصر بنى سويف للأسمنت','MBSC','EGx',408.7,'2026-08-02 14:01:39','2026-08-31 12:25:01',17),(141,'مصر للأسمنت','MCQE','EGx',234.1,'2026-08-02 14:01:39','2026-08-31 12:25:01',17),(142,'ماكرو جروب للمستحضرات الطبية','MCRO','EGx',1.5,'2026-08-02 14:01:39','2026-08-31 12:25:02',3),(144,'مينا للاستثمار السياحي والعقاري','MENA','EGx',6.91,'2026-08-02 14:01:39','2026-08-31 12:25:02',5),(145,'العبوات الطبية','MEPA','EGx',1.9,'2026-08-02 14:01:39','2026-08-31 12:25:03',3),(146,'مصر لإنتاج الأسمدة','MFPC','EGx',41.5,'2026-08-02 14:01:39','2026-08-31 12:25:04',2),(147,'مصر للأسواق الحرة','MFSC','EGx',49.85,'2026-08-02 14:01:39','2026-08-31 12:25:04',11),(148,'مصر للفنادق','MHOT','EGx',18.51,'2026-08-02 14:01:39','2026-08-31 12:25:05',6),(149,'مصر لصناعة الكيماويات','MICH','EGx',50.48,'2026-08-02 14:01:39','2026-08-31 12:25:06',2),(150,'مطاحن ومخابز شمال القاهرة','MILS','EGx',206.28,'2026-08-02 14:01:39','2026-08-31 12:25:06',9),(151,'مينا فارم للأدوية والصناعات الكيماوية','MIPH','EGx',800.08,'2026-08-02 14:01:39','2026-08-31 12:25:07',3),(152,'مرسى مرسى علم للتنمية السياحية','MMAT','EGx',3.53,'2026-08-02 14:01:39','2026-08-05 15:12:01',6),(153,'المصرية لنظم التعلم الحديثة','MOED','EGx',0.837,'2026-08-02 14:01:39','2026-08-31 12:25:08',13),(154,'الخدمات الملاحية والبترولية','MOIL','EGx',0.688,'2026-08-02 14:01:39','2026-08-31 12:25:09',10),(155,'المهندس للتأمين','MOIN','EGx',33.75,'2026-08-02 14:01:39','2026-08-31 12:25:10',14),(156,'مصر للزيوت والصابون','MOSC','EGx',313.26,'2026-08-02 14:01:39','2026-08-31 12:25:10',9),(157,'ممفيس للأدوية والصناعات الكيماوية','MPCI','EGx',446,'2026-08-02 14:01:39','2026-08-31 12:25:11',3),(158,'المنصورة للدواجن','MPCO','EGx',2.11,'2026-08-02 14:01:39','2026-08-31 12:25:12',9),(159,'المصرية لمدينة الإنتاج الإعلامي','MPRC','EGx',43.4,'2026-08-02 14:01:39','2026-08-31 12:25:12',8),(160,'ام.ام جروب للصناعة والتجارة العالمية','MTIE','EGx',8.49,'2026-08-02 14:01:39','2026-08-31 12:25:13',11),(161,'النعيم القابضة للاستثمارات','NAHO','EGx',0.143,'2026-08-02 14:01:39','2026-08-30 11:51:43',14),(162,'النعيم العقارية القابضة','NARE','EGx',17.22,'2026-08-02 14:01:39','2026-08-31 12:25:14',5),(163,'شركة النصر للأعمال المدنية','NCCW','EGx',5.87,'2026-08-02 14:01:39','2026-08-31 12:25:15',15),(165,'شمال الصعيد للتنمية والإنتاج الزراعي','NEDA','EGx',2.74,'2026-08-02 14:01:39','2026-08-31 12:25:15',9),(166,'الوطنية للاسكان للنقابات المهنية','NHPS','EGx',89.01,'2026-08-02 14:01:39','2026-08-31 12:25:16',5),(167,'مستشفى النزهة الدولي','NINH','EGx',23.5,'2026-08-02 14:01:39','2026-08-31 12:25:16',3),(168,'النيل للأدوية والصناعات الكيماوية','NIPH','EGx',347.02,'2026-08-02 14:01:39','2026-08-31 12:25:17',3),(169,'العبور للاستثمار العقاري','OBRI','EGx',32.97,'2026-08-02 14:01:39','2026-08-31 12:25:17',5),(170,'السادس من أكتوبر للتنمية والاستثمار','OCDI','EGx',31.2,'2026-08-02 14:01:39','2026-08-31 12:25:18',5),(171,'أكتوبر فارما','OCPH','EGx',252.61,'2026-08-02 14:01:39','2026-08-31 12:25:19',3),(172,'أودن للاستثمارات المالية','ODIN','EGx',3.03,'2026-08-02 14:01:39','2026-08-31 12:25:19',14),(173,'أوراسكوم المالية القابضة','OFH','EGx',1.05,'2026-08-02 14:01:39','2026-08-31 12:25:20',14),(174,'أوراسكوم للاستثمار القابضة','OIH','EGx',2.02,'2026-08-02 14:01:39','2026-08-31 12:25:21',14),(175,'عبور لاند للصناعات الغذائية','OLFI','EGx',22.67,'2026-08-02 14:01:39','2026-08-31 12:25:21',9),(176,'اوراسكوم كونستراكشون بي ال سي','ORAS','EGx',859.79,'2026-08-02 14:01:39','2026-08-31 12:25:22',15),(177,'أوراسكوم للتنمية مصر','ORHD','EGx',41.5,'2026-08-02 14:01:39','2026-08-31 12:25:22',5),(178,'النساجون الشرقيون للسجاد','ORWE','EGx',25.76,'2026-08-02 14:01:39','2026-08-31 12:25:23',16),(179,'المصرية الدولية للصناعات الدوائية','PHAR','EGx',129.74,'2026-08-02 14:01:39','2026-08-31 12:25:24',3),(180,'بالم هيلز للتعمير','PHDC','EGx',14.79,'2026-08-02 14:01:39','2026-08-31 12:25:24',5),(181,'بريميم هيلثكير جروب','PHGC','EGx',0.089,'2026-08-02 14:01:39','2026-08-27 11:52:14',3),(182,'بيراميزا للفنادق والقرى السياحية','PHTV','EGx',339.88,'2026-08-02 14:01:39','2026-08-31 12:25:25',6),(183,'القاهرة للدواجن','POUL','EGx',39.5,'2026-08-02 14:01:39','2026-08-31 12:25:26',9),(184,'العامة لمنتجات الخزف والصيني','PRCL','EGx',31.13,'2026-08-02 14:01:39','2026-08-31 12:25:27',17),(185,'بايونيرز بروبرتيز للتنمية العمرانية','PRDC','EGx',9.77,'2026-08-02 14:01:39','2026-08-31 12:25:27',5),(186,'برايم القابضة للاستثمارات المالية','PRMH','EGx',2.65,'2026-08-02 14:01:39','2026-08-31 12:25:28',14),(187,'بنك قطر الوطني الأهلي','QNBE','EGx',58.94,'2026-08-02 14:01:39','2026-08-31 12:25:29',1),(188,'راية لخدمات مراكز الاتصالات','RACC','EGx',9.5,'2026-08-02 14:01:39','2026-08-31 12:25:29',8),(189,'العامة لصناعة الورق','RAKT','EGx',22.11,'2026-08-02 14:01:39','2026-08-31 12:25:30',18),(190,'راية القابضة للاستثمارات المالية','RAYA','EGx',7.24,'2026-08-02 14:01:39','2026-08-31 12:25:30',14),(191,'ركاز القابضة للاستثمارات المالية','RKAZ','EGx',4.1,'2026-08-02 14:01:39','2026-08-30 11:52:02',14),(192,'العاشر من رمضان للصناعات الدوائية والمستحضرات تشخيصية','RMDA','EGx',6,'2026-08-02 14:01:39','2026-08-31 12:25:31',3),(193,'رواد السياحة','ROTO','EGx',44.11,'2026-08-02 14:01:39','2026-08-31 12:25:32',6),(194,'الاستثمار العقاري العربي','RREI','EGx',4.31,'2026-08-02 14:01:39','2026-08-31 12:25:33',5),(195,'رمكو لإنشاء القرى السياحية','RTVC','EGx',4.2,'2026-08-02 14:01:39','2026-08-31 12:25:33',6),(196,'روبكس العالمية لتصنيع البلاستيك والاكريلك','RUBX','EGx',12.8,'2026-08-02 14:01:39','2026-08-31 12:25:34',17),(197,'بنك الشركة المصرفية العربية الدولية','SAIB','EGx',2.53,'2026-08-02 14:01:39','2026-08-30 11:52:06',1),(198,'بنك البركة مصر','SAUD','EGx',22.92,'2026-08-02 14:01:39','2026-08-31 12:25:35',1),(199,'أسمنت سيناء','SCEM','EGx',97.01,'2026-08-02 14:01:39','2026-08-31 12:25:36',17),(200,'مطاحن ومخابز جنوب القاهرة والجيزة','SCFM','EGx',283.05,'2026-08-02 14:01:39','2026-08-31 12:25:36',9),(201,'قناة السويس لتوطين التكنولوجيا','SCTS','EGx',617.43,'2026-08-02 14:01:39','2026-08-31 12:25:37',13),(202,'شارم دريمز للاستثمار السياحي','SDTI','EGx',69.01,'2026-08-02 14:01:39','2026-08-31 12:25:37',6),(203,'السعودية المصرية للاستثمار والتمويل','SEIG','EGx',260.25,'2026-08-02 14:01:39','2026-08-31 12:25:38',14),(204,'سبأ الدولية للأدوية والصناعات الكيماوية','SIPC','EGx',4.87,'2026-08-02 14:01:39','2026-08-31 12:25:39',3),(205,'سيدي كرير للبتروكيماويات','SKPC','EGx',17.79,'2026-08-02 14:01:39','2026-08-31 12:25:40',2),(206,'سماد مصر','SMFR','EGx',259.76,'2026-08-02 14:01:39','2026-08-31 12:25:40',11),(207,'الشرقية الوطنية للأمن الغذائي','SNFC','EGx',10.35,'2026-08-02 14:01:39','2026-08-31 12:25:41',9),(208,'الشمس بيراميدز للمنشات السياحية','SPHT','EGx',1.91,'2026-08-02 14:01:39','2026-08-05 15:22:51',6),(209,'الإسكندرية للغزل والنسيج','SPIN','EGx',19.77,'2026-08-02 14:01:39','2026-08-31 12:25:42',16),(210,'سبيد ميديكال','SPMD','EGx',0.45,'2026-08-02 14:01:39','2026-08-31 12:25:43',3),(211,'الدلتا للسكر','SUGR','EGx',57,'2026-08-02 14:01:39','2026-08-31 12:25:43',9),(212,'جنوب الوادى للأسمنت','SVCE','EGx',10.91,'2026-08-02 14:01:39','2026-08-31 12:25:44',17),(213,'السويدي اليكتريك','SWDY','EGx',125.95,'2026-08-02 14:01:39','2026-08-31 12:25:44',4),(214,'شركة تعليم لخدمات الإدارة','TALM','EGx',17.85,'2026-08-02 14:01:39','2026-08-31 12:25:45',13),(215,'تنمية للاستثمار العقاري','TANM','EGx',5.05,'2026-08-02 14:01:39','2026-08-31 12:25:46',5),(216,'طاقة عربية ش.م.م','TAQA','EGx',16.25,'2026-08-02 14:01:39','2026-08-31 12:25:46',7),(217,'مجموعة طلعت مصطفى القابضة','TMGH','EGx',97,'2026-08-02 14:01:39','2026-08-31 12:25:47',5),(219,'توسع للتخصيم','TWSA','EGx',8.1,'2026-08-02 14:01:39','2026-08-31 12:25:47',14),(220,'الاسكندرية الوطنية للاستثمارات المالية','TYCN','EGx',14.67,'2026-08-02 14:01:39','2026-08-31 12:25:48',14),(221,'المصرف المتحد','UBEE','EGx',14.58,'2026-08-02 14:01:39','2026-08-31 12:25:48',1),(222,'مطاحن مصر العليا','UEFM','EGx',540.83,'2026-08-02 14:01:39','2026-08-31 12:25:49',9),(223,'الصعيد العامة للمقاولات والاستثمار العقاري','UEGC','EGx',1.84,'2026-08-02 14:01:39','2026-08-31 12:25:50',5),(224,'يونيفرسال لصناعة مواد التعبئة والتغليف والورق','UNIP','EGx',0.37,'2026-08-02 14:01:39','2026-08-31 12:25:50',18),(225,'المتحدة للاسكان والتعمير','UNIT','EGx',18.7,'2026-08-02 14:01:39','2026-08-31 12:25:51',5),(226,'الاتحاد الصيدلي للخدمات الطبية والاستثمار','UPMS','EGx',11.2,'2026-08-02 14:01:39','2026-08-31 12:25:52',19),(227,'يوتوبيا للاستثمار العقاري والسياحي','UTOP','EGx',112.16,'2026-08-02 14:01:39','2026-08-31 12:25:52',19),(228,'يو للتمويل الاستهلاكي','VALU','EGx',11.2,'2026-08-02 14:01:39','2026-08-31 12:25:53',14),(229,'فالمور القابضة للاستثمار','VLMR','EGx',0.696,'2026-08-02 14:01:39','2026-08-31 12:25:54',14),(230,'فالمور القابضة للاستثمار','VLMRA','EGx',30.35,'2026-08-02 14:01:39','2026-08-31 12:25:54',14),(231,'مطاحن وسط وغرب الدلتا','WCDF','EGx',648.98,'2026-08-02 14:01:39','2026-08-31 12:25:55',9),(232,'وادي كوم امبو لاستصلاح الأراضي','WKOL','EGx',344.63,'2026-08-02 14:01:39','2026-08-31 12:25:55',15),(233,'الزيوت المستخلصة ومنتجاتها','ZEOT','EGx',13.76,'2026-08-02 14:01:39','2026-08-31 12:25:56',9),(234,'زهراء المعادي للاستثمار والتعمير','ZMID','EGx',8.92,'2026-08-02 14:01:39','2026-08-31 12:25:57',5),(235,'صندوق ازيموت جولد','AZG','EGX',22,'2026-08-02 16:56:57','2026-08-02 16:56:57',20),(236,'قرة لمشروعات الطاقة والاستثمار','KORA','EGX',3.58,'2026-08-03 09:56:49','2026-08-31 12:24:55',15);
/*!40000 ALTER TABLE `stocks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trade_tracks`
--

DROP TABLE IF EXISTS `trade_tracks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `trade_tracks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `trade_id` bigint unsigned NOT NULL,
  `amount` double NOT NULL,
  `date` datetime NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `trade_tracks_trade_id_foreign` (`trade_id`),
  CONSTRAINT `trade_tracks_trade_id_foreign` FOREIGN KEY (`trade_id`) REFERENCES `trades` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=193 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trade_tracks`
--

LOCK TABLES `trade_tracks` WRITE;
/*!40000 ALTER TABLE `trade_tracks` DISABLE KEYS */;
INSERT INTO `trade_tracks` VALUES (1,1,-4062.87,'2026-07-26 17:11:21','buy','2026-08-02 14:11:55','2026-08-02 14:11:55'),(2,1,-4328.19,'2026-07-28 17:11:55','buy','2026-08-02 14:12:19','2026-08-02 14:12:19'),(3,4,-1407.38,'2026-08-02 17:40:45','buy','2026-08-02 14:41:11','2026-08-02 14:41:11'),(4,4,1415.3,'2026-07-29 17:41:11','sell','2026-08-02 14:41:53','2026-08-02 14:41:53'),(5,4,-1946.33,'2026-07-27 17:41:53','buy','2026-08-02 14:42:21','2026-08-02 14:42:32'),(6,4,-1318.58,'2026-07-14 17:42:39','buy','2026-08-02 14:43:59','2026-08-02 14:43:59'),(7,4,-1575,'2026-07-08 17:43:59','buy','2026-08-02 14:44:46','2026-08-02 14:59:48'),(8,4,2471.58,'2026-07-01 17:44:45','sell','2026-08-02 14:45:08','2026-08-02 14:45:08'),(9,4,-4424.3,'2026-06-22 17:45:08','buy','2026-08-02 14:45:45','2026-08-02 14:45:45'),(10,4,1303.42,'2026-06-21 17:45:45','sell','2026-08-02 14:46:14','2026-08-02 14:46:14'),(11,4,-1250.49,'2026-06-21 17:46:14','buy','2026-08-02 14:46:43','2026-08-02 14:46:43'),(12,4,-2090.5,'2026-06-17 17:46:43','buy','2026-08-02 14:47:05','2026-08-02 14:47:05'),(13,4,-2141.57,'2026-06-16 17:47:05','buy','2026-08-02 14:47:32','2026-08-02 14:47:32'),(14,4,-3297.94,'2026-06-15 17:47:32','buy','2026-08-02 14:47:59','2026-08-02 14:47:59'),(15,4,-19368.18,'2026-06-14 17:52:59','buy','2026-08-02 14:53:19','2026-08-02 14:53:19'),(16,2,2633.71,'2026-07-30 18:01:23','sell','2026-08-02 15:01:51','2026-08-02 15:01:51'),(17,2,-7795.71,'2026-07-30 18:01:51','buy','2026-08-02 15:02:15','2026-08-02 15:02:15'),(18,2,-2736.41,'2026-07-29 18:02:15','buy','2026-08-02 15:02:37','2026-08-02 15:02:37'),(19,2,-5509.88,'2026-07-28 18:02:37','buy','2026-08-02 15:02:56','2026-08-02 15:02:56'),(20,2,-5529.9,'2026-07-19 18:02:56','buy','2026-08-02 15:03:39','2026-08-02 15:03:39'),(21,2,5669.9,'2026-06-12 18:04:08','sell','2026-08-02 15:04:35','2026-08-02 15:04:35'),(22,2,-5631.02,'2026-07-12 18:05:17','buy','2026-08-02 15:05:50','2026-08-02 15:05:50'),(23,7,891,'2026-08-02 19:57:26','profit','2026-08-02 16:57:39','2026-08-02 16:57:39'),(24,8,119,'2026-08-02 19:58:11','profit','2026-08-02 16:58:25','2026-08-02 16:58:25'),(25,9,944,'2026-08-02 19:59:29','profit','2026-08-02 16:59:35','2026-08-02 16:59:35'),(26,10,94,'2026-08-02 19:59:55','profit','2026-08-02 17:00:02','2026-08-02 17:00:02'),(27,11,57,'2026-08-02 20:00:45','profit','2026-08-02 17:00:50','2026-08-02 17:00:50'),(28,12,109,'2026-08-02 20:01:16','profit','2026-08-02 17:01:25','2026-08-02 17:01:25'),(29,13,32,'2026-08-02 20:02:05','profit','2026-08-02 17:02:12','2026-08-02 17:02:12'),(30,14,1093,'2026-08-02 20:02:53','profit','2026-08-02 17:03:00','2026-08-02 17:03:00'),(31,15,23,'2026-08-02 20:03:31','profit','2026-08-02 17:03:36','2026-08-02 17:03:36'),(32,16,456,'2026-08-02 20:04:11','profit','2026-08-02 17:04:15','2026-08-02 17:04:15'),(33,17,59,'2026-08-02 20:04:42','profit','2026-08-02 17:04:53','2026-08-02 17:04:53'),(34,18,2,'2026-08-02 20:05:25','profit','2026-08-02 17:05:32','2026-08-02 17:05:32'),(35,19,479,'2026-08-02 20:05:58','profit','2026-08-02 17:06:02','2026-08-02 17:06:02'),(36,20,137,'2026-08-02 20:06:20','profit','2026-08-02 17:06:28','2026-08-02 17:06:28'),(37,21,818,'2026-08-02 20:06:59','profit','2026-08-02 17:07:07','2026-08-02 17:07:07'),(38,22,143,'2026-08-02 20:07:30','profit','2026-08-02 17:07:37','2026-08-02 17:07:37'),(39,23,1061,'2026-08-02 20:07:56','profit','2026-08-02 17:08:02','2026-08-02 17:08:02'),(40,24,270,'2026-08-02 20:08:57','profit','2026-08-02 17:09:05','2026-08-02 17:09:05'),(41,25,3186,'2026-08-02 20:09:38','profit','2026-08-02 17:09:46','2026-08-02 17:09:46'),(42,26,2718,'2026-08-02 20:10:19','profit','2026-08-02 17:10:28','2026-08-02 17:10:28'),(43,27,893,'2026-08-02 20:10:52','profit','2026-08-02 17:10:56','2026-08-02 17:10:56'),(44,28,1284,'2026-08-02 20:11:39','profit','2026-08-02 17:11:48','2026-08-02 17:11:48'),(45,29,1251,'2026-08-02 20:12:18','profit','2026-08-02 17:12:27','2026-08-02 17:12:27'),(46,30,-24,'2026-08-02 20:13:05','profit','2026-08-02 17:13:13','2026-08-02 17:13:13'),(47,31,-250,'2026-08-02 20:13:34','profit','2026-08-02 17:13:41','2026-08-02 17:13:41'),(48,32,-742,'2026-02-26 20:14:22',NULL,'2026-08-02 17:14:26','2026-08-03 14:43:16'),(49,33,-180,'2026-08-02 20:15:22','profit','2026-08-02 17:15:29','2026-08-02 17:15:29'),(50,34,33,'2026-08-02 20:15:55','profit','2026-08-02 17:15:58','2026-08-02 17:15:58'),(51,35,20,'2026-08-02 20:16:17','profit','2026-08-02 17:16:26','2026-08-02 17:16:26'),(52,36,2457,'2026-08-02 20:17:51','profit','2026-08-02 17:18:18','2026-08-02 17:18:18'),(53,38,-7760.29,'2026-04-29 21:07:02','buy','2026-08-02 18:09:33','2026-08-02 18:09:33'),(54,38,-4037.83,'2026-05-14 21:09:45','buy','2026-08-02 18:10:39','2026-08-02 18:10:39'),(55,38,-4012.81,'2026-05-18 21:10:39','buy','2026-08-02 18:11:10','2026-08-02 18:11:10'),(56,38,-3972.77,'2026-05-20 21:11:10','buy','2026-08-02 18:11:47','2026-08-02 18:11:47'),(57,38,4281.86,'2026-06-11 21:12:38','sell','2026-08-02 18:13:30','2026-08-02 18:13:30'),(58,38,5225.72,'2026-06-16 21:13:30','sell','2026-08-02 18:13:54','2026-08-02 18:13:54'),(59,38,6034.75,'2026-06-17 21:13:54','sell','2026-08-02 18:14:27','2026-08-02 18:14:27'),(60,38,-6115.34,'2026-06-21 21:14:27','buy','2026-08-02 18:15:09','2026-08-02 18:15:09'),(61,38,6639.04,'2026-06-21 21:15:09','sell','2026-08-02 18:15:45','2026-08-02 18:15:45'),(62,38,6234.51,'2026-06-22 21:15:45','sell','2026-08-02 18:16:27','2026-08-02 18:16:27'),(63,38,6229.52,'2026-06-23 21:16:27','sell','2026-08-02 18:16:52','2026-08-02 18:16:52'),(64,38,-7131.55,'2026-07-15 21:16:52','buy','2026-08-02 18:17:46','2026-08-02 18:17:46'),(65,38,7398.11,'2026-07-15 21:17:46','sell','2026-08-02 18:18:06','2026-08-02 18:18:06'),(66,40,-5218.89,'2026-06-04 14:30:56','buy','2026-08-03 11:31:59','2026-08-03 11:31:59'),(67,40,9.51,'2026-06-04 14:32:05','profit','2026-08-03 11:32:31','2026-08-03 11:32:31'),(68,40,2677.89,'2026-06-14 14:32:31','sell','2026-08-03 11:33:05','2026-08-03 11:33:05'),(69,40,3482.64,'2026-06-15 14:33:05','sell','2026-08-03 11:33:35','2026-08-03 11:33:35'),(70,41,-4523.65,'2026-06-25 14:34:15','buy','2026-08-03 11:34:54','2026-08-03 11:34:54'),(71,41,4566.27,'2026-07-08 14:34:54','sell','2026-08-03 11:35:27','2026-08-03 11:35:27'),(72,6,3065.16,'2026-07-15 14:36:52','sell','2026-08-03 11:38:16','2026-08-03 11:38:16'),(73,6,-3030.77,'2026-07-15 14:38:16','buy','2026-08-03 11:38:52','2026-08-03 11:38:52'),(74,6,3111.1,'2026-07-14 14:38:52','sell','2026-08-03 11:39:23','2026-08-03 11:39:23'),(75,6,-3008.75,'2026-07-12 14:39:23','buy','2026-08-03 11:39:53','2026-08-03 11:39:53'),(76,6,-3016.27,'2026-07-08 14:39:53','buy','2026-08-03 11:40:29','2026-08-03 11:40:29'),(77,6,-4316.39,'2026-06-29 14:40:29','buy','2026-08-03 11:41:09','2026-08-03 11:41:09'),(78,6,-4451.54,'2026-06-25 14:41:33','buy','2026-08-03 11:41:56','2026-08-03 11:41:56'),(79,6,4488.38,'2026-06-24 14:41:56','sell','2026-08-03 11:42:25','2026-08-03 11:42:25'),(80,6,-4451.54,'2026-06-24 14:42:52','buy','2026-08-03 11:43:25','2026-08-03 11:43:25'),(81,6,-3038.78,'2026-06-22 14:43:25','buy','2026-08-03 11:43:57','2026-08-03 11:43:57'),(82,6,-2243.79,'2026-06-11 14:43:57','buy','2026-08-03 11:44:36','2026-08-03 11:48:04'),(83,6,-2323.4,'2026-06-07 14:46:37','buy','2026-08-03 11:47:10','2026-08-03 11:47:10'),(84,6,4338.57,'2026-06-28 14:49:30','sell','2026-08-03 11:49:51','2026-08-03 11:49:51'),(85,37,-8495,'2026-04-30 14:54:08',NULL,'2026-08-03 11:56:26','2026-08-03 11:56:26'),(86,37,-3192.99,'2026-05-18 14:56:26','buy','2026-08-03 11:57:01','2026-08-03 11:57:01'),(87,37,15192.48,'2026-08-03 14:57:01','sell','2026-08-03 11:57:35','2026-08-03 11:57:35'),(88,39,-12004,'2026-05-04 14:59:01',NULL,'2026-08-03 12:00:43','2026-08-03 12:00:43'),(89,39,3482.64,'2026-05-17 15:00:43','sell','2026-08-03 12:01:46','2026-08-03 12:01:46'),(90,39,3462.66,'2026-05-18 15:01:46','sell','2026-08-03 12:02:08','2026-08-03 12:02:08'),(91,39,3632.46,'2026-06-11 15:02:08','sell','2026-08-03 12:02:45','2026-08-03 12:02:45'),(92,39,3582.51,'2026-06-14 15:02:45','sell','2026-08-03 12:03:18','2026-08-03 12:03:18'),(93,3,-14022,'2026-04-28 15:25:35',NULL,'2026-08-03 12:27:20','2026-08-03 12:27:20'),(94,3,228,'2026-05-14 15:27:20','profit','2026-08-03 12:27:52','2026-08-03 12:27:52'),(95,3,-2844.54,'2026-05-18 15:27:52','buy','2026-08-03 12:28:21','2026-08-03 12:28:21'),(96,3,2964.28,'2026-06-10 15:28:21','sell','2026-08-03 12:29:07','2026-08-03 12:29:07'),(97,3,-3109.88,'2026-06-23 15:29:07','buy','2026-08-03 12:29:51','2026-08-03 12:29:51'),(98,3,-2892.61,'2026-07-21 15:29:51','buy','2026-08-03 12:30:46','2026-08-03 12:30:46'),(99,5,-34119,'2026-04-30 15:31:57',NULL,'2026-08-03 12:32:49','2026-08-03 12:32:49'),(100,5,3158.03,'2026-05-17 15:32:49','sell','2026-08-03 12:33:47','2026-08-03 12:33:47'),(101,5,3232.96,'2026-06-23 15:33:47','sell','2026-08-03 12:34:38','2026-08-03 12:34:38'),(102,5,3188,'2026-06-28 15:34:38','sell','2026-08-03 12:35:02','2026-08-03 12:35:02'),(103,5,3537.57,'2026-07-12 15:35:02','sell','2026-08-03 12:35:43','2026-08-03 12:35:43'),(104,5,3637.45,'2026-07-13 15:35:43','sell','2026-08-03 12:36:10','2026-08-03 12:45:15'),(105,5,14725.55,'2026-07-30 15:36:10','sell','2026-08-03 12:36:51','2026-08-03 12:36:51'),(106,5,-10814.5,'2026-07-30 15:36:51','buy','2026-08-03 12:37:13','2026-08-03 12:37:13'),(107,5,3655.58,'2026-08-03 15:37:13','sell','2026-08-03 12:41:41','2026-08-03 12:41:41'),(108,5,-3589.27,'2026-08-03 15:41:41','buy','2026-08-03 12:42:01','2026-08-03 12:42:01'),(109,5,3163.03,'2026-06-21 15:46:50','sell','2026-08-03 12:47:23','2026-08-03 12:47:23'),(110,32,-4528.65,'2026-05-17 17:44:03','buy','2026-08-03 14:44:47','2026-08-03 14:44:47'),(111,32,-4358.45,'2026-05-21 17:44:47','buy','2026-08-03 14:45:20','2026-08-03 14:45:20'),(112,32,-4398.49,'2026-05-25 17:45:20','buy','2026-08-03 14:45:47','2026-08-03 14:45:47'),(113,32,4491.37,'2026-06-17 17:45:47','sell','2026-08-03 14:46:30','2026-08-03 14:46:30'),(114,32,-4478.59,'2026-06-17 17:46:30','buy','2026-08-03 14:46:55','2026-08-03 14:46:55'),(115,32,4561.28,'2026-06-21 17:46:55','sell','2026-08-03 14:47:14','2026-08-03 14:47:14'),(116,32,4671.15,'2026-06-22 17:47:14','sell','2026-08-03 14:47:44','2026-08-03 14:47:44'),(117,32,-4518.64,'2026-06-23 17:47:44','buy','2026-08-03 14:48:20','2026-08-03 14:48:20'),(118,32,4601.24,'2026-06-25 17:48:20','sell','2026-08-03 14:48:52','2026-08-03 14:48:52'),(119,32,-4478.59,'2026-06-28 17:48:52','buy','2026-08-03 14:49:12','2026-08-03 14:49:12'),(120,32,4731.08,'2026-07-05 17:49:12','sell','2026-08-03 14:49:56','2026-08-03 14:49:56'),(121,32,-5219.51,'2026-07-08 17:49:56','buy','2026-08-03 14:50:26','2026-08-03 14:50:26'),(122,32,5200.49,'2026-07-08 17:50:26','sell','2026-08-03 14:51:23','2026-08-03 14:51:23'),(123,32,5250.42,'2026-07-08 17:51:23','sell','2026-08-03 14:52:09','2026-08-03 14:52:09'),(124,32,-16709.86,'2026-07-09 17:52:09','buy','2026-08-03 14:52:29','2026-08-03 14:52:29'),(125,32,11150.05,'2026-07-09 17:52:29','sell','2026-08-03 14:52:51','2026-08-03 14:52:51'),(126,32,5719.84,'2026-07-12 17:52:51','sell','2026-08-03 14:53:19','2026-08-03 14:53:19'),(127,32,-6020.51,'2026-07-14 17:53:19','buy','2026-08-03 14:53:44','2026-08-03 14:53:44'),(128,32,6029.46,'2026-07-14 17:53:44','sell','2026-08-03 14:54:08','2026-08-03 14:54:08'),(129,32,-18141.64,'2026-07-15 17:54:08','buy','2026-08-03 14:54:32','2026-08-03 14:54:32'),(130,32,6029.46,'2026-07-15 17:54:32','sell','2026-08-03 14:54:51','2026-08-03 14:54:51'),(131,32,-6421.01,'2026-07-16 17:54:51','buy','2026-08-03 14:55:23','2026-08-03 14:55:23'),(132,32,6468.9,'2026-07-19 17:55:23','sell','2026-08-03 14:55:54','2026-08-03 14:55:54'),(133,32,-9599.99,'2026-07-19 17:55:54','buy','2026-08-03 14:56:17','2026-08-03 14:56:17'),(134,32,9629.95,'2026-07-20 17:56:43','sell','2026-08-03 14:57:00','2026-08-03 14:57:00'),(135,32,-19635.51,'2026-07-20 17:57:11','buy','2026-08-03 14:57:42','2026-08-03 14:57:42'),(136,32,9869.64,'2026-07-20 17:57:42','sell','2026-08-03 14:58:05','2026-08-03 14:58:05'),(137,32,6678.64,'2026-07-21 17:58:05','sell','2026-08-03 14:58:35','2026-08-03 14:58:35'),(138,32,-35799.69,'2026-07-21 17:58:35','buy','2026-08-03 14:58:51','2026-08-03 14:58:51'),(139,32,21294.35,'2026-07-21 17:58:51','sell','2026-08-03 14:59:08','2026-08-03 14:59:08'),(140,32,7128.08,'2026-07-22 17:59:08','sell','2026-08-03 14:59:41','2026-08-03 14:59:41'),(141,32,-28167.14,'2026-07-22 17:59:41','buy','2026-08-03 15:00:06','2026-08-03 15:00:06'),(142,32,21314.32,'2026-07-22 18:00:06','sell','2026-08-03 15:00:39','2026-08-03 15:00:39'),(143,32,10585.74,'2026-07-26 18:00:39','sell','2026-08-03 15:01:07','2026-08-03 15:01:07'),(144,32,-14013.49,'2026-07-26 18:01:07','buy','2026-08-03 15:01:49','2026-08-03 15:01:49'),(145,32,14066.39,'2026-07-26 18:01:49','sell','2026-08-03 15:02:12','2026-08-03 15:02:12'),(146,32,7128.08,'2026-07-26 18:02:12','sell','2026-08-03 15:02:30','2026-08-03 15:02:30'),(147,32,12258.64,'2026-07-16 18:08:03','sell','2026-08-03 15:08:23','2026-08-03 15:09:17'),(148,4,-115.55,'2026-08-03 18:14:04','buy','2026-08-03 15:14:47','2026-08-03 15:14:47'),(149,5,7124.51,'2026-08-04 16:01:26','sell','2026-08-04 13:01:40','2026-08-04 13:01:40'),(150,4,-1347.28,'2026-08-04 16:02:08','buy','2026-08-04 13:02:25','2026-08-04 13:02:25'),(151,1,5058.38,'2026-08-04 16:02:52','sell','2026-08-04 13:03:04','2026-08-04 13:03:04'),(152,42,-7353.34,'2026-08-04 16:03:34','buy','2026-08-04 13:03:46','2026-08-04 13:03:46'),(153,42,7608.07,'2026-08-04 16:03:52','sell','2026-08-04 13:04:05','2026-08-04 13:04:05'),(154,3,9717.46,'2026-08-04 16:07:21','sell','2026-08-04 13:07:36','2026-08-04 13:07:36'),(155,6,3287.23,'2026-08-05 15:33:05','sell','2026-08-05 12:33:46','2026-08-05 12:33:46'),(156,2,5527.31,'2026-08-05 15:34:03','sell','2026-08-05 12:34:17','2026-08-05 12:34:17'),(157,2,-5432.48,'2026-08-05 15:34:28','buy','2026-08-05 12:34:43','2026-08-05 12:34:43'),(158,5,-7225.62,'2026-08-06 18:02:21','buy','2026-08-06 15:02:39','2026-08-06 15:02:39'),(159,3,-2718.75,'2026-08-06 18:02:56','buy','2026-08-06 15:03:08','2026-08-06 15:03:08'),(160,2,-2717.75,'2026-08-06 18:03:18','buy','2026-08-06 15:03:31','2026-08-06 15:03:31'),(161,5,3670.56,'2026-08-09 15:20:09','sell','2026-08-09 12:20:23','2026-08-09 12:20:23'),(162,1,-6018.21,'2026-08-09 15:20:37','buy','2026-08-09 12:20:56','2026-08-09 12:20:56'),(163,32,-6742.74,'2026-08-09 15:21:44','buy','2026-08-09 12:22:13','2026-08-09 12:23:05'),(164,32,6772.28,'2026-08-09 15:22:13','sell','2026-08-09 12:22:28','2026-08-09 12:22:28'),(165,6,-3250.66,'2026-08-10 15:33:55','buy','2026-08-10 12:34:09','2026-08-10 12:34:09'),(166,2,8558.98,'2026-08-10 15:34:28','sell','2026-08-10 12:34:50','2026-08-10 12:34:50'),(167,1,6331.21,'2026-08-10 15:35:02','sell','2026-08-10 12:35:15','2026-08-10 12:35:15'),(168,31,-9927.25,'2026-08-10 15:35:49','buy','2026-08-10 12:36:09','2026-08-10 12:36:09'),(169,5,7623.64,'2026-08-11 16:29:26','sell','2026-08-11 13:29:35','2026-08-11 13:30:03'),(170,31,-5298.45,'2026-08-11 16:30:12','buy','2026-08-11 13:31:17','2026-08-11 13:31:17'),(171,31,-3299.76,'2026-08-12 16:35:48','buy','2026-08-12 13:36:06','2026-08-12 13:37:45'),(172,1,-6418.89,'2026-08-12 16:36:33','buy','2026-08-12 13:37:02','2026-08-12 13:37:02'),(173,1,6708.5,'2026-08-12 16:37:06','sell','2026-08-12 13:37:20','2026-08-12 13:37:20'),(174,1,-3150.84,'2026-08-16 16:46:59','buy','2026-08-16 13:47:12','2026-08-16 13:47:12'),(175,6,-3451.01,'2026-08-16 16:47:18','buy','2026-08-16 13:47:34','2026-08-16 13:47:34'),(176,5,-3814.66,'2026-08-16 16:47:46','buy','2026-08-16 13:48:03','2026-08-16 13:48:03'),(177,1,-1902.22,'2026-08-17 15:33:42','buy','2026-08-17 12:33:57','2026-08-17 12:33:57'),(178,6,-3400.94,'2026-08-17 15:33:59','buy','2026-08-17 12:34:18','2026-08-17 12:34:18'),(179,31,5086.58,'2026-08-18 15:17:41','sell','2026-08-18 12:17:55','2026-08-18 12:17:55'),(180,4,1988.6,'2026-08-19 15:18:28','sell','2026-08-19 12:18:42','2026-08-19 12:18:42'),(181,31,-3359.88,'2026-08-19 15:19:24','buy','2026-08-19 12:19:36','2026-08-19 12:19:36'),(182,4,-1883.69,'2026-08-20 15:20:31','buy','2026-08-20 12:21:05','2026-08-20 12:21:05'),(183,4,1916.23,'2026-08-20 15:21:13','sell','2026-08-20 12:21:27','2026-08-20 12:21:27'),(184,1,-1428.41,'2026-08-23 16:55:18','buy','2026-08-23 13:55:29','2026-08-23 13:55:29'),(185,31,-1607.3,'2026-08-24 15:15:17','buy','2026-08-24 12:15:32','2026-08-24 12:15:32'),(186,4,-1021.23,'2026-08-25 15:15:42','buy','2026-08-25 12:15:57','2026-08-25 12:15:57'),(187,5,4284.48,'2026-08-26 15:30:38','sell','2026-08-26 12:31:03','2026-08-26 12:31:03'),(189,31,6524.55,'2026-08-30 15:41:53','sell','2026-08-30 12:42:08','2026-08-30 12:42:08'),(190,31,-6495.34,'2026-08-30 15:42:31','buy','2026-08-30 12:42:41','2026-08-30 12:42:41'),(191,5,855,'2026-08-31 15:26:50','profit','2026-08-31 12:27:03','2026-08-31 12:27:03'),(192,4,-4052.56,'2026-08-31 16:35:47','buy','2026-08-31 13:36:12','2026-08-31 13:36:12');
/*!40000 ALTER TABLE `trade_tracks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trades`
--

DROP TABLE IF EXISTS `trades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `trades` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `stock_id` bigint unsigned NOT NULL,
  `amount` double NOT NULL,
  `status` enum('open','close') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `closed_at` datetime DEFAULT NULL,
  `year` smallint unsigned NOT NULL DEFAULT '2026',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `trades_stock_id_foreign` (`stock_id`),
  KEY `trades_year_index` (`year`),
  CONSTRAINT `trades_stock_id_foreign` FOREIGN KEY (`stock_id`) REFERENCES `stocks` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trades`
--

LOCK TABLES `trades` WRITE;
/*!40000 ALTER TABLE `trades` DISABLE KEYS */;
INSERT INTO `trades` VALUES (1,113,1000,'open',NULL,2026,'2026-08-02 14:08:14','2026-08-23 13:54:39'),(2,69,5000,'open',NULL,2026,'2026-08-02 14:08:28','2026-08-10 11:55:41'),(3,130,724,'open',NULL,2026,'2026-08-02 14:08:55','2026-08-06 11:51:40'),(4,96,5000,'open',NULL,2026,'2026-08-02 14:09:28','2026-08-31 13:35:43'),(5,234,1000,'open',NULL,2026,'2026-08-02 14:09:41','2026-08-26 12:29:18'),(6,118,1400,'open',NULL,2026,'2026-08-02 14:09:58','2026-08-17 12:31:48'),(7,235,0,'close',NULL,2025,'2026-08-02 16:57:18','2026-08-02 16:57:18'),(8,7,0,'close',NULL,2025,'2026-08-02 16:58:02','2026-08-02 16:58:02'),(9,98,0,'close',NULL,2025,'2026-08-02 16:59:26','2026-08-02 16:59:26'),(10,91,0,'close',NULL,2025,'2026-08-02 16:59:52','2026-08-02 16:59:52'),(11,2,0,'close',NULL,2025,'2026-08-02 17:00:26','2026-08-02 17:00:26'),(12,39,0,'close',NULL,2025,'2026-08-02 17:01:13','2026-08-02 17:01:13'),(13,116,0,'close',NULL,2025,'2026-08-02 17:02:02','2026-08-02 17:02:02'),(14,117,0,'close',NULL,2025,'2026-08-02 17:02:48','2026-08-02 17:02:48'),(15,3,0,'close',NULL,2025,'2026-08-02 17:03:28','2026-08-02 17:03:28'),(16,188,0,'close',NULL,2025,'2026-08-02 17:04:06','2026-08-02 17:04:06'),(17,71,0,'close',NULL,2025,'2026-08-02 17:04:33','2026-08-02 17:04:33'),(18,179,0,'close',NULL,2025,'2026-08-02 17:05:22','2026-08-02 17:05:22'),(19,94,0,'close',NULL,2025,'2026-08-02 17:05:50','2026-08-02 17:05:50'),(20,153,0,'close',NULL,2025,'2026-08-02 17:06:17','2026-08-02 17:06:17'),(21,223,0,'close',NULL,2025,'2026-08-02 17:06:56','2026-08-02 17:06:56'),(22,212,0,'close',NULL,2025,'2026-08-02 17:07:26','2026-08-02 17:07:26'),(23,210,0,'close',NULL,2025,'2026-08-02 17:07:53','2026-08-02 17:07:53'),(24,121,0,'close',NULL,2025,'2026-08-02 17:08:54','2026-08-02 17:08:54'),(25,118,0,'close',NULL,2025,'2026-08-02 17:09:35','2026-08-02 17:09:35'),(26,33,0,'close',NULL,2025,'2026-08-02 17:10:02','2026-08-02 17:10:02'),(27,80,0,'close',NULL,2025,'2026-08-02 17:10:46','2026-08-02 17:10:46'),(28,106,0,'close',NULL,2026,'2026-08-02 17:11:18','2026-08-02 17:11:18'),(29,107,0,'close',NULL,2025,'2026-08-02 17:12:15','2026-08-02 17:12:15'),(30,74,0,'close',NULL,2025,'2026-08-02 17:13:02','2026-08-02 17:13:02'),(31,169,550,'open',NULL,2025,'2026-08-02 17:13:28','2026-08-24 12:15:16'),(32,122,0,'close',NULL,2026,'2026-08-02 17:14:05','2026-08-02 17:19:07'),(33,175,0,'close',NULL,2025,'2026-08-02 17:15:04','2026-08-02 17:15:04'),(34,19,0,'close',NULL,2025,'2026-08-02 17:15:52','2026-08-02 17:15:52'),(35,233,0,'close',NULL,2025,'2026-08-02 17:16:15','2026-08-02 17:16:15'),(36,69,0,'close',NULL,2025,'2026-08-02 17:17:42','2026-08-02 17:17:42'),(37,230,0,'close',NULL,2025,'2026-08-02 18:02:20','2026-08-02 18:02:20'),(38,113,0,'close','2026-06-01 16:58:29',2026,'2026-08-02 18:02:47','2026-08-18 13:58:41'),(39,52,0,'close',NULL,2026,'2026-08-02 18:05:09','2026-08-02 18:05:09'),(40,236,0,'close',NULL,2026,'2026-08-03 09:57:06','2026-08-03 09:57:06'),(41,38,0,'close',NULL,2026,'2026-08-03 11:34:05','2026-08-03 11:34:05'),(42,71,0,'close',NULL,2026,'2026-08-04 13:03:31','2026-08-04 13:04:55');
/*!40000 ALTER TABLE `trades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin User','admin@example.com',NULL,'$2y$12$eoI78NcO/YE5nqpaMRbLq.4bP5u96qx0BTjGEL9FI.m/Jkr/FS4Uu','xfqkCwKJ9EyUgUtqXITWVVUCIp8oNtj2woY3z3wojaQuA9YfLWIRGa0bzuVG','2026-08-02 14:00:07','2026-08-02 14:00:07');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wallet_logs`
--

DROP TABLE IF EXISTS `wallet_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wallet_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `wallet_id` bigint unsigned NOT NULL,
  `trade_track_id` bigint unsigned DEFAULT NULL,
  `trade_id` bigint unsigned DEFAULT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaction_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(15,2) NOT NULL,
  `cash_change` decimal(15,2) NOT NULL,
  `cash_before` decimal(15,2) NOT NULL,
  `cash_after` decimal(15,2) NOT NULL,
  `save_cloud_before` decimal(15,2) DEFAULT NULL,
  `save_cloud_after` decimal(15,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `wallet_logs_wallet_id_foreign` (`wallet_id`),
  KEY `wallet_logs_trade_track_id_index` (`trade_track_id`),
  KEY `wallet_logs_trade_id_index` (`trade_id`),
  CONSTRAINT `wallet_logs_wallet_id_foreign` FOREIGN KEY (`wallet_id`) REFERENCES `wallets` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wallet_logs`
--

LOCK TABLES `wallet_logs` WRITE;
/*!40000 ALTER TABLE `wallet_logs` DISABLE KEYS */;
INSERT INTO `wallet_logs` VALUES (5,1,189,31,'created','sell',6524.55,6524.55,4315.00,10839.55,NULL,NULL,'2026-08-30 12:42:08','2026-08-30 12:42:08'),(6,1,190,31,'created','buy',-6495.34,-6495.34,10839.55,4344.21,NULL,NULL,'2026-08-30 12:42:41','2026-08-30 12:42:41'),(7,1,191,5,'created','profit',855.00,855.00,4344.21,5199.21,NULL,NULL,'2026-08-31 12:27:03','2026-08-31 12:27:03'),(8,1,192,4,'created','buy',-4052.56,-4052.56,5199.21,1146.65,NULL,NULL,'2026-08-31 13:36:12','2026-08-31 13:36:12');
/*!40000 ALTER TABLE `wallet_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wallets`
--

DROP TABLE IF EXISTS `wallets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wallets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `cash` decimal(15,2) NOT NULL DEFAULT '0.00',
  `save_cloud` decimal(15,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `wallets_user_id_unique` (`user_id`),
  CONSTRAINT `wallets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wallets`
--

LOCK TABLES `wallets` WRITE;
/*!40000 ALTER TABLE `wallets` DISABLE KEYS */;
INSERT INTO `wallets` VALUES (1,1,1146.65,17898.00,'2026-08-02 14:00:40','2026-08-31 13:36:12');
/*!40000 ALTER TABLE `wallets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `withdrawals`
--

DROP TABLE IF EXISTS `withdrawals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `withdrawals` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `withdrawal_date` date NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `withdrawals_user_id_foreign` (`user_id`),
  CONSTRAINT `withdrawals_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `withdrawals`
--

LOCK TABLES `withdrawals` WRITE;
/*!40000 ALTER TABLE `withdrawals` DISABLE KEYS */;
INSERT INTO `withdrawals` VALUES (1,1,10000.00,'2026-05-01',NULL,'2026-08-02 14:03:14','2026-08-02 14:03:14'),(2,1,10000.00,'2026-07-05',NULL,'2026-08-02 14:03:29','2026-08-02 14:03:29'),(3,1,5000.00,'2026-08-12',NULL,'2026-08-12 13:38:06','2026-08-12 13:38:06');
/*!40000 ALTER TABLE `withdrawals` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-09-01 11:00:01
