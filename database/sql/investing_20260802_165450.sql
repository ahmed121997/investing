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
INSERT INTO `cache` VALUES ('investing-cache-livewire-rate-limiter:16d36dff9abd246c67dfac3e63b993a169af77e6','i:1;',1785676497),('investing-cache-livewire-rate-limiter:16d36dff9abd246c67dfac3e63b993a169af77e6:timer','i:1785676497;',1785676497);
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deposits`
--

LOCK TABLES `deposits` WRITE;
/*!40000 ALTER TABLE `deposits` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2026_08_02_000000_create_stock_fee_settings_table',1),(2,'0001_01_01_000000_create_users_table',2),(3,'0001_01_01_000001_create_cache_table',2),(4,'0001_01_01_000002_create_jobs_table',2),(5,'2026_01_26_140835_create_deposits_table',2),(6,'2026_01_26_140836_create_withdrawals_table',2),(7,'2026_01_26_143201_add_avatar_to_users_table',2),(8,'2026_01_26_143312_create_media_table',2),(9,'2026_05_07_000000_create_stocks_table',2),(10,'2026_05_07_131708_create_trades_table',2),(11,'2026_05_07_141328_create_trade_tracks_table',2),(12,'2026_05_10_000000_create_wallets_table',2),(13,'2026_06_03_162525_add_year_to_trades_table',2),(14,'2026_06_04_000000_create_sectors_table',2),(15,'2026_06_04_000001_add_sector_id_to_stocks_table',2);
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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sectors`
--

