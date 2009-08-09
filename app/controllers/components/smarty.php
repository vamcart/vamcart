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
		
		$smarty->plugins_dir = array('plugins','vam_plugins');
	    require_once $smarty->_get_plugin_filepath('function', 'eval');
		
		return $smarty;
	}
	
	function fetch($str,$assigns = array())
	{
		$smarty = $this->load_smarty();

		foreach($assigns AS $key => $value)
		{
			$smarty->assign($key,$value);
		}
		
	    return smarty_function_eval(array('var' => $str), $smarty);
	}
 
	function display($str,$assigns = array())
	{
	    echo $this->fetch($str,$assigns);
	}
}
?>