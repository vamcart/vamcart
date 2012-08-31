<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
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
			$this->DefinedLanguage->delete($definition['DefinedLanguage']['id']);
		}
		$this->Session->setFlash(__('Record deleted.',true));
		$this->redirect('/defined_languages/admin/');
	}

	function download_export()
	{
		$images = array();
		$z = new ZipArchive();
		$res = $z->open('./files/languages.zip', ZIPARCHIVE::OVERWRITE);

		$definitions = $this->DefinedLanguage->find('all');
		$output  = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
		$output .= '<definitions>' . "\n";

		$definitions_array = array();

		foreach ($definitions as $definition) {
			if (!isset($definitions_array[$definition['DefinedLanguage']['key']])) {
				$definitions_array[$definition['DefinedLanguage']['key']] = array();
			}

			$definitions_array[$definition['DefinedLanguage']['key']][$definition['DefinedLanguage']['language_id']] =
				$definition['DefinedLanguage']['value'];
		}

		foreach ($definitions_array as $key => $definition) {
			$output .= '  <definition>' . "\n";
			$output .= '    <key><![CDATA[' . $key . ']]></key>' . "\n";
			foreach ($definition as $language_id => $value) {
				$output .= '    <language id="' . $language_id . '">' . "\n";
				$output .= '      <![CDATA[';
				$output .= $value;
				$output .= ']]>' . "\n";
				$output .= '    </language>' . "\n";
			}
			$output .= '  </definition>' . "\n";
		}

		$output .= '</definitions>' . "\n";
		$z->addFromString('defined_languages.xml', $output);

		$z->close();

		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="languages.zip"');
		readfile('./files/languages.zip');
		@unlink('./files/languages.zip');
		die();
	}


	
	function admin_edit ($defined_language_key = "")
	{
		$this->set('current_crumb', __('Defined Language Details', true));
		$this->set('title_for_layout', __('Defined Language Details', true));
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
			if(isset($this->params['form']['cancelbutton']))
			{
				$this->redirect('/defined_languages/admin/');
				die();
			}
			
			// Lets just delete all of the defined languages and remake them
			$language_descriptions = $this->DefinedLanguage->find('all', array('conditions' => array('key' => $defined_language_key)));
			foreach($language_descriptions AS $language_description)
			{
				$this->DefinedLanguage->delete($language_description['DefinedLanguage']['id']);
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
		$this->set('title_for_layout', __('Defined Language Listing', true));
		$this->set('defined_languages', $this->DefinedLanguage->find('all', array('group' => array('DefinedLanguage.key'))));
	}
}
?>