DROP TABLE IF EXISTS wwi_contact;
DROP TABLE IF EXISTS wwi_reviews;
DROP TABLE IF EXISTS wwi_users;

CREATE TABLE IF NOT EXISTS `wideworldimporters`.`wwi_users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `address` VARCHAR(45) NOT NULL,
  `city` VARCHAR(45) NOT NULL,
  `postal` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC)
);

CREATE TABLE IF NOT EXISTS `wideworldimporters`.`wwi_contact` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `supplier_id` INT(11) NOT NULL,
  `message` TEXT NOT NULL,
  `wwi_users_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`, `wwi_users_id`),
  INDEX `user_id_idx` (`user_id` ASC),
  INDEX `fk_wwi_contact_wwi_users1_idx` (`wwi_users_id` ASC),
  CONSTRAINT `fk_wwi_contact_wwi_users1`
    FOREIGN KEY (`wwi_users_id`)
    REFERENCES `wideworldimporters`.`wwi_users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
);

CREATE TABLE IF NOT EXISTS `wideworldimporters`.`wwi_reviews` (
  `product_id` INT(11) NOT NULL,
  `user_id` INT(11) NOT NULL,
  `stars` INT(1) NOT NULL,
  `description` VARCHAR(200) NOT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`product_id`, `user_id`),
  INDEX `user_id_idx` (`user_id` ASC),
  CONSTRAINT `product_id`
    FOREIGN KEY (`product_id`)
    REFERENCES `wideworldimporters`.`stockitems` (`StockItemID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `user_id`
    FOREIGN KEY (`user_id`)
    REFERENCES `wideworldimporters`.`wwi_users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
);
