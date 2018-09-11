<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
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
		$Content = new Content();
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

		$Content->recursive = 1;

		$content_list_data = $Content->find('all', array(
			'fields' => array('Content.id', 'Content.alias','Content.content_type_id', 'Content.modified', 'ContentType.name'),
			'conditions' => $content_list_data_conditions,
		));

		// Loop through the content list and create a new array with only what the template needs
		$content_list = array();
		$count = 0;

		foreach($content_list_data as $raw_data) {

			if (in_array(strtolower($raw_data['ContentType']['name']), $allowed_types)) {
				if ($raw_data['ContentType']['name'] == 'link') {
					$content_list[$count]['url'] = $raw_data['ContentLink']['url'];
				} else {
					$content_list[$count]['url']    = '/' . $raw_data['ContentType']['name'] . '/' . $raw_data['Content']['alias'] . $config['URL_EXTENSION'];
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
	}

	public function yandex_turbo()
	{
		global $content;
		$params = array();

		global $config;

		// Load some necessary components & models
		App::import('Model', 'Content');
		$Content = new Content();
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

		$Content->bindModel(array(
			'hasOne' => array(
				'ContentDownloadable' => array(
					'className' => 'ContentDownloadable'
				)
			)
		));


		//$allowed_types = array('category', 'product', 'downloadable');
		$allowed_types = array('product');
		
		$content_list_data_conditions = array(
			'Content.active' => '1'
		);


		$Content->recursive = 1;

		$content_list_data = $Content->find('all', array(
			'conditions' => $content_list_data_conditions,
		));

		// Loop through the content list and create a new array with only what the template needs
		$content_list_categories = array();
		$content_list_products = array();
		$count_categories = 0;
		$count_products = 0;

 		$ContentBase = new ContentBaseComponent(new ComponentCollection());
	
		foreach($content_list_data as $raw_data) {

			if (in_array(strtolower($raw_data['ContentType']['name']), $allowed_types)) {
				if ($raw_data['ContentType']['name'] == 'category') {
					$content_list_categories[$count_categories]['id'] = $raw_data['Content']['id'];
					$content_list_categories[$count_categories]['parentId'] = $raw_data['Content']['parent_id'];
					$content_list_categories[$count_categories]['name'] = $raw_data['ContentDescription']['name'];
					$count_categories++;
				} elseif($raw_data['ContentType']['name'] == 'product' or $raw_data['ContentType']['name'] == 'downloadable') {
					$content_list_products[$count_products]['id']     = $raw_data['Content']['id'];
					$content_list_products[$count_products]['parentId'] = $raw_data['Content']['parent_id'];
					$content_list_products[$count_products]['url']    = '/' . $raw_data['ContentType']['name'] . '/' . $raw_data['Content']['alias'] . $config['URL_EXTENSION'];
					$content_list_products[$count_products]['price'] = ($raw_data['Content']['content_type_id'] == 7) ? $raw_data['ContentDownloadable']['price'] . ' ' . $this->Session->read('Customer.currency_symbol_left') : $raw_data['ContentProduct']['price'] . ' ' . $this->Session->read('Customer.currency_symbol_right');
					$content_list_products[$count_products]['stock'] = $raw_data['ContentProduct']['stock'];
					$content_list_products[$count_products]['name'] = $raw_data['ContentDescription']['name'];
					$content_list_products[$count_products]['description'] = strip_tags($raw_data['ContentDescription']['description']);
					$content_list_products[$count_products]['short_description'] = strip_tags($raw_data['ContentDescription']['short_description']);

					$content_list_products[$count_products]['rating']	= $ContentBase->getReviewsInfo($raw_data['Content']['id'], 'average_rating');	
					$content_list_products[$count_products]['max_rating']	= $ContentBase->getReviewsInfo($raw_data['Content']['id'], 'max_rating');	
					$content_list_products[$count_products]['star_rating']	= $ContentBase->getReviewsInfo($raw_data['Content']['id'], 'star_rating');	
					$content_list_products[$count_products]['reviews']	= $ContentBase->getReviewsInfo($raw_data['Content']['id'], 'reviews_total');	

					// Content Image
					
					if($raw_data['ContentImage']['image'] != "") {
						$image_url = $raw_data['Content']['id'] . '/' . $raw_data['ContentImage']['image'];
						$image_path = BASE . '/img/content/' . $raw_data['ContentImage']['image'];
						$thumb_name = substr_replace($raw_data['ContentImage']['image'] , '', strrpos($raw_data['ContentImage']['image'] , '.')).'-'.$config['THUMBNAIL_SIZE'].'.png';	
						$thumb_path = IMAGES . 'content/' . $thumb_name;
						$thumb_url = BASE . '/img/content/' . $thumb_name;
		
							if(file_exists($thumb_path) && is_file($thumb_path)) {
								list($width, $height, $type, $attr) = getimagesize($thumb_path);
								$content_list_products[$count_products]['image'] =  $thumb_url;
								$content_list_products[$count_products]['image_original'] =  $image_path;
							} else {
								$content_list_products[$count_products]['image'] = BASE . '/images/thumb/' . $image_url;
								$content_list_products[$count_products]['image_original'] =  $image_path;
							}
		
					} else { 
		
						$image_url = 'noimage.png';
						$thumb_name = 'noimage-'.$config['THUMBNAIL_SIZE'].'.png';	
						$thumb_path = IMAGES . 'content/' . $thumb_name;
						$thumb_url = BASE . '/img/content/' . $thumb_name;
		
							if(file_exists($thumb_path) && is_file($thumb_path)) {
								list($width, $height, $type, $attr) = getimagesize($thumb_path);
								$content_list_products[$count_products]['image'] =  $thumb_url;
							} else {
								$content_list_products[$count_products]['image'] = BASE . '/images/thumb/' . $image_url;
							}
		
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
		$this->set('telephone', $config['TELEPHONE']);
		$this->set('categories', $content_list_categories);
		$this->set('products', $content_list_products);

		$this->layout = 'default';
	}
	
	public function yandex()
	{

		global $content;
		$params = array();

		global $config;

		// Load some necessary components & models
		App::import('Model', 'Content');
		$Content = new Content();
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

		$Content->bindModel(array(
			'hasOne' => array(
				'ContentDownloadable' => array(
					'className' => 'ContentDownloadable'
				)
			)
		));


		$allowed_types = array('category', 'product', 'downloadable');

		$content_list_data_conditions = array(
			'Content.yml_export' => '1'
		);

		$Content->recursive = 1;

		$content_list_data = $Content->find('all', array(
			'conditions' => $content_list_data_conditions,
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
				} elseif($raw_data['ContentType']['name'] == 'product' or $raw_data['ContentType']['name'] == 'downloadable') {
					$content_list_products[$count_products]['id']     = $raw_data['Content']['id'];
					$content_list_products[$count_products]['parentId'] = $raw_data['Content']['parent_id'];
					$content_list_products[$count_products]['url']    = '/' . $raw_data['ContentType']['name'] . '/' . $raw_data['Content']['alias'] . $config['URL_EXTENSION'];
					$content_list_products[$count_products]['price'] = ($raw_data['Content']['content_type_id'] == 7) ? $raw_data['ContentDownloadable']['price'] . ' ' . $this->Session->read('Customer.currency_code') : $raw_data['ContentProduct']['price'] . ' ' . $this->Session->read('Customer.currency_code');
					$content_list_products[$count_products]['stock'] = $raw_data['ContentProduct']['stock'];
					$content_list_products[$count_products]['name'] = $raw_data['ContentDescription']['name'];
					$content_list_products[$count_products]['description'] = strip_tags(htmlentities($raw_data['ContentDescription']['description']));
					$content_list_products[$count_products]['short_description'] = strip_tags(htmlentities($raw_data['ContentDescription']['short_description']));

					// Content Image
					
					if($raw_data['ContentImage']['image'] != "") {
						$image_url = $raw_data['Content']['id'] . '/' . $raw_data['ContentImage']['image'];
						$image_path = BASE . '/img/content/' . $raw_data['ContentImage']['image'];
						$thumb_name = substr_replace($raw_data['ContentImage']['image'] , '', strrpos($raw_data['ContentImage']['image'] , '.')).'-'.$config['THUMBNAIL_SIZE'].'.png';	
						$thumb_path = IMAGES . 'content/' . $thumb_name;
						$thumb_url = BASE . '/img/content/' . $thumb_name;
		
							if(file_exists($thumb_path) && is_file($thumb_path)) {
								list($width, $height, $type, $attr) = getimagesize($thumb_path);
								$content_list_products[$count_products]['image'] =  $thumb_url;
								$content_list_products[$count_products]['image_original'] =  $image_path;
							} else {
								$content_list_products[$count_products]['image'] = BASE . '/images/thumb/' . $image_url;
								$content_list_products[$count_products]['image_original'] =  $image_path;
							}
		
					} else { 
		
						$image_url = 'noimage.png';
						$thumb_name = 'noimage-'.$config['THUMBNAIL_SIZE'].'.png';	
						$thumb_path = IMAGES . 'content/' . $thumb_name;
						$thumb_url = BASE . '/img/content/' . $thumb_name;
		
							if(file_exists($thumb_path) && is_file($thumb_path)) {
								list($width, $height, $type, $attr) = getimagesize($thumb_path);
								$content_list_products[$count_products]['image'] =  $thumb_url;
							} else {
								$content_list_products[$count_products]['image'] = BASE . '/images/thumb/' . $image_url;
							}
		
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
	}

	public function google_shopping()
	{

		global $content;
		$params = array();

		global $config;

		// Load some necessary components & models

		App::import('Model', 'ContentCategory');
		$ContentCategory = new ContentCategory();

		App::import('Model', 'Content');
		$Content = new Content();
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

		$Content->bindModel(array(
			'hasOne' => array(
				'ContentDownloadable' => array(
					'className' => 'ContentDownloadable'
				)
			)
		));


		$allowed_types = array('category', 'product', 'downloadable');

		$content_list_data_conditions = array(
			'Content.yml_export' => '1'
		);

		$Content->recursive = 1;

		$content_list_data = $Content->find('all', array(
			'conditions' => $content_list_data_conditions,
		));

		// Loop through the content list and create a new array with only what the template needs
		$content_list_categories = array();
		$content_list_products = array();
		$count_categories = 0;
		$count_products = 0;

		foreach($content_list_data as $raw_data) {

				$google_shopping_category_id = 0;
				if ($raw_data['ContentType']['name'] == 'product') {
				$category_id = $ContentCategory->find('first', array('conditions' => array('ContentCategory.content_id' => $raw_data['Content']['parent_id'])));
				$google_shopping_category_id = $category_id['ContentCategory']['google_product_category_id'];
				}

			if (in_array(strtolower($raw_data['ContentType']['name']), $allowed_types)) {
				if ($raw_data['ContentType']['name'] == 'category') {
					$content_list_categories[$count_categories]['id'] = $raw_data['Content']['id'];
					$content_list_categories[$count_categories]['parentId'] = $raw_data['Content']['parent_id'];
					$content_list_categories[$count_categories]['name'] = $raw_data['ContentDescription']['name'];
					$count_categories++;
				} elseif($raw_data['ContentType']['name'] == 'product' or $raw_data['ContentType']['name'] == 'downloadable') {
					$content_list_products[$count_products]['id']     = $raw_data['Content']['id'];
					$content_list_products[$count_products]['parentId'] = $raw_data['Content']['parent_id'];
					$content_list_products[$count_products]['url']    = '/' . $raw_data['ContentType']['name'] . '/' . $raw_data['Content']['alias'] . $config['URL_EXTENSION'];
					$content_list_products[$count_products]['price'] = ($raw_data['Content']['content_type_id'] == 7) ? $raw_data['ContentDownloadable']['price'] . ' ' . $this->Session->read('Customer.currency_code') : $raw_data['ContentProduct']['price'] . ' ' . $this->Session->read('Customer.currency_code');
					$content_list_products[$count_products]['stock'] = $raw_data['ContentProduct']['stock'];
					$content_list_products[$count_products]['name'] = $raw_data['ContentDescription']['name'];
					$content_list_products[$count_products]['google_shopping_category_id'] = $google_shopping_category_id;
					$content_list_products[$count_products]['description'] = strip_tags(htmlentities($raw_data['ContentDescription']['description']));
					$content_list_products[$count_products]['short_description'] = strip_tags(htmlentities($raw_data['ContentDescription']['short_description']));

					// Content Image
					
					if($raw_data['ContentImage']['image'] != "") {
						$image_url = $raw_data['Content']['id'] . '/' . $raw_data['ContentImage']['image'];
						$image_path = BASE . '/img/content/' . $raw_data['ContentImage']['image'];
						$thumb_name = substr_replace($raw_data['ContentImage']['image'] , '', strrpos($raw_data['ContentImage']['image'] , '.')).'-'.$config['THUMBNAIL_SIZE'].'.png';	
						$thumb_path = IMAGES . 'content/' . $thumb_name;
						$thumb_url = BASE . '/img/content/' . $thumb_name;
		
							if(file_exists($thumb_path) && is_file($thumb_path)) {
								list($width, $height, $type, $attr) = getimagesize($thumb_path);
								$content_list_products[$count_products]['image'] =  $thumb_url;
								$content_list_products[$count_products]['image_original'] =  $image_path;
							} else {
								$content_list_products[$count_products]['image'] = BASE . '/images/thumb/' . $image_url;
								$content_list_products[$count_products]['image_original'] =  $image_path;
							}
		
					} else { 
		
						$image_url = 'noimage.png';
						$thumb_name = 'noimage-'.$config['THUMBNAIL_SIZE'].'.png';	
						$thumb_path = IMAGES . 'content/' . $thumb_name;
						$thumb_url = BASE . '/img/content/' . $thumb_name;
		
							if(file_exists($thumb_path) && is_file($thumb_path)) {
								list($width, $height, $type, $attr) = getimagesize($thumb_path);
								$content_list_products[$count_products]['image'] =  $thumb_url;
							} else {
								$content_list_products[$count_products]['image'] = BASE . '/images/thumb/' . $image_url;
							}
		
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
	}


}
?>
