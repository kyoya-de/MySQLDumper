CREATE TABLE `User` (
  `id` INTEGER NOT NULL,
  `username` VARCHAR(64) NOT NULL,
  `password` VARCHAR(32) NOT NULL,
  `salt` VARCHAR(32) NOT NULL,
  `active` BOOLEAN NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  PRIMARY KEY(`id`)
);

CREATE TABLE `Role` (
  `id` INTEGER NOT NULL,
  `name` VARCHAR(64) NOT NULL,
  `role` VARCHAR(20) NOT NULL,
  PRIMARY KEY(`id`)
);
CREATE UNIQUE INDEX `UNIQ_F75B255457698A6A` ON `Role` (`role`);

CREATE TABLE `user_role` (
  `user_id` INTEGER NOT NULL,
  `role_id` INTEGER NOT NULL,
  PRIMARY KEY(`user_id`, `role_id`)
);
CREATE INDEX `IDX_2DE8C6A3A76ED395` ON `user_role` (`user_id`);
CREATE INDEX `IDX_2DE8C6A3D60322AC` ON `user_role` (`role_id`);

CREATE TABLE `UserDatabase` (
  `id` INTEGER NOT NULL,
  `driver` VARCHAR(32) NOT NULL,
  `user` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `host` VARCHAR(255) NOT NULL,
  `port` INTEGER NOT NULL,
  `unixSocket` VARCHAR(255) NOT NULL,
  `dbName` VARCHAR(255) NOT NULL,
  `charset` VARCHAR(255) NOT NULL,
  `path` CLOB NOT NULL,
  `msdUser_id` INTEGER DEFAULT NULL,
  PRIMARY KEY(`id`)
);
CREATE INDEX `IDX_45140F7AFA38390` ON `UserDatabase` (`msdUser_id`);

CREATE TABLE `DriverOption` (
  `id` INTEGER NOT NULL,
  `database_id` INTEGER DEFAULT NULL,
  `option` INTEGER NOT NULL,
  `value` VARCHAR(255) NOT NULL,
  PRIMARY KEY(`id`)
);
CREATE INDEX `IDX_4FA1FFCFF6801C70` ON `DriverOption` (`database_id`);
