<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
class TemplatesController extends AppController {
	public $name = 'Templates';
	public $uses = array('Template','Content','UserPref');
	
	public function admin_set_all_products ($template_id) 
	{
		$products = $this->Content->find('all');
		
		foreach($products AS $product)
		{
			$product['Content']['template_id'] = $template_id;
			$this->Content->save($product);
		}
	
		$this->Session->setFlash(__('You have updated multiple records.',true));				
		$this->redirect('/templates/admin/');
	}
	
	public function admin_set_as_default ($template_id)
	{
		$this->setDefaultItem($template_id);
	}
	
	public function expand_section($template_id) 
	{
		$user_prefs = $this->UserPref->find('first', array('conditions' => array('name' => 'template_collpase', 'user_id' => $this->Session->read('User.id'))));
		$template_collapse = explode(',', $user_prefs['UserPref']['value']);

		$new_collapsed = "";
		foreach($template_collapse AS $collapsed)
		{
			if($collapsed != $template_id)
				$new_collapsed .= $collapsed . ',';
		}
		
		$user_prefs['UserPref']['value'] = $new_collapsed;
	
		$this->UserPref->save($user_prefs);
		
		$this->redirect('/templates/admin/' . $this->RequestHandler->isAjax());		
	}


	public function contract_section($template_id) 
	{
		$user_prefs = $this->UserPref->find('first', array('conditions' => array('name' => 'template_collpase', 'user_id' => $this->Session->read('User.id'))));
		$template_collapse = explode(',', $user_prefs['UserPref']['value']);

		$new_collapsed = "";
		foreach($template_collapse AS $collapsed)
		{
			$new_collapsed .= $collapsed . ',';
			if($collapsed == $template_id)
				$in_array = true;
		}
		
		if(!isset($in_array))
			$new_collapsed .= $template_id;
		
		$user_prefs['UserPref']['value'] = $new_collapsed;
	
		$this->UserPref->save($user_prefs);
		
		$this->redirect('/templates/admin/' . $this->RequestHandler->isAjax());		
	}
	
	public function admin_delete_stylesheet_association($template_id, $stylesheet_id)
	{
		$this->Template->delete_single_association($template_id, $stylesheet_id);	
		$this->Session->setFlash(__('You have deleted a stylesheet association.', true));
		
		$this->redirect('/templates/admin_attach_stylesheets/' . $template_id);
	}
	
	public function admin_attach_stylesheets ($template_id)
	{
		$this->set('current_crumb', __('Attach Stylesheets', true));
		$this->set('title_for_layout', __('Attach Stylesheets', true));
		// Get the template
		$this->Template->id = $template_id;
		$template = $this->Template->read();

		if(!empty($this->data))
		{
			// Construct an array of stylesheet IDs in the data so we can save teh HABTM
			foreach($template['Stylesheet'] AS $value)
			{
				$this->request->data['Stylesheet']['Stylesheet'][] = $value['id'];
			}
			$this->Template->save($this->data);
			
			// Get the template again
			$template = $this->Template->read();
		
		}


		$this->set('template', $template);
		
		// First get a list of all stylesheets
		$all_stylesheets = $this->Template->Stylesheet->find('list');
		
		
		// Loop through the template stylesheets, removing any that are already associatied
		// Figure out a cleaner way for this later
		foreach($template['Stylesheet'] AS $value)
		{
			$key = $value['id'];
			if(!empty($all_stylesheets[$key]))
			{
				unset($all_stylesheets[$key]);
			}
		}
		
		$this->set('available_stylesheets', $all_stylesheets);
		
	}

	public function admin_copy ($template_id)
	{
		if(empty($this->data))
		{
			$this->set('current_crumb', __('Copy Template', true));
			$this->set('title_for_layout', __('Copy Template', true));
			$this->Template->id = $template_id;
			$this->set('template', $this->Template->read());
		}
		else
		{
			$this->Template->id = $template_id;
			$old_template = $this->Template->read();
			
			$new_template = $old_template;
			$new_template['Template']['id'] = null;
			$new_template['Template']['default'] = 0;
			$new_template['Template']['name'] = $this->data['Template']['name'];
			
			$this->Template->save($new_template);
			$new_template_id = $this->Template->getLastInsertId();
			
			$old_children = $this->Template->find('all', array('conditions' => array('parent_id' => $template_id)));
			foreach($old_children AS $old_child)
			{
				$this->Template->create();
				
				$new_child = $old_child;
				$new_child['Template']['id'] = null;
				$new_child['Template']['parent_id'] = $new_template_id;

				$this->Template->save($new_child);
			}
			
			$this->Session->setFlash(__('Record copied.', true));
			$this->redirect('/templates/admin/');
		}
		
	}
	
