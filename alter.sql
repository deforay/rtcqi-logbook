-- ---
-- Globals
-- ---

-- SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
-- SET FOREIGN_KEY_CHECKS=0;

-- ---
-- Table 'monthly_reports'
-- 
-- ---

DROP TABLE IF EXISTS `monthly_reports`;
		
CREATE TABLE `monthly_reports` (
  `mr_id` INT(11) NOT NULL AUTO_INCREMENT,
  `ts_id` INT(11) NOT NULL COMMENT 'Site Name',
  `st_id` INT(11) NOT NULL,
  `site_unique_id` VARCHAR(100) NULL DEFAULT NULL,
  `provincesss_id` INT(11) NOT NULL,
  `site_manager` VARCHAR(100) NULL DEFAULT NULL,
  `is_flc` VARCHAR(10) NOT NULL DEFAULT 'no',
  `is_recency` VARCHAR(20) NOT NULL DEFAULT 'no',
  `contact_no` VARCHAR(100) NULL DEFAULT NULL,
  `latitude` VARCHAR(100) NOT NULL,
  `longitude` VARCHAR(200) NOT NULL,
  `algorithm_type` VARCHAR(255) NULL DEFAULT NULL,
  `date_of_data_collection` DATE NOT NULL,
  `reporting_month` DATE NOT NULL,
  `book_no` INT(10) NOT NULL DEFAULT 0,
  `name_of_data_collector` VARCHAR(100) NULL DEFAULT NULL,
  `signature` MEDIUMTEXT NULL DEFAULT NULL,
  PRIMARY KEY (`mr_id`),
KEY (`ts_id`),
KEY (`provincesss_id`),
KEY (`st_id`)
);

-- ---
-- Table 'provinces'
-- 
-- ---

DROP TABLE IF EXISTS `provinces`;
		
CREATE TABLE `provinces` (
  `provincesss_id` INT(11) NOT NULL AUTO_INCREMENT,
  `province_name` VARCHAR(100) NOT NULL,
  `province_status` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`provincesss_id`)
);

-- ---
-- Table 'districts'
-- 
-- ---

DROP TABLE IF EXISTS `districts`;
		
CREATE TABLE `districts` (
  `district_id` INT(11) NOT NULL AUTO_INCREMENT,
  `provincesss_id` INT(11) NOT NULL,
  `district_name` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`district_id`),
KEY (`provincesss_id`)
);

-- ---
-- Table 'monthly_reports_pages'
-- 
-- ---

DROP TABLE IF EXISTS `monthly_reports_pages`;
		
CREATE TABLE `monthly_reports_pages` (
  `mrp_id` INT(11) NOT NULL,
  `mr_id` INT(11) NOT NULL,
  `page_no` VARCHAR(50) NULL DEFAULT NULL,
  `start_test_date` DATE NULL DEFAULT NULL,
  `end_test_date` DATE NULL DEFAULT NULL,
  `lot_no_1` VARCHAR(200) NULL DEFAULT NULL,
  `expiry_date_1` DATE NULL DEFAULT NULL,
  `test_1_kit_id` INT(11) NULL DEFAULT NULL,
  `test_1_reactive` INT(11) NULL DEFAULT NULL,
  `test_1_nonreactive` INT(11) NULL DEFAULT NULL,
  `test_1_invalid` INT(11) NULL DEFAULT NULL,
  `lot_no_2` VARCHAR(100) NULL DEFAULT NULL,
  `expiry_date_2` DATE NULL DEFAULT NULL,
  `test_2_kit_id` INT(11) NULL DEFAULT NULL,
  `test_2_reactive` INT(11) NULL DEFAULT NULL,
  `test_2_nonreactive` INT(11) NULL DEFAULT NULL,
  `test_2_invalid` INT(11) NULL DEFAULT NULL,
  `test_3_kit_id` INT(11) NULL DEFAULT NULL,
  `lot_no_3` VARCHAR(200) NULL DEFAULT NULL,
  `expiry_date_3` DATE NULL DEFAULT NULL,
  `test_3_reactive` INT(11) NULL DEFAULT NULL,
  `test_3_nonreactive` INT(11) NULL DEFAULT NULL,
  `test_3_invalid` INT(11) NULL DEFAULT NULL,
  `lot_no_4` VARCHAR(200) NULL DEFAULT NULL,
  `expiry_date_4` DATE NULL DEFAULT NULL,
  `test_4_kit_id` INT(11) NULL DEFAULT NULL,
  `test_4_reactive` INT(11) NULL DEFAULT NULL,
  `test_4_nonreactive` INT(11) NULL DEFAULT NULL,
  `test_4_invalid` INT(11) NULL DEFAULT NULL,
  `final_positive` INT(11) NULL DEFAULT NULL,
  `final_negative` INT(11) NULL DEFAULT NULL,
  `final_undetermined` INT(11) NULL DEFAULT NULL,
  `total_high_vl` VARCHAR(200) NULL DEFAULT NULL,
  `low_vl` VARCHAR(200) NULL DEFAULT NULL,
  `total_vl_not_reported` VARCHAR(200) NULL DEFAULT NULL,
  `recency_total_recent` VARCHAR(200) NULL DEFAULT NULL,
  `recency_total_negative` VARCHAR(100) NULL DEFAULT NULL,
  `recency_total_inconclusive` VARCHAR(200) NULL DEFAULT NULL,
  `recency_total_longterm` VARCHAR(200) NULL DEFAULT NULL,
  `positive_percentage` INT(11) NULL DEFAULT NULL,
  `positive_agreement` VARCHAR(11) NULL DEFAULT NULL,
  `overall_agreement` VARCHAR(200) NULL DEFAULT NULL,
  `updated_by` INT(11) NULL DEFAULT NULL,
  `updated_on` DATETIME NULL DEFAULT NULL,
KEY (`updated_by`),
  PRIMARY KEY (`mrp_id`),
KEY (`page_no`),
KEY (`mr_id`),
KEY (`test_3_invalid`)
);

