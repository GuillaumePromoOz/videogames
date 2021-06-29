CREATE DATABASE IF NOT EXISTS `PLATFORMS` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `PLATFORMS`;

CREATE TABLE `REVIEW` (
  `title` VARCHAR(42),
  `content` VARCHAR(42),
  `author` VARCHAR(42),
  `publication_date` VARCHAR(42),
  `display_rating` VARCHAR(42),
  `gameplay_rating` VARCHAR(42),
  `lifetime_rating` VARCHAR(42),
  `name` VARCHAR(42),
  `user_name` VARCHAR(42),
  PRIMARY KEY (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*
CREATE TABLE `USER` (
  `user_name` VARCHAR(42),
  PRIMARY KEY (`user_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
*/

CREATE TABLE `VIDEOGAME` (
  `name` VARCHAR(42),
  `editor` VARCHAR(42),
  `name_1` VARCHAR(42),
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `PLATFORM` (
  `name` VARCHAR(42),
  `publisher` VARCHAR(42),
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ALTER TABLE `REVIEW` ADD FOREIGN KEY (`user_name`) REFERENCES `USER` (`user_name`);
ALTER TABLE `REVIEW` ADD FOREIGN KEY (`name`) REFERENCES `VIDEOGAME` (`name`);
ALTER TABLE `VIDEOGAME` ADD FOREIGN KEY (`name_1`) REFERENCES `PLATFORM` (`name`);