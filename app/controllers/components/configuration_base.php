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

class ConfigurationBaseComponent extends Object 
{


	function beforeFilter ()
	{
	}

    function startup(&$controller)
	{

    }

	function load_configuration ()
	{
		$config_values = Cache::read('sms_config');
		
		if($config_values === false)
		{
			loadModel('Configuration');
				$this->Configuration =& new Configuration();
	
			$configuration_values = $this->Configuration->findAll();

			$config_values = array_combine(Set::extract($configuration_values, '{n}.Configuration.key'),
						 		 Set::extract($configuration_values, '{n}.Configuration.value'));		

			Cache::write('sms_config', $config_values, intval($config_values['CACHE_TIME']));
		}
		
		return $config_values;
		
	}	
}
?>