-- ---
-- Table 'site_types'
-- 
-- ---

DROP TABLE IF EXISTS `site_types`;
		
CREATE TABLE `site_types` (
  `st_id` INT(10) NOT NULL AUTO_INCREMENT,
  `site_type_name` VARCHAR(100) NOT NULL,
  `site_type_status` VARCHAR(10) NOT NULL DEFAULT 'active',
  PRIMARY KEY (`st_id`)
);

-- ---
-- Table 'test_sites'
-- 
-- ---

DROP TABLE IF EXISTS `test_sites`;
		
CREATE TABLE `test_sites` (
  `ts_id` INT(11) NOT NULL AUTO_INCREMENT,
  `site_id` VARCHAR(100) NULL DEFAULT NULL,
  `site_name` VARCHAR(50) NULL DEFAULT NULL,
  `site_latitude` VARCHAR(100) NULL DEFAULT NULL,
  `site_longitude` VARCHAR(100) NULL DEFAULT NULL,
  `site_address1` VARCHAR(50) NULL DEFAULT NULL,
  `site_address2` VARCHAR(50) NULL DEFAULT NULL,
  `site_postal_code` VARCHAR(20) NULL DEFAULT NULL,
  `site_city` VARCHAR(20) NULL DEFAULT NULL,
  `site_state` VARCHAR(20) NULL DEFAULT NULL,
  `site_country` VARCHAR(20) NULL DEFAULT NULL,
  `updated_by` INT(11) NOT NULL,
  `updated_on` DATETIME NULL DEFAULT NULL,
  `test_site_status` VARCHAR(10) NULL DEFAULT 'active' COMMENT '1 = Site is active, 0 deleted but present in database as som',
  `created_on` DATE NULL DEFAULT NULL,
  `created_by` INT(11) NOT NULL,
  `new field` INT(11) NULL DEFAULT NULL,
  UNIQUE KEY (`ts_id`),
  PRIMARY KEY (`ts_id`),
KEY (`site_postal_code`)
);

-- ---
-- Table 'users'
-- 
-- ---

DROP TABLE IF EXISTS `users`;
		
