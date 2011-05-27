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

class SmartyComponent extends Object 
{
	function beforeFilter ()
	{
	}

    function startup(&$controller)
	{
    }	
 	
	function load_template ($params,$tag)
	{
		if(isset($params['template']))
		{
			
				// Cache the output.
				$cache_name = 'vam_plugin_template_' .  $params['template'];
				$output = Cache::read($cache_name);
				if($output === false)
				{
					ob_start();
		
			App::import('Model', 'MicroTemplate');
				$MicroTemplate =& new MicroTemplate();
			
			$template = $MicroTemplate->find(array('alias' => $params['template']));
			$display_template = $template['MicroTemplate']['template'];
			
			echo $display_template;
		
				// End of cache	
				$output = @ob_get_contents();
				ob_end_clean();	
				Cache::write($cache_name, $output);		
			}
			$display_template = $output;
		}
		else
		{	
			$display_template_function = 'default_template_' . $tag;
			$display_template = $display_template_function();
		}
		
		return $display_template;
	}
	
 	function load_smarty ()
	{
		App::import('Vendor', 'Smarty', array('file' => 'smarty'.DS.'Smarty.class.php'));
		$smarty = new Smarty();
		
		$smarty->plugins_dir = array(
			'../vendors/smarty/plugins',
			'../vendors/smarty/local_plugins',
			'../vendors/smarty/vam_plugins');
		
		return $smarty;
	}
	
	function fetch($str,$assigns = array())
	{
		$smarty = $this->load_smarty();

		foreach($assigns AS $key => $value)
		{
			$smarty->assign($key,$value);
		}
		
		return $smarty->fetch('eval:' . $str, null, null, null, false);
	}
 
	function display($str,$assigns = array())
	{
	    echo $this->fetch($str,$assigns);
	}
}
?>