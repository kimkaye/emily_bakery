CREATE TABLE `emily_bakery`.`products` (
                                           `id` INT NOT NULL AUTO_INCREMENT,
                                           `product_name` VARCHAR(255) NULL,
                                           `product_price` FLOAT NULL,
                                           `product_img` TINYTEXT NULL,
                                           `category` ENUM('COOKIES', 'CAKES', 'PASTRIES', 'QUICHES') NULL,
                                           PRIMARY KEY (`id`));