	public function admin_delete ($template_id)
	{
		// First make sure nothing is using this template
		$check_content = $this->Content->find('count', array('conditions' => array('template_id' => $template_id)));
		
		// Don't allow the delete if something is utilizing this template
		if(($check_content) > 0)
		{
			$this->Session->setFlash(__('Could not delete template. Template is in use.', true));		
		}
		else
		{
			// Get all templates that have this template as a parent
			$child_templates = $this->Template->find('all', array('conditions' => array('parent_id' => $template_id)));
			foreach($child_templates AS $child)
			{
				$this->Template->delete($child['Template']['id']);
			}
			
			// Ok, delete the template
			$this->Template->delete($template_id);	
			$this->Session->setFlash(__('You deleted a template.', true));		
		}
		$this->redirect('/templates/admin/');
	}
	
	public function admin_edit ($template_id)
	{
		$this->set('current_crumb', __('Template Content', true));
		$this->set('title_for_layout', __('Template Content', true));
		if(empty($this->data))	
		{
			$template = $this->Template->read(null, $template_id);
			
			if($template['Template']['parent_id'] == 0)
			{
				$layout_template = $this->Template->find('first', array('conditions' => array('parent_id' => $template_id, 'template_type_id' => '1')));
				$this->redirect('/templates/admin_edit/' . $layout_template['Template']['id']);				
			}
			
			$this->request->data = $template;
			
			// Set the breadcrumb and breadcrumb info

			$this->Template->id = $template['Template']['parent_id'];
			$parent = $this->Template->read();
			
		}
		else
		{
			if(isset($this->data['cancelbutton']))
			{
				$this->redirect('/templates/admin/');
				die();
			}
		
			$this->Template->save($this->data);		
			$this->Session->setFlash(__('Record saved.', true));
				
			if(isset($this->data['apply']))
			{
				$this->redirect('/templates/admin_edit/' . $template_id);
			}
			else
			{
				$this->redirect('/templates/admin/');
			}				
		
		}
	}
	
	public function admin_edit_details ($template_id)
	{
		$this->set('current_crumb', __('Edit Template', true));
		$this->set('title_for_layout', __('Edit Template', true));
		if(empty($this->data))
		{
			$this->Template->id = $template_id;
			$data = $this->Template->read();
			$this->set('data', $data);
		}
		else
		{
			$this->Template->save($this->data);
			$this->Session->setFlash(__('Record saved.', true));
			$this->redirect('/templates/admin/');
		}
	}
	
	public function admin_new() 
	{
		$this->set('current_crumb', __('New Template', true));
		$this->set('title_for_layout', __('New Template', true));
		if(empty($this->data))
		{
		
		}
		else
		{
			if(isset($this->data['cancelbutton']))
			{
				$this->redirect('/templates/admin/');
				die();
			}

			$this->Template->save($this->data);
			$template_id = $this->Template->getLastInsertId();
						
			$default_templates = $this->Template->TemplateType->find('all');
			foreach($default_templates AS $default)
			{
				$this->Template->create();
				$new_template = array();
				$new_template['Template']['parent_id'] = $template_id;
				$new_template['Template']['template_type_id'] = $default['TemplateType']['id'];				
				$new_template['Template']['name'] = $default['TemplateType']['name'];								
				$new_template['Template']['template'] = $default['TemplateType']['default_template'];				
				
				$this->Template->save($new_template);
			}
			

			$this->Session->setFlash(__('Record created.', true));
			$this->redirect('/templates/admin/');
		}
	}
	
	public function admin($ajax = false)
	{
		$this->set('current_crumb', __('Templates Listing', true));
		$this->set('title_for_layout', __('Templates Listing', true));
		$this->set('templates',$this->Template->find('threaded', array('order' => array('Template.id ASC'))));
	
		$user_prefs = $this->UserPref->find('first', array('conditions' => array('name' => 'template_collpase','user_id' => $this->Session->read('User.id'))));	
		$exploded_prefs = explode(',', $user_prefs['UserPref']['value']);
	
		$this->set('user_prefs', $exploded_prefs);	
	}
	
	public function download_export()
	{
		$scripts = array();
		$images = array();
		$z = new ZipArchive();
		$res = $z->open('./files/templates.zip', ZIPARCHIVE::OVERWRITE);

		$templates = $this->Template->find('threaded', array('order' => array('Template.id ASC')));

		$output  = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
		$output .= '<templates>' . "\n";

		foreach ($templates as $key => $template) {
			$output .= '  <template name="' . $template['Template']['name'] . '">' . "\n";
			foreach ($template['children'] as $child) {

				$matches = array();
				preg_match_all('/<script.*?src\w*?=\w*?\"{base_path}\/(.*?)\"/i', $child['Template']['template'], $matches);

				foreach ((array)$matches[1] as $matche) {
					$scripts[$matche] = $matche;
				}

				$matches = array();
				preg_match_all('/<img.*?src\w*?=\w*?\"{base_path}\/(.*?)\"/i', $child['Template']['template'], $matches);

				foreach ((array)$matches[1] as $matche) {
					$images[$matche] = $matche;
				}

				$output .= '    <template template_type_id="' . $child['Template']['template_type_id'] . '" name="' . $child['Template']['name'] . '">' . "\n";
				$output .= '      <![CDATA[';
				$output .= $child['Template']['template'];
				$output .= ']]>' . "\n";
				$output .= '    </template>' . "\n";
			}
			$output .= '  </template>' . "\n";
		}

		$output .= '</templates>' . "\n";
		$z->addFromString('templates.xml', $output);

		foreach ($scripts as $script) {
			$z->addFile($script, $script);
		}

		foreach ($images as $image) {
			$z->addFile($image, $image);
		}

		$z->close();

		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="templates.zip"');
		readfile('./files/templates.zip');
		@unlink('./files/templates.zip');
		die();
	}

