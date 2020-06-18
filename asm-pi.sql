-- ---
-- Globals
-- ---

-- SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
-- SET FOREIGN_KEY_CHECKS=0;

-- ---
-- Table 'users'
-- 
-- ---

DROP TABLE IF EXISTS `users`;
		
CREATE TABLE `users` (
  `user_id` INTEGER NOT NULL AUTO_INCREMENT ,
  `first_name` VARCHAR(255) NULL DEFAULT NULL,
  `last_name` VARCHAR(255) NULL DEFAULT NULL,
  `role` INTEGER NULL DEFAULT NULL,
  `login_id` VARCHAR(255) NULL DEFAULT NULL,
  `password` VARCHAR(255) NULL DEFAULT NULL,
  `email` VARCHAR(255) NULL DEFAULT NULL,
  `phone` VARCHAR(255) NULL DEFAULT NULL,
  `status` VARCHAR(255) NULL DEFAULT 'inactive',
  PRIMARY KEY (`user_id`)
);

-- ---
-- Table 'roles'
-- 
-- ---

DROP TABLE IF EXISTS `roles`;
		
CREATE TABLE `roles` (
  `role_id` INTEGER NOT NULL AUTO_INCREMENT,
  `role_name` VARCHAR(255) NOT NULL DEFAULT 'NULL',
  `role_code` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`role_id`)
);

-- ---
-- Table 'vendors'
-- 
-- ---

DROP TABLE IF EXISTS `vendors`;
		
CREATE TABLE `vendors` (
  `vendor_id` INTEGER NOT NULL AUTO_INCREMENT,
  `vendor_name` VARCHAR(255) NULL DEFAULT NULL,
  `vendor_code` VARCHAR(255) NULL DEFAULT NULL,
  `vendor_type` INTEGER NOT NULL,
  `registered_on` DATE NULL DEFAULT NULL,
  `address_line_1` VARCHAR(255) NULL DEFAULT NULL,
  `address_line_2` VARCHAR(255) NULL DEFAULT NULL,
  `city` VARCHAR(255) NULL DEFAULT NULL,
  `state` VARCHAR(255) NULL DEFAULT NULL,
  `pincode` VARCHAR(255) NULL DEFAULT NULL,
  `country` INTEGER NOT NULL,
  `email` VARCHAR(255) NULL DEFAULT NULL,
  `alt_email` VARCHAR(255) NULL DEFAULT NULL,
  `phone` VARCHAR(255) NULL DEFAULT NULL,
  `alt_phone` VARCHAR(255) NULL DEFAULT NULL,
  `status` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`vendor_id`)
);

-- ---
-- Table 'items'
-- 
-- ---

DROP TABLE IF EXISTS `items`;
		
CREATE TABLE `items` (
  `item_id` INTEGER NOT NULL AUTO_INCREMENT,
  `item_code` VARCHAR(255) NOT NULL,
  `item_name` VARCHAR(255) NULL DEFAULT NULL,
  `item_type` INTEGER NOT NULL,
  `brand` INTEGER NOT NULL,
  `latest_price` DECIMAL(10,2) NULL DEFAULT NULL,
  `stockable` VARCHAR(255) NOT NULL DEFAULT 'yes',
  `base_unit` INTEGER NOT NULL,
  UNIQUE KEY (`item_id`, `item_code`),
  UNIQUE KEY (`item_code`)
);

-- ---
-- Table 'branch_types'
-- 
-- ---

DROP TABLE IF EXISTS `branch_types`;
		
CREATE TABLE `branch_types` (
  `branch_type_id` INTEGER NOT NULL AUTO_INCREMENT,
  `branch_type` VARCHAR(255) NOT NULL,
  `status` VARCHAR(255) NULL DEFAULT 'active',
  PRIMARY KEY (`branch_type_id`)
);

-- ---
-- Table 'branches'
-- 
-- ---

DROP TABLE IF EXISTS `branches`;
		
