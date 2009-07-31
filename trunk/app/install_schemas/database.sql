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
(6, 'CACHE_TIME', '3600');

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
(35, 0, 1, 0, 3, 1, 1, 'home-page', '', 1, 1, '2007-07-28 21:11:18', '2007-09-12 12:30:17'),
(36, 0, 3, 0, 1, 1, 0, 'horns', '', 1, 1, '2007-07-28 21:11:49', '2007-08-01 14:56:05'),
(38, 36, 2, 0, 2, 1, 0, 'elk-horns', '', 1, 1, '2007-07-29 18:54:37', '2007-09-11 11:20:29'),
(39, 0, 2, 0, 1, 1, 0, 'hoofs', '', 1, 1, '2007-07-29 22:02:10', '2007-08-01 14:55:54'),
(44, 0, 4, 0, 3, 1, 0, 'information', '', 1, 0, '2007-07-30 15:34:48', '2007-07-30 15:35:02'),
(45, 44, 1, 0, 3, 1, 0, 'shipping--returns', '', 1, 1, '2007-07-30 15:36:30', '2007-08-06 14:53:16'),
(46, 44, 1, 0, 3, 1, 0, 'privacy-policy', '', 1, 1, '2007-07-30 15:36:54', '2007-07-30 15:37:09'),
(47, 44, 2, 0, 3, 1, 0, 'conditions-of-use', '', 1, 1, '2007-07-30 15:37:33', '2007-07-30 15:37:33'),
(48, 44, 3, 0, 3, 1, 0, 'contact-us', '', 1, 1, '2007-07-30 15:38:03', '2007-07-30 15:38:03'),
(49, -1, 5, 0, 3, 1, 0, 'cart-contents', '', 1, 1, '2007-07-30 20:40:14', '2007-08-09 16:23:47'),
(50, -1, 6, 0, 3, 1, 0, 'checkout', '', 1, 1, '2007-07-30 20:52:36', '2007-08-01 16:54:56'),
(51, -1, 5, 0, 3, 1, 0, 'payment', '', 1, 1, '2007-08-07 11:16:28', '2007-09-01 16:22:10'),
(53, -1, 5, 0, 3, 1, 0, 'thank-you', '', 1, 1, '2007-08-07 11:58:21', '2007-08-15 16:00:40'),
(58, -1, 0, 0, 3, 1, 0, 'read-reviews', '', 1, 0, '2007-08-20 09:37:04', '2007-08-20 09:37:04'),
(59, -1, 0, 0, 3, 1, 0, 'create-review', '', 1, 0, '2007-08-20 09:37:04', '2007-08-20 09:37:04'),
(68, -1, 0, 0, 3, 1, 0, 'coupon-details', '', 1, 0, '2007-09-13 11:11:08', '2007-09-13 11:11:08');

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
  `name` varchar(50) collate utf8_unicode_ci NOT NULL,
  `description` text collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `content_descriptions` (`id`, `content_id`, `language_id`, `name`, `description`) VALUES 
