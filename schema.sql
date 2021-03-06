ALTER DATABASE yeticave
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;

USE yeticave;

CREATE TABLE `category` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`name` CHAR(50) NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `name` (`name`)
);

CREATE TABLE `user` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`registration_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`email` CHAR(50) NOT NULL,
	`name` CHAR(50) NOT NULL,
	`password_hash` CHAR(255) NOT NULL,
	`avatar` TEXT NOT NULL,
	`contacts` VARCHAR(500) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `lot` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`created_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`title` CHAR(50) NOT NULL,
	`description` TEXT NOT NULL,
	`image` TEXT NOT NULL,
	`cost` INT(10) UNSIGNED NOT NULL,
	`end_date` DATETIME NOT NULL,
	`step` MEDIUMINT(10) UNSIGNED NOT NULL,
	`favorite` SMALLINT(5) UNSIGNED NULL DEFAULT NULL,
	`author` INT(10) UNSIGNED NOT NULL,
	`winner` INT(10) UNSIGNED NULL DEFAULT NULL,
	`category` SMALLINT(5) UNSIGNED NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `title` (`title`),
	INDEX `description` (`description`(1000)),
	CONSTRAINT `FK_lot_user` FOREIGN KEY (`author`) REFERENCES `user` (`id`),
	CONSTRAINT `FK_lot_user_2` FOREIGN KEY (`winner`) REFERENCES `user` (`id`)
);

CREATE TABLE `bet` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`price` INT(10) UNSIGNED NOT NULL,
	`created_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`lot` INT(10) UNSIGNED NOT NULL,
	`author` INT(10) UNSIGNED NOT NULL,
	PRIMARY KEY (`id`),
	CONSTRAINT `FK_bet_lot` FOREIGN KEY (`lot`) REFERENCES `lot` (`id`),
	CONSTRAINT `FK_bet_user` FOREIGN KEY (`author`) REFERENCES `user` (`id`)
);