	public function admin_import()
	{
		$this->set('current_crumb', __('Import', true));
		$this->set('title_for_layout', __('Import', true));
	}

	public function admin_upload()
	{
		if (isset($this->data['Templates']['submittedfile'])
			&& $this->data['Templates']['submittedfile']['error'] == 0
			&& is_uploaded_file($this->data['Templates']['submittedfile']['tmp_name'])) {

			@unlink('./files/' . $this->data['Templates']['submittedfile']['name']);
			@unlink('./files/templates.xml');
			move_uploaded_file($this->data['Templates']['submittedfile']['tmp_name'], './files/' . $this->data['Templates']['submittedfile']['name']);

			$z = new ZipArchive();
			$z->open('./files/' . $this->data['Templates']['submittedfile']['name']);

			$res = $z->extractTo('./files/');
			$this->copyDir('./files/js', './js', true);
			$this->copyDir('./files/img', './img', true);

			$res = $z->extractTo('./files/', 'templates.xml');

			if ($res) {
				$doc = new DOMDocument();
				if ($doc->load('./files/templates.xml')) {
					$xpath = new DOMXpath($doc);
					$templates = $xpath->query('//templates/template');

					foreach ($templates as $template) {
						$name = '';

						foreach ($template->attributes as $attribute) {
							if ('name' == $attribute->name) {
								$name = $attribute->value;
							}
						}

						if ('' == $name) {
							$this->Session->setFlash(__('Templates name is empty.',true));
							@$this->removeDir('./files/js');
							@$this->removeDir('./files/img');
							@unlink('./files/templates.xml');
							@unlink('./files/' . $this->data['Templates']['submittedfile']['name']);
							$this->redirect('/templates/admin_import/');
						} else {
							$this->Template->unbindModel(array('hasAndBelongsToMany' => array('Stylesheet')), false);
							$tmpl = $this->Template->find('first', array('conditions' => "Template.name = '" . $name . "'"));

							if (!$tmpl) {
								$tmpl = array();
								$tmpl['Template'] = array('id' => null);
								$tmpl['Template']['parent_id'] = 0;
								$tmpl['Template']['template_type_id'] = 0;
								$tmpl['Template']['name'] = $name;
								$this->Template->save($tmpl);
								$id = $this->Template->getLastInsertId();
							} else {
								$id = $tmpl['Template']['id'];
							}

							$children = $xpath->query('//templates/template[@name="' . $name . '"]/template');

							foreach ($children as $child) {
								$child_name = '';
								$child_type_id = '';

								foreach ($child->attributes as $attribute) {

									if ('name' == $attribute->name) {
										$child_name = $attribute->value;
									}

									if ('template_type_id' == $attribute->name) {
										$child_type_id = $attribute->value;
									}

								}

								$child_template = $this->Template->find('first', array('conditions' => "Template.parent_id='" . $id . "' and Template.template_type_id='" . $child_type_id . "'"));
								
								if (!$child_template) {
									$child_template = array();
									$child_template['Template'] = array(
										'id' => null,
									);
								}

								$child_template['Template']['parent_id'] = $id;
								$child_template['Template']['template_type_id'] = $child_type_id;
								$child_template['Template']['name'] = $child_name;
								$child_template['Template']['template'] = trim($child->nodeValue);

								$this->Template->save($child_template);
							}
						}
					}

					$this->Session->setFlash(__('Templates has been imported.',true));
					@$this->removeDir('./files/js');
					@$this->removeDir('./files/img');
					@unlink('./files/templates.xml');
					@unlink('./files/' . $this->data['Templates']['submittedfile']['name']);
					$this->redirect('/templates/admin/');
				} else {
					$this->Session->setFlash(__('Invalid XML file templates.xml.',true));
					@$this->removeDir('./files/js');
					@$this->removeDir('./files/img');
					@unlink('./files/templates.xml');
					@unlink('./files/' . $this->data['Templates']['submittedfile']['name']);
					$this->redirect('/templates/admin_import/');
				}
			} else {
				$this->Session->setFlash(__('Error extracting templates.xml.',true));
				@$this->removeDir('./files/js');
				@$this->removeDir('./files/img');
				@unlink('./files/templates.xml');
				@unlink('./files/' . $this->data['Templates']['submittedfile']['name']);
				$this->redirect('/templates/admin_import/');
			}

			$z->close();

			@$this->removeDir('./files/js');
			@$this->removeDir('./files/img');
			@unlink('./files/templates.xml');
			@unlink('./files/' . $this->data['Templates']['submittedfile']['name']);
			$this->redirect('/templatess/admin/');
		} else {
			$this->Session->setFlash(__('Please, select the file for import.',true));
			$this->redirect('/templates/admin_import/');
		}
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
