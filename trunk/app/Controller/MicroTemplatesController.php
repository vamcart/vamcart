<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
class MicroTemplatesController extends AppController {
	public $name = 'MicroTemplates';
	
	public function admin_create_from_tag ()
	{
		$this->set('current_crumb',__('Enter an alias to use',true));
		$this->set('title_for_layout', __('Enter an alias to use', true));
	}
	
		
	public function admin_delete ($id)
	{
		$this->MicroTemplate->delete($id);
		$this->Session->setFlash( __('Record deleted.',true));
		$this->redirect('/micro_templates/admin');
	}
	
	public function admin_edit ($id = null)
	{
		$this->set('current_crumb', __('Micro Template', true));
		$this->set('title_for_layout', __('Micro Template', true));
		if(empty($this->data))
		{
			$this->request->data = $this->MicroTemplate->read(null,$id);
			
		}
		else
		{
			// Check if we pressed the cancel button
			if(isset($this->data['cancelbutton']))
			{
				$this->redirect('/micro_templates/admin/');
				die();
			}
			
			// Generate the alias to be safe
			$this->request->data['MicroTemplate']['alias'] = $this->generateAlias($this->data['MicroTemplate']['alias']);	
		
			$this->MicroTemplate->save($this->data);

			$this->Session->setFlash( __('Micro Template Saved.',true));
			
			if(isset($this->data['apply']))
			{
				if($id == null)
					$id = $this->MicroTemplate->getLastInsertId();
				$this->redirect('/micro_templates/admin_edit/' . $id);
			}
			else
			{
				$this->redirect('/micro_templates/admin');
			}
		}
	}
	
	public function admin_new ()
	{
		$this->redirect('/micro_templates/admin_edit/');	
	}
	
	public function admin ($ajax = false)
	{
		$this->set('current_crumb', __('Micro Templates Listing', true));
		$this->set('title_for_layout', __('Micro Templates Listing', true));
		$this->set('micro_templates',$this->MicroTemplate->find('all'));
	}
	public function download_export()
	{
		$scripts = array();
		$images = array();
		$z = new ZipArchive();
		$res = $z->open('./files/micro_templates.zip', ZIPARCHIVE::OVERWRITE);

		$micro_templates = $this->MicroTemplate->find('all');

		$output  = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
		$output .= '<micro_templates>' . "\n";

		foreach ($micro_templates as $key => $template) {
			$matches = array();
			preg_match_all('/<script.*?src\w*?=\w*?\"{base_path}\/(.*?)\"/i', $template['MicroTemplate']['template'], $matches);

			foreach ((array)$matches[1] as $matche) {
				$scripts[$matche] = $matche;
			}

			$matches = array();
			preg_match_all('/<img.*?src\w*?=\w*?\"{base_path}\/(.*?)\"/i', $template['MicroTemplate']['template'], $matches);

			foreach ((array)$matches[1] as $matche) {
				$images[$matche] = $matche;
			}

			$output .= '  <micro_template alias="' . $template['MicroTemplate']['alias'] . '" tag_name="' . $template['MicroTemplate']['tag_name'] . '">' . "\n";
			$output .= '    <![CDATA[';
			$output .= $template['MicroTemplate']['template'];
			$output .= ']]>' . "\n";
			$output .= '  </micro_template>' . "\n";
		}

		$output .= '</micro_templates>' . "\n";
		$z->addFromString('micro_templates.xml', $output);

		foreach ($scripts as $script) {
			if (file_exists($script)) {
				$z->addFile($script, $script);
			}
		}

		foreach ($images as $image) {
			if (file_exists($image)) {
				$z->addFile($image, $image);
			}
		}

		$z->close();

		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="micro_templates.zip"');
		readfile('./files/micro_templates.zip');
		@unlink('./files/micro_templates.zip');
		die();
	}

	public function admin_import()
	{
		$this->set('current_crumb', __('Import', true));
		$this->set('title_for_layout', __('Import', true));
	}

