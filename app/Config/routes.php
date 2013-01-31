<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
 
 /**
 * Load all plugin routes.  See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
 Router::parseExtensions('rss','xml');

	Router::connect('/', array('controller' => 'pages', 'action' => 'index'));
	Router::connect('/pages/*', array('controller' => 'pages'));

	Router::connect('/product/:content_alias', array('controller' => 'pages', 'action' => 'index'));
	Router::connect('/downloadable/:content_alias', array('controller' => 'pages', 'action' => 'index'));
	Router::connect('/download/:order_id/:content_id/:download_key', array('controller' => 'download', 'action' => 'get'));
	Router::connect('/category/:content_alias', array('controller' => 'pages', 'action' => 'index'));
	Router::connect('/category/:content_alias/page/:page', array('controller' => 'pages', 'action' => 'index'));
	Router::connect('/page/:content_alias', array('controller' => 'pages', 'action' => 'index'));
	Router::connect('/news/:content_alias', array('controller' => 'pages', 'action' => 'index'));
	Router::connect('/article/:content_alias', array('controller' => 'pages', 'action' => 'index'));
	Router::connect('/customer/:content_alias', array('controller' => 'pages', 'action' => 'index'));
	Router::connect('/google_sitemap', array('controller' => 'sitemaps', 'action' => 'google', 'ext' => 'xml'));
	Router::connect('/yandex_market', array('controller' => 'sitemaps', 'action' => 'yandex', 'ext' => 'xml'));

	Router::connect('/tests', array('controller' => 'tests', 'action' => 'index'));
	
/**
 * Load all plugin routes.  See the CakePlugin documentation on 
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';
