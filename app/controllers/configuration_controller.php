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

class ConfigurationController extends AppController {
	var $name = 'Configuration';
	
	function admin_clear_cache ()
	{
		Cache::clear();
		$this->Session->setFlash(__('Cache cleared.',true));
		$this->redirect('/configuration/admin_edit/');
	}
	
	function admin_edit ()
	{
		if(!empty($this->data))
		{
			if(isset($this->params['form']['cancelbutton']))
			{
				$this->redirect('/admin/admin_top/5/');
				die();
			}
						
			foreach($this->data['Configuration'] AS $key => $value)
			{
				$current_config = $this->Configuration->find(array('key' => $key));
				$current_config['Configuration']['value'] = $value;
				$this->Configuration->save($current_config);
			}
			$this->Session->setFlash(__('Record saved.', true));
		}
		
		// Grab all configration values then loop through and set the array key to the database key
		$configuration_values = $this->Configuration->findAll();
		$keyed_config_values = array();
		foreach($configuration_values AS $key => $value)
		{
			$array_key = $value['Configuration']['key'];
			$keyed_config_values[$array_key] = $value['Configuration'];
		}

		$this->set('configuration_values',$keyed_config_values);
		$this->render('','admin');
	}
}
?>