(179, 44, 1, 'Information', 'Information about our site can be found by visiting the following links:'),
(180, 44, 2, 'Информация', 'Информация о магазине доступна по следующим ссылкам:'),
(185, 46, 1, 'Payment methods', '<p>Enter your payment methods on this page.</p>'),
(186, 46, 2, 'Оплата', '<p>Укажите информацию о способах оплаты товара на данной странице.</p>'),
(187, 47, 1, 'About Us', '<p>About us page.</p>'),
(188, 47, 2, 'О магазине', '<p>Информация о магазине.</p>'),
(189, 48, 1, 'Contact Us', '<p>Enter your contact information on this page.</p>'),
(190, 48, 2, 'Контакты', '<p>Контактная информация.</p>'),
(225, 39, 1, 'Hoofs', 'Description'),
(226, 39, 2, 'Копыта', 'Описание категории!'),
(227, 36, 1, 'Horns', 'Description'),
(228, 36, 2, 'Рога', 'Рога оленей, лосей и других животных!'),
(241, 50, 1, 'Checkout', '{checkout}'),
(242, 50, 2, 'Оформление', '{checkout}'),
(245, 45, 1, 'Shipping and Returns', '<p>Enter your Shipping & Return information on this page.</p>'),
(246, 45, 2, 'Доставка', '<p>Укажите информацию о способах доставки товара на данной странице.</p>'),
(269, 49, 1, 'Cart Contents', '{shopping_cart}'),
(270, 49, 2, 'Корзина', '{shopping_cart}'),
(313, 53, 1, 'Thank You', 'Thanks for shopping!'),
(314, 53, 2, 'Спасибо', 'Спасибо за покупки!'),
(323, 58, 1, 'Read Reviews', '{module alias=''reviews'' action=''display''}'),
(324, 58, 2, 'Читать отзывы', '{module alias=''reviews'' action=''display''}'),
(325, 59, 1, 'Write Review', '{module alias=''reviews'' action=''create''}'),
(326, 59, 2, 'Добавить отзыв', '{module alias=''reviews'' action=''create''}'),
(359, 51, 1, 'Payment', '{payment}\r\n\r\n<h2 style="margin-top:75px;">{lang}cart-contents{/lang}<h2>\r\n{shopping_cart template=''payment-view-cart''}'),
(360, 51, 2, 'Оплата', '{payment}\r\n\r\n<h2 style="margin-top:75px;">{lang}cart-contents{/lang}<h2>\r\n{shopping_cart template=''payment-view-cart''}'),
(385, 38, 1, 'Elk Horns', 'Product description.'),
(386, 38, 2, 'Рога лося', 'Дешевле не найдёте, отличные лосиные рога.'),
(391, 35, 1, 'Home', '<p>Welcome to your new online catalog!</p>\r\n<p><a href=''admin/''>Click here to go to the admin area.</a><br />\r\nLogin credentials: admin/password</p>'),
(392, 35, 2, 'Главная страница', '<p>Добро пожаловать!</p>\r\n<p><a href=''admin/''>Вход в админку.</a><br />\r\nЛогин/пароль: admin/password</p>'),
(393, 68, 1, 'Voucher Details', '{module alias=''coupons'' action=''show_info''}'),
(394, 68, 2, 'Информация о купоне', '{module alias=''coupons'' action=''show_info''}');

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
(1, 4, 'Category', 'ContentCategory'),
(2, 3, 'Product', 'ContentProduct'),
(3, 2, 'Page', 'ContentPage'),
(4, 0, 'Link', 'ContentLink'),
(5, 0, 'Selflink', 'ContentSelflink');

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
(1, 1, 1, 'US Dollar', 'USD', '$', '', '.', ',', '2', 1, '2007-07-15 11:39:15', '2007-07-15 13:08:23'),
(2, 1, 0, 'Рубль', 'RUR', '', 'руб.', '.', ',', '0.0312', 1, '2007-07-15 11:39:15', '2007-07-15 13:08:23'),
(3, 1, 0, 'Euro', 'EUR', '&euro;', '', '.', ',', '2', 0.7811, '2007-07-15 13:09:23', '2007-07-15 13:09:23');

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
(25, 1, 'welcome-message', 'Welcome to the online store yo! 2 ', '2007-07-27 20:35:49', '2007-07-27 20:35:49'),
(26, 2, 'welcome-message', 'Добро пожаловать!', '2007-07-27 20:35:49', '2007-07-27 20:35:49'),
(27, 1, 'product', 'Product', '2007-07-31 15:09:46', '2007-07-31 15:09:46'),
(28, 2, 'product', 'Товар', '2007-07-31 15:09:46', '2007-07-31 15:09:46'),
(29, 1, 'price-ea', 'Price Ea.', '2007-07-31 15:09:57', '2007-07-31 15:09:57'),
(30, 2, 'price-ea', 'Цена / шт.', '2007-07-31 15:09:57', '2007-07-31 15:09:57'),
(31, 1, 'qty', 'Qty.', '2007-07-31 15:10:08', '2007-07-31 15:10:08'),
(32, 2, 'qty', 'Количество', '2007-07-31 15:10:08', '2007-07-31 15:10:08'),
(33, 1, 'total', 'Total', '2007-07-31 15:10:18', '2007-07-31 15:10:18'),
(34, 2, 'total', 'Всего', '2007-07-31 15:10:18', '2007-07-31 15:10:18'),
(35, 1, 'checkout', 'Checkout', '2007-07-31 15:13:50', '2007-07-31 15:13:50'),
(36, 2, 'checkout', 'Оформить', '2007-07-31 15:13:50', '2007-07-31 15:13:50'),
(37, 1, 'shopping-cart', 'Shopping Cart', '2007-07-31 15:13:59', '2007-07-31 15:13:59'),
(38, 2, 'shopping-cart', 'Корзина', '2007-07-31 15:13:59', '2007-07-31 15:13:59'),
(39, 1, 'Currency', 'Currency', '2007-07-31 15:50:10', '2007-07-31 15:50:10'),
(40, 2, 'Currency', 'Валюта', '2007-07-31 15:50:10', '2007-07-31 15:50:10'),
(41, 1, 'Language', 'Language', '2007-08-01 14:53:11', '2007-08-01 14:53:11'),
(42, 2, 'Language', 'Язык', '2007-08-01 14:53:11', '2007-08-01 14:53:11'),
(43, 1, 'no-cart-items', 'There are no items in your cart.', '2007-08-01 15:17:08', '2007-08-01 15:17:08'),
(44, 2, 'no-cart-items', 'Корзина пуста.', '2007-08-01 15:17:08', '2007-08-01 15:17:08'),
(45, 1, 'sub-category-list', 'Sub Categories', '2007-08-02 09:32:33', '2007-08-02 09:32:33'),
(46, 2, 'sub-category-list', 'Подкатегории', '2007-08-02 09:32:33', '2007-08-02 09:32:33'),
(47, 1, 'sub-product-list', 'Products in this Category', '2007-08-02 09:32:50', '2007-08-02 09:32:50'),
(48, 2, 'sub-product-list', 'Товары в данной категории', '2007-08-02 09:32:50', '2007-08-02 09:32:50'),
(49, 1, 'no-sub-categories', 'No child categories.', '2007-08-02 09:36:10', '2007-08-02 09:36:10'),
(50, 2, 'no-sub-categories', 'Нет подкатегорий.', '2007-08-02 09:36:10', '2007-08-02 09:36:10'),
(53, 1, 'no-sub-products', 'No Child Products.', '2007-08-02 09:36:38', '2007-08-02 09:36:38'),
(54, 2, 'no-sub-products', 'Нет товаров.', '2007-08-02 09:36:38', '2007-08-02 09:36:38'),
(55, 1, 'name', 'Name', '2007-08-02 13:56:04', '2007-08-02 13:56:04'),
(56, 2, 'name', 'Имя', '2007-08-02 13:56:04', '2007-08-02 13:56:04'),
(57, 1, 'Billing Information', 'Billing Information', '2007-08-02 13:56:47', '2007-08-02 13:56:47'),
(58, 2, 'Billing Information', 'Информация о покупателе', '2007-08-02 13:56:47', '2007-08-02 13:56:47'),
(59, 1, 'address_line_1', 'Address Line 1', '2007-08-02 13:57:04', '2007-08-02 13:57:04'),
(60, 2, 'address_line_1', 'Адрес', '2007-08-02 13:57:04', '2007-08-02 13:57:04'),
(61, 1, 'address_line_2', 'Address Line 2', '2007-08-02 13:57:34', '2007-08-02 13:57:34'),
(62, 2, 'address_line_2', 'Доп. информация', '2007-08-02 13:57:34', '2007-08-02 13:57:34'),
(65, 1, 'city', 'City', '2007-08-06 17:43:04', '2007-08-06 17:43:04'),
(66, 2, 'city', 'Город', '2007-08-06 17:43:04', '2007-08-06 17:43:04'),
(67, 1, 'state', 'State', '2007-08-06 17:43:57', '2007-08-06 17:43:57'),
(68, 2, 'state', 'Регион', '2007-08-06 17:43:57', '2007-08-06 17:43:57'),
(71, 1, 'zipcode', 'Zipcode ', '2007-08-06 17:44:17', '2007-08-06 17:44:17'),
(72, 2, 'zipcode', 'Почтовый индекс', '2007-08-06 17:44:17', '2007-08-06 17:44:17'),
(73, 1, 'Shipping Information', 'Shipping Information (if different from billing address)', '2007-08-06 17:44:44', '2007-08-06 17:44:44'),
(74, 2, 'Shipping Information', 'Информация о доставке', '2007-08-06 17:44:44', '2007-08-06 17:44:44'),
(75, 1, 'continue to payment', 'Continue to Payment', '2007-08-06 17:58:54', '2007-08-06 17:58:54'),
(76, 2, 'continue to payment', 'Продолжить', '2007-08-06 17:58:54', '2007-08-06 17:58:54'),
(77, 1, 'Shipping Method', 'Shipping Method', '2007-08-06 18:00:49', '2007-08-06 18:00:49'),
(78, 2, 'Shipping Method', 'Способы доставки', '2007-08-06 18:00:49', '2007-08-06 18:00:49'),
(79, 1, 'Payment Method', 'Payment Method', '2007-08-06 18:00:59', '2007-08-06 18:00:59'),
(80, 2, 'Payment Method', 'Способы оплаты', '2007-08-06 18:00:59', '2007-08-06 18:00:59'),
(81, 1, 'Confirm Order', 'Confirm Order', '2007-08-07 11:24:48', '2007-08-07 11:24:48'),
(82, 2, 'Confirm Order', 'Подтвердить заказ', '2007-08-07 11:24:48', '2007-08-07 11:24:48'),
(83, 1, 'Make payment with money order/check.', 'You are about to make a payment using a money order or check. Please note that this form of payment will take an additional 5-7 days to clear before your order is shipped.', '2007-08-07 11:45:43', '2007-08-07 11:45:43'),
(84, 2, 'Make payment with money order/check.', 'Доставка будет осуществлена в течение 5-7 дней после оплаты.', '2007-08-07 11:45:44', '2007-08-07 11:45:44'),
(87, 1, 'Contact Information', 'Contact Information', '2007-08-09 09:24:12', '2007-08-09 09:24:12'),
(88, 2, 'Contact Information', 'Контактная информация', '2007-08-09 09:24:12', '2007-08-09 09:24:12'),
(93, 1, 'email', 'Email', '2007-08-10 10:59:57', '2007-08-10 10:59:57'),
(94, 2, 'email', 'Email', '2007-08-10 10:59:57', '2007-08-10 10:59:57'),
(95, 1, 'phone', 'Phone', '2007-08-10 11:34:27', '2007-08-10 11:34:27'),
(96, 2, 'phone', 'Телефон', '2007-08-10 11:34:27', '2007-08-10 11:34:27'),
(97, 1, 'shipping', 'Shipping', '2007-08-10 13:04:09', '2007-08-10 13:04:09'),
(98, 2, 'shipping', 'Доставка', '2007-08-10 13:04:09', '2007-08-10 13:04:09'),
(99, 1, 'cart-contents', 'Cart Contents', '2007-08-10 13:08:48', '2007-08-10 13:08:48'),
(100, 2, 'cart-contents', 'Содержание корзины', '2007-08-10 13:08:48', '2007-08-10 13:08:48'),
(103, 1, 'money_order_check-details', 'Your order will ship out after your payment clears.', '2007-08-11 15:34:09', '2007-08-11 15:34:09'),
(104, 2, 'money_order_check-details', 'Заказ будет выполнен после получения оплаты.', '2007-08-11 15:34:09', '2007-08-11 15:34:09'),
(105, 1, 'store_pickup-details', 'Enter any in-store pickup details here.  You can find this content in the admin area, Locale -> Defined Language Values -> store-pickup-details', '2007-08-11 15:34:18', '2007-08-11 15:34:18'),
(106, 2, 'store_pickup-details', 'Укажите свою информацию о получении заказа в Админке -> Локализация -> Языковые строки -> store-pickup-details', '2007-08-11 15:34:18', '2007-08-11 15:34:18'),
(107, 1, 'paypal-details', 'Checkout with paypal.', '2007-08-11 15:35:57', '2007-08-11 15:35:57'),
(108, 2, 'paypal-details', 'Оформление через paypal.', '2007-08-11 15:35:57', '2007-08-11 15:35:57'),
(109, 1, 'credit_card-details', 'Enter your credit card details.', '2007-08-12 16:08:57', '2007-08-12 16:08:57'),
(110, 2, 'credit_card-details', 'Укажите данные Вашей кредитной карты.', '2007-08-12 16:08:57', '2007-08-12 16:08:57'),
(111, 1, 'Read Reviews', 'Read Reviews', '2007-08-13 09:28:49', '2007-08-13 09:28:49'),
(112, 2, 'Read Reviews', 'Читать отзывы', '2007-08-13 09:28:49', '2007-08-13 09:28:49'),
(113, 1, 'Write a Review', 'Write a Review', '2007-08-13 09:28:49', '2007-08-13 09:28:49'),
(114, 2, 'Write a Review', 'Добавить отзыв', '2007-08-13 09:28:49', '2007-08-13 09:28:49'),
(115, 1, 'google_html-details', '<p>Click the button below to be taken to Google Checkout.</p>', '2007-08-13 16:57:39', '2007-08-13 16:57:39'),
(116, 2, 'google_html-details', '<p>Нажмите кнопку ниже для перехода к оплате.</p>', '2007-08-13 16:57:39', '2007-08-13 16:57:39'),
(117, 1, 'Main Page', 'Main Page', '2007-08-13 09:28:49', '2007-08-13 09:28:49'),
(118, 2, 'Main Page', 'Главная', '2007-08-13 09:28:49', '2007-08-13 09:28:49'),
(119, 1, 'Categories', 'Categories', '2007-08-13 09:28:49', '2007-08-13 09:28:49'),
(120, 2, 'Categories', 'Разделы', '2007-08-13 09:28:49', '2007-08-13 09:28:49');

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
(1, 2, 'CouponsModule', '/module_coupons/event/utilize_coupon/', '2007-09-13 11:11:08', '2007-09-13 11:11:08');

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
(1, 'Footer', '<a href="http://vamshop.ru/" target="blank">VaM Shop</a>', 'footer', 1, '2007-07-17 10:00:06', '2007-09-12 17:05:49');

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
(1, 'vertical-menu', '<!-- Categories box -->\r\n<div class="box">\r\n<h5>{lang}Categories{/lang}</h5>\r\n<div class="boxContent">\r\n<ul id="CatNavi">\r\n{foreach from=$content_list item=node}\r\n<li{if $node.alias == $content_alias} class="active"{/if}><a href="{$node.url}">{$node.name}</a></li>\r\n{/foreach}\r\n</ul>\r\n</div>\r\n</div>\r\n<!-- /Categories box -->', '2007-07-28 17:08:06', '2009-07-12 18:59:10', 'content_listing'),
(3, 'information-links', '<ul>\r\n<li{if  $smarty.server.REQUEST_URI == \'/\'} class="current"{/if}><a href="/"><span>{lang}Main Page{/lang}</span></a></li>\r\n{foreach from=$content_list item=node}\r\n<li{if $node.alias == $content_alias} class="current"{/if}><a href="{$node.url}"><span>{$node.name}</span></a></li>\r\n{/foreach}\r\n</ul>', '2007-07-30 15:42:21', '2009-07-12 15:41:54', 'content_listing'),(5, 'shopping-cart', '<div class="cart">\r\n	<table style="width:100%;">\r\n		<tr>	\r\n			<th> </th>\r\n			<th>{lang}product{/lang}</th>\r\n			<th>{lang}price-ea{/lang}</th>\r\n			<th>{lang}qty{/lang}</th>\r\n			<th>{lang}total{/lang}</th>\r\n		</tr>\r\n				\r\n		{foreach from=$order_items item=product}			\r\n			<tr>\r\n				<td><a href="/cart/remove_product/{$product.id}" class="remove">x</a></td>\r\n				<td><a href="{$product.link}">{$product.name}</a></td>\r\n				<td>{$product.price}</td>\r\n				<td>{$product.qty}</td>\r\n				<td>{$product.line_total}</td>\r\n			</tr>				\r\n		{foreachelse}	\r\n			<tr>\r\n				<td colspan="5">{lang}no-cart-items{/lang}</td>\r\n			</tr>\r\n		{/foreach}				\r\n				\r\n		<tr class="cart_total">\r\n			<td colspan="5">{lang}total{/lang} {$order_total}</td>\r\n		</tr>\r\n	</table>\r\n	<a class="checkout" href="{$checkout_link}">{lang}checkout{/lang}</a>\r\n</div>', '2007-07-31 14:56:59', '2007-09-02 22:26:49', 'shopping_cart'),
(6, 'currency-box', '<!-- Box -->\r\n<div class="box">\r\n<h5>{lang}Currency{/lang}</h5>\r\n<div class="boxContent">\r\n\r\n<form action="/currencies/pick_currency/" method="post">\r\n<select name="currency_picker">\r\n{foreach from=$currencies item=currency}\r\n<option value="{$currency.id}" {if $currency.id == $smarty.session.Customer.currency_id}selected="selected"{/if}>{$currency.name}</option>\r\n{/foreach}\r\n</select>\r\n<input type="submit" value="{lang}Go{/lang}" />\r\n</form>\r\n		\r\n</p>\r\n</div>\r\n</div>\r\n<!-- /Box -->', '2007-08-01 14:42:02', '2009-07-12 18:57:01', 'currency_box'),
(8, 'cart-content-box', '<!-- Box -->\r\n<div class="box">\r\n<h5><a href="{$cart_link}" class="shopping_cart_link">{lang}shopping-cart{/lang}</a></h5>\r\n<div class="boxContent">\r\n\r\n	<ul class="cart_contents">\r\n		{foreach from=$order_items item=product}\r\n			<li>{$product.qty} x <a href="{$product.url}">{$product.name}</a></li>\r\n		{/foreach}\r\n	</ul>\r\n	<ul class="cart_total">\r\n		<li>{lang}total{/lang}: {$order_total}</li>\r\n	</ul>\r\n	<a class="checkout" href="{$checkout_link}">{lang}checkout{/lang}</a>\r\n		\r\n</p>\r\n</div>\r\n</div>\r\n<!-- /Box -->', '2007-08-09 16:27:09', '2009-07-12 19:24:29', 'shopping_cart'),
(9, 'payment-view-cart', '<div class="cart">\r\n	<table style="width:100%;">\r\n		<tr>	\r\n			<th> </th>\r\n			<th>{lang}product{/lang}</th>\r\n			<th>{lang}price-ea{/lang}</th>\r\n			<th>{lang}qty{/lang}</th>\r\n			<th>{lang}total{/lang}</th>\r\n		</tr>\r\n				\r\n		{foreach from=$order_items item=product}			\r\n			<tr>\r\n				<td><a href="/cart/remove_product/{$product.id}" class="remove">x</a></td>\r\n				<td><a href="{$product.link}">{$product.name}</a></td>\r\n				<td>{$product.price}</td>\r\n				<td>{$product.qty}</td>\r\n				<td>{$product.line_total}</td>\r\n			</tr>				\r\n		{foreachelse}	\r\n			<tr>\r\n				<td colspan="5">{lang}no-cart-items{/lang}</td>\r\n			</tr>\r\n		{/foreach}				\r\n				\r\n		<tr class="cart_total">\r\n			<td colspan="5">\r\n				{lang}shipping{/lang}: {$shipping_total}<br />\r\n				<strong>{lang}total{/lang}:</strong> {$order_total}\r\n			</td>\r\n		</tr>\r\n	</table>\r\n</div>', '2007-08-10 13:09:25', '2007-09-02 22:25:57', 'shopping_cart'),
(10, 'language-box', '<!-- Box -->\r\n<div class="box">\r\n<h5>{lang}Language{/lang}</h5>\r\n<div class="boxContent">\r\n\r\n{foreach from=$languages item=language}\r\n<a href="{$language.url}"><img src="{$language.image}" alt="{$language.name}" title="{$language.name}"/></a>\r\n{/foreach}\r\n\r\n</div>\r\n</div>\r\n<!-- /Box -->', '2009-07-12 18:52:23', '2009-07-12 18:57:08', 'language_box');

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
(1, 1, 2, 2, 5.99, 0, 25.79, 'Test Order', 'asdfasf', 'asdfasdf', '', '', '', '', '', '', '', '', '', '', '', 0, 0, 0, '0000-00-00 00:00:00');

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
(1, 1, 1, 0, 'asdf', '2007-08-28 11:06:18', '2007-08-28 11:06:18');

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
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `payment_methods` (`id`, `active`, `default`, `name`, `alias`) VALUES 
(1, 1, 0, 'In-store Pickup', 'store_pickup'),
(2, 1, 1, 'Money Order/Check', 'money_order_check'),
(3, 1, 0, 'Paypal', 'paypal'),
(4, 1, 0, 'Credit Card', 'credit_card'),
(5, 1, 0, 'Authorize.Net', 'authorize'),
(6, 1, 0, 'Google Checkout', 'google_html');

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
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `shipping_methods` (`id`, `name`, `code`, `default`, `active`) VALUES 
(1, 'Free Shipping', 'free_shipping', 0, 1),
(2, 'Flat Rate', 'flat_rate', 1, 1),
(3, 'Per Item', 'per_item', 0, 1),
(4, 'Table Based', 'table_based', 0, 1);

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