LOCK TABLES `sectors` WRITE;
/*!40000 ALTER TABLE `sectors` DISABLE KEYS */;
INSERT INTO `sectors` VALUES (1,'Banks','بنوك','2026-08-02 13:12:34','2026-08-02 13:12:34'),(2,'Basic Resources','موارد أساسية','2026-08-02 13:12:34','2026-08-02 13:12:34'),(3,'Healthcare & Pharmaceuticals','رعاية صحية و ادوية','2026-08-02 13:12:34','2026-08-02 13:12:34'),(4,'Industrial Products & Services & Automobiles','خدمات و منتجات صناعية وسيارات','2026-08-02 13:12:34','2026-08-02 13:12:34'),(5,'Real Estate','عقارات','2026-08-02 13:12:34','2026-08-02 13:12:34'),(6,'Tourism & Recreation','سياحة وترفيه','2026-08-02 13:12:34','2026-08-02 13:12:34'),(7,'Utilities','مرافق','2026-08-02 13:12:34','2026-08-02 13:12:34'),(8,'Telecommunications & Media & IT','اتصالات و اعلام و تكنولوجيا المعلومات','2026-08-02 13:12:34','2026-08-02 13:12:34'),(9,'Food, Beverages & Tobacco','أغذية و مشروبات و تبغ','2026-08-02 13:12:34','2026-08-02 13:12:34'),(10,'Energy & Support Services','طاقة وخدمات مساندة','2026-08-02 13:12:34','2026-08-02 13:12:34'),(11,'Trade & Distribution','تجارة و موزعون','2026-08-02 13:12:34','2026-08-02 13:12:34'),(12,'Transportation & Shipping Services','خدمات النقل والشحن','2026-08-02 13:12:34','2026-08-02 13:12:34'),(13,'Educational Services','خدمات تعليمية','2026-08-02 13:12:34','2026-08-02 13:12:34'),(14,'Non-Banking Financial Services','خدمات مالية غير مصرفية','2026-08-02 13:12:34','2026-08-02 13:12:34'),(15,'Contracting & Engineering Construction','مقاولات و إنشاءات هندسية','2026-08-02 13:12:34','2026-08-02 13:12:34'),(16,'Textiles & Durable Goods','منسوجات و سلع معمرة','2026-08-02 13:12:34','2026-08-02 13:12:34'),(17,'Building Materials','مواد البناء','2026-08-02 13:12:34','2026-08-02 13:12:34'),(18,'Paper, Packaging & Wrapping Materials','ورق ومواد تعبئة و تغليف','2026-08-02 13:12:34','2026-08-02 13:12:34');
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
INSERT INTO `sessions` VALUES ('HXEoNp1xUDMKZoAxoqTGE0tifD3a3ZA4ewSoEJNe',1,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','YTo3OntzOjY6Il90b2tlbiI7czo0MDoiTXA0Um9kWmtJSGtvZTFqUThQWkRwU0JOdFpOdWc3enBrU0plY3VzNSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2NDoiYThmZjdhNzcyNzZmODc1NTVjMmRhNTc5ZGQyODMxYzY2MzIyYjdhNDI1YWY4ZDcyMjM0YzE5MmNiZTAyMDA0NSI7czo2OiJ0YWJsZXMiO2E6Mjp7czo0MDoiOTYyMjFlZDg3ZGU5OGViYTJhNzU3NWEyNTZhZWQxYTdfY29sdW1ucyI7YTo3OntpOjA7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTA6InN0b2NrLm5hbWUiO3M6NToibGFiZWwiO3M6NToiU3RvY2siO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToxO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjY6ImFtb3VudCI7czo1OiJsYWJlbCI7czo2OiJBbW91bnQiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToyO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEzOiJjdXJyZW50X3RvdGFsIjtzOjU6ImxhYmVsIjtzOjEzOiJDdXJyZW50IFRvdGFsIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MzthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxOToidG90YWxfdHJhZGVzX2Ftb3VudCI7czo1OiJsYWJlbCI7czoxMzoiVHJhZGVzIEFtb3VudCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjQ7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTE6InByb2ZpdF9sb3NzIjtzOjU6ImxhYmVsIjtzOjExOiJQcm9maXQvTG9zcyI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjU7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6Njoic3RhdHVzIjtzOjU6ImxhYmVsIjtzOjY6IlN0YXR1cyI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjY7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTA6ImNyZWF0ZWRfYXQiO3M6NToibGFiZWwiO3M6NzoiQ3JlYXRlZCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO319czo0MDoiYmMxZWI0YjMyNWFiZmNlZTNmNWE4MmYyMDcyMWIxYTFfY29sdW1ucyI7YTozOntpOjA7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NDoiZGF0ZSI7czo1OiJsYWJlbCI7czo0OiJEYXRlIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo2OiJhbW91bnQiO3M6NToibGFiZWwiO3M6NjoiQW1vdW50IjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MjthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo0OiJ0eXBlIjtzOjU6ImxhYmVsIjtzOjQ6IlR5cGUiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9fX1zOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czoyNzoiaHR0cDovL2ludmVzdGluZy50ZXN0L2FkbWluIjtzOjU6InJvdXRlIjtzOjMwOiJmaWxhbWVudC5hZG1pbi5wYWdlcy5kYXNoYm9hcmQiO31zOjg6ImZpbGFtZW50IjthOjA6e319',1783263057),('nU4V6FbJhkQciJOL9ZPVrja0B3oM2hoFFLgwHXYb',1,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','YTo3OntzOjY6Il90b2tlbiI7czo0MDoiVGxuMWZLZHFYRllubm1UcWhZbjI3dEJyaGZSQVA1b2pOdm15Nm5zMiI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjM0OiJodHRwOi8vaW52ZXN0aW5nLnRlc3QvYWRtaW4vdHJhZGVzIjtzOjU6InJvdXRlIjtzOjM3OiJmaWxhbWVudC5hZG1pbi5yZXNvdXJjZXMudHJhZGVzLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2NDoiMDk3NjY1OTY4YjJkZjFiYmUwOTA4OWNlNWU5YjZhZDNjYTJkZWZhMTE2OTgzM2Q1YmRkM2FkZTViMmQ4ZThjYSI7czo2OiJ0YWJsZXMiO2E6Nzp7czo0MDoiOTYyMjFlZDg3ZGU5OGViYTJhNzU3NWEyNTZhZWQxYTdfY29sdW1ucyI7YTo3OntpOjA7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTA6InN0b2NrLm5hbWUiO3M6NToibGFiZWwiO3M6NToiU3RvY2siO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToxO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjY6ImFtb3VudCI7czo1OiJsYWJlbCI7czo2OiJBbW91bnQiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToyO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEzOiJjdXJyZW50X3RvdGFsIjtzOjU6ImxhYmVsIjtzOjEzOiJDdXJyZW50IFRvdGFsIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MzthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxOToidG90YWxfdHJhZGVzX2Ftb3VudCI7czo1OiJsYWJlbCI7czoxMzoiVHJhZGVzIEFtb3VudCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjQ7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTE6InByb2ZpdF9sb3NzIjtzOjU6ImxhYmVsIjtzOjExOiJQcm9maXQvTG9zcyI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjU7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6Njoic3RhdHVzIjtzOjU6ImxhYmVsIjtzOjY6IlN0YXR1cyI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjY7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTA6ImNyZWF0ZWRfYXQiO3M6NToibGFiZWwiO3M6NzoiQ3JlYXRlZCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO319czo0MToiOTYyMjFlZDg3ZGU5OGViYTJhNzU3NWEyNTZhZWQxYTdfcGVyX3BhZ2UiO3M6MjoiNTAiO3M6NDA6ImIzNDk1ZmNkMDNlNjEzYTQ2ZTIwYTIzMDg2NDc4OTcwX2NvbHVtbnMiO2E6Mjp7aTowO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjQ6Im5hbWUiO3M6NToibGFiZWwiO3M6MTQ6Ik5hbWUgKEVuZ2xpc2gpIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo3OiJuYW1lX2FyIjtzOjU6ImxhYmVsIjtzOjEzOiJOYW1lIChBcmFiaWMpIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fX1zOjQwOiI0N2U2NzhjOGEyZTdhMjEwNjliZmY4NWQ4Y2M1NzkwZV9jb2x1bW5zIjthOjY6e2k6MDthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo0OiJuYW1lIjtzOjU6ImxhYmVsIjtzOjQ6Ik5hbWUiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToxO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjQ6ImNvZGUiO3M6NToibGFiZWwiO3M6NDoiQ29kZSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjI7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTQ6InNlY3Rvci5uYW1lX2FyIjtzOjU6ImxhYmVsIjtzOjY6IlNlY3RvciI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjM7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NjoibWFya2V0IjtzOjU6ImxhYmVsIjtzOjY6Ik1hcmtldCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjQ7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NToicHJpY2UiO3M6NToibGFiZWwiO3M6NToiUHJpY2UiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo1O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEwOiJ1cGRhdGVkX2F0IjtzOjU6ImxhYmVsIjtzOjEyOiJMYXN0IFVwZGF0ZWQiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9fXM6NDA6IjUxYjgwZWI4MWI4YjczOThhNDdjN2VkMjRhOWNmOTA4X2NvbHVtbnMiO2E6NDp7aTowO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjk6InVzZXIubmFtZSI7czo1OiJsYWJlbCI7czo0OiJVc2VyIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo2OiJhbW91bnQiO3M6NToibGFiZWwiO3M6NjoiQW1vdW50IjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MjthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxNToid2l0aGRyYXdhbF9kYXRlIjtzOjU6ImxhYmVsIjtzOjE1OiJXaXRoZHJhd2FsIERhdGUiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTozO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjExOiJkZXNjcmlwdGlvbiI7czo1OiJsYWJlbCI7czoxMToiRGVzY3JpcHRpb24iO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9fXM6NDA6IjY3YzRkMzE5NmYzZjMyMGQxMTc0ZTM1M2IwMGM0ZjI0X2NvbHVtbnMiO2E6NDp7aTowO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjk6InVzZXIubmFtZSI7czo1OiJsYWJlbCI7czo0OiJVc2VyIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo2OiJhbW91bnQiO3M6NToibGFiZWwiO3M6NjoiQW1vdW50IjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MjthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMjoiZGVwb3NpdF9kYXRlIjtzOjU6ImxhYmVsIjtzOjEyOiJEZXBvc2l0IERhdGUiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTozO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjExOiJkZXNjcmlwdGlvbiI7czo1OiJsYWJlbCI7czoxMToiRGVzY3JpcHRpb24iO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9fXM6NDA6ImJjMWViNGIzMjVhYmZjZWUzZjVhODJmMjA3MjFiMWExX2NvbHVtbnMiO2E6Mzp7aTowO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjQ6ImRhdGUiO3M6NToibGFiZWwiO3M6NDoiRGF0ZSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjE7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NjoiYW1vdW50IjtzOjU6ImxhYmVsIjtzOjY6IkFtb3VudCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjI7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NDoidHlwZSI7czo1OiJsYWJlbCI7czo0OiJUeXBlIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fX19fQ==',1785678313);
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
  `egx_fee_percentage` double DEFAULT NULL,
  `misr_clearing_fee_percentage` double DEFAULT NULL,
  `fra_fee_percentage` double DEFAULT NULL,
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
INSERT INTO `stock_fee_settings` VALUES (1,0,0,0,0,0,0,'2026-08-02 12:36:56','2026-08-02 12:36:56');
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
) ENGINE=InnoDB AUTO_INCREMENT=250 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stocks`
--

LOCK TABLES `stocks` WRITE;
/*!40000 ALTER TABLE `stocks` DISABLE KEYS */;
INSERT INTO `stocks` VALUES (1,'العامة لاستصلاح الأراضي والتنمية والتعمير','AALR','EGX',206.23,'2026-05-07 09:56:19','2026-07-05 11:50:03',15),(2,'أبو قير للأسمدة و الصناعات الكيماوية','ABUK','EGX',69.7,'2026-05-07 09:56:19','2026-07-05 11:50:04',2),(3,'الشركة العربية لإدارة وتطوير الأصول','ACAMD','EGX',2.31,'2026-05-07 09:56:19','2026-07-05 11:50:04',5),(4,'ايه كابيتال القابضة','ACAP','EGX',8.58,'2026-05-07 09:56:19','2026-07-05 11:50:05',5),(5,'العربية لحليج الأقطان','ACGC','EGX',9.34,'2026-05-07 09:56:19','2026-07-05 11:50:05',16),(7,'أكت فاينانشال للاستشارات ش م م','ACTF','EGX',2.67,'2026-05-07 09:56:19','2026-07-05 11:50:06',12),(8,'العربية للأدوية والصناعات الكيماوية','ADCI','EGX',238.5,'2026-05-07 09:56:19','2026-07-05 11:50:07',3),(9,'مصرف أبو ظبي الإسلامي - مصر','ADIB','EGX',46.7,'2026-05-07 09:56:19','2026-07-05 11:50:07',1),(10,'العربية لمنتجات الألبان','ADPC','EGX',3.48,'2026-05-07 09:56:19','2026-07-05 11:50:08',9),(11,'آراب للتنمية والاستثمار العقاري','ADRI','EGX',7.26,'2026-05-07 09:56:19','2026-07-05 11:50:08',14),(12,'الأهلي للتنمية والاستثمار','AFDI','EGX',44.31,'2026-05-07 09:56:19','2026-07-05 11:50:09',14),(13,'مطاحن ومخابز الإسكندرية','AFMC','EGX',71.94,'2026-05-07 09:56:19','2026-07-05 11:50:10',9),(14,'ارابيا انفستمنتس هولدنج','AIDC','EGX',0.662,'2026-05-07 09:56:19','2026-07-05 11:50:10',14),(15,'أطلس للاستثمار والصناعات الغذائية','AIFI','EGX',2.01,'2026-05-07 09:56:19','2026-07-05 11:50:11',9),(17,'أجواء للصناعات الغذائية - مصر','AJWA','EGX',179.96,'2026-05-07 09:56:19','2026-07-05 11:50:12',9),(18,'الاسكندرية لتداول الحاويات والبضائع','ALCN','EGX',28.26,'2026-05-07 09:56:19','2026-07-05 11:50:13',12),(19,'الألومنيوم العربية','ALUM','EGX',22,'2026-05-07 09:56:19','2026-07-05 11:50:13',2),(20,'مجموعة عامر القابضة','AMER','EGX',2.48,'2026-05-07 09:56:19','2026-07-05 11:50:14',5),(21,'الإسكندرية للخدمات الطبية المركز الطبي الجديد','AMES','EGX',60.18,'2026-05-07 09:56:19','2026-07-05 11:50:15',3),(22,'الملتقى العربي للاستثمارات','AMIA','EGX',8.71,'2026-05-07 09:56:19','2026-07-05 11:50:15',14),(23,'الاسكندرية للزيوت المعدنية','AMOC','EGX',7.85,'2026-05-07 09:56:19','2026-07-05 11:50:16',10),(24,'نوفيدا للاستثمار والتكنولوجيا','AMPI','EGX',2.59,'2026-05-07 09:56:19','2026-07-05 11:50:16',8),(25,'العربية وبولفارا للغزل والنسيج','APSW','EGX',8.54,'2026-05-07 09:56:19','2026-07-05 11:50:17',16),(26,'المطورون العرب القابضة','ARAB','EGX',0.216,'2026-05-07 09:56:19','2026-07-05 11:50:17',5),(27,'العربية للأسمنت','ARCC','EGX',56.25,'2026-05-07 09:56:19','2026-07-05 11:50:18',17),(28,'المجموعة المصرية العقارية','AREH','EGX',1.37,'2026-05-07 09:56:19','2026-08-02 13:12:25',5),(29,'العربية للمحابس','ARVA','EGX',10.89,'2026-05-07 09:56:19','2026-07-05 11:50:20',17),(30,'أسيك للتعدين','ASCM','EGX',60.1,'2026-05-07 09:56:19','2026-07-05 11:50:20',2),(31,'اسباير كابيتال القابضة للاستثمارات المالية','ASPI','EGX',0.318,'2026-05-07 09:56:19','2026-07-05 11:50:21',14),(32,'التوفيق للتأجير التمويلي','ATLC','EGX',5.26,'2026-05-07 09:56:19','2026-07-05 11:50:22',14),(33,'مصر الوطنية للصلب','ATQA','EGX',9.56,'2026-05-07 09:56:19','2026-07-05 11:50:22',2),(34,'الاسكندرية للأدوية والصناعات الكيماوية','AXPH','EGX',1200.16,'2026-05-07 09:56:19','2026-07-05 11:50:23',3),(35,'بي إنفستمنتس القابضة','BINV','EGX',47.33,'2026-05-07 09:56:19','2026-07-05 11:50:24',14),(36,'جلاكسو سميثكلاين','BIOC','EGX',70.57,'2026-05-07 09:56:19','2026-07-05 11:50:25',3),(37,'بنيان للتنمية والتجارة','BONY','EGX',4.91,'2026-05-07 09:56:19','2026-07-05 11:50:25',5),(38,'بلتون المالية القابضة','BTFH','EGX',3,'2026-05-07 09:56:19','2026-07-05 11:50:26',14),(39,'بنك قناة السويس','CANA','EGX',33.45,'2026-05-07 09:56:19','2026-08-02 13:12:26',1),(40,'القاهرة للخدمات التعليمية','CAED','EGX',71.47,'2026-05-07 09:56:19','2026-07-05 11:50:27',13),(41,'شركة القلعة للاستشارات المالية ش.م.م','CCAP','EGX',5.13,'2026-05-07 09:56:19','2026-07-05 11:50:28',14),(42,'الخليجية الكندية للاستثمار العقاري العربي','CCRS','EGX',2.39,'2026-05-07 09:56:19','2026-07-05 11:50:28',5),(43,'مطاحن مصر الوسطى','CEFM','EGX',100.65,'2026-05-07 09:56:19','2026-07-05 11:50:29',9),(44,'العربية للخزف سيراميكا','CERA','EGX',1.23,'2026-05-07 09:56:19','2026-07-05 11:50:30',17),(45,'العرفة للاستثمارات والاستشارات','CFGH','EGX',0.11,'2026-05-07 09:56:19','2026-08-02 13:12:26',14),(46,'سي آي كابيتال القابضة للاستثمارات المالية','CICH','EGX',11.98,'2026-05-07 09:56:19','2026-07-05 11:50:31',14),(47,'بنك كريدي أجريكول مصر','CIEB','EGX',24.44,'2026-05-07 09:56:19','2026-07-05 11:50:31',1),(48,'القاهرة للاستثمار والتنمية العقارية','CIRA','EGX',28.2,'2026-05-07 09:56:19','2026-07-05 11:50:32',13),(49,'شركة مستشفي كليوباترا','CLHO','EGX',16.4,'2026-05-07 09:56:19','2026-07-05 11:50:33',3),(50,'كونتكت المالية القابضة','CNFN','EGX',4.77,'2026-05-07 09:56:19','2026-07-05 11:50:34',14),(51,'البنك التجاري الدولي (مصر)','COMI','EGX',129.71,'2026-05-07 09:56:19','2026-07-05 11:50:35',1),(52,'كوبر للاستثمار التجاري والتطوير العقاري','COPR','EGX',0.363,'2026-05-07 09:56:19','2026-07-05 11:50:35',15),(53,'القاهره للزيوت والصابون','COSG','EGX',1.56,'2026-05-07 09:56:19','2026-07-05 11:50:36',9),(54,'القاهرة للأدوية والصناعات الكيماوية','CPCI','EGX',400.02,'2026-05-07 09:56:19','2026-07-05 11:50:37',3),(55,'كريست مارك للمقاولات والتطوير العقاري','CRST','EGX',1.36,'2026-05-07 09:56:19','2026-07-05 11:50:37',15),(56,'القناة للتوكيلات الملاحية','CSAG','EGX',32.52,'2026-05-07 09:56:19','2026-07-05 11:50:38',12),(57,'التعمير والاستشارات الهندسية','DAPH','EGX',82.96,'2026-05-07 09:56:19','2026-07-05 11:50:39',5),(58,'الدلتا للتأمين','DEIN','EGX',12.14,'2026-05-07 09:56:19','2026-08-02 13:12:26',3),(59,'ديجيتايز للاستثمار والتقنية','DGTZ','EGX',2.63,'2026-05-07 09:56:19','2026-07-05 11:50:40',8),(60,'الصناعات الغذائية العربية','DOMT','EGX',27.21,'2026-05-07 09:56:19','2026-07-05 11:50:41',9),(61,'دايس للملابس الجاهزة','DSCW','EGX',1.74,'2026-05-07 09:56:19','2026-07-05 11:50:41',16),(62,'دلتا للطباعة والتغليف','DTPP','EGX',204,'2026-05-07 09:56:19','2026-07-05 11:50:42',4),(63,'العربية لاستصلاح الاراضي','EALR','EGX',341.09,'2026-05-07 09:56:19','2026-07-05 11:50:43',15),(64,'المصرية العربية ثمار لتداول الأوراق المالية','EASB','EGX',7.38,'2026-05-07 09:56:19','2026-07-05 11:50:43',14),(65,'الشرقية - ايسترن كومباني','EAST','EGX',37.2,'2026-05-07 09:56:19','2026-07-05 11:50:44',9),(66,'اصول إى إس بى للوساطة في الاوراق المالية','EBSC','EGX',2.05,'2026-05-07 09:56:19','2026-07-05 11:50:45',14),(67,'العز للسيراميك والبورسلين','ECAP','EGX',33.01,'2026-05-07 09:56:19','2026-07-05 11:50:45',17),(68,'مطاحن شرق الدلتا','EDFM','EGX',320.43,'2026-05-07 09:56:19','2026-07-05 11:50:46',9),(69,'العربية للصناعات الهندسية','EEII','EGX',2.73,'2026-05-07 09:56:19','2026-07-05 11:50:47',4),(70,'المالية والصناعية المصرية','EFIC','EGX',185.57,'2026-05-07 09:56:19','2026-07-05 11:50:48',2),(71,'إيديتا للصناعات الغذائية','EFID','EGX',28.36,'2026-05-07 09:56:19','2026-07-05 11:50:48',9),(72,'اي فاينانس للاستثمارات المالية والرقمية','EFIH','EGX',21.5,'2026-05-07 09:56:19','2026-07-05 11:50:49',8),(73,'مصر للالومنيوم','EGAL','EGX',294.02,'2026-05-07 09:56:19','2026-07-05 11:50:49',2),(74,'غاز مصر','EGAS','EGX',49.72,'2026-05-07 09:56:19','2026-07-05 11:50:50',7),(75,'البنك المصري الخليجي','EGBE','EGX',0.456,'2026-05-07 09:56:19','2026-07-05 11:50:51',1),(76,'الصناعات الكيماوية المصرية','EGCH','EGX',12.7,'2026-05-07 09:56:19','2026-07-05 11:50:51',2),(77,'صندوق المصريين للاستثمار العقاري','EGREF','EGX',13.45,'2026-05-07 09:56:19','2026-07-05 11:50:52',14),(78,'المصرية للأقمار الصناعية','EGSA','EGX',8.93,'2026-05-07 09:56:19','2026-08-02 13:12:26',8),(79,'المصرية للمنتجعات السياحية','EGTS','EGX',19.21,'2026-05-07 09:56:19','2026-07-05 11:50:53',6),(80,'المصريين للاسكان والتنمية والتعمير','EHDR','EGX',2.57,'2026-05-07 09:56:19','2026-07-05 11:50:54',5),(81,'الكابلات الكهربائية المصرية','ELEC','EGX',2.08,'2026-05-07 09:56:19','2026-07-05 11:50:55',4),(82,'القاهرة للإسكان والتعمير','ELKA','EGX',1.44,'2026-05-07 09:56:19','2026-07-05 11:50:55',5),(83,'النصر لتصنيع الحاصلات الزراعية','ELNA','EGX',39.68,'2026-05-07 09:56:19','2026-08-02 13:12:26',9),(84,'الشمس للإسكان والتعمير','ELSH','EGX',13.83,'2026-05-07 09:56:19','2026-07-05 11:50:56',5),(85,'الوادى العالمية للاستثمار و التنمية','ELWA','EGX',1.98,'2026-05-07 09:56:19','2026-07-05 11:50:57',6),(86,'إعمار مصر للتنمية','EMFD','EGX',11.75,'2026-05-07 09:56:19','2026-07-05 11:50:58',5),(87,'الصناعات الهندسية المعمارية للانشاء والتعمير','ENGC','EGX',37.08,'2026-05-07 09:56:19','2026-07-05 11:50:58',15),(88,'العروبة للسمسرة في الاوراق المالية','EOSB','EGX',1.49,'2026-05-07 09:56:19','2026-08-02 13:12:26',14),(89,'المصرية للدواجن','EPCO','EGX',8.8,'2026-05-07 09:56:19','2026-07-05 11:50:59',9),(90,'الاهرام للطباعة والتغليف','EPPK','EGX',14.53,'2026-05-07 09:56:19','2026-07-05 11:51:00',18),(91,'المصرية للاتصالات','ETEL','EGX',92.77,'2026-05-07 09:56:19','2026-07-05 11:51:01',8),(92,'المصرية لخدمات النقل','ETRS','EGX',10.76,'2026-05-07 09:56:19','2026-07-05 11:51:01',12),(93,'البنك المصري لتنمية الصادرات','EXPA','EGX',18.73,'2026-05-07 09:56:19','2026-07-05 11:51:02',1),(94,'بنك فيصل الإسلامي المصري بالجنيه','FAIT','EGX',36.63,'2026-05-07 09:56:19','2026-07-05 11:51:02',1),(95,'بنك فيصل الإسلامي المصري بالدولار','FAITA','EGX',0.98,'2026-05-07 09:56:19','2026-07-05 11:51:03',1),(96,'فيوتشر كير للصناعات الطبية','FCMD','EGX',6.52,'2026-05-07 09:56:19','2026-07-05 11:51:04',3),(98,'فوري لتكنولوجيا البنوك والمدفوعات الإلكترونية','FWRY','EGX',18.41,'2026-05-07 09:56:19','2026-07-05 11:51:05',1),(99,'جى بى كوربوريشن','GBCO','EGX',31.17,'2026-05-07 09:56:19','2026-07-05 11:51:06',4),(100,'جدوى للتنمية الصناعية','GDWA','EGX',0.765,'2026-05-07 09:56:19','2026-07-05 11:51:07',4),(101,'الجيزة العامة للمقاولات والاستثمار العقاري','GGCC','EGX',0.518,'2026-05-07 09:56:19','2026-07-05 11:51:07',15),(102,'جو جرين للاستثمار الزراعى والتنمية','GGRN','EGX',1.43,'2026-05-07 09:56:19','2026-07-05 11:51:08',9),(103,'الغربية الإسلامية للتنمية العمرانية','GIHD','EGX',43.37,'2026-05-07 09:56:19','2026-07-05 11:51:09',5),(104,'مجموعة جى . أم . سى للاستثمارات الصناعية والتجارية المالية','GMCI','EGX',1.95,'2026-05-07 09:56:19','2026-07-05 11:51:09',11),(106,'جورميه ايجيبت دوت كوم للاغذية','GOUR','EGX',13.32,'2026-05-07 09:56:19','2026-07-05 11:51:10',11),(107,'جي بي آي للنمو العمراني','GPIM','EGX',1.14,'2026-05-07 09:56:19','2026-07-05 11:51:11',15),(109,'جراند انفستمنت القابضة للاستثمارات المالية','GRCA','EGX',51.72,'2026-05-07 09:56:19','2026-07-05 11:51:11',14),(110,'العامة للصوامع والتخزين','GSSC','EGX',248.17,'2026-05-07 09:56:19','2026-07-05 11:51:12',9),(111,'جيتكس للاستثمارات التجارية والصناعية','GTEX','EGX',0.03,'2026-05-07 09:56:19','2026-08-02 13:12:26',16),(112,'جولدن تكس للاصواف','GTWL','EGX',89.27,'2026-05-07 09:56:19','2026-07-05 11:51:13',16),(113,'هيبكو للاستثمارات التجارية والتنمية العقارية','HBCO','EGX',7.91,'2026-05-07 09:56:19','2026-08-02 13:12:26',NULL),(115,'بنك التعمير والإسكان','HDBK','EGX',169,'2026-05-07 09:56:19','2026-07-05 11:51:15',1),(116,'مصر الجديدة للاسكان والتعمير','HELI','EGX',6.64,'2026-05-07 09:56:19','2026-07-05 11:51:15',5),(117,'المجموعة المالية هيرمس القابضة','HRHO','EGX',26.77,'2026-05-07 09:56:19','2026-07-05 11:51:16',14),(118,'الدولية للأسمدة والكيماويات','ICFC','EGX',14.75,'2026-05-07 09:56:19','2026-07-05 11:51:17',11),(119,'العالمية للاستثمار والتنمية','ICID','EGX',7.97,'2026-05-07 09:56:19','2026-07-05 11:51:17',5),(120,'الدولية للتأجير التمويلي','ICLE','EGX',15.76,'2026-05-07 09:56:19','2026-08-02 11:51:20',NULL),(121,'الإسماعيلية الجديدة للتطوير والتنمية العمرانية','IDRE','EGX',44.73,'2026-05-07 09:56:19','2026-07-05 11:51:19',NULL),(122,'المشروعات الصناعية والهندسية','IEEC','EGX',0.49,'2026-05-07 09:56:19','2026-07-05 11:51:19',15),(123,'الدولية للمحاصيل الزراعية','IFAP','EGX',19.45,'2026-05-07 09:56:19','2026-07-05 11:51:20',NULL),(124,'المجموعة المتكاملة للأعمال الهندسية','INEG','EGX',0.428,'2026-05-07 09:56:19','2026-07-05 11:51:20',NULL),(125,'الاسماعيلية الوطنية للصناعات الغذائية','INFI','EGX',93.73,'2026-05-07 09:56:19','2026-07-05 11:51:21',NULL),(126,'الحديد والصلب المصرية','IRON','EGX',32.02,'2026-05-07 09:56:19','2026-07-05 11:51:22',2),(127,'الاسماعيلية مصر للدواجن','ISMA','EGX',28.07,'2026-05-07 09:56:19','2026-07-05 11:51:22',9),(128,'الحديد والصلب للمناجم والمحاجر','ISMQ','EGX',9.9,'2026-05-07 09:56:19','2026-07-05 11:51:23',2),(129,'ابن سينا فارما','ISPH','EGX',11.16,'2026-05-07 09:56:19','2026-08-02 13:12:26',3),(130,'جهينة للصناعات الغذائية','JUFO','EGX',29.97,'2026-05-07 09:56:19','2026-07-05 11:51:24',9),(131,'النصر للملابس والمنسوجات','KABO','EGX',6.4,'2026-05-07 09:56:19','2026-07-05 11:51:25',NULL),(132,'نهر الخير للتنمية والأستثمار الزراعى والخدمات البيئي','KRDI','EGX',0.346,'2026-05-07 09:56:19','2026-07-05 11:51:26',NULL),(133,'القاهرة الوطنية للاستثمار والاوراق المالية','KWIN','EGX',68.22,'2026-05-07 09:56:19','2026-07-05 11:51:26',14),(134,'كفر الزيات للمبيدات والكيماويات','KZPC','EGX',8.56,'2026-05-07 09:56:19','2026-07-05 11:51:27',2),(135,'ليسيكو مصر','LCSW','EGX',28.41,'2026-05-07 09:56:19','2026-07-05 11:51:28',17),(136,'لوتس للتنمية والاستثمار الزراعي','LUTS','EGX',0.73,'2026-05-07 09:56:19','2026-07-05 11:51:29',NULL),(137,'مرسيليا المصرية الخليجية للاستثمار العقاري','MAAL','EGX',7.54,'2026-05-07 09:56:19','2026-07-05 11:51:29',NULL),(138,'مدينة نصر للاسكان والتعمير','MASR','EGX',7.56,'2026-05-07 09:56:19','2026-07-05 11:51:30',NULL),(139,'إم بي للهندسة والمقاولات','MBEG','EGX',3.82,'2026-05-07 09:56:19','2026-07-05 11:51:30',NULL),(140,'مصر بنى سويف للأسمنت','MBSC','EGX',244.18,'2026-05-07 09:56:19','2026-07-05 11:51:31',NULL),(141,'مصر للأسمنت','MCQE','EGX',194.52,'2026-05-07 09:56:19','2026-08-02 13:12:26',NULL),(142,'ماكرو جروب للمستحضرات الطبية','MCRO','EGX',1.23,'2026-05-07 09:56:19','2026-07-05 11:51:32',NULL),(144,'مينا للاستثمار السياحي والعقاري','MENA','EGX',5.87,'2026-05-07 09:56:19','2026-08-02 13:12:26',5),(145,'العبوات الطبية','MEPA','EGX',1.62,'2026-05-07 09:56:19','2026-07-05 11:51:34',3),(146,'مصر لإنتاج الأسمدة','MFPC','EGX',36.3,'2026-05-07 09:56:19','2026-07-05 11:51:35',NULL),(147,'مصر للأسواق الحرة','MFSC','EGX',49.7,'2026-05-07 09:56:19','2026-07-05 11:51:35',NULL),(148,'مصر للفنادق','MHOT','EGX',34.79,'2026-05-07 09:56:19','2026-07-05 11:51:36',6),(149,'مصر لصناعة الكيماويات','MICH','EGX',37.73,'2026-05-07 09:56:19','2026-07-05 11:51:37',2),(150,'مطاحن ومخابز شمال القاهرة','MILS','EGX',130.29,'2026-05-07 09:56:19','2026-07-05 11:51:37',9),(151,'مينا فارم للأدوية والصناعات الكيماوية','MIPH','EGX',661.65,'2026-05-07 09:56:19','2026-07-05 11:51:38',NULL),(153,'المصرية لنظم التعلم الحديثة','MOED','EGX',0.681,'2026-05-07 09:56:19','2026-07-05 11:51:39',NULL),(154,'الخدمات الملاحية والبترولية','MOIL','EGX',0.505,'2026-05-07 09:56:19','2026-07-05 11:51:40',NULL),(155,'المهندس للتأمين','MOIN','EGX',23.72,'2026-05-07 09:56:19','2026-07-05 11:51:40',14),(156,'مصر للزيوت والصابون','MOSC','EGX',269.87,'2026-05-07 09:56:19','2026-07-05 11:51:41',NULL),(157,'ممفيس للأدوية والصناعات الكيماوية','MPCI','EGX',246.21,'2026-05-07 09:56:19','2026-07-05 11:51:41',NULL),(158,'المنصورة للدواجن','MPCO','EGX',1.63,'2026-05-07 09:56:19','2026-08-02 13:12:26',9),(159,'المصرية لمدينة الإنتاج الإعلامي','MPRC','EGX',38.15,'2026-05-07 09:56:19','2026-07-05 11:51:43',NULL),(160,'ام.ام جروب للصناعة والتجارة العالمية','MTIE','EGX',9.55,'2026-05-07 09:56:19','2026-07-05 11:51:43',11),(161,'النعيم القابضة للاستثمارات','NAHO','EGX',0.104,'2026-05-07 09:56:19','2026-07-05 11:51:44',14),(162,'النعيم العقارية القابضة','NARE','EGX',13.82,'2026-05-07 09:56:19','2026-07-05 11:51:44',NULL),(163,'شركة النصر للأعمال المدنية','NCCW','EGX',6.29,'2026-05-07 09:56:19','2026-07-05 11:51:45',15),(165,'شمال الصعيد للتنمية والإنتاج الزراعي','NEDA','EGX',2.79,'2026-05-07 09:56:19','2026-08-02 13:12:26',NULL),(166,'الوطنية للاسكان للنقابات المهنية','NHPS','EGX',67.54,'2026-05-07 09:56:19','2026-07-05 11:51:47',5),(167,'مستشفى النزهة الدولي','NINH','EGX',18.07,'2026-05-07 09:56:19','2026-07-05 11:51:48',NULL),(168,'النيل للأدوية والصناعات الكيماوية','NIPH','EGX',173.05,'2026-05-07 09:56:19','2026-07-05 11:51:48',NULL),(169,'العبور للاستثمار العقاري','OBRI','EGX',38.01,'2026-05-07 09:56:19','2026-07-05 11:51:49',NULL),(170,'السادس من أكتوبر للتنمية والاستثمار','OCDI','EGX',25.51,'2026-05-07 09:56:19','2026-07-05 11:51:50',NULL),(171,'أكتوبر فارما','OCPH','EGX',357.65,'2026-05-07 09:56:19','2026-07-05 11:51:50',NULL),(172,'أودن للاستثمارات المالية','ODIN','EGX',2.29,'2026-05-07 09:56:19','2026-07-05 11:51:51',NULL),(173,'أوراسكوم المالية القابضة','OFH','EGX',0.622,'2026-05-07 09:56:19','2026-07-05 11:51:51',NULL),(174,'أوراسكوم للاستثمار القابضة','OIH','EGX',1.52,'2026-05-07 09:56:19','2026-08-02 13:12:26',NULL),(175,'عبور لاند للصناعات الغذائية','OLFI','EGX',22.6,'2026-05-07 09:56:19','2026-07-05 11:51:53',9),(176,'اوراسكوم كونستراكشون بي ال سي','ORAS','EGX',718.65,'2026-05-07 09:56:19','2026-07-05 11:51:53',15),(177,'أوراسكوم للتنمية مصر','ORHD','EGX',38.15,'2026-05-07 09:56:19','2026-07-05 11:51:54',NULL),(178,'النساجون الشرقيون للسجاد','ORWE','EGX',22.62,'2026-05-07 09:56:19','2026-07-05 11:51:55',16),(179,'المصرية الدولية للصناعات الدوائية','PHAR','EGX',88.87,'2026-05-07 09:56:19','2026-07-05 11:51:55',NULL),(180,'بالم هيلز للتعمير','PHDC','EGX',14.7,'2026-05-07 09:56:19','2026-07-05 11:51:56',5),(182,'بيراميزا للفنادق والقرى السياحية','PHTV','EGX',268.5,'2026-05-07 09:56:19','2026-07-05 11:51:57',NULL),(183,'القاهرة للدواجن','POUL','EGX',37.93,'2026-05-07 09:56:19','2026-07-05 11:51:57',9),(184,'العامة لمنتجات الخزف والصيني','PRCL','EGX',33.95,'2026-05-07 09:56:19','2026-07-05 11:51:58',17),(185,'بايونيرز بروبرتيز للتنمية العمرانية','PRDC','EGX',7.73,'2026-05-07 09:56:19','2026-07-05 11:51:59',NULL),(186,'برايم القابضة للاستثمارات المالية','PRMH','EGX',2.24,'2026-05-07 09:56:19','2026-08-02 13:12:26',14),(187,'بنك قطر الوطني الأهلي','QNBE','EGX',52.65,'2026-05-07 09:56:19','2026-07-05 11:52:00',1),(188,'راية لخدمات مراكز الاتصالات','RACC','EGX',9.96,'2026-05-07 09:56:19','2026-07-05 11:52:00',8),(189,'العامة لصناعة الورق','RAKT','EGX',24.89,'2026-05-07 09:56:19','2026-08-02 13:12:26',NULL),(190,'راية القابضة للاستثمارات المالية','RAYA','EGX',7.91,'2026-05-07 09:56:19','2026-07-05 11:52:02',NULL),(191,'ركاز القابضة للاستثمارات المالية','RKAZ','EGX',5.4,'2026-05-07 09:56:19','2026-07-05 11:52:02',NULL),(192,'العاشر من رمضان للصناعات الدوائية والمستحضرات تشخيصية','RMDA','EGX',4.69,'2026-05-07 09:56:19','2026-08-02 13:12:26',3),(193,'رواد السياحة','ROTO','EGX',42.92,'2026-05-07 09:56:19','2026-07-05 11:52:04',6),(194,'الاستثمار العقاري العربي','RREI','EGX',3.55,'2026-05-07 09:56:19','2026-07-05 11:52:04',NULL),(195,'رمكو لإنشاء القرى السياحية','RTVC','EGX',3.84,'2026-05-07 09:56:19','2026-07-05 11:52:05',NULL),(196,'روبكس العالمية لتصنيع البلاستيك والاكريلك','RUBX','EGX',13.25,'2026-05-07 09:56:19','2026-07-05 11:52:05',NULL),(198,'بنك البركة مصر','SAUD','EGX',21.36,'2026-05-07 09:56:19','2026-07-05 11:52:06',1),(199,'أسمنت سيناء','SCEM','EGX',65.62,'2026-05-07 09:56:19','2026-07-05 11:52:07',NULL),(200,'مطاحن ومخابز جنوب القاهرة والجيزة','SCFM','EGX',243.97,'2026-05-07 09:56:19','2026-07-05 11:52:08',9),(201,'قناة السويس لتوطين التكنولوجيا','SCTS','EGX',621.33,'2026-05-07 09:56:19','2026-07-05 11:52:08',13),(202,'شارم دريمز للاستثمار السياحي','SDTI','EGX',46.59,'2026-05-07 09:56:19','2026-07-05 11:52:09',NULL),(203,'السعودية المصرية للاستثمار والتمويل','SEIG','EGX',190.31,'2026-05-07 09:56:19','2026-07-05 11:52:10',14),(204,'سبأ الدولية للأدوية والصناعات الكيماوية','SIPC','EGX',3.42,'2026-05-07 09:56:19','2026-07-05 11:52:10',3),(205,'سيدي كرير للبتروكيماويات','SKPC','EGX',16.18,'2026-05-07 09:56:19','2026-07-05 11:52:11',NULL),(206,'سماد مصر','SMFR','EGX',195.23,'2026-05-07 09:56:19','2026-07-05 11:52:12',NULL),(207,'الشرقية الوطنية للأمن الغذائي','SNFC','EGX',11.91,'2026-05-07 09:56:19','2026-07-05 11:52:12',NULL),(209,'الإسكندرية للغزل والنسيج','SPIN','EGX',14.49,'2026-05-07 09:56:19','2026-07-05 11:52:14',NULL),(210,'سبيد ميديكال','SPMD','EGX',0.432,'2026-05-07 09:56:19','2026-07-05 11:52:14',3),(211,'الدلتا للسكر','SUGR','EGX',47.45,'2026-05-07 09:56:19','2026-07-05 11:52:15',9),(212,'جنوب الوادى للأسمنت','SVCE','EGX',9.71,'2026-05-07 09:56:19','2026-07-05 11:52:16',NULL),(213,'السويدي اليكتريك','SWDY','EGX',87.51,'2026-05-07 09:56:19','2026-07-05 11:52:16',NULL),(214,'شركة تعليم لخدمات الإدارة','TALM','EGX',15.96,'2026-05-07 09:56:19','2026-07-05 11:52:17',NULL),(215,'تنمية للاستثمار العقاري','TANM','EGX',5.37,'2026-05-07 09:56:19','2026-07-05 11:52:17',5),(216,'طاقة عربية ش.م.م','TAQA','EGX',14.5,'2026-05-07 09:56:19','2026-07-05 11:52:18',7),(217,'مجموعة طلعت مصطفى القابضة','TMGH','EGX',95.9,'2026-05-07 09:56:19','2026-07-05 11:52:19',5),(218,'عبر المحيطات للسياحة','TRTO','EGX',0.03,'2026-05-07 09:56:19','2026-08-02 13:12:26',NULL),(219,'توسع للتخصيم','TWSA','EGX',4.94,'2026-05-07 09:56:19','2026-08-02 13:12:26',14),(220,'الاسكندرية الوطنية للاستثمارات المالية','TYCN','EGX',27.8,'2026-05-07 09:56:19','2026-07-05 11:52:20',NULL),(221,'المصرف المتحد','UBEE','EGX',13.39,'2026-05-07 09:56:19','2026-07-05 11:52:21',1),(222,'مطاحن مصر العليا','UEFM','EGX',477.74,'2026-05-07 09:56:19','2026-07-05 11:52:22',9),(223,'الصعيد العامة للمقاولات والاستثمار العقاري','UEGC','EGX',1.54,'2026-05-07 09:56:19','2026-07-05 11:52:22',NULL),(224,'يونيفرسال لصناعة مواد التعبئة والتغليف والورق','UNIP','EGX',0.29,'2026-05-07 09:56:19','2026-08-02 13:12:26',NULL),(225,'المتحدة للاسكان والتعمير','UNIT','EGX',13.41,'2026-05-07 09:56:19','2026-07-05 11:52:23',5),(226,'الاتحاد الصيدلي للخدمات الطبية والاستثمار','UPMS','EGX',12.38,'2026-05-07 09:56:19','2026-07-05 11:52:24',NULL),(227,'يوتوبيا للاستثمار العقاري والسياحي','UTOP','EGX',80,'2026-05-07 09:56:19','2026-07-05 11:52:25',NULL),(228,'يو للتمويل الاستهلاكي','VALU','EGX',12.6,'2026-05-07 09:56:19','2026-07-05 11:52:26',NULL),(229,'فالمور القابضة للاستثمار','VLMR','EGX',0.663,'2026-05-07 09:56:19','2026-07-05 11:52:26',14),(230,'فالمور القابضة للاستثمار','VLMRA','EGX',29.25,'2026-05-07 09:56:19','2026-07-05 11:52:27',NULL),(231,'مطاحن وسط وغرب الدلتا','WCDF','EGX',547.85,'2026-05-07 09:56:19','2026-08-02 13:12:26',9),(232,'وادي كوم امبو لاستصلاح الأراضي','WKOL','EGX',282.7,'2026-05-07 09:56:19','2026-07-05 11:52:28',NULL),(233,'الزيوت المستخلصة ومنتجاتها','ZEOT','EGX',11.12,'2026-05-07 09:56:19','2026-07-05 11:52:29',9),(234,'زهراء المعادي للاستثمار والتعمير','ZMID','EGX',6.8,'2026-05-07 09:56:19','2026-07-05 11:52:29',5),(236,'قرة لمشروعات الطاقة والاستثمار','KORA','EGX',3.45,'2026-05-22 11:24:13','2026-07-05 11:51:25',15),(237,' حق فيوتشر كير ','FCMD_r3','EGX',4.36,'2026-06-15 13:18:58','2026-07-05 11:39:16',3),(238,'أكرو مصر للشدات والسقالات المعدنية','ACRO','EGx',97.58,'2026-08-02 13:12:25','2026-08-02 13:12:25',NULL),(239,'ارابيا انفستمنتس هولدنج','AIHC','EGx',0.35,'2026-08-02 13:12:25','2026-08-02 13:12:25',NULL),(240,'فيركيم مصر للأسمدة والكيماويات','FERC','EGx',80.82,'2026-08-02 13:12:26','2026-08-02 13:12:26',NULL),(241,'جولدن كوست السخنة للاستثمار السياحي','GOCO','EGx',0.85,'2026-08-02 13:12:26','2026-08-02 13:12:26',NULL),(242,'جولدن بيراميدز بلازا','GPPL','EGx',1.38,'2026-08-02 13:12:26','2026-08-02 13:12:26',NULL),(243,'القابضة للاستثمارات المالية','HCFI','EGx',3.77,'2026-08-02 13:12:26','2026-08-02 13:12:26',NULL),(244,'الشرق الأوسط لصناعة الزجاج','MEGM','EGx',12.54,'2026-08-02 13:12:26','2026-08-02 13:12:26',NULL),(245,'مرسى مرسى علم للتنمية السياحية','MMAT','EGx',3.42,'2026-08-02 13:12:26','2026-08-02 13:12:26',NULL),(246,'الحفر الوطنية','NDRL','EGx',5,'2026-08-02 13:12:26','2026-08-02 13:12:26',NULL),(247,'بريميم هيلثكير جروب','PHGC','EGx',0.09,'2026-08-02 13:12:26','2026-08-02 13:12:26',NULL),(248,'بنك الشركة المصرفية العربية الدولية','SAIB','EGx',2.25,'2026-08-02 13:12:26','2026-08-02 13:12:26',NULL),(249,'الشمس بيراميدز للمنشات السياحية','SPHT','EGx',1.79,'2026-08-02 13:12:26','2026-08-02 13:12:26',NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=158 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trade_tracks`
--

