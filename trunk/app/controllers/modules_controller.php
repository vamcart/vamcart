<?php 
/** SMS - Selling Made Simple
 * Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
 * This project's homepage is: http://sellingmadesimple.org
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * BUT withOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
**/

class ModulesController extends AppController {
	var $name = 'Modules';
   
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
				
		$this->render('','admin');
	}
}
?>