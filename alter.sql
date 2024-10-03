-- ---
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

DROP TABLE IF EXISTS `monthly_reports_pages`;

CREATE TABLE `monthly_reports_pages` (
  `mrp_id` INT(11) NOT NULL AUTO_INCREMENT,
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
-- Prasath M 4 June 2021
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

-- Sakthivel P 8 July 2021

INSERT INTO `global_config` (`config_id`, `display_name`, `global_name`, `global_value`) VALUES (NULL, 'Latitude', 'latitude', '11.1271'), (NULL, 'Longitude', 'longitude', '78.6569');

-- Sakthivel P 29 July 2021
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

-- Sakthivel P 04 Aug 2021
ALTER TABLE monthly_reports ADD last_modified_on datetime DEFAULT NULL;

-- Sakthivel P 09 Aug 2021
ALTER TABLE monthly_reports ADD district_id int(11);
ALTER TABLE `monthly_reports` ADD FOREIGN KEY (district_id) REFERENCES `districts` (`district_id`);

-- Sakthivel P 13 Aug 2021
ALTER TABLE monthly_reports ADD tester_name Varchar(100) NULL;

-- Sakthivel P 25 Feb 2022
ALTER TABLE `users` ADD `force_password_reset` INT NULL DEFAULT NULL AFTER `user_status`;

-- Sakthivel P 28 Feb 2022
CREATE TABLE `roles` (
 `role_id` tinyint(11) NOT NULL AUTO_INCREMENT,
 `role_name` varchar(255) DEFAULT NULL,
 `role_code` varchar(255) DEFAULT NULL,
 `role_description` varchar(500) DEFAULT NULL,
 `role_status` varchar(255) NOT NULL DEFAULT 'active',
 PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

ALTER TABLE `users` ADD `role_id` INT(11) NOT NULL AFTER `phone`;

CREATE TABLE `resources` (
 `resource_id` varchar(255) NOT NULL,
 `display_name` varchar(255) DEFAULT NULL,
 `status` varchar(255) DEFAULT NULL,
 PRIMARY KEY (`resource_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `privileges` (
 `resource_id` varchar(255) NOT NULL,
 `privilege_name` varchar(255) NOT NULL,
 `display_name` varchar(255) DEFAULT NULL,
 PRIMARY KEY (`resource_id`,`privilege_name`),
 CONSTRAINT `privileges_ibfk_1` FOREIGN KEY (`resource_id`) REFERENCES `resources` (`resource_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `resources` (`resource_id`, `display_name`, `status`) VALUES ('App\\Http\\Controllers\\Roles\\RolesController', 'Roles', 'active');
INSERT INTO `privileges` (`resource_id`, `privilege_name`, `display_name`) VALUES ('App\\Http\\Controllers\\Roles\\RolesController', 'add', 'Add'), ('App\\Http\\Controllers\\Roles\\RolesController', 'edit', 'Edit');
INSERT INTO `privileges` (`resource_id`, `privilege_name`, `display_name`) VALUES ('App\\Http\\Controllers\\Roles\\RolesController', 'index', 'Access');

-- Sakthivel P 01 Mar 2022

INSERT INTO `resources` (`resource_id`, `display_name`, `status`) VALUES ('App\\Http\\Controllers\\User\\UserController', 'User', 'active'), ('App\\Http\\Controllers\\TestSite\\TestSiteController', 'TestSite', 'active'), ('App\\Http\\Controllers\\TestKit\\TestKitController', 'TestKit', 'active'),('App\\Http\\Controllers\\Facility\\FacilityController', 'Facility', 'active'), ('App\\Http\\Controllers\\Province\\ProvinceController', 'Province', 'active'), ('App\\Http\\Controllers\\District\\DistrictController', 'District', 'active'),('App\\Http\\Controllers\\SiteType\\SiteTypeController', 'SiteType', 'active'),('App\\Http\\Controllers\\GlobalConfig\\GlobalConfigController', 'GlobalConfig', 'active'),('App\\Http\\Controllers\\AllowedTestKit\\AllowedTestKitController', 'AllowedTestKit', 'active'),('App\\Http\\Controllers\\MonthlyReport\\MonthlyReportController', 'MonthlyReport', 'active'),('App\\Http\\Controllers\\Report\\ReportController', 'Report', 'active'),('App\\Http\\Controllers\\Dashboard\\DashboardController', 'Dashboard', 'active');
INSERT INTO `privileges` (`resource_id`, `privilege_name`, `display_name`) VALUES ('App\\Http\\Controllers\\User\\UserController', 'add', 'Add'),('App\\Http\\Controllers\\User\\UserController', 'edit', 'Edit'),('App\\Http\\Controllers\\User\\UserController', 'index', 'Access'),('App\\Http\\Controllers\\TestSite\\TestSiteController', 'add', 'Add'),('App\\Http\\Controllers\\TestSite\\TestSiteController', 'edit', 'Edit'),('App\\Http\\Controllers\\TestSite\\TestSiteController', 'index', 'Access'),('App\\Http\\Controllers\\TestKit\\TestKitController', 'add', 'Add'),('App\\Http\\Controllers\\TestKit\\TestKitController', 'edit', 'Edit'),('App\\Http\\Controllers\\TestKit\\TestKitController', 'index', 'Access'),('App\\Http\\Controllers\\Facility\\FacilityController', 'add', 'Add'), ('App\\Http\\Controllers\\Facility\\FacilityController', 'edit', 'Edit'),('App\\Http\\Controllers\\Facility\\FacilityController', 'index', 'Access'),('App\\Http\\Controllers\\Province\\ProvinceController', 'add', 'Add'), ('App\\Http\\Controllers\\Province\\ProvinceController', 'edit', 'Edit'),('App\\Http\\Controllers\\Province\\ProvinceController', 'index', 'Access'),('App\\Http\\Controllers\\District\\DistrictController', 'add', 'Add'), ('App\\Http\\Controllers\\District\\DistrictController', 'edit', 'Edit'),('App\\Http\\Controllers\\District\\DistrictController', 'index', 'Access'),('App\\Http\\Controllers\\SiteType\\SiteTypeController', 'add', 'Add'), ('App\\Http\\Controllers\\SiteType\\SiteTypeController', 'edit', 'Edit'),('App\\Http\\Controllers\\SiteType\\SiteTypeController', 'index', 'Access'),('App\\Http\\Controllers\\GlobalConfig\\GlobalConfigController', 'edit', 'Edit'),('App\\Http\\Controllers\\GlobalConfig\\GlobalConfigController', 'index', 'Access'),('App\\Http\\Controllers\\AllowedTestKit\\AllowedTestKitController', 'add', 'Add'), ('App\\Http\\Controllers\\AllowedTestKit\\AllowedTestKitController', 'edit', 'Edit'),('App\\Http\\Controllers\\AllowedTestKit\\AllowedTestKitController', 'index', 'Access'),('App\\Http\\Controllers\\MonthlyReport\\MonthlyReportController', 'add', 'Add'),('App\\Http\\Controllers\\MonthlyReport\\MonthlyReportController', 'edit', 'Edit'),('App\\Http\\Controllers\\MonthlyReport\\MonthlyReportController', 'index', 'Access'),('App\\Http\\Controllers\\MonthlyReport\\MonthlyReportController', 'bulk', 'Bulk Upload'),('App\\Http\\Controllers\\Report\\ReportController', 'trendreport', 'Trend Report'),('App\\Http\\Controllers\\Report\\ReportController', 'logbookreport', 'Logbook Report'),('App\\Http\\Controllers\\Report\\ReportController', 'testkitreport', 'Test Kit Report'),('App\\Http\\Controllers\\Report\\ReportController', 'invalidresultreport', 'Invalid Result Report'),('App\\Http\\Controllers\\Report\\ReportController', 'customreport', 'Custom Report'),('App\\Http\\Controllers\\Report\\ReportController', 'trendexport', 'Trend Export'),('App\\Http\\Controllers\\Report\\ReportController', 'logbookexport', 'Logbook Export'),('App\\Http\\Controllers\\Report\\ReportController', 'testkitexport', 'Test Kit Export'),('App\\Http\\Controllers\\Report\\ReportController', 'invalidresultexport', 'Invalid Result Export'),('App\\Http\\Controllers\\Report\\ReportController', 'customexport', 'Custom Export'),('App\\Http\\Controllers\\User\\UserController', 'profile', 'Profile'),('App\\Http\\Controllers\\Dashboard\\DashboardController', 'index', 'Access');

--ilahir 11-May-2022
CREATE TABLE `not_uploaded_monthly_reports` (
  `nu_mr_id` int(11) NOT NULL,
  `test_site_name` varchar(255) DEFAULT NULL,
  `site_type` varchar(255) DEFAULT NULL,
  `facility` varchar(255) DEFAULT NULL,
  `province_name` varchar(255) DEFAULT NULL,
  `site_manager` varchar(255) DEFAULT NULL,
  `site_unique_id` varchar(255) DEFAULT NULL,
  `tester_name` varchar(255) DEFAULT NULL,
  `is_flc` varchar(255) DEFAULT NULL,
  `is_recency` varchar(255) DEFAULT NULL,
  `contact_no` varchar(255) DEFAULT NULL,
  `algorithm_type` varchar(255) DEFAULT NULL,
  `date_of_data_collection` varchar(255) DEFAULT NULL,
  `reporting_month` varchar(255) DEFAULT NULL,
  `book_no` varchar(255) DEFAULT NULL,
  `name_of_data_collector` varchar(255) DEFAULT NULL,
  `source` varchar(100) DEFAULT NULL,
  `page_no` varchar(255) DEFAULT NULL,
  `start_test_date` varchar(255) DEFAULT NULL,
  `end_test_date` varchar(255) DEFAULT NULL,
  `test_kit_name1` varchar(255) DEFAULT NULL,
  `lot_no_1` varchar(255) DEFAULT NULL,
  `expiry_date_1` varchar(255) DEFAULT NULL,
  `test_1_reactive` varchar(255) DEFAULT NULL,
  `test_1_non_reactive` varchar(255) DEFAULT NULL,
  `test_1_invalid` varchar(255) DEFAULT NULL,
  `test_kit_name2` varchar(255) DEFAULT NULL,
  `lot_no_2` varchar(255) DEFAULT NULL,
  `expiry_date_2` varchar(255) DEFAULT NULL,
  `test_2_reactive` varchar(255) DEFAULT NULL,
  `test_2_non_reactive` varchar(255) DEFAULT NULL,
  `test_2_invalid` varchar(255) DEFAULT NULL,
  `test_kit_name3` varchar(255) DEFAULT NULL,
  `lot_no_3` varchar(255) DEFAULT NULL,
  `expiry_date_3` varchar(255) DEFAULT NULL,
  `test_3_reactive` varchar(255) DEFAULT NULL,
  `test_3_non_reactive` varchar(255) DEFAULT NULL,
  `test_3_invalid` varchar(255) DEFAULT NULL,
  `test_kit_name4` varchar(255) DEFAULT NULL,
  `lot_no_4` varchar(255) DEFAULT NULL,
  `expiry_date_4` varchar(255) DEFAULT NULL,
  `test_4_reactive` varchar(255) DEFAULT NULL,
  `test_4_non_reactive` varchar(255) DEFAULT NULL,
  `test_4_invalid` varchar(255) DEFAULT NULL,
  `final_positive` varchar(255) DEFAULT NULL,
  `final_negative` varchar(255) DEFAULT NULL,
  `final_undetermined` varchar(255) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `added_on` datetime DEFAULT NULL,
  `added_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

ALTER TABLE `not_uploaded_monthly_reports`
  ADD PRIMARY KEY (`nu_mr_id`);

ALTER TABLE `not_uploaded_monthly_reports`
  MODIFY `nu_mr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

INSERT INTO `privileges` (`resource_id`, `privilege_name`, `display_name`) VALUES ('App\\Http\\Controllers\\MonthlyReport\\MonthlyReportController', 'notUpload', 'Not Upload Data');

INSERT INTO `privileges` (`resource_id`, `privilege_name`, `display_name`) VALUES ('Application\\\\Controller\\\\AuditTrail', 'index', 'Audit Trail');

INSERT INTO `resources` (`resource_id`, `display_name`) VALUES ('Application\\Controller\\AuditTrail', 'Audit Trail');
-- Sijulda 128-Mar-2023
CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `password_resets`
  ADD KEY `email` (`email`);

-- Sijulda 25-Apr-2023
ALTER TABLE `not_uploaded_monthly_reports`
  ADD `comment` varchar(255) DEFAULT NULL;

-- Sijulda 04-May-2023
ALTER TABLE `not_uploaded_monthly_reports`
  ADD `status` bit(10);

-- Sijulda 04-May-2023
ALTER TABLE `monthly_reports_pages`
ADD `created_by` INT NULL DEFAULT NULL AFTER `updated_on`;

-- Sijulda 04-May-2023
ALTER TABLE `monthly_reports_pages`
ADD `created_on` DATETIME NULL DEFAULT NULL AFTER `created_by`;

-- Amit 16-May-2023
ALTER TABLE `monthly_reports` ADD `updated_by` INT NULL DEFAULT NULL AFTER `added_on`;

-- Sijulda 16-May-2023
ALTER TABLE `monthly_reports`
ADD `updated_by` VARCHAR(100) NOT NULL AFTER `added_on`;

-- Sijulda 14-July-2023
CREATE TABLE `sub_districts` (
  `sub_district_id` int NOT NULL AUTO_INCREMENT,
  `district_id` int NOT NULL,
  `sub_district_name` varchar(100) NOT NULL,
  PRIMARY KEY (`sub_district_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Sijulda 14-July-2023
INSERT INTO `resources` (`resource_id`, `display_name`, `status`) VALUES ('App\\Http\\Controllers\\SubDistrict\\SubDistrictController', 'SubDistrict', 'active');

-- Sijulda 14-July-2023
INSERT INTO `privileges` (`resource_id`, `privilege_name`, `display_name`) VALUES ('App\\Http\\Controllers\\SubDistrict\\SubDistrictController', 'add', 'Add');
INSERT INTO `privileges` (`resource_id`, `privilege_name`, `display_name`) VALUES ('App\\Http\\Controllers\\SubDistrict\\SubDistrictController', 'edit', 'Edit');
INSERT INTO `privileges` (`resource_id`, `privilege_name`, `display_name`) VALUES ('App\\Http\\Controllers\\SubDistrict\\SubDistrictController', 'index', 'Access');

-- Sijulda 14-july-2023
ALTER TABLE `test_sites` ADD `site_sub_district` INT NOT NULL AFTER `site_district`;
ALTER TABLE `monthly_reports` ADD `sub_district_id` INT NULL DEFAULT NULL AFTER `district_id`;

-- Sijulda 03-August-2023
ALTER TABLE `users` ADD `language` VARCHAR(5) NULL DEFAULT NULL AFTER `role_id`;

-- Sijulda 24-August-2023
INSERT INTO `privileges` (`resource_id`, `privilege_name`, `display_name`) VALUES ('App\\Http\\Controllers\\MonthlyReport\\MonthlyReportController', 'notUpload', 'Not Upload');

-- Sijulda 24-August-2023
INSERT INTO `privileges` (`resource_id`, `privilege_name`, `display_name`) VALUES ('App\\Http\\Controllers\\MonthlyReport\\MonthlyReportController', 'notUploadExport', 'Not Upload Export');

-- Sijulda 11-September-2023
INSERT INTO `privileges` (`resource_id`, `privilege_name`, `display_name`) VALUES ('App\\Http\\Controllers\\User\\UserController', 'userActivityLog', 'User Activity Log');
INSERT INTO `privileges` (`resource_id`, `privilege_name`, `display_name`) VALUES ('App\\Http\\Controllers\\User\\UserController', 'userloginhistory', 'User Login History');

-- Sijulda 14-September-2023
INSERT INTO `privileges` (`resource_id`, `privilege_name`, `display_name`) VALUES ('App\\Http\\Controllers\\Report\\ReportController', 'notreportedsites', 'Not Reported Sites ');
INSERT INTO `privileges` (`resource_id`, `privilege_name`, `display_name`) VALUES ('App\\Http\\Controllers\\Report\\ReportController', 'notreportedsitesexport', 'Not Reported Sites Export');

-- Sijulda 11-December-2023
CREATE TABLE `implementing_partners` (`implementing_partner_id` int NOT NULL AUTO_INCREMENT,`implementing_partner_name` varchar(100) NOT NULL,`implementing_partner_status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'active' COMMENT '1 = Implementing Person is active, 0 deleted but present in database as som',PRIMARY KEY (`implementing_partner_id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci
INSERT INTO `resources` (`resource_id`, `display_name`, `status`) VALUES ('App\\Http\\Controllers\\ImplementingPartners\\ImplementingPartnersController', 'ImplementingPartners', 'active')
INSERT INTO `privileges` (`resource_id`, `privilege_name`, `display_name`) VALUES ('App\\Http\\Controllers\\ImplementingPartners\\ImplementingPartnersController', 'add', 'Add')
INSERT INTO `privileges` (`resource_id`, `privilege_name`, `display_name`) VALUES ('App\\Http\\Controllers\\ImplementingPartners\\ImplementingPartnersController', 'edit', 'Edit')
INSERT INTO `privileges` (`resource_id`, `privilege_name`, `display_name`) VALUES ('App\\Http\\Controllers\\ImplementingPartners\\ImplementingPartnersController', 'index', 'Access')

-- Sijulda 14-December-2023
ALTER TABLE `test_sites` ADD `external_site_id` VARCHAR(100) NOT NULL AFTER `site_id`;
ALTER TABLE `test_sites` ADD `site_type` TEXT NOT NULL AFTER `site_country`;
ALTER TABLE `test_sites` ADD `site_implementing_partner_id` INT NOT NULL AFTER `site_type`;

-- ilahir 15-Dec-2023

INSERT INTO `global_config` (`config_id`, `display_name`, `global_name`, `global_value`) VALUES (NULL, 'Testing Algorithm', 'testing_algorithm', '');
-- Sijulda 18-December- 2023
ALTER TABLE `provinces` ADD `province_external_id` VARCHAR(100) NULL DEFAULT NULL AFTER `province_id`;
ALTER TABLE `sub_districts` ADD `sub_district_external_id` VARCHAR(100) NULL DEFAULT NULL AFTER `sub_district_id`;
ALTER TABLE `districts` ADD `district_external_id` VARCHAR(100) NULL DEFAULT NULL AFTER `district_id`;

-- Sijulda 19-December-2023
ALTER TABLE `districts` ADD `district_status` VARCHAR(100) NOT NULL DEFAULT 'active' AFTER `district_name`;
ALTER TABLE `sub_districts` ADD `sub_district_status` VARCHAR(100) NOT NULL DEFAULT 'active' AFTER `sub_district_name`;

-- ilahir 20-Dec-2023
INSERT INTO `resources` (`resource_id`, `display_name`, `status`) VALUES ('App\\Http\\Controllers\\MonitoringReport\\MonitoringReportController', 'Monitoring Report', 'active');
INSERT INTO `privileges` (`resource_id`, `privilege_name`, `display_name`) VALUES ('App\\Http\\Controllers\\MonitoringReport\\MonitoringReportController', 'sitewisereport', 'Sitewise Report');

-- Sijulda 26-December-2023
ALTER TABLE `test_kits` DROP COLUMN Installation_id;

-- Sijulda 02-January-2024
ALTER TABLE `test_sites` ADD `site_primary_email` VARCHAR(255) NULL DEFAULT NULL AFTER `site_longitude`;
ALTER TABLE `test_sites` ADD `site_secondary_email` VARCHAR(255) NULL DEFAULT NULL AFTER `site_primary_email`;
ALTER TABLE `test_sites` ADD `site_primary_mobile_no` VARCHAR(255) NULL DEFAULT NULL AFTER `site_secondary_email`;
ALTER TABLE `test_sites` ADD `site_secondary_mobile_no` VARCHAR(255) NULL DEFAULT NULL AFTER `site_primary_mobile_no`;

-- ilahir 03-Jan-2024
INSERT INTO `global_config` (`config_id`, `display_name`, `global_name`, `global_value`) VALUES (NULL, 'Disable Inactive User', 'disable_inactive_user', '');
INSERT INTO `global_config` (`config_id`, `display_name`, `global_name`, `global_value`) VALUES (NULL, 'Disable Inactive User No.of Months', 'disable_user_no_of_months', '6');
ALTER TABLE `users` ADD `last_login_datetime` DATETIME NULL DEFAULT NULL AFTER `updated_by`;

-- Sijulda 05-January-2024
DROP TABLE IF EXISTS `audit_monthly_reports`;

CREATE TABLE `audit_monthly_reports` SELECT * from `monthly_reports` WHERE 1=0;

ALTER TABLE `audit_monthly_reports`
   MODIFY COLUMN `mr_id` int(11) NOT NULL,
   ENGINE = MyISAM,
   ADD `action` VARCHAR(8) DEFAULT 'insert' FIRST,
   ADD `revision` INT(6) NOT NULL AUTO_INCREMENT AFTER `action`,
   ADD `dt_datetime` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `revision`,
   ADD PRIMARY KEY (`mr_id`, `revision`);

DROP TRIGGER IF EXISTS monthly_reports_data__ai;
DROP TRIGGER IF EXISTS monthly_reports_data__au;
DROP TRIGGER IF EXISTS monthly_reports_data__bd;

CREATE TRIGGER monthly_reports_data__ai AFTER INSERT ON `monthly_reports` FOR EACH ROW
    INSERT INTO `audit_monthly_reports` SELECT 'insert', NULL, NOW(), d.*
    FROM `monthly_reports` AS d WHERE d.mr_id = NEW.mr_id;

CREATE TRIGGER monthly_reports_data__au AFTER UPDATE ON `monthly_reports` FOR EACH ROW
    INSERT INTO `audit_monthly_reports` SELECT 'update', NULL, NOW(), d.*
    FROM `monthly_reports` AS d WHERE d.mr_id = NEW.mr_id;

CREATE TRIGGER monthly_reports_data__bd BEFORE DELETE ON `monthly_reports` FOR EACH ROW
    INSERT INTO `audit_monthly_reports` SELECT 'delete', NULL, NOW(), d.*
    FROM `monthly_reports` AS d WHERE d.mr_id = OLD.mr_id;

-- ilahir 08-Jan-2024
CREATE TABLE `temp_mail` (
  `temp_id` int NOT NULL,
  `message` mediumtext,
  `from_mail` varchar(255) DEFAULT NULL,
  `to_email` varchar(255) NOT NULL,
  `subject` mediumtext,
  `from_full_name` varchar(255) DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'pending',
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `temp_mail` ADD PRIMARY KEY (`temp_id`);
ALTER TABLE `temp_mail` MODIFY `temp_id` int NOT NULL AUTO_INCREMENT;

-- Sijulda 04-Apr-2024
INSERT INTO `global_config` (`config_id`, `display_name`, `global_name`, `global_value`) VALUES (NULL, 'Sample Collection Past Months Limit', 'sample_collection_past_months_limit', '6');

-- Sijulda 09-Apr-2024
CREATE TABLE `reminder_history` (`history_id` INT NOT NULL AUTO_INCREMENT , `site_id` INT NOT NULL , `reminder_datetime` DATETIME NOT NULL , `reminded_by` INT NOT NULL , PRIMARY KEY (`history_id`)) ENGINE = InnoDB;

-- Sijulda 06-May-2024
CREATE TABLE `users_location_map` (
  `user_id` int(11) NOT NULL,
  `province_id` int(11) NOT NULL,
  `district_id` int(11) DEFAULT NULL,
  UNIQUE KEY `unique_user_province_district` (`user_id`,`province_id`,`district_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Sijulda 10-May-2024
ALTER TABLE `users` ADD `user_mapping` INT NOT NULL DEFAULT '1' AFTER `role_id`;

-- Sakthi 20-june-2024
ALTER TABLE `users` ADD `prefered_language` ENUM('en','fr') NOT NULL DEFAULT 'en' AFTER `user_status`;

-- Sakhti 21-june-2024
INSERT INTO `global_config` (`config_id`, `display_name`, `global_name`, `global_value`) VALUES (NULL, 'Prefered Language', 'en', 'English\r\n');