CREATE TABLE `users` (
  `user_id` INT(11) NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(255) NULL DEFAULT NULL,
  `last_name` VARCHAR(255) NULL DEFAULT NULL,
  `password` VARCHAR(255) NULL DEFAULT NULL,
  `email` VARCHAR(255) NULL DEFAULT NULL,
  `phone` VARCHAR(255) NULL DEFAULT NULL,
  `user_status` VARCHAR(255) NULL DEFAULT 'active',
  `created_on` DATETIME NULL DEFAULT NULL,
  `updated_on` DATETIME NULL DEFAULT NULL,
  `created_by` INT(11) NULL DEFAULT NULL,
  `updated_by` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`)
);

-- ---
-- Table 'users_facility_map'
-- 
-- ---
-- Sakthivel P 3 June 2021

DROP TABLE IF EXISTS `users_facility_map`;
		
CREATE TABLE `users_facility_map` ( 
  `ufm_id` INT(11) NOT NULL AUTO_INCREMENT,
 `user_id` INT(11) NOT NULL, 
 `ts_id` INT(11) NOT NULL, KEY (`user_id`), 
 PRIMARY KEY (`ufm_id`) );

-- ---
-- Table 'facilities'
-- 
-- ---

DROP TABLE IF EXISTS `facilities`;
		
CREATE TABLE `facilities` (
  `facility_id` INT(11) NOT NULL AUTO_INCREMENT,
  `facility_name` VARCHAR(50) NULL DEFAULT NULL,
  `facility_latitude` VARCHAR(50) NULL DEFAULT NULL,
  `facility_longitude` VARCHAR(50) NULL DEFAULT NULL,
  `facility_address1` VARCHAR(255) NULL DEFAULT NULL,
  `facility_address2` VARCHAR(50) NULL DEFAULT NULL,
  `facility_city` VARCHAR(20) NULL DEFAULT NULL,
  `facility_state` VARCHAR(20) NULL DEFAULT NULL,
  `facility_postal_code` VARCHAR(20) NULL DEFAULT NULL,
  `facility_country` VARCHAR(20) NULL DEFAULT NULL,
  `facility_region` VARCHAR(20) NULL DEFAULT NULL,
  `contact_name` VARCHAR(50) NULL DEFAULT NULL,
  `contact_email` VARCHAR(20) NULL DEFAULT NULL,
  `contact_phoneno` VARCHAR(20) NULL DEFAULT NULL,
  `facility_status` VARCHAR(20) NOT NULL DEFAULT 'active' COMMENT '1 = Site is active, 0 deleted but present in database as som',
  `updated_on` DATETIME NULL DEFAULT NULL,
  `updated_by` INT(11) NULL DEFAULT NULL,
  `created_on` DATETIME NOT NULL,
  `created_by` INT(11) NOT NULL,
  PRIMARY KEY (`facility_id`)
);

-- ---
-- Table 'test_kits'
-- 
-- ---

DROP TABLE IF EXISTS `test_kits`;
		
CREATE TABLE `test_kits` (
  `tk_id` INT(11) NOT NULL AUTO_INCREMENT,
  `test_kit_name_id` VARCHAR(50) NULL DEFAULT NULL,
  `test_kit_name_id_1` VARCHAR(50) NOT NULL,
  `test_kit_name_short` VARCHAR(100) NULL DEFAULT NULL,
  `test_kit_name` VARCHAR(100) NOT NULL,
  `test_kit_comments` VARCHAR(50) NULL DEFAULT NULL,
  `test_kit_manufacturer` VARCHAR(100) NOT NULL,
  `test_kit_expiry_date` DATE NULL DEFAULT NULL,
  `Installation_id` VARCHAR(50) NULL DEFAULT NULL,
  `test_kit_status` VARCHAR(100) NOT NULL DEFAULT 'active',
  `updated_on` DATETIME NULL DEFAULT NULL,
  `updated_by` INT(11) NULL DEFAULT NULL,
  `created_on` DATE NOT NULL,
  `created_by` INT(11) NOT NULL,
KEY (`Installation_id`),
  PRIMARY KEY (`tk_id`)
);

-- ---
-- Table 'global_config'
-- 
-- ---

DROP TABLE IF EXISTS `global_config`;
		
CREATE TABLE `global_config` (
  `config_id` INT(11) NOT NULL AUTO_INCREMENT,
  `display_name` VARCHAR(200) NOT NULL,
  `global_name` VARCHAR(200) NOT NULL,
  `global_value` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`config_id`)
);

-- ---
-- Table 'allowed_testkits'
-- 
-- ---

DROP TABLE IF EXISTS `allowed_testkits`;
		
CREATE TABLE `allowed_testkits` (
  `test_kit_no` INT(11) NOT NULL,
  `testkit_id` INT(11) NOT NULL,
  PRIMARY KEY (`test_kit_no`, `testkit_id`)
);

-- ---
-- Foreign Keys 
-- ---

ALTER TABLE `monthly_reports` ADD FOREIGN KEY (ts_id) REFERENCES `test_sites` (`ts_id`);
ALTER TABLE `monthly_reports` ADD FOREIGN KEY (st_id) REFERENCES `site_types` (`st_id`);
ALTER TABLE `monthly_reports` ADD FOREIGN KEY (provincesss_id) REFERENCES `provinces` (`provincesss_id`);
ALTER TABLE `districts` ADD FOREIGN KEY (provincesss_id) REFERENCES `provinces` (`provincesss_id`);
ALTER TABLE `districts` ADD FOREIGN KEY (provincesss_id) REFERENCES `provinces` (`provincesss_id`);
ALTER TABLE `monthly_reports_pages` ADD FOREIGN KEY (mr_id) REFERENCES `monthly_reports` (`mr_id`);
ALTER TABLE `users_facility_map` ADD FOREIGN KEY (user_id) REFERENCES `users` (`user_id`);
-- Sakthivel P 3 June 2021
ALTER TABLE `users_facility_map` ADD FOREIGN KEY (ts_id) REFERENCES `test_sites` (`ts_id`);
ALTER TABLE `allowed_testkits` ADD FOREIGN KEY (testkit_id) REFERENCES `test_kits` (`tk_id`);

-- ---
-- Table Properties
-- ---

-- ALTER TABLE `monthly_reports` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `provinces` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `districts` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `monthly_reports_pages` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `site_types` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `test_sites` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `users` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `users_facility_map` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `facilities` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `test_kits` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `global_config` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `allowed_testkits` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ---
-- Test Data
-- ---

-- INSERT INTO `monthly_reports` (`mr_id`,`ts_id`,`st_id`,`site_unique_id`,`provincesss_id`,`site_manager`,`is_flc`,`is_recency`,`contact_no`,`latitude`,`longitude`,`algorithm_type`,`date_of_data_collection`,`reporting_month`,`book_no`,`name_of_data_collector`,`signature`) VALUES
-- ('','','','','','','','','','','','','','','','','');
-- INSERT INTO `provinces` (`provincesss_id`,`province_name`,`province_status`) VALUES
-- ('','','');
-- INSERT INTO `districts` (`district_id`,`provincesss_id`,`district_name`) VALUES
-- ('','','');
-- INSERT INTO `monthly_reports_pages` (`mrp_id`,`mr_id`,`page_no`,`start_test_date`,`end_test_date`,`lot_no_1`,`expiry_date_1`,`test_1_kit_id`,`test_1_reactive`,`test_1_nonreactive`,`test_1_invalid`,`lot_no_2`,`expiry_date_2`,`test_2_kit_id`,`test_2_reactive`,`test_2_nonreactive`,`test_2_invalid`,`test_3_kit_id`,`lot_no_3`,`expiry_date_3`,`test_3_reactive`,`test_3_nonreactive`,`test_3_invalid`,`lot_no_4`,`expiry_date_4`,`test_4_kit_id`,`test_4_reactive`,`test_4_nonreactive`,`test_4_invalid`,`final_positive`,`final_negative`,`final_undetermined`,`total_high_vl`,`low_vl`,`total_vl_not_reported`,`recency_total_recent`,`recency_total_negative`,`recency_total_inconclusive`,`recency_total_longterm`,`positive_percentage`,`positive_agreement`,`overall_agreement`,`updated_by`,`updated_on`) VALUES
-- ('','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','');
-- INSERT INTO `site_types` (`st_id`,`site_type_name`,`site_type_status`) VALUES
-- ('','','');
-- INSERT INTO `test_sites` (`ts_id`,`site_id`,`site_name`,`site_latitude`,`site_longitude`,`site_address1`,`site_address2`,`site_postal_code`,`site_city`,`site_state`,`site_country`,`updated_by`,`updated_on`,`test_site_status`,`created_on`,`created_by`,`new field`) VALUES
-- ('','','','','','','','','','','','','','','','','');
-- INSERT INTO `users` (`user_id`,`first_name`,`last_name`,`password`,`email`,`phone`,`user_status`,`created_on`,`updated_on`,`created_by`,`updated_by`) VALUES
-- ('','','','','','','','','','','');
-- INSERT INTO `users_facility_map` (`ufm_id`,`user_id`,`facility_id`) VALUES
-- ('','','');
-- INSERT INTO `facilities` (`facility_id`,`facility_name`,`facility_latitude`,`facility_longitude`,`facility_address1`,`facility_address2`,`facility_city`,`facility_state`,`facility_postal_code`,`facility_country`,`facility_region`,`contact_name`,`contact_email`,`contact_phoneno`,`facility_status`,`updated_on`,`updated_by`,`created_on`,`created_by`) VALUES
-- ('','','','','','','','','','','','','','','','','','','');
-- INSERT INTO `test_kits` (`tk_id`,`test_kit_name_id`,`test_kit_name_id_1`,`test_kit_name_short`,`test_kit_name`,`test_kit_comments`,`test_kit_manufacturer`,`test_kit_expiry_date`,`Installation_id`,`test_kit_status`,`updated_on`,`updated_by`,`created_on`,`created_by`) VALUES
-- ('','','','','','','','','','','','','','');
-- INSERT INTO `global_config` (`config_id`,`display_name`,`global_name`,`global_value`) VALUES
-- ('','','','');
-- INSERT INTO `allowed_testkits` (`test_kit_no`,`testkit_id`) VALUES
-- ('','');


-- Sakthivel P 3 June 2021
ALTER TABLE test_sites ADD facility_id int(11);
ALTER TABLE `test_sites` ADD FOREIGN KEY (facility_id) REFERENCES `facilities` (`facility_id`);

-- Sakthivel P 4 June 2021
ALTER TABLE users_facility_map
  RENAME TO users_testsite_map;
--Prasath M 4 June 2021
INSERT INTO `global_config` (`config_id`, `display_name`, `global_name`, `global_value`) VALUES
(1, 'Instance Name', 'instance_name', 'Test'),
(2, 'Institute/Organization Name', 'institute_name', 'Test org'),
(3, 'Administrator Name', 'admin_name', 'Deforay'),
(4, 'Administrator Email', 'admin_email', 'admin@gmail.com'),
(5, 'Administrator Phone', 'admin_phone', '8798798789'),
(6, 'Recency Tests', 'recency_test', 'disabled'),
(7, 'Number of Tests', 'no_of_test', '3'),
(8, 'Logo', 'logo', ''),
(9, 'RTCQI LOGBOOK', 'title_name', '');



ALTER TABLE monthly_reports ADD source Varchar(100) NULL;
ALTER TABLE monthly_reports ADD added_by Varchar(100) NULL;
ALTER TABLE monthly_reports ADD added_on DATE NULL;
ALTER TABLE `monthly_reports` CHANGE `reporting_month` `reporting_month` VARCHAR(100) NOT NULL;   

-- Sakthivel P 5 July 2021
ALTER TABLE test_sites ADD provincesss_id int(11);
ALTER TABLE `test_sites` ADD FOREIGN KEY (provincesss_id) REFERENCES `provinces` (`provincesss_id`);

-- Sakthivel P 5 July 2021
ALTER TABLE test_sites ADD district_id int(11);
ALTER TABLE `test_sites` ADD FOREIGN KEY (district_id) REFERENCES `districts` (`district_id`);


ALTER TABLE facilities ADD provincesss_id int(11);
ALTER TABLE `facilities` ADD FOREIGN KEY (provincesss_id) REFERENCES `provinces` (`provincesss_id`);

ALTER TABLE facilities ADD district_id int(11);
ALTER TABLE `facilities` ADD FOREIGN KEY (district_id) REFERENCES `districts` (`district_id`);

--Sakthivel P 8 July 2021

INSERT INTO `global_config` (`config_id`, `display_name`, `global_name`, `global_value`) VALUES (NULL, 'Latitude', 'latitude', '11.1271'), (NULL, 'Longitude', 'longitude', '78.6569');

--Sakthivel P 29 July 2021
CREATE TABLE `track` (
`log_id` int NOT NULL ,
`event_type` TEXT DEFAULT NULL,
`action` mediumtext,
`resource` TEXT DEFAULT NULL,
`date_time` datetime DEFAULT NULL,
`ip_address` TEXT DEFAULT NULL,
PRIMARY KEY (`log_id`)
);
ALTER TABLE `track` CHANGE `log_id` `log_id` INT(11) NOT NULL AUTO_INCREMENT;

--Sakthivel P 04 Aug 2021
ALTER TABLE monthly_reports ADD last_modified_on datetime DEFAULT NULL;
