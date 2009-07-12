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
				$cache_name = 'sms_plugin_template_' .  $params['template'];
				$output = Cache::read($cache_name);
				if($output === false)
				{
					ob_start();
		
			loadModel('MicroTemplate');
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
		vendor('smarty/Smarty.class');
		$smarty = new Smarty();
		
		$smarty->plugins_dir = array('plugins','sms_plugins');
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