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
		require_once("../Vendor/smarty/vam_plugins/" . $type . "." . $tag . ".php");
		
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
		if ($handle = opendir('../Vendor/smarty/vam_plugins/')) {
			
		while ($files[] = readdir($handle));
		sort($files);
					
	    	foreach ($files as $file) 
	    	{
				$smarty_plugin = explode('.',$file);

				if(($smarty_plugin[0] == 'function') || ($smarty_plugin[0] == 'block'))
				{
					require_once("../Vendor/smarty/vam_plugins/".$file);
					$default_template_function = 'default_template_' . $smarty_plugin[1];
		
					if(function_exists($default_template_function))
					{
						$smarty_plugin['template'] = 1;
					}				
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
		
		$val = $this->data['AddModule']['submittedfile'];
		
		if ( (!empty( $this->data['AddModule']['submittedfile']['tmp_name']) && $this->data['AddModule']['submittedfile']['tmp_name'] != 'none')) {
			$this->Session->setFlash( __('Module Uploaded', true));		

			$this->destination = '../tmp/modules/';
			$this->filename = $this->data['AddModule']['submittedfile']['name'];
			$this->permissions = '0777';

				if (move_uploaded_file($this->data['AddModule']['submittedfile']['tmp_name'], $this->destination . $this->filename)) {
					chmod($this->destination . $this->filename, $this->permissions);
					App::import('Vendor', 'PclZip', array('file' => 'pclzip'.DS.'zip.php'));
					$this->archive = new PclZip('../tmp/modules/'.$this->filename);
						if ($this->archive->extract(PCLZIP_OPT_PATH,'../..') == 0)
							die(__('Error : Unable to unzip archive', true));
					@unlink($this->destination.$this->filename);
				} else {
							return false;
				}

		} else {
			$this->Session->setFlash( __('Module Not Uploaded', true));
		}		
		
		$this->redirect('/tags/admin/');
	
	}
	
}
?>