	public function admin_upload()
	{
		if (isset($this->data['MicroTemplates']['submittedfile'])
			&& $this->data['MicroTemplates']['submittedfile']['error'] == 0
			&& is_uploaded_file($this->data['MicroTemplates']['submittedfile']['tmp_name'])) {

			@unlink('./files/' . $this->data['MicroTemplates']['submittedfile']['name']);
			@unlink('./files/micro_templates.xml');
			move_uploaded_file($this->data['MicroTemplates']['submittedfile']['tmp_name'], './files/' . $this->data['MicroTemplates']['submittedfile']['name']);

			$z = new ZipArchive();
			$z->open('./files/' . $this->data['MicroTemplates']['submittedfile']['name']);

			$res = $z->extractTo('./files/');
			$this->copyDir('./files/js', './js', true);
			$this->copyDir('./files/img', './img', true);

			$res = $z->extractTo('./files/', 'micro_templates.xml');

			if ($res) {
				$doc = new DOMDocument();
				if ($doc->load('./files/micro_templates.xml')) {
					$xpath = new DOMXpath($doc);
					$micro_templates = $xpath->query('//micro_templates/micro_template');

					foreach ($micro_templates as $template) {
						$alias = '';
						$tag_name = '';

						foreach ($template->attributes as $attribute) {
							if ('alias' == $attribute->name) {
								$alias = $attribute->value;
							}

							if ('tag_name' == $attribute->name) {
								$tag_name = $attribute->value;
							}
						}

						if ('' == $alias) {
							$this->Session->setFlash(__('MicroTemplates alias is empty.',true));
							@$this->removeDir('./files/js');
							@$this->removeDir('./files/img');
							@unlink('./files/micro_templates.xml');
							@unlink('./files/' . $this->data['MicroTemplates']['submittedfile']['name']);
							$this->redirect('/micro_templates/admin_import/');
						} else {
							$tmpl = $this->MicroTemplate->find('first', array('conditions' => "MicroTemplate.alias = '" . $alias . "'"));

							if (!$tmpl) {
								$tmpl = array();
								$tmpl['MicroTemplate'] = array('id' => null);
								$tmpl['MicroTemplate']['alias'] = $alias;
							}

							$tmpl['MicroTemplate']['tag_name'] = $tag_name;
							$tmpl['MicroTemplate']['template'] = trim($template->nodeValue);

							$this->MicroTemplate->save($tmpl);
						}
					}

					$this->Session->setFlash(__('MicroTemplates has been imported.',true));
					@$this->removeDir('./files/js');
					@$this->removeDir('./files/img');
					@unlink('./files/micro_templates.xml');
					@unlink('./files/' . $this->data['MicroTemplates']['submittedfile']['name']);
					$this->redirect('/micro_templates/admin/');
				} else {
					$this->Session->setFlash(__('Invalid XML file micro_templates.xml.',true));
					@$this->removeDir('./files/js');
					@$this->removeDir('./files/img');
					@unlink('./files/micro_templates.xml');
					@unlink('./files/' . $this->data['MicriTemplates']['submittedfile']['name']);
					$this->redirect('/micro_templates/admin_import/');
				}
			} else {
				$this->Session->setFlash(__('Error extracting micro_templates.xml.',true));
				@$this->removeDir('./files/js');
				@$this->removeDir('./files/img');
				@unlink('./files/micro_templates.xml');
				@unlink('./files/' . $this->data['MicroTemplates']['submittedfile']['name']);
				$this->redirect('/micro_templates/admin_import/');
			}

			$z->close();
			@$this->removeDir('./files/js');
			@$this->removeDir('./files/img');
			@unlink('./files/micro_templates.xml');
			@unlink('./files/' . $this->data['MicroTemplates']['submittedfile']['name']);
			$this->redirect('/micro_templates/admin/');
		} else {
			$this->Session->setFlash(__('Please, select the file for import.',true));
			$this->redirect('/micro_templates/admin_import/');
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
?>