INSERT INTO `stylesheets` (`id`, `active`, `name`, `alias`, `stylesheet`, `stylesheet_media_type_id`, `created`, `modified`) VALUES 
(1, 1, 'Default Layout', 'default-home-page-layout', '/* -----------------------------------------------------------------------------------------\r\n   VaM Shop - open source ecommerce solution\r\n   http://vamshop.ru\r\n\r\n   Copyright (c) 2005-2008 VaM Shop \r\n   -----------------------------------------------------------------------------------------\r\n   Released under the GNU General Public License \r\n   ---------------------------------------------------------------------------------------*/\r\n\r\n/*<![CDATA[*/\r\n\r\nhtml,body\r\n   {\r\n     margin: 0;\r\n     padding: 0;\r\n   }\r\n\r\nbody\r\n   {\r\n     font: 76% arial,sans-serif;\r\n   }\r\n\r\nimg\r\n   {\r\n	  border: 0;\r\n   }\r\n\r\nh2, h3\r\n   {\r\n     margin: 0 0 0 0;\r\n     padding: 0 0 0 0;\r\n   }\r\n   \r\n/* Links color */\r\na \r\n   {\r\n     color: #000;\r\n     text-decoration: underline;\r\n   }\r\n\r\na:hover \r\n   {\r\n     color: #990000;\r\n     text-decoration: none;\r\n   }\r\n/* /Links color */\r\n\r\n/* Content */\r\ndiv#wrapper\r\n   {\r\n     float: left;\r\n     width: 100%;\r\n   }\r\n\r\ndiv#content\r\n   {\r\n     margin: 0 19%;\r\n   }\r\n\r\n/* /Content */\r\n\r\n/* Left column */\r\ndiv#left\r\n   {\r\n     float: left;\r\n     width: 18%;\r\n     margin-left: -100%;\r\n     background: #fff;\r\n   }\r\n/* /Left column */\r\n\r\n/* Right column */\r\ndiv#right\r\n   {\r\n     float: left;\r\n     overflow: auto;\r\n     width: 18%;\r\n     margin-left: -18%;\r\n     background: #fff;\r\n   }\r\n/* /Right column */\r\n\r\n/* Footer */\r\ndiv#footer\r\n   {\r\n     clear: left;\r\n     height: 50px;\r\n     width: 100%;\r\n     background: #f1f1f6;\r\n     border-top: 3px solid #67748B;\r\n     text-align: center;\r\n     color: #000;\r\n   }\r\n   \r\ndiv#footer p\r\n   {\r\n     margin: 0;\r\n     padding: 5px 10px;\r\n   }\r\n   \r\n/* /Footer */\r\n\r\n/* Navigation */\r\ndiv#navigation \r\n   {\r\n     padding-top: 0.5em;\r\n     padding-bottom: 0.5em;\r\n     padding-left: 10px;\r\n     border-bottom: 1px solid #000;\r\n     background: #990000;\r\n     color: #ffffff;\r\n   }\r\n\r\n#navigation span \r\n   {\r\n     display: block;\r\n     font: 11px Tahoma, Verdana, Arial, sans-serif;\r\n     font-weight: bold;\r\n     color: #ffffff;\r\n     border-bottom: 2px #990000 solid;\r\n     padding: 0 0 0 20px; \r\n   }\r\n   \r\n#navigation a\r\n   {\r\n     font: 11px Tahoma, Verdana, Arial, sans-serif;\r\n     font-weight: bold;\r\n     color: #ffffff;\r\n     text-decoration: none;\r\n   }\r\n\r\n#navigation a:hover\r\n   {\r\n     font: 11px Tahoma, Verdana, Arial, sans-serif;\r\n     font-weight: bold;\r\n     color: #ffffff;\r\n     text-decoration: none;\r\n   }\r\n\r\n#navigation a:visited\r\n   {\r\n     font: 11px Tahoma, Verdana, Arial, sans-serif;\r\n     font-weight: bold;\r\n     color: #ffffff;\r\n     text-decoration: none;\r\n   }\r\n   \r\n/* /Navigation */\r\n   \r\n/* Page header */\r\n#content h1 \r\n   {\r\n     display: block;\r\n     font: 16px Tahoma, Verdana, Arial, sans-serif;\r\n     font-weight: bold;\r\n     color: #990000;\r\n     border-bottom: 2px #990000 solid;\r\n     padding: 0 0 0 20px; \r\n     margin: 0.2em 0 0.2em 0; \r\n   }\r\n\r\n#content h1 a \r\n   {\r\n     color: #990000;\r\n     text-decoration: none;\r\n   }\r\n/* /Page header */\r\n\r\n/* Page content */\r\n.page \r\n   {\r\n     background: transparent;\r\n     width: 100%;\r\n     margin-top: 0.5em;\r\n     margin-bottom: 0.5em;\r\n   }\r\n\r\n.pageItem \r\n   {\r\n     background: #f1f1f6;\r\n     width: 100%;\r\n   }\r\n\r\n.page h1, .page p \r\n   {\r\n     margin: 0 10px;\r\n   }\r\n\r\n.page h1 \r\n   {\r\n     font-size: 2em;\r\n     color: #fff;\r\n   }\r\n\r\n.page p \r\n   {\r\n     padding-bottom: 0.5em;\r\n     padding-top: 0.5em;\r\n   }\r\n\r\n.page .b1, .page .b2, .page .b3, .page .b4, .page .b1b, .page .b2b, .page .b3b, .page .b4b \r\n   {\r\n     display: block;\r\n     overflow: hidden;\r\n     font-size: 1px;\r\n   }\r\n\r\n.page .b1, .page .b2, .page .b3, .page .b1b, .page .b2b, .page .b3b \r\n   {\r\n     height: 1px;\r\n   }\r\n\r\n.page .b2 \r\n   {\r\n     background: #f1f1f6;\r\n     border-left: 1px solid #fff;\r\n     border-right: 1px solid #f1f1f6;\r\n   }\r\n\r\n.page .b3 \r\n   {\r\n     background: #f1f1f6;\r\n     border-left: 1px solid #fff;\r\n     border-right: 1px solid #f1f1f6;\r\n   }\r\n\r\n.page .b4 \r\n   {\r\n     background: #f1f1f6;\r\n     border-left: 1px solid #fff;\r\n     border-right: 1px solid #f1f1f6;\r\n   }\r\n\r\n.page .b4b \r\n   {\r\n     background: #f1f1f6;\r\n     border-left: 1px solid #f1f1f6;\r\n     border-right: 1px solid #f1f1f6;\r\n   }\r\n\r\n.page .b3b \r\n   {\r\n     background: #f1f1f6;\r\n     border-left: 1px solid #f1f1f6;\r\n     border-right: 1px solid #f1f1f6;\r\n   }\r\n\r\n.page .b2b \r\n   {\r\n     background: #f1f1f6;\r\n     border-left: 1px solid #f1f1f6;\r\n     border-right: 1px solid #f1f1f6;\r\n   }\r\n\r\n.page .b1 \r\n   {\r\n     margin: 0 5px;\r\n     background: #fff;\r\n   }\r\n\r\n.page .b2, .page .b2b \r\n   {\r\n     margin: 0 3px;\r\n     border-width: 0 2px;\r\n   }\r\n\r\n.page .b3, .page .b3b \r\n   {\r\n     margin: 0 2px;\r\n   }\r\n\r\n.page .b4, .page .b4b \r\n   {\r\n     height: 2px;\r\n     margin: 0 1px;\r\n   }\r\n\r\n.page .b1b \r\n   {\r\n     margin: 0 5px;\r\n     background: #f1f1f6;\r\n   }\r\n\r\n.pagecontent \r\n   {\r\n     display: block;\r\n     padding-left: 0.5em;\r\n     padding-right: 0.5em;\r\n     background: #f1f1f6;\r\n   }\r\n\r\n.pagecontentfooter \r\n   {\r\n     display: block;\r\n     text-align: right;\r\n     background:#ffffff;\r\n     margin-top: 0.5em;\r\n     margin-bottom: 0.5em;\r\n   }\r\n/* /Page content */\r\n\r\n/*- Bookmarks */\r\n\r\n#menu \r\n   {\r\n	  background: #fff;\r\n	  border-bottom: 1px solid #000;\r\n	  border-width: 1px;\r\n	  margin-top: 1em;\r\n	  padding-top: .6em;\r\n   }\r\n\r\n#menu ul, #navigation ul li \r\n   {\r\n	  list-style: none;\r\n	  margin: 0;\r\n	  padding: 0;\r\n   }\r\n\r\n#menu ul \r\n   {\r\n	  padding: 5px 0 0px;\r\n	  text-align: center;\r\n   }\r\n\r\n#menu ul li \r\n   {\r\n	  display: inline;\r\n	  margin:0 .375em;\r\n   }\r\n\r\n#menu ul li.last \r\n   {\r\n	  margin-right: 0;\r\n   }\r\n\r\n#menu ul li a \r\n   {\r\n	  background: url("/img/tab-right.png") no-repeat 100% 0;\r\n	  background-color: #67748b;\r\n	  color: #fff;\r\n	  padding: 0px 0 0px;\r\n     font-weight: bold;\r\n	  text-decoration: none;\r\n   }\r\n\r\n#menu ul li.current a \r\n   {\r\n	  background: url("/img/tab-right-active.png") no-repeat 100% 0;\r\n	  background-color: #990000;\r\n	  color: #fff;\r\n	  padding: 0px 0 1px;\r\n     font-weight: bold;\r\n	  text-decoration: none;\r\n   }\r\n\r\n#menu ul li a span \r\n   {\r\n	  background: url("/img/tab-left.png") no-repeat;\r\n	  padding: 0px 1em;\r\n     border-bottom:1px solid #000;\r\n   }\r\n\r\n#menu ul li.current a span \r\n   {\r\n	  background: url("/img/tab-left-active.png") no-repeat;\r\n	  padding: 0px 1em 1px;\r\n     border-bottom:0;\r\n   }\r\n\r\n#menu ul li a:hover span \r\n   {\r\n	  color: #fff;\r\n     font-weight: bold;\r\n	  text-decoration: none;\r\n   }\r\n\r\n/*\\*//*/\r\n#menu ul li a \r\n   {\r\n	  display: inline-block;\r\n	  white-space: nowrap;\r\n	  width: 1px;\r\n   }\r\n\r\n#menu ul \r\n   {\r\n	  padding-bottom: 0;\r\n	  margin-bottom: -1px;\r\n   }\r\n/**/\r\n\r\n/*\\*/\r\n* html #menu ul li a \r\n   {\r\n	  padding: 0;\r\n   }\r\n/**/\r\n\r\n/*- /Bookmarks */\r\n\r\n/*- Boxes */\r\n\r\n/*- Box */\r\n.box\r\n   {\r\n     text-align: left;\r\n     margin-bottom: 0.2em;\r\n     margin-top: 0.2em;\r\n     margin-right: 0.2em;\r\n     padding-top: 0.2em;\r\n     padding-bottom: 0.4em;\r\n  	  border-bottom-width: 1px;\r\n	  border-bottom-style: dashed;\r\n     border-bottom-color: #67748B;\r\n   }\r\n\r\n/*- Box Header */\r\n.box h5 \r\n   {\r\n     display: block;\r\n     font: 12px Tahoma, Verdana, Arial, sans-serif;\r\n     font-weight: bold;\r\n     color: #990000;\r\n     border-bottom: 2px #e5e5e5 solid;\r\n     background: url(/img/box.png) no-repeat left center;\r\n     margin: 0 0 .4em .3em;\r\n     padding: .1em 0 0 16px;\r\n  }\r\n\r\n.box h5 a\r\n   {\r\n     color: #990000;\r\n     text-decoration: none;\r\n   }\r\n/*- /Box Header */\r\n\r\n/*- Box Content */\r\n.boxContent \r\n   {\r\n     padding-left: 0;\r\n     text-align: left;\r\n  }\r\n\r\n#boxContent p \r\n   {\r\n     margin: 0 0 0 0;\r\n     padding-bottom: 0.2em;\r\n  }\r\n\r\n/*- /Box Content */\r\n\r\n/*- /Box */\r\n\r\n/*- /Boxes */\r\n    \r\n/*]]>*/', 0, '2007-07-14 18:44:00', '2009-07-12 18:49:57'),
(2, 1, 'Default Typography', 'default-typography', '* {\r\n    font-size:12px;\r\n    font-family: Arial, Helvetica, sans-serif;\r\n}\r\na {\r\ntext-decoration:none;\r\n}\r\nh1 a {\r\ncolor:#000000;\r\nfont-size:24px;\r\n}\r\nh2 {\r\nfont-size:16px;\r\n}\r\np {\r\nfont-size:12px;\r\nline-height:15px;\r\nmargin-bottom:20px;\r\n}\r\n#footer a {\r\nfont-size:11px;\r\n}\r\na.remove {\r\nfont-weight:bold;\r\ncolor:FF0000;\r\n}', 0, '2007-07-24 14:15:32', '2007-08-02 13:47:12'),
(3, 1, 'Default Product Details', 'default-product-details', '#product_details_left {\r\n	float:left;\r\n	width:70%;\r\n}\r\n#product_details_right {\r\n	float:right;\r\n	width:30%;\r\n}\r\n.product_price {\r\n	text-align:center;\r\n	font-weight:bold;\r\n	font-size:16px;\r\n	margin:10px auto;\r\n}\r\n.content_images {\r\n	text-align:center;\r\n	list-style-type:none;\r\n}\r\n.product_quantity {\r\n	width:25px;\r\n	font-weight:bold;\r\n	text-align:center;\r\n}', 0, '2007-07-30 16:28:26', '2007-08-15 15:09:34'),
(4, 1, 'Default Checkout', 'default-checkout', '/* Element Styling */\r\n.css_form hr,\r\n#checkout hr {\r\n	margin:10px 0;\r\n	display:none;\r\n}\r\n.css_form div,\r\n#checkout div {\r\n	padding:15px;\r\n	background:#E5ECF2;\r\n	margin-bottom:25px;	\r\n}\r\n.css_form div div,\r\n#checkout div div {\r\n	padding:0;\r\n	margin-bottom:10px;\r\n	background-color:transparent;\r\n}\r\n/* End Element Styling */\r\n\r\n\r\n/* Form Styling */\r\n.css_form label,\r\n#checkout label {\r\n	display:block;\r\n	float:left;\r\n	width:150px;\r\n}\r\n.css_form input,\r\n#checkout input,\r\n.css_form textarea,\r\n#checkout textarea {\r\n	width:180px;\r\n}	\r\n#checkout #payment_method label,\r\n#checkout #shipping_method label {\r\n	display:inline;\r\n	float:none;\r\n	width:auto;\r\n}\r\n#checkout #payment_method input,\r\n#checkout #shipping_method input {\r\n	width:auto;\r\n}\r\noption {\r\n	padding:0pt 1em 0pt 4px;\r\n}\r\n/* End Form Styling */', 0, '2007-08-10 11:07:11', '2007-08-13 15:35:53');

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
(1, 1, 'Non-Taxable', '2007-08-03 20:39:02', '2007-08-06 10:03:37'),
(2, 0, 'United States - VA Sales Tax', '2007-08-05 20:18:46', '2007-08-06 10:03:52');

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
(1, 0, 0, 1, 'Default Theme', '', '2007-07-26 16:02:41', '2007-09-12 17:46:19'),
(2, 1, 1, 0, 'Layout', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />\r\n<meta http-equiv="Content-Style-Type" content="text/css" />\r\n<meta name="robots" content="index,follow" />\r\n	{* This tag links all attached stylesheets to the current template *}\r\n	{* You can link more stylesheets to this theme by clicking on the small css icon. *}\r\n	{stylesheet}\r\n\r\n	{* Outputs the global metadata found in Configuration => Store Settings *}\r\n	{metadata}\r\n<title>\r\n	{* site_name: Outputs the site name found in Configuration => Store Settings *}\r\n	{* content_name: Outputs the name of the current content page *}\r\n	{site_name} - {page_name}\r\n</title>\r\n</head>\r\n<body>\r\n\r\n<!-- Container -->\r\n<div id="container">\r\n\r\n\r\n<!-- Header -->\r\n<div id="header">\r\n<a href="/"><img src="/img/logo.png" alt="{site_name}" /></a>\r\n</div>\r\n\r\n<!-- /Header -->\r\n\r\n<div id="menu">\r\n{content_listing template=\'information-links\' parent=\'44\'}\r\n</div>\r\n\r\n<!-- Navigation -->\r\n<div id="navigation">\r\n{admin_area_link}\r\n</div>\r\n\r\n<!-- /Navigation -->\r\n\r\n<!-- Main Content -->\r\n<div id="wrapper">\r\n\r\n<div id="content">\r\n\r\n{admin_edit_link}\r\n<h2>{page_name}</h2>\r\n{content}\r\n{admin_edit_link}\r\n\r\n</div>\r\n\r\n</div>\r\n\r\n<!-- /Main Content -->\r\n\r\n<!-- Left Column -->\r\n<div id="left">\r\n\r\n\r\n{content_listing template=\'vertical-menu\' parent=\'0\' type=\'product,category\'}\r\n\r\n</div>\r\n\r\n<!-- /Left Column -->\r\n\r\n<!-- Right Column -->\r\n<div id="right">\r\n\r\n\r\n{shopping_cart template=\'cart-content-box\'}\r\n{language_box template=\'language-box\'}\r\n{currency_box template=\'currency-box\'}\r\n\r\n</div>\r\n\r\n<!-- /Right Column -->\r\n\r\n<!-- Footer -->\r\n<div id="footer">\r\n<p>{global_content alias=\'footer\'}</p>\r\n</div>\r\n\r\n<!-- /Footer -->\r\n\r\n</div>\r\n<!-- /Container -->\r\n\r\n</body>\r\n</html>', '2007-07-26 16:02:41', '2009-07-12 18:50:45'),
(3, 1, 2, 0, 'Content Page', '{description}\r\n', '2007-07-26 16:02:41', '2007-07-29 21:37:54'),
(4, 1, 3, 0, 'Product Info', '<div id="product_details_left">\r\n	{description}\r\n</div>\r\n<div id="product_details_right">\r\n	<div class="product_images">{content_images number=''1''}</div>\r\n	{product_form}\r\n		<div class="product_price">{product_quantity} @ {product_price}</div>\r\n		<div class="add_to_cart">{purchase_button id=$content_id}</div>\r\n	{/product_form}\r\n	{module alias=''reviews'' action=''link''}\r\n</div>\r\n<div style="clear:both;"></div>', '2007-07-26 16:02:41', '2007-08-20 09:29:00'),
(5, 1, 4, 0, 'Category Info', '{description}\r\n\r\n{if $sub_count.categories > 0}\r\n	<h3>{lang}sub-category-list{/lang}</h3>\r\n	<div class="content_listing">\r\n		{content_listing  parent=$content_id type=''category''}\r\n	</div>\r\n{/if}\r\n\r\n{if $sub_count.products > 0}\r\n	<h3>{lang}sub-product-list{/lang}</h3>\r\n	<div class="content_listing">\r\n		{content_listing parent=$content_id type=''product''}\r\n	</div>\r\n{/if}', '2007-07-26 16:02:41', '2007-08-30 14:49:18');

DROP TABLE IF EXISTS templates_stylesheets;
CREATE TABLE `templates_stylesheets` (
  `template_id` int(10) unsigned NOT NULL default '0',
  `stylesheet_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`template_id`,`stylesheet_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `templates_stylesheets` (`template_id`, `stylesheet_id`) VALUES 
(1, 1),
(1, 2),
(1, 3),
(1, 4);

DROP TABLE IF EXISTS template_types;
CREATE TABLE `template_types` (
  `id` int(10) NOT NULL auto_increment,
  `name` varchar(50) collate utf8_unicode_ci NOT NULL,
  `default_template` text collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `template_types` (`id`, `name`, `default_template`) VALUES 
(1, 'Layout', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml">\r\n<head>\r\n	{stylesheet}\r\n	{metadata}\r\n<title>\r\n	{site_name} - {page_name}\r\n</title>\r\n<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />\r\n</head>\r\n<body>\r\n	<div id="layout">\r\n		<div id="header">\r\n			<h1><a href="/">{site_name}</a></h1>\r\n		</div>\r\n		<div id="navigation"> </div>\r\n		<div id="left_sidebar">\r\n			 {content_listing template=''vertical-menu'' parent=''0'' type=''product,category''}\r\n		</div>\r\n		<div id="content">\r\n			{admin_edit_link}\r\n			<div id="inner-content">\r\n				<h2>{page_name}</h2>\r\n				{content}\r\n			</div>\r\n			{admin_edit_link}\r\n		</div>\r\n		<div id="right_sidebar">\r\n			{shopping_cart template=''cart-content-box''}\r\n			{language_box}\r\n			{currency_box}\r\n		</div>\r\n		<div class="clearb"></div>	\r\n		<div id="footer">\r\n			{content_listing template=''information-links'' parent=''44''}\r\n		</div>\r\n		<div id="powered_by">\r\n			{global_content alias=''footer''}\r\n		</div>\r\n	</div>\r\n</body>\r\n</html>'),
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
(1, 'admin', 'vam@test.com', '5f4dcc3b5aa765d61d8327deb882cf99', '0000-00-00 00:00:00', '2007-07-23 15:34:53');

DROP TABLE IF EXISTS user_prefs;
CREATE TABLE `user_prefs` (
  `id` int(10) NOT NULL auto_increment,
  `user_id` int(10) NOT NULL,
  `name` varchar(50) collate utf8_unicode_ci NOT NULL,
  `value` text collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `user_prefs` (`id`, `user_id`, `name`, `value`) VALUES 
(1, 1, 'language', 'eng');

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
(1, 'User Agent', 'user-agent', 'echo $_SERVER[''HTTP_USER_AGENT''];', '2007-07-25 09:50:24', '2007-07-27 18:08:55');
