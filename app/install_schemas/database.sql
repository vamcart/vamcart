SET SQL_MODE=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));
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
(2, 'email', 'Email Settings','','cus-email','1','3'),
(3, 'checkout', 'Checkout Settings','','cus-cart','1','3');

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
(1,'1','SITE_NAME', 'VamShop','text', '', 'Site Name','','1'),
(2,'1','TELEPHONE', '+1-800-123-45-67','text', '', 'Telephone','','2'),
(3,'1','FACEBOOK', 'http://facebook.com/your-account','text', '', 'Facebook','','3'),
(4,'1','TWITTER', 'http://twitter.com/your-account','text', '', 'Twitter','','4'),
(5,'1','GOOGLE', 'http://plus.google.com/your-account','text', '', 'Google+','','5'),
(6,'1','METADATA', '<meta name="generator" content="Bluefish 2.2.7" />','textarea', '', 'Metadata','','6'),
(7,'1','URL_EXTENSION', '.html','text', '', 'URL Extension','','7'),
(8,'1','GD_LIBRARY', '1','select', '0,1', 'GD Library Enabled','','8'),
(9,'1','THUMBNAIL_SIZE', '250','text', '', 'Image Thumbnail Size','','9'),
(10,'1','GOOGLE_ANALYTICS', '','text', '', 'Google Analytics ID','','10'),
(11,'1','YANDEX_METRIKA', '','text', '', 'Yandex.Metrika ID','','11'),
(12,'1','PRODUCTS_PER_PAGE', '20','text', '', 'Products Per Page','','12'),
(13,'2','SEND_EXTRA_EMAIL', 'vam@test.com','text', '', 'Send extra order emails to','','13'),
(14,'2','NEW_ORDER_FROM_EMAIL', 'vam@test.com','text', '', 'New Order: From','','14'),
(15,'2','NEW_ORDER_FROM_NAME', 'VamShop','text', '', 'New Order: From Name','','15'),
(16,'2','NEW_ORDER_STATUS_FROM_EMAIL', 'vam@test.com','text', '', 'New Order Status: From','','16'),
(17,'2','NEW_ORDER_STATUS_FROM_NAME', 'VamShop','text', '', 'New Order Status: From Name','','17'),
(18,'2','SEND_CONTACT_US_EMAIL', 'vam@test.com','text', '', 'Send contact us emails to','','18'),
(19,'1','AJAX_ENABLE', '1', 'select', '0,1', 'Ajax Enable', '', '19'),
(20,'1','DADATA_API_KEY', 'd54b2e521766960e89c4c5f871483b33eae9a364','text', '', 'DaData API Key','','20'),
(21,'1','PHONE_MASK', '(999) 999-99-99','text', '', 'Phone Input Mask','','21'),
(22,'1','SMS_EMAIL', '','text', '', 'SMS Email Gateway','','22'),
(23,'3','CHECKOUT_DISPLAY_ADDRESS_FIELD', '1','select', '0,1', 'Display Address Line 1 Field','','23'),
(24,'3','CHECKOUT_DISPLAY_ADDRESS_1_FIELD', '1','select', '0,1', 'Display Address Line 2 Field','','24'),
(25,'3','CHECKOUT_DISPLAY_CITY_FIELD', '1','select', '0,1', 'Display City Field','','25'),
(26,'3','CHECKOUT_DISPLAY_POSTCODE_FIELD', '1','select', '0,1', 'Display Zipcode Field','','26'),
(27,'3','CHECKOUT_DISPLAY_COUNTRY_FIELD', '1','select', '0,1', 'Display Country Field','','27'),
(28,'3','CHECKOUT_DISPLAY_STATE_FIELD', '1','select', '0,1', 'Display State Field','','28'),
(29,'3','CHECKOUT_DISPLAY_SHIPPING_INFO_BLOCK', '1','select', '0,1', 'Display Shipping Info Block','','29'),
(30,'3','CHECKOUT_DISPLAY_EMAIL_FIELD', '1','select', '0,1', 'Display Email Field','','30'),
(31,'3','CHECKOUT_DISPLAY_COMMENTS_FIELD', '1','select', '0,1', 'Display Order Comments Field','','31'),
(32,'3','CHECKOUT_DISPLAY_SHIPPING_METHODS_BLOCK', '1','select', '0,1', 'Display Shipping Methods Block','','32'),
(33,'3','CHECKOUT_DISPLAY_PAYMENT_METHODS_BLOCK', '1','select', '0,1', 'Display Payment Methods Block','','33'),
(34,'1','GOOGLE_OAUTH_CLIENT_ID', '','text', '', 'Google OAuth Client ID','','34'),
(35,'1','GOOGLE_OAUTH_SECRET_KEY', '','text', '', 'Google OAuth Secret Key','','35');

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
  `is_group` tinyint(4) DEFAULT NULL,
  `id_group` int(10) DEFAULT NULL,
  `created` datetime,
  `modified` datetime,
  PRIMARY KEY  (`id`),
  INDEX active (active),
  INDEX content_id (parent_id,alias,active),
  INDEX yml_export (yml_export)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `contents` VALUES 
(35,0,1,0,3,1,1,'home-page','',1,0,0,107,NULL,NULL,'2009-07-28 21:11:18','2013-10-19 23:21:28'),
(36,0,2,0,1,1,0,'tablets','',1,1,1,14,NULL,NULL,'2009-07-28 21:11:49','2013-10-19 21:02:02'),
(38,36,1,0,2,1,0,'samsung-galaxy-tab-3','',1,1,1,18,NULL,NULL,'2009-07-29 18:54:37','2013-10-19 22:35:47'),
(39,0,3,0,1,1,0,'smartphones','',1,1,1,9,NULL,NULL,'2009-07-29 22:02:10','2013-10-19 21:02:11'),
(43,0,1,0,1,1,0,'notebooks','',1,1,1,12,NULL,NULL,'2013-10-19 19:26:12','2013-10-19 21:01:54'),
(44,0,5,0,1,1,0,'information','',1,0,0,0,NULL,NULL,'2009-07-30 15:34:48','2009-07-30 15:35:02'),
(45,44,1,0,3,1,0,'shipping--returns','',1,1,0,0,NULL,NULL,'2009-07-30 15:36:30','2009-08-06 14:53:16'),
(46,44,2,0,3,1,0,'privacy-policy','',1,1,0,0,NULL,NULL,'2009-07-30 15:36:54','2009-07-30 15:37:09'),
(47,44,3,0,3,1,0,'conditions-of-use','',1,1,0,0,NULL,NULL,'2009-07-30 15:37:33','2009-07-30 15:37:33'),
(48,44,4,0,3,1,0,'contact-us','',1,1,0,0,NULL,NULL,'2009-07-30 15:38:03','2009-07-30 15:38:03'),
(49,-1,5,0,3,1,0,'cart-contents','',1,1,0,0,NULL,NULL,'2009-07-30 20:40:14','2009-08-09 16:23:47'),
(50,-1,6,0,3,1,0,'checkout','',1,1,0,0,NULL,NULL,'2009-07-30 20:52:36','2009-08-01 16:54:56'),
(51,-1,5,0,3,1,0,'confirmation','',1,1,0,0,NULL,NULL,'2009-08-07 11:16:28','2009-09-01 16:22:10'),
(53,-1,5,0,3,1,0,'success','',1,1,0,0,NULL,NULL,'2009-08-07 11:58:21','2009-08-15 16:00:40'),
(58,-1,0,0,3,1,0,'read-reviews','',1,0,0,0,NULL,NULL,'2009-08-20 09:37:04','2009-08-20 09:37:04'),
(59,-1,0,0,3,1,0,'create-review','',1,0,0,0,NULL,NULL,'2009-08-20 09:37:04','2009-08-20 09:37:04'),
(68,-1,0,0,3,1,0,'coupon-details','',1,0,0,0,NULL,NULL,'2009-09-13 11:11:08','2009-09-13 11:11:08'),
(69,0,6,0,1,1,0,'news','',1,0,0,0,NULL,NULL,'2009-11-10 20:18:22','2009-11-10 20:18:22'),
(70,0,7,0,1,1,0,'articles','',1,0,0,0,NULL,NULL,'2009-11-10 20:18:45','2009-11-10 20:18:45'),
(71,69,1,0,5,1,0,'sample-news','',1,1,0,0,NULL,NULL,'2009-11-10 20:20:08','2009-11-10 20:20:08'),
(72,70,1,0,6,1,0,'sample-article','',1,1,0,0,NULL,NULL,'2009-11-10 20:20:51','2009-11-10 20:20:51'),
(73,-1,6,0,3,1,0,'search-result','',1,0,0,0,NULL,NULL,'2009-11-10 20:20:51','2009-11-10 20:20:51'),
(87,-1,7,0,3,1,0,'register','',1,0,0,107,NULL,NULL,'2012-08-19 00:00:00','2012-08-19 21:18:34'),
(88,-1,8,0,3,1,0,'register-success','',1,0,0,3,NULL,NULL,'2012-08-19 00:00:00','2012-08-19 21:19:37'),
(89,-1,7,0,3,1,0,'account','',1,0,0,106,NULL,NULL,'2012-08-19 00:00:00','2012-08-19 21:18:34'),
(90,-1,8,0,3,1,0,'account_edit','',1,0,0,3,NULL,NULL,'2012-08-19 00:00:00','2012-08-19 21:19:37'),
(91,-1,8,0,3,1,0,'my_orders','',1,0,0,3,NULL,NULL,'2012-08-19 00:00:00','2012-08-19 21:19:37'),
(92,-1,8,0,3,1,0,'address_book','',1,0,0,3,NULL,NULL,'2012-08-19 00:00:00','2012-08-19 21:19:37'),
(93,36,2,0,2,1,0,'samsung-galaxy-note-10-1','',1,1,1,7,NULL,NULL,'2013-10-19 22:29:17','2013-10-19 23:05:33'),
(94,36,3,0,2,1,0,'samsung-galaxy-note-8','',1,1,1,4,NULL,NULL,'2013-10-19 22:42:55','2013-10-19 22:48:15'),
(95,39,1,0,2,1,0,'samsung-galaxy-note-3','',1,1,1,3,NULL,NULL,'2013-10-19 22:58:43','2013-10-19 23:17:52'),
(96,39,2,0,2,1,0,'samsung-galaxy-s4','',1,1,1,2,NULL,NULL,'2013-10-19 22:59:55','2013-10-20 00:21:21'),
(97,39,3,0,2,1,0,'samsung-galaxy-ace-3','',1,1,1,2,NULL,NULL,'2013-10-19 23:00:57','2013-10-19 23:18:42'),
(98,43,1,0,2,1,0,'samsung-ativ-book-9','',1,1,1,3,NULL,NULL,'2013-10-19 23:32:11','2013-10-20 00:20:51'),
(99,43,2,0,2,1,0,'samsung-ativ-smart-pc','',1,1,1,1,NULL,NULL,'2013-10-19 23:34:33','2013-10-19 23:52:11'),
(100,43,3,0,2,1,0,'samsung-ativ-book-4','',1,1,1,2,NULL,NULL,'2013-10-19 23:35:52','2013-10-19 23:52:26'),
(101,0,4,0,1,1,0,'smart-watches','',1,1,1,0,NULL,NULL,'2014-07-11 19:18:53','2014-07-11 19:18:53'),
(102,101,1,0,2,1,0,'samsung-gear-2-wild-orange','',1,1,1,0,1,102,'2014-07-11 19:35:57','2014-07-11 20:09:00'),
(103,101,2,0,2,1,0,'samsung-gear-2-gold-brown','',1,1,1,0,NULL,102,'2014-07-11 19:38:33','2014-07-11 20:09:13'),
(104,101,3,0,2,1,0,'samsung-gear-2-charcoal-black','',1,1,1,0,NULL,102,'2014-07-11 19:39:53','2014-07-11 20:09:22'),
(105, -1, NULL, NULL, 3, 1, NULL, 'ask_a_product_question', NULL, 1, NULL, NULL, NULL, NULL, NULL, '2014-08-09 20:58:06', '2014-08-09 20:58:06'),
(106, -1, NULL, NULL, 3, 1, NULL, 'one_click_buy', NULL, 1, NULL, NULL, NULL, NULL, NULL, '2014-08-09 20:58:09', '2014-08-09 20:58:09'),
(107,0,8,0,1,1,0,'brands','',1,0,0,0,NULL,NULL,'2014-07-11 19:18:53','2014-07-11 19:18:53'),
(108,107,1,0,8,1,0,'samsung','',1,1,0,0,NULL,NULL,'2014-07-11 19:18:53','2014-07-11 19:18:53'),
(109,-1,7,0,3,1,0,'password_recovery','',1,0,0,106,NULL,NULL,'2014-08-19 00:00:00','2014-08-19 21:18:34'),
(110,44,5,0,3,1,0,'404','',1,0,0,0,NULL,NULL,'2009-07-30 15:36:54','2009-07-30 15:37:09');

