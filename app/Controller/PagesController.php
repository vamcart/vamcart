<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
class PagesController extends AppController {

public $components = array('ConfigurationBase', 'ContentBase', 'Smarty');
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
                
                global $compare_list;
                $compare_list = $this->Session->read('compare_list.' . $alias);
                if(!isset($compare_list)) $compare_list = array();
                if(isset($this->params['add_alias']))
                {
                    $compare_content = $this->ContentBase->get_content_information($this->params['add_alias']);
                    $compare_list[$this->params['add_alias']] = $compare_content['Content']['id'];
                    $this->Session->write('compare_list.' . $alias ,$compare_list);
                }
                if(isset($this->params['del_alias']))
                {
                    unset($compare_list[$this->params['del_alias']]); 
                    $this->Session->write('compare_list.' . $alias ,$compare_list);
                }
                if(isset($this->params['compared'])) $is_compared = 1; else $is_compared = null;
                

                global $filter_list,$filtered_content,$filtered_attributes;  
                $filter_list = $this->Session->read('filter_list.' . $alias);//текущее состояние фильтра

                // Фильтры через get форму                
                if(isset($this->params->query['data'])) $this->data = $this->params->query['data'];
                                            
                if(isset($this->params['filtered']))
                {
                    if($this->params['filtered'] == 'set'&&!isset($this->data['cancelbutton'])) {
                        $filter_list = $this->Content->Attr->getFilterFromFormData($this->data);
                        if(!empty($filter_list))
                            $this->Session->write('filter_list.' . $alias ,$filter_list);//сохраняем состояние(например для пагинации)
                    } else if($this->params['filtered'] == 'unset'||isset($this->data['cancelbutton']))
                    {                                                
                        $filter_list = $filtered_attributes = $filtered_content = null;
                        $this->Session->delete('filter_list.' . $alias);
                    }        
                }
                $content_filtered_list_data = $this->Content->get_filtered_conditions($filter_list,$alias);
                if (is_array($content_filtered_list_data)) {                  
                $filtered_content = $content_filtered_list_data['content_ids'];
                $filtered_attributes = $content_filtered_list_data['attribute_ids'];
                }                  
                

		// Pull the content out of cache or generate it if it doesn't exist
		// Cache is based on language_id and alias of the page.
		$cache_name = 'vam_content_' . $_SESSION['Customer']['customer_group_id'] . '_' . $this->Session->read('Customer.language_id') . '_' . $this->Session->read('Customer.currency_id') . '_' . $alias;
		$content = Cache::read($cache_name, 'catalog');

		if($content === false or $is_compared == 1)
		{
			$content = $this->ContentBase->get_content_information($alias);                      
			$content_description = $this->ContentBase->get_content_description($content['Content']['id']);
			$content_relations = $this->ContentBase->get_content_relations($content['Content']['id']);

			$content['ContentDescription'] = $content_description['ContentDescription'];
			$content['ContentRelations'] = $content_relations;

			$specific_model = $content['ContentType']['type'];
			$specific_content = $this->Content->$specific_model->find('first', array('conditions' => array('content_id' => $content['Content']['id'])));

			foreach($specific_content as $key=>$value) {
				$content[$key] = $value;
			}

			Cache::write($cache_name, $content, 'catalog');

		}

		// Get the template information.  
		//Layout template cache is generated by the content_id appended to vam_layout_template_.
		$cache_name = 'vam_layout_template_' . $content['Content']['id'];
		$template = Cache::read($cache_name, 'catalog');
		if ($template === false) {
			$template = $this->Content->Template->find('first', array('conditions' => array('template_type_id' => '1', 'parent_id' => $content['Template']['id'])));
			// Minify html                	
			if (Configure::read('debug') == 0) $template['Template']['template'] = str_replace(array("\n","\r","\t"),'',$template['Template']['template']);
			Cache::write($cache_name, $template, 'catalog');
		}

		if (!isset($this->params['page'])) {
			$this->params['page'] = 1;
		}

		global $sort_by;
		if (isset($this->params['order'])) {
			$sort_by = $this->params['order'];
		} else {
			$sort_by = false;
		}

		$this->Session->write('Customer.page', $this->params['page']);

		// Save cache based on content_id for template_vars.
		$cache_name = 'vam_template_vars_' . $content['Content']['id'].(isset($this->params['page'])?'_'.$this->params['page']:'').(isset($sort_by)?'_'.$sort_by:'').$is_compared;
		$template_vars = Cache::read($cache_name, 'catalog');
              
		if ($template_vars === false) {
			$template_vars = array(
				'content_id' => $content['Content']['id'],
				'language' => $this->Session->read('Customer.language'),
				'content_alias' => $content['Content']['alias'],
				'content_type' => $content['ContentType']['name'],
				'parent_id' => $content['Content']['parent_id'],
				'sub_count' => array(
					'all_content' => $this->Content->find('count', array('conditions' => array('Content.parent_id' => $content['Content']['id'], 'Content.active' => 1))),
					'categories' => $this->Content->find('count', array('conditions' => array('Content.parent_id' => $content['Content']['id'], 'ContentType.name' => 'category'))),
					'products' => $this->Content->find('count', array('conditions' => array('Content.parent_id' => $content['Content']['id'], 'Content.active' => 1, 'ContentType.name' => 'product'))),
					'manufacturers' => $this->Content->find('count', array('conditions' => array('Content.parent_id' => $content['Content']['id'], 'ContentType.name' => 'manufacturer'))),
					'manufacturer_products' => $this->Content->find('count', array('conditions' => array('ContentProduct.manufacturer_id' => $content['Content']['id'], 'Content.active' => 1, 'ContentType.name' => 'product'))),
					'downloadables' => $this->Content->find('count', array('conditions' => array('Content.parent_id' => $content['Content']['id'], 'Content.active' => 1, 'ContentType.name' => 'downloadable'))),
					'pages' => $this->Content->find('count', array('conditions' => array('Content.parent_id' => $content['Content']['id'], 'Content.active' => 1, 'ContentType.name' => 'page'))),
					'news' => $this->Content->find('count', array('conditions' => array('Content.parent_id' => $content['Content']['id'], 'Content.active' => 1, 'ContentType.name' => 'news'))),
					'articles' => $this->Content->find('count', array('conditions' => array('Content.parent_id' => $content['Content']['id'], 'Content.active' => 1, 'ContentType.name' => 'article'))),
					'links' => $this->Content->find('count', array('conditions' => array('Content.parent_id' => $content['Content']['id'], 'Content.active' => 1, 'OR' => array('ContentType.name' => 'link'))))
				),
				'show_in_menu' => $content['Content']['show_in_menu'],
				'created' => $content['Content']['created'],
				'modified' => $content['Content']['modified'],
				'stock' => (isset($content['ContentProduct']['stock'])) ? $content['ContentProduct']['stock'] : false,
				'page' => $this->params['page'],
				'current_order' => $sort_by,
				'ajax_enable' => $config['AJAX_ENABLE'],
				'is_compared' => $is_compared
			);

			Cache::write($cache_name, $template_vars, 'catalog');
		}
                
                global $make_attr_product;
                $make_attr_product = null;
                if(isset($this->data['set_attr']))
                {
                    $attrs = $this->data['set_attr'];
                    function v($var){return($var == 1);}
                    $make_attr_product = key(array_filter($attrs,"v"));
                    $this->request->is('ajax');
                    $template_vars['ajax_enable'] = true;
                    $this->Smarty->display('{content}', $template_vars);     
                }
                else 
                {
                    $this->Smarty->display($template['Template']['template'], $template_vars);
                    echo '<!-- Powered by: VamShop (http://vamshop.com) -->' . "\n";
                }
		die();
	}
        
}
