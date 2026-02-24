-- MEF Awards Database Schema
-- No sample data (app will insert records)

CREATE DATABASE IF NOT EXISTS mef_awards
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE mef_awards;

-- =============================
-- TABLE: award_category
-- =============================
DROP TABLE IF EXISTS award_category;
CREATE TABLE award_category (
  award_category_id INT(11) NOT NULL AUTO_INCREMENT,
  category_name VARCHAR(150) NOT NULL,
  description TEXT DEFAULT NULL,
  PRIMARY KEY (award_category_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================
-- TABLE: nominee
-- =============================
DROP TABLE IF EXISTS nominee;
CREATE TABLE nominee (
  nominee_id INT(11) NOT NULL AUTO_INCREMENT,
  full_name VARCHAR(150) NOT NULL,
  id_number VARCHAR(50) NOT NULL,
  dob DATE NOT NULL,
  gender ENUM('Male','Female','Other','Prefer not to say') NOT NULL,
  email VARCHAR(150) NOT NULL,
  phone_number VARCHAR(20) DEFAULT NULL,
  facebook_link VARCHAR(255) DEFAULT NULL,
  instagram_link VARCHAR(255) DEFAULT NULL,
  x_link VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (nominee_id),
  UNIQUE KEY id_number (id_number),
  UNIQUE KEY uniq_nominee_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================
-- TABLE: nominator
-- =============================
DROP TABLE IF EXISTS nominator;
CREATE TABLE nominator (
  nominator_id INT(11) NOT NULL AUTO_INCREMENT,
  full_name VARCHAR(150) NOT NULL,
  email VARCHAR(150) NOT NULL,
  phone_number VARCHAR(20) DEFAULT NULL,
  PRIMARY KEY (nominator_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================
-- TABLE: testimonies
-- =============================
DROP TABLE IF EXISTS testimonies;
CREATE TABLE testimonies (
  testimony_id INT(11) NOT NULL AUTO_INCREMENT,
  full_name VARCHAR(120) NOT NULL,
  location VARCHAR(120) DEFAULT NULL,
  field_of_study VARCHAR(120) DEFAULT NULL,
  email VARCHAR(190) DEFAULT NULL,
  title VARCHAR(160) NOT NULL,
  story TEXT NOT NULL,
  quote VARCHAR(255) DEFAULT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (testimony_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================
-- TABLE: nomination
-- =============================
DROP TABLE IF EXISTS nomination;
CREATE TABLE nomination (
  nomination_id INT(11) NOT NULL AUTO_INCREMENT,
  nominee_id INT(11) NOT NULL,
  nominator_id INT(11) NOT NULL,
  award_category_id INT(11) NOT NULL,
  qualification TEXT NOT NULL,
  submission_datetime DATETIME DEFAULT CURRENT_TIMESTAMP,
  status VARCHAR(50) NOT NULL DEFAULT 'Submitted',
  PRIMARY KEY (nomination_id),
  KEY fk_nomination_nominee (nominee_id),
  KEY fk_nomination_nominator (nominator_id),
  KEY fk_nomination_category (award_category_id),
  CONSTRAINT fk_nomination_nominee
    FOREIGN KEY (nominee_id) REFERENCES nominee (nominee_id),
  CONSTRAINT fk_nomination_nominator
    FOREIGN KEY (nominator_id) REFERENCES nominator (nominator_id),
  CONSTRAINT fk_nomination_category
    FOREIGN KEY (award_category_id) REFERENCES award_category (award_category_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;