LOCK TABLES `trade_tracks` WRITE;
/*!40000 ALTER TABLE `trade_tracks` DISABLE KEYS */;
INSERT INTO `trade_tracks` VALUES (1,1,-14022,'2026-05-07 14:30:44','buy','2026-05-07 11:30:49','2026-07-15 12:38:31'),(2,2,-34119,'2026-05-07 15:32:32','buy','2026-05-07 12:32:37','2026-07-15 12:37:55'),(4,4,-7760,'2026-05-07 15:51:20','buy','2026-05-07 12:51:22','2026-07-15 12:37:13'),(100,9,4731.08,'2026-07-05 17:39:05','sell','2026-07-05 14:39:25','2026-07-05 14:39:25'),(102,40,4566.27,'2026-07-08 16:00:05','sell','2026-07-08 13:00:29','2026-07-08 13:00:29'),(103,9,5200.49,'2026-07-08 16:00:49','sell','2026-07-08 13:03:28','2026-07-08 13:03:28'),(104,9,-5219.51,'2026-07-08 16:03:40','buy','2026-07-08 13:04:00','2026-07-08 13:04:00'),(105,9,5250.42,'2026-07-08 16:04:04','sell','2026-07-08 13:04:23','2026-07-08 13:04:23'),(106,37,-3016.76,'2026-07-08 16:04:54','buy','2026-07-08 13:05:11','2026-07-08 13:05:11'),(107,38,-4424.3,'2026-06-21 16:10:50','buy','2026-07-08 13:11:46','2026-07-08 13:11:46'),(108,38,2471.58,'2026-07-01 16:12:11','sell','2026-07-08 13:12:25','2026-07-08 13:12:25'),(109,38,-1575,'2026-07-08 16:12:33','buy','2026-07-08 13:12:37','2026-07-08 13:12:37'),(110,9,-16709.86,'2026-07-09 16:08:25','buy','2026-07-09 13:08:56','2026-07-09 13:09:05'),(111,9,11150.05,'2026-07-09 16:09:29','sell','2026-07-09 13:09:40','2026-07-09 13:09:40'),(112,37,-3008.75,'2026-07-12 17:23:17','buy','2026-07-12 14:23:26','2026-07-12 14:23:26'),(113,2,3537.57,'2026-07-12 17:23:59','sell','2026-07-12 14:24:20','2026-07-12 14:24:20'),(114,9,5719.84,'2026-07-12 17:24:33','sell','2026-07-12 14:24:48','2026-07-12 14:24:48'),(117,2,3637.45,'2026-07-13 16:15:24','sell','2026-07-13 13:15:47','2026-07-13 13:15:47'),(118,9,-6020.51,'2026-07-14 16:59:55','buy','2026-07-14 14:00:15','2026-07-14 14:00:47'),(119,9,6029.46,'2026-07-14 17:00:15','sell','2026-07-14 14:00:41','2026-07-14 14:00:41'),(120,38,-1318.58,'2026-07-14 17:01:13','buy','2026-07-14 14:01:28','2026-07-14 14:01:28'),(121,37,3111.1,'2026-07-14 17:01:49','sell','2026-07-14 14:01:58','2026-07-14 14:01:58'),(122,4,-7131.55,'2026-07-14 17:02:32','buy','2026-07-14 14:02:42','2026-07-14 14:02:42'),(124,4,7398.11,'2026-07-15 15:25:31','sell','2026-07-15 12:25:37','2026-07-15 12:25:37'),(125,37,-3030.77,'2026-07-15 15:26:24','buy','2026-07-15 12:26:41','2026-07-15 12:26:41'),(126,37,3065.16,'2026-07-15 15:26:41','sell','2026-07-15 12:27:03','2026-07-15 12:27:03'),(127,9,-18141.64,'2026-07-15 15:28:23','buy','2026-07-15 12:28:34','2026-07-15 12:28:34'),(128,9,6029.46,'2026-07-15 15:28:36','sell','2026-07-15 12:28:49','2026-07-15 12:28:49'),(129,9,12258.64,'2026-07-16 15:48:22','sell','2026-07-16 12:48:35','2026-07-16 12:48:35'),(130,9,-6421.01,'2026-07-16 15:48:40','buy','2026-07-16 12:48:53','2026-07-16 12:48:53'),(131,9,6468.9,'2026-07-19 16:55:09','sell','2026-07-19 13:55:49','2026-07-19 13:55:49'),(132,9,-9599.99,'2026-07-19 16:55:58','buy','2026-07-19 13:56:14','2026-07-19 13:56:14'),(133,42,-5529.9,'2026-07-19 16:56:46','buy','2026-07-19 13:56:57','2026-07-19 13:56:57'),(134,9,9629.95,'2026-07-20 16:19:31','sell','2026-07-20 13:19:54','2026-07-20 13:19:54'),(135,9,-19635.51,'2026-07-20 16:20:01','buy','2026-07-20 13:20:26','2026-07-20 13:20:26'),(136,9,9869.64,'2026-07-20 16:20:28','sell','2026-07-20 13:20:47','2026-07-20 13:20:47'),(137,1,-2892.61,'2026-07-21 15:54:52','buy','2026-07-21 12:55:05','2026-07-21 12:55:05'),(138,9,6678.64,'2026-07-21 15:55:13','sell','2026-07-21 12:55:44','2026-07-21 12:55:44'),(139,9,-35799.69,'2026-07-21 15:55:50','buy','2026-07-21 12:56:12','2026-07-21 12:56:12'),(140,9,21294.35,'2026-07-21 15:56:17','sell','2026-07-21 12:56:35','2026-07-21 12:56:35'),(141,9,7128.08,'2026-07-22 15:50:00','sell','2026-07-22 12:50:21','2026-07-22 12:50:21'),(142,9,-28167.14,'2026-07-22 15:50:21','buy','2026-07-22 12:50:41','2026-07-22 12:50:41'),(143,9,21314.32,'2026-07-22 15:50:41','sell','2026-07-22 12:50:54','2026-07-22 12:50:54'),(144,9,10585.74,'2026-07-26 16:10:06','sell','2026-07-26 13:10:33','2026-07-26 13:10:33'),(145,9,-14013.49,'2026-07-26 16:10:35','buy','2026-07-26 13:10:47','2026-07-26 13:10:47'),(146,9,14066.39,'2026-07-26 16:10:51','sell','2026-07-26 13:10:57','2026-07-26 13:11:02'),(147,9,7128.08,'2026-07-26 16:11:04','sell','2026-07-26 13:11:20','2026-07-26 13:11:20'),(148,43,-4062.87,'2026-07-26 16:12:04','buy','2026-07-26 13:12:18','2026-07-26 13:12:18'),(149,38,-1946.33,'2026-07-27 15:28:01','buy','2026-07-27 12:28:24','2026-07-27 12:28:24'),(150,42,-5509.88,'2026-07-28 15:25:57','buy','2026-07-28 12:26:14','2026-07-28 12:26:14'),(151,43,-4328.19,'2026-07-28 15:26:30','buy','2026-07-28 12:26:44','2026-07-28 12:26:44'),(152,38,1415.3,'2026-07-29 15:59:36','sell','2026-07-29 12:59:55','2026-07-29 12:59:55'),(153,42,-2736.41,'2026-07-29 16:00:03','buy','2026-07-29 13:00:18','2026-07-29 13:00:18'),(154,2,14725.55,'2026-07-30 16:14:40','sell','2026-07-30 13:15:04','2026-07-30 13:15:04'),(155,2,-10814.5,'2026-07-30 16:15:13','buy','2026-07-30 13:15:47','2026-07-30 13:15:47'),(156,42,-7795.71,'2026-07-30 16:16:21','buy','2026-07-30 13:16:49','2026-07-30 13:16:49'),(157,42,2633.71,'2026-07-30 16:16:57','sell','2026-07-30 13:17:14','2026-07-30 13:17:14');
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
  `year` smallint unsigned NOT NULL DEFAULT '2026',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `trades_stock_id_foreign` (`stock_id`),
  KEY `trades_year_index` (`year`),
  CONSTRAINT `trades_stock_id_foreign` FOREIGN KEY (`stock_id`) REFERENCES `stocks` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trades`
--

LOCK TABLES `trades` WRITE;
/*!40000 ALTER TABLE `trades` DISABLE KEYS */;
INSERT INTO `trades` VALUES (1,130,800,'open',2026,'2026-05-07 11:03:51','2026-07-21 11:57:52'),(2,234,2500,'open',2026,'2026-05-07 11:04:47','2026-07-30 13:14:30'),(4,113,0,'close',2026,'2026-05-07 12:47:06','2026-07-15 12:25:52'),(9,122,10000,'open',2026,'2026-05-07 13:00:20','2026-07-05 11:42:32'),(37,118,1000,'open',2026,'2026-06-07 11:31:12','2026-07-14 14:01:47'),(38,96,4100,'open',2026,'2026-06-14 12:40:01','2026-07-29 12:14:04'),(40,38,0,'close',2026,'2026-06-25 12:18:32','2026-07-08 13:00:39'),(42,69,7000,'open',2026,'2026-07-19 13:56:38','2026-07-30 13:16:16'),(43,113,1000,'open',2026,'2026-07-26 13:11:59','2026-07-28 12:25:34');
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
INSERT INTO `users` VALUES (1,'Admin User','admin@example.com',NULL,'$2y$12$rV0HIvA1.qtChIcPZCUMb.pF6YBfYl1GONm33Hfm8J8wScPHnM0gW',NULL,'2026-08-02 13:12:34','2026-08-02 13:12:34');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wallets`
--

LOCK TABLES `wallets` WRITE;
/*!40000 ALTER TABLE `wallets` DISABLE KEYS */;
INSERT INTO `wallets` VALUES (1,1,19496.00,24667.00,'2026-05-10 11:12:55','2026-07-05 14:43:35');
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
INSERT INTO `withdrawals` VALUES (3,1,10000.00,'2026-07-05',NULL,'2026-07-05 11:41:47','2026-07-05 11:41:47');
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

-- Dump completed on 2026-08-02 16:54:50
