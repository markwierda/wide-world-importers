CREATE TABLE `wwi_reviews` (
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `stars` int(1) NOT NULL,
  `description` varchar(200) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date DEFAULT NULL,
  PRIMARY KEY (`product_id`,`user_id`),
  KEY `user_id_idx` (`user_id`),
  CONSTRAINT `product_id` FOREIGN KEY (`product_id`) REFERENCES `stockitems` (`StockItemID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `wwi_users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
);
