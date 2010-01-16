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
		$config_values = Cache::read('vam_config');
		
		if($config_values === false)
		{
			App::import('Model', 'Configuration');
				$this->Configuration =& new Configuration();
	
			$configuration_values = $this->Configuration->find('all');

			$config_values = array_combine(Set::extract($configuration_values, '{n}.Configuration.key'),
						 		 Set::extract($configuration_values, '{n}.Configuration.value'));		

			Cache::write('vam_config', $config_values, intval($config_values['CACHE_TIME']));
		}
		
		return $config_values;
		
	}	
}
?>