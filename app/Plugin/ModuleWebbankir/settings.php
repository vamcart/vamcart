<?php
define('WEBBANKIR_API_URL_SETTING', 'https://frame.webbankir.partners');
define('WEBBANKIR_MODULE', 'module_webbankir');
define('MODULE_VERSION_SETTING', '1.0');
define('WEBBANKIR_PAGE_SETTINGS', 'page_settings');

if (!defined('PHP_VERSION_ID')) {
    $version = explode('.', PHP_VERSION);

    define('PHP_VERSION_ID', ($version[0] * 10000 + $version[1] * 100 + $version[2]));
}