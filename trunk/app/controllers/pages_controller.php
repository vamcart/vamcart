<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

class PagesController extends AppController {
	var $components = array('ConfigurationBase', 'ContentBase', 'Smarty', 'Gzip.Gzip');
	var $uses = null;
	var $autoLayout = false;
	var $autoRender = false;
	var $helpers = null;
	var $layout = null;

	function beforeFilter()
	{
		// This redirects the user to the install script if the config.php filesize is empty.
		if ($this->action == 'index') {
			$configfilesize = filesize(ROOT . DS . '/config.php');
			if(empty($configfilesize)) {
				$this->redirect('/install/');
				die();
			}
		}

		// Call the beforeFilter in the app_controller
		parent::beforeFilter();

	}

	function getAliasFromParams ($params)
	{
		global $config;

		if (!isset($params['content_alias'])) {
			$content_alias = "";
		} else {
			$content_alias = substr($params['content_alias'],0,(strlen($params['content_alias']) - strlen($config['URL_EXTENSION'])));
		}

		return $content_alias;
	}

	function index()
	{
		global $content;
		global $config;

		App::import('Model', 'Content');
		$this->Content =& new Content();

		$alias = $this->getAliasFromParams($this->params);

		// Pull the content out of cache or generate it if it doesn't exist
		// Cache is based on language_id and alias of the page.
		$cache_name = 'vam_content_' . $this->Session->read('Customer.language_id') . '_' . $alias;
		$content = Cache::read($cache_name);

		if($content === false)
		{
			$content = $this->ContentBase->get_content_information($alias);
			$content_description = $this->ContentBase->get_content_description($content['Content']['id']);
			$content['ContentDescription'] = $content_description['ContentDescription'];

			$specific_model = $content['ContentType']['type'];
			$specific_content = $this->Content->$specific_model->find(array('content_id' => $content['Content']['id']));
			//$content[$specific_model] = $specific_content[$specific_model];
			foreach($specific_content as $key=>$value) {
				$content[$key] = $value;
			}

			Cache::write($cache_name, $content);

			// Update content viewed
			$content['Content']['viewed'] = $content['Content']['viewed'] + 1; 
			$this->Content->save($content);
		}

		/*
		$this->paginate = array(
			'conditions' => array('Content.parent_id' => $content['Content']['id'], 'ContentType.name' => 'product'),
			'limit' => 3
		);

		$data = $this->paginate('Content');

		$this->set('data', $data);

                 */


		// Get the template information.  
		//Layout template cache is generated by the content_id appended to vam_layout_template_.
		$cache_name = 'vam_layout_template_' . $content['Content']['id'];
		$template = Cache::read($cache_name);
		if ($template === false) {
			$template = $this->Content->Template->find(array('template_type_id' => '1', 'parent_id' => $content['Template']['id']));
			Cache::write($cache_name, $template);
		}
		// Save cache based on content_id for template_vars.
		$cache_name = 'vam_template_vars_' . $content['Content']['id'];
		$template_vars = Cache::read($cache_name);

		if (!isset($this->params['page'])) {
			$this->params['page'] = 1;
		}

		if ($template_vars === false) {
			$template_vars = array(
				'content_id' => $content['Content']['id'],
				'content_alias' => $content['Content']['alias'],
				'parent_id' => $content['Content']['parent_id'],
				'sub_count' => array(
					'all_content' => $this->Content->find('count', array('conditions' => array('Content.parent_id' => $content['Content']['id'], 'Content.active' => 1))),
					'categories' => $this->Content->find('count', array('conditions' => array('Content.parent_id' => $content['Content']['id'], 'ContentType.name' => 'category'))),
					'products' => $this->Content->find('count', array('conditions' => array('Content.parent_id' => $content['Content']['id'], 'Content.active' => 1, 'ContentType.name' => 'product'))),
					'downloadables' => $this->Content->find('count', array('conditions' => array('Content.parent_id' => $content['Content']['id'], 'Content.active' => 1, 'ContentType.name' => 'downloadable'))),
					'pages' => $this->Content->find('count', array('conditions' => array('Content.parent_id' => $content['Content']['id'], 'Content.active' => 1, 'ContentType.name' => 'page'))),
					'news' => $this->Content->find('count', array('conditions' => array('Content.parent_id' => $content['Content']['id'], 'Content.active' => 1, 'ContentType.name' => 'news'))),
					'article' => $this->Content->find('count', array('conditions' => array('Content.parent_id' => $content['Content']['id'], 'Content.active' => 1, 'ContentType.name' => 'article'))),
					'pages' => $this->Content->find('count', array('conditions' => array('Content.parent_id' => $content['Content']['id'], 'Content.active' => 1, 'OR' => array('ContentType.name' => 'link'))))
				),
				'show_in_menu' => $content['Content']['show_in_menu'],
				'created' => $content['Content']['created'],
				'modified' => $content['Content']['modified'],
				'page' => $this->params['page'],
				'ajax_enable' => $config['AJAX_ENABLE'],
			);

			Cache::write($cache_name, $template_vars);
		}
		echo '<!-- Powered by: VamCart (http://vamcart.com) -->' . "\n";
		$this->Smarty->display($template['Template']['template'], $template_vars);
		die();
	}
}
?>
