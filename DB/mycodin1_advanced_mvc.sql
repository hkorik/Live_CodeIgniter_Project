SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

USE `mycodin1_advanced_mvc` ;

-- -----------------------------------------------------
-- Table `mycodin1_advanced_mvc`.`users`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mycodin1_advanced_mvc`.`users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `first_name` VARCHAR(255) NULL ,
  `last_name` VARCHAR(255) NULL ,
  `email` VARCHAR(255) NULL ,
  `password` VARCHAR(255) NULL ,
  `description` VARCHAR(100) NULL ,
  `user_level` TINYINT(1) NULL ,
  `created_at` DATETIME NULL ,
  `updated_at` DATETIME NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `email` (`email` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mycodin1_advanced_mvc`.`messages`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mycodin1_advanced_mvc`.`messages` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `user_id` INT(11) NOT NULL ,
  `profile_user_id` INT(11) NOT NULL ,
  `message` LONGTEXT NULL ,
  `created_at` DATETIME NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_posts_users1_idx` (`user_id` ASC) ,
  INDEX `fk_messages_users2_idx` (`profile_user_id` ASC) ,
  CONSTRAINT `fk_posts_users1`
    FOREIGN KEY (`user_id` )
    REFERENCES `mycodin1_advanced_mvc`.`users` (`id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_messages_users2`
    FOREIGN KEY (`profile_user_id` )
    REFERENCES `mycodin1_advanced_mvc`.`users` (`id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mycodin1_advanced_mvc`.`comments`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mycodin1_advanced_mvc`.`comments` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `user_id` INT(11) NOT NULL ,
  `message_id` INT(11) NOT NULL ,
  `comment` LONGTEXT NULL ,
  `created_at` DATETIME NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_messages_users1_idx` (`user_id` ASC) ,
  INDEX `fk_replies_posts1_idx` (`message_id` ASC) ,
  CONSTRAINT `fk_messages_users1`
    FOREIGN KEY (`user_id` )
    REFERENCES `mycodin1_advanced_mvc`.`users` (`id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_replies_posts1`
    FOREIGN KEY (`message_id` )
    REFERENCES `mycodin1_advanced_mvc`.`messages` (`id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `mycodin1_advanced_mvc` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
