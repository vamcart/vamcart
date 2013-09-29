<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

class SmartyComponent extends Object
{
	public function beforeFilter () {
	}
	
	public function initialize(Controller $controller) {
	}
    
	public function startup(Controller $controller) {
	}

	public function shutdown(Controller $controller) {
	}
    
	public function beforeRender(Controller $controller){
	}

	public function beforeRedirect(Controller $controller){
	}
	
	public function load_template ($params, $tag)
	{
		if(isset($params['template'])) {
			// Cache the output.
			$cache_name = 'vam_plugin_template_' .  $params['template'];
			$output = Cache::read($cache_name);
			if ($output === false) {
				ob_start();

				App::import('Model', 'MicroTemplate');
				$MicroTemplate =& new MicroTemplate();

				$template = $MicroTemplate->find('first', array('conditions' => array('alias' => $params['template'])));
				$display_template = $template['MicroTemplate']['template'];

				echo $display_template;

				// End of cache
				$output = @ob_get_contents();
				ob_end_clean();
				Cache::write($cache_name, $output);
			}
			$display_template = $output;
		} else {
			$display_template_function = 'default_template_' . $tag;
			$display_template = $display_template_function();
		}

		return $display_template;
	}

	public function load_smarty ()
	{
		App::import('Vendor', 'Smarty', array('file' => 'smarty'.DS.'Smarty.class.php'));
		$smarty = new Smarty();

		$smarty->plugins_dir = array(
			'../Vendor/smarty/plugins',
			'../Vendor/smarty/local_plugins',
			'../Vendor/smarty/vam_plugins'
		);

		$smarty->setCompileDir(CACHE.'/smarty_cache');
		$smarty->setCacheDir(CACHE.'/smarty_templates_c');

		$smarty->setCaching(Smarty::CACHING_LIFETIME_SAVED);

		$smarty->setCacheLifetime(86400);
		
		$smarty->setCompileCheck(false);
				
		$smarty->debugging = true;

		return $smarty;
	}

	public function fetch($str, $assigns = array())
	{
		$smarty = $this->load_smarty();

		foreach($assigns AS $key => $value) {
			$smarty->assign($key, $value);
		}

		return $smarty->fetch('string:' . $str);
	}

	public function display($str, $assigns = array())
	{
		echo $this->fetch($str, $assigns);
	}
}
?>
