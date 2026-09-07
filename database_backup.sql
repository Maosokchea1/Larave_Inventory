-- MySQL dump 10.13  Distrib 8.0.46, for Win64 (x86_64)
--
-- Host: localhost    Database: laravel_inventory
-- ------------------------------------------------------
-- Server version	8.0.46

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
  PRIMARY KEY (`key`)
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
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Note` text COLLATE utf8mb4_unicode_ci,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Computer','Good',1,'2026-08-01 04:15:36','2026-08-29 10:50:36'),(2,'Phone',NULL,1,'2026-08-04 10:05:03','2026-08-04 10:05:03');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_07_23_162020_create_categories_table',1),(5,'2026_07_24_020347_create_suppliers_table',1),(6,'2026_07_24_031648_create_products_table',1),(7,'2026_07_25_020000_create_profiles_table',1),(8,'2026_07_25_042745_create_notifications_table',1),(9,'2026_07_25_050849_create_settings_table',1),(10,'2026_07_26_050056_create_stock_transactions_table',1),(11,'2026_07_26_052505_add_stock_to_products_table',1),(12,'2026_07_27_022810_create_product_settings_table',1),(13,'2026_07_27_125358_create_roles_table',1),(14,'2026_07_28_012940_create_permissions_table',1),(15,'2026_07_28_072623_create_permission_role_table',1),(16,'2026_08_01_094814_remove_columns_from_users_table',2),(17,'2026_08_01_105735_add_status_and_role_to_users_table',3),(18,'2026_08_01_133324_add_phone_and_address_to_users_table',4),(19,'2026_08_01_133530_add_fields_to_users_table',4),(20,'2026_08_10_232330_add_transfer_to_stock_transactions_type_column',5),(21,'2026_08_14_101226_stock_movements',6),(22,'2026_08_16_134950_remove_unique_from_users_name_column',7),(23,'2026_08_16_140040_drop_unique_from_users_name',8),(24,'2026_08_16_145530_create_user_roles_table',8),(25,'2026_08_16_152612_add_image_to_users_table',9),(26,'2026_08_16_152900_add_user_id_to_roles_table',10),(28,'2026_08_16_152957_remove_unique_from_roles_name_table',11);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint unsigned NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
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
INSERT INTO `notifications` VALUES ('04366395-b106-41f2-9000-7e74e4e62dac','App\\Notifications\\UserActivityNotification','App\\Models\\User',4,'{\"title\":\"Admin Profile Updated\",\"message\":\"Admin Sengouth Than (ID: 1) updated profile \\u2014 Profile picture: changed to a new image.\",\"url\":\"#\"}',NULL,'2026-08-24 11:43:14','2026-08-24 11:43:14'),('0515cff5-5301-439c-ba7a-56edbef287da','App\\Notifications\\UserActivityNotification','App\\Models\\User',2,'{\"title\":\"Admin Profile Updated\",\"message\":\"Admin Sengouth Than (ID: 1) updated profile \\u2014 Profile picture: changed to a new image.\",\"url\":\"#\"}','2026-08-24 13:26:27','2026-08-24 11:43:14','2026-08-24 13:26:27'),('07133b08-3629-47fb-b6fc-83020f8e1b9c','App\\Notifications\\UserActivityNotification','App\\Models\\User',4,'{\"title\":\"Admin Profile Updated\",\"message\":\"Admin Sengouth Than (ID: 1) updated profile \\u2014 Profile picture: changed to a new image.\",\"url\":\"#\"}',NULL,'2026-08-24 11:38:45','2026-08-24 11:38:45'),('12b75e4e-e847-432c-8428-c55ca57a63f2','App\\Notifications\\UserActivityNotification','App\\Models\\User',2,'{\"title\":\"Admin Profile Updated\",\"message\":\"Admin Admin (ID: 2) updated profile \\u2014 Name: Admin \\u2192 Mao Sokchea.\",\"url\":\"#\"}','2026-08-16 07:06:15','2026-08-16 07:01:37','2026-08-16 07:06:15'),('2054b9c3-2c73-40e6-89fc-91e7de76fd7e','App\\Notifications\\UserActivityNotification','App\\Models\\User',1,'{\"title\":\"User Profile Updated\",\"message\":\"User Sengouth Than (ID: 1) updated profile \\u2014 Phone: Not set \\u2192 090\\u200b\\u200b 47 4090; Address: Not set \\u2192 Phnom Penh.\",\"url\":\"#\"}','2026-08-16 09:37:53','2026-08-01 09:37:04','2026-08-16 09:37:53'),('277d62db-bc93-47ce-a155-a5132ee6b703','App\\Notifications\\UserActivityNotification','App\\Models\\User',2,'{\"title\":\"Admin Profile Updated\",\"message\":\"Admin Mao Sokchea (ID: 2) updated profile \\u2014 Profile picture: changed to a new image.\",\"url\":\"#\"}','2026-08-01 11:03:31','2026-08-01 11:01:49','2026-08-01 11:03:31'),('29e7fa71-a461-406c-aac1-31cdf0f22b48','App\\Notifications\\UserActivityNotification','App\\Models\\User',3,'{\"title\":\"Admin Profile Updated\",\"message\":\"Admin Sengouth Than (ID: 1) updated profile \\u2014 Profile picture: changed to a new image.\",\"url\":\"#\"}',NULL,'2026-08-24 11:38:45','2026-08-24 11:38:45'),('36bebc45-637d-45ec-97ed-521caad78fcb','App\\Notifications\\UserActivityNotification','App\\Models\\User',1,'{\"title\":\"Admin Profile Updated\",\"message\":\"Admin Mao Sokchea kh (ID: 2) updated profile \\u2014 Name: Mao Sokchea kh \\u2192 Mao Sokchea.\",\"url\":\"#\"}','2026-08-16 09:37:53','2026-08-01 07:50:57','2026-08-16 09:37:53'),('41dab40a-fa19-421b-b562-79a4cee9c500','App\\Notifications\\UserActivityNotification','App\\Models\\User',4,'{\"title\":\"User Profile Updated\",\"message\":\"User Sengouth Than (ID: 1) updated profile \\u2014 Name: Sengouth Than \\u2192 Sengouth Tha.\",\"url\":\"#\"}',NULL,'2026-08-24 13:11:41','2026-08-24 13:11:41'),('424dc3d0-bc79-4316-90d6-e4b8c8e00691','App\\Notifications\\UserActivityNotification','App\\Models\\User',1,'{\"title\":\"Admin Profile Updated\",\"message\":\"Admin Sengouth Than (ID: 1) updated profile \\u2014 Profile picture: changed to a new image.\",\"url\":\"#\"}','2026-08-24 11:45:36','2026-08-24 11:38:45','2026-08-24 11:45:36'),('438e5959-4c03-4df9-8ebd-27b75711f975','App\\Notifications\\UserActivityNotification','App\\Models\\User',1,'{\"title\":\"Admin Profile Updated\",\"message\":\"Admin Mao Sokchea (ID: 2) updated profile \\u2014 Name: Mao Sokchea \\u2192 Admin.\",\"url\":\"#\"}','2026-08-16 09:37:53','2026-08-16 07:01:19','2026-08-16 09:37:53'),('541f7465-4d65-47bb-8d0f-3eb77a936dbd','App\\Notifications\\UserActivityNotification','App\\Models\\User',2,'{\"title\":\"User Profile Updated\",\"message\":\"User Sengouth Than (ID: 1) updated profile \\u2014 Name: Sengouth Than \\u2192 Sengouth Tha.\",\"url\":\"#\"}','2026-08-24 13:26:27','2026-08-24 13:11:41','2026-08-24 13:26:27'),('65ecad02-140e-428b-aec5-4bd16ff5e253','App\\Notifications\\UserActivityNotification','App\\Models\\User',2,'{\"title\":\"Profile Updated\",\"message\":\"User Mao Sokchea updated: Name.\",\"url\":\"#\"}','2026-08-01 07:47:33','2026-08-01 07:47:25','2026-08-01 07:47:33'),('665d37ab-bfbb-4564-bacd-06a22d098b94','App\\Notifications\\UserActivityNotification','App\\Models\\User',2,'{\"title\":\"Admin Profile Updated\",\"message\":\"Admin Sengouth Than (ID: 1) updated profile \\u2014 Profile picture: changed to a new image.\",\"url\":\"#\"}','2026-08-24 13:26:27','2026-08-24 11:38:45','2026-08-24 13:26:27'),('7cb5ab7f-eb18-4fe8-92f0-47462bca3765','App\\Notifications\\UserActivityNotification','App\\Models\\User',1,'{\"title\":\"User Profile Updated\",\"message\":\"User Sengouth Than (ID: 1) updated profile \\u2014 Name: Sengouth Than \\u2192 Sengouth Tha.\",\"url\":\"#\"}',NULL,'2026-08-24 13:11:41','2026-08-24 13:11:41'),('83da0293-e3cd-4756-a759-8f4a8a5b2957','App\\Notifications\\UserActivityNotification','App\\Models\\User',2,'{\"title\":\"Admin Profile Updated\",\"message\":\"Admin Mao Sokchea (ID: 2) updated profile \\u2014 Name: Mao Sokchea \\u2192 Admin.\",\"url\":\"#\"}','2026-08-16 07:06:15','2026-08-16 07:01:19','2026-08-16 07:06:15'),('9e0c97a0-4c1c-4a2e-a2a6-4c24d386c5a9','App\\Notifications\\UserActivityNotification','App\\Models\\User',3,'{\"title\":\"Admin Profile Updated\",\"message\":\"Admin Sengouth Than (ID: 1) updated profile \\u2014 Profile picture: changed to a new image.\",\"url\":\"#\"}',NULL,'2026-08-24 11:43:14','2026-08-24 11:43:14'),('9eb861f2-589e-4e4e-b7c6-62ef7fbe10cf','App\\Notifications\\UserActivityNotification','App\\Models\\User',2,'{\"title\":\"Admin Profile Updated\",\"message\":\"Admin Mao Sokchea kh (ID: 2) updated profile \\u2014 Name: Mao Sokchea kh \\u2192 Mao Sokchea.\",\"url\":\"#\"}','2026-08-01 09:56:35','2026-08-01 07:50:57','2026-08-01 09:56:35'),('a0cee9fb-9b58-4621-977d-fdacc9dcccbc','App\\Notifications\\UserActivityNotification','App\\Models\\User',3,'{\"title\":\"User Profile Updated\",\"message\":\"User Sengouth Than (ID: 1) updated profile \\u2014 Name: Sengouth Than \\u2192 Sengouth Tha.\",\"url\":\"#\"}',NULL,'2026-08-24 13:11:41','2026-08-24 13:11:41'),('a2f3591b-cbf7-467c-8701-e38db8a02cfc','App\\Notifications\\UserActivityNotification','App\\Models\\User',1,'{\"title\":\"Admin Profile Updated\",\"message\":\"Admin Sengouth Than (ID: 1) updated profile \\u2014 Profile picture: changed to a new image.\",\"url\":\"#\"}','2026-08-24 11:45:36','2026-08-24 11:43:14','2026-08-24 11:45:36'),('a92bfab9-be92-4dc8-b962-456456e9d246','App\\Notifications\\UserActivityNotification','App\\Models\\User',2,'{\"title\":\"User Profile Updated\",\"message\":\"User Sengouth Than (ID: 1) updated profile \\u2014 Phone: Not set \\u2192 090\\u200b\\u200b 47 4090; Address: Not set \\u2192 Phnom Penh.\",\"url\":\"#\"}','2026-08-01 09:56:35','2026-08-01 09:37:04','2026-08-01 09:56:35'),('c3226480-f617-46cc-89e4-7b9ecde21690','App\\Notifications\\UserActivityNotification','App\\Models\\User',1,'{\"title\":\"Profile Updated\",\"message\":\"User Mao Sokchea updated: Name.\",\"url\":\"#\"}','2026-08-16 09:37:53','2026-08-01 07:47:25','2026-08-16 09:37:53'),('eea0306a-a741-4a81-8981-3aab5985beae','App\\Notifications\\UserActivityNotification','App\\Models\\User',1,'{\"title\":\"Admin Profile Updated\",\"message\":\"Admin Admin (ID: 2) updated profile \\u2014 Name: Admin \\u2192 Mao Sokchea.\",\"url\":\"#\"}','2026-08-16 09:37:53','2026-08-16 07:01:37','2026-08-16 09:37:53'),('f6c49504-1f66-48ca-9c66-53f049533356','App\\Notifications\\UserActivityNotification','App\\Models\\User',1,'{\"title\":\"Admin Profile Updated\",\"message\":\"Admin Mao Sokchea (ID: 2) updated profile \\u2014 Profile picture: changed to a new image.\",\"url\":\"#\"}','2026-08-16 09:37:53','2026-08-01 11:01:49','2026-08-16 09:37:53');
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permission_role`
--

