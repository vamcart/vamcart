<?php 
/** SMS - Selling Made Simple
 * Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
 * This project's homepage is: http://sellingmadesimple.org
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * BUT withOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
**/

class ContentBaseComponent extends Object 
{
    var $components = array('Session','Smarty');

	function beforeFilter ()
	{
		
	}

    function startup(&$controller)
	{
		$this->load_models();
    }

	function load_models ()
	{
		// We're loading the Session component here because the smarty plugin can't yet
		App::import('Component', 'Session');
			$this->Session =& new SessionComponent();
		
		App::import('Model', 'Content');
			$this->Content =& new Content();
		
		App::import('Model', 'ContentDescription');
			$this->ContentDescription =& new ContentDescription();	
	}


	/**
	* Returns the ID of the default page
	*
	*/		
	function default_content ()
	{
		$content = $this->Content->find(array('Content.default' => '1'));
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
	function get_content_description ($content_id = null)
	{
		if($content_id == null)
			$content_id = $this->default_content();

		$this->load_models();
		
		$content_description = $this->ContentDescription->find(array('content_id' => $content_id, 'language_id' => $this->Session->read('Customer.language_id')));
		
		return $content_description;
	}
	
	/**
	* Unbinds all content descriptions and retuns the content.
	*
	* @param int $content_id ID of content page to Get
	* @return  array  Content without the descriptions
	*/	
	function get_content_information ($content_alias)
	{
		$this->load_models();
			
		if($content_alias == "")
			$content_alias = $this->default_content();

		// Unbind all models then rebind just the ones we'll need
		$this->Content->unbindAll();
		
		// Bind the template and content_type models
	    $this->Content->bindModel(array('belongsTo' => array('Template' => array('className' => 'Template'))));

	    $this->Content->bindModel(array('belongsTo' => array('ContentType' => array('className' => 'ContentType'))));		
		
		$content_conditions = "Content.id = '".$content_alias."' OR Content.alias = '".$content_alias."'";
		$content = $this->Content->find($content_conditions,null, null, 2);

		return $content;
	}
	
		
	/**
	* Returns a list of all content in $key => $value format
	*
	* @param array $conditions array or string of conditions for findAll
	* @return  array  List of all available content.
	*/	
    function generate_content_list ($conditions = null)
    {
			
		$this->Content->unbindModel(array('hasMany' => array('ContentDescription')));
		$this->Content->bindModel(
	        array('hasOne' => array(
				'ContentDescription' => array(
                    'className' => 'ContentDescription',
					'conditions'   => 'language_id = 1'
                )
            )
           	)
	    );
		
		$options = array();
		
		$temp_content = $this->Content->findAll($conditions, null, 'ContentDescription.name ASC');
		
		foreach($temp_content AS $loop_content)
		{
			$options_key = $loop_content['Content']['id'];
			$options[$options_key] = $loop_content['ContentDescription']['name'];
			//$options[$options_key] = $loop_content['Content']['id'] . '. ' . $loop_content['ContentDescription']['name'];
		}
		
		return $options;
    }
	
	
	
}
?>