-- ---
-- Globals
-- ---

-- SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
-- SET FOREIGN_KEY_CHECKS=0;

-- ---
-- Table 'stylists'
--
-- ---

DROP TABLE IF EXISTS `stylists`;

CREATE TABLE `stylists` (
  `id` INTEGER NOT NULL AUTO_INCREMENT,
  `stylist_name` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
);

-- ---
-- Table 'clients'
--
-- ---

DROP TABLE IF EXISTS `clients`;

CREATE TABLE `clients` (
  `id` INTEGER NOT NULL AUTO_INCREMENT,
  `client_name` VARCHAR(255) NULL DEFAULT NULL,
  `stylist_id` INTEGER NOT NULL,
  PRIMARY KEY (`id`)
);

-- ---
-- Foreign Keys
-- ---

ALTER TABLE `clients` ADD FOREIGN KEY (stylist_id) REFERENCES `stylists` (`id`) ON DELETE CASCADE;

-- ---
-- Table Properties
-- ---

-- ALTER TABLE `stylists` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `clients` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ---
-- Test Data
-- ---

-- INSERT INTO `stylists` (`id`,`stylist_name`) VALUES
-- ('','');
-- INSERT INTO `clients` (`id`,`client_name`,`stylist_id`) VALUES
-- ('','','');
