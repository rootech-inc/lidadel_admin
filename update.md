###### **DONE**
### DONE bookings table update
``ALTER TABLE `events_booking` CHANGE `payment` `payment` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL, CHANGE `payment_method` `payment_method` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL, CHANGE `sits` `sits` INT(11) NULL, CHANGE `special_request` `special_request` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL;``

### DONE tours table update
``ALTER TABLE `tours` CHANGE `description` `overview` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;``
``ALTER TABLE `tours` ADD `country` VARCHAR(20) NULL DEFAULT '' AFTER `eob`, ADD `city` VARCHAR(20) NULL AFTER `country`, ADD `type` VARCHAR(20) NULL AFTER `city`, ADD `group_size` INT NULL AFTER `type`;``
### DONE new table highlights
``CREATE TABLE `lisaavrb_tnt`.`highlights` ( `id` INT NOT NULL AUTO_INCREMENT , `event` TEXT NOT NULL , `light` TEXT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;``

### PENDING create user table
``create table users(id int, username text null, password text null); create unique index users_id_uindex on users (id); alter table users
add constraint users_pk
primary key (id); alter table users modify id int auto_increment;``