DROP TABLE IF EXISTS content_categories;
CREATE TABLE `content_categories` (
  `id` int(10) auto_increment,
  `content_id` int(10),
  `google_product_category_id` int(10),
  `extra` varchar(1) collate utf8_unicode_ci,
  PRIMARY KEY  (`id`),
  INDEX content_id (content_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `content_categories` VALUES 
(8,36,0,'1'),
(9,39,0,'1'),
(12,51,0,'1'),
(13,43,0,'1'),
(14,101,0,'1'),
(15,107,0,'1')	;

DROP TABLE IF EXISTS content_descriptions;
CREATE TABLE `content_descriptions` (
  `id` int(10) auto_increment,
  `content_id` int(10),
  `language_id` int(10),
  `name` varchar(255) collate utf8_unicode_ci,
  `description` text collate utf8_unicode_ci,
  `short_description` text collate utf8_unicode_ci,
  `meta_title` varchar(255) collate utf8_unicode_ci,
  `meta_description` varchar(255) collate utf8_unicode_ci,
  `meta_keywords` varchar(255) collate utf8_unicode_ci,
  PRIMARY KEY  (`id`),
  INDEX content_id (content_id,language_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `content_descriptions` VALUES 
(179,44,1,'Information','Information about our site can be found by visiting the following links:','','Information','Information','Information'),
(180,44,2,'Информация','Информация о магазине доступна по следующим ссылкам:','','Информация','Информация','Информация'),
(185,46,1,'Payment methods','Enter your payment methods on this page.','','','',''),
(186,46,2,'Оплата','Укажите информацию о способах оплаты товара на данной странице.','','Payment methods','Payment methods','Payment methods'),
(187,47,1,'About Us','About us page.','','About Us','About Us','About Us'),
(188,47,2,'О магазине','Информация о магазине.','','О магазине','О магазине','О магазине'),
(189,48,1,'Contact Us','Enter your contact information on this page.\r\n{contact_us}','','Contact Us','Contact Us','Contact Us'),
(190,48,2,'Контакты','Контактная информация.\r\n{contact_us}','','Контакты','Контакты','Контакты'),
(241,50,1,'Checkout','{checkout}','','Checkout','Checkout','Checkout'),
(242,50,2,'Оформление','{checkout}','','Оформление','Оформление','Оформление'),
(245,45,1,'Shipping and Returns','Enter your Shipping & Return information on this page.','','Shipping and Returns','Shipping and Returns','Shipping and Returns'),
(246,45,2,'Доставка','Укажите информацию о способах доставки товара на данной странице.','','Доставка','Доставка','Доставка'),
(269,49,1,'Cart Contents','{shopping_cart}\r\n\r\n{content_listing template="featured-products" label_id="3" type="product" limit="9"}','','Cart Contents','Cart Contents','Cart Contents'),
(270,49,2,'Корзина','{shopping_cart}\r\n\r\n{content_listing template="featured-products" label_id="3" type="product" limit="9"}','','Корзина','Корзина','Корзина'),
(313,53,1,'Thank You','Thanks for shopping!\r\n\r\n{content_listing template="featured-products" label_id="3" type="product" limit="9"}\r\n\r\n{my_orders}','','Thank You','Thank You','Thank You'),
(314,53,2,'Спасибо','Спасибо за покупки!\r\n\r\n{content_listing template="featured-products" label_id="3" type="product" limit="9"}\r\n\r\n{my_orders}','','Спасибо','Спасибо','Спасибо'),
(323,58,1,'Read Reviews','{module alias=\'reviews\' action=\'display\'}','','Read Reviews','Read Reviews','Read Reviews'),
(324,58,2,'Читать отзывы','{module alias=\'reviews\' action=\'display\'}','','Читать отзывы','Читать отзывы','Читать отзывы'),
(325,59,1,'Write Review','{module alias=\'reviews\' action=\'create\'}','','Write Review','Write Review','Write Review'),
(326,59,2,'Добавить отзыв','{module alias=\'reviews\' action=\'create\'}','','Добавить отзыв','Добавить отзыв','Добавить отзыв'),
(359,51,1,'Confirmation','{payment}\r\n{shipping}\r\n{shopping_cart template=\'cart-confirm-view\'}','','Confirmation','Confirmation','Confirmation'),
(360,51,2,'Подтверждение заказа','{payment}\r\n{shipping}\r\n{shopping_cart template=\'cart-confirm-view\'}','','Подтверждение заказа','Подтверждение заказа','Подтверждение заказа'),
(393,68,1,'Voucher Details','{module alias=\'coupons\' action=\'show_info\'}','','Voucher Details','Voucher Details','Voucher Details'),
(394,68,2,'Информация о купоне','{module alias=\'coupons\' action=\'show_info\'}','','Информация о купоне','Информация о купоне','Информация о купоне'),
(395,69,1,'News','','','News','News','News'),
(396,69,2,'Новости','','','Новости','Новости','Новости'),
(397,70,1,'Articles','','','Articles','Articles','Articles'),
(398,70,2,'Статьи','','','Статьи','Статьи','Статьи'),
(399,71,1,'News heading','News content','','News heading','News heading','News heading'),
(400,71,2,'Заголовок новости','Текст новости','','Заголовок новости','Заголовок новости','Заголовок новости'),
(401,72,1,'Article','Description','','Article','Article','Article'),
(402,72,2,'Статья','Текст статьи','','Статья','Статья','Статья'),
(403,73,1,'Search results','{search_result}','','Search results','Search results','Search results'),
(404,73,2,'Результаты поиска','{search_result}','','Результаты поиска','Результаты поиска','Результаты поиска'),
(515,87,1,'Register','{registration_form}','','Register','Register','Register'),
(516,87,2,'Регистрация','{registration_form}','','Регистрация','Регистрация','Регистрация'),
(517,88,1,'Register success','Thak you for registration','','Register success','Register success','Register success'),
(518,88,2,'Успешная регистрация','Благодарим Вас за регистрацию в нашем магазине!','','Успешная регистрация','Успешная регистрация','Успешная регистрация'),
(519,89,1,'Account','{login_box}','','Account','Account','Account'),
(520,89,2,'Личный кабинет','{login_box}','','Личный кабинет','Личный кабинет','Личный кабинет'),
(521,90,1,'Account Edit','{account_edit}','','Account Edit','Account Edit','Account Edit'),
(522,90,2,'Редактирование данных','{account_edit}','','Редактирование данных','Редактирование данных','Редактирование данных'),
(523,91,1,'My Orders','{my_orders}','','My Orders','My Orders','My Orders'),
(524,91,2,'Мои заказы','{my_orders}','','Мои заказы','Мои заказы','Мои заказы'),
(525,92,1,'Address Book','{address_book}','','Address Book','Address Book','Address Book'),
(526,92,2,'Адресная книга','{address_book}','','Адресная книга','Адресная книга','Адресная книга'),
(741,35,1,'Home','<a href="{base_path}/users/admin_login/">Click here to go to the admin area.</a><br />Login: admin<br />Password: password<br /><br />','','Home','Home','Home'),
(742,35,2,'Главная страница','<a href="{base_path}/users/admin_login/">Вход в админку.</a><br />Логин: admin<br />Пароль: password<br /><br />','','Главная страница','Главная страница','Главная страница'),
(775,38,1,'Samsung GALAXY Tab 3','Product description.','Product short description.','Samsung GALAXY Tab 3','Samsung GALAXY Tab 3','Samsung GALAXY Tab 3'),
(776,38,2,'Samsung GALAXY Tab 3','Исключительная плавность работы и почти безграничный технический потенциал Samsung GALAXY Tab 3 воплотились в элегантном и современном дизайне. Легкий и тонкий корпус делает этот планшет эргономичным и удобным в управлении. Вы непременно оцените его преимущества!','Исключительная плавность работы и почти безграничный технический потенциал Samsung GALAXY Tab 3 воплотились в элегантном и современном дизайне. Легкий и тонкий корпус делает этот планшет эргономичным и удобным в управлении. Вы непременно оцените его преимущества!','Samsung GALAXY Tab 3','Samsung GALAXY Tab 3','Samsung GALAXY Tab 3'),
(777,93,1,'Samsung GALAXY Note 10.1','Product description.','Product short description.','Samsung GALAXY Note 10.1','Samsung GALAXY Note 10.1','Samsung GALAXY Note 10.1'),
(778,93,2,'Samsung GALAXY Note 10.1','Новый планшет Samsung GALAXY Note 10.1 2014 Edition отличается исключительно высоким разрешением WQXGA, кристально четким изображением и большим экраном. Высочайшее разрешение обеспечивает комфортные условия для просмотра любого контента, причем фильмы в формате Full HD будут воспроизводиться без малейшей потери качества, а фотоснимки приобретут удивительную детальность.','Новый планшет Samsung GALAXY Note 10.1 2014 Edition отличается исключительно высоким разрешением WQXGA, кристально четким изображением и большим экраном. Высочайшее разрешение обеспечивает комфортные условия для просмотра любого контента, причем фильмы в формате Full HD будут воспроизводиться без малейшей потери качества, а фотоснимки приобретут удивительную детальность.','Samsung GALAXY Note 10.1','Samsung GALAXY Note 10.1','Samsung GALAXY Note 10.1'),
(779,94,1,'Samsung GALAXY Note 8','Product description.','Product short description.','Samsung GALAXY Note 8','Samsung GALAXY Note 8','Samsung GALAXY Note 8'),
(780,94,2,'Samsung GALAXY Note 8','Поприветствуйте новый Samsung GALAXY Note 8.0, вашего друга и помощника во всех делах. Быстрый, функциональный и компактный, с поддержкой рукописного ввода с помощью S Pen, он всегда будет под рукой, когда вам необходимо.','Поприветствуйте новый Samsung GALAXY Note 8.0, вашего друга и помощника во всех делах. Быстрый, функциональный и компактный, с поддержкой рукописного ввода с помощью S Pen, он всегда будет под рукой, когда вам необходимо.','Samsung GALAXY Note 8','Samsung GALAXY Note 8','Samsung GALAXY Note 8'),
(781,98,1,'Samsung ATIV Book 9','Product description.','Product short description.','Samsung ATIV Book 9','Samsung ATIV Book 9','Samsung ATIV Book 9'),
(782,98,2,'Samsung ATIV Book 9','Уникальный тонкий 15,0\" ноутбук.','Уникальный тонкий 15,0\" ноутбук.','Samsung ATIV Book 9','Samsung ATIV Book 9','Samsung ATIV Book 9'),
(783,99,1,'Samsung ATIV Smart PC','Product description.','Product short description.','Samsung ATIV Smart PC','Samsung ATIV Smart PC','Samsung ATIV Smart PC'),
(784,99,2,'Samsung ATIV Smart PC','Инновационная конструкция сочетает в себе функциональность ноутбука с удобством планшета: с ней вы получаете исключительную мобильность и удобство для работы на ходу, включая серфинг по Интернету, широкие возможности коммуникации, просмотра видео и игровых приложений. Если же вам требуется поработать - подключите к ATIV Smart PC полноразмерную клавиатуру, и ваш планшет приобретет функциональность полноценного ноутбука.','Инновационная конструкция сочетает в себе функциональность ноутбука с удобством планшета: с ней вы получаете исключительную мобильность и удобство для работы на ходу, включая серфинг по Интернету, широкие возможности коммуникации, просмотра видео и игровых приложений. Если же вам требуется поработать - подключите к ATIV Smart PC полноразмерную клавиатуру, и ваш планшет приобретет функциональность полноценного ноутбука.','Samsung ATIV Smart PC','Samsung ATIV Smart PC','Samsung ATIV Smart PC'),
(785,100,1,'Samsung ATIV Book 4','Product description.','Product short description.','Samsung ATIV Book 4','Samsung ATIV Book 4','Samsung ATIV Book 4'),
(786,100,2,'Samsung ATIV Book 4','При весе 1,99 кг и толщине 22,9 мм ноутбук отличается стильным дизайном. Он настолько компактен, что его можно всегда иметь при себе. ATIV Book 4 настолько легкий, что вы не сможете себя представить без него. Тем не менее, этот ноутбук отличается высокой функциональностью и производительностью.','При весе 1,99 кг и толщине 22,9 мм ноутбук отличается стильным дизайном. Он настолько компактен, что его можно всегда иметь при себе. ATIV Book 4 настолько легкий, что вы не сможете себя представить без него. Тем не менее, этот ноутбук отличается высокой функциональностью и производительностью.','Samsung ATIV Book 4','Samsung ATIV Book 4','Samsung ATIV Book 4'),
(787,95,1,'Samsung GALAXY Note 3','Product description.','Product short description.','Samsung GALAXY Note 3','Samsung GALAXY Note 3','Samsung GALAXY Note 3'),
(788,95,2,'Samsung GALAXY Note 3','Смартфон премиум-класса с большим и ярким дисплеем 5,7 дюйма.','Смартфон премиум-класса с большим и ярким дисплеем 5,7 дюйма.','Samsung GALAXY Note 3','Samsung GALAXY Note 3','Samsung GALAXY Note 3'),
(789,96,1,'Samsung GALAXY S4','Product description.','Product short description.','Samsung GALAXY S4','Samsung GALAXY S4','Samsung GALAXY S4'),
(790,96,2,'Samsung GALAXY S4','Новый смартфон Samsung GALAXY S4 станет твоим истинным компаньоном, который поможет упростить общение с людьми и сохранить самые радостные моменты жизни. Каждая его функция призвана сделать твою жизнь насыщенней и интересней. Кроме того, он может следить за твоим здоровьем и самочувствием. Samsung GALAXY S4 - твой незаменимый помощник.','Новый смартфон Samsung GALAXY S4 станет твоим истинным компаньоном, который поможет упростить общение с людьми и сохранить самые радостные моменты жизни. Каждая его функция призвана сделать твою жизнь насыщенней и интересней. Кроме того, он может следить за твоим здоровьем и самочувствием. Samsung GALAXY S4 - твой незаменимый помощник.','Samsung GALAXY S4','Samsung GALAXY S4','Samsung GALAXY S4'),
(791,97,1,'Samsung GALAXY Ace 3','Product description.','Product short description.','Samsung GALAXY Ace 3','Samsung GALAXY Ace 3','Samsung GALAXY Ace 3'),
(792,97,2,'Samsung GALAXY Ace 3','Samsung GALAXY Ace 3 - ваш проводник в мир высоких технологий и производительности. Смартфон оснащен мощным процессором, поддерживает быстрые подключения и работает на новейшей версии платформы Android с первоклассным пользовательским интерфейсом. Игровой портал, облачное хранилище, навигация с поддержкой GPS и ГЛОНАСС - у этой модели есть все, чтобы претендовать на звание совершенного смартфона.','Samsung GALAXY Ace 3 - ваш проводник в мир высоких технологий и производительности. Смартфон оснащен мощным процессором, поддерживает быстрые подключения и работает на новейшей версии платформы Android с первоклассным пользовательским интерфейсом. Игровой портал, облачное хранилище, навигация с поддержкой GPS и ГЛОНАСС - у этой модели есть все, чтобы претендовать на звание совершенного смартфона.','Samsung GALAXY Ace 3','Samsung GALAXY Ace 3','Samsung GALAXY Ace 3'),
(793,39,1,'Smartphones','Smartphones category description.','Smartphones category short description.','Smartphones','Smartphones','Smartphones'),
(794,39,2,'Смартфоны','Описание категории смартфоны.','Краткое описание категории смартфоны.','Смартфоны','Смартфоны','Смартфоны'),
(795,36,1,'Tablets','Tablets category description.','Tablets category short description.','Tablets','Tablets','Tablets'),
(796,36,2,'Планшеты','Описание категории планшеты.','Краткое описание категории планшеты.','Планшеты','Планшеты','Планшеты'),
(797,43,1,'Notebooks','Notebooks category description.','Notebooks category short description.','Notebooks','Notebooks','Notebooks'),
(798,43,2,'Ноутбуки','Описание категории ноутбуки.','Краткое описание категории ноутбуки.','Ноутбуки','Ноутбуки','Ноутбуки'),
(799,101,1,'Smart Watches','Smart watches category description.','Smart watches category short description.','Smart Watches','Smart Watches','Smart Watches'),
(800,101,2,'Умные часы','Описание категории умные часы.','Краткое описание категории умные часы.','Умные часы','Умные часы','Умные часы'),
(807,102,1,'Samsung Gear 2 Wild Orange','Product description.','Product short description.','Samsung Gear 2 Wild Orange','Samsung Gear 2 Wild Orange','Samsung Gear 2 Wild Orange'),
(808,102,2,'Samsung Gear 2 Wild Orange','Часы Samsung Gear 2 выполнены в стиле современных модных тенденций. Они оборудованы 1,63-дюймовым Super AMOLED дисплеем, который заключен в стильный металлический корпус. Минималистичный дизайн и сменные ремешки различных цветов позволяят смело заявить о твоем тонком вкусе и любви к высоким технологиям. <br /><br />Стоит также отметить, что в элегантный корпус Samsung Gear 2 встроена камера с разрешением 2 Мпикс. Теперь ты не упустишь ни одного момента.','Часы Samsung Gear 2 выполнены в стиле современных модных тенденций. Они оборудованы 1,63-дюймовым Super AMOLED дисплеем, который заключен в стильный металлический корпус. Минималистичный дизайн и сменные ремешки различных цветов позволяят смело заявить о твоем тонком вкусе и любви к высоким технологиям. <br /><br />Стоит также отметить, что в элегантный корпус Samsung Gear 2 встроена камера с разрешением 2 Мпикс. Теперь ты не упустишь ни одного момента.','Samsung Gear 2 Wild Orange','Samsung Gear 2 Wild Orange','Samsung Gear 2 Wild Orange'),
(809,103,1,'Samsung Gear 2 Gold Brown','Product description.','Product short description.','Samsung Gear 2 Gold Brown','Samsung Gear 2 Gold Brown','Samsung Gear 2 Gold Brown'),
(810,103,2,'Samsung Gear 2 Gold Brown','Часы Samsung Gear 2 выполнены в стиле современных модных тенденций. Они оборудованы 1,63-дюймовым Super AMOLED дисплеем, который заключен в стильный металлический корпус. Минималистичный дизайн и сменные ремешки различных цветов позволяят смело заявить о твоем тонком вкусе и любви к высоким технологиям. <br /><br />Стоит также отметить, что в элегантный корпус Samsung Gear 2 встроена камера с разрешением 2 Мпикс. Теперь ты не упустишь ни одного момента.','Часы Samsung Gear 2 выполнены в стиле современных модных тенденций. Они оборудованы 1,63-дюймовым Super AMOLED дисплеем, который заключен в стильный металлический корпус. Минималистичный дизайн и сменные ремешки различных цветов позволяят смело заявить о твоем тонком вкусе и любви к высоким технологиям. <br /><br />Стоит также отметить, что в элегантный корпус Samsung Gear 2 встроена камера с разрешением 2 Мпикс. Теперь ты не упустишь ни одного момента.','Samsung Gear 2 Gold Brown','Samsung Gear 2 Gold Brown','Samsung Gear 2 Gold Brown'),
(811,104,1,'Samsung Gear 2 Charcoal Black','Product description.','Product short description.','Samsung Gear 2 Charcoal Black','Samsung Gear 2 Charcoal Black','Samsung Gear 2 Charcoal Black'),
(812,104,2,'Samsung Gear 2 Charcoal Black','Часы Samsung Gear 2 выполнены в стиле современных модных тенденций. Они оборудованы 1,63-дюймовым Super AMOLED дисплеем, который заключен в стильный металлический корпус. Минималистичный дизайн и сменные ремешки различных цветов позволяят смело заявить о твоем тонком вкусе и любви к высоким технологиям. <br /><br />Стоит также отметить, что в элегантный корпус Samsung Gear 2 встроена камера с разрешением 2 Мпикс. Теперь ты не упустишь ни одного момента.','Часы Samsung Gear 2 выполнены в стиле современных модных тенденций. Они оборудованы 1,63-дюймовым Super AMOLED дисплеем, который заключен в стильный металлический корпус. Минималистичный дизайн и сменные ремешки различных цветов позволяят смело заявить о твоем тонком вкусе и любви к высоким технологиям. <br /><br />Стоит также отметить, что в элегантный корпус Samsung Gear 2 встроена камера с разрешением 2 Мпикс. Теперь ты не упустишь ни одного момента.','Samsung Gear 2 Charcoal Black','Samsung Gear 2 Charcoal Black','Samsung Gear 2 Charcoal Black'),
(813, 105, 1, 'Ask A Product Question', '{module alias=''ask_a_product_question'' controller=''get'' action=''ask_success''}', '', 'Ask A Product Question', 'Ask A Product Question', 'Ask A Product Question'),
(814, 105, 2, 'Задать вопрос о товаре', '{module alias=''ask_a_product_question'' controller=''get'' action=''ask_success''}', '', 'Задать вопрос о товаре', 'Задать вопрос о товаре', 'Задать вопрос о товаре'),
(815, 106, 1, 'One Click Buy', '{module alias=''one_click_buy'' controller=''buy'' action=''success''}', '', 'One Click Buy', 'One Click Buy', 'One Click Buy'),
(816, 106, 2, 'Купить за 1 клик', '{module alias=''one_click_buy'' controller=''buy'' action=''success''}', '', 'Купить за 1 клик', 'Купить за 1 клик', 'Купить за 1 клик'),
(817, 107, 1, 'Brands', '', '', 'Brands', 'Brands', 'Brands'),
(818, 107, 2, 'Брэнды', '', '', 'Брэнды', 'Брэнды', 'Брэнды'),
(819, 108, 1, 'Samsung', '', '', 'Samsung', 'Samsung', 'Samsung'),
(820, 108, 2, 'Samsung', '', '', 'Samsung', 'Samsung', 'Samsung'),
(821, 109, 1, 'Password Recovery', '{password_recovery}', '', 'Password Recovery', 'Password Recovery', 'Password Recovery'),
(822, 109, 2, 'Восстановление пароля', '{password_recovery}', '', 'Восстановление пароля', 'Восстановление пароля', 'Восстановление пароля'),
(823, 110, 1, '404', 'Page not found.<br /><br />We couldn\'t find that page.<br /><br />Try searching.<br /><br />{content_listing template="featured-products" label_id="3" type="product" limit="9"}', '', '404', '404', '404'),
(824, 110, 2, '404', 'Страница не найдена.<br /><br />Неправильно набран адрес, либо такой страницы больше не существует.<br /><br />Вы можете воспользоваться поиском.<br /><br />{content_listing template="featured-products" label_id="3" type="product" limit="9"}', '', '404', '404', '404');

DROP TABLE IF EXISTS content_images;
CREATE TABLE `content_images` (
  `id` int(10) auto_increment,
  `content_id` int(10),
  `order` int(10),
  `image` varchar(255) collate utf8_unicode_ci,
  `created` datetime,
  `modified` datetime,
  PRIMARY KEY  (`id`),
  INDEX content_id (content_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `content_images` VALUES 
(23,39,1,'smartphones.png','2013-10-19 20:44:16','2013-10-19 20:44:16'),
(26,36,1,'tablets.png','2013-10-19 20:50:28','2013-10-19 20:50:28'),
(30,43,1,'notebooks.png','2013-10-19 20:57:10','2013-10-19 20:57:10'),
(79,93,1,'samsung-galaxy-note-10-1.png','2013-10-19 22:34:00','2013-10-19 22:34:00'),
(80,93,2,'samsung-galaxy-note-10-2.jpg','2013-10-19 22:34:00','2013-10-19 22:34:00'),
(81,93,3,'samsung-galaxy-note-10-3.jpg','2013-10-19 22:34:00','2013-10-19 22:34:00'),
(82,93,4,'samsung-galaxy-note-10-4.jpg','2013-10-19 22:34:01','2013-10-19 22:34:01'),
(83,38,1,'samsung-galaxy-tab-3-1.png','2013-10-19 22:35:45','2013-10-19 22:35:45'),
(84,38,2,'samsung-galaxy-tab-3-2.jpg','2013-10-19 22:35:45','2013-10-19 22:35:45'),
(85,38,3,'samsung-galaxy-tab-3-3.jpg','2013-10-19 22:35:45','2013-10-19 22:35:45'),
(86,38,4,'samsung-galaxy-tab-3-4.jpg','2013-10-19 22:35:45','2013-10-19 22:35:45'),
(89,94,1,'samsung-galaxy-note-8-1.png','2013-10-19 22:48:13','2013-10-19 22:48:13'),
(90,94,2,'samsung-galaxy-note-8-2.jpg','2013-10-19 22:48:13','2013-10-19 22:48:13'),
(91,94,3,'samsung-galaxy-note-8-3.jpg','2013-10-19 22:48:13','2013-10-19 22:48:13'),
(92,94,4,'samsung-galaxy-note-8-4.jpg','2013-10-19 22:48:14','2013-10-19 22:48:14'),
(93,95,1,'samsung-galaxy-note-3-1.png','2013-10-19 23:17:50','2013-10-19 23:17:50'),
(94,95,2,'samsung-galaxy-note-3-2.jpg','2013-10-19 23:17:50','2013-10-19 23:17:50'),
(95,95,3,'samsung-galaxy-note-3-3.jpg','2013-10-19 23:17:50','2013-10-19 23:17:50'),
(96,95,4,'samsung-galaxy-note-3-4.jpg','2013-10-19 23:17:50','2013-10-19 23:17:50'),
(97,96,1,'samsung-galaxy-s4-1.png','2013-10-19 23:18:22','2013-10-19 23:18:22'),
(98,96,2,'samsung-galaxy-s4-2.jpg','2013-10-19 23:18:22','2013-10-19 23:18:22'),
(99,96,3,'samsung-galaxy-s4-3.jpg','2013-10-19 23:18:22','2013-10-19 23:18:22'),
(100,96,4,'samsung-galaxy-s4-4.jpg','2013-10-19 23:18:22','2013-10-19 23:18:22'),
(101,97,1,'samsung-galaxy-ace-3-1.png','2013-10-19 23:18:41','2013-10-19 23:18:41'),
(102,97,2,'samsung-galaxy-ace-3-2.jpg','2013-10-19 23:18:41','2013-10-19 23:18:41'),
(103,97,3,'samsung-galaxy-ace-3-3.jpg','2013-10-19 23:18:41','2013-10-19 23:18:41'),
(104,97,4,'samsung-galaxy-ace-3-4.jpg','2013-10-19 23:18:41','2013-10-19 23:18:41'),
(105,98,1,'samsung-ativ-book-9-1.png','2013-10-19 23:44:13','2013-10-19 23:44:13'),
(106,98,2,'samsung-ativ-book-9-2.jpg','2013-10-19 23:44:13','2013-10-19 23:44:13'),
(107,98,3,'samsung-ativ-book-9-3.jpg','2013-10-19 23:44:13','2013-10-19 23:44:13'),
(108,98,4,'samsung-ativ-book-9-4.jpg','2013-10-19 23:44:13','2013-10-19 23:44:13'),
(109,99,1,'samsung-ativ-smart-pc-1.png','2013-10-19 23:52:10','2013-10-19 23:52:10'),
(110,99,2,'samsung-ativ-smart-pc-2.jpg','2013-10-19 23:52:10','2013-10-19 23:52:10'),
(111,99,3,'samsung-ativ-smart-pc-3.jpg','2013-10-19 23:52:10','2013-10-19 23:52:10'),
(112,99,4,'samsung-ativ-smart-pc-4.jpg','2013-10-19 23:52:10','2013-10-19 23:52:10'),
(113,100,1,'samsung-ativ-book-4-1.png','2013-10-19 23:52:25','2013-10-19 23:52:25'),
(114,100,2,'samsung-ativ-book-4-2.jpg','2013-10-19 23:52:25','2013-10-19 23:52:25'),
(115,100,3,'samsung-ativ-book-4-3.jpg','2013-10-19 23:52:25','2013-10-19 23:52:25'),
(116,100,4,'samsung-ativ-book-4-4.jpg','2013-10-19 23:52:25','2013-10-19 23:52:25'),
(117,102,1,'samsung-gear-2-wild-orange-1.jpg','2014-07-11 20:08:56','2014-07-11 20:08:56'),
(118,102,2,'samsung-gear-2-wild-orange-2.jpg','2014-07-11 20:08:56','2014-07-11 20:08:56'),
(119,103,1,'samsung-gear-2-gold-brown-1.jpg','2014-07-11 20:09:10','2014-07-11 20:09:10'),
(120,103,2,'samsung-gear-2-gold-brown-2.jpg','2014-07-11 20:09:10','2014-07-11 20:09:10'),
(121,103,3,'samsung-gear-2-gold-brown-3.jpg','2014-07-11 20:09:10','2014-07-11 20:09:10'),
(122,103,4,'samsung-gear-2-gold-brown-4.jpg','2014-07-11 20:09:11','2014-07-11 20:09:11'),
(123,104,1,'samsung-gear-2-charcoal-black-1.jpg','2014-07-11 20:09:21','2014-07-11 20:09:21'),
(124,104,2,'samsung-gear-2-charcoal-black-2.jpg','2014-07-11 20:09:21','2014-07-11 20:09:21'),
(125,104,3,'samsung-gear-2-charcoal-black-3.jpg','2014-07-11 20:09:21','2014-07-11 20:09:21'),
(126,104,4,'samsung-gear-2-charcoal-black-4.jpg','2014-07-11 20:09:21','2014-07-11 20:09:21'),
(127,108,1,'samsung.png','2014-07-11 20:09:21','2014-07-11 20:09:21'),
(128,101,1,'smart-watches.png','2014-07-11 20:09:21','2014-07-11 20:09:21')	;

DROP TABLE IF EXISTS content_links;
CREATE TABLE `content_links` (
  `id` int(10) auto_increment,
  `content_id` int(10),
  `url` varchar(255) collate utf8_unicode_ci,
  PRIMARY KEY  (`id`),
  INDEX content_id (content_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS content_manufacturers;
CREATE TABLE `content_manufacturers` (
  `id` int(10) auto_increment,
  `content_id` int(10),
  `extra` varchar(1) collate utf8_unicode_ci,
  PRIMARY KEY  (`id`),
  INDEX content_id (content_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `content_manufacturers` VALUES 
(1,108,'1')	;

DROP TABLE IF EXISTS content_pages;
CREATE TABLE `content_pages` (
  `id` int(10) auto_increment,
  `content_id` int(10),
  `extra` varchar(1) collate utf8_unicode_ci,
  PRIMARY KEY  (`id`),
  INDEX content_id (content_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `content_pages` VALUES 
(23,35,'1'),
(24,36,'1'),
(25,44,'1'),
(26,45,'1'),
(27,46,'1'),
(28,47,'1'),
(29,48,'1'),
(30,49,'1'),
(31,50,'1'),
(32,51,'1'),
(33,53,'1'),
(34,73,'1'),
(35,87,'1'),
(36,88,'1'),
(37,110,'1')	;

DROP TABLE IF EXISTS content_products;
CREATE TABLE `content_products` (
  `id` int(10) auto_increment,
  `content_id` int(10),
  `manufacturer_id` int(10),
  `label_id` int(10),
  `stock` int(10),
  `model` varchar(255) collate utf8_unicode_ci,
  `sku` varchar(255) collate utf8_unicode_ci,
  `price` double,
  `tax_id` int(10),
  `weight` double,
  `length` double,
  `width` double,
  `height` double,
  `volume` double,
  `moq` int(8) DEFAULT '1',
  `pf` int(8) DEFAULT '1',
  `is_new` int(8) DEFAULT '1',
  `is_featured` int(8) DEFAULT '0',
  `ordered` int(10),
  PRIMARY KEY  (`id`),
  INDEX content_id (content_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `content_products` VALUES 
(17,38,108,0,999,'samsung-galaxy-tab-3','',399,1,0.6,30,20,5,0.003,1,1,1,0,0),
(18,93,108,2,999,'samsung-galaxy-note-10-1','',299,1,0.6,30,20,5,0.003,1,1,1,0,0),
(19,94,108,0,999,'samsung-galaxy-note-8','',199,1,0.6,30,20,5,0.003,1,1,1,0,0),
(20,95,108,1,999,'samsung-galaxy-note-3','',499,1,0.6,30,20,5,0.003,1,1,0,1,0),
(21,96,108,2,999,'samsung-galaxy-s4','',399,1,0.6,30,20,5,0.003,1,1,0,1,0),
(22,97,108,3,999,'samsung-galaxy-ace-3','',299,1,0.6,30,20,5,0.003,1,1,0,1,0),
(23,98,108,0,999,'samsung-ativ-book-9','',999,1,0.6,30,20,5,0.003,1,1,0,0,0),
(24,99,108,0,999,'samsung-ativ-smart-pc','',899,1,0.6,30,20,5,0.003,1,1,0,0,0),
(25,100,108,3,999,'samsung-ativ-book-4','',799,1,0.6,30,20,5,0.003,1,1,0,0,0),
(26,102,108,0,999,'samsung-gear-2-wild-orange','',299,1,0.6,30,20,5,0.003,1,1,0,0,0),
(27,103,108,0,999,'samsung-gear-2-gold-brown','',299,1,0.6,30,20,5,0.003,1,1,0,0,0),
(28,104,108,0,999,'samsung-gear-2-charcoal-black','',299,1,0.6,30,20,5,0.003,1,1,0,0,0);

DROP TABLE IF EXISTS content_product_prices;
CREATE TABLE IF NOT EXISTS `content_product_prices` (
  `id` int(10) AUTO_INCREMENT,
  `content_product_id` int(10),
  `quantity` int(10),
  `price` double,
  PRIMARY KEY (`id`),
  INDEX content_product_id (content_product_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS content_specials;
CREATE TABLE `content_specials` (
  `id` int(10) auto_increment,
  `content_id` int(10),
  `groups_customer_id` int(10),
  `price` double,
  `date_start` date,
  `date_end` date,
  PRIMARY KEY  (`id`),
  INDEX content_id (content_id),
  INDEX groups_customer_id (groups_customer_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `content_specials` (`id`, `content_id`, `groups_customer_id`, `price`, `date_start`, `date_end`) VALUES
(1, 95, NULL, 429, NULL, NULL),
(2, 97, NULL, 249, NULL, NULL),
(3, 93, NULL, 249, NULL, NULL),
(4, 100, NULL, 729, NULL, NULL),
(5, 102, NULL, 249, NULL, NULL);

DROP TABLE IF EXISTS content_news;
CREATE TABLE `content_news` (
  `id` int(10) auto_increment,
  `content_id` int(1),
  `extra` varchar(1) collate utf8_unicode_ci,
  PRIMARY KEY  (`id`),
  INDEX content_id (content_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `content_news` (`id`, `content_id`, `extra`) VALUES 
(1, 69, '1'),
(2, 71, '1');

DROP TABLE IF EXISTS content_articles;
CREATE TABLE `content_articles` (
  `id` int(10) auto_increment,
  `content_id` int(1),
  `extra` varchar(1) collate utf8_unicode_ci,
  PRIMARY KEY  (`id`),
  INDEX content_id (content_id)
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
  PRIMARY KEY  (`id`),
  INDEX template_type_id (template_type_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `content_types` (`id`, `template_type_id`, `name`, `type`) VALUES 
(1, 4, 'category', 'ContentCategory'),
(2, 3, 'product', 'ContentProduct'),
(3, 2, 'page', 'ContentPage'),
(4, 0, 'link', 'ContentLink'),
(5, 5, 'news', 'ContentNews'),
(6, 6, 'article', 'ContentArticle'),
(7, 3, 'downloadable', 'ContentDownloadable'),
(8, 7, 'manufacturer', 'ContentManufacturer');

DROP TABLE IF EXISTS `content_downloadables`;
CREATE TABLE IF NOT EXISTS `content_downloadables` (
  `id` int(10) AUTO_INCREMENT,
  `content_id` int(10),
  `manufacturer_id` int(10),
  `label_id` int(10),
  `filename` varchar(256),
  `filestorename` varchar(256),
  `price` double,
  `stock` int(10),
  `model` varchar(255),
  `sku` varchar(255),
  `tax_id` int(10),
  `weight` double,
  `length` double,
  `width` double,
  `height` double,
  `volume` double,
  `moq` int(8) DEFAULT '1',
  `pf` int(8) DEFAULT '1',
  `is_new` int(8) DEFAULT '1',
  `is_featured` int(8) DEFAULT '0',
  `ordered` int(10),
  `order_status_id` int(10),
  `max_downloads` int(10) DEFAULT '0',
  `max_days_for_download` int(10) DEFAULT '0',
  PRIMARY KEY (`id`),
  INDEX content_id (content_id)
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
(176, 'Russian Federation', 'RU', 'RUS', ':name\n:street_address\n:postcode :city\n:country', 1),
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
(236, 'Serbia', 'RS', 'SRB', '', 1),
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
(1, 109, 0, 'Акмолинская область', 'Акмолинская область'),
(2, 109, 0, 'Актюбинская область', 'Актюбинская область'),
(3, 109, 0, 'Алматинская область', 'Алматинская область'),
(4, 109, 0, 'Атырауская область', 'Атырауская область'),
(5, 109, 0, 'Восточно-Казахстанская область', 'Восточно-Казахстанская область'),
(6, 109, 0, 'Жамбылская область', 'Жамбылская область'),
(7, 109, 0, 'Западно-Казахстанская область', 'Западно-Казахстанская область'),
(8, 109, 0, 'Карагандинская область', 'Карагандинская область'),
(9, 109, 0, 'Кзылординская область', 'Кзылординская область'),
(10, 109, 0, 'Костанайская область', 'Костанайская область'),
(11, 109, 0, 'Мангистауская область', 'Мангистауская область'),
(12, 109, 0, 'Павлодарская область', 'Павлодарская область'),
(13, 109, 0, 'Северо-Казахстанская область', 'Северо-Казахстанская область'),
(14, 109, 0, 'Южно-Казахстанская область', 'Южно-Казахстанская область'),
(15, 115, 0, 'Баткенская область', 'Баткенская область'),
(16, 115, 0, 'Бишкек', 'Бишкек'),
(17, 115, 0, 'Джалал-Абадская область', 'Джалал-Абадская область'),
(18, 115, 0, 'Иссык-Кульская область', 'Иссык-Кульская область'),
(19, 115, 0, 'Таласская область', 'Таласская область'),
(20, 115, 0, 'Нарынская область', 'Нарынская область'),
(21, 115, 0, 'Ошская область', 'Ошская область'),
(22, 115, 0, 'Чуйская область', 'Чуйская область'),
(23, 176, 5, 'Адыгея', 'Адыгея'),
(24, 176, 3, 'Башкирия', 'Башкирия'),
(25, 176, 4, 'Бурятия', 'Бурятия'),
(26, 176, 3, 'Горный Алтай', 'Горный Алтай'),
(27, 176, 3, 'Дагестан', 'Дагестан'),
(28, 176, 3, 'Ингушетия', 'Ингушетия'),
(29, 176, 3, 'Кабардино-Балкария', 'Кабардино-Балкария'),
(30, 176, 4, 'Калмыкия', 'Калмыкия'),
(31, 176, 3, 'Карачаево-Черкесия', 'Карачаево-Черкесия'),
(32, 176, 1, 'Карелия', 'Карелия'),
(33, 176, 2, 'Коми', 'Коми'),
(34, 176, 2, 'Марийская Республика', 'Марийская Республика'),
(35, 176, 2, 'Мордовская Республика', 'Мордовская Республика'),
(36, 176, 5, 'Якутия', 'Якутия'),
(37, 176, 3, 'Северная Осетия', 'Северная Осетия'),
(38, 176, 2, 'Татарстан', 'Татарстан'),
(39, 176, 3, 'Тува', 'Тува'),
(40, 176, 2, 'Удмуртия', 'Удмуртия'),
(41, 176, 3, 'Хакасия', 'Хакасия'),
(42, 176, 3, 'Чечня', 'Чечня'),
(43, 176, 2, 'Чувашия', 'Чувашия'),
(44, 176, 3, 'Алтайский край', 'Алтайский край'),
(45, 176, 3, 'Краснодарский край', 'Краснодарский край'),
(46, 176, 3, 'Красноярский край', 'Красноярский край'),
(47, 176, 5, 'Приморский край', 'Приморский край'),
(48, 176, 3, 'Ставропольский край', 'Ставропольский край'),
(49, 176, 5, 'Хабаровский край', 'Хабаровский край'),
(50, 176, 5, 'Амурская область', 'Амурская область'),
(51, 176, 2, 'Архангельская область', 'Архангельская область'),
(52, 176, 3, 'Астраханская область', 'Астраханская область'),
(53, 176, 2, 'Белгородская область', 'Белгородская область'),
(54, 176, 2, 'Брянская область', 'Брянская область'),
(55, 176, 2, 'Владимирская область', 'Владимирская область'),
(56, 176, 2, 'Волгоградская область', 'Волгоградская область'),
(57, 176, 2, 'Вологодская область', 'Вологодская область'),
(58, 176, 2, 'Воронежская область', 'Воронежская область'),
(59, 176, 2, 'Ивановская область', 'Ивановская область'),
(60, 176, 4, 'Иркутская область', 'Иркутская область'),
(61, 176, 2, 'Калининградская область', 'Калининградская область'),
(62, 176, 2, 'Калужская область', 'Калужская область'),
(63, 176, 5, 'Камчатский край', 'Камчатский край'),
(64, 176, 3, 'Кемеровская область', 'Кемеровская область'),
(65, 176, 2, 'Кировская область', 'Кировская область'),
(66, 176, 2, 'Костромская область', 'Костромская область'),
(67, 176, 3, 'Курганская область', 'Курганская область'),
(68, 176, 2, 'Курская область', 'Курская область'),
(69, 176, 1, 'Ленинградская область', 'Ленинградская область'),
(70, 176, 2, 'Липецкая область', 'Липецкая область'),
(71, 176, 5, 'Магаданская область', 'Магаданская область'),
(72, 176, 2, 'Московская область', 'Московская область'),
(73, 176, 2, 'Мурманская область', 'Мурманская область'),
(74, 176, 2, 'Нижегородская область', 'Нижегородская область'),
(75, 176, 1, 'Новгородская область', 'Новгородская область'),
(76, 176, 3, 'Новосибирская область', 'Новосибирская область'),
(77, 176, 3, 'Омская область', 'Омская область'),
(78, 176, 3, 'Оренбургская область', 'Оренбургская область'),
(79, 176, 2, 'Орловская область', 'Орловская область'),
(80, 176, 2, 'Пензенская область', 'Пензенская область'),
(81, 176, 2, 'Пермский край', 'Пермский край'),
(82, 176, 1, 'Псковская область', 'Псковская область'),
(83, 176, 2, 'Ростовская область', 'Ростовская область'),
(84, 176, 2, 'Рязанская область', 'Рязанская область'),
(85, 176, 2, 'Самарская область', 'Самарская область'),
(86, 176, 2, 'Саратовская область', 'Саратовская область'),
(87, 176, 5, 'Сахалинская область', 'Сахалинская область'),
(88, 176, 3, 'Свердловская область', 'Свердловская область'),
(89, 176, 2, 'Смоленская область', 'Смоленская область'),
(90, 176, 2, 'Тамбовская область', 'Тамбовская область'),
(91, 176, 1, 'Тверская область', 'Тверская область'),
(92, 176, 3, 'Томская область', 'Томская область'),
(93, 176, 2, 'Тульская область', 'Тульская область'),
(94, 176, 3, 'Тюменская область', 'Тюменская область'),
(95, 176, 2, 'Ульяновская область', 'Ульяновская область'),
(96, 176, 3, 'Челябинская область', 'Челябинская область'),
(97, 176, 4, 'Читинская область', 'Читинская область'),
(98, 176, 2, 'Ярославская область', 'Ярославская область'),
(99, 176, 2, 'Москва', 'Москва'),
(100, 176, 1, 'Санкт-Петербург', 'Санкт-Петербург'),
(101, 176, 5, 'Еврейская автономная область', 'Еврейская автономная область'),
(102, 176, 4, 'Агинский Бурятский АО', 'Агинский Бурятский АО'),
(104, 176, 2, 'Ненецкий АО', 'Ненецкий АО'),
(105, 176, 2, 'Таймырский АО', 'Таймырский АО'),
(106, 176, 4, 'Усть-Ордынский Бурятский АО', 'Усть-Ордынский Бурятский АО'),
(107, 176, 2, 'Ханты-Мансийский АО', 'Ханты-Мансийский АО'),
(108, 176, 5, 'Чукотский АО', 'Чукотский АО'),
(109, 176, 5, 'Эвенкийский АО', 'Эвенкийский АО'),
(110, 176, 5, 'Ямало-Ненецкий АО', 'Ямало-Ненецкий АО'),
(111, 207, 0, 'Мухтори-Кухистони-Бадахшони', 'Мухтори-Кухистони-Бадахшони'),
(112, 207, 0, 'Хатлонская область', 'Хатлонская область'),
(113, 207, 0, 'Ленинабадская область', 'Ленинабадская область'),
(114, 216, 0, 'Ахал', 'Ахал'),
(115, 216, 0, 'Балкан', 'Балкан'),
(116, 216, 0, 'Дашховуз', 'Дашховуз'),
(117, 216, 0, 'Лебап', 'Лебап'),
(118, 216, 0, 'Мары', 'Мары'),
(119, 176, 3, 'Республика Крым', 'Республика Крым'),
(120, 220, 0, 'Винницкая область', 'Винницкая область'),
(121, 220, 0, 'Волынская область', 'Волынская область'),
(122, 220, 0, 'Днепропетровская область', 'Днепропетровская область'),
(123, 220, 0, 'Донецкая область', 'Донецкая область'),
(124, 220, 0, 'Житомирская область', 'Житомирская область'),
(125, 220, 0, 'Закарпатская область', 'Закарпатская область'),
(126, 220, 0, 'Запорожская область', 'Запорожская область'),
(127, 220, 0, 'Ивано-Франковская область', 'Ивано-Франковская область'),
(128, 220, 0, 'Киевская область', 'Киевская область'),
(129, 220, 0, 'Кировоградская область', 'Кировоградская область'),
(130, 220, 0, 'Луганская область', 'Луганская область'),
(131, 220, 0, 'Львовская область', 'Львовская область'),
(132, 220, 0, 'Николаевская область', 'Николаевская область'),
(133, 220, 0, 'Одесская область', 'Одесская область'),
(134, 220, 0, 'Полтавская область', 'Полтавская область'),
(135, 220, 0, 'Ровенская область', 'Ровенская область'),
(136, 220, 0, 'Сумская область', 'Сумская область'),
(137, 220, 0, 'Тернопольская область', 'Тернопольская область'),
(138, 220, 0, 'Харьковская область', 'Харьковская область'),
(139, 220, 0, 'Херсонская область', 'Херсонская область'),
(140, 220, 0, 'Хмельницкая область', 'Хмельницкая область'),
(141, 220, 0, 'Черкасская область', 'Черкасская область'),
(142, 220, 0, 'Черниговская область', 'Черниговская область'),
(143, 220, 0, 'Черновицкая область', 'Черновицкая область'),
(144, 226, 0, 'Андижанский', 'Андижанский'),
(145, 226, 0, 'Бухарский', 'Бухарский'),
(146, 226, 0, 'Джизакский', 'Джизакский'),
(147, 226, 0, 'Каракалпакия', 'Каракалпакия'),
(148, 226, 0, 'Кашкадарьинский', 'Кашкадарьинский'),
(149, 226, 0, 'Навоийский', 'Навоийский'),
(150, 226, 0, 'Наманганский', 'Наманганский'),
(151, 226, 0, 'Самаркандский', 'Самаркандский'),
(152, 226, 0, 'Сурхандарьинский', 'Сурхандарьинский'),
(153, 226, 0, 'Сырдарьинский', 'Сырдарьинский'),
(154, 226, 0, 'Ташкентский', 'Ташкентский'),
(155, 226, 0, 'Ферганский', 'Ферганский'),
(156, 226, 0, 'Хорезмский', 'Хорезмский'),
(157, 15, 0, 'Апшеронский район', 'Апшеронский район'),
(158, 15, 0, 'Агдамский район', 'Агдамский район'),
(159, 15, 0, 'Агдашский район', 'Агдашский район'),
(160, 15, 0, 'Агджабединский район', 'Агджабединский район'),
(161, 15, 0, 'Акстафинский район', 'Акстафинский район'),
(162, 15, 0, 'Агсуинский район', 'Агсуинский район'),
(163, 15, 0, 'Астаринский район', 'Астаринский район'),
(164, 15, 0, 'Балакенский район', 'Балакенский район'),
(165, 15, 0, 'Бейлаганский район', 'Бейлаганский район'),
(166, 15, 0, 'Бардинский район', 'Бардинский район'),
(167, 15, 0, 'Билясуварский район', 'Билясуварский район'),
(168, 15, 0, 'Джебраильский район', 'Джебраильский район'),
(169, 15, 0, 'Джалилабадский район', 'Джалилабадский район'),
(170, 15, 0, 'Дашкесанский район', 'Дашкесанский район'),
(171, 15, 0, 'Дивичинский район', 'Дивичинский район'),
(172, 15, 0, 'Физулинский район', 'Физулинский район'),
(173, 15, 0, 'Кедабекский район', 'Кедабекский район'),
(174, 15, 0, 'Геранбойский район', 'Геранбойский район'),
(175, 15, 0, 'Геокчайский район', 'Геокчайский район'),
(176, 15, 0, 'Гаджигабульский район', 'Гаджигабульский район'),
(177, 15, 0, 'Хачмазский район', 'Хачмазский район'),
(178, 15, 0, 'Ханларский район', 'Ханларский район'),
(179, 15, 0, 'Хызынский район', 'Хызынский район'),
(180, 15, 0, 'Ходжавендский район', 'Ходжавендский район'),
(181, 15, 0, 'Ходжалинский район', 'Ходжалинский район'),
(182, 15, 0, 'Имишлинский район', 'Имишлинский район'),
(183, 15, 0, 'Исмаиллинский район', 'Исмаиллинский район'),
(184, 15, 0, 'Кельбаджарский район', 'Кельбаджарский район'),
(185, 15, 0, 'Кюрдамирский район', 'Кюрдамирский район'),
(186, 15, 0, 'Гахский район', 'Гахский район'),
(187, 15, 0, 'Газахский район', 'Газахский район'),
(188, 15, 0, 'Габалинский район', 'Габалинский район'),
(189, 15, 0, 'Гобустанский район', 'Гобустанский район'),
(190, 15, 0, 'Губинский район', 'Губинский район'),
(191, 15, 0, 'Губадлинский район', 'Губадлинский район'),
(192, 15, 0, 'Гусарский район', 'Гусарский район'),
(193, 15, 0, 'Лачинский район', 'Лачинский район'),
(194, 15, 0, 'Ленкоранский район', 'Ленкоранский район'),
(195, 15, 0, 'Лерикский район', 'Лерикский район'),
(196, 15, 0, 'Масаллинский район', 'Масаллинский район'),
(197, 15, 0, 'Нефтчалинский район', 'Нефтчалинский район'),
(198, 15, 0, 'Огузский район', 'Огузский район'),
(199, 15, 0, 'Саатлинский район', 'Саатлинский район'),
(200, 15, 0, 'Сабирабадский район', 'Сабирабадский район'),
(201, 15, 0, 'Сальянский район', 'Сальянский район'),
(202, 15, 0, 'Самухский район', 'Самухский район'),
(203, 15, 0, 'Сиязаньский район', 'Сиязаньский район'),
(204, 15, 0, 'Шемахинский район', 'Шемахинский район'),
(205, 15, 0, 'Шемкирский район', 'Шемкирский район'),
(206, 15, 0, 'Шекинский район', 'Шекинский район'),
(207, 15, 0, 'Шушинский район', 'Шушинский район'),
(208, 15, 0, 'Тертерский район', 'Тертерский район'),
(209, 15, 0, 'Товузский район', 'Товузский район'),
(210, 15, 0, 'Уджарский район', 'Уджарский район'),
(211, 15, 0, 'Ярдымлинский район', 'Ярдымлинский район'),
(212, 15, 0, 'Евлахский район', 'Евлахский район'),
(213, 15, 0, 'Закатальский район', 'Закатальский район'),
(214, 15, 0, 'Зангеланский район', 'Зангеланский район'),
(215, 15, 0, 'Зардабский район', 'Зардабский район'),
(216, 15, 0, 'Нахичеванская Автономная Республика', 'Нахичеванская Автономная Республика'),
(217, 15, 0, 'Бабекский район', 'Бабекский район'),
(218, 15, 0, 'Джульфинский район', 'Джульфинский район'),
(219, 15, 0, 'Ордубадский район', 'Ордубадский район'),
(220, 15, 0, 'Садаракский район', 'Садаракский район'),
(221, 15, 0, 'Шахбузский район', 'Шахбузский район'),
(222, 15, 0, 'Шарурский район', 'Шарурский район'),
(223, 67, 0, 'Харьюский уезд', 'Харьюский уезд'),
(224, 67, 0, 'Хийумааский уезд', 'Хийумааский уезд'),
(225, 67, 0, 'Ида-Вирумааский уезд', 'Ида-Вирумааский уезд'),
(226, 67, 0, 'Ярвамаамааский уезд', 'Ярвамаамааский уезд'),
(227, 67, 0, 'Йыгевамааский уезд', 'Йыгевамааский уезд'),
(228, 67, 0, 'Ляэнемааский уезд', 'Ляэнемааский уезд'),
(229, 67, 0, 'Ляэне-Вирумааский уезд', 'Ляэне-Вирумааский уезд'),
(230, 67, 0, 'Пылвамааский уезд', 'Пылвамааский уезд'),
(231, 67, 0, 'Пярнумааский уезд', 'Пярнумааский уезд'),
(232, 67, 0, 'Рапламааский уезд', 'Рапламааский уезд'),
(233, 67, 0, 'Сааремааский уезд', 'Сааремааский уезд'),
(234, 67, 0, 'Тартумааский уезд', 'Тартумааский уезд'),
(235, 67, 0, 'Валгамааский уезд', 'Валгамааский уезд'),
(236, 67, 0, 'Вильяндимааский уезд', 'Вильяндимааский уезд'),
(237, 67, 0, 'Вырумааский уезд', 'Вырумааский уезд'),
(238, 20, 0, 'Витебская область', 'Витебская область'),
(239, 20, 0, 'Могилевская область', 'Могилевская область'),
(240, 20, 0, 'Минская область', 'Минская область'),
(241, 20, 0, 'Гродненская область', 'Гродненская область'),
(242, 20, 0, 'Гомельская область', 'Гомельская область'),
(243, 20, 0, 'Брестская область', 'Брестская область'),
(244, 11, 0, 'Область Арагацотн', 'Область Арагацотн'),
(245, 11, 0, 'Араратская область', 'Араратская область'),
(246, 11, 0, 'Армавирская область', 'Армавирская область'),
(247, 11, 0, 'Гегаркуникская область', 'Гегаркуникская область'),
(248, 11, 0, 'Ереван', 'Ереван'),
(249, 11, 0, 'Лорийская область', 'Лорийская область'),
(250, 11, 0, 'Котайкская область', 'Котайкская область'),
(251, 11, 0, 'Ширакская область', 'Ширакская область'),
(252, 11, 0, 'Сюникская область', 'Сюникская область'),
(253, 11, 0, 'Область Вайоц Дзор', 'Область Вайоц Дзор'),
(254, 11, 0, 'Тавушская область', 'Тавушская область'),
(255, 80, 0, 'Гурия', 'Гурия'),
(256, 80, 0, 'Имерети', 'Имерети'),
(257, 80, 0, 'Кахети', 'Кахети'),
(258, 80, 0, 'Квемо-Картли', 'Квемо-Картли'),
(259, 80, 0, 'Мцхета-Тианети', 'Мцхета-Тианети'),
(260, 80, 0, 'Рача-Лечхуми - Квемо Сванети', 'Рача-Лечхуми - Квемо Сванети'),
(261, 80, 0, 'Самегрело - Земо-Сванети', 'Самегрело - Земо-Сванети'),
(262, 80, 0, 'Самцхе-Джавахети', 'Самцхе-Джавахети'),
(263, 80, 0, 'Тбилиси', 'Тбилиси'),
(264, 80, 0, 'Шида - Картли', 'Шида - Картли'),
(265, 80, 0, 'Аджарская автономная республика', 'Аджарская автономная республика'),
(266, 80, 0, 'Абхазская автономная республика', 'Абхазская автономная республика'),
(267, 80, 0, 'Республика Южная Осетия', 'Республика Южная Осетия'),
(268, 140, 0, 'Балти', 'Балти'),
(269, 140, 0, 'Единет', 'Единет'),
(270, 140, 0, 'Кагул', 'Кагул'),
(271, 140, 0, 'Кишенёв', 'Кишенёв'),
(272, 140, 0, 'Лапушна', 'Лапушна'),
(273, 140, 0, 'Оргей', 'Оргей'),
(274, 140, 0, 'Сорока', 'Сорока'),
(275, 140, 0, 'Тараклия', 'Тараклия'),
(276, 140, 0, 'Тигина', 'Тигина'),
(277, 140, 0, 'Унгены', 'Унгены'),
(278, 123, 0, 'Алитусский уезд', 'Алитусский уезд'),
(279, 123, 0, 'Каунасский уезд', 'Каунасский уезд'),
(280, 123, 0, 'Kлайпедский уезд', 'Kлайпедский уезд'),
(281, 123, 0, 'Maриямпольский уезд', 'Maриямпольский уезд'),
(282, 123, 0, 'Панявежский уезд', 'Панявежский уезд'),
(283, 123, 0, 'Шяуляйский уезд', 'Шяуляйский уезд'),
(284, 123, 0, 'Таурагский уезд', 'Таурагский уезд'),
(285, 123, 0, 'Tяльшяйский уезд', 'Tяльшяйский уезд'),
(286, 123, 0, 'Утянский уезд', 'Утянский уезд'),
(287, 123, 0, 'Вильнюсский уезд', 'Вильнюсский уезд'),
(288, 117, 0, 'Аизкраукленский', 'Аизкраукленский'),
(289, 117, 0, 'Алуксненский', 'Алуксненский'),
(290, 117, 0, 'Балвский', 'Балвский'),
(291, 117, 0, 'Бауский', 'Бауский'),
(292, 117, 0, 'Валкский', 'Валкский'),
(293, 117, 0, 'Валмиерский', 'Валмиерский'),
(294, 117, 0, 'Вентспилсский', 'Вентспилсский'),
(295, 117, 0, 'Гулбенский', 'Гулбенский'),
(296, 117, 0, 'Давгавпилский', 'Давгавпилский'),
(297, 117, 0, 'Добелский', 'Добелский'),
(298, 117, 0, 'Екабпилский', 'Екабпилский'),
(299, 117, 0, 'Елгавский', 'Елгавский'),
(300, 117, 0, 'Краславский', 'Краславский'),
(301, 117, 0, 'Кулдигский', 'Кулдигский'),
(302, 117, 0, 'Лепайский', 'Лепайский'),
(303, 117, 0, 'Лимбажский', 'Лимбажский'),
(304, 117, 0, 'Ледзенский', 'Ледзенский'),
(305, 117, 0, 'Мадонский', 'Мадонский'),
(306, 117, 0, 'Огрский', 'Огрский'),
(307, 117, 0, 'Прейльский', 'Прейльский'),
(308, 117, 0, 'Резекненский', 'Резекненский'),
(309, 117, 0, 'Рижский', 'Рижский'),
(310, 117, 0, 'Салдуский', 'Салдуский'),
(311, 117, 0, 'Талсинский', 'Талсинский'),
(312, 117, 0, 'Тукумский', 'Тукумский'),
(313, 117, 0, 'Цесиский', 'Цесиский'),
(314, 117, 0, 'Вентспилс', 'Вентспилс'),
(315, 117, 0, 'Даугавпилс', 'Даугавпилс'),
(316, 117, 0, 'Елгава', 'Елгава'),
(317, 117, 0, 'Лиепая', 'Лиепая'),
(318, 117, 0, 'Резекне', 'Резекне'),
(319, 117, 0, 'Рига', 'Рига'),
(320, 117, 0, 'Юрмала', 'Юрмала'),
(321, 223, 0, 'AL', 'Alabama'),
(322, 223, 0, 'AK', 'Alaska'),
(323, 223, 0, 'AS', 'American Samoa'),
(324, 223, 0, 'AZ', 'Arizona'),
(325, 223, 0, 'AR', 'Arkansas'),
(326, 223, 0, 'AF', 'Armed Forces Africa'),
(327, 223, 0, 'AA', 'Armed Forces Americas'),
(328, 223, 0, 'AC', 'Armed Forces Canada'),
(329, 223, 0, 'AE', 'Armed Forces Europe'),
(330, 223, 0, 'AM', 'Armed Forces Middle East'),
(331, 223, 0, 'AP', 'Armed Forces Pacific'),
(332, 223, 0, 'CA', 'California'),
(333, 223, 0, 'CO', 'Colorado'),
(334, 223, 0, 'CT', 'Connecticut'),
(335, 223, 0, 'DE', 'Delaware'),
(336, 223, 0, 'DC', 'District of Columbia'),
(337, 223, 0, 'FM', 'Federated States Of Micronesia'),
(338, 223, 0, 'FL', 'Florida'),
(339, 223, 0, 'GA', 'Georgia'),
(340, 223, 0, 'GU', 'Guam'),
(341, 223, 0, 'HI', 'Hawaii'),
(342, 223, 0, 'ID', 'Idaho'),
(343, 223, 0, 'IL', 'Illinois'),
(344, 223, 0, 'IN', 'Indiana'),
(345, 223, 0, 'IA', 'Iowa'),
(346, 223, 0, 'KS', 'Kansas'),
(347, 223, 0, 'KY', 'Kentucky'),
(348, 223, 0, 'LA', 'Louisiana'),
(349, 223, 0, 'ME', 'Maine'),
(350, 223, 0, 'MH', 'Marshall Islands'),
(351, 223, 0, 'MD', 'Maryland'),
(352, 223, 0, 'MA', 'Massachusetts'),
(353, 223, 0, 'MI', 'Michigan'),
(354, 223, 0, 'MN', 'Minnesota'),
(355, 223, 0, 'MS', 'Mississippi'),
(356, 223, 0, 'MO', 'Missouri'),
(357, 223, 0, 'MT', 'Montana'),
(358, 223, 0, 'NE', 'Nebraska'),
(359, 223, 0, 'NV', 'Nevada'),
(360, 223, 0, 'NH', 'New Hampshire'),
(361, 223, 0, 'NJ', 'New Jersey'),
(362, 223, 0, 'NM', 'New Mexico'),
(363, 223, 0, 'NY', 'New York'),
(364, 223, 0, 'NC', 'North Carolina'),
(365, 223, 0, 'ND', 'North Dakota'),
(366, 223, 0, 'MP', 'Northern Mariana Islands'),
(367, 223, 0, 'OH', 'Ohio'),
(368, 223, 0, 'OK', 'Oklahoma'),
(369, 223, 0, 'OR', 'Oregon'),
(370, 223, 0, 'PW', 'Palau'),
(371, 223, 0, 'PA', 'Pennsylvania'),
(372, 223, 0, 'PR', 'Puerto Rico'),
(373, 223, 0, 'RI', 'Rhode Island'),
(374, 223, 0, 'SC', 'South Carolina'),
(375, 223, 0, 'SD', 'South Dakota'),
(376, 223, 0, 'TN', 'Tennessee'),
(377, 223, 0, 'TX', 'Texas'),
(378, 223, 0, 'UT', 'Utah'),
(379, 223, 0, 'VT', 'Vermont'),
(380, 223, 0, 'VI', 'Virgin Islands'),
(381, 223, 0, 'VA', 'Virginia'),
(382, 223, 0, 'WA', 'Washington'),
(383, 223, 0, 'WV', 'West Virginia'),
(384, 223, 0, 'WI', 'Wisconsin'),
(385, 223, 0, 'WY', 'Wyoming'),
(386, 176, 3, 'Севастополь', 'Севастополь');

DROP TABLE IF EXISTS currencies;
CREATE TABLE `currencies` (
  `id` int(10) auto_increment,
  `active` tinyint(4) default '1',
  `default` tinyint(4) default '0',
  `name` varchar(255) collate utf8_unicode_ci,
  `code` varchar(3) collate utf8_unicode_ci,
  `symbol_left` varchar(48) collate utf8_unicode_ci,
  `symbol_right` varchar(48) collate utf8_unicode_ci,
  `decimal_point` char(1) collate utf8_unicode_ci,
  `thousands_point` char(1) collate utf8_unicode_ci,
  `decimal_places` char(1) collate utf8_unicode_ci,
  `value` float,
  `created` datetime,
  `modified` datetime,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `currencies` (`id`, `active`, `default`, `name`, `code`, `symbol_left`, `symbol_right`, `decimal_point`, `thousands_point`, `decimal_places`, `value`, `created`, `modified`) VALUES 
(1, 1, 1, 'US Dollar', 'USD', '$', '', '.', '', '0', 1, '2009-07-15 11:39:15', '2009-07-15 13:08:23'),
(2, 0, 0, 'Рубль', 'RUB', '', 'руб.', '.', '', '0', 1, '2009-07-15 11:39:15', '2009-07-15 13:08:23');

DROP TABLE IF EXISTS email_templates;
CREATE TABLE `email_templates` (
  `id` int(10) auto_increment,
  `alias` varchar(255) collate utf8_unicode_ci,
  `default` int(4),
  `order` int(4),
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `email_templates` (`id`, `alias`, `default`, `order`) VALUES
(1, 'new-order', 0, 1),
(2, 'new-order-status', 0, 2),
(3, 'new-customer', 0, 3),
(4, 'abandoned-cart', 0, 4),
(5, 'ask_a_product_question', 0, 5),
(6, 'one_click_buy', 0, 6),
(7, 'password_recovery_verification', 0, 7),
(8, 'password_recovery_new_password', 0, 8);

DROP TABLE IF EXISTS email_template_descriptions;
CREATE TABLE `email_template_descriptions` (
  `id` int(10) auto_increment,
  `email_template_id` int(10),
  `language_id` int(10),
  `subject` varchar(255) collate utf8_unicode_ci,
  `content` text collate utf8_unicode_ci,
  PRIMARY KEY  (`id`),
  INDEX email_template_id (email_template_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `email_template_descriptions` (`id`, `email_template_id`, `language_id`, `subject`, `content`) VALUES
(1, 1, 1, 'Your order #{$order_number}', 'Dear {$firstname}!<br /><br />Your order confirmed!<br />Order number: {$order_number}<br /><br />Products:<br />{foreach item=products from=$order_products}<br />{$products.quantity} x {$products.name} = {$products.total}<br />{if $products.filename != ""}{lang}Download link:{/lang} {$smarty.const.FULL_BASE_URL}{$smarty.const.BASE}/download/{$order_number}/{$products.id}/{$products.download_key}{/if}<br />{/foreach}<br /><br />{lang}{$shipping_method}{/lang}:  {$shipping_total}<br />{lang}Order Total:{/lang} {$order_total}<br /><br />Shipping Method: {$shipping_method}<br />{$shipping_method_description}<br /><br />Payment Method: {$payment_method}<br />{$payment_method_description}<br /><br />Customer: {$bill_name}<br />Phone: {$phone}<br />Email: {$email}<br /><br />Shipping Address:<br />{$bill_zip}, {$bill_state}, {$bill_city}<br />{$bill_line_1} {$bill_line_2}<br /><br />{$comments}<br /><br />Thank you!<br /><br />'),
(2, 1, 2, 'Ваш заказ №{$order_number}', 'Здравствуйте, {$firstname}!<br /><br />Ваш заказ подтверждён.<br />Номер заказа: {$order_number}<br /><br />Заказанные товары:<br />{foreach item=products from=$order_products}<br />{$products.quantity} x {$products.name} = {$products.total}<br />{if $products.filename != ""}{lang}Download link:{/lang} {$smarty.const.FULL_BASE_URL}{$smarty.const.BASE}/download/{$order_number}/{$products.id}/{$products.download_key}{/if}<br />{/foreach}<br /><br />{lang}{$shipping_method}{/lang}:  {$shipping_total}<br />{lang}Order Total:{/lang} {$order_total}<br /><br />Способ доставки: {$shipping_method}<br />{$shipping_method_description}<br /><br />Способ оплаты: {$payment_method}<br />{$payment_method_description}<br /><br />Покупатель: {$bill_name}<br />Телефон: {$phone}<br />Email: {$email}<br /><br />Адрес доставки:<br />{$bill_zip}, {$bill_state}, {$bill_city}<br />{$bill_line_1} {$bill_line_2}<br /><br />{$comments}<br /><br />Спасибо!'),
(3, 2, 1, 'Order #{$order_number}: Status Changed', 'Dear {$firstname}!<br /><br />Thank you!<br /><br />New Order Status: {$order_status}<br /><br />{$comments}<br /><br />Order number: {$order_number}<br /><br />Products:<br />{foreach item=products from=$order_products}<br />{$products.quantity} x {$products.name} = {$products.total}<br />{if $products.filename != ""}{lang}Download link:{/lang} {$smarty.const.FULL_BASE_URL}{$smarty.const.BASE}/download/{$order_number}/{$products.id}/{$products.download_key}{/if}<br />{/foreach}<br /><br />{lang}{$shipping_method}{/lang}:  {$shipping_total}<br />{lang}Order Total:{/lang} {$order_total}<br /><br />Shipping Method: {$shipping_method}<br />{$shipping_method_description}<br /><br />Payment Method: {$payment_method}<br />{$payment_method_description}<br /><br />Customer: {$bill_name}<br />Phone: {$phone}<br />Email: {$email}<br /><br />Shipping Address:<br />{$bill_zip}, {$bill_state}, {$bill_city}<br />{$bill_line_1} {$bill_line_2}'),
(4, 2, 2, 'Изменён статус Вашего заказа №{$order_number}', 'Здравствуйте, {$firstname}!<br /><br />Спасибо за Ваш заказ!<br /><br />Статус Вашего заказа изменён.<br /><br />Новый статус заказа: {$order_status}<br /><br />{$comments}<br /><br />Номер заказа: {$order_number}<br /><br />Заказанные товары:<br />{foreach item=products from=$order_products}<br />{$products.quantity} x {$products.name} = {$products.total}<br />{if $products.filename != ""}{lang}Download link:{/lang} {$smarty.const.FULL_BASE_URL}{$smarty.const.BASE}/download/{$order_number}/{$products.id}/{$products.download_key}{/if}<br />{/foreach}<br /><br />{lang}{$shipping_method}{/lang}:  {$shipping_total}<br />{lang}Order Total:{/lang} {$order_total}<br /><br />Способ доставки: {$shipping_method}<br />{$shipping_method_description}<br /><br />Способ оплаты: {$payment_method}<br />{$payment_method_description}<br /><br />Покупатель: {$bill_name}<br />Телефон: {$phone}<br />Email: {$email}<br /><br />Адрес доставки:<br />{$bill_zip}, {$bill_state}, {$bill_city}<br />{$bill_line_1} {$bill_line_2}'),
(5, 3, 1, 'Registration', 'Hello {$firstname}!<br /><br />Thank you for registration!<br /><br />E-mail: {$email}<br />Password: {$password}'),
(6, 3, 2, 'Регистрация', 'Здравствуйте, {$firstname}!<br /><br />Благодарим за регистрацию!<br /><br />Ваши даные для входа:<br /><br />E-mail: {$email}<br />Пароль: {$password}<br /><br />В своём аккаунте Вы можете следить за этапами оформления и доставки Вашего заказа!'),
(7, 4, 1, 'Abandoned cart', 'Thank you for stopping by {$store_name} and considering us for your purchase.<br /><br />We noticed that during a visit to our store you placed the following item(s) in your shopping cart, but did not complete the transaction.<br /><br />Shopping Cart Contents:<br />{foreach item=products from=$order_products}<br />{$products.quantity} x {$products.name} = {$products.total}<br />{if $products.filename != ""}{lang}Download link:{/lang} {$smarty.const.FULL_BASE_URL}{$smarty.const.BASE}/download/{$order_number}/{$products.id}/{$products.download_key}{/if}<br />{/foreach}<br /><br />{lang}{$shipping_method}{/lang}:  {$shipping_total}<br />{lang}Order Total:{/lang} {$order_total}<br /><br />{$comments}<br /><br />We are always interested in knowing what happened and if there was a reason that you decided not to purchase at this time. If you could be so kind as to let us know if you had any issues or concerns, we would appreciate it.  We are asking for feedback from you and others as to how we can help make your experience at {$store_name} better.<br /><br />PLEASE NOTE: If you believe you completed your purchase and are wondering why it was not delivered, this email is an indication that your order was NOT completed, and that you have NOT been charged! Please return to the store in order to complete your order.<br /><br />Our apologies if you already completed your purchase, we try not to send these messages in those cases, but sometimes it is hard for us to tell depending on individual circumstances.<br /><br />Again, thank you for your time and consideration in helping us improve {$store_name}.'),
(8, 4, 2, 'Незавершённый заказ', 'Здравствуйте!<br /><br />Вы начинали оформлять заказ в интернет-магазине {$store_name}, но так и не оформили его до конца!<br /><br />Нам было бы интересно узнать, почему Вы так и не оформили его до конца?<br /><br />Если у Вас в процессе оформления заказа возникли какие-либо проблемы, мы всегда готовы Вам помочь с оформлением заказа и с удовольствием ответим на возникшие вопросы. <br /><br />Задайте нам их в ответном письме, мы поможем Вам оформить заказ.<br /><br />Товар, который Вы заказывали:<br />{foreach item=products from=$order_products}<br />{$products.quantity} x {$products.name} = {$products.total}<br />{if $products.filename != ""}{lang}Download link:{/lang} {$smarty.const.FULL_BASE_URL}{$smarty.const.BASE}/download/{$order_number}/{$products.id}/{$products.download_key}{/if}<br />{/foreach}<br /><br />{lang}{$shipping_method}{/lang}:  {$shipping_total}<br />{lang}Order Total:{/lang} {$order_total}<br /><br />{$comments}'),
(9, 5, 1, 'Ask a product question - {$product_name}', 'Hello!<br /><br />Thank you for your question! We''ll reply you shortly.<br /><br />Product name: {$product_name}<br /><br />Your question:<br /><br />{$question}'),
(10, 5, 2, 'Задать вопрос о товаре - {$product_name}', 'Здравствуйте!<br /><br />Спасибо за Ваш вопрос! Мы ответим Вам в самое ближайшее время.<br /><br />Название товара: {$product_name}<br /><br />Ваш вопрос:<br /><br />{$question}'),
(11, 6, 1, 'One Click Buy - {$product_name}', 'Hello!<br /><br />Thank you for stopping by {$store_name} and considering us for your purchase. Ordered product:<br /><br />{$product_name}<br /><br />Contact information: {$contact}'),
(12, 6, 2, 'Купить за 1 клик - {$product_name}', 'Здравствуйте!<br /><br />Вы оформили заказ в интернет-магазине {$store_name}!<br /><br />Товар, который Вы заказали:<br /><br />{$product_name}<br /><br />Контактные данные: {$contact}'),
(13, 7, 1, 'Confirmation mail for password renewal', 'Please confirm your password request!<br /><br />Please confirm,that you personally required a new password. <br />For this reason we sent this email with a personal confirmation link. <br />If you confirm the link, by clicking it, immediately a new password <br />is sent to you in a further email at the disposal.<br />      <br />Your confirmation link: {$link}<br />'),
(14, 7, 2, 'Подтверждение emaill для отправки нового пароля', 'Пожалуйста, подтвердите Ваш запрос!<br /><br />Подтвердите, что Вы запросили новый пароль. <br />Для этого перейдите по ссылке подтверждения. <br />Если Вы подтвердите Ваш запрос, перейдя по ссылке, Вы получите новый пароль на свой e-mail.<br />      <br />Ваша ссылка подтверждения: {$link}'),
(15, 8, 1, 'Your new password', 'This is your login credentials:<br /><br />E-mail: {$email}<br />Password: {$password}<br /><br />Account page: {$account_page}'),
(16, 8, 2, 'Ваш новый пароль', 'Ваши данные для входа:<br /><br />E-mail: {$email}<br />Пароль: {$password}<br /><br />Вход в личный кабинет: {$account_page}');

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
  PRIMARY KEY  (`id`),
  INDEX answer_template_id (answer_template_id)
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
  `is_show_var` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX content_id (`content_id`),
  INDEX parent_id (`parent_id`),
  INDEX order_id (`order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `attributes` VALUES 
(1,0,39,\N,\N,1,4,\N,0,1,1,1,0),
(2,1,0,'list_value','',1,\N,'0',0,\N,\N,\N,\N),
(3,1,0,'list_value','',2,\N,'0',0,\N,\N,\N,\N),
(4,1,0,'list_value','',3,\N,'0',0,\N,\N,\N,\N),
(5,0,39,\N,\N,2,4,\N,0,1,1,1,0),
(6,5,0,'list_value','',1,\N,'0',0,\N,\N,\N,\N),
(7,5,0,'list_value','',2,\N,'0',0,\N,\N,\N,\N),
(8,5,0,'list_value','',3,\N,'0',0,\N,\N,\N,\N),
(9,0,39,\N,\N,3,4,\N,0,1,1,1,0),
(10,9,0,'list_value','',1,\N,'0',0,\N,\N,\N,\N),
(11,9,0,'list_value','',2,\N,'0',0,\N,\N,\N,\N),
(12,9,0,'list_value','',3,\N,'0',0,\N,\N,\N,\N),
(13,0,39,\N,\N,4,4,\N,0,1,1,1,0),
(14,13,0,'list_value','',1,\N,'0',0,\N,\N,\N,\N),
(15,13,0,'list_value','',2,\N,'0',0,\N,\N,\N,\N),
(16,13,0,'list_value','',3,\N,'0',0,\N,\N,\N,\N),
(17,0,39,\N,\N,5,4,\N,0,1,1,1,1),
(18,17,0,'list_value','',1,\N,'0',0,\N,\N,\N,\N),
(19,17,0,'list_value','',2,\N,'0',0,\N,\N,\N,\N),
(20,17,0,'list_value','',3,\N,'0',0,\N,\N,\N,\N),
(21,2,95,\N,'1',\N,\N,\N,\N,\N,\N,\N,\N),
(22,3,95,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(23,4,95,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(24,6,95,\N,'1',\N,\N,\N,\N,\N,\N,\N,\N),
(25,7,95,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(26,8,95,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(27,10,95,\N,'1',\N,\N,\N,\N,\N,\N,\N,\N),
(28,11,95,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(29,12,95,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(30,14,95,\N,'1',\N,\N,\N,\N,\N,\N,\N,\N),
(31,15,95,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(32,16,95,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(33,18,95,\N,'1',\N,\N,\N,\N,\N,\N,\N,\N),
(34,19,95,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(35,20,95,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(36,2,96,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(37,3,96,\N,'1',\N,\N,\N,\N,\N,\N,\N,\N),
(38,4,96,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(39,6,96,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(40,7,96,\N,'1',\N,\N,\N,\N,\N,\N,\N,\N),
(41,8,96,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(42,10,96,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(43,11,96,\N,'1',\N,\N,\N,\N,\N,\N,\N,\N),
(44,12,96,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(45,14,96,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(46,15,96,\N,'1',\N,\N,\N,\N,\N,\N,\N,\N),
(47,16,96,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(48,18,96,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(49,19,96,\N,'1',\N,\N,\N,\N,\N,\N,\N,\N),
(50,20,96,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(51,2,97,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(52,3,97,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(53,4,97,\N,'1',\N,\N,\N,\N,\N,\N,\N,\N),
(54,6,97,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(55,7,97,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(56,8,97,\N,'1',\N,\N,\N,\N,\N,\N,\N,\N),
(57,10,97,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(58,11,97,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(59,12,97,\N,'1',\N,\N,\N,\N,\N,\N,\N,\N),
(60,14,97,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(61,15,97,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(62,16,97,\N,'1',\N,\N,\N,\N,\N,\N,\N,\N),
(63,18,97,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(64,19,97,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(65,20,97,\N,'1',\N,\N,\N,\N,\N,\N,\N,\N),
(66,0,36,\N,\N,1,2,\N,0,1,1,1,0),
(67,0,36,\N,\N,2,2,\N,0,1,1,1,0),
(68,0,36,\N,\N,3,2,\N,0,1,1,1,0),
(69,0,36,\N,\N,4,2,\N,0,1,1,1,0),
(70,0,36,\N,\N,5,2,\N,0,1,1,1,1),
(71,0,43,\N,\N,1,4,\N,0,1,1,1,0),
(72,0,43,\N,\N,2,4,\N,0,1,1,1,0),
(73,0,43,\N,\N,3,4,\N,0,1,1,1,0),
(74,0,43,\N,\N,4,4,\N,0,1,1,1,0),
(75,0,43,\N,\N,5,4,\N,0,1,1,1,1),
(76,66,0,'list_value','',1,\N,'0',0,\N,\N,\N,\N),
(77,66,0,'list_value','',2,\N,'0',0,\N,\N,\N,\N),
(78,66,0,'list_value','',3,\N,'0',0,\N,\N,\N,\N),
(79,67,0,'list_value','',1,\N,'0',0,\N,\N,\N,\N),
(80,67,0,'list_value','',2,\N,'0',0,\N,\N,\N,\N),
(81,67,0,'list_value','',3,\N,'0',0,\N,\N,\N,\N),
(82,68,0,'list_value','',1,\N,'0',0,\N,\N,\N,\N),
(83,68,0,'list_value','',2,\N,'0',0,\N,\N,\N,\N),
(84,68,0,'list_value','',3,\N,'0',0,\N,\N,\N,\N),
(85,69,0,'list_value','',1,\N,'0',0,\N,\N,\N,\N),
(86,69,0,'list_value','',2,\N,'0',0,\N,\N,\N,\N),
(87,69,0,'list_value','',3,\N,'0',0,\N,\N,\N,\N),
(88,70,0,'list_value','',1,\N,'0',0,\N,\N,\N,\N),
(89,70,0,'list_value','',2,\N,'0',0,\N,\N,\N,\N),
(90,76,38,\N,'1',\N,\N,\N,\N,\N,\N,\N,\N),
(91,77,38,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(92,78,38,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(93,79,38,\N,'1',\N,\N,\N,\N,\N,\N,\N,\N),
(94,80,38,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(95,81,38,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(96,82,38,\N,'1',\N,\N,\N,\N,\N,\N,\N,\N),
(97,83,38,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(98,84,38,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(99,85,38,\N,'1',\N,\N,\N,\N,\N,\N,\N,\N),
(100,86,38,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(101,87,38,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(102,88,38,\N,'1',\N,\N,\N,\N,\N,\N,\N,\N),
(103,89,38,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(104,76,94,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(105,77,94,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(106,78,94,\N,'1',\N,\N,\N,\N,\N,\N,\N,\N),
(107,79,94,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(108,80,94,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(109,81,94,\N,'1',\N,\N,\N,\N,\N,\N,\N,\N),
(110,82,94,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(111,83,94,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(112,84,94,\N,'1',\N,\N,\N,\N,\N,\N,\N,\N),
(113,85,94,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(114,86,94,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(115,87,94,\N,'1',\N,\N,\N,\N,\N,\N,\N,\N),
(116,88,94,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(117,89,94,\N,'1',\N,\N,\N,\N,\N,\N,\N,\N),
(118,76,93,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(119,77,93,\N,'1',\N,\N,\N,\N,\N,\N,\N,\N),
(120,78,93,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(121,79,93,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(122,80,93,\N,'1',\N,\N,\N,\N,\N,\N,\N,\N),
(123,81,93,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(124,82,93,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(125,83,93,\N,'1',\N,\N,\N,\N,\N,\N,\N,\N),
(126,84,93,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(127,85,93,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(128,86,93,\N,'1',\N,\N,\N,\N,\N,\N,\N,\N),
(129,87,93,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(130,88,93,\N,'1',\N,\N,\N,\N,\N,\N,\N,\N),
(131,89,93,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(132,71,0,'list_value','',1,\N,'0',0,\N,\N,\N,\N),
(133,71,0,'list_value','',2,\N,'0',0,\N,\N,\N,\N),
(134,71,0,'list_value','',3,\N,'0',0,\N,\N,\N,\N),
(135,72,0,'list_value','',1,\N,'0',0,\N,\N,\N,\N),
(136,72,0,'list_value','',2,\N,'0',0,\N,\N,\N,\N),
(137,72,0,'list_value','',3,\N,'0',0,\N,\N,\N,\N),
(138,73,0,'list_value','',1,\N,'0',0,\N,\N,\N,\N),
(139,73,0,'list_value','',2,\N,'0',0,\N,\N,\N,\N),
(140,73,0,'list_value','',3,\N,'0',0,\N,\N,\N,\N),
(141,74,0,'list_value','',1,\N,'0',0,\N,\N,\N,\N),
(142,74,0,'list_value','',2,\N,'0',0,\N,\N,\N,\N),
(143,74,0,'list_value','',3,\N,'0',0,\N,\N,\N,\N),
(144,75,0,'list_value','',1,\N,'0',0,\N,\N,\N,\N),
(145,75,0,'list_value','',2,\N,'0',0,\N,\N,\N,\N),
(146,75,0,'list_value','',3,\N,'0',0,\N,\N,\N,\N),
(147,132,98,\N,'1',\N,\N,\N,\N,\N,\N,\N,\N),
(148,133,98,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(149,134,98,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(150,135,98,\N,'1',\N,\N,\N,\N,\N,\N,\N,\N),
(151,136,98,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(152,137,98,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(153,138,98,\N,'1',\N,\N,\N,\N,\N,\N,\N,\N),
(154,139,98,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(155,140,98,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(156,141,98,\N,'1',\N,\N,\N,\N,\N,\N,\N,\N),
(157,142,98,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(158,143,98,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(159,144,98,\N,'1',\N,\N,\N,\N,\N,\N,\N,\N),
(160,145,98,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(161,146,98,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(162,132,99,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(163,133,99,\N,'1',\N,\N,\N,\N,\N,\N,\N,\N),
(164,134,99,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(165,135,99,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(166,136,99,\N,'1',\N,\N,\N,\N,\N,\N,\N,\N),
(167,137,99,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(168,138,99,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(169,139,99,\N,'1',\N,\N,\N,\N,\N,\N,\N,\N),
(170,140,99,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(171,141,99,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(172,142,99,\N,'1',\N,\N,\N,\N,\N,\N,\N,\N),
(173,143,99,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(174,144,99,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(175,145,99,\N,'1',\N,\N,\N,\N,\N,\N,\N,\N),
(176,146,99,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(177,132,100,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(178,133,100,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(179,134,100,\N,'1',\N,\N,\N,\N,\N,\N,\N,\N),
(180,135,100,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(181,136,100,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(182,137,100,\N,'1',\N,\N,\N,\N,\N,\N,\N,\N),
(183,138,100,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(184,139,100,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(185,140,100,\N,'1',\N,\N,\N,\N,\N,\N,\N,\N),
(186,141,100,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(187,142,100,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(188,143,100,\N,'1',\N,\N,\N,\N,\N,\N,\N,\N),
(189,144,100,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(190,145,100,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(191,146,100,\N,'1',\N,\N,\N,\N,\N,\N,\N,\N),
(192,0,101,\N,\N,1,4,\N,0,1,0,0,0),
(193,192,0,'list_value','',1,\N,'0',0,\N,\N,\N,\N),
(194,192,0,'list_value','',2,\N,'0',0,\N,\N,\N,\N),
(195,192,0,'list_value','',3,\N,'0',0,\N,\N,\N,\N),
(196,193,102,\N,'1',\N,\N,\N,\N,\N,\N,\N,\N),
(197,194,102,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(198,195,102,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(199,193,103,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(200,194,103,\N,'1',\N,\N,\N,\N,\N,\N,\N,\N),
(201,195,103,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(202,193,104,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(203,194,104,\N,'0',\N,\N,\N,\N,\N,\N,\N,\N),
(204,195,104,\N,'1',\N,\N,\N,\N,\N,\N,\N,\N)	;

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
  PRIMARY KEY (`dsc_id`),
  INDEX attribute_id (attribute_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `attribute_descriptions` VALUES 
(1,1,1,'Display',\N,\N,\N,\N),
(2,1,2,'Экран',\N,\N,\N,\N),
(3,2,1,'5.7\" 1920 x 1080',\N,\N,\N,\N),
(4,2,2,'5.7\" 1920 x 1080',\N,\N,\N,\N),
(5,3,1,'5\" 1920 x 1080',\N,\N,\N,\N),
(6,3,2,'5\" 1920 x 1080',\N,\N,\N,\N),
(7,4,1,'4\" 800 x 480',\N,\N,\N,\N),
(8,4,2,'4\" 800 x 480',\N,\N,\N,\N),
(9,5,1,'Battery',\N,\N,\N,\N),
(10,5,2,'Батарея',\N,\N,\N,\N),
(11,6,1,'3200 mAh',\N,\N,\N,\N),
(12,6,2,'3200 мАч',\N,\N,\N,\N),
(13,7,1,'2600 mAh',\N,\N,\N,\N),
(14,7,2,'2600 мАч',\N,\N,\N,\N),
(15,8,1,'1500 mAh',\N,\N,\N,\N),
(16,8,2,'1500 мАч',\N,\N,\N,\N),
(17,9,1,'Dimensions',\N,\N,\N,\N),
(18,9,2,'Размеры',\N,\N,\N,\N),
(19,10,1,'151,2 х 79,2 х 8,3 mm',\N,\N,\N,\N),
(20,10,2,'151,2 х 79,2 х 8,3 мм',\N,\N,\N,\N),
(21,11,1,'136,6 x 69,8 x 7,9 mm',\N,\N,\N,\N),
(22,11,2,'136,6 x 69,8 x 7,9 мм',\N,\N,\N,\N),
(23,12,1,'121,20 x 62,70 x 9,79 mm',\N,\N,\N,\N),
(24,12,2,'121,20 x 62,70 x 9,79 мм',\N,\N,\N,\N),
(25,13,1,'Weight',\N,\N,\N,\N),
(26,13,2,'Вес',\N,\N,\N,\N),
(27,14,1,'168 g.',\N,\N,\N,\N),
(28,14,2,'168 г.',\N,\N,\N,\N),
(29,15,1,'130 g.',\N,\N,\N,\N),
(30,15,2,'130 г.',\N,\N,\N,\N),
(31,16,1,'115 g.',\N,\N,\N,\N),
(32,16,2,'115 г.',\N,\N,\N,\N),
(33,17,1,'Storage',\N,\N,\N,\N),
(34,17,2,'Память',\N,\N,\N,\N),
(35,18,1,'32 GB',\N,\N,\N,\N),
(36,18,2,'32 ГБ',\N,\N,\N,\N),
(37,19,1,'16 GB',\N,\N,\N,\N),
(38,19,2,'16 ГБ',\N,\N,\N,\N),
(39,20,1,'4 GB',\N,\N,\N,\N),
(40,20,2,'4 ГБ',\N,\N,\N,\N),
(41,66,1,'Display',\N,\N,\N,\N),
(42,66,2,'Экран',\N,\N,\N,\N),
(43,67,1,'Battery',\N,\N,\N,\N),
(44,67,2,'Батарея',\N,\N,\N,\N),
(45,68,1,'Dimensions',\N,\N,\N,\N),
(46,68,2,'Размеры',\N,\N,\N,\N),
(47,69,1,'Weight',\N,\N,\N,\N),
(48,69,2,'Вес',\N,\N,\N,\N),
(49,70,1,'Storage',\N,\N,\N,\N),
(50,70,2,'Память',\N,\N,\N,\N),
(51,71,1,'Display',\N,\N,\N,\N),
(52,71,2,'Экран',\N,\N,\N,\N),
(53,72,1,'Battery',\N,\N,\N,\N),
(54,72,2,'Батарея',\N,\N,\N,\N),
(55,73,1,'Dimensions',\N,\N,\N,\N),
(56,73,2,'Размеры',\N,\N,\N,\N),
(57,74,1,'Weight',\N,\N,\N,\N),
(58,74,2,'Вес',\N,\N,\N,\N),
(59,75,1,'Storage',\N,\N,\N,\N),
(60,75,2,'Память',\N,\N,\N,\N),
(61,76,1,'10.1\" 1280 x 800',\N,\N,\N,\N),
(62,76,2,'10.1\" 1280 x 800',\N,\N,\N,\N),
(63,77,1,'10.1\" 2560 х 1600',\N,\N,\N,\N),
(64,77,2,'10.1\" 2560 х 1600',\N,\N,\N,\N),
(65,78,1,'8.0\" 1280 x 800',\N,\N,\N,\N),
(66,78,2,'8.0\" 1280 x 800',\N,\N,\N,\N),
(67,79,1,'6 800 mAh',\N,\N,\N,\N),
(68,79,2,'6 800 мАч',\N,\N,\N,\N),
(69,80,1,'8 220 mAh',\N,\N,\N,\N),
(70,80,2,'8 220 мАч',\N,\N,\N,\N),
(71,81,1,'4 600 mAh',\N,\N,\N,\N),
(72,81,2,'4 600 мАч',\N,\N,\N,\N),
(73,82,1,'176,10 x 243,10 x 7,95 mm',\N,\N,\N,\N),
(74,82,2,'176,10 x 243,10 x 7,95 мм',\N,\N,\N,\N),
(75,83,1,'171,4 х 243,1 х 7,9 mm',\N,\N,\N,\N),
(76,83,2,'171,4 х 243,1 х 7,9 мм',\N,\N,\N,\N),
(77,84,1,'135,90 x 210,80 x 7,95 mm',\N,\N,\N,\N),
(78,84,2,'135,90 x 210,80 x 7,95 мм',\N,\N,\N,\N),
(79,85,1,'512 g.',\N,\N,\N,\N),
(80,85,2,'512 г.',\N,\N,\N,\N),
(81,86,1,'547 g.',\N,\N,\N,\N),
(82,86,2,'547 г.',\N,\N,\N,\N),
(83,87,1,'345 g.',\N,\N,\N,\N),
(84,87,2,'345 г.',\N,\N,\N,\N),
(85,88,1,'32 GB',\N,\N,\N,\N),
(86,88,2,'32 ГБ',\N,\N,\N,\N),
(87,89,1,'16 GB',\N,\N,\N,\N),
(88,89,2,'16 ГБ',\N,\N,\N,\N),
(89,132,1,'15,0\" 1600 x 900',\N,\N,\N,\N),
(90,132,2,'15,0\" 1600 x 900',\N,\N,\N,\N),
(91,133,1,'11,6\" 1366 x 768',\N,\N,\N,\N),
(92,133,2,'11,6\" 1366 x 768',\N,\N,\N,\N),
(93,134,1,'15,6\" 1366 x 768',\N,\N,\N,\N),
(94,134,2,'15,6\" 1366 x 768',\N,\N,\N,\N),
(95,135,1,'8 cell, 62Wh',\N,\N,\N,\N),
(96,135,2,'8 ячеек, 62 Вт*ч',\N,\N,\N,\N),
(97,136,1,'2 cell, 30Wh',\N,\N,\N,\N),
(98,136,2,'2 ячейки, 30 Вт*ч',\N,\N,\N,\N),
(99,137,1,'3 cell, 43Wh',\N,\N,\N,\N),
(100,137,2,'3 ячейки, 43 Вт*ч',\N,\N,\N,\N),
(101,138,1,'356,9 x 237,0 x 14,9 mm',\N,\N,\N,\N),
(102,138,2,'356,9 x 237,0 x 14,9 мм',\N,\N,\N,\N),
(103,139,1,'304,0 x 189,4 x 9,9 mm',\N,\N,\N,\N),
(104,139,2,'304,0 x 189,4 x 9,9 мм',\N,\N,\N,\N),
(105,140,1,'376,0 x 248,0 x 22,9 mm',\N,\N,\N,\N),
(106,140,2,'376,0 x 248,0 x 22,9 мм',\N,\N,\N,\N),
(107,141,1,'1,65 kg.',\N,\N,\N,\N),
(108,141,2,'1,65 кг.',\N,\N,\N,\N),
(109,142,1,'0,744 kg.',\N,\N,\N,\N),
(110,142,2,'0,744 кг.',\N,\N,\N,\N),
(111,143,1,'1,99 kg.',\N,\N,\N,\N),
(112,143,2,'1,99 кг.',\N,\N,\N,\N),
(113,144,1,'256 GB SSD',\N,\N,\N,\N),
(114,144,2,'256 ГБ SSD',\N,\N,\N,\N),
(115,145,1,'64 GB SSD ',\N,\N,\N,\N),
(116,145,2,'64 ГБ SSD',\N,\N,\N,\N),
(117,146,1,'500 GB HDD',\N,\N,\N,\N),
(118,146,2,'500 ГБ HDD',\N,\N,\N,\N),
(119,192,1,'Color',\N,\N,\N,\N),
(120,192,2,'Цвет',\N,\N,\N,\N),
(121,193,1,'Orange',\N,\N,\N,\N),
(122,193,2,'Оранжевый',\N,\N,\N,\N),
(123,194,1,'Brown',\N,\N,\N,\N),
(124,194,2,'Коричневый',\N,\N,\N,\N),
(125,195,1,'Black',\N,\N,\N,\N),
(126,195,2,'Чёрный',\N,\N,\N,\N)	;

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

INSERT INTO `attribute_templates` (`id`, `name`, `default`, `template_filter`, `template_editor`, `template_catalog`, `template_product`, `template_compare`, `setting`) VALUES
(1, 'value', NULL, '<div class="form-group">\r\n<div class="checkbox">\r\n  <label>\r\n    <input id="activebox{$id_attribute}" {if $is_active == 1} checked="checked" {/if} type="checkbox" disabled>\r\n    {$name_attribute}\r\n  </label>\r\n</div>\r\n</div>\r\n<input id="activeval{$id_attribute}" name="data[values_f][{$id_attribute}][is_active]" {if $is_active == 1} value="1" {/if} type="hidden">\r\n<div class="form-group">\r\n	<label class="sr-only">{$name_attribute}</label>\r\n	<input name="data[values_f][{$id_attribute}][data][{$values_attribute.dig_value.id}][value]" value="{$values_attribute.dig_value.val}" id="value{$id_attribute}" type="text" class="form-control">\r\n	<input name="data[values_f][{$id_attribute}][data][{$values_attribute.dig_value.id}][type_attr]" value="{$values_attribute.dig_value.type_attr}" type="hidden">\r\n	<input name="data[values_f][{$id_attribute}][data][{$values_attribute.dig_value.id}][id]" value="{$values_attribute.dig_value.id}" type="hidden">\r\n</div>\r\n<script>\r\n$(function($){\r\n  $("#value{$id_attribute}").on("change",function() {\r\n    $("#activebox{$id_attribute}").attr("checked",true);\r\n    $("#activeval{$id_attribute}").attr("value","1");\r\n  });\r\n});  \r\n</script>', '<div class="input text">\r\n  <label>{$name_attribute}</label>\r\n  <input name="data[values_s][{$id_attribute}][data][{$values_attribute.dig_value.parent_id}][value]" value="{$values_attribute.dig_value.val}" id="value{$id_attribute}" type="text">\r\n  <input name="data[values_s][{$id_attribute}][data][{$values_attribute.dig_value.parent_id}][type_attr]" value="{$values_attribute.dig_value.type_attr}" type="hidden">\r\n  <input name="data[values_s][{$id_attribute}][data][{$values_attribute.dig_value.parent_id}][id]" value="{$values_attribute.dig_value.id}" type="hidden">\r\n  <input name="data[values_s][{$id_attribute}][data][{$values_attribute.dig_value.parent_id}][parent_id]" value="{$values_attribute.dig_value.parent_id}" type="hidden">\r\n</div>', '{$name_attribute}:	{$values_attribute.set_val}', '{$name_attribute}:	{$values_attribute.set_val}', '{$values_attribute.dig_value.val}', 'a:7:{s:9:"dig_value";s:1:"1";s:9:"max_value";s:1:"0";s:9:"min_value";s:1:"0";s:10:"like_value";s:1:"0";s:10:"list_value";s:1:"0";s:12:"checked_list";s:1:"0";s:9:"any_value";s:1:"0";}'),
(2, 'radio', NULL, '<div class="form-group">\r\n<div class="checkbox">\r\n  <label>\r\n    <input id="activebox{$id_attribute}" {if $is_active == 1} checked="checked" {/if} aria-hidden="true" type="checkbox" disabled>\r\n    {$name_attribute}\r\n  </label>\r\n</div>\r\n</div>\r\n<input id="activeval{$id_attribute}" name="data[values_f][{$id_attribute}][is_active]" {if $is_active == 1} value="1" {/if} type="hidden" aria-hidden="true">\r\n{foreach from=$values_attribute item=val}\r\n<div class="form-group">\r\n<div class="radio">\r\n    <label {if $val.disable} style="color: gray;" {/if}>\r\n      <input type="radio" {if $val.val == 1 && $is_active == 1} checked="checked" {/if} name="data[values_f][{$id_attribute}][set]" value="{$val.id}" id="value{$val.id}" class="radio{$id_attribute} filter-value">\r\n      {$val.name}\r\n    </label>\r\n</div>\r\n</div>\r\n<input name="data[values_f][{$id_attribute}][data][{$val.id}][type_attr]" value="{$val.type_attr}" type="hidden" aria-hidden="true">\r\n<input name="data[values_f][{$id_attribute}][data][{$val.id}][id]" value="{$val.id}" type="hidden" aria-hidden="true">\r\n{/foreach}\r\n<script>\r\n$(function($){\r\n  $(".radio{$id_attribute}").on("change",function() {\r\n    $("#activebox{$id_attribute}").attr("checked",true);\r\n    $("#activeval{$id_attribute}").attr("value","1");\r\n    $("#filterbutton").click();\r\n  });\r\n});  \r\n</script>\r\n', '<div class="radio">\r\n{$name_attribute}\r\n{foreach from=$values_attribute item=val}\r\n  <div>\r\n    <input type="radio" {if $val.val == 1} checked="checked" {/if} name="data[values_s][{$id_attribute}][set]" value="{$val.parent_id}" id="value{$val.id}" aria-hidden="true">\r\n    <label>{$val.name}</label>\r\n    <input name="data[values_s][{$id_attribute}][data][{$val.parent_id}][type_attr]" value="{$val.type_attr}" type="hidden" aria-hidden="true">\r\n    <input name="data[values_s][{$id_attribute}][data][{$val.parent_id}][id]" value="{$val.id}" type="hidden" aria-hidden="true">\r\n    <input name="data[values_s][{$id_attribute}][data][{$val.parent_id}][parent_id]" value="{$val.parent_id}" type="hidden" aria-hidden="true">\r\n  </div>\r\n{/foreach}\r\n</div>', '{$name_attribute}:	{$values_attribute.name}\r\n', '{$name_attribute}:	{$values_attribute.name}', '{foreach from=$values_attribute item=val}\r\n  {if $val.val == 1} {$val.name} {/if}\r\n{/foreach}', 'a:7:{s:9:"dig_value";s:1:"0";s:9:"max_value";s:1:"0";s:9:"min_value";s:1:"0";s:10:"like_value";s:1:"0";s:10:"list_value";s:1:"1";s:12:"checked_list";s:1:"0";s:9:"any_value";s:1:"0";}'),
(3, 'check', NULL, '<div class="form-group">\r\n<div class="checkbox">\r\n  <label>\r\n    <input id="activebox{$id_attribute}" {if $is_active == 1} checked="checked" {/if} aria-hidden="true" type="checkbox" disabled>\r\n    {$name_attribute}\r\n  </label>\r\n</div>\r\n</div>\r\n<input id="activeval{$id_attribute}" name="data[values_f][{$id_attribute}][is_active]" {if $is_active == 1} value="1" {/if} type="hidden" aria-hidden="true">\r\n{foreach from=$values_attribute item=val}\r\n<div class="form-group">\r\n<div class="checkbox">\r\n  <label>\r\n    <input type="checkbox" {if $val.val == 1} checked="checked" {/if} name="data[values_f][{$id_attribute}][data][{$val.id}][value]" value="1" id="value{$val.id}" class="checkbox{$id_attribute}" aria-hidden="true">\r\n    {$val.name}\r\n  </label>\r\n</div>\r\n</div>\r\n<input name="data[values_f][{$id_attribute}][data][{$val.id}][type_attr]" value="{$val.type_attr}" type="hidden" aria-hidden="true">\r\n<input name="data[values_f][{$id_attribute}][data][{$val.id}][id]" value="{$val.id}" type="hidden" aria-hidden="true">\r\n{/foreach}\r\n<script>\r\n$(function($){\r\n  $(".checkbox{$id_attribute}").on("change",function() {\r\n    $("#activebox{$id_attribute}").attr("checked",true);\r\n    $("#activeval{$id_attribute}").attr("value","1");\r\n    $("#filterbutton").click();\r\n  });\r\n});  \r\n</script>', '<div class="checkbox">\r\n{foreach from=$values_attribute item=val}\r\n  <div>\r\n    <input type="checkbox" {if $val.val == 1} checked="checked" {/if} name="data[values_s][{$id_attribute}][data][{$val.parent_id}][value]" value="1" id="value{$val.id}" aria-hidden="true">\r\n    <label>{$val.name}</label>\r\n    <input name="data[values_s][{$id_attribute}][data][{$val.parent_id}][type_attr]" value="{$val.type_attr}" type="hidden" aria-hidden="true">\r\n    <input name="data[values_s][{$id_attribute}][data][{$val.parent_id}][id]" value="{$val.id}" type="hidden" aria-hidden="true">\r\n    <input name="data[values_s][{$id_attribute}][data][{$val.parent_id}][parent_id]" value="{$val.parent_id}" type="hidden" aria-hidden="true">\r\n  </div>\r\n{/foreach}\r\n</div>', '{$name_attribute} :\r\n<ul>\r\n{foreach from=$values_attribute item=val}\r\n  {if $val.set_val == 1} <li> {$val.name} </li> {/if}\r\n{/foreach}\r\n</ul>', '{$name_attribute} :\r\n<ul>\r\n{foreach from=$values_attribute item=val}\r\n  {if $val.set_val == 1} <li> {$val.name} </li> {/if}\r\n{/foreach}\r\n</ul>', '<ul>\r\n  {foreach from=$values_attribute item=val}\r\n  {if $val.val == 1} <li>{$val.name}</li> {/if}\r\n  {/foreach}\r\n</ul>  ', 'a:7:{s:9:"dig_value";s:1:"0";s:9:"max_value";s:1:"0";s:9:"min_value";s:1:"0";s:10:"like_value";s:1:"0";s:10:"list_value";s:1:"1";s:12:"checked_list";s:1:"1";s:9:"any_value";s:1:"0";}'),
(4, 'list', NULL, '<div class="form-group">\r\n<div class="checkbox">\r\n  <label>\r\n    <input id="activebox{$id_attribute}" {if $is_active == 1} checked="checked" {/if} type="checkbox" disabled aria-hidden="true">\r\n    {$name_attribute}\r\n  </label>\r\n</div>\r\n</div>\r\n<input id="activeval{$id_attribute}" name="data[values_f][{$id_attribute}][is_active]" {if $is_active == 1} value="1" {/if} type="hidden"  aria-hidden="true">\r\n<div class="form-group">\r\n	<label class="sr-only">{$name_attribute}</label>\r\n  <select class="form-control" name="data[values_f][{$id_attribute}][set]" id="listvalue{$id_attribute}" aria-hidden="true">\r\n  {foreach from=$values_attribute item=val}\r\n  <option value="{$val.id}" {if $val.val == 1} selected {/if}>{$val.name}</option>\r\n  {/foreach}\r\n  </select>\r\n  {foreach from=$values_attribute item=val}\r\n    <input name="data[values_f][{$id_attribute}][data][{$val.id}][type_attr]" value="{$val.type_attr}" type="hidden" aria-hidden="true">\r\n    <input name="data[values_f][{$id_attribute}][data][{$val.id}][id]" value="{$val.id}" type="hidden" aria-hidden="true">\r\n  {/foreach}\r\n</div>\r\n<script>\r\n$(function($){\r\n  $("#listvalue{$id_attribute}").on("change",function() {\r\n    $("#activebox{$id_attribute}").attr("checked",true);\r\n    $("#activeval{$id_attribute}").attr("value","1");\r\n    $("#filterbutton").click();\r\n  });\r\n});  \r\n</script>', '<div class="input select">\r\n  <label>{$name_attribute}</label>\r\n  <select name="data[values_s][{$id_attribute}][set]" id="listvalue{$id_attribute}" aria-hidden="true">\r\n  {foreach from=$values_attribute item=val}\r\n  <option value="{$val.parent_id}" {if $val.val == 1} selected {/if}>{$val.name}</option>\r\n  {/foreach}\r\n  </select>\r\n  {foreach from=$values_attribute item=val}\r\n    <input name="data[values_s][{$id_attribute}][data][{$val.parent_id}][type_attr]" value="{$val.type_attr}" type="hidden" aria-hidden="true">\r\n    <input name="data[values_s][{$id_attribute}][data][{$val.parent_id}][id]" value="{$val.id}" type="hidden" aria-hidden="true">\r\n    <input name="data[values_s][{$id_attribute}][data][{$val.parent_id}][parent_id]" value="{$val.parent_id}" type="hidden" aria-hidden="true">\r\n  {/foreach}\r\n</div>', '{$name_attribute}:	{$values_attribute.name}', '{$name_attribute}:	{$values_attribute.name}', '{foreach from=$values_attribute item=val}\r\n  {if $val.val == 1} {$val.name} {/if}\r\n{/foreach}', 'a:7:{s:9:"dig_value";s:1:"0";s:9:"max_value";s:1:"0";s:9:"min_value";s:1:"0";s:10:"like_value";s:1:"0";s:10:"list_value";s:1:"1";s:12:"checked_list";s:1:"0";s:9:"any_value";s:1:"0";}'),
(5, 'range', NULL, '<div class="form-group">\r\n<div class="checkbox">\r\n  <label>\r\n    <input id="activebox{$id_attribute}" {if $is_active == 1} checked="checked" {/if} aria-hidden="true" type="checkbox" disabled>\r\n    {$name_attribute}\r\n  </label>\r\n</div>\r\n</div>\r\n<input id="activeval{$id_attribute}" name="data[values_f][{$id_attribute}][is_active]" {if $is_active == 1} value="1" {/if} type="hidden" aria-hidden="true">\r\n<div class="form-group">\r\n	<label class="sr-only">{$values_attribute.min_value.name}</label>\r\n  <input name="data[values_f][{$id_attribute}][data][{$values_attribute.min_value.id}][value]" value="{$values_attribute.min_value.val}" id="min_value{$id_attribute}" type="text" class="form-control range_value" aria-hidden="true">\r\n</div>\r\n<input name="data[values_f][{$id_attribute}][data][{$values_attribute.min_value.id}][type_attr]" value="{$values_attribute.min_value.type_attr}" type="hidden" aria-hidden="true">\r\n<input name="data[values_f][{$id_attribute}][data][{$values_attribute.min_value.id}][id]" value="{$values_attribute.min_value.id}" type="hidden" aria-hidden="true">\r\n<div class="form-group">\r\n	<label class="sr-only">{$values_attribute.max_value.name}</label>\r\n  <input name="data[values_f][{$id_attribute}][data][{$values_attribute.max_value.id}][value]" value="{$values_attribute.max_value.val}" id="max_value{$id_attribute}" type="text" class="form-control range_value" aria-hidden="true">\r\n</div>\r\n<input name="data[values_f][{$id_attribute}][data][{$values_attribute.max_value.id}][type_attr]" value="{$values_attribute.max_value.type_attr}" type="hidden" aria-hidden="true">\r\n<input name="data[values_f][{$id_attribute}][data][{$values_attribute.max_value.id}][id]" value="{$values_attribute.max_value.id}" type="hidden" aria-hidden="true">\r\n<script>\r\n$(function($){\r\n  $(".range_value").on("change",function() {\r\n    $("#activebox{$id_attribute}").attr("checked",true);\r\n    $("#activeval{$id_attribute}").attr("value","1");\r\n  });\r\n});  \r\n</script>', '<div class="input text">\r\n  <label>{$values_attribute.min_value.name}</label>\r\n  <input name="data[values_s][{$id_attribute}][data][{$values_attribute.min_value.parent_id}][value]" value="{$values_attribute.min_value.val}" id="min_value{$id_attribute}" type="text" aria-hidden="true">\r\n  <input name="data[values_s][{$id_attribute}][data][{$values_attribute.min_value.parent_id}][type_attr]" value="{$values_attribute.min_value.type_attr}" type="hidden" aria-hidden="true">\r\n  <input name="data[values_s][{$id_attribute}][data][{$values_attribute.min_value.parent_id}][id]" value="{$values_attribute.min_value.id}" type="hidden" aria-hidden="true">\r\n  <input name="data[values_s][{$id_attribute}][data][{$values_attribute.min_value.parent_id}][parent_id]" value="{$values_attribute.min_value.parent_id}" type="hidden" aria-hidden="true">\r\n</div>\r\n<div class="input text">\r\n  <label>{$values_attribute.max_value.name}</label>\r\n  <input name="data[values_s][{$id_attribute}][data][{$values_attribute.max_value.parent_id}][value]" value="{$values_attribute.max_value.val}" id="max_value{$id_attribute}" type="text" aria-hidden="true">\r\n  <input name="data[values_s][{$id_attribute}][data][{$values_attribute.max_value.parent_id}][type_attr]" value="{$values_attribute.max_value.type_attr}" type="hidden" aria-hidden="true">\r\n  <input name="data[values_s][{$id_attribute}][data][{$values_attribute.max_value.parent_id}][id]" value="{$values_attribute.max_value.id}" type="hidden" aria-hidden="true">\r\n  <input name="data[values_s][{$id_attribute}][data][{$values_attribute.max_value.parent_id}][parent_id]" value="{$values_attribute.max_value.parent_id}" type="hidden" aria-hidden="true">\r\n</div>', '{if $values_attribute.min_value.val}\r\n<li>\r\n  {$name_attribute}	{$values_attribute.min_value.val}\r\n</li>\r\n{/if}', '{if $values_attribute.min_value.val}\r\n<li>\r\n  {$name_attribute}	{$values_attribute.min_value.val}\r\n</li>\r\n{/if}', '{$values_attribute.min_value.val}', 'a:7:{s:9:"dig_value";s:1:"0";s:9:"max_value";s:1:"1";s:9:"min_value";s:1:"1";s:10:"like_value";s:1:"0";s:10:"list_value";s:1:"0";s:12:"checked_list";s:1:"0";s:9:"any_value";s:1:"0";}'),
(6, 'like', NULL, '<div class="form-group">\r\n<div class="checkbox">\r\n  <label>\r\n    <input id="activebox{$id_attribute}" {if $is_active == 1} checked="checked" {/if} aria-hidden="true" type="checkbox" disabled>\r\n    {$name_attribute}\r\n  </label>\r\n</div>\r\n</div>\r\n<input id="activeval{$id_attribute}" name="data[values_f][{$id_attribute}][is_active]" {if $is_active == 1} value="1" {/if} type="hidden" aria-hidden="true">\r\n<div class="form-group">\r\n	<label class="sr-only">{$name_attribute}</label>\r\n	<input name="data[values_f][{$id_attribute}][data][{$values_attribute.like_value.id}][value]" value="{$values_attribute.like_value.val}" id="value{$id_attribute}" type="text" class="form-control" aria-hidden="true">\r\n	<input name="data[values_f][{$id_attribute}][data][{$values_attribute.like_value.id}][type_attr]" value="{$values_attribute.like_value.type_attr}" type="hidden" aria-hidden="true">\r\n	<input name="data[values_f][{$id_attribute}][data][{$values_attribute.like_value.id}][id]" value="{$values_attribute.like_value.id}" type="hidden" aria-hidden="true">\r\n</div>\r\n<script>\r\n$(function($){\r\n  $("#value{$id_attribute}").on("change",function() {\r\n    $("#activebox{$id_attribute}").attr("checked",true);\r\n    $("#activeval{$id_attribute}").attr("value","1");\r\n  });\r\n});  \r\n</script>', '<div class="input text">\r\n  <label>{$name_attribute}</label>\r\n  <input name="data[values_s][{$id_attribute}][data][{$values_attribute.like_value.parent_id}][value]" value="{$values_attribute.like_value.val}" id="value{$id_attribute}" type="text" aria-hidden="true">\r\n  <input name="data[values_s][{$id_attribute}][data][{$values_attribute.like_value.parent_id}][type_attr]" value="{$values_attribute.like_value.type_attr}" type="hidden" aria-hidden="true">\r\n  <input name="data[values_s][{$id_attribute}][data][{$values_attribute.like_value.parent_id}][id]" value="{$values_attribute.like_value.id}" type="hidden" aria-hidden="true">\r\n  <input name="data[values_s][{$id_attribute}][data][{$values_attribute.like_value.parent_id}][parent_id]" value="{$values_attribute.like_value.parent_id}" type="hidden" aria-hidden="true">\r\n</div>', '{if $values_attribute.like_value.val}\r\n<li>\r\n  {$values_attribute.like_value.name}:	{$values_attribute.like_value.val}\r\n</li>\r\n{/if}', '{if $values_attribute.like_value.val}\r\n<li>\r\n  {$values_attribute.like_value.name}:	{$values_attribute.like_value.val}\r\n</li>\r\n{/if}', '{$values_attribute.like_value.val}', 'a:7:{s:9:"dig_value";s:1:"0";s:9:"max_value";s:1:"0";s:9:"min_value";s:1:"0";s:10:"like_value";s:1:"1";s:10:"list_value";s:1:"0";s:12:"checked_list";s:1:"0";s:9:"any_value";s:1:"0";}');

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
(1, 2, 'CouponsModule', '/module_coupons/event/utilize_coupon/', '2009-09-13 11:11:08', '2009-09-13 11:11:08'),
(2, 2, 'ModuleGift', '/module_gift/gift/get_gift/', '2017-08-14 22:12:57', '2017-08-14 22:12:57');

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

INSERT INTO `geo_zones` (`id`, `name`, `description`, `created`, `modified`) VALUES
(1, 'Russian Post Zone 1', '', '2014-06-29 11:30:45', '2014-06-29 20:24:59'),
(2, 'Russian Post Zone 2', '', '2014-06-29 11:30:48', '2014-06-29 20:24:54'),
(3, 'Russian Post Zone 3', '', '2014-06-29 11:30:52', '2014-06-29 11:30:52'),
(4, 'Russian Post Zone 4', '', '2014-06-29 11:30:55', '2014-06-29 11:30:55'),
(5, 'Russian Post Zone 5', '', '2014-06-29 11:30:58', '2014-06-29 11:30:58');

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
(1, 'Footer', '<p class="copyright"><a href="http://{lang}vamshop.com{/lang}/">{lang}Powered by{/lang} VamShop</a>.</p>', 'footer', 1, '2009-07-17 10:00:06', '2009-09-12 17:05:49');

DROP TABLE IF EXISTS labels;
CREATE TABLE `labels` (
  `id` int(10) auto_increment,
  `default` tinyint(4),
  `name` varchar(255) collate utf8_unicode_ci,
  `alias` varchar(255) collate utf8_unicode_ci,
  `html` varchar(255) collate utf8_unicode_ci,
  `active` tinyint(4) default '1',
  `sort_order` int(3),
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `labels` (`id`, `default`, `name`, `alias`, `html`, `active`, `sort_order`) VALUES 
(1, 1, 'New', 'new', '', 1, 1),
(2, 0, 'Hit', 'hit', '', 1, 2),
(3, 0, 'Sale', 'sale', '', 1, 3);

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
(2, 0, 'Русский', 'rus', 'ru', 0, 2);

DROP TABLE IF EXISTS micro_templates;
CREATE TABLE `micro_templates` (
  `id` int(10) auto_increment,
  `alias` varchar(255) collate utf8_unicode_ci,
  `template` longtext collate utf8_unicode_ci,
  `created` datetime,
  `modified` datetime,
  `tag_name` varchar(255) collate utf8_unicode_ci,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `micro_templates` (`id`, `alias`, `template`, `created`, `modified`, `tag_name`) VALUES
(1, 'subcategory-listing', '{if $content_list}\r\n<div class="row featured-categories">\r\n	<ul class="thumbnails">\r\n	{foreach from=$content_list item=node}\r\n		<li class="item col-sm-6 col-md-4">\r\n			<div class="thumbnail text-center">\r\n				<a href="{$node.url}" class="image">\r\n				<img src="{$node.image}" alt="{$node.name}"{if {$node.image_width} > 0} width="{$node.image_width}"{/if}{if {$node.image_height} > 0} height="{$node.image_height}"{/if} />\r\n				<span class="frame-overlay"></span>\r\n				<h4 class="title"><i class="fa fa-folder-open"></i> {$node.name}</h4>\r\n				<span class="link">{lang}view products{/lang} <i class="fa fa-chevron-right"></i></span>\r\n				</a>\r\n\r\n				<div class="inner notop text-left">\r\n					<div class="description">\r\n						{$node.short_description|strip_tags|truncate:120:"...":true}\r\n					</div>\r\n				</div>\r\n			</div>\r\n		</li>\r\n	{/foreach}\r\n	</ul>\r\n</div>\r\n{else}\r\n<div>{lang}No Items Found{/lang}</div>\r\n{/if}\r\n', '2013-10-01 17:08:06', '2014-03-05 18:57:10', 'content_listing'),
(2, 'featured-products', '{if $content_list}\r\n<h2>{lang}Featured Products{/lang}</h2>\r\n<div class="row shop-products">\r\n  <ul class="thumbnails">\r\n  {foreach from=$content_list item=node}\r\n    <li class="item col-sm-6 col-md-4">\r\n      <div class="thumbnail text-center">\r\n        {if $node.discount > 0}<div class="description"><span class="discount">-{$node.discount|round}%</span></div>{/if}\r\n        <a href="{$node.url}" class="image"><img src="{$node.image}" alt="{$node.name}"{if {$node.image_width} > 0} width="{$node.image_width}"{/if}{if {$node.image_height} > 0} height="{$node.image_height}"{/if} />\r\n        {if $node.price}<span class="frame-overlay"></span><span class="price">{$node.price}</span>{/if}\r\n        {product_label label_id={$node.label_id}}\r\n        </a>\r\n        <div class="inner notop nobottom text-left">\r\n          <h4 class="title"><a href="{$node.url}">{$node.name}</a></h4>\r\n          {if $node.reviews > 0}<div class="description"><span class="rating">{$node.star_rating}</span> <span class="reviews">{lang}Feedback{/lang}: {$node.reviews}</span></div>{/if}\r\n          {if $node.old_price}<div class="description">{lang}List Price{/lang}: <span class="old-price"><del>{$node.old_price}</del></span></div>{/if}\r\n          {if $node.price_save}<div class="description">{lang}You Save{/lang}: <span class="save">{$node.price_save} ({$node.price_save_percent|round}%)</span></div>{/if}\r\n          <div class="description">{$node.short_description|strip_tags|truncate:30:"...":true}</div>\r\n          <div class="description">{attribute_list product_id=$node.id}</div>\r\n        </div>\r\n      </div>\r\n      {product_form product_id={$node.id}}\r\n      <div class="inner darken notop">\r\n        <button class="btn btn-default btn-add-to-cart" type="submit" value="{lang}Buy{/lang}"><i class="fa fa-shopping-cart"></i> {lang}Buy{/lang}</button>\r\n      </div>\r\n      {/product_form}\r\n    </li>\r\n  {/foreach}\r\n  </ul>\r\n</div>\r\n{/if}  ', '2013-10-08 18:09:58', '2014-12-28 14:29:27', 'content_listing'),
(3, 'product-listing', '{if $content_list}\r\n\r\n{filter_variants}\r\n\r\n{if isset($content_alias)}\r\n<div class="sort">\r\n<div class="btn-toolbar">\r\n  <div class="btn-group">\r\n  <span class="btn btn-default"><i class="fa fa-sort" title="{lang}Sort by{/lang}"></i></span>\r\n    <a class="btn btn-default{if $order == "price-asc"} active{/if}" href="{base_path}/category/{$content_alias->value}{$ext}/order/price-asc">{lang}Price{/lang}</a>\r\n    <a class="btn btn-default{if $order == "price-asc"} active{/if}" href="{base_path}/category/{$content_alias->value}{$ext}/order/price-asc"><i class="fa fa-sort-numeric-asc" title="{lang}Price (Low to High){/lang}"></i></a>\r\n    <a class="btn btn-default{if $order == "price-desc"} active{/if}" href="{base_path}/category/{$content_alias->value}{$ext}/order/price-desc"><i class="fa fa-sort-numeric-desc" title="{lang}Price (High to Low){/lang}"></i></a>\r\n    <a class="btn btn-default{if $order == "name-asc"} active{/if}" href="{base_path}/category/{$content_alias->value}{$ext}/order/name-asc">{lang}Product Name{/lang}</a>\r\n    <a class="btn btn-default{if $order == "name-asc"} active{/if}" href="{base_path}/category/{$content_alias->value}{$ext}/order/name-asc"><i class="fa fa-sort-alpha-asc" title="{lang}Name (A-Z){/lang}"></i></a>\r\n    <a class="btn btn-default{if $order == "name-desc"} active{/if}" href="{base_path}/category/{$content_alias->value}{$ext}/order/name-desc"><i class="fa fa-sort-alpha-desc" title="{lang}Name (Z-A){/lang}"></i></a>\r\n    <a class="btn btn-default{if $order == "ordered-desc"} active{/if}" href="{base_path}/category/{$content_alias->value}{$ext}/order/ordered-desc">{lang}Popular{/lang}</a>\r\n    <a class="btn btn-default{if $order == "ordered-desc"} active{/if}" href="{base_path}/category/{$content_alias->value}{$ext}/order/ordered-desc"><i class="fa fa-thumbs-up" title="{lang}Popular (desc){/lang}"></i></a>\r\n    <a class="btn btn-default{if $order == "ordered-asc"} active{/if}" href="{base_path}/category/{$content_alias->value}{$ext}/order/ordered-asc"><i class="fa fa-thumbs-down" title="{lang}Popular (asc){/lang}"></i></a>\r\n  </div>\r\n</div>\r\n</div>\r\n{/if}  \r\n\r\n{if isset($content_alias)}\r\n{if $pages_number > 1}\r\n<!-- start: Pagination -->\r\n<div class="text-center">\r\n  <ul class="pagination">\r\n    {for $pg=1 to $pages_number}\r\n    <li{if $pg == {$page}} class="active"{/if}><a href="{base_path}/category/{$content_alias->value}{$ext}/page/{$pg}{if $order}/order/{$order}{/if}">{$pg}</a></li>\r\n    {/for}\r\n    <li{if "all" == {$page}} class="active"{/if}><a href="{base_path}/category/{$content_alias->value}{$ext}/page/all{if $order}/order/{$order}{/if}">{lang}All{/lang}</a></li>\r\n  </ul>\r\n</div>\r\n<!-- end: Pagination -->\r\n{/if}  \r\n{/if}  \r\n  \r\n<!-- start: products listing -->\r\n<div class="row shop-products">\r\n  <ul class="thumbnails">\r\n    {foreach from=$content_list item=node}\r\n    <li class="item col-sm-6 col-md-4">\r\n      <div class="thumbnail text-center">\r\n        {if $node.discount > 0}<div class="description"><span class="discount">-{$node.discount|round}%</span></div>{/if}\r\n        <a href="{$node.url}" class="image"><img src="{$node.image}" alt="{$node.name}"{if {$node.image_width} > 0} width="{$node.image_width}"{/if}{if {$node.image_height} > 0} height="{$node.image_height}"{/if} />\r\n        {if $node.price}<span class="frame-overlay"></span><span class="price">{$node.price}</span>{/if}\r\n        {product_label label_id={$node.label_id}}\r\n        </a>\r\n      <div class="inner notop nobottom text-left">\r\n        <h4 class="title"><a href="{$node.url}">{$node.name}</a></h4>\r\n        {if $node.reviews > 0}<div class="description"><span class="rating">{$node.star_rating}</span> <span class="reviews">{lang}Feedback{/lang}: {$node.reviews}</span></div>{/if}\r\n        {if $node.old_price}<div class="description">{lang}List Price{/lang}: <span class="old-price"><del>{$node.old_price}</del></span></div>{/if}\r\n        {if $node.price_save}<div class="description">{lang}You Save{/lang}: <span class="save">{$node.price_save} ({$node.price_save_percent|round}%)</span></div>{/if}\r\n        <div class="description">{$node.short_description|strip_tags|truncate:30:"...":true}</div>\r\n        <div class="description">{attribute_list product_id=$node.id}</div>\r\n      </div>\r\n      </div>\r\n      {product_form product_id={$node.id}}\r\n      <div class="inner darken notop">\r\n        <button class="btn btn-default btn-add-to-cart" type="submit"><i class="fa fa-shopping-cart"></i> {lang}Buy{/lang}</button>\r\n        {if isset($is_compare)}<a href="{base_path}/category/addcmp/{$node.alias}/{$content_alias->value}{$ext}" class="btn btn-default btn-add-to-cart"><i class="fa fa-bookmark"></i> {lang}Compare{/lang}</a>{/if}\r\n      </div>\r\n      {/product_form}\r\n    </li>\r\n    {/foreach}\r\n  </ul>\r\n</div>  \r\n<!-- end: products listing -->\r\n\r\n{if isset($content_alias)}\r\n{if $pages_number > 1}\r\n<!-- start: Pagination -->\r\n<div class="text-center">\r\n  <ul class="pagination">\r\n    {for $pg=1 to $pages_number}\r\n    <li{if $pg == {$page}} class="active"{/if}><a href="{base_path}/category/{$content_alias->value}{$ext}/page/{$pg}{if $order}/order/{$order}{/if}">{$pg}</a></li>\r\n    {/for}\r\n    <li{if "all" == {$page}} class="active"{/if}><a href="{base_path}/category/{$content_alias->value}{$ext}/page/all{if $order}/order/{$order}{/if}">{lang}All{/lang}</a></li>\r\n  </ul>\r\n</div>\r\n<!-- end: Pagination -->\r\n{/if}\r\n{/if}  \r\n\r\n{else}\r\n{lang}No Items Found{/lang}\r\n\r\n{/if}  ', '2013-10-01 17:08:06', '2018-10-11 20:53:07', 'content_listing'),
(4, 'slider', '{if $content_list}\r\n	<div id="sequence-theme">\r\n		<div id="sequence">\r\n			<div class="sequence-prev"><i class="fa fa-chevron-left"></i></div>\r\n			<div class="sequence-next"><i class="fa fa-chevron-right"></i></div>\r\n				<ul class="sequence-canvas">\r\n				{foreach from=$content_list item=node}\r\n					<li{if $node@first} class="animate-in"{/if}>\r\n						<div class="text">\r\n							<h2 class="title"><span><a href="{$node.url}">{$node.name|strip_tags|truncate:30:"...":true}</a></span></h2>\r\n							{if $node.reviews > 0}<div class="description"><span class="rating">{$node.star_rating}</span> <span class="reviews">{lang}Feedback{/lang}: {$node.reviews}</span></div>{/if}\r\n							{if $node.short_description}<div class="description">{$node.short_description|strip_tags|truncate:120:"...":true}</div>{/if}\r\n							<a href="{$node.url}" class="btn btn-default">{lang}read more{/lang}</a>\r\n						</div>\r\n						<img class="image" src="{$node.image}" alt="{$node.name}"{if {$node.image_width} > 0} width="{$node.image_width}"{/if}{if {$node.image_height} > 0} height="{$node.image_height}"{/if} />\r\n					</li>\r\n				{/foreach}\r\n				</ul>\r\n		</div>\r\n	</div>\r\n{/if}', '2013-10-08 18:39:12', '2015-06-23 21:40:28', 'content_listing'),
(5, 'links', '{foreach from=$content_list item=node}\r\n<li{if $node.alias == $content_alias} class="active"{/if}><a href="{$node.url}">{$node.name}</a></li>\r\n{/foreach}', '2013-10-01 17:08:06', '2013-10-07 16:25:08', 'content_listing'),
(6, 'cart-confirm-view', '{if $order_items}\r\n<div class="cart">\r\n<h3>{lang}Cart Contents{/lang}</h3>\r\n<table class="table table-striped table-hover">\r\n  <thead>\r\n	<tr>\r\n		<th></th>\r\n		<th>{lang}Product{/lang}</th>\r\n		<th>{lang}Price Ea.{/lang}</th>\r\n		<th>{lang}Qty{/lang}</th>\r\n		<th>{lang}Total{/lang}</th>\r\n	</tr>\r\n	</thead>\r\n\r\n  <tbody>\r\n{foreach from=$order_items item=product}\r\n	<tr>\r\n		<td class="text-center"><img class="media-object" src="{$product.image.image_thumb}" alt=""{if {$product.image.image_width} > 0} width="{$product.image.image_width}"{/if}{if {$product.image.image_height} > 0} height="{$product.image.image_height}"{/if} /></td>\r\n		<td><a href="{$product.url}">{$product.name}</a></td>\r\n		<td>{$product.price}</td>\r\n		<td>{$product.qty}</td>\r\n		<td>{$product.line_total}</td>\r\n	</tr>\r\n{foreachelse}\r\n	<tr>\r\n		<td colspan="5">{lang}No Cart Items{/lang}</td>\r\n	</tr>\r\n{/foreach}\r\n    {if $shipping_total_value > 0}\r\n	<tr class="cart_total">\r\n		<td colspan="3">&nbsp;</td>\r\n		<td class="total-name">{lang}Shipping{/lang}:</td>\r\n		<td class="total-value">{$shipping_total}</td>\r\n	</tr>\r\n    {/if}\r\n    {if $tax_total_value > 0}\r\n	<tr class="cart_total">\r\n		<td colspan="3">&nbsp;</td>\r\n		<td class="total-name">{lang}Tax{/lang}:</td>\r\n		<td class="total-value">{$tax_total}</td>\r\n	</tr>\r\n    {/if}\r\n    {if $order_total_value > 0}\r\n	<tr class="cart_total">\r\n		<td colspan="3">&nbsp;</td>\r\n		<td class="total-name"><strong>{lang}Total{/lang}:</strong></td>\r\n		<td class="total-value">{$order_total}</td>\r\n	</tr>\r\n    {/if}\r\n  </tbody>\r\n</table>\r\n</div>\r\n{else}\r\n	{lang}No Cart Items{/lang}\r\n{/if}', '2013-10-16 21:54:14', '2015-07-22 00:20:33', 'shopping_cart'),
(7, 'cart-content-box', '{if $order_items}\r\n<div class="widget inner shopping-cart-widget">\r\n	<h3 class="widget-title">{lang}Shopping Cart{/lang}</h3>\r\n		<div class="products">\r\n			{foreach from=$order_items item=product}\r\n				<div class="media">\r\n					<a class="pull-right" href="{$product.url}">\r\n						<img class="media-object" src="{$product.image.image_thumb}" alt=""{if {$product.image.image_width} > 0} width="{$product.image.image_width}"{/if}{if {$product.image.image_height} > 0} height="{$product.image.image_height}"{/if} />\r\n					</a>\r\n				<div class="media-body">\r\n					<h4 class="media-heading"><a href="{$product.url}">{$product.name}</a> <a href="{base_path}/cart/remove_product/{$product.id}/1" class="remove" title="{lang}Remove{/lang}"><i class="fa fa-trash-o"></i></a></h4>\r\n					{$product.qty} x {$product.price}\r\n				</div>\r\n				</div>\r\n			{/foreach}\r\n		</div>\r\n		{if $shipping_total_value > 0}\r\n		<p class="subtotal">\r\n			{lang}Shipping{/lang}:\r\n			<span class="amount">{$shipping_total}</span>\r\n		</p>\r\n		{/if}\r\n		{if $tax_total_value > 0}\r\n		<p class="subtotal">\r\n			{lang}Tax{/lang}:\r\n			<span class="amount">{$tax_total}</span>\r\n		</p>\r\n		{/if}\r\n		{if $order_total_value > 0}\r\n		<p class="subtotal">\r\n			<strong>{lang}Total{/lang}:</strong>\r\n			<span class="amount">{$order_total}</span>\r\n		</p>\r\n		{/if}\r\n		<p class="buttons">\r\n			<a class="btn btn-default viewcart" href="{$cart_link}"><i class="fa fa-shopping-cart"></i> {lang}View Cart{/lang}</a>\r\n			<a class="btn btn-warning checkout" href="{$checkout_link}"><i class="fa fa-check"></i> {lang}Checkout{/lang}</a>\r\n		</p>\r\n</div>\r\n{else}\r\n<div class="widget inner shopping-cart-widget">\r\n	<h3 class="widget-title">{lang}Shopping Cart{/lang}</h3>\r\n        <div class="cart-body">{lang}No Cart Items{/lang}</div>\r\n</div>\r\n{/if}\r\n', '2013-10-01 17:08:06', '2015-07-22 00:20:52', 'shopping_cart'),
(8, 'search-result-ajax', '{if $content_list}\r\n<script type="text/javascript">\r\n$(document).ready(function() {\r\n	$(document).click(function (){\r\n		$("#searchResults").hide();\r\n	});\r\n});\r\n</script>  \r\n<div id="searchResults">\r\n<table class="table table-striped table-hover hidden-xs">\r\n  <thead>\r\n	<tr>\r\n		<th colspan="3">{lang}Top 5 results:{/lang}</th>\r\n	</tr>\r\n	</thead>\r\n  <tbody>\r\n{foreach from=$content_list item=product}\r\n	<tr>\r\n		<td class="text-center"><img class="media-object" src="{$product.image}" alt="{$product.name}" width="40" height="40" /></td>\r\n		<td><a href="{$product.url}">{$product.name}</a></td>\r\n		<td>{$product.price}</td>\r\n	</tr>\r\n{/foreach}\r\n	<tr>\r\n      <td colspan="3" class="text-center"><a href="{base_path}/page/search-result.html?keyword={$smarty.get.keyword}">{lang}Display all search results.{/lang}</a></td>\r\n	</tr>\r\n  </tbody>\r\n</table>\r\n</div>\r\n{/if}  \r\n', '2018-10-26 21:51:26', '2018-10-30 19:58:54', 'search_result');

DROP TABLE IF EXISTS micro_template_logs;
CREATE TABLE `micro_template_logs` (
  `id` int(10) auto_increment,
  `micro_template_id` int(10),
  `alias` varchar(255) collate utf8_unicode_ci,
  `template` longtext collate utf8_unicode_ci,
  `created` datetime,
  `modified` datetime,
  `tag_name` varchar(255) collate utf8_unicode_ci,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
(1, 'Reviews', 'cus-user-comment', 'reviews', '1.0', 3),
(2, 'Coupons', 'cus-calculator', 'coupons', '2', 3),
(3, 'Abandoned Carts', 'cus-cart-error', 'abandoned_carts', '1', 2),
(4, 'Ask A Product Question', 'cus-user-comment', 'ask_a_product_question', '1', -1),
(5, 'One Click Buy', 'cus-cart', 'one_click_buy', '1', -1),
(6, 'Gift', 'cus-cart-put', 'gift', '1', 5);

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

DROP TABLE IF EXISTS module_gifts;
CREATE TABLE `module_gifts` (
  `id` int(10) auto_increment,
  `content_id` int(10),
  `order_total` double,
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
  `rating` int(10),
  `created` datetime,
  `modified` datetime,
  PRIMARY KEY  (`id`),
  INDEX content_id (content_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `module_reviews` (`id`, `content_id`, `name`, `content`, `rating`, `created`, `modified`) VALUES
(1, 38, 'Alex', ':)', 5, '2014-10-22 16:51:07', '2014-10-22 16:51:07'),
(2, 38, 'Alex', ':(', 4, '2014-10-22 16:51:16', '2014-10-22 16:51:16'),
(3, 93, 'Alex', ':)', 5, '2014-10-22 16:51:07', '2014-10-22 16:51:07'),
(4, 93, 'Alex', ':(', 4, '2014-10-22 16:51:16', '2014-10-22 16:51:16'),
(5, 94, 'Alex', ':)', 5, '2014-10-22 16:51:07', '2014-10-22 16:51:07'),
(6, 94, 'Alex', ':(', 4, '2014-10-22 16:51:16', '2014-10-22 16:51:16'),
(7, 95, 'Alex', ':)', 5, '2014-10-22 16:51:07', '2014-10-22 16:51:07'),
(8, 95, 'Alex', ':(', 4, '2014-10-22 16:51:16', '2014-10-22 16:51:16'),
(9, 96, 'Alex', ':)', 5, '2014-10-22 16:51:07', '2014-10-22 16:51:07'),
(10, 96, 'Alex', ':(', 4, '2014-10-22 16:51:16', '2014-10-22 16:51:16'),
(11, 97, 'Alex', ':)', 5, '2014-10-22 16:51:07', '2014-10-22 16:51:07'),
(12, 97, 'Alex', ':(', 4, '2014-10-22 16:51:16', '2014-10-22 16:51:16'),
(13, 98, 'Alex', ':)', 5, '2014-10-22 16:51:07', '2014-10-22 16:51:07'),
(14, 98, 'Alex', ':(', 4, '2014-10-22 16:51:16', '2014-10-22 16:51:16'),
(15, 99, 'Alex', ':)', 5, '2014-10-22 16:51:07', '2014-10-22 16:51:07'),
(16, 99, 'Alex', ':(', 4, '2014-10-22 16:51:16', '2014-10-22 16:51:16'),
(17, 100, 'Alex', ':)', 5, '2014-10-22 16:51:07', '2014-10-22 16:51:07'),
(18, 100, 'Alex', ':(', 4, '2014-10-22 16:51:16', '2014-10-22 16:51:16'),
(19, 102, 'Alex', ':)', 5, '2014-10-22 16:51:07', '2014-10-22 16:51:07'),
(20, 102, 'Alex', ':(', 4, '2014-10-22 16:51:16', '2014-10-22 16:51:16'),
(21, 103, 'Alex', ':)', 5, '2014-10-22 16:51:07', '2014-10-22 16:51:07'),
(22, 103, 'Alex', ':(', 4, '2014-10-22 16:51:16', '2014-10-22 16:51:16'),
(23, 104, 'Alex', ':)', 5, '2014-10-22 16:51:07', '2014-10-22 16:51:07'),
(24, 104, 'Alex', ':(', 4, '2014-10-22 16:51:16', '2014-10-22 16:51:16');

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
  `phone` varchar(30) collate utf8_unicode_ci,
  `company_name` varchar(255) collate utf8_unicode_ci,
  `company_info` varchar(255) collate utf8_unicode_ci,
  `company_vat` varchar(255) collate utf8_unicode_ci DEFAULT NULL,
  `tracking` varchar(255),
  `ref` varchar(255),
  `ip` varchar(255),
  `forwarded_ip` varchar(255),
  `user_agent` varchar(255),
  `accept_language` varchar(255),
  `created` datetime,
  `modified` datetime,
  PRIMARY KEY  (`id`),
  INDEX order_status_id (order_status_id),
  INDEX customer_id (customer_id),
  INDEX created (created)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS order_comments;
CREATE TABLE `order_comments` (
  `id` int(10) auto_increment,
  `user_id` int(10),
  `order_id` int(10),
  `sent_to_customer` tinyint(4),
  `comment` text collate utf8_unicode_ci,
  `created` datetime,
  `modified` datetime,
  PRIMARY KEY  (`id`),
  INDEX user_id (user_id),
  INDEX order_id (order_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS order_products;
CREATE TABLE `order_products` (
  `id` int(10) auto_increment,
  `order_id` int(10),
  `content_id` int(10),
  `name` varchar(255) collate utf8_unicode_ci,
  `model` varchar(255) collate utf8_unicode_ci,
  `sku` varchar(255) collate utf8_unicode_ci,
  `quantity` int(10),
  `price` double,
  `weight` double,
  `length` double,
  `width` double,
  `height` double,
  `volume` double,
  `tax` double,
  `filename` varchar(255) COLLATE utf8_unicode_ci,
  `filestorename` varchar(255) COLLATE utf8_unicode_ci,
  `download_count` int(11),
  `max_downloads` int(10) DEFAULT '0',
  `max_days_for_download` int(10) DEFAULT '0',
  `download_key` varchar(256) COLLATE utf8_unicode_ci,
  `order_status_id` int(10),
  PRIMARY KEY  (`id`),
  INDEX order_id (order_id),
  INDEX content_id (content_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  PRIMARY KEY  (`id`),
  INDEX order_status_id (order_status_id)
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
  `description` text collate utf8_unicode_ci,
  `icon` varchar(255) collate utf8_unicode_ci,
  `alias` varchar(255) collate utf8_unicode_ci,
  `order` int(10),
  `order_status_id` int(10),
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `payment_methods` (`id`, `active`, `default`, `name`, `description`, `icon`, `alias`, `order`, `order_status_id`) VALUES 
(1, 1, 0, 'In-store Pickup', 'Description', 'pickup.png', 'StorePickup', 0, 0),
(2, 1, 1, 'Money Order Check', '', 'moneyorder.png', 'MoneyOrderCheck', 0, 0),
(3, 1, 0, 'Paypal', '', 'paypal.png', 'Paypal', 0, 0),
(4, 1, 0, 'Credit Card', '', 'creditcard.png', 'CreditCard', 0, 0),
(5, 1, 0, 'Authorize.Net', '', 'authorize.png', 'Authorize', 0, 0),
(6, 1, 0, 'Google Checkout', '', 'googlecheckout.png', 'GoogleHtml', 0, 0);

DROP TABLE IF EXISTS payment_method_values;
CREATE TABLE `payment_method_values` (
  `id` int(10) auto_increment,
  `payment_method_id` int(10),
  `key` varchar(255) collate utf8_unicode_ci,
  `value` text collate utf8_unicode_ci,
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
(2, 'ContentDescription', 'name', '/contents/admin_edit/', 'content_id', ''),
(3, 'ContentDescription', 'description', '/contents/admin_edit/', 'content_id', 'name'),
(4, 'ContentDescription', 'short_description', '/contents/admin_edit/', 'content_id', 'name'),
(5, 'ContentProduct', 'model', '/contents/admin_edit/', 'content_id', ''),
(6, 'ContentLink', 'url', '/contents/admin_edit/', 'content_id', ''),
(7, 'Language', 'name', '/languages/admin_edit/', 'id', ''),
(8, 'Template', 'name', '/templates/admin_edit/', 'id', ''),
(9, 'Template', 'template', '/templates/admin_edit/', 'id', 'name'),
(10, 'Stylesheet', 'name', '/stylesheets/admin_edit/', 'id', ''),
(11, 'Stylesheet', 'stylesheet', '/stylesheets/admin_edit/', 'id', 'name'),
(12, 'Customer', 'name', '/customers/admin_edit/', 'id', ''),
(13, 'Customer', 'email', '/customers/admin_edit/', 'id', '');

DROP TABLE IF EXISTS shipping_methods;
CREATE TABLE `shipping_methods` (
  `id` int(10) auto_increment,
  `name` varchar(255) collate utf8_unicode_ci,
  `description` text collate utf8_unicode_ci,
  `icon` varchar(255) collate utf8_unicode_ci,
  `code` varchar(255) collate utf8_unicode_ci,
  `default` tinyint(4) default '0',
  `active` tinyint(4),
  `order` int(10),
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `shipping_methods` (`id`, `name`, `description`, `icon`, `code`, `default`, `active`, `order`) VALUES
(1, 'FlatRate', 'Description', 'flat.png', 'FlatRate', 1, 1, 0),
(2, 'PerItem', '', 'item.png', 'PerItem', 0, 1, 0),
(3, 'RussianPost', '', 'russianpost.png', 'RussianPost', 0, 1, 0),
(4, 'TableBased', '', 'table.png', 'TableBased', 0, 1, 0),
(5, 'ZoneBased', '', 'zone.png', 'ZoneBased', 0, 1, 0);

DROP TABLE IF EXISTS shipping_method_values;
CREATE TABLE `shipping_method_values` (
  `id` int(10) auto_increment,
  `shipping_method_id` int(10),
  `key` varchar(255) collate utf8_unicode_ci,
  `value` text collate utf8_unicode_ci,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `shipping_method_values` (`id`, `shipping_method_id`, `key`, `value`) VALUES
(1, 1, 'cost', '0'),
(2, 2, 'per_item_amount', '1.00'),
(3, 2, 'per_item_handling', '5.00'),
(4, 3, 'russian_post_type', 'weight'),
(5, 3, 'russian_post_zone_1', '1'),
(6, 3, 'russian_post_cost_1', '0.5:97,1:105,1.5:113,2:121,2.5:129,3:137,3.5:145,4:153,4.5:161,5:169,5.5:177,6:185,6.5:193,7:201,7.5:209,8:217,8.5:225,9:233,9.5:241,10:249,10.5:318,11:327,11.5:337,12:347,12.5:357,13:367,13.5:377,14:387,14.5:397,15:407,15.5:417,16:427,16.5:437,17:447,17.5:457,18:467,18.5:477,19:487,19.5:497,20:507'),
(7, 3, 'russian_post_handling_1', ''),
(8, 3, 'russian_post_zone_2', '2'),
(9, 3, 'russian_post_cost_2', '0.5:98,1:107,1.5:116,2:125,2.5:134,3:143,3.5:152,4:161,4.5:170,5:179,5.5:188,6:197,6.5:206,7:215,7.5:224,8:233,8.5:242,9:251,9.5:260,10:269,10.5:348,11:359,11.5:370,12:381,12.5:392,13:403,13.5:414,14:425,14.5:436,15:447,15.5:458,16:469,16.5:480,17:491,17.5:502,18:513,18.5:524,19:535,19.5:546,20:557'),
(10, 3, 'russian_post_handling_2', ''),
(11, 3, 'russian_post_zone_3', '3'),
(12, 3, 'russian_post_cost_3', '0.5:102,1:115,1.5:128,2:141,2.5:154,3:167,3.5:180,4:193,4.5:206,5:219,5.5:232,6:245,6.5:258,7:271,7.5:284,8:297,8.5:310,9:323,9.5:336,10:349,10.5:457,11:473,11.5:489,12:505,12.5:521,13:537,13.5:553,14:569,14.5:585,15:601,15.5:617,16:633,16.5:649,17:665,17.5:681,18:697,18.5:713,19:729,19.5:745,20:761'),
(13, 3, 'russian_post_handling_3', ''),
(14, 3, 'russian_post_zone_4', '4'),
(15, 3, 'russian_post_cost_4', '0.5:125,1:143,1.5:161,2:179,2.5:197,3:215,3.5:233,4:251,4.5:269,5:287,5.5:305,6:323,6.5:341,7:359,7.5:377,8:395,8.5:413,9:431,9.5:449,10:467,10.5:629,11:652,11.5:675,12:698,12.5:721,13:744,13.5:767,14:790,14.5:813,15:836,15.5:859,16:882,16.5:905,17:928,17.5:951,18:974,18.5:997,19:1020,19.5:1043,20:1066'),
(16, 3, 'russian_post_handling_4', ''),
(17, 3, 'russian_post_zone_5', '5'),
(18, 3, 'russian_post_cost_5', '0.5:165,1:211,1.5:257,2:303,2.5:349,3:395,3.5:441,4:487,4.5:533,5:579,5.5:625,6:671,6.5:717,7:763,7.5:809,8:855,8.5:901,9:947,9.5:993,10:1039,10.5:1145,11:1191,11.5:1237,12:1283,12.5:1329,13:1375,13.5:1421,14:1467,14.5:1513,15:1559,15.5:1605,16:1651,16.5:1697,17:1743,17.5:1789,18:1835,18.5:1881,19:1927,19.5:1973,20:2019'),
(19, 3, 'russian_post_handling_5', ''),
(20, 4, 'table_based_type', 'weight'),
(21, 4, 'table_based_rates', '0:0.50,1:1.50,2:2.25,3:3.00,4:5.75'),
(22, 5, 'zone_based_type', 'weight'),
(23, 5, 'zone_based_zone_1', ''),
(24, 5, 'zone_based_cost_1', ''),
(25, 5, 'zone_based_handling_1', ''),
(26, 5, 'zone_based_zone_2', ''),
(27, 5, 'zone_based_cost_2', ''),
(28, 5, 'zone_based_handling_2', ''),
(29, 5, 'zone_based_zone_3', ''),
(30, 5, 'zone_based_cost_3', ''),
(31, 5, 'zone_based_handling_3', ''),
(32, 5, 'zone_based_zone_4', ''),
(33, 5, 'zone_based_cost_4', ''),
(34, 5, 'zone_based_handling_4', ''),
(35, 5, 'zone_based_zone_5', ''),
(36, 5, 'zone_based_cost_5', ''),
(37, 5, 'zone_based_handling_5', ''),
(38, 5, 'zone_based_zone_6', ''),
(39, 5, 'zone_based_cost_6', ''),
(40, 5, 'zone_based_handling_6', ''),
(41, 5, 'zone_based_zone_7', ''),
(42, 5, 'zone_based_cost_7', ''),
(43, 5, 'zone_based_handling_7', ''),
(44, 5, 'zone_based_zone_8', ''),
(45, 5, 'zone_based_cost_8', ''),
(46, 5, 'zone_based_handling_8', ''),
(47, 5, 'zone_based_zone_9', ''),
(48, 5, 'zone_based_cost_9', ''),
(49, 5, 'zone_based_handling_9', ''),
(50, 5, 'zone_based_zone_10', ''),
(51, 5, 'zone_based_cost_10', ''),
(52, 5, 'zone_based_handling_10', '');

DROP TABLE IF EXISTS stylesheets;
CREATE TABLE `stylesheets` (
  `id` int(10) auto_increment,
  `active` tinyint(4),
  `name` varchar(255) collate utf8_unicode_ci,
  `alias` varchar(255) collate utf8_unicode_ci,
  `stylesheet` longtext collate utf8_unicode_ci,
  `stylesheet_media_type_id` int(10),
  `created` datetime,
  `modified` datetime,
  PRIMARY KEY  (`id`),
  INDEX indx (active,alias)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `stylesheets` (`id`, `active`, `name`, `alias`, `stylesheet`, `stylesheet_media_type_id`, `created`, `modified`) VALUES
(1, 1, 'VamShop', 'vamshop', '', 0, '2009-07-14 18:44:00', '2014-07-13 15:42:53');

DROP TABLE IF EXISTS stylesheet_logs;
CREATE TABLE `stylesheet_logs` (
  `id` int(10) auto_increment,
  `stylesheet_id` int(10),
  `active` tinyint(4),
  `name` varchar(255) collate utf8_unicode_ci,
  `alias` varchar(255) collate utf8_unicode_ci,
  `stylesheet` longtext collate utf8_unicode_ci,
  `stylesheet_media_type_id` int(10),
  `created` datetime,
  `modified` datetime,
  PRIMARY KEY  (`id`),
  INDEX indx (active,alias)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
(1, 1, 'Non-Taxable', '2009-08-03 20:39:02', '2009-08-06 10:03:37');

DROP TABLE IF EXISTS tax_country_zone_rates;
CREATE TABLE `tax_country_zone_rates` (
  `id` int(10) auto_increment,
  `tax_id` int(10),
  `country_zone_id` int(10),
  `rate` double,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS templates;
CREATE TABLE `templates` (
  `id` int(10) auto_increment,
  `parent_id` int(10),
  `template_type_id` int(10),
  `default` tinyint(4) default '0',
  `name` varchar(255) collate utf8_unicode_ci,
  `template` longtext collate utf8_unicode_ci,
  `created` datetime,
  `modified` datetime,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `templates` (`id`, `parent_id`, `template_type_id`, `default`, `name`, `template`, `created`, `modified`) VALUES
(1, 0, 0, 1, 'Default Theme', '', '2013-10-01 16:07:25', '2013-04-17 16:07:25'),
(2, 1, 1, 0, 'Main Layout', '<!DOCTYPE html>\r\n<html lang="{$language}">\r\n<head>\r\n  <title>{meta_title}{if {filter_active_name}} {filter_active_name}{/if} - {config value=site_name}</title>\r\n  <meta name="description" content="{meta_description}{if {filter_active_name}} {filter_active_name}{/if}" />\r\n  <meta name="keywords" content="{meta_keywords}{if {filter_active_name}} {filter_active_name}{/if}" />\r\n  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>\r\n  <meta name="viewport" content="initial-scale=1.0, width=device-width"/>\r\n  {metadata}\r\n  {headdata}\r\n  <link rel="shortcut icon" href="{base_path}/favicon.ico"/>\r\n  {bender src="{base_path}/css/bootstrap3/bootstrap.min.css"}\r\n  {bender src="{base_path}/css/font-roboto.css"}\r\n  {bender src="{base_path}/css/font-awesome.min.css"}\r\n  {bender src="{base_path}/css/jquery/plugins/push-menu/push-menu.css"}\r\n  {bender src="{base_path}/css/jquery/plugins/colorbox/colorbox.css"}\r\n  {bender src="{base_path}/css/jquery/plugins/chosen/bootstrap-chosen.css"}\r\n  {bender src="{base_path}/css/jquery/plugins/bxslider/jquery.bxslider.css"}\r\n  {bender src="{base_path}/css/jquery/plugins/sequence/sequence.css"}\r\n  {bender src="{base_path}/css/vamshop.css"}\r\n  {bender output="{base_path}/css/vamshop-packed.css"}\r\n  {stylesheet}\r\n  <script>{literal}(function(w,d,u){w.readyQ=[];w.bindReadyQ=[];function p(x,y){if(x=="ready"){w.bindReadyQ.push(y);}else{w.readyQ.push(x);}};var a={ready:p,bind:p};w.$=w.jQuery=function(f){if(f===d||f===u){return a}else{p(f)}}})(window,document){/literal}</script>\r\n</head>\r\n<body>\r\n  <!-- start: Header -->\r\n  <header>\r\n  <div class="container">\r\n   <div class="topbar clearfix">\r\n       <ul class="nav nav-pills top-contacts pull-left">\r\n         <li><a href="tel:{config value=telephone}"><i class="fa fa-phone"></i> {config value=telephone}</a></li>\r\n         <li><a href="{config value=twitter}"><i class="fa fa-twitter"></i> Twitter</a></li>\r\n         <li><a href="{config value=facebook}"><i class="fa fa-facebook"></i> Facebook</a></li>\r\n         <li><a href="{base_path}/page/contact-us{config value=url_extension}"><i class="fa fa-pencil"></i> {lang}Contact Us{/lang}</a></li>\r\n       </ul>\r\n   </div>\r\n   <div class="row">\r\n     <div class="col-sm-5">\r\n       <a href="{base_path}/"><img src="{base_path}/img/logo.png" alt="{config value=site_name}" title="{config value=site_name}" width="247" height="98" /></a>\r\n     </div>\r\n     <div class="col-sm-5">\r\n     </div>\r\n     <div class="col-sm-2">\r\n     </div>\r\n   </div>\r\n  </div>\r\n  </header>\r\n  <!-- end: Header -->\r\n\r\n <div class="nav-wrapper">\r\n <nav id="nav" data-spy="affix" data-offset-top="140" data-offset-bottom="0">    \r\n  <div class="navbar navbar-default navigation">\r\n   <div class="container">    \r\n    <div class="navbar-header">\r\n      <button type="button" class="navbar-toggle toggle-menu menu-left" aria-label="navbar" data-toggle="collapse" data-target="#navbar-collapse">\r\n        <span class="sr-only"></span>                \r\n        <span class="icon-bar"></span>\r\n        <span class="icon-bar"></span>\r\n        <span class="icon-bar"></span>\r\n      </button>\r\n     <a class="navbar-brand" href="{base_path}/" aria-hidden="true">\r\n         <i class="fa fa-home"></i>\r\n     </a>\r\n    </div>\r\n    <div class="collapse navbar-collapse navbar-default cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="navbar-collapse">\r\n   <ul class="nav navbar-nav">\r\n     <li class="dropdown">\r\n       <a data-toggle="dropdown" class="dropdown-toggle" href="">{lang}Categories{/lang} <b class="caret"></b></a>\r\n         <ul class="dropdown-menu">\r\n           {content_listing template="links" parent="0" type="category"}\r\n         </ul>\r\n     </li>\r\n   </ul>\r\n     <form class="navbar-form navbar-left" role="search" id="search" action="{base_path}/page/search-result{config value=url_extension}" method="get" autocomplete="off">\r\n       <div class="input-group">\r\n           <input type="text" class="form-control" placeholder="{lang}Search{/lang}" name="keyword" id="search-keywords" aria-label="search" autocomplete="off">\r\n           <div class="input-group-btn">\r\n               <button class="btn btn-primary" aria-label="submit" type="submit"><i class="fa fa-search"></i></button>\r\n           </div>\r\n       </div>\r\n       <div id="searchPreview"></div>\r\n     </form>\r\n      <ul class="nav navbar-nav navbar-right">\r\n         <li><a href="{base_path}/page/account{config value=url_extension}" title="{lang}My Orders{/lang}"><i class="fa fa-user"></i> {lang}My Orders{/lang}</a></li>\r\n         <li class="dropdown"><a data-toggle="dropdown" class="dropdown-toggle cart" data-target="#" href="{base_path}/page/cart-contents{config value=url_extension}" title="{lang}Cart{/lang}"><i class="fa fa-shopping-cart"></i> {lang}Cart{/lang} {if {shopping_cart_total} > 0}<sup><span title="{shopping_cart_total}" class="badge progress-bar-danger">{shopping_cart_total}</span></sup>{/if} <span class="caret"></span></a>\r\n	         <ul class="dropdown-menu cart">\r\n	           <li><div id="shopping-cart-box">{shopping_cart template="cart-content-box" showempty="true"}</div></li>\r\n	         </ul>\r\n         </li>\r\n      </ul>\r\n    </div>\r\n   </div>\r\n  </div>  \r\n </nav>\r\n </div>  \r\n\r\n{flash_message}          \r\n \r\n <div class="container">\r\n   <div class="row content">\r\n   \r\n      {breadcrumbs}\r\n     \r\n      {if $content_type == "category"}<div class="col-md-9 col-md-push-3">{/if}\r\n      <div id="ajaxcontent">\r\n        {if isset($is_compared)}{compared}{else}{content}{/if}\r\n		{if $content_alias == "home-page"}\r\n		{content_listing template="subcategory-listing" parent="0" type="category" limit="3"}\r\n		{content_listing template="slider" parent="tablets" type="product" limit="9"}\r\n		{content_listing template="featured-products" parent="smartphones" type="product" limit="9"}\r\n		{/if}       \r\n      </div>\r\n      {if $content_type == "category"}</div>{/if}\r\n\r\n     {if $content_type == "category"}\r\n     <div class="col-md-3 col-md-pull-9">\r\n       <div class="widget inner categories-widget">\r\n         <h3 class="widget-title">{lang}Categories{/lang}</h3>\r\n           <ul class="icons clearfix">\r\n             {content_listing template="links" parent="0" type="category"}\r\n           </ul>\r\n       </div>\r\n       <div class="widget inner brands-widget">\r\n         <h3 class="widget-title">{lang}Brands{/lang}</h3>\r\n           <ul class="icons clearfix">\r\n             {content_listing template="links" parent="brands" type="manufacturer" category={$content_id}}\r\n           </ul>\r\n       </div>\r\n       {filter}\r\n       {compare}\r\n     </div>\r\n     {/if}\r\n\r\n   </div><!-- /.row -->\r\n\r\n </div><!-- /.container -->\r\n\r\n <!-- Site footer -->\r\n <footer>\r\n <div class="container">\r\n <div class="row">\r\n   <div class="col-sm-4">\r\n     <div class="widget information-widget">\r\n       <h3 class="widget-title">{lang}Information{/lang}</h3>\r\n         <ul class="icons clearfix">\r\n           {content_listing template="links" parent="information" type="page" limit="10"}\r\n         </ul>\r\n     </div>\r\n   </div>\r\n   <div class="col-sm-4">\r\n     <div class="widget news-widget">\r\n       <h3 class="widget-title">{lang}News{/lang}</h3>\r\n         <ul class="icons clearfix">\r\n           {content_listing template="links" parent="news" type="news" limit="10"}\r\n         </ul>\r\n     </div>\r\n   </div>\r\n   <div class="col-sm-4">\r\n     <div class="widget articles-widget">\r\n       <h3 class="widget-title">{lang}Articles{/lang}</h3>\r\n         <ul class="icons clearfix">\r\n           {content_listing template="links" parent="articles" type="article" limit="10"}\r\n         </ul>\r\n     </div>\r\n   </div>\r\n </div>\r\n <div class="text-center">\r\n  {global_content alias="footer"}\r\n </div>\r\n </div>\r\n </footer>\r\n\r\n{bender src="{base_path}/js/jquery/jquery.min.js"}\r\n{bender src="{base_path}/js/bootstrap3/bootstrap.min.js"}\r\n{bender src="{base_path}/js/ie10-viewport-bug-workaround.js"}\r\n{bender src="{base_path}/js/jquery/plugins/jpushmenu/jpushmenu.js"}\r\n{bender src="{base_path}/js/jquery/plugins/colorbox/jquery.colorbox-min.js"}\r\n{bender src="{base_path}/js/jquery/plugins/cookie/jquery.cookie.js"}\r\n{bender src="{base_path}/js/jquery/plugins/chosen/chosen.jquery.js"}\r\n{bender src="{base_path}/js/jquery/plugins/bxslider/jquery.bxslider.min.js"}\r\n{bender src="{base_path}/js/jquery/plugins/sequence/jquery.sequence-min.js"}\r\n{bender src="{base_path}/js/jquery/plugins/scrollup/jquery.scrollup.min.js"}\r\n{bender src="{base_path}/js/jquery/plugins/maskedinput/jquery.maskedinput.min.js"}\r\n{bender src="{base_path}/js/jquery/plugins/validate/jquery.validate.pack.js"}\r\n{bender src="{base_path}/js/vamshop.js"}\r\n{bender output="{base_path}/js/vamshop-packed.js"}\r\n<script>{literal}(function($,d){$.each(readyQ,function(i,f){$(f)});$.each(bindReadyQ,function(i,f){$(d).on("ready",f)})})(jQuery,document){/literal}</script>\r\n<!--[if lt IE 9]>\r\n<script src="{base_path}/js/html5.js"></script>\r\n<script src="{base_path}/js/respond.min.js"></script>\r\n<![endif]-->\r\n\r\n{google_analytics}\r\n{yandex_metrika}\r\n\r\n</body>\r\n</html>', '2013-10-01 16:07:25', '2014-12-28 17:19:43'),
(3, 1, 2, 0, 'Content Page', '<!-- start: Page section -->\r\n  <div class="content page">\r\n      {if $content_alias != "home-page"}<h2>{page_name}</h2>{/if}              \r\n      {description}\r\n  </div>\r\n<!-- end: Page section -->', '2013-10-01 16:07:25', '2014-12-28 17:19:52'),
(4, 1, 3, 0, 'Product Info', '<!-- start: Page section -->\r\n  <div class="content product-info" itemscope itemtype="http://schema.org/Product">\r\n    <h2 itemprop="name">{page_name}</h2>              \r\n    <div class="row">\r\n      <!-- start: Product image -->\r\n        <div class="col-md-6">\r\n        {content_images}\r\n        </div>\r\n      <!-- end: Product image -->\r\n      <!-- start: Product info -->\r\n        <div class="col-md-6 product-info">\r\n          {module alias="reviews" action="reviews_total"}{module alias="reviews" action="reviews_rating"}\r\n          {product_manufacturer}\r\n          <br />\r\n          <div class="description" itemprop="offers" itemscope itemtype="http://schema.org/Offer">{lang}Price{/lang}: <span class="price" itemprop="price">{product_price}</span></div>\r\n          <br />\r\n          {if {product_price_old}}<div class="description">{lang}List Price{/lang}: <span class="old-price"><del>{product_price_old}</del></span></div>{/if}\r\n          {if {product_price_save}}<div class="description">{lang}You Save{/lang}: <span class="save">{product_price_save}</span></div><br />{/if}\r\n                  \r\n          {discount_group}\r\n          {discount_list}\r\n\r\n          {attribute_list}\r\n          \r\n          {product_form}\r\n          <div class="form-group">\r\n            <label class="sr-only">{lang}Qty{/lang}</label>\r\n            <input name="product_quantity" class="form-control" id="product_quantity" type="text" value="1" size="1" aria-label="quantity" />\r\n          </div>          \r\n          <div class="form-group">\r\n          <button type="submit" class="btn btn-warning"><i class="fa fa-shopping-cart"></i> {lang}Add to cart{/lang}</button>\r\n          </div>          \r\n          {module alias="one_click_buy" controller="buy" action="link"}\r\n          {module alias="ask_a_product_question" controller="get" action="ask_link"}\r\n          {/product_form}\r\n\r\n          {payment_methods limit="3"}\r\n          {shipping_methods limit="3"}\r\n          \r\n        </div>\r\n      <!-- end: Product info -->\r\n\r\n\r\n    </div>\r\n\r\n      <div class="row product-tabs">\r\n\r\n          <ul class="nav nav-tabs">\r\n            <li class="active"><a href="#description" aria-controls="description" data-toggle="tab"><i class="fa fa-thumbs-up"></i> {lang}Description{/lang}</a></li>\r\n            <li><a href="#reviews" aria-controls="reviews" data-toggle="tab"><i class="fa fa-comment"></i> {lang}Reviews{/lang}</a></li>\r\n            <li><a href="#add-review" aria-controls="add-review" data-toggle="tab"><i class="fa fa-pencil"></i> {lang}Add Review{/lang}</a></li>\r\n          </ul>\r\n\r\n          <div class="tab-content">\r\n\r\n            <div class="tab-pane inner fade in notop active" id="description">\r\n              <div itemprop="description">{description}</div>\r\n            </div>\r\n\r\n            <div class="tab-pane inner fade in notop" id="reviews">\r\n              {module alias="reviews" action="display"}\r\n            </div>\r\n\r\n            <div class="tab-pane inner fade in notop" id="add-review">\r\n              {module alias="reviews" action="create"}\r\n            </div>\r\n\r\n          </div>\r\n\r\n      </div>\r\n\r\n    {xsell}\r\n\r\n  </div>\r\n<!-- end: Page section -->', '2013-10-01 16:07:25', '2014-12-28 17:20:01'),
(5, 1, 4, 0, 'Category Info', '<!-- start: Page section -->\r\n  <div class="content listing">\r\n      {if $content_alias != "home-page"}<h2>{page_name}{if {filter_active_name}} {filter_active_name}{/if}</h2>{/if}              \r\n      {description}\r\n\r\n    {if $sub_count->value.categories > 0}\r\n      <div class="content_listing">\r\n          {content_listing template="subcategory-listing" parent={$content_id} type="category"}\r\n      </div>\r\n    {/if}\r\n\r\n    {if $sub_count->value.manufacturers > 0}\r\n      <div class="content_listing">\r\n          {content_listing template="subcategory-listing" parent={$content_id} type="manufacturer"}\r\n      </div>\r\n    {/if}\r\n      \r\n    {if $sub_count->value.products + $sub_count->value.downloadables > 0}\r\n      <div class="content_listing">\r\n        {content_listing template="product-listing" parent={$content_id} page={$page} type="product,downloadable" current_order={$current_order}}\r\n      </div>\r\n    {/if}\r\n\r\n    {if $sub_count->value.pages > 0 or $sub_count->value.news > 0 or $sub_count->value.articles > 0}\r\n      <div class="content_listing">\r\n        <ul class="icons">\r\n        {content_listing template="links" parent={$content_id}}\r\n        </ul>\r\n      </div>\r\n    {/if}\r\n</div>\r\n<!-- end: Page section -->', '2013-10-01 16:07:25', '2014-12-28 17:20:12'),
(6, 1, 5, 0, 'News Page', '<!-- start: Page section -->\r\n  <div class="content news">\r\n      {if $content_alias != "home-page"}<h2>{page_name}</h2>{/if}              \r\n      {description}\r\n  </div>\r\n<!-- end: Page section -->', '2013-10-01 16:07:25', '2014-12-28 17:20:24'),
(7, 1, 6, 0, 'Article Page', '<!-- start: Page section -->\r\n  <div class="content article">\r\n      {if $content_alias != "home-page"}<h2>{page_name}</h2>{/if}              \r\n      {description}\r\n  </div>\r\n<!-- end: Page section -->', '2013-10-01 16:07:25', '2014-12-28 17:20:32'),
(8, 1, 7, 0, 'Manufacturer Info', '<!-- start: Page section -->\r\n  <div class="content manufacturer">\r\n    {if $content_alias != "home-page"}<h2>{page_name}</h2>{/if}              \r\n    {description}\r\n    {content_images number=1 content_id={$content_id}}\r\n\r\n    {if $sub_count->value.manufacturer_products}\r\n    <div class="content_listing">\r\n      {content_listing template="product-listing" manufacturer={$content_id} page={$page} type="product,downloadable" current_order={$current_order}}\r\n    </div>\r\n    {/if}\r\n</div>\r\n<!-- end: Page section -->', '2013-10-01 16:07:25', '2014-12-28 17:20:41');

DROP TABLE IF EXISTS template_logs;
CREATE TABLE `template_logs` (
  `id` int(10) auto_increment,
  `template_id` int(10),
  `parent_id` int(10),
  `template_type_id` int(10),
  `default` tinyint(4) default '0',
  `name` varchar(255) collate utf8_unicode_ci,
  `template` longtext collate utf8_unicode_ci,
  `created` datetime,
  `modified` datetime,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  `default_template` longtext collate utf8_unicode_ci,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `template_types` (`id`, `name`, `default_template`) VALUES 
(1, 'Main Layout', '<!DOCTYPE html>\r\n<html lang="{$language}">\r\n<head>\r\n  <title>{meta_title}{if {filter_active_name}} {filter_active_name}{/if} - {config value=site_name}</title>\r\n  <meta name="description" content="{meta_description}{if {filter_active_name}} {filter_active_name}{/if}" />\r\n  <meta name="keywords" content="{meta_keywords}{if {filter_active_name}} {filter_active_name}{/if}" />\r\n  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>\r\n  <meta name="viewport" content="initial-scale=1.0, width=device-width"/>\r\n  {metadata}\r\n  {headdata}\r\n  <link rel="shortcut icon" href="{base_path}/favicon.ico"/>\r\n  {bender src="{base_path}/css/bootstrap3/bootstrap.min.css"}\r\n  {bender src="{base_path}/css/font-roboto.css"}\r\n  {bender src="{base_path}/css/font-awesome.min.css"}\r\n  {bender src="{base_path}/css/jquery/plugins/push-menu/push-menu.css"}\r\n  {bender src="{base_path}/css/jquery/plugins/colorbox/colorbox.css"}\r\n  {bender src="{base_path}/css/jquery/plugins/chosen/bootstrap-chosen.css"}\r\n  {bender src="{base_path}/css/jquery/plugins/bxslider/jquery.bxslider.css"}\r\n  {bender src="{base_path}/css/jquery/plugins/sequence/sequence.css"}\r\n  {bender src="{base_path}/css/vamshop.css"}\r\n  {bender output="{base_path}/css/vamshop-packed.css"}\r\n  {stylesheet}\r\n  <script>{literal}(function(w,d,u){w.readyQ=[];w.bindReadyQ=[];function p(x,y){if(x=="ready"){w.bindReadyQ.push(y);}else{w.readyQ.push(x);}};var a={ready:p,bind:p};w.$=w.jQuery=function(f){if(f===d||f===u){return a}else{p(f)}}})(window,document){/literal}</script>\r\n</head>\r\n<body>\r\n  <!-- start: Header -->\r\n  <header>\r\n  <div class="container">\r\n   <div class="topbar clearfix">\r\n       <ul class="nav nav-pills top-contacts pull-left">\r\n         <li><a href="tel:{config value=telephone}"><i class="fa fa-phone"></i> {config value=telephone}</a></li>\r\n         <li><a href="{config value=twitter}"><i class="fa fa-twitter"></i> Twitter</a></li>\r\n         <li><a href="{config value=facebook}"><i class="fa fa-facebook"></i> Facebook</a></li>\r\n         <li><a href="{base_path}/page/contact-us{config value=url_extension}"><i class="fa fa-pencil"></i> {lang}Contact Us{/lang}</a></li>\r\n       </ul>\r\n   </div>\r\n   <div class="row">\r\n     <div class="col-sm-5">\r\n       <a href="{base_path}/"><img src="{base_path}/img/logo.png" alt="{config value=site_name}" title="{config value=site_name}" width="247" height="98" /></a>\r\n     </div>\r\n     <div class="col-sm-5">\r\n     </div>\r\n     <div class="col-sm-2">\r\n     </div>\r\n   </div>\r\n  </div>\r\n  </header>\r\n  <!-- end: Header -->\r\n\r\n <div class="nav-wrapper">\r\n <nav id="nav" data-spy="affix" data-offset-top="140" data-offset-bottom="0">    \r\n  <div class="navbar navbar-default navigation">\r\n   <div class="container">    \r\n    <div class="navbar-header">\r\n      <button type="button" class="navbar-toggle toggle-menu menu-left" aria-label="navbar" data-toggle="collapse" data-target="#navbar-collapse">\r\n        <span class="sr-only"></span>                \r\n        <span class="icon-bar"></span>\r\n        <span class="icon-bar"></span>\r\n        <span class="icon-bar"></span>\r\n      </button>\r\n     <a class="navbar-brand" href="{base_path}/" aria-hidden="true">\r\n         <i class="fa fa-home"></i>\r\n     </a>\r\n    </div>\r\n    <div class="collapse navbar-collapse navbar-default cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="navbar-collapse">\r\n   <ul class="nav navbar-nav">\r\n     <li class="dropdown">\r\n       <a data-toggle="dropdown" class="dropdown-toggle" href="">{lang}Categories{/lang} <b class="caret"></b></a>\r\n         <ul class="dropdown-menu">\r\n           {content_listing template="links" parent="0" type="category"}\r\n         </ul>\r\n     </li>\r\n   </ul>\r\n     <form class="navbar-form navbar-left" role="search" id="search" action="{base_path}/page/search-result{config value=url_extension}" method="get" autocomplete="off">\r\n       <div class="input-group">\r\n           <input type="text" class="form-control" placeholder="{lang}Search{/lang}" name="keyword" id="search-keywords" aria-label="search" autocomplete="off">\r\n           <div class="input-group-btn">\r\n               <button class="btn btn-primary" aria-label="submit" type="submit"><i class="fa fa-search"></i></button>\r\n           </div>\r\n       </div>\r\n       <div id="searchPreview"></div>\r\n     </form>\r\n      <ul class="nav navbar-nav navbar-right">\r\n         <li><a href="{base_path}/page/account{config value=url_extension}" title="{lang}My Orders{/lang}"><i class="fa fa-user"></i> {lang}My Orders{/lang}</a></li>\r\n         <li class="dropdown"><a data-toggle="dropdown" class="dropdown-toggle cart" data-target="#" href="{base_path}/page/cart-contents{config value=url_extension}" title="{lang}Cart{/lang}"><i class="fa fa-shopping-cart"></i> {lang}Cart{/lang} {if {shopping_cart_total} > 0}<sup><span title="{shopping_cart_total}" class="badge progress-bar-danger">{shopping_cart_total}</span></sup>{/if} <span class="caret"></span></a>\r\n	         <ul class="dropdown-menu cart">\r\n	           <li><div id="shopping-cart-box">{shopping_cart template="cart-content-box" showempty="true"}</div></li>\r\n	         </ul>\r\n         </li>\r\n      </ul>\r\n    </div>\r\n   </div>\r\n  </div>  \r\n </nav>\r\n </div>  \r\n\r\n{flash_message}          \r\n \r\n <div class="container">\r\n   <div class="row content">\r\n   \r\n      {breadcrumbs}\r\n     \r\n      {if $content_type == "category"}<div class="col-md-9 col-md-push-3">{/if}\r\n      <div id="ajaxcontent">\r\n        {if isset($is_compared)}{compared}{else}{content}{/if}\r\n		{if $content_alias == "home-page"}\r\n		{content_listing template="subcategory-listing" parent="0" type="category" limit="3"}\r\n		{content_listing template="slider" parent="tablets" type="product" limit="9"}\r\n		{content_listing template="featured-products" parent="smartphones" type="product" limit="9"}\r\n		{/if}       \r\n      </div>\r\n      {if $content_type == "category"}</div>{/if}\r\n\r\n     {if $content_type == "category"}\r\n     <div class="col-md-3 col-md-pull-9">\r\n       <div class="widget inner categories-widget">\r\n         <h3 class="widget-title">{lang}Categories{/lang}</h3>\r\n           <ul class="icons clearfix">\r\n             {content_listing template="links" parent="0" type="category"}\r\n           </ul>\r\n       </div>\r\n       <div class="widget inner brands-widget">\r\n         <h3 class="widget-title">{lang}Brands{/lang}</h3>\r\n           <ul class="icons clearfix">\r\n             {content_listing template="links" parent="brands" type="manufacturer" category={$content_id}}\r\n           </ul>\r\n       </div>\r\n       {filter}\r\n       {compare}\r\n     </div>\r\n     {/if}\r\n\r\n   </div><!-- /.row -->\r\n\r\n </div><!-- /.container -->\r\n\r\n <!-- Site footer -->\r\n <footer>\r\n <div class="container">\r\n <div class="row">\r\n   <div class="col-sm-4">\r\n     <div class="widget information-widget">\r\n       <h3 class="widget-title">{lang}Information{/lang}</h3>\r\n         <ul class="icons clearfix">\r\n           {content_listing template="links" parent="information" type="page" limit="10"}\r\n         </ul>\r\n     </div>\r\n   </div>\r\n   <div class="col-sm-4">\r\n     <div class="widget news-widget">\r\n       <h3 class="widget-title">{lang}News{/lang}</h3>\r\n         <ul class="icons clearfix">\r\n           {content_listing template="links" parent="news" type="news" limit="10"}\r\n         </ul>\r\n     </div>\r\n   </div>\r\n   <div class="col-sm-4">\r\n     <div class="widget articles-widget">\r\n       <h3 class="widget-title">{lang}Articles{/lang}</h3>\r\n         <ul class="icons clearfix">\r\n           {content_listing template="links" parent="articles" type="article" limit="10"}\r\n         </ul>\r\n     </div>\r\n   </div>\r\n </div>\r\n <div class="text-center">\r\n  {global_content alias="footer"}\r\n </div>\r\n </div>\r\n </footer>\r\n\r\n{bender src="{base_path}/js/jquery/jquery.min.js"}\r\n{bender src="{base_path}/js/bootstrap3/bootstrap.min.js"}\r\n{bender src="{base_path}/js/ie10-viewport-bug-workaround.js"}\r\n{bender src="{base_path}/js/jquery/plugins/jpushmenu/jpushmenu.js"}\r\n{bender src="{base_path}/js/jquery/plugins/colorbox/jquery.colorbox-min.js"}\r\n{bender src="{base_path}/js/jquery/plugins/cookie/jquery.cookie.js"}\r\n{bender src="{base_path}/js/jquery/plugins/chosen/chosen.jquery.js"}\r\n{bender src="{base_path}/js/jquery/plugins/bxslider/jquery.bxslider.min.js"}\r\n{bender src="{base_path}/js/jquery/plugins/sequence/jquery.sequence-min.js"}\r\n{bender src="{base_path}/js/jquery/plugins/scrollup/jquery.scrollup.min.js"}\r\n{bender src="{base_path}/js/jquery/plugins/maskedinput/jquery.maskedinput.min.js"}\r\n{bender src="{base_path}/js/jquery/plugins/validate/jquery.validate.pack.js"}\r\n{bender src="{base_path}/js/vamshop.js"}\r\n{bender output="{base_path}/js/vamshop-packed.js"}\r\n<script>{literal}(function($,d){$.each(readyQ,function(i,f){$(f)});$.each(bindReadyQ,function(i,f){$(d).on("ready",f)})})(jQuery,document){/literal}</script>\r\n<!--[if lt IE 9]>\r\n<script src="{base_path}/js/html5.js"></script>\r\n<script src="{base_path}/js/respond.min.js"></script>\r\n<![endif]-->\r\n\r\n{google_analytics}\r\n{yandex_metrika}\r\n\r\n</body>\r\n</html>'),
(2, 'Content Page', '<!-- start: Page section -->\r\n  <div class="content page">\r\n      {if $content_alias != "home-page"}<h2>{page_name}</h2>{/if}              \r\n      {description}\r\n  </div>\r\n<!-- end: Page section -->'),
(3, 'Product Info', '<!-- start: Page section -->\r\n  <div class="content product-info" itemscope itemtype="http://schema.org/Product">\r\n    <h2 itemprop="name">{page_name}</h2>              \r\n    <div class="row">\r\n      <!-- start: Product image -->\r\n        <div class="col-md-6">\r\n        {content_images}\r\n        </div>\r\n      <!-- end: Product image -->\r\n      <!-- start: Product info -->\r\n        <div class="col-md-6 product-info">\r\n          {module alias="reviews" action="reviews_total"}{module alias="reviews" action="reviews_rating"}\r\n          {product_manufacturer}\r\n          <br />\r\n          <div class="description" itemprop="offers" itemscope itemtype="http://schema.org/Offer">{lang}Price{/lang}: <span class="price" itemprop="price">{product_price}</span></div>\r\n          <br />\r\n          {if {product_price_old}}<div class="description">{lang}List Price{/lang}: <span class="old-price"><del>{product_price_old}</del></span></div>{/if}\r\n          {if {product_price_save}}<div class="description">{lang}You Save{/lang}: <span class="save">{product_price_save}</span></div><br />{/if}\r\n                  \r\n          {discount_group}\r\n          {discount_list}\r\n\r\n          {attribute_list}\r\n          \r\n          {product_form}\r\n          <div class="form-group">\r\n            <label class="sr-only">{lang}Qty{/lang}</label>\r\n            <input name="product_quantity" class="form-control" id="product_quantity" type="text" value="1" size="1" aria-label="quantity" />\r\n          </div>          \r\n          <div class="form-group">\r\n          <button type="submit" class="btn btn-warning"><i class="fa fa-shopping-cart"></i> {lang}Add to cart{/lang}</button>\r\n          </div>          \r\n          {module alias="one_click_buy" controller="buy" action="link"}\r\n          {module alias="ask_a_product_question" controller="get" action="ask_link"}\r\n          {/product_form}\r\n\r\n          {payment_methods limit="3"}\r\n          {shipping_methods limit="3"}\r\n          \r\n        </div>\r\n      <!-- end: Product info -->\r\n\r\n\r\n    </div>\r\n\r\n      <div class="row product-tabs">\r\n\r\n          <ul class="nav nav-tabs">\r\n            <li class="active"><a href="#description" aria-controls="description" data-toggle="tab"><i class="fa fa-thumbs-up"></i> {lang}Description{/lang}</a></li>\r\n            <li><a href="#reviews" aria-controls="reviews" data-toggle="tab"><i class="fa fa-comment"></i> {lang}Reviews{/lang}</a></li>\r\n            <li><a href="#add-review" aria-controls="add-review" data-toggle="tab"><i class="fa fa-pencil"></i> {lang}Add Review{/lang}</a></li>\r\n          </ul>\r\n\r\n          <div class="tab-content">\r\n\r\n            <div class="tab-pane inner fade in notop active" id="description">\r\n              <div itemprop="description">{description}</div>\r\n            </div>\r\n\r\n            <div class="tab-pane inner fade in notop" id="reviews">\r\n              {module alias="reviews" action="display"}\r\n            </div>\r\n\r\n            <div class="tab-pane inner fade in notop" id="add-review">\r\n              {module alias="reviews" action="create"}\r\n            </div>\r\n\r\n          </div>\r\n\r\n      </div>\r\n\r\n    {xsell}\r\n\r\n  </div>\r\n<!-- end: Page section -->'),
(4, 'Category Info', '<!-- start: Page section -->\r\n  <div class="content listing">\r\n      {if $content_alias != "home-page"}<h2>{page_name}{if {filter_active_name}} {filter_active_name}{/if}</h2>{/if}              \r\n      {description}\r\n\r\n    {if $sub_count->value.categories > 0}\r\n      <div class="content_listing">\r\n          {content_listing template="subcategory-listing" parent={$content_id} type="category"}\r\n      </div>\r\n    {/if}\r\n\r\n    {if $sub_count->value.manufacturers > 0}\r\n      <div class="content_listing">\r\n          {content_listing template="subcategory-listing" parent={$content_id} type="manufacturer"}\r\n      </div>\r\n    {/if}\r\n      \r\n    {if $sub_count->value.products + $sub_count->value.downloadables > 0}\r\n      <div class="content_listing">\r\n        {content_listing template="product-listing" parent={$content_id} page={$page} type="product,downloadable" current_order={$current_order}}\r\n      </div>\r\n    {/if}\r\n\r\n    {if $sub_count->value.pages > 0 or $sub_count->value.news > 0 or $sub_count->value.articles > 0}\r\n      <div class="content_listing">\r\n        <ul class="icons">\r\n        {content_listing template="links" parent={$content_id}}\r\n        </ul>\r\n      </div>\r\n    {/if}\r\n</div>\r\n<!-- end: Page section -->'),
(5, 'News Page', '<!-- start: Page section -->\r\n  <div class="content news">\r\n      {if $content_alias != "home-page"}<h2>{page_name}</h2>{/if}              \r\n      {description}\r\n  </div>\r\n<!-- end: Page section -->'),
(6, 'Article Page', '<!-- start: Page section -->\r\n  <div class="content article">\r\n      {if $content_alias != "home-page"}<h2>{page_name}</h2>{/if}              \r\n      {description}\r\n  </div>\r\n<!-- end: Page section -->'),
(7, 'Manufacturer Info', '<!-- start: Page section -->\r\n  <div class="content manufacturer">\r\n    {if $content_alias != "home-page"}<h2>{page_name}</h2>{/if}              \r\n    {description}\r\n    {content_images number=1 content_id={$content_id}}\r\n\r\n    {if $sub_count->value.manufacturer_products}\r\n    <div class="content_listing">\r\n      {content_listing template="product-listing" manufacturer={$content_id} page={$page} type="product,downloadable" current_order={$current_order}}\r\n    </div>\r\n    {/if}\r\n</div>\r\n<!-- end: Page section -->');

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

DROP TABLE IF EXISTS user_preves;
CREATE TABLE `user_preves` (
  `id` int(10) auto_increment,
  `user_id` int(10),
  `name` varchar(255) collate utf8_unicode_ci,
  `value` text collate utf8_unicode_ci,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `user_preves` (`id`, `user_id`, `name`, `value`) VALUES 
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
  `groups_customer_id` int(10),
  `oauth_provider` varchar(255),
  `oauth_uid` varchar(255),
  `avatar` varchar(255),
  `name` varchar(32),
  `email` varchar(96),
  `password` varchar(40),
  `inn` varchar(255),
  `kpp` varchar(255),
  `ogrn` varchar(255),
  `company_name` varchar(255),
  `company_city` varchar(255),
  `company_state` varchar(255),
  `code` varchar(255),
  `tracking` varchar(255),
  `ref` varchar(255),
  `ip` varchar(255),
  `forwarded_ip` varchar(255),
  `user_agent` varchar(255),
  `accept_language` varchar(255),
  `created` datetime,
  `modified` datetime,
  PRIMARY KEY (`id`),
  INDEX groups_customer_id (groups_customer_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS customer_messages;
CREATE TABLE `customer_messages` (
  `id` int(10) auto_increment,
  `customer_id` int(10),
  `user_id` int(10),
  `user_name` varchar(255),
  `message` text COLLATE utf8_unicode_ci,
  `sent_to_customer` tinyint(4),
  `created` datetime,
  `modified` datetime,
  PRIMARY KEY  (`id`),
  INDEX customer_id (customer_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS groups_customers;
CREATE TABLE IF NOT EXISTS `groups_customers` (
  `id` int(10) AUTO_INCREMENT,
  `name` varchar(32),
  `price` double,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS groups_customer_descriptions;
CREATE TABLE `groups_customer_descriptions` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `groups_customer_id` int(10) DEFAULT NULL,
  `language_id` int(10) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX groups_customer_id (groups_customer_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  `phone` varchar(30) collate utf8_unicode_ci,
  `created` datetime,
  `modified` datetime,
  PRIMARY KEY  (`id`),
  INDEX customer_id (customer_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS contents_contents;
CREATE TABLE IF NOT EXISTS `contents_contents` (
  `id` int(10) AUTO_INCREMENT,
  `product_id` int(10),
  `related_id` int(10),
  PRIMARY KEY (`id`),
  INDEX product_id (product_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `contents_contents` VALUES 
(1,38,95),
(2,38,96),
(3,38,97),
(4,93,95),
(5,93,96),
(6,93,97),
(7,94,95),
(8,94,97),
(9,94,96),
(11,98,95),
(12,98,96),
(13,98,97),
(14,99,97),
(15,99,96),
(16,99,95),
(17,100,97),
(18,100,96),
(19,100,95),
(20,95,93),
(21,95,38),
(22,95,94),
(23,96,93),
(24,96,38),
(25,96,94),
(26,97,94),
(27,97,38),
(28, 97, 93),
(29, 102, 97),
(30, 102, 95),
(31, 102, 96),
(32, 103, 95),
(33, 103, 97),
(34, 103, 96),
(35, 104, 96),
(36, 104, 95),
(37, 104, 97);

DROP TABLE IF EXISTS search_logs;
CREATE TABLE IF NOT EXISTS `search_logs` (
  `id` int(10) AUTO_INCREMENT,
  `customer_id` int(10),
  `keyword` varchar(32),
  `tracking` varchar(255),
  `ref` varchar(255),
  `ip` varchar(255),
  `forwarded_ip` varchar(255),
  `user_agent` varchar(255),
  `accept_language` varchar(255),
  `created` datetime,
  `modified` datetime,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS contacts;
CREATE TABLE `contacts` (
  `id` int(10) auto_increment,
  `customer_id` int(10),
  `name` varchar(255) collate utf8_unicode_ci,
  `email` varchar(255) collate utf8_unicode_ci,
  `message` text COLLATE utf8_unicode_ci,
  `answered` int(10),
  `tracking` varchar(255),
  `ref` varchar(255),
  `ip` varchar(255),
  `forwarded_ip` varchar(255),
  `user_agent` varchar(255),
  `accept_language` varchar(255),
  `created` datetime,
  `modified` datetime,
  PRIMARY KEY  (`id`),
  INDEX name (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS contact_answers;
CREATE TABLE `contact_answers` (
  `id` int(10) auto_increment,
  `contact_id` int(10),
  `user_id` int(10),
  `user_name` varchar(255),
  `answer` text COLLATE utf8_unicode_ci,
  `sent_to_customer` tinyint(4),
  `created` datetime,
  `modified` datetime,
  PRIMARY KEY  (`id`),
  INDEX contact_id (contact_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;