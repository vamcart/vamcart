<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
class SitemapsController extends AppController {
	public $name = 'Sitemaps';
	public $uses = null;
	public $helpers = array('Time');
	public $components = array('RequestHandler');

	public function index() 
	{
		$this->redirect('/google_sitemap/');
	}

	public function google()
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

	public function yandex()
	{

		global $content;
		$params = array();

		global $config;

		// Load some necessary components & models
		App::import('Model', 'Content');
		$Content =& new Content();
		$Content->unbindAll();

		$Content->bindModel(array(
			'hasOne' => array(
				'ContentDescription' => array(
					'className' => 'ContentDescription',
					'conditions' => 'language_id = '.$_SESSION['Customer']['language_id']
				)
			)
		));

		$Content->bindModel(array(
			'belongsTo' => array(
				'ContentType' => array(
					'className' => 'ContentType'
				)
			)
		));

		$Content->bindModel(array(
			'hasOne' => array(
				'ContentImage' => array(
					'className' => 'ContentImage',
					'conditions' => array(
						'ContentImage.order' => '1'
					)
				)
			)
		));

		$Content->bindModel(array(
			'hasOne' => array(
				'ContentProduct' => array(
					'className' => 'ContentProduct'
				)
			)
		));

		$allowed_types = array('category', 'product');

		$content_list_data_conditions = array(
			'Content.yml_export' => '1'
		);

		$Content->recursive = 2;

		$content_list_data = $Content->find('all', array(
			'conditions' => $content_list_data_conditions,
			'order' => array(
				'Content.order ASC'
			)
		));

		// Loop through the content list and create a new array with only what the template needs
		$content_list_categories = array();
		$content_list_products = array();
		$count_categories = 0;
		$count_products = 0;

		foreach($content_list_data as $raw_data) {

			if (in_array(strtolower($raw_data['ContentType']['name']), $allowed_types)) {
				if ($raw_data['ContentType']['name'] == 'category') {
					$content_list_categories[$count_categories]['id'] = $raw_data['Content']['id'];
					$content_list_categories[$count_categories]['parentId'] = $raw_data['Content']['parent_id'];
					$content_list_categories[$count_categories]['name'] = $raw_data['ContentDescription']['name'];
					$count_categories++;
				} elseif($raw_data['ContentType']['name'] == 'product') {
					$content_list_products[$count_products]['id']     = $raw_data['Content']['id'];
					$content_list_products[$count_products]['parentId'] = $raw_data['Content']['parent_id'];
					$content_list_products[$count_products]['url']    = BASE . '/' . $raw_data['ContentType']['name'] . '/' . $raw_data['Content']['alias'] . $config['URL_EXTENSION'];
					$content_list_products[$count_products]['price'] = $raw_data['ContentProduct']['price'];
					$content_list_products[$count_products]['name'] = $raw_data['ContentDescription']['name'];
					$content_list_products[$count_products]['description'] = strip_tags($raw_data['ContentDescription']['description']);

					if ($raw_data['ContentImage']['image'] != "") {
						$image_url = 'content/' . $raw_data['Content']['id'] . '/' . $raw_data['ContentImage']['image'];
					} else {
						$image_url = 'noimage.png';
					}

					if ($config['GD_LIBRARY'] == 0) {
						$content_list_products[$count_products]['image'] =  BASE . '/img/' . $image_url;
					} else {
						$content_list_products[$count_products]['image'] = BASE . '/images/thumb?src=/' . $image_url . '&w=' . $config['THUMBNAIL_SIZE'];
					}

					$count_products++;
				}
			}
		}

		App::import('Model', 'Currency');
		$Currency = new Currency();

		$currenncies_data = $Currency->find('all', array(
			'conditions' => array(
				'Currency.active' => '1'
			)
		));

		$currencies = array();
		$count_currencies = 0;
		$default_currency = '';

		if (sizeof($currenncies_data) > 0) {
			foreach($currenncies_data as $raw_data) {
				$currencies[$count_currencies] = array();
				$currencies[$count_currencies]['id'] = $raw_data['Currency']['code'];
				$currencies[$count_currencies]['rate'] = $raw_data['Currency']['value'];

				if (1 == $raw_data['Currency']['default']) {
					$default_currency = $raw_data['Currency']['code'];
				}

				$count_currencies++;
			}
		}

		$this->set('currencies', $currencies);
		$this->set('default_currency', $default_currency);
		$this->set('sitename', $config['SITE_NAME']);
		$this->set('categories', $content_list_categories);
		$this->set('products', $content_list_products);

		$this->layout = 'default';
		Configure::write('debug', 0);
	}

}
?>
