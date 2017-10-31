<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
   
class TagsController extends AppController {
	public $name = 'Tags';
	public $uses = null;
	
	public function admin_view ($type, $tag)
	{
		$this->set('current_crumb', __('Tag Details', true));
		$this->set('title_for_layout', __('Tag Details', true));
		require_once("../Catalog/" . $type . "." . $tag . ".php");
		
		// Get information for the help content
		ob_start();
		call_user_func_array('smarty_help_function_'.$tag, array());
		$help_content = @ob_get_contents();
		ob_end_clean();
		
		// Get information for the about content
		ob_start();
		call_user_func_array('smarty_about_function_'.$tag, array());
		$about_content = @ob_get_contents();
		ob_end_clean();		
		
		$this->set('tag', $tag);
		$default_template_function = 'default_template_' . $tag;
	
		if(function_exists($default_template_function))
		{
			$template = $default_template_function();
			$this->set('default_template',$template);
		}
		
		$this->set('current_crumb_info', $tag);
		$this->set('tag_type',$type);
		$this->set('tag_name',$tag);		

		$this->set('help_content',$help_content);
		$this->set('about_content',$about_content);		
		
	}
	
	public function admin ()
	{
		$this->set('current_crumb', __('Tags Listing', true));
		$this->set('title_for_layout', __('Tags Listing', true));
		$files = array();
		if ($handle = opendir('../Catalog/')) {
			
		while ($files[] = readdir($handle));
		sort($files);
					
	    	foreach ($files as $file) 
	    	{
				$smarty_plugin = explode('.',$file);

				if(($smarty_plugin[0] == 'function') || ($smarty_plugin[0] == 'block'))
				{
					require_once("../Catalog/".$file);
					$default_template_function = 'default_template_' . $smarty_plugin[1];
		
					if(function_exists($default_template_function))
					{
						$smarty_plugin['template'] = 1;
					}		
					
		ob_start();
		call_user_func_array('smarty_help_function_'.$smarty_plugin[1], array());
		$about_content = @ob_get_contents();
		ob_end_clean();		

						$smarty_plugin['about'] = $about_content;
									
			        $files[] = $smarty_plugin;				
				}
	    	}
		    closedir($handle);
		}
		$this->set('files',$files);
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
			$this->redirect('/tags/admin/');
			die();
		}
		
		if (isset($this->data['AddModule']['submittedfile'])
			&& $this->data['AddModule']['submittedfile']['error'] == 0
			&& is_uploaded_file($this->data['AddModule']['submittedfile']['tmp_name'])) {

			@unlink(ROOT.'/app/tmp/modules/' . $this->data['AddModule']['submittedfile']['name']);

			if (!is_dir(ROOT.'/app/tmp/modules/tags/')) {
				mkdir(ROOT.'/app/tmp/modules/tags/');
			}
		
			move_uploaded_file($this->data['AddModule']['submittedfile']['tmp_name'], ROOT.'/app/tmp/modules/tags/' . $this->data['AddModule']['submittedfile']['name']);

			$z = new ZipArchive();
			$z->open(ROOT.'/app/tmp/modules/tags/' . $this->data['AddModule']['submittedfile']['name']);

			$res = $z->extractTo(ROOT.'/app/tmp/modules/tags/');
			$this->copyDir(ROOT.'/app/tmp/modules/tags/app/Catalog', ROOT.'/app/Catalog', true);
			$locale_dir = ROOT.'/app/tmp/modules/tags/app/Locale';
			if (file_exists($locale_dir) && is_dir($locale_dir)) $this->copyDir($locale_dir, ROOT.'/app/Locale', true);
						
			$z->close();

			@$this->removeDir(ROOT.'/app/tmp/modules/tags/');
			@unlink(ROOT.'/app/tmp/modules/tags/' . $this->data['Templates']['submittedfile']['name']);
			$this->Session->setFlash( __('Module Uploaded', true));		
			$this->redirect('/tags/admin/');
		} else {
			$this->Session->setFlash(__('Please, select the file for import.',true));
			$this->redirect('/tags/admin_add/');
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
							if ('php' == $ext) {
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