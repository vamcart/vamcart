<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

class SitemapsController extends AppController {
	var $name = 'Sitemaps';
	var $uses = null;
	var $helpers = array('Time');
	var $components = array('RequestHandler');

	function index() 
	{
		$this->redirect('/google_sitemap/');
	}

	function google()
	{
		global $content;
		$params = array();

		global $config;

		// Load some necessary components & models
		App::import('Model', 'Content');
		$Content =& new Content();
		$Content->unbindAll();

		$Content->bindModel(array(
			'belongsTo' => array(
				'ContentType' => array(
					'className' => 'ContentType'
				)
			)
		));

		$allowed_types = array('category', 'product', 'news', 'article');

		$content_list_data_conditions = array(
			'Content.active' => '1',
			'Content.show_in_menu' => '1'
		);

		$Content->recursive = 2;

		$content_list_data = $Content->find('all', array(
			'conditions' => $content_list_data_conditions,
			'order' => array(
				'Content.order ASC'
			)
		));

		// Loop through the content list and create a new array with only what the template needs
		$content_list = array();
		$count = 0;

		foreach($content_list_data as $raw_data) {

			if (in_array(strtolower($raw_data['ContentType']['name']), $allowed_types)) {
				if ($raw_data['ContentType']['name'] == 'link') {
					$content_list[$count]['url'] = $raw_data['ContentLink']['url'];
				} else {
					$content_list[$count]['url']    = BASE . '/' . $raw_data['ContentType']['name'] . '/' . $raw_data['Content']['alias'] . $config['URL_EXTENSION'];
				}

				switch ($raw_data['ContentType']['name']) {
					case 'category':
						$content_list[$count]['priority'] = '1.0';
						$content_list[$count]['changefreq'] = 'weekly';
						break;
					case 'product':
						$content_list[$count]['priority'] = '0.5';
						$content_list[$count]['changefreq'] = 'daily';
						break;
					default:
						$content_list[$count]['priority'] = '0.5';
						$content_list[$count]['changefreq'] = 'daily';
						break;
				}

				$content_list[$count]['lastmod'] = $raw_data['Content']['modified'];

				$count ++;
			}
		}

		$this->set('content_list', $content_list);
		$this->layout = 'default';
		Configure::write('debug', 0);
	}
}
?>