CREATE TABLE `branches` (
  `branch_id` INTEGER NOT NULL AUTO_INCREMENT,
  `branch_type` INTEGER NOT NULL,
  `branch_name` VARCHAR(255) NULL DEFAULT NULL,
  `email` VARCHAR(255) NULL DEFAULT NULL,
  `phone` VARCHAR(255) NULL DEFAULT NULL,
  `address_line_1` VARCHAR(255) NULL DEFAULT NULL,
  `address_line_2` VARCHAR(255) NULL DEFAULT NULL,
  `city` VARCHAR(255) NULL DEFAULT NULL,
  `state` VARCHAR(255) NULL DEFAULT NULL,
  `country` INTEGER NOT NULL,
  `pincode` VARCHAR(255) NULL DEFAULT NULL,
  `status` VARCHAR(255) NULL DEFAULT 'active',
  PRIMARY KEY (`branch_id`)
);

-- ---
-- Table 'user_branch_map'
-- 
-- ---

DROP TABLE IF EXISTS `user_branch_map`;
		
CREATE TABLE `user_branch_map` (
  `user_id` INTEGER NOT NULL,
  `branch_id` INTEGER NOT NULL,
  PRIMARY KEY (`user_id`, `branch_id`)
);

-- ---
-- Table 'vendor_types'
-- 
-- ---

DROP TABLE IF EXISTS `vendor_types`;
		
CREATE TABLE `vendor_types` (
  `vendor_type_id` INTEGER NOT NULL AUTO_INCREMENT,
  `vendor_type` VARCHAR(255) NULL DEFAULT NULL,
  `status` VARCHAR(255) NULL DEFAULT 'active',
  PRIMARY KEY (`vendor_type_id`)
);

-- ---
-- Table 'countries'
-- 
-- ---

DROP TABLE IF EXISTS `countries`;
		
CREATE TABLE `countries` (
  `country_id` INTEGER NOT NULL AUTO_INCREMENT,
  `country_name` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`country_id`)
);

-- ---
-- Table 'units_of_measure'
-- 
-- ---

DROP TABLE IF EXISTS `units_of_measure`;
		
CREATE TABLE `units_of_measure` (
  `uom_id` INTEGER NOT NULL AUTO_INCREMENT,
  `unit_name` VARCHAR(255) NULL DEFAULT NULL,
  `status` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`uom_id`)
);

-- ---
-- Table 'uom_conversion'
-- // 24 pencils in a box

conversion_id | base_unit | multiplier | to_unit
1 | 1 | 24 | 2 
-- ---

DROP TABLE IF EXISTS `uom_conversion`;
		
CREATE TABLE `uom_conversion` (
  `conversion_id` INTEGER NOT NULL AUTO_INCREMENT,
  `base_unit` INTEGER NOT NULL,
  `multiplier` DECIMAL(6,2) NOT NULL DEFAULT 1,
  `to_unit` INTEGER NOT NULL,
  PRIMARY KEY (`conversion_id`)
) COMMENT '// 24 pencils in a box

conversion_id | base_unit | multipli';

-- ---
-- Table 'inventories'
-- 
-- ---

DROP TABLE IF EXISTS `inventories`;
		
CREATE TABLE `inventories` (
  `inventory_id` INTEGER NOT NULL AUTO_INCREMENT,
  `item` INTEGER NOT NULL,
  `uom` INTEGER NOT NULL,
  `quantity` DECIMAL(10,2) NULL DEFAULT NULL,
  `branch` INTEGER NULL DEFAULT NULL,
  `last_updated_on` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`inventory_id`)
);

-- ---
-- Table 'item_categories'
-- 
-- ---

DROP TABLE IF EXISTS `item_categories`;
		
CREATE TABLE `item_categories` (
  `item_category_id` INTEGER NOT NULL AUTO_INCREMENT,
  `item_category` VARCHAR(255) NOT NULL,
  `status` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`item_category_id`)
);

-- ---
-- Table 'item_types'
-- 
-- ---

DROP TABLE IF EXISTS `item_types`;
		
CREATE TABLE `item_types` (
  `item_type_id` INTEGER NOT NULL AUTO_INCREMENT,
  `item_type` VARCHAR(255) NOT NULL,
  `item_category` INTEGER NOT NULL,
  `status` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`item_type_id`)
);

-- ---
-- Table 'brands'
-- 
-- ---

