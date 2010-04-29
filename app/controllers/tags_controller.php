<?php
/* -----------------------------------------------------------------------------------------
   VaM Cart
   http://vamcart.com
   http://vamcart.ru
   Copyright 2009-2010 VaM Cart
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class TagsController extends AppController {
	var $name = 'Tags';
	var $uses = null;
	
	function admin_view ($type, $tag)
	{
		$this->set('current_crumb', __('Tag Details', true));
		$this->set('title_for_layout', __('Tag Details', true));
		require_once("../vendors/smarty/vam_plugins/" . $type . "." . $tag . ".php");
		
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
	
	function admin ()
	{
		$this->set('current_crumb', __('Tags Listing', true));
		$this->set('title_for_layout', __('Tags Listing', true));
		$files = array();
		if ($handle = opendir('../vendors/smarty/vam_plugins/')) {
	    	while (false !== ($file = readdir($handle))) 
			{
				$smarty_plugin = explode('.',$file);

				if(($smarty_plugin[0] == 'function') || ($smarty_plugin[0] == 'block'))
				{
					require_once("../vendors/smarty/vam_plugins/".$file);
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
}
?>