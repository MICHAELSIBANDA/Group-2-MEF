-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 24, 2026 at 01:46 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mef_awards`
--

-- --------------------------------------------------------

--
-- Table structure for table `award_category`
--

CREATE TABLE `award_category` (
  `award_category_id` int(11) NOT NULL,
  `category_name` varchar(150) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `award_category`
--

INSERT INTO `award_category` (`award_category_id`, `category_name`, `description`) VALUES
(1, 'AI Champion Award', NULL),
(2, 'Entrepreneur of the year Award', NULL),
(3, 'African Development Research Award', NULL),
(4, 'Agricultural Innovation & Impact Award', NULL),
(5, 'Emerging Business Award', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `nomination`
--

CREATE TABLE `nomination` (
  `nomination_id` int(11) NOT NULL,
  `nominee_id` int(11) NOT NULL,
  `nominator_id` int(11) NOT NULL,
  `award_category_id` int(11) NOT NULL,
  `qualification` text NOT NULL,
  `submission_datetime` datetime DEFAULT current_timestamp(),
  `status` varchar(50) NOT NULL DEFAULT 'Submitted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nomination`
--

INSERT INTO `nomination` (`nomination_id`, `nominee_id`, `nominator_id`, `award_category_id`, `qualification`, `submission_datetime`, `status`) VALUES
(2, 2, 2, 4, 'WW35', '2026-02-24 14:35:28', 'Submitted');

-- --------------------------------------------------------

--
-- Table structure for table `nominator`
--

CREATE TABLE `nominator` (
  `nominator_id` int(11) NOT NULL,
  `full_name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nominator`
--

INSERT INTO `nominator` (`nominator_id`, `full_name`, `email`, `phone_number`) VALUES
(2, 'E4TR', 'sa@gmail.com', '123');

-- --------------------------------------------------------

--
-- Table structure for table `nominee`
--

CREATE TABLE `nominee` (
  `nominee_id` int(11) NOT NULL,
  `full_name` varchar(150) NOT NULL,
  `id_number` varchar(50) NOT NULL,
  `dob` date NOT NULL,
  `gender` enum('Male','Female','Other','Prefer not to say') NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `facebook_link` varchar(255) DEFAULT NULL,
  `instagram_link` varchar(255) DEFAULT NULL,
  `x_link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nominee`
--

INSERT INTO `nominee` (`nominee_id`, `full_name`, `id_number`, `dob`, `gender`, `email`, `phone_number`, `facebook_link`, `instagram_link`, `x_link`) VALUES
(2, 'SSS', '12334', '2026-02-10', 'Male', 'sa@gmail.com', '1223', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `testimonies`
--

CREATE TABLE `testimonies` (
  `testimony_id` int(11) NOT NULL,
  `full_name` varchar(120) NOT NULL,
  `location` varchar(120) DEFAULT NULL,
  `field_of_study` varchar(120) DEFAULT NULL,
  `email` varchar(190) DEFAULT NULL,
  `title` varchar(160) NOT NULL,
  `story` text NOT NULL,
  `quote` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `award_category`
--
ALTER TABLE `award_category`
  ADD PRIMARY KEY (`award_category_id`);

--
-- Indexes for table `nomination`
--
ALTER TABLE `nomination`
  ADD PRIMARY KEY (`nomination_id`),
  ADD KEY `fk_nomination_nominee` (`nominee_id`),
  ADD KEY `fk_nomination_nominator` (`nominator_id`),
  ADD KEY `fk_nomination_category` (`award_category_id`);

--
-- Indexes for table `nominator`
--
ALTER TABLE `nominator`
  ADD PRIMARY KEY (`nominator_id`);

--
-- Indexes for table `nominee`
--
ALTER TABLE `nominee`
  ADD PRIMARY KEY (`nominee_id`),
  ADD UNIQUE KEY `id_number` (`id_number`),
  ADD UNIQUE KEY `uniq_nominee_email` (`email`);

--
-- Indexes for table `testimonies`
--
ALTER TABLE `testimonies`
  ADD PRIMARY KEY (`testimony_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `award_category`
--
ALTER TABLE `award_category`
  MODIFY `award_category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `nomination`
--
ALTER TABLE `nomination`
  MODIFY `nomination_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `nominator`
--
ALTER TABLE `nominator`
  MODIFY `nominator_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `nominee`
--
ALTER TABLE `nominee`
  MODIFY `nominee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `testimonies`
--
ALTER TABLE `testimonies`
  MODIFY `testimony_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `nomination`
--
ALTER TABLE `nomination`
  ADD CONSTRAINT `fk_nomination_category` FOREIGN KEY (`award_category_id`) REFERENCES `award_category` (`award_category_id`),
  ADD CONSTRAINT `fk_nomination_nominator` FOREIGN KEY (`nominator_id`) REFERENCES `nominator` (`nominator_id`),
  ADD CONSTRAINT `fk_nomination_nominee` FOREIGN KEY (`nominee_id`) REFERENCES `nominee` (`nominee_id`);
COMMIT;

INSERT INTO award_category (category_name, description) VALUES
('AI Champion Award', NULL),
('Entrepreneur of the year Award', NULL),
('African Development Research Award', NULL),
('Agricultural Innovation & Impact Award', NULL),
('Emerging Business Award', NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