DROP TABLE IF EXISTS `brands`;
		
CREATE TABLE `brands` (
  `brand_id` INTEGER NOT NULL AUTO_INCREMENT,
  `brand_name` VARCHAR(255) NULL DEFAULT NULL,
  `manufaturer_name` VARCHAR(255) NULL DEFAULT NULL,
  `status` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`brand_id`)
);

-- ---
-- Table 'item_price_records'
-- 
-- ---

DROP TABLE IF EXISTS `item_price_records`;
		
CREATE TABLE `item_price_records` (
  `item_id` INTEGER NOT NULL,
  `purchase_date` DATE NOT NULL,
  `unit_price` DECIMAL(10,2) NULL DEFAULT NULL,
  PRIMARY KEY (`item_id`, `purchase_date`)
);

-- ---
-- Table 'purchase_orders'
-- 
-- ---

DROP TABLE IF EXISTS `purchase_orders`;
		
CREATE TABLE `purchase_orders` (
  `po_id` INTEGER NOT NULL AUTO_INCREMENT,
  `po_number` VARCHAR(255) NULL DEFAULT NULL,
  `po_issued_on` DATE NULL DEFAULT NULL,
  `vendor` INTEGER NOT NULL,
  `total_amount` VARCHAR(255) NOT NULL,
  `payment_status` VARCHAR(255) NOT NULL,
  `order_status` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`po_id`)
);

-- ---
-- Table 'purchase_order_details'
-- 
-- ---

DROP TABLE IF EXISTS `purchase_order_details`;
		
CREATE TABLE `purchase_order_details` (
  `pod_id` INTEGER NOT NULL AUTO_INCREMENT,
  `po_id` INTEGER NOT NULL,
  `item_id` INTEGER NOT NULL,
  `uom` INTEGER NOT NULL,
  `unit_price` VARCHAR(255) NULL DEFAULT NULL,
  `quantity` VARCHAR(255) NULL DEFAULT NULL,
  `delivery_status` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`pod_id`)
);

-- ---
-- Table 'email_queue'
-- 
-- ---

DROP TABLE IF EXISTS `email_queue`;
		
CREATE TABLE `email_queue` (
  `queue_id` INTEGER NOT NULL,
  `from` VARCHAR(255) NULL DEFAULT NULL,
  `to` MEDIUMTEXT NOT NULL,
  `cc` MEDIUMTEXT NULL DEFAULT NULL,
  `bcc` MEDIUMTEXT NULL DEFAULT NULL,
  `subject` VARCHAR(1000) NOT NULL,
  `content` MEDIUMTEXT NULL DEFAULT NULL,
  `attachments` MEDIUMTEXT NULL DEFAULT NULL,
  `status` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`queue_id`)
);

-- ---
-- Foreign Keys 
-- ---

ALTER TABLE `users` ADD FOREIGN KEY (role) REFERENCES `roles` (`role_id`);
ALTER TABLE `vendors` ADD FOREIGN KEY (vendor_type) REFERENCES `vendor_types` (`vendor_type_id`);
ALTER TABLE `vendors` ADD FOREIGN KEY (country) REFERENCES `countries` (`country_id`);
ALTER TABLE `items` ADD FOREIGN KEY (item_type) REFERENCES `item_types` (`item_type_id`);
ALTER TABLE `items` ADD FOREIGN KEY (brand) REFERENCES `brands` (`brand_id`);
ALTER TABLE `items` ADD FOREIGN KEY (base_unit) REFERENCES `units_of_measure` (`uom_id`);
ALTER TABLE `branches` ADD FOREIGN KEY (branch_type) REFERENCES `branch_types` (`branch_type_id`);
ALTER TABLE `branches` ADD FOREIGN KEY (country) REFERENCES `countries` (`country_id`);
ALTER TABLE `user_branch_map` ADD FOREIGN KEY (user_id) REFERENCES `users` (`user_id`);
ALTER TABLE `user_branch_map` ADD FOREIGN KEY (branch_id) REFERENCES `branches` (`branch_id`);
ALTER TABLE `uom_conversion` ADD FOREIGN KEY (base_unit) REFERENCES `units_of_measure` (`uom_id`);
ALTER TABLE `uom_conversion` ADD FOREIGN KEY (to_unit) REFERENCES `units_of_measure` (`uom_id`);
ALTER TABLE `inventories` ADD FOREIGN KEY (item) REFERENCES `items` (`item_id`);
ALTER TABLE `inventories` ADD FOREIGN KEY (uom) REFERENCES `units_of_measure` (`uom_id`);
ALTER TABLE `inventories` ADD FOREIGN KEY (branch) REFERENCES `branches` (`branch_id`);
ALTER TABLE `item_types` ADD FOREIGN KEY (item_category) REFERENCES `item_categories` (`item_category_id`);
ALTER TABLE `item_price_records` ADD FOREIGN KEY (item_id) REFERENCES `items` (`item_id`);
ALTER TABLE `purchase_orders` ADD FOREIGN KEY (vendor) REFERENCES `vendors` (`vendor_id`);
ALTER TABLE `purchase_order_details` ADD FOREIGN KEY (po_id) REFERENCES `purchase_orders` (`po_id`);
ALTER TABLE `purchase_order_details` ADD FOREIGN KEY (uom) REFERENCES `units_of_measure` (`uom_id`);