DROP TABLE IF EXISTS `permission_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permission_role` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `permission_role_role_id_foreign` (`role_id`),
  CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permission_role`
--

LOCK TABLES `permission_role` WRITE;
/*!40000 ALTER TABLE `permission_role` DISABLE KEYS */;
/*!40000 ALTER TABLE `permission_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'web',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_settings`
--

DROP TABLE IF EXISTS `product_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key_value` text COLLATE utf8mb4_unicode_ci,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_settings_key_name_unique` (`key_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_settings`
--

LOCK TABLES `product_settings` WRITE;
/*!40000 ALTER TABLE `product_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint unsigned NOT NULL,
  `supplier_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `SKU` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Cost` decimal(10,2) NOT NULL,
  `Price` decimal(10,2) NOT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `Note` text COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_sku_unique` (`SKU`),
  KEY `products_category_id_foreign` (`category_id`),
  KEY `products_supplier_id_foreign` (`supplier_id`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `products_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,1,5,'Asus','24365',1000.50,1100.00,30,'products/dIHaPUX6EXfxcyr9zKNRaKjjVrACFZPWw0Uz2K8E.png','Phnom Penh','Good','active','2026-08-01 04:16:44','2026-08-29 10:51:08'),(2,2,1,'Phone 17 Pro Max','234445',1000.50,1200.00,5,'products/TLSf1lcK7hKK58grRYweuauwvsBNeP3RnvwSWjjm.jpg','Phnom Penh','Good','active','2026-08-04 17:13:57','2026-08-24 03:39:21'),(3,1,1,'MSI','234556',900.00,1000.00,14,'products/3WdAeauNOzrbaAzp7UwDOIQlVi9xCLr84oyeTvbq.jpg','Phnom Penh','Good','active','2026-08-05 03:15:26','2026-08-14 05:47:43'),(4,1,1,'Dell','345678',450.00,600.00,10,'products/mMiHhuSLid5wCpPcHDDOehtgZEA466ys4aB9HRmr.jpg','Phnom Penh','Good','active','2026-08-11 05:59:52','2026-08-14 05:43:33'),(6,2,1,'Iphone 16 Pro Max','23456',800.00,900.00,10,'products/zyixcfc6L3ZRzLecAxFmyKBMS2AUXDvlHV3Ikb7L.png','Phnom Penh','Good','active','2026-08-11 06:05:34','2026-08-14 03:39:30'),(7,2,1,'Iphone 15 Pro Max','32454',600.00,700.00,6,'products/F6xk4BaRWDcwt4BfAiKLHUqFzcD1uGJO7LIXeZBS.jpg','Phnom Penh','Good','active','2026-08-11 06:11:44','2026-08-23 15:23:32'),(8,2,1,'Iphone 12 Pro Max','34457',250.00,300.00,3,'products/8y8GE8w29WkpspiyVzJK7ePxWgWMhjADuDKy5qwL.png','Phnom Penh',NULL,'active','2026-08-17 04:17:03','2026-08-17 12:49:08'),(9,2,1,'Iphone 15 Pro','123567',0.25,0.30,0,'products/UP92XygjHXJNEitIu1q6AOIvM82c0gutzxZC1nFY.png','Phnom Penh','Good','active','2026-08-24 12:59:58','2026-08-24 13:00:42');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profiles`
--

DROP TABLE IF EXISTS `profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `profiles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `avatar_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `profiles_user_id_unique` (`user_id`),
  CONSTRAINT `profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profiles`
--

LOCK TABLES `profiles` WRITE;
/*!40000 ALTER TABLE `profiles` DISABLE KEYS */;
/*!40000 ALTER TABLE `profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'web',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `roles_user_id_foreign` (`user_id`),
  CONSTRAINT `roles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Admin',NULL,'web','2026-08-01 08:48:48','2026-08-01 08:48:48'),(5,'User',1,'web','2026-08-16 08:30:16','2026-08-24 13:08:49'),(6,'Admin',3,'web','2026-08-16 10:32:25','2026-08-24 13:08:14');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stock_movements`
--

DROP TABLE IF EXISTS `stock_movements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `stock_movements` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `type` enum('in','out') COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `stock_movements_product_id_foreign` (`product_id`),
  KEY `stock_movements_user_id_foreign` (`user_id`),
  CONSTRAINT `stock_movements_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `stock_movements_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stock_movements`
--

LOCK TABLES `stock_movements` WRITE;
/*!40000 ALTER TABLE `stock_movements` DISABLE KEYS */;
/*!40000 ALTER TABLE `stock_movements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stock_transactions`
--

DROP TABLE IF EXISTS `stock_transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `stock_transactions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `suppliers_id` bigint unsigned DEFAULT NULL,
  `user_id` bigint unsigned NOT NULL,
  `type` enum('in','out','adjustment','transfer') COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `stock_transactions_product_id_foreign` (`product_id`),
  KEY `stock_transactions_suppliers_id_foreign` (`suppliers_id`),
  KEY `stock_transactions_user_id_foreign` (`user_id`),
  CONSTRAINT `stock_transactions_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `stock_transactions_suppliers_id_foreign` FOREIGN KEY (`suppliers_id`) REFERENCES `suppliers` (`id`) ON DELETE SET NULL,
  CONSTRAINT `stock_transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stock_transactions`
--

LOCK TABLES `stock_transactions` WRITE;
/*!40000 ALTER TABLE `stock_transactions` DISABLE KEYS */;
INSERT INTO `stock_transactions` VALUES (1,1,1,2,'in',10,NULL,'2026-08-01 04:32:16','2026-08-01 04:32:16'),(2,1,NULL,2,'out',2,NULL,'2026-08-01 09:21:21','2026-08-01 09:21:21'),(3,2,1,2,'in',10,NULL,'2026-08-10 11:40:43','2026-08-10 11:40:43'),(4,2,NULL,2,'out',5,NULL,'2026-08-10 11:42:08','2026-08-10 11:42:08'),(5,2,NULL,2,'transfer',1,NULL,'2026-08-10 16:23:58','2026-08-23 13:28:40'),(6,3,2,2,'in',10,NULL,'2026-08-11 04:38:44','2026-08-11 04:38:44'),(7,4,NULL,2,'adjustment',25,'Adjustment (add): Old Stock (0) -> New Stock (25). Reason: Good','2026-08-12 13:24:31','2026-08-12 13:24:31'),(8,6,1,2,'in',10,NULL,'2026-08-14 03:39:30','2026-08-14 03:39:30'),(9,4,1,2,'in',10,NULL,'2026-08-14 05:43:33','2026-08-14 05:43:33'),(11,3,1,2,'in',2,NULL,'2026-08-14 05:45:59','2026-08-14 05:45:59'),(12,3,1,2,'in',2,NULL,'2026-08-14 05:47:43','2026-08-14 05:47:43'),(13,1,1,2,'in',2,NULL,'2026-08-14 05:48:00','2026-08-14 05:48:00'),(14,1,NULL,2,'out',1,NULL,'2026-08-14 05:53:35','2026-08-14 05:53:35'),(15,1,NULL,2,'out',1,NULL,'2026-08-14 05:54:09','2026-08-14 05:54:09'),(16,1,NULL,2,'adjustment',2,'Adjustment (add): Old Stock (8) -> New Stock (10). Reason: Goood','2026-08-14 05:56:42','2026-08-14 05:56:42'),(17,1,NULL,2,'adjustment',1,'Adjustment (subtract): Old Stock (8) -> New Stock (7). Reason: cool','2026-08-14 05:57:32','2026-08-14 05:57:32'),(18,1,1,1,'in',2,NULL,'2026-08-16 09:57:58','2026-08-16 09:57:58'),(19,7,1,2,'in',1,NULL,'2026-08-17 03:29:48','2026-08-17 03:29:48'),(20,8,1,2,'in',1,NULL,'2026-08-17 05:07:53','2026-08-17 05:07:53'),(21,8,1,2,'in',1,NULL,'2026-08-17 05:08:09','2026-08-17 05:08:09'),(22,8,NULL,2,'adjustment',2,'Adjustment (add): Old Stock (2) -> New Stock (4). Reason: add','2026-08-17 12:04:42','2026-08-17 12:04:42'),(23,8,NULL,2,'adjustment',1,'Adjustment (add): Old Stock (2) -> New Stock (3). Reason: add','2026-08-17 12:49:08','2026-08-17 12:49:08'),(24,7,1,2,'in',5,NULL,'2026-08-23 15:23:32','2026-08-23 15:23:32'),(25,1,1,2,'in',5,NULL,'2026-08-24 11:18:32','2026-08-24 11:18:32'),(26,1,1,1,'in',5,NULL,'2026-08-24 13:02:52','2026-08-24 13:02:52'),(27,1,NULL,1,'out',5,'Broken','2026-08-24 13:03:43','2026-08-24 13:03:43'),(28,1,NULL,1,'adjustment',5,'Adjustment (add): Old Stock (15) -> New Stock (20). Reason: Confuse','2026-08-24 13:04:20','2026-08-24 13:04:20'),(29,1,2,2,'in',10,NULL,'2026-08-29 10:51:08','2026-08-29 10:51:08');
/*!40000 ALTER TABLE `stock_transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `suppliers`
--

DROP TABLE IF EXISTS `suppliers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `suppliers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_time` datetime DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suppliers`
--

LOCK TABLES `suppliers` WRITE;
/*!40000 ALTER TABLE `suppliers` DISABLE KEYS */;
INSERT INTO `suppliers` VALUES (1,'America','090​​ 47 48 32','mrrsokchea0@gmail.com','2026-08-05 10:16:00','Good','2026-08-01 04:16:00','2026-08-05 03:16:15'),(2,'Japan','090​​ 47 4090','mrrsokchea12@gmail.com','2026-08-05 00:06:00',NULL,'2026-08-04 10:06:30','2026-08-04 10:06:30'),(4,'Holland','090​​ 47 4091','mrrsokchea14@gmail.com','2026-08-15 12:00:00',NULL,'2026-08-15 06:23:44','2026-08-24 13:01:51'),(5,'Cambodia','090​​ 47 48 32','mrrsokchea0@gmail.com','2026-08-24 12:00:00','Good','2026-08-24 13:02:33','2026-08-29 10:50:49');
/*!40000 ALTER TABLE `suppliers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_roles`
--

DROP TABLE IF EXISTS `user_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `role_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_roles_user_id_foreign` (`user_id`),
  CONSTRAINT `user_roles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_roles`
--

LOCK TABLES `user_roles` WRITE;
/*!40000 ALTER TABLE `user_roles` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_settings`
--

DROP TABLE IF EXISTS `user_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `email_notifications` tinyint(1) NOT NULL DEFAULT '1',
  `push_notifications` tinyint(1) NOT NULL DEFAULT '1',
  `theme` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'light',
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_settings_user_id_unique` (`user_id`),
  CONSTRAINT `user_settings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_settings`
--

LOCK TABLES `user_settings` WRITE;
/*!40000 ALTER TABLE `user_settings` DISABLE KEYS */;
INSERT INTO `user_settings` VALUES (1,2,1,0,'light','en','2026-08-01 04:23:59','2026-08-01 04:23:59'),(2,1,1,0,'light','en','2026-08-01 05:44:06','2026-08-01 05:44:06');
/*!40000 ALTER TABLE `user_settings` ENABLE KEYS */;
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
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `age` int DEFAULT NULL,
  `major` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `score` decimal(5,2) DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Sengouth Tha','senghouth.than1212@gmail.com','090​​ 47 4090',NULL,'$2y$12$.Xa5p5su5qwU9gTCeTuMUugFNZWvNC4v.QBMKYNnega5GLMOmy7D2','user',NULL,NULL,NULL,NULL,'Phnom Penh',NULL,'2026-07-30 06:36:02','2026-08-24 13:11:39','Active',NULL,'profile-images/aSdzfHIcBjf4tT9tUxmepplARyr39e2EDw6Ip8bd.jpg'),(2,'Mao Sokchea','mrrsokchea0@gmail.com','090​​ 47 48 32',NULL,'$2y$12$PsQt2YbWG6qvks3BPQ19RO129ugemlXqA9VRnuLPpYc71zfXpHEB6','admin',NULL,NULL,NULL,NULL,'Kratie',NULL,'2026-08-01 02:38:55','2026-08-16 07:01:37','Active',NULL,'profile-images/Yv59xhXrt39G6iJCTX6ZYCsVORgBVjwXfCJSqAQo.jpg'),(3,'Admin','mrrsokchea12@gmail.com',NULL,NULL,'$2y$12$AX3KNz0LYoYRedzJBpvg1eZhSNE5Lpk7KeG6uO8Nmqm2CO2wIzq3K','admin',NULL,NULL,NULL,NULL,NULL,NULL,'2026-08-16 10:00:04','2026-08-24 13:08:14','Active',NULL,NULL),(4,'mrrsokchea','mrrsokchea0123@gmail.como',NULL,NULL,'$2y$12$DZJGA381OhoJpPcAM0o20.OMYbJMLeIa/PS.NhSxxiSCq4dY442s2','user',NULL,NULL,NULL,NULL,NULL,NULL,'2026-08-24 11:24:18','2026-08-24 11:24:18','Active',NULL,NULL);
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

-- Dump completed on 2026-08-31 19:11:22
