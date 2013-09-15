<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
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
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */


/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController {

public $components = array('ConfigurationBase', 'ContentBase', 'Smarty', 'Gzip.Gzip');
	public $uses = null;
	public $autoLayout = false;
	public $autoRender = false;
	public $helpers = null;
	public $layout = null;

	public function beforeFilter()
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

	public function getAliasFromParams ($params)
	{
		global $config;

		if (!isset($params['content_alias'])) {
			$content_alias = "";
		} else {
			$content_alias = substr($params['content_alias'],0,(strlen($params['content_alias']) - strlen($config['URL_EXTENSION'])));
		}

		return $content_alias;
	}

	public function index()
	{
		global $content;
		global $config;

		App::import('Model', 'Content');
		$this->Content = new Content();

		$alias = $this->getAliasFromParams($this->params);
                
/*->***************************************************************/
                global $compare_list;
                $compare_list = $this->Session->read('compare_list.' . $alias);
                if(!isset($compare_list)) $compare_list = array();
                if(isset($this->params['add_alias']))
                {
                    $compare_content = $this->ContentBase->get_content_information($this->params['add_alias']);
                    $compare_list[$this->params['add_alias']] = $compare_content['Content']['id'];
                    //array_push($compare_list,$compare_content['Content']['id']);
                    $this->Session->write('compare_list.' . $alias ,$compare_list);
                    //$this->redirect($_SERVER['HTTP_REFERER']);
                }
                if(isset($this->params['del_alias']))
                {
                    unset($compare_list[$this->params['del_alias']]); 
                    $this->Session->write('compare_list.' . $alias ,$compare_list);
                    //$this->redirect($_SERVER['HTTP_REFERER']);
                }
                if(isset($this->params['compared'])) $is_compared = 1; else $is_compared = null;
                
                global $filter_list;
                $filter_list = $this->Session->read('filter_list.' . $alias);//текущее состояние
                
                if(isset($this->params['filtered']) && $this->params['filtered'] == 'set')
                {
                    App::import('Model', 'Attribute');
                    $Attribute = new Attribute;
                    $filter_data = $Attribute->getFilterFromFormData($this->data);
                    if(!empty($filter_data))
                    {
                        foreach ($filter_data AS $k => $opt_filter)
                        {
                            $filter_list[$k]['type_attr'] = $opt_filter['type_attr'];
                            $filter_list[$k]['value'] = $opt_filter['value'];
                            $filter_list[$k]['is_active'] = $opt_filter['is_active'];
                        }
                        $this->Session->write('filter_list.' . $alias ,$filter_list);//сохраняем состояние для пагинации
                    }
                }
                if(isset($this->params['filtered']) && $this->params['filtered'] == 'set' && isset($this->data['cancelbutton']))
                {
                    $filter_list = array();
                    $this->Session->delete('filter_list.' . $alias);
                }
/***************************************************************<-*/

		// Pull the content out of cache or generate it if it doesn't exist
		// Cache is based on language_id and alias of the page.
		$cache_name = 'vam_content_' . $this->Session->read('Customer.language_id') . '_' . $alias;
		$content = Cache::read($cache_name);

		if($content === false)
		{
			$content = $this->ContentBase->get_content_information($alias);
			$content_description = $this->ContentBase->get_content_description($content['Content']['id']);
			$content_relations = $this->ContentBase->get_content_relations($content['Content']['id']);

			$content['ContentDescription'] = $content_description['ContentDescription'];
			$content['ContentRelations'] = $content_relations;

			$specific_model = $content['ContentType']['type'];
			$specific_content = $this->Content->$specific_model->find('first', array('conditions' => array('content_id' => $content['Content']['id'])));
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
			$template = $this->Content->Template->find('first', array('conditions' => array('template_type_id' => '1', 'parent_id' => $content['Template']['id'])));
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
/*->***************************************************************/                            
                                'is_compared' => $is_compared
/***************************************************************<-*/                                
			);

			Cache::write($cache_name, $template_vars);
		}
		echo '<!-- Powered by: VamCart (http://vamcart.com) -->' . "\n";
		$this->Smarty->display($template['Template']['template'], $template_vars);
		die();
	}
}
