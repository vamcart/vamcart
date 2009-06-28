DROP TABLE IF EXISTS pages;
CREATE TABLE pages (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(50),
    body TEXT,
    created DATETIME DEFAULT NULL,
    modified DATETIME DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS page_translations;
CREATE TABLE `page_translations` (
  `id` int(10) NOT NULL auto_increment,
  `locale` varchar(6) NOT NULL default '',
  `model` varchar(255) NOT NULL default '',
  `foreign_key` int(10) NOT NULL default '0',
  `field` varchar(255) NOT NULL default '',
  `content` text,
  PRIMARY KEY  (`id`),
  KEY `locale` (`locale`),
  KEY `model` (`model`),
  KEY `row_id` (`foreign_key`),
  KEY `field` (`field`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS languages;
CREATE TABLE languages (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50),
    code VARCHAR(50),
    created DATETIME DEFAULT NULL,
    modified DATETIME DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

INSERT INTO `languages` VALUES (1, 'English', 'eng', now(), now());
INSERT INTO `languages` VALUES (2, 'Русский', 'rus', now(), now());

DROP TABLE IF EXISTS configurations;
CREATE TABLE configurations (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    configuration_key VARCHAR(255),
    configuration_value VARCHAR(255),
    created DATETIME DEFAULT NULL,
    modified DATETIME DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

INSERT INTO `configurations` (configuration_key, configuration_value, created, modified) VALUES ('store.name', 'VaM Shop', now(), now());
INSERT INTO `configurations` (configuration_key, configuration_value, created, modified) VALUES ('language', 'rus', now(), now());
INSERT INTO `configurations` (configuration_key, configuration_value, created, modified) VALUES ('layout.theme', 'example', now(), now());
INSERT INTO `configurations` (configuration_key, configuration_value, created, modified) VALUES ('layout.template', 'example', now(), now());

