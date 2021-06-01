-- phpMyAdmin SQL Dump
-- version 4.6.6deb5ubuntu0.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 28, 2021 at 10:08 AM
-- Server version: 5.7.32-0ubuntu0.18.04.1
-- PHP Version: 7.2.24-0ubuntu0.18.04.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rtcqi-logbook`
--

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `district_id` int(11) NOT NULL,
  `provincesss_id` int(11) NOT NULL,
  `district_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `facility`
--

CREATE TABLE `facility` (
  `facility_id` int(50) ,
  `facility_name` varchar(50) DEFAULT NULL,
  `facility_latitude` varchar(50) DEFAULT NULL,
  `facility_longitude` varchar(50) DEFAULT NULL,
  `facility_address1` varchar(50) DEFAULT NULL,
  `facility_address2` varchar(50) DEFAULT NULL,
  `facility_city` varchar(20) DEFAULT NULL,
  `facility_state` varchar(20) DEFAULT NULL,
  `facility_postal_code` varchar(20) DEFAULT NULL,
  `facility_country` varchar(20) DEFAULT NULL,
  `facility_region` varchar(20) DEFAULT NULL,
  `contact_name` varchar(50) DEFAULT NULL,
  `contact_email` varchar(50) DEFAULT NULL,
  `contact_phoneno` varchar(20) DEFAULT NULL,
  `facility_status` varchar(20) NOT NULL DEFAULT 'active' COMMENT '1 = Site is active, 0 deleted but present in database as som',
  `updated_on` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `facility_district_map`
--

CREATE TABLE `facility_district_map` (
  `fdm_id` int(11) NOT NULL,
  `facility_id` int(11) NOT NULL,
  `district_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `provinces`
--

CREATE TABLE `provinces` (
  `provincesss_id` int(11) NOT NULL,
  `province_name` varchar(100) NOT NULL,
  `province_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `site_type`
--

CREATE TABLE `site_type` (
  `st_id` int(10) NOT NULL,
  `site_type_name` varchar(100) NOT NULL,
  `site_type_status` varchar(10) NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `survey_data_collection`
--

CREATE TABLE `survey_data_collection` (
  `sdc_id` int(11) NOT NULL,
  `ts_id` int(11) NOT NULL COMMENT 'Site Name',
  `st_id` int(11) NOT NULL,
  `is_barcode_available` varchar(100) NOT NULL DEFAULT 'no',
  `site_unique_id` varchar(100) DEFAULT NULL,
  `provincesss_id` int(11) NOT NULL,
  `site_manager` varchar(100) DEFAULT NULL,
  `is_flc` varchar(10) NOT NULL DEFAULT 'no',
  `contact_no` varchar(100) DEFAULT NULL,
  `latitude` varchar(100) NOT NULL,
  `longitude` varchar(200) NOT NULL,
  `algorithm_type` varchar(255) DEFAULT NULL,
  `date_of_data_collection` date NOT NULL,
  `reporting_month` date NOT NULL,
  `book_no` int(10) NOT NULL DEFAULT '0',
  `name_of_data_collector` varchar(100) DEFAULT NULL,
  `signature` mediumtext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `survey_individual_test`
--

CREATE TABLE `survey_individual_test` (
  `sit_id` int(11) NOT NULL,
  `sdc_id` int(11) NOT NULL,
  `page_no` varchar(50) DEFAULT NULL,
  `start_test_date` date DEFAULT NULL,
  `end_test_date` date DEFAULT NULL,
  `test_1_kit_id` int(11) DEFAULT NULL,
  `test_2_kit_id` int(11) DEFAULT NULL,
  `test_3_kit_id` int(11) DEFAULT NULL,
  `test_4_kit_id` int(11) DEFAULT NULL,
  `test_1_reactive` int(11) DEFAULT NULL,
  `test_1_nonreactive` int(11) DEFAULT NULL,
  `test_1_invalid` int(11) DEFAULT NULL,
  `test_2_reactive` int(11) DEFAULT NULL,
  `test_2_nonreactive` int(11) DEFAULT NULL,
  `test_2_invalid` int(11) DEFAULT NULL,
  `test_3_reactive` int(11) DEFAULT NULL,
  `test_3_nonreactive` int(11) DEFAULT NULL,
  `test_3_invalid` int(11) DEFAULT NULL,
  `test_4_reactive` int(11) DEFAULT NULL,
  `test_4_nonreactive` int(11) DEFAULT NULL,
  `test_4_invalid` int(11) DEFAULT NULL,
  `final_positive` int(11) DEFAULT NULL,
  `final_negative` int(11) DEFAULT NULL,
  `final_undetermined` int(11) DEFAULT NULL,
  `positive_percentage` int(11) DEFAULT NULL,
  `positive_agreement` varchar(11) DEFAULT NULL,
  `overall_agreement` varchar(200) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `test_kit_information`
--

CREATE TABLE `test_kit_information` (
  `tk_id` int(11) NOT NULL,
  `test_kit_name_id` varchar(50) DEFAULT NULL,
  `test_kit_name_id_1` varchar(50) NOT NULL,
  `test_kit_name_short` varchar(100) DEFAULT NULL,
  `test_kit_name` varchar(100) NOT NULL,
  `test_kit_comments` varchar(50) DEFAULT NULL,
  `test_kit_manufacturer` varchar(100) NOT NULL,
  `test_kit_expiry_date` date DEFAULT NULL,
  `Installation_id` varchar(50) DEFAULT NULL,
  `test_kit_status` varchar(100) NOT NULL DEFAULT 'active',
  `updated_on` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_on` date NOT NULL,
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `test_site`
--

CREATE TABLE `test_site` (
  `ts_id` int(11) NOT NULL,
  `site_ID` varchar(100) DEFAULT NULL,
  `site_name` varchar(50) DEFAULT NULL,
  `site_latitude` varchar(100) DEFAULT NULL,
  `site_longitude` varchar(100) DEFAULT NULL,
  `site_address1` varchar(50) DEFAULT NULL,
  `site_address2` varchar(50) DEFAULT NULL,
  `site_postal_code` varchar(20) DEFAULT NULL,
  `site_city` varchar(20) DEFAULT NULL,
  `site_state` varchar(20) DEFAULT NULL,
  `site_country` varchar(20) DEFAULT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_on` datetime DEFAULT NULL,
  `test_site_status` varchar(10) DEFAULT 'active' COMMENT '1 = Site is active, 0 deleted but present in database as som',
  `created_on` date DEFAULT NULL,
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `user_status` varchar(255) DEFAULT 'active',
  `created_on` datetime DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `password`, `email`, `phone`, `user_status`, `created_on`, `updated_on`, `created_by`, `updated_by`) VALUES
(2, 'Prasath', 'Mahalingam', '$2y$10$bl209TD.1CtLkQl8RMfNiu7bP91Rke60cmEAgJIDPxUvKPCEIpEqO', 'mprasath2410@gmail.com', '6548789987', 'active', '2021-05-27 14:08:55', '2021-05-27 14:53:29', NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `users_facility_map`
--

CREATE TABLE `users_facility_map` (
  `ufm_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `facility_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`district_id`),
  ADD KEY `provincesss_id` (`provincesss_id`);

--
-- Indexes for table `facility`
--
ALTER TABLE `facility`
  ADD PRIMARY KEY (`facility_id`);

--
-- Indexes for table `facility_district_map`
--
ALTER TABLE `facility_district_map`
  ADD PRIMARY KEY (`fdm_id`);

--
-- Indexes for table `provinces`
--
ALTER TABLE `provinces`
  ADD PRIMARY KEY (`provincesss_id`);

--
-- Indexes for table `site_type`
--
ALTER TABLE `site_type`
  ADD PRIMARY KEY (`st_id`);

--
-- Indexes for table `survey_data_collection`
--
ALTER TABLE `survey_data_collection`
  ADD PRIMARY KEY (`sdc_id`),
  ADD KEY `ts_id` (`ts_id`),
  ADD KEY `st_id` (`st_id`),
  ADD KEY `provincesss_id` (`provincesss_id`);

--
-- Indexes for table `survey_individual_test`
--
ALTER TABLE `survey_individual_test`
  ADD PRIMARY KEY (`sit_id`),
  ADD KEY `sdc_id` (`sdc_id`),
  ADD KEY `test_3_invalid` (`test_3_invalid`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `page_no` (`page_no`);

--
-- Indexes for table `test_kit_information`
--
ALTER TABLE `test_kit_information`
  ADD PRIMARY KEY (`tk_id`),
  ADD KEY `Installation_id` (`Installation_id`);

--
-- Indexes for table `test_site`
--
ALTER TABLE `test_site`
  ADD PRIMARY KEY (`ts_id`),
  ADD UNIQUE KEY `ts_id` (`ts_id`),
  ADD KEY `site_postal_code` (`site_postal_code`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `users_facility_map`
--
ALTER TABLE `users_facility_map`
  ADD PRIMARY KEY (`ufm_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `districts`
--
ALTER TABLE `districts`
  MODIFY `district_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `facility_district_map`
--
ALTER TABLE `facility_district_map`
  MODIFY `fdm_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `provinces`
--
ALTER TABLE `provinces`
  MODIFY `provincesss_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `site_type`
--
ALTER TABLE `site_type`
  MODIFY `st_id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `survey_data_collection`
--
ALTER TABLE `survey_data_collection`
  MODIFY `sdc_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `test_kit_information`
--
ALTER TABLE `test_kit_information`
  MODIFY `tk_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `test_site`
--
ALTER TABLE `test_site`
  MODIFY `ts_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users_facility_map`
--
ALTER TABLE `users_facility_map`
  MODIFY `ufm_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `districts`
--
ALTER TABLE `districts`
  ADD CONSTRAINT `district_ibfk_1` FOREIGN KEY (`provincesss_id`) REFERENCES `provinces` (`provincesss_id`);

--
-- Constraints for table `survey_data_collection`
--
ALTER TABLE `survey_data_collection`
  ADD CONSTRAINT `survey_data_collection_ibfk_1` FOREIGN KEY (`ts_id`) REFERENCES `test_site` (`ts_id`),
  ADD CONSTRAINT `survey_data_collection_ibfk_2` FOREIGN KEY (`st_id`) REFERENCES `site_type` (`st_id`),
  ADD CONSTRAINT `survey_data_collection_ibfk_3` FOREIGN KEY (`provincesss_id`) REFERENCES `provinces` (`provincesss_id`);

--
-- Constraints for table `survey_individual_test`
--
ALTER TABLE `survey_individual_test`
  ADD CONSTRAINT `survey_individual_test_ibfk_1` FOREIGN KEY (`sdc_id`) REFERENCES `survey_data_collection` (`sdc_id`);

--
-- Constraints for table `users_facility_map`
--
ALTER TABLE `users_facility_map`
  ADD CONSTRAINT `users_facility_map_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- Prasath M 21 May 2021
ALTER TABLE `provinces` CHANGE `province_status` `province_status` VARCHAR(100) NOT NULL;