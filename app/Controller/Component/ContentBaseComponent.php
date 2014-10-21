<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

App::uses('Controller/Component', 'SessionComponent');
App::uses('Model', 'Content');
App::uses('Model', 'ContentDescription');

class ContentBaseComponent extends Object
{
    public $components = array('Session','Smarty');

	public function beforeFilter ()
	{
	}
	
	public function initialize(Controller $controller) {
	}
    
	public function startup(Controller $controller) {
	$this->load_models();
	}

	public function shutdown(Controller $controller) {
	}
    
	public function beforeRender(Controller $controller){
	}
	
	public function beforeRedirect(Controller $controller){
	}

	public function load_models ()
	{
		// We're loading the Session component here because the smarty plugin can't yet
		
		$this->Session = new SessionComponent(new ComponentCollection());

		$this->Content = new Content();

		$this->ContentDescription = new ContentDescription();

	}


	/**
	* Returns the ID of the default page
	*
	*/
	public function default_content ()
	{
		$content = $this->Content->find('first', array('conditions' => array('Content.default' => '1')));
		$content_id = $content['Content']['id'];

		return $content_id;
	}


	/**
	* Unbinds all content descriptions.
	* Binds content description with a HasOne association
	*
	* @param int $content_id ID of content page to Get
	* @return  array  Content descriptions
	*/
	public function get_content_description ($content_id = null)
	{
		if ($content_id == null) {
			$content_id = $this->default_content();
		}

		$this->load_models();
		 
		$content_description = $this->ContentDescription->find('first', array('conditions' => array('content_id' => $content_id, 'language_id' => $this->Session->read('Customer.language_id'))));
 
		return $content_description;
	}

	/**
	* Unbinds all content descriptions and retuns the content.
	*
	* @param int $content_id ID of content page to Get
	* @return  array  Content without the descriptions
	*/
	public function get_content_information ($content_alias)
	{
		$this->load_models();

		if ($content_alias == "") {
			$content_alias = $this->default_content();
		}

		// Unbind all models then rebind just the ones we'll need
		$this->Content->unbindAll();

		// Bind the template and content_type models
		$this->Content->bindModel(array('belongsTo' => array('Template' => array('className' => 'Template'))));

		$this->Content->bindModel(array('belongsTo' => array('ContentType' => array('className' => 'ContentType'))));

                //Атрибуты для фильтрации
                $this->Content->bindModel(array('hasMany' => array(
				'FilteredAttribute' => array(
                    'className' => 'Attribute'
                   ,'conditions' =>array('FilteredAttribute.is_active' => '1' ,'FilteredAttribute.is_show_flt' => '1')
                   ,'order' => array('FilteredAttribute.order ASC')
					))));
                $this->Content->FilteredAttribute->setLanguageDescriptor($this->Session->read('Customer.language_id'));
                $this->Content->FilteredAttribute->ValAttribute->setLanguageDescriptor($this->Session->read('Customer.language_id'));
                //Атрибуты для сравнения
                $this->Content->bindModel(array('hasMany' => array(
				'CompareAttribute' => array(
                    'className' => 'Attribute'
                   ,'conditions' =>array('CompareAttribute.is_active' => '1' ,'CompareAttribute.is_show_cmp' => '1')
                   ,'order' => array('CompareAttribute.order ASC')
					))));
                $this->Content->CompareAttribute->setLanguageDescriptor($this->Session->read('Customer.language_id'));
                $this->Content->CompareAttribute->ValAttribute->setLanguageDescriptor($this->Session->read('Customer.language_id'));
                //Атрибуты для отображения
                $this->Content->bindModel(array('hasMany' => array(
				'Attribute' => array(
                    'className' => 'Attribute'
                   ,'conditions' =>array('Attribute.is_active' => '1')
                   ,'order' => array('Attribute.order ASC')
					))));
                $this->Content->Attribute->setLanguageDescriptor($this->Session->read('Customer.language_id'));
                $this->Content->Attribute->ValAttribute->setLanguageDescriptor($this->Session->read('Customer.language_id'));

		$content_conditions = "Content.id = '" . $content_alias . "' OR BINARY Content.alias = '" . $content_alias . "' AND Content.active ='1'";
		$content = $this->Content->find('first', array('recursive' => 2, 'conditions' => $content_conditions));

		// Error page
	    if (!$content) {
   	     throw new NotFoundException();
    	}		
		
		return $content;
	}

	public function get_content_relations($content_id)
	{
		$this->load_models();
		
		$content_conditions = "Content.id = '" . $content_id . "'";
		$conditions = array("Content.id" => $content_id, "Content.content_type_id" => 2);
		$content = $this->Content->find('first', array('conditions' => $content_conditions));
		return $content['xsell'];
	}

	public function get_content_image($content_id)
	{
		App::import('Model', 'ContentImage');
		$ContentImage = new ContentImage();
		
		$content_image = $ContentImage->find('first', array('conditions' => array('content_id' => $content_id)));

		return $content_image['ContentImage']['image'];
	}
	
	/**
	* Returns a list of all content in $key => $value format
	*
	* @param array $conditions array or string of conditions for findAll
	* @return  array  List of all available content.
	*/
	public function generate_content_list ($conditions = null)
	{
		$this->Content->unbindModel(array('hasMany' => array('ContentDescription')));
		$this->Content->bindModel(
			array('hasOne' => array(
					'ContentDescription' => array(
						'className'	=> 'ContentDescription',
						'conditions'	=> 'language_id = ' . $this->Session->read('Customer.language_id')
					)
				)
			)
		);

		$options = array();

		$temp_content = $this->Content->find('all', array('conditions' => $conditions));

		foreach($temp_content AS $loop_content)
		{
			$options_key = $loop_content['Content']['id'];
			$options[$options_key] = $loop_content['ContentDescription']['name'];
			//$options[$options_key] = $loop_content['Content']['id'] . '. ' . $loop_content['ContentDescription']['name'];
		}

		$top_level = array("0" => __('Top Level', true));
		$options = $top_level + $options;
		return $options;
	}
}
?>