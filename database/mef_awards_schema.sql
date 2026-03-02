SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- USE DATABASE
CREATE DATABASE IF NOT EXISTS `mef_awards`
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
USE `mef_awards`;

-- =========================
-- DROP OLD TABLES
-- =========================
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `nomination_documents`;
DROP TABLE IF EXISTS `nomination_details`;
DROP TABLE IF EXISTS `nomination`;
DROP TABLE IF EXISTS `nominee`;
DROP TABLE IF EXISTS `nominator`;
DROP TABLE IF EXISTS `join_requests`;
DROP TABLE IF EXISTS `award_category`;
DROP TABLE IF EXISTS `testimonies`;

SET FOREIGN_KEY_CHECKS = 1;

-- =========================
-- CREATE TABLES
-- =========================
CREATE TABLE `award_category` (
  `award_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`award_category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `award_category` (`award_category_id`, `category_name`, `description`) VALUES
(1, 'AI Champion Award', NULL),
(2, 'Entrepreneur of the year Award', NULL),
(3, 'African Development Research Award', NULL),
(4, 'Agricultural Innovation & Impact Award', NULL),
(5, 'Emerging Business Award', NULL);

CREATE TABLE `join_requests` (
  `join_request_id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `institution` varchar(150) NOT NULL,
  `role` enum('Student','Partner','Volunteer','Sponsor') NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`join_request_id`),
  KEY `idx_join_email` (`email`),
  KEY `idx_join_role` (`role`),
  KEY `idx_join_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `nominator` (
  `nominator_id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`nominator_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `nominee` (
  `nominee_id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(150) NOT NULL,
  `id_number` varchar(50) NOT NULL,
  `dob` date NOT NULL,
  `gender` enum('Male','Female','Other','Prefer not to say') NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `facebook_link` varchar(255) DEFAULT NULL,
  `instagram_link` varchar(255) DEFAULT NULL,
  `x_link` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`nominee_id`),
  UNIQUE KEY `id_number` (`id_number`),
  UNIQUE KEY `uniq_nominee_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `nomination` (
  `nomination_id` int(11) NOT NULL AUTO_INCREMENT,
  `nominee_id` int(11) NOT NULL,
  `nominator_id` int(11) NOT NULL,
  `award_category_id` int(11) NOT NULL,
  `qualification` text NOT NULL,
  `submission_datetime` datetime DEFAULT current_timestamp(),
  `status` varchar(50) NOT NULL DEFAULT 'Submitted',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`nomination_id`),
  KEY `fk_nomination_nominee` (`nominee_id`),
  KEY `fk_nomination_nominator` (`nominator_id`),
  KEY `fk_nomination_category` (`award_category_id`),
  CONSTRAINT `fk_nomination_category`
    FOREIGN KEY (`award_category_id`) REFERENCES `award_category` (`award_category_id`),
  CONSTRAINT `fk_nomination_nominator`
    FOREIGN KEY (`nominator_id`) REFERENCES `nominator` (`nominator_id`),
  CONSTRAINT `fk_nomination_nominee`
    FOREIGN KEY (`nominee_id`) REFERENCES `nominee` (`nominee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `nomination_details` (
  `nomination_details_id` int(11) NOT NULL AUTO_INCREMENT,
  `nomination_id` int(11) NOT NULL,
  `category_key` varchar(80) NOT NULL,
  `details_json` longtext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`nomination_details_id`),
  KEY `idx_nomination_details_nomination_id` (`nomination_id`),
  CONSTRAINT `fk_nomination_details_nomination`
    FOREIGN KEY (`nomination_id`) REFERENCES `nomination` (`nomination_id`)
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `nomination_documents` (
  `nomination_document_id` int(11) NOT NULL AUTO_INCREMENT,
  `nomination_id` int(11) NOT NULL,
  `doc_type` varchar(80) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `original_name` varchar(255) NOT NULL,
  `mime_type` varchar(100) DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`nomination_document_id`),
  KEY `idx_nomination_documents_nomination_id` (`nomination_id`),
  KEY `idx_nomination_documents_doc_type` (`doc_type`),
  CONSTRAINT `fk_nomination_documents_nomination`
    FOREIGN KEY (`nomination_id`) REFERENCES `nomination` (`nomination_id`)
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `testimonies` (
  `testimony_id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(120) NOT NULL,
  `location` varchar(120) DEFAULT NULL,
  `field_of_study` varchar(120) DEFAULT NULL,
  `email` varchar(190) DEFAULT NULL,
  `title` varchar(160) NOT NULL,
  `story` text NOT NULL,
  `quote` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`testimony_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

COMMIT;