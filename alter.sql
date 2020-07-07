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

--Sudarmathi 26 June 2020
INSERT INTO `resources` (`resource_id`, `display_name`, `status`) VALUES ('App\\Http\\Controllers\\Rfq\\RfqController', 'Rfq', 'active');
INSERT INTO `privileges` (`resource_id`, `privilege_name`, `display_name`) VALUES ('App\\Http\\Controllers\\Rfq\\RfqController', 'edit', 'Edit'), ('App\\Http\\Controllers\\Rfq\\RfqController', 'index', 'Access'), ('App\\Http\\Controllers\\Rfq\\RfqController', 'add', 'Access');

--Sriram 26 June 2020
INSERT INTO `resources` (`resource_id`, `display_name`, `status`) VALUES ('App\\Http\\Controllers\\PurchaseOrder\\PurchaseOrderController', 'Purchase Order', 'active');
INSERT INTO `privileges` (`resource_id`, `privilege_name`, `display_name`) VALUES ('App\\Http\\Controllers\\PurchaseOrder\\PurchaseOrderController', 'edit', 'Edit'), ('App\\Http\\Controllers\\PurchaseOrder\\PurchaseOrderController', 'index', 'Access'), ('App\\Http\\Controllers\\PurchaseOrder\\PurchaseOrderController', 'add', 'Access');

--Sriram 29 June 2020
ALTER TABLE `purchase_orders` ADD `created_by` INT(11) NULL DEFAULT NULL AFTER `order_status`;
ALTER TABLE `purchase_orders` ADD `created_on` DATETIME NULL DEFAULT NULL AFTER `created_by`;
ALTER TABLE `purchase_order_details` ADD `created_on` DATETIME NULL DEFAULT NULL AFTER `delivery_status`;
ALTER TABLE `purchase_orders` ADD `updated_by` INT(11) NULL DEFAULT NULL AFTER `created_on`;
ALTER TABLE `purchase_orders` ADD `updated_on` DATETIME NULL DEFAULT NULL AFTER `updated_by`;
ALTER TABLE `purchase_order_details` ADD `updated_on` DATETIME NULL DEFAULT NULL AFTER `created_on`;
ALTER TABLE `quotes` ADD `approve_status` VARCHAR(100) NOT NULL DEFAULT 'no' AFTER `quotes_status`;
ALTER TABLE `quotes` ADD `updated_on` DATETIME NULL DEFAULT NULL AFTER `approve_status`;

--Sudarmathi 01 July 2020
ALTER TABLE `rfq` ADD `rfq_upload_file` VARCHAR(500) NULL AFTER `updated_by`;
ALTER TABLE `quotes` ADD `quotes_upload_file` VARCHAR(500) NULL AFTER `updated_by`;

--Sudarmathi 03 July 2020
ALTER TABLE items DROP FOREIGN KEY items_ibfk_1;
ALTER TABLE items DROP FOREIGN KEY items_ibfk_2;
ALTER TABLE items DROP FOREIGN KEY items_ibfk_3;
TRUNCATE item_categories;
TRUNCATE item_types;
TRUNCATE brands;
ALTER TABLE uom_conversion DROP FOREIGN KEY uom_conversion_ibfk_1;
ALTER TABLE uom_conversion DROP FOREIGN KEY uom_conversion_ibfk_2;
TRUNCATE uom_conversion;
TRUNCATE units_of_measure;

INSERT INTO `item_categories` (`item_category_id`, `item_category`, `item_category_status`, `created_on`, `updated_on`, `created_by`) VALUES (NULL, 'default', 'active', NULL, NULL, NULL);
INSERT INTO `item_types` (`item_type_id`, `item_type`, `item_category`, `item_type_status`, `created_on`, `updated_on`, `created_by`, `updated_by`) VALUES (NULL, 'default', '1', 'active', NULL, NULL, NULL, NULL);
INSERT INTO `brands` (`brand_id`, `brand_name`, `manufacturer_name`, `brand_status`, `created_on`, `updated_on`, `created_by`, `updated_by`) VALUES (NULL, 'default', NULL, 'active', NULL, NULL, NULL, NULL);
INSERT INTO `units_of_measure` (`uom_id`, `unit_name`, `unit_status`, `created_on`, `updated_on`, `created_by`) VALUES (NULL, 'Nos', 'active', NULL, NULL, NULL);
INSERT INTO `uom_conversion` (`conversion_id`, `base_unit`, `multiplier`, `to_unit`, `unit_conversion_status`, `created_on`, `updated_on`) VALUES (NULL, '1', '1.00', '', 'active', NULL, NULL);

ALTER TABLE `items` CHANGE `item_code` `item_code` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL;
ALTER TABLE `items` CHANGE `base_unit` `base_unit` INT(11) NULL;


--Sivakumar 06 July 2020
ALTER TABLE `rfq` ADD `description` TEXT NULL AFTER `rfq_status`
ALTER TABLE `quotes` ADD `description` TEXT NULL AFTER `quotes_status`
ALTER TABLE `purchase_orders` ADD `description` TEXT NULL AFTER `payment_status`

--SUdar 07 July 2020
ALTER TABLE `items` ADD `item_category_id` INT NULL AFTER `updated_by`;