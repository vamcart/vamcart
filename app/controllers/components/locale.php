<?php 
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class LocaleComponent extends Object 
{

	function beforeFilter ()
	{
		
	}

    function startup(&$controller)
	{
		$this->controller =& $controller;
    }
	
	function custom_crumb ($format, $language_key, $count = 1)
	{
		$language_format = __('% ' . $format, true);
		if($language_format != '% ' . $format)
			$this->controller->set('current_crumb',sprintf($language_format, __n($language_key,$language_key, $count, true)));
	}

	function set_crumb($action=null,$controller=null)
	{
		if($action == null)
		{
			$action = $this->controller->action;
		}
		
		if($controller == null)
		{
			$controller = $this->controller->name;
		}
		
		// Only return a crumb if the language value is assigned something.
		$language_format = __('% ' . $action, true);
		if($language_format != '% ' . $action)
			return sprintf($language_format, __n($controller,$controller, 1, true));
			
	}
	
	
}
?>