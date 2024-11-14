-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Nov 13, 2024 at 11:29 AM
-- Server version: 10.6.12-MariaDB-1:10.6.12+maria~ubu2004-log
-- PHP Version: 8.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sql_tp`
--

-- --------------------------------------------------------

--
-- Table structure for table `ads`
--

CREATE TABLE `ads` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_admin_id` int(10) UNSIGNED DEFAULT NULL,
  `user_pp_id` int(10) UNSIGNED NOT NULL,
  `is_draft` tinyint(1) NOT NULL,
  `accept_share_contact_infos` tinyint(1) NOT NULL DEFAULT 0,
  `title` varchar(255) DEFAULT NULL,
  `about_content` varchar(1000) DEFAULT NULL,
  `about_project_content` varchar(1000) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(10) UNSIGNED NOT NULL,
  `department_code` varchar(255) NOT NULL,
  `insee_code` varchar(255) NOT NULL,
  `zip_code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `gps_lat` double(16,14) NOT NULL,
  `gps_lng` double(17,14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `code` int(11) NOT NULL,
  `alpha2` varchar(255) NOT NULL,
  `alpha3` varchar(255) NOT NULL,
  `name_en_gb` varchar(255) NOT NULL,
  `name_fr_fr` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(10) UNSIGNED NOT NULL,
  `region_code` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `documentables`
--

CREATE TABLE `documentables` (
  `id` int(10) UNSIGNED NOT NULL,
  `document_id` int(10) UNSIGNED NOT NULL,
  `documentable_id` int(10) UNSIGNED NOT NULL,
  `documentable_type` varchar(255) NOT NULL COMMENT 'tables référentes : ads et ad_note',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `size` int(11) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `land_offer_ads`
--

CREATE TABLE `land_offer_ads` (
  `id` int(10) UNSIGNED NOT NULL,
  `accept_use_zip_code` tinyint(1) NOT NULL DEFAULT 1,
  `surface` int(11) NOT NULL,
  `sau_description` varchar(1000) DEFAULT NULL,
  `water_access` tinyint(1) DEFAULT NULL,
  `ad_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `land_seek_ads`
--

