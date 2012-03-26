SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

DROP SCHEMA IF EXISTS `ecommerce` ;
CREATE SCHEMA IF NOT EXISTS `ecommerce` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci ;
USE `ecommerce` ;

-- -----------------------------------------------------
-- Table `ecommerce`.`customers`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ecommerce`.`customers` ;

CREATE  TABLE IF NOT EXISTS `ecommerce`.`customers` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `email` VARCHAR(255) NOT NULL ,
  `password` VARCHAR(65) NOT NULL ,
  `salt` VARCHAR(20) NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ecommerce`.`customer_addresses`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ecommerce`.`customer_addresses` ;

CREATE  TABLE IF NOT EXISTS `ecommerce`.`customer_addresses` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `customers_id` INT NOT NULL ,
  `first_name` VARCHAR(100) NOT NULL ,
  `last_name` VARCHAR(100) NOT NULL ,
  `address_1` VARCHAR(255) NOT NULL ,
  `address_2` VARCHAR(255) NULL ,
  `city` VARCHAR(100) NOT NULL ,
  `state` VARCHAR(50) NOT NULL ,
  `country` VARCHAR(2) NOT NULL ,
  `zip_code` VARCHAR(15) NOT NULL ,
  `type` ENUM('billing','shipping') NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_ca_customers` (`customers_id` ASC) ,
  CONSTRAINT `fk_ca_customers`
    FOREIGN KEY (`customers_id` )
    REFERENCES `ecommerce`.`customers` (`id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ecommerce`.`products`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ecommerce`.`products` ;

CREATE  TABLE IF NOT EXISTS `ecommerce`.`products` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(100) NOT NULL ,
  `is_deleted` TINYINT(1) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ecommerce`.`product_descriptions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ecommerce`.`product_descriptions` ;

CREATE  TABLE IF NOT EXISTS `ecommerce`.`product_descriptions` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `products_id` INT NOT NULL ,
  `name` VARCHAR(100) NOT NULL ,
  `price` DECIMAL(10,2) NOT NULL ,
  `deck` VARCHAR(100) NULL ,
  `long_desc` TEXT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_pd_products` (`products_id` ASC) ,
  CONSTRAINT `fk_pd_products`
    FOREIGN KEY (`products_id` )
    REFERENCES `ecommerce`.`products` (`id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ecommerce`.`product_images`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ecommerce`.`product_images` ;

CREATE  TABLE IF NOT EXISTS `ecommerce`.`product_images` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `products_id` INT NOT NULL ,
  `location` VARCHAR(255) NOT NULL ,
  `primary` TINYINT(1) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_pi_products` (`products_id` ASC) ,
  CONSTRAINT `fk_pi_products`
    FOREIGN KEY (`products_id` )
    REFERENCES `ecommerce`.`products` (`id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ecommerce`.`departments`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ecommerce`.`departments` ;

CREATE  TABLE IF NOT EXISTS `ecommerce`.`departments` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(100) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ecommerce`.`admin_users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ecommerce`.`admin_users` ;

CREATE  TABLE IF NOT EXISTS `ecommerce`.`admin_users` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `username` VARCHAR(100) NOT NULL ,
  `email` VARCHAR(255) NOT NULL ,
  `first_name` VARCHAR(100) NOT NULL ,
  `last_name` VARCHAR(100) NOT NULL ,
  `hash` VARCHAR(65) NOT NULL ,
  `salt` VARCHAR(20) NOT NULL ,
  `departments_id` INT NOT NULL ,
  `lockout_time` DATETIME NULL ,
  `created_time` DATETIME NULL ,
  `updated_time` DATETIME NULL ,
  `is_deleted` TINYINT(1) NOT NULL DEFAULT 0 ,
  `lockout` TINYINT(1) NULL DEFAULT 0 ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `username_UNIQUE` (`username` ASC) ,
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) ,
  INDEX `fk_au_departments` (`departments_id` ASC) ,
  CONSTRAINT `fk_au_departments`
    FOREIGN KEY (`departments_id` )
    REFERENCES `ecommerce`.`departments` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ecommerce`.`admin_user_roles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ecommerce`.`admin_user_roles` ;

CREATE  TABLE IF NOT EXISTS `ecommerce`.`admin_user_roles` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(100) NOT NULL ,
  `map` VARCHAR(255) NOT NULL ,
  `parent_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `name_UNIQUE` (`name` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ecommerce`.`admin_user_roles_map`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ecommerce`.`admin_user_roles_map` ;

CREATE  TABLE IF NOT EXISTS `ecommerce`.`admin_user_roles_map` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `admin_user_roles_id` INT NOT NULL ,
  `admin_users_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_aurm_admin_users` (`admin_users_id` ASC) ,
  INDEX `fk_aurm_admin_user_roles` (`admin_user_roles_id` ASC) ,
  CONSTRAINT `fk_aurm_admin_users`
    FOREIGN KEY (`admin_users_id` )
    REFERENCES `ecommerce`.`admin_users` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_aurm_admin_user_roles`
    FOREIGN KEY (`admin_user_roles_id` )
    REFERENCES `ecommerce`.`admin_user_roles` (`id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ecommerce`.`department_roles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ecommerce`.`department_roles` ;

CREATE  TABLE IF NOT EXISTS `ecommerce`.`department_roles` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(100) NOT NULL ,
  `map` VARCHAR(255) NOT NULL ,
  `parent_id` INT NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ecommerce`.`department_roles_map`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ecommerce`.`department_roles_map` ;

CREATE  TABLE IF NOT EXISTS `ecommerce`.`department_roles_map` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `department_roles_id` INT NOT NULL ,
  `departments_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_drm_departments` (`departments_id` ASC) ,
  INDEX `fk_drm_department_roles` (`department_roles_id` ASC) ,
  CONSTRAINT `fk_drm_departments`
    FOREIGN KEY (`departments_id` )
    REFERENCES `ecommerce`.`departments` (`id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_drm_department_roles`
    FOREIGN KEY (`department_roles_id` )
    REFERENCES `ecommerce`.`department_roles` (`id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ecommerce`.`categories`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ecommerce`.`categories` ;

CREATE  TABLE IF NOT EXISTS `ecommerce`.`categories` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(100) NOT NULL ,
  `parent_id` INT NOT NULL ,
  `is_deleted` TINYINT(1) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ecommerce`.`product_categories_map`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ecommerce`.`product_categories_map` ;

CREATE  TABLE IF NOT EXISTS `ecommerce`.`product_categories_map` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `product_descriptions_id` INT NOT NULL ,
  `categories_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_pcm_product_descriptions` (`product_descriptions_id` ASC) ,
  INDEX `fk_pcm_categories` (`categories_id` ASC) ,
  CONSTRAINT `fk_pcm_product_descriptions`
    FOREIGN KEY (`product_descriptions_id` )
    REFERENCES `ecommerce`.`product_descriptions` (`id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pcm_categories`
    FOREIGN KEY (`categories_id` )
    REFERENCES `ecommerce`.`categories` (`id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ecommerce`.`carts`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ecommerce`.`carts` ;

CREATE  TABLE IF NOT EXISTS `ecommerce`.`carts` (
  `id` INT NOT NULL ,
  `total` DECIMAL NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ecommerce`.`promos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ecommerce`.`promos` ;

CREATE  TABLE IF NOT EXISTS `ecommerce`.`promos` (
  `id` INT NOT NULL ,
  `name` VARCHAR(45) NOT NULL ,
  `code` VARCHAR(10) NOT NULL ,
  `amount` DECIMAL NOT NULL ,
  `start` DATE NOT NULL ,
  `end` DATE NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ecommerce`.`orders`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ecommerce`.`orders` ;

CREATE  TABLE IF NOT EXISTS `ecommerce`.`orders` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `total` DECIMAL NOT NULL ,
  `status` SMALLINT NOT NULL ,
  `start` DATE NOT NULL ,
  `finish` DATE NULL ,
  `carts_id` INT NOT NULL ,
  `customers_id` INT NOT NULL ,
  `orders_billing_address_id` INT NOT NULL ,
  `orders_shipping_address_id` INT NOT NULL ,
  `promos_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_o_carts` (`carts_id` ASC) ,
  INDEX `fk_o_promos` (`promos_id` ASC) ,
  CONSTRAINT `fk_o_carts`
    FOREIGN KEY (`carts_id` )
    REFERENCES `ecommerce`.`carts` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_o_promos`
    FOREIGN KEY (`promos_id` )
    REFERENCES `ecommerce`.`promos` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ecommerce`.`orders_customers_addresses`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ecommerce`.`orders_customers_addresses` ;

CREATE  TABLE IF NOT EXISTS `ecommerce`.`orders_customers_addresses` (
  `id` INT NOT NULL COMMENT '		' ,
  `customers_id` INT NOT NULL ,
  `first_name` VARCHAR(100) NOT NULL ,
  `last_name` VARCHAR(100) NOT NULL ,
  `address_1` VARCHAR(255) NOT NULL ,
  `address_2` VARCHAR(255) NULL ,
  `city` VARCHAR(100) NOT NULL ,
  `state` VARCHAR(50) NOT NULL ,
  `country` VARCHAR(2) NOT NULL ,
  `zip_code` VARCHAR(15) NOT NULL ,
  `type` ENUM('billing','shipping') NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ecommerce`.`shippings`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ecommerce`.`shippings` ;

CREATE  TABLE IF NOT EXISTS `ecommerce`.`shippings` (
  `id` INT NOT NULL ,
  `delivery_type_id` INT NOT NULL ,
  `cost` DECIMAL NOT NULL ,
  `address_id` INT NOT NULL ,
  `status` SMALLINT NOT NULL ,
  `fedex_route_id` INT NOT NULL ,
  `orders_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_s_orders` (`orders_id` ASC) ,
  CONSTRAINT `fk_s_orders`
    FOREIGN KEY (`orders_id` )
    REFERENCES `ecommerce`.`orders` (`id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ecommerce`.`orders_customers_addresses_archive`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ecommerce`.`orders_customers_addresses_archive` ;

CREATE  TABLE IF NOT EXISTS `ecommerce`.`orders_customers_addresses_archive` (
  `id` INT NOT NULL COMMENT '		' ,
  `customers_id` INT NOT NULL ,
  `first_name` VARCHAR(100) NOT NULL ,
  `last_name` VARCHAR(100) NOT NULL ,
  `address_1` VARCHAR(255) NOT NULL ,
  `address_2` VARCHAR(255) NULL ,
  `city` VARCHAR(100) NOT NULL ,
  `state` VARCHAR(50) NOT NULL ,
  `country` VARCHAR(2) NOT NULL ,
  `zip_code` VARCHAR(15) NOT NULL ,
  `type` ENUM('billing','shipping') NOT NULL )
ENGINE = ARCHIVE;


-- -----------------------------------------------------
-- Table `ecommerce`.`carts_products_map`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ecommerce`.`carts_products_map` ;

CREATE  TABLE IF NOT EXISTS `ecommerce`.`carts_products_map` (
  `id` INT NOT NULL ,
  `cart_id` INT NOT NULL ,
  `products_id` INT NOT NULL ,
  `products_price` DECIMAL NOT NULL ,
  `qty` SMALLINT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_cpm_products` (`products_id` ASC) ,
  INDEX `fk_cpm_carts` (`cart_id` ASC) ,
  CONSTRAINT `fk_cpm_products`
    FOREIGN KEY (`products_id` )
    REFERENCES `ecommerce`.`products` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cpm_carts`
    FOREIGN KEY (`cart_id` )
    REFERENCES `ecommerce`.`carts` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