-- ---
-- Table Properties
-- ---

-- ALTER TABLE `users` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `roles` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `vendors` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `items` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `branch_types` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `branches` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `user_branch_map` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `vendor_types` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `countries` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `units_of_measure` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `uom_conversion` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `inventories` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `item_categories` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `item_types` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `brands` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `item_price_records` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `purchase_orders` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `purchase_order_details` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `email_queue` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ---
-- Test Data
-- ---

-- INSERT INTO `users` (`user_id`,`first_name`,`last_name`,`role`,`login_id`,`password`,`email`,`phone`,`status`) VALUES
-- ('','','','','','','','','');
-- INSERT INTO `roles` (`role_id`,`role_name`,`role_code`) VALUES
-- ('','','');
-- INSERT INTO `vendors` (`vendor_id`,`vendor_name`,`vendor_code`,`vendor_type`,`registered_on`,`address_line_1`,`address_line_2`,`city`,`state`,`pincode`,`country`,`email`,`alt_email`,`phone`,`alt_phone`,`status`) VALUES
-- ('','','','','','','','','','','','','','','','');
-- INSERT INTO `items` (`item_id`,`item_code`,`item_name`,`item_type`,`brand`,`latest_price`,`stockable`,`base_unit`) VALUES
-- ('','','','','','','','');
-- INSERT INTO `branch_types` (`branch_type_id`,`branch_type`,`status`) VALUES
-- ('','','');
-- INSERT INTO `branches` (`branch_id`,`branch_type`,`branch_name`,`email`,`phone`,`address_line_1`,`address_line_2`,`city`,`state`,`country`,`pincode`,`status`) VALUES
-- ('','','','','','','','','','','','');
-- INSERT INTO `user_branch_map` (`user_id`,`branch_id`) VALUES
-- ('','');
-- INSERT INTO `vendor_types` (`vendor_type_id`,`vendor_type`,`status`) VALUES
-- ('','','');
-- INSERT INTO `countries` (`country_id`,`country_name`) VALUES
-- ('','');
-- INSERT INTO `units_of_measure` (`uom_id`,`unit_name`,`status`) VALUES
-- ('','','');
-- INSERT INTO `uom_conversion` (`conversion_id`,`base_unit`,`multiplier`,`to_unit`) VALUES
-- ('','','','');
-- INSERT INTO `inventories` (`inventory_id`,`item`,`uom`,`quantity`,`branch`,`last_updated_on`) VALUES
-- ('','','','','','');
-- INSERT INTO `item_categories` (`item_category_id`,`item_category`,`status`) VALUES
-- ('','','');
-- INSERT INTO `item_types` (`item_type_id`,`item_type`,`item_category`,`status`) VALUES
-- ('','','','');
-- INSERT INTO `brands` (`brand_id`,`brand_name`,`manufaturer_name`,`status`) VALUES
-- ('','','','');
-- INSERT INTO `item_price_records` (`item_id`,`purchase_date`,`unit_price`) VALUES
-- ('','','');
-- INSERT INTO `purchase_orders` (`po_id`,`po_number`,`po_issued_on`,`vendor`,`total_amount`,`payment_status`,`order_status`) VALUES
-- ('','','','','','','');
-- INSERT INTO `purchase_order_details` (`pod_id`,`po_id`,`item_id`,`uom`,`unit_price`,`quantity`,`delivery_status`) VALUES
-- ('','','','','','','');
-- INSERT INTO `email_queue` (`queue_id`,`from`,`to`,`cc`,`bcc`,`subject`,`content`,`attachments`,`status`) VALUES
-- ('','','','','','','','','');


