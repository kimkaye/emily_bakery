CREATE TABLE `emily_bakery`.`contacts` (
                                                   `id` INT NOT NULL AUTO_INCREMENT,
                                                   `name` VARCHAR(45) NOT NULL,
                                                   `email` VARCHAR(255) NOT NULL,
                                                   `message` TINYTEXT NOT NULL,
                                                   PRIMARY KEY (`id`),
                                                   UNIQUE INDEX `id_UNIQUE` (`id` ASC));
