<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
class DefinedLanguagesController extends AppController {
	public $name = 'DefinedLanguages';
	
	/*
	* Delets all language definitions with key = $key 
	*
	*/
	public function admin_delete ($key)
	{
		$definitions = $this->DefinedLanguage->find('all', array('conditions' => array('key' => $key)));
		foreach($definitions AS $definition)
		{
			$this->DefinedLanguage->delete($definition['DefinedLanguage']['id']);
		}
		$this->Session->setFlash(__('Record deleted.',true));
		$this->redirect('/defined_languages/admin/');
	}

	public function download_export()
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


	
	public function admin_edit ($defined_language_key = "")
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
			if(isset($this->data['cancelbutton']))
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
	
	public function admin_new()
	{
		$this->redirect('/defined_languages/admin_edit/');	
	}
	
	public function admin_import()
	{
		$this->set('current_crumb', __('Import', true));
		$this->set('title_for_layout', __('Import', true));
	}

	public function admin_upload()
	{
		if (isset($this->data['DefinedLanguages']['submittedfile'])
			&& $this->data['DefinedLanguages']['submittedfile']['error'] == 0
			&& is_uploaded_file($this->data['DefinedLanguages']['submittedfile']['tmp_name'])) {

			@unlink('./files/' . $this->data['DefinedLanguages']['submittedfile']['name']);
			@unlink('./files/defined_languages.xml');
			move_uploaded_file($this->data['DefinedLanguages']['submittedfile']['tmp_name'], './files/' . $this->data['DefinedLanguages']['submittedfile']['name']);

			$z = new ZipArchive();
			$z->open('./files/' . $this->data['DefinedLanguages']['submittedfile']['name']);

			$res = $z->extractTo('./files/', 'defined_languages.xml');
			if ($res) {
				$doc = new DOMDocument();
				if ($doc->load('./files/defined_languages.xml')) {
					$xpath = new DOMXpath($doc);
					$keys = $xpath->query('//definitions/definition/key');

					foreach ($keys as $key) {
						$original = $key->nodeValue;
						$languages = $xpath->query('//definitions/definition[key="' . $key->nodeValue . '"]/language');
						foreach($languages as $language) {
							$id = '';
							foreach ($language->attributes as $attribute) {
								if ('id' == $attribute->name) {
									$language_id = $attribute->value;
								}
							}
							$value = trim($language->nodeValue);

							if ('' == $language_id || '' == $key) {
								$this->Session->setFlash(__('Key or language_id empty.',true));
								@unlink('./files/defined_languages.xml');
								@unlink('./files/' . $this->data['DefinedLanguages']['submittedfile']['name']);
								$this->redirect('/defined_languages/admin_import/');
							} else {
								$definition = $this->DefinedLanguage->find('first', array('conditions' => "DefinedLanguage.language_id = '". $language_id ."' and DefinedLanguage.key='" . $original . "'"));

								if (!$definition) {
									$definition = array();
									$definition['DefinedLanguage'] = array(
										'id' => null,
									);
								}

								$definition['DefinedLanguage']['language_id'] = $language_id;
								$definition['DefinedLanguage']['key'] = $original;
								$definition['DefinedLanguage']['value'] = $value;

								$this->DefinedLanguage->save($definition);
							}

						}
					}

					$this->Session->setFlash(__('Defined languages has been imported.',true));
					@unlink('./files/defined_languages.xml');
					@unlink('./files/' . $this->data['DefinedLanguages']['submittedfile']['name']);
					$this->redirect('/defined_languages/admin/');
				} else {
					$this->Session->setFlash(__('Invalid XML file defined_languages.xml.',true));
					@unlink('./files/defined_languages.xml');
					@unlink('./files/' . $this->data['DefinedLanguages']['submittedfile']['name']);
					$this->redirect('/defined_languages/admin_import/');
				}
			} else {
				$this->Session->setFlash(__('Error extracting defined_languages.xml.',true));
				@unlink('./files/defined_languages.xml');
				@unlink('./files/' . $this->data['DefinedLanguages']['submittedfile']['name']);
				$this->redirect('/defined_languages/admin_import/');
			}

			$z->close();

			@unlink('./files/defined_languages.xml');
			@unlink('./files/' . $this->data['DefinedLanguages']['submittedfile']['name']);
			$this->redirect('/defined_languages/admin/');
		} else {
			$this->Session->setFlash(__('Please, select the file for import.',true));
			$this->redirect('/defined_languages/admin_import/');
		}
	}


	public function admin()
	{
		$this->set('current_crumb', __('Defined Language Listing', true));
		$this->set('title_for_layout', __('Defined Language Listing', true));
		$this->set('defined_languages', $this->DefinedLanguage->find('all', array('group' => array('DefinedLanguage.key'))));
	}
}
?>