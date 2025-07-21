-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.32-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.10.0.7000
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for baroon_reptile
CREATE DATABASE IF NOT EXISTS `baroon_reptile` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `baroon_reptile`;

-- Dumping structure for table baroon_reptile.bookings
CREATE TABLE IF NOT EXISTS `bookings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `reptile_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `total_days` int(11) NOT NULL,
  `price_per_day` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` enum('pending','confirmed','in_progress','completed','cancelled') DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  KEY `reptile_id` (`reptile_id`),
  CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`reptile_id`) REFERENCES `reptiles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table baroon_reptile.bookings: ~1 rows (approximately)
INSERT INTO `bookings` (`id`, `customer_id`, `reptile_id`, `start_date`, `end_date`, `total_days`, `price_per_day`, `total_price`, `status`, `notes`, `created_at`, `updated_at`) VALUES
	(1, 2, 1, '2025-07-23', '2025-07-26', 3, 50000.00, 150000.00, 'in_progress', 'beri makan', '2025-07-19 18:10:30', '2025-07-19 20:12:46');

-- Dumping structure for table baroon_reptile.daily_business_reports
CREATE TABLE IF NOT EXISTS `daily_business_reports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `report_date` date NOT NULL,
  `total_bookings` int(11) DEFAULT 0,
  `total_revenue` decimal(15,2) DEFAULT 0.00,
  `active_reptiles` int(11) DEFAULT 0,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `report_date` (`report_date`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table baroon_reptile.daily_business_reports: ~2 rows (approximately)
INSERT INTO `daily_business_reports` (`id`, `report_date`, `total_bookings`, `total_revenue`, `active_reptiles`, `notes`, `created_at`, `updated_at`) VALUES
	(1, '2025-07-20', 5, 250000.00, 12, 'Sample daily report', '2025-07-20 16:22:14', '2025-07-20 16:22:14'),
	(2, '2025-07-19', 3, 150000.00, 12, 'Yesterday report', '2025-07-20 16:22:14', '2025-07-20 16:22:14');

-- Dumping structure for table baroon_reptile.daily_reports
CREATE TABLE IF NOT EXISTS `daily_reports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reptile_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `report_date` date NOT NULL,
  `feeding_time` time DEFAULT NULL,
  `feeding_notes` text DEFAULT NULL,
  `health_status` enum('excellent','good','fair','poor') DEFAULT 'good',
  `activity_level` enum('very_active','active','normal','low','inactive') DEFAULT 'normal',
  `temperature` decimal(4,1) DEFAULT NULL,
  `humidity` decimal(4,1) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `photos` varchar(500) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `reptile_id` (`reptile_id`),
  KEY `booking_id` (`booking_id`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `daily_reports_ibfk_1` FOREIGN KEY (`reptile_id`) REFERENCES `reptiles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `daily_reports_ibfk_2` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  CONSTRAINT `daily_reports_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table baroon_reptile.daily_reports: ~0 rows (approximately)

-- Dumping structure for table baroon_reptile.facilities
CREATE TABLE IF NOT EXISTS `facilities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `capacity` int(11) DEFAULT 1,
  `price_per_day` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` enum('available','occupied','maintenance') DEFAULT 'available',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table baroon_reptile.facilities: ~7 rows (approximately)
INSERT INTO `facilities` (`id`, `name`, `description`, `capacity`, `price_per_day`, `status`, `created_at`) VALUES
	(1, 'Terrarium Kecil A1', 'Terrarium 60x40x40cm untuk reptile kecil', 1, 25000.00, '', '2025-07-19 17:54:33'),
	(2, 'Terrarium Kecil A2', 'Terrarium 60x40x40cm untuk reptile kecil', 1, 25000.00, 'available', '2025-07-19 17:54:33'),
	(3, 'Terrarium Sedang B1', 'Terrarium 100x50x50cm untuk reptile sedang', 1, 35000.00, 'available', '2025-07-19 17:54:33'),
	(4, 'Terrarium Sedang B2', 'Terrarium 100x50x50cm untuk reptile sedang', 1, 35000.00, 'available', '2025-07-19 17:54:33'),
	(5, 'Terrarium Besar C1', 'Terrarium 150x80x80cm untuk reptile besar', 1, 50000.00, 'available', '2025-07-19 17:54:33'),
	(6, 'Aquarium Kura-kura D1', 'Aquarium 100x50x40cm untuk kura-kura air', 1, 30000.00, 'available', '2025-07-19 17:54:33'),
	(7, 'Kandang Outdoor E1', 'Kandang outdoor untuk kura-kura darat', 2, 40000.00, 'available', '2025-07-19 17:54:33');

-- Dumping structure for table baroon_reptile.payments
CREATE TABLE IF NOT EXISTS `payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `booking_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` enum('cash','transfer','credit_card') NOT NULL,
  `payment_status` enum('pending','paid','failed') DEFAULT 'pending',
  `payment_date` timestamp NULL DEFAULT NULL,
  `proof_image` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `booking_id` (`booking_id`),
  CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table baroon_reptile.payments: ~0 rows (approximately)
INSERT INTO `payments` (`id`, `booking_id`, `amount`, `payment_method`, `payment_status`, `payment_date`, `proof_image`, `notes`, `created_at`) VALUES
	(1, 1, 150000.00, 'transfer', 'paid', NULL, NULL, 'tf ke 231312 an rifasha', '2025-07-19 18:17:16');

-- Dumping structure for table baroon_reptile.reptiles
CREATE TABLE IF NOT EXISTS `reptiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `species` varchar(100) DEFAULT NULL,
  `age` varchar(20) DEFAULT NULL,
  `weight` decimal(5,2) DEFAULT NULL,
  `length` decimal(5,2) DEFAULT NULL,
  `gender` enum('male','female','unknown') DEFAULT NULL,
  `special_needs` text DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `status` enum('active','completed','cancelled') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `reptiles_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reptiles_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `reptile_categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table baroon_reptile.reptiles: ~0 rows (approximately)
INSERT INTO `reptiles` (`id`, `customer_id`, `category_id`, `name`, `species`, `age`, `weight`, `length`, `gender`, `special_needs`, `photo`, `status`, `created_at`, `updated_at`) VALUES
	(1, 2, 3, 'Sanca albino', 'python retic', '5', 5.00, 200.00, 'male', 'alergi rifasha', '', 'active', '2025-07-19 18:00:33', '2025-07-19 18:08:51');

-- Dumping structure for table baroon_reptile.reptile_categories
CREATE TABLE IF NOT EXISTS `reptile_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `price_per_day` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table baroon_reptile.reptile_categories: ~8 rows (approximately)
INSERT INTO `reptile_categories` (`id`, `name`, `description`, `price_per_day`, `created_at`) VALUES
	(1, 'Ular Kecil', 'Ular dengan panjang kurang dari 1 meter', 25000.00, '2025-07-19 17:54:33'),
	(2, 'Ular Sedang', 'Ular dengan panjang 1-2 meter', 35000.00, '2025-07-19 17:54:33'),
	(3, 'Ular Besar', 'Ular dengan panjang lebih dari 2 meter', 50000.00, '2025-07-19 17:54:33'),
	(4, 'Kadal Kecil', 'Gecko, tokek, dan kadal kecil lainnya', 20000.00, '2025-07-19 17:54:33'),
	(5, 'Kadal Sedang', 'Iguana, bearded dragon, monitor kecil', 40000.00, '2025-07-19 17:54:33'),
	(6, 'Kadal Besar', 'Monitor besar, iguana dewasa', 60000.00, '2025-07-19 17:54:33'),
	(7, 'Kura-kura Darat', 'Kura-kura darat berbagai ukuran', 30000.00, '2025-07-19 17:54:33'),
	(8, 'Kura-kura Air', 'Kura-kura air dan semi-aquatic', 35000.00, '2025-07-19 17:54:33');

-- Dumping structure for table baroon_reptile.testimonials
CREATE TABLE IF NOT EXISTS `testimonials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `comment` text DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `testimonials_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table baroon_reptile.testimonials: ~0 rows (approximately)

-- Dumping structure for table baroon_reptile.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `role` enum('admin','customer') DEFAULT 'customer',
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table baroon_reptile.users: ~2 rows (approximately)
INSERT INTO `users` (`id`, `username`, `email`, `password`, `full_name`, `phone`, `address`, `role`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'admin', 'admin@baroonreptile.com', '$2y$10$y28Ps1hT5psBDKyihloabOEz9V/uOnIBDCKjBYt5rpCXdv7uP.0uK', 'Administrator', '081234567890', NULL, 'admin', 'active', '2025-07-19 17:54:33', '2025-07-19 17:57:24'),
	(2, 'customer1', 'customer@example.com', '$2y$10$b14onakvPP1K9fojo/N5GejyzneuVUsFuvB2/8ryjhCLLDA.Ny30W', 'John Doe', '081234567891', NULL, 'customer', 'active', '2025-07-19 17:54:33', '2025-07-19 17:57:24');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
