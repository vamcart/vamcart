<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
function smarty_function_search_result($params, $template)
{
	global $config;
	uses('sanitize');
	$clean = new Sanitize();
	$clean->paranoid($_POST);

	App::import('Component', 'Smarty');
	$Smarty =& new SmartyComponent();

	App::import('Component', 'Session');
	$Session =& new SessionComponent();

	if (isset($_POST['keyword']) && !empty($_POST['keyword'])) {

		App::import('Model', 'Content');
		$Content =& new Content();
		$Content->unbindAll();

		$Content->bindModel(array(
			'hasOne' => array(
				'ContentDescription' => array(
					'className' => 'ContentDescription',
					'conditions'   => 'language_id = '.$_SESSION['Customer']['language_id']
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

		$search_conditions = array('AND' => array('ContentType.name' => 'product',
						'OR' => array('ContentDescription.name LIKE' => '%' . $_POST['keyword'] . '%',
							      'ContentDescription.description LIKE' => '%' . $_POST['keyword'] . '%')));

		$content_list_data = $Content->find('all', array('conditions' => $search_conditions, 'recursive' => 2));

		$content_list = array();
		$count = 0;

		foreach($content_list_data AS $raw_data) {
			$content_list[$count]['name']   = $raw_data['ContentDescription']['name'];
			$content_list[$count]['alias']  = $raw_data['Content']['alias'];
			$content_list[$count]['price']  = $raw_data['ContentProduct']['price'];
			$content_list[$count]['stock']  = $raw_data['ContentProduct']['stock'];
			$content_list[$count]['model']  = $raw_data['ContentProduct']['model'];
			$content_list[$count]['weight'] = $raw_data['ContentProduct']['weight'];

			if (isset($raw_data['ContentImage']['image']) && file_exists(IMAGES . 'content/' . $raw_data['Content']['id'] . '/' . $raw_data['ContentImage']['image'])) {
				$content_list[$count]['icon']   = BASE . '/img/content/' . $raw_data['Content']['id'] . '/' . $raw_data['ContentImage']['image'];
			}

			if ($raw_data['ContentImage']['image'] != "") {
				$image_url = 'content/' . $raw_data['Content']['id'] . '/' . $raw_data['ContentImage']['image'];
			} else {
				$image_url = 'noimage.png';
			}

			if ($config['GD_LIBRARY'] == 0) {
				$content_list[$count]['image'] =  BASE . '/img/' . $image_url;
			} else {
				$content_list[$count]['image'] = BASE . '/images/thumb?src=/' . $image_url . '&w=' . $config['THUMBNAIL_SIZE'];
			}

			$content_list[$count]['url']    = BASE . '/' . $raw_data['ContentType']['name'] . '/' . $raw_data['Content']['alias'] . $config['URL_EXTENSION'];
			$count ++;
		}
	} else {
		$content_list = array();
		$count = 0;
	}


	$content_total = $count;
	$vars = $template->smarty->tpl_vars;
	$vars['content_list'] = $content_list;
	$vars['count'] = $count;
	$params['on_page'] = $config['PRODUCTS_PER_PAGE'];
	
	//$vars['page'] = $params['page'];
	$vars['page'] = 1;
	$vars['ext'] = $config['URL_EXTENSION'];
	$vars['pages_number'] = ceil($content_total/$params['on_page']);

	if($config['GD_LIBRARY'] == 0) {
		$vars['thumbnail_width'] = $config['THUMBNAIL_SIZE'];
        }

	$display_template = $Smarty->load_template($params, 'content_listing');
	$Smarty->display($display_template, $vars);

}

function smarty_help_function_search_result() {
}

function smarty_about_function_search_result() {
}

