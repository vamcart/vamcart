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

class ModulesController extends AppController {
	var $name = 'Modules';
	var $view = 'Theme';
	var $layout = 'admin';
	var $theme = 'vamshop';
   
	function admin ()
	{
		$this->set('current_crumb', __('Modules Listing', true));
		$path = APP . 'plugins' . DS;
		$module_path = new Folder($path);
		$dirs = $module_path->read();

		$modules = array();
		foreach($dirs[0] AS $dir)
		{
			if(substr($dir,0,7) == 'module_')
			{
				$module = array();
				$module['alias'] = substr($dir,7,strlen($dir)); 
				$module['name'] = Inflector::humanize($module['alias']);
				$module['installed'] = $this->Module->findCount(array('alias' => $module['alias']));
				
				$module['version'] = intval(file_get_contents(APP . 'plugins' . DS . $dir . DS . 'version.txt'));
				
				if($module['installed'] > 0)
				{
					$db_module = $this->Module->find(array('alias' => $module['alias']));
					$module['installed_version'] = $db_module['Module']['version'];
				}
					
				$modules[] = $module;
			}
		}

		
		$this->set('modules',$modules);
				
	}
}
?>