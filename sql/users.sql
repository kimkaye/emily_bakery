CREATE TABLE `emily_bakery`.`users` (
                                        `id` INT NOT NULL AUTO_INCREMENT,
                                        `username` VARCHAR(45) NOT NULL,
                                        `password` VARCHAR(255) NOT NULL,
                                        `name` VARCHAR(255) NOT NULL,
                                        `mail` VARCHAR(255) NOT NULL,
                                        `phone` VARCHAR(255) NOT NULL,
                                        `birth_year` INT NOT NULL,
                                        `is_admin` TINYINT NOT NULL DEFAULT 0,
                                        PRIMARY KEY (`id`));