--Sudarmathi 16 june 2020

CREATE TABLE `resources` ( `resource_id` varchar(255) NOT NULL, `display_name` varchar(255) DEFAULT NULL, `status` varchar(255) DEFAULT NULL, PRIMARY KEY (`resource_id`) ) ENGINE=InnoDB DEFAULT CHARSET=latin1
	
CREATE TABLE `privileges` (
 `resource_id` varchar(255) NOT NULL,
 `privilege_name` varchar(255) NOT NULL,
 `display_name` varchar(255) DEFAULT NULL,
 PRIMARY KEY (`resource_id`,`privilege_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1

INSERT INTO `resources` (`resource_id`, `display_name`, `status`) VALUES ('App\\Http\\Controllers\\Roles\\RolesController', 'Role', 'active');
INSERT INTO `privileges` (`resource_id`, `privilege_name`, `display_name`) VALUES ('App\\Http\\Controllers\\Roles\\RolesController', 'add', 'Add'), ('App\\Http\\Controllers\\Roles\\RolesController', 'edit', 'Edit');
INSERT INTO `privileges` (`resource_id`, `privilege_name`, `display_name`) VALUES ('App\\Http\\Controllers\\Roles\\RolesController', 'index', 'Access');

CREATE TABLE `event_log` (
 `event_id` int(11) NOT NULL AUTO_INCREMENT,
 `actor` int(11) NOT NULL,
 `subject` varchar(255) DEFAULT NULL,
 `event_type` varchar(255) DEFAULT NULL,
 `action` varchar(255) DEFAULT NULL,
 `resource_name` varchar(255) DEFAULT NULL,
 `added_on` datetime DEFAULT NULL,
 PRIMARY KEY (`event_id`)
) ENGINE=InnoDB AUTO_INCREMENT=821 DEFAULT CHARSET=latin1

ALTER TABLE `roles` ADD `role_description` VARCHAR(1000) NULL AFTER `role_code`;
ALTER TABLE `roles` ADD `role_status` VARCHAR(255) NOT NULL AFTER `role_description`;

ALTER TABLE `roles` ADD `created_on` DATETIME NULL AFTER `role_status`, ADD `updated_on` DATETIME NULL AFTER `created_on`, ADD `created_by` INT NULL AFTER `updated_on`, ADD `updated_by` INT NULL AFTER `created_by`;

ALTER TABLE `branch_types` ADD `created_on` DATETIME NULL AFTER `status`, ADD `updated_on` DATETIME NULL AFTER `created_on`, ADD `created_by` INT NULL AFTER `updated_on`, ADD `updated_by` INT NULL AFTER `created_by`;

-- Prasath M 18 Jun 2020
alter table item_categories change status item_category_status varchar(255) ;
ALTER TABLE `item_categories` ADD `created_on` DATETIME NULL AFTER `item_category_status`, ADD `updated_on` DATETIME NULL AFTER `created_on`, ADD `created_by` INT NULL 

alter table units_of_measure change status unit_status varchar(255) ;
ALTER TABLE `units_of_measure` ADD `created_on` DATETIME NULL AFTER `unit_status`, ADD `updated_on` DATETIME NULL AFTER `created_on`, ADD `created_by` INT NULL 

alter table item_types change status item_type_status varchar(255) ;
ALTER TABLE `item_types` ADD `created_on` DATETIME NULL AFTER `item_type_status`, ADD `updated_on` DATETIME NULL AFTER `created_on`, ADD `created_by` INT NULL 