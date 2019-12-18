DROP TABLE IF EXISTS wwi_contact;
DROP TABLE IF EXISTS wwi_reviews;
DROP TABLE IF EXISTS wwi_users;

CREATE TABLE `wwi_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `address` varchar(45) NOT NULL,
  `city` varchar(45) NOT NULL,
  `postal` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `wwi_reviews` (
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `stars` int(1) NOT NULL,
  `description` varchar(200) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`product_id`,`user_id`),
  KEY `user_id_idx` (`user_id`),
  CONSTRAINT `product_id` FOREIGN KEY (`product_id`) REFERENCES `stockitems` (`StockItemID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `wwi_users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `wwi_contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id_idx` (`uid`),
  KEY `supplier_id_idx` (`supplier_id`),
  CONSTRAINT `supplier_id` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`SupplierID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `uid` FOREIGN KEY (`uid`) REFERENCES `wwi_users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