CREATE TABLE `land_seek_ads` (
  `id` int(10) UNSIGNED NOT NULL,
  `is_bio` tinyint(1) DEFAULT NULL,
  `experience_farming` text DEFAULT NULL,
  `ad_id` int(10) UNSIGNED NOT NULL,
  `surface_range_min` int(11) DEFAULT NULL,
  `surface_range_max` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `locationable_ads`
--

CREATE TABLE `locationable_ads` (
  `id` int(10) UNSIGNED NOT NULL,
  `ad_id` int(10) UNSIGNED NOT NULL,
  `locationable_ad_id` int(10) UNSIGNED NOT NULL,
  `locationable_ad_type` varchar(255) NOT NULL COMMENT 'cette colonne fait référence aux tables ads, researches',
  `radius` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `productionable_genres`
--

CREATE TABLE `productionable_genres` (
  `id` int(10) UNSIGNED NOT NULL,
  `production_genre_id` int(10) UNSIGNED NOT NULL,
  `productionable_genre_id` int(10) UNSIGNED NOT NULL,
  `productionable_genre_type` varchar(255) NOT NULL COMMENT 'Cette colonne liste les modèle qui sont rattaché à un type de production : la table land_seek_ads, land_offer_ads et la table researches.',
  `type` enum('actual','possible') NOT NULL DEFAULT 'actual',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `production_genres`
--

CREATE TABLE `production_genres` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `regions`
--

CREATE TABLE `regions` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(3) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `sf_id` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `country_id` smallint(5) UNSIGNED DEFAULT NULL,
  `zip_code_id` int(10) UNSIGNED DEFAULT NULL,
  `role` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ads`
--
ALTER TABLE `ads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `iix_ads_user_admin_id` (`user_admin_id`),
  ADD KEY `ix_ads_user_lead_id` (`user_pp_id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cities_department_code_foreign` (`department_code`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `departments_code_unique` (`code`),
  ADD KEY `departments_region_code_foreign` (`region_code`);

--
-- Indexes for table `documentables`
--
ALTER TABLE `documentables`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_documentable_1` (`document_id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `documents_user_id_foreign` (`user_id`);

--
-- Indexes for table `land_offer_ads`
--
ALTER TABLE `land_offer_ads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_land_offer_ads_1_idx` (`ad_id`);

--
-- Indexes for table `land_seek_ads`
--
ALTER TABLE `land_seek_ads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_land_seek_ads_1_idx` (`ad_id`);

--
-- Indexes for table `locationable_ads`
--
ALTER TABLE `locationable_ads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_locationable_ads_1` (`ad_id`),
  ADD KEY `ix_locationable_ad_1` (`locationable_ad_id`),
  ADD KEY `ix_locationable_ad_2` (`locationable_ad_type`);

--
-- Indexes for table `productionable_genres`
--
ALTER TABLE `productionable_genres`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_productionable_genre_1_idx` (`production_genre_id`),
  ADD KEY `ix_productionable_genre_2` (`productionable_genre_type`),
  ADD KEY `ix_productionable_genre_1` (`productionable_genre_id`);

--
-- Indexes for table `production_genres`
--
ALTER TABLE `production_genres`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_parent_idx` (`parent_id`);

--
-- Indexes for table `regions`
--
ALTER TABLE `regions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `regions_code_unique` (`code`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `fk_users_countries_1_idx` (`country_id`),
  ADD KEY `fk_users_zip_code_2_idx` (`zip_code_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ads`
--
ALTER TABLE `ads`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `documentables`
--
ALTER TABLE `documentables`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `land_offer_ads`
--
ALTER TABLE `land_offer_ads`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `land_seek_ads`
--
ALTER TABLE `land_seek_ads`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `locationable_ads`
--
ALTER TABLE `locationable_ads`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `productionable_genres`
--
ALTER TABLE `productionable_genres`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `production_genres`
--
ALTER TABLE `production_genres`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `regions`
--
ALTER TABLE `regions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ads`
--
ALTER TABLE `ads`
  ADD CONSTRAINT `iix_ads_user_admin_id` FOREIGN KEY (`user_admin_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ix_ads_user_lead_id` FOREIGN KEY (`user_pp_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `cities_department_code_foreign` FOREIGN KEY (`department_code`) REFERENCES `departments` (`code`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `departments_region_code_foreign` FOREIGN KEY (`region_code`) REFERENCES `regions` (`code`);

--
-- Constraints for table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `land_offer_ads`
--
ALTER TABLE `land_offer_ads`
  ADD CONSTRAINT `fk_land_offer_ads_1_idx` FOREIGN KEY (`ad_id`) REFERENCES `ads` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `land_seek_ads`
--
ALTER TABLE `land_seek_ads`
  ADD CONSTRAINT `fk_land_seek_ads_1_idx` FOREIGN KEY (`ad_id`) REFERENCES `ads` (`id`);

--
-- Constraints for table `locationable_ads`
--
ALTER TABLE `locationable_ads`
  ADD CONSTRAINT `fk_locationable_ads_1` FOREIGN KEY (`ad_id`) REFERENCES `ads` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `productionable_genres`
--
ALTER TABLE `productionable_genres`
  ADD CONSTRAINT `fk_productionable_genre_1_idx` FOREIGN KEY (`production_genre_id`) REFERENCES `production_genres` (`id`);

--
-- Constraints for table `production_genres`
--
ALTER TABLE `production_genres`
  ADD CONSTRAINT `fk_parent_idx` FOREIGN KEY (`parent_id`) REFERENCES `production_genres` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_countries_1_idx` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`),
  ADD CONSTRAINT `fk_users_zip_code_2_idx` FOREIGN KEY (`zip_code_id`) REFERENCES `cities` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
