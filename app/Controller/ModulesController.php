<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('Folder', 'Utility');

class ModulesController extends AppController {
	public $name = 'Modules';
   
	public function admin ()
	{
		$this->set('current_crumb', __('Modules Listing', true));
		$this->set('title_for_layout', __('Modules Listing', true));
		$path = APP . 'Plugin' . DS;
		$module_path = new Folder($path);
		$dirs = $module_path->read();

		$modules = array();
		foreach($dirs[0] AS $dir)
		{
			if(substr($dir,0,6) == 'Module')
			{
				$module = array();
				$module['alias'] = strtolower(substr(preg_replace('/([A-Z])/', '_${1}', substr($dir,6,strlen($dir))) , 1));
				$module['name'] = Inflector::humanize($module['alias']);
				$module['installed'] = $this->Module->find('count', array('conditions' => array('alias' => $module['alias'])));
				
				$module['version'] = intval(file_get_contents(APP . 'Plugin' . DS . $dir . DS . 'version.txt'));
				
				if($module['installed'] > 0)
				{
					$db_module = $this->Module->find('first', array('conditions' => array('alias' => $module['alias'])));
					$module['installed_version'] = $db_module['Module']['version'];
				}
					
				$modules[] = $module;
			}
		}

		
		$this->set('modules',$modules);

		// clear Cache::write() items
		Cache::clear();
		// clear core cache
		$cachePaths = array('views', 'persistent', 'models', 'catalog');
		foreach($cachePaths as $config) {
				clearCache(null, $config);
		}	
		
	}

	public function admin_add ()
	{
		$this->set('current_crumb', __('Module Upload', true));
		$this->set('title_for_layout', __('Module Upload', true));
	}

	public function admin_upload ()
	{
		$this->set('current_crumb', __('Module Upload', true));
		$this->set('title_for_layout', __('Module Upload', true));

		// If they pressed cancel
		if(isset($this->data['cancelbutton']))
		{
			$this->redirect('/modules/admin/');
			die();
		}
		
		if (isset($this->data['AddModule']['submittedfile'])
			&& $this->data['AddModule']['submittedfile']['error'] == 0
			&& is_uploaded_file($this->data['AddModule']['submittedfile']['tmp_name'])) {

			@unlink(ROOT.'/app/tmp/modules/' . $this->data['AddModule']['submittedfile']['name']);

			if (!is_dir(ROOT.'/app/tmp/modules/plugins/')) {
				mkdir(ROOT.'/app/tmp/modules/plugins/');
			}
		
			move_uploaded_file($this->data['AddModule']['submittedfile']['tmp_name'], ROOT.'/app/tmp/modules/plugins/' . $this->data['AddModule']['submittedfile']['name']);

			$z = new ZipArchive();
			$z->open(ROOT.'/app/tmp/modules/plugins/' . $this->data['AddModule']['submittedfile']['name']);

			$res = $z->extractTo(ROOT.'/app/tmp/modules/plugins/');
			$this->copyDir(ROOT.'/app/tmp/modules/plugins/app/Plugin', ROOT.'/app/Plugin', true);
			$css_dir = ROOT.'/app/tmp/modules/plugins/app/webroot/css';
			if (file_exists($css_dir) && is_dir($css_dir)) $this->copyDir($css_dir, ROOT.'/app/webroot/css', true);
			$js_dir = ROOT.'/app/tmp/modules/plugins/app/webroot/js';
			if (file_exists($js_dir) && is_dir($js_dir)) $this->copyDir($js_dir, ROOT.'/app/webroot/js', true);
			$images_dir = ROOT.'/app/tmp/modules/plugins/app/webroot/img';
			if (file_exists($images_dir) && is_dir($images_dir)) $this->copyDir($images_dir, ROOT.'/app/webroot/img', true);
			$locale_dir = ROOT.'/app/tmp/modules/plugins/app/Locale';
			if (file_exists($locale_dir) && is_dir($locale_dir)) $this->copyDir($locale_dir, ROOT.'/app/Locale', true);
			
			$z->close();

			@$this->removeDir(ROOT.'/app/tmp/modules/plugins/');
			@unlink(ROOT.'/app/tmp/modules/plugins/' . $this->data['Templates']['submittedfile']['name']);
			$this->Session->setFlash( __('Module Uploaded', true));		
			$this->redirect('/modules/admin/');
		} else {
			$this->Session->setFlash(__('Please, select the file for import.',true));
			$this->redirect('/modules/admin_add/');
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
							//if ('php' == $ext) {
								if (!@copy($path, $dest . '/' . $file)) {
								}
							//}
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