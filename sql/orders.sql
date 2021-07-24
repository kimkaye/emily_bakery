CREATE TABLE `emily_bakery`.`orders` (
                                         `id` INT NOT NULL AUTO_INCREMENT,
                                         `user_id` INT NULL,
                                         `total_price` FLOAT NULL,
                                         `delivery_address` TINYTEXT NULL,
                                         `delivery_date` DATE NULL,
                                         `delivery_time` TIME NULL,
                                         `with_delivery` TINYINT NULL,
                                         `city` VARCHAR(255) NULL,
                                         `branch` VARCHAR(255) NULL,
                                         `created_at`  DATETIME NULL DEFAULT NOW(),
                                         PRIMARY KEY (`id`));