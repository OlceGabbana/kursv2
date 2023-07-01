-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema kurs
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema kurs
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `kurs` DEFAULT CHARACTER SET utf8 ;
USE `kurs` ;

-- -----------------------------------------------------
-- Table `kurs`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kurs`.`users` (
  `id_user` INT NOT NULL AUTO_INCREMENT,
  `name_user` VARCHAR(45) NULL,
  `surn_user` VARCHAR(80) NULL,
  `fname_user` VARCHAR(80) NULL,
  `phone_user` VARCHAR(11) NULL,
  `e-mail_user` VARCHAR(100) NULL,
  `hash_pw_user` VARCHAR(150) NULL,
  `score_user` INT NULL DEFAULT 0,
  `role_user` ENUM('Администратор', 'Пользователь', 'Модератор') NULL DEFAULT 'Пользователь',
  PRIMARY KEY (`id_user`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kurs`.`dishes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kurs`.`dishes` (
  `id_dish` INT NOT NULL AUTO_INCREMENT,
  `name_dish` VARCHAR(100) NULL,
  `price_dish` DECIMAL(9,2) NULL,
  `file-path_dish` VARCHAR(80) NULL,
  `desc_dish` VARCHAR(300) NULL,
  PRIMARY KEY (`id_dish`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kurs`.`categories`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kurs`.`categories` (
  `id_category` INT NOT NULL AUTO_INCREMENT,
  `name_category` VARCHAR(45) NULL,
  PRIMARY KEY (`id_category`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kurs`.`dishes_has_categories`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kurs`.`dishes_has_categories` (
  `dishes_id_dish` INT NOT NULL,
  `categories_id_category` INT NOT NULL,
  PRIMARY KEY (`dishes_id_dish`, `categories_id_category`),
  INDEX `fk_dishes_has_categories_categories1_idx` (`categories_id_category` ASC) VISIBLE,
  INDEX `fk_dishes_has_categories_dishes_idx` (`dishes_id_dish` ASC) VISIBLE,
  CONSTRAINT `fk_dishes_has_categories_dishes`
    FOREIGN KEY (`dishes_id_dish`)
    REFERENCES `kurs`.`dishes` (`id_dish`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_dishes_has_categories_categories1`
    FOREIGN KEY (`categories_id_category`)
    REFERENCES `kurs`.`categories` (`id_category`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kurs`.`orders`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kurs`.`orders` (
  `id_order` INT NOT NULL AUTO_INCREMENT,
  `date_order` DATETIME(6) NULL,
  `sum_order` DECIMAL(9,2) NULL,
  `users_id_user` INT NOT NULL,
  PRIMARY KEY (`id_order`, `users_id_user`),
  INDEX `fk_orders_users1_idx` (`users_id_user` ASC) VISIBLE,
  CONSTRAINT `fk_orders_users1`
    FOREIGN KEY (`users_id_user`)
    REFERENCES `kurs`.`users` (`id_user`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kurs`.`orders_has_dishes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kurs`.`orders_has_dishes` (
  `orders_id_order` INT NOT NULL,
  `dishes_id_dish` INT NOT NULL,
  PRIMARY KEY (`orders_id_order`, `dishes_id_dish`),
  INDEX `fk_orders_has_dishes_dishes1_idx` (`dishes_id_dish` ASC) VISIBLE,
  INDEX `fk_orders_has_dishes_orders1_idx` (`orders_id_order` ASC) VISIBLE,
  CONSTRAINT `fk_orders_has_dishes_orders1`
    FOREIGN KEY (`orders_id_order`)
    REFERENCES `kurs`.`orders` (`id_order`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_orders_has_dishes_dishes1`
    FOREIGN KEY (`dishes_id_dish`)
    REFERENCES `kurs`.`dishes` (`id_dish`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kurs`.`reservations`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kurs`.`reservations` (
  `id_reservation` INT NOT NULL AUTO_INCREMENT,
  `date_reservation` DATE NULL,
  `time_begin_reservation` TIME NULL,
  `time_end_reservation` TIME NULL,
  PRIMARY KEY (`id_reservation`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kurs`.`users_has_reservations`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kurs`.`users_has_reservations` (
  `users_id_user` INT NOT NULL,
  `reservations_id_reservation` INT NOT NULL,
  PRIMARY KEY (`users_id_user`, `reservations_id_reservation`),
  INDEX `fk_users_has_reservations_reservations1_idx` (`reservations_id_reservation` ASC) VISIBLE,
  INDEX `fk_users_has_reservations_users1_idx` (`users_id_user` ASC) VISIBLE,
  CONSTRAINT `fk_users_has_reservations_users1`
    FOREIGN KEY (`users_id_user`)
    REFERENCES `kurs`.`users` (`id_user`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_has_reservations_reservations1`
    FOREIGN KEY (`reservations_id_reservation`)
    REFERENCES `kurs`.`reservations` (`id_reservation`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kurs`.`tables`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kurs`.`tables` (
  `id_table` INT NOT NULL AUTO_INCREMENT,
  `sits_table` INT NULL,
  `status_table` ENUM('Занято', 'Свободно') NULL DEFAULT 'Свободно',
  `price_hour_table` DECIMAL(9,2) NULL,
  `reservations_id_reservation` INT NOT NULL,
  PRIMARY KEY (`id_table`, `reservations_id_reservation`),
  INDEX `fk_tables_reservations1_idx` (`reservations_id_reservation` ASC) VISIBLE,
  CONSTRAINT `fk_tables_reservations1`
    FOREIGN KEY (`reservations_id_reservation`)
    REFERENCES `kurs`.`reservations` (`id_reservation`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
