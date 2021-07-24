CREATE TABLE `emily_bakery`.`products_order` (
                                                 `id` INT NOT NULL AUTO_INCREMENT,
                                                 `order_id` INT NOT NULL,
                                                 `product_id` INT NOT NULL,
                                                 `amount` INT NOT NULL,
                                                 `total_product_price` FLOAT NOT NULL,
                                                 PRIMARY KEY (`id`));
