<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
class StylesheetsController extends AppController {
	public $name = 'Stylesheets';
		
	public function load($alias)
	{
		$alias = str_replace(".css","",$alias);
		$stylesheet = $this->Stylesheet->find('first', array('conditions' => "Stylesheet.id = '".$alias."' OR Stylesheet.alias = '".$alias."'"));

		// Minify css
		$output = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $stylesheet['Stylesheet']['stylesheet']);
		$output = str_replace(array("\r\n", "\r", "\n", "\t", '/\s\s+/', '  ', '   '), '', $output);
		$output = str_replace(array(' {', '{ '), '{', $output);
		$output = str_replace(array(' }', '} '), '}', $output);

		/* set MIME type */
		@ob_start ('ob_gzhandler');
		header("Content-Type: text/css");
		header("Cache-Control: must-revalidate");
		$offset = 720000 ;
		$ExpStr = "Expires: " . gmdate("D, d M Y H:i:s", time() + $offset) . " GMT";
		header($ExpStr); 

		echo '/* Begin Stylesheet: ' . $stylesheet['Stylesheet']['name'] . ' */';		
		echo $output;
		echo '/* End Stylesheet: ' . $stylesheet['Stylesheet']['name'] . ' */';				
		die();

	}


	public function download_export()
	{
		$images = array();
		$z = new ZipArchive();
		$res = $z->open('./files/styles.zip', ZIPARCHIVE::OVERWRITE);

		$stylesheets = $this->Stylesheet->find('all');
		$output  = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
		$output .= '<stylesheets>' . "\n";
		foreach ($stylesheets as $stylesheet) {
			$output .= '  <stylesheet name="' . $stylesheet['Stylesheet']['name'] . '" alias="' . $stylesheet['Stylesheet']['alias'] . '">' . "\n";
			$output .= '  <![CDATA[' . "\n";
			$output .= $stylesheet['Stylesheet']['stylesheet'];
			$output .= '  ]]>' . "\n";
			$output .= '  </stylesheet>' . "\n";

			$matches = array();
			
			preg_match_all('/url\(\.\.\/\.\.\/(.*?)\)/', $stylesheet['Stylesheet']['stylesheet'], $matches);

			foreach ((array)$matches[1] as $matche) {
				$images[$matche] = $matche;
			}
		
		}
		$output .= '</stylesheets>' . "\n";
		$z->addFromString('stylesheets.xml', $output);

		foreach ($images as $image) {
			$z->addFile($image, $image);
		}

		$z->close();

		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="styles.zip"');
		readfile('./files/styles.zip');
		@unlink('./files/styles.zip');
		die();
	}

	public function admin_delete_template_association($template_id, $stylesheet_id)
	{
		$this->Stylesheet->Template->delete_single_association($template_id, $stylesheet_id);	
		$this->Session->setFlash(__('You have deleted a template association.',true));
		
		$this->redirect('/stylesheets/admin_attach_templates/' . $stylesheet_id);
	}
	
	public function admin_attach_templates ($stylesheet_id)
	{
		// Get the stylesheet
		$this->Stylesheet->id = $stylesheet_id;
		$stylesheet = $this->Stylesheet->read();
		if(!empty($this->data))
		{
			// Construct an array of stylesheet IDs in the data so we can save teh HABTM
			foreach($stylesheet['Template'] AS $value)
			{
				$this->request->data['Template']['Template'][] = $value['id'];
			}
			$this->Stylesheet->save($this->data);

			// Get the template again
			$stylesheet = $this->Stylesheet->read();
		
		}
		$this->set('current_crumb',__('Attach Template',true));
		$this->set('title_for_layout', __('Attach Template', true));
		$this->set('stylesheet', $stylesheet);

		// First get a list of all stylesheets
		$all_templates = $this->Stylesheet->Template->find('list', array('parent_id' => '0'));
		
		foreach($all_templates AS $key => $value) {
			$all_templates[$key] = __($value);	
		}
					
		// Loop through the template stylesheets, removing any that are already associatied
		// Figure out a cleaner way for this later
		foreach($stylesheet['Template'] AS $value)
		{
			$key = $value['id'];
			if(!empty($all_templates[$key]))
			{
				unset($all_templates[$key]);
			}
		}

		$this->set('available_templates', $all_templates);
		
	}
	
	public function admin_change_active_status ($id) 
	{
		$this->changeActiveStatus($id);	
	}
	
	public function admin_copy ($stylesheet_id)
	{
		$this->set('current_crumb',__('Copy Stylesheet',true));
		$this->set('title_for_layout', __('Copy Stylesheet', true));
		if(empty($this->data))
		{
			$this->Stylesheet->id = $stylesheet_id;
			$this->set('stylesheet',$this->Stylesheet->read());
		}
		else
		{
			if(isset($this->data['cancelbutton']))
			{
				$this->redirect('/stylesheets/admin/');
			}
			else
			{
				$this->Stylesheet->id = $stylesheet_id;
				$old_stylesheet = $this->Stylesheet->read();
			
				$new_stylesheet = $old_stylesheet;
				$new_stylesheet['Stylesheet']['id'] = null;
				$new_stylesheet['Stylesheet']['name'] = $this->data['Stylesheet']['name'];
				$new_stylesheet['Stylesheet']['alias'] = $this->generateAlias($this->data['Stylesheet']['name']);	
				$new_stylesheet['Stylesheet']['stylesheet'] = $this->data['Stylesheet']['stylesheet'];
			
				$this->Stylesheet->save($new_stylesheet);
			
				$stylesheet_id = $this->Stylesheet->getLastInsertId();
		
				$this->redirect('/stylesheets/admin_edit/' . $stylesheet_id);
			}
		}	
	}
	
	public function admin_delete ($stylesheet_id)
	{
		// First make sure no templates are using this stylesheet
		$this->Stylesheet->id = $stylesheet_id;
		$stylesheet_find = $this->Stylesheet->read();
		
		// Don't allow the delete if a template is utilizing this stylesheet
		if(count($stylesheet_find['Template']) > 0)
		{
			$this->Session->setFlash(__('Could not delete stylesheet. Stylesheet is in use.',true));		
		}
		else
		{
			// Ok, delete the stylesheet
			$this->Stylesheet->delete($stylesheet_id);	
			$this->Session->setFlash(__('You deleted a stylesheet.',true));		
		}
		$this->redirect('/stylesheets/admin/');
	}
	
	public function admin_edit ($stylesheet_id = null)
	{
		$this->set('current_crumb', __('Stylesheet', true));
		$this->set('title_for_layout', __('Stylesheet', true));
		$this->set('active_checked', true);
		if(($stylesheet_id == null) && (empty($this->data)))
		{	// We're creating a stylesheet
			$this->set('new_stylesheet', true);
			$this->set('data', null);
		}
		elseif(empty($this->data))	
		{	// Otherwise we're editing a stylesheet
			$this->Stylesheet->id = $stylesheet_id;
			$data = $this->Stylesheet->read();
			if($data['Stylesheet']['active'] == 1) {
				$this->set('active_checked', true);
			} else {
				$this->set('active_checked', false);
			}
			$this->set('data',$data);
		}
		else
		{	// We submitted data
			if(isset($this->data['cancelbutton']))
			{	
				$this->redirect('/stylesheets/admin/');
			}
			else
			{	
				// If the alias is empty, generate it by the name, otherwise generate it with the alias again just for protection.
				if($this->data['Stylesheet']['alias'] == "")
				{	
					$this->request->data['Stylesheet']['alias'] = $this->generateAlias( $this->data['Stylesheet']['name']);
				}
				else
				{
					$this->request->data['Stylesheet']['alias'] = $this->generateAlias($this->data['Stylesheet']['alias']);	
				}

			
				// Do the save
				$this->Stylesheet->save($this->data);			
				
				// Set the flash and stylesheet_id depending on if it's a new stylesheet
				if($this->data['Stylesheet']['id'] == "")	
				{
					$stylesheet_id = $this->Stylesheet->getLastInsertId();
					$this->Session->setFlash(__('You have created a new stylesheet.',true));
				}
				else
				{
					$this->Session->setFlash(__('You have updated a stylesheet.',true));
				}
			}
			
			if(isset($this->data['apply']))
				$this->redirect('/stylesheets/admin_edit/' . $stylesheet_id);
			else
				$this->redirect('/stylesheets/admin/');
		}
	}
	
	public function admin_new() 
	{
		$this->redirect('/stylesheets/admin_edit/');
	}
	
	public function admin_modify_selected() 
	{
		foreach($this->params['data']['Stylesheet']['modify'] AS $value)
		{
			// Make sure the id is valid
			if($value > 0)
			{
			
				// Get the GCB from the database
				$this->Stylesheet->id = $value;
				$stylesheet = $this->Stylesheet->read();
			
				switch ($this->data['multiaction']) 
				{
					case "delete":
					    $this->Stylesheet->delete($value);
						$this->Session->setFlash(__('You have deleted multiple stylesheets.',true));		
					    break;
					case "activate":
					    $stylesheet['Stylesheet']['active'] = 1;
						$this->Stylesheet->save($stylesheet);
						$this->Session->setFlash(__('You have activated multiple stylesheets.',true));		
				    	break;
					case "deactivate":
					    $stylesheet['Stylesheet']['active'] = 0;
						$this->Stylesheet->save($stylesheet);
						$this->Session->setFlash(__('You have inactivated multiple stylesheets.',true));		
					    break;
				}
			}
		}
		$this->redirect('/stylesheets/admin/');
	}	
	
	public function admin_import()
	{
		$this->set('current_crumb', __('Import', true));
		$this->set('title_for_layout', __('Import', true));
	}
	
	public function admin_upload()
	{
	
		if (isset($this->data['Stylesheet']['submittedfile'])
		       && $this->data['Stylesheet']['submittedfile']['error'] == 0
		       && is_uploaded_file($this->data['Stylesheet']['submittedfile']['tmp_name'])) {

			@$this->removeDir('./files/img');
			@unlink('./files/' . $this->data['Stylesheet']['submittedfile']['name']);
			@unlink('./files/stylesheets.xml');
			move_uploaded_file($this->data['Stylesheet']['submittedfile']['tmp_name'], './files/' . $this->data['Stylesheet']['submittedfile']['name']);

			$z = new ZipArchive();
			$z->open('./files/' . $this->data['Stylesheet']['submittedfile']['name']);

			$res = $z->extractTo('./files/');
			$this->copyDir('./files/img', './img', true);

			$res = $z->extractTo('./files/', 'stylesheets.xml');
			if ($res) {
				$doc = new DOMDocument();
				if ($doc->load('./files/stylesheets.xml')) {
					$xpath = new DOMXpath($doc);
					$sheets = $xpath->query('//stylesheets/stylesheet');
					foreach ($sheets as $sheet) {
						$name = '';
						$alias = '';

						foreach ($sheet->attributes as $attribute) {
							if ('name' == $attribute->name) {
								$name = $attribute->value;
							} elseif ('alias' == $attribute->name) {
								$alias = $attribute->value;
							}
						}

						if ('' == $name || '' == $alias) {
							$this->Session->setFlash(__('Style name or style alias is empty.',true));
							@$this->removeDir('./files/img');
							@unlink('./files/stylesheets.xml');
							@unlink('./files/' . $this->data['Stylesheet']['submittedfile']['name']);
							$this->redirect('/stylesheets/admin_import/');
						} else {
							$data = $sheet->nodeValue;

							$this->Stylesheet->unbindModel(array('hasAndBelongsToMany' => array('Template')), false);
							$stylesheet = $this->Stylesheet->find('first', array('conditions' => "Stylesheet.alias = '".$alias."'"));

							if (!$stylesheet) {
								$stylesheet = array();
								$stylesheet['Stylesheet'] = array(
									'id' => null,
								);
							}

							$stylesheet['Stylesheet']['name'] = $name;
							$stylesheet['Stylesheet']['alias'] = $alias;
							$stylesheet['Stylesheet']['stylesheet'] = $data;

							$this->Stylesheet->save($stylesheet);
						}
					}

					$this->Session->setFlash(__('Styles has been imported.',true));
					@$this->removeDir('./files/img');
					@unlink('./files/stylesheets.xml');
					@unlink('./files/' . $this->data['Stylesheet']['submittedfile']['name']);
					$this->redirect('/stylesheets/admin/');
				} else {
					$this->Session->setFlash(__('Invalid XML file stylesheets.xml.',true));
					@$this->removeDir('./files/img');
					@unlink('./files/stylesheets.xml');
					@unlink('./files/' . $this->data['Stylesheet']['submittedfile']['name']);
					$this->redirect('/stylesheets/admin_import/');
				}
			} else {
				$this->Session->setFlash(__('Error extracting stylesheets.xml.',true));
				@$this->removeDir('./files/img');
				@unlink('./files/stylesheets.xml');
				@unlink('./files/' . $this->data['Stylesheet']['submittedfile']['name']);
				$this->redirect('/stylesheets/admin_import/');
			}

			$z->close();

			@$this->removeDir('./files/img');
			@unlink('./files/stylesheets.xml');
			@unlink('./files/' . $this->data['Stylesheet']['submittedfile']['name']);
			$this->redirect('/stylesheets/admin/');
		} else {
			$this->Session->setFlash(__('Please, select the file for import.',true));
			$this->redirect('/stylesheets/admin_import/');
		}
	}
	
	public function admin($ajax_request = false)
	{
		$this->set('current_crumb', __('Stylesheets Listing', true));
		$this->set('title_for_layout', __('Stylesheets Listing', true));
		$this->set('stylesheets',$this->Stylesheet->find('all', array('order' => array('Stylesheet.name ASC'))));
		
	}
	
	
	// Helper stuff
	public function removeDir($path)
	{
		if (file_exists($path) && is_dir($path)) {
			$dirHandle = opendir($path);

			while (false !== ($file = readdir($dirHandle))) {
				if ($file!='.' && $file!='..') {
					$tmpPath=$path.'/'.$file;
					chmod($tmpPath, 0777);

					if (is_dir($tmpPath)) {
						$this->removeDir($tmpPath);
					} else {
						if (file_exists($tmpPath)) {
							@unlink($tmpPath);
						}
					}
				}
			}

			closedir($dirHandle);

			if (file_exists($path)) {
				@rmdir($path);
			}
		}
	}

	public function copyDir($source, $dest, $overwrite = false)
	{
		if (!is_dir($dest)) {
			mkdir($dest);
		}

		if ($handle = opendir($source)) {
			while (false !== ($file = readdir($handle))) {
				if ($file != '.' && $file != '..') {
					$path = $source . '/' . $file;

					if (is_file($path)) {
						if (!is_file($dest . '/' . $file) || $overwrite) {
							$ext = pathinfo($file, PATHINFO_EXTENSION);
							if ('php' != $ext) {
								if (!@copy($path, $dest . '/' . $file)) {
								}
							}
						}
					} elseif (is_dir($path)) {

						if (!is_dir($dest . '/' . $file)) {
							mkdir($dest . '/' . $file);
						}

						$this->copyDir($path, $dest . '/' . $file, $overwrite);
					}
				}
			}
			closedir($handle);
		}
	}
}
?>