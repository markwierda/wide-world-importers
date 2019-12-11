CREATE TABLE `wideworldimporters`.`wwi_reviews` (
  `product_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `stars` INT(1) NOT NULL,
  `description` VARCHAR(200) NOT NULL,
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
