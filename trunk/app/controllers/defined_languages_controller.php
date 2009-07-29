<?php
/* -----------------------------------------------------------------------------------------
   VaM Shop
   http://vamshop.com
   http://vamshop.ru
   Copyright 2009 VaM Shop
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class DefinedLanguagesController extends AppController {
	var $name = 'DefinedLanguages';
	
	/*
	* Delets all language definitions with key = $key 
	*
	*/
	function admin_delete ($key)
	{
		$definitions = $this->DefinedLanguage->find('all', array('conditions' => array('key' => $key)));
		foreach($definitions AS $definition)
		{
			$this->DefinedLanguage->del($definition['DefinedLanguage']['id']);
		}
		$this->Session->setFlash(__('Record deleted.',true));
		$this->redirect('/defined_languages/admin/');
	}
	
	
	function admin_edit ($defined_language_key = "")
	{
		$this->set('current_crumb', __('Defined Language Details', true));
		if(empty($this->data))
		{
			$data = $this->DefinedLanguage->find('all', array('conditions' => array('key' => $defined_language_key)));

			// Loop through the language definftions and set a new array with the key as the language_id
			$keyed_definitions = array();
			foreach($data AS $key => $value)
			{
				$array_key = $value['DefinedLanguage']['language_id'];
				$keyed_definitions[$array_key] = $data[$key];
			}
			
			$this->set('data', $keyed_definitions);
			$this->set('defined_key',$defined_language_key);
			$this->set('languages', $this->DefinedLanguage->Language->find('all', array('conditions' => array('active' => '1'), 'order' => array('Language.id ASC'))));
		}
		else
		{
			// Check if we pressed the cancel button
			if(isset($this->params['form']['cancel']))
			{
				$this->redirect('/defined_languages/admin/');
				die();
			}
			
			// Lets just delete all of the defined languages and remake them
			$language_descriptions = $this->DefinedLanguage->find('all', array('conditions' => array('key' => $defined_language_key)));
			foreach($language_descriptions AS $language_description)
			{
				$this->DefinedLanguage->del($language_description['DefinedLanguage']['id']);
			}

			foreach($this->data['DefinedLanguage']['DefinedLanguage'] AS $id => $value)
			{
				$new_definition = array();
				$new_definition['DefinedLanguage']['language_id'] = $id;
				$new_definition['DefinedLanguage']['key'] = $this->data['DefinedLanguage']['key'];
				$new_definition['DefinedLanguage']['value'] = $value['value'];				

				$this->DefinedLanguage->create();
				$this->DefinedLanguage->save($new_definition);
			}
				

			$this->redirect('/defined_languages/admin/');
			
		
		}
	}
	
	function admin_new()
	{
		$this->redirect('/defined_languages/admin_edit/');	
	}
	
	function admin()
	{
		$this->set('current_crumb', __('Defined Language Listing', true));
		$this->set('defined_languages', $this->DefinedLanguage->find('all', array('group' => array('DefinedLanguage.key'))));
	}
}
?>