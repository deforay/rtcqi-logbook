--Sudarmathi 25 June 2020

DROP TABLE IF EXISTS `rfq`;
		
CREATE TABLE `rfq` (
  `rfq_id` INTEGER NOT NULL AUTO_INCREMENT,
  `rfq_number` VARCHAR(255) NOT NULL,
  `rfq_issued_on` DATE NOT NULL,
  `last_date` DATE NULL DEFAULT NULL,
  `rfq_status` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`rfq_id`)
);

-- ---
-- Table 'quotes'
-- 
-- ---

DROP TABLE IF EXISTS `quotes`;
		
CREATE TABLE `quotes` (
  `quote_id` INTEGER NOT NULL AUTO_INCREMENT,
  `rfq_id` INTEGER NOT NULL,
  `vendor_id` INTEGER NOT NULL,
  `quote_number` VARCHAR(255) NOT NULL,
  `invited_on` DATE NOT NULL,
  `responded_on` DATETIME NOT NULL,
  `status` VARCHAR(255) NULL DEFAULT 'pending',
  PRIMARY KEY (`quote_id`),
  UNIQUE KEY (`rfq_id`, `vendor_id`)
);

-- ---
-- Table 'rfq_details'
-- 
-- ---

DROP TABLE IF EXISTS `rfq_details`;
		
CREATE TABLE `rfq_details` (
  `rfqd_id` INTEGER NOT NULL AUTO_INCREMENT,
  `rfq_id` INTEGER NOT NULL,
  `item_id` INTEGER NOT NULL,
  `uom` INTEGER NOT NULL,
  `quantity` DECIMAL(10,2) NOT NULL DEFAULT 1,
  PRIMARY KEY (`rfqd_id`)
);

-- ---
-- Table 'quote_details'
-- 
-- ---

DROP TABLE IF EXISTS `quote_details`;
		
CREATE TABLE `quote_details` (
  `qd_id` INTEGER NOT NULL AUTO_INCREMENT,
  `quote_id` INTEGER NOT NULL,
  `item_id` INTEGER NOT NULL,
  `uom` INTEGER NOT NULL,
  `quantity` INTEGER NOT NULL,
  `delivery_type` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`qd_id`)
);

ALTER TABLE `rfq` ADD `created_on` DATETIME NULL AFTER `rfq_status`, ADD `updated_on` DATETIME NULL AFTER `created_on`, ADD `created_by` INT NULL AFTER `updated_on`, ADD `updated_by` INT NULL AFTER `created_by`;
ALTER TABLE `quotes` CHANGE `quote_number` `quote_number` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL;
ALTER TABLE `quotes` CHANGE `invited_on` `invited_on` DATE NULL;
ALTER TABLE `quotes` CHANGE `responded_on` `responded_on` DATETIME NULL;
ALTER TABLE `quotes` CHANGE `status` `quotes_status` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'pending';
ALTER TABLE `quotes` ADD `created_on` DATETIME NULL AFTER `quotes_status`, ADD `updated_on` DATETIME NULL AFTER `created_on`, ADD `created_by` INT NULL AFTER `updated_on`, ADD `updated_by` INT NULL AFTER `created_by`;

--sri 25 June 2020
INSERT INTO `resources` (`resource_id`, `display_name`, `status`) VALUES ('App\\Http\\Controllers\\Quotes\\QuotesController', 'Quotes', 'active');
INSERT INTO `privileges` (`resource_id`, `privilege_name`, `display_name`) VALUES ('App\\Http\\Controllers\\Quotes\\QuotesController', 'edit', 'Edit'), ('App\\Http\\Controllers\\Quotes\\QuotesController', 'index', 'Access');
ALTER TABLE `quotes` CHANGE `status` `quotes_status` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'pending';
ALTER TABLE `items` ADD `item_status` VARCHAR(255) NULL DEFAULT 'active' AFTER `base_unit`;
ALTER TABLE `quote_details` ADD `unit_price` DECIMAL(10,2) NULL DEFAULT NULL AFTER `quantity`;
ALTER TABLE `quote_details` ADD `updated_on` DATETIME NULL DEFAULT NULL AFTER `delivery_type`;

