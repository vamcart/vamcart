SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET NAMES 'utf8';

DROP TABLE IF EXISTS configuration_groups;
CREATE TABLE `configuration_groups` (
  `id` int(10) NOT NULL auto_increment,
  `key` varchar(50) collate utf8_unicode_ci NOT NULL,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `description` varchar(255) collate utf8_unicode_ci NOT NULL,
  `group_icon` varchar(255) collate utf8_unicode_ci NOT NULL,
  `visible` varchar(255) collate utf8_unicode_ci NOT NULL,
  `sort_order` varchar(255) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `configuration_groups` (`id`, `key`, `name`, `description`, `group_icon`, `visible`, `sort_order`) VALUES 
(1, 'main', 'Main','','cus-application','1','1'),
(2, 'cache', 'Caching','','cus-compress','1','2'),
(3, 'email', 'Email Settings','','cus-email','1','3');

DROP TABLE IF EXISTS configurations;
CREATE TABLE `configurations` (
  `id` int(10) NOT NULL auto_increment,
  `configuration_group_id` int(10) NOT NULL,
  `key` varchar(50) collate utf8_unicode_ci NOT NULL,
  `value` varchar(255) collate utf8_unicode_ci NOT NULL,
  `type` varchar(255) collate utf8_unicode_ci NOT NULL,
  `options` varchar(255) collate utf8_unicode_ci NOT NULL,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `description` varchar(255) collate utf8_unicode_ci NOT NULL,
  `sort_order` varchar(255) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `configurations` (`id`, `configuration_group_id`, `key`, `value`, `type`, `options`, `name`, `description`, `sort_order`) VALUES 
(1,'1','SITE_NAME', 'VamCart','text', '', 'Site Name','','1'),
(2,'1','METADATA', '<meta name="generator" content="Bluefish 2.2.2" />','textarea', '', 'Metadata','','2'),
(3,'1','URL_EXTENSION', '.html','text', '', 'URL Extension','','3'),
(4,'1','GD_LIBRARY', '1','select', '0,1', 'GD Library Enabled','','4'),
(5,'1','THUMBNAIL_SIZE', '125','text', '', 'Image Thumbnail Size','','5'),
(6,'1','GOOGLE_ANALYTICS', '','text', '', 'Google Analytics ID','','6'),
(7,'1','YANDEX_METRIKA', '','text', '', 'Yandex.Metrika ID','','7'),
(8,'1','PRODUCTS_PER_PAGE', '20','text', '', 'Products Per Page','','8'),
(9,'2','CACHE_TIME', '3600','text', '', 'Cache Time in Seconds','','9'),
(10,'3','SEND_EXTRA_EMAIL', 'vam@test.com','text', '', 'Send extra order emails to','','10'),
(11,'3','NEW_ORDER_FROM_EMAIL', 'vam@test.com','text', '', 'New Order: From','','11'),
(12,'3','NEW_ORDER_FROM_NAME', 'VamCart','text', '', 'New Order: From Name','','12'),
(13,'3','NEW_ORDER_STATUS_FROM_EMAIL', 'vam@test.com','text', '', 'New Order Status: From','','13'),
(14,'3','NEW_ORDER_STATUS_FROM_NAME', 'VamCart','text', '', 'New Order Status: From Name','','14'),
(15,'3','SEND_CONTACT_US_EMAIL', 'vam@test.com','text', '', 'Send contact us emails to','','15'),
(16,'1','AJAX_ENABLE', '0', 'select', '0,1', 'Ajax Enable', '', '16');

DROP TABLE IF EXISTS contents;
CREATE TABLE `contents` (
  `id` int(10) NOT NULL auto_increment,
  `parent_id` int(10) NOT NULL,
  `order` int(10) NOT NULL,
  `hierarchy` int(10) NOT NULL,
  `content_type_id` int(10) NOT NULL,
  `template_id` int(10) NOT NULL,
  `default` tinyint(4) NOT NULL,
  `alias` varchar(50) collate utf8_unicode_ci NOT NULL,
  `head_data` text collate utf8_unicode_ci NOT NULL,
  `active` tinyint(4) NOT NULL,
  `show_in_menu` tinyint(4) NOT NULL,
  `yml_export` tinyint(4) NOT NULL,
  `viewed` int(10) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
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
  `id` int(10) NOT NULL auto_increment,
  `content_id` int(10) NOT NULL,
  `extra` varchar(1) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `content_categories` (`id`, `content_id`, `extra`) VALUES 
(8, 36, '1'),
(9, 39, '1'),
(12, 51, '1');

DROP TABLE IF EXISTS content_descriptions;
CREATE TABLE `content_descriptions` (
  `id` int(10) NOT NULL auto_increment,
  `content_id` int(10) NOT NULL,
  `language_id` int(10) NOT NULL,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `description` text collate utf8_unicode_ci NOT NULL,
  `meta_title` varchar(255) collate utf8_unicode_ci NOT NULL,
  `meta_description` varchar(255) collate utf8_unicode_ci NOT NULL,
  `meta_keywords` varchar(255) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `content_descriptions` (`id`, `content_id`, `language_id`, `name`, `description`, `meta_title`, `meta_description`, `meta_keywords`) VALUES 
(179, 44, 1, 'Information', 'Information about our site can be found by visiting the following links:','', '', ''),
(180, 44, 2, 'Информация', 'Информация о магазине доступна по следующим ссылкам:','', '', ''),
(185, 46, 1, 'Payment methods', '<p>Enter your payment methods on this page.</p>','', '', ''),
(186, 46, 2, 'Оплата', '<p>Укажите информацию о способах оплаты товара на данной странице.</p>','', '', ''),
(187, 47, 1, 'About Us', '<p>About us page.</p>','', '', ''),
(188, 47, 2, 'О магазине', '<p>Информация о магазине.</p>','', '', ''),
(189, 48, 1, 'Contact Us', '<p>Enter your contact information on this page.</p>\r\n{contact_us}','', '', ''),
(190, 48, 2, 'Контакты', '<p>Контактная информация.</p>\r\n{contact_us}','', '', ''),
(225, 39, 1, 'Hoofs', 'Description','', '', ''),
(226, 39, 2, 'Копыта', 'Описание категории!','', '', ''),
(227, 36, 1, 'Horns', 'Description','', '', ''),
(228, 36, 2, 'Рога', 'Рога оленей, лосей и других животных!','', '', ''),
(241, 50, 1, 'Checkout', '{checkout template=\'checkout\'}','', '', ''),
(242, 50, 2, 'Оформление', '{checkout template=\'checkout\'}','', '', ''),
(245, 45, 1, 'Shipping and Returns', '<p>Enter your Shipping & Return information on this page.</p>','', '', ''),
(246, 45, 2, 'Доставка', '<p>Укажите информацию о способах доставки товара на данной странице.</p>','', '', ''),
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
(391, 35, 1, 'Home', '<p>Welcome to your new online catalog!</p>\r\n<p><a href="admin/">Click here to go to the admin area.</a></p>','', '', ''),
(392, 35, 2, 'Главная страница', '<p>Добро пожаловать!</p>\r\n<p><a href="admin/">Вход в админку.</a></p>','', '', ''),
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
(403, 73, 1, 'Search results', '{content_listing_search}{search_result}','', '', ''),
(404, 73, 2, 'Результаты поиска', '{content_listing_search}{search_result}','', '', '');
INSERT INTO `content_descriptions` VALUES(515, 87, 1, 'Register', '{registration_form}', '', '', '');
INSERT INTO `content_descriptions` VALUES(516, 87, 2, 'Регистрация', '{registration_form}', '', '', '');
INSERT INTO `content_descriptions` VALUES(517, 88, 1, 'Register success', 'Thak you for registration', '', '', '');
INSERT INTO `content_descriptions` VALUES(518, 88, 2, 'Успешная регистрация', 'Благодарим Вас за регистрацию в нашем магазине!', '', '', '');

INSERT INTO `content_descriptions` VALUES(519, 89, 1, 'Account', '{if $smarty.session.customer_id}\r\n<ul>\r\n  <li><a href="{base_path}/customer/account_edit.html">{lang}Account Edit{/lang}</a></li>\r\n  <li><a href="{base_path}/customer/address_book.html">{lang}Address Book{/lang}</a></li>\r\n  <li><a href="{base_path}/customer/my_orders.html">{lang}My Orders{/lang}</a></li>\r\n</ul>\r\n{else}\r\n{lang}Permission Denied.{/lang}\r\n{/if}', '', '', '');
INSERT INTO `content_descriptions` VALUES(520, 89, 2, 'Личный кабинет', '{if $smarty.session.customer_id}\r\n<ul>\r\n  <li><a href="{base_path}/customer/account_edit.html">{lang}Account Edit{/lang}</a></li>\r\n  <li><a href="{base_path}/customer/address_book.html">{lang}Address Book{/lang}</a></li>\r\n  <li><a href="{base_path}/customer/my_orders.html">{lang}My Orders{/lang}</a></li>\r\n</ul>\r\n{else}\r\n{lang}Permission Denied.{/lang}\r\n{/if}', '', '', '');
INSERT INTO `content_descriptions` VALUES(521, 90, 1, 'Account Edit', '{account_edit}', '', '', '');
INSERT INTO `content_descriptions` VALUES(522, 90, 2, 'Редактирование данных', '{account_edit}', '', '', '');

INSERT INTO `content_descriptions` VALUES(523, 91, 1, 'My Orders', '{my_orders}', '', '', '');
INSERT INTO `content_descriptions` VALUES(524, 91, 2, 'Мои заказы', '{my_orders}', '', '', '');

INSERT INTO `content_descriptions` VALUES(525, 92, 1, 'Address Book', '{address_book}', '', '', '');
INSERT INTO `content_descriptions` VALUES(526, 92, 2, 'Адресная книга', '{address_book}', '', '', '');

DROP TABLE IF EXISTS content_images;
CREATE TABLE `content_images` (
  `id` int(10) NOT NULL auto_increment,
  `content_id` int(10) NOT NULL,
  `order` int(10) NOT NULL,
  `image` varchar(255) collate utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `content_images` VALUES (1, 45, 1, 'shipping-methods.png', '2010-02-05 16:26:47', '2010-02-05 16:26:47');
INSERT INTO `content_images` VALUES (2, 46, 1, 'payment-methods.png', '2010-02-05 16:27:21', '2010-02-05 16:27:21');
INSERT INTO `content_images` VALUES (3, 47, 1, 'information.png', '2010-02-05 16:28:39', '2010-02-05 16:28:39');
INSERT INTO `content_images` VALUES (4, 48, 1, 'email.png', '2010-02-05 16:29:21', '2010-02-05 16:29:21');

DROP TABLE IF EXISTS content_links;
CREATE TABLE `content_links` (
  `id` int(10) NOT NULL auto_increment,
  `content_id` int(10) NOT NULL,
  `url` varchar(255) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS content_pages;
CREATE TABLE `content_pages` (
  `id` int(10) NOT NULL auto_increment,
  `content_id` int(10) NOT NULL,
  `extra` varchar(1) collate utf8_unicode_ci NOT NULL,
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
  `id` int(10) NOT NULL auto_increment,
  `content_id` int(10) NOT NULL,
  `stock` int(10) NOT NULL,
  `model` varchar(50) collate utf8_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `tax_id` int(10) NOT NULL,
  `weight` double NOT NULL,
  `moq` int(8) NOT NULL DEFAULT '1' COMMENT 'Minimum order quantity',
  `pf` int(8) NOT NULL DEFAULT '1' COMMENT 'Price For',
  `ordered` int(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `content_products` (`id`, `content_id`, `stock`, `model`, `price`, `tax_id`, `weight`, `moq`, `pf`, `ordered`) VALUES 
(16, 37, 12, '123456', 10.99, 2, 0, 1, 1, 0),
(17, 38, 22, 'sample', 4.95, 2, 3, 1, 1, 0);

DROP TABLE IF EXISTS content_product_prices;
CREATE TABLE IF NOT EXISTS `content_product_prices` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `content_product_id` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `price` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `content_product_prices` (`id`, `content_product_id`, `quantity`, `price`) VALUES
(1, 16, 5, 10.50);

DROP TABLE IF EXISTS content_news;
CREATE TABLE `content_news` (
  `id` int(10) NOT NULL auto_increment,
  `content_id` int(1) NOT NULL,
  `extra` varchar(1) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `content_news` (`id`, `content_id`, `extra`) VALUES 
(1, 69, '1'),
(2, 71, '1');

DROP TABLE IF EXISTS content_articles;
CREATE TABLE `content_articles` (
  `id` int(10) NOT NULL auto_increment,
  `content_id` int(1) NOT NULL,
  `extra` varchar(1) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `content_articles` (`id`, `content_id`, `extra`) VALUES 
(1, 70, '1'),
(2, 72, '1');

DROP TABLE IF EXISTS content_types;
CREATE TABLE `content_types` (
  `id` int(10) NOT NULL auto_increment,
  `template_type_id` tinyint(4) NOT NULL,
  `name` varchar(50) collate utf8_unicode_ci NOT NULL,
  `type` varchar(50) collate utf8_unicode_ci NOT NULL,
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
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `content_id` int(10) NOT NULL,
  `filename` varchar(256) NOT NULL,
  `filestorename` varchar(256) NOT NULL,
  `price` double NOT NULL,
  `model` varchar(50) NOT NULL,
  `tax_id` int(10) NOT NULL,
  `order_status_id` int(10) NOT NULL,
  `max_downloads` int(10) DEFAULT '0',
  `max_days_for_download` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS countries;
CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `iso_code_2` char(2) COLLATE utf8_unicode_ci NOT NULL,
  `iso_code_3` char(3) COLLATE utf8_unicode_ci NOT NULL,
  `address_format` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `eu` int(2) NOT NULL DEFAULT '0',
  `private` int(2) NOT NULL DEFAULT '0',
  `firm` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `IDX_NAME` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `countries` (`id`, `name`, `iso_code_2`, `iso_code_3`, `address_format`, `eu`, `private`, `firm`) VALUES
(1, 'Afghanistan', 'AF', 'AFG', '', 0, 0, 0),
(2, 'Albania', 'AL', 'ALB', '', 0, 0, 0),
(3, 'Algeria', 'DZ', 'DZA', '', 0, 0, 0),
(4, 'American Samoa', 'AS', 'ASM', '', 0, 0, 0),
(5, 'Andorra', 'AD', 'AND', '', 0, 0, 0),
(6, 'Angola', 'AO', 'AGO', '', 0, 0, 0),
(7, 'Anguilla', 'AI', 'AIA', '', 0, 0, 0),
(8, 'Antarctica', 'AQ', 'ATA', '', 0, 0, 0),
(9, 'Antigua and Barbuda', 'AG', 'ATG', '', 0, 0, 0),
(10, 'Argentina', 'AR', 'ARG', ':name\n:street_address\n:postcode :city\n:country', 0, 0, 0),
(11, 'Armenia', 'AM', 'ARM', '', 0, 0, 0),
(12, 'Aruba', 'AW', 'ABW', '', 0, 0, 0),
(13, 'Australia', 'AU', 'AUS', ':name\n:street_address\n:suburb :state_code :postcode\n:country', 0, 0, 0),
(14, 'Austria', 'AT', 'AUT', ':name\n:street_address\nA-:postcode :city\n:country', 1, 1, 0),
(15, 'Azerbaijan', 'AZ', 'AZE', '', 0, 0, 0),
(16, 'Bahamas', 'BS', 'BHS', '', 0, 0, 0),
(17, 'Bahrain', 'BH', 'BHR', '', 0, 0, 0),
(18, 'Bangladesh', 'BD', 'BGD', '', 0, 0, 0),
(19, 'Barbados', 'BB', 'BRB', '', 0, 0, 0),
(20, 'Belarus', 'BY', 'BLR', '', 0, 0, 0),
(21, 'Belgium', 'BE', 'BEL', ':name\n:street_address\nB-:postcode :city\n:country', 1, 1, 0),
(22, 'Belize', 'BZ', 'BLZ', '', 0, 0, 0),
(23, 'Benin', 'BJ', 'BEN', '', 0, 0, 0),
(24, 'Bermuda', 'BM', 'BMU', '', 0, 0, 0),
(25, 'Bhutan', 'BT', 'BTN', '', 0, 0, 0),
(26, 'Bolivia', 'BO', 'BOL', '', 0, 0, 0),
(27, 'Bosnia and Herzegowina', 'BA', 'BIH', '', 0, 0, 0),
(28, 'Botswana', 'BW', 'BWA', '', 0, 0, 0),
(29, 'Bouvet Island', 'BV', 'BVT', '', 0, 0, 0),
(30, 'Brazil', 'BR', 'BRA', ':name\n:street_address\n:state\n:postcode\n:country', 0, 0, 0),
(31, 'British Indian Ocean Territory', 'IO', 'IOT', '', 0, 0, 0),
(32, 'Brunei Darussalam', 'BN', 'BRN', '', 0, 0, 0),
(33, 'Bulgaria', 'BG', 'BGR', '', 1, 1, 0),
(34, 'Burkina Faso', 'BF', 'BFA', '', 0, 0, 0),
(35, 'Burundi', 'BI', 'BDI', '', 0, 0, 0),
(36, 'Cambodia', 'KH', 'KHM', '', 0, 0, 0),
(37, 'Cameroon', 'CM', 'CMR', '', 0, 0, 0),
(38, 'Canada', 'CA', 'CAN', ':name\n:street_address\n:city :state_code :postcode\n:country', 0, 0, 0),
(39, 'Cape Verde', 'CV', 'CPV', '', 0, 0, 0),
(40, 'Cayman Islands', 'KY', 'CYM', '', 0, 0, 0),
(41, 'Central African Republic', 'CF', 'CAF', '', 0, 0, 0),
(42, 'Chad', 'TD', 'TCD', '', 0, 0, 0),
(43, 'Chile', 'CL', 'CHL', ':name\n:street_address\n:city\n:country', 0, 0, 0),
(44, 'China', 'CN', 'CHN', ':name\n:street_address\n:postcode :city\n:country', 0, 0, 0),
(45, 'Christmas Island', 'CX', 'CXR', '', 0, 0, 0),
(46, 'Cocos (Keeling) Islands', 'CC', 'CCK', '', 0, 0, 0),
(47, 'Colombia', 'CO', 'COL', '', 0, 0, 0),
(48, 'Comoros', 'KM', 'COM', '', 0, 0, 0),
(49, 'Congo', 'CG', 'COG', '', 0, 0, 0),
(50, 'Cook Islands', 'CK', 'COK', '', 0, 0, 0),
(51, 'Costa Rica', 'CR', 'CRI', '', 0, 0, 0),
(52, 'Cote D''Ivoire', 'CI', 'CIV', '', 0, 0, 0),
(53, 'Croatia', 'HR', 'HRV', '', 0, 0, 0),
(54, 'Cuba', 'CU', 'CUB', '', 0, 0, 0),
(55, 'Cyprus', 'CY', 'CYP', '', 1, 1, 0),
(56, 'Czech Republic', 'CZ', 'CZE', '', 1, 1, 0),
(57, 'Denmark', 'DK', 'DNK', ':name\n:street_address\nDK-:postcode :city\n:country', 1, 1, 0),
(58, 'Djibouti', 'DJ', 'DJI', '', 0, 0, 0),
(59, 'Dominica', 'DM', 'DMA', '', 0, 0, 0),
(60, 'Dominican Republic', 'DO', 'DOM', '', 0, 0, 0),
(61, 'East Timor', 'TP', 'TMP', '', 0, 0, 0),
(62, 'Ecuador', 'EC', 'ECU', '', 0, 0, 0),
(63, 'Egypt', 'EG', 'EGY', '', 0, 0, 0),
(64, 'El Salvador', 'SV', 'SLV', '', 0, 0, 0),
(65, 'Equatorial Guinea', 'GQ', 'GNQ', '', 0, 0, 0),
(66, 'Eritrea', 'ER', 'ERI', '', 0, 0, 0),
(67, 'Estonia', 'EE', 'EST', '', 1, 1, 0),
(68, 'Ethiopia', 'ET', 'ETH', '', 0, 0, 0),
(69, 'Falkland Islands (Malvinas)', 'FK', 'FLK', '', 0, 0, 0),
(70, 'Faroe Islands', 'FO', 'FRO', '', 0, 0, 0),
(71, 'Fiji', 'FJ', 'FJI', '', 0, 0, 0),
(72, 'Finland', 'FI', 'FIN', ':name\n:street_address\nFIN-:postcode :city\n:country', 1, 1, 0),
(73, 'France', 'FR', 'FRA', ':name\n:street_address\n:postcode :city\n:country', 1, 1, 0),
(74, 'France, Metropolitan', 'FX', 'FXX', ':name\n:street_address\n:postcode :city\n:country', 0, 0, 0),
(75, 'French Guiana', 'GF', 'GUF', ':name\n:street_address\n:postcode :city\n:country', 0, 0, 0),
(76, 'French Polynesia', 'PF', 'PYF', ':name\n:street_address\n:postcode :city\n:country', 0, 0, 0),
(77, 'French Southern Territories', 'TF', 'ATF', ':name\n:street_address\n:postcode :city\n:country', 0, 0, 0),
(78, 'Gabon', 'GA', 'GAB', '', 0, 0, 0),
(79, 'Gambia', 'GM', 'GMB', '', 0, 0, 0),
(80, 'Georgia', 'GE', 'GEO', '', 0, 0, 0),
(81, 'Germany', 'DE', 'DEU', ':name\n:street_address\nD-:postcode :city\n:country', 1, 1, 0),
(82, 'Ghana', 'GH', 'GHA', '', 0, 0, 0),
(83, 'Gibraltar', 'GI', 'GIB', '', 0, 0, 0),
(84, 'Greece', 'GR', 'GRC', '', 1, 1, 0),
(85, 'Greenland', 'GL', 'GRL', ':name\n:street_address\nDK-:postcode :city\n:country', 0, 0, 0),
(86, 'Grenada', 'GD', 'GRD', '', 0, 0, 0),
(87, 'Guadeloupe', 'GP', 'GLP', '', 0, 0, 0),
(88, 'Guam', 'GU', 'GUM', '', 0, 0, 0),
(89, 'Guatemala', 'GT', 'GTM', '', 0, 0, 0),
(90, 'Guinea', 'GN', 'GIN', '', 0, 0, 0),
(91, 'Guinea-Bissau', 'GW', 'GNB', '', 0, 0, 0),
(92, 'Guyana', 'GY', 'GUY', '', 0, 0, 0),
(93, 'Haiti', 'HT', 'HTI', '', 0, 0, 0),
(94, 'Heard and McDonald Islands', 'HM', 'HMD', '', 0, 0, 0),
(95, 'Honduras', 'HN', 'HND', '', 0, 0, 0),
(96, 'Hong Kong', 'HK', 'HKG', ':name\n:street_address\n:city\n:country', 0, 0, 0),
(97, 'Hungary', 'HU', 'HUN', '', 1, 1, 0),
(98, 'Iceland', 'IS', 'ISL', ':name\n:street_address\nIS:postcode :city\n:country', 0, 0, 0),
(99, 'India', 'IN', 'IND', ':name\n:street_address\n:city-:postcode\n:country', 0, 0, 0),
(100, 'Indonesia', 'ID', 'IDN', ':name\n:street_address\n:city :postcode\n:country', 0, 0, 0),
(101, 'Iran', 'IR', 'IRN', '', 0, 0, 0),
(102, 'Iraq', 'IQ', 'IRQ', '', 0, 0, 0),
(103, 'Ireland', 'IE', 'IRL', ':name\n:street_address\nIE-:city\n:country', 1, 1, 0),
(104, 'Israel', 'IL', 'ISR', ':name\n:street_address\n:postcode :city\n:country', 0, 0, 0),
(105, 'Italy', 'IT', 'ITA', ':name\n:street_address\n:postcode-:city :state_code\n:country', 1, 1, 0),
(106, 'Jamaica', 'JM', 'JAM', '', 0, 0, 0),
(107, 'Japan', 'JP', 'JPN', ':name\n:street_address, :suburb\n:city :postcode\n:country', 0, 0, 0),
(108, 'Jordan', 'JO', 'JOR', '', 0, 0, 0),
(109, 'Kazakhstan', 'KZ', 'KAZ', '', 0, 0, 0),
(110, 'Kenya', 'KE', 'KEN', '', 0, 0, 0),
(111, 'Kiribati', 'KI', 'KIR', '', 0, 0, 0),
(112, 'Korea, North', 'KP', 'PRK', '', 0, 0, 0),
(113, 'Korea, South', 'KR', 'KOR', '', 0, 0, 0),
(114, 'Kuwait', 'KW', 'KWT', '', 0, 0, 0),
(115, 'Kyrgyzstan', 'KG', 'KGZ', '', 0, 0, 0),
(116, 'Laos', 'LA', 'LAO', '', 0, 0, 0),
(117, 'Latvia', 'LV', 'LVA', '', 1, 1, 0),
(118, 'Lebanon', 'LB', 'LBN', '', 0, 0, 0),
(119, 'Lesotho', 'LS', 'LSO', '', 0, 0, 0),
(120, 'Liberia', 'LR', 'LBR', '', 0, 0, 0),
(121, 'Libyan Arab Jamahiriya', 'LY', 'LBY', '', 0, 0, 0),
(122, 'Liechtenstein', 'LI', 'LIE', '', 0, 0, 0),
(123, 'Lithuania', 'LT', 'LTU', '', 1, 1, 0),
(124, 'Luxembourg', 'LU', 'LUX', ':name\n:street_address\nL-:postcode :city\n:country', 1, 1, 0),
(125, 'Macau', 'MO', 'MAC', '', 0, 0, 0),
(126, 'Macedonia', 'MK', 'MKD', '', 0, 0, 0),
(127, 'Madagascar', 'MG', 'MDG', '', 0, 0, 0),
(128, 'Malawi', 'MW', 'MWI', '', 0, 0, 0),
(129, 'Malaysia', 'MY', 'MYS', '', 0, 0, 0),
(130, 'Maldives', 'MV', 'MDV', '', 0, 0, 0),
(131, 'Mali', 'ML', 'MLI', '', 0, 0, 0),
(132, 'Malta', 'MT', 'MLT', '', 1, 1, 0),
(133, 'Marshall Islands', 'MH', 'MHL', '', 0, 0, 0),
(134, 'Martinique', 'MQ', 'MTQ', '', 0, 0, 0),
(135, 'Mauritania', 'MR', 'MRT', '', 0, 0, 0),
(136, 'Mauritius', 'MU', 'MUS', '', 0, 0, 0),
(137, 'Mayotte', 'YT', 'MYT', '', 0, 0, 0),
(138, 'Mexico', 'MX', 'MEX', ':name\n:street_address\n:postcode :city, :state_code\n:country', 0, 0, 0),
(139, 'Micronesia', 'FM', 'FSM', '', 0, 0, 0),
(140, 'Moldova', 'MD', 'MDA', '', 0, 0, 0),
(141, 'Monaco', 'MC', 'MCO', '', 0, 0, 0),
(142, 'Mongolia', 'MN', 'MNG', '', 0, 0, 0),
(143, 'Montserrat', 'MS', 'MSR', '', 0, 0, 0),
(144, 'Morocco', 'MA', 'MAR', '', 0, 0, 0),
(145, 'Mozambique', 'MZ', 'MOZ', '', 0, 0, 0),
(146, 'Myanmar', 'MM', 'MMR', '', 0, 0, 0),
(147, 'Namibia', 'NA', 'NAM', '', 0, 0, 0),
(148, 'Nauru', 'NR', 'NRU', '', 0, 0, 0),
(149, 'Nepal', 'NP', 'NPL', '', 0, 0, 0),
(150, 'Netherlands', 'NL', 'NLD', ':name\n:street_address\n:postcode :city\n:country', 1, 1, 0),
(151, 'Netherlands Antilles', 'AN', 'ANT', ':name\n:street_address\n:postcode :city\n:country', 0, 0, 0),
(152, 'New Caledonia', 'NC', 'NCL', '', 0, 0, 0),
(153, 'New Zealand', 'NZ', 'NZL', ':name\n:street_address\n:suburb\n:city :postcode\n:country', 0, 0, 0),
(154, 'Nicaragua', 'NI', 'NIC', '', 0, 0, 0),
(155, 'Niger', 'NE', 'NER', '', 0, 0, 0),
(156, 'Nigeria', 'NG', 'NGA', '', 0, 0, 0),
(157, 'Niue', 'NU', 'NIU', '', 0, 0, 0),
(158, 'Norfolk Island', 'NF', 'NFK', '', 0, 0, 0),
(159, 'Northern Mariana Islands', 'MP', 'MNP', '', 0, 0, 0),
(160, 'Norway', 'NO', 'NOR', ':name\n:street_address\nNO-:postcode :city\n:country', 0, 0, 0),
(161, 'Oman', 'OM', 'OMN', '', 0, 0, 0),
(162, 'Pakistan', 'PK', 'PAK', '', 0, 0, 0),
(163, 'Palau', 'PW', 'PLW', '', 0, 0, 0),
(164, 'Panama', 'PA', 'PAN', '', 0, 0, 0),
(165, 'Papua New Guinea', 'PG', 'PNG', '', 0, 0, 0),
(166, 'Paraguay', 'PY', 'PRY', '', 0, 0, 0),
(167, 'Peru', 'PE', 'PER', '', 0, 0, 0),
(168, 'Philippines', 'PH', 'PHL', '', 0, 0, 0),
(169, 'Pitcairn', 'PN', 'PCN', '', 0, 0, 0),
(170, 'Poland', 'PL', 'POL', ':name\n:street_address\n:postcode :city\n:country', 1, 1, 0),
(171, 'Portugal', 'PT', 'PRT', ':name\n:street_address\n:postcode :city\n:country', 1, 1, 0),
(172, 'Puerto Rico', 'PR', 'PRI', '', 0, 0, 0),
(173, 'Qatar', 'QA', 'QAT', '', 0, 0, 0),
(174, 'Reunion', 'RE', 'REU', '', 0, 0, 0),
(175, 'Romania', 'RO', 'ROM', '', 1, 1, 0),
(176, 'Russia', 'RU', 'RUS', ':name\n:street_address\n:postcode :city\n:country', 0, 0, 0),
(177, 'Rwanda', 'RW', 'RWA', '', 0, 0, 0),
(178, 'Saint Kitts and Nevis', 'KN', 'KNA', '', 0, 0, 0),
(179, 'Saint Lucia', 'LC', 'LCA', '', 0, 0, 0),
(180, 'Saint Vincent and the Grenadines', 'VC', 'VCT', '', 0, 0, 0),
(181, 'Samoa', 'WS', 'WSM', '', 0, 0, 0),
(182, 'San Marino', 'SM', 'SMR', '', 0, 0, 0),
(183, 'Sao Tome and Principe', 'ST', 'STP', '', 0, 0, 0),
(184, 'Saudi Arabia', 'SA', 'SAU', '', 0, 0, 0),
(185, 'Senegal', 'SN', 'SEN', '', 0, 0, 0),
(186, 'Seychelles', 'SC', 'SYC', '', 0, 0, 0),
(187, 'Sierra Leone', 'SL', 'SLE', '', 0, 0, 0),
(188, 'Singapore', 'SG', 'SGP', ':name\n:street_address\n:city :postcode\n:country', 0, 0, 0),
(189, 'Slovakia', 'SK', 'SVK', '', 1, 1, 0),
(190, 'Slovenia', 'SI', 'SVN', '', 1, 1, 1),
(191, 'Solomon Islands', 'SB', 'SLB', '', 0, 0, 0),
(192, 'Somalia', 'SO', 'SOM', '', 0, 0, 0),
(193, 'South Africa', 'ZA', 'ZAF', ':name\n:street_address\n:suburb\n:city\n:postcode :country', 0, 0, 0),
(194, 'South Georgia and the South Sandwich Islands', 'GS', 'SGS', '', 0, 0, 0),
(195, 'Spain', 'ES', 'ESP', ':name\n:street_address\n:postcode :city\n:country', 1, 1, 0),
(196, 'Sri Lanka', 'LK', 'LKA', '', 0, 0, 0),
(197, 'St. Helena', 'SH', 'SHN', '', 0, 0, 0),
(198, 'St. Pierre and Miquelon', 'PM', 'SPM', '', 0, 0, 0),
(199, 'Sudan', 'SD', 'SDN', '', 0, 0, 0),
(200, 'Suriname', 'SR', 'SUR', '', 0, 0, 0),
(201, 'Svalbard and Jan Mayen Islands', 'SJ', 'SJM', '', 0, 0, 0),
(202, 'Swaziland', 'SZ', 'SWZ', '', 0, 0, 0),
(203, 'Sweden', 'SE', 'SWE', ':name\n:street_address\n:postcode :city\n:country', 1, 1, 0),
(204, 'Switzerland', 'CH', 'CHE', ':name\n:street_address\n:postcode :city\n:country', 0, 0, 0),
(205, 'Syrian Arab Republic', 'SY', 'SYR', '', 0, 0, 0),
(206, 'Taiwan', 'TW', 'TWN', ':name\n:street_address\n:city :postcode\n:country', 0, 0, 0),
(207, 'Tajikistan', 'TJ', 'TJK', '', 0, 0, 0),
(208, 'Tanzania', 'TZ', 'TZA', '', 0, 0, 0),
(209, 'Thailand', 'TH', 'THA', '', 0, 0, 0),
(210, 'Togo', 'TG', 'TGO', '', 0, 0, 0),
(211, 'Tokelau', 'TK', 'TKL', '', 0, 0, 0),
(212, 'Tonga', 'TO', 'TON', '', 0, 0, 0),
(213, 'Trinidad and Tobago', 'TT', 'TTO', '', 0, 0, 0),
(214, 'Tunisia', 'TN', 'TUN', '', 0, 0, 0),
(215, 'Turkey', 'TR', 'TUR', '', 0, 0, 0),
(216, 'Turkmenistan', 'TM', 'TKM', '', 0, 0, 0),
(217, 'Turks and Caicos Islands', 'TC', 'TCA', '', 0, 0, 0),
(218, 'Tuvalu', 'TV', 'TUV', '', 0, 0, 0),
(219, 'Uganda', 'UG', 'UGA', '', 0, 0, 0),
(220, 'Ukraine', 'UA', 'UKR', '', 0, 0, 0),
(221, 'United Arab Emirates', 'AE', 'ARE', '', 0, 0, 0),
(222, 'United Kingdom', 'GB', 'GBR', ':name\n:street_address\n:city\n:postcode\n:country', 0, 0, 0),
(223, 'United States of America', 'US', 'USA', ':name\n:street_address\n:city :state_code :postcode\n:country', 0, 0, 0),
(224, 'United States Minor Outlying Islands', 'UM', 'UMI', '', 0, 0, 0),
(225, 'Uruguay', 'UY', 'URY', '', 0, 0, 0),
(226, 'Uzbekistan', 'UZ', 'UZB', '', 0, 0, 0),
(227, 'Vanuatu', 'VU', 'VUT', '', 0, 0, 0),
(228, 'Vatican City State (Holy See)', 'VA', 'VAT', '', 0, 0, 0),
(229, 'Venezuela', 'VE', 'VEN', '', 0, 0, 0),
(230, 'Vietnam', 'VN', 'VNM', '', 0, 0, 0),
(231, 'Virgin Islands (British)', 'VG', 'VGB', '', 0, 0, 0),
(232, 'Virgin Islands (U.S.)', 'VI', 'VIR', '', 0, 0, 0),
(233, 'Wallis and Futuna Islands', 'WF', 'WLF', '', 0, 0, 0),
(234, 'Western Sahara', 'EH', 'ESH', '', 0, 0, 0),
(235, 'Yemen', 'YE', 'YEM', '', 0, 0, 0),
(236, 'Yugoslavia', 'YU', 'YUG', '', 0, 0, 0),
(237, 'Zaire', 'ZR', 'ZAR', '', 0, 0, 0),
(238, 'Zambia', 'ZM', 'ZMB', '', 0, 0, 0),
(239, 'Zimbabwe', 'ZW', 'ZWE', '', 0, 0, 0);

DROP TABLE IF EXISTS country_zones;
CREATE TABLE `country_zones` (
  `id` int(10) NOT NULL auto_increment,
  `country_id` int(10) NOT NULL,
  `geo_zone_id` int(11) NOT NULL,
  `code` varchar(32) collate utf8_unicode_ci NOT NULL,
  `name` varchar(64) collate utf8_unicode_ci NOT NULL,
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
  `id` int(10) NOT NULL auto_increment,
  `active` tinyint(4) NOT NULL default '1',
  `default` tinyint(4) NOT NULL default '0',
  `name` varchar(50) collate utf8_unicode_ci NOT NULL,
  `code` varchar(3) collate utf8_unicode_ci NOT NULL,
  `symbol_left` varchar(24) collate utf8_unicode_ci NOT NULL,
  `symbol_right` varchar(24) collate utf8_unicode_ci NOT NULL,
  `decimal_point` char(1) collate utf8_unicode_ci NOT NULL,
  `thousands_point` char(1) collate utf8_unicode_ci NOT NULL,
  `decimal_places` char(1) collate utf8_unicode_ci NOT NULL,
  `value` float NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `currencies` (`id`, `active`, `default`, `name`, `code`, `symbol_left`, `symbol_right`, `decimal_point`, `thousands_point`, `decimal_places`, `value`, `created`, `modified`) VALUES 
(1, 1, 1, 'US Dollar', 'USD', '$', '', '.', ',', '2', 1, '2009-07-15 11:39:15', '2009-07-15 13:08:23'),
(2, 1, 0, 'Рубль', 'RUR', '', 'руб.', '.', ',', '0.0312', 1, '2009-07-15 11:39:15', '2009-07-15 13:08:23'),
(3, 1, 0, 'Euro', 'EUR', '&euro;', '', '.', ',', '2', 0.7811, '2009-07-15 13:09:23', '2009-07-15 13:09:23');

DROP TABLE IF EXISTS defined_languages;
CREATE TABLE `defined_languages` (
  `id` int(10) NOT NULL auto_increment,
  `language_id` int(10) NOT NULL,
  `key` varchar(50) collate utf8_unicode_ci NOT NULL,
  `value` text collate utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `defined_languages` (`id`, `language_id`, `key`, `value`, `created`, `modified`) VALUES 
(1, 1, 'Cart Contents', 'Cart Contents', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(2, 2, 'Cart Contents', 'Содержимое корзины', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(3, 1, 'Categories', 'Categories', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(4, 2, 'Categories', 'Разделы', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(5, 1, 'Product', 'Product', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(6, 2, 'Product', 'Товар', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(7, 1, 'Price Ea.', 'Price Ea.', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(8, 2, 'Price Ea.', 'Цена / шт.', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(9, 1, 'Qty', 'Qty', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(10, 2, 'Qty', 'Количество', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(11, 1, 'Total', 'Total', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(12, 2, 'Total', 'Всего', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(13, 1, 'No Cart Items', 'No Cart Items', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(14, 2, 'No Cart Items', 'В корзине нет товара.', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(15, 1, 'Checkout', 'Checkout', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(16, 2, 'Checkout', 'Оформить', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(17, 1, 'Currency', 'Currency', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(18, 2, 'Currency', 'Валюта', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(19, 1, 'Go', 'Go', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(20, 2, 'Go', 'Продолжить', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(21, 1, 'Shopping Cart', 'Shopping Cart', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(22, 2, 'Shopping Cart', 'Корзина', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(23, 1, 'Shipping', 'Shipping', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(24, 2, 'Shipping', 'Доставка', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(25, 1, 'Language', 'Language', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(26, 2, 'Language', 'Язык', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(27, 1, 'Sub Categories', 'Sub Categories', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(28, 2, 'Sub Categories', 'Подкатегории', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(29, 1, 'Products in this Category', 'Products in this Category', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(30, 2, 'Products in this Category', 'Товары в данной категории', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(31, 1, 'Coupon Code', 'Coupon Code', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(32, 2, 'Coupon Code', 'Код купона', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(33, 1, 'Read Reviews', 'Read Reviews', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(34, 2, 'Read Reviews', 'Читать отзывы', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(35, 1, 'Write a Review', 'Write a Review', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(36, 2, 'Write a Review', 'Написать отзыв', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(37, 1, 'No reviews were found for this product.', 'No reviews were found for this product.', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(38, 2, 'No reviews were found for this product.', 'Нет отзывов для данного товара.', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(39, 1, 'Confirm Order', 'Confirm Order', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(40, 2, 'Confirm Order', 'Подтвердить заказ', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(41, 1, 'Billing Information', 'Billing Information', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(42, 2, 'Billing Information', 'Информация о покупателе', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(43, 1, 'Name', 'Name', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(44, 2, 'Name', 'Имя', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(45, 1, 'Address Line 1', 'Address Line 1', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(46, 2, 'Address Line 1', 'Адрес', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(47, 1, 'Address Line 2', 'Address Line 2', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(48, 2, 'Address Line 2', 'Доп. информация', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(49, 1, 'City', 'City', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(50, 2, 'City', 'Город', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(51, 1, 'State', 'State', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(52, 2, 'State', 'Регион', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(53, 1, 'Zipcode', 'Zipcode', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(54, 2, 'Zipcode', 'Почтовый индекс', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(55, 1, 'Shipping Information', 'Shipping Information', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(56, 2, 'Shipping Information', 'Информация о доставке', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(57, 1, 'Contact Information', 'Contact Information', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(58, 2, 'Contact Information', 'Контактная информация', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(59, 1, 'Email', 'Email', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(60, 2, 'Email', 'Email', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(61, 1, 'Phone', 'Phone', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(62, 2, 'Phone', 'Телефон', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(63, 1, 'Shipping Method', 'Shipping Method', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(64, 2, 'Shipping Method', 'Способы доставки', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(65, 1, 'Payment Method', 'Payment Method', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(66, 2, 'Payment Method', 'Способы оплаты', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(67, 1, 'Continue', 'Continue', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(68, 2, 'Continue', 'Продолжить', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(69, 1, 'No Items Found', 'No Items Found', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(70, 2, 'No Items Found', 'Товары не найдены.', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(71, 1, 'No Image', 'No Image', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(72, 2, 'No Image', 'Нет картинки', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(73, 1, 'Review', 'Review', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(74, 2, 'Review', 'Отзыв', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(75, 1, 'Submit', 'Submit', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(76, 2, 'Submit', 'Добавить', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(77, 1, 'News', 'News', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(78, 2, 'News', 'Новости', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(79, 1, 'Articles', 'Articles', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(80, 2, 'Articles', 'Статьи', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(81, 1, 'PHP Shopping Cart', 'PHP Shopping Cart', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(82, 2, 'PHP Shopping Cart', 'Скрипты интернет-магазина', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(83, 1, 'Credit Card Number', 'Credit Card Number', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(84, 2, 'Credit Card Number', 'Номер кредитной карточки', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(85, 1, 'Credit Card Expiration', 'Credit Card Expiration', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(86, 2, 'Credit Card Expiration', 'Действительна до', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(87, 1, 'Contact Us', 'Contact Us', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(88, 2, 'Contact Us', 'Обратная связь', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(89, 1, 'Your Name', 'Your Name', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(90, 2, 'Your Name', 'Ваше имя', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(91, 1, 'Your Email', 'Your Email', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(92, 2, 'Your Email', 'Ваш email', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(93, 1, 'Message', 'Message', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(94, 2, 'Message', 'Сообщение', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(95, 1, 'Send', 'Send', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(96, 2, 'Send', 'Отправить', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(97, 1, 'Different from billing address', 'Different from billing address', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(98, 2, 'Different from billing address', 'Нажмите, если адрес доставки и адрес покупателя различные', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(99, 1, 'Home', 'Home', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(100, 2, 'Home', 'Главная', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(101, 1, 'Process to Payment', 'Process to Payment', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(102, 2, 'Process to Payment', 'Перейти к оплате заказа', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(103, 1, 'Free Shipping', 'Free Shipping', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(104, 2, 'Free Shipping', 'Бесплатная доставка', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(105, 1, 'Flat Rate', 'Flat Rate', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(106, 2, 'Flat Rate', 'Курьерская доставка', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(107, 1, 'Per Item', 'Per Item', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(108, 2, 'Per Item', 'На единицу', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(109, 1, 'Table Based', 'Table Based', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(110, 2, 'Table Based', 'Табличный тариф', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(111, 1, 'In-store Pickup', 'In-store Pickup', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(112, 2, 'In-store Pickup', 'Самовывоз', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(113, 1, 'Credit Card', 'Credit Card', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(114, 2, 'Credit Card', 'Кредитная карточка', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(115, 1, 'Money Order Check', 'Money Order Check', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(116, 2, 'Money Order Check', 'Оплата наличными курьеру', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(117, 1, 'Kvitancia', 'Kvitancia', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(118, 2, 'Kvitancia', 'Оплата по квитанции СБ РФ', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(119, 1, 'Invoice', 'Invoice', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(120, 2, 'Invoice', 'Оплата по счёту', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(121, 1, 'Country', 'Country', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(122, 2, 'Country', 'Страна', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(123, 1, 'Print Order', 'Print Order', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(124, 2, 'Print Order', 'Распечатать квитанцию', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(125, 1, 'Company', 'Company', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(126, 2, 'Company', 'Компания', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(127, 1, 'Invoice', 'Invoice', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(128, 2, 'Invoice', 'Оплата по счёту', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(129, 1, 'Print Invoice', 'Print Invoice', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(130, 2, 'Print Invoice', 'Распечатать счёт', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(131, 1, 'Example', 'Example', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(132, 2, 'Example', 'Пример', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(133, 1, 'Phone', 'Phone', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(134, 2, 'Phone', 'Телефон', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(135, 1, 'Please agree to our policy.', 'Please agree to our policy.', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(136, 2, 'Please agree to our policy.', 'Нажимая кнопку "Продолжить", я подтверждаю свою дееспособность, даю согласие на обработку своих персональных данных.', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(137, 1, 'Terms & Conditions.', 'Terms & Conditions.', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(138, 2, 'Terms & Conditions.', 'Подробнее о защите персональной информации.', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(139, 1, 'All', 'All', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(140, 2, 'All', 'Все', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(141, 1, 'Pages', 'Pages', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(142, 2, 'Pages', 'Страницы', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(143, 1, 'Update', 'Update', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(144, 2, 'Update', 'Обновить', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(145, 1, 'Login', 'Login', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(146, 2, 'Login', 'Вход', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(147, 1, 'Search', 'Search', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(148, 2, 'Search', 'Поиск', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(149, 1, 'E-mail', 'E-mail', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(150, 2, 'E-mail', 'E-mail', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(151, 1, 'Password', 'Password', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(152, 2, 'Password', 'Пароль', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(153, 1, 'Registration', 'Registration', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(154, 2, 'Registration', 'Регистрация', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(155, 1, 'Name', 'Name', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(156, 2, 'Name', 'Имя', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(159, 1, 'Retype Password', 'Retype Password', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(160, 2, 'Retype Password', 'Повторите пароль', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(161, 1, 'Register', 'Register', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(162, 2, 'Register', 'Регистрация', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(163, 1, 'Logout', 'Logout', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(164, 2, 'Logout', 'Выход', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(165, 1, 'Also purchased', 'Also purchased', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(166, 2, 'Also purchased', 'Сопутствующие товары', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(167, 1, 'ZoneBased', 'ZoneBased', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(168, 2, 'ZoneBased', 'Зональный тариф', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(169, 1, 'Save', 'Save', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(170, 2, 'Save', 'Сохранить', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(171, 1, 'Account Edit', 'Account Edit', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(172, 2, 'Account Edit', 'Редактирование данных', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(173, 1, 'Address Book', 'Address Book', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(174, 2, 'Address Book', 'Адресная книга', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(175, 1, 'My Orders', 'My Orders', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(176, 2, 'My Orders', 'Мои заказы', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(177, 1, 'My Account', 'My Account', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(178, 2, 'My Account', 'Личный кабинет', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),

(179, 1, 'Order number', 'Order number', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(180, 2, 'Order number', 'Номер заказа', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(181, 1, 'Customer', 'Customer', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(182, 2, 'Customer', 'Покупатель', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(183, 1, 'Products', 'Products', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(184, 2, 'Products', 'Товары', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(185, 1, 'Order Comments', 'Order Comments', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(186, 2, 'Order Comments', 'Комментарии к заказу', '2009-09-12 20:08:49', '2009-09-12 20:08:49');


DROP TABLE IF EXISTS email_templates;
CREATE TABLE `email_templates` (
  `id` int(10) NOT NULL auto_increment,
  `alias` varchar(255) collate utf8_unicode_ci NOT NULL,
  `default` int(4) NOT NULL,
  `order` int(4) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `email_templates` VALUES (1, 'new-order', 1, 1);
INSERT INTO `email_templates` VALUES (2, 'new-order-status', 1, 2);
INSERT INTO `email_templates` VALUES (3, 'new-customer', 1, 3);


DROP TABLE IF EXISTS email_template_descriptions;
CREATE TABLE `email_template_descriptions` (
  `id` int(10) NOT NULL auto_increment,
  `email_template_id` int(10) NOT NULL,
  `language_id` int(10) NOT NULL,
  `subject` varchar(255) collate utf8_unicode_ci NOT NULL,
  `content` text collate utf8_unicode_ci NOT NULL,
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
  `id` int(10) NOT NULL auto_increment,
  `alias` varchar(255) collate utf8_unicode_ci NOT NULL,
  `default` int(4) NOT NULL,
  `order` int(4) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS answer_template_descriptions;
CREATE TABLE `answer_template_descriptions` (
  `id` int(10) NOT NULL auto_increment,
  `answer_template_id` int(10) NOT NULL,
  `language_id` int(10) NOT NULL,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `content` text collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS events;
CREATE TABLE `events` (
  `id` int(10) NOT NULL auto_increment,
  `alias` varchar(50) collate utf8_unicode_ci NOT NULL,
  `originator` varchar(50) collate utf8_unicode_ci NOT NULL,
  `description` varchar(200) collate utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
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
  `id` int(10) NOT NULL auto_increment,
  `event_id` int(10) NOT NULL,
  `originator` varchar(50) collate utf8_unicode_ci NOT NULL,
  `action` varchar(200) collate utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `event_handlers` (`id`, `event_id`, `originator`, `action`, `created`, `modified`) VALUES 
(1, 2, 'CouponsModule', '/module_coupons/event/utilize_coupon/', '2009-09-13 11:11:08', '2009-09-13 11:11:08');

DROP TABLE IF EXISTS `geo_zones`;
CREATE TABLE IF NOT EXISTS `geo_zones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `description` text NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_NAME` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS global_content_blocks;
CREATE TABLE `global_content_blocks` (
  `id` int(10) NOT NULL auto_increment,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `content` text collate utf8_unicode_ci NOT NULL,
  `alias` varchar(50) collate utf8_unicode_ci NOT NULL,
  `active` tinyint(4) NOT NULL default '1',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `global_content_blocks` (`id`, `name`, `content`, `alias`, `active`, `created`, `modified`) VALUES 
(1, 'Footer', '<a href="http://vamcart.com/">{lang}PHP Shopping Cart{/lang}</a> <a href="http://vamcart.com/">VamCart</a>', 'footer', 1, '2009-07-17 10:00:06', '2009-09-12 17:05:49');

DROP TABLE IF EXISTS languages;
CREATE TABLE `languages` (
  `id` int(10) NOT NULL auto_increment,
  `default` tinyint(4) NOT NULL,
  `name` varchar(50) collate utf8_unicode_ci NOT NULL,
  `code` varchar(5) collate utf8_unicode_ci NOT NULL,
  `iso_code_2` varchar(2) collate utf8_unicode_ci NOT NULL,
  `active` tinyint(4) NOT NULL default '1',
  `sort_order` int(3) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `languages` (`id`, `default`, `name`, `code`, `iso_code_2`, `active`, `sort_order`) VALUES 
(1, 1, 'English', 'eng', 'en', 1, 1),
(2, 0, 'Русский', 'rus', 'ru', 1, 0);

DROP TABLE IF EXISTS micro_templates;
CREATE TABLE `micro_templates` (
  `id` int(10) NOT NULL auto_increment,
  `alias` varchar(50) collate utf8_unicode_ci NOT NULL,
  `template` text collate utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `tag_name` varchar(20) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `micro_templates` VALUES (1, 'vertical-menu', '<!-- Categories box -->\r\n<div class="box">\r\n<h5><img src="{base_path}/img/icons/menu/categories.png" alt="" />&nbsp;{lang}Categories{/lang}</h5>\r\n<div class="boxContent">\r\n<ul id="CatNavi">\r\n{foreach from=$content_list item=node}\r\n<li{if $node.alias == $content_alias} class="active"{/if}><a href="{$node.url}">{$node.name}</a></li>\r\n{/foreach}\r\n</ul>\r\n</div>\r\n</div>\r\n<!-- /Categories box -->', '2009-07-28 17:08:06', '2010-02-05 19:15:05', 'content_listing');
INSERT INTO `micro_templates` VALUES (3, 'information-links', '<li{if $content_alias == \'home-page\'} class="current"{/if}><a href="{base_path}/">&nbsp;<img src="{base_path}/img/icons/page/home.png" border="0" alt="" /><span>{lang}Home{/lang}</span></a></li>\r\n{foreach from=$content_list item=node}\r\n<li{if $node.alias == $content_alias} class="current"{/if}><a href="{$node.url}">{if $node.icon}&nbsp;<img src="{$node.icon}" border="0" alt="" />{/if}<span>{$node.name}</span></a></li>\r\n{/foreach}\r\n', '2009-07-30 15:42:21', '2009-07-12 15:41:54', 'content_listing');
INSERT INTO `micro_templates` VALUES (5, 'shopping-cart', '<div class="cart">\r\n	<table>\r\n		<tr>	\r\n			<th> </th>\r\n			<th>{lang}Product{/lang}</th>\r\n			<th>{lang}Price Ea.{/lang}</th>\r\n			<th>{lang}Qty{/lang}</th>\r\n			<th>{lang}Total{/lang}</th>\r\n		</tr>\r\n				\r\n		{foreach from=$order_items item=product}			\r\n			<tr>\r\n				<td><a href="{base_path}/cart/remove_product/{$product.id}" class="remove">x</a></td>\r\n				<td><a href="{$product.link}">{$product.name}</a></td>\r\n				<td>{$product.price}</td>\r\n				<td>{$product.qty}</td>\r\n				<td>{$product.line_total}</td>\r\n			</tr>				\r\n		{foreachelse}	\r\n			<tr>\r\n				<td colspan="5">{lang}No Cart Items{/lang}</td>\r\n			</tr>\r\n		{/foreach}				\r\n				\r\n		<tr class="cart_total">\r\n			<td colspan="5">{lang}Total{/lang} {$order_total}</td>\r\n		</tr>\r\n	</table>\r\n	<a class="checkout" href="{$checkout_link}">{lang}Checkout{/lang}</a>\r\n</div>', '2009-07-31 14:56:59', '2009-09-02 22:26:49', 'shopping_cart');
INSERT INTO `micro_templates` VALUES (6, 'currency-box', '<!-- Box -->\r\n<div class="box">\r\n<h5><img src="{base_path}/img/icons/menu/payment-methods.png" alt="" />&nbsp;{lang}Currency{/lang}</h5>\r\n<div class="boxContent">\r\n\r\n<form action="{base_path}/currencies/pick_currency/" method="post">\r\n<select name="currency_picker">\r\n{foreach from=$currencies item=currency}\r\n<option value="{$currency.id}" {if $currency.id == $smarty.session.Customer.currency_id}selected="selected"{/if}>{$currency.name}</option>\r\n{/foreach}\r\n</select>\r\n<button class="btn" type="submit" value="{lang}Go{/lang}"><i class="cus-tick"></i> {lang}Go{/lang}</button>\r\n</form>\r\n		\r\n</p>\r\n</div>\r\n</div>\r\n<!-- /Box -->', '2009-08-01 14:42:02', '2010-02-05 19:19:50', 'currency_box');
INSERT INTO `micro_templates` VALUES (8, 'cart-content-box', '<!-- Box -->\r\n<div id="shopping-cart-box">\r\n<div class="box">\r\n<h5><img src="{base_path}/img/icons/menu/orders.png" alt="" />&nbsp;<a href="{$cart_link}" class="shopping_cart_link">{lang}Shopping Cart{/lang}</a></h5>\r\n<div class="boxContent">\r\n\r\n	<ul class="cart_contents">\r\n		{foreach from=$order_items item=product}\r\n			<li>{$product.qty} x <a href="{$product.url}">{$product.name}</a></li>\r\n		{/foreach}\r\n	</ul>\r\n	<ul class="cart_total">\r\n		<li>{lang}Total{/lang}: {$order_total}</li>\r\n	</ul>\r\n	<a class="checkout" href="{$checkout_link}">{lang}Checkout{/lang}</a>\r\n		\r\n</p>\r\n</div>\r\n</div>\r\n</div>\r\n<!-- /Box -->', '2009-08-09 16:27:09', '2010-02-05 19:18:16', 'shopping_cart');
INSERT INTO `micro_templates` VALUES (9, 'payment-view-cart', '<div class="cart">\r\n	<table>\r\n		<tr>	\r\n			<th> </th>\r\n			<th>{lang}Product{/lang}</th>\r\n			<th>{lang}Price Ea.{/lang}</th>\r\n			<th>{lang}Qty{/lang}</th>\r\n			<th>{lang}Total{/lang}</th>\r\n		</tr>\r\n				\r\n		{foreach from=$order_items item=product}			\r\n			<tr>\r\n				<td><a href="{base_path}/cart/remove_product/{$product.id}" class="remove">x</a></td>\r\n				<td><a href="{$product.link}">{$product.name}</a></td>\r\n				<td>{$product.price}</td>\r\n				<td>{$product.qty}</td>\r\n				<td>{$product.line_total}</td>\r\n			</tr>				\r\n		{foreachelse}	\r\n			<tr>\r\n				<td colspan="5">{lang}No Cart Items{/lang}</td>\r\n			</tr>\r\n		{/foreach}				\r\n				\r\n		<tr class="cart_total">\r\n			<td colspan="5">\r\n				{lang}Shipping{/lang}: {$shipping_total}<br />\r\n				<strong>{lang}Total{/lang}:</strong> {$order_total}\r\n			</td>\r\n		</tr>\r\n	</table>\r\n</div>', '2009-08-10 13:09:25', '2009-09-02 22:25:57', 'shopping_cart');
INSERT INTO `micro_templates` VALUES (10, 'language-box', '<!-- Box -->\r\n<div class="box">\r\n<h5><img src="{base_path}/img/icons/menu/locale.png" alt="" />&nbsp;{lang}Language{/lang}</h5>\r\n<div class="boxContent">\r\n\r\n{foreach from=$languages item=language}\r\n<a href="{$language.url}"><img src="{$language.image}" alt="{$language.name}" title="{$language.name}"/></a>\r\n{/foreach}\r\n\r\n</div>\r\n</div>\r\n<!-- /Box -->', '2009-07-12 18:52:23', '2010-02-05 19:15:57', 'language_box');
INSERT INTO `micro_templates` VALUES (11, 'subcategory-listing', '<div>\r\n<ul class="listing">\r\n{foreach from=$content_list item=node}\r\n	<li\r\n	{if $node.alias == $content_alias}\r\n		class="active"\r\n	{/if}\r\n	>\r\n	<div><a href="{$node.url}"><img src="{$node.image}" alt="{$node.name}" \r\n	{if isset($thumbnail_width)}\r\n	 width="{$thumbnail_width}"\r\n	{/if}\r\n	/></a></div>\r\n	<div><a href="{$node.url}">{$node.name}</a></div></li>\r\n{foreachelse}\r\n	<li class="no_items">{lang}No Items Found{/lang}</li>\r\n{/foreach}\r\n</ul>\r\n<div class="clear"></div>\r\n</div>\r\n', '2009-07-12 18:52:23', '2009-07-12 18:57:08', 'content_listing');
INSERT INTO `micro_templates` VALUES (12, 'product-listing', '<div>\r\n {if $pages_number > 1 || $page=="all"}\r\n    <div class="paginator">\r\n          <ul>\r\n            <li>{lang}Pages{/lang}:</li>\r\n            {for $pg=1 to $pages_number}\r\n            <li><a href="{base_path}/category/{$content_alias->value}{$ext}/page/{$pg}" {if $pg == $page}class="current"{/if}>{$pg}</a></li>\r\n            {/for}\r\n            <li><a href="{base_path}/category/{$content_alias->value}{$ext}/page/all" {if "all" == $page}class="current"{/if}>{lang}All{/lang}</a></li>\r\n          </ul>\r\n    </div>\r\n  {/if}  \r\n<ul class="listing">\r\n{foreach from=$content_list item=node}\r\n	<li\r\n	{if $node.alias == $content_alias}\r\n		class="active"\r\n	{/if}\r\n	>\r\n	<div><a href="{$node.url}"><img src="{$node.image}" alt="{$node.name}" \r\n	{if isset($thumbnail_width)}\r\n	 width="{$thumbnail_width}"\r\n	{/if}\r\n	/></a></div>\r\n	<div><a href="{$node.url}">{$node.name}</a></div></li>\r\n{foreachelse}\r\n	<li class="no_items">{lang}No Items Found{/lang}</li>\r\n{/foreach}\r\n</ul>\r\n<div class="clear"></div> \r\n\r\n  {if $pages_number > 1 || $page=="all"}\r\n    <div class="paginator">\r\n          <ul>\r\n            <li>{lang}Pages{/lang}:</li>\r\n            {for $pg=1 to $pages_number}\r\n            <li><a href="{base_path}/category/{$content_alias->value}{$ext}/page/{$pg}" {if $pg == $page}class="current"{/if}>{$pg}</a></li>\r\n            {/for}\r\n            <li><a href="{base_path}/category/{$content_alias->value}{$ext}/page/all" {if "all" == $page}class="current"{/if}>{lang}All{/lang}</a></li>\r\n          </ul>\r\n    </div>\r\n  {/if}  \r\n  \r\n</div>\r\n', '2009-07-12 18:52:23', '2009-07-12 18:57:08', 'content_listing');
INSERT INTO `micro_templates` VALUES (13, 'checkout', '<script type="text/javascript" src="{base_path}/js/modified.js"></script>\r\n<script type="text/javascript" src="{base_path}/js/focus-first-input.js"></script>\r\n<script type="text/javascript" src="{base_path}/js/jquery/plugins/validate/jquery.validate.pack.js"></script>\r\n  \r\n<script type="text/javascript">\r\n$(document).ready(function() {\r\n  // validate checkout form\r\n  $("#contentform").validate({\r\n    rules: {\r\n      bill_name: {\r\n        required: true,\r\n        minlength: 2      \r\n     },\r\n      agree: {\r\n        required: true\r\n     },\r\n    },\r\n    messages: {\r\n      bill_name: {\r\n        required: "Required field",\r\n        minlength: "Required field. Min length: 2"\r\n      },\r\n      agree: {\r\n        required: "Required field"\r\n      }\r\n    }\r\n  });\r\n});\r\n</script>\r\n<script type="text/javascript">\r\n  $(document).ready(function() {\r\n    $("div#ship_information").hide();\r\n    $("div#diff_shipping").click(function (){\r\n        $("div#ship_information").show();\r\n        $("div#diff_shipping").hide();\r\n    });\r\n    $("#bill_country").change(function () {\r\n      $("#bill_state_div").load(''/countries/billing_regions/'' + $(this).val());\r\n    });\r\n    $("#ship_country").change(function () {\r\n      $("#ship_state_div").load(''/countries/shipping_regions/'' + $(this).val());\r\n    });\r\n  });\r\n</script>\r\n\r\n<div id="checkout">\r\n<form action="{$checkout_form_action}" method="post" id="contentform">\r\n  <div id="shipping_method">\r\n    <div>\r\n      <h3>{lang}Shipping Method{/lang}</h3>\r\n    </div>  \r\n    {foreach from=$ship_methods item=ship_method}\r\n      <div>\r\n        <input type="radio" name="shipping_method_id" value="{$ship_method.id}" id="ship_{$ship_method.id}" \r\n        {if $ship_method.id == $order.shipping_method_id}\r\n          checked="checked"\r\n         {/if}\r\n        />\r\n        <label for="ship_{$ship_method.id}">\r\n          {if $ship_method.icon}<img src="{base_path}/img/icons/shipping/{$ship_method.icon}" alt="{$ship_method.name}" title="{$ship_method.name}" />&nbsp;{/if}\r\n          {lang}{$ship_method.name}{/lang}\r\n          </label>\r\n      </div>\r\n    {/foreach}\r\n  </div>\r\n  <div id="payment_method">\r\n    <div>\r\n      <h3>{lang}Payment Method{/lang}</h3>\r\n    </div>    \r\n    {foreach from=$payment_methods item=payment_method}\r\n      <div>\r\n        <input type="radio" name="payment_method_id" value="{$payment_method.id}" id="payment_{$payment_method.id}" \r\n        {if $payment_method.id == $order.payment_method_id}\r\n          checked="checked"\r\n         {/if}        \r\n        />\r\n        <label for="payment_{$payment_method.id}">\r\n{if $payment_method.icon}<img src="{base_path}/img/icons/payment/{$payment_method.icon}" alt="{$payment_method.name}" title="{$payment_method.name}" />&nbsp;{/if}\r\n{lang}{$payment_method.name}{/lang}\r\n</label>\r\n      </div>\r\n    {/foreach}    \r\n  </div>\r\n  <div id="bill_information">\r\n    <div>\r\n      <h3>{lang}Billing Information{/lang}</h3>\r\n    </div>\r\n    <div>  \r\n      <label for="bill_name">{lang}Name{/lang}</label>\r\n      <input type="text" name="bill_name" id="bill_name" value="{$order.bill_name}"/>\r\n    </div>\r\n    <div>  \r\n      <label for="bill_line_1">{lang}Address Line 1{/lang}</label>\r\n      <input type="text" name="bill_line_1" id="bill_line_1" value="{$order.bill_line_1}" />\r\n    </div>    \r\n    <div>  \r\n      <label for="bill_line_2">{lang}Address Line 2{/lang}</label>\r\n      <input type="text" name="bill_line_2" id="bill_line_2" value="{$order.bill_line_2}" />\r\n    </div>    \r\n    <div>  \r\n      <label for="bill_city">{lang}City{/lang}</label>\r\n      <input type="text" name="bill_city" id="bill_city" value="{$order.bill_city}" />\r\n    </div>    \r\n    <div>  \r\n      <label for="bill_country">{lang}Country{/lang}</label>\r\n      <select name="bill_country" id="bill_country">{country_list selected=$order.bill_country}</select>\r\n    </div>    \r\n    <div id="bill_state_div">  \r\n      <label for="bill_state">{lang}State{/lang}</label>\r\n      <select name="bill_state" id="bill_state">{state_list country=$order.bill_country selected=$order.bill_state}</select>\r\n    </div>    \r\n    <div>  \r\n      <label for="bill_zip">{lang}Zipcode{/lang}</label>\r\n      <input type="text" name="bill_zip" id="bill_zip" value="{$order.bill_zip}" />\r\n    </div>  \r\n  </div>    \r\n  <div id="diff_shipping">\r\n    <div>\r\n      <h3>{lang}Shipping Information{/lang}</h3>\r\n    </div>\r\n    <div>\r\n      <label for="diff_shipping"><input type="checkbox" name="diff_shipping" id="diff_shipping" value="1" /> {lang}Different from billing address{/lang}</label>\r\n    </div>\r\n  </div>\r\n  <div id="ship_information">\r\n    <div>\r\n      <h3>{lang}Shipping Information{/lang}</h3>\r\n    </div>\r\n    <div>  \r\n      <label for="ship_name">{lang}Name{/lang}</label>\r\n      <input type="text" name="ship_name" id="ship_name" value="{$order.ship_name}" />\r\n    </div>\r\n    <div>  \r\n      <label for="ship_line_1">{lang}Address Line 1{/lang}</label>\r\n      <input type="text" name="ship_line_1" id="ship_line_1" value="{$order.ship_line_1}" />\r\n    </div>    \r\n    <div>  \r\n      <label for="ship_line_2">{lang}Address Line 1{/lang}</label>\r\n      <input type="text" name="ship_line_2" id="ship_line_2" value="{$order.ship_line_2}" />\r\n    </div>    \r\n    <div>  \r\n      <label for="ship_city">{lang}City{/lang}</label>\r\n      <input type="text" name="ship_city" id="ship_city" value="{$order.ship_city}" />\r\n    </div>    \r\n    <div>  \r\n      <label for="ship_country">{lang}Country{/lang}</label>\r\n      <select name="ship_country" id="ship_country">{country_list selected=$order.ship_country}</select>\r\n    </div>    \r\n    <div id="ship_state_div">  \r\n      <label for="ship_state">{lang}State{/lang}</label>\r\n      <select name="ship_state" id="ship_state">{state_list country=$order.ship_country selected=$order.ship_state}</select>\r\n    </div>    \r\n    <div>  \r\n      <label for="ship_zip">{lang}Zipcode{/lang}</label>\r\n      <input type="text" name="ship_zip" id="ship_zip" value="{$order.ship_zip}" />\r\n    </div>                \r\n  </div>\r\n  <div id="contact_information">\r\n    <div>\r\n      <h3>{lang}Contact Information{/lang}</h3>\r\n    </div>\r\n    <div>  \r\n      <label for="email">{lang}Email{/lang}</label>\r\n      <input type="text" name="email" id="email" value="{$order.email}" />\r\n    </div>\r\n    <div>  \r\n      <label for="phone">{lang}Phone{/lang}</label>\r\n      <input type="text" name="phone" id="phone" value="{$order.phone}" />\r\n    </div>    \r\n    <div>  \r\n      <label for="company_name">{lang}Company{/lang}</label>\r\n      <input type="text" name="company_name" id="company_name" value="{$order.company_name}" />\r\n    </div>    \r\n    <div>  \r\n      <label for="company_vat">{lang}VAT number{/lang}</label>\r\n      <input type="text" name="company_vat" id="company_vat" value="{$order.company_vat}" />\r\n    </div>    \r\n    <div>  \r\n      <label for="agree">{lang}Please agree to our policy.{/lang} <a href="{base_path}/page/conditions-of-use.html">{lang}Terms & Conditions.{/lang}</a></label>\r\n      <input type="checkbox" class="checkbox" id="agree" name="agree" />\r\n    </div>    \r\n  </div>\r\n  <div>\r\n  {module alias="coupons" action="checkout_box"}\r\n  </div>\r\n  <button class="btn" type="submit" value="{lang}Continue{/lang}"><i class="cus-tick"></i> {lang}Continue{/lang}</button>\r\n</form>\r\n</div>\r\n', '2009-07-12 18:52:23', '2013-05-30 19:05:43', 'checkout');
INSERT INTO `micro_templates` VALUES (14, 'news-box', '<!-- News box -->\r\n<div class="box">\r\n<h5><img src="{base_path}/img/icons/menu/pages.png" alt="" />&nbsp;{lang}News{/lang}</h5>\r\n<div class="boxContent">\r\n<ul>\r\n{foreach from=$content_list item=node}\r\n<li{if $node.alias == $content_alias} class="active"{/if}><a href="{$node.url}">{$node.name}</a></li>\r\n{/foreach}\r\n</ul>\r\n</div>\r\n</div>\r\n<!-- /News box -->', '2009-07-12 18:52:23', '2010-02-05 19:17:42', 'content_listing');
INSERT INTO `micro_templates` VALUES (15, 'articles-box', '<!-- Articles box -->\r\n<div class="box">\r\n<h5><img src="{base_path}/img/icons/menu/blocks.png" alt="" />&nbsp;{lang}Articles{/lang}</h5>\r\n<div class="boxContent">\r\n<ul>\r\n{foreach from=$content_list item=node}\r\n<li{if $node.alias == $content_alias} class="active"{/if}><a href="{$node.url}">{$node.name}</a></li>\r\n{/foreach}\r\n</ul>\r\n</div>\r\n</div>\r\n<!-- /Articles box -->', '2009-07-12 18:52:23', '2010-02-05 19:17:51', 'content_listing');
INSERT INTO `micro_templates` VALUES (16, 'cart-content-box-ajax', '<div class="box">\r\n<h5><img src="{base_path}/img/icons/menu/orders.png" alt="" />&nbsp;<a href="{$cart_link}" class="shopping_cart_link">{lang}Shopping Cart{/lang}</a></h5>\r\n<div class="boxContent">\r\n	<ul class="cart_contents">\r\n		{foreach from=$order_items item=product}\r\n                <li>{$product.qty} x <a href="{$product.url}">{$product.name}</a></li>\r\n		{/foreach}\r\n	</ul>\r\n	<ul class="cart_total">\r\n		<li>{lang}Total{/lang}: {$order_total}</li>\r\n 	</ul>\r\n	<a class="checkout" href="{$checkout_link}">{lang}Checkout{/lang}</a>\r\n</div>\r\n</div>\r\n', '2012-07-06 12:26:25', '2012-07-06 12:31:32', 'shopping_cart');
INSERT INTO `micro_templates` VALUES (17, 'search-box', '<!-- Search box -->\r\n<div class="box">\r\n<h5><img src="{base_path}/img/icons/menu/categories.png" alt="" />&nbsp;{lang}Search{/lang}</h5>\r\n<div class="boxContent">\r\n\r\n<form action="{base_path}/page/search-result.html" method="get">\r\n<input type="text" name="keyword" />\r\n<br />\r\n<button class="btn" type="submit" value="{lang}Go{/lang}"><i class="cus-magnifier"></i> {lang}Search{/lang}</button>\r\n</form>\r\n\r\n</div>\r\n</div>\r\n<!-- /Search box -->', '2012-07-30 00:00:00', '2012-07-30 15:58:32', 'content_listing');
INSERT INTO `micro_templates` VALUES (18, 'login-box', '<div class="box">\r\n<h5>&nbsp;{lang}Login{/lang}</h5>\r\n<div class="boxContent">\r\n{if not $is_logged_in }\r\n<form action="{base_path}/site/login?return_url={$return_url}" method="post">\r\n<label>{lang}E-mail{/lang}</label>\r\n<input type="text" name="data[Customer][email]" />\r\n<br />\r\n<label>{lang}Password{/lang}</label>\r\n<input type="password" name="data[Customer][password]" />\r\n<br />\r\n<button class="btn" type="submit" value="{lang}Login{/lang}"><i class="cus-tick"></i> {lang}Login{/lang}</button>\r\n</form>\r\n<br />\r\n  <a href="{base_path}/customer/register.html">{lang}Registration{/lang}</a>\r\n{else}\r\n<ul>\r\n  <li><a href="{base_path}/customer/account.html">{lang}My Account{/lang}</a></li>\r\n</ul>\r\n<form action="{base_path}/site/logout?return_url={$return_url}" method="post">\r\n<button class="btn" type="submit" value="{lang}Logout{/lang}"><i class="cus-tick"></i> {lang}Logout{/lang}</button>\r\n</form>\r\n{/if}\r\n</div>\r\n</div>', '2012-08-19 13:56:58', '2012-08-25 02:46:36', 'login_box');



DROP TABLE IF EXISTS modules;
CREATE TABLE `modules` (
  `id` int(10) NOT NULL auto_increment,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `icon` varchar(255) collate utf8_unicode_ci NOT NULL,
  `alias` varchar(255) collate utf8_unicode_ci NOT NULL,
  `version` varchar(10) collate utf8_unicode_ci NOT NULL,
  `nav_level` int(4) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `modules` (`id`, `name`, `icon`, `alias`, `version`, `nav_level`) VALUES 
(1, 'reviews', 'cus-user-comment', 'reviews', '1.0', 3),
(2, 'coupons', 'cus-calculator', 'coupons', '2', 3);

DROP TABLE IF EXISTS module_coupons;
CREATE TABLE `module_coupons` (
  `id` int(10) NOT NULL auto_increment,
  `name` varchar(50) collate utf8_unicode_ci NOT NULL,
  `code` varchar(50) collate utf8_unicode_ci NOT NULL,
  `free_shipping` varchar(10) collate utf8_unicode_ci NOT NULL,
  `percent_off_total` double NOT NULL,
  `amount_off_total` double NOT NULL,
  `max_uses` int(10) NOT NULL,
  `min_product_count` int(10) NOT NULL,
  `max_product_count` int(10) NOT NULL,
  `min_order_total` int(10) NOT NULL,
  `max_order_total` int(10) NOT NULL,
  `start_date` datetime NOT NULL,
  `expiration_date` datetime NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS module_reviews;
CREATE TABLE `module_reviews` (
  `id` int(10) NOT NULL auto_increment,
  `content_id` int(10) NOT NULL,
  `name` varchar(50) collate utf8_unicode_ci NOT NULL,
  `content` text collate utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS orders;
CREATE TABLE `orders` (
  `id` int(10) NOT NULL auto_increment,
  `customer_id` int(10) NOT NULL,
  `order_status_id` int(10) NOT NULL,
  `shipping_method_id` int(10) NOT NULL,
  `payment_method_id` int(10) NOT NULL,
  `shipping` double NOT NULL,
  `tax` double NOT NULL,
  `total` double NOT NULL,
  `bill_name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `bill_line_1` varchar(255) collate utf8_unicode_ci NOT NULL,
  `bill_line_2` varchar(255) collate utf8_unicode_ci NOT NULL,
  `bill_city` varchar(255) collate utf8_unicode_ci NOT NULL,
  `bill_state` varchar(255) collate utf8_unicode_ci NOT NULL,
  `bill_country` varchar(255) collate utf8_unicode_ci NOT NULL,
  `bill_zip` varchar(20) collate utf8_unicode_ci NOT NULL,
  `ship_name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `ship_line_1` varchar(255) collate utf8_unicode_ci NOT NULL,
  `ship_line_2` varchar(255) collate utf8_unicode_ci NOT NULL,
  `ship_city` varchar(255) collate utf8_unicode_ci NOT NULL,
  `ship_state` varchar(255) collate utf8_unicode_ci NOT NULL,
  `ship_country` varchar(255) collate utf8_unicode_ci NOT NULL,
  `ship_zip` varchar(20) collate utf8_unicode_ci NOT NULL,
  `email` varchar(255) collate utf8_unicode_ci NOT NULL,
  `phone` varchar(15) collate utf8_unicode_ci NOT NULL,
  `company_name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `company_info` varchar(255) collate utf8_unicode_ci NOT NULL,
  `company_vat` varchar(20) collate utf8_unicode_ci DEFAULT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `orders` (`id`, `customer_id`, `order_status_id`, `shipping_method_id`, `payment_method_id`, `shipping`, `tax`, `total`, `bill_name`, `bill_line_1`, `bill_line_2`, `bill_city`, `bill_state`, `bill_country`, `bill_zip`, `ship_name`, `ship_line_1`, `ship_line_2`, `ship_city`, `ship_state`, `ship_country`, `ship_zip`, `email`, `phone`, `company_name`, `company_info`, `created`) VALUES 
(1, 0, 1, 2, 2, 0, 0, 25.79, 'Test Order', 'asdfasf', 'asdfasdf', '', '', '', '', 'Test Order', '', '', '', '', '', '', 'vam@test.com', '', '', '', '2009-08-28 11:06:18');

DROP TABLE IF EXISTS order_comments;
CREATE TABLE `order_comments` (
  `id` int(10) NOT NULL auto_increment,
  `user_id` int(10) NOT NULL,
  `order_id` int(10) NOT NULL,
  `sent_to_customer` tinyint(4) NOT NULL,
  `comment` text collate utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `order_comments` (`id`, `user_id`, `order_id`, `sent_to_customer`, `comment`, `created`, `modified`) VALUES 
(1, 1, 1, 0, 'asdf', '2009-08-28 11:06:18', '2009-08-28 11:06:18');

DROP TABLE IF EXISTS order_products;
CREATE TABLE `order_products` (
  `id` int(10) NOT NULL auto_increment,
  `order_id` int(10) NOT NULL,
  `content_id` int(10) NOT NULL,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `model` varchar(255) collate utf8_unicode_ci NOT NULL,
  `quantity` int(10) NOT NULL,
  `price` double NOT NULL,
  `weight` varchar(10) collate utf8_unicode_ci NOT NULL,
  `tax` double NOT NULL,
  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `filestorename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `download_count` int(11) NOT NULL,
  `max_downloads` int(10) NOT NULL DEFAULT '0',
  `max_days_for_download` int(10) NOT NULL DEFAULT '0',
  `download_key` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `order_status_id` int(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `order_products` (`id`, `order_id`, `content_id`, `name`, `model`, `quantity`, `price`, `weight`, `tax`) VALUES 
(1, 1, 38, 'Mozilla Firefox', '', 3, 4.95, '', 0),
(2, 1, 37, 'Internet Explorer', '', 2, 10.99, '', 0);

DROP TABLE IF EXISTS order_statuses;
CREATE TABLE `order_statuses` (
  `id` int(10) NOT NULL auto_increment,
  `default` tinyint(4) NOT NULL,
  `order` int(4) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `order_statuses` (`id`, `default`, `order`) VALUES 
(1, 1, 1),
(2, 0, 2),
(3, 0, 3),
(4, 0, 4);

DROP TABLE IF EXISTS order_status_descriptions;
CREATE TABLE `order_status_descriptions` (
  `id` int(10) NOT NULL auto_increment,
  `order_status_id` int(10) NOT NULL,
  `language_id` int(10) NOT NULL,
  `name` varchar(50) collate utf8_unicode_ci NOT NULL,
  `description` text collate utf8_unicode_ci NOT NULL,
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
  `id` int(10) NOT NULL auto_increment,
  `active` tinyint(4) NOT NULL,
  `default` tinyint(4) NOT NULL,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `icon` varchar(255) collate utf8_unicode_ci NOT NULL,
  `alias` varchar(255) collate utf8_unicode_ci NOT NULL,
  `order` int(10) NOT NULL,
  `order_status_id` int(10) NOT NULL,
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
  `id` int(10) NOT NULL auto_increment,
  `payment_method_id` int(10) NOT NULL,
  `key` varchar(50) collate utf8_unicode_ci NOT NULL,
  `value` varchar(255) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `payment_method_values` (`id`, `payment_method_id`, `key`, `value`) VALUES 
(1, 3, 'paypal_email', 'vam@test.com'),
(2, 5, 'authorize_login', '123456'),
(3, 6, 'google_html_merchant_id', '1234567890');

DROP TABLE IF EXISTS search_tables;
CREATE TABLE `search_tables` (
  `id` int(10) NOT NULL auto_increment,
  `model` varchar(50) collate utf8_unicode_ci NOT NULL,
  `field` varchar(50) collate utf8_unicode_ci NOT NULL,
  `url` varchar(50) collate utf8_unicode_ci NOT NULL,
  `edit_field` varchar(50) collate utf8_unicode_ci NOT NULL,
  `alternate_anchor` varchar(50) collate utf8_unicode_ci NOT NULL,
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
  `id` int(10) NOT NULL auto_increment,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `icon` varchar(255) collate utf8_unicode_ci NOT NULL,
  `code` varchar(255) collate utf8_unicode_ci NOT NULL,
  `default` tinyint(4) NOT NULL default '0',
  `active` tinyint(4) NOT NULL,
  `order` int(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `shipping_methods` (`id`, `name`, `icon`, `code`, `default`, `active`, `order`) VALUES 
(1, 'Free Shipping', '', 'FreeShipping', 0, 1, 0),
(2, 'Flat Rate', '', 'FlatRate', 1, 1, 0),
(3, 'Per Item', '', 'PerItem', 0, 1, 0),
(4, 'Table Based', '', 'TableBased', 0, 1, 0);

DROP TABLE IF EXISTS shipping_method_values;
CREATE TABLE `shipping_method_values` (
  `id` int(10) NOT NULL auto_increment,
  `shipping_method_id` int(10) NOT NULL,
  `key` varchar(50) collate utf8_unicode_ci NOT NULL,
  `value` varchar(255) collate utf8_unicode_ci NOT NULL,
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
  `id` int(10) NOT NULL auto_increment,
  `active` tinyint(4) NOT NULL,
  `name` varchar(50) collate utf8_unicode_ci NOT NULL,
  `alias` varchar(255) collate utf8_unicode_ci NOT NULL,
  `stylesheet` text collate utf8_unicode_ci NOT NULL,
  `stylesheet_media_type_id` int(10) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `stylesheets` (`id`, `active`, `name`, `alias`, `stylesheet`, `stylesheet_media_type_id`, `created`, `modified`) VALUES
(1, 1, 'VamCart', 'vamcart', '/* -----------------------------------------------------------------------------------------\r\n   VamCart - http://vamcart.com\r\n   -----------------------------------------------------------------------------------------\r\n   Copyright (c) 2013 VamSoft Ltd.\r\n   License - http://vamcart.com/license.html\r\n   ---------------------------------------------------------------------------------------*/\r\n\r\nhtml,body\r\n  {\r\n    margin: 0;\r\n    padding: 0;\r\n    background-color: #fff;\r\n    background-image: url(../../img/bg.png);\r\n    background-position: 0 -221px;\r\n    background-repeat: repeat-x;\r\n  }\r\n\r\nbody\r\n  {\r\n    font-family: ''Lucida Grande'', Helvetica, Arial, Verdana, sans-serif;\r\n    font-size: 11pt;\r\n  }\r\n\r\nimg\r\n	{\r\n		border: 0;\r\n	}\r\n\r\nh2 img\r\n	{\r\n		border: 0;\r\n		padding: 0;\r\n		margin: 0 0 5px 0;\r\n	}\r\n\r\nul, li\r\n  {\r\n    list-style: none;\r\n    margin: 0;\r\n    padding: 0;\r\n  }\r\n\r\n/* Links color */\r\na\r\n  {\r\n    color: #000;\r\n    text-decoration: underline;\r\n  }\r\n\r\na:hover\r\n  {\r\n    color: #990000;\r\n    text-decoration: none;\r\n  }\r\n/* /Links color */\r\n\r\n/* Content */\r\ndiv#wrapper\r\n  {\r\n    float: left;\r\n    width: 100%;\r\n  }\r\n\r\ndiv#content\r\n  {\r\n    margin: 0 19%;\r\n  }\r\n\r\ndiv#content a, \r\ndiv#content a:visited,\r\ndiv#content a:hover  \r\n	{\r\n		color: #494a4e;\r\n		text-decoration: none;\r\n	}\r\n\r\ndiv#header a, \r\ndiv#header a:visited, \r\ndiv#header a:hover \r\n	{\r\n		color: #494a4e;\r\n		text-decoration: none;\r\n	}\r\n	\r\n/* /Content */\r\n\r\n/* Left column */\r\ndiv#left\r\n  {\r\n    float: left;\r\n    width: 18%;\r\n    margin-left: -100%;\r\n    background: transparent;\r\n  }\r\n/* /Left column */\r\n\r\n/* Right column */\r\ndiv#right\r\n  {\r\n    float: left;\r\n    overflow: auto;\r\n    width: 18%;\r\n    margin-left: -18%;\r\n    background: transparent;\r\n  }\r\n/* /Right column */\r\n\r\n/* Header */\r\n\r\n#header\r\n  {\r\n    background-color: #fff;\r\n    background-image: url(../../img/bg.png);\r\n    background-position: 0 0;\r\n    background-repeat: repeat-x;\r\n    height: 100px;\r\n  }\r\n\r\n\r\n#header div.header-left\r\n  {\r\n    float: left;\r\n    margin: 0;\r\n    padding: 0;\r\n  }\r\n\r\n\r\n#header div.header-right\r\n  {\r\n    float: right;\r\n    margin: 0;\r\n    padding: .3em;\r\n  }\r\n\r\n/* /Header */\r\n\r\n/* Footer */\r\ndiv#footer\r\n  {\r\n    clear: left;\r\n    height: 50px;\r\n    width: 100%;\r\n    background: transparent;\r\n    border-top: 0px solid #67748B;\r\n    text-align: center;\r\n    color: #000;\r\n  }\r\n   \r\ndiv#footer p\r\n  {\r\n    margin: 0;\r\n    padding: 5px 10px;\r\n  }\r\n   \r\n/* /Footer */\r\n\r\n/* Navigation */\r\n/* /Navigation */\r\n   \r\n/* Page header */\r\n\r\n#content h1,\r\n#content h2,\r\n#content h3\r\n  {\r\n    color: #ff7b08;\r\n    font-weight: bold;\r\n    font-size: 12pt;\r\n  }\r\n\r\n/* /Page header */\r\n\r\n/* Page content */\r\n\r\ndiv.page\r\n  {\r\n    margin: 0;\r\n    padding: 0;\r\n  }\r\n\r\ndiv.page h2\r\n  {\r\n    margin: 0;\r\n    padding: 7px 0 7px 10px;\r\n    background-color: #f4f4f4;\r\n    background-image: url(../../img/bg.png);\r\n    background-position: 0 -135px;\r\n    background-repeat: repeat-x;\r\n    border-top: 1px solid #c0c1c2;\r\n    border-left: 1px solid #c0c1c2;\r\n    border-right: 1px solid #c0c1c2;\r\n    border-bottom: 1px solid #c0c1c2;\r\n    border-top-left-radius: 8px;\r\n    border-top-right-radius: 8px;\r\n    vertical-align: middle;\r\n  }\r\n  \r\ndiv.pageContent\r\n  {\r\n    margin: 0;\r\n    padding: .5em;\r\n    background-color: #fff;\r\n    background-image: url(../../img/bg.png);\r\n    background-position: 0 -602px;\r\n    background-repeat: repeat-x;\r\n    border-top: 0px;\r\n    border-left: 1px solid #c0c1c2;\r\n    border-right: 1px solid #c0c1c2;\r\n    border-bottom: 1px solid #c0c1c2;\r\n    border-bottom-left-radius: 8px;\r\n    border-bottom-right-radius: 8px;\r\n  }\r\n\r\n/* /Page content */\r\n\r\n/*- Menu */\r\n\r\ndiv#menu\r\n  {\r\n    border-top: 3px solid #ff7b08;\r\n    background-color: #fff;\r\n    background-image: url(../../img/bg.png);\r\n    background-position: 0 -100px;\r\n    background-repeat: repeat-x;\r\n    padding: 0;\r\n    margin: 0 auto;\r\n  }\r\n\r\n#menu ul, #menu ul li\r\n  {\r\n    list-style: none;\r\n    margin: 0;\r\n    padding: 0;\r\n  }\r\n\r\n#menu ul\r\n  {\r\n    padding: 3px 0 3px;\r\n    text-align: center;\r\n  }\r\n\r\n#menu ul li\r\n  {\r\n    display: inline;\r\n    margin-right: .3em;\r\n  }\r\n\r\n#menu ul li.current a\r\n  {\r\n    display: inline;\r\n    color: #fff;\r\n    background: #ff7b08;\r\n    margin-right: .3em;\r\n  }\r\n\r\n#menu ul li a\r\n  {\r\n    color: #000;\r\n    padding: 5px 0;\r\n    text-decoration: none;\r\n  }\r\n\r\n#menu ul li a span\r\n  {\r\n    padding: 5px .5em;\r\n  }\r\n\r\n#menu ul li a:hover span\r\n  {\r\n    color: #fff;\r\n    text-decoration: none;\r\n  }\r\n\r\n#menu ul li a:hover\r\n  {\r\n    color: #69C;\r\n    background: #ff7b08;\r\n    text-decoration: none;\r\n  }\r\n\r\n/*\\*//*/\r\n#menu ul li a\r\n  {\r\n    display: inline-block;\r\n    white-space: nowrap;\r\n    width: 1px;\r\n  }\r\n\r\n#menu ul\r\n  {\r\n    padding-bottom: 0;\r\n    margin-bottom: -1px;\r\n  }\r\n/**/\r\n\r\n/*\\*/\r\n* html #menu ul li a\r\n  {\r\n    padding: 0;\r\n  }\r\n/**/\r\n    \r\n/*- /Menu */\r\n\r\n/*- Boxes */\r\n\r\n/*- Box */\r\n.box\r\n  {\r\n    margin: 0 .5em .5em .5em;\r\n    padding: 0;\r\n  }\r\n\r\n/*- Box Header */\r\n.box h5\r\n  {\r\n    color: #ff7b08;\r\n    font-weight: bold;\r\n    font-size: 12pt;\r\n    margin: 0;\r\n    padding: 7px 0 7px 10px;\r\n    background-color: #f4f4f4;\r\n    background-image: url(../../img/bg.png);\r\n    background-position: 0 -135px;\r\n    background-repeat: repeat-x;\r\n    border-top: 1px solid #c0c1c2;\r\n    border-left: 1px solid #c0c1c2;\r\n    border-right: 1px solid #c0c1c2;\r\n    border-bottom: 1px solid #c0c1c2;\r\n    border-top-left-radius: 8px;\r\n    border-top-right-radius: 8px;\r\n    vertical-align: middle;\r\n  }\r\n\r\n.box h5 a\r\n  {\r\n    color: #ff7b08;\r\n    font-weight: bold;\r\n    font-size: 12pt;\r\n    text-decoration: none;\r\n  }\r\n/*- /Box Header */\r\n\r\n/*- Box Content */\r\n.boxContent\r\n  {\r\n    margin: 0;\r\n    padding: .5em;\r\n    background-color: #fff;\r\n    background-image: url(../../img/bg.png);\r\n    background-position: 0 -602px;\r\n    background-repeat: repeat-x;\r\n    border-top: 0px;\r\n    border-left: 1px solid #c0c1c2;\r\n    border-right: 1px solid #c0c1c2;\r\n    border-bottom: 1px solid #c0c1c2;\r\n    border-bottom-left-radius: 8px;\r\n    border-bottom-right-radius: 8px;\r\n  }\r\n\r\n.boxContent.center\r\n  {\r\n    margin: 0 auto;\r\n    text-align: center;\r\n    padding: .5em;\r\n    background-color: #fff;\r\n    background-image: url(../../img/bg.png);\r\n    background-position: 0 -602px;\r\n    background-repeat: repeat-x;\r\n    border-top: 0px;\r\n    border-left: 1px solid #c0c1c2;\r\n    border-right: 1px solid #c0c1c2;\r\n    border-bottom: 1px solid #c0c1c2;\r\n    border-bottom-left-radius: 8px;\r\n    border-bottom-right-radius: 8px;\r\n  }\r\n  \r\n#boxContent p\r\n  {\r\n    margin: 0;\r\n    padding: 0;\r\n  }\r\n\r\n/*- /Box Content */\r\n\r\n/*- /Box */\r\n\r\n/*- /Boxes */\r\n\r\n/* Buttons */\r\n\r\n.btn\r\n	{\r\n		margin: 2px;\r\n	}\r\n\r\n/* /Buttons */\r\n\r\n/* Forms */\r\n\r\nform\r\n  {\r\n    padding: 0;\r\n    margin: 0;\r\n  }\r\n\r\nfieldset\r\n  {\r\n    border: 0px;\r\n  }\r\n\r\nlegend\r\n  {\r\n    font-size: 12pt;\r\n    font-weight: bold;\r\n    color: #ff9c0f;\r\n    margin-bottom: .5em;\r\n    padding: 0;\r\n  }\r\n\r\nlabel\r\n  {\r\n    color: #545452;\r\n    padding: 0 10px 0 10px;\r\n    margin-bottom: 0;\r\n  }\r\n\r\n  \r\ninput\r\n  {\r\n    border: 1px solid;\r\n    border-color: #666 #ccc #ccc #666;\r\n    padding: .2em;\r\n    margin: .2em;\r\n    border-top-left-radius: 4px;\r\n    border-top-right-radius: 4px;\r\n    border-bottom-left-radius: 4px;\r\n    border-bottom-right-radius: 4px;\r\n  }\r\n\r\n\r\nselect\r\n  {\r\n    margin-left: .5em;\r\n    border-top-left-radius: 4px;\r\n    border-top-right-radius: 4px;\r\n    border-bottom-left-radius: 4px;\r\n    border-bottom-right-radius: 4px;\r\n  }\r\n\r\ntextarea\r\n  {\r\n    overflow: auto;\r\n    width: 80%;\r\n    height: 25em;\r\n    border: 1px solid;\r\n    border-color: #666 #ccc #ccc #666;\r\n    padding: .3em;\r\n    border-top-left-radius: 4px;\r\n    border-top-right-radius: 4px;\r\n    border-bottom-left-radius: 4px;\r\n    border-bottom-right-radius: 4px;\r\n  }\r\n\r\ntextarea:focus, input:focus, .sffocus, .sffocus\r\n  {\r\n    background-color: #ffc;\r\n  }\r\n\r\nlabel.error \r\n  {\r\n    margin-left: 10px;\r\n    width: auto;\r\n    display: inline;\r\n    color: red;\r\n    font-weight: normal;\r\n    background: transparent;\r\n}\r\n\r\n.error\r\n   {\r\n    background: #fcc;\r\n   }\r\n     \r\n/* /Forms */\r\n\r\n\r\n/* Pagination */\r\n.paginator ul\r\n  {\r\n    list-style:none;\r\n  }\r\n\r\n.paginator ul li\r\n  {\r\n    display:inline;\r\n  }\r\n\r\n.paginator ul li a.current\r\n  {\r\n    font-weight:bold;\r\n  }\r\n/* /Pagination */\r\n.back {  float: right;\r\n}\r\n\r\ninput.button {\r\n  margin: 0 5px;\r\n  cursor: pointer;\r\n}\r\n\r\n.total-value {\r\n  float: right;\r\n}\r\n\r\n#login-form .label {\r\n  float: left;\r\n  width: 200px;\r\n}', 0, '2009-07-14 18:44:00', '2013-04-17 16:06:08');

DROP TABLE IF EXISTS stylesheet_media_types;
CREATE TABLE `stylesheet_media_types` (
  `id` int(10) NOT NULL auto_increment,
  `name` varchar(50) collate utf8_unicode_ci NOT NULL,
  `type` varchar(50) collate utf8_unicode_ci NOT NULL,
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
  `id` int(10) NOT NULL auto_increment,
  `default` tinyint(4) NOT NULL,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `taxes` (`id`, `default`, `name`, `created`, `modified`) VALUES 
(1, 1, 'Non-Taxable', '2009-08-03 20:39:02', '2009-08-06 10:03:37'),
(2, 0, 'United States - VA Sales Tax', '2009-08-05 20:18:46', '2009-08-06 10:03:52');

DROP TABLE IF EXISTS tax_country_zone_rates;
CREATE TABLE `tax_country_zone_rates` (
  `id` int(10) NOT NULL auto_increment,
  `tax_id` int(10) NOT NULL,
  `country_zone_id` int(10) NOT NULL,
  `rate` double NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `tax_country_zone_rates` (`id`, `tax_id`, `country_zone_id`, `rate`) VALUES 
(1, 2, 51, 5);

DROP TABLE IF EXISTS templates;
CREATE TABLE `templates` (
  `id` int(10) NOT NULL auto_increment,
  `parent_id` int(10) NOT NULL,
  `template_type_id` int(10) NOT NULL,
  `default` tinyint(4) NOT NULL default '0',
  `name` varchar(50) collate utf8_unicode_ci NOT NULL,
  `template` text collate utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `templates` (`id`, `parent_id`, `template_type_id`, `default`, `name`, `template`, `created`, `modified`) VALUES
(1, 0, 0, 1, 'Default Theme', '', '2009-07-26 16:02:41', '2009-09-12 17:46:19'),
(2, 1, 1, 0, 'Main Layout', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />\r\n<meta name="viewport" content="width=device-width, initial-scale=1.0">\r\n{stylesheet}\r\n<link rel="stylesheet" type="text/css" href="{base_path}/css/normalize.css" />\r\n<link rel="stylesheet" type="text/css" href="{base_path}/css/bootstrap/bootstrap.css" />\r\n<link rel="stylesheet" type="text/css" href="{base_path}/css/bootstrap/bootstrap-responsive.css" />\r\n<link rel="stylesheet" type="text/css" href="{base_path}/css/bootstrap/cus-icons.css" />\r\n<script type="text/javascript" src="{base_path}/js/jquery/jquery.min.js"></script>\r\n<script type="text/javascript" src="{base_path}/js/bootstrap/bootstrap.min.js"></script>\r\n{meta_description}\r\n{meta_keywords}\r\n{metadata}\r\n{headdata}\r\n<title>\r\n{site_name} - {page_name}\r\n</title>\r\n</head>\r\n<body>\r\n{google_analytics}\r\n{yandex_metrika}\r\n<!-- Container -->\r\n<div id="container">\r\n\r\n	<!-- Header -->\r\n	<div id="header">\r\n		<div class="header-left">\r\n			<a href="{base_path}/"><img src="{base_path}/img/logo.png" alt="{site_name}" /><br /></a>\r\n		</div>\r\n		<div class="header-right">\r\n		</div>\r\n		<div class="clear"></div>\r\n	</div>\r\n	<!-- /Header -->\r\n\r\n	<!--Menu -->\r\n	<div id="menu">\r\n		<ul>\r\n			{content_listing template=''information-links'' parent=''44''}\r\n			{admin_area_link}\r\n		</ul>\r\n	</div>\r\n	<!--/Menu -->\r\n\r\n	<!-- Navigation -->\r\n	<div id="navigation">\r\n		&nbsp;\r\n	</div>\r\n	<!-- /Navigation -->\r\n\r\n	<!-- Main Content -->\r\n	<div id="wrapper">\r\n		<div id="content">\r\n          {flash_message}\r\n			<div class="page">\r\n				<h2>{page_name}</h2>\r\n			<div class="pageContent">\r\n				{admin_edit_link}\r\n				{content}\r\n			</div>\r\n			</div>\r\n		</div>\r\n	</div>\r\n	<!-- /Main Content -->\r\n\r\n	<!-- Left Column -->\r\n	<div id="left">\r\n		{content_listing template=''search-box''}\r\n		{content_listing template=''vertical-menu'' parent=''0'' type=''category''}\r\n		{content_listing template=''news-box'' parent=''69'' type=''news''}\r\n		{content_listing template=''articles-box'' parent=''70'' type=''article''}\r\n	</div>\r\n	<!-- /Left Column -->\r\n\r\n	<!-- Right Column -->\r\n	<div id="right">\r\n		{login_box template=''login-box''}\r\n		{shopping_cart template=''cart-content-box''}\r\n		{language_box template=''language-box''}\r\n		{currency_box template=''currency-box''}\r\n	</div>\r\n	<!-- /Right Column -->\r\n\r\n	<!-- Footer -->\r\n	<div id="footer">\r\n		<p>{global_content alias=''footer''}</p>\r\n	</div>\r\n	<!-- /Footer -->\r\n\r\n</div>\r\n<!-- /Container -->\r\n\r\n</body>\r\n</html>', '2009-07-26 16:02:41', '2013-04-17 16:03:06'),
(3, 1, 2, 0, 'Content Page', '{description}\r\n', '2009-07-26 16:02:41', '2009-07-29 21:37:54'),
(4, 1, 3, 0, 'Product Info', '<link rel="stylesheet" type="text/css" href="{base_path}/css/lightbox/jquery.lightbox.css" media="screen" />\r\n<script type="text/javascript" src="{base_path}/js/jquery/plugins/lightbox/jquery.lightbox.js"></script>\r\n\r\n<script type="text/javascript">\r\n  $(document).ready(function() {\r\n    $("a.zoom").lightBox({\r\n    fixedNavigation:true,\r\n      imageLoading: "{base_path}/img/jquery/plugins/lightbox/lightbox-ico-loading.gif",\r\n      imageBtnClose: "{base_path}/img/jquery/plugins/lightbox/lightbox-btn-close.gif",\r\n      imageBtnPrev: "{base_path}/img/jquery/plugins/lightbox/lightbox-btn-prev.gif",\r\n      imageBtnNext: "{base_path}/img/jquery/plugins/lightbox/lightbox-btn-next.gif",      \r\n    });\r\n  });\r\n\r\n  function onProductFormSubmit() {\r\n    var str = $("#product-form").serialize();\r\n\r\n    $.post("/cart/purchase_product", str, function(data) {\r\n      $("#shopping-cart-box").html(data);\r\n    });\r\n\r\n  }\r\n</script>\r\n\r\n\r\n<div id="product_details_left">\r\n  {description}\r\n</div>\r\n<div id="product_details_right">\r\n  <div class="product_images">{content_images}</div>\r\n  <div class="pricing">\r\n{product_prices}\r\n    <div style="clear: both"></div>\r\n    <div style="clear: both"></div>\r\n    {if ''1'' == $ajax_enable}\r\n	    {product_form_ajax}\r\n	    <div class="product_price">{product_quantity} {purchase_button id=$content_id}</div>\r\n	    {/product_form_ajax}\r\n    {else}\r\n	    {product_form}\r\n	    <div class="product_price">{product_quantity} {purchase_button id=$content_id}</div>\r\n	    {/product_form}\r\n    {/if}\r\n    {xsell}\r\n    {module alias=''reviews'' action=''link''}\r\n  </div>\r\n</div>\r\n<div style="clear:both;"></div>', '2009-07-26 16:02:41', '2013-04-17 16:07:42'),
(5, 1, 4, 0, 'Category Info', '{description}\r\n\r\n{if $sub_count->value.categories > 0}\r\n    <h3>{lang}Sub Categories{/lang}</h3>\r\n    <div class="content_listing">\r\n        {content_listing template=''subcategory-listing'' parent={$content_id} type=''category''}\r\n    </div>\r\n{/if}\r\n\r\n{if $sub_count->value.products + $sub_count->value.downloadables > 0}\r\n    <h3>{lang}Products in this Category{/lang}</h3>\r\n    <div class="content_listing">\r\n        {content_listing template=''product-listing'' parent={$content_id} page={$page} type=''product,downloadable''}\r\n    </div>\r\n{/if}', '2009-07-26 16:02:41', '2012-11-01 11:41:07'),
(6, 1, 5, 0, 'News Page', '{description}\r\n', '2009-07-26 16:02:41', '2009-07-29 21:37:54'),
(7, 1, 6, 0, 'Article Page', '{description}\r\n', '2009-07-26 16:02:41', '2009-07-29 21:37:54'),
(8, 1, 7, 0, 'Downloadable Product Info', '<link rel="stylesheet" type="text/css" href="{base_path}/css/lightbox/jquery.lightbox.css" media="screen" />\r\n<script type="text/javascript" src="{base_path}/js/jquery/plugins/lightbox/jquery.lightbox.js"></script>\r\n\r\n<script type="text/javascript">\r\n  $(document).ready(function() {\r\n    $("a.zoom").lightBox({\r\n    fixedNavigation:true,\r\n      imageLoading: "{base_path}/img/jquery/plugins/lightbox/lightbox-ico-loading.gif",\r\n      imageBtnClose: "{base_path}/img/jquery/plugins/lightbox/lightbox-btn-close.gif",\r\n      imageBtnPrev: "{base_path}/img/jquery/plugins/lightbox/lightbox-btn-prev.gif",\r\n      imageBtnNext: "{base_path}/img/jquery/plugins/lightbox/lightbox-btn-next.gif",      \r\n    });\r\n  });\r\n\r\n  function onProductFormSubmit() {\r\n    var str = $("#product-form").serialize();\r\n\r\n    $.post("/cart/purchase_product", str, function(data) {\r\n      $("#shopping-cart-box").html(data);\r\n    });\r\n\r\n  }\r\n</script>\r\n\r\n\r\n<div id="product_details_left">\r\n  {description}\r\n</div>\r\n<div id="product_details_right">\r\n  <div class="product_images">{content_images}</div>\r\n  <div class="pricing">\r\n{downloadable_prices}\r\n    <div style="clear: both"></div>\r\n    <div style="clear: both"></div>\r\n    {if ''1'' == $ajax_enable}\r\n        {product_form_ajax}\r\n        <div class="product_price">{product_quantity} {purchase_button id=$content_id}</div>\r\n        {/product_form_ajax}\r\n    {else}\r\n        {product_form}\r\n        <div class="product_price">{product_quantity} {purchase_button id=$content_id}</div>\r\n        {/product_form}\r\n    {/if}\r\n    {xsell}\r\n    {module alias=''reviews'' action=''link''}\r\n  </div>\r\n</div>\r\n<div style="clear:both;"></div>', '2012-11-04 00:00:00', '2013-04-17 16:07:25');



DROP TABLE IF EXISTS templates_stylesheets;
CREATE TABLE `templates_stylesheets` (
  `template_id` int(10) unsigned NOT NULL default '0',
  `stylesheet_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`template_id`,`stylesheet_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `templates_stylesheets` (`template_id`, `stylesheet_id`) VALUES 
(1, 1);

DROP TABLE IF EXISTS template_types;
CREATE TABLE `template_types` (
  `id` int(10) NOT NULL auto_increment,
  `name` varchar(50) collate utf8_unicode_ci NOT NULL,
  `default_template` text collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `template_types` (`id`, `name`, `default_template`) VALUES 
(1, 'Main Layout', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />\r\n<meta name="viewport" content="width=device-width, initial-scale=1.0">\r\n{stylesheet}\r\n<link rel="stylesheet" type="text/css" href="{base_path}/css/normalize.css" />\r\n<link rel="stylesheet" type="text/css" href="{base_path}/css/bootstrap/bootstrap.css" />\r\n<link rel="stylesheet" type="text/css" href="{base_path}/css/bootstrap/bootstrap-responsive.css" />\r\n<link rel="stylesheet" type="text/css" href="{base_path}/css/bootstrap/cus-icons.css" />\r\n<script type="text/javascript" src="{base_path}/js/jquery/jquery.min.js"></script>\r\n<script type="text/javascript" src="{base_path}/js/bootstrap/bootstrap.min.js"></script>\r\n{meta_description}\r\n{meta_keywords}\r\n{metadata}\r\n{headdata}\r\n<title>\r\n{site_name} - {page_name}\r\n</title>\r\n</head>\r\n<body>\r\n{google_analytics}\r\n{yandex_metrika}\r\n<!-- Container -->\r\n<div id="container">\r\n\r\n	<!-- Header -->\r\n	<div id="header">\r\n		<div class="header-left">\r\n			<a href="{base_path}/"><img src="{base_path}/img/logo.png" alt="{site_name}" /><br /></a>\r\n		</div>\r\n		<div class="header-right">\r\n		</div>\r\n		<div class="clear"></div>\r\n	</div>\r\n	<!-- /Header -->\r\n\r\n	<!--Menu -->\r\n	<div id="menu">\r\n		<ul>\r\n			{content_listing template=''information-links'' parent=''44''}\r\n			{admin_area_link}\r\n		</ul>\r\n	</div>\r\n	<!--/Menu -->\r\n\r\n	<!-- Navigation -->\r\n	<div id="navigation">\r\n		&nbsp;\r\n	</div>\r\n	<!-- /Navigation -->\r\n\r\n	<!-- Main Content -->\r\n	<div id="wrapper">\r\n		<div id="content">\r\n          {flash_message}			<div class="page">\r\n				<h2>{page_name}</h2>\r\n			<div class="pageContent">\r\n				{admin_edit_link}\r\n				{content}\r\n			</div>\r\n			</div>\r\n		</div>\r\n	</div>\r\n	<!-- /Main Content -->\r\n\r\n	<!-- Left Column -->\r\n	<div id="left">\r\n		{content_listing template=''search-box''}\r\n		{content_listing template=''vertical-menu'' parent=''0'' type=''category''}\r\n		{content_listing template=''news-box'' parent=''69'' type=''news''}\r\n		{content_listing template=''articles-box'' parent=''70'' type=''article''}\r\n	</div>\r\n	<!-- /Left Column -->\r\n\r\n	<!-- Right Column -->\r\n	<div id="right">\r\n		{login_box template=''login-box''}\r\n		{shopping_cart template=''cart-content-box''}\r\n		{language_box template=''language-box''}\r\n		{currency_box template=''currency-box''}\r\n	</div>\r\n	<!-- /Right Column -->\r\n\r\n	<!-- Footer -->\r\n	<div id="footer">\r\n		<p>{global_content alias=''footer''}</p>\r\n	</div>\r\n	<!-- /Footer -->\r\n\r\n</div>\r\n<!-- /Container -->\r\n\r\n</body>\r\n</html>'),
(2, 'Content Page', '{description}\r\n'),
(3, 'Product Info', '<link rel="stylesheet" type="text/css" href="{base_path}/css/lightbox/jquery.lightbox.css" media="screen" />\r\n<script type="text/javascript" src="{base_path}/js/jquery/plugins/lightbox/jquery.lightbox.js"></script>\r\n\r\n<script type="text/javascript">\r\n  $(document).ready(function() {\r\n    $("a.zoom").lightBox({\r\n    fixedNavigation:true,\r\n      imageLoading: "{base_path}/img/jquery/plugins/lightbox/lightbox-ico-loading.gif",\r\n      imageBtnClose: "{base_path}/img/jquery/plugins/lightbox/lightbox-btn-close.gif",\r\n      imageBtnPrev: "{base_path}/img/jquery/plugins/lightbox/lightbox-btn-prev.gif",\r\n      imageBtnNext: "{base_path}/img/jquery/plugins/lightbox/lightbox-btn-next.gif",      \r\n    });\r\n  });\r\n\r\n  function onProductFormSubmit() {\r\n    var str = $("#product-form").serialize();\r\n\r\n    $.post("/cart/purchase_product", str, function(data) {\r\n      $("#shopping-cart-box").html(data);\r\n    });\r\n\r\n  }\r\n</script>\r\n\r\n\r\n<div id="product_details_left">\r\n  {description}\r\n</div>\r\n<div id="product_details_right">\r\n  <div class="product_images">{content_images}</div>\r\n  <div class="pricing">\r\n{product_prices}\r\n    <div style="clear: both"></div>\r\n    <div style="clear: both"></div>\r\n    {if ''1'' == $ajax_enable}\r\n	    {product_form_ajax}\r\n	    <div class="product_price">{product_quantity} {purchase_button id=$content_id}</div>\r\n	    {/product_form_ajax}\r\n    {else}\r\n	    {product_form}\r\n	    <div class="product_price">{product_quantity} {purchase_button id=$content_id}</div>\r\n	    {/product_form}\r\n    {/if}\r\n    {xsell}\r\n    {module alias=''reviews'' action=''link''}\r\n  </div>\r\n</div>\r\n<div style="clear:both;"></div>'),
(4, 'Category Info', '{description}\r\n\r\n{if $sub_count->value.categories > 0}\r\n    <h3>{lang}Sub Categories{/lang}</h3>\r\n    <div class="content_listing">\r\n        {content_listing template=''subcategory-listing'' parent={$content_id} type=''category''}\r\n    </div>\r\n{/if}\r\n\r\n{if $sub_count->value.products + $sub_count->value.downloadables > 0}\r\n    <h3>{lang}Products in this Category{/lang}</h3>\r\n    <div class="content_listing">\r\n        {content_listing template=''product-listing'' parent={$content_id} page={$page} type=''product,downloadable''}\r\n    </div>\r\n{/if}'),
(5, 'News Page', '{description}'),
(6, 'Article Page', '{description}'),
(7, 'Downloadable Product Info', '<link rel="stylesheet" type="text/css" href="{base_path}/css/lightbox/jquery.lightbox.css" media="screen" />\r\n<script type="text/javascript" src="{base_path}/js/jquery/plugins/lightbox/jquery.lightbox.js"></script>\r\n\r\n<script type="text/javascript">\r\n  $(document).ready(function() {\r\n    $("a.zoom").lightBox({\r\n    fixedNavigation:true,\r\n      imageLoading: "{base_path}/img/jquery/plugins/lightbox/lightbox-ico-loading.gif",\r\n      imageBtnClose: "{base_path}/img/jquery/plugins/lightbox/lightbox-btn-close.gif",\r\n      imageBtnPrev: "{base_path}/img/jquery/plugins/lightbox/lightbox-btn-prev.gif",\r\n      imageBtnNext: "{base_path}/img/jquery/plugins/lightbox/lightbox-btn-next.gif",      \r\n    });\r\n  });\r\n\r\n  function onProductFormSubmit() {\r\n    var str = $("#product-form").serialize();\r\n\r\n    $.post("/cart/purchase_product", str, function(data) {\r\n      $("#shopping-cart-box").html(data);\r\n    });\r\n\r\n  }\r\n</script>\r\n\r\n\r\n<div id="product_details_left">\r\n  {description}\r\n</div>\r\n<div id="product_details_right">\r\n  <div class="product_images">{content_images}</div>\r\n  <div class="pricing">\r\n{downloadable_prices}\r\n    <div style="clear: both"></div>\r\n    <div style="clear: both"></div>\r\n    {if ''1'' == $ajax_enable}\r\n        {product_form_ajax}\r\n        <div class="product_price">{product_quantity} {purchase_button id=$content_id}</div>\r\n        {/product_form_ajax}\r\n    {else}\r\n        {product_form}\r\n        <div class="product_price">{product_quantity} {purchase_button id=$content_id}</div>\r\n        {/product_form}\r\n    {/if}\r\n    {xsell}\r\n    {module alias=''reviews'' action=''link''}\r\n  </div>\r\n</div>\r\n<div style="clear:both;"></div>');

DROP TABLE IF EXISTS users;
CREATE TABLE `users` (
  `id` int(10) NOT NULL auto_increment,
  `username` varchar(50) collate utf8_unicode_ci NOT NULL,
  `email` varchar(50) collate utf8_unicode_ci NOT NULL,
  `password` varchar(255) collate utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created`, `modified`) VALUES 
(1, 'admin', 'vam@test.com', '4e825adacc62644d112a2f4e41d395bfb31f55a9', '0000-00-00 00:00:00', '2009-07-23 15:34:53');

DROP TABLE IF EXISTS user_prefs;
CREATE TABLE `user_prefs` (
  `id` int(10) NOT NULL auto_increment,
  `user_id` int(10) NOT NULL,
  `name` varchar(50) collate utf8_unicode_ci NOT NULL,
  `value` text collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `user_prefs` (`id`, `user_id`, `name`, `value`) VALUES 
(1, 1, 'content_collapse', ''),
(2, 1, 'template_collpase', ''),
(3, 1, 'language', 'en');

DROP TABLE IF EXISTS user_tags;
CREATE TABLE `user_tags` (
  `id` int(10) NOT NULL auto_increment,
  `name` varchar(50) collate utf8_unicode_ci NOT NULL,
  `alias` varchar(50) collate utf8_unicode_ci NOT NULL,
  `content` text collate utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `user_tags` (`id`, `name`, `alias`, `content`, `created`, `modified`) VALUES 
(1, 'User Agent', 'user-agent', 'echo $_SERVER[''HTTP_USER_AGENT''];', '2009-07-25 09:50:24', '2009-07-27 18:08:55');

DROP TABLE IF EXISTS licenses;
CREATE TABLE IF NOT EXISTS `licenses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `licenseKey` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `licenses` (`id`, `licenseKey`) VALUES 
(1, 'NTc5MmEyMjdlMG5qZGxhf3BbXAMAeGdWWLa7jYXx');

DROP TABLE IF EXISTS updates;
CREATE TABLE IF NOT EXISTS `updates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS customers;
CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `lastname` varchar(32) NOT NULL,
  `email` varchar(96) NOT NULL,
  `password` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS address_books;
CREATE TABLE `address_books` (
  `id` int(10) NOT NULL auto_increment,
  `customer_id` int(10) NOT NULL,
  `ship_name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `ship_line_1` varchar(255) collate utf8_unicode_ci NOT NULL,
  `ship_line_2` varchar(255) collate utf8_unicode_ci NOT NULL,
  `ship_city` varchar(255) collate utf8_unicode_ci NOT NULL,
  `ship_state` varchar(255) collate utf8_unicode_ci NOT NULL,
  `ship_country` varchar(255) collate utf8_unicode_ci NOT NULL,
  `ship_zip` varchar(20) collate utf8_unicode_ci NOT NULL,
  `phone` varchar(15) collate utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS contents_contents;
CREATE TABLE IF NOT EXISTS `contents_contents` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `product_id` int(10) NOT NULL,
  `related_id` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
