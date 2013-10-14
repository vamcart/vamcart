SET SQL_MODE='';
SET SQL_BIG_SELECTS=1;
SET NAMES 'utf8';

DROP TABLE IF EXISTS configuration_groups;
CREATE TABLE `configuration_groups` (
  `id` int(10) auto_increment,
  `key` varchar(255) collate utf8_unicode_ci,
  `name` varchar(255) collate utf8_unicode_ci,
  `description` varchar(255) collate utf8_unicode_ci,
  `group_icon` varchar(255) collate utf8_unicode_ci,
  `visible` varchar(255) collate utf8_unicode_ci,
  `sort_order` varchar(255) collate utf8_unicode_ci,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `configuration_groups` (`id`, `key`, `name`, `description`, `group_icon`, `visible`, `sort_order`) VALUES 
(1, 'main', 'Main','','cus-application','1','1'),
(2, 'cache', 'Caching','','cus-compress','1','2'),
(3, 'email', 'Email Settings','','cus-email','1','3');

DROP TABLE IF EXISTS configurations;
CREATE TABLE `configurations` (
  `id` int(10) auto_increment,
  `configuration_group_id` int(10),
  `key` varchar(255) collate utf8_unicode_ci,
  `value` varchar(255) collate utf8_unicode_ci,
  `type` varchar(255) collate utf8_unicode_ci,
  `options` varchar(255) collate utf8_unicode_ci,
  `name` varchar(255) collate utf8_unicode_ci,
  `description` varchar(255) collate utf8_unicode_ci,
  `sort_order` varchar(255) collate utf8_unicode_ci,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `configurations` (`id`, `configuration_group_id`, `key`, `value`, `type`, `options`, `name`, `description`, `sort_order`) VALUES 
(1,'1','SITE_NAME', 'VamCart','text', '', 'Site Name','','1'),
(2,'1','TELEPHONE', '+1 800 123-45-67','text', '', 'Telephone','','2'),
(3,'1','FACEBOOK', 'http://facebook.com/your-account','text', '', 'Facebook','','3'),
(4,'1','TWITTER', 'http://twitter.com/your-account','text', '', 'Twitter','','4'),
(5,'1','GOOGLE', 'http://plus.google.com/your-account','text', '', 'Google+','','5'),
(6,'1','METADATA', '<meta name="generator" content="Bluefish 2.2.2" />','textarea', '', 'Metadata','','6'),
(7,'1','URL_EXTENSION', '.html','text', '', 'URL Extension','','7'),
(8,'1','GD_LIBRARY', '1','select', '0,1', 'GD Library Enabled','','8'),
(9,'1','THUMBNAIL_SIZE', '470','text', '', 'Image Thumbnail Size','','9'),
(10,'1','GOOGLE_ANALYTICS', '','text', '', 'Google Analytics ID','','10'),
(11,'1','YANDEX_METRIKA', '','text', '', 'Yandex.Metrika ID','','11'),
(12,'1','PRODUCTS_PER_PAGE', '20','text', '', 'Products Per Page','','12'),
(13,'2','CACHE_TIME', '3600','text', '', 'Cache Time in Seconds','','13'),
(14,'3','SEND_EXTRA_EMAIL', 'vam@test.com','text', '', 'Send extra order emails to','','14'),
(15,'3','NEW_ORDER_FROM_EMAIL', 'vam@test.com','text', '', 'New Order: From','','15'),
(16,'3','NEW_ORDER_FROM_NAME', 'VamCart','text', '', 'New Order: From Name','','16'),
(17,'3','NEW_ORDER_STATUS_FROM_EMAIL', 'vam@test.com','text', '', 'New Order Status: From','','17'),
(18,'3','NEW_ORDER_STATUS_FROM_NAME', 'VamCart','text', '', 'New Order Status: From Name','','18'),
(19,'3','SEND_CONTACT_US_EMAIL', 'vam@test.com','text', '', 'Send contact us emails to','','19'),
(20,'1','AJAX_ENABLE', '0', 'select', '0,1', 'Ajax Enable', '', '20');

DROP TABLE IF EXISTS contents;
CREATE TABLE `contents` (
  `id` int(10) auto_increment,
  `parent_id` int(10),
  `order` int(10),
  `hierarchy` int(10),
  `content_type_id` int(10),
  `template_id` int(10),
  `default` tinyint(4),
  `alias` varchar(255) collate utf8_unicode_ci,
  `head_data` text collate utf8_unicode_ci,
  `active` tinyint(4),
  `show_in_menu` tinyint(4),
  `yml_export` tinyint(4),
  `viewed` int(10),
  `created` datetime,
  `modified` datetime,
 PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `contents` (`id`, `parent_id`, `order`, `hierarchy`, `content_type_id`, `template_id`, `default`, `alias`, `head_data`, `active`, `show_in_menu`, `yml_export`, `viewed`, `created`, `modified`) VALUES 
(35, 0, 1, 0, 3, 1, 1, 'home-page', '', 1, 1, 0, 0, '2009-07-28 21:11:18', '2009-09-12 12:30:17'),
(36, 0, 3, 0, 1, 1, 0, 'horns', '', 1, 1, 0, 0, '2009-07-28 21:11:49', '2009-08-01 14:56:05'),
(38, 36, 2, 0, 2, 1, 0, 'elk-horns', '', 1, 1, 0, 0, '2009-07-29 18:54:37', '2009-09-11 11:20:29'),
(39, 0, 2, 0, 1, 1, 0, 'hoofs', '', 1, 1, 0, 0, '2009-07-29 22:02:10', '2009-08-01 14:55:54'),
(44, 0, 4, 0, 1, 1, 0, 'information', '', 1, 0, 0, 0, '2009-07-30 15:34:48', '2009-07-30 15:35:02'),
(45, 44, 1, 0, 3, 1, 0, 'shipping--returns', '', 1, 1, 0, 0, '2009-07-30 15:36:30', '2009-08-06 14:53:16'),
(46, 44, 1, 0, 3, 1, 0, 'privacy-policy', '', 1, 1, 0, 0, '2009-07-30 15:36:54', '2009-07-30 15:37:09'),
(47, 44, 2, 0, 3, 1, 0, 'conditions-of-use', '', 1, 1, 0, 0, '2009-07-30 15:37:33', '2009-07-30 15:37:33'),
(48, 44, 3, 0, 3, 1, 0, 'contact-us', '', 1, 1, 0, 0, '2009-07-30 15:38:03', '2009-07-30 15:38:03'),
(49, -1, 5, 0, 3, 1, 0, 'cart-contents', '', 1, 1, 0, 0, '2009-07-30 20:40:14', '2009-08-09 16:23:47'),
(50, -1, 6, 0, 3, 1, 0, 'checkout', '', 1, 1, 0, 0, '2009-07-30 20:52:36', '2009-08-01 16:54:56'),
(51, -1, 5, 0, 3, 1, 0, 'confirmation', '', 1, 1, 0, 0, '2009-08-07 11:16:28', '2009-09-01 16:22:10'),
(53, -1, 5, 0, 3, 1, 0, 'success', '', 1, 1, 0, 0, '2009-08-07 11:58:21', '2009-08-15 16:00:40'),
(58, -1, 0, 0, 3, 1, 0, 'read-reviews', '', 1, 0, 0, 0, '2009-08-20 09:37:04', '2009-08-20 09:37:04'),
(59, -1, 0, 0, 3, 1, 0, 'create-review', '', 1, 0, 0, 0, '2009-08-20 09:37:04', '2009-08-20 09:37:04'),
(68, -1, 0, 0, 3, 1, 0, 'coupon-details', '', 1, 0, 0, 0, '2009-09-13 11:11:08', '2009-09-13 11:11:08'),
(69, 0, 5, 0, 1, 1, 0, 'news', '', 1, 0, 0, 0, '2009-11-10 20:18:22', '2009-11-10 20:18:22'),
(70, 0, 6, 0, 1, 1, 0, 'articles', '', 1, 0, 0, 0, '2009-11-10 20:18:45', '2009-11-10 20:18:45'),
(71, 69, 1, 0, 5, 1, 0, 'sample-news', '', 1, 1, 0, 0, '2009-11-10 20:20:08', '2009-11-10 20:20:08'),
(72, 70, 1, 0, 6, 1, 0, 'sample-article', '', 1, 1, 0, 0, '2009-11-10 20:20:51', '2009-11-10 20:20:51'),
(73, -1, 6, 0, 3, 1, 0, 'search-result', '', 1, 0, 0, 0, '2009-11-10 20:20:51', '2009-11-10 20:20:51');
INSERT INTO `contents` VALUES(87, -1, 7, 0, 3, 1, 0, 'register', '', 1, 0, 0, 106, '2012-08-19 00:00:00', '2012-08-19 21:18:34');
INSERT INTO `contents` VALUES(88, -1, 8, 0, 3, 1, 0, 'register-success', '', 1, 0, 0, 3, '2012-08-19 00:00:00', '2012-08-19 21:19:37');

INSERT INTO `contents` VALUES(89, -1, 7, 0, 3, 1, 0, 'account', '', 1, 0, 0, 106, '2012-08-19 00:00:00', '2012-08-19 21:18:34');
INSERT INTO `contents` VALUES(90, -1, 8, 0, 3, 1, 0, 'account_edit', '', 1, 0, 0, 3, '2012-08-19 00:00:00', '2012-08-19 21:19:37');
INSERT INTO `contents` VALUES(91, -1, 8, 0, 3, 1, 0, 'my_orders', '', 1, 0, 0, 3, '2012-08-19 00:00:00', '2012-08-19 21:19:37');
INSERT INTO `contents` VALUES(92, -1, 8, 0, 3, 1, 0, 'address_book', '', 1, 0, 0, 3, '2012-08-19 00:00:00', '2012-08-19 21:19:37');

DROP TABLE IF EXISTS content_categories;
CREATE TABLE `content_categories` (
  `id` int(10) auto_increment,
  `content_id` int(10),
  `extra` varchar(1) collate utf8_unicode_ci,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `content_categories` (`id`, `content_id`, `extra`) VALUES 
(8, 36, '1'),
(9, 39, '1'),
(12, 51, '1');

DROP TABLE IF EXISTS content_descriptions;
CREATE TABLE `content_descriptions` (
  `id` int(10) auto_increment,
  `content_id` int(10),
  `language_id` int(10),
  `name` varchar(255) collate utf8_unicode_ci,
  `description` text collate utf8_unicode_ci,
  `meta_title` varchar(255) collate utf8_unicode_ci,
  `meta_description` varchar(255) collate utf8_unicode_ci,
  `meta_keywords` varchar(255) collate utf8_unicode_ci,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `content_descriptions` (`id`, `content_id`, `language_id`, `name`, `description`, `meta_title`, `meta_description`, `meta_keywords`) VALUES 
(179, 44, 1, 'Information', 'Information about our site can be found by visiting the following links:','', '', ''),
(180, 44, 2, 'Информация', 'Информация о магазине доступна по следующим ссылкам:','', '', ''),
(185, 46, 1, 'Payment methods', 'Enter your payment methods on this page.','', '', ''),
(186, 46, 2, 'Оплата', 'Укажите информацию о способах оплаты товара на данной странице.','', '', ''),
(187, 47, 1, 'About Us', 'About us page.','', '', ''),
(188, 47, 2, 'О магазине', 'Информация о магазине.','', '', ''),
(189, 48, 1, 'Contact Us', 'Enter your contact information on this page.\r\n{contact_us}','', '', ''),
(190, 48, 2, 'Контакты', 'Контактная информация.\r\n{contact_us}','', '', ''),
(225, 39, 1, 'Hoofs', 'Description','', '', ''),
(226, 39, 2, 'Копыта', 'Описание категории!','', '', ''),
(227, 36, 1, 'Horns', 'Description','', '', ''),
(228, 36, 2, 'Рога', 'Рога оленей, лосей и других животных!','', '', ''),
(241, 50, 1, 'Checkout', '{checkout}','', '', ''),
(242, 50, 2, 'Оформление', '{checkout}','', '', ''),
(245, 45, 1, 'Shipping and Returns', 'Enter your Shipping & Return information on this page.','', '', ''),
(246, 45, 2, 'Доставка', 'Укажите информацию о способах доставки товара на данной странице.','', '', ''),
(269, 49, 1, 'Cart Contents', '{shopping_cart}','', '', ''),
(270, 49, 2, 'Корзина', '{shopping_cart}','', '', ''),
(313, 53, 1, 'Thank You', 'Thanks for shopping!','', '', ''),
(314, 53, 2, 'Спасибо', 'Спасибо за покупки!','', '', ''),
(323, 58, 1, 'Read Reviews', '{module alias=''reviews'' action=''display''}','', '', ''),
(324, 58, 2, 'Читать отзывы', '{module alias=''reviews'' action=''display''}','', '', ''),
(325, 59, 1, 'Write Review', '{module alias=''reviews'' action=''create''}','', '', ''),
(326, 59, 2, 'Добавить отзыв', '{module alias=''reviews'' action=''create''}','', '', ''),
(359, 51, 1, 'Confirmation', '{payment}\r\n{shipping}\r\n\r\n<h2>{lang}Cart Contents{/lang}</h2>\r\n{shopping_cart template=''payment-view-cart''}','', '', ''),
(360, 51, 2, 'Подтверждение заказа', '{payment}\r\n{shipping}\r\n\r\n<h2>{lang}Cart Contents{/lang}</h2>\r\n{shopping_cart template=''payment-view-cart''}','', '', ''),
(385, 38, 1, 'Elk Horns', 'Product description.','', '', ''),
(386, 38, 2, 'Рога лося', 'Дешевле не найдёте, отличные лосиные рога.','', '', ''),
(391, 35, 1, 'Home', '<a href=\"{base_path}/admin/\">Click here to go to the admin area.</a>\r\n{content_listing template=\'slider\' parent=\'36\' type=\'product\' limit=\'5\'}\r\n {content_listing template=\'subcategory-listing\' parent=\'0\' type=\'category\' limit=\'3\'}\r\n{content_listing template=\'featured-products\' parent=\'36\' type=\'product\' limit=\'3\'}','', '', ''),
(392, 35, 2, 'Главная страница', '<a href=\"{base_path}/admin/\">Вход в админку.</a>\r\n{content_listing template=\'slider\' parent=\'36\' type=\'product\' limit=\'5\'}\r\n{content_listing template=\'subcategory-listing\' parent=\'0\' type=\'category\' limit=\'3\'}\r\n{content_listing template=\'featured-products\' parent=\'36\' type=\'product\' limit=\'3\'}','', '', ''),
(393, 68, 1, 'Voucher Details', '{module alias=''coupons'' action=''show_info''}','', '', ''),
(394, 68, 2, 'Информация о купоне', '{module alias=''coupons'' action=''show_info''}','', '', ''),
(395, 69, 1, 'News', '', '', '', ''),
(396, 69, 2, 'Новости', '', '', '', ''),
(397, 70, 1, 'Articles', '', '', '', ''),
(398, 70, 2, 'Статьи', '', '', '', ''),
(399, 71, 1, 'News heading', 'News content','', '', ''),
(400, 71, 2, 'Заголовок новости', 'Текст новости','', '', ''),
(401, 72, 1, 'Article', 'Description','', '', ''),
(402, 72, 2, 'Статья', 'Текст статьи','', '', ''),
(403, 73, 1, 'Search results', '{search_result}','', '', ''),
(404, 73, 2, 'Результаты поиска', '{search_result}','', '', '');
INSERT INTO `content_descriptions` VALUES(515, 87, 1, 'Register', '{registration_form}', '', '', '');
INSERT INTO `content_descriptions` VALUES(516, 87, 2, 'Регистрация', '{registration_form}', '', '', '');
INSERT INTO `content_descriptions` VALUES(517, 88, 1, 'Register success', 'Thak you for registration', '', '', '');
INSERT INTO `content_descriptions` VALUES(518, 88, 2, 'Успешная регистрация', 'Благодарим Вас за регистрацию в нашем магазине!', '', '', '');

INSERT INTO `content_descriptions` VALUES(519, 89, 1, 'Account', '{if $smarty.session.Customer.customer_id}\r\n<ul>\r\n  <li><a href="{base_path}/customer/account_edit.html">{lang}Account Edit{/lang}</a></li>\r\n  <li><a href="{base_path}/customer/address_book.html">{lang}Address Book{/lang}</a></li>\r\n  <li><a href="{base_path}/customer/my_orders.html">{lang}My Orders{/lang}</a></li>\r\n</ul>\r\n{else}\r\n{lang}Permission Denied.{/lang}\r\n{login_box}\r\n{/if}', '', '', '');
INSERT INTO `content_descriptions` VALUES(520, 89, 2, 'Личный кабинет', '{if $smarty.session.Customer.customer_id}\r\n<ul>\r\n  <li><a href="{base_path}/customer/account_edit.html">{lang}Account Edit{/lang}</a></li>\r\n  <li><a href="{base_path}/customer/address_book.html">{lang}Address Book{/lang}</a></li>\r\n  <li><a href="{base_path}/customer/my_orders.html">{lang}My Orders{/lang}</a></li>\r\n</ul>\r\n{else}\r\n{lang}Permission Denied.{/lang}\r\n{login_box}\r\n{/if}', '', '', '');
INSERT INTO `content_descriptions` VALUES(521, 90, 1, 'Account Edit', '{account_edit}', '', '', '');
INSERT INTO `content_descriptions` VALUES(522, 90, 2, 'Редактирование данных', '{account_edit}', '', '', '');

INSERT INTO `content_descriptions` VALUES(523, 91, 1, 'My Orders', '{my_orders}', '', '', '');
INSERT INTO `content_descriptions` VALUES(524, 91, 2, 'Мои заказы', '{my_orders}', '', '', '');

INSERT INTO `content_descriptions` VALUES(525, 92, 1, 'Address Book', '{address_book}', '', '', '');
INSERT INTO `content_descriptions` VALUES(526, 92, 2, 'Адресная книга', '{address_book}', '', '', '');

DROP TABLE IF EXISTS content_images;
CREATE TABLE `content_images` (
  `id` int(10) auto_increment,
  `content_id` int(10),
  `order` int(10),
  `image` varchar(255) collate utf8_unicode_ci,
  `created` datetime,
  `modified` datetime,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS content_links;
CREATE TABLE `content_links` (
  `id` int(10) auto_increment,
  `content_id` int(10),
  `url` varchar(255) collate utf8_unicode_ci,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS content_pages;
CREATE TABLE `content_pages` (
  `id` int(10) auto_increment,
  `content_id` int(10),
  `extra` varchar(1) collate utf8_unicode_ci,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `content_pages` (`id`, `content_id`, `extra`) VALUES 
(23, 35, '1'),
(24, 36, '1'),
(25, 44, '1'),
(26, 45, '1'),
(27, 46, '1'),
(28, 47, '1'),
(29, 48, '1'),
(30, 49, '1'),
(31, 50, '1'),
(32, 51, '1'),
(33, 53, '1'),
(34, 73, '1');
INSERT INTO `content_pages` VALUES(35, 87, '1');
INSERT INTO `content_pages` VALUES(36, 88, '1');

DROP TABLE IF EXISTS content_products;
CREATE TABLE `content_products` (
  `id` int(10) auto_increment,
  `content_id` int(10),
  `stock` int(10),
  `model` varchar(255) collate utf8_unicode_ci,
  `price` double,
  `tax_id` int(10),
  `weight` double,
  `moq` int(8) DEFAULT '1' COMMENT 'Minimum order quantity',
  `pf` int(8) DEFAULT '1' COMMENT 'Price For',
  `ordered` int(10),
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `content_products` (`id`, `content_id`, `stock`, `model`, `price`, `tax_id`, `weight`, `moq`, `pf`, `ordered`) VALUES 
(16, 37, 12, '123456', 10.99, 2, 0, 1, 1, 0),
(17, 38, 22, 'sample', 4.95, 2, 3, 1, 1, 0);

DROP TABLE IF EXISTS content_product_prices;
CREATE TABLE IF NOT EXISTS `content_product_prices` (
  `id` int(10) AUTO_INCREMENT,
  `content_product_id` int(10),
  `quantity` int(10),
  `price` double,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `content_product_prices` (`id`, `content_product_id`, `quantity`, `price`) VALUES
(1, 16, 5, 10.50);

DROP TABLE IF EXISTS content_news;
CREATE TABLE `content_news` (
  `id` int(10) auto_increment,
  `content_id` int(1),
  `extra` varchar(1) collate utf8_unicode_ci,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `content_news` (`id`, `content_id`, `extra`) VALUES 
(1, 69, '1'),
(2, 71, '1');

DROP TABLE IF EXISTS content_articles;
CREATE TABLE `content_articles` (
  `id` int(10) auto_increment,
  `content_id` int(1),
  `extra` varchar(1) collate utf8_unicode_ci,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `content_articles` (`id`, `content_id`, `extra`) VALUES 
(1, 70, '1'),
(2, 72, '1');

DROP TABLE IF EXISTS content_types;
CREATE TABLE `content_types` (
  `id` int(10) auto_increment,
  `template_type_id` tinyint(4),
  `name` varchar(255) collate utf8_unicode_ci,
  `type` varchar(255) collate utf8_unicode_ci,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `content_types` (`id`, `template_type_id`, `name`, `type`) VALUES 
(1, 4, 'category', 'ContentCategory'),
(2, 3, 'product', 'ContentProduct'),
(3, 2, 'page', 'ContentPage'),
(4, 0, 'link', 'ContentLink'),
(5, 5, 'news', 'ContentNews'),
(6, 6, 'article', 'ContentArticle'),
(7, 7, 'downloadable', 'ContentDownloadable');

DROP TABLE IF EXISTS `content_downloadables`;
CREATE TABLE IF NOT EXISTS `content_downloadables` (
  `id` int(10) AUTO_INCREMENT,
  `content_id` int(10),
  `filename` varchar(256),
  `filestorename` varchar(256),
  `price` double,
  `model` varchar(255),
  `tax_id` int(10),
  `order_status_id` int(10),
  `max_downloads` int(10) DEFAULT '0',
  `max_days_for_download` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `countries`;
CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `iso_code_2` char(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `iso_code_3` char(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_format` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `IDX_NAME` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=240 ;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `iso_code_2`, `iso_code_3`, `address_format`, `active`) VALUES
(1, 'Afghanistan', 'AF', 'AFG', '', 1),
(2, 'Albania', 'AL', 'ALB', '', 1),
(3, 'Algeria', 'DZ', 'DZA', '', 1),
(4, 'American Samoa', 'AS', 'ASM', '', 1),
(5, 'Andorra', 'AD', 'AND', '', 1),
(6, 'Angola', 'AO', 'AGO', '', 1),
(7, 'Anguilla', 'AI', 'AIA', '', 1),
(8, 'Antarctica', 'AQ', 'ATA', '', 1),
(9, 'Antigua and Barbuda', 'AG', 'ATG', '', 1),
(10, 'Argentina', 'AR', 'ARG', ':name\n:street_address\n:postcode :city\n:country', 1),
(11, 'Armenia', 'AM', 'ARM', '', 1),
(12, 'Aruba', 'AW', 'ABW', '', 1),
(13, 'Australia', 'AU', 'AUS', ':name\n:street_address\n:suburb :state_code :postcode\n:country', 1),
(14, 'Austria', 'AT', 'AUT', ':name\n:street_address\nA-:postcode :city\n:country', 1),
(15, 'Azerbaijan', 'AZ', 'AZE', '', 1),
(16, 'Bahamas', 'BS', 'BHS', '', 1),
(17, 'Bahrain', 'BH', 'BHR', '', 1),
(18, 'Bangladesh', 'BD', 'BGD', '', 1),
(19, 'Barbados', 'BB', 'BRB', '', 1),
(20, 'Belarus', 'BY', 'BLR', '', 1),
(21, 'Belgium', 'BE', 'BEL', ':name\n:street_address\nB-:postcode :city\n:country', 1),
(22, 'Belize', 'BZ', 'BLZ', '', 1),
(23, 'Benin', 'BJ', 'BEN', '', 1),
(24, 'Bermuda', 'BM', 'BMU', '', 1),
(25, 'Bhutan', 'BT', 'BTN', '', 1),
(26, 'Bolivia', 'BO', 'BOL', '', 1),
(27, 'Bosnia and Herzegowina', 'BA', 'BIH', '', 1),
(28, 'Botswana', 'BW', 'BWA', '', 1),
(29, 'Bouvet Island', 'BV', 'BVT', '', 1),
(30, 'Brazil', 'BR', 'BRA', ':name\n:street_address\n:state\n:postcode\n:country', 1),
(31, 'British Indian Ocean Territory', 'IO', 'IOT', '', 1),
(32, 'Brunei Darussalam', 'BN', 'BRN', '', 1),
(33, 'Bulgaria', 'BG', 'BGR', '', 1),
(34, 'Burkina Faso', 'BF', 'BFA', '', 1),
(35, 'Burundi', 'BI', 'BDI', '', 1),
(36, 'Cambodia', 'KH', 'KHM', '', 1),
(37, 'Cameroon', 'CM', 'CMR', '', 1),
(38, 'Canada', 'CA', 'CAN', ':name\n:street_address\n:city :state_code :postcode\n:country', 1),
(39, 'Cape Verde', 'CV', 'CPV', '', 1),
(40, 'Cayman Islands', 'KY', 'CYM', '', 1),
(41, 'Central African Republic', 'CF', 'CAF', '', 1),
(42, 'Chad', 'TD', 'TCD', '', 1),
(43, 'Chile', 'CL', 'CHL', ':name\n:street_address\n:city\n:country', 1),
(44, 'China', 'CN', 'CHN', ':name\n:street_address\n:postcode :city\n:country', 1),
(45, 'Christmas Island', 'CX', 'CXR', '', 1),
(46, 'Cocos (Keeling) Islands', 'CC', 'CCK', '', 1),
(47, 'Colombia', 'CO', 'COL', '', 1),
(48, 'Comoros', 'KM', 'COM', '', 1),
(49, 'Congo', 'CG', 'COG', '', 1),
(50, 'Cook Islands', 'CK', 'COK', '', 1),
(51, 'Costa Rica', 'CR', 'CRI', '', 1),
(52, 'Cote D''Ivoire', 'CI', 'CIV', '', 1),
(53, 'Croatia', 'HR', 'HRV', '', 1),
(54, 'Cuba', 'CU', 'CUB', '', 1),
(55, 'Cyprus', 'CY', 'CYP', '', 1),
(56, 'Czech Republic', 'CZ', 'CZE', '', 1),
(57, 'Denmark', 'DK', 'DNK', ':name\n:street_address\nDK-:postcode :city\n:country', 1),
(58, 'Djibouti', 'DJ', 'DJI', '', 1),
(59, 'Dominica', 'DM', 'DMA', '', 1),
(60, 'Dominican Republic', 'DO', 'DOM', '', 1),
(61, 'East Timor', 'TP', 'TMP', '', 1),
(62, 'Ecuador', 'EC', 'ECU', '', 1),
(63, 'Egypt', 'EG', 'EGY', '', 1),
(64, 'El Salvador', 'SV', 'SLV', '', 1),
(65, 'Equatorial Guinea', 'GQ', 'GNQ', '', 1),
(66, 'Eritrea', 'ER', 'ERI', '', 1),
(67, 'Estonia', 'EE', 'EST', '', 1),
(68, 'Ethiopia', 'ET', 'ETH', '', 1),
(69, 'Falkland Islands (Malvinas)', 'FK', 'FLK', '', 1),
(70, 'Faroe Islands', 'FO', 'FRO', '', 1),
(71, 'Fiji', 'FJ', 'FJI', '', 1),
(72, 'Finland', 'FI', 'FIN', ':name\n:street_address\nFIN-:postcode :city\n:country', 1),
(73, 'France', 'FR', 'FRA', ':name\n:street_address\n:postcode :city\n:country', 1),
(74, 'France, Metropolitan', 'FX', 'FXX', ':name\n:street_address\n:postcode :city\n:country', 1),
(75, 'French Guiana', 'GF', 'GUF', ':name\n:street_address\n:postcode :city\n:country', 1),
(76, 'French Polynesia', 'PF', 'PYF', ':name\n:street_address\n:postcode :city\n:country', 1),
(77, 'French Southern Territories', 'TF', 'ATF', ':name\n:street_address\n:postcode :city\n:country', 1),
(78, 'Gabon', 'GA', 'GAB', '', 1),
(79, 'Gambia', 'GM', 'GMB', '', 1),
(80, 'Georgia', 'GE', 'GEO', '', 1),
(81, 'Germany', 'DE', 'DEU', ':name\n:street_address\nD-:postcode :city\n:country', 1),
(82, 'Ghana', 'GH', 'GHA', '', 1),
(83, 'Gibraltar', 'GI', 'GIB', '', 1),
(84, 'Greece', 'GR', 'GRC', '', 1),
(85, 'Greenland', 'GL', 'GRL', ':name\n:street_address\nDK-:postcode :city\n:country', 1),
(86, 'Grenada', 'GD', 'GRD', '', 1),
(87, 'Guadeloupe', 'GP', 'GLP', '', 1),
(88, 'Guam', 'GU', 'GUM', '', 1),
(89, 'Guatemala', 'GT', 'GTM', '', 1),
(90, 'Guinea', 'GN', 'GIN', '', 1),
(91, 'Guinea-Bissau', 'GW', 'GNB', '', 1),
(92, 'Guyana', 'GY', 'GUY', '', 1),
(93, 'Haiti', 'HT', 'HTI', '', 1),
(94, 'Heard and McDonald Islands', 'HM', 'HMD', '', 1),
(95, 'Honduras', 'HN', 'HND', '', 1),
(96, 'Hong Kong', 'HK', 'HKG', ':name\n:street_address\n:city\n:country', 1),
(97, 'Hungary', 'HU', 'HUN', '', 1),
(98, 'Iceland', 'IS', 'ISL', ':name\n:street_address\nIS:postcode :city\n:country', 1),
(99, 'India', 'IN', 'IND', ':name\n:street_address\n:city-:postcode\n:country', 1),
(100, 'Indonesia', 'ID', 'IDN', ':name\n:street_address\n:city :postcode\n:country', 1),
(101, 'Iran', 'IR', 'IRN', '', 1),
(102, 'Iraq', 'IQ', 'IRQ', '', 1),
(103, 'Ireland', 'IE', 'IRL', ':name\n:street_address\nIE-:city\n:country', 1),
(104, 'Israel', 'IL', 'ISR', ':name\n:street_address\n:postcode :city\n:country', 1),
(105, 'Italy', 'IT', 'ITA', ':name\n:street_address\n:postcode-:city :state_code\n:country', 1),
(106, 'Jamaica', 'JM', 'JAM', '', 1),
(107, 'Japan', 'JP', 'JPN', ':name\n:street_address, :suburb\n:city :postcode\n:country', 1),
(108, 'Jordan', 'JO', 'JOR', '', 1),
(109, 'Kazakhstan', 'KZ', 'KAZ', '', 1),
(110, 'Kenya', 'KE', 'KEN', '', 1),
(111, 'Kiribati', 'KI', 'KIR', '', 1),
(112, 'Korea, North', 'KP', 'PRK', '', 1),
(113, 'Korea, South', 'KR', 'KOR', '', 1),
(114, 'Kuwait', 'KW', 'KWT', '', 1),
(115, 'Kyrgyzstan', 'KG', 'KGZ', '', 1),
(116, 'Laos', 'LA', 'LAO', '', 1),
(117, 'Latvia', 'LV', 'LVA', '', 1),
(118, 'Lebanon', 'LB', 'LBN', '', 1),
(119, 'Lesotho', 'LS', 'LSO', '', 1),
(120, 'Liberia', 'LR', 'LBR', '', 1),
(121, 'Libyan Arab Jamahiriya', 'LY', 'LBY', '', 1),
(122, 'Liechtenstein', 'LI', 'LIE', '', 1),
(123, 'Lithuania', 'LT', 'LTU', '', 1),
(124, 'Luxembourg', 'LU', 'LUX', ':name\n:street_address\nL-:postcode :city\n:country', 1),
(125, 'Macau', 'MO', 'MAC', '', 1),
(126, 'Macedonia', 'MK', 'MKD', '', 1),
(127, 'Madagascar', 'MG', 'MDG', '', 1),
(128, 'Malawi', 'MW', 'MWI', '', 1),
(129, 'Malaysia', 'MY', 'MYS', '', 1),
(130, 'Maldives', 'MV', 'MDV', '', 1),
(131, 'Mali', 'ML', 'MLI', '', 1),
(132, 'Malta', 'MT', 'MLT', '', 1),
(133, 'Marshall Islands', 'MH', 'MHL', '', 1),
(134, 'Martinique', 'MQ', 'MTQ', '', 1),
(135, 'Mauritania', 'MR', 'MRT', '', 1),
(136, 'Mauritius', 'MU', 'MUS', '', 1),
(137, 'Mayotte', 'YT', 'MYT', '', 1),
(138, 'Mexico', 'MX', 'MEX', ':name\n:street_address\n:postcode :city, :state_code\n:country', 1),
(139, 'Micronesia', 'FM', 'FSM', '', 1),
(140, 'Moldova', 'MD', 'MDA', '', 1),
(141, 'Monaco', 'MC', 'MCO', '', 1),
(142, 'Mongolia', 'MN', 'MNG', '', 1),
(143, 'Montserrat', 'MS', 'MSR', '', 1),
(144, 'Morocco', 'MA', 'MAR', '', 1),
(145, 'Mozambique', 'MZ', 'MOZ', '', 1),
(146, 'Myanmar', 'MM', 'MMR', '', 1),
(147, 'Namibia', 'NA', 'NAM', '', 1),
(148, 'Nauru', 'NR', 'NRU', '', 1),
(149, 'Nepal', 'NP', 'NPL', '', 1),
(150, 'Netherlands', 'NL', 'NLD', ':name\n:street_address\n:postcode :city\n:country', 1),
(151, 'Netherlands Antilles', 'AN', 'ANT', ':name\n:street_address\n:postcode :city\n:country', 1),
(152, 'New Caledonia', 'NC', 'NCL', '', 1),
(153, 'New Zealand', 'NZ', 'NZL', ':name\n:street_address\n:suburb\n:city :postcode\n:country', 1),
(154, 'Nicaragua', 'NI', 'NIC', '', 1),
(155, 'Niger', 'NE', 'NER', '', 1),
(156, 'Nigeria', 'NG', 'NGA', '', 1),
(157, 'Niue', 'NU', 'NIU', '', 1),
(158, 'Norfolk Island', 'NF', 'NFK', '', 1),
(159, 'Northern Mariana Islands', 'MP', 'MNP', '', 1),
(160, 'Norway', 'NO', 'NOR', ':name\n:street_address\nNO-:postcode :city\n:country', 1),
(161, 'Oman', 'OM', 'OMN', '', 1),
(162, 'Pakistan', 'PK', 'PAK', '', 1),
(163, 'Palau', 'PW', 'PLW', '', 1),
(164, 'Panama', 'PA', 'PAN', '', 1),
(165, 'Papua New Guinea', 'PG', 'PNG', '', 1),
(166, 'Paraguay', 'PY', 'PRY', '', 1),
(167, 'Peru', 'PE', 'PER', '', 1),
(168, 'Philippines', 'PH', 'PHL', '', 1),
(169, 'Pitcairn', 'PN', 'PCN', '', 1),
(170, 'Poland', 'PL', 'POL', ':name\n:street_address\n:postcode :city\n:country', 1),
(171, 'Portugal', 'PT', 'PRT', ':name\n:street_address\n:postcode :city\n:country', 1),
(172, 'Puerto Rico', 'PR', 'PRI', '', 1),
(173, 'Qatar', 'QA', 'QAT', '', 1),
(174, 'Reunion', 'RE', 'REU', '', 1),
(175, 'Romania', 'RO', 'ROM', '', 1),
(176, 'Russia', 'RU', 'RUS', ':name\n:street_address\n:postcode :city\n:country', 1),
(177, 'Rwanda', 'RW', 'RWA', '', 1),
(178, 'Saint Kitts and Nevis', 'KN', 'KNA', '', 1),
(179, 'Saint Lucia', 'LC', 'LCA', '', 1),
(180, 'Saint Vincent and the Grenadines', 'VC', 'VCT', '', 1),
(181, 'Samoa', 'WS', 'WSM', '', 1),
(182, 'San Marino', 'SM', 'SMR', '', 1),
(183, 'Sao Tome and Principe', 'ST', 'STP', '', 1),
(184, 'Saudi Arabia', 'SA', 'SAU', '', 1),
(185, 'Senegal', 'SN', 'SEN', '', 1),
(186, 'Seychelles', 'SC', 'SYC', '', 1),
(187, 'Sierra Leone', 'SL', 'SLE', '', 1),
(188, 'Singapore', 'SG', 'SGP', ':name\n:street_address\n:city :postcode\n:country', 1),
(189, 'Slovakia', 'SK', 'SVK', '', 1),
(190, 'Slovenia', 'SI', 'SVN', '', 1),
(191, 'Solomon Islands', 'SB', 'SLB', '', 1),
(192, 'Somalia', 'SO', 'SOM', '', 1),
(193, 'South Africa', 'ZA', 'ZAF', ':name\n:street_address\n:suburb\n:city\n:postcode :country', 1),
(194, 'South Georgia and the South Sandwich Islands', 'GS', 'SGS', '', 1),
(195, 'Spain', 'ES', 'ESP', ':name\n:street_address\n:postcode :city\n:country', 1),
(196, 'Sri Lanka', 'LK', 'LKA', '', 1),
(197, 'St. Helena', 'SH', 'SHN', '', 1),
(198, 'St. Pierre and Miquelon', 'PM', 'SPM', '', 1),
(199, 'Sudan', 'SD', 'SDN', '', 1),
(200, 'Suriname', 'SR', 'SUR', '', 1),
(201, 'Svalbard and Jan Mayen Islands', 'SJ', 'SJM', '', 1),
(202, 'Swaziland', 'SZ', 'SWZ', '', 1),
(203, 'Sweden', 'SE', 'SWE', ':name\n:street_address\n:postcode :city\n:country', 1),
(204, 'Switzerland', 'CH', 'CHE', ':name\n:street_address\n:postcode :city\n:country', 1),
(205, 'Syrian Arab Republic', 'SY', 'SYR', '', 1),
(206, 'Taiwan', 'TW', 'TWN', ':name\n:street_address\n:city :postcode\n:country', 1),
(207, 'Tajikistan', 'TJ', 'TJK', '', 1),
(208, 'Tanzania', 'TZ', 'TZA', '', 1),
(209, 'Thailand', 'TH', 'THA', '', 1),
(210, 'Togo', 'TG', 'TGO', '', 1),
(211, 'Tokelau', 'TK', 'TKL', '', 1),
(212, 'Tonga', 'TO', 'TON', '', 1),
(213, 'Trinidad and Tobago', 'TT', 'TTO', '', 1),
(214, 'Tunisia', 'TN', 'TUN', '', 1),
(215, 'Turkey', 'TR', 'TUR', '', 1),
(216, 'Turkmenistan', 'TM', 'TKM', '', 1),
(217, 'Turks and Caicos Islands', 'TC', 'TCA', '', 1),
(218, 'Tuvalu', 'TV', 'TUV', '', 1),
(219, 'Uganda', 'UG', 'UGA', '', 1),
(220, 'Ukraine', 'UA', 'UKR', '', 1),
(221, 'United Arab Emirates', 'AE', 'ARE', '', 1),
(222, 'United Kingdom', 'GB', 'GBR', ':name\n:street_address\n:city\n:postcode\n:country', 1),
(223, 'United States of America', 'US', 'USA', ':name\n:street_address\n:city :state_code :postcode\n:country', 1),
(224, 'United States Minor Outlying Islands', 'UM', 'UMI', '', 1),
(225, 'Uruguay', 'UY', 'URY', '', 1),
(226, 'Uzbekistan', 'UZ', 'UZB', '', 1),
(227, 'Vanuatu', 'VU', 'VUT', '', 1),
(228, 'Vatican City State (Holy See)', 'VA', 'VAT', '', 1),
(229, 'Venezuela', 'VE', 'VEN', '', 1),
(230, 'Vietnam', 'VN', 'VNM', '', 1),
(231, 'Virgin Islands (British)', 'VG', 'VGB', '', 1),
(232, 'Virgin Islands (U.S.)', 'VI', 'VIR', '', 1),
(233, 'Wallis and Futuna Islands', 'WF', 'WLF', '', 1),
(234, 'Western Sahara', 'EH', 'ESH', '', 1),
(235, 'Yemen', 'YE', 'YEM', '', 1),
(236, 'Yugoslavia', 'YU', 'YUG', '', 1),
(237, 'Zaire', 'ZR', 'ZAR', '', 1),
(238, 'Zambia', 'ZM', 'ZMB', '', 1),
(239, 'Zimbabwe', 'ZW', 'ZWE', '', 1);

DROP TABLE IF EXISTS country_zones;
CREATE TABLE `country_zones` (
  `id` int(10) auto_increment,
  `country_id` int(10),
  `geo_zone_id` int(11),
  `code` varchar(255) collate utf8_unicode_ci,
  `name` varchar(255) collate utf8_unicode_ci,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `country_zones` (`id`, `country_id`, `geo_zone_id`, `code`, `name`) VALUES 
(1, 223, 0, 'AK', 'Alaska'),
(2, 223, 0, 'AL', 'Alabama'),
(3, 223, 0, 'AS', 'American Samoa'),
(4, 223, 0, 'AR', 'Arkansas'),
(5, 223, 0, 'AZ', 'Arizona'),
(6, 223, 0, 'CA', 'California'),
(7, 223, 0, 'CO', 'Colorado'),
(8, 223, 0, 'CT', 'Connecticut'),
(9, 223, 0, 'DC', 'District of Columbia'),
(10, 223, 0, 'DE', 'Delaware'),
(11, 223, 0, 'FL', 'Florida'),
(12, 223, 0, 'GA', 'Georgia'),
(13, 223, 0, 'GU', 'Guam'),
(14, 223, 0, 'HI', 'Hawaii'),
(15, 223, 0, 'IA', 'Iowa'),
(16, 223, 0, 'ID', 'Idaho'),
(17, 223, 0, 'IL', 'Illinois'),
(18, 223, 0, 'IN', 'Indiana'),
(19, 223, 0, 'KS', 'Kansas'),
(20, 223, 0, 'KY', 'Kentucky'),
(21, 223, 0, 'LA', 'Louisiana'),
(22, 223, 0, 'MA', 'Massachusetts'),
(23, 223, 0, 'MD', 'Maryland'),
(24, 223, 0, 'ME', 'Maine'),
(25, 223, 0, 'MI', 'Michigan'),
(26, 223, 0, 'MN', 'Minnesota'),
(27, 223, 0, 'MO', 'Missouri'),
(28, 223, 0, 'MS', 'Mississippi'),
(29, 223, 0, 'MT', 'Montana'),
(30, 223, 0, 'NC', 'North Carolina'),
(31, 223, 0, 'ND', 'North Dakota'),
(32, 223, 0, 'NE', 'Nebraska'),
(33, 223, 0, 'NH', 'New Hampshire'),
(34, 223, 0, 'NJ', 'New Jersey'),
(35, 223, 0, 'NM', 'New Mexico'),
(36, 223, 0, 'NV', 'Nevada'),
(37, 223, 0, 'NY', 'New York'),
(38, 223, 0, 'MP', 'Northern Mariana Islands'),
(39, 223, 0, 'OH', 'Ohio'),
(40, 223, 0, 'OK', 'Oklahoma'),
(41, 223, 0, 'OR', 'Oregon'),
(42, 223, 0, 'PA', 'Pennsylvania'),
(43, 223, 0, 'PR', 'Puerto Rico'),
(44, 223, 0, 'RI', 'Rhode Island'),
(45, 223, 0, 'SC', 'South Carolina'),
(46, 223, 0, 'SD', 'South Dakota'),
(47, 223, 0, 'TN', 'Tennessee'),
(48, 223, 0, 'TX', 'Texas'),
(49, 223, 0, 'UM', 'U.S. Minor Outlying Islands'),
(50, 223, 0, 'UT', 'Utah'),
(51, 223, 0, 'VA', 'Virginia'),
(52, 223, 0, 'VI', 'Virgin Islands of the U.S.'),
(53, 223, 0, 'VT', 'Vermont'),
(54, 223, 0, 'WA', 'Washington'),
(55, 223, 0, 'WI', 'Wisconsin'),
(56, 223, 0, 'WV', 'West Virginia'),
(57, 223, 0, 'WY', 'Wyoming');

DROP TABLE IF EXISTS currencies;
CREATE TABLE `currencies` (
  `id` int(10) auto_increment,
  `active` tinyint(4) default '1',
  `default` tinyint(4) default '0',
  `name` varchar(255) collate utf8_unicode_ci,
  `code` varchar(3) collate utf8_unicode_ci,
  `symbol_left` varchar(24) collate utf8_unicode_ci,
  `symbol_right` varchar(24) collate utf8_unicode_ci,
  `decimal_point` char(1) collate utf8_unicode_ci,
  `thousands_point` char(1) collate utf8_unicode_ci,
  `decimal_places` char(1) collate utf8_unicode_ci,
  `value` float,
  `created` datetime,
  `modified` datetime,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `currencies` (`id`, `active`, `default`, `name`, `code`, `symbol_left`, `symbol_right`, `decimal_point`, `thousands_point`, `decimal_places`, `value`, `created`, `modified`) VALUES 
(1, 1, 1, 'US Dollar', 'USD', '$', '', '.', ',', '2', 1, '2009-07-15 11:39:15', '2009-07-15 13:08:23'),
(2, 1, 0, 'Рубль', 'RUR', '', 'руб.', '.', ',', '0.0312', 1, '2009-07-15 11:39:15', '2009-07-15 13:08:23'),
(3, 1, 0, 'Euro', 'EUR', '&euro;', '', '.', ',', '2', 0.7811, '2009-07-15 13:09:23', '2009-07-15 13:09:23');

DROP TABLE IF EXISTS defined_languages;
CREATE TABLE `defined_languages` (
  `id` int(10) auto_increment,
  `language_id` int(10),
  `key` varchar(255) collate utf8_unicode_ci,
  `value` text collate utf8_unicode_ci,
  `created` datetime,
  `modified` datetime,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `defined_languages` (`id`, `language_id`, `key`, `value`, `created`, `modified`) VALUES 
(1, 1, 'Cart Contents', 'Cart Contents', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(2, 2, 'Cart Contents', 'Содержимое корзины', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(3, 1, 'Categories', 'Categories', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(4, 2, 'Categories', 'Разделы', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(5, 1, 'Product', 'Product', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(6, 2, 'Product', 'Товар', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(7, 1, 'Price Ea.', 'Price Ea.', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(8, 2, 'Price Ea.', 'Цена / шт.', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(9, 1, 'Qty', 'Qty', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(10, 2, 'Qty', 'Количество', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(11, 1, 'Total', 'Total', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(12, 2, 'Total', 'Всего', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(13, 1, 'No Cart Items', 'No Cart Items', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(14, 2, 'No Cart Items', 'В корзине нет товара.', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(15, 1, 'Checkout', 'Checkout', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(16, 2, 'Checkout', 'Оформить', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(17, 1, 'Currency', 'Currency', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(18, 2, 'Currency', 'Валюта', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(19, 1, 'Go', 'Go', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(20, 2, 'Go', 'Продолжить', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(21, 1, 'Shopping Cart', 'Shopping Cart', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(22, 2, 'Shopping Cart', 'Корзина', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(23, 1, 'Shipping', 'Shipping', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(24, 2, 'Shipping', 'Доставка', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(25, 1, 'Language', 'Language', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(26, 2, 'Language', 'Язык', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(27, 1, 'Sub Categories', 'Sub Categories', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(28, 2, 'Sub Categories', 'Подкатегории', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(29, 1, 'Products in this Category', 'Products in this Category', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(30, 2, 'Products in this Category', 'Товары в данной категории', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(31, 1, 'Coupon Code', 'Coupon Code', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(32, 2, 'Coupon Code', 'Код купона', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(33, 1, 'Read Reviews', 'Read Reviews', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(34, 2, 'Read Reviews', 'Читать отзывы', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(35, 1, 'Write a Review', 'Write a Review', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(36, 2, 'Write a Review', 'Написать отзыв', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(37, 1, 'No reviews were found for this product.', 'No reviews were found for this product.', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(38, 2, 'No reviews were found for this product.', 'Нет отзывов для данного товара.', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(39, 1, 'Confirm Order', 'Confirm Order', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(40, 2, 'Confirm Order', 'Подтвердить заказ', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(41, 1, 'Billing Information', 'Billing Information', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(42, 2, 'Billing Information', 'Информация о покупателе', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(43, 1, 'Name', 'Name', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(44, 2, 'Name', 'Имя', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(45, 1, 'Address Line 1', 'Address Line 1', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(46, 2, 'Address Line 1', 'Адрес', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(47, 1, 'Address Line 2', 'Address Line 2', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(48, 2, 'Address Line 2', 'Доп. информация', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(49, 1, 'City', 'City', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(50, 2, 'City', 'Город', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(51, 1, 'State', 'State', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(52, 2, 'State', 'Регион', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(53, 1, 'Zipcode', 'Zipcode', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(54, 2, 'Zipcode', 'Почтовый индекс', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(55, 1, 'Shipping Information', 'Shipping Information', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(56, 2, 'Shipping Information', 'Информация о доставке', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(57, 1, 'Contact Information', 'Contact Information', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(58, 2, 'Contact Information', 'Контактная информация', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(59, 1, 'Email', 'Email', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(60, 2, 'Email', 'Email', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(61, 1, 'Phone', 'Phone', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(62, 2, 'Phone', 'Телефон', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(63, 1, 'Shipping Method', 'Shipping Method', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(64, 2, 'Shipping Method', 'Способы доставки', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(65, 1, 'Payment Method', 'Payment Method', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(66, 2, 'Payment Method', 'Способы оплаты', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(67, 1, 'Continue', 'Continue', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(68, 2, 'Continue', 'Продолжить', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(69, 1, 'No Items Found', 'No Items Found', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(70, 2, 'No Items Found', 'Товары не найдены.', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(71, 1, 'No Image', 'No Image', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(72, 2, 'No Image', 'Нет картинки', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(73, 1, 'Review', 'Review', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(74, 2, 'Review', 'Отзыв', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(75, 1, 'Submit', 'Submit', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(76, 2, 'Submit', 'Добавить', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(77, 1, 'News', 'News', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(78, 2, 'News', 'Новости', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(79, 1, 'Articles', 'Articles', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(80, 2, 'Articles', 'Статьи', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(81, 1, 'PHP Shopping Cart', 'PHP Shopping Cart', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(82, 2, 'PHP Shopping Cart', 'Скрипты интернет-магазина', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(83, 1, 'Model', 'Model', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(84, 2, 'Model', 'Артикул', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(85, 1, 'Price', 'Price', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(86, 2, 'Price', 'Стоимость', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(87, 1, 'Contact Us', 'Contact Us', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(88, 2, 'Contact Us', 'Обратная связь', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(89, 1, 'Your Name', 'Your Name', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(90, 2, 'Your Name', 'Ваше имя', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(91, 1, 'Your Email', 'Your Email', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(92, 2, 'Your Email', 'Ваш email', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(93, 1, 'Message', 'Message', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(94, 2, 'Message', 'Сообщение', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(95, 1, 'Send', 'Send', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(96, 2, 'Send', 'Отправить', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(97, 1, 'Different from billing address', 'Different from billing address', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(98, 2, 'Different from billing address', 'Нажмите, если адрес доставки и адрес покупателя различные', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(99, 1, 'Home', 'Home', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(100, 2, 'Home', 'Главная', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(101, 1, 'Process to Payment', 'Process to Payment', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(102, 2, 'Process to Payment', 'Перейти к оплате заказа', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(103, 1, 'Free Shipping', 'Free Shipping', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(104, 2, 'Free Shipping', 'Бесплатная доставка', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(105, 1, 'Flat Rate', 'Flat Rate', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(106, 2, 'Flat Rate', 'Курьерская доставка', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(107, 1, 'Per Item', 'Per Item', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(108, 2, 'Per Item', 'На единицу', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(109, 1, 'Table Based', 'Table Based', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(110, 2, 'Table Based', 'Табличный тариф', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(111, 1, 'In-store Pickup', 'In-store Pickup', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(112, 2, 'In-store Pickup', 'Самовывоз', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(113, 1, 'Credit Card', 'Credit Card', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(114, 2, 'Credit Card', 'Кредитная карточка', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(115, 1, 'Money Order Check', 'Money Order Check', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(116, 2, 'Money Order Check', 'Оплата наличными курьеру', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(117, 1, 'Kvitancia', 'Kvitancia', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(118, 2, 'Kvitancia', 'Оплата по квитанции СБ РФ', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(119, 1, 'Invoice', 'Invoice', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(120, 2, 'Invoice', 'Оплата по счёту', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(121, 1, 'Country', 'Country', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(122, 2, 'Country', 'Страна', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(123, 1, 'Print Order', 'Print Order', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(124, 2, 'Print Order', 'Распечатать квитанцию', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(125, 1, 'Company', 'Company', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(126, 2, 'Company', 'Компания', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(127, 1, 'Invoice', 'Invoice', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(128, 2, 'Invoice', 'Оплата по счёту', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(129, 1, 'Print Invoice', 'Print Invoice', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(130, 2, 'Print Invoice', 'Распечатать счёт', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(131, 1, 'Example', 'Example', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(132, 2, 'Example', 'Пример', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(133, 1, 'Phone', 'Phone', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(134, 2, 'Phone', 'Телефон', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(135, 1, 'Please agree to our policy.', 'Please agree to our policy.', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(136, 2, 'Please agree to our policy.', 'Нажимая кнопку "Продолжить", я подтверждаю свою дееспособность, даю согласие на обработку своих персональных данных.', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(137, 1, 'Terms & Conditions.', 'Terms & Conditions.', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(138, 2, 'Terms & Conditions.', 'Подробнее о защите персональной информации.', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(139, 1, 'All', 'All', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(140, 2, 'All', 'Все', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(141, 1, 'Pages', 'Pages', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(142, 2, 'Pages', 'Страницы', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(143, 1, 'Update', 'Update', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(144, 2, 'Update', 'Обновить', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(145, 1, 'Login', 'Login', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(146, 2, 'Login', 'Вход', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(147, 1, 'Search', 'Search', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(148, 2, 'Search', 'Поиск', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(149, 1, 'E-mail', 'E-mail', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(150, 2, 'E-mail', 'E-mail', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(151, 1, 'Password', 'Password', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(152, 2, 'Password', 'Пароль', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(153, 1, 'Registration', 'Registration', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(154, 2, 'Registration', 'Регистрация', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(155, 1, 'Name', 'Name', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(156, 2, 'Name', 'Имя', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(159, 1, 'Retype Password', 'Retype Password', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(160, 2, 'Retype Password', 'Повторите пароль', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(161, 1, 'Register', 'Register', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(162, 2, 'Register', 'Регистрация', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(163, 1, 'Logout', 'Logout', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(164, 2, 'Logout', 'Выход', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(165, 1, 'Also purchased', 'Also purchased', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(166, 2, 'Also purchased', 'Сопутствующие товары', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(167, 1, 'ZoneBased', 'ZoneBased', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(168, 2, 'ZoneBased', 'Зональный тариф', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(169, 1, 'Save', 'Save', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(170, 2, 'Save', 'Сохранить', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(171, 1, 'Account Edit', 'Account Edit', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(172, 2, 'Account Edit', 'Редактирование данных', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(173, 1, 'Address Book', 'Address Book', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(174, 2, 'Address Book', 'Адресная книга', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(175, 1, 'My Orders', 'My Orders', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(176, 2, 'My Orders', 'Мои заказы', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(177, 1, 'My Account', 'My Account', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(178, 2, 'My Account', 'Личный кабинет', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(179, 1, 'Order number', 'Order number', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(180, 2, 'Order number', 'Номер заказа', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(181, 1, 'Customer', 'Customer', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(182, 2, 'Customer', 'Покупатель', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(183, 1, 'Products', 'Products', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(184, 2, 'Products', 'Товары', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(185, 1, 'Order Comments', 'Order Comments', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(186, 2, 'Order Comments', 'Комментарии к заказу', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(187, 1, 'Quantity', 'Quantity', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(188, 2, 'Quantity', 'Количество', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(189, 1, 'Order Total', 'Order Total', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(190, 2, 'Order Total', 'Стоимость заказа', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(191, 1, 'Date', 'Date', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(192, 2, 'Date', 'Дата', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(193, 1, 'Sent To Customer', 'Sent To Customer', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(194, 2, 'Sent To Customer', 'Покупатель уведомлён', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(195, 1, 'Comment', 'Comment', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(196, 2, 'Comment', 'Комментарий', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(197, 1, 'Order Status', 'Order Status', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(198, 2, 'Order Status', 'Статус заказа', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(199, 1, 'Orders Not Found!', 'Orders Not Found!', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(200, 2, 'Orders Not Found!', 'Заказы не найдены!', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(201, 1, 'Permission Denied.', 'Permission Denied.', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(202, 2, 'Permission Denied.', 'Нет доступа.', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(203, 1, 'New Password', 'New Password', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(204, 2, 'New Password', 'Новый пароль', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(205, 1, 'Leave empty to use current password.', 'Leave empty to use current password.', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(206, 2, 'Leave empty to use current password.', 'Оставьте поле пустым, если Вы не хотите менять текущий пароль.', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(207, 1, 'Comparison', 'Comparison', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(208, 2, 'Comparison', 'Сравнение', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(209, 1, 'Remove', 'Remove', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(210, 2, 'Remove', 'Удалить', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(211, 1, 'Compare', 'Compare', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(212, 2, 'Compare', 'Сравнить', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(213, 1, 'Add to compare', 'Add to compare', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(214, 2, 'Add to compare', 'Сравнить', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(215, 1, 'Filter', 'Filter', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(216, 2, 'Filter', 'Фильтр', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(217, 1, 'Apply', 'Apply', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(218, 2, 'Apply', 'Применить', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(219, 1, 'Reset', 'Reset', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(220, 2, 'Reset', 'Сбросить', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(221, 1, 'Information', 'Information', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(222, 2, 'Information', 'Информация', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(223, 1, 'View Cart', 'View Cart', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(224, 2, 'View Cart', 'Корзина', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(225, 1, 'Cart', 'Cart', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(226, 2, 'Cart', 'Корзина', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(227, 1, 'Add to cart', 'Add to cart', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(228, 2, 'Add to cart', 'Добавить в корзину', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(229, 1, 'Details', 'Details', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(230, 2, 'Details', 'Подробнее', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(231, 1, 'About Us', 'About Us', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(232, 2, 'About Us', 'Информация о магазине', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(233, 1, 'view products', 'view products', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(234, 2, 'view products', 'смотреть товары', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(235, 1, 'Featured Products', 'Featured Products', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(236, 2, 'Featured Products', 'Рекомендуемые товары', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(237, 1, 'Buy', 'Buy', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(238, 2, 'Buy', 'Купить', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(239, 1, 'read more', 'read more', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(240, 2, 'read more', 'подробнее', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(241, 1, 'best buy!', 'best buy!', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(242, 2, 'best buy!', 'успей купить!', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(243, 1, 'Description', 'Description', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(244, 2, 'Description', 'Описание', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(245, 1, 'Add Review', 'Add Review', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(246, 2, 'Add Review', 'Добавить отзыв', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(247, 1, 'Reviews', 'Reviews', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(248, 2, 'Reviews', 'Отзывы', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(249, 1, 'Buy', 'Buy', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
(250, 2, 'Buy', 'Купить', '2013-10-10 20:08:49', '2013-10-10 20:08:49');

DROP TABLE IF EXISTS email_templates;
CREATE TABLE `email_templates` (
  `id` int(10) auto_increment,
  `alias` varchar(255) collate utf8_unicode_ci,
  `default` int(4),
  `order` int(4),
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `email_templates` VALUES (1, 'new-order', 1, 1);
INSERT INTO `email_templates` VALUES (2, 'new-order-status', 1, 2);
INSERT INTO `email_templates` VALUES (3, 'new-customer', 1, 3);

DROP TABLE IF EXISTS email_template_descriptions;
CREATE TABLE `email_template_descriptions` (
  `id` int(10) auto_increment,
  `email_template_id` int(10),
  `language_id` int(10),
  `subject` varchar(255) collate utf8_unicode_ci,
  `content` text collate utf8_unicode_ci,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `email_template_descriptions` VALUES (1, 1, 1, 'Your order #{$order_number}', 'Dear {$name}!\r\n\r\nYour order confirmed!\r\nOrder number: {$order_number}\r\n\r\nProducts:\r\n{$products}\r\n\r\nThank you!\r\n\r\n');
INSERT INTO `email_template_descriptions` VALUES (2, 1, 2, 'Ваш заказ №{$order_number}', 'Здравствуйте, {$name}!\r\n\r\nВаш заказ подтверждён.\r\nНомер заказа: {$order_number}\r\n\r\nЗаказанные товары:\r\n{$products}\r\n\r\nСпасибо!');
INSERT INTO `email_template_descriptions` VALUES (3, 2, 1, 'Order #{$order_number}: Status Changed', 'Dear {$name}!\r\n\r\nThank you!\r\n\r\nOrder number: {$order_number}\r\n\r\nNew Order Status: {$order_status}\r\n\r\n{$comments}');
INSERT INTO `email_template_descriptions` VALUES (4, 2, 2, 'Изменён статус Вашего заказа №{$order_number}', 'Здравствуйте, {$name}!\r\n\r\nСпасибо за Ваш заказ!\r\n\r\nНомер заказа: {$order_number}\r\n\r\nСтатус Вашего заказа изменён.\r\n\r\nНовый статус заказа: {$order_status}\r\n\r\n{$comments}');
INSERT INTO `email_template_descriptions` VALUES (5, 3, 1, 'Registration', 'Thank you for registration!');
INSERT INTO `email_template_descriptions` VALUES (6, 3, 2, 'Регистрация', 'Благодарим за регистрацию!');

DROP TABLE IF EXISTS answer_templates;
CREATE TABLE `answer_templates` (
  `id` int(10) auto_increment,
  `alias` varchar(255) collate utf8_unicode_ci,
  `default` int(4),
  `order` int(4),
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS answer_template_descriptions;
CREATE TABLE `answer_template_descriptions` (
  `id` int(10) auto_increment,
  `answer_template_id` int(10),
  `language_id` int(10),
  `name` varchar(255) collate utf8_unicode_ci,
  `content` text collate utf8_unicode_ci,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS attributes;
CREATE TABLE `attributes` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `content_id` int(10) DEFAULT NULL,
  `type_attr` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `val` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `order` int(10) DEFAULT NULL,
  `attribute_template_id` int(10) DEFAULT NULL,
  `price_modificator` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `price_value` double DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT NULL,
  `is_show_flt` tinyint(4) DEFAULT NULL,
  `is_show_cmp` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS attribute_descriptions;
CREATE TABLE `attribute_descriptions` (
  `dsc_id` int(10) NOT NULL AUTO_INCREMENT,
  `attribute_id` int(10) DEFAULT NULL,
  `language_id` int(10) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `meta_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_keywords` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`dsc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS attribute_templates;
CREATE TABLE `attribute_templates` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `default` tinyint(4) DEFAULT NULL,
  `template_filter` text COLLATE utf8_unicode_ci,
  `template_editor` text COLLATE utf8_unicode_ci,
  `template_catalog` text COLLATE utf8_unicode_ci,
  `template_product` text COLLATE utf8_unicode_ci,
  `template_compare` text COLLATE utf8_unicode_ci,
  `setting` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `attribute_templates` VALUES 
(1,'value',\N,'<input id=\"activebox{$id_attribute}\" {if $is_active == 1} checked=\"checked\" {/if} type=\"checkbox\" disabled>\r\n<input id=\"activeval{$id_attribute}\" name=\"data[values_f][{$id_attribute}][is_active]\" {if $is_active == 1} value=\"1\" {/if} type=\"hidden\">\r\n\r\n<div class=\"input text\">\r\n<label for=\"value{$id_attribute}\">{$name_attribute}</label>\r\n  <input name=\"data[values_f][{$id_attribute}][data][{$values_attribute.dig_value.id}][value]\" value=\"{$values_attribute.dig_value.val}\" id=\"value{$id_attribute}\" type=\"text\">\r\n<input name=\"data[values_f][{$id_attribute}][data][{$values_attribute.dig_value.id}][type_attr]\" value=\"{$values_attribute.dig_value.type_attr}\" type=\"hidden\">\r\n<input name=\"data[values_f][{$id_attribute}][data][{$values_attribute.dig_value.id}][id]\" value=\"{$values_attribute.dig_value.id}\" type=\"hidden\">\r\n</div>\r\n\r\n<script type=\"text/javascript\">\r\n  $(\"#value{$id_attribute}\").change(function() {\r\n    $(\"#activebox{$id_attribute}\").attr(\"checked\",true);\r\n    $(\"#activeval{$id_attribute}\").attr(\"value\",\"1\");\r\n  });\r\n  \r\n</script>\r\n','<div class=\"input text\">\r\n  <label for=\"value{$id_attribute}\">{$name_attribute}</label>\r\n  <input name=\"data[values_s][{$id_attribute}][data][{$values_attribute.dig_value.parent_id}][value]\" value=\"{$values_attribute.dig_value.val}\" id=\"value{$id_attribute}\" type=\"text\">\r\n  <input name=\"data[values_s][{$id_attribute}][data][{$values_attribute.dig_value.parent_id}][type_attr]\" value=\"{$values_attribute.dig_value.type_attr}\" type=\"hidden\">\r\n  <input name=\"data[values_s][{$id_attribute}][data][{$values_attribute.dig_value.parent_id}][id]\" value=\"{$values_attribute.dig_value.id}\" type=\"hidden\">\r\n  <input name=\"data[values_s][{$id_attribute}][data][{$values_attribute.dig_value.parent_id}][parent_id]\" value=\"{$values_attribute.dig_value.parent_id}\" type=\"hidden\">\r\n</div>','{if $values_attribute.dig_value.val}\r\n<li>\r\n  {$values_attribute.dig_value.name}	{$values_attribute.dig_value.val}\r\n</li>\r\n{/if}','{if $values_attribute.dig_value.val}\r\n<li>\r\n  {$values_attribute.dig_value.name}	{$values_attribute.dig_value.val}\r\n</li>\r\n{/if}','{$values_attribute.dig_value.val}','a:7:{s:9:\"dig_value\";s:1:\"1\";s:9:\"max_value\";s:1:\"0\";s:9:\"min_value\";s:1:\"0\";s:10:\"like_value\";s:1:\"0\";s:10:\"list_value\";s:1:\"0\";s:12:\"checked_list\";s:1:\"0\";s:9:\"any_value\";s:1:\"0\";}'),
(2,'radio',\N,'<input id=\"activebox{$id_attribute}\" {if $is_active == 1} checked=\"checked\" {/if} type=\"checkbox\" disabled>\r\n<input id=\"activeval{$id_attribute}\" name=\"data[values_f][{$id_attribute}][is_active]\" {if $is_active == 1} value=\"1\" {/if} type=\"hidden\">\r\n<br>{$name_attribute}\r\n<div class=\"radio\">\r\n{foreach from=$values_attribute item=val}\r\n<div>\r\n  <input type=\"radio\" {if $val.val == 1} checked=\"checked\" {/if} name=\"data[values_f][{$id_attribute}][set]\" value=\"{$val.id}\" id=\"value{$val.id}\" class=\"radio{$id_attribute}\">\r\n<label for=\"value{$val.id}\">{$val.name}</label>\r\n<input name=\"data[values_f][{$id_attribute}][data][{$val.id}][type_attr]\" value=\"{$val.type_attr}\" type=\"hidden\">\r\n<input name=\"data[values_f][{$id_attribute}][data][{$val.id}][id]\" value=\"{$val.id}\" type=\"hidden\">\r\n</div>\r\n{/foreach}\r\n</div>\r\n\r\n<script type=\"text/javascript\">\r\n  $(\".radio{$id_attribute}\").change(function() {\r\n    $(\"#activebox{$id_attribute}\").attr(\"checked\",true);\r\n    $(\"#activeval{$id_attribute}\").attr(\"value\",\"1\");\r\n  });\r\n</script>\r\n','<div class=\"radio\">\r\n{foreach from=$values_attribute item=val}\r\n  <div>\r\n    <input type=\"radio\" {if $val.val == 1} checked=\"checked\" {/if} name=\"data[values_s][{$id_attribute}][set]\" value=\"{$val.parent_id}\" id=\"value{$val.id}\">\r\n    <label for=\"value{$val.id}\">{$val.name}</label>\r\n    <input name=\"data[values_s][{$id_attribute}][data][{$val.parent_id}][type_attr]\" value=\"{$val.type_attr}\" type=\"hidden\">\r\n    <input name=\"data[values_s][{$id_attribute}][data][{$val.parent_id}][id]\" value=\"{$val.id}\" type=\"hidden\">\r\n    <input name=\"data[values_s][{$id_attribute}][data][{$val.parent_id}][parent_id]\" value=\"{$val.parent_id}\" type=\"hidden\">\r\n  </div>\r\n{/foreach}\r\n</div>','{foreach from=$values_attribute item=val}\r\n{if $val.val == 1} <li>{$name_attribute}	{$val.name}</li> {/if}\r\n{/foreach}\r\n','{foreach from=$values_attribute item=val}\r\n{if $val.val == 1} <li>{$name_attribute}	{$val.name}</li> {/if}\r\n{/foreach}','{foreach from=$values_attribute item=val}\r\n  {if $val.val == 1} {$val.name} {/if}\r\n{/foreach}','a:7:{s:9:\"dig_value\";s:1:\"0\";s:9:\"max_value\";s:1:\"0\";s:9:\"min_value\";s:1:\"0\";s:10:\"like_value\";s:1:\"0\";s:10:\"list_value\";s:1:\"1\";s:12:\"checked_list\";s:1:\"0\";s:9:\"any_value\";s:1:\"0\";}'),
(3,'check',\N,'<input id=\"activebox{$id_attribute}\" {if $is_active == 1} checked=\"checked\" {/if} type=\"checkbox\" disabled>\r\n<input id=\"activeval{$id_attribute}\" name=\"data[values_f][{$id_attribute}][is_active]\" {if $is_active == 1} value=\"1\" {/if} type=\"hidden\">\r\n<br>{$name_attribute}\r\n<div class=\"checkbox\">\r\n{foreach from=$values_attribute item=val}\r\n<div>\r\n<input type=\"checkbox\" {if $val.val == 1} checked=\"checked\" {/if} name=\"data[values_f][{$id_attribute}][data][{$val.id}][value]\" value=\"1\" id=\"value{$val.id}\" class=\"checkbox{$id_attribute}\">\r\n<label for=\"value{$val.id}\">{$val.name}</label>\r\n<input name=\"data[values_f][{$id_attribute}][data][{$val.id}][type_attr]\" value=\"{$val.type_attr}\" type=\"hidden\">\r\n<input name=\"data[values_f][{$id_attribute}][data][{$val.id}][id]\" value=\"{$val.id}\" type=\"hidden\">\r\n</div>\r\n{/foreach}\r\n</div>\r\n\r\n<script type=\"text/javascript\">\r\n  $(\".checkbox{$id_attribute}\").change(function() {\r\n    $(\"#activebox{$id_attribute}\").attr(\"checked\",true);\r\n    $(\"#activeval{$id_attribute}\").attr(\"value\",\"1\");\r\n  });\r\n</script>\r\n','<div class=\"checkbox\">\r\n{foreach from=$values_attribute item=val}\r\n  <div>\r\n    <input type=\"checkbox\" {if $val.val == 1} checked=\"checked\" {/if} name=\"data[values_s][{$id_attribute}][data][{$val.parent_id}][value]\" value=\"1\" id=\"value{$val.id}\">\r\n    <label for=\"value{$val.id}\">{$val.name}</label>\r\n    <input name=\"data[values_s][{$id_attribute}][data][{$val.parent_id}][type_attr]\" value=\"{$val.type_attr}\" type=\"hidden\">\r\n    <input name=\"data[values_s][{$id_attribute}][data][{$val.parent_id}][id]\" value=\"{$val.id}\" type=\"hidden\">\r\n    <input name=\"data[values_s][{$id_attribute}][data][{$val.parent_id}][parent_id]\" value=\"{$val.parent_id}\" type=\"hidden\">\r\n  </div>\r\n{/foreach}\r\n</div>','<li>\r\n{$name_attribute} :\r\n<ul>\r\n{foreach from=$values_attribute item=val}\r\n  {if $val.val == 1} <li> > {$val.name} </li> {/if}\r\n  {/foreach}\r\n</ul>\r\n</li>','<li>\r\n{$name_attribute} :\r\n<ul>\r\n{foreach from=$values_attribute item=val}\r\n  {if $val.val == 1} <li> > {$val.name} <!-- {$val.price_modificator} {$val.price_value} --> </li> {/if}\r\n{/foreach}\r\n</ul>\r\n</li>','<ul>\r\n  {foreach from=$values_attribute item=val}\r\n  {if $val.val == 1} <li>{$val.name}</li> {/if}\r\n  {/foreach}\r\n</ul>  ','a:7:{s:9:\"dig_value\";s:1:\"0\";s:9:\"max_value\";s:1:\"0\";s:9:\"min_value\";s:1:\"0\";s:10:\"like_value\";s:1:\"0\";s:10:\"list_value\";s:1:\"1\";s:12:\"checked_list\";s:1:\"1\";s:9:\"any_value\";s:1:\"0\";}'),
(4,'list',\N,'<input id=\"activebox{$id_attribute}\" {if $is_active == 1} checked=\"checked\" {/if} type=\"checkbox\" disabled>\r\n<input id=\"activeval{$id_attribute}\" name=\"data[values_f][{$id_attribute}][is_active]\" {if $is_active == 1} value=\"1\" {/if} type=\"hidden\">\r\n<div class=\"input select\">\r\n  <label for=\"listvalue{$id_attribute}\">{$name_attribute}</label>\r\n  <select name=\"data[values_f][{$id_attribute}][set]\" id=\"listvalue{$id_attribute}\">\r\n  {foreach from=$values_attribute item=val}\r\n  <option value=\"{$val.id}\" {if $val.val == 1} selected {/if}>{$val.name}</option>\r\n  {/foreach}\r\n  </select>\r\n  {foreach from=$values_attribute item=val}\r\n    <input name=\"data[values_f][{$id_attribute}][data][{$val.id}][type_attr]\" value=\"{$val.type_attr}\" type=\"hidden\">\r\n    <input name=\"data[values_f][{$id_attribute}][data][{$val.id}][id]\" value=\"{$val.id}\" type=\"hidden\">\r\n  {/foreach}\r\n</div>\r\n\r\n<script type=\"text/javascript\">\r\n  $(\"#listvalue{$id_attribute}\").change(function() {\r\n    $(\"#activebox{$id_attribute}\").attr(\"checked\",true);\r\n    $(\"#activeval{$id_attribute}\").attr(\"value\",\"1\");\r\n  });\r\n</script>\r\n','<div class=\"input select\">\r\n  <label for=\"listvalue{$id_attribute}\">{$name_attribute}</label>\r\n  <select name=\"data[values_s][{$id_attribute}][set]\" id=\"listvalue{$id_attribute}\">\r\n  {foreach from=$values_attribute item=val}\r\n  <option value=\"{$val.parent_id}\" {if $val.val == 1} selected {/if}>{$val.name}</option>\r\n  {/foreach}\r\n  </select>\r\n  {foreach from=$values_attribute item=val}\r\n    <input name=\"data[values_s][{$id_attribute}][data][{$val.parent_id}][type_attr]\" value=\"{$val.type_attr}\" type=\"hidden\">\r\n    <input name=\"data[values_s][{$id_attribute}][data][{$val.parent_id}][id]\" value=\"{$val.id}\" type=\"hidden\">\r\n    <input name=\"data[values_s][{$id_attribute}][data][{$val.parent_id}][parent_id]\" value=\"{$val.parent_id}\" type=\"hidden\">\r\n  {/foreach}\r\n</div>','{foreach from=$values_attribute item=val}\r\n  {if $val.val == 1} <li>{$name_attribute}	{$val.name}</li> {/if}\r\n{/foreach}','{foreach from=$values_attribute item=val}\r\n  {if $val.val == 1} <li>{$name_attribute}	{$val.name}</li> {/if}\r\n{/foreach}','{foreach from=$values_attribute item=val}\r\n  {if $val.val == 1} {$val.name} {/if}\r\n{/foreach}','a:7:{s:9:\"dig_value\";s:1:\"0\";s:9:\"max_value\";s:1:\"0\";s:9:\"min_value\";s:1:\"0\";s:10:\"like_value\";s:1:\"0\";s:10:\"list_value\";s:1:\"1\";s:12:\"checked_list\";s:1:\"0\";s:9:\"any_value\";s:1:\"0\";}'),
(5,'range',\N,'<input id=\"activebox{$id_attribute}\" {if $is_active == 1} checked=\"checked\" {/if} type=\"checkbox\" disabled>\r\n<input id=\"activeval{$id_attribute}\" name=\"data[values_f][{$id_attribute}][is_active]\" {if $is_active == 1} value=\"1\" {/if} type=\"hidden\">\r\n\r\n<div class=\"input text\">\r\n<label for=\"min_value{$id_attribute}\">{$values_attribute.min_value.name}</label>\r\n<input name=\"data[values_f][{$id_attribute}][data][{$values_attribute.min_value.id}][value]\" value=\"{$values_attribute.min_value.val}\" id=\"min_value{$id_attribute}\" type=\"text\" class=\"range_value\">\r\n<input name=\"data[values_f][{$id_attribute}][data][{$values_attribute.min_value.id}][type_attr]\" value=\"{$values_attribute.min_value.type_attr}\" type=\"hidden\">\r\n<input name=\"data[values_f][{$id_attribute}][data][{$values_attribute.min_value.id}][id]\" value=\"{$values_attribute.min_value.id}\" type=\"hidden\">\r\n</div> \r\n<div class=\"input text\">\r\n<label for=\"max_value{$id_attribute}\">{$values_attribute.max_value.name}</label>\r\n<input name=\"data[values_f][{$id_attribute}][data][{$values_attribute.max_value.id}][value]\" value=\"{$values_attribute.max_value.val}\" id=\"max_value{$id_attribute}\" type=\"text\" class=\"range_value\">\r\n<input name=\"data[values_f][{$id_attribute}][data][{$values_attribute.max_value.id}][type_attr]\" value=\"{$values_attribute.max_value.type_attr}\" type=\"hidden\">\r\n<input name=\"data[values_f][{$id_attribute}][data][{$values_attribute.max_value.id}][id]\" value=\"{$values_attribute.max_value.id}\" type=\"hidden\">\r\n</div>\r\n\r\n<script type=\"text/javascript\">\r\n  $(\".range_value\").change(function() {\r\n    $(\"#activebox{$id_attribute}\").attr(\"checked\",true);\r\n    $(\"#activeval{$id_attribute}\").attr(\"value\",\"1\");\r\n  });\r\n  \r\n</script>','<div class=\"input text\">\r\n  <label for=\"min_value{$id_attribute}\">{$values_attribute.min_value.name}</label>\r\n  <input name=\"data[values_s][{$id_attribute}][data][{$values_attribute.min_value.parent_id}][value]\" value=\"{$values_attribute.min_value.val}\" id=\"min_value{$id_attribute}\" type=\"text\">\r\n  <input name=\"data[values_s][{$id_attribute}][data][{$values_attribute.min_value.parent_id}][type_attr]\" value=\"{$values_attribute.min_value.type_attr}\" type=\"hidden\">\r\n  <input name=\"data[values_s][{$id_attribute}][data][{$values_attribute.min_value.parent_id}][id]\" value=\"{$values_attribute.min_value.id}\" type=\"hidden\">\r\n  <input name=\"data[values_s][{$id_attribute}][data][{$values_attribute.min_value.parent_id}][parent_id]\" value=\"{$values_attribute.min_value.parent_id}\" type=\"hidden\">\r\n</div>\r\n<div class=\"input text\">\r\n  <label for=\"max_value{$id_attribute}\">{$values_attribute.max_value.name}</label>\r\n  <input name=\"data[values_s][{$id_attribute}][data][{$values_attribute.max_value.parent_id}][value]\" value=\"{$values_attribute.max_value.val}\" id=\"max_value{$id_attribute}\" type=\"text\">\r\n  <input name=\"data[values_s][{$id_attribute}][data][{$values_attribute.max_value.parent_id}][type_attr]\" value=\"{$values_attribute.max_value.type_attr}\" type=\"hidden\">\r\n  <input name=\"data[values_s][{$id_attribute}][data][{$values_attribute.max_value.parent_id}][id]\" value=\"{$values_attribute.max_value.id}\" type=\"hidden\">\r\n  <input name=\"data[values_s][{$id_attribute}][data][{$values_attribute.max_value.parent_id}][parent_id]\" value=\"{$values_attribute.max_value.parent_id}\" type=\"hidden\">\r\n</div>','{if $values_attribute.min_value.val}\r\n<li>\r\n  {$name_attribute}	{$values_attribute.min_value.val}\r\n</li>\r\n{/if}','{if $values_attribute.min_value.val}\r\n<li>\r\n  {$name_attribute}	{$values_attribute.min_value.val}\r\n</li>\r\n{/if}','{$values_attribute.min_value.val}','a:7:{s:9:\"dig_value\";s:1:\"0\";s:9:\"max_value\";s:1:\"1\";s:9:\"min_value\";s:1:\"1\";s:10:\"like_value\";s:1:\"0\";s:10:\"list_value\";s:1:\"0\";s:12:\"checked_list\";s:1:\"0\";s:9:\"any_value\";s:1:\"0\";}'),
(6,'like',\N,'<input id=\"activebox{$id_attribute}\" {if $is_active == 1} checked=\"checked\" {/if} type=\"checkbox\" disabled>\r\n<input id=\"activeval{$id_attribute}\" name=\"data[values_f][{$id_attribute}][is_active]\" {if $is_active == 1} value=\"1\" {/if} type=\"hidden\">\r\n\r\n<div class=\"input text\">\r\n<label for=\"value{$id_attribute}\">{$name_attribute}</label>\r\n  <input name=\"data[values_f][{$id_attribute}][data][{$values_attribute.like_value.id}][value]\" value=\"{$values_attribute.like_value.val}\" id=\"value{$id_attribute}\" type=\"text\">\r\n<input name=\"data[values_f][{$id_attribute}][data][{$values_attribute.like_value.id}][type_attr]\" value=\"{$values_attribute.like_value.type_attr}\" type=\"hidden\">\r\n<input name=\"data[values_f][{$id_attribute}][data][{$values_attribute.like_value.id}][id]\" value=\"{$values_attribute.like_value.id}\" type=\"hidden\">\r\n</div>\r\n\r\n<script type=\"text/javascript\">\r\n  $(\"#value{$id_attribute}\").change(function() {\r\n    $(\"#activebox{$id_attribute}\").attr(\"checked\",true);\r\n    $(\"#activeval{$id_attribute}\").attr(\"value\",\"1\");\r\n  });\r\n  \r\n</script>','<div class=\"input text\">\r\n  <label for=\"value{$id_attribute}\">{$name_attribute}</label>\r\n  <input name=\"data[values_s][{$id_attribute}][data][{$values_attribute.like_value.parent_id}][value]\" value=\"{$values_attribute.like_value.val}\" id=\"value{$id_attribute}\" type=\"text\">\r\n  <input name=\"data[values_s][{$id_attribute}][data][{$values_attribute.like_value.parent_id}][type_attr]\" value=\"{$values_attribute.like_value.type_attr}\" type=\"hidden\">\r\n  <input name=\"data[values_s][{$id_attribute}][data][{$values_attribute.like_value.parent_id}][id]\" value=\"{$values_attribute.like_value.id}\" type=\"hidden\">\r\n  <input name=\"data[values_s][{$id_attribute}][data][{$values_attribute.like_value.parent_id}][parent_id]\" value=\"{$values_attribute.like_value.parent_id}\" type=\"hidden\">\r\n</div>','{if $values_attribute.like_value.val}\r\n<li>\r\n  {$values_attribute.like_value.name}	{$values_attribute.like_value.val}\r\n</li>\r\n{/if}','{if $values_attribute.like_value.val}\r\n<li>\r\n  {$values_attribute.like_value.name}	{$values_attribute.like_value.val}\r\n</li>\r\n{/if}','{$values_attribute.like_value.val}','a:7:{s:9:\"dig_value\";s:1:\"0\";s:9:\"max_value\";s:1:\"0\";s:9:\"min_value\";s:1:\"0\";s:10:\"like_value\";s:1:\"1\";s:10:\"list_value\";s:1:\"0\";s:12:\"checked_list\";s:1:\"0\";s:9:\"any_value\";s:1:\"0\";}')	;

DROP TABLE IF EXISTS events;
CREATE TABLE `events` (
  `id` int(10) auto_increment,
  `alias` varchar(255) collate utf8_unicode_ci,
  `originator` varchar(255) collate utf8_unicode_ci,
  `description` varchar(255) collate utf8_unicode_ci,
  `created` datetime,
  `modified` datetime,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `events` (`id`, `alias`, `originator`, `description`, `created`, `modified`) VALUES 
(1, 'UpdateOrderTotalsBeforeSave', 'Core', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'UpdateOrderTotalsAfterSave', 'Core', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'PlaceOrderBeforeSave', 'Core', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'PlaceOrderAfterSave', 'Core', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'AddToCartBeforeSave', 'Core', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 'AddToCartAfterSave', 'Core', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 'RemoveFromCartBeforeSave', 'Core', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 'RemoveFromCartAfterSave', 'Core', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 'UpdateCustomerDetailsBeforeSave', 'Core', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 'UpdateCustomerDetailsAfterSave', 'Core', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 'SwitchLanguage', 'Core', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 'SwitchCurrency', 'Core', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

DROP TABLE IF EXISTS event_handlers;
CREATE TABLE `event_handlers` (
  `id` int(10) auto_increment,
  `event_id` int(10),
  `originator` varchar(255) collate utf8_unicode_ci,
  `action` varchar(255) collate utf8_unicode_ci,
  `created` datetime,
  `modified` datetime,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `event_handlers` (`id`, `event_id`, `originator`, `action`, `created`, `modified`) VALUES 
(1, 2, 'CouponsModule', '/module_coupons/event/utilize_coupon/', '2009-09-13 11:11:08', '2009-09-13 11:11:08');

DROP TABLE IF EXISTS `geo_zones`;
CREATE TABLE IF NOT EXISTS `geo_zones` (
  `id` int(11) AUTO_INCREMENT,
  `name` varchar(255),
  `description` text,
  `created` datetime,
  `modified` datetime,
  PRIMARY KEY (`id`),
  KEY `IDX_NAME` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS global_content_blocks;
CREATE TABLE `global_content_blocks` (
  `id` int(10) auto_increment,
  `name` varchar(255) collate utf8_unicode_ci,
  `content` text collate utf8_unicode_ci,
  `alias` varchar(255) collate utf8_unicode_ci,
  `active` tinyint(4) default '1',
  `created` datetime,
  `modified` datetime,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `global_content_blocks` (`id`, `name`, `content`, `alias`, `active`, `created`, `modified`) VALUES 
(1, 'Footer', '<p class="copyright"><a href="http://vamcart.com/">{lang}PHP Shopping Cart{/lang}</a> <a href="http://vamcart.com/">VamCart</a>.</p>', 'footer', 1, '2009-07-17 10:00:06', '2009-09-12 17:05:49');

DROP TABLE IF EXISTS languages;
CREATE TABLE `languages` (
  `id` int(10) auto_increment,
  `default` tinyint(4),
  `name` varchar(255) collate utf8_unicode_ci,
  `code` varchar(5) collate utf8_unicode_ci,
  `iso_code_2` varchar(2) collate utf8_unicode_ci,
  `active` tinyint(4) default '1',
  `sort_order` int(3),
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `languages` (`id`, `default`, `name`, `code`, `iso_code_2`, `active`, `sort_order`) VALUES 
(1, 1, 'English', 'eng', 'en', 1, 1),
(2, 0, 'Русский', 'rus', 'ru', 1, 0);

DROP TABLE IF EXISTS micro_templates;
CREATE TABLE `micro_templates` (
  `id` int(10) auto_increment,
  `alias` varchar(255) collate utf8_unicode_ci,
  `template` text collate utf8_unicode_ci,
  `created` datetime,
  `modified` datetime,
  `tag_name` varchar(255) collate utf8_unicode_ci,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `micro_templates` VALUES 
(1,'categories-box','{if $content_list}\r\n<section class=\"widget inner categories-widget\">\r\n	<h3 class=\"widget-title\">{lang}Categories{/lang}</h3>\r\n		<ul class=\"icons clearfix\">\r\n			{foreach from=$content_list item=node}\r\n				<li{if $node.alias == $content_alias} class=\"active\"{/if}><a href=\"{$node.url}\">{$node.name}</a></li>\r\n			{/foreach}\r\n		</ul>\r\n</section>\r\n{/if}','2013-10-01 17:08:06','2013-10-08 20:03:31','content_listing'),
(2,'info-links','<ul class=\"nav pull-left\">\r\n	<li{if $content_alias == \'home-page\'} class=\"active\"{/if}><a href=\"{base_path}/\">{lang}Home{/lang}</a></li>\r\n	<li class=\"dropdown\">\r\n		<a data-toggle=\"dropdown\" class=\"dropdown-toggle\" href=\"\">{lang}Information{/lang} <b class=\"caret\"></b></a>\r\n			<ul class=\"dropdown-menu\">\r\n				{foreach from=$content_list item=node}\r\n					<li{if $node.alias == $content_alias} class=\"active\"{/if}><a href=\"{$node.url}\">{$node.name}</a></li>\r\n				{/foreach}\r\n			</ul>\r\n	</li>\r\n	{admin_area_link}\r\n</ul>','2013-10-01 17:08:06','2013-10-08 21:00:31','content_listing'),
(3,'subcategory-listing','{if $content_list}\r\n<div class=\"row-fluid featured-categories\">\r\n	<ul class=\"thumbnails\">\r\n	{foreach from=$content_list item=node}\r\n		<li class=\"span4 item\">\r\n			<div class=\"thumbnail\">\r\n				<a href=\"{$node.url}\" class=\"image\">\r\n				<img src=\"{$node.image}\" alt=\"{$node.name}\" title=\"{$node.name}\"{if isset($thumbnail_width)} width=\"{$thumbnail_width}\"{/if} />\r\n				<span class=\"frame-overlay\"></span>\r\n				<h4 class=\"title\"><i class=\"icon-folder-open\"></i> {$node.name}</h4>\r\n				<span class=\"link\">{lang}view products{/lang} <i class=\"icon-chevron-right\"></i></span>\r\n				</a>\r\n\r\n				<div class=\"inner notop\">\r\n					<p class=\"description\">\r\n						{$node.description|strip_tags|truncate:30:\"...\":true}\r\n					</p>\r\n				</div>\r\n			</div>\r\n		</li>\r\n	{/foreach}\r\n	</ul>\r\n</div>\r\n{else}\r\n<div>{lang}No Items Found{/lang}</div>\r\n{/if}\r\n','2013-10-01 17:08:06','2013-10-11 23:44:32','content_listing'),
(4,'product-listing','{if $content_list}\r\n\r\n{if $pages_number > 1 || $page==\"all\"}\r\n<!-- start: Pagination -->\r\n<div class=\"pagination pagination-centered\">\r\n	<ul>\r\n		{for $pg=1 to $pages_number}\r\n		<li{if $pg == $page} class=\"active\"{/if}><a href=\"{base_path}/category/{$content_alias->value}{$ext}/page/{$pg}\">{$pg}</a></li>\r\n		{/for}\r\n		<li><a href=\"{base_path}/category/{$content_alias->value}{$ext}/page/all\" {if \"all\" == $page}class=\"current\"{/if}>{lang}All{/lang}</a></li>\r\n	</ul>\r\n</div>\r\n<!-- end: Pagination -->\r\n{/if}  \r\n  \r\n<!-- start: products listing -->\r\n<div class=\"row-fluid shop-products\">\r\n	<ul class=\"thumbnails\">\r\n		{foreach from=$content_list item=node}\r\n		<li class=\"item span4 {if $node@index is div by 3}first{/if}\">\r\n			<div class=\"thumbnail\">\r\n				<a href=\"{$node.url}\" class=\"image\"><img src=\"{$node.image}\" alt=\"{$node.name}\"{if isset($thumbnail_width)} width=\"{$thumbnail_width}\"{/if} /><span class=\"frame-overlay\"></span><span class=\"price\">{$node.price}</span></a>\r\n			<div class=\"inner notop nobottom\">\r\n				<h4 class=\"title\">{$node.name}</h4>\r\n				<p class=\"description\">{$node.description|strip_tags|truncate:30:\"...\":true}</p>\r\n				<p class=\"description\">{attribute_list value_attributes=$node.attributes}</p>\r\n              </div>\r\n			</div>\r\n			{product_form product_id={$node.id}}\r\n			<div class=\"inner darken notop\">\r\n              <button class=\"btn btn-add-to-cart\" type=\"submit\"><i class=\"icon-shopping-cart\"></i> {lang}Buy{/lang}</button>\r\n              {if isset($is_compare)}<a href=\"{base_path}/category/addcmp/{$node.alias}/{$content_alias->value}{$ext}\" class=\"btn btn-add-to-cart\"><i class=\"icon-bookmark\"></i> {lang}Compare{/lang}</a>{/if}\r\n			</div>\r\n            {/product_form}\r\n		</li>\r\n		{/foreach}\r\n	</ul>\r\n<!-- end: products listing -->\r\n\r\n{if $pages_number > 1 || $page==\"all\"}\r\n<!-- start: Pagination -->\r\n<div class=\"pagination pagination-centered\">\r\n	<ul>\r\n		{for $pg=1 to $pages_number}\r\n		<li{if $pg == $page} class=\"active\"{/if}><a href=\"{base_path}/category/{$content_alias->value}{$ext}/page/{$pg}\">{$pg}</a></li>\r\n		{/for}\r\n		<li><a href=\"{base_path}/category/{$content_alias->value}{$ext}/page/all\" {if \"all\" == $page}class=\"current\"{/if}>{lang}All{/lang}</a></li>\r\n	</ul>\r\n</div>\r\n<!-- end: Pagination -->\r\n{/if}\r\n\r\n{else}\r\n{lang}No Items Found{/lang}\r\n\r\n{/if}  ','2013-10-01 17:08:06','2013-10-14 11:17:41','content_listing'),
(5,'news-dropdown','<li class=\"dropdown\">\r\n	<a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\">{lang}News{/lang} <b class=\"caret\"></b></a>\r\n		<ul class=\"dropdown-menu\">\r\n			{foreach from=$content_list item=node}\r\n				<li{if $node.alias == $content_alias} class=\"active\"{/if}><a href=\"{$node.url}\">{$node.name}</a></li>\r\n			{/foreach}\r\n		</ul>\r\n</li>','2013-10-08 12:05:54','2013-10-08 21:00:38','content_listing'),
(6,'search-box','<section class=\"widget inner darken search\">\r\n	<form id=\"search\" class=\"input-append\" action=\"{base_path}/page/search-result.html\" method=\"get\">\r\n		<input class=\"span4\" id=\"appendedInputButton\" name=\"keyword\" type=\"text\" placeholder=\"{lang}Search{/lang}\" />\r\n		<input class=\"btn search-bt\" type=\"submit\" value=\"\" />\r\n	</form>\r\n</section>','2013-10-01 17:08:06','2013-10-07 16:25:08','content_listing'),
(7,'cart-content-box','<div id=\"shopping-cart-box\">\r\n{if $order_items}\r\n<section class=\"widget inner shopping-cart-widget\">\r\n	<h3 class=\"widget-title\">{lang}Shopping Cart{/lang}</h3>\r\n		<div class=\"products\">\r\n			{foreach from=$order_items item=product}\r\n				<div class=\"media\">\r\n					<a class=\"pull-right\" href=\"{$product.url}\">\r\n						<img class=\"media-object\" src=\"{$product.image.image_thumb}\" alt=\"\" title=\"\" />\r\n					</a>\r\n				<div class=\"media-body\">\r\n                  <h4 class=\"media-heading\"><a href=\"{$product.url}\">{$product.name}</a> <a href=\"{base_path}/cart/remove_product/{$product.id}/1\" class=\"remove\" title=\"{lang}Remove{/lang}\"><i class=\"icon-trash\"></i></a></h4>\r\n					{$product.qty} x {$product.price}\r\n				</div>\r\n				</div>\r\n			{/foreach}\r\n		</div>\r\n		<p class=\"subtotal\">\r\n			<strong>{lang}Total{/lang}:</strong>\r\n			<span class=\"amount\">{$order_total}</span>\r\n		</p>\r\n		<p class=\"buttons\">\r\n			<a class=\"btn btn-inverse viewcart\" href=\"{$cart_link}\">{lang}View Cart{/lang}</a>\r\n			<a class=\"btn btn-inverse checkout\" href=\"{$checkout_link}\">{lang}Checkout{/lang} &rarr;</a>\r\n		</p>\r\n</section>\r\n{/if}\r\n</div>','2013-10-01 17:08:06','2013-10-13 18:25:43','shopping_cart'),
(8,'cart-content-box-ajax','{if $order_items}\r\n<section class=\"widget inner shopping-cart-widget\">\r\n	<h3 class=\"widget-title\">{lang}Shopping Cart{/lang}</h3>\r\n		<div class=\"products\">\r\n			{foreach from=$order_items item=product}\r\n				<div class=\"media\">\r\n					<a class=\"pull-right\" href=\"{$product.url}\">\r\n						<img class=\"media-object\" src=\"{$product.image.image_thumb}\" alt=\"\" title=\"\" />\r\n					</a>\r\n				<div class=\"media-body\">\r\n					<h4 class=\"media-heading\"><a href=\"{$product.url}\">{$product.name}</a> <a href=\"{base_path}/cart/remove_product/{$product.id}/1\" class=\"remove\" title=\"{lang}Remove{/lang}\"><i class=\"icon-trash\"></i></a></h4>\r\n					{$product.qty} x {$product.price}\r\n				</div>\r\n				</div>\r\n			{/foreach}\r\n		</div>\r\n		<p class=\"subtotal\">\r\n			<strong>{lang}Total{/lang}:</strong>\r\n			<span class=\"amount\">{$order_total}</span>\r\n		</p>\r\n		<p class=\"buttons\">\r\n			<a class=\"btn btn-inverse viewcart\" href=\"{$cart_link}\">{lang}View Cart{/lang}</a>\r\n			<a class=\"btn btn-inverse checkout\" href=\"{$checkout_link}\">{lang}Checkout{/lang} &rarr;</a>\r\n		</p>\r\n</section>\r\n{/if}','2013-10-01 17:08:06','2013-10-07 23:43:52','shopping_cart'),
(9,'cart-content-box-pull','{if $order_items}\r\n<div class=\"shopping-cart pull-right\">\r\n	<a href=\"{$cart_link}\" class=\"cart\">\r\n		<span class=\"quantity\">{$total_quantity}</span>\r\n		<span class=\"amount\"><i class=\"icon-shopping-cart\"></i>{$order_total}</span>\r\n	</a>\r\n	<div class=\"cart-dropdown\">\r\n		<h2 class=\"title\">{lang}Cart{/lang}</h2>\r\n			<div class=\"content\">\r\n				<div class=\"products\">\r\n					{foreach from=$order_items item=product}\r\n						<div class=\"media\">\r\n							<a class=\"pull-right\" href=\"{$product.url}\">\r\n								<img class=\"media-object\" src=\"{$product.image.image_thumb}\" alt=\"\" title=\"\" />\r\n							</a>\r\n							<div class=\"media-body\">\r\n								<h4 class=\"media-heading\"><a href=\"{$product.url}\">{$product.name}</a> <a href=\"{base_path}/cart/remove_product/{$product.id}/1\" class=\"remove\" title=\"{lang}Remove{/lang}\"><i class=\"icon-trash\"></i></a></h4>\r\n								{$product.qty} x {$product.price}\r\n							</div>\r\n						</div>\r\n					{/foreach}\r\n				</div>\r\n				<p class=\"subtotal\">\r\n					<strong>{lang}Total{/lang}:</strong>\r\n					<span class=\"amount\">{$order_total}</span>\r\n				</p>\r\n				<p class=\"buttons\">\r\n					<a class=\"btn btn-inverse viewcart\" href=\"{$cart_link}\">{lang}View Cart{/lang}</a>\r\n					<a class=\"btn btn-inverse viewcart\" href=\"{$checkout_link}\">{lang}Checkout{/lang} &rarr;</a>\r\n				</p>\r\n			</div>\r\n	</div>\r\n</div>\r\n{/if}','2013-10-07 16:49:09','2013-10-13 18:23:37','shopping_cart'),
(10,'footer-links','<ul class=\"unstyled\">\r\n	{foreach from=$content_list item=node}\r\n		<li{if $node.alias == $content_alias} class=\"active\"{/if}><a href=\"{$node.url}\">{$node.name}</a></li>\r\n	{/foreach}\r\n</ul>','2013-10-08 12:52:16','2013-10-08 21:00:45','content_listing'),
(11,'featured-products','{if $content_list}\r\n<h2>{lang}Featured Products{/lang}</h2>\r\n<div class=\"row-fluid featured-products\">\r\n	<ul class=\"thumbnails\">\r\n	{foreach from=$content_list item=node}\r\n		<li class=\"span4 item\">\r\n			<div class=\"thumbnail\">\r\n				<a href=\"{$node.url}\" class=\"image\">\r\n					<img src=\"{$node.image}\" alt=\"{$node.name}\"{if isset($thumbnail_width)} width=\"{$thumbnail_width}\"{/if} />\r\n					<span class=\"frame-overlay\"></span>\r\n					<span class=\"price\">{$node.price}</span>\r\n				</a>\r\n				<div class=\"inner notop nobottom\">\r\n					<h4 class=\"title\">{$node.name}</h4>\r\n					<p class=\"description\">{$node.description|strip_tags|truncate:30:\"...\":true}</p>\r\n				</div>\r\n			</div>\r\n			{product_form product_id={$node.id}}\r\n			<div class=\"inner darken notop\">\r\n				<button class=\"btn btn-add-to-cart\" type=\"submit\" value=\"{lang}Buy{/lang}\">{lang}Buy{/lang}<i class=\"icon-shopping-cart\"></i></button>\r\n			</div>\r\n			{/product_form}\r\n		</li>\r\n	{/foreach}\r\n	</ul>\r\n</div>\r\n{/if}  ','2013-10-08 18:09:58','2013-10-14 11:17:38','content_listing'),
(12,'slider','{if $content_list}\r\n<script type=\"text/javascript\" src=\"{base_path}/js/jquery/plugins/sequence.jquery-min.js\"></script>\r\n<script type=\"text/javascript\" src=\"{base_path}/js/jquery/plugins/sequencejs-options.js\"></script>\r\n<link rel=\"stylesheet\" type=\"text/css\" href=\"{base_path}/css/sequencejs.css\"/>\r\n\r\n<section id=\"slider\">\r\n	<div id=\"sequence-theme\">\r\n		<div id=\"sequence\">\r\n			<div class=\"prev\"><i class=\"icon-chevron-left\"></i></div>\r\n			<div class=\"next\"><i class=\"icon-chevron-right\"></i></div>\r\n				<ul>\r\n				{foreach from=$content_list item=node}\r\n					<li>\r\n						<div class=\"text\">\r\n							<h2 class=\"title\"><span>{$node.name|strip_tags|truncate:20:\"...\":true}</span></h2>\r\n							<h3 class=\"subtitle\"><span>{lang}best buy!{/lang}</span></h3>\r\n							<p class=\"description\">{$node.description|strip_tags|truncate:130:\"...\":true}</p>\r\n							<a href=\"{$node.url}\" class=\"btn\">{lang}read more{/lang}</a>\r\n						</div>\r\n						<img class=\"image\" src=\"{$node.image}\" alt=\"{$node.name}\" />\r\n					</li>\r\n				{/foreach}\r\n				</ul>\r\n		</div>\r\n	</div>\r\n</section>\r\n{/if}','2013-10-08 18:39:12','2013-10-10 23:39:26','content_listing')	;

DROP TABLE IF EXISTS modules;
CREATE TABLE `modules` (
  `id` int(10) auto_increment,
  `name` varchar(255) collate utf8_unicode_ci,
  `icon` varchar(255) collate utf8_unicode_ci,
  `alias` varchar(255) collate utf8_unicode_ci,
  `version` varchar(10) collate utf8_unicode_ci,
  `nav_level` int(4),
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `modules` (`id`, `name`, `icon`, `alias`, `version`, `nav_level`) VALUES 
(1, 'reviews', 'cus-user-comment', 'reviews', '1.0', 3),
(2, 'coupons', 'cus-calculator', 'coupons', '2', 3);

DROP TABLE IF EXISTS module_coupons;
CREATE TABLE `module_coupons` (
  `id` int(10) auto_increment,
  `name` varchar(255) collate utf8_unicode_ci,
  `code` varchar(255) collate utf8_unicode_ci,
  `free_shipping` varchar(10) collate utf8_unicode_ci,
  `percent_off_total` double,
  `amount_off_total` double,
  `max_uses` int(10),
  `min_product_count` int(10),
  `max_product_count` int(10),
  `min_order_total` int(10),
  `max_order_total` int(10),
  `start_date` datetime,
  `expiration_date` datetime,
  `created` datetime,
  `modified` datetime,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS module_reviews;
CREATE TABLE `module_reviews` (
  `id` int(10) auto_increment,
  `content_id` int(10),
  `name` varchar(255) collate utf8_unicode_ci,
  `content` text collate utf8_unicode_ci,
  `created` datetime,
  `modified` datetime,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS orders;
CREATE TABLE `orders` (
  `id` int(10) auto_increment,
  `customer_id` int(10),
  `order_status_id` int(10),
  `shipping_method_id` int(10),
  `payment_method_id` int(10),
  `shipping` double,
  `tax` double,
  `total` double,
  `bill_name` varchar(255) collate utf8_unicode_ci,
  `bill_line_1` varchar(255) collate utf8_unicode_ci,
  `bill_line_2` varchar(255) collate utf8_unicode_ci,
  `bill_city` varchar(255) collate utf8_unicode_ci,
  `bill_state` varchar(255) collate utf8_unicode_ci,
  `bill_country` varchar(255) collate utf8_unicode_ci,
  `bill_zip` varchar(255) collate utf8_unicode_ci,
  `ship_name` varchar(255) collate utf8_unicode_ci,
  `ship_line_1` varchar(255) collate utf8_unicode_ci,
  `ship_line_2` varchar(255) collate utf8_unicode_ci,
  `ship_city` varchar(255) collate utf8_unicode_ci,
  `ship_state` varchar(255) collate utf8_unicode_ci,
  `ship_country` varchar(255) collate utf8_unicode_ci,
  `ship_zip` varchar(255) collate utf8_unicode_ci,
  `email` varchar(255) collate utf8_unicode_ci,
  `phone` varchar(15) collate utf8_unicode_ci,
  `company_name` varchar(255) collate utf8_unicode_ci,
  `company_info` varchar(255) collate utf8_unicode_ci,
  `company_vat` varchar(255) collate utf8_unicode_ci DEFAULT NULL,
  `created` datetime,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `orders` (`id`, `customer_id`, `order_status_id`, `shipping_method_id`, `payment_method_id`, `shipping`, `tax`, `total`, `bill_name`, `bill_line_1`, `bill_line_2`, `bill_city`, `bill_state`, `bill_country`, `bill_zip`, `ship_name`, `ship_line_1`, `ship_line_2`, `ship_city`, `ship_state`, `ship_country`, `ship_zip`, `email`, `phone`, `company_name`, `company_info`, `created`) VALUES 
(1, 0, 1, 2, 2, 0, 0, 25.79, 'Test Order', 'asdfasf', 'asdfasdf', '', '', '', '', 'Test Order', '', '', '', '', '', '', 'vam@test.com', '', '', '', '2009-08-28 11:06:18');

DROP TABLE IF EXISTS order_comments;
CREATE TABLE `order_comments` (
  `id` int(10) auto_increment,
  `user_id` int(10),
  `order_id` int(10),
  `sent_to_customer` tinyint(4),
  `comment` text collate utf8_unicode_ci,
  `created` datetime,
  `modified` datetime,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `order_comments` (`id`, `user_id`, `order_id`, `sent_to_customer`, `comment`, `created`, `modified`) VALUES 
(1, 1, 1, 0, 'asdf', '2009-08-28 11:06:18', '2009-08-28 11:06:18');

DROP TABLE IF EXISTS order_products;
CREATE TABLE `order_products` (
  `id` int(10) auto_increment,
  `order_id` int(10),
  `content_id` int(10),
  `name` varchar(255) collate utf8_unicode_ci,
  `model` varchar(255) collate utf8_unicode_ci,
  `quantity` int(10),
  `price` double,
  `weight` varchar(10) collate utf8_unicode_ci,
  `tax` double,
  `filename` varchar(255) COLLATE utf8_unicode_ci,
  `filestorename` varchar(255) COLLATE utf8_unicode_ci,
  `download_count` int(11),
  `max_downloads` int(10) DEFAULT '0',
  `max_days_for_download` int(10) DEFAULT '0',
  `download_key` varchar(256) COLLATE utf8_unicode_ci,
  `order_status_id` int(10),
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `order_products` (`id`, `order_id`, `content_id`, `name`, `model`, `quantity`, `price`, `weight`, `tax`) VALUES 
(1, 1, 38, 'Mozilla Firefox', '', 3, 4.95, '', 0),
(2, 1, 37, 'Internet Explorer', '', 2, 10.99, '', 0);

DROP TABLE IF EXISTS order_statuses;
CREATE TABLE `order_statuses` (
  `id` int(10) auto_increment,
  `default` tinyint(4),
  `order` int(4),
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `order_statuses` (`id`, `default`, `order`) VALUES 
(1, 1, 1),
(2, 0, 2),
(3, 0, 3),
(4, 0, 4);

DROP TABLE IF EXISTS order_status_descriptions;
CREATE TABLE `order_status_descriptions` (
  `id` int(10) auto_increment,
  `order_status_id` int(10),
  `language_id` int(10),
  `name` varchar(255) collate utf8_unicode_ci,
  `description` text collate utf8_unicode_ci,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `order_status_descriptions` (`id`, `order_status_id`, `language_id`, `name`, `description`) VALUES 
(1, 1, 1, 'Pending', ''),
(2, 1, 2, 'Ожидает проверки', ''),
(3, 2, 1, 'Processing', ''),
(4, 2, 2, 'Обрабатывается', ''),
(5, 3, 1, 'Delivering', ''),
(6, 3, 2, 'Доставляется', ''),
(7, 4, 1, 'Delivered', ''),
(8, 4, 2, 'Доставлен', '');

DROP TABLE IF EXISTS payment_methods;
CREATE TABLE `payment_methods` (
  `id` int(10) auto_increment,
  `active` tinyint(4),
  `default` tinyint(4),
  `name` varchar(255) collate utf8_unicode_ci,
  `icon` varchar(255) collate utf8_unicode_ci,
  `alias` varchar(255) collate utf8_unicode_ci,
  `order` int(10),
  `order_status_id` int(10),
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `payment_methods` (`id`, `active`, `default`, `name`, `icon`, `alias`, `order`, `order_status_id`) VALUES 
(1, 1, 0, 'In-store Pickup', '', 'StorePickup', 0, 0),
(2, 1, 1, 'Money Order Check', '', 'MoneyOrderCheck', 0, 0),
(3, 1, 0, 'Paypal', 'paypal.png', 'Paypal', 0, 0),
(4, 1, 0, 'Credit Card', '', 'CreditCard', 0, 0),
(5, 1, 0, 'Authorize.Net', '', 'Authorize', 0, 0),
(6, 1, 0, 'Google Checkout', '', 'GoogleHtml', 0, 0);

DROP TABLE IF EXISTS payment_method_values;
CREATE TABLE `payment_method_values` (
  `id` int(10) auto_increment,
  `payment_method_id` int(10),
  `key` varchar(255) collate utf8_unicode_ci,
  `value` varchar(255) collate utf8_unicode_ci,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `payment_method_values` (`id`, `payment_method_id`, `key`, `value`) VALUES 
(1, 3, 'paypal_email', 'vam@test.com'),
(2, 5, 'authorize_login', '123456'),
(3, 6, 'google_html_merchant_id', '1234567890');

DROP TABLE IF EXISTS search_tables;
CREATE TABLE `search_tables` (
  `id` int(10) auto_increment,
  `model` varchar(255) collate utf8_unicode_ci,
  `field` varchar(255) collate utf8_unicode_ci,
  `url` varchar(255) collate utf8_unicode_ci,
  `edit_field` varchar(255) collate utf8_unicode_ci,
  `alternate_anchor` varchar(255) collate utf8_unicode_ci,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `search_tables` (`id`, `model`, `field`, `url`, `edit_field`, `alternate_anchor`) VALUES 
(1, 'Content', 'alias', '/contents/admin_edit/', 'id', ''),
(2, 'Content', 'head_data', '/contents/admin_edit/', 'content_id', ''),
(3, 'ContentDescription', 'name', '/contents/admin_edit/', 'content_id', ''),
(4, 'ContentDescription', 'description', '/contents/admin_edit/', 'content_id', 'name'),
(5, 'ContentLink', 'url', '/contents/admin_edit/', 'content_id', ''),
(6, 'Language', 'name', '/languages/admin_edit/', 'id', ''),
(7, 'DefinedLanguage', 'key', '/defined_languages/admin_edit/', 'key', ''),
(8, 'DefinedLanguage', 'value', '/defined_languages/admin_edit/', 'key', ''),
(9, 'Template', 'name', '/templates/admin_edit_microplate/', 'id', ''),
(10, 'Template', 'template', '/templates/admin_edit_microplate/', 'id', 'name'),
(11, 'Stylesheet', 'name', '/stylesheets/admin_edit/', 'id', ''),
(12, 'Stylesheet', 'stylesheet', '/stylesheets/admin_edit/', 'id', 'name');

DROP TABLE IF EXISTS shipping_methods;
CREATE TABLE `shipping_methods` (
  `id` int(10) auto_increment,
  `name` varchar(255) collate utf8_unicode_ci,
  `icon` varchar(255) collate utf8_unicode_ci,
  `code` varchar(255) collate utf8_unicode_ci,
  `default` tinyint(4) default '0',
  `active` tinyint(4),
  `order` int(10),
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `shipping_methods` (`id`, `name`, `icon`, `code`, `default`, `active`, `order`) VALUES 
(1, 'Free Shipping', '', 'FreeShipping', 0, 1, 0),
(2, 'Flat Rate', '', 'FlatRate', 1, 1, 0),
(3, 'Per Item', '', 'PerItem', 0, 1, 0),
(4, 'Table Based', '', 'TableBased', 0, 1, 0);

DROP TABLE IF EXISTS shipping_method_values;
CREATE TABLE `shipping_method_values` (
  `id` int(10) auto_increment,
  `shipping_method_id` int(10),
  `key` varchar(255) collate utf8_unicode_ci,
  `value` varchar(255) collate utf8_unicode_ci,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `shipping_method_values` (`id`, `shipping_method_id`, `key`, `value`) VALUES 
(1, 3, 'per_item_amount', '1'),
(2, 3, 'per_item_handling', '5.00'),
(3, 4, 'table_based_type', 'weight'),
(4, 4, 'table_based_rates', '0:0.50,\r\n1:1.50,\r\n2:2.25,\r\n3:3.00,\r\n4:5.75'),
(5, 2, 'cost', '0');

DROP TABLE IF EXISTS stylesheets;
CREATE TABLE `stylesheets` (
  `id` int(10) auto_increment,
  `active` tinyint(4),
  `name` varchar(255) collate utf8_unicode_ci,
  `alias` varchar(255) collate utf8_unicode_ci,
  `stylesheet` text collate utf8_unicode_ci,
  `stylesheet_media_type_id` int(10),
  `created` datetime,
  `modified` datetime,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `stylesheets` (`id`, `active`, `name`, `alias`, `stylesheet`, `stylesheet_media_type_id`, `created`, `modified`) VALUES
(1, 1, 'VamCart', 'vamcart', '/* -----------------------------------------------------------------------------------------\r\n   VamCart - http://vamcart.com\r\n   -----------------------------------------------------------------------------------------\r\n   Copyright (c) 2013 VamSoft Ltd.\r\n   License - http://vamcart.com/license.html\r\n   ---------------------------------------------------------------------------------------*/\r\n\r\nhtml,body\r\n  {\r\n    margin: 0;\r\n    padding: 0;\r\n    background-color: #fff;\r\n    background-image: url(../../img/bg.png);\r\n    background-position: 0 -221px;\r\n    background-repeat: repeat-x;\r\n  }\r\n\r\nbody\r\n  {\r\n    font-family: ''Lucida Grande'', Helvetica, Arial, Verdana, sans-serif;\r\n    font-size: 11pt;\r\n  }\r\n\r\nimg\r\n	{\r\n		border: 0;\r\n	}\r\n\r\nh2 img\r\n	{\r\n		border: 0;\r\n		padding: 0;\r\n		margin: 0 0 5px 0;\r\n	}\r\n\r\nul, li\r\n  {\r\n    list-style: none;\r\n    margin: 0;\r\n    padding: 0;\r\n  }\r\n\r\n/* Links color */\r\na\r\n  {\r\n    color: #000;\r\n    text-decoration: underline;\r\n  }\r\n\r\na:hover\r\n  {\r\n    color: #990000;\r\n    text-decoration: none;\r\n  }\r\n/* /Links color */\r\n\r\n/* Content */\r\ndiv#wrapper\r\n  {\r\n    float: left;\r\n    width: 100%;\r\n  }\r\n\r\ndiv#content\r\n  {\r\n    margin: 0 19%;\r\n  }\r\n\r\ndiv#content a, \r\ndiv#content a:visited,\r\ndiv#content a:hover  \r\n	{\r\n		color: #494a4e;\r\n		text-decoration: none;\r\n	}\r\n\r\ndiv#header a, \r\ndiv#header a:visited, \r\ndiv#header a:hover \r\n	{\r\n		color: #494a4e;\r\n		text-decoration: none;\r\n	}\r\n	\r\n/* /Content */\r\n\r\n/* Left column */\r\ndiv#left\r\n  {\r\n    float: left;\r\n    width: 18%;\r\n    margin-left: -100%;\r\n    background: transparent;\r\n  }\r\n/* /Left column */\r\n\r\n/* Right column */\r\ndiv#right\r\n  {\r\n    float: left;\r\n    overflow: auto;\r\n    width: 18%;\r\n    margin-left: -18%;\r\n    background: transparent;\r\n  }\r\n/* /Right column */\r\n\r\n/* Header */\r\n\r\n#header\r\n  {\r\n    background-color: #fff;\r\n    background-image: url(../../img/bg.png);\r\n    background-position: 0 0;\r\n    background-repeat: repeat-x;\r\n    height: 100px;\r\n  }\r\n\r\n\r\n#header div.header-left\r\n  {\r\n    float: left;\r\n    margin: 0;\r\n    padding: 0;\r\n  }\r\n\r\n\r\n#header div.header-right\r\n  {\r\n    float: right;\r\n    margin: 0;\r\n    padding: .3em;\r\n  }\r\n\r\n/* /Header */\r\n\r\n/* Footer */\r\ndiv#footer\r\n  {\r\n    clear: left;\r\n    height: 50px;\r\n    width: 100%;\r\n    background: transparent;\r\n    border-top: 0px solid #67748B;\r\n    text-align: center;\r\n    color: #000;\r\n  }\r\n   \r\ndiv#footer p\r\n  {\r\n    margin: 0;\r\n    padding: 5px 10px;\r\n  }\r\n   \r\n/* /Footer */\r\n\r\n/* Navigation */\r\n/* /Navigation */\r\n   \r\n/* Page header */\r\n\r\n#content h1,\r\n#content h2,\r\n#content h3\r\n  {\r\n    color: #ff7b08;\r\n    font-weight: bold;\r\n    font-size: 12pt;\r\n  }\r\n\r\n/* /Page header */\r\n\r\n/* Page content */\r\n\r\ndiv.page\r\n  {\r\n    margin: 0;\r\n    padding: 0;\r\n  }\r\n\r\ndiv.page h2\r\n  {\r\n    margin: 0;\r\n    padding: 7px 0 7px 10px;\r\n    background-color: #f4f4f4;\r\n    background-image: url(../../img/bg.png);\r\n    background-position: 0 -135px;\r\n    background-repeat: repeat-x;\r\n    border-top: 1px solid #c0c1c2;\r\n    border-left: 1px solid #c0c1c2;\r\n    border-right: 1px solid #c0c1c2;\r\n    border-bottom: 1px solid #c0c1c2;\r\n    border-top-left-radius: 8px;\r\n    border-top-right-radius: 8px;\r\n    vertical-align: middle;\r\n  }\r\n  \r\ndiv.pageContent\r\n  {\r\n    margin: 0;\r\n    padding: .5em;\r\n    background-color: #fff;\r\n    background-image: url(../../img/bg.png);\r\n    background-position: 0 -602px;\r\n    background-repeat: repeat-x;\r\n    border-top: 0px;\r\n    border-left: 1px solid #c0c1c2;\r\n    border-right: 1px solid #c0c1c2;\r\n    border-bottom: 1px solid #c0c1c2;\r\n    border-bottom-left-radius: 8px;\r\n    border-bottom-right-radius: 8px;\r\n  }\r\n\r\n/* /Page content */\r\n\r\n/*- Menu */\r\n\r\ndiv#menu\r\n  {\r\n    border-top: 3px solid #ff7b08;\r\n    background-color: #fff;\r\n    background-image: url(../../img/bg.png);\r\n    background-position: 0 -100px;\r\n    background-repeat: repeat-x;\r\n    padding: 0;\r\n    margin: 0 auto;\r\n  }\r\n\r\n#menu ul, #menu ul li\r\n  {\r\n    list-style: none;\r\n    margin: 0;\r\n    padding: 0;\r\n  }\r\n\r\n#menu ul\r\n  {\r\n    padding: 3px 0 3px;\r\n    text-align: center;\r\n  }\r\n\r\n#menu ul li\r\n  {\r\n    display: inline;\r\n    margin-right: .3em;\r\n  }\r\n\r\n#menu ul li.current a\r\n  {\r\n    display: inline;\r\n    color: #fff;\r\n    background: #ff7b08;\r\n    margin-right: .3em;\r\n  }\r\n\r\n#menu ul li a\r\n  {\r\n    color: #000;\r\n    padding: 5px 0;\r\n    text-decoration: none;\r\n  }\r\n\r\n#menu ul li a span\r\n  {\r\n    padding: 5px .5em;\r\n  }\r\n\r\n#menu ul li a:hover span\r\n  {\r\n    color: #fff;\r\n    text-decoration: none;\r\n  }\r\n\r\n#menu ul li a:hover\r\n  {\r\n    color: #69C;\r\n    background: #ff7b08;\r\n    text-decoration: none;\r\n  }\r\n\r\n/*\\*//*/\r\n#menu ul li a\r\n  {\r\n    display: inline-block;\r\n    white-space: nowrap;\r\n    width: 1px;\r\n  }\r\n\r\n#menu ul\r\n  {\r\n    padding-bottom: 0;\r\n    margin-bottom: -1px;\r\n  }\r\n/**/\r\n\r\n/*\\*/\r\n* html #menu ul li a\r\n  {\r\n    padding: 0;\r\n  }\r\n/**/\r\n    \r\n/*- /Menu */\r\n\r\n/*- Boxes */\r\n\r\n/*- Box */\r\n.box\r\n  {\r\n    margin: 0 .5em .5em .5em;\r\n    padding: 0;\r\n  }\r\n\r\n/*- Box Header */\r\n.box h5\r\n  {\r\n    color: #ff7b08;\r\n    font-weight: bold;\r\n    font-size: 12pt;\r\n    margin: 0;\r\n    padding: 7px 0 7px 10px;\r\n    background-color: #f4f4f4;\r\n    background-image: url(../../img/bg.png);\r\n    background-position: 0 -135px;\r\n    background-repeat: repeat-x;\r\n    border-top: 1px solid #c0c1c2;\r\n    border-left: 1px solid #c0c1c2;\r\n    border-right: 1px solid #c0c1c2;\r\n    border-bottom: 1px solid #c0c1c2;\r\n    border-top-left-radius: 8px;\r\n    border-top-right-radius: 8px;\r\n    vertical-align: middle;\r\n  }\r\n\r\n.box h5 a\r\n  {\r\n    color: #ff7b08;\r\n    font-weight: bold;\r\n    font-size: 12pt;\r\n    text-decoration: none;\r\n  }\r\n/*- /Box Header */\r\n\r\n/*- Box Content */\r\n.boxContent\r\n  {\r\n    margin: 0;\r\n    padding: .5em;\r\n    background-color: #fff;\r\n    background-image: url(../../img/bg.png);\r\n    background-position: 0 -602px;\r\n    background-repeat: repeat-x;\r\n    border-top: 0px;\r\n    border-left: 1px solid #c0c1c2;\r\n    border-right: 1px solid #c0c1c2;\r\n    border-bottom: 1px solid #c0c1c2;\r\n    border-bottom-left-radius: 8px;\r\n    border-bottom-right-radius: 8px;\r\n  }\r\n\r\n.boxContent.center\r\n  {\r\n    margin: 0 auto;\r\n    text-align: center;\r\n    padding: .5em;\r\n    background-color: #fff;\r\n    background-image: url(../../img/bg.png);\r\n    background-position: 0 -602px;\r\n    background-repeat: repeat-x;\r\n    border-top: 0px;\r\n    border-left: 1px solid #c0c1c2;\r\n    border-right: 1px solid #c0c1c2;\r\n    border-bottom: 1px solid #c0c1c2;\r\n    border-bottom-left-radius: 8px;\r\n    border-bottom-right-radius: 8px;\r\n  }\r\n  \r\n#boxContent p\r\n  {\r\n    margin: 0;\r\n    padding: 0;\r\n  }\r\n\r\n/*- /Box Content */\r\n\r\n/*- /Box */\r\n\r\n/*- /Boxes */\r\n\r\n/* Buttons */\r\n\r\n.btn\r\n	{\r\n		margin: 2px;\r\n	}\r\n\r\n/* /Buttons */\r\n\r\n/* Forms */\r\n\r\nform\r\n  {\r\n    padding: 0;\r\n    margin: 0;\r\n  }\r\n\r\nfieldset\r\n  {\r\n    border: 0px;\r\n  }\r\n\r\nlegend\r\n  {\r\n    font-size: 12pt;\r\n    font-weight: bold;\r\n    color: #ff9c0f;\r\n    margin-bottom: .5em;\r\n    padding: 0;\r\n  }\r\n\r\nlabel\r\n  {\r\n    color: #545452;\r\n    padding: 0 10px 0 10px;\r\n    margin-bottom: 0;\r\n  }\r\n\r\n  \r\ninput\r\n  {\r\n    border: 1px solid;\r\n    border-color: #666 #ccc #ccc #666;\r\n    padding: .2em;\r\n    margin: .2em;\r\n    border-top-left-radius: 4px;\r\n    border-top-right-radius: 4px;\r\n    border-bottom-left-radius: 4px;\r\n    border-bottom-right-radius: 4px;\r\n  }\r\n\r\n\r\nselect\r\n  {\r\n    margin-left: .5em;\r\n    border-top-left-radius: 4px;\r\n    border-top-right-radius: 4px;\r\n    border-bottom-left-radius: 4px;\r\n    border-bottom-right-radius: 4px;\r\n  }\r\n\r\ntextarea\r\n  {\r\n    overflow: auto;\r\n    width: 80%;\r\n    height: 25em;\r\n    border: 1px solid;\r\n    border-color: #666 #ccc #ccc #666;\r\n    padding: .3em;\r\n    border-top-left-radius: 4px;\r\n    border-top-right-radius: 4px;\r\n    border-bottom-left-radius: 4px;\r\n    border-bottom-right-radius: 4px;\r\n  }\r\n\r\ntextarea:focus, input:focus, .sffocus, .sffocus\r\n  {\r\n    background-color: #ffc;\r\n  }\r\n\r\nlabel.error \r\n  {\r\n    margin-left: 10px;\r\n    width: auto;\r\n    display: inline;\r\n    color: red;\r\n    font-weight: normal;\r\n    background: transparent;\r\n}\r\n\r\n.error\r\n   {\r\n    background: #fcc;\r\n   }\r\n     \r\n/* /Forms */\r\n\r\n/* Tables */\r\n\r\ndiv#content table.contentTable\r\n	{\r\n		width: 100%;\r\n		padding: 0 0 0 0;\r\n		margin: 0 0 .2em 0;\r\n		border: 1px solid #97a5b0;\r\n		border-top-left-radius: 4px;\r\n		border-top-right-radius: 4px;\r\n		border-bottom-left-radius: 4px;\r\n		border-bottom-right-radius: 4px;\r\n	}\r\n\r\ndiv#content table.contentTable tr\r\n	{\r\n		padding: 0;\r\n		margin: 0;\r\n	}\r\n\r\ndiv#content table.contentTable tr.contentRowEven\r\n	{\r\n		padding: 0;\r\n		margin: 0;\r\n		background: #f7f7f7;\r\n	}\r\n\r\ndiv#content table.contentTable tr.contentRowOdd\r\n	{\r\n		padding: 0;\r\n		margin: 0;\r\n		background: #fff;\r\n	}\r\n\r\ndiv#content table.contentTable tr.contentRowEvenHover,\r\ndiv#content table.contentTable tr.contentRowOddHover\r\n	{\r\n		padding: 0;\r\n		margin: 0;\r\n		background: #ffc;\r\n	}\r\n\r\ndiv#content table.contentTable th\r\n	{\r\n		color: #000;\r\n		font-weight: normal;\r\n		padding: .9em;\r\n		margin: 0;\r\n		background-color: #e3eff7;\r\n		background-image: url(../../img/bg.png);\r\n		background-position: 0 0;\r\n		background-repeat: repeat-x; \r\n		border: 1px solid #97a5b0;\r\n		border-top-left-radius: 4px;\r\n		border-top-right-radius: 4px;\r\n		border-bottom-left-radius: 4px;\r\n		border-bottom-right-radius: 4px;\r\n	}\r\n\r\ndiv#content table.contentTable td\r\n	{\r\n		padding: .3em .3em .3em .3em;\r\n		margin: 0;\r\n	}\r\n\r\n/* Pagination */\r\n	\r\ndiv#content table.contentPagination\r\n	{\r\n		padding: 0;\r\n		margin: 0;\r\n	}\r\n\r\ndiv#content table.contentPagination tr\r\n	{\r\n		padding: 0;\r\n		margin: 0;\r\n	}\r\n\r\ndiv#content table.contentPagination td\r\n	{\r\n		padding: 0;\r\n		margin: 0;\r\n	}\r\n\r\n/* /Pagination */\r\n\r\n/* Orders */\r\n	\r\ndiv#content table.orderTable\r\n	{\r\n		width: 100%;\r\n		padding: 0;\r\n		margin: 0;\r\n	}\r\n\r\ndiv#content table.orderTable tr\r\n	{\r\n		padding: 0;\r\n		margin: 0;\r\n	}\r\n\r\ndiv#content table.orderTable td\r\n	{\r\n		padding: .3em .3em .3em .3em;\r\n		margin: 0;\r\n	}\r\n\r\ndiv.search-f {\r\n	float: right;\r\n	margin: 0 9px;\r\n}\r\n\r\ndiv.search-f label {\r\n	display: none;\r\n}\r\n\r\ndiv.search-f .submit {\r\n	display: none;\r\n}\r\n/* /Orders */\r\n\r\ndiv#content .noData\r\n	{\r\n		padding: .5em;\r\n		margin: 0;\r\n		background: transparent;\r\n	}\r\n	\r\n\r\n/* /Tables */\r\n\r\n/* Pagination */\r\n.paginator ul\r\n  {\r\n    list-style:none;\r\n  }\r\n\r\n.paginator ul li\r\n  {\r\n    display:inline;\r\n  }\r\n\r\n.paginator ul li a.current\r\n  {\r\n    font-weight:bold;\r\n  }\r\n/* /Pagination */\r\n.back {  float: right;\r\n}\r\n\r\ninput.button {\r\n  margin: 0 5px;\r\n  cursor: pointer;\r\n}\r\n\r\n.total-value {\r\n  float: right;\r\n}\r\n\r\n#login-form .label {\r\n  float: left;\r\n  width: 200px;\r\n}', 0, '2009-07-14 18:44:00', '2013-07-12 14:12:17');

DROP TABLE IF EXISTS stylesheet_media_types;
CREATE TABLE `stylesheet_media_types` (
  `id` int(10) auto_increment,
  `name` varchar(255) collate utf8_unicode_ci,
  `type` varchar(255) collate utf8_unicode_ci,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `stylesheet_media_types` (`id`, `name`, `type`) VALUES 
(1, 'all : Suitable for all devices.', 'all'),
(2, 'aural : Intended for speech synthesizers.', 'aural'),
(3, 'braille : Intended for braille tactile feedback de', 'braille'),
(4, 'embossed : Intended for paged braille printers.', 'embossed'),
(5, 'handheld : Intended for handheld devices', 'handheld'),
(6, 'print : Intended for paged, opaque material and fo', 'print'),
(7, 'projection : Intended for projected presentations,', 'projection'),
(8, 'screen : Intended primarily for color computer scr', 'screen'),
(9, 'tty : Intended for media using a fixed-pitch chara', 'tty'),
(10, 'tv : Intended for television-type devices.', 'tv'),
(11, 'iPhone specific', 'only screen and (max-device-width: 480px)');

DROP TABLE IF EXISTS taxes;
CREATE TABLE `taxes` (
  `id` int(10) auto_increment,
  `default` tinyint(4),
  `name` varchar(255) collate utf8_unicode_ci,
  `created` datetime,
  `modified` datetime,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `taxes` (`id`, `default`, `name`, `created`, `modified`) VALUES 
(1, 1, 'Non-Taxable', '2009-08-03 20:39:02', '2009-08-06 10:03:37'),
(2, 0, 'United States - VA Sales Tax', '2009-08-05 20:18:46', '2009-08-06 10:03:52');

DROP TABLE IF EXISTS tax_country_zone_rates;
CREATE TABLE `tax_country_zone_rates` (
  `id` int(10) auto_increment,
  `tax_id` int(10),
  `country_zone_id` int(10),
  `rate` double,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `tax_country_zone_rates` (`id`, `tax_id`, `country_zone_id`, `rate`) VALUES 
(1, 2, 51, 5);

DROP TABLE IF EXISTS templates;
CREATE TABLE `templates` (
  `id` int(10) auto_increment,
  `parent_id` int(10),
  `template_type_id` int(10),
  `default` tinyint(4) default '0',
  `name` varchar(255) collate utf8_unicode_ci,
  `template` text collate utf8_unicode_ci,
  `created` datetime,
  `modified` datetime,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `templates` (`id`, `parent_id`, `template_type_id`, `default`, `name`, `template`, `created`, `modified`) VALUES
(1, 0, 0, 1, 'Default Theme', '', '2013-10-01 16:07:25', '2013-04-17 16:07:25'),
(2, 1, 1, 0, 'Main Layout', '<!DOCTYPE html>\r\n<html>\r\n\r\n<head>\r\n	{meta_description}\r\n	{meta_keywords}\r\n	{metadata}\r\n	{headdata}\r\n	<title>{config value=site_name} - {page_name}</title>\r\n	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"/>\r\n	<meta name=\"viewport\" content=\"width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no\"/>\r\n\r\n	<link rel=\"apple-touch-icon-precomposed\" sizes=\"144x144\" href=\"{base_path}/img/ico/apple-touch-icon-144-precomposed.png\"/>\r\n	<link rel=\"apple-touch-icon-precomposed\" sizes=\"114x114\" href=\"{base_path}/img/ico/apple-touch-icon-114-precomposed.png\"/>\r\n	<link rel=\"apple-touch-icon-precomposed\" sizes=\"72x72\" href=\"{base_path}/img/ico/apple-touch-icon-72-precomposed.png\"/>\r\n	<link rel=\"apple-touch-icon-precomposed\" href=\"{base_path}/img/ico/apple-touch-icon-57-precomposed.png\"/>\r\n	<link rel=\"shortcut icon\" href=\"{base_path}/favicon.ico\"/>\r\n\r\n	<script type=\"text/javascript\" src=\"{base_path}/js/jquery/jquery.min.js\"></script>\r\n	<script type=\"text/javascript\" src=\"{base_path}/js/bootstrap/bootstrap.min.js\"></script>\r\n	<script type=\"text/javascript\" src=\"{base_path}/js/jquery/plugins/jquery.easing.1.3.js\"></script>\r\n	<script type=\"text/javascript\" src=\"{base_path}/js/vamcart.js\"></script>\r\n	<script type=\"text/javascript\" src=\"{base_path}/js/jquery/plugins/lightbox/jquery.lightbox.js\"></script>\r\n\r\n	<link rel=\"stylesheet\" type=\"text/css\" href=\"{base_path}/css/bootstrap/bootstrap.css\"/>\r\n	<link rel=\"stylesheet\" type=\"text/css\" href=\"{base_path}/css/bootstrap/cus-icons.css\"/>\r\n	<link rel=\"stylesheet\" type=\"text/css\" href=\"{base_path}/css/vamcart.css\"/>\r\n	<link rel=\"stylesheet\" type=\"text/css\" href=\"{base_path}/css/font-awesome.min.css\"/>\r\n	<link rel=\"stylesheet\" type=\"text/css\" href=\"{base_path}/css/lightbox/jquery.lightbox.css\" media=\"screen\" />\r\n	<!--[if IE 7]>\r\n	<link rel=\"stylesheet\" type=\"text/css\" href=\"{base_path}/css/font-awesome-ie7.min.css\"/>\r\n	<![endif]-->\r\n\r\n	<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->\r\n	<!--[if lt IE 9]>\r\n	<script type=\"text/javascript\" src=\"{base_path}/js/html5.js\"></script>\r\n	<![endif]-->\r\n</head>\r\n\r\n<body>\r\n\r\n{google_analytics}\r\n{yandex_metrika}\r\n\r\n<!-- start: TOP BAR -->\r\n<div class=\"topbar clearfix\">\r\n	<div class=\"container\">\r\n		<ul class=\"nav nav-pills top-contacts pull-left\">\r\n			<li><a href=\"\"><i class=\"icon-phone\"></i> {config value=telephone}</a></li>\r\n			<li><a href=\"{config value=twitter}\"><i class=\"icon-twitter\"></i> Twitter</a></li>\r\n			<li><a href=\"{config value=facebook}\"><i class=\"icon-facebook\"></i> Facebook</a></li>\r\n		</ul>\r\n		<ul class=\"nav nav-pills top-menu pull-right\">\r\n			<li><a href=\"{base_path}\">{lang}Home{/lang}</a></li>\r\n			{content_listing template=\'news-dropdown\' parent=\'69\' type=\'news\' limit=\'5\'}\r\n			<li><a href=\"{base_path}/page/contact-us.html\">{lang}Contact Us{/lang}</a></li>\r\n		</ul>\r\n	</div>\r\n</div>\r\n<!-- end: TOP BAR -->\r\n\r\n<!-- start: Header -->\r\n<div id=\"header\">\r\n	<div class=\"container\">\r\n		<div class=\"row-fluid\">\r\n			<div class=\"span3 logo\">\r\n				<a href=\"{base_path}/\"><img src=\"{base_path}/img/logo.png\" alt=\"{config value=site_name}\" title=\"{config value=site_name}\" /></a>\r\n			</div>\r\n			<div class=\"span6 search\">\r\n					<form class=\"form-search\" action=\"{base_path}/page/search-result.html\" method=\"get\">\r\n						<input type=\"text\" name=\"keyword\" class=\"input-medium\" placeholder=\"{lang}Search{/lang}\">\r\n						<button type=\"submit\" class=\"btn hidden\">{lang}Search{/lang}</button>\r\n					</form>\r\n			</div>\r\n		</div>\r\n	</div>\r\n</div>\r\n<!-- end: Header -->\r\n\r\n<!-- start: Main Menu -->\r\n<div id=\"navigation\" class=\"default\">\r\n	<div class=\"container\">\r\n		<div class=\"login\">\r\n			<a href=\"{base_path}/page/account.html\" class=\"account-avatar\" data-original-title=\"{lang}My Account{/lang}\" data-placement=\"top\" rel=\"tooltip\"><img src=\"{base_path}/img/account.png\" alt=\"\"/></a>\r\n			<a href=\"{base_path}/page/account.html\" class=\"account\" data-original-title=\"{lang}Login{/lang}\" data-placement=\"top\" rel=\"tooltip\"><i class=\"icon-lightbulb\"></i></a>\r\n		</div>\r\n		<div class=\"navbar navbar-static-top\">\r\n			<div class=\"navbar-inner\">\r\n				{content_listing template=\'info-links\' parent=\'44\' limit=\'10\'}\r\n				{shopping_cart template=\'cart-content-box-pull\'}\r\n			</div>\r\n		</div>\r\n	</div>\r\n</div>\r\n<!-- end: Main Menu -->\r\n\r\n<!-- start: Container -->\r\n<div id=\"container\">\r\n	<div class=\"container\">\r\n\r\n		<div class=\"row-fluid\">\r\n\r\n			{flash_message}\r\n\r\n			{if isset($is_compared)}{compared}{else}{content}{/if}\r\n\r\n		<!-- start: Sidebar -->\r\n		<aside class=\"span3 sidebar pull-left\">\r\n\r\n			{shopping_cart template=\'cart-content-box\'}\r\n			{content_listing template=\'search-box\'}\r\n			{content_listing template=\'categories-box\' parent=\'0\' type=\'category\'}\r\n			{filter}\r\n			{login_box}\r\n			{compare}\r\n			{language_box}\r\n			{currency_box}\r\n\r\n		</aside>\r\n		<!-- end: Sidebar -->\r\n\r\n		</div>\r\n\r\n	</div>\r\n</div>\r\n<!-- end: Container -->\r\n\r\n<!-- start: Footer -->\r\n<footer id=\"footer\">\r\n	<div class=\"container\">\r\n		<div class=\"row-fluid\">\r\n			<div class=\"span3 clearfix\">\r\n				<h3 class=\"widget-title\">{lang}Information{/lang}</h3>\r\n				<div class=\"widget-inner\">\r\n					{content_listing template=\'footer-links\' parent=\'44\' type=\'page\' limit=\'10\'}\r\n				</div>\r\n			</div>\r\n			<div class=\"span3 clearfix\">\r\n				<h3 class=\"widget-title\">{lang}News{/lang}</h3>\r\n				<div class=\"widget-inner\">\r\n					{content_listing template=\'footer-links\' parent=\'69\' type=\'news\' limit=\'10\'}\r\n				</div>\r\n			</div>\r\n\r\n			<div class=\"span6 clearfix\">\r\n				<h3 class=\"widget-title\">{lang}Articles{/lang}</h3>\r\n				<div class=\"widget-inner\">\r\n					{content_listing template=\'footer-links\' parent=\'70\' type=\'article\' limit=\'10\'}\r\n				</div>\r\n			</div>\r\n		</div>\r\n	</div>\r\n</footer>\r\n<!-- end: Footer -->\r\n\r\n<!-- start: Footer menu -->\r\n<section id=\"footer-menu\">\r\n	<div class=\"container\">\r\n		<div class=\"row-fluid\">\r\n			<div class=\"span6\">\r\n				<ul class=\"privacy inline\">\r\n					<li><a href=\"{base_path}/page/conditions-of-use.html\">{lang}About Us{/lang}</a></li>\r\n					<li><a href=\"{base_path}/page/contact-us.html\">{lang}Contact Us{/lang}</a></li>\r\n				</ul>\r\n				{global_content alias=\'footer\'}\r\n			</div>\r\n		</div>\r\n	</div>\r\n</section>\r\n<!-- end: Footer menu -->\r\n\r\n</body>\r\n</html>', '2013-10-01 16:07:25', '2013-04-17 16:07:25'),
(3, 1, 2, 0, 'Content Page', '<!-- start: Page section -->\r\n	<section class=\"span9 page-sidebar pull-right\">\r\n		<h2>{page_name}</h2>              \r\n			{admin_edit_link}\r\n			{description}\r\n	</section>\r\n<!-- end: Page section -->', '2013-10-01 16:07:25', '2013-04-17 16:07:25'),
(4, 1, 3, 0, 'Product Info', '<script type=\"text/javascript\">\r\n$(document).ready(function(){\r\n  $(\"a.lightbox\").lightBox({\r\n    fixedNavigation:true,\r\n      imageLoading: \"{base_path}/img/jquery/plugins/lightbox/lightbox-ico-loading.gif\",\r\n      imageBtnClose: \"{base_path}/img/jquery/plugins/lightbox/lightbox-btn-close.gif\",\r\n      imageBtnPrev: \"{base_path}/img/jquery/plugins/lightbox/lightbox-btn-prev.gif\",\r\n      imageBtnNext: \"{base_path}/img/jquery/plugins/lightbox/lightbox-btn-next.gif\",      \r\n    });\r\n});\r\n{if ($ajax_enable eq \'1\')}\r\n  function onProductFormSubmit() {\r\n    var str = $(\"#product-form\").serialize();\r\n\r\n    $.post(\"{base_path}/cart/purchase_product\", str, function(data) {\r\n      $(\"#shopping-cart-box\").html(data);\r\n    });\r\n  }\r\n{/if}\r\n</script>\r\n\r\n<!-- start: Page section -->\r\n	<section class=\"span9 page-sidebar pull-right\">\r\n\r\n		<div class=\"row-fluid\">\r\n			<!-- start: Product image -->\r\n				{content_images}\r\n			<!-- end: Product image -->\r\n			<!-- start: Product title -->\r\n				<div class=\"span6 product-info\">\r\n\r\n					<div class=\"inner product-title\">\r\n						<div class=\"row-fluid\">\r\n							<div class=\"span8 title\"><h1>{page_name}</h1></div>\r\n							<div class=\"span4 price\">{product_price}</div>\r\n						</div>\r\n					</div>\r\n\r\n					<div class=\"inner nobottom product-cart\">\r\n							{product_form}\r\n								<label>{lang}Qty{/lang}:</label>\r\n								<input name=\"product_quantity\" id=\"product_quantity\" type=\"text\" value=\"1\" size=\"3\" />\r\n								<button type=\"submit\" class=\"btn btn-inverse\"><i class=\"icon-shopping-cart\"></i> {lang}Add to cart{/lang}</button>\r\n							{/product_form}\r\n					</div>\r\n					\r\n					<div class=\"inner\">\r\n						{attribute_list value_attributes=$node.attributes}\r\n					</div>\r\n\r\n				</div>\r\n			<!-- end: Product title -->\r\n		</div>\r\n\r\n		<div class=\"row-fluid\">\r\n\r\n			<div class=\"row-fluid product-tabs\">\r\n				<section class=\"widget\">\r\n\r\n					<ul class=\"nav nav-tabs\">\r\n						<li class=\"active\"><a href=\"#description\" data-toggle=\"tab\">{lang}Description{/lang}</a></li>\r\n						<li><a href=\"#reviews\" data-toggle=\"tab\">{lang}Reviews{/lang}</a></li>\r\n						<li><a href=\"#add-review\" data-toggle=\"tab\">{lang}Add Review{/lang}</a></li>\r\n					</ul>\r\n\r\n					<div class=\"tab-content\">\r\n\r\n						<div class=\"tab-pane inner notop active\" id=\"description\">\r\n							{description}\r\n						</div>\r\n\r\n						<div class=\"tab-pane inner notop\" id=\"reviews\">\r\n							{module alias=\'reviews\' action=\'display\'}\r\n						</div>\r\n\r\n						<div class=\"tab-pane inner notop\" id=\"add-review\">\r\n							{module alias=\'reviews\' action=\'create\'}\r\n						</div>\r\n\r\n					</div>\r\n				</section>\r\n			</div>\r\n		</div>\r\n\r\n		{xsell}\r\n\r\n	</section>\r\n<!-- end: Page section -->', '2013-10-01 16:07:25', '2013-04-17 16:07:25'),
(5, 1, 4, 0, 'Category Info', '<!-- start: Page section -->\r\n	<section class=\"span9 page-sidebar pull-right\">\r\n		<h2>{page_name}</h2>              \r\n			{admin_edit_link}\r\n			{description}\r\n\r\n		{if $sub_count->value.categories > 0}\r\n			<h3>{lang}Sub Categories{/lang}</h3>\r\n				<div class=\"content_listing\">\r\n					{content_listing template=\'subcategory-listing\' parent={$content_id} type=\'category\'}\r\n				</div>\r\n		{/if}\r\n\r\n		{if $sub_count->value.products + $sub_count->value.downloadables > 0}\r\n			<h3>{lang}Products in this Category{/lang}</h3>\r\n				<div class=\"content_listing\">\r\n					{content_listing template=\'product-listing\' parent={$content_id} page={$page} type=\'product,downloadable\'}\r\n				</div>\r\n		{/if}\r\n	</section>\r\n<!-- end: Page section -->', '2013-10-01 16:07:25', '2013-04-17 16:07:25'),
(6, 1, 5, 0, 'News Page', '<!-- start: Page section -->\r\n	<section class=\"span9 page-sidebar pull-right\">\r\n		<h2>{page_name}</h2>              \r\n			{admin_edit_link}\r\n			{description}\r\n	</section>\r\n<!-- end: Page section -->','2013-10-01 16:07:25','2013-10-09 13:38:52'),
(7, 1, 6, 0, 'Article Page', '<!-- start: Page section -->\r\n	<section class=\"span9 page-sidebar pull-right\">\r\n		<h2>{page_name}</h2>              \r\n			{admin_edit_link}\r\n			{description}\r\n	</section>\r\n<!-- end: Page section -->', '2013-10-01 16:07:25', '2013-04-17 16:07:25'),
(8, 1, 7, 0, 'Downloadable Product Info', '<script type=\"text/javascript\">\r\n$(document).ready(function(){\r\n  $(\"a.lightbox\").lightBox({\r\n    fixedNavigation:true,\r\n      imageLoading: \"{base_path}/img/jquery/plugins/lightbox/lightbox-ico-loading.gif\",\r\n      imageBtnClose: \"{base_path}/img/jquery/plugins/lightbox/lightbox-btn-close.gif\",\r\n      imageBtnPrev: \"{base_path}/img/jquery/plugins/lightbox/lightbox-btn-prev.gif\",\r\n      imageBtnNext: \"{base_path}/img/jquery/plugins/lightbox/lightbox-btn-next.gif\",      \r\n    });\r\n});\r\n{if ($ajax_enable eq \'1\')}\r\n  function onProductFormSubmit() {\r\n    var str = $(\"#product-form\").serialize();\r\n\r\n    $.post(\"{base_path}/cart/purchase_product\", str, function(data) {\r\n      $(\"#shopping-cart-box\").html(data);\r\n    });\r\n  }\r\n{/if}\r\n</script>\r\n\r\n<!-- start: Page section -->\r\n	<section class=\"span9 page-sidebar pull-right\">\r\n\r\n		<div class=\"row-fluid\">\r\n			<!-- start: Product image -->\r\n				{content_images}\r\n			<!-- end: Product image -->\r\n			<!-- start: Product title -->\r\n				<div class=\"span6 product-info\">\r\n\r\n					<div class=\"inner product-title\">\r\n						<div class=\"row-fluid\">\r\n							<div class=\"span8 title\"><h1>{page_name}</h1></div>\r\n							<div class=\"span4 price\">{product_downloadable_price}</div>\r\n						</div>\r\n					</div>\r\n\r\n					<div class=\"inner nobottom product-cart\">\r\n							{product_form}\r\n								<label>{lang}Qty{/lang}:</label>\r\n								<input name=\"product_quantity\" id=\"product_quantity\" type=\"text\" value=\"1\" size=\"3\" />\r\n								<button type=\"submit\" class=\"btn btn-inverse\"><i class=\"icon-shopping-cart\"></i> {lang}Add to cart{/lang}</button>\r\n							{/product_form}\r\n					</div>\r\n					\r\n					<div class=\"inner\">\r\n						{attribute_list value_attributes=$node.attributes}\r\n					</div>\r\n\r\n				</div>\r\n			<!-- end: Product title -->\r\n		</div>\r\n\r\n		<div class=\"row-fluid\">\r\n\r\n			<div class=\"row-fluid product-tabs\">\r\n				<section class=\"widget\">\r\n\r\n					<ul class=\"nav nav-tabs\">\r\n						<li class=\"active\"><a href=\"#description\" data-toggle=\"tab\">{lang}Description{/lang}</a></li>\r\n						<li><a href=\"#reviews\" data-toggle=\"tab\">{lang}Reviews{/lang}</a></li>\r\n						<li><a href=\"#add-review\" data-toggle=\"tab\">{lang}Add Review{/lang}</a></li>\r\n					</ul>\r\n\r\n					<div class=\"tab-content\">\r\n\r\n						<div class=\"tab-pane inner notop active\" id=\"description\">\r\n							{description}\r\n						</div>\r\n\r\n						<div class=\"tab-pane inner notop\" id=\"reviews\">\r\n							{module alias=\'reviews\' action=\'display\'}\r\n						</div>\r\n\r\n						<div class=\"tab-pane inner notop\" id=\"add-review\">\r\n							{module alias=\'reviews\' action=\'create\'}\r\n						</div>\r\n\r\n					</div>\r\n				</section>\r\n			</div>\r\n		</div>\r\n\r\n		{xsell}\r\n\r\n	</section>\r\n<!-- end: Page section -->', '2013-10-01 16:07:25', '2013-04-17 16:07:25');

DROP TABLE IF EXISTS templates_stylesheets;
CREATE TABLE `templates_stylesheets` (
  `template_id` int(10) unsigned default '0',
  `stylesheet_id` int(10) unsigned default '0',
  PRIMARY KEY  (`template_id`,`stylesheet_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `templates_stylesheets` (`template_id`, `stylesheet_id`) VALUES 
(1, 1);

DROP TABLE IF EXISTS template_types;
CREATE TABLE `template_types` (
  `id` int(10) auto_increment,
  `name` varchar(255) collate utf8_unicode_ci,
  `default_template` text collate utf8_unicode_ci,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `template_types` (`id`, `name`, `default_template`) VALUES 
(1, 'Main Layout', '<!DOCTYPE html>\r\n<html>\r\n\r\n<head>\r\n	{meta_description}\r\n	{meta_keywords}\r\n	{metadata}\r\n	{headdata}\r\n	<title>{config value=site_name} - {page_name}</title>\r\n	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"/>\r\n	<meta name=\"viewport\" content=\"width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no\"/>\r\n\r\n	<link rel=\"apple-touch-icon-precomposed\" sizes=\"144x144\" href=\"{base_path}/img/ico/apple-touch-icon-144-precomposed.png\"/>\r\n	<link rel=\"apple-touch-icon-precomposed\" sizes=\"114x114\" href=\"{base_path}/img/ico/apple-touch-icon-114-precomposed.png\"/>\r\n	<link rel=\"apple-touch-icon-precomposed\" sizes=\"72x72\" href=\"{base_path}/img/ico/apple-touch-icon-72-precomposed.png\"/>\r\n	<link rel=\"apple-touch-icon-precomposed\" href=\"{base_path}/img/ico/apple-touch-icon-57-precomposed.png\"/>\r\n	<link rel=\"shortcut icon\" href=\"{base_path}/favicon.ico\"/>\r\n\r\n	<script type=\"text/javascript\" src=\"{base_path}/js/jquery/jquery.min.js\"></script>\r\n	<script type=\"text/javascript\" src=\"{base_path}/js/bootstrap/bootstrap.min.js\"></script>\r\n	<script type=\"text/javascript\" src=\"{base_path}/js/jquery/plugins/jquery.easing.1.3.js\"></script>\r\n	<script type=\"text/javascript\" src=\"{base_path}/js/vamcart.js\"></script>\r\n	<script type=\"text/javascript\" src=\"{base_path}/js/jquery/plugins/lightbox/jquery.lightbox.js\"></script>\r\n\r\n	<link rel=\"stylesheet\" type=\"text/css\" href=\"{base_path}/css/bootstrap/bootstrap.css\"/>\r\n	<link rel=\"stylesheet\" type=\"text/css\" href=\"{base_path}/css/bootstrap/cus-icons.css\"/>\r\n	<link rel=\"stylesheet\" type=\"text/css\" href=\"{base_path}/css/vamcart.css\"/>\r\n	<link rel=\"stylesheet\" type=\"text/css\" href=\"{base_path}/css/font-awesome.min.css\"/>\r\n	<link rel=\"stylesheet\" type=\"text/css\" href=\"{base_path}/css/lightbox/jquery.lightbox.css\" media=\"screen\" />\r\n	<!--[if IE 7]>\r\n	<link rel=\"stylesheet\" type=\"text/css\" href=\"{base_path}/css/font-awesome-ie7.min.css\"/>\r\n	<![endif]-->\r\n\r\n	<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->\r\n	<!--[if lt IE 9]>\r\n	<script type=\"text/javascript\" src=\"{base_path}/js/html5.js\"></script>\r\n	<![endif]-->\r\n</head>\r\n\r\n<body>\r\n\r\n{google_analytics}\r\n{yandex_metrika}\r\n\r\n<!-- start: TOP BAR -->\r\n<div class=\"topbar clearfix\">\r\n	<div class=\"container\">\r\n		<ul class=\"nav nav-pills top-contacts pull-left\">\r\n			<li><a href=\"\"><i class=\"icon-phone\"></i> {config value=telephone}</a></li>\r\n			<li><a href=\"{config value=twitter}\"><i class=\"icon-twitter\"></i> Twitter</a></li>\r\n			<li><a href=\"{config value=facebook}\"><i class=\"icon-facebook\"></i> Facebook</a></li>\r\n		</ul>\r\n		<ul class=\"nav nav-pills top-menu pull-right\">\r\n			<li><a href=\"{base_path}\">{lang}Home{/lang}</a></li>\r\n			{content_listing template=\'news-dropdown\' parent=\'69\' type=\'news\' limit=\'5\'}\r\n			<li><a href=\"{base_path}/page/contact-us.html\">{lang}Contact Us{/lang}</a></li>\r\n		</ul>\r\n	</div>\r\n</div>\r\n<!-- end: TOP BAR -->\r\n\r\n<!-- start: Header -->\r\n<div id=\"header\">\r\n	<div class=\"container\">\r\n		<div class=\"row-fluid\">\r\n			<div class=\"span3 logo\">\r\n				<a href=\"{base_path}/\"><img src=\"{base_path}/img/logo.png\" alt=\"{config value=site_name}\" title=\"{config value=site_name}\" /></a>\r\n			</div>\r\n			<div class=\"span6 search\">\r\n					<form class=\"form-search\" action=\"{base_path}/page/search-result.html\" method=\"get\">\r\n						<input type=\"text\" name=\"keyword\" class=\"input-medium\" placeholder=\"{lang}Search{/lang}\">\r\n						<button type=\"submit\" class=\"btn hidden\">{lang}Search{/lang}</button>\r\n					</form>\r\n			</div>\r\n		</div>\r\n	</div>\r\n</div>\r\n<!-- end: Header -->\r\n\r\n<!-- start: Main Menu -->\r\n<div id=\"navigation\" class=\"default\">\r\n	<div class=\"container\">\r\n		<div class=\"login\">\r\n			<a href=\"{base_path}/page/account.html\" class=\"account-avatar\" data-original-title=\"{lang}My Account{/lang}\" data-placement=\"top\" rel=\"tooltip\"><img src=\"{base_path}/img/account.png\" alt=\"\"/></a>\r\n			<a href=\"{base_path}/page/account.html\" class=\"account\" data-original-title=\"{lang}Login{/lang}\" data-placement=\"top\" rel=\"tooltip\"><i class=\"icon-lightbulb\"></i></a>\r\n		</div>\r\n		<div class=\"navbar navbar-static-top\">\r\n			<div class=\"navbar-inner\">\r\n				{content_listing template=\'info-links\' parent=\'44\' limit=\'10\'}\r\n				{shopping_cart template=\'cart-content-box-pull\'}\r\n			</div>\r\n		</div>\r\n	</div>\r\n</div>\r\n<!-- end: Main Menu -->\r\n\r\n<!-- start: Container -->\r\n<div id=\"container\">\r\n	<div class=\"container\">\r\n\r\n		<div class=\"row-fluid\">\r\n\r\n			{flash_message}\r\n\r\n			{if isset($is_compared)}{compared}{else}{content}{/if}\r\n\r\n		<!-- start: Sidebar -->\r\n		<aside class=\"span3 sidebar pull-left\">\r\n\r\n			{shopping_cart template=\'cart-content-box\'}\r\n			{content_listing template=\'search-box\'}\r\n			{content_listing template=\'categories-box\' parent=\'0\' type=\'category\'}\r\n			{filter}\r\n			{login_box}\r\n			{compare}\r\n			{language_box}\r\n			{currency_box}\r\n\r\n		</aside>\r\n		<!-- end: Sidebar -->\r\n\r\n		</div>\r\n\r\n	</div>\r\n</div>\r\n<!-- end: Container -->\r\n\r\n<!-- start: Footer -->\r\n<footer id=\"footer\">\r\n	<div class=\"container\">\r\n		<div class=\"row-fluid\">\r\n			<div class=\"span3 clearfix\">\r\n				<h3 class=\"widget-title\">{lang}Information{/lang}</h3>\r\n				<div class=\"widget-inner\">\r\n					{content_listing template=\'footer-links\' parent=\'44\' type=\'page\' limit=\'10\'}\r\n				</div>\r\n			</div>\r\n			<div class=\"span3 clearfix\">\r\n				<h3 class=\"widget-title\">{lang}News{/lang}</h3>\r\n				<div class=\"widget-inner\">\r\n					{content_listing template=\'footer-links\' parent=\'69\' type=\'news\' limit=\'10\'}\r\n				</div>\r\n			</div>\r\n\r\n			<div class=\"span6 clearfix\">\r\n				<h3 class=\"widget-title\">{lang}Articles{/lang}</h3>\r\n				<div class=\"widget-inner\">\r\n					{content_listing template=\'footer-links\' parent=\'70\' type=\'article\' limit=\'10\'}\r\n				</div>\r\n			</div>\r\n		</div>\r\n	</div>\r\n</footer>\r\n<!-- end: Footer -->\r\n\r\n<!-- start: Footer menu -->\r\n<section id=\"footer-menu\">\r\n	<div class=\"container\">\r\n		<div class=\"row-fluid\">\r\n			<div class=\"span6\">\r\n				<ul class=\"privacy inline\">\r\n					<li><a href=\"{base_path}/page/conditions-of-use.html\">{lang}About Us{/lang}</a></li>\r\n					<li><a href=\"{base_path}/page/contact-us.html\">{lang}Contact Us{/lang}</a></li>\r\n				</ul>\r\n				{global_content alias=\'footer\'}\r\n			</div>\r\n		</div>\r\n	</div>\r\n</section>\r\n<!-- end: Footer menu -->\r\n\r\n</body>\r\n</html>'),
(2, 'Content Page', '<!-- start: Page section -->\r\n	<section class=\"span9 page-sidebar pull-right\">\r\n		<h2>{page_name}</h2>              \r\n			{admin_edit_link}\r\n			{description}\r\n	</section>\r\n<!-- end: Page section -->'),
(3, 'Product Info', '<script type=\"text/javascript\">\r\n$(document).ready(function(){\r\n  $(\"a.lightbox\").lightBox({\r\n    fixedNavigation:true,\r\n      imageLoading: \"{base_path}/img/jquery/plugins/lightbox/lightbox-ico-loading.gif\",\r\n      imageBtnClose: \"{base_path}/img/jquery/plugins/lightbox/lightbox-btn-close.gif\",\r\n      imageBtnPrev: \"{base_path}/img/jquery/plugins/lightbox/lightbox-btn-prev.gif\",\r\n      imageBtnNext: \"{base_path}/img/jquery/plugins/lightbox/lightbox-btn-next.gif\",      \r\n    });\r\n});\r\n{if ($ajax_enable eq \'1\')}\r\n  function onProductFormSubmit() {\r\n    var str = $(\"#product-form\").serialize();\r\n\r\n    $.post(\"{base_path}/cart/purchase_product\", str, function(data) {\r\n      $(\"#shopping-cart-box\").html(data);\r\n    });\r\n  }\r\n{/if}\r\n</script>\r\n\r\n<!-- start: Page section -->\r\n	<section class=\"span9 page-sidebar pull-right\">\r\n\r\n		<div class=\"row-fluid\">\r\n			<!-- start: Product image -->\r\n				{content_images}\r\n			<!-- end: Product image -->\r\n			<!-- start: Product title -->\r\n				<div class=\"span6 product-info\">\r\n\r\n					<div class=\"inner product-title\">\r\n						<div class=\"row-fluid\">\r\n							<div class=\"span8 title\"><h1>{page_name}</h1></div>\r\n							<div class=\"span4 price\">{product_price}</div>\r\n						</div>\r\n					</div>\r\n\r\n					<div class=\"inner nobottom product-cart\">\r\n							{product_form}\r\n								<label>{lang}Qty{/lang}:</label>\r\n								<input name=\"product_quantity\" id=\"product_quantity\" type=\"text\" value=\"1\" size=\"3\" />\r\n								<button type=\"submit\" class=\"btn btn-inverse\"><i class=\"icon-shopping-cart\"></i> {lang}Add to cart{/lang}</button>\r\n							{/product_form}\r\n					</div>\r\n					\r\n					<div class=\"inner\">\r\n						{attribute_list value_attributes=$node.attributes}\r\n					</div>\r\n\r\n				</div>\r\n			<!-- end: Product title -->\r\n		</div>\r\n\r\n		<div class=\"row-fluid\">\r\n\r\n			<div class=\"row-fluid product-tabs\">\r\n				<section class=\"widget\">\r\n\r\n					<ul class=\"nav nav-tabs\">\r\n						<li class=\"active\"><a href=\"#description\" data-toggle=\"tab\">{lang}Description{/lang}</a></li>\r\n						<li><a href=\"#reviews\" data-toggle=\"tab\">{lang}Reviews{/lang}</a></li>\r\n						<li><a href=\"#add-review\" data-toggle=\"tab\">{lang}Add Review{/lang}</a></li>\r\n					</ul>\r\n\r\n					<div class=\"tab-content\">\r\n\r\n						<div class=\"tab-pane inner notop active\" id=\"description\">\r\n							{description}\r\n						</div>\r\n\r\n						<div class=\"tab-pane inner notop\" id=\"reviews\">\r\n							{module alias=\'reviews\' action=\'display\'}\r\n						</div>\r\n\r\n						<div class=\"tab-pane inner notop\" id=\"add-review\">\r\n							{module alias=\'reviews\' action=\'create\'}\r\n						</div>\r\n\r\n					</div>\r\n				</section>\r\n			</div>\r\n		</div>\r\n\r\n		{xsell}\r\n\r\n	</section>\r\n<!-- end: Page section -->'),
(4, 'Category Info', '<!-- start: Page section -->\r\n	<section class=\"span9 page-sidebar pull-right\">\r\n		<h2>{page_name}</h2>              \r\n			{admin_edit_link}\r\n			{description}\r\n\r\n		{if $sub_count->value.categories > 0}\r\n			<h3>{lang}Sub Categories{/lang}</h3>\r\n				<div class=\"content_listing\">\r\n					{content_listing template=\'subcategory-listing\' parent={$content_id} type=\'category\'}\r\n				</div>\r\n		{/if}\r\n\r\n		{if $sub_count->value.products + $sub_count->value.downloadables > 0}\r\n			<h3>{lang}Products in this Category{/lang}</h3>\r\n				<div class=\"content_listing\">\r\n					{content_listing template=\'product-listing\' parent={$content_id} page={$page} type=\'product,downloadable\'}\r\n				</div>\r\n		{/if}\r\n	</section>\r\n<!-- end: Page section -->'),
(5, 'News Page', '<!-- start: Page section -->\r\n	<section class=\"span9 page-sidebar pull-right\">\r\n		<h2>{page_name}</h2>              \r\n			{admin_edit_link}\r\n			{description}\r\n	</section>\r\n<!-- end: Page section -->'),
(6, 'Article Page', '<!-- start: Page section -->\r\n	<section class=\"span9 page-sidebar pull-right\">\r\n		<h2>{page_name}</h2>              \r\n			{admin_edit_link}\r\n			{description}\r\n	</section>\r\n<!-- end: Page section -->'),
(7, 'Downloadable Product Info', '<script type=\"text/javascript\">\r\n$(document).ready(function(){\r\n  $(\"a.lightbox\").lightBox({\r\n    fixedNavigation:true,\r\n      imageLoading: \"{base_path}/img/jquery/plugins/lightbox/lightbox-ico-loading.gif\",\r\n      imageBtnClose: \"{base_path}/img/jquery/plugins/lightbox/lightbox-btn-close.gif\",\r\n      imageBtnPrev: \"{base_path}/img/jquery/plugins/lightbox/lightbox-btn-prev.gif\",\r\n      imageBtnNext: \"{base_path}/img/jquery/plugins/lightbox/lightbox-btn-next.gif\",      \r\n    });\r\n});\r\n{if ($ajax_enable eq \'1\')}\r\n  function onProductFormSubmit() {\r\n    var str = $(\"#product-form\").serialize();\r\n\r\n    $.post(\"{base_path}/cart/purchase_product\", str, function(data) {\r\n      $(\"#shopping-cart-box\").html(data);\r\n    });\r\n  }\r\n{/if}\r\n</script>\r\n\r\n<!-- start: Page section -->\r\n	<section class=\"span9 page-sidebar pull-right\">\r\n\r\n		<div class=\"row-fluid\">\r\n			<!-- start: Product image -->\r\n				{content_images}\r\n			<!-- end: Product image -->\r\n			<!-- start: Product title -->\r\n				<div class=\"span6 product-info\">\r\n\r\n					<div class=\"inner product-title\">\r\n						<div class=\"row-fluid\">\r\n							<div class=\"span8 title\"><h1>{page_name}</h1></div>\r\n							<div class=\"span4 price\">{product_downloadable_price}</div>\r\n						</div>\r\n					</div>\r\n\r\n					<div class=\"inner nobottom product-cart\">\r\n							{product_form}\r\n								<label>{lang}Qty{/lang}:</label>\r\n								<input name=\"product_quantity\" id=\"product_quantity\" type=\"text\" value=\"1\" size=\"3\" />\r\n								<button type=\"submit\" class=\"btn btn-inverse\"><i class=\"icon-shopping-cart\"></i> {lang}Add to cart{/lang}</button>\r\n							{/product_form}\r\n					</div>\r\n					\r\n					<div class=\"inner\">\r\n						{attribute_list value_attributes=$node.attributes}\r\n					</div>\r\n\r\n				</div>\r\n			<!-- end: Product title -->\r\n		</div>\r\n\r\n		<div class=\"row-fluid\">\r\n\r\n			<div class=\"row-fluid product-tabs\">\r\n				<section class=\"widget\">\r\n\r\n					<ul class=\"nav nav-tabs\">\r\n						<li class=\"active\"><a href=\"#description\" data-toggle=\"tab\">{lang}Description{/lang}</a></li>\r\n						<li><a href=\"#reviews\" data-toggle=\"tab\">{lang}Reviews{/lang}</a></li>\r\n						<li><a href=\"#add-review\" data-toggle=\"tab\">{lang}Add Review{/lang}</a></li>\r\n					</ul>\r\n\r\n					<div class=\"tab-content\">\r\n\r\n						<div class=\"tab-pane inner notop active\" id=\"description\">\r\n							{description}\r\n						</div>\r\n\r\n						<div class=\"tab-pane inner notop\" id=\"reviews\">\r\n							{module alias=\'reviews\' action=\'display\'}\r\n						</div>\r\n\r\n						<div class=\"tab-pane inner notop\" id=\"add-review\">\r\n							{module alias=\'reviews\' action=\'create\'}\r\n						</div>\r\n\r\n					</div>\r\n				</section>\r\n			</div>\r\n		</div>\r\n\r\n		{xsell}\r\n\r\n	</section>\r\n<!-- end: Page section -->');

DROP TABLE IF EXISTS users;
CREATE TABLE `users` (
  `id` int(10) auto_increment,
  `username` varchar(255) collate utf8_unicode_ci,
  `email` varchar(255) collate utf8_unicode_ci,
  `password` varchar(255) collate utf8_unicode_ci,
  `created` datetime,
  `modified` datetime,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created`, `modified`) VALUES 
(1, 'admin', 'vam@test.com', '4e825adacc62644d112a2f4e41d395bfb31f55a9', '0000-00-00 00:00:00', '2009-07-23 15:34:53');

DROP TABLE IF EXISTS user_prefs;
CREATE TABLE `user_prefs` (
  `id` int(10) auto_increment,
  `user_id` int(10),
  `name` varchar(255) collate utf8_unicode_ci,
  `value` text collate utf8_unicode_ci,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `user_prefs` (`id`, `user_id`, `name`, `value`) VALUES 
(1, 1, 'content_collapse', ''),
(2, 1, 'template_collpase', ''),
(3, 1, 'language', 'en');

DROP TABLE IF EXISTS user_tags;
CREATE TABLE `user_tags` (
  `id` int(10) auto_increment,
  `name` varchar(255) collate utf8_unicode_ci,
  `alias` varchar(255) collate utf8_unicode_ci,
  `content` text collate utf8_unicode_ci,
  `created` datetime,
  `modified` datetime,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `user_tags` (`id`, `name`, `alias`, `content`, `created`, `modified`) VALUES 
(1, 'User Agent', 'user-agent', 'echo $_SERVER[''HTTP_USER_AGENT''];', '2009-07-25 09:50:24', '2009-07-27 18:08:55');

DROP TABLE IF EXISTS licenses;
CREATE TABLE IF NOT EXISTS `licenses` (
  `id` int(11) AUTO_INCREMENT,
  `licenseKey` varchar(255),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `licenses` (`id`, `licenseKey`) VALUES 
(1, 'NTc5MmEyMjdlMG5qZGxhf3BbXAMAeGdWWLa7jYXx');

DROP TABLE IF EXISTS updates;
CREATE TABLE IF NOT EXISTS `updates` (
  `id` int(11) AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS customers;
CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(10) AUTO_INCREMENT,
  `name` varchar(32),
  `email` varchar(96),
  `password` varchar(40),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS address_books;
CREATE TABLE `address_books` (
  `id` int(10) auto_increment,
  `customer_id` int(10),
  `ship_name` varchar(255) collate utf8_unicode_ci,
  `ship_line_1` varchar(255) collate utf8_unicode_ci,
  `ship_line_2` varchar(255) collate utf8_unicode_ci,
  `ship_city` varchar(255) collate utf8_unicode_ci,
  `ship_state` varchar(255) collate utf8_unicode_ci,
  `ship_country` varchar(255) collate utf8_unicode_ci,
  `ship_zip` varchar(255) collate utf8_unicode_ci,
  `phone` varchar(15) collate utf8_unicode_ci,
  `created` datetime,
  `modified` datetime,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS contents_contents;
CREATE TABLE IF NOT EXISTS `contents_contents` (
  `id` int(10) AUTO_INCREMENT,
  `product_id` int(10),
  `related_id` int(10),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
