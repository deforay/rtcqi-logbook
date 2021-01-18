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


--SUdar 07 July 2020
ALTER TABLE `items` ADD `item_category_id` INT NULL AFTER `updated_by`;
--Sivakumar 07 July 2020
INSERT INTO `privileges` (`resource_id`, `privilege_name`, `display_name`) VALUES ('App\\Http\\Controllers\\MailTemplate\\MailTemplateController', 'add', 'Add'), ('App\\Http\\Controllers\\MailTemplate\\MailTemplateController', 'edit', 'Edit'), ('App\\Http\\Controllers\\MailTemplate\\MailTemplateController', 'index', 'Access');
INSERT INTO `resources` (`resource_id`, `display_name`, `status`) VALUES ('App\\Http\\Controllers\\MailTemplate\\MailTemplateController', 'Mail Template', 'active');
-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 07, 2020 at 05:01 PM
-- Server version: 5.7.29-0ubuntu0.18.04.1
-- PHP Version: 7.2.24-0ubuntu0.18.04.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `jumbobags`
--

-- --------------------------------------------------------

--
-- Table structure for table `mail_template`
--

CREATE TABLE `mail_template` (
  `mail_temp_id` int(11) NOT NULL,
  `template_name` varchar(255) NOT NULL,
  `mail_purpose` varchar(255) NOT NULL,
  `from_name` varchar(255) DEFAULT NULL,
  `mail_from` varchar(255) DEFAULT NULL,
  `mail_cc` varchar(255) DEFAULT NULL,
  `mail_bcc` varchar(255) DEFAULT NULL,
  `mail_subject` text,
  `mail_content` text,
  `mail_footer` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `mail_template`
  ADD PRIMARY KEY (`mail_temp_id`);
ALTER TABLE `mail_template`
  MODIFY `mail_temp_id` int(11) NOT NULL AUTO_INCREMENT;


--Sivakumar 08 July 2020
INSERT INTO `mail_template` (`mail_temp_id`, `template_name`, `mail_purpose`, `from_name`, `mail_from`, `mail_cc`, `mail_bcc`, `mail_subject`, `mail_content`, `mail_footer`) VALUES
(1, 'RFQ Activation', 'test_mail', 'American Society for Microbiology', 'test@deforay.com', NULL, NULL, 'RFQ activation mail', '<p>Dear&nbsp; ##VENDOR-NAME##,</p>\r\n\r\n<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;RFQ ##RFG-NUMBER## number is activated.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Thanks &amp; Regards,</p>\r\n\r\n<p>&nbsp;American Society for Microbiology&nbsp;</p>', NULL),
(2, 'Quotes Update', 'test', ' American Society for Microbiology Vendor', 'sivakumar@deforay.com', NULL, NULL, 'Quotes Update', '<p>Dear&nbsp; Admin,</p>\r\n\r\n<p>&nbsp; &nbsp; Vender&nbsp; ##VENDOR-NAME## added new&nbsp;Quotes (##QUOTES-NUMBAER##).</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Thanks &amp; Regards,</p>\r\n\r\n<p>&nbsp;&nbsp;##VENDOR-NAME##</p>', NULL),
(3, 'Quotes Approval', 'Quotes Approval', ' American Society for Microbiology ', 'sivakumar@deforay.com', NULL, NULL, 'Quotes Approval', '<p>Dear&nbsp; ##VENDOR-NAME##,</p>\r\n\r\n<p>&nbsp; &nbsp; &nbsp; &nbsp; Your&nbsp;Quotes&nbsp;(##QUOTES-NUMBAER##) is approved.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Thanks &amp; Regards,</p>\r\n\r\n<p>&nbsp;American Society for Microbiology&nbsp;</p>', NULL);

CREATE TABLE `temp_mail` (
 `temp_id` int(11) NOT NULL AUTO_INCREMENT,
 `message` mediumtext,
 `from_mail` varchar(255) DEFAULT NULL,
 `to_email` varchar(255) DEFAULT NULL,
 `cc` varchar(500) DEFAULT NULL,
 `bcc` varchar(500) DEFAULT NULL,
 `subject` mediumtext,
 `from_full_name` varchar(255) DEFAULT NULL,
 `status` varchar(255) NOT NULL DEFAULT 'pending',
 `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `customer_name` varchar(255) DEFAULT NULL,
 PRIMARY KEY (`temp_id`),
 UNIQUE KEY `temp_id` (`temp_id`)
);


--Sudarmathi 08 July 2020
ALTER TABLE `quotes` ADD `stock_available` VARCHAR(50) NULL DEFAULT 'no' AFTER `quotes_upload_file`, ADD `eta_if_no_stock` INT NULL AFTER `stock_available`, ADD `vendor_notes` TEXT NULL AFTER `eta_if_no_stock`, ADD `mode_of_delivery` VARCHAR(255) NULL AFTER `vendor_notes`, ADD `estimated_date_of_delivery` DATE NULL AFTER `mode_of_delivery`;
ALTER TABLE `quotes` ADD `description` TEXT NULL AFTER `estimated_date_of_delivery`;

--Sivakumar 09 July 2020
ALTER TABLE `purchase_orders` ADD `upload_path` VARCHAR(500) NULL AFTER `updated_on`;

---Sudarmathi 10 July 2020
ALTER TABLE `purchase_orders` CHANGE `upload_path` `upload_path` VARCHAR(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL;

--Sivakumar 14 July 2020
ALTER TABLE `vendors` CHANGE `registered_on` `registered_on` DATE NULL DEFAULT NULL;

--Sivakumar 15 July 2020
ALTER TABLE `items` ADD `updated_by` INT(11) NULL DEFAULT NULL AFTER `updated_on`;


---Sudarmathi 17 July 2020
ALTER TABLE `purchase_orders` ADD `quote_id` INT NOT NULL AFTER `description`;
-- ALTER TABLE `purchase_orders` ADD FOREIGN KEY (quote_id) REFERENCES `quotes` (`quotes_id`);

CREATE TABLE `delivery_schedule` (
 `delivery_id` int(11) NOT NULL AUTO_INCREMENT,
 `item_id` int(11) NOT NULL,
 `qty` int(11) NOT NULL,
 `expected_date_of_delivery` date NOT NULL,
 `delivery_mode` varchar(255) NOT NULL,
 `comments` text NOT NULL,
 PRIMARY KEY (`delivery_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1


--Sudarmathi 20 july 2020

INSERT INTO `resources` (`resource_id`, `display_name`, `status`) VALUES ('App\\Http\\Controllers\\DeliverySchedule\\DeliveryScheduleController', 'Delivery Schedule', 'active');
INSERT INTO `privileges` (`resource_id`, `privilege_name`, `display_name`) VALUES ('App\\Http\\Controllers\\DeliverySchedule\\DeliveryScheduleController', 'index', 'Access');
INSERT INTO `privileges` (`resource_id`, `privilege_name`, `display_name`) VALUES ('App\\Http\\Controllers\\DeliverySchedule\\DeliveryScheduleController', 'add', 'Add');
ALTER TABLE `delivery_schedule` ADD `created_on` DATETIME NULL AFTER `comments`, ADD `updated_on` DATETIME NULL AFTER `created_on`, ADD `created_by` INT NULL AFTER `updated_on`, ADD `updated_by` INT NULL AFTER `created_by`, ADD `po_id` INT NOT NULL AFTER `updated_by`;
ALTER TABLE `delivery_schedule` CHANGE `po_id` `pod_id` INT(11) NOT NULL;

--Sudarmathi 22 july 2020
INSERT INTO `privileges` (`resource_id`, `privilege_name`, `display_name`) VALUES ('App\\Http\\Controllers\\DeliverySchedule\\DeliveryScheduleController', 'edit', 'Edit');
ALTER TABLE `delivery_schedule` CHANGE `qty` `delivery_qty` INT(11) NOT NULL;

CREATE TABLE `delivery_schedule_edit_comments` (
 `delivery_comment_id` int(11) NOT NULL AUTO_INCREMENT,
 `delivery_id` int(11) NOT NULL,
 `edit_comments` text NOT NULL,
 `updated_by` int(11) DEFAULT NULL,
 `created_by` int(11) DEFAULT NULL,
 `created_on` datetime DEFAULT NULL,
 `updated_on` datetime DEFAULT NULL,
 PRIMARY KEY (`delivery_comment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


---sudarmathi july 28 2020

ALTER TABLE `purchase_orders` ADD `last_date_of_delivery` DATE NULL AFTER `quote_id`, ADD `delivery_location` VARCHAR(255) NULL AFTER `last_date_of_delivery`

---Sudarmathi july 29 2020

ALTER TABLE `delivery_schedule` ADD `delivery_schedule_status` VARCHAR(255) NULL AFTER `pod_id`;
INSERT INTO `privileges` (`resource_id`, `privilege_name`, `display_name`) VALUES ('App\\Http\\Controllers\\DeliverySchedule\\DeliveryScheduleController', 'itemreceive', 'Item Receive');

---Sudarmathi july 30 2020
ALTER TABLE `delivery_schedule` ADD `received_qty` INT NULL AFTER `delivery_schedule_status`, ADD `damaged_qty` INT NULL AFTER `received_qty`;
ALTER TABLE `delivery_schedule` ADD `short_description` TEXT NULL AFTER `damaged_qty`;

--sudarmathi july 31 2020
CREATE TABLE `asm`.`inventory_stock` ( `stock_id` INT NOT NULL AUTO_INCREMENT , `item_id` INT NOT NULL , `expiry_date` DATE NOT NULL , `service_date` DATE NOT NULL , `stock_quantity` INT NOT NULL , `created_on` DATETIME NULL , `updated_on` DATETIME NULL , `created_by` INT NULL , `updated_by` INT NULL , PRIMARY KEY (`stock_id`)) ENGINE = InnoDB;

--Sudarmathi August 03 2020

ALTER TABLE `inventory_stock` ADD `branch_id` INT NOT NULL AFTER `updated_by`;
ALTER TABLE `delivery_schedule` ADD `branch_id` INT NOT NULL AFTER `short_description`;

--Sudarmathi August 06 2020

ALTER TABLE `purchase_order_details` DROP `delivery_status`;

CREATE TABLE `autocomplete_comments` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `description` text NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
INSERT INTO `autocomplete_comments` (`id`, `description`) VALUES (NULL, 'Received in damaged condition'), (NULL, 'Expired');
INSERT INTO `autocomplete_comments` (`id`, `description`) VALUES (NULL, 'Not matching requirements/description'), (NULL, 'Did not meet expectations');
INSERT INTO `autocomplete_comments` (`id`, `description`) VALUES (NULL, 'Delayed delivery');

--Sudarmathi 10 August 2020
ALTER TABLE `autocomplete_comments` ADD `created_on` DATETIME NULL AFTER `description`, ADD `updated_on` DATETIME NULL AFTER `created_on`, ADD `created_by` INT NULL AFTER `updated_on`, ADD `updated_by` INT NULL AFTER `created_by`;

--Sudarmathi 12 August 2020
ALTER TABLE `quotes` CHANGE `description` `quote_description` TEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;
ALTER TABLE `purchase_orders` ADD `purchase_order_description` TEXT NULL AFTER `delivery_location`;
ALTER TABLE `purchase_orders` ADD `purchase_order_upload_file` TEXT NULL AFTER `purchase_order_description`;

--Sudarmathi 13 August 2020
ALTER TABLE `inventory_stock` ADD `non_conformity_comments` TEXT NULL AFTER `branch_id`;
ALTER TABLE `inventory_stock` DROP `service_date`;
ALTER TABLE `inventory_stock` ADD `batch_number` VARCHAR(255) NULL AFTER `non_conformity_comments`;

--Sudarmathi 17 August 2020
INSERT INTO `privileges` (`resource_id`, `privilege_name`, `display_name`) VALUES ('App\\Http\\Controllers\\Rfq\\RfqController', 'activate', 'Activate');
UPDATE `privileges` SET `display_name` = 'Add' WHERE `privileges`.`resource_id` = 'App\\Http\\Controllers\\Rfq\\RfqController' AND `privileges`.`privilege_name` = 'add';

--Prasath M 18 Aug 2020
Alter table quote_details add column description Varchar(255) NULL;
Alter table quotes change responded_on responded_on date NULL;
Alter table purchase_order_details add column description Varchar(255) NULL;


--Sudarmathi M 18 Aug 2020
ALTER TABLE `temp_mail` ADD `attachment` TEXT NULL AFTER `customer_name`;

--Sudarmathi 20 Aug 2020
ALTER TABLE `rfq_details` ADD `item_description` TEXT NULL AFTER `quantity`;

--sriram 21 AUG
ALTER TABLE `purchase_orders` CHANGE `quote_id` `quote_id` INT(11) NULL DEFAULT NULL;

--Sudarmathi 24 Aug 2020
ALTER TABLE `rfq` ADD `rfq_notes` TEXT NULL AFTER `description`;
ALTER TABLE `quotes` ADD `quote_notes` TEXT NULL AFTER `quote_description`;
ALTER TABLE `purchase_orders` ADD `purchase_order_notes` TEXT NULL AFTER `purchase_order_upload_file`;
CREATE TABLE `bank_details` (
 `bank_id` int(11) NOT NULL AUTO_INCREMENT,
 `vendor_id` int(11) NOT NULL,
 `bank_name` varchar(255) NOT NULL,
 `bank_account_no` varchar(255) NOT NULL,
 `bank_branch` varchar(255) NOT NULL,
 `swift_code` varchar(255) NOT NULL,
 `bank_status` int(11) DEFAULT NULL,
 `created_on` datetime DEFAULT NULL,
 `updated_on` datetime DEFAULT NULL,
 `created_by` int(11) DEFAULT NULL,
 `updated_by` int(11) DEFAULT NULL,
 PRIMARY KEY (`bank_id`),
 KEY `vendor_id` (`vendor_id`),
 CONSTRAINT `bank_details_ibfk_1` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`vendor_id`))
 ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

 --Sudarmathi 25 Aug 2020
 ALTER TABLE `bank_details` ADD `account_holder_name` VARCHAR(255) NOT NULL AFTER `bank_status`, ADD `address` VARCHAR(500) NULL AFTER `account_holder_name`, ADD `city` VARCHAR(255) NULL AFTER `address`, ADD `country` VARCHAR(255) NULL AFTER `city`, ADD `iban` VARCHAR(255) NOT NULL AFTER `country`;
 ALTER TABLE `bank_details` ADD `intermediary_bank` VARCHAR(255) NULL AFTER `iban`;
 ALTER TABLE `bank_details` CHANGE `address` `bank_address` VARCHAR(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;
 ALTER TABLE `bank_details` CHANGE `city` `bank_city` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;
 ALTER TABLE `bank_details` CHANGE `country` `bank_country` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;
 
 --sriram 25 AUG
 ALTER TABLE `inventory_stock` ADD `sl_number` INT(11) NULL DEFAULT NULL AFTER `batch_number`;
 ALTER TABLE `inventory_stock` ADD `manufacturing_date` DATE NULL DEFAULT NULL AFTER `sl_number`;
 ALTER TABLE `inventory_stock` ADD `inventory_upload_file` VARCHAR(500) NULL DEFAULT NULL AFTER `manufacturing_date`;
 
 --sriram 26 AUG
 CREATE TABLE `global_config` (
`config_id` tinyint(11) NOT NULL AUTO_INCREMENT,
`display_name` varchar(255) DEFAULT NULL,
`global_name` varchar(255) DEFAULT NULL,
`global_value` varchar(255) DEFAULT NULL,
PRIMARY KEY (`config_id`)
);

INSERT INTO `global_config` (`config_id`, `display_name`, `global_name`, `global_value`) VALUES (NULL, 'Email', 'email', 'admin@asmusa.org')


--Sudarmathi 26 AUG 2020

ALTER TABLE `mail_template` CHANGE `mail_purpose` `mail_purpose` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL;

--Sudarmathi 31 AUG 2020
INSERT INTO `resources` (`resource_id`, `display_name`, `status`) VALUES ('App\\Http\\Controllers\\GlobalConfig\\GlobalConfigController', 'Global Config', 'active');
INSERT INTO `privileges` (`resource_id`, `privilege_name`, `display_name`) VALUES ('App\\Http\\Controllers\\GlobalConfig\\GlobalConfigController', 'edit', 'Edit'), ('App\\Http\\Controllers\\GlobalConfig\\GlobalConfigController', 'index', 'Access');
ALTER TABLE `global_config` ADD `allow_admin_edit` VARCHAR(10) NOT NULL DEFAULT 'no' AFTER `global_value`, ADD `is_numeric` VARCHAR(10) NOT NULL DEFAULT 'no' AFTER `allow_admin_edit`;
UPDATE `global_config` SET `allow_admin_edit` = 'yes' WHERE `global_config`.`config_id` = 1;
ALTER TABLE `purchase_orders` DROP `upload_path`;

--Sudarmathi 02 SEP 2020

CREATE TABLE `inventory_outwards` (
 `outwards_id` int(11) NOT NULL AUTO_INCREMENT,
 `item_id` int(11) NOT NULL,
 `item_quantity` int(11) NOT NULL,
 `issued_on` date NOT NULL,
 `issued_to` varchar(255) NOT NULL,
 `outwards_description` text,
 `created_by` int(11) DEFAULT NULL,
 `updated_by` int(11) DEFAULT NULL,
 `created_on` date DEFAULT NULL,
 `updated_on` date DEFAULT NULL,
 PRIMARY KEY (`outwards_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `resources` (`resource_id`, `display_name`, `status`) VALUES ('App\\Http\\Controllers\\InventoryOutwards\\InventoryOutwardsController', 'Inventory Outwards', 'active');
INSERT INTO `privileges` (`resource_id`, `privilege_name`, `display_name`) VALUES ('App\\Http\\Controllers\\InventoryOutwards\\InventoryOutwardsController', 'add', 'Add'), ('App\\Http\\Controllers\\InventoryOutwards\\InventoryOutwardsController', 'index', 'Access');
ALTER TABLE `inventory_outwards` CHANGE `item_quantity` `item_issued_quantity` INT(11) NOT NULL;
ALTER TABLE `inventory_outwards` CHANGE `created_on` `created_on` DATETIME NULL DEFAULT NULL;
ALTER TABLE `inventory_outwards` CHANGE `updated_on` `updated_on` DATETIME NULL DEFAULT NULL;

---Sudarmathi 03 SEP 2020
ALTER TABLE `inventory_stock` CHANGE `expiry_date` `expiry_date` DATE NULL;

--Sudarmathi 04 SEP 2020

INSERT INTO `resources` (`resource_id`, `display_name`, `status`) VALUES ('App\\Http\\Controllers\\Report\\ReportController', 'Report', 'active');
INSERT INTO `privileges` (`resource_id`, `privilege_name`, `display_name`) VALUES ('App\\Http\\Controllers\\Report\\ReportController', 'inventoryReport', 'Inventory Report');

--sri 08 SEP 2020
ALTER TABLE `inventory_outwards` ADD `stock_return` VARCHAR(100) NOT NULL DEFAULT 'no' AFTER `updated_on`;
INSERT INTO `privileges` (`resource_id`, `privilege_name`, `display_name`) VALUES ('App\\Http\\Controllers\\InventoryOutwards\\InventoryOutwardsController', 'returnissueitems', 'Return Issue Item');

--sri 09 SEP 2020
ALTER TABLE `items` ADD `minimum_quantity` INT(5) NULL DEFAULT NULL AFTER `stockable`

--Sudar 09 SEP 2020
ALTER TABLE `inventory_stock` ADD `received_date` DATE NULL DEFAULT NULL AFTER `inventory_upload_file`;

--Sudar 10 SEP 2020
INSERT INTO `global_config` (`config_id`, `display_name`, `global_name`, `global_value`, `allow_admin_edit`, `is_numeric`) VALUES (NULL, 'Expiry Alert', 'expiry_alert', '7', 'yes', 'yes');

--Sri 12 SEP 2020
INSERT INTO `privileges` (`resource_id`, `privilege_name`, `display_name`) VALUES ('App\\Http\\Controllers\\AssetTag\\AssetTagController', 'index', 'Access'), ('App\\Http\\Controllers\\AssetTag\\AssetTagController', 'add', 'Add');
INSERT INTO `privileges` (`resource_id`, `privilege_name`, `display_name`) VALUES ('App\\Http\\Controllers\\AssetTag\\AssetTagController', 'edit', 'Edit');

INSERT INTO `privileges` (`resource_id`, `privilege_name`, `display_name`) VALUES ('App\\Http\\Controllers\\Maintenance\\MaintenanceController', 'index', 'Access'), ('App\\Http\\Controllers\\Maintenance\\MaintenanceController', 'add', 'Add');
INSERT INTO `privileges` (`resource_id`, `privilege_name`, `display_name`) VALUES ('App\\Http\\Controllers\\Maintenance\\MaintenanceController', 'edit', 'Edit');
INSERT INTO `resources` (`resource_id`, `display_name`, `status`) VALUES ('App\\Http\\Controllers\\AssetTag\\AssetTagController', 'Asset Tag', 'active'), ('App\\Http\\Controllers\\Maintenance\\MaintenanceController', 'Maintenance', 'active');

CREATE TABLE `asset_tags` (
 `asset_id` int(11) NOT NULL AUTO_INCREMENT,
 `location_id` int(11) NOT NULL,
 `item_id` int(11) NOT NULL,
 `asset_tag` varchar(255) NOT NULL,
 `asset_tag_status` varchar(100) NOT NULL,
 `created_by` int(11) DEFAULT NULL,
 `updated_by` int(11) DEFAULT NULL,
 `created_on` date DEFAULT NULL,
 `updated_on` date DEFAULT NULL,
 PRIMARY KEY (`asset_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `asset_tags` ADD `status` VARCHAR(100) NOT NULL DEFAULT 'active' AFTER `asset_tag`;
ALTER TABLE `branches` ADD `branch_code` VARCHAR(255) NULL DEFAULT NULL AFTER `branch_name`;

ALTER TABLE `asset_tags` CHANGE `location_id` `branch_id` INT(11) NOT NULL;

--Sri 15 SEP 2020

CREATE TABLE `maintenance` (
 `maintenance_id` int(11) NOT NULL AUTO_INCREMENT,
 `service_date` date NOT NULL,
 `service_done_by` varchar(255) NOT NULL,
 `verified_by` varchar(255) NOT NULL,
 `regular_service` varchar(255) NOT NULL,
 `next_maintenance_date` date NOT NULL,
 `maintenance_status` varchar(100) NOT NULL,
 `created_by` int(11) DEFAULT NULL,
 `updated_by` int(11) DEFAULT NULL,
 `created_on` date DEFAULT NULL,
 `updated_on` date DEFAULT NULL,
 PRIMARY KEY (`maintenance_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--Sudarmathi 15 SEP 2020

ALTER TABLE `items` ADD `requires_service` VARCHAR(50) NOT NULL DEFAULT 'no' AFTER `updated_by`, ADD `can_expire` VARCHAR(50) NOT NULL DEFAULT 'no' AFTER `requires_service`;

--sri SEP 2020
ALTER TABLE `units_of_measure` ADD `updated_by` INT(11) NULL DEFAULT NULL AFTER `created_by`;
ALTER TABLE `uom_conversion` ADD `created_by` INT(11) NULL DEFAULT NULL AFTER `updated_on`;
ALTER TABLE `uom_conversion` ADD `updated_by` INT(11) NULL DEFAULT NULL AFTER `created_by`;

-- Prasath M 21 SEP 2020  
ALTER TABLE `inventory_stock` ADD `pod_id` INT(11)  NULL AFTER `updated_by`;
ALTER TABLE `inventory_stock` ADD `delivery_id` INT(11)  NULL AFTER `updated_by`;

--sri 21 Sep 2020
ALTER TABLE `maintenance` CHANGE `created_on` `created_on` DATETIME NULL DEFAULT NULL;
ALTER TABLE `maintenance` CHANGE `updated_on` `updated_on` DATETIME NULL DEFAULT NULL;
ALTER TABLE `maintenance` ADD `location_id` INT(11) NULL DEFAULT NULL AFTER `maintenance_id`;
ALTER TABLE `maintenance` ADD `item_id` INT(11) NULL DEFAULT NULL AFTER `location_id`;

--Sudarmathi 21 SEP 2020
INSERT INTO `global_config` (`config_id`, `display_name`, `global_name`, `global_value`, `allow_admin_edit`, `is_numeric`) VALUES (NULL, 'Logo', 'logo_path', '/images/logo.png', 'yes', 'no');

--Sudarmathi 24 SEP 2020
ALTER TABLE `inventory_outwards` ADD `issued_from` INT NOT NULL AFTER `stock_return`;
ALTER TABLE `inventory_outwards` ADD `return_on` DATE NULL AFTER `issued_from`, ADD `return_quantity` INT NULL AFTER `return_on`;
ALTER TABLE `inventory_outwards` ADD `stock_expiry_date` DATE NULL AFTER `return_quantity`;

--Sudarmathi 28 SEP 2020
INSERT INTO `global_config` (`config_id`, `display_name`, `global_name`, `global_value`, `allow_admin_edit`, `is_numeric`) VALUES (NULL, 'Base Currency', 'base_currency', 'GBP', 'yes', 'no');
ALTER TABLE `purchase_orders` ADD `base_currency` VARCHAR(50) NOT NULL DEFAULT 'yes' AFTER `purchase_order_notes`, ADD `exchange_rate` VARCHAR(255) NOT NULL AFTER `base_currency`;

--Sudarmathi 30 SEP 2020
ALTER TABLE `purchase_order_details` ADD `converted_price` VARCHAR(255) NULL AFTER `description`;

--Sudarmathi 09 Nov 2020
ALTER TABLE `quotes` ADD `quote_expiry_date` DATE NULL AFTER `quote_notes`;

--Sudarmathi 19 Nov 2020
ALTER TABLE `rfq` ADD `purchase_category` VARCHAR(255) NULL AFTER `rfq_notes`;
ALTER TABLE `purchase_orders` ADD `po_purchase_category` VARCHAR(255) NULL AFTER `exchange_rate`;
