SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET NAMES 'utf8';

DROP TABLE IF EXISTS configurations;
CREATE TABLE `configurations` (
  `id` int(10) NOT NULL auto_increment,
  `key` varchar(50) collate utf8_unicode_ci NOT NULL,
  `value` varchar(100) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `configurations` (`id`, `key`, `value`) VALUES 
(1, 'METADATA', '<meta name="Generator" content="VaM Shop - vamshop.com" />'),
(2, 'SITE_NAME', 'VaM Shop'),
(3, 'URL_EXTENSION', '.html'),
(4, 'GD_LIBRARY', '0'),
(5, 'THUMBNAIL_SIZE', '125'),
(6, 'CACHE_TIME', '3600'),
(7, 'SEND_EXTRA_EMAIL', 'vam@test.com'),
(8, 'NEW_ORDER_FROM_EMAIL', 'vam@test.com'),
(9, 'NEW_ORDER_FROM_NAME', 'VaM Shop'),
(10, 'NEW_ORDER_STATUS_FROM_EMAIL', 'vam@test.com'),
(11, 'NEW_ORDER_STATUS_FROM_NAME', 'VaM Shop');

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
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `contents` (`id`, `parent_id`, `order`, `hierarchy`, `content_type_id`, `template_id`, `default`, `alias`, `head_data`, `active`, `show_in_menu`, `created`, `modified`) VALUES 
(35, 0, 1, 0, 3, 1, 1, 'home-page', '', 1, 1, '2009-07-28 21:11:18', '2009-09-12 12:30:17'),
(36, 0, 3, 0, 1, 1, 0, 'horns', '', 1, 1, '2009-07-28 21:11:49', '2009-08-01 14:56:05'),
(38, 36, 2, 0, 2, 1, 0, 'elk-horns', '', 1, 1, '2009-07-29 18:54:37', '2009-09-11 11:20:29'),
(39, 0, 2, 0, 1, 1, 0, 'hoofs', '', 1, 1, '2009-07-29 22:02:10', '2009-08-01 14:55:54'),
(44, 0, 4, 0, 3, 1, 0, 'information', '', 1, 0, '2009-07-30 15:34:48', '2009-07-30 15:35:02'),
(45, 44, 1, 0, 3, 1, 0, 'shipping--returns', '', 1, 1, '2009-07-30 15:36:30', '2009-08-06 14:53:16'),
(46, 44, 1, 0, 3, 1, 0, 'privacy-policy', '', 1, 1, '2009-07-30 15:36:54', '2009-07-30 15:37:09'),
(47, 44, 2, 0, 3, 1, 0, 'conditions-of-use', '', 1, 1, '2009-07-30 15:37:33', '2009-07-30 15:37:33'),
(48, 44, 3, 0, 3, 1, 0, 'contact-us', '', 1, 1, '2009-07-30 15:38:03', '2009-07-30 15:38:03'),
(49, -1, 5, 0, 3, 1, 0, 'cart-contents', '', 1, 1, '2009-07-30 20:40:14', '2009-08-09 16:23:47'),
(50, -1, 6, 0, 3, 1, 0, 'checkout', '', 1, 1, '2009-07-30 20:52:36', '2009-08-01 16:54:56'),
(51, -1, 5, 0, 3, 1, 0, 'payment', '', 1, 1, '2009-08-07 11:16:28', '2009-09-01 16:22:10'),
(53, -1, 5, 0, 3, 1, 0, 'thank-you', '', 1, 1, '2009-08-07 11:58:21', '2009-08-15 16:00:40'),
(58, -1, 0, 0, 3, 1, 0, 'read-reviews', '', 1, 0, '2009-08-20 09:37:04', '2009-08-20 09:37:04'),
(59, -1, 0, 0, 3, 1, 0, 'create-review', '', 1, 0, '2009-08-20 09:37:04', '2009-08-20 09:37:04'),
(68, -1, 0, 0, 3, 1, 0, 'coupon-details', '', 1, 0, '2009-09-13 11:11:08', '2009-09-13 11:11:08');

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
(189, 48, 1, 'Contact Us', '<p>Enter your contact information on this page.</p>','', '', ''),
(190, 48, 2, 'Контакты', '<p>Контактная информация.</p>','', '', ''),
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
(359, 51, 1, 'Payment', '{payment}\r\n\r\n<h2 style="margin-top:75px;">{lang}Cart Contents{/lang}<h2>\r\n{shopping_cart template=''payment-view-cart''}','', '', ''),
(360, 51, 2, 'Оплата', '{payment}\r\n\r\n<h2 style="margin-top:75px;">{lang}Cart Contents{/lang}<h2>\r\n{shopping_cart template=''payment-view-cart''}','', '', ''),
(385, 38, 1, 'Elk Horns', 'Product description.','', '', ''),
(386, 38, 2, 'Рога лося', 'Дешевле не найдёте, отличные лосиные рога.','', '', ''),
(391, 35, 1, 'Home', '<p>Welcome to your new online catalog!</p>\r\n<p><a href=''admin/''>Click here to go to the admin area.</a><br />\r\nLogin credentials: admin/password</p>','', '', ''),
(392, 35, 2, 'Главная страница', '<p>Добро пожаловать!</p>\r\n<p><a href=''admin/''>Вход в админку.</a><br />\r\nЛогин/пароль: admin/password</p>','', '', ''),
(393, 68, 1, 'Voucher Details', '{module alias=''coupons'' action=''show_info''}','', '', ''),
(394, 68, 2, 'Информация о купоне', '{module alias=''coupons'' action=''show_info''}','', '', '');

DROP TABLE IF EXISTS content_images;
CREATE TABLE `content_images` (
  `id` int(10) NOT NULL auto_increment,
  `content_id` int(10) NOT NULL,
  `order` int(10) NOT NULL,
  `image` varchar(100) collate utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
(33, 53, '1');

DROP TABLE IF EXISTS content_products;
CREATE TABLE `content_products` (
  `id` int(10) NOT NULL auto_increment,
  `content_id` int(10) NOT NULL,
  `stock` int(10) NOT NULL,
  `model` varchar(50) collate utf8_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `tax_id` int(10) NOT NULL,
  `weight` double NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `content_products` (`id`, `content_id`, `stock`, `model`, `price`, `tax_id`, `weight`) VALUES 
(16, 37, 12, '123456', 10.99, 2, 0),
(17, 38, 22, '', 4.95, 2, 3);

DROP TABLE IF EXISTS content_selflinks;
CREATE TABLE `content_selflinks` (
  `id` int(10) NOT NULL auto_increment,
  `content_id` int(1) NOT NULL,
  `url` varchar(50) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
(5, 0, 'selflink', 'ContentSelflink');

DROP TABLE IF EXISTS countries;
CREATE TABLE `countries` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(64) collate utf8_unicode_ci NOT NULL,
  `iso_code_2` char(2) collate utf8_unicode_ci NOT NULL,
  `iso_code_3` char(3) collate utf8_unicode_ci NOT NULL,
  `address_format` varchar(255) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`),
  KEY `IDX_NAME` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `countries` (`id`, `name`, `iso_code_2`, `iso_code_3`, `address_format`) VALUES 
(1, 'Afghanistan', 'Af', 'AFG', ''),
(2, 'Albania', 'AL', 'ALB', ''),
(3, 'Algeria', 'DZ', 'DZA', ''),
(4, 'American Samoa', 'AS', 'ASM', ''),
(5, 'Andorra', 'AD', 'AND', ''),
(6, 'Angola', 'AO', 'AGO', ''),
(7, 'Anguilla', 'AI', 'AIA', ''),
(8, 'Antarctica', 'AQ', 'ATA', ''),
(9, 'Antigua and Barbuda', 'AG', 'ATG', ''),
(10, 'Argentina', 'AR', 'ARG', ':name\n:street_address\n:postcode :city\n:country'),
(11, 'Armenia', 'AM', 'ARM', ''),
(12, 'Aruba', 'AW', 'ABW', ''),
(13, 'Australia', 'AU', 'AUS', ':name\n:street_address\n:suburb :state_code :postcode\n:country'),
(14, 'Austria', 'AT', 'AUT', ':name\n:street_address\nA-:postcode :city\n:country'),
(15, 'Azerbaijan', 'AZ', 'AZE', ''),
(16, 'Bahamas', 'BS', 'BHS', ''),
(17, 'Bahrain', 'BH', 'BHR', ''),
(18, 'Bangladesh', 'BD', 'BGD', ''),
(19, 'Barbados', 'BB', 'BRB', ''),
(20, 'Belarus', 'BY', 'BLR', ''),
(21, 'Belgium', 'BE', 'BEL', ':name\n:street_address\nB-:postcode :city\n:country'),
(22, 'Belize', 'BZ', 'BLZ', ''),
(23, 'Benin', 'BJ', 'BEN', ''),
(24, 'Bermuda', 'BM', 'BMU', ''),
(25, 'Bhutan', 'BT', 'BTN', ''),
(26, 'Bolivia', 'BO', 'BOL', ''),
(27, 'Bosnia and Herzegowina', 'BA', 'BIH', ''),
(28, 'Botswana', 'BW', 'BWA', ''),
(29, 'Bouvet Island', 'BV', 'BVT', ''),
(30, 'Brazil', 'BR', 'BRA', ':name\n:street_address\n:state\n:postcode\n:country'),
(31, 'British Indian Ocean Territory', 'IO', 'IOT', ''),
(32, 'Brunei Darussalam', 'BN', 'BRN', ''),
(33, 'Bulgaria', 'BG', 'BGR', ''),
(34, 'Burkina Faso', 'BF', 'BFA', ''),
(35, 'Burundi', 'BI', 'BDI', ''),
(36, 'Cambodia', 'KH', 'KHM', ''),
(37, 'Cameroon', 'CM', 'CMR', ''),
(38, 'Canada', 'CA', 'CAN', ':name\n:street_address\n:city :state_code :postcode\n:country'),
(39, 'Cape Verde', 'CV', 'CPV', ''),
(40, 'Cayman Islands', 'KY', 'CYM', ''),
(41, 'Central African Republic', 'CF', 'CAF', ''),
(42, 'Chad', 'TD', 'TCD', ''),
(43, 'Chile', 'CL', 'CHL', ':name\n:street_address\n:city\n:country'),
(44, 'China', 'CN', 'CHN', ':name\n:street_address\n:postcode :city\n:country'),
(45, 'Christmas Island', 'CX', 'CXR', ''),
(46, 'Cocos (Keeling) Islands', 'CC', 'CCK', ''),
(47, 'Colombia', 'CO', 'COL', ''),
(48, 'Comoros', 'KM', 'COM', ''),
(49, 'Congo', 'CG', 'COG', ''),
(50, 'Cook Islands', 'CK', 'COK', ''),
(51, 'Costa Rica', 'CR', 'CRI', ''),
(52, 'Cote D''Ivoire', 'CI', 'CIV', ''),
(53, 'Croatia', 'HR', 'HRV', ''),
(54, 'Cuba', 'CU', 'CUB', ''),
(55, 'Cyprus', 'CY', 'CYP', ''),
(56, 'Czech Republic', 'CZ', 'CZE', ''),
(57, 'Denmark', 'DK', 'DNK', ':name\n:street_address\nDK-:postcode :city\n:country'),
(58, 'Djibouti', 'DJ', 'DJI', ''),
(59, 'Dominica', 'DM', 'DMA', ''),
(60, 'Dominican Republic', 'DO', 'DOM', ''),
(61, 'East Timor', 'TP', 'TMP', ''),
(62, 'Ecuador', 'EC', 'ECU', ''),
(63, 'Egypt', 'EG', 'EGY', ''),
(64, 'El Salvador', 'SV', 'SLV', ''),
(65, 'Equatorial Guinea', 'GQ', 'GNQ', ''),
(66, 'Eritrea', 'ER', 'ERI', ''),
(67, 'Estonia', 'EE', 'EST', ''),
(68, 'Ethiopia', 'ET', 'ETH', ''),
(69, 'Falkland Islands (Malvinas)', 'FK', 'FLK', ''),
(70, 'Faroe Islands', 'FO', 'FRO', ''),
(71, 'Fiji', 'FJ', 'FJI', ''),
(72, 'Finland', 'FI', 'FIN', ':name\n:street_address\nFIN-:postcode :city\n:country'),
(73, 'France', 'FR', 'FRA', ':name\n:street_address\n:postcode :city\n:country'),
(74, 'France, Metropolitan', 'FX', 'FXX', ':name\n:street_address\n:postcode :city\n:country'),
(75, 'French Guiana', 'GF', 'GUF', ':name\n:street_address\n:postcode :city\n:country'),
(76, 'French Polynesia', 'PF', 'PYF', ':name\n:street_address\n:postcode :city\n:country'),
(77, 'French Southern Territories', 'TF', 'ATF', ':name\n:street_address\n:postcode :city\n:country'),
(78, 'Gabon', 'GA', 'GAB', ''),
(79, 'Gambia', 'GM', 'GMB', ''),
(80, 'Georgia', 'GE', 'GEO', ''),
(81, 'Germany', 'DE', 'DEU', ':name\n:street_address\nD-:postcode :city\n:country'),
(82, 'Ghana', 'GH', 'GHA', ''),
(83, 'Gibraltar', 'GI', 'GIB', ''),
(84, 'Greece', 'GR', 'GRC', ''),
(85, 'Greenland', 'GL', 'GRL', ':name\n:street_address\nDK-:postcode :city\n:country'),
(86, 'Grenada', 'GD', 'GRD', ''),
(87, 'Guadeloupe', 'GP', 'GLP', ''),
(88, 'Guam', 'GU', 'GUM', ''),
(89, 'Guatemala', 'GT', 'GTM', ''),
(90, 'Guinea', 'GN', 'GIN', ''),
(91, 'Guinea-Bissau', 'GW', 'GNB', ''),
(92, 'Guyana', 'GY', 'GUY', ''),
(93, 'Haiti', 'HT', 'HTI', ''),
(94, 'Heard and McDonald Islands', 'HM', 'HMD', ''),
(95, 'Honduras', 'HN', 'HND', ''),
(96, 'Hong Kong', 'HK', 'HKG', ':name\n:street_address\n:city\n:country'),
(97, 'Hungary', 'HU', 'HUN', ''),
(98, 'Iceland', 'IS', 'ISL', ':name\n:street_address\nIS:postcode :city\n:country'),
(99, 'India', 'IN', 'IND', ':name\n:street_address\n:city-:postcode\n:country'),
(100, 'Indonesia', 'ID', 'IDN', ':name\n:street_address\n:city :postcode\n:country'),
(101, 'Iran', 'IR', 'IRN', ''),
(102, 'Iraq', 'IQ', 'IRQ', ''),
(103, 'Ireland', 'IE', 'IRL', ':name\n:street_address\nIE-:city\n:country'),
(104, 'Israel', 'IL', 'ISR', ':name\n:street_address\n:postcode :city\n:country'),
(105, 'Italy', 'IT', 'ITA', ':name\n:street_address\n:postcode-:city :state_code\n:country'),
(106, 'Jamaica', 'JM', 'JAM', ''),
(107, 'Japan', 'JP', 'JPN', ':name\n:street_address, :suburb\n:city :postcode\n:country'),
(108, 'Jordan', 'JO', 'JOR', ''),
(109, 'Kazakhstan', 'KZ', 'KAZ', ''),
(110, 'Kenya', 'KE', 'KEN', ''),
(111, 'Kiribati', 'KI', 'KIR', ''),
(112, 'Korea, North', 'KP', 'PRK', ''),
(113, 'Korea, South', 'KR', 'KOR', ''),
(114, 'Kuwait', 'KW', 'KWT', ''),
(115, 'Kyrgyzstan', 'KG', 'KGZ', ''),
(116, 'Laos', 'LA', 'LAO', ''),
(117, 'Latvia', 'LV', 'LVA', ''),
(118, 'Lebanon', 'LB', 'LBN', ''),
(119, 'Lesotho', 'LS', 'LSO', ''),
(120, 'Liberia', 'LR', 'LBR', ''),
(121, 'Libyan Arab Jamahiriya', 'LY', 'LBY', ''),
(122, 'Liechtenstein', 'LI', 'LIE', ''),
(123, 'Lithuania', 'LT', 'LTU', ''),
(124, 'Luxembourg', 'LU', 'LUX', ':name\n:street_address\nL-:postcode :city\n:country'),
(125, 'Macau', 'MO', 'MAC', ''),
(126, 'Macedonia', 'MK', 'MKD', ''),
(127, 'Madagascar', 'MG', 'MDG', ''),
(128, 'Malawi', 'MW', 'MWI', ''),
(129, 'Malaysia', 'MY', 'MYS', ''),
(130, 'Maldives', 'MV', 'MDV', ''),
(131, 'Mali', 'ML', 'MLI', ''),
(132, 'Malta', 'MT', 'MLT', ''),
(133, 'Marshall Islands', 'MH', 'MHL', ''),
(134, 'Martinique', 'MQ', 'MTQ', ''),
(135, 'Mauritania', 'MR', 'MRT', ''),
(136, 'Mauritius', 'MU', 'MUS', ''),
(137, 'Mayotte', 'YT', 'MYT', ''),
(138, 'Mexico', 'MX', 'MEX', ':name\n:street_address\n:postcode :city, :state_code\n:country'),
(139, 'Micronesia', 'FM', 'FSM', ''),
(140, 'Moldova', 'MD', 'MDA', ''),
(141, 'Monaco', 'MC', 'MCO', ''),
(142, 'Mongolia', 'MN', 'MNG', ''),
(143, 'Montserrat', 'MS', 'MSR', ''),
(144, 'Morocco', 'MA', 'MAR', ''),
(145, 'Mozambique', 'MZ', 'MOZ', ''),
(146, 'Myanmar', 'MM', 'MMR', ''),
(147, 'Namibia', 'NA', 'NAM', ''),
(148, 'Nauru', 'NR', 'NRU', ''),
(149, 'Nepal', 'NP', 'NPL', ''),
(150, 'Netherlands', 'NL', 'NLD', ':name\n:street_address\n:postcode :city\n:country'),
(151, 'Netherlands Antilles', 'AN', 'ANT', ':name\n:street_address\n:postcode :city\n:country'),
(152, 'New Caledonia', 'NC', 'NCL', ''),
(153, 'New Zealand', 'NZ', 'NZL', ':name\n:street_address\n:suburb\n:city :postcode\n:country'),
(154, 'Nicaragua', 'NI', 'NIC', ''),
(155, 'Niger', 'NE', 'NER', ''),
(156, 'Nigeria', 'NG', 'NGA', ''),
(157, 'Niue', 'NU', 'NIU', ''),
(158, 'Norfolk Island', 'NF', 'NFK', ''),
(159, 'Northern Mariana Islands', 'MP', 'MNP', ''),
(160, 'Norway', 'NO', 'NOR', ':name\n:street_address\nNO-:postcode :city\n:country'),
(161, 'Oman', 'OM', 'OMN', ''),
(162, 'Pakistan', 'PK', 'PAK', ''),
(163, 'Palau', 'PW', 'PLW', ''),
(164, 'Panama', 'PA', 'PAN', ''),
(165, 'Papua New Guinea', 'PG', 'PNG', ''),
(166, 'Paraguay', 'PY', 'PRY', ''),
(167, 'Peru', 'PE', 'PER', ''),
(168, 'Philippines', 'PH', 'PHL', ''),
(169, 'Pitcairn', 'PN', 'PCN', ''),
(170, 'Poland', 'PL', 'POL', ':name\n:street_address\n:postcode :city\n:country'),
(171, 'Portugal', 'PT', 'PRT', ':name\n:street_address\n:postcode :city\n:country'),
(172, 'Puerto Rico', 'PR', 'PRI', ''),
(173, 'Qatar', 'QA', 'QAT', ''),
(174, 'Reunion', 'RE', 'REU', ''),
(175, 'Romania', 'RO', 'ROM', ''),
(176, 'Russia', 'RU', 'RUS', ':name\n:street_address\n:postcode :city\n:country'),
(177, 'Rwanda', 'RW', 'RWA', ''),
(178, 'Saint Kitts and Nevis', 'KN', 'KNA', ''),
(179, 'Saint Lucia', 'LC', 'LCA', ''),
(180, 'Saint Vincent and the Grenadines', 'VC', 'VCT', ''),
(181, 'Samoa', 'WS', 'WSM', ''),
(182, 'San Marino', 'SM', 'SMR', ''),
(183, 'Sao Tome and Principe', 'ST', 'STP', ''),
(184, 'Saudi Arabia', 'SA', 'SAU', ''),
(185, 'Senegal', 'SN', 'SEN', ''),
(186, 'Seychelles', 'SC', 'SYC', ''),
(187, 'Sierra Leone', 'SL', 'SLE', ''),
(188, 'Singapore', 'SG', 'SGP', ':name\n:street_address\n:city :postcode\n:country'),
(189, 'Slovakia', 'SK', 'SVK', ''),
(190, 'Slovenia', 'SI', 'SVN', ''),
(191, 'Solomon Islands', 'SB', 'SLB', ''),
(192, 'Somalia', 'SO', 'SOM', ''),
(193, 'South Africa', 'ZA', 'ZAF', ':name\n:street_address\n:suburb\n:city\n:postcode :country'),
(194, 'South Georgia and the South Sandwich Islands', 'GS', 'SGS', ''),
(195, 'Spain', 'ES', 'ESP', ':name\n:street_address\n:postcode :city\n:country'),
(196, 'Sri Lanka', 'LK', 'LKA', ''),
(197, 'St. Helena', 'SH', 'SHN', ''),
(198, 'St. Pierre and Miquelon', 'PM', 'SPM', ''),
(199, 'Sudan', 'SD', 'SDN', ''),
(200, 'Suriname', 'SR', 'SUR', ''),
(201, 'Svalbard and Jan Mayen Islands', 'SJ', 'SJM', ''),
(202, 'Swaziland', 'SZ', 'SWZ', ''),
(203, 'Sweden', 'SE', 'SWE', ':name\n:street_address\n:postcode :city\n:country'),
(204, 'Switzerland', 'CH', 'CHE', ':name\n:street_address\n:postcode :city\n:country'),
(205, 'Syrian Arab Republic', 'SY', 'SYR', ''),
(206, 'Taiwan', 'TW', 'TWN', ':name\n:street_address\n:city :postcode\n:country'),
(207, 'Tajikistan', 'TJ', 'TJK', ''),
(208, 'Tanzania', 'TZ', 'TZA', ''),
(209, 'Thailand', 'TH', 'THA', ''),
(210, 'Togo', 'TG', 'TGO', ''),
(211, 'Tokelau', 'TK', 'TKL', ''),
(212, 'Tonga', 'TO', 'TON', ''),
(213, 'Trinidad and Tobago', 'TT', 'TTO', ''),
(214, 'Tunisia', 'TN', 'TUN', ''),
(215, 'Turkey', 'TR', 'TUR', ''),
(216, 'Turkmenistan', 'TM', 'TKM', ''),
(217, 'Turks and Caicos Islands', 'TC', 'TCA', ''),
(218, 'Tuvalu', 'TV', 'TUV', ''),
(219, 'Uganda', 'UG', 'UGA', ''),
(220, 'Ukraine', 'UA', 'UKR', ''),
(221, 'United Arab Emirates', 'AE', 'ARE', ''),
(222, 'United Kingdom', 'GB', 'GBR', ':name\n:street_address\n:city\n:postcode\n:country'),
(223, 'United States of America', 'US', 'USA', ':name\n:street_address\n:city :state_code :postcode\n:country'),
(224, 'United States Minor Outlying Islands', 'UM', 'UMI', ''),
(225, 'Uruguay', 'UY', 'URY', ''),
(226, 'Uzbekistan', 'UZ', 'UZB', ''),
(227, 'Vanuatu', 'VU', 'VUT', ''),
(228, 'Vatican City State (Holy See)', 'VA', 'VAT', ''),
(229, 'Venezuela', 'VE', 'VEN', ''),
(230, 'Vietnam', 'VN', 'VNM', ''),
(231, 'Virgin Islands (British)', 'VG', 'VGB', ''),
(232, 'Virgin Islands (U.S.)', 'VI', 'VIR', ''),
(233, 'Wallis and Futuna Islands', 'WF', 'WLF', ''),
(234, 'Western Sahara', 'EH', 'ESH', ''),
(235, 'Yemen', 'YE', 'YEM', ''),
(236, 'Yugoslavia', 'YU', 'YUG', ''),
(237, 'Zaire', 'ZR', 'ZAR', ''),
(238, 'Zambia', 'ZM', 'ZMB', ''),
(239, 'Zimbabwe', 'ZW', 'ZWE', '');

DROP TABLE IF EXISTS country_zones;
CREATE TABLE `country_zones` (
  `id` int(10) NOT NULL auto_increment,
  `country_id` int(10) NOT NULL,
  `code` varchar(32) collate utf8_unicode_ci NOT NULL,
  `name` varchar(64) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `country_zones` (`id`, `country_id`, `code`, `name`) VALUES 
(1, 223, 'AK', 'Alaska'),
(2, 223, 'AL', 'Alabama'),
(3, 223, 'AS', 'American Samoa'),
(4, 223, 'AR', 'Arkansas'),
(5, 223, 'AZ', 'Arizona'),
(6, 223, 'CA', 'California'),
(7, 223, 'CO', 'Colorado'),
(8, 223, 'CT', 'Connecticut'),
(9, 223, 'DC', 'District of Columbia'),
(10, 223, 'DE', 'Delaware'),
(11, 223, 'FL', 'Florida'),
(12, 223, 'GA', 'Georgia'),
(13, 223, 'GU', 'Guam'),
(14, 223, 'HI', 'Hawaii'),
(15, 223, 'IA', 'Iowa'),
(16, 223, 'ID', 'Idaho'),
(17, 223, 'IL', 'Illinois'),
(18, 223, 'IN', 'Indiana'),
(19, 223, 'KS', 'Kansas'),
(20, 223, 'KY', 'Kentucky'),
(21, 223, 'LA', 'Louisiana'),
(22, 223, 'MA', 'Massachusetts'),
(23, 223, 'MD', 'Maryland'),
(24, 223, 'ME', 'Maine'),
(25, 223, 'MI', 'Michigan'),
(26, 223, 'MN', 'Minnesota'),
(27, 223, 'MO', 'Missouri'),
(28, 223, 'MS', 'Mississippi'),
(29, 223, 'MT', 'Montana'),
(30, 223, 'NC', 'North Carolina'),
(31, 223, 'ND', 'North Dakota'),
(32, 223, 'NE', 'Nebraska'),
(33, 223, 'NH', 'New Hampshire'),
(34, 223, 'NJ', 'New Jersey'),
(35, 223, 'NM', 'New Mexico'),
(36, 223, 'NV', 'Nevada'),
(37, 223, 'NY', 'New York'),
(38, 223, 'MP', 'Northern Mariana Islands'),
(39, 223, 'OH', 'Ohio'),
(40, 223, 'OK', 'Oklahoma'),
(41, 223, 'OR', 'Oregon'),
(42, 223, 'PA', 'Pennsylvania'),
(43, 223, 'PR', 'Puerto Rico'),
(44, 223, 'RI', 'Rhode Island'),
(45, 223, 'SC', 'South Carolina'),
(46, 223, 'SD', 'South Dakota'),
(47, 223, 'TN', 'Tennessee'),
(48, 223, 'TX', 'Texas'),
(49, 223, 'UM', 'U.S. Minor Outlying Islands'),
(50, 223, 'UT', 'Utah'),
(51, 223, 'VA', 'Virginia'),
(52, 223, 'VI', 'Virgin Islands of the U.S.'),
(53, 223, 'VT', 'Vermont'),
(54, 223, 'WA', 'Washington'),
(55, 223, 'WI', 'Wisconsin'),
(56, 223, 'WV', 'West Virginia'),
(57, 223, 'WY', 'Wyoming');

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
(5, 1, 'Main Page', 'Main Page', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(6, 2, 'Main Page', 'Главная', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(7, 1, 'Product', 'Product', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(8, 2, 'Product', 'Товар', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(9, 1, 'Price Ea.', 'Price Ea.', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(10, 2, 'Price Ea.', 'Цена / шт.', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(11, 1, 'Qty', 'Qty', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(12, 2, 'Qty', 'Количество', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(13, 1, 'Total', 'Total', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(14, 2, 'Total', 'Всего', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(15, 1, 'No Cart Items', 'No Cart Items', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(16, 2, 'No Cart Items', 'В корзине нет товара.', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(17, 1, 'Checkout', 'Checkout', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(18, 2, 'Checkout', 'Оформить', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(19, 1, 'Currency', 'Currency', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(20, 2, 'Currency', 'Валюта', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(21, 1, 'Go', 'Go', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(22, 2, 'Go', 'Продолжить', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(23, 1, 'Shopping Cart', 'Shopping Cart', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(24, 2, 'Shopping Cart', 'Корзина', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(25, 1, 'Shipping', 'Shipping', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(26, 2, 'Shipping', 'Доставка', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(27, 1, 'Language', 'Language', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(28, 2, 'Language', 'Язык', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(29, 1, 'Sub Categories', 'Sub Categories', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(30, 2, 'Sub Categories', 'Подкатегории', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(31, 1, 'Products in this Category', 'Products in this Category', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(32, 2, 'Products in this Category', 'Товары в данной категории', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(33, 1, 'Coupon Code', 'Coupon Code', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(34, 2, 'Coupon Code', 'Код купона', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(35, 1, 'Read Reviews', 'Read Reviews', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(36, 2, 'Read Reviews', 'Читать отзывы', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(37, 1, 'Write a Review', 'Write a Review', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(38, 2, 'Write a Review', 'Написать отзыв', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(39, 1, 'No reviews were found for this product.', 'No reviews were found for this product.', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(40, 2, 'No reviews were found for this product.', 'Нет отзывов для данного товара.', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(41, 1, 'Confirm Order', 'Confirm Order', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(42, 2, 'Confirm Order', 'Подтвердить заказ', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(43, 1, 'Billing Information', 'Billing Information', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(44, 2, 'Billing Information', 'Информация о покупателе', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(45, 1, 'Name', 'Name', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(46, 2, 'Name', 'Имя', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(47, 1, 'Address Line 1', 'Address Line 1', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(48, 2, 'Address Line 1', 'Адрес', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(49, 1, 'Address Line 2', 'Address Line 2', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(50, 2, 'Address Line 2', 'Доп. информация', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(51, 1, 'City', 'City', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(52, 2, 'City', 'Город', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(53, 1, 'State', 'State', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(54, 2, 'State', 'Регион', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(55, 1, 'Zipcode', 'Zipcode', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(56, 2, 'Zipcode', 'Почтовый индекс', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(57, 1, 'Shipping Information', 'Shipping Information', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(58, 2, 'Shipping Information', 'Информация о доставке', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(59, 1, 'Contact Information', 'Contact Information', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(60, 2, 'Contact Information', 'Информация о доставке', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(61, 1, 'Email', 'Email', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(62, 2, 'Email', 'Email', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(63, 1, 'Phone', 'Phone', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(64, 2, 'Phone', 'Телефон', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(65, 1, 'Shipping Method', 'Shipping Method', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(66, 2, 'Shipping Method', 'Способы доставки', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(67, 1, 'Payment Method', 'Payment Method', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(68, 2, 'Payment Method', 'Способы оплаты', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(69, 1, 'Continue', 'Continue', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(70, 2, 'Continue', 'Продолжить', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(71, 1, 'No Items Found', 'No Items Found', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(72, 2, 'No Items Found', 'Товары не найдены.', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(73, 1, 'Click to Enlarge', 'Click to Enlarge', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(74, 2, 'Click to Enlarge', 'Увеличить', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(75, 1, 'No Image', 'No Image', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(76, 2, 'No Image', 'Нет картинки', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(77, 1, 'Review', 'Review', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(78, 2, 'Review', 'Отзыв', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(79, 1, 'Submit', 'Submit', '2009-09-12 20:08:49', '2009-09-12 20:08:49'),
(80, 2, 'Submit', 'Добавить', '2009-09-12 20:08:49', '2009-09-12 20:08:49');

DROP TABLE IF EXISTS email_templates;
CREATE TABLE `email_templates` (
  `id` int(10) NOT NULL auto_increment,
  `alias` varchar(50) collate utf8_unicode_ci NOT NULL,
  `default` int(4) NOT NULL,
  `order` int(4) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `email_templates` VALUES (1, 'new-order', 1, 1);
INSERT INTO `email_templates` VALUES (2, 'new-order-status', 1, 2);

DROP TABLE IF EXISTS email_template_descriptions;
CREATE TABLE `email_template_descriptions` (
  `id` int(10) NOT NULL auto_increment,
  `email_template_id` int(10) NOT NULL,
  `language_id` int(10) NOT NULL,
  `subject` varchar(50) collate utf8_unicode_ci NOT NULL,
  `content` text collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `email_template_descriptions` VALUES (1, 1, 1, 'Your order #{$order_number}', 'Dear {$name}!\r\n\r\nYour order confirmed!\r\nOrder number: {$order_number}\r\n\r\nProducts:\r\n{$products}\r\n\r\nThank you!\r\n\r\n');
INSERT INTO `email_template_descriptions` VALUES (2, 1, 2, 'Ваш заказ №{$order_number}', 'Здравствуйте, {$name}!\r\n\r\nВаш заказ подтверждён.\r\nНомер заказа: {$order_number}\r\n\r\nЗаказанные товары:\r\n{$products}\r\n\r\nСпасибо!');
INSERT INTO `email_template_descriptions` VALUES (3, 2, 1, 'Order #{$order_number}: Status Changed', 'Dear {$name}!\r\n\r\nThank you!\r\n\r\nOrder number: {$order_number}\r\n\r\nNew Order Status: {$order_status}\r\n\r\n{$comments}');
INSERT INTO `email_template_descriptions` VALUES (4, 2, 2, 'Изменён статус Вашего заказа №{$order_number}', 'Здравствуйте, {$name}!\r\n\r\nСпасибо за Ваш заказ!\r\n\r\nНомер заказа: {$order_number}\r\n\r\nСтатус Вашего заказа изменён.\r\n\r\nНовый статус заказа: {$order_status}\r\n\r\n{$comments}');


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

DROP TABLE IF EXISTS global_content_blocks;
CREATE TABLE `global_content_blocks` (
  `id` int(10) NOT NULL auto_increment,
  `name` varchar(100) collate utf8_unicode_ci NOT NULL,
  `content` text collate utf8_unicode_ci NOT NULL,
  `alias` varchar(50) collate utf8_unicode_ci NOT NULL,
  `active` tinyint(4) NOT NULL default '1',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `global_content_blocks` (`id`, `name`, `content`, `alias`, `active`, `created`, `modified`) VALUES 
(1, 'Footer', '<a href="http://vamshop.ru/" target="blank">VaM Shop</a>', 'footer', 1, '2009-07-17 10:00:06', '2009-09-12 17:05:49');

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
(1, 1, 'English', 'eng', 'us', 1, 1),
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

INSERT INTO `micro_templates` (`id`, `alias`, `template`, `created`, `modified`, `tag_name`) VALUES 
(1, 'vertical-menu', '<!-- Categories box -->\r\n<div class="box">\r\n<h5>{lang}Categories{/lang}</h5>\r\n<div class="boxContent">\r\n<ul id="CatNavi">\r\n{foreach from=$content_list item=node}\r\n<li{if $node.alias == $content_alias} class="active"{/if}><a href="{$node.url}">{$node.name}</a></li>\r\n{/foreach}\r\n</ul>\r\n</div>\r\n</div>\r\n<!-- /Categories box -->', '2009-07-28 17:08:06', '2009-07-12 18:59:10', 'content_listing'),
(3, 'information-links', '<ul>\r\n<li{if  $smarty.server.REQUEST_URI == \'/\'} class="current"{/if}><a href="/"><span>{lang}Main Page{/lang}</span></a></li>\r\n{foreach from=$content_list item=node}\r\n<li{if $node.alias == $content_alias} class="current"{/if}><a href="{$node.url}"><span>{$node.name}</span></a></li>\r\n{/foreach}\r\n</ul>', '2009-07-30 15:42:21', '2009-07-12 15:41:54', 'content_listing'),(5, 'shopping-cart', '<div class="cart">\r\n	<table style="width:100%;">\r\n		<tr>	\r\n			<th> </th>\r\n			<th>{lang}Product{/lang}</th>\r\n			<th>{lang}Price Ea.{/lang}</th>\r\n			<th>{lang}Qty{/lang}</th>\r\n			<th>{lang}Total{/lang}</th>\r\n		</tr>\r\n				\r\n		{foreach from=$order_items item=product}			\r\n			<tr>\r\n				<td><a href="/cart/remove_product/{$product.id}" class="remove">x</a></td>\r\n				<td><a href="{$product.link}">{$product.name}</a></td>\r\n				<td>{$product.price}</td>\r\n				<td>{$product.qty}</td>\r\n				<td>{$product.line_total}</td>\r\n			</tr>				\r\n		{foreachelse}	\r\n			<tr>\r\n				<td colspan="5">{lang}No Cart Items{/lang}</td>\r\n			</tr>\r\n		{/foreach}				\r\n				\r\n		<tr class="cart_total">\r\n			<td colspan="5">{lang}Total{/lang} {$order_total}</td>\r\n		</tr>\r\n	</table>\r\n	<a class="checkout" href="{$checkout_link}">{lang}Checkout{/lang}</a>\r\n</div>', '2009-07-31 14:56:59', '2009-09-02 22:26:49', 'shopping_cart'),
(6, 'currency-box', '<!-- Box -->\r\n<div class="box">\r\n<h5>{lang}Currency{/lang}</h5>\r\n<div class="boxContent">\r\n\r\n<form action="/currencies/pick_currency/" method="post">\r\n<select name="currency_picker">\r\n{foreach from=$currencies item=currency}\r\n<option value="{$currency.id}" {if $currency.id == $smarty.session.Customer.currency_id}selected="selected"{/if}>{$currency.name}</option>\r\n{/foreach}\r\n</select>\r\n<span class="button"><button type="submit" value="{lang}Go{/lang}">{lang}Go{/lang}</button></span>\r\n</form>\r\n		\r\n</p>\r\n</div>\r\n</div>\r\n<!-- /Box -->', '2009-08-01 14:42:02', '2009-07-12 18:57:01', 'currency_box'),
(8, 'cart-content-box', '<!-- Box -->\r\n<div class="box">\r\n<h5><a href="{$cart_link}" class="shopping_cart_link">{lang}Shopping Cart{/lang}</a></h5>\r\n<div class="boxContent">\r\n\r\n	<ul class="cart_contents">\r\n		{foreach from=$order_items item=product}\r\n			<li>{$product.qty} x <a href="{$product.url}">{$product.name}</a></li>\r\n		{/foreach}\r\n	</ul>\r\n	<ul class="cart_total">\r\n		<li>{lang}Total{/lang}: {$order_total}</li>\r\n	</ul>\r\n	<a class="checkout" href="{$checkout_link}">{lang}Checkout{/lang}</a>\r\n		\r\n</p>\r\n</div>\r\n</div>\r\n<!-- /Box -->', '2009-08-09 16:27:09', '2009-07-12 19:24:29', 'shopping_cart'),
(9, 'payment-view-cart', '<div class="cart">\r\n	<table style="width:100%;">\r\n		<tr>	\r\n			<th> </th>\r\n			<th>{lang}Product{/lang}</th>\r\n			<th>{lang}Price Ea.{/lang}</th>\r\n			<th>{lang}Qty{/lang}</th>\r\n			<th>{lang}Total{/lang}</th>\r\n		</tr>\r\n				\r\n		{foreach from=$order_items item=product}			\r\n			<tr>\r\n				<td><a href="/cart/remove_product/{$product.id}" class="remove">x</a></td>\r\n				<td><a href="{$product.link}">{$product.name}</a></td>\r\n				<td>{$product.price}</td>\r\n				<td>{$product.qty}</td>\r\n				<td>{$product.line_total}</td>\r\n			</tr>				\r\n		{foreachelse}	\r\n			<tr>\r\n				<td colspan="5">{lang}No Cart Items{/lang}</td>\r\n			</tr>\r\n		{/foreach}				\r\n				\r\n		<tr class="cart_total">\r\n			<td colspan="5">\r\n				{lang}Shipping{/lang}: {$shipping_total}<br />\r\n				<strong>{lang}Total{/lang}:</strong> {$order_total}\r\n			</td>\r\n		</tr>\r\n	</table>\r\n</div>', '2009-08-10 13:09:25', '2009-09-02 22:25:57', 'shopping_cart'),
(10, 'language-box', '<!-- Box -->\r\n<div class="box">\r\n<h5>{lang}Language{/lang}</h5>\r\n<div class="boxContent">\r\n\r\n{foreach from=$languages item=language}\r\n<a href="{$language.url}"><img src="{$language.image}" alt="{$language.name}" title="{$language.name}"/></a>\r\n{/foreach}\r\n\r\n</div>\r\n</div>\r\n<!-- /Box -->', '2009-07-12 18:52:23', '2009-07-12 18:57:08', 'language_box'),
(11, 'subcategory-listing', '<div>\r\n<ul class="listing">\r\n{foreach from=$content_list item=node}\r\n	<li\r\n	{if $node.alias == $content_alias}\r\n		class="active"\r\n	{/if}\r\n	>\r\n	<div><a href="{$node.url}"><img src="{$node.image}" alt="{$node.name}" \r\n	{if isset($thumbnail_width)}\r\n	 width="{$thumbnail_width}"\r\n	{/if}\r\n	/></a></div>\r\n	<div><a href="{$node.url}">{$node.name}</a></div></li>\r\n{foreachelse}\r\n	<li class="no_items">{lang}No Items Found{/lang}</li>\r\n{/foreach}\r\n</ul>\r\n<div class="clearb"></div>\r\n</div>\r\n', '2009-07-12 18:52:23', '2009-07-12 18:57:08', 'content_listing'),
(12, 'product-listing', '<div>\r\n<ul class="listing">\r\n{foreach from=$content_list item=node}\r\n	<li\r\n	{if $node.alias == $content_alias}\r\n		class="active"\r\n	{/if}\r\n	>\r\n	<div><a href="{$node.url}"><img src="{$node.image}" alt="{$node.name}" \r\n	{if isset($thumbnail_width)}\r\n	 width="{$thumbnail_width}"\r\n	{/if}\r\n	/></a></div>\r\n	<div><a href="{$node.url}">{$node.name}</a></div></li>\r\n{foreachelse}\r\n	<li class="no_items">{lang}No Items Found{/lang}</li>\r\n{/foreach}\r\n</ul>\r\n<div class="clearb"></div>\r\n</div>\r\n', '2009-07-12 18:52:23', '2009-07-12 18:57:08', 'content_listing'),
(13, 'checkout', '<div id="checkout">\r\n<form action="{$checkout_form_action}" method="post">\r\n	<div id="shipping_method">\r\n		<div>\r\n			<h3>{lang}Shipping Method{/lang}</h3>\r\n		</div>	\r\n		{foreach from=$ship_methods item=ship_method}\r\n			<div>\r\n				<input type="radio" name="shipping_method_id" value="{$ship_method.id}" id="ship_{$ship_method.id}" \r\n				{if $ship_method.id == $order.shipping_method_id}\r\n				  checked="checked"\r\n				 {/if}\r\n				/>\r\n				<label for="ship_{$ship_method.id}">{$ship_method.name} - {$ship_method.cost}</label>\r\n			</div>\r\n		{/foreach}\r\n	</div>\r\n	<div id="payment_method">\r\n		<div>\r\n			<h3>{lang}Payment Method{/lang}</h3>\r\n		</div>		\r\n		{foreach from=$payment_methods item=payment_method}\r\n			<div>\r\n				<input type="radio" name="payment_method_id" value="{$payment_method.id}" id="payment_{$payment_method.id}" \r\n				{if $payment_method.id == $order.payment_method_id}\r\n				  checked="checked"\r\n				 {/if}				\r\n				/>\r\n				<label for="payment_{$payment_method.id}">{$payment_method.name}</label>\r\n			</div>\r\n		{/foreach}		\r\n	</div>\r\n	<div id="ship_information">\r\n		<div>\r\n			<h3>{lang}Shipping Information{/lang}</h3>\r\n		</div>\r\n		<div>	\r\n			<label>{lang}Name{/lang}</label>\r\n			<input type="text" name="ship_name" value="{$order.ship_name}" />\r\n		</div>\r\n		<div>	\r\n			<label>{lang}Address Line 1{/lang}</label>\r\n			<input type="text" name="ship_line_1" value="{$order.ship_line_1}" />\r\n		</div>		\r\n		<div>	\r\n			<label>{lang}Address Line 1{/lang}</label>\r\n			<input type="text" name="ship_line_2" value="{$order.ship_line_2}" />\r\n		</div>		\r\n		<div>	\r\n			<label>{lang}City{/lang}</label>\r\n			<input type="text" name="ship_city" value="{$order.ship_city}" />\r\n		</div>		\r\n		<div>	\r\n			<label>{lang}State{/lang}</label>\r\n			<input type="text" name="ship_state" value="{$order.ship_state}" />\r\n		</div>		\r\n		<div>	\r\n			<label>{lang}Zipcode{/lang}</label>\r\n			<input type="text" name="ship_zip" value="{$order.ship_zip}" />\r\n		</div>								\r\n	</div>\r\n	<div id="bill_information">\r\n		<div>\r\n			<h3>{lang}Billing Information{/lang}</h3>\r\n		</div>\r\n		<div>	\r\n			<label>{lang}Name{/lang}</label>\r\n			<input type="text" name="bill_name" value="{$order.bill_name}"/>\r\n		</div>\r\n		<div>	\r\n			<label>{lang}Address Line 1{/lang}</label>\r\n			<input type="text" name="bill_line_1" value="{$order.bill_line_1}" />\r\n		</div>		\r\n		<div>	\r\n			<label>{lang}Address Line 2{/lang}</label>\r\n			<input type="text" name="bill_line_2" value="{$order.bill_line_2}" />\r\n		</div>		\r\n		<div>	\r\n			<label>{lang}City{/lang}</label>\r\n			<input type="text" name="bill_city" value="{$order.bill_city}" />\r\n		</div>		\r\n		<div>	\r\n			<label>{lang}State{/lang}</label>\r\n			<input type="text" name="bill_state" value="{$order.bill_state}" />\r\n		</div>		\r\n		<div>	\r\n			<label>{lang}Zipcode{/lang}</label>\r\n			<input type="text" name="bill_zip" value="{$order.bill_zip}" />\r\n		</div>	\r\n	</div>		\r\n	<div id="contact_information">\r\n		<div>\r\n			<h3>{lang}Contact Information{/lang}</h3>\r\n		</div>\r\n		<div>	\r\n			<label>{lang}Email{/lang}</label>\r\n			<input type="text" name="email" value="{$order.email}" />\r\n		</div>\r\n		<div>	\r\n			<label>{lang}Phone{/lang}</label>\r\n			<input type="text" name="phone" value="{$order.phone}" />\r\n		</div>		\r\n	</div>\r\n	<div>\r\n	{module alias="coupons" action="checkout_box"}\r\n	</div>\r\n	<span class="button"><button type="submit" value="{lang}Continue{/lang}">{lang}Continue{/lang}</button></span>\r\n</form>\r\n</div>\r\n', '2009-07-12 18:52:23', '2009-11-01 19:20:58', 'checkout');

DROP TABLE IF EXISTS modules;
CREATE TABLE `modules` (
  `id` int(10) NOT NULL auto_increment,
  `name` varchar(50) collate utf8_unicode_ci NOT NULL,
  `alias` varchar(50) collate utf8_unicode_ci NOT NULL,
  `version` varchar(10) collate utf8_unicode_ci NOT NULL,
  `nav_level` int(4) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `modules` (`id`, `name`, `alias`, `version`, `nav_level`) VALUES 
(1, 'Reviews', 'reviews', '1.0', 3),
(2, 'Coupons', 'coupons', '2', 3);

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
  `order_status_id` int(10) NOT NULL,
  `shipping_method_id` int(10) NOT NULL,
  `payment_method_id` int(10) NOT NULL,
  `shipping` double NOT NULL,
  `tax` double NOT NULL,
  `total` double NOT NULL,
  `bill_name` varchar(100) collate utf8_unicode_ci NOT NULL,
  `bill_line_1` varchar(100) collate utf8_unicode_ci NOT NULL,
  `bill_line_2` varchar(100) collate utf8_unicode_ci NOT NULL,
  `bill_city` varchar(100) collate utf8_unicode_ci NOT NULL,
  `bill_state` varchar(100) collate utf8_unicode_ci NOT NULL,
  `bill_zip` varchar(20) collate utf8_unicode_ci NOT NULL,
  `ship_name` varchar(100) collate utf8_unicode_ci NOT NULL,
  `ship_line_1` varchar(100) collate utf8_unicode_ci NOT NULL,
  `ship_line_2` varchar(100) collate utf8_unicode_ci NOT NULL,
  `ship_city` varchar(100) collate utf8_unicode_ci NOT NULL,
  `ship_state` varchar(100) collate utf8_unicode_ci NOT NULL,
  `ship_zip` varchar(20) collate utf8_unicode_ci NOT NULL,
  `email` varchar(100) collate utf8_unicode_ci NOT NULL,
  `phone` varchar(15) collate utf8_unicode_ci NOT NULL,
  `cc_number` int(20) NOT NULL,
  `cc_expiration_month` int(2) NOT NULL,
  `cc_expiration_year` int(4) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `orders` (`id`, `order_status_id`, `shipping_method_id`, `payment_method_id`, `shipping`, `tax`, `total`, `bill_name`, `bill_line_1`, `bill_line_2`, `bill_city`, `bill_state`, `bill_zip`, `ship_name`, `ship_line_1`, `ship_line_2`, `ship_city`, `ship_state`, `ship_zip`, `email`, `phone`, `cc_number`, `cc_expiration_month`, `cc_expiration_year`, `created`) VALUES 
(1, 1, 2, 2, 5.99, 0, 25.79, 'Test Order', 'asdfasf', 'asdfasdf', '', '', '', '', '', '', '', '', '', 'vam@test.com', '', 0, 0, 0, '2009-08-28 11:06:18');

DROP TABLE IF EXISTS order_comments;
CREATE TABLE `order_comments` (
  `id` int(10) NOT NULL auto_increment,
  `user_id` int(10) NOT NULL,
  `order_id` int(10) NOT NULL,
  `sent_to_customer` tinyint(4) NOT NULL,
  `comment` varchar(255) collate utf8_unicode_ci NOT NULL,
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
  `name` varchar(100) collate utf8_unicode_ci NOT NULL,
  `quantity` int(10) NOT NULL,
  `price` double NOT NULL,
  `weight` varchar(10) collate utf8_unicode_ci NOT NULL,
  `tax` double NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `order_products` (`id`, `order_id`, `content_id`, `name`, `quantity`, `price`, `weight`, `tax`) VALUES 
(1, 1, 38, 'Mozilla Firefox', 3, 4.95, '', 0),
(2, 1, 37, 'Internet Explorer', 2, 10.99, '', 0);

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
  `name` varchar(100) collate utf8_unicode_ci NOT NULL,
  `alias` varchar(100) collate utf8_unicode_ci NOT NULL,
  `order` int(10) NOT NULL,
  `order_status_id` int(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `payment_methods` (`id`, `active`, `default`, `name`, `alias`, `order`, `order_status_id`) VALUES 
(1, 1, 0, 'In-store Pickup', 'store_pickup', 0, 0),
(2, 1, 1, 'Money Order/Check', 'money_order_check', 0, 0),
(3, 1, 0, 'Paypal', 'paypal', 0, 0),
(4, 1, 0, 'Credit Card', 'credit_card', 0, 0),
(5, 1, 0, 'Authorize.Net', 'authorize', 0, 0),
(6, 1, 0, 'Google Checkout', 'google_html', 0, 0);

DROP TABLE IF EXISTS payment_method_values;
CREATE TABLE `payment_method_values` (
  `id` int(10) NOT NULL auto_increment,
  `payment_method_id` int(10) NOT NULL,
  `key` varchar(50) collate utf8_unicode_ci NOT NULL,
  `value` varchar(100) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `payment_method_values` (`id`, `payment_method_id`, `key`, `value`) VALUES 
(1, 3, 'paypal_email', 'kevingraasdfndon@hotmail.com'),
(2, 5, 'authorize_login', '888888888'),
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
  `name` varchar(100) collate utf8_unicode_ci NOT NULL,
  `code` varchar(100) collate utf8_unicode_ci NOT NULL,
  `default` tinyint(4) NOT NULL default '0',
  `active` tinyint(4) NOT NULL,
  `order` int(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `shipping_methods` (`id`, `name`, `code`, `default`, `active`, `order`) VALUES 
(1, 'Free Shipping', 'free_shipping', 0, 1, 0),
(2, 'Flat Rate', 'flat_rate', 1, 1, 0),
(3, 'Per Item', 'per_item', 0, 1, 0),
(4, 'Table Based', 'table_based', 0, 1, 0);

DROP TABLE IF EXISTS shipping_method_values;
CREATE TABLE `shipping_method_values` (
  `id` int(10) NOT NULL auto_increment,
  `shipping_method_id` int(10) NOT NULL,
  `key` varchar(50) collate utf8_unicode_ci NOT NULL,
  `value` varchar(100) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `shipping_method_values` (`id`, `shipping_method_id`, `key`, `value`) VALUES 
(1, 2, 'rate', '5.99'),
(2, 3, 'per_item_amount', '1'),
(3, 3, 'per_item_handling', '5.00'),
(4, 4, 'table_based_type', 'weight'),
(5, 4, 'table_based_rates', '0:0.50,\r\n1:1.50,\r\n2:2.25,\r\n3:3.00,\r\n4:5.75'),
(6, 2, 'cost', '5.99');

DROP TABLE IF EXISTS stylesheets;
CREATE TABLE `stylesheets` (
  `id` int(10) NOT NULL auto_increment,
  `active` tinyint(4) NOT NULL,
  `name` varchar(50) collate utf8_unicode_ci NOT NULL,
  `alias` varchar(100) collate utf8_unicode_ci NOT NULL,
  `stylesheet` text collate utf8_unicode_ci NOT NULL,
  `stylesheet_media_type_id` int(10) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `stylesheets` VALUES (1, 1, 'VaM Shop', 'vamshop', '/* -----------------------------------------------------------------------------------------\r\n   VaM Shop - open source ecommerce solution\r\n   http://vamshop.ru\r\n\r\n   Copyright (c) 2005-2009 VaM Shop \r\n   -----------------------------------------------------------------------------------------\r\n   Released under the GNU General Public License \r\n   ---------------------------------------------------------------------------------------*/\r\n\r\nhtml,body\r\n   {\r\n     margin: 0;\r\n     padding: 0;\r\n   }\r\n\r\nbody\r\n   {\r\n   	font: 16px arial,sans-serif;\r\n   }\r\n\r\nimg\r\n   {\r\n	  border: 0;\r\n   }\r\n\r\nh2, h3\r\n   {\r\n     margin: 0;\r\n     padding: 0;\r\n   }\r\n   \r\n/* Links color */\r\na \r\n   {\r\n     color: #000;\r\n     text-decoration: underline;\r\n   }\r\n\r\na:hover \r\n   {\r\n     color: #990000;\r\n     text-decoration: none;\r\n   }\r\n/* /Links color */\r\n\r\n/* Content */\r\ndiv#wrapper\r\n   {\r\n     float: left;\r\n     width: 100%;\r\n   }\r\n\r\ndiv#content\r\n   {\r\n     margin: 0 19%;\r\n   }\r\n\r\n/* /Content */\r\n\r\n/* Left column */\r\ndiv#left\r\n   {\r\n     float: left;\r\n     width: 18%;\r\n     margin-left: -100%;\r\n     background: #fff;\r\n   }\r\n/* /Left column */\r\n\r\n/* Right column */\r\ndiv#right\r\n   {\r\n     float: left;\r\n     overflow: auto;\r\n     width: 18%;\r\n     margin-left: -18%;\r\n     background: #fff;\r\n   }\r\n/* /Right column */\r\n\r\n/* Footer */\r\ndiv#footer\r\n   {\r\n     clear: left;\r\n     height: 50px;\r\n     width: 100%;\r\n     background: transparent;\r\n     border-top: 0px solid #67748B;\r\n     text-align: center;\r\n     color: #000;\r\n   }\r\n   \r\ndiv#footer p\r\n   {\r\n     margin: 0;\r\n     padding: 5px 10px;\r\n   }\r\n   \r\n/* /Footer */\r\n\r\n/* Navigation */\r\ndiv#navigation \r\n   {\r\n     padding-top: 0.5em;\r\n     padding-bottom: 0.5em;\r\n     padding-left: 10px;\r\n     border-bottom: 1px solid #000;\r\n     background: #990000;\r\n     color: #ffffff;\r\n   }\r\n\r\n#navigation span \r\n   {\r\n     display: block;\r\n     font-weight: bold;\r\n     color: #ffffff;\r\n     border-bottom: 0px #990000 solid;\r\n     padding: 0 0 0 20px; \r\n   }\r\n   \r\n#navigation a\r\n   {\r\n     font-weight: bold;\r\n     color: #ffffff;\r\n     text-decoration: none;\r\n   }\r\n\r\n#navigation a:hover\r\n   {\r\n     font-weight: bold;\r\n     color: #ffffff;\r\n     text-decoration: none;\r\n   }\r\n\r\n#navigation a:visited\r\n   {\r\n     font-weight: bold;\r\n     color: #ffffff;\r\n     text-decoration: none;\r\n   }\r\n   \r\n/* /Navigation */\r\n   \r\n/* Page header */\r\n#content h1 \r\n   {\r\n     display: block;\r\n     font-weight: bold;\r\n     color: #990000;\r\n     border-bottom: 0px #990000 solid;\r\n     padding: 0 0 0 20px; \r\n     margin: 0.2em 0 0.2em 0; \r\n   }\r\n\r\n#content h1 a \r\n   {\r\n     color: #990000;\r\n     text-decoration: none;\r\n   }\r\n/* /Page header */\r\n\r\n/* Page content */\r\n.page \r\n   {\r\n     background: transparent;\r\n     width: 100%;\r\n     margin-top: 0.5em;\r\n     margin-bottom: 0.5em;\r\n   }\r\n\r\n.pageItem \r\n   {\r\n     background: #f1f1f6;\r\n     width: 100%;\r\n   }\r\n\r\n.page h1, .page p \r\n   {\r\n     margin: 0 10px;\r\n   }\r\n\r\n.page h1 \r\n   {\r\n     color: #fff;\r\n   }\r\n\r\n.page p \r\n   {\r\n     padding-bottom: 0.5em;\r\n     padding-top: 0.5em;\r\n   }\r\n\r\n.page .b1, .page .b2, .page .b3, .page .b4, .page .b1b, .page .b2b, .page .b3b, .page .b4b \r\n   {\r\n     display: block;\r\n     overflow: hidden;\r\n     font-size: 1px;\r\n   }\r\n\r\n.page .b1, .page .b2, .page .b3, .page .b1b, .page .b2b, .page .b3b \r\n   {\r\n     height: 1px;\r\n   }\r\n\r\n.page .b2 \r\n   {\r\n     background: #f1f1f6;\r\n     border-left: 1px solid #fff;\r\n     border-right: 1px solid #f1f1f6;\r\n   }\r\n\r\n.page .b3 \r\n   {\r\n     background: #f1f1f6;\r\n     border-left: 1px solid #fff;\r\n     border-right: 1px solid #f1f1f6;\r\n   }\r\n\r\n.page .b4 \r\n   {\r\n     background: #f1f1f6;\r\n     border-left: 1px solid #fff;\r\n     border-right: 1px solid #f1f1f6;\r\n   }\r\n\r\n.page .b4b \r\n   {\r\n     background: #f1f1f6;\r\n     border-left: 1px solid #f1f1f6;\r\n     border-right: 1px solid #f1f1f6;\r\n   }\r\n\r\n.page .b3b \r\n   {\r\n     background: #f1f1f6;\r\n     border-left: 1px solid #f1f1f6;\r\n     border-right: 1px solid #f1f1f6;\r\n   }\r\n\r\n.page .b2b \r\n   {\r\n     background: #f1f1f6;\r\n     border-left: 1px solid #f1f1f6;\r\n     border-right: 1px solid #f1f1f6;\r\n   }\r\n\r\n.page .b1 \r\n   {\r\n     margin: 0 5px;\r\n     background: #fff;\r\n   }\r\n\r\n.page .b2, .page .b2b \r\n   {\r\n     margin: 0 3px;\r\n     border-width: 0 2px;\r\n   }\r\n\r\n.page .b3, .page .b3b \r\n   {\r\n     margin: 0 2px;\r\n   }\r\n\r\n.page .b4, .page .b4b \r\n   {\r\n     height: 2px;\r\n     margin: 0 1px;\r\n   }\r\n\r\n.page .b1b \r\n   {\r\n     margin: 0 5px;\r\n     background: #f1f1f6;\r\n   }\r\n\r\n.pagecontent \r\n   {\r\n     display: block;\r\n     padding-left: 0.5em;\r\n     padding-right: 0.5em;\r\n     background: #f1f1f6;\r\n   }\r\n\r\n.pagecontentfooter \r\n   {\r\n     display: block;\r\n     text-align: right;\r\n     background:#ffffff;\r\n     margin-top: 0.5em;\r\n     margin-bottom: 0.5em;\r\n   }\r\n/* /Page content */\r\n\r\n/*- Bookmarks */\r\n\r\n#menu \r\n   {\r\n	  background: #fff;\r\n	  border-bottom: 1px solid #000;\r\n	  border-width: 1px;\r\n	  margin-top: 1em;\r\n	  padding-top: .6em;\r\n   }\r\n\r\n#menu ul, #navigation ul li \r\n   {\r\n	  list-style: none;\r\n	  margin: 0;\r\n	  padding: 0;\r\n   }\r\n\r\n#menu ul \r\n   {\r\n	  padding: 5px 0 0px;\r\n	  text-align: center;\r\n   }\r\n\r\n#menu ul li \r\n   {\r\n	  display: inline;\r\n	  margin:0 .375em;\r\n   }\r\n\r\n#menu ul li.last \r\n   {\r\n	  margin-right: 0;\r\n   }\r\n\r\n#menu ul li a \r\n   {\r\n	  background: url("/img/tab-right.png") no-repeat 100% 0;\r\n	  background-color: #67748b;\r\n	  color: #fff;\r\n	  padding: 0px 0 0px;\r\n     font-weight: bold;\r\n	  text-decoration: none;\r\n   }\r\n\r\n#menu ul li.current a \r\n   {\r\n	  background: url("/img/tab-right-active.png") no-repeat 100% 0;\r\n	  background-color: #990000;\r\n	  color: #fff;\r\n	  padding: 0px 0 1px;\r\n     font-weight: bold;\r\n	  text-decoration: none;\r\n   }\r\n\r\n#menu ul li a span \r\n   {\r\n	  background: url("/img/tab-left.png") no-repeat;\r\n	  padding: 0px 1em;\r\n     border-bottom:1px solid #000;\r\n   }\r\n\r\n#menu ul li.current a span \r\n   {\r\n	  background: url("/img/tab-left-active.png") no-repeat;\r\n	  padding: 0px 1em 1px;\r\n     border-bottom:0;\r\n   }\r\n\r\n#menu ul li a:hover span \r\n   {\r\n	  color: #fff;\r\n     font-weight: bold;\r\n	  text-decoration: none;\r\n   }\r\n\r\n/*\\*//*/\r\n#menu ul li a \r\n   {\r\n	  display: inline-block;\r\n	  white-space: nowrap;\r\n	  width: 1px;\r\n   }\r\n\r\n#menu ul \r\n   {\r\n	  padding-bottom: 0;\r\n	  margin-bottom: -1px;\r\n   }\r\n/**/\r\n\r\n/*\\*/\r\n* html #menu ul li a \r\n   {\r\n	  padding: 0;\r\n   }\r\n/**/\r\n\r\n/*- /Bookmarks */\r\n\r\n/*- Boxes */\r\n\r\n/*- Box */\r\n.box\r\n   {\r\n     text-align: left;\r\n     margin-bottom: 0.2em;\r\n     margin-top: 0.2em;\r\n     margin-right: 0.2em;\r\n     padding-top: 0.2em;\r\n     padding-bottom: 0.4em;\r\n  	  border-bottom-width: 0px;\r\n	  border-bottom-style: dashed;\r\n     border-bottom-color: #67748B;\r\n   }\r\n\r\n/*- Box Header */\r\n.box h5 \r\n   {\r\n     display: block;\r\n     font-weight: bold;\r\n     color: #990000;\r\n     border-bottom: 0px #e5e5e5 solid;\r\n     background: url(/img/box.png) no-repeat left center;\r\n     margin: 0 0 .4em .3em;\r\n     padding: .1em 0 0 16px;\r\n  }\r\n\r\n.box h5 a\r\n   {\r\n     color: #990000;\r\n     text-decoration: none;\r\n   }\r\n/*- /Box Header */\r\n\r\n/*- Box Content */\r\n.boxContent \r\n   {\r\n     padding-left: 0;\r\n     text-align: left;\r\n  }\r\n\r\n#boxContent p \r\n   {\r\n     margin: 0 0 0 0;\r\n     padding-bottom: 0.2em;\r\n  }\r\n\r\n/*- /Box Content */\r\n\r\n/*- /Box */\r\n\r\n/*- /Boxes */\r\n\r\n/* Buttons */\r\n\r\na.button, \r\nspan.button, \r\ndel.button\r\n	{\r\n		display: -moz-inline-box;\r\n		display: inline-block;\r\n		cursor: pointer;\r\n		border: none;\r\n		font-size: 0;\r\n		line-height: 0;\r\n    \r\n	/*\r\n	for Safari, read this first\r\n	http://creativebits.org/webdev/safari_background_repeat_bug_fix\r\n	*/\r\n	\r\n		background-position: 0 0;\r\n		background-repeat: no-repeat;\r\n		height: 30px;\r\n		text-decoration: none;\r\n		color: #2e523b;\r\n		font-style: normal;\r\n		margin: 0 6px 0px 0;\r\n		padding: 0 10px 0 0;	\r\n		vertical-align: middle;	\r\n		padding-top: -2px;\r\n		_position: relative;\r\n		_width: 10px;	\r\n		_overflow-y: hidden;\r\n	}\r\n\r\na.button, \r\nspan.button, \r\ndel.button, \r\na.button span, \r\nspan.button button, \r\nspan.button input, \r\ndel.button span\r\n	{\r\n		background-image: url(/img/admin/buttons/form_buttons.png);\r\n		_background-image: url(/img/admin/buttons/form_buttons.gif);\r\n	}\r\n\r\na.button span, \r\nspan.button button, \r\nspan.button input, \r\ndel.button span\r\n	{\r\n		white-space: nowrap;\r\n		cursor: pointer;\r\n		color: #222;\r\n		display: -moz-inline-box;\r\n		display: inline-block;\r\n		line-height: 1;\r\n		letter-spacing: 0 !important;\r\n		font-family: "Arial" !important;\r\n		font-size: 12px !important;\r\n		font-style: normal;    \r\n		background-color: transparent;\r\n		background-position: 100% 0;\r\n		background-repeat: no-repeat;\r\n		height: 30px;\r\n		padding: 8px 20px 0 10px;\r\n		margin: 0 -16px 0 10px;\r\n		border: none;\r\n		vertical-align: text-top;\r\n		zoom: 1;\r\n		_position: relative;\r\n		_padding-left: 0px;\r\n		_padding-right: 12px;\r\n		_margin-right: -10px;	\r\n		_display: block;\r\n		_top: 0;\r\n		_right: -5px;\r\n	}\r\n\r\nspan.button button\r\n	{\r\n		line-height: 2.5; /*Opera need this*/\r\n	}\r\n\r\nhtml.safari a.button span, \r\nhtml.safari del.button span\r\n	{\r\n		line-height: 1.3;\r\n	}\r\n\r\nhtml.safari span.button button\r\n	{\r\n		line-height: 2.6;\r\n	}\r\n\r\nhtml.safari a.button:focus,\r\nhtml.safari span.button button:focus\r\n	{\r\n		outline: none;\r\n	}\r\n\r\ndel.button\r\n	{\r\n		/* cursor:not-allowed;	*/\r\n		background-position: 0 -120px;\r\n	}\r\n\r\ndel.button span\r\n	{\r\n		cursor: default;\r\n		color: #aaa !important;\r\n		background-position: 100% -120px;\r\n	}\r\n\r\nspan.button button, \r\nspan.button input\r\n	{\r\n		padding-top: 0px;\r\n		line-height: 2.5; /*Opera need this*/\r\n	}\r\n\r\n/** optional **/\r\n/*\r\na.button:visited\r\n	{\r\n		color: #aaa;\r\n	}\r\n*/\r\n\r\n/*Hover Style*/\r\n\r\na.button:hover, \r\na.button:focus, \r\na.dom-button-focus, \r\nspan.button-behavior-hover\r\n	{\r\n		background-position: 0 -60px;\r\n		color: #222;\r\n		text-decoration: none;\r\n	}\r\n\r\na.button:hover span, \r\na.button:focus span, \r\nspan.button-behavior-hover button, \r\nspan.button-behavior-hover input\r\n	{\r\n		background-position: 100% -60px;\r\n	}\r\n\r\na.button:active, \r\na.button:focus span\r\n	{\r\n		color: #444;\r\n	}\r\n\r\ndel.button-behavior-hover, \r\ndel.button:hover\r\n	{\r\n		background-position: 0 -180px;\r\n		/* cursor:not-allowed; */\r\n	}\r\n\r\ndel.button-behavior-hover span, \r\ndel.button:hover span\r\n	{\r\n		background-position: 100% -180px;\r\n		/* cursor:not-allowed; */\r\n	}\r\n\r\n/* /Buttons */\r\n', 0, '2009-07-14 18:44:00', '2009-11-08 13:36:42');

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
  `name` varchar(100) collate utf8_unicode_ci NOT NULL,
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
(2, 1, 1, 0, 'Main Layout', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />\r\n<meta http-equiv="Content-Style-Type" content="text/css" />\r\n<meta name="robots" content="index,follow" />\r\n	{* This tag links all attached stylesheets to the current template *}\r\n	{* You can link more stylesheets to this theme by clicking on the small css icon. *}\r\n	{stylesheet}\r\n\r\n	{* Outputs the global metadata found in Configuration => Store Settings *}\r\n	{metadata}\r\n	{headdata}\r\n	{meta_description}\r\n	{meta_keywords}\r\n\n<title>\r\n	{* site_name: Outputs the site name found in Configuration => Store Settings *}\r\n	{* content_name: Outputs the name of the current content page *}\r\n	{site_name} - {page_name}\r\n</title>\r\n</head>\r\n<body>\r\n\r\n<!-- Container -->\r\n<div id="container">\r\n\r\n\r\n<!-- Header -->\r\n<div id="header">\r\n<a href="/"><img src="/img/logo.png" alt="{site_name}" /></a>\r\n</div>\r\n\r\n<!-- /Header -->\r\n\r\n<div id="menu">\r\n{content_listing template=\'information-links\' parent=\'44\'}\r\n</div>\r\n\r\n<!-- Navigation -->\r\n<div id="navigation">\r\n{admin_area_link}\r\n</div>\r\n\r\n<!-- /Navigation -->\r\n\r\n<!-- Main Content -->\r\n<div id="wrapper">\r\n\r\n<div id="content">\r\n\r\n{admin_edit_link}\r\n<h2>{page_name}</h2>\r\n{content}\r\n{admin_edit_link}\r\n\r\n</div>\r\n\r\n</div>\r\n\r\n<!-- /Main Content -->\r\n\r\n<!-- Left Column -->\r\n<div id="left">\r\n\r\n\r\n{content_listing template=\'vertical-menu\' parent=\'0\' type=\'product,category\'}\r\n\r\n</div>\r\n\r\n<!-- /Left Column -->\r\n\r\n<!-- Right Column -->\r\n<div id="right">\r\n\r\n\r\n{shopping_cart template=\'cart-content-box\'}\r\n{language_box template=\'language-box\'}\r\n{currency_box template=\'currency-box\'}\r\n\r\n</div>\r\n\r\n<!-- /Right Column -->\r\n\r\n<!-- Footer -->\r\n<div id="footer">\r\n<p>{global_content alias=\'footer\'}</p>\r\n</div>\r\n\r\n<!-- /Footer -->\r\n\r\n</div>\r\n<!-- /Container -->\r\n\r\n</body>\r\n</html>', '2009-07-26 16:02:41', '2009-07-12 18:50:45'),
(3, 1, 2, 0, 'Content Page', '{description}\r\n', '2009-07-26 16:02:41', '2009-07-29 21:37:54'),
(4, 1, 3, 0, 'Product Info', '{literal}\r\n<script type="text/javascript" src="/js/jquery/jquery.min.js"></script>\r\n<link rel="stylesheet" type="text/css" href="/css/jquery/plugins/fancybox/jquery.fancybox-1.2.5.css" media="screen" />\r\n<script type="text/javascript" src="/js/jquery/plugins/fancybox/jquery.fancybox-1.2.5.pack.js"></script>\r\n<script type="text/javascript">\r\n	$(document).ready(function() {\r\n		$("a.zoom").fancybox();\r\n	});\r\n</script>\r\n{/literal}\r\n\r\n<div id="product_details_left">\r\n	{description}\r\n</div>\r\n<div id="product_details_right">\r\n	<div class="product_images">{content_images number=''1''}</div>\r\n	{product_form}\r\n		<div class="product_price">{product_quantity} @ {product_price}</div>\r\n		<div class="add_to_cart">{purchase_button id=$content_id}</div>\r\n	{/product_form}\r\n	{module alias=''reviews'' action=''link''}\r\n</div>\r\n<div style="clear:both;"></div>', '2009-07-26 16:02:41', '2009-08-20 09:29:00'),
(5, 1, 4, 0, 'Category Info', '{description}\r\n\r\n{if $sub_count.categories > 0}\r\n	<h3>{lang}Sub Categories{/lang}</h3>\r\n	<div class="content_listing">\r\n		{content_listing template=\'subcategory-listing\' parent=$content_id type=''category''}\r\n	</div>\r\n{/if}\r\n\r\n{if $sub_count.products > 0}\r\n	<h3>{lang}Products in this Category{/lang}</h3>\r\n	<div class="content_listing">\r\n		{content_listing template=\'product-listing\' parent=$content_id type=''product''}\r\n	</div>\r\n{/if}', '2009-07-26 16:02:41', '2009-08-30 14:49:18');

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
(1, 'Main Layout', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml">\r\n<head>\r\n	{stylesheet}\r\n	{metadata}\r\n	{headdata}\r\n	{meta_description}\r\n	{meta_keywords}\r\n\n<title>\r\n	{site_name} - {page_name}\r\n</title>\r\n<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />\r\n</head>\r\n<body>\r\n	<div id="layout">\r\n		<div id="header">\r\n			<h1><a href="/">{site_name}</a></h1>\r\n		</div>\r\n		<div id="navigation"> </div>\r\n		<div id="left_sidebar">\r\n			 {content_listing template=''vertical-menu'' parent=''0'' type=''product,category''}\r\n		</div>\r\n		<div id="content">\r\n			{admin_edit_link}\r\n			<div id="inner-content">\r\n				<h2>{page_name}</h2>\r\n				{content}\r\n			</div>\r\n			{admin_edit_link}\r\n		</div>\r\n		<div id="right_sidebar">\r\n			{shopping_cart template=''cart-content-box''}\r\n			{language_box}\r\n			{currency_box}\r\n		</div>\r\n		<div class="clearb"></div>	\r\n		<div id="footer">\r\n			{content_listing template=''information-links'' parent=''44''}\r\n		</div>\r\n		<div id="powered_by">\r\n			{global_content alias=''footer''}\r\n		</div>\r\n	</div>\r\n</body>\r\n</html>'),
(2, 'Content Page', '{description}'),
(3, 'Product Info', '<div id="product_details_left">\r\n	{description}\r\n</div>\r\n<div id="product_details_right">\r\n	<div class="product_images">{content_images number=''1''}</div>\r\n	{product_form}\r\n		<div class="product_price">{product_quantity} @ {product_price}</div>\r\n		<div class="add_to_cart">{purchase_button id=$content_id}</div>\r\n	{/product_form}\r\n</div>\r\n<div style="clear:both;"></div>'),
(4, 'Category Info', '{description}');

DROP TABLE IF EXISTS users;
CREATE TABLE `users` (
  `id` int(10) NOT NULL auto_increment,
  `username` varchar(50) collate utf8_unicode_ci NOT NULL,
  `email` varchar(50) collate utf8_unicode_ci NOT NULL,
  `password` varchar(100) collate utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created`, `modified`) VALUES 
(1, 'admin', 'vam@test.com', '5f4dcc3b5aa765d61d8327deb882cf99', '0000-00-00 00:00:00', '2009-07-23 15:34:53');

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
(3, 1, 'language', 